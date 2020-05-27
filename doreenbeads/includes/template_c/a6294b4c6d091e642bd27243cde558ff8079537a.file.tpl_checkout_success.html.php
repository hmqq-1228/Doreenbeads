<?php /* Smarty version Smarty-3.1.13, created on 2020-04-17 09:01:06
         compiled from "includes\templates\checkout\tpl_checkout_success.html" */ ?>
<?php /*%%SmartyHeaderCode:250155e98114b453883-15822522%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6294b4c6d091e642bd27243cde558ff8079537a' => 
    array (
      0 => 'includes\\templates\\checkout\\tpl_checkout_success.html',
      1 => 1587085250,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '250155e98114b453883-15822522',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e98114b61a664_43532402',
  'variables' => 
  array (
    'message' => 0,
    'order' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e98114b61a664_43532402')) {function content_5e98114b61a664_43532402($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('includes/templates/checkout/tpl_checkout_head.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="min_main">
	<div class="result_info">
		<ins class="icon_ok"></ins>
			<h2><?php echo $_smarty_tpl->tpl_vars['message']->value['success_successfully'];?>
</h2>
			<br/>
			<h3 style="color: #FF0000;"><?php ob_start();?><?php echo @constant('TEXT_PAY_SUCCESS_TIP_TiTLE');?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
</h3>
			<p style="margin-top: 10px;line-height: 18px;"><?php ob_start();?><?php echo @constant('TEXT_PAY_SUCCESS_TIP');?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
</p>
			<h2 style="color:#5b5a5a"><?php echo $_smarty_tpl->tpl_vars['message']->value['set_coupon'];?>
</h2>
			<br/>
			<p><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_number'];?>
 <span><?php echo $_smarty_tpl->tpl_vars['message']->value['success_orders_id'];?>
</span><?php echo $_smarty_tpl->tpl_vars['message']->value['success_date'];?>
</p>
			<br/>
			<p><?php echo @constant('TEXT_PLEASE_KINDLY_CHECK');?>
</p>
	</div>
	<div class="paydetails_complete">
		<div class="payment fleft">
			<p class="paymenttit"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_payment_detailas'];?>
</p>
			<table class="paydetail">
				<tr><td align="right" nowrap style="padding-bottom:10px;"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_payment_method'];?>
</td><td style="padding-bottom:10px;"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_payment_method_text'];?>
</td></tr>
				<?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_total'];?>

			</table>
			<div style="text-align:center;">
				<br/>
				<a class="paynow_btn" href="<?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_details'];?>
" style="color:#fff;"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_detail'];?>
</a> &nbsp;&nbsp;
				<?php if ($_smarty_tpl->tpl_vars['message']->value['success_order_status']==2){?>
					<?php echo $_smarty_tpl->tpl_vars['message']->value['success_you_ve_made_payment'];?>

				<?php }elseif($_smarty_tpl->tpl_vars['message']->value['success_order_status']==42){?>
					<?php echo $_smarty_tpl->tpl_vars['message']->value['success_payment_under_checking'];?>

				<?php }else{ ?>
				<a class="paynow_btn" style="color:#fff;" href="<?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_details'];?>
&continued_order=payment">
				
				<?php echo @constant('TEXT_MAKE_PAYMENT');?>

				</a>
				<?php }?>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['message']->value['success_order_status']==2){?>
			<div class="makepayment"  style="margin-left:100px">
			<a href="invoice.php?oID=<?php echo $_smarty_tpl->tpl_vars['message']->value['success_orders_id'];?>
" class="view_invoice" target="_blank"><?php echo $_smarty_tpl->tpl_vars['message']->value['text_view_invoice'];?>
</a>
			</div>
			<?php }?>
		</div>
		<div class="shipinvoice fright">
			<p class="paymenttit"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_shipping_invoece_comments'];?>
</p>
			<table class="paydetail_special">
				<?php if ($_smarty_tpl->tpl_vars['order']->value->info['shipping_restriction_total']>0&&($_smarty_tpl->tpl_vars['message']->value['success_order_status']==2||$_smarty_tpl->tpl_vars['message']->value['success_order_status']==3||$_smarty_tpl->tpl_vars['message']->value['success_order_status']==4||$_smarty_tpl->tpl_vars['message']->value['success_order_status']==10)){?>
				<tr><td align="left" colspan="2" style="color:red;"><?php echo @constant('TEXT_SHIPPING_RESTRICTION_IMPORTANT_NOTE');?>
</td></tr>
				<?php }?>
				<tr><td width="25%" align="right" nowrap><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['success_shipping_method'];?>
</strong></td><td><?php echo $_smarty_tpl->tpl_vars['message']->value['success_shipping_method_text'];?>
</td></tr>
				<?php if ($_smarty_tpl->tpl_vars['message']->value['shipping_days']!=''){?><tr><td align="right" nowrap><strong><?php echo @constant('TEXT_ESTSHIPPING_TIME');?>
</strong></td><td><?php echo $_smarty_tpl->tpl_vars['message']->value['shipping_days'];?>
</td></tr><?php }?>
<!--
				<?php if ($_smarty_tpl->tpl_vars['message']->value['success_invoice_count']>0){?>
				<tr><td align="right">Invoice Value:</td><td>
					<?php if ($_smarty_tpl->tpl_vars['message']->value['order_invoice_value']!=''){?><?php echo $_smarty_tpl->tpl_vars['message']->value['order_invoice_value'];?>
<?php }else{ ?>/<?php }?></td></tr>
				<tr><td align="right">Invoice Shipping Fee:</td><td>
					<?php if ($_smarty_tpl->tpl_vars['message']->value['order_shipping_fee']!=''){?><?php echo $_smarty_tpl->tpl_vars['message']->value['order_shipping_fee'];?>
<?php }else{ ?>/<?php }?></td></tr>
				<tr><td align="right">Item Description marked as:</td><td>
					<?php if ($_smarty_tpl->tpl_vars['message']->value['order_item_description']!=''){?><?php echo $_smarty_tpl->tpl_vars['message']->value['order_item_description'];?>
<?php }else{ ?>/<?php }?></td></tr> 
				<?php }?>
-->
			</table>		  
			<p class="addr"><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['success_shipping_address'];?>
</strong><br/><span><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_shipping_address'];?>
</span></p>
			<p class="addr"><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_cumments'];?>
</strong><br/><span><?php echo $_smarty_tpl->tpl_vars['message']->value['order_comments'];?>
</span></p>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
<?php echo $_smarty_tpl->getSubTemplate ('includes/templates/checkout/tpl_products_foryour_consider.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>
<?php }} ?>