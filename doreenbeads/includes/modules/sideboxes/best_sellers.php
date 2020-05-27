<?php
/**
 * best_sellers sidebox - displays selected number of (usu top ten) best selling products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: best_sellers.php 2718 2005-12-28 06:42:39Z drbyte $
 */

// test if box should display
  $show_best_sellers = false;
  
  if (isset($_SESSION['has_valid_order']) and $_SESSION['has_valid_order']) $show_best_sellers = true;
  if (isset($_GET['products_id'])) $show_best_sellers = false;
  
  if ($show_best_sellers) {
    if (isset($current_category_id) && ($current_category_id > 0)) {
      $best_sellers_query = "select p.products_id, p.products_image,pon.products_order_num from " . TABLE_PRODUCTS . " p, 
								". TABLE_PRODUCTS_TO_CATEGORIES . " p2c,  " . TABLE_CATEGORIES . " c," . TABLE_PRODUCTS_ORDER_NUM . " pon 
								 where p.products_status = '1'
								 and p.products_id = pon.products_id
                                 and p.products_id = p2c.products_id
                                 and p2c.categories_id = c.categories_id
                                 and '" . (int)$current_category_id . "' = c.parent_id
								 group by p2c.products_id 
                                 order by pon.products_order_num desc
                                 limit " . MAX_DISPLAY_BESTSELLERS;
      $best_sellers = $db->Execute($best_sellers_query);
    } else {
      $best_sellers_query = "SELECT p.products_id, p.products_image, pon.products_order_num
							 FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_ORDER_NUM . " pon
							 WHERE p.products_id = pon.products_id
							 AND p.products_status =1
							 ORDER BY pon.products_order_num DESC 
                             limit " . MAX_DISPLAY_BESTSELLERS;
      $best_sellers = $db->Execute($best_sellers_query);
    }

    if ($best_sellers->RecordCount() >= MIN_DISPLAY_BESTSELLERS) {
      $title =  BOX_HEADING_BESTSELLERS;
      $box_id =  'bestsellers';
      $rows = 0;
      while (!$best_sellers->EOF) {
        $rows++;
        $bestsellers_list[$rows]['id'] = $best_sellers->fields['products_id'];
        $bestsellers_list[$rows]['image']  = $best_sellers->fields['products_image'];
        $bestsellers_list[$rows]['name']  = '';
        $best_sellers->MoveNext();
      }

      $title_link = false;
      require($template->get_template_dir('tpl_best_sellers.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_best_sellers.php');
      $title =  BOX_HEADING_BESTSELLERS;
      require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
    }
  }
?>