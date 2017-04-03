<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');

function is_logged_in()
{
  if (array_key_exists('logged_in', $_SESSION))
    return TRUE;
  else
    return FALSE;
}

function log_in_user($user)
{
  $_SESSION['logged_in'] = 1;
  $_SESSION['logged_in_user'] = $user;
  if (isAdmin()){
     $_SESSION['admin'] = 1;
}
}

// checks if current user is admin
function isAdmin(){
    global $ADMIN;
    foreach($ADMIN as $name){
        if ($name == $_SESSION['logged_in_user'])
            return TRUE;
		}
    return FALSE;
}

function log_out_user()
{
  unset($_SESSION['logged_in'], $_SESSION['logged_in_user'], $_SESSION['admin']);
}

?>

