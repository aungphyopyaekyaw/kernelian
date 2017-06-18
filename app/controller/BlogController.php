<?php

class BlogController {

	public function index($google = null) {

		if(isset($google)) {
			 $blog = DB::table("blog")->select('id', 'title')->where('title', '=', 'This is an example of standard post format')->get();
		} else {
			$blog = DB::table("blog")->select('id', 'title')->get();
		}

		return View::start("blog", compact('blog'));
	}
}
