<?php

namespace WPReliableMD\Admin;

class Controller {
	public function __construct() {
		add_action('edit_page_form',array($this,'enqueue_scripts'));
		add_action('edit_form_advanced',array($this,'enqueue_scripts'));
	}

	public function enqueue_scripts() {
		//Requirejs库
		wp_enqueue_script('Require', '//cdn.jsdelivr.net/npm/requirejs/require.min.js', array(), WPReliableMD_VER, true);
		wp_enqueue_script( 'ReliableMD', WPReliableMD_URL . '/js/WPReliableMD.js', array(), WPReliableMD_VER, true );
	}
}

?>