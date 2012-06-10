<?php
/*
Plugin Name: Rakuten product
Plugin URI: http://www.kodokuman.com/
Description: Rakuten short tag plugin
Version: 0.2
Author: Johnathan David
Author URI: http://www.kodokuman.com/
License: GPLv2 or later
*/

include_once 'includes/RakutenShortTag.php';
include_once 'includes/MediaRakutenSearch.php';

define ('KDK_WP_RAKUTEN_NAME','kdk-wprakuten');


//languages
//echo $base_name = basename(plugin_dir_path(__FILE__));
$res = load_plugin_textdomain( 'kdk-wprakuten', false, "kdk-wprakuten/languages/" );

add_action('init', 'RakutenShortTag::register_rakuten_shorttag');
add_filter('media_upload_tabs', 'MediaRakutenSearch::add_media_tab');


?>