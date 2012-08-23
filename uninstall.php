<?php

	//uninstallation
	if(!defined('WP_UNINSTALL_PLUGIN')) {
		exit ();
	} else{
		//OPTIONS
		require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/plugin-options.php');
		$user_field = get_option('ia_jsfiddle_username_field');
		foreach($options as $opt => $val) {
			delete_option($opt);
		}
	}

?>