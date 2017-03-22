<?php
require_once('config.php');
session_start();
require_once('login-tools.php');


function html5_prolog($title, $css_files = array(), $js_files = array())
{
  echo "<!DOCTYPE html>\n".
    "<html><head><title>".
    htmlspecialchars($title).
    "</title>"
  ;
  
  foreach ($css_files as $css_file)
    echo "<link rel='stylesheet' type='text/css' href='css/$css_file' />";
  
  foreach ($js_files as $js_file)
    echo "<script src='$js_file' type='application/javascript'></script>";

  echo "<meta charset='utf-8'>";

  echo "</head><body>\n";
}

function html5_loginstatus($content)
{
  echo '<div id="content">';
  echo $content;
  echo '</div>';
  
}

function html5_epilog()
{
	echo "</body></html>";
}

function html5_nav()
{
echo "<nav>".
			"<div id='logo'>".
				"<p>Logo</p>".
			"</div>".
			"<ul class='page-nav'>".
				"<li><a href='index.php'>Home</a></li>".
				"<li><a href='contactus.php'>Contact Us</a></li>".
				"<li><a href='adopt.php'>Adopt Animals</a></li>".
				"<li><a href='surrender.php'>Surrender Animals</a></li>".
				"<li><a href='cruelty.php'>Report Cruelty</a></li>".
				"<li class='nav-right'><a href='login.php'>Sign In</a></li>".
			"</ul>".
		"</nav>";	
}


function html5_index($title, $css=array(), $js=array(), $content="")
{
  html5_prolog($title, $css, $js);
}

function html5_navigation($title, $css=array(), $js=array(), $content="")
{
  html5_prolog($title, $css, $js);
  html5_nav();
  html5_loginstatus($content);
}

?>
