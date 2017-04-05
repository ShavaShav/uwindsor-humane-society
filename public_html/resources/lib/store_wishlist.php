<?php
session_start();
require_once(dirname(__FILE__) . '/../lib/login-tools.php');
require_once(dirname(__FILE__) . '/../lib/database.php');

// adding an animal if it's not already in the cookie 'wishlist' variable
if(isset($_POST['animal_img'])) {
 $animal_values=$_POST['animal_name']."+".$_POST['animal_img']."+".$_POST['animal_id'];
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
        // show animal info with a button to remove
        echo <<<ZZEOF
        <div class='wishlistAnimals'>
            <img src='$animal_val[1]' class="animalImage">
            <p>$animal_val[0]</p>
            <input type="button" value="Remove Animal" onclick="removeAnimal('
ZZEOF;
        echo $_SESSION['wishlist'][$i];
        echo "')\">";
        echo "<br>";
        
        // adopt button
        $db = new AnimalDB;
        $hasRequested = $db->hasRequestedAdoption($_SESSION['logged_in_user'], $animal_val['2']);
        // only show if they haven't already requested adoption
        if (is_logged_in() && !$hasRequested){
            echo '<input type="button" value="Request Adoption" onclick="requestAdoption(\'';
            echo $_SESSION['wishlist'][$i];
            echo "')\">";
        } else if ($hasRequested) {
            echo '<p>Adoption requested!</p>';
        }
        echo "</div>";
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

// adds the animal to the adoptions table
if(isset($_POST['request_adoption']))
{

    $animal_val = explode("+", $_POST['animal_val']);
    
    $db = new AnimalDB;
    // attempt to add animal to table
    if ($db->requestAdoption($_SESSION['logged_in_user'], $animal_val['2'])){
        echo "You have successfully requested ".$animal_val[0]." for adoption!";
    } else {
        echo "Something went wrong while requesting adoption! :(";
    }
    $db->close();
    exit();	
}


?>