<?php

	require_once('ia-jsfiddle-skin-manager.class.php');
	//generates a JSON file containing JSFiddle embed skins
	$skin_manager = new IA_JSFiddle_Skin_Manager();
	$skin_manager->get_themes();

?>