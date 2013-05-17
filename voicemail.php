<?php
include_once("library/Config.php");
//include_once("library/salesforceLocalObject.php");
//$salesforceLocalObject=new SalesForceLocalManager();
//$twilio_variables=$salesforceLocalObject->getTwillioIncomingVariables();
//$salesforceLocalObject->insertCallVariables($twilio_variables);
header('Content-type: text/xml');

$message = basename($_SERVER['SCRIPT_NAME'])." --- ";
foreach($_REQUEST as $key => $value)
{
	$message.= $key." => ".$value." || ";
}
// 
updateData("insert into twilio_debug set message='".$message."' , time_stamp ='".date("d-m-Y H:i:s")."'");

$number=$_REQUEST['From'];
	?>
	<Response>
		<Say voice="woman">Leave your message after beep.</Say>
        <Hangup/>
	</Response>