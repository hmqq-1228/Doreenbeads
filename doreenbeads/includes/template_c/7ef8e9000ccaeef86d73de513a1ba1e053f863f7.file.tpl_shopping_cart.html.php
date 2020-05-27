<?php /* Smarty version Smarty-3.1.13, created on 2020-03-11 18:15:45
         compiled from "includes\templates\checkout\tpl_shopping_cart.html" */ ?>
<?php /*%%SmartyHeaderCode:306765e68ba51abebc0-41452670%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7ef8e9000ccaeef86d73de513a1ba1e053f863f7' => 
    array (
      0 => 'includes\\templates\\checkout\\tpl_shopping_cart.html',
      1 => 1575421047,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '306765e68ba51abebc0-41452670',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'total_weight' => 0,
    'text_countries_list' => 0,
    'customer_default_city' => 0,
    'customer_default_postcode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e68ba51d87187_51199282',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e68ba51d87187_51199282')) {function content_5e68ba51d87187_51199282($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("includes/templates/checkout/tpl_checkout_head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!-- shopping cart -->
<div class="min_main">	
    <?php echo $_smarty_tpl->getSubTemplate ("includes/templates/checkout/tpl_shopping_cart_products.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php echo $_smarty_tpl->getSubTemplate ("includes/templates/checkout/tpl_recently_viewed_products.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
    
</div>
<!-- shopping cart -->

<!-- bof quick add product -->
<div id="quick_add_content">
<?php echo $_smarty_tpl->getSubTemplate ("includes/templates/checkout/tpl_quick_add_products.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>
<!-- eof quick add product -->

<!-- bof shipping calculator -->
<div class="smallwindow windowship" id="estimatewindow" style="display: none;">
	<div class="smallwindowtit">
		<strong><?php echo @constant('TEXT_CART_SHIPPING_INFO');?>
</strong>
		<a href="javascript:void(0);" class="shipclose_btn">X</a>
	</div>
	<div class="clearfix"></div>
	<table class="shiptab">
		<tr>
			<td><ins><?php echo @constant('TEXT_WORD_SHIPPING_WEIGHT');?>
:</ins><input class="canread total_weight_input" value="<?php echo $_smarty_tpl->tpl_vars['total_weight']->value;?>
g" disabled /></td>
			<td><ins><?php echo @constant('TEXT_CART_SHIPPING_COUNTRY');?>
:</ins><div class="shipping_cal_country"><?php echo $_smarty_tpl->tpl_vars['text_countries_list']->value;?>
</div></td>
		</tr>
		<tr>
			<td><ins><?php echo @constant('TEXT_CART_SHIPPING_CITY');?>
:</ins><input class="estimate_city" type="text" value="<?php echo $_smarty_tpl->tpl_vars['customer_default_city']->value;?>
" /><input class="estimate_ocity" type="hidden"  value="<?php echo $_smarty_tpl->tpl_vars['customer_default_city']->value;?>
" /></td>
			<td><ins><?php echo @constant('TEXT_CART_SHIPPING_POSTCODE');?>
:</ins><input class="estimate_postcode" type="text" value="<?php echo $_smarty_tpl->tpl_vars['customer_default_postcode']->value;?>
" /><input class="estimate_opostcode" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['customer_default_postcode']->value;?>
" /></td>
		</tr>
		<tr>
			<td>
				<button class="paynow_btn estimate_btn">
					<?php echo @constant('TEXT_CART_SHIPPING_CAL');?>

				</button>
			</td>
			<td></td>
		</tr>
	</table>	
	
	<span style="margin-left:20px;"><?php echo @constant('TEXT_SHIPPING_COST_IS_CAL_BY');?>
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
	
	<div class="estimate_content"><div class="estshipping_loading"><img src="includes/templates/cherry_zen/images/zen_loader.gif"></div></div>
</div>
<!-- eof --><?php }} ?>