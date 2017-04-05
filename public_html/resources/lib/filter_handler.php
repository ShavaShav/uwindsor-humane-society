<?php 
require_once('database.php');
require_once('../templates/animal.php');

// form ids designed to map to database names/php args

// go through POST fields(filters), building array to make query
$filters = array();

foreach($_POST as $filter => $value){
    if (!strcmp($value, "all")) // don't add a filter, if selection's value is all
        continue;
    // else add the filter to the array
    $filters[$filter] = htmlspecialchars($value);
}

$db = new AnimalDB; // connect to database

$animals = $db->getFilteredAnimals($filters); // query db to get array of animals

// create response: animals divs, javascript that calls this will set the innerHTML
// show animals from database respone
// filters are drop boxes, so dont need to check
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