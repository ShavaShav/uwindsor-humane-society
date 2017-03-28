<?php
require_once(dirname(__FILE__).'/../config.php');

function is_logged_in()
{
  if (array_key_exists('logged_in', $_SESSION))
    return $_SESSION['logged_in_user'];
  else
    return FALSE;
}

function log_in_user($user)
{
  $_SESSION['logged_in'] = 1;
  $_SESSION['logged_in_user'] = $user;
  if (isAdmin){
     $_SESSION['admin'] = 1;
  } else {
     $_SESSION['admin'] = 0;
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

