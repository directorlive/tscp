<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
}

function getAllLanguages(){
	return getData("SELECT * FROM `language_master`");
}
function buildLanguageBox(){
	$selectStr="<select name='language' onchange='javascript:changeLanguage();' style=\"font-size:10px;height15px;padding:0;\">";
	$allLanguages=getAllLanguages();
	foreach($allLanguages as $language){
		$selected="";
		if($language['id']==$_SESSION['preferred_language']){
			$selected=" selected='selected'";
		}
		$selectStr.="<option".$selected." value='".$language['id']."'>".$language['language_name']."</option>";
	}
	$selectStr.="</select>";
	echo $selectStr;
}
function getPageTitle($module_id,$language_id,$position_id){
	return getOne("SELECT `value` FROM `language_details` WHERE `module_id`='".$module_id."' AND `language_id`='".$language_id."' AND `position_id`='".$position_id."'");
//	echo ("SELECT `value` FROM `language_details` WHERE `module_id`='".$module_id."' AND `language_id`='".$language_id."' AND `position_id`='".$position_id."'");
}

function buildUserMenu()
{
	$userGroup = $_SESSION['user_group'];
	$pageArray = getData("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 1");
	
	?>
    <script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
    <ul id="MenuBar1" class="MenuBarHorizontal">
      <?
	  	for($i=0; $i<sizeof($pageArray);$i++)
		{
			?>
            <li><a class="MenuBarItemSubmenu" href="javascript:callPage('<?=$pageArray[$i]['page_name']?>')"><?=$pageArray[$i]['title']?></a>
            <?
				$subPageArray = getdata("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 2 and parent_page_id = '".$pageArray[$i]['page_id']."'");
				if(sizeof($subPageArray)>0)
				{
					echo "<ul>";
					for($j=0;$j<sizeof($subPageArray);$j++)
					{
					?>
                    	<li><a href="javascript:callPage('<?=$subPageArray[$j]['page_name']?>')"><?=$subPageArray[$j]['title']?></a></li>                   
                    <?
					}
					echo "</ul>";
				}				
			?>
         	</li>            
            <?
		}
	  ?>      
    </ul>
    <script type="text/javascript">
    var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
    </script>   
    <?	
}
/*
function buildUserMenuMain($pageName="")
{
	$userGroup = (int)$_SESSION['user_group'];
	$userName = getOne("select name from users where user_id = '".$_SESSION['user_id']."'");
	$pageArray = array();
	if($userGroup != 1)
	{
		$pageArray = getData("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 1 order by page_id");
	}
	else
	{
		$pageArray = getData("select * from pages where is_active = 1 and level = 1 order by page_id");
	}
	?>
    <div id="topmenu">
		<ul>
     <?
	 	$selected_page_id=0;
		$currentPage = addslashes($pageName);
		$currentPageId = getOne("select page_id from pages where page_name = '".$currentPage."'");
		
	  	for($i=0; $i<sizeof($pageArray);$i++)
		{
			$css_class = '';
			if($currentPageId == $pageArray[$i]['page_id'])
			{
				$css_class = " class='current'";
				$selected_page_id=$currentPageId;
			}
			
			?>
			<li<?=$css_class?>><a href="javascript:callPage('<?=$pageArray[$i]['page_name']?>')"><?=$pageArray[$i]['title']?></a></li>            
            <?
        }
		
	?>
        <li><a href="javascript:userLogout('')" class="last"><span>Logout</span></a></li>
        </ul>
	</div>
    </div>
	<?
		if($userGroup != 1)
		{
			$subPageArray = getdata("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 2 and parent_page_id = '".$selected_page_id."'");
		}
		else
		{
			$subPageArray = getdata("select * from pages where is_active = 1 and level = 2 and parent_page_id = '".$selected_page_id."'");
		}
		?>
			<div id="top-panel">
				 <div id="panel">
		<?
		if(sizeof($subPageArray)>0)
		{
			?>
					<ul>
					<?
						for($i=0;$i<sizeof($subPageArray);$i++)
						{
							//var_dump($subPageArray[$i]);exit;
						?>
							<li><a href="javascript:callPage('<?=$subPageArray[$i]['page_name']?>')"><?=$subPageArray[$i]['title']?></a>             
						<?
						}
					?>
					</ul>
			<?
		}
		?>
				</div>
			</div>
		<?
}
*/
function buildUserMenuMain()
{
	$userGroup = $_SESSION['user_group'];
	$userName = getOne("select name from users where user_id = '".$_SESSION['user_id']."'");
	$pageArray = getData("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 1 order by `tab_order` ASC");
	
	?>
    <div id="topmenu">
    <ul>
     <?
	  	for($i=0; $i<sizeof($pageArray);$i++)
		{
			?>
			<li><a href="javascript:callPage('<?=$pageArray[$i]['page_name']?>')" class="parent"><span><?=$pageArray[$i]['title']?></span></a>
			<?
				$subPageArray = getdata("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 2 and parent_page_id = '".$pageArray[$i]['page_id']."' order by `tab_order` ASC");
				if(sizeof($subPageArray)>0)
				{
					echo "<ul class=\"mysubmenu\">";
					for($j=0; $j<sizeof($subPageArray); $j++)
					{
					?>
								 <? $sub_sub_PageArray = getdata("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 3 and parent_page_id = '".$subPageArray[$j]['page_id']."' order by `tab_order` ASC");
								
                           if(sizeof($sub_sub_PageArray)>0)
							{
								echo "<li class='sidemenu_parent'><a href=\"javascript:callPage('".$subPageArray[$j]['page_name']."')\"><span>".$subPageArray[$j]['title']."</span></a>";
								echo "<div class=\"sidemenu_container\">";	
								echo "<ul class=\"sidemenu\">";
								for($k=0; $k<sizeof($sub_sub_PageArray); $k++)
								{
								?>
									
									<li><a href="javascript:callPage('<?=$sub_sub_PageArray[$k]['page_name']?>')"><span><?=$sub_sub_PageArray[$k]['title']?></span></a></li>
										
								<?
								}
								echo "</ul>"; 
								echo "</div></li>";
							}else{?>
                    	<li><a href="javascript:callPage('<?=$subPageArray[$j]['page_name']?>')"><span><?=$subPageArray[$j]['title']?></span></a></li>
                    <? }
					}
					echo "</ul>";
				}				
			?>
         	</li>            
            <?
        }
	?>
    <li><a href="javascript:userLogout('')" class="last"><span>Logout</span></a>
    </ul>
</div>
    <?
}
function buildSidebar()
{
	$userGroup = (int)$_SESSION['user_group'];
	$userName = getOne("select name from users where user_id = '".$_SESSION['user_id']."'");
	$pageArray = array();
	if($userGroup != 1)
	{
		$pageArray = getData("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 1 order by page_id");
	}
	else
	{
		$pageArray = getData("select * from pages where is_active = 1 and level = 1 order by page_id");
	}
	?>
		<ul>
     <?
/*	 	$selected_page_id=0;
		$currentPage = addslashes($pageName);
		$currentPageId = getOne("select page_id from pages where page_name = '".$currentPage."'");
*/		
	  	for($i=0; $i<sizeof($pageArray);$i++)
		{
/*			$css_class = '';
			if($currentPageId == $pageArray[$i]['page_id'])
			{
				$css_class = " class='current'";
				$selected_page_id=$currentPageId;
			}
*/			
			?>
			<li<? //$css_class?>><h3><a href="javascript:callPage('<?=$pageArray[$i]['page_name']?>')"><?=$pageArray[$i]['title']?></a></h3>
				<?
                    if($userGroup != 1)
                    {
                        $subPageArray = getdata("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 2 and parent_page_id = '".$pageArray[$i]['page_id']."'");
                    }
                    else
                    {
                        $subPageArray = getdata("select * from pages where is_active = 1 and level = 2 and parent_page_id = '".$pageArray[$i]['page_id']."'");
                    }
                    
                    if(sizeof($subPageArray)>0)
                    {
                        ?>
                                <ul>
                                <?
                                    for($j=0;$j<sizeof($subPageArray);$j++)
                                    {
                                        //var_dump($subPageArray[$i]);exit;
                                    ?>
                                        <li><a href="javascript:callPage('<?=$subPageArray[$j]['page_name']?>')"><?=$subPageArray[$j]['title']?></a>             
                                    <?
                                    }
                                ?>
                                </ul>
                 	<?
					}
					?>      
            </li>
            <?
        }
		
	?>
        </ul>
		<?
}

function purifyInputs()
{
	foreach($_REQUEST as $key=>$value)
	{
		if(is_array($value)){	//Change: Msnthan Tripathi:25-Aug-2012. The function is giving error when passed array of checkboxes in query string.
			foreach($value as $keySub => $valueSub){
				$value[$keySub] = addslashes($valueSub);
			}
		}else{
			$_REQUEST[$key] = addslashes($value);
		}
	}
}

function getAllUserGroups()
{
	$getQuery = "Select * from user_groups order by group_id";
	$userGroups = getData($getQuery);
	return $userGroups;
}

function getAllGlobalAdmins()
{
	$getQuery = "Select * from users where user_group = 1 order by user_id";
	$userGroups = getData($getQuery);
	return $userGroups;
}

function getAllAdmins()
{
	$getQuery = "Select * from users where user_group = 2 order by user_id";
	$userGroups = getData($getQuery);
	return $userGroups;
}

function getAllEmployees()
{
	$getQuery = "Select * from users where user_group = 3 order by user_id";
	$userGroups = getData($getQuery);
	return $userGroups;
}


function setActiveInactive($value)
{
	if($value=='1')
	{
		echo "<img border=0 width='15px' src='images/yes.png' title='Active' />";
	}
	else
	{
		echo "<img border=0 width='15px' src='images/no.png' title='Active' />";
	}
}

function createPopup($dataPage, $header)
{
	?>
    <div id="boxes">

	<div id="dialog" class="window">
	<span id='popHeaderSpn'><?=$header?></span> | 
	<a href="#" class="close"/>Close</a>
    <br /><br />
    <? include_once($dataPage) ?>
	</div>
 	
	<!-- Mask to cover the whole screen -->
 	<!-- <div id="mask"></div> -->
	</div>    
    <?	
}

function populateNotification($notificationString)
{
	if(strstr($notificationString,"Successfully"))
	{
		return "<span stlyle class='successNot'>".$notificationString."</span>";
	}
	else
	{
		return "<span stlyle class='failureNot'>".$notificationString."</span>";
	}
}

function addNewGroup($group_name,$group_comments,$landing_page)
{
	$insQuery = "insert into user_groups set
					group_name = '".$group_name."',
					is_active = '1',
					comments = '".$group_comments."',
					landing_page = '".$landing_page."'					
				";
	updateData($insQuery);
	return "Group Added Successfully!!";
	
}

function addUser($user_name,$password,$full_name,$userGroup,$email,$user_phone_number)
{
	$CheckUserExists = getOne("select user_name from users where user_name = '".$user_name."'");
	
	if(trim($CheckUserExists) != "")
	{
		return "Duplicate User Found. Please use a different User Name.";
	}
	
	$spclCharArr = array(' ', '-', '(', ')' , '/'); 
	
	$user_phone_number = str_replace($spclCharArr,'',$user_phone_number);	
	
	$insQuery = "insert into users set
					user_group = '".$userGroup."',
					user_name = '".$user_name."',
					is_active = '1',
					user_password = sha1('".$password."'),
					name = '".$full_name."',
					user_email = '".$email."',
					user_phone = '".$user_phone_number."'								
				";
	updateData($insQuery);
	return "User Added Successfully!!";
	
}

function editUser($user_id, $user_name,$password,$full_name,$userGroup,$email,$user_phone_number)
{
	$CheckUserExists = getOne("select user_name from users where user_name = '".$user_name."' and user_id != '".$user_id."'");
	
	if(trim($CheckUserExists) != "")
	{
		return "Duplicate User Found. Please use a different User Name.";
	}
	
	$updateQuery = "update users set
						user_group = '".$userGroup."',
						user_name = '".$user_name."',
						is_active = '1',
						user_password = sha1('".$password."'),
						name = '".$full_name."',
						user_email = '".$email."',
						user_phone = '".$user_phone_number."'
					where
						user_id = '".$user_id."' and
						user_group = '".$userGroup."'			
				";
	updateData($updateQuery);
	return "User Updated Successfully!!";
}

function  deleteUser($user_id, $userGroup)
{
	if($user_id == '1')
	{
		return "System Super-User cannot be deleted!!";
	}
	else
	{
		$delQry = "delete from users where user_id = '".$user_id."' and user_group = '".$userGroup."'";
		updateData($delQry);
		return "User Deleted Successfully!!";
	}
}

function getUserName($user_id)
{
	$userName = getOne("select name from users where user_id = '".$user_id."'");
	return $userName;
}


function getAdminUsersCombo($boxName)
{
	$adminUsers = getAllAdmins();
	createComboBox($boxName,'user_id','name',$adminUsers);
}

function getGroupCombo($boxName)
{	session_start();
	$userGroup = (int) $_SESSION['user_group'];
	?>
    <select style="width:240px" name="<?=$boxName?>" id="<?=$boxName?>">
    	<? if($userGroup == 1 ) { ?>
        <option value='1'>Super Admin</option>
        <? } if(($userGroup == 2) || ($userGroup == 1) ) { ?>
        <option value='2'>Administrator</option>
        <? }?>
        <option value='3'>On Call Employee</option>    
    </select>
    
    <?
}

function createComboBox($name,$value,$display, $data, $blankField=false, $selectedValue="",$display2="",$firstFieldValue='Please Select')
{
	echo "<select id='".$name."' name = '".$name."' >";
	if($blankField){
		echo "<option value='0'>".$firstFieldValue."</option>";
	}
	for($d=0;$d<sizeof($data);$d++)
	{
		$selectedString = "";
		$selectedValue = trim($selectedValue);
		if($data[$d][$value] == $selectedValue)
		{
			$selectedString = " selected = 'selected' ";
		}
		
		echo "<option value='".$data[$d][$value]."' ".$selectedString.">".$data[$d][$display];
		if($display2!=""){
			echo " (".$data[$d][$display2].")";
		}
		echo "</option>";
	}
	echo "</select>";
}
function getActiveEmployee($ph_id)
{
	$activeUser = getOne("select user_id from schedule where ph_id = '".$ph_id."' and is_active = '1'");
	return $activeUser;
}

function getAssignedBy($ph_id)
{
	$assignedBy = getOne("select assigned_by from schedule where ph_id = '".$ph_id."' and is_active = '1'");
	return $assignedBy;
}


function getTwlioCreds()
{
	$twilioArr = array();
	$twilioArr['sid'] = getConfigValue('twilio_sid');
	$twilioArr['auth_token'] = getConfigValue('twilio_auth_token');
	$twilioArr['app_sid'] = getConfigValue('twilio_app_sid');
	return $twilioArr;
}


function getConfigValue($key)
{
	return $value = getOne("Select config_value from settings where config_name = '".$key."'");
}

function getSalesforceSettings(){
	$salesforce_arr = array();
	$salesforce_arr['uname'] = getSettingValue('salesforce_uname');	
	$salesforce_arr['pass'] = getSettingValue('salesforce_pass');	
	$salesforce_arr['security_token'] = getSettingValue('salesforce_security_token');
	$salesforce_arr['client_id'] = getSettingValue('salesforce_client_id');
	$salesforce_arr['client_secret'] = getSettingValue('salesforce_client_secret');
	//print_r($salesforce_arr); exit;
	return $salesforce_arr;
	
}
function getSettingValue($key){
	return $value = getOne("select config_value from settings where config_name = '".$key."'");
}

function updateConfigValue($key,$value)
{
	updateData("update settings set config_value = '".$value."' where config_name = '".$key."'");
}

function updateSettings($sid, $authToken,$twilio_app_sid,$salesforce_uname,$salesforce_pass,$salesforce_security_token,$salesforce_client_id,$salesforce_client_secret)
{
	updateConfigValue('twilio_sid',$sid);
	updateConfigValue('twilio_auth_token',$authToken);
	updateConfigValue('twilio_app_sid',$twilio_app_sid);
	updateConfigValue('salesforce_uname',$salesforce_uname);
	updateConfigValue('salesforce_pass',$salesforce_pass);
	updateConfigValue('salesforce_security_token',$salesforce_security_token);
	updateConfigValue('salesforce_client_id',$salesforce_client_id);
	updateConfigValue('salesforce_client_secret',$salesforce_client_secret);
	return "Settings Updated Successfully!!";
}

function buyNumber($newNumber)
{
	require_once('customvbx.class.php');
	$vbxClient = new TwilioExt();
	$status = $vbxClient->buyNumber($newNumber);
	if($status == "Success")
	{	$absNumber = substr($newNumber, -10); 
		addPhoneNumber($newNumber,"");
		return "Success";
	}
	else
	{
		return $status;
	}
	
}

function mailUser($transcript, $phoneNumber, $CallSid)
{	//echo "select user_id from schedule where ph_id = (select ph_id from phone_numbers where phone_number like '%".trim($phoneNumber)."') and is_active=1";
	 $inCallEmployeeId = getOne("select user_id from schedule where ph_id = (select ph_id from phone_numbers where phone_number like '%".trim($phoneNumber)."') and is_active=1");
	$inCallEmployeeMail = getOne("select user_email from users where user_id = '".$inCallEmployeeId."'");
	$voiceURL = getOne("select recording_url from incomming_calls where call_sid = '".$CallSid."'");
	
	
	if(trim($inCallEmployeeMail) != "")
	{
		$message = "
			<h3> New Call for you..!!</h3>
			<br />
			You have a new message.<br />
			Transcription: ".$transcript."<br />
			Voice Url: ".$voiceURL."<br /><br />
			Log in to VBX scheduler for more details.<br />
			Thanks.		
		";
		mailEmployee($inCallEmployeeMail, $message);
	}
}

function mailEmployee($to, $message) 
{		
				$headers = "From: VBX Scheduler <admin@poc.lifechurch.tv>\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$subject = 'New Call for you';
				
				if(mail($to,$subject, $message,$headers))
					//{}
					echo $testyry=  "Mail sent .........";
				else
					echo $testyry=  "Mail not sent........";
		
}

function getAllPhoneNumbers()
{
	$getQuery = "Select * from phone_numbers order by ph_id";
	$userGroups = getData($getQuery);
	return $userGroups;
}


function editPhoneNumber($phone_id,$phone_number,$text_message)
{
	$CheckNumberExists = getOne("select phone_number from phone_numbers where phone_number = '".$phone_number."' and ph_id != '".$phone_id."'");
	
	if(trim($CheckNumberExists) != "")
	{
		return "Phone Number already exists in the System!";
	}
	
	$updateQuery = "update phone_numbers set
						phone_number = '".$phone_number."',
						text_message = '".$text_message."',
						is_active = '1'
					where
						ph_id = '".$phone_id."'		
				";
	updateData($updateQuery);
	return "Phone Number settings updated Successfully!!";
}

function addPhoneNumber($phone_number,$text_message)
{
	
	$CheckNumberExists = getOne("select phone_number from phone_numbers where phone_number = '".$phone_number."'");
	
	if(trim($CheckNumberExists) != "")
	{
		return "Phone Number already exists in the System!";
	}
	
	$insQuery = "insert into phone_numbers set
					phone_number = '".$phone_number."',
					text_message = '".$text_message."',
					is_active = '1'				
				";
	updateData($insQuery);
	return "Phone Number Added Successfully!!";
	
}

function deletePhoneNumber($ph_id)
{
	$delQry = "Delete from phone_numbers where ph_id = '".$ph_id."'";
	updateData($delQry);
	return "Phone Number deleted Successfully!!";
}

function getAllPhones_from_salesforce_leads()
{
//	require_once("Config.php");
	$getQuery = "Select Id, SUBSTR(replace(replace(replace(replace(Phone,' ',''),'(',''),')',''),'-',''),-10) as Phone
	FROM
	salesforce_leads";
	//WHERE
	// Phone RLIKE '^[+]?[-() 0-9]+$'";
	$leadphones = getData($getQuery);
	foreach($leadphones as $record){
		$formatted_phone=$record['Phone'];
		if($record['Phone']!==""){
		$formatted_phone="+1".$formatted_phone;
	}
	updateData("Update salesforce_leads set formated_phone ='".$formatted_phone."' Where Id='".$record['Id']."'" );
	// echo ("Update salesforce_leads set formated_phone='".$formatted_phone."' Where Id='".$record['Id']."'"."<br />" );
}



}



?>