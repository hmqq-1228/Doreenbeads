<?php /* Smarty version Smarty-3.1.13, created on 2020-04-17 09:06:26
         compiled from "includes\templates\mobilesite\tpl\checkout\tpl_checkout_normal.html" */ ?>
<?php /*%%SmartyHeaderCode:90865e99011247d816-71646166%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23079a22f7d0d844fcd5b323622bc5fddce63308' => 
    array (
      0 => 'includes\\templates\\mobilesite\\tpl\\checkout\\tpl_checkout_normal.html',
      1 => 1575421066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '90865e99011247d816-71646166',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'address_num' => 0,
    'address_checked' => 0,
    'address_info' => 0,
    'obj_text' => 0,
    'shipping_info' => 0,
    'tariff_text' => 0,
    'total_num' => 0,
    'total_price' => 0,
    'pinfo' => 0,
    'p' => 0,
    'cart_fen_ye_bottom' => 0,
    'add_coupon_str' => 0,
    'coupon_display' => 0,
    'coupon_select' => 0,
    'show_coupon' => 0,
    'order_total_str' => 0,
    'shoppingcart_default_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e990112781f95_17900499',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e990112781f95_17900499')) {function content_5e990112781f95_17900499($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['address_num']->value<=0){?>
<?php echo $_smarty_tpl->getSubTemplate ('includes/templates/mobilesite/tpl/checkout/tpl_checkout_address.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
<div class="order_main">
    <div class="order_warp">
        <h3><?php echo @constant('TEXT_ADDRESS_INFOMATION');?>
</h3>
        <div class="addresscont" id='addressAnchor'>
	    	<div class="selected" id="addressbox" onclick="saveAddressInfo('index.php?main_page=checkout&pn=lt');">
	    		<label><?php echo $_smarty_tpl->tpl_vars['address_checked']->value['address_info'];?>
</label>
	    		
	    		<img src="/includes/templates/mobilesite/css/<?php echo $_SESSION['languages_code'];?>
/images/method_arrow.png" />
	    	</div>
    	</div>
		<div id="hidden_shipping_address_info" style="display: none;">
			<input type='hidden' name="gender" value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_gender"];?>
'>
			<input type='hidden' name='firstname' id='firstname' value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_firstname"];?>
'>
			<input type='hidden' name='lastname' id='lastname' value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_lastname"];?>
'>
			<input type='hidden' name='country' id='country' value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_country_id"];?>
'>
			<input type='hidden' name='zone_id' id='zone_id' value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_zone_id"];?>
'>
			<input type='hidden' name='state' id='state' value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_state"];?>
'>
			<input type='hidden' name='street_address' id='street_address' value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_street_address"];?>
'>
			<input type='hidden' name='city' id='city' value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_city"];?>
'>
			<input type='hidden' name='postcode' id='postcode' value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_postcode"];?>
'>
			<input type='hidden' name='telephone' id='telephone' value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["telephone_number"];?>
'>
		</div>
    	
    	<h3 class="addressnav" id='shippingAnchor' style="margin-top:15px;"><?php echo $_smarty_tpl->tpl_vars['obj_text']->value["text_shipping_method"];?>
</h3>
		<div class="shippingcontcheck" style="position:relative;" onclick="saveAddressInfo('index.php?main_page=checkout&pn=sc');">
			<div class="shippingcontContent shippingcontContentSelect">
				<span class="shippingTitle"><span class="price_color"><?php echo $_smarty_tpl->tpl_vars['shipping_info']->value['cost_show'];?>
</span><br><?php echo $_smarty_tpl->tpl_vars['shipping_info']->value['title'];?>
<br><?php echo $_smarty_tpl->tpl_vars['shipping_info']->value['days_show'];?>
</span>
				<span class="shippingDays"></span>
				<?php if ($_smarty_tpl->tpl_vars['shipping_info']->value['show_note']!=''){?>
					<span class='shippingTip'><img class="methodInfo" src="/includes/templates/mobilesite/css/<?php echo $_SESSION['languages_code'];?>
/images/addr_info.png" /></span>
				<?php }else{ ?>
					<span class='shippingTip'>&nbsp;</span>
				<?php }?>
				<span class="shippingMore"><img class="medthodArrow" src="/includes/templates/mobilesite/css/<?php echo $_SESSION['languages_code'];?>
/images/method_arrow.png" /></span>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['shipping_info']->value['show_note']!=''){?>
				<div class="shippingTipContent">
					<?php echo $_smarty_tpl->tpl_vars['shipping_info']->value['show_note'];?>

				</div>
			<?php }?>
		</div>
		<form class="commentform" name="commentform" action="index.php?main_page=checkout" method="post">
		<input type="hidden" value="comment" name="action">
		<h3 class="addressnav"><?php echo @constant('TEXT_MESSAGE_CUSTOM_NO');?>
</h3>
		<div class="shipcont">
		     <div class="ordermessage">
		       <h3><?php echo @constant('TEXT_ORDER_MESSAGE');?>
</h3>
		       <textarea id="ordermessage" maxlength="1000" name="orderComments" style="color: darkgray;padding: 2%;" origin-tip="<?php echo @constant('TABLE_BODY_COMMENTS');?>
"><?php echo @constant('TABLE_BODY_COMMENTS');?>
</textarea>
		       <span id="message-byte"><?php echo @constant('TEXT_WORDS_LEFT');?>
</span>
		     </div>
		     
		      <div class="ordermessage">
		       <h3><?php echo @constant('TEXT_CUSTOM_NO');?>
</h3>
		       <?php echo $_smarty_tpl->tpl_vars['tariff_text']->value;?>

		     </div>
		</div>
		</form>
		
        <h4><b><?php echo @constant('TEXT_ITEMS_REVIEW');?>
</b></h4>
        <div class="clearfix"></div>
        <div class="items">
        	<a href="javascript:void(0);" class="view_details"><?php echo @constant('TEXT_PRODUCT_DETAILS');?>
<!-- (<?php echo $_smarty_tpl->tpl_vars['total_num']->value;?>
) --><ins class="icon_arrow_up"></ins></a>
        	<div class="jq_detail_items display_none">
	          	<p class="total"><?php echo @constant('TEXT_CART_TOTAL_PRODUCT_PRICE');?>
: <b class="price_color"><?php echo $_smarty_tpl->tpl_vars['total_price']->value;?>
</b></p>
	          	<ul class="shopcart_ul">
	          		<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['pinfo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
		            <li>
		              	<p class="cartpro_name"><?php echo $_smarty_tpl->tpl_vars['p']->value['name'];?>
[<?php echo $_smarty_tpl->tpl_vars['p']->value['model'];?>
]</p>
		              	<div class="pro_img"><?php echo $_smarty_tpl->tpl_vars['p']->value['image'];?>
<?php if ($_smarty_tpl->tpl_vars['p']->value['discount']){?><span class="cart_discount"><?php echo $_smarty_tpl->tpl_vars['p']->value['discount'];?>
% <?php echo @constant('TEXT_OFF');?>
</span><?php }?></div>
		              	<div class="pro_price">
			                <p>
			                	<span><?php echo @constant('TEXT_PRICE_WORDS');?>
:</span>
			                	<?php if ($_smarty_tpl->tpl_vars['p']->value['oprice']!=$_smarty_tpl->tpl_vars['p']->value['price']){?>
			                	<del><?php echo $_smarty_tpl->tpl_vars['p']->value['oprice'];?>
</del><br />
								<?php }?>
			                  	<?php echo $_smarty_tpl->tpl_vars['p']->value['price'];?>

			                </p>
			                <p><span><?php echo @constant('TABLE_HEADING_QUANTITY');?>
:</span> <span><?php echo $_smarty_tpl->tpl_vars['p']->value['qty'];?>
 <?php echo @constant('TEXT_PACKET_2');?>
</span> </p>
			                <p><span><?php echo @constant('TEXT_ORDER_INFO_SUBTOTAL');?>
:</span> <?php echo $_smarty_tpl->tpl_vars['p']->value['total'];?>
</p>
		              	</div>
		              	<div class="clearfix"></div>
		              	<?php if ($_smarty_tpl->tpl_vars['p']->value['is_preorder']){?><p class="avalaible">
							<?php if ($_smarty_tpl->tpl_vars['p']->value['products_stocking_days']>7){?>
				                <?php echo @constant('TEXT_AVAILABLE_IN715');?>

				            <?php }else{ ?>
				                <?php echo @constant('TEXT_AVAILABLE_IN57');?>

				            <?php }?>
                           </p><?php }?>
		            </li>
		            <?php } ?>
	          	</ul>
	          	<?php if ($_smarty_tpl->tpl_vars['cart_fen_ye_bottom']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['cart_fen_ye_bottom']->value;?>
<?php }?>
				<div class="bottom_arrow">
					<div class="bottom_background">
						<ins></ins>
					</div>
				</div>
          	</div>
        </div>
		<div class="items_coupon">
	        <h3><?php echo @constant('TEXT_DISCOUNT_COUPOU');?>
</h3>
            <?php echo $_smarty_tpl->tpl_vars['add_coupon_str']->value;?>

            <?php if ($_smarty_tpl->tpl_vars['coupon_display']->value){?>
				<?php if (count($_smarty_tpl->tpl_vars['coupon_select']->value)>0){?>
					<?php if (count($_smarty_tpl->tpl_vars['show_coupon']->value)>0){?>
						<div class="couponSelect" conpon_id="<?php echo $_smarty_tpl->tpl_vars['show_coupon']->value['coupon_to_customer_id'];?>
" onclick="saveAddressInfo('index.php?main_page=checkout&pn=cm');">
							<span class="couponContent">
								<span class="couponDesc"><?php echo $_smarty_tpl->tpl_vars['show_coupon']->value['coupon_description'];?>
</span>
								<span class="couponDate" align="center"><?php echo $_smarty_tpl->tpl_vars['show_coupon']->value['coupon_start_time_format'];?>
 - <?php echo $_smarty_tpl->tpl_vars['show_coupon']->value['deadlineformat'];?>
</span>
							</span>
							<span class="couponArrow">
								<img class="" src="/includes/templates/mobilesite/css/<?php echo $_SESSION['languages_code'];?>
/images/method_arrow.png" />
							</span>
						</div>
					<?php }else{ ?>
						<div class="couponSelect"  onclick="saveAddressInfo('index.php?main_page=checkout&pn=cm');">
							<span class="couponContent">
								<span class="couponDesc"><?php echo @constant('TEXT_DISCOUNT_COUPON_NULL');?>
</span>
								<span class="couponDate" align="center">&nbsp;</span>
							</span>
							<span class="couponArrow">
								<img class="" src="/includes/templates/mobilesite/css/<?php echo $_SESSION['languages_code'];?>
/images/method_arrow.png" />
							</span>
						</div>
					<?php }?>
				<?php }else{ ?>
					<div class="no_use_coupon"  onclick="saveAddressInfo('index.php?main_page=checkout&pn=cm');">
						<span class="couponContent">
							<span class="couponDesc"><?php echo @constant('TEXT_DISCOUNT_COUPON_NO_USE');?>
</span>
							<span class="couponDate" align="center">&nbsp;</span>
						</span>
						<span class="couponArrow">
							<img class="" src="/includes/templates/mobilesite/css/<?php echo $_SESSION['languages_code'];?>
/images/method_arrow.png" />
						</span>
					</div>
				<?php }?>
			<?php }?>
	  	</div>
	  	
		
		<div class="bottom_total">
        	<h3><?php echo @constant('TEXT_ORDER_SUMMARY');?>
</h3>
        	<?php echo $_smarty_tpl->tpl_vars['order_total_str']->value;?>

        </div>

        <div class="total_tip">
	        <p><span class="price_color">* </span><?php echo @constant('TEXT_REORDER_PACKING_TIPS');?>
</p>
	        <p>
	          	<label><input type="radio" name="packingway" id="pack1" value="1" /><?php if ($_SESSION['packing_tips_choose']==3){?><?php echo @constant('TEXT_REORDER_PACKING_WAY_FOUR');?>
<?php }else{ ?><?php echo @constant('TEXT_REORDER_PACKING_WAY_ONE');?>
<?php }?></label>
	          	<br />
	          	<label><input type="radio" name="packingway" id="pack2" value="2"/><?php if ($_SESSION['packing_tips_choose']==3){?><?php echo @constant('TEXT_REORDER_PACKING_WAY_FIVE');?>
<?php }else{ ?><?php echo @constant('TEXT_REORDER_PACKING_WAY_TWO');?>
<?php }?></label>
	          	<br />
	        </p>
	        <div class="tip_msg packchoice_tips"><a href="javascript:void(0);" class="grey_9"><?php echo @constant('TEXT_EXTRA_TIPS');?>
</a>
	         	<p class="packchoicetips"><ins></ins><?php echo @constant('TEXT_EXTAR_SHIPPING_FEE');?>
</p>
	        </div>
      </div>

        <div class="cart_btn checkout-review">
			<a href="javascript:void(0);" class="btn_big btn_ltblue jq_order_submit" id="continuenext"><?php echo @constant('TEXT_PLACE_YOUR_ORDER');?>
</a>
			<a href="<?php echo $_smarty_tpl->tpl_vars['shoppingcart_default_url']->value;?>
" class="btn_big btn_grey"><?php echo @constant('TEXT_BACK');?>
</a>
	        <input type="hidden" name="address_id" value="<?php echo $_SESSION['sendto'];?>
">
	        <input type="hidden" name="shipping_code" value="<?php echo $_SESSION['shipping']['code'];?>
">
		</div>
		
    	
    </div>
</div>
<div class="packchoice-tips"><p><?php echo @constant('TEXT_ERROR_PACKING_TIPS');?>
</p></div>
<?php }?><?php }} ?>