<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once($TEMPLATES_PATH . '/common.php');
require_once('resources/lib/login-tools.php');
require_once('resources/lib/database.php');

$db = new UserDB;

html5_header(
	'University of Windsor Humane Society',
	array('css/root.css', 'css/index.css'),
	array('js/index.js'));

global $TEMPLATES_PATH;
?>


<div class="logoborder">
	<img src="resources/templates/img.php?type=svg&filename=frontpagelogo.svg">
</div>

<div id="greetingBox">
    <div id="greetingMsg">
        <!-- generated via index.js -->
    </div>
</div>

<div class="buttonborder">
	<div class="buttons">
		
		<div id="About" style="cursor:pointer;" 
		onclick="document.location='contactus.php'"> 
			
		<img src='resources/templates/img.php?type=svg&filename=contact.svg'>
		
		</div>
				
		<div id="Animals" style="cursor:pointer;" 
		onclick="document.location='adopt.php'">
		
		<img src='resources/templates/img.php?type=svg&filename=adopt.svg'>
		
		</div>
				
		<div id="Surrender" style="cursor:pointer;" 
		onclick="document.location='surrender.php'">
		
		<img src='resources/templates/img.php?type=svg&filename=surrender.svg'>
		
		</div>
		
		<div id="Cruelty" style="cursor:pointer;" 
		onclick="document.location='cruelty.php'">
		
		<img src='resources/templates/img.php?type=svg&filename=report.svg'>
		
		</div>
	</div>
</div>
<?php
html5_footer();
?>