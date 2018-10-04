<?php

namespace WPReliableMD\View;

class Controller {

	public function __construct() {

		//Javascript 文件
		add_filter('wp_head',array($this,'enqueue_scripts'),2);
		//CSS
		add_filter('wp_head',array($this,'enqueue_style'),2);

		add_filter('the_content',array($this,'WPReliableMD_the_Content'));
	}
	public function enqueue_scripts() {
		wp_deregister_script('jquery'); //取消系统原有的jquery定义
		wp_enqueue_script('jquery-tui-editor', WPReliableMD_URL.'/bower_components/jquery/dist/jquery.js', false, WPReliableMD_VER, false);
		//wp_enqueue_script('require', WPReliableMD_URL.'/js/require.js', array('jquery-tui-editor'), WPReliableMD_VER, false);
//		wp_enqueue_script('markdown-it', WPReliableMD_URL.'/bower_components/markdown-it/dist/markdown-it.js', array('jquery-tui-editor'), WPReliableMD_VER, false);
//		wp_enqueue_script('to-mark', WPReliableMD_URL.'/bower_components/to-mark/dist/to-mark.js', array('markdown-it'), WPReliableMD_VER, false);
//		wp_enqueue_script('tui-code-snippet', WPReliableMD_URL.'/bower_components/tui-code-snippet/dist/tui-code-snippet.js', array('to-mark'), WPReliableMD_VER, false);
//		wp_enqueue_script('tui-color-picker', WPReliableMD_URL.'/bower_components/tui-color-picker/dist/tui-color-picker.js', array('tui-code-snippet'), WPReliableMD_VER, false);
//		wp_enqueue_script('codemirror', WPReliableMD_URL.'/bower_components/codemirror/lib/codemirror.js', array('tui-color-picker'), WPReliableMD_VER, false);
//		wp_enqueue_script('highlightjs', WPReliableMD_URL.'/bower_components/highlightjs/highlight.pack.js', array('codemirror'), WPReliableMD_VER, false);
//		wp_enqueue_script('squire-rte', WPReliableMD_URL.'/bower_components/squire-rte/build/squire-raw.js', array('highlightjs'), WPReliableMD_VER, false);
//		wp_enqueue_script('plantuml-encoder', WPReliableMD_URL.'/bower_components/plantuml-encoder/dist/plantuml-encoder.js', array('squire-rte'), WPReliableMD_VER, false);
//		wp_enqueue_script('raphael', WPReliableMD_URL.'/bower_components/raphael/raphael.js', array('plantuml-encoder'), WPReliableMD_VER, false);
//		wp_enqueue_script('tui-chart', WPReliableMD_URL.'/bower_components/tui-chart/dist/tui-chart.js', array('raphael'), WPReliableMD_VER, false);
//		wp_enqueue_script('tui-editor', WPReliableMD_URL.'/bower_components/tui-editor/dist/tui-editor-Editor-all.js', array('tui-chart'), WPReliableMD_VER, false);
//		wp_enqueue_script( 'jsHtmlToText', WPReliableMD_URL . '/js/jsHtmlToText.js', array('tui-editor'), WPReliableMD_VER, false );
//		wp_enqueue_script( 'katex', WPReliableMD_URL . '/bower_components/katex/dist/katex.js', array('tui-editor'), WPReliableMD_VER, false );

		wp_enqueue_script('require', WPReliableMD_URL.'/js/require.js', array('jquery-tui-editor'), WPReliableMD_VER, false);
		wp_enqueue_script('require-paths', WPReliableMD_URL.'/js/require_paths.js', array('require'), WPReliableMD_VER, false);
		wp_enqueue_script( 'WPReliableMD_render', WPReliableMD_URL . '/js/WPReliableMD_render.js', array('require-paths'), WPReliableMD_VER, false );

		wp_localize_script( 'WPReliableMD_render', 'ReliableMD', array(
			'api_root' => esc_url_raw( rest_url() ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
			'js_root' => WPReliableMD_URL.'/js/',
			'js_dep_lib_root' => WPReliableMD_URL.'/bower_components/',
		));
	}

	public function enqueue_style() {
		wp_enqueue_style('normalize', '//necolas.github.io/normalize.css/8.0.0/normalize.css', array(), WPReliableMD_VER, false);
		wp_enqueue_style('codemirror', WPReliableMD_URL.'/bower_components/codemirror/lib/codemirror.css', array('normalize'), WPReliableMD_VER, false);
		wp_enqueue_style('github', WPReliableMD_URL.'/bower_components/highlightjs/styles/github.css', array('codemirror'), WPReliableMD_VER, false);
		wp_enqueue_style('tui-editor', WPReliableMD_URL.'/bower_components/tui-editor/dist/tui-editor.css', array('github'), WPReliableMD_VER, false);
		wp_enqueue_style('tui-editor-contents', WPReliableMD_URL.'/bower_components/tui-editor/dist/tui-editor-contents.css', array('tui-editor'), WPReliableMD_VER, false);
		wp_enqueue_style('tui-color-picker', WPReliableMD_URL.'/bower_components/tui-color-picker/dist/tui-color-picker.css', array('tui-editor-contents'), WPReliableMD_VER, false);
		wp_enqueue_style('tui-chart', WPReliableMD_URL.'/bower_components/tui-chart/dist/tui-chart.css', array('tui-color-picker'), WPReliableMD_VER, false);
		wp_enqueue_style( 'katex', WPReliableMD_URL . '/bower_components/katex/dist/katex.css', array('tui-editor'), WPReliableMD_VER, false );
		wp_enqueue_style( 'ReliableMD', WPReliableMD_URL . '/css/WPReliableMD_Admin.css', array('katex'), WPReliableMD_VER, false );
	}

	public function WPReliableMD_the_Content($content) {
		if(get_post_meta(get_the_ID(),'markdown',true) === 'true') {
			//如果是markdown文章，则输出，不使用前面处理的结果，直接取文章数据
			$post = get_post(get_the_ID());
			$content = $post->post_content;
			$content = $this->WPReliableMD_Content($content);
		}
		return $content;
	}

	static public function WPReliableMD_Content($content) {
		$new_content = "<div class='markdown'>";
		$new_content.= $content;
		$new_content.= "</div>";
		$content = $new_content;
		return $content;
	}
}

?>
