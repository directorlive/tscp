<? session_start();
	require_once('library/salesforceLocalObject.php');
	$salesforceLocalObject=new SalesForceLocalManager();
	$message = "update_caller_entry.php ---- CALLBACK==> ";
	foreach($_REQUEST as $key => $value)
	{
		$message.= $key." => ".$value." || ";
	}
	$number='';
	updateData("insert into twilio_debug set message='".$message."' , time_stamp ='".date("d-m-Y H:i:s")."'");
	$dataArray=array();
	$dataArray['call_sid']=$_REQUEST['DialCallSid'];
	$dataArray['recording_url']=$_REQUEST['RecordingUrl'];
	$dataArray['call_duration']=$_REQUEST['DialCallDuration'];
	//$dataArray['is_active']='0';
	if(isset($_REQUEST['call_log_id'])){
		$dataArray['call_id']=$_REQUEST['call_log_id'];
		$dataArray['call_from']=$_REQUEST['From'];
		$number=$_REQUEST['To'];
		$salesforceLocalObject->updateCallVariablesById($dataArray);
	}else{
		$number=$_REQUEST['From'];
		$salesforceLocalObject->updateCallVariablesByCallId($dataArray);
	}

	$salesforceLocalObject->syncCalls();

	$number=substr($number,-10);
//	updateData('DELETE FROM `calls_on_hold` WHERE `phone_number` like \'%%'.$number.'%\'');
	
	updateData("Delete from active_calls where call_sid='".$_REQUEST['CallSid']."'");
	header("content-type:application/xml");
?>
<Response></Response>