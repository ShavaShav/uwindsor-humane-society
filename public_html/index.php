<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'University of Windsor Humane Society',
	array('css/index.css'),
	array());
?>

<div id="signin" style="cursor:pointer;" 
	onclick="document.location='login.php'">
	
	<img src='img/svg/signin.svg'>

</div>

<div class="logoborder">
	<img src="img/logo/frontpagelogo.svg">
</div>

<div class="buttonborder">
	<div class="buttons">
		
		<div id="About" style="cursor:pointer;" 
		onclick="document.location='contactus.php'"> 
			
		<img src='img/svg/contact.svg'>
		
		</div>
				
		<div id="Animals" style="cursor:pointer;" 
		onclick="document.location='adopt.php'">
		
		<img src='img/svg/adopt.svg'>
		
		</div>
				
		<div id="Surrender" style="cursor:pointer;" 
		onclick="document.location='surrender.php'">
		
		<img src='img/svg/surrender.svg'>
		
		</div>
		
		<div id="Cruelty" style="cursor:pointer;" 
		onclick="document.location='cruelty.php'">
		
		<img src='img/svg/report.svg'>
		
		</div>
	</div>
</div>
<?php
html5_footer();
?>