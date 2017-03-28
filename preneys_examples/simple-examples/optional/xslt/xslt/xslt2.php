<?php

/*
 * This file uses: myfile.xml and eg2.xsl.
 * It sets the showChapter parameter to whatever is assigned to 'id'.
 */

header('Content-Type: text/html');

$xmlFile = new DOMDocument();
$xmlFile->load('/home/preney/public_html/examples/xml-eg1/myfile.xml');

$xslFile = new DOMDocument();
$xslFile->load('/home/preney/public_html/examples/xml-eg1/eg2.xsl');

$proc = new XSLTProcessor();
$showChapterID = !isset($_GET['id']) ? 1 : $_GET['id'];
$proc->setParameter('', 'showChapter', $showChapterID);
$proc->importStylesheet($xslFile);
echo $proc->transformToXML($xmlFile);

?>
