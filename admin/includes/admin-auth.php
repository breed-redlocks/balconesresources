<?php
error_reporting(E_ALL);
session_start();
include "../class/users.class.inc";
include "settings.php";
	$members 	= new Users;
	$where 		= "userName = '" . $_POST[userName] . "'";
	$check 		= $members->getData($where);

	if (!$check) {
		$logMessage = 1;
		Header('Location: '.$adminUrl.'?logMessage='.$logMessage);
		exit();
	}

	if (md5($_POST['password']) == $check[0][password]) {
		foreach($check[0] as $key => $value) {
				if ($key != "password") {
					$_SESSION[$key]=$value;
				}
		}
	} else {
		$logMessage = 2;
	}
Header('Location: '.$adminUrl.'?logMessage='.$logMessage);
?>