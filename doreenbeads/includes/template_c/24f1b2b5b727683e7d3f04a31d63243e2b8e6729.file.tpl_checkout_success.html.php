<?php /* Smarty version Smarty-3.1.13, created on 2020-04-17 09:23:30
         compiled from "includes\templates\mobilesite\tpl\tpl_checkout_success.html" */ ?>
<?php /*%%SmartyHeaderCode:41885e990167ebb706-52787197%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24f1b2b5b727683e7d3f04a31d63243e2b8e6729' => 
    array (
      0 => 'includes\\templates\\mobilesite\\tpl\\tpl_checkout_success.html',
      1 => 1587086606,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '41885e990167ebb706-52787197',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e9901681f63d2_84873608',
  'variables' => 
  array (
    'message' => 0,
    'order' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e9901681f63d2_84873608')) {function content_5e9901681f63d2_84873608($_smarty_tpl) {?><div class="order_main">
    <div class="comllete_warp">
        <div class="balance1">
            <p><?php echo $_smarty_tpl->tpl_vars['message']->value['success_successfully'];?>
</p>
						<h2 style="font-weight: bold;color: #ff0000;"><?php echo @constant('TEXT_PAY_SUCCESS_TIP_TiTLE');?>
</h2>
            <p><?php echo @constant('TEXT_PAY_SUCCESS_TIP');?>
</p>
						<table>
                <tr>
                    <?php if ($_smarty_tpl->tpl_vars['message']->value['success_order_status']==2){?>                
                    <td class="price_color"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_you_ve_made_payment'];?>
:</td><td class="price_color"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_total_text'];?>
</td>
                    <?php }elseif($_smarty_tpl->tpl_vars['message']->value['success_order_status']==42){?>
                    <td class="price_color" colspan="2"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_payment_under_checking'];?>
</td>
                    <?php }else{ ?>
                    <td class="price_color" colspan="2"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_unpaid'];?>
</td>
                    <?php }?>
                </tr>
				<?php if ($_smarty_tpl->tpl_vars['order']->value->info['shipping_restriction_total']>0&&($_smarty_tpl->tpl_vars['message']->value['success_order_status']==2||$_smarty_tpl->tpl_vars['message']->value['success_order_status']==3||$_smarty_tpl->tpl_vars['message']->value['success_order_status']==4||$_smarty_tpl->tpl_vars['message']->value['success_order_status']==10)){?>
				<tr><td colspan="2" style="color:red;"><?php echo @constant('TEXT_SHIPPING_RESTRICTION_IMPORTANT_NOTE');?>
</td></tr>
				<?php }?>

                <tr><th><?php echo $_smarty_tpl->tpl_vars['message']->value['success_payment_method'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['message']->value['success_payment_method_text'];?>
</td></tr>
                <tr><th><?php echo @constant('TABLE_HEADING_STATUS_DATE');?>
:</th><td><?php echo $_smarty_tpl->tpl_vars['message']->value['success_date'];?>
</td></tr>
                <tr><th><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_number'];?>
 </th><td><a class="link_text" href="<?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_details'];?>
"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_orders_id'];?>
</a></td></tr>
            </table>
            <a class="btn_blue btn_with230 margin_top_10" href="<?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_details'];?>
"><?php echo @constant('TEXT_VIEW_DETAILS');?>
</a>
			<?php if ($_smarty_tpl->tpl_vars['message']->value['success_order_status']!=2&&$_smarty_tpl->tpl_vars['message']->value['success_order_status']!=42){?>                
                <a class="btn_blue btn_with230 margin_top_10" href="<?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_details'];?>
&continued_order=payment"><?php echo @constant('TEXT_MAKE_PAYMENT');?>
</a>
			<?php }?>
            <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['message']->value['use_all_balance'];?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1){?>
            <p><?php echo @constant('TEXT_BALANCE_TOTAL');?>
:<span class="price_color"> <?php echo $_smarty_tpl->tpl_vars['message']->value['balance_total'];?>
</span>.</p>
            <p><?php echo $_smarty_tpl->tpl_vars['message']->value['balance_use'];?>
</p>
            <p><?php echo @constant('TEXT_BALANCE_LEFT');?>
: <span class="price_color"><?php echo $_smarty_tpl->tpl_vars['message']->value['balance_remain'];?>
</span></p>
            <?php }?>
        </div>
        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['message']->value['use_all_balance'];?>
<?php $_tmp2=ob_get_clean();?><?php if (!$_tmp2){?>
        <div class="bottom_total">
            <h3><?php echo @constant('TEXT_ORDER_SUMMARY');?>
</h3>
            <table><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_total'];?>
</table>
        </div>
        <div class="bottom_comments">
            <h3><?php echo @constant('TEXT_SHIPPING_INVOECE_COMMENTS');?>
</h3>
            <table>
                <tr><th><?php echo $_smarty_tpl->tpl_vars['message']->value['success_shipping_address'];?>
:</th><td><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_shipping_address'];?>
</td></tr>
                <tr><th><?php echo $_smarty_tpl->tpl_vars['message']->value['success_shipping_method'];?>
:</th><td><?php echo $_smarty_tpl->tpl_vars['message']->value['success_shipping_method_text'];?>
</td></tr>
                <tr><th><?php echo @constant('TEXT_ESTSHIPPING_TIME');?>
:</th><td><?php echo $_smarty_tpl->tpl_vars['message']->value['shipping_days'];?>
</td></tr>
                <tr><th><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_cumments'];?>
:</th><td><?php echo $_smarty_tpl->tpl_vars['message']->value['order_comments'];?>
</td></tr>
            </table>
        </div>
        <?php }?>
    </div>
</div>
<!-- <div class="maincontent bordert">
    <div class="completecont">
      <h3 class="complete-tit"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_successfully'];?>
</h3>
      <p class="ordernum-time"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_number'];?>
 <ins><a href="<?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_details'];?>
"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_orders_id'];?>
</a></ins> <span><?php echo $_smarty_tpl->tpl_vars['message']->value['success_date'];?>
</span></p>  
      <h3 class="h3tit"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_payment_detailas'];?>
</h3> 
      <dl class="paydetail">
        <dt><?php echo $_smarty_tpl->tpl_vars['message']->value['success_payment_method'];?>
</dt><dd><?php echo $_smarty_tpl->tpl_vars['message']->value['success_payment_method_text'];?>
</dd>
        <?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_total'];?>

      </dl>
      <ul class="ordernow">
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_details'];?>
"><?php echo $_smarty_tpl->tpl_vars['message']->value['success_view_invoice'];?>
</a></li><li><a style="color:#008fed;font-weight:bold;font-size:13px;">
                      <?php if ($_smarty_tpl->tpl_vars['message']->value['success_order_status']==2){?>
                      <?php echo $_smarty_tpl->tpl_vars['message']->value['success_you_ve_made_payment'];?>

                      <?php }elseif($_smarty_tpl->tpl_vars['message']->value['success_order_status']==42){?>
                      <?php echo $_smarty_tpl->tpl_vars['message']->value['success_payment_under_checking'];?>

                      <?php }else{ ?>
                      <?php echo $_smarty_tpl->tpl_vars['message']->value['success_unpaid'];?>

                      <?php }?></a></li>
      </ul>
      <div class="shiporder">
        <p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['success_shipping_method'];?>
:</strong><?php echo $_smarty_tpl->tpl_vars['message']->value['success_shipping_method_text'];?>
</p>
        <p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['success_shipping_address'];?>
: </strong><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_shipping_address'];?>
</p>
        <p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_cumments'];?>
:</strong><?php echo $_smarty_tpl->tpl_vars['message']->value['order_comments'];?>
 </p>
      </div>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['message']->value['checkout_payment_size']>0){?>
    <dl class="accountpay_tips">
       <dd><ins></ins></dd>
       <dt><p><?php echo $_smarty_tpl->tpl_vars['message']->value['checkout_payment'];?>
</p>
       </dt>
      <div class="clear"></div>
    </dl>
    <?php }?>
</div> --><?php }} ?>