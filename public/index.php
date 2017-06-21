<?php

define("DD", "..");
define("controller_dir", "../app/controller/");

require_once DD . "/kernel/lib/yaml/sfYamlParser.php";
require_once DD . "/kernel/lib/Helper.php";

$yaml_parser = new sfYamlParser;
$route = $yaml_parser->parse(file_get_contents(DD . '/app/routes.yaml'));

Route::get($route);

function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

echo '<br>'.convert(memory_get_usage(true));
