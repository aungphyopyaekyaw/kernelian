<?php
require DD . "/kernel/provider/DBProvider.php";
require DD . "/kernel/provider/ViewProvider.php";

class Route {
	
	private static $_instance;

	public static function gethelp() {
		$request_uri = $_SERVER['REQUEST_URI'];
		$script_name = $_SERVER['SCRIPT_NAME'];
		$e_request_uri = explode("/", $request_uri);
		$e_script_name = explode("/", $script_name);
		$request_uri = array_diff($e_request_uri, $e_script_name);
		$o_request_uri = array_values($request_uri);
		return $o_request_uri;
	}

	public static function get_func($controller) {
		$request_uri = self::gethelp();
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
		$request_uri = self::gethelp();

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
						exit();
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
			exit();
		}
	}
}

class Validate {
	private static $result = TRUE;

	public static function input($value) {
		foreach($value as $ikey => $ival) {
			if(empty($ikey)) {
				return 'Input cannot be empty';
			}
			if(strpos($ival, ':') !== FALSE) {
				$ival = explode(':', $ival);
				call_user_func('self::'.$ival[0], $ikey, $ival[1]);
			} else {
				call_user_func('self::'.$ival, $ikey);
			}
		}
		if(self::$result == 1) {
			return NULL;
		}
		return self::$result;
	}

	static public function is_difficult($ikey) {
		if(self::$result === TRUE) {
			self::$result = (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', $ikey)) ? TRUE : 'Not strong enough';
		}
		return __CLASS__;
	}

	static public function is_email($ikey) {
		if(self::$result === TRUE) {
			self::$result = (filter_var($ikey, FILTER_VALIDATE_EMAIL)) ? TRUE : 'It is not Email';
		}
		return __CLASS__;
	}

	static public function is_has($ikey, $value) {
		if(self::$result === TRUE) {
			$val = explode('|', $value);
			$var = 0;
			foreach ($val as $v) {
				if($v == 'number') {
					$var += (preg_match('/^(?=.*\d).+$/', $ikey) ? 1 : $message = $v );
				}
				if ($v == 'alphabet') {
					$var += (preg_match('/[a-zA-Z]/', $ikey) ? 1 : $message = $v );
				}
				if($v == 'special') {
					$var += (preg_match('/^(?=.*(_|[^\w])).+$/', $ikey) ? 1 : $message = $v );
				}
			}
			self::$result = (count($val) == $var) ? TRUE : 'It does not have ' . $message;
		}
		return __CLASS__;
	}

}
