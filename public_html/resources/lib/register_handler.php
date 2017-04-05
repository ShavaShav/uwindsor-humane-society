<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once('database.php');

function registerUser() {
    if (empty($_POST['reg_user_name'])) {
        echo "<p id='prompt'>Empty Username</p>";
    } elseif (empty($_POST['reg_user_password_new']) || empty($_POST['reg_user_password_repeat'])) {
        echo "<p id='prompt'>Empty Password</p>";
	} elseif (!preg_match('/^.+\@.+\..+$/', $_POST['email'])){
		$string = "<p id='prompt'>Email is not of correct format. name@domain.extension</p>";
    } elseif ($_POST['reg_user_password_new'] !== $_POST['reg_user_password_repeat']) {
        echo "<p id='prompt'>Passwords must match</p>";
    } elseif (strlen($_POST['reg_user_password_new']) < 6) {
        echo "<p id='prompt'>Password minimum 6 characters</p>";
	} elseif (!preg_match('/^((?=.*[a-z])(?=.*[A-Z])(?=.*\d).+)(\w{5,})(\s{0})$/', $_POST['reg_user_password_new'])){
		$string = "<p id='prompt'>The password must contain at least one capital letter, lower case letters, and numbers</p>";
    } elseif (strlen($_POST['reg_user_name']) > 64 || strlen($_POST['reg_user_name']) < 2) {
        echo "<p id='prompt'>Username must be 2-64 characters</p>";
    } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['reg_user_name'])) {
        echo "<p id='prompt'>Username format incorrect: only letters and numbers, 2-64 characters</p>";
    } else {
		$user_name = htmlspecialchars($_POST['reg_user_name']);
        $user_password = htmlspecialchars($_POST['reg_user_password_new']);
		$email = htmlspecialchars($_POST['email']);

		$db = new UserDB;

        if ($db->checkUserExists($user_name)) {
			$string = "Sorry, that username is already taken.";
        } else if ($db->insert($user_name, $user_password, $email)) {
               $string = "Your account has been created successfully. You can now log in.";
        } else {
                $string = "Sorry, your registration failed. Please go back and try again.";
		}
    }
	return $string;
	}
	


?>