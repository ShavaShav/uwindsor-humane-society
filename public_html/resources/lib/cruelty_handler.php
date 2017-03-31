<?php

$name = $_POST['name'];
$email = $_POST['e-mail'];
$number = $_POST['phoneNumber'];
$personName = $_POST['personName'];
$personAddress = $_POST['personAddress'];
$incident = $_POST['incidentText'];
$textIncident = strip_tags($incident);
$subject = "Cruelty Complaint From " . $name;

$message = "Message from: \n\n" . $name . "\n" . $number . "\n" . $email . "\n\n\n Message concerning: \n\n" .
$personName . "\n" . $personAddress . "\n\n\n Description of cruelty:\n\n" . $textIncident;

mail('kim.ficara@gmail.com', $subject, $message);

header('Location: http://hs.myweb.cs.uwindsor.ca/confirmation.php');

?>
