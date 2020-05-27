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
 */
?>
<div class="centerColumn" id="checkoutShipping">

<h1 id="checkoutShippingHeading"><?php echo HEADING_TITLE; ?></h1>
<?php if ($messageStack->size('checkout_shipping') > 0) echo $messageStack->output('checkout_shipping'); ?>

<!-- bof Order Steps (tableless) -->
<?php if($_SESSION['languages_id']==1){?>
    <div id="order_steps">
            <div class="order_steps_text">
			<span id="active_step_text"><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.ORDER_STEPS_IMAGE, ORDER_STEPS_IMAGE_ALT); ?><br /><?php echo TEXT_ORDER_STEPS_1; ?></span><span class="order_steps_text2"><?php echo TEXT_ORDER_STEPS_2; ?></span><span class="order_steps_text3"><?php echo TEXT_ORDER_STEPS_3; ?></span><span class="order_steps_text4"><?php echo TEXT_ORDER_STEPS_4; ?></span>
            </div>
            <div class="order_steps_line_2">
                <span class="progressbar_active">&nbsp;</span><span class="progressbar_inactive">&nbsp;</span><span class="progressbar_inactive">&nbsp;</span><span class="progressbar_inactive">&nbsp;</span>
            </div>
    </div>
    <?php }else{?>
    <table border=0 cellspacing=0 cellpadding=0 width="100%" id="order_steps_text_tb">
    <tr id="order_steps_text_tr_top">
    <td id="active_step_text_td"><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.ORDER_STEPS_IMAGE, ORDER_STEPS_IMAGE_ALT); ?><br /><?php echo TEXT_ORDER_STEPS_1; ?></td>
    <td><?php echo TEXT_ORDER_STEPS_2; ?></td>
    <td><?php echo TEXT_ORDER_STEPS_3; ?></td>
    <td><?php echo TEXT_ORDER_STEPS_4; ?></td>
    </tr>
    <tr id="order_steps_text_tr_below">
    <td><div class='progressbar_active_tr'></div></td><td><div></div></td><td><div></div></td><td><div></div></td>
    </tr>
    </table>
    <?php }?>
<!-- eof Order Steps (tableless) -->

<h2 id="checkoutShippingHeadingAddress"><?php echo TITLE_SHIPPING_ADDRESS; ?></h2>

<!--jessa 2010-02-07-->
<?php
	$address_listing = $db->Execute("select address_book_id, entry_firstname as firstname, entry_lastname as lastname,
                           entry_company as company,  telephone_number as telephone_number,  entry_suburb as suburb,
                           entry_city as city, entry_postcode as postcode,entry_street_address as street_address,
                           entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id
						   from " . TABLE_ADDRESS_BOOK . "
						   where customers_id = " . $_SESSION['customer_id']);
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
						echo '<a href="' . $editShippingButtonLink . '">' . zen_image_button(BUTTON_IMAGE_CHANGE_ADDRESS, BUTTON_CHANGE_ADDRESS_ALT) . '</a>&nbsp;&nbsp;&nbsp;&nbsp;'; 
					}
				}
				echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK, 'action=checkout_shipping') . '">' . zen_image_button('button_manage_address_book.gif', TEXT_IMAGE_MANAGE_ADDRESS_ALT) . '</a>';
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
			<legend><?php echo TEXT_SELECT_YOUR_ADDRESS;?></legend>
			<?php
			
				echo zen_draw_form('set_shipping_fee', zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL')) . zen_draw_hidden_field('action', 'shipping_fee');
				$row = 0;
				$col = 0;
				$show_address = array();
				while(!$address_listing->EOF){
					$format_id = zen_get_address_format_id($address_listing->fields['country_id']);
					$show_address[$row][$col] = array('customer_name' => zen_output_string_protected($address_listing->fields['firstname'] . ' ' . $address_listing->fields['lastname']),
													 
													  'text' => zen_address_format($format_id, $address_listing->fields, true, ' ', '<br />'),  
													  'telephone_number' => $address_listing->fields['telephone_number'],
													  'address_book_id' => $address_listing->fields['address_book_id']);
					$col++; 
					if ($col > 1){
						$col = 0;
						$row++;
					}
					$address_listing->MoveNext();
				}
				//$_SESSION['sendto'] . 
				$show_content = '<table width="100%" border="0" cellspacing="5" cellpadding="0">' . "\n";
				for ($i = 0; $i < sizeof($show_address); $i++){
					$show_content .= '	<tr>' . "\n";
					for ($j = 0; $j < sizeof($show_address[$i]); $j++){
						$show_content .= '		<td width="50%">' . "\n";
						$show_content .= '			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="address_table">' . "\n";
						$show_content .= '				<tr>' . "\n";
						$show_content .= '					<td style="padding:10px 5px;"><div><div id="customer_name">';
						if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0')){
							//当用户浏览器是IE6时, 执行以下代码
							$show_content .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">' . "\n";
							$show_content .= '  <tr>' . "\n";
							if ((isset($_SESSION['sendto']) && $_SESSION['sendto'] == $show_address[$i][$j]['address_book_id'] && $_SESSION['reset_shipping_fee'] == true) || $auto_select==true){
								$show_content .= '	  <td style="width:25px; text-align:center;"><a href="' . zen_href_link(FILENAME_SHOPPING_CART, 'set=shipping_fee&sendto=' . $show_address[$i][$j]['address_book_id']) . '">' . zen_image('includes/templates/cherry_zen/images/button_radio_select.jpg') . '</td>' . "\n";
							} else {
								$show_content .= '	  <td style="width:25px; text-align:center;"><a href="' . zen_href_link(FILENAME_SHOPPING_CART, 'set=shipping_fee&sendto=' . $show_address[$i][$j]['address_book_id']) . '">' . zen_image('includes/templates/cherry_zen/images/button_radio.jpg') . '</td>' . "\n";
							}
							$show_content .= '	  <td stylt="text-align:left; padding-left:5px;">' . $show_address[$i][$j]['customer_name'] . '</td>' . "\n";
							$show_content .= '	  <td style="text-align:left; padding-left:5px;"><a href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '&edit=' . $show_address[$i][$j]['address_book_id']) . '&addr_edit=edit">' . zen_image(DIR_WS_TEMPLATES . 'cherry_zen/buttons/english/small_edit.gif') . '</a>';
							$show_content .= '	</tr>' . "\n";
							$show_content .= '</table>' . "\n";
						} else {
							$show_content .= '<input type="radio" name="select_address" value="' . $show_address[$i][$j]['address_book_id'] . '"';
								if (($_SESSION['reset_shipping_fee'] == 'true' && $_SESSION['sendto'] == $show_address[$i][$j]['address_book_id']) || $auto_select==true){
									$show_content .= ' checked="checked"';
								}
							$show_content .= ' onclick="popu();">';
							$show_content .= $show_address[$i][$j]['customer_name'] . '<span id="edit"><a href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '&edit=' . $show_address[$i][$j]['address_book_id']) . '&addr_edit=edit">' . zen_image_button('small_edit.gif') . '</a></span></div></div>';
						}
						//$show_address[$i][$j]['address_book_id'] . 
						$show_content .= '<div style="clear:both;padding-left:25px; text-align:left;;">' . $show_address[$i][$j]['text'] . '</div>' . '</td>' . "\n";
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
<!--eof jessa 2010-02-07-->

<!--jessa 2009-11-04 添加以下代码，显示顾客购买商品的重量-->
<fieldset>
  <legend><?php echo TEXT_YOUR_SHIPPING_WEIGHT_INFO;?></legend>
      <br />
    <table width='80%' border='0' cellspacing ='0' align="left" style="border-collapse:collapse; border:1px solid #CCCCCC">  
    		 <tr>
    		    <td style="font-weight:bold; text-align:right; padding:5px 3px; width:70%;">
    		      <?php echo TEXT_GROSS_WEIGHT;?>:    		
    		    </td>
    		    <td style="font-weight:bold; text-align:left; padding-left:8px; border:1px solid #CCCCCC;">
					<?php
						$weight = $_SESSION['cart']->show_weight();
						echo $weight.TEXT_PRODUCT_WEIGHT_UNIT;
				    ?>
    		    </td>
    		  </tr>
    		  <tr>
    		    <td style="font-weight:bold; text-align:right; padding:5px 3px; width:70%;">
 					<?php echo TEXT_PACKING_BOX_WEIGHT;?>:
    		    </td>
    		    <td style="font-weight:bold; text-align:left; padding-left:8px; border:1px solid #CCCCCC;">
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
    		    <td style="font-weight:bold; text-align:right; padding:5px 3px; width:70%;">
					<?php echo TEXT_SHIPPING_WEIGHTS;?>:
    		    </td>
    		    <td style="font-weight:bold; text-align:left; padding-left:8px; border:1px solid #CCCCCC;">
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
    <br />

</fieldset>
<!--eof jessa 2009-11-04-->

<?php
  if (zen_count_shipping_modules() > 0) {
  	$ldc_min_cost = 1000000;
	  for ($comp1 = 0; $comp1 < sizeof($quotes); $comp1++){
		if (!$quotes[$comp1]['error'] && $quotes[$comp1]['id'] != 'sptya'){
			for ($comp2 = 0; $comp2 < sizeof($quotes[$comp1]['methods']); $comp2++){
// 				if ($quotes[$comp1]['methods'][$comp2]['id'] == 'airmail'){
// 					$ldc_cost = $quotes[$comp1]['methods'][$comp2]['cost'] * 1.5;
// 				}else{
					$ldc_cost = $quotes[$comp1]['methods'][$comp2]['cost'];
// 				}
				if ($ldc_cost < $ldc_min_cost){
					$ls_min_id = $quotes[$comp1]['methods'][$comp2]['id'];
					$ldc_min_cost = $ldc_cost;
				}
			}
		}
	  }
	  	  
	  reset($quotes);
?>

<fieldset>
			<legend><?php echo TEXT_SHIPPING_METHOD;?></legend>
			<?php if (isset($_SESSION['russia_discount'])) {?>
			<div style="margin:10px 0;font-weight:700;font-size:15px;color:red;"><?php echo TEXT_RUSSIA_DISCOUNT_REACH_10000;?></div>
			<?php }else{ $n = 1;?>
			
			<?php if ($show_en_country_note && false) { ?>
			<div class="note-tr-display" style="margin:10px 0;font-weight:700;font-size:15px;" onclick="showDetailsTr('en_country_note');"><?php echo $n . '. ' . TEXT_SUGGEST_ENGLISH_ADDRESS . zen_image(DIR_WS_TEMPLATE_IMAGES.'s1.png', '', '', '', 'class="img_appear" id="img_en_country_note"');?></div>
			<div class="details_tr" id="details_tr_en_country_note"><?php echo TEXT_SUGGEST_ENGLISH_ADDRESS_CONTENT;?></div>
			<?php ++$n; }?>
			
			<div class="note-tr-display" style="margin:10px 0;font-weight:700;font-size:15px;" onclick="showDetailsTr('before_choose');"><?php echo $n . '. ' . TEXT_SHIPPING_METHOD_DISCOUNT_NOTE_1 . zen_image(DIR_WS_TEMPLATE_IMAGES.'s1.png', '', '', '', 'class="img_appear" id="img_before_choose"');?></div>
			<div class="details_tr" id="details_tr_before_choose"><?php echo TEXT_SHIPPING_METHOD_DISCOUNT_NOTE_1_CONTENT;?></div>
			<?php if($select_country_id==176 ){ ++$n;?>
			<div style="margin:10px 0; color:red;font-weight:700;font-size:15px;"><?php echo $n . '. ' . TEXT_SHIPPING_METHOD_DISCOUNT_NOTE_2;?></div>
			<?php 
				  }
				}
			?>

			<div style="clear:both;">
			<?php 
				if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1){
			?>	
				<div id="shipping_text"><?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?></div>
			<?php 
				}elseif($free_shipping == false){
			?>
				<div id="shipping_text"><?php echo TEXT_ENTER_SHIPPING_INFORMATION; ?></div>
			<?php
				}
			?>	
				<div id="shipping_help"><a href="<?php echo HTTP_SERVER.(($_SESSION['languages_id']==1)?'':'/'.$_SESSION['languages_code']).'/'?>index.php?main_page=shippinginfo" target="_blank">[<?php echo TEXT_SHIPPING_CHARGE_RATE;?>]</a></div></div><br>				
			<?php			
				if ($free_shipping == true){
			?>
				<div id="freeShip" class="important" ><?php echo FREE_SHIPPING_TITLE; ?>&nbsp;<?php echo $quotes[$i]['icon']; ?></div>

				<div id="defaultSelected"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . zen_draw_hidden_field('shipping', 'free_free'); ?></div>
		<?php 
			}else{
				echo zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); 
				if ($_SESSION['reset_shipping_fee'] == 'true' && $_SESSION['sendto'] != ''){
					echo zen_draw_hidden_field('reset_sendto_new', $_SESSION['sendto']);
				}
		?>
				<div id="shipping_method">
			
			<?php
	require($template->get_template_dir('tpl_modules_checkout_shipping_method.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_checkout_shipping_method.php');
?>
				</div>
</fieldset>

<?php
			}
  } else {
?>
<h2 id="checkoutShippingHeadingMethod"><?php echo TITLE_NO_SHIPPING_AVAILABLE; ?></h2>
<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_NO_SHIPPING_AVAILABLE; ?></div>
<?php
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

<div style="clear:both;"><div style="float:left; width:35%;"><?php echo '<a href="' . HTTP_SERVER .(($_SESSION['languages_id']==1)?'':'/'.$_SESSION['languages_code']).'/'. '">' .zen_image_button('button_return_to_shopping.gif').'</a>'; ?></div><div style="float:right; widows:35%;"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT); ?></div></div>
<div style="clear:both;"><?php echo '<strong>' . TITLE_CONTINUE_CHECKOUT_PROCEDURE . '</strong><br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>

</form>
</div>
<script>

</script>