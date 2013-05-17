<?
require_once("ivrs_config.php");

$AccountSid = $_REQUEST['AccountSid'];
$SmsSid = $_REQUEST['SmsSid'];
$Body = $_REQUEST['Body'];
$To = $_REQUEST['To'];
$ToCountry = $_REQUEST['ToCountry'];
$ToState = $_REQUEST['ToState'];
$ToCity = $_REQUEST['ToCity'];
$ToZip = $_REQUEST['ToZip'];

$From = $_REQUEST['From'];
$FromState = $_REQUEST['FromState'];
$FromCountry = $_REQUEST['FromCountry'];
$FromCity = $_REQUEST['FromCity'];
$SmsStatus = $_REQUEST['SmsStatus'];
$FromZip = $_REQUEST['FromZip'];

$time_to_reply = 0;
/*if(is_numeric($Body))
{
	$extraTime = ($Body * 60 );
	$time_to_reply = time() + $extraTime;
	echo $appExists = getOne("Select count(*) from incoming_sms where is_active = '1' and sms_from = '".$From."'");
	if((int)$appExists >= 1)
	{
		updateData("update incoming_sms set time_to_reply = '".$time_to_reply."', sms_message = sms_message + '".$Body."' where sms_from = '".$From."'");
		
	}
	else
	{
		$insertQry = "insert into incoming_sms set
					sms_from = '".addslashes($From)."',
					sms_to = '".addslashes($To)."',
					sms_time = '".time()."',
					sms_message	 = '".addslashes($Body)."',
					is_active = '1',
					sms_sid = '".addslashes($SmsSid)."',
					from_state = '".addslashes($FromState)."',
					from_country = '".addslashes($FromCountry)."',
					from_zip = '".addslashes($FromZip)."',
					sms_status = '".addslashes($SmsStatus)."',
					time_to_reply = '".$time_to_reply."'
				";
		updateData($insertQry);
	}

}
else if(trim($Body) == "FINISHED")
{
	$updateQry = "update incoming_sms set sms_status = 'Finished', is_active = '0' where sms_from = '".$From."'";
	updateData($updateQry);
}
*/
?>