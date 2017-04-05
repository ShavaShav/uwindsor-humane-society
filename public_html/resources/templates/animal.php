<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');

function generateAnimalHTML($id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color){
    echo '<img src="../../img/animals/'.$id.'.jpg" class="animalImage">';
    generateAnimalDetails($id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color);
}

function generateAnimalShortHTML($id, $name){
    echo '<img src="../../img/animals/'.$id.'.jpg" class="animalImage">';
    echo '<p id="animalName_$id">'.$name.'</p>';
}

// generate surrender details with image and header
function generateSurrenderHTML($username, $id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color){
    echo '<p><b>'.$username.'</b> wishes to surrender:</p>';
    echo '<img src="../../img/surrenders/'.$id.'.jpg" class="animalImage">';
    generateAnimalDetails($id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color);
}

// generate just the animals details, no picture
function generateAnimalDetails($id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color){
 echo <<<ZZEOF
    <p><span id="attribute">Name: </span><span id="animalName_$id">$name</span></p>
    <p><span id="attribute">Species: </span><span id="animalSpecies_$id">$species</span></p>
    <p><span id="attribute">Age: </span><span id="animalAge_$id">$age</span></p>
    <p><span id="attribute">Gender: </span><span id="animalGender_$id">$gender</span></p>
    <p><span id="attribute">Altered: </span><span id="animalAltered_$id">$altered</span></p>
    <p><span id="attribute">Size: </span><span id="animalSize_$id">$size</span></p>
    <p><span id="attribute">Primary Color: </span><span id="animalPrimaryColor_$id">$primary_color</span></p>
    <p><span id="attribute">Secondary Color: </span><span id="animalSecondaryColor_$id">$secondary_color</span></p>
ZZEOF;
}

?>