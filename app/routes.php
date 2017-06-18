<?php
/* need to add Controllers */
include controller_dir . "HomeController.php";
include controller_dir . "BlogController.php";

/* add include files after adding routes */
return array(
			'/' 	=> array('controller' => 'HomeController@func'),

			#below is the example for param passing
			'blog'	=> array('controller' => 'BlogController@index'),
);
