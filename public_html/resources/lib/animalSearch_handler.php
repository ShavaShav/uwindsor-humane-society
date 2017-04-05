<?php 

require_once('database.php');

$partialSearch = htmlspecialchars($_POST['name']);

$db = new AnimalDB; // connect to database

    $animals = $db->getAnimalsWithNamesContaining($partialSearch); // query db to get array of animals
 
 
    foreach($animals as $animal) {
    $id = $animal["id"];
    $name = $animal["name"];
    $species = $animal["species"];
    $age = $animal["age"];
    $gender = $animal["gender"];
    $altered = $animal["altered"];
    $size = $animal["size"];
    $primary_color = $animal["primary_color"];
    $secondary_color = $animal["secondary_color"];
    echo <<<ZZEOF
    <div class="animal" id="$id" draggable="true" ondragstart="animalDragstart($id)">
        <img src="../../img/animals/$id.jpg">
        <p><span id="attribute">Name: </span><span id="animalName_$id">$name</span></p>
        <p><span id="attribute">Species: </span><span id="animalSpecies_$id">$species</span></p>
        <p><span id="attribute">Age: </span><span id="animalAge_$id">$age</span></p>
        <p><span id="attribute">Gender: </span><span id="animalGender_$id">$gender</span></p>
        <p><span id="attribute">Altered: </span><span id="animalAltered_$id">$altered</span></p>
        <p><span id="attribute">Size: </span><span id="animalSize_$id">$size</span></p>
        <p><span id="attribute">Primary Color: </span><span id="animalPrimaryColor_$id">$primary_color</span></p>
        <p><span id="attribute">Secondary Color: </span><span id="animalSecondaryColor_$id">$secondary_color</span></p>
    </div>
ZZEOF;
    }

?>