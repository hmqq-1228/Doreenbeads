<?php
require('includes/application_top.php');

$status_arr = array(array('id' => 0 , 'text' =>'All') , array('id' => 10 , 'text' => '开启') , array('id' => 20 , 'text' => '暂停'));

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] :  '';
$search_condition = '';

$status = zen_db_input($_GET['status']);
$erp_id = zen_db_input($_GET['erp_id']);

if($status != '' && in_array($status, array(10, 20))){
    $search_condition = ' and shipping_status = ' . $status;
}

if($erp_id != '' ){
    $search_condition = ' and shipping_erp_id = "' . $erp_id . '"';
}

$pageIndex = 1;
if($_GET['page'])
{
    $pageIndex = intval($_GET['page']);
}

$shipping_virtual_methods_query_sql = 'SELECT shipping_id, shipping_erp_id, shipping_code, tc.countries_name, shipping_status, create_admin, create_datetime, modify_admin, modify_datetime FROM ' . TABLE_VIRTUAL_SHIPPING . ' tvs inner join ' . TABLE_COUNTRIES . ' tc on tvs.country_code = tc.countries_iso_code_2 where 1' . $search_condition;
$shipping_virtual_methods_split = new splitPageResults($pageIndex, MAX_DISPLAY_SEARCH_RESULTS, $shipping_virtual_methods_query_sql, $query_numrows);
$shipping_virtual_methods = $db->Execute($shipping_virtual_methods_query_sql);

switch ($action){
    case 'check_form':
        $shipping_code = zen_db_prepare_input($_POST['shipping_code']);
        $return_array = array('error' => false, 'error_info' => '');
        
        if($shipping_code != ''){
            $check_method_code_query = 'select shipping_id from ' . TABLE_VIRTUAL_SHIPPING . ' where shipping_code = "' . $shipping_code . '"';
            $check_method_code = $db->Execute($check_method_code_query);
            
            if($check_method_code->RecordCount() > 0){
                $return_array['error'] = true;
                $return_array['error_info'] = '该虚拟海外仓运输方式已存在，请勿重复创建!';
            }
        }
        
        echo json_encode($return_array);
        exit;
        break;
        
    case 'create':
        $shipping_code = zen_db_prepare_input(strtolower($_POST['shipping_virtual_method_code']));
        $method_file = $_FILES['method_file'];
        $postcode_file = $_FILES['postcode_file'];
        $postage_file = $_FILES['postage_file'];
        $error_array = array(
            'error' => false ,
            'error_detail' => array(
                'method_error' => '',
                'postcode_error' => '',
                'postage_error' => ''
            )
        );
        
        $check_same_shipping_query = 'select shipping_id from ' . TABLE_VIRTUAL_SHIPPING . ' where shipping_code = "' . $shipping_code . '"';
        $check_same_shipping = $db->Execute($check_same_shipping_query);
        if($check_same_shipping->RecordCount() > 0){
            $messageStack->add_session('该虚拟海外仓运输方式已存在！','error');
            zen_redirect(zen_href_link('shipping_virtual_methods'));
        }
        
        if($method_file['error'] || empty($method_file)){
            $error_array['error'] = true;
            $error_array['error_detail']['method_error'] = '该文件上传错误！';
        }
        
        if($postcode_file['error'] || empty($postcode_file)){
            $error_array['error'] = true;
            $error_array['error_detail']['postcode_error'] = '该文件上传错误！';
        }
        
        if($postage_file['error'] || empty($postage_file)){
            $error_array['error'] = true;
            $error_array['error_detail']['postage_error'] = '该文件上传错误！';
        }
        
        if(!$error_array['error']){
            $method_file_name = basename($method_file['name']);
            $file_ext = substr($method_file_name, strrpos($method_file_name, '.') + 1);
            
            if($file_ext!='xlsx' && $file_ext!='xls'){
                $error_array['error'] = true;
                $error_array['error_detail']['method_error'] = '请上传正确格式的文件';
            }else{
                set_time_limit(0);
                
                $method_file_from = $method_file['tmp_name'];
                set_include_path('../Classes/');
                include 'PHPExcel.php';
                if($file_ext=='xlsx'){
                    include 'PHPExcel/Reader/Excel2007.php';
                    $method_objReader = new PHPExcel_Reader_Excel2007;
                }else{
                    include 'PHPExcel/Reader/Excel5.php';
                    $method_objReader = new PHPExcel_Reader_Excel5;
                }
                
                $method_objPHPExcel = $method_objReader->load($method_file_from);
                $method_sheet = $method_objPHPExcel->getActiveSheet();
                
                for ($j=2; $j <= $method_sheet->getHighestRow(); $j++){
                    $virtual_shipping_status = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(0,$j)->getValue()));
                    $virtual_shipping_code = zen_db_prepare_input(strtolower(trim($method_sheet->getCellByColumnAndRow(4,$j)->getValue())));
                    $virtual_shipping_range = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(10,$j)->getValue()));
                    
                    if($shipping_code == $virtual_shipping_code){
                        if($virtual_shipping_range == '国内') {
                            if($virtual_shipping_status != '暂停'){
                                $virtual_shipping_erp_id = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(1,$j)->getValue()));
                                $virtual_shipping_name = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(2,$j)->getValue()));
                                $virtual_shipping_warehouse = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(6,$j)->getValue()));
                                $virtual_shipping_warehouse_oversea = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(7,$j)->getValue()));
                                $virtual_shipping_country_code = zen_db_prepare_input(strtoupper(trim($method_sheet->getCellByColumnAndRow(9,$j)->getValue())));
                                $virtual_shipping_fuel_surcharge_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(12,$j)->getValue()));
                                $virtual_shipping_fuel_surcharge =  str_replace('%', '', $virtual_shipping_fuel_surcharge_str);
                                $virtual_shipping_vat_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(13,$j)->getValue()));
                                $virtual_shipping_vat = str_replace('%', '', $virtual_shipping_vat_str);
                                $virtual_shipping_discount_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(16,$j)->getValue()));
                                $virtual_shipping_discount = str_replace('%', '', $virtual_shipping_discount_str);
                                $virtual_shipping_cal_remote_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(17,$j)->getValue()));
                                $virtual_shipping_cal_remote = $virtual_shipping_cal_remote_str == '是' ? 10 : 20;
                                $virtual_shipping_weight_type_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(18,$j)->getValue()));

                                if(in_array($virtual_shipping_weight_type_str, array('重量', '体积重量', '两者取大'))){
                                    switch ($virtual_shipping_weight_type_str){
                                        case '重量':
                                            $virtual_shipping_weight_type = 10;
                                            break;
                                        case '体积重量':
                                            $virtual_shipping_weight_type = 20;
                                            break;
                                        case '两者取大':
                                            $virtual_shipping_weight_type = 30;
                                            break;
                                    }
                                }else{
                                    $error_array['error'] = true;
                                    $error_array['error_detail']['method_error'] = '重量取值方式错误,请核对';
                                    break;
                                }

                                $virtual_shipping_guideline_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(19,$j)->getValue()));

                                if($virtual_shipping_cal_remote == 10){
                                    if(in_array($virtual_shipping_guideline_str, array('国际标准', '仅邮编'))){
                                        switch ($virtual_shipping_guideline_str){
                                            case '国际标准':
                                                $virtual_shipping_guideline = 10;
                                                break;
                                            case '仅邮编':
                                                $virtual_shipping_guideline = 20;
                                                break;
                                        }
                                    }else{
                                        $error_array['error'] = true;
                                        $error_array['error_detail']['method_error'] = '参考标准错误,请核对';
                                        break;
                                    }
                                }

                                $virtual_shipping_remote_cal_type_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(20,$j)->getValue()));
                                if($virtual_shipping_cal_remote == 10){
                                    switch ($virtual_shipping_remote_cal_type_str){
                                        case '总乘':
                                            $virtual_shipping_remote_cal_type = 20;
                                            break;
                                        case '额定值':
                                            $virtual_shipping_remote_cal_type = 30;
                                            break;
                                        default:
                                            $virtual_shipping_remote_cal_type = 10;
                                            break;
                                    }
                                }

                                $virtual_shipping_remote_fee = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(21,$j)->getValue()));
    //                             if($virtual_shipping_cal_remote == 10){
    //                                 if($virtual_shipping_remote_fee <= 0){
    //                                     $error_array['error'] = true;
    //                                     $error_array['error_detail']['method_error'] = '每公斤费用错误,请核对';
    //                                     break;
    //                                 }
    //                             }

                                $virtual_shipping_remote_min_fee_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(22,$j)->getValue()));
    //                             if($virtual_shipping_cal_remote == 10){
    //                                 if($virtual_shipping_remote_min_fee_str < 0 || $virtual_shipping_remote_min_fee_str == ''){
    //                                     $virtual_shipping_remote_min_fee = 0;
    //                                 }else{
                                        $virtual_shipping_remote_min_fee  = (int)$virtual_shipping_remote_min_fee_str;
    //                                 }
    //                             }

                                $virtual_shipping_limit_split_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(23,$j)->getValue()));
                                $virtual_shipping_limit_split = $virtual_shipping_limit_split_str == '是' ? 10 : 20;
                                $virtual_shipping_track_url = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(24,$j)->getValue()));

                                $check_country_id_query = 'select countries_id from ' . TABLE_COUNTRIES . ' where countries_iso_code_2 = "' . $virtual_shipping_country_code . '"';
                                $check_country_id = $db->Execute($check_country_id_query);

                                if($check_country_id->RecordCount() > 0){
                                    if(!$error_array['error']){
                                        $virtual_shipping_info_data = array(
                                            'shipping_erp_id' => $virtual_shipping_erp_id,
                                            'shipping_code' => $virtual_shipping_code,
                                            'country_code' => $virtual_shipping_country_code,
                                            'shipping_name' => $virtual_shipping_name,
                                            'shipping_warehouse' => $virtual_shipping_warehouse,
                                            'shipping_warehouse_virtual_overseas' => $virtual_shipping_warehouse_oversea,
                                            'shipping_fuel_surcharge' => $virtual_shipping_fuel_surcharge,
                                            'shipping_vat' => $virtual_shipping_vat,
                                            'shipping_discount' => $virtual_shipping_discount,
                                            'cal_remote' => $virtual_shipping_cal_remote,
                                            'cal_weight_type' => $virtual_shipping_weight_type,
                                            'remote_guideline' => $virtual_shipping_guideline,
                                            'remote_cal_type' => $virtual_shipping_remote_cal_type,
                                            'remote_min_fee' => $virtual_shipping_remote_min_fee,
                                            'remote_fee' => $virtual_shipping_remote_fee,
                                            'limit_split' => $virtual_shipping_limit_split,
                                            'track_url' => $virtual_shipping_track_url,
                                            'shipping_status' => 10,
                                            'create_admin' => $_SESSION['admin_email'],
                                            'create_datetime' => 'now()'
                                        );

                                        zen_db_perform(TABLE_VIRTUAL_SHIPPING, $virtual_shipping_info_data);
                                        $virtual_shipping_id = $db->Insert_ID ();
                                    }
                                    break;
                                }else{
                                    $error_array['error'] = true;
                                    $error_array['error_detail']['method_error'] = '发货国家code错误,请核对';
                                    break;
                                }

                            }else{
                                $error_array['error'] = true;
                                $error_array['error_detail']['method_error'] = '暂停运输方式，不能创建。';
                                break;
                            }
                        }else{
                            $error_array['error'] = true;
                            $error_array['error_detail']['method_error'] = '必须是国内运输方式，不能创建。';
                            break;
                        }
                    }
                }
                
                if($virtual_shipping_code != '' && sizeof($virtual_shipping_info_data) > 0 && $virtual_shipping_id > 0 && !$error_array['error']){
                    $postcode_file_name = basename($postcode_file['name']);
                    $file_ext = substr($postcode_file_name, strrpos($postcode_file_name, '.') + 1);
                    
                    if($file_ext!='xlsx' && $file_ext!='xls'){
                        $error_array['error'] = true;
                        $error_array['error_detail']['postcode_error'] = '请上传正确格式的文件';
                    }else{
                        $postcode_file_from = $postcode_file['tmp_name'];
                        
                        if($file_ext=='xlsx'){
                            include_once 'PHPExcel/Reader/Excel2007.php';
                            $postcode_objReader = new PHPExcel_Reader_Excel2007;
                        }else{
                            include_once 'PHPExcel/Reader/Excel5.php';
                            $postcode_objReader = new PHPExcel_Reader_Excel5;
                        }
                        
                        $postcode_objPHPExcel = $postcode_objReader->load($postcode_file_from);
                        $postcode_sheet = $postcode_objPHPExcel->getActiveSheet();
                        $success_num = 0;
                        for ($j=2; $j <= $postcode_sheet->getHighestRow(); $j++){
                            $postage_shipping_erp_id = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(0,$j)->getValue()));
                            
                            if($postage_shipping_erp_id == $virtual_shipping_erp_id){
                                $shipping_area_code = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(1,$j)->getValue()));
                                $shipping_post_code_start = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(2,$j)->getValue()));
                                $shipping_post_code_end = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(3,$j)->getValue()));
                                $shipping_transport_min = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(4,$j)->getValue()));
                                $shipping_transport_max = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(5,$j)->getValue()));
                                $shipping_singleticket_limit = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(6,$j)->getValue()));
                                $shipping_singlepiece_limit = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(7,$j)->getValue()));
                                
                                if(!$error_array['error']){
                                    $shipping_postcode_data = array(
                                        'shipping_id' => $virtual_shipping_id,
                                        'shipping_erp_id' => $virtual_shipping_erp_id,
                                        'shipping_code' => $virtual_shipping_code,
                                        'shipping_area_code' => $shipping_area_code,
                                        'shipping_post_code_start' => $shipping_post_code_start,
                                        'shipping_post_code_end' => $shipping_post_code_end,
                                        'shipping_singlepiece_limit' => $shipping_singlepiece_limit,
                                        'shipping_singleticket_limit' => $shipping_singleticket_limit,
                                        'shipping_transport_min' => $shipping_transport_min,
                                        'shipping_transport_max' => $shipping_transport_max,
                                        'create_admin' => $_SESSION['admin_email'],
                                        'create_datetime' => 'now()'
                                    );
                                    
                                    zen_db_perform(TABLE_VIRTUAL_SHIPPING_AREA_POSTCODE, $shipping_postcode_data);
                                    $success_num++;
                                }
                            }
                        }
                    }
                    
                    if($success_num == 0){
                        $error_array['error'] = true;
                        $error_array['error_detail']['postcode_error'] = '请检查区域邮编表！';
                    }
                    
                    if(!$error_array['error']){
                        $postage_file_name = basename($postage_file['name']);
                        $file_ext = substr($postcode_file_name, strrpos($postcode_file_name, '.') + 1);
                        
                        if($file_ext!='xlsx' && $file_ext!='xls'){
                            $error_array['error'] = true;
                            $error_array['error_detail']['postage_error'] = '请上传正确格式的文件';
                        }else{
                            $postage_file_from = $postage_file['tmp_name'];
                            if($file_ext=='xlsx'){
                                include_once 'PHPExcel/Reader/Excel2007.php';
                                $postage_objReader = new PHPExcel_Reader_Excel2007;
                            }else{
                                include_once 'PHPExcel/Reader/Excel5.php';
                                $postage_objReader = new PHPExcel_Reader_Excel5;
                            }
                            
                            $postage_objPHPExcel = $postage_objReader->load($postage_file_from);
                            $postage_sheet = $postage_objPHPExcel->getActiveSheet();
                            $success_num = 0;
                            for ($j=2; $j <= $postage_sheet->getHighestRow(); $j++){
                                $postage_shipping_erp_id = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(1,$j)->getValue()));
                                
                                if($postage_shipping_erp_id == $virtual_shipping_erp_id){
                                    $shipping_area_code = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(2,$j)->getValue()));
                                    $shipping_amount = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(4,$j)->getValue()));
                                    $shipping_incremental_type = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(5,$j)->getValue()));
                                    $shipping_incremental_weight = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(3,$j)->getValue()));
                                    $shipping_incremental_unit = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(6,$j)->getValue()));
                                    $shipping_incremental_price = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(7,$j)->getValue()));
                                    
                                    if(!$error_array['error']){
                                        $shipping_virtual_postage_data = array(
                                            'shipping_id' => $virtual_shipping_id,
                                            'shipping_erp_id' => $virtual_shipping_erp_id,
                                            'shipping_code' => $virtual_shipping_code,
                                            'shipping_area_code' => $shipping_area_code,
                                            'shipping_amount' => $shipping_amount,
                                            'shipping_incremental_type' => $shipping_incremental_type,
                                            'shipping_incremental_weight' => $shipping_incremental_weight,
                                            'shipping_incremental_unit' => $shipping_incremental_unit,
                                            'shipping_incremental_price' => $shipping_incremental_price,
                                            'create_admin' => $_SESSION['admin_email'],
                                            'create_datetime' => 'now()'
                                        );
                                        
                                        zen_db_perform(TABLE_VIRTUAL_SHIPPING_AREA_POSTAGE, $shipping_virtual_postage_data);
                                        $success_num++;
                                    }
                                }
                            }
                            
                            if($success_num == 0){
                                $error_array['error'] = true;
                                $error_array['error_detail']['postage_error'] = '请检查区域运费表！';
                            }
                        }
                    }
                }
            }
        }
        
        if($error_array['error']){
            $_SESSION['virtual_shipping_error'] = $error_array;
            zen_redirect(zen_href_link('shipping_virtual_methods', 'action=new'));
        }else{
            $messageStack->add_session('该虚拟海外仓运输方式创建成功！','success');
            zen_redirect(zen_href_link('shipping_virtual_methods'));
        }
        break;
    case 'update':
        $shipping_code = zen_db_prepare_input(strtolower($_POST['shipping_virtual_method_code']));
        $method_file = $_FILES['method_file'];
        $postcode_file = $_FILES['postcode_file'];
        $postage_file = $_FILES['postage_file'];
        $error_array = array(
            'error' => false ,
            'error_detail' => array(
                'method_error' => '',
                'postcode_error' => '',
                'postage_error' => ''
            )
        );
        
        if($method_file['error'] || empty($method_file)){
            $error_array['error'] = true;
            $error_array['error_detail']['method_error'] = '该文件上传错误！';
        }
        
        if($postcode_file['error'] || empty($postcode_file)){
            $error_array['error'] = true;
            $error_array['error_detail']['postcode_error'] = '该文件上传错误！';
        }
        
        if($postage_file['error'] || empty($postage_file)){
            $error_array['error'] = true;
            $error_array['error_detail']['postage_error'] = '该文件上传错误！';
        }
        
        if(!$error_array['error']){
            $method_file_name = basename($method_file['name']);
            $file_ext = substr($method_file_name, strrpos($method_file_name, '.') + 1);
            
            if($file_ext!='xlsx' && $file_ext!='xls'){
                $error_array['error'] = true;
                $error_array['error_detail']['method_error'] = '请上传正确格式的文件';
            }else{
                set_time_limit(0);
                
                $method_file_from = $method_file['tmp_name'];
                set_include_path('../Classes/');
                include 'PHPExcel.php';
                if($file_ext=='xlsx'){
                    include 'PHPExcel/Reader/Excel2007.php';
                    $method_objReader = new PHPExcel_Reader_Excel2007;
                }else{
                    include 'PHPExcel/Reader/Excel5.php';
                    $method_objReader = new PHPExcel_Reader_Excel5;
                }
                
                $method_objPHPExcel = $method_objReader->load($method_file_from);
                $method_sheet = $method_objPHPExcel->getActiveSheet();
                
                for ($j=2; $j <= $method_sheet->getHighestRow(); $j++){
                    $virtual_shipping_code = zen_db_prepare_input(strtolower(trim($method_sheet->getCellByColumnAndRow(4,$j)->getValue())));
                    $virtual_shipping_range = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(10,$j)->getValue()));
                    
                    if($shipping_code == $virtual_shipping_code){
                        if($virtual_shipping_range == '国内') {
                            $check_shipping_query = $db->Execute('select shipping_id from ' . TABLE_VIRTUAL_SHIPPING . ' where shipping_code = "' . $shipping_code . '"');

                            if ($check_shipping_query->RecordCount() > 0) {
                                $virtual_shipping_id = $check_shipping_query->fields['shipping_id'];
                                $virtual_shipping_status_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(0, $j)->getValue()));
                                $virtual_shipping_erp_id = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(1, $j)->getValue()));
                                $virtual_shipping_status = ($virtual_shipping_status_str == '暂停' ? 20 : 10);
                                $virtual_shipping_name = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(2, $j)->getValue()));
                                $virtual_shipping_fuel_surcharge_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(12, $j)->getValue()));
                                $virtual_shipping_fuel_surcharge = str_replace('%', '', $virtual_shipping_fuel_surcharge_str);
                                $virtual_shipping_vat_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(13, $j)->getValue()));
                                $virtual_shipping_vat = str_replace('%', '', $virtual_shipping_vat_str);
                                $virtual_shipping_discount_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(16, $j)->getValue()));
                                $virtual_shipping_discount = str_replace('%', '', $virtual_shipping_discount_str);
                                $virtual_shipping_cal_remote_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(17, $j)->getValue()));
                                $virtual_shipping_cal_remote = $virtual_shipping_cal_remote_str == '是' ? 10 : 20;
                                $virtual_shipping_weight_type_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(18, $j)->getValue()));

                                if (in_array($virtual_shipping_weight_type_str, array('重量', '体积重量', '两者取大'))) {
                                    switch ($virtual_shipping_weight_type_str) {
                                        case '重量':
                                            $virtual_shipping_weight_type = 10;
                                            break;
                                        case '体积重量':
                                            $virtual_shipping_weight_type = 20;
                                            break;
                                        case '两者取大':
                                            $virtual_shipping_weight_type = 30;
                                            break;
                                    }
                                } else {
                                    $error_array['error'] = true;
                                    $error_array['error_detail']['method_error'] = '重量取值方式错误,请核对';
                                    break;
                                }

                                $virtual_shipping_guideline_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(19, $j)->getValue()));

                                if ($virtual_shipping_cal_remote == 10) {
                                    if (in_array($virtual_shipping_guideline_str, array('国际标准', '仅邮编'))) {
                                        switch ($virtual_shipping_guideline_str) {
                                            case '国际标准':
                                                $virtual_shipping_guideline = 10;
                                                break;
                                            case '仅邮编':
                                                $virtual_shipping_guideline = 20;
                                                break;
                                        }
                                    } else {
                                        $error_array['error'] = true;
                                        $error_array['error_detail']['method_error'] = '参考标准错误,请核对';
                                        break;
                                    }
                                }

                                $virtual_shipping_remote_cal_type_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(20, $j)->getValue()));
                                if ($virtual_shipping_cal_remote == 10) {
                                    switch ($virtual_shipping_remote_cal_type_str) {
                                        case '总乘':
                                            $virtual_shipping_remote_cal_type = 20;
                                            break;
                                        case '额定值':
                                            $virtual_shipping_remote_cal_type = 30;
                                            break;
                                        default:
                                            $virtual_shipping_remote_cal_type = 10;
                                            break;
                                    }
                                }

                                $virtual_shipping_remote_fee = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(21, $j)->getValue()));
//                             if($virtual_shipping_cal_remote == 10){
//                                 if($virtual_shipping_remote_fee <= 0){
//                                     $error_array['error'] = true;
//                                     $error_array['error_detail']['method_error'] = '每公斤费用错误,请核对';
//                                     break;
//                                 }
//                             }

                                $virtual_shipping_remote_min_fee_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(22, $j)->getValue()));
//                             if($virtual_shipping_cal_remote == 10){
//                                 if($virtual_shipping_remote_min_fee_str < 0 || $virtual_shipping_remote_min_fee_str == ''){
//                                     $virtual_shipping_remote_min_fee = 0;
//                                 }else{
                                $virtual_shipping_remote_min_fee = (int)$virtual_shipping_remote_min_fee_str;
//                                 }
//                             }

                                $virtual_shipping_limit_split_str = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(23, $j)->getValue()));
                                $virtual_shipping_limit_split = $virtual_shipping_limit_split_str == '是' ? 10 : 20;
                                $virtual_shipping_track_url = zen_db_prepare_input(trim($method_sheet->getCellByColumnAndRow(24, $j)->getValue()));

                                if (!$error_array['error']) {
                                    $virtual_shipping_info_data = array(
                                        'shipping_name' => $virtual_shipping_name,
                                        'shipping_fuel_surcharge' => $virtual_shipping_fuel_surcharge,
                                        'shipping_vat' => $virtual_shipping_vat,
                                        'shipping_discount' => $virtual_shipping_discount,
                                        'cal_remote' => $virtual_shipping_cal_remote,
                                        'cal_weight_type' => $virtual_shipping_weight_type,
                                        'remote_guideline' => $virtual_shipping_guideline,
                                        'remote_cal_type' => $virtual_shipping_remote_cal_type,
                                        'remote_min_fee' => $virtual_shipping_remote_min_fee,
                                        'remote_fee' => $virtual_shipping_remote_fee,
                                        'limit_split' => $virtual_shipping_limit_split,
                                        'track_url' => $virtual_shipping_track_url,
                                        'shipping_status' => $virtual_shipping_status,
                                        'modify_admin' => $_SESSION['admin_email'],
                                        'modify_datetime' => 'now()'
                                    );

                                    zen_db_perform(TABLE_VIRTUAL_SHIPPING, $virtual_shipping_info_data, 'update', 'shipping_code ="' . $shipping_code . '"');
                                }
                                break;
                            } else {
                                $error_array['error'] = true;
                                $error_array['error_detail']['method_error'] = '此虚拟海外仓运输方式不存在。';
                                break;
                            }
                        }else{
                            $error_array['error'] = true;
                            $error_array['error_detail']['method_error'] = '必须是国内运输方式，不能更新。';
                            break;
                        }
                    }
                }
                
                if($virtual_shipping_code != '' && sizeof($virtual_shipping_info_data) > 0 && $virtual_shipping_id > 0 && !$error_array['error']){
                    $postcode_file_name = basename($postcode_file['name']);
                    $file_ext = substr($postcode_file_name, strrpos($postcode_file_name, '.') + 1);
                    
                    if($file_ext!='xlsx' && $file_ext!='xls'){
                        $error_array['error'] = true;
                        $error_array['error_detail']['postcode_error'] = '请上传正确格式的文件';
                    }else{
                        $postcode_file_from = $postcode_file['tmp_name'];
                        
                        if($file_ext=='xlsx'){
                            include_once 'PHPExcel/Reader/Excel2007.php';
                            $postcode_objReader = new PHPExcel_Reader_Excel2007;
                        }else{
                            include_once 'PHPExcel/Reader/Excel5.php';
                            $postcode_objReader = new PHPExcel_Reader_Excel5;
                        }
                        
                        $postcode_objPHPExcel = $postcode_objReader->load($postcode_file_from);
                        $postcode_sheet = $postcode_objPHPExcel->getActiveSheet();
                        $success_num = 0;
                        for ($j=2; $j <= $postcode_sheet->getHighestRow(); $j++){
                            $postage_shipping_erp_id = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(0,$j)->getValue()));
                            
                            if($postage_shipping_erp_id == $virtual_shipping_erp_id){
                                $shipping_area_code = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(1,$j)->getValue()));
                                $shipping_post_code_start = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(2,$j)->getValue()));
                                $shipping_post_code_end = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(3,$j)->getValue()));
                                $shipping_transport_min = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(4,$j)->getValue()));
                                $shipping_transport_max = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(5,$j)->getValue()));
                                $shipping_singleticket_limit = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(6,$j)->getValue()));
                                $shipping_singlepiece_limit = zen_db_prepare_input(trim($postcode_sheet->getCellByColumnAndRow(7,$j)->getValue()));
                                
                                $shipping_postcode_data[] = array(
                                    'shipping_id' => $virtual_shipping_id,
                                    'shipping_erp_id' => $virtual_shipping_erp_id,
                                    'shipping_code' => $virtual_shipping_code,
                                    'shipping_area_code' => $shipping_area_code,
                                    'shipping_post_code_start' => $shipping_post_code_start,
                                    'shipping_post_code_end' => $shipping_post_code_end,
                                    'shipping_singlepiece_limit' => $shipping_singlepiece_limit,
                                    'shipping_singleticket_limit' => $shipping_singleticket_limit,
                                    'shipping_transport_min' => $shipping_transport_min,
                                    'shipping_transport_max' => $shipping_transport_max,
                                    'modify_admin' => $_SESSION['admin_email'],
                                    'modify_datetime' => 'now()'
                                );
                            }
                        }
                       
                        if(sizeof($shipping_postcode_data) > 0){
                            $db->Execute('DELETE from ' . TABLE_VIRTUAL_SHIPPING_AREA_POSTCODE . ' WHERE shipping_code = "' . $shipping_code . '"');
                            foreach ($shipping_postcode_data as $values){
                                zen_db_perform(TABLE_VIRTUAL_SHIPPING_AREA_POSTCODE, $values);
                                $success_num++;
                            }
                        }
                    }
                    
                    if($success_num == 0){
                        $error_array['error'] = true;
                        $error_array['error_detail']['postcode_error'] = '请检查区域邮编表！';
                    }
                    
                    if(!$error_array['error']){
                        $postage_file_name = basename($postage_file['name']);
                        $file_ext = substr($postcode_file_name, strrpos($postcode_file_name, '.') + 1);
                        
                        if($file_ext!='xlsx' && $file_ext!='xls'){
                            $error_array['error'] = true;
                            $error_array['error_detail']['postage_error'] = '请上传正确格式的文件';
                        }else{
                            $postage_file_from = $postage_file['tmp_name'];
                            if($file_ext=='xlsx'){
                                include_once 'PHPExcel/Reader/Excel2007.php';
                                $postage_objReader = new PHPExcel_Reader_Excel2007;
                            }else{
                                include_once 'PHPExcel/Reader/Excel5.php';
                                $postage_objReader = new PHPExcel_Reader_Excel5;
                            }
                            
                            $postage_objPHPExcel = $postage_objReader->load($postage_file_from);
                            $postage_sheet = $postage_objPHPExcel->getActiveSheet();
                            $success_num = 0;
                            for ($j=2; $j <= $postage_sheet->getHighestRow(); $j++){
                                $postage_shipping_erp_id = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(1,$j)->getValue()));
                                
                                if($postage_shipping_erp_id == $virtual_shipping_erp_id){
                                    $shipping_area_code = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(2,$j)->getValue()));
                                    $shipping_amount = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(4,$j)->getValue()));
                                    $shipping_incremental_type = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(5,$j)->getValue()));
                                    $shipping_incremental_weight = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(3,$j)->getValue()));
                                    $shipping_incremental_unit = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(6,$j)->getValue()));
                                    $shipping_incremental_price = zen_db_prepare_input(trim($postage_sheet->getCellByColumnAndRow(7,$j)->getValue()));
                                    
                                    $shipping_virtual_postage_data[] = array(
                                        'shipping_id' => $virtual_shipping_id,
                                        'shipping_erp_id' => $virtual_shipping_erp_id,
                                        'shipping_code' => $virtual_shipping_code,
                                        'shipping_area_code' => $shipping_area_code,
                                        'shipping_amount' => $shipping_amount,
                                        'shipping_incremental_type' => $shipping_incremental_type,
                                        'shipping_incremental_weight' => $shipping_incremental_weight,
                                        'shipping_incremental_unit' => $shipping_incremental_unit,
                                        'shipping_incremental_price' => $shipping_incremental_price,
                                        'modify_admin' => $_SESSION['admin_email'],
                                        'modify_datetime' => 'now()'
                                    );
                                }
                            }
                            
                            if(sizeof($shipping_virtual_postage_data) > 0){
                                $db->Execute('DELETE from ' . TABLE_VIRTUAL_SHIPPING_AREA_POSTAGE . ' WHERE shipping_code = "' . $shipping_code . '"');
                                foreach ($shipping_virtual_postage_data as $values){
                                    zen_db_perform(TABLE_VIRTUAL_SHIPPING_AREA_POSTAGE, $values);
                                    $success_num++;
                                }
                            }
                            
                            if($success_num == 0){
                                $error_array['error'] = true;
                                $error_array['error_detail']['postage_error'] = '请检查区域运费表！';
                            }
                        }
                    }
                }
            }
        }
        
        if($error_array['error']){
            $_SESSION['virtual_shipping_error'] = $error_array;
            zen_redirect(zen_href_link('shipping_virtual_methods', zen_get_all_get_params(array('action')) . 'action=edit'));
        }else{
            $messageStack->add_session('该虚拟海外仓运输方式更新成功！','success');
            zen_redirect(zen_href_link('shipping_virtual_methods', zen_get_all_get_params(array('action'))));
        }
        
        break;
}
?>

<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>虚拟海外仓运输方式</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
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
	function process_json(data){
		var returnInfo=eval('('+data+')');
		return returnInfo;
	}

  function check_form(formName){
	var shipping_code = $('input[name=shipping_virtual_method_code]').val();
	var method_file = $('input[name=method_file]').val();
	var postcode_file = $('input[name=postcode_file]').val();
	var postage_file = $('input[name=postage_file]').val();
// 	var form_data = new FormData($('#' + formName)[0]);
	var error = false;

	$('.code_error').html('');
	$('.method_file_error').html('');
	$('.postcode_file_error').html('');
	$('.postage_file_error').html('');

	if(shipping_code == ''){
		error = true
		$('.code_error').html('运输方式代码不能为空！');
	}

	if(method_file == ''){
		error = true
		$('.method_file_error').html('请上传文件');
	}else{
		var fileType_l = method_file.substr(method_file.length-5, method_file.length);
		var fileType_s = method_file.substr(method_file.length-4, method_file.length);
		
		if(!(fileType_l == '.xlsx' || fileType_s == '.xls')){
			$('.method_file_error').html('请上传正确格式的文件');
		}
	}
	
	if(postcode_file == ''){
		error = true
		$('.postcode_file_error').html('请上传文件');
	}else{
		var fileType_l = postcode_file.substr(postcode_file.length-5, postcode_file.length);
		var fileType_s = postcode_file.substr(postcode_file.length-4, postcode_file.length);
		
		if(!(fileType_l == '.xlsx' || fileType_s == '.xls')){
			$('.postcode_file_error').html('请上传正确格式的文件');
		}
	}
	
	if(postage_file == ''){
		error = true
		$('.postage_file_error').html('请上传文件');
	}else{
		var fileType_l = postage_file.substr(postage_file.length-5, postage_file.length);
		var fileType_s = postage_file.substr(postage_file.length-4, postage_file.length);
		
		if(!(fileType_l == '.xlsx' || fileType_s == '.xls')){
			$('.postage_file_error').html('请上传正确格式的文件');
		}
	}
	
	if(!error && formName == 'create_form'){
    	$.ajax({
    		'url' :'shipping_virtual_methods.php',
    		'type':'post',
    		'data':{'action':'check_form' , 'shipping_code' : shipping_code },
    		'async':false,
    		'success':function(data){
    			var returnInfo = process_json(data);
    			
    			if(returnInfo.error == true){
    				$(".code_error").text(returnInfo.error_info);
    				error = true;
    			}
    		}
    	}); 
	}

	return !error;
  }
</script>
<style>
 .info_red{
 	color:red;
 	padding-left:20px;
 	margin: 5px;
 }
 .simple_button{
    background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
    border: 1px solid #656462;
    border-radius: 3px 3px 3px 3px;
    cursor: pointer;
    padding: 3px 20px;
 }
 .listshow{
	margin: 0;
    padding: 5px 10px;
 }
 .star_red{
    color:red;
 }
 
</style>
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php');?>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
      <tr>
      	<td width="100%" valign="top" style="padding: 20px;" colspan=2>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            	<tbody>
            	<tr>
                    <td class="pageHeading"><span style="font-size: 20px;">虚拟海外仓运输方式</span></td>
                    <td align="right" class="pageHeading" style="float: right;">
                    <?php echo zen_draw_form('search_form', 'shipping_virtual_methods' , '' , 'get' , 'id="search_form"')?>
        				<table border="0" width="100%" cellspacing="0" cellpadding="3">
        					<tr><td style="float: right;">状态：</td><td><?php echo zen_draw_pull_down_menu('status' , $status_arr , (isset($_GET['status'])?$_GET['status']: 0) , 'style="width:200px;height:20px;"');?></td></tr>
        					<tr><td style="float: right;">ERP ID：</td><td><?php echo zen_draw_input_field('erp_id', (isset($_GET['erp_id'])?$_GET['erp_id']: '') , 'style="width:200px;height:20px;"');?></td></tr>
        					<tr>
        						<td colspan="2">
        							<?php echo  zen_draw_input_field('button','搜索','onclick="document.getElementById(\'search_form\').submit();" style="width:70px;height:25px;float: right;cursor: pointer;"',false,'button');?>
        						</td>
        					</tr>
        				</table>
        			<?php echo '</form>'; ?>
        			</td>
                </tr>
        		</tbody>
        	</table>
        </td>
      </tr>
      <tr>
      	<td valign="top" width="70%">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
          	<tr>
                <td valign="top" width='80%'>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                      <tr class="dataTableHeadingRow">
                        <td class="dataTableHeadingContent" align="left">ID</td> 
                        <td class="dataTableHeadingContent" align="center">ERP ID</td>
                        <td class="dataTableHeadingContent" align="center">Code</td>
                        <td class="dataTableHeadingContent" align="center">国家</td>
                        <td class="dataTableHeadingContent" align="center">状态</td>
                        <td class="dataTableHeadingContent" align="right">操作</td>
                      </tr>
                      <?php
                      while(!$shipping_virtual_methods->EOF){
                          $i = 1;
                          if ((!isset($_GET['sID']) || (isset($_GET['sID']) && ($_GET['sID'] == $shipping_virtual_methods->fields['shipping_id']))) && !isset($sInfo)) {
                              $sInfo_array = $shipping_virtual_methods->fields;
                              $sInfo = new objectInfo($sInfo_array);
                              $_GET['page'] = ceil($i / 20);
                          }
                          $i++;
                      	?>
        	              <tr class="dataTableRow">
        	                <td class="dataTableHeadingContent" align="left"><?php echo $shipping_virtual_methods->fields['shipping_id'] ?></td> 
        	                <td class="dataTableHeadingContent" align="center"><?php echo $shipping_virtual_methods->fields['shipping_erp_id'] ?></td>
        	                 <td class="dataTableHeadingContent" align="center"><?php echo $shipping_virtual_methods->fields['shipping_code'] ?></td>
        	                <td class="dataTableHeadingContent" align="center"><?php echo $shipping_virtual_methods->fields['countries_name'] ?></td>
        	                <td class="dataTableHeadingContent" align="center"><?php echo $shipping_virtual_methods->fields['shipping_status'] == 10 ? '开启' : '暂停' ?></td>
        	                <td class="dataTableContent" align="right">
                		<?php echo '<a href="' . zen_href_link('shipping_virtual_methods', zen_get_all_get_params(array('sID', 'erp_id' , 'type' , 'status', 'action' )) . 'sID=' . $shipping_virtual_methods->fields['shipping_id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>&nbsp;
                		<?php if ( (is_object($sInfo)) && ($shipping_virtual_methods->fields['shipping_id'] == $sInfo->shipping_id) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link('shipping_virtual_methods', zen_get_all_get_params(array('action' , 'sID' , 'page' , 'status' , 'pName')) . 'page=' . $pageIndex . '&sID=' . $shipping_virtual_methods->fields['shipping_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>
                	</td>
        	              </tr>
                     <?php 	$shipping_virtual_methods->MoveNext();
                      }
                      ?>
                      </table>
                   	</td>
                  </tr>
                  <tr>
    	              <td style="padding-top: 10px;">
    		              <table border="0" width="100%" cellspacing="0" cellpadding="2">
    		              <tr>
    		             	 <td class="dataTableHeadingContent" colspan="3" align="left"><?php echo $shipping_virtual_methods_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS,$pageIndex, TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
    		                <td class="dataTableHeadingContent" colspan="5" align="right"><?php echo $shipping_virtual_methods_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $pageIndex, zen_get_all_get_params(array('page', 'id')) . '&products_key=' . urlencode($_GET['products_key'])); ?></td>
    		              </tr>
    		              </table>
    	              </td>
                  </tr>
                  <tr>
                    <td align="right">
                    	<a href='<?php  echo zen_href_link('shipping_virtual_methods','action=new&page='.(isset($_GET['page'])?$_GET['page']:'1'))?>'><button class='simple_button'>新建</button></a>
                    </td>
                  </tr>
                </td>
            </tr>
          </tbody>
          </table>
    	</td>
    	<?php 
        	if($action == 'new'){?>
        	    <td valign="top" >
            	    <div class="infoBoxContent">
                	    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                    	    <tbody>
                        	    <tr class="infoBoxHeading">
                        	    	<td class="infoBoxHeading"><b>新建虚拟海外仓运输方式</b></td>
                              	</tr>
                        	</tbody>
                    	</table>
                    	<?php echo zen_draw_form('create_form', 'shipping_virtual_methods', zen_get_all_get_params(array('action')), 'post', 'id="create_form" enctype="multipart/form-data"')?>
                    	<?php echo zen_draw_hidden_field('action', 'create');?>
                    	<p class="listshow"><span class="star_red">*</span><b>代码：</b><?php echo zen_draw_input_field('shipping_virtual_method_code')?></p>
                    	<p class="info_red code_error"></p>
                    	<p class="listshow"><b>运输方式：</b><?php echo zen_draw_file_field('method_file')?></p>
                    	<p class="info_red method_file_error"><?php echo $_SESSION['virtual_shipping_error']['error_detail']['method_error']; ?></p>
                    	<p class="listshow"><b>邮编区域：</b><?php echo zen_draw_file_field('postcode_file')?></p>
                    	<p class="info_red postcode_file_error"><?php echo $_SESSION['virtual_shipping_error']['error_detail']['postcode_error']; ?></p>
                    	<p class="listshow"><b>区域运费：</b><?php echo zen_draw_file_field('postage_file')?></p>
                    	<p class="info_red postage_file_error"><?php echo $_SESSION['virtual_shipping_error']['error_detail']['postage_error']; ?></p>
                    	<p class="listshow">
                    		<button class='simple_button' onclick='return check_form("create_form")'>Submit</button>
                    		<a href="<?php echo zen_href_link('shipping_virtual_methods', zen_get_all_get_params(array('action')))?>"><button type="button" class='simple_button'>Cancel</button></a>
                    	</p>
                    	<?php echo '</form>';?>
            		</div>
                 </td>
            <?php 
        	}elseif($action == 'edit'){?>
        	    <td valign="top" >
        	    <div class="infoBoxContent">
        	    <table width="100%" border="0" cellspacing="0" cellpadding="2">
        	    <tbody>
        	    <tr class="infoBoxHeading">
        	    <td class="infoBoxHeading"><b>虚拟海外仓运输方式 ERP ID: <?php echo $sInfo->shipping_erp_id;?></b></td>
        	    </tr>
        	    </tbody>
        	    </table>
        	    <?php echo zen_draw_form('update_form', 'shipping_virtual_methods', zen_get_all_get_params(array('action')), 'post', 'id="update_form" enctype="multipart/form-data"')?>
                    	<?php echo zen_draw_hidden_field('action', 'update');?>
                    	<p class="listshow"><span class="star_red">*</span><b>代码：</b><?php echo zen_draw_input_field('shipping_virtual_method_code', $sInfo->shipping_code, 'style="color:grey;" readonly=readonly')?></p>
                    	<p class="info_red code_error"></p>
                    	<p class="listshow"><b>运输方式：</b><?php echo zen_draw_file_field('method_file')?></p>
                    	<p class="info_red method_file_error"><?php echo $_SESSION['virtual_shipping_error']['error_detail']['method_error']; ?></p>
                    	<p class="listshow"><b>邮编区域：</b><?php echo zen_draw_file_field('postcode_file')?></p>
                    	<p class="info_red postcode_file_error"><?php echo $_SESSION['virtual_shipping_error']['error_detail']['postcode_error']; ?></p>
                    	<p class="listshow"><b>区域运费：</b><?php echo zen_draw_file_field('postage_file')?></p>
                    	<p class="info_red postage_file_error"><?php echo $_SESSION['virtual_shipping_error']['error_detail']['postage_error']; ?></p>
                    	<p class="listshow">
                    		<button class='simple_button' onclick='return check_form("update_form")'>Submit</button>
                    		<a href="<?php echo zen_href_link('shipping_virtual_methods', zen_get_all_get_params(array('action')))?>"><button type="button" class='simple_button'>Cancel</button></a>
                    	</p>
                    	<?php echo '</form>';?>
            		</div>
                 </td>
            <?php 
        	}else{
        	    if(isset($sInfo) && is_object($sInfo) && $sInfo->shipping_id > 0){
        	        $shipping_postcode_day_query = 'SELECT
                                                            shipping_post_code_start,
                                                            shipping_post_code_end,
                                                            shipping_transport_min,
                                                            shipping_transport_max
                                                        FROM
                                                            t_virtual_shipping_area_postcode
                                                        WHERE
                                                            shipping_id = ' . $sInfo->shipping_id;
        	        
        	        $shipping_postcode_day = $db->Execute($shipping_postcode_day_query);
        	    }
    	?>
            	<td valign="top" >
                    <div class="infoBoxContent">
                    	<table width="100%" border="0" cellspacing="0" cellpadding="2">
              				<tbody>
              					<tr class="infoBoxHeading">
                					<td class="infoBoxHeading"><b>虚拟海外仓运输方式 ERP ID: <?php echo $sInfo->shipping_erp_id;?></b></td>
              					</tr>
            				</tbody>
            			</table>
        				
        				<table width="100%" border="0" cellspacing="0" cellpadding="2">
        					<tr style="line-height: 20px;"><td style="text-align: right;"><b>ID : </b></td><td style="padding-left: 10px;"><?php echo $sInfo->shipping_id ? $sInfo->shipping_id : '/';?></td></tr>
        					<tr style="line-height: 20px;"><td style="text-align: right;"><b>ERP ID : </b></td><td style="padding-left: 10px;"><?php echo $sInfo->shipping_erp_id ? $sInfo->shipping_erp_id : '/';?></td></tr>
        					<tr style="line-height: 20px;"><td style="text-align: right;"><b>Code : </b></td><td style="padding-left: 10px;"><?php echo $sInfo->shipping_code ? $sInfo->shipping_code : '/';?></td></tr>
        					<tr style="line-height: 20px;"><td style="text-align: right;"><b>国家 : </b></td><td style="padding-left: 10px;"><?php echo $sInfo->countries_name ? $sInfo->countries_name : '/';?></td></tr>
        					<tr >
        						<td style="vertical-align: initial;text-align: right;"><b>邮编区间段/运输天数 : </b> </td>
        						<td style="padding-left: 10px;">
        							<?php
            				            if(isset($shipping_postcode_day) && $shipping_postcode_day->RecordCount() > 0){
                				            while (!$shipping_postcode_day->EOF){
                				                echo '<p>' . $shipping_postcode_day->fields['shipping_post_code_start'] . '~' . $shipping_postcode_day->fields['shipping_post_code_end'] . ' / '
                                                    . $shipping_postcode_day->fields['shipping_transport_min'] . '~' . $shipping_postcode_day->fields['shipping_transport_max'] .  ' days</p>';
                				        
                				                $shipping_postcode_day->MoveNext();
                				            }
            				            }
                				    ?>
        						</td>
        					</tr>
        				</table>
        				<p class="listshow" style="text-align: center;margin-top:20px;">
        					<a href='<?php  echo zen_href_link('shipping_virtual_methods','action=edit&sID=' . $sInfo->shipping_id . '&page='.(isset($_GET['page'])?$_GET['page']:'1'))?>'><button class='simple_button'>更新</button></a>
        				</p>
                    </div>
                 </td>
         
         <?php }?>
      </tr>
  </tbody>
</table>

<?php unset($_SESSION['virtual_shipping_error']);?>
</body>
</html>