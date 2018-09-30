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

	public function WPReliableMD_Page_Init() {
		global $post_type_object;
?>
		<div id="titlediv">
			<div id="titlewrap">
				<label class="screen-reader-text" id="title-prompt-text" for="title"><?php echo apply_filters( 'enter_title_here', __( 'Enter title here' ), $post ); ?></label>
				<input type="text" name="post_title" size="30" value="<?php echo esc_attr( $post->post_title ); ?>" id="title" spellcheck="true" autocomplete="off" />
			</div>
		</div>
		<div class="row">
        	<div class="col-xs-6">
            	<h4>编辑</h4>
        	</div>
        	<div class="col-xs-6">
           		<h4>预览</h4>
        	</div>
    	</div>
    	<div class="row" style="margin-left: 1em">
        	<div class="btn-group btn-group-xs">
            	<button type="button" class="btn btn-default"><b>B</b></button>
            	<button type="button" class="btn btn-default"><em>I</em></button>
        	</div>
    	</div>
    	<div class="row mdeditor">
        	<div class="col-xs-6">
            	<div class="mdeditor-raw">
                	<textarea style="width: 100%;height: 25em; resize:none;border: 1px solid #ccc!important;padding:14px;border-radius: 16px!important;"></textarea>
            	</div>
        	</div>
        	<div class="col-xs-6">
            	<div class="mdeditor-rendered" style="width: 100%; ">
           		</div>
        	</div>
        	<div class="clearfix visible-xs"></div>
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

		return true;
		//return false;
	}
}

?>