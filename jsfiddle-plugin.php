<?php
	
	/*
		Plugin Name: JSFiddle Shortcode InternetAlche.Me
		Plugin URI: http://internetalche.me/
		Description: Add JSFiddles via shortcode
		Version: v0.2b
		Author: Eric Allen
		Author URI: http://internetalche.me/
		License: MIT
	*/
	
	/*
	--------------------------------------------------- Change Log -----------------------------------------------------
		
	 + 2012-08-09  v0.2b  Plug-in updated. Began class creation and started designing plug-in methods, etc. Cleaned up plug-in code to a series of separate files that will be more manageable in the long run.

	 + 2012-08-07  v0.1b  Plug-in created.
									
	--------------------------------------------------------------------------------------------------------------------
	*/

	
	//OPTIONS
	
	global $options, $shortcode, $caps;
	$options = array(
		'ia_jsfiddle_version_number' => '0.2b',
		'ia_jsfiddle_username_field' => 'iajsfiddle'
	);
	$shortcode = 'iajsfiddle';
	$caps = array(
		'ia_jsfiddle_options'
	);


	//CLASSES

	//include plugin classes
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/classes/IAJSFiddlePlugin.class.php'); //setup
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/classes/IAJSFiddle.class.php'); //shortcode display
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/classes/IAJSFiddleAPI.class.php'); //api interaction
	

	//SHORTCODE	
	
	function ia_jsfiddle_display_by_shortcode($atts) {
		//get data from short code
		extract(
			shortcode_atts(
				array(
					'fiddle' => '',
					'height' => '',
					'width' => '',
					'show' => ''
				), $atts
			)
		);
		$user = get_the_author_meta(get_option('ia_jsfiddle_username_field'));
		$fiddle_array = array();
		$fiddle_array['code'] = $fiddle;
		$fiddle_array['user'] = $user;
		$ia_jsfiddle = new IA_JSFiddle($fiddle_array,$height,$width,$show);
		$jsfiddle = $ia_jsfiddle->get_fiddle();
		echo $jsfiddle;
	}
	//set up shortcode for display
	add_shortcode('iajsfiddle','ia_jsfiddle_display_by_shortcode');

	
	//ACTIVATION

	//add plug-in options
	function ia_jsfiddle_set_options() {
		global $options,$shortcode,$caps;
		//initialize setup class
		$ia_jsfiddle_plugin = IA_JSFiddle_Plugin::get_instance($options,$shortcode,$caps);
		$ia_jsfiddle_plugin->activate();
	}
	//run when plug-in is activated
	register_activation_hook(__FILE__,'ia_jsfiddle_set_options');
	

	//DEACTIVATION
	
	//remove plug-in options
	function ia_jsfiddle_clear_options() {
		global $options,$shortcode,$caps;
		//initialize setup class
		$ia_jsfiddle_plugin = IA_JSFiddle_Plugin::get_instance($options,$shortcode,$caps);
		$ia_jsfiddle_plugin->deactivate();
	}
	register_deactivation_hook(__FILE__,'ia_jsfiddle_clear_options');

	
	//MISC
	
	//include plugin actions
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/user.php'); //user based actions
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/post.php'); //menu based actions
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/menu.php'); //menu based actions
	
?>