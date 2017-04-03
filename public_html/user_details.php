<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once(dirname(__FILE__) . '/resources/lib/login-tools.php');
require_once(dirname(__FILE__) . '/resources/lib/database.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'User Details',
	array('css/root.css'),
	array());
	
html5_nav();

if ( is_logged_in() ){
?>

    <!-- user page here -->
    <p style="text-align:center">Hi <?php echo $_SESSION['logged_in_user'] ?>!</p>
	
	<div id="doubleform">
		<form class="form" role="form" method="post" name="emailchange" action="message_page.php" accept-charset="UTF-8" id="login-nav">
										<div>
											 <label for="user_email">Change Email:</label>
											 <input id="user_email" placeholder="New Email" name="user_email" required>
											 <input type="password" id="user_password" name="user_password" placeholder="Password" required>
											 <input type="password" id="user_password_repeat" name="user_password_repeat" placeholder="Repeat Password" required>
										</div>
										<div>
											 <button type="submit">Confirm</button>
										</div>
								 </form>
		<form class="form" role="form" method="post" name="passwordchange" action="message_page.php" accept-charset="UTF-8" id="login-nav">
										<div>
											 <label for="user_password">Change Password:</label>
											 <input type="password" id="user_password_new" placeholder="New Password" name="user_password_new" required>
											 <input type="password" id="user_password" name="user_password" placeholder="Old Password" required>
											 <input type="password" id="user_password_repeat" name="user_password_repeat" placeholder="Repeat Old Password" required>
										</div>
										<div>
											 <button type="submit">Confirm</button>
										</div>
								 </form>
	</div>

<?php
} else { // end if logged in
?>
    <!-- this is just a safety precaution in case a user manually types in url to this page -->
    <p style="text-align:center">Sorry, you must be signed in to view this page!</p>

<?php
} // end else (not logged in)

html5_footer();
?>