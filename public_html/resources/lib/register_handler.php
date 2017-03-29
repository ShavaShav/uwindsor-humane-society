<?php
require_once(dirname(__FILE__) . '/../config.php');
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
	
	
		$user_name = $_POST['user_name'];
        $user_password = $_POST['user_password_new'];

		$db = new UserDB;
		

        if ($db->checkUserExists($user_name)) {
            echo "<p>Sorry, that username is already taken.</p><br>";
        } else {
            if ($db->insert($user_name, $user_password)) {
                echo "<p>Your account has been created successfully. You can now log in.</p><br>";
            } else {
                echo "<p>Sorry, your registration failed. Please go back and try again.</p><br>";
            }
        }
		
		

	}
}


?>