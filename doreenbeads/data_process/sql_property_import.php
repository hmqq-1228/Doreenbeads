<?php
chdir("../");
require('includes/application_top.php');
set_time_limit(3600);
@ini_set('memory_limit','2012M');
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel.php';
include 'PHPExcel/Reader/Excel2007.php';
include 'PHPExcel/Writer/Excel2007.php';
$objReader = new PHPExcel_Reader_Excel2007;
if(!isset($_GET['action'])){
	echo 'need param';
	exit;
}
global $db;
$action=$_GET['action'];
$file=$_GET['file'];
switch($action){
	//import group
	case 'step1':
		$objPHPExcel = $objReader->load($file.".xlsx");		
		$sheet = $objPHPExcel->getActiveSheet();
		for($j=3;$j<=$sheet->getHighestRow();$j++){
			$a1=trim($sheet->getCellByColumnAndRow(0,$j)->getValue());//code
			$b1=trim($sheet->getCellByColumnAndRow(1,$j)->getValue());//sort
			$c1=trim($sheet->getCellByColumnAndRow(2,$j)->getValue());//value
			$d1=trim($sheet->getCellByColumnAndRow(3,$j)->getValue());//type
			$e1=trim($sheet->getCellByColumnAndRow(4,$j)->getValue());//status
			$f1=trim($sheet->getCellByColumnAndRow(5,$j)->getValue());//creator
			$g1=trim($sheet->getCellByColumnAndRow(6,$j)->getValue());//create time
			$h1=trim($sheet->getCellByColumnAndRow(7,$j)->getValue());//modifier
			if(trim($c1)!=''&& $a1!=''){
				if($e1=='A'||$e1=='C'){
					$status=1;
				}else{
					$status=0;
				}
				$check=$db->Execute('select group_code from t_property_group where group_code="'.$a1.'" limit 1');
				if($check->RecordCount()>0){
					if($status<1){
						$db->Execute('update t_property_group set group_status=0 where group_code="'.$a1.'"');
						echo $a1.' disabled<br>';
					}else{
						echo $a1.'已存在<br>';
					}
					
				}else{
					
					$sql="insert into t_property_group (group_code,group_value,group_status,sort_order,creator,create_date) values ('".$a1."','".$c1."','".$status."','".$b1."','".$f1."','".date('Y-m-d H:i:s')."') ;";
					echo $sql.'<br>';
					$db->Execute($sql);
				}
			}
		}
	break;
	//import property
	case 'step2':
		$objPHPExcel = $objReader->load($file.".xlsx");		
		$sheet = $objPHPExcel->getActiveSheet();
		for($j=3;$j<=$sheet->getHighestRow();$j++){
			$a1=trim($sheet->getCellByColumnAndRow(0,$j)->getValue());//code
			$b1=trim($sheet->getCellByColumnAndRow(1,$j)->getValue());//sort
			$c1=trim($sheet->getCellByColumnAndRow(2,$j)->getValue());//group
			$d1=trim($sheet->getCellByColumnAndRow(3,$j)->getValue());//value
			$e1=trim($sheet->getCellByColumnAndRow(4,$j)->getValue());//status
			$f1=trim($sheet->getCellByColumnAndRow(5,$j)->getValue());//creator
			$g1=trim($sheet->getCellByColumnAndRow(6,$j)->getValue());//create time
			$h1=trim($sheet->getCellByColumnAndRow(7,$j)->getValue());//modifier
			if($e1=='A'||$e1=='C'){
				$status=1;
			}else{
				$status=0;
			}
			$check=$db->Execute('select property_code from t_property where property_code="'.$a1.'" limit 1');
			if($check->RecordCount()>0){
				if($status<1){
					$db->Execute('update t_property set property_status=0 where property_code="'.$a1.'"');
					echo $a1.' disabled<br>';
				}else{
					//echo $a1.'已存在<br>';
				}
			}elseif($a1!=''){
				
				$select=$db->Execute('select property_group_id from t_property_group where group_code="'.$c1.'" limit 1');
				if($select->RecordCount()>0){
					$d1=str_replace("'", "\'", $d1);
					$group=$select->fields['property_group_id'];
					$sql="insert into t_property (property_code,property_value,property_group_id,property_status,sort_order,property_creator,property_create_date) values ('".$a1."','".$d1."','".$group."','".$status."','".$b1."','1','".date('Y-m-d H:i:s')."') ";
					echo $sql.'<br>';
					$db->Execute($sql);
				}else{
					echo $j.'行，属性不存在<br>';
				}
					
			}
		}
		$db->Execute("update `t_property` set property_display_id=property_id where property_display_id=0;");
	break;
	//import property name
	case 'step3':
		$objPHPExcel = $objReader->load($file.".xlsx");		
		$sheet = $objPHPExcel->getActiveSheet();
		for($j=3;$j<=$sheet->getHighestRow();$j++){
			$a1=trim($sheet->getCellByColumnAndRow(0,$j)->getValue());//code
			$b1=trim($sheet->getCellByColumnAndRow(1,$j)->getValue());//lang
			$c1=trim($sheet->getCellByColumnAndRow(2,$j)->getValue());//name
			$kind=substr($a1, 0,1);
			$language=1;
			switch ($b1){
				case 'EN':
					$language=1;
					break;
				case 'DE':
					$language=2;
					break;
				case 'RU':
					$language=3;
					break;
				case 'FR':
					$language=4;
					break;
				case 'ES':
					$language=5;
					break;
				case 'JA':
					$language=6;
					break;
				case 'IT':
					$language=7;
					break;
			}
			$c1=str_replace("'", "\'", $c1);
			//$c1=str_replace("法语:", "", $c1);
			if($kind=='P'){
				$select=$db->Execute('select property_group_id from t_property_group where group_code="'.$a1.'" limit 1');
				if($select->RecordCount()>0){
					$check=$db->Execute('select property_group_id from  t_property_group_description where property_group_id="'.$select->fields['property_group_id'].'" and languages_id="'.$language.'" limit 1');
					if($check->RecordCount()>0){
						if($c1=="NULL"){
							$db->Execute("update t_property_group set group_status=0 where property_group_id='".$select->fields['property_group_id']."'");
							echo $a1.'---'.$b1 .'已失效<br>';
						}else{
							$db->Execute("update t_property_group_description set property_group_name='".$c1."' where property_group_id='".$select->fields['property_group_id']."' and languages_id='".$language."'");
							//echo $a1.'---'.$b1 .'已更新<br>';
						}
					}else{
						$sql="insert into t_property_group_description (property_group_id,languages_id,property_group_name) values ('".$select->fields['property_group_id']."','".$language."','".$c1."') ";
						//echo $j.'---'.$sql.'<br>';
						$db->Execute($sql);
					}
				}else{
					echo $j.'行，属性值不存在<br>';
				}
			}elseif($kind=='V'){
				$select=$db->Execute('select property_id from  t_property where property_code="'.$a1.'" limit 1');
				if($select->RecordCount()>0){
					$check=$db->Execute('select property_id from   t_property_description where property_id="'.$select->fields['property_id'].'" and languages_id="'.$language.'" limit 1');
					if($check->RecordCount()>0){
						if($c1=="NULL"){
							$db->Execute("update t_property set property_status=0 where property_id='".$select->fields['property_id']."'");
							echo $a1.'---'.$b1 .'已失效<br>';
						}else{
							$db->Execute("update t_property_description set property_name='".$c1."' where property_id='".$select->fields['property_id']."' and languages_id='".$language."'");
							//echo $a1.'---'.$b1 .'已更新<br>';
						}
					}else{
						$sql="insert into t_property_description (property_id,languages_id,property_name) values ('".$select->fields['property_id']."','".$language."','".$c1."') ";
						echo $j.'---'.$sql.'<br>';
						$db->Execute($sql);
					}
				}else{
					echo $j.'行，属性值不存在<br>';
				}
			}
		
		}
	break;
	// relationship for product and property
	case 'step4':
		$objPHPExcel = $objReader->load($file.".xlsx");		
		$sheet = $objPHPExcel->getActiveSheet();
		for($j=1;$j<=$sheet->getHighestRow();$j++){
			$a1=trim($sheet->getCellByColumnAndRow(1,$j)->getValue());//model
			$b1=trim($sheet->getCellByColumnAndRow(3,$j)->getValue());//group
			$c1=trim($sheet->getCellByColumnAndRow(4,$j)->getValue());//value
			$kind=substr($b1, 0,1);
			$kind1=substr($c1, 0,1);
			if($kind=='P'&&$kind1=='V'){
				$select=$db->Execute('select property_group_id from t_property_group where group_code="'.$b1.'" limit 1');
				$select1=$db->Execute('select property_id from  t_property where property_code="'.$c1.'" limit 1');
				if($select->RecordCount()>0&&$select1->RecordCount()>0){
					if(trim($a1)!=''){
						if(substr($a1,0,1)=='X'){
							$a1=substr($a1,1);
						}
						$select2=$db->Execute('select products_id from  t_products where products_model="'.$a1.'" ');
						if($select2->RecordCount()>0){
							$pid=$select2->fields['products_id'];
							if($pid!=''&&$pid!=0){
								$check=$db->Execute('select products_to_property_id  from   t_products_to_property where product_id="'.$pid.'" and property_id="'.$select1->fields['property_id'].'" and property_group_id="'.$select->fields['property_group_id'].'" limit 1');
								if($check->RecordCount()>0){
									//echo $a1.'---'.$b1 .'----'.$c1.'已存在<br>';
								}else{
									$sql="insert into t_products_to_property (product_id,property_id,property_group_id) values ('".$pid."','".$select1->fields['property_id']."','".$select->fields['property_group_id']."') ";
									//echo $j.'---'.$sql.'<br>';
									$db->Execute($sql);
								}
							}else{
								echo $j.'行，产品编号问题<br>';
							}
						}else{
							echo $j.'行，产品编号问题<br>';
						}
					}else{
						echo $j.'行，产品编号null<br>';
					}
				}else{
					echo $j.'行，属性值不存在<br>';
				}
			}else{
				echo $j.'行，属性值不存在<br>';
			}
		}
	break;
	//add other language name if not exist
	case 'step5':
		$select='select property_id,property_name from t_property_description where languages_id = 1 order by property_id ';
		$res=$db->Execute($select);
		while(!$res->EOF){
			for($i=2;$i<=5;$i++){
				$check=$db->Execute('select property_id,property_name from t_property_description where languages_id = '.$i.' and property_id='.$res->fields['property_id'].' limit 1');
				if($check->RecordCount()==0){
					$insert='insert into t_property_description (property_id,languages_id,property_name) values ('.$res->fields['property_id'].','.$i.',"'.addslashes($res->fields['property_name']).'") ';
					echo $insert.';<br>';
					$db->Execute($insert);
				}elseif($check->fields['property_name']==''){
					$update='update t_property_description set property_name="'.addslashes($res->fields['property_name']).'" where  property_id='.$res->fields['property_id'].' and languages_id='.$i.' ';
					echo $update.';<br>';
					$db->Execute($update);
				}
			}
			$res->MoveNext();
		}
		
		$select2='select property_group_id,property_group_name from t_property_group_description where languages_id = 1 order by property_group_id ';
		$res2=$db->Execute($select2);
		while(!$res2->EOF){
			for($i=2;$i<=5;$i++){
				$check2=$db->Execute('select property_group_id,property_group_name from t_property_group_description where languages_id = '.$i.' and property_group_id='.$res2->fields['property_group_id'].' limit 1');
				if($check2->RecordCount()==0){
					$insert2='insert into t_property_group_description (property_group_id,languages_id,property_group_name) values ('.$res2->fields['property_group_id'].','.$i.',"'.addslashes($res2->fields['property_group_name']).'") ';
					echo $insert2.';<br>';
					$db->Execute($insert2);
				}elseif($check2->fields['property_group_name']==''){
					$update2='update t_property_group_description set property_group_name="'.addslashes($res2->fields['property_group_name']).'" where  property_group_id='.$res2->fields['property_group_id'].' and languages_id='.$i.' ';
					echo $update2.';<br>';
					$db->Execute($update2);
				}
			}
			$res2->MoveNext();
		}
	break;
	//set basic property, property sort type
	case 'basic':
		$objPHPExcel = $objReader->load($file.".xlsx");
		$sheet = $objPHPExcel->getActiveSheet();
		$i=0;
		if(isset($_GET['sort'])&&$_GET['sort']=='all'){
			$leng=($sheet->getHighestRow())*10;
			$db->Execute('update t_property_group set sort_order = sort_order+'.$leng.' ');
		}
		
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$a1=trim($sheet->getCellByColumnAndRow(2,$j)->getValue());
			$b1=trim($sheet->getCellByColumnAndRow(3,$j)->getValue());
			$b1=$b1*10;
			$c1=trim($sheet->getCellByColumnAndRow(4,$j)->getValue());
			$d1=trim($sheet->getCellByColumnAndRow(5,$j)->getValue());
			$e1=trim($sheet->getCellByColumnAndRow(6,$j)->getValue());
			$u='update t_property_group set is_basic=1 , sort_order='.$b1.' where group_code ="'.$a1.'"  ';
			$update=$db->Execute($u);
			//echo $u.';<br>';
			$i++;
			if($e1=='1'){
				$db->Execute('update t_property_group set is_basic=0  where group_code ="'.$a1.'"  ');
			}
			if($c1!=''){
				$db->Execute('update t_property_group pg,t_property_group_description pgd  set property_group_name="'.$c1.'"  where pgd.property_group_id=pg.property_group_id and pgd.languages_id=1 and pg.group_code ="'.$a1.'"  ');
			}
			if($d1=='1'){
			$s='update t_property_group set sort_type=1 where group_code ="'.$a1.'" ';
			$db->Execute($s);
			}
		}
		echo $i;
	break;
	case 'to':
		$objPHPExcel = $objReader->load($file.".xlsx");
		$sheet = $objPHPExcel->getActiveSheet();
		if($_GET['step']==2){
			$group=array();
			$db->Execute('update t_property set property_display_id=property_id');
			for($j=2;$j<=$sheet->getHighestRow();$j++){
				$a1=trim($sheet->getCellByColumnAndRow(0,$j)->getValue());
				if(trim($a1)!=''){
					if(!isset($group[$a1])){
						$gselect='select property_group_id from  t_property_group where group_value="'.$a1.'" limit 1';
						$g=$db->Execute($gselect);
						$group[$a1]=$g->fields['property_group_id'];
					}
					$gid=$group[$a1];
					$b1=trim($sheet->getCellByColumnAndRow(7,$j)->getValue());
					$b2=trim($sheet->getCellByColumnAndRow(8,$j)->getValue());
					$check=$db->Execute('select ps_id from  t_propery_simplify where property_children='.$b2.' limit 1');
					if(trim($b1)!=''){
						if($check->RecordCount()>0){
							$db->Execute('update  t_property set property_display_id='.$b1.' where property_id='.$b2.' ');
							echo $j.'行 存在<br>';
						}else{
							$db->Execute('insert into  t_propery_simplify (property_parents,property_children) values('.$b1.','.$b2.')');
							$db->Execute('update  t_property set property_display_id='.$b1.' where property_id='.$b2.' ');
						}
					}
				}
			}
		}else{
			$group=array();	
			for($j=2;$j<=$sheet->getHighestRow();$j++){
				$a1=trim($sheet->getCellByColumnAndRow(0,$j)->getValue());
				if(trim($a1)!=''){
					if(!isset($group[$a1])){
						$gselect='select property_group_id from  t_property_group where group_value="'.$a1.'" limit 1';
						$g=$db->Execute($gselect);
						$group[$a1]=$g->fields['property_group_id'];
					}
					$gid=$group[$a1];
					$b=trim($sheet->getCellByColumnAndRow(4,$j)->getValue());
					$vselect='select property_code,property_value,p.property_id from  t_property p , t_property_description pd where pd.property_id=p.property_id and languages_id=1 and property_name="'.$b.'" and property_group_id='.$gid.' limit 1';
					$v=$db->Execute($vselect);
					if($b=='停用'){
					}else{
						if($v->RecordCount()>0){
							$sheet->setCellValueByColumnAndRow(5,$j,$v->fields['property_value']);
							$sheet->setCellValueByColumnAndRow(6,$j,$v->fields['property_code']);
							$sheet->setCellValueByColumnAndRow(7,$j,$v->fields['property_id']);
						}else{
							$insql='insert into t_property (property_code,property_value,property_group_id,property_status,sort_order,property_creator,property_create_date) values ("V0000000","'.$b.'",'.$gid.',1,10000,1,"'.date('Y-m-d H:i:s').'") ';
							$insert=$db->Execute($insql);
							$inid=$db->insert_ID();
							for($cou=1;$cou<=4;$cou++){
								$db->Execute('insert into t_property_description (property_id,languages_id,property_name) values('.$inid.','.$cou.',"'.$b.'") ');
							}
							file_put_contents('need.txt', $b."\n",FILE_APPEND);
							$sheet->setCellValueByColumnAndRow(5,$j,$b);
							$sheet->setCellValueByColumnAndRow(6,$j,'V0000000');
							$sheet->setCellValueByColumnAndRow(7,$j,$inid);
						}
					}
					$c1=trim($sheet->getCellByColumnAndRow(1,$j)->getValue());
					$select=$db->Execute('select property_id from t_property where property_code="'.$c1.'" limit 1');
					$sheet->setCellValueByColumnAndRow(8,$j,$select->fields['property_id']);
				}
			}
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save($file.".xlsx");
		}
		break;
		case 'size':
			$objPHPExcel = $objReader->load($file.".xlsx");
			$sheet = $objPHPExcel->getActiveSheet();
			if($_GET['step']==2){
				$group=array();
				//$db->Execute('update t_property set property_display_id=property_id');
				for($j=2;$j<=$sheet->getHighestRow();$j++){
					$a1=trim($sheet->getCellByColumnAndRow(1,$j)->getValue());
					if(trim($a1)!=''){
						if(!isset($group[$a1])){
							$gselect='select property_group_id from  t_property_group where group_code="'.$a1.'" limit 1';
							$g=$db->Execute($gselect);
							$group[$a1]=$g->fields['property_group_id'];
						}
						$gid=$group[$a1];
						$new=trim($sheet->getCellByColumnAndRow(5,$j)->getValue());
						if($new!=''){
							$b1=trim($sheet->getCellByColumnAndRow(8,$j)->getValue());
							$b2=trim($sheet->getCellByColumnAndRow(9,$j)->getValue());
							$check=$db->Execute('select ps_id from  t_propery_simplify where property_children='.$b2.' limit 1');
							if(trim($b1)!=''){
								if($check->RecordCount()>0){
									$db->Execute('update  t_property set property_display_id='.$b1.' where property_id='.$b2.' ');
									echo $j.'行 存在<br>';
								}else{
									$db->Execute('insert into  t_propery_simplify (property_parents,property_children) values('.$b1.','.$b2.')');
									$db->Execute('update  t_property set property_display_id='.$b1.' where property_id='.$b2.' ');
								}
							}							
						}
						$vcode=trim($sheet->getCellByColumnAndRow(3,$j)->getValue());
						$sort_order=trim($sheet->getCellByColumnAndRow(4,$j)->getValue());
						$db->Execute('update  t_property set sort_order='.$sort_order.' where property_code="'.$vcode.'" ');
					}
				}
			}else{
				$group=array();
				for($j=2;$j<=$sheet->getHighestRow();$j++){
					$a1=trim($sheet->getCellByColumnAndRow(1,$j)->getValue());
					if(trim($a1)!=''){
						if(!isset($group[$a1])){
							$gselect='select property_group_id from  t_property_group where group_code="'.$a1.'" limit 1';
							$g=$db->Execute($gselect);
							$group[$a1]=$g->fields['property_group_id'];						
						}
						$gid=$group[$a1];				
						$b=trim($sheet->getCellByColumnAndRow(5,$j)->getValue());
						if($b!=''){
						$vselect='select property_code,property_value,p.property_id from  t_property p , t_property_description pd where pd.property_id=p.property_id and languages_id=1 and property_name="'.$b.'" and property_group_id='.$gid.' limit 1';
						$v=$db->Execute($vselect);
						if($b=='停用'){
						}else{
							if($v->RecordCount()>0){
								$sheet->setCellValueByColumnAndRow(6,$j,$v->fields['property_value']);
								$sheet->setCellValueByColumnAndRow(7,$j,$v->fields['property_code']);
								$sheet->setCellValueByColumnAndRow(8,$j,$v->fields['property_id']);
							}else{
								$sort_order=trim($sheet->getCellByColumnAndRow(4,$j)->getValue());
								$insql='insert into t_property (property_code,property_value,property_group_id,property_status,sort_order,property_creator,property_create_date) values ("V0000000","'.$b.'",'.$gid.',1,"'.$sort_order.'",1,"'.date('Y-m-d H:i:s').'") ';
								$insert=$db->Execute($insql);
								$inid=$db->insert_ID();
								for($cou=1;$cou<=4;$cou++){
									$db->Execute('insert into t_property_description (property_id,languages_id,property_name) values('.$inid.','.$cou.',"'.$b.'") ');
								}
								file_put_contents('need.txt', $b."\n",FILE_APPEND);
								$sheet->setCellValueByColumnAndRow(6,$j,$b);
								$sheet->setCellValueByColumnAndRow(7,$j,'V0000000');
								$sheet->setCellValueByColumnAndRow(8,$j,$inid);
							}
						}
						$c1=trim($sheet->getCellByColumnAndRow(3,$j)->getValue());
						$select=$db->Execute('select property_id from t_property where property_code="'.$c1.'" limit 1');
						$sheet->setCellValueByColumnAndRow(9,$j,$select->fields['property_id']);
						}
					}
				}
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save($file.".xlsx");
			}
			echo 'over';
	break;
	case 'sort':
		
		$objPHPExcel = $objReader->load($file.".xlsx");	
		$sheet = $objPHPExcel->getActiveSheet();
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$i++;
			$a1=trim($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$b1=trim($sheet->getCellByColumnAndRow(2,$j)->getValue());
			$c1=trim($sheet->getCellByColumnAndRow(3,$j)->getValue());
			$d1=trim($sheet->getCellByColumnAndRow(4,$j)->getValue());
			$e1=trim($sheet->getCellByColumnAndRow(5,$j)->getValue());
			$f1=trim($sheet->getCellByColumnAndRow(6,$j)->getValue());
			$g1=trim($sheet->getCellByColumnAndRow(7,$j)->getValue());
			$h1=trim($sheet->getCellByColumnAndRow(8,$j)->getValue());

				$u1='update t_property set sort_order='.$g1.' where property_id='.$h1.' ';
				echo $u1.';<br>';
				$db->Execute($u1);
				$u2='update t_property_description set property_name="'.addslashes($d1).'" where property_id='.$h1.' and languages_id=2 ';
				echo $u2.';<br>';
				$db->Execute($u2);
				$u3='update t_property_description set property_name="'.addslashes($e1).'" where property_id='.$h1.' and languages_id=3 ';
				echo $u3.';<br>';
				$db->Execute($u3);
				$u4='update t_property_description set property_name="'.addslashes($f1).'" where property_id='.$h1.' and languages_id=4 ';
				echo $u4.';<br>';
				$db->Execute($u4);
				$u5='update t_property_description set property_name="'.addslashes($c1).'" where property_id='.$h1.' and languages_id=1 ';
				echo $u5.';<br>';
				$db->Execute($u5);
	
		}
		echo $i;
	break;
	//import category to property group
	case 'ctp':
		$objPHPExcel = $objReader->load($file.".xlsx");
		$sheet = $objPHPExcel->getActiveSheet();
		for($j=2;$j<=$sheet->getHighestRow();$j++){
			$a1='0'.trim($sheet->getCellByColumnAndRow(1,$j)->getValue());//category
			$b1=trim($sheet->getCellByColumnAndRow(3,$j)->getValue());//group
			
			$check_category = $db->Execute("select categories_id from t_categories where categories_code='".$a1."' limit 1");
			if($check_category->RecordCount()>0){
				$check_property = $db->Execute("select property_group_id from t_property_group where group_code='".$b1."' limit 1");
				if($check_property->RecordCount()>0){
					$check_exist = $db->Execute("select ctp_id from t_categories_to_property where categories_id='".$check_category->fields['categories_id']."' and property_group_id='".$check_property->fields['property_group_id']."' limit 1");
					if($check_exist->RecordCount()>0){
						echo 'existed<br/>';
					}else{
						$sql_data_array = array(
								'categories_id'=>$check_category->fields['categories_id'],
								'property_group_id'=>$check_property->fields['property_group_id']
						);
						zen_db_perform('t_categories_to_property', $sql_data_array);
						echo 'Add '.$a1.'-----'.$b1.'<br/>';
					}
				}else{
					echo 'property not existed<br/>';
				}
			}else{
				echo 'category not existed<br/>';
			}
			
		}
		break;
	case 'modify':
			$objPHPExcel = $objReader->load($file.".xlsx");
			$sheet = $objPHPExcel->getActiveSheet();
			$cnt=0;
			for($j=2;$j<=$sheet->getHighestRow();$j++){
				$a1=trim($sheet->getCellByColumnAndRow(0,$j)->getValue());//sku
				$b1=trim($sheet->getCellByColumnAndRow(1,$j)->getValue());//property
				$product_query = $db->Execute("select products_id from t_products where products_model='".$a1."' limit 1");
				$property_query = $db->Execute("select property_id from t_property where property_code='".$b1."' limit 1");
				if($product_query->fields['products_id']>0 && $property_query->fields['property_id']>0){
					$check_exist = $db->Execute("select products_to_property_id from ".TABLE_PRODUCTS_TO_PROPERTY."
						where product_id='".$product_query->fields['products_id']."'
						and property_id='".$property_query->fields['property_id']."'");
					if($check_exist->RecordCount()==0){
						$group_query = $db->Execute("select property_group_id from t_property where property_id='".$property_query->fields['property_id']."' limit 1");
							
						$sql_data = array(
								'product_id'=>$product_query->fields['products_id'],
								'property_id'=>$property_query->fields['property_id'],
								'property_group_id'=>$group_query->fields['property_group_id']
						);
						zen_db_perform(TABLE_PRODUCTS_TO_PROPERTY, $sql_data);
						$cnt++;
					}
				}else{
					echo $a1.' or '.$b1.' is not existed<br/>';
				}
			}
			echo $cnt;
			break;
	default:
		echo 'invalid param';
		break;
}
