<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
}

include_once('DAL.php');
require_once('commonObject.php');

$host = "localhost";
$user = "satnyxin_tscp";
$pass = 'EU~ux;C7Qsn$';
$database = "satnyxin_tscp";

mysql_connect($host,$user,$pass,TRUE) or die("could not connect");
mysql_select_db($database) or die("could not select database".$database);


?>