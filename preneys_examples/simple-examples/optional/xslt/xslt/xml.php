<?php

header('Content-Type: text/xml');

$xmlFile = new DOMDocument();
$xmlFile->load('/home/preney/public_html/examples/xml-eg1/myfile.xml');
echo $xmlFile->saveXML();

?>
