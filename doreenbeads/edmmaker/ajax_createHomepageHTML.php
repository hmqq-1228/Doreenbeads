<?php
$ftp_str = 'ftp_'.$_SESSION['site'];
$ftp_arr = $$ftp_str;
$picUrl = $ftp_arr['url'].$langArr[$_SESSION['lang']].'/edm/'.date('Ymd').'/';
$tpl = 'tpl_'.$_SESSION['site'].'_'.$_SESSION['type'].'_'.$langArr[$_SESSION['lang']].'.html';
$sheetArr = array('banner', 'hot', 'featured', 'new');
//	smarty
require('lib/classes/Smarty.class.php');
$smarty = new Smarty;
$smarty->caching = false;
$smarty->template_dir = "template/";
$smarty->compile_dir = "template_c/";
$smarty->config_dir = "classes/configs/";
$smarty->assign("year", date('Y'));

$currentSheet = $PHPExcel->getSheet(0);
$allRow = $currentSheet->getHighestRow();
for($currentRow = 2; $currentRow <= $allRow; $currentRow++){
	if(myGetValue(0,$currentRow) == '') continue;
	$banner[] = array(
		'picSrc' => myGetValue(0,$currentRow),
		'picHref' => myGetValue(1,$currentRow),
		'picAlt' => myGetValue(2,$currentRow)
	);
}
if(! count($banner)) $banner = false;
$smarty->assign("banner", $banner);

$currentSheet = $PHPExcel->getSheet(1);
$allRow = $currentSheet->getHighestRow();
$hot['left'] = array(
	'picSrc' => myGetValue(1,2),
	'picHref' => myGetValue(2,2),
	'picAlt' => myGetValue(3,2),
	'titleName' => myGetValue(4,2),
	'titleHref' => myGetValue(5,2)
);
for($currentRow = 3; $currentRow <= $allRow; $currentRow++){
	if(myGetValue(1,$currentRow) == '') continue;
	$hot['right'][] = array(
		'picSrc' => myGetValue(1,$currentRow),
		'picHref' => myGetValue(2,$currentRow),
		'picAlt' => myGetValue(3,$currentRow),
		'titleName' => myGetValue(4,$currentRow),
		'titleHref' => myGetValue(5,$currentRow)
	);
}
if(! count($hot)) $hot = false;
$smarty->assign("hot", $hot);

$currentSheet = $PHPExcel->getSheet(2);
$allRow = $currentSheet->getHighestRow();
for($currentRow = 2; $currentRow <= $allRow; $currentRow++){
	if(myGetValue(0,$currentRow) == '') continue;
	$featured[] = array(
		'picSrc' => myGetValue(1, $currentRow) ? myGetValue(1, $currentRow) : ($picUrl.myGetValue(0, $currentRow)),
		'picHref' => myGetValue(2,$currentRow),
		'picAlt' => myGetValue(3,$currentRow),
		'price' => myGetValue(4,$currentRow)
	);
}
if(! count($featured)) $featured = false;
$smarty->assign("featured", $featured);

$currentSheet = $PHPExcel->getSheet(3);
$allRow = $currentSheet->getHighestRow();
for($currentRow = 2; $currentRow <= $allRow; $currentRow++){
	if(myGetValue(0,$currentRow) == '') continue;
	$new[] = array(
		'picSrc' => myGetValue(1, $currentRow) ? myGetValue(1, $currentRow) : ($picUrl.myGetValue(0, $currentRow)),
		'picHref' => myGetValue(2,$currentRow),
		'picAlt' => myGetValue(3,$currentRow),
		'titleName' => myGetValue(4,$currentRow),
		'titleHref' => myGetValue(5,$currentRow)
	);
}
if(! count($new)) $new = false;
$smarty->assign("new", $new);

$html = $smarty->fetch($tpl);

$savePath = 'download/'.date('Ym').'/';
if(! file_exists($savePath)) mkdir($savePath);
$saveFile = $savePath.'db_'.$langArr[$_SESSION['lang']].'_'.$_SESSION['type'].'_'.date('YmdHis').'.html';
if(file_exists($saveFile)) unlink($saveFile);
file_put_contents($saveFile, $html);

echo '生成html完成, 点击<a href='.$saveFile.' target="_blank">这里</a>下载.';

?>