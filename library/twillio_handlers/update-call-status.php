<?php
require_once("../Config.php");

$callFrom = $_REQUEST['From'];
$callTo = $_REQUEST['To'];
$callSid = $_REQUEST['CallSid'];
$callStatus = trim($_REQUEST['CallStatus']);
$callId = $_REQUEST['call_id'];

$callToSlim = substr($callTo,-10);

if($callStatus == 'completed')
{
	$qry1 = "select user_id from users where user_phone like '".$callToSlim."'";
	$attendedBy = getOne($qry1);
	
	$updateQry= "update incomming_calls set 
					is_active = 0, 
					attended_by = '".$attendedBy."'
				 where call_id = '".$callId."'";
	updateData($updateQry);
	//updateData("insert into twilio_logs set title = 'Qry Dump', message = 'Start: \n ".addslashes($qry1)." \r\n ".addslashes($updateQry)."'");
}


?>