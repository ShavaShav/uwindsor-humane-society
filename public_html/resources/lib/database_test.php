<?php
require_once('../config.php');
require_once('database.php'); // must include, relative to current location, to get UserDB class

// create a user database connection, pages must be hosted be on myWeb or it won't work!
$adminDB = new AdminDB;

echo "<h2>Getting the entire Animals table with AdminDB...</h2><br>";
    
// running a query from raw SQL statement. (*check logs, print results of query if you are getting errors!)
$results = $adminDB->runQuery("SELECT * FROM Animals");

// print the results of array (array of arrays)
foreach($results as $row){
   print_r($row);
   echo "<br>";
}

// example of getting variables for an animal from the results (which is an array (rows/tuples of resultant table) of arrays (columns/attributes of resultant table))
if (sizeof($results) > 0){
    echo '<br><h1>'.$results[0]['name'].' is a '.$results[0]['species'].' who is '.$results[0]['age'].' years old.</h1>'; 
}
// closing connection so we dont have two running simultenously
$adminDB->close();

// Im thinking two different classes of connection - Admin runs anway queries and user is limited
$animalDB = new AnimalDB;

// example of adding filters to query for animals
$filters = array();
$filters["species"] = "cat";
$filters["min_age"] = "0";
$filters["max_age"] = "10";
$filters["primary_color"] = "black";

echo "<h2>Setting some filters to get only black cats with a max age of 10... with UserDB</h2><br>";

// get the filtered animals
$results = $animalDB->getFilteredAnimals($filters);

// show them
foreach($results as $row){
   print_r($row);
   echo "<br>";
}

// testing getNamesStartingWith (takes a partial name and the table)
// For Animals it gets animal name, for Users it gets the username
$results = $animalDB->getNamesStartingWith("B");

echo "<h2>Result of search for animal names starting with B: </h2><h3>";
foreach($results as $row){
   echo $row['name'];
   echo "<br>";
}
echo "</h3>";

$results = $animalDB->getNamesStartingWith("Ch");

echo "<h2>Result of search for animal names starting with Ch: </h2><h3>";
foreach($results as $row){
   echo $row['name'];
   echo "<br>";
}
echo "</h3>";

$animalDB->close(); // close animalDB

$db = new UserDB; // open userDB

//$results = $db->getNamesStartingWith("Sha");
//
//echo "<h2>Result of search for usernames starting with Sha: </h2><h3>";
//foreach($results as $row){
//   echo $row['username'];
//   echo "<br>";
//}
//echo "</h3>";

echo $db->compute_password_hash("Hello");

if ($db->verify_password_hash("Hello", "8b1a9953c4611296a827abf8c47804d7"))
    echo "Password and hash verified!";
else
    echo "Password and hash do not match";

//$db = new userDB();
//echo "Adding some users...\n";
//$db->insert('john', 'hd834h8irtj9');
//$db->insert('suzy', '284hs8d87432jf');
//echo "<br>";
//echo "1. Checking john with incorrect password... ";
//echo $db->check_user_pass('john','abc123') ? 'FAIL' : 'PASS';
//echo "<br>";
//echo "\n2. Checking john with correct password... ";
//echo $db->check_user_pass('john','hd834h8irtj9') ? 'PASS' : 'FAIL';
//echo "\nLookup All...\n";
//print_r($db->lookup_all());
//echo "Lookup...\n";
//print_r($db->lookup('john'));
//echo "<br>";
//echo "3. Erasing john...\n";
//$db->erase('john');
//echo "Lookup All...\n";
//print_r($db->lookup_all());
//echo "<br>";
//echo "4. Checking john with incorrect password... ";
//echo $db->check_user_pass('john','abc123') ? 'FAIL' : 'PASS';
//echo "<br>";
//echo "\n5. Checking john with old correct password... ";
//echo $db->check_user_pass('john','hd834h8irtj9') ? 'FAIL' : 'PASS';
//echo "<br>";
//echo "\n6. Erasing suzy...\n";
//$db->erase('suzy');
//echo "Done.\n";


?>