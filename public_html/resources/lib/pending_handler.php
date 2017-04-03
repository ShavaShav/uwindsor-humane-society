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
    // storing some post variables and common stuff that will be in every email
    $option = $_POST['option'];
    $admin_email = 'uwindsorhs@gmail.com';
    // set up mail header   
    $db = new UserDB;
    $username = $_POST['username'];
    $user = $db->lookup($username); // get the user details
    $user_email = $user['email']; // get their email address
    $db->close();
    
    $header = "From: $admin_email\r\n"; 
    $header.= "MIME-Version: 1.0\r\n"; 
    $header.= "Content-Type: text/plain; charset=utf-8\r\n"; 
    $header.= "X-Priority: 1\r\n"; 
    
    $message = "Dear ".$username.", \r\n\r\n";
    
    if (strpos($option, 'surrender') !== false){
        // surrender change
        $db = new SurrenderDB;
        $surrenderID = $_POST['id'];
        $surrenderAnimal = $db->lookup($surrenderID);
        $surrenderName = $surrenderAnimal['name'];
        if (!strcmp($option, 'confirm_surrender')){
            // confirming surrender
            $surrenderID = $_POST['id'];
            $animalID = $db->moveToAnimalsTable($surrenderID);
            // Move image from img/surrenders/ to img/animals/ with new id
            rename('../../img/surrenders/'.$surrenderID.'.jpg', '../../img/animals/'.$animalID.'.jpg');
            
            // send email to user
            $subject = 'Approval of '.surrenderName.'\'s surrender to the uWindsor Humane Society.';
            $message .= "Your request for surrender of ".surrenderName." to the uWindsor Humane Society has been approved. Please stop by soon to drop them off and fill out some paperwork. Feel free to contact us if you would like more information.";
        } else if (!strcmp($option, 'deny_surrender')){
            // denying surrender
            $db->remove($surrenderId); // remove from surrender table
            // delete image
            unlink('../../img/surrenders/' . $id . '.jpg');
            
             // send email to user
            $subject = 'Denial of '.surrenderName.'\'s surrender to the uWindsor Humane Society.';
            $message .= "Unfortunately, your request for surrender of ".surrenderName." to the uWindsor Humane Society has been denied. Please contact us if you would like more information.";
        }
        $db->close();
        reloadSurrenders();
    } else {
        // adoption change
        $db = new AnimalDB;
        $id = $_POST['id'];
        $animal = $db->lookup($id);
        $animalName = $animal['name'];
        if (!strcmp($option, 'confirm_adoption')){
            // confirming adoption, Send email to users
            // will need to email other users who were effectively denied
            $users = $db->getUsersWhoRequestAdoption($id);// get all users who want this animal
            foreach($users as $user_entry){
                if (!strcmp($user_entry['username'], $username)) {
                    // the chosen user who was confirmed.
                    $subject = $animalName.' has got a new home!';
                    $message .= "Your request to adopt ".$animalName." from the uWindsor Humane Society has been approved. Please come by soon to fill out paperwork and pick them up! :) Please contact us if you would like more information.";
                    // this will be in the main email being generated here
                } else {
                    // denied users, call function that makes a seperate email
                    adoptDenyEmail($user_entry, $animalName, $header);
                }
            }
 // COMMENTING OUT FOR NOW UNTIL WE GET SURRENDER UP SO WE CAN REINSERT THEM!!!    
            // now safe to remove the animal from our tables
//            $db->remove($id);
            // delete image
//            unlink('../../img/animals/' . $id . '.jpg');
        } else if (!strcmp($option, 'deny_adoption')){
            // denying adoption
            // remove from adoption table
            $db->denyAdoption($username, $id);
            
            // Send email to user
            $subject = 'Denial of '.$animalName.'\'s adoption from the uWindsor Humane Society.';
            $message .= "After much consideration, your request to adopt ".$animalName." from the uWindsor Humane Society has been denied. We would like to thank you for your interest. Please contact us if you would like more information.";
        }
        $db->close();
        reloadAdoptions();
    }
    $message .= "\r\n\r\nSincerely,\r\nThe uWindsor Humane Society Team";
    
    $success = mail($user_email, $subject, $message, $header);
    
    // show the admin whether operations were successful via JS window alert
    if ($success){
        echo '<script>alert("Users have been notified by email!")</script>';
    } else {
        echo '<script>alert("Postmaster was unable to send emails!")</script>';
    }
    
}

// this method does not check for if a denial letter has error in sending
function adoptDenyEmail($user, $animalName, $header){
    // set up mail header   
    $db = new UserDB;
    $username = $_POST['username'];
    $user = $db->lookup($username); // get the user details
    $user_email = $user['email']; // get their email address
    $db->close();
    
    // build email 
    $subject = $animalName.' is no longer available for adoption from the uWindsor Humane Society.';
    $message .= "Unfortunately, ".$animalName." is not longer available for adoption from the uWindsor Humane Society. We would like to thank you for your interest. Please contact us if you would like more information.";

    $message .= "\r\n\r\nSincerely,\r\nThe uWindsor Humane Society Team";
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