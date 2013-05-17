<?
//Manthan Tripathi - 23/08/2012
//to add and edit groups
$is_edit=false;
$is_exist=false;
require_once('library/groupObject.php');
$groupObject= new GroupManager();
require_once('library/pageObject.php');
$pageObject= new PageManager();
$allPages=$pageObject->getAllPages();
if(isset($_SESSION['groupExist'])&& $_SESSION['groupExist']=="true"){
	$groupDetails=$groupObject->getGroupVariables();
	$groupDetails['selectedPages']=array();
	if(isset($_REQUEST['pages'])){
		$groupDetails['selectedPages']=$_REQUEST['pages'];
	}
	
	$groupDetails['selectedGroups']=array();
	if(isset($_REQUEST['groups'])){
		$groupDetails['selectedGroups']=$_REQUEST['pages'];
	}
	$is_exist=true;
	unset($_SESSION['groupExist']);
}
if(isset($_SESSION['edit_group']) && $_SESSION['edit_group']=="true"){
	$is_edit=true;
	if($is_exist){
		$groupDetails['group_id']=$_REQUEST['group_id'];
	}else{
		$groupId=$_SESSION['group_id'];
		$groupDetails=$groupObject->getGroupDetails($groupId);
		$groupDetails['selectedPages']=$groupObject->getAllPermissionedPagesOfGroup($groupId);
		$groupDetails['selectedGroups']=$groupObject->getAllPermissionedGroupsOfGroup($groupId);
	}
	unset($_SESSION['edit_group'],$_SESSION['group_id']);
}
?>
<div class="grid-24">
  <div class="widget">
    
    <!-- .widget-header -->

    <div class="widget-content">
	    <? if($is_edit){
				echo "<input type='hidden' id='first_focus' value='group_name'>";
			}else{
				echo "<input type='hidden' id='first_focus' value='group_name'>";
			}
	 	?>



        <? if($is_edit){ echo"<input type=\"hidden\" name=\"group_id\" id=\"group_id\" value=\"".$groupDetails['group_id']."\">";}?>
        
        <!-- .field-group -->
        <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="group_name">Name<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
	            <input type="text" name="group_name" id="group_name" size="32" value="<? if($is_edit || $is_exist) echo $groupDetails['group_name'];?>">
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="comments">Comments<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
            	<input type="text" name="comments" id="comments" size="32" value="<? if($is_edit || $is_exist) echo $groupDetails['comments'];?>">
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->        
         <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="landing_page">Landing Page<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
				<? if($is_edit || $is_exist){createComboBox('landing_page','page_id','title', $allPages, true,$groupDetails['landing_page']);} 
                else{ createComboBox('landing_page','page_id','title', $allPages,true);}?>
            </div>
			<div class="clr"></div>
     	</div>
        <!-- .field-group -->
        
         <div class="field-group tricolumn col1of3">
				<label class='lbl_new'  for="pages" style="font-weight:bold;">Page Permissions:</label>
            	<div style="margin-top:10px;">
					<? if($is_edit || $is_exist){
						echo $pageObject->getTreeString($groupDetails['selectedPages']);
					}else{
						echo $pageObject->getTreeString();
					}?>
                </div>
                <span><input type="checkbox" id="check_all_pages"/>Check All <a id="uncheck_all_pages" href="#" >Uncheck All</a></span>
     	</div>
        
         <!-- .field-group -->
        
         <div class="field-group tricolumn col2of3">
			<label class='lbl_new'  for="groups" style="font-weight:bold">Group Permissions:</label>
            <div style="margin-top:10px;">
				<? if($is_edit || $is_exist){
                    echo $groupObject->makeGroupPermissionList($groupDetails['selectedGroups']);
                }else{
                    echo $groupObject->makeGroupPermissionList();
                }?>
            </div>
            <span><input type="checkbox" id="check_all_groups"/>Check All <a id="uncheck_all_groups" href="#" >Uncheck All</a></span>
     	</div>
        <div style="clear:both;"></div>
        <!-- .field-group -->
        
       <br />
		<? if($is_exist){echo "
		   <div class=\"errordiv\">
				<span>
				   Group Exist!
				</span>
		   </div>
	   ";}else{?>
		<div class="errordiv" style="display:none;">
			<span>
				
            </span>
       </div>
       <? }?>
       <br />
        <div class="actions">
            <input type="button" onClick="<? if($is_edit && ! $is_copy){echo "validateGroupFields('manage_groups.php','edit_group_entry');";}else{echo "validateGroupFields('manage_groups.php','add_group');";}?>" class="btn btn-grey" value="Save Data" /> &nbsp;&nbsp;&nbsp;
			<? if(!$is_edit || $is_copy){?>
                <input type="button" class="btn btn-grey" value="Add More" onClick="validateGroupFields('manage_groups.php','add_more');"/> &nbsp;&nbsp;&nbsp;
            <? }?>
            <input type="button" class="btn btn-grey" value="Cancel"  onClick="callPage('manage_groups.php');"/>
            <div><span class="required">*</span> required</div>
        </div>
        <!-- .actions -->

    </div>
    <!-- .widget-content --> 
    
  </div>
  <!-- .widget --> 
  
</div>
