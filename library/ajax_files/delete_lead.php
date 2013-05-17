<?
	session_start();
	set_time_limit(0);
	if($_SERVER['REQUEST_METHOD']==="POST"){
		require_once('../salesforceLocalObject.php');
		$salesforceLocalObject = new SalesForceLocalManager();

		$id=$_REQUEST['id'];
		$salesforceLocalObject->deleteLead($id);
	}
	
?>