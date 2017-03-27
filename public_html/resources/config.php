<?php 
// An array of globals variables (other arrays that contain constants), just require config.php and use them
// If we use these variables, then we only have to keep them up to date here

$TEMPLATES_PATH = 'resources/templates';
$LIB_PATH = 'resources/lib';
$IMG_PATH = 'img';

// database credentials (to be updated)
$DB = array(
    "dbname" => "shaverz_hs",
    "username" => "shaverz_hs",
    "password" => "ejr6GdqWK",
    "host" => "localhost"
);

define("DB_HOST", "localhost");
define("DB_NAME", "laureau_ryan");
define("DB_USER", "laureau_login");
define("DB_PASS", "Qwerty123");
 
// report errors on the page, should make debugging easier
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>