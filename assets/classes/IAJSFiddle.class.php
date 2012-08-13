<?php

	//class for jsfiddle plug-in
	class IA_JSFiddle {

		var $fiddle, $height, $width, $show, $skin, $output;

		public function __construct(array $f = null,$h = null,$w = null,$s = null,$sk = null) {
			if($f) {
				$this->fiddle = $f;
				if($h != null) {
					$this->height = $h;
				} else {
					$this->height = '300px';
				}
				if($w != null) {
					$this->width = $w;
				} else {
					$this->width = '100%';
				}
				if($s != null) {
					$this->show = $s;
				} else {
					$this->show = 'js,resources,html,css,result';
				}
				if($sk != null) {
					$this->skin = $sk;
				} else {
					$this->skin = 'default';
				}
			} else {
				return false;
			}
		}

		public function get_fiddle() {
			$this->output = '';
			$show_string = '';
			$show_string = substr($show_string,0,-1);
			if($this->skin && $this->skin !== 'default') {
				$this->output .= '<iframe style="width: ' . $this->width . '; height: ' . $this->height . ';" src="' . plugins_url() . '/jsfiddle-plugin/assets/jsFiddle-skin-proxy/?id=' . $this->fiddle['code'] . '&tabs=' . $this->show .'&skindir=' . get_option('ia_jsfiddle_skins_dir') . '&skin=' . $this->skin . '" allowfullscreen="allowfullscreen" frameborder="0"></iframe>';
			} else {
				$this->output .= '<iframe style="width: ' . $this->width . '; height: ' . $this->height . ';" src="http://jsfiddle.net/' . $this->fiddle['user'] . '/' . $this->fiddle['code'] . '/embedded/' . $this->show . '" allowfullscreen="allowfullscreen" frameborder="0"></iframe>';
			}
			return $this->output;
		}

	}

?>