<?php
/**
 * Class Rakuten short tags
 */
class RakutenShortTag {
	//コードの登録
	static function register_rakuten_shorttag () {
		add_shortcode('rakuten', 'RakutenShortTag::get_tag'); //[rakuten ]コード登録
	}

	static function get_tag ($raw_args, $content=null) {

		$defaults = array (
				'itemcode' => '',
				'isbn' => ''
		);

		$spanitized_args = shortcode_atts($defaults, $raw_args); //コードの属性を取得
		if (empty($spanitized_args['itemcode']) && empty($spanitized_args['isbn'])) {
			return '';
		}

		//javascriptの登録！
		$src = plugins_url() . '/' . KDK_WP_RAKUTEN_NAME . '/js/kdk_rakuten.jquery.js.php';
		wp_register_script(__CLASS__, $src);
		wp_enqueue_script('jquery');
		wp_enqueue_script(__CLASS__);

		$defaults = array(
				'RakutenAffiliateId' => KDK_DEFAULT_AID,
		);
		// get option 'text_string' value from the database
		$options = get_option( 'rakuten_product_options', $defaults);

		$param['developerId'] = KDK_DEFAULT_DID;
		$param['affiliateId'] = $options['RakutenAffiliateId'];
		if(!empty($spanitized_args['itemcode'])) {
			$param['operation'] = "ItemCodeSearch";
			$param['version'] = "2010-08-05";
			$param['itemCode'] = $spanitized_args['itemcode'];
		} else {
			$param['operation'] = "BooksBookSearch";
			$param['version'] = "2011-12-01";
			$param['isbn'] = $spanitized_args['isbn'];
		}

		$data['itemcode'] = json_encode($param);
		$tpl = file_get_contents(dirname(dirname(__FILE__)) . '/tpls/short_code.tpl'); //テンプレートを読み込む
		return RakutenShortTag::parse($tpl, $data); //テンプレートのパース
	}

	static function parse ($tpl, $hash) {
		foreach ($hash as $key => $value) {
			$tpl = str_replace('[+'.$key.'+]', $value, $tpl);
		}
		return $tpl;
	}

}
?>