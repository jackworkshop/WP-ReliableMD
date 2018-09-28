<?php

/* 插件的主执行文件 */

namespace WPReliableMD;

class Main {
	/* 构造函数 */
	public function __construct() {
		add_action( 'rest_api_init', array(this,'WPReliableMD_Api_Init'));
	}
	private function WPReliableMD_Api_Init() {
		register_rest_route('WPReliableMD', 'config', [
			'methods'   => 'GET',
			'callback'  => 'WPReliableMD_Config_Api'
		]);
	}
	private function WPReliableMD_Config_Api() {
		return json_encode([
			'enable' => true
		]);
	}
}

?>