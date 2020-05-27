<?php
require ('includes/application_top.php');
global $db;
$check = false;
/* $sql_basket = "SELECT * FROM ".TABLE_CUSTOMERS_BASKET." WHERE customers_id = :customersID" ;
$sql_basket = $db->bindVars($sql_basket, ':customersID', $_SESSION['customer_id'], 'integer');
$result = $db->Execute($sql_basket); */

$terms_total = (isset ( $_SESSION ['count_cart'] ) ? $_SESSION ['count_cart'] : $_SESSION ['cart']->get_products_items ());

if($terms_total > 0){
	$check = ture;	
}

echo $check;
?>