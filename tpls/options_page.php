<?php
$opt_name = 'rakuten_product_options';

$hidden_field_name = 'rakuten_product_options_hidden';

$defaults = array(
		'RakutenAffiliateId' => KDK_DEFAULT_AID,
);

$image_path = plugins_url() . "/" . KDK_WP_RAKUTEN_NAME . "/images/";

$opt_val = get_option( $opt_name , $defaults);

if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {

	$opt_val = $_POST[ $opt_name ];

	update_option( $opt_name, $opt_val );

	?>
<div class="updated">
	<p>
		<strong><?php _e('Options saved.', 'kdk-wprakuten' ); ?> </strong>
	</p>

	<?php

}


echo '<div class="wrap">';

echo "<h2>" . __( 'Rakuten product options', 'kdk-wprakuten' ) . "</h2>";


wp_enqueue_style( 'rakuten_product_template' );
?>
	<form name="form1" method="post"
		action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="<?php echo $hidden_field_name; ?>"
			value="Y">

		<p>
			<?php _e("Rakuten affiliate ID:", 'kdk-wprakuten' ); ?>
			<input type="text" name="rakuten_product_options[RakutenAffiliateId]"
				value="<?php echo esc_attr($opt_val["RakutenAffiliateId"]); ?>"
				size="50">
		</p>
		<div>
			<p>
				<?php _e("Exemplo", 'kdk-wprakuten' ); ?>
			</p>

			<div id="rakuten_product_template1">
				<?php require_once 'template1_tag.html';?>
			</div>
		</div>
		<hr />

		<p class="submit">
			<input type="submit" name="Submit"
				value="<?php _e('Update Options', 'kdk-wprakuten' ) ?>" />
		</p>

	</form>
</div>
<?php wp_enqueue_scripts('jquery')?>
<script type="text/javascript">
jQuery(function ($){
	$('.rakuten_product_main').fadeIn();
})(jQuery)
</script>
