<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: categories.php 6991 2007-09-13 01:01:24Z drbyte $
 */

  require('includes/application_top.php');
  include (DIR_FS_CATALOG . DIR_WS_CLASSES . 'language.php');
  require(DIR_WS_FUNCTIONS . 'function_discount.php');
  require(DIR_WS_FUNCTIONS . 'functions_promotion.php');
  require(DIR_WS_MODULES . 'prod_cat_header_code.php');  
  require(DIR_WS_MODULES . 'change_category_status.php');
  
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if(isset($_GET['pID'])){
	file_get_contents(HTTP_SERVER."/uploadimg.php?plist=".(int)$_GET['pID']);
	unset($_GET['pID']);
	zen_redirect(zen_href_link(FILENAME_CATEGORIES, zen_get_all_get_params()));
  }
    // Ultimate SEO URLs v2.100
	// If the action will affect the cache entries
	if (preg_match("/(insert|update|setflag)/i", $action)) {
		include_once(DIR_WS_INCLUDES . 'reset_seo_cache.php');
	}
	
  if (!isset($_SESSION['categories_products_sort_order'])) {
    $_SESSION['categories_products_sort_order'] = CATEGORIES_PRODUCTS_SORT_ORDER;
  }

  if (!isset($_GET['reset_categories_products_sort_order'])) {
    $reset_categories_products_sort_order = $_SESSION['categories_products_sort_order'];
  }
  
  if($_POST['action'] == 'remove_products'){
  	$file = $_FILES['file_remove'];
  
  	if($file['error'] || empty($file)){
  		$messageStack->add_session('Fail: 文件不能为空'.$file['name'],'error');
  		zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
  	}
  	$filename = basename($file['name']);
  	$file_ext = substr($filename, strrpos($filename, '.') + 1);
  	if($file_ext!='xlsx'&&$file_ext!='xls'){
  		$messageStack->add_session('Fail: 文件格式有误，请上传xlsx或者xls格式的文件','error');
  		zen_redirect(zen_href_link(FILENAME_CATEGORIES,  'cPath=' . $_POST['cPath']));
  	}else{
  		set_time_limit(0);
  		$messageStack->add_session('Success: File Upload saved successfully '.$filename,'success');
  
  		$error_info_array=array();
  		$file_from=$file['tmp_name'];
  		$remove_all=false;
  		$success_num = 0;
  
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
  			$remove_error = false;
  			$products_model = zen_db_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
  			$category_id = zen_db_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
  				
  			if ($products_model != ''){
  				if($category_id != '' && $category_id != 0){
  					$check_products_query = $db->Execute('select products_id , master_categories_id from ' . TABLE_PRODUCTS . ' where products_model = "' . $products_model . '" order by products_status asc limit 1');
  						
  					if($check_products_query->RecordCount() > 0){
  						$products_id = $check_products_query->fields['products_id'];
  						$master_categories_id = $check_products_query->fields['master_categories_id'];
  
  						$check_category_query = $db->Execute('select categories_id from ' . TABLE_CATEGORIES . ' where categories_id = ' . $category_id);
  
  						if($check_category_query->RecordCount() > 0){
  							if($master_categories_id != $category_id){
	  							$check_products_to_category = $db->Execute('select products_id , categories_id from ' . TABLE_PRODUCTS_TO_CATEGORIES . ' where products_id = ' . $products_id . ' and categories_id = ' . $category_id);
	  
	  							if($check_products_to_category->RecordCount() > 0){
	  								try {
	  									$remove_products_to_category = $db->Execute('delete from ' . TABLE_PRODUCTS_TO_CATEGORIES . ' WHERE products_id = ' . $products_id . ' and categories_id = ' . $category_id . ' limit 1');
	  									$success_num++;
	  									remove_product_memcache($products_id);
	  								} catch (Exception $e) {
	  									$error_info_array[] = '第  <b>'.$j.'</b> 行数据移除发生错误，移除失败。';
	  								}
	  							}else{
	  								$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号【 ' . $products_model . ' 】不在类别ID【 ' . $category_id . ' 】下。';
	  							}
  							}else{
  								$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，不能将商品从主类别下移除';
  							}
  						}else{
  							$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，类别ID【 ' . $category_id . ' 】不存在';
  						}
  					}else{
  						$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号【 ' . $products_model . ' 】不存在！';
  					}
  				}else{
  					$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，类别ID不能为空或为0。';
  				}
  			}else{
  				$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号不能为空。';
  			}
  		}
  	}
  
  	if(sizeof($error_info_array)>=1){
  		$messageStack->add_session($success_num . ' 件商品信息移除成功。','caution');
  		foreach($error_info_array as $val){
  			$messageStack->add_session($val,'error');
  		}
  		zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
  	}else{
  		$messageStack->add_session('所有商品移除成功','success');
  		zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
  	}
  }

if($_POST['action'] == 'upload_img'){
    $file = $_FILES['file_img'];

    if($file['error'] || empty($file)){
        $messageStack->add_session('Fail: 文件不能为空'.$file['name'],'error');
        zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
    }

    $filename = basename($file['name']);
    if(substr($filename, '-4') != 'xlsx' && substr($filename, '-3') != 'xls'){
        $messageStack->add_session('Fail: 文件格式有误，请上传xlsx或者xls格式的文件','error');
        zen_redirect(zen_href_link(FILENAME_CATEGORIES,  'cPath=' . $_POST['cPath']));
    }else{
        set_time_limit(0);
        //$messageStack->add_session('Success: File Upload saved successfully '.$filename,'success');
        
        $error = false;
        $error_info_array=array();
        $file_from=$file['tmp_name'];
        $success_num = 0;
        $products_model_array = array();
        
        set_include_path('../Classes/');
        include 'PHPExcel.php';
        if(substr($filename, '-4')=='xlsx'){
            include 'PHPExcel/Reader/Excel2007.php';
            $objReader = new PHPExcel_Reader_Excel2007;
        }else{
            include 'PHPExcel/Reader/Excel5.php';
            $objReader = new PHPExcel_Reader_Excel5;
        }
        $objPHPExcel = $objReader->load($file_from);
        $sheet = $objPHPExcel->getActiveSheet();

        for($j = 2; $j <= $sheet->getHighestRow (); $j ++) {
            $error = false;
            $products_model = trim ( $sheet->getCellByColumnAndRow ( 0, $j )->getValue () );

            if ($products_model == '') {
                $error = true;
                $error_info_array[] = "第". $j ."行产品编号为空";
                continue;
            }

            $check_products_model_query = $db->Execute("SELECT * FROM " . TABLE_PRODUCTS . " WHERE products_model = '". $products_model ."' ORDER BY products_id DESC LIMIT 1");
            //print_r($check_products_model_query->fields);
            if ($check_products_model_query->RecordCount() <= 0) {
                $error = true;
                $error_info_array[] = "第". $j ."行数据有误，商品编号【". $products_model ."】不存在";
                continue;
            }

            if (!$error) {
                $products_model_array[] = $products_model;
            }
        }
        
        if (sizeof($products_model_array) > 0) {

            $products_model_str = implode(',', $products_model_array);

            $url = HTTP_IMG_SERVER . 'upload_img.php?action=update_image_from_data';

            $header = array();

            $data = 'models='.$products_model_str;

            $ret = curl_post($header, $data, $url);
            $ret = json_decode($ret);

            foreach ($ret as $error){
                $messageStack->add_session( $error, 'error');
            }

            foreach($products_model_array as $value) {
                $value = trim($value);
                $product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$value."' and products_status!=10");
                if($product_query->fields['products_id']>0){
                    $image_count = intval(file_get_contents(HTTP_IMG_SERVER . 'count_product_img.php?model='.$value));
                    if($image_count > 0) {
                        $product_image_count = $db->Execute("select image_total from ".TABLE_PRODUCTS_IMAGE_COUNT." where products_id='".$product_query->fields['products_id']."'");
                        if($product_image_count->RecordCount() > 0) {
                            if($product_image_count->fields['image_total'] != $image_count) {
                                $db->Execute("update ".TABLE_PRODUCTS_IMAGE_COUNT." set image_total=" . $image_count . ", last_modify_time=now() where products_id=".$product_query->fields['products_id']);
                                $operationLog = "商品图片数量 变更: from " . $product_image_count->fields['image_total'] . " to " . $image_count . "";
                                zen_insert_operate_logs($_SESSION ['admin_id'], $value, $operationLog, 2);
                                
                                $success_num++;
                            } else {
                                echo $value.' ---无更新<br/>';
                            }
                        } else {
                            $sql_data_array = array(
                                'products_id' => $product_query->fields['products_id'],
                                'image_total' => $image_count,
                                'last_modify_time' => 'now()'
                            );
                            zen_db_perform(TABLE_PRODUCTS_IMAGE_COUNT, $sql_data_array);
                            $operationLog = "商品图片数量 变更: from 0 to " . $image_count . "";
                            zen_insert_operate_logs($_SESSION ['admin_id'], $value, $operationLog, 2);
                            $success_num++;
                        }
                        remove_product_memcache($product_query->fields['products_id']);
                    }   
                    
                }else{
                    echo $value.' --- 不存在<br/>';
                }
            }
        }
        if(sizeof($error_info_array)>=1){
            $messageStack->add_session($success_num . ' 件商品修改成功','caution');
            foreach($error_info_array as $val){
                $messageStack->add_session($val,'error');
            }
            zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
        }else{
            $messageStack->add_session('所有商品修改成功','success');
            zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
        }
    }
}

if($_POST['action'] == 'upload_status'){
    
    $file = $_FILES['file_status'];

    if($file['error'] || empty($file)){
        $messageStack->add_session('Fail: 文件不能为空'.$file['name'],'error');
        zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
    }

    $filename = basename($file['name']);
    if(substr($filename, '-4') != 'xlsx' && substr($filename, '-3') != 'xls'){
        $messageStack->add_session('Fail: 文件格式有误，请上传xlsx或者xls格式的文件','error');
        zen_redirect(zen_href_link(FILENAME_CATEGORIES,  'cPath=' . $_POST['cPath']));
    }else{
        set_time_limit(0);
        $messageStack->add_session('Success: File Upload saved successfully '.$filename,'success');
        
        $error = false;
        $error_info_array=array();
        $file_from=$file['tmp_name'];
        $success_num = 0;
        
        set_include_path('../Classes/');
        include 'PHPExcel.php';
        if(substr($filename, '-4')=='xlsx'){
            include 'PHPExcel/Reader/Excel2007.php';
            $objReader = new PHPExcel_Reader_Excel2007;
        }else{
            include 'PHPExcel/Reader/Excel5.php';
            $objReader = new PHPExcel_Reader_Excel5;
        }
        $objPHPExcel = $objReader->load($file_from);
        $sheet = $objPHPExcel->getActiveSheet();
        
        for($j=3;$j<=$sheet->getHighestRow();$j++){
            $products_id = 0;
            $error = false;
            $products_model = zen_db_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
            $new_products_status = (int)zen_db_input($sheet->getCellByColumnAndRow(1,$j)->getValue());

            if ($products_model == '') {
                $error = true;
                $error_info_array[] = "第". $j ."行产品编号为空";
                continue;
            }

            if (!in_array($new_products_status, array(0, 10))) {
                $error = true;
                $error_info_array[] = "第". $j ."行数据有误，状态不存在";
                continue;
            }

            $check_products_model_query = $db->Execute("SELECT * FROM " . TABLE_PRODUCTS . " WHERE products_model = '". $products_model ."' ORDER BY products_id DESC LIMIT 1");
            //print_r($check_products_model_query->fields);
            if ($check_products_model_query->RecordCount() <= 0) {
                $error = true;
                $error_info_array[] = "第". $j ."行数据有误，商品编号【". $products_model ."】不存在";
                continue;
            }else{
                $products_id = $check_products_model_query->fields['products_id'];
                $old_products_status = $check_products_model_query->fields['products_status'];
                if ( $old_products_status == $new_products_status ) {
                    $error = true;
                    $error_info_array[] = "第". $j ."行数据有误,商品编号【". $products_model ."】已处于". $new_products_status ."状态";
                    continue;
                }
            }

            if ( !$error && $products_id != 0 ) {
                try {
                    $update_products_status_array = array('products_status' => $new_products_status);
                    zen_db_perform(TABLE_PRODUCTS, $update_products_status_array,'update', "products_id='".$products_id."'");
//                    if($new_products_status != 1){
//                    	zen_auto_update_promotion_products_status($products_id);
//                    }else{
//                        zen_auto_update_promotion_products_status($products_id, true);
//                    }
                    remove_product_memcache($products_id);
                    $operate_content = $products_model . '商品状态变更： ' . $old_products_status . '  变为 ' . $new_products_status;
                    zen_insert_operate_logs ( $_SESSION ['admin_id'], $products_model, $operate_content, 2 );
                    $success_num++;
                } catch (Exception $e) {
                    $error_info_array[] = '第  <b>'.$j.'</b> 行数据移除发生错误，移除失败。';
                }
            }
        }
    }

    if(sizeof($error_info_array)>=1){
        $messageStack->add_session($success_num . ' 件商品修改成功','caution');
        foreach($error_info_array as $val){
            $messageStack->add_session($val,'error');
        }
        zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
    }else{
        $messageStack->add_session('所有商品修改成功','success');
        zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
    }
}

function zen_get_products_to_categories_path($cid, $array = array()) {
  global $db;
  global $all_cate_array;
  $array [] = $cid;
  if ($all_cate_array [$cid] ['parent']) {
    return zen_get_products_to_categories_path ( $all_cate_array [$cid] ['parent'], $array );
  } else {
    $array = array_reverse ( $array );
    $length = 5;
    for($i = sizeof ( $array ); $i <= $length; $i ++) {
      $array [$i] = 0;
    }
    return implode ( ',', $array );
  }
}
function zen_get_all_cate_array() {
  global $db;
  $get_all_cate_array = array ();
  $get_all_cate_query = "select c.categories_id,c.parent_id from " . TABLE_CATEGORIES . " c   where  categories_status=1 order by  categories_id ";
  $get_all_cate = $db->Execute ( $get_all_cate_query );
  if ($get_all_cate->RecordCount () > 0) {
    while ( ! $get_all_cate->EOF ) {
      $get_all_cate_array [$get_all_cate->fields ['categories_id']] = array (
          'id' => $get_all_cate->fields ['categories_id'],
          'parent' => $get_all_cate->fields ['parent_id'] 
      );
      $get_all_cate->MoveNext ();
    }
  }
  return $get_all_cate_array;
}
//error_reporting(E_ALL^E_NOTICE);
if($_POST['action'] == 'update_products'){
  
  $file = $_FILES['file_update_products'];

  if($file['error'] || empty($file)){
    $messageStack->add_session('Fail: 文件不能为空'.$file['name'],'error');
    zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
  }

  $filename = basename($file['name']);
  if(substr($filename, '-4') != 'xlsx' && substr($filename, '-3') != 'xls'){
    $messageStack->add_session('Fail: 文件格式有误，请上传xlsx或者xls格式的文件','error');
    zen_redirect(zen_href_link(FILENAME_CATEGORIES,  'cPath=' . $_POST['cPath']));
  }else{
    set_time_limit(0);
    $startime=microtime(true);
    $messageStack->add_session('Success: File Upload saved successfully '.$filename,'success');
    
    $error = false;
    $error_info_array=array();
    $file_from=$file['tmp_name'];
    $success_num = 0;
    
    set_include_path('../Classes/');
    include 'PHPExcel.php';
    if(substr($filename, '-4')=='xlsx'){
      include 'PHPExcel/Reader/Excel2007.php';
      $objReader = new PHPExcel_Reader_Excel2007;
    }else{
      include 'PHPExcel/Reader/Excel5.php';
      $objReader = new PHPExcel_Reader_Excel5;
    }
    $objPHPExcel = $objReader->load($file_from);
    $sheet = $objPHPExcel->getActiveSheet();
    $all_products_array = array();
    $error_array = array();
    $category_array = array();
    $category_path_array = array();
    $all_cate_array = array();
    $all_cate_array = zen_get_all_cate_array ();
    $products_model_array = array();

    for($j = 4; $j <= $sheet->getHighestRow (); $j ++) {
      $is_club=1;
      $ru_club=1;
      $is_not_shipping_discount = 0;
      $products_name = array();
      $update_data = true;

      $category_code = trim ( $sheet->getCellByColumnAndRow ( 0, $j )->getValue () );
      $category_code = str_replace("'", "", $category_code);
      $products_model = trim ( $sheet->getCellByColumnAndRow ( 1, $j )->getValue () );
      $products_price = trim ( $sheet->getCellByColumnAndRow ( 2, $j )->getValue () );
      $products_without_desciption = trim ( $sheet->getCellByColumnAndRow ( 3, $j )->getValue () );
      $price_level = trim ( $sheet->getCellByColumnAndRow ( 4, $j )->getValue () );
      $products_weight = trim ( $sheet->getCellByColumnAndRow ( 5, $j )->getValue () );
      $products_weight_volume = zen_db_prepare_input ( trim ( $sheet->getCellByColumnAndRow ( 6, $j )->getValue () ) );
      $products_property = trim ( $sheet->getCellByColumnAndRow ( 7, $j )->getValue () );
      $products_name[1] = trim ( $sheet->getCellByColumnAndRow ( 8, $j )->getValue () );
      $products_name[2] = trim ( $sheet->getCellByColumnAndRow ( 10, $j )->getValue () );
      $products_name[3] = trim ( $sheet->getCellByColumnAndRow ( 12, $j )->getValue () );
      $products_name[4] = trim ( $sheet->getCellByColumnAndRow ( 14, $j )->getValue () );
      $products_name[5] = trim ( $sheet->getCellByColumnAndRow ( 16, $j )->getValue () );
      $products_name[6] = trim ( $sheet->getCellByColumnAndRow ( 20, $j )->getValue () );
      $products_name[7] = trim ( $sheet->getCellByColumnAndRow ( 18, $j )->getValue () );
      $limit_stock = trim ( $sheet->getCellByColumnAndRow ( 22, $j )->getValue () );
      $products_quantity = trim ( $sheet->getCellByColumnAndRow (23, $j )->getValue () );
      $per_quantity = trim ( $sheet->getCellByColumnAndRow (24, $j )->getValue () );
      $per_unit = trim ( $sheet->getCellByColumnAndRow (25, $j )->getValue () );
      $is_mixed = (int)trim ( $sheet->getCellByColumnAndRow (27, $j )->getValue () );

      if( $products_weight > 50 || $products_weight_volume > 50 ){
        $is_club=0;
      }
      if($products_weight > 50){
        $ru_club=0;
      }
      if(substr($category_code,0,4)=='0120' || substr($category_code,0,4)=='0504' || substr($category_code,0,2)=='04'){
        $is_not_shipping_discount = 1;
      }

      if ($update_data) {
          $products_id = array();
          $price_manager_id = 0;
          $products_sql = 'select products_id, price_manager_id from  ' . TABLE_PRODUCTS . ' where products_model = "' . $products_model . '" and products_status != 10';
          $products = $db->Execute ( $products_sql );
          if ($products->RecordCount () <= 0) {
              $update_data = false;
              $error_array [] = '第' . $j . '行 ，产品编号不存在' . "\n";
          }else{
              while(!$products->EOF){
                  $price_manager_id = $products->fields['price_manager_id'];
                  $products_id[] = $products->fields['products_id'];
                  $products->MoveNext();
              }
          }

      }

      if ($update_data) {
          if (! $products_price || $products_price < 0.1) {
              $update_data = false;
              $error_array [] = '第' . $j . '行 ，上货价格有问题' . "\n";
          } else {
              if(!(substr($products_model, -1) == 'H' || substr($products_model, -1) == 'Q') && $price_manager_id > 0) {
                  $up_proportion_query = $db->Execute('select price_manager_id, price_manager_value from ' . TABLE_PRICE_MANAGER . ' where price_manager_id = ' . $price_manager_id );
                  if ($up_proportion_query->RecordCount() > 0) {
                      $up_proportion = (int)$up_proportion_query->fields['price_manager_value'];

                      $price_after_manager = $products_price * (1 + $up_proportion / 100);
                  }
              }else{
                  $price_manager_id = 0;
                  $price_after_manager = $products_price;
              }
          }
      }

      if ($update_data) {
        if (! $price_level) {
          $update_data = false;
          $error_array [] = '第' . $j . '行 ，价格梯段有问题' . "\n";
        }
      }
      
      if ($update_data) {
        if (! $products_weight) {
          $update_data = false;
          $error_array [] = '第' . $j . '行 ，产品重量有问题' . "\n";
        }
      }

      if ($update_data) {
        if ($products_name[1]=='') {
          $update_data = false;
          $error_array [] = '第' . $j . '行 ，英语产品名字为空' . "\n";
        }
      }
      if ($update_data) {
        if ($products_name[2]=='') {
          $update_data = false;
          $error_array [] = '第' . $j . '行 ，德语产品名字为空' . "\n";
        }
      }
      if ($update_data) {
        if ($products_name[3]=='') {
          $update_data = false;
          $error_array [] = '第' . $j . '行 ，俄语产品名字为空' . "\n";
        }
      }
      if ($update_data) {
        if ($products_name[4]=='') {
          $update_data = false;
          $error_array [] = '第' . $j . '行 ，法语产品名字为空' . "\n";
        }
      }

      if ($update_data) {
        if (! $per_quantity) {
          $update_data = false;
          $error_array [] = '第' . $j . '行 ，每组数量为空' . "\n";
        }
      }

      if ($update_data) {
        if (! $per_unit) {
          $update_data = false;
          $error_array [] = '第' . $j . '行 ，计量单位为空' . "\n";
        }
      }


      if ($update_data) {
        $sql_data_array = array (
            'products_net_price' => $products_price,
            'products_weight' => $products_weight,
            'products_volume_weight' => $products_weight_volume,
            'products_status' => 1,
            'products_quantity_order_min' => 1,
            'products_limit_stock' => $limit_stock,
            'products_quantity_mixed' => 1,
            'products_discount_type' => 1,
            'products_discount_type_from' => 1,
            'products_sort_order' => 1000,
            'product_price_times' => $price_level,
            'products_price_sorter' => $products_price,
            'products_last_modified' => date ( 'Y-m-d H:i:s' ),
            'price_manager_id' => $price_manager_id,
            'is_mixed' => $is_mixed
        );
        foreach ($products_id as $key => $value) {
          zen_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . (int)$value . "'");
          zen_refresh_products_price ( $value, $price_after_manager, $products_weight, 0, $price_level, false, '', array('insert' => false, 'record_log' => true, 'batch_update' => false, 'currrency_last_modified' => null) );
        }

        $operate_content= '商品被编辑 products_price: '.$products_price .', product_price_times: '. $price_level . __FILE__ .' IN LINE '.__LINE__;
        zen_insert_operate_logs($_SESSION['admin_id'],$products_model,$operate_content,2);

        for($lang=1;$lang<=5;$lang++){
          $products_name_str=$products_name[$lang];
          if($products_name_str==''){
            $products_name_str=$products_name[1];
          }
          
          if($lang == 1 && $products_without_desciption != '') {
              //是否存在这个tag
              $time = date('Y-m-d H:i:s');
              $result = $db->Execute('select tag_id from ' . TABLE_PRODUCTS_NAME_WITHOUT_CATG . ' where products_name_without_catg="' . zen_db_prepare_input(trim(addslashes($products_without_desciption))) . '"');
              $tag_id = 0;
              if($result->RecordCount() > 0) {
                  $tag_id = $result->fields['tag_id'];
              } else {
                  $sql_data_tag = array(
                      'products_name_without_catg' => zen_db_prepare_input(trim($products_without_desciption)),
                      'created' => $time,
                  );
                  zen_db_perform(TABLE_PRODUCTS_NAME_WITHOUT_CATG, $sql_data_tag);
                  $tag_id = $db->insert_ID();
              }
          
              $sql_data_relation = array(
                  'tag_id' => $tag_id,
                  'created' => $time,
              );
              foreach ($products_id as $key => $value) {
                  zen_db_perform(TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION, $sql_data_relation, 'update', "products_id = '" . (int)$value . "'");
              }
          }
          
          $sql_data_array_description = array('products_name' => zen_db_prepare_input($products_name_str),
                        'products_name_without_catg' => zen_db_prepare_input($products_without_desciption));
          foreach ($products_id as $key => $value) {
            zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array_description, 'update', "products_id = '" . (int)$value . "' and language_id = " . $lang);
          }
        }
        
        foreach ($products_id as $key => $value) {
          remove_product_memcache($value);
        }
      }
      
    }

    if(sizeof($error_array)){
      $logs_from='../products/logs/';
      $logs_name='error_log';
      $logs_file=$logs_from.$logs_name;
      if(file_get_contents($logs_file)==''){
        file_put_contents($logs_file, "更新产品信息日志\n",FILE_APPEND);
      }
      file_put_contents($logs_file, "\n\n".'--- 开始时间:'.date('Y-m-d H:i:s',$startime).' ---'."\n",FILE_APPEND);
      foreach($error_array as $number){
        file_put_contents($logs_file, $number,FILE_APPEND);
        $messageStack->add_session ( $number, 'error' );
      }
      $messageStack->add_session ( '<a href="'.$logs_file.'">查看所有错误志</a>', 'success' );
      $endtime=microtime(true);
      file_put_contents($logs_file, '用时: '.round(($endtime-$startime),2).' (s)'."\n",FILE_APPEND);
      file_put_contents($logs_file, '------ END ------'."\n",FILE_APPEND);
    }else{
      $messageStack->add_session ( '全部数据更新完成', 'success' );
    }
        zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
  }
}
if(isset($_POST['action']) && $_POST['action'] == 'move_category'){
	if(! isset($_FILES['file_remove']) || ! $_FILES['file_remove']){
		$messageStack->add_session ( 'please upload a xlsx file!', 'error' );
	}else{
		set_time_limit(0);
		$file = $_FILES['file_remove'];
		$filename = basename($file['name']);
		$file_ext = substr($filename, strrpos($filename, '.') + 1);
		$messageStack->add_session('Success: File Upload saved successfully '.$filename,'success');

		$error_info_array=array();
		$file_from=$file['tmp_name'];
		$remove_all=false;
		$success_num = 0;

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

		$cnt = 0;
		$categoryIds = $categoryPaths = array();
		for($j=2; $j<=$sheet->getHighestRow(); $j++){
			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$old_ccode = zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());
			$new_ccode = zen_db_prepare_input($sheet->getCellByColumnAndRow(2,$j)->getValue());

			if($model == '' || $old_ccode == '' || $new_ccode == '' || $old_ccode == 0 || $new_ccode == 0){
				continue;
			}
			if(isset($categoryIds[$old_ccode])){
				$old_cid = zen_db_prepare_input($categoryIds[$old_ccode]);
			}else{
				$c_query = $db->Execute("select categories_id from ".TABLE_CATEGORIES." where categories_code='".$old_ccode."'");
				if($c_query->RecordCount()>0){
					$old_cid = $c_query->fields['categories_id'];
					$categoryIds[$old_ccode] = $c_query->fields['categories_id'];
				}else{
					$error_info_array[] = "第 $j 行移出产品线号" . $old_ccode." 不存在<br/>";
					continue;
				}

			}

			if(isset($categoryIds[$new_ccode])){
				$new_cid = zen_db_prepare_input($categoryIds[$new_ccode]);
			}else{
				$c_query = $db->Execute("select categories_id from ".TABLE_CATEGORIES." where categories_code='".$new_ccode."'");
				if($c_query->RecordCount()>0){
					$new_cid = $c_query->fields['categories_id'];
					$categoryIds[$new_ccode] = $c_query->fields['categories_id'];
				}else{
					$error_info_array[] = "第 $j 行移入产品线号" . $new_ccode." 不存在<br/>";
					continue;
				}
			}
				
			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
			if($product_query->fields['products_id']>0 && $new_cid>0){
			    $products_id = $product_query->fields['products_id'];
			    $products_to_category_check = $db->Execute('select products_id from ' . TABLE_PRODUCTS_TO_CATEGORIES . ' where categories_id = ' . $old_cid .' and products_id = ' . $products_id);
				if($products_to_category_check->RecordCount() > 0){
				    $db->Execute("update ".TABLE_PRODUCTS." set master_categories_id=".(int)$new_cid." where products_id=".$products_id);
				    $db->Execute("delete from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$products_id." and categories_id=".(int)$old_cid);
				    $check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$products_id." and categories_id=".(int)$new_cid);
					
					if($check_exist->RecordCount()==0){
					    move_products_to_new_categories($products_id, $new_cid);
					    $cnt++;
					    //分类关系表对应关系判断
					    $check_result  = $db->Execute("select * from ".TABLE_CATEGORIES_RELATION." where common_categories_id=".$new_cid." and status = 1 limit 1");
					    
					    if($check_result->RecordCount()>0){
					        $relation_ids = explode(',', $check_result->fields['recommend_categories_id']);
					        
					        foreach ($relation_ids as $ids){
					            $check_products_to_category_query = $db->Execute('select products_id from ' . TABLE_PRODUCTS_TO_CATEGORIES . ' where products_id =' . $products_id . ' and categories_id =' . $ids);
					            
					            if($check_products_to_category_query->RecordCount() == 0){
					                move_products_to_new_categories($products_id, $ids);
					            }
					        }
					    }
					}
					remove_product_memcache($products_id);
				}else{
					$error_info_array[] = "第 $j 行商品不属于对应移出产品线。";
					continue;
				}
			}else{
				$error_info_array[] = "第 $j 行" . $model." 不存在";
				continue;
			}
		}

		if(sizeof($error_info_array) >= 1){
			$messageStack->add_session($cnt . ' 条数据上传成功','caution');
			foreach($error_info_array as $val){
				$messageStack->add_session($val,'error');
			}
		}else{
			$messageStack->add_session('所有商品移动成功','success');
		}
		zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
	}
}

if(isset($_POST['action']) && $_POST['action'] == 'add_category'){
	if(! isset($_FILES['file_remove']) || ! $_FILES['file_remove']){
		$messageStack->add_session ( 'please upload a xlsx file!', 'error' );
	}else{
		set_time_limit(0);
		$file = $_FILES['file_remove'];
		$filename = basename($file['name']);
		$file_ext = substr($filename, strrpos($filename, '.') + 1);
		$messageStack->add_session('Success: File Upload saved successfully '.$filename,'success');

		$error_info_array=array();
		$file_from=$file['tmp_name'];
		$remove_all=false;
		$success_num = 0;

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

		$cnt = 0;
		$categoryIds = $categoryPaths = array();
		for($j=2; $j<=$sheet->getHighestRow(); $j++){
			$model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0,$j)->getValue());
			$new_cid= zen_db_prepare_input($sheet->getCellByColumnAndRow(1,$j)->getValue());

			if($model == '' || $new_cid == '' || $new_cid == 0){
				continue;
			}
			$cpid = array_reverse(getParent($new_cid, array()));
			$first = zen_db_prepare_input(isset($cpid[0]) ? $cpid[0] : 0);
			$second = zen_db_prepare_input(isset($cpid[1]) ? $cpid[1] : 0);
			$third = zen_db_prepare_input(isset($cpid[2]) ? $cpid[2] : 0);
			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
			if($product_query->fields['products_id']>0 && $new_cid>0){
				$category_check = $db->Execute('select categories_id from ' . TABLE_CATEGORIES . ' where categories_id = ' . $new_cid);
				if($category_check->RecordCount() > 0){
					$check_exist = $db->Execute("select products_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$product_query->fields['products_id']." and categories_id=".(int)$new_cid);
					
					if($check_exist->RecordCount()==0){
						$p2c_data = array(
								'products_id'=>$product_query->fields['products_id'],
								'categories_id'=>(int)$new_cid,
								'first_categories_id'=>(int)$first,
								'second_categories_id'=>(int)$second,
								'three_categories_id'=>(int)$third
						);
						zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $p2c_data);
						remove_product_memcache($product_query->fields['products_id']);
						$cnt++;
					}else{
						$error_info_array[] = "第 $j 行商品已在此类别下。";
						continue;
					}
				}else{
					$error_info_array[] = "第 $j 行类别不存在。";
					continue;
				}
			}else{
				$error_info_array[] = "第 $j 行商品不存在。";
				continue;
			}
		}

		if(sizeof($error_info_array) >= 1){
			$messageStack->add_session($cnt . ' 条数据上传成功','caution');
			foreach($error_info_array as $val){
				$messageStack->add_session($val,'error');
			}
		}else{
			$messageStack->add_session('所有商品添加成功','success');
		}
		zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
	}
}

if(isset($_POST['action']) && $_POST['action'] == 'my_products'){
	if(! isset($_FILES['file_remove']) || ! $_FILES['file_remove']){
		$messageStack->add_session ( 'please upload a xlsx file!', 'error' );
	}else{
		set_time_limit(0);
		$file = $_FILES['file_remove'];
		$filename = basename($file['name']);
		$file_ext = substr($filename, strrpos($filename, '.') + 1);
		$messageStack->add_session('Success: File Upload saved successfully '.$filename,'success');

		$cnt=0;
		$fp = fopen($_FILES['file_remove']['tmp_name'], 'r');
		$customer_query = $db->Execute('select customers_id from '.TABLE_CUSTOMERS.' where customers_email_address="fenghuan.chen@panduo.com.cn"');
		$cid = intval($customer_query->fields['customers_id']);
		$data = fgetcsv($fp);
		$j = 1;
		while($data = fgetcsv($fp)){
			$model = trim($data[0]);
			$customers_email = trim($data[1]);
			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."'");
			if($product_query->fields['products_id']>0){
				$customer_query = $db->Execute('select customers_id from '.TABLE_CUSTOMERS.' where customers_email_address="' . $customers_email . '"');
				if($customer_query->RecordCount() > 0){
					$cid = intval($customer_query->fields['customers_id']);
					$coupon_data_array = array(
							'products_id'=>intval($product_query->fields['products_id']),
							'customers_id'=>$cid
					);
					zen_db_perform(TABLE_MY_PRODUCTS, $coupon_data_array);
					$db->Execute("update ".TABLE_PRODUCTS." set products_status = 0  where products_id='".$product_query->fields['products_id']."'");
					remove_product_memcache($product_query->fields['products_id']);
					$cnt++;
				}else{
					$error_info_array[] = "第 $j 行" . $customers_email." 客户邮箱不存在";
					continue;
				}
			}else{
				$error_info_array[] = "第 $j 行" . $model." 不存在";
				continue;
			}
			$j++;
		}
		fclose($fp);

		if(sizeof($error_info_array) >= 1){
			$messageStack->add_session($cnt . ' 条数据上传成功','caution');
			foreach($error_info_array as $val){
				$messageStack->add_session($val,'error');
			}
		}else{
			$messageStack->add_session('所有商品操作成功','success');
		}
		zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
	}
}

if(isset($_POST['action']) && $_POST['action'] == 'clear_memcache'){
	if(! isset($_FILES['file_remove']) || ! $_FILES['file_remove']){
		$messageStack->add_session ( 'please upload a xlsx file!', 'error' );
	}else{
		$cnt=0;
		$fp = fopen($_FILES['file_remove']['tmp_name'], 'r');
		$j = 1;
		while($data = fgetcsv($fp)){
			$model = trim($data[0]);
			if($model == '') continue;

			$product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."' and products_status != 10");
			if($product_query->fields['products_id']>0){
				remove_product_memcache($product_query->fields['products_id']);
				$cnt++;
			}else{
				$error_info_array[] = "第 $j 行" . $model." 不存在";
				continue;
			}
			$j++;
		}
		fclose($fp);

		if(sizeof($error_info_array) >= 1){
			$messageStack->add_session($cnt . ' 条数据上传成功','caution');
			foreach($error_info_array as $val){
				$messageStack->add_session($val,'error');
			}
		}else{
			$messageStack->add_session('所有商品操作成功','success');
		}
		zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
	}
}

if(isset($_POST['action']) && $_POST['action'] == 'products_display'){
    if(! isset($_FILES['products_display']) || ! $_FILES['products_display']){
        $messageStack->add_session ( 'please upload a xlsx file!', 'error' );
    }else{
        $cnt=0;
        $fp = fopen($_FILES['products_display']['tmp_name'], 'r');
        $j = 1;
        while($data = fgetcsv($fp)){
            $model = trim($data[0]);
            $is_display = trim($data[1]);
            if($model == ''){
                $j++;
                continue;
            }

            $product_query = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_model='".$model."' and products_status != 10");
            if($product_query->fields['products_id']>0){
                $db->Execute("update ".TABLE_PRODUCTS." set is_display = " . $is_display . "  where products_id='".$product_query->fields['products_id']."'");
                remove_product_memcache($product_query->fields['products_id']);
                $cnt++;
            }else{
                $error_info_array[] = "第 $j 行" . $model." 不存在";
            }
            $j++;
        }
        fclose($fp);

        if(sizeof($error_info_array) >= 1){
            $messageStack->add_session($cnt . ' 条数据上传成功','caution');
            foreach($error_info_array as $val){
                $messageStack->add_session($val,'error');
            }
        }else{
            $messageStack->add_session('所有商品操作成功','success');
        }
        zen_redirect(zen_href_link(FILENAME_CATEGORIES,  $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
    }
}

  if (zen_not_null($action)) {
    switch ($action) {
      case 'set_categories_products_sort_order':
      $_SESSION['categories_products_sort_order'] = $_GET['reset_categories_products_sort_order'];
      $action='';
      zen_redirect(zen_href_link(FILENAME_CATEGORIES,  'cPath=' . $_GET['cPath'] . ((isset($_GET['pID']) and !empty($_GET['pID'])) ? '&pID=' . $_GET['pID'] : '') . ((isset($_GET['page']) and !empty($_GET['page'])) ? '&page=' . $_GET['page'] : '')));
      break;
      case 'set_editor':
      // Reset will be done by init_html_editor.php. Now we simply redirect to refresh page properly.
      $action='';
      zen_redirect(zen_href_link(FILENAME_CATEGORIES,  'cPath=' . $_GET['cPath'] . ((isset($_GET['pID']) and !empty($_GET['pID'])) ? '&pID=' . $_GET['pID'] : '') . ((isset($_GET['page']) and !empty($_GET['page'])) ? '&page=' . $_GET['page'] : '')));
      break;

      case 'viewProNoCate':
			$as_categories_id=$_GET['cID'];
			$products_has_no_cate_array=array();
			zen_set_time_limit(600);
			$categories = zen_get_category_tree($as_categories_id, '', '0', '', true);	
			
			if ($categories != 0){
			for ($i=0, $n=sizeof($categories); $i<$n; $i++) {										
				//echo $categories[$i]['id']."<br>";
					$check_change_status_query='select p.products_id, p.products_status,p.products_model from '.TABLE_PRODUCTS_TO_CATEGORIES.' ptc, '.TABLE_PRODUCTS.' p  where categories_id='. $categories[$i]['id'].' and p.products_id=ptc.products_id ';
					$check_change_status=$db->Execute($check_change_status_query);
					if($check_change_status->RecordCount()>0){
						
						while(!$check_change_status->EOF){
							if($check_change_status->fields['products_status']==1){
								
								$check_pro_status_query='select p.products_id  from '.TABLE_PRODUCTS.' p, '.TABLE_PRODUCTS_TO_CATEGORIES.' ptc , '.TABLE_CATEGORIES.' c  where p.products_id=ptc.products_id  and c.categories_id=ptc.categories_id  and ptc.products_id='.$check_change_status->fields['products_id'].'  and p.products_status=1 and ptc.categories_id <> '.$categories[$i]['id'].' and c.categories_status=1';
								$check_pro_status=$db->Execute($check_pro_status_query);								
								if($check_pro_status->RecordCount()==0){
									//echo $check_change_status->fields['products_id']."<br>";
									$products_has_no_cate_array[$check_change_status->fields['products_id']]=$check_change_status->fields['products_model'];
								}								
							}
							
							$check_change_status->MoveNext();
						}
					}				
				
			}
			//print_r($products_has_no_cate_array);exit;
		}
			break;
		case 'update_category_status':			
			// disable category and products including subcategories
			if (isset($_POST['categories_id']) && $_POST['categories_id'] != '') {
				$categories_id = zen_db_prepare_input($_POST['categories_id']);
				$categories_status = zen_db_prepare_input($_POST['categories_status']);
				$products_status = isset($_POST['set_products_status'])?zen_db_prepare_input($_POST['set_products_status']):'';
				
				$return_array= control_cate_status($categories_id, $categories_status, $products_status);
				remove_categores_memcache_by_categories_id($categories_id);
				//var_dump($return_array);exit;
				$change_category_status_return=$return_array[1];
				
				for($i = 0; $i < sizeof($change_category_status_return); $i++){
					if(isset($change_category_status_return[$i]['error']) && $change_category_status_return[$i]['error'] != ''){
						$messageStack->add_session($change_category_status_return[$i]['error'], 'warning');
					}
				}				
				if($categories_status==1){
					$operate_content= '类别被隐藏';
         		    //zen_insert_operate_logs($_SESSION['admin_id'],$categories_id,$operate_content,3);					
				}else{
					$operate_content= '类别被显示';
          			//zen_insert_operate_logs($_SESSION['admin_id'],$categories_id,$operate_content,3);
				}
			}
			if($categories_status==1){
					if($return_array[0]){
					?>
					<script>
					if(confirm('类别屏蔽成功，但有部分商品由于该类别被屏蔽而无法显示,是否查看这些商品?')){
		   			window.location.href='<?php echo zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&cID=' . $_GET['cID'].'&action=viewProNoCate');?>';						 								
					}else{
	   			    window.location.href='<?php echo zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&cID=' . $_GET['cID']);?>';						 
						}
					</script>
					<?php 
				}else{
					?>
					<script>
					alert('类别屏蔽成功.');
					window.location.href='<?php echo zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&cID=' . $_GET['cID']);?>';
					</script>
					<?php 
				}}else{
				   zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&cID=' . $_GET['cID']));					
				}				
			break;

      case 'remove_type':
      $sql = "delete from " .  TABLE_PRODUCT_TYPES_TO_CATEGORY . "
              where category_id = '" . zen_db_prepare_input($_GET['cID']) . "'
              and product_type_id = '" . zen_db_prepare_input($_GET['type_id']) . "'";

      $db->Execute($sql);

      zen_remove_restrict_sub_categories($_GET['cID'], $_GET['type_id']);

      $action = "edit";
      zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'action=edit_category&cPath=' . $_GET['cPath'] . '&cID=' . zen_db_prepare_input($_GET['cID'])));
      break;
      case 'setflag':
      if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
        if (isset($_GET['pID'])) {
          zen_set_product_status($_GET['pID'], $_GET['flag']);
        }

      }

      zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&pID=' . $_GET['pID'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
      break;
      case 'insert_category':
      case 'update_category':
      if ( isset($_POST['add_type']) or isset($_POST['add_type_all']) ) {
        // check if it is already restricted
        $sql = "select * from " . TABLE_PRODUCT_TYPES_TO_CATEGORY . "
                where category_id = '" . zen_db_prepare_input($_POST['categories_id']) . "'
                and product_type_id = '" . zen_db_prepare_input($_POST['restrict_type']) . "'";
		
		$categories_level_sql = $db->Execute("Select categories_level
											   From " . TABLE_CATEGORIES . "
											  Where categories_id = '" . $cInfo->categories_id . "'");
		$categories_level = $categories_level_sql->fields['categories_level']; 		
        $type_to_cat = $db->Execute($sql);
        if ($type_to_cat->RecordCount() < 1) {
          //@@TODO find all sub-categories and restrict them as well.

          $insert_sql_data = array('category_id' => zen_db_prepare_input($_POST['categories_id']),
                                   'product_type_id' => zen_db_prepare_input($_POST['restrict_type']));

          zen_db_perform(TABLE_PRODUCT_TYPES_TO_CATEGORY, $insert_sql_data);
          /*
          // moved below so evaluated separately from current category
          if (isset($_POST['add_type_all'])) {
          zen_restrict_sub_categories($_POST['categories_id'], $_POST['restrict_type']);
          }
          */
        }
        // add product type restrictions to subcategories if not already set
        if (isset($_POST['add_type_all'])) {
          zen_restrict_sub_categories($_POST['categories_id'], $_POST['restrict_type']);
        }
        $action = "edit";
        zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'action=edit_category&cPath=' . $cPath . '&cID=' . zen_db_prepare_input($_POST['categories_id'])));
      }
      if (isset($_POST['categories_id'])) $categories_id = zen_db_prepare_input($_POST['categories_id']);
      $sort_order = zen_db_prepare_input($_POST['sort_order']);
	  $categories_level = zen_db_prepare_input($_POST['categories_level']);
	  $categories_code = zen_db_prepare_input($_POST['categories_code']);
	  $left_display = zen_db_prepare_input(($_POST['categories_display'] == '' ? 10 : $_POST['categories_display']));
	  $new_arrivals_display = zen_db_prepare_input($_POST['new_arrivals_display']);
      $sql_data_array = array('sort_order' => (int)$sort_order, 'categories_level' => (int)$categories_level, 'categories_code' => $categories_code,'left_display' => $left_display,'new_arrivals_display' => $new_arrivals_display);

      if ($action == 'insert_category') {
        $insert_sql_data = array('parent_id' => $current_category_id,
                                 'date_added' => 'now()', 'categories_level' => (int)$categories_level);

        $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

        zen_db_perform(TABLE_CATEGORIES, $sql_data_array);
       	$last_insert_id_query =  $db->Execute("select last_insert_id()");
        $categories_id = $last_insert_id_query->fields['last_insert_id()'];
        // check if [arent is restricted
        $sql = "select parent_id from " . TABLE_CATEGORIES . "
                where categories_id = '" . $categories_id . "'";

        $parent_cat = $db->Execute($sql);
        if ($parent_cat->fields['parent_id'] != '0') {
          $sql = "select * from " . TABLE_PRODUCT_TYPES_TO_CATEGORY . "
                  where category_id = '" . $parent_cat->fields['parent_id'] . "'";
          $has_type = $db->Execute($sql);
          if ($has_type->RecordCount() > 0 ) {
            while (!$has_type->EOF) {
              $insert_sql_data = array('category_id' => $categories_id,
                                       'product_type_id' => $has_type->fields['product_type_id']);
              zen_db_perform(TABLE_PRODUCT_TYPES_TO_CATEGORY, $insert_sql_data);
              $has_type->moveNext();
            }
          }
        }
      } elseif ($action == 'update_category') {
        $update_sql_data = array('last_modified' => 'now()');

        $sql_data_array = array_merge($sql_data_array, $update_sql_data);

        zen_db_perform(TABLE_CATEGORIES, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "'");
        remove_categores_memcache_by_categories_id($categories_id);
      }

      $languages = zen_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $categories_name_array = $_POST['categories_name'];
        $categories_description_array = $_POST['categories_description'];
        $language_id = $languages[$i]['id'];

        // clean $categories_description when blank or just <p /> left behind
        $sql_data_array = array('categories_name' => zen_db_prepare_input($categories_name_array[$language_id]),
                                'categories_description' => ($categories_description_array[$language_id] == '<p />' ? '' : zen_db_prepare_input($categories_description_array[$language_id])));

        if ($action == 'insert_category') {
          $insert_sql_data = array('categories_id' => $categories_id,
                                   'language_id' => $languages[$i]['id']);

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          zen_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array);
        } elseif ($action == 'update_category') {
          zen_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          remove_categores_memcache_by_categories_id((int)$categories_id);
        }
      }

      if ($_POST['categories_image_manual'] != '') {
        // add image manually
        $categories_image_name = $_POST['img_dir'] . $_POST['categories_image_manual'];
        $db->Execute("update " . TABLE_CATEGORIES . "
                      set categories_image = '" . $categories_image_name . "'
                      where categories_id = '" . (int)$categories_id . "'");
      } else {
        if ($categories_image = new upload('categories_image')) {
          $categories_image->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir']);
          if ($categories_image->parse() && $categories_image->save()) {
            $categories_image_name = $_POST['img_dir'] . $categories_image->filename;
          }
          if ($categories_image->filename != 'none' && $categories_image->filename != '' && $_POST['image_delete'] != 1) {
            // save filename when not set to none and not blank
            $db->Execute("update " . TABLE_CATEGORIES . "
                          set categories_image = '" . $categories_image_name . "'
                          where categories_id = '" . (int)$categories_id . "'");
          } else {
            // remove filename when set to none and not blank
            if ($categories_image->filename != '' || $_POST['image_delete'] == 1) {
              $db->Execute("update " . TABLE_CATEGORIES . "
                            set categories_image = ''
                            where categories_id = '" . (int)$categories_id . "'");
            }
          }
        }
      }
      remove_categores_memcache_by_categories_id((int)$categories_id);
      zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id));
      break;

      // bof: categories meta tags
      case 'update_category_meta_tags':
      // add or update meta tags
      //die('I SEE ' . $action . ' - ' . $_POST['categories_id']);
      $categories_id = $_POST['categories_id'];
      $languages = zen_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $language_id = $languages[$i]['id'];
        $check = $db->Execute("select *
                               from " . TABLE_METATAGS_CATEGORIES_DESCRIPTION . "
                               where categories_id = '" . (int)$categories_id . "'
                               and language_id = '" . (int)$language_id . "'");
        if ($check->RecordCount() > 0) {
          $action = 'update_category_meta_tags';
        } else {
          $action = 'insert_categories_meta_tags';
        }

        $sql_data_array = array('metatags_title' => zen_db_prepare_input($_POST['metatags_title'][$language_id]),
                                'metatags_keywords' => zen_db_prepare_input($_POST['metatags_keywords'][$language_id]),
                                'metatags_description' => zen_db_prepare_input($_POST['metatags_description'][$language_id]));

        if ($action == 'insert_categories_meta_tags') {
          $insert_sql_data = array('categories_id' => $categories_id,
                                   'language_id' => $language_id);
          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          zen_db_perform(TABLE_METATAGS_CATEGORIES_DESCRIPTION, $sql_data_array);
        } elseif ($action == 'update_category_meta_tags') {
          zen_db_perform(TABLE_METATAGS_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "' and language_id = '" . (int)$language_id . "'");
        }
      }

      zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id));
      break;
      // eof: categories meta tags

      case 'delete_category_confirm_old':
      // demo active test
      if (zen_admin_demo()) {
        $_GET['action']= '';
        $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
        zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
      }
      if (isset($_POST['categories_id'])) {
        $categories_id = zen_db_prepare_input($_POST['categories_id']);

        $categories = zen_get_category_tree($categories_id, '', '0', '', true);
        $products = array();
        $products_delete = array();

        for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
          $product_ids = $db->Execute("select products_id
                                           from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                                           where categories_id = '" . (int)$categories[$i]['id'] . "'");

          while (!$product_ids->EOF) {
            $products[$product_ids->fields['products_id']]['categories'][] = $categories[$i]['id'];
            $product_ids->MoveNext();
          }
        }

        reset($products);
        while (list($key, $value) = each($products)) {
          $category_ids = '';

          for ($i=0, $n=sizeof($value['categories']); $i<$n; $i++) {
            $category_ids .= "'" . (int)$value['categories'][$i] . "', ";
          }
          $category_ids = substr($category_ids, 0, -2);

          $check = $db->Execute("select count(*) as total
                                           from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                                           where products_id = '" . (int)$key . "'
                                           and categories_id not in (" . $category_ids . ")");
          if ($check->fields['total'] < '1') {
            $products_delete[$key] = $key;
          }
        }

        // removing categories can be a lengthy process
        zen_set_time_limit(600);
        for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
          zen_remove_category($categories[$i]['id']);
        }

        reset($products_delete);
        while (list($key) = each($products_delete)) {
          zen_remove_product($key);
        }
      }


      zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
      break;

      //////////////////////////////////
      // delete new

      case 'delete_category_confirm':
      // demo active test
      if (zen_admin_demo()) {
        $_GET['action']= '';
        $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
        zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
      }

      // future cat specific deletion
      $delete_linked = 'true';
      if ($_POST['delete_linked'] == 'delete_linked_no') {
        $delete_linked = 'false';
      } else {
        $delete_linked = 'true';
      }

      // delete category and products
      if (isset($_POST['categories_id'])) {
        $categories_id = zen_db_prepare_input($_POST['categories_id']);

        // create list of any subcategories in the selected category,
        $categories = zen_get_category_tree($categories_id, '', '0', '', true);

        zen_set_time_limit(600);

        // loop through this cat and subcats for delete-processing.
        for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
          $sql = "select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id='" . $categories[$i]['id'] . "'";
          $category_products = $db->Execute($sql);

          while (!$category_products->EOF) {
            $cascaded_prod_id_for_delete = $category_products->fields['products_id'];
            $cascaded_prod_cat_for_delete = array();
            $cascaded_prod_cat_for_delete[] = $categories[$i]['id'];
            //echo 'processing product_id: ' . $cascaded_prod_id_for_delete . ' in category: ' . $cascaded_prod_cat_for_delete . '<br>';

            // determine product-type-specific override script for this product
            $product_type = zen_get_products_type($category_products->fields['products_id']);
            // now loop thru the delete_product_confirm script for each product in the current category
            if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/delete_product_confirm.php')) {
              require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/delete_product_confirm.php');
            } else {
              require(DIR_WS_MODULES . 'delete_product_confirm.php');
            }

            // THIS LINE COMMENTED BECAUSE IT'S DONE ALREADY DURING DELETE_PRODUCT_CONFIRM.PHP:
            //zen_remove_product($category_products->fields['products_id'], $delete_linked);
            $category_products->MoveNext();
          }

          zen_remove_category($categories[$i]['id']);
          remove_categores_memcache_by_categories_id($categories[$i]['id']);

        } // end for loop
      }
      zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
      break;

      // eof delete new
      /////////////////////////////////
      // @@TODO where is delete_product_confirm

      case 'move_category_confirm':
      		if (isset($_POST['categories_id']) && ($_POST['categories_id'] != $_POST['move_to_category_id'])) {
				$categories_id = zen_db_prepare_input($_POST['categories_id']);
				$new_parent_id = zen_db_prepare_input($_POST['move_to_category_id']);
				$array_categories = zen_get_next_subcategories($categories_id);
				zen_get_parent_categories($categories_parent,$new_parent_id);
				$categories_count =  getmaxdim($array_categories);
				$categories_parent = count($categories_parent) + 1;
				$new_categories_count =  $categories_count + $categories_parent;
				if($new_categories_count > 6){
					$messageStack->add_session("error : A maximum of six categories", 'error');
					zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
				}
				$cPath_array = zen_parse_category_path(zen_get_generated_category_path_ids($categories_id));
				$current_category_id = $cPath_array[0];
				switch (count($cPath_array)){
	 			 	case 1:
	 			 		$categories_str = 'first_categories_id = ' . (int)$current_category_id . '';
	 			 		$categories_filter = ' first_categories_id ';
	 			 		 break;
	      			case 2:
	      				$categories_str = 'second_categories_id = ' . (int)$current_category_id . '';
	      				$categories_filter = ' second_categories_id ';
	      				 break;
	      			case 3:
	      				$categories_str = 'three_categories_id = ' . (int)$current_category_id . '';
	      				$categories_filter = ' three_categories_id ';
	      				 break;
	      			case 4:
	      				$categories_str = 'four_categories_id = ' . (int)$current_category_id . '';
	      				$categories_filter = ' four_categories_id ';
	      				 break;
	      			case 5:
	      				$categories_str = 'five_categories_id = ' . (int)$current_category_id . '';
	      				$categories_filter = ' five_categories_id ';
	      				 break;
	      			case 6:
	      				$categories_str = 'six_categories_id = ' . (int)$current_category_id . '';
	      				$categories_filter = ' six_categories_id ';
	      				 break;	 	 	 	 
	      			default:
	      				$categories_str = 'categories_id = ' . (int)$current_category_id . '';
	      				$categories_filter = 'categories_id ';
	      				 break;	 	 	
	 			 }
				
				$sql_products="select products_id, categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where $categories_str ";
				
				$path = explode('_', zen_get_generated_category_path_ids($new_parent_id));

				if (in_array($categories_id, $path)) {
					$messageStack->add_session(ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT, 'error');
					zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
				} else {
					$sql = "select count(*) as count from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id='" . (int)$new_parent_id . "'";
					$zc_count_products = $db->Execute($sql);
					if ( $zc_count_products->fields['count'] > 0) {
						if(count($cPath_array) > 6){
							
						}
						$messageStack->add_session(ERROR_CATEGORY_HAS_PRODUCTS, 'error');
					} else {
						$messageStack->add_session(SUCCESS_CATEGORY_MOVED, 'success');
					}
					$res=$db->Execute($sql_products);
					$db->Execute("update " . TABLE_CATEGORIES . "
                            set parent_id = '" . (int)$new_parent_id . "', last_modified = now()
                            where categories_id = '" . (int)$categories_id . "'");
					remove_categores_memcache_by_categories_id((int)$categories_id);
					// fix here - if this is a category with subcats it needs to know to loop through
					// reset all products_price_sorter for moved category products
					$reset_price_sorter = $db->Execute("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id='" . (int)$categories_id . "'");
					while (!$reset_price_sorter->EOF) {
						zen_update_products_price_sorter($reset_price_sorter->fields['products_id']);
						$reset_price_sorter->MoveNext();
					}
					if($res->RecordCount()>0){
						while (!$res->EOF){
							if(isset($res->fields['categories_id']) && $res->fields['categories_id']>0){
								zen_get_parent_categories($categories_all,$res->fields['categories_id']);
								if(count($categories_all) == 0){
									$db->Execute("update  ".TABLE_PRODUCTS_TO_CATEGORIES." set first_categories_id = ".$res->fields['categories_id'].", second_categories_id = 0,three_categories_id = 0,four_categories_id = 0,five_categories_id= 0,six_categories_id = 0  where products_id =  ".$res->fields['products_id']." AND categories_id = ".$res->fields['categories_id']."");
								}elseif(count($categories_all) == 1){
									$update_categories = " first_categories_id = $categories_all[0] , second_categories_id = ".$res->fields['categories_id'].",three_categories_id = 0,four_categories_id = 0,five_categories_id= 0,six_categories_id = 0";
								}elseif (count($categories_all) == 2){
									$update_categories = " first_categories_id = $categories_all[1],second_categories_id = $categories_all[0],three_categories_id = ".$res->fields['categories_id'].",four_categories_id = 0,five_categories_id= 0,six_categories_id = 0";
								}elseif (count($categories_all) == 3){
									$update_categories = " first_categories_id = $categories_all[2],second_categories_id = $categories_all[1],three_categories_id = $categories_all[0],four_categories_id = ".$res->fields['categories_id'].",five_categories_id= 0,six_categories_id = 0";
								}elseif (count($categories_all) == 4){
									$update_categories = " first_categories_id = $categories_all[3],second_categories_id = $categories_all[2],three_categories_id = $categories_all[1],four_categories_id = ".$categories_all[0].",five_categories_id= ".$res->fields['categories_id'].",six_categories_id = 0";
								}elseif (count($categories_all) == 5){
									$update_categories = " first_categories_id = $categories_all[4],second_categories_id = $categories_all[3],three_categories_id = $categories_all[2],four_categories_id = ".$categories_all[1].",five_categories_id= ".$categories_all[0].",six_categories_id = ".$res->fields['categories_id']."";
								}
								if($update_categories!=""){
									$db->Execute("update  ".TABLE_PRODUCTS_TO_CATEGORIES." set $update_categories  where products_id =  ".$res->fields['products_id']." AND categories_id = ".$res->fields['categories_id']."");
									unset($update_categories);
								}								
							}
							unset($categories_all);
							$res->MoveNext();
						}
						
					}
					zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $new_parent_id));
				}
			} else {
        $messageStack->add_session(ERROR_CANNOT_MOVE_CATEGORY_TO_CATEGORY_SELF . $cPath, 'error');
        zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
      }

      break;
      // @@TODO where is move_product_confirm
      // @@TODO where is insert_product
      // @@TODO where is update_product

      // attribute features
      case 'delete_attributes':
      zen_delete_products_attributes($_GET['products_id']);
      $messageStack->add_session(SUCCESS_ATTRIBUTES_DELETED . ' ID#' . $_GET['products_id'], 'success');
      $action='';

      // reset products_price_sorter for searches etc.
      zen_update_products_price_sorter($_GET['products_id']);

      zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $_GET['products_id'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
      break;

      case 'update_attributes_sort_order':
      zen_update_attributes_products_option_values_sort_order($_GET['products_id']);
      $messageStack->add_session(SUCCESS_ATTRIBUTES_UPDATE . ' ID#' . $_GET['products_id'], 'success');
      $action='';
      zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $_GET['products_id'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
      break;

      // attributes copy to product
      case 'update_attributes_copy_to_product':
      $copy_attributes_delete_first = ($_POST['copy_attributes'] == 'copy_attributes_delete' ? '1' : '0');
      $copy_attributes_duplicates_skipped = ($_POST['copy_attributes'] == 'copy_attributes_ignore' ? '1' : '0');
      $copy_attributes_duplicates_overwrite = ($_POST['copy_attributes'] == 'copy_attributes_update' ? '1' : '0');
      zen_copy_products_attributes($_POST['products_id'], $_POST['products_update_id']);
      //      die('I would copy Product ID#' . $_POST['products_id'] . ' to a Product ID#' . $_POST['products_update_id'] . ' - Existing attributes ' . $_POST['copy_attributes']);
      $_GET['action']= '';
      zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $_GET['products_id'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
      break;

      // attributes copy to category
      case 'update_attributes_copy_to_category':
      $copy_attributes_delete_first = ($_POST['copy_attributes'] == 'copy_attributes_delete' ? '1' : '0');
      $copy_attributes_duplicates_skipped = ($_POST['copy_attributes'] == 'copy_attributes_ignore' ? '1' : '0');
      $copy_attributes_duplicates_overwrite = ($_POST['copy_attributes'] == 'copy_attributes_update' ? '1' : '0');
      $copy_to_category = $db->Execute("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id='" . $_POST['categories_update_id'] . "'");
      while (!$copy_to_category->EOF) {
        zen_copy_products_attributes($_POST['products_id'], $copy_to_category->fields['products_id']);
        $copy_to_category->MoveNext();
      }
      //      die('CATEGORIES - I would copy Product ID#' . $_POST['products_id'] . ' to a Category ID#' . $_POST['categories_update_id']  . ' - Existing attributes ' . $_POST['copy_attributes'] . ' Total Products ' . $copy_to_category->RecordCount());

      $_GET['action']= '';
      zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $_GET['products_id'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
      break;
      case 'new_product':
      if (isset($_GET['product_type'])) {
        // see if this category is restricted
        $pieces = explode('_',$_GET['cPath']);
        $cat_id = $pieces[sizeof($pieces)-1];
        //	echo $cat_id;
        $sql = "select product_type_id from " . TABLE_PRODUCT_TYPES_TO_CATEGORY . " where category_id = '" . $cat_id . "'";
        $product_type_list = $db->Execute($sql);
        $sql = "select product_type_id from " . TABLE_PRODUCT_TYPES_TO_CATEGORY . " where category_id = '" . $cat_id . "' and product_type_id = '" . $_GET['product_type'] . "'";
        $product_type_good = $db->Execute($sql);
        if ($product_type_list->RecordCount() < 1 || $product_type_good->RecordCount() > 0) {
          $url = zen_get_all_get_params();
          $sql = "select type_handler from " . TABLE_PRODUCT_TYPES . " where type_id = '" . $_GET['product_type'] . "'";
          $handler = $db->Execute($sql);
          zen_redirect(zen_href_link($handler->fields['type_handler'] . '.php', zen_get_all_get_params()));
        } else {
          $messageStack->add(ERROR_CANNOT_ADD_PRODUCT_TYPE, 'error');
        }
      }
      break;
    }
  }

  // check if the catalog image directory exists
  if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES)) $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript">
<!--
function init()
{
  cssjsmenu('navbar');
  if (document.getElementById)
  {
    var kill = document.getElementById('hoverJS');
    kill.disabled = true;
  }
  if (typeof _editor_url == "string") HTMLArea.replaceAll();
}

function checkfile(){
    if($('#file_status_file').val()==''){
        alert('请选择一个.xlsx（或.xls）文件');
        return false;
    }else{
        return true;
    }
  }
function checkfileUpdate_products(){
    if($('#file_update_products').val()==''){
    alert('请选择一个.xlsx（或.xls）文件');
    return false;
  }else{
    return true;
  }
  }

function checkfileUploadimg(){
    if($('#file_img').val()==''){
    alert('请选择一个.xlsx（或.xls）文件');
    return false;
  }else{
    return true;
  }
  }
// -->
</script>
<style type="text/css">
.product_type{
position:relative;
bottom:8px;
}
</style>
<?php if ($action != 'edit_category_meta_tags') { // bof: categories meta tags ?>
<?php if ($editor_handler != '') include ($editor_handler); ?>
<?php } // meta tags disable editor eof: categories meta tags?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onLoad="init()">
<div id="spiffycalendar" class="text"></div>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
<?php if ($action == '') { ?>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="smallText" align="center" width="100" valign="top"><?php echo TEXT_LEGEND; ?></td>
            <td class="smallText" align="center" width="100" valign="top"><?php echo TEXT_LEGEND_STATUS_OFF . '<br />' . zen_image(DIR_WS_IMAGES . 'icon_red_on.gif', IMAGE_ICON_STATUS_OFF); ?></td>
            <td class="smallText" align="center" width="100" valign="top"><?php echo TEXT_LEGEND_STATUS_ON . '<br />' . zen_image(DIR_WS_IMAGES . 'icon_green_on.gif', IMAGE_ICON_STATUS_ON); ?></td>
            <td class="smallText" align="center" width="100" valign="top"><?php echo TEXT_LEGEND_LINKED . '<br />' . zen_image(DIR_WS_IMAGES . 'icon_yellow_on.gif', IMAGE_ICON_LINKED); ?></td>
            <td class="smallText" align="center" width="150" valign="top"><?php echo TEXT_LEGEND_META_TAGS . '<br />' . TEXT_YES . '&nbsp;' . TEXT_NO . '<br />' . zen_image(DIR_WS_IMAGES . 'icon_edit_metatags_on.gif', ICON_METATAGS_ON) . '&nbsp;' . zen_image(DIR_WS_IMAGES . 'icon_edit_metatags_off.gif', ICON_METATAGS_OFF); ?></td>
          </tr>
        </table></td>
      </tr>
  <tr>
    <td class="smallText" width="100%" align="right">
<?php
      // toggle switch for editor
      echo TEXT_EDITOR_INFO . zen_draw_form('set_editor_form', FILENAME_CATEGORIES, '', 'get') . '&nbsp;&nbsp;' . zen_draw_pull_down_menu('reset_editor', $editors_pulldown, $current_editor_key, 'onChange="this.form.submit();"') . zen_hide_session_id() .
            zen_draw_hidden_field('cID', $cPath) .
            zen_draw_hidden_field('cPath', $cPath) .
            zen_draw_hidden_field('pID', $_GET['pID']) .
            zen_draw_hidden_field('page', $_GET['page']) .
            zen_draw_hidden_field('action', 'set_editor') .
      '</form>';
?>
    </td>
  </tr>

  <tr>
    <td class="smallText" width="100%" align="right">
      <?php
      // check for which buttons to show for categories and products
      $check_categories = zen_has_category_subcategories($current_category_id);
      $check_products = zen_products_in_category_count($current_category_id, false, false, 1);

      $zc_skip_products = false;
      $zc_skip_categories = false;

      if ($check_products == 0) {
        $zc_skip_products = false;
        $zc_skip_categories = false;
      }

      if ($check_categories == true) {
        $zc_skip_products = true;
        $zc_skip_categories = false;
      }

      if ($check_products > 0) {
        $zc_skip_products = false;
        $zc_skip_categories = false;
      }

      if ($zc_skip_products == true) {
        // toggle switch for display sort order
        $categories_products_sort_order_array = array(array('id' => '0', 'text' => TEXT_SORT_CATEGORIES_SORT_ORDER_PRODUCTS_NAME),
        array('id' => '1', 'text' => TEXT_SORT_CATEGORIES_NAME)
        );
      } else {
        // toggle switch for display sort order
        $categories_products_sort_order_array = array(array('id' => '0', 'text' => TEXT_SORT_PRODUCTS_MODEL),
        array('id' => '1', 'text' => TEXT_SORT_PRODUCTS_NAME),
        array('id' => '2', 'text' => TEXT_SORT_PRODUCTS_SORT_ORDER_PRODUCTS_NAME),
        array('id' => '3', 'text'=> TEXT_SORT_PRODUCTS_QUANTITY),
        array('id' => '4', 'text'=> TEXT_SORT_PRODUCTS_QUANTITY_DESC),
        array('id' => '5', 'text'=> TEXT_SORT_PRODUCTS_PRICE),
        array('id' => '6', 'text'=> TEXT_SORT_PRODUCTS_PRICE_DESC)
        );
      }

      echo TEXT_CATEGORIES_PRODUCTS_SORT_ORDER_INFO . zen_draw_form('set_categories_products_sort_order_form', FILENAME_CATEGORIES, '', 'get') . '&nbsp;&nbsp;' . zen_draw_pull_down_menu('reset_categories_products_sort_order', $categories_products_sort_order_array, $reset_categories_products_sort_order, 'onChange="this.form.submit();"') . zen_hide_session_id() .
            zen_draw_hidden_field('cID', $cPath) .
            zen_draw_hidden_field('cPath', $cPath) .
            zen_draw_hidden_field('pID', $_GET['pID']) .
            zen_draw_hidden_field('page', $_GET['page']) .
            zen_draw_hidden_field('action', 'set_categories_products_sort_order') .
      '</form>';
      ?>
    </td>
  </tr>

<?php } ?>
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top">
<?php
if($action=='viewProNoCate'){
	$numcount=0;
	?>
	<div style="line-height:40px;font-size:16px;">
	这些商品由于该类别被屏蔽而无法显示:
	</div>
	<?php 
	$search_pro_str='';
	foreach($products_has_no_cate_array as $val){
		$numcount++;
		if($numcount==(sizeof($products_has_no_cate_array))){
		echo $val;	
		$search_pro_str.=$val;
		}else{
		echo $val.' , ';	
		$search_pro_str.=$val.',';
		}
		
	}
	?>
	<div style="margin-top:10px">
	<input onclick='location.href="<?php echo  zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cID']);?>"' type="button" value='back to the category' style="cursor:pointer;" >
	<form action='<?php echo zen_href_link(FILENAME_CATEGORIES);?>' method='post'>
	<input type='hidden' name='search' value='<?php echo $search_pro_str?>'>
	<input type='hidden' name='showCategory' value='no'>
	<input style="cursor:pointer;" type="submit" value='operate these products'>
	</form>
	</div>
	<?php
}else{
	require(DIR_WS_MODULES . 'category_product_listing.php');
}

  $heading = array();
  $contents = array();
  // Make an array of product types
  $sql = "select type_id, type_name from " . TABLE_PRODUCT_TYPES;
  $product_types = $db->Execute($sql);
  while (!$product_types->EOF) {
    $type_array[] = array('id' => $product_types->fields['type_id'], 'text' => $product_types->fields['type_name']);
    $product_types->MoveNext();
  }
  switch ($action) {
    case 'setflag_categories':
		$heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_STATUS_CATEGORY . '</b>');
		$contents = array('form' => zen_draw_form('categories', FILENAME_CATEGORIES, 'action=update_category_status&cPath=' . $_GET['cPath'] . '&cID=' . $_GET['cID'], 'post', 'enctype="multipart/form-data"') . zen_draw_hidden_field('categories_id', $cInfo->categories_id) . zen_draw_hidden_field('categories_status', $cInfo->categories_status));
		$contents[] = array('text' => zen_get_category_name($cInfo->categories_id, $_SESSION['languages_id']));
		//$contents[] = array('text' => '<br />' . TEXT_CATEGORIES_STATUS_WARNING . '<br /><br />');
		$contents[] = array('text' => TEXT_CATEGORIES_STATUS_INTRO . ' ' . ($cInfo->categories_status == '1' ? TEXT_CATEGORIES_STATUS_OFF : TEXT_CATEGORIES_STATUS_ON));
		if ($cInfo->categories_status == '1') {
			//$contents[] = array('text' => '<br />' . TEXT_PRODUCTS_STATUS_INFO . ' ' . TEXT_PRODUCTS_STATUS_OFF . zen_draw_hidden_field('set_products_status_off', true));
		} else {
			$contents[] = array('text' => '<br />' . TEXT_PRODUCTS_STATUS_INFO . '<br />' .
			zen_draw_radio_field('set_products_status', 'set_products_status_nochange', true) . ' ' . TEXT_PRODUCTS_STATUS_NOCHANGE . ' (restore previous state)' . '<br />' .
			zen_draw_radio_field('set_products_status', 'set_products_status_on') . ' ' . TEXT_PRODUCTS_STATUS_ON . ' (enable all products)' . '<br />' .
			zen_draw_radio_field('set_products_status', 'set_products_status_off') . ' ' . TEXT_PRODUCTS_STATUS_OFF . ' (disable all products)');
		}


		//        $contents[] = array('text' => '<br />' . TEXT_PRODUCTS_STATUS_INFO . '<br />' . zen_draw_radio_field('set_products_status', 'set_products_status_off', true) . ' ' . TEXT_PRODUCTS_STATUS_OFF . '<br />' . zen_draw_radio_field('set_products_status', 'set_products_status_on') . ' ' . TEXT_PRODUCTS_STATUS_ON);

		$contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_update.gif', IMAGE_UPDATE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
		break;

    case 'new_category':
    $is_display =true;
    $is_display1 = false;
	$categories_level_sql = $db->Execute("Select categories_level
									    From " . TABLE_CATEGORIES . "
									   Where categories_id ='" .  $cInfo->categories_id . "'");
	$categories_level = $categories_level_sql->fields['categories_level'];	
    $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CATEGORY . '</b>');

    $contents = array('form' => zen_draw_form('newcategory', FILENAME_CATEGORIES, 'action=insert_category&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"'));
    $contents[] = array('text' => TEXT_NEW_CATEGORY_INTRO);

    $category_inputs_string = '';
    $languages = zen_get_languages();
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
      $category_inputs_string .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . zen_draw_input_field('categories_name[' . $languages[$i]['id'] . ']', '', zen_set_field_length(TABLE_CATEGORIES_DESCRIPTION, 'categories_name'));
    }

    $contents[] = array('text' => '<br />' . TEXT_CATEGORIES_NAME . $category_inputs_string);
    $category_inputs_string = '';

    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
      $category_inputs_string .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;';
      if ($_SESSION['html_editor_preference_status']=='FCKEDITOR') {
                $oFCKeditor = new FCKeditor('categories_description[' . $languages[$i]['id']  . ']') ;
                $oFCKeditor->Value = zen_get_category_description($cInfo->categories_id, $languages[$i]['id']);
                $oFCKeditor->Width  = '97%' ;
                $oFCKeditor->Height = '200' ;
//                $oFCKeditor->Config['ToolbarLocation'] = 'Out:xToolbar' ;
//                $oFCKeditor->Create() ;
                $output = $oFCKeditor->CreateHtml() ;
        $category_inputs_string .= '<br />' . $output;

//        $category_inputs_string .= '<IFRAME src= "' . DIR_WS_CATALOG . 'FCKeditor/fckeditor.html?FieldName=categories_description[' . $languages[$i]['id']  . ']&Upload=false&Browse=false&Toolbar=Short" width="97%" height="200" frameborder="no" scrolling="yes"></IFRAME>';
//        $category_inputs_string .= '<INPUT type="hidden" name="categories_description[' . $languages[$i]['id']  . ']" ' . 'value=' . "'" . zen_get_category_description($cInfo->categories_id, $languages[$i]['id']) . "'>";
      } else {
        $category_inputs_string .= zen_draw_textarea_field('categories_description[' . $languages[$i]['id'] . ']', 'soft', '100%', '20', zen_get_category_description($cInfo->categories_id, $languages[$i]['id']));
      }
    }
    $contents[] = array('text' => '<br />类别编号(产品线号): ' . zen_draw_input_field('categories_code'));
    $contents[] = array('text' => '<br />' . '前台是否显示:<label>' . zen_draw_radio_field('categories_display', 10, $is_display).'展示</label><label >'.zen_draw_radio_field('categories_display', 20, $is_display1).'不展示</label>');
    $contents[] = array('text' => '<br />' . '新品区是否展示:<label>' . zen_draw_radio_field('new_arrivals_display', 10, empty($new_arrivals_display) || $new_arrivals_display == 10 ? true : false).'展示</label><label >'.zen_draw_radio_field('new_arrivals_display', 20, $new_arrivals_display == 20 ? true : false).'不展示</label>');
    
    $contents[] = array('text' => '<br />' . TEXT_CATEGORIES_DESCRIPTION . $category_inputs_string);
    $contents[] = array('text' => '<br />' . TEXT_CATEGORIES_IMAGE . '<br />' . zen_draw_file_field('categories_image'));
    $dir = @dir(DIR_FS_CATALOG_IMAGES);
    $dir_info[] = array('id' => '', 'text' => "Main Directory");
    while ($file = $dir->read()) {
      if (is_dir(DIR_FS_CATALOG_IMAGES . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
        $dir_info[] = array('id' => $file . '/', 'text' => $file);
      }
    }
    $dir->close();
    sort($dir_info);
    $default_directory = 'categories/';

    $contents[] = array('text' => TEXT_CATEGORIES_IMAGE_DIR . ' ' . zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory));
    $contents[] = array('text' => '<br />' . TEXT_CATEGORIES_IMAGE_MANUAL . '&nbsp;' . zen_draw_input_field('categories_image_manual'));

    $contents[] = array('text' => '<br />' . TEXT_SORT_ORDER . '<br />' . zen_draw_input_field('sort_order', '', 'size="6"'));
	$contents[] = array('text' => '<br />' . 'Categories Level:' . zen_draw_input_field('categories_level', $categories_level, 'size="6"'));
    $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;
    case 'edit_category':
    // echo 'I SEE ' . $_SESSION['html_editor_preference_status'];
    // set image delete
	$categories_level_sql = $db->Execute("Select categories_level,categories_code,left_display,categories_status,new_arrivals_display
									    From " . TABLE_CATEGORIES . "
									   Where categories_id ='" .  $cInfo->categories_id . "'");
	$left_display = $categories_level_sql->fields['left_display'];
	$categories_level = $categories_level_sql->fields['categories_level'];	
	$categories_code = $categories_level_sql->fields['categories_code'];
	$categories_status = $categories_level_sql->fields['categories_status'];
	$new_arrivals_display = $categories_level_sql->fields['new_arrivals_display'];
    $on_image_delete = false;
    $off_image_delete = true;
    $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</b>');

    $contents = array('form' => zen_draw_form('categories', FILENAME_CATEGORIES, 'action=update_category&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') . zen_draw_hidden_field('categories_id', $cInfo->categories_id));
    $contents[] = array('text' => TEXT_EDIT_INTRO);

    $languages = zen_get_languages();

    $category_inputs_string = '';
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
      $category_inputs_string .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . zen_draw_input_field('categories_name[' . $languages[$i]['id'] . ']', zen_get_category_name($cInfo->categories_id, $languages[$i]['id']), zen_set_field_length(TABLE_CATEGORIES_DESCRIPTION, 'categories_name'));
    }
    $contents[] = array('text' => '<br />' . TEXT_EDIT_CATEGORIES_NAME . $category_inputs_string);
    $category_inputs_string = '';
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
      $category_inputs_string .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' ;
      if ($_SESSION['html_editor_preference_status']=='FCKEDITOR') {
                $oFCKeditor = new FCKeditor('categories_description[' . $languages[$i]['id']  . ']') ;
                $oFCKeditor->Value = zen_get_category_description($cInfo->categories_id, $languages[$i]['id']);
                $oFCKeditor->Width  = '97%' ;
                $oFCKeditor->Height = '200' ;
//                $oFCKeditor->Config['ToolbarLocation'] = 'Out:xToolbar' ;
//                $oFCKeditor->Create() ;
                $output = $oFCKeditor->CreateHtml() ;
        $category_inputs_string .= '<br />' . $output;
//        $category_inputs_string .= '<IFRAME src= "' . DIR_WS_CATALOG . 'FCKeditor/fckeditor.html?FieldName=categories_description[' . $languages[$i]['id']  . ']&Upload=false&Browse=false&Toolbar=Short" width="97%" height="200" frameborder="no" scrolling="yes"></IFRAME>';
//        $category_inputs_string .= '<INPUT type="hidden" name="categories_description[' . $languages[$i]['id']  . ']" ' . 'value=' . "'" . zen_get_category_description($cInfo->categories_id, $languages[$i]['id']) . "'>";
      } else {
        $category_inputs_string .= zen_draw_textarea_field('categories_description[' . $languages[$i]['id'] . ']', 'soft', '100%', '20', zen_get_category_description($cInfo->categories_id, $languages[$i]['id']));
      }
    }
    $contents[] = array('text' => '<br />类别编号(产品线号): ' . zen_draw_input_field('categories_code', $categories_code));
    
    if($categories_status == 1){
    	if($left_display == 10){
    		$is_display =true;
    		$is_display1 = false;
    	}else{
    		$is_display = false;
    		$is_display1 = true;
    	}
    	$contents[] = array('text' => '<br />' . '前台是否显示:<label>' . zen_draw_radio_field('categories_display', 10, $is_display).'展示</label><label >'.zen_draw_radio_field('categories_display', 20, $is_display1).'不展示</label>');
    	$contents[] = array('text' => '<br />' . '新品区是否展示:<label>' . zen_draw_radio_field('new_arrivals_display', 10, $new_arrivals_display == 10 ? true : false).'展示</label><label >'.zen_draw_radio_field('new_arrivals_display', 20, $new_arrivals_display == 20 ? true : false).'不展示</label>');
    }
    
    $contents[] = array('text' => '<br />' . TEXT_CATEGORIES_DESCRIPTION . $category_inputs_string);
    $contents[] = array('text' => '<br />' . TEXT_EDIT_CATEGORIES_IMAGE . '<br />' . zen_draw_file_field('categories_image'));

    $dir = @dir(DIR_FS_CATALOG_IMAGES);
    $dir_info[] = array('id' => '', 'text' => "Main Directory");
    while ($file = $dir->read()) {
      if (is_dir(DIR_FS_CATALOG_IMAGES . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
        $dir_info[] = array('id' => $file . '/', 'text' => $file);
      }
    }
    $dir->close();
    sort($dir_info);
    $default_directory = substr( $cInfo->categories_image, 0,strpos( $cInfo->categories_image, '/')+1);

    $contents[] = array('text' => TEXT_CATEGORIES_IMAGE_DIR . ' ' . zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory));

    $contents[] = array('text' => '<br />' . TEXT_CATEGORIES_IMAGE_MANUAL . '&nbsp;' . zen_draw_input_field('categories_image_manual'));

    $contents[] = array('text' => '<br />' . zen_info_image($cInfo->categories_image, $cInfo->categories_name));
    $contents[] = array('text' => '<br />' . $cInfo->categories_image);
    $contents[] = array('text' => '<br />' . TEXT_IMAGES_DELETE . ' ' . zen_draw_radio_field('image_delete', '0', $off_image_delete) . '&nbsp;' . TABLE_HEADING_NO . ' ' . zen_draw_radio_field('image_delete', '1', $on_image_delete) . '&nbsp;' . TABLE_HEADING_YES);

    $contents[] = array('text' => '<br />' . TEXT_EDIT_SORT_ORDER . '<br />' . zen_draw_input_field('sort_order', $cInfo->sort_order, 'size="6"'));
	$contents[] = array('text' => '<br />' . 'Categories Level:' . zen_draw_input_field('categories_level', $categories_level, 'size="6"'));
    $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    $contents[] = array('text' => TEXT_RESTRICT_PRODUCT_TYPE . ' ' . zen_draw_pull_down_menu('restrict_type', $type_array) . '&nbsp<input type="submit" name="add_type_all" value="' . BUTTON_ADD_PRODUCT_TYPES_SUBCATEGORIES_ON . '">' . '&nbsp<input type="submit" name="add_type" value="' . BUTTON_ADD_PRODUCT_TYPES_SUBCATEGORIES_OFF . '">');
    $sql = "select * from " . TABLE_PRODUCT_TYPES_TO_CATEGORY . "
                           where category_id = '" . $cInfo->categories_id . "'";

    $restrict_types = $db->Execute($sql);
    if ($restrict_types->RecordCount() > 0 ) {
      $contents[] = array('text' => '<br />' . TEXT_CATEGORY_HAS_RESTRICTIONS . '<br />');
      while (!$restrict_types->EOF) {
        $sql = "select type_name from " . TABLE_PRODUCT_TYPES . " where type_id = '" . $restrict_types->fields['product_type_id'] . "'";
        $type = $db->Execute($sql);
        $contents[] = array('text' => '<a href="' . zen_href_link(FILENAME_CATEGORIES, 'action=remove_type&cPath=' . $cPath . '&cID='.$cInfo->categories_id.'&type_id='.$restrict_types->fields['product_type_id']) . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>&nbsp;' . $type->fields['type_name'] . '<br />');
        $restrict_types->MoveNext();
      }
    }
    break;
    case 'delete_category':
    $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CATEGORY . '</b>');

    $contents = array('form' => zen_draw_form('categories', FILENAME_CATEGORIES, 'action=delete_category_confirm&cPath=' . $cPath) . zen_draw_hidden_field('categories_id', $cInfo->categories_id));
    $contents[] = array('text' => TEXT_DELETE_CATEGORY_INTRO);
    $contents[] = array('text' => '<br />' . TEXT_DELETE_CATEGORY_INTRO_LINKED_PRODUCTS);
    $contents[] = array('text' => '<br /><b>' . $cInfo->categories_name . '</b>');
    if ($cInfo->childs_count > 0) $contents[] = array('text' => '<br />' . sprintf(TEXT_DELETE_WARNING_CHILDS, $cInfo->childs_count));
    if ($cInfo->products_count > 0) $contents[] = array('text' => '<br />' . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $cInfo->products_count));
    /*
    // future cat specific
    if ($cInfo->products_count > 0) {
    $contents[] = array('text' => '<br />' . TEXT_PRODUCTS_LINKED_INFO . '<br />' .
    zen_draw_radio_field('delete_linked', 'delete_linked_yes') . ' ' . TEXT_PRODUCTS_DELETE_LINKED_YES . '<br />' .
    zen_draw_radio_field('delete_linked', 'delete_linked_no', true) . ' ' . TEXT_PRODUCTS_DELETE_LINKED_NO);
    }
    */
    $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;

    // bof: categories meta tags
    case 'edit_category_meta_tags':
    $heading[] = array('text' => '<strong>' . TEXT_INFO_HEADING_EDIT_CATEGORY_META_TAGS . '</strong>');

    $contents = array('form' => zen_draw_form('categories', FILENAME_CATEGORIES, 'action=update_category_meta_tags&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') . zen_draw_hidden_field('categories_id', $cInfo->categories_id));
    $contents[] = array('text' => TEXT_EDIT_CATEGORIES_META_TAGS_INTRO . ' - <strong>' . $cInfo->categories_id . ' ' . $cInfo->categories_name . '</strong>');

    $languages = zen_get_languages();

    $category_inputs_string_metatags_title = '';
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
      $category_inputs_string_metatags_title .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['metatags_title']) . '&nbsp;' . zen_draw_input_field('metatags_title[' . $languages[$i]['id'] . ']', zen_get_category_metatags_title($cInfo->categories_id, $languages[$i]['id']), zen_set_field_length(TABLE_METATAGS_CATEGORIES_DESCRIPTION, 'metatags_title'));
    }
    $contents[] = array('text' => '<br />' . TEXT_EDIT_CATEGORIES_META_TAGS_TITLE . $category_inputs_string_metatags_title);

    $category_inputs_string_metatags_keywords = '';
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
      $category_inputs_string_metatags_keywords .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['metatags_keywords']) . '&nbsp;' ;
      $category_inputs_string_metatags_keywords .= zen_draw_textarea_field('metatags_keywords[' . $languages[$i]['id'] . ']', 'soft', '100%', '20', zen_get_category_metatags_keywords($cInfo->categories_id, $languages[$i]['id']));
    }
    $contents[] = array('text' => '<br />' . TEXT_EDIT_CATEGORIES_META_TAGS_KEYWORDS . $category_inputs_string_metatags_keywords);

    $category_inputs_string_metatags_description = '';
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
      $category_inputs_string_metatags_description .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' ;
      $category_inputs_string_metatags_description .= zen_draw_textarea_field('metatags_description[' . $languages[$i]['id'] . ']', 'soft', '100%', '20', zen_get_category_metatags_description($cInfo->categories_id, $languages[$i]['id']));
    }
    $contents[] = array('text' => '<br />' . TEXT_EDIT_CATEGORIES_META_TAGS_DESCRIPTION . $category_inputs_string_metatags_description);

    $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;
    // eof: categories meta tags

    case 'move_category':
    $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_CATEGORY . '</b>');

    $contents = array('form' => zen_draw_form('categories', FILENAME_CATEGORIES, 'action=move_category_confirm&cPath=' . $cPath) . zen_draw_hidden_field('categories_id', $cInfo->categories_id));
    $contents[] = array('text' => sprintf(TEXT_MOVE_CATEGORIES_INTRO, $cInfo->categories_name));
    $contents[] = array('text' => '<br />' . sprintf(TEXT_MOVE, $cInfo->categories_name) . '<br />' . zen_draw_pull_down_menu('move_to_category_id', zen_get_category_tree(), $current_category_id));
    $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_move.gif', IMAGE_MOVE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;
    case 'delete_product':
    $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_PRODUCT . '</b>');

    $contents = array('form' => zen_draw_form('products', FILENAME_CATEGORIES, 'action=delete_product_confirm&cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . zen_draw_hidden_field('products_id', $pInfo->products_id));
    $contents[] = array('text' => TEXT_DELETE_PRODUCT_INTRO);
    $contents[] = array('text' => '<br /><b>' . $pInfo->products_name . ' ID#' . $pInfo->products_id . '</b>');

    $product_categories_string = '';
    $product_categories = zen_generate_category_path($pInfo->products_id, 'product');
    for ($i = 0, $n = sizeof($product_categories); $i < $n; $i++) {
      $category_path = '';
      for ($j = 0, $k = sizeof($product_categories[$i]); $j < $k; $j++) {
        $category_path .= $product_categories[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
      }
      $category_path = substr($category_path, 0, -16);
      $product_categories_string .= zen_draw_checkbox_field('product_categories[]', $product_categories[$i][sizeof($product_categories[$i])-1]['id'], true) . '&nbsp;' . $category_path . '<br />';
    }
    $product_categories_string = substr($product_categories_string, 0, -4);

    $contents[] = array('text' => '<br />' . $product_categories_string);
    $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;
    case 'move_product':
    $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_PRODUCT . '</b>');

    $contents = array('form' => zen_draw_form('products', FILENAME_CATEGORIES, 'action=move_product_confirm&cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . zen_draw_hidden_field('products_id', $pInfo->products_id));
    $contents[] = array('text' => sprintf(TEXT_MOVE_PRODUCTS_INTRO, $pInfo->products_name));
    $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENT_CATEGORIES . '<br /><b>' . zen_output_generated_category_path($pInfo->products_id, 'product') . '</b>');
    $contents[] = array('text' => '<br />' . sprintf(TEXT_MOVE, $pInfo->products_name) . '<br />' . zen_draw_pull_down_menu('move_to_category_id', zen_get_category_tree(), $current_category_id));
    $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_move.gif', IMAGE_MOVE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;
    case 'copy_to':
    $copy_attributes_delete_first = '0';
    $copy_attributes_duplicates_skipped = '0';
    $copy_attributes_duplicates_overwrite = '0';
    $copy_attributes_include_downloads = '1';
    $copy_attributes_include_filename = '1';

    $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');
    // WebMakers.com Added: Split Page
    if (empty($pInfo->products_id)) {
      $pInfo->products_id= $pID;
    }

    $contents = array('form' => zen_draw_form('copy_to', FILENAME_CATEGORIES, 'action=copy_to_confirm&cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . zen_draw_hidden_field('products_id', $pInfo->products_id));
    $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
    $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENT_PRODUCT . '<br /><b>' . $pInfo->products_name  . ' ID#' . $pInfo->products_id . '</b>');
    $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENT_CATEGORIES . '<br /><b>' . zen_output_generated_category_path($pInfo->products_id, 'product') . '</b>');
    $contents[] = array('text' => '<br />' . TEXT_CATEGORIES . '<br />' . zen_draw_pull_down_menu('categories_id', zen_get_category_tree(), $current_category_id));
    $contents[] = array('text' => '<br />' . TEXT_HOW_TO_COPY . '<br />' . zen_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br />' . zen_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE);

    // only ask about attributes if they exist
    if (zen_has_product_attributes($pInfo->products_id, 'false')) {
      $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));
      $contents[] = array('text' => '<br />' . TEXT_COPY_ATTRIBUTES_ONLY);
      $contents[] = array('text' => '<br />' . TEXT_COPY_ATTRIBUTES . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_yes', true) . ' ' . TEXT_COPY_ATTRIBUTES_YES . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_no') . ' ' . TEXT_COPY_ATTRIBUTES_NO);
      // future          $contents[] = array('align' => 'center', 'text' => '<br />' . ATTRIBUTES_NAMES_HELPER . '<br />' . zen_draw_separator('pixel_trans.gif', '1', '10'));
      $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));
    }

    $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_copy.gif', IMAGE_COPY) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');

    break;
    // attribute features
    case 'attribute_features':
    $copy_attributes_delete_first = '0';
    $copy_attributes_duplicates_skipped = '0';
    $copy_attributes_duplicates_overwrite = '0';
    $copy_attributes_include_downloads = '1';
    $copy_attributes_include_filename = '1';
    $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_ATTRIBUTE_FEATURES . $pInfo->products_id . '</b>');

    $contents[] = array('align' => 'center', 'text' => '<br />' . '<strong>' . TEXT_PRODUCTS_ATTRIBUTES_INFO . '</strong>' . '<br />');

    $contents[] = array('align' => 'center', 'text' => '<br />' . '<strong>' . zen_get_products_name($pInfo->products_id, $languages_id) . ' ID# ' . $pInfo->products_id . '</strong><br /><br />' .
    (zen_has_product_attributes($pInfo->products_id, 'false') ? '<a href="' . zen_href_link(FILENAME_ATTRIBUTES_CONTROLLER, '&action=attributes_preview' . '&products_filter=' . $pInfo->products_id . '&current_category_id=' . $current_category_id) . '">' . zen_image_button('button_preview.gif', IMAGE_PREVIEW) . '</a>' . '&nbsp;&nbsp;' : '') .
    '<a href="' . zen_href_link(FILENAME_ATTRIBUTES_CONTROLLER, 'products_filter=' . $pInfo->products_id . '&current_category_id=' . $current_category_id) . '">' . zen_image_button('button_edit_attribs.gif', IMAGE_EDIT_ATTRIBUTES) . '</a>' .
    '<br /><br />');
    // only if attributes
    if (zen_has_product_attributes($pInfo->products_id, 'false')) {
      $contents[] = array('align' => 'left', 'text' => '<br />' . '<strong>' . TEXT_PRODUCT_ATTRIBUTES_DOWNLOADS . '</strong>' . zen_has_product_attributes_downloads($pInfo->products_id) . zen_has_product_attributes_downloads($pInfo->products_id, true));
      $contents[] = array('align' => 'left', 'text' => '<br />' . TEXT_INFO_ATTRIBUTES_FEATURES_DELETE . '<strong>' . zen_get_products_name($pInfo->products_id) . ' ID# ' . $pInfo->products_id . '</strong><br /><a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=delete_attributes' . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . '&products_id=' . $pInfo->products_id) . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
      $contents[] = array('align' => 'left', 'text' => '<br />' . TEXT_INFO_ATTRIBUTES_FEATURES_UPDATES . '<strong>' . zen_get_products_name($pInfo->products_id, $languages_id) . ' ID# ' . $pInfo->products_id . '</strong><br /><a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=update_attributes_sort_order' . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . '&products_id=' . $pInfo->products_id) . '">' . zen_image_button('button_update.gif', IMAGE_UPDATE) . '</a>');
      $contents[] = array('align' => 'left', 'text' => '<br />' . TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO_PRODUCT . '<strong>' . zen_get_products_name($pInfo->products_id, $languages_id) . ' ID# ' . $pInfo->products_id . '</strong><br /><a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=attribute_features_copy_to_product' . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . '&products_id=' . $pInfo->products_id) . '">' . zen_image_button('button_copy_to.gif', IMAGE_COPY_TO) . '</a>');
      $contents[] = array('align' => 'left', 'text' => '<br />' . TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO_CATEGORY . '<strong>' . zen_get_products_name($pInfo->products_id, $languages_id) . ' ID# ' . $pInfo->products_id . '</strong><br /><a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=attribute_features_copy_to_category' . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . '&products_id=' . $pInfo->products_id) . '">' . zen_image_button('button_copy_to.gif', IMAGE_COPY_TO) . '</a>');
    }
    $contents[] = array('align' => 'center', 'text' => '<br /><a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;

    // attribute copier to product
    case 'attribute_features_copy_to_product':
    $_GET['products_update_id'] = '';
    // excluded current product from the pull down menu of products
    $products_exclude_array = array();
    $products_exclude_array[] = $pInfo->products_id;

    $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_ATTRIBUTE_FEATURES . $pInfo->products_id . '</b>');
    $contents = array('form' => zen_draw_form('products', FILENAME_CATEGORIES, 'action=update_attributes_copy_to_product&cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . zen_draw_hidden_field('products_id', $pInfo->products_id) . zen_draw_hidden_field('products_update_id', $_GET['products_update_id']) . zen_draw_hidden_field('copy_attributes', $_GET['copy_attributes']));
    $contents[] = array('text' => '<br />' . TEXT_COPY_ATTRIBUTES_CONDITIONS . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_delete', true) . ' ' . TEXT_COPY_ATTRIBUTES_DELETE . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_update') . ' ' . TEXT_COPY_ATTRIBUTES_UPDATE . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_ignore') . ' ' . TEXT_COPY_ATTRIBUTES_IGNORE);
    $contents[] = array('align' => 'center', 'text' => '<br />' . zen_draw_products_pull_down('products_update_id', '', $products_exclude_array, true) . '<br /><br />' . zen_image_submit('button_copy_to.gif', IMAGE_COPY_TO). '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;

    // attribute copier to product
    case 'attribute_features_copy_to_category':
    $_GET['categories_update_id'] = '';

    $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_ATTRIBUTE_FEATURES . $pInfo->products_id . '</b>');
    $contents = array('form' => zen_draw_form('products', FILENAME_CATEGORIES, 'action=update_attributes_copy_to_category&cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . zen_draw_hidden_field('products_id', $pInfo->products_id) . zen_draw_hidden_field('categories_update_id', $_GET['categories_update_id']) . zen_draw_hidden_field('copy_attributes', $_GET['copy_attributes']));
    $contents[] = array('text' => '<br />' . TEXT_COPY_ATTRIBUTES_CONDITIONS . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_delete', true) . ' ' . TEXT_COPY_ATTRIBUTES_DELETE . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_update') . ' ' . TEXT_COPY_ATTRIBUTES_UPDATE . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_ignore') . ' ' . TEXT_COPY_ATTRIBUTES_IGNORE);
    $contents[] = array('align' => 'center', 'text' => '<br />' . zen_draw_products_pull_down_categories('categories_update_id', '', '', true) . '<br /><br />' . zen_image_submit('button_copy_to.gif', IMAGE_COPY_TO) . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
    break;

  } // switch

  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
    echo '            <td valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>

          </tr>
          <tr>
            <td class="alert" colspan="3" width="100%" align="center">
<?php
  // warning if products are in top level categories
  $check_products_top_categories = $db->Execute("select count(*) as products_errors from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = 0");
  if ($check_products_top_categories->fields['products_errors'] > 0) {
    echo WARNING_PRODUCTS_IN_TOP_INFO . $check_products_top_categories->fields['products_errors'] . '<br />';
  }
?>
            </td>
          </tr>
          <tr>
<?php
// Split Page
if ($products_query_numrows > 0) {
  if (empty($pInfo->products_id)) {
    $pInfo->products_id= $pID;
  }
?>
            <td class="smallText" align="center"><?php echo $products_split->display_count($products_query_numrows, MAX_DISPLAY_RESULTS_CATEGORIES, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS) . '<br>' . $products_split->display_links($products_query_numrows, MAX_DISPLAY_RESULTS_CATEGORIES, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y', 'pID')) ); ?></td>

<?php
}
// Split Page
?>
          </tr>
        </table></td>
      </tr>
    </table>
    </td>
<!-- body_text_eof //-->
  </tr>
</table>

<table border="0" width="100%" cellspacing="15" cellpadding="2" style="margin-left: 20px;">
    <tr>
        <td>
            <?php echo zen_draw_form('status_form', FILENAME_CATEGORIES, '', 'post','onsubmit="return checkfileUpdate_products();" enctype="multipart/form-data"');?>
                <span style="margin-right:10px;">批量更新商品上货信息:</span>
                <input type="file" name="file_update_products" id="file_update_products" />
                <input type="hidden" name="action" value="update_products">
                <input type="hidden" name="cPath" value="<?php echo $cPath; ?>">
                <a href="./file/products_template.xlsx" style="display:inline-block;margin-right:10px;">下载模板</a>
                <input  type="submit"  name="submit_update_products" style="width:75px;font-size:13px;" value="上传" />
                <span>说明：商品所属产品线，属性值，库存状态无法在此更新。</span>
                </form>
    </td>
  </tr>
    
    <tr>
        <td>
            <?php echo zen_draw_form('status_form', FILENAME_CATEGORIES, '', 'post','onsubmit="return checkfile();" enctype="multipart/form-data"');?>
            <span style="margin-right:10px;">批量更新产品状态:</span>
                <input type="file" name="file_status" id="file_status_file" />
                <input type="hidden" name="action" value="upload_status">
                <input type="hidden" name="cPath" value="<?php echo $cPath; ?>">
                <a href="./file/template_batch_change_products_status.xlsx" style="display:inline-block;margin-right:10px;">下载模板</a>
                <input  type="submit"  name="submit_status" style="width:75px;font-size:13px;" value="上传" />
            </form>
        </td>
    </tr>
    <tr>
      <td>
        <?php echo zen_draw_form('img_form', FILENAME_CATEGORIES, '', 'post','onsubmit="return checkfileUploadimg();" enctype="multipart/form-data"');?>
                <span style="margin-right:10px;">批量更新商品图片及数量:</span>
                <input type="file" name="file_img" id="file_img"/>
                <input type="hidden" name="action" value="upload_img">
                <input type="hidden" name="cPath" value="<?php echo $cPath; ?>">
                 <a href="./file/update_products_img.xls" style="display:inline-block;margin-right:10px;">下载模板</a>
                <input  type="submit"  name="submit_img" style="width:75px;font-size:13px;" value="上传" />
                  </form>
          </td>
    </tr>

	<tr>
		<td>
			<?php echo zen_draw_form('remove_products', FILENAME_CATEGORIES, '', 'post','enctype="multipart/form-data"');?>
		          <span style="margin-right:10px;">批量将商品从指定类别下移除:</span><input type="file" name="file_remove"/>
		          <input type="hidden" name="action" value="remove_products">
		          <input type="hidden" name="cPath" value="<?php echo $cPath; ?>">
		          <a href="./file/remove_products_to_category.xlsx" style="display:inline-block;margin-right:10px;">下载模板</a>
		          <input  type="submit"  name="submit_img" style="width:75px;font-size:13px;" value="上传" />
	              </form>
        </td>
	</tr>	
		<tr>
		<td>
			<?php echo zen_draw_form('move_category', FILENAME_CATEGORIES, '', 'post','enctype="multipart/form-data"');?>
		          <span style="margin-right:10px;">产品移动产品线:</span><input type="file" name="file_remove"/>
		          <input type="hidden" name="action" value="move_category">
		          <input type="hidden" name="cPath" value="<?php echo $cPath; ?>">
		          <a href="./file/template_move_category.xlsx" style="display:inline-block;margin-right:10px;">下载模板</a>
		          <input  type="submit"  name="submit_img" style="width:75px;font-size:13px;" value="上传" />
	              </form>
        </td>
	</tr>
	<tr>
		<td>
			<?php echo zen_draw_form('add_category', FILENAME_CATEGORIES, '', 'post','enctype="multipart/form-data"');?>
		          <span style="margin-right:10px;">产品添加产品线:</span><input type="file" name="file_remove"/>
		          <input type="hidden" name="action" value="add_category">
		          <input type="hidden" name="cPath" value="<?php echo $cPath; ?>">
		          <a href="./file/template_add_category.xlsx" style="display:inline-block;margin-right:10px;">下载模板</a>
		          <input  type="submit"  name="submit_img" style="width:75px;font-size:13px;" value="上传" />
	              </form>
        </td>
	</tr>
	<tr>
		<td>
			<?php echo zen_draw_form('my_products', FILENAME_CATEGORIES, '', 'post','enctype="multipart/form-data"');?>
		          <span style="margin-right:10px;">设置My Products商品:</span><input type="file" name="file_remove"/>
		          <input type="hidden" name="action" value="my_products">
		          <input type="hidden" name="cPath" value="<?php echo $cPath; ?>">
		          <a href="./file/template_my_products.csv" style="display:inline-block;margin-right:10px;">下载模板</a>
		          <input  type="submit"  name="submit_img" style="width:75px;font-size:13px;" value="上传" />
	              </form>
        </td>
	</tr>
	<tr>
		<td>
			<?php echo zen_draw_form('clear_memcache', FILENAME_CATEGORIES, '', 'post','enctype="multipart/form-data"');?>
		          <span style="margin-right:10px;">清除memcache缓存:</span><input type="file" name="file_remove"/>
		          <input type="hidden" name="action" value="clear_memcache">
		          <input type="hidden" name="cPath" value="<?php echo $cPath; ?>">
		          <a href="./file/template_clear_memcache.csv" style="display:inline-block;margin-right:10px;">下载模板</a>
		          <input  type="submit"  name="submit_img" style="width:75px;font-size:13px;" value="上传" />
	              </form>
        </td>
	</tr>
<!--    <tr>-->
<!--        <td>-->
<!--            --><?php //echo zen_draw_form('clear_memcache', FILENAME_CATEGORIES, '', 'post','enctype="multipart/form-data"');?>
<!--            <span style="margin-right:10px;">商品批量是否可搜索:</span><input type="file" name="products_display"/>-->
<!--            <input type="hidden" name="action" value="products_display">-->
<!--            <input type="hidden" name="cPath" value="--><?php //echo $cPath; ?><!--">-->
<!--            <a href="./file/template_products_display.csv" style="display:inline-block;margin-right:10px;">下载模板</a>-->
<!--            <input  type="submit"  name="submit_img" style="width:75px;font-size:13px;" value="上传" />-->
<!--            </form>-->
<!--        </td>-->
<!--    </tr>-->
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php 
	require(DIR_WS_INCLUDES . 'application_bottom.php'); 
 //只作为临时引入
    echo "<script type='text/javascript' src='./includes/jquery.js'></script>";
?>