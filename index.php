<?php
/*
 Plugin Name: Rakuten product
Plugin URI: http://www.kodokuman.com/
Description: Rakuten short tag plugin
Version: 0.3.2.1
Author: Johnathan David
Author URI: http://www.kodokuman.com/
License: GPLv2 or later
*/

include_once 'includes/RakutenShortTag.php';
include_once 'includes/MediaRakutenSearch.php';
include_once 'includes/RakutenSettingOption.php';
include_once 'includes/RakutenMediaTab.php';
include_once 'includes/IRakutenMediaTab.php';
include_once 'includes/RakutenItensTab.php';
include_once 'includes/RakutenBooksTab.php';

define ('KDK_WP_RAKUTEN_NAME','kdk-wprakuten');
define ('KDK_DEFAULT_AID', '0a30aaaf.afb9b1e2.0a30aab0.82880378');
define ('KDK_DEFAULT_DID', 'feaeec38b8bc37411b14de274b1d9480');

//languages
//echo $base_name = basename(plugin_dir_path(__FILE__));
load_plugin_textdomain( 'kdk-wprakuten', false, "kdk-wprakuten/languages/" );
load_plugin_textdomain( 'kdk-wprakuten-books', false, "kdk-wprakuten/languages/" );
load_plugin_textdomain( 'kdk-wprakuten-itens', false, "kdk-wprakuten/languages/" );

echo __('availability_0','kdk-wprakuten-books');

//古いコードを吸収するため
add_action('init', 'RakutenShortTag::register_rakuten_shorttag');
//add_filter('media_upload_tabs', 'MediaRakutenSearch::add_media_tab');

//オプション設定
add_action('admin_menu', 'RakutenSettingOption::add_page');
add_action('admin_init', 'RakutenSettingOption::admin_init');

add_action('wp_loaded', 'wprakuten_init');
function wprakuten_init () {
	//script cssの登録
	$css =  plugins_url(KDK_WP_RAKUTEN_NAME . "/css");
	wp_register_style( 'rakuten_product_template', "{$css}/rakuten_product_template.css" );
	wp_register_style( 'media_rakute', "$css/media_rakuten.css" );
	$js_path = plugins_url() . "/" .KDK_WP_RAKUTEN_NAME . "/js/";
	wp_register_script( 'rakuten-base-api', $js_path . 'RakutenItemSearch.js');
	wp_register_script( 'rakuten-paging', $js_path . 'paging.js');
	wp_register_script( 'rakuten-jquery-metadata', $js_path . 'jquery.metadata.js', array('jquery'));
	wp_register_script( 'rakuten-templates', $js_path . 'rakuten_template_tas.js', array('rakuten-jquery-metadata','rakuten-base-api'));

	$rakutenMediaTab = RakutenMediaTab::getInstance();
	$rakutenMediaTab->addTab(new RakutenItensTab());
	$rakutenMediaTab->addTab(new RakutenBooksTab());
}
?>