<?php
	session_start();
	set_time_limit(0);
// Download/Install the PHP helper library from twilio.com/docs/libraries.

// This line loads the library
		$recall_time=time()+30;
require_once 'library/twilio/Twilio.php';
require_once('library/Config.php');
require_once('library/commonFunctions.php');

$twilio_creds=getTwlioCreds();
// Your Account Sid and Auth Token from twilio.com/user/account
$client = new Services_Twilio($twilio_creds['sid'], $twilio_creds['auth_token']);
$number=$_REQUEST['number'];
if(strlen($number)===11){
	$number="+".$number;
}else{
	$number="+".$number;
}
//echo $number;exit;
// Loop over the list of calls and echo a property for each one
while(time()<$recall_time){
	foreach ($client->account->calls->getIterator(0, 50, array("Status" => "in-progress","To" => $number))as $call){
		//require_once('library/Config.php');
		updateData("Delete from active_calls where phone_number like '%".substr($number,-10)."%'");
		updateData("insert into active_calls set call_sid='".$call->sid."', phone_number='".$number."', is_active='1'");
		echo '{"got_it":true,"call_sid":"'.$call->sid.'"}';exit;
	}
}
echo "recall";exit;