<?php
require_once('commonFunctions.php');

$salesforce_setting = getSalesforceSettings();

define("CLIENT_ID", $salesforce_setting['client_id']);
define("CLIENT_SECRET", $salesforce_setting['client_secret']);
define("REDIRECT_URI", "https://localhost/tscp/library/resttest/oauth_callback.php");
define("LOGIN_URI", "https://login.salesforce.com");
define("SALESFORCE_UNAME", $salesforce_setting['uname']);
define("SALESFORCE_PASS", $salesforce_setting['pass']);
define("SALESFORCE_SECURITY_TOKEN", $salesforce_setting['security_token']);
?>