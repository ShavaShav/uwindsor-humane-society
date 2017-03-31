<?php

$name = $_POST['customer_name'];
$email = $_POST['email_address'];
$reason = $_POST['contact'];
$elaborate = $_POST['elaborate'];
$textelaborate = strip_tags($elaborate);
$subject = "Contact Us Regarding " . $reason;

$message = "Message from: \n\n" . $name . "\n" . $email . "\n\n Message concerning:  " .
$reason . "\n\n" . $textelaborate;

mail('kim.ficara@gmail.com', $subject, $message);

header('Location: ../../confirmation.php');

?>