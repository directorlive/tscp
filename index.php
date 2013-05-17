<? $notification = "";
include_once("login_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>

<link href="css/login-box.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function submitForm()
{	
	var uName = document.getElementById('username').value;
	var pWord = document.getElementById('password').value;
	
	if(uName == "" || pWord == "")
	{
		alert("Please enter a Username and Password");
	}
	else
	{
		document.getElementById('loginForm').submit();
	}
	
	
}

function submitenter(myfield,e)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	
	if (keycode == 13)
	   {
	   submitForm();
	   return false;
	   }
	else
	   return true;
}
</script>

</head>

<body>


<div>


<!--<div id="login-box">
<form name="loginForm" id="loginForm" action="" method="post">
<H2>Login</H2>
Please enter your username & password to Login.

<br />
<br />
<div id="login-box-name" style="margin-top:20px;">Username:</div><div id="login-box-field" style="margin-top:20px;"><input name="username" id="username" class="form-login" title="Username" value="" size="30" maxlength="2048" /></div>
<div id="login-box-name">Password:</div><div id="login-box-field"><input name="password" type="password" class="form-login" title="Password" id="password" value="" size="30" maxlength="2048"  onKeyPress="return submitenter(this,event)" /></div>
<br />
<br />
<br />
<a href="javascript:submitForm()"><img src="images/login-btn.png" width="103" height="42" style="margin-left:90px;" /></a>

</form>
</div>

</div>-->
<section class="container">
    <div class="login">
      <h1>Login to TSCP</h1>
      <div style="color:#900; padding-left:70px" ><?=$notification?></div>
     <form name="loginForm" id="loginForm" action="" method="post">
        <p><input name="username" id="username" type="text" name="login" value="" placeholder="Username or Email"></p>
        <p><input type="password" name="password" id="password" value="" placeholder="Password"></p>
        <p><a href="http://clientsupport.twilio.com/" target="_blank">Check Browser Compability with Twilio</a></p>
        <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p>
        <p class="submit"><input type="submit" name="commit" value="Login"></p>
      </form>
    </div>

    <div class="login-help">
      <p>Forgot your password? <a href="#">Click here to reset it</a>.</p>
    </div>
  </section>
</body>
</html>