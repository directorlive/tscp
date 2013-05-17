<script>
	$(document).ready(function(e){
		get_all_available_agents();
		agent_checking=setInterval('get_all_available_agents()',5000);
	});
	function get_all_available_agents(){
		if(navigator.onLine){
			  $.ajax({
				url:'library/ajax_files/get_all_available_agents.php',
				type:'POST',
				beforeSend:function(){
					/*$(".loading_message").html('Fetching All Leads...');
					$("#leadload").show();*/
					//showIncomingCall("Fetching Details",number);
					//$("#incoming_call_alert .phone_number").addClass('loading');
				},
				success:function(resp){
						$("#agentload").hide();
	
						var table_html= "<table class='table table-bordered table-striped data-table display agents_table'><thead><tr><th>Sr. No.</th><th>Name</th><th>Availablility</th></tr></thead><tbody>";
						for(i=0;i<resp.length;i++) {
							table_html+="<tr><td>"+(i+1)+"</td><td>"+((resp[i].agent_name==null)?put_in_center("-"):resp[i].agent_name)+"</td><td>"+((parseInt(resp[i].is_available)===1)?"<div class='availability_true'></div>":"<div class='availability_false'></div>")+"</td></tr>";
						}
						table_html+="</tbody> </table>";
	
						$("#all_available_agents").html(table_html);
						//convertToDataTables('.leads_table',new Object());
				}
			});
		}else{
			alert("Please Check your internet connection!");
		}
	}
	
	
/*	function show_lead_details(Id){
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
						setLeadDefaultDetails(resp);
						toggleLeadForm(false);
					}
							
			
		});
	}*/
	
	
</script>
<div class="grid-24">
  <div class="widget widget-table">
    <div class="widget-content">
         <div id="agentload" style="text-align:center;"> <img src="images/loading.gif" width="34"  height="34"/><br/>
			<span class="loading_message">Loading all Agents...<span>
        </div>
	    <div id="all_available_agents"></div>
    </div>
    <!-- .widget-content --> 
    
  </div>
</div>