<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action'])) {
	$limit = "";
	if($_GET['action'] == "all") {
		$result = $db->Execute("select ci.identity_id, cd.categories_name, ci.data_url from " . TABLE_CHECK_IMAGES . " ci left join " . TABLE_CATEGORIES_DESCRIPTION . " cd on cd.categories_id=ci.identity_id where ci.identity_type=10 and cd.language_id=1");
		$categories_str = '<table style="width:540px; margin-top:11px; font-size:12px;" border="1" rules="all">
			<tr>
				<td width="10%" align="left">类别ID</td>
				<td width="30%" align="left">类别名称</td>
				<td width="60%" align="left">类别链接地址</td>
			</tr>';
		$count_catogires = $count_products = 0;
		$html_msg['EMAIL_MESSAGE_HTML'] = '';
		while (!$result->EOF) {
			$categories_str .= '	<tr>
				<td align="left">' . $result->fields['identity_id'] . '</td>
				<td align="left">' . $result->fields['categories_name'] . '</td>
				<td align="left"><a href="' . $result->fields['data_url'] . '" target="_blank">' . $result->fields['data_url'] . '</a></td>
			</tr>';
			$count_catogires++;
			$result->MoveNext();
		}
		$categories_str .= '<tr><td colspan="3" align="right">邮件生成时间：' . $startdate . '</td></tr></table>';
		
		$products_str = '<table style="width:540px; margin-top:11px; font-size:12px;" border="1" rules="all">
			<tr>
				<td align="left">产品编号</td>
			</tr>';
		$result = $db->Execute("select identity_code from " . TABLE_CHECK_IMAGES . " where identity_type=20");
		while (!$result->EOF) {
			if(!empty($result->fields['identity_code'])) {
				$products_str .= '	<tr>
					<td align="left">' . $result->fields['identity_code'] . '</td>
				</tr>';
				$count_products ++;
			}
			$result->MoveNext();
		}
		$products_str .= '<tr><td colspan="3" align="right">邮件生成时间：' . $startdate . '</td></tr></table>';
	}
	
	$has_error = "【有】";
	if($count_catogires > 0) {
		$html_msg['EMAIL_MESSAGE_HTML'] .= $categories_str;
	}
	if($count_products > 0) {
		$html_msg['EMAIL_MESSAGE_HTML'] .= $products_str;
	}
	
	if($count_catogires <= 0 && $count_products <= 0) {
		$has_error = "【无】";
		$no_picture_str = '<table style="width:540px; margin-top:11px; font-size:12px;" border="1" rules="all">
			<tr>
				<td align="center" style="color:green; font-size:18px; font-weight:bold;">恭喜，今天无图片缺失</td>
			</tr>';
		$no_picture_str .= '<tr><td align="right">邮件生成时间：' . $startdate . '</td></tr></table>';
		$html_msg['EMAIL_MESSAGE_HTML'] .= $no_picture_str;
	}
	
	if(!empty($html_msg['EMAIL_MESSAGE_HTML'])) {
		$html_msg['EMAIL_MESSAGE_HTML'] .= '<br/><br/><font color=red>备注：此邮件为系统自动检测图片缺失数据并发送，如有疑问请联系技术部，谢谢！</font>';
		//$html_msg['EMAIL_MESSAGE_HTML'] .= '<br/><br/><font color=red>备注：2016-07-05前检测产品图片只检测了第一张，现在三张图片都会检测！</font>';
		zen_mail('All', 'xiaoyang.lou@panduo.com.cn', $has_error . '网站缺失类别和产品图片列表(' . date("Ymd") . ')[' . STORE_NAME . ']', strip_tags($html_msg), STORE_NAME, EMAIL_FROM, $html_msg, 'default', '', 'false', 'wenwen.wu@panduo.com.cn,qilie.kang@panduo.com.cn,xi.xia@panduo.com.cn,yuping.li@panduo.com.cn, yuanyuan.xu@panduo.com.cn,zhijie.jiang@panduo.com.cn,qianwen.zhang@panduo.com.cn, min.cheng@panduo.com.cn');
	}	
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>