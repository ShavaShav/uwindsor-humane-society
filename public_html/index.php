<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'University of Windsor Humane Society',
	array('css/root.css', 'css/index.css'),
	array());
?>
<div id="signin" style="cursor:pointer;" 
	onclick="document.location='login.php'">
<p>Sign In</p>
</div>
<div class="buttonborder">
	<div class="buttons">
		
		<div id="About" style="cursor:pointer;" 
		onclick="document.location='contactus.php'"> 
			<div><p>Contact Us</p></div>
		</div>
				
		<div id="Animals" style="cursor:pointer;" 
		onclick="document.location='adopt.php'">
			<div><p>Adopt Animals</p></div>
		</div>
				
		<div id="Surrender" style="cursor:pointer;" 
		onclick="document.location='surrender.php'">
			<div><p>Surrender Animals</p></div>
		</div>
				
		<div id="Cruelty" style="cursor:pointer;" 
		onclick="document.location='cruelty.php'">
			<div><p>Report Cruelty</p><div>
		</div>
	</div>
</div>
<?php
html5_footer();
?>