<?php
chdir("../");
	require_once("includes/application_top.php");
	//require("includes/access_ip_limit.php");
	@ini_set('display_errors', '1');	
	set_time_limit(7200);
	ini_set('memory_limit','512M');
	global $db;
	
	
	if(!isset($_GET['fpath'])|| $_GET['fpath']=='') die('require param fpath');
	
	$exc_file = $_GET['fpath'];
	if(!file_exists($exc_file)) die("can not find file $exc_file");
	$filename = basename($exc_file);
  	$file_ext = substr($filename, strrpos($filename, '.') + 1);
 				
  	include 'Classes/PHPExcel.php';
  	if($file_ext=='xlsx'){		
  		include 'Classes/PHPExcel/Reader/Excel2007.php';
  		$objReader = new PHPExcel_Reader_Excel2007;
  	}else{
  		include 'Classes/PHPExcel/Reader/Excel5.php';
  		$objReader = new PHPExcel_Reader_Excel5;
  	}
  	$count = 0;
  	$name_list = array();
  	$objPHPExcel = $objReader->load($exc_file);
  	$sheet = $objPHPExcel->getActiveSheet();
 switch($_GET['type']){ 
 	case 'update_description_txt':
 		$folder= 'products/description/';
 		$date_str = $_GET['date'];
 		if(!$date_str){
 			die('need date str');
 		}
 		for($j=4;$j<=$sheet->getHighestRow();$j++){
 			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 			$pid_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."' limit 1");
 			if($model=='' || $pid_query->RecordCount()==0){
 				continue;
 			}
 			$weight = zen_db_prepare_input($sheet->getCellByColumnAndRow(5,$j)->getValue());
 			$volume = zen_db_prepare_input($sheet->getCellByColumnAndRow(6,$j)->getValue());
 			if($volume=='')$volume=0;
 			if($weight>0 )
 				$db->Execute("update ".TABLE_PRODUCTS." set products_weight=".$weight.",products_volume_weight=".$volume." where products_id=".$pid_query->fields['products_id']);
 			
 			
 			$name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(8,$j)->getValue());
 			$name_de = zen_db_prepare_input($sheet->getCellByColumnAndRow(10,$j)->getValue());
 			$name_ru = zen_db_prepare_input($sheet->getCellByColumnAndRow(12,$j)->getValue());
 			$name_fr = zen_db_prepare_input($sheet->getCellByColumnAndRow(14,$j)->getValue());
 			
 	
 			if($name_en!=''){
 				$sql_data = array(
 						'products_name'=>$name_en
 				);
 				zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data,'update', "products_id='".$pid_query->fields['products_id']."' and language_id =1");
 	
 			}
 			if($name_de!=''){
 				$sql_data = array(
 						'products_name'=>$name_de
 				);
 				zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data,'update', "products_id='".$pid_query->fields['products_id']."' and language_id =2");
 	
 			}
 			if($name_ru!=''){
 				$sql_data = array(
 						'products_name'=>$name_ru
 				);
 				zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data,'update', "products_id='".$pid_query->fields['products_id']."' and language_id =3");
 	
 			}
 			if($name_fr!=''){
 				$sql_data = array(
 						'products_name'=>$name_fr
 				);
 				zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data,'update', "products_id='".$pid_query->fields['products_id']."' and language_id =4");
 	
 			}
 			
 	
 			$products_description_en =  file_get_contents($folder.$date_str.'-EN/'.trim($model).'.txt');
 			$products_description_de =  file_get_contents($folder.$date_str.'-DE/'.trim($model).'.txt');
 			$products_description_ru =  file_get_contents($folder.$date_str.'-RU/'.trim($model).'.txt');
 			$products_description_fr =  file_get_contents($folder.$date_str.'-FR/'.trim($model).'.txt');
 			
 			if($products_description_de == ''){
 				$products_description_de = $products_description_en;
 			}
 			if($products_description_ru == ''){
 				$products_description_ru = $products_description_en;
 			}
 			if($products_description_fr == ''){
 				$products_description_fr = $products_description_en;
 			}
 			
 			if($products_description_en != ''){
 				$sql_data_array_description = array(
 						'products_description' => trim($products_description_en)
 				);
 				zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description,"update",'products_id = '.$pid_query->fields['products_id'].' and language_id = 1');
 	
 			}
 			unset($sql_data_array_description);
 	
 			if($products_description_de != ''){
 				$sql_data_array_description = array(
 						'products_description' => trim($products_description_de)
 				);
 				zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description,"update",'products_id = '.$pid_query->fields['products_id'].' and language_id = 2');
 	
 			}
 			unset($sql_data_array_description);
 	
 				
 			if($products_description_ru != ''){
 				$sql_data_array_description = array(
 						'products_description' => trim($products_description_ru)
 				);
 				zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description,"update",'products_id = '.$pid_query->fields['products_id'].' and language_id = 3');
 	
 			}
 	
 			unset($sql_data_array_description);
 	
 			if($products_description_fr != ''){
 					
 				$sql_data_array_description = array(
 						'products_description' => trim($products_description_fr));
 				zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description,"update",'products_id = '.$pid_query->fields['products_id'].' and language_id = 4');
 	
 			}
 	
 			unset($sql_data_array_description);
 			remove_product_memcache($pid_query->fields['products_id']);
 			
 			$count++;
 		}
 		echo $count;
 		break;
 	case 'property_group':
 		$group_query = $db->Execute("select pg.property_group_id, pgd.property_group_name from zen_property_group pg, zen_property_group_description pgd
 								 where pg.property_group_id=pgd.property_group_id
 									and pgd.languages_id=1");
 		while(!$group_query->EOF){
 			$check_exist = $db->Execute("select property_group_id from zen_property_group_description where property_group_id='".$group_query->fields['property_group_id']."' and languages_id=5");
 			if($check_exist->RecordCount()==0){
 				$sql_data_arr = array(
 						'property_group_id'=>$group_query->fields['property_group_id'],
 						'languages_id'=>5,
 						'property_group_name'=>$group_query->fields['property_group_name'],
 				);
 				zen_db_perform('zen_property_group_description', $sql_data_arr);
 				$count++;
 			}
 			$group_query->MoveNext();
 		}
 		echo $count;
 		break;
 	case 'property':
 		for($j=2;$j<=$sheet->getHighestRow();$j++){
 			$property_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 			$name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
 			$name_es = zen_db_prepare_input($sheet->getCellByColumnAndRow(3,$j)->getValue());
 			if($name_es==''){
 				$name_es = $name_en;
 			}
 			if(strtoupper(substr($property_code, 0, 1))=='P'){
 				$group_query = $db->Execute("select property_group_id from zen_property_group where group_code='".$property_code."' limit 1");
 				if($group_query->RecordCount()>0){
 					$sql_data_arr = array(
 							'property_group_id'=>$group_query->fields['property_group_id'],
 							'languages_id'=>5,
 							'property_group_name'=>$name_es
 					);
 					$check_exist = $db->Execute("select property_group_id from zen_property_group_description where property_group_id='".$group_query->fields['property_group_id']."' and languages_id=5");
 					if($check_exist->RecordCount()==0){
 						zen_db_perform('zen_property_group_description', $sql_data_arr);
 						$count++;
 					}
 				}
 			}elseif(strtoupper(substr($property_code, 0, 1))=='V'){
 				$property_query = $db->Execute("select property_id from zen_property where property_code='".$property_code."' limit 1"); 				
 				if($property_query->RecordCount()>0){ 					
 					$sql_data_arr = array(
 							'property_id'=>$property_query->fields['property_id'],
 							'languages_id'=>5,
 							'property_name'=>$name_es
 					);
 					$check_exist = $db->Execute("select property_id from zen_property_description where property_id='".$property_query->fields['property_id']."' and languages_id=5");
 					if($check_exist->RecordCount()==0){
 						zen_db_perform('zen_property_description', $sql_data_arr);
 						$count++;
 					}
 				}
 			}
 		}
 		echo $count;
 		break;
 	case 'category':
//category name ru
  		for($j=2;$j<=$sheet->getHighestRow();$j++){
  			$category_id = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
  			$name_ru= zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
  	
  			$db->Execute("update t_categories_description set categories_name='".$name_ru."' where categories_id='".$category_id."' and language_id=3");
  			$count++;
  		}
  		echo $count;
  	break;
  	exit;
 	case 'product':
//product name ru  
		$product_query = $db->Execute("select products_id, products_model from t_products");
  		while(!$product_query->EOF){
  			
  			$name_query_de = $db->Execute("select products_name,products_description,products_name_without_catg
  						from zen_products p, zen_products_description pd
  						where p.products_id=pd.products_id
  						and pd.language_id=2 and p.products_model='".$product_query->fields['products_model']."' limit 1");
  			if($name_query_de->RecordCount()>0){
  					$sql_data_arr = array(
  			
  				'products_name'=>zen_db_prepare_input($name_query_de->fields['products_name']),
  				'products_description'=>$name_query_de->fields['products_description'],
  				'products_name_without_catg'=>zen_db_prepare_input($name_query_de->fields['products_name_without_catg'])
  					
  				);
  				zen_db_perform('t_products_description', $sql_data_arr, 'update', "products_id='".$product_query->fields['products_id']."' and language_id=2");
  			}		
  			
  			$name_query = $db->Execute("select products_name,products_description,products_name_without_catg
  						from zen_products p, zen_products_description pd
  						where p.products_id=pd.products_id
  						and pd.language_id=4 and p.products_model='".$product_query->fields['products_model']."' limit 1");
  			if($name_query->RecordCount()>0){
  				$sql_data_arr = array(

  						'products_name'=>zen_db_prepare_input($name_query->fields['products_name']),
  						'products_description'=>$name_query->fields['products_description'],
  						'products_name_without_catg'=>zen_db_prepare_input($name_query->fields['products_name_without_catg'])
  							
  				);
  				zen_db_perform('t_products_description', $sql_data_arr, 'update', "products_id='".$product_query->fields['products_id']."' and language_id=4");
 				 
  				$count++;
  			}
  			
  			$product_query->MoveNext();
  		}
  		echo $count;
  	break;
 	case 'category_fr':
 		$category_query = $db->Execute("select c.categories_id, cd.categories_name,cd.categories_description from t_categories c, t_categories_description cd 
 										where c.categories_id=cd.categories_id and cd.language_id=1");
 		while(!$category_query->EOF){
 			$check_es_exist = $db->Execute("select categories_id from t_categories_description where categories_id='".$category_query->fields['categories_id']."' and language_id=4");
 			if($check_es_exist->RecordCount()==0){
 				$sql_data = array(
 						'categories_id'=>$category_query->fields['categories_id'],
 						'language_id'=>4,
 						'categories_name'=>$category_query->fields['categories_name'],
 						'categories_description'=>$category_query->fields['categories_description']
 				);
 				zen_db_perform('t_categories_description', $sql_data);
 				$count++;
 			}
 			$category_query->MoveNext();
 		}
 		echo $count;
 		break;
 	case 'category_de':
 			$category_query = $db->Execute("select c.categories_id, cd.categories_name,cd.categories_description from t_categories c, t_categories_description cd
 										where c.categories_id=cd.categories_id and cd.language_id=1");
 			while(!$category_query->EOF){
 				$check_es_exist = $db->Execute("select categories_id from t_categories_description where categories_id='".$category_query->fields['categories_id']."' and language_id=2");
 				if($check_es_exist->RecordCount()==0){
 					$sql_data = array(
 							'categories_id'=>$category_query->fields['categories_id'],
 							'language_id'=>2,
 							'categories_name'=>$category_query->fields['categories_name'],
 							'categories_description'=>$category_query->fields['categories_description']
 					);
 					zen_db_perform('t_categories_description', $sql_data);
 					$count++;
 				}
 				$category_query->MoveNext();
 			}
 			echo $count;
 			break;
 	case 'product_fr':
 		$products_query = $db->Execute("select p.products_id,pd.products_name,pd.products_description,products_name_without_catg
 							from t_products p, t_products_description pd where p.products_id=pd.products_id and language_id=1");
 		while(!$products_query->EOF){
 			$check_exist = $db->Execute("select products_id from t_products_description where products_id='".$products_query->fields['products_id']."' and language_id=4");
 			if($check_exist->RecordCount()==0){
 				$sql_data_arr = array(
 						'products_id'=>$products_query->fields['products_id'],
 						'language_id'=>4,
 						'products_name'=>$products_query->fields['products_name'],
 						'products_description'=>$products_query->fields['products_description'],
 						'products_name_without_catg'=>$products_query->fields['products_name_without_catg']
 						
 				);
 				zen_db_perform('t_products_description', $sql_data_arr);
 				$count++;
 			}
 			
 			$products_query->MoveNext();
 		}
 		echo $count;
 		break;
 	case 'product_de':
 			$products_query = $db->Execute("select p.products_id,pd.products_name,pd.products_description,products_name_without_catg
 							from t_products p, t_products_description pd where p.products_id=pd.products_id and language_id=1");
 			while(!$products_query->EOF){
 				$check_exist = $db->Execute("select products_id from t_products_description where products_id='".$products_query->fields['products_id']."' and language_id=2");
 				if($check_exist->RecordCount()==0){
 					$sql_data_arr = array(
 							'products_id'=>$products_query->fields['products_id'],
 							'language_id'=>2,
 							'products_name'=>$products_query->fields['products_name'],
 							'products_description'=>$products_query->fields['products_description'],
 							'products_name_without_catg'=>$products_query->fields['products_name_without_catg']
 								
 					);
 					zen_db_perform('t_products_description', $sql_data_arr);
 					$count++;
 				}
 		
 				$products_query->MoveNext();
 			}
 			echo $count;
 			break;
 	case 'beads':
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 					
 				$model = $sheet->getCellByColumnAndRow(0,$j)->getValue();
 				$name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 				$name_en = str_replace("'", "\'", $name_en);
 				$pid = $db->Execute("select products_id from t_products where products_model='".$model."'");
 				if($pid->fields['products_id']>0 && $name_en!=''){
 					$sql = "update t_products_description set products_name = '".$name_en."' where products_id='".$pid->fields['products_id']."' and language_id =1;";
 					$db->Execute($sql);
 					$count++;
 				}
 					
 			}
 			echo $count;
 			break;
//  	case 'ezpage':
 				
//  				$ezpage_query = $db->Execute("select pages_id,languages_id,pages_html_text from t_ezpages order by pages_id");
//  				while(!$ezpage_query->EOF){
//  					$new_content = str_ireplace(array('<ins class="closecont"></ins>','<ins class="closecont"> </ins>','<ins></ins>'), '<ins class="closecont">&nbsp;</ins>', $ezpage_query->fields['pages_html_text']);
//  					$sql_data_arr = array(
 					
//  							'pages_html_text'=>($new_content),
 							
 								
//  					);
//  					zen_db_perform('t_ezpages', $sql_data_arr, 'update', "pages_id='".$ezpage_query->fields['pages_id']."' and languages_id=".$ezpage_query->fields['languages_id']);
 					
//  					$count++;
 			
//  					$ezpage_query->MoveNext();
//  				}
//  				echo $count++;
//  		break;
 	case 'prod_desc':
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 				$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 				$products_id = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 		
 				$fpath_en = 'products/description/20140124-EN/'.$model.'.txt';
 				$fpath_ru = 'products/description/20140124-RU/'.$model.'.txt';
 				
 				if($products_id->fields['products_id']>0 && file_exists($fpath_en)){
 					$desc_en = trim(file_get_contents($fpath_en));
 					$sql_data_en = array('products_description'=>$desc_en);
 					zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_en,'update', "products_id='".$products_id->fields['products_id']."' and language_id =1");
 				}
 				if($products_id->fields['products_id']>0 && file_exists($fpath_ru)){
 					$desc_ru = trim(file_get_contents($fpath_ru));
 					$sql_data_ru = array('products_description'=>$desc_ru);
 					zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_ru,'update', "products_id='".$products_id->fields['products_id']."' and language_id =3");
 				}
 				
 				echo $desc_en.'<br/>';
 				$count++;
 			}
 			echo $count;
 			break;
 	case 'mixed':
 		$i=0;
 		$mix_query = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where first_categories_id=1680 group by products_id");
 		while(!$mix_query->EOF){
 			$db->Execute("update ".TABLE_PRODUCTS." set is_mixed=1 where products_id='".$mix_query->fields['products_id']."'");
 			$i++;
 			$mix_query->MoveNext();
 		}
 		echo $i;
 		break;
 	case 'pack_qty':
 			$cnt=0;
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 				$products_model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 				$unit_number = zen_db_prepare_input($sheet->getCellByColumnAndRow(3,$j)->getValue());
 				$unit_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
 				
   				$products_id_sql = 'select products_id from t_products where products_model ="'.$products_model.'" ';
    			$product_query = $db->Execute($products_id_sql);
    			
   		 		if(!$product_query->fields['products_id'])   continue;
   
    			$products_unit_id = 'select unit_id from t_products_unit where unit_code = "'.$unit_code.'"';
    			$unit_query = $db->Execute($products_unit_id);
	    
    			if(!$unit_query->fields['unit_id']) {
    				echo $products_model.'---'.$unit_code.' not exist<br/>';
    				continue; 
    			}
    			remove_product_memcache($product_query->fields['products_id']);
    			$db->Execute("delete from ".TABLE_PRODUCTS_TO_UNIT." where products_id=".$product_query->fields['products_id']);
    			$check_exist = $db->Execute("select unit_number from t_products_to_unit where products_id=".$product_query->fields['products_id']." and products_unit_id=".$unit_query->fields['unit_id']) ; 
   				if($check_exist->RecordCount()==0){
   					$unit_data_query = array(
   						'products_id'=>$product_query->fields['products_id'],
   						'products_unit_id'=>$unit_query->fields['unit_id'],
   						'unit_number'=>	(int)$unit_number   						
   					);
    				zen_db_perform(TABLE_PRODUCTS_TO_UNIT, $unit_data_query);
    				$cnt++;
   				}
 			}
 			echo $cnt;
 		break;
 	case 'silver_img':
 			$cnt=0;
 			$src_img = 'download/silver_report.jpg';
 			$src_folder = 'download/';
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 				$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 				$image_query = $db->Execute("select products_id,products_image from ".TABLE_PRODUCTS." where products_model='".$model."'");
 				if($image_query->RecordCount()>0 && $image_query->fields['products_image']!=''){
 					$products_image = $image_query->fields['products_image'];
 					$image_name_arr = explode('.', $products_image);
 					$postfix = $image_name_arr[sizeof($image_name_arr)-1];
 					$products_image_c = str_replace('.'.$postfix ,'C.'.$postfix ,$products_image);
 					$filesize_c = filesize($src_folder.$products_image_c.'')/1024;
 					if($filesize_c == 0){
 						$products_image_c = str_replace('JPG','jpg',$products_image_c);
 						$filesize_c = filesize($src_folder.$products_image_c.'')/1024;
 					}
 					$cp_res = copy($src_img, $src_folder.$products_image_c);
 					if($cp_res){
 						$water = file_get_contents('http://www.dorabeads.com/uploadimg.php?plist='.$image_query->fields['products_id']);
 						if($water) {
 							echo $products_image_c.'---'.$water.'<br/>';
 							$cnt++;
 						}
 					}
 				}
 			}
 			echo $cnt;
 			break;
 	case 'my_products':
 		$cnt=0;
 		for($j=2;$j<=$sheet->getHighestRow();$j++){
 			$email = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 			$customers_query = $db->Execute("select customers_id from ".TABLE_CUSTOMERS." where customers_email_address ='".$email."'");
 			$products_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 			if($customers_query->RecordCount()>0 && $products_query->RecordCount()>0){
 				$db->Execute("update ".TABLE_PRODUCTS." set products_status=0 where products_id=".$products_query->fields['products_id']);
 				remove_product_memcache($pid_query->fields['products_id']);
 				$data_array = array('customers_id'=>$customers_query->fields['customers_id'],'products_id'=>$products_query->fields['products_id']);
 				zen_db_perform(TABLE_MY_PRODUCTS, $data_array);
 				$cnt++;
 			}
 		}
 		echo $cnt;
 		break;
 	case 'update_name':
 			if(!$_GET['lang']){
 				die('require language');
 			}
 			$lanuages_id=$_GET['lang'];
 			$cnt=0;
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 				$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 				$name = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 				$pid_query = $db->Execute("select products_id,products_date_added from ".TABLE_PRODUCTS." where products_model='".$model."' limit 1");
 				if($pid_query->fields['products_id']>0 && $pid_query->fields['products_date_added']>'2014-05-15 00:00:00'){
 					$sql_data = array(
 							'products_name'=>$name
 					);
 					zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data,'update', "products_id='".$pid_query->fields['products_id']."' and language_id ='".$lanuages_id."'");
 					$cnt++;
 				}
 		
 			}
 			echo $cnt;
 			break;
 	case 'property_display':
 		$cnt=0;
 		for($j=2;$j<=$sheet->getHighestRow();$j++){
 					$property_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 					$display_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
 					$display_query = $db->Execute("select property_id from ".TABLE_PROPERTY." where property_code='".$display_code."'");
 					$db->Execute("update ".TABLE_PROPERTY." set property_display_id='".$display_query->fields['property_id']."' where property_code='".$property_code."'");
 					$cnt++;
 		}
 		echo $cnt;
 		break;
	case 'property_display_new':	//	属性值归总
 		$cnt=0;
 		for($j=2;$j<=$sheet->getHighestRow();$j++){
 			$property_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$display_name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(4,$j)->getValue());
 			$display_name_cn = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$display_query = $db->Execute('select a.property_id from t_property a 
				left join t_property_description b on a.property_id=b.property_id 
				left join t_property_group c on a.property_group_id=c.property_group_id
				where b.languages_id=1 and b.property_name="'.$display_name_en.'" and c.group_value="'.$display_name_cn.'"');
//			$a = $db->Execute("select property_display_id from ".TABLE_PROPERTY." where property_code='".$property_code."'");
			if($display_query->RecordCount()>0){
//				echo 'new: '.$display_query->fields['property_id'].' ==  old: '.$a->fields['property_display_id']."<br/>";
				$db->Execute("update ".TABLE_PROPERTY." set property_display_id='".$display_query->fields['property_id']."' where property_code='".$property_code."'");
			}
 			$cnt++;
 		}
 		echo $cnt;
 		break;

 	case 'reload_img':
 		$cnt=0;
 		for($j=2;$j<=$sheet->getHighestRow();$j++){
 			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 			$products_query = $db->Execute("select products_id from t_products where products_model='".$model."'");
 			if($products_query->RecordCount()>0){
 				$db->Execute("delete from t_product_image_update where product_id=".$products_query->fields['products_id']);
 				$cnt++;
 			}
 			
 		}
 		echo $cnt;
 		
 		break;
 		case 'update_description_info':
 			$cnt=0;
 			if(!$_GET['lang']){
 				die('require language');
 			}
 			$languages_id=$_GET['lang'];
 			$lang_query = $db->Execute("select code from ".TABLE_LANGUAGES." where languages_id=".$languages_id);
 			if($lang_query->RecordCount()==0){
 				die('invalid language');
 			}
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 				$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 		
 				$pid_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."' limit 1");
 				if($pid_query->fields['products_id']>0 ){
 					$desc_en = $db->Execute("select products_description from ".TABLE_PRODUCTS_DESCRIPTION." where products_id = ".$pid_query->fields['products_id']." and language_id =1");
 					$sql_data_array_description = array(
 							'products_description' => $desc_en->fields['products_description']);
 					zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array_description,"update",'products_id = '.$pid_query->fields['products_id'].' and language_id ='.$languages_id);
 					$cnt++;
 				}
 			}
 			break;
 		case 'mix_area':
 					
 				$cnt=0;
 			
 				for($j=2;$j<=$sheet->getHighestRow();$j++){
 					$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 					$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 					if($product_query->RecordCount()>0){
 						$db->Execute("update ".TABLE_PRODUCTS." set is_mixed=1 where products_id='".$product_query->fields['products_id']."'");
 						$cnt++;
 					}
 				}
 				echo $cnt;
 			
 				break;
 		case 'price_manager':
 					$cnt=0;
 					for($j=2;$j<=$sheet->getHighestRow();$j++){
 						$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 						$product_query = $db->Execute("select products_id,price_manager_id,products_price from ".TABLE_PRODUCTS." where products_model='".$model."'");
 						if($product_query->RecordCount()>0&& !$product_query->fields['price_manager_id']){
 							$db->Execute("update ".TABLE_PRODUCTS." set products_price=products_price*1.03,price_manager_id =39 where products_id='".$product_query->fields['products_id']."'");
              $operate_content = '商品 products_price 变更: from '. $product_query->fields['products_price'] .' to '. $product_query->fields['products_price']*1.03 .' in ' . __FILE__ . ' on line: ' . __LINE__;
              zen_insert_operate_logs ( $_SESSION ['admin_id'], $model, $operate_content, 2 );
 							$cnt++;
 						}
 					}
 					echo $cnt;
 						
 					break;
 			case 'load_promotion':
 						$cnt=0;
 						for($j=2;$j<=$sheet->getHighestRow();$j++){
 							$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 							$promotion_id = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 							$product_query = $db->Execute("select products_id,products_limit_stock from ".TABLE_PRODUCTS." where products_model='".$model."'");
 							if($product_query->RecordCount()>0 && $promotion_id>0){
 								remove_product_memcache($product_query->fields['products_id']);
 								//$check_exist = $db->Execute("select pp_promotion_id from ".TABLE_PROMOTION_PRODUCTS." where pp_products_id=".$product_query->fields['products_id']);
 								
 								$db->Execute("delete from ".TABLE_PROMOTION_PRODUCTS." where pp_products_id=".$product_query->fields['products_id']);
 															
 								$check_stock = $db->Execute("select products_quantity from ".TABLE_PRODUCTS_STOCK." where products_id=".$product_query->fields['products_id']);
 								if($check_stock->fields['products_quantity']>0){
 								 			
 									$promotion_data = array(
 											'pp_products_id'=>$product_query->fields['products_id'],
 											'pp_promotion_id'=>(int)$promotion_id
 					
 									);
 									zen_db_perform(TABLE_PROMOTION_PRODUCTS, $promotion_data);
 									if($product_query->fields['products_limit_stock']==1){
 										$db->Execute("update ".TABLE_PRODUCTS." set products_is_perorder=1 where products_id='".$product_query->fields['products_id']."'");
 									}
 									$cnt++;
 								}
 					
 							}
 						}
 						echo $cnt;
 							
 				break;
 			case 'customer_tele':
 				$address_query = $db->Execute("select address_book_id,customers_id from ".TABLE_ADDRESS_BOOK." where entry_telephone=''");
 				while(!$address_query->EOF){
 					$tel_query = $db->Execute("select customers_telephone,customers_cell_phone from ".TABLE_CUSTOMERS." where customers_id=".$address_query->fields['customers_id']);
 					if($tel_query->fields['customers_telephone']!=''){
 						$db->Execute("update ".TABLE_ADDRESS_BOOK." set entry_telephone='".$tel_query->fields['customers_telephone']."' where address_book_id=".$address_query->fields['address_book_id']);
 						$cnt++;
 					}elseif($tel_query->fields['customers_cell_phone']!=''){
 						$db->Execute("update ".TABLE_ADDRESS_BOOK." set entry_telephone='".$tel_query->fields['customers_cell_phone']."' where address_book_id=".$address_query->fields['address_book_id']);
 						$cnt++;
 					}
 					$address_query->MoveNext();
 				}
 				echo $cnt;
 				break;
 			case 'update_clearance':
 					$cnt=0;
 					for($j=2;$j<=$sheet->getHighestRow();$j++){
 						$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 						$cpath = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 						$pid_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."' limit 1");
 						if($model=='' || $pid_query->RecordCount()==0){
 							continue;
 						}
 						$path_arr = explode('_',$cpath);
 						$cid = $path_arr[sizeof($path_arr)-1];
 						$first_cid = 0;
 						$second_cid = 0;
 						$third_cid = 0;
 						$k=1;
 						foreach($path_arr as $val){
 							if($k==1){
 								$first_cid = $val;
 							}elseif($k==2){
 								$second_cid = $val;
 							}elseif($k==3){
 								$third_cid = $val;
 							}
 							$k++;
 						}
 						$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$pid_query->fields['products_id']." and categories_id=".(int)$cid);
 						if($check_exist->RecordCount()==0){
 							$ptc_data = array(
 									'products_id'=>$pid_query->fields['products_id'],
 									'categories_id'=>$cid,
 									'first_categories_id'=>	$first_cid,
 									'second_categories_id'=>$second_cid,
 									'three_categories_id'=>	$third_cid
 							);
 							zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $ptc_data);
 							$cnt++;
 						}
 					}
 					echo $cnt;
 				break;
 	case 'set_daily_deal':
 					$cnt=0;
 					$group = 1;
 					if($_GET['group']>0){
 							$group = (int)$_GET['group'];
 					}else{
 							die('need group id');
 					}
 					for($j=2;$j<=$sheet->getHighestRow();$j++){
 							$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 							$start_time = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 							$end_time = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
 							$price = zen_db_prepare_input($sheet->getCellByColumnAndRow(3,$j)->getValue());
 							if(!$price){
 								echo $model.' --- invalid price<br/>';
 								continue;
 							}
 							$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 							if($product_query->RecordCount()>0){
 								$check_exist = $db->Execute("select dailydeal_promotion_id from ".TABLE_DAILYDEAL_PROMOTION." where products_id=".$product_query->fields['products_id']);
 								if($check_exist->RecordCount()>0){
 									$db->Execute("delete from ".TABLE_DAILYDEAL_PROMOTION." where products_id=".$product_query->fields['products_id']);
 								}
 								
 									$daily_data = array(
 											'products_id'=>$product_query->fields['products_id'],
 											'dailydeal_products_start_date'=>$start_time,
 											'dailydeal_products_end_date'=>	$end_time,
 											'products_img'=>'dailydeal_promotion/products_image/'.$model.'.jpg',
 											'dailydeal_is_forbid'=>10, 	
 											'group_id'=>$group,
 											'dailydeal_price'=>round($price,2)
 												
 									);
 									remove_product_memcache($product_query->fields['products_id']);
 									zen_db_perform(TABLE_DAILYDEAL_PROMOTION, $daily_data);
 									$check_promotion = $db->Execute("delete from ".TABLE_PROMOTION_PRODUCTS." where pp_products_id=".$product_query->fields['products_id']);
 									$cnt++;
 								
 							}
 						}
 						echo $cnt;
 						break;
 	case 'remove_my_product':
 		$cnt=0;
 		for($j=2;$j<=$sheet->getHighestRow();$j++){
 			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 			if($product_query->fields['products_id']>0){
 				$db->Execute("delete from ".TABLE_MY_PRODUCTS." where products_id=".$product_query->fields['products_id']);
 				$db->Execute("update ".TABLE_PRODUCTS." set products_status=1 where products_id=".$product_query->fields['products_id']);
 				$cnt++;
 					
 			}
 		}
 		echo $cnt;
 		break;
 	case 'check_dora':
 		$cnt=0;
 		for($j=2;$j<=$sheet->getHighestRow();$j++){
 			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 			$product_query = $db->Execute("select products_id,products_status from ".TABLE_PRODUCTS." where products_model='".$model."'");
 			if($product_query->fields['products_id']>0 && $product_query->fields['products_status']>0){
 				//$db->Execute("update ".TABLE_PRODUCTS." set products_status=0 where products_id=".$product_query->fields['products_id']);
 				echo 'Y<br/>';	
 			}else{
 				//echo 'N<br/>';
 			}
 		}
 		
 		break;
 	case 'move_baby':
 			$cnt=0;
 			
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 				$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 				$categories = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 				$first = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
 				$second = zen_db_prepare_input($sheet->getCellByColumnAndRow(3,$j)->getValue());
 				$third = zen_db_prepare_input($sheet->getCellByColumnAndRow(4,$j)->getValue());
 				$old_cid = zen_db_prepare_input($sheet->getCellByColumnAndRow(5,$j)->getValue());
 				$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 				if($product_query->fields['products_id']>0&&$categories>0){
 					remove_product_memcache($product_query->fields['products_id']);
 					$db->Execute("update ".TABLE_PRODUCTS." set master_categories_id=".(int)$categories." where products_id=".$product_query->fields['products_id']);
 					
 					$db->Execute("delete from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$product_query->fields['products_id']." and categories_id= ".(int)$old_cid);
 					$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$product_query->fields['products_id']." and categories_id=".(int)$categories);
 					if($check_exist->RecordCount()==0){
 						$p2c_data = array(
 								'products_id'=>$product_query->fields['products_id'],
 								'categories_id'=>(int)$categories,
 								'first_categories_id'=>(int)$first,
 								'second_categories_id'=>(int)$second,
 								'three_categories_id'=>(int)$third
 		
 						);
 						zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $p2c_data);
 						$cnt++;
 		
 					}
 				}
 			}
 			echo $cnt;
 			break;
 	case 'move_featured':
 				$cnt=0;
 				 			
 				for($j=2;$j<=$sheet->getHighestRow();$j++){
 					$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 					$categories = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 					$first = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
 					$second = zen_db_prepare_input($sheet->getCellByColumnAndRow(3,$j)->getValue());
 					$third = zen_db_prepare_input($sheet->getCellByColumnAndRow(4,$j)->getValue());
 					$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 					if($product_query->fields['products_id']>0){
 						remove_product_memcache($product_query->fields['products_id']);
 						 						
 						$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$product_query->fields['products_id']." and categories_id=".(int)$categories);
 						if($check_exist->RecordCount()==0){
 							$p2c_data = array(
 									'products_id'=>$product_query->fields['products_id'],
 									'categories_id'=>(int)$categories,
 									'first_categories_id'=>(int)$first,
 									'second_categories_id'=>(int)$second,
 									'three_categories_id'=>(int)$third
 										
 							);
 							zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $p2c_data);
 							$cnt++;
 								
 						}
 					}
 				}
 				echo $cnt;
 				break;
 		case 'pid_list':
 				$cnt=0;
 				$list = '';
 				for($j=2;$j<=$sheet->getHighestRow();$j++){
 					$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 					$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 					if($product_query->fields['products_id']>0 ){
 						$stock_query = $db->Execute("select products_quantity from ".TABLE_PRODUCTS_STOCK." where products_id=".$product_query->fields['products_id']);
						if($stock_query->fields['products_quantity']<=0){
							echo 'Y<br/>';
						}else{
							echo 'N<br/>';
						}
 							//remove_product_memcache($product_query->fields['products_id']);
 						$cnt++;
 					}else{
 						echo 'N<br/>';
 					}
 				}
 				echo $cnt;
 				break;
 			case 'syn_country':
 					$cnt=0;
 					for($j=2;$j<=$sheet->getHighestRow();$j++){
 						$country_id = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 						$country_name = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 						$country_iso2 = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
 						$country_iso3 = zen_db_prepare_input($sheet->getCellByColumnAndRow(3,$j)->getValue());
 						$check_exist = $db->Execute("select countries_id from ".TABLE_COUNTRIES." where countries_iso_code_2='".$country_iso2."'");
 						if($check_exist->RecordCount()==0){
 							$sql_data = array(
 									'countries_id'=>$country_id,
 									'countries_name'=>$country_name,
 									'countries_iso_code_2'=>$country_iso2,
 									'countries_iso_code_3'=>$country_iso3
 							);
 							zen_db_perform(TABLE_COUNTRIES, $sql_data);
 							$cnt++;
 				
 						}
 					}
 					echo $cnt;
 					break;
 		case 'reopen_product':
 			$cnt=0;
 			
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 				$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 				
 				$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
 				if($product_query->fields['products_id']>0 ){
 					$db->Execute("update ".TABLE_PRODUCTS." set products_status=1 where products_id=".(int)$product_query->fields['products_id']);			
 					remove_product_memcache($product_query->fields['products_id']);
 					$cnt++;
 				}
 			}
 			echo $cnt;
 			break;
 		break;
 	case 'other_package_size':
 			$cnt=0;
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 				$model_main = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 				$model_other = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 				$type = 1;//s size
 				$main_product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model_main."'");
 				$other_product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model_other."'");
 		
 				if($main_product_query->fields['products_id']>0 && $other_product_query->fields['products_id']>0){
 					$check_exist = $db->Execute("select relation_id from ".TABLE_PRODUCTS_PACKAGE_RELATION." where main_product_id=".$main_product_query->fields['products_id']);
 					if($check_exist->RecordCount()==0){
 							
 						$sql_data = array(
 								'main_product_id'=>$main_product_query->fields['products_id'],
 								'other_size_product_id'=>$other_product_query->fields['products_id'],
 								'package_type'=>$type,
 								'date_added'=>date('Y-m-d H:i:s')
 						);
 						zen_db_perform(TABLE_PRODUCTS_PACKAGE_RELATION, $sql_data);
 							
 						$sql_data_2 = array(
 								'main_product_id'=>$other_product_query->fields['products_id'],
 								'other_size_product_id'=>$main_product_query->fields['products_id'],
 								'package_type'=>2, //main size
 								'date_added'=>date('Y-m-d H:i:s')
 						);
 						zen_db_perform(TABLE_PRODUCTS_PACKAGE_RELATION, $sql_data_2);
 						$cnt++;
 					}
 				}
 			}
 			echo $cnt;
 			break;
 	case 'update_name_en':
 			$cnt=0;
 			
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 				$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 				$name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 					
 				$pid_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."' limit 1");
 				if($model=='' || $pid_query->RecordCount()==0){
 					continue;
 				}
 				remove_product_memcache($pid_query->fields['products_id']);
 				if($name_en!=''){
 					$sql_data = array(
 							'products_name'=>$name_en
 					);
 					zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data,'update', "products_id='".$pid_query->fields['products_id']."' and language_id =1");
 					$cnt++;
 				}
 			}
 			echo $cnt;
 		break;
 		case 'remote_cne':
 			$cnt=0;
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 				$shipping_code = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 				$country_name = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 				$postcode_from = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());
 				$postcode_to= zen_db_prepare_input($sheet->getCellByColumnAndRow(3,$j)->getValue());
 				$city = zen_db_prepare_input($sheet->getCellByColumnAndRow(4,$j)->getValue());
 		
 				$city = strtoupper(preg_replace('/[\s-]/', '', $city));
 				$postcode_low = strtolower(str_replace(array('-',' '), array('',''), $postcode_from));
 				$postcode_high = strtolower(str_replace(array('-',' '), array('',''), $postcode_to));
 		
 				$country_query = $db->Execute("select countries_iso_code_2 from ".TABLE_COUNTRIES." where countries_name='".$country_name."'");
 				if($country_query->RecordCount()>0){
 					$remote_data = array(
 							'countries_iso_code_2'=>$country_query->fields['countries_iso_code_2'],
 							'postage'=>$postcode_from,
 							'trans_type'=>$shipping_code,
 							'city'=>$city,
 							'postcode_high'=>$postcode_to
 		
 					);
 					zen_db_perform(TABLE_REMOTE_ADDRESSES, $remote_data);
 					$cnt++;
 				}
 		
 		
 			}
 				
 			echo $cnt;
 			break;
 		case 'send_coupon':
 			$cnt=0;
 			for($j=2;$j<=$sheet->getHighestRow();$j++){
 				$email = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
 				$coupon_id = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
 				$customers_query = $db->Execute("select customers_id from ".TABLE_CUSTOMERS." where customers_email_address='".$email."'");
 				if($customers_query->RecordCount()>0){
 					$sql_data = array(
 						'cc_coupon_id'=>(int)$coupon_id,
 						'cc_customers_id'=>$customers_query->fields['customers_id']
 							
 					);
 					zen_db_perform(TABLE_COUPON_CUSTOMER, $sql_data);
 				}
 			
 			}
 			echo $cnt;
 			break;
	 case 'transaction':
 		$db->Execute("truncate t_products_transaction");
		$o = $db->Execute("select a.orders_id from t_orders a where a.date_purchased>='2015-04-01 00:00:00' order by a.orders_id limit 1");
		$sql = "select p.products_id from " . TABLE_PRODUCTS . " p order by p.products_id";
 		$products_query = $db->Execute($sql);
 		while(!$products_query->EOF){
			$t = $db->Execute("select count(op.products_id ) total from " . TABLE_ORDERS_PRODUCTS . " op where op.products_id ='".$products_query->fields['products_id']."' and op.orders_id>='".$o->fields['orders_id']."'");
			$sql_data_arr = array(
				'products_id'=>$products_query->fields['products_id'],
				'transaction_times'=>$t->fields['total']
			);
			zen_db_perform('t_products_transaction', $sql_data_arr);
 			$products_query->MoveNext();
 		}
 		break;
 	default:
 		echo 'Invalid action';
 		break;
 }	
  	
?>
