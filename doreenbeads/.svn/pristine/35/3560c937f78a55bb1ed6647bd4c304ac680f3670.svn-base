<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$za_contents = array();
$za_heading = array();
$za_heading = array('text' => '营销功能设置', 'link' => zen_href_link(FILENAME_ALT_NAV, '', 'NONSSL'));
//$za_contents[] = array('text' => 'Home-Page Promotion', 'link' => zen_href_link('promotion', '', 'NONSSL'));
$za_contents[] = array('text' => '商品专区设置', 'link' => zen_href_link(FILENAME_SUBJECT_PRODUCT_AREA, '', 'NONSSL'));
$za_contents[] = array('text' => '一口价DEALS设置', 'link' => zen_href_link(FILENAME_DEALS_LIST, '', 'NONSSL')); 
$za_contents[] = array('text' => '促销折扣区设置', 'link' => zen_href_link(FILENAME_PROMOTION_LIST, '', 'NONSSL'));
$za_contents[] = array('text' => '促销区设置', 'link' => zen_href_link(FILENAME_PROMOTION_AREA, '', 'NONSSL'));
$za_contents[] = array('text' => '营销URL获取', 'link' => zen_href_link(FILENAME_MARKETING_URL, '', 'NONSSL'));
$za_contents[] = array('text' => '移除促销产品', 'link' => zen_href_link(FILENAME_REMOVE_PROMOTION_PRODUCTS, '', 'NONSSL'));
$za_contents[] = array('text' => 'Coupon管理', 'link' => zen_href_link(FILENAME_COUPON_MANAGE, '', 'NONSSL'));
$za_contents[] = array('text' => 'Coupon发送列表&发送', 'link' => zen_href_link(FILENAME_COUPON_SEND, '', 'NONSSL'));
$za_contents[] = array('text' => '促销活动展示专区', 'link' => zen_href_link('promotion_display_area', '', 'NONSSL'));

//$za_contents[] = array('text' => 'Add New Promotion', 'link' => zen_href_link(FILENAME_PROMOTION_LIST, 'action=add', 'NONSSL'));

if (sizeof($za_contents)){
	echo zen_draw_admin_box($za_heading, $za_contents);
}
?>