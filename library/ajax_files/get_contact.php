<?
	session_start();
	set_time_limit(0);
	$id=$_REQUEST['Id'];
	header('Content-type: application/json');
	require_once('../REST/rest_functions.php');
	$lead = show_contact($id);
	$tasks = get_tasks_of($leadId);
	echo '{"contact_details":'.$lead.',"all_tasks":'.$tasks.'}';
	
?>