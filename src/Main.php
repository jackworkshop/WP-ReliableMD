<?php

namespace WPReliableMD;

use WPReliableMD\Admin\Controller as AdminController;
use WPReliableMD\View\Controller as ViewController;
use WPReliableMD\REST\Controller as RestController;
use WPReliableMD\Environment\Controller as EnvironmentController;

class Main {

	private $env;

	private $rest;

	private $view;

	private $admin;

	public function __construct() {

		$this->env = new EnvironmentController(); //初始化插件环境控制器

		$this->rest = new RestController();  //初始化REST控制器

		$this->view = new ViewController(); //初始化前端渲染控制器

		$this->admin = new AdminController();

	}


}

?>
