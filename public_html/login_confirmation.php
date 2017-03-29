<?php
require_once('resources/templates/common.php');
require_once('resources/config.php');
require_once('resources/lib/database.php');
require_once('resources/lib/login_handler.php');
session_start();

html5_header(
	'Login Confirmation',
	array('css/root.css',),
	array());
html5_nav();

loginUser();

if(is_logged_in()){
	echo "<p>Log in as " . $_SESSION['logged_in_user'] . " successful! Head back to the <a href='index.php'>Home Page</a>";
} else {
	echo "<p>Something went wrong. Our Bad!";
}

html5_footer();
?>