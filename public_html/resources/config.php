<?php 
// An array of globals variables (other arrays that contain constants), just require config.php and use them
// If we use these variables, then we only have to keep them up to date here

// might need to change this once deployed?
$URLS = array(
    "base" =>$_SERVER["DOCUMENT_ROOT"]."/2017w-60334-project-group-aa"
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

// These constants can be used to easily locate library and template php files
defined("LIBRARY_PATH")
    or define("LIBRARY_PATH", $URLS["base"].$PATHS["resources"].'/lib');
     
defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", $URLS["base"].$PATHS["resources"].'/templates');
 
// report errors on the page, should make debugging easier
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>