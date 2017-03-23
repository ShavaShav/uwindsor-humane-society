<?php
include_once 'functions.php';
sec_session_start();

//unset all session vals
$_SESSION = array();

//get the session parameters
$params = session_get_cookie_params();

//delete the cookie
setcookie(session_name(), ''. time() - 420000, 
	$params["path"],
	$params["domain"],
	$params["secure"],
	$params["httponly"]);

//destroy session
session_destroy();
header('Location: ../index.php');
?>