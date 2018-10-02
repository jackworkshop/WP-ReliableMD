<?php

namespace WPReliableMD\View;

class Controller {

	public function __construct() {

		//Javascript 文件
		add_filter('wp_head',array($this,'enqueue_scripts'),2);

		add_filter('the_content',array($this,'WPReliableMD_Content'));

		remove_filter (  'the_content' ,  'wpautop'  );
	}
	public function enqueue_scripts() {
		wp_deregister_script('jquery'); //取消系统原有的jquery定义
		wp_enqueue_script('jquery-tui-editor', WPReliableMD_URL.'/bower_components/jquery/dist/jquery.js', false, WPReliableMD_VER, false);

		wp_enqueue_script( 'frontend-render', WPReliableMD_URL . '/js/frontend-render.js', array('jquery-tui-editor'), WPReliableMD_VER, false );

		wp_localize_script( 'frontend-render', 'wpApiSettings', array(
			'root' => esc_url_raw( rest_url() ),
			 'nonce' => wp_create_nonce( 'wp_rest' )
		));
	}

	public function WPReliableMD_admin_body_class() {
		if ( current_theme_supports( 'editor-styles' ) && current_theme_supports( 'dark-editor-style' ) ) {
		 	return "$classes reliablemd-editor-page is-fullscreen-mode is-dark-theme";
		} else {
			// Default to is-fullscreen-mode to avoid jumps in the UI.
			return "$classes reliablemd-editor-page is-fullscreen-mode";
		}
	}

	public function WPReliableMD_the_Content($content) {
		if(get_post_meta($post_id,'markdown',true) === 'true') {
			//如果是markdown文章，则输出
			$content = WPReliableMD_Content($content);
		}
		return $content;
	}

	static public function WPReliableMD_Content($content) {
		$new_content = "<div class='markdown'>\n";
		$new_content.= $content;
		$new_content.= "\n</div>";
		return $new_content;
	}
}

?>
