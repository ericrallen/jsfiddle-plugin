<?php

	//class for jsfiddle plug-in
	class IA_JSFiddle {

		var $user, $fiddle, $height, $width, $show, $output;

		private function __construct($u = null,array $f = null,$h = null,$w = null,$s = null) {
			if($u && $f) {
				$this->user = $u;
				$this->fiddle = $f;
				if($h) {
					$this->height = $h;
				} else {
					$this->height = '300px';
				}
				if($w) {
					$this->width = $w;
				} else {
					$this->width = '100%';
				}
				if($s) {
					$this->show = $s;
				} else {
					$this->show = 'js,resources,htmlcss,result';
				}
				$this->get_user_name();
			} else {
				return false;
			}
		}

		private function get_user_name() {
			if($this->user) {
				$user_name = get_usermeta($this->user,'iajsfiddle',true);
				$this->fiddle['user'] = $user_name;
			}
		}

		public function get_fiddle() {
			$this->output = '';
			$this->output .= '<iframe style="width: ' . $this->width . '; height: ' . $this->height . ';" src="http://jsfiddle.net/' . $this->fiddle['user'] . '/' . $this->fiddle['key'] . '/embedded/ allowfullscreen="allowfullscreen" frameborder="0"></iframe>';
			return $this->output;
		}

	}

?>