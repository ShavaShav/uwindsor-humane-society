<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
        'Report Cruelty',
        array('css/root.css'),
        array());

html5_nav();
?>
<script src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: '#incidentText',
        height: 200,
        width: 400,

        plugins: [
           ' wordcount  ',
         ],

        image_advtab: true
    });
    </script>
<div class="contentborder">
        <h2>Report Cruelty</h2>
        <form action="/resources/lib/cruelty_handler.php" method="post">
        <p class="formLabel">Your name</p>
        <input type="text" name="name" id="name" class="textInput" required>
        <p class="formLabel">Your phone number</p>
        <input type="text" name="phoneNumber" id="phoneNumber" 
class="textInput" required>
        <p class="formLabel">Your e-mail</p>
        <input type="text" name="e-mail" id="e-mail" class="textInput" required>
        <p class="formLabel">Name of person involved (if known)</p>
        <input type="text" name="personName" id="personName" 
class="textInput">
        <p class="formLabel">Address of person</p>
        <input type="text" name="personAddress" id="personAddress" 
class="textInput" required>
        <p class="formLabel">Please describe what you saw (required)</p> 
        <textarea name="incidentText" id="incidentText"></textarea>   
        <br>
        <input type="submit" name="submit" id="submit" 
class="submitButton">
            
        </form> 
</div>
                
<?php
html5_footer();
?>
