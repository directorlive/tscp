
<div id='Popup Content'>
<div class="popInputDiv" style="padding-bottom:10px">
<span class="popInputLeft">User Name:</span> 
<span class="popInputRight"><input type="text" name="user_name" id="user_name"></span> 
</div>
<br />
<div class="popInputDiv" style="padding-bottom:10px">
<span class="popInputLeft">Password:</span> 
<span style="float:right; min-width:40%"> <input type="password" name="password" id="password"></span> 
</div>
<br />
<div class="popInputDiv" style="padding-bottom:10px">
<span  class="popInputLeft">Full Name:</span> 
<span  class="popInputRight"><input type="text" name="full_name" id="full_name"></span> 
</div>
<br />
<div class="popInputDiv" style="padding-bottom:10px">
<span  class="popInputLeft">Email Id:</span> 
<span  class="popInputRight"><input type="text" name="email" id="email"></span> 
</div>
<br />
<div class="popInputDiv">
<span  class="popInputLeft">Phone Number:</span> 
<span  class="popInputRight"><input type="text" name="user_phone_number" id="user_phone_number"></span> 
</div>
<br /> <br />

<input type="hidden" name="user_id" id="user_id" value=""></input>
<span id="addUser">
<input type="button" value="Add User" onClick="addUser('manage_administrators.php','addnewadmin')">
</span>
<span id="editUser" style="display:none">
<input type="button" value="Edit User" onClick="editUser('manage_administrators.php','editadmin')">
</span>
</div>