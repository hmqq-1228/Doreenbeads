<?php
//	read from excel
$dataArr = array();
//$sheets = array('featured', 'new');
$sheetCount = $PHPExcel->getSheetCount();
for($n=0; $n<=$sheetCount-1; $n++){
	$arr = array();
	$currentSheet = $PHPExcel->getSheet($n);
	$allRow = $currentSheet->getHighestRow();
	for($currentRow = 2; $currentRow <= $allRow; $currentRow++){
		if(myGetValue(0, $currentRow) == '') continue;

		$param = array(
			'showCate'	=> $n==1 ? 1 : 0,
			'showOld'	=> 0,
			'showCurr'	=> $n==0 ? 1 : 0,
			'isNew'		=> $n==1 ? myGetValue(1, $currentRow) : 0,
			'isPro'		=> $n==1 ? myGetValue(2, $currentRow) : 0,
			'isMix'		=> $n==1 ? myGetValue(3, $currentRow) : 0
		);
		$ret = myGetProductInfo(myGetValue(0, $currentRow), $param);

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

	//	banner
	$objPHPExcel->setActiveSheetIndex(0);
	$activeSheet = $objPHPExcel->getActiveSheet();
	$activeSheet->setSharedStyle($style_obj, "A2:C5");

	//	hot
	$objPHPExcel->setActiveSheetIndex(1);
	$activeSheet = $objPHPExcel->getActiveSheet();
	$activeSheet->setSharedStyle($style_obj, "B2:F6");

	//	feature
	$objPHPExcel->setActiveSheetIndex(2);
	$activeSheet = $objPHPExcel->getActiveSheet();
	$activeSheet->setSharedStyle($style_obj, "A2:E21");
	$n = 2;
	foreach($dataArr[0] as $a){
		$activeSheet->setCellValue('A'.$n, $a['image']);
	//	$activeSheet->setCellValue('B'.$n, $a['image']);
		$activeSheet->setCellValue('C'.$n, $a['url']);
		$activeSheet->setCellValue('D'.$n, $a['name']);
		$activeSheet->setCellValue('E'.$n, $a['price_curr']);

		if(! myGetProductImg($a['code']))
			echo $a['code'].' 图片获取失败!<br/>';
		else
			$zipFileList[] = $imgdownDir.$a['code'].'.jpg';
		$n++;
	}

	//	new
	$objPHPExcel->setActiveSheetIndex(3);
	$activeSheet = $objPHPExcel->getActiveSheet();
	$activeSheet->setSharedStyle($style_obj, "A2:F21");
	$n = 2;
	foreach($dataArr[1] as $a){
		$activeSheet->setCellValue('A'.$n, $a['image']);
	//	$activeSheet->setCellValue('B'.$n, $a['image']);
		$activeSheet->setCellValue('C'.$n, $a['url']);
		$activeSheet->setCellValue('D'.$n, $a['name']);
		$activeSheet->setCellValue('E'.$n, $a['cate_name']);
		$activeSheet->setCellValue('F'.$n, $a['cate_url']);

		if(! myGetProductImg($a['code']))
			echo $a['code'].' 图片获取失败!<br/>';
		else
			$zipFileList[] = $imgdownDir.$a['code'].'.jpg';
		$n++;
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
?>