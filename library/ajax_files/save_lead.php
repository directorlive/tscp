<?
	session_start();
	set_time_limit(0);
	if($_SERVER['REQUEST_METHOD']==="POST"){
		require_once('../salesforceLocalObject.php');
		$salesforceLocalObject = new SalesForceLocalManager();
		
		$lead_variables=$salesforceLocalObject->getLeadVariables();
		$lead_variables_local=$salesforceLocalObject->getLeadVariablesForLocal();
		
		$function=$_REQUEST['type'];
		$function="save_lead_".$function;
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
					echo "Lead added successfully";return;
				}else{
					echo "Error Creating new lead! <br>Error:".$response['error'];return;
				}
			}else{
				echo $resp_array;return;
			}
		}else if($function=="save_lead_update"){
			$resp_array=update_lead($lead_variables,$_REQUEST['lead_id']);
			
			$lead_variables_local['Id']=$_REQUEST['lead_id'];
			$salesforceLocalObject->updateLead($lead_variables_local);
			echo "Lead Updated successfully.";return;
		}
	}
	
?>