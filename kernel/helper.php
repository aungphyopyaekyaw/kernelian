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

	function is_auth() {
		if(isset($_SESSION['is_auth']) && $_SESSION['is_auth'] === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function abort($code) {
		http_response_code($code);
		echo View::make($code);
    	exit();
	}

	function str_slug($text) {
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text); // replace non letter or digits by -
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text); // transliterate
	  $text = preg_replace('~[^-\w]+~', '', $text); // remove unwanted characters
	  $text = trim($text, '-'); // trim
	  $text = preg_replace('~-+~', '-', $text); // remove duplicate -
	  $text = strtolower($text); // lowercase

	  if (empty($text)) {
	    return 'n-a';
	  }

	  return $text;
	}