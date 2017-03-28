<?php
require_once('../config.php');
require_once('php-pre55-password-hash-utils.php');

class Database {
    protected $conn; // Actual connection is inherited by UserDB, AnimalsDB, WishlistDB and AdminDB
    
    public function __construct() {
        global $DB; // capture global variable from config.php
        
        // attempt to connect to the database
        try {
            $this->conn = new PDO("mysql:host=".$DB["host"].";dbname=".$DB["dbname"], $DB["username"], $DB["password"]);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
            $this->conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    // close the connection
    public function close(){
        $this->conn = null;
    }
}

class AnimalDB extends Database {
    // call Database constructor
    public function __construct() {
        parent::__construct();
    }
    
    // returns a filtered list of animals (filters MUST use the ids here)
    public function getFilteredAnimals($filters) {
        $sql = "SELECT * FROM Animals";
        $whereClauses = []; // build an array of WHERE clauses
        
        // translate filters to where clauses, if they exist (.e.g species="cat")
        if (isset($filters["species"])){
            array_push($whereClauses, 'species="'.$filters["species"].'"');
        }
        if (isset($filters["min_age"]) && isset($filters["max_age"])){
            array_push($whereClauses, 'age BETWEEN :min_age AND :max_age');
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
        
        $sql = $sql.';'; // end statement
        
        // execute the query
        $stmt = $this->conn->prepare($sql);
        
        // will just check these because they are open to user input, should be integer
        $stmt->bindParam(':min_age', $filters["min_age"], PDO::PARAM_INT);
        $stmt->bindParam(':max_age', $filters["max_age"], PDO::PARAM_INT);
        
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // gets animals with full attributs, given a partial name
    public function getAnimalsWithNamesContaining($partialName){
        
        $partialName = "%$partialName%"; // match characters before or after
        
        // prepare statement
        $sql = "SELECT * FROM Animals WHERE name LIKE :partial_name";
        $stmt = $this->conn->prepare($sql);
        
        // binad params (safety measure)
        $stmt->bindValue(':partial_name', $partialName, PDO::PARAM_STR);
        
        // execute the query
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // gets animals names, given a partial name
    public function getNamesStartingWith($partialName){
        // match names starting with
        $partialName = "$partialName%";
       
        $sql = "SELECT name FROM Animals WHERE name LIKE :partial_name";
        
        // prepare statement
        $stmt = $this->conn->prepare($sql);
        
        // binad params (safety measure)
        $stmt->bindValue(':partial_name', $partialName, PDO::PARAM_STR);
        
        // execute the query
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

// UserDB offers functions for accessing and manipulating user table
class UserDB extends Database {

    // call Database constructor
    public function __construct() {
        parent::__construct();
    }
    
    // gets usernames, given a partial username *** might not be used in site
    public function getNamesStartingWith($partialName){
        // search db for names starting with $partialName, return results
        // matches names starting with partialName
        $sql = "SELECT username FROM Users WHERE username LIKE :partial_name";
        
        // prepare statement
        $stmt = $this->conn->prepare($sql);
        
        // binad params (safety measure)
        $stmt->bindValue(':partial_name', $partialName, PDO::PARAM_STR);
        
        // execute the query
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    /*
     * The following are Professor Preneys functions for manipulating 
     * the Users table, slightly altered to suit our table.
     */
    
    // This method computes a secure password hash. 
    protected final function compute_password_hash($pass)
    {
        global $DB; // caputure config.php var

    // Combine the site-wide salt with $pass...
    $salted_pass = $DB->site_wide_password_salt . $pass;
    if (strlen($salted_pass) > 72)
        throw new Exception('Password + site salt too long to avoid truncation.'); 

        // this function is from php-pree55-password-hash-utils-php!!!
        return password_hash($salted_pass, PASSWORD_DEFAULT);
    }

    // function verify_password_hash($plaint_pass, $hashed_pass)
    protected final function verify_password_hash($plain_pass, $hashed_pass)
    {
        global $DB;

        // Combine the site-wide salt with $pass...
        $salted_pass = $DB->site_wide_password_salt . $plain_pass;
        if (strlen($salted_pass) > 72)
            throw new Exception('Password + site salt too long to avoid truncation.'); 

        // this function is from php-pree55-password-hash-utils-php!!!
        return password_verify($salted_pass, $hashed_pass) === TRUE;
    }

    // Inserts a new user $user into the DBUser table having password $pass.
    public function insert($user, $pass)
    {
        // Create the entry to add...
        $entry = array(
            ':user' => $user,
            ':pass' => $this->compute_password_hash($pass),
        );

        // Create the SQL prepared statement and insert the entry... // not sure how :user works but trusting preney on this one
        $sql = 'INSERT INTO Users (username, password) VALUES (:user, :pass)';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($entry);
    }

    // Erases an existing user $user from the DBUser table.
    public function erase($user)
    {
        $entry = array( ':user' => $user );

        // Create the SQL prepared statement and delete the entry...
        $sql = 'DELETE FROM Users WHERE username = :user';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($entry);
    }

    // Checks that user $user exists and has password $pass. If
    // such is true, then TRUE is returned. Otherwise FALSE is returned.
    public function check_user_pass($user, $pass)
    {
        // Create the entry to add...
        $entry = array( ':user' => $user );

        // Create the SQL prepared statement and insert the entry...
        try
        {
          $sql = 'SELECT password FROM Users WHERE username = :user';
          $stmt = $this->conn->prepare($sql);
          $stmt->execute($entry);
          $result = $stmt->fetchAll();
          if (count($result) == 1 && array_key_exists('pass', $result[0]))
          {
            return $this->verify_password_hash($pass, $result[0]['pass']);
          }
          else
            return FALSE;
        }
        catch (PDOException $e)
        {
          return FALSE;
        }
    }

    // Attempt to look up user $user in the DBUser table. If $user
    // is not found, then FALSE is returned. Otherwise an array
    // containing the DBUser entry is returned. The column names
    // are: "user" and "pass".
    //
    // If the user is not found or a DB error occurs FALSE is
    // returned. Otherwise an associative array for the record is returned.
    public function lookup($user)
    {
        // Create the entry to add...
        $entry = array( ':user' => $user );

        // Create the SQL prepared statement and insert the entry...
        try
        {
          $sql = 'SELECT * FROM Users WHERE username = :user';
          $stmt = $this->conn->prepare($sql);
          $stmt->execute($entry);
          $result = $stmt->fetchAll();
          if (count($result) != 1)
            return FALSE;
          else
            return $result[0];
        }
        catch (PDOException $e)
        {
          return FALSE;
        }
    }

    // Look up all users in the users table. This function permits
    // PDOExceptions to leak.
    public function lookup_all()
    {
        // Create the SQL prepared statement and insert the entry...
        $sql = 'SELECT * FROM Users';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // inserts a new user into the Users table, return true if successful
    public function insertNewUser($username, $hashed_password, $email){
        $sql = "INSERT INTO Users (username, password, email) VALUES('" . $username . "', '" . $hashed_password . "', '" . $email . "');";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }

    // returns true if username is found is db
    public function checkUserExists($username){
        $sql = "SELECT * FROM Users WHERE username='" . $user_name . "';";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute();

        if (sizeof($result) > 0)
            return true;
        else
            return false;
    }
}

// Admin connection should offer full access through runQuery()
class AdminDB extends Database {

    // call Database constructor
    public function __construct() {
        parent::__construct();
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
}

?>
