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
        <p>Name: <span id="animalName_$id">$name</span></p>
        <p>Species: <span id="animalSpecies_$id">$species</span></p>
        <p>Age: <span id="animalAge_$id">$age</span></p>
        <p>Gender: <span id="animalGender_$id">$gender</span></p>
        <p>Altered: <span id="animalAltered_$id">$altered</span></p>
        <p>Size: <span id="animalSize_$id">$size</span></p>
        <p>Primary Color: <span id="animalPrimaryColor_$id">$primary_color</span></p>
        <p>Secondary Color: <span id="animalSecondaryColor_$id">$secondary_color</span></p>
    </div>
ZZEOF;
    }

?>