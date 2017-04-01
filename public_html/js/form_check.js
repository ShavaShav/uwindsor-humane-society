function validateRegister(){
	var x = document.forms["register"]["reg_user_name"].value;
	var y = document.forms["register"]["reg_user_password_new"].value;
	var z = document.forms["register"]["reg_user_password_repeat"].value;
	
	if (y != z){
		alert("Passwords must match.");
		return false;
	}
	
	window.alert("Registration Successful! You can now log in :)")
	return true;
}
