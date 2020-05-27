<?php
/**
* 功能: 一口价类Deals管理
* 作者: phc
* 时间: 2015年8月15日
* 文件: deals_list.php
*/

require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'language.php');
  $action = (isset($_GET['action']) ? $_GET['action'] : ''); 
  //$expire_intervals = array(12=>12,24=>24,48=>48,72=>72); 
  $languages = zen_get_languages();
  $language_count = sizeof($languages);
  
  if(zen_not_null($action)){
  	switch ($action) { 
  		case 'clear_product':
  			$pid = zen_db_prepare_input($_GET['pID']); 
  			$admin_email = $_SESSION['admin_email'];
	        
	        $products_id_result = $db->Execute("select products_id , dailydeal_products_start_date , dailydeal_products_end_date from " . TABLE_DAILYDEAL_PROMOTION . " where area_id = '" . (int)$pid . "' and dailydeal_is_forbid = 10");
	        while (!$products_id_result->EOF) {
	        	$start_time = $products_id_result->fields['dailydeal_products_start_date'];
	        	$end_time = $products_id_result->fields['dailydeal_products_end_date'];
	        	$current_datetime = date("Y-m-d H:i:s");
	        	
	        	if ($current_datetime < $start_time){
	        		$db->Execute("delete from " . TABLE_DAILYDEAL_PROMOTION . " where area_id = '" . (int)$pid . "' and products_id = " . $products_id_result->fields['products_id'] . " and dailydeal_is_forbid = 10");
	        	}elseif($current_datetime >= $start_time && $current_datetime <= $end_time){
	        		$db->Execute('update ' . TABLE_DAILYDEAL_PROMOTION . ' set dailydeal_is_forbid = 20 , dailydeal_forbid_admin = "' . $admin_email . '" , dailydeal_forbid_time = "' . $current_datetime . '" where area_id = ' . (int)$pid . ' and products_id = ' . $products_id_result->fields['products_id'] . ' and dailydeal_is_forbid = 10');
	        	}
	        	
	         
	          	remove_product_memcache($products_id_result->fields['products_id']);
	          	$products_id_result->MoveNext();
	        }
	        
	        $db->Execute('update ' . TABLE_DAILYDEAL_AREA . ' SET modify_admin = "' . $admin_email . '" , modify_time = "' . $current_datetime .'" where dailydeal_area_id = ' . $pid);
  			$messageStack->add_session('Success: 成功清空一口价Deals区ID为 '.$pid.'的产品!','success');	
  			zen_redirect(zen_href_link(FILENAME_DEALS_LIST, '&pID='.$pid.'&page=' . (isset($_GET['page'])?$_GET['page']:"1")));
  			break;
  		case 'upload':
  			$area_id = intval($_POST['upload_area_id']);
  			$file=$_FILES['promotionFile'];
  			
  			if(!$area_id)
  			{
  				$messageStack->add_session('Fail: 要导入一口价商品对应的一口价Deals区不能为空','error');
  				zen_redirect(zen_href_link(FILENAME_DEALS_LIST));
  			}
  			
  			if($file['error']||empty($file)){
  				$messageStack->add_session('Fail: 要导入一口价商品对应的文件不能为空'.$file['name'],'error');
  				zen_redirect(zen_href_link(FILENAME_DEALS_LIST));
  			}
  			
  			$filename = basename($file['name']);
  			$file_ext = substr($filename, strrpos($filename, '.') + 1);
  			if($file_ext!='xlsx'&&$file_ext!='xls'){
  				$messageStack->add_session('Fail: 文件格式有误，请上传xlsx或者xls格式的文件','error');
  				zen_redirect(zen_href_link(FILENAME_DEALS_LIST));
  			}else{
  				set_time_limit(0);

  				$detail_sql = "select `dailydeal_area_id`, `area_name`, `start_date`, `end_date`, `expire_interval`, `area_status` from " . TABLE_DAILYDEAL_AREA . "  where dailydeal_area_id=".$area_id." order by dailydeal_area_id desc limit 1   ";
  				$detail_result=$db->Execute($detail_sql);
  				
  				$detail_info = $detail_result->fields;
  				
  				$error_info_array=array();
  				$file_from=$file['tmp_name'];
  				$update_all=false;
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
  				
  				$save_data = array();
  				$error_info = array();
  				
  				$objPHPExcel = $objReader->load($file_from);
  				$sheet = $objPHPExcel->getActiveSheet();
  				$data_count = 0;
  				
  				for($j=2;$j<=$sheet->getHighestRow();$j++){
  					$update_error=false;
  					$data_count ++;
  					
  					$sku = $sheet->getCellByColumnAndRow(0,$j)->getValue();//货号
  					$price  = $sheet->getCellByColumnAndRow(1,$j)->getValue();//售价(美元)
  					$start_date = $sheet->getCellByColumnAndRow(2,$j)->getValue();//开始日期
                    $max_number = $sheet->getCellByColumnAndRow(3,$j)->getValue();//单笔最大购买数
                    $sale_while_stock_lasts = $sheet->getCellByColumnAndRow(4,$j)->getValue();//是否售完即止
                    
  					//验证数据 
  					//1.导入格式校验
  					$row_number = $j;
  					if(trim($sku) == '')
  					{
  						$error_info[] = zend_format("第[{0}]行商品编号不能为空",$row_number);
  						continue;
  					}
  					
  					if($sale_while_stock_lasts == 1){
  						$sale_while_stock_lasts = 10;
  					}elseif($sale_while_stock_lasts == 0){
  						$sale_while_stock_lasts = 20;
  					}else{
  						$error_info[] = zend_format("第[{0}]行[{1}]商品“售完即止”数据有误。",$row_number, $sku);
  						continue;
  					}
  					
  					if(trim($price)=='')
  					{
  						$error_info[] = zend_format("第[{0}]行售价不能为空",$row_number);
  						continue;
  					}
  					
  					if(!is_numeric($price) || $price <=0)
  					{
  						$error_info[] = zend_format("第[{0}]行售价[{1}]不是有效的数值,售价必须是大于0的数值，比如12.35",$row_number,$price);
  						continue;
  					}
  					
  					if(trim($start_date)=='')
  					{
  						$error_info[] = zend_format("第[{0}]行开始日期不能为空",$row_number);
  						continue;
  					}
  					
  					if(!strtotime($start_date))
  					{
  						$error_info[] = zend_format("第[{0}]行开始日期不是有效的日期格式,格式必须是yyyy-MM-dd,比如2008-08-08",$row_number);
  						continue;
  					}
  					
  					$current_datetime = date("Y-m-d H:i:s");
  					$start_datetime = $detail_info['start_date'];
  					$start_time = date("H:i:s",strtotime($detail_info['start_date']));
  					$end_datetime = $detail_info['end_date'];
  					$area_name = $detail_info['area_name'];

  					$real_begin_date = zend_format("{0} {1}",$start_date,$start_time);
  					
  					if(strtotime($real_begin_date) < strtotime($start_datetime))
  					{
  						$error_info[] = zend_format("第[{0}]行开始日期{1}不能小于活动区[{2}]设置的开始时间[{3}]",$row_number,$start_date,$area_name,$start_datetime);
  						continue;
  					}
  					
  					if(strtotime($real_begin_date) >= strtotime($end_datetime))
  					{
  						$error_info[] = zend_format("第[{0}]行开始日期{1}不能大于活动区[{2}]设置的结束时间[{3}]",$row_number,$start_date,$area_name,$end_datetime);
  						continue;
  					}
  					
					  					
  					//2.数据库数据校验
  					$product_sql_result = $db->Execute('select products_id, products_status, products_limit_stock from  '.TABLE_PRODUCTS.' where products_model="'.$sku.'" order by products_status asc limit 1'); 
  					if($product_sql_result->RecordCount() <=0 ){
  						$error_info[] = zend_format("第[{0}]行商品编号[{1}]对应的商品在系统中不存在",$row_number,$sku);
  						continue;
  					}
  					
  					$product_info = $product_sql_result->fields;
  					$pid = $product_info['products_id'];
  					if(!empty($product_info['products_limit_stock'])) {
  						$max_number = 0;
  					}
  					if($product_info['products_status'] != 1 )
  					{
  						if($product_info['products_status'] == 10){
  							$error_info[] = zend_format("第[{0}]行商品编号[{1}]对应的商品已经删除，不能导入",$row_number,$sku);
  						}else{
  							$error_info[] = zend_format("第[{0}]行商品编号[{1}]对应的商品已经下货，不能导入",$row_number,$sku);
  						}
  						continue;
  					}
  								
  					$expire_interval = $detail_info['expire_interval'];
  					
  					$product_end_datetime = strtotime(zend_format("+{0} hour",$expire_interval),strtotime(zend_format("{0} {1}",$start_date,$start_time)));
  					
  					if($product_end_datetime > strtotime($end_datetime))
  					{
  						$product_end_datetime = strtotime($end_datetime);
  					}
  					
  					$real_end_date = date("Y-m-d H:i:s",$product_end_datetime);
  					
  					if(strtotime($real_begin_date) >= strtotime($real_end_date))
  					{
  						$error_info[] = zend_format("第[{0}]行根据活动区设置的商品时效[{1}]小时计算出来的开始日期{2}大于或者等于结束时间[{3}]",$row_number,$expire_interval,$real_begin_date,$real_end_date);
  						continue;
  					}
  					
  					if(array_key_exists($pid, $save_data)) 
  					{
  						$error_info[] = zend_format("第[{0}]行商品编号[{1}]对应的商品已在本次的第[{2}]行存在,不能重复导入",$row_number,$sku,$save_data[$pid]['row_number']);
  						continue;
  					}
  					
  					$have_exist = false;
  					$no_overlapping_promotion_sql = 'SELECT pp_products_id FROM '. TABLE_PROMOTION_PRODUCTS . ' zpp inner join ' . TABLE_PROMOTION . ' zp on zpp.pp_promotion_id = zp.promotion_id
														WHERE (
															(
																pp_promotion_start_time <= "' . $real_begin_date . '"
																AND pp_promotion_end_time >= "' . $real_end_date . '"
															)
														or (
															pp_promotion_start_time >= "' . $real_begin_date . '"
															AND pp_promotion_start_time <= "' . $real_end_date . '"
														)
														or (
															pp_promotion_end_time >= "' . $real_begin_date . '"
															AND pp_promotion_end_time <= "' . $real_end_date . '"
														)
															) and zp.promotion_status = 1 and zpp.pp_is_forbid = 10';
  					$no_overlapping_promotion = $db->Execute($no_overlapping_promotion_sql);
  						
	  				if($no_overlapping_promotion->RecordCount() > 0){
  						$products_arr = array();
  						
  						while(!$no_overlapping_promotion->EOF){
	  						$products_id = zen_db_input($no_overlapping_promotion->fields['pp_products_id']);
	  						$products_arr[] = $products_id;
	  													
	  						$no_overlapping_promotion->MoveNext();
  						}
  						if(in_array($pid, $products_arr)){
  								$have_exist = true;
  						}
  					}
  					
  					if($have_exist == false){
  						$dailydeal_products_sql = 'SELECT products_id FROM ' . TABLE_DAILYDEAL_PROMOTION . '
	  																			WHERE (
																					(
																						dailydeal_products_start_date <= "' . $real_begin_date . '"
																						AND dailydeal_products_end_date >= "' . $real_end_date . '"
																					)
																				or (
																					dailydeal_products_start_date >= "' . $real_begin_date . '"
																					AND dailydeal_products_start_date <= "' . $real_end_date . '"
																				)
																				or (
																					dailydeal_products_end_date >= "' . $real_begin_date . '"
																					AND dailydeal_products_end_date <= "' . $real_end_date . '"
																				) ) AND dailydeal_is_forbid = 10';
  						$dailydeal_products_query = $db->Execute($dailydeal_products_sql);
  					
  						if($dailydeal_products_query->RecordCount() > 0){
  							$dl_products_arr = array();
  							while (!$dailydeal_products_query->EOF){
  								$dl_products_id = zen_db_input($dailydeal_products_query->fields['products_id']);
  								$dl_products_arr[] = $dl_products_id;
  					
  								$dailydeal_products_query->MoveNext();
  							}
  								
  							if(in_array($pid, $dl_products_arr)){
  								$have_exist = true;
  							}
  						}
  					}
  					
  					if($have_exist){
  						$error_info[] = zend_format("第[{0}]行商品编号[{1}]对应的商品已有其他优惠，不能导入",$row_number,$sku);
  						continue;
  					}
  					
  					$check_my_products = $db->Execute("select products_id from " . TABLE_MY_PRODUCTS . " where products_id=" . $pid);
  					if($check_my_products->RecordCount() > 0 ){
  						$error_info[] = zend_format("第[{0}]行商品编号[{1}]对应的商品已下架，不能导入",$row_number,$sku);
  						continue;
  					}
  					
  					$save_data[$pid] = array(
  						"row_number" => $row_number,
  						"products_id"=>$pid,
  						"sku"=>$sku,
  						"area_id"=>$area_id,
  						"start_date"=>$real_begin_date,
  						"end_date"=>$real_end_date,
  						"price"=>$price,
                        "max_num_per_order"=>$max_number,
  						"sale_while_stock_lasts"=>$sale_while_stock_lasts
  					);
  				}
  				  				
  				if($error_info)
  				{
  					//存在严重错误
  					$total_error_msg = implode(';<br />', $error_info);

  					$messageStack->add_session(zend_format('一口价Deals活动区商品信息导入{0}失败。<br>原因如下:{1}',$save_data ?'部分':'全部',$total_error_msg),'error');
  					
  				}
  				
  				//保存成功数据的
  				if($save_data)
  				{
  					foreach ($save_data as $item) {
  						$data_save = array(
  								"products_id" => $item["products_id"],
  								"dailydeal_products_start_date" => $item["start_date"],
  								"dailydeal_products_end_date" => $item["end_date"],
  								"products_img" => '',
  								"dailydeal_is_forbid" => '10',
  								"group_id" => '0',
  								"dailydeal_price" => $item["price"],
  								"area_id" => $item["area_id"],
                                "max_num_per_order" => $item["max_num_per_order"],
  								"sale_while_stock_lasts" => $item["sale_while_stock_lasts"]
  						);
  							
  						zen_db_perform(TABLE_DAILYDEAL_PROMOTION, $data_save, 'insert');
  						remove_product_memcache($item["products_id"]);
  					}
  				
  					$messageStack->add_session(zend_format('一口价Deals活动区商品信息导入{0}'.count($save_data).'条成功。 活动开启后，则对应商品在对应时效内以对应价格出售!',$data_count == count($save_data) ?'全部':'部分'),'success');
  				}
  			} 
  			
  			$return_url = zen_href_link(FILENAME_DEALS_LIST,'pID='.$area_id.'&page='.$page);
  			zen_redirect($return_url);
  			
  			exit;
  			break; 
  		case 'save': 
  			$stage = $_POST['stage'];
  			$pid=$_POST['pId'];
  			$page=$_POST['page'];
  			$pDateEnd=$_POST['pEndTime'];
  			$operator_admin = zen_db_input($_SESSION['admin_email']);
  			$operator_time = date('Y-m-d H:i:s');
  			
  			if($stage == 'ready'){
	  			$saveType=$_POST['save_type'];
	  			$actionType = "insert";
	  			if($saveType == 'edit')
	  			{
	  				$actionType = "update";
	  			}
	  			
	  			$pType=$_POST['pType'];
	  			$pDateStart=$_POST['pStartTime'];
	  			$pExpireInterval=(int)$_POST['pExpireInterval']; 
	  			
	  			$lang_infos = array();
	  			for ($i = 0, $n = $language_count; $i < $n; $i++) {
	  				$lang_id = $languages[$i]['id'];
	  				$lang_infos[$lang_id] = array(
	  						"lang_info"=>$languages[$i],
	  						"pName"=>isset($_POST['pName'.$lang_id]) ? $_POST['pName'.$lang_id] : '',
	  						"pDesc"=>isset($_POST['pDesc'.$lang_id]) ? $_POST['pDesc'.$lang_id] : ''
	  				);
	  			}
	  			 
	  			$planguageStr = implode(',', $planguage);
	  			
	  			$base_data_array = array(  
	  					'area_name'=>zen_db_prepare_input($_POST['pName1']),  
	  					'start_date' => zen_db_prepare_input($pDateStart),
	  					'end_date' => zen_db_prepare_input($pDateEnd),
	  					'expire_interval' => zen_db_prepare_input((int)$pExpireInterval),
	  					'area_status' => 1
	  					);
	  			if($actionType == 'update'){
	  				$extrem_info_arr = array(
	  					'modify_admin' => $operator_admin,
	  					'modify_time' => $operator_time
	  				);
	  			}else{
	  				$extrem_info_arr = array(
	  						'created_admin' => $operator_admin,
	  						'created_time' => $operator_time
	  				);
	  			}
	  			$base_data_array = array_merge($base_data_array , $extrem_info_arr);
	  			   			   
	  			//var_dump($base_data_array);die(); 
	  			
	  			$return_url = zen_href_link(FILENAME_DEALS_LIST);
	  			if($actionType=='insert'){ 
	  				zen_db_perform(TABLE_DAILYDEAL_AREA, $base_data_array, $actionType);
	  				$pid=$db->insert_ID();
	  				
	  			}else{ 
	  				zen_db_perform(TABLE_DAILYDEAL_AREA, $base_data_array, $actionType,"dailydeal_area_id = " . $pid . "");
	  				
	  				$return_url = zen_href_link(FILENAME_DEALS_LIST,'pID='.$pid.'&page='.$page);
	  			}
	  			
	  			//多语言表保存
	  			$db->Execute("delete from " . TABLE_DAILYDEAL_AREA_DESCRIPTION . " where area_id = '" . (int)$pid . "'");
	  			
	  			foreach ($lang_infos as $key=>$value) {
	  				$data_desc = array(
	  						'area_id'=>(int)$pid,
	  						'languages_id'=>(int)$key,
	  						'area_name'=>zen_db_prepare_input($value['pName']),
	  						'area_desc'=>''//zen_db_prepare_input($value['pDesc']),
	  				); 
	  				
	  				zen_db_perform(TABLE_DAILYDEAL_AREA_DESCRIPTION, $data_desc, 'insert'); 
	  			}
  			}else{
  				$check_dailydeals_original_end_time_query = $db->Execute('select end_date from ' . TABLE_DAILYDEAL_AREA . ' where dailydeal_area_id = ' . $pid);
  				$check_dailydeals_original_end_time = $check_dailydeals_original_end_time_query->fields['end_date'];
  				
  				if (strtotime($check_dailydeals_original_end_time) != strtotime(zen_db_prepare_input($pDateEnd))){
	  				$base_data_array = array(
	  					'end_date' => zen_db_prepare_input($pDateEnd),
	  					'modify_admin' => $operator_admin,
	  					'modify_time' => $operator_time
	  				);
	  				
	  				zen_db_perform(TABLE_DAILYDEAL_AREA, $base_data_array, 'update',"dailydeal_area_id = " . $pid . "");
	  				
	  				$operating_log_content = 'ID为#' . $pid . '# 的dailydeals区结束时间由' . $check_dailydeals_original_end_time . '改为' . zen_db_prepare_input($pDateEnd);
	  				zen_insert_operate_logs($_SESSION['admin_id'],$pid,$operating_log_content,20);
  				}
  					
  				$return_url = zen_href_link(FILENAME_DEALS_LIST,'pID='.$pid.'&page='.$page);
  					
  			}
  			zen_redirect($return_url);
  			
  			exit;
  			break;
  		case 'forbid':
  			$pid = zen_db_input($_GET['pID']);
  			$admin_email = $_SESSION['admin_email'];
  			if($pid != ''){
  				$products_id_result = $db->Execute("select products_id , dailydeal_products_start_date , dailydeal_products_end_date from " . TABLE_DAILYDEAL_PROMOTION . " where area_id = '" . (int)$pid . "' and dailydeal_is_forbid = 10");
  				while (!$products_id_result->EOF) {
  					$start_time = $products_id_result->fields['dailydeal_products_start_date'];
  					$end_time = $products_id_result->fields['dailydeal_products_end_date'];
  					$current_datetime = date("Y-m-d H:i:s");
  						
  					if ($current_datetime < $start_time){
  						$db->Execute("delete from " . TABLE_DAILYDEAL_PROMOTION . " where area_id = '" . (int)$pid . "' and products_id = " . $products_id_result->fields['products_id'] . " and dailydeal_is_forbid = 10");
  					}else{
  						$db->Execute('update ' . TABLE_DAILYDEAL_PROMOTION . ' set dailydeal_is_forbid = 20 , dailydeal_forbid_admin = "' . $admin_email . '" , dailydeal_forbid_time = "' . $current_datetime . '" where area_id = ' . (int)$pid . ' and products_id = ' . $products_id_result->fields['products_id'] . ' and dailydeal_is_forbid = 10');
  					}
  						
  						
  					remove_product_memcache($products_id_result->fields['products_id']);
  					$products_id_result->MoveNext();
  				}
  					
  				$db->Execute('update ' . TABLE_DAILYDEAL_AREA. ' SET area_status = 0, modify_admin = "' . $admin_email . '" , modify_time = "' . $current_datetime .'" where dailydeal_area_id = ' . $pid);
  			
  			}
  				
  			zen_redirect(zen_href_link(FILENAME_DEALS_LIST, zen_get_all_get_params(array('action'))));
  			
  			break;
  	}
  }

?>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>一口价Deals设置</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script language="javascript" src="includes/javascript/common.js"></script>
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
  
  function sureToClear(url,id){
	  if(confirm("您确定要清空ID为"+id+"的一口价Deals区商品吗?")){
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
	    
	  
	     $('#fileDown form input[name=upload]').click(function(){
			var formObj = $(this).parents('form');
			var uploadAreaIdObj = $('#upload_area_id',formObj);
			var uploadFileObj = $('input[name=promotionFile]',formObj);

			var areaId = uploadAreaIdObj.val();
			if(areaId == "" || areaId == undefined || areaId == null){
				alert('请选择需要导入产品的一口价Deals活动区');
				return false;
			}

			var uploadFile = uploadFileObj.val();
			if(uploadFile == "" || uploadFile == undefined || uploadFile == null){
				alert('请选择需要导入产品的Excle文件');
				return false;
			}
			
		  })
	   
		  $('#btnCancel').click(function(){
			  window.location.href = '<?php echo zen_href_link(FILENAME_DEALS_LIST,'page='.$_GET['page'].(isset($_GET['pID'])?('&pID='.$_GET['pID']):'')) ?>';
			  return false;
		  });
		  	  	   
		  $('#btnSubmit').click(function(){
		  	var formObj = $(this).parents('form');
			var re = /^[1-9]\d*$/g;
		  	var pNameObj = $("input.pName",formObj);
			var pStartTimeObj = $("#pStartTime",formObj);
			var pEndTimeObj = $("#pEndTime",formObj);
			var pExpireIntervalObj = $("#pExpireInterval",formObj);
			var pStatusObj = $("[name='pStatus']:checked",formObj);
			$("#time_error_promt").css('display','none');
			var strReg = /^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;
		    
			//数据验证
			//名称
			var is_name_error = false;
			pNameObj.each(function(index){
			   if($(this).val() == "" || $(this).val() == undefined || $(this).val() == null)
			   {
				   alert("入口名称-["+$(this).attr('data-lang-name')+"]不能为空");
				   $(this).focus();
				   is_name_error = true;
				   return false;
			   }
		   });

			if(is_name_error)
			{
				return false;
			}
			
		  	//时间验证
			pStartTimeVal = pStartTimeObj.val().trim(); 
			pStartTimeNotEdit = pStartTimeObj.prop('disabled') || pStartTimeObj.prop('readonly');
			if(pStartTimeVal == "" || pStartTimeVal == undefined || pStartTimeVal == null)
			{
				alert('开始时间不能为空');	
				return false;
			}
			
			if(!strReg.test(pStartTimeVal))
			{
				alert('开始时间不是有效的日期时间格式,格式必须是:yyyy-MM-dd HH:mm:ss,比如2015-08-08 08:08:08');	
				return false;
			}
			
			pEndTimeVal = pEndTimeObj.val().trim();
			if(pEndTimeVal == "" || pEndTimeVal == undefined || pEndTimeVal == null)
			{
				alert('结束时间不能为空');	
				return false;
			}
			
			if(!strReg.test(pEndTimeVal))
			{
				alert('结束时间不是有效的日期时间格式,格式必须是:yyyy-MM-dd HH:mm:ss,比如2015-08-08 08:08:08');	
				return false;
			}
			
            var now = new Date(); 
			var start = new Date(pStartTimeVal.replace("-", "/").replace("-", "/"));
            var end = new Date(pEndTimeVal.replace("-", "/").replace("-", "/")); 
            if(!pStartTimeNotEdit && start < now)
			{
            	alert('开始时间['+start.format('yyyy-MM-dd HH:mm:ss')+']必须大于当前时间['+now.format('yyyy-MM-dd HH:mm:ss'))+']';	
				return false;
			}

            if(end < now)
			{
            	alert('结束时间['+end.format('yyyy-MM-dd HH:mm:ss')+']必须大于当前时间['+now.format('yyyy-MM-dd HH:mm:ss'))+']';		
				return false;
			}
			
			if(!pStartTimeNotEdit && end <= start)
			{
				alert('结束时间['+start.format('yyyy-MM-dd HH:mm:ss')+']必须大于开始时间['+end.format('yyyy-MM-dd HH:mm:ss'))+']';
				return false;
			}

			//时效
			var pExpireInterval = pExpireIntervalObj.val().trim();  
			if(pExpireInterval == "" || pExpireInterval == undefined || pExpireInterval == null)
			{	
				alert('请选择商品时效');	
				return false;
			}else if(pExpireInterval.match(re) == null){
				$("#time_error_promt").css('display','inline');
				return false;
			}
			
			var pId = $("[name='pId']:checked",formObj).val()||'0';
			
			//数据提交
			formObj.submit();
			
			return false;
		  });
	  })//end of jquery readay 

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
 
 #detail_info tr{
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
  	<td width="100%" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tbody>
    	<tr>
            <td class="pageHeading"><?php echo $action=='add'?'一口价Deals新增':($action=='edit'?'一口价Deals编辑':'一口价Deals设置');?></td>
            <?php if($action == ''){?><td><a href="<?php echo zen_href_link(FILENAME_DEALS_PRODUCTS )?>"><button class='simple_button'>一口价DEALS商品信息</button></a></td><?php }?>
            <td align="right" class="pageHeading"><img width="57" height="40" border="0" alt="" src="images/pixel_trans.gif"></td>
        </tr>
		</tbody>
	</table>
	</td>
	</tr>
	<tr>
	<td>           
<?php
if(!$action){   
	$pageIndex = 1;
	If(isset($_GET['page']) && $_GET['page'])
	{
		$pageIndex = intval($_GET['page']);
	}
	$list_sql = "select `dailydeal_area_id`, `area_name`, `start_date`, `end_date`, `expire_interval`, `area_status` , `created_admin`, `created_time` , `modify_admin` , `modify_time` from " . TABLE_DAILYDEAL_AREA . " order by dailydeal_area_id desc ";
	$list_split = new splitPageResults($pageIndex, MAX_DISPLAY_SEARCH_RESULTS, $list_sql, $query_numrows);
	$list_result = $db->Execute($list_sql);
	
	?> 
	</td></tr>
	<tr><td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody><tr>
            <td valign="top" width='80%'>
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left">ID</td> 
                <td class="dataTableHeadingContent" align="center">活动名称-en</td>
                <td class="dataTableHeadingContent" align="center">活动开始时间</td>
                <td class="dataTableHeadingContent" align="center">活动结束时间</td>
                <td class="dataTableHeadingContent" align="center">商品时效</td>
                <td class="dataTableHeadingContent" align="center">状态</td>
                <td class="dataTableHeadingContent" align="center">启用/禁用</td> 
                <td class="dataTableHeadingContent" align="right">操作</td>
              </tr>
              <?php 
              while(!$list_result->EOF){
					if ((!isset($_GET['pID']) || (isset($_GET['pID']) && ($_GET['pID'] == $list_result->fields['dailydeal_area_id']))) && !isset($pInfo)) {
						$pInfo_array = $list_result->fields;
						$pInfo = new objectInfo($pInfo_array); 
					}
					if (isset($pInfo) && is_object($pInfo) && ($list_result->fields['dailydeal_area_id'] == $pInfo->dailydeal_area_id)) {
						echo '<tr class="dataTableRowSelected">';
					}else{
						echo '<tr class="dataTableRow">';
					}
					
					$current_datetime = date("Y-m-d H:i:s");
					$start_datetime = $list_result->fields['start_date'];
					$end_datetime = $list_result->fields['end_date'];
					

					$active_state = '';
					if($list_result->fields['area_status'] == 0){
						$active_state = '已结束';
					}else{
						if ($current_datetime <$start_datetime)
						{
							$active_state = '未开始';
						}else if($current_datetime >=$start_datetime && $current_datetime <= $end_datetime)
						{
							$active_state = '活动';
						}else if($current_datetime >=$end_datetime)
						{
							$active_state = '已结束';
						}
					}
					?>
					<td class="dataTableContent" align="left"><b><?php echo $list_result->fields['dailydeal_area_id'];?></b></td> 
                	<td class="dataTableContent" align="center"><?php echo $list_result->fields['area_name'];?></td>
                	<td class="dataTableContent" align="center"><?php echo $list_result->fields['start_date']?$list_result->fields['start_date']:'/';?></td>
                	<td class="dataTableContent" align="center"><?php echo $list_result->fields['end_date']?$list_result->fields['end_date']:'/';?></td>
                	<td class="dataTableContent" align="center"><?php echo $list_result->fields['expire_interval'];?></td>
                	<td class="dataTableContent" align="center"><?php echo $active_state;?></td>
                	<td class="dataTableContent" align="center"><?php echo $list_result->fields['area_status']==1?zen_image(DIR_WS_IMAGES . 'icon_green_on.gif', IMAGE_ICON_STATUS_ON):zen_image(DIR_WS_IMAGES . 'icon_red_on.gif', IMAGE_ICON_STATUS_OFF);?></td>
                	<td class="dataTableContent" align="right">
                	<?php echo $active_state == '已结束'?'':'<a href="' . zen_href_link(FILENAME_DEALS_LIST, zen_get_all_get_params(array('pID', 'action')) . 'pID=' . $list_result->fields['dailydeal_area_id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>&nbsp;
                	<?php if ( (is_object($pInfo)) && ($list_result->fields['dailydeal_area_id'] == $pInfo->dailydeal_area_id) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_DEALS_LIST, zen_get_all_get_params(array('pID', 'action')) . 'pID=' . $list_result->fields['dailydeal_area_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>
                	</td>
                	</tr>
					<?php
					$list_result->MoveNext();
				}
				
              ?>
              <tr>
             	<td class="dataTableHeadingContent" colspan="3" align="left"><?php echo $list_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS,$pageIndex, TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
                <td class="dataTableHeadingContent" colspan="5" align="right"><?php echo $list_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $pageIndex, zen_get_all_get_params(array('page', 'id'))); ?></td>
              </tr>
            </table>
            <table border="0" width="100%" cellspacing="0" cellpadding="2" style="margin:10px 0px;">
              <tr>
                <td width="50%" align="left">
                	&nbsp;&nbsp; 
                </td> 
                <td width="50%" align="right">
                	<a href='<?php  echo zen_href_link(FILENAME_DEALS_LIST,'action=add&page='.(isset($_GET['page'])?$_GET['page']:'1'))?>'><button class='simple_button'>新建</button></a>
                </td>
              </tr>
            </table>            
            <div id="fileDown" style="margin:30px 0px"> 
				<form name="photo" enctype="multipart/form-data" action="<?php echo zen_href_link(FILENAME_DEALS_LIST,'action=upload')?>" method="post">
					<span style="color: red">*</span><b>1.选择Deals活动区:</b> 
					<select name="upload_area_id" id="upload_area_id">
						<option value="">请选择</option> 
						<?php 
						$select_area_sql = "select `dailydeal_area_id`, `area_name` from " . TABLE_DAILYDEAL_AREA . " where area_status != 0 order by dailydeal_area_id desc ";

						$select_area_result = $db->Execute($select_area_sql);
						while(!$select_area_result->EOF){
						?>
							<option value="<?php echo $select_area_result->fields['dailydeal_area_id']?>">[ID:<?php echo $select_area_result->fields['dailydeal_area_id']?>] <?php echo $select_area_result->fields['area_name']?></option> 
						<?php 
							$select_area_result->MoveNext();
						}?>
					</select>
					<br>
					<br>
					<span style="color: red">*</span><b>2.导入产品:</b> <input type="file" name="promotionFile" size="30" /> <a href="./file/template_deals_products_fixed_price.xls.xls" target="_blank">下载模板</a>
					<br>
					<br>
					<input type="submit" name="upload" value="上传" />				
				</form>  
			</div> 
            </td>    
            <td valign="top">
            <div class="infoBoxContent">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
  				<tbody><tr class="infoBoxHeading">
    					<td class="infoBoxHeading"><b>ID <?php echo $pInfo->dailydeal_area_id;?></b></td>
  						</tr>
				</tbody>
			</table>	 
			<p class="listshow"><b>活动名称-en:</b> <?php echo $pInfo->area_name;?></p> 
			<p class="listshow"><b>开始时间:</b> <?php echo  $pInfo->start_date?$pInfo->start_date:'/';?></p>
			<p class="listshow"><b>结束时间:</b> <?php echo  $pInfo->end_date?$pInfo->end_date:'/';?></p>
			<p class="listshow"><b>商品时效:</b> <?php echo  $pInfo->expire_interval;?></p>
			
			<?php 
			$current_datetime = date("Y-m-d H:i:s");
			$start_datetime = $pInfo->start_date;
			$end_datetime = $pInfo->end_date;
			
			$active_state = '';
			if($pInfo->area_status == 0){
				$active_state = '已结束';
			}else{
				if ($current_datetime <$start_datetime)
				{
					$active_state = '未开始';
				}else if($current_datetime >=$start_datetime && $current_datetime <= $end_datetime)
				{
					$active_state = '活动';
				}else if($current_datetime >=$end_datetime)
				{
					$active_state = '已结束';
				}
			}
			$product_count = 0;
			$product_query= "select count(*) as product_count from ".TABLE_DAILYDEAL_PROMOTION." where area_id = '".intval($pInfo->dailydeal_area_id)."'";
			
			$product_result = $db->Execute($product_query); 
			if($product_result->RecordCount() >0 &&  !$product_result->EOF){
					$product_count = $product_result->fields['product_count']; 
			}  
			
			?>
			<p class="listshow"><b>状态:</b> <?php echo  $active_state;?></p>
			<p class="listshow"><b>启用/禁用:</b> <?php echo  $pInfo->area_status == 1? '启用':'禁用';?></p>
			<p class="listshow"><b>创建人:</b> <?php echo  $pInfo->created_admin?$pInfo->created_admin:'/';?></p>
			<p class="listshow"><b>创建时间:</b> <?php echo  $pInfo->created_time?$pInfo->created_time:'/';?></p>
			<p class="listshow"><b>修改人:</b> <?php echo  $pInfo->modify_admin?$pInfo->modify_admin:'/';?></p>
			<p class="listshow"><b>修改时间:</b> <?php echo  $pInfo->modify_time?$pInfo->modify_time:'/';?></p>
				
			<table width="100%" border="0" cellspacing="0" cellpadding="12">
				<tr>
				<td width='50%' align='left'>
					<?php if($active_state != '已结束'){?>
						<a href="<?php echo zen_href_link(FILENAME_DEALS_LIST, zen_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->dailydeal_area_id . '&action=edit', 'NONSSL')?>"><button class="simple_button">编辑</button></a>
					<?php }?>
				</td>
				<td align='center'>
					<?php if($product_count >0 && $active_state =="未开始"){?>
						<button class="simple_button" onclick='sureToClear("<?php echo zen_href_link(FILENAME_DEALS_LIST, zen_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->dailydeal_area_id . '&action=clear_product', 'NONSSL')?>",<?php echo $pInfo->dailydeal_area_id;?>)'>清空产品</button>
					<?php }?>
				</td>
			   </tr>
			   <tr>
					<td align='left'>
						<?php  if($active_state != '已结束'){?>
							<a href="<?php echo zen_href_link(FILENAME_MARKETING_URL,zen_get_all_get_params(array('action', 'id','page')).'action=daily_deals&pID='.$pInfo->dailydeal_area_id)?>"><button class="simple_button">营销URL获取</button></a>
						<?php }?>
					</td>
					<td width='50%' align='center'>
						<?php  if($active_state == '未开始' || $active_state == '活动'){?>
				   			<a href="<?php echo zen_href_link(FILENAME_DEALS_LIST, zen_get_all_get_params(array('pID', 'action')) . 'pID=' . $pInfo->dailydeal_area_id . '&action=forbid', 'NONSSL')?>"><button class="simple_button" style="width:96px;">禁用</button></a>
				   		<?php }?>
			   		</td>
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
		$active_state = '';
		$have_start = false;
		if($action=='edit'&&isset($_GET['pID'])){
			$detail_sql = "select `dailydeal_area_id`, `area_name`, `start_date`, `end_date`, `expire_interval`, `area_status` from " . TABLE_DAILYDEAL_AREA . "  where dailydeal_area_id=".$_GET['pID']." order by dailydeal_area_id desc limit 1   ";
			$detail_result=$db->Execute($detail_sql);
						
			$detail_info = $detail_result->fields;
			
			$current_datetime = date("Y-m-d H:i:s");
			$start_datetime = $detail_info['start_date'];
			$end_datetime = $detail_info['end_date'];
				
			$active_state = '';
			if($detail_info['area_status'] == 0){
				$active_state = '已结束';
			}else{
				if ($current_datetime <$start_datetime)
				{
					$active_state = '未开始';
				}else if($current_datetime >=$start_datetime && $current_datetime <= $end_datetime)
				{
					$active_state = '活动';
				}else if($current_datetime >=$end_datetime)
				{
					$active_state = '已结束';
				}
			}
			if($active_state == '活动'){
				$have_start = true;
			}
		}else {
			$detail_info = array(
					"dailydeal_area_id"=>$_GET['pID'],
					"area_name"=>"", 
					"start_date"=>date("Y-m-d 15:00:00"),
					"end_date"=>'',
					"expire_interval"=>'',
					"area_status"=>1
			);
		}
		
		?>  
		<form id="frm_detail_info" name="frm_detail_info" action="<?php echo zen_href_link(FILENAME_DEALS_LIST,'action=save')?>" method="post">
			<input type="hidden" name="save_type" value="<?php echo $_GET['action']?>" />
			<input type="hidden" name="pId" value="<?php echo $detail_info['dailydeal_area_id']?>" />
			<input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
			<input type="hidden" name="stage" value="<?php echo (!$have_start ? 'ready' : 'loading')?>" />
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="detail_info"> 
				<?php if($action=='edit'){?>
				<tr>
					<td class="info_column_title" align="right">ID:</td>
					<td class="info_column_content" ><?php echo $detail_info['dailydeal_area_id'];?></td>
				</tr>
				<?php }?> 
				<tr>
					<td class="info_column_title" align="right" style="vertical-align: top;"><span class="info_red">*</span>活动名称:</td>
					<td class="info_column_content" > 
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<?php 
								$detail_desc_sql = "select `area_desc_id`, `area_id`, `languages_id`, `area_name`, `area_desc`  from " . TABLE_DAILYDEAL_AREA_DESCRIPTION. " WHERE area_id =:area_id";
								$detail_desc_sql = $db->bindVars($detail_desc_sql, ':area_id', $detail_info['dailydeal_area_id'], 'integer'); 
								$detail_desc_result = $db->Execute($detail_desc_sql);
								
								$detail_desc_array = array();
								
								if($detail_desc_result->RecordCount() >0)
								{
									while(!$detail_desc_result->EOF){
										$detail_desc_array[$detail_desc_result->fields['languages_id']] = $detail_desc_result->fields;
										
										$detail_desc_result->MoveNext();
									}
								} 
							?>
							<?php   
							for ($i = 0, $n = $language_count; $i < $n; $i++) { 
								$lang_id = $languages[$i]['id'];
							?> 
							<tr style="height: 25px;"> 
								<td style="width:60px;" align="right"><?php echo $languages[$i]['name']?> :</td>
								<td><input type="text" id="pName<?php echo $lang_id?>" <?php echo (!$have_start ? '' : 'disabled') ?> class="pName" data-lang-name="<?php echo $languages[$i]['name']?>" name="pName<?php echo $lang_id?>" maxlength="200" style="width:400px;" value="<?php echo $detail_desc_array && array_key_exists($lang_id, $detail_desc_array)?$detail_desc_array[$lang_id]['area_name']:'' ?>" /></td> 
							</tr>
							<?php }?> 
						</table>     
					</td>
				</tr>
				<tr>
					<td class="info_column_title" align="right"><span class="info_red">*</span>开始时间:</td>
					<td class="info_column_content" >
						<input class="Wdate" <?php echo (!$have_start ? '' : 'disabled') ?> type="text" id="pStartTime" name="pStartTime" min-date ="%y-%M-%d" max-date ="#F{$dp.$D(\'pEndTime\')}" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $detail_info['start_date'];?>"  />
					</td>
				</tr>
				<tr> 
					<td class="info_column_title"align="right"><span class="info_red">*</span>结束时间:</td>
					<td class="info_column_content" >
						<input class="Wdate" type="text" id="pEndTime" name="pEndTime"  min-date ="#F{$dp.$D(\'pStartTime\')||%y-%M-%d}" max-date="2038-01-01" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $detail_info['end_date'];?>" />
					</td>
				</tr>
				<tr>
					<td class="info_column_title" align="right"><span class="info_red">*</span>商品时效:</td>
					<td class="info_column_content" >
						<?php echo  zen_draw_input_field('pExpireInterval',$detail_info['expire_interval'] != '' ? $detail_info['expire_interval'] : '','id=pExpireInterval style="width:70px;" '  . (!$have_start ? '' : 'disabled'));?> 小时（<font style="color:red;">只能填入非零自然数</font>）
					<br><font style="color:red;display:none;" id="time_error_promt">请填入非零自然数</font>
					</td>
				</tr>
				<tr>
					<td width="100px" align="left" colspan="2" style="padding-left:50px;">
						<input type="button" class="simple_button" name="btnSubmit" id="btnSubmit" value="保存" /> &nbsp;
						<input type="button" class="simple_button" name="btnCancel" id="btnCancel" value="取消">
					</td> 
				</tr>
			</table>
		</form> 
		<?php
}
?>
</td>
</tr>
</tbody>
</table>
</body>
</html>