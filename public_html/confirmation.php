<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'Contact Us',
	array('css/nav.css'),
	array());
	
html5_nav();
?>
<div class="contentborder">
<p>
Thank you for reaching out, we will get back to you shortly.
</p>
</div>

<?php
html5_footer();
?>