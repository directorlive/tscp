<script>
	$(document).ready(function(e){
		get_all_leads();
	});
	
	function get_all_leads(){
			if(navigator.onLine){
			  $.ajax({
				url:'library/ajax_files/get_all_leads.php',
				type:'POST',
				beforeSend:function(){
					$(".loading_message").html('Fetching All Leads...');
					$("#leadload").show();
					//showIncomingCall("Fetching Details",number);
					//$("#incoming_call_alert .phone_number").addClass('loading');
				},
				success:function(resp){
						$("#leadload").hide();
	
						var table_html= "<table class='table table-bordered table-striped data-table display leads_table'><thead><tr><th>Sr. No.</th><th>Name</th><th>Title</th><th class='email_col'>Email</th><th>LeadSource</th><th>Rating</th><th>Phone</th><th>Actions</th></tr></thead><tbody>";
						for(i=0;i<resp.length;i++ ) {
							table_html+="<tr><td>"+(i+1)+"</td><td><a href='#' onclick='show_lead_details(\""+resp[i].Id+"\")'>"+((resp[i].Name==null)?put_in_center("-"):resp[i].Name)+"</a></td><td>"+((resp[i].Title==null)?put_in_center("-"):resp[i].Title)+"</td><td class='email_col'>"+((resp[i].Email==null)?put_in_center("-"):resp[i].Email)+"</td><td>"+((resp[i].LeadSource==null)?put_in_center("-"):resp[i].LeadSource)+"</td><td>"+((resp[i].Rating==null)?put_in_center("-"):resp[i].Rating)+"</td><td>"+((resp[i].Phone==null)?put_in_center("-"):resp[i].Phone)+"</td><td><a href='#' onclick='call_lead(\""+resp[i].Name+"\",\""+resp[i].Phone+"\",\""+resp[i].Id+"\")'>Call</a></td></tr>";
						}
						table_html+="</tbody> </table>";
	
						$("#all_leads").html(table_html);
						convertToDataTables('.leads_table',new Object());
				}
			});
		}else{
			alert("Please Check your internet connection!");
		}
	}
	
	function show_lead_details(Id){
		if(navigator.onLine){
			$.ajax({
						url:'library/ajax_files/get_lead.php',
						type:'POST',
						data:'Id='+Id,
						beforeSend:function(){
							$(".loading_message").html('Fetching Lead details...');
							$("#leadload").show();
						},
						success:function(resp){
						$("#leadload").hide();
						//alert(typeof resp);
						if(typeof resp==="object"){
							if(typeof resp.lead_details[0]!=='undefined' && typeof resp.lead_details[0].errorCode!=="undefined"){
								if(resp.lead_details[0].errorCode==="NOT_FOUND"){
									if(confirm("Lead deleted from salesforce!\nDo you want to delete it from TSCP also?")){
										delete_lead(Id);
									}
								}
							}else{
								setLeadDefaultDetails(resp);
							}
						}else{
							alert("An error occured. Please Contact administrator!");
						}
					}
					/*{
							$("#leadload").hide();
							setLeadDefaultDetails(resp);
							toggleLeadForm(false);
						}*/
			});
		}else{
			alert("Please Check your internet connection!");
		}
	}
	
function delete_lead(id){
	if(navigator.onLine){
		$.ajax({
					url:'library/ajax_files/delete_lead.php',
					type:'POST',
					data:'id='+id,
					beforeSend:function(){
						$(".contact_loading_message").html('Deleting lead...');
						$("#contactload").show();
					},
					success:function(resp){
						$("#contactload").hide();
						get_all_leads();
					}
		});
	}else{
		alert("Please Check your internet connection!");
	}
}
</script>
<div class="grid-24">
  <div class="widget widget-table">
    <div class="widget-content">
         <div id="leadload" style="text-align:center;display:none; "> <img src="images/loading.gif" width="34"  height="34"/><br/>
			<span class="loading_message"><span>
        </div>
	    <div id="all_leads"></div>
    </div>
    <!-- .widget-content --> 
    
  </div>
</div>