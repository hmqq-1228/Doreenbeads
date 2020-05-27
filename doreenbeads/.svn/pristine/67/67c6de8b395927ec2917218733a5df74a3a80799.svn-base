<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_success.<br />
 * Displays confirmation details after order has been successfully processed.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_success_default.php 5407 2006-12-27 01:35:37Z drbyte $
 */
?>
<div class="centerColumn" id="checkoutSuccess">

<!--bof -gift certificate- send or spend box-->
<?php
// only show when there is a GV balance
  if ($customer_has_gv_balance ) {
?>
<div id="sendSpendWrapper">
<?php require($template->get_template_dir('tpl_modules_send_or_spend.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_send_or_spend.php'); ?>
</div>
<?php
  }
?>
<!--eof -gift certificate- send or spend box-->

<h1 id="checkoutSuccessHeading"><?php echo HEADING_TITLE; ?></h1>
<?php 
//Australia donation Display the donation amt at check out amt
//robbie wei
	$orders_amt = $db->Execute("Select value, orders_status
					  From " . TABLE_ORDERS ." as orders, " . TABLE_ORDERS_TOTAL . " as order_total
					 Where orders.orders_id = order_total.orders_id
					   And orders.orders_id = " . $zv_orders_id . "
					   And class = 'ot_subtotal'");
    $amount = $orders_amt->fields['value'];
    $amount = zen_round($amount * 0.03, 2);
    $donation_amt_txt = '<font style="color: red">' . $currencies->format($amount) . '</font>';
//eof robbie
?>
<div id="checkoutSuccessOrderNumber">
	<?php echo TEXT_YOUR_ORDER_NUMBER . $zv_orders_id; ?><br />
	<?php 
	if ($date_now < '20090308') {
		if ($orders_amt->fields['value'] = '1') {
			echo sprintf(TEXT_THANKS_BEFORE,$donation_amt_txt);
		}
		else {
			echo sprintf(TEXT_THANKS_AFTER,$donation_amt_txt);
		}
	}?>
</div>

<!-- bof Order Steps (tableless) -->
 <?php if($_SESSION['languages_id']==1){?>
    <div id="order_steps">
            <div class="order_steps_text">
			<span class="order_steps_text2"><?php echo TEXT_ORDER_STEPS_1; ?></span><span class="order_steps_text3"><?php echo TEXT_ORDER_STEPS_2; ?></span><span class="order_steps_text4"><?php echo TEXT_ORDER_STEPS_3; ?></span><span id="active_step_text"><?php echo  zen_image(DIR_WS_TEMPLATE_IMAGES.ORDER_STEPS_IMAGE, ORDER_STEPS_IMAGE_ALT); ?><br /><?php echo TEXT_ORDER_STEPS_4; ?></span>
            </div>
            <div class="order_steps_line_2">
                <span class="progressbar_active">&nbsp;</span><span class="progressbar_active">&nbsp;</span><span class="progressbar_active">&nbsp;</span><span class="progressbar_active">&nbsp;</span>
            </div>
    </div>
    <?php }else{?>
    <table border=0 cellspacing=0 cellpadding=0 width="100%" id="order_steps_text_tb">
    <tr id="order_steps_text_tr_top">
    <td><?php echo TEXT_ORDER_STEPS_1; ?></td>
    <td><?php echo TEXT_ORDER_STEPS_2; ?></td>
    <td ><?php echo TEXT_ORDER_STEPS_3; ?></td>
    <td id="active_step_text_td"><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.ORDER_STEPS_IMAGE, ORDER_STEPS_IMAGE_ALT); ?><br /><?php echo TEXT_ORDER_STEPS_4; ?></td>
    </tr>
    <tr id="order_steps_text_tr_below">
    <td><div class='progressbar_active_tr'></div></td><td><div class='progressbar_active_tr'></div></td><td><div class='progressbar_active_tr'></div></td><td><div class='progressbar_active_tr'></div></td>
    </tr>
    </table>
    <?php }?>
<!-- eof Order Steps (tableless) -->
<?php
  $current_order_query = "Select delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_address_format_id
  							From " . TABLE_ORDERS . "
  						   Where orders_id = " . (int)$zv_orders_id;
  $current_orders = $db->Execute($current_order_query);
  $current_orders_array = array();
  if ($current_orders->RecordCount() > 0){
  	$current_orders_array = array('name' => $current_orders->fields['delivery_name'],
  								  'company' => $current_orders->fields['delivery_company'],
  								  'street_address' => $current_orders->fields['delivery_street_address'],
  								  'suburb' => $current_orders->fields['delivery_suburb'],
  								  'city' => $current_orders->fields['delivery_city'],
  								  'postcode' => $current_orders->fields['delivery_postcode'],
  								  'state' => $current_orders->fields['delivery_state'],
  								  'country' => $current_orders->fields['delivery_country'],
  								  'format_id' => $current_orders->fields['delivery_address_format_id']);
  }
?>
<div style="padding:10px; border:1px solid #FF8040; clear:both;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td width="50%" style="vertical-align:top"><address><?php echo '<strong>'.TEXT_SHIPPING_ADDRESS.':</strong><br />' . zen_address_format($current_orders_array['format_id'], $current_orders_array, 1, ' ', '<br />'); ?></address></td>
      <td width="50%" style="vertical-align:top"><?php echo TEXT_IMPORTANT_NOTES_SUCCESS; ?></td>
  	</tr>
  </table>
</div>
<br style="clear:both;" />

<?php if (DEFINE_CHECKOUT_SUCCESS_STATUS >= 1 and DEFINE_CHECKOUT_SUCCESS_STATUS <= 2) { ?>
<div id="checkoutSuccessMainContent" class="content">

<div >

<?php if ($_SESSION['languages_id']==3){?>
<p>Найдите нас на VK, чтобы получить последние новости нашего сайта：8seasons.com.</p>
<div >
<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?52"></script>

<!-- VK Widget -->
<div id="vk_groupss"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groupss", {mode: 0, width: "600", height: "200"}, '42161117');
</script>
</div>
	<?php }?>
<?php
/**
 * require the html_defined text for checkout success
 */
  require($define_page);
?>

</div>

<?php } ?>
<!--bof logoff-->
<div id="checkoutSuccessLogoff">
<?php
  if (isset($_SESSION['customer_guest_id'])) {
    echo TEXT_CHECKOUT_LOGOFF_GUEST;
  } elseif (isset($_SESSION['customer_id'])) {
    echo TEXT_CHECKOUT_LOGOFF_CUSTOMER;
  }
?>
<div class="buttonRow forward"><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><?php echo zen_image_button(BUTTON_IMAGE_LOG_OFF , BUTTON_LOG_OFF_ALT); ?></a></div>
</div>
<!--eof logoff-->
<br class="clearBoth" />
<!--bof -product notifications box-->
<?php
/**
 * The following creates a list of checkboxes for the customer to select if they wish to be included in product-notification
 * announcements related to products they've just purchased.
 **/
//product_notify do not show product notification on checkout success
//robbie wei
$flag_show_products_notification = false;
    if ($flag_show_products_notification == true) {
?>
<fieldset id="csNotifications">
<legend><?php echo TEXT_NOTIFY_PRODUCTS; ?></legend>
<?php echo zen_draw_form('order', zen_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', 'SSL')); ?>

<?php foreach ($notificationsArray as $notifications) { ?>
<?php echo zen_draw_checkbox_field('notify[]', $notifications['products_id'], true, 'id="notify-' . $notifications['counter'] . '"') ;?>
<label class="checkboxLabel" for="<?php echo 'notify-' . $notifications['counter']; ?>"><?php echo $notifications['products_name']; ?></label>
<br />
<?php } ?>
<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); ?></div>
</form>
</fieldset>
<?php
    }
?>
<!--eof -product notifications box-->



<!--bof -product downloads module-->
<?php
  if (DOWNLOAD_ENABLED == 'true') require($template->get_template_dir('tpl_modules_downloads.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_downloads.php');
?>
<!--eof -product downloads module-->

<div id="checkoutSuccessOrderLink"><?php echo TEXT_SEE_ORDERS;?></div>

<div id="checkoutSuccessContactLink"><?php echo TEXT_CONTACT_STORE_OWNER;?></div>

<h3 id="checkoutSuccessThanks" class="centeredContent"><?php echo TEXT_THANKS_FOR_SHOPPING; ?></h3>
</div>