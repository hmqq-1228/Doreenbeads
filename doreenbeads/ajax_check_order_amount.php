<?php
require ('includes/application_top.php');
$action = isset ( $_POST ['action'] ) && $_POST ['action'] != '' ? $_POST ['action'] : '';
switch ($action) {
	case 'check_amount' :
		$amount = 0;
		$orders_total_sql = $db->Execute ("select * from ".TABLE_ORDERS_TOTAL." where orders_id = ".$_POST ['orders_id']);
		while(!$orders_total_sql->EOF){
			if($orders_total_sql->fields['class'] == 'ot_total')  $amount += $orders_total_sql->fields['value'];
			if($orders_total_sql->fields['class'] == 'ot_extra_amount')  $amount -= $orders_total_sql->fields['value'];
			$orders_total_sql->moveNext();
		}
		$adjust_amout = round($_POST ['adjust_amout']/$_POST['currency'],2);
		$amount += $adjust_amout;
		if( $amount < 0 ) echo true; else echo false;
		break;
}

?>