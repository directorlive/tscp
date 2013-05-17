// JavaScript Document
function submitenter(myfield,e)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	
	if (keycode == 13)
	   {
	   myfield.form.submit();
	   return false;
	   }
	else
	   return true;
}

function callPage(page)
{
	if(page != "")
	{
		document.getElementById('page').value = page;
		document.getElementById('mainForm').submit();
	}
}

function addNewGroup()
{
	if($('#group_name').val() == "")
	{
		alert("Please Enter A Group Name");
	}
	else if($('#group_comments').val() == "")
	{
		alert("Please Enter Group Comments");
	}
	else if($('#landing_page').val() == "")
	{
		alert("Please Enter the Groups Landing Page");
	}
	else
	{
		$('#page').val('manage_groups.php');
		$('#function').val('addnewgroup');
		$('#mainForm').submit();
	}
}

function addUser(page, func)
{
	if($('#user_name').val() == "")
	{
		alert("Please Enter A User Name");
	}
	else if($('#password').val() == "")
	{
		alert("Please Enter Password");
	}
	else if($('#full_name').val() == "")
	{
		alert("Please Enter the User's Full Name");
	}
	else if($('#email').val() == "")
	{
		alert("Please Enter the Email Id");
	}
	else if($('#user_phone_number').val() == "")
	{
		alert("Please Enter the User's Phone Number");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function addADUser(page, func)
{
	if($('#userName').val() == "")
	{
		alert("Please Enter A User Name");
	}
	else if($('#displayName').val() == "")
	{
		alert("Please Enter a Display Name");
	}
	else if($('#userMail').val() == "")
	{
		alert("Please Enter the Email Id");
	}
	else if($('#userPhone').val() == "")
	{
		alert("Please Enter the User's Phone Number");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}


function clearUserFields(header)
{
	$('#popHeaderSpn').html(header);
	$('#user_name').val("");
	$('#full_name').val("");
	$('#user_id').val("");
	$('#email').val("");
	$('#user_phone_number').val("");
	document.getElementById('editUser').style.display = "none";
	document.getElementById('addUser').style.display = "";	
}

function clearPhoneFields(header)
{
	$('#popHeaderSpn').html(header);
	$('#phone_number').val("");
	document.getElementById('editNumber').style.display = "none";
	document.getElementById('addNumber').style.display = "";	
}

function setEditAssignedEmployee(id,ph_number,user)
{
	$('#phone_number').val(ph_number);
	$('#on_call_emp').val(user);
	$('#ph_id').val(id);
}

function setEditUser(id, uname, full_name, email, phone)
{
	$('#popHeaderSpn').html('Edit User Details');
	$('#user_name').val(uname);
	$('#full_name').val(full_name);
	$('#user_id').val(id);
	$('#email').val(email);
	$('#user_phone_number').val(phone);
	document.getElementById('addUser').style.display = "none";
	document.getElementById('editUser').style.display = "";
}

function setEditPhone(id,ph_number,text_message)
{	
	$('#popHeaderSpn').html('Edit Phone Settings');
	$('#phone_number').val(ph_number);
	$('#text_message').val(text_message);
	
	$('#ph_id').val(id);
	document.getElementById('addNumber').style.display = "none";
	document.getElementById('editNumber').style.display = "";
}

function changePhoneEmployee(page, func)
{
	if($('#phone_number').val() == "")
	{
		alert("Please Select A Phone Number.");
	}
	else if($('#on_call_emp').val() == "")
	{
		alert("Please select an On-Call-Employee.");
	}
	else if($('#ph_id').val() == "")
	{
		alert("Please Select a phone number to Edit.");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function editNumber(page, func)
{
	if($('#phone_number').val() == "")
	{
		alert("Please Enter A Phone Number.");
	}
	else if($('#text_message').val() == "")
	{
		alert("Please Enter the Text Reply to be sent to the User.");
	}
	else if($('#ph_id').val() == "")
	{
		alert("Please Select a phone number to Edit.");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function editUser(page, func)
{
	if($('#user_name').val() == "")
	{
		alert("Please Enter A User Name.");
	}
	else if($('#password').val() == "")
	{
		alert("Please Enter Password.");
	}
	else if($('#full_name').val() == "")
	{
		alert("Please Enter the User's Full Name.");
	}
	else if($('#email').val() == "")
	{
		alert("Please Enter the Email Id");
	}
	else if($('#user_phone_number').val() == "")
	{
		alert("Please Enter the User's Phone Number");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function deleteUser(id,uname,page)
{
	if(confirm("Do you really want to delete the User: "+uname))
	{	$('#user_id').val(id);
		$('#page').val(page);
		$('#function').val('deleteuser');
		$('#mainForm').submit();
	}
}

function deletePhone(id,phone,page)
{
	if(confirm("Do you really want to delete the Phone Number: "+phone))
	{	$('#ph_id').val(id);
		$('#page').val(page);
		$('#function').val('deletephone');
		$('#mainForm').submit();
	}
}

function addNumber(page, func)
{
	if($('#phone_number').val() == "")
	{
		alert("Please Enter A Phone Number.");
	}
	else if($('#phone_number').val().length < 10)
	{
		alert("Phone Number must be 10 digits in length.");
	}
	else if($('#admin_user').val() == "")
	{
		alert("Please Select an Admin user to Manage the number.");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function viewHistory(id,page,func)
{
		$('#ph_history').val(id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
}

function userLogout()
{
	$('#page').val('home.php');
	$('#function').val('logout');
	$('#mainForm').submit();
}

function changeLanguage()
{
	$('#page').val('home.php');
	$('#function').val('language_change');
	$('#mainForm').submit();
}

function updateSettings(page, func)
{
	if(confirm("Confirm settings change! Incorrect Settings will cause the App to stop working!!"))
	{	
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function searchTwiNum()
{
	var inp = $('#pattern').val();
	if(inp.length >= 3)
	{
		if(isNaN(inp))
		{
			alert("Please enter only Numbers");
			 $('#pattern').val('')
		}
		else
		{
			getData('buyNewPhone.php?stat=2&sample='+inp, 'ajaxResponse');
		}
	}
}

function searchForUser()
{
	var inp = $('#srchusername').val();
	if(inp.length > 1)
	{
			getData('searchForUser.php?stat=2&sample='+inp, 'ajaxResponse');
	}
	else
	{
		alert("Please enter a userName");
		 $('#pattern').val('')
	}
}


function buyNumber(num, page, func)
{
	if(confirm("Do you really want to buy number " +num+ "? Changes would be Ir-reversible!"))
	{
		$('#new_phone_number').val(num);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function setTranscription(value)
{
	$('#callTranscriptionDiv').html(value);
}

function phoneMgmtChng(page, func)
{
	var phone_num = $('#phone_number').val();
	var user =  $('#admin_user').val();
	
	var url = page + "?func="+func+"&phone_number="+phone_num+"&admin_user="+user;
	
	getData(url, 'phoneAdminsSpn');
	
}

function ajaxFileUpload()
	{
		$.ajaxFileUpload
		(
			{
				url:'doajaxfileupload.php',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							alert(data.msg);
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

	}
	
function validateLeadFields(save_type){
	$(".errordiv").hide();	
	var allClear = 1;
	if($('#FirstName').val() == '')
	{
		$('.errordiv>span').html("First name is required!");
		allClear = 0;
	}else if($('#LastName').val() == '')
	{
		$('.errordiv>span').html("Last name is required!");
		allClear = 0;
	}
	else if($('#Company').val() == '')
	{
		$('.errordiv>span').html("Company is required!");
		allClear = 0;
	}
/*	else if($('#Birthday__c').val() == '')
	{
		$('.errordiv>span').html("Birthday is required!");
		allClear = 0;
	}*/

	if(allClear == 1)
	{
/*		$('#page').val('call_platform.php');
		$('#function').val('save_lead_'+save_type);
		$('#mainForm').submit();*/
		var fields=new Array("Accept_the_Guest_Waiver__c","Street","City","State","PostalCode","Country","Birthday__c","ParentFirstName__c","ParentLastName__c","Company","Description","Email","Industry","LeadSource","Status","Salutation","FirstName","LastName","Phone","Rating","Title","Website","Type__c",'lead_id');
		var datastr="";
		for(var i=0;i<fields.length;i++){
			if(fields[i]=="Birthday__c" && parseISO8601($("#"+fields[i]).val())=='Invalid Date'){
				continue;
			}
			datastr+=fields[i]+"="+urlEncode($("#"+fields[i]).val())+"&";
		}
		datastr+="type="+save_type;
//		alert(datastr);return false;
		if(navigator.onLine){
			$.ajax({
				url:"library/ajax_files/save_lead.php",
				data:datastr,
				type:"POST",
				async:false,
				success:function(resp){
					alert(resp);
				}
			});
		}else{
			alert("Please Check your internet connection!");
		}
		return false;
	}else{
		$(".errordiv").slideDown();	
	}
}
function urlEncode(str){
	str=str.replace(/&/g,"%26");
	str=str.replace(/'/g,"%27");
	str=str.replace(/"/g,"%22");
	return str;
}
function validateContactFields(save_type){
	$(".errordiv").hide();	
	var allClear = 1;
	if($('#FirstName').val() == '')
	{
		$('.errordiv>span').html("First name is required!");
		allClear = 0;
	}else if($('#LastName').val() == '')
	{
		$('.errordiv>span').html("Last name is required!");
		allClear = 0;
	}
	else if($('#Company').val() == '')
	{
		$('.errordiv>span').html("Company is required!");
		allClear = 0;
	}
/*	else if($('#Birthday__c').val() == '')
	{
		$('.errordiv>span').html("Birthday is required!");
		allClear = 0;
	}*/

	if(allClear == 1)
	{
		var fields=new Array("FirstName","MobilePhone","LastName","Email","Title","MailingStreet","OtherStreet","MailingCity","OtherCity","MailingState","OtherState","MailingPostalCode","OtherPostalCode","MailingCountry","OtherCountry","Fax","HomePhone","Birthdate","OtherPhone","Department","AssistantName","AssistantPhone","Description","LeadSource","Type__c","Salutation","Phone",'contact_id');
		var datastr="";
		for(var i=0;i<fields.length;i++){
			if(fields[i]=="Birthdate" && parseISO8601($("#"+fields[i]).val())=='Invalid Date'){
				continue;
			}
			datastr+=fields[i]+"="+urlEncode($("#"+fields[i]).val())+"&";
		}
		datastr+="type="+save_type;
//		alert(datastr);return false;
		if(navigator.onLine){
			$.ajax({
				url:"library/ajax_files/save_contact.php",
				data:datastr,
				type:"POST",
				async:false,
				success:function(resp){
					alert(resp);
				}
			});
		}else{
			alert("Please Check your internet connection!");
		}
		return false;
//		$('#page').val('call_platform.php');
//		$('#function').val('save_contact_'+save_type);
//		$('#mainForm').submit();
	}else{
		$(".errordiv").slideDown();	
	}
}

$(document).ready(function(e) {
	convertToDatePicker('.date_picker');
	convertToDataTables('.data-table',new Object());
});
function convertToDataTables(selector,options_obj){
	if(typeof options_obj.iDisplayLength==="undefined"){
		options_obj.iDisplayLength=15;
	}
	if(typeof options_obj.aLengthMenu==="undefined"){
		options_obj.aLengthMenu=[[15, 25, 50, 100, -1], [15, 25, 50, 100, "All"]];
	}
	if(typeof options_obj.sPaginationType==="undefined"){
		options_obj.sPaginationType="full_numbers";
	}
	if(typeof options_obj.oLanguage==="undefined"){
		options_obj.oLanguage={"sLengthMenu": "Show:_MENU_"};
	}

	$(selector).dataTable(options_obj);
}
function convertToDatePicker(selector){
	$(selector).datepicker({
			dateFormat: "d M, yy",
			altField: ".date_picker_alt",
			altFormat: "yy-mm-dd"
	});
}
function setDatepickerDate(selector,date_to_set,alt_selector){
	if(date_to_set!==null){
		$(selector).datepicker('setDate', parseISO8601(date_to_set));
		if(alt_selector!==null){
			$(alt_selector).val(date_to_set);
		}
	}
}
function parseISO8601(dateStringInRange) {
    var isoExp = /^\s*(\d{4})-(\d\d)-(\d\d)\s*$/,
        date = new Date(NaN), month,
        parts = isoExp.exec(dateStringInRange);

    if(parts) {
      month = +parts[2];
      date.setFullYear(parts[1], month - 1, parts[3]);
      if(month != date.getMonth() + 1) {
        date.setTime(NaN);
      }
    }
    return date;
}
function toggleLeadForm(hideForm){
	if(hideForm===true){
		$("#add_lead_form").fadeOut('fast',function(){
			$("#main_content_div").fadeIn();
		});
	}else{
		$("#main_content_div").fadeOut('fast',function(){
			$("#add_lead_form").fadeIn();
		});
	}
}
function setPageTitle(title){
	$("#page_title").html(title);
}
function put_in_center(str){
	return "<div style='text-align:center;'>"+str+"</div>";
}