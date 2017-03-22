<?php
require_once('lib/config.php');
start_session();
require_once('lib/common.php');

html5_navigation(
	'Report Cruelty',
	array('nav.css'),
	array(),
	"is logged in: ".is_logged_in()
);
?>
        <p class="titleText">Cruelty Form</p>
        <form action="/cruelty_handler.php" method="post">
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
		
<?php
html5_epilog();
?>
