<?php
session_start();
define("DD", "..");
define("controller_dir", "../app/controller/");
require_once DD."/kernel/lib/yaml/sfYaml.php";
require_once DD."/kernel/lib/Main.php";

Route::make(sfYaml::load(DD.'/app/routes.yaml'));

function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

echo '<br>'.convert(memory_get_usage(true));
