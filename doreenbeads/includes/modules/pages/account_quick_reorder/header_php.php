<?php
/**
 * Header code file for the Account History Information/Details page (which displays details for a single specific order)
 *
 * @package page
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 2943 2006-02-02 15:56:09Z wilt $
 */
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_ACCOUNT_QUICK_REORDER');
//    ini_set('error_reporting', E_ALL);
//    ini_set('display_errors', 'On');
if (!$_SESSION['customer_id']) {
    $_SESSION['navigation']->set_snapshot();
    zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

if (!isset($_GET['order_id']) || (isset($_GET['order_id']) && !is_numeric($_GET['order_id']))) {
    zen_redirect(zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}

$customer_info_query = "SELECT customers_id
                        FROM   " . TABLE_ORDERS . "
                        WHERE  orders_id = :ordersID";

$customer_info_query = $db->bindVars($customer_info_query, ':ordersID', $_GET['order_id'], 'integer');
$customer_info = $db->Execute($customer_info_query);

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2, zen_href_link(FILENAME_ACCOUNT_QUICK_REORDER, '', 'SSL'));
$breadcrumb->add('Order #'.($_GET['order_id']),zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $_GET['order_id'], 'SSL'));
$breadcrumb->add(sprintf('Quick Reorder'));
require(DIR_WS_CLASSES . 'order.php');
$order = new order($_GET['order_id']);

$orders_products_query = "select op.orders_products_id, op.products_id, op.products_name,
                         op.products_model, op.products_price, op.products_tax,
                         op.products_quantity, op.final_price,
                         op.onetime_charges,
                         op.products_priced_by_attribute, op.product_is_free, op.products_discount_type,
                        op. products_discount_type_from,p.products_image,p.products_weight
                          from " . TABLE_ORDERS_PRODUCTS . " op," . TABLE_PRODUCTS . " p
                          where  p.products_id =  op.products_id
                         and orders_id = '" . $_GET['order_id'] . "'
                          order by orders_products_id";
$orders_products = $db->Execute($orders_products_query);
//�����ʾ������
$row = 0;
$col = 0;
$show_products_content = array();
while(!$orders_products->EOF){
    $products_quantity = $orders_products->fields['products_quantity'];
    $ls_javascript = "chaColor('" . $orders_products->fields['products_id'] . "', 'qty_" . $orders_products->fields['products_id'] . "');";
    $product_status_query = $db->Execute('select products_status from ' . TABLE_PRODUCTS . ' where products_id = ' . $orders_products->fields['products_id']);
    $product_status = $product_status_query->fields['products_status'];
    if ($products_quantity > 0){
        $show_products_content[$row][$col] = array('params' => 'width="20%" style="text-align:center; padding:10px 5px;"',
            'text' => ($product_status ? '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id='
                        . $orders_products->fields['products_id']) . '" target="_blank"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($orders_products->fields['products_image'], 80, 80) . '"></a>' : '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($orders_products->fields['products_image'], 80, 80) . '">') . '<br />' . ($product_status ? '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders_products->fields['products_id'])
                    . '" target="_blank">' . TEXT_MODEL . ':' . $orders_products->fields['products_model'] . '</a>' : '' . TEXT_MODEL . ':' . $orders_products->fields['products_model']) . '<br />'
                . zen_get_products_display_price($orders_products->fields['products_id']) . '<br />' . zen_draw_checkbox_field('add[]', $orders_products->fields['products_id'], false, 'id="' . $orders_products->fields['products_id'] . '"'
                    . ' onclick="' . $ls_javascript . '"')
                . zen_draw_hidden_field('products_id[]', $orders_products->fields['products_id']) . 'Add:' . zen_draw_input_field('cart_quantity[]', $orders_products->fields['products_quantity'] , 'id ="qty_' . $orders_products->fields['products_id'] . '" size="4" style="background-color:#CCCCCC"').'<br />');
        $col++;
    }else{
        $show_products_content[$row][$col] = array('params' => 'width="20%" style="text-align:center; padding:10px 5px;"',
            'text' => ($product_status ? '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id='
                        . $orders_products->fields['products_id']) . '" target="_blank"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($orders_products->fields['products_image'], 80, 80) . '"></a>' : '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($orders_products->fields['products_image'], 80, 80) . '">') . '<br />' . ($product_status ? '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders_products->fields['products_id'])
                    . '" target="_blank">' . TEXT_MODEL . ':' . $orders_products->fields['products_model'] . '</a>' : '' . TEXT_MODEL . ':' . $orders_products->fields['products_model']) . '<br />'
                . zen_get_products_display_price($orders_products->fields['products_id']) . zen_get_buy_now_button_quick_view($orders_products->fields['products_id'], $the_button, $products_link));
        $col++;
    }
    if ($col > 4){
        $col = 0;
        $row++;
    }
    $orders_products->MoveNext();
}
//print_r($_POST);
if (isset($_GET['action']) && $_GET['action'] == 'addconfirm'){
    //�ͻ�Ҫ�����ʷ������Ĳ�Ʒ
    $prod_id_list = '';
    for ($i = 0; $i < sizeof($_POST['add']); $i++){
        $li_products_id = $_POST['add'][$i];
        for ($j = 0; $j < sizeof($_POST['products_id']); $j++){
            if ($li_products_id == $_POST['products_id'][$j]) {
                $li_products_qty = $_POST['cart_quantity'][$j];
                if ($li_products_qty > 0){
                    ////����shopping cart
                    //echo '$products_id:' . $li_products_id .'$qty:' . $li_products_qty . '<br />';
                    $_SESSION['cart']->addselectedtocart($li_products_id,$li_products_qty);
                }
            }
        }

    }
    //die();
    //zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
}

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT_QUICK_REORDER');
?>