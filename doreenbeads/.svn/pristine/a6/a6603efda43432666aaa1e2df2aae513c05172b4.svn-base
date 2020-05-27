<?php
define ( 'IS_ADMIN_FLAG', true );
require ('./db/query_factory.php');
require_once './db/init_database.php';
require_once('./PHPExcel.php');
require_once './PHPExcel/IOFactory.php';

if (isset($_POST ['action']) && $_POST ['action'] == 'tongji') {
	if (isset($_FILES['base_data']) && $_FILES['base_data']['error'] == 0){
		$new_file = 'base_data.xlsx';	
		if (file_exists($new_file)){
			unlink($new_file);
		}
		move_uploaded_file($_FILES['base_data']['tmp_name'], $new_file);
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel = PHPExcel_IOFactory::load($new_file);
		$objPHPExcel->setActiveSheetIndex(0);
		$allColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
		$allRow = $objPHPExcel->getActiveSheet()->getHighestRow();
		$sql = 'CREATE TABLE IF NOT EXISTS `staff` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `sex` char(1) NOT NULL,
		  `xueli` char(1) NOT NULL,
		  `age` int(2) NOT NULL,
		  `part` int(2) NOT NULL,
		  `gonglin` int(3) NOT NULL,
		  `date` DATETIME NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';		
		$db->Execute ( $sql );
		$db->Execute('TRUNCATE TABLE  `staff`');
		$sql = 'insert into staff values ';
		$time = date('Y-m-d H:i:s');
		for($x = 2; $x <= $allRow; $x++){
			$a = $objPHPExcel->getActiveSheet()->getCell('A'.$x)->getValue();
			$b = $objPHPExcel->getActiveSheet()->getCell('B'.$x)->getValue();
			$c = $objPHPExcel->getActiveSheet()->getCell('C'.$x)->getValue();
			$d = $objPHPExcel->getActiveSheet()->getCell('D'.$x)->getValue();
			$e = $objPHPExcel->getActiveSheet()->getCell('E'.$x)->getValue();
			preg_match_all('/\d/', $e, $m);
			$month = $m[0][0] * 12 + $m[0][1];
			if($a != ''){
				$sql .= '(NULL, "' . strtoupper(trim($b)) . '", "' . strtolower($c) . '", ' . $d . ', ' . $a . ', ' . $month . ', "' . $time . '"), ';
			}
		}
		$sql = substr($sql, 0 ,-2);
		$db->Execute($sql);
		unlink($new_file);
		$result['B'] = $db->Execute('select part, count(*) from staff where age > 40 group by part order by part;');
		$result['C'] = $db->Execute('select part, count(*) from staff where age > 30 and age <= 40 group by part order by part;');
		$result['D'] = $db->Execute('select part, count(*) from staff where age > 25 and age <= 30 group by part order by part;');
		$result['E'] = $db->Execute('select part, count(*) from staff where age > 20 and age <= 25 group by part order by part;');
		$result['F'] = $db->Execute('select part, count(*) from staff where age <= 20 group by part order by part;');
		
		$result['H'] = $db->Execute('select part, count(*) from staff where gonglin > 60 group by part order by part;');
		$result['I'] = $db->Execute('select part, count(*) from staff where gonglin > 36 and gonglin <= 60 group by part order by part;');
		$result['J'] = $db->Execute('select part, count(*) from staff where gonglin > 12 and gonglin <= 36 group by part order by part;');
		$result['K'] = $db->Execute('select part, count(*) from staff where gonglin > 6 and gonglin <= 12 group by part order by part;');
		$result['L'] = $db->Execute('select part, count(*) from staff where gonglin > 3 and gonglin <= 6 group by part order by part;');
		$result['M'] = $db->Execute('select part, count(*) from staff where gonglin <= 3 group by part order by part;');
		
		$result['O'] = $db->Execute('select part, count(*) from staff where xueli = "a" group by part order by part;');
		$result['P'] = $db->Execute('select part, count(*) from staff where xueli = "b" group by part order by part;');
		$result['Q'] = $db->Execute('select part, count(*) from staff where xueli = "c" group by part order by part;');
		$result['R'] = $db->Execute('select part, count(*) from staff where xueli = "d" group by part order by part;');
		
		$result['T'] = $db->Execute('select part, count(*) from staff where sex = "A" group by part order by part;');
		$result['U'] = $db->Execute('select part, count(*) from staff where sex = "B" group by part order by part;');

		$objPHPExcel = PHPExcel_IOFactory::load("tongji.xlsx");
		$objPHPExcel->setActiveSheetIndex(0);

		for ($i = 'B'; $i < 'V'; $i++){
			if (in_array($i, array('G', 'N', 'S'))) continue;
			while (!$result[$i]->EOF){
				for ($j = 3; $j <= 19; $j++){
					if ($result[$i]->fields['part'] == ($j - 2)){
						$objPHPExcel->getActiveSheet()->setCellValue($i . $j, $result[$i]->fields['count(*)']);
					}
				}
				$result[$i]->MoveNext();
			}
		}
		
		ob_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="tongjijieguo.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		$db->close();
		exit;
	}
}
?>
<html>
<head>
<title>统计</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" name="tongji" method="post" enctype="multipart/form-data">
	<input type="file" name="base_data" /><input type="submit" /> <input type="hidden" name="action" value="tongji" />
</form>
<font color="red">说明：</font><br>
1，导入的excel文件A列必须为部门，B列为性别，C列为学历，D列为年龄，E为工龄；<br>
2，正式数据从第二行开始；
</body>
</html>