<?php
/**
 * create the breadcrumb trail
 * see {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
 * @package initSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_add_crumbs.php 6948 2007-09-02 23:30:49Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$breadcrumb->add(HEADER_TITLE_CATALOG, zen_href_link(FILENAME_DEFAULT));
/**
 * add category names or the manufacturer name to the breadcrumb trail
 */
// might need isset($_GET['cPath']) later ... right now need $cPath or breaks breadcrumb from sidebox etc.
if ($_GET['main_page'] == 'products_common_list' && $_GET['pn'] == 'similar') {
}else{
  if (isset($cPath_array) && isset($cPath)) {
    for ($i=0, $n=sizeof($cPath_array); $i<$n; $i++) {
     /*  $categories_query = "select categories_name
                             from " . TABLE_CATEGORIES_DESCRIPTION . "
                             where categories_id = '" . (int)$cPath_array[$i] . "'
                             and language_id = '" . (int)$_SESSION['languages_id'] . "'";

      $categories = $db->Execute($categories_query); */
    	$categories = get_category_info_memcache((int)$cPath_array[$i], 'detail', (int)$_SESSION['languages_id']);
  //echo 'I SEE ' . (int)$cPath_array[$i] . '<br>';
      if (isset($categories['categories_name']) && $categories['categories_name'] != '') {
        $breadcrumb->add($categories['categories_name'], zen_href_link(FILENAME_DEFAULT, 'cPath=' . implode('_', array_slice($cPath_array, 0, ($i+1)))));
      } else {
        // if invalid, set the robots noindex/nofollow for this page
        $robotsNoIndex = true;
        break;
      }
    }
  }
}
/**
 * add get terms (e.g manufacturer, music genre, record company or other user defined selector) to breadcrumb
 */
$sql = "select *
		from " . TABLE_GET_TERMS_TO_FILTER;
$get_terms = $db->execute($sql);
while (!$get_terms->EOF) {
	if (isset($_GET[$get_terms->fields['get_term_name']])) {
		$sql = "select " . $get_terms->fields['get_term_name_field'] . "
		        from " . constant($get_terms->fields['get_term_table']) . "
		        where " . $get_terms->fields['get_term_name'] . " =  " . (int)$_GET[$get_terms->fields['get_term_name']];
		$get_term_breadcrumb = $db->execute($sql);
    if ($get_term_breadcrumb->RecordCount() > 0) {
      $breadcrumb->add($get_term_breadcrumb->fields[$get_terms->fields['get_term_name_field']], zen_href_link(FILENAME_DEFAULT, $get_terms->fields['get_term_name'] . "=" . $_GET[$get_terms->fields['get_term_name']]));
    }
	}
	$get_terms->movenext();
}
/**
 * add the products model to the breadcrumb trail
 */
if (isset($_GET['products_id'])) {
/*   $productmodel_query = "select products_model
                   from " . TABLE_PRODUCTS . "
                   where products_id = '" . (int)$_GET['products_id'] . "'";

  $productmodel = $db->Execute($productmodel_query); */
  $productInfo = get_products_info_memcache($_GET['products_id']); 
  if ($productInfo['products_model'] != '') {
    if (!($productInfo['products_status'] != 1 && $_GET['main_page'] == 'products_common_list' && $_GET['pn'] == 'similar')) {
      $breadcrumb->add( $productInfo['products_model'], zen_href_link('product_info', '&products_id=' . $_GET['products_id']) );
    }
  }
}
?>