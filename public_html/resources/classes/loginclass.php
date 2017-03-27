<?php
class user_login{
	//object for database connection
    private $conn = null;
	//error message array
    public $errors = array();
    //other message array
    public $messages = array();

    //constructor for the login object
    public function __construct()
    {
        session_start();
		
		//checks if the logout button was clicked
        if (isset($_GET["logout"])) {
            $this->logout();
        }
        
		//if the login form was submitted, we run the login function
        elseif (isset($_POST["login"])) {
            $this->login();
        }
    }
	
	private function login()
    {
        //check if name/password field are empty
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field empty.";	
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // we should use my PDO class for this
            //database connection using the constants from config.php
            $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			
            //change charset to utf8
            if (!$this->conn->set_charset("utf8")) {
                $this->errors[] = $this->conn->error;
            }

            //if no connect_errno exists, then connection was successful
            if (!$this->conn->connect_errno) {

                //escapes any special characters in the username for use in an SQL statement
                $user_name = $this->conn->real_escape_string($_POST['user_name']);

                //gets username, email, and hashed password --> allows using email adress to login
                $sql = "SELECT user_name, user_email, user_password_hash
                        FROM users
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";
                $login_check = $this->conn->query($sql);

                //this means the user existed
                if ($login_check->num_rows == 1) {

                    //this obtains the results of the query as an object
                    $result_row = $login_check->fetch_object();

                    // password_verify is a php5.5 function, requires the compatability library
					//checks if the hashing of the input password matches the stored hashed pass
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {

                        //if it matched, the username/email are saved in the $_SESSION object & login status is set to 1
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['user_login_status'] = 1;

                    } else {
                        $this->errors[] = "Wrong password";
                    }
                } else {
                    $this->errors[] = "User does not exist";
                }
            } else {
                $this->errors[] = "No database connection";
            }
        }
    }
	
	public function logout()
    {
        //deletes the session
        $_SESSION = array();
        session_destroy();
        $this->messages[] = "You have been logged out.";

    }
	
	public function login_status()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        return false;
    }
}