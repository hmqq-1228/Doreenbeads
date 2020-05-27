<?php
require_once(DIR_WS_FUNCTIONS . "functions_search.php");
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
 $solr_str_array = get_listing_display_order($disp_order_default);
 $solr_order_str = $solr_str_array['solr_order_str'];
 $order_by = $solr_str_array['order_by'];
$is_advance_result_listing = true;
$breadcrumb->add(NAVBAR_TITLE_2);
//Tianwen.Wan20161101->潘晓燕反应bing不允许浏览器标题里出现pandora，暂时屏蔽
$_GET['keyword'] = trim(str_replace("　", " ", $_GET['keyword']));
$array_keyword_switch = array(
	array('key' => "Thomas Sabo", 'value' => "Link Chain Bracelet"),
	array('key' => "pandora", 'value' => "European"),
	array('key' => "stardust", 'value' => "Sparkledust"),
	array('key' => "shamballa", 'value' => "Braiding Adjustable Bracelet")
);
if($_SESSION['languages_id'] == 2) {
	$array_keyword_switch[0] = array('key' => "Thomas Sabo", 'value' => "Gliederkette Armband");
}
foreach($array_keyword_switch as $keyword_switch_row) {
	if(strtolower($_GET['keyword']) == strtolower($keyword_switch_row['key'])) {
		$_GET['keyword'] = $keyword_switch_row['value'];
	}
}

if (!isset($_GET['action'])){
	if (!isset($_SESSION['display_mode'])) $_SESSION['display_mode'] = 'normal';
}else{
	if ($_GET['action'] == 'quick'){
		$_SESSION['display_mode'] = 'quick';
	}else{
		$_SESSION['display_mode'] = 'normal';
	}
}

if(is_numeric(ITEM_PERPAGE_MOBILE)){
	$item_per_page = ITEM_PERPAGE_MOBILE;
}else{
	$item_per_page = 20;
}

if (isset ( $_GET ['page'] ) && $_GET ['page'] != '' && is_numeric($_GET['page']) ) {
	$current_page = ( int ) (trim ( $_GET ['page'] ));
} else {
	$current_page = 1;
}
$get_all_cate_array=zen_get_all_cate_array();
$current_category_name=TEXT_ALL_CATEGORIES;
if(isset($_GET['cId'])&&$_GET['cId']!=0){
	$last_category_id = $_GET ['cId'];
	$current_category_name = $get_all_cate_array[$_GET['cId']]['name'];
	$breadcrumb->add($get_all_cate_array[$_GET['cId']]['name'], zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'cId=' .$_GET['cId'].'&keyword='.$_GET ['keyword']));
}

$properties_select=' ';
$delArray=array();
$getsInfoArray=array();
$propertyGet='';

if(isset($_GET['pcount']) && $_GET['pcount']>0){
	$property_by_group = array();
	for($cnt=1;$cnt<=$_GET['pcount'];$cnt++){
		if($_GET['p'.$cnt]>0){
			$propertyGet='&p'.$cnt.'='.$_GET['p'.$cnt].$propertyGet;
			$getsInfoArray['p'.$cnt]=$_GET['p'.$cnt];
			$delArray[]='p'.$cnt;
			$group_query = $db->Execute("select property_group_id from ".TABLE_PROPERTY." where property_id='".$_GET['p'.$cnt]."' limit 1");
			$property_by_group[$group_query->fields['property_group_id']][] = $_GET['p'.$cnt];
		}
	}
	foreach($property_by_group as $pg=>$pv){
		$properties_select.= ' AND (';
		for($prop_cnt=0;$prop_cnt<sizeof($pv);$prop_cnt++){
			if($prop_cnt>0) $properties_select.=' OR ';
			$properties_select.=' properties_id:'.$pv[$prop_cnt];
		}
		$properties_select.=' )';
	}
	$propertyGet=$propertyGet.'&pcount='.$_GET['pcount'];
}
$delArray[]='pcount';
$delArray[]='page';
$search_offset = ($current_page-1) * $item_per_page;
if (! defined ( 'KEYWORD_FORMAT_STRING' )) {
	define ( 'KEYWORD_FORMAT_STRING', 'keywords' );
}

$_GET ['keyword'] = zen_db_prepare_input($_GET['keyword']);
$error = false;
$missing_one_input = false;

//去除左右空格、中文空格替换成英文空格、两个空格替换成一个空格
$keyword_input = str_replace("  ", " ", str_replace("　", "", trim(stripslashes($_GET['keyword']))));

$invalid_words_list = array('and', 'or', 'on', 'of', 'in', 'this', 'that', 'these', 'those', "(", ")", "'", '"', "&", ":", "?", "<", ">",'^','？','：','（','）','‘','’','”','“','，','【','】','——','￥','……','！','。');
if(in_array(strtolower($keyword_input), $invalid_words_list)){
	$error = true;
}

$model_keyword = str_replace ( $invalid_words_list, "", $keyword_input );
$is_products_model = preg_match('/^[a-z\d\._-]{5,20}$/i', $keyword_input);
if ($is_products_model && $model_keyword != 'T02847') {
    if (!(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0)) {
        $products_display_solr_str = ' and is_display = 1 ';
    }
	$querypro_pron = $db->Execute ( "SELECT products_model,products_id FROM " . TABLE_PRODUCTS . " WHERE products_status = 1 and products_model = '" . trim ( $model_keyword ) . "'" . $products_display_solr_str . " LIMIT 1" );
	if(!$querypro_pron->EOF){
		zen_redirect(zen_href_link('product_info', 'products_id=' .$querypro_pron->fields ['products_id']));
		$querypro_pron->MoveNext();
	}
}

if ((isset ( $_GET ['keyword'] ) && (empty ( $_GET ['keyword'] ) || $_GET ['keyword'] == HEADER_SEARCH_DEFAULT_TEXT || $_GET ['keyword'] == KEYWORD_FORMAT_STRING))) {
	$error = true;
	$missing_one_input = true;
	$messageStack->add_session ( 'search', ERROR_AT_LEAST_ONE_INPUT );
} else {
	$keywords = '';
	if (isset ( $_GET ['keyword'] ) && $_GET ['keyword'] != HEADER_SEARCH_DEFAULT_TEXT && $_GET ['keyword'] != KEYWORD_FORMAT_STRING) {
		$keywords = $_GET ['keyword'];
	}
	if (zen_not_null ( $keywords )) {
		if (! zen_parse_search_string ( $keywords, $search_keywords )) {
			$error = true;
			$messageStack->add_session ( 'search', ERROR_INVALID_KEYWORDS );
		}
	}
}

if($_SESSION['languages_id']==3){
	$search_keywords=ru_changeKeyWord(explode(' ',$keywords));
	$parsed_keywords=implode(' ',$search_keywords);
}else{
	$search_keywords=changeKeyWord(explode(' ',$keywords));
	$parsed_keywords=implode(' AND ',$search_keywords);
}

$parsed_keywords = trim(str_replace($invalid_words_list, '', $parsed_keywords));

if ($parsed_keywords == 'T02847') {
	$error = true;
}

if(!empty($keyword_input)){
	$insert_languages_id = ($_SESSION['languages_id']) ? $_SESSION['languages_id'] : 0;
	$insert_user_id = ($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;
	$insert_keywords = str_replace("\t", " ", addslashes(zen_db_prepare_input($_GET['keyword'])));
	$insert_categories_id = (isset($_GET['categories_id']) && $_GET['categories_id'] != '') ? $_GET['categories_id'] : 0;
	$ip_address = zen_get_ip_address();
	$handle = fopen("log/search_keyword_mobile/" . date("Y-m-d") . ".txt", "a");
	fwrite($handle, $insert_languages_id . "\t" . $insert_user_id . "\t" . $insert_keywords . "\t" . $insert_categories_id . "\t" . $ip_address . "\t" . date("Y-m-d H:i:s") . "\n");
	fclose($handle);
	//$db->Execute("Insert into zen_search_keyword (sk_word_id, sk_user_id, sk_key_word, sk_categories, sk_search_date) 
	//			  Values ('', " . $insert_user_id . ", '" . $insert_keywords . "', " . $insert_categories_id . ", now())");
	//            //Values ('', " . $insert_user_id . ", '" . $insert_keywords . "', " . $insert_categories_id . ", now())");
}

$related_array = get_search_related_array($keyword_input, $_SESSION['languages_id'], SHOW_SEARCH_RALATED_NUMBER);
$related_str = "";
foreach ($related_array as $value) {
	$related_str .= "<a href=" . zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'keyword=' . urlencode($value['keyword_display']), 'NONSSL', false) . ">" . $value['keyword_display'] . "</a>&nbsp;&nbsp;&nbsp;";
}

if ($error == true) {
	$num_products_count = $count_res->response->numFound = 0;
} else {
	/*
	if (is_numeric($keywords)) {
		$keywords = "*" . $keywords;
	}
	if (count($search_keywords) > 0 && $_SESSION['languages_id'] != 3) {
		$keywords = '' . strtolower($keywords) . '^3';
	} else {
		$keywords = strtolower($keywords);
	}
	*/
	$current_time = time();
	$condition['sort'] = $solr_order_str;
	$condition['facet'] = 'true';
	$condition['facet.mincount'] = '1';
	$condition['facet.limit'] = '-1';

	$condition['facet.field'][] = 'properties_id';
	$condition['f.properties_id.facet.missing'] = 'false';
	$condition['f.properties_id.facet.method'] = 'enum';
	
	$condition['facet.field'][] = 'categories_id';
	$condition['f.categories_id.facet.missing'] = 'true';
	$condition['f.categories_id.facet.method'] = 'enum';
		
	$condition['fl'] = 'products_id, score,is_promotion,is_hot_seller,is_new,products_name';
	//$condition['defType'] = 'edismax';//dismax
	$condition['pf'] = 'products_name products_description';
	$condition['qf'] = 'products_name^0.18 products_description^0.16';
	//$condition['bf']='extra_score^0.2 stock_sort^0.04';
		
	//$is_search_synonym = false;
	$solr = new Apache_Solr_service(SOLR_HOST, SOLR_PORT, "/solr/dorabeads_" . $_SESSION["languages_code"]);
	$keywords = get_keywrods_to_solr($keyword_input, $_SESSION['languages_id']);
	$extra_select_str = $keywords . ($last_category_id ? " AND categories_id:" . $last_category_id . " " : "");
	if(in_array($_GET['pack'], array('0', '1', '2'))){
		$extra_select_str .= ' AND package_size:' . $_GET['pack'];
	}
	if(is_numeric($_GET['products_filter_onsale']) && $_GET['products_filter_onsale'] == 1) {
		$extra_select_str .= ' AND ((+promotion_start_time:[0 TO ' . $current_time . '] AND +promotion_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']) OR (+daily_deal_start_time:[0 TO ' . $current_time . '] AND +daily_deal_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']))';
	}
	if(is_numeric($_GET['products_filter_in_stock']) && $_GET['products_filter_in_stock'] == 1) {
		$extra_select_str .= ' AND -products_quantity:0';
		//$extra_select_str .= ' AND +products_quantity:[1 TO ' . PHP_INT_MAX . ']';
	}
	if(is_numeric($_GET['products_filter_mixed']) && $_GET['products_filter_mixed'] == 1) {
		$extra_select_str .= ' AND is_mixed:1';
	}
    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) {
        $products_display_solr_str = '';
    } else {
        $products_display_solr_str = ' AND is_display:1';
    }
    $extra_select_str .= $products_display_solr_str;
	$count_res = search_by_solr($solr, $condition, $extra_select_str, $properties_select, $search_offset, $item_per_page);
	$num_products_count = $count_res->response->numFound;
}

$products_new_split = new splitPageResults("", $item_per_page, "", "page", false, $num_products_count);
$properties_facet = $count_res->facet_counts->facet_fields->properties_id;
$product_all = $count_res->response->docs;
$categories_facet = $count_res->facet_counts->facet_fields->categories_id;
$categories_refine_by = get_refine_by_category_tree($categories_facet);
$product_res = array ();
$display_product_cnt = 0;
foreach ($product_all as $prod_val) {
	$product_res[] = $prod_val->products_id;
	$display_product_cnt++;
}

//记录无效链接
record_valid_url(true , $display_product_cnt , 0);
//eof

/*
$solr = new Apache_Solr_service(SOLR_HOST , SOLR_PORT ,'/solr/dorabeads_'.$_SESSION['languages_code']);
if ($error == true) {
	$count_res->response->numFound = 0;
}else{
	$keywords_special_array = array('^','*','#','~','@','!','$','%','&','(',')','_','+','=','<','>','/','{','}','[',']','\\','|','`',':','"');
	foreach($keywords_special_array as $single_char){
		if(stristr($keywords,$single_char)){
			$error = true;
			break;
		}
	}
	if ($error == true || $model_keyword == 'T02847') {
		$count_res->response->numFound = 0;
	}else{
		if(is_numeric($keywords)) {
			$keywords = "*".$keywords;
		}
		if(count($search_keywords) > 0 && $_SESSION['languages_id'] != 3){
			$keywords = ''.strtolower($keywords).'^3';
		}else{
			$keywords = strtolower($keywords);
		}
		$condition['sort'] = $solr_order_str;
		$condition['facet'] = 'true';
		$condition['facet.mincount'] = '1';
		$condition['facet.limit'] = '-1';
		
		$condition['facet.field'][] = 'properties_id';
		$condition['f.properties_id.facet.missing'] = 'false';
		$condition['f.properties_id.facet.method'] = 'enum';
		
		$condition['facet.field'][] = 'categories_id';
		$condition['f.categories_id.facet.missing'] = 'true';
		$condition['f.categories_id.facet.method'] = 'enum';
		
		$condition['fl'] = 'products_id, score,is_promotion,is_hot_seller,is_new,products_name,categories_name';
		$condition['defType']='edismax';
		$condition['pf']='categories_name products_name products_description';
		$condition['qf']='categories_name^0.42 products_name^0.18 products_description^0.16';
		//$condition['bf']='extra_score^0.2 stock_sort^0.04';

		$extra_select_str=' AND '.$keywords;
		$extra_select_str.=$last_category_id?' AND categories_id:'.$last_category_id.' ':'';
		$count_res = $solr->search('products_status:1 '.$extra_select_str.$properties_select , $search_offset, $item_per_page, $condition);

		if($count_res->response->numFound == 0 && $_SESSION['languages_id'] == 3){
			$keywords = str_replace(array('с','в','х','м','е','к','н','а','о','С','В','Х','М','Е','К','Н','А','О'),array('c','b','x','m','e','k','h','a','o','c','b','x','m','e','k','h','a','o') , $keywords);
			$count_res = $solr->search($keywords.$extra_select_str.$properties_select .' AND products_status:1 ', $search_offset, $item_per_page, $condition);
		}
		if($count_res->response->numFound > 20000){
			unset($count_res);
			$count_res->response->numFound=0;
			$error = true;
		}
	}
}

$num_products_count = $count_res->response->numFound;
$products_new_split = new splitPageResults('', $item_per_page, '', 'page',false,$num_products_count);
$properties_facet = $count_res->facet_counts->facet_fields->properties_id; 
$categories_facet = $count_res->facet_counts->facet_fields->categories_id;

$categories_refine_by = get_refine_by_category_tree($categories_facet);

$product_all = $count_res->response->docs;
 //var_dump($product_all);exit;
$product_res = array();
$display_product_cnt = 0;
foreach($product_all as $prod_val){
	$product_res[] = $prod_val->products_id;
	$display_product_cnt++;
}
if($products_new_split->number_of_rows > 0){
	/*暂时关掉20140913
	$keywords_count_sql = "SELECT kc_key_id,kc_key_count,kc_key_language_id FROM ".TABLE_KEYWORDS_COUNT." where kc_key_value = '".zen_db_prepare_input($keywords)."' and kc_key_language_id = ".intval($_SESSION['languages_id'])."";
	$keywords_count_sql_queery = $db->Execute($keywords_count_sql);
	$kc_key_id = intval($keywords_count_sql_queery->fields['kc_key_id']);
	$kc_key_language_id = intval($keywords_count_sql_queery->fields['kc_key_language_id']);
	$kc_key_count = intval($keywords_count_sql_queery->fields['kc_key_count']) + 1;
	if($kc_key_id > 0 && intval($kc_key_language_id )== intval($_SESSION['languages_id'])){
		$db->Execute("update ".TABLE_KEYWORDS_COUNT." set kc_key_count = ".$kc_key_count.",kc_key_products_count = ".$products_new_split->number_of_rows." where kc_key_value='".zen_db_prepare_input($keywords)."' and kc_key_language_id = ".intval($_SESSION['languages_id'])."");
	}else{
		$db->Execute("insert into  ".TABLE_KEYWORDS_COUNT."(kc_key_value,kc_key_count,kc_key_products_count,kc_key_language_id) values('".zen_db_prepare_input($keywords)."',1,".$products_new_split->number_of_rows.",".intval($_SESSION['languages_id']).")");
	}
}
*/
require(DIR_WS_MODULES .  zen_get_module_directory('property.php'));
require(DIR_WS_MODULES .  zen_get_module_directory('display_sort_number.php'));


$this_is_product_list_page = true;
$this_is_best_match_category = true;
$this_is_search_action = true;
$body_header_title = TEXT_SEARCH_RESULTS;

$smarty->assign ( 'text_search_resykt_normal', sprintf(TEXT_SEARCH_RESULT_NORMAL, $keyword_input, $num_products_count, $keyword_input));
$smarty->assign ( 'related_str', $related_str );
$smarty->assign ( 'this_is_search_action', $this_is_search_action );
$smarty->assign ( 'body_header_title', $body_header_title );
$smarty->assign ( 'result_count', $num_products_count );
$smarty->assign ( 'view_only_sale_url', zen_href_link($_GET['main_page'], zen_get_all_get_params(array('products_filter_onsale', 'page')) . (!isset($_GET['products_filter_onsale']) ? 'products_filter_onsale=1' : '')) );

$smarty->assign('index_link',zen_href_link(FILENAME_DEFAULT));
 
include(DIR_WS_MODULES . zen_get_module_directory('product_gallery_by_property'));

$smarty->assign ( 'tpl', $tpl );

?>