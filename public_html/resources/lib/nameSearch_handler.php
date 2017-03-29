<?php 

require_once('database.php');

// go through POST fields(filters), building array to make query
$partialSearch = $_POST['name'];

$db = new AnimalDB; // connect to database

 $animals = $db->getNamesStartingWith($partialSearch); // query db to get array of animals
 
 if (sizeof($animals) != 0)
 {
 	echo $animals[0]['name'];
 }
 
 else
 {
 	echo "No animals found!";
 }
 
 echo "<script>makeAnimalsDraggable()</script>";

?>