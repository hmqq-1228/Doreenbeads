<?php
/*
*wei.liang 2013.8.12
*add_basket_note.php
*本页面用于不刷新添加购物车note
*/

	require('includes/application_top.php');
	
	$basket_id = intval($_POST['basket_id']);//购物车ID
	$basket_note = zen_db_prepare_input($_POST['basket_note']);//note
	$err = '';
	if(!$basket_id){
		echo "";exit;
	}
	if(isset($basket_note) && $basket_note != ''){
		$db->Execute("update ".TABLE_CUSTOMERS_BASKET." set note = '".$basket_note."' where customers_basket_id = ".(int)$basket_id."");
		echo 'true';
	}else{
		$db->Execute("update ".TABLE_CUSTOMERS_BASKET." set note = '' where customers_basket_id = ".(int)$basket_id."");
		echo 'true';
	}
?>
