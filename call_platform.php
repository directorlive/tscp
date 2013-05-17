<?php
// @start snippet

//+15714140222

// client creds
//$accountSid = 'ACd4423401eb4a46b6ac290198c8b76e84';
//$authToken  = '67995a2618e468e5a79a48ab26f65493';
//$appSid = "APaac0112343ba7d2d36409a94b596c870"; 

//Test Sid And Token
//$accountSid = 'AC3d8e4e5cf91d8fb185eb132133a2030e';
//$authToken  = '84a9c08fa7ac56f364c98429d9d1d1a7';


// The app outgoing connections will use:
 /*
// The client name for incoming connections:
$clientName = "JohnSmith"; 
 
$capability = new Services_Twilio_Capability($accountSid, $authToken);
 
// This allows incoming connections as $clientName: 
$capability->allowClientIncoming($clientName);
 
// This allows outgoing connections to $appSid with the "From" 
// parameter being the value of $clientName 
$capability->allowClientOutgoing($appSid, array(), $clientName);
 
// This returns a token to use with Twilio based on 
// the account and capabilities defined above 
$app_token = $capability->generateToken();

*

include 'library/twilio/Twilio/Capability.php';
$twilio_creds=getTwlioCreds();
$token = new Services_Twilio_Capability($twilio_creds['sid'], $twilio_creds['auth_token']);
$token->allowClientOutgoing($twilio_creds['app_sid']);
$token->allowClientIncoming("John");
// @end snippet
?>
		<!-- @start snippet -->
		<script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){

			Twilio.Device.setup("<?php echo $token->generateToken();?>");
			connection=null;
			
			$("#call").click(function() {  
				params = { "tocall" : $('#tocall').val()};
				connection = Twilio.Device.connect(params);
			});
			$("#hangup").click(function() {  
				Twilio.Device.disconnectAll();
			});

			Twilio.Device.ready(function (device) {
				$('#status').text('Ready to start call');
			});

			Twilio.Device.incoming(function (conn) {
				if (confirm('Accept incoming call from ' + conn.parameters.From + '?')){
					connection=conn;
				    conn.accept();
				}
			});

			Twilio.Device.offline(function (device) {
				$('#status').text('Offline');
			});

			Twilio.Device.error(function (error) {
				$('#status').text(error);
			});

			Twilio.Device.connect(function (conn) {
				$('#status').text("Successfully established call");
				toggleCallStatus();
			});

			Twilio.Device.disconnect(function (conn) {
				$('#status').text("Call ended");
				toggleCallStatus();
			});
			
			function toggleCallStatus(){
				$('#call').toggle();
				$('#hangup').toggle();
				$('#dialpad').slideToggle();
			}

			$.each(['0','1','2','3','4','5','6','7','8','9','star','hash'], function(index, value) { 
		    	$('#button' + value).click(function(){ 
					if(connection) {
						if (value=='star')
							connection.sendDigits('*')
						else if (value=='hash')
							connection.sendDigits('#')
						else
							connection.sendDigits(value)
						return false;
					}else{
						if (value=='star')
							$("#tocall").val($("#tocall").val()+"*");
						else if (value=='hash')
							$("#tocall").val($("#tocall").val()+"#");
						else
							$("#tocall").val($("#tocall").val()+""+value);
					}
					});
			});


		});

		</script>
		<!-- @end snippet -->
		*/?>      
<script>
/*
         <div id="leadload" style="text-align:center;display:none; "> <img src="images/loading.gif" width="34"  height="34"/><br/>
        		<span class="loading_message"><span>
        </div>

	$(document).ready(function(e){
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
						
						if(resp.done){
							if(resp.totalSize>=1){
								var table_html= "<table class='table table-bordered table-striped data-table display'><thead><tr><th>Sr. No.</th><th>Name</th><th>Title</th><th class='email_col'>Email</th><th>LeadSource</th><th>Rating</th><th>Phone</th><th>Actions</th></tr></thead><tbody>";
								for(i=1;i<resp.totalSize;i++ ) {
									
									
									table_html+="<tr><td>"+i+"</td><td><a href='#' onclick='show_lead_details(\""+resp.records[i].Id+"\")'>"+((resp.records[i].Name==null)?put_in_center("-"):resp.records[i].Name)+"</a></td><td>"+((resp.records[i].Title==null)?put_in_center("-"):resp.records[i].Title)+"</td><td class='email_col'>"+((resp.records[i].Email==null)?put_in_center("-"):resp.records[i].Email)+"</td><td>"+((resp.records[i].LeadSource==null)?put_in_center("-"):resp.records[i].LeadSource)+"</td><td>"+((resp.records[i].Rating==null)?put_in_center("-"):resp.records[i].Rating)+"</td><td>"+((resp.records[i].Phone==null)?put_in_center("-"):resp.records[i].Phone)+"</td><td><a href='#' onclick='call_lead(\""+resp.records[i].Name+"\",\""+resp.records[i].Phone+"\")'>Call</a></td></tr>";

								}
								table_html+="</tbody> </table>";

								$("#all_leads").html(table_html);
								convertToDataTables('.data-table');
						}
						
					}else if(resp[0].errorCode=="INVALID_SESSION_ID"){
						alert("Your Session has been expired!\nPlease Login Again to Continue");
						window.location="index.php";
					}else{
						alert("Error Fetching details. Please Contact Administrator!\nError Code:"+resp[0].message);
					}
				}
						
		
	});

	});
	
	
	function show_lead_details(Id){
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
	}
	function put_in_center(str){
		return "<div style='text-align:center;'>"+str+"</div>"
	}
	
*/
$(document).ready(function(e) {
    callSidebarPageAjax('show_all_leads.php','All Leads',null);
});
</script>
<div class="grid-24">
  <div class="widget widget-table">
    <div class="widget-content">
    </div>
    <!-- .widget-content --> 
    
  </div>
</div>