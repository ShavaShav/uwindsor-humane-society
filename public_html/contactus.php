<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'Contact Us',
	array('css/root.css', 'css/contactus.css'),
	array());
	
html5_nav();
?>
<script src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: '#elaborate',
        height: 150,
        width: 400,

        plugins: [
           ' wordcount  ',
         ],

        image_advtab: true
    });
    </script>
<div class="contentborder">
<h2>Email Us</h2>
<div class="formContent">
<form action='resources/lib/contact_handler.php', method="post">
<br><div class="formOption">
    <label>Name:</label>
    <input type="text" name="customer_name" required></br>  
</div>

<div class="formOption">
    <label>Email:</label>
    <input type="text" name="email_address" required></br>
</div>

<div class="formOption">
    <label>Reason for Contact:</label>
    <select id="contact" name="contact">
    <option value="general inquiry" selected="selected">General inquiry</option>
    <option value="problem with website" >Problem with website</option>
    <option value="suggestion" >Suggestion</option>
    </select>
</div><br><br><br><br>

<label id="disclaimer">
*You may also contact us at 1-800-519-5119 or visit us at 33 LULZ Street, Windsor, Ontario*
</label><br><br><br>

<div class="formOption">
    <p class = "formLabel"><b>Please Clarify:</b> </p>
    <textarea name="elaborate" id="elaborate"></textarea>
</div>
</div>

<div class="formOption">
	<input type="submit" value="Submit" id="submitButton">
</div>

</form>
</div>

<?php
html5_footer();
?>