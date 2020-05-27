<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_reviews_random.php 2982 2006-02-07 07:56:41Z birdbrain $
 */
  $content = "";
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent centeredContent">';
   $content .= //'<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_review_sidebox_product->fields['products_id'] . '&reviews_id=' . $random_review_sidebox_product->fields['reviews_id']) . '">' 
  			  '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . $random_review_sidebox_product->fields['products_id'] . '&reviews_id=' . $random_review_sidebox_product->fields['reviews_id']) . '"><img alt="' . htmlspecialchars(zen_clean_html($random_review_sidebox_product->fields['products_name'])) . '" title="' . htmlspecialchars(zen_clean_html($random_review_sidebox_product->fields['products_name'])) . '" src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($random_review_sidebox_product->fields['products_image'], 80, 80) . '"><br />' . $review_box_text . ' ..</a><br /><br />' . zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $random_review_sidebox_product->fields['reviews_rating'] . '.gif' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $random_review_sidebox_product->fields['reviews_rating']))
  			  . '<br /><br /><a href="' .  zen_href_link(FILENAME_REVIEWS) . '"><img src="includes/templates/cherry_zen/buttons/english/button_more_reviews.gif"></a><br /><br />';
  $content .= '</div>';
?>