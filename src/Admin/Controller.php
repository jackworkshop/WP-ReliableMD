<?php

namespace WPReliableMD\Admin;

class Controller {
	public function __construct() {
		//Javascript 文件
		add_action('edit_page_form',array($this,'enqueue_scripts'));
		add_action('edit_form_advanced',array($this,'enqueue_scripts'));
		//CSS 文件
		add_action('edit_page_form',array($this,'enqueue_style'));
		add_action('edit_form_advanced',array($this,'enqueue_style'));
	}

	public function enqueue_scripts() {
		//Requirejs库
		wp_enqueue_script('Require', '//cdn.jsdelivr.net/npm/requirejs/require.min.js', array(), WPReliableMD_VER, true);
		wp_enqueue_script('Bootstrap', '//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), WPReliableMD_VER, true);
		wp_enqueue_script( 'ReliableMD', WPReliableMD_URL . '/js/WPReliableMD.js', array(), WPReliableMD_VER, true );
	}

	public function enqueue_style() {
		//Requirejs库
		wp_enqueue_style('normalize', '//necolas.github.io/normalize.css/8.0.0/normalize.css', array(), WPReliableMD_VER, true);
		wp_enqueue_style('Bootstrap', '//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), WPReliableMD_VER, true);
		wp_enqueue_style( 'ReliableMD', WPReliableMD_URL . '/css/WPReliableMD.css', array(), WPReliableMD_VER, true );
	}
}

?>