<?php
$ftp_str = 'ftp_'.$_SESSION['site'];
$ftp_arr = $$ftp_str;
$picUrl = $ftp_arr['url'].$langArr[$_SESSION['lang']].'/edm/'.date('Ymd').'/';
$tpl = 'tpl_'.$_SESSION['site'].'_'.$_SESSION['type'].'_'.$langArr[$_SESSION['lang']].'.html';
//	smarty
require('lib/classes/Smarty.class.php');
$smarty = new Smarty;
$smarty->caching = false;
$smarty->template_dir = "template/";
$smarty->compile_dir = "template_c/";
$smarty->config_dir = "classes/configs/";
$smarty->assign("year", date('Y'));

//	1st sheet; about big pic
$currentSheet = $PHPExcel->getSheet(0);
for($currentRow=2; $currentRow<=4; $currentRow++){
	$picName = $currentRow==2 ? 'bigPic' : ($currentRow==3 ? 'banner1' : 'banner2');
	if(myGetValue(1, $currentRow) != '' || myGetValue(2, $currentRow) != ''){
		$$picName = array(
			'picSrc' => myGetValue(2, $currentRow) ? myGetValue(2, $currentRow) : ($picUrl.myGetValue(1, $currentRow)),
			'picAlt' => myGetValue(3, $currentRow),
			'picHref' => myGetValue(4, $currentRow)
		);
	}else{
		$$picName = false;
	}
}
$smarty->assign("bigPic", $bigPic);
$smarty->assign("banner1", $banner1);
$smarty->assign("banner2", $banner2);

$currentSheet = $PHPExcel->getSheet(1);
$allRow = $currentSheet->getHighestRow();
for($currentRow = 3; $currentRow <= $allRow; $currentRow++){
	if(myGetValue(0, $currentRow) == '') continue;
	$new[] = array(
		'picSrc' => myGetValue(1, $currentRow) ? myGetValue(1, $currentRow) : ($picUrl.myGetValue(0, $currentRow)),
		'picHref' => myGetValue(2,$currentRow),
		'picAlt' => myGetValue(3,$currentRow)
	);
}
if(! count($new)) $new = false;
$smarty->assign("new", $new);

$currentSheet = $PHPExcel->getSheet(2);
$allRow = $currentSheet->getHighestRow();
for($currentRow = 3; $currentRow <= $allRow; $currentRow++){
	if(myGetValue(0, $currentRow) == '') continue;
	$other[] = array(
		'picSrc' => myGetValue(1, $currentRow) ? myGetValue(1, $currentRow) : ($picUrl.myGetValue(0, $currentRow)),
		'picHref' => myGetValue(2,$currentRow),
		'picAlt' => myGetValue(3,$currentRow)
	);
}
if(! count($other)) $other = false;
$smarty->assign("other", $other);
$smarty->assign("other_cnt", count($other));

$html = $smarty->fetch($tpl);

$savePath = 'download/'.date('Ym').'/';
if(! file_exists($savePath)) mkdir($savePath);
$saveFile = $savePath.'db_'.$langArr[$_SESSION['lang']].'_'.$_SESSION['type'].'_'.date('YmdHis').'.html';
if(file_exists($saveFile)) unlink($saveFile);
file_put_contents($saveFile, $html);

echo '生成html完成, 点击<a href='.$saveFile.' target="_blank">这里</a>下载.';

?>