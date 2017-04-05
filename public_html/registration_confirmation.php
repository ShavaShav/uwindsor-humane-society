<?php
require_once('resources/templates/common.php');
require_once('resources/lib/register_handler.php');
require_once('resources/lib/form_fill.php');

regformdata();

html5_header(
	'Register Confirmation',
	array('css/root.css'),
	array());
html5_nav();

$message = registerUser();
echo "<p id='prompt'>" . $message . "</p></div>";
html5_footer();
?>