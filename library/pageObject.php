<?
//Manthan Tripathi - 22/08/2012
//for page management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class PageManager extends commonObject
{
	private $allSelectedPages; //for consistencty in recursive function createSub It will hold all the selected pages.
	//to get all the pages.
	function getAllPages()
	{
		$pageArray=array();
		$resultSet = getData("select * from  pages where `level`=1 AND is_active =1 AND page_id in (SELECT `page_id` FROM `user_permissions` WHERE is_active =1 AND `group_id`=".$_SESSION['user_group'].") order by `tab_order` ASC");
		foreach($resultSet as $result){
			$pageArray[]=$result;
			$resultSet2=getData("select * from  pages where is_active =1 AND parent_page_id=".$result['page_id']." AND page_id in (SELECT `page_id` FROM `user_permissions` WHERE is_active =1 AND `group_id`=".$_SESSION['user_group'].") order by `tab_order` ASC");
			foreach($resultSet2 as $result2){
				$pageArray[]=$result2;
				$resultSet3=getData("select * from  pages where is_active =1 AND parent_page_id=".$result2['page_id']." AND page_id in (SELECT `page_id` FROM `user_permissions` WHERE is_active =1 AND `group_id`=".$_SESSION['user_group'].") order by `tab_order` ASC");
				foreach($resultSet3 as $result3){
					$pageArray[]=$result3;
				}
			}
		}
		return $pageArray;
	}
	
	//To get all the details of perticular page using page_id
	function getPageDetails($page_id)
	{
		return $resultSet = getRow("select * from  pages where is_active =1 AND page_id='".$page_id."'");
	}

	//To get name of perticular page using page_id
	function getPageNameUsingId($page_id){
		return $resultSet = getOne("select page_name from pages where is_active =1 AND page_id='".$page_id."'");
	}

	//To get all pages of specified level
	function getAllPagesOfLevel($level){
		return $resultSet = getData("select * from pages where is_active =1 AND level='".$level."' AND page_id in (SELECT `page_id` FROM `user_permissions` WHERE is_active =1 AND `group_id`=".$_SESSION['user_group']." ) order by tab_order ASC");
	}

	//To get all pages of or less than specified level
	function getAllPagesOfLevelBelow($level){
		return $resultSet = getData("select * from pages where is_active =1 AND level<=".$level." AND page_id in (SELECT `page_id` FROM `user_permissions` WHERE is_active =1 AND `group_id`=".$_SESSION['user_group']." ) order by tab_order ASC");
	}
	
	//To get the child pages of perticular page
	function getSubPagesOf($page_id){
		return $resultSet= getData("Select * from pages where is_active =1 AND parent_page_id='".$page_id."' AND page_id in (SELECT `page_id` FROM `user_permissions` WHERE is_active =1 AND `group_id`=".$_SESSION['user_group'].") order by tab_order ASC");
	}
	
	//To restrict duplicate in pages.
	function isPageExist($page_name,$level,$page_id=0){
		$query="select * from pages where page_name='".$page_name."' AND level='".$level."'";
		if($page_id!=0){
			$query="select * from pages where page_name='".$page_name."' AND level='".$level."' AND page_id!='".$page_id."'";
		}
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}
	}
	
	//To update a row in pages table using page_id. 
	function updateUsingId($dataArray){
		$updateQry=$this->getUpdateDataString($dataArray,"pages","page_id");
		updateData($updateQry);
	}

	//To delete a row in pages table using page_id. 
	function deleteUsingId($page_id){
		updateData("UPDATE `pages` SET `is_active`=false WHERE `page_id`='".$page_id."'");
		updateData("UPDATE `user_permissions` SET `is_active`=false WHERE `page_id`='".$page_id."'");
	}
		
	function insertPage($varArray)
	{
		$insertQry = $this->getInsertDataString($varArray, 'pages');
		updateData($insertQry);
		$page_id=mysql_insert_id();
		updateData("INSERT INTO `user_permissions` (`group_id`, `page_id`) VALUES ('".$_SESSION['user_group']."','".$page_id."')");
		return $page_id;
	}
	
	function getPageVariables()
	{
		$varArray['page_name'] = $_REQUEST['page_name'];
		$varArray['description'] = $_REQUEST['description'];
		$varArray['title'] = $_REQUEST['title'];
		$varArray['level'] = $_REQUEST['level'];
		$varArray['parent_page_id'] = $_REQUEST['parent_page_id'];
		$varArray['tab_order'] = $_REQUEST['tab_order'];
		return $varArray;
	}
	
	//recursive method to get all the childs and sub-child of perticular page;
	function createSub($page){
		$subPages=$this->getSubPagesOf($page['page_id']);
		$checkedStr="";
		//echo $this->allSelectedPages; exit;
		if(in_array($page['page_id'],$this->allSelectedPages)){
			$checkedStr="checked=\"checked\"";
		}
		if(sizeof($subPages)>0){
			$tree_str="<li><span class=\"closed_child_pages\"></span><input type=\"checkbox\" name=\"pages[]\" value=\"".$page['page_id']."\" ".$checkedStr."><span>".$page['title']."</span><ol style=\"display:none\">";
			foreach($subPages as $subPage){
				$tree_str.=$this->createSub($subPage);
			}
			return $tree_str."</ol></li>";
		}else{
			return "<li><span class=\"no_child_pages\"></span><input type=\"checkbox\" name=\"pages[]\" value=\"".$page['page_id']."\" ".$checkedStr."><span>".$page['title']."</span></li>";
		}
	} 
	
	//to generate tree structure of pages with parent child relation ship in user group page 
	function getTreeString($checked=array(0,0)){
		$this->allSelectedPages=$checked;
		$str="";
		$pagesOfZero=$this->getAllPagesOfLevel(0);
		$pagesOfOne=$this->getAllPagesOfLevel(1);
		foreach($pagesOfZero as $page){
			$str.="<input type=\"checkbox\" name=\"pages[]\" value=\"".$page['page_id']."\" checked=\"checked\" style=\"display:none\">";
		}
		$str.="<ol class=\"main_pages\">";
		foreach($pagesOfOne as $page){
			$str.=$this->createSub($page);
		}
		$str.="</ol>";
		return $str;
	}	
	
}
?>