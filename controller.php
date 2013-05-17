<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
}
//5163137980 - Lisa Bretschneider

$page = "";
$notification = "";	

purifyInputs();

if(isset($_POST['page']))
{
	$page = addslashes($_POST['page']);	
}
else{
	$page = getOne("SELECT `page_name` FROM `pages` WHERE `is_active`=1 AND `page_id`=(select landing_page from user_groups where group_id = '".$_SESSION['user_group']."')");
}

checkPagePermissions($page);

$function = "";
if(isset($_REQUEST['function']))
{
	$function = $_REQUEST['function'];
	
	$is_copy=false;// used later in code
	$is_edit=false;
	$is_exist=false;
	switch($page)
	{		
		//**********************************************************************************************************************************
		//**********************************************************************************************************************************
		case "manage_pages.php":
			include('sub_controller/sc_pages.php');
			break;
		//**********************************************************************************************************************************
		case "manage_groups.php":
			include('sub_controller/sc_groups.php');
			break;
		//**********************************************************************************************************************************
		case "manage_users.php":
			include('sub_controller/sc_users.php');	
			break;
		//**********************************************************************************************************************************
		case "call_platform.php":
			include('sub_controller/sc_call_platform.php');	
			break;	
		//**********************************************************************************************************************************
		case "home.php":
			include('sub_controller/sc_home.php');	
			break;
		
		//**********************************************************************************************************************************
		case "settings.php":
			include('sub_controller/sc_settings.php');	
			break;
		
	}
}
//echo $function;exit;
	$pageTitle = getOne("Select `title` from pages where page_name='".$page."'");
	//$current_page_id=getOne("Select `page_id` from pages where page_name='".$page."'");
	//$pageTitle = getPageTitle('1',$_SESSION['preferred_language'],$current_page_id);

    echo "<span id='userStatus' style=\"color:#bbb;margin-left:73px;font-weight:bold;float:right;\">Welcome: ".$_SESSION['name'];
	//buildLanguageBox();
	echo "</span>";
    echo"<h2>Twilio-Salesforce Call Platform</h2>";
	echo "<div>
			<ul class='switch_container'>
				<li><a id='switch_off' href='#'>OFF</a></li>
				<li><a id='switch_on' href='#'>ON</a></li>
			</ul>
		</div>";
	buildUserMenuMain($page);
	echo "</div>";
	echo "<div id='wrapper'>";
	echo "<div id='sidebar'>";
	include_once('sidebar.php');
	echo "</div>";
	echo "<div id='content'>";
	echo "<div id='box'>";
	echo "<div id='incoming_call_alert'><span class='message'></span> <span class='phone_number'></span> <span class='controls'><input type='button' value='' class='buttonpick' onclick='pickCall();'><input type='button' value='' class='buttonrejectincoming' onclick='rejectCall();'><input type='button' value='Hold Call' id='hold_btn' onclick='putCallOnHold();'><input type='button' value='Transfer Call' id='transfer_btn' onclick='transferCall();'></span><div class='blinking'></div></div><div id='multiple_callers_div' style='display:none;'>Select Caller<span id='callers'></span></div><div id='resume_button' style='display:none;padding: 5px;'><input type='button' value='Resume' id='resume_btn' class='' onclick='resumeCall();'></div>";
//	echo "<form name=\"mainForm\" id=\"mainForm\" action=\"\" method=\"post\" enctype=\"multipart/form-data\">";

	echo "<input type='hidden' name='page' id='page'/>";
	//value='".(isset($_POST['page'])?$_POST['page']:"")."'
	echo "<input type='hidden' name='function' id='function' />";
	//  value='".(isset($_POST['function'])?$_POST['function']:"")."' 
	echo "<h3 id='page_title'>".$pageTitle."</h3>";
	if($notification != "" )
	{
		echo "<div style='text-align:center' >".populateNotification($notification)."</div>";
	}
	echo "<div id='main_content_div'>";
	if(!is_file($page)){
		include('uc.php');
	}
	else{
		include_once($page);
	}
	echo "</div>";
	echo "<div id='sidebar_content_div'>";
	echo "</div>";

	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "<div class='clr'></div>";
	echo "</div>";
	echo "</form>";

?>