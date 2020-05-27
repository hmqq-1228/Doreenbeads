<?php
/**
 * continued payment for order header
 * @author wei.liang
 * @version 2.0
*/
set_time_limit ( 600 );
$zco_notifier->notify ( 'NOTIFY_HEADER_START_ORDER_PRODUCT_SNAPSHOT' );
$page_account = true;

require (DIR_WS_CLASSES . 'order.php');
require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/product_info.php');

if ((isset ( $_GET ['oID'] ) && ( int ) $_GET ['oID'] > 0) && (isset ( $_GET ['pID'] ) && ( int ) $_GET ['pID'] > 0)) {
	global $db;
	$order_products_snapshot = true;
	$order = new order ( ( int ) $_GET ['oID'] );
	
	// lxy: check if this is my order

		$products_order_query = "select	products_model, products_name, products_weight_quick, products_categories_name, 
										products_categories_id, products_description, final_price, products_quantity
								from " . TABLE_ORDERS_PRODUCTS . "
								where orders_id = '" . ( int ) $_GET ['oID'] . "' and	products_id = '" . ( int ) $_GET ['pID'] . "' limit 1";
		$products_order = $db->Execute ( $products_order_query );
		
		$products_img_query = "select  products_image,products_status
								from " . TABLE_PRODUCTS . "
								where products_id = '" . ( int ) $_GET ['pID'] . "' limit 1";
		$products_img = $db->Execute ( $products_img_query );
		$products_price = $currencies->format ( zen_add_tax ( $products_order->fields ['final_price'], 0 ), true, $order->info ['currency'], $order->info ['currency_value'] );
		$smarty->assign ( 'phoycont_date_purchased', zen_date_short ( $order->info ['date_purchased'] ) );
		$smarty->assign ( 'order', $order );
		$smarty->assign ( 'oid', ( int ) $_GET ['oID'] );
		
		$message['phoycont_number'] = TEXT_ORDER_PRODUCTS_PHOTCONT_NUMBER;
		$message['phoycont_your_price'] = TEXT_CART_UNIT_PRICE;
		$message['phoycont_pack'] = TEXT_ORDER_PRODUCTS_PHOTCONT_PACK;
		$message['phoycont_packs'] = TEXT_ORDER_PRODUCTS_PHOTCONT_PACKS;
		$message['phoycont_shipping_weight'] = TEXT_ORDER_PRODUCTS_PHOTCONT_SHIPPING_WEIGHT;
		$message['phoycont_order_qty'] = TEXT_ORDER_PRODUCTS_PHOTCONT_ORDER_QTY;
		$message['phoycont_product_category'] = TEXT_ORDER_PRODUCTS_PHOTCONT_PRODUCT_CATEGORY;
		$message['phoycont_this_is_snapshot'] = TEXT_ORDER_PRODUCTS_PHOTCONT_THIS_IS_SNAPSHOT;
		$message['phoycont_view_detail'] = TEXT_ORDER_PRODUCTS_PHOTCONT_VIEW_DETAIL;
		$message['phoycont_order_information'] = TEXT_ORDER_PRODUCTS_PHOTCONT_ORDER_INFORMATION;
		$message['phoycont_order_number'] = TEXT_ORDER_PRODUCTS_PHOTCONT_ORDER_NUMBER;
		$message['phoycont_order_date'] = TEXT_ORDER_PRODUCTS_PHOTCONT_ORDER_DATE;
		$message['phoycont_order_status'] = TEXT_ORDER_PRODUCTS_PHOTCONT_ORDER_STATUS;
		$message['phoycont_note'] = TEXT_ORDER_PRODUCTS_PHOTCONT_NOTE;
		$message['phoycont_discription'] = TEXT_DISCRIPTION;
		$message['phoycont_date_purchased'] = zen_date_long($order->info['date_purchased']);
		$message['phoycont_grams'] = TEXT_GRAMS;
		$message['session_languages_id'] = $_SESSION['languages_id'];
		$message['products_is_not_fount'] = TEXT_PRODUCT_NOT_FOUND;
		$smarty->assign ( 'message', $message );
		
		$products_count = $products_order->RecordCount ();
		if ($products_count > 0) {
			if ($products_img->RecordCount ()) {
				$img_dir = HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $products_img->fields ['products_image'], 310, 310 );
				$smarty->assign ( 'img_dir', $img_dir );
				$smarty->assign ( 'products_status', $products_img->fields ['products_status'] );
			}
			$cPath_new = 'cPath=' . get_category_info_memcache ( $products_order->fields ['products_categories_id'] , 'cPath' );
			$cPath_url = zen_href_link ( FILENAME_DEFAULT, $cPath_new );
			$products_link = zen_href_link ( FILENAME_PRODUCT_INFO, 'products_id=' . ( int ) $_GET ['pID'] );
			$smarty->assign ( 'cPath_url', $cPath_url );
			$smarty->assign ( 'products_link', $products_link );
			$smarty->assign ( 'products_price', $products_price );
			$smarty->assign ( 'products_order', $products_order->fields );

			
	
		
		$smarty->caching = 0;
	} else {
		$smarty->assign ( 'not_fount', 'true' );
	}
}

$zco_notifier->notify ( 'NOTIFY_HEADER_END_ORDER_PRODUCT_SNAPSHOT' );
?>
