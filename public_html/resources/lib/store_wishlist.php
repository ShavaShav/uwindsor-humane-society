<?php
session_start();

// adding an animal if it's not already in the cookie 'wishlist' variable
if(isset($_POST['animal_img'])) {
 $animal_values=$_POST['animal_name']."+".$_POST['animal_img'];
    if(count($_SESSION['wishlist']) > 0) {
        if(in_array($animal_values, $_SESSION['wishlist'])) {
        } else {
            $_SESSION['wishlist'][]=$animal_values;
        }
    } else {
        $_SESSION['wishlist'][]=$animal_values;
    }
    echo count($_SESSION['wishlist'])." Animal(s) on your Wishlist";
    exit();
}

// the wishlist div displays all animals in the 'wishlist' cookie variable
if(isset($_POST['show_wishlist'])) {
    for($i = 0;$i < count($_SESSION['wishlist']); $i++) {	
        $animal_val = explode("+", $_SESSION['wishlist'][$i]);
echo <<<ZZEOF
    <div class='wishlistAnimals'>
        <img src='$animal_val[1]'>
        <p>$animal_val[0]</p>
        <input type="button" value="Remove Animal" onclick="removeAnimal('
ZZEOF;
echo $_SESSION['wishlist'][$i];
echo <<<ZZEOF
')">
    </div>
ZZEOF;
 }
 exit();	
}

// removes animal_val from the cookie's "wishlist" variable
if(isset($_POST['remove_animal']))
{
    $animal_val=$_POST['animal_val'];
    for($i = 0; $i < count($_SESSION['wishlist']); $i++) {
        if($_SESSION['wishlist'][$i] == $animal_val) {
            unset($_SESSION['wishlist'][$i]);
        }
    }
    $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
    echo count($_SESSION['wishlist'])." Animal(s) on your Wishlist";
    exit();	
}
?>