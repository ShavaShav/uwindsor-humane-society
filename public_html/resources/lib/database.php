<?php
require_once(dirname(__FILE__).'/../config.php');

function prepareStatement($statement){
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

$result = prepareStatement("SELECT id, name, species, age FROM Animals");



?>

