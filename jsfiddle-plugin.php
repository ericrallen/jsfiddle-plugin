<?php
	
	/*
		Plugin Name: JSFiddle Shortcode
		Plugin URI: http://internetalche.me/
		Description: Add JSFiddles via shortcode
		Version: v0.1b
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
	$options = array(
		'ia_jsfiddle_version_number' => '0.2b'
	);
	$shortcode = 'iajsfiddle';
	$caps = array(
		'ia_jsfiddle_options'
	);

	
	//CLASSES

	//include plugin classes
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/classes/IAJSFiddlePlugin.class.php'); //setup
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/classes/IAJSFiddle.class.php'); //shortcode display
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/classes/IAJSFiddleAPI.class.php'); //api interaction

	//initialize setup class
	$ia_jsfiddle_plugin = IA_JSFiddle_Plugin::get_instance($);

	
	//SHORTCODE	
	
	function ia_jsfiddle_display_by_shortcode($atts) {
		//get data from short code
		extract(
			shortcode_atts(
				array(
					'user' => 'NULL',
					'fiddle' => 'NULL',
					'height' => '300px',
					'width' => '100%',
					'show' => 'NULL'
				), $atts
			)
		);
		$fiddle['code'] = $fiddle;
		$ia_jsfiddle = new IA_JSFiddle($user,$fiddle,$height,$width,$show);
		$fiddle = $ia_jsfiddle->get_fiddle();
	}
	//set up shortcode for display
	if(!ia_js_fiddle_shortcode_exists('iajsfiddle')) {
		add_shortcode('iajsfiddle','ia_jsfiddle_display_by_shortcode');
	}

	
	//ACTIVATION

	//add plug-in options
	function ia_jsfiddle_set_options() {
		$ia_jsfiddle_plugin->activate();
	}
	//run when plug-in is activated
	register_activation_hook(__FILE__,'ia_jsfiddle_set_options');
	

	//DEACTIVATION
	
	//remove plug-in options
	function ia_jsfiddle_clear_options() {
		$ia_jsfiddle_plugin->deactivate();
	}
	register_deactivation_hook(__FILE__,'ia_jsfiddle_clear_options');

	
	//MISC
	
	//include plugin actions
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/actions/user.php'); //user based actions
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/actions/menu.php'); //menu based actions
	
?>