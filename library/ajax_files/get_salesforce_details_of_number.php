<?
/*
(862)220-8402
(914)424 1461
609-5339070
7634-404-9356
9078023
973 618-0011
954 3483820
914490-9179
914 9532295
917 445 5997
9381894 9059557
*/
	session_start();
//	echo "number"
	set_time_limit(0);
	$number=$_REQUEST['number'];
	$number_array=array($number);
//	$number_with_brackets='('.substr($number,-10,3).') '.substr($number,-7,3).'-'.substr($number,-4);
	array_push($number_array,'('.substr($number,-10,3).') '.substr($number,-7,3).'-'.substr($number,-4)); //(862) 220-8402
	array_push($number_array,'('.substr($number,-10,3).')'.substr($number,-7,3).'-'.substr($number,-4)); //(862)220-8402
	array_push($number_array,'('.substr($number,-10,3).')'.substr($number,-7,3).' '.substr($number,-4)); //(862)220 8402
	array_push($number_array,'('.substr($number,-10,3).') '.substr($number,-7,3).' '.substr($number,-4)); //(862) 220 8402
	array_push($number_array,'('.substr($number,-10,3).') '.substr($number,-7,3).substr($number,-4)); //(862) 2208402
	array_push($number_array,substr($number,-10,3).'-'.substr($number,-7,3).'-'.substr($number,-4)); //862-220-8402
	array_push($number_array,substr($number,-10,3).'-'.substr($number,-7,3).substr($number,-4)); //862-2208402
	array_push($number_array,substr($number,-10,3).'-'.substr($number,-7,3).' '.substr($number,-4)); //862-220 8402
	array_push($number_array,substr($number,-10,3).' '.substr($number,-7,3).' '.substr($number,-4)); //862 220 8402
	array_push($number_array,substr($number,-10,3).substr($number,-7,3).'-'.substr($number,-4)); //862220-8402
	array_push($number_array,substr($number,-10,3).' '.substr($number,-7,3).substr($number,-4)); //862 2208402
	array_push($number_array,substr($number,-10,3).' '.substr($number,-7,3).'-'.substr($number,-4)); //862 220-8402
	if(strlen($number)>10){
		array_push($number_array,substr($number,-11,4).'-'.substr($number,-7,3).'-'.substr($number,-4)); //7862-220-8402
		array_push($number_array,substr($number,-10));
	}
//	var_dump($number_array);exit;
	header('Content-type: application/json');
	require_once('../REST/rest_functions.php');
	$lead_details=get_name_of_number_leads($number_array);
	$lead_decoded=json_decode($lead_details,true);
	$tasks = get_tasks_of($lead_decoded['records'][0]['Id']);
	echo '{"lead_details":'.$lead_details.',"all_tasks":'.$tasks.'}';
?>
