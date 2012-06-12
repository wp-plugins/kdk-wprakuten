<script type="text/javascript">
	jQuery(function($) {
		var pager;
		var PageClick;
		var searchParam;
		var is_request = false;
		$('#media_rakuten_search_form').submit(function() {
			$(this).find('input:not(:disabled)').each(function() {
				if ($(this).attr('type').toLowerCase() == "text") {
					if ($(this).val().trim() == "") {
						$(this).attr('disabled', 'disabled');
					}
				}
			});
			rakuteSearch($(this).serialize());
			return false;
		});

		function rakuteSearch(param) {
			if (!is_request) {
				$('#error').hide();
				searchParam = param;
				var $API_BASE_URL = "http://api.rakuten.co.jp/rws/3.0/json";
				is_request = true;
				loading(true);
				jQuery
						.ajax({
							url : $API_BASE_URL,
							data : param,
							dataType : 'jsonp',
							jsonp : 'callBack',
							complete : function(json) {
							},
							success : function(data, status) {
								is_request = false;
								loading(false);
								$(
										'#media_rakuten_search_form input[type=radio]:checked')
										.click();
								if (status == "success") {
									if (data.Header != undefined
											&& data.Header.Status.toLowerCase() == "success") {

										if (data.Header.Args.Arg.operation.value
												.toLowerCase() == "itemsearch") {
											var Item = data.Body.ItemSearch.Items.Item;
											setPager(
													data.Body.ItemSearch.count,
													data.Body.ItemSearch.page,
													data.Body.ItemSearch.pageCount);
											setNormalItens(Item);
										} else {
											var Item = data.Body.BooksBookSearch.Items.Item;
											setPager(
													data.Body.BooksBookSearch.count,
													data.Body.BooksBookSearch.page,
													data.Body.BooksBookSearch.pageCount);
											setBookItens(Item);
										}

									} else if (data.Header.Status.toLowerCase() == "clienterror")
									{
										$('#error').html(data.Header.StatusMsg).show();
									} else if (data.Header.Status.toLowerCase() == 'notfound') {
										$('#pager').html('<?php _e('Nao foi encontrado nenhum produto','kdk-wprakuten')?>');
									}
								}

							},
							beforeSend : function() {
							},
							error : function() {
							}
						});
			}
		}

		function setPager(count, page, pageCount) {
			PageClick = function(pageclickednumber) {
				if (!is_request) {
					var SearchString = "page=([0-9]+)";
					var RegularExp = new RegExp(SearchString, 'g');
					var res = searchParam.match(RegularExp);
					if (res == null) {
						searchParam += "&page=" + pageclickednumber;
					} else {
						searchParam = searchParam.replace(res, "page="
								+ pageclickednumber);
					}
					rakuteSearch(searchParam);
				}
			}
			$("#pager").pager({
				pagenumber : page,
				pagecount : pageCount,
				buttonClickCallback : PageClick
			});
			var found_msg = "<?php esc_html_e('Encontrados %d produto(s).','kdk-wprakuten')?>".replace(/%d/g,count);
			$('#page p').html(found_msg);
			$('#itens').empty();
		}

		function setBookItens(Item) {
			if (Item) {
				$.each(Item, function(product) {
					var product = this;
					var li = $('<li></li>');
					var img = $('<img />').attr('src', this.mediumImageUrl);
					var name = $('<div></div>').text(
							this.title + " : " + this.itemPrice);
					var button_container = $('<div></div>').addClass(
							'button_container');
					var add_post_button = $('<input />').attr('type', 'button')
							.val('<?php esc_attr_e('Inserir','kdk-wprakuten')?>');
					var add_post_button2 = $('<input />')
							.attr('type', 'button').val('<?php esc_attr_e('Inserir o codigo','kdk-wprakuten')?>');
//					button_container.append(add_post_button);
					button_container.append(add_post_button2);
					li.append(img);
					li.append(name);
					li.append(button_container);
					add_post_button.click(function() {
						var win = window.dialogArguments || opener || parent
								|| top;
						win.send_product(product);
					});
					add_post_button2.click(function() {
						var win = window.dialogArguments || opener || parent || top;
						win.send_to_editor('[rakuten isbn="'+product.isbn+'"]');
					});
					$('#itens').append(li);
				});
			}
		}

		function setNormalItens(Item) {
			if (Item) {
				$.each(Item, function(product) {
					var product = this;
					var li = $('<li></li>');
					var img = $('<img />').attr('src', this.mediumImageUrl);
					var name = $('<div></div>').text(
							this.itemName + " : " + this.itemPrice);
					var button_container = $('<div></div>').addClass(
							'button_container');
					var add_post_button = $('<input />').attr('type', 'button')
							.val('<?php esc_attr_e('Inserir','kdk-wprakuten')?>');
					var add_post_button2 = $('<input />')
							.attr('type', 'button').val('<?php esc_attr_e('Inserir o codigo','kdk-wprakuten')?>');
//					button_container.append(add_post_button);
					button_container.append(add_post_button2);
					li.append(img);
					li.append(name);
					li.append(button_container);
					add_post_button.click(function() {
						var win = window.dialogArguments || opener || parent
								|| top;
						win.send_product(product);
					});
					add_post_button2.click(function() {
						var win = window.dialogArguments || opener || parent || top;
						win.send_to_editor('[rakuten itemCode="'+product.itemCode+'"]');
					});
					$('#itens').append(li);
				});
			}
		}

		function loading (flg) {
			if (flg) {
				$('#shopping_url_button').attr('disabled', true);
				$('#shopping_url_button').hide();
				$('#loading_text').show();
			} else {
				$('#shopping_url_button').removeAttr('disabled');
				$('#shopping_url_button').show();
				$('#loading_text').hide();
			}
		}

		$('#media_rakuten_search_form input[type=text]').keyup(function(e) {
			if (e.keyCode == 13) {
				$('#media_rakuten_search_form').submit();
			}
		});

		$('#shopping_url_button').click(function (){
			$('#media_rakuten_search_form').submit();
		});

		$('#operation_table input[type=radio]')
				.click(
						function() {
							if (this.value == "BooksBookSearch") {
								$('#media_rakuten_itemsearch').fadeOut();
								$('#media_rakuten_booksearch').fadeIn();
								$(
										'#media_rakuten_booksearch input,#media_rakuten_booksearch select')
										.removeAttr('disabled');
								$(
										'#media_rakuten_itemsearch input,#media_rakuten_itemsearch select')
										.attr('disabled', 'disabled');
							} else {
								$('#media_rakuten_booksearch').fadeOut();
								$('#media_rakuten_itemsearch').fadeIn();
								$(
										'#media_rakuten_itemsearch input,#media_rakuten_itemsearch select')
										.removeAttr('disabled');
								$(
										'#media_rakuten_booksearch input,#media_rakuten_booksearch select')
										.attr('disabled', 'disabled');
							}
						});

		$(".rakuten_books_label input[type=radio]").click();

	});
</script>
<form method="GET" action="#" id="media_rakuten_search_form">
	<div id="error"></div>
	<input type="hidden" name="developerId"
		value="<?php echo KDK_DEFAULT_DID?>" /> <input type="hidden"
		name="affiliateId"
		value="<?php echo esc_attr($options['RakutenAffiliateId'])?>" />
	<table id="operation_table">
		<tr>
			<td><label class="rakuten_books_label"><input type="radio"
					name="operation" value="BooksBookSearch"> <?php _e('Pesquisar livros','kdk-wprakuten');?>
			</label></td>
			<td><label class="rakuten_item_label"><input type="radio"
					name="operation" value="ItemSearch"> <?php _e('Pesquisar itens','kdk-wprakuten');?>
			</label></td>
		</tr>
	</table>

	<table id="media_rakuten_itemsearch">
		<tr>
			<td><?php _e('Palavra chave','kdk-wprakuten')?></td>
			<td><input type="hidden" name="version" value="2010-09-15" /> <input
				type="text" name="keyword" />
			</td>
		</tr>
		<tr>
			<td><?php _e('Ordem','kdk-wprakuten');?></td>
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
			</select></td>
		</tr>
	</table>

	<table id="media_rakuten_booksearch">
		<tr>
			<td><?php _e('Nome do livro','kdk-wprakuten');?></td>
			<td><input type="hidden" name="version" value="2011-12-01" /> <input
				type="text" name="title" /></td>
			<td><?php _e('Autor','kdk-wprakuten')?></td>
			<td><input type="text" name="author" /></td>
		</tr>
		<tr>
			<td><?php _e('Editora','kdk-wprakuten')?></td>
			<td><input type="text" name="publisherName" /></td>
			<td><?php _e('ISBN','kdk-wprakuten')?></td>
			<td><input type="text" name="isbn" /></td>
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
		<input type="button" name="shopping_url_button"
			id="shopping_url_button"
			value="<?php esc_attr_e('Pesquisar','kdk-wprakuten')?>" />
		<div id="loading_text">
			<?php _e('Pesquisando....','kdk-wprakuten')?>
		</div>
	</div>
</form>
<div id="result">
	<div id="page">
		<p></p>
		<div id="pager"></div>
	</div>

	<ul id="itens">
	</ul>
</div>

