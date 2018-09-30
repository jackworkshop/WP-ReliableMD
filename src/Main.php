<?php

/* 插件的主执行文件 */

namespace WPReliableMD;

use WPReliableMD\Admin\Controller as AdminController;

class Main {
	protected $config_filename;
	/* 构造函数 */
	public function __construct() {
		$this->config_filename = WPReliableMD_PATH.'\\config.json';
		add_action( 'rest_api_init', array($this,'WPReliableMD_Api_Init'));
		
		add_filter('replace_editor',array($this,'WPReliableMD_init'),10,2);
	}

	public function WPReliableMD_Api_Init() {
		register_rest_route(WPReliableMD_NAME, 'config', [
			'methods'   => 'GET',
			'callback'  => array($this,'WPReliableMD_Config_Api')
		]);
	}
	public function WPReliableMD_Config_Api() {
		if ( file_exists( $this->config_filename ) ) {
			$f = fopen($this->config_filename, "r");
			$config = fread($f, filesize($this->config_filename));
			return json_decode($config,TRUE);
		} else {
			return [
				'enable' => true,
				'latex' => "MathJax",
				'info' => 'default config'
			];
		}
	}
	public function WPReliableMD_init( $return, $post) {
		global $title, $post_type;

		if ( true === $return && current_filter() === 'replace_editor' ) {
			return $return;
		}

		new AdminController(); //初始化Admin控制器

		//add_filter( 'screen_options_show_screen', '__return_false' );

        $post_type_object = get_post_type_object( $post_type );
		if ( ! empty( $post_type_object ) ) {
			$title = $post_type_object->labels->edit_item;
		}
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

		require_once ABSPATH . 'wp-admin/includes/meta-boxes.php';

		require_once ABSPATH . 'wp-admin/admin-header.php';

		return true;
		//return false;
	}
}

?>