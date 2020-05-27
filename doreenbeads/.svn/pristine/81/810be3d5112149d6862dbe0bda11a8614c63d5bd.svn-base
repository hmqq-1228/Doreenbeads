<?php
/**�����ļ� jessa
 * tpl_matching_products_default.php
 *
 * @package modules
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @version $Id: matching_products.php 5369 2010-02-25
 */
 
 include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MATCHING_PRODCUTS));

?>

<?php
 if ($zc_show_matching_products == true){
?>
<div class="detail-associated">
<h3>You may also like...</h3>
 <?php
  //on 2010-10-18  ƥ���Ʒ��Ӳ�Ʒ�����ﳵ
  echo zen_draw_form('multiple_products_cart_quantity', zen_href_link(FILENAME_PRODUCT_INFO, zen_get_all_get_params(array('action')) . 'action=multiple_products_add_product'), 'post', 'enctype="multipart/form-data" id="matching_product" ');
  // eof on 2010-10-18
  require($template->get_template_dir('tpl_quick_browse_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_quick_browse_display.php');
 ?>
     </form>
</div>
 <?php } ?>