<?php
include_once("library/Config.php");
//include_once("library/salesforceLocalObject.php");
//$salesforceLocalObject=new SalesForceLocalManager();
//$twilio_variables=$salesforceLocalObject->getTwillioIncomingVariables();
//$salesforceLocalObject->insertCallVariables($twilio_variables);
header('Content-type: text/xml');

$message = "dial_number.php --- ";
$number= "";
foreach($_REQUEST as $key => $value)
{
	$message.= $key." => ".$value." || ";
}
// 
updateData("insert into twilio_debug set message='".$message."' , time_stamp ='".date("d-m-Y H:i:s")."'");
$my_phone_numbers=array('+14247723149','+12672448080','+12679156075');

if(isset($_REQUEST['To']) && in_array($_REQUEST['To'],$my_phone_numbers))
//<Dial action="update_caller_entry.php" method="GET" record="true"><Client>mfalgares</Client></Dial>
{ 
/*<Response> 
	<Dial>
		<Conference startConferenceOnEnter='false' waitUrl='hold.mp3'>Waiting Room</Conference>
	</Dial>
</Response>
<Response>
	<Dial>
		<Conference beep="false" waitUrl='tw_conference.php'>
			Customer Waiting Room
		</Conference>
	</Dial>
</Response>
*/

	$number=$_REQUEST['From'];
	$number_array=array($number);
	array_push($number_array,'('.substr($number,-10,3).') '.substr($number,-7,3).'-'.substr($number,-4)); //(862) 220-8402
	array_push($number_array,'('.substr($number,-10,3).')'.substr($number,-7,3).'-'.substr($number,-4)); //(862)220-8402
	array_push($number_array,'('.substr($number,-10,3).')'.substr($number,-7,3).' '.substr($number,-4)); //(862)220 8402
	array_push($number_array,'('.substr($number,-10,3).') '.substr($number,-7,3).' '.substr($number,-4)); //(862) 220 8402
	array_push($number_array,'('.substr($number,-10,3).') '.substr($number,-7,3).substr($number,-4)); //(862) 2208402
	array_push($number_array,substr($number,-10,3).'-'.substr($number,-7,3).'-'.substr($number,-4)); //862-220-8402
	array_push($number_array,substr($number,-10,3).'-'.substr($number,-7,3).substr($number,-4)); //862-2208402
	array_push($number_array,substr($number,-10,3).'-'.substr($number,-7,3).' '.substr($number,-4)); //862-220 8402
	array_push($number_array,substr($number,-10,3).' '.substr($number,-7,3).' '.substr($number,-4)); //862 220 8402
	array_push($number_array,substr($number,-10,3).substr($number,-7,3).'-'.substr($number,-4)); //862220-8402
	array_push($number_array,substr($number,-10,3).' '.substr($number,-7,3).substr($number,-4)); //862 2208402
	array_push($number_array,substr($number,-10,3).' '.substr($number,-7,3).'-'.substr($number,-4)); //862 220-8402
	if(strlen($number)>10){
		array_push($number_array,substr($number,-11,4).'-'.substr($number,-7,3).'-'.substr($number,-4)); //7862-220-8402
		array_push($number_array,substr($number,-10));
	}
	
	$query="SELECT CONCAT(FirstName,' ',LastName) from salesforce_leads where Phone!='' AND (";
	foreach($number_array as $number){
		$query.="Phone = '".$number."' OR ";
	}
	$query.="Phone like '%".substr($number_array[0],-10)."%') order by `Id` DESC";
	//echo $query;exit;
	$caller=getOne($query);

	$agent=getOne('SELECT agent_name from available_agents where is_available=1 AND TIMESTAMPDIFF(SECOND,`last_online`,NOW())<5 order by `last_picked_call` ASC,`last_online` DESC');
	if($agent===FALSE OR is_null($agent)){
		$expiring_time=time()+300;
		//No agent available
		?>
		<Response>
			<Say voice="woman">Hello, <?= $caller?$caller:"" ?></Say>
			<Say voice="woman">None of our agent is available right now.</Say>
            <Gather action="http://www.gaminride.com/Twilio/twiml/applet/voice/vm/start" timeout="15" numDigits="1">
                <Say voice="woman">Please wait for some time or press 1 to leave voicemail.</Say>
            </Gather>
			<Redirect>no_agent_available_twiml.php?exp=<?=$expiring_time?></Redirect>
		</Response>
		<? 
	}else{
		updateData("Update available_agents set `last_picked_call`=NOW() where agent_name='".$agent."'");
		updateData("insert into twilio_debug set message='dial_number_02T ---- ".$caller.'--'.$agent."' , time_stamp ='".date("d-m-Y H:i:s")."'");
		?>
		<Response>
			<Say voice="woman">Hello, <?= $caller?$caller:"" ?></Say>
			<Dial action="update_caller_entry.php" method="GET" record="true"><Client><?=$agent?></Client></Dial>
		</Response>
		<? 
	}
} else if(isset($_REQUEST['To']) && $_REQUEST['To']==='' && isset($_REQUEST['tocall']) && $_REQUEST['tocall']!==''){
	$number=$_REQUEST['tocall'];
?>
<Response>
	<Dial action="update_caller_entry.php<? if(isset($_REQUEST['call_log_id'])){echo "?call_log_id=".$_REQUEST['call_log_id'];} ?>" method="GET" record="true" callerId="+14247723149"><?php echo htmlspecialchars($_REQUEST["tocall"]); ?></Dial>
</Response>
<?php }
updateData("Delete from active_calls where phone_number like '%".substr($number,-10)."%'");
updateData("insert into active_calls set call_sid='".$_REQUEST['CallSid']."', phone_number='".$number."', is_active='1'");
?> 