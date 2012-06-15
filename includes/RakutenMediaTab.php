<?php
/*
 * 投稿ページに楽天のタブウィンドウを表示
*/
class RakutenMediaTab {

	const REPLACE_DEVID = "%%%RAKUTEN%%%DEV_ID%%%";
	const REPLACE_AFLID = "%%%RAKUTEN%%%AFF_ID%%%";

	const KDK_DEFAULT_DID = "feaeec38b8bc37411b14de274b1d9480";
	const KDK_DEFAULT_AID = "0a30aaaf.afb9b1e2.0a30aab0.82880378";

	private static $singleton = null;

	private $tabInterfaces = array();

	function RakutenMediaTab () {
		//アップロード/挿入の隣にボタンを追加
		add_action( 'media_buttons', array(&$this,'media_button'), 100);

		//タグのテンプレートを表示する為のアクション
		add_filter( 'rakuten_template', array(&$this,'getTemplate'));

		//文字列変換フィルター
		add_filter("rakuten_str_replace", array(&$this,'replaceStr'));

		//古いショートコードはこのクラスで吸収
		add_shortcode('rakuten', array(&$this,'doShortcode'));
	}

	// インスタンスを生成する
	public static function getInstance() {
		if (RakutenMediaTab::$singleton == null) {
			RakutenMediaTab::$singleton = new RakutenMediaTab();
		} else {
			//echo "インスタンスは既に存在します\n";
		}
		return RakutenMediaTab::$singleton;
	}

	//投稿にメディアボタンを追加
	function media_button ($editor_id = 'content') {
		$context = apply_filters('media_buttons_context_rakuten', __('Rakuten %s'));
		$img = '<img src="' . esc_url( plugins_url() . "/". KDK_WP_RAKUTEN_NAME . '/images/r_icon.png' ) . '" width="15" height="15" />';
		echo '<a href="' . $this->get_upload_iframe_src('kdk-wprakuten-itens') . '" class="thickbox" id="' . esc_attr( $editor_id ) . '-add_media-rakuten" title="' . esc_attr__( 'Rakuten' ) . '" onclick="return false;">' . sprintf( $context, $img ) . '</a>';
	}

	//メディアボタンのリンク作成
	function get_upload_iframe_src( $type = 'kdk-wprakuten-itens' ) {
		global $post_ID;
		$url = plugins_url() . "/". KDK_WP_RAKUTEN_NAME . "/rakuten-media.php";
		$uploading_iframe_ID = (int) $post_ID;
		$upload_iframe_src = add_query_arg( 'post_id', $uploading_iframe_ID, $url );

		$upload_iframe_src = add_query_arg('tab', $type, $upload_iframe_src);
		return add_query_arg('TB_iframe', true, $upload_iframe_src);
	}

	//タブのアクションを実装
	function do_action ($type = "kdk-wprakuten-itens")
	{
		foreach ($this->tabInterfaces as $tab) {
			if ($tab == $type) {
				$this->kdk_iframe(&$tab);
			}
		}
	}

	//登録されているタブをすべて取得
	function media_rakuten_tabs ()
	{
		//ソート
		$interfaces = array();
		$i=1;
		foreach ($this->tabInterfaces as $v) {
			if ($v=="kdk-wprakuten-itens") {
				$interfaces[0] = $v;
			} else {
				$interfaces[$i] = $v;
				$i++;
			}
		}
		ksort($interfaces);
		return $interfaces;
	}

	//iframeの実装
	public function kdk_iframe($tab) {
		?>
<!DOCTYPE html>
<!--[if IE 8]>
	<html xmlns="http://www.w3.org/1999/xhtml" class="ie8" <?php do_action('admin_xml_ns'); ?> <?php language_attributes(); ?>>
	<![endif]-->
<!--[if !(IE 8) ]><!-->
<html xmlns="http://www.w3.org/1999/xhtml"
		<?php do_action('admin_xml_ns'); ?> <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type"
	content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
<title><?php bloginfo('name') ?></title>

</head>
<body id="media-upload" class="no-js">


	<?php
	$this->media_rakuten_header();
	$fields = $tab->getFields();
	$display_fields = $tab->displayFields();
	//code
	$code    = $tab->shortCodeName();
	$defaults = array(
			'RakutenAffiliateId' => KDK_DEFAULT_AID,
	);


	$options = get_option( 'rakuten_product_options', $defaults);
	//replace
	foreach ($fields as $i => $v) {
		if (!is_array($v)) {
			$fields[$i] = str_replace(RakutenMediaTab::REPLACE_AFLID, $options['RakutenAffiliateId'], $fields[$i]);
			$fields[$i] = str_replace(RakutenMediaTab::REPLACE_DEVID, KDK_DEFAULT_DID, $fields[$i]);
		}
	}

	include_once dirname(dirname(__FILE__)) . "/tpls/tab_template.php";
	// 	$args = func_get_args();
	// 	$args = array_slice($args, 1);
	// 	call_user_func_array($content_func, $args);
	//do_action('admin_print_footer_scripts');
	?>

</body>
</html>
<?php
	}

	function media_rakuten_header() {
		wp_enqueue_style( 'media' );
		wp_enqueue_style( 'media_rakute' );
		wp_enqueue_style( 'ie' );
		wp_enqueue_style('colors-fresh');
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'rakuten-base-api' );
		wp_enqueue_script( 'rakuten-api' );
		wp_enqueue_script( 'rakuten-paging' );
		do_action('admin_head');
		do_action('admin_print_styles-media-upload-popup');
		do_action('admin_print_styles');
		do_action('admin_print_scripts');
		?>
<script type="text/javascript">post_id = <?php echo intval($_REQUEST['post_id']); ?>;</script>
<div id="media-upload-header">
	<?php $this->the_media_rakuten_tabs(); ?>
</div>
<?php
	}

	function the_media_rakuten_tabs() {
		$tabs = $this->media_rakuten_tabs();
		if ( !empty($tabs) ) {
			echo "<ul id='sidemenu'>\n";
			$current = isset($_GET['tab'])?$_GET['tab']:"";
			foreach ( $tabs as $tab ) {
				$class = '';

				if ( $current == $tab )
					$class = " class='current'";

				$href = add_query_arg(array('tab' => $tab->__toString()));
				$link = "<a href='" . esc_url($href) . "'$class>".esc_attr__($tab->getName(),'kdk-wprakuten')."</a>";
				echo "\t<li id='" . esc_attr("tab-$tab") . "'>$link</li>\n";
			}
			echo "</ul>\n";
		}
	}


	//タブの追加
	function addTab($interface) {
		if (is_a($interface,'IRakutenMediaTab')) {
			$this->tabInterfaces[] = $interface;
			//			add_filter('media_rakuten_tabs', array(&$interface,'update_rakuten_tab'));
			//add_action("media_rakuten_tabs_action", $interface);

			//ショートコード登録
			$code = $interface->shortCodeName();
			if (!empty($code)) {
				add_shortcode($code, array(&$interface,'doShortcode'));
				add_action('rakuten_media_{$code}', array(&$interface,'doShortcode'));
			}
		}
	}

	//古いショートコードの吸収
	function doShortcode ($raw_args, $content=null) {
		$defaults = array (
				'itemcode' => '',
				'isbn' => ''
		);

		$spanitized_args = shortcode_atts($defaults, $raw_args); //コードの属性を取得
		if (empty($spanitized_args['itemcode']) && empty($spanitized_args['isbn'])) {
			return '';
		}


		$defaults = array(
				'RakutenAffiliateId' => KDK_DEFAULT_AID,
		);
		$options = get_option( 'rakuten_product_options', $defaults);


		$param['developerId'] = KDK_DEFAULT_DID;
		$param['affiliateId'] = $options['RakutenAffiliateId'];
		if(!empty($spanitized_args['itemcode'])) {
			$param['operation'] = "ItemCodeSearch";
			$param['version'] = "2010-08-05";
			$param['itemCode'] = $spanitized_args['itemcode'];
		} else {
			$param['operation'] = "BooksBookSearch";
			$param['version'] = "2011-12-01";
			$param['isbn'] = $spanitized_args['isbn'];
		}

		$data['itemcode'] = json_encode($param);
		return '<div class="kdk_rakuten" style="display:none;">' . json_encode($param) . '</div>';
	}

	//テンプレートの取得
	function getTemplate ($type) {
		wp_enqueue_style( 'rakuten_product_template',100 );
		wp_enqueue_script("rakuten-templates");
		$template = "";
		switch ($type)
		{
			default:
				$template = file_get_contents(dirname(dirname(__FILE__)) . "/tpls/template1_tag.html");
		}
		return $template;
	}

	function replaceStr($str) {
		if ($str === RakutenMediaTab::REPLACE_DEVID) {
			return RakutenMediaTab::KDK_DEFAULT_DID;
		}

		if ($str === RakutenMediaTab::REPLACE_AFLID) {
			return RakutenMediaTab::KDK_DEFAULT_AID;
		}
	}

	//スタティックメソット
	function pser_field ($fields, $json_obj=null)
	{
		$tmp = explode(',',$fields);
		if (count($tmp) > 1) {
			$ret = "";
			foreach ($tmp as $k => $v) {
				if ($k == 0) {
					$ret .= "{$json_obj}.{$v} ";
				} else {
					$ret .= " '<small>' + {$json_obj}.{$v} + '</smal>'";
				}

				if ((count($tmp) -1) > $k)
					$ret .= "+' <br /> '+";
			}
			return $ret;
		} else {
			return "{$json_obj}.{$fields}";
		}
	}
}