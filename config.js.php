<?php
/**
 * Created by PhpStorm.
 * User: qiujaingkun
 * Date: 2018/9/28
 * Time: 18:26
 */
$config_filename = './config.js';
$default_config = <<<TAG

RMD_config = {
	'enable': true,
	'latex': "MathJax",
	'info': 'default config'
};
TAG;
if ( file_exists( $config_filename ) ) {
	$f = fopen($config_filename, "r");
	$config = fread($f, filesize($config_filename));
}else{
	$config = $default_config;
}
echo $config;
