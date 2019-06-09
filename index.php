<?php 
session_start();
ob_start();
define('DIR_APPLICATION', str_replace('\'', '/', realpath(dirname(__FILE__))) . '/');
include(DIR_APPLICATION."config.php");
$msg = 'none';
$sql = '';

if(isset($_POST['username']) && $_POST['username'] != '' && isset($_POST['password']) && $_POST['password'] != ''){
	if($_POST['ddlLoginType'] == '1'){
		$sql= @mysqli_query($link,"SELECT * FROM `manager`  WHERE Email = '".make_safe($_POST['username'])."' and Password = '".make_safe($_POST['password'])."'");
	}
	
	if($_POST['ddlLoginType'] == '2'){
		$sql= mysqli_query($link,"SELECT * FROM `login`  WHERE UserName = '".make_safe($_POST['username'])."' and Password = '".make_safe($_POST['password'])."'");
	}
	
	if($row = mysqli_fetch_array($sql)){
		//here success
		if($_POST['ddlLoginType'] == '1'||$_POST['ddlLoginType'] == '2' ){
			
			$_SESSION['objLogin'] = $row; 
		}
		
		$_SESSION['login_type'] = $_POST['ddlLoginType'];
	 
		if($_POST['ddlLoginType'] == '1'){
			header("Location: dashboard.php");
			die();
		}
		else if($_POST['ddlLoginType'] == '2'){
			header("Location: e_dashboard.php");
			die();
		}
		
	}else{
		$msg = 'block';
	}
	
}

function make_safe($variable) 
{
   $variable = trim($variable);
   return $variable; 
}
?>
<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Online-Based Rotaring System</title>
<!-- BOOTSTRAP STYLES-->
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<!-- FONTAWESOME STYLES-->
<link href="assets/css/font-awesome.css" rel="stylesheet" />
<!-- CUSTOM STYLES-->
<link href="assets/css/custom.css" rel="stylesheet" />
<!-- GOOGLE FONTS-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
</head>
<body>
<div class="container"> <br/>
  <br/>
  <br/>
  <div class="row text-center ">
    <div class="col-md-12"><br/>
      <span style="font-size:35px;font-weight:bold;color:red;">FFWS</span> <span style="font-size:18px;">Online-Based Rotering System</span></div>
  </div>
  <br/>
  <div class="row ">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
      <div style="margin-bottom:8px;padding-top:2px;width:100%;height:25px;background:#E52740;color:#fff; display:<?php echo $msg; ?>" align="center">Wrong login information</div>
      <div class="panel panel-default" id="loginBox">
        <div class="panel-heading"> <strong> Enter Login Details </strong> </div>
        <div class="panel-body">
          <form onSubmit="return validationForm();" role="form" id="form" method="post">
            <br />
            <div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
              <input type="text" name="username" id="username" class="form-control" placeholder="Your Email" />
            </div>
            <div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
              <input type="password" name="password" id="password" class="form-control"  placeholder="Your Password" />
            </div>
            <div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
              <select name="ddlLoginType" onChange="mewhat(this.value);" id="ddlLoginType" class="form-control">
                <option value="">--Select Type--</option>
                <option value="1">Manager</option>
                <option value="2">Employee</option>
               
              </select>
            </div>
           
            <div class="form-group">
              <label class="checkbox-inline"> </label>
              <span class="pull-right"> <a href="<?php echo WEB_URL;?>forgetpassword.php" >Forget password ? </a> </span> </div>
            <hr />
            <div align="center">
              <button style="width:100%;" type="submit" id="login" class="btn btn-primary"><i class="fa fa-user"  ></i>&nbsp;Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function validationForm(){
	if($("#username").val() == ''){
		alert("Email Required !!!");
		$("#username").focus();
		return false;
	}
	
	else if($("#password").val() == ''){
		alert("Password Required !!!");
		$("#password").focus();
		return false;
	}
	else if($("#ddlLoginType").val() == ''){
		alert("Select User Type !!!");
		return false;
	}
	else{
		return true;
	}
}
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function mewhat(val){
	if(val != ''){
		if(val == '5'){
			$("#x_branch").show();
		}
		else{
			$("#x_branch").hide();
		}
	}
	else{
		$("#x_branch").hide();
	}
}
</script>
</body>
</html>
