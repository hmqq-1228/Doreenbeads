<?php
/**
 * Module Template
 *
 * Displays content related to "also-like-products"
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_also_like_products.php 3206 2006-03-19 04:04:09Z birdbrain $
 */
  $zc_show_also_like = false;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ALSO_LIKE_PRODUCTS));
?>

<?php if ($zc_show_also_like == true) { ?>
<div class="detail-associated">
<h3>You may also like...</h3>
<?php
  // on 2010-10-18 also_like_products ��ӹ��ﳵͼ��
  echo zen_draw_form('multiple_products_cart_quantity', zen_href_link(FILENAME_PRODUCT_INFO, zen_get_all_get_params(array('action')) . 'action=multiple_products_add_product'), 'post', 'enctype="multipart/form-data" id="also_like_products"');
  //eof 2010-10-18
  require($template->get_template_dir('tpl_quick_browse_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_quick_browse_display.php');
?>
  </form>
</div>
<?php } ?>
