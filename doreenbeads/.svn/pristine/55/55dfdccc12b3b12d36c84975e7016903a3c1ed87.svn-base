<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_notifications.<br />
 * Allows customer to manage product notifications
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_notifications_default.php 3206 2006-03-19 04:04:09Z birdbrain $
 */
?>
<div class="centerColumn" id="accountNotifications">
<?php echo zen_draw_form('account_notifications', zen_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); ?>

<p class="ordertit"><strong><?php echo HEADING_TITLE; ?></strong>
	<span class="updatedis">
          	<?php if ($messageStack->size('account') > 0) {
          				echo SUCCESS_NOTIFICATIONS_UPDATED;
          		  }
          ?>
          </span>
</p>

<div class="notice"><?php echo MY_NOTIFICATIONS_DESCRIPTION; ?></div>

<?php
  if ($flag_global_notifications != '1') {
?>

<?php
    if ($flag_products_check) {
?>
<div class="notices"><?php echo NOTIFICATIONS_DESCRIPTION; ?></div>
<?php
/**
 * Used to loop thru and display product notifications
 */
  foreach ($notificationsArray as $notifications) { 
  	$products_info = $db->Execute("Select products_image

								From " . TABLE_PRODUCTS . 

								" Where products_id = " . $notifications['products_id']);
//	$productsImage = zen_image(DIR_WS_IMAGES . $products_info->fields['products_image'], $notifications['products_name'], IMAGE_SHOPPING_CART_WIDTH, IMAGE_SHOPPING_CART_HEIGHT);
	$productsImage = zen_image(HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_info->fields['products_image'], 80, 80), $notifications['products_name'], 80, 80);
	
	echo zen_draw_checkbox_field('notify[]', $notifications['products_id'], true, 'id="notify-' . $notifications['counter'] . '"'); 
	$linkProductsImage = zen_href_link('product_info', 'products_id=' . $notifications['products_id']);

?>
<a href="<?php echo $linkProductsImage; ?>"  target="_blank">

	<label class="checkboxLabel"><?php echo $productsImage; ?></label>

	<label class="checkboxLabel"><?php echo $notifications['products_name']; ?></label>

</a>

<br class="clearBoth"/>

<?php
  }
?>
<p class="filterbtn back"><button><?php echo BUTTON_UPDATE_ALT;?></button><p>
<?php
    } else {
?>
<div class="notices"><?php echo NOTIFICATIONS_NON_EXISTING; ?></div>
</fieldset>

<?php
    }
?>

<?php
  }
?>

</form>    
</div>
