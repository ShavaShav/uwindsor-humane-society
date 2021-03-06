<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');
require_once(dirname(__FILE__) . '/../lib/login-tools.php');
require_once(dirname(__FILE__) . '/../lib/form_fill.php');
session_start();

function html5_header($title, $css_files = array(), $js_files = array())
{
    
    echo "<!DOCTYPE html>\n".
        "<html><head><title>".
        htmlspecialchars($title).
        "</title>".
        "<meta charset='utf-8'>".
        "<!-- Latest compiled and minified JQuery --><script
			  src='https://code.jquery.com/jquery-3.2.1.min.js'
			  integrity='sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4='
			  crossorigin='anonymous''></script><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>

        <!-- Latest compiled and minified Bootstrap JS -->
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' integrity='sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa' crossorigin='anonymous'></script>";
  
    foreach ($css_files as $css_file)
        echo "<link rel='stylesheet' type='text/css' href='$css_file' />";
  
    foreach ($js_files as $js_file)
        echo "<script src='$js_file' type='application/javascript'></script>";
    
	
    echo "</head><body>\n";
}

function html5_footer()
{
	echo "</body></html>";
}

function html5_nav()
{

global $TEMPLATES_PATH;

$log_name = session_field('user_name');
$reg_name = session_field('reg_user_name');
$email = session_field('email');
// can be NO whitespace after <<<ZZEOF
echo <<<ZZEOF
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
		data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="index.php"><img class="navbar-brand" src="
ZZEOF;
print($TEMPLATES_PATH . '/img.php?type=content&filename=small_logo.png');
echo <<<ZZEOF
"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home <span class="sr-only">Home</span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
			aria-haspopup="true" aria-expanded="false">Contact Us <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="cruelty.php">Report cruelty</a></li>
            <li><a href="contactus.php">Email us</a></li>
          </ul>
        </li>	
        <li><a href="adopt.php">Adopt Animals</a></li>
        <li><a href="surrender.php">Surrender Animals</a></li>
ZZEOF;
if(isset($_SESSION['admin'])){
	echo '<li><a href="pending_requests.php">Pending Requests</a></li>';
}
echo '</ul>';

if (is_logged_in()){
echo '<ul class="nav navbar-nav navbar-right"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Logged As: ';	
echo $_SESSION['logged_in_user'];
echo '</b> <span class="caret"></span></a><ul id="login-dp" class="dropdown-menu">';
echo <<<ZZEOF
<li><form id="logoutbutton" method="post" action="message_page.php">
    <input type="hidden" name="logout"></form></li>
<li><a onclick="document.getElementById('logoutbutton').submit()">Logout</a></li>
<li> <a href="user_details.php">User Details</a></li>
</ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
ZZEOF;
} else {
	echo <<<ZZEOF
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div>
							<div>
								 <form class="form" role="form" method="post" name="login" action="login_confirmation.php" accept-charset="UTF-8" id="login-nav">
										<div class="form-group">
											 <label>Username</label>
											 <input id="user_name" name="user_name" value="{$log_name}" required>
										</div>
										<div class="form-group">
											 <label>Password</label>
											 <input type="password" id="user_password_new" name="user_password_new" required>
										</div>
										<div>
											 <button type="submit">Sign in</button>
										</div>
								 </form>
							</div>
					 </div>
				</li>
			</ul>
        </li>
		
		 <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Register</b> <span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div>
							<div>
								 <form class="form" role="form" method="post" name="register" action="registration_confirmation.php" accept-charset="UTF-8" id="login-nav">
										<div class="form-group">
											 <label>Username (2-64 chars)</label>
											 <input id="user_name"  pattern=".{2,}" name="reg_user_name" value="{$reg_name}" required />
										</div>
										<div class="form-group">
											<label>Email (name@domain.x)</label>
											<input id="login_input_email" name="email" value="{$email}" required  /><br>
										</div>
										<div class="form-group">
											<label>Password (>6 chars)</label>
											<input id="login_input_password_new" type="password" name="reg_user_password_new" pattern=".{6,}" required autocomplete="off" /><br>
										</div>
										<div class="form-group">
										<label>Repeat Password</label>
											<input id="login_input_password_repeat" type="password" name="reg_user_password_repeat" pattern=".{6,}" required autocomplete="off" /><br>
										</div>
										<div>
											 <button type="submit">Register</button>
										</div>
								 </form>
							</div>
					 </div>
				</li>
			</ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
ZZEOF;
}
}

?>