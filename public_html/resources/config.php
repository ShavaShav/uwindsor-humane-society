<?php 
// An array of globals variables (other arrays that contain constants), just require config.php and use them
// If we use these variables, then we only have to keep them up to date here

$TEMPLATES_PATH = dirname(__FILE__).'/templates';
$LIB_PATH = dirname(__FILE__).'/lib';

// might need to change this once deployed?
$URLS = array(
    "base" =>'/'
);

// common paths
$PATHS = array(
    "resources" => "/resources",
    "images" => array(
        "animals" => "/images/animals",
        "content" => "/images/content",
        "layout" => "/images/layout"
    )
);

// database credentials (to be updated)
$DB = array(
    "db1" => array(
        "dbname" => "database1",
        "username" => "dbUser",
        "password" => "pa$$",
        "host" => "localhost"
    ),
    "db2" => array(
        "dbname" => "database2",
        "username" => "dbUser",
        "password" => "pa$$",
        "host" => "localhost"
    )
);
 
// report errors on the page, should make debugging easier
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>