<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_best_sellers.php 2982 2006-02-07 07:56:41Z birdbrain $
 */
  $content = '';
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">' . "\n";
  $content .= '<div class="wrapper">' .  "\n"."<ol>"."\n";
  
  for ($i=1; $i<=sizeof($bestsellers_list); $i++) {
  	$content .= '<li><a href="' . zen_href_link('product_info', 'products_id=' . $bestsellers_list[$i]['id']) . '"><img alt="' . htmlspecialchars(zen_clean_html($bestsellers_list[$i]['name'])) . '" title="' . htmlspecialchars(zen_clean_html($bestsellers_list[$i]['name'])) . '" src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($bestsellers_list[$i]['image'], 80, 80) . '"></a></li>' . "\n";
  }
  $content .= '</ol>';
  $content .= '</div>' . "\n";
  $content .= '</div>';
?>