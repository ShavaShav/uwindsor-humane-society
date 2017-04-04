<?php

$name = htmlspecialchars($_POST['customer_name']);
$email = htmlspecialchars($_POST['email_address']);
$reason = htmlspecialchars($_POST['contact']);
$elaborate = htmlspecialchars($_POST['elaborate']);
$textelaborate = strip_tags($elaborate);
$subject = "Contact Us Regarding " . $reason;

$message = "Message from: \n\n" . $name . "\n" . $email . "\n\n Message concerning:  " .
$reason . "\n\n" . $textelaborate;

mail('kim.ficara@gmail.com', $subject, $message);

header('Location: ../../confirmation.php');

?>