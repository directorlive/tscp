<div class="grid-24" id="add_new_client">
  <div class="widget">
    <div style="float:right;padding-right: 11px;font-weight: bolder;">
			<a href="#" id="contact_form_call" style="padding:5px;">Call</a>
	</div>    
    <!-- .widget-header -->  
    <div class="widget-content">
        <!-- .field-group -->
        <input type="hidden" name='contact_id' id="contact_id" />
        <div class="field-group">
        	<h4>Client Details</h4>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="FirstName">First Name</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <select id="Salutation" name="Salutation" title="Salutation"  style="width:32%;">
                        <option value="">--None--</option>
                        <option value="Mr.">Mr.</option>
                        <option value="Ms.">Ms.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Dr.">Dr.</option>
                        <option value="Prof.">Prof.</option>
                    </select> 
                    <input type="text" name="FirstName" id="FirstName" style="width:56%;" value="<? //if($is_edit || $is_exist) echo $pageDetails['FirstName'];?>">
                </div>
				<div class="field_value FirstName_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Phone">Phone</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="Phone" id="Phone" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['phone'];?>">
                </div>
				<div class="field_value Phone_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="LastName"><span class="required">*</span>Last Name</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="LastName" id="LastName" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['LastName'];?>">
                </div>
				<div class="field_value LastName_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="MobilePhone">Mobile</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="MobilePhone" id="MobilePhone" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['MobilePhone'];?>">
                </div>
				<div class="field_value MobilePhone_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -- >
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="AccountId"><span class="required">*</span>Account Name</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="AccountId" id="AccountId" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['title'];?>">
                </div>
				<div class="field_value AccountName_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="ReportsToId">Reports To</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="ReportsToId" id="ReportsToId" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['email'];?>">
                </div>
				<div class="field_value ReportsToId_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
         
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Title">Title</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="Title" id="Title" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['Title'];?>">
                </div>
				<div class="field_value Title_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Email">Email</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="Email" id="Email" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['Email'];?>">
                </div>
				<div class="field_value Email_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Type__c">Type</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
					<select id="Type__c" name="Type__c">
					<option value="">--None--</option>
					<option value="Customer">Customer</option>
					<option value="Franchisee">Franchisee</option>
					<option value="Partner">Partner</option>
					<option value="Interactive80">Interactive80</option>
					<option value="i80Graffiti">i80Graffiti</option>
					</select>
                   <!-- <input type="text" name="RecordTypeId" id="RecordTypeId" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['RecordTypeId'];?>"> -->
                </div>
				<div class="field_value Type__c_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        <!-- .field-group -->
		<div class="field-group">
        	<h4>Address Information<a href="#" onclick="copyAddress()" style="float: right;">Copy Mailing Address to Other Address</a></h4>
			
        </div>
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="MailingStreet">Mailing Street</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="MailingStreet" id="MailingStreet" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['MailingStreet'];?>">
                </div>
				<div class="field_value MailingStreet_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="OtherStreet">Other Street</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="OtherStreet" id="OtherStreet" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['OtherStreet'];?>">
                </div>
				<div class="field_value OtherStreet_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="MailingCity">Mailing City</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="MailingCity" id="MailingCity" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['MailingCity'];?>">
                </div>
				<div class="field_value MailingCity_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="OtherCity">Other City</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="OtherCity" id="OtherCity" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['OtherCity'];?>">
                </div>
				<div class="field_value OtherCity_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="MailingState">Mailing State/Province</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="MailingState" id="MailingState" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['MailingState'];?>">
                </div>
				<div class="field_value MailingState_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="OtherState">Other State/Province</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="OtherState" id="OtherState" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['OtherState'];?>">
                </div>
				<div class="field_value OtherState_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="title">Mailing Zip/Postal Code</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="MailingPostalCode" id="MailingPostalCode" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['MailingPostalCode'];?>">
                </div>
				<div class="field_value MailingPostalCode_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="email">Other Zip/Postal Code</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="OtherPostalCode" id="OtherPostalCode" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['OtherPostalCode'];?>">
                </div>
				<div class="field_value OtherPostalCode_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
         
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="MailingCountry">Mailing Country</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="MailingCountry" id="MailingCountry" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['MailingCountry'];?>">
                </div>
				<div class="field_value MailingCountry_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="report_to">Other Country</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="OtherCountry" id="OtherCountry" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['OtherCountry'];?>">
                </div>
				<div class="field_value OtherCountry_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        <!-- .field-group -->
		<div class="field-group">
        	<h4>Additional Information</h4>
        </div>
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Fax">Fax</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="Fax" id="Fax" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['Fax'];?>">
                </div>
				<div class="field_value Fax_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="LeadSource">Lead Source</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
					<select id="LeadSource" name="LeadSource">
					<option value="">--None--</option>
					<option value="Advertisement">Advertisement</option>
					<option value="Camp Expo">Camp Expo</option>
					<option value="Employee Referral">Employee Referral</option>
					<option value="Expo">Expo</option>
					<option value="External Referral">External Referral</option>
					<option value="Jewish Camp Expo">Jewish Camp Expo</option>
					<option value="Mobile Billboard">Mobile Billboard</option>
					<option value="NJEA Expo">NJEA Expo</option>
					<option value="Other">Other</option>
					<option value="Partner">Partner</option>
					<option value="PartyPop">PartyPop</option>
					<option value="Previous Event">Previous Event</option>
					<option value="PTA Expo">PTA Expo</option>
					<option value="PTO Today">PTO Today</option>
					<option value="Public Relations">Public Relations</option>
					<option value="Seminar - Internal">Seminar - Internal</option>
					<option value="Seminar - Partner">Seminar - Partner</option>
					<option value="Trade Show">Trade Show</option>
					<option value="Web">Web</option>
					<option value="Word of mouth">Word of mouth</option>
					</select>
                   <!-- <input type="text" name="LeadSource" id="LeadSource" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['LeadSource'];?>">  -->
                </div>
				<div class="field_value LeadSource_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="HomePhone">Home Phone</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="HomePhone" id="HomePhone" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['HomePhone'];?>">
                </div>
				<div class="field_value HomePhone_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Birthdate">Birthdate</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="Birthdate" id="Birthdate" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['Birthdate'];?>">
                </div>
				<div class="field_value Birthdate_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="OtherPhone">Other Phone</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="OtherPhone" id="OtherPhone" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['OtherPhone'];?>">
                </div>
				<div class="field_value OtherPhone_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Department">Department</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="Department" id="Department" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['Department'];?>">
                </div>
				<div class="field_value Department_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="AssistantName">Assistant</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="AssistantName" id="AssistantName" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['AssistantName'];?>">
                </div>
				<div class="field_value AssistantName_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>

			<div class="clr"></div>
        </div>
         
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="AssistantPhone">Asst. Phone</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="AssistantPhone" id="AssistantPhone" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['AssistantPhone'];?>">
                </div>
				<div class="field_value AssistantPhone_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        <!-- .field-group -->
		<div class="field-group">
        	<h4>Description Information</h4>
        </div>
        <!-- .field-group -->
        <div class="field-group">
            <div class="field_label"><label class='lbl_new'  for="MailingStreet">Description</label></div>
            <div class="colon">:</div>
            <div class="field_value inputbox">
                <textarea  name="Description" id="Description"></textarea>
<!--                <input type="text" name="Description" id="Description" size="32" value="< ? // if($is_edit || $is_exist) echo $pageDetails['Description'];?>"> -->
            </div>
            <div class="field_value Description_label labelbox" style="display:none;">
                <label class="value_label"></label>
            </div>
            <div class="clr"></div>
        </div>
		<div class="field-group">
        	<h4>Notes and Call Logs</h4>
        </div>
        <!-- .field-group -->
        <div class="field-group">
        	<div id="all_notes"></div>
            <div class="clr"></div>
        </div>
        <!-- .field-group -->
        <br />
		<div class="errordiv" style="display:none;">
			<span>
            </span>
       </div>
		<br />
        <div class="actions">
			<input type="button" onClick="validateContactFields('add');" id="save_contact" class="btn btn-grey" value="Save" /> &nbsp;&nbsp;&nbsp;
        	<input type="button" class="btn btn-grey" value="Cancel"  onClick="hideSidebarContent();"/>
        </div>
        <!-- .actions -->

    </div>
    <!-- .widget-content --> 
    
  </div>
  <!-- .widget --> 
  
</div>
<script type="text/javascript">

function hideSidebarContent(){
		$("#sidebar_content_div").fadeOut('slow',function(){
			$("#main_content_div").fadeIn();
		});
}

function copyAddress(){
	$("#OtherStreet").val($("#MailingStreet").val());
	$("#OtherCity").val($("#MailingCity").val());
	$("#OtherState").val($("#MailingState").val());
	$("#OtherPostalCode").val($("#MailingPostalCode").val());
	$("#OtherCountry").val($("#MailingCountry").val());
}
</script>
<? /*        
       <br />
       <? if($is_exist){echo "
       <div class=\"errordiv\">
			<span>
			   Contact Exist!
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
            <input type="button" onClick="<? if($is_edit && ! $is_copy){echo "validateContactFields('call_platform.php','edit_page_entry');";}else{echo "validatePageFields('manage_pages.php','add_page');";}?>" class="btn btn-grey" value="Save Data" /> &nbsp;&nbsp;&nbsp;
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
*/
?>