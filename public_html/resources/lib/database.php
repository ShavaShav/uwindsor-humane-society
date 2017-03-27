<?php
require_once('../config.php');
require_once('password_functions.php');



class registration
{
	//object for database connection
    private $conn = null;
	//error message array
    public $errors = array();
    //other message array
    public $messages = array();


    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerUser();
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function registerUser()
    {
		//checks the formatting conditions and for empty fields
		//does so using the empty function and regular expressions
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "Passwords must match";
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $this->errors[] = "Password minimum 6 characters";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "Username must be 2-64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "Username format incorrect: only letters and numbers, 2-64 characters";
        } elseif (empty($_POST['user_email'])) {
            $this->errors[] = "Email cannot be empty";
        } elseif (strlen($_POST['user_email']) > 64) {
            $this->errors[] = "Email must be less than 64 characters";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email is not formatted correctly: name@website.postfix";
        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
			
            $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->conn->set_charset("utf8")) {
                $this->errors[] = $this->conn->error;
            }

            //if no connect_errno exists, then connection was successful
            if (!$this->conn->connect_errno) {

			
				//removes special characters and anything that could be code
                $user_name = $this->conn->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $user_email = $this->conn->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));

                $user_password = $_POST['user_password_new'];

                //password_hash is hashes the inputted password string, used through the compatability library
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                //query to see if the email/username already exists in the database
                $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
                $check_user_name = $this->conn->query($sql);

                if ($check_user_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {
                    //If they didnt exist, we write them to the DB
                    $sql = "INSERT INTO users (user_name, user_password_hash, user_email)
                            VALUES('" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "');";
                    $query_new_user_insert = $this->conn->query($sql);

                    //Report back to user a success or failure
                    if ($query_new_user_insert) {
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            } else {
                $this->errors[] = "No database connection made.";
            }
        } else {
            $this->errors[] = "Unknown error.";
        }
    }
}

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

}

?>
