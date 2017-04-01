<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once(dirname(__FILE__) . '/resources/lib/login-tools.php');
require_once(dirname(__FILE__) . '/resources/lib/database.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'Contact Us',
	array('css/root.css'),
	array());
	
html5_nav();

if ( is_logged_in() && isAdmin() ){
?>
    <!-- repeat for surrenders and adoptions -->
    <form>
    <label>User: </label>
    <p id="userdata$id"><!-- username here --></p><br>
    <label>Animal: </label>
    <p id="animaldata$id"><!-- animal data here--></p><br>
    <input type="submit" name="Confirm" id="Confirm">
    <input type="submit" name="Deny" id="Deny">
        <hidden val>username, animal_id</hidden>
    </form>

<?php
} else { // end if admin
?>

<!-- this is just a safety precaution in case a user manually types in url to this page -->
    <p style="text-align:center">Sorry, you are not authorized to view this page!</p>

<?php
} // end if not admin

html5_footer();
?>