<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: reports_dhtml.php 6027 2007-03-21 09:11:58Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

  $za_contents = array();
  $za_heading = array();
  $za_heading = array('text' => BOX_HEADING_REPORTS, 'link' => zen_href_link(FILENAME_ALT_NAV, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_REPORTS_PRODUCTS_VIEWED, 'link' => zen_href_link(FILENAME_STATS_PRODUCTS_VIEWED, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_REPORTS_PRODUCTS_PURCHASED, 'link' => zen_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_REPORTS_ORDERS_TOTAL, 'link' => zen_href_link(FILENAME_STATS_CUSTOMERS, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_REPORTS_PRODUCTS_LOWSTOCK, 'link' => zen_href_link(FILENAME_STATS_PRODUCTS_LOWSTOCK, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_REPORTS_CUSTOMERS_REFERRALS, 'link' => zen_href_link(FILENAME_STATS_CUSTOMERS_REFERRALS, '', 'NONSSL'));
  //jessa 2010-01-22 add the link of products restock notification 
  $za_contents[] = array('text' => 'Restock Notification', 'link' => zen_href_link(FILENAME_PRODUCTS_RESTOCK_NOTIFY, '', 'NONSSL'));
  //eof jessa 2010-01-22
  
  //jessa 2010-03-30 add the link of Search Statistics
  $za_contents[] = array('text' => 'Search Statistics', 'link' => zen_href_link(FILENAME_SEARCH_STATISTICS, '', 'NONSSL'));
  //eof jessa 2010-03-30

    $za_contents[] = array('text' => '客户注册数统计', 'link' => zen_href_link('customers_register_total', '', 'NONSSL'));

  $za_contents[] = array('text' => '网站平均订单金额统计', 'link' => zen_href_link('order_avg_total', '', 'NONSSL'));

  $za_contents[] = array('text' => '统计订单情况', 'link' => zen_href_link('order_data', '', 'NONSSL'));

  $za_contents[] = array('text' => '导出网站上货信息', 'link' => zen_href_link('download_products_create_date', '', 'NONSSL'));

  $za_contents[] = array('text' => '销售数据导出', 'link' => zen_href_link('sale_date', '', 'NONSSL'));

  $za_contents[] = array('text' => '导出网站所有产品编号', 'link' => zen_href_link('download_products_model', '', 'NONSSL'));
  $za_contents[] = array('text' => '商品销售数据导出', 'link' => zen_href_link('products_sale_data', '', 'NONSSL'));

  $za_contents[] = array('text' => '点击次数统计', 'link' => zen_href_link('count_clicks', '', 'NONSSL'));
  
  $za_contents[] = array('text' => '流失客户数据', 'link' => zen_href_link(FILENAME_CUSTOMERS_LOSS, '', 'NONSSL'));
  $za_contents[] = array('text' => '流失客户Coupon使用效果数据', 'link' => zen_href_link(FILENAME_CUSTOMERS_LOSS_COUPON_USE, '', 'NONSSL'));
  $za_contents[] = array('text' => 'Coupon使用效果统计', 'link' => zen_href_link(FILENAME_CUSTOMERS_COUPON_USE, '', 'NONSSL'));
  $za_contents[] = array('text' => '广告客户订单数据', 'link' => zen_href_link(FILENAME_ADVERTISEMENT_CUSTOMER_ORDER_DATA, '', 'NONSSL'));
  $za_contents[] = array('text' => '满减活动数据', 'link' => zen_href_link(FILENAME_ACTIVITY_FULL_REDUCTION, '', 'NONSSL'));
  $za_contents[] = array('text' => 'Braintree付款金额', 'link' => zen_href_link(FILENAME_BRAINTREE_AMOUNT_OF_PAYMENT, '', 'NONSSL'));
  $za_contents[] = array('text' => '商品动销数据', 'link' => zen_href_link(FILENAME_GOODS_SALES_DATA, '', 'NONSSL'));
if ($za_dir = @dir(DIR_WS_BOXES . 'extra_boxes')) {
  while ($zv_file = $za_dir->read()) {
    if (preg_match('/reports_dhtml.php$/', $zv_file)) {
      require(DIR_WS_BOXES . 'extra_boxes/' . $zv_file);
    }
  }
  $za_dir->close();
}
?>
<!-- reports //-->
<?php
echo zen_draw_admin_box($za_heading, $za_contents);
?>
<!-- reports_eof //-->
