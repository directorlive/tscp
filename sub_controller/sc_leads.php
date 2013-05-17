<?php
	switch($function){
			case "save_lead_add":
			case "save_lead_update":
				require_once('library/REST/rest_functions.php');
				
				$fieldArray=array("Accept_the_Guest_Waiver__c","Street","City","State","PostalCode","Country","Birthday__c","ParentFirstName__c","ParentLastName__c","Company","Description","Email","Industry","LeadSource","Status","Salutation","FirstName","LastName","Phone","Rating","Title","Website","Type__c");
				$varArray=array();
				foreach($fieldArray as $field){
					$varArray[$field] = $_REQUEST[$field];
				}
				
				
				
				if($function=="save_lead_add"){
					$resp_array=create_lead($varArray);
					$response = json_decode($resp_array, true);
					if($response){
						if(! isset($response['error']) || count($response['error'])===0){
							$id = $response["id"];
							$notification="Lead added successfully";
						}else{
							$notification="Error Creating new lead! <br>Error:".$response['error'];
						}
					}else{
						$notification=$resp_array;
					}
				}else if($function=="save_lead_update"){
					$resp_array=update_lead($varArray,$_REQUEST['lead_id']);
					$notification="Lead Updated successfully.";
				}
			break;
		}
?>