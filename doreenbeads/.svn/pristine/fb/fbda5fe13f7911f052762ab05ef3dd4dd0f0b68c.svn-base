<?php 
$error = false;
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add('Facebook Fan Giveaway');

/*
if(!isset($_GET['utm_campaign']) || $_GET['utm_campaign']!='facebook_fan_giveaway'){
	$error = true;
	require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/product_info.php');
	$error_msg = TEXT_PRODUCT_NOT_FOUND;
}
*/

$blackCountry = explode(',', FACEBOOK_LIKE_BLACK_COUNTRY);
if(in_array($checkIpAddress->countryCode, $blackCountry)){	//	屏蔽国家
	$error = true;
	$error_msg = 'Sorry, This page is unavailable as your address is beyond our shipping area.';
}

if(! $error){
	$dateNow = date('Y-m-d H:i:s');
	$isActiveTime = $dateNow >= FACEBOOK_LIKE_START_TIME && $dateNow <= FACEBOOK_LIKE_END_TIME;

//	$fbAccount = 'https://www.facebook.com/doreenbeads';
//	$fbApi = file_get_contents('http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls='.$fbAccount);
//	$fbApiArr = json_decode($fbApi, true);
//	$likeCountNow = intval($fbApiArr[0]['like_count']);
//	$likeCountLeft = FACEBOOK_LIKE_LIKE_COUNT - $likeCountNow;
	$endDate = date('F jS', strtotime(FACEBOOK_LIKE_START_TIME));

	$smarty->assign('isActiveTime', $isActiveTime);

//	$define_facebook_like = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', 'define_facebook_like.php', 'false');
	$define_facebook_like = zen_get_file_directory(DIR_WS_LANGUAGES . 'english/html_includes/', 'define_facebook_like_mobile.php', 'false');	//	全部用英语
	ob_start();
	require($define_facebook_like);
	$facebook_like = ob_get_clean();
	$smarty->assign('facebook_like', $facebook_like);
}

$smarty->assign('error', $error);
$smarty->assign('error_msg', $error_msg);
?>