<?php

namespace WPReliableMD\View;

use WPReliableMD\View\Hyperdown\Parser as Parser;

class Controller {

	private $parser;

	public function __construct() {

		//Javascript 文件
		add_filter( 'wp_head', array( $this, 'enqueue_scripts' ), 2 );
		//CSS
		add_filter( 'wp_head', array( $this, 'enqueue_style' ), 2 );
		add_filter( 'the_content', array( $this, 'WPReliableMD_the_Content' ) );
		//add_filter( 'the_excerpt', array( $this, 'the_excerpt' ) );

		add_shortcode('markdown',array($this,'WPReliableMD_Shortcode_Markdown'));

		$this->parser       = new Parser();
	}

	/*function the_excerpt($post_excerpt) {
		$post_id = get_the_ID();
		//return $post_excerpt;
		if ( !has_excerpt() ) {
			if ( get_post_meta( $post_id, 'markdown', true ) === 'true' ) {
				$post    = get_post( $post_id );
				//$post_excerpt = $this->parser->makeHtml( substr( $post->post_content, 0, 50 ));
				$post_excerpt = "<p>";
				//$post_excerpt .= __("This is a markdown article. Users do not have a summary of the article, so they cannot be displayed.");
				$post_excerpt .= "[markdown]".substr( $post->post_content, 0, 50 )."[/markdown]";
				//$post_excerpt = $this->parser->makeHtml( substr( $post->post_content, 0, 50 ).apply_filters( 'excerpt_more', '' ));
				$post_excerpt .= apply_filters( 'excerpt_more', '' );
				$post_excerpt .= "</p>";
			}
		}
		return do_shortcode($post_excerpt);
	}*/

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
		$backend_rendered = $this->parser->makeHtml($content);
		$new_content = "<div class='markdown-block'>";
		$new_content .= "<div class='markdown' style='display:none;'>{$content}</div>";
		$new_content .= "<div class='markdown-backend-rendered'>{$backend_rendered}</div>";
		$new_content .= "</div>";
		$content     = $new_content;

		return $content;
	}
}

?>
