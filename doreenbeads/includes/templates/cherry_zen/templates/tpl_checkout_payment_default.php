<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_payment.<br />
 * Displays the allowed payment modules, for selection by customer.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_payment_default.php 5414 2006-12-27 07:51:03Z drbyte $
 */
?>
<?php echo $payment_modules->javascript_validation(); ?>
<div class="centerColumn" id="checkoutPayment">
<?php echo zen_draw_form('checkout_payment', zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post', ($flagOnSubmit ? 'onsubmit="return check_form();"' : '')); ?>

<h1 id="checkoutPaymentHeading"><?php echo HEADING_TITLE; ?></h1>

<!-- bof Order Steps (tableless) -->
    <div id="order_steps">
            <div class="order_steps_text">
			<span class="order_steps_text2"><?php echo TEXT_ORDER_STEPS_1; ?></span><span id="active_step_text"><?php echo zen_image($template->get_template_dir(ORDER_STEPS_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . ORDER_STEPS_IMAGE, ORDER_STEPS_IMAGE_ALT); ?><br /><?php echo TEXT_ORDER_STEPS_2; ?></span><span class="order_steps_text3"><?php echo TEXT_ORDER_STEPS_3; ?></span><span class="order_steps_text4"><?php echo TEXT_ORDER_STEPS_4; ?></span>
            </div>
            <div class="order_steps_line_2">
                <span class="progressbar_active">&nbsp;</span><span class="progressbar_active">&nbsp;</span><span class="progressbar_inactive">&nbsp;</span><span class="progressbar_inactive">&nbsp;</span>
            </div>
    </div>
<!-- eof Order Steps (tableless) -->

<?php if ($messageStack->size('redemptions') > 0) echo $messageStack->output('redemptions'); ?>
<?php if ($messageStack->size('checkout') > 0) echo $messageStack->output('checkout'); ?>
<?php if ($messageStack->size('checkout_payment') > 0) echo $messageStack->output('checkout_payment'); ?>

<?php
  if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
?>
<fieldset>
<legend><?php echo TABLE_HEADING_CONDITIONS; ?></legend>
<div><?php echo TEXT_CONDITIONS_DESCRIPTION;?></div>
<?php echo  zen_draw_checkbox_field('conditions', '1', false, 'id="conditions"');?>
<label class="checkboxLabel" for="conditions"><?php echo TEXT_CONDITIONS_CONFIRM; ?></label>
</fieldset>
<?php
  }
?>

<?php

//jessa 2010-02-05 ɾ��ѡ�񸶿ʽʱ����ֵ�billing address��һ��
/*
// ** BEGIN PAYPAL EXPRESS CHECKOUT **
      if (!$payment_modules->in_special_checkout()) {
      // ** END PAYPAL EXPRESS CHECKOUT ** ?>
<h2 id="checkoutPaymentHeadingAddress"><?php echo TITLE_BILLING_ADDRESS; ?></h2>

<div id="checkoutBillto" class="floatingBox back">
<?php if (MAX_ADDRESS_BOOK_ENTRIES >= 2) { ?>
<div class="buttonRow forward"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHANGE_ADDRESS, BUTTON_CHANGE_ADDRESS_ALT) . '</a>'; ?></div>
<?php } ?>
<address><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />'); ?></address>
</div>

<div class="floatingBox important forward"><?php echo TEXT_SELECTED_BILLING_DESTINATION; ?></div>
<br class="clearBoth" />
<?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
      }
      // ** END PAYPAL EXPRESS CHECKOUT ** 
      
*/
?>
<br class="clearBoth">      
<fieldset id="checkoutOrderTotals">
<legend id="checkoutPaymentHeadingTotal"><?php echo TEXT_YOUR_TOTAL; ?></legend>
<?php
  if (MODULE_ORDER_TOTAL_INSTALLED) {
    $order_totals = $order_total_modules->process();
?>
<?php $order_total_modules->output(); ?>
<?php
  }
?>
</fieldset>

<?php
  $selection =  $order_total_modules->credit_selection();
  if (sizeof($selection)>0) {
    for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
      if ($_GET['credit_class_error_code'] == $selection[$i]['id']) {
?>
<div class="messageStackError"><?php echo zen_output_string_protected($_GET['credit_class_error']); ?></div>

<?php
      }
      for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
?>
<fieldset>
<legend><?php echo $selection[$i]['module']; ?></legend>
<?php echo $selection[$i]['redeem_instructions']; ?>
<div class="gvBal larger"><?php echo $selection[$i]['checkbox']; ?></div>
<?php 
	echo $selection[$i]['fields'][$j]['field'];
	echo '<span id="getcoupon" style="display:block; float:right; clear:left; width:550px;margin-top:6px;" >';
	if(zen_not_null($_SESSION['cc_id'])){
		echo '<strong>'.TEXT_RCD_CODE.': ' . zen_get_current_rcd_code().'</strong>';
	}else{
		echo '<a onclick="getCouponCode();return false;" href="#" >'.((!zen_customer_has_valid_order())?TEXT_CLICK_GET_FIRST_CODE:TEXT_CLICK_GET_RCD_CODE).'</a>';
	}
	echo '</span>';
?>
<label class="inputLabel"<?php echo ($selection[$i]['fields'][$j]['tag']) ? ' for="'.$selection[$i]['fields'][$j]['tag'].'"': ''; ?>><?php echo $selection[$i]['fields'][$j]['title']; ?></label>
<div class="clearBoth"></div>
</fieldset>
<?php
      }
    }
?>

<?php
    }
?>

<?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
      if (!$payment_modules->in_special_checkout()) {
      // ** END PAYPAL EXPRESS CHECKOUT ** ?>
<fieldset>
<legend><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></legend>

<?php
  if (SHOW_ACCEPTED_CREDIT_CARDS != '0') {
?>

<?php
    if (SHOW_ACCEPTED_CREDIT_CARDS == '1') {
      echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();
    }
    if (SHOW_ACCEPTED_CREDIT_CARDS == '2') {
      echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled('IMAGE_');
    }
?>
<br class="clearBoth" />
<?php } ?>

<?php
  $selection = $payment_modules->selection();

  if (sizeof($selection) > 1) {
?>
<p class="important"><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></p>
<?php
  } elseif (sizeof($selection) == 0) {
?>
<p class="important"><?php echo TEXT_NO_PAYMENT_OPTIONS_AVAILABLE; ?></p>

<?php
  }
?>

<?php
  $radio_buttons = 0;
  for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
  	  if ($selection[$i]['id'] == 'paypalmanually') Continue;
?>
<?php
    if (sizeof($selection) > 1) {
    	//jessa 2010-02-05 ɾ��paypal�Ŀ��ٸ��ʽ�������ж������������paypal�Ŀ��ٸ��ʽ������ʾ����
        //if (empty($selection[$i]['noradio']) && $selection[$i]['id'] != 'paypalwpp') {
        if (empty($selection[$i]['noradio'])){
 ?>
<?php 		echo zen_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-'.$selection[$i]['id'].'"'); ?>
<?php   } ?>
<?php
    } else {
    	//if ($selection[$i]['id'] != 'paypalwpp'){
?>
<?php 	echo zen_draw_hidden_field('payment', $selection[$i]['id']); ?>
<?php
    	//}
    }
    //eof jessa 2010-02-05
?>
<label for="pmt-<?php echo $selection[$i]['id']; ?>" class="radioButtonLabel">
<?php 
	//jessa 2010-02-05 ɾ��paypal�Ŀ��ٸ��ʽ�������ж������������paypal�Ŀ��ٸ��ʽ������ʾ����
	//if ($selection[$i]['id'] != 'paypalwpp'){
		echo $selection[$i]['module']; 
	//}
	//eof jessa 2010-02-05
?>
</label>

<?php
    if (defined('MODULE_ORDER_TOTAL_COD_STATUS') && MODULE_ORDER_TOTAL_COD_STATUS == 'true' and $selection[$i]['id'] == 'cod') {
?>
<div class="alert"><?php echo TEXT_INFO_COD_FEES; ?></div>
<?php
    } else {
      // echo 'WRONG ' . $selection[$i]['id'];
?>
<?php
    }
?>
<br class="clearBoth" />

<?php
    if (isset($selection[$i]['error'])) {
?>
    <div><?php echo $selection[$i]['error']; ?></div>

<?php
    } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
?>

<div class="ccinfo">
<?php
      for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
?>
<label <?php echo (isset($selection[$i]['fields'][$j]['tag']) ? 'for="'.$selection[$i]['fields'][$j]['tag'] . '" ' : ''); ?>class="inputLabelPayment"><?php echo $selection[$i]['fields'][$j]['title']; ?></label><?php echo $selection[$i]['fields'][$j]['field']; ?>
<br class="clearBoth" />
<?php
      }
?>
</div>
<br class="clearBoth" />
<?php
    }
    $radio_buttons++;
?>
<br class="clearBoth" />
<?php
  }
?>

</fieldset>
<?php
// ** BEGIN PAYPAL EXPRESS CHECKOUT **
      } else {
        ?><input type="hidden" name="payment" value="<?php echo $_SESSION['payment']; ?>" /><?php
      }
      // ** END PAYPAL EXPRESS CHECKOUT ** ?>
<fieldset>
<legend><?php echo TABLE_HEADING_COMMENTS; ?></legend>
	<table style="width:100%;margin-bottom:10px;">
		<tr><td style="padding-left:14px;"><?php echo TABLE_BODY_COMMENTS1; ?></td></tr>
		<tr><td style="padding-left:14px;"><?php echo TABLE_BODY_COMMENTS2; ?></td></tr>
	</table>

<?php echo zen_draw_textarea_field('comments', '45', '3'); ?>
</fieldset>

<div style="clear:both;"><div style="float:left; width:35%;"><?php echo '<a href="' . HTTP_SERVER . '"><img src="' . HTTP_SERVER . '/' . DIR_WS_TEMPLATES . 'cherry_zen/buttons/english/button_return_to_shopping.gif"></a>'; ?></div><div style="float:right; widows:35%;"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT, 'onclick="submitFunction('.zen_user_has_gv_account($_SESSION['customer_id']).','.$order->info['total'].')"'); ?></div></div>
<div style="clear:both;"><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>

</form><br /><br /><br />

<?php 

/*	paypal_offlin
	add a pay method when paypal error
	--------------------begin------------------------------------------------------

*/

echo zen_draw_form('paypal_error', zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post'); ?>
<div>
	<a name="PAYPAL_ERROR"></a><hr />
  	<p class="REDCONTENT"><font size="+1" class="content">Attention!!</font> (Only for those users who have already tried PayPal, but failed.)</p>
	<p class="important">
		Dear customers,<br /><br />
		Sometimes due to some problems from PayPal website, you can not pay us successfully by choosing PayPal payment method. <br />
		For example, after you confirm order on our website and been brought to PayPal website, but payment is not successful and  it redirects you back to our page. If such problems or other paypal problems happened to you, made you failed to pay via paypal several times. Do not worry. We have developed a perfect solution to this problem. You can try our backup payment method (PayPal Manually Send) according to step by step guide to finish your order.</p> 
<p class="important">*Note: Your entire payment procedure is been completed on PayPal website. You are sure to send your order money with PayPal Manually payment as securely as PayPal.</p>
<p class="important">Now click this button<?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE, BUTTON_CONFIRM_ORDER_ALT, 'name="btn_submit" id="btn_submit"') ;?> to go to the Order Confirmation page. </p>
</div>
	<input type=hidden name="payment" value="cod" id="pmt-cod"/>
</form>
<?php ////end of paypal error 
?>

</div>


