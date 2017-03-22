<?php
require_once("/../config.php");
//session_start();
require_once(LIBRARY_PATH . '/login-tools.php');

function html5_header($title, $css_files = array(), $js_files = array())
{
    echo "<!DOCTYPE html>\n".
        "<html><head><title>".
        htmlspecialchars($title).
        "</title>";
  
    foreach ($css_files as $css_file)
        echo "<link rel='stylesheet' type='text/css' href='$css_file' />";
  
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

function html5_footer()
{
	echo "</body></html>";
}

function html5_nav()
{
// can be NO whitespace after <<<ZZEOF
echo <<<ZZEOF
    "<nav>
        <div id="logo">
            <p>Logo</p>
        </div>
        <ul class="page-nav">
            <li><a href="/">Home</a></li>
            <li><a href="/About.html">Animals</a></li>
            <li><a href="/AdoptAnimals.php">Adopt Animals</a></li>
            <li><a href="/SurrenderAnimals.php">Surrender Animals</a></li>
            <li><a href="/Cruelty.php">Report Cruelty</a></li>
            <li class="nav-right"><a href="/sign_in.php">Sign In</a></li>
        </ul>
    </nav>"
ZZEOF;
// Also, ZZEOF; can't be indented, and no white space can follow it either
}


// Do we use these functions?

function html5_index($title, $css=array(), $js=array(), $content="")
{
	html5_header($title, $css, $js);
}

function html5_navigation($title, $css=array(), $js=array(), $content="")	
{
  html5_header($title, $css, $js);
  html5_nav();
  html5_loginstatus($content);
}

?>
