<?php

	//OPTIONS
	
	global $options, $shortcode, $caps;
	$options = array(
		'ia_jsfiddle_version_number' => '1.0b',
		'ia_jsfiddle_username_field' => 'iajsfiddle',
		'ia_jsfiddle_skins_dir' => plugins_url() . '/jsfiddle-plugin/assets/jsFiddle-skin-proxy/skins/',
		'ia_jsfiddle_theme_manager_cron' => 'hourly'
	);
	$shortcode = 'iajsfiddle';
	$caps = array(
		'ia_jsfiddle_options'
	);

?>