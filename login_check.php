<?

if((isset($_POST['username'])) && (trim($_POST['username']) != ""))
{
	require_once('library/loginObject.php');
	$inpUsername = $_POST['username'];
	$inpPassword = $_POST['password'];	
	
	if(checkLogin($inpUsername,$inpPassword))
	{
		session_start();
		require_once('library/salesforce_auto_login.php');
		setUserDetails($inpUsername);
		header("Location: home.php");
		exit;
	}
	else
	{
		$notification = "Username & Password Incorrect";
	}
	
}

?>