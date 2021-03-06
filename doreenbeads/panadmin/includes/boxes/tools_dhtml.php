<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tools_dhtml.php 6027 2007-03-21 09:11:58Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
  $za_contents = array();
  $za_heading = array();
  $za_heading = array('text' => BOX_HEADING_TOOLS, 'link' => zen_href_link(FILENAME_ALT_NAV, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_TEMPLATE_SELECT, 'link' => zen_href_link(FILENAME_TEMPLATE_SELECT, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_LAYOUT_CONTROLLER, 'link' => zen_href_link(FILENAME_LAYOUT_CONTROLLER, '', 'NONSSL'));
// removed broken
//  $za_contents[] = array('text' => BOX_TOOLS_BACKUP, 'link' => zen_href_link(FILENAME_BACKUP, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_BANNER_MANAGER, 'link' => zen_href_link(FILENAME_BANNER_MANAGER, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_MAIL, 'link' => zen_href_link(FILENAME_MAIL, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_NEWSLETTER_MANAGER, 'link' => zen_href_link(FILENAME_NEWSLETTERS, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_SERVER_INFO, 'link' => zen_href_link(FILENAME_SERVER_INFO, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_WHOS_ONLINE, 'link' => zen_href_link(FILENAME_WHOS_ONLINE, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_ADMIN, 'link' => zen_href_link(FILENAME_ADMIN, '', 'NONSSL'));
  $za_contents[] = array('text' => 'Admin Group', 'link' => zen_href_link('admin_group.php', '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_EMAIL_WELCOME, 'link' => zen_href_link(FILENAME_EMAIL_WELCOME, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_STORE_MANAGER, 'link' => zen_href_link(FILENAME_STORE_MANAGER, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_DEVELOPERS_TOOL_KIT, 'link' => zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_EZPAGES, 'link' => zen_href_link(FILENAME_EZPAGES_ADMIN, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_DEFINE_PAGES_EDITOR, 'link' => zen_href_link(FILENAME_DEFINE_PAGES_EDITOR, '', 'NONSSL'));
   $za_contents[] = array('text' => BOX_TOOLS_DEFINE_PRODUCT_UPDATER, 'link' => zen_href_link(FILENAME_PRODUCTS_UPDATER, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_DEFINE_POSTAGE_MANAGE, 'link' => zen_href_link(FILENAME_POSTAGE_DIST_MANA, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_TOOLS_SQLPATCH, 'link' => zen_href_link(FILENAME_SQLPATCH, '', 'NONSSL'));
  $za_contents[] = array('text' => 'Order Exporter for dorabeads', 'link' => zen_href_link('order_exporter.php', '', 'NONSSL'));
    //jessa 2009-12-06 add download product
  $za_contents[] = array('text' => 'Download Product for dorabeads', 'link' => zen_href_link('download_product_csv.php', '', 'NONSSL'));
  //eof jessa 2009-12-06
  
  //jessa 2009-12-23 add download new products every month
  $za_contents[] = array('text' => 'New Products Setting', 'link' => zen_href_link('download_new_products_table.php', '', 'NONSSL'));
  //eof jessa 2009-12-23
  
  //jessa 2010-04-04
  $za_contents[] = array('text' => 'Find New Product Without Catg', 'link' => zen_href_link('find_new_proudcts_without_catg.php', '', 'NONSSL'));
  //eof jessa 2010-04-04

  $za_contents[] = array('text' => 'Promotion Countdown', 'link' => zen_href_link('countdown_setting.php', '', 'NONSSL'));
  
  $za_contents[] = array('text' => '商品图片导出', 'link' => zen_href_link('products_images_export.php', '', 'NONSSL'));
// //light 2010-8-14
  //$za_contents[] = array('text' => 'Refer Site', 'link' => zen_href_link('refer_site.php', '', 'NONSSL'));
//  //eof light 2010-8-14
if ($za_dir = @dir(DIR_WS_BOXES . 'extra_boxes')) {
  while ($zv_file = $za_dir->read()) {
    if (preg_match('/tools_dhtml.php$/', $zv_file)) {
      require(DIR_WS_BOXES . 'extra_boxes/' . $zv_file);
    }
  }
  $za_dir->close();
}

?>
<!-- tools //-->
<?php
echo zen_draw_admin_box($za_heading, $za_contents);
?>
<!-- tools_eof //-->
