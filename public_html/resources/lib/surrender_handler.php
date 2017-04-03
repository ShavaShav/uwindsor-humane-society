<?php 
    
require_once('database.php');
require_once('login-tools.php');
require_once(dirname(__FILE__).'/../config.php');
require_once(dirname(__FILE__) . '/../templates/common.php');

// insert animal details into Surrenders table

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

// upload image to temp img/surrenders/ folder
if (!empty($_FILES)) { // image uploaded
    
    if ($_FILES['animalImage']['size'] < 16000){ // max 16 kb (approx. max of a 200px by 200px jpg)

        $tempFile = $_FILES['animalImage']['tmp_name']; // uploaded file
        $targetPath = $_SERVER['DOCUMENT_ROOT'].'/img/surrenders/'; // surrenders folder path
        $targetFile =  $targetPath . $return_id . '.jpg';   //attach id from db

        if (!move_uploaded_file($tempFile,$targetFile)){
            // failure to upload
            copyDefaultImage($return_id);
        } 
    }     
} else {
    // no image uploaded
    copyDefaultImage($return_id);
}

// redirect user to confirmation page notifying submission worked
header('Location: ../../confirmation.php');


function copyDefaultImage($surrenderId){
    // copys the default animal image as placeholder
    $targetImg = $_SERVER['DOCUMENT_ROOT'].'/img/surrenders/'.$surrenderId.'.jpg';
    $defaultImg = $_SERVER['DOCUMENT_ROOT'].'/img/animals/default.jpg';
    copy($defaultImg, $targetImg);
}

?>