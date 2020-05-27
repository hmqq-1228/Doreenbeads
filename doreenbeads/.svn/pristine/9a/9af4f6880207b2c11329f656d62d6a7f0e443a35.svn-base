<?php
/**
 * products_quantity_discounts module
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: products_quantity_discounts.php 6477 2007-06-09 04:38:22Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
//	lvxiaoyong 20150725
if ($_POST['ac'] != 'loadprice' && $_GET['main_page'] != FILENAME_PRODUCTS_COMMON_LIST && $_GET['main_page'] != 'learning_center') {
    include_once(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
}

// if customer authorization is on do not show discounts

$zc_hidden_discounts_on = false;
$zc_hidden_discounts_text = '';
switch (true) {
    case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
        // customer must be logged in to browse
        $zc_hidden_discounts_on = true;
        $zc_hidden_discounts_text = 'MUST LOGIN';
        break;
    case (STORE_STATUS == 1 || CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
        // customer may browse but no prices
        $zc_hidden_discounts_on = true;
        $zc_hidden_discounts_text = TEXT_LOGIN_FOR_PRICE_PRICE;
        break;
    case (CUSTOMERS_APPROVAL == '3' and TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM != ''):
        // customer may browse but no prices
        $zc_hidden_discounts_on = true;
        $zc_hidden_discounts_text = TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM;
        break;
    case (CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and $_SESSION['customer_id'] == ''):
        // customer must be logged in to browse
        $zc_hidden_discounts_on = true;
        $zc_hidden_discounts_text = TEXT_AUTHORIZATION_PENDING_PRICE;
        break;
    case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customers_authorization'] > '0'):
        // customer must be logged in to browse
        $zc_hidden_discounts_on = true;
        $zc_hidden_discounts_text = TEXT_AUTHORIZATION_PENDING_PRICE;
        break;
    default:
        // proceed normally
        break;
}
// create products discount output table

// find out the minimum quantity for this product
$products_min_query = new stdClass();
$products_min_query->fields = get_products_info_memcache((int)$products_id_current);
$products_quantity_order_min = $products_min_query->fields['products_quantity_order_min'];
$ldc_product_price = round($products_min_query->fields['products_price'], 2);

// retrieve the list of discount levels for this product
//WSL
$products_discounts_query = get_products_max_sale_price($products_id_current);

$discount_col_cnt = DISCOUNT_QUANTITY_PRICES_COLUMN;

$display_price = round(zen_get_products_base_price($products_id_current), 2);
//robbie wei change true to false

$display_specials_price = round(zen_get_products_special_price($products_id_current, false), 2);

// set first price value
if ($display_specials_price == false) {
    $show_price = $display_price;
} else {
    $show_price = $display_specials_price;
}

//switch (true) {
//    case ($products_discounts_query['discount_qty'] <= 2):
//        $show_qty = '1';
//        break;
//    case ($products_quantity_order_min == ($products_discounts_query['discount_qty'] - 1) || $products_quantity_order_min == ($products_discounts_query['discount_qty'])):
//        $show_qty = $products_quantity_order_min;
//        break;
//    default:
//        $show_qty = $products_quantity_order_min . '-' . number_format($products_discounts_query['discount_qty'] - 1);
//        break;
//}

if ($display_specials_price == $display_price) {
    $display_specials_price = 0;
}
$disc_cnt = 1;
$quantityDiscounts = array();
$columnCount = 0;

foreach ($products_discounts_query as $key => $value) {
    $$display_pricedisc_cnt++;
    switch ($products_discount_type) {
        // none
        case '0':
            $quantityDiscounts[$columnCount]['discounted_price'] = 0;
            break;
        // percentage discount
        case '1':
            if ($products_discount_type_from == '0') {
                $quantityDiscounts[$columnCount]['discounted_price'] = $display_price - ($display_price * ($value['discount_price'] / 100));
            } else {
                if (!$display_specials_price) {
                    $quantityDiscounts[$columnCount]['discounted_price'] = $display_price - ($display_price * ($value['discount_price'] / 100));
                } else {
                    $quantityDiscounts[$columnCount]['discounted_price'] = $display_specials_price - ($display_specials_price * ($value['discount_price'] / 100));
                }
            }
            break;
        // actual price
        case '2':
            if ($products_discount_type_from == '0') {
                $quantityDiscounts[$columnCount]['discounted_price'] = $value['discount_price'];
            } else {
                $quantityDiscounts[$columnCount]['discounted_price'] = $value['discount_price'];
            }
            break;
        // amount offprice
        case '3':
            if ($products_discount_type_from == '0') {
                $quantityDiscounts[$columnCount]['discounted_price'] = $display_price - $value['discount_price'];
            } else {
                if (!$display_specials_price) {
                    $quantityDiscounts[$columnCount]['discounted_price'] = $display_price - $value['discount_price'];
                } else {
                    $quantityDiscounts[$columnCount]['discounted_price'] = $display_specials_price - $value['discount_price'];
                }
            }
            break;
    }

    $quantityDiscounts[$columnCount]['show_qty'] = number_format($value['discount_qty']);

    if (!isset($products_discounts_query[$key + 1])) {
        $quantityDiscounts[$columnCount]['show_qty'] .= '+';
    } else {
//        if (($value['discount_qty'] - 1) != $show_qty) {
            if ($quantityDiscounts[$columnCount]['show_qty'] < $products_discounts_query[$key + 1]['discount_qty'] - 1) {
                if($columnCount == 0 && $products_quantity_order_min > $quantityDiscounts[$columnCount]['show_qty'] && $products_quantity_order_min < $products_discounts_query[$key + 1]['discount_qty']){
                    if($products_quantity_order_min == ($products_discounts_query[$key + 1]['discount_qty'] - 1)){
                        $quantityDiscounts[$columnCount]['show_qty'] = $products_quantity_order_min ;
                    }else{
                        $quantityDiscounts[$columnCount]['show_qty'] = $products_quantity_order_min . '-' . number_format($products_discounts_query[$key + 1]['discount_qty'] - 1);
                    }

                }else{
                    $quantityDiscounts[$columnCount]['show_qty'] .= '-' . number_format($products_discounts_query[$key + 1]['discount_qty'] - 1);
                }

            }
//        }
    }
    //$value->MoveNext();
    $disc_cnt = 0;
    $columnCount++;
}
if (!zen_not_null($quantityDiscounts)) {
    $quantityDiscounts[0]['discounted_price'] = round($display_price, 2);
}
?>