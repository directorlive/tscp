<?
	session_start();
	set_time_limit(0);
	if($_SERVER['REQUEST_METHOD']==="POST"){
		require_once('../salesforceLocalObject.php');
		$salesforceLocalObject=new SalesForceLocalManager();
		$dataArray=array();
		$dataArray['CallSID__c']=$_REQUEST['call_id'];
		$dataArray['AccountId']=$_REQUEST['account_id'];
		$salesforceLocalObject->insertNote($dataArray);
/*		$response = json_decode($resp_array, true);
		if($response){
			if(! isset($response['error']) || count($response['error'])===0){
				$id = $response["id"];
				echo $id." added successfully";
//				$notification=" added successfully";
			}else{
				echo "Error Creating new lead! <br>Error:".$response['error'];
			}
		}else{
			echo $resp_array;
		}*/
	}
	
?>