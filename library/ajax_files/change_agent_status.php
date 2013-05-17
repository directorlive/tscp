<?
	session_start();
	if($_SERVER['REQUEST_METHOD']==="POST"){
		require_once('../Config.php');
		$is_available=$_REQUEST['is_available'];
		$now='';
		if($is_available){
			$now=',last_online=NOW()';
		}
		$agent_name=$_SESSION['user_name'];
		$agent_count=getOne("Select count(`agent_name`) from available_agents where agent_name='".$agent_name."'");
		if(intval($agent_count)===1){
			updateData("update available_agents set is_available={$is_available}{$now} where agent_name='{$agent_name}'");
		}else{
			updateData("Delete from available_agents where agent_name='{$agent_name}'");
			updateData("insert into available_agents set is_available={$is_available}, agent_name='{$agent_name}'{$now}");
		}
	}
	
?>