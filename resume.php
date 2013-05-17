<?php
	include_once("library/Config.php");
	header('Content-type: text/xml');


	$message = "resume.php ---- ";
	foreach($_REQUEST as $key => $value)
	{
		$message.= $key." => ".$value." || ";
	}

	updateData("insert into twilio_debug set message='".$message."' , time_stamp ='".date("d-m-Y H:i:s")."'");
	if(strpos($_REQUEST['From'],'4247723149')===FALSE){
		$number=substr($_REQUEST['From'],-10);
	}else{
		$number=substr($_REQUEST['To'],-10);
	}
	
	updateData("Delete from active_calls where phone_number like '%".$number."%'");
	updateData("insert into active_calls set call_sid='".$_REQUEST['CallSid']."', phone_number='".$number."', is_active='1'");

	$number=substr($number,-10);
	$agent=getOne("Select agent_name FROM `calls_on_hold` WHERE `phone_number` like '%".$number."%'");
	updateData("DELETE FROM `calls_on_hold` WHERE `phone_number` like '%".$number."%'");
	
?>
<Response>
	<Dial action="update_caller_entry.php" method="GET" record="true"><Client><?=$agent?></Client></Dial>
</Response>