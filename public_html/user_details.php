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

<?php
} else { // end if logged in
?>
    <!-- this is just a safety precaution in case a user manually types in url to this page -->
    <p style="text-align:center">Sorry, you must be signed in to view this page!</p>

<?php
} // end else (not logged in)

html5_footer();
?>