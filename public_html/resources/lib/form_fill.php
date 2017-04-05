<?php

function post_session_field($postfield, $sessfield, $deflt='')
{
	if (isset($_POST[$postfield]))
		$_SESSION[$sessfield] = htmlspecialchars($_POST[$postfield]);
	else if (!isset($_SESSION[$sessfield]))
		$_SESSION[$sessfield] = $deflt;
}

function session_field($sessfield, $deflt='')
{
	if (isset($_SESSION[$sessfield]))
		return $_SESSION[$sessfield];
	else
		return $deflt;
}

function logformdata(){
	post_session_field('user_name', 'user_name');
}

function regformdata(){
	post_session_field('reg_user_name','reg_user_name');
	post_session_field('email','email');	
}

?>