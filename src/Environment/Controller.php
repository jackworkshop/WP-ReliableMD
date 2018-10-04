<?php

namespace WPReliableMD\Environment;

class Controller {

	public function __construct() {
		add_action( 'init', array($this,'register_script' ));
		add_action( 'init', array($this,'register_style' ));
	}

	public function register_script() {
		//定义脚本本地化数据
		$ReliableMDSetting = array(
			'api_root' => esc_url_raw( rest_url() ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
			'js_root' => WPReliableMD_URL.'/js/',
			'js_dep_lib_root' => WPReliableMD_URL.'/bower_components/'
		);

		wp_deregister_script('jquery'); //取消系统原有的jquery定义
//		wp_register_script('jquery', WPReliableMD_URL.'/bower_components/jquery/dist/jquery.js', false, WPReliableMD_VER, false);
//		wp_enqueue_script('jquery');
		wp_register_script('require', WPReliableMD_URL.'/js/require.js', array('jquery'), WPReliableMD_VER, false);
		wp_register_script('require-paths', WPReliableMD_URL.'/js/require_paths.js', array('require'), WPReliableMD_VER, false);
		if(is_admin())
		{
			wp_register_script( 'ReliableMD', WPReliableMD_URL . '/js/WPReliableMD_Admin.js', array('require-paths'), WPReliableMD_VER, false );

			wp_localize_script( 'ReliableMD', 'ReliableMD', $ReliableMDSetting);
			wp_localize_script( 'require-paths', 'ReliableMD', $ReliableMDSetting);

		} else {
			wp_register_script( 'WPReliableMD_render', WPReliableMD_URL . '/js/WPReliableMD_render.js', array('require-paths'), WPReliableMD_VER, false );

			wp_localize_script( 'WPReliableMD_render', 'ReliableMD', $ReliableMDSetting);

			wp_localize_script( 'require-paths', 'ReliableMD', $ReliableMDSetting);
		}

	}

	public function register_style() {
		wp_register_style('normalize', '//necolas.github.io/normalize.css/8.0.0/normalize.css', array(), WPReliableMD_VER, false);
		wp_register_style('codemirror', WPReliableMD_URL.'/bower_components/codemirror/lib/codemirror.css', array('normalize'), WPReliableMD_VER, false);
		wp_register_style('github', WPReliableMD_URL.'/bower_components/highlightjs/styles/github.css', array('codemirror'), WPReliableMD_VER, false);
		wp_register_style('tui-editor', WPReliableMD_URL.'/bower_components/tui-editor/dist/tui-editor.css', array('github'), WPReliableMD_VER, false);
		wp_register_style('tui-editor-contents', WPReliableMD_URL.'/bower_components/tui-editor/dist/tui-editor-contents.css', array('tui-editor'), WPReliableMD_VER, false);
		wp_register_style('tui-color-picker', WPReliableMD_URL.'/bower_components/tui-color-picker/dist/tui-color-picker.css', array('tui-editor-contents'), WPReliableMD_VER, false);
		wp_register_style('tui-chart', WPReliableMD_URL.'/bower_components/tui-chart/dist/tui-chart.css', array('tui-color-picker'), WPReliableMD_VER, false);
		wp_register_style( 'katex', WPReliableMD_URL . '/bower_components/katex/dist/katex.css', array('tui-editor'), WPReliableMD_VER, false );
		if(is_admin()) {
			wp_register_style( 'ReliableMD', WPReliableMD_URL . '/css/WPReliableMD_Admin.css', array('katex'), WPReliableMD_VER, false );
		}
	}
}

?>
