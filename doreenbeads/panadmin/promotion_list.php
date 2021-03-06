<?php
  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'language.php');
  
  function outputXlsHeader($data,$file_name = 'export')
  {
  	ob_end_clean();
  	header('Content-Type: text/xls');
  	header ( "Content-type:application/vnd.ms-excel;charset=utf-8" );
  	$str = mb_convert_encoding($file_name, 'gbk', 'utf-8');
  	header('Content-Disposition: attachment;filename="' .$str . '.xls"');
  	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
  	header('Expires:0');
  	header('Pragma:public');
  	$encode = mb_detect_encoding($data, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
	$data = mb_convert_encoding($data, $encode, 'utf-8');
  
  	echo $data;
  	die();
  }
  
  
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $promotion_types = array(0=>"",1=>"正常促销",2=>"DEALS活动");
  $promotion_types_arr = array(array('id' => 0 , 'text' =>'请选择...') , array('id' => 1 , 'text' => '正常促销') , array('id' => 2 , 'text' => 'Deals促销'));
  $status_arr = array(array('id' => 0 , 'text' =>'请选择...') , array('id' => 1 , 'text' => '未开始') , array('id' => 2 , 'text' => '活动') , array('id' => 3 , 'text' => '已结束'));
    
  if(zen_not_null($action)){
  	switch ($action) {
//   		case 'delete':
//   			$pid = zen_db_prepare_input($_GET['pID']);		 			  			
//   			$db->Execute("delete from " . TABLE_PROMOTION . " where promotion_id = '" . (int)$pid . "'");
//   			$db->Execute("delete from " . TABLE_PROMOTION_DESCRIPTION . " where pd_id = '" . (int)$pid . "'");
//   			$db->Execute("delete from " . TABLE_PROMOTION_PRODUCTS . " where pp_promotion_id = '" . (int)$pid . "'");
//   			zen_redirect(zen_href_link(FILENAME_PROMOTION_LIST, 'page=' . $_GET['page']));
//   			break;
  		case 'clear_product':
  			$pid = zen_db_prepare_input($_GET['pID']); 
  			$admin_email = $_SESSION['admin_email'];
  			
  			$promotion_products = $db->Execute('select pp_products_id from ' . TABLE_PROMOTION_PRODUCTS . ' where pp_promotion_id = ' . $pid . ' and pp_is_forbid = 10');
  			$products_count = $promotion_products->RecordCount();
  			$promotion_date = $db->Execute('select promotion_start_time , promotion_end_time from ' . TABLE_PROMOTION . ' where promotion_id = ' . $pid);
  			$start_time = $promotion_date->fields['promotion_start_time'];
  			$end_time = $promotion_date->fields['promotion_end_time'];
  			$current_datetime = date("Y-m-d H:i:s");
  				
  			if ($current_datetime < $start_time && $products_count > 0){
  				while (!$promotion_products->EOF){
  					$forbid_products_sql = "delete from " . TABLE_PROMOTION_PRODUCTS . " where pp_promotion_id = '" . (int)$pid . "' AND pp_products_id = " . $promotion_products->fields['pp_products_id'] . " and pp_is_forbid = 10";
  				
  					$db->Execute($forbid_products_sql);
  					remove_product_memcache($promotion_products->fields['pp_products_id'] );
  					$promotion_products->MoveNext();
  				}
  			}else if($current_datetime >= $start_time && $current_datetime <= $end_time && $products_count > 0){
  				while (!$promotion_products->EOF){
  					$forbid_products_sql = "update " . TABLE_PROMOTION_PRODUCTS . " set pp_is_forbid = 20 , pp_forbid_admin ='" . $admin_email . "' , pp_forbid_time = '" . $current_datetime . "' where pp_promotion_id = '" . (int)$pid . "' AND pp_products_id = " . $promotion_products->fields['pp_products_id'] . " and pp_is_forbid = 10";
  				
  					$db->Execute($forbid_products_sql);
  					remove_product_memcache($promotion_products->fields['pp_products_id'] );
  					
  					$promotion_products->MoveNext();
  				}
  				$db->Execute('update ' . TABLE_PROMOTION . ' SET promotion_modify_operator = "' . $admin_email . '" , promotion_modify_time = "' . $current_datetime .'" where promotion_id = ' . $pid);
  			}
  			
  			$messageStack->add_session('Success: 成功清空促销折扣区ID为 '.$pid.'的产品!','success');	
  			zen_redirect(zen_href_link(FILENAME_PROMOTION_LIST, '&pID='.$pid.'&page=' . (isset($_GET['page'])?$_GET['page']:"1")));
  			break;
  		case 'upload':
  			$file=$_FILES['promotionFile'];
  			$pre_url = $_POST['pre_url'];
  			
  			if($file['error']||empty($file)){
  				$messageStack->add_session('Fail: 要设置促销折扣区商品对应的文件不能为空'.$file['name'],'error');
  				zen_redirect(zen_href_link(FILENAME_PROMOTION_LIST));
  			}
  			$filename = basename($file['name']);
  			$file_ext = substr($filename, strrpos($filename, '.') + 1);
  			if($file_ext!='xlsx'&&$file_ext!='xls'){
  				$messageStack->add_session('Fail: 文件格式有误，请上传xlsx或者xls格式的文件','error');
  				zen_redirect(zen_href_link(FILENAME_PROMOTION_LIST));
  			}else{
  				set_time_limit(0);
  				$messageStack->add_session('Success: File Upload saved successfully '.$file['name'],'success');				
  				$error_info_array=array();
  				$promotion_products_arr = array();
  				$dailydeal_products_arr = array();
  				$file_from=$file['tmp_name'];
  				$update_all=false;
  				$success_num = 0;
  				if($_GET['area']=='all'){
  					$update_all=true;
  				}
  				set_include_path('../Classes/'); 				
  				include 'PHPExcel.php';
  				if($file_ext=='xlsx'){		
  					 include 'PHPExcel/Reader/Excel2007.php';
  					 $objReader = new PHPExcel_Reader_Excel2007;
  				}else{
  					include 'PHPExcel/Reader/Excel5.php';
  					$objReader = new PHPExcel_Reader_Excel5;
  				}
  				$objPHPExcel = $objReader->load($file_from);
  				$sheet = $objPHPExcel->getActiveSheet();
  				for($j=2;$j<=$sheet->getHighestRow();$j++){
  					$update_error=false;
  					$a1=$sheet->getCellByColumnAndRow(0,$j)->getValue();
  					$b1=intval($sheet->getCellByColumnAndRow(1,$j)->getValue());
  					$c1=intval($sheet->getCellByColumnAndRow(2,$j)->getValue());
  					$d1=intval($sheet->getCellByColumnAndRow(3,$j)->getValue());
  								
  					if(trim($a1)==''){
  						$update_error = true;
  						$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号不能为空。';
  					}else{
  						if($d1 == 1){
  							$sale_while_stock_lasts = 10;
  						}elseif($d1 == 0){
  							$sale_while_stock_lasts = 20;
  						}else{
  							$error_info_array[] = zend_format("第  <b>'.$j.'</b> 行 商品“售完即止”数据有误。");
  							continue;
  						}
  						
  						$select = $db->Execute('select products_id , products_quantity_order_min , products_status, products_limit_stock from  ' . TABLE_PRODUCTS . ' where products_model= "'.$a1.'" order by products_status asc limit 1');
  						$products_limit_stock = $select->fields['products_limit_stock'];
  						$pid = $select->fields['products_id'];
  						if(!empty($select->fields['products_limit_stock'])) {
	  						$c1 = 0;
	  					}
	  					
  						if($select->RecordCount() > 0 && $pid != '' && $pid != 0){
  							if($select->fields['products_status'] != 1){
  								$update_error=true;
  								if($select->fields['products_status'] == 10){
  									$error_info_array[]='第  <b>'.$j.'</b> 行数据商品编号【' . $a1 . '】已删除，不能导入。';
  								}else{
  									$error_info_array[]='第  <b>'.$j.'</b> 行数据商品编号【' . $a1 . '】已下架，不能导入。';
  								}
  							}else{
  								$check_my_products = $db->Execute("select products_id from " . TABLE_MY_PRODUCTS . " where products_id=" . $pid);
  								if($check_my_products->RecordCount() > 0 ){
  									$error_info_array[] = "第<b>".$j."</b>行数据商品编号【" . $a1 . "】对应的商品已下架，不能导入";
  								}else{
		  							if(trim($b1)==''){
		  								$update_error=true;
		  								$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，促销编号栏为必填项。';
		  							}else{
		  								$check_promotion=$db->Execute('select promotion_id, promotion_start_time , promotion_end_time , promotion_status from  '.TABLE_PROMOTION.' where promotion_id="'.$b1.'" limit 1');
		  								if($check_promotion->RecordCount()>0){
		  									$current_datetime = date("Y-m-d H:i:s");
		  									if($check_promotion->fields['promotion_status'] != 0  && $check_promotion->fields['promotion_end_time'] > $current_datetime){
			  									if(!$update_error){
			  										$have_exist = false;
			  										$promotion_start_time = (strtotime($check_promotion->fields['promotion_start_time']) < strtotime($current_datetime)) ? $current_datetime : $check_promotion->fields['promotion_start_time'];
			  										$promotion_end_time = $check_promotion->fields['promotion_end_time'];
			  										
			  										if(!array_key_exists($b1 ,  $promotion_products_arr)){
				  										$no_overlapping_promotion_sql = 'SELECT pp_products_id FROM '. TABLE_PROMOTION_PRODUCTS . ' zpp inner join ' . TABLE_PROMOTION . ' zp on zpp.pp_promotion_id = zp.promotion_id
																							WHERE (
																								(
																									pp_promotion_start_time <= "' . $promotion_start_time . '"
																									AND pp_promotion_end_time >= "' . $promotion_end_time . '"
																								)
																							or (
																								pp_promotion_start_time >= "' . $promotion_start_time . '"
																								AND pp_promotion_start_time <= "' . $promotion_end_time . '"
																							)
																							or (
																								pp_promotion_end_time >= "' . $promotion_start_time . '"
																								AND pp_promotion_end_time <= "' . $promotion_end_time . '"
																							) ) and zp.promotion_status = 1 and zpp.pp_is_forbid = 10';
				  										$no_overlapping_promotion = $db->Execute($no_overlapping_promotion_sql);
				  										
				  										if($no_overlapping_promotion->RecordCount() > 0){
				  											while(!$no_overlapping_promotion->EOF){
					  											$products_id = zen_db_input($no_overlapping_promotion->fields['pp_products_id']);
					  											$products_arr[] = $products_id;
					  													
					  											$no_overlapping_promotion->MoveNext();
				  											}
				  										}
			  											$promotion_products_arr[$b1] = $products_arr;
			  											
			  											if(in_array($pid, $products_arr)){
			  												$have_exist = true;
			  											}
			  										}else{
				  										if(in_array($pid, $promotion_products_arr[$b1])){
				  											$have_exist = true;
				  										}
				  									}
				  									
			  										if($have_exist == false){
			  											if(!array_key_exists($b1, $dailydeal_products_arr)){
			  												$dailydeal_products_sql = 'SELECT products_id FROM ' . TABLE_DAILYDEAL_PROMOTION . ' dp INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on dp.area_id = zda.dailydeal_area_id 
			  																			WHERE (
																							(
																								dailydeal_products_start_date <= "' . $promotion_start_time . '"
																								AND dailydeal_products_end_date >= "' . $promotion_end_time . '"
																							)
																						or (
																							dailydeal_products_start_date >= "' . $promotion_start_time . '"
																						    and dailydeal_products_start_date <= "' . $promotion_end_time . '"
																						)
																						or (
																							dailydeal_products_end_date >= "' . $promotion_start_time . '"
																							AND dailydeal_products_end_date <= "' . $promotion_end_time . '"
																						) ) AND dailydeal_is_forbid = 10 and zda.area_status = 1';
				  											$dailydeal_products_query = $db->Execute($dailydeal_products_sql);
				  											
				  											if($dailydeal_products_query->RecordCount() > 0){
				  												while (!$dailydeal_products_query->EOF){
				  													$dl_products_id = zen_db_input($dailydeal_products_query->fields['products_id']);
				  													$dl_products_arr[] = $dl_products_id;
				  													
				  													$dailydeal_products_query->MoveNext();
				  												}
				  												$dailydeal_products_arr[$b1] = $dl_products_arr;
				  												
				  												if(in_array($pid, $dl_products_arr)){
				  													$have_exist = true;
				  												}
				  											}
			  											}else{
				  											if(in_array($pid, $dailydeal_products_arr[$b1])){
				  												$have_exist = true;
				  											}
				  										}
			  										}
			  										
			  										if(!$have_exist){
				 										$check_stock = $db->Execute("select products_quantity from ".TABLE_PRODUCTS_STOCK." where products_id=".$pid);
				 										// (!$products_limit_stock  && $check_stock->fields['products_quantity'] ==0) ---->backorder 也可以添加到折扣区 cm add
				 										if($check_stock->fields['products_quantity']>0 || (!$products_limit_stock  && $check_stock->fields['products_quantity'] ==0)){
				 					 						$promotion_data = array(
				 												'pp_products_id'=>$pid,
				 												'pp_promotion_id'=>(int)$b1,
				 					 							'pp_promotion_start_time' => $promotion_start_time,
				 					 							'pp_promotion_end_time' => $promotion_end_time,
                                                                'pp_max_num_per_order' => $c1,
				 					 							'sale_while_stock_lasts' => $sale_while_stock_lasts
				 											);
				 											zen_db_perform(TABLE_PROMOTION_PRODUCTS, $promotion_data);
				 											remove_product_memcache($pid);
				 											$success_num++;
				 										}else{
				 											$update_error=true;
				 											$error_info_array[]='第  <b>'.$j.'</b> 该商品编号【' . $a1 . '】库存不足。';
				 										}
			  										}else{
			  											$update_error=true;
			  											$error_info_array[]='第  <b>'.$j.'</b> 行数据商品编号【' . $a1 . '】已有其它优惠信息，不能导入。';
			  										}
			  									}
		  									}else{
		  										$update_error=true;
		  										$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，该折扣区已结束。';
		  									}
		  								}else{
		  									$update_error=true;
		  									$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，该折扣区 编号不存在。';
		  								}
		  							}
  								}
  							}
  						}else{
  							$update_error=true;
  							$error_info_array[]='第  <b>'.$j.'</b> 行数据有误，商品编号【' . $a1 . '】不存在。';
  						}
  					}
  				}
  			}
  			if(sizeof($error_info_array)>=1){
  				$messageStack->add_session($success_num . ' 件商品信息导入成功，对应商品在相应时间内以折扣价出售。','caution');
  				foreach($error_info_array as $val){
  					$messageStack->add_session($val,'error');
  				}
  				zen_redirect($pre_url);
  			}else{
  				$messageStack->add_session('所有商品导入成功','success');
  				zen_redirect($pre_url);
  			}
  			exit;
  			break;
  		case 'set':
  			$pDateStart=$_POST['datestart'];
  			$pDateEnd=$_POST['dateend'];
  			$pTimeEnd=$_POST['timeend'];
  			$pTimeStart=$_POST['timestart'];
  			$pStatus=$_POST['status'];
  			$db->Execute('update '.TABLE_CONFIGURATION.' set configuration_value="'.$pStatus.'" where configuration_key="SHOW_PROMOTION_AREA_STATUS" ');
  			$db->Execute('update '.TABLE_CONFIGURATION.' set configuration_value="'.($pDateStart.' '.$pTimeStart).'" where configuration_key="SHOW_PROMOTION_AREA_START_TIME" ');
  			$db->Execute('update '.TABLE_CONFIGURATION.' set configuration_value="'.($pDateEnd.' '.$pTimeEnd).'" where configuration_key="SHOW_PROMOTION_AREA_END_TIME" ');
  			echo zen_href_link(FILENAME_PROMOTION_LIST);
  			exit;
  			break;
  		case 'set_navigation':
  			$status = $_POST['promotion_status_display'];
  			$languageArr = explode(",", $_POST['language_codes']);
  			if($status == '1') {
  				$languages = ",";
	  			foreach($languageArr as $code) {
	  				if(isset($_POST['navigation_' . $code])) {
	  					$languages .= $code . ",";
	  				}	
	  			}
  			} else {
  				$languages = $_POST['languages_old'];
  			}
  			
  			$updateInfo = json_encode(array('status' => $status, 'languages' => $languages));
  			$db->Execute('update '.TABLE_CONFIGURATION.' set configuration_value="'.addslashes($updateInfo).'" where configuration_key="SHOW_PROMOTION_AREA_NAVIGATION" ');
  			zen_redirect(zen_href_link(FILENAME_PROMOTION_LIST));
  			exit;
  			break;
  		case 'update':
  		case 'insert':
  			$pid=$_POST['pid'];
  			$pName=$_POST['pName'];
  			$pDateStart=$_POST['datestart'];
  			$pDateEnd=$_POST['dateend'];
  			$pTimeEnd=$_POST['timeend'];
  			$pTimeStart=$_POST['timestart'];
  			$pDiscount=$_POST['discount'];
  			$pStatus=$_POST['status'];
  			$pType=$_POST['pType'];
  			$page=$_POST['page'];
  			
  			$promotion_data_array = array('promotion_discount' => zen_db_prepare_input((float)$pDiscount),
  					'promotion_start_time' => zen_db_prepare_input($pDateStart.' '.$pTimeStart),
  					'promotion_end_time' => zen_db_prepare_input($pDateEnd.' '.$pTimeEnd),
  					'promotion_status' => zen_db_prepare_input((int)$pStatus));
  			if($action=='insert'){
  				$promotion_data_array["promotion_type"] = isset($pType) ? intval($pType): 1;
  				
  				zen_db_perform(TABLE_PROMOTION, $promotion_data_array, 'insert');
  				$iId=$db->insert_ID();
  			}else{
  				zen_db_perform(TABLE_PROMOTION, $promotion_data_array, 'update', "promotion_id = '" . zen_db_input($pid) . "'");
  			}
  			foreach($pName as $key=>$val){
  				if($action=='insert'){
  				$promotion_des_data_array = array('pd_languages_id' => zen_db_prepare_input(($key+1)),
  					'pd_name' => zen_db_prepare_input($val),
  					'pd_id'=>$iId);
  				zen_db_perform(TABLE_PROMOTION_DESCRIPTION,$promotion_des_data_array, 'insert');
  				}else{
  					$db->Execute('update '.TABLE_PROMOTION_DESCRIPTION.' set  pd_name="'.$val.'" where  pd_id="'.zen_db_input($pid).'" and pd_languages_id='.($key+1).' ');
  				}
  			}
  			if($action=='insert'){
  				echo zen_href_link(FILENAME_PROMOTION_LIST);
  			}else{
  				echo zen_href_link(FILENAME_PROMOTION_LIST,'pID='.$pid.'&page='.$page);
  			}			
  			exit;
  			break;
  		case 'save': 
  			$stage = $_POST['stage'];
  			$pid=$_POST['pId'];
  			$page=$_POST['page'];
  			$pDateEnd=$_POST['pEndTime'];
  			$admin_email = $_SESSION['admin_email'];
  			$operate_time = date('Y-m-d H:i:s');
  				
  			if($stage == 'ready'){
	  			$saveType=$_POST['save_type'];
	  			$actionType = "insert";
	  			$extre_array = array();
	  			
	  			if($saveType == 'edit')
	  			{
	  				$actionType = "update";
	  			}
	  			
	  			$pType=$_POST['pType'];
	  			$pDiscount=$_POST['pDiscount']; 
	  			$pDateStart=$_POST['pStartTime'];
	  			$pName = $_POST['pName'];
	  				
	  			$promotion_data_array = array( 
	  					'promotion_name'=>zen_db_prepare_input($pName),
	  					'promotion_type'=>isset($pType) ? intval($pType): 1,
	  					'promotion_discount' => zen_db_prepare_input((float)$pDiscount),
	  					'promotion_start_time' => zen_db_prepare_input($pDateStart),
	  					'promotion_end_time' => zen_db_prepare_input($pDateEnd),
	  					'promotion_status' => 1
	  			);
	  			
	  			if($actionType == "update"){
	  				$extre_array = array(
	  						'promotion_modify_time' => $operate_time,
	  						'promotion_modify_operator' => $admin_email
	  				);
	  			}else{
	  				$extre_array = array(
	  						'promotion_create_time' => $operate_time,
	  						'promotion_create_operator' => $admin_email
	  				);
	  			}
	  			
	  			$promotion_data_array = array_merge($promotion_data_array, $extre_array);
	
	  			if($actionType=='insert'){ 
	  				zen_db_perform(TABLE_PROMOTION, $promotion_data_array, $actionType);
	  				$pid=$db->insert_ID();
	  				
	  				zen_redirect(zen_href_link(FILENAME_PROMOTION_LIST));
	  			}else{
		  			zen_db_perform(TABLE_PROMOTION, $promotion_data_array, 'update',"promotion_id = " . $pid . "");
		  			
		  			$promotion_products_info = array(
		  					'pp_promotion_start_time' => zen_db_prepare_input($pDateStart),
		  					'pp_promotion_end_time' => zen_db_prepare_input($pDateEnd)
		  			);
		  			
		  			zen_db_perform(TABLE_PROMOTION_PRODUCTS, $promotion_products_info, 'update', "pp_promotion_id = " . $pid);
		  					
		  			zen_redirect(zen_href_link(FILENAME_PROMOTION_LIST,'pID='.$pid.'&page='.$page));
		  		}
  			}else{
  				$check_promotion_original_end_time_query = $db->Execute('select promotion_end_time from ' . TABLE_PROMOTION . ' where promotion_id = ' . $pid);
  				$check_promotion_original_end_time = $check_promotion_original_end_time_query->fields['promotion_end_time'];
  				
  				if (strtotime($check_promotion_original_end_time) != strtotime(zen_db_prepare_input($pDateEnd))){
	  				$promotion_data_array = array(
	  					'promotion_end_time' => zen_db_prepare_input($pDateEnd),
	  					'promotion_modify_time' => $operate_time,
	  					'promotion_modify_operator' => $admin_email
	  				);
  				
	  				zen_db_perform(TABLE_PROMOTION, $promotion_data_array, 'update',"promotion_id = " . $pid . "");
	  				
	  				$promotion_products_info = array(
	  						'pp_promotion_end_time' => zen_db_prepare_input($pDateEnd)
	  				);
	  					
	  				zen_db_perform(TABLE_PROMOTION_PRODUCTS, $promotion_products_info, 'update', "pp_promotion_id = " . $pid);
	  				
  					$operating_log_content = 'ID为#' . $pid . '# 的促销区促销结束时间由' . $check_promotion_original_end_time . '改为' . zen_db_prepare_input($pDateEnd);
  					zen_insert_operate_logs($_SESSION['admin_id'],$pid,$operating_log_content,10);
  				}
  				
  				zen_redirect(zen_href_link(FILENAME_PROMOTION_LIST,'pID='.$pid.'&page='.$page));
  			}
  			exit;
  			break;
  		case 'forbid':
  			$pid = zen_db_input($_GET['pID']);
  			$admin_email = zen_db_input($_SESSION['admin_email']);
  			if($pid != ''){
  				$forbid_area_sql = 'update ' . TABLE_PROMOTION . ' SET promotion_status = 0 where promotion_id = ' . $pid;
  				$db->Execute($forbid_area_sql);
  				
	  			$promotion_products = $db->Execute('select pp_products_id from ' . TABLE_PROMOTION_PRODUCTS . ' where pp_promotion_id = ' . $pid . ' and pp_is_forbid = 10');
	  			$products_count = $promotion_products->RecordCount();
	  			$promotion_date = $db->Execute('select promotion_start_time , promotion_end_time from ' . TABLE_PROMOTION . ' where promotion_id = ' . $pid);
	  			$start_time = $promotion_date->fields['promotion_start_time'];
	  			$end_time = $promotion_date->fields['promotion_end_time'];
	  			$current_datetime = date("Y-m-d H:i:s");
	  				
	  			if ($current_datetime < $start_time && $products_count > 0){
	  				while (!$promotion_products->EOF){
	  					$forbid_products_sql = "delete from " . TABLE_PROMOTION_PRODUCTS . " where pp_promotion_id = '" . (int)$pid . "' AND pp_products_id = " . $promotion_products->fields['pp_products_id'] . " and pp_is_forbid = 10";
	  				
	  					$db->Execute($forbid_products_sql);
	  					remove_product_memcache($promotion_products->fields['pp_products_id'] );
	  					$promotion_products->MoveNext();
	  				}
	  			}else if($current_datetime >= $start_time && $current_datetime <= $end_time && $products_count > 0){
	  				while (!$promotion_products->EOF){
	  					$forbid_products_sql = "update " . TABLE_PROMOTION_PRODUCTS . " set pp_is_forbid = 20 , pp_forbid_admin ='" . $admin_email . "' , pp_forbid_time = '" . $current_datetime . "' where pp_promotion_id = '" . (int)$pid . "' AND pp_products_id = " . $promotion_products->fields['pp_products_id'] . " and pp_is_forbid = 10";
	  				
	  					$db->Execute($forbid_products_sql);
	  					remove_product_memcache($promotion_products->fields['pp_products_id'] );
	  					
	  					$promotion_products->MoveNext();
	  				}
	  			}
	  			$db->Execute('update ' . TABLE_PROMOTION . ' SET promotion_modify_operator = "' . $admin_email . '" , promotion_modify_time = "' . $current_datetime .'" where promotion_id = ' . $pid);
  				
  			}
  			
  			zen_redirect(zen_href_link(FILENAME_PROMOTION_LIST, zen_get_all_get_params(array('action' , 'type' , 'status' , 'pName' , 'x' , 'y'))));
  			break;
  		case 'export':
  			$promotion_id_array = $_POST['promotion_id'];
  			if(sizeof($promotion_id_array) > 0){
	  			$promotion_id = implode(',' ,$promotion_id_array);
	  					
	  			if($promotion_id != '' ){
	  				$search_sql = 'SELECT zpt.products_model , zp.promotion_id, zp.promotion_discount , zpp.pp_promotion_start_time , zpp.pp_promotion_end_time , zp.promotion_type ,zpp.pp_is_forbid , zpp.pp_forbid_time from (' . TABLE_PROMOTION_PRODUCTS . ' zpp INNER JOIN ' . TABLE_PROMOTION . ' zp on zp.promotion_id = zpp.pp_promotion_id) INNER JOIN ' . TABLE_PRODUCTS . ' zpt on zpt.products_id = zpp.pp_products_id where  zp.promotion_id in (' . $promotion_id . ')';
	  				$products_query = $db->Execute($search_sql);
	  				$str = '<table border="1" valign="top" style="font-size:15px;width:600px;text-align: center;border-spacing: 0px;">
					<tr  style="background-color: #fff;height: 40px;">
						<th>商品编号</th>
	  					<th>促销区编号</th>
						<th>折扣</th>
						<th>开始时间</th>
						<th>结束时间</th>
						<th>应用场景</th>
					</tr>';
	  						
	  			if($products_query->RecordCount() > 0){
	  				while (!$products_query->EOF){
	  					$str.='<tr  style="background-color: #fff;height: 40px;">
								<td>' . $products_query->fields['products_model'] . '</td>
								<td>' . $products_query->fields['promotion_id'] . '</td>
								<td>' . $products_query->fields['promotion_discount'] . '%</td>
								<td>' . $products_query->fields['pp_promotion_start_time']  . '</td>
								<td>' . ($products_query->fields['pp_is_forbid'] == 10 ?  $products_query->fields['pp_promotion_end_time'] : $products_query->fields['pp_forbid_time'])   . '</td>
								<td>' . ($products_query->fields['promotion_type'] == 1 ? '正常促销' : 'Deals促销' ) . '</td>
							</tr>';
	  								
	  					$products_query->MoveNext();
	  				}
	  			}
	  			$str.= '</table>';
	  			$promotion_id = str_replace(',' , '_' , $promotion_id);
	  			outputXlsHeader($str,"促销区_ " . $promotion_id . '_商品' .date("Ymd"));
	  						
	  		}
  		}
  		exit;
  		break;
  		case 'search':
  			$type = zen_db_input($_GET['type']);
  			$status = zen_db_input($_GET['status']);
  			$search_key = zen_db_input($_GET['pName']);
  			
  			if($type != 0){
  				if($search_condition == ''){
  					$search_condition .= ' where zp.promotion_type =' . $type;
  				}
  			}
  			
  			if($status != 0){
  				if($search_condition == ''){
  					if($status == 1){
  						$search_condition .= ' where ( zp.promotion_start_time > now() and zp.promotion_status = 1 )';
  					}elseif($status == 2){
  						$search_condition .= ' where ( zp.promotion_start_time <= now() and zp.promotion_end_time >= now() and zp.promotion_status = 1 )';
  					}else{
  						$search_condition .= ' where ( zp.promotion_end_time <= now() or zp.promotion_status = 0  )';
  					}
  				}else{
  					if($status == 1){
  						$search_condition .= ' and ( zp.promotion_start_time > now() and zp.promotion_status = 1 )';
  					}elseif($status == 2){
  						$search_condition .= ' and ( zp.promotion_start_time <= now() and zp.promotion_end_time >= now() and zp.promotion_status = 1 )';
  					}else{
  						$search_condition .= ' and ( zp.promotion_end_time <= now() or zp.promotion_status = 0  )';
  					}
  				}
  			}
  			
  			if($search_key !=  '' && $search_key != '折扣区名称'){
  				if($search_condition == ''){
  					$search_condition .= ' where zp.promotion_name like  "%' . $search_key . '%"';
  				}else{
  					$search_condition .= ' and zp.promotion_name like  "%' . $search_key . '%"';
  				}
  			}
  		break;
  	}
  }

?>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>促销折扣区设置</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script language="javascript" src="includes/javascript/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  function sureToDel(url,id){
	  if(confirm("您确定要删除ID为"+id+"的促销折扣区吗?")){
		  window.location.href=url;
	  }
  }
  
  function sureToClear(url,id){
	  if(confirm("您确定要清空ID为"+id+"的促销折扣区商品吗?")){
		  window.location.href=url;
	  }
  }

  $(document).ready(function(){
		//绑定图片日期控件
	    $(".Wdate").css({ cursor: "pointer" });
	    $(".Wdate").die("click").live("click", function () { 
	    	if($(this).prop('disabled') || $(this).prop('readonly'))
		    {
	    		 return false;
			}
	        var options = { skin: $(this).attr("skin") || 'whyGreen' };
	        if ($(this).attr("dateFmt")) {
	            options.dateFmt = $(this).attr("dateFmt");
	        }
	        
	        if ($(this).attr("min-date")) {
	            options.minDate = $(this).attr("min-date");
	        }
	        if ($(this).attr("max-date")) {
	            if ($(this).attr("no-limit-max-date") == 'true') {
	                options.maxDate = $(this).attr("max-date");
	            } else {
	                options.maxDate = $(this).attr("max-date") || '%y-%M-%d';
	            }
	        }
	        WdatePicker(options);
	    });
	    
	  $('#promotion_total .cal-TextBox').attr('disabled',true);
	  $('.so-BtnLink img').live('click',function(){
		  	//var _index=$('.promotion_form').index($(this).parents('.promotion_form'));
		  	$('.promotion_form').attr('name','temporary');
		  	$(this).parents('.promotion_form').attr('name','promotion_form');
		  	var _left=$(this).offset().left;
		  	var _top=$(this).offset().top+17;
		  	$('#spiffycalendar').css({left:(_left+'px'),top:(_top+'px')});
		  })
	  $('.cancelbut').live('click',function(){
		  	//var _index=$('.promotionInfoTr').index($(this).parents('.promotionInfoTr'));
		  	$(this).parents('.promotionInfoTr').find('.promotionInput').val('');
		  	$(this).parents('.promotionInfoTr').find('.timeinput').val('00:00:00');
		  	$(this).parents('.promotionInfoTr').find('.cal-TextBox').val('');
		  	$(this).parents('.promotionInfoTr').find('#on').attr('checked',true);
		  })
	  $('#fileDown form input[name=upload]').click(function(){
			if($(this).parents('form').find('input[name=promotionFile]').val()==''){
				return false;
			}
		  })
	  
	  $('.submitbut').live('click',function(){
		  	var error=false;
		  	var pName=new Array();
		  	$(this).parents('.promotionInfoTr').find('.promotionName').each(function(i){
				if($.trim($(this).val())==''){					
					error=true;							
				}else{
					pName[i]=$(this).val();
					}
				})
			if(error){alert('有 promotion Name 没填写');return false;}
			var discount=$.trim($(this).parents('.promotionInfoTr').find('.short').val());
			if(discount==''){
				alert('Promotion Discount 没填写');
				return false;
				}
			if(isNaN(discount)||discount>=100||discount<=0){
				alert('Promotion Discount 输入错误');
				return false;
			}
			var datestart=$.trim($(this).parents('.promotionInfoTr').find('input[name=start]').val());
			if(datestart==''){
				alert('开始日期 没设置');
				return false;
				}
			var dateend=$.trim($(this).parents('.promotionInfoTr').find('input[name=end]').val());
			if(dateend==''){
				alert('结束日期 没设置');
				return false;
				}
			var str=/^(\d{4})-(0[1-9]{1}|1[0-2]{1})-(0[1-9]{1}|[1-2]{1}\d{1}|3[0-1]{1})$/;
			var re2 = new RegExp(str);
			if(!datestart.match(re2)){
				alert('开始日期 格式错误');
				return false;
			}
			if(!dateend.match(re2)){
				alert('结束日期格式错误');
				return false;
			}
			var timestart=$.trim($(this).parents('.promotionInfoTr').find('input[name=time_start]').val());
			if(timestart==''){
				alert('开始时间没设置');
				return false;
				}			
			var timeend=$.trim($(this).parents('.promotionInfoTr').find('input[name=time_end]').val());
			if(timeend==''){
				alert('结束时间没设置');
				return false;
				}
			var strRegex=/^(0\d{1}|1\d{1}|2[0-3]):[0-5]\d{1}:([0-5]\d{1})$/;
			var re = new RegExp(strRegex);	
			if(!timestart.match(re)){
				alert('开始时间格式设置错误');
				return false;
			}
			if(!timeend.match(re)){
				alert('结束时间格式设置错误');
				return false;
			}
			if($(this).parents('.promotionInfoTr').find('span.pid').hasClass('editaction')){
				var action='update';
				var pid=$(this).parents('.promotionInfoTr').find('.editaction').text();
			}else{
				var action='insert';
				var pid=0;
				}
			var page='<?php echo $_GET['page']?>';
			var status=$(this).parents('.promotionInfoTr').find('input[name=status]:checked').val();
			$.post('./promotion_list.php?action='+action,{pid:pid,pName:pName,discount:discount,datestart:datestart,dateend:dateend,timestart:timestart,timeend:timeend,status:status,page:page},function(data){
				//alert(data);
				window.location.href=data;
				})				
		  })

		  $('#btnCancel').click(function(){
			  window.location.href = '<?php echo zen_href_link(FILENAME_PROMOTION_LIST,'page='.$_GET['page'].(isset($_GET['pID'])?('&pID='.$_GET['pID']):'')) ?>';
			  return false;
		  });
	  	   
	  })//end of jquery readay
	  
	  $('#update_navigation').live('click', function() {
	  	var formObject = $(this).parents('form').filter(':first');
	  	if(formObject.hasClass("protecting")) {
	  		formObject.removeClass('protecting');
	  		$(this).val('Update');
	  		formObject.find('input').attr('disabled',false);
	  		return false;
	  	}
	  	
	  	var checkedLength = 0;
	  	$('#promotion_form_display .jq_languages').each(function() {
  			if($(this).attr('checked') == 'checked') {
  				checkedLength++;
  			}
  		});
  		if(checkedLength <= 0) {
  			$('#open_error').text(' 请至少选择一项!');
  			return false;
  		}
	  	
	  });
  
	  $('#promotion_form_display .jq_languages').live('click', function() {
	  	var len = $('#promotion_form_display .jq_languages').length;
	  	if($(this).attr('checked') == 'checked') {
	  		var checkedLength = 0;
	  		$('#promotion_form_display .jq_languages').each(function() {
	  			if($(this).attr('checked') == 'checked') {
	  				checkedLength++;
	  			}
	  		});
	  		if(len == checkedLength + 1) {
	  			$('#navigation_0').attr('checked', true);
	  		}
	  	} else {
	  		$('#navigation_0').attr('checked', false);
	  	}
	  });
	  
	  $('#promotion_status_display1').live('click', function() {
	  	$('.jq_languages').attr('disabled',true);
	  });
	  $('#promotion_status_display2').live('click', function() {
	  	$('.jq_languages').attr('disabled',false);
	  });
	  $('#navigation_0').live('click', function() {
	    var checked = $(this).attr('checked') || false;
	  	$('.jq_languages').attr('checked',checked);
	  });
	  
	  
	  function checkPromotion(){
		  if($('#promotion_total').hasClass('protecting')){
			  $('#promotion_total').removeClass('protecting');
			  $('.cal-TextBox').attr('disabled',false);
			  $('#promotion_total input[name=promotion_status]').attr('disabled',false);
			  $('#promotion_total .timeinput').attr('disabled',false);
			  $('#updatePro').val('Update');
			  return false;
		  }else{
			  $('#updatePro').val('Wait...'); 
			  var datestart=$.trim($('#promotion_total input[name=start]').val());
				if(datestart==''){
					$('#updatePro').val('Update');
					alert('开始日期 没设置');	
					return false;
					}
				var dateend=$.trim($('#promotion_total input[name=end]').val());
				if(dateend==''){
					$('#updatePro').val('Update');
					alert('结束日期 没设置');
					return false;
					}
				var str=/^(\d{4})-(0[1-9]{1}|1[0-2]{1})-(0[1-9]{1}|[1-2]{1}\d{1}|3[0-1]{1})$/;
				var re2 = new RegExp(str);
				if(!datestart.match(re2)){
					$('#updatePro').val('Update');
					alert('开始日期 格式错误');			
					return false;
				}
				if(!dateend.match(re2)){
					$('#updatePro').val('Update');
					alert('结束日期格式错误');
					return false;
				}
				var timestart=$.trim($('#promotion_total input[name=time_start]').val());
				if(timestart==''){
					$('#updatePro').val('Update');
					alert('开始时间没设置');
					return false;
					}			
				var timeend=$.trim($('#promotion_total input[name=time_end]').val());
				if(timeend==''){
					$('#updatePro').val('Update');
					alert('结束时间没设置');
					return false;
					}
				var strRegex=/^(0\d{1}|1\d{1}|2[0-3]):[0-5]\d{1}:([0-5]\d{1})$/;
				var re = new RegExp(strRegex);	
				if(!timestart.match(re)){
					$('#updatePro').val('Update');
					alert('开始时间格式设置错误');
					return false;
				}
				if(!timeend.match(re)){
					$('#updatePro').val('Update');
					alert('结束时间格式设置错误');
					return false;
				}
				var status=$('#promotion_total input[name=promotion_status]:checked').val();
				$.post('./promotion_list.php?action=set',{datestart:datestart,dateend:dateend,timestart:timestart,timeend:timeend,status:status},function(data){
					window.location.href=data;
					})	
			 	return false;
		  }		  
  		}

	  function check_input(){
			var discount = parseInt($('#discount_input').val());
			var starttime = $('#pStartTime').val();
			var endtime = $('#pEndTime').val();
			var name = $('#promotion_name').val();
			var error = false;
			var time_error = false;
			var now = new Date();
			var stage =  $("input[name=stage]").val();
			var have_start = false;

			if(stage == 'loading'){
				have_start = true;
			}

			$('#discount_error').html('');
			$('#starttime_error').html('');
			$('#endtime_error').html('');
			$('#name_error').html('');

			if(!have_start){
				if(name == ''){
					$('#name_error').html('请填写折扣区名称!');
					error = true;
				}
			}

			if(starttime != ''){
				starttime = Date.parse(starttime.replace(/-/g,"/"));
			}
			if(endtime != ''){
				endtime = Date.parse(endtime.replace(/-/g,"/"));
			}

			if(discount <= 0  || isNaN(discount)){
				$('#discount_error').html('请输入正确的商品折扣!');
				error = true;
			}

			if(starttime == ''){
				$('#starttime_error').html('请选择开始时间!');
				time_error = true;
				error = true;
			}

			if(endtime == ''){
				$('#endtime_error').html('请选择结束时间!');
				time_error = true;
				error = true;
			}

			if(time_error == false){
				if(!have_start){
					if(starttime < now){
						$('#starttime_error').html('开始时间必须大于当前时间！');
						error = true;
					}
				}else{
					if(endtime < now){
						$('#endtime_error').html('结束时间需大于当前时间!');
						error = true;
					}
				}
				if(starttime >= endtime ){
					$('#endtime_error').html('结束时间需晚于开始时间!');
					error = true;
				}
			}

			if(error){
				return false;
			}else{
				return true;
			}
			
		}
		
</script>
<style>
.simple_button{background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
    border: 1px solid #656462;
    border-radius: 3px 3px 3px 3px;
    cursor: pointer;
    padding: 3px 20px;}
 .listshow{
	margin: 0;
    padding: 5px 10px;
 }
 #showpromotion{
 	margin-top: 20px;
 }
 #showpromotion th{
 	  background: none repeat scroll 0 0 #D6D6CC;
    font-size: 13px;
    padding: 6px 10px 6px 15px;
    text-align: left;
 }
  #showpromotion th .red{
  	color: #FF0000;
    font-weight: normal;
  }
 #showpromotion td{
 	border-bottom: 1px dashed #CCCCCC;
 }
 .actionBut{
 	 display: table-cell;
    margin-bottom: 5px;
    width: 80px;
 }
 .promotionInput{
 	border: 1px solid #888888;
    height: 20px;
    line-height: 20px;
    width: 160px;
 }
 .short{
 	margin: 0 5px 0 20px;
    width: 50px;
 height: 24px;
    line-height: 24px;
 }
 .promotionName{
 	float: right;
 }
 .promotionLang{
 	float: left;
    line-height: 20px;
 }
 .promotionDiv{
 	 margin: 2px 0;
    overflow: hidden;
 }
 #fileDown{
	padding: 0 0 0 10px;
 }
 #fileDown p{
	 font-size: 13px;
    font-weight: bold;
    margin: 5px 0;
 }
 #fileDown a{
 	 text-decoration: underline;
 }
 #fileDown a:hover{
	color:#ff6600;
 }
 #fileDown input{
	font-size:12px;cursor:pointer;
 }
 #promotion_total{
	 margin-top: 15px;
    padding: 10px;
 }
 #promotion_total h2{
 	font-size: 14px;
    margin: 8px 0;
 }
 .protecting .cal-TextBox{
	background: none repeat scroll 0 0 #FFFFFF;
    color: #6D6D6D;
 }
 #updatePro{
	font-weight:bold;
 }
 
 #promotion_info tr{
 	height:40px;
 }
 
 .info_column_title{
 	padding-right:5px; 
 	width:80px;
 }
 
 .info_column_content{
 	padding-left:5px; 
 }
 .info_red{
 	color:red;
 }
 .Wdate{
 	width:150px;
 }
</style>
</head>
<body onLoad="init()">
<div id="spiffycalendar" class="text"></div>
<?php require(DIR_WS_INCLUDES . 'header.php'); 
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
  <tr>
  	<td width="100%" valign="top" style="padding: 20px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tbody>
    	<tr>
            <td class="pageHeading"><span style="font-size: 20px;"><?php echo $action=='add'?'新建折扣区':($action=='edit'?'促销折扣区编辑':'促销折扣区设置');?></span></td>
            <?php if(!$action || $action == 'search'){?><td><a href="<?php echo zen_href_link(FILENAME_PROMOTION_PRODUCTS )?>"><button class='simple_button'>促销商品信息</button></a></td><?php }?>
            <td align="right" class="pageHeading">
            	<form name="search" action="<?php echo zen_href_link(FILENAME_PROMOTION_LIST)?>" method="get">
            	<table width="100%" border="0" cellspacing="5" cellpadding="0">
            		<tr><td  align="right"><?php echo zen_draw_hidden_field('action' , 'search')?><span style="font-size: 13px; font-weight: bold;">应用场景：</span><?php echo zen_draw_pull_down_menu('type', $promotion_types_arr , $_GET['type'] ? $_GET['type'] : '' , 'style="width: 100px;height: 20px;"')?></td></tr>
            		<tr><td  align="right"><span style="font-size: 13px; font-weight: bold;">状态：</span><?php echo zen_draw_pull_down_menu('status', $status_arr , $_GET['status'] ? $_GET['status'] : '', 'style="width: 100px;height: 20px;"')?></td></tr>
            		<tr><td  align="right"><?php echo zen_draw_input_field('pName' , $_GET['pName'] ? $_GET['pName'] :'折扣区名称' , 'onclick="if (this.value == \'折扣区名称\'){this.value=\'\';this.style.color=\'#000\';}" style="height: 25px;width: 165px;color: darkgray;"')?></td></tr>
            		<tr><td  align="right"><?php echo zen_image_submit('button_search_cn.png','搜索');?></td></tr>
            	</table>
            	</form>
            </td>
        </tr>
		</tbody>
	</table>
	</td>
	</tr>
	<tr>
	<td>           
<?php
if(!$action || $action == 'search'){
	$languages = zen_get_languages();
	$promotion_area = json_decode(SHOW_PROMOTION_AREA_NAVIGATION);
	$pageIndex = 1;
	If($_GET['page'])
	{
		$pageIndex = intval($_GET['page']);
	}
	$promotion_list_query_raw = "select promotion_id,promotion_name ,promotion_discount,promotion_start_time,promotion_end_time,promotion_status,promotion_type,promotion_create_time,promotion_create_operator,promotion_modify_time,promotion_modify_operator from " . TABLE_PROMOTION . " zp " . $search_condition . " order by zp.promotion_id desc ";
	$promotion_list_split = new splitPageResults($pageIndex, MAX_DISPLAY_SEARCH_RESULTS, $promotion_list_query_raw, $query_numrows);
	$promotion_list = $db->Execute($promotion_list_query_raw);
	
	?> 
	</td></tr>
	<tr><td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody><tr>
            <td valign="top" width='80%'>
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
			<form name="export_products" action="<?php echo zen_href_link(FILENAME_PROMOTION_LIST,'action=export')?>" method="post">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="center">ID</td> 
                <td class="dataTableHeadingContent" align="center">折扣</td>
                <td class="dataTableHeadingContent" align="center">折扣区名称</td>
                <td class="dataTableHeadingContent" align="center">开始时间</td>
                <td class="dataTableHeadingContent" align="center">结束时间</td>
                <td class="dataTableHeadingContent" align="center">状态</td>
                <td class="dataTableHeadingContent" align="center">启用/禁用</td>
                <td class="dataTableHeadingContent" align="center">应用场景</td>
                <td class="dataTableHeadingContent" align="right">操作</td>
              </tr>
              <?php 
              while(!$promotion_list->EOF){
              		$i = 1;
					if ((!isset($_GET['pID']) || (isset($_GET['pID']) && ($_GET['pID'] == $promotion_list->fields['promotion_id']))) && !isset($pInfo)) {
						$pInfo_array = $promotion_list->fields;
						$pInfo = new objectInfo($pInfo_array); 
						$_GET['page'] = ceil($i / 20);
					}
					$i++;
					if (isset($pInfo) && is_object($pInfo) && ($promotion_list->fields['promotion_id'] == $pInfo->promotion_id)) {
						echo '<tr class="dataTableRowSelected">';
					}else{
						echo '<tr class="dataTableRow">';
					}
					
					$current_datetime = date("Y-m-d H:i:s");
					$start_datetime = $promotion_list->fields['promotion_start_time'];
					$end_datetime = $promotion_list->fields['promotion_end_time'];
					
					$promotion_active_state = '';
					if($promotion_list->fields['promotion_status'] == 0){
						$promotion_active_state = '已结束';
					}else{
						if ($current_datetime <$start_datetime)
						{
							$promotion_active_state = '未开始';
						}else if($current_datetime >=$start_datetime && $current_datetime <= $end_datetime)
						{
							$promotion_active_state = '活动';
						}else if($current_datetime >=$end_datetime)
						{
							$promotion_active_state = '已结束';
						}
					}					
					?>
					<td class="dataTableContent" align="center"><b><?php echo zen_draw_checkbox_field('promotion_id[]' , $promotion_list->fields['promotion_id'])?><?php echo $promotion_list->fields['promotion_id'];?></b></td> 
                	<td class="dataTableContent" align="center"><?php echo round($promotion_list->fields['promotion_discount'],2);?>% off</td>
                	<td class="dataTableContent" align="center"><b><?php echo $promotion_list->fields['promotion_name'] ? $promotion_list->fields['promotion_name'] : '/';?></b></td> 
                	<td class="dataTableContent" align="center"><?php echo $promotion_list->fields['promotion_start_time']?$promotion_list->fields['promotion_start_time']:'/';?></td>
                	<td class="dataTableContent" align="center"><?php echo $promotion_list->fields['promotion_end_time']?$promotion_list->fields['promotion_end_time']:'/';?></td>
                	<td class="dataTableContent" align="center"><?php echo $promotion_active_state;?></td>
                	<td class="dataTableContent" align="center"><?php echo $promotion_list->fields['promotion_status']==1?zen_image(DIR_WS_IMAGES . 'icon_green_on.gif', IMAGE_ICON_STATUS_ON):zen_image(DIR_WS_IMAGES . 'icon_red_on.gif', IMAGE_ICON_STATUS_OFF);?></td>
                	<td class="dataTableContent" align="center"><?php echo $promotion_types[$promotion_list->fields['promotion_type']];?></td>
                	<td class="dataTableContent" align="right">
                		<?php echo $promotion_active_state == '已结束'?'':('<a href="' . zen_href_link(FILENAME_PROMOTION_LIST, zen_get_all_get_params(array('pID', 'action' , 'type' , 'status' , 'pName' , 'x' , 'y')) . 'pID=' . $promotion_list->fields['promotion_id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'); ?>&nbsp;
                		<?php if ( (is_object($pInfo)) && ($promotion_list->fields['promotion_id'] == $pInfo->promotion_id) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_PROMOTION_LIST, zen_get_all_get_params(array('action' , 'pID' , 'page' , 'type' , 'status' , 'pName' , 'x' , 'y')) . 'page=' . $pageIndex . '&pID=' . $promotion_list->fields['promotion_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>
                	</td>
                	</tr>
					<?php
					$promotion_list->MoveNext();
				}
              ?>
               <tr>
             	 <td class="dataTableHeadingContent" colspan="3" align="left"><?php echo zen_image_submit('button_export_cn.gif','导出','style="width:100px;height:30px;"');?>(点击导出选中折扣区中的促销商品数据)</td>
                <td class="dataTableHeadingContent" colspan="5" align="right"></td>
              </tr>
          </form>
              <tr>
             	 <td class="dataTableHeadingContent" colspan="3" align="left"><?php echo $promotion_list_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS,$pageIndex, TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
                <td class="dataTableHeadingContent" colspan="5" align="right"><?php echo $promotion_list_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $pageIndex, zen_get_all_get_params(array('page', 'id'))); ?></td>
              </tr>
            </table>
            <table border="0" width="100%" cellspacing="0" cellpadding="2" style="margin:10px 0px;">
              <tr>
                <td width="50%" align="left">
               		<img width="57" height="40" border="0" alt="" src="images/pixel_trans.gif">
                </td> 
                <td width="50%" align="right">
                	<a href='<?php  echo zen_href_link(FILENAME_PROMOTION_LIST,'action=add&page='.(isset($_GET['page'])?$_GET['page']:'1'))?>'><button class='simple_button'>新建折扣区</button></a>
                </td>
              </tr>
            </table>    
            <div id="fileDown" style="margin:30px 0px">
            <!-- 	<form name="photo" enctype="multipart/form-data" action="<?php echo zen_href_link(FILENAME_PROMOTION_LIST,'action=upload&area=all')?>" method="post">
            		<p>在此上传促销产品</p>
					<b>File:</b> <input type="file" name="promotionFile" size="30" /> <input type="submit" name="upload" value="Upload(更新库存和滞销状态)" />					
				</form> -->
				<br><br>
				<form name="photo" enctype="multipart/form-data" action="<?php echo zen_href_link(FILENAME_PROMOTION_LIST,'action=upload')?>" method="post">
				<b>File:</b> <input type="file" name="promotionFile" size="30" /> <input type="submit" name="upload" value="Upload(不更新库存和滞销状态)" />	<?php echo zen_draw_hidden_field('pre_url' , zen_href_link(FILENAME_PROMOTION_LIST ,zen_get_all_get_params(array('page')) . 'page=' . $pageIndex))?>			
				</form>
				<br><br>
				<a href="./file/promotion_template.xlsx">Download table template</a>
			</div>        
			<div id="promotion_total" class='protecting' style="display: none;" >
				<script language="javascript">
					var StartDate = new ctlSpiffyCalendarBox("StartDate", "promotion_form", "start", "btnDate1","<?php echo SHOW_PROMOTION_AREA_START_TIME?substr(SHOW_PROMOTION_AREA_START_TIME,0,10):''?>",scBTNMODE_CUSTOMBLUE);
					StartDate.minYearChoice=2013;
					StartDate.maxYearChoice=2041;
					var EndDate = new ctlSpiffyCalendarBox("EndDate", "promotion_form", "end", "btnDate2","<?php echo SHOW_PROMOTION_AREA_END_TIME?substr(SHOW_PROMOTION_AREA_END_TIME,0,10):''?>",scBTNMODE_CUSTOMBLUE);
					EndDate.minYearChoice=2013;
					EndDate.maxYearChoice=2041;					
				</script>
				<table style="width:900px;">
					<tr>
						<th>促销总开关</th>
						<th>前台促销入口控制开关</th>
					</tr>
					<tr>
						<td valign="top">
							<form action="<?php echo zen_href_link(FILENAME_PROMOTION_LIST,'action=set')?>" name='promotion_form' onSubmit='return checkPromotion()'>
								开始时间：<script language="javascript">StartDate.writeControl(); StartDate.dateFormat="yyyy-MM-dd";</script>
			            			  <?php echo zen_draw_input_field('time_start', (SHOW_PROMOTION_AREA_START_TIME?(substr(SHOW_PROMOTION_AREA_START_TIME,11)):'00:00:00'), 'size="8" disabled="disabled" class="timeinput"').' (HH:MM:SS)'?><br>
								结束时间：<script language="javascript">EndDate.writeControl(); EndDate.dateFormat="yyyy-MM-dd";</script>
			            			  <?php echo zen_draw_input_field('time_end', (SHOW_PROMOTION_AREA_END_TIME?(substr(SHOW_PROMOTION_AREA_END_TIME,11)):'00:00:00'), 'size="8" disabled="disabled" class="timeinput" ').' (HH:MM:SS)'?><br>
								是否开启：<input type='radio' name="promotion_status" value='1' id='pon' disabled='disabled' <?php echo SHOW_PROMOTION_AREA_STATUS?'checked="checked"':''?>><label for="pon">On</label><input type='radio' name="promotion_status" value='0' id='poff' disabled='disabled' <?php echo SHOW_PROMOTION_AREA_STATUS?'':'checked="checked"'?>><label for="poff">Off</label><br><br>
								<input type="submit" class="simple_button" value='Edit' id="updatePro">
							</form>
						</td>
						<td valign="top">
							<form action="<?php echo zen_href_link(FILENAME_PROMOTION_LIST,'action=set_navigation')?>" id="promotion_form_display" name='promotion_form_display' class='protecting' method='post'>
								<input type='radio' name="promotion_status_display" value='0' id='promotion_status_display1' disabled='disabled' <?php echo $promotion_area->status == 0 ? 'checked="checked" ' : ''?>><label for="promotion_status_display1">关闭</label><br/>
								<input type='radio' name="promotion_status_display" value='1' id='promotion_status_display2' disabled='disabled' <?php echo $promotion_area->status == 1 ?' checked="checked"' : ''?>><label for="promotion_status_display2">开启</label><span id="open_error" style="color:red;"></span><br/>
								&nbsp;&nbsp;&nbsp;&nbsp;<input class='jq_languages' type="checkbox" id="navigation_0" value='1' disabled='disabled' /><label for="navigation_0">所有</label>
								<?php 
									$language_codes = "";
									foreach($languages as $language) {
										$language_codes .= $language['code'] . ",";
										$checked_language = strstr($promotion_area->languages, "," . $language['code'] . ",") != "" ? " checked='checked'" : "";
										echo "<input class='jq_languages' type='checkbox' id='navigation_" . $language['code'] . "' name='navigation_" . $language['code'] . "'" . $checked_language . " value='1' disabled='disabled' /><label for='navigation_" . $language['code'] . "'>" . ucfirst($language['directory']) . "</label> ";
									}
									$language_codes = substr($language_codes, 0, -1);
								?>
								<br/><br/>
								<input type="hidden" name="language_codes" value="<?php echo $language_codes;?>">
								<input type="hidden" name="languages_old" value="<?php echo $promotion_area->languages;?>">
								<input type="submit" class="simple_button" value='Edit' id="update_navigation">
							</form>
						</td>
					</tr>
				</table>
				<!--
				<h2>促销总开关:</h2>
				<span>
				<form action="<?php echo zen_href_link(FILENAME_PROMOTION_LIST,'action=set')?>" name='promotion_form' onSubmit='return checkPromotion()'>
					开始时间：<script language="javascript">StartDate.writeControl(); StartDate.dateFormat="yyyy-MM-dd";</script>
            			  <?php echo zen_draw_input_field('time_start', (SHOW_PROMOTION_AREA_START_TIME?(substr(SHOW_PROMOTION_AREA_START_TIME,11)):'00:00:00'), 'size="8" disabled="disabled" class="timeinput"').' (HH:MM:SS)'?><br>
					结束时间：<script language="javascript">EndDate.writeControl(); EndDate.dateFormat="yyyy-MM-dd";</script>
            			  <?php echo zen_draw_input_field('time_end', (SHOW_PROMOTION_AREA_END_TIME?(substr(SHOW_PROMOTION_AREA_END_TIME,11)):'00:00:00'), 'size="8" disabled="disabled" class="timeinput" ').' (HH:MM:SS)'?><br>
					是否开启：<input type='radio' name="promotion_status" value='1' id='pon' disabled='disabled' <?php echo SHOW_PROMOTION_AREA_STATUS?'checked="checked"':''?>><label for="pon">On</label><input type='radio' name="promotion_status" value='0' id='poff' disabled='disabled' <?php echo SHOW_PROMOTION_AREA_STATUS?'':'checked="checked"'?>><label for="poff">Off</label><br><br>
					<input type="submit" class="simple_button" value='Edit' id="updatePro">
				</form>
				</span>
				-->
			</div>
            </td>    
            <td valign="top">
            <div class="infoBoxContent">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
  				<tbody><tr class="infoBoxHeading">
    					<td class="infoBoxHeading"><b>ID <?php echo $pInfo->promotion_id;?></b></td>
  						</tr>
				</tbody>
			</table>	
			<?php 	
				$current_datetime = date("Y-m-d H:i:s");
				$start_datetime = $pInfo->promotion_start_time;
				$end_datetime = $pInfo->promotion_end_time;
				$promotion_active_state = '';
				
				if($pInfo->promotion_status == 0){
					$promotion_active_state = '已结束';
				}else{
					if ($current_datetime <$start_datetime)
					{
						$promotion_active_state = '未开始';
					}else if($current_datetime >=$start_datetime && $current_datetime <= $end_datetime)
					{
						$promotion_active_state = '活动';
					}else if($current_datetime >=$end_datetime)
					{
						$promotion_active_state = '已结束';
					}
				}
			?> 
			<p class="listshow"><b>折扣:</b> <?php echo round($pInfo->promotion_discount,2);?>% off</p>
			<p class="listshow"><b>折扣区名称:</b> <?php echo $pInfo->promotion_name ? $pInfo->promotion_name : '/';?></p>
			<p class="listshow"><b>状态:</b> <?php echo  $promotion_active_state;?></p>
			<p class="listshow"><b>启用/禁用:</b> <?php echo  $pInfo->promotion_status == '1' ? '启用' : '禁用';?></p>
			<p class="listshow"><b>应用场景:</b> <?php echo $promotion_types[$pInfo->promotion_type];?></p>
			<p class="listshow"><b>开始时间:</b> <?php echo  $pInfo->promotion_start_time?$pInfo->promotion_start_time:'/';?></p>
			<p class="listshow"><b>结束时间:</b> <?php echo  $pInfo->promotion_end_time?$pInfo->promotion_end_time:'/';?></p>
			<p class="listshow"><b>创建人:</b> <?php echo  $pInfo->promotion_create_operator?$pInfo->promotion_create_operator:'/';?></p>
			<p class="listshow"><b>创建时间:</b> <?php echo  $pInfo->promotion_create_time?$pInfo->promotion_create_time:'/';?></p>
			<p class="listshow"><b>修改人:</b> <?php echo  $pInfo->promotion_modify_operator?$pInfo->promotion_modify_operator:'/';?></p>
			<p class="listshow"><b>修改时间:</b> <?php echo  $pInfo->promotion_modify_time?$pInfo->promotion_modify_time:'/';?></p>
			<?php 
			$promotion_product_count = 0;
			$promotion_product_query= "select count(*) as product_count from ".TABLE_PROMOTION_PRODUCTS." where pp_promotion_id = ".intval($pInfo->promotion_id) . " and pp_is_forbid = 10";
			$promotion_product_result = $db->Execute($promotion_product_query);
			if(!$promotion_product_result->EOF){
					$promotion_product_count = $promotion_product_result->fields['product_count'];
					
					$promotion_product_result->MoveNext();
			}  
			?>
				
			<table width="100%" border="0" cellspacing="0" cellpadding="12">
				<tr>
					<?php if($promotion_active_state != "已结束"){?>
					<td width='50%' align='center'><a href="<?php echo zen_href_link(FILENAME_PROMOTION_LIST, zen_get_all_get_params(array('pID', 'action' , 'type' , 'status' , 'pName' , 'x' , 'y')) . 'pID=' . $pInfo->promotion_id . '&action=edit', 'NONSSL')?>"><button class="simple_button" style="width:96px;">编辑</button></a></td>
					<?php }?>
					<?php  if($promotion_active_state == '未开始' || $promotion_active_state == '活动'){?>
			   			<td width='50%' align='center'><a href="<?php echo zen_href_link(FILENAME_PROMOTION_LIST, zen_get_all_get_params(array('pID', 'action' , 'type' , 'status' , 'pName' , 'x' , 'y')) . 'pID=' . $pInfo->promotion_id . '&action=forbid', 'NONSSL')?>"><button class="simple_button" style="width:96px;">禁用</button></a></td>
			   		<?php }?>
		   		</tr>
		   		<tr>
					<?php if($promotion_product_count >0 && $promotion_active_state =="未开始"){?>
					<td align='center'><button class="simple_button" style="width:96px;" onclick='sureToClear("<?php echo zen_href_link(FILENAME_PROMOTION_LIST, zen_get_all_get_params(array('pID', 'action' , 'type' , 'status' , 'pName' , 'x' , 'y')) . 'pID=' . $pInfo->promotion_id . '&action=clear_product', 'NONSSL')?>",<?php echo $pInfo->promotion_id;?>)'>清空产品</button></td>
					<?php }?>
					<td align='center' style="display: none;"><button class="simple_button" onclick='sureToDel("<?php echo zen_href_link(FILENAME_PROMOTION_LIST, zen_get_all_get_params(array('pID', 'action' , 'type' , 'status' , 'pName' , 'x' , 'y')) . 'pID=' . $pInfo->promotion_id . '&action=delete', 'NONSSL')?>",<?php echo $pInfo->promotion_id;?>)'>删除</button></td>
			   </tr>
			</table>
			</div>
            </td>
        	</tr>
    	</tbody>
    </table>
	<?php
	}else{
		?>
		<?php  

		$promotion_active_state = '';
		$have_start = false;
		if($action=='edit'&&isset($_GET['pID'])){
			$promotion_query_raw = "select promotion_id,promotion_name,promotion_discount,promotion_start_time,promotion_end_time,promotion_status,promotion_type  from " . TABLE_PROMOTION . "  where promotion_id=".$_GET['pID']." order by promotion_id desc limit 1   ";
			$promotion_info=$db->Execute($promotion_query_raw);
			
			$promotion_discount_info = $promotion_info->fields;
			
			$pinfo = new objectInfo($promotion_info->fields);
			$promotion_des_query_raw = 'select pd_languages_id,pd_name from '.TABLE_PROMOTION_DESCRIPTION.' where pd_id='.$_GET['pID'].' order by pd_id desc ';
			$promotion_des_info=$db->Execute($promotion_des_query_raw);
			$pnameArr=array();
			while(!$promotion_des_info->EOF){
				$pnameArr[$promotion_des_info->fields['pd_languages_id']]=$promotion_des_info->fields['pd_name'];
				$promotion_des_info->MoveNext();
				}
			
			$current_datetime = date("Y-m-d H:i:s");
			$start_datetime = $promotion_discount_info["promotion_start_time"];
			$end_datetime = $promotion_discount_info["promotion_end_time"];
			if($pinfo->promotion_status == 0){
				$promotion_active_state = '已结束';
			}else{
				if ($current_datetime <$start_datetime)
				{
					$promotion_active_state = '未开始';
				}else if($current_datetime >=$start_datetime && $current_datetime <= $end_datetime)
				{
					$promotion_active_state = '活动';
				}else if($current_datetime >=$end_datetime)
				{
					$promotion_active_state = '已结束';
				}
			}
			if($promotion_active_state == '活动'){
				$have_start = true;
			}
		}else {
			$promotion_discount_info = array(
					"promotion_id"=>$_GET['pID'],
					"promotion_type"=>"1",
					"promotion_discount" =>-1,
					"promotion_start_time"=>date("Y-m-d 15:00:00"),
					"promotion_end_time"=>'',
					"promotion_status"=>1
			);
		} 
		
		?>
		<script language="javascript">
		var StartDate = new ctlSpiffyCalendarBox("StartDate", "promotion_form", "start", "btnDate1","<?php echo isset($pinfo->promotion_start_time)?substr($pinfo->promotion_start_time,0,10):''?>",scBTNMODE_CUSTOMBLUE);
		StartDate.minYearChoice=2013;
		StartDate.maxYearChoice=2041;
		var EndDate = new ctlSpiffyCalendarBox("EndDate", "promotion_form", "end", "btnDate2","<?php echo isset($pinfo->promotion_start_time)?substr($pinfo->promotion_end_time,0,10):''?>",scBTNMODE_CUSTOMBLUE);
		EndDate.minYearChoice=2013;
		EndDate.maxYearChoice=2041;
		</script>
		
		<form id="frm_promotion_info" name="frm_promotion_info" action="<?php echo zen_href_link(FILENAME_PROMOTION_LIST,'action=save')?>" method="post">
			<input type="hidden" name="save_type" value="<?php echo $_GET['action']?>" />
			<input type="hidden" name="pId" value="<?php echo $promotion_discount_info['promotion_id']?>" />
			<input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
			<input type="hidden" name="stage" value="<?php echo (!$have_start ? 'ready' : 'loading')?>" />
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="promotion_info"> 
				<?php if($action=='edit'){?>
				<tr>
					<td class="info_column_title" align="right">ID:</td>
					<td class="info_column_content" ><?php echo $promotion_discount_info['promotion_id'];?></td>
					<td></td>
				</tr>
				<?php }?>
				<tr>
					<td class="info_column_title" align="right"><span class="info_red">*</span>折扣区名称:</td>
					<td class="info_column_content" >
					<input type="text" id="promotion_name" name="pName" style="width:150px;text-align:left;" <?php echo (!$have_start ? '' : 'disabled') ?>  value="<?php echo $promotion_discount_info['promotion_name'] == '' ?'': $promotion_discount_info['promotion_name'];?>" />
					</td>
					<td id="name_error" style="color: red;"></td>
				</tr>
				<tr>
					<td class="info_column_title" align="right"><span class="info_red">*</span>应用场景:</td>
					<td class="info_column_content" >
						<input type="radio" id="pType1" name="pType" value="1" <?php echo (!$have_start ? '' : 'disabled') ?> <?php echo $promotion_discount_info['promotion_type']==1?'checked="checked"':'' ?>/><label for="pType1"><?php echo $promotion_types[1]?></label>
						<input type="radio" id="pType2" name="pType" value="2" <?php echo (!$have_start ? '' : 'disabled') ?> <?php echo $promotion_discount_info['promotion_type']==2?'checked="checked"':'' ?>/><label for="pType2"><?php echo $promotion_types[2]?></label>
					</td>
					<td></td>
				</tr>
				
				<tr>
					<td class="info_column_title" align="right"><span class="info_red">*</span>折扣:</td>
					<td class="info_column_content" > 
						<input type="text" id="discount_input" name="pDiscount" <?php echo (!$have_start ? '' : 'disabled') ?> maxlength="3" style="width:50px;text-align:right;" value="<?php echo $promotion_discount_info['promotion_discount'] <=0 ?'': round($promotion_discount_info['promotion_discount'],0);?>" /> %
					</td>
					<td id="discount_error" style="color: red;"></td>
				</tr>
				<tr>
					<td class="info_column_title" align="right"><span class="info_red">*</span>开始时间:</td>
					<td class="info_column_content" >
						<input class="Wdate" <?php echo (!$have_start ? '' : 'disabled') ?> type="text" id="pStartTime" name="pStartTime" min-date ="%y-%M-%d" max-date ="#F{$dp.$D(\'pEndTime\')}" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $promotion_discount_info['promotion_start_time'];?>" />
					</td>
					<td id="starttime_error" style="color: red;"></td>
				</tr>
				<tr> 
					<td class="info_column_title"align="right"><span class="info_red">*</span>结束时间:</td>
					<td class="info_column_content" >
						<input class="Wdate" type="text" id="pEndTime" name="pEndTime"  min-date ="#F{$dp.$D(\'pStartTime\')||%y-%M-%d}" max-date="2038-01-01" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $promotion_discount_info['promotion_end_time'];?>" />
					</td>
					<td id="endtime_error" style="color: red;"></td>
				</tr>
				<tr>
					<td width="100px" align="left" colspan="2" style="padding-left:50px;">
						<?php echo zen_image_submit('button_save_cn.png','','onclick="return check_input();"');?>
						<?php echo zen_image_button('button_cancel_cn.png', IMAGE_CANCEL  , 'onClick="JavaScript:history.go(-1)" style="cursor: pointer;"') ;?>
					</td> 
					<td></td>
				</tr>
			</table>
		</form>
		 <div style="text-align:right;margin:20px 10px 0px 0px;display:none;"><a href='<?php echo zen_href_link(FILENAME_PROMOTION_LIST,'page='.$_GET['page'].(isset($_GET['pID'])?('&pID='.$_GET['pID']):'')) ?>'><button class='simple_button'>Back</button></a></div>
		<?php
}
?>
</td>
</tr>
</tbody>
</table>
</body>
</html>