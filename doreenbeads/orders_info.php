<?php
require_once('includes/application_top.php');
$sql="select o.orders_id, o.delivery_country, o.billing_country, o.customers_id, o.customers_name, o.payment_method, o.order_total,o.shipping_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, o.seller_memo, s.orders_status_name, ot.text as order_totals, o.customers_company, o.delivery_country, o.billing_country, o.customers_email_address, o.customers_street_address, o.delivery_company, o.delivery_name, o.delivery_street_address, o.billing_company, o.billing_name, o.billing_street_address, o.payment_module_code, o.shipping_module_code, o.ip_address from (t_orders o, t_orders_status s ) left join t_orders_total ot on (o.orders_id = ot.orders_id) where (o.orders_status = s.orders_status_id and s.language_id = '1' and ot.class = 'ot_total') and date_purchased>='2012-01-01' order by o.orders_id DESC ";

$res=$db->Execute($sql);
echo "<table border=1>";
$a=0;
if($res->RecordCount()>0){
	while (!$res->EOF){
		      	$get_vip_amount_sql="select value from ".TABLE_ORDERS_TOTAL." where class='ot_group_pricing' and orders_id = ".$res->fields['orders_id'];
		      	      	$get_vip_amount=$db->Execute($get_vip_amount_sql);
		if($get_vip_amount->RecordCount()>0){
      	  	$get_sub_total_sql="select value from ".TABLE_ORDERS_TOTAL." where class='ot_subtotal' and orders_id = ".$res->fields['orders_id'];
      		$get_sub_total=$db->Execute($get_sub_total_sql);
      		$vip_discount=(round($get_vip_amount->fields['value']/$get_sub_total->fields['value'],2)*100)."%";
      	}else{
      		$vip_discount="5.01$";
      	}
	
		echo "<tr><td>".$res->fields['orders_id']."</td>
		<td>".$res->fields['payment_module_code']."</td>
		<td>".$res->fields['shipping_module_code']."</td>
		<td>".$res->fields['customers_name']."</td>
		<td>".$res->fields['customers_email_address']."</td>
		<td>".strip_tags($res->fields['order_totals'])."</td>
		<td>".$res->fields['order_total']."</td>
		<td>".$res->fields['date_purchased']."</td>
		<td>".$vip_discount."</td>
		<td>".$res->fields['orders_status_name']."</td>
		<td>".$res->fields['billing_country']."</td>
		</tr>";
      	
      	$a++;
		$res->MoveNext();
	}
}
echo "</table>";
echo $a;