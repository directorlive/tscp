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
$client = new Services_Twilio($twilio_creds['sid'], $twilio_creds['auth_token']);

$call_sid=$_SESSION['hold_call_sid'];
//echo('Select call_sid from active_calls where number like \'%%'.$_REQUEST['call_to_put_on_hold'].'%\'');exit;
//echo $_REQUEST['call_to_put_on_hold'].$call_sid;exit;
// Get an object from its sid. If you do not have a sid,
// check out the list resource examples on this page
//echo $call_sid;exit;
$call = $client->account->calls->get($call_sid);
$call->update(array(
        "Url" => "http://satnyx.in/tscp/resume.php"
    ));
echo $call->to;