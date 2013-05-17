<?
//Manthan Tripathi - 23/08/2012
//to add and edit pages.
$is_edit=false;
$is_exist=false;
$show_parent_page_div=false;
require_once('library/pageObject.php');
$pageObject= new PageManager();
if(isset($_SESSION['pageExist'])&& $_SESSION['pageExist']=="true"){
	$pageDetails=$pageObject->getPageVariables();
	$is_exist=true;
	unset($_SESSION['pageExist']);
}
if(isset($_SESSION['edit_page']) && $_SESSION['edit_page']=="true"){
	$is_edit=true;
	if($is_exist){
		$pageDetails['page_id']=$_REQUEST['page_id'];
	}else{
		$pageId=$_SESSION['page_id'];
		$pageDetails=$pageObject->getPageDetails($pageId);
	}
	unset($_SESSION['edit_page'],$_SESSION['page_id']);
}
if($is_edit || $is_exist){
	if($pageDetails['level']==2 || $pageDetails['level']==3){
		$show_parent_page_div=true;
		$allParentPages=$pageObject->getAllPagesOfLevelBelow($pageDetails['level']-1);
	}
}
?>
<div class="grid-24">
  <div class="widget">
    
    <!-- .widget-header -->  
    <div class="widget-content">
	    <? if($is_edit){
				echo "<input type='hidden' id='first_focus' value='title'>";
			}else{
				echo "<input type='hidden' id='first_focus' value='title'>";
			}
	 	?>



        <? if($is_edit){ echo"<input type=\"hidden\" name=\"page_id\" id=\"page_id\" value=\"".$pageDetails['page_id']."\">";}?>
        <!-- .field-group -->
        <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="title">Title<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
            	<input type="text" name="title" id="title" size="32" value="<? if($is_edit || $is_exist) echo $pageDetails['title'];?>">
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="page_name">Name<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
	            <input type="text" name="page_name" id="page_name" size="32" value="<? if($is_edit || $is_exist) echo $pageDetails['page_name'];?>">
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="description">Desc.<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
				<input type="text" name="description" id="description" size="32" value="<? if($is_edit || $is_exist) echo $pageDetails['description'];?>">
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group" id="level_div">
			<div class="field_label"><label class='lbl_new'  for="level">Level<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
                <select id="level" name="level">
                    <option value="0">Please Select</option>
                <? $selected="";
                if($is_edit || $is_exist){$selected=$pageDetails['level'];} 
                for($i=0;$i<count($PAGE_LEVELS);$i++){
                    echo "<option value=\"".$PAGE_LEVELS[$i]."\"";
                    if($PAGE_LEVELS[$i]==$selected){
                        echo "selected=\"selected\"";
                    }
                    echo " >".$PAGE_LEVELS[$i]."</option>";
                }
                ?>
                </select>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->        
         <div class="field-group" id="parent_page_id_div" <? if(!$show_parent_page_div){ echo "style=\"display:none;\""; }?> >
			<div class="field_label"><label class='lbl_new'  for="parent_page_id">Parent Page<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
				<? if($is_edit || $is_exist){createComboBox('parent_page_id','page_id','title', $allParentPages, true,$pageDetails['parent_page_id']);} 
                else{ echo "<select id=\"parent_page_id\" disabled=\"disabled\" name=\"parent_page_id\">
                                <option value=\"0\">Loading...</option>
                            </select>";}?>
            </div>
			<div class="clr"></div>
     	</div>
         
        <!-- .field-group -->
        <div class="field-group">
			<div class="field_label"><label class='lbl_new'  for="tab_order">Tab Order<span class="required">*</span></label></div>
            <div class="colon">:</div>
			<div class="field_value">
            	<input type="text" name="tab_order" id="tab_order" size="5" value="<? if($is_edit || $is_exist) echo $pageDetails['tab_order'];?>">
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        
       <br />
       <? if($is_exist){echo "
       <div class=\"errordiv\">
			<span>
			   Same page Exist!
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
            <input type="button" onClick="<? if($is_edit && ! $is_copy){echo "validatePageFields('manage_pages.php','edit_page_entry');";}else{echo "validatePageFields('manage_pages.php','add_page');";}?>" class="btn btn-grey" value="Save Data" /> &nbsp;&nbsp;&nbsp;
			<? if(!$is_edit || $is_copy){?>
                <input type="button" class="btn btn-grey" value="Add More" onClick="validatePageFields('manage_pages.php','add_more');"/> &nbsp;&nbsp;&nbsp;
            <? }?>
            <input type="button" class="btn btn-grey" value="Cancel"  onClick="callPage('manage_pages.php');"/>
            <div><span class="required">*</span> required</div>
        </div>
        <!-- .actions -->

    </div>
    <!-- .widget-content --> 
    
  </div>
  <!-- .widget --> 
  
</div>
