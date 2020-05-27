<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account.<br />
 * Displays previous orders and options to change various Customer Account settings
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_default.php 4086 2006-08-07 02:06:18Z ajeh $
 */
?>

<div class="centerColumn" id="accountDefault">
<br class="clearBoth" />
<?php echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_ACCOUNT_QUICK_REORDER, 'action=addconfirm')); ?>
<h2 id="orderHistoryDetailedOrder" align="center"><?php echo HEADING_TITLE . ORDER_HEADING_DIVIDER . sprintf(HEADING_ORDER_NUMBER, $_GET['order_id']); ?></h2>
<div class="forward"><?php echo HEADING_ORDER_DATE . ' ' . zen_date_long($order->info['date_purchased']); ?></div>
<br />
<?php echo '<font color="#993366">Please select the item(s) you wanted to reorder, and you could adjust the quantity as you like.</font>'; ?>
<hr />
<div id="show_quick_product">
	<?php
		$show_content = '<table width="100%" border="0" cellspacing="0" cellpadding="0">' . "\n";
		for ($i = 0; $i < sizeof($show_products_content); $i++){
			$show_content .= '	<tr>' . "\n";
			for ($j = 0; $j < sizeof($show_products_content[$i]); $j++){
				$show_content .= '		<td ' . $show_products_content[$i][$j]['params'] . ' valign="middle">' . $show_products_content[$i][$j]['text'] . '</td>' . "\n";
			}
			$show_content .= '	</tr>' . "\n";
		}
		$show_content .= '	</table>' . "\n";
		echo $show_content;
	?>
</div>
<hr />
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	<tr>
	  	  <td style="width:90px; text-align:left;"><?php echo '<a href="javascript:" onclick="return selectall();">' . zen_image_button('button_select_all.jpg') . '</a>'; ?></td>
		  <td style="width:105px; font-weight:bold; text-align:left;"><?php echo '<a href="javascript:" onclick="return unselectall();">' . zen_image_button('button_unselect_all.jpg') . '</a>'; ?></td>
		  <td style="text-align:right;">&nbsp;</td>
		</tr>
</table>
<div><?php echo zen_image_submit(BUTTON_IMAGE_ADD_PRODCUTS_TO_CART, BUTTON_ADD_PRODUCT_TO_CART,'onclick="return init_addconfirm();"');
		  //  '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=addconfirm') . '">' . zen_image_button(BUTTON_IMAGE_ADD_PRODCUTS_TO_CART, BUTTON_ADD_PRODUCT_TO_CART) . '</a>';?></div>
</form>
		  <br class="clearBoth" />
<div class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO,'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_ADD_ADDRESS_ALT) . '</a>'; ?></div>
<div align="right"><?php echo '<a href="' . zen_href_link(FILENAME_SHOPPING_CART,'SSL') . '">' . zen_image_button(BUTTON_GOTO_SHOPPINGCART, BUTTON_GOTO_SHOPPINGCART)  . '</a>'; ?></div>
<br />
<div align="right"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_ADD_MORE_ITEMS) . '">' . zen_image_button(BUTTON_ADD_MORE_ITEM, BUTTON_ADD_MORE_ITEM)  . '</a>'; ?></div>
</div>