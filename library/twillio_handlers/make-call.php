<? require_once("../Config.php");
$call_id = $_REQUEST['call_id'];
$qry1 = "select recording_url from incomming_calls where call_id = '".$call_id."'";
$recUrl = getOne($qry1);

$incommingNumber = getOne("select call_to from incomming_calls where call_id = '".$call_id."' ");
$voiceFileEmp = getOne("select voice_file_e from phone_numbers where phone_number = '".$incommingNumber."' ");

?>
<Response>
	<? if(trim($voiceFileEmp) != "" ) { ?>
    <Play><?=SITEURL.$voiceFileEmp?></Play>
    <? } else { ?>
	<Say> You Have a Message from VBX Scheduler.</Say>
    <? } ?>
     <Gather action="<?=SITEURL.'library/IVRS/handle-employee-input.php?call_id='.$call_id?>" numDigits="4">
        <Say>Please enter your password to listen to the message.</Say>
    </Gather>
</Response>