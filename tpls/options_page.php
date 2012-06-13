<?php
// フィールドと設定項目名のための変数
$opt_name = 'rakuten_product_options';

$hidden_field_name = 'rakuten_product_options_hidden';

$defaults = array(
		'RakutenAffiliateId' => KDK_DEFAULT_AID,
);

$image_path = plugins_url() . "/" . KDK_WP_RAKUTEN_NAME . "/images/";

// データベースから既存の設定値を読み込む
$opt_val = get_option( $opt_name , $defaults);

// ユーザが何かの情報を投稿したかどうかをチェックする
// 投稿していれば、このhiddenフィールドの値は'Y'にセットされる
if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
	// 投稿された値を読む
	$opt_val = $_POST[ $opt_name ];

	// データベースに値を設定する
	update_option( $opt_name, $opt_val );

	// 画面に更新されたことを伝えるメッセージを表示

	?>
<div class="updated">
	<p>
		<strong><?php _e('Options saved.'); ?> </strong>
	</p>

	<?php

}

// 設定変更画面を表示する

echo '<div class="wrap">';

// ヘッダー

echo "<h2>" . __( 'Menu Test Plugin Options' ) . "</h2>";

// 設定用フォーム
wp_enqueue_style( 'rakuten_product_template' );
?>
	<form name="form1" method="post"
		action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="<?php echo $hidden_field_name; ?>"
			value="Y">

		<p>
			<?php _e("Rakuten affiliate ID:"); ?>
			<input type="text" name="rakuten_product_options[RakutenAffiliateId]"
				value="<?php echo esc_attr($opt_val["RakutenAffiliateId"]); ?>"
				size="50">
		</p>
		<div>
			<p>
				<?php _e("Exemplo"); ?>
			</p>

			<div id="rakuten_product_template1">
				<?php require_once 'template1_tag.html';?>
			</div>
		</div>
		<hr />

		<p class="submit">
			<input type="submit" name="Submit"
				value="<?php _e('Update Options') ?>" />
		</p>

	</form>
</div>
<?php wp_enqueue_scripts('jquery')?>
<script type="text/javascript">
jQuery(function ($){
	$('.rakuten_product_main').fadeIn();
})(jQuery)
</script>
