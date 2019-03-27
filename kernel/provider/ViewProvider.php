<?php
class View {

	public static function start($view, &$data = null) {
		$config = Config::get('app');
		$app = array('app' => $config);
		require_once "../kernel/lib/Twig/Autoloader.php";
		Twig_Autoloader::register(true);
		$loader = new Twig_Loader_Filesystem("../app/view/");
		$twig = new Twig_Environment($loader, array('cache' => "../tmp/cache"));
		if(isset($data)){
			$app = array_merge($data, $app);
			$template = $twig->loadTemplate($view.".twig");
			echo $template->render($app);
		} else {
			echo $twig->render($view.".twig", $app);
		}
	}

	public static function make($view, $data = null) {
		$file =  "../app/view/" . $view . ".php";
		if(file_exists($file)) {
			ob_start();
			if($data != null) {
			extract($data); // to change array_key to variable
			}
			include $file;
			return ob_get_clean();
			} else {
			$f404 = "../app/view/404.php";
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
