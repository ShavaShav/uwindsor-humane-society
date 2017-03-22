<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once($TEMPLATES_PATH . '/common.php');
session_start();

html5_navigation(
	'Contact Us',
	array('css/nav.css'),
	array(),
	"is logged in: ".is_logged_in()
);

?>

<form action="/contact_us.php" method="post">

<p class = "formLabel"><b><u> Name</u></b> </p>
<input type="text" name="customer_name" required></br>

<p class = "formLabel"><b><u> Email</u></b> </p>
<input type="text" email="email_address" required></br>

	
<p class = "formLabel"><b><u> Reason for Contact</u></b> </p>
<select id="contact" name="contact">
<option value="selected">Please select one</option>
<option value="problem" >Problem with website</option>
<option value="suggestion" >Suggestion</option>
<option value="enquiry" >General enquiry</option>
</select>

<p class = "formLabel"><b><u> Please Clarify</u></b> </p>
<textarea elaborate="elaborate" maxlength="500"></textarea> </p>

<input type = "submit" value = "Submit" class = "submitButton">

</form>

<p>
You may also contact us at 1800-519-5119 or visit us at 33 LULZ Street, Windsor, Ontario.
</p>

<?php
html5_footer();
?>