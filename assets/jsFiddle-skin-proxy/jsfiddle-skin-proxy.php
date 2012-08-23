<?php

class jsfiddle_skin_proxy {
	
	public static function process($id, $skindir, $result = false, $tabs = 'js,html,css,result', $skin = 'default') {
		
		$url = $result ? 'http://fiddle.jshell.net/'.$id.'/show/light/' : 'http://fiddle.jshell.net/'.$id.'/embedded/'.urlencode($tabs).'/';
		
		self::validate($id);
		$output = self::get_contents($url);
		$output = self::parse($output,$id,$skindir,$skin);
		
		return $output;
		
	}
	
	public static function parse($output,$id,$skindir,$skin) {
		$output = preg_replace(
			array(
				'/(src\=\")\//i',
				'/(href\=\")\//i'
			),
			'$1http://jsfiddle.net/',
			$output
		);
		
		$url_proxy = preg_replace('/(.*?)\?.*/i','$1',$_SERVER['REQUEST_URI']);
		
		$output = preg_replace(
			'/show_src\s+?\=\s+?\".*?\"/i',
			'show_src = "'.$url_proxy.'?id='.$id.'&result=1"',
			$output
		);
		
		$output = preg_replace(
			'/shell_edit_url\s+?\=\s+?\'/i',
			'shell_edit_url = \'http://jsfiddle.net',
			$output
		);
		
		//if there was a skin passed
		if($skin !== 'default') {
			//set up the link structure
			$skin_link = $skindir . $skin;
			//check for style definition
			$header_response = get_headers($skin_link . '/style.css', 1);
			if(strpos($header_response[0],"404") !== false) {
				//there is no style definition for the requested theme
			} else {
				//check for script definition
				$header_response = get_headers($skin_link . '/js/scripts.js', 1);
				if(strpos($header_response[0],"404") !== false) {
					$script_link = '';
				} else {
					$script_link = '<script type="text/javascript" src="' . $skin_link . '/js/scripts.js"></script>' . "\n";
				}
				//add custom css and js to bottom of the <head>
				$output = str_replace(
					'</head>',
					'<link rel="stylesheet" type="text/css" href="' . $skin_link . '/style.css" />' . "\n" .
					$script_link . 
					'</head>',
					$output
				);
			}
		}
		return $output;
	}
	
	public static function get_contents($url) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}
	
	public static function validate($id) {
		if ( ! preg_match('/^[a-z0-9\/]*$/si', $id) ) {
			throw new Exception("Invalid jsfiddle ID");
		}
	}
	
}

?>