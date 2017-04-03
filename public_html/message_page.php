<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once(dirname(__FILE__) . '/resources/lib/login-tools.php');
require_once(dirname(__FILE__) . '/resources/lib/database.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'Return Message',
	array('css/root.css'),
	array());
	
html5_nav();

$db = new UserDB;

if (isset($_POST['user_email'])){
	if ($_POST['user_password'] == $_POST['user_password_repeat']){
		if ($db->check_user_password($_SESSION['logged_in_user'], $_POST['user_password'])){
			$db->modifyEmail($_SESSION['logged_in_user'], $_POST['user_email']);
			echo "<p>Email successfully changed!</p>";
		} else {
			echo "<p>Password did not match our records</p>";
		}
	} else {
		echo "<p>Typed passwords did not match</p>";
	}
}

//Have to use regular expression to check password
if (isset($_POST['user_password_new'])){
	if ($_POST['user_password'] == $_POST['user_password_repeat']){
		if ($db->check_user_password($_SESSION['logged_in_user'], $_POST['user_password'])){
			
			$db->modifyPassword($_SESSION['logged_in_user'], $_POST['user_password_new']);
			echo "<p>Password successfully changed!</p>";
		} else {
			echo "<p>Password did not match our records</p>";
		}
	} else {
		echo "<p>Typed passwords did not match</p>";
	}
}




?>