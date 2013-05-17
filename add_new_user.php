<?
//Manthan Tripathi - 25/08/2012
//to add and edit users
$is_edit=false;
$is_exist=false;
require_once('library/userObject.php');
$userObject= new UserManager();
require_once('library/groupObject.php');
$groupObject= new GroupManager();
$allGroups=$groupObject->getAllGroups();
$allLanguages=getAllLanguages();
$defaultLanguage=1;
foreach($allLanguages as $language){
	if($language['is_default']=='1'){
		$defaultLanguage=$language['id'];
		break;
	}
}
if(isset($_SESSION['userExist'])&& $_SESSION['userExist']=="true"){
	$userDetails=$userObject->getUserVariables();
	$is_exist=true;
	unset($_SESSION['userExist']);
	
/*	$userDetails['selectedBranches']=array();
	if(isset($_REQUEST['branches'])){
		$userDetails['selectedBranches']=$_REQUEST['branches'];
	}*/
}
if(isset($_SESSION['edit_user']) && $_SESSION['edit_user']=="true"){
	$is_edit=true;
	if($is_exist){
		$userDetails['user_id']=$_REQUEST['user_id'];
	}else{
		$userId=$_SESSION['user_id_for_edit'];
		$userDetails=$userObject->getUserDetails($userId);
//		$userDetails['selectedBranches']=$userObject->getAllPermissionedBranchesOfUser($userId);
	}
	unset($_SESSION['edit_user'],$_SESSION['user_id_for_edit']);
}
?>
<div class="grid-24">
  <div class="widget">
    <div class="widget-content">
	    <? if($is_edit){
				echo "<input type='hidden' id='first_focus' value='user_name'>";
			}else{
				echo "<input type='hidden' id='first_focus' value='user_name'>";
			}
	 	?>


        
        <? if($is_edit){ echo"<input type=\"hidden\" name=\"user_id\" id=\"user_id\" value=\"".$userDetails['user_id']."\">";}?>
        
        <!-- .field-group -->
        <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="user_name">Username<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
            	<? if($is_edit){?>
                	<label class='value_label'><?=$userDetails['user_name']?></label>
                	<input type="hidden" name="user_name" id="user_name" value="<?=$userDetails['user_name']?>">
				<? }else{?>
		            <input type="text" name="user_name" id="user_name" size="20" value="<? if($is_exist) echo $userDetails['user_name'];?>">
		        <? }?>
            </div>
			<div class="clr"></div>
        </div>
        <!-- .field-group -->
        <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="user_password">Password<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
				<input type="password" name="user_password" id="user_password" size="32" value="<? if($is_edit){echo "********";}?>">
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="reenter_password">Re-Enter Password<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
				<input type="password" id="reenter_password" size="32" value="<? if($is_edit){echo "********";}?>">
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="name">Name<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
            	<input type="text" name="name" id="name" size="32" value="<? if($is_edit || $is_exist) echo $userDetails['name'];?>">
            </div>
			<div class="clr"></div>
        </div>        
        
        <!-- .field-group -->        
         <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="user_group">Group<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
				<? if($is_edit || $is_exist){createComboBox('user_group','group_id','group_name', $allGroups, true,$userDetails['user_group']);} 
                else{ createComboBox('user_group','group_id','group_name', $allGroups,true);}?>
            </div>
			<div class="clr"></div>
     	</div>
        
        <!-- .field-group -->
        <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="user_email">E-mail<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
            	<input type="text" name="user_email" id="user_email" size="32" value="<? if($is_edit || $is_exist) echo $userDetails['user_email'];?>">
            </div>
			<div class="clr"></div>
        </div>

        <!-- .field-group -->
        
         <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="user_phone">Phone<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
				<input type="text" name="user_phone" id="user_phone" size="32" value="<? if($is_edit || $is_exist) echo $userDetails['user_phone'];?>">
            </div>
			<div class="clr"></div>
     	</div>

        <!-- .field-group -->
        
         <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="preferred_language">Preferred Language<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
				<? if($is_edit || $is_exist){createComboBox('preferred_language','id','language_name', $allLanguages, false,$userDetails['preferred_language']);} 
                else{ createComboBox('preferred_language','id','language_name', $allLanguages, false,$defaultLanguage);}?>
            </div>
			<div class="clr"></div>
     	</div>
        
        <!-- .field-group --
        
         <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="branches">Company Permissions</label></div>
            <div class="colon">:</div>
			<div class="field_value">
            	<span>
				< ? 	if($is_edit || $is_exist){
						echo $companyObject->getCompanyBranchTreeString($userDetails['selectedBranches']);
					}else{
						echo $companyObject->getCompanyBranchTreeString();
					}
				?>
                </span>
                <span><input type="checkbox" id="check_all_companies"/>Check All <a id="uncheck_all_companies" href="#" >Uncheck All</a></span>
            </div>
			<div class="clr"></div>
     	</div>
        <!-- .field-group -->
       <br />
		<? if($is_exist){echo "
		   <div class=\"errordiv\">
				<span>
				   User name Exist!
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
            <input type="button" onClick="<? if($is_edit && ! $is_copy){echo "validateUserFields('manage_users.php','edit_user_entry');";}else{echo "validateUserFields('manage_users.php','add_user');";}?>" class="btn btn-grey" value="Save Data" /> &nbsp;&nbsp;&nbsp;
			<? if(!$is_edit || $is_copy){?>
                <input type="button" class="btn btn-grey" value="Add More" onClick="validateUserFields('manage_users.php','add_more');"/> &nbsp;&nbsp;&nbsp;
            <? }?>
            <input type="button" class="btn btn-grey" value="Cancel"  onClick="callPage('manage_users.php');"/>
            <div><span class="required">*</span> required</div>
        </div>
        <!-- .actions -->

    </div>
    <!-- .widget-content --> 
    
  </div>
  <!-- .widget --> 
  
</div>
