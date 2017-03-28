<?php
require_once('../config.php');
require_once('php-pre55-password-hash-utils.php');

// Users should have limited set of functions
class UserDB
{
    protected $conn; // UserDB and AdminDB can access the connection

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
	

    // returns a filtered list of animals (filters MUST use the ids here)
    public function filteredAnimals($filters) {
        $sql = "SELECT * FROM Animals";
        $whereClauses = []; // build an array of WHERE clauses
        
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
        
        $sql = $sql.';'; // end statement
        
        // execute the query
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // gets animals names or usernames, given a partial string and table
    public function getNamesStartingWith($partialName, $tableName){
        // search db for names starting with $partialName, return results
        // can find usernames and pet names, depending on tablename given
        $sql = "SELECT ";
        
        if (!strcmp($tableName, 'Animals')){
            $sql = $sql . "name FROM Animals WHERE name "; // attribute of name in Animals
        } else if (!strcmp($tableName, 'Users')) {
            $sql = $sql . "username FROM Users WHERE username "; // attribute of username in Users
        } else {
            return array(); // invalid, return empty results
        }
        $sql = $sql . "LIKE '" . $partialName . "%';"; // matches names starting with partialName
        
        // execute the query
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // close the connection
    public function close(){
        $this->conn = null;
    }
}

// Admin connection should offer full access through runQuery() and some easy modification querying functions (deleting users, animals, etc)
class AdminDB extends UserDB
{

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

    // This method computes a secure password hash. Some references
  // including why this is done in this manner are:
  //
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

  //
  // function verify_password_hash($plaint_pass, $hashed_pass)
  //
  protected final function verify_password_hash($plain_pass, $hashed_pass)
  {
    global $CFG;

    // Combine the site-wide salt with $pass...
    $salted_pass = $DB->site_wide_password_salt . $plain_pass;
    if (strlen($salted_pass) > 72)
      throw new Exception('Password + site salt too long to avoid truncation.'); 

      // this function is from php-pree55-password-hash-utils-php!!!
    return password_verify($salted_pass, $hashed_pass) === TRUE;
  }

  //
  // insert($user, $pass)
  //
  // Inserts a new user $user into the DBUser table having password $pass.
  //
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

  //
  // erase($user)
  //
  // Erases an existing user $user from the DBUser table.
  //
  public function erase($user)
  {
    $entry = array( ':user' => $user );

    // Create the SQL prepared statement and delete the entry...
    $sql = 'DELETE FROM Users WHERE username = :user';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($entry);
  }

  //
  // check_user_pass($user, $pass)
  //
  // Checks that user $user exists and has password $pass. If
  // such is true, then TRUE is returned. Otherwise FALSE is returned.
  //
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

    //
    // lookup($user)
    //
    // Attempt to look up user $user in the DBUser table. If $user
    // is not found, then FALSE is returned. Otherwise an array
    // containing the DBUser entry is returned. The column names
    // are: "user" and "pass".
    //
    // If the user is not found or a DB error occurs FALSE is
    // returned. Otherwise an associative array for the record is returned.
    //
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

    //
    // lookup_all()
    //
    // Look up all users in the users table. This function permits
    // PDOExceptions to leak.
    //
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

?>
