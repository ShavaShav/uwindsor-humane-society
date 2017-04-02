<?php
require_once('database.php');
require_once('../templates/animal.php');

if (isset($_POST['reload_adoptions'])) 
{
    reloadAdoptions();
} 
else if (isset($_POST['reload_surrenders'])) 
{
    reloadSurrenders();
} else if (isset($_POST['option'])) {
    $option = $_POST['option'];
    if (strpos($option, 'surrender') !== false){
        // surrender change
        $db = new SurrenderDB;
        if (!strcmp($option, 'confirm_surrender')){
            // confirming surrender
            $surrenderID = $_POST['id'];
            $animalID = $db->moveToAnimalsTable($surrenderID);
            // Move image from img/surrenders/ to img/animals/ with new id
            rename('../../img/surrenders/'.$surrenderID.'.jpg', '../../img/animals/'.$animalID.'.jpg');
            //TODO SEND EMAILS?
        } else if (!strcmp($option, 'deny_surrender')){
            // denying surrender
            $id = $_POST['id'];
            $db->remove($id); // remove from surrender table
            // delete image
            unlink('../../img/surrenders/' . $id . '.jpg');
            //TODO SEND EMAILS?
        }
        $db->close();
        reloadSurrenders();
    } else {
        // adoption change
        $db = new AnimalDB;
        if (!strcmp($option, 'confirm_adoption')){
            // confirming adoption
 // COMMENTING OUT FOR NOW UNTIL WE GET SURRENDER UP SO WE CAN REINSERT THEM!!!
            $animal_id = $_POST['id'];
   //         $db->remove($animal_id);
            // delete image
 //           unlink('../../img/animals/' . $animal_id . '.jpg');
            //TODO SEND EMAILS?
        } else if (!strcmp($option, 'deny_adoption')){
            // denying adoption
            $username = $_POST['username'];
            $animal_id = $_POST['id'];
            // remove from adoption table
            $db->denyAdoption($username, $animal_id);
            //TODO SEND EMAILS?
        }
        $db->close();
        reloadAdoptions();
    }
}

// print out admin divs based on Adoptions Table
function reloadAdoptions() {
$db = new AnimalDB; // connect to database

$entries = $db->getAllPendingAdoptions(); // query db to get array of animals

// create response: animals divs, javascript that calls this will set the innerHTML
foreach($entries as $entry) {
    $id = $entry["id"]; // animal id
    $name = $entry["name"]; // animal name
    
    $username = $entry["username"];

    echo '<div class="pendingEntry">';
    echo '<div>';
    echo '<p><b>'.$username.'</b> would like to Adopt:</p>';
    generateAnimalShortHTML($id, $name);
    echo <<<ZZEOF
            <input type="hidden" name="username" value="$username">
            <input type="hidden" name="id" value="$id">
            <div class="buttonBox">
                <button onclick="confirmOrDeny('$username',  '$id', 'confirm_adoption')" name="confirm_adoption" id="confirm_adoption" value="Confirm" class="confirmButton">Confirm</button>
                <button onclick="confirmOrDeny('$username',  '$id', 'deny_adoption')" name="deny_adoption" id="deny_adoption" value="Deny" class="denyButton">Deny</button>
            </div>
        </div>
    </div>
ZZEOF;
    }
}

// print out admin divs based on Surrenders Table
function reloadSurrenders() {
$db = new SurrenderDB; // connect to database

$entries = $db->lookup_all(); // query db to get array of animals

// create response: animals divs, javascript that calls this will set the innerHTML
foreach($entries as $entry) {
    $animal_id = $entry["id"];
    $name = $entry["name"]; // animal name
    $species = $entry["species"];
    $age = $entry["age"];
    $gender = $entry["gender"];
    $altered = $entry["altered"];
    $size = $entry["size"];
    $primary_color = $entry["primary_color"];
    $secondary_color = $entry["secondary_color"];
    
    $username = $entry["username"];
    
    echo '<div class="pendingEntry">';
    echo '<div>';
    echo '<b>Animal ID: '.$animal_id.'</b>';
    echo generateSurrenderHTML($username, $animal_id, $name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color);
    
echo <<<ZZEOF
            <input type="hidden" name="username" value="$username">
            <input type="hidden" name="animal_id" value="$animal_id">
            <div class="buttonBox">
                <button onclick="confirmOrDeny('$username',  '$animal_id', 'confirm_surrender')" name="confirm_surrender" id="confirm_surrender" value="Confirm" class="confirmButton">Confirm</button>
                <button onclick="confirmOrDeny('$username',  '$animal_id', 'deny_surrender')" name="deny_surrender" id="deny_surrender" value="Deny" class="denyButton">Deny</button>
            </div>
        </div>
    </div>
ZZEOF;
    }
}
?>