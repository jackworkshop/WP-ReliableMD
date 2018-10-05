<?php

namespace WPReliableMD\View;

use WPReliableMD\View\Hyperdown\Parser as Parser;

class Controller {

	public function __construct() {

		//Javascript 文件
		add_filter( 'wp_head', array( $this, 'enqueue_scripts' ), 2 );
		//CSS
		add_filter( 'wp_head', array( $this, 'enqueue_style' ), 2 );
		add_filter( 'the_content', array( $this, 'WPReliableMD_the_Content' ) );
		add_filter( 'the_excerpt', array( $this, 'home_the_excerpt' ) );

//		add_shortcode('markdown',array($this,'WPReliableMD_Shortcode_Markdown'));

	}

	function home_the_excerpt($post_excerpt) {
		$post_id = get_the_ID();
		if ( ! has_excerpt() ) {
			$post         = get_post( $post_id );
			$post_excerpt = $post->post_content;
		}

		if ( get_post_meta( $post_id, 'markdown', true ) === 'true' ) {
			$post_excerpt = (new parser())->makeHtml( $post_excerpt );
			if(preg_match('#<p>((\w|[^x00-xff]).+?)</p>#', $post_excerpt, $mc))
			{
				$post_excerpt = $mc[1];
			}
		}

		return substr($post_excerpt, 0, 50);
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
		return $content;
	}

	public function WPReliableMD_Shortcode_Markdown($attr, $content) {
		return $this->WPReliableMD_Content($content);
	}

	public function WPReliableMD_Content( $content ) {
		$backend_rendered = (new Parser())->makeHtml($content);
		$new_content = "<div class='markdown-block'>";
		$new_content .= "<div class='markdown' style='display:none;'>{$content}</div>";
		$new_content .= "<div class='markdown-backend-rendered'>{$backend_rendered}</div>";
		$new_content .= "</div>";
		$content     = $new_content;

		return $content;
	}
}

?>
