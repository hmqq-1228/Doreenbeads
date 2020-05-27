<?php /* Smarty version Smarty-3.1.13, created on 2020-04-17 09:06:12
         compiled from "includes\templates\mobilesite\tpl\tpl_shopping_cart_normal.html" */ ?>
<?php /*%%SmartyHeaderCode:255965e990104f3b702-83475233%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a64658ddcc6763b997cb8edd1bee8893b3c001f9' => 
    array (
      0 => 'includes\\templates\\mobilesite\\tpl\\tpl_shopping_cart_normal.html',
      1 => 1586330285,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '255965e990104f3b702-83475233',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tpl_head' => 0,
    'messageStack' => 0,
    'cart_products_out_stoct_errors' => 0,
    'cart_products_down_errors' => 0,
    'cart_has_buy_facebook_like_product_errors' => 0,
    'prom_discount_note' => 0,
    'page' => 0,
    'total_items' => 0,
    'is_checked_count' => 0,
    'total_amount_convert' => 0,
    'total_weight' => 0,
    'shoppingcart_default_url' => 0,
    'is_checked_all' => 0,
    'currency_symbol_left' => 0,
    'cart_sort_by' => 0,
    'product_array' => 0,
    'k' => 0,
    'value' => 0,
    'cate_id' => 0,
    'cate_total_arr' => 0,
    'cart_fen_ye' => 0,
    'products_removed_array' => 0,
    'invalid_items_fen_ye' => 0,
    'original_prices' => 0,
    'discounts' => 0,
    'discounts_format' => 0,
    'promotion_discount_full_set_minus_title' => 0,
    'promotion_discount_full_set_minus_content' => 0,
    'promotion_discount_usd' => 0,
    'promotion_discount' => 0,
    'cVipInfo' => 0,
    'vip_content' => 0,
    'rcd_discount' => 0,
    'show_current_discount' => 0,
    'prom_discount' => 0,
    'prom_discount_title' => 0,
    'prom_discount_format' => 0,
    'cart_save_price_note' => 0,
    'special_discount_content' => 0,
    'special_discount_title' => 0,
    'is_handing_fee' => 0,
    'handing_fee' => 0,
    'shipping_content' => 0,
    'total_all' => 0,
    'total_amount_original' => 0,
    'shipping_method_by' => 0,
    'checkout_default_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e990105911e93_28806889',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e990105911e93_28806889')) {function content_5e990105911e93_28806889($_smarty_tpl) {?><!-- <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['tpl_head']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 -->
<div class="order_main">
	<?php if ($_smarty_tpl->tpl_vars['messageStack']->value->size('addwishlist')>0){?>
	<div class="removealltips">
		<?php echo $_smarty_tpl->tpl_vars['messageStack']->value->output('addwishlist');?>

	</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['cart_products_out_stoct_errors']->value!=''){?>
	<div class="removealltips">
		<?php echo $_smarty_tpl->tpl_vars['cart_products_out_stoct_errors']->value;?>

	</div>
	<?php }?>
	<!-- <?php if ($_smarty_tpl->tpl_vars['cart_products_down_errors']->value!=''){?>
    <div class="removealltips">
    <?php echo $_smarty_tpl->tpl_vars['cart_products_down_errors']->value;?>

    </div>
    <?php }?> -->
	<?php if ($_smarty_tpl->tpl_vars['cart_has_buy_facebook_like_product_errors']->value!=''){?>
	<div class="removealltips">
		<?php echo $_smarty_tpl->tpl_vars['cart_has_buy_facebook_like_product_errors']->value;?>

	</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['prom_discount_note']->value!=''){?>
	<div class="prompt"><?php echo $_smarty_tpl->tpl_vars['prom_discount_note']->value;?>
</div>
	<?php }else{ ?>
	<div class="prompt" style="display:none;"></div>
	<?php }?>
	<div>
		<a href="<?php echo $_SESSION['prev_url'];?>
" class="continue link_color">&lt;&lt; <?php echo @constant('TEXT_CONTINUE_SHOPPING');?>
</a>
		<div class="clearfix"></div>
	</div>

	<input type="hidden" class="split_current_page" value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
">

	<div class="shopmain">
		<p class="top_total"><?php echo @constant('TEXT_CART_WORD_TOTAL');?>
: <b class="jq_total_items price_color"><?php echo $_smarty_tpl->tpl_vars['total_items']->value;?>
</b> / <?php echo @constant('TEXT_CART_WORD_SELECTED');?>
: <b class="jq_is_checked_count price_color"><?php echo $_smarty_tpl->tpl_vars['is_checked_count']->value;?>
</b> / <?php echo @constant('TEXT_CART_AMOUNT');?>
: <b class="subtotal_amount price_color"><?php echo $_smarty_tpl->tpl_vars['total_amount_convert']->value;?>
</b>
			<span><?php echo @constant('TEXT_PRODUCT_WEIGHT');?>
: <b class="jq_total_weight"><?php echo $_smarty_tpl->tpl_vars['total_weight']->value;?>
</b> <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>
 (<a href="<?php echo $_smarty_tpl->tpl_vars['shoppingcart_default_url']->value;?>
&pn=vw"><?php echo @constant('TEXT_VIEW_SHIPPING_WEIGHT');?>
</a>)</span>
		</p>
		<div>
			<div style="float:left; width:30%; height:37px; vertical-align:text-bottom; margin-top:8px;"><label><input type="checkbox" class="jq_products_checked jq_products_checked_all" data-type="all" value="0" style="width:18px; height:18px; margin-left:5px;" <?php if ($_smarty_tpl->tpl_vars['is_checked_all']->value==1){?> checked="checked"<?php }?> />&nbsp;&nbsp;<?php echo @constant('TEXT_ALL');?>
</label></div>
			<div style="float:right; width:70%;">
				<a href='javascript:void(0);' class="add_all_wishlist link_color" data-confirm="<?php echo @constant('TEXT_CART_JS_MOVE_ALL');?>
"><?php echo @constant('TEXT_CART_MOVE_WISHLIST');?>
</a>
				<a href="javascript:void(0)" class="empty-btn empty link_color" data-confirm="<?php echo @constant('TEXT_CART_JS_EMPTY_CART');?>
"><?php echo @constant('TEXT_CART_EMPTY_CART');?>
</a>
			</div>

			<div class="clearfix"></div>
		</div>
		<!-- <h3 class="totalmoney"><?php echo @constant('TEXT_CART_WORD_TOTAL');?>
: <strong><?php echo $_smarty_tpl->tpl_vars['total_items']->value;?>
</strong> <?php echo @constant('TEXT_CART_ITEMS');?>
, <span><?php echo $_smarty_tpl->tpl_vars['currency_symbol_left']->value;?>
<strong class="subtotal_amount"><?php echo $_smarty_tpl->tpl_vars['total_amount_convert']->value;?>
</strong></span></h3>
        <h3 class="totalmoney1"><?php echo @constant('TEXT_CART_TOTAL_WEIGHT');?>
: <strong class="total_weight"><?php echo $_smarty_tpl->tpl_vars['total_weight']->value;?>
</strong> <?php echo @constant('TEXT_CART_WEIGHT_UNIT');?>
 (<a href="<?php echo $_smarty_tpl->tpl_vars['shoppingcart_default_url']->value;?>
&pn=vw"><?php echo @constant('TEXT_VIEW_SHIPPING_WEIGHT');?>
</a>)</h3>

        <h5 class="totalweight"><a href="javascript:void(0);" onclick="move_all_to_wishlist();" class="moveall-btn"><?php echo @constant('TEXT_CART_MOVE_WISHLIST');?>
</a><a href="javascript:void(0)" class="empty-btn"><?php echo @constant('TEXT_CART_EMPTY_CART');?>
</a></h5> -->

		<!-- 去除sort by category 这个功能 m V2.0.2 -->
		<!-- <?php if ($_smarty_tpl->tpl_vars['cart_sort_by']->value=='cate'){?>
              <h5 class="totalweight"><a href="<?php echo $_smarty_tpl->tpl_vars['shoppingcart_default_url']->value;?>
&sortby=time"><?php echo @constant('TEXT_SORT_BY_MODIFY_TIME');?>
</a></h5>
              <?php }else{ ?>
              <h5 class="totalweight"><a href="<?php echo $_smarty_tpl->tpl_vars['shoppingcart_default_url']->value;?>
&sortby=cate"><?php echo @constant('TEXT_SORT_BY_CATEGORY');?>
</a></h5>
              <?php }?> -->

		<!-- <div class="confirmtips-move">
            <div>
                <p><?php echo @constant('TEXT_CART_JS_MOVE_ALL');?>
</p>
                <p><a href="javascript:void(0)" class="okbtn" title="1"><?php echo @constant('TEXT_OK');?>
</a><a href="javascript:void(0)" class="cancelbtn" title="2"><?php echo @constant('TEXT_CANCEL');?>
</a></p>
            </div>
        </div> -->
		<!-- <div class="emptytips-move" style="z-index:100">
            <div>
                <p><?php echo @constant('TEXT_CART_JS_MOVE_ALL');?>
</p>
                <p><a href="javascript:void(0)" class="okbtn" title="1"><?php echo @constant('TEXT_OK');?>
</a><a href="javascript:void(0)" class="cancelbtn" title="2"><?php echo @constant('TEXT_CANCEL');?>
</a></p>
            </div>
        </div> -->

		<div class="shopcart-cont" id="shopcart-cont">
			<ul>
				<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['product_array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
				<?php if (count($_SESSION['delete_products'])!=0&&$_SESSION['delete_products']['index_num']==$_smarty_tpl->tpl_vars['k']->value){?>
				<li>
					<p class="cartpro_name">
						<a href="<?php echo $_SESSION['delete_products']['pro_href'];?>
"><?php echo substr($_SESSION['delete_products']['pro_name_all'],'0','60');?>
 ... [<?php echo $_SESSION['delete_products']['pro_model'];?>
]</a><span class="grey_6"><?php echo @constant('HAS_BEEN_REMOVED');?>
</span>
					</p>
					<a href="javascript:void(0);" class="link_color Re_add readd_product" data-id=<?php echo $_SESSION['delete_products']['products_id'];?>
 data-qty=<?php echo $_SESSION['delete_products']['del_qty'];?>
><?php echo @constant('RE_ADD');?>
</a>
				</li>
				<?php }?>

				<!-- <?php if ($_smarty_tpl->tpl_vars['value']->value['cate']&&$_smarty_tpl->tpl_vars['cart_sort_by']->value=='cate'){?>
                <?php $_smarty_tpl->tpl_vars["cate_id"] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value['cate_id'], null, 0);?>
                <div class="shopcarttype"><?php echo $_smarty_tpl->tpl_vars['value']->value['cate_name'];?>
<span><?php echo @constant('TEXT_CART_P_SUBTOTAL');?>
: <em><?php echo $_smarty_tpl->tpl_vars['currency_symbol_left']->value;?>
<font id="cate_total_<?php echo $_smarty_tpl->tpl_vars['cate_id']->value;?>
" class="subtotal"><?php echo $_smarty_tpl->tpl_vars['cate_total_arr']->value[$_smarty_tpl->tpl_vars['cate_id']->value];?>
</font></em></span></div>
                <?php }?>	 -->
				<div class="shopcart-list">

					<li>
						<p class="cartpro_name"><label><input type="checkbox" class="jq_products_checked" data-type="single" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
" style="width:18px; height:18px; margin-top:-6px;" <?php if ($_smarty_tpl->tpl_vars['value']->value['is_checked']==1){?> checked="checked"<?php }?> /> &nbsp;</label><a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_link'];?>
"><?php if ($_smarty_tpl->tpl_vars['value']->value['is_small_pack']){?><font style="color:#f00" title="Ready Time:7~15 workdays">&lt;<?php echo @constant('TEXT_SMALL_PACK');?>
&gt;</font><?php }?><?php echo $_smarty_tpl->tpl_vars['value']->value['product_name'];?>
 [<?php echo $_smarty_tpl->tpl_vars['value']->value['model'];?>
]</a></p>
						<div class="pro_img">
							<a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_link'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['product_image'];?>
</a>
							<?php if ($_smarty_tpl->tpl_vars['value']->value['discount']>0){?>
							<span class="cart_discount"><?php echo $_smarty_tpl->tpl_vars['value']->value['discount'];?>
%&nbsp;<?php echo @constant('TEXT_OFF');?>
</span>
							<?php }?>
						</div>
						<div class="pro_price">
							<p>
								<?php echo @constant('TEXT_PRICE');?>
:
								<?php if ($_smarty_tpl->tpl_vars['value']->value['original_price']!=$_smarty_tpl->tpl_vars['value']->value['price']){?>
								<span><del class="oprice_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['original_price'];?>
</del><br /></span>
								<?php }else{ ?>
								<span style="display:none;"><del class="oprice_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['original_price'];?>
</del><br /></span>
								<?php }?>
								<span class="price_color"><span class="price_color price_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['price'];?>
</span></span>
							</p>
							<p class="pro_number">
								<?php if ($_smarty_tpl->tpl_vars['value']->value['id']==28675){?>
								<input class="qty_content" maxlength="5" name="product_qty" type="text" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['qty'];?>
" onpaste="return false" readonly="true"/>
								<input name="product_qty_old" id="qty_old_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['qty'];?>
" />
								<?php }elseif($_smarty_tpl->tpl_vars['value']->value['id']==39729){?>
								<input class="qty_content" maxlength="5" name="product_qty" type="text" value="1" onpaste="return false" readonly="true"/>
								<?php }else{ ?>
								<span class="pro_number_icon_span">
								<span class="cart_decrease_icon <?php if ($_smarty_tpl->tpl_vars['value']->value['qty']<=1){?>gray<?php }?>"></span>
								<input class="qty_content" maxlength="5" name="product_qty" type="text" id="qty_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['qty'];?>
" onpaste="return false" />
								<span class="cart_plus_icon <?php if ($_smarty_tpl->tpl_vars['value']->value['qty']>=99999){?>gray<?php }?>"></span>
								<input name="product_qty_old" id="qty_old_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['qty'];?>
" />
								<input name="product_id" id="id_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" />
							</span>
								<?php }?>
							</p>
							<div class="clearfix"></div>
							<p><?php echo @constant('TEXT_CART_P_SUBTOTAL');?>
: <span class="price_color"><span class="total_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['total'];?>
</span></span></p>
						</div>
						<div class="clearfix"></div>
						<p class="jq_is_preorder_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
 avalaible">
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
						</p>
						<span style="<?php if ($_smarty_tpl->tpl_vars['value']->value['qty']<=$_smarty_tpl->tpl_vars['value']->value['pp_max_num_per_order']){?>display:none;<?php }?>" class="show_promotion_num_tips grey_6 jq_show_promotiom_tips_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['max_num_per_order_tips'];?>
</span>
						<div>
							<span class="with49 float_left"><a href="javascript:void(0);" class="link_text delete-btn" data-confirm="<?php echo @constant('TEXT_CART_JS_REMOVE_ITEM');?>
" index_num= <?php echo $_smarty_tpl->tpl_vars['k']->value;?>
><?php echo @constant('TEXT_CART_DELETE');?>
</a></span>
							<span class="with49 float_lt"><a href="javascript:void(0);" class="link_text jq_addtowishlist float_lt" data-confirm="<?php echo @constant('TEXT_CART_JS_MOVE_TO_WISHLIST');?>
"><?php echo @constant('TEXT_CART_MOVE_TO_WISHLIST');?>
</a></span>
						</div>
						<div class="clearfix"></div>
						<span class="shopping_cart_products_tips jq_qty_update_tips_<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['products_qty_update_auto_note'];?>
</span>
					</li>

				</div>
				<?php if (count($_SESSION['delete_products'])!=0&&$_SESSION['delete_products']['index_num']==$_smarty_tpl->tpl_vars['k']->value+1&&$_SESSION['delete_products']['index_num']==count($_smarty_tpl->tpl_vars['product_array']->value)){?>
				<li>
					<p class="cartpro_name">
						<a href="<?php echo $_SESSION['delete_products']['pro_href'];?>
"><?php echo substr($_SESSION['delete_products']['pro_name_all'],'0','60');?>
 ... [<?php echo $_SESSION['delete_products']['pro_model'];?>
]</a><span class="grey_6"><?php echo @constant('HAS_BEEN_REMOVED');?>
</span>
					</p>
					<a href="javascript:void(0);" class="link_color Re_add readd_product" data-id=<?php echo $_SESSION['delete_products']['products_id'];?>
 data-qty=<?php echo $_SESSION['delete_products']['del_qty'];?>
><?php echo @constant('RE_ADD');?>
</a>
				</li>
				<?php }?>
				<?php } ?>
			</ul>
			<br/>
			<?php echo $_smarty_tpl->tpl_vars['cart_fen_ye']->value;?>

		</div>
		<div style="border-bottom:1px solid #ccc;">
			<div style="float:left; width:30%; height:37px; vertical-align:text-bottom; margin-top:8px;"><label><input type="checkbox" class="jq_products_checked jq_products_checked_all" data-type="all" value="0" style="width:18px; height:18px; margin-left:5px;" <?php if ($_smarty_tpl->tpl_vars['is_checked_all']->value==1){?> checked="checked"<?php }?> />&nbsp;&nbsp;<?php echo @constant('TEXT_ALL');?>
</label></div>
			<div style="float:right; width:70%;">
				<a href='javascript:void(0);' class="add_all_wishlist link_color"><?php echo @constant('TEXT_CART_MOVE_WISHLIST');?>
</a>
				<a href="javascript:void(0)" class="empty-btn empty link_color" data-confirm="<?php echo @constant('TEXT_CART_JS_EMPTY_CART');?>
"><?php echo @constant('TEXT_CART_EMPTY_CART');?>
</a>
			</div>

			<div class="clearfix"></div>
		</div>
		<div>
			<a href="<?php echo $_SESSION['prev_url'];?>
" class="continue link_color">&lt;&lt; <?php echo @constant('TEXT_CONTINUE_SHOPPING');?>
</a>
			<div class="clearfix"></div>
		</div>
		<?php if (count($_smarty_tpl->tpl_vars['products_removed_array']->value)!=0){?>
		<div class="cart_warp">
			<div class="cart_invalid">
				<h3><?php echo @constant('TEXT_CART_INVALID_ITEMS');?>
<a href="javascript:void(0);" class="jq_cart_invalid_notebook cart_invalid_notebook" data-toggle="10"></a></h3>
				<div class="jq_cart_invalid_tip_msg_10 cart_invalid_tip_msg" style="display:none;"><i></i><?php echo @constant('TEXT_SHOPPING_CART_DOWN_NOTE');?>
</div>
				<a href="javascript:void(0);" class="jq_products_invalid_all empty_invalid link_color" data-title="<?php echo addslashes(@constant('TEXT_SHOPING_CART_CONFIRM_EMPTY_INVALID_ITEMS'));?>
"><?php echo @constant('TEXT_CART_EMPTY_INVALID_ITEMS');?>
</a>

				<div class="clearfix"></div>
				<div class="cart_invalid_items">
					<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['products_removed_array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
					<div class="jq_products_list_<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
">
						<p>
							<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="<?php echo $_smarty_tpl->tpl_vars['value']->value['products_image_80'];?>
" /> <span><?php echo $_smarty_tpl->tpl_vars['value']->value['products_name'];?>
,  [<?php echo $_smarty_tpl->tpl_vars['value']->value['products_model'];?>
]</span>
						</p>

						<div class="products_invalid_operation">
							<?php echo $_smarty_tpl->tpl_vars['value']->value['also_like_str'];?>
<a href="javascript:void(0);" class="jq_products_invalid_one" data-id="<?php echo $_smarty_tpl->tpl_vars['value']->value['customers_basket_id'];?>
"><?php echo @constant('TEXT_DELETE');?>
</a>
						</div>
					</div>
					<?php } ?>
				</div>

				<a href="javascript:void(0);" class="jq_products_invalid_all empty_invalid link_color" data-title="<?php echo addslashes(@constant('TEXT_SHOPING_CART_CONFIRM_EMPTY_INVALID_ITEMS'));?>
"><?php echo @constant('TEXT_CART_EMPTY_INVALID_ITEMS');?>
</a>
				<div class="clearfix"></div>
				<div class="invalid_items_fen_ye"><?php echo $_smarty_tpl->tpl_vars['invalid_items_fen_ye']->value;?>
</div>
			</div>
		</div>
		<?php }?>
		<div class="bottom_total">
			<h3><?php echo @constant('TEXT_ORDER_SUMMARY');?>
</h3>
			<table>
				<tr>
					<th><?php echo @constant('TEXT_CART_ORIGINAL_PRICES');?>
: </th>
					<td class="total_pice price_color">  <span class="total_amount_original"><?php echo $_smarty_tpl->tpl_vars['original_prices']->value;?>
</span></td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['discounts']->value>0){?>
				<tr>
					<th class="discount_title"><?php echo @constant('TEXT_CART_DISCOUNT');?>
: </th>
					<td class="total_pice price_color"><span class="discount_content"> -<?php echo $_smarty_tpl->tpl_vars['discounts_format']->value;?>
</span>
						<span class="image_down_arrow"></span>
				        <span class="image_up_arrow" style="display:none;"></span>
					</td>
				</tr>
				<?php }?>
				<tr>
					<td colspan="2">
						<table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;">
							<tr>
								<th class="promotion_discount_full_set_minus_title"><?php echo $_smarty_tpl->tpl_vars['promotion_discount_full_set_minus_title']->value;?>
</th>
								<td class="promotion_discount_full_set_minus_content total_pice price_color"><?php echo $_smarty_tpl->tpl_vars['promotion_discount_full_set_minus_content']->value;?>
</td>
							</tr>
							<?php if ($_smarty_tpl->tpl_vars['promotion_discount_usd']->value>0){?>
							<tr>
								<th><?php echo @constant('TEXT_PROMOTION_SAVE');?>
: </th>
								<td class="promotion_discount_content total_pice price_color">- <?php echo $_smarty_tpl->tpl_vars['promotion_discount']->value;?>
</td>
							</tr>
							<?php }?>
							<?php if ($_SESSION['customer_id']!=''&&$_smarty_tpl->tpl_vars['cVipInfo']->value['amount']>0){?>
							<tr>
								<th class="vip_title"><?php echo @constant('TEXT_CART_VIP_DISCOUNT');?>
: </th>
								<td class="total_pice price_color vip_content"><?php echo $_smarty_tpl->tpl_vars['vip_content']->value;?>
</td>
							</tr>
							<?php }else{ ?>
							<tr>
								<th class="vip_title" style="display:none;"><?php echo @constant('TEXT_CART_VIP_DISCOUNT');?>
: </th>
								<td class="total_pice price_color vip_content" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['vip_content']->value;?>
</td>
							</tr>
							<?php }?>
							<?php if ($_SESSION['customer_id']!=''&&$_smarty_tpl->tpl_vars['rcd_discount']->value>0){?>
							<tr>
								<th class="rcd_title">RCD(<span class="vipoff">3% <?php echo @constant('TEXT_DISCOUNT_OFF_SHOW');?>
</span>): </th>
								<td class="total_pice price_color rcd_contents">- <?php echo $_smarty_tpl->tpl_vars['show_current_discount']->value;?>
</td>
							</tr>
							<?php }else{ ?>
							<tr>
								<th class="rcd_title" style="display:none;">RCD(<span class="vipoff">3%</span>): </th>
								<td class="total_pice price_color rcd_content" style="display:none;">- <?php echo $_smarty_tpl->tpl_vars['show_current_discount']->value;?>
</td>
							</tr>
							<?php }?>
							<?php if ($_SESSION['customer_id']!=''&&$_smarty_tpl->tpl_vars['prom_discount']->value>0){?>
							<tr>
								<th class="promotion_title"><?php echo $_smarty_tpl->tpl_vars['prom_discount_title']->value;?>
: </th>
								<td class="promotion_discount total_pice price_color">-
									<span><?php echo $_smarty_tpl->tpl_vars['prom_discount_format']->value;?>
</span></td>
							</tr>
							<?php }else{ ?>
							<tr>
								<th class="promotion_title" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['prom_discount_title']->value;?>
:</th>
								<td class="promotion_discount total_pice price_color" style="display:none;">-
									<span><?php echo $_smarty_tpl->tpl_vars['prom_discount_format']->value;?>
</span></td>
							</tr>
							<?php }?>
						</table>
				    </td>
			    </tr>
				<?php if ($_smarty_tpl->tpl_vars['promotion_discount_usd']->value>0){?>
				<tr>
					<td colspan="2" class="grey_9 cal_total_amount_convert">(<?php echo $_smarty_tpl->tpl_vars['cart_save_price_note']->value;?>
)</td>
				</tr>
				<?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['special_discount_content']->value>0){?>
				<tr>
					<th class="special_discount_title"><?php echo $_smarty_tpl->tpl_vars['special_discount_title']->value;?>
</th>
					<td class="special_discount_content total_pice price_color"><?php echo $_smarty_tpl->tpl_vars['special_discount_content']->value;?>
</td>
				</tr>
                                <?php }?>    
				<!-- <?php if ($_SESSION['customer_id']!=''&&$_smarty_tpl->tpl_vars['cVipInfo']->value['amount']>0){?>
				<tr>
					<th class="vip_title"><?php echo @constant('TEXT_CART_VIP_DISCOUNT');?>
: </th>
					<td class="total_pice price_color vip_content"><?php echo $_smarty_tpl->tpl_vars['vip_content']->value;?>
</td>
				</tr>
				<?php }else{ ?>
				<tr>
					<th class="vip_title" style="display:none;"><?php echo @constant('TEXT_CART_VIP_DISCOUNT');?>
: </th>
					<td class="total_pice price_color vip_content" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['vip_content']->value;?>
</td>
				</tr>
				<?php }?> -->
				<!-- <?php if ($_SESSION['customer_id']!=''&&$_smarty_tpl->tpl_vars['rcd_discount']->value>0){?>
				<tr>
					<th class="rcd_title">RCD(<span class="vipoff">3% <?php echo @constant('TEXT_DISCOUNT_OFF_SHOW');?>
</span>): </th>
					<td class="total_pice price_color rcd_content">(-) <?php echo $_smarty_tpl->tpl_vars['show_current_discount']->value;?>
</td>
				</tr>
				<?php }else{ ?>
				<tr>
					<th class="rcd_title" style="display:none;">RCD(<span class="vipoff">3%</span>): </th>
					<td class="total_pice price_color rcd_content" style="display:none;">(-) <?php echo $_smarty_tpl->tpl_vars['show_current_discount']->value;?>
</td>
				</tr>
				<?php }?> -->
				    <th class="handing_fee_titles" <?php if ($_smarty_tpl->tpl_vars['is_handing_fee']->value<0){?> style="display:inline" <?php }else{ ?> style="display:none" <?php }?>><?php echo @constant('TEXT_HANDING_FEE_WORDS');?>
:</th>
				    <td class="handing_fee_contents total_pice price_color" <?php if ($_smarty_tpl->tpl_vars['is_handing_fee']->value<0){?> style="display:table-cell" <?php }else{ ?> style="display:none" <?php }?>><?php echo $_smarty_tpl->tpl_vars['handing_fee']->value;?>
</td>
				<tr>
					<th class="shipping_title"><?php echo @constant('TEXT_SHIPPING_FEE_WORDS');?>
:</th>
					<td class="shipping_content total_pice price_color"><?php echo $_smarty_tpl->tpl_vars['shipping_content']->value;?>
</td>
				</tr>
				<tr>
					<td colspan="2" class="grey_9">(<?php echo @constant('TEXT_SHIPPING_FEE_CHANGE_METHOD_TIPS');?>
)</td>
				</tr>
				<tr>
					<th><?php echo @constant('TEXT_CART_WORD_TOTAL1');?>
:</th>
					<td class=" total_pice price_color"> <span class="total_amount"><?php echo $_smarty_tpl->tpl_vars['total_all']->value;?>
</span></td>
				</tr>
			</table>
		</div>

		<!-- <?php if ($_smarty_tpl->tpl_vars['cart_products_down_errors']->value!=''){?>
        <div class="removealltips">
        <?php echo $_smarty_tpl->tpl_vars['cart_products_down_errors']->value;?>

        </div>
        <?php }?> -->

		<!-- <div class="checkdiscount">
            <dl><dt><?php echo @constant('TEXT_CART_TOTAL_PRODUCT_PRICE');?>
: </dt><dd>(+) <?php echo $_smarty_tpl->tpl_vars['currency_symbol_left']->value;?>
 <span class="total_amount_original"><?php echo $_smarty_tpl->tpl_vars['total_amount_convert']->value;?>
</span><ins class="pricetipsicon opentips"></ins></dd></dl>
            <div class="pricetipscont "><span class="bot"></span><span class="top"></span><?php echo @constant('TEXT_CART_TOTAL_PRODUCT_PRICE');?>
 = <?php echo @constant('TEXT_CART_ORIGINAL_PRICE');?>
-<?php echo @constant('TEXT_CART_PRODUCT_DISCOUNT');?>
<br><b class="cal_total_amount_convert">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['currency_symbol_left']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['total_amount_convert']->value;?>
 = <?php echo $_smarty_tpl->tpl_vars['currency_symbol_left']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['total_amount_original']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['currency_symbol_left']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['promotion_discount']->value;?>
</b></div>

            <dt class="special_discount_title"><?php echo $_smarty_tpl->tpl_vars['special_discount_title']->value;?>
</dt>
            <dd class="special_discount_content"><?php echo $_smarty_tpl->tpl_vars['special_discount_content']->value;?>
</dd>
            <dt class="promotion_discount_full_set_minus_title"></dt>
                <dd class="promotion_discount_full_set_minus_content"></dd>
            <?php if ($_SESSION['customer_id']!=''&&$_smarty_tpl->tpl_vars['cVipInfo']->value['amount']>0){?>
            <dl>
                <dt class="vip_title"><a href="http://www.doreenbeads.com/index.php?main_page=help_center&id=65" class="vip"><?php echo @constant('TEXT_CART_VIP_DISCOUNT');?>
: </a></dt>
                <dd class="vip_content"><?php echo $_smarty_tpl->tpl_vars['vip_content']->value;?>
</dd>
            </dl>
            <?php }else{ ?>
            <dl>
                <dt class="vip_title" style="display:none;"><a href="http://www.doreenbeads.com/index.php?main_page=help_center&id=65"  class="vip"><?php echo @constant('TEXT_CART_VIP_DISCOUNT');?>
:</a></dt>
                <dd class="vip_content" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['vip_content']->value;?>
</dd>
            </dl>
            <?php }?>

            <?php if ($_SESSION['customer_id']!=''&&$_smarty_tpl->tpl_vars['prom_discount']->value>0){?>
            <dl>
                <dt class="promotion_title"><a class="vip"><?php echo $_smarty_tpl->tpl_vars['prom_discount_title']->value;?>
: </a></dt>
                <dd class="promotion_discount">(-) <?php echo $_smarty_tpl->tpl_vars['currency_symbol_left']->value;?>

                        <span><?php echo $_smarty_tpl->tpl_vars['prom_discount']->value;?>
</span></dd>
            </dl>
            <?php }else{ ?>
            <dl>
                <dt class="promotion_title" style="display:none;"><a class="vip"><?php echo $_smarty_tpl->tpl_vars['prom_discount_title']->value;?>
: </a></dt>
                <dd class="promotion_discount" style="display:none;">(-) <?php echo $_smarty_tpl->tpl_vars['currency_symbol_left']->value;?>

                        <span><?php echo $_smarty_tpl->tpl_vars['prom_discount']->value;?>
</span></dd>
            </dl>
            <?php }?>

            Tianwen.Wan->closed20151116_17
            <dl>
                <dt><a href="<?php echo $_smarty_tpl->tpl_vars['shoppingcart_default_url']->value;?>
&pn=sc<?php if ($_smarty_tpl->tpl_vars['page']->value>1){?>&page=<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
<?php }?>" class="estShippingCost"><?php echo @constant('TEXT_CART_SHIPPING_COST');?>
: </a></dt>
                <dd class="shipping_content"><?php echo $_smarty_tpl->tpl_vars['shipping_content']->value;?>
</dd>
            </dl>
            <p class="shippingMethodDd"><?php if ($_COOKIE['shipping_method_selected']!=''){?><?php echo $_COOKIE['shipping_method_selected'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['shipping_method_by']->value;?>
<?php }?></p>
            <br/>
            <br/>
            <br/>
        </div> -->

		<!-- <div class="checktotal">
            <p><strong><?php echo @constant('TEXT_CART_WORD_TOTAL1');?>
: <span><?php echo $_smarty_tpl->tpl_vars['currency_symbol_left']->value;?>
</span> <span class="total_amount"><?php echo $_smarty_tpl->tpl_vars['total_all']->value;?>
</span></strong>
            <a href="<?php echo $_smarty_tpl->tpl_vars['checkout_default_url']->value;?>
" class="checkbtn-cart"><?php echo @constant('TEXT_CART_CHECKOUT');?>
</a></p>
        </div> -->
		<table class="mobileDrawer" cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo @constant('TEXT_CART_WORD_TOTAL1');?>
:  <span class="total_amount"><?php echo $_smarty_tpl->tpl_vars['total_all']->value;?>
</span></th>
				<td><a href="javascript:void(0);" class="jq_checkbtn" data-url="<?php echo $_smarty_tpl->tpl_vars['checkout_default_url']->value;?>
"><?php echo @constant('TEXT_CART_CHECKOUT');?>
</a></td>
			</tr>
		</table>

	</div>

	<div class="addsuccess-tip float-show" style="display:none;"></div>
	<!-- <div class="deletetips float-show">
        <div>
            <p><?php echo @constant('TEXT_CART_JS_REMOVE_ITEM');?>
</p>
            <p><a href="javascript:void(0)" class="okbtn"><?php echo @constant('TEXT_OK');?>
</a><a href="javascript:void(0)" class="cancelbtn"><?php echo @constant('TEXT_CANCEL');?>
</a><input type="hidden" id="delete-pid"></p>
        </div>
    </div> -->
	<!--购物车删除弹框开始-->
	<div class="shopping_cart_bomb jq_shopping_cart_delete" >
		<div class="popup_cart_de">
			<a class="close_White jq_cancelbtn" href="javascript:void(0)"></a>
			<div class="popup_cart_remove">
				<p><?php echo @constant('TEXT_CART_JS_REMOVE_ITEM');?>
</p>
				<a class="btn_orange jq_del_one_okbtn"><?php echo @constant('TEXT_YES');?>
</a>
				<a class="btn_grey jq_cancelbtn"><?php echo @constant('TEXT_NO');?>
</a>
			</div>
			<input type="hidden" id="delete-pid">
		</div>
	</div>
	<!--购物车删除弹框结束-->
	<!--购物车删除弹框开始-->
	<div class="shopping_cart_bomb jq_shopping_cart_delete_all" >
		<div class="popup_cart_de">
			<a class="close_White jq_cancelbtn" href="javascript:void(0)"></a>
			<div class="popup_cart_remove">
				<p><?php echo @constant('TEXT_CART_JS_MOVE_ALL');?>
</p>
				<a class="btn_orange jq_del_all_okbtn"><?php echo @constant('TEXT_YES');?>
</a>
				<a class="btn_grey jq_cancelbtn"><?php echo @constant('TEXT_NO');?>
</a>
			</div>
			<input type="hidden" id="delete-pid">
		</div>
	</div>
	<!--购物车删除弹框结束-->
	<!--购物车add to wishlist弹框开始-->
	<div class="shopping_cart_bomb jq_shopping_cart_addwishlist" >
		<div class="popup_cart_de">
			<a class="close_White jq_cancelbtn" href="javascript:void(0)"></a>
			<div class="popup_cart_addwishlist">
				<p><?php echo @constant('TEXT_CART_ADD_WISHLIST_SUCCESS');?>
</p>
				<a href="index.php?main_page=wishlist" class="btn_orange a_ru"><?php echo @constant('TEXT_CART_VIEW_WISHLIST');?>
</a>
			</div>
		</div>
	</div>
	<!--购物车add to wishlist弹框结束-->
	<!--购物车add all to wishlist弹框开始-->
	<div class="shopping_cart_bomb jq_shopping_cart_add_all_wishlist" >
		<div class="popup_cart_de">
			<a class="close_White jq_cancelbtn" href="javascript:void(0)"></a>
			<div class="popup_cart_remove">
				<p><?php echo @constant('TEXT_CART_JS_MOVE_ALL');?>
</p>
				<a class="btn_orange jq_add_wishlist_okbtn"><?php echo @constant('TEXT_YES');?>
</a>
				<a class="btn_grey jq_cancelbtn"><?php echo @constant('TEXT_NO');?>
</a>
			</div>
		</div>
	</div>
	<!--购物车add all to wishlist弹框结束-->
	<!--购物车移除无效商品弹框开始-->
	<div class="shopping_cart_bomb jq_shopping_cart_invaild_all" >
		<div class="popup_cart_de">
			<a class="close_White jq_cancelbtn" href="javascript:void(0)"></a>
			<div class="popup_cart_remove">
				<p><?php echo @constant('TEXT_CART_JS_MOVE_ALL');?>
</p>
				<a class="btn_orange jq_invaild_all_okbtn"><?php echo @constant('TEXT_YES');?>
</a>
				<a class="btn_grey jq_cancelbtn"><?php echo @constant('TEXT_NO');?>
</a>
			</div>
			<input type="hidden" id="delete-pid">
		</div>
	</div>
	<!--购物车移除无效商品弹框结束-->
</div><?php }} ?>