<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset($_POST) && !empty($_POST)) {
	$limit = "";
	$categories_str = '<table style="width:540px; margin-top:11px; font-size:12px;" border="1" rules="all">
		<tr>
			<td width="10%" align="left">ERP ID</td>
			<td width="60%" align="left">邮箱</td>
			<td width="30%" align="left">剩余过期时间</td>
		</tr>';
	$count_catogires = $count_products = 0;
	$html_msg['EMAIL_MESSAGE_HTML'] = '';
	foreach($_POST as $data) {
		$categories_str .= '	<tr>
			<td align="left">' . $data['erp_id'] . '</td>
			<td align="left">' . $data['email'] . '</td>
			<td align="left">' . $data['time'] . '</td>
		</tr>';
		$count_catogires++;
	}
	$categories_str .= '<tr><td colspan="3" align="right">邮件生成时间：' . $startdate . '</td></tr></table>';

	if($count_catogires > 0) {
		$html_msg['EMAIL_MESSAGE_HTML'] .= $categories_str;
	}
	
	if(!empty($html_msg['EMAIL_MESSAGE_HTML'])) {
		$html_msg['EMAIL_MESSAGE_HTML'] .= '<br/><br/><font color=red>备注：系统自动检测Refresh Token即将过期店铺并发送，谢谢！</font>';
		zen_mail('All', 'jie.li@panduo.com.cn', '速卖通Refresh Token过期列表(' . date("Ymd") . ')[' . STORE_NAME . ']', strip_tags($html_msg), STORE_NAME, EMAIL_FROM, $html_msg, 'default', '', 'false', 'qilie.kang@panduo.com.cn,xiafeng.liu@panduo.com.cn,tianwen.wan@panduo.com.cn,fei.fang@panduo.com.cn,yini.xie@panduo.com.cn');
                //zen_mail('All', 'tianwen.wan@panduo.com.cn', '速卖通Refresh Token过期列表(' . date("Ymd") . ')[' . STORE_NAME . ']', strip_tags($html_msg), STORE_NAME, EMAIL_FROM, $html_msg, 'default', '', 'false', '76182110@qq.com');
	}	
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>
