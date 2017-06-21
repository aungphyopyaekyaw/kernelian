<?php

class BlogController {

	public function index() {

		if(isset($id)) {
			 $blog = DB::table("blog")->select('id', 'title')->where('id', '=', $id)->get();
		} else {
			$blog = DB::table("blog")->select('id', 'title')->get();
		}

		$test = [
			array('id' => '1', 'title' => 'Example title 1'),
			array('id' => '2', 'title' => 'Example title 2')
		];
		return View::start("blog", compact('blog', 'test'));
	}

	public function func() {
			echo "Blog controller";
	}

	public function create() {
		var_dump($_POST['firstname']);
		return View::start('form');
	}
}
