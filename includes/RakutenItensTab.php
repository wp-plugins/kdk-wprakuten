<?php
class RakutenItensTab implements IRakutenMediaTab {
	function getName()
	{
		return __('Pesquisa de produtos');
	}

	public function getFields() {
		return array(
				//デベロッパーID
				'__developerId' => '%%%RAKUTEN%%%DEV_ID%%%',
				//アフィリエイトID
				'__affiliateId' => '%%%RAKUTEN%%%AFF_ID%%%',
				//操作
				'__operation' => 'ItemSearch',
				//検索キーワード
				'keyword' => null,
				//バージョン
				'__version' => '2010-09-15',
				//ショップコード
				'_shopCode' => null,
				//ジャンルID
				'__genreId' => null,
				//1ページあたりの取得件数
				'__hits' => 30,
				//取得ページ
				'__page' => 1,
				//ソート
				'sort' => array(
						'+affiliateRate',
						'-affiliateRate',
						'+reviewCount',
						'-reviewCount',
						'+reviewAverage',
						'-reviewAverage',
						'+itemPrice',
						'-itemPrice',
						'+updateTimestamp',
						'-updateTimestamp',
						'standard'
				),
				'__minPrice' => 0,
				'__maxPrice' => null,
				'__availability' => array(0,1),
				'__field' => array(0,1),
				'__carrier' => array(0,1),
				'__imageFlag' => array(0,1),
				'__orFlag' => array(0,1),
				'__NGKeyword' => null,
				'__genreInformationFlag' => array(0,1),
				'__purchaseType' => array(0,1,2),
				'__shipOverseasFlag' => array(0,1),
				'__shipOverseasArea' => null,
				'__asurakuFlag' => array(0,1),
				'__asurakuArea' => null,
				'__pointRateFlag' => array(0,1),
				'__pointRate' => array('',2,3,4,5,6,7,8,9,10),
				'__postageFlag' => array(0,1),
				'__creditCardFlag' => array(0,1)
		);
	}

	public function displayFields() {
		return array(
				'id'    => 'itemCode',
				'catchcopy' => 'catchcopy',
				'description'=>'itemCaption',
				'shopName' => 'shopName',
				'shopCode' => 'shopCode',
				'shopUrl' => 'shopUrl',
				'imageFlag'  => 'imageFlag',
				'imageUrl' => 'mediumImageUrl',
				'thumbUrl' => 'smallImageUrl',
				'title' => 'itemName',
				'price' => 'itemPrice',
				'salePrice' => '',
				'affiliateUrl' => 'affiliateUrl',
				'url' => 'itemUrl',
				'affiliateRate' => 'affiliateRate',
				'reviewCount' => 'reviewCount',
				'reviewAverage' => 'reviewAverage',
				'other' => array(
						'availability',
						'taxFlag',
						'postageFlag',
						'creditCardFlag',
						'shopOfTheYearFlag',
						'shipOverseasFlag',
						'shipOverseasArea',
						'asurakuFlag',
						'asurakuArea',
						'affiliateRate',
						'startTime',
						'endTime',
						'pointRate',
						'pointRateStartTime',
						'pointRateEndTime',
						'genreId'

				)
		);
	}


	public function shortCodeName() {
		return 'rakute_item';
	}

	public function doShortcode($raw_args, $content=null)
	{
		wp_enqueue_script( 'jquery' );
		$template = apply_filters("rakuten_template","template1");
		$codeName = $this->shortCodeName();

		$defaults = array (
				'id' => '',
		);
		$spanitized_args = shortcode_atts($defaults, $raw_args);

		if (empty($spanitized_args['id']))
			return '';

		$display_fields = $this->displayFields();

		$metadata[$display_fields['id']] = $spanitized_args['id'];
		$metadata['operation'] = 'ItemCodeSearch';
		$metadata['version'] = '2010-08-05';
		$metadata['developerId'] = apply_filters('rakuten_str_replace','%%%RAKUTEN%%%DEV_ID%%%');
		$metadata['affiliateId'] = apply_filters('rakuten_str_replace','%%%RAKUTEN%%%AFF_ID%%%');

		$get_data['rakuten_title'] = $display_fields['title'];
		$get_data['rakuten_price'] = $display_fields['price'];
		$get_data['rakuten_description'] = $display_fields['description'];
		$get_data['rakuten_url'] = $display_fields['affiliateUrl'];
		$get_data['rakuten_photo'] = $display_fields['imageUrl'];
		$json = json_encode(array('param'=>$metadata,'display'=>$get_data));
		$template = str_replace("[+rakuten_jsondata+]", $json, $template);
		return $template;
	}

	public function __toString()
	{
		return "kdk-wprakuten-itens";
	}
}