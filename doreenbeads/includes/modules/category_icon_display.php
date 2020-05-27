<?php
/**
 * category_icon_display module
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: category_icon_display.php 6104 2007-04-01 14:54:40Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
if ($cPath == '') {
  $cPath= zen_get_product_path((int)$_GET['products_id']);
}
$category_id = get_products_info_memcache((int)$_GET['products_id'] , 'categories_id');
$cPath_new = 'cPath=' . get_category_info_memcache($category_id , 'cPath');
switch(true) {
  case ($module_show_categories=='1'):
  $align='left';
  break;
  case ($module_show_categories=='2'):
  $align='center';
  break;
  case ($module_show_categories=='3'):
  $align='right';
  break;
}

$category_icon_display_name = get_category_info_memcache((int)$current_category_id , 'categories_name');
$category_icon_display_image = get_category_info_memcache((int)$current_category_id , 'categories_image');

switch(true) {
  // name only
  case (PRODUCT_INFO_CATEGORIES_IMAGE_STATUS == 1):
    $category_icon_display_image = '';
    break;
  // name and image but name only when blank
  case (PRODUCT_INFO_CATEGORIES_IMAGE_STATUS == 2 && $category_icon_display_image == ''):
    $category_icon_display_image = '';
    break;
  default:
    // name and image always display image regardless
    $category_icon_display_image = zen_image(DIR_WS_IMAGES . $category_icon_display_image, $category_icon_display_name, CATEGORY_ICON_IMAGE_WIDTH, CATEGORY_ICON_IMAGE_HEIGHT) . '<br />';
    break;
}
//    }
?>