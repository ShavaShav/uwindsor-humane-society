<?php
require_once('../config.php');
require_once('database.php'); // must include, relative to current location, to get UserDB class

$db = new UserDB; // open userDB

echo "Adding John...<br><br>";
// use the insert function with the unhashed password, it hashes it within function
$db->insert('john', 'hd834h8irtj9', 'john@weakMail.com');
//$db->insert('suzy', '284hs8d87432jf', 'suzy@gmail.com');

// addition of email to insert method
echo "1. Checking john with incorrect password...<br><br> ";
echo $db->check_user_password('john','abc123') ? 'PASS' : 'FAIL';

echo "<br><br>\n2. Checking john with correct password... <br><br>";
echo $db->check_user_password('john','hd834h8irtj9') ? 'PASS' : 'FAIL';

echo "<br><br>Lookup...<br><br>";
print_r($db->lookup('john'));

// modify password
echo "<br><br><h2>** Modifying John's password...</h2><br>";
$db->modifyPassword('john', 'newPass1234');

echo "<br><br>Lookup John...<br><br>";
print_r($db->lookup('john'));

// modify email
echo "<br><br><h2>** Modifying John's Email...</h2><br>";
$db->modifyEmail('john', 'john@awesomeMail.com');

echo "<br><br>Lookup John...<br><br>";
print_r($db->lookup('john'));

echo "<br><br>3. Erasing john...<br><br>";
$db->erase('john');

$db->close();

?>