<?php
require('includes/application_top.php');

if (isset($_POST['check_action']) && $_POST['check_action'] == 'check_have_buy'){
	$check_result = "NOT_BUY";
	 
	$product_id = intval($_POST['product_id']);
	$customer_id = intval($_SESSION['customer_id']);
	
	if($product_id > 0 && $customer_id > 0){
		$customer_products_qrray = array();
		$customer_products_sql = 'SELECT products_id FROM ' . TABLE_ORDERS_PRODUCTS . ' INNER JOIN ' . TABLE_ORDERS . ' on ' . TABLE_ORDERS_PRODUCTS . '.orders_id = ' . TABLE_ORDERS . '.orders_id WHERE customers_id = ' . $customer_id . ' AND orders_status in (' . MODULE_ORDER_PAID_VAILD_ALL_SATUS_ID_GROUP . ')';
		//print_r($customer_products_sql);exit;
		$customer_products_query = $db->Execute($customer_products_sql);

		while (!$customer_products_query->EOF){
			$customer_products_qrray[] = $customer_products_query->fields['products_id'];
			$customer_products_query->MoveNext();
		}

		if(in_array($product_id, $customer_products_qrray)){
			$check_result = "HAVE_BUY";
		}
	}
	echo $check_result;

	exit;
}

?>