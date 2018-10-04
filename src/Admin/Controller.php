<?php

namespace WPReliableMD\Admin;

class Controller {

	public function __construct() {

		//Javascript 文件
		add_filter('admin_head',array($this,'enqueue_scripts'),2);
		//CSS 文件
		add_filter('admin_head',array($this,'enqueue_style'),2);

		add_filter( 'admin_body_class', array($this,'WPReliableMD_admin_body_class'));
	}
	public function enqueue_scripts() {
		wp_enqueue_script('require');
		wp_enqueue_script('require-paths');
		wp_enqueue_script( 'ReliableMD');
	}

	public function enqueue_style() {
		wp_enqueue_style('normalize');
		wp_enqueue_style('codemirror');
		wp_enqueue_style('github');
		wp_enqueue_style('tui-editor');
		wp_enqueue_style('tui-editor-contents');
		wp_enqueue_style('tui-color-picker');
		wp_enqueue_style('tui-chart');
		wp_enqueue_style( 'katex');
		wp_enqueue_style( 'ReliableMD');
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
