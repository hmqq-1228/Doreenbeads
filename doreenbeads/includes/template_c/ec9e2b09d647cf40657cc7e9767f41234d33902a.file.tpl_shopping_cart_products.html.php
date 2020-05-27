<?php /* Smarty version Smarty-3.1.13, created on 2020-04-16 10:25:26
         compiled from "includes\templates\checkout\tpl_shopping_cart_products.html" */ ?>
<?php /*%%SmartyHeaderCode:175225e68ba51e75890-68503829%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec9e2b09d647cf40657cc7e9767f41234d33902a' => 
    array (
      0 => 'includes\\templates\\checkout\\tpl_shopping_cart_products.html',
      1 => 1587003405,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '175225e68ba51e75890-68503829',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e68ba52af8422_57808314',
  'variables' => 
  array (
    'cart_products_out_stoct_errors' => 0,
    'cart_products_down_errors' => 0,
    'products_num' => 0,
    'cart_has_buy_facebook_like_product_errors' => 0,
    'messageStack' => 0,
    'message' => 0,
    'history_amount' => 0,
    'cNextVipInfo' => 0,
    'width_vip_li' => 0,
    'channel_status' => 0,
    'cVipInfo' => 0,
    'coupon_array' => 0,
    'value' => 0,
    'is_checked_all' => 0,
    'total_weight' => 0,
    'total_items' => 0,
    'is_checked_count' => 0,
    'total_amount_convert' => 0,
    'cart_sort_type' => 0,
    'cart_sort_by' => 0,
    'product_array' => 0,
    'k' => 0,
    'cate_id' => 0,
    'cate_total_arr' => 0,
    'gift_id' => 0,
    'languages_id' => 0,
    'cart_fen_ye' => 0,
    'original_prices' => 0,
    'total_amount_original' => 0,
    'total_amount_discount' => 0,
    'discounts' => 0,
    'discounts_format' => 0,
    'manjian_discount' => 0,
    'promotion_discount_full_set_minus_title' => 0,
    'promotion_discount_full_set_minus_content' => 0,
    'promotion_discount' => 0,
    'promotion_discount_format' => 0,
    'vip_content' => 0,
    'rcd_discount' => 0,
    'show_current_discount' => 0,
    'prom_discount' => 0,
    'prom_discount_title' => 0,
    'prom_discount_format' => 0,
    'tenoff' => 0,
    'is_handing_fee' => 0,
    'handing_fee' => 0,
    'special_discount_title' => 0,
    'special_discount_content' => 0,
    'shipping_content' => 0,
    'shipping_method_by' => 0,
    'total_all' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e68ba52af8422_57808314')) {function content_5e68ba52af8422_57808314($_smarty_tpl) {?><div class="shopping_cart_main_content">
	
	<?php if ($_smarty_tpl->tpl_vars['cart_products_out_stoct_errors']->value!=''){?>
	<div class="shopping_cart_products_error"><?php echo $_smarty_tpl->tpl_vars['cart_products_out_stoct_errors']->value;?>
</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['cart_products_down_errors']->value!=''&&$_smarty_tpl->tpl_vars['products_num']->value==0){?>
	<div class="shopping_cart_products_error"><?php echo $_smarty_tpl->tpl_vars['cart_products_down_errors']->value;?>
</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['cart_has_buy_facebook_like_product_errors']->value!=''){?>
	<div class="shopping_cart_products_error"><?php echo $_smarty_tpl->tpl_vars['cart_has_buy_facebook_like_product_errors']->value;?>
</div>
	<?php }?>
	
	<div class="carttopbtn">		
		<a href="<?php echo $_SESSION['prev_url'];?>
"  class="continue_shop"><span><ins></ins><?php echo @constant('TEXT_CART_CONTINUE_SHOPPING');?>
</span></a>		
		<?php if ($_smarty_tpl->tpl_vars['messageStack']->value->size('addwishlist')>0){?>
		<?php echo $_smarty_tpl->tpl_vars['messageStack']->value->output('addwishlist');?>

		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['products_num']->value!=0){?>
		<a href="javascript:void(0);" class="jq_checkbtn checkout" data-yes="<?php echo @constant('TEXT_YES');?>
" data-no="<?php echo @constant('TEXT_ORDER_CANCELED');?>
"><span><?php echo @constant('TEXT_CART_CHECKOUT');?>
<ins></ins></span></a>
		<div  style="float: right;margin-right: 30px;">
			<a style="display:none;" class="jq_paypal_quick_payment jq_paypalwpp" data-url="<?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_http_server'];?>
/ipn_main_handler.php?action=setexpresscheckout&ec_cancel=1" href="javascript:void(0);">
			<img align="absmiddle" src="<?php echo @constant('HTTP_SERVER');?>
/includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>
/btn_xpressCheckout_01.png">
			</a>
			<font style="margin-left: 25px; display:none;">-- <?php echo @constant('TEXT_SHOPPING_CART_OR');?>
 --</font>
			<input type="hidden" value="0" id="paypal_ec" name="paypal_ec">
		</div>
		<?php }?>
		<div class="clearBoth"></div>
	</div>
    
    <div class="caption_shopgray">
	   	<h3><?php echo @constant('TEXT_CART_MY_CART');?>
</h3>
	   	<?php if ($_SESSION['customer_id']!=''){?>
		<div class="level">
	        <ul>
				<?php if ($_smarty_tpl->tpl_vars['history_amount']->value<5000){?>
					<?php if ($_smarty_tpl->tpl_vars['cNextVipInfo']->value['group_percentage']!=15){?>
					<li class="next_level"><span><strong><?php echo $_smarty_tpl->tpl_vars['cNextVipInfo']->value['customer_group'];?>
</strong>(<?php echo $_smarty_tpl->tpl_vars['cNextVipInfo']->value['group_percentage'];?>
% <?php echo @constant('TEXT_CART_OFF');?>
)</span></li>           	
					<li class="<?php if ($_smarty_tpl->tpl_vars['history_amount']->value==0){?>schedule_null<?php }else{ ?>schedule<?php }?>"><span style="width:<?php echo $_smarty_tpl->tpl_vars['width_vip_li']->value;?>
%;"><ins><?php echo $_smarty_tpl->tpl_vars['history_amount']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['cNextVipInfo']->value['max_amt'];?>
 (US $)</ins></span></li>
					<?php }?>
				<?php }?>
	            <li class="current">
	            	<span><?php if (!$_smarty_tpl->tpl_vars['channel_status']->value){?><strong><?php echo $_smarty_tpl->tpl_vars['cVipInfo']->value['customer_group'];?>
</strong>(<?php }?><?php echo $_smarty_tpl->tpl_vars['cVipInfo']->value['group_percentage'];?>
% <?php echo @constant('TEXT_CART_OFF');?>
<?php if (!$_smarty_tpl->tpl_vars['channel_status']->value){?>)<?php }?></span>
	            </li>
	            <li><?php echo @constant('TEXT_CART_MY_VIP');?>
:</li>
	        </ul>
	   	</div>
	   	<?php }?>
	</div>
	
    <?php if ($_smarty_tpl->tpl_vars['products_num']->value!=0){?>
    <form action='<?php echo @constant('HTTPS_SERVER');?>
/index.php?main_page=shopping_cart' method='post' name="shopping_cart_form">
    <!-- my cart table -->
    <div class="shopcart_operate">
    	<?php if (sizeof($_smarty_tpl->tpl_vars['coupon_array']->value)>0){?>
    	<a href="javascript:void(0);" style="float:left;" class="jq_show_successtips_coupon"><?php echo @constant('TEXT_MY_AVTIVE_COUPONS');?>
</a>
    	<div class="successtips_coupon">
			<span class="bot"></span>
			<span class="top"></span>
			<p><?php echo @constant('TEXT_SHOPPING_CART_COUPON_TIPS');?>
</p>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
			    	<th width="40%"><?php echo @constant('TEXT_COUPON_CODE');?>
</th>
			    	<th width="25%"><?php echo @constant('TEXT_COUPON_PAR_VALUE');?>
</th>
			    	<th width="35%"><?php echo @constant('TEXT_COUPON_MIN_ORDER');?>
</th>
			    </tr>
			    <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['coupon_array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
			    <tr>
			    	<td><?php echo $_smarty_tpl->tpl_vars['value']->value['coupon_code'];?>
</td>
			    	<td><?php echo $_smarty_tpl->tpl_vars['value']->value['coupon_amount'];?>
</td>
			    	<td><?php echo $_smarty_tpl->tpl_vars['value']->value['coupon_minimum_order'];?>
</td>
			    </tr>
			    <?php } ?>
			</table>
		</div>
		<?php }?>
    	<a href="javascript:void(0);" class="jq_move_all_to_wishlist" data-yes="<?php echo @constant('TEXT_YES');?>
" data-no="<?php echo @constant('TEXT_ORDER_CANCELED');?>
" data-confirm="<?php echo @constant('TEXT_CART_JS_MOVE_ALL');?>
"><?php echo @constant('TEXT_CART_MOVE_WISHLIST');?>
</a>
    	<a href="javascript:void(0);" class="empty_cart" data-yes="<?php echo @constant('TEXT_YES');?>
" data-no="<?php echo @constant('TEXT_ORDER_CANCELED');?>
"><?php echo @constant('TEXT_CART_EMPTY_CART');?>
</a>
    </div>

    <table width="1000" border="0" cellspacing="0" cellpadding="0" class="shopcart_content shopcart1">
      <tr>
    <th scope="col" width="170" style="border-left:#d2dfb3 1px solid;">
	<input type="checkbox" class="jq_products_checked" data-type="all" value="0" style="width:14px; margin:2px 3px 0 14px;" <?php if ($_smarty_tpl->tpl_vars['is_checked_all']->value==1){?> checked="checked"<?php }?> /><span style="float:left; margin:2px 3px 0 5px;"><?php echo @constant('TEXT_ALL');?>
 &nbsp;&nbsp;&nbsp;<?php echo @constant('TEXT_CART_P_IMG');?>
</span>
	</th>
    <th scope="col" width="35"><?php echo @constant('TEXT_CART_P_NUMBER');?>
</th>
    <th scope="col" width="80"><?php echo @constant('TEXT_CART_P_WEIGHT');?>
</th>
    <th scope="col" width="200"><?php echo @constant('TEXT_CART_P_NAME');?>
</th>
    <th scope="col" width="105"><?php echo @constant('TEXT_CART_P_PRICE');?>
</th>
    <th scope="col" width="130"><?php echo @constant('TEXT_CART_P_QTY');?>
</th>
    <th scope="col" width="140"><?php echo @constant('TEXT_CART_P_SUBTOTAL');?>
</th>
    <th scope="col" width="140" style="border-right:#d2dfb3 1px solid;">&nbsp;</th>
  </tr>
 <tr class="top_total">
    <td colspan="5">
    <?php echo @constant('TEXT_PRODUCT_WEIGHT');?>
: <strong class="total_weight"><?php echo $_smarty_tpl->tpl_vars['total_weight']->value;?>
</strong> <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>

    <span class="view_shippping_weight">(<?php echo @constant('TEXT_VIEW_SHIPPING_WEIGHT');?>
)    
    <div class="successtips_weight">
		<span class="bot"></span>
		<span class="top"></span>
		<?php echo @constant('TEXT_SHIPPING_COST_IS_CAL_BY');?>

		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
		    	<td style="border-bottom:#d0d1a9 1px solid; border-right:#d0d1a9 1px solid;" width="60%"><?php echo @constant('TEXT_PRODUCT_WEIGHT');?>
</td>
		        <td style="border-bottom:#d0d1a9 1px solid;"><font class="view_weight_1"><?php echo $_smarty_tpl->tpl_vars['total_weight']->value;?>
</font> <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>
</td>
		    </tr>
			<tr class="show_volume_weight_tr">
			</tr>
		    <tr>
		    	<td style="border-bottom:#d0d1a9 1px solid; border-right:#d0d1a9 1px solid;"><?php echo @constant('TEXT_WORD_PACKAGE_BOX_WEIGHT');?>
</td>
		        <td style="border-bottom:#d0d1a9 1px solid;" class="show_package_box_weight_td"><font class="view_weight_2"><?php if ($_smarty_tpl->tpl_vars['total_weight']->value>50000){?><?php echo $_smarty_tpl->tpl_vars['total_weight']->value*0.06;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['total_weight']->value*0.1;?>
<?php }?></font> <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>
</td>
		    </tr>
		    <tr>
		    	<td style="border-bottom:#d0d1a9 1px solid; border-right:#d0d1a9 1px solid;"><?php echo @constant('TEXT_WORD_SHIPPING_WEIGHT');?>
</td>
		        <td style="border-bottom:#d0d1a9 1px solid;" class="shipping_total_weight_td"><font class="view_weight_3"><?php if ($_smarty_tpl->tpl_vars['total_weight']->value>50000){?><?php echo $_smarty_tpl->tpl_vars['total_weight']->value*1.06;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['total_weight']->value*1.1;?>
<?php }?></font> <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>
</td>
		    </tr>
		</table>
	</div>
    </span>
      
    </td>
    <td colspan="4"><?php echo @constant('TEXT_CART_WORD_TOTAL');?>
: <strong class="jq_total_items"><?php echo $_smarty_tpl->tpl_vars['total_items']->value;?>
</strong> <?php echo @constant('TEXT_CART_ITEMS');?>
 &nbsp;&nbsp;&nbsp;<?php echo @constant('TEXT_CART_WORD_SELECTED');?>
: <strong class="jq_is_checked_count"><?php echo $_smarty_tpl->tpl_vars['is_checked_count']->value;?>
</strong> <?php echo @constant('TEXT_CART_ITEMS');?>
 &nbsp;&nbsp;&nbsp;<?php echo @constant('TEXT_CART_AMOUNT');?>
: <strong class="subtotal_amount"><?php echo $_smarty_tpl->tpl_vars['total_amount_convert']->value;?>
</strong></td>
  </tr>
  <tr>
  <td colspan="8">
	
	<a href="index.php?main_page=shopping_cart&sort_by=customers_basket_id&sort_type=<?php if ($_smarty_tpl->tpl_vars['cart_sort_type']->value=='desc'){?>asc<?php }else{ ?>desc<?php }?>">
		<div class="<?php if ($_smarty_tpl->tpl_vars['cart_sort_by']->value=='customers_basket_id'&&$_smarty_tpl->tpl_vars['cart_sort_type']->value=='desc'){?>newest_ndn<?php }elseif($_smarty_tpl->tpl_vars['cart_sort_by']->value=='customers_basket_id'&&$_smarty_tpl->tpl_vars['cart_sort_type']->value=='asc'){?>newest_nup<?php }else{ ?>newest_pup<?php }?>">
			<span><?php echo @constant('TEXT_DATE_ADDED');?>
</span><span style="width:18px; height:18px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		</div>
	</a>

	<a href="index.php?main_page=shopping_cart&sort_by=products_model&sort_type=<?php if ($_smarty_tpl->tpl_vars['cart_sort_type']->value=='desc'){?>asc<?php }else{ ?>desc<?php }?>">
		<div class="<?php if ($_smarty_tpl->tpl_vars['cart_sort_by']->value=='products_model'&&$_smarty_tpl->tpl_vars['cart_sort_type']->value=='desc'){?>newest_ndn<?php }elseif($_smarty_tpl->tpl_vars['cart_sort_by']->value=='products_model'&&$_smarty_tpl->tpl_vars['cart_sort_type']->value=='asc'){?>newest_nup<?php }else{ ?>newest_pup<?php }?>">
			<span><?php echo @constant('TEXT_CART_P_NUMBER');?>
</span><span style="width:18px; height:18px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		</div>
	</a>
  </td>
  </tr>	
	<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['product_array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
	<?php if (count($_SESSION['delete_products'])!=0&&$_SESSION['delete_products']['index_num']==$_smarty_tpl->tpl_vars['k']->value){?>
		<tr class="del_cart_product"><td colspan="8"><a href="<?php echo $_SESSION['delete_products']['pro_href'];?>
" target="_blank" class="textcolor"><?php echo substr($_SESSION['delete_products']['pro_name_all'],'0','40');?>
...(<?php echo $_SESSION['delete_products']['pro_model'];?>
)</a> <?php echo @constant('HAS_BEEN_REMOVED');?>
 <a class="textcolor" href="javascript:void(0)" onclick="readd_product(<?php echo $_SESSION['delete_products']['products_id'];?>
,<?php echo $_SESSION['delete_products']['del_qty'];?>
);"> <?php echo @constant('RE_ADD');?>
 </a></td></tr>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['value']->value['cate']&&$_smarty_tpl->tpl_vars['cart_sort_by']->value=='cate'){?>
	<?php $_smarty_tpl->tpl_vars["cate_id"] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value['cate_id'], null, 0);?>
	<tr class="thead">
		<td colspan="6" class="cate-tit"><?php echo $_smarty_tpl->tpl_vars['value']->value['cate_name'];?>
</td>
		<td colspan="2" class="cate-total"><span class="totalprice"><span id="cate_total_<?php echo $_smarty_tpl->tpl_vars['cate_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['cate_total_arr']->value[$_smarty_tpl->tpl_vars['cate_id']->value];?>
</span></span></td>
	</tr>
	<?php }?>
	
		<td>
			<div class="num">
            <input type="checkbox" class="jq_products_checked" data-type="single" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
" style="width:14px; margin-top:-3px;" <?php if ($_smarty_tpl->tpl_vars['value']->value['is_checked']==1){?> checked="checked"<?php }?> />
            <?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
.<input type="hidden" name="pro_id[]" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"></div>
            <div class="orderimg">
				<div class="maximg jq_products_image_detail_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" style="display:none;">
					<s></s>
					<span></span>
					<img class="jq_products_image_src_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" />
				</div>

				<?php if ($_smarty_tpl->tpl_vars['value']->value['discount']>0){?>
				<div class="discountprice"><?php if (($_SESSION['languages_id']=='2'||$_SESSION['languages_id']=='3'||$_SESSION['languages_id']=='4')){?>-<?php echo $_smarty_tpl->tpl_vars['value']->value['discount'];?>
%<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['value']->value['discount'];?>
%<br>off<?php }?><br/></div>
				<?php }?>
				<p><?php if ($_smarty_tpl->tpl_vars['value']->value['id']!=$_smarty_tpl->tpl_vars['gift_id']->value&&!$_smarty_tpl->tpl_vars['value']->value['is_gift']){?><a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_link'];?>
"><?php }?><?php echo $_smarty_tpl->tpl_vars['value']->value['product_image'];?>
<?php if ($_smarty_tpl->tpl_vars['value']->value['id']!=$_smarty_tpl->tpl_vars['gift_id']->value&&!$_smarty_tpl->tpl_vars['value']->value['is_gift']){?></a><?php }?></p>
            </div>
        </td>
        <td style="position:relative;">
        	<?php echo $_smarty_tpl->tpl_vars['value']->value['model'];?>

			<span style="<?php if ($_smarty_tpl->tpl_vars['value']->value['qty']<=$_smarty_tpl->tpl_vars['value']->value['pp_max_num_per_order']){?>display:none;<?php }?>" class="show_promotion_num_tips jq_show_promotiom_tips_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['max_num_per_order_tips'];?>
</span>
        </td>
        <td align="center">
	        <?php echo $_smarty_tpl->tpl_vars['value']->value['weight'];?>
 <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>

	        <?php if ($_smarty_tpl->tpl_vars['value']->value['volume_weight']!=0){?>
	    	<div class="volweight"><a href="<?php echo @constant('HTTP_SERVER');?>
/index.php?main_page=page&id=21#P5" target="_blank"><?php echo @constant('TEXT_CART_P_V_WEIGHT');?>
</a>: <?php echo $_smarty_tpl->tpl_vars['value']->value['volume_weight'];?>
 <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>
</div>
	    	<?php }?>
    	</td>
        <td class="gift_name">
		<?php if ($_smarty_tpl->tpl_vars['value']->value['id']!=$_smarty_tpl->tpl_vars['gift_id']->value&&!$_smarty_tpl->tpl_vars['value']->value['is_gift']){?><a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_name_all'];?>
" class="textcolor"><?php }?><?php echo $_smarty_tpl->tpl_vars['value']->value['product_name'];?>
<?php if ($_smarty_tpl->tpl_vars['value']->value['id']!=$_smarty_tpl->tpl_vars['gift_id']->value&&!$_smarty_tpl->tpl_vars['value']->value['is_gift']){?></a><?php }?>
		<div class="clearfix"></div>
		<div style="color:#999;" class="jq_is_preorder_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
">
			<?php if ($_smarty_tpl->tpl_vars['value']->value['is_s_level_product']==1){?>

			<?php }else{ ?>
				<?php if ($_smarty_tpl->tpl_vars['value']->value['is_preorder']){?>
				    <?php if ($_smarty_tpl->tpl_vars['value']->value['products_stocking_days']>7){?>
				        <?php echo @constant('TEXT_AVAILABLE_IN715');?>

				    <?php }else{ ?>
				        <?php echo @constant('TEXT_AVAILABLE_IN57');?>

				    <?php }?>
				<?php }?>
			<?php }?>
		</div>

		<div style="color:#999;" class="jq_qty_update_tips_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
">
		<?php echo $_smarty_tpl->tpl_vars['value']->value['products_qty_update_auto_note'];?>

		</div>

		</td>
        <td align="center">        
        	<del style="<?php if ($_smarty_tpl->tpl_vars['value']->value['original_price']==$_smarty_tpl->tpl_vars['value']->value['price']){?>display:none;<?php }?>" class="oprice_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"> <?php echo $_smarty_tpl->tpl_vars['value']->value['original_price'];?>
</del>
	    	<span class="price_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['price'];?>
</span>
        </td>
        <td>
			<div class="update_num">
				<p class="qty_content">
				<?php if ($_smarty_tpl->tpl_vars['value']->value['id']==$_smarty_tpl->tpl_vars['gift_id']->value||$_smarty_tpl->tpl_vars['value']->value['is_gift']){?>
					<input  name="product_qty" type="number" min="1" max="99999" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" style="margin-left:26px;" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['qty'];?>
" onpaste="return false" readonly="true"/>
					<input name="product_qty_old" id="qty_old_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['qty'];?>
" />
					<input name="product_quantity" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_quantity'];?>
" />
					<input name="product_model" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['model'];?>
" />
					<input name="product_id" id="id_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" />
				<?php }else{ ?>
					<span class="icon_decrease"></span>
					<input name="product_qty" type="number" min="1" max="99999" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" id="qty_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['qty'];?>
" onpaste="return false" maxlength="5" />
					<span class="icon_increase"></span>
					<input name="product_qty_old" id="qty_old_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['qty'];?>
" />
					<input name="product_quantity" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_quantity'];?>
" />
					<input name="product_model" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['model'];?>
" />
					<input name="product_id" id="id_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" />
				<?php }?>	
				</p>
				<div class="successtips_update">
					<span class="bot"></span>
					<span class="top"></span>
					<p class="update_qty_note"><?php echo $_smarty_tpl->tpl_vars['value']->value['update_qty_note'];?>
</p>
				</div>  
			</div>
        </td>
        <td><span class="totalprice"><span class="total_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['total'];?>
</span></span></td>
        <td align="center">
			<a class="jq_icon_collect textcolor" href="javascript:void(0);" data-confirm="<?php echo @constant('TEXT_CART_JS_MOVE_TO_WISHLIST');?>
" id="wish_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo @constant('TEXT_MOVE_TO_WISHLIST');?>
</a>
        	<br/>
        	<a href="javascript:void(0)" class="jq_icon_delete textcolor" pid="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" data-index="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" title="<?php echo @constant('TEXT_DELETE');?>
"><?php echo @constant('TEXT_DELETE');?>
</a>
        	
        	<!-- <div id="products_notes" style="position: absolute;width: 60px;">
        					<?php if ($_smarty_tpl->tpl_vars['value']->value['note']!=''){?>
        						<span id="products_note_<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
" class="products_note_in"></span>
        					<?php }else{ ?>
        						<span id="products_note_<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
" class="products_note"></span>
        					<?php }?>		
        					<div class="products_note_tips" style="border: 1px solid #D0D1A9;border-radius: 0px;padding: 0px 0px;position: relative;height: auto;width: 300px;left: -150px;top: 10px;background: none repeat scroll 0 0 #FFFFCC;display:none;z-index:1">
        						<span class="bot" style="position: absolute;top:-16px;left: 190px;border-color: rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) #D0D1A9;border-style: dashed dashed solid;border-width: 8px;"></span>
        						<span class="top" style="position: absolute;top:-15px;left: 190px;border-color: rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) #FFFFCC;border-style: dashed dashed solid;border-width: 8px;"></span>
        						<div id="products_note_tips_<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['note'];?>
</div>
        					</div>
        					<div class="pricetips" style="border: 1px solid #bbbbbb; padding:10px;border-radius: 0px;position: relative;height: 170px;width: 450px;left: -360px;top: 10px;background: #ffffff;">
        						<span class="bot" style="left: 380px;"></span>
        						<span class="top" style="left: 380px;"></span>
        						<textarea id="basket_note_<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
" name="basket_note" wrap="soft" style="resize:none;height: 120px;width: 450px;" onkeyup="keypress(<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
)" onkeypress="return(this.value.length<254)" onblur="this.value = this.value.substring(0, 254)"><?php echo $_smarty_tpl->tpl_vars['value']->value['note'];?>
</textarea>
        						<div  style="text-align: left;margin-right: 10px;margin-top: 10px;">
        								<?php if ($_smarty_tpl->tpl_vars['languages_id']->value==3){?>
        								<button class="btn_yellow save_note" aid="<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
">
        									<span style="width: 120px; overflow: auto;position: relative;"><strong style="padding: 0 0 0 10px;"><?php echo @constant('TEXT_QUESTION_SUBMIT');?>
</strong></span>
        								</button>
        								<?php }else{ ?>
        								<button class="btn_yellow save_note" aid="<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
">
        									<span style="width: 80px; overflow: auto;position: relative;"><strong style="padding: 0 0 0 10px;"><?php echo @constant('TEXT_QUESTION_SUBMIT');?>
</strong></span>
        								</button>
        								<?php }?>
        								<button class="btn_grey cancel_note">
        									<span style="width: 80px;margin-top: 2px;overflow: auto;position: relative;"><strong style="min-width: 0px;"><?php echo @constant('CHECKOUT_ADDRESS_BOOK_CANCEL');?>
</strong></span>
        								</button>
        								<label class="save_note_tpis_<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
 save_note_tpis"><font color="red">*</font><?php echo @constant('TEXT_NOTE_MAXCHAAR');?>
</label>
        						</div>				
        					</div>
        				</div> -->
        </td>
	</tr>
	<?php if (count($_SESSION['delete_products'])!=0&&$_SESSION['delete_products']['index_num']==$_smarty_tpl->tpl_vars['k']->value+1&&$_SESSION['delete_products']['index_num']==count($_smarty_tpl->tpl_vars['product_array']->value)){?>
		<tr class="del_cart_product"><td colspan="8"><a href="<?php echo $_SESSION['delete_products']['pro_href'];?>
" target="_blank" class="textcolor"><?php echo substr($_SESSION['delete_products']['pro_name_all'],'0','40');?>
...(<?php echo $_SESSION['delete_products']['pro_model'];?>
)</a> <?php echo @constant('HAS_BEEN_REMOVED');?>
 <a class="textcolor" href="javascript:void(0)" onclick="readd_product(<?php echo $_SESSION['delete_products']['products_id'];?>
,<?php echo $_SESSION['delete_products']['del_qty'];?>
);"> <?php echo @constant('RE_ADD');?>
 </a></td></tr>
	<?php }?>
	<?php } ?>
    </table>
    <?php echo $_smarty_tpl->tpl_vars['cart_fen_ye']->value;?>

	</form>
	<?php if ($_smarty_tpl->tpl_vars['cart_products_down_errors']->value!=''){?>
	<div class="shopping_cart_products_error"><?php echo $_smarty_tpl->tpl_vars['cart_products_down_errors']->value;?>
</div>
	<?php }?>
	<div class="orderdetailpage">
	<span><?php echo @constant('TEXT_PRODUCT_WEIGHT');?>
: <strong class="total_weight"><?php echo $_smarty_tpl->tpl_vars['total_weight']->value;?>
</strong> <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>
</span>
	<span class="view_shippping_weight">(<?php echo @constant('TEXT_VIEW_SHIPPING_WEIGHT');?>
)    
		<div class="successtips_weight">
			<span class="bot"></span>
			<span class="top"></span>
			<?php echo @constant('TEXT_SHIPPING_COST_IS_CAL_BY');?>

			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
			    	<td style="border-bottom:#d0d1a9 1px solid; border-right:#d0d1a9 1px solid;" width="60%"><?php echo @constant('TEXT_PRODUCT_WEIGHT');?>
</td>
			        <td style="border-bottom:#d0d1a9 1px solid;"><font class="view_weight_1"><?php echo $_smarty_tpl->tpl_vars['total_weight']->value;?>
</font> <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>
</td>
			    </tr>
				<tr class="show_volume_weight_tr">
			    </tr>
			    <tr>
			    	<td style="border-bottom:#d0d1a9 1px solid; border-right:#d0d1a9 1px solid;"><?php echo @constant('TEXT_WORD_PACKAGE_BOX_WEIGHT');?>
</td>
			        <td style="border-bottom:#d0d1a9 1px solid;" class="show_package_box_weight_td"><font class="view_weight_2"><?php if ($_smarty_tpl->tpl_vars['total_weight']->value>50000){?><?php echo $_smarty_tpl->tpl_vars['total_weight']->value*0.06;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['total_weight']->value*0.1;?>
<?php }?></font> <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>
</td>
			    </tr>
			    <tr>
			    	<td style="border-bottom:#d0d1a9 1px solid; border-right:#d0d1a9 1px solid;"><?php echo @constant('TEXT_WORD_SHIPPING_WEIGHT');?>
</td>
			        <td style="border-bottom:#d0d1a9 1px solid;" class="shipping_total_weight_td"><font class="view_weight_3"><?php if ($_smarty_tpl->tpl_vars['total_weight']->value>50000){?><?php echo $_smarty_tpl->tpl_vars['total_weight']->value*1.06;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['total_weight']->value*1.1;?>
<?php }?></font> <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>
</td>
			    </tr>
			</table>
		</div>
	</span>
    </div>
	<div class="total_price totalcont">
    	<div class="left">
        	<strong class="tit"><?php echo @constant('TEXT_CART_QUICK_ORDER_BY');?>
</strong>
            <p><?php echo @constant('TEXT_CART_QUICK_ORDER_BY_CONTENT');?>
</p>
            <p>
              <a href="javascript:void(0);" class="quickadd_btn"><span><?php echo @constant('TEXT_CART_QUICK_ADD_NOW');?>
<ins></ins></span></a>
            </p>
        </div>        
        <div class="details_price">
        	<dl>
            	<dt><?php echo @constant('TEXT_CART_ORIGINAL_PRICES');?>
:</dt> 
            	<dd>
            	<span class="total_amount_original"><?php echo $_smarty_tpl->tpl_vars['original_prices']->value;?>
</span>
            	<span class="cart_total_info"><a class="icon_question" href="javascript:void(0)"></a>
		        	<div class="successtips_total">
			        	<span class="bot" style="padding:0px;"></span>
						<span class="top" style="padding:0px;"></span>
						<?php echo @constant('TEXT_CART_ORIGINAL_PRICES');?>
 = <?php echo @constant('TEXT_REGULAR_AMOUNT');?>
 + <?php echo @constant('TEXT_CART_PRODUCT_DISCOUNT');?>
<br>
						<font color="#cb0000" class="cal_total_amount_convert"><?php echo $_smarty_tpl->tpl_vars['original_prices']->value;?>
 = <?php echo $_smarty_tpl->tpl_vars['total_amount_original']->value;?>
 + <?php echo $_smarty_tpl->tpl_vars['total_amount_discount']->value;?>
</font>
					</div>
				</span>
            	</dd>
            	<?php if ($_smarty_tpl->tpl_vars['discounts']->value>0){?>
            	<dt class="discount_title"><?php echo @constant('TEXT_CART_DISCOUNT');?>
:</dt>
            	<dd ><span class="discount_content">- <?php echo $_smarty_tpl->tpl_vars['discounts_format']->value;?>
</span>
            		<span class="image_down_arrow"></span>
				    <span class="image_up_arrow" style="display:none;"></span>
				</dd>
				<?php }?>
				<table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;">
					<?php if ($_smarty_tpl->tpl_vars['manjian_discount']->value>0){?>
						<tr>
							<th class="promotion_discount_full_set_minus_title"><?php echo $_smarty_tpl->tpl_vars['promotion_discount_full_set_minus_title']->value;?>
</th>
							<td class="promotion_discount_full_set_minus_content"><?php echo $_smarty_tpl->tpl_vars['promotion_discount_full_set_minus_content']->value;?>
</td>
						<tr>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['promotion_discount']->value>0){?>
						<tr>
							<th><?php echo @constant('TEXT_PROMOTION_SAVE');?>
:</th>
							<td class="promotion_discount_content">- <?php echo $_smarty_tpl->tpl_vars['promotion_discount_format']->value;?>
</td>
						</tr>
					<?php }?>
					<?php if ($_SESSION['customer_id']!=''&&$_smarty_tpl->tpl_vars['cVipInfo']->value['amount']>0){?>
						<tr>
							<th class="vip_title"><?php echo @constant('TEXT_CART_VIP_DISCOUNT');?>
(<font color="red"><?php echo $_smarty_tpl->tpl_vars['cVipInfo']->value['group_percentage'];?>
% <?php echo @constant('TEXT_DISCOUNT_OFF_SHOW');?>
</font>): </th>
							<td class="vip_content"><?php echo $_smarty_tpl->tpl_vars['vip_content']->value;?>
</td>
						</tr>
					<?php }else{ ?>
						<tr>
							<th class="vip_title"><?php echo @constant('TEXT_CART_VIP_DISCOUNT');?>
: </th>
							<td class="vip_content"><?php echo $_smarty_tpl->tpl_vars['vip_content']->value;?>
</td>
						</tr>
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['rcd_discount']->value>0){?>
						<tr>
							<th class="rcd_title">RCD(<font color="red">3% <?php echo @constant('TEXT_DISCOUNT_OFF_SHOW');?>
</font>): </th>
							<td class="rcd_content">- <span class="coupon_amount"><?php echo $_smarty_tpl->tpl_vars['show_current_discount']->value;?>
</span></td>
						</tr>
					<?php }else{ ?>
						<tr>
							<th class="rcd_title" style="display:none;">RCD(<font color="red">3% <?php echo @constant('TEXT_DISCOUNT_OFF_SHOW');?>
</font>): </th>
							<td class="rcd_content" style="display:none;">- <span class="coupon_amount"><?php echo $_smarty_tpl->tpl_vars['show_current_discount']->value;?>
</span></td>
						</tr>
					<?php }?>
					<?php if ($_SESSION['customer_id']!=''&&$_smarty_tpl->tpl_vars['prom_discount']->value>0){?>
						<tr>
							<th class="promotion_title"><?php echo $_smarty_tpl->tpl_vars['prom_discount_title']->value;?>
:</th>
							<td class="promotion_discount">-
								<span><?php echo $_smarty_tpl->tpl_vars['prom_discount_format']->value;?>
</span>
								<?php if ($_smarty_tpl->tpl_vars['tenoff']->value==1){?>
								<span class="vipoff">(10% <?php echo ucfirst(mb_strtolower(@constant('TEXT_CART_OFF'), 'UTF-8'));?>
)</span>
								<?php }?>
							</td>
						</tr>
					<?php }else{ ?>
					<tr>
						<th class="promotion_title" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['prom_discount_title']->value;?>
:</th>
						<td class="promotion_discount" style="display:none;">- 
							<span><?php echo $_smarty_tpl->tpl_vars['prom_discount_format']->value;?>
</span>
							<?php if ($_smarty_tpl->tpl_vars['tenoff']->value==1){?>
							<span class="vipoff">(10% <?php echo ucfirst(mb_strtolower(@constant('TEXT_CART_OFF'), 'UTF-8'));?>
)</span>
							<?php }?>
						</td>
					</tr>
					<?php }?>
				</table>
                  <dt class="handing_fee_title" <?php if ($_smarty_tpl->tpl_vars['is_handing_fee']->value<0){?> style="display:block" <?php }else{ ?> style="display:none" <?php }?>><?php echo @constant('TEXT_HANDING_FEE');?>
:</dt>
                  <dd <?php if ($_smarty_tpl->tpl_vars['is_handing_fee']->value<0){?>style="display:inline" <?php }else{ ?> style="display:none" <?php }?> class="handing_fee_dd"><span class="handing_fee_content"><?php echo $_smarty_tpl->tpl_vars['handing_fee']->value;?>
</span>
                  <span <?php if ($_smarty_tpl->tpl_vars['is_handing_fee']->value<0){?> style="display:inline" <?php }else{ ?> style="display:none" <?php }?> class="cart_total_infos"><a class="icon_question" href="javascript:void(0)"></a>
                  	<div class="successtips_total">
			        	<span class="bot" style="padding:0px;"></span>
						<span class="top" style="padding:0px;"></span>
					    <p><?php echo @constant('TEXT_HANDINGFEE_INFO');?>
</p>
					</div>
                  </span>
                  </dd>

            	<dt class="special_discount_title"><?php echo $_smarty_tpl->tpl_vars['special_discount_title']->value;?>
</dt>
            	<dd class="special_discount_content"><?php echo $_smarty_tpl->tpl_vars['special_discount_content']->value;?>
</dd>

                <dt><a href="javascript:void(0)" class="estShippingCost"><?php echo @constant('TEXT_CART_SHIPPING_COST');?>
: </a></dt><dd class="shipping_content"><?php echo $_smarty_tpl->tpl_vars['shipping_content']->value;?>
</dd>               
                <dt class="shippingMethodDd" style="text-align:left;"><?php echo $_smarty_tpl->tpl_vars['shipping_method_by']->value;?>
</dt>
                <dt><strong><?php echo @constant('TEXT_CART_WORD_TOTAL1');?>
:</strong></dt><dd><strong class="total_amount"><?php echo $_smarty_tpl->tpl_vars['total_all']->value;?>
</strong></dd>
            </dl>
        </div>
        <div class="clearBoth"></div>
    </div>
	<div class="carttopbtn mtop">
		<a href="javascript:void(0);" onclick="window.history.back();" class="continue_shop"><span><ins></ins><?php echo @constant('TEXT_CART_CONTINUE_SHOPPING');?>
</span></a>		
		<?php if ($_smarty_tpl->tpl_vars['products_num']->value!=0){?>
		<a href="javascript:void(0);" class="jq_checkbtn checkout" data-yes="<?php echo @constant('TEXT_YES');?>
" data-no="<?php echo @constant('TEXT_ORDER_CANCELED');?>
"><span><?php echo @constant('TEXT_CART_CHECKOUT');?>
<ins></ins></span></a>
		<div  style="float: right;margin-right: 30px;">
			<a style="display:none;" class="jq_paypal_quick_payment jq_paypalwpp" data-url="<?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_http_server'];?>
/ipn_main_handler.php?action=setexpresscheckout&ec_cancel=1" href="javascript:void(0);">
			<img align="absmiddle" src="<?php echo @constant('HTTP_SERVER');?>
/includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>
/btn_xpressCheckout_01.png">
			</a>
			<font style="margin-left: 25px; display:none;">-- <?php echo @constant('TEXT_SHOPPING_CART_OR');?>
 --</font>
			<input type="hidden" value="0" id="paypal_ec" name="paypal_ec">
		</div>
		<?php }?>
        <div class="clearBoth"></div>

		<?php if ($_SESSION['languages_code']=='en'){?>
	   <div class="paymethod_left"><img src="<?php echo @constant('HTTP_SERVER');?>
/includes/templates/cherry_zen/images/english/paypal_ad.png" width="368" height="145"></div>
	   <?php }?>
	   <div class="paymethod"><?php echo @constant('TEXT_CART_AVAILABLE_PAYMENT');?>
:&nbsp;&nbsp;<a href="page.html?id=15"><img width="415" height="20" src="includes/templates/cherry_zen/images/pay_methods.gif"></a></div>

	</div>
    
       
<!-- shopcart end -->

<?php }else{ ?>
<!-- bof my cart empty -->
<div class="cart_empty">
   	<ins class="icon_cartempty"></ins>
    <p><?php echo @constant('TEXT_CART_IS_EMPTY_DO_SHOPPING');?>
</p>
    <a href="<?php echo @constant('HTTP_SERVER');?>
"><?php echo @constant('TEXT_CART_IS_EMPTY_SHOP');?>
</a>
</div>
<hr>
<div class="total_price totalcont" style="border:0px; padding-top:0px;">
	<div class="left">
		<strong class="tit"><?php echo @constant('TEXT_CART_QUICK_ORDER_BY');?>
</strong>
		<p><?php echo @constant('TEXT_CART_QUICK_ORDER_BY_CONTENT');?>
</p>
		<p><a href="javascript:void(0);" class="quickadd_btn"><span><?php echo @constant('TEXT_CART_QUICK_ADD_NOW');?>
<ins></ins></span></a></p>
	</div>
</div>
<div class="clearBoth"></div>
<!-- eof my cart empty -->
<?php }?>
</div><?php }} ?>