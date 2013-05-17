<?php
//require_once('../Cron_Config.php');
require_once('rest_functions.php');
//require_once('../salesforceLocalObject.php');
//$salesforceObject=new SalesForceLocalManager();
function is_contact_exist($Id){
	$cnt=getOne("Select count(`Id`) from salesforce_contacts where Id='".$Id."'");
	if(intval($cnt)>0){
		return true;
	}else{
		return false;
	}
}
$updates_json=get_changes_in_contacts();

$response = json_decode($updates_json, true);
//print_r($response);
if($response){
	$total_size = $response['totalSize'];
	
	if(intval($total_size)>0){
		$query ="";
		//echo "$ins_Leads <br/>";
		$total_size = $response['totalSize'];
		
		//echo "$total_size record(s) returned<br/><br/>";
		foreach ((array) $response['records'] as $record) {
			$query="Id='".addslashes($record['Id'])."', Email='".addslashes($record['Email'])."', LeadSource='".addslashes($record['LeadSource'])."', FirstName='".addslashes($record['FirstName'])."', LastName='".addslashes($record['LastName'])."', MobilePhone='".addslashes($record['MobilePhone'])."', Phone='".addslashes($record['Phone'])."'";
			if(is_contact_exist($record['Id'])){
				$query ="Update salesforce_contacts set ".$query." Where Id='".$record['Id']."'";
			}else{
				$query ="Insert into salesforce_contacts set ".$query;
			}
			updateData($query);
//			echo($query);
			unset($query);
		}
	//	$ins_Leads=substr($ins_Leads,0,strlen($ins_Leads)-1);
		
		//echo "$total_size record(s) returned<br/><br/>";
		/*foreach ((array) $response['records'] as $record) {
			echo $record['Id'] . ", " . $record['Name'] . "<br/>";
		}*/
	}
}