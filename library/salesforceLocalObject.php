<?
//Manthan Tripathi - 29/03/2012
//for local salesforce management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');
require_once('REST/rest_functions.php');
class SalesForceLocalManager extends commonObject
{
	function get_all_contacts(){
		$getQuery = "SELECT Id,CONCAT(FirstName,' ',LastName) as Name,Email,LeadSource,Phone,MobilePhone from salesforce_contacts";
		$all_contacts = getData($getQuery);
		return $all_contacts;
	}
		
	function get_all_leads(){
		$getQuery = "SELECT Id,CONCAT(FirstName,' ',LastName) as Name,Title,Email,LeadSource,Rating,Phone from salesforce_leads";
		$all_contacts = getData($getQuery);
		return $all_contacts;
	}
	
	function is_contact_exist($Id){
		$cnt=getOne("Select count(`Id`) from salesforce_contacts where Id='".$Id."'");
		if(intval($cnt)>0){
			return true;
		}else{
			return false;
		}
	}
	
	function is_lead_exist($Id){
		$cnt=getOne("Select count(`Id`) from salesforce_leads where Id='".$Id."'");
		if(intval($cnt)>0){
			return true;
		}else{
			return false;
		}
	}
	
	function is_call_exist($number){
		if(strlen($number)>10){
			$number=substr($number,-10);
		}
		$cnt=getData("Select call_id from incoming_calls where (call_from like '".$number."' OR call_to like '".$number."') AND has_to_sync='0' order by current_time DESC");
		if($cnt){
			return $cnt[0]['call_id'];
		}else{
			return false;
		}
	}
	
	function has_recording_url($call_id){
		$recording_url=getOne("Select `RecordingURL__c` from salesforce_tasks where CallSID__c='".$call_id."'");
		if(is_null($recording_url)){
			return false;
		}else{
			return $recording_url;
		}
	}
	
	function updateLead($dataArray){
		$updateQry=$this->getUpdateDataString($dataArray,"salesforce_leads","Id");
		updateData($updateQry);
	}
	
	function updateContact($dataArray){
		$updateQry=$this->getUpdateDataString($dataArray,"salesforce_contacts","Id");
		updateData($updateQry);
	}
	
	function updateCallVariablesByCallId($varArray){
		$updateQry=$this->getUpdateDataString($varArray,"incoming_calls","call_sid");
		updateData($updateQry);
	}
	
	function updateCallVariablesById($varArray){
		$updateQry=$this->getUpdateDataString($varArray,"incoming_calls","call_id");
		updateData($updateQry);
	}
	
	function updateCallVariablesByNumber($varArray){
		$updateQry=$this->getUpdateDataString($varArray,"incoming_calls","call_from");
		$updateQry.=" AND is_active='1'";
		updateData($updateQry);
	}
	
	function insertLead($varArray){
		$insertQry = $this->getInsertDataString($varArray, 'salesforce_leads');
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	function insertContact($varArray){
		$insertQry = $this->getInsertDataString($varArray, 'salesforce_contacts');
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	function insertNote($varArray){
		$insertQry = $this->getInsertDataString($varArray, 'salesforce_tasks');
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	function insertCallVariables($varArray){
		$insertQry = $this->getInsertDataString($varArray, 'incoming_calls');
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	function deleteContact($id){
		updateData("DELETE from salesforce_contacts where id='".$id."'");
	}
	
	function deleteLead($id){
		updateData("DELETE from salesforce_leads where id='".$id."'");
	}
	
	function getLeadVariables(){
		$fieldArray=array("Accept_the_Guest_Waiver__c","Street","City","State","PostalCode","Country","Birthday__c","ParentFirstName__c","ParentLastName__c","Company","Description","Email","Industry","LeadSource","Status","Salutation","FirstName","LastName","Phone","Rating","Title","Website","Type__c");
		$varArray=array();
		foreach($fieldArray as $field){
			if(isset($_REQUEST[$field])){
				$varArray[$field] = $_REQUEST[$field];
			}
		}
		return $varArray;
	}
	
	function getLeadVariablesForLocal(){
		$fieldArray=array("Email","LeadSource","FirstName","LastName","Phone","Rating","Title");
		$varArray=array();
		foreach($fieldArray as $field){
			$varArray[$field] = $_REQUEST[$field];
		}
		return $varArray;
	}
	
	function getContactVariables(){
		$fieldArray=array("FirstName","MobilePhone","LastName","Email","Title","MailingStreet","OtherStreet","MailingCity","OtherCity","MailingState","OtherState","MailingPostalCode","OtherPostalCode","MailingCountry","OtherCountry","Fax","HomePhone","Birthdate","OtherPhone","Department","AssistantName","AssistantPhone","Description","LeadSource","Type__c","Salutation","Phone");
		$varArray=array();
		foreach($fieldArray as $field){
			if(isset($_REQUEST[$field])){
				$varArray[$field] = $_REQUEST[$field];
			}
		}
		return $varArray;
	}
	
	function getContactVariablesForLocal(){
		$fieldArray=array("Phone","FirstName","MobilePhone","LastName","Email","LeadSource");
		$varArray=array();
		foreach($fieldArray as $field){
			$varArray[$field] = $_REQUEST[$field];
		}
		return $varArray;
	}
	
	function getTwillioIncomingVariables(){
		$fieldArray=array("CallSid","From","To");
		$varArray['call_sid']=$_REQUEST['CallSid'];
		$varArray['call_from']=$_REQUEST['From'];
		$varArray['call_to']=$_REQUEST['To'];
		return $varArray;
	}
	
	function syncCalls(){
		$call_to_sync=getData("Select * from incoming_calls where has_to_sync='1' AND is_sync='0' AND recording_url!=''");
		if(count($call_to_sync)===0){
			return false;
		}
		$call_ids='';
		foreach($call_to_sync as $call){
			$dataArray=array();
			$dataArray['CallSID__c']=$call['call_sid'];
			$dataArray['RecordingURL__c']=$call['recording_url'];
			$dataArray['WhoId']=$call['account_id'];
			$dataArray['ActivityDate']=date('Y-m-d');
			$dataArray['Status']='Completed';
			if(strpos($call['call_from'],'client')===FALSE){
				$dataArray['Subject']="Incoming Call";
			}else{
				$dataArray['Subject']="Dialed Call";
			}
			add_note($dataArray);
			$call_ids.="'".$call['call_id']."',";
		}
		if($call_ids!==''){
			$call_ids=substr($call_ids,0,strlen($call_ids)-1);
			updateData("Update incoming_calls set is_sync='1' where call_id in (".$call_ids.")");
		}
		return true;
	}	
}
?>