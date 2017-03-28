<?php

/*
 * This file uses: myfile.xml and eg.xsl.
 * It sets the showChapter parameter to whatever is assigned to 'id'.
 */

header('Content-Type: text/html');

$xmlFile = new DOMDocument();
$xmlFile->load('/home/preney/public_html/examples/xml-eg1/myfile.xml');
//echo $xmlFile->saveXML();

$xslFile = new DOMDocument();
$xslFile->load('/home/preney/public_html/examples/xml-eg1/eg.xsl');

$proc = new XSLTProcessor();
$proc->importStylesheet($xslFile);
echo $proc->transformToXML($xmlFile);

?>
