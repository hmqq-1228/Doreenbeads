<?php
/**
 * @package admin
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: update_product.php 5974 2007-03-04 01:17:35Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
include(DIR_FS_CATALOG . DIR_WS_CLASSES . 'language.php');
//jessa 2010-01-28 get the product info

$product_weight = trim($_POST['products_weight']);
$product_new_net_price = trim($_POST['products_net_price']);
if ($product_new_net_price == '') $product_new_net_price = 0;
$old_price_times = trim($_POST['old_price_times']);
if ($old_price_times == '') $old_price_times = 0;
$old_product_net_price = trim($_POST['old_net_price']);
if ($old_product_net_price == '') $old_product_net_price = 0;
$old_product_weight = trim($_POST['old_product_weight']);
if ($old_product_weight == '') $old_product_weight = 0;
$new_price_times = trim($_POST['product_price_times']) != '' ? trim($_POST['product_price_times']) : 0;


//eof jessa 2010-01-28

if (isset($_POST['edit_x']) || isset($_POST['edit_y'])) {
    $action = 'new_product';
} else {
    if (isset($_GET['pID'])) $products_id = zen_db_prepare_input($_GET['pID']);
    $products_date_available = zen_db_prepare_input($_POST['products_date_available']);

    $products_date_available = (date('Y-m-d') < $products_date_available) ? $products_date_available : 'null';

    // Data-cleaning to prevent MySQL5 data-type mismatch errors:
    $tmp_value = zen_db_prepare_input($_POST['products_quantity']);
    $products_quantity = (!zen_not_null($tmp_value) || $tmp_value == '' || $tmp_value == 0) ? 0 : $tmp_value;
    $tmp_value = zen_db_prepare_input($_POST['products_price']);
    $products_price = (!zen_not_null($tmp_value) || $tmp_value == '' || $tmp_value == 0) ? 0 : $tmp_value;
    //jessa 2009-08-24 ÔöŒÓÒ»žö»ñÈ¡products_net_price±íµ¥ÊýŸÝµÄŽúÂë
    $tmp_value = zen_db_prepare_input($_POST['products_net_price']);
    $products_net_price = (!zen_not_null($tmp_value) || $tmp_value == '' || $tmp_value == 0) ? 0 : $tmp_value;
    //eof jessa 2009-08-24
    $tmp_value = zen_db_prepare_input($_POST['products_weight']);
    $products_weight = (!zen_not_null($tmp_value) || $tmp_value == '' || $tmp_value == 0) ? 0 : $tmp_value;
    $tmp_value = zen_db_prepare_input($_POST['manufacturers_id']);
    $manufacturers_id = (!zen_not_null($tmp_value) || $tmp_value == '' || $tmp_value == 0) ? 0 : $tmp_value;

    $price_manager_check = zen_db_prepare_input($_POST ['price_manager_check']);
    $price_manager = 0;
    $price_manager_array = array();
    if (substr($_POST['products_model'], -1) == 'H' || substr($_POST['products_model'], -1) == 'Q') {
        $price_manager_array = array('price_manager_id' => 0);
        $products_price = $product_new_net_price;
    } else {
        if ($price_manager_check > 0) {
            $price_manager = zen_db_prepare_input($_POST ['price_manager']);

            if ($price_manager > 0) {
                $price_manager_value = $db->Execute("SELECT price_manager_value FROM  " . TABLE_PRICE_MANAGER . " where price_manager_id = " . $price_manager . " order by price_manager_id desc ");

                $products_price = $products_net_price + ($products_net_price * ($price_manager_value->fields ['price_manager_value'] / 100));

                $price_manager_array = array('price_manager_id' => $price_manager);
            }
        } else {
            $products_price = $products_net_price;
        }
    }

    $ems_discount = EMS_DISCOUNT;
//	$airmail_info = get_airmail_info();
//	$products_price = $products_price + $products_weight * $airmail_info['extra_times'] * MODULE_SHIPPING_AIRMAIL_ARGUMENT * $airmail_info['discount'] / 1000 / MODULE_SHIPPING_CHIANPOST_CURRENCY;

    $$products_status = 1;
    if (zen_db_prepare_input($_POST ['limit_stock']) == 1 && $products_quantity == 0) {
        $$products_status = 0;
    }

    $sql_data_array = array( //'products_quantity' => $products_quantity,
        'products_type' => zen_db_prepare_input($_GET['product_type']),
        'products_model' => zen_db_prepare_input($_POST['products_model']),
        'products_price' => $products_price,
        'products_net_price' => $products_net_price,
        'products_date_available' => $products_date_available,
        'products_weight' => $products_weight,
        'products_volume_weight' => zen_db_prepare_input($_POST['products_volume_weight']),
        'products_status' => $$products_status,
        'is_mixed' => zen_db_prepare_input($_POST['is_mixed']),
        'products_virtual' => zen_db_prepare_input($_POST['products_virtual']),
        'products_tax_class_id' => zen_db_prepare_input($_POST['products_tax_class_id']),
        'manufacturers_id' => $manufacturers_id,
        'products_quantity_order_min' => zen_db_prepare_input($_POST['products_quantity_order_min']),
        'products_quantity_order_units' => zen_db_prepare_input($_POST['products_quantity_order_units']),
        'products_priced_by_attribute' => zen_db_prepare_input($_POST['products_priced_by_attribute']),
        'products_limit_stock' => zen_db_prepare_input($_POST['limit_stock']),
        'product_is_free' => zen_db_prepare_input($_POST['product_is_free']),
        'product_is_call' => zen_db_prepare_input($_POST['product_is_call']),
        'products_quantity_mixed' => zen_db_prepare_input($_POST['products_quantity_mixed']),
        'product_is_always_free_shipping' => zen_db_prepare_input($_POST['product_is_always_free_shipping']),
        'products_qty_box_status' => zen_db_prepare_input($_POST['products_qty_box_status']),
        'products_quantity_order_max' => ((zen_db_prepare_input($_POST['products_quantity_order_max'])) < 0 ? 0 : zen_db_prepare_input($_POST['products_quantity_order_max'])),
        'products_sort_order' => (int)zen_db_prepare_input($_POST['products_sort_order']),
        'products_discount_type' => zen_db_prepare_input($_POST['products_discount_type']),
        'products_discount_type_from' => zen_db_prepare_input($_POST['products_discount_type_from']),
        'products_price_sorter' => zen_db_prepare_input($_POST['products_price_sorter']),
        //'match_prod_list' => trim($_POST['match_products']),
        'product_price_times' => trim($_POST['product_price_times']),
        'products_level' => trim($_POST['products_level']),
        'products_stocking_days' => trim($_POST['products_stocking_days']),
        'is_display' => zen_db_prepare_input ( $_POST ['is_display'] )
    );

    $sql_data_array = array_merge($sql_data_array, $price_manager_array);
    //eof jessa 2010-01-22
    //eof jessa 2009-08-24

    // when set to none remove from database
    // is out dated for browsers use radio only
    $sql_data_array['products_image'] = zen_db_prepare_input($_POST['products_image']);
    $new_image = 'true';

    if ($_POST['image_delete'] == 1) {
        $sql_data_array['products_image'] = '';
        $new_image = 'false';
    }

    if ($_POST['image_delete'] == 1) {
        $sql_data_array['products_image'] = '';
        $new_image = 'false';
    }

    if ($action == 'insert_product') {
        $check_model_query = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model='" . ucfirst($sql_data_array['products_model']) . "'");
        if ($check_model_query->RecordCount() > 0) {
            $messageStack->add_session('商品编号重复，禁止上传', 'error');
            zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
        }
        $insert_sql_data = array('products_date_added' => 'now()',
            'master_categories_id' => (int)$current_category_id);

        $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

        zen_db_perform(TABLE_PRODUCTS, $sql_data_array);
        $products_id = zen_db_insert_id();
        //WSL
        $sql_data_array_products_stock = array(
            'products_id' => $products_id,
            'products_quantity' => $products_quantity,
            'create_time' => strtotime(date('Y-m-d H:i:s')),
            'modify_time' => strtotime(date('now'))
        );
        zen_db_perform(TABLE_PRODUCTS_STOCK, $sql_data_array_products_stock);

        /*best match 的单个商品更新 WSL*/
        if (isset($_POST ['match_products']) && $_POST ['match_products'] != '') {
            $db->Execute("delete from " . TABLE_PRODUCTS_MATCH_PROD_LIST . " where products_id = " . $products_id);
            $match_products_arr = explode(',', $_POST ['match_products']);
            foreach ($match_products_arr as $key => $value) {
                $match_products_id = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model = " . "'" . $value . "'")->fields['products_id'];
                $db->Execute("insert into " . TABLE_PRODUCTS_MATCH_PROD_LIST . " values(''," . $products_id . "," . $match_products_id . ")");
            }
        } else {
            $db->Execute("delete from " . TABLE_PRODUCTS_MATCH_PROD_LIST . " where products_id = " . $products_id);
        }
        /*end*/

        // reset products_price_sorter for searches etc.
        zen_update_products_price_sorter($products_id);

        zen_get_parent_categories($categories_all, $current_category_id);
        if (count($categories_all) == 0) {
            $update_categories = " $current_category_id ,0, 0, 0, 0, 0";
        } elseif (count($categories_all) == 1) {
            $update_categories = " $categories_all[0] , " . $current_category_id . ", 0, 0, 0, 0";
        } elseif (count($categories_all) == 2) {
            $update_categories = "  $categories_all[1], $categories_all[0], " . $current_category_id . ", 0, 0, 0";
        } elseif (count($categories_all) == 3) {
            $update_categories = "  $categories_all[2], $categories_all[1], $categories_all[0], " . $current_category_id . ", 0, 0";
        } elseif (count($categories_all) == 4) {
            $update_categories = "  $categories_all[3], $categories_all[2], $categories_all[1], " . $categories_all[0] . ", " . $current_category_id . ", 0";
        } elseif (count($categories_all) == 5) {
            $update_categories = "  $categories_all[4], $categories_all[3], $categories_all[2], " . $categories_all[1] . ", " . $categories_all[0] . ", " . $current_category_id . "";
        }

        $db->Execute("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . "
                    (products_id, categories_id,
                    first_categories_id,second_categories_id,
                    three_categories_id,four_categories_id,
                    five_categories_id,six_categories_id)
                    values ('" . (int)$products_id . "', '" . (int)$current_category_id . "'," . $update_categories . ")");

        ///////////////////////////////////////////////////////
        //// INSERT PRODUCT-TYPE-SPECIFIC *INSERTS* HERE //////
        //robbie ÔöŒÓproduct_qty_discount±íÄÚÈÝµÄÔöŒÓ
        zen_refresh_products_price((int)$products_id, $product_new_net_price, $product_weight, $old_price_times, $new_price_times, false, '', array('insert' => true, 'record_log' => true, 'batch_update' => false, 'currrency_last_modified' => null));// insert

        //jessa 2010-04-04 ÐÂœš²úÆ·µÄÊ±ºò£¬œ«²úÆ·µÄÀà±ðŒÆÈëÊýŸÝ¿â
        $insert_prod_catg = addslashes(trim($_POST['products_name_without_catg']));
        $find_prod_catg = $db->Execute("select * from t_prod_catg where pcg_name = '" . $insert_prod_catg . "'");
        if ($find_prod_catg->RecordCount() > 0) {
            $db->Execute("update t_prod_catg set pcg_create_date = now() where pcg_name = '" . $insert_prod_catg . "'");
        } else {
            $db->Execute("insert into t_prod_catg (pcg_id, pcg_name, pcg_create_date) values ('', '" . $insert_prod_catg . "', now())");
        }
        //eof jessa 2010-04-04
//eof jessa 2010-01-29 Íê³ÉÐÂœš²úÆ·²¢ÐÂœš²úÆ·µÄŒÛžñ·Ö×é±í
        file_get_contents(HTTP_SERVER . "/uploadimg.php?pid=" . $products_id);

        ////    *END OF PRODUCT-TYPE-SPECIFIC INSERTS* ////////
        ///////////////////////////////////////////////////////
    } elseif ($action == 'update_product') {
        $update_sql_data = array('products_last_modified' => 'now()',
            'master_categories_id' => ($_POST['master_category'] > 0 ? zen_db_prepare_input($_POST['master_category']) : zen_db_prepare_input($_POST['master_categories_id'])));

        $sql_data_array = array_merge($sql_data_array, $update_sql_data);

        $operate_content = '商品被编辑';
        if ($old_product_price != $products_price) {
            $operate_content .= ' products_net_price 变更: from ' . $old_product_net_price . ' to ' . $products_net_price . ' in ' . __FILE__ . ' on line: ' . __LINE__;
        }
        /*
        if (zen_db_prepare_input ( $_POST ['products_status'] ) == 0) {
            $operate_content .= ',商品状态:隐藏';
        } else if(zen_db_prepare_input ( $_POST ['products_status'] ) == 10) {
            $operate_content .= ',商品状态:删除';
        } else {
            $operate_content .= ',商品状态:显示';
        }
        */
        if (zen_db_prepare_input($_POST ['limit_stock']) == 1 && $products_quantity == 0) {
            $operate_content .= ',商品被无库存下架';
        }
        zen_insert_operate_logs($_SESSION ['admin_id'], zen_db_prepare_input($_POST ['products_model']), $operate_content, 2);

        zen_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "'");

        if ($products_quantity == 0) {
            //backorder商品 不更新pp_is_forbid为20 cm add
            //zen_auto_update_promotion_products_status($products_id);
            if(zen_db_prepare_input($_POST['limit_stock']) ==1){
                zen_auto_update_promotion_products_status($products_id);
            }

        } else {
            zen_auto_update_promotion_products_status($products_id, true);
        }

        // 若商品被限制库存，则将该商品从products_s_level表中删除
        if (zen_db_prepare_input($_POST ['limit_stock']) == 1) {
            $check_slevel_exist = "select products_id from " . TABLE_PRODUCTS_S_LEVEL . " where products_id = " . ( int )$products_id . " limit 1";
            $check_slevel_exist_result = $db->Execute($check_slevel_exist);
            if ($check_slevel_exist_result->RecordCount() > 0) {
                $db->Execute("delete from " . TABLE_PRODUCTS_S_LEVEL . " where products_id = " . ( int )$products_id);
                $operate_content = '商品在不更新库存表中删除';
                zen_insert_operate_logs($_SESSION ['admin_id'], zen_db_prepare_input($_POST ['products_model']), $operate_content, 2);
            }
        }

        update_products_quantity(array('products_id' => $products_id, 'products_quantity' => $products_quantity));
        /*best match 的单个商品更新 WSL*/
        if (isset($_POST ['match_products']) && $_POST ['match_products'] != '') {
            $db->Execute("delete from " . TABLE_PRODUCTS_MATCH_PROD_LIST . " where products_id = " . (int)$products_id);
            $match_products_arr = explode(',', $_POST ['match_products']);
            foreach ($match_products_arr as $key => $value) {
                $match_products_id = $db->Execute("select products_id from " . TABLE_PRODUCTS . " where products_model = " . "'" . $value . "'")->fields['products_id'];
                $db->Execute("insert into " . TABLE_PRODUCTS_MATCH_PROD_LIST . " values(''," . (int)$products_id . "," . $match_products_id . ")");
            }
        } else {
            $db->Execute("delete from " . TABLE_PRODUCTS_MATCH_PROD_LIST . " where products_id = " . $products_id);
        }
        /*end*/
        // reset products_price_sorter for searches etc.
        zen_update_products_price_sorter((int)$products_id);

        ///////////////////////////////////////////////////////
        //// INSERT PRODUCT-TYPE-SPECIFIC *UPDATES* HERE //////


//jessa 2010-02-01 ÔÚÐÞžÄ²úÆ·µÄÍ¬Ê±£¬·¢ËÍproducts notifyÓÊŒþ
        $tmp_value = zen_db_prepare_input($_POST['old_quantity']);
        $old_quantity = (!zen_not_null($tmp_value) || $tmp_value == '') ? 10 : $tmp_value;
        if ($products_quantity <> 0 && $old_quantity == 0) {
            //specify the newsletter id at here
            $newsletter = $db->Execute("select newsletters_id, title, content, content_html, module
                                from " . TABLE_NEWSLETTERS . "
                                where module = 'product_notification' Order By newsletters_id");

            /* $db->Execute("Update " . TABLE_PRODUCTS .
                                            " Set products_date_added = now()
                                            Where products_id = '" . $products_id . "'"); */

//	  	include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/newsletters/' . $nInfo->module . substr($PHP_SELF, strrpos($PHP_SELF, '.')));
//      include(DIR_WS_MODULES . 'newsletters/product_notification.php' . $nInfo->module . substr($PHP_SELF, strrpos($PHP_SELF, '.'));
            include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/newsletters/product_notification.php');
            include(DIR_WS_MODULES . 'newsletters/product_notification.php');

            if (!$newsletter->EOF) {
                $notification = new product_notification($newsletter->fields['title'], $newsletter->fields['content'], $newsletter->fields['content_html'], '1');

                //and the newsletter id at here
                $notification->send($newsletter->fields['newsletters_id'], $products_id);
            }
        }
        //eof jessa 2010-02-01

// 	if ($old_price_times <> $new_price_times or $product_weight <> $old_product_weight or $product_new_net_price <> $old_product_net_price)

        zen_refresh_products_price((int)$products_id, $products_price, $product_weight, $old_price_times, $new_price_times, false);

        remove_product_memcache((int)$products_id);
        /* 	 $insert_prod_catg = addslashes(trim($_POST['products_name_without_catg']));
             $old_quantity = trim($_POST['old_quantity']);
             $find_prod_catg = $db->Execute("select * from t_prod_catg where pcg_name = '" . $insert_prod_catg . "'");
             if ((int)$old_quantity == 0){
                 $db->Execute("update t_prod_catg set pcg_create_date = now() where pcg_name = '" . $insert_prod_catg . "'");
             }
             if ($find_prod_catg->RecordCount() == 0){
                 $db->Execute("insert into t_prod_catg (pcg_id, pcg_name, pcg_create_date) values ('', '" . $insert_prod_catg . "', now())");
             } */
        //eof jessa 2010-04-04
//eof jessa 2010-01-29 Íê³ÉÐÞžÄ


        ////    *END OF PRODUCT-TYPE-SPECIFIC UPDATES* ////////
        ///////////////////////////////////////////////////////
    }

    //bof property
    while (list($key, $value) = each($_POST['property_group_id'])) {
        if ($key != '') {
            if ($value == '') {
                $db->Execute('delete from ' . TABLE_PRODUCTS_TO_PROPERTY . ' where product_id = ' . $products_id . ' and property_group_id = ' . $key);;
            } else {
                $check = $db->Execute('select products_to_property_id from ' . TABLE_PRODUCTS_TO_PROPERTY . ' where product_id = ' . $products_id . ' and property_group_id = ' . $key);
                if ($check->RecordCount() > 0) {
                    $db->Execute('update ' . TABLE_PRODUCTS_TO_PROPERTY . ' set property_id = ' . $value . ' where product_id = ' . $products_id . ' and property_group_id = ' . $key);
                } else {
                    $db->Execute('insert into ' . TABLE_PRODUCTS_TO_PROPERTY . ' values (NULL, ' . $products_id . ', ' . $value . ', ' . $key . ')');
                }
            }
        }
    }
    //eof

    //bof 如果限制库存商品数量为0，则自动下架，zale(已删除的商品不适用此逻辑)
    if (zen_db_prepare_input($_POST['limit_stock']) && $products_quantity <= 0 && $sql_data_array['products_status'] != 10) {
        $db->Execute('update ' . TABLE_PRODUCTS . ' set products_status = 0 where products_id = ' . $products_id);
    }
    //eof

    $languages = zen_get_languages();
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $language_id = $languages[$i]['id'];

        $sql_data_array = array('products_name' => zen_db_prepare_input($_POST['products_name'][$language_id]),
            'products_name_without_catg' => (trim($_POST ['products_name_without_catg'] [$language_id] == '')) ? zen_db_prepare_input($_POST ['products_name_without_catg'] [1]) : zen_db_prepare_input($_POST ['products_name_without_catg'] [$language_id]),

            'products_url' => zen_db_prepare_input($_POST['products_url'][$language_id]));

        $sql_data_array_info = array('products_description' => zen_db_prepare_input($_POST['products_description'][$language_id]));

        $insert_sql_data = array('products_id' => $products_id,
            'language_id' => $language_id);
        if ($action == 'insert_product') {

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            $sql_data_array_info = array_merge($sql_data_array_info, $insert_sql_data);
            zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);
            zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_info);
            /*WSL products_name_without_catg字段插入*/
            $sql_data_array_products_name_without_catg = array(
                'products_name_without_catg' => zen_db_prepare_input(($_POST ['products_name_without_catg'] [$language_id] == '')) ? zen_db_prepare_input($_POST ['products_name_without_catg'] [1]) : zen_db_prepare_input($_POST ['products_name_without_catg'] [$language_id]),
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            );
            zen_db_perform(TABLE_PRODUCTS_NAME_WITHOUT_CATG, $sql_data_array_products_name_without_catg);
            $insert_id_products_name_without_catg = $db->insert_ID();
            $sql_data_array_products_name_without_catg_relation = array(
                'tag_id' => $insert_id_products_name_without_catg,
                'products_id' => $products_id,
                'created' => date('Y-m-d H:i:s')
            );
            zen_db_perform(TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION, $sql_data_array_products_name_without_catg_relation);

        } elseif ($action == 'update_product') {
            zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and language_id = '" . (int)$language_id . "'");

            $check_desc_exist = $db->Execute("select products_id from " . TABLE_PRODUCTS_INFO . " where products_id = '" . ( int )$products_id . "' and language_id = '" . ( int )$language_id . "'");
            if ($check_desc_exist->RecordCount() > 0) {
                zen_db_perform ( TABLE_PRODUCTS_INFO, $sql_data_array_info, 'update', "products_id = '" . ( int ) $products_id . "' and language_id = '" . ( int ) $language_id . "'" );
            } else {
                $sql_data_array_info = array_merge($sql_data_array_info, $insert_sql_data);
                zen_db_perform(TABLE_PRODUCTS_INFO, $sql_data_array_info);
            }
            /*WSL*/
            $products_name_without_catg_str = (trim($_POST ['products_name_without_catg'] [$language_id] == '')) ? zen_db_prepare_input($_POST ['products_name_without_catg'] [1]) : zen_db_prepare_input($_POST ['products_name_without_catg'] [$language_id]);
            $result = $db->Execute('select tag_id from ' . TABLE_PRODUCTS_NAME_WITHOUT_CATG . ' where products_name_without_catg = "' . $products_name_without_catg_str . '"');
            if ($result->RecordCount() > 0) {
                $tag_id = $result->fields['tag_id'];
            } else {
                $sql_data_array_products_name_without_catg = array(
                    'products_name_without_catg' => (trim($_POST ['products_name_without_catg'] [$language_id] == '')) ? zen_db_prepare_input($_POST ['products_name_without_catg'] [1]) : zen_db_prepare_input($_POST ['products_name_without_catg'] [$language_id]),
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s')
                );
                zen_db_perform(TABLE_PRODUCTS_NAME_WITHOUT_CATG, $sql_data_array_products_name_without_catg);
                $tag_id = $db->insert_ID();
            }
            $sql_data_array_products_name_without_catg_relation = array(
                'tag_id' => $tag_id,
            );

            zen_db_perform(TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION, $sql_data_array_products_name_without_catg_relation, 'update', "products_id = " . (int)$products_id);

        }
    }

    // add meta tags
    $languages = zen_get_languages();
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $language_id = $languages[$i]['id'];

        $sql_data_array = array('metatags_title' => zen_db_prepare_input($_POST['metatags_title'][$language_id]),
            'metatags_keywords' => zen_db_prepare_input($_POST['metatags_keywords'][$language_id]),
            'metatags_description' => zen_db_prepare_input($_POST['metatags_description'][$language_id]));

        if ($action == 'insert_product_meta_tags') {

            $insert_sql_data = array('products_id' => $products_id,
                'language_id' => $language_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            zen_db_perform(TABLE_META_TAGS_PRODUCTS_DESCRIPTION, $sql_data_array);
        } elseif ($action == 'update_product_meta_tags') {
            zen_db_perform(TABLE_META_TAGS_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and language_id = '" . (int)$language_id . "'");
        }
    }


    // future image handler code
    define('IMAGE_MANAGER_HANDLER', 0);
    define('DIR_IMAGEMAGICK', '');
    if ($new_image == 'true' and IMAGE_MANAGER_HANDLER >= 1) {
        $src = DIR_FS_CATALOG . DIR_WS_IMAGES . zen_get_products_image((int)$products_id);
        $filename_small = $src;
        preg_match("/.*\/(.*)\.(\w*)$/", $src, $fname);
        list($oiwidth, $oiheight, $oitype) = getimagesize($src);

        $small_width = SMALL_IMAGE_WIDTH;
        $small_height = SMALL_IMAGE_HEIGHT;
        $medium_width = MEDIUM_IMAGE_WIDTH;
        $medium_height = MEDIUM_IMAGE_HEIGHT;
        $large_width = LARGE_IMAGE_WIDTH;
        $large_height = LARGE_IMAGE_HEIGHT;

        $k = max($oiheight / $small_height, $oiwidth / $small_width); //use smallest size
        $small_width = round($oiwidth / $k);
        $small_height = round($oiheight / $k);

        $k = max($oiheight / $medium_height, $oiwidth / $medium_width); //use smallest size
        $medium_width = round($oiwidth / $k);
        $medium_height = round($oiheight / $k);

        $large_width = $oiwidth;
        $large_height = $oiheight;

        $products_image = zen_get_products_image((int)$products_id);
        $products_image_extension = substr($products_image, strrpos($products_image, '.'));
        $products_image_base = ereg_replace($products_image_extension, '', $products_image);

        $filename_medium = DIR_FS_CATALOG . DIR_WS_IMAGES . 'medium/' . $products_image_base . IMAGE_SUFFIX_MEDIUM . '.' . $fname[2];
        $filename_large = DIR_FS_CATALOG . DIR_WS_IMAGES . 'large/' . $products_image_base . IMAGE_SUFFIX_LARGE . '.' . $fname[2];

        // ImageMagick
        if (IMAGE_MANAGER_HANDLER == '1') {
            copy($src, $filename_large);
            copy($src, $filename_medium);
            exec(DIR_IMAGEMAGICK . "mogrify -geometry " . $large_width . " " . $filename_large);
            exec(DIR_IMAGEMAGICK . "mogrify -geometry " . $medium_width . " " . $filename_medium);
            exec(DIR_IMAGEMAGICK . "mogrify -geometry " . $small_width . " " . $filename_small);
        }
    }

    zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
}
?>
