<?php 
switch($function){
			case "add_page":
				require_once('library/pageObject.php');
				$pageObject = new PageManager();
				
				$pageVariables = $pageObject->getPageVariables();
				if(!$pageObject->isPageExist($pageVariables['page_name'],$pageVariables['level'])){
					$pageObject->insertPage($pageVariables);
					$notification = "Page Added Successfully!";
				}else{
					$_SESSION['pageExist']=true;
					$page="add_new_page.php";
				}
			break;
			
			case "edit_page":
			case "copy_page":
				$_SESSION['edit_page']="true";
				$_SESSION['page_id']=$_REQUEST['page_id'];
				
				if($function=="copy_page"){
					$is_copy=true;
				}
				$page="add_new_page.php";
			break;
			
			case "edit_page_entry":
				require_once('library/pageObject.php');
				$pageObject = new PageManager();
				$pageVariables = $pageObject->getPageVariables();
				$pageVariables['page_id']=$_REQUEST['page_id'];
				$pageObject->updateUsingId($pageVariables);
				$notification = "Page Updated Successfully!";
			break;
			
			case "delete_page":
				require_once('library/pageObject.php');
				$pageObject = new PageManager();
				$page_id=$_REQUEST['page_id'];
				$pageObject->deleteUsingId($page_id);
				$notification = "Page Deleted Successfully!";
			break;
		}
		
?>