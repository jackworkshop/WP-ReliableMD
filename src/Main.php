<?php

/* 插件的主执行文件 */

namespace WPReliableMD;

class Main {
	protected $config_filename;
	/* 构造函数 */
	public function __construct() {
		$this->config_filename = WPReliableMD_PATH.'\\config.json';
		add_action( 'rest_api_init', array($this,'WPReliableMD_Api_Init'));
	}
	public function WPReliableMD_Api_Init() {
		register_rest_route('WPReliableMD', 'config', [
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
}

?>