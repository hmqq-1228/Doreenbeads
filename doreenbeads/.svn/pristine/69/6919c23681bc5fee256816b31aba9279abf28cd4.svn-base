<?php

/**

 * Page Template

 *

 * Loaded automatically by index.php?main_page=account_edit.<br />

 * Displays information related to a single specific order

 *

 * @package templateSystem

 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: tpl_account_history_info_default.php 6524 2007-06-25 21:27:46Z drbyte $

 */

?>

<div class="centerColumn" id="accountHistInfo">
<h2 align="center">Quick Add Products</h2>
<br class="clearBoth" />
<?php echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_ACCOUNT_ADD_MORE_ITEMS, 'action=addconfirm')); ?>
<div style="padding:8px;border:1px solid #9AACBA; color:blue;line-height:135%;"><?php echo TEXT_INVITED_WRITE_REVIEWS; ?></div>
<hr />
<div align="center">
<table border="0" width="30%" cellspacing="0" cellpadding="0" id="prodcutList">
    <tr class="tableHeading">
        <th scope="col">Prod No.</th>
		<th scope="col">Qty.</th>
<?php
  for ($i=0;$i<10; $i++) {
?>
    <tr>
		<td><?php echo zen_draw_input_field('products_id[]','' , 'size="10"'); ?></td>
        <td><?php echo zen_draw_input_field('cart_quantity[]','', 'size="4"'); ?></td>
    </tr>
<?php
  }
?> 
</table>
</div>
<hr />
<div  class="buttonRow back"><?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODCUTS_TO_CART, BUTTON_ADD_PRODUCT_TO_CART,'onclick="return init_addconfirm();"'); ?></div>
</form>
<div align="right"><?php echo zen_image_submit(BUTTON_ADD_MORE_ITEM, BUTTON_ADD_MORE_ITEM,'onclick="return AddAction();"'); ?></div>

<br class="clearBoth" />
<div align="right"><?php echo '<a href="' . zen_href_link(FILENAME_SHOPPING_CART,'SSL') . '">' . zen_image_button(BUTTON_GOTO_SHOPPINGCART, BUTTON_GOTO_SHOPPINGCART)  . '</a>'; ?></div>
</div>