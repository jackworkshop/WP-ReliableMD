<?php
/**
 * Plugin Name:       WP ReliableMD
 * Plugin URI:        https://github.com/jackworkshop/WP-ReliableMD
 * Description:       A reliable, beautiful and powerful markdown plugin for wordpress, supporting editing and rendering
 * Version:           0.9-dev
 * Author:            WP-ReliableMD
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       ReliableMD
 */

function WP_ReliableMD_block_init() {
	$asset_file = include( plugin_dir_path( __FILE__ ) . 'block.asset.php');

    wp_register_script(
        'block',
        plugins_url( 'block.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );
    wp_register_style(
        'block',
        plugins_url( 'block.css', __FILE__ )
    );
    wp_enqueue_style('block');
    register_block_type( 'wp-reliablemd/toast-editor', array(
        'api_version' => 2,
        'editor_script' => 'block',
        'editor_style' => 'block'
        //'render_callback' => 'WP_ReliableMD_block_dynamic_render_callback'
    ) );
}

add_action( 'init', 'WP_ReliableMD_block_init' );
