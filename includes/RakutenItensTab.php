<?php
class RakutenItensTab implements IRakutenMediaTab {
	function getName()
	{
		return __('Pesquisa de produtos');
	}

	public function getFields() {
		return array(
				//デベロッパーID
				'developerId' => '%%%RAKUTEN%%%DEV_ID%%%',
				//アフィリエイトID
				'affiliateId' => '%%%RAKUTEN%%%AFF_ID%%%',
				//操作
				'operation' => 'ItemSearch',
				//検索キーワード
				'keyword' => null,
				//バージョン
				'version' => '2010-09-15',
				//ショップコード
				'shopCode' => null,
				//ジャンルID
				'genreId' => null,
				//1ページあたりの取得件数
				'hits' => 30,
				//取得ページ
				'page' => 1,
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
				'minPrice' => 0,
				'maxPrice' => null,
				'availability' => array(0,1),
				'field' => array(0,1),
				'carrier' => array(0,1),
				'imageFlag' => array(0,1),
				'orFlag' => array(0,1),
				'NGKeyword' => null,
				'genreInformationFlag' => array(0,1),
				'purchaseType' => array(0,1,2),
				'shipOverseasFlag' => array(0,1),
				'shipOverseasArea' => null,
				'asurakuFlag' => array(0,1),
				'asurakuArea' => null,
				'pointRateFlag' => array(0,1),
				'pointRate' => array(2,3,4,5,6,7,8,9,10),
				'postageFlag' => array(0,1),
				'creditCardFlag' => array(0,1)
		);
	}

	public function content() {
		include_once dirname(dirname(__FILE__)) . "/tpls/rakuten_item_search.php";
	}


	public function shortCodeNames() {
		return array('rakute_item');
	}

	public function doShortcode($raw_args, $content=null)
	{

	}

	public function __toString()
	{
		return "default";
	}
}