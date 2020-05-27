<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: catalog_dhtml.php 6050 2007-03-24 03:20:50Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
  $za_contents = array();
  $za_heading = array('text' => BOX_HEADING_CATALOG, 'link' => zen_href_link(FILENAME_ALT_NAV, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_CATEGORIES_PRODUCTS, 'link' => zen_href_link(FILENAME_CATEGORIES, '', 'NONSSL'));
  $za_contents[] = array('text' => '类别对应关系设置', 'link' => zen_href_link('products_category_setting', '', 'NONSSL'));
  $za_contents[] = array('text' => '商品属性和属性值管理', 'link' => zen_href_link('products_property_manger', '', 'NONSSL'));
  $za_contents[] = array('text' => '调价上浮比例管理', 'link' => zen_href_link('price_manager', '', 'NONSSL'));
  $za_contents[] = array('text' => '自动上货', 'link' => zen_href_link('products_upload', '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_PRODUCT_TYPES, 'link' => zen_href_link(FILENAME_PRODUCT_TYPES, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_PRODUCTS_PRICE_MANAGER, 'link' => zen_href_link(FILENAME_PRODUCTS_PRICE_MANAGER, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_CATEGORIES_OPTIONS_NAME_MANAGER, 'link' => zen_href_link(FILENAME_OPTIONS_NAME_MANAGER, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_CATEGORIES_OPTIONS_VALUES_MANAGER, 'link' => zen_href_link(FILENAME_OPTIONS_VALUES_MANAGER, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_CATEGORIES_ATTRIBUTES_CONTROLLER, 'link' => zen_href_link(FILENAME_ATTRIBUTES_CONTROLLER, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_CATEGORIES_ATTRIBUTES_DOWNLOADS_MANAGER, 'link' => zen_href_link(FILENAME_DOWNLOADS_MANAGER, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_PRODUCT_OPTIONS_NAME, 'link' => zen_href_link(FILENAME_PRODUCTS_OPTIONS_NAME, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_PRODUCT_OPTIONS_VALUES, 'link' => zen_href_link(FILENAME_PRODUCTS_OPTIONS_VALUES, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_MANUFACTURERS, 'link' => zen_href_link(FILENAME_MANUFACTURERS, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_REVIEWS, 'link' => zen_href_link(FILENAME_REVIEWS, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_SPECIALS, 'link' => zen_href_link(FILENAME_SPECIALS, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_FEATURED, 'link' => zen_href_link(FILENAME_FEATURED, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_CLEARANCE_PRODUCTS, 'link' => zen_href_link(FILENAME_CLEARANCE_PRODUCTS, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_SALEMAKER, 'link' => zen_href_link(FILENAME_SALEMAKER, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_PRODUCTS_EXPECTED, 'link' => zen_href_link(FILENAME_PRODUCTS_EXPECTED, '', 'NONSSL'));
  $za_contents[] = array('text' => 'products property values', 'link' => zen_href_link('products_property_values', '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CATALOG_MATCH_PRODUCTS, 'link' => zen_href_link(FILENAME_MATCHING_PRODCUTS_MANAGER, '', 'NONSSL'));
  //eof jessa 2010-02-26  
  $za_contents[] = array('text' => 'Check Products Price', 'link' => zen_href_link('check_products.php', '', 'SSL'));
  $za_contents[] = array('text' => 'Move Products', 'link' => zen_href_link('move_products.php', '', 'NONSSL'));
  $za_contents[] = array('text' => 'Add Info To Description', 'link' => zen_href_link('add_description_info.php', '', 'NONSSL'));
  $za_contents[] = array('text' => '列表排序原则', 'link' => zen_href_link('product_sort_order', '', 'NONSSL'));
  $za_contents[] = array('text' => '不更新库存商品管理', 'link' => zen_href_link('products_s_level', '', 'NONSSL'));
  $za_contents[] = array('text' => '找货/订做信息', 'link' => zen_href_link('oem_sourcing', '', 'NONSSL'));
  $za_contents[] = array('text' => '找货/订做商品', 'link' => zen_href_link('oem_sourcing_products', '', 'NONSSL'));
  $za_contents[] = array('text' => '非饰品商品管理', 'link' => zen_href_link('non_accessories', '', 'NONSSL'));

  
if ($za_dir = @dir(DIR_WS_BOXES . 'extra_boxes')) {
  while ($zv_file = $za_dir->read()) {
    if (preg_match('/catalog_dhtml.php$/', $zv_file)) {
      require(DIR_WS_BOXES . 'extra_boxes/' . $zv_file);
    }
  }
  $za_dir->close();
}

?>
<!-- catalog //-->
<?php
echo zen_draw_admin_box($za_heading, $za_contents);
?>
<!-- catalog_eof //-->
