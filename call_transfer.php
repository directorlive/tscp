<?php
session_start();
// Download/Install the PHP helper library from twilio.com/docs/libraries.
// This line loads the library
include 'library/twilio/Twilio.php';
//require('/path/to/twilio-php/Services/Twilio.php');
require_once('library/Config.php');
require_once('library/commonFunctions.php');
$twilio_creds=getTwlioCreds();
// Your Account Sid and Auth Token from twilio.com/user/account
	$message = "call_transfer.php ---- ";
	foreach($_REQUEST as $key => $value)
	{
		$message.= $key." => ".$value." || ";
	}

	updateData("insert into twilio_debug set message='".$message."' , time_stamp ='".date("d-m-Y H:i:s")."'");
$client = new Services_Twilio($twilio_creds['sid'], $twilio_creds['auth_token']);
$call_to_transfer=substr($_REQUEST['call_to_transfer'],-10);
$query="SELECT `call_sid` from `active_calls` where `phone_number` like '%{$call_to_transfer}%'";
$call_sid=getOne($query);
//echo('Select call_sid from active_calls where number like \'%%'.$_REQUEST['call_to_put_on_hold'].'%\'');exit;
//echo $_REQUEST['call_to_put_on_hold'].$call_sid;exit;
// Get an object from its sid. If you do not have a sid,
// check out the list resource examples on this page

//$_SESSION['hold_call_sid']=$call_sid;
//updateData('DELETE FROM `calls_on_hold` WHERE `phone_number` like \'%%'.$_REQUEST['call_to_put_on_hold'].'%\'');
//updateData("INSERT INTO `calls_on_hold`(`phone_number`, `agent_name`) VALUES ('".$_REQUEST['call_to_put_on_hold']."','".$_SESSION['user_name']."')");
$call = $client->account->calls->get($call_sid);
$call->update(array(
        "Url" => "http://satnyx.in/tscp/transfer_call.php?transfering_to=".$_REQUEST['transfering_to']
    ));
echo $call->to;