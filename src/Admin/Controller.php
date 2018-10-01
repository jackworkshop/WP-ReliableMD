<?php

namespace WPReliableMD\Admin;

class Controller {
	public function __construct() {

		//Javascript 文件
		add_action('admin_enqueue_scripts',array($this,'enqueue_scripts'));
		//CSS 文件
		add_action('admin_enqueue_scripts',array($this,'enqueue_style'));
		add_filter( 'admin_body_class', array($this,'WPReliableMD_admin_body_class'));
	}

	public function enqueue_scripts() {
		//Requirejs库
		wp_enqueue_script('Require', '//cdn.jsdelivr.net/npm/requirejs/require.min.js', array(), WPReliableMD_VER, true);
		wp_enqueue_script('Bootstrap', '//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), WPReliableMD_VER, true);
		wp_enqueue_script( 'ReliableMD', WPReliableMD_URL . '/js/WPReliableMD_Admin.js', array(), WPReliableMD_VER, true );
	}

	public function enqueue_style() {
		//Requirejs库
		wp_enqueue_style('normalize', '//necolas.github.io/normalize.css/8.0.0/normalize.css', array(), WPReliableMD_VER, true);
		wp_enqueue_style('Bootstrap', '//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), WPReliableMD_VER, true);
		wp_enqueue_style( 'ReliableMD', WPReliableMD_URL . '/css/WPReliableMD_Admin.css', array(), WPReliableMD_VER, true );
	}

	public function WPReliableMD_admin_body_class() {
		if ( current_theme_supports( 'editor-styles' ) && current_theme_supports( 'dark-editor-style' ) ) {
		 	return "$classes reliablemd-editor-page is-fullscreen-mode is-dark-theme";
		} else {
			// Default to is-fullscreen-mode to avoid jumps in the UI.
			return "$classes reliablemd-editor-page is-fullscreen-mode";
		}
	}
}

?>