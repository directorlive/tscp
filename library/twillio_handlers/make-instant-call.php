<?
	require_once(dirname(__FILE__) ."/../Config.php");
	require_once(dirname(__FILE__) ."/../customvbx.class.php");
	$CallSid = trim($_REQUEST['CallSid']);
	
	
	$callArray = getData("select * from incomming_calls where is_active = '1' and call_sid = '".$CallSid."'");
	
	for($i=0;$i<sizeof($callArray);$i++)
	{
		$outNumber = $callArray[$i]['call_from'];
		$inNumber = $callArray[$i]['call_to'];
		$callId = $callArray[$i]['call_id'];
		
		$inCallEmployeeId = getOne("select user_id from schedule where ph_id = (select ph_id from phone_numbers where phone_number = '".$inNumber."')");
		$inCallEmployee = getOne("select user_phone from users where user_id = '".$inCallEmployeeId."'");
		
		$twiObj = new TwilioExt();
		$twiCli = new Services_Twilio($twiObj->accountSid, $twiObj->authToken);

		//$options = array("StatusCallback" => SITEURL."library/IVRS/update-call-status.php?call_id=".$callId) ; 
		$options = array() ; 
		$call = $twiCli->account->calls->create($inNumber, $inCallEmployee,  SITEURL.'library/IVRS/make-call.php?call_id='.$callId ,$options); 
		
		updateData("update incomming_calls set dial_attempts = (dial_attempts + 1) where call_id = '".$callId."'");		
	}

?>