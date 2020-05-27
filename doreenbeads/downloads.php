<?php
  define('IS_ADMIN_FLAG', true);
  //正式站有两个配置文件，这里要用新配置文件
  require('includes/configure_new.php');
  require('includes/database_tables.php');
  require('includes/classes/class.base.php');
  require('includes/init_includes/init_database.php');
  require('includes/functions/functions_general.php');
  set_time_limit(1800);
  if (isset($_POST['selectson']) && $_POST['selectson'] != ''){
  	  $download_order_id = trim($_GET['order_id']);
  	  $sql_extra = ' and  op.products_id in(';
  	  for ($i=0, $n=sizeof($_POST['selectson']); $i<$n; $i++){
  	  	$sql_extra .= $_POST['selectson'][$i] . ', ';
  	  }
  	  $sql_extra = substr($sql_extra, 0, -2);
  	  $sql_extra .= ')';
	  zen_download_order_pic($download_order_id, true, $sql_extra);
  }else{
	  if (isset($_GET['product_id']) && $_GET['product_id'] != ''){
	  	$download_product_id = trim($_GET['product_id']);
	  	zen_download_order_pic($download_product_id, false);
	  } elseif (isset($_GET['order_id']) && $_GET['order_id'] != ''){
	  	$download_order_id = trim($_GET['order_id']);
	  	zen_download_order_pic($download_order_id);
	  }
  }
  
  function zen_download_order_pic($id, $lb_is_order = true, $sql_extra = ''){
  	global $db;
  	
  	$download_pic_dir = 'download/';
	$pic_array = array();
  	if ($lb_is_order == true){
  		$download_pic_query = "Select op.products_id, p.products_model, p.products_image From ".TABLE_ORDERS_PRODUCTS." op inner join ".TABLE_PRODUCTS." p on p.products_id=op.products_id Where op.orders_id = " . $id . $sql_extra;
		$download_pic = $db->Execute($download_pic_query);
		
  		$pic_str = '';
  		while(!$download_pic->EOF){
  			$pic_array[]=$download_pic->fields['products_image'];  			
	  		if ($sql_extra != ''){
	  			$pic_array = '';
	  			$download_pic_query1 = "Select products_model, products_image From " . TABLE_PRODUCTS . " Where products_id = " . $download_pic->fields['products_id'];
	  			$download_pic1 = $db->Execute($download_pic_query1);
	  			/*WSL*/
	  			$match_products_id_result = $db->Execute("select match_products_id from ".TABLE_PRODUCTS_MATCH_PROD_LIST." where products_id =".$download_pic->fields['products_id']);
	  			while (!$match_products_id_result->EOF){
	  				$match_products_model = $db->Execute("select products_model, products_image from ".TABLE_PRODUCTS." where products_id =".$match_products_id_result->fields['match_products_id'])->fields['products_model'];
	  				$match_products_model_arr[] = $match_products_model;
	  				$match_products_id_result->MoveNext();
	  			}
  				$product_model = $download_pic1->fields['products_image'];
  				$pic = $match_products_model_arr;
  				/*end*/
  				
  				//$matchlist = $download_pic1->fields['match_prod_list'];
		  		/* if(trim($matchlist)){
		  			$pic = @explode(',',$matchlist);		
		  		} */
		  		if(!in_array($product_model,$pic)){
		  			$pic[]= $product_model;
		  		}
		  		$pic_arr[] = $pic;
	  		} 		
  			$download_pic->MoveNext();
  		}
  		if ($pic_array == ''){
  			foreach ($pic_arr as $val){
  				foreach ($val as $pic){
  					$pic_array[] = $pic;
  				}  				
  			}
  		}
		
//  		while(!$download_pic->EOF){
//  			$pic_array[]=$download_pic->fields['products_model'];
//  			$download_pic->MoveNext();
//			}
  	} else {
  		$download_pic_query = "Select products_id,products_model, products_image From " . TABLE_PRODUCTS . " Where products_id = " . (int)$id;
		$download_pic = $db->Execute($download_pic_query);
		/*WSL*/
		$match_products_id_result = $db->Execute("select match_products_id from ".TABLE_PRODUCTS_MATCH_PROD_LIST." where products_id =".$download_pic->fields['products_id']);
		while (!$match_products_id_result->EOF){
			$match_products_model = $db->Execute("select products_model, products_image from ".TABLE_PRODUCTS." where products_id =".$match_products_id_result->fields['match_products_id'])->fields['products_model'];
			$match_products_model_arr[] = $match_products_model;
			$match_products_id_result->MoveNext();
		}
		
  		//$matchlist = $download_pic->fields['match_prod_list'];
  		$product_model = $download_pic->fields['products_image'];
  		$pic_array = $match_products_model_arr;
  		
  		/* if(trim($matchlist)){
  			$pic_array = @explode(',',$matchlist);		
  		} */
  		if(!in_array($product_model,$pic_array)){
  		
		$pic_array[]= $product_model;
  		}
  		//var_dump($pic_array);exit;
  	}
  	
  	if ($lb_is_order == true){
  		$zip_file_name = 'Dorabeads-Order-[' . $id . '].zip';
  		$new_folder_name = 'Dorabeads-Order-[' . $id . ']';
  		if ($sql_extra != ''){
  			$zip_file_name = 'Dorabeads-Order-[' . $id . ']-Selected.zip';
  			$new_folder_name = 'Dorabeads-Order-[' . $id . ']-Selected';
  		}
  	} else {
  		$zip_file_name = 'DoraBeads-Product-' . substr($download_pic->fields['products_model'], 0, 1) . substr($download_pic->fields['products_model'], -5) . '.zip';
  		$new_folder_name = 'DoraBeads-Product-' . substr($download_pic->fields['products_model'], 0, 1) . substr($download_pic->fields['products_model'], -5);
  	}
  	
  	mkdir($new_folder_name, 0777);
  	$new_folder_dir = $new_folder_name;
  	
  	$character_array = array('A', 'B', 'C', 'D', 'E', 'F');
  	$zip_file_array = array();
  	foreach ($pic_array as $download_pic_model){
  		/*
  		if(substr($download_pic_model, -1)=='S' || substr($download_pic_model, -1)=='H'){
  			$download_pic_model  = substr($download_pic_model, 0, -1);
  		}
		$first_letter = strtolower(substr($download_pic_model, 0, 1));
		switch($first_letter){
			case '8' : $pic_folder_num = 'knitting'; break;
			case 'w' : $pic_folder_num = 'tattoo'; break;
			case 'a' :
			case 'b' : $pic_folder_num = ((int)substr($download_pic_model, 1, 2) + 1); break;
			case 'c' :			
			case 'e' : 
			case 'f' :
			case 'g' : 
			case 'j' :
			case 'k' :
			case 'p' :
			case 'q' :
			case 's' :
			case 'z' : $pic_folder_num = substr($download_pic_model, 0, 3); 
			break;
			case 'h' :
			$pic_folder_num = 'H';
			break;
			default : $pic_folder_num = ceil(((int)substr($download_pic_model, -5)) / 1000);
		}		
		//echo $pic_folder_num.'<br>';
//  		$pic_folder_num = ceil(((int)substr($download_pic_model, -5)) / 1000);
  		
  		$character_cnt = 0;
  		while ($character_cnt < sizeof($character_array)){
  			$download_pic_name = $download_pic_model . $character_array[$character_cnt] . '.jpg';
  			//echo $download_pic_dir . $pic_folder_num . '/' . $download_pic_name.'<br>';
  			if (file_exists($download_pic_dir . $pic_folder_num . '/' . $download_pic_name)){
  				copy($download_pic_dir . $pic_folder_num . '/' . $download_pic_name, $new_folder_dir . '/' . $download_pic_name);
  				$zip_file_array[] = $new_folder_dir . '/' . $download_pic_name;
  			}
  			$character_cnt++;
  		}
  		*/
  		foreach($character_array as $character_value) {
			//注意800055-7.4货号，所以要用.JPG
			$download_pic_name = strchr($download_pic_model, ".JPG", true) . $character_value . ".jpg";
			$download_pic_name_lower = strchr($download_pic_model, ".jpg", true) . $character_value . ".jpg";
			if(!file_exists($download_pic_dir . $download_pic_name) && file_exists($download_pic_dir . $download_pic_name_lower)) {
				$download_pic_name = $download_pic_name_lower;
			}
			$download_pic_name_new = strrchr($download_pic_name, "/");
			if (file_exists($download_pic_dir . $download_pic_name) || file_exists(strtolower($download_pic_dir . $download_pic_name))){
  				copy($download_pic_dir . $download_pic_name, $new_folder_dir . $download_pic_name_new);
  				$zip_file_array[] = $new_folder_dir . $download_pic_name_new;
  			}
  			/*else{
  				if (file_exists($download_pic_dir . 'knitting/' . $download_pic_name) || file_exists(strtolower($download_pic_dir . 'knitting/' . $download_pic_name))) {
  					copy($download_pic_dir . 'knitting/' . $download_pic_name, $new_folder_dir . '/' . $download_pic_name);
  					$zip_file_array[] = $new_folder_dir . '/' . $download_pic_name;
				}
  			}
  			*/
		}
  		
  	}
  	
  	if (sizeof($zip_file_array) > 0){
  		set_time_limit(0);
		ini_set('memory_limit', '512M');
  		zen_create_zip($zip_file_array, $zip_file_name, true);
  		if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
  			header('Content-type: application/octetstream');
  			header('Content-Disposition: attachment; filename=' . $zip_file_name);
  		} else {
  			header('Content-Type: application/x-octet-stream');
			header('Content-Disposition: attachment; filename=' . $zip_file_name);
  		}
  		ob_end_clean();
  		readfile($zip_file_name);
  		unlink($zip_file_name);
  	}
  	
  	zen_delete_file($new_folder_dir . '/');
  	rmdir($new_folder_dir);
  }

  function zen_create_zip($file_array = array(), $destination = '', $overwrite = false){
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
			$zip->addFile($zip_file, $zip_file);
		}
		
		$zip->close();
		return file_exists($destination);
  	} else {
  		return false;
  	}
  }
  
  function zen_delete_file($dir){
  	if ($delete_dir = @dir($dir)){
  		while ($delete_file = $delete_dir->read()){
  			if (substr($delete_file, -1) != '.') unlink($dir . $delete_file);
  		}
  		
  		$delete_dir->close();
  	}
  }
?>