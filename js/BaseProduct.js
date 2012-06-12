// 親クラスの定義

var BaseProduct = function BaseProduct() {
	this.param = null;
	this.url = null;
};

BaseProduct.prototype.setParams = function(param) {
	this.param = param;
};

BaseProduct.prototype.setUrl = function(url) {
	this.url = url;
};

BaseProduct.prototype.jpson = function(callback) {

	var new_param = {};
	if (this.param) {
		for (i in this.param) {
			if (this.param[i].length > 0) {
				new_param[i] = this.param[i];
			}
		}
	}


	if (new_param) {
		jQuery.ajax({
			url : this.url,
			data : new_param,
			dataType : 'jsonp',
			jsonp : 'callBack',
			complete : function(json) {
			},
			success : function(data, status) {
				if (callback)
					callback(data, status);
			},
			beforeSend : function() {
			},
			error : function() {
			}
		});
	}
};
