<?php
require_once('../config.php');
require_once('database.php'); // must include, relative to current location, to get UserDB class

// create a user database connection
$userDB = new UserDB;

echo "<h2>Gettings entire Animals table...</h2><br>";
    
// running a query from raw SQL statement. (*check logs, print results of query if you are getting errors!)
$results = $userDB->runQuery("SELECT * FROM Animals");

// print the results of array (array of arrays)
foreach($results as $row){
   print_r($row);
   echo "<br>";
}

// example of getting variables for an animal from the results (which is an array (rows/ of resultant table) of arrays (columns/attributes of resultant table))
if (sizeof($results) > 0){
    echo '<br><h1>'.$results[0]['name'].' is a '.$results[0]['species'].' who is '.$results[0]['age'].' years old.</h1>'; 
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

echo "<h2>Setting some filters and getting Animals...</h2><br>";

// get the filtered animals
$results = $userDB->filteredAnimals($filters);

// show them
foreach($results as $row){
   print_r($row);
   echo "<br>";
}

?>