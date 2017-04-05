<?php
require_once('resources/templates/common.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once('resources/lib/database.php');
require_once('resources/lib/register_handler.php');

html5_header(
	'Register Confirmation',
	array('css/root.css'),
	array());
html5_nav();

$message = registerUser();
echo "<p id='prompt'>" . $message . "</p></div>";
html5_footer();
?>