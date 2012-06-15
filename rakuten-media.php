<?php
define('IFRAME_REQUEST' , true);
if (!defined('WP_PLUGIN_URL')) {
	$root_dir = basename(dirname(dirname(dirname(__FILE__))));
	if ($root_dir == "wp-plugins") {
//		define('WP_PLUGIN_URL', '/var/www/mnt/wp-plugins');
		$wp_load_path = realpath('../../../'). '/Blog/wordpress/wp-load.php';
		require_once ($wp_load_path);
		//		$wp_load_path = realpath('../../../'). '/Blog/wordpress/wp-admin/includes/admin.php';
		//		require_once ($wp_load_path);
	} else {
		$wp_load_path = realpath('../../../'). '/wp-load.php';
		require_once ($wp_load_path);
		//		$wp_load_path = realpath('../../../'). '/wp-admin/includes/admin.php';
		//		require_once ($wp_load_path);
	}
}

if (!current_user_can('upload_files'))
	wp_die(__('You do not have permission to upload files.'));

$rakutenMediaTab = RakutenMediaTab::getInstance();

wp_enqueue_script('plupload-handlers');
wp_enqueue_script('image-edit');
wp_enqueue_script('set-post-thumbnail' );
wp_enqueue_style('imgareaselect');

@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
$post_id = isset($_REQUEST['post_id'])? (int) $_REQUEST['post_id'] : 0;


if ( isset($_GET['tab']) )
	$tab = strval($_GET['tab']);
else
	$tab = 'kdk-wprakuten-itens';

$rakutenMediaTab->do_action($tab);
// if ( $tab == 'type' || $tab == 'type_url' || ! array_key_exists( $tab , $rakutenMediaTab->media_rakuten_tabs() ) ) {
// 	do_action("media_rakuten_$type");
// }else {
// 	do_action("media_rakuten_$tab");
// }
?>
