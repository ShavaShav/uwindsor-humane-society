<?php

    $i = 1; 
    $target = "img/animals/";

    // $dir = opendir($target); 
 // $dir = opendir('img/animals'); 

    // $dir = 'uploads/';
    // if ($handle = opendir($dir)) {
    //     while (($file = readdir($handle)) !== false){
    //         if (!in_array($file, array('.', '..')) && !is_dir($dir.$file)) 
    //             $i++;
    //     }
    // }

    if ($handle = opendir($target)){
        while (($file = readdir($handle)) !== false){
            if (!in_array($file, array('.', '..')) && !is_dir($target.$file))
                $i++;
        }
    }

    // while (false !== ($file = readdir($dir))) { 
    //     if (!in_array($file, array('.', '..') and !is_dir($file)){

    //      $i++;
    //  }
    // }

function findexts ($filename){
	$filename = strtolower($filename);
	$exts = split("[/\\.]", $filename);
	$n = count($exts)-1;
	$exts = $exts[$n];
	return $exts;
	}
	
$ext = findexts ($_FILES['file']['name']) ;
//$target = "img/animals/";
$target = $target.$i.'.'.$ext;

 move_uploaded_file($_FILES['file']['tmp_name'], $target);


//$upload_dir = 'img/animals';
//if (!empty($_FILES)) 
//{


  //  $tempFile = $_FILES['file']['tmp_name'];//this is temporary server location
     
    // $ext = substr(strrchr($_FILES['file'], '.'), 1);
   // $ext = split("[/\\.]", $) ;

 //  $temp = explode(".", $_FILES["file"]["name"]);
 //  $newfilename = $i. '.' . end($temp);
 //  move_uploaded_file ($_FILES["file"]["tmp_name"], "../img/animals/" . $newfilename); 
   
   // $ext = pathinfo($tempFile, PATHINFO_EXTENSION);
 
   // $ext = substr(strrchr($tempFile, '.'), 1);

     // using DIRECTORY_SEPARATOR constant is a good practice, it makes your code portable.
   //  $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . $upload_dir . DIRECTORY_SEPARATOR;

     // Adding timestamp with image's name so that files with same name can be uploaded easily.
    // $mainFile = $uploadPath. $_FILES['file']['name'];
   //  $mainFile = $uploadPath. $i. '.' .$ext;
//   $mainFile = $uploadPath. $i .'.'. $name;
   //  move_uploaded_file($tempFile,$mainFile);
//}

?>


