<?php

class HomeController {
	public function func() {
		#if you want to use twig use View::start method
		$blog = [
			array('id' => '1', 'title' => 'Example title 1'),
			array('id' => '2', 'title' => 'Example title 2')
		];
		return View::start("index", compact('blog'));

		#otherwise
		// return View::make("index");
	}
}
