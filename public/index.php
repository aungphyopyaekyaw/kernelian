<?php
define("DD", "..");
define("controller_dir", "../app/controller/");

include DD . "/kernel/lib/Helper.php";

$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];

//make array and remove slash
$e_request_uri = explode("/", $request_uri);
$e_script_name = explode("/", $script_name);

$request_uri = array_diff($e_request_uri, $e_script_name);
$o_request_uri = array_values($request_uri);

if(empty($o_request_uri)) {
	$route = "/";
} else {
	$route = $o_request_uri[0];
}

$routes = include DD . "/app/routes.php";

if (array_key_exists($route, $routes)) {
	array_shift($o_request_uri);
	if(Helper::is_routeWithParameters($routes, $route) == Helper::is_uriWithPareamenters($o_request_uri)) {
		$e_routes = explode("@", $routes[$route]['controller']);
		call_user_func_array(array(new $e_routes[0], $e_routes[1]), $o_request_uri);
	}	else {
		echo View::make("404");
	}
} else {
	echo View::make("404");
}
