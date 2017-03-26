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
<form action='resources/lib/contact_handler.php', method="post">

<p class = "formLabel"><b><u> Name</u></b> </p>
<input type="text" name="customer_name" required></br>

<p class = "formLabel"><b><u> Email</u></b> </p>
<input type="text" name="email_address" required></br>

	
<p class = "formLabel"><b><u> Reason for Contact</u></b> </p>
<select id="contact" name="contact">
<option value="selected">Please select one</option>
<option value="problem with website" >Problem with website</option>
<option value="suggestion" >Suggestion</option>
<option value="general enquiry" >General enquiry</option>
</select>

<p class = "formLabel"><b><u> Please Clarify</u></b> </p>
<textarea name="elaborate" id="elaborate"></textarea>

<input type = "submit" value = "Submit" class = "submitButton">

</form>

<p>
You may also contact us at 1800-519-5119 or visit us at 33 LULZ Street, Windsor, Ontario.
</p>

<?php
html5_footer();
?>