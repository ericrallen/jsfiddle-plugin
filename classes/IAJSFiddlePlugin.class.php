<?php

	//class for plug-in set up
	class IA_JSFiddle_Plugin {

		private static $ia_instance;
		private $options, $shortcode, $caps;

		//create object
		private function __construct($o,$s,$c) {
			$this->options = $o;
			$this->shortcode = $s;
			$this->caps = $c;
		}

		//impose singleton pattern
		public static function get_instance(array $o = null,$s = null,array $c = null) {
			if($v && $s && $c) {
				if(!self::$ia_instance) {
					self::$ia_instance = new IA_JSFiddle_Plugin($v,$s,$c);
				}
			}
			return self::$ia_instance;
		}

		//check to see if the shortcode already exists
		private function shortcode_exists() {
			global $shortcode_tags;
			if(!$this->shortcode) {
				return false;
			} else {
				if(array_key_exists($this->shortcode,$shortcode_tags)) {
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
	    	//iterate through all roles and add the capabilities
	    	foreach($GLOBALS['wp_roles'] as $role_obj) {
	        	foreach($this->caps as $cap) {
		        	if(!$role_obj->has_cap($cap) && $rol_obj->has_cap($min_cap)) {
		        		$role_obj->add_cap($custom_cap, $grant);
		        	}
		    	}
	    	}
		}

		//remove user capabilities
		private function remove_caps() {
			//iterate through all roles and remove the capabilities
	    	foreach($GLOBALS['wp_roles'] as $role_obj) {
	        	foreach($this->caps as $cap) {
	        		if ($role_obj->has_cap($cap)) {
	            		$role_obj->remove_cap($cap);
	    			}
	    		}
	    	}
		}

		//install and initialize the plug in
		public function activate() {
			//store version number
			foreach($this->v as $opt => $val) {
				add_option($opt,$val);
			}
			$this->add_caps();
		}

		//disable some stuff that isn't useful if it's deactivated
		public function deactivate() {
			//remove shortcode
			if($this->shortcode_exists()) {
				remove_shortcode($this->shortcode);
			}
		}

		//leave no trace of the plugin
		public function uninstall() {
			global $wpdb;
			//remove user capability
			$this->remove_caps();
			//remove options
			foreach($this->v as $opt => $val) {
				remove_option($opt);
			}
			//get users with jsfiddle meta and remove the meta
			$u_table = $wpdv->prefix . 'usermeta';
			$query = "SELECT user_id FROM $u_table WHERE meta_key = 'jsfiddle';";
			$get_users = $wpdb->get_results($query);
			if($get_users) {
				foreach($get_users as $user_id) {
					delete_user_meta($user_id,'iajsfiddle');
				}
			}
		}
	
	}

?>