<?php

	//class for plug-in set up
	class IA_JSFiddle_Plugin {

		private static $ia_instance;
		var $options = array();
		var $shortcode;
		var $caps = array();

		//impose singleton pattern
		public static function get_instance(array $o = null, $s = null, array $c = null) {
			if(!self::$ia_instance) {
				self::$ia_instance = new IA_JSFiddle_Plugin($o,$s,$c);
			}
			return self::$ia_instance;
		}

		private function __initialize(array $o = null, $s = null, array $c = null) {
			if($o && $s && $c) {
				$this->options = $o;
				$this->shortcode = $s;
				$this->caps = $c;
			}
		}

		//check to see if the shortcode already exists
		private function shortcode_exists() {
			global $shortcode_tags;
			if(!self::$ia_instance->shortcode) {
				return false;
			} else {
				if(array_key_exists(self::$ia_instance->shortcode,$shortcode_tags)) {
					return true;
				} else {
					return false;
				}
			}
		}

		//add user capabilities
		private function add_caps() {
	    	$min_cap = 'manage_options';
	    	$grant = true;
	    	global $wp_roles;
	    	//iterate through all roles and add the capabilities
	    	foreach($wp_roles->role_names as $role => $info) {
	    		$role_obj = get_role($role);
	    		foreach(self::$ia_instance->caps as $cap) {
		        	if(!$role_obj->has_cap($cap) && $role_obj->has_cap($min_cap)) {
		        		add_cap($role,$cap,$grant);
		        	}
		    	}
	    	}
		}

		//remove user capabilities
		private function remove_caps() {
			global $wp_roles;
			//iterate through all roles and remove the capabilities
	    	foreach($wp_roles->roles as $role => $info) {
	        	$role_obj = get_role($role);
	        	foreach(self::$ia_instance->caps as $cap) {
	        		if ($role_obj->has_cap($cap)) {
	            		remove_cap($role, $cap);
	    			}
	    		}
	    	}
		}

		//install and initialize the plug in
		public function activate() {
			//store version options
			foreach(self::$ia_instance->options as $opt => $val) {
				if(!get_option($opt)) {
					add_option($opt,$val);
				} else {
					if(get_option($opt) !== $val) {
						update_option($opt,$val);
					}
				}
			}
			self::$ia_instance->add_caps();
		}

		//disable some stuff that isn't useful if it's deactivated
		public function deactivate() {
			//remove shortcode
			if(self::$ia_instance->shortcode_exists()) {
				remove_shortcode(self::$ia_instance->shortcode);
			}
		}

		//leave no trace of the plugin
		public function uninstall() {
			global $wpdb;
			//remove user capability
			self::$ia_instance->remove_caps();
			//remove options
			foreach(self::$ia_instance->options as $opt => $val) {
				remove_option($opt);
			}
			//get users with jsfiddle meta and remove the meta
			$u_table = $wpdb->prefix . 'usermeta';
			$user_field = get_option('ia_jsfiddle_username_field');
			$query = "SELECT user_id FROM $u_table WHERE meta_key = '$user_field';";
			$get_users = $wpdb->get_results($query);
			if($get_users) {
				foreach($get_users as $user_id) {
					delete_user_meta($user_id,$user_field);
				}
			}
		}
	
	}

?>