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
		wp_enqueue_script('require');
		wp_enqueue_script('require-paths');
		wp_enqueue_script( 'WPReliableMD_render');
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
