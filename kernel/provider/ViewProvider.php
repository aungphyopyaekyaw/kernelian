<?php
class View {

	public static function getconf() {
			$appconf = new App;
			return $appconf->appconf();
	}

	public static function start($view, &$data = null) {
		$config = self::getconf();
		$app = array('app' => $config);
		require_once DD . "/kernel/lib/Twig/Autoloader.php";
		Twig_Autoloader::register(true);
		$loader = new Twig_Loader_Filesystem(DD . "/app/view/");
		$twig = new Twig_Environment($loader, array('cache' => DD . "/tmp/cache"));
		if(isset($data)){
			$app = array_merge($data, $app);
			$template = $twig->loadTemplate($view.".twig");
			echo $template->render($app);
		} else {
			echo $twig->render($view.".twig", $app);
		}
	}

	public static function make($view, $data = null) {
		$file =  DD . "/app/view/" . $view . ".php";
		if(file_exists($file)) {
			ob_start();
			if($data != null) {
			extract($data); // to change array_key to variable
			}
			include $file;
			return ob_get_clean();
			} else {
			$f404 = DD . "/app/view/404.php";
			ob_start();
			if($data != null) {
			extract($data); // to change array_key to variable
			}
			include $f404;
			return ob_get_clean();
		}
	}

}

?>
