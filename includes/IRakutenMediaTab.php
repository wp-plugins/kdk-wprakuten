<?php
interface IRakutenMediaTab
{
	public function getName();
	public function getFields();
	public function content();
	public function shortCodeNames();
	public function doShortcode($raw_args, $content=null);
}