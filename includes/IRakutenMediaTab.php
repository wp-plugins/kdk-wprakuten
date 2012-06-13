<?php
interface IRakutenMediaTab
{
	public function getName();
	public function getFields();
	public function displayFields();
	public function shortCodeName();
	public function doShortcode($raw_args, $content=null);
}