<?php
require ('includes/application_top.php');

$pid = intval ( $_POST ['productid'] ); // 产品ID
$qty = intval ( $_POST ['number'] ); // 个数


if(isset($_POST['action']) && $_POST['action'] == 'add_or_update'){
	$products_id = intval ( $_POST ['productid'] );
    $products_qty = intval ( $_POST ['number'] );
    $products_model = $_POST['model'];
	if ($products_qty > 0){
		//PRINT_R($_SESSION['cart']);EXIT;
		if($_SESSION['cart']->in_cart($products_id)){
			  //$orl_number = $_SESSION['cart']->get_quantity($products_id);
			  //$products_qty = $orl_number + $products_qty;					
			  // 根据需求，添加商品到购物车是根据页面上的input里面的数据直接更新购物车数据，而不是购物车里的原数据与添加的数量相加
			  $_SESSION['cart']->update_quantity($products_id, $products_qty);
		}else {
			  $_SESSION['cart']->add_cart($products_id, $products_qty);
		}
	}
	echo $_SESSION['cart']->get_products_items ();
	exit();
}

//	facebook like 送礼品活动
if(isset($_POST['ac']) && $_POST['ac'] == 'facebook_like_add'){
	if(! zen_is_facebook_like_time()){
		echo '';
		exit();
	}
	$pid = FACEBOOK_LIKE_PRODUCT_ID;
	$qty = 1;
}

//	加载价格信息 for mobile
if(isset($_POST['ac']) && $_POST['ac'] == 'loadprice'){
	$pid = $_POST ['productId'];
	$query_result = new stdClass();
	$query_result->fields = get_products_info_memcache($pid);
	$query_result->fields['products_quantity'] = zen_get_products_stock($pid);
	if($query_result->fields['products_limit_stock']==1 && $query_result->fields ['products_quantity']!=0){
		echo $query_result->fields['products_quantity'].'|||';
	}else{
		echo '0|||';
	}
	echo zen_display_products_quantity_discounts_mobile($pid, $smarty) . '|||';
	
	if($query_result->fields['is_s_level_product'] == 1){
		echo '0|||';
	}else{
    	if($query_result->fields['products_quantity']<=0 && $query_result->fields['is_sold_out']==0){
    		if($query_result->fields['products_stocking_days'] > 7){
    			echo '1|||'. TEXT_AVAILABLE_IN715;
    		}else{
    			echo '1|||'. TEXT_AVAILABLE_IN57;
    		}
    	}else{
    		echo '0|||';
    	}
	}
	
	exit();
}

$action = isset($_POST['action']) && $_POST['action'] != '' ? $_POST['action'] : '';
$err = '';
if (! $pid) {
	echo "";
	exit ();
}
$new_qty = $qty;
$order_total = 0;
global $db;

$query_result = new stdClass();
$query_result->fields = get_products_info_memcache($pid);
// echo $sql . '|'. $query_result->RecordCount ();exit;
if (empty($query_result->fields)) {
	if ($action == 'order_detail_add'){
		echo 'soldout';
	}
	exit ();
}

if ($query_result->fields['products_status'] != 1 && $action == 'order_detail_add') {
	echo 'soldout';
	exit ();
}

/*$is_incart = $_SESSION ['cart']->in_cart ( $pid ) ? 1 : 0;
if ($is_incart && $action == 'order_detail_add'){
	echo 'incart';
	exit ();
}*/

$is_promotion = false;

//临时取消促销限制	xiaoyong.lv20150420
//取消该判断WSL 2015-1-13
//if($query_result->fields['products_is_perorder'] == 1){
// 	if(zen_is_promotion_time()){
	        $promotion_discount = get_products_discount_by_products_id($pid);
	        if($promotion_discount>0){
	            $is_promotion = true;
	        }
//			$promotion_discount_query='select p.promotion_discount from '.TABLE_PROMOTION.' p , '.TABLE_PROMOTION_PRODUCTS.' pp where pp.pp_products_id='.$pid.' and pp.pp_promotion_id=p.promotion_id and p.promotion_status=1 and p.promotion_start_time<="'.date('Y-m-d H:i:s').'" and p.promotion_end_time>"'.date('Y-m-d H:i:s').'" ';
//			$promotion_discount=$db->Execute($promotion_discount_query);
//			if($promotion_discount->fields['promotion_discount']>0){
//				 $is_promotion = true;
//			}
// 	} 
//}

$check_binded = $db->Execute("select customers_id from ".TABLE_MY_PRODUCTS." where products_id='".$pid."'");
if($check_binded->fields['customers_id']>0 && $query_result->fields['products_status'] == "1"){
	$db->Execute("update ".TABLE_PRODUCTS." set products_status=0 where products_id='".$pid."'");
	$query_result->fields['products_status'] =0;
}
if($query_result->fields['products_status'] !="1" && !check_my_product($_SESSION['customer_id'], $pid)) {
	$err = ERROR_PRODUCT_PRODUCTS_BEEN_REMOVED;
} else {
	$query_result->fields ['products_quantity'] = zen_get_products_stock($pid);
	$products_quantity = $query_result->fields ['products_quantity'];
	$products_model = $query_result->fields ['products_model'];
	$products_order_min = $query_result->fields ['products_quantity_order_min'];
	$products_order_max = $query_result->fields ['products_quantity_order_max'];
	
	// 添加商品的数量<=20 >0 并超过库存的时候，需要有弹框。
	if (!$is_mobilesite){ 
		if ($query_result->fields['products_quantity'] <= 20 && $query_result->fields['products_quantity'] > 0 ) {
			if ( ($qty > $query_result->fields['products_quantity']) && $query_result->fields['products_limit_stock'] == 0 ) {
				echo $out_of_qty = 'yes';
				echo "|";
				echo $new_qty = $qty;
				echo "|";
				echo $products_quantity;
				echo "|";
				echo $products_model;
				/*echo "|";
				echo $cart_qty = $_SESSION['cart']->get_quantity($pid);*/
				exit;
			}
		}
	}
	
	if ($products_order_min > 1 && $qty < $products_order_min) {
		$err = sprintf(TEXT_CART_MINIMUM_AMOUNT, $products_model, $products_order_min);
		if($products_quantity != 0 && $products_order_min > $products_quantity){
			$err .= sprintf(TEXT_CART_ONLY_HAVE, $products_quantity, $products_model);
			$new_qty = $products_quantity;
		}else{
			$new_qty = $products_order_min;
		}
	}elseif (($products_quantity!=0 && $qty>$products_quantity && ($query_result->fields['products_limit_stock']==1 || $is_promotion)) || $qty == 2147483647){
		$err = sprintf(TEXT_CART_ONLY_HAVE, $products_quantity, $products_model);
		$new_qty = $products_quantity;
	}
	if ($new_qty > 0) {
		if ($_SESSION ['cart']->in_cart ( $pid )) {
			$_SESSION ['cart']->update_quantity ( $pid, $new_qty );
		} else {
			$_SESSION ['cart']->add_cart ( $pid, $new_qty );
		}
		$new_qty = $_SESSION ['cart']->get_quantity ( $pid );
		$addcart = 1;
	} else {
		$new_qty = 1;
		$addcart = 0;
	}
	$order_total = $currencies->format ( $_SESSION ['cart']->show_total () );
}
//暂时屏蔽掉计算总价的影响性能，Tianwen.Wan20141013
//$_SESSION ['cart']->calculate ();
echo $_SESSION ['cart']->get_products_items() > 999 ? '999+':$_SESSION ['cart']->get_products_items();
echo "|";
echo $new_qty;
echo "|";
echo $err;
echo "|";
echo $order_total;	
?>
