<?php
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");
$write_shopping_log = false;
if(isset($_SESSION['count_cart']) && $_SESSION['count_cart'] >= 50) {
	$write_shopping_log = true;
	$identity_info = $_COOKIE['cookie_cart_id'];
	if(!empty($_SESSION['customer_id'])) {
		$identity_info = $_SESSION['customer_id'];
	}
	if(empty($identity_info)) {
		$identity_info = json_encode($_COOKIE) . "separator" . json_encode($_SESSION);
	}
	write_file("log/shopping_cart_log/", "shopping_cart_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\r\n");
}

//bof 后台管理员帮顾客下单
if (isset($_GET['admin_id']) && $_GET['admin_id'] != ''){
	$_SESSION['checkout_admin_for_customer'] = $_GET['admin_id'];
}
//eof
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));
require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/my_coupon.php');

$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : '1';
$smarty->assign('page', $page);
//Tianwen.Wan20180612->当出现删除商品异常时页面会刷新所以需要(如俄语站删除该商品：B0080422)：time() - $_SESSION['delete_products']['date_created_unix'] > 30
if(!isset($_SESSION['delete_products']['date_created_unix']) || (isset($_SESSION['delete_products']['date_created_unix']) && time() - $_SESSION['delete_products']['date_created_unix'] > 30)) {
	unset($_SESSION['delete_products']);
}
$sort_by = zen_db_prepare_input($_GET['sort_by']);
$sort_type = zen_db_prepare_input($_GET['sort_type']);
if(empty($sort_by) && empty($sort_type)) {
	$sort_by = "customers_basket_id";
	$sort_type = "desc";
}
if(!empty($sort_by) && !in_array($sort_by, array('customers_basket_id', 'products_model'))) {
	$sort_by = "customers_basket_id";
}
if(!empty($sort_type) && !in_array($sort_type, array('desc', 'asc'))) {
	$sort_type = "desc";
}
$_SESSION['cart_sort_by'] = $sort_by;
$_SESSION['cart_sort_type'] = $sort_type;


$smarty->assign ( 'cart_sort_by', $sort_by);
$smarty->assign ( 'cart_sort_type', $sort_type);

$smarty->assign ( 'index_href', zen_href_link(FILENAME_DEFAULT) );

/* $products_query = $db->Execute('select products_id from ' . TABLE_PRODUCTS . ' order by products_id desc limit 150');
while (!$products_query->EOF){
	$_SESSION['cart']->add_cart($products_query->fields['products_id'], 1);
	$products_query->MoveNext();
} */
if (zen_not_null($_SERVER['HTTP_REFERER'])) {
	$url_suffix = parse_url($_SERVER['HTTP_REFERER']);
	if (empty($url_suffix['query'])) {
		if (strpos($url_suffix['path'],'-p-') || strpos($url_suffix['path'],'-c-') || strpos($url_suffix['path'],'-ai-')) {
			$_SESSION['prev_url'] = $_SERVER['HTTP_REFERER'];
		}else{
			$_SESSION['prev_url'] = zen_href_link(FILENAME_DEFAULT);
		}
	}else{ 
		if (strpos($url_suffix['query'], '&')) {
			$url_query = strstr($url_suffix['query'],'&',true);
		}else{
			$url_query = $url_suffix['query'];
		}
		$url_query_short = substr($url_query, 10);
		//var_dump($url_query_short);
		if ($url_query_short) {
			if ((strpos($url_query_short, 'product')!== false) || (strpos($url_query_short, 'wishlist')!== false) || (strpos($url_query_short, 'promotion')!== false) || (strpos($url_query_short, 'search')!== false) || (strpos($url_query_short, 'subject')!== false) || strpos($url_suffix['path'],'-p-') || strpos($url_suffix['path'],'-c-') || strpos($url_suffix['path'],'-ai-')) {
				$_SESSION['prev_url'] = $_SERVER['HTTP_REFERER'];
			}else{
				$_SESSION['prev_url'] = zen_href_link(FILENAME_DEFAULT);
			}
		}
	}
}
// bof move single product to wishlist
if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'mws') {
	if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '') {
		$product_id = (int)$_GET ['pid'];
		$wishlist_check = $db->Execute ( 'select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . $product_id . ' and wl_customers_id = ' . $_SESSION ['customer_id'] );
		if ($wishlist_check->RecordCount () == 0) {
			$sql = 'insert into ' . TABLE_WISH . ' (wl_products_id, wl_customers_id, wl_date_added) values (' . $product_id . ', ' . $_SESSION ["customer_id"] . ', "' . date ( 'y-m-d H:i:s' ) . '")';
			$db->Execute ( $sql );
			update_products_add_wishlist(intval($product_id));
			$messageStack->add_session ( 'addwishlist', TEXT_MOVE_TO_WISHLIST_SUCCESS, 'success' );
		}
		zen_redirect ( zen_href_link ( FILENAME_SHOPPING_CART, $page != '' ? 'page=' . $_GET['page'] : '' ) );
	}
}
// eof

// bof move all product to wishlist
if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'mwa') {
	if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '') {
		//$products = $_SESSION ['cart']->get_products ( false );
		//Tianwen.Wan20160624购物车优化
		$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize(0, 0, true, false, false);
		$products = $products_array['data'];
		if (zen_not_null ( $products )) {
			$sql = '';
			for($i = 0; $i < sizeof ( $products ); $i ++) {
				$wishlist_check = $db->Execute ( 'select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . $products[$i]['id'] . ' and wl_customers_id = ' . $_SESSION ['customer_id'] );
				if ($wishlist_check->RecordCount () == 0) {
					$sql .= '(' . $products[$i]['id'] . ', ' . $_SESSION ["customer_id"] . ', ' . $products[$i]['quantity'] . ', "' . date ( 'y-m-d H:i:s' ) . '"), ';
					update_products_add_wishlist(intval($products[$i]['id']));
				} else{
					$db->Execute ( 'update ' . TABLE_WISH . ' set wl_product_num = '.$products[$i]['quantity'].' where wl_products_id = ' . $products[$i]['id'] . '  and wl_customers_id = ' . $_SESSION ['customer_id'] . '' );
				}
			}
			$_SESSION ['cart']->remove_all(false);
			if ($sql != '') {
				$sql = 'insert into ' . TABLE_WISH . ' (wl_products_id, wl_customers_id, wl_product_num, wl_date_added) values ' . substr ( $sql, 0, - 2 );
				$db->Execute ( $sql );
				$messageStack->add_session ( 'addwishlist', TEXT_MOVE_TO_WISHLIST_SUCCESS, 'addwishlist' );
			}else{
				$messageStack->add_session ( 'addwishlist', TEXT_MOVE_TO_WISHLIST_SUCCESS_NOTICE, 'addwishlist' );
			}
		}
		zen_redirect ( zen_href_link ( FILENAME_SHOPPING_CART ) );
	}
}
// eof

// bof add order to wishlist
if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'add_order_to_wishlist' && is_numeric($_GET ['orders_id'])) {
	if (isset($_SESSION ['customer_id']) && $_SESSION['customer_id'] != '') {
		$products = $db->Execute('select o.customers_id, op.products_id, op.products_quantity from ' . TABLE_ORDERS_PRODUCTS . ' op inner join ' . TABLE_ORDERS . ' o on o.orders_id = op.orders_id  where o.orders_id = ' . $_GET ['orders_id']);
		if ($products->RecordCount() > 0) {
			while(!$products->EOF) {
				if($products->fields['customers_id'] == $_SESSION ['customer_id']) {
					$wishlist_check = $db->Execute('select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . $products->fields['products_id'] . ' and wl_customers_id = ' . $_SESSION ['customer_id']);
					if ($wishlist_check->RecordCount() == 0) {
						$sql_data_array = array(
							'wl_products_id' => $products->fields['products_id'],
							'wl_customers_id' => $products->fields['customers_id'],
							'wl_product_num' => $products->fields['products_quantity'],
							'wl_date_added' => date('y-m-d H:i:s')
						);
						zen_db_perform(TABLE_WISH, $sql_data_array);
						update_products_add_wishlist(intval($products->fields['products_id']));
					} else {
						$db->Execute("update " . TABLE_WISH . " set wl_product_num = " . $products->fields['products_quantity'] . " where wl_products_id = " . $products->fields['products_id'] . " and wl_customers_id = " . $_SESSION ['customer_id']);
					}
				}
				$products->MoveNext();
			}
		}
		zen_redirect(zen_href_link(FILENAME_WISHLIST));
	} else {
		zen_redirect(zen_href_link(FILENAME_LOGIN));
	}
}
// eof

// bof empty shopping cart
if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'empty') {
	$_SESSION ['cart']->remove_all(false);
	zen_redirect ( zen_href_link ( FILENAME_SHOPPING_CART ) );
}
// eof

// bof add select products to cart
if (isset ( $_POST ['action'] ) && $_POST ['action'] == 'addselect') {
	$datas = array();
	for($i = 0; $i < sizeof ( $_POST ['product_model'] ); $i ++) {
		$product_model = strtoupper ( trim ( $_POST ['product_model'] [$i] ) );
		$product_qty = $_POST ['product_qty'] [$i] ? $_POST ['product_qty'] [$i] : 1;
		array_push($datas, array('products_model' => $product_model, 'products_quantity' => $product_qty));
	}
	$result = addToCartBatch($datas);
}
// eof

if($_POST ['action'] == 'add_spreadsheet') {
	$file = $_FILES['filePath'];
	$filename = basename($file['name']);
	$file_from=$file['tmp_name'];
	$check_code = zen_db_input($_POST['check_code']);
	
	$jsonData = array('error' => false, 'msg' => '');
	$datas = array();

	if($_SESSION['auto_auth_code_display']['shopping_cart_uploadFile'] >= 3 || !isset($_SESSION['customer_id']) || $_SESSION['customer_id'] == 0){
		if($_SESSION['verification_code_common'] != $check_code || $check_code == ''){
			$jsonData['error'] = true;
			$jsonData['msg'] = TEXT_INPUT_RIGHT_CODE;
		}
	}

	if($file['error'] || empty($file)){
		$jsonData['error'] = true;
	}elseif(substr($filename, '-4') != 'xlsx' && substr($filename, '-3') != 'xls'){
		$jsonData['error'] = true;
	}

	if (!$jsonData['error']) {
		set_time_limit(0);
		set_include_path('./Classes/');
		include 'PHPExcel.php';
		if(substr($filename, '-4')=='xlsx'){
			include 'PHPExcel/Reader/Excel2007.php';
			$objReader = new PHPExcel_Reader_Excel2007;
		}else{
			include 'PHPExcel/Reader/Excel5.php';
			$objReader = new PHPExcel_Reader_Excel5;
		}
	}

	$objPHPExcel = $objReader->load($file_from);
	$sheet = $objPHPExcel->getActiveSheet();

	for($j = 2; $j <= $sheet->getHighestRow (); $j ++) {
		$products_model = trim ( $sheet->getCellByColumnAndRow ( 0, $j )->getValue () );
		$products_qty = trim ( $sheet->getCellByColumnAndRow ( 1, $j )->getValue () );
		if ($products_model != '') {
			array_push($datas, array('products_model' => $products_model, 'products_quantity' => $products_qty));
		}
	}
	$result = addToCartBatch($datas);
	if ($_SESSION['auto_auth_code_display']['shopping_cart_uploadFile'] > 0){
		$_SESSION['auto_auth_code_display']['shopping_cart_uploadFile']+= 1;
	}else{
		$_SESSION['auto_auth_code_display']['shopping_cart_uploadFile'] = 1;
	}	
	
	echo json_encode($jsonData);die;
}

if($_GET['action'] == 'export_cart') {
	require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
	$filename = 'MyDoreenbeadsCart_' . date('m-d-Y');
	
 	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle($filename);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Part No.');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'QTY');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(34);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(34);
	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(24);
	$objPHPExcel->getActiveSheet()->getStyle('A1:B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
	//$products = $_SESSION ['cart']->get_products(false, 1000);
	//Tianwen.Wan20160624购物车优化
	$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize(1, 1000, false, false, true);
	$products = $products_array['data'];
	
	for($index = 0; $index <count($products); $index++) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . ($index + 2), $products[$index]['model']);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . ($index + 2), $products[$index]['quantity']);
	}
   	
	header ( "Content-type: application/vnd.ms-excel; charset=UTF-8" );
	if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE")){
		header('Content-Disposition: attachment; filename=' . urlencode($filename) . '.xls');
	}else{
		header('Content-Disposition: attachment; filename=' . $filename . '.xls');
	}	
	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
   	header("Content-Type: application/force-download"); 
	header("Content-Type: application/octet-stream"); 
	header("Content-Type: application/download"); 
	header("Content-Transfer-Encoding: binary"); 
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("Pragma: no-cache");
   	$objWriter->save('php://output'); 
}


$use_new_template = true;
$is_login = (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '');

$_SESSION ['valid_to_checkout'] = true;
//$_SESSION['cart_errors'] = '';
//$_SESSION ['cart']->get_isvalid_checkout ( true );
//$_SESSION ['cart']->calculate();
//Tianwen.Wan20160624购物车优化
$page_size = 100;
$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize($page_size, $page, false, false, true);
$products = $products_array['data'];
$products_num = $products_array['count'];
$is_checked_all = $products_array['is_checked_all'];
//christmas gift
if (!$_SESSION ['valid_to_checkout']) {
	if ($_SESSION ['cart_errors_min'] != '') {
		$messageStack->add ( 'cart_errors_min', ERROR_CART_UPDATE . $_SESSION ['cart_errors_min'], 'caution' );
	}
	if ($_SESSION ['cart_products_errors'] != '') {
		$cart_products_down_errors.=$_SESSION['cart_products_errors'];
	}
}
//echo $_SESSION ['cart']->show_total();exit;
$cart_products_down_errors.= $_SESSION['cart_products_down_errors'];
$cart_products_out_stoct_errors = $_SESSION['cart_products_out_stoct_errors'];
unset($_SESSION['cart_products_down_errors']);
unset($_SESSION['cart_products_out_stoct_errors']);
$smarty->assign ( 'cart_products_down_errors', $cart_products_down_errors );
$smarty->assign ( 'cart_products_out_stoct_errors', $cart_products_out_stoct_errors );
$smarty->assign ( 'cart_has_buy_facebook_like_product_errors', $_SESSION['cart_has_buy_facebook_like_product_errors'] );
unset($_SESSION['cart_has_buy_facebook_like_product_errors']);

// bof customer vip info
$history_amount = 0; // customer all orders total amount
$cVipInfo = getCustomerVipInfo ();
$cNextVipInfo = getCustomerVipInfo ( true );
$smarty->assign('channel_status' , $_SESSION['channel']);
$prom_discount_note = '';
if ($is_login) {
	//订单折扣与 VIP&RCD取大者
	$promInfo = calculate_order_discount();
	$prom_discount = $promInfo['order_discount'];
	$prom_discount_title = $promInfo['order_discount_title'];
	
	$vip_rcd_discount = $cVipInfo['amount'];
	$rcd_discount = 0;

	if($_SESSION ['cart']->show_total_new() > $_SESSION['cart']->show_promotion_total()){
		$total_amount = $_SESSION ['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total();//正价商品总金额·

		/*满减活动*/ 
		if(date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME){
			if ($total_amount > $currencies->format_cl( 49 )) {
				$discount = floor($total_amount/$currencies->format_cl( 49 )) * $currencies->format_wei( 4 );
				$total_amount = $total_amount - $discount;
			}
		}
		/*阶梯式满减活动*/
		if(date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && !$_SESSION['channel']){
			if ($total_amount > $currencies->format_cl( 379 )) {
				$discount = 25;
			}elseif($total_amount > $currencies->format_cl( 259 )){
				$discount = 20;
			}elseif($total_amount > $currencies->format_cl( 149 )){
				$discount = 10;
			}elseif($total_amount > $currencies->format_cl( 49 )){
				$discount = 5;
			}elseif($total_amount > $currencies->format_cl( 19 )){
                $discount = 1;
            }else{
				$discount = 0;
			}
			
			$total_amount = $total_amount - $currencies->format_cl($discount);
		}

        $total_amount -= $cVipInfo['amount'];

        if (!zen_get_customer_create() && !get_with_channel()) {
			$rcd_discount = round(0.03 * ($total_amount), 2);
			$vip_rcd_discount += $rcd_discount;
		}
	}
	if($prom_discount >= $vip_rcd_discount){
		$cVipInfo['amount'] = 0;
		$rcd_discount = 0;
		$show_current_discount = '';
		$prom_discount_note = zen_get_discount_note();
	}else{
		$prom_discount = 0;
		$prom_discount_title = '';
		$show_current_discount = $currencies->format($rcd_discount, false);
		
	}
	//eof
	$tenoff = 0;
    $smarty->assign ( 'manjian_discount', $discount );
	$smarty->assign ( 'tenoff', $tenoff );
	$smarty->assign ( 'prom_discount', $currencies->format_cl($prom_discount, false));
	$smarty->assign ( 'prom_discount_format', $currencies->format($prom_discount, false));
	$smarty->assign ( 'prom_discount_title', $prom_discount_title);
	$smarty->assign ( 'rcd_discount', $rcd_discount);
	$smarty->assign ( 'show_current_discount', $show_current_discount);

	$order_total = $db->Execute ( "Select sum(order_total) as total From " . TABLE_ORDERS . " Where orders_status in (" . MODULE_ORDER_PAID_VALID_REFUND_STATUS_ID_GROUP . ") And customers_id = " . ( int ) $_SESSION ['customer_id'] );
	$declare_total = $db->Execute ( 'Select sum(usd_order_total) as d_total From ' . TABLE_DECLARE_ORDERS . " Where status>0 and customer_id = " . ( int ) $_SESSION ['customer_id'] );
	$history_amount = $order_total->fields ['total'] + $declare_total->fields ['d_total'];
} else {
	$prom_discount_note = zen_get_discount_note();
}
$width_vip_li = round ( $history_amount / $cNextVipInfo ['max_amt'], 2 ) * 100;

$smarty->assign ( 'prom_discount_note', $prom_discount_note );
$smarty->assign ( 'cVipInfo', $cVipInfo );
$smarty->assign ( 'cNextVipInfo', $cNextVipInfo );
$smarty->assign ( 'history_amount', floor ( $history_amount ) );
$smarty->assign ( 'width_vip_li', $width_vip_li );
// eof

$smarty->assign ( 'products_num', $products_num );

$smarty->assign ( 'total_weight', $_SESSION ['cart']->show_weight () );
$smarty->assign ( 'total_items', $products_num );
$smarty->assign ( 'is_checked_count', $products_array['is_checked_count'] );
$smarty->assign ( 'total_amount', $currencies->format($_SESSION ['cart']->show_total (), false) );
$smarty->assign ( 'total_amount_convert', $currencies->format($_SESSION ['cart']->show_total_new (), false) );
$smarty->assign ( 'show_total_new_cart', $_SESSION['cart']->show_total_new() * 3 / 100);
$smarty->assign ( 'currency_symbol_left', $currencies->currencies [$_SESSION ['currency']] ['symbol_left'] );
//bof fen ye

if ($products_num > $page_size){
	$products_split = new splitPageResults('', $page_size, '', 'page', false, $products_array['count']);
	$cart_fen_ye = '<div class="cart_split_page propagelist">' . $products_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))) . '</div>';
}else{
	$cart_fen_ye = '';
}
$smarty->assign ( 'cart_fen_ye', $cart_fen_ye );
//eof
//christmas gift
$_SESSION ['cart']->check_gift();
//$smarty->assign ( 'gift_id', $_SESSION['gift_id']);
$smarty->assign ( 'gift_id', 0);

$_SESSION['basket_product_orderby'] = true;
//$products = $_SESSION ['cart']->get_products ( false, $page_size );

$promotion_discount = '';
$cate_total = 0;
for($i = 0, $n = sizeof ( $products ); $i < $n; $i ++) {
	$product_name = htmlspecialchars ( zen_clean_html ( $products [$i] ['name'] ) );
	$product_link = zen_href_link ( 'product_info', 'products_id=' . $products [$i] ['id'] );
	$product_image = (IMAGE_SHOPPING_CART_STATUS == 1 ? '<img class="jq_products_image_small lazy-img" data-id="' . $i . '" width="88" height="88" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $products [$i] ['image'], 80, 80 ) . '" data-original="' . HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $products [$i] ['image'], 500, 500 ) . '" alt="' . $product_name . '">' : '');
	$qty = $products [$i] ['quantity'];
	//show promotion max num per order
	$promotion_info = get_product_promotion_info($products[$i]['id']);
	if (isset($promotion_info['pp_max_num_per_order']) && $promotion_info['pp_max_num_per_order'] > 0) {
		$pp_max_num_per_order = $promotion_info['pp_max_num_per_order'];
		$max_num_per_order_tips = sprintf(TEXT_DISCOUNT_PRODUCTS_MAX_NUMBER_TIPS, $pp_max_num_per_order);
		if ($qty > $pp_max_num_per_order) {
			$products [$i] ['final_price'] = $products [$i] ['original_price'];
		}
	}else{
		$pp_max_num_per_order = 0;
		$max_num_per_order_tips = '';
	}
	$product_each_price = $currencies->format_cl ( zen_add_tax ( $products [$i] ['final_price'], zen_get_tax_rate ( $products [$i] ['tax_class_id'] ) ) );
	$product_each_price_original = $currencies->format_cl ( zen_add_tax ( $products [$i] ['original_price'], zen_get_tax_rate ( $products [$i] ['tax_class_id'] ) ) );
	$product_total_amount = $currencies->format_cl ( $product_each_price * $products [$i] ['quantity'], false );
	$products_model = $products [$i] ['model'];
	$discount_amount = zen_show_discount_amount ( $products [$i] ['id'] );
	$first_cate_info = zen_get_first_cate($products [$i] ['id']);
	$productArray [$i] = array ('product_link' => $product_link,
			'product_image' => $product_image,
			'product_name' =>  ($products [$i] ['product_quantity']==0 ? TEXT_PREORDER.' ':'') . getstrbylength ( $product_name, 100 ), 
			'product_name_all' => $product_name,
			'id' => $products [$i] ['id'],
			'qty' => $qty,
			'model' => $products_model,
			'weight' => $products [$i] ['weight'],
			'volume_weight' => $products [$i] ['volume_weight'],
			'price' => $currencies->format($product_each_price, false),
			'original_price' => $currencies->format($product_each_price_original, false),
			'total' => $currencies->format($product_total_amount, false),
			'total_number' => $product_total_amount,
			'is_checked' => $products [$i] ['is_checked'],
		    'note' => $products [$i] ['note'],
			'customers_basket_id' => $products [$i] ['customers_basket_id'],
			'discount' => $discount_amount,
			'update_qty_note' => '',
			'product_quantity' => $products [$i] ['product_quantity'],
			'cate_id' => $first_cate_info['categories_id'],
			'cate_name' => $first_cate_info['categories_name'],
			'is_preorder' => $products[$i]['product_quantity']==0,
			'is_gift' => 0,
			'products_qty_update_auto_note' => $products[$i]['products_qty_update_auto_note'],
			'pp_max_num_per_order' => $pp_max_num_per_order,
			'max_num_per_order_tips' => $max_num_per_order_tips,
    	    'products_stocking_days' => get_products_info_memcache($products [$i] ['id'], 'products_stocking_days'),
    	    'is_s_level_product' => get_products_info_memcache($products [$i] ['id'], 'is_s_level_product')
	);
}

$smarty->assign('is_checked_all', $is_checked_all);
if ($_SESSION['cart_sort_by'] == 'cate') {
	$products_sort = zen_get_shopping_cart_category($productArray);
	$productArray = $products_sort['productsArr'];
	$smarty->assign ( 'product_array', $products_sort ['productsArr'] );
	$smarty->assign ( 'cate_total_arr', $products_sort ['cate_total_arr'] );
}else{
	$smarty->assign ( 'product_array', $productArray );
}
$smarty->assign ( 'total_amount_original',  $currencies->format($_SESSION ['cart']->show_origin_amount (), false));
$smarty->assign ( 'total_amount_discount', $currencies->format($_SESSION ['cart']->show_discount_amount (), false) );
$promotion_discount = $_SESSION ['cart']->show_total_original () - $_SESSION ['cart']->show_total_new ();
$smarty->assign ( 'promotion_discount', $promotion_discount);
$smarty->assign ( 'promotion_discount_format', $currencies->format($promotion_discount, false));
$original_prices = $_SESSION ['cart']->show_origin_amount () + $_SESSION ['cart']->show_discount_amount ();
$smarty->assign ( 'original_prices', $currencies->format($original_prices, false) );

$total_all = $_SESSION ['cart']->show_total_new () - $prom_discount - $cVipInfo ['amount'] -  $rcd_discount ;


$pay_total = 9.99;
if($total_all < $currencies->format_cl($pay_total)){
   $handing_fee_format = 0.99;
   $handing_fee = $currencies->format_cl($handing_fee_format);
   $total_all = $total_all + $handing_fee;
}

$vip_rcd = $cVipInfo ['amount'] + $rcd_discount;

if($prom_discount >= $vip_rcd){
    $discounts = $prom_discount + $promotion_discount + $discount;
}else{
    $discounts = $vip_rcd + $promotion_discount + $discount;
}
$is_handing_fee = $total_all -$handing_fee - $currencies->format_cl($pay_total);

$smarty->assign ( 'is_handing_fee',$is_handing_fee );
$smarty->assign ( 'handing_fee_format',$handing_fee );
$smarty->assign ( 'handing_fee', $currencies->format($handing_fee, false) );
$smarty->assign ( 'discounts', $discounts );
$smarty->assign ( 'discounts_format', $currencies->format($discounts, false) );

// bof get customer country id
if(isset($_SESSION['cart_country_id']) && $_SESSION['cart_country_id'] != ''){
	$country_id = $_SESSION['cart_country_id'];
	if ($is_login) {
		$customer = $db->Execute ( 'select ab.entry_country_id, c.customers_country_id, ab.entry_postcode, ab.entry_city from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_ADDRESS_BOOK . ' ab where c.customers_id = ' . $_SESSION ['customer_id'] . ' and ab.address_book_id = c.customers_default_address_id and ab.entry_country_id = ' . $country_id );
		if ($customer->RecordCount () == 1) {
			$customer_default_postcode = $customer->fields ['entry_postcode'];
			$customer_default_city = $customer->fields ['entry_city'];
		}
	}
}else{
	if ($is_login) {
		$customer = $db->Execute ( 'select ab.entry_country_id, c.customers_country_id, ab.entry_postcode, ab.entry_city from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_ADDRESS_BOOK . ' ab where c.customers_id = ' . $_SESSION ['customer_id'] . ' and ab.address_book_id = c.customers_default_address_id' );
		if ($customer->RecordCount () == 1) {
			$country_id = $customer->fields ['entry_country_id'];
			$customer_default_postcode = $customer->fields ['entry_postcode'];
			$customer_default_city = $customer->fields ['entry_city'];
		} else {
			$country = $db->Execute ( 'select customers_country_id from ' . TABLE_CUSTOMERS . ' where customers_id = ' . $_SESSION ['customer_id'] );
			$country_id = $country->fields ['customers_country_id'];
		}
	} else {
// 		require (DIR_WS_CLASSES . 'check_ip_address.php');
//		$checkIpAddress = new checkIpAddress;
		$checkIpAddress->get_country_code();
		$country_code = ($checkIpAddress->countryCode == '' ? 'US' : $checkIpAddress->countryCode);
		$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false);
		$country_id_query = $db->Execute ( 'select countries_id from ' . TABLE_COUNTRIES . ' where countries_iso_code_2 = "' . $country_code . '"' );
		$country_id = $country_id_query->fields ['countries_id'];
	}
}
//eof

// get active coupon  20170329 
$coupon_array = array();
if ($is_login) {
	$coupon_sql = "SELECT c.coupon_code, c.coupon_amount, c.coupon_minimum_order FROM " . TABLE_COUPONS . " c, " . TABLE_COUPON_CUSTOMER . " cc WHERE c.coupon_id = cc.cc_coupon_id AND cc.cc_coupon_status = 10 AND cc.cc_customers_id = " . $_SESSION['customer_id'] .' ORDER BY cc.date_created DESC LIMIT 5';
	$coupon_query = $db->Execute($coupon_sql);
	if ($coupon_query->RecordCount() > 0) {
		while (!$coupon_query->EOF) {
			$coupon_array[] = array('coupon_code' => $coupon_query->fields['coupon_code'],
								'coupon_amount' => $currencies->format( $coupon_query->fields['coupon_amount'] ),
								'coupon_minimum_order' => $currencies->format( $coupon_query->fields['coupon_minimum_order'] )
								);
			$coupon_query->MoveNext();
		}
	}
}

$text_countries_list = zen_get_country_select('zone_country_id', $country_id, $_SESSION['languages_id'], 'id="country"');
$country_info = zen_get_countries($country_id);
$text_countries_list .= zen_draw_hidden_field('country_name', $country_info['countries_name']);
$smarty->assign ( 'text_countries_list', $text_countries_list );
$smarty->assign ( 'customer_default_postcode', $customer_default_postcode );
$smarty->assign ( 'customer_default_city', $customer_default_city );

//bof recently viewed products
$r_products = get_recently_viewed_lazy_products();
$smarty->assign ( 'r_products', $r_products );
$smarty->assign ('customers_id',$_SESSION['customer_id']);
//eof
$smarty->assign ( 'messageStack', $messageStack );
$smarty->assign('shipping_content', '<img src="includes/templates/cherry_zen/images/zen_loader.gif">');
$smarty->assign('vip_content', '<img src="includes/templates/cherry_zen/images/zen_loader.gif">');
$smarty->assign('special_discount_title', '');
$smarty->assign('special_discount_content', '');

$smarty->assign('coupon_array', $coupon_array);

$open_live_chat_url = 'onclick="window.open(\'' . HTTP_LIVECHAT_URL . '/request.php?langs='.$_SESSION['language'].'&amp;uname='.$_SESSION['customer_first_name'].'&amp;uemail='.$url_email.'&amp;l=HongShengXie&amp;x=1&amp;deptid=1&amp;pagex=http%3A//'.$_SERVER['REQUEST_URI'].'\',\'unique\',\'scrollbars=no,menubar=no,resizable=0,location=no,screenX=50,screenY=0,width=500,height=400\')"';

if($write_shopping_log) {
	write_file("log/shopping_cart_log/", "shopping_cart_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n");
}
/**
 * 批量添加购物车
 * @param array
 * @return array
 */
function addToCartBatch($datas) {
	global $db;
	$successes = $updates = $notOnSales = $soldOuts = $limitStocks = $errorQuantitis = $notExists = array();
	$my_products_sql = "select products_id, customers_id from " . TABLE_MY_PRODUCTS;
	$my_products_result = $db->Execute($my_products_sql);
	$my_products_array = array();
	while (!$my_products_result->EOF) {
		$my_products_array[$my_products_result->fields['products_id']][] = $my_products_result->fields['customers_id'];
		$my_products_result->MoveNext();
	}
	foreach($datas as $info) {
		$action = "insert";
		if (!empty($info['products_model']) && is_numeric($info['products_quantity']) && $info['products_quantity'] > 0) {
			$product_result = $db->Execute ( "select products_id, products_status, is_sold_out, products_limit_stock from " . TABLE_PRODUCTS . " where products_model = '" . $info['products_model'] . "'" );
			if ($product_result->RecordCount() != 0) {
				$products_quantity_data = zen_get_products_stock($product_result->fields['products_id']);
				$product_result->fields['products_quantity'] = $products_quantity_data;

				$product_id = $product_result->fields['products_id'];
				/*if($product_result->fields['products_status'] == 10) {
					array_push($notOnSales, $info['products_model']);
				} else if(($product_result->fields['products_quantity'] == 0 && $product_result->fields['products_status'] == 1 && $product_result->fields['is_sold_out'] == 1) || ($product_result->fields['products_status'] == 0 && !in_array($_SESSION['customer_id'], $my_products_array[$product_id]))){
					array_push($notOnSales, $info['products_model']);
				}else{*/
					if($product_id != 28675){
						$action = $_SESSION ['cart']->add_cart ($product_id, $info['products_quantity']);
						
						array_push($successes, $info['products_model']);
					}
				//}
				if($action == "update") {
					array_push($updates, $info['products_model']);
				}
			} else {
				array_push($notExists, $info['products_model']);
			}
		} else {
			array_push($errorQuantitis, $info['products_model']);
		}
	}
	return array('successes' => $successes, 'updates' => $updates, 'not_on_sales' => $notOnSales, 'sold_outs' => $soldOuts, 'limit_stocks' => $limitStocks, 'error_quantitis' => $errorQuantitis, 'not_exists' => $notExists);
}
?>