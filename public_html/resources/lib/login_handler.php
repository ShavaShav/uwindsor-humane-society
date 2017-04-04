<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once('database.php');
require_once('login-tools.php');


function loginUser($user_name, $user_password) {
		$db = new UserDB;
		
        if ($db->check_user_password($user_name, $user_password)){
			log_in_user($user_name);
			$string = "<p>Successfully logged in!</p>";
		} else {
			$string = "<p>Password did not match our logs</p>";
		}
	return $string;
}



?>