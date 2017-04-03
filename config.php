<?php 
// An bunch of globals variables (and arrays)

$TEMPLATES_PATH = 'resources/templates';
$LIB_PATH = 'resources/lib';
$IMG_PATH = 'img';

// database credentials
$DB = array(
    "dbname" => "shaverz_hs",
    "username" => "shaverz_hs",
    "password" => "ejr6GdqWK",
    "host" => "localhost",
    "site_wide_password_salt" => '238ydfshurt4r89dsjier3__=424!&*#'
);

// List of admin usernames
$ADMIN = array(
    "shaverz",
    "GIJoe"
);

// report errors on the page, should make debugging easier
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRICT);

?>