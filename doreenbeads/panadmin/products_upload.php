<?php
require('includes/application_top.php');
require(DIR_WS_CLASSES . 'language.php');
require('includes/functions/function_discount.php');
function zen_get_products_to_categories_path($cid, $array = array())
{
    global $db;
    global $all_cate_array;
    $array [] = $cid;
    if ($all_cate_array [$cid] ['parent']) {
        return zen_get_products_to_categories_path($all_cate_array [$cid] ['parent'], $array);
    } else {
        $array = array_reverse($array);
        $length = 5;
        for ($i = sizeof($array); $i <= $length; $i++) {
            $array [$i] = 0;
        }
        return implode(',', $array);
    }
}

function zen_get_all_cate_array()
{
    global $db;
    $get_all_cate_array = array();
    $get_all_cate_query = "select c.categories_id,c.parent_id from " . TABLE_CATEGORIES . " c   where  categories_status=1 order by  categories_id ";
    $get_all_cate = $db->Execute($get_all_cate_query);
    if ($get_all_cate->RecordCount() > 0) {
        while (!$get_all_cate->EOF) {
            $get_all_cate_array [$get_all_cate->fields ['categories_id']] = array(
                'id' => $get_all_cate->fields ['categories_id'],
                'parent' => $get_all_cate->fields ['parent_id']
            );
            $get_all_cate->MoveNext();
        }
    }
    return $get_all_cate_array;
}

function img_curl_post($header, $data, $url)
{
    $ch = curl_init();
    $res = curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    curl_close($ch);
    if ($result == NULL) {
        return 0;
    }
    return $result;
}

function product_update_log($log)
{
    $logs_from = '../products/logs/';
    $logs_name = 'update_status_log_' . date("ym");
    $logs_file = $logs_from . $logs_name;
    $startime = microtime(true);
    file_put_contents($logs_file, "\n\n" . '--- 执行时间:' . date('Y-m-d H:i:s', $startime) . ' ---' . "\n", FILE_APPEND);
    file_put_contents($logs_file, "\n---更新的商品编号:" . $log . "\n", FILE_APPEND);
}

function product_info_update_log($log,$admin_id)
{
    $logs_from = '../products/logs/';
    $logs_name = 'update_tips_log_' . date("ym");
    $logs_file = $logs_from . $logs_name;
    $startime = microtime(true);
    file_put_contents($logs_file, "\n\n" . '--- 执行时间:' . date('Y-m-d H:i:s', $startime) . ' ---' . "\n", FILE_APPEND);
    file_put_contents($logs_file, "\n---更新的商品编号:" . $log . "\n 操作ID：". $admin_id . "\n", FILE_APPEND);
}

$async = isset ($_GET ['async']) && in_array($_GET['async'], array('auto', 'manual')) ? $_GET ['async'] : '';

$action = (isset ($_GET ['action']) ? $_GET ['action'] : '');
if (zen_not_null($action)) {
    switch ($action) {
        case 'img_finish_update_status':
            $url = HTTP_IMG_SERVER . '/upload_exists_img_result_' . $async . '.txt';
            $ret = file_get_contents($url);
            if ($ret) {
                $update_products_model_str_final = "('" . str_replace(",", "','", $ret) . "')";

                $select_sql = "SELECT    products_id  FROM " . TABLE_PRODUCTS . "  WHERE products_status = 0 AND products_model IN " . $update_products_model_str_final;
                $select_query = $db->Execute($select_sql);
                $select_array = array();
                while (!$select_query->EOF) {
                    $select_array[] = $select_query->fields['products_id'];
                    $select_query->MoveNext();
                }
                if ($select_array) {

                    $update_products_model_sql = 'UPDATE ' . TABLE_PRODUCTS . ' SET products_status = 1 WHERE products_status = 0 AND products_model IN ' . $update_products_model_str_final;
                    $update_products_model_delete_query = $db->Execute($update_products_model_sql);

                    foreach ($select_array as $product) {
                        remove_product_memcache($product);
                    }
                }

                file_get_contents(HTTP_IMG_SERVER . '/upload_img.php?action=clear_product_models&async=' . $async);
                product_update_log($ret);
            }

            exit();
            break;
        case 'update_no_img_product':
            $update_startime = microtime(true);
            $file = $_FILES['file_img'];

            if ($file['error'] || empty($file)) {
                $messageStack->add_session('Fail: 文件不能为空' . $file['name'], 'error');
                zen_redirect(zen_href_link(FILENAME_CATEGORIES, $_POST['cPath'] != '' ? 'cPath=' . $_POST['cPath'] : ''));
            }

            $filename = basename($file['name']);
            if (substr($filename, '-4') != 'xlsx' && substr($filename, '-3') != 'xls') {
                $messageStack->add_session('Fail: 文件格式有误，请上传xlsx或者xls格式的文件', 'error');
                zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $_POST['cPath']));
            } else {

                $url = HTTP_IMG_SERVER . '/upload_exists_img_result_manual' . '.txt';
                $ret = file_get_contents($url);
                if ($ret == 'start') {
                    $messageStack->add_session('刷图程序还在处理中，请勿重复提交！', 'caution');
                    zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD, 'async=manual'));
                    exit();
                }

                set_time_limit(0);

                $error = false;
                $error_info_array = array();
                $file_from = $file['tmp_name'];
                $success_num = 0;
                $products_model_array = array();

                set_include_path('../Classes/');
                include 'PHPExcel.php';
                if (substr($filename, '-4') == 'xlsx') {
                    include 'PHPExcel/Reader/Excel2007.php';
                    $objReader = new PHPExcel_Reader_Excel2007;
                } else {
                    include 'PHPExcel/Reader/Excel5.php';
                    $objReader = new PHPExcel_Reader_Excel5;
                }
                $objPHPExcel = $objReader->load($file_from);
                $sheet = $objPHPExcel->getActiveSheet();

                for ($j = 2; $j <= $sheet->getHighestRow(); $j++) {
                    $error = false;
                    $products_model = trim($sheet->getCellByColumnAndRow(0, $j)->getValue());

                    if ($products_model == '') {
                        $error = true;
                        $error_info_array[] = "第" . $j . "行产品编号为空";
                        continue;
                    }

                    $check_products_model_query = $db->Execute("SELECT * FROM " . TABLE_PRODUCTS . " WHERE products_model = '" . $products_model . "' ORDER BY products_id DESC LIMIT 1");
                    //print_r($check_products_model_query->fields);
                    if ($check_products_model_query->RecordCount() <= 0) {
                        $error = true;
                        $error_info_array[] = "第" . $j . "行数据有误，商品编号【" . $products_model . "】不存在";
                        continue;
                    }

                    if (!$error) {
                        $products_model_array[] = $products_model;
                    }
                }

                if (sizeof($error_info_array)) {
                    $logs_from = '../products/logs/';
                    $logs_name = 'error_log';
                    $logs_file = $logs_from . $logs_name;
                    if (file_get_contents($logs_file) == '') {
                        file_put_contents($logs_file, "自动上货缺失图片更新日志\n", FILE_APPEND);
                    }
                    file_put_contents($logs_file, "\n\n" . '--- 开始时间:' . date('Y-m-d H:i:s', $update_startime) . ' ---' . "\n", FILE_APPEND);
                    file_put_contents($logs_file, '文件名: ' . $xlsxfrom . "\n", FILE_APPEND);
                    file_put_contents($logs_file, '产品描述日期: ' . $txtfrom . "\n", FILE_APPEND);
                    foreach ($error_info_array as $number) {
                        file_put_contents($logs_file, $number, FILE_APPEND);
                        $messageStack->add_session($number, 'error');
                    }
                    $messageStack->add_session('<a href="' . $logs_file . '">查看所有错误志</a>', 'success');
                    $update_endtime = microtime(true);
                    file_put_contents($logs_file, '用时: ' . round(($update_endtime - $update_startime), 2) . ' (s)' . "\n", FILE_APPEND);
                    file_put_contents($logs_file, '------ END ------' . "\n", FILE_APPEND);
                } else {
                    $messageStack->add_session('全部数据更新完成,不要关闭页面知道刷图程序完成', 'success');
                }


                if (sizeof($products_model_array) > 0) {

                    $products_model_str = implode(',', $products_model_array);

                    $url = HTTP_IMG_SERVER . '/upload_img.php?action=update_image_from_data';

                    $header = array();

                    $data = 'async=manual&models=' . $products_model_str;
                    file_get_contents(HTTP_IMG_SERVER . '/upload_img.php?action=clear_product_upload_result&async=manual');
                    $ret = img_curl_post($header, $data, $url);

                    zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD, 'async=manual'));
                } else {
                    zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD));
                }

            }
            break;
        case 'upload_data' :
            $is_display = $_POST['is_display'];
            if (!in_array($is_display, array('1', '0'))) {
                $is_display = 1;
            }
            $url = HTTP_IMG_SERVER . '/upload_exists_img_result_auto' . '.txt';
            $ret = file_get_contents($url);
            if ($ret == 'start') {
                $messageStack->add_session('刷图程序还在处理中，请勿重复提交！', 'caution');
                zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD, 'async=auto'));
                exit();
            }

            set_time_limit(0);
            @ini_set('memory_limit', '256M');
            set_include_path('../Classes/');
            $startime = microtime(true);
            include 'PHPExcel.php';
            include 'PHPExcel/Reader/Excel2007.php';
            $objReader = new PHPExcel_Reader_Excel2007 ();

            //	产品表格
            $xlsxdir = '../products/';
            $xlsxfrom = date('Ymd') . '.xlsx';//trim ( $_POST ['whereisxlsx'] );
//			if (! strstr ( $xlsxfrom, '.xlsx' )) {
//				$xlsxfrom = $xlsxfrom . '.xlsx';
//			}
            $xlsxfile = $xlsxdir . $xlsxfrom;
            if (file_exists($xlsxfile)) unlink($xlsxfile);
            move_uploaded_file($_FILES['whereisxlsx']['tmp_name'], $xlsxfile);

            //	产品描述
            $txtxdir = '../products/description/';
            $zip = new ZipArchive;
            if ($zip->open($_FILES['whereistxt']['tmp_name']) === true) {
                $zip->extractTo($txtxdir);
            }
            $txtfrom = date('Ymd');//trim ( $_POST ['whereistxt'] );
            if (!is_dir($txtxdir . $txtfrom . '-EN')) {
                $messageStack->add_session($txtxdir . $txtfrom . '-EN' . '产品描述目录不存在', 'error');
                zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD));
            }

            //	shanghuo.csv
            $shanghuoCSV = '../shanghuo.csv';
            if (file_exists($shanghuoCSV)) unlink($shanghuoCSV);
            $shanghuo = fopen($shanghuoCSV, 'w');

            if (file_exists($xlsxfile)) {
                $objPHPExcel = $objReader->load($xlsxfile);
                $sheet = $objPHPExcel->getActiveSheet();
                $all_products_array = array();
                $error_array = array();
                $category_array = array();
                $category_path_array = array();
                $all_cate_array = array();
                $all_cate_array = zen_get_all_cate_array();
                $products_model_array = array();

                $insert_db_product_array = array();
                // print_r($all_cate_array);
                $remote_url = 'http://192.168.3.220/8seasonsorg/';
                $remote_url_pic = $remote_url . 'images/download/';


                //这里$j 本应该判断 < $sheet->getHighestRow () 不用= 防止上传者删掉最后一行 还是按原来的写法保留=号 但是后面增加做了判断
                $en_name = trim($sheet->getCellByColumnAndRow(8, $sheet->getHighestRow())->getValue());
                if (mb_strpos($en_name, "共") !== false) {
                    $total_num = $sheet->getHighestRow() - 1;
                } else {
                    $total_num = $sheet->getHighestRow();
                }


                for ($j = 4; $j <= $total_num; $j++) {
                    $products_name = array();
                    $category_code = trim($sheet->getCellByColumnAndRow(0, $j)->getValue());
                    if ($category_code == '') {
                        $error_array [] = '第' . $j . '行 ，产品线号为空' . "\n";
                        continue;
                    }
                    $all_products_array[$j]['row_number'] = $j;
                    $all_products_array[$j]['category_code'] = str_replace("'", "", $category_code);
                    $all_products_array[$j]['products_model'] = trim($sheet->getCellByColumnAndRow(1, $j)->getValue());
                    $all_products_array[$j]['products_price'] = trim($sheet->getCellByColumnAndRow(2, $j)->getValue());
                    $all_products_array[$j]['products_without_desciption'] = addslashes(trim($sheet->getCellByColumnAndRow(3, $j)->getValue()));
                    $all_products_array[$j]['price_level'] = trim($sheet->getCellByColumnAndRow(4, $j)->getValue());
                    $all_products_array[$j]['products_weight'] = trim($sheet->getCellByColumnAndRow(5, $j)->getValue());
                    $all_products_array[$j]['products_weight_volume'] = zen_db_prepare_input(trim($sheet->getCellByColumnAndRow(6, $j)->getValue()));
                    $all_products_array[$j]['products_property'] = trim($sheet->getCellByColumnAndRow(7, $j)->getValue());
                    $products_name[1] = trim($sheet->getCellByColumnAndRow(8, $j)->getValue());
                    $products_name[2] = trim($sheet->getCellByColumnAndRow(10, $j)->getValue());
                    $products_name[3] = trim($sheet->getCellByColumnAndRow(12, $j)->getValue());
                    $products_name[4] = trim($sheet->getCellByColumnAndRow(14, $j)->getValue());
                    $products_name[5] = trim($sheet->getCellByColumnAndRow(16, $j)->getValue());
                    $products_name[6] = trim($sheet->getCellByColumnAndRow(20, $j)->getValue());
                    $products_name[7] = trim($sheet->getCellByColumnAndRow(18, $j)->getValue());
                    $all_products_array[$j]['products_name'] = addslashes(serialize($products_name));
                    $all_products_array[$j]['limit_stock'] = trim($sheet->getCellByColumnAndRow(22, $j)->getValue());
                    $all_products_array[$j]['products_quantity'] = trim($sheet->getCellByColumnAndRow(23, $j)->getValue());
                    $all_products_array[$j]['per_pack_qty'] = trim($sheet->getCellByColumnAndRow(24, $j)->getValue());
                    $all_products_array[$j]['unit_code'] = str_replace("'", "", trim($sheet->getCellByColumnAndRow(25, $j)->getValue()));
                    $all_products_array[$j]['products_stocking_days'] = (int)trim(str_replace("'", "", $sheet->getCellByColumnAndRow(26, $j)->getValue()));
                    $all_products_array[$j]['is_mixed'] = (int)trim(str_replace("'", "", $sheet->getCellByColumnAndRow(27, $j)->getValue()));
                    $all_products_array[$j]['is_preorder'] = (int)trim(str_replace("'", "", $sheet->getCellByColumnAndRow(28, $j)->getValue()));

                    //非饰品  需求编号：1568 chengmin
                    $is_non_accessories[$all_products_array[$j]['products_model']] = (int)trim($sheet->getCellByColumnAndRow(29, $j)->getValue());
                }
// 				print_r($all_products_array);exit;

                $sql_suffix = '';
                $insert_time = date('Y-m-d H:i:s');
                if (!empty($all_products_array)) {
                    $sql_prefix = "INSERT INTO " . TABLE_PRODUCTS_AUTO_UPLOAD . " (row_number, category_code, products_model, products_price, products_without_desciption, price_level, products_weight, products_weight_volume, products_property, products_name, limit_stock, products_quantity, create_time, per_pack_qty, unit_code, is_mixed,is_preorder, products_stocking_days) VALUES ";
                    foreach ($all_products_array as $key => $products_array) {
                        $sql_suffix .= "( '" . $products_array['row_number'] . "', '" . $products_array['category_code'] . "', '" . $products_array['products_model'] . "', '" . $products_array['products_price'] . "', '" . $products_array['products_without_desciption'] . "', '" . $products_array['price_level'] . "', '" . $products_array['products_weight'] . "', '" . $products_array['products_weight_volume'] . "', '" . $products_array['products_property'] . "', '" . $products_array['products_name'] . "', '" . $products_array['limit_stock'] . "', '" . $products_array['products_quantity'] . "', '" . $insert_time . "', '" . $products_array['per_pack_qty'] . "', '" . $products_array['unit_code'] . "', " . $products_array['is_mixed'] . ", " . $products_array['is_preorder'] . ", " . $products_array['products_stocking_days'] . " ),";
                    }
                    $sql_suffix = rtrim($sql_suffix, ',');
                    $insert_sql = $sql_prefix . $sql_suffix;
                    $insert_id = $db->Execute($insert_sql);
                    //echo $insert_sql;
                }

                // 取出表中的数据
                $select_sql = "SELECT row_number, category_code, products_model, products_price, products_without_desciption, price_level, products_weight, products_weight_volume, products_property, products_name, limit_stock, products_quantity, create_time, per_pack_qty, unit_code, products_stocking_days, is_mixed,is_preorder FROM " . TABLE_PRODUCTS_AUTO_UPLOAD . " where create_time = '" . $insert_time . "' GROUP BY products_model ORDER BY auto_id DESC";
                $select_query = $db->Execute($select_sql);

                $select_array = array();
                while (!$select_query->EOF) {
                    $select_array[] = array('row_number' => $select_query->fields['row_number'],
                        'category_code' => $select_query->fields['category_code'],
                        'products_model' => $select_query->fields['products_model'],
                        'products_price' => $select_query->fields['products_price'],
                        'products_without_desciption' => $select_query->fields['products_without_desciption'],
                        'price_level' => $select_query->fields['price_level'],
                        'products_weight' => $select_query->fields['products_weight'],
                        'products_weight_volume' => $select_query->fields['products_weight_volume'],
                        'products_property' => $select_query->fields['products_property'],
                        'products_name' => $select_query->fields['products_name'],
                        'limit_stock' => $select_query->fields['limit_stock'],
                        'products_quantity' => $select_query->fields['products_quantity'],
                        'per_pack_qty' => $select_query->fields['per_pack_qty'],
                        'unit_code' => $select_query->fields['unit_code'],
                        'products_stocking_days' => $select_query->fields['products_stocking_days'],
                        'is_mixed' => $select_query->fields['is_mixed'],
                        'is_preorder' => $select_query->fields['is_preorder']
                    );
                    $select_query->MoveNext();
                }
                //print_r($select_array);die;

                foreach ($select_array as $key => $products_info) {
                    $is_club = 1;
                    $ru_club = 1;
                    $is_not_shipping_discount = 0;
                    $products_name = array();

                    $row_number = $products_info['row_number'];
                    $category_code = $products_info['category_code'];
                    $products_model = $products_info['products_model'];
                    $products_price = $products_info['products_price'];
                    $products_without_desciption = stripslashes($products_info['products_without_desciption']);
                    $price_level = $products_info['price_level'];
                    $products_weight = $products_info['products_weight'];
                    $products_weight_volume = $products_info['products_weight_volume'];
                    $products_property = $products_info['products_property'];
                    $products_name_str = $products_info['products_name'];
                    $limit_stock = $products_info['limit_stock'];
                    $products_quantity = $products_info['products_quantity'];
                    $per_pack_qty = $products_info['per_pack_qty'];
                    $unit_code = $products_info['unit_code'];
                    $products_stocking_days = $products_info['products_stocking_days'];
                    $is_mixed = $products_info['is_mixed'];
                    $is_preorder = $products_info['is_preorder'];

                    $products_model_array[] = $products_model;

                    $update_data = true;
                    if ($category_code == '') {
                        $update_data = false;
                        $error_array [] = '第' . $j . '行 ，产品线号为空' . "\n";
                    } else {
                        if (!isset ($category_array [$category_code])) {
                            $getCidQuery = $db->Execute('select categories_id,categories_status from ' . TABLE_CATEGORIES . ' where categories_code="' . $category_code . '" limit 1');
                            if ($getCidQuery->RecordCount() > 0) {
                                if ($getCidQuery->fields ['categories_status'] == 1) {
                                    $category_array [$category_code] = $getCidQuery->fields ['categories_id'];
                                    $category_path_array [$category_code] = zen_get_products_to_categories_path($getCidQuery->fields ['categories_id']);
                                } else {
                                    $category_array [$category_code] = -1;
                                    $category_path_array [$category_code] = '';
                                }
                            } else {
                                $category_array [$category_code] = 0;
                                $category_path_array [$category_code] = '';
                            }
                        }

                        $cid = $category_array [$category_code];
                        $category_path = $category_path_array [$category_code];
                        if ($cid == 0) {
                            $update_data = false;
                            $error_array [] = '第' . $row_number . '行 ，产品线号不存在' . "\n";
                        } elseif ($cid == -1) {
                            $update_data = false;
                            $error_array [] = '第' . $row_number . '行 ，产品线号状态有问题' . "\n";
                        }
                    }

                    if (substr($products_model, 0, 1) == 'B') {
                        if (substr($products_model, -1) == 'S' || substr($products_model, -1) == 'Q') {
                            $image_name = substr($products_model, 0, -1);
                            $products_image = ((int)substr($image_name, 1, 2) + 1) . '/' . $image_name . '.JPG';
                        } else {
                            $products_image = ((int)substr($products_model, 1, 2) + 1) . '/' . $products_model . '.JPG';
                        }
                    } else {
                        if (substr($products_model, -1) == 'S' || substr($products_model, -1) == 'Q') {
                            $image_name = substr($products_model, 0, -1);
                            $products_image = substr($image_name, 0, 3) . '/' . $image_name . '.JPG';
                        } else {
                            $products_image = substr($products_model, 0, 3) . '/' . $products_model . '.JPG';
                        }
                    }

                    if ($update_data) {
                        if (substr($products_model, -1) == 'H') {
                            $update_data = false;
                            $error_array [] = '第' . $row_number . '行 ，' . $products_model . '上传失败，不能上传大包装' . "\n";
                        } else {
                            $products_sql = 'select products_id from  ' . TABLE_PRODUCTS . ' where products_model = "' . $products_model . '"  limit 1';
                            $products = $db->Execute($products_sql);
                            if ($products->RecordCount() > 0) {
                                $update_data = false;
                                $error_array [] = '第' . $row_number . '行 ，产品编号已存在' . "\n";
                            }
                        }
                    }

                    // 如果上货小包装，检查正常包装是否上货
//					if ($update_data && substr($products_model, -1) == 'S' ) {
//						$normal_model = substr($products_model, 0, -1);
//						$products_normal = $db->Execute ( 'select products_id from  ' . TABLE_PRODUCTS . ' where products_model = "' . $normal_model . '"  limit 1' );
//						if ($products_normal->RecordCount () > 0) {
//							//echo $products_model.' exist <br/>';
//						}else{
//							$update_data = false;
//							$error_array [] = '第' . $row_number . '行 ，'.$products_model.'上传失败，请先上传正常包装的商品' . "\n";
//						}
//					}

                    if ($update_data) {
                        if (!$products_price || $products_price < 0.1) {
                            $update_data = false;
                            $error_array [] = '第' . $row_number . '行 ，上货价格有问题' . "\n";
                        } else {
                            //$products_price = $products_price * 1.04;
                        }
                    }

                    if ($update_data) {
                        if (!$price_level) {
                            $update_data = false;
                            $error_array [] = '第' . $row_number . '行 ，价格梯段有问题' . "\n";
                        }
                    }

                    if ($update_data) {
                        if (!$products_weight) {
                            $update_data = false;
                            $error_array [] = '第' . $row_number . '行 ，产品重量有问题' . "\n";
                        }
                    }

                    if ($update_data) {
                        if ($products_property == '') {
                            $update_data = false;
                            $error_array [] = '第' . $row_number . '行 ，产品属性值为空' . "\n";
                        } else {
                            $products_property_array = explode(';', $products_property);
                            foreach ($products_property_array as $key => $val) {
                                $products_property_array [$key] = "'" . $val . "'";
                            }
                            $products_property_str = implode(',', $products_property_array);
                            $get_all_pro = $db->Execute("select property_id,property_group_id from t_property where property_code in (" . $products_property_str . ") ");
                            if ($get_all_pro->RecordCount() > 0) {
                            } else {
                                $update_data = false;
                                $error_array [] = '第' . $row_number . '行 ，产品属性值均不存在' . "\n";
                            }
                        }
                    }

                    $products_name = unserialize(stripcslashes($products_name_str));
                    if ($update_data) {
                        if (stripslashes($products_name[1]) == '') {
                            $update_data = false;
                            $error_array [] = '第' . $row_number . '行 ，英语产品名字为空' . "\n";
                        }
                    }

                    if ($update_data) {
                        if (!file_exists($txtxdir . $txtfrom . '-EN/' . $products_model . '.txt')) {
                            $update_data = false;
                            $error_array [] = '第' . $row_number . '行 ，英语产品描述不存在' . "\n";
                        } else {
                            $products_description_txt_en = file_get_contents($txtxdir . $txtfrom . '-EN/' . $products_model . '.txt');
                        }
                    }

                    if ($update_data) {
                        if ($products_quantity <= 20 || $limit_stock == 1) {
                            if (substr($products_model, -1) != 'S') {
                                $products_quantity = floor($products_quantity * 0.3);
                            } else {
                                $products_quantity = floor($products_quantity * 0.6);
                            }
                        } else {
                            $limit_stock = 0;
                            $products_quantity = '50000';
                        }

                        if (!(substr($products_model, -1) == 'H' || substr($products_model, -1) == 'Q') ) {
                            $price_manager_id = 42;
                            $price_manager_value = $db->Execute("SELECT price_manager_value FROM " . TABLE_PRICE_MANAGER . " where price_manager_id = " . $price_manager_id . " order by price_manager_id desc ");
                            $price_after_manager = $products_price * ($price_manager_value->fields['price_manager_value'] / 100 + 1);
                        } else {
                            $price_manager_id = 0;
                            $price_after_manager = $products_price;
                        }

                        fputcsv($shanghuo, array($products_model));
                        $insert_db_product_array[] = $products_model;

                        $sql_data_array = array(
                            //'products_quantity' => $products_quantity,
                            'products_model' => $products_model,
                            'products_net_price' => $products_price,
                            'products_weight' => $products_weight,
                            'products_volume_weight' => $products_weight_volume,
                            'products_status' => 0, //将原先的默认上货状态改成下架状态  因图片缺失问题  chengmin modify 2019.11.14
                            'products_quantity_order_min' => 1,
                            'products_limit_stock' => $limit_stock,
                            'products_quantity_mixed' => 1,
                            'products_discount_type' => 1,
                            'products_discount_type_from' => 1,
                            'products_sort_order' => 1000,
                            'product_price_times' => $price_level,
                            'products_price_sorter' => $products_price,
                            'products_date_added' => date('Y-m-d H:i:s'),
                            'master_categories_id' => $cid,
                            'products_image' => $products_image,
                            'price_manager_id' => $price_manager_id,
                            'products_stocking_days' => $products_stocking_days,
                            'is_mixed' => $is_mixed,
                            'is_preorder' => $is_preorder,
                            'is_display' => $is_display
                        );

                        zen_db_perform(TABLE_PRODUCTS, $sql_data_array);
                        $products_id = $db->insert_ID();
                        $sql_data_array_products_stock = array(
                            'products_id' => $products_id,
                            'products_quantity' => $products_quantity,
                            'create_time' => strtotime(date('Y-m-d H:i:s')),
                            'modify_time' => strtotime(date('now'))
                        );
                        zen_db_perform(TABLE_PRODUCTS_STOCK, $sql_data_array_products_stock);


                        $ptc_insert_sql = "insert into " . TABLE_PRODUCTS_TO_CATEGORIES . "
							(products_id, categories_id,
							first_categories_id,second_categories_id,

								three_categories_id,four_categories_id,
							five_categories_id,six_categories_id)
							values ('" . $products_id . "', '" . $cid . "'," . $category_path . ")";
                        //echo $ptc_insert_sql . '<br>';
                        $db->Execute($ptc_insert_sql);

                        //判断分类对应关系表是否存在当前CID的对应关系
                        $result_rlt = $db->Execute('select recommend_categories_id from ' . TABLE_CATEGORIES_RELATION . ' where common_categories_id = ' . $cid . ' and status = 1 limit 1');

                        if ($result_rlt->RecordCount()) {
                            $relation_ids = explode(',', $result_rlt->fields['recommend_categories_id']);
                            foreach ($relation_ids as $ids) {
                                if ($ids == '' || $ids <= 0) {
                                    continue;
                                }
                                $check_products_to_category_query = $db->Execute('select products_id from ' . TABLE_PRODUCTS_TO_CATEGORIES . ' where products_id =' . $products_id . ' and categories_id =' . $ids);

                                if ($check_products_to_category_query->RecordCount() == 0) {
                                    move_products_to_new_categories($products_id, $ids);
                                }
                            }
                        }
                        zen_refresh_products_price($products_id, $price_after_manager, $products_weight, 0, $price_level, false, '', array('insert' => true, 'record_log' => true, 'batch_update' => false, 'currrency_last_modified' => null));
                        while (!$get_all_pro->EOF) {
                            $property_insert_sql = 'insert into  t_products_to_property (product_id,property_id,property_group_id) values (' . $products_id . ',' . $get_all_pro->fields['property_id'] . ',' . $get_all_pro->fields['property_group_id'] . ') ';

                            $db->Execute($property_insert_sql);
                            $get_all_pro->MoveNext();
                        }

                        //如果是非饰品 则入非饰品表 需求编号：1568  chengmin
                        if ($is_non_accessories[$products_model] == 1) {
                            $check_non_products = $db->Execute('select nas_id from ' . TABLE_PRODUCTS_NON_ACCESSORIES . ' where products_id = ' . $products_id);
                            if ($check_non_products->RecordCount() == 0) {
                                $sql_data_array = array(
                                    'products_id' => $products_id,
                                    'products_model' => $products_model,
                                    'add_admin' => $_SESSION['admin_email'],
                                    'add_datetime' => 'now()'
                                );

                                zen_db_perform(TABLE_PRODUCTS_NON_ACCESSORIES, $sql_data_array);
                            }
                        }
                        //


                        $unit_id = $db->Execute("select unit_id from " . TABLE_PRODUCTS_UNIT . " where unit_code='" . $unit_code . "'");
                        $unit_data_array = array(
                            'products_id' => $products_id,
                            'products_unit_id' => (int)$unit_id->fields['unit_id'],
                            'unit_number' => (int)$per_pack_qty
                        );
                        zen_db_perform('t_products_to_unit', $unit_data_array);

                        for ($lang = 1; $lang <= 5; $lang++) {
                            switch ($lang) {
                                case 1:
                                    $lang_code = 'EN';
                                    break;
                                case 2:
                                    $lang_code = 'DE';
                                    break;
                                case 3:
                                    $lang_code = 'RU';
                                    break;
                                case 4:
                                    $lang_code = 'FR';
                                    break;
                                //case 5:
                                //$lang_code='ES';
                                //break;
                            }
                            $products_name_str = $products_name[$lang];
                            if ($products_name_str == '') {
                                $products_name_str = $products_name[1];
                            }
                            $findtxt = $txtxdir . $txtfrom . '-' . $lang_code . '/' . $products_model . '.txt';
                            //echo $findtxt.'<br>';
                            $products_description_txt = file_get_contents($findtxt);
                            //var_dump(file_exists($findtxt));
                            //if($lang==1){
                            //$products_description_txt_en=$products_description_txt;
                            //}

                            $sql_data_array_description = array('products_id' => $products_id,
                                'products_name' => zen_db_prepare_input($products_name_str),

                                'language_id' => $lang,
                                'products_name_without_catg' => zen_db_prepare_input($products_without_desciption));
                            zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array_description);
                            /*WSL*/
                            if ($lang == 1 && $products_without_desciption != '') {
                                $result = $db->Execute('select tag_id from ' . TABLE_PRODUCTS_NAME_WITHOUT_CATG . ' where products_name_without_catg = "' . zen_db_prepare_input($products_without_desciption) . '"');
                                $tag_id = 0;
                                if ($result->RecordCount() > 0) {
                                    $tag_id = $result->fields['tag_id'];
                                } else {
                                    $sql_data_array_catg = array(
                                        'products_name_without_catg' => zen_db_prepare_input($products_without_desciption),
                                        'created' => date('Y-m-d H:i:s'),
                                        'modified' => date('Y-m-d H:i:s')
                                    );
                                    zen_db_perform(TABLE_PRODUCTS_NAME_WITHOUT_CATG, $sql_data_array_catg);
                                    $tag_id = $db->insert_ID();
                                }
                                $sql_data_relation = array(
                                    'tag_id' => $tag_id,
                                    'products_id' => $products_id,
                                    'created' => date('Y-m-d H:i:s')
                                );
                                zen_db_perform(TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION, $sql_data_relation);
                            }
                            /*end*/
                            if (trim($products_description_txt) != '') {

                                $sql_data_array_info = array(
                                    'products_id' => $products_id,
                                    'products_description' => zen_db_prepare_input($products_description_txt),
                                    'language_id' => $lang
                                );
                                zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_info);
                            }
                        }
                        // 需要关联小包装和正常包装，刷关联数据
                        if (substr($products_model, -1) == 'S' || substr($products_model, -1) == 'Q') {
                            $model_main = substr($products_model, 0, -1);
                            $model_other = $products_model;
                            $type = substr($products_model, -1) == 'Q' ? 3 : 1;//1:small size, 3:big size

                            $main_product_query = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model='" . $model_main . "'");
                            $other_product_query = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model='" . $model_other . "'");

                            if ($main_product_query->fields['products_id'] > 0 && $other_product_query->fields['products_id'] > 0) {
//				 			  $check_exist = $db->Execute("select relation_id from ".TABLE_PRODUCTS_PACKAGE_RELATION." where main_product_id=".$main_product_query->fields['products_id']." and package_type=".$type);
//				 			  if($check_exist->RecordCount()==0){

                                $sql_data = array(
                                    'main_product_id' => $main_product_query->fields['products_id'],
                                    'other_size_product_id' => $other_product_query->fields['products_id'],
                                    'package_type' => $type,
                                    'date_added' => date('Y-m-d H:i:s')
                                );
                                zen_db_perform(TABLE_PRODUCTS_PACKAGE_RELATION, $sql_data);

                                $sql_data_2 = array(
                                    'main_product_id' => $other_product_query->fields['products_id'],
                                    'other_size_product_id' => $main_product_query->fields['products_id'],
                                    'package_type' => 2, //main size
                                    'date_added' => date('Y-m-d H:i:s')
                                );
                                zen_db_perform(TABLE_PRODUCTS_PACKAGE_RELATION, $sql_data_2);
                                // 清除大小包装缓存
                                remove_product_memcache($products_id);
//				 			  }else{
//									echo $model_main.'已存在数据<br/>';
//							  }
                            } else {
                                echo $model_main . '产品没找到<br/>';
                            }
                            /*
                            //更新上货价表
                            $chengben_data_array = array();
                            $chengben_query = $db->Execute('select chengben_id from ' . TABLE_PRODUCTS_CHENGBEN .' where chengben_id = ' . $products_id .' limit 1');
                            if($chengben_query->RecordCount() > 0){
                                $chengben_data_array = array(
                                        'price' => $products_price,
                                        'date_modified' => date('Y-m-d H:i:s')
                                );
                                $condition_where_clause = 'chengben_id = :chengben_id';
                                $delivery_where_clause = $db->bindVars($condition_where_clause, ':chengben_id', $products_id, 'integer');
                                zen_db_perform(TABLE_PRODUCTS_SHANGHUOJIA,$chengben_data_array,'update',$delivery_where_clause);
                            }else{
                                $chengben_data_array = array(
                                        'chengben_id' => $products_id,
                                        'price' => $products_price,
                                        'date_created' => date('Y-m-d H:i:s'),
                                        'date_modified' => date('Y-m-d H:i:s')
                                );
                                zen_db_perform(TABLE_PRODUCTS_SHANGHUOJIA,$chengben_data_array);
                            }
                            */
                        }
                        //usleep(50000);
                    }
                }

                $products_model_str = join(",", $products_model_array);
                $products_model_str_final = "('" . str_replace(",", "','", $products_model_str) . "')";
                //echo $products_model_str_final;
                $products_model_delete_sql = 'UPDATE ' . TABLE_PRODUCTS_AUTO_UPLOAD . ' SET status = 20 WHERE products_model IN ' . $products_model_str_final;
                $products_model_delete_query = $db->Execute($products_model_delete_sql);
                $input_upload_result = '';

                if (sizeof($error_array)) {
                    $logs_from = '../products/logs/';
                    $logs_name = 'error_log';
                    $logs_file = $logs_from . $logs_name;
                    if (file_get_contents($logs_file) == '') {
                        file_put_contents($logs_file, "自动上货日志\n", FILE_APPEND);
                    }
                    file_put_contents($logs_file, "\n\n" . '--- 开始时间:' . date('Y-m-d H:i:s', $startime) . ' ---' . "\n", FILE_APPEND);
                    file_put_contents($logs_file, '文件名: ' . $xlsxfrom . "\n", FILE_APPEND);
                    file_put_contents($logs_file, '产品描述日期: ' . $txtfrom . "\n", FILE_APPEND);
                    foreach ($error_array as $number) {
                        file_put_contents($logs_file, $number, FILE_APPEND);
                        $messageStack->add_session($number, 'error');
                    }
                    $messageStack->add_session('<a href="' . $logs_file . '">查看所有错误志</a>', 'success');
                    $endtime = microtime(true);
                    file_put_contents($logs_file, '用时: ' . round(($endtime - $startime), 2) . ' (s)' . "\n", FILE_APPEND);
                    file_put_contents($logs_file, '------ END ------' . "\n", FILE_APPEND);
                } else {
                    $messageStack->add_session('全部数据更新完成,不要关闭页面直到刷图程序完成', 'success');
                }


                /*
                                //	上传 shanghuo.csv到ftp
                                include('includes/classes/ftp.class.php');
                                if($_SERVER['HTTP_HOST']=='www.doreenbeads.com'){
                                    $ftp = new Ftp(array(
                                        'hostname'	=> '206.225.80.155',
                                        'username'	=> 'dorabeads',
                                        //'password'	=> 'Lw-GjrV10sUWikr=jm',
                                        //'password'	=> 'ADg4yocU1fMD',
                                        'password'	=> '#der5@$)_12d201512~!',
                                        'port'		=> '21'
                                    ));
                                }else{
                                    $ftp = new Ftp(array(
                                        'hostname'	=> '10.2.1.167',
                                        'username'	=> 'dorabeads',
                                        'password'	=> 'pan195013',
                                        'port'		=> '21'
                                    ));
                                }
                                fclose($shanghuo);
                                $ftpErr = false;
                                if(! $ftp->connect()){
                                    $ftpErr = true;
                                    $messageStack->add_session ( 'ftp连接错误', 'error' );
                                }else{
                                    if(! $ftp->upload($shanghuoCSV, 'shanghuo.csv')){
                                        $ftpErr = true;
                                    }
                                }
                                if($ftpErr){
                                    $messageStack->add_session ( 'ftp发生错误，请手动下载<a target="_blank" href="'.$shanghuoCSV.'">shanghuo.csv</a>，并上传至img.doreenbeads.com的根目录！', 'error' );
                                }
                                $ftp->close();

                                $messageStack->add_session ( '（如果ftp错误，请先确认shanghuo.csv上传至img服务器后再---）点击<a target="_blank" href="' . HTTP_IMG_SERVER . '/upload_img.php?pid=1">这里</a>开始刷图片直至完成。！', 'success' );
                */

                //$messageStack->add_session ( '刷图片程序已在后台自动执行，请不要关闭当前页面！', 'success' );

                if (sizeof($insert_db_product_array) > 0) {

                    $products_model_str = implode(',', $insert_db_product_array);

                    $url = HTTP_IMG_SERVER . '/upload_img.php?action=update_image_from_data';

                    $header = array();

                    $data = 'async=auto&models=' . $products_model_str;
                    file_get_contents(HTTP_IMG_SERVER . '/upload_img.php?action=clear_product_upload_result&async=auto');
                    $ret = img_curl_post($header, $data, $url);
                }

                zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD, 'async=auto'));
            } else {
                $messageStack->add_session('产品数据文件不存在', 'error');
                zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD));
            }
            break;

        case 'update_data' :
            set_time_limit(0);
            @ini_set('memory_limit', '256M');
            set_include_path('../Classes/');
            $startime = microtime(true);
            include 'PHPExcel.php';
            include 'PHPExcel/Reader/Excel2007.php';
            $objReader = new PHPExcel_Reader_Excel2007 ();

            //	产品表格
            $xlsxdir = '../products/';
            $xlsxfrom = date('Ymd') . '.xlsx';
            $xlsxfile = $xlsxdir . $xlsxfrom;
            if (file_exists($xlsxfile)) unlink($xlsxfile);
            move_uploaded_file($_FILES['whereisxlsx2']['tmp_name'], $xlsxfile);

            //	产品描述
            $txtxdir = '../products/description/';
            $zip = new ZipArchive;
            if ($zip->open($_FILES['whereistxt2']['tmp_name']) === true) {
                $zip->extractTo($txtxdir);
            }
            $txtfrom = date('Ymd');
            if (file_exists($xlsxfile)) {
                $objPHPExcel = $objReader->load($xlsxfile);
                $sheet = $objPHPExcel->getActiveSheet();
                $error_array = array();

                for ($j = 4; $j <= $sheet->getHighestRow(); $j++) {
                    $model = zen_db_prepare_input($sheet->getCellByColumnAndRow(1, $j)->getValue());
                    $pid_query = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model='" . $model . "' limit 1");
                    if ($model == '' || $pid_query->RecordCount() == 0) {
                        $error_array [] = '第' . $j . '行 ，产品不存在' . "\n";
                        continue;
                    }
                    $weight = zen_db_prepare_input($sheet->getCellByColumnAndRow(5, $j)->getValue());
                    $volume = zen_db_prepare_input($sheet->getCellByColumnAndRow(6, $j)->getValue());
                    if ($volume == '') $volume = 0;
                    if ($weight > 0)
                        $db->Execute("update " . TABLE_PRODUCTS . " set products_weight=" . $weight . ",products_volume_weight=" . $volume . " where products_id=" . $pid_query->fields['products_id']);


                    $name_en = zen_db_prepare_input($sheet->getCellByColumnAndRow(8, $j)->getValue());
                    $name_de = zen_db_prepare_input($sheet->getCellByColumnAndRow(10, $j)->getValue());
                    $name_ru = zen_db_prepare_input($sheet->getCellByColumnAndRow(12, $j)->getValue());
                    $name_fr = zen_db_prepare_input($sheet->getCellByColumnAndRow(14, $j)->getValue());

                    if ($name_en != '') {
                        $sql_data = array(
                            'products_name' => $name_en
                        );
                        zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data, 'update', "products_id='" . $pid_query->fields['products_id'] . "' and language_id =1");

                    }
                    if ($name_de != '') {
                        $sql_data = array(
                            'products_name' => $name_de
                        );
                        zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data, 'update', "products_id='" . $pid_query->fields['products_id'] . "' and language_id =2");

                    }
                    if ($name_ru != '') {
                        $sql_data = array(
                            'products_name' => $name_ru
                        );
                        zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data, 'update', "products_id='" . $pid_query->fields['products_id'] . "' and language_id =3");

                    }
                    if ($name_fr != '') {
                        $sql_data = array(
                            'products_name' => $name_fr
                        );
                        zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data, 'update', "products_id='" . $pid_query->fields['products_id'] . "' and language_id =4");

                    }

                    $products_description_en = file_get_contents($txtxdir . $txtfrom . '-EN/' . trim($model) . '.txt');
                    $products_description_de = file_get_contents($txtxdir . $txtfrom . '-DE/' . trim($model) . '.txt');
                    $products_description_ru = file_get_contents($txtxdir . $txtfrom . '-RU/' . trim($model) . '.txt');
                    $products_description_fr = file_get_contents($txtxdir . $txtfrom . '-FR/' . trim($model) . '.txt');


                    if ($products_description_en != '') {
                        $sql_data_array_description = array(
                            'products_id' => $pid_query->fields['products_id'],
                            'products_description' => trim($products_description_en),
                            'language_id' => 1
                        );
                        $check_exist_result = $db->Execute('select products_id from ' . TABLE_PRODUCTS_INFO . ' where products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 1 ');
                        if ($check_exist_result->RecordCount() > 0) {
                            zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description, "update", 'products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 1');
                        } else {
                            zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description, "insert", 'products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 1');
                        }
                    }
                    unset($check_exist_result);
                    unset($sql_data_array_description);

                    if ($products_description_de != '') {
                        $sql_data_array_description = array(
                            'products_description' => trim($products_description_de),
                            'products_id' => $pid_query->fields['products_id'],
                            'language_id' => 2
                        );
                        $check_exist_result = $db->Execute('select products_id from ' . TABLE_PRODUCTS_INFO . ' where products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 2 ');
                        if ($check_exist_result->RecordCount() > 0) {
                            zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description, "update", 'products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 2');
                        } else {
                            zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description, "insert", 'products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 2');
                        }

                    }
                    unset($check_exist_result);
                    unset($sql_data_array_description);


                    if ($products_description_ru != '') {
                        $sql_data_array_description = array(
                            'products_description' => trim($products_description_ru),
                            'products_id' => $pid_query->fields['products_id'],
                            'language_id' => 3
                        );
                        $check_exist_result = $db->Execute('select products_id from ' . TABLE_PRODUCTS_INFO . ' where products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 3 ');
                        if ($check_exist_result->RecordCount() > 0) {
                            zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description, "update", 'products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 3');
                        } else {
                            zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description, "insert", 'products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 3');
                        }

                    }
                    unset($check_exist_result);
                    unset($sql_data_array_description);

                    if ($products_description_fr != '') {

                        $sql_data_array_description = array(
                            'products_description' => trim($products_description_fr),
                            'products_id' => $pid_query->fields['products_id'],
                            'language_id' => 4
                        );
                        $check_exist_result = $db->Execute('select products_id from ' . TABLE_PRODUCTS_INFO . ' where products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 4 ');
                        if ($check_exist_result->RecordCount() > 0) {
                            zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description, "update", 'products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 4');
                        } else {
                            zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_description, "insert", 'products_id = ' . $pid_query->fields['products_id'] . ' and language_id = 4');
                        }

                    }
                    unset($check_exist_result);
                    unset($sql_data_array_description);

                    remove_product_memcache($pid_query->fields['products_id']);
                }
                if (sizeof($error_array)) {
                    foreach ($error_array as $value) {
                        $messageStack->add_session($value, 'error');
                    }
                    zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD));
                } else {
                    $messageStack->add_session('更新标题和描述完成', 'success');
                    zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD));
                }
            } else {
                $messageStack->add_session('产品数据文件不存在', 'error');
                zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD));
            }
            break;

        case 'update_tips' :
            set_time_limit(0);
            @ini_set('memory_limit', '256M');
            set_include_path('../Classes/');
            $startime = microtime(true);
            include 'PHPExcel.php';
            include 'PHPExcel/Reader/Excel2007.php';
            $objReader = new PHPExcel_Reader_Excel2007 ();

            //	产品表格
            $xlsxdir = '../products/';
            $xlsxfrom = "tips_".date('Ymd') . '.xlsx';
            $xlsxfile = $xlsxdir . $xlsxfrom;
            if (file_exists($xlsxfile)) unlink($xlsxfile);
            move_uploaded_file($_FILES['whereisxlsx4']['tmp_name'], $xlsxfile);

            //	产品提示
            $txtxdir = '../products/description/';
            $zip = new ZipArchive;
            if ($zip->open($_FILES['whereistxt4']['tmp_name']) === true) {
                $zip->extractTo($txtxdir);
            }
            $txtfrom = "tips";
            if (file_exists($xlsxfile)) {
                $objPHPExcel = $objReader->load($xlsxfile);
                $sheet = $objPHPExcel->getActiveSheet();
                $error_array = array();

                $update_products_info_model = array();
                for ($j = 2; $j <= $sheet->getHighestRow(); $j++) {
                    $update_products_info_model[] = trim($sheet->getCellByColumnAndRow(0, $j)->getValue());
                }


                if($update_products_info_model){
                    $update_products_info_model_final = implode("','",$update_products_info_model);
                    $update_products_info_model_final ="'".$update_products_info_model_final."'";
                    $update_products_info_id = array();
                    $get_product_query = "select products_id from " . TABLE_PRODUCTS . "   where  products_model in (".$update_products_info_model_final.")";
                    $get_product = $db->Execute($get_product_query);
                    if ($get_product->RecordCount() > 0) {
                        while (!$get_product->EOF) {
                            $update_products_info_id[] = $get_product->fields ['products_id'];
                            $get_product->MoveNext();
                        }
                    }

                    if($update_products_info_id){
                        $update_products_info_id_final = implode(",",$update_products_info_id);

                        $products_tips_en = file_exists($txtxdir . $txtfrom . '_EN.txt') ? file_get_contents($txtxdir . $txtfrom . '_EN.txt') : false;
                        $products_tips_de =  file_exists($txtxdir . $txtfrom . '_DE.txt') ? file_get_contents($txtxdir . $txtfrom . '_DE.txt') : false;
                        $products_tips_ru =  file_exists($txtxdir . $txtfrom . '_RU.txt') ? file_get_contents($txtxdir . $txtfrom . '_RU.txt') : false;
                        $products_tips_fr =  file_exists($txtxdir . $txtfrom . '_FR.txt') ? file_get_contents($txtxdir . $txtfrom . '_FR.txt') : false;

                        if ($products_tips_en !== false) {
                            $products_tips_en = zen_db_input($products_tips_en);
                            $update_products_info_model_sql = 'UPDATE ' . TABLE_PRODUCTS_INFO . ' SET products_tips = "'.$products_tips_en.'" WHERE language_id = 1 AND products_id IN (' . $update_products_info_id_final.')';
                            $update_products_info_query = $db->Execute($update_products_info_model_sql);
                        }

                        if ($products_tips_de !== false) {
                            $products_tips_de = zen_db_input($products_tips_de);
                            $update_products_info_model_sql = 'UPDATE ' . TABLE_PRODUCTS_INFO . ' SET products_tips = "'.$products_tips_de.'" WHERE language_id = 2 AND products_id IN (' . $update_products_info_id_final.')';
                            $update_products_info_query = $db->Execute($update_products_info_model_sql);
                       }

                        if ($products_tips_ru !== false) {
                            $products_tips_ru = zen_db_input($products_tips_ru);
                            $update_products_info_model_sql = 'UPDATE ' . TABLE_PRODUCTS_INFO . ' SET products_tips = "'.$products_tips_ru.'" WHERE language_id = 3 AND products_id IN (' . $update_products_info_id_final.')';
                            $update_products_info_query = $db->Execute($update_products_info_model_sql);
                        }

                        if ($products_tips_fr !== false) {
                            $products_tips_fr = zen_db_input($products_tips_fr);
                            $update_products_info_model_sql = 'UPDATE ' . TABLE_PRODUCTS_INFO . ' SET products_tips = "'.$products_tips_fr.'" WHERE language_id = 4 AND products_id IN (' . $update_products_info_id_final.')';
                            $update_products_info_query = $db->Execute($update_products_info_model_sql);
                        }
                    }

                    foreach ($update_products_info_id as $p_info_id){
                        remove_product_memcache($p_info_id);
                    }

                    product_info_update_log($update_products_info_model_final,$_SESSION ['admin_id']);
                }else{
                    $messageStack->add_session("产品编号不能为空", 'error');
                    zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD));
                }

                $messageStack->add_session('更新提示完成', 'success');
                zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD));
            } else {
                $messageStack->add_session('产品数据文件不存在', 'error');
                zen_redirect(zen_href_link(FILENAME_PRODUCTS_UPLOAD));
            }
            break;
    }
}
?>
    <!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

    <html <?php echo HTML_PARAMS; ?>>

    <head>

        <meta http-equiv="Content-Type"
              content="text/html; charset=<?php echo CHARSET; ?>">

        <title><?php echo TITLE; ?></title>

        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

        <link rel="stylesheet" type="text/css"
              href="includes/cssjsmenuhover.css" media="all" id="hoverJS">

        <script language="javascript" src="includes/menu.js"></script>

        <script language="javascript" src="includes/general.js"></script>
        <script language="javascript" src="includes/jquery.js"></script>
        <script type="text/javascript">
            function init() {

                cssjsmenu('navbar');

                if (document.getElementById) {

                    var kill = document.getElementById('hoverJS');

                    kill.disabled = true;

                }

                <?php
                if(isset($_GET['async']) && in_array($_GET['async'], array('auto', 'manual'))){
                ?>

                var async = '<?php echo $_GET['async']?>';
                setTimeout(function () {
                        getResult(interval_id, async);
                    },
                    200, interval_id, async);
                interval_id = setInterval(function () {
                    getResult(interval_id, async);
                }, 6000, interval_id, async);
                <?php
                }
                ?>

            }

            function checkfile() {
                if ($('#whereisxlsx').val() == '' || $('#whereistxt').val() == '') {
                    alert('输入不能为空');
                    return false;
                } else {
                    return true;
                }
            }

            function checkfile3() {
                if ($('#file_img').val() == '' || $('#file_img').val() == '') {
                    alert('输入不能为空');
                    return false;
                } else {
                    return true;
                }
            }

            function checkfile2() {
                if ($('#whereisxlsx2').val() == '' || $('#whereistxt2').val() == '') {
                    alert('输入不能为空');
                    return false;
                } else {
                    return true;
                }
            }


            function checkfile4() {
                if ($('#whereisxlsx4').val() == '' || $('#whereistxt4').val() == '') {
                    alert('输入不能为空');
                    return false;
                } else {
                    return true;
                }
            }

            var interval_id = 0;

            function getResult(id, async) {
                $.ajax({
                    url: '/upload_img_result_' + async + '.php',
                    type: 'get',
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.indexOf('%') !== -1) {
                            $(".img_process_tip").remove();
                            $("body").prepend('<table class="img_process_tip" border="0" width="100%" cellspacing="0" cellpadding="2">\n' +
                                '  <tbody><tr class="messageStackError"> <td class="messageStackSuccess" style="font-size:20; ">\n' +
                                '<img src="images/icons/success.gif" border="0" alt="Success" title=" Success " >&nbsp;刷图片程序已在后台自动执行，请不要关闭当前页面，否则商品状态不能更新为上架！每6秒更新进度提示！</td>\n' +
                                '<tr class="messageStackError">\n' +
                                '    <td class="messageStackError" style="font-size:20;font-weight: bold;color:#f00;"><img src="images/icons/error.gif" border="0" alt="Error" title=" Error ">&nbsp;刷图已处理:' + data + '</td>\n' +
                                '  </tr></tbody></table>');
                        } else {
                            $(".messageStackCaution").remove();
                            if (data != 'success') {
                                var res = data.split("\n");
                                var strHtml = ' ';
                                /*     for(var i in res){
                                         strHtml +=  '  <tr class="messageStackError">\n' +
                                             '    <td class="messageStackError"><img src="images/icons/error.gif" border="0" alt="Error" title=" Error ">商品编号：'+res[i]+' 图片缺失</td>\n' +
                                             '  </tr>\n' ;
                                     }*/

                                strHtml += '  <tr class="messageStackError">\n' +
                                    '    <td class="messageStackError"><img src="images/icons/error.gif" border="0" alt="Error" title=" Error ">商品编号：<br/>' + data + ' <br/>\n图片缺失</td>\n' +
                                    '  </tr>\n';

                                strHtml += '  <tr class="messageStackError">\n' +
                                    '    <td class="messageStackError"><img src="images/icons/error.gif" border="0" alt="Error" title=" Error "><a href="' + '<?php echo HTTP_IMG_SERVER?>/upload_img_result_' + async + '.txt' + '" target="_blank">查看缺失编号列表</a></td>\n' +
                                    '  </tr>\n';
                                $("body").prepend('<table border="0" width="100%" cellspacing="0" cellpadding="2">\n' +
                                    '  <tbody>\n' + strHtml +
                                    '</tbody></table>');
                                $(".img_process_tip").remove();
                                $("body").prepend('<table border="0" width="100%" cellspacing="0" cellpadding="2">\n' +
                                    '  <tbody> <tr class="messageStackError">\n' +
                                    '    <td class="messageStackSuccess"><img src="images/icons/success.gif" border="0" alt="Success" title=" Success ">&nbsp;刷图片已完成</td>\n' +
                                    '  </tr></tbody></table>');

                            } else {
                                $(".img_process_tip").remove();
                                $("body").prepend('<table border="0" width="100%" cellspacing="0" cellpadding="2">\n' +
                                    '  <tbody> <tr class="messageStackError">\n' +
                                    '    <td class="messageStackSuccess"><img src="images/icons/success.gif" border="0" alt="Success" title=" Success ">&nbsp;刷图片已完成</td>\n' +
                                    '  </tr></tbody></table>');
                            }

                            updateProductStatus("<?php   echo zen_href_link(FILENAME_PRODUCTS_UPLOAD, 'action=img_finish_update_status&async=')?>" + async);
                            clearInterval(id);
                        }
                    }
                });
            }

            function updateProductStatus(url) {
                $.ajax({
                    url: url,
                    type: 'get',
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                    }
                });
            }
        </script>
        <style>
            #products_upload_main {
                padding: 10px;
            }

            #products_upload_main p {
                margin: 0px;
            }

            .inputdiv {
                margin: 20px 0 30px 20px;
            }

            .headertitle {
                font-size: 15px;
                padding: 0 0 5px;
            }

            .inputdiv {
                font-size: 12px;
            }

            .inputdiv .filetips {
                color: #FF6600;
                font-size: 12px;
                padding: 5px 0;
            }

            .inputdiv .filetips a {
                color: #0000ff;
                text-decoration: underline;
            }

            .submitdiv {
                margin-top: 8px;
            }

            .submitdiv input {
                font-size: 16px;
                width: 100px;
            }
        </style>
    </head>
    <body onLoad="init()">
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <div id="products_upload_main">
        <p class="pageHeading">自动上货</p>
        <p class='filetips'>重要： 默认是下架状态，刷图成功后的商品自动上架，提示刷图进度时不要关闭页面</p>
        <form action="<?php echo zen_href_link(FILENAME_PRODUCTS_UPLOAD, 'action=upload_data') ?>" method="post"
              onsubmit='return checkfile()' enctype="multipart/form-data">
            <div class='inputdiv'>
                <p class='headertitle'>1. 上传产品数据表格</p>
                <b>File:</b> <input type="file" id='whereisxlsx' name='whereisxlsx'>
                <p class='filetips'>(请确保所选择文件的数据格式和模板一致, <a href='./file/products_template.xlsx'>模板参照</a>)</p>
            </div>
            <div class='inputdiv'>
                <p class='headertitle'>2. 上传产品描述zip</p>
                <b>File:</b> <input type="file" id='whereistxt' name='whereistxt'>
                <p class='filetips'>(产品描述文件夹格式如20131024-EN,20131024-DE)</p>
                <p>
                    商品是否展示：<?php echo zen_draw_radio_field('is_display', '1', true, '', 'style="position:relative;top:3px;"') ?>
                    是
                    <span width="5px"></span><?php echo zen_draw_radio_field('is_display', '0', false, '', 'style="position:relative;top:3px;"') ?>
                    否
                </p>
                <div class='submitdiv'>
                    <input type='submit' name='uploadxlsx' value='提交'>
                </div>
            </div>
        </form>
        <p><b>Tips:</b> 请先通过ftp把图片原图提交下到相应的图片目录下.</p>

        <hr/>

        <p class="pageHeading">更新自动上货后缺失图片的商品图片和状态</p>
        <form action="<?php echo zen_href_link(FILENAME_PRODUCTS_UPLOAD, 'action=update_no_img_product') ?>"
              method="post" onsubmit='return checkfile3()' enctype="multipart/form-data">
            <div class='inputdiv'>
                <p class='headertitle'>上传缺失图片的产品数据表格</p>
                <b>File:</b> <input type="file" id='file_img' name='file_img'>
                <p class='filetips'>(请确保所选择文件的数据格式和模板一致, <a href='./file/update_products_img.xls'>模板参照</a>)</p>
                <p class='filetips'>重要：这个是将文件里对应编号的商品更新为上架状态 填写的编号必须是本次自动上货提示缺失图片的商品！</p>
            </div>
            <div class='inputdiv'>
                <div class='submitdiv'>
                    <input type='submit' name='uploadxlsx2' value='提交'>
                </div>
            </div>
        </form>

        <hr/>

        <p class="pageHeading">更新标题和描述(文件格式同上货)</p>
        <form action="<?php echo zen_href_link(FILENAME_PRODUCTS_UPLOAD, 'action=update_data') ?>" method="post"
              onsubmit='return checkfile2()' enctype="multipart/form-data">
            <div class='inputdiv'>
                <p class='headertitle'>1. 上传产品数据表格</p>
                <b>File:</b> <input type="file" id='whereisxlsx2' name='whereisxlsx2'>
            </div>
            <div class='inputdiv'>
                <p class='headertitle'>2. 上传产品描述zip</p>
                <b>File:</b> <input type="file" id='whereistxt2' name='whereistxt2'>
                <div class='submitdiv'>
                    <input type='submit' name='uploadxlsx2' value='提交'>
                </div>
            </div>
        </form>

        <p class="pageHeading">更新提示</p>
        <form action="<?php echo zen_href_link(FILENAME_PRODUCTS_UPLOAD, 'action=update_tips') ?>" method="post"
              onsubmit='return checkfile4()' enctype="multipart/form-data">
            <div class='inputdiv'>
                <p class='headertitle'>1. 上传产品数据表格</p>
                <b>File:</b> <input type="file" id='whereisxlsx4' name='whereisxlsx4'>
                <p class='filetips'>(请确保所选择文件的数据格式和模板一致, <a href='./file/update_products_tips.xlsx'>模板参照</a>)</p>
            </div>
            <div class='inputdiv'>
                <p class='headertitle'>2. 上传产品提示zip</p>
                <b>File:</b> <input type="file" id='whereistxt4' name='whereistxt4'>
                <p class='filetips'>(请确保所选择文件的数据格式和模板一致, 模板里所有的语种 实际操作不需要的不要放进去<a href='./file/update_products_info.zip'>模板参照</a>)</p>
                <div class='submitdiv'>
                    <input type='submit' name='uploadxlsx2' value='提交'>
                </div>
            </div>
        </form>
    </div>
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    </body>
    </html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>