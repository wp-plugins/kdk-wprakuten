<?php

if (!defined('WP_PLUGIN_URL')) {
	$root_dir = basename(dirname(dirname(__FILE__)));
	if ($root_dir == "trunk") {
		require_once (realpath('../../../../'). '/Blog/wordpress/wp-config.php');
	} else {
		require_once (realpath('../../../../'). '/wp-config.php');
	}
}

$data = array();
$tpl = file_get_contents(dirname(dirname(__FILE__)) . '/tpls/kdk_rakuten.js.tpl');
echo RakutenShortTag::parse($tpl, $data);
?>

