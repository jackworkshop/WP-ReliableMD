<?php

/* 插件的主执行文件 */

namespace WPReliableMD;

use WPReliableMD\Admin\Controller as AdminController;
use WPReliableMD\View\Controller as ViewController;
use WPReliableMD\REST\Controller as RestController;
use WPReliableMD\Environment\Controller as EnvironmentController;
use WPReliableMD\Poster as Poster;
//require_once WPReliableMD_PATH . '/src/Poster.php';

class Main {

	/* 构造函数 */
	public function __construct() {

		add_filter('replace_editor',array($this,'WPReliableMD_init'),10,2);

		new EnvironmentController(); //初始化插件环境控制器

		new RestController();  //初始化REST控制器

		new ViewController(); //初始化前端渲染控制器
	}


	public function WPReliableMD_Page_Init() {
		global $post_type_object;

		?>

        <div class="explain" style="margin-top: 1em;">
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

	public function WPReliableMD_init( $return, $post) {
		global $title, $post_type;

		if ( true === $return && current_filter() === 'replace_editor' ) {
			return $return;
		}

		new AdminController(); //初始化Admin控制器

		add_filter( 'screen_options_show_screen', '__return_false' );

        $post_type_object = get_post_type_object( $post_type );
		if ( ! empty( $post_type_object ) ) {
			$title = $post_type_object->labels->edit_item;
		}

		require_once ABSPATH . 'wp-admin/includes/meta-boxes.php';

		require_once ABSPATH . 'wp-admin/admin-header.php';

		$this->WPReliableMD_Page_Init();   //初始化页面

		remove_filter('the_content', 'wpautop');

		return true;
		//return false;
	}
}

?>
