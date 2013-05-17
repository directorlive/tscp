<?
	session_start();
	set_time_limit(0);
	header('Content-type: application/json');
	require_once('../Config.php');
	$result=getData("Select * from available_agents order by id");
	echo json_encode($result);
?>



