<?php
	switch($function){
			case "add_user":
				require_once('library/userObject.php');
				$userObject = new UserManager();
				$userVariables = $userObject->getUserVariables();
				if(!$userObject->isUserExist($userVariables['user_name'])){
					$userPassword=$userVariables['user_password'];
					$userVariables['user_password']="";
					$user_id=$userObject->insertUser($userVariables);
					$userObject->setPassword($userPassword,$user_id);
					
/*					$selectedBranchArray=array();
					if(isset($_REQUEST['branches'])){
						$selectedBranchArray=$_REQUEST['branches'];
					}
					$userObject->setBranchPermissionsForUser($user_id,$selectedBranchArray);
*/					
					$notification = "User Added Successfully!";
				}else{
					$_SESSION['userExist']=true;
					$page="add_new_user.php";
				}
			break;
			
			case "edit_user":
			case "copy_user":
				$_SESSION['edit_user']="true";
				$_SESSION['user_id_for_edit']=$_REQUEST['user_id'];
				
				if($function=="copy_user"){
					$is_copy=true;
				}
				$page="add_new_user.php";
			break;
			
			case "edit_user_entry":
				require_once('library/userObject.php');
				$userObject = new UserManager();
				$userVariables = $userObject->getUserVariables();
				$userVariables['user_id']=$_REQUEST['user_id'];
				if(!$userObject->isUserExist($userVariables['user_name'],$userVariables['user_id'])){
					$userPassword=$userVariables['user_password'];
					//$userVariables['user_password']="";
					unset($userVariables['user_password']);
					$previousPass=$userObject->getUserPassword($userVariables['user_id']);
					$userObject->updateUsingId($userVariables);
					$sha1_currentpass=sha1($userPassword);
					if(!($sha1_currentpass==$previousPass)  && !($sha1_currentpass==sha1('********'))){
						$userObject->setPassword($userPassword,$userVariables['user_id']);
					}
/*					$selectedBranchArray=array();
					if(isset($_REQUEST['branches'])){
						$selectedBranchArray=$_REQUEST['branches'];
					}
					$userObject->setBranchPermissionsForUser($userVariables['user_id'],$selectedBranchArray);*/
					
					$notification = "User Updated Successfully!";
				}else{
					$_SESSION['userExist']=true;
					$page="add_new_user.php";
				}
			break;
			
			case "delete_user":
				require_once('library/userObject.php');
				$userObject = new UserManager();
				$user_id=$_REQUEST['user_id'];
				$userObject->deleteUsingId($user_id);
				$notification = "User Deleted Successfully!";
			break;
		}

?>