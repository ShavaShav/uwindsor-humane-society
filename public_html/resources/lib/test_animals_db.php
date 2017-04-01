<?php
require_once('../config.php');
require_once('database.php'); // must include, relative to current location, to get UserDB class

// just resetting the auto increments so they start at the next appropriate id
// doing this while testing as alot of ids get wasted if not
$db = new AnimalDB;
$db->resetAutoID();
$db->close();
$db = new SurrenderDB;
$db->resetAutoID();
$db->close();


/*
 * SURRENDERING, AND SUBSEQUENT CONFIRMATION OR DENYAL
 */


$db = new SurrenderDB;

$db->resetAutoID();

echo "<br><br><h2>Inserting Zach the Cat into Surrender....</h2><br>";
$surrenderID = $db->insert('Zach', 'cat', 4, 'male', 'yes', 'medium', 'white', 'black', 'shaverz');

echo "<br><br><h2>Zach the Cat given the temp id of ".$surrenderID."....</h2><br>";

echo "<br><br><h2>Confirming Zach the Cat's Surrender (Moving to Animals Table)....</h2><br>";
$animalID = $db->moveToAnimalsTable($surrenderID);

echo "<br><br><h2>Zach the Cat's new id in the Animal Table is ".$animalID.".</h2>";


echo "<br><br><h2>Inserting Kyle the Dog into Surrender....</h2><br>";
$surrenderID = $db->insert('Kyle', 'Dog', 6, 'male', 'yes', 'medium', 'white', 'none', 'shaverz');

echo "<br><br><h2>Denying Kyle the Dog's Surrender due to Fleas....</h2><br>";
echo $db->remove($surrenderID) == TRUE ? "SUCCESS" : "FAIL";

$db->close();


/*
 * INSERTING ANIMALS MANUALLY (as opposed to thru surrender) AND THE PROCESS OF ADOPTION (REMOVAL)
 */

$db = new AnimalDB;

echo "<br><br><h2>Removing Zach the Cat from the database, turns out he had fleas too....</h2><br>";
echo $db->remove($animalID) == TRUE ? "SUCCESS" : "FAIL";

echo "<br><br><h2>An admin inserts Craig the Reptile directly into Animals...</h2><br>";

$animalId = $db->insert('Craig', 'reptile', 1, 'male', 'no', 'small', 'green', 'yellow');


// users will click button in wishlist to request adoption
echo "<br><br><h2>kimficara requests to adopt Craig...</h2><br>";
echo $db->requestAdoption('kimficara', $animalId) == TRUE ? "SUCCESS" : "FAIL";

echo "<br><br><h2>shaverz requests to adopt Craig...</h2><br>";
echo $db->requestAdoption('shaverz', $animalId) == TRUE ? "SUCCESS" : "FAIL";


echo "<br><br><h2>An admin confirms Craig's adoption to shaverz... Sorry kimficara! Sending emails to both...</h2><br>";
// send out emails
sendAdoptionEmails($animalId, "shaverz");
// remove animal from db
echo $db->remove($animalId) == TRUE ? "SUCCESS" : "FAIL";

$db->close();

// idea for how to deal with confirming animals and notifying all others who also wanted it
// we could also just not send people who are denied any email, probably wouldn't hurt our grade..
function sendAdoptionEmails($id, $username){
    // send a confirmation to username's email
    
    // send denial emails to other users with animal_id in Adoption Table
}

?>