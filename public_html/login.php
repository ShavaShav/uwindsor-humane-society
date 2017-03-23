<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
  'Login Page',
  array('css/nav.css'),
  array());

html5_nav();
?>
<div class="contentborder">
 <div id='login'>
      <form action='check-login.php' method='POST'>
        Login:    <input type='text' name='login' /><br />
        Password: <input type='password' name='passwd' /><br />
        <input type='submit' />
      </form>
    </div>
	<p> Not a member? <a href="/sigup.php"> Click here to sign up!</a>
</div>
	
<?php
html5_footer();
?>