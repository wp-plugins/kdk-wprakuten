;
(function($) {
	$.fn.itemSearch = function(option) {
		var opts = $.extend({}, $.fn.itemSearch.defaults, option);
		this.each(function() {
			$(this).submit(
					function() {
						var param = $.extend({},
								$.fn.itemSearch.defaults.param, option.param);
						do_request(this, opts, param);
						return false;
					});
		});
		// console.log(JSON.stringify(opts, null, '\t'));
	};

	function do_request(form, opts, param) {
		var fp = $(form).serializeArray();
		// var new_param = {};
		if (fp.length > 0) {
			for (i in fp) {
				console.log("param name   :   " + fp[i].name + "   val   : "
						+ param[fp[i].name]);
				if (param[fp[i].name] !== undefined) {
					// if (fp[i].value !== "") {
					param[fp[i].name] = fp[i].value;
					// } else {
					// }
				}
			}
		}
		console.log(JSON.stringify(param, null, '\t'));
		for (i in param) {
			if (param[i] == "" || param[i] == null) {
				delete param[i];
			}
		}
		// param = $.extend({}, param, new_param);
		console.log("request" + JSON.stringify(param, null, '\t'));
		_do_request(param, opts);
	}

	function _do_request(param, opts) {
		$.ajax({
			url : opts.request_url,
			data : param,
			dataType : 'jsonp',
			jsonp : 'callBack',
			success : function(data, status) {
				if (status == "success") {
					if (checkHeader(data) === true) {
						if (opts.callBack) {
							opts.callBack(data, param, opts);
						}
					}
				}
			}
		});
	}

	function checkHeader(data) {
		if (data.Header != undefined) {
			if (data.Header.Status.toLowerCase() == "success") {
				return true;
			} else if (data.Header.Status.toLowerCase() == "clienterror") {
				return data.Header.StatusMsg;
			} else if (data.Header.Status.toLowerCase() == 'notfound') {
				return "notfound";
			}
		}
	}

	$.itemSearch = {};
	$.itemSearch.setPager = function(count, page, pageCount, requestData, opts) {
		var PageClick = function(pageclickednumber) {
			requestData['page'] = pageclickednumber;
			_do_request(requestData, opts);
		};
		$("#" + opts.pager).pager({
			pagenumber : page,
			pagecount : pageCount,
			buttonClickCallback : PageClick
		});
	};

	$.itemSearch.prepare = function(form, defaults) {
		$.fn.itemSearch.defaults = defaults;
		var opts = {};
		opts.param = {};
		$(form).itemSearch(opts);
	};

	$.itemSearch.do_serarchitem = function(option) {
		var opts = $.extend({}, $.fn.itemSearch.defaults, option);
		_do_request(opts.param, opts);
	};

	$.fn.itemSearch.defaults = {
		'output_list' : 'itens',
		'callBack' : null,
		'pager' : 'pager',
		'request_url' : 'http://api.rakuten.co.jp/rws/3.0/json',
		param : {}
	};

})(jQuery);