<?php
require "../kernel/helper.php";

class Config {
	public static function get($value) {
		$e_value = explode('.', $value);
		$config_file = "../app/config/" . $e_value[0] . ".yaml";
		if(file_exists($config_file)) {
			$config = sfYaml::load($config_file);
			$slice_value = array_slice($e_value, 1);
			return _arrayResolver($slice_value, $config);
		} else {
			echo "Configuration file was not found";
		}
	}
}
