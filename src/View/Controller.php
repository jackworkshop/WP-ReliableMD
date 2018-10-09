<?php

namespace WPReliableMD\View;

use WPReliableMD\View\Hyperdown\Parser as Parser;

class Controller {

	public function __construct() {

		//Javascript 文件
		add_filter( 'wp_head', array( $this, 'enqueue_scripts' ), 2 );
		//CSS
		add_filter( 'wp_head', array( $this, 'enqueue_style' ), 2 );
		//markdown解析
		add_filter( 'the_content', array( $this, 'WPReliableMD_the_Content' ) );
		add_filter( 'the_excerpt', array( $this, 'the_excerpt' ) );
		add_shortcode('markdown',array($this,'WPReliableMD_Shortcode_Markdown'));

		add_filter('widget_text', 'do_shortcode');

	}

	function the_excerpt( $post_excerpt ) {
		$post_id = get_the_ID();
		if ( ! has_excerpt() ) {
			$post         = get_post( $post_id );
			$post_excerpt = $post->post_content;
		}

		if ( get_post_meta( $post_id, 'markdown', true ) === 'true' ) {
			$post_excerpt = ( new parser() )->makeHtml( $post_excerpt );
			if ( preg_match( '#<p>((\w|\d|[^x00-xff]).+?)</p>#', $post_excerpt, $mc ) ) {
				$post_excerpt = $mc[1];
			} else {
				$post_excerpt = __('This post has no common text');
			}
		}

		return do_shortcode(substr( $post_excerpt, 0, 50 ));
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'require' );
		wp_enqueue_script( 'require-paths' );
		wp_enqueue_script( 'WPReliableMDFrontend' );
	}

	public function enqueue_style() {
		wp_enqueue_style( 'normalize' );
		wp_enqueue_style( 'codemirror' );
		wp_enqueue_style( 'github' );
		wp_enqueue_style( 'tui-editor' );
		wp_enqueue_style( 'tui-editor-contents' );
		wp_enqueue_style( 'tui-color-picker' );
		wp_enqueue_style( 'tui-chart' );
		wp_enqueue_style( 'katex' );
		wp_enqueue_style( 'WPReliableMDFrontend' );
	}

	public function WPReliableMD_the_Content( $content ) {
		if ( get_post_meta( get_the_ID(), 'markdown', true ) === 'true' ) {
			//如果是markdown文章，则输出，不使用前面处理的结果，直接取文章数据
			$post    = get_post( get_the_ID() );
			$content = $post->post_content;
			$content = $this->WPReliableMD_Content( $content );
		}

		return do_shortcode($content);
	}

	public function WPReliableMD_Shortcode_Markdown( $attr, $content ) {
		return do_shortcode($this->WPReliableMD_Content($this->WPReliableMD_AntiTransfer($content)));
	}

	public function WPReliableMD_AntiTransfer($content)  {
		$AntiTransfer = array(
			'&gt;' => '>',
			'&lt;' => '<',
		);


		foreach ($AntiTransfer as $key => $value) {
			$content = str_replace($key,$value,$content);
		}
		return $content;
	}

	public function WPReliableMD_Content( $content ) {

		if ( get_post_meta( get_the_ID(), 'markdown', true ) === 'true' ) {
			$content = apply_filters('markdown_content',$content);  //执行HOOK，进行处理
		}

		$parser = new Parser();
		$backend_rendered = $parser->makeHtml( $content );
		$new_content      = "<div class='markdown-block'>";
		$new_content      .= "<div class='markdown' style='display:none;'>{$content}</div>";
		$new_content      .= "<div class='markdown-backend-rendered'>{$backend_rendered}</div>";
		$new_content      .= "</div>";
		$content          = $new_content;

		return $content;
	}
}

?>
