<?php 
    
require_once('database.php');
require_once('login-tools.php');
require_once(dirname(__FILE__).'/../config.php');
require_once(dirname(__FILE__) . '/../templates/common.php');

$name = $_POST['name'];
$species = $_POST['species'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$altered = $_POST['altered'];
$size = $_POST['size'];
$primary_color = $_POST['primary_color'];
$secondary_color = $_POST['secondary_color'];
$username = $_SESSION['logged_in_user'];

$db = new SurrenderDB; 

$return_id = $db->insert($name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color, $username);

header('Location: ../../confirmation.php');

?>