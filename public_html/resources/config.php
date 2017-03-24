<?php 
// An array of globals variables (other arrays that contain constants), just require config.php and use them
// If we use these variables, then we only have to keep them up to date here

$TEMPLATES_PATH = dirname(__FILE__).'/templates';
$LIB_PATH = dirname(__FILE__).'/lib';

// might need to change this once deployed?
$URLS = array(
    "base" => '../public_html'
);

// common paths
$PATHS = array(
    "resources" => $URLS["base"]."/resources",
    "images" => array(
        "animals" => $URLS["base"]."/img/animals",
        "content" => $URLS["base"]."/img/content",
        "layout" => $URLS["base"]."/img/layout"
    )
);

// database credentials (to be updated)
$DB = array(
    "dbname" => "shaverz_hs",
    "username" => "shaverz_hs",
    "password" => "ejr6GdqWK",
    "host" => "localhost"
);
 
// report errors on the page, should make debugging easier
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>