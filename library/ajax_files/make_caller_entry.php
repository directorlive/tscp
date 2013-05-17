<?
	session_start();
	if($_SERVER['REQUEST_METHOD']==="POST"){
		require_once('../salesforceLocalObject.php');
		$salesforceLocalObject=new SalesForceLocalManager();
		
		$dataArray=array();
		$dataArray['account_id']=$_REQUEST['account_id'];
		if($_REQUEST['account_id']!='0'){
			$dataArray['has_to_sync']='1';
		}
		$dataArray['call_to']=$_REQUEST['to'];
		if(isset($_REQUEST['call_id'])){
			$dataArray['call_sid']=$_REQUEST['call_id'];
			$dataArray['call_from']=$_REQUEST['from'];
		}
		$id=$salesforceLocalObject->insertCallVariables($dataArray);
		header('Content-type: application/json');
		echo '{"done":true,"id":"'.$id.'"}';
	}
?>