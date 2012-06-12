/*
 * 楽天APIにアクセスする為のクラス
 */
var RakutenApi = function RakutenApi() {
	this.url = 'http://api.rakuten.co.jp/rws/3.0/json';
	this.apiParams ={
		'itemsearch' : {
			'version' : '2010-09-15',
			'operation' : 'ItemSearch',
			'developerId' : 'feaeec38b8bc37411b14de274b1d9480',
			/*
			 * UTF-8でURLエンコードした文字列
			 * (*1)検索キーワード、ジャンルIDのいずれかが指定されていることが必須です。
			 */
			'keyword' : '',
			/*
			 * ショップごとのURL
			 *（http://www.rakuten.co.jp/[xyz]）におけるxyzのこと
			 */
			'shopCode' : '',

			/*
			 * ジャンルID
			 * 楽天市場におけるジャンルを特定するためのID
			 * ジャンル名、ジャンルの親子関係を調べたい場合は、「楽天ジャンル検索API(GenreSearch)」をご利用ください
			 * (*1)検索キーワード、ジャンルIDのいずれかが指定されていることが必須です。
			 *
			 */
			'genreId' : '',

			//1ページあたりの取得件数
			'hits' : '',
			// 取得ページ
			'page' : '',
			/*
			 * ソート
			 * +affiliateRate：アフィリエイト料率順（昇順）
			 * -affiliateRate：アフィリエイト料率順（降順）
			 * +reviewCount：レビュー件数順（昇順）
			 * -reviewCount：レビュー件数順（降順）
			 * +reviewAverage：レビュー平均順（昇順）【NEW】
			 * -reviewAverage：レビュー平均順（降順）【NEW】
			 * +itemPrice：価格順（昇順）
			 * -itemPrice：価格順（降順）
			 * +updateTimestamp： 商品更新日時順（昇順）
			 * -updateTimestamp：商品更新日時順（降順）
			 * standard：楽天標準ソート順
			 */
			'sort' : '',
			//最小価格
			'minPrice' : '',
			//最大価格
			'maxPrice' : '',

			/*
			 * 販売可能
			 * 0：すべての商品
			 * 1：販売可能な商品のみ
			 */
			'availability' : '',
			/*
			 * 検索フィールド
			 * 0：検索対象が広い（同じ検索キーワードでも多くの検索結果が得られる）
			 * 1：検索対象範囲が限定される（同じ検索キーワードでも少ない検索結果が得られる）
			 */
			'field' : '',
			/*
			 * キャリア
			 * PC用の情報を返すのか、モバイル用の情報を返すのかを選択
			 * PC: 0
			 * mobile: 1
			 */
			'carrier' : '',
			/*
			 * 商品画像有無フラグ
			 * 0 : すべての商品を検索対象とする
			 * 1 : 商品画像ありの商品のみを検索対象とする
			 */
			'imageFlag' : '',

			/*
			 * OR検索フラグ
			 * 複数キーワードが設定された場合に、AND検索、OR検索のいずれかが選択可能。
			 * 0:AND検索
			 * 1:OR検索
			 * ※ただし、(A and B) or Cといった複雑な検索条件設定は指定不可。
			 */
			'orFlag' : '',
			//除外キーワード
			'NGKeyword' : '',
			/*
			 * ジャンルごとの商品数取得フラグ
			 * 0 :ジャンルごとの商品数の情報を取得しない
			 * 1 :ジャンルごとの商品数の情報を取得する
			 */
			'genreInformationFlag':'',
			/*
			 * 購入種別
			 * 商品を購入方法別に検索する事が可能
			 * 0：通常購入
			 * 1：定期購入(定期購入とは、お客様の欲しい商品が欲しいサイクルで買えるサービスです。)
			 * 2：頒布会購入(頒布会購入とは、ショップがセレクトした商品を、ショップが決めた回数でお届けするサービスです。)
			 */
			'purchaseType' : '',
			/*
			 * 海外配送フラグ
			 * 0 :すべての商品
			 * 1 :海外配送可能な商品のみ
			 */
			'shipOverseasFlag' : '',
			/*
			 * 'shopCode' : '',

			/*
			 * ジャンルID
			 * 楽天市場におけるジャンルを特定するためのID
			 * ジャンル名、ジャンルの親子関係を調べたい場合は、「楽天ジャンル検索API(GenreSearch)」をご利用ください
			 * (*1)検索キーワード、ジャンルIDのいずれかが指定されていることが必須です。
			 *
			 */
			'genreId' : '',

			//1ページあたりの取得件数
			'hits' : '',
			// 取得ページ
			'page' : '',
			/*
			 * ソート
			 * +affiliateRate：アフィリエイト料率順（昇順）
			 * -affiliateRate：アフィリエイト料率順（降順）
			 * +reviewCount：レビュー件数順（昇順）
			 * -reviewCount：レビュー件数順（降順）
			 * +reviewAverage：レビュー平均順（昇順）【NEW】
			 * -reviewAverage：レビュー平均順（降順）【NEW】
			 * +itemPrice：価格順（昇順）
			 * -itemPrice：価格順（降順）
			 * +updateTimestamp： 商品更新日時順（昇順）
			 * -updateTimestamp：商品更新日時順（降順）
			 * standard：楽天標準ソート順
			 */
			'sort' : '',
			//最小価格
			'minPrice' : '',
			//最大価格
			'maxPrice' : '',

			/*
			 * 販売可能
			 * 0：すべての商品
			 * 1：販売可能な商品のみ
			 */
			'availability' : '',
			/*
			 * 検索フィールド
			 * 0：検索対象が広い（同じ検索キーワードでも多くの検索結果が得られる）
			 * 1：検索対象範囲が限定される（同じ検索キーワードでも少ない検索結果が得られる）
			 */
			'field' : '',
			/*
			 * キャリア
			 * PC用の情報を返すのか、モバイル用の情報を返すのかを選択
			 * PC: 0
			 * mobile: 1
			 */
			'carrier' : '',
			/*
			 * 商品画像有無フラグ
			 * 0 : すべての商品を検索対象とする
			 * 1 : 商品画像ありの商品のみを検索対象とする
			 */
			'imageFlag' : '',

			/*
			 * OR検索フラグ
			 * 複数キーワードが設定された場合に、AND検索、OR検索のいずれかが選択可能。
			 * 0:AND検索
			 * 1:OR検索
			 * ※ただし、(A and B) or Cといった複雑な検索条件設定は指定不可。
			 */
			'orFlag' : '',
			//除外キーワード
			'NGKeyword' : '',
			/*
			 * ジャンルごとの商品数取得フラグ
			 * 0 :ジャンルごとの商品数の情報を取得しない
			 * 1 :ジャンルごとの商品数の情報を取得する
			 */
			'genreInformationFlag':'',
			/*
			 * 購入種別
			 * 商品を購入方法別に検索する事が可能
			 * 0：通常購入
			 * 1：定期購入(定期購入とは、お客様の欲しい商品が欲しいサイクルで買えるサービスです。)
			 * 2：頒布会購入(頒布会購入とは、ショップがセレクトした商品を、ショップが決めた回数でお届けするサービスです。)
			 */
			'purchaseType' : '',
			/*
			 * 海外配送フラグ
			 * 0 :すべての商品
			 * 1 :海外配送可能な商品のみ
			 */
			'shipOverseasFlag' : '',
			/*
			 * 海外配送対象地域
			 * 配送可能地域での絞込みが可能
			 * 配送地域コードについては別途「海外配送対象地域　コード一覧」を参照してください http://webservice.rakuten.co.jp/api/areacode/shipoverseasarea.html
			 * ※海外配送フラグで「1」が指定されたときのみ利用可能
			 */
			'shipOverseasArea':'',

			/*
			 * あす楽フラグ
			 * 0 :すべての商品
			 * 1 :あす楽対応可能な商品のみ
			 */
			'asurakuFlag' : '',

			/*
			 * あす楽配送対象地域
			 * 配送可能地域での絞込みが可能
			 * 配送地域コードについては別途「あす楽配送対象地域　コード一覧」を参照してください http://webservice.rakuten.co.jp/api/areacode/asurakuarea.html
			 * ※あす楽フラグで「1」が指定されたときのみ利用可能
			 */
			'asurakuArea' : '',

			/*
			 * ポイント倍付けフラグ
			 * 0 :すべての商品
			 * 1 :ポイント倍付け商品のみ
			 */
			'pointRateFlag' : '',

			/*
			 * 商品別ポイント倍付け
			 * 2から10までの整数　例）5 →ポイント5倍
			 * 商品別ポイント倍付けについてはこちらをご確認ください。 http://webservice.rakuten.co.jp/api/itemsearch/#INDEX05
			 * ※ポイント倍付け商品フラグに「1」が指定されたときのみ利用可能
			 */
			'pointRate' : '',

			/*
			 * 送料フラグ
			 * 0 :すべての商品
			 * 1 :送料込み／送料無料の商品のみ
			 */
			'postageFlag' : '',

			/*
			 * クレジットカード利用可能フラグ
			 * 0 :すべての商品
			 * 1 :クレジットカード利用可能な商品のみ
			 */
			'creditCardFlag':''
		},
		//楽天ブックス総合検索API
		'BooksTotalSearch' : {
			'operation' : 'BooksTotalSearch',
			'version' : '2011-12-01',
			'developerId' : 'feaeec38b8bc37411b14de274b1d9480',
			'keyword' : '',
			'hits' : '',
			'page' : '',

			/*
			 * 0：すべての商品
			 * 1：在庫あり
			 * 2：3～5日以内に発送予定
			 * 3：3～7日以内に発送予定
			 * 4：メーカー取り寄せ
			 * 5：予約受付中
			 * 6：メーカーに在庫確認
			 */
			'availability' : '',

			/*
			 * 品切れ等購入不可商品表示フラグ
			 * 0：品切れや販売終了など購入不可の商品は結果に表示させない
			 * 1：品切れや販売終了など購入不可の商品を結果に表示させる
			 */
			'outOfStockFlag' : '',
			/*
			 * チラよみフラグ
			 * 0：すべての商品
			 * 1：チラよみ対象商品で絞り込む
			 */
			'chirayomiFlag' : '',
			'sort' : '',
			/*
			 * 限定フラグ
			 * 0:すべての商品
			 * 1:限定版商品のみ
			 * ※限定版商品には期間限定・数量限定・予約限定などの商品が含まれます。
			 */
			'limitedFlag': '',
			/*
			 *
			 * 0:検索対象が広い（同じ検索キーワードでも多くの検索結果が得られる）
			 * 1:検索対象範囲が限定される（同じ検索キーワードでも少ない検索結果が得られる）
			 */
			'field' : '',
			'carrier' : '',
			'orFlag' : '',
			'NGKeyword':'',
			/*
			 * ジャンルごとの商品数取得フラグ
			 * 0 :ジャンルごとの商品数の情報を取得しない
			 * 1 :ジャンルごとの商品数の情報を取得する
			 */
			'genreInformationFlag':''
		}
	};
}

RakutenApi.prototype = new BaseProduct();

RakutenApi.prototype.setOperation = function(operation) {
	if (!this.apiParams[operation]) {
		alert('setOperation error');
	} else {
		this.param = this.apiParams[operation];
	}
}

RakutenApi.prototype.setKey = function (k,v) {
	if (this.param != null) {
		if (this.param[k] != undefined) {
			this.param[k] = v;
		}
	}
}
