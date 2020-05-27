<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: customers_dhtml.php 6027 2007-03-21 09:11:58Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
  $za_contents = array();
  $za_heading = array();
  $za_heading = array('text' => BOX_HEADING_CUSTOMERS, 'link' => zen_href_link(FILENAME_ALT_NAV, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CUSTOMERS_CUSTOMERS, 'link' => zen_href_link(FILENAME_CUSTOMERS, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CUSTOMERS_ORDERS, 'link' => zen_href_link(FILENAME_ORDERS, '', 'NONSSL'));
  $za_contents[] = array('text' => '特殊VIP管理', 'link' => zen_href_link(FILENAME_CHANNEL, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CUSTOMERS_GROUP_PRICING, 'link' => zen_href_link(FILENAME_GROUP_PRICING, '', 'NONSSL'));

    $za_contents[] = array('text' => '允许GC付款的客户管理', 'link' => zen_href_link('customers_gc', '', 'NONSSL'));

    $za_contents[] = array('text' => '默认不显示GC支付方式国家管理', 'link' => zen_href_link('customers_gc_country', '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CUSTOMERS_PAYPAL, 'link' => zen_href_link(FILENAME_PAYPAL, '', 'NONSSL'));
  //jessa 2009-12-28 ���ӹ˿����չ���
  $za_contents[] = array('text' => BOX_CUSTOMERS_BIRTHDAY, 'link' => zen_href_link(FILENAME_BIRTHDAY, '', 'NONSSL'));
  //eof jessa 2009-12-28
  
  $za_contents[] = array('text' => 'Feedback Manage', 'link' => zen_href_link(FILENAME_FEEDBACK_MANAGE, '', 'NONSSL'));
  
  
  $za_contents[] = array('text' => 'Credit Account Manage', 'link' => zen_href_link(FILENAME_CASH_ACCOUNT, '', 'NONSSL'));
  //EOF
  $za_contents[] = array('text' => 'Declared Orders Manage', 'link' => zen_href_link(FILENAME_DECLARE_ORDERS, '', 'NONSSL'));
  
  $za_contents[] = array('text' => 'Customers without Order', 'link' => zen_href_link(FILENAME_CUSTOMERS_NO_ORDER, '', 'NONSSL'));

  $za_contents[] = array('text' => 'Remote Address Manage', 'link' => zen_href_link(FILENAME_ADDRESS_BOOK, '', 'NONSSL'));

  $za_contents[] = array('text' => '客户购物车物品', 'link' => zen_href_link(FILENAME_SHOPPING_CART1, '', 'NONSSL'));
  
  $za_contents[] = array('text' => 'Customer Question', 'link' => zen_href_link(FILENAME_CUSTOMER_QUESTION, '', 'NONSSL'));

  $za_contents[] = array('text' => 'Avatar Manager', 'link' => zen_href_link("avatar_manage", '', 'NONSSL'));
  
  $za_contents[] = array('text' => '重置客户密码', 'link' => zen_href_link(FILENAME_RESET_PASSWORD, '', 'NONSSL'));

  $za_contents[] = array('text' => '获取公共密码授权码', 'link' => zen_href_link(FILENAME_AUTH_CODE, '', 'NONSSL'));

  $za_contents[] = array('text' => '客户邮箱更换记录管理', 'link' => zen_href_link(FILENAME_CUSTOMERS_EMAIL_CHANGE, '', 'NONSSL'));
  
  $za_contents[] = array('text' => '客户邮箱合并', 'link' => zen_href_link(FILENAME_CUSTOMERS_EMAIL_MERGE, '', 'NONSSL'));
  
  $za_contents[] = array('text' => '客户店铺信息', 'link' => zen_href_link(FILENAME_CUSTOMERS_BUSINESS_WEB_INFO, '', 'NONSSL'));

  $za_contents[] = array('text' => '客户邮箱转换', 'link' => zen_href_link(FILENAME_CUSTOMERS_CLIENT_MAILBOX_CONVERSION, '', 'NONSSL'));
  
if ($za_dir = @dir(DIR_WS_BOXES . 'extra_boxes')) {
  while ($zv_file = $za_dir->read()) {
    if (preg_match('/customers_dhtml.php$/', $zv_file)) {
      require(DIR_WS_BOXES . 'extra_boxes/' . $zv_file);
    }
  }
  $za_dir->close();
}

?>

<!-- customers //-->
<?php
echo zen_draw_admin_box($za_heading, $za_contents);
?>
<!-- customers_eof //-->
