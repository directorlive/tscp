<?php
include_once("library/Config.php");
//include_once("library/salesforceLocalObject.php");
//$salesforceLocalObject=new SalesForceLocalManager();
//$twilio_variables=$salesforceLocalObject->getTwillioIncomingVariables();
//$salesforceLocalObject->insertCallVariables($twilio_variables);
header('Content-type: text/xml');

$message = "dial_number2.php --- ";
foreach($_REQUEST as $key => $value)
{
	$message.= $key." => ".$value." || ";
}
// 
updateData("insert into twilio_debug set message='".$message."' , time_stamp ='".date("d-m-Y H:i:s")."'");
?>