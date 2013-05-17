<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
require_once("library/userObject.php");
$userObject=new UserManager();
$allUsers=$userObject->getAllUsers();
require_once("library/groupObject.php");
$groupObject=new GroupManager();
?>
<input type="hidden" name='user_id' id='user_id'  />
<div class='grid-24'>
  <div class="widget widget-table">
    <div class="widget-content">
      <span class="datatable_addlink"><a href="javascript:callPage('add_new_user.php')" class="btn btn-small btn-grey"><span class="icon-plus"></span>Add New</a></span>
      <table class="table table-bordered table-striped data-table display">
        <thead>
          <tr>
            <th>Sr. No.</th>
            <th>User Name</th>
            <th>Name</th>
            <th>User Group</th>
            <th>User E-mail</th>
            <th>User Phone</th>
            <th class="col_actions" style="text-align:center;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?
		  for($i=0;$i<sizeof($allUsers);$i++)
		  {
			  ?>
              	<tr class="gradeA">
                <td><?=$i+1?></td>
                <td><?=$allUsers[$i]['user_name']?></td>
                <td><?=$allUsers[$i]['name']?></td>
                <td><?=$groupObject->getGroupNameUsingId($allUsers[$i]['user_group']);?></td>
                <td><?=$allUsers[$i]['user_email']?></td>
                <td><?=$allUsers[$i]['user_phone']?></td>
                <td class="col_actions"> <a href="javascript:editUser('<?=$allUsers[$i]['user_id']?>');" class="btn btn-small btn-grey"><img src="images/icons/user_edit.png" title="Edit user" width="16" height="16"></a> <a href="javascript:deleteUser('<?=$allUsers[$i]['user_id']?>');" class="btn btn-small btn-grey"><img src="images/icons/user_delete.png" title="Delete user" width="16" height="16"></td>
          		</tr>              
              <?
		  }
		  ?>        
        </tbody>
      </table>

    </div>
    <!-- .widget-content --> 
    
  </div>
</div>