<?php
require_once('../config.php');

// Users should have limited set of functions
class UserDB
{
    protected $conn; // userDB and adminDB can access the connection

    public function __construct() {
        global $DB; // capture global variable from config.php
        // attempt to connect to the database
        try {
            $this->conn = new PDO("mysql:host=".$DB["host"].";dbname=".$DB["dbname"], $DB["username"], $DB["password"]);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    // run any SQL query and get any result
    public function runQuery($sql) {
        // execute the query
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // returns a filtered list of animals (filters MUST use the ids here)
    public function filteredAnimals($filters) {
        $sql = "SELECT * FROM Animals";
        $whereClauses = [];
        
        // translate filters to where clauses, if they exist (.e.g species="cat")
        if (isset($filters["species"])){
            array_push($whereClauses, 'species="'.$filters["species"].'"');
        }
        if (isset($filters["min_age"]) && isset($filters["max_age"])){
            array_push($whereClauses, 'age BETWEEN '.$filters["min_age"].' AND '.$filters["max_age"]);
        }
        if (isset($filters["gender"])){
            array_push($whereClauses, 'gender="'.$filters["gender"].'"');
        }
        if (isset($filters["altered"])){
            array_push($whereClauses, 'altered="'.$filters["altered"].'"');
        }
        if (isset($filters["size"])){
            array_push($whereClauses, 'size="'.$filters["size"].'"');
        }
        if (isset($filters["primary_color"])){
            array_push($whereClauses, 'primary_color="'.$filters["primary_color"].'"');
        }
        if (isset($filters["secondary_color"])){
            array_push($whereClauses, 'secondary_color="'.$filters["secondary_color"].'"');
        }
        
        // add where clauses to the sql statement
        if (sizeof($whereClauses) > 0){
            $sql = $sql." WHERE ".$whereClauses[0];
            foreach ($whereClauses as $i => $where){
                if ($i < 1) continue;
                $sql = $sql." AND ".$where;
            }
        }
        
        
        $sql = $sql.';'; //
        echo "<h2>".$sql."</h2>";
        
        // execute the query
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getAnimalNamesStartingWith($partialName){
        // search db for names starting with $partialName, return results
    }
    
    public function getUserNamesStartingWith($partialName){
        // search db for names starting with $partialName, return results
    }
}

// TODO:  Admin connection should offer full access
//class dbAdmin extends dbUser
//{
//
//    public function __construct() {
//        global $DB; // capture global variable from config.php
//        // attempt to connect to the database
//        try {
//            $this->conn = new PDO("mysql:host=".$DB["host"].";dbname=".$DB["dbname"], $DB["username"], $DB["password"]);
//            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        } catch(PDOException $e) {
//            echo "Error: " . $e->getMessage();
//        }
//    }
//
//    // run any SQL query and get any result
//    public function runQuery($sql) {
//        // execute the query
//        $stmt = $this->conn->prepare($sql);
//        $stmt->execute();
//
//        // set the resulting array to associative
//        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        return $result;
//    }
//
//}

?>
