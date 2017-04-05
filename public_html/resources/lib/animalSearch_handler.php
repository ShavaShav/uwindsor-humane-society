<?php 

require_once('database.php');
require_once('../templates/animal.php');

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
    echo '<div class="animal" id="'.$id.'" draggable="true" ondragstart="animalDragstart('.$id.')">';
    generateAnimalHTML($id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color);
    echo '</div>';
    }

?>