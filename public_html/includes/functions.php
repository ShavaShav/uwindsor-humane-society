<?php
include_once 'psl-config.php';

function sec_session_start() {
	$session_name = 'sec_session_id'; //Set a custom session name
	
	session_name($session_name);
	
	$secure = true;
	//stops js being able to access session id
	$httponly = true;
	//forces sessions to only use cookies
	
	if (ini_set('session.use_only_cookies', 1) === FALSE) {
		header("Location: ../error.php?err=Could not initiate safe session (ini_set)");
		exit();
	}
	//Gets current cookies paramaters
	
	$cookieParams = session_get_cookie_params();
	session_set_cookie_params($cookieParams["lifetime"],
		$cookieParams["path"],
		$cookieParams["domain"],
		$secure,
		$httponly);
	
	session_start();
	//starts the php session
	session_regenerate_id(true);
	//renerates the session and deletes the previous
}

function login($email, $password, $mysqli){
	//using prepared statements prevents sql injection
	if ($stmt = $mysqli->prepare("SELECT id, username, password
		FROM members
		WHERE email = ?
			LIMIT 1")){
				$stmt->bind_param('s', $email);
				//bind $email to parameter
				$stmt->execute();
				//executes the query
				$stmt->store_result();
				
				//now we get the results
				$stmt->bind_result($user_id, $username, $db_password);
				$stmt->fetch();
				
					if ($stmt->num_rows == 1){
						//if user exists, check if locked from too many attempts
						if (checkbrute($user_id, $mysqli) == true) {
							//account is locked
							return false;
						} else {
							//check if password matches
							//use password_verify to prevent timing attacks
							if (password_verify($password, $db_password)){
								//get user-agent string of the user
								$user_browser = $_SERVER['HTTP_USER_AGENT'];
								//XSS protection, might print value
								$user_id = preg_replace("/[^0-9]+/", "", $user_id);
								$_SESSION['user_id'] = $user_id;
								$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
								$_SESSION['username'] = $username;
								$_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);
								//login success
								return true;
							} else {
								//password not correct, record the attempt
								$now = time();
								$mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')");
								return false;
							}
						}
						
					} else {
						//no user existed
						return false;
					}
			}
}

function checkbrute($user_id, $mysqli){
	$now = time();
	
	$valid_attempts = $now - (2 * 60 * 60);
	
	if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
		$stmt->bind_param('i', $user_id);
		$stmt->execute();
		$stmt->store_result();
		
		//if more than 5 failed attempts
		if ($stmt->num_rows > 5){
			return true;
		} else {
			return false;
		}
	}
}

function login_check($mysqli){
	//check if all session variables set
	if (isset($_SESSION['user_id', $_SESSION['username'), $_SESSION['login_string'])) {
		$user_id = $_SESSION['user_id'];
		$login_string = $_SESSION['login_string'];
		$username = $_SESSION['username'];
		
		//get tht user-agent
		$user_browser = $_SERVER['HTTP_USER_AGENT'];
		
		if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) {
			//bind $user_id to parameter
			$stmt->bind_param('i', $user_id);
			$stmt->execute();
			$stmt->store_result();
			
			if ($stmt->num_rows == 1) {
				//If the user exists get variables from result
				$stmt->bind_result($password);
				$stmt->fetch();
				$login_check = hash('sha512', $password . $user_browser);
				
				if (hash_equals($login_check, $login_string)){
					//user is logged
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}else {
		return false;
	}
}

function esc_url($url) {
	if ('' == $url){
		return $url;
	}
	
	$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
	
	$strip = array('%0d', '%0a', '%0D', '%0A');)
	$url = (string) $url;
	
	$count = 1;
	while ($count) {
		$url = str_replace($strip, '', $url, $count);
	}
	
	$url = str_replace((';//', '://', $url);
	$url = htmlentities($url);
	$url = str_replace('&amp;', '&#038;', $url);
	$url = str_replace("'", '&#039;', $url);
	
	if ($url[0] !== '/'){
		//must be relative from $_SERVER['PHP_SELF']
		return '';
	} else {
		return $url;
	}
}

?>