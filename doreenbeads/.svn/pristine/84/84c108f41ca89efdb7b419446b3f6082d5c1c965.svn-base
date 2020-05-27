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

$currentSheet = $PHPExcel->getSheet(0);
$allRow = $currentSheet->getHighestRow();
$currentRow = $allRow - 1;
for($currentRow = 2; $currentRow <= $allRow; $currentRow++){
	if(myGetValue(0,$currentRow) != ''){
		$categories[] = array(
				'picName' => myGetValue(1,$currentRow),
				'picSrc' => myGetValue(2,$currentRow)? myGetValue(2, $currentRow) : (myGetValue(1, $currentRow) ? $picUrl.myGetValue(1, $currentRow) : ''),
				'picAlt' => myGetValue(3,$currentRow),
				'picHref' => myGetValue(4,$currentRow),
				'cateTitle' => myGetValue(5,$currentRow),
				'cateDesc' => myGetValue(6,$currentRow)
		);
	}
}
for($i = 1;$i <= 2; $i++ ){
	$banner[] = array_pop($categories);
}

if(! count($banner)) $banner = false;
if(! count($categories)) $categories = false;
$smarty->assign("banner", $banner);
$smarty->assign("categories", $categories);

$sheetNum = $PHPExcel->getSheetCount();

for($sheet = 1;$sheet < $sheetNum; $sheet++){
	$currentSheet = $PHPExcel->getSheet($sheet);
	$allRow = $currentSheet->getHighestRow();
	for($currentRow = 2; $currentRow <= $allRow; $currentRow++){
		if(myGetValue(0, $currentRow) == '') continue;
		$products[$sheet-1][] = array(
			'picName' => myGetValue(0, $currentRow),
			'picSrc' => myGetValue(1, $currentRow) ? myGetValue(1, $currentRow) : ($picUrl.myGetValue(0, $currentRow)),
			'picHref' => myGetValue(2, $currentRow),
			'picAlt' => myGetValue(3, $currentRow),
			'price_old' => myGetValue(5, $currentRow),
			'price_curr' => myGetValue(6, $currentRow)
		);
	}
}

if(! count($products)) $products = false;
$smarty->assign("products", $products);

$html = $smarty->fetch($tpl);

$savePath = 'download/'.date('Ym').'/';
if(! file_exists($savePath)) mkdir($savePath);
$saveFile = $savePath.'db'.'_'.$langArr[$_SESSION['lang']].'_'.$_SESSION['type'].'_'.date('YmdHis').'.html';

if(file_exists($saveFile)) unlink($saveFile);
file_put_contents($saveFile, $html);

echo '生成html完成, 点击<a href='.$saveFile.' target="_blank">这里</a>下载.';

?>