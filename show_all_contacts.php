	<script>
$(document).ready(function(e){
	get_all_contacts();
});
function get_all_contacts(){
	if(navigator.onLine){
		$.ajax({
					url:'library/ajax_files/get_all_contacts.php',
					type:'POST',
					
					beforeSend:function(){
						$(".contact_loading_message").html('Fetching All Contacts...');
						$("#contactload").show();
						//showIncomingCall("Fetching Details",number);
						//$("#incoming_call_alert .phone_number").addClass('loading');
					},
					success:function(resp){
							$("#contactload").hide();
							/*var table_html= "<table class='table table-bordered table-striped data-table display contact_table'><thead><tr><th>Sr. No.</th><th>Name</th><th class='email_col'>Email</th><th>LeadSource</th><th>Phone</th><th>MobilePhone</th><th>Actions</th></tr></thead><tbody>";
							//alert(resp[0].Id);
							for(i=0;i<resp.length;i++){
								table_html+="<tr><td>"+(i+1)+"</td><td><a href='#' onclick=\"show_contact_details('"+resp[i].Id+"');\">"+((resp[i].Name==null)?put_in_center("-"):resp[i].Name)+"</a></td><td class='email_col'>"+((resp[i].Email==null)?put_in_center("-"):resp[i].Email)+"</td><td>"+((resp[i].LeadSource==null)?put_in_center("-"):resp[i].LeadSource)+"</td><td>"+((resp[i].Phone==null)?put_in_center("-"):resp[i].Phone)+"</td><td>"+((resp[i].MobilePhone==null)?put_in_center("-"):resp[i].MobilePhone)+"</td><td><a href='#' onclick='call_lead(\""+resp[i].Name+"\",\""+resp[i].Phone+"\",\""+resp[i].Id+"\")'>Call</a></td></tr>";
							}
							table_html+="</tbody> </table>";*/
							
							//$.parseHTML(resp);
							$("#all_contacts").html(resp);
							convertToDataTables('.contact_table',new Object);
					},
					error:function(jqXHR,textStatus,errorThrown){
						alert(jqXHR+textStatus+errorThrown);
					}
		});
	}else{
			alert("Please Check your internet connection!");
	}
}
function show_contact_details(Id){
	if(navigator.onLine){
		$.ajax({
					url:'library/ajax_files/get_contact.php',
					type:'POST',
					data:'Id='+Id,
					beforeSend:function(){
						$(".contact_loading_message").html('Fetching contact details...');
						$("#contactload").show();
					},
					success:function(resp){
						$("#contactload").hide();
						//alert(typeof resp);
						if(typeof resp==="object"){
							if(typeof resp[0]!=='undefined' && typeof resp[0].errorCode!=="undefined"){
								if(resp[0].errorCode==="NOT_FOUND"){
									if(confirm("Contact deleted from salesforce!\nDo you want to delete it from TSCP also?")){
										delete_contact(Id);
									}
								}
							}else{
								setContactDefaultDetails(resp);
							}
						}else{
							alert("An error occured. Please Contact administrator!");
						}
					}
		});
	}else{
		alert("Please Check your internet connection!");
	}
}
function delete_contact(id){
	if(navigator.onLine){
		$.ajax({
					url:'library/ajax_files/delete_contact.php',
					type:'POST',
					data:'id='+id,
					beforeSend:function(){
						$(".contact_loading_message").html('Deleting contact...');
						$("#contactload").show();
					},
					success:function(resp){
						$("#contactload").hide();
						get_all_contacts();
					}
		});
	}else{
		alert("Please Check your internet connection!");
	}
}
</script>
<div class="grid-24">
  <div class="widget">
    
    <!-- .widget-header -->  
    <div class="widget-content">
		<div id="contactload" style="text-align:center;display:none; "> <img src="images/loading.gif" width="34"  height="34"/><br/>
			<span class="contact_loading_message"><span>
        </div>
        <div id="all_contacts"></div>
    </div>
    <!-- .widget-content --> 
    
  </div>
  <!-- .widget --> 
  
</div>