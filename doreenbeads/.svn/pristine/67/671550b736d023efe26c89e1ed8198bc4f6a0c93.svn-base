<?php
/**
* create an excel for download; return html;
* author: lvxiaoyong 20140224
* version: 1.0
*/
set_time_limit(300);	//	limit time 5 mins

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

//	download test pictures
if(isset($_POST['type']) && isset($_POST['type'])=='testPic'){
	//	imgdown config
	$imgdown_str = 'imgdown_'.$_SESSION['site'];
	$imgdownConf = $$imgdown_str;
	$savePath = 'download/'.date('Ym').'/';
	if(! file_exists($savePath)) mkdir($savePath);
	$imgdownRand = 'edmdown_'.date('YmdHis').'_'.rand(0,999);
	$imgdownDir = 'tmp/'.$imgdownRand.'/';
	$imgdownFile = $savePath.'db'.'_'.date('YmdHis').'_test_'.$langArr[$_SESSION['lang']].'.zip';
	if(file_exists($imgdownDir)) myDeleteDir($imgdownDir);
	mkdir($imgdownDir);

	$currentSheet = $PHPExcel->getSheet(0);
	$allRow = $currentSheet->getHighestRow();
	for($currentRow = 2; $currentRow <= $allRow; $currentRow++){
		$code = myGetValue(0, $currentRow);
		if($code == '') continue;
		if(! $ret = myGetProductImg($code)){
			echo $code.' 图片不存在!<br/>';
		}else{
			$zipFileList[] = $imgdownDir.$code.'.jpg';
		}
	}

	if($zipFileList){
		if(! myCreateZip($zipFileList, $imgdownFile, true))
			echo '创建图片ZIP文件失败!<br/>';
		else
			echo '<a href="'.$imgdownFile.'" target="_blank">点此</a>下载测试图片ZIP.<br/>';
	}

	myDeleteDir($imgdownDir);
	exit;
}

//	set database, load functions and classes, init some data
$oldDir = dirname(__FILE__);
//$root_str = 'root_'.$_SESSION['site'];
//chdir($$root_str);	//	important!!!
chdir('..');	//	important!!!
define('IS_ADMIN_FLAG',false);
define('CUSTOMERS_APPROVAL_AUTHORIZATION', 0);
define('SHOW_SALE_DISCOUNT_STATUS', 0);
include('includes/configure.php');
$memcache = new Memcache();
if(!$memcache->addServer(MEMCACHE_HOST, MEMCACHE_PORT)){
	unset($memcache);
}
include('includes/database_tables.php');
include('includes/filenames.php');
include('includes/classes/class.base.php');
include('includes/classes/cache.php');
$zc_cache = new cache();
include('includes/classes/db/mysql/query_factory.php');
include('includes/classes/currencies.php');
global $db;
if(! is_object($db)){
	$db = new queryFactory();
	$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, '', false);
}
if(!$db){
	echo 'ERROR: Could not connect to the database.';
	exit;
}
include('includes/init_includes/init_db_config_read.php');
include('includes/functions/functions_general.php');
include_once('includes/functions/functions_prices.php');
include('includes/functions/html_output.php');
include_once(DIR_WS_CLASSES . 'seo.url.php');

if($_SESSION['type']=='homepage'){
	include('ajax_createHomepageEXCEL.php');
	exit;
}elseif($_SESSION['type']=='edm0'){
	include('ajax_createedm0EXCEL.php');
	exit;
}

//	read from excel
$dataArr = array();
$sheetCount = $PHPExcel->getSheetCount();
for($n=0; $n<=$sheetCount-1; $n++){
	$arr = array();
	$currentSheet = $PHPExcel->getSheet($n);
	$allRow = $currentSheet->getHighestRow();
	for($currentRow = 2; $currentRow <= $allRow; $currentRow++){
		if(myGetValue(0, $currentRow) == '') continue;
		if($_SESSION['type'] == 'edm2'){
			$param = array(
				'showCate'	=> 0,
				'showOld'	=> 0,
				'showCurr'	=> 0,
				'isNew'		=> 0,
				'isPro'		=> 0,
				'isMix'		=> 0
			);
		}else{
			$param = array(
				'showCate'	=> myGetValue(1, $currentRow),
				'showOld'	=> myGetValue(2, $currentRow),
				'showCurr'	=> myGetValue(3, $currentRow),
				'isNew'		=> myGetValue(4, $currentRow),
				'isPro'		=> myGetValue(5, $currentRow),
				'isMix'		=> myGetValue(6, $currentRow)
			);
		}
		if(! $ret = myGetProductInfo(myGetValue(0, $currentRow), $param)){
			echo myGetValue(0, $currentRow).' 数据不存在!<br/>';
		}else{
			$arr[] = $ret;
		}
	}
	if(count($arr))
		$dataArr[$n] = $arr;
}
chdir($oldDir);		//	important!!!

/*
echo '<pre>';
print_r($dataArr);
echo '</pre>';
*/

if(count($dataArr) > 0){
	//	create Excel
	require './lib/classes/PHPExcel/IOFactory.php';
	$filePath = './template/excel/'.$_SESSION['type'].'-2.xlsx';
	$objPHPExcel = PHPExcel_IOFactory::load($filePath);

	//	imgdown config
	$imgdown_str = 'imgdown_'.$_SESSION['site'];
	$imgdownConf = $$imgdown_str;
	$savePath = 'download/'.date('Ym').'/';
	if(! file_exists($savePath)) mkdir($savePath);
	$imgdownRand = 'edmdown_'.date('Ymd').'_'.rand(0,999);
	$imgdownDir = 'tmp/'.$imgdownRand.'/';
	$imgdownFile = $savePath.'db_'.date('YmdHis').'_'.$_SESSION['type'].'_'.$langArr[$_SESSION['lang']].'.zip';
	$exceldownFile = $savePath.'db_'.date('YmdHis').'_'.$_SESSION['type'].'_'.$langArr[$_SESSION['lang']].'.xlsx';
	if(file_exists($imgdownDir)) myDeleteDir($imgdownDir);
	mkdir($imgdownDir);
	
	$style_obj = new PHPExcel_Style(); 
	$style_array = array( 
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('argb' => 'FFFFFFFF'),
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'wrap'       => true
		),
		'borders' => array(    
			'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
			'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
		)
	);
	$style_obj->applyFromArray($style_array);

	$objPHPExcel->setActiveSheetIndex(0);
	$activeSheet = $objPHPExcel->getActiveSheet();
	if($_SESSION['type'] == 'edm2'){
		$activeSheet->setSharedStyle($style_obj, "B2:E2");
	}else{
		$activeSheet->setSharedStyle($style_obj, "B2:G4");
	}

	foreach($dataArr as $n=>$arr){
		$objPHPExcel->setActiveSheetIndex($n+1);
		$activeSheet = $objPHPExcel->getActiveSheet();
		if($_SESSION['type'] == 'edm2'){
			$activeSheet->setSharedStyle($style_obj, "A2:D21");
		}else{
			$activeSheet->setSharedStyle($style_obj, "A2:O21");
		}
		$n = 3;
		foreach($arr as $a){
			$activeSheet->setCellValue('A'.$n, $a['image']);
		//	$activeSheet->setCellValue('B'.$n, $a['image']);
			$activeSheet->setCellValue('C'.$n, $a['url']);
			$activeSheet->setCellValue('D'.$n, $a['name']);
			if($_SESSION['type'] != 'edm2'){
				$activeSheet->setCellValue('E'.$n, $a['cate_name']);
				$activeSheet->setCellValue('F'.$n, $a['cate_url']);
				$activeSheet->setCellValue('G'.$n, $a['price_old']);
				$activeSheet->setCellValue('H'.$n, $a['price_curr']);
			}

			if(! myGetProductImg($a['code']))
				echo $a['code'].' 图片获取失败!<br/>';
			else
				$zipFileList[] = $imgdownDir.$a['code'].'.jpg';
			$n++;
		}
	}
	$objPHPExcel->setActiveSheetIndex(0);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	if(file_exists($exceldownFile)) unlink($exceldownFile);
	$objWriter->save($exceldownFile);

	if($zipFileList){
		if(! myCreateZip($zipFileList, $imgdownFile, true))
			echo '创建图片ZIP文件失败!<br/>';
		else
			echo '<a href="'.$imgdownFile.'" target="_blank">点此</a>下载产品图片ZIP.<br/>';
	}

	echo '<a href="'.$exceldownFile.'" target="_blank">点此</a>下载产品数据2EXCEL.<br/>';
}

//	delate temp dir
myDeleteDir($imgdownDir);

/**
* get product info;
* @param	string		product code;
* @return	array;
*/
function myGetProductInfo($p_code, $p_param){
	global $db, $langArr;

	$code = trim($p_code);
	if($code == '') return false;
	$ret = array();
	$ret['code'] = $code;

	$presult = $db->Execute('select products_id, master_categories_id from '.TABLE_PRODUCTS.' where products_model="'.$code.'" and products_status = 1 limit 1');
	if($presult->RecordCount() <= 0) return false;
	$id = intval($presult->fields['products_id']);

	//	image
	$ret['image'] = $code.'.jpg';

		//	url
	//$ret['url'] = 'http://'.$pre.'.'.$_SESSION['site'].'.com/index.php?main_page=product_info&products_id='.$id;
	$_SESSION["languages_id"] = $_SESSION['lang'];
	$_SESSION["languages_code"] = $langArr[$_SESSION['lang']];
	$ret['url'] = zen_href_link('product_info', 'products_id='.$id , 'SSL');

	//	alt
	$cid = intval($presult->fields['master_categories_id']);
	$cresult = $db->Execute('select categories_name from '.TABLE_CATEGORIES_DESCRIPTION.' where categories_id='.$cid.' and language_id='.$_SESSION['lang']);
	$ret['name'] = $cresult->fields['categories_name'];

	if($p_param['showCate'] == 1){
		//	category url
		$cPath = get_category_info_memcache($cid, 'cPath');
		if (zen_not_null($cPath)) $cPath .= '_';
		$cPath .= $cid;
		$ret['cate_url'] = zen_href_link('index', 'cPath='.$cPath , 'SSL');//'http://'.$pre.'.'.$_SESSION['site'].'.com/index.php?main_page=index&cPath='.$cid;
		if($p_param['isNew'] == 1) $ret['cate_url'] = zen_href_link('products_new', 'cId='.$cid.'&disp_order=6' , 'SSL');//'&disp_order=6';
		if($p_param['isPro'] == 1) $ret['cate_url'] = 'https://www.'.$_SESSION['site'].'.com/'.$langArr[$_SESSION['lang']].'/index.php?main_page=promotion&cId='.$cid;
		if($p_param['isMix'] == 1 && $_SESSION['site'] == '8seasons') $ret['cate_url'] = 'https://www.'.$_SESSION['site'].'.com/'.$langArr[$_SESSION['lang']].'/index.php?main_page=products_mixed&cId='.$cid;
		//	category name
		$ret['cate_name'] = $cresult->fields['categories_name'];
	}

	if(in_array($p_param['showOld'], array(1, 9)) || in_array($p_param['showCurr'], array(1, 9))){
	    if($price = myGetProductPrice($id, $p_param['showOld'], $p_param['showCurr'])){
	        $ret['price_old'] = $price[0];
	        $ret['price_curr'] = $price[1];
	    }
	}

	return $ret;
}

/**
* get product price
* @param	string	product id
* @return	array	price
*/
function myGetProductPrice($p_id, $p_old, $p_curr){
	global $db, $currencies, $currenciesArr, $aslowasArr;

	$product_id = intval($p_id);
	if(! $product_id) return false;
	
	$p_old_origin = $p_old;
	
	if($p_old == 0){
	    $p_old = $p_curr;
	}else{
	    if($p_old == $p_curr){
	        $same_flag = true;
	    }
	}

	$_SESSION['currency'] = $currenciesArr[$_SESSION['lang']];
	if(! is_object($currencies)) $currencies = new currencies();

	$origin_price_array = get_products_max_sale_price($product_id);
	$origin_price = $origin_price_array[0]['discount_price'];
	$max_discount = array_pop($origin_price_array);
	
	if($p_old > 0){
    	switch ($p_old){
    	    case 1:
    	        $showOld_value = $max_discount['discount_price'];
    	        break;
    	    case 9:
    	        $showOld_value = $origin_price;
    	        break;
    	}
    	$showOld = $currencies->display_price($showOld_value);
	}
	
	$display_specials_price = zen_get_products_special_price($product_id, false, $origin_price);
	if($display_specials_price && $display_specials_price != $origin_price){
	    $daily_deal_price = get_products_promotion_price($product_id);
	    
	    @ $discount = $display_specials_price/$origin_price;
	    switch ($p_curr){
	        case 1:
	            if($daily_deal_price){
	                $showCurr_value = $daily_deal_price;
	            }else{
	                $showCurr_value = $max_discount['discount_price'] * $discount;
	            }
	            $showCurr = $currencies->display_price($showCurr_value);
	            break;
	        case 9:
	            if($daily_deal_price){
	                $showCurr_value = $daily_deal_price;
	            }else{
	                $showCurr_value = $display_specials_price;
	            }
	            $showCurr = $currencies->display_price($showCurr_value);
	            break;
	    }
	}
	
	if($p_old_origin == 0){
	    $showCurr = $showOld;
	    $showOld = '';
	}else{
	    if($showCurr_value == 0 && $same_flag){
	        $showCurr = $showOld;
	        $showOld = '';
	    }
	}
	
	return array($showOld, $showCurr);
}

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

/**
* download image
* @param	string	product code
* @return	bool	succ or not
*/
function myGetProductImg($p_code){
	global $imgdownConf, $imgdownDir;

	$code = trim($p_code);
	if($code == '') return false;
	$remote_image = myGetImagePath($code);
	$local_image = $imgdownDir . $code . '.jpg';
	if(file_exists($local_image)) return true;		//	already exist
	$fgc = 'http://img.'.$_SESSION['site'].'.com/getRemoteImageByEdmmaker.php?img='.urlencode('pan195013'.$remote_image);
	if(! $str = @file_get_contents($fgc))	//	get image error
		return false;
	file_put_contents($local_image, $str);
	
	return true;
}

function myGetImagePath($p_code){
	global $imgdownConf, $db;

	$code = trim($p_code);
	if($code == '') return false;
	$path = '';

	switch($_SESSION['site']){
		case 'doreenbeads':
			$products_info = $db->Execute('select products_image from t_products where products_model = "' . $code .'"');
			$src = zen_db_input($products_info->fields['products_image']);
			$path = get_img_size($src , '310' , '310' , 'no_watermarkimg');
			$path = 'bmz_cache/' . $path;
			break;

		case '8seasons':
		default:
			$dir = substr($code, 0, 1) . '/' . substr($code, 0, 3) . '/';
			$path = $imgdownConf . $dir . $code . 'A.jpg';
			break;
	}

	return $path;
}

/**
* create zip file
* @param	array	files to add
* @param	string	zip file
* @param	bool	overwrite or not
* @return	bool	succ or not
*/
function myCreateZip($file_array = array(), $destination = '', $overwrite = false){
	if (file_exists($destination) && !$overwrite) return false;

	$valid_files = array();
	if (is_array($file_array)){
		foreach ($file_array as $file){
			if (file_exists($file)){
				$valid_files[] = $file;
			}
		}
	}

	if (sizeof($valid_files) > 0){
		$zip = new ZipArchive();
		if($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true){
			return false;
		}

		foreach ($valid_files as $zip_file){
			$zip->addFile($zip_file, basename($zip_file));
		}

		$zip->close();
		return file_exists($destination);
	} else {
		return false;
	}
}

/**
* delete all the file in dir ,and remove dir
* @param	string		dir
* @return	void
*/
function myDeleteDir($dir){
	if ($delete_dir = @dir($dir)){
		while ($delete_file = $delete_dir->read()){
			if (substr($delete_file, -1) != '.') unlink($dir . $delete_file);
		}
		$delete_dir->close();
	}
	@rmdir($dir);
}
?>