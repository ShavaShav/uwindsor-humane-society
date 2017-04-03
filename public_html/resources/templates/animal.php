<?php 
require_once(dirname(__FILE__) . '/../config.php');

function generateAnimalHTML($id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color){
    echo '<img src="../../img/animals/'.$id.'.jpg">';
    generateAnimalDetails($id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color);
}

function generateAnimalShortHTML($id, $name){
    echo '<img src="../../img/animals/'.$id.'.jpg">';
    echo '<p id="animalName_$id">'.$name.'</p>';
}

// generate surrender details with image and header
function generateSurrenderHTML($username, $id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color){
    echo '<p><b>'.$username.'</b> wishes to surrender:</p>';
    echo '<img src="../../img/surrenders/'.$id.'.jpg">';
    generateAnimalDetails($id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color);
}

// generate just the animals details, no picture
function generateAnimalDetails($id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color){
 echo <<<ZZEOF
    <p>Name: <span id="animalName_$id">$name</span></p>
    <p>Species: <span id="animalSpecies_$id">$species</span></p>
    <p>Age: <span id="animalAge_$id">$age</span></p>
    <p>Gender: <span id="animalGender_$id">$gender</span></p>
    <p>Altered: <span id="animalAltered_$id">$altered</span></p>
    <p>Size: <span id="animalSize_$id">$size</span></p>
    <p>Primary Color: <span id="animalPrimaryColor_$id">$primary_color</span></p>
    <p>Secondary Color: <span id="animalSecondaryColor_$id">$secondary_color</span></p>
ZZEOF;
}

?>