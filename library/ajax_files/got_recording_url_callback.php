<?
	session_start();
	set_time_limit(0);
	if($_SERVER['REQUEST_METHOD']==="POST"){
		require_once('../salesforceLocalObject.php');
		$salesforceLocalObject=new SalesForceLocalManager();
		$call_id=$_REQUEST['call_id'];
		$recall_time=time()+300;
		while(time()<$recall_time){
			$recording_url=$salesforceLocalObject->has_recording_url($call_id);
			if($recording_url){
				echo '{"got_it":true,"recording_url":"'.$recording_url.'"}';
				return;
				//echo "Error i have got some non json string";return;
			}
		}
		echo "recall";return;
	}
/*		
		$dataArray['CallSID__c']=$_REQUEST['call_id'];
		$dataArray['Description']=$_REQUEST['note'];
		$dataArray['WhoId']=$_REQUEST['account_id'];
		$dataArray['ActivityDate']=date('Y-m-d');
//		$dataArray['IsClosed']=TRUE;
		$dataArray['Status']='Completed';
		$dataArray['Subject']="Note";
//		header('Content-type: application/json');
		$resp_array=add_note($dataArray);
		$response = json_decode($resp_array, true);
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
	
?>