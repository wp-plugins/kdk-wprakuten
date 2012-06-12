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

	public function shortCodeNames() {
		return array('rakuten_book');
	}

	public function doShortcode($raw_args, $content=null)
	{

	}

	public function __toString()
	{
		return "RakutenBooksTab";
	}
}