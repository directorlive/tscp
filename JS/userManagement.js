//Manthan Tripathi - 23/08/2012
//To put the user management code seperate to use again.
$(document).ready(function(){

	//Manthan Tripathi - 23/08/2012
	//To display the dropdown of parent pages if current level of page is either 2 or 3
	$("#level_div select").change(function(){
		var level=$(this).find(":selected").val();
		var div_id="#parent_page_id_div";//ID of the div which has the child element.
		if(parseInt(level)==2 || parseInt(level)==3){
			level=parseInt(level);
			level--;
			$(div_id).show();
			getPagesOfLevel(level,div_id);
		}else{
			$(div_id).hide();
		}
	});
	
	//Manthan Tripathi - 25/08/2012
	//In user permissoin tree, to display subtree on click of parent
	$(".closed_child_pages,.opened_child_pages").click(function(){
		$(this).parent().find(">ol").slideToggle();
		$(this).toggleClass("closed_child_pages");
		$(this).toggleClass("opened_child_pages");	
	});
	
	//Manthan Tripathi - 25/08/2012
	//In user permissoin tree, to select subtree on select of parent
	$(".main_pages li input").click(function(){
		if($(this).is(":checked")){
			$(this).parent().find("ol li input").attr("checked","checked");
		}else{
			$(this).parent().find("ol li input").removeAttr("checked");
		}
	});

	//Manthan Tripathi - 25/08/2012
	//To check all pages checkbox on check event of check all checkbox
	$("#check_all_pages").click(function(){
		if($(this).is(":checked")){
			$(".main_pages").find("input").attr("checked","checked");
		}
	});
	
	//Manthan Tripathi - 25/08/2012
	//To uncheck all pages checkbox on click event of uncheck all link(It will ask for confirmation first)
	$("#uncheck_all_pages").click(function(){
		if(confirm("Are you sure you want to uncheck all the pages?")){
			$(".main_pages").find("input").removeAttr("checked");
			$("#check_all_pages").removeAttr("checked");
		}
		return false; 
	});

	//Manthan Tripathi - 27/08/2012
	//To check all groups checkbox on check event of check all checkbox
	$("#check_all_groups").click(function(){
		if($(this).is(":checked")){
			$(".groupsCheckboxes").find("input").attr("checked","checked");
		}
	});
	
	//Manthan Tripathi - 27/08/2012
	//To uncheck all groups checkbox on click event of uncheck all link(It will ask for confirmation first)
	$("#uncheck_all_groups").click(function(){
		if(confirm("Are you sure you want to uncheck all the groups?")){
			$(".groupsCheckboxes").find("input").removeAttr("checked");
			$("#check_all_groups").removeAttr("checked");
		}
		return false; 
	});
	
	//Manthan Tripathi - 04/09/2012
	//In user-company permissoin tree, to select subtree on select of parent
	$(".company_checkboxes li>input").click(function(){
		if($(this).is(":checked")){
			$(this).parent().find("ol li input").attr("checked","checked");
		}else{
			$(this).parent().find("ol li input").removeAttr("checked");
		}
	});
	
	
	//Manthan Tripathi - 04/09/2012
	//In user-company permissoin tree, to select subtree on click of intermediate checkbox
	$(".company_checkboxes>li>.intermediate_checkbox").click(function(){
		$(this).parent().find("input").attr("checked","checked");
		hideIntermediate($(this).parent());
	});
	
	//Manthan Tripathi - 04/09/2012
	//In user-company permissoin tree, to deselect parent if Any one of child is not selected
	$(".company_checkboxes>li>ol>li>input").click(function(){
		if(!$(this).is(":checked")){
			var parent_li=$(this).parent().parent().parent();
			var none_selected=true;
			$(this).parent().parent().find("li input").each(function(){
				if($(this).is(":checked")){
					none_selected=false;
				}				
			});
			if(none_selected){
				hideIntermediate(parent_li);
				parent_li.find(">input").removeAttr("checked");
			}else{
				showIntermediate(parent_li);
			}
		}else{
			var parent_li=$(this).parent().parent().parent();
			var all_selected=true;
			$(this).parent().parent().find("li input").each(function(){
				if(!$(this).is(":checked")){
					all_selected=false;
				}
			});
			if(all_selected){
				hideIntermediate(parent_li);
				parent_li.find(">input").attr("checked","checked");
			}else{
				showIntermediate(parent_li);
			}
		}
	});

	
	//Manthan Tripathi - 04/09/2012
	//In user-company permissoin tree, to select parent if all of child are selected in initialization
	$(".company_checkboxes>li>ol>li>input").each(function(){
		if($(this).is(":checked")){
			var parent_li=$(this).parent().parent().parent();
			var all_selected=true;
			$(this).parent().parent().find("li input").each(function(){
				if(!$(this).is(":checked")){
					all_selected=false;
				}				
			});
			if(all_selected){
				parent_li.find("input").attr("checked","checked");
			}else{
				showIntermediate(parent_li);
			}
		}
	});
	
	//Manthan Tripathi - 04/09/2012
	//To check all companies checkbox on check event of check all checkbox
	$("#check_all_companies").click(function(){
		if($(this).is(":checked")){
			$(".company_checkboxes").find("input").attr("checked","checked");
		}
	});
	
	//Manthan Tripathi - 04/09/2012
	//To uncheck all companies checkbox on click event of uncheck all link(It will ask for confirmation first)
	$("#uncheck_all_companies").click(function(){
		if(confirm("Are you sure you want to uncheck all the companies?")){
			$(".company_checkboxes").find("input").removeAttr("checked");
			$("#check_all_companies").removeAttr("checked");
		}
		return false; 
	});

});



//Manthan Tripathi - 23/08/2012
//generalized method to get pages of perticular level with AJAX.
//level is number of which we want to get pages
//div_id is jquery selector of the div(or any other element) to which child select belongs.
function getPagesOfLevel(level,div_id){
	if(navigator.onLine){
		$.ajax({
			url:"library/ajax_files/get_all_pages_of_level.php",
			type:"POST",
			data:"level="+level,
			beforeSend:function(){
					$(div_id+" select").html("<option value=\"0\">Loading...</option>");
					$(div_id+" select").attr("disabled","disabled");
				},
			success:function(resp){
				//resp=JSON.parse(resp);
				var page_html="<option value=\"0\">Please Select</option>";
				for(var i=0;i<resp.pages.length;i++){
					page_html+="<option value=\""+ resp.pages[i].page_id+"\">"+ resp.pages[i].title +"</option>";
				}
				$(div_id+" select").html(page_html);
				$(div_id+" select").removeAttr("disabled");
			}
		});
	}else{
		alert("Please Check your internet connection!");
	}
}


//Manthan Tripathi - 23/08/2012
//to edit page details
function editPage(page_id){
	$("#page_id").val(page_id);
	$('#page').val('manage_pages.php');
	$('#function').val('edit_page');
	$('#mainForm').submit();
	
}

//Manthan Tripathi - 23/08/2012
//to copy page details
function copyPage(page_id){
	$("#page_id").val(page_id);
	$('#page').val('manage_pages.php');
	$('#function').val('copy_page');
	$('#mainForm').submit();
	
}

//to delete user details
function deletePage(page_id){
	if(confirm("Are you sure you want to delete page?")){
		$("#page_id").val(page_id);
		$('#page').val('manage_pages.php');
		$('#function').val('delete_page');
		$('#mainForm').submit();
	}
}


//Manthan Tripathi - 23/08/2012
//to validate page fields
function validatePageFields(page, func)
{
	$(".errordiv").hide();
	var allClear = 1;
	if($('#title').val() == "")
	{
		$('.errordiv>span').html("Page Title is required!");
		allClear = 0;
	}else if($('#page_name').val() == "")
	{
		$('.errordiv>span').html("Page name is required!");
		allClear = 0;
	}else if($('#level').val() == 0)
	{
		$('.errordiv>span').html("Level is required!");
		allClear = 0;
	}
	else if($('#tab_order').val() == "")
	{
		$('.errordiv>span').html("Tab order is required!");
		allClear = 0;
	}else if($('#description').val() == "")
	{
		$('.errordiv>span').html("Description is required!");
		allClear = 0;
	}
	else if(!$('#parent_page_id_div').is(":hidden"))
	{
		if($('#parent_page_id').val() == 0)
		{
			$('.errordiv>span').html("Parent Page is required!");
			allClear = 0;
		}
	}

	if(allClear == 1){
		$("#parent_page_id").removeAttr("disabled");
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}else{
		$(".errordiv").slideDown();	
	}
}


//Manthan Tripathi - 24/08/2012
//to edit group details
function editGroup(group_id){
	$("#group_id").val(group_id);
	$('#page').val('manage_groups.php');
	$('#function').val('edit_group');
	$('#mainForm').submit();
	
}

//Manthan Tripathi - 24/08/2012
//to edit group details
function copyGroup(group_id){
	$("#group_id").val(group_id);
	$('#page').val('manage_groups.php');
	$('#function').val('copy_group');
	$('#mainForm').submit();
	
}

//to delete user details
function deleteGroup(group_id){
	if(confirm("Are you sure you want to delete group?")){
		$("#group_id").val(group_id);
		$('#page').val('manage_groups.php');
		$('#function').val('delete_group');
		$('#mainForm').submit();
	}
}

//Manthan Tripathi - 23/08/2012
//to validate group fields
function validateGroupFields(page, func)
{
	var allClear = 1;
	if($('#group_name').val() == "")
	{
		$('.errordiv>span').html("Group name is required!");
		allClear = 0;
	}
	else if($('#landing_page').val() == 0)
	{
		$('.errordiv>span').html("Landing page is required!");
		allClear = 0;
	}
	else if($('#comments').val() == "")
	{
		$('.errordiv>span').html("comments are required!");
		allClear = 0;
	}

	if(allClear == 1)
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}else{
		$(".errordiv").slideDown();	
	}
}



//Manthan Tripathi - 25/08/2012
//to edit user details
function editUser(user_id){
	$("#user_id").val(user_id);
	$('#page').val('manage_users.php');
	$('#function').val('edit_user');
	$('#mainForm').submit();
	
}

//Manthan Tripathi - 25/08/2012
//to edit user details
function copyUser(user_id){
	$("#user_id").val(user_id);
	$('#page').val('manage_users.php');
	$('#function').val('copy_user');
	$('#mainForm').submit();
	
}

//to delete user details
function deleteUser(user_id){
	if(confirm("Are you sure you want to delete user?")){
		$("#user_id").val(user_id);
		$('#page').val('manage_users.php');
		$('#function').val('delete_user');
		$('#mainForm').submit();
	}
}

//Manthan Tripathi - 25/08/2012
//to validate user fields
function validateUserFields(page, func)
{
	var allClear = 1;
	if($('#user_name').val() == "")
	{
		$('.errordiv>span').html("User name is required!");
		allClear = 0;
	}
	else if($('#user_password').val() == "")
	{
		$('.errordiv>span').html("Password is required!");
		allClear = 0;
	}
	else if($('#reenter_password').val() != $('#user_password').val())
	{
		$('.errordiv>span').html("Password doesn't match!");
		allClear = 0;
	}
	else if($('#name').val() == "")
	{
		$('.errordiv>span').html("Name is required!");
		allClear = 0;
	}
	else if($('#user_email').val() == "")
	{
		$('.errordiv>span').html("E-mail ID is required!");
		allClear = 0;
	}
	else if($('#user_phone').val() == "")
	{
		$('.errordiv>span').html("Phone number is required!");
		allClear = 0;
	}
	else if($('#user_group').val() == 0)
	{
		$('.errordiv>span').html("User group is required!");
		allClear = 0;
	}
	
	if(allClear == 1)
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}else{
		$(".errordiv").slideDown();	
	}
}

//Manthan Tripathi- 04/09/2012
//Function to show intermediate checkbox
function showIntermediate(this_li){
	this_li.find(".intermediate_checkbox").show();
	this_li.find(".top_check").hide();
}

//Manthan Tripathi- 04/09/2012
//Function to hide intermediate checkbox
function hideIntermediate(this_li){
	this_li.find(".intermediate_checkbox").hide();
	this_li.find(".top_check").show();
}