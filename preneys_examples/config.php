<?php

// Create an empty class for configuration data...
$CFG = new stdClass();

// Global configuration variables...
$CFG->base_url = 'http://humanesociety.shaverz.myweb.uwindsor.ca';

// Site salt (for additional password security)...
$CFG->site_wide_password_salt = '238ydfshurt4r89dsjier3__=424!&*#';

// db_admin_prohibit_create_drop:
//   IMPORTANT: By default this setting should be TRUE!
//   Functions that are capable of creating and destroying database
//   tables in this site's code will check this setting to see if
//   it has been set to FALSE. If it has not been set to FALSE, then
//   the function will fail to execute as a safety precaution.
$CFG->db_admin_prohibit_create_drop = FALSE;

// Database connectivity information...
// db_dsn:
//   This must be set to the PHP PDO DSN to your database.
// db_user:
//   This must be set to the database connection's user name.
// db_pass:
//   This must be set to the database connection user's password.
$CFG->db_dsn = 'mysql:host=localhost;dbname=shaver_hs';
$CFG->db_user='shaver_hs';
$CFG->db_pass='ejr6GdqWK';

?>
