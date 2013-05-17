<?php
//	echo $function;exit;
	switch($function)
		{
			case "updateSettings":
				$twilio_sid = $_REQUEST['twilio_sid'];
				$twilio_auth_token = $_REQUEST['twilio_auth_token'];
				$twilio_app_sid = $_REQUEST['twilio_app_sid'];
				$salesforce_uname = $_REQUEST['salesforce_uname'];
				$salesforce_pass = $_REQUEST['salesforce_pass'];
				$salesforce_security_token = $_REQUEST['salesforce_security_token'];
				$salesforce_client_id = $_REQUEST['salesforce_client_id'];
				$salesforce_client_secret = $_REQUEST['salesforce_client_secret'];
				//print_r($_REQUEST); exit;
				$notification = updateSettings($twilio_sid,$twilio_auth_token,$twilio_app_sid,$salesforce_uname,$salesforce_pass,$salesforce_security_token,$salesforce_client_id,$salesforce_client_secret);
			break;
		}
?>