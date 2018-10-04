<?php

namespace WPReliableMD\Admin;

class Controller {

	public function __construct() {

		//Javascript 文件
		add_filter( 'admin_head', array( $this, 'enqueue_scripts' ), 2 );
		//CSS 文件
		add_filter( 'admin_head', array( $this, 'enqueue_style' ), 2 );

		add_filter( 'admin_body_class', array( $this, 'WPReliableMD_admin_body_class' ) );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'require' );
		wp_enqueue_script( 'require-paths' );
		wp_enqueue_script( 'ReliableMD' );
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
		wp_enqueue_style( 'ReliableMD' );
	}

	public function WPReliableMD_admin_body_class() {
		if ( current_theme_supports( 'editor-styles' ) && current_theme_supports( 'dark-editor-style' ) ) {
			return "$classes reliablemd-editor-page is-fullscreen-mode is-dark-theme";
		} else {
			// Default to is-fullscreen-mode to avoid jumps in the UI.
			return "$classes reliablemd-editor-page is-fullscreen-mode";
		}
	}

	public function WPReliableMD_Page_Init() {
		global $post_type_object;

		?>

        <div id="editor-title" style="margin-top: 1em;">
            <h1>Input your text here</h1>
        </div>

        <div class="code-html">
            <div id="editSection"></div>
            <div style="text-align: right">
                <button id="submit">Submit</button>
            </div>
        </div>
		<?php
	}

	public function WPReliableMD_init( $return, $post ) {
		global $title, $post_type;

		if ( true === $return && current_filter() === 'replace_editor' ) {
			return $return;
		}

		add_filter( 'screen_options_show_screen', '__return_false' );

		$post_type_object = get_post_type_object( $post_type );
		if ( ! empty( $post_type_object ) ) {
			$title = $post_type_object->labels->edit_item;
		}

		require_once ABSPATH . 'wp-admin/includes/meta-boxes.php';

		require_once ABSPATH . 'wp-admin/admin-header.php';

		$this->WPReliableMD_Page_Init();   //初始化页面

		remove_filter( 'the_content', 'wpautop' );

		return true;
		//return false;
	}
}

?>
