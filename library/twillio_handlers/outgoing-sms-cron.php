<?  //echo dirname(__FILE__);
	require_once(dirname(__FILE__) ."/../Config.php");
	require_once(dirname(__FILE__) ."/../customvbx.class.php");
	
	$callArray = getData("select * from incoming_sms where is_active = '1' and time_to_reply > '".$timeAfter."' ");
	
	$timeNow = time();
	echo $timeAfter = time() + (1*60);
	echo "<br />";
	
	if(sizeof($callArray) == 0)
	{
		echo "No Active calls";
	}
	
	for($i=0;$i<sizeof($callArray);$i++)
	{
		$outNumber = $callArray[$i]['sms_from'];
		$inNumber = $callArray[$i]['sms_to'];
		$callId = $callArray[$i]['sms_id'];
		
		$replyText = getOne("select text_message from phone_numbers where phone_number like '%".$inNumber."%'");
		
		$twiObj = new TwilioExt();
		$twiCli = new Services_Twilio($twiObj->accountSid, $twiObj->authToken);

		
		$options = array() ; 
		$smsStat = $twiCli->account->sms_messages->create($inNumber, $outNumber, $replyText); 
		
		//echo $callArray[$i]['time_to_reply']." || ".$callArray[$i]['sms_message']."<br />";
		
		updateData("update incoming_sms set sms_status = 'replied' where sms_id = '".$callId."'");		
	}
	//updateData("insert into twilio_logs set title = 'Cron Status - ".date('Y-m-d H:i:s')."', message = '$i Attempts made'");
?>