<?php

namespace WPReliableMD;

use WPReliableMD\Admin\Controller as AdminController;
use WPReliableMD\View\Controller as ViewController;
use WPReliableMD\REST\Controller as RestController;
use WPReliableMD\Environment\Controller as EnvironmentController;

class Main {

	public function __construct() {

		new EnvironmentController(); //初始化插件环境控制器

		new RestController();  //初始化REST控制器

		new ViewController(); //初始化前端渲染控制器

		new AdminController(); //初始化后台控制器

	}


}

?>
