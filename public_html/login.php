<?php
require_once('lib/common.php');

html5_navigation(
  'Login Page',
  array('nav.css'),
  array(),
  "<p>Login Form:</p>".generate_html5_login_form()."<br />"
);


?>
