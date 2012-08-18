<?php

	require_once(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/ia-jsfiddle-skin-manager.class.php');
	//generates a JSON file containing JSFiddle embed skins
	$skin_manager = new IA_JSFiddle_Skin_Manager();
	$skin_manager->initialize();

?>