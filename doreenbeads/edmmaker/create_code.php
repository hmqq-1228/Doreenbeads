<?php
if (!session_id()) session_start();
header("Content-type:image/png");
$str = 'abcdefghijklmnbqrstuvwxyz123456789';
$shuffled = str_shuffle($str);
$str = substr($shuffled,0,4);
$_SESSION['auth_num'] = md5($str);

$str = strtoupper($str);
$mailaddress = $str;
$mailaddresslen = strlen($mailaddress);
$mailaddressimages = imagecreate($mailaddresslen*12,25);
$lenadd = $mailaddresslen;
$fontsize = "5";
$center = (imagesx($mailaddressimages)-8.3*strlen($mailaddress))/2;
$white = ImageColorAllocate($mailaddressimages,100,200,210);
$mailimagesbackground = ImageColorAllocate($mailaddressimages,255,255,255);
$mailimagesfacecolor = ImageColorAllocate($mailaddressimages,200,0,0);
imagefilledrectangle($mailaddressimages,0,0,100,100,$white);
ImageString($mailaddressimages,$fontsize,$center,5,$mailaddress,$mailimagesfacecolor);
Imagepng($mailaddressimages);
ImageDestroy($mailaddressimages);
?>