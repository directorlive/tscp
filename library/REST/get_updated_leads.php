<?php
require_once('rest_functions.php');
function is_lead_exist($Id){
	$cnt=getOne("Select count(`Id`) from salesforce_leads where Id='".$Id."'");
	if(intval($cnt)>0){
		return true;
	}else{
		return false;
	}
}
$updates_json=get_changes_in_leads();

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
			$query="Id='".addslashes($record['Id'])."', Email='".addslashes($record['Email'])."', LeadSource='".addslashes($record['LeadSource'])."', FirstName='".addslashes($record['FirstName'])."', LastName='".addslashes($record['LastName'])."', Rating='".addslashes($record['Rating'])."', Title='".addslashes($record['Title'])."', Phone='".addslashes($record['Phone'])."'";
			if(is_lead_exist($record['Id'])){
				$query ="Update salesforce_leads set ".$query." Where Id='".$record['Id']."'";
			}else{
				$query ="Insert into salesforce_leads set ".$query;
			}
			updateData($query);
			unset($query);
		}
	//	$ins_Leads=substr($ins_Leads,0,strlen($ins_Leads)-1);
		
		//echo "$total_size record(s) returned<br/><br/>";
		/*foreach ((array) $response['records'] as $record) {
			echo $record['Id'] . ", " . $record['Name'] . "<br/>";
		}*/
	}
}