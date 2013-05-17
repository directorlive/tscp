<div class="grid-24" id="add_lead_form">
  <div class="widget">
    <div style="float:right;padding-right: 11px;font-weight: bolder;">
			<a href="#" id="lead_form_call" style="padding:5px;">Call</a>
	</div>
    <!-- .widget-header -->  
    <div class="widget-content">
    	<input type="hidden" name='lead_id' id="lead_id" />
        <!-- .field-group -->
        <div class="field-group">
        	<h4>Lead Information</h4>
        </div>
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Type__c">Type</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <select id="Type__c" name="Type__c">
                    	<option value="">--None--</option>
                        <option value="EarnNBurn">EarnNBurn</option>
                        <option value="Gamin Ride">Gamin Ride</option>
                        <option value="Glamour Ride">Glamour Ride</option>
                        <option value="iDance">iDance</option>
                        <option value="i80 Party">i80 Party</option>
                        <option value="i80 Business">i80 Business</option>
                    </select>
                </div>
				<div class="field_value Type__c_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Status"><span class="required">*</span>Lead Status</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
					<select id="Status" name="Status">
                    	<option value="Contacted">Contacted</option>
                        <option value="Open" selected="selected">Open</option>
                        <option value="Qualified">Qualified</option>
                        <option value="Unqualified">Unqualified</option>
                    </select>
                </div>
				<div class="field_value Status_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
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
                    <input type="text" name="Phone" id="Phone" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['MobilePhone'];?>">
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
                <div class="field_label"><label class='lbl_new'  for="Company"><span class="required">*</span>Company Name</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="Company" id="Company" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['Company'];?>">
                </div>
				<div class="field_value Company_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Rating">Rating</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <select id="Rating" name="Rating">
                    	<option value="">--None--</option>
                        <option value="Hot">Hot</option>
                        <option value="Warm">Warm</option>
                        <option value="Cold">Cold</option>
                    </select>
                </div>
				<div class="field_value Rating_label labelbox" style="display:none;">
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
			<div class="clr"></div>
        </div>
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Birthday__c">Birthday</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="Birthday__c_show" id="Birthday__c_show" size="32" class="date_picker" value="<? //if($is_edit || $is_exist) echo $pageDetails['Birthday__c'];?>">
                    <input type="hidden" name="Birthday__c" id="Birthday__c" class="date_picker_alt">
                </div>
				<div class="field_value Birthday__c_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        <!-- .field-group -->
		<div class="field-group">
        	<h4>Address Information</h4>
        </div>
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Street">Street</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="Street" id="Street" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['Street'];?>">
                </div>
				<div class="field_value Street_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Website">Website</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="Website" id="Website" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['OtherStreet'];?>">
                </div>
				<div class="field_value Website_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="City">City</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="City" id="City" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['City'];?>">
                </div>
				<div class="field_value City_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="State">State/Province</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="State" id="State" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['State'];?>">
                </div>
				<div class="field_value State_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="title">Zip/Postal Code</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="PostalCode" id="PostalCode" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['PostalCode'];?>">
                </div>
				<div class="field_value PostalCode_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
         
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Country">Country</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="Country" id="Country" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['Country'];?>">
                </div>
				<div class="field_value Country_label labelbox" style="display:none;">
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
               <!-- <div class="field_label"><label class='lbl_new'  for="NumberOfEmployees">No. of Employees</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="NumberOfEmployees" id="NumberOfEmployees" size="32" value="<? // if($is_edit || $is_exist) echo $pageDetails['NumberOfEmployees'];?>">
                </div>
				<div class="field_value NumberOfEmployees_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div> -->
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
<!--                <div class="field_label"><label class='lbl_new'  for="AnnualRevenue">Annual Revenue</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="AnnualRevenue" id="AnnualRevenue" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['HomePhone'];?>">
                </div>
				<div class="field_value AnnualRevenue_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>-->
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="Industry">Industry</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <select id="Industry" name="Industry">
                    	<option value="">--None--</option>
                    	<option value="Agriculture">Agriculture</option>
                    	<option value="Apparel">Apparel</option>
                    	<option value="Banking">Banking</option>
                    	<option value="Biotechnology">Biotechnology</option>
                    	<option value="Chemicals">Chemicals</option>
                    	<option value="Communications">Communications</option>
                    	<option value="Construction">Construction</option>
                    	<option value="Consulting">Consulting</option>
                    	<option value="Education">Education</option>
                    	<option value="Electronics">Electronics</option>
                    	<option value="Energy">Energy</option>
                    	<option value="Engineering">Engineering</option>
                    	<option value="Entertainment">Entertainment</option>
                    	<option value="Environmental">Environmental</option>
                    	<option value="Finance">Finance</option>
                    	<option value="Food &amp; Beverage">Food &amp; Beverage</option>
                    	<option value="Government">Government</option>
                    	<option value="Healthcare">Healthcare</option>
                    	<option value="Hospitality">Hospitality</option>
                    	<option value="Insurance">Insurance</option>
                    	<option value="Machinery">Machinery</option>
                    	<option value="Manufacturing">Manufacturing</option>
                    	<option value="Media">Media</option>
                    	<option value="Not For Profit">Not For Profit</option>
                    	<option value="Other">Other</option>
                    	<option value="Recreation">Recreation</option>
                    	<option value="Retail">Retail</option>
                    	<option value="Shipping">Shipping</option>
                    	<option value="Technology">Technology</option>
                    	<option value="Telecommunications">Telecommunications</option>
                    	<option value="Transportation">Transportation</option>
                    	<option value="Utilities">Utilities</option>
                    </select>
                </div>
				<div class="field_value Industry_label labelbox" style="display:none;">
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
            <div class="field_label"><label class='lbl_new'  for="Description">Description</label></div>
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
        <!-- .field-group -->
		<div class="field-group">
        	<h4>RSVP</h4>
        </div>
        <!-- .field-group -->
        <div class="field-group">
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="ParentFirstName__c">Parent/Guardian First Name</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="ParentFirstName__c" id="ParentFirstName__c" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['ParentFirstName__c'];?>">
                </div>
				<div class="field_value ParentFirstName__c_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="field-group-half">
                <div class="field_label"><label class='lbl_new'  for="ParentLastName__c">Parent/Guardian Last Name</label></div>
                <div class="colon">:</div>
                <div class="field_value inputbox">
                    <input type="text" name="ParentLastName__c" id="ParentLastName__c" size="32" value="<? //if($is_edit || $is_exist) echo $pageDetails['ParentFirstName__c'];?>">
                </div>
				<div class="field_value ParentLastName__c_label labelbox" style="display:none;">
                    <label class="value_label"></label>
                </div>
                <div class="clr"></div>
            </div>
			<div class="clr"></div>
        </div>
        <div class="field-group">
            <div class="field_label"><label class='lbl_new'  for="Accept_the_Guest_Waiver__c">Accept the Guest Waiver</label></div>
            <div class="colon">:</div>
            <div class="field_value inputbox">
                <select id="Accept_the_Guest_Waiver__c" name="Accept_the_Guest_Waiver__c">
                    <option value="">--None--</option>
                    <option value="I AGREE &amp; ACCEPT THE GUEST AGREEMENT &amp; LIABILITY WAIVER">I AGREE &amp; ACCEPT THE GUEST AGREEMENT &amp; LIABILITY WAIVER</option>
                    <option value="I DISAGREE &amp; ACCEPT THE GUEST AGREEMENT &amp; LIABILITY WAIVER">I DISAGREE &amp; ACCEPT THE GUEST AGREEMENT &amp; LIABILITY WAIVER</option>
                </select>
            </div>
            <div class="field_value Accept_the_Guest_Waiver__c_label labelbox" style="display:none;">
                <label class="value_label"></label>
            </div>
            <div class="clr"></div>
        </div>
        <!-- .field-group -->
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
			<input type="button" onClick="validateLeadFields('add');" id="save_lead" class="btn btn-grey" value="Save" /> &nbsp;&nbsp;&nbsp;
        	<input type="button" class="btn btn-grey" value="Cancel"  onClick="hideSidebarContent();"/>
        </div>
        <!-- .actions -->

    </div>
    <!-- .widget-content --> 
    
  </div>
  <!-- .widget --> 
  
</div>
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