<?php
require_once('../config.php');

echo $DB["host"] . "\n";
echo $DB["dbname"]."\n";
echo $DB["username"] . "\n";
echo $DB["password"] . "\n";

function prepareStatement($statement){
    global $DB;
    try {
    // connect to db
    $conn = new PDO("mysql:host=".$DB["host"].";dbname=".$DB["dbname"], $DB["username"], $DB["password"]);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // do the query
    $stmt = $conn->prepare($statement);
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
    // close current db connection
    $conn = null;
}

// make a query
$result = prepareStatement("SELECT id, name, species, age FROM Animals");

//create an array of the results
//$resultsArray = array();
foreach($result as $row){
    print_r($row);
    echo "<br>";
    //array_push($results_array, $row);
}

// prints json object
//echo json_encode($resultsarray);
print('\n');

?>

