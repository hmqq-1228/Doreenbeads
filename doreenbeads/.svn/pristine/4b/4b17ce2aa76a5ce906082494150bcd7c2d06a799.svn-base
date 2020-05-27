<?php
chdir("../");
require ("includes/application_top.php");
//error_reporting(E_ALL^E_DEPRECATED);
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action'])) {
	if (MODULE_UPDATE_PRODUCTS_DISCOUNT_QUANTITY == 10) { // 成功
		$has_error = "【无】";
		$no_error_str = '<table style="width:540px; margin-top:11px; font-size:12px;" border="1" rules="all">
			<tr>
				<td align="center" style="color:green; font-size:18px; font-weight:bold;">恭喜，t_products_discount_discount更新成功</td>
			</tr>';
		$no_error_str .= '<tr><td align="right">邮件生成时间：' . $startdate . '</td></tr></table>';
		$html_msg['EMAIL_MESSAGE_HTML'] .= $no_error_str;
	}else{
		$currency_refresh_time_query = $db->Execute ('select last_modified from ' . TABLE_CONFIGURATION . ' where configuration_key = "CURRENT_CURRENCY" limit 1');
		$currency_refresh_time = $currency_refresh_time_query->fields['last_modified'];
		
		$count_failed_update_query = $db->Execute('select COUNT(DISTINCT products_id) as total from '. TABLE_PRODUCTS_DISCOUNT_QUANTITY .' WHERE last_modified <  "' . $currency_refresh_time . '" and products_id in ( select products_id from ' . TABLE_PRODUCTS . ' )');
		$count_failed_update = $count_failed_update_query->fields['total'];	
		
		$has_error = "【有】";
		if($count_failed_update > 0) {
			$configuration_value = 20;
			$html_msg['EMAIL_MESSAGE_HTML'] .= 't_products_discount_discount失败数： '.$count_failed_update;
		}
		
		if($count_failed_update <= 0 && $count_failed_update <= 0) {
			$configuration_value = 10;
			$has_error = "【无】";
			$no_picture_str = '<table style="width:540px; margin-top:11px; font-size:12px;" border="1" rules="all">
				<tr>
					<td align="center" style="color:green; font-size:18px; font-weight:bold;">恭喜，t_products_discount_discount更新成功</td>
				</tr>';
			$no_picture_str .= '<tr><td align="right">邮件生成时间：' . $startdate . '</td></tr></table>';
		}

		// 更新MODULE_UPDATE_PRODUCTS_DISCOUNT_QUANTITY状态，状态为10-全部更新成功,20 未成功
		$updateSql = "update " . TABLE_CONFIGURATION . " z set z.configuration_value = " . $configuration_value . " , z.last_modified = now() where z.configuration_key = 'MODULE_UPDATE_PRODUCTS_DISCOUNT_QUANTITY'";
		$db->Execute ( $updateSql );
	}

	
	
	if(!empty($html_msg['EMAIL_MESSAGE_HTML'])) {
		$html_msg['EMAIL_MESSAGE_HTML'] .= '<br/><br/><font color=red>备注：此邮件为系统自动检测，如有疑问请联系技术部，谢谢！</font>';
		//$html_msg['EMAIL_MESSAGE_HTML'] .= '<br/><br/><font color=red>备注：2016-07-05前检测产品图片只检测了第一张，现在三张图片都会检测！</font>';
		zen_mail('All', 'xi.xia@panduo.com.cn', $has_error . '汇率变化更新产品价格(' . date("Ymd") . ')', strip_tags($html_msg), STORE_NAME, EMAIL_FROM, $html_msg, 'default', '', 'false', 'qilie.kang@panduo.com.cn,tingting.hua@panduo.com.cn,yuping.li@panduo.com.cn');
	}	
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>