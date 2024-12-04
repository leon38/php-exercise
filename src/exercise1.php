#!/opt/homebrew/bin/php
<?php
namespace Damien\Combodo;

if ($argc < 2) {
    print_r('This program needs the path to a file to work !');
}

$filename = $argv[1];
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
$doc = new \DOMDocument();
$doc->loadXML($contents);

$xpath = new \DOMXpath($doc);
/**
 * @var array<object{id:string, nodeName:string}> $items
 */
$items = $xpath->query("//class[@id]");
$classes = [];
foreach($items as $item) {
    $classes[$item->id] = true;
}
print_r(count($classes));
?>