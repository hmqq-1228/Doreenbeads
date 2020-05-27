<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action'])) {
	$html_msg['EMAIL_MESSAGE_HTML'] = '';
	if($_GET['action'] == "check") {
		$result = $db->Execute("select orders_id, order_total, customers_email_address, seller_memo, payment_method, payment_module_code, payment_info, date_purchased, is_exported from " . TABLE_ORDERS . " where orders_status in(2, 42) and order_total>0.00 and date_purchased>from_unixtime(unix_timestamp() - 172800) and (payment_info='' or payment_info like '%:null%') and payment_module_code not like '%Credit%' and payment_module_code not like '%Balance%' and payment_module_code not like '%wire%' and payment_module_code not like '%wirebc%' and payment_module_code not like '%westernunion%' and customers_email_address not like '%panduo.com.cn%' and payment_info!='' and payment_info is not null order by orders_id asc");
		$content = '<table style="width:540px; margin-top:11px; font-size:12px;" border="1" rules="all">
			<tr>
				<td width="20%" align="left">订单号</td>
				<td width="20%" align="left">订单金额</td>
				<td width="60%" align="left">下单时间</td>
			</tr>';
		$count_catogires = $count_products = 0;
		
		while (!$result->EOF) {
			$content .= '	<tr>
				<td align="left">' . $result->fields['orders_id'] . '</td>
				<td align="left">US$ ' . $result->fields['order_total'] . '</td>
				<td align="left">' . $result->fields['date_purchased'] . '</td>
			</tr>';
			$count_catogires++;
			$result->MoveNext();
		}
		$content .= '<tr><td colspan="3" align="right">邮件生成时间：' . $startdate . '</td></tr></table>';
	}
	
	if($count_catogires > 0) {
		$html_msg['EMAIL_MESSAGE_HTML'] .= $content;
	}
	
	if(!empty($html_msg['EMAIL_MESSAGE_HTML'])) {
		$html_msg['EMAIL_MESSAGE_HTML'] .= '<br/><br/><font color=red>备注：此邮件为系统自动检测交易ID缺失异常订单并发送，如有疑问请联系技术部，谢谢！</font>';
		zen_mail('All', 'xi.xia@panduo.com.cn', '最近2天交易ID缺失异常订单(' . date("Ymd_Hi") . ')[' . STORE_NAME . ']', strip_tags($html_msg), STORE_NAME, EMAIL_FROM, $html_msg, 'default', '', 'false', 'qilie.kang@panduo.com.cn');
	}	
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>