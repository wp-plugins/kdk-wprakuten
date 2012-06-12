<form method="GET" action="#" id="itemSearchForm">
	<table id="media_rakuten_booksearch">
		<tr>
			<td><?php _e('Nome do livro','kdk-wprakuten');?></td>
			<td><input type="hidden" name="version" value="2011-12-01" /> <input
				type="text" name="title" value=""/></td>
			<td><?php _e('Autor','kdk-wprakuten')?></td>
			<td><input type="text" name="author" value="" /></td>
		</tr>
		<tr>
			<td><?php _e('Editora','kdk-wprakuten')?></td>
			<td><input type="text" name="publisherName" value="" /></td>
			<td><?php _e('ISBN','kdk-wprakuten')?></td>
			<td><input type="text" name="isbn" value="" /></td>
		</tr>
		<tr>
			<td><?php _e('Ordem','kdk-wprakuten');?></td>
			<td colspan="2"><select name="sort">
					<option value="standard">
						<?php _e('Padrao','kdk-wprakuten')?>
					</option>
					<option value="sales">
						<?php _e('Mais vendido','kdk-wprakuten')?>
					</option>
					<option value="+releaseDate">
						<?php _e('Data de lancamento (Antigo)','kdk-wprakuten')?>
					</option>
					<option value="-releaseDate">
						<?php _e('Data de lancamento (Novo)','kdk-wprakuten')?>
					</option>
					<option value="+itemPrice">
						<?php _e('Mais barato','kdk-wprakuten')?>
					</option>
					<option value="-itemPrice">
						<?php _e('Mais caro','kdk-wprakuten')?>
					</option>
					<option value="reviewCount">
						<?php _e('Mais comentarios','kdk-wprakuten')?>
					</option>
					<option value="reviewAverage">
						<?php _e('Mais comentarios (media)','kdk-wprakuten')?>
					</option>
			</select></td>
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
		console.log(JSON.stringify(requestParam, null, '\t'));
		$.itemSearch.setPager(
			data.Body.BooksBookSearch.count,
			data.Body.BooksBookSearch.page,
			data.Body.BooksBookSearch.pageCount,
			requestParam,
			opts
		);
		var ul = document.getElementById("itens");
		ul.innerHTML = '';
		var itens = data.Body.BooksBookSearch.Items.Item;
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
				'operation' : 'BooksBookSearch',
				'version' : '2011-12-01',
				'developerId' : 'feaeec38b8bc37411b14de274b1d9480',
				'hits': 30,
				'page' : 1,
				'availability' : 0,
				'outOfStockFlag' : 1,
				'chirayomiFlag' : 0,
				'sort':'+releaseDate',
				'limitedFlag' : 0,
				'carrier' : 0,
				'genreInformationFlag' : 0,
				'title':'',
				'author':'',
				'publisherName':'',
				'size': 0,
				'isbn' : '',
				'booksGenreId' : ''
			}
		}
	$.itemSearch.prepare($('#itemSearchForm'),defaults);

});
</script>
