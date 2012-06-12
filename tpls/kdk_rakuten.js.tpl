jQuery.fn.kdk_rakuten = function (param){
	return this.each(function (){
		var $API_BASE_URL = "http://api.rakuten.co.jp/rws/3.0/json";

		var self = this;
		var param = JSON.parse(jQuery(this).text().trim());
		jQuery(self).html('loading.....');
		jQuery.ajax({
		  url : $API_BASE_URL,
		  data : param,
		  dataType : 'jsonp',
		  jsonp : 'callBack',
		  complete : function(json){
		  },
		  success : function(data, status){
			  jQuery(self).empty();
			  if (status == "success") {
				  if (data.Header != undefined && data.Header.Status.toLowerCase() == "success") {

					  var Item = (data.Body.ItemCodeSearch ? data.Body.ItemCodeSearch.Items.Item[0] : data.Body.BooksBookSearch.Items.Item[0]);

					  var name = '';
					  if (Item)
					    name = Item.itemName || Item.title;

					  var affiliateUrl_a = jQuery('<a></a>').attr({'href':Item.affiliateUrl,'title':name});
					  var item_img = jQuery('<img />').attr({'src':Item.mediumImageUrl,'alt':name});
					  affiliateUrl_a.append(item_img);

					  jQuery(self).html(affiliateUrl_a);
				  }
			  }
		  },
		  beforeSend : function(){
		  },
		  error : function(){
		  }
		});

	});
}

jQuery('.kdk_rakuten').kdk_rakuten();