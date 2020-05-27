<?php
require ('includes/application_top.php');

$pid = intval ( $_POST ['productid'] ); // 产品ID
$qty = intval ( $_POST ['number'] ); // 个数
$action = isset($_POST['action']) && $_POST['action'] != '' ? $_POST['action'] : '';
$err = '';
if (! $pid) {
	echo "";
	exit ();
}
$new_qty = $qty;
global $db;
$is_incart = $_SESSION ['cart']->in_cart ( $pid ) ? 1 : 0;
if ($is_incart && $action == 'order_detail_add'){
	echo 'incart';
	exit ();
}
$query_result = $db->Execute ( $sql );
$query_result = new stdClass();
$query_result->fields = get_products_info_memcache($pid);
// echo $sql . '|'. $query_result->RecordCount ();exit;
if (empty($query_result->fields)) {
	if ($action == 'order_detail_add'){
		echo 'soldout';
	}
	exit ();
}
$is_promotion = false;
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
if($check_binded->fields['customers_id']>0 && $query_result->fields['products_status']>0){
	$db->Execute("update ".TABLE_PRODUCTS." set products_status=0 where products_id='".$pid."'");
	$query_result->fields['products_status'] =0;
}

if($query_result->fields['products_status']<1 && !check_my_product($_SESSION['customer_id'], $pid)) exit;
$query_result->fields ['products_quantity'] = zen_get_products_stock($pid);
$products_quantity = $query_result->fields ['products_quantity'];
$products_model = $query_result->fields ['products_model'];
$products_order_min = $query_result->fields ['products_quantity_order_min'];
$products_order_max = $query_result->fields ['products_quantity_order_max'];

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
//暂时屏蔽掉计算总价的影响性能，Tianwen.Wan20141013
//$_SESSION ['cart']->calculate ();
echo $_SESSION ['cart']->get_products_items ();
echo "|";
echo $new_qty;
echo "|";
echo $err;
echo "|";
echo $currencies->format ( $_SESSION ['cart']->show_total () );	
?>
