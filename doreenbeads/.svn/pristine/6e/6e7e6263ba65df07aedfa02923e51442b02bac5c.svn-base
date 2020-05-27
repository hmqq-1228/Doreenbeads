<?php 
$error = false;
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

//	为了登陆后能跳转到这里
if (! $_SESSION ['customer_id']) {
	$_SESSION ['navigation']->set_snapshot ();
}

//	抽奖次数
$lotteryTimes = zen_count_facebook_lottery_times();

//	bof 抽奖动作
if(isset($_GET['action']) && $_GET['action'] == 'lottery'){
	$data = array('success' => true, 'msg' => '');

	//	不在活动时间、验证客户不正确、国家屏蔽
	if(!zen_is_facebook_like_time() || !isset($_POST['authCode']) || $_POST['authCode'] == '' || $fun_inviteFriends->decode($_POST['authCode']) != $_SESSION['customer_id'] || in_array($checkIpAddress->countryCode, $blackCountry)){
		$data['success'] = false;
		$data['msg'] = 'System Error!';
		echo json_encode($data);
		die();
 	}

	//	抽奖次数超过可抽奖次数了
	if($lotteryTimes[1] >= $lotteryTimes[0]){
		$data['success'] = false;
		$data['msg'] = TEXT_SPIN_OUTOF_CHANCES;
		echo json_encode($data);
		die();
	}

	//	angle为旋转角度; v为概率; d为coupon号或产品id; prize为用于显示的文字
	$prize_arr = array(
		'0' => array('id' => 1, 'angle' => 51.5, 'prize' => '5', 'min' => 25, 'v' => 35, 'd' => 'CP2015090605'),
		'1' => array('id' => 2, 'angle' => 309, 'prize' => '10', 'min' => 50,  'v' => 20, 'd' => 'CP2015090610'),
		'2' => array('id' => 3, 'angle' => 154.5, 'prize' => '15', 'min' => 75,  'v' => 10, 'd' => 'CP2015090615'),
//		'3' => array('id' => 4, 'angle' => 0, 'prize' => TEXT_SPIN_PRODUCT_DITSAMPLE, 'v' => 12, 'd' => SPINTOWIN_PRODUCT1_ID),
//		'4' => array('id' => 5, 'angle' => 257.5, 'prize' => TEXT_SPIN_PRODUCT_SWAROVSKI, 'v' => 8, 'd' => SPINTOWIN_PRODUCT2_ID),
//		'5' => array('id' => 6, 'angle' => 103, 'prize' => TEXT_SPIN_PRODUCT_NECKLACE, 'v' => 5, 'd' => SPINTOWIN_PRODUCT3_ID),
//		'6' => array('id' => 7, 'angle' => 206, 'prize' => 'NO WIN', 'v' => 10, 'd' => '')
		'3' => array('id' => 4, 'angle' => 0, 'prize' => TEXT_SPIN_PRODUCT_DITSAMPLE, 'v' => 1, 'd' => SPINTOWIN_PRODUCT1_ID),
		'4' => array('id' => 5, 'angle' => 257.5, 'prize' => TEXT_SPIN_PRODUCT_SWAROVSKI, 'v' => 1, 'd' => SPINTOWIN_PRODUCT2_ID),
		'5' => array('id' => 6, 'angle' => 103, 'prize' => TEXT_SPIN_PRODUCT_NECKLACE, 'v' => 1, 'd' => SPINTOWIN_PRODUCT3_ID),
		'6' => array('id' => 7, 'angle' => 206, 'prize' => 'NO WIN', 'v' => 32, 'd' => '')
	);
	foreach ($prize_arr as $v) {
		$arr[$v['id']] = $v['v'];
	}
	$prize_id = getRandForLottery($arr);
	$res = $prize_arr[$prize_id - 1];
	$data['angle'] = $res['angle'];
	$data['prize'] = $res['prize'];

	$db->Execute("update " . TABLE_CUSTOMERS . " set has_gift = has_gift + 1 where customers_id ='" . intval($_SESSION['customer_id']) . "'");
	$data['times'] = $lotteryTimes[1] + 1;

	if(in_array($prize_id, array(1,2,3))){	//	抽到coupon，加入mycoupon
		$coupon_query = $db->Execute("select coupon_id, coupon_amount, day_after_add from ".TABLE_COUPONS." where coupon_code = '".$res['d']."' limit 1");
		if($coupon_query->fields['coupon_id']){
			$coupon_data_array = array(
				'cc_coupon_id' => (int)$coupon_query->fields['coupon_id'],
				'cc_customers_id' => $_SESSION['customer_id'],
				'cc_amount' => $coupon_query->fields['coupon_amount'],
				'cc_coupon_start_time' => date('Y-m-d H:i:s'),
				'cc_coupon_end_time' => date('Y-m-d H:i:s', strtotime("+".$coupon_query->fields['day_after_add']." day")),
				'cc_coupon_status'=>10,
				'date_created'=>'now()'
			);
			zen_db_perform(TABLE_COUPON_CUSTOMER, $coupon_data_array);
		}

		if($_SESSION['languages_id'] == 1){
			if($lotteryTimes[1] < 1) $data['msg'] = sprintf(TEXT_SPIN_COUPON_1ST, $res['prize'], $res['min'], 'onclick="fbSharePluginInit()"');
			else $data['msg'] = sprintf(TEXT_SPIN_COUPON_2ND, $res['prize'], $res['min']);
		}else{
			if($lotteryTimes[1] < 1) $data['msg'] = sprintf(TEXT_SPIN_COUPON_1ST, $res['prize'], 'onclick="fbSharePluginInit()"');
			else $data['msg'] = sprintf(TEXT_SPIN_COUPON_2ND, $res['prize']);
		}
	}else if(in_array($prize_id, array(4,5,6))){	//	抽到礼品，加入购物车
		$pid = $res['d'];
		if ($_SESSION['cart']->in_cart($pid)) {
			$_SESSION['cart']->update_quantity($pid, 2);
		} else {
			$_SESSION['cart']->add_cart($pid, 1);
		}
		//$data['cartcount'] = $_SESSION['cart']->get_products_items();

		if($lotteryTimes[1] < 1) $data['msg'] = sprintf(TEXT_SPIN_PRODUCT_1ST, $res['prize'], 'onclick="fbSharePluginInit()"');
		else $data['msg'] = sprintf(TEXT_SPIN_PRODUCT_2ND, $res['prize']);
	}else{	//	没抽到
		if($lotteryTimes[1] < 1) $data['msg'] = sprintf(TEXT_SPIN_DONT_WIN_1ST, 'onclick="fbSharePluginInit()"');
		else $data['msg'] = TEXT_SPIN_DONT_WIN_2ND;
	}

	echo json_encode($data);
	die();
}
//	eof 抽奖动作

//	bof 分享动作
if(isset($_GET['action']) && $_GET['action'] == 'share'){
	$data = array('success' => true, 'msg' => '');

	//	不在活动时间、验证客户不正确、国家屏蔽
	if(!zen_is_facebook_like_time() || !isset($_POST['authCode']) || $_POST['authCode'] == '' || $fun_inviteFriends->decode($_POST['authCode']) != $_SESSION['customer_id'] || in_array($checkIpAddress->countryCode, $blackCountry)){
		$data['success'] = false;
		$data['msg'] = 'System Error!';
		echo json_encode($data);
		die();
 	}

	if($lotteryTimes[0] <= 1){
		$db->Execute("update " . TABLE_CUSTOMERS . " set has_gift = '2".$lotteryTimes[1]."' where customers_id ='" . intval($_SESSION['customer_id']) . "'");
	}

	echo json_encode($data);
	die();
}
//	eof 分享动作

$breadcrumb->add(NAVBAR_TITLE);
$blackCountry = explode(',', FACEBOOK_LIKE_BLACK_COUNTRY);
if(in_array($checkIpAddress->countryCode, $blackCountry)){	//	屏蔽国家
	$error = true;
	$error_msg = TEXT_SPIN_UNAVAILABLE_COUTRY;
}

if(!zen_is_facebook_like_time()){
	$error = true;
	$error_msg = TEXT_SPIN_DATE_ENDED;
}

if(! $error){
	$authCode = isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '' ? $fun_inviteFriends->encode($_SESSION['customer_id']) : '';

//	$define_facebook_like = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', 'define_spin_to_win.php', 'false');
	$define_facebook_like = zen_get_file_directory(DIR_WS_LANGUAGES . 'english/html_includes/', 'define_spin_to_win_mobile.php', 'false');	//	全部用英语
	ob_start();
	require($define_facebook_like);
	$facebook_like = ob_get_clean();
	$smarty->assign('facebook_like', $facebook_like);
}
$smarty->assign('error', $error);
$smarty->assign('error_msg', $error_msg);
$smarty->assign('spinLotteryTimes', $lotteryTimes[1]);
$smarty->assign('spinCanTimes', $lotteryTimes[0]);
$smarty->assign('authCode', $authCode);

//	抽奖几率方法
function getRandForLottery($proArr) {
	$data = '';
	$proSum = array_sum($proArr);
     
	foreach ($proArr as $k => $v) {
		$randNum = mt_rand(1, $proSum);
		if ($randNum <= $v) {
			$data = $k;
			break;
		} else {
			$proSum -= $v;
		}
	}
	unset($proArr);

	return $data;
}
?>