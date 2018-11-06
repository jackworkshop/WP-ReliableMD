<?php
/**
 * Plugin Name:       WP ReliableMD
 * Plugin URI:        https://github.com/jack9603301/WP-ReliableMD
 * Description:       A reliable, beautiful and powerful markdown plugin for wordpress, supporting editing and rendering
 * Version:           0.5
 * Author:            WP-ReliableMD
 * Author URI:        https://github.com/jack9603301/WP-ReliableMD
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       ReliableMD
 * Domain Path:       /languages
 */

namespace WPReliableMDRoot;

use WPReliableMD\Main as Main;

define('WPReliableMD_NAME','WP-ReliableMD');
define('WPReliableMD_VER','1.0');
define('WPReliableMD_FILE',plugin_basename( __FILE__ ));
define('WPReliableMD_URL', plugins_url( '', __FILE__ ) ); //插件资源路径
define('WPReliableMD_PATH', dirname( __FILE__ ) ); //插件路径文件夹

//自动加载
require_once WPReliableMD_PATH . '/vendor/autoload.php';

new Main();  //进入插件主处理程序

?>