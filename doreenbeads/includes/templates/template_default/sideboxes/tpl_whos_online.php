<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_whos_online.php 2982 2006-02-07 07:56:41Z birdbrain $
 */
  $content = '';
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent centeredContent">';
  for ($i=0; $i<sizeof($whos_online); $i++) {
    $content .= $whos_online[$i];
  }
  $content .= '</div>';
  $content .= '';
?>
<div class="rightBoxContainer" id="email_order" style="width:<?php echo BOX_WIDTH_RIGHT; ?>; text-align:center; padding:10px 0px;">
<a href="<?php echo zen_href_link(FILENAME_EZPAGES, 'id=97'); ?>"><img src="includes/templates/cherry_zen/images/email_order.jpg"></a>
</div>