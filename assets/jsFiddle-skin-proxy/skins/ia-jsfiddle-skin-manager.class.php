<?php

	//theme manager class
	class IA_JSFiddle_Theme_Manager {
		
		var $dir, $skins;

		function get_themes() {
			$this->skins_dir = getcwd();
			$skins = array();
			foreach(glob('*', GLOB_ONLYDIR) as $dir) {
				$has_js = false;
				$active = false;
				if($sk = opendir($dir)) {
					while(($file = readdir($sk)) !== false) {
						$f_name = $file;
						$f_type = filetype($skin_dir . '/' . $dir . '/' . $file);
						$file_array[$f_type][] = $f_name;
					}
					foreach($file_array['dir'] as $key => $val) {
						if($val === 'js') {
							$has_js = true;
						}
					}
					foreach($file_array['file'] as $key => $val) {
						if($val === 'style.css') {
							$active = true;
						}
					}
					if($active) {
						$skins[$dir]['name'] = $dir;
						if($has_js) {
							$this->skins[$dir]['js'] = 'true';
						} else {
							$this->skins[$dir]['js'] = 'false';
						}
					}
					closedir($sk);
					$this->write_file();
				}
			}
		}

		function write_file() {
			$json = json_encode($this->skins);
			$filename = $this->skin_dir . '/jsfiddle-skins.json';
			$file = file_put_contents($filename,utf8_encode($json));
			chmod($filename,0755);
		}
	
	}

?>