<?php
/**
 * information sidebox - displays list of general info links, as defined in this file
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: information.php 4132 2006-08-14 00:36:39Z drbyte $
 */

  unset($information);
   
  $information[] = '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . 'index.php?main_page=page&id=21">FAQ</a>';
  //jessa 2010-03-31 add the following code
  
  //jessa 2010-04-22 add the latest news
  $information[] = '<a href="' . zen_href_link(FILENAME_EZPAGES, 'id=64') . '">Latest News</a>';
  //eof jessa 2010-04-22
  
  $information[] = '<a href="' . zen_href_link(FILENAME_EZPAGES, 'id=52') . '">Quality Control</a>';
  //eof jessa 2010-03-31
  
  //jessa 2010-04-01 add the following code
  $information[] = '<a href="' . zen_href_link(FILENAME_EZPAGES, 'id=54') . '">Shopping Guide</a>';
  //eof jessa 2010-04-01
  
  //jessa 2010-04-18 add the New Products(Updated)
  $information[] = '<a href="' . zen_href_link(FILENAME_EZPAGES, 'id=63') . '"><span style="color:red;">New</span> Product(Updated)</a>';
  //eof jessa 2010-04-18
  
  $information[] = '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . 'index.php?main_page=page&id=15">Payment Method</a>';
  if (DEFINE_SHIPPINGINFO_STATUS <= 1) {
    $information[] = '<a href="' . zen_href_link(FILENAME_SHIPPING) . '">' . BOX_INFORMATION_SHIPPING . '</a>';
  }
   
////jessa 2010-04-13 删除这里的链接，放在下面的导航上
//  if (DEFINE_PRIVACY_STATUS <= 1) {
//    $information[] = '<a href="' . zen_href_link(FILENAME_PRIVACY) . '">' . BOX_INFORMATION_PRIVACY . '</a>';
//  }

////jessa 2010-04-15 add shipping calculator
//$information[] = '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . 'index.php?main_page=shipping_calculator">Shipping Calculator</a>';
////eof jessa 2010-04-15
  
/*jessa 2009-09-08 在information里增加下面的内容*/
   $information[] = '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . 'index.php?main_page=page&id=16">How to Order</a>';
/*eof jessa 2009-09-08*/

   //$information[] = '<a href="' . zen_href_link(FILENAME_EZPAGES, 'id=69') . '">Picture Authorization</a>';

// Forum (phpBB) link:
  if ( (isset($phpBB->phpBB['db_installed_config']) && $phpBB->phpBB['db_installed_config']) && (isset($phpBB->phpBB['files_installed']) && $phpBB->phpBB['files_installed'])  && (PHPBB_LINKS_ENABLED=='true')) {
    $information[] = '<a href="' . zen_href_link($phpBB->phpBB['phpbb_url'] . FILENAME_BB_INDEX, '', 'NONSSL', false, '', true) . '" target="_blank">' . BOX_BBINDEX . '</a>';
// or: $phpBB->phpBB['phpbb_url'] . FILENAME_BB_INDEX
// or: str_replace(str_replace(DIR_WS_CATALOG, '', DIR_FS_CATALOG), '', DIR_WS_PHPBB)
  }

/*jessa 2009-09-08 删除information中sitemap内容*/
/*
if (DEFINE_SITE_MAP_STATUS <= 1) {
    $information[] = '<a href="' . zen_href_link(FILENAME_SITE_MAP) . '">' . BOX_INFORMATION_SITE_MAP . '</a>';
  }
*/
/*eof jessa 2009-09-08*/

  // only show GV FAQ when installed
  //jessa 2009-08-09
  //delete the following code between /* and */
/*
 if (MODULE_ORDER_TOTAL_GV_STATUS == 'true') {
    $information[] = '<a href="' . zen_href_link(FILENAME_GV_FAQ) . '">' . BOX_INFORMATION_GV . '</a>';
  }
  // only show Discount Coupon FAQ when installed
  if (DEFINE_DISCOUNT_COUPON_STATUS <= 1 && MODULE_ORDER_TOTAL_COUPON_STATUS == 'true') {
    $information[] = '<a href="' . zen_href_link(FILENAME_DISCOUNT_COUPON) . '">' . BOX_INFORMATION_DISCOUNT_COUPONS . '</a>';
  }

  if (SHOW_NEWSLETTER_UNSUBSCRIBE_LINK == 'true') {
    $information[] = '<a href="' . zen_href_link(FILENAME_UNSUBSCRIBE) . '">' . BOX_INFORMATION_UNSUBSCRIBE . '</a>';
  }
*/
//eof jessa
  require($template->get_template_dir('tpl_information.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_information.php');

  $title =  BOX_HEADING_INFORMATION;
  $title_link = false;

  require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
?>
