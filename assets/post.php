<?php

	require_once("classes/IAJSFiddleAPI.class.php");
	
	//post editor actions
	function ia_jsfiddle_metabox() {
		add_meta_box('ia_jsfiddle_list','JSFiddles','ia_jsfiddle_user_fiddles','post','side','high');
		add_meta_box('ia_jsfiddle_list','JSFiddles','ia_jsfiddle_user_fiddles','post','side','high');
	}
	add_action('admin_init','ia_jsfiddle_metabox',10,1);

	function ia_jsfiddle_user_fiddles() { ?>

		<div class="inside">
			<h2>test</h2>

			<?php
			$user = wp_get_current_user();
			$fiddle_user = get_user_meta($user->ID,get_option('ia_jsfiddle_username_field'),true);
			$ia_jsfiddle_api = new IA_JSFiddle_API();
			$user_fiddles = $ia_jsfiddle_api->get_fiddles($fiddle_user); ?>

		</div>

	<?php }

?>