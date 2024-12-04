#!/opt/homebrew/bin/php
<?php
require('XMLParser.php');

if (isset($argc) && $argc < 2) {
    print_r('This program needs the path to a file to work !');
}

$filename = $argv[1];
$parserXml = new \Damien\Combodo\XMLParser($filename);
$parserXml->parseItems();