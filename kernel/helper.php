<?php

	function _arrayResolver($key, $default_array) {
		foreach ($key as $k => $value) {
		$default_array = $default_array[$value];
		}
		return $default_array;
	}

	function redirect($path) {
		header('Location: ' . Config::get('app.baseurl') . $path);
		exit();
	}
