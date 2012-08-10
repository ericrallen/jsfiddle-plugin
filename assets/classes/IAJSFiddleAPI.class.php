<?php

	//class for retrieving fiddles for the fiddle embed selector
	class IA_JSFiddle_API {

		public function get_fiddles($user) {
			$url = 'http://jsfiddle.net/api/user/' . $user . '/demo/list.json?limit=999999&sort=framework&callback=Api';
			//$url = 'http://jsfiddle.net/api/user_shells/' . $user . '/';
			
			$headers = array("Content-Type: application/json");

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
			$reponse = curl_exec($ch);
			curl_close($ch);
			$return_val = json_decode($response);
			return $return_val;
		}

	}