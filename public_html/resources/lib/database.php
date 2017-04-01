<?php
require_once(dirname(__FILE__) . '/../config.php');
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

// for animals table
class AnimalDB extends Database {
    // call Database constructor
    public function __construct() {
        parent::__construct();
    }
    
    //inserts a new animal in the Animals table and returns their assigned unique id
	public function insert($name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color) {
        
        // Create the SQL prepared statement and insert the entry...
        $sql = 'INSERT INTO Animals (name, species, age, gender, altered, size, primary_color, secondary_color) VALUES (:name, :species, :age, :gender, :altered, :size, :primary_color, :secondary_color)';
        
        // prepare the statement
        $stmt = $this->conn->prepare($sql);
        
        // bind parameters
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':species', $species, PDO::PARAM_STR);
        $stmt->bindValue(':age', $age, PDO::PARAM_INT);
        $stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindValue(':altered', $altered, PDO::PARAM_STR);
        $stmt->bindValue(':size', $size, PDO::PARAM_STR);
        $stmt->bindValue(':primary_color', $primary_color, PDO::PARAM_STR);
        $stmt->bindValue(':secondary_color', $secondary_color, PDO::PARAM_STR);
        
        $stmt->execute();
    
        return $this->getMaxID();
	}
    
    // deletes animal from database, which cascade delete entries in adoption table
    // so when an admin confirms adoption, just call this method and send them an email
    public function remove($id){
        try {
            // Create the SQL prepared statement and delete the entry...
            $sql = 'DELETE FROM Animals WHERE id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            $stmt->execute();
                    
            return TRUE;
        } catch (PDOException $e) {
            return FALSE;
        }
    }
    
    // this removes the entry in the Adoption table, admin uses to deny adoption before emailing
    public function denyAdoption($username, $animal_id) {
        try {
            // Create the SQL prepared statement and delete the entry...
            $sql = 'DELETE FROM Adoptions WHERE username = :username AND animal_id = :animal_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            
            $stmt->execute();
                    
            return TRUE;
        } catch (PDOException $e) {
            return FALSE;
        }
    }
    
    
    // this will place the username and animal's id in the Adoptions table,
    // so that the admin can either confirm or deny them. User uses this function
    public function requestAdoption($username, $animal_id) {
        try {
      
            $sql = 'INSERT INTO Adoptions (username, animal_id) VALUES (:username, :animal_id)';

            // prepare the statement
            $stmt = $this->conn->prepare($sql);

            // bind parameters
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);

            $stmt->execute();
            
            return TRUE;
        } catch (PDOException $e) {
            return FALSE;
        }
    }
    
    // this returns the username, with animals details for every requested adoption
    // This function permits PDOExceptions to leak.
    public function getAllAdoptions() {
        // Create the SQL prepared statement and insert the entry...
        $sql = 'SELECT * FROM Adoptions';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
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
    
    // gets animals with full attributes, given a partial name
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
    
    public function lookup($id)
    {
        // Create the entry to add...
        $entry = array( ':id' => $id );

        // Create the SQL prepared statement and insert the entry...
        try
        {
          $sql = 'SELECT * FROM Animals WHERE id = :id';
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
    
    public function hasRequestedAdoption($username, $id)
    {
        // Create the SQL prepared statement and insert the entry...
        try
        {
          $sql = 'SELECT * FROM Adoptions WHERE animal_id = :id AND username = :username';
          $stmt = $this->conn->prepare($sql);
            
          // binad params (safety measure)
          $stmt->bindValue(':username', $username, PDO::PARAM_STR);  
          $stmt->bindValue(':id', $id, PDO::PARAM_INT);        

          $stmt->execute();
          $result = $stmt->fetchAll();
          if (count($result) != 1)
            return FALSE;
          else
            return TRUE;
        }
        catch (PDOException $e)
        {
          return FALSE;
        }
    }
    
    public function getMaxID(){
         // get the last id generated, which is the max
        $sql = "SELECT MAX(id) FROM Animals";
        // prepare the statement
        $stmt = $this->conn->prepare($sql);
        // execute
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_NUM);
        return $result[0][0];
    }
    
    // call this function to reset the auto-incrementing id
    public function resetAutoID(){
        $nextId = $this->getMaxID();
        $nextId = $nextId + 1;
        
        // prepare the statement
        $sql = "ALTER TABLE Animals AUTO_INCREMENT=:id";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(':id', $nextId, PDO::PARAM_INT);
        
        // execute
        $stmt->execute();
    }
}

//SurrenderDB offers functions for accessing and manipulating surrender table _ This table is a short-term holding area until admin either approves to be put into Animals table or denies them and deletes animal
class SurrenderDB extends Database {
	
	//call Database constructor
	public function __construct() {
		parent::__construct();
	}
	
	//inserts a new animal in the surrender table and returns the surrender id
    // Make sure that whoever uses this functions saves an img in /img/surrender with the returned id.jpg!
	public function insert($name, $species, $age, $gender, $altered, $size, $primary_color, $secondary_color, $username) {
		// Create the entry to add...
        $entry = array(
            ':name' => $name,
            ':species' => $species,
            ':age' => $age,
            ':gender' => $gender,
            ':altered' => $altered,
            ':size' => $size,
            ':primary_color' => $primary_color,
            ':secondary_color' => $secondary_color,
            ':username' => $username
            
        );

        // Create the SQL prepared statement and insert the entry... // not sure how :user works but trusting preney on this one OUTPUT Inserted.id
        $sql = 'INSERT INTO Surrenders (name, species, age, gender, altered, size, primary_color, secondary_color, username) VALUES (:name, :species, :age, :gender, :altered, :size, :primary_color, :secondary_color, :username)';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($entry);
        
        return $this->getMaxID();
	}
    
    // moves animal from surrenders to animals table, given their surrender id
    // used by admin when approving a surrender.
    // return the animals ID in the animals table
    public function moveToAnimalsTable($id){
        try {
            // copy values from surrender to animals table
            $sql = "INSERT INTO Animals (name, species, age, gender, altered, size, primary_color, secondary_color)
                    SELECT name, species, age, gender, altered, size, primary_color, secondary_color
                    FROM Surrenders
                    WHERE id = :id";
            // prepare statement
            $stmt = $this->conn->prepare($sql);
            // bind params
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            // execute the query
            $stmt->execute();

            // get the animals new id from the animalsTable
            $sql = "SELECT MAX(id) FROM Animals";
            // prepare the statement
            $stmt = $this->conn->prepare($sql);
            // execute
            $stmt->execute();
            $newId = $stmt->fetchAll(PDO::FETCH_NUM);
            
            // delete animal from surrender table
            $sql = "DELETE FROM Surrenders WHERE id = :id";
            // prepare statement
            $stmt = $this->conn->prepare($sql);
            // bind params
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            // execute the query
            $stmt->execute();
            
            return $newId[0][0];
        } catch (PDOException $e) {
            return FALSE;
        }
    }   
    
    // deletes animal from surrenders to animals table, given their surrender id
    // used by admin when denying a surrender
    public function remove($id){
        try {
            // delete animal from surrender table
            $sql = "DELETE FROM Surrenders WHERE id = :id";
            // prepare statement
            $stmt = $this->conn->prepare($sql);
            // bind params
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            // execute the query
            $stmt->execute();
            
            return TRUE;
        } catch (PDOException $e) {
            return FALSE;
        }
    }  

    // Look up all animals in the Surrenders table. This function permits
    // PDOExceptions to leak.
    public function lookup_all() {
        // Create the SQL prepared statement and insert the entry...
        $sql = 'SELECT * FROM Surrenders';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getMaxID() {
         // get the last id generated, which is the max
        $sql = "SELECT MAX(id) FROM Surrenders";
        // prepare the statement
        $stmt = $this->conn->prepare($sql);
        // execute
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_NUM);
        return $result[0][0];
    }
    
    // call this function to reset the auto-incrementing id to the next max id (for testing)
    public function resetAutoID(){
        $nextId = $this->getMaxID();
        $nextId = $nextId + 1;
        
        // prepare the statement
        $sql = "ALTER TABLE Surrenders AUTO_INCREMENT=:id";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(':id', $nextId, PDO::PARAM_INT);
        
        // execute
        $stmt->execute();
    }
}


// UserDB offers functions for accessing and manipulating user table
class UserDB extends Database {

    // call Database constructor
    public function __construct() {
        parent::__construct();
    }
    
    public function modifyEmail($username, $email){
        try {
            $sql = "UPDATE Users SET email=:email WHERE username=:username";

            // prepare statement
            $stmt = $this->conn->prepare($sql);

            // bind params (safety measure)
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);

            // execute the query
            $stmt->execute();

            return TRUE;
        } catch (PDOException $e) {
            return FALSE;
        }
    }
    
    // this function takes an unhashed password! assumes that check_user_password already called
    // to verify old password
    public function modifyPassword($username, $password){
        
        $hashed = $this->compute_password_hash($password);
        
        try {
            $sql = "UPDATE Users SET password=:password WHERE username=:username";

            // prepare statement
            $stmt = $this->conn->prepare($sql);

            // bind params (safety measure)
            $stmt->bindValue(':password', $hashed, PDO::PARAM_STR);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);

            // execute the query
            $stmt->execute();

            return TRUE;
        } catch (PDOException $e) {
            return FALSE;
        }
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
    
    public final function compute_password_hash($password){
        return md5($password);
    }

    public final function verify_password_hash($plain_pass, $hashed_pass){
         // check if plain passwords md5 form is equal to
        $new_hash = $this->compute_password_hash($plain_pass);
        $compare = strcmp($new_hash, $hashed_pass);
        return ($compare == 0);
    }
    
    public final function check_user_password($user, $plain_password){
        try {
            // prepare statement
            $sql = "SELECT password FROM Users WHERE username = :user"; // get hashed password
            $stmt = $this->conn->prepare($sql);
            // will just check these because they are open to user input, should be integer
            $stmt->bindValue(':user', $user, PDO::PARAM_STR);
            // execute the query
            $stmt->execute();
            // set the resulting array to associative
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // user has a password in table
            if (!empty($result)) {
                $hashed_password = $result[0]['password']; // get pw
                return $this->verify_password_hash($plain_password, $hashed_password);
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            return FALSE;
        }
    }
    
    // Inserts a new user $user into the DBUser table having password $pass.
    public function insert($user, $pass, $email)
    {
        // Create the entry to add...
        $entry = array(
            ':user' => $user,
            ':pass' => $this->compute_password_hash($pass),
            ':email' => $email,
        );

        // Create the SQL prepared statement and insert the entry... // not sure how :user works but trusting preney on this one
        $sql = 'INSERT INTO Users (username, password, email) VALUES (:user, :pass, :email)';
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

    // Attempt to look up user $user in the Users table. If $user
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


    // returns true if username is found is db
    public function checkUserExists($username){
        $result = $this->lookup($username);
        if($result == FALSE){
			return FALSE;
		} else {
			return TRUE;
		}
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
