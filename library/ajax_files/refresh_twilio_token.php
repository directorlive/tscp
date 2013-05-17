<?
	session_start();
	require_once '../twilio/Twilio/Capability.php';
	require_once '../Config.php';
	require_once '../commonFunctions.php';
	$twilio_creds=getTwlioCreds();
	$token = new Services_Twilio_Capability($twilio_creds['sid'], $twilio_creds['auth_token']);
	$token->allowClientOutgoing($twilio_creds['app_sid']);
	$token->allowClientIncoming("mfalgares");
	echo $token->generateToken();

?>
