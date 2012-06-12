<form method="GET" action="#" id="itemSearchForm">
	<input type="hidden" name="developerId"
		value="<?php echo KDK_DEFAULT_DID?>" /> <input type="hidden"
		name="affiliateId"
		value="<?php echo esc_attr($options['RakutenAffiliateId'])?>" />
	<h3 class="media-title">楽天商品検索</h3>
	<table>
		<tr>
			<td><?php _e('Palavra chave','kdk-wprakuten')?>
			</td>
			<td><input type="hidden" name="version" value="2010-09-15" /> <input
				type="text" name="keyword" /></td>
		</tr>
		<tr>
			<td><?php _e('Ordem','kdk-wprakuten');?>
			</td>
			<td><select name="sort">
					<option value="+affiliateRate">
						<?php _e('Taxas de afiliados (ascendente)','kdk-wprakuten');?>
					</option>
					<option value="-affiliateRate">
						<?php _e('Taxas de afiliados (decrescente)','kdk-wprakuten');?>
					</option>
					<option value="+reviewCount">
						<?php _e('Comentarios (ascendente)','kdk-wprakuten');?>
					</option>
					<option value="-reviewCount">
						<?php _e('Comentarios (decrescente)','kdk-wprakuten');?>
					</option>
					<option value="+reviewAverage">
						<?php _e('Media de comentarios (ascendente)','kdk-wprakuten');?>
					</option>
					<option value="-reviewAverage">
						<?php _e('Media de comentarios (decrescente)','kdk-wprakuten');?>
					</option>
					<option value="+itemPrice">
						<?php _e('Preco (ascendente)','kdk-wprakuten');?>
					</option>
					<option value="-itemPrice">
						<?php _e('Preco (decrescente)','kdk-wprakuten');?>
					</option>
					<option value="+updateTimestamp">
						<?php _e('Data de atualizacao (ascendente)','kdk-wprakuten');?>
					</option>
					<option value="-updateTimestamp">
						<?php _e('Data de atualizacao (decrescente)','kdk-wprakuten');?>
					</option>
					<option value="standard">
						<?php _e('Padrao do Rakuten','kdk-wprakuten');?>
					</option>
			</select>
			</td>
		</tr>
	</table>
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
		console.log(JSON.stringify(requestParam, null, '\t'));
		$.itemSearch.setPager(
			data.Body.ItemSearch.count,
			data.Body.ItemSearch.page,
			data.Body.ItemSearch.pageCount,
			requestParam,
			opts
		);
		var ul = document.getElementById("itens");
		ul.innerHTML = '';
		var itens = data.Body.ItemSearch.Items.Item;
		$.each(itens, function(i, item) {
			 var li = "<li>";
			 li += "<img src='" + item.mediumImageUrl + "' />";
			 li += "</li>";
			 ul.innerHTML += li;
		});
	}

	var defaults = {
			callBack: callback,
			'pager' : 'pager',
			'request_url' : 'http://api.rakuten.co.jp/rws/3.0/json',
			param : {
				'version' : '2010-09-15',
				'operation' : 'ItemSearch',
				'developerId' : 'feaeec38b8bc37411b14de274b1d9480',
				'keyword' : null,
				'shopCode' : null,
				'genreId' : null,
				'hits' : 30,
				'page' : 1,
				'sort' : '+affiliateRate',
				'minPrice' : 0,
				'maxPrice' : null,
				'availability' : 0,
				'field' : 0,
				'carrier' : 0,
				'imageFlag' : 0,
				'orFlag' : null,
				'NGKeyword' : null,
				'genreInformationFlag' : 0,
				'purchaseType' : 0,
				'shipOverseasFlag' : 0,
				'shipOverseasArea' : null,
				'asurakuFlag' : 0,
				'asurakuArea' : null,
				'pointRateFlag' : 0,
				'pointRate' : 0,
				'postageFlag' : 0,
				'creditCardFlag' : 0
			}
		}
	$.itemSearch.prepare($('#itemSearchForm'),defaults);

});
</script>
