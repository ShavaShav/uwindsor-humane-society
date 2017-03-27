<?php]
if (isset($user)) {
    if ($user->errors) {
        foreach ($user->errors as $error) {
            echo $error;
        }
    }
    if ($user->messages) {
        foreach ($user->messages as $message) {
            echo $message;
        }
    }
}
?>


<form method="post" action="login.php" name="loginform">

    <label for="login_input_username">Username</label>
    <input id="login_input_username" class="login_input" type="text" name="user_name" required />

    <label for="login_input_password">Password</label>
    <input id="login_input_password" class="login_input" type="password" name="user_password" autocomplete="off" required />

    <input type="submit"  name="login" value="Log in" />

</form>
<p>Not a member? <a href="register.php">Sign Up!</a></p>
