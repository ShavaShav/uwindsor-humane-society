<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'Contact Us',
	array('css/root.css'),
	array());
	
html5_nav();
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
html5_footer();
?>