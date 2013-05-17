<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
require_once("library/pageObject.php");
$pageObject=new PageManager();
$allPages=$pageObject->getAllPages();
?>
<input type="hidden" name='page_id' id='page_id'  />
<div class='grid-24'>
  <div class="widget widget-table">
    <div class="widget-content">
      <span class="datatable_addlink"><a href="javascript:callPage('add_new_page.php')" class="btn btn-small btn-grey"><span class="icon-plus"></span>Add New</a></span>
      <table class="table table-bordered table-striped data-table display">
        <thead>
          <tr>
            <th>Sr. No.</th>
            <th class="page_level">Level</th>
            <th>Page Title</th>
            <th>Page Name</th>
            <th>Description</th>
            <th class="col_actions" style="text-align:center;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?
		  for($i=0;$i<sizeof($allPages);$i++)
		  {
			  ?>
              	<tr class="gradeA">
            	<td><?=$i+1?></td>
                <td class="page_level_<?=$allPages[$i]['level']?>"><?=$allPages[$i]['level']?></td>
            	<td><?=$allPages[$i]['title']?></td>
                <td><?=$allPages[$i]['page_name']?></td>
                <td><?=$allPages[$i]['description']?></td>
                <td class="col_actions"> <a href="javascript:editPage('<?=$allPages[$i]['page_id']?>');" class="btn btn-small btn-grey"><img src="images/icons/user_edit.png" title="Edit Page" width="16" height="16"></a> <a href="javascript:deletePage('<?=$allPages[$i]['page_id']?>');" class="btn btn-small btn-grey"><img src="images/icons/user_delete.png" title="Delete Page" width="16" height="16"></td>
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