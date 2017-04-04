<?php
require_once('resources/templates/common.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once('resources/lib/login_handler.php');
session_start();

html5_header(
	'Login Confirmation',
	array('css/root.css'),
	array());

$user_name = htmlspecialchars($_POST['user_name']);
$user_password = htmlspecialchars($_POST['user_password_new']);
$message = loginUser($user_name, $user_password);
echo "<p>" . $message . "</p>";

html5_nav();

html5_footer();
?>