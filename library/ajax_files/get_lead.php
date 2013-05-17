<?
	session_start();
	set_time_limit(0);
	$leadId=$_REQUEST['Id'];
	header('Content-type: application/json');
	require_once('../REST/rest_functions.php');
	$lead = show_lead($leadId);
	$tasks = get_tasks_of($leadId);
	echo '{"lead_details":'.$lead.',"all_tasks":'.$tasks.'}';
?>