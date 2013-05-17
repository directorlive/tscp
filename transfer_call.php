<?
	require_once('library/Config.php');
	header('Content-type: text/xml'); 
	$message = "transfer_call.php ---- ";
	foreach($_REQUEST as $key => $value)
	{
		$message.= $key." => ".$value." || ";
	}

	updateData("insert into twilio_debug set message='".$message."' , time_stamp ='".date("d-m-Y H:i:s")."'");

	$transfering_to=$_REQUEST['transfering_to'];
	$transfering_to="+1".substr($transfering_to,-10);
?>
<Response>
	<Say voice="woman">Your call is being transfered!</Say>
	<Say voice="woman">Please wait for some time!</Say>
    <Dial><Number><?= $transfering_to ?></Number></Dial>
</Response>