<?php
require DD . "/kernel/provider/InfoProvider.php";
require DD . "/kernel/provider/DBProvider.php";
require DD . "/kernel/provider/ViewProvider.php";

class Helper {
	public static function gethelp() {
		$request_uri = $_SERVER['REQUEST_URI'];
		$script_name = $_SERVER['SCRIPT_NAME'];
		$e_request_uri = explode("/", $request_uri);
		$e_script_name = explode("/", $script_name);
		$request_uri = array_diff($e_request_uri, $e_script_name);
		$o_request_uri = array_values($request_uri);
		return $o_request_uri;
	}
}

class Route {

	public static function get($route) {
		self::make($route);
	}

	public static function get_func($controller) {
		$request_uri = Helper::gethelp();
		if(empty($request_uri)) {
			$request_uri = array('/');
		}

		$getfunc = explode('@', $controller);
		include controller_dir . $getfunc[0] .'.php';
		return call_user_func_array(array(new $getfunc[0], $getfunc[1]), $request_uri);
	}

	public static function make($route) {
		$check_route = $route;
		$route = array_keys($route);
		$request_uri = Helper::gethelp();

		if(empty($request_uri)) {
			$request_uri = array('/');
		}

		$result = array_intersect($route, $request_uri);
		$str_result = current($result);
		if($result) {
			if(isset($check_route[$str_result])) {
				$fixed_controller = $check_route[$str_result];
			}
			if(is_array($fixed_controller)) {
				$route = array_keys($fixed_controller);
				$s_route = array_intersect($request_uri, $route);
				if($s_route) {
					$str_route = current($s_route);
					self::get_func($fixed_controller[$str_route]);
				} else {
					if(array_key_exists(1, $request_uri)) {
						echo View::make('404');
					}
					else {
						self::get_func($fixed_controller['/']);
					}
				}
			} else {
				self::get_func($fixed_controller);
			}
		}
		else {
			echo View::make('404');
		}
	}
}
