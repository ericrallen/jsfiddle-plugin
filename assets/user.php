<?php

	//user actions for js fiddle plugin

	//add JSFiddle profile field
	function update_contact_methods( $contactmethods ) {
		$jsfiddle_username = get_option('ia_jsfiddle_username_field');
		if($jsfiddle_username === 'iajsfiddle') {
			$contactmethods['iajsfiddle'] = 'JSFiddle';
			return $contactmethods;
		}
	}
	add_filter('user_contactmethods','update_contact_methods',10,1);

?>