<?
	session_start();
	set_time_limit(0);
	header('Content-type: application/json');
	require_once('../salesforceLocalObject.php');
	$salesforceObject=new SalesForceLocalManager();
	$result = $salesforceObject->get_all_leads();
	echo json_encode($result);
?>



