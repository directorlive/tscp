<?
	session_start();
	set_time_limit(0);
	if($_SERVER['REQUEST_METHOD']==="POST"){
		require_once('../salesforceLocalObject.php');
		$salesforceLocalObject = new SalesForceLocalManager();

		$contact_variables=$salesforceLocalObject->getContactVariables();
		$contact_variables_local=$salesforceLocalObject->getContactVariablesForLocal();

		$function=$_REQUEST['type'];
		$function="save_contact_".$function;

		if($function=="save_contact_add"){
			$resp_array=create_contact($contact_variables);
			$response = json_decode($resp_array, true);
			if($response){
				if(! isset($response['error']) || count($response['error'])===0){
					$id = $response["id"];
					$contact_variables_local['Id']=$id;
					$salesforceLocalObject->insertContact($contact_variables_local);
					echo "Contact added successfully";return;
				}else{
					echo "Error Creating new contact! <br>Error:".$response['error'];return;
				}
			}else{
				echo $resp_array;return;
			}
		}else if($function=="save_contact_update"){
			$resp_array=update_contact($contact_variables,$_REQUEST['contact_id']);
			$contact_variables_local['Id']=$_REQUEST['contact_id'];
			$salesforceLocalObject->updateContact($contact_variables_local);
			echo "Contact Updated successfully.";return;
		}
	}
	
?>