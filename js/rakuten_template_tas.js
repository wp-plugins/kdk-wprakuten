;
(function($) {
	$.fn.rakuten_templates = function() {
		$.metadata.setType("attr", "data");

		return this
				.each(function() {
					var opts = $.fn.rakuten_templates.defaults;
					var metadata = $.metadata.get(this);
					var self = this;
					if (metadata != undefined) {
						opts.param = metadata.param;
						opts.callBack = function(data, requestParam, opts) {
							for (i in metadata.display) {
								var operation = metadata.param.operation;
								var datas = metadata.display[i].split(",");
								var itens = data.Body[operation].Items.Item;
								if (itens.length > 0) {
									// alert(itens[0][datas]);
									// if (itens[0][datas]) {
									if ("rakuten_url" == i) {
										$(self).find("." + i)[0].href = itens[0][datas];
									} else if ("rakuten_photo" == i) {
										$(self).find("." + i)[0].src = itens[0][datas];
									} else {
										var target = $(self).find("." + i)[0];
										target.innerHTML = "";
										for (j in datas) {
											target.innerHTML += itens[0][datas[j]]
													+ " ";
										}
										// }
									}
								}

							}
							$(self).fadeIn();
						};
						$.itemSearch.do_serarchitem(opts);
					}

				});

	};

	$.fn.rakuten_templates.defaults = {
		// 'callBack' : setdata,
		'request_url' : 'http://api.rakuten.co.jp/rws/3.0/json',
		param : {}
	};
})(jQuery);

jQuery('.rakuten_product_main').rakuten_templates();