<?php 
    
require_once('database.php');
require_once('login-tools.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once(dirname(__FILE__) . '/../templates/common.php');

// insert animal details into Surrenders table

$name = htmlspecialchars($_POST['name']);
$species = htmlspecialchars($_POST['species']);
$age = htmlspecialchars($_POST['age']);
$gender = htmlspecialchars($_POST['gender']);
$altered = htmlspecialchars($_POST['altered']);
$size = htmlspecialchars($_POST['size']);
$primary_color = htmlspecialchars($_POST['primary_color']);
$secondary_color = htmlspecialchars($_POST['secondary_color']);
$username = $_SESSION['logged_in_user'];

$db = new SurrenderDB; 

$return_id = $db->insert($name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color, $username);

// upload image to temp img/surrenders/ folder, if there is an upload (client side only allows jpgs)
if (!empty($_FILES)) { // image uploaded
    
    if ($_FILES['animalImage']['size'] < 1000000){ // limit to 1MB jpgs (server side check)

        $tempFile = $_FILES['animalImage']['tmp_name']; // uploaded file
        $targetPath = $IMG_PATH. '/surrenders/'; // surrenders folder path
        $targetFile =  $targetPath . $return_id . '.jpg';   //attach id from db
        
        // checking server side that the image in a jpg
        if (strcmp(mime_content_type($targetPath), "image/jpeg"))
            move_uploaded_file($tempFile,$targetFile); // move the temp upload to surrenders folder
    }     
}

// if no image is uploaded, or bad image, img.php will just return the default cat silouette image wherever it should appear on the site

// redirect user to confirmation page notifying submission worked
header('Location: ../../confirmation.php');

?>