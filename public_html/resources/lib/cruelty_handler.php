<?php

$name = $_POST['name'];
$email = $_POST['e-mail'];
$number = $_POST['phoneNumber'];
$personName = $_POST['personName'];
$personAddress = $_POST['personAddress'];
$incident = $_POST['incidentText'];

$message = "Message from: \n\n" . $name . "\n" . $number . "\n" . $email . "\n\n\n Message concerning: \n\n" .
$personName . "\n" . $personAddress . "\n" . $incident;

mail('kim.ficara@gmail.com', 'Cruelty Form Submission', $message);

header('Location: http://hs.myweb.cs.uwindsor.ca/confirmation.php');

?>
