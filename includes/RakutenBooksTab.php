<?php
class RakutenBooksTab implements IRakutenMediaTab {

	function getName()
	{
		return __('Pesquisa de livros');
	}

	public function getFields()
	{
		return array(
				'__developerId' => '%%%RAKUTEN%%%DEV_ID%%%',
				'__affiliateId' => '%%%RAKUTEN%%%AFF_ID%%%',
				'__operation' => 'BooksBookSearch',
				'__version' => '2011-12-01',
				'__hits'=> 30,
				'__page' => 1,
				'__availability' => array(0,1),
				'outOfStockFlag' => array(1,0),
				'chirayomiFlag' => array(0,1),
				'sort'=>array(
						'standard',
						'sales',
						'+releaseDate',
						'-releaseDate',
						'+itemPrice',
						'-itemPrice',
						'reviewCount',
						'reviewAverage'
				),
				'limitedFlag' => array(0,1),
				'__carrier' => array(0,1),
				'__genreInformationFlag' => 0,
				'title'=>'',
				'author'=>'',
				'publisherName'=>'',
				'size'=> array(0,1,2,3,4,5,6,7,8,9,10),
				'isbn' => '',
				'booksGenreId' => ''
		);
	}

	public function displayFields() {
		return array(
				'id'    => 'isbn',
				'catchcopy' => 'contents',
				'description'=>'itemCaption',
				'shopName' => 'publisherName,author',
				'shopCode' => 'shopCode',
				'shopUrl' => 'shopUrl',
				'imageFlag'  => 'imageFlag',
				'imageUrl' => 'mediumImageUrl',
				'thumbUrl' => 'smallImageUrl',
				'title' => 'title,subTitle',
				'price' => 'itemPrice',
				'salePrice' => 'listPrice',
				'affiliateUrl' => 'affiliateUrl',
				'url' => 'itemUrl',
				'affiliateRate' => 'affiliateRate',
				'reviewCount' => 'reviewCount',
				'reviewAverage' => 'reviewAverage',
				'other' => array(
						'availability',
						'chirayomiUrl',
						'postageFlag',
						'limitedFlag',
						'booksGenreId'

				)
		);
	}

	public function shortCodeName() {
		return 'rakuten_book';
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
		$metadata['operation'] = 'BooksBookSearch';
		$metadata['version'] = '2011-12-01';
		$metadata['developerId'] = apply_filters('rakuten_str_replace','%%%RAKUTEN%%%DEV_ID%%%');
		$metadata['affiliateId'] = apply_filters('rakuten_str_replace','%%%RAKUTEN%%%AFF_ID%%%');

		$get_data['rakuten_title'] = $display_fields['title'];
		$get_data['rakuten_price'] = $display_fields['price'];
		$get_data['rakuten_description'] = $display_fields['description'];
		$get_data['rakuten_url'] = $display_fields['affiliateUrl'];
		$get_data['rakuten_photo'] = $display_fields['imageUrl'];

		$json = json_encode(array('param'=>$metadata,'display'=>$get_data));

		return str_replace("[+rakuten_jsondata+]", $json, $template);


	}

	public function __toString()
	{
		return "kdk-wprakuten-books";
	}
}