<?php
/**
* create an excel for download; return html;
* author: lvxiaoyong 20140224
* version: 1.0
*/

if(! isset($_FILES['ulFile'])) die('请上传excel文件!');
$fileName = $_FILES['ulFile']['name'];
if(substr($fileName, strrpos($fileName, '.')+1) != 'xlsx') die('请上传正确的excel(*.xlsx)文件!');

if(true){
	$ulFile = $_FILES['ulFile']['tmp_name'];
}else{
	$ulFile = 'tmp/'.$_SESSION['SLT'].'_'.date("Ymd").'.xlsx';
	if(file_exists($ulFile)) unlink($ulFile);
	move_uploaded_file($_FILES['ulFile']['tmp_name'], $ulFile);
}
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

//	database config
$db_str = 'db_'.$_SESSION['site'];
$dbConf = $$db_str;
if(!is_array($dbConf) || !$dbConf) die('DB 配置错误!');
$con = mysql_connect($dbConf['server'], $dbConf['username'], $dbConf['password']) or die(mysql_error());
mysql_select_db($dbConf['database'], $con) or die(mysql_error());

//	imgdown config
$imgdown_str = 'imgdown_'.$_SESSION['site'];
$imgdownConf = $$imgdown_str;
$imgdownRand = 'imgdown_'.date('Ymd').'_'.rand(0,999);
$imgdownDir = 'tmp/'.$imgdownRand.'/';
$imgdownFile = 'download/'.'db_'.$imgdownRand.'.zip';
$exceldownFile = 'download/'.'db_'.$imgdownRand.'.xlsx';
if(file_exists($imgdownDir)) myDeleteDir($imgdownDir);
mkdir($imgdownDir);

//	read from excel
$dataArr = array();
$sheetCount = $PHPExcel->getSheetCount();
$oldDir = dirname(__FILE__);
chdir('C:/wamp/www/8seasons/');
//include('includes/application_top.php');
define('IS_ADMIN_FLAG',false);
include('includes/configure.php');
include('includes/classes/class.base.php');
include('includes/classes/db/mysql/query_factory.php');
include('includes/database_tables.php');
include('includes/functions/functions_general.php');
include('includes/functions/functions_price.php');
global $db;
if(! is_object($db)){
	$db = new queryFactory();
	$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, '', false);
}
if(!$db){
	echo 'ERROR: Could not connect to the database.';
	exit;
}

for($n=0; $n<=$sheetCount-1; $n++){
	$arr = array();
	$currentSheet = $PHPExcel->getSheet($n);
	$allRow = $currentSheet->getHighestRow();
	for($currentRow = 2; $currentRow <= $allRow; $currentRow++){
		if(myGetValue(0, $currentRow) == '') continue;
		$param = array(
			'showCate'	=> myGetValue(1, $currentRow),
			'showOld'	=> myGetValue(2, $currentRow),
			'showCurr'	=> myGetValue(3, $currentRow)
		);
		if(! $ret = myGetProductInfo(myGetValue(0, $currentRow), $param)){
			echo myGetValue(0, $currentRow).' 数据不存在!<br/>';
		}else{
			$arr[] = $ret;
		}
	}
	$dataArr[$n] = $arr;
}
chdir($oldDir);

echo '<pre>';
print_r($dataArr);
echo '</pre>';

if(count($dataArr) > 0){
	//	create Excel
	require './lib/classes/PHPExcel/IOFactory.php';
	$filePath = './template/excel/testEDM.xlsx';
	$objPHPExcel = PHPExcel_IOFactory::load($filePath);
	
	foreach($dataArr as $n=>$arr){
		$objPHPExcel->setActiveSheetIndex($n+1);
		$activeSheet = $objPHPExcel->getActiveSheet();
		$n = 3;
		foreach($arr as $a){
			$activeSheet->setCellValue('A'.$n, $a['image']);
		//	$activeSheet->setCellValue('B'.$n, $a['image']);
			$activeSheet->setCellValue('C'.$n, $a['url']);
			$activeSheet->setCellValue('D'.$n, $a['cate_name']);
			$activeSheet->setCellValue('E'.$n, $a['cate_name']);
			$activeSheet->setCellValue('F'.$n, $a['cate_url']);
			$activeSheet->setCellValue('G'.$n, $a['price_curr']);
			$activeSheet->setCellValue('H'.$n, $a['price_old']);

			if(! myGetProductImg($a['code']))
				echo $a['code'].' 图片获取失败!<br/>';
			else
				$zipFileList[] = $imgdownDir.$a['code'].'.jpg';
			$n++;
		}
	}
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	if(file_exists($exceldownFile)) unlink($exceldownFile);
	$objWriter->save($exceldownFile);

	if($zipFileList){
		if(! myCreateZip($zipFileList, $imgdownFile))
			echo '创建图片ZIP文件失败!<br/>';
		else
			echo '<a href="'.$imgdownFile.'">点此</a>下载图片ZIP.<br/>';
	}

	echo '<a href="'.$exceldownFile.'">点此</a>下载EXCEL.<br/>';
}

myDeleteDir($imgdownDir);

/**
* get product info;
* @param	string		product code;
* @return	array;
*/
function myGetProductInfo($p_code, $p_param){
	global $con,$langArr,$dbConf;

	$t_products = $dbConf['prefix'].'products';
	$t_products_description = $dbConf['prefix'].'products_description';
	$t_categories_description = $dbConf['prefix'].'categories_description';
	$code = trim($p_code);
	if($code == '') return false;
	$ret = array();
	$ret['code'] = $code;

	$result = mysql_query('select * from '.$t_products.' where products_model="'.$code.'" limit 1', $con);
	$productArr = mysql_fetch_array($result, MYSQLI_ASSOC);
	if(!$productArr) return false;
	$id = intval($productArr['products_id']);

	//	image
	$ret['image'] = $code.'.jpg';

	//	url
	$ret['url'] = 'http://www.'.$_SESSION['site'].'.com/'.$langArr[$_SESSION['lang']].'/index.php?main_page=product_info&&products_id='.$id;

/*
	//	name
	$result = mysql_query('select products_name from '.$t_products_description.' where products_id='.$id.' and language_id='.$_SESSION['lang'], $con);
	$nameArr = mysql_fetch_array($result, MYSQLI_ASSOC);
	$ret['name'] = $nameArr['products_name'];
*/

	if($p_param['showCate'] == 1){
		//	category url
		$ret['cate_url'] = 'http://www.'.$_SESSION['site'].'.com/'.$langArr[$_SESSION['lang']].'/index.php?main_page=index&cPath='.$productArr['master_categories_id'];
		//	category name
		$result = mysql_query('select categories_name from '.$t_categories_description.' where categories_id='.intval($productArr['master_categories_id']).' and language_id='.$_SESSION['lang'], $con);
		$nameArr = mysql_fetch_array($result, MYSQLI_ASSOC);
		$ret['cate_name'] = $nameArr['categories_name'];
	}

	if($p_param['showOld'] == 1 || $p_param['showCurr'] == 1){
		if($price = myGetProductPrice($id, $p_param['showOld'], $p_param['showCurr'])){
			$ret['price_old'] = $price[0];
			$ret['price_curr'] = $price[1];
		}
	}

	return $ret;
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

	$dir = substr($code, 0, 1) . '/' . substr($code, 0, 3) . '/';
	$remote_image = $imgdownConf . $dir . $code . 'A.jpg';	//	eg. 'img.8seasons.com/images/download/B/B00/B00001A.jpg'
	$local_image = $imgdownDir . $code . '.jpg';
	if(file_exists($local_image)) return true;		//	already exist
	if(! $str = file_get_contents($remote_image))	//	get image error
		return false;
	file_put_contents($local_image, $str);
	
	return true;
}

/**
* get product price
* @param	string	product id
* @return	array	price
*/
function myGetProductPrice($p_id, $p_old, $p_curr){
	global $con,$langArr,$dbConf;

	$id = intval($p_id);
	if(! $id) return false;

	$t_products = $dbConf['prefix'].'products';
	$t_products_discount_quantity = $dbConf['prefix'].'products_discount_quantity';
	$ret = array();

	$result = mysql_query('select products_price, products_discount_type from '.$t_products.' where products_id='.$id.' limit 1', $con);
	$productArr = mysql_fetch_array($result, MYSQLI_ASSOC);
	if(!$productArr) return false;
	$display_normal_price = $productArr['products_price'];
	$new_normal_price = '';
	
	if($productArr['products_discount_type'] > 0) {
		$result = mysql_query('select Max(discount_price) as low_discount from ' . $t_products_discount_quantity . ' Where products_id = ' . $id);
		$pdqArr = mysql_fetch_array($result, MYSQLI_ASSOC);
		if(count($pdqArr)>0 && $pdqArr['low_discount']){
			$new_normal_price = $display_normal_price * (1 - $pdqArr['low_discount'] / 100);
		}
	}

	if($p_old == 1){
		$showOld = zen_get_products_special_price($id);
	}else{
		$showOld = '';
	}
	if($p_curr == 1){
		if($new_normal_price!='')
			$showCurr = round($new_normal_price, 2) .' ~ '. round($display_normal_price, 2);
		else
			$showCurr = round($display_normal_price, 2);
	}else{
		$showCurr = '';
	}

	$ret = array($showOld, $showCurr);
	return $ret;
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
	rmdir($dir);
}
?>