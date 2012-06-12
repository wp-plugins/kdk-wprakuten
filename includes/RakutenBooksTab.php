<?php
class RakutenBooksTab implements IRakutenMediaTab {

	function getName()
	{
		return __('Pesquisa de livros');
	}

	public function getFields()
	{
		return array();
	}

	public function content() {
		include_once dirname(dirname(__FILE__)) . "/tpls/rakuten_books_search.php";
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