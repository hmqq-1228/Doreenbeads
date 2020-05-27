<?php
require('includes/application_top.php');
require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
global $db;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
if(zen_not_null($action)){
	$search_condition .= '';
    switch($action){
    	case 'search':
    	  
          $starttime = $_GET['starttime'];
   	      $stoptime = $_GET['stoptime'];
   	      if($starttime != '' && $stoptime != ''){
              $search_condition .= " and p.products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
              $search_two .= " and p.products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";	
              $search_three .= " and p.products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
   	      }
   	      //计算上架总数
   	      if($starttime != '' && $stoptime != ''){
   	      	if($search_one == ''){
               $search_one .= " where products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
   	      	}else{
             $search_one .= " and products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
   	      	}
   	      }
         
   	      $type = $_GET['type'];
   	      if($type == 1){
   	      	  $search_condition .= " and p.is_preorder = 1 ";
   	      	  if($search_one == ''){
                $search_one .= " where is_preorder = 1 ";
   	      	  }else{
   	      	    $search_one .= " and is_preorder = 1 ";
   	      	  }
   	      	  $search_two .= " and p.is_preorder = 1 ";
   	      	  $search_three .= " and p.is_preorder = 1 ";
   	      }
   	      $starttimes = $_GET['starttimes'];
   	      $stoptimes = $_GET['stoptimes'];
          if($starttimes != '' && $stoptimes != ''){
              $search_condition .= " and o.date_purchased BETWEEN '" . $starttimes . "' AND '" . $stoptimes. "'";	
              $search_two .= " and o.date_purchased BETWEEN '" . $starttimes . "' AND '" . $stoptimes. "'";
              $search_three .=  " and o.date_purchased BETWEEN '" . $starttimes . "' AND '" . $stoptimes. "'";
   	      }
   	      $status = $_GET['status'];
   	      if($status != 0){
            if($status == 1){
              $status = 1;
              $search_condition .= " and p.products_status = '" . $status . "' ";
              $search_three .= " and p.products_status = '" . $status . "' ";
            }else if($status == 2){
              $status = 1;
              $search_condition .= " and p.products_status != '" . $status . "' ";
              $search_three .= " and p.products_status != '" . $status . "' ";
            }
            
          }
   	     
    	break;
    	case 'export':
      $search_four = $_POST['action'];
      $starttime = $_GET['starttime'];
   	      $stoptime = $_GET['stoptime'];
   	      if($starttime != '' && $stoptime != ''){
              $search_condition .= " and p.products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
              $search_two .= " and p.products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";	
              $search_three .= " and p.products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
   	      }
   	      //计算上架总数
   	      if($starttime != '' && $stoptime != ''){
   	      	if($search_one == ''){
               $search_one .= " where products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
   	      	}else{
             $search_one .= " and products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
   	      	}
   	      }
   	      $type = $_GET['type'];
   	      if($type == 1){
   	      	  $search_condition .= " and p.is_preorder = 1 ";
   	      	  if($search_one == ''){
                $search_one .= " where is_preorder = 1 ";
   	      	  }else{
   	      	    $search_one .= " and is_preorder = 1 ";
   	      	  }
   	      	  $search_two .= " and p.is_preorder = 1 ";
   	      	  $search_three .= " and p.is_preorder = 1 ";
   	      }
   	      $starttimes = $_GET['starttimes'];
   	      $stoptimes = $_GET['stoptimes'];
          if($starttimes != '' && $stoptimes != ''){
              $search_condition .= " and o.date_purchased BETWEEN '" . $starttimes . "' AND '" . $stoptimes. "'";	
              $search_two .= " and o.date_purchased BETWEEN '" . $starttimes . "' AND '" . $stoptimes. "'";
              $search_three .=  " and o.date_purchased BETWEEN '" . $starttimes . "' AND '" . $stoptimes. "'";
   	      }
   	      $status = $_GET['status'];
   	      if($status != 0){
            if($status == 1){
              $status = 1;
              $search_condition .= " and p.products_status = '" . $status . "' ";
              $search_three .= " and p.products_status = '" . $status . "' ";
            }else if($status == 2){
              $status = 1;
              $search_condition .= " and p.products_status != '" . $status . "' ";
              $search_three .= " and p.products_status != '" . $status . "' ";
            }
            
          }
   	if(empty($starttimes)  || empty($stoptimes)){
      $goods_sales_data_sql = "select p.products_model,p.products_image,p.products_status,cd.categories_name,p.products_net_price FROM ". TABLE_PRODUCTS ." p LEFT JOIN ". TABLE_CATEGORIES_DESCRIPTION ." cd ON cd.categories_id = p.master_categories_id  WHERE cd.language_id = 1" . $search_condition . $search_four . " GROUP BY p.products_id ORDER BY p.products_model ASC";
    }else{     
    	$goods_sales_data_sql = "SELECT p.products_model,p.products_image,p.products_status,cd.categories_name,p.products_net_price,SUM(op.products_quantity) sale_num,round(sum(final_price * op.products_quantity),2) sale_total,COUNT(op.orders_id) sale_orders_num,count(distinct(o.customers_id)) customers_buy_num FROM ". TABLE_PRODUCTS ." p LEFT JOIN ". TABLE_CATEGORIES_DESCRIPTION ." cd ON cd.categories_id = p.master_categories_id  LEFT JOIN (". TABLE_ORDERS_PRODUCTS ." op INNER JOIN " . TABLE_ORDERS . " o ON op.orders_id = o.orders_id) ON p.products_id = op.products_id WHERE cd.language_id = 1 and o.orders_status in (2,3,4,10,42) " . $search_condition . $search_four . " GROUP BY p.products_id ORDER BY sale_num DESC,p.products_model ASC";
   }
	 $goods_sales_data_res = $db->Execute($goods_sales_data_sql);
     $download = 'download/goods_sales_data.csv';
     $fp = fopen($download, 'w');
     $array_head = array('商品编号', '商品图片', '是否在架', '类别名称', '上货价（￥）', '销售总组数', '销售总金额（￥）', '购买订单数', '购买客户数');
	foreach($array_head as $array_head_key => $array_head_value) {
		$array_head[$array_head_key] = iconv("utf-8", "gb2312", $array_head_value);
	}
	fputcsv($fp, $array_head);
    while (!$goods_sales_data_res->EOF) {
    	$currency_query = $db->Execute('select configuration_value from ' . TABLE_CONFIGURATION . ' where configuration_key = "MODULE_SHIPPING_CHIANPOST_CURRENCY"');
        $currency = $currency_query->fields['configuration_value'];
        $price = round($goods_sales_data_res->fields ['products_net_price'] * $currency,2);
        $sale_total =round($goods_sales_data_res->fields ['sale_total'] * $currency,2); 
	    $status = $goods_sales_data_res->fields['products_status'];
			if($status == 0 || $status == 10){
				$status = '否';
			}else if($status == 1){
				$status = '是';
			}
		$goods_sales_data_res->fields['products_model'] = $goods_sales_data_res->fields['products_model'] ;
		$goods_sales_data_res->fields['products_image'] = 'http://img.8seasons.com/bmz_cache/' . DIR_WS_IMAGES . get_img_size($goods_sales_data_res->fields['products_image'], 80, 80) ;
		$goods_sales_data_res->fields['products_status'] = iconv("utf-8", "gb2312", $status);
		$goods_sales_data_res->fields['categories_name'] = $goods_sales_data_res->fields['categories_name'] ;
		$goods_sales_data_res->fields['products_net_price'] = $price ;
		$goods_sales_data_res->fields['sale_num'] = $goods_sales_data_res->fields['sale_num'] ;
		$goods_sales_data_res->fields['sale_total'] = $sale_total?$sale_total: '' ;
		$goods_sales_data_res->fields['sale_orders_num'] = $goods_sales_data_res->fields['sale_orders_num'] ;
		$goods_sales_data_res->fields['customers_buy_num'] = $goods_sales_data_res->fields['customers_buy_num'] ;
		fputcsv($fp, $goods_sales_data_res->fields);
		
		$goods_sales_data_res->MoveNext();
	}
	fclose($fp);
    $file = fopen($download, "r");
	header("Content-type:text/html;charset=utf-8"); 
	Header("Content-type: application/octet-stream");
	Header("Accept-Ranges: bytes");
	Header("Accept-Length: " . filesize($download));
	$file_name = 'DB-动销数据.csv';;
	if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
		header('Content-type: application/octetstream');
	} else {
		header('Content-Type: application/x-octet-stream');
	}
	header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $file_name));
	echo fread($file, filesize($download));
	fclose($file);
	exit;
    	break;
    	case 'get_template':
    	   $download = 'file/template_products_model.xls';
            $file = fopen($download, "r");
            header("Content-type:text/html;charset=utf-8"); 
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: " . filesize($download));
			$file_name = '商品编号导入模板.xls';
			if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
					header('Content-type: application/octetstream');
				} else {
					header('Content-Type: application/x-octet-stream');
				}
				header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $file_name));
				echo fread($file, filesize($download));
				fclose($file);
		    	break;
    	case 'import':
      $starttime = $_GET['starttime'];
          $stoptime = $_GET['stoptime'];
          if($starttime != '' && $stoptime != ''){
              $search_condition .= " and p.products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
              $search_two .= " and p.products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";  
              $search_three .= " and p.products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
          }
          //计算上架总数
          if($starttime != '' && $stoptime != ''){
            if($search_one == ''){
               $search_one .= " where products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
            }else{
             $search_one .= " and products_date_added BETWEEN '" . $starttime . "' AND '" . $stoptime. "'";
            }
          }
          $type = $_GET['type'];

          if($type == 1){
              $search_condition .= " and p.is_preorder = 1 ";
              if($search_one == ''){
                $search_one .= " where is_preorder = 1 ";
              }else{
                $search_one .= " and is_preorder = 1 ";
              }
              $search_two .= " and p.is_preorder = 1 ";
              $search_three .= " and p.is_preorder = 1 ";
          }
          $starttimes = $_GET['starttimes'];
          $stoptimes = $_GET['stoptimes'];
          if($starttimes != '' && $stoptimes != ''){
              $search_condition .= " and o.date_purchased BETWEEN '" . $starttimes . "' AND '" . $stoptimes. "'"; 
              $search_two .= " and o.date_purchased BETWEEN '" . $starttimes . "' AND '" . $stoptimes. "'";
              $search_three .=  " and o.date_purchased BETWEEN '" . $starttimes . "' AND '" . $stoptimes. "'";
          }
          $status = $_GET['status'];

          if($status != 0){
            if($status == 1){
              $status = 1;
              $search_condition .= " and p.products_status = '" . $status . "' ";
              $search_three .= " and p.products_status = '" . $status . "' ";
            }else if($status == 2){
              $status = 1;
              $search_condition .= " and p.products_status != '" . $status . "' ";
              $search_three .= " and p.products_status != '" . $status . "' ";
            }
            
          }
	        require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
			require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel/Reader/Excel5.php');
			$objReader = new PHPExcel_Reader_Excel5();

			$file = $_FILES['xls_file'];
			$filename = basename($file['name']);
			$ext_name = substr($filename, strrpos($filename, '.') + 1);

			$error = $error_empty = $error_has_exist = '';
			$i = 0;
			if (empty($ext_name)) {
		       $error .= '请先选择文件';
	          } else if ($ext_name != 'xls') {
		          $error .= '文件格式有误，请上传xls格式的文件';
	          } else {
		        if (file_exists($file['tmp_name'])) {
					$objPHPExcel = $objReader->load($file['tmp_name']);

					$sheet = $objPHPExcel->getActiveSheet();
					$array_products_model = array();
                     
					for ($j = 2; $j <= $sheet->getHighestRow(); $j++) {
						$products_model = trim(zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue()));
						if (empty($products_model)) {
							$error_empty .= 'line' . $j . '商品编号不能为空！' . '<br/>';
							continue;
						}
						if(in_array($products_model,$array_products_model)) {
							$error_has_exist .= 'line' . $j . '商品编号重复' . '<br/>';
							continue;
						}else{
							array_push($array_products_model, $products_model);
						}
					}

			// $objPHPExcel = new PHPExcel();
			// $objPHPExcel->setActiveSheetIndex(0);
			// $objPHPExcel->getActiveSheet()->setCellValue('A1','用户ID');
			// $objPHPExcel->getActiveSheet()->setCellValue('B1','用户邮箱');
			$data_index = 2;
			$a ='';
			foreach($array_products_model as $products_model) {
                 // $email_address = "";
               $search_fours .= "'". $products_model . "'".',';
                
			     $data_index++;
			     
			}
              $search_four = " and p.products_model in (" . rtrim($search_fours,',') . ")" ;
		}else {
			$error .= '未知错误' . '<br/>';
		}
        if (!empty ($error_empty)) {
			$error .= $error_empty;
		}
		if (!empty ($error_has_exist)) {
			$error .= $error_has_exist;
		}
	} 
    
	if (!empty ($error)) {
		$messageStack->add_session($error, 'error');
    zen_redirect(zen_href_link(FILENAME_GOODS_SALES_DATA, zen_get_all_get_params(array ('action', 'coupons')), 'NONSSL'));
	} 
	    break;
		    }	
         $_POST['aa'] = $search_four;
   if(empty($starttimes)  || empty($stoptimes)){
      $goods_sales_data_sql = "select p.products_id,p.products_model,p.products_image,p.products_status,cd.categories_name,p.products_net_price FROM ". TABLE_PRODUCTS ." p LEFT JOIN ". TABLE_CATEGORIES_DESCRIPTION ." cd ON cd.categories_id = p.master_categories_id  WHERE cd.language_id = 1" . $search_condition . $search_four . " GROUP BY p.products_id ORDER BY p.products_model ASC";
    }else{
   $goods_sales_data_sql = "SELECT p.products_id,p.products_model,p.products_image,p.products_status,cd.categories_name,p.products_net_price,SUM(op.products_quantity) sale_num,round(sum(final_price * op.products_quantity),2) sale_total,COUNT(op.orders_id) sale_orders_num,count(distinct(o.customers_id)) customers_buy_num FROM ". TABLE_PRODUCTS ." p LEFT JOIN ". TABLE_CATEGORIES_DESCRIPTION ." cd ON cd.categories_id = p.master_categories_id  LEFT JOIN (". TABLE_ORDERS_PRODUCTS ." op INNER JOIN " . TABLE_ORDERS . " o ON op.orders_id = o.orders_id) ON p.products_id = op.products_id WHERE cd.language_id = 1 and o.orders_status in (2,3,4,10,42) " . $search_condition . $search_four . " GROUP BY p.products_id ORDER BY sale_num DESC,p.products_model ASC";
   }
	$goods_sales_data_res = $db->Execute($goods_sales_data_sql);
    if ($goods_sales_data_res->RecordCount() > 0) {
		$i = 1;
		while ( ! $goods_sales_data_res->EOF ) {
			
			if ( isset($_GET['id']) && $_GET['id'] == $goods_sales_data_res->fields['products_id']){
				$_GET['page'] = ceil($i / 20);
				$goods_sales_data_res->EOF = true;
			}
			$i++;
			
			$goods_sales_data_res->MoveNext();
		}
    }

    $goods_sales_data_res_split = new splitPageResults($_GET['page'], 20, $goods_sales_data_sql, $goods_sales_data_res->RecordCount());
    $res = $db->Execute($goods_sales_data_sql);
    //求出美元和人民币之间的汇率

    $currency_query = $db->Execute('select configuration_value from ' . TABLE_CONFIGURATION . ' where configuration_key = "MODULE_SHIPPING_CHIANPOST_CURRENCY"');
    $currency = $currency_query->fields['configuration_value']; 

	if ($res->RecordCount() > 0) {
        
        
		while ( !$res->EOF ) { 
      $status = $res->fields['products_status'];
        if($status == 0 || $status == 10){
            $status = '否';
        }else{
          $status = '是';
        }
			$price = round($res->fields ['products_net_price'] * $currency,2);
            $sale_total =round($res->fields ['sale_total'] * $currency,2);
           $res_method [$res->fields ['products_id']]= array (
           	        'products_model' => $res->fields ['products_model'],
	  				'products_image' => $res->fields ['products_image'],
	  				'products_status' => $status,
	  				'categories_name' => $res->fields ['categories_name'],
	  				'price' => $price,
	  				'sale_num' => $res->fields ['sale_num'],
	  				'sale_total' => $sale_total,
	  				'sale_orders_num' => $res->fields ['sale_orders_num'],
	  				'customers_buy_num' => $res->fields ['customers_buy_num']
	  	       );
	     	$res->MoveNext();
		}
	}
	//计算上架总数
	if($starttime != '' && $stoptime != ''){
	$shangjia_num_sql = "select count(products_model) shangjia_num from " . TABLE_PRODUCTS .  $search_one ;
	$shangjia_num_res = $db->Execute($shangjia_num_sql);
	$shangjia_num = $shangjia_num_res->fields['shangjia_num'];
    }
   //计算在架总数
	if(empty($starttimes)  && empty($stoptimes)){
      $zaijia_num_sql ="select count(products_model) zaijia_num from ". TABLE_PRODUCTS ." p where p.products_status = 1  " . $search_two ;
    }else{
     $zaijia_num_sql = "select count(*) zaijia_num from (SELECT count(p.products_model)  FROM ". TABLE_PRODUCTS ." p left JOIN (" .TABLE_ORDERS_PRODUCTS . " op INNER JOIN " . TABLE_ORDERS . " o ON op.orders_id = o.orders_id) ON p.products_id = op.products_id WHERE p.products_status = 1 and orders_status in(2,3,4,10,42)  " . $search_two . " group by p.products_model) t1" ;
    }
	$zaijia_num_res = $db->Execute($zaijia_num_sql);
	$zaijia_num = $zaijia_num_res->fields['zaijia_num'];
	//计算动销总数
	if($starttimes != '' && $stoptimes != ''){
	$dongxiao_num_sql = "select count(*) dongxiao_num from (SELECT count(p.products_model)  FROM ". TABLE_PRODUCTS ." p LEFT JOIN ". TABLE_CATEGORIES_DESCRIPTION ." cd ON cd.categories_id = p.master_categories_id left JOIN (" .TABLE_ORDERS_PRODUCTS . " op INNER JOIN " . TABLE_ORDERS . " o ON op.orders_id = o.orders_id) ON p.products_id = op.products_id WHERE cd.language_id = 1 and orders_status in (2,3,4,10,42) " . $search_three . " group by p.products_model) t1";

	$dongxiao_num_res = $db->Execute($dongxiao_num_sql);
	$dongxiao_num = $dongxiao_num_res->fields['dongxiao_num'];
    }
  
}
$error = false;
$error = false;
if($starttime > $stoptime || empty($starttime) && !empty($stoptime) || empty($stoptime) && !empty($starttime)){
          
    $messageStack->add_session("请输入正确的上架时间", "error");
    zen_redirect(zen_href_link(FILENAME_GOODS_SALES_DATA, zen_get_all_get_params(array ('action', 'coupons')), 'NONSSL'));
  
        }
if($starttimes > $stoptimes || empty($starttimes) && !empty($stoptimes) || empty($stoptimes) && !empty($starttimes)){
   $messageStack->add_session("请输入正确的动销时间", "error");
    zen_redirect(zen_href_link(FILENAME_GOODS_SALES_DATA, zen_get_all_get_params(array ('action', 'coupons')), 'NONSSL'));
}

?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>商品动销数据导出</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
  <table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
     <tr>
        <td>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <!-- <td class="pageHeading" widht="100px">佣金管理</td>         	 -->
                       
          </tr>
        </table>
        </td>
      </tr>
    </td>
    <td align="right">
    	<?php
               $type_str_arr = array(array('id' => 0, 'text' => '全部商品'),
                                       array('id' => 1, 'text' => 'Preorder商品')                  
                                      );
               $status_str_arr = array(array('id' => 0, 'text' => '全部'),
                                       array('id' => 1, 'text' => '是'),
                                       array('id' => 2, 'text' => '否')
                                      );
             
            ?> 
        <form name="search" action="<?php echo zen_href_link(FILENAME_GOODS_SALES_DATA)?>" method="get">
          <table width="100%" border="0" cellspacing="5" cellpadding="0">
          	<tr><td  align="right">上架时间：<?php echo zen_draw_input_field('starttime',(isset($_GET['starttime']))?$_GET['starttime']: date('Y-m-d').' 00:00:00', "class = 'Wdate' style='width:140px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'    ") ?>&nbsp-&nbsp<?php echo zen_draw_input_field('stoptime', (isset($_GET['stoptime']))?$_GET['stoptime']: date('Y-m-d').' 23:59:59', "class = 'Wdate' style='width:140px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");;?><?php echo zen_draw_hidden_field('action' , 'search')?>&nbsp&nbsp&nbsp<span >商品类型：</span><?php echo zen_draw_pull_down_menu('type', $type_str_arr , $_GET['type'] ? $_GET['type'] : '' , 'style="width: 100px;height: 20px;"')?></td></tr>
          	<tr><td  align="right">动销时间：<?php echo zen_draw_input_field('starttimes',(isset($_GET['starttimes']))?$_GET['starttimes']: date('Y-m-d').' 00:00:00', "class = 'Wdate' style='width:140px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'    ") ?>&nbsp-&nbsp<?php echo zen_draw_input_field('stoptimes', $compare_stop_time ? $compare_stop_time : (isset($_GET['stoptimes']))?$_GET['stoptimes']: date('Y-m-d').' 23:59:59', "class = 'Wdate' style='width:140px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");;?><?php echo zen_draw_hidden_field('action' , 'search')?><?php echo zen_draw_hidden_field('action' , 'search')?>&nbsp&nbsp&nbsp<span >是否在架：</span><?php echo zen_draw_pull_down_menu('status', $status_str_arr , $_GET['status'] ? $_GET['status'] : '' , 'style="width: 100px;height: 20px;"')?></td></tr>
          	
          	<tr><td  align="right"><?php echo zen_image_submit('button_search_cn.png','Search');?></td></tr>
          </table>
          <br/>
          <span>上架总数：<?php echo $shangjia_num ? $shangjia_num :'';?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
          <span>在架总数：<?php echo $zaijia_num ? $zaijia_num :'';?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
          <span>动销总数：<?php echo $dongxiao_num ? $dongxiao_num :'';?></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        </form>
        <tr><td>
            <form  name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_GOODS_SALES_DATA,zen_get_all_get_params(array('action')) . 'action=export');?>" method="post">
			<input type="hidden" name="action" value="<?php echo $_POST['aa']?>" />
			<input type="submit" style="width:50px;height:30px" value="导出" />
			</form>
			<!-- <form  name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_GOODS_SALES_DATA,zen_get_all_get_params(array('action')) . 'action=import');?>" method="post">
			<input type="hidden" name="action" value="export" />

            <input type="file" id="xls_file" name="xls_file" style="font-size:14px;" />
            
			<input type="submit" style="width:50px;height:30px"value="导入" />
			
			
            <a href="<?php echo zen_href_link(FILENAME_GOODS_SALES_DATA,zen_get_all_get_params(array('action')) . 'action=get_template');?>" style="font-size:14px;">下载模版</a>
			</form> -->
			<form  enctype="multipart/form-data" name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_GOODS_SALES_DATA,zen_get_all_get_params(array('action')) . 'action=import');?>" method="post">
		   	<input type="hidden" name="action" value="export"/>
		    <input type="file" id="xls_file" name="xls_file" style="font-size:14px;" />

		   	<input style="width:50px;height:30px" type="submit" value="导入" />
		    
		    <a href="<?php echo zen_href_link(FILENAME_GOODS_SALES_DATA,zen_get_all_get_params(array('action')) . 'action=get_template');?>" style="font-size:14px;">下载模版</a>
		    </form>
		</td></tr>
    </td>
  </tr>

  <tr>
  	  
  	<td valign="top">
  		<table border="0" width="100%" cellspacing="0" cellpadding="0">          
          <tr>
            <td valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" width="150px" align="center">商品编号</td>
                <td class="dataTableHeadingContent" width="150px" align="center">商品图片</td>
                <td class="dataTableHeadingContent" width="150px" align="center">是否在架</td>
                <td class="dataTableHeadingContent" width="150px" align="center">类别名称</td>
                <td class="dataTableHeadingContent" width="150px" align="center">上货价（￥）</td>
                <td class="dataTableHeadingContent" width="150px" align="center">销售总组数</td>
                <td class="dataTableHeadingContent" width="150px" align="center">销售总金额（￥）</td>
                <td class="dataTableHeadingContent" width="150px" align="center">购买订单数</td>
                <td class="dataTableHeadingContent" width="150px" align="center">购买客户数</td>
              </tr>
              <?php 
              	foreach ($res_method as $method => $val){
				
              ?> 
              
              	<td class="dataTableHeadingContent" align="center"><?php echo $val['products_model']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo '<img  src="http://img.doreenbeads.com/bmz_cache/' . get_img_size($val['products_image'], 80, 80) . '" />';?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['products_status']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['categories_name']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['price']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['sale_num'] ?$val['sale_num']:'';?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['sale_total'] ?$val['sale_total']:'';?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['sale_orders_num'] ?$val['sale_orders_num']:''; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['customers_buy_num'] ?$val['customers_buy_num']:''; ?></td>
                </td>
              </tr>

          <?php } ?>
          <tr aling="left">
                    <td class="smallText" valign="top" colspan="5"><?php echo $goods_sales_data_res_split->display_count($goods_sales_data_res->RecordCount(), 20, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
                    <td class="smallText" align="right" colspan="6"><?php echo $goods_sales_data_res_split->display_links($goods_sales_data_res->RecordCount(), 20, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'orderby', 'id')) . 'orderby=' . $order_by); ?></td>
              </tr>
          </tr>
  </tr>
  </table>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>