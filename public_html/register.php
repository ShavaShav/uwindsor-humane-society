<?php
require_once('resources/templates/common.php');
html5_header(
	'Register Account',
	array('css/root.css',),
	array());
html5_nav();
?>

<h1>Register An Account:</h1>
<ul> Requirements:
<li>Username 2-64 characters or numbers only.</li>
<li>Password minimum 6 characters.</li>
<li>Confirmation password must match.</li>

<form method="post" action="registration_confirmation.php" name="registerform">

    <label for="login_input_username">Username</label><br>
    <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required /><br>

    <label for="login_input_password_new">Password (min. 6 characters)</label><br>
    <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" /><br>

    <label for="login_input_password_repeat">Repeat password</label><br>
    <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" /><br>
    <input type="submit"  name="register" value="Register" /><br>

</form>

<?php
html5_footer();
?>