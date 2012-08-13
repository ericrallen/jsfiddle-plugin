<?php

	global $options, $shortcode, $caps;
	$options = array(
		'ia_jsfiddle_version_number' => '0.2b',
		'ia_jsfiddle_username_field' => 'iajsfiddle'
	);
	$shortcode = 'iajsfiddle';
	$caps = array(
		'ia_jsfiddle_options'
	);

	//include plugin creation class
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/classes/IAJSFiddlePlugin.class.php');
	
	$ia_jsfiddle = IA_JSFiddle_Plugin::get_instance($options,$shortcode,$caps);
	$ia_jsfiddle->uninstall();

?>