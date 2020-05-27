<?php
//	read from excel
$dataArr = array();

$sheetCount = $PHPExcel->getSheetCount();
for($n=0; $n<=$sheetCount-1; $n++){
	$arr = array();
	$currentSheet = $PHPExcel->getSheet($n);
	$allRow = $currentSheet->getHighestRow();
	for($currentRow = 2; $currentRow <= $allRow; $currentRow++){
		if(myGetValue(0, $currentRow) == '') continue;

		if($n == 0){
			$ret = myGetCategoryInfo(myGetValue(0, $currentRow));
			$ret['cate_desc'] = get_category_info_memcache(myGetValue(0, $currentRow) , 'categories_description', $_SESSION['lang']);
		}else{
			$param = array(
				'showCate'	=> myGetValue(1, $currentRow),
				'showOld'	=> myGetValue(2, $currentRow),
				'showCurr'	=> myGetValue(3, $currentRow),
				'isNew'		=> 0,
				'isPro'		=> 0,
				'isMix'		=> 0
			);
			$ret = myGetProductInfo(myGetValue(0, $currentRow), $param);
		}

		if(! $ret){
			echo myGetValue(0, $currentRow).' 数据不存在!<br/>';
		}else{
			$arr[] = $ret;
		}
	}
	if(count($arr))
		$dataArr[$n] = $arr;
}

chdir($oldDir);		//	important!!!

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
	$activeSheet->setSharedStyle($style_obj, "A2:H21");
	$n = 2;
	foreach($dataArr[0] as $a){
		//$activeSheet->setCellValue('A'.$n, $a['image']);
		//$activeSheet->setCellValue('C'.$n, $a['image']);
		$activeSheet->setCellValue('D'.$n, $a['name']);
		$activeSheet->setCellValue('E'.$n, $a['cate_url']);
		$activeSheet->setCellValue('F'.$n, $a['name']);
		//$activeSheet->setCellValue('G'.$n, $a['cate_desc']);
		$activeSheet->setCellValue('H'.$n, $a['cate_url']);
		
		$n++;
	}
	
	for($i = 1;$i < 5;$i++){
		$objPHPExcel->setActiveSheetIndex($i);
		$activeSheet = $objPHPExcel->getActiveSheet();
		$activeSheet->setSharedStyle($style_obj, "A2:F21");
		$n = 2;
		foreach($dataArr[$i] as $a){
			$activeSheet->setCellValue('A'.$n, $a['image']);
			$activeSheet->setCellValue('C'.$n, $a['url']);
			$activeSheet->setCellValue('D'.$n, $a['name']);
			$activeSheet->setCellValue('E'.$n, $a['name']);
			$activeSheet->setCellValue('F'.$n, $a['price_old']);
			$activeSheet->setCellValue('G'.$n, $a['price_curr']);
		
			if(! myGetProductImg($a['code'])){
				echo $a['code'].' 图片获取失败!<br/>';
			}else{
				$zipFileList[] = $imgdownDir.$a['code'].'.jpg';
			}
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
			echo '<a href="'.$imgdownFile.'" target="_blank">点此</a>下载首页图片ZIP.<br/>';
	}

	echo '<a href="'.$exceldownFile.'" target="_blank">点此</a>下载首页数据2EXCEL.<br/>';
}

//	delate temp dir
myDeleteDir($imgdownDir);

/**
* get category info;
* @param	int		category id;
* @return	array;
*/
function myGetCategoryInfo($p_id){
	global $db, $langArr;

	$id = intval($p_id);
	if(! $id) return false;
	$ret = array();
	$ret['id'] = $id;

	$cresult = $db->Execute('select c.categories_image, cd.categories_name from '. TABLE_CATEGORIES .' c, '. TABLE_CATEGORIES_DESCRIPTION.' cd where c.categories_id=cd.categories_id and c.categories_id='.$id.' and cd.language_id='.$_SESSION['lang']);
	$ret['name'] = $cresult->fields['categories_name'];
	$ret['image'] = $cresult->fields['categories_image'];

	$pre = $langArr[$_SESSION['lang']] == 'en' ? 'www' : $langArr[$_SESSION['lang']];
	$_SESSION["languages_id"] = $_SESSION['lang'];
	$_SESSION["languages_code"] = $langArr[$_SESSION['lang']];

	$cPath = get_category_info_memcache($id, 'cPath');
	$ret['cate_url'] = zen_href_link('index', 'cPath='.$cPath , 'SSL');//'http://'.$pre.'.'.$_SESSION['site'].'.com/index.php?main_page=index&cPath='.$id;

	return $ret;
}

/**
* download image
* @param	string	product code
* @return	bool	succ or not
*/
function myGetCategoryImg($p_code){
	global $imgdownConf, $imgdownDir;

	$code = trim($p_code);
	if($code == '') return false;

	$image = explode('/', $code);
	$remote_image = myGetCategoryImagePath($code);
	$local_image = $imgdownDir . $image[1];
	if(file_exists($local_image)) return true;		//	already exist
	if(! $str = @file_get_contents($remote_image))	//	get image error
		return false;
	file_put_contents($local_image, $str);
	
	return true;
}

/**
* get category image path
* @param	string		image
* @return	string		image path
*/
function myGetCategoryImagePath($p_code){
	global $cateImgDown;

	$code = trim($p_code);
	if($code == '') return false;

	//$image = substr($code, 0, strlen($code)-4) . '_120_120.JPG';
	$path = $cateImgDown.$code;
	
	return $path;
}
?>