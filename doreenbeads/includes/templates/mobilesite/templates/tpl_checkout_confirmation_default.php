<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_confirmation.<br />
 * Displays final checkout details, cart, payment and shipping info details.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_confirmation_default.php 6524 2007-06-25 21:27:46Z drbyte $
 */
?>
<div class="centerColumn" id="checkoutConfirmDefault">

<h1 id="checkoutConfirmDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

<?php 
	if (isset($_SESSION['payment']) && $_SESSION['payment'] == 'westernunion'){
?>
<h1 align="center" style="color:red;"><?php echo TEXT_PAYMENT_WESTERNUNINON ;?></h1>
<?php } ?>

<!-- bof Order Steps (tableless) -->
<?php echo ORDER_REVIEW; ?>
 <?php if($_SESSION['languages_id']==1){?>
    <div id="order_steps">
            <div class="order_steps_text">
			<span class="order_steps_text2"><?php echo TEXT_ORDER_STEPS_1; ?></span><span class="order_steps_text3"><?php echo TEXT_ORDER_STEPS_2; ?></span><span id="active_step_text"><?php echo  zen_image(DIR_WS_TEMPLATE_IMAGES.ORDER_STEPS_IMAGE, ORDER_STEPS_IMAGE_ALT); ?><br /><?php echo TEXT_ORDER_STEPS_3; ?></span><span class="order_steps_text4"><?php echo TEXT_ORDER_STEPS_4; ?></span>
            </div>
            <div class="order_steps_line_2">
                <span class="progressbar_active">&nbsp;</span><span class="progressbar_active">&nbsp;</span><span class="progressbar_active">&nbsp;</span><span class="progressbar_inactive">&nbsp;</span>
            </div>
    </div>
    <?php }else{?>
        <table border=0 cellspacing=0 cellpadding=0 width="100%" id="order_steps_text_tb">
    <tr id="order_steps_text_tr_top">
    <td><?php echo TEXT_ORDER_STEPS_1; ?></td>
    <td><?php echo TEXT_ORDER_STEPS_2; ?></td>
    <td id="active_step_text_td"><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.ORDER_STEPS_IMAGE, ORDER_STEPS_IMAGE_ALT); ?><br /><?php echo TEXT_ORDER_STEPS_3; ?></td>
    <td><?php echo TEXT_ORDER_STEPS_4; ?></td>
    </tr>
    <tr id="order_steps_text_tr_below">
    <td><div class='progressbar_active_tr'></div></td><td><div class='progressbar_active_tr'></div></td><td><div class='progressbar_active_tr'></div></td><td><div></div></td>
    </tr>
    </table>
    <?php }?>
<!-- eof Order Steps (tableless) -->

<?php if ($messageStack->size('redemptions') > 0) echo $messageStack->output('redemptions'); ?>
<?php if ($messageStack->size('checkout_confirmation') > 0) echo $messageStack->output('checkout_confirmation'); ?>
<?php if ($messageStack->size('checkout') > 0) echo $messageStack->output('checkout'); ?>

<div id="check_shipping">
<?php
////deal the paypal error
////paypal_offline_robbie wei 2008-10-29
////If payment method is paypal error, do not display billing address part
////bof

if ($_POST['payment'] == 'cod') {
	$payment = 'paypalmanually';
}
if ($payment != 'paypalmanually') { ?>
<?php
/* ɾ��billing address
<h2 id="checkoutConfirmDefaultBillingAddress"><?php echo HEADING_BILLING_ADDRESS; ?></h2>
<?php if (!$flagDisablePaymentAddressChange) { ?>
<div class="buttonRow forward"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT) . '</a>'; ?></div>
<?php } ?>

<address><?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?></address>
*/
?>
<?php
  $class =& $_SESSION['payment'];
?>

<h3 id="checkoutConfirmDefaultPayment"><?php echo HEADING_PAYMENT_METHOD; ?></h3> 
<h4 id="checkoutConfirmDefaultPaymentTitle"><?php echo $GLOBALS[$class]->title; ?></h4>
<?php
	}
else{
	?>
<p class="important"><font color="red">
	<?php echo TEXT_HIT_CONFIRM_ORDER;?> </font></p>
<?php
}
////eof robbie_wei
?>

<?php
  if (is_array($payment_modules->modules)) {
    if ($confirmation = $payment_modules->confirmation()) {
?>
<div class="important"><?php echo $confirmation['title']; ?></div>
<?php
    }
?>
<div class="important">
<?php
      for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {
?>
<div class="back"><?php echo $confirmation['fields'][$i]['title']; ?></div>
<div ><?php echo $confirmation['fields'][$i]['field']; ?></div>
<?php
     }
?>
      </div>
<?php
  }
?>

<br class="clearBoth" />
</div>

<?php
  if ($_SESSION['sendto'] != false) {
?>
<hr>
<div id="checkoutShipto" class="forward">
<br/>
<h2 id="checkoutConfirmDefaultShippingAddress"><?php echo HEADING_DELIVERY_ADDRESS; ?></h2>
<div class="buttonRow forward"><?php echo '<a href="' . $editShippingButtonLink . '">' . zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT) . '</a>'; ?></div>

<address><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); ?></address>
<?php echo '<br />'.TEXT_IMPORTANT_NOTES.' <br /><br />'; ?>
<?php
    if ($order->info['shipping_method']) {
?>
<h3 id="checkoutConfirmDefaultShipment"><?php echo HEADING_SHIPPING_METHOD; ?></h3>
<h4 id="checkoutConfirmDefaultShipmentTitle"><?php echo $order->info['shipping_method']; ?></h4>

<?php
    }
?>
</div>
<?php
  }
?>
<br class="clearBoth" />
<hr />
<?php
// always show comments
//  if ($order->info['comments']) {
?>

<h2 id="checkoutConfirmDefaultHeadingComments"><?php echo HEADING_ORDER_COMMENTS; ?></h2>
<div class="buttonRow forward"><?php echo  '<a href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT) . '</a>'; ?></div>
<div><?php echo (empty($order->info['comments']) ? NO_COMMENTS_TEXT : nl2br(zen_output_string_protected($order->info['comments'])) . zen_draw_hidden_field('comments', $order->info['comments'])); ?></div>
<br class="clearBoth" />
<?php
//  }
?>
<hr />

<h2 id="checkoutConfirmDefaultHeadingCart"><?php echo HEADING_PRODUCTS; ?></h2>

<div class="buttonRow forward"><?php echo '<a href="' . zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT) . '</a>'; ?></div>
<br class="clearBoth" />

<?php  if ($flagAnyOutOfStock) { ?>
<?php    if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>
<div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
<?php    } else { ?>
<div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>
<?php    } //endif STOCK_ALLOW_CHECKOUT ?>
<?php  } //endif flagAnyOutOfStock ?>


      <table border="0" width="100%" cellspacing="0" cellpadding="0" id="cartContentsDisplay">
        <tr class="cartTableHeading">
        <th scope="col" id="ccQuantityHeading" width="30"><?php echo TABLE_HEADING_QUANTITY; ?></th>
        <th scope="col" id="ccProductsHeading"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
<?php
  // If there are tax groups, display the tax columns for price breakdown
  if (sizeof($order->info['tax_groups']) > 1) {
?>
          <th scope="col" id="ccTaxHeading"><?php echo HEADING_TAX; ?></th>
<?php
  }
?>
		  <th scope="col" id="ccTotalHeading"><?php echo TEXT_MODEL;?></th>
          <th scope="col" id="ccTotalHeading"><?php echo TABLE_HEADING_TOTAL; ?></th>
        </tr>
<?php // now loop thru all products to display quantity and price ?>
<?php for ($i=0, $n=sizeof($order->products); $i<$n; $i++) { ?>
        <tr class="<?php echo $order->products[$i]['rowClass']; ?>">
          <td  class="cartQuantity"><?php echo $order->products[$i]['qty']; ?>&nbsp;x</td>
          <td class="cartProductDisplay"><?php echo $order->products[$i]['name']; ?>
          <?php  echo $stock_check[$i]; ?>

<?php // if there are attributes, loop thru them and display one per line
    if (isset($order->products[$i]['attributes']) && sizeof($order->products[$i]['attributes']) > 0 ) {
    echo '<ul class="cartAttribsList">';
      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
?>
      <li><?php echo $order->products[$i]['attributes'][$j]['option'] . ': ' . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])); ?></li>
<?php
      } // end loop
      echo '</ul>';
    } // endif attribute-info
?>
        </td>

<?php // display tax info if exists ?>
<?php if (sizeof($order->info['tax_groups']) > 1)  { ?>
        <td class="cartTotalDisplay">
          <?php echo zen_display_tax_value($order->products[$i]['tax']); ?>%</td>
<?php    }  // endif tax info display  ?>
		<td class="cartProductDisplay" align="center"><?php echo $order->products[$i]['model']; ?></td>
        <td class="cartTotalDisplay">
          <?php echo $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']);
          if ($order->products[$i]['onetime_charges'] != 0 ) echo '<br /> ' . $currencies->display_price($order->products[$i]['onetime_charges'], $order->products[$i]['tax'], 1);
?>
        </td>
      </tr>
<?php  }  // end for loopthru all products ?>
      </table>
      <hr />

<?php
  if (MODULE_ORDER_TOTAL_INSTALLED) {
    $order_totals = $order_total_modules->process();
?>
<div id="orderTotals"><?php $order_total_modules->output(); ?></div>
<?php
  }
?>

<?php
  echo zen_draw_form('checkout_confirmation', $form_action_url, 'post', 'id="checkout_confirmation" onsubmit="return submitonce();"');

  if (is_array($payment_modules->modules)) {
    echo $payment_modules->process_button();
  }
?>
<div class='preorder_packing_choose'>
<p><b class='noticered'>*</b> <?php echo TEXT_REORDER_PACKING_TIPS;?></p>
<span class='packingLeft'><?php echo TEXT_PACKING;?></span>
<span class='packingRadio'>
<p><input type='radio' name='packingway'  value='1'> <?php echo TEXT_REORDER_PACKING_WAY_ONE;?></p>
<p><input type='radio' name='packingway' value='2'> <?php echo TEXT_REORDER_PACKING_WAY_TWO;?></p>
<div class='extra_tips'>
( <font><?php echo TEXT_EXTRA_TIPS;?></font> )
<dl>
<dt></dt>
<dd><?php echo TEXT_EXTAR_SHIPPING_FEE;?></dd>
</dl>
</div>
<p class='error_packing_info'><?php echo TEXT_ERROR_PACKING_TIPS;?></p>
</span>
</div>
<div style="clear:both;"><div style="float:left; width:35%;"><?php echo '<a href=" '.HTTP_SERVER .(($_SESSION['languages_id']==1)?'':'/'.$_SESSION['languages_code']).'/'. '">'.zen_image_button('button_return_to_shopping.gif').'</a>'; ?></div><div style="float:right; widows:35%;"><?php echo zen_image_submit(BUTTON_IMAGE_CONFIRM_ORDER, BUTTON_CONFIRM_ORDER_ALT, 'name="btn_submit" id="btn_submit"') ;?></div></div>
</form>
<div style="clear:both;"><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>

</div>