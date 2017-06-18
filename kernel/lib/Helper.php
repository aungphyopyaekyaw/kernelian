<?php
require DD . "/kernel/provider/InfoProvider.php";
require DD . "/kernel/provider/DBProvider.php";
require DD . "/kernel/provider/ViewProvider.php";

class Helper {
	public static function is_uriWithPareamenters($uri) {
		if(count($uri)) {
			return count($uri);
		} else {
			return 1;
		}
	}

	public static function is_routeWithParameters($routes, $controller) {
		$real_route = $routes[$controller];
		$params = isset($real_route['params']) ? $real_route['params'] : '';
		// $params = $real_route['params'];
		$e_params = explode(",", $params);
		return count($e_params);
	}
}
