<?php
session_start();
	if (!$_SESSION[id]) {
	exit("ACCESS DENIED!");
	}
include "class/users.class.inc";
$comp = 'users';
$users = new Users;
$userList = $users->getData();
	
	if (isset($_GET['action'])) {
  		$action = $_GET['action'];
	}
		if (isset($_GET['id'])) {
  		$userId = $_GET['id'];
	}

?>
<html>
	<head>
		<title>Users</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen, print">
		<script>
			function confirmDelete(delUrl) {
  				if (confirm("Are you sure you want to delete")) {
    				document.location = delUrl;
  				}
			}
		</script>
	</head>
	<body>
	<div id="wrapper">
	<?php 
	

		include "includes/admin-nav.inc";
		
		if ($action == 'edit') {
			if ($_POST[id]) {
				if ($_POST['newPassword'] == $_POST['newPassword2']) {
					$password = $_POST['newPassword'];
					$_POST['password'] = md5($password);
			 		$update = $users->updateRecord($_POST);
			 		$message = " - User Updated";
			 	} else {
			 		$message = " - Passwords did NOT match!";
			 	
			 	}
			 }
			
			$where = "id = '" . $userId . "'";
			$user = $users->getData($where);
			include "includes/user-form.inc";
			
			} elseif ($action == 'add') {
				$hidden = 'new';
				if ($_POST[hidden] == 'new') {
					if ($_POST['newPassword'] == $_POST['newPassword2']) {
						$password = $_POST['newPassword'];
						$_POST['password'] = md5($password);
			 			$insert = $users->insertRecord($_POST);
			 			$message = " - User Added";
			 		} else {
			 			$message = " - Passwords did NOT match!";
			 		}
			 	}
			include "includes/user-form.inc";
		
			} else {
		 		if  ($action == 'delete') { 
		 			$where[id] = $userId;
					$delete = $users->deleteRecord($where);
		 		}
		echo '<div class="table">
					<div class="table-row">
						<div><a href="?&action=add">Add a User</a></div>
					</div>
					<div class="clear"></div>
					<div class="table-row">
					<div class="table-item" style="width:30px">&nbsp;</div>
					<div class="table-item" style="width:30px">&nbsp;</div>
					<div class="item-short">ID</div>
					<div class="item-long">User Name</div>
					<div class="item-short">First Name</div>
					<div class="item-short">Last Name</div>
					<div class="item-short">User Name</div>
					<div class="item-long">Email</div>
					<div class="item-short">&nbsp;</div>
					<div class="clear"></div>
					</div>';
		foreach ($userList as $user) {
			echo '<div class="table-row">
		<div class="table-item" style="width:30px"><a href="?comp=' . $comp . '&action=edit&id=' . $user['id'] . '" title="EDIT / VIEW"><img src="./images/edit.gif"></a></div>
    	<div class="table-item" style="width:30px"><a href="javascript:confirmDelete(\'?comp=' . $comp . '&action=delete&id=' . $user['id'] . '\')"><img src="./images/delete.gif"></a></div>
					<div class="item-short">' . $user['id'] . '</div>    			
					<div class="item-long"><a href="?&id=' . $user['id'] . '&action=edit">' . $user['userName'] . '</a></div>
					<div class="item-short">' . $user['firstName'] . '</div>
					<div class="item-short">' . $user['lastName'] . '</div>
					<div class="item-short">' . $user['userName'] . '</div>
					<div class="item-long">' . $user['email'] . '</div>
				<div class="clear"></div></div>
				';
		}
		echo '</div>';
		}
	?>
	
	
	</div>
	</body>
</html>