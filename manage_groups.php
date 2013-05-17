<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
require_once("library/groupObject.php");
$groupObject=new GroupManager();
$allGroups=$groupObject->getAllGroups();
require_once("library/pageObject.php");
$pageObject=new PageManager();
      /* <?=$pageObject->getTreeString();?>  */
?>
<input type="hidden" name='group_id' id='group_id'  />
<div class='grid-24'>
  <div class="widget widget-table">
    <div class="widget-content">
      <span class="datatable_addlink"><a href="javascript:callPage('add_new_group.php')" class="btn btn-small btn-grey"><span class="icon-plus"></span>Add New</a></span>
      <table class="table table-bordered table-striped data-table display">
        <thead>
          <tr>
            <th>Sr. No.</th>
            <th>Group Name</th>
            <th>Comments</th>
            <th>Landing Page</th>
            <th class="col_actions" style="text-align:center;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?
		  for($i=0;$i<sizeof($allGroups);$i++)
		  {
			  ?>
              	<tr class="gradeA">
                <td><?=$i+1?></td>
                <td><?=$allGroups[$i]['group_name']?></td>
                <td><?=$allGroups[$i]['comments']?></td>
                <td><?=$pageObject->getPageNameUsingId($allGroups[$i]['landing_page']);?></td>
                <td class="col_actions"> <a href="javascript:editGroup('<?=$allGroups[$i]['group_id']?>');" class="btn btn-small btn-grey"><img src="images/icons/user_edit.png" title="Edit Group" width="16" height="16"></a> <a href="javascript:deleteGroup('<?=$allGroups[$i]['group_id']?>');" class="btn btn-small btn-grey"><img src="images/icons/user_delete.png" title="Delete Group" width="16" height="16"></a></td>
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