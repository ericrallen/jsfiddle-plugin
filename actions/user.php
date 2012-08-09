<?php

	//user actions for js fiddle plugin

	//add JSFiddle profile field
	function update_contact_methods( $contactmethods ) {
		$contactmethods['iajsfiddle'] = 'JSFiddle';
		return $contactmethods;
	}
	add_filter('user_contactmethods','update_contact_methods',10,1);

?>