<?
    session_start();
	set_time_limit(0);
//	header('Content-type: application/json');
	require_once('../salesforceLocalObject.php');
	$salesforceObject=new SalesForceLocalManager();
	$result = $salesforceObject->get_all_contacts();
	$table_html= "<table class='table table-bordered table-striped data-table display contact_table'><thead><tr><th>Sr. No.</th><th>Name</th><th class='email_col'>Email</th><th>LeadSource</th><th>Phone</th><th>MobilePhone</th><th>Actions</th></tr></thead><tbody>";
	$i=0;
	foreach($result as $contact){
		$table_html.="<tr><td>".($i+1)."</td><td><a href='#' onclick=\"show_contact_details('".$contact['Id']."');\">".(($contact['Name']==null)?put_in_center("-"):$contact['Name'])."</a></td><td class='email_col'>".(($contact['Email']==null)?put_in_center("-"):$contact['Email'])."</td><td>".(($contact['LeadSource']==null)?put_in_center("-"):$contact['LeadSource'])."</td><td>".(($contact['Phone']==null)?put_in_center("-"):$contact['Phone'])."</td><td>".(($contact['MobilePhone']==null)?put_in_center("-"):$contact['MobilePhone'])."</td><td><a href='#' onclick='call_lead(\"".$contact['Name']."\",\"".$contact['Phone']."\",\"".$contact['Id']."\")'>Call</a></td></tr>";
		$i++;
/*
var table_html= "<table class='table table-bordered table-striped data-table display contact_table'><thead><tr><th>Sr. No.</th><th>Name</th><th class='email_col'>Email</th><th>LeadSource</th><th>Phone</th><th>MobilePhone</th><th>Actions</th></tr></thead><tbody>";
							//alert(resp[0].Id);
							for(i=0;i<resp.length;i++){
								table_html+="<tr><td>"+(i+1)+"</td><td><a href='#' onclick=\"show_contact_details('"+resp[i].Id+"');\">"+((resp[i].Name==null)?put_in_center("-"):resp[i].Name)+"</a></td><td class='email_col'>"+((resp[i].Email==null)?put_in_center("-"):resp[i].Email)+"</td><td>"+((resp[i].LeadSource==null)?put_in_center("-"):resp[i].LeadSource)+"</td><td>"+((resp[i].Phone==null)?put_in_center("-"):resp[i].Phone)+"</td><td>"+((resp[i].MobilePhone==null)?put_in_center("-"):resp[i].MobilePhone)+"</td><td><a href='#' onclick='call_lead(\""+resp[i].Name+"\",\""+resp[i].Phone+"\",\""+resp[i].Id+"\")'>Call</a></td></tr>";
							}
							table_html+="</tbody> </table>";
*/
//		echo "<pre>";print_r($contact);echo "</pre>";
	}
	$table_html.="</tbody> </table>";
	echo $table_html;
	
	 //echo json_encode($result);
function put_in_center($str){
	return "<div style='text-align:center;'>".$str."</div>";
}
?>