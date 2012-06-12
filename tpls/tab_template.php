<form method="GET" action="#" id="itemSearchForm">
	<h3>
		<?php echo $tab->getName()?>
	</h3>
	<table>
		<tr>
			<?php
			$lines = 1;
			foreach ($fields as $k => $value) :
			if (strpos($k, '__') !== false) {
				$name = ereg_replace('^__', "", $k);
				if (empty($value))
					continue;

				$val = "";
				if (!is_array($value)) {
					$val = $value;
				} else if (current($value) !== false) {
					$val = current($value);
				}
				echo '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($val) .'" />';
				continue;
			}
			?>
			<td><label for="label_<?php echo esc_attr($k)?>"><?php esc_html_e($k)?>
			</label></td>

			<?php if (!is_array($value)) :?>

			<td><input id="label_<?php echo esc_attr($k)?>" type="text"
				name="<?php echo ereg_replace('^_+', "",esc_attr($k))?>"
				value="<?php echo esc_attr($value) ?>" /></td>

			<?php else :?>

			<td><?php if (count($value) > 2) :?> <select
				id="label_<?php echo esc_attr($k)?>"
				name="<?php echo esc_attr($k) ?>">
					<?php foreach ($value as $option) :?>
					<option value="<?php echo esc_attr($option)?>">

						<?php esc_html_e($option)?>

					</option>
					<?php endforeach;?>
			</select> <?php else :?> <?php foreach ($value as $option) :?> <label><?php esc_html_e($option)?>
					<input type="radio" name="<?php echo esc_attr($k)?>"
					value="<?php echo esc_attr($option)?>" /> </label> <?php endforeach;?>
				<?php endif;?></td>
			<?php endif?>

			<?php if ($lines % 2 == 0) :?>
		</tr>
		<tr>
			<?php endif ;?>
			<?php
			$lines++;
			endforeach;
			?>
		</tr>
	</table>
	<div class="kdk_button">
		<input type="submit" name="shopping_url_button"
			id="shopping_url_button"
			value="<?php esc_attr_e('Pesquisar','kdk-wprakuten')?>" />
		<div id="loading_text">
			<?php _e('Pesquisando....','kdk-wprakuten')?>
		</div>
	</div>
</form>
<div id="page">
	<p></p>
	<div id="pager"></div>
</div>
<ul id="itens">
</ul>
<script type="text/javascript">
jQuery(function ($) {
	var callback = function(data,requestParam,opts) {
		$.itemSearch.setPager(
			data.Body.<?php echo $fields['__operation']?>.count,
			data.Body.<?php echo $fields['__operation']?>.page,
			data.Body.<?php echo $fields['__operation']?>.pageCount,
			requestParam,
			opts
		);
		var ul = document.getElementById("itens");
		ul.innerHTML = '';
		var itens = data.Body.<?php echo $fields['__operation']?>.Items.Item;
		$.each(itens, function(i, item) {
			if (i % 2 == 0)
				var li = "<li class='list1'>";
			else
				var li = "<li class='list2'>";

			 li += "<img src='" + item.<?php echo $display_fields['imageUrl']?> + "' />";

			 li += "<p class='title'>"+<?php echo RakutenMediaTab::pser_field( $display_fields['title'] , 'item') ?>+"</p>";

			 li += "<p class='price'>&yen;"+<?php echo RakutenMediaTab::pser_field( $display_fields['price'] , 'item') ?>+"</p>";

			 li += "<button value='<?php esc_attr_e("Add code")?>'><?php esc_attr_e("Add code")?></button>";

			 li += "</li>";
			 ul.innerHTML += li;
		});
	}

	var defaults = {
			callBack: callback,
			'pager' : 'pager',
			'request_url' : 'http://api.rakuten.co.jp/rws/3.0/json',
			param : {
				<?php foreach ($fields as $k => $v) :?>
					<?php echo ereg_replace('^_+', "", $k)?> : '<?php echo is_array($v) ? current($v) : $v?>',
				<?php endforeach;?>
			}
		}
	$.itemSearch.prepare($('#itemSearchForm'),defaults);

});
</script>