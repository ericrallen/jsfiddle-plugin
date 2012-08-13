<?php

class jsfiddle_skin_proxy {
	
	public static function process($id, $result = false, $tabs = 'js,html,css,result', $skin = 'default') {
		
		$url = $result ? 'http://fiddle.jshell.net/'.$id.'/show/light/' : 'http://fiddle.jshell.net/'.$id.'/embedded/'.urlencode($tabs).'/';
		
		self::validate($id);
		$output = self::get_contents($url);
		$output = self::parse($output,$id,$skin);
		
		return $output;
		
	}
	
	public static function parse($output,$id,$skin) {
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
		
		if($skin !== 'default') {
			$output = str_replace(
				'</head>',
				'<link rel="stylesheet" type="text/css" href="' . $url_proxy . '/skins/' . $skin . '/style.css" />' . "\n" .
				'<script type="text/javascript" src="' . $url_proxy . '/js/scripts.js"></script>' . "\n" .
				'</head>',
				$output
			);
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