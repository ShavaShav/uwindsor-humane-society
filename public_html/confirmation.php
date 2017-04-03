<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once($TEMPLATES_PATH . '/common.php');

html5_header(
	'Contact Us',
	array('css/root.css'),
	array());
	
html5_nav();
?>
<div class="contentborder">
<p style="text-align: center">
Thank you, we will review your submission and get back to you shortly!
</p>
</div>

<?php
html5_footer();
?>