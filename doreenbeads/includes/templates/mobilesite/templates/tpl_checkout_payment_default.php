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

<style type="text/css">

<!--

.REDCONTENT {color: #FF0000}

-->

</style>

<div class="centerColumn" id="checkoutPayment">

<?php echo zen_draw_form('checkout_payment', zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post', ($flagOnSubmit ? 'onsubmit="return check_form();"' : '')); ?>



<h1 id="checkoutPaymentHeading"><?php echo HEADING_TITLE; ?></h1>



<!-- bof Order Steps (tableless) -->
<?php if($_SESSION['languages_id']==1){?>
    <div id="order_steps">

            <div class="order_steps_text">

			<span class="order_steps_text2"><?php echo TEXT_ORDER_STEPS_1; ?></span><span id="active_step_text"><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES. ORDER_STEPS_IMAGE, ORDER_STEPS_IMAGE_ALT); ?><br /><?php echo TEXT_ORDER_STEPS_2; ?></span><span class="order_steps_text3"><?php echo TEXT_ORDER_STEPS_3; ?></span><span class="order_steps_text4"><?php echo TEXT_ORDER_STEPS_4; ?></span>

            </div>

            <div class="order_steps_line_2">

                <span class="progressbar_active">&nbsp;</span><span class="progressbar_active">&nbsp;</span><span class="progressbar_inactive">&nbsp;</span><span class="progressbar_inactive">&nbsp;</span>

            </div>

    </div>
<?php }else{?>
    <table border=0 cellspacing=0 cellpadding=0 width="100%" id="order_steps_text_tb">
    <tr id="order_steps_text_tr_top">
    <td><?php echo TEXT_ORDER_STEPS_1; ?></td>
    <td id="active_step_text_td"><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.ORDER_STEPS_IMAGE, ORDER_STEPS_IMAGE_ALT); ?><br /><?php echo TEXT_ORDER_STEPS_2; ?></td>
    <td><?php echo TEXT_ORDER_STEPS_3; ?></td>
    <td><?php echo TEXT_ORDER_STEPS_4; ?></td>
    </tr>
    <tr id="order_steps_text_tr_below">
    <td><div class='progressbar_active_tr'></div></td><td><div class='progressbar_active_tr'></div></td><td><div></div></td><td><div></div></td>
    </tr>
    </table>
<?php }?>
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
/*jessa 2010-03-10 ɾ��billing address

<?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **

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

      // ** END PAYPAL EXPRESS CHECKOUT ** ?>
*/
 ?>     

<fieldset id="checkoutOrderTotals">

<legend id="checkoutPaymentHeadingTotal"><?php echo TEXT_YOUR_TOTAL; ?></legend>

<?php

  if (MODULE_ORDER_TOTAL_INSTALLED) {

    $order_totals = $order_total_modules->process();

?>

<table width='80%' border='0' cellspacing ='0' align="left" style="border-collapse:collapse; border:1px solid #CCCCCC">

<?php  echo $order_total_modules->output(true); ?>

</table>

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

//coupon_robbie wei 08-11-24

//      	if($selection[$i]['module'] === 'Discount Coupon')

//      		continue;

?>

<fieldset>

<!--coupon_wei at here-->

	<!--coupon_robbie wei

	<legend><?php //echo $selection[$i]['module']; ?></legend>

	<?php //echo $selection[$i]['redeem_instructions']; ?>

	<div class="gvBal larger"><?php //echo $selection[$i]['checkbox']; ?></div>

	<?php //echo $selection[$i]['fields'][$j]['field']; ?>

	<label class="inputLabel" <?//php echo ($selection[$i]['fields'][$j]['tag']) ? ' for="'.$selection[$i]['fields'][$j]['tag'].'"': ''; ?>><?php //echo $selection[$i]['fields'][$j]['title']; ?></label>

	<div class="clearBoth"></div>

	-->

	<legend><?php echo $selection[$i]['module']; ?></legend>

	<?php echo $selection[$i]['redeem_instructions']; ?>

	<div class="gvBal larger"><?php echo $selection[$i]['checkbox']; ?></div>

	<label class="inputLabel"<?php echo ($selection[$i]['fields'][$j]['tag']) ? ' for="'.$selection[$i]['fields'][$j]['tag'].'"': ''; ?>><b><?php echo $selection[$i]['fields'][$j]['title']; ?></b>

	<?php 
		$_SESSION['has_valid_order']=zen_customer_has_valid_order();
		echo $selection[$i]['fields'][$j]['field'];
		echo '<span id="getcoupon" style="display:block; float:right; clear:left; width:420px;margin-top:6px;" >';
		if(zen_not_null($_SESSION['cc_id'])){
			echo '<strong>'.TEXT_RCD_CODE.': ' . zen_get_current_rcd_code().'</strong>';
		}else{
			echo '<a onclick="getCouponCode();return false;" href="#" >'.(($_SESSION['has_valid_order'] == true)?TEXT_CLICK_GET_RCD_CODE:(($_SESSION['register_march_coupou']&&$order->info['subtotal']>=100)?TEXT_CLICK_GET_MARCH_CODE:TEXT_CLICK_GET_FIRST_CODE)).'</a>';
		}
		echo '</span>';
	?>
	</label>
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

<?php   if ($selection[$i]['id'] == 'alipay'){
//				  if(calc_order_amount_payment($order->info['total'],'USD')<2000){
//				  	
			if($_SESSION['customer_id'] == 20796 
					  || $_SESSION['customer_id'] == 5420 
					  || $_SESSION['customer_id'] == 8345 
					  || $_SESSION['customer_id'] == 7883 
					  || $_SESSION['customer_id'] == 5906 
					  || $_SESSION['customer_id'] == 9900 
					  || $_SESSION['customer_id'] == 28020 
					  || $_SESSION['customer_id'] == 20065 
					  || $_SESSION['customer_id'] == 20796 
					  || $_SESSION['customer_id'] == 29124 
					  || $_SESSION['customer_id'] == 24838){
					  	
					 echo zen_draw_radio_field('payment', 'boc-visa', ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-visa"').'<label for="pmt-visa"  class="radioButtonLabel">'.zen_image('images/icon-logo/visa.png','visa',45,30).' '.TEXT_CREDIT_CARD_VISA.'</label>'; 
 					 echo "<br/>"; 
 					 echo zen_draw_radio_field('payment', 'boc-master', ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-master"').'<label class="radioButtonLabel" for="pmt-master">'.zen_image('images/icon-logo/master.png','master',45,30,'for="pmt-master"').' '.TEXT_CREDIT_CARD_MASTERCARD.'</label>'; 
				  }
				  
 		         
 		}elseif ($selection[$i]['id'] == 'paypalwpp'){
				  
					 echo zen_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-'.$selection[$i]['id'].'"').'<label class="radioButtonLabel" for="pmt-'.$selection[$i]['id'].'">';
					 echo $selection[$i]['module'].'</label>'; 
 					 echo zen_draw_radio_field('payment', 'paypalwpp', ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="visa-paypal"').'<label class="radioButtonLabel" for="visa-paypal"><a href="https://www.paypal.com/" target="_blank">'.zen_image('images/icon-logo/paypal_visa.jpg','paypal',120,40,'for="visa-paypal"').'</a> '.TEXT_CREDIT_CARD_VISA_PAYPAL.'</label>'; 
				  
 		}else{ 
                  echo zen_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-'.$selection[$i]['id'].'"'); 
 	     } ?>
<?php } ?>

<?php

    } else {
    	//if ($selection[$i]['id'] != 'paypalwpp')

?>

<?php echo zen_draw_hidden_field('payment', $selection[$i]['id']); ?>

<?php
    }
	//eof jessa 2010-02-05
?>

<label for="pmt-<?php echo $selection[$i]['id']; ?>" class="radioButtonLabel">
<?php 
	//jessa 2010-02-05 ɾ��paypal�Ŀ��ٸ��ʽ�������ж������������paypal�Ŀ��ٸ��ʽ������ʾ����
	//if ($selection[$i]['id'] != 'paypalwpp'){
		if ($selection[$i]['id'] == 'alipay' || $selection[$i]['id'] == 'paypalwpp'){
		
		}elseif($selection[$i]['id'] == 'moneygram'){
			echo zen_image(DIR_WS_TEMPLATE_IMAGES.'moneygram.jpg').$selection[$i]['module'].MODULE_PAYMENT_MONEYGRAM_ABOUT_INFO;
		}else{
			echo $selection[$i]['module'];
		}
	//}
	//eof jessa 2010-02-05 
	
?>
</label>
<?php 
if ($selection[$i]['id'] == 'wire' || $selection[$i]['id'] == 'wirebc'){
	echo '<span style="margin-left:25px;color:red;cursor:pointer;display:'.($selection[$i]['id'] == $_SESSION['payment'] ? 'true' : 'none').'" class="note-status-pm" id="note-'.$selection[$i]['id'].'" onclick=showDetailsTr("'.$selection[$i]['id'].'")>';
	echo TEXT_PLEASE_READ_THIS_NOTE;
	echo '<img src="'.DIR_WS_TEMPLATE_IMAGES.'s1.png'.'" class="img_appear" id="img_'.$selection[$i]['id'].'">';
	echo '</span>';
?>
<div class="details_tr_pm" id="details_tr_<?php echo $selection[$i]['id'];?>">
<?php echo TEXT_PAYMENT_TRANSFER_NOTE;?>
<br>
<?php 
//if($order->info['total']>=1500){
	echo '3. ' . TEXT_REACH_1500_NOTE;
//}
?>
</div>
<?php
}
?>


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

<?php

    }

    $radio_buttons++;

?>

<br class="clearBoth" />

<?php

  }

?>

<!--

 ////paypal_offline_robbie wei   2008-12- 17:38

-->

<p><font face="Arial">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<font color="Red"><?php echo TEXT_PAYPAL_FAILED_CLICK;?></font>

</p>

</fieldset>

<?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **

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



<?php  echo zen_draw_textarea_field('comments', '45', '3'); ?>



</fieldset>



<div style="clear:both;"><div style="float:left; width:35%;"><?php echo '<a href="' . HTTP_SERVER . (($_SESSION['languages_id']==1)?'':'/'.$_SESSION['languages_code']).'/'.'">'.zen_image_button('button_return_to_shopping.gif').'</a>'; ?></div><div style="float:right; widows:35%;"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT, 'onclick="submitFunction('.zen_user_has_gv_account($_SESSION['customer_id']).','.$order->info['total'].')"'); ?></div></div>

<div style="clear:both; text-align:left;"><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>



</form><br /><br /><br />

<?php 

/*	paypal_offline_robbie wei

	add a pay method when paypal error

	date:081023

	--------------------begin------------------------------------------------------

*/

echo zen_draw_form('paypal_error', zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post'); ?>

<div>

	<a name="PAYPAL_ERROR"></a><hr />

<?php if(MODULE_PAYMENT_COD_STATUS == 'True'){
		echo TEXT_PAYPAL_ERROR_INFO;
	}?>

</div>

	<input type=hidden name="payment" value="cod" id="pmt-cod"/>

</form>

<?php ////end of paypal error 

?>

</div>

