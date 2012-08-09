<?php

	//actions for admin menu

	//include files for each page
	require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/pages/options.php");
	
	//add items to the admin menu
	function ia_jsfiddle_menu() {
		//add options page under the Settings menu
		add_submenu_page('options-general.php','JSFiddle Shortcode','JSFiddle Shortcode Settings','ia_jsfiddle_options','ia_jsfiddle_options','ia_jsfiddle_options_page');
	}
	//run when admin menu is being created
	add_action('admin_menu','ia_jsfiddle_menu');

?>