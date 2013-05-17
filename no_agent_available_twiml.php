<?php
include_once("library/Config.php");
//include_once("library/salesforceLocalObject.php");
//$salesforceLocalObject=new SalesForceLocalManager();
//$twilio_variables=$salesforceLocalObject->getTwillioIncomingVariables();
//$salesforceLocalObject->insertCallVariables($twilio_variables);
header('Content-type: text/xml');

$message = basename($_SERVER['SCRIPT_NAME'])." --- ";
foreach($_REQUEST as $key => $value)
{
	$message.= $key." => ".$value." || ";
}
// 
updateData("insert into twilio_debug set message='".$message."' , time_stamp ='".date("d-m-Y H:i:s")."'");

$number=$_REQUEST['From'];

$agent=getOne('SELECT agent_name from available_agents where is_available=1 AND TIMESTAMPDIFF(SECOND,`last_online`,NOW())<5 order by `last_picked_call` ASC,`last_online` DESC');
if($agent===FALSE OR is_null($agent)){
	$expiring_time=$_REQUEST['exp'];
	if(time()<$expiring_time){
		?>
		<Response>
			<Gather action="http://www.gaminride.com/Twilio/twiml/applet/voice/vm/start" timeout="15" numDigits="1">
				<Say voice="woman">Please wait for some time or press 1 to leave voicemail.</Say>
			</Gather>
			<Redirect><?=basename($_SERVER['SCRIPT_NAME'])?>?exp=<?=$expiring_time?></Redirect>
		</Response>
		<? 
	}else{
		?>
		<Response>
			<Redirect>http://www.gaminride.com/Twilio/twiml/applet/voice/local/start</Redirect>
		</Response>
		<?
	}
}else{
	updateData("Update available_agents set `last_picked_call`=NOW() where agent_name='".$agent."'");
	updateData("insert into twilio_debug set message='".basename($_SERVER['SCRIPT_NAME'])."_02T ---- ".$caller.'--'.$agent."' , time_stamp ='".date("d-m-Y H:i:s")."'");
	?>
	<Response>
		<Dial action="update_caller_entry.php" method="GET" record="true"><Client><?=$agent?></Client></Dial>
	</Response>
	<? 
}
updateData("Delete from active_calls where phone_number like '%".substr($number,-10)."%'");
updateData("insert into active_calls set call_sid='".$_REQUEST['CallSid']."', phone_number='".$number."', is_active='1'");
?> 