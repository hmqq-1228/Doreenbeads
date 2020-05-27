<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_shipping.<br />
 * Displays allowed shipping modules for selection by customer.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_shipping_default.php 6964 2007-09-09 14:22:44Z ajeh $
 * @replace;
 */
?>

<div class="centerColumn" id="checkoutShipping">
<h1 id="checkoutShippingHeading"><?php echo HEADING_TITLE; ?></h1>
<?php if ($messageStack->size('checkout_shipping') > 0) echo $messageStack->output('checkout_shipping'); ?>

<!-- bof Order Steps (tableless) -->
    <div id="order_steps">
            <div class="order_steps_text">
			<span id="active_step_text"><?php echo zen_image($template->get_template_dir(ORDER_STEPS_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . ORDER_STEPS_IMAGE, ORDER_STEPS_IMAGE_ALT); ?><br /><?php echo TEXT_ORDER_STEPS_1; ?></span><span class="order_steps_text2"><?php echo TEXT_ORDER_STEPS_2; ?></span><span class="order_steps_text3"><?php echo TEXT_ORDER_STEPS_3; ?></span><span class="order_steps_text4"><?php echo TEXT_ORDER_STEPS_4; ?></span>
            </div>
            <div class="order_steps_line_2">
                <span class="progressbar_active">&nbsp;</span><span class="progressbar_inactive">&nbsp;</span><span class="progressbar_inactive">&nbsp;</span><span class="progressbar_inactive">&nbsp;</span>
            </div>
    </div>
<!-- eof Order Steps (tableless) -->

<h2 id="checkoutShippingHeadingAddress"><?php echo TITLE_SHIPPING_ADDRESS; ?></h2>

<!--jessa 2010-02-07-->
<?php
	$address_listing = $db->Execute("Select address_book_id, entry_firstname as firstname, entry_lastname as lastname,
											entry_company as company, entry_street_address as street_address,
											entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
											entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id
									   From " . TABLE_ADDRESS_BOOK . "
									  Where customers_id = " . $_SESSION['customer_id']);
	$address_num = $address_listing->RecordCount();
	$max_addres_entries = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MAX_ADDRESS_BOOK_ENTRIES'");
	$max_address_entries_value = (int)$max_addres_entries->fields['configuration_value'];
?>

<div id="address_wapper">
	<div class="shipping_description">
		<?php 
			if ($address_num < $max_address_entries_value){
				echo TEXT_CHOOSE_SHIPPING_DESTINATION; 
			}else{
				echo TEXT_CHOOSE_SHIPPING_DESTINATION_1;
			}
		?>
		<div id="change_address">
			<?php
				if ($displayAddressEdit) { 
					if ($address_num < $max_address_entries_value){
						echo '<a class="addlistbtn11" href="javascript:void(0);">' . zen_image_button(BUTTON_IMAGE_CHANGE_ADDRESS, BUTTON_CHANGE_ADDRESS_ALT) . '</a>&nbsp;&nbsp;&nbsp;&nbsp;'; 
					}
				}
				echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK, 'action=checkout_shipping') . '">' . zen_image_button('button_manage_address_book.gif', 'button_manage_address_book') . '</a>';
			?>
		</div>
	</div>
	
	<?php
		if ($_SESSION['address_select_error'] != ''){
			echo '<div id="address_select_error">' . TEXT_CHOOSE_SHIPPING_ADDRESS . '</div>';
			unset($_SESSION['address_select_error']);
		}
	?>

		<div id="address_listing">
		<fieldset>
			<legend>Select Your Address</legend>
		<?php
			echo zen_draw_form('set_shipping_fee', zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL')) . zen_draw_hidden_field('action', 'shipping_fee');
				$row = 0;
				$col = 0;
				$show_address = array();
				while(!$address_listing->EOF){
					$format_id = zen_get_address_format_id($address_listing->fields['country_id']);
					$show_address[$row][$col] = array('customer_name' => zen_output_string_protected($address_listing->fields['firstname'] . ' ' . $address_listing->fields['lastname']),
													 
													  'text' => zen_address_format($format_id, $address_listing->fields, true, ' ', '<br />'),  
													  'address_book_id' => $address_listing->fields['address_book_id']);
					$col++; 
					if ($col > 1){
						$col = 0;
						$row++;
					}
					$address_listing->MoveNext();
				}
				$show_content = '<table width="100%" border="0" cellspacing="10" cellpadding="0">' . "\n";
				for ($i = 0; $i < sizeof($show_address); $i++){
					$show_content .= '	<tr>' . "\n";
					for ($j = 0; $j < sizeof($show_address[$i]); $j++){
						$show_content .= '		<td width="50%">' . "\n";
						$show_content .= '			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="address_table">' . "\n";
						$show_content .= '				<tr>' . "\n";
						$show_content .= '					<td style="padding:10px 5px;"><div><div id="customer_name">';
						$show_content .= '<input type="radio" name="select_address" value="' . $show_address[$i][$j]['address_book_id'] . '"';
							if (($_SESSION['sendto'] == $show_address[$i][$j]['address_book_id']) || $auto_select == true){
								$show_content .= ' checked="checked"';
							}
						$show_content .= ' onclick="popu()">';
						$show_content .= $show_address[$i][$j]['customer_name'] . '</div><div id="edit"><a href="javascript:void(0);" class="addressedit" addid="'.$show_address[$i][$j]['address_book_id'].'">' . zen_image(DIR_WS_TEMPLATES . 'cherry_zen/buttons/english/small_edit.gif') . '</a></div></div><div style="clear:both;padding-left:25px; text-align:left;;">' . $show_address[$i][$j]['text'] . '</div>' . '</td>' . "\n";
						$show_content .= '				</tr>' . "\n";
						$show_content .= '			</table>' . "\n";
						$show_content .= '		</td>' . "\n";
					}
					$show_content .= '	</tr>' . "\n";
				}
				$show_content .= '</table>' . "\n";
				
				echo $show_content;
				
			?>
			</form>
			</fieldset>
		</div>	
</div>
<br class="clearBoth" />
<?php 
	echo zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); 
	if ($_SESSION['reset_shipping_fee'] == 'true' && $_SESSION['sendto'] != ''){
		echo zen_draw_hidden_field('reset_sendto_new', $_SESSION['sendto']);
	}
?>
<!--eof jessa 2010-02-07-->

<!--jessa 2009-11-04 添加以下代码，显示顾客购买商品的重量-->
<fieldset>
  <legend>Your Shipping Weight Information</legend>
    <table width="80%" border="0" cellspacing ="0" style = "border-collapse:collapse;border:1px solid #CCCCCC;">  
	  <tr>
		<td style='font-weight:bold; text-align:right; padding:5px 3px; width:70%;'>Gross Weight:</td>
		<td style='font-weight:bold; text-align:left; padding-left:8px; border:1px solid #CCCCCC;'>
			<?php 
				$weight = $_SESSION['cart']->show_weight();
				echo $weight.TEXT_PRODUCT_WEIGHT_UNIT;
			?>
		</td>
	  </tr>
	  <tr>
		<td style='font-weight:bold; text-align:right; padding:5px 3px; width:70%;'>Package Box Weight:</td>
		<td style='font-weight:bold; text-align:left; padding-left:8px; border:1px solid #CCCCCC;'>
			<?php
				if($weight>50000){
					echo ($weight*0.06).TEXT_PRODUCT_WEIGHT_UNIT;
				}else{
					echo ($weight*0.1).TEXT_PRODUCT_WEIGHT_UNIT;
				}
			?>
		</td>
	  </tr>
	  <tr>
		<td style='font-weight:bold; text-align:right; padding:5px 3px; width:70%;'>Shipping Weight:</td>
		<td style='font-weight:bold; text-align:left; padding-left:8px; border:1px solid #CCCCCC;'>
			<?php
				if($weight>50000){
					echo ($weight*1.06).TEXT_PRODUCT_WEIGHT_UNIT;  
				}else{ 
					echo ($weight*1.1).TEXT_PRODUCT_WEIGHT_UNIT;  
				} 
			?>
		</td>
	  </tr>
    </table>
</fieldset>
<!--eof jessa 2009-11-04-->

<?php
	if (sizeof($shipping_result) > 0){
?>
<fieldset>
		<legend>Shipping Method</legend>
<?php
		if (sizeof($shipping_result) > 1){
?>
			<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?></div>
<?php
		}elseif($free_shipping == false){
?>
			<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_ENTER_SHIPPING_INFORMATION; ?></div>

<?php
		}
?>
<?php
		if ($free_shipping == true){
?>
			<div id="freeShip" class="important"><?php echo FREE_SHIPPING_TITLE; ?></div>
			<div id="defaultSelected"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . zen_draw_hidden_field('shipping', 'free_free');?></div>
<?php
		}else{
?>
<script type="text/javascript">
$j(document).ready(function(){
	$j('.note-tr-display, .details_tr').click(function(e){
		e.stopPropagation();
	})
})
</script>
<div style="padding:8px 0px; border-bottom:1px dashed #CCCCCC">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<th width='3%'></th>
			<th width='15%'><a class='sorttype' type='cost' href='javascript:void(0);'><?php echo TEXT_PRICE;?> <img style='vertical-align: middle;' src='includes/templates/cherry_zen/images/asc.png'/></a></th>
			<?php if (sizeof($special_discount) > 0){ ?>
			<th width='18%' style="text-align:left; color:#ff0000;"><a style="color:#000000;" href='javascript:void(0);' title="Since shipping cost for different shipping methods are different a lot, so when your parcel is heavy, we could get some discount from shipping agent, so we give you discount accordingly.">Special Discount</a></th>
			<?php } ?>
			<th width='30%' style="text-align:left;"><?php echo TEXT_SHIPPING_METHOD;?></th>
			<th width='10%' style="text-align:left;"><a class='sorttype'  type='day' href='javascript:void(0);'><?php echo TEXT_DAYS;?> <img style='vertical-align: middle;' src='includes/templates/cherry_zen/images/asc.png'/></a></th>
			<th width='24%' style="text-align:left;"><?php echo TEXT_NOTE;?></th>
		</tr>
	</table>
</div>
		<div id="shipping_method">
			
		<?php		
			require($template->get_template_dir('tpl_modules_checkout_shipping_method.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_checkout_shipping_method.php');				
		?>
		</div>
</fieldset>

<?php
			}
	}else{
?>
<h2 id="checkoutShippingHeadingMethod"><?php echo TITLE_NO_SHIPPING_AVAILABLE; ?></h2>

<?php 
if ($address_num == 0){
	?>
	<h2 id="checkoutShippingHeadingMethod">Sorry your shipping address is empty, you can’t continue to check out until you submit your shipping address, please click <a class="addlistbtn11" href="javascript:void(0);"><img title=" Add Address " alt="Change Address" src="includes/templates/cherry_zen/buttons/english/button_change_address.gif"></a> to submit. many thanks!</h2>
	<?php 
}else{
?>
<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_NO_SHIPPING_AVAILABLE; ?></div>
<?php
}
	}
?>
<fieldset class="shipping" id="comments">
<legend><?php echo TABLE_HEADING_COMMENTS; ?></legend>
	<table style="width:100%;margin-bottom:10px;">
		<tr><td style="padding-left:14px;"><?php echo TABLE_BODY_COMMENTS1; ?></td></tr>
		<tr><td style="padding-left:14px;"><?php echo TABLE_BODY_COMMENTS2; ?></td></tr>
	</table>

<?php echo zen_draw_textarea_field('comments', '45', '3'); ?>
</fieldset>

<div style="clear:both;"><div style="float:left; width:35%;"><?php echo '<a href="' . HTTP_SERVER . '"><img src="' . HTTP_SERVER . '/' . DIR_WS_TEMPLATES . 'cherry_zen/buttons/english/button_return_to_shopping.gif"></a>'; ?></div><div style="float:right; widows:35%;"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT); ?></div></div>
<div style="clear:both;"><?php echo '<strong>' . TITLE_CONTINUE_CHECKOUT_PROCEDURE . '</strong><br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>

</form>
</div>