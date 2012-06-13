<?php
/*
 * Class RakutenSettingsOptions
* プラグインのオプション設定
*/
Class RakutenSettingOption
{
	/**
	 * メニューの追加
	 */
	static public function add_page() {

		//ページの追加
		add_options_page(
				__('Rakuten product'),
				__('Rakuten product'),
				'manage_options',
				'rakuten_product_option_page',
				'RakutenSettingOption::options_page'
		);

		register_setting(
				'rakuten_product_options',
				'rakuten_product_options',
				'RakutenSettingOption::validate_options'
		);



	}

	static public function admin_init()
	{
		add_settings_section( 'rakuten_product_main_section', __('Configuracao'), 'RakutenSettingOption::section_text', 'rakuten_product_option_page' );
		add_settings_field( 'RakutenAffiliateId', __('Rakuten affiliate id'), 'RakutenSettingOption::setting_affiliate_id_input', 'rakuten_product_option_page', 'rakuten_product_main_section' );
	}

	static public function section_text ()
	{
		echo '<p>' . __('Rakuten api settings') . '</p>';
	}

	static public function setting_affiliate_id_input ()
	{
		$defaults = array(
				'RakutenAffiliateId' => KDK_DEFAULT_AID,
		);
		$options = get_option( 'rakuten_product_options', $defaults);
		$text_string = $options['RakutenAffiliateId'];
		// echo the field
		?>
<input
	id='rakuten_affiliate_id'
	name='rakuten_product_options[RakutenAffiliateId]' type='text'
	value='<?php echo esc_attr($text_string)?>' size='35' />
<small> <em> <?php _e('Se tiver o affiliate id do Rakuten digite porfavor.')?>
		<?php printf(__('Mais detalhes %s'),'<a href="http://affiliate.rakuten.co.jp/" targer="_blank">http://affiliate.rakuten.co.jp/</a>')?>
</em>
</small>
<?php }



static public function validate_options($input) {
	return $input;
}

static function options_page() {
	require_once (dirname(dirname(__FILE__)) . "/tpls/options_page.php");
}
}

?>