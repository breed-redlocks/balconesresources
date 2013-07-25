<form acton="?&action=edit" method="post" name="user" id="admin">
	<input type="hidden" name="id" value="<?php echo $user[0][id]; ?>">
	<input type="hidden" name="hidden" value="<?php echo $hidden; ?>">
<fieldset>
<legend>User ID = <?php echo $user[0][id]; ?><?php echo $message; ?></legend>
<ol>	
	<li><label for="">First Name</label><input type="text" name="firstName" value="<?php echo $user[0][firstName]; ?>"></li>
	<li><label for="">Last Name</label><input type="text" name="lastName" value="<?php echo $user[0][lastName]; ?>"></li>
	<li><label for="">User Name</label><input type="text" name="userName" value="<?php echo $user[0][userName]; ?>"></li>
	<li><label for="">Email</label><input type="text" name="email" value="<?php echo $user[0][email]; ?>"></li>
	<li><label for="">New Password</label><input type="text" name="newPassword" value=""></li>
	<li><label for="">Re-type Password</label><input type="text" name="newPassword2" value=""></li>
	<li><label for="">Access</label><input type="text" name="userLevel" value="">&nbsp;1 = All Access - 0 = Limited</li>
</ol>
</fieldset>
<fieldset>
<button type="submit">Submit</button>
</fieldset>