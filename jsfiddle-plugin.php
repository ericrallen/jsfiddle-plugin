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
		
	 +	2012-08-07		v0.1b		Plug-in created.
									
	--------------------------------------------------------------------------------------------------------------------
	*/

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
		$output = '';
		
		if($user && $fiddle) {
			$output .= '<iframe style="width: ' . $width . '; height: ' . $height . ';" src="http://jsfiddle.net/' . $user . '/' . $fiddle . '/embedded/ allowfullscreen="allowfullscreen" frameborder="0"></iframe>';
		} else {
			$output .= 'There was an error loading this <a href="http://jsfiddle.net/">jsfiddle</a>.';
		}
		return $output;
	}
	//set up shortcode for display
	add_shortcode('jsfiddle','ia_jsfiddle_display_by_shortcode');
	
?>