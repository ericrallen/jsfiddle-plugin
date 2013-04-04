<?php	
/*
Plugin Name: JSFiddle Shortcode by InternetAlche.Me
Plugin URI: https://github.com/ericrallen/jsfiddle-plugin/
Description: Add JSFiddles via shortcode and select Fiddles from your JSFiddle user account directly from your post and page editor.
Version: 1.3.4
Author: Eric Allen
Author URI: http://internetalche.me/
License: MIT
*/
	
	/*
	--------------------------------------------------- Change Log -----------------------------------------------------
		
	 + 2013-04-03 v1.3.4 Updated custom skin functionality to work better.

	 + 2012-09-06 v1.3.3 Added support for simple shortcode via [iajsfiddle url=""].

	 + 2012-09-06 v1.3.2 Updated a few directory errors that I missed in the previous update.

	 + 2012-09-06 v1.3 Updated plug-in to fix an issue involving directory structure after I changed the plug-in's folders for the Wordpress repo.

	 + 2012-08-21  v1.0b  Plug-in updated. Finished the cron implementation of the theme manager.

	 + 2012-08-18  v1.0b  Plug-in updaated. Set up theme manager and cron implementation. Made several updates to functionality.

	 + 2012-08-09  v0.2b  Plug-in updated. Began class creation and started designing plug-in methods, etc. Cleaned up plug-in code to a series of separate files that will be more manageable in the long run.

	 + 2012-08-07  v0.1b  Plug-in created.
									
	--------------------------------------------------------------------------------------------------------------------
	*/

	
	//OPTIONS
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/plugin-options.php');


	//CLASSES

	//include plugin classes
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/classes/IAJSFiddle.class.php'); //shortcode display

	//SHORTCODE	
	
	function ia_jsfiddle_display_by_shortcode($atts) {
		//get data from short code
		extract(
			shortcode_atts(
				array(
					'user' => '',
					'fiddle' => '',
					'height' => '',
					'width' => '',
					'show' => '',
					'skin' => '',
					'url' => ''
				), $atts
			)
		);
		$fiddle_array = array();
		if($url) {
			if(substr($url, 0, 7) == 'http://') {
				$url = substr($url, 7);
			}
			$url_array = explode('/', $url);
			$fiddle_array['user'] = $url_array[1];
			$fiddle_array['code'] = $url_array[2];
		} else {
			$fiddle_array['code'] = $fiddle;
			if(!$user) {
				$user = get_the_author_meta(get_option('ia_jsfiddle_username_field'));
			}
			$fiddle_array['user'] = $user;
		}
		$ia_jsfiddle = new IA_JSFiddle($fiddle_array,$height,$width,$show,$skin);
		$jsfiddle = $ia_jsfiddle->get_fiddle();
		return $jsfiddle;
	}
	//set up shortcode for display
	add_shortcode($shortcode,'ia_jsfiddle_display_by_shortcode');
	

	//CRON

	//set up cron for theme manager script
	function ia_jsfiddle_add_cron() {
		require_once(get_option('ia_js_fiddle_skins_dir') . '/plugin-options.php');
		$skin_manager = new IA_JSFiddle_Theme_Manager();
		$skin_manager->initialize();
	}
	
	if (!wp_next_scheduled('ia_jsfiddle_check_themes')) {
		$schedule = get_option('ia_js_fiddle_theme_manager_cron');
		wp_schedule_event(time(),$schedule,'ia_jsfiddle_cron' );
	}

	add_action('ia_jsfiddle_cron','ia_jsfiddle_run_cron');


	//ACTIVATION

	//add plug-in options
	function ia_jsfiddle_set_options() {
		global $options,$shortcode;
		foreach($options as $opt => $val) {
			if(!get_option($opt)) {
				add_option($opt,$val);
			} else {
				if(get_option($opt) !== $val) {
					update_option($opt,$val);
				}
			}
		}
		ia_jsfiddle_add_caps();
		$fp = fopen(WP_PLUGIN_URL . '/' . basename(dirname(__FILE__)) . '/assets/jsFiddle-skin-proxy/skins/ia-jsfiddle-skin-manager.php', "r");
	}
	//run when plug-in is activated
	register_activation_hook(__FILE__,'ia_jsfiddle_set_options');

	//DEACTIVATION
	
	//remove plug-in options
	function ia_jsfiddle_clear_options() {
		global $options, $shortcode, $caps, $wpdb, $wp_roles;
		if(ia_jsfiddle_shortcode_exists($shortcode)) {
			remove_shortcode($shortcode);
		}
		
		//get users with jsfiddle meta and remove the meta
		$u_table = $wpdb->prefix . 'usermeta';
		
		$remove['meta_key'] = 'iajsfiddle';
		foreach($remove as $name => $val) {
			$query = "SELECT user_id FROM $u_table WHERE meta_key = '$val';";
			$get_users = $wpdb->get_results($query);
			if($get_users) {
				foreach($get_users as $user_id) {
					delete_user_meta($user_id,$val);
				}
			}
		}
		
		//iterate through all roles and remove the capabilities
		foreach($wp_roles->roles as $role => $info) {
			$role_obj = get_role($role);
			foreach($caps as $cap) {
				if ($role_obj->has_cap($cap)) {
					$role_obj->remove_cap($cap);
				}
			}
		}
	}
	register_deactivation_hook(__FILE__,'ia_jsfiddle_clear_options');

	
	//MISC
	
	//include plugin actions
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/user.php'); //user based actions
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/post.php'); //menu based actions
	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/assets/menu.php'); //menu based actions

	//check shortcode
	function ia_jsfiddle_shortcode_exists() {
		global $shortcode_tags, $shortcode;
		if(!$shortcode) {
			return false;
		} else {
			if(array_key_exists($shortcode,$shortcode_tags)) {
				return true;
			} else {
				return false;
			}
		}
	}

	//add role caps
	function ia_jsfiddle_add_caps() {
		global $wp_roles, $caps;
		$min_cap = 'manage_options';
		$grant = true;
		//iterate through all roles and add the capabilities
		foreach($wp_roles->role_names as $role => $info) {
			$role_obj = get_role($role);
			foreach($caps as $cap) {
				if(!$role_obj->has_cap($cap) && $role_obj->has_cap($min_cap)) {
					$role_obj->add_cap($cap,$grant);
				}
			}
		}
	}
	
?>