<?php
session_start();

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
    echo count($_SESSION['wishlist'])." Animals on your Wishlist";
    exit();
}

if(isset($_POST['show_wishlist'])) {
    for($i = 0;$i < count($_SESSION['wishlist']); $i++) {	
        $animal_val = explode("+", $_SESSION['wishlist'][$i]);
?>
        <div class='wishlistAnimals'>
            <img src='<?php echo $animal_val[2];?>'>
            <p><?php echo $animal_val[0];?></p>
            <p><?php echo $animal_val[1];?></p>
            <input type='button' value='Remove Animal' onclick='removeAnimal("<?php echo $_SESSION['wishlist'][$i];?>");'>
        </div>
<?php
 }
 exit();	
}
  
if(isset($_POST['remove_animal']))
{
    $animal_val=$_POST['animal_val'];
    for($i = 0; $i < count($_SESSION['wishlist']); $i++) {
        if($_SESSION['wishlist'][$i] == $animal_val) {
            unset($_SESSION['wishlist'][$i]);
        }
    }
    $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
    echo count($_SESSION['wishlist'])." Animals on your Wishlist";
    exit();	
}
?>