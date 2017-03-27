<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
require_once('resources/lib/password_functions.php');
require_once('resources/lib/database.php');

html5_header(
  'Login Page',
  array('css/root.css'),
  array());

html5_nav();

require_once("resources/classes/loginclass.php");

$user = new user_login();

if ($user->login_status() == true) {
    include('views/login/logged.php');
} else {
	include('views/login/notlogged.php');
}
	
