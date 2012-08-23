<?php

require_once dirname(__FILE__) . '/jsfiddle-skin-proxy.php';

try {
	echo jsfiddle_skin_proxy::process($_GET['id'], $_GET['skindir'], isset($_GET['result']), (isset($_GET['tabs']) ? $_GET['tabs'] : 'js,html,css,result'), (isset($_GET['skin']) ? $_GET['skin'] : 'default'));
} catch (Exception $e) {
	// invalid id
}

?>