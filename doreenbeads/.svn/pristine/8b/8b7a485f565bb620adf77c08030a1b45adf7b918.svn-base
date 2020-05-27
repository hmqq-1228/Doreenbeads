<?php

require('includes/application_top.php');
header("Content-type:image/png");
// 预先声明默认后缀
$suffix = "common";
// 获取参数传递的后缀
$code_suffix = @trim($_GET['code_suffix']);
// 刷新原有后缀
if(!empty($code_suffix)) {
	$suffix = $code_suffix;
}
// 声明验证码随机范围字符串
$str = 'abcdefghijklmnbqrstuvwxyz123456789';
// 随机打乱所有字符
$shuffled = str_shuffle($str);
// 从中取出四位字符
$str = substr($shuffled,0,4);
// 把验证码放到SESSION中
$_SESSION['verification_code_' . $suffix] = $str;
// 把验证码转换成大写
$str = strtoupper($str);
// 获取验证码
$mailaddress = $str;
// 获取验证码长度
$mailaddresslen = strlen($mailaddress);
// 生成验证码画布
$mailaddressimages = imagecreate($mailaddresslen * 12,25);
// 另存验证码长度
$lenadd = $mailaddresslen;
// 设置文字大小
$fontsize = "5";
// 获取图片中心点
$center = (imagesx($mailaddressimages) - 8.3 * strlen($mailaddress)) / 2;
$white = ImageColorAllocate($mailaddressimages,100,200,210); 
$mailimagesbackground=ImageColorAllocate($mailaddressimages,255,255,255);
$mailimagesfacecolor=ImageColorAllocate($mailaddressimages,200,0,0);
imagefilledrectangle($mailaddressimages,0,0,100,100,$white);
ImageString($mailaddressimages,$fontsize,$center,5,$mailaddress,$mailimagesfacecolor);
Imagepng($mailaddressimages);
ImageDestroy($mailaddressimages);
?>