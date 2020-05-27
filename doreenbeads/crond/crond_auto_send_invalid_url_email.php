<?php
chdir("../");
@ set_time_limit(0);
@ ini_set("memory_limit', '2048M");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'sort_out_invalid_url') {
	$url_sql = 'SELECT  invalid_url , COUNT(1) as visit_time from ' . TABLE_INVALID_URL . ' where date_created > "' . date('Y-m-d' , time() - 24 * 60 * 60) . ' 08:00:00' . '"  and date_created <= "' . date('Y-m-d') . ' 08:00:00' . '" GROUP BY invalid_url';
	$url_query = $db->Execute($url_sql);
	$url_arr = array();
	$email_content = '';
	
	if($url_query->RecordCount() > 0){
		while (!$url_query->EOF){
			$url = strtolower(trim($url_query->fields['invalid_url']));
			
			if(array_key_exists($url, $url_arr)){
				$url_arr[$url]++;
			}else{
				$url_arr[$url] = $url_query->fields['visit_time'];
			}
			
			$url_query->MoveNext();
		}

		$email_content .= '<table border="1" width="100%" cellspacing="0" cellpadding="5"><tr><td><strong>无效链接</strong></td><td><strong>访问次数</strong></td><tr>';
		foreach ($url_arr as $url_k => $visit_time){
			$email_content .= '<tr><td><a class="url" href="' . $url_k . '">' . $url_k . '</a></td><td><span class="visit_time">' . $visit_time . '</span></td></div>';
		}
		$email_content .= '</table>';
		$title = '【有】上一日无效推广链接';
	}else{
		$email_content .= '<table border="1" width="100%" cellspacing="0" cellpadding="5"><tr><td align="center"><span style="font-size:25px;font-weight: bold;color:green;">恭喜，上一日没有无效链接被点击</span></td></tr><tr><td><span align="right">邮件生成时间：' . date('Y-m-d H:i:s') . '</span></td></tr></table>';
		$title = '【无】上一日无效推广链接';
	}
	
	$messege['EMAIL_MESSAGE_HTML'] = $email_content;
	
	if($email_content != ''){
		zen_mail('潘晓燕', 'xiaoyan.pan@panduo.com.cn', $title, strip_tags($email_content), STORE_NAME, EMAIL_FROM , $messege , 'invalid_url', '', 'false', 'hanqi.deng@panduo.com.cn, di.wang@panduo.com.cn,peng.huang@panduo.com.cn,mengjie.yang@panduo.com.cn,xi.xia@panduo.com.cn,yuping.li@panduo.com.cn');
	}
}


echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>