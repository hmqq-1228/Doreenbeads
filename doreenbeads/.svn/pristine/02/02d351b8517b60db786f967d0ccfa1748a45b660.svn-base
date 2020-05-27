<?php
/*
*by zale 2011.12.20
*checkCode.php
*本页面用于不刷新判断验证码是否正确
*/

require('includes/application_top.php');
$suffix = "common";
$form_code = zen_db_prepare_input($_POST['form_code']);
$code_suffix = zen_db_prepare_input($_POST['code_suffix']);
if(!empty($code_suffix)) {
	$suffix = $code_suffix;
}
if($_SESSION['verification_code_' . $suffix] != strtolower($form_code)){
	echo TEXT_INPUT_RIGHT_CODE;
}
?>