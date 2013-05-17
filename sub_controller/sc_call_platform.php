<?php
	require_once('library/salesforceLocalObject.php');
	$salesforceLocalObject = new SalesForceLocalManager();
	switch($function){
			case "save_lead_add":
			case "save_lead_update":
				//require_once('library/REST/rest_functions.php');
				$lead_variables=$salesforceLocalObject->getLeadVariables();
				$lead_variables_local=$salesforceLocalObject->getLeadVariablesForLocal();
				
				if($function=="save_lead_add"){
					$resp_array=create_lead($lead_variables);
					$response = json_decode($resp_array, true);
					if($response){
						if(! isset($response['error']) || count($response['error'])===0){
							$id = $response["id"];
							$lead_variables_local['Id']=$id;
							$call_variables=array();
							$call_variables['call_id']=$salesforceLocalObject->is_call_exist($_REQUEST['Phone']);
							if($call_variables['call_id']){
								$call_variables['account_id']=$id;
								$call_variables['has_to_sync']='1';
								$salesforceLocalObject->updateCallVariablesById($call_variables);
								$salesforceLocalObject->syncCalls();
							}
							$salesforceLocalObject->insertLead($lead_variables_local);
							$notification="Lead added successfully";
						}else{
							$notification="Error Creating new lead! <br>Error:".$response['error'];
						}
					}else{
						$notification=$resp_array;
					}
				}else if($function=="save_lead_update"){
					$resp_array=update_lead($lead_variables,$_REQUEST['lead_id']);
					$lead_variables_local['Id']=$_REQUEST['lead_id'];
					$salesforceLocalObject->updateLead($lead_variables_local);
					$notification="Lead Updated successfully.";
				}
			break;
			
			case "save_contact_add":
			case "save_contact_update":
				$contact_variables=$salesforceLocalObject->getContactVariables();
				$contact_variables_local=$salesforceLocalObject->getContactVariablesForLocal();
				
				if($function=="save_contact_add"){
					$resp_array=create_contact($contact_variables);
					$response = json_decode($resp_array, true);
					if($response){
						if(! isset($response['error']) || count($response['error'])===0){
							$id = $response["id"];
							$contact_variables_local['Id']=$id;
							$salesforceLocalObject->insertContact($contact_variables_local);
							$notification="Contact added successfully";
						}else{
							$notification="Error Creating new contact! <br>Error:".$response['error'];
						}
					}else{
						$notification=$resp_array;
					}
				}else if($function=="save_contact_update"){
					$resp_array=update_contact($contact_variables,$_REQUEST['contact_id']);
					$contact_variables_local['Id']=$_REQUEST['contact_id'];
					$salesforceLocalObject->updateContact($contact_variables_local);
					$notification="Contact Updated successfully.";
				}
			break;
		}
?>