<?php

class BlogController {

	public function index() {

		if(isset($id)) {
			 $blog = DB::table("blog")->select('id', 'title')->where('id', '=', $id)->get();
		} else {
			$blog = DB::table("blog")->select('id', 'title')->get();
		}

		return View::start("blog", compact('blog'));
	}

	public function func() {
			echo "Blog controller";
	}
}
