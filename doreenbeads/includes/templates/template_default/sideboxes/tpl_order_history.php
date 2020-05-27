<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_order_history.php 4224 2006-08-24 01:41:50Z drbyte $
 */
  $content = "";
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent"  style="text-align:center">' . "\n";
  //$content .= '<ul class="orderHistList">' . "\n" ;

  for ($i=1; $i<=sizeof($customer_orders); $i++) {
        $content .= '<div style="padding:5px"><a href="' . zen_href_link('product_info', 'products_id=' . $customer_orders[$i]['id']) . '"><img alt="' . htmlspecialchars(zen_clean_html($customer_orders[$i]['name'])) . '" title="' . htmlspecialchars(zen_clean_html($customer_orders[$i]['name'])) . '" src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($customer_orders[$i]['image'], 80, 80) . '"></a><br /><a href="' . zen_href_link('product_info', 'products_id=' . $customer_orders[$i]['id']) . '"><span style="display:block;text-align:left">' . $customer_orders[$i]['name'] . '</span></a>' . zen_get_products_display_price($customer_orders[$i]['id']) . '</div>' . "\n";
		
  }
  //$content .= '</ul>' . "\n" ;
  $content .= '</div>';
?>