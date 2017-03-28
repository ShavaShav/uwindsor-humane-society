<?php
require_once('lib/common.php');

html5_page(
  'Page < Title',
  array('a.css', 'b.css'),
  array('a.js', 'b.js'),
  "is logged in: ".is_logged_in()
);

?>
