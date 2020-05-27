<?php
require ('includes/application_top.php');
set_time_limit ( 600 );
require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/account.php');
$order_id = zen_db_prepare_input ( $_POST ['order_id'] );

require (DIR_WS_CLASSES . 'order.php');
$order = new order ( ( int ) $order_id );
$products_sold_out = '';
$j = 0;
$products_info = array();

for($i = 0, $n = sizeof ( $order->products ); $i < $n; $i ++) {
	$products_id = $order->products [$i] ['id'];
	$products_qty = $order->products [$i] ['qty'];
	$products_model = $order->products [$i] ['model'];
	
	$products_info = get_products_info_memcache($products_id);
	if ($products_info['products_status'] != 1) {
		$products_sold_out .= $products_model . ', ';
		$j++;
	}else{
		$_SESSION ['cart']->add_cart ( $products_id, $products_qty );
	}
}
$products_sold_out = substr($products_sold_out, 0, -2);

if ($j > 0){
	$text = sprintf(TEXT_REORDER_REMOVED_TIPS, $products_sold_out);
}else{
	$text = '';
}	

echo trim($text);
?>