<?
$twilioCreds = getTwlioCreds();
$salesforce_settings = getSalesforceSettings();
//print_r($salesforce_settings); exit;
?>
<div class="grid-24">
	<div class="widget">
		<div class="widget-content">
        		<div class="field-group">
                	<h4>Twilio Settings</h4>
                </div>
                <div class="field-group">
                    <div class="field_label">Account SID</div>
                    <div class="colon">:</div>
                    <div class="field_value"><input type="text" name="twilio_sid" id="twilio_sid" value="<?=$twilioCreds['sid']?>" style="width:300px"></div>
                    <div class="clr"></div>
                </div>
                <div class="field-group">
                    <div class="field_label">Auth Token</div>
                    <div class="colon">:</div>
                    <div class="field_value"><input type="text" name="twilio_auth_token" id="twilio_auth_token" value="<?=$twilioCreds['auth_token']?>"  style="width:300px"></div>
                    <div class="clr"></div>
                </div>
                <div class="field-group">
                    <div class="field_label">App ID</div>
                    <div class="colon">:</div>
                    <div class="field_value"><input type="text" name="twilio_app_sid" id="twilio_app_sid" value="<?=$twilioCreds['app_sid']?>"  style="width:300px"></div>
                    <div class="clr"></div>
                </div>
                <br />
                
                <div class="field-group">
                	<h4>Salesforce Settings</h4>
                </div>
                <div class="field-group">
                    <div class="field_label">User Name</div>
                    <div class="colon">:</div>
                    <div class="field_value"><input type="text" name="salesforce_uname" id="salesforce_uname" value="<?=$salesforce_settings['uname']?>"  style="width:300px"></div>
                    <div class="clr"></div>
                </div>
                <div class="field-group">
                    <div class="field_label">Password</div>
                    <div class="colon">:</div>
                    <div class="field_value"><input type="text" name="salesforce_pass" id="salesforce_pass" value="<?=$salesforce_settings['pass']?>"  style="width:300px"></div>
                    <div class="clr"></div>
                </div>
                <div class="field-group">
                    <div class="field_label">Security Token</div>
                    <div class="colon">:</div>
                    <div class="field_value"><input type="text" name="salesforce_security_token" id="salesforce_security_token" value="<?=$salesforce_settings['security_token']?>"  style="width:300px"></div>
                    <div class="clr"></div>
                </div>
				<div class="field-group">
                    <div class="field_label">Client ID</div>
                    <div class="colon">:</div>
                    <div class="field_value"><input type="text" name="salesforce_client_id" id="salesforce_client_id" value="<?=$salesforce_settings['client_id']?>"  style="width:300px"></div>
                    <div class="clr"></div>
                </div>
				<div class="field-group">
                    <div class="field_label">Client Secret</div>
                    <div class="colon">:</div>
                    <div class="field_value"><input type="text" name="salesforce_client_secret" id="salesforce_client_secret" value="<?=$salesforce_settings['client_secret']?>"  style="width:300px"></div>
                    <div class="clr"></div>
                </div>
                <br /><br />
                <div id="addUser" class="actions">
                    <input type="button" class="btn" value=" Update Settings " onClick="updateSettings('settings.php','updateSettings')">
                </div>
        </div><!-- @end widget-content -->
    </div><!-- @end widget -->
</div><!-- @end grid-24 -->