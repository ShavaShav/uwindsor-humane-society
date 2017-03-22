<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_navigation(
  'Login Page',
  array('css/nav.css'),
  array(),
  "<p>Login Form:</p>".generate_html5_login_form()."<br />"
);


?>
