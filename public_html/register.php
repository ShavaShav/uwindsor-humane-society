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

$user = new user_login();
$registration = new registration();

if ($user->login_status() == true) {
    echo "<p>You are already signed in as" . $_SESSION['user_name'] . "</p>";
} else {
	echo <<<ZZEOF
<form method="post" action="register.php" name="registerform">

    <label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label>
    <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />

    <label for="login_input_email">User's email</label>
    <input id="login_input_email" class="login_input" type="email" name="user_email" required />

    <label for="login_input_password_new">Password (min. 6 characters)</label>
    <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

    <label for="login_input_password_repeat">Repeat password</label>
    <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
    <input type="submit"  name="register" value="Register" />

</form>
ZZEOF;
}
	

html5_footer();
?>


