<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
}
//buildSidebar();

include 'library/twilio/Twilio/Capability.php';
$twilio_creds=getTwlioCreds();
$token = new Services_Twilio_Capability($twilio_creds['sid'], $twilio_creds['auth_token']);
$token->allowClientOutgoing($twilio_creds['app_sid']);
$agent_name=$_SESSION['user_name'];
$token->allowClientIncoming($agent_name);
// @end snippet
//+16617480240 - Vishak sir skype
?>
		<!-- @start snippet -->
		<!-- <script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script> -->
        <script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>
		<script type="text/javascript">
		var num_reg_exp=/^\+{0,1}[1-9]{0,1}[0-9]{0,14}$/;
		var blinking_on,miss_call_check,latest_call_id=0, account_id=0, multiple_caller_response=null, is_on_call=false, is_on_hold=false, caller_name="", dialed_number=0, use_twilio_availability=true, agent_name='<?=$agent_name?>',agent_checking;
		
		$(document).ready(function(){
			Twilio.Device.setup("<?php echo $token->generateToken();?>");
			
			connection=null;
			$("#call").click(function() {
				use_twilio_availability=false;
				changeAgentStatus(false);
				$('.switch_container li.on').removeClass('on');
				$("#switch_off").parent().addClass('on');
				
				params = { "tocall" : $('#tocall').val()};
				connection = Twilio.Device.connect(params);
				connection.disconnect(function(conn) {
				  rejectCall();
				});
			});
			$("#hangup").click(function() {  
				Twilio.Device.disconnectAll();
			});

			Twilio.Device.ready(function (device) {
				if(use_twilio_availability){
					$('#status').text('Ready to start call');
					changeAgentStatus(true);
				}
			});

			Twilio.Device.incoming(function (conn) {
				use_twilio_availability=false;
				changeAgentStatus(false);
				$('.switch_container li.on').removeClass('on');
				$("#switch_off").parent().addClass('on');
				if(!is_on_hold){
					getNameOfCaller(conn.parameters.From)
				}else{
					showIncomingCall(caller_name,conn.parameters.From);
				}
				connection=conn;
				/*if (confirm('' + conn.parameters.From + '?')){
					connection=conn;
				    conn.accept();
				}*/
			});

			Twilio.Device.offline(function (device) {
				$('#status').text('Offline');
				changeAgentStatus(false);
			});

			Twilio.Device.error(function (error) {
				if(error.message=="This AccessToken is no longer valid"){
					refreshCapabilityToken();
				}else{
					//Object {message: "User denied access to microphone.", code: 31208}
					$('#status').text(error);
				}
			});

			Twilio.Device.connect(function (conn) {
				use_twilio_availability=false;
				changeAgentStatus(false);
				$("#incoming_call_alert .buttonpick").hide();
				$('.switch_container li.on').removeClass('on');
				$("#switch_off").parent().addClass('on');
				//latest_call_id='123';
				if (typeof conn.parameters.CallSid !== "undefined"){
					make_caller_entry(conn.parameters.CallSid,conn.parameters.From,conn.parameters.To);
					latest_call_id=conn.parameters.CallSid;
				}
				$('#status').text("Successfully established call");
				$("#incoming_call_alert .message").html("IN Call with: ");
				clearTimeout(miss_call_check);
				clearTimeout(blinking_on);
				//toggleCallStatus();
				//$("#on_call_note").attr('readonly','readonly');
				//$("#note_container").fadeOut('slow');
			});

			Twilio.Device.disconnect(function (conn) {
				$('#status').text("Call ended");
				clearTimeout(blinking_on);
				clearTimeout(miss_call_check);
				rejectCall();
			});
			
			function toggleCallStatus(){
				$('#call').toggle();
				$('#hangup').toggle();
				$('#dialpad').slideToggle();
			}

			$.each(['0','1','2','3','4','5','6','7','8','9','star','hash','plus'], function(index, value) { 
		    	$('#button' + value).click(function(){ 
					if(connection) {
						if (value=='star')
							connection.sendDigits('*')
						else if (value=='hash')
							connection.sendDigits('#')
						else if(value != 'plus')
							connection.sendDigits(value)
						return false;
					}else{
						var new_val="";
						if (value=='star')
							new_val=$("#tocall").val()+"*";
						else if (value=='hash')
							new_val=$("#tocall").val()+"#";
						else if (value=='plus')
							new_val=$("#tocall").val()+"+";
						else
							new_val=$("#tocall").val()+""+value;
							
						if(num_reg_exp.test(new_val)){
							$("#tocall").val(new_val);
						}
					}
				});
			});
//			43,48-57,
			$("#tocall").keypress(function(e) {
				var key_code;
				if(e.keyCode){
					key_code=e.keyCode;
				}else{
					key_code=e.which;
				}
				
				if(key_code!=8 && key_code!=37 && key_code!=39 && key_code!=43 && !(key_code>=48 && key_code<=57)){
					return false;
				}
				//return false;
            });
			$("#save_note").click(function(){
				if(account_id!==0){
					//latest_call_id="Non call note";
					var note=$.trim($("#on_call_note").val());
					if(note!=''){
						note=urlEncode(note);

						if(navigator.onLine){
							$.ajax({
								url:"library/ajax_files/save_call_note.php",
								type:'POST',
								data:"call_id="+latest_call_id+"&note="+note+"&account_id="+account_id,
								beforeSend:function(){
									$("#save_note").val("saving...");
									$("#save_note").attr('disabled','disabled');
								},
								success:function(resp){
									alert(resp);
									$("#on_call_note").val("");
									$("#save_note").val("Save Note");
									$("#save_note").removeAttr('disabled');
								}
							});
						}else{
							alert("Please Check your internet connection!");
						}
					}
				}
			});
			
			// Change Switch
			$("ul.switch_container li").click(function(){
				$("ul.switch_container li").removeClass("on");
				$(this).addClass("on");
				if($(this).find('a').attr('id')==="switch_on"){
					use_twilio_availability=true;
					if(Twilio.Device.status()=="ready"){
						$('#status').text('Ready to start call');
						changeAgentStatus(true);
					}
				}else{
					use_twilio_availability=false;
					changeAgentStatus(false);
					$("#status").text('Offline');
				}
				return false;
			});
			$("#switch_on").parent().addClass('on');
			setInterval('markAvaillability()',5000);
			
		});
		function refreshCapabilityToken(){
			if(navigator.onLine){
				$.ajax({
					url:"library/ajax_files/refresh_twilio_token.php",
					type:"POST",
					beforeLoad:function(){
						$('#status').text("Refreshing Token Please Wait...");
					},
					success:function(token){
						if(token){
							Twilio.Device.setup(token);
						}
					}		
				});
			}else{
				alert("Please Check your internet connection!");
			}
		}
		function blinkCallAlert(){
			$("#incoming_call_alert .blinking").fadeToggle('fast');
			//$("#incoming_call_alert .blinking").animate({borderColor:#FFB649},'fast');
		}
		function pickCall(){
			if(connection){
				connection.accept();
				clearTimeout(blinking_on);
				$("#incoming_call_alert .message").html("IN Call with: ");
			}
		}
		function muteCall(){
			if(connection){
				connection.mute();
				$("#incoming_call_alert .message").html("IN Call with(muted): ");
				$("#buttonmute").hide();
				$("#buttonunmute").show();
			}
		}
		function unmuteCall(){
			if(connection){
				connection.unmute();
				$("#incoming_call_alert .message").html("IN Call with: ");
				$("#buttonunmute").hide();
				$("#buttonmute").show();
			}
		}
		function rejectCall(){
			$("#incoming_call_alert .message").html("Call ended: ");
			clearTimeout(blinking_on);
			clearTimeout(miss_call_check);
			setTimeout("$('#incoming_call_alert').slideUp('slow');",1000);
			$("#dialpad #buttondial").attr('onclick','makeCall();');
			$("#dialpad #buttonreject").attr('onclick','resetBox();');
			Twilio.Device.disconnectAll();
			if(connection){
				connection.cancel();
				connection=null;
			}
		}
		function makeCall(){
			if($("#tocall").val()!="" && num_reg_exp.test($('#tocall').val())){
				$("#dialpad #buttondial").attr('onclick','return false;');
				$("#dialpad #buttonreject").attr('onclick','rejectCall();');
				dialed_number=$('#tocall').val();
				
				use_twilio_availability=false;
				changeAgentStatus(false);
				$('.switch_container li.on').removeClass('on');
				$("#switch_off").parent().addClass('on');
				
				params = { "tocall" : $('#tocall').val()};
				connection = Twilio.Device.connect(params);
				getDialedCallSid(dialed_number);
				showOutgoingCall('No Name',dialed_number);
				connection.disconnect(function(conn) {
					rejectCall();
				});
			}
		}
		function resetBox(){
			$("#tocall").val('');
			if(connection){
				connection=null;
			}
		}
		function getNameOfCaller(number){
			if(navigator.onLine){
				$.ajax({
					url:'library/ajax_files/get_salesforce_details_of_number.php',
					type:'POST',
					data:'number='+number,
					beforeSend:function(){
						$("#multiple_callers_div").hide();
						blinking_on=setInterval('blinkCallAlert()',500);
						miss_call_check=setInterval('checkRejection()',500);
						showIncomingCall("Fetching Details",number);
						$("#incoming_call_alert .phone_number").addClass('loading');
					},
					success:function(resp){
						$("#incoming_call_alert .phone_number").removeClass('loading');
						if(connection && connection.status()=="pending"){
							if(resp.lead_details.done){
								if(resp.lead_details.totalSize==1){
									account_id=resp.lead_details.records[0].Id;
									caller_name=resp.lead_details.records[0].Name;
									showIncomingCall(resp.lead_details.records[0].Name,number);
									var json_obj={lead_details:resp.lead_details.records[0],all_tasks:resp.all_tasks};
									setLeadDefaultDetails(json_obj);
								}else if(resp.lead_details.totalSize>1){
									multiple_caller_response=resp;
									var all_callers="";
									for(var i=0;i<resp.lead_details.totalSize;i++){
										all_callers+="<a href='#' class='multiple_callers_number' onclick='selectTheCaller(\""+i+"\",\""+number+"\")'>"+resp.lead_details.records[i].Name+"</a>";
									}
									$("#multiple_callers_div").html(all_callers);
									$("#incoming_call_alert .phone_number").html('Choose Caller'+"("+number+")");
									$("#multiple_callers_div").slideDown();
								}else{
									showIncomingCall("Unknown",number);
									caller_name="Unknown";
									callSidebarPageAjax('add_new_lead.php','Add Lead',"$('#Phone').val(param1);",number);
								}
							}else if(resp[0].errorCode=="INVALID_SESSION_ID"){
								alert("Your Session has been expired!\nPlease Login Again to Continue");
								window.location="index.php";
							}else{
								alert("Error Fetching details. Please Contact Administrator!\nError Code:"+resp[0].message);
							}
						}else{//if(connection && connection.status()=="pending"){
							if(resp.lead_details.done){
								if(resp.lead_details.totalSize>=1){
									account_id=resp.lead_details.records[0].Id;
									$("#incoming_call_alert .phone_number").html(resp.lead_details.records[0].Name+"("+number+")");
									var json_obj={lead_details:resp.lead_details.records[0],all_tasks:resp.all_tasks};
									setLeadDefaultDetails(json_obj);
								}else{
									$("#incoming_call_alert .phone_number").html("Unknown"+"("+number+")");
									callSidebarPageAjax('add_new_lead.php','Add Lead',"$('#Phone').val(param1);",number);
								}
							}
							gotMissedCall();
						}
					}
				});
			}else{
				alert("Please Check your internet connection!");
			}				
		}
		function selectTheCaller(index,number){
			account_id=multiple_caller_response.lead_details.records[index].Id;
			showIncomingCall(multiple_caller_response.lead_details.records[index].Name,number);
			var json_obj={lead_details:multiple_caller_response.lead_details.records[index],all_tasks:multiple_caller_response.all_tasks};
			caller_name=multiple_caller_response.lead_details.records[index].Name;
			setLeadDefaultDetails(json_obj);
			multiple_caller_response=null;
			$("#multiple_callers_div").slideUp();
		}
		function checkRejection(){
			if(connection){
				if(connection.status()=="closed"){
					gotMissedCall();	
				}
			}
		}
		function gotMissedCall(){
			$("#incoming_call_alert .message").html("Call Missed: ");
			clearTimeout(blinking_on);
			clearTimeout(miss_call_check);
			$("#dialpad #buttondial").attr('onclick','makeCall();');
			$("#dialpad #buttonreject").attr('onclick','resetBox();');
			Twilio.Device.disconnectAll();
			if(connection){
				connection.cancel();
				connection=null;
			}
		}
		function showIncomingCall(name,number){
			$("#incoming_call_alert .message").html("INCOMING CALL FROM: ");
			$("#incoming_call_alert .phone_number").html(name+"("+number+")");
			$("#incoming_call_alert .buttonpick").show();
			$("#incoming_call_alert").slideDown();
			$("#dialpad #buttondial").attr('onclick','pickCall();');
			$("#dialpad #buttonreject").attr('onclick','rejectCall();');
			$("#main_content_div").fadeOut('slow',function(){
				$("#add_lead_form").fadeIn('fast');
			});
		}
		function showOutgoingCall(name,number){
			caller_name=name;
			$("#incoming_call_alert .message").html("CALLING TO: ");
			$("#incoming_call_alert .phone_number").html(name+"("+number+")");
			$("#incoming_call_alert .buttonpick").hide();
			$("#incoming_call_alert").slideDown();
			$("#dialpad #buttondial").attr('onclick','return false;');
			$("#dialpad #buttonreject").attr('onclick','rejectCall();');
/*			$("#main_content_div").fadeOut('slow',function(){
				$("#add_lead_form").fadeIn('fast');
			});*/
		}
		function setLeadDefaultDetails(json_obj){
			callSidebarPageAjax('add_new_lead.php',"Lead Details","setDefaultDetails(param1,'lead');",json_obj);
		}
		function setContactDefaultDetails(json_obj){
			callSidebarPageAjax('add_new_client.php',"Contact Details","setDefaultDetails(param1,'contact');",json_obj);
		}
		function setDefaultDetails(json_obj,type){
			var main_json_object=json_obj;
			if(type=="lead"){
				main_json_object=json_obj.lead_details;
			}else if(type=="contact"){
				main_json_object=json_obj.contact_details;
			}
			for(prop in main_json_object){
				$('.'+prop+'_label .value_label').html(main_json_object[prop]);
			}
			for(prop in main_json_object){
				if($('#'+prop).hasClass('date_picker_alt')){
					setDatepickerDate('.date_picker',main_json_object[prop],'.date_picker_alt');
				}else if($('#'+prop).is('input[type="text"]')){
					$('#'+prop).val(main_json_object[prop]);
				}else if($('#'+prop).is('textarea')){
					$('#'+prop).html(main_json_object[prop]);
				}else if($('#'+prop).is('select')){
					$('#'+prop+' option[value="'+main_json_object[prop]+'"]').attr('selected','selected');
				}
			}
			fillNonTexts(json_obj,type);
/*			$('.inputbox').fadeOut('fast',function(){
				$('.labelbox').fadeIn('fast');
			});*/
		}
		function fillNonTexts(json_obj,type){
			$("#note_container").fadeIn('fast');
			if(type=="lead"){
				var save_onclick_function=$("#save_lead").attr('onclick');
				$("#save_lead").attr('onclick',save_onclick_function.replace('add','update'));
				$("#lead_id").val(json_obj.lead_details['Id']);
				$("#lead_form_call").attr('onclick','call_lead("'+json_obj.lead_details['Name']+'","'+json_obj.lead_details['Phone']+'","'+json_obj.lead_details['Id']+'")');

				account_id=json_obj.lead_details['Id'];
				//$("#on_call_note").removeAttr('readonly');

				var table_html= "<table class='table table-bordered table-striped display all_notes_table'><thead><tr><th style='width:40px;'>Sr. No.</th><th>Record URL</th><th>Description</th></thead><tbody>";
				if(json_obj.all_tasks.totalSize>=1){
					for(i=0;i<json_obj.all_tasks.totalSize;i++){
						table_html+="<tr><td style='width:40px;'>"+(i+1)+"</td><td>"+((json_obj.all_tasks.records[i].RecordingURL__c==null)?put_in_center("-"):"<a href="+json_obj.all_tasks.records[i].RecordingURL__c+" target='_blank'>"+json_obj.all_tasks.records[i].RecordingURL__c+"</a>")+"</td><td>"+((json_obj.all_tasks.records[i].Description==null)?put_in_center("-"):json_obj.all_tasks.records[i].Description)+"</td></tr>";
					}
				}
				table_html+="</tbody> </table>";

				$("#all_notes").html(table_html);
				convertToDataTables('.all_notes_table',{"iDisplayLength":10,"aLengthMenu":[[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]]});
			}else if(type=="contact"){
				var save_onclick_function=$("#save_contact").attr('onclick');
				$("#save_contact").attr('onclick',save_onclick_function.replace('add','update'));
				$("#contact_id").val(json_obj.contact_details['Id']);
				account_id=json_obj.contact_details['Id'];
				$("#contact_form_call").attr('onclick','call_lead("'+json_obj.contact_details['Phone']+'")');

				var table_html= "<table class='table table-bordered table-striped display all_notes_table'><thead><tr><th style='width:40px;'>Sr. No.</th><th>Record URL</th><th>Description</th></thead><tbody>";
				if(json_obj.all_tasks.totalSize>=1){
					for(i=0;i<json_obj.all_tasks.totalSize;i++){
						table_html+="<tr><td style='width:40px;'>"+(i+1)+"</td><td>"+((json_obj.all_tasks.records[i].RecordingURL__c==null)?put_in_center("-"):"<a href="+json_obj.all_tasks.records[i].RecordingURL__c+" target='_blank'>"+json_obj.all_tasks.records[i].RecordingURL__c+"</a>")+"</td><td>"+((json_obj.all_tasks.records[i].Description==null)?put_in_center("-"):json_obj.all_tasks.records[i].Description)+"</td></tr>";
					}
				}
				table_html+="</tbody> </table>";

				$("#all_notes").html(table_html);
				convertToDataTables('.all_notes_table',{"iDisplayLength":10,"aLengthMenu":[[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]]});
			}
		}
		function call_lead(name,number,account_id){
			if(number=='null' || number==''){
				alert("No number to call!");
			}else{
				number=stripNonNumericChars(number);
				if(number.length>=10){
					number='+1'+number.substr(number.length-10);
				}
				if(navigator.onLine){
					$.ajax({
						url:"library/ajax_files/make_caller_entry.php",
						data:"to="+number+"&account_id="+account_id,
						type:'POST',
						async:false,
						success:function(resp){
							if(resp.done){
								doCall(number,resp.id);
								showOutgoingCall(name,number);
							}
						}
					});
				}else{
					alert("Please Check your internet connection!");
				}
			}
		}
		function doCall(number,call_log_id){
			use_twilio_availability=false;
			changeAgentStatus(false);
			$('.switch_container li.on').removeClass('on');
			$("#switch_off").parent().addClass('on');
			
			params = { "tocall" : number,"call_log_id":call_log_id};
			dialed_number=number;
			connection = Twilio.Device.connect(params);
			getDialedCallSid(dialed_number);
			connection.disconnect(function(conn) {
			  rejectCall();
			})
		}
		function stripNonNumericChars(pstrSource){ 
			var m_strOut = new String(pstrSource); 
			m_strOut = m_strOut.replace(/[^0-9]/g, ''); 
		
			return m_strOut; 
		}
		function callSidebarPageAjax(page_name,title,successCallback,param1){
			clearInterval(agent_checking);
			latest_call_id="Non call note";
			//$("#on_call_note").attr('readonly','readonly');
			$("#note_container").fadeOut('slow');
			//account_id=0;
			if(navigator.onLine){
				$.ajax({
					url:page_name,
					success:function(resp){
						$("#main_content_div").fadeOut('slow',function(){
							setPageTitle(title);
							$("#sidebar_content_div").fadeIn();
							$('#sidebar_content_div').html(resp);
							convertToDatePicker(".date_picker");
							if(successCallback!==null){
								eval(successCallback);
							}
						});
					}
				});
			}else{
				alert("Please Check your internet connection!");
			}
		}
		
		function hideSidebarContent(){
			$("#sidebar_content_div").fadeOut('slow',function(){
				$("#main_content_div").fadeIn();
			});
		}
		function make_caller_entry(call_id,from,to){
			if(navigator.onLine){
				$.ajax({
					url:"library/ajax_files/make_caller_entry.php",
					type:"POST",
					data:"call_id="+call_id+"&account_id="+account_id+"&from="+from+"&to="+to,
					success:function(resp){
					}
				});
			}else{
				alert("Please Check your internet connection!");
			}
		}
	
		function putCallOnHold(){
			if(latest_call_id!="Non call note" && latest_call_id!=0){
				if(connection !== null && (connection.status()=="pending" || connection.status()=="open" || connection.status()=="connecting")){
					var number='';
					if(typeof connection.parameters.From==="undefined" || connection.parameters.From.indexOf('7723149')!==(-1)){
						number=stripNonNumericChars(dialed_number);
					}else{
						number=stripNonNumericChars(connection.parameters.From);
					}
					if(navigator.onLine){
						$.ajax({
							url:"call_hold.php",
							type:"POST",
							data:"call_to_put_on_hold="+number,
							beforeSend:function(){
								$("#hold_btn").val("Please Wait...");
							},
							success:function(resp){
								$("#hold_btn").val("Hold call");
								$("#resume_btn").val("Resume Call with "+caller_name);
								$("#resume_button").show();
								is_on_hold=true;
							}	
						});
					}else{
						alert("Please Check your internet connection!");
					}
				}
			}
		}
		function resumeCall(){
			if(navigator.onLine){
				$.ajax({
					url:"call_resume.php",
					type:"POST",
					beforeSend:function(){
						$("#resume_btn").val("Please Wait...");
					},
					success:function(resp){
						$("#resume_btn").val("Resume");
						$("#resume_button").hide();
					}	
				});
			}else{
				alert("Please Check your internet connection!");
			}
		}
		function getDialedCallSid(number){
			if(connection !== null && (connection.status()=="pending" || connection.status()=="open" || connection.status()=="connecting")){
				number=stripNonNumericChars(number);

				if(navigator.onLine){
					$.ajax({
						url:'get_dialed_call_sid.php',
						data:'number='+number,
						type:'POST',
						beforeSend:function(){
							$("#hold_btn,#transfer_btn").attr('onclick','return false;');
							$("#hold_btn,#transfer_btn").addClass('loading_btn loading');
						},
						success:function(resp){
							if(resp==='recall' || resp==='MySQL server has gone away'){
								getDialedCallSid(number);
							}else{
								try{
									resp=JSON.parse(resp);
									if(resp.got_it){
										latest_call_id=resp.call_sid;
										got_dialed_call_sid_callback();
									}
								}catch(e){
									alert("Error fetching Call SID! Contact Administrator.");
								}
							}
						}
					});
				}else{
					alert("Please Check your internet connection!");
				}
			}
		}
		function got_dialed_call_sid_callback(){
			$("#hold_btn").attr('onclick','putCallOnHold();');
			$("#transfer_btn").attr('onclick','transferCall();');
			$("#hold_btn,#transfer_btn").removeClass('loading_btn loading');
		}
		function changeAgentStatus(isAvailable){
			if(navigator.onLine){
				$.ajax({
					url:'library/ajax_files/change_agent_status.php',
					type:"POST",
					data:"is_available="+isAvailable,
					success:function(resp){
						
					}
				});
			}else{
				alert("Please Check your internet connection!");
			}
		}
		function markAvaillability(){
			if(use_twilio_availability){
				if(Twilio.Device.status()=="ready"){
					changeAgentStatus(true);
				}
			}
		}
		function transferCall(){
			if(latest_call_id!="Non call note" && latest_call_id!=0){
				if(connection !== null && (connection.status()=="pending" || connection.status()=="open" || connection.status()=="connecting")){
					var res=prompt("Please enter the number to transfer the call");
					if(res){
						res=stripNonNumericChars(res)
						if(res!="" && num_reg_exp.test(res) && res.length>=10){
							if(res.length==10){
								res='1'+res
							}
							var number='';
							if(typeof connection.parameters.From==="undefined" || connection.parameters.From.indexOf('7723149')!==(-1)){
								number=stripNonNumericChars(dialed_number);
							}else{
								number=stripNonNumericChars(connection.parameters.From);
							}
							$.ajax({
								url:'call_transfer.php',
								type:'POST',
								data:'transfering_to='+res+'&call_to_transfer='+number,
								beforeSend:function(){
									$('#transfer_btn').val('Transferring...');
								},
								success:function(resp){
									$('#transfer_btn').val('Transfer Call');
								}
							});
						}else{
							alert("Please enter valid phone number!");
							transferCall();
						}
					}
				}
			}
		}
		</script>
			<ul>
				<li>
					<h3 class="dialer_title">Leads</h3>
					<ul>
						<li><a href="#" onclick="callSidebarPageAjax('show_all_leads.php','All Leads',null);">All Leads</a></li>
						<li><a href="#" onclick="callSidebarPageAjax('add_new_lead.php','Add Lead',null);">Add new Lead</a></li>
					</ul>
				</li>
				<li>
					<h3 class="dialer_title">Contacts</h3>
					<ul>
						<li><a href="#" onclick="callSidebarPageAjax('show_all_contacts.php','All Contacts',null);">All Contacts</a></li>
						<li><a href="#" onclick="callSidebarPageAjax('add_new_client.php','Add Contact',null);">Add new Contacts</a></li>
					</ul>
				</li>
				<li>
	                <h3 class="dialer_title">Agents</h3>
					<ul>
						<li><a href="#" onclick="callSidebarPageAjax('show_all_available_agents.php','Available Agents',null);">Available Agents</a></li>
					</ul>
				</li>
				<li>
					<h3 class="dialer_title">Dialer</h3>
                    <div align="center" style="margin:5px 0;">
                        <!-- @start snippet -->
                        <input type="text" id="tocall" value="">
        <!--                <input type="button" id="call" value="Start Call"/>
                        <input type="button" id="hangup" value="Hangup Call" style="display:none;"/> -->
                        <div id="status">
                            Offline
                        </div>
                        <div id="dialpad">
                            <table>
                                <tr>
                                    <td><input type="button" value="" id="button1"></td>
                                    <td><input type="button" value="" id="button2"></td>
                                    <td><input type="button" value="" id="button3"></td>
                                    <td><input type="button" value="" id="buttondial" onclick="makeCall();"></td>
                                </tr>
                                <tr>
                                    <td><input type="button" value="" id="button4"></td>
                                    <td><input type="button" value="" id="button5"></td>
                                    <td><input type="button" value="" id="button6"></td>
                                    <td><input type="button" value="" id="buttonreject" onclick="resetBox();"></td>
                                </tr>
                                <tr>
                                    <td><input type="button" value="" id="button7"></td>
                                    <td><input type="button" value="" id="button8"></td>
                                    <td><input type="button" value="" id="button9"></td>
                                    <td><input type="button" value="" id="buttonmute" onclick="muteCall();"><input type="button" value="" id="buttonunmute" onclick="unmuteCall();" style="display:none;"></td>
                                </tr>
                                <tr>
                                    <td><input type="button" value="" id="buttonstar"></td>
                                    <td><input type="button" value="" id="button0"></td>
                                    <td><input type="button" value="" id="buttonhash"></td>
                                    <td><input type="button" value="" id="buttonplus"></td>
                                </tr>
                            </table>
                        </div>
                        <!-- @end snippet -->
                    </div>
				</li>
                <li id="note_container" style="display:none;text-align:center;">
                    <h3 class="dialer_title">Note</h3>
                    <textarea rows="4"  id="on_call_note" maxlength="256" style="max-width:150px;"></textarea>
                    <input type="button" id="save_note" value="Save Note" style="margin-top:5px;"/>
                </li>
			</ul>
            <br />