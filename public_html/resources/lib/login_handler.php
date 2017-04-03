<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once('database.php');
require_once('login-tools.php');


function loginUser() {
		$user_name = $_POST['user_name'];
        $user_password = $_POST['user_password_new'];

		$db = new UserDB;
		
        if ($db->check_user_password($user_name, $user_password)){
			log_in_user($user_name);
		}
}



?>