<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_header(
	'Contact Us',
	array('css/root.css'),
	array());
	
html5_nav();
?>
<script src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: '#elaborate',
        height: 200,
        width: 400,

        plugins: [
           ' wordcount  ',
         ],

        image_advtab: true
    });
    </script>
<h2>Email Us</h2>
<form action='resources/lib/contact_handler.php', method="post">
<div class="formOption">
    <label>Name</label>
    <input type="text" name="customer_name" required></br>  
</div>

<div class="formOption">
    <label>Email</label>
    <input type="text" name="email_address" required></br>
</div>

<div class="formOption">
    <label>Reason for Contact</label>
    <select id="contact" name="contact">
    <option value="no reason selected">Please select one</option>
    <option value="problem with website" >Problem with website</option>
    <option value="suggestion" >Suggestion</option>
    <option value="general enquiry" >General enquiry</option>
    </select>
</div>

<div class="formOption">
    <p class = "formLabel"><b><u> Please Clarify</u></b> </p>
    <textarea name="elaborate" id="elaborate"></textarea>
</div>

<input type="submit" value="Submit" id="submitButton">

</form>

<p>
You may also contact us at 1800-519-5119 or visit us at 33 LULZ Street, Windsor, Ontario.
</p>

<?php
html5_footer();
?>