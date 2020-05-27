<?php
set_time_limit(600);
$zco_notifier->notify('NOTIFY_HEADER_START_QUICK_REORDER');

if (!$_SESSION['customer_id']) {
    $_SESSION['navigation']->set_snapshot();
    zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
} else {
    // validate customer
    if (zen_get_customer_validate_session($_SESSION['customer_id']) == false) {
      $_SESSION['navigation']->set_snapshot();
      zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
    }
}
require(DIR_WS_CLASSES . 'order.php');
if(isset($_GET['oid'])){
	$order = new order((int)$_GET['oid']);
}else{
	zen_redirect(zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}
for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
	$products_id = $order->products[$i]['id'];
	$products_qty = $order->products[$i]['qty'];
	
	if ($products_qty > 0 && $products_id!=$_SESSION['gift_id']){
		//PRINT_R($_SESSION['cart']);EXIT;
		if($_SESSION['cart']->in_cart($products_id)){
			  $orl_number = $_SESSION['cart']->get_quantity($products_id);
			  $products_qty = $orl_number + $products_qty;
			  $_SESSION['cart']->update_quantity($products_id, $products_qty);
		}else {
			  $_SESSION['cart']->add_cart($products_id, $products_qty);
		}
	}
}
if($i > 0){
	zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
}

$zco_notifier->notify('NOTIFY_HEADER_END_QUICK_REORDER');
?>