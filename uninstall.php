<?php

	//uninstallation
	if(!defined('WP_UNINSTALL_PLUGIN')) {
		exit ();
	} else{
		global $wpdb;
		//OPTIONS
		require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/plugin-options.php');
		foreach($options as $opt => $val) {
			delete_option($opt);
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

?>