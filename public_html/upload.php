<?php
$i = 1;
$ds          = DIRECTORY_SEPARATOR;  //1
$target = 'img/surrenders/'; 
//$target_file = $target . basename($_FILES["file"]["tmp_name"]);
 
     if ($handle = opendir($target)){
        while (($file = readdir($handle)) !== false){
            if (!in_array($file, array('.', '..')) && !is_dir($target.$file))
                $i++;
        }
    }

//  move_uploaded_file($_FILES['file']['tmp_name'], $target)
   // $tempFile = $_FILES['file']['tmp_name'];          //3       
   // $temp = explode(".", $_FILES["file"]["name"]);
   // $targetPath = dirname( __FILE__ ) . $ds. $target . $ds;
  //$newfilename = $target. $i . '.' . end($temp);
  //move_uploaded_file($tempFile, $newfilename);     

      
   // $targetPath = dirname( __FILE__ ) . $ds. $target . $ds;  //4
     
   // $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
   // move_uploaded_file($tempFile,$targetFile); //6


//$ds          = DIRECTORY_SEPARATOR;  //1
//$i = 1;
//$storeFolder = 'uploads';   //2
 
     function findexts ($filename){
  $filename = strtolower($filename);
  $exts = split("[/\\.]", $filename);
  $n = count($exts)-1;
  $exts = $exts[$n];
  return $exts;
  }
    $ext = findexts ($_FILES['file']['name']) ;
    $targetPath = dirname( __FILE__ ) . $ds. $target . $ds;
    $targetFile = $targetPath.$i.'.'.$ext;

 move_uploaded_file($_FILES['file']['tmp_name'], $targetFile);

  //   $tempFile = $_FILES['file']['tmp_name'];          //3             
      
  //   $targetPath = dirname( __FILE__ ) . $ds. $target . $ds;  //4
     
  //   $targetFile =  $targetPath. $i;  //5
  //   $imageFileType = pathinfo($targetFile,PATHINFO_EXTENSION);
  // //pathinfo($targetFile,PATHINFO_EXTENSION)

  //   move_uploaded_file($tempFile,$targetFile); //6
  //   //rename ("$target/$targetFile", "$target/$i.$imageFileType");
     
 
     


?>      