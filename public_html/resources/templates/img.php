<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../config.php');

if (isset($_GET['type']) && isset($_GET['filename'])) {
    $type = $_GET['type'];
    $img = $_GET['filename'];
    $path = $IMG_PATH . '/'. $type . '/' . $img;
    if (file_exists($path)) {
        header('Content-type: ' . mime_content_type($path));   // parse the mime type   
        readfile($path);
        exit();
    }
}

// return the default image on 404, a silouette of a cat
header('Content-type: image/jpeg');
readfile($IMG_PATH . '/content/default.jpg');

?>