<?php
/**
 * Class Rakuten Media Search
 */

class MediaRakutenSearch {
	static function add_meta_box ()
	{
	}

	/**
	 *
	 * @param array $tabs
	 * @return array
	 */
	static function add_media_tab( $tabs )
	{
		$newtab = array('rakuten_insert_tab' => __('Rakuten','kdk-wprakuten'));
		add_action('media_upload_rakuten_insert_tab', 'MediaRakutenSearch::media_tab_content');
		return array_merge($tabs,$newtab);
	}

	static function media_tab_content ()
	{
		$css =  plugins_url(KDK_WP_RAKUTEN_NAME . "/css/media_rakuten.css");
		$js =  plugins_url(KDK_WP_RAKUTEN_NAME . "/js/paging.js");
		wp_register_style( 'media_rakuten_search_form-style', $css );
		wp_enqueue_style( 'media_rakuten_search_form-style' );
		wp_register_script('paging',$js);
		wp_enqueue_script('paging');
		return wp_iframe(array('MediaRakutenSearch','media_rakuten_search_form'));
	}

	/**
	 * @param unknown_type $type
	 * @param unknown_type $errors
	 * @param unknown_type $id
	 */
	static public function media_rakuten_search_form ($type = null, $errors = null, $id = null) {

		media_upload_header();
		$defaults = array(
				'RakutenAffiliateId' => KDK_DEFAULT_AID,
		);
		$options = get_option( 'rakuten_product_options', $defaults);
		require_once dirname(dirname(__FILE__)) . '/tpls/media_tab_content.php';
	}
}
?>