<?php
require_once('../config.php');
require_once('password_functions.php');

//error message array
$errors = array();
//other message array
$messages = array();

if (isset($_POST["register"])) {
    registerUser();
}

/**
 * handles the entire registration process. checks all error possibilities
 * and creates a new user in the database if everything is fine
 */

function registerUser() {
    //checks the formatting conditions and for empty fields
    //does so using the empty function and regular expressions
    if (empty($_POST['user_name'])) {
        $errors[] = "Empty Username";
    } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
        $errors[] = "Empty Password";
    } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
        $errors[] = "Passwords must match";
    } elseif (strlen($_POST['user_password_new']) < 6) {
        $errors[] = "Password minimum 6 characters";
    } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
        $errors[] = "Username must be 2-64 characters";
    } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
        $errors[] = "Username format incorrect: only letters and numbers, 2-64 characters";
    } elseif (empty($_POST['user_email'])) {
        $errors[] = "Email cannot be empty";
    } elseif (strlen($_POST['user_email']) > 64) {
        $errors[] = "Email must be less than 64 characters";
    } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Your email is not formatted correctly: name@website.postfix";
    } elseif (!empty($_POST['user_name'])
        && strlen($_POST['user_name']) <= 64
        && strlen($_POST['user_name']) >= 2
        && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
        && !empty($_POST['user_email'])
        && strlen($_POST['user_email']) <= 64
        && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
        && !empty($_POST['user_password_new'])
        && !empty($_POST['user_password_repeat'])
        && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
    ) {

        // errors will be printed if database connect through AdminDB is unsuccessful
        $conn = new AdminDB;

        //removes special characters and anything that could be code
        $user_name = $conn->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
        $user_email = $conn->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));

        $user_password = $_POST['user_password_new'];

        //password_hash is hashes the inputted password string, used through the compatability library
        $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

        //query to see if the email/username already exists in the database
        // the attributes had the wrong names ! :P

        if (!$conn->checkUserExists($user_name)) {
            $errors[] = "Sorry, that username / email address is already taken.";
        } else {
            if ($conn->insertNewUser($user_name, $user_password_hash, $user_email)) {
                $messages[] = "Your account has been created successfully. You can now log in.";
            } else {
                $errors[] = "Sorry, your registration failed. Please go back and try again.";
            }
        }

}

?>