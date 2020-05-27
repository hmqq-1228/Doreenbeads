<?php /* Smarty version Smarty-3.1.13, created on 2020-04-27 14:54:24
         compiled from "includes\templates\account\tpl_account_history_info.html" */ ?>
<?php /*%%SmartyHeaderCode:63035ea681a05109e0-96209083%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c73ad01a735618b4265ed947d59ebce0d8482a4' => 
    array (
      0 => 'includes\\templates\\account\\tpl_account_history_info.html',
      1 => 1586330285,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63035ea681a05109e0-96209083',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'message' => 0,
    'orders' => 0,
    'payment_details_str' => 0,
    'payment_selection' => 0,
    'order' => 0,
    'WMdisplay' => 0,
    'Qiwidisplay' => 0,
    'confirmation' => 0,
    'currencies_array' => 0,
    'orderId' => 0,
    'paymentOrderId' => 0,
    'lastName' => 0,
    'firstName' => 0,
    'shippingFirstName' => 0,
    'shippingLastName' => 0,
    'shippingStreet' => 0,
    'shippingState' => 0,
    'shippinCountryCode' => 0,
    'shippinZip' => 0,
    'merchantRef' => 0,
    'price' => 0,
    'countryCode' => 0,
    'lanuageCode' => 0,
    'currencyCode' => 0,
    'shippingCity' => 0,
    'phoneNumber' => 0,
    'email' => 0,
    'city' => 0,
    'state' => 0,
    'street' => 0,
    'type' => 0,
    'text_countries_list' => 0,
    'paypal_payment_message' => 0,
    'total_products' => 0,
    'orders_array' => 0,
    'k' => 0,
    'val' => 0,
    'gift_id' => 0,
    'order_products_review_split_str' => 0,
    'statusArray' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5ea681a09b9911_07430216',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ea681a09b9911_07430216')) {function content_5ea681a09b9911_07430216($_smarty_tpl) {?><script>window.lang_wdate='<?php echo $_SESSION['languages_code'];?>
';</script>
<script type="text/javascript" src="includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
  	var tempCount = 0, strDivID = "";
  	function ShowMessage(Msg,UploadingTipId) {
      alert(Msg);
      var uploadingTip = $j("#" + UploadingTipId).html();
      if (uploadingTip.length > 0) {
          $j("#" + UploadingTipId).html("");
      }
  	}

    function showUploadingFile(FileName,UploadingTipId) {
		$j("#" + UploadingTipId).html("<img width='20' width='20' src='includes/templates/cherry_zen/images/zen_loader.gif'>");
		$j("#" + UploadingTipId).show();
    }
    
    function showAttachmentFile(FileName,NewFileName,FileSize,UploadingTipId) {
		$j("#" + UploadingTipId).html('');
		if(FileName.substr(FileName.lastIndexOf('.')+1).toLowerCase() == 'pdf'){
			$j("#" + UploadingTipId).html(FileName+' <a href="javascript:void(0)" onclick="del_file(\''+UploadingTipId+'\')">delete</a>');
		}else{
			$j("#" + UploadingTipId).html('<img src="'+NewFileName+'" height="80px" width="80px" class="jq_showBigImg" /> <a href="javascript:void(0)" onclick="del_file(\''+UploadingTipId+'\')"><?php echo @constant('TEXT_DELETE');?>
</a>');
		}		
		$j("#payment_" + UploadingTipId).val(NewFileName);
		$j("#payment_file_" + UploadingTipId).hide();
    }
  
</script>

	<p class="ordertit"><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['header_title'];?>
</strong></p>
	<p class="ordernum"><strong><?php echo @constant('TEXT_OD_ORDER_NUMBER');?>
:</strong> <span class="order_details_oid"><?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
</span>      <span><?php echo $_smarty_tpl->tpl_vars['orders']->value['date_purchased_format'];?>
</span></p>
	<?php if ($_smarty_tpl->tpl_vars['orders']->value['order_status']!=0){?>
	<div class="orderprocess">
		<ul>
			<?php if ($_smarty_tpl->tpl_vars['orders']->value['order_status']==1||$_smarty_tpl->tpl_vars['orders']->value['order_status']==42){?>
			<li class="pend">
				<strong class="greenbold"><?php echo @constant('TEXT_ORDER_STATUS_PENDING');?>
</strong><ins class="qustion_icontips"></ins>
				<div class="nowdiv">					
					<div class="orderprocess_tips">
						<span class="bot"></span>
						<span class="top"></span>
						<?php echo @constant('TEXT_STATUS_PENDING_NOTE');?>

					</div>
            	</div>
			</li>
			<li class="process"><strong ><?php echo @constant('TEXT_ORDER_STATUS_PROCESSING');?>
</strong></li>
			<li class="ship"><strong><?php echo @constant('TEXT_ORDER_STATUS_SHIPPED');?>
</strong></li>
			<?php }?>
			
			<?php if ($_smarty_tpl->tpl_vars['orders']->value['order_status']==2){?>
			<li class="pendnext"><strong><?php echo @constant('TEXT_ORDER_STATUS_PENDING');?>
</strong></li>
			<li class="processnext">
				<strong class="greenbold"><?php echo @constant('TEXT_ORDER_STATUS_PROCESSING');?>
</strong><ins class="qustion_icontips"></ins>
				<div class="nowdiv">
					<div class="orderprocess_tips">
						<span class="bot"></span>
						<span class="top"></span>
						<?php echo @constant('TEXT_STATUS_PROCESSING_NOTE');?>

					</div>
            	</div>
			</li>
			<li class="ship"><strong><?php echo @constant('TEXT_ORDER_STATUS_SHIPPED');?>
</strong></li>
			<?php }?>
			
			<?php if ($_smarty_tpl->tpl_vars['orders']->value['order_status']==3){?>
			<li class="pendnext"><strong><?php echo @constant('TEXT_ORDER_STATUS_PENDING');?>
</strong></li>
			<li class="processthre"><strong><?php echo @constant('TEXT_ORDER_STATUS_PROCESSING');?>
</strong></li>
			<li class="shipthre">
				<strong class="greenbold"><?php echo @constant('TEXT_ORDER_STATUS_SHIPPED');?>
</strong><ins class="qustion_icontips"></ins>
				<div class="nowdiv">
					<div class="orderprocess_tips">
						<span class="bot"></span>
						<span class="top"></span>
						<?php echo @constant('TEXT_STATUS_SHIPPED_NOTE');?>

					</div>
            	</div>
			</li>
			<?php }?>			
			
			<?php if ($_smarty_tpl->tpl_vars['orders']->value['order_status']==4){?>
			<li class="pendnext"><strong><?php echo @constant('TEXT_ORDER_STATUS_PENDING');?>
</strong></li>
			<li class="processthre"><strong><?php echo @constant('TEXT_ORDER_STATUS_PROCESSING');?>
</strong></li>
			<li class="processthre"><strong><?php echo @constant('TEXT_ORDER_STATUS_SHIPPED');?>
</strong></li>
			<li class="shipthre">
				<strong class="greenbold"><?php echo @constant('TEXT_ORDER_STATUS_UPDATE');?>
</strong><ins class="qustion_icontips"></ins>
				<div class="nowdiv">
					<div class="orderprocess_tips">
						<span class="bot"></span>
						<span class="top"></span>
						<?php echo @constant('TEXT_STATUS_UPDATE_NOTE');?>

					</div>
            	</div>
			</li>
			<?php }?>
		</ul>       
	</div>
	<?php }?>
	
	<?php if ($_smarty_tpl->tpl_vars['message']->value['make_payment']){?>
	
	<p class="itemstit"><?php echo @constant('TEXT_PAYMENT_DETAILS');?>
</p>
	<div class="order_calculate_price">
		<table class="paydetail">                
			<?php echo $_smarty_tpl->tpl_vars['payment_details_str']->value;?>

		</table>
	</div>    
	<div id="errorMessage" style="font-size:14px;line-height:20px;padding-bottom:10px;color:#C00;"></div>
	<div class=caption_shopgray><h3><?php echo @constant('TEXT_PAYMENT_METHODS');?>
</h3></div>
	<form name="checkout_payment" action="index.php?main_page=continued_order" method="post" onsubmit="return check_form(this);">
		<input type="hidden" name="orders_id" value="<?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
">
		<div class="payment_cont paymentwap">			
			<div class="left">
				<ul>
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['payment_selection']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						<?php if ($_smarty_tpl->tpl_vars['message']->value['order_total_no_currency_left']<$_smarty_tpl->tpl_vars['message']->value['order_total_wire_min']&&($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='wire'||$_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='wirebc')){?>
						<?php }else{ ?>
							<?php if ($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']!='alipay'&&$_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']!='moneygram'){?>
								<?php if ($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']!='paypalmanually'){?>
									<li type="<?php echo $_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" <?php if (($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']&&$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']!='gcCreditCard')||(($_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']==''||$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='Balance'||$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='gcCreditCard'||($_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='webMoney'&&$_smarty_tpl->tpl_vars['WMdisplay']->value=='webMoney')||($_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='QIWI'&&$_smarty_tpl->tpl_vars['Qiwidisplay']->value=='QIWI'))&&$_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='paypalwpp')){?>class="chose"<?php }?>><label><input style="position: relative;top: 10px;margin-left: 10px;"  name="payment" type="radio" value="<?php echo $_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" <?php if (($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']&&$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']!='gcCreditCard')||(($_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']==''||$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='Balance'||$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='gcCreditCard'||($_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='webMoney'&&$_smarty_tpl->tpl_vars['WMdisplay']->value=='webMoney')||($_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='QIWI'&&$_smarty_tpl->tpl_vars['Qiwidisplay']->value=='QIWI'))&&$_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='paypalwpp')){?>checked="checked"<?php }?> />
									<?php if ($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='paypalwpp'){?><ins class="icon_pay_Paypal"></ins><?php echo @constant('TEXT_PAYMENT_PAYPAL');?>

									<?php }elseif($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='wire'){?><ins class="icon_pay_HSBC"></ins><?php echo @constant('TEXT_PAYMENT_HSBC');?>

									<?php }elseif($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='wirebc'){?><ins class="icon_pay_China"></ins><?php echo @constant('TEXT_PAYMENT_BC');?>

									<?php }elseif($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='westernunion'){?><ins class="icon_pay_Union"></ins><?php echo @constant('TEXT_PAYMENT_WESTERN');?>

									<?php }elseif($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='gcCreditCard'){?><ins class="icon_pay_Card"></ins><?php echo @constant('MODULE_PAYMENT_GCCREDITCARD_TEXT_HEAD');?>

									<?php }elseif($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='braintree'){?><ins class="icon_pay_braintree"></ins><?php echo @constant('MODULE_PAYMENT_BRAINTREE_TEXT_HEAD');?>

									<?php }elseif($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='braintree-google'){?><ins class="icon_pay_braintree_google"></ins><strong>Google Pay</strong>
									<?php }elseif($_smarty_tpl->tpl_vars['payment_selection']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id']=='braintree-apple'){?><ins class="icon_pay_braintree_apple"></ins><strong>Apple Pay</strong>
									<?php }?>
								</label></li>
								<?php }?>
							<?php }?>
						<?php }?>
					<?php endfor; endif; ?>
					
					<li type="moneygram" <?php if ('moneygram'==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']){?>class="chose"<?php }?>><label><input style="position: relative;top: 10px;margin-left: 10px;"  name="payment" type="radio" value="moneygram" <?php if ('moneygram'==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']){?>checked="checked"<?php }?> /><ins class="icon_money_gram"></ins><?php echo @constant('TEXT_PAYMENT_MONEY_GRAM');?>
</label></li>
				</ul>
			</div>
			
			<div class="right">
				<!--	paypal	-->
				<div class="right_cont_chinabank right_cont_paypalwpp <?php if ('paypalwpp'==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']||($_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']==''||$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='Balance'||$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='gcCreditCard'||($_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='webMoney'&&$_smarty_tpl->tpl_vars['WMdisplay']->value=='webMoney')||($_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']=='QIWI'&&$_smarty_tpl->tpl_vars['Qiwidisplay']->value=='QIWI'))){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<div class="txt_paypal">
						<p>
							<img src="<?php echo @constant('HTTP_SERVER');?>
/includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>
/btn_xpressCheckout_243x40.png" />
							<img src="https://www.paypalobjects.com/digitalassets/c/website/marketing/na/us/logo-center/9_bdg_secured_by_pp_2line.png" border="0" alt="Secured by PayPal">
						</p>
						<p>
							<ins class="arrow"></ins>
							<span><?php echo @constant('TEXT_PAYMENT_PAY_US_CLICK');?>
</span>
						</p>
						<p>
							<button class="paynow_btn jq_paypalwpp" data-url="index.php?main_page=continued_order&payment=paypalwpp&orders_id=<?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
" id="paypalwpp">
								<span>
									<strong><?php echo $_smarty_tpl->tpl_vars['message']->value['account_pay_now'];?>
</strong>
								</span>
							</button>
						</p>
						<p>
							<ins class="arrow"></ins>
							<span><?php echo @constant('TEXT_PAYMENT_OR_DIRECTLY_LOGIN');?>
</span>
						</p>
						<div class="clear"></div>
					</div>
				</div>
				<!--	braintree	-->
				<div class="right_cont_chinabank right_cont_braintree  <?php if ('braintree'==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']||'braintree-credit'==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<iframe id="braintree_iframe" scrolling="auto" width="550" frameborder=0 src="<?php echo @constant('HTTP_SERVER');?>
/index.php?main_page=checkout_braintree&order_id=<?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
&action=credit&go=" style="height:300px;"></iframe>
				</div>

				<div class="right_cont_chinabank right_cont_braintree-google <?php if ('braintree-google'==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<iframe id="braintree_iframe" scrolling="auto" width="550" frameborder=0 src="<?php echo @constant('HTTP_SERVER');?>
/index.php?main_page=checkout_braintree&order_id=<?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
&action=google&go=" style="height:300px;"></iframe>
				</div>

				<div class="right_cont_chinabank right_cont_braintree-apple <?php if ('braintree-apple'==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<iframe id="braintree_iframe" scrolling="auto" width="550" frameborder=0 src="<?php echo @constant('HTTP_SERVER');?>
/index.php?main_page=checkout_braintree&order_id=<?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
&action=apple&go=" style="height:300px;"></iframe>
				</div>


				<!--	HSBC	-->
				<div class="right_cont_chinabank right_cont_wire <?php if ('wire'==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>					
					<div class="txt_chinabank">						
						<h5><span><?php echo @constant('TEXT_PAYMENT_BANK_HSBC');?>
</span><a href="<?php echo @constant('HTTP_SERVER');?>
/payment_files/<?php echo $_SESSION['languages_code'];?>
/Bank_Transfer(Citibank).txt" target="_blank" class="print" title="<?php echo @constant('TEXT_PAYMENT_PRINT');?>
"></a>
                        <a class="download" title="<?php echo @constant('TEXT_DOWNLOAD');?>
" target="_blank" href="<?php echo @constant('HTTP_SERVER');?>
/payment_files/<?php echo $_SESSION['languages_code'];?>
/Bank_Transfer(Citibank).doc"></a></h5>
						<?php echo $_smarty_tpl->tpl_vars['confirmation']->value['wire']['title'];?>

						<div class="borderbt"></div>
						<p><?php echo @constant('TEXT_FILL_OUT');?>
</p>
						<table cellpadding="0" cellspacing="0" class="fill_info">
							<tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_ACOOUNT_ORDER_NO');?>
:</th>
                                <td><?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
</td>
                            </tr>
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_ACOOUNT_YOUR_NAME');?>
:</th>
                                <td><input type="text" id="hsbs_yname" name="hsbs_yname"/><br><span class="font_red error_payment"></span></td>
                            </tr>
                            <tr>
                            	<th width="135"><span class="font_red">*</span> <?php echo @constant('TEXT_CURRENCY');?>
:</th>
                                <td>
                                	<p class="select3">
	                                	<span class="text_left7"><?php echo $_smarty_tpl->tpl_vars['message']->value['default_currency'];?>
</span>
	                                	<span class="arrow_right7"><ins></ins></span>
                                	</p>
                                	<ul class="selectlist7">
	                                	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['currencies_array']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	                                	<li><?php echo $_smarty_tpl->tpl_vars['currencies_array']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['symbol_left'];?>
</li>
	                                	<?php endfor; endif; ?>
	                                	<li><?php echo @constant('TEXT_OTHERS');?>
</li>
                                	</ul>
                                	<input type="hidden" id="hsbs_Currency" name="hsbs_Currency" value="<?php echo $_smarty_tpl->tpl_vars['message']->value['default_currency'];?>
"/>
                                </td>
                            </tr>
                            
                             <tr>
                            	<th></th>
                            	<td style="display:none">
                            	<input type="text" value="" name="hsbs_Currency_input"/><span><?php echo @constant('TEXT_YOUR_CURRENCY');?>
</span>
                            	<br/>  	
                            	<span  class="font_red error_payment"></span>
                            	</td>
                            </tr>
                            
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_SUM');?>
:</th>
                                <td><input type="text" id="hsbs_amout" name="hsbs_amout"/><br><span class="font_red error_payment"></span></td>
                            </tr>
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_PAYMENT_DATE');?>
:</th>
                                <td>
                                	<input class="date" value="" type="text" id="hsbs_date" name="hsbs_date" onclick="WdatePicker();"><br>
                                	<span class="font_red error_payment"></span>
                                </td>
                            </tr>
                            <tr>
                            	<th><span class="font_w">&nbsp;</span> <?php echo @constant('TEXT_PAYMENT_REDEIPT');?>
:</th>
                                <td>
                                	<input type="hidden" id="payment_loading_hsbs" name="hsbs_file" id="hsbs_file">
                                	<div id="payment_file_loading_china">
                                	<embed type="application/x-shockwave-flash" allowscriptaccess="always" quality="high" flashvars="postUrl=<?php echo @constant('HTTP_SERVER');?>
/image_upload.php?Action=TicketFilePath&amp;maxSize=2097152&amp;minSize=0&amp;fileType=*.gif;*.png;*.jpeg;*.jpg;*.pdf;*.bmp;&amp;alertFun=ShowMessage&amp;upInfo=showUploadingFile&amp;pullBack=showAttachmentFile&amp;testAlert=flash_test&amp;UploadingTipId=loading_hsbs&amp;isAllowCNFileName=true&amp;postData=username=xm;userpassword=123;upath=/tmp" wmode="transparent" palette="transparent|transparent" src="flash/SimpleSwfupload.swf" name="SimpleSwfupload" class="divComposeAttachFlash_Object" style="background:url('includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>
/btnbrowse.gif') no-repeat scroll 0 0 transparent;height: 27px;width:134px;position:relative;">
                                	</embed>
                                	</div>
                                	<p style="display:none" id="loading_hsbs"></p>
									<p class="txt_tip">(.gif / .png / .jpeg / .jpg / .bmp / .pdf), less than 2M.</p>
                                </td>
                            </tr>
                            <tr>
                            	<th></th>
                                <td>
                                    <p class="txt_tip"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_prompt'];?>
</p> 
                                </td>
                            </tr>
                            <tr>
                            	<th></th>
                                <td>
                                    <button class="paynow_btn"><?php echo @constant('TEXT_SUBMIT');?>
</button>
                                </td>
                            </tr>
                        </table>
					</div>
				</div>
				
				<!--	Bank of China	-->
				<div class="right_cont_chinabank right_cont_wirebc <?php if ('wirebc'==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>					
					<div class="txt_chinabank">						
						<h5><span><?php echo @constant('TEXT_PAYMENT_BANK_CHINA');?>
</span><a href="<?php echo @constant('HTTP_SERVER');?>
/payment_files/<?php echo $_SESSION['languages_code'];?>
/Bank_Transfer(Bank_of_China).txt" target="_blank" class="print" title="<?php echo @constant('TEXT_PAYMENT_PRINT');?>
"></a>
                        <a class="download" title="<?php echo @constant('TEXT_DOWNLOAD');?>
" target="_blank" href="<?php echo @constant('HTTP_SERVER');?>
/payment_files/<?php echo $_SESSION['languages_code'];?>
/Bank_Transfer(Bank_of_China).doc"></a></h5>
						<?php echo $_smarty_tpl->tpl_vars['confirmation']->value['wirebc']['title'];?>

						<div class="borderbt"></div>
						<p><?php echo @constant('TEXT_FILL_OUT');?>
</p>
						<table cellpadding="0" cellspacing="0" class="fill_info">
							<tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_ACOOUNT_ORDER_NO');?>
:</th>
                                <td><?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
</td>
                            </tr>
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_ACOOUNT_YOUR_NAME');?>
:</th>
                                <td><input type="text" id="china_yname" name="china_yname"/><br><span class="font_red error_payment"></span></td>
                            </tr>
                            <tr>
                            	<th width="135"><span class="font_red">*</span> <?php echo @constant('TEXT_CURRENCY');?>
:</th>
                                <td>
                                	<p class="select3">
	                                	<span class="text_left7"><?php echo $_smarty_tpl->tpl_vars['message']->value['default_currency'];?>
</span>
	                                	<span class="arrow_right7"><ins></ins></span>                                	
                                	</p>
                                	<ul class="selectlist7">
	                                	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['currencies_array']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	                                	<li><?php echo $_smarty_tpl->tpl_vars['currencies_array']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['symbol_left'];?>
</li>
	                                	<?php endfor; endif; ?>
	                                <!--  othersѡ��	<li><?php echo @constant('TEXT_OTHERS');?>
</li> -->
                                	</ul>
                                	<input type="hidden" id="china_Currency" name="china_Currency" value="<?php echo $_smarty_tpl->tpl_vars['message']->value['default_currency'];?>
"/>
                                </td>
                            </tr>
                            
                        <!--     <tr>
                            	<th></th>
                            	<td style="display:none" >
                            	<input type="text" value="" name="china_Currency_input"/><span><?php echo @constant('TEXT_YOUR_CURRENCY');?>
</span>
                            	<br/>  	
                            	<span  class="font_red error_payment"></span>
                            	</td>
                            </tr> -->
                            
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_SUM');?>
:</th>
                                <td><input type="text" id="china_amout" name="china_amout"/><br><span class="font_red error_payment"></span></td>
                            </tr>
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_PAYMENT_DATE');?>
:</th>
                                <td>
                                	<input class="date" value="" type="text" id="china_date" name="china_date" onclick="WdatePicker();"><br>
                                	<span class="font_red error_payment"></span>
                                </td>
                            </tr>
                            <tr>
                            	<th><span class="font_w">&nbsp;</span> <?php echo @constant('TEXT_PAYMENT_REDEIPT');?>
:</th>
                                <td>
                                	<input type="hidden" id="payment_loading_china" name="china_file" id="china_file">
                                	<div id="payment_file_loading_china">
                                	<embed type="application/x-shockwave-flash" allowscriptaccess="always" quality="high" flashvars="postUrl=<?php echo @constant('HTTP_SERVER');?>
/image_upload.php?Action=TicketFilePath&amp;maxSize=2097152&amp;minSize=0&amp;fileType=*.gif;*.png;*.jpeg;*.jpg;*.pdf;*.bmp;&amp;alertFun=ShowMessage&amp;upInfo=showUploadingFile&amp;pullBack=showAttachmentFile&amp;testAlert=flash_test&amp;UploadingTipId=loading_china&amp;isAllowCNFileName=true&amp;postData=username=xm;userpassword=123;upath=/tmp" wmode="transparent" palette="transparent|transparent" src="flash/SimpleSwfupload.swf" name="SimpleSwfupload" class="divComposeAttachFlash_Object" style="background:url('includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>
/btnbrowse.gif') no-repeat scroll 0 0 transparent;height: 27px;width:134px;position:relative;">
                                	</embed>
                                	</div>
                                	<p style="display:none" id="loading_china"></p>
                                	<p class="txt_tip">(.gif / .png / .jpeg / .jpg / .bmp / .pdf), less than 2M.</p>
                                </td>
                            </tr>
                            <tr>
                            	<th></th>
                                <td>
                                    <p class="txt_tip"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_prompt'];?>
</p> 
                                </td>
                            </tr>
                            <tr>
                            	<th></th>
                                <td>
                                    <button class="paynow_btn"><?php echo @constant('TEXT_SUBMIT');?>
</button>
                                </td>
                            </tr>
                        </table>
					</div>
				</div>

				<!--	Westerm Union	-->
				<div class="right_cont_chinabank right_cont_westernunion <?php if ('westernunion'==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>					
					<div class="txt_chinabank">						
						<h5><span><?php echo @constant('TEXT_PAYMENT_BANK_WESTERN_UNION');?>
</span><a href="<?php echo @constant('HTTP_SERVER');?>
/payment_files/<?php echo $_SESSION['languages_code'];?>
/Western_Union.txt" target="_blank" class="print" title="<?php echo @constant('TEXT_PAYMENT_PRINT');?>
"></a>
                        <a class="download" title="<?php echo @constant('TEXT_DOWNLOAD');?>
" target="_blank" href="<?php echo @constant('HTTP_SERVER');?>
/payment_files/<?php echo $_SESSION['languages_code'];?>
/Western_Union.doc"></a></h5>
						<?php echo $_smarty_tpl->tpl_vars['confirmation']->value['westernunion']['title'];?>

						<div class="borderbt"></div>
						<p><?php echo @constant('TEXT_FILL_OUT');?>
</p>
						<table cellpadding="0" cellspacing="0" class="fill_info">
							<tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_ACOOUNT_ORDER_NO');?>
:</th>
                                <td><?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
</td>
                            </tr>
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_ACOOUNT_YOUR_NAME');?>
:</th>
                                <td><input type="text" id="western_yname" name="western_yname"/><br><span class="font_red error_payment"></span></td>
                            </tr>
                            <tr>
                            	<th width="135"><span class="font_red">*</span> <?php echo @constant('TEXT_CURRENCY');?>
:</th>
                                <td>
                                	<p class="select3">
	                                	<span class="text_left7"><?php echo $_smarty_tpl->tpl_vars['message']->value['default_currency'];?>
</span>
	                                	<span class="arrow_right7"><ins></ins></span>                                	
                                	</p>
                                	<ul class="selectlist7">
	                                	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['currencies_array']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	                                	<li><?php echo $_smarty_tpl->tpl_vars['currencies_array']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['symbol_left'];?>
</li>
	                                	<?php endfor; endif; ?>
	                                	<li><?php echo @constant('TEXT_OTHERS');?>
</li>
                                	</ul>
                                	<input type="hidden" id="western_Currency" name="western_Currency" value="<?php echo $_smarty_tpl->tpl_vars['message']->value['default_currency'];?>
"/>
                                </td>                             
                            </tr>
                            
                            <tr>
                            	<th></th>
                            	<td style="display:none">
                            	<input type="text" value="" name="western_Currency_input"/><span><?php echo @constant('TEXT_YOUR_CURRENCY');?>
</span>
                            	<br/>  	
                            	<span  class="font_red error_payment"></span>
                            	</td>
                            </tr>
                            
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_SUM');?>
:</th>
                                <td><input type="text" id="western_amout" name="western_amout"/><br><span class="font_red error_payment"></span></td>
                            </tr>
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_CONTROL_NO');?>
:</th>
                                <td><input type="text" id="western_control_no" name="western_control_no"/><p class="txt_tip"><?php echo @constant('TEXT_PAYMENT_WESTERN_CONTROL_NO');?>
</p><span class="font_red error_payment"></span></td>
                            </tr>                            
                            <tr>
                            	<th><span class="font_w">&nbsp;</span> <?php echo @constant('TEXT_PAYMENT_REDEIPT');?>
:</th>
                                <td>
                                	<input type="hidden" id="payment_loading_western" name="western_file" id="western_file">
                                	<div id="payment_file_loading_western">
                                	<embed type="application/x-shockwave-flash" allowscriptaccess="always" quality="high" flashvars="postUrl=<?php echo @constant('HTTP_SERVER');?>
/image_upload.php?Action=TicketFilePath&amp;maxSize=2097152&amp;minSize=0&amp;fileType=*.gif;*.png;*.jpeg;*.jpg;*.pdf;*.bmp;&amp;alertFun=ShowMessage&amp;upInfo=showUploadingFile&amp;pullBack=showAttachmentFile&amp;testAlert=flash_test&amp;UploadingTipId=loading_western&amp;isAllowCNFileName=true&amp;postData=username=xm;userpassword=123;upath=/tmp" wmode="transparent" palette="transparent|transparent" src="flash/SimpleSwfupload.swf" name="SimpleSwfupload" class="divComposeAttachFlash_Object" style="background:url('includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>
/btnbrowse.gif') no-repeat scroll 0 0 transparent;height: 27px;width:134px;position:relative;">
                                	</embed>
                                	</div>
                                	<p style="display:none" id="loading_western"></p>
                                	<p class="txt_tip">(.gif / .png / .jpeg / .jpg / .bmp / .pdf), less than 2M.</p>
                                </td>
                            </tr>
                            <tr>
                            	<th></th>
                                <td>
                                    <p class="txt_tip"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_prompt'];?>
</p> 
                                </td>
                            </tr>
                            <tr>
                            	<th></th>
                                <td>
                                    <button class="paynow_btn"><?php echo @constant('TEXT_SUBMIT');?>
</button>
                                </td>
                            </tr>
                        </table>
					</div>
				</div>
				<!-- open or close gcCreditCard	-->
				<?php if ($_smarty_tpl->tpl_vars['message']->value['show_gc_payment']&&1==2){?>
				<!--	Credit Card via Paypal	-->
				<div class="right_cont_chinabank right_cont_gcCreditCard">
					<div id="paymentInfo">
						<input type="hidden" id="orderId" value="<?php echo $_smarty_tpl->tpl_vars['orderId']->value;?>
" />
						<input type="hidden" id="paymentOrderId" value="<?php echo $_smarty_tpl->tpl_vars['paymentOrderId']->value;?>
" />
						<input type="hidden" id="lastName" value="<?php echo $_smarty_tpl->tpl_vars['lastName']->value;?>
" />
						<input type="hidden" id="firstName" value="<?php echo $_smarty_tpl->tpl_vars['firstName']->value;?>
" />
						<input type="hidden" id="shippingFirstName" value="<?php echo $_smarty_tpl->tpl_vars['shippingFirstName']->value;?>
" />
						<input type="hidden" id="shippingLastName" value="<?php echo $_smarty_tpl->tpl_vars['shippingLastName']->value;?>
" />
						<input type="hidden" id="shippingStreet" value="<?php echo $_smarty_tpl->tpl_vars['shippingStreet']->value;?>
" />
						<input type="hidden" id="shippingState" value="<?php echo $_smarty_tpl->tpl_vars['shippingState']->value;?>
" />
						<input type="hidden" id="shippinCountryCode" value="<?php echo $_smarty_tpl->tpl_vars['shippinCountryCode']->value;?>
" />
						<input type="hidden" id="shippinZip" value="<?php echo $_smarty_tpl->tpl_vars['shippinZip']->value;?>
" />
						<input type="hidden" id="merchantRef" value="<?php echo $_smarty_tpl->tpl_vars['merchantRef']->value;?>
" />
						<input type="hidden" id="price" value="<?php echo $_smarty_tpl->tpl_vars['price']->value*100;?>
" />
						<input type="hidden" id="countryCode" value="<?php echo $_smarty_tpl->tpl_vars['countryCode']->value;?>
" />
						<input type="hidden" id="lanuageCode" value="<?php echo $_smarty_tpl->tpl_vars['lanuageCode']->value;?>
" />
						<input type="hidden" id="currencyCode" value="<?php echo $_smarty_tpl->tpl_vars['currencyCode']->value;?>
" />
						<input type="hidden" id="shippingCity" value="<?php echo $_smarty_tpl->tpl_vars['shippingCity']->value;?>
" />
						<input type="hidden" id="phoneNumber" value="<?php echo $_smarty_tpl->tpl_vars['phoneNumber']->value;?>
" />
						<input type="hidden" id="email" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" />
						<input type="hidden" id="city" value="<?php echo $_smarty_tpl->tpl_vars['city']->value;?>
" />
						<input type="hidden" id="state" value="<?php echo $_smarty_tpl->tpl_vars['state']->value;?>
" />
						<input type="hidden" id="street" value="<?php echo $_smarty_tpl->tpl_vars['street']->value;?>
" />
						<input type="hidden" id="type" value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" />
						<input type="hidden" id="http_server" value="<?php echo @constant('HTTP_SERVER');?>
" />
						
					</div>
					<div class="txt_card">            	
						<ul style="float: left;padding-left: 7px;width: auto;">
							<li style="float: left;padding: 0 20px 0 0; height: auto;" >
								<input class="gcPayment" style="margin: 9px 10px 0 0;float: left;" type="radio" value="1" id="CreditCardType_1" name="CreditCardType" checked="checked">
								<label for="CreditCardType_1" class="PayType" style="background: url('<?php echo @constant('HTTPS_SERVER');?>
/pic/visa.jpg') no-repeat;padding-left: 37px;margin: 5px 0 0 22px;display: block;">Visa</label>
								
							</li>
							<li style="float: left;padding: 0 20px 0 0; height: auto;">
								<input class="gcPayment" style="margin: 9px 10px 0 0;float: left;" type="radio" value="3" id="CreditCardType_3" name="CreditCardType">
								<label for="CreditCardType_3" class="PayType" style="background: url('<?php echo @constant('HTTPS_SERVER');?>
/pic/icon-master.jpg') no-repeat;padding-left: 37px;margin: 5px 0 0 22px;display: block;">Master Card</label>
							</li>
						</ul>
					</div>
					<div class="payDetail">
						<div id="loading">
							<img style="margin-top: 10px;text-align:center;margin-top:40px;" src="<?php echo @constant('HTTPS_SERVER');?>
/pic/loader.gif" alt="">
						</div>
						<div id="payIframe">
							<iframe id="gcFormActionUrl" scrolling="auto" width="445" frameborder=0 height="280" src=""></iframe>
						</div>
					</div>
				</div>
				<?php }?>
				<!--	Monry Gram	-->
				<div class="right_cont_chinabank right_cont_moneygram <?php if ('moneygram'==$_smarty_tpl->tpl_vars['order']->value->info['payment_module_code']){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>					
					<div class="txt_chinabank">						
						<h5><span><?php echo @constant('TEXT_PAYMENT_MONEY_GRAM');?>
</span><a href="<?php echo @constant('HTTP_SERVER');?>
/payment_files/<?php echo $_SESSION['languages_code'];?>
/Money_Gram.txt" target="_blank" class="print" title="<?php echo @constant('TEXT_PAYMENT_PRINT');?>
"></a>
                        <a class="download" title="<?php echo @constant('TEXT_DOWNLOAD');?>
" target="_blank" href="<?php echo @constant('HTTP_SERVER');?>
/payment_files/<?php echo $_SESSION['languages_code'];?>
/Money_Gram.doc"></a></h5>
						<?php echo $_smarty_tpl->tpl_vars['confirmation']->value['moneygram']['title'];?>
				 
						<div class="borderbt"></div>
						<p><?php echo @constant('TEXT_FILL_OUT');?>
</p>
						<table cellpadding="0" cellspacing="0" class="fill_info">
							<tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_ACOOUNT_ORDER_NO');?>
:</th>
                                <td><?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
</td>
                            </tr>
							<tr>
                            	<th width="150"><span class="font_red">*</span> <?php echo @constant('TEXT_YOUR_FULL_NAME');?>
:</th>
                                <td><input type="text" id="moneygram_full_name" name="moneygram_full_name"/><br><span class="font_red"><?php echo @constant('TEXT_ACCONT_ENTER_REMITTER');?>
</span></td>
                            </tr>
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_YOUR_COUNTRY');?>
:</th>
                                <td><?php echo $_smarty_tpl->tpl_vars['text_countries_list']->value;?>
</td>
                            </tr>							
                            <tr>
                            	<th width="135"><span class="font_red">*</span> <?php echo @constant('TEXT_CURRENCY');?>
:</th>
                                <td>
                                	<p class="select3">
	                                	<span class="text_left7"><?php echo $_smarty_tpl->tpl_vars['message']->value['default_currency'];?>
</span>
	                                	<span class="arrow_right7"><ins></ins></span>                                	
                                	</p>
                                	<ul class="selectlist7">
	                                	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['currencies_array']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	                                	<li><?php echo $_smarty_tpl->tpl_vars['currencies_array']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['symbol_left'];?>
</li>
	                                	<?php endfor; endif; ?>
	                                	<li><?php echo @constant('TEXT_OTHERS');?>
</li>
                                	</ul>
                                	<input type="hidden" id="moneygram_Currency" name="moneygram_Currency" value="<?php echo $_smarty_tpl->tpl_vars['message']->value['default_currency'];?>
"/>
                                </td>
                            </tr>
                            
                            <tr>
                            	<th></th>
                            	<td style="display:none">
                            	<input type="text" value="" name="moneygram_Currency_input"/><span><?php echo @constant('TEXT_YOUR_CURRENCY');?>
</span>
                            	<br/>  	
                            	<span  class="font_red error_payment"></span>
                            	</td>
                            </tr>
                            
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_SUM');?>
:</th>
                                <td><input type="text" id="moneygram_amout" name="moneygram_amout"/><br><span class="font_red error_payment"></span></td>
                            </tr>
                            <tr>
                            	<th><span class="font_red">*</span> <?php echo @constant('TEXT_CONTROL_NO');?>
:</th>
                                <td><input type="text" id="moneygram_control_no" name="moneygram_control_no"/><p class="txt_tip"><?php echo @constant('TEXT_PAYMENT_MONEY_GRAM_CONTROL_NO');?>
</p><span class="font_red error_payment"></span></td>
                            </tr>                            
                            <tr>
                            	<th><span class="font_w">&nbsp;</span> <?php echo @constant('TEXT_PAYMENT_REDEIPT');?>
:</th>
                                <td>
                                	<input type="hidden" id="payment_loading_moneygram" name="moneygram_file" id="moneygram_file">
                                	<div id="payment_file_loading_moneygram">
                                	<embed type="application/x-shockwave-flash" allowscriptaccess="always" quality="high" flashvars="postUrl=<?php echo @constant('HTTP_SERVER');?>
/image_upload.php?Action=TicketFilePath&amp;maxSize=2097152&amp;minSize=0&amp;fileType=*.gif;*.png;*.jpeg;*.jpg;*.pdf;*.bmp;&amp;alertFun=ShowMessage&amp;upInfo=showUploadingFile&amp;pullBack=showAttachmentFile&amp;testAlert=flash_test&amp;UploadingTipId=loading_moneygram&amp;isAllowCNFileName=true&amp;postData=username=xm;userpassword=123;upath=/tmp" wmode="transparent" palette="transparent|transparent" src="flash/SimpleSwfupload.swf" name="SimpleSwfupload" class="divComposeAttachFlash_Object" style="background:url('includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>
/btnbrowse.gif') no-repeat scroll 0 0 transparent;height: 27px;width:134px;position:relative;">
                                	</embed>
                                	</div>
                                	<p style="display:none" id="loading_moneygram"></p>
                                	<p class="txt_tip">(.gif / .png / .jpeg / .jpg / .bmp / .pdf), less than 2M.</p>
                                </td>
                            </tr>
                            <tr>
                            	<th></th>
                                <td>
                                    <p class="txt_tip"><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_prompt'];?>
</p> 
                                </td>
                            </tr>
                            <tr>
                            	<th></th>
                                <td><button class="paynow_btn"><?php echo @constant('TEXT_SUBMIT');?>
</button></td>
                            </tr>
                        </table>
					</div>
				</div>
		  	</div>
			<div class="clear"></div>			
		</div>

		<div id="paypal_payment_box" <?php if (!$_smarty_tpl->tpl_vars['paypal_payment_message']->value){?> style="display:none;"<?php }?>>
			<p id="paypal_payment_message"><?php echo $_smarty_tpl->tpl_vars['paypal_payment_message']->value;?>
</p>
		</div>

		<!--	HSBC/bank of china	-->
		<div class="paynotes paynotes_wirebc paynotes_wire">
	        <p><strong><?php echo @constant('TEXT_NOTE');?>
:</strong></p>
	        <?php echo @constant('TEXT_PAYMENT_HSBS_CHINA');?>

	 	</div>
	 
		<!--	westerm union	-->
	 	<div class="paynotes paynotes_westernunion ">
        <p><strong><?php echo @constant('TEXT_NOTE');?>
: </strong></p><p>1. <?php echo @constant('TEXT_PAYMENT_NOTE_3');?>
 </p><p>2. <?php echo @constant('TEXT_PAYMENT_NOTE_2');?>
 </p>
		</div>
		<div class="paynotes  paynotes_moneygram">
        <p><strong><?php echo @constant('TEXT_NOTE');?>
: </strong></p><p>1. <?php echo @constant('TEXT_PAYMENT_NOTE_2');?>
 </p><p>2. <?php echo @constant('TEXT_PAYMENT_NOTE_3');?>
 </p>
		</div>
	</form>
	<?php }else{ ?>
	<div class="paydetails">
		<div class="payment fleft">
			<p class="paymenttit"><?php echo @constant('TEXT_PAYMENT_DETAILS');?>
</p>
			<table class="paydetail">
				<?php echo $_smarty_tpl->tpl_vars['payment_details_str']->value;?>

			</table>
			<div class="makepayment">
				<?php echo $_smarty_tpl->tpl_vars['orders']->value['makepayment_str'];?>

			</div>   
		</div>
		<div class="shipinvoice fright">
			<p class="paymenttit"><?php echo @constant('TEXT_SHIPPING_INVOECE_COMMENTS');?>
</p>
			<table class="paydetail_special">
				<?php if ($_smarty_tpl->tpl_vars['order']->value->info['shipping_restriction_total']>0&&($_smarty_tpl->tpl_vars['orders']->value['order_status']==2||$_smarty_tpl->tpl_vars['orders']->value['order_status']==3||$_smarty_tpl->tpl_vars['orders']->value['order_status']==4||$_smarty_tpl->tpl_vars['orders']->value['order_status']==10)){?>
				<tr><td colspan="2" style="color:red;"><?php echo @constant('TEXT_SHIPPING_RESTRICTION_IMPORTANT_NOTE');?>
</td></tr>
				<?php }?>

				<tr><td><strong><?php echo @constant('TEXT_SHIPPING_METHOD');?>
:</strong></td><td><?php if ($_smarty_tpl->tpl_vars['order']->value->info['shipping_method']!=''){?><?php echo $_smarty_tpl->tpl_vars['order']->value->info['shipping_method'];?>
<?php }else{ ?>/<?php }?></td></tr>
				<?php if ($_smarty_tpl->tpl_vars['message']->value['shipping_number_input']!=''){?><tr><td><strong><?php echo @constant('TEXT_TRACKING_NUMBER');?>
:</strong></td><td><?php echo $_smarty_tpl->tpl_vars['message']->value['shipping_number_input'];?>
</td></tr><?php }?>
				<?php if ($_smarty_tpl->tpl_vars['message']->value['shipping_days']!=''){?><tr><td><strong><?php echo @constant('TEXT_ESTSHIPPING_TIME');?>
:</strong></td><td><?php echo $_smarty_tpl->tpl_vars['message']->value['shipping_days'];?>
</td></tr><?php }?>
			</table>
			<p class="addr"><strong><?php echo @constant('TEXT_SHIPPING_ADDRESS');?>
:</strong><br/><span><?php echo $_smarty_tpl->tpl_vars['orders']->value['shipping_address'];?>
</span></p>
			<p class="addr"><strong><?php echo @constant('TEXT_ORDER_COMMONTS');?>
:</strong><br/><span><?php echo $_smarty_tpl->tpl_vars['orders']->value['order_comments'];?>
</span></p>
		</div>
		<div class="clearBoth"></div>
	</div>
	<div class="clearBoth"></div>
	<div class="doublebtn">
		<a href="index.php?main_page=shopping_cart&action=add_order_to_wishlist&orders_id=<?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
"><?php echo @constant('TEXT_CART_MOVE_WISHLIST');?>
</a>
		<a href="javascript:void(0);" class="quick_reorder" oid="<?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
"><?php echo @constant('TEXT_PAYMENT_QUICK_PEORDER');?>
</a>
		<?php if ($_smarty_tpl->tpl_vars['orders']->value['order_status']==2||$_smarty_tpl->tpl_vars['orders']->value['order_status']==3||$_smarty_tpl->tpl_vars['orders']->value['order_status']==4||$_smarty_tpl->tpl_vars['orders']->value['order_status']==10){?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['message']->value['http_download_img'];?>
downloads.php?order_id=<?php echo $_smarty_tpl->tpl_vars['orders']->value['order_id'];?>
"><?php echo @constant('TEXT_DOWNLOAD_ALL_PICTURES');?>
</a>
 		<?php }?>
	</div>
	<?php echo $_smarty_tpl->getSubTemplate ("includes/templates/checkout/tpl_quick_add_products.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	<div class="itemscont">
		<p class="itemstit"><?php echo @constant('TEXT_ITEMS_REVIEW');?>
</p>
		<p class="itemTotal"><a><?php echo @constant('HEADING_TOTAL');?>
: <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['total_products']->value;?>
</span> <?php if ($_smarty_tpl->tpl_vars['total_products']->value>1){?><?php echo @constant('HEADING_ITEMS');?>
<?php }else{ ?><?php echo @constant('HEADING_ITEM');?>
<?php }?></a>  <strong><?php echo @constant('HEADING_AMOUNT');?>
:  <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_subtotal'];?>
</span></strong></p>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="shopcart_content">
			<tr>
	            <th width="105"><?php echo @constant('HEADING_IMAGE');?>
</th>
	            <th width="60"><?php echo @constant('HEADING_MODEL');?>
</th>
	            <th width="100"><?php echo @constant('HEADING_WEIGHT');?>
</th>
	            <th width="230"><?php echo @constant('HEADING_PRODUCT_NAME');?>
</th>
	            <th width="95"><?php echo @constant('HEADING_PRICE');?>
</th>
	            <th width="80"><?php echo @constant('HEADING_QUANTITY');?>
</th>
	            <th width="100"><?php echo @constant('HEADING_SUBTOTAL');?>
</th>
	            <th width="100"><?php echo @constant('HEADING_ACTION');?>
</th>
			</tr> 
		</table>
	 	<table  width="100%" border="0" cellspacing="0" cellpadding="0" class="shopcart_content table_order_products_review">
		<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['orders_array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
			<tr<?php if ($_smarty_tpl->tpl_vars['k']->value>=3){?> class="hideTheTr"<?php }?>>
				<td width="105">					
					<?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
.<?php echo $_smarty_tpl->tpl_vars['val']->value['products_img'];?>

				</td>
	            <td width="60"><?php echo $_smarty_tpl->tpl_vars['val']->value['products_model'];?>
</td>
	            <td width="100" class="volweightwap"><?php echo $_smarty_tpl->tpl_vars['val']->value['products_weight'];?>
g</td>
	            <td width="230" style="text-align:left;" class="gift_name"><?php echo $_smarty_tpl->tpl_vars['val']->value['products_name'];?>

	            <?php if ($_smarty_tpl->tpl_vars['val']->value['is_preorder']==1){?>
	               <?php if ($_smarty_tpl->tpl_vars['val']->value['products_stocking_days']>7){?>
	                   <div class="clearfix"></div><div style=" margin:10px 0 0 0; color:#999"><?php echo @constant('TEXT_AVAILABLE_IN715');?>
</div>
	               <?php }else{ ?>
	                   <div class="clearfix"></div><div style=" margin:10px 0 0 0; color:#999"><?php echo @constant('TEXT_AVAILABLE_IN57');?>
</div>
	               <?php }?>
	            <?php }?>
	            </td>
	            <td width="95"><?php if ($_smarty_tpl->tpl_vars['val']->value['products_price_orignal']!=$_smarty_tpl->tpl_vars['val']->value['products_price']){?><del class="oprice_18862"><?php echo $_smarty_tpl->tpl_vars['val']->value['products_price_orignal'];?>
</del><?php }?><?php echo $_smarty_tpl->tpl_vars['val']->value['products_price'];?>
</td>
	            <td width="80"><?php echo $_smarty_tpl->tpl_vars['val']->value['products_qty'];?>
 <?php if ($_smarty_tpl->tpl_vars['val']->value['products_qty']>1){?><?php echo @constant('TEXT_PACKS');?>
<?php }else{ ?><?php echo @constant('TEXT_PACK');?>
<?php }?></td>
	            <td width="95"><span class="font_red"><?php echo $_smarty_tpl->tpl_vars['val']->value['products_price_total'];?>
</span></td>
	            <td width="100">
	              <?php if ($_smarty_tpl->tpl_vars['val']->value['products_id']!=$_smarty_tpl->tpl_vars['gift_id']->value){?>
				    <?php if (!$_smarty_tpl->tpl_vars['val']->value['is_gift']){?>
	            	<a href="javascript:void(0);" class="order_detail_addcart"><?php echo @constant('TEXT_CART_ADD_TO_CART');?>
</a>
	            	<input type="hidden" name="product_id" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['products_id'];?>
">
	            	<input type="hidden" name="product_qty" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['products_qty'];?>
">
	            	<div class="successtips_collect1">
		            	<span class="bot"></span>
		            	<span class="top"></span>
		            	<?php echo @constant('TEXT_ADD_TO_CART_SUCCESS');?>
<br/>
		            	<a href="index.php?main_page=shopping_cart" style="padding-right: 0px;"><?php echo @constant('TEXT_VIEW_CART');?>
</a> / <a href="javascript:void(0);" class="successtips_collect_close"><?php echo @constant('TEXT_CLOSE');?>
</a>
	            	</div>
					<?php }?>
	            	<?php if ($_smarty_tpl->tpl_vars['orders']->value['order_status']==2||$_smarty_tpl->tpl_vars['orders']->value['order_status']==3||$_smarty_tpl->tpl_vars['orders']->value['order_status']==4||$_smarty_tpl->tpl_vars['orders']->value['order_status']==10){?>
	            	<br/>
	            	<a href="<?php echo $_smarty_tpl->tpl_vars['message']->value['http_download_img'];?>
downloads.php?product_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['products_id'];?>
"><?php echo @constant('TEXT_DOWNLOAD_PIC');?>
</a>
	            	<?php }?>
	            	<?php if ($_smarty_tpl->tpl_vars['val']->value['note']!=''){?>	
	            	<br/>
	            	<div id="products_notes" style="position: absolute;width:70px;margin-left:20px;">		
						<a style="color:#008FED;" href="javascript:void(0);" class="rp_btn_ipn remark_order" aid="<?php echo $_smarty_tpl->tpl_vars['val']->value['products_id'];?>
" ><?php echo @constant('TEXT_PRODUCTS_REMARK');?>
</a>
						<div id="show_note_<?php echo $_smarty_tpl->tpl_vars['val']->value['products_id'];?>
" class="products_note_tips" style="border: 1px solid rgb(208, 209, 169); border-radius: 0px 0px 0px 0px; padding: 0px; text-align:left; position: relative; height: auto; width: 300px; left: -150px; top: 10px; background: none repeat scroll 0px 0px rgb(255, 255, 204); z-index: 1; display: none;">
							<span class="bot" style="position: absolute;top:-16px;left: 190px;border-color: rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) #D0D1A9;border-style: dashed dashed solid;border-width: 8px;"></span>
							<span class="top" style="position: absolute;top:-15px;left: 190px;border-color: rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) #FFFFCC;border-style: dashed dashed solid;border-width: 8px;"></span>
							<div id="products_note_tips_191489"><?php echo $_smarty_tpl->tpl_vars['val']->value['note'];?>
</div>
						</div>
					</div>
					<br/>
					<?php }?>
	              <?php }?>
	            </td>
			</tr>
		<?php } ?>
			<?php if (count($_smarty_tpl->tpl_vars['orders_array']->value)>3){?>
			<tr>
				<td colspan="8" class="more"><a href="javascript:void(0);" class="close1"></a></td>
			</tr>
			<?php }?>
	 		<?php if ($_smarty_tpl->tpl_vars['order_products_review_split_str']->value!='&nbsp;'){?>
			<tr>
				<td colspan="8">
		            <div class="propagelist">
		            	<?php echo $_smarty_tpl->tpl_vars['order_products_review_split_str']->value;?>

					</div>
	      		</td>
	      	</tr>
	      	<?php }?>
		</table>
		<p class="itemstit"><?php echo $_smarty_tpl->tpl_vars['message']->value['heading_order_history'];?>
</p>
		 <table  width="100%" border="0" cellspacing="0" cellpadding="0" class="shopcart_content">
          <tr>
            <th width="70"><?php echo $_smarty_tpl->tpl_vars['message']->value['heading_status_date'];?>
</th>
            <th width="45"><?php echo $_smarty_tpl->tpl_vars['message']->value['heading_status_order_status'];?>
</th>
            <th width="375"><?php echo $_smarty_tpl->tpl_vars['message']->value['heading_status_comments'];?>
</th>
          </tr>     
		  <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['statusArray']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			<td style="height: 0px;padding: 10px 5px;"><?php echo $_smarty_tpl->tpl_vars['statusArray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['date_added'];?>
</td>
            <td style="height: 0px;padding: 10px 5px;"><?php echo $_smarty_tpl->tpl_vars['statusArray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['orders_status_name'];?>
</td>
			<td style="text-align: left;height: 0px;padding: 10px 5px;"><?php echo $_smarty_tpl->tpl_vars['statusArray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['comments'];?>
</td>
          </tr> 
		  <?php endfor; endif; ?>
        </table>
	</div>
	<?php }?><?php }} ?>