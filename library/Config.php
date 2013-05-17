<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
}

include_once('DAL.php');
require_once('commonObject.php');

$host = "";
$user = "";
$pass = "";
$database = "";


if($_SERVER['HTTP_HOST']=='localhost')
{
	$host="localhost";
	$user="root";
	$pass="";
	$database="tscp";
}else if(($_SERVER['HTTP_HOST']=='app-server') || ($_SERVER['HTTP_HOST']=='10.20.30.40')){
	$host="localhost";
	$user="root";
	$pass="sat_dev_321";
	$database="tscp";
}else if(($_SERVER['HTTP_HOST']=='www.satnyx.in') ||($_SERVER['HTTP_HOST']=='satnyx.in') ||($_SERVER['HTTP_HOST']=='http://satnyx.in') ){	
	
	$host="localhost";
	$user="satnyxin_tscp";
	$pass="EU~ux;C7Qsn$";
	$database="satnyxin_tscp";
}else{
	$host="localhost";
	$user="root";
	$pass="sat_dev_321";
	$database="tscp";
}
if(!isset($db_connection) || !mysql_ping($db_connection)){
	$db_connection=mysql_connect($host,$user,$pass,TRUE) or die("could not connect");
	mysql_select_db($database) or die("could not select database".$database);
}


?>