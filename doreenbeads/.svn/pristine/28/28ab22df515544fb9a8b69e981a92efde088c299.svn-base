<?php
set_time_limit(600);

if(! isset($_FILES['ulFile'])) die('请上传excel文件!');
$fileName = $_FILES['ulFile']['name'];
if(substr($fileName, strrpos($fileName, '.')+1) != 'xlsx') die('请上传正确的excel(*.xlsx)文件!');

//	load excel
$ulFile = $_FILES['ulFile']['tmp_name'];
include('lib/classes/PHPExcel.php');
$PHPExcel = new PHPExcel();
$PHPReader = new PHPExcel_Reader_Excel2007();
if(!$PHPReader->canRead($ulFile)){
	$PHPReader = new PHPExcel_Reader_Excel5();
	if(!$PHPReader->canRead($ulFile)){
		die('no Excel');
	}
}
$PHPExcel = $PHPReader->load($ulFile);

if($_SESSION['type']=='homepage'){
	include('ajax_createHomepageHTML.php');
	exit;
}

// if($_SESSION['type']=='edm2'){
// 	include('ajax_createNewedmHTML.php');
// 	exit;
// }

if($_SESSION['type'] == 'edm0'){
	include('ajax_createEdm0HTML.php');
	exit;
}
$ftp_str = 'ftp_'.$_SESSION['site'];
$ftp_arr = $$ftp_str;
$picUrl = $ftp_arr['url'].$langArr[$_SESSION['lang']].'/edm/'.date('Ymd').'/';
$tpl = 'tpl_'.$_SESSION['site'].'_'.$langArr[$_SESSION['lang']].'.html';

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

//	other sheet;
$sheetCount = $PHPExcel->getSheetCount();
$sheetData = array();
for($n=1; $n<=$sheetCount-1; $n++){
	$currentSheet = $PHPExcel->getSheet($n);

	if(myGetValue(4,2)){
		$title = array(
			'href' => myGetValue(5,2),
			'title' => myGetValue(4,2)
		);
	}else{
		$title = false;
	}

	$allRow = $currentSheet->getHighestRow();
	$content = array();
	for($currentRow = 3; $currentRow <= $allRow; $currentRow++){
		//	if picture name == ''
		if(myGetValue(0, $currentRow) == '') continue;
		$content[] = array(
			'picSrc' => myGetValue(1, $currentRow) ? myGetValue(1, $currentRow) : ($picUrl.myGetValue(0, $currentRow)),
			'picHref' => myGetValue(2, $currentRow),
			'picAlt' => myGetValue(3, $currentRow),
			'titleName' => myGetValue(4, $currentRow),
			'titleHref' => myGetValue(5, $currentRow),
			'oldPrice' => myGetValue(6, $currentRow),
			'CurrPrice' => myGetValue(7, $currentRow)
		);
	}
	$has = count($content) > 0 ? true : false;

	if($has){
		$sheetData[] = array('title'=>$title, 'content'=>$content, 'cnt'=>count($content));
	}
}

//	smarty
require('lib/classes/Smarty.class.php');
$smarty = new Smarty;
$smarty->caching = false;
$smarty->template_dir = "template/";
$smarty->compile_dir = "template_c/";
$smarty->config_dir = "classes/configs/";
$smarty->assign("bigPic", $bigPic);
$smarty->assign("banner1", $banner1);
$smarty->assign("banner2", $banner2);
$smarty->assign("year", date('Y'));
$smarty->assign("sheetData", count($sheetData) ? $sheetData : false);
$html = $smarty->fetch($tpl);

$savePath = 'download/'.date('Ym').'/';
if(! file_exists($savePath)) mkdir($savePath);
$saveFile = $savePath.'db_'.$langArr[$_SESSION['lang']].'_'.date('YmdHis').'.html';
if(file_exists($saveFile)) unlink($saveFile);
file_put_contents($saveFile, $html);

echo '生成html完成, 点击<a href='.$saveFile.' target="_blank">这里</a>下载.';

/**
* get cell value
* @param	int		column
* @param	int		row
* @return	mix		value
*/
function myGetValue($column, $row){
	global $currentSheet;

	if(! $currentSheet) return false;

	return trim($currentSheet->getCellByColumnAndRow($column, $row)->getValue());
}
?>
