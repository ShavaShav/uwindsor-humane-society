<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once('database.php');

function registerUser() {
   
    /*if (empty($_POST['user_name'])) {
        echo "<p>Empty Username</p><br>";
    } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
        echo "<p>Empty Password</p><br>";
    } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
        echo "<p>Passwords must match</p><br>";
    } elseif (strlen($_POST['user_password_new']) < 6) {
        echo "<p>Password minimum 6 characters</p><br>";
    } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
        echo "<p>Username must be 2-64 characters</p><br>";
    } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
        echo "<p>Username format incorrect: only letters and numbers, 2-64 characters</p><br>";
    } elseif (!empty($_POST['user_name'])
        && strlen($_POST['user_name']) <= 64
        && strlen($_POST['user_name']) >= 2
        && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
        && !empty($_POST['user_password_new'])
        && !empty($_POST['user_password_repeat'])
        && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
    ) {*/
	
	
		$user_name = $_POST['reg_user_name'];
        $user_password = $_POST['reg_user_password_new'];

		$db = new UserDB;
		

        if ($db->checkUserExists($user_name)) {
			$string = "Sorry, that username is already taken.";
            
        } else {
            if ($db->insert($user_name, $user_password)) {
               $string = "Your account has been created successfully. You can now log in.";
            } else {
                $string = "Sorry, your registration failed. Please go back and try again.";
            }
        }
		echo "<script type='text/javascript'>", "alertUser($string)", "</script>";
		
		

}


?>