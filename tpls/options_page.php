<div class="wrap">
	<?php screen_icon(); ?>
	<h2>
		<?php _e('Configuracao - Rakuten product')?>
	</h2>
	<form action="options.php" method="POST">
		<?php settings_fields('rakuten_product_options'); ?>
		<?php do_settings_sections('rakuten_product_option_page'); ?>
		<input name="Submit" type="submit" value="Save Changes" />
	</form>
</div>
