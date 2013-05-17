<?
//Manthan Tripathi - 23/08/2012
//for group management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class GroupManager extends commonObject
{
	
	//to get all the groups.
	function getAllGroups()
	{
		return $resultSet = getData("select * from  user_groups where is_active =1 AND group_id in (SELECT `permissioned_group_id` as `user_group` FROM `user_permissions_on_group` WHERE `group_id`=".$_SESSION['user_group'].")");
	}
	
	//To get all the details of perticular user group using group_id
	function getGroupDetails($group_id)
	{
		return $resultSet = getRow("select * from  user_groups where is_active =1 AND group_id='".$group_id."'");
	}

	//To get name of perticular group using group_id
	function getGroupNameUsingId($group_id){
		return $resultSet = getOne("select group_name from user_groups where is_active =1 AND group_id='".$group_id."'");
	}

	//To restrict duplicate in groups.
	function isGroupExist($group_name,$landing_page,$group_id=0){
		$query="select * from user_groups where group_name='".$group_name."' AND landing_page='".$landing_page."'";
		if($group_id!=0){
			$query="select * from user_groups where group_name='".$group_name."' AND landing_page='".$landing_page."' AND group_id!='".$group_id."'";
		}
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}
	}
	
	//To update a row in user_group table using group_id. 
	function updateUsingId($dataArray){
		$updateQry=$this->getUpdateDataString($dataArray,"user_groups","group_id");
		updateData($updateQry);
	}
	
	//To get the page permission for group.
	function getAllPermissionedPagesOfGroup($group_id){
		$resultSet=getData("SELECT `page_id` FROM `user_permissions` WHERE is_active =1 AND `group_id`=".$group_id);
		$permissionedPages=array();
		for($i=0;$i<count($resultSet);$i++){
			$permissionedPages[]=$resultSet[$i]['page_id'];
		}
		return $permissionedPages;
	}
	
	//To set the page permission for group.
	function setPagePermissionsForGroup($group_id,$pageArray){
		$first=true;
		updateData("DELETE FROM `user_permissions` WHERE  page_id!=1 AND `group_id`=".$group_id);
		if(count($pageArray)>0){
			$query="INSERT INTO `user_permissions`(`group_id`, `page_id`) VALUES ";
			foreach($pageArray as $pageToAdd){
				if(!$first){
					$query.=", ";
				}else{
					$first=false;
				}
				$query.="('".$group_id."','".$pageToAdd."')";
			}
			updateData($query);
		}
		updateData("OPTIMIZE TABLE `user_permissions`");//To delete the data files related to the deleted records.
	}
	
	function setOnePagePermissionsForGroup($varArray){
		$insertQry = $this->getInsertDataString($varArray, 'user_permissions');
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	//To get the group permission for group.
	function getAllPermissionedGroupsOfGroup($group_id){
		$resultSet=getData("SELECT `permissioned_group_id` FROM `user_permissions_on_group` WHERE is_active =1 AND `group_id`=".$group_id);
		$permissionedGroups=array();
		for($i=0;$i<count($resultSet);$i++){
			$permissionedGroups[]=$resultSet[$i]['permissioned_group_id'];
		}
		return $permissionedGroups;
	}
	
	//To make the HTML list of checkboxes for permission of group.
	function makeGroupPermissionList($permissionedGroups=array()){
		$permissionedGroupsStr="<ul class=\"groupsCheckboxes\">";
		$allGroups=$this->getAllGroups();
		for($i=0;$i<count($allGroups);$i++){
			$permissionedGroupsStr.="<li><input type=\"checkbox\" name=\"groups[]\" value=\"".$allGroups[$i]['group_id']."\"";
			if(in_array($allGroups[$i]['group_id'],$permissionedGroups)){
				$permissionedGroupsStr.="checked=\"checked\"";
			}
			$permissionedGroupsStr.=">".$allGroups[$i]['group_name']."</li>";
		}
		return $permissionedGroupsStr."</ul>";
	}
	
	//To set the group permission for group.
	function setGroupPermissionsForGroup($group_id,$groupArray){
		$first=true;
		updateData("DELETE FROM `user_permissions_on_group` WHERE `group_id`=".$group_id);
		if(count($groupArray)>0){
			$query="INSERT INTO `user_permissions_on_group`(`group_id`, `permissioned_group_id`) VALUES ";
			foreach($groupArray as $groupToAdd){
				if(!$first){
					$query.=", ";
				}else{
					$first=false;
				}
				$query.="('".$group_id."','".$groupToAdd."')";
			}
			updateData($query);
		}
		updateData("OPTIMIZE TABLE `user_permissions_on_group`");//To delete the data files related to the deleted records.
	}

	//To delete a row in user_group table using group_id. 
	function deleteUsingId($group_id){
		updateData("UPDATE `user_groups` SET `is_active`=false WHERE `group_id`='".$group_id."'");
		updateData("UPDATE `user_permissions_on_group` SET `is_active`=false WHERE `group_id`='".$group_id."'");
		updateData("UPDATE `user_permissions` SET `is_active`=false WHERE `group_id`='".$group_id."'");
	}
		
	function insertGroup($varArray)
	{
		$insertQry = $this->getInsertDataString($varArray, 'user_groups');
		updateData($insertQry);
		$insertedGroupId=mysql_insert_id();
		updateData("INSERT INTO `user_permissions_on_group`(`group_id`, `permissioned_group_id`) VALUES ('".$_SESSION['user_group']."','".$insertedGroupId."')");
		return $insertedGroupId;
	}
	
	function getGroupVariables()
	{
		$varArray['group_name'] = $_REQUEST['group_name'];
		$varArray['comments'] = $_REQUEST['comments'];
		$varArray['landing_page'] = $_REQUEST['landing_page'];
		return $varArray;
	}

}
?>