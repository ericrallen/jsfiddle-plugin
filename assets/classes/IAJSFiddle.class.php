<?php

	//class for jsfiddle plug-in
	class IA_JSFiddle {

		var $fiddle, $height, $width, $show, $output;

		public function __construct(array $f = null,$h = null,$w = null,$s = null) {
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
			} else {
				return false;
			}
		}

		public function get_fiddle() {
			$this->output = '';
			$show_string = '';
			$show_string = substr($show_string,0,-1);
			$this->output .= '<iframe style="width: ' . $this->width . '; height: ' . $this->height . ';" src="http://jsfiddle.net/' . $this->fiddle['user'] . '/' . $this->fiddle['code'] . '/embedded/' . $this->show . '" allowfullscreen="allowfullscreen" frameborder="0"></iframe>';
			return $this->output;
		}

	}

?>