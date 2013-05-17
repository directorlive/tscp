<?php
	switch($function){
			case "add_group":
				require_once('library/groupObject.php');
				$groupObject = new GroupManager();
				$groupVariables = $groupObject->getGroupVariables();
				if(!$groupObject->isGroupExist($groupVariables['group_name'],$groupVariables['landing_page'])){
					$group_id=$groupObject->insertGroup($groupVariables);
					$selectedPageArray=array();
					if(isset($_REQUEST['pages'])){
						$selectedPageArray=$_REQUEST['pages'];
					}
					$groupObject->setPagePermissionsForGroup($group_id,$selectedPageArray);
					$selectedGroupArray=array();
					if(isset($_REQUEST['groups'])){
						$selectedGroupArray=$_REQUEST['groups'];
					}
					$selectedGroupArray[]=$group_id;
					$groupObject->setGroupPermissionsForGroup($group_id,$selectedGroupArray);
					$notification = "Group Added Successfully!";
				}else{
					$_SESSION['groupExist']=true;
					$page="add_new_group.php";
				}

			break;
			
			case "edit_group":
			case "copy_group":
				$_SESSION['edit_group']="true";
				$_SESSION['group_id']=$_REQUEST['group_id'];
				
				if($function=="copy_group"){
					$is_copy=true;
				}
				$page="add_new_group.php";
			break;
			
			case "edit_group_entry":
				require_once('library/groupObject.php');
				$groupObject = new GroupManager();
				$groupVariables = $groupObject->getGroupVariables();
				$groupVariables['group_id']=$_REQUEST['group_id'];
				if(!$groupObject->isGroupExist($groupVariables['group_name'],$groupVariables['landing_page'],$groupVariables['group_id'])){
					$groupObject->updateUsingId($groupVariables);
					$selectedPageArray=array();
					if(isset($_REQUEST['pages'])){
						$selectedPageArray=$_REQUEST['pages'];
					}
					$groupObject->setPagePermissionsForGroup($groupVariables['group_id'],$selectedPageArray);
					$selectedGroupArray=array();
					if(isset($_REQUEST['groups'])){
						$selectedGroupArray=$_REQUEST['groups'];
					}
					$groupObject->setGroupPermissionsForGroup($groupVariables['group_id'],$selectedGroupArray);
					$notification = "Group Updated Successfully!";
				}else{
					$_SESSION['groupExist']=true;
					$page="add_new_group.php";
				}
			break;
			
			case "delete_group":
				require_once('library/groupObject.php');
				$groupObject = new GroupManager();
				$group_id=$_REQUEST['group_id'];
				$groupObject->deleteUsingId($group_id);
				$notification = "Group Deleted Successfully!";
			break;
		}
?>