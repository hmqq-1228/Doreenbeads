<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | export of orders is based on easypopulate module 2005 by langer      |
// +----------------------------------------------------------------------+
// $Id: ordersExport.php,v0.1 2007 matej $
//

require_once ('includes/application_top.php');
@set_time_limit(300); // if possible, let's try for 5 minutes before timeouts
require(DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();
$separator = ","; // only tab allowed


if(isset($_GET['download'])){
	$selectfrom = zen_output_string($_POST['selectfrom']);
	
	if($selectfrom==1){
		$sData['dfrom'] = zen_output_string($_POST['dfrom']);
		$sData['dto'] =zen_output_string($_POST['dto']);
		$sData['time_start'] =zen_output_string($_POST['time_start']);
		$sData['time_end'] =zen_output_string($_POST['time_end']);
	}else{
		$sData['dfrom'] = zen_output_string($_POST['pdfrom']);
		$sData['dto'] =zen_output_string($_POST['pdto']);
		$sData['time_start'] =zen_output_string($_POST['p_time_start']);
		$sData['time_end'] =zen_output_string($_POST['p_time_end']);
	}
	
	
	if($sData['dfrom'] != ''){
		$cust_from= $sData['dfrom'].' '.$sData['time_start'].':00:00';
	}
	if($sData['dto'] != ''){
		$cust_to= $sData['dto'].' '.$sData['time_end'].':00:00';
	}
	if($sData['dfrom'] != '' &&  $sData['dto']== ''){
		echo '<span style="color:red;">The end time cannot be empty</span>';
	}else if($sData['dfrom'] == '' &&  $sData['dto'] != ''){
		echo '<span style="color:red;">The start time cannot be empty</span>';
	}else if($cust_from > $cust_to){
		echo '<span style="color:red;">Start time must be less than the end of time</span>';
	}else{
		if($sData['dfrom'] != "" && $sData['dto']!=""){
			if($selectfrom==1){
				$time_data = ' AND date_purchased > "'.$cust_from.'" AND date_purchased < "'.$cust_to.'"';
			}else{
				$time_data = ' AND os.orders_status_id=2 AND os.date_added > "'.$cust_from.'" AND os.date_added < "'.$cust_to.'"';
			}
		}
	$file_layout = array( 0 => 'Sales Record Number',
						  1 => 'User Id',
						  2 => 'Buyer Full name',
						  3 => 'Buyer Phone Number',
						  4 => 'Buyer Email',
						  5 => 'Buyer Address 1',
						  6 => 'Buyer Address 2',
						  7 => 'Buyer Town/City',
						  8 => 'Buyer County',
						  9 => 'Buyer Postcode',
						  10 => 'Buyer Country',
						  11 => 'Item Number',
						  12 => 'Item Title',
						  13 => 'Custom Label',
						  14 => 'Quantity',
						  15 => 'Sale Price',
						  16 => 'Included VAT Rate',
						  17 => 'Postage and Packing',
						  18 => 'Insurance',
						  19 => 'Total Price',
						  20 => 'Payment Method', /*21-29 not needed*/
						  21 => 'Sale Date',
						  22 => 'Checkout Date',
						  23 => 'Paid on Date',
						  24 => 'Dispatch Date',
						  25 => 'Invoice date',
						  26 => 'Invoice number',
						  27 => 'Feedback left',
						  28 => 'Feedback received',
						  29 => 'Notes to yourself',
						  30 => 'Listed On',
						  31 => 'Sold On',
						  32 => 'PayPal Transaction ID',
						  33 => 'Seller Memo',
						  34 => 'Transaction ID',
						  35 => 'Order ID',
						  36 => 'Language',
						  37 => 'Buyer Company', 
						  38 => 'Postage Service',
					      39 => 'Customers VIP',
						  40 => 'ifpreorder',
						  41 => 'Custom/VAT Number',
						  42 => 'Prod Remk',
						  43 => 'if-remote',
						  44 => 'ifclubmembers',
						  45 => 'Actual prod. price',
						  46 => 'Credit Balance(US$)',
						  47=>'Customers_id'
						);
	$output_str = '';					
	foreach ($file_layout as $fieldName){
		$output_str .= $fieldName.',';
	}
	$output_str .= "\n";
	
	//$sql_condition = " and customers_email_address NOT LIKE '%panduo.com.cn%'";
	$sql_condition='';
		$query_order = "SELECT distinct o.orders_id,customers_id,customers_email_address,customers_telephone,customers_company,delivery_name,
	                     delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, customers_id,currency,currency_value,delivery_telephone,
	                     delivery_state, delivery_country, payment_method,payment_module_code, shipping_module_code,language_id,
	                     shipping_method, date_purchased, delivery_address_remote,o.payment_info FROM ".TABLE_ORDERS." o, ".TABLE_ORDERS_STATUS_HISTORY." os WHERE o.orders_id = os.orders_id AND 	orders_status = 2  ".$time_data." " . $sql_condition;
	$orders = $db->Execute($query_order);
	$total_products_num = 0;
	while(!$orders->EOF){
		$record = array();
		$record[0] = $orders->fields['orders_id'];
		$box_number='';
//		$record[1] = substr($orders->fields['customers_email_address'], 1, 30);
		$record[1] = $orders->fields['customers_email_address'];
		$record[2] = $orders->fields['delivery_name'];
		if(isset($orders->fields['delivery_telephone']) && $orders->fields['delivery_telephone'] != ''){
			$record[3] = $orders->fields['delivery_telephone'];
		}else{
			$record[3] = $orders->fields['customers_telephone'];
		}
		$record[4] = $orders->fields['customers_email_address'];
		$record[5] = preg_replace("/\r\n/"," ",$orders->fields['delivery_street_address']);
		$record[6] = preg_replace("/\r\n/"," ",$orders->fields['delivery_suburb']);
		$record[7] = preg_replace("/\r\n/"," ",$orders->fields['delivery_city']);
		$record[8] = $orders->fields['delivery_state'];
		$record[9] = $orders->fields['delivery_postcode'];
		$record[10] = $orders->fields['delivery_country'];
		$record[23] = $orders->fields['date_purchased'];
		//$record[28] = $orders->fields['shipping_module_code'];
		//$record[33] = substr($orders->fields['shipping_module_code'], 0, strpos($orders->fields['shipping_module_code'], " ("));
		if ($orders->fields['shipping_module_code'] == 'airmail') $orders->fields['shipping_module_code'] = 'zyairmail';
		$record[33] = $orders->fields['shipping_module_code'];
		
		$str_shipping = $orders->fields['shipping_method'];
		if(preg_match('/Total Box Number/', $str_shipping)){
			preg_match_all('/\d+/', $str_shipping, $matches);
			$box_number = $matches[0][0];
		}

		$record[38] = $orders->fields ['shipping_module_code'];
		$record[38].=$box_number?("||".$box_number):'';
		$record[38].=$orders->fields ['delivery_address_remote']?"||P":"";
		$customers_group = $db->Execute('Select group_percentage
								     From ' . TABLE_CUSTOMERS . ' as c, ' . TABLE_GROUP_PRICING . ' as gp 
								  Where c.customers_group_pricing = gp.group_id 
								  And customers_id = ' . $orders->fields['customers_id']);
		if(isset($customers_group->fields['group_percentage']) && $customers_group->fields['group_percentage'] > 0){
			$record[39] = $customers_group->fields['group_percentage'].'%';
		}else{
			$record[39] = '0%';//'6.01$';
		}
		$tariff=$db->Execute("select delivery_tariff_number from ".TABLE_ORDERS." where order_id = ".(int)$orders->fields ['orders_id']."  limit 1");
		if($tariff->RecordCount() > 0){
			$record[41] = $tariff->fields['delivery_tariff_number'];
					
		}else{
			$record[41] = '/';
		}
		$record[43] = $orders->fields ['delivery_address_remote'];
		$order_memo = $db->Execute("Select orders_id, comments from " . TABLE_ORDERS_STATUS_HISTORY . " Where orders_id = '" 
			. $orders->fields['orders_id'] . "' Order By orders_status_history_id asc");
		$ls_memo = preg_replace("/\r\n/","",$order_memo->fields["comments"]);
		$ls_memo = str_replace(chr(13) . chr(10), ' ', $ls_memo);
		$ls_memo = str_replace ( ",", " ", $ls_memo );
		$ls_memo = mb_substr ( $ls_memo, 0, 400, 'utf-8');
		$ls_memo = preg_replace("/\n/","",$ls_memo); 
		$record[33] = $ls_memo;
		
		$seller_memo = $db->Execute ( 'Select seller_memo from ' . TABLE_ORDERS . ' Where orders_id = ' . $orders->fields ['orders_id'] );
		if (zen_not_null($seller_memo->fields['seller_memo'])){
			$record[33] .= '||' . preg_replace("/\r\n/","",$seller_memo->fields['seller_memo']);
		}		
		$lang_query = $db->Execute("select code from ".TABLE_LANGUAGES." where languages_id='".$orders->fields['language_id']."'");
		$record[36] = $lang_query->fields['code'];
		$record[37] = $orders->fields['customers_company'];
		$query_order_total = "SELECT z.text as text, z.class as class, z.value 
			FROM ".TABLE_ORDERS_TOTAL." z where z.orders_id = ".$record[0] ." order by sort_order asc";
		$order_total = $db->Execute($query_order_total);
		$order_discount = 0;
		$subtotal_usd = 0;
		$ot_cash_account = 0;
		/*
			update by wqz  bof
			add switch case to class
			date:2008-11-1 21:57
		*/
		/*$product_amount = $order_total->fields['text'];
		$order_total->MoveNext();
		$shipping_price = $order_total->fields['text'];
		$order_total->MoveNext();
		if($order_total->fields['class'] <> 'ot_total') $order_total->MoveNext();
		$total_amount = $order_total->fields['text'];
		//$row_cnt = $order_total->num_rows;  //$order_total->fields['text'];
		//for($i = 1; $i < $row_cnt; $i++)*/
		while(!$order_total->EOF)
		{
			$class = $order_total->fields['class'];
			switch($class)
			{
				case 'ot_subtotal':
					$product_amount = $order_total->fields['text'];
					$subtotal_usd = $order_total->fields ['value'];
					break;
				case 'ot_total':
					$total_amount = $order_total->fields['text'];
					break;
				case 'ot_shipping':
					$shipping_price = $order_total->fields['text'];
					break;
				case 'ot_coupon':
				case 'ot_group_pricing':
				case 'ot_promotion':
				case 'ot_cash_account':
				case 'ot_big_orderd':
				case 'ot_discount_coupon':
					$order_discount+=$order_total->fields ['value'];
					break;
			}
			if($class == 'ot_cash_account') $ot_cash_account = $order_total->fields ['value'];
			if($class == 'ot_big_orderd') $special_discount = $order_total->fields ['value'];
			$order_total->MoveNext();
		}
		////eof by weiqizan

		$record[15] = $product_amount;
		$record[16] = '0%';
		$record[17] = $shipping_price;
		$record[18] = 'US $0.00';
		$record[19] = $total_amount;

		$payment_array = (array)json_decode($orders->fields['payment_info']);
		$record[20] = $orders->fields['payment_module_code'];
				
		$record[30]	= HTTP_SERVER;	
		$record[31]	= HTTP_SERVER;

		$record [34] = $payment_array['transaction_id'];	
		
		$actual_total = $subtotal_usd-$order_discount;
		$record [45] = $currencies->format($actual_total,true, $orders->fields['currency'], $orders->fields['currency_value']);
		$record [46] = $ot_cash_account;

		$record [47] = $orders->fields ['customers_id'];
				
		$query_orders_product = "SELECT products_model, products_name, products_price, final_price, note,
		                                                        products_quantity FROM ".TABLE_ORDERS_PRODUCTS." where orders_id = ".$record[0]." order by products_model";
		$orders_product = $db->Execute($query_orders_product);
		$temp = $orders_product->RecordCount();
		$total_products_num += $temp;
		if($temp == 1){
			$record[11] = $orders_product->fields['products_model'];
			$record[12] = strip_tags($orders_product->fields['products_name']);
			$record[13] = $orders_product->fields['products_model'];
			$record[14] = $orders_product->fields['products_quantity'];
			$record [40] = 0;
			$orders_product->fields ['note'] = preg_replace("/\r\n/","",$orders_product->fields ['note']);
			$orders_product->fields ['note'] = str_replace(chr(13) . chr(10), ' ', $orders_product->fields ['note']);
			$orders_product->fields ['note'] = str_replace ( ",", " ", $orders_product->fields ['note'] );
			$orders_product->fields ['note'] = mb_substr ( $orders_product->fields ['note'], 0, 400, 'utf-8');
			$orders_product->fields ['note'] = preg_replace("/\n/","",$orders_product->fields ['note']); 
			$record [42] = $orders_product->fields ['note'];
			$record [43] = $orders->fields ['delivery_address_remote'];
			appendOutputStr($record);
		}else if($temp > 1) {
			appendOutputStr($record);
			while(!$orders_product->EOF){
				$subRecord = array();
				$subRecord[0] = $orders->fields['orders_id'];
				$subRecord[1] = $orders->fields['customers_email_address'];
				$subRecord[11] = $orders_product->fields['products_model'];
				$subRecord[12] = strip_tags($orders_product->fields['products_name']);
				$subRecord[13] = $orders_product->fields['products_model'];
				$subRecord[14] = $orders_product->fields['products_quantity'];
				$subRecord[15] = $currencies->format_cl($orders_product->fields['final_price'], true, $orders->fields['currency'], $orders->fields['currency_value']);
				$subRecord [40] = 0;
				$orders_product->fields ['note'] = preg_replace("/\r\n/","",$orders_product->fields ['note']);
				$orders_product->fields ['note'] = str_replace(chr(13) . chr(10), ' ', $orders_product->fields ['note']);
				$orders_product->fields ['note'] = str_replace ( ",", " ", $orders_product->fields ['note'] );
				$orders_product->fields ['note'] = mb_substr ( $orders_product->fields ['note'], 0, 400, 'utf-8');
				$orders_product->fields ['note'] = preg_replace("/\n/","",$orders_product->fields ['note']); 
				$record [42] = $orders_product->fields ['note'];
				$subRecord [43] = $orders->fields ['delivery_address_remote'];
				
				$price_percent = $orders_product->fields['final_price']/$subtotal_usd;
				$actual_prod_price = $actual_total*$price_percent;
				//$subRecord [44] = $currencies->format($actual_prod_price,true, $orders->fields['currency'], $orders->fields['currency_value']);
				$subRecord [45] = round($actual_prod_price*$orders->fields['currency_value'],4);
				$subRecord [46] = '';
				
				appendOutputStr($subRecord);
				$orders_product->MoveNext();
			}
		}
		//for api product quantity manage
		$db->Execute("update ".TABLE_ORDERS." set is_exported=1 where orders_id='".$orders->fields ['orders_id']."'");
		
		$orders->MoveNext();
	}
	
	$totalRecord = array();
	$totalRecord[0] = $total_products_num;
	$totalRecord[1] = "record(s) downloaded";
	appendOutputStr($totalRecord);
	$lastRecord = array();
	$mail_addr = $db->Execute("select configuration_value as value from ".TABLE_CONFIGURATION." where configuration_key = 'STORE_OWNER_EMAIL_ADDRESS'");
	$addr = $mail_addr->fields["value"];
	$lastRecord[0] = "Seller ID: ".$addr;
	appendOutputStr($lastRecord);
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=OrderExporter(".str_replace('http://','',HTTP_SERVER).").csv");
	// Changed if using SSL, helps prevent program delay/timeout (add to backup.php also)
	if ($request_type== 'NONSSL'){
		header("Pragma: no-cache");
	} else {
		header("Pragma: ");
	}
	header("Expires: 0");
	echo $output_str;
	die();
}
}
function appendOutputStr($record){
	global $output_str, $file_layout;
	if(is_array($record)){
		for($i = 0, $length = count($file_layout); $i < $length; $i++){
			$output_str .= str_replace(',',' ',$record[$i]).",";
		}
		$output_str .= "\n";
	}
}


// THE HTML PAGE IS BELOW HERE 
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
	<title><?php echo TITLE; ?></title>
	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
	<script language="javascript" src="includes/menu.js"></script>
	<script language="javascript" src="includes/general.js"></script>
	<?php echo "<script> window.lang_wdate='".$_SESSION['languages_code']."'; </script>";?>
	<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
	<script type="text/javascript">
	function submit_order_exproter(){
		order_exporter.submit();
	}
		<!--
		function init()
		{
		cssjsmenu('navbar');
		if (document.getElementById)
		{
		var kill = document.getElementById('hoverJS');
		kill.disabled = true;
		}
		}
		// -->
	</script>
	<style>
#selectTb{
	margin: 20px 0 0 20px;
}
#selectTb td{
	line-height: 25px;
    padding: 2px 10px 5px 0;
    vertical-align: top;
}
</style>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<!-- body_text //-->
<?php
		echo zen_draw_separator('pixel_trans.gif', '1', '10');
?>
		<table align="center" border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td class="pageHeading" align="left"><?php echo ORDER_EXPORTER_PAGE_HEADING; ?></td>
		</tr>
		</table>
<?php
		echo zen_draw_separator('pixel_trans.gif', '1', '10');
?>
<form name="order_exporter" action="order_exporter.php?download=stream" method="post">
<table  border="0"  cellspacing="0" cellpadding='0' id="selectTb">
<tr>
<td rowspan=2>
<b>日期筛选：</b>
</td>
<td>
<input type="radio" name='selectfrom' checked='checked' value=2>订单状态改为processing的日期：
</td>
<td>
<?php
echo TEXT_ORDER_EXPORTER_DATE_START." ";
   echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('pdfrom', $sData['dfrom'], 'onClick="WdatePicker();"  onfocus="RemoveFormatString(this, \'' . DATE_FORMAT_STRING . '\')"')); 
   echo zen_draw_input_field('p_time_start', '00', 'size="8"').'(HH)';
   echo '<br/>';
   echo " ".TEXT_ORDER_EXPORTER_DATE_END." &nbsp; ";
   echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('pdto', $sData['pdto'], 'onClick="WdatePicker();"  onfocus="RemoveFormatString(this, \'' . DATE_FORMAT_STRING . '\')"'));  
   echo zen_draw_input_field('p_time_end', '00', 'size="8"').'(HH)';
?>
</td>
</tr>
<tr>
<td>
<input type="radio" name='selectfrom' value=1>下单日期：
</td>
<td>
<?php
echo TEXT_ORDER_EXPORTER_DATE_START." ";
   echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('dfrom', $sData['dfrom'], 'onClick="WdatePicker();"  onfocus="RemoveFormatString(this, \'' . DATE_FORMAT_STRING . '\')"')); 
   echo zen_draw_input_field('time_start', '00', 'size="8"').'(HH)';
   echo '<br/>';
   echo " ".TEXT_ORDER_EXPORTER_DATE_END." &nbsp; ";
   echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('dto', $sData['dto'], 'onClick="WdatePicker();"  onfocus="RemoveFormatString(this, \'' . DATE_FORMAT_STRING . '\')"'));  
   echo zen_draw_input_field('time_end', '00', 'size="8"').'(HH)';
?>
</td>
</tr>
<tr>
<td colspan=3>
<table align="center" width="70%" border="0" cellpadding="8"
	valign="top">
	<tr>
		<td width="100%"><b><?php
		echo ORDERSEXPORT_PAGE_HEADING2;
		?></b> 
		<br />
		<!-- Download file links --> <a
			href="javascript:void(0);" onclick="submit_order_exproter();"><?php
			echo ORDERSEXPORT_LINK_DOWNLOAD1;
			?></a>
		<br />
		</td>
	</tr>
</table>
</td>
</tr>

		
		
</table>
</form>				

<!-- body_text_eof //-->
<!-- body_eof //-->
	<br />

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>