<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action'])) {
	$limit = "";
	if($_GET['action'] == "check") {
		//$result = $db->Execute("select t1.*, o.order_total, o.orders_status, o.date_purchased from (select orders_id, count(*) count from " . TABLE_ORDERS_PRODUCTS . " where orders_id in(select orders_id from " . TABLE_ORDERS . " where date_purchased>from_unixtime(unix_timestamp()-(86400*2)) and orders_status>0 and orders_status!=5) GROUP BY orders_id HAVING count>300 order by count desc) t1 INNER JOIN zen_orders o on o.orders_id=t1.orders_id");
		$result = $db->Execute("select t1.*, o.order_total, o.orders_status, o.date_purchased from (select o.orders_id, count(1) count from " . TABLE_ORDERS_PRODUCTS . " op inner join " . TABLE_ORDERS . " o on o.orders_id=op.orders_id where o.date_purchased>from_unixtime(unix_timestamp()-(86400*1)) and o.orders_status>0 and o.orders_status!=5 group by o.orders_id having count>300) t1 INNER JOIN " . TABLE_ORDERS . " o on o.orders_id=t1.orders_id");
		$categories_str = '<table style="width:540px; margin-top:11px; font-size:12px;" border="1" rules="all">
			<tr>
				<td width="10%" align="left">订单ID</td>
				<td width="20%" align="left">产品数量</td>
				<td width="20%" align="left">订单金额</td>
				<td width="20%" align="left">订单状态</td>
				<td width="30%" align="left">下单时间</td>
			</tr>';
		$count_catogires = $count_products = 0;
		$html_msg['EMAIL_MESSAGE_HTML'] = '';
		while (!$result->EOF) {
			$categories_str .= '	<tr>
				<td align="left">' . $result->fields['orders_id'] . '</td>
				<td align="left">' . $result->fields['count'] . '</td>
				<td align="left">' . $result->fields['order_total'] . '</td>
				<td align="left">' . $result->fields['orders_status'] . '</td>
				<td align="left">' . $result->fields['date_purchased'] . '</td>
			</tr>';
			$count_catogires++;
			$result->MoveNext();
		}
		$categories_str .= '</table>';
		
	}

	if($count_catogires > 0) {
		$html_msg['EMAIL_MESSAGE_HTML'] .= $categories_str;
	}

	if(!empty($html_msg['EMAIL_MESSAGE_HTML'])) {
		$_SESSION['language'] = 'japanese';
		$_SESSION['languages_id'] = '6';
		$_SESSION['languages_code'] = 'jp';
		$html_msg['EMAIL_MESSAGE_HTML'] .= '<br/><br/><font color=red>备注：此邮件为系统大订单并发送，如有疑问请联系技术部，谢谢！</font>';
		zen_mail('All', 'qilie.kang@panduo.com.cn', '最近一天大订单列表(' . date("Y-m-d-H:i:s") . ')[' . STORE_NAME . ']', strip_tags($html_msg['EMAIL_MESSAGE_HTML']), STORE_NAME, EMAIL_FROM, $html_msg, 'default', '', 'false', 'tingting.hua@panduo.com.cn');
	}	
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>