<?php

function example_cleanup($filename,$readfileResult)
{
  if ($readfileResult === FALSE)
  {
    // Perhaps an error occurred sending the file,
    // so do something (e.g., log it to the DB, email the admin, etc.).
  }
}

// Very simple example to send this file (which you'd never do in
// a real web site).
HTTPUtils::sendFile(
  basename(__FILE__), /* This file's local name */
  'dload_example_file_name.dsadasdas', // What client sees as file name
  'application/octet-stream', // Ensure Save As... style download
  'PHP Code', // Description
  'example_cleanup'     // optional
);

?>
