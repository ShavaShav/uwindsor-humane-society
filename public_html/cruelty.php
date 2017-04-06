<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once($TEMPLATES_PATH . '/common.php');

html5_header(
        'Report Cruelty',
        array('css/root.css', 'css/cruelty.css'),
        array());

html5_nav();
?>
<script src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: '#incidentText',
        height: 150,
        width: 400,

        plugins: [
           ' wordcount  ',
         ],

        image_advtab: true
    });
    </script>
<div class="contentborder">
        <h2>Report Cruelty</h2>
        <div class="formContent">
        <form action="/resources/lib/cruelty_handler.php" method="post">
        
        <br><div class="formOption"> 
              <label>Your name:</label>
              <input type="text" name="name" id="name" class="textInput" required>
        </div>
          
    	<div class="formOption"> 
              <label>Your phone number:</label>
              <input type="text" name="phoneNumber" id="phoneNumber" class="textInput" required>
        </div>
        
        <div class="formOption"> 
              <label>Your e-mail:</label>
              <input type="text" name="e-mail" id="e-mail" class="textInput" required>
        </div>
        
        <div class="formOption"> 
              <label>Name of person involved:</label>
              <input type="text" name="personName" id="personName" class="textInput" required>
        </div>
        
        <div class="formOption"> 
              <label>Address of person involved:</label>
              <input type="text" name="personAddress" id="personAddress" class="textInput" required>
        </div><br>
        
        <div class="formOption">
        		<label id="disclaimer">*Your information will remain confidential*</label>
        </div><br>
        
        <div class="formOption"> 
              <label>Please describe what you saw:</label>
              <textarea name="incidentText" id="incidentText"></textarea> 
        </div>
        </div>
        <div class="formOption"> 
               <input type="submit" name="submit" id="submit" class="submitButton">
        </div>
        
    </form> 
</div>
                
<?php
html5_footer();
?>
