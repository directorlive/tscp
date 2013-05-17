<?php
//session_start();
date_default_timezone_set('EST');
$included_files=get_included_files();
//var_dump($included_files);exit;
if(!in_array('/home/satnyxin/public_html/tscp/library/Cron_Config.php',$included_files)){
	require_once(dirname( dirname(__FILE__) ).'/Config.php');
}
require_once(dirname( dirname(__FILE__) ).'/commonFunctions.php');
$access_token = getConfigValue('salesforce_current_access_token');
$instance_url = getConfigValue('salesforce_current_instance_url');
//echo $access_token."URL= ".$instance_url;exit;
//$_SESSION['access_token']=$access_token;
//$_SESSION['instance_url']=$instance_url;

function describe_lead() {
	global $access_token;
	global $instance_url;
    $url = "$instance_url/services/data/v20.0/sobjects/lead/describe";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
	
    $json_response = curl_exec($curl);
	var_dump($json_response);
    curl_close($curl);

    $response = json_decode($json_response, true);
	echo "<pre>";print_r($response);echo"</pre>";

/*    $total_size = $response['totalSize'];

    echo "$total_size record(s) returned<br/><br/>";
    foreach ((array) $response['records'] as $record) {
        echo $record['Id'] . ", " . $record['Name'] . "<br/>";
    }
    echo "<br/>";*/
}
//describe_lead($instance_url, $access_token);
function show_accounts() {
	global $access_token;
	global $instance_url;
    
    $query = "SELECT Name, Id from Account";
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
	
    $json_response = curl_exec($curl);
	var_dump($json_response);
    curl_close($curl);

    $response = json_decode($json_response, true);

    $total_size = $response['totalSize'];

    echo "$total_size record(s) returned<br/><br/>";
    foreach ((array) $response['records'] as $record) {
        echo $record['Id'] . ", " . $record['Name'] . "<br/>";
    }
    echo "<br/>";
}

function create_account($name) {
	global $access_token;
	global $instance_url;
    
    $url = "$instance_url/services/data/v20.0/sobjects/Account/";

    $content = json_encode(array("Name" => $name));

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 201 ) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
    
    echo "HTTP status $status creating account<br/><br/>";

    curl_close($curl);

    $response = json_decode($json_response, true);

    $id = $response["id"];

    echo "New record id $id<br/><br/>";

    return $id;
}

function show_account($id) {
	global $access_token;
	global $instance_url;
    
    $url = "$instance_url/services/data/v20.0/sobjects/Account/$id";
	//echo $url;exit;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 200 ) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }

    echo "HTTP status $status reading account<br/><br/>";

    curl_close($curl);

    $response = json_decode($json_response, true);

    foreach ((array) $response as $key => $value) {
        echo "$key:$value<br/>";
    }
    echo "<br/>";
}

function update_account($id, $new_name, $city) {
	global $access_token;
	global $instance_url;
    
    $url = "$instance_url/services/data/v20.0/sobjects/Account/$id";

    $content = json_encode(array("Name" => $new_name, "BillingCity" => $city));

    $curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 204 ) {
        die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }

    echo "HTTP status $status updating account<br/><br/>";

    curl_close($curl);
}

function delete_account($id) {
	global $access_token;
	global $instance_url;
    
    $url = "$instance_url/services/data/v20.0/sobjects/Account/$id";

    $curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");

    curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 204 ) {
        die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }

    echo "HTTP status $status deleting account<br/><br/>";

    curl_close($curl);
}
function get_name_of_number_clients($number) {
	global $access_token;
	global $instance_url;
    
    $query = "SELECT AccountId, AssistantName, AssistantPhone, Birthdate, Department, Description, Email, EmailBouncedDate, EmailBouncedReason, Fax, FirstName, HomePhone, IsDeleted, LastActivityDate, LastCURequestDate, LastCUUpdateDate, LastName, LeadSource, MailingCity, MailingState, MailingCountry, MailingPostalCode, MailingStreet, MasterRecordId, MobilePhone, Name, OtherCity, OtherCountry, OtherPostalCode, OtherState, OtherPhone, OtherStreet, OwnerId, Phone, ReportsToId, Salutation, Title from Contact WHERE AssistantPhone = '{$number}' OR Fax = '{$number}' OR MobilePhone = '{$number}' OR OtherPhone = '{$number}' OR Phone = '{$number}' OR HomePhone = '{$number}'";
	//CleanStatus, CanAllowPortalSelfReg, ConnectionReceivedId, ConnectionSentId, DoNotCall, HasOptedOutOfEmail, IsPersonAccount, Jigsaw, MailingStateCode, MailingCountryCode, OtherCountryCode, OtherStateCode, RecordTypeId,
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));

    $json_response = curl_exec($curl);
    curl_close($curl);


/*    $response = json_decode($json_response, true);
	//print_r($response);exit;
    $total_size = $response['totalSize'];

    echo "$total_size record(s) returned<br/><br/>";
    foreach ((array) $response['records'] as $record) {
        echo $record['Id'] . ", " . $record['Name'] . "<br/>";
    }
    echo "<br/>";*/
	return ($json_response);
}
function get_name_of_number_leads($numbers) {
	global $access_token;
	global $instance_url;
    
//	$number='(609) 699-4102';
//	$number='201-835-0762';
    $query = "SELECT Id,Accept_the_Guest_Waiver__c,Street,City,State,PostalCode,Country,Birthday__c,ParentFirstName__c,ParentLastName__c,Company,Description,Email,Industry,LeadSource,Status,Name,Salutation,FirstName,LastName,Phone,Rating,Title,Website,Type__c from Lead WHERE IsDeleted=FALSE AND (";
	foreach($numbers as $number){
		$query.="Phone = '".$number."' OR ";
	}
	$query.="Phone like '%".substr($numbers[0],-10)."%') ";
	//$query=substr($query,0,strlen($query)-4);

//	echo $query;exit;
//	 Phone = '".implode(',',$numbers)."'";
	//CleanStatus, CanAllowPortalSelfReg, ConnectionReceivedId, ConnectionSentId, DoNotCall, HasOptedOutOfEmail, IsPersonAccount, Jigsaw, MailingStateCode, MailingCountryCode, OtherCountryCode, OtherStateCode, RecordTypeId,
	//, AssistantName, AssistantPhone, Birthdate, Department, Description, Email, EmailBouncedDate, EmailBouncedReason, Fax, FirstName, HomePhone, IsDeleted, LastActivityDate, LastCURequestDate, LastCUUpdateDate, LastName, LeadSource, MailingCity, MailingState, MailingCountry, MailingPostalCode, MailingStreet, MasterRecordId, MobilePhone, Name, OtherCity, OtherCountry, OtherPostalCode, OtherState, OtherPhone, OtherStreet, OwnerId, Phone, ReportsToId, Salutation, Title
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));

    $json_response = curl_exec($curl);
    curl_close($curl);

	return ($json_response);
}
function get_deletd_leads() {
	global $access_token;
	global $instance_url;
    
    $query = "SELECT Id,IsDeleted from Lead ALL ROWS";

    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));

    $json_response = curl_exec($curl);
    curl_close($curl);

	echo ($json_response);
}
//get_deletd_leads();
function create_lead($dataArray) {
	global $access_token;
	global $instance_url;
    
    $url = "$instance_url/services/data/v20.0/sobjects/Lead/";

    $content = json_encode($dataArray);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 201 ) {
        return ("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }

    curl_close($curl);
	
	return $json_response;

/*    $response = json_decode($json_response, true);

    $id = $response["id"];

    echo "New record id $id<br/><br/>";

    return $id;*/
}
//get_deletd_leads();
function create_contact($dataArray) {
	global $access_token;
	global $instance_url;
    
    $url = "$instance_url/services/data/v20.0/sobjects/Contact/";

    $content = json_encode($dataArray);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 201 ) {
        return ("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }

    curl_close($curl);
	
	return $json_response;
}
function update_lead($dataArray,$id) {
	global $access_token;
	global $instance_url;
    
    $url = "$instance_url/services/data/v20.0/sobjects/Lead/$id/";
//	echo $url;exit;
    $content = json_encode($dataArray);
//	echo $url;exit;
    $curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 204 ) {
        return ("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }

    curl_close($curl);
	return $json_response;
}

function update_contact($dataArray,$id) {
	global $access_token;
	global $instance_url;
    
    $url = "$instance_url/services/data/v20.0/sobjects/Contact/$id/";
//	echo $url;exit;
    $content = json_encode($dataArray);
//	echo $url;exit;
    $curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 204 ) {
        return ("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }

    curl_close($curl);
	return $json_response;
}
// to get the updated or inserted leads from specified time
function get_changes_in_leads($time=15){
	global $access_token;
	global $instance_url;
    
    $query = "SELECT Id,Accept_the_Guest_Waiver__c,Street,City,State,PostalCode,Country,Birthday__c,ParentFirstName__c,ParentLastName__c,Company,Description,Email,Industry,LeadSource,Status,Name,Salutation,FirstName,LastName,Phone,Rating,Title,Website,Type__c from Lead WHERE ";
	if(intval(date('i'))>=$time){
		$query.="CreatedDate > ".date('Y-m-d\TH:').str_pad((intval(date('i'))-$time), 2, '0', STR_PAD_LEFT).date(':sP')." OR LastModifiedDate > ".date('Y-m-d\TH:').str_pad((intval(date('i'))-$time), 2, '0', STR_PAD_LEFT).date(':sP');
	}else if(intval(date('H'))>=1){
		$query.="CreatedDate > ".date('Y-m-d\T').str_pad((intval(date('H'))-1), 2, '0', STR_PAD_LEFT).':'.str_pad((intval(date('i'))+(60-intval($time))), 2, '0', STR_PAD_LEFT).date(':sP')." OR LastModifiedDate > ".date('Y-m-d\T').str_pad((intval(date('H'))-1), 2, '0', STR_PAD_LEFT).':'.str_pad((intval(date('i'))+(60-intval($time))), 2, '0', STR_PAD_LEFT).date(':sP');
	}else{
		$query.="CreatedDate > ".date('Y-m-').str_pad((intval(date('d'))-1), 2, '0', STR_PAD_LEFT).'T'.str_pad((intval(date('H'))+23), 2, '0', STR_PAD_LEFT).':'.str_pad((intval(date('i'))+(60-intval($time))), 2, '0', STR_PAD_LEFT).date(':sP')." OR LastModifiedDate > ".date('Y-m-').str_pad((intval(date('d'))-1), 2, '0', STR_PAD_LEFT).'T'.str_pad((intval(date('H'))+23), 2, '0', STR_PAD_LEFT).':'.str_pad((intval(date('i'))+(60-intval($time))), 2, '0', STR_PAD_LEFT).date(':sP');
	}
//	echo $query;exit;
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
	
    $json_response = curl_exec($curl);
    curl_close($curl);
	return $json_response;   	
}

//$var123=json_decode();
//echo get_name_of_number_leads('123',$instance_url, $access_token);
//sobjects/lead/describe
//show_accounts($instance_url, $access_token);
//echo get_name_of_number('(609) 699-4102',$instance_url, $access_token);
/*
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>REST/OAuth Example</title>
    </head>
    <body>
        <tt>
            <?php

            if (!isset($access_token) || $access_token == "") {
                die("Error - access token missing from session!");
            }

            if (!isset($instance_url) || $instance_url == "") {
                die("Error - instance URL missing from session!");
            }
			get_name_of_number('(609) 699-4102',$instance_url, $access_token)

 /*           show_accounts($instance_url, $access_token);

            $id = create_account("My New Org", $instance_url, $access_token);

            show_account($id, $instance_url, $access_token);

            show_accounts($instance_url, $access_token);

            update_account($id, "My New Org, Inc", "San Francisco",
                    $instance_url, $access_token);

            show_account($id, $instance_url, $access_token);

            show_accounts($instance_url, $access_token);

            delete_account($id, $instance_url, $access_token);

            show_accounts($instance_url, $access_token);
			* /
            
        </tt>
    </body>
</html>
*/
function get_all_leads() {
	global $access_token;
	global $instance_url;
    
    $query = "SELECT Id,Name,Street,Email,LeadSource,FirstName,LastName,Rating,Title,Phone from Lead";
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
	
    $json_response = curl_exec($curl);
    curl_close($curl);
	return $json_response;   
}

function show_lead($id){
	global $access_token;
	global $instance_url;
    
    $url = "$instance_url/services/data/v20.0/sobjects/Lead/$id";
	//echo $url;exit;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

/*    if ( $status != 200 ) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }*/

 //   echo "HTTP status $status reading account<br/><br/>";

    curl_close($curl);
	return $json_response;
    /*$response = json_decode($json_response, true);

    foreach ((array) $response as $key => $value) {
        echo "$key:$value<br/>";
    }
    echo "<br/>";*/
}
function db_leads() {
	global $access_token;
	global $instance_url;
    
	$query = "SELECT Id,Email,LeadSource,FirstName,LastName,Rating,Title,Phone from Lead";
	$url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_HTTPHEADER,
	array("Authorization: OAuth $access_token"));
	
	$json_response = curl_exec($curl);
	//var_dump($json_response);
	curl_close($curl);
	//return $json_response;
	$response = json_decode($json_response, true);
	//$Id = json_decode($Id, true);
	//echo "$ins_Leads <br/>";
	$total_size = $response['totalSize'];
	
	//echo "$total_size record(s) returned<br/><br/>";
	foreach ((array) $response['records'] as $record) {
		$ins_Leads ="insert into salesforce_leads (Id,Email,LeadSource,FirstName,LastName,Rating,Title,Phone) VALUES ";
		$ins_Leads.="('".addslashes($record['Id'])."','".addslashes($record['Email'])."','".addslashes($record['LeadSource'])."','".addslashes($record['FirstName'])."','".addslashes($record['LastName'])."','".addslashes($record['Rating'])."','".addslashes($record['Title'])."','".addslashes($record['Phone'])."');";
		echo $ins_Leads;
	}

}
//db_leads();


function get_all_contacts() {
	global $access_token;
	global $instance_url;
    
    $query = "SELECT Id,Name,FirstName,LastName,Phone,Email,Title,AccountId,Name from Contact";
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
	
    $json_response = curl_exec($curl);
    curl_close($curl);
	return $json_response;   
	//print_r($json_response);
		  
}


function show_contact($id){
	global $access_token;
	global $instance_url;
    
    $url = "$instance_url/services/data/v20.0/sobjects/Contact/$id";
	//echo $url;exit;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

/*    if ( $status != 200 ) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }*/

 //   echo "HTTP status $status reading account<br/><br/>";

    curl_close($curl);
	return $json_response;
    /*$response = json_decode($json_response, true);

    foreach ((array) $response as $key => $value) {
        echo "$key:$value<br/>";
    }
    echo "<br/>";*/
}

//get_all_contacts();


function db_contacts() {
	global $access_token;
	global $instance_url;
    
	$query = "SELECT Id,FirstName,LastName,Email,LeadSource,Phone,MobilePhone from Contact";
	$url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);
	//return $json_response;
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_HTTPHEADER,
	array("Authorization: OAuth $access_token"));
	
	$json_response = curl_exec($curl);
	//var_dump($json_response);
	$response = json_decode($json_response, true);
	//$Id = json_decode($Id, true);
	//echo "$ins_Leads <br/>";
	foreach ((array) $response['records'] as $record) {
		$ins_contacts ="insert into salesforce_contacts (Id,FirstName,LastName,Email,LeadSource,Phone,MobilePhone) VALUES ";
		$ins_contacts.="('".addslashes($record['Id'])."','".addslashes($record['FirstName'])."','".addslashes($record['LastName'])."','".addslashes($record['Email'])."','".addslashes($record['LeadSource'])."','".addslashes($record['Phone'])."','".addslashes($record['MobilePhone'])."');";
		echo $ins_contacts;
	}
	if(isset($response['nextRecordsUrl']) && $response['nextRecordsUrl']!==""){
		while(isset($response['nextRecordsUrl']) && $response['nextRecordsUrl']!==""){
			//echo "<br>----------------------------------------------------------------------------------------------------------<br>".$response['nextRecordsUrl'];
			$url = $instance_url.$response['nextRecordsUrl'];
			//return $json_response;
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_HTTPHEADER,
			array("Authorization: OAuth $access_token"));
			
			$json_response = curl_exec($curl);
			//var_dump($json_response);
			$response = json_decode($json_response, true);
			//$Id = json_decode($Id, true);
			//echo "$ins_Leads <br/>";
			foreach ((array) $response['records'] as $record) {
				$ins_contacts ="insert into salesforce_contacts (Id,FirstName,LastName,Email,LeadSource,Phone,MobilePhone) VALUES ";
				$ins_contacts.="('".addslashes($record['Id'])."','".addslashes($record['FirstName'])."','".addslashes($record['LastName'])."','".addslashes($record['Email'])."','".addslashes($record['LeadSource'])."','".addslashes($record['Phone'])."','".addslashes($record['MobilePhone'])."');";
				echo $ins_contacts;
			}
			
		}
	}
//	var_dump($response);
	

}


function get_changes_in_contacts($time=15){
	global $access_token;
	global $instance_url;
    
    $query = "SELECT Id,FirstName,LastName,Email,LeadSource,Phone,MobilePhone from Contact WHERE ";
	if(intval(date('i'))>=$time){
		$query.="CreatedDate > ".date('Y-m-d\TH:').str_pad((intval(date('i'))-$time), 2, '0', STR_PAD_LEFT).date(':sP')." OR LastModifiedDate > ".date('Y-m-d\TH:').str_pad((intval(date('i'))-$time), 2, '0', STR_PAD_LEFT).date(':sP');
	}else if(intval(date('H'))>=1){
		$query.="CreatedDate > ".date('Y-m-d\T').str_pad((intval(date('H'))-1), 2, '0', STR_PAD_LEFT).':'.str_pad((intval(date('i'))+(60-intval($time))), 2, '0', STR_PAD_LEFT).date(':sP')." OR LastModifiedDate > ".date('Y-m-d\T').str_pad((intval(date('H'))-1), 2, '0', STR_PAD_LEFT).':'.str_pad((intval(date('i'))+(60-intval($time))), 2, '0', STR_PAD_LEFT).date(':sP');
	}else{
		$query.="CreatedDate > ".date('Y-m-').str_pad((intval(date('d'))-1), 2, '0', STR_PAD_LEFT).'T'.str_pad((intval(date('H'))+23), 2, '0', STR_PAD_LEFT).':'.str_pad((intval(date('i'))+(60-intval($time))), 2, '0', STR_PAD_LEFT).date(':sP')." OR LastModifiedDate > ".date('Y-m-').str_pad((intval(date('d'))-1), 2, '0', STR_PAD_LEFT).'T'.str_pad((intval(date('H'))+23), 2, '0', STR_PAD_LEFT).':'.str_pad((intval(date('i'))+(60-intval($time))), 2, '0', STR_PAD_LEFT).date(':sP');
	}
//	echo $query;exit;
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
	
    $json_response = curl_exec($curl);
    curl_close($curl);
	return $json_response;   	
}
//db_leads();

function add_note($dataArray){
	global $access_token;
	global $instance_url;
    
    $url = "$instance_url/services/data/v20.0/sobjects/Task/";

    $content = json_encode($dataArray);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 201 ) {
        return ("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }

    curl_close($curl);
	
	return $json_response;	
}
function add_bulk_calls($dataArray){
	global $access_token;
	global $instance_url;
    
	updateData("insert into twilio_debug set message=' CALL - add_bulk_calls' , time_stamp ='".date("d-m-Y H:i:s")."'");
    $url = "$instance_url/services/data/v20.0/sobjects/Task/";

	foreach($dataArray as $call){
	updateData("insert into twilio_debug set message=' CALL - add_bulk_calls in foreach' , time_stamp ='".date("d-m-Y H:i:s")."'");
		$content = json_encode($call);
	
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER,
				array("Authorization: OAuth $access_token",
					"Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
	
		$json_response = curl_exec($curl);
	
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	
		if ( $status != 201 ) {
			updateData("insert into twilio_debug set message='"."Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl)."' , time_stamp ='".date("d-m-Y H:i:s")."'");
		}else{
			updateData("insert into twilio_debug set message='".json_decode($json_response)."' , time_stamp ='".date("d-m-Y H:i:s")."'");
		}
	
		curl_close($curl);
//		echo "1 task created";
	}
		
}
function get_tasks_of($Id) {
	global $access_token;
	global $instance_url;
    	
	$query = "SELECT RecordingURL__c, Description from Task where whoId = '{$Id}' ORDER BY CreatedDate DESC";
	$url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_HTTPHEADER,
	array("Authorization: OAuth $access_token"));
	
	$json_response = curl_exec($curl);
	//var_dump($json_response);
	
	$json_response = curl_exec($curl);
    curl_close($curl);

	return $json_response;
}
?>
