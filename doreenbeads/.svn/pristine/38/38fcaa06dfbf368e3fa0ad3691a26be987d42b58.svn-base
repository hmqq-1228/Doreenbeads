<?php
/**
 * Side Box Template
 * includes/templates/templates_default/sideboxes/tpl_recent.php
 *
 */
  $content = "";
  while(!$recent_products->EOF){

  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent centeredContent">';
  $content .= '<a href="' . zen_href_link('product_info', 'products_id=' . $recent_products->fields["products_id"]) . '"><img alt="' . htmlspecialchars(zen_clean_html($recent_products->fields['products_name'])) . '" title="' . htmlspecialchars(zen_clean_html($recent_products->fields['products_name'])) . '" src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($recent_products->fields['products_image'], 80, 80) . '"></a><br />' . $recent_products->fields['products_name'] . '<br />' ; 
  $content .= '</div>';
  $recent_products->MoveNext();
 }
 ?>