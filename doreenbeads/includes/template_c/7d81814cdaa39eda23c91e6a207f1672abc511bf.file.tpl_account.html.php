<?php /* Smarty version Smarty-3.1.13, created on 2020-04-27 13:38:57
         compiled from "includes\templates\account\tpl_account.html" */ ?>
<?php /*%%SmartyHeaderCode:314955ea66ff120abf3-25678282%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d81814cdaa39eda23c91e6a207f1672abc511bf' => 
    array (
      0 => 'includes\\templates\\account\\tpl_account.html',
      1 => 1575421066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '314955ea66ff120abf3-25678282',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'message' => 0,
    'filter' => 0,
    'ordersarray' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5ea66ff1324174_39288647',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ea66ff1324174_39288647')) {function content_5ea66ff1324174_39288647($_smarty_tpl) {?><script>window.lang_wdate='<?php echo $_SESSION['languages_code'];?>
';</script>
<script type="text/javascript" src="includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>

<div class="mainwrap_r">
	<p class="ordertit"><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['account_status_text'];?>
</strong><!-- <a href="javascript:void(0)" class="quickadd_btn"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_products_order_by_no'];?>
 >></a> --></p>
	<div class="clearBoth"></div>
	<div class="filterform">
		<form name="orderfilters" action="index.php?main_page=account" method="post">
			<input name="orderfilter" type="hidden" value="1"/>
			<dl>
				<dd>
					<p><label><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_order_number'];?>
:</label><input name="ordernumber" <?php if ($_smarty_tpl->tpl_vars['filter']->value['filter_ordernumber']!=''){?> value="<?php echo $_smarty_tpl->tpl_vars['filter']->value['filter_ordernumber'];?>
" <?php }?> type="text"/></p>
					<div class="orderstatus">
						<label><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_status'];?>
:</label>
						<p class="select1">
							<span id="text_left1"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_status_text'];?>
</span>
							<span id="arrow_right1"></span>
						</p>
						<ul class="selectlist1">
							<li value="99"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_all_orders'];?>
</li>
							<li value="1"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_pendding'];?>
</li>
							<li value="2"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_processing'];?>
</li>
							<li value="3"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_shipped'];?>
</li>
							<li value="4"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_update'];?>
</li>
							<li value="10"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_delivered'];?>
</li>
							<li value="0"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_canceled'];?>
</li>
						</ul>
					</div>
					<input type="hidden" name="orderstatus" value="<?php echo $_smarty_tpl->tpl_vars['message']->value['status_id'];?>
"/>
				</dd>
				<dt>
					<p><label><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_pro_number'];?>
:</label><input name="pronumber" value="<?php echo $_smarty_tpl->tpl_vars['filter']->value['filter_pronumber'];?>
" type="text"/></p>
					<p>
						<label><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_date'];?>
:</label>
						<input class="Wdate" style="width:82px;" value="<?php echo $_smarty_tpl->tpl_vars['filter']->value['filter_date_start'];?>
" type="text" name="datestart" onclick="WdatePicker();" onfocus="RemoveFormatString(this, 'DATE_FORMAT_STRING')"> <?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_to'];?>
 
						<input class="Wdate" style="width:82px;" value="<?php echo $_smarty_tpl->tpl_vars['filter']->value['filter_date_end'];?>
" type="text" name="dateend" onclick="WdatePicker();" onfocus="RemoveFormatString(this, 'DATE_FORMAT_STRING')">
					</p>
				</dt>
			</dl>
			<div class="clearBoth"></div>
			<p class="filterbtn"><button class="btn_yellow"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_filter'];?>
</button></p>
		</form>
	</div>
     
	<div class="orderdetail">
		<div class="propagelist">
			<?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_result_page'];?>

		</div>
		<table>
			<tr>
				<th width="170"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_date'];?>
</th>
				<th width="160"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_order_number'];?>
</th>
				<th width="160"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_total'];?>
</th>
				<th width="160"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_status'];?>
</th>
				<th width="180"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_action'];?>
</th>
			</tr>
			<?php if (count($_smarty_tpl->tpl_vars['ordersarray']->value)==0){?>
			<tr><td colspan="5" align="center"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_no_order'];?>
</td><tr>
			<?php }else{ ?>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ordersarray']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['date_purchased'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['order_total'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_status_name'];?>
</td>
				<td class="account_action">
					<?php if ($_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_status']==1&&$_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['show_payment']==0){?><a href="index.php?main_page=account_history_info&order_id=<?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_id'];?>
&continued_order=payment"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_make_payment'];?>
</a><br/>
					<a target="_blank" href="index.php?main_page=account_history_info&order_id=<?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_view_details'];?>
</a><br/> 
					<!--<a href="javascript:void(0);" class="quick_reorder" oid="<?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_id'];?>
" ><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_quick_peorder'];?>
</a><br/>-->
					<?php }else{ ?>
					<a target="_blank"  href="index.php?main_page=account_history_info&order_id=<?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_product_details'];?>
</a><br/> 
					<?php if ($_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['show_track_info']==1){?><a style='color:#008FED;' href="index.php?main_page=track_info&order_id=<?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_id'];?>
"><?php echo @constant('TEXT_PAYMENT_TRACK_INFO');?>
</a><br/><?php }?>
					<!--<a href="javascript:void(0);" class="quick_reorder" oid="<?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_quick_peorder'];?>
</a><br/>-->
					<?php if ($_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_status']!=1){?><a target='_blank' href="invoice.php?oID=<?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_view_invoice'];?>
</a><br/><?php }?>
					<!--<?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_order_inquiry'];?>
<br>-->
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_status']==2||$_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_status']==3||$_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_status']==4||$_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_status']==10){?><a href="index.php?main_page=packing_slip&action=pack_filter&ordernumber=<?php echo $_smarty_tpl->tpl_vars['ordersarray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_id'];?>
" style='color:#008FED;'><?php echo $_smarty_tpl->tpl_vars['message']->value['account_packing_slip'];?>
</a><?php }?>
				</td> 
			</tr>
			<?php endfor; endif; ?>
			<?php }?>
		</table>
		<div class="propagelist">
			<?php echo $_smarty_tpl->tpl_vars['message']->value['account_text_result_page'];?>

		</div>
		<div class="clearBoth"></div>
	</div>
</div>
<div class="clearfix"></div>
<!-- bof quick add product -->
<div id="quick_add_content">
<?php echo $_smarty_tpl->getSubTemplate ("includes/templates/checkout/tpl_quick_add_products.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>
<!-- eof quick add product --><?php }} ?>