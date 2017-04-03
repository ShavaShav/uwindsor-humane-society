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

$ds = DIRECTORY_SEPARATOR;
 
$storeFolder = 'img/surrenders';
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
    move_uploaded_file($tempFile,$targetFile); //6
     
}


//// upload image from 'dropzone' to temp img/surrenders/ folder
//$i = 1;
//$ds          = DIRECTORY_SEPARATOR;  //1
//$target = 'img/surrenders/'; 
// 
//if ($handle = opendir($target)){
//    while (($file = readdir($handle)) !== false){
//        if (!in_array($file, array('.', '..')) && !is_dir($target.$file))
//            $i++;
//    }
//}
//
//function findexts ($filename){
//    $filename = strtolower($filename);
//    $exts = split("[/\\.]", $filename);
//    $n = count($exts)-1;
//    $exts = $exts[$n];
//    return $exts;
//}
//
//$ext = findexts ($_FILES['file']['name']) ;
//$targetPath = dirname( __FILE__ ) . $ds. $target . $ds;
//$targetFile = $targetPath.$i.'.'.$ext;
//
//move_uploaded_file($_FILES['file']['tmp_name'], $targetFile);


// redirect user to confirmation page notifying submission worked
// header('Location: ../../confirmation.php');

?>