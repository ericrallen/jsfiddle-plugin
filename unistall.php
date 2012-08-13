<?php

	//include options
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/plugin-options.php');

	//include plugin creation class
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/classes/IAJSFiddlePlugin.class.php');
	
	$ia_jsfiddle = IA_JSFiddle_Plugin::get_instance($options,$shortcode,$caps);
	$ia_jsfiddle->uninstall();

?>