<?php

$name = $_POST['customer_name'];
$email = $_POST['email_address'];
$reason = $_POST['contact'];
$elaborate = $_POST['elaborate'];

$message = "Message from: \n\n" . $name . "\n" . $email . "\n\n Message concerning:  " .
$reason . "\n\n" . $elaborate;

mail('kim.ficara@gmail.com', 'Contact Us Form Submission', $message);

header('Location: ../../confirmation.php');

?>