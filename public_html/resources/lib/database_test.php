<?php
require_once('../config.php');
require_once('database.php');

// create a user database connection
$userDB = new UserDB;

// running a query from raw SQL statement. (*check logs, print results of query if you are getting errors!)
$results = $userDB->runQuery("SELECT * FROM Animals");

// print the results of array (array of arrays)
foreach($results as $row){
   print_r($row);
   echo "<br>";
}

// example of getting variables for an animal from the results (which is an array (rows/ of resultant table) of arrays (columns/attributes of resultant table))
if (sizeof($results) > 0){
    echo '<br><h2>'.$results[0]['name'].' is a '.$results[0]['species'].' who is '.$results[0]['age'].' years old.</h2>'; 
}

// example of adding filters to query for animals
$filters = array();
$filters["species"] = "dog";
$filters["min_age"] = "0";
$filters["max_age"] = "10";
$filters["size"] = "medium";
$filters["altered"] = "no";
$filters["gender"] = "male";
$filters["primary_color"] = "black";
$filters["secondary_color"] = "tan";

// get the filtered animals
$results = $userDB->filteredAnimals($filters);

// show them
foreach($results as $row){
   print_r($row);
   echo "<br>";
}

?>