<?php
define('OS_DELIM', '');
require('includes/application_top.php');
//zen_redirect(zen_href_link(FILENAME_DEFAULT, '', 'SSL'));
require('includes/functions/function_discount.php');
require(DIR_WS_CLASSES . 'language.php');
set_time_limit(0);
$action = (isset ($_GET ['action']) ? $_GET ['action'] : '');
if (zen_not_null($action)) {
    switch ($action) {
        case 'process' :
            $table = trim($_GET ['tablename']);
            $table_array = explode(',', $table);

            for ($i = 0; $i < sizeof($table_array); $i++) {
                $sql_text = '';
                $create_table = mysql_query("show create table " . $table_array [$i], $db_conn);
                $create_table_text = mysql_fetch_array($create_table);
                $sql_text .= $create_table_text ["Create Table"] . ';' . "\n\n\n";

                $table = $db->Execute("select * from " . $table_array [$i]);
                while (!$table->EOF) {
                    $keys = array_keys($table->fields);
                    $keys = array_map('addslashes', $keys);
                    $keys = join(',', $keys);
                    $values = array_values($table->fields);
                    $values = array_map('addslashes', $values);
                    $values = join('\',\'', $values);
                    $values = '\'' . $values . '\'';
                    $sql_text .= 'INSERT INTO ' . $table_array [$i] . ' (' . $keys . ') VALUES (' . $values . ');' . "\n";
                    $table->MoveNext();
                }
                $sql_file = 'backups/tables/' . $table_array [$i] . '.sql';
                $fp = fopen($sql_file, 'wb');
                fputs($fp, $sql_text);
                fclose($fp);
            }

            $backup_base_table_dir = 'backups/tables/';
            $backup_file_array = array();
            if ($backup_table_dir = @dir($backup_base_table_dir)) {
                while ($backup_table_file = $backup_table_dir->read()) {
                    if (preg_match('/.sql$/', $backup_table_file)) {
                        $backup_file_array [] = $backup_base_table_dir . $backup_table_file;
                    }
                }
            }

            $zip_file_name = 'db-dorabeads-' . date('YmdHis') . '.zip';
            if (sizeof($backup_file_array) > 0) {
                zen_create_zip($backup_file_array, $zip_file_name, true);
                if (preg_match('/MSIE/', $_SERVER ['HTTP_USER_AGENT'])) {
                    header('Content-type: application/octetstream');
                    header('Content-Disposition: attachment; filename=' . $zip_file_name);
                } else {
                    header('Content-Type: application/x-octet-stream');
                    header('Content-Disposition: attachment; filename=' . $zip_file_name);
                }
                readfile($zip_file_name);
                unlink($zip_file_name);
            }

            if ($backup_table_dir = @dir($backup_base_table_dir)) {
                while ($backup_table_file = $backup_table_dir->read()) {
                    if (preg_match('/.sql$/', $backup_table_file)) {
                        unlink($backup_base_table_dir . $backup_table_file);
                    }
                }
            }
            break;

        case 'update1' :
            $sql = "select configuration_value, last_modified from " . TABLE_CONFIGURATION . " where configuration_group_id = 1000 order by sort_order asc";
            $configures = $db->Execute($sql);

            $cur_currency = $configures->fields ['configuration_value'];
            $configures->MoveNext();
            $cur_profit = $configures->fields ['configuration_value'];

            $new_currency = zen_db_prepare_input($_POST ['currency']);
            $new_profit = zen_db_prepare_input($_POST ['profit']);

            if ($new_profit > 0 && $new_currency > 0) {
                $price_time = zen_trans_number_format_to_float(number_format($cur_currency * $new_profit / ($new_currency * $cur_profit), 4));
                $updateSql = 'update ' . TABLE_PRODUCTS . ' z set z.products_price = z.products_price * ' . $price_time . ', z.products_net_price = z.products_net_price*' . $price_time . ' where products_id in (select products_id from ' . TABLE_PRODUCTS_DISCOUNT_QUANTITY . ')';
                $db->Execute($updateSql);

                $updateSql = "update " . TABLE_CONFIGURATION . " z set z.configuration_value = '" . $new_currency . "' , z.last_modified = now() where z.configuration_key = 'CURRENT_CURRENCY'";
                $db->Execute($updateSql);

                $updateSql = "update " . TABLE_CONFIGURATION . " z set z.configuration_value = '" . $new_profit . "' , z.last_modified = now() where z.configuration_key = 'CURRENT_PROFIT_MARGIN'";
                $db->Execute($updateSql);

                // 更新MODULE_UPDATE_PRODUCTS_DISCOUNT_QUANTITY状态，状态为40-在架商品待更新
                $updateSql = "update " . TABLE_CONFIGURATION . " z set z.configuration_value = 40 , z.last_modified = now() where z.configuration_key = 'MODULE_UPDATE_PRODUCTS_DISCOUNT_QUANTITY'";
                $db->Execute($updateSql);

                $operate_content = '商品 products_price = products_price * ' . $price_time . ' in ' . __FILE__ . ' on line: ' . __LINE__;
                zen_insert_operate_logs($_SESSION ['admin_id'], '', $operate_content, 2);

            }
            zen_memcache_flush();
            break;
//        case 'update2' :
//            set_time_limit(24600);
//            $upload_data = @file($_FILES ['costfile'] ['tmp_name']);
//            $ls_not_refresh = '';
//
//            $lds_not_refresh = $db->Execute("Select products_id
//											   From " . TABLE_PRODUCTS_TO_CATEGORIES . "
//											  Where categories_id in (" . MODULE_CATEGORY_DO_NOT_REFRESH_PRICE . ")");
//            while (!$lds_not_refresh->EOF) {
//                $ls_not_refresh .= $lds_not_refresh->fields ['products_id'] . ', ';
//                $lds_not_refresh->MoveNext();
//            }
//            $ls_not_refresh = substr($ls_not_refresh, 0, -2);
//            $erp = array();
//            foreach ($upload_data as $row_num => $row_data) {
//                $data_fields = explode("\t", $row_data);
//                if (sizeof($data_fields >= 2)) {
//                    $model_name = $data_fields [0];
//                    if (!is_numeric($data_fields [1]) || !zen_not_null($model_name)) {
//                        continue;
//                    }
//                    $ldc_net_price = zen_trans_number_format_to_float(number_format($data_fields [1], 4));
//                    $ldc_price_times = zen_trans_number_format_to_float(number_format($data_fields [2], 1));
//                    $erp [$model_name] = array(
//                        'net_price' => $ldc_net_price,
//                        'price_times' => $ldc_price_times
//                    );
//                }
//            }
//
//            $ls_to_refresh = 'Select products_model, products_price_sorter, products_price, products_weight, products_id, products_model, product_price_times, products_net_price, price_manager_id
//								From ' . TABLE_PRODUCTS . "
//							   Where products_id not in (" . $ls_not_refresh . ")";
//            $lds_to_refresh = $db->Execute($ls_to_refresh);
//            $str = '';
//            $str_times = '';
//            $str_download = '';
//            while (!$lds_to_refresh->EOF) {
//                $price_manager_id = $lds_to_refresh->fields['price_manager_id'];
//                $products_model = $lds_to_refresh->fields['products_model'];
//
//                if ($lds_to_refresh->fields ['products_model'] == '' || !isset ($erp [$lds_to_refresh->fields ['products_model']])) {
//                    $lds_to_refresh->MoveNext();
//                } else {
//                    if ($lds_to_refresh->fields ['products_price_sorter'] != $lds_to_refresh->fields ['products_price'])
//                        $lb_special = true;
//                    $ldc_price_times = ($erp [$lds_to_refresh->fields ['products_model']] ['price_times'] > 0 ? $erp [$lds_to_refresh->fields ['products_model']] ['price_times'] : 0);
//
//                    if ($lds_to_refresh->fields ['products_net_price'] > 0) {
//                        $price_margin = abs($erp [$lds_to_refresh->fields ['products_model']] ['net_price'] - $lds_to_refresh->fields ['products_net_price']) / $lds_to_refresh->fields ['products_net_price'] * 100;
//                    } else {
//                        $price_margin = 0;
//                    }
//
//                    if ($erp [$lds_to_refresh->fields ['products_model']] ['price_times'] != $lds_to_refresh->fields ['product_price_times']) {
//                        $str_times .= $lds_to_refresh->fields ['products_model'] . "\t\t" . $erp [$lds_to_refresh->fields ['products_model']] ['price_times'] . "\t\t" . $lds_to_refresh->fields ['product_price_times'] . "\r\n";
//                    } elseif ($price_margin > PRICE_CHANGE_MARGIN) {
//                        $str .= $lds_to_refresh->fields ['products_model'] . "\t\t" . $erp [$lds_to_refresh->fields ['products_model']] ['net_price'] . "\t\t" . $lds_to_refresh->fields ['products_net_price'] . "\r\n";
//                    } elseif ($erp [$lds_to_refresh->fields ['products_model']] ['net_price'] > 0) {
//                        if (!(substr($products_model, -1) == 'H' || substr($products_model, -1) == 'Q') && $price_manager_id > 0) {
//                            $price_manager_value = $db->Execute("SELECT price_manager_value FROM " . TABLE_PRICE_MANAGER . " where price_manager_id = " . $price_manager_id . " order by price_manager_id desc ");
//                            $price_after_manager = $erp [$lds_to_refresh->fields ['products_model']] ['net_price'] * ($price_manager_value->fields['price_manager_value'] / 100 + 1);
//                        } else {
//                            $price_after_manager = $erp [$lds_to_refresh->fields ['products_model']] ['net_price'];
//                        }
//
//                        zen_refresh_products_price($lds_to_refresh->fields ['products_id'], $price_after_manager, $lds_to_refresh->fields ['products_weight'], 0, $ldc_price_times, $lb_special, $lds_to_refresh->fields ['products_price']);
//                    }
//                    $lds_to_refresh->MoveNext();
//                }
//            }
//            if ($str_times != '') {
//                $str_download = "商品编号\tERP系数\t网站系数\r\n" . $str_times . "\r\n\r\n";
//            }
//            if ($str != '') {
//                $str_download .= "商品编号\tERP成本价\t网站成本价\r\n" . $str;
//            }
//            if ($str_download != '') {
//                $filename = 'checkPrice.txt';
//                if (file_exists($filename)) {
//                    unlink($filename);
//                }
//                $fp = fopen($filename, 'a+');
//                fwrite($fp, $str_download);
//                fclose($fp);
//
//                header("Content-Type: application/force-download");
//                header("Content-Disposition: attachment; filename=" . $filename);
//                readfile($filename);
//                exit ();
//            }
//            break;

        case 'update4' :
            set_time_limit(24600);
            $t = time();
            echo '开始时间：' . $t . '<br>';
            $upload_data = @file($_FILES ['matchfile'] ['tmp_name']);
            $db->Execute("truncate " . TABLE_PRODUCTS_MATCH_PROD_LIST);
            foreach ($upload_data as $row_num => $row_data) {
                $data_fields = explode("\t", $row_data);
                if (sizeof($data_fields) > 0) {
                    if (trim($data_fields [1]) == '0' && trim($data_fields [2]) == '0') {
                        $prod_model_first = trim($data_fields [0]);
                        $prod_model_second = trim($data_fields [3]);
                        $prod_model_first_array = array_filter(explode(',', $prod_model_first));
                        $prod_model_second_array = array_filter(explode(',', $prod_model_second));
                        for ($first_cnt = 0; $first_cnt < sizeof($prod_model_first_array); $first_cnt++) {
                            if ($prod_model_first_array[$first_cnt] != '') {

                                $products_id = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model = " . "'" . $prod_model_first_array[$first_cnt] . "'")->fields['products_id'];
                                if ($products_id) {
                                    //$db->Execute("delete from ".TABLE_PRODUCTS_MATCH_PROD_LIST." where products_id =".$products_id);
                                    foreach ($prod_model_second_array as $key => $value) {
                                        $match_products_id = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model = " . "'" . $value . "'")->fields['products_id'];
                                        if ($match_products_id) {
                                            $db->Execute("insert into " . TABLE_PRODUCTS_MATCH_PROD_LIST . " values(''," . $products_id . "," . $match_products_id . ")");
                                        }
                                    }
                                }

                                /* $match_prod_query = 'Update ' . TABLE_PRODUCTS . '
                                                      Set match_prod_list = "' . $prod_model_second . '"
                                                    Where products_model = "' . $prod_model_first_array [$first_cnt] . '"'; */
                            }
                            //$db->Execute ( $match_prod_query );
                        }
                        /* for($second_cnt = 0; $second_cnt < sizeof ( $prod_model_second_array ); $second_cnt ++) {
                            $match_prod_ori = $db->Execute ( 'select match_prod_list from ' . TABLE_PRODUCTS . ' where products_model = "' . $prod_model_second_array [$second_cnt] . '"' );
                            if ($match_prod_ori->RecordCount () == 1 && $match_prod_ori->fields ['match_prod_list'] != '') {
                                $match_prod_list_original = explode ( ',', $match_prod_ori->fields ['match_prod_list'] );
                                $match_prod_list_merge = array_merge ( $prod_model_first_array, $match_prod_list_original );
                                $match_prod_list_merge = array_filter(array_unique ( $match_prod_list_merge ));
                                $match_prod_list = implode ( ',', $match_prod_list_merge );
                            } else {
                                $match_prod_list = $prod_model_first;
                            }
                            $match_prod_query = 'Update ' . TABLE_PRODUCTS . '
                                                      Set match_prod_list = "' . $match_prod_list . '"
                                                    Where products_model = "' . $prod_model_second_array[$second_cnt] . '"';
                            $db->Execute ( $match_prod_query );
                        } */
                    } else {
                        $prod_model = trim($data_fields[0]);
                        $prod_match = trim($data_fields[3]);
                        $prod_match = array_filter(explode(',', $prod_match));
                        if ($prod_model != '' && $prod_match != '') {
                            $products_id3 = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model = " . "'" . $prod_model . "'")->fields['products_id'];
                            if ($products_id3) {
                                foreach ($prod_match as $key3 => $value3) {
                                    $match_products_id3 = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model = " . "'" . $value3 . "'")->fields['products_id'];
                                    if ($match_products_id3) {
                                        $db->Execute("insert into " . TABLE_PRODUCTS_MATCH_PROD_LIST . " values(''," . $products_id3 . "," . $match_products_id3 . ")");
                                    }
                                }
                                /* $match_prod_query = 'Update ' . TABLE_PRODUCTS . '
                                 Set match_prod_list = "' . $prod_match .'"
                                Where products_model = "' . $prod_model . '"';
                                $db->Execute($match_prod_query); */
                            }
                        }
                        /* if ($prod_model != '' && $prod_match!= ''){
                            $match_prod_query = 'Update ' . TABLE_PRODUCTS . '
                                                    Set match_prod_list = "' . $prod_match .'"
                                                  Where products_model = "' . $prod_model . '"';
                            $db->Execute($match_prod_query);
                        } */
                    }
                }
            }
            $t2 = time();
            echo '结束时间：' . $t2, '<br>';
            echo '花费：', ($t2 - $t);
            break;
        case 'update5' :
            $change_margin = zen_db_prepare_input($_POST ['change_margin']);
            if ($change_margin > 0) {
                $db->Execute('update ' . TABLE_CONFIGURATION . ' set configuration_value = "' . $change_margin . '" where configuration_key = "PRICE_CHANGE_MARGIN"');
                $messageStack->add('更新成功！', 'success');
            }
            break;
        case 'update6' :
            set_time_limit(24600);
            $upload_data = @file($_FILES ['timesfile'] ['tmp_name']);

            foreach ($upload_data as $row_num => $row_data) {
                $data_fields = explode("\t", $row_data);
                if (sizeof($data_fields >= 2)) {
                    $model_name = $data_fields [0];
                    if (!is_numeric($data_fields [1]) || !zen_not_null($model_name)) {
                        continue;
                    }
                    $ldc_net_price = zen_trans_number_format_to_float(number_format($data_fields [1], 4));
                    $ldc_price_times = zen_trans_number_format_to_float(number_format($data_fields [2], 1));
                    $db->Execute('update ' . TABLE_PRODUCTS . ' set product_price_times = ' . $ldc_price_times . ' where products_model = "' . $model_name . '"');
                    $ls_to_refresh = 'Select products_price_sorter, products_price, products_weight, products_id, products_model, product_price_times, products_net_price
								From ' . TABLE_PRODUCTS . '
							   Where products_model = "' . $model_name . '"';
                    $lds_to_refresh = $db->Execute($ls_to_refresh);
                    if ($lds_to_refresh->fields ['products_price_sorter'] != $lds_to_refresh->fields ['products_price']) $lb_special = true;
                    zen_refresh_products_price($lds_to_refresh->fields ['products_id'], $ldc_net_price, $lds_to_refresh->fields ['products_weight'], 0, $ldc_price_times, $lb_special, $lds_to_refresh->fields ['products_price']);
                }
            }
            break;
    }
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
            function init() {
                cssjsmenu('navbar');
                if (document.getElementById) {
                    var kill = document.getElementById('hoverJS');
                    kill.disabled = true;
                }
            }

            // -->
        </script>
    </head>
    <body onLoad="init()">
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading"
                align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
        </tr>
    </table>
    <!-- body //-->
    <table border="0" width="100%" cellspacing="2" cellpadding="2">
        <tr>
            <td colspan="2" align="left"
                style="font-family: Verdana, sans-serif; font-size: 15px; font-size-adjust: none; color: #003D00; font-variant: small-caps; font-weight: bold;">
                Update Currency & Profit
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top">
                            <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                <tr class="dataTableHeadingRow">
                                    <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CURRENCY; ?></td>
                                    <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PROFIT; ?></td>
                                    <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_MODIFY_DATE; ?></td>
                                    <td class="dataTableHeadingContent"
                                        align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;
                                    </td>
                                </tr>
                                <?php
                                echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(product_updater, '&action=edit') . '\'">' . "\n";
                                $sql = "select configuration_value, last_modified from " . TABLE_CONFIGURATION . " where configuration_group_id = 1000 order by sort_order asc";
                                $configures = $db->Execute($sql);
                                ?>
                                <td class="dataTableContent">
                                    <?php
                                    $cur_currency = $configures->fields ['configuration_value'];
                                    echo $cur_currency;
                                    $configures->MoveNext();
                                    ?>
                                </td>
                                <td class="dataTableContent">
                                    <?php
                                    $cur_profit = $configures->fields ['configuration_value'];
                                    echo $cur_profit;
                                    ?>
                                </td>
                                <td class="dataTableContent">
                                    <?php
                                    $last_modified = $configures->fields ['last_modified'];
                                    echo $last_modified;
                                    ?>
                                </td>
                                <td class="dataTableContent" align="right">
                                    <?php
                                    echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', '');
                                    ?>
                                    &nbsp;
                                </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <?php
                            $heading = array();
                            $contents = array();

                            switch ($action) {
                                case 'edit' :
                                    $heading [] = array(
                                        'text' => '<b> Edit the Currency & Profit</b>'
                                    );

                                    $contents = array(
                                        'form' => zen_draw_form('currency', product_updater, 'action=update1')
                                    );
                                    $contents [] = array(
                                        'text' => 'Please make any neccesary changes:'
                                    );
                                    $contents [] = array(
                                        'text' => '<br />New Currency<br />' . zen_draw_input_field('currency', $cur_currency)
                                    );
                                    $contents [] = array(
                                        'text' => '<br />New Profit Margin<br />' . zen_draw_input_field('profit', $cur_profit)
                                    );
                                    $contents [] = array(
                                        'align' => 'center',
                                        'text' => '<br />' . zen_image_submit('button_update.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . zen_href_link(product_updater) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'
                                    );
                                    break;
                                default :
                                    $heading [] = array(
                                        'text' => '<b>Currency & Profit</b>'
                                    );
                                    $contents [] = array(
                                        'align' => 'left',
                                        'text' => '<b>Current Currency:</b> ' . $cur_currency
                                    );
                                    $contents [] = array(
                                        'align' => 'left',
                                        'text' => '<b>Current Profit Margin:</b> ' . $cur_profit
                                    );
                                    $contents [] = array(
                                        'text' => '<br> <b>Last modified date:</b><br/> ' . $last_modified
                                    );
                                    break;
                            }

                            if ((zen_not_null($heading)) && (zen_not_null($contents))) {
                                echo '            <td width="25%" valign="top">' . "\n";

                                $box = new box ();
                                echo $box->infoBox($heading, $contents);

                                echo '            </td>' . "\n";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- body_eof //-->
    <br/>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 8px 10px;"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCTS_UPDATER, 'action=process&tablename=' . TABLE_PRODUCTS . ',' . TABLE_PRODUCTS_DISCOUNT_QUANTITY) . '"><b>Download Products Infomation</b></a>' ?></td>
        </tr>
    </table>
    <br/>
<!--    <table border="0" width="100%" cellspacing="2" cellpadding="2">-->
<!--        <tr>-->
<!--            <td colspan="1" align="left"-->
<!--                style="font-family: Verdana, sans-serif; font-size: 15px; font-size-adjust: none; color: #003D00; font-variant: small-caps; font-weight: bold;">-->
<!--                Update product price by file-->
<!--            </td>-->
<!--        </tr>-->
<!--        <td>-->
<!--            <form ENCTYPE="multipart/form-data" ACTION="product_updater.php?action=update2" METHOD="POST">-->
<!--                <div style="float: left;">-->
<!--                    <input TYPE="hidden" name="MAX_FILE_SIZE" value="100000000">-->
<!--                    <input name="costfile" type="file" size="50">-->
<!--                    <input type="submit" name="buttoninsert" value="Update">-->
<!--                    <br/>-->
<!--                </div>-->
<!--            </form>-->
<!--            <form action="product_updater.php?action=update5" METHOD="POST">-->
<!--                <div style="margin-left: 500px;">-->
<!--                    <span style="font-family: Verdana, sans-serif; font-size: 15px; font-size-adjust: none; color: #003D00; font-variant: small-caps; font-weight: bold;">变动幅度</span>-->
<!--                    <br>-->
<!--                    <input name="change_margin" type="text"-->
<!--                           value="--><?php //echo zen_get_configuration_key_value('PRICE_CHANGE_MARGIN'); ?><!--">-->
<!--                    %-->
<!--                    <input type="submit" value="提交">-->
<!--                    <br/>-->
<!--                </div>-->
<!--            </form>-->
<!--        </td>-->
<!--        <tr>-->
<!--        </tr>-->
<!--    </table>-->
    <br/>
    <br/>
    <table border="0" width="100%" cellspacing="2" cellpadding="2">
        <tr>
            <td colspan="1" align="left"
                style="font-family: Verdana, sans-serif; font-size: 15px; font-size-adjust: none; color: #003D00; font-variant: small-caps; font-weight: bold;">
                Update product matching products by TXT file
            </td>
        </tr>
        <td>
            <form ENCTYPE="multipart/form-data" ACTION="product_updater.php?action=update4" METHOD="POST">
                <div align="left">
                    <input TYPE="hidden" name="MAX_FILE_SIZE" value="100000000">
                    <input name="matchfile" type="file" size="50">
                    <input type="submit" name="buttoninsert" value="Update">
                    <br/>
                </div>
            </form>
        </td>
        <tr>
        </tr>
    </table>

    <table border="0" width="100%" cellspacing="2" cellpadding="2">
        <tr>
            <td colspan="1" align="left"
                style="font-family: Verdana, sans-serif; font-size: 15px; font-size-adjust: none; color: #003D00; font-variant: small-caps; font-weight: bold;">
                更新价格系数
            </td>
        </tr>
        <td>
            <form ENCTYPE="multipart/form-data" ACTION="product_updater.php?action=update6" METHOD="POST">
                <div align="left">
                    <input TYPE="hidden" name="MAX_FILE_SIZE" value="100000000">
                    <input name="timesfile" type="file" size="50">
                    <input type="submit" name="buttoninsert" value="Update">
                    <br/>
                </div>
            </form>
        </td>
        <tr>
        </tr>
    </table>
    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
    <br/>
    </body>
    </html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>