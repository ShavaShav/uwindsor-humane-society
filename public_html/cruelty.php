<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'Report Cruelty',
	array('css/nav.css'),
	array());

html5_nav();
?>
<div class="contentborder">
        <p class="titleText">Cruelty Form</p>
        <form action="/resources/lib/cruelty_handler.php" method="post">
        <p class="formLabel">Your name</p>
        <input type="text" name="name" id="name" class="textInput">
        <p class="formLabel">Your phone number</p>
        <input type="text" name="phoneNumber" id="phoneNumber" 
class="textInput">
        <p class="formLabel">Your e-mail</p>
        <input type="text" name="e-mail" id="e-mail" class="textInput">
        <p class="formLabel">Name of person involved (if known)</p>
        <input type="text" name="personName" id="personName" 
class="textInput">
        <p class="formLabel">Address of location (if known)</p>
        <input type="text" name="personAddress" id="personAddress" 
class="textInput">
        <p class="formLabel">Please describe what you saw (required)</p> 
        <textarea rows="15" cols="100" name="incidentText" 
id="incidentText" class="formLabel">  </textarea>            
        <input type="submit" name="submit" id="submit" 
class="submitButton">
            
        </form> 
</div>
		
<?php
html5_footer();
?>
