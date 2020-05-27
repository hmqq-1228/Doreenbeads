<?php /* Smarty version Smarty-3.1.13, created on 2020-04-16 16:02:05
         compiled from "includes\templates\checkout\tpl_checkout_payment.html" */ ?>
<?php /*%%SmartyHeaderCode:133565e9810fd2c2489-29259464%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e997c210de149841ec0d36d07e43ae252e024b55' => 
    array (
      0 => 'includes\\templates\\checkout\\tpl_checkout_payment.html',
      1 => 1583978848,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '133565e9810fd2c2489-29259464',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'javascript_validation' => 0,
    'message' => 0,
    'order_totals_arr' => 0,
    'payment_selection' => 0,
    'payment' => 0,
    'default_payment' => 0,
    'order_total' => 0,
    'cash_account_remaining_total' => 0,
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
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e9810fd8db419_46847754',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e9810fd8db419_46847754')) {function content_5e9810fd8db419_46847754($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('includes/templates/checkout/tpl_checkout_head.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!-- payment templates start -->
<?php echo $_smarty_tpl->tpl_vars['javascript_validation']->value;?>


<div class="min_main">
	<div class="result_info">
		<ins class="icon_ok"></ins>
		<h2><?php echo @constant('TEXT_PAYMENT_YOUR_ORDER_SUCCESS');?>
</h2>
		<p><?php echo @constant('TEXT_PAYMENT_ORDER_NUMBER');?>
 <span><?php echo $_smarty_tpl->tpl_vars['message']->value['order_number_created'];?>
</span></p>
	</div>
	<div id="errorMessage" style="font-size:14px;line-height:20px;padding-bottom:10px;color:#C00;"></div>

	<?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']>0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']==0){?>
	<form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit_succ'];?>
" method="post" onsubmit="return check_form();">
	<?php }else{ ?>
	<form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit'];?>
" method="post" onsubmit="return check_form();">
	<?php }?>
		<div class="payment_cont">
			<div class="left">
				<ul>
				<?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']>0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']==0){?>
					<li class="chose" type="balance"><label><input style="position: relative;top: 10px;margin-left: 10px;" name="payment" type="radio" value="balance" checked="checked" /><?php echo @constant('TEXT_CREDIT_ACCOUNT_BALANCE');?>
</label></li>
				<?php }else{ ?>
					<?php  $_smarty_tpl->tpl_vars['payment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['payment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['payment_selection']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['payment']->key => $_smarty_tpl->tpl_vars['payment']->value){
$_smarty_tpl->tpl_vars['payment']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['message']->value['order_total_no_currency_left']<$_smarty_tpl->tpl_vars['message']->value['order_total_wire_min']&&($_smarty_tpl->tpl_vars['payment']->value['id']=='wire'||$_smarty_tpl->tpl_vars['payment']->value['id']=='wirebc'||$_smarty_tpl->tpl_vars['payment']->value['id']=='')){?>
						<?php }else{ ?>
							<?php if ($_smarty_tpl->tpl_vars['payment']->value['id']!='alipay'&&$_smarty_tpl->tpl_vars['payment']->value['id']!='moneygram'){?>
								<?php if ($_smarty_tpl->tpl_vars['payment']->value['id']!='paypalmanually'){?>
									<li type="<?php echo $_smarty_tpl->tpl_vars['payment']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['payment']->value['id']==$_smarty_tpl->tpl_vars['default_payment']->value){?>class="chose"<?php }?>><label><input style="position: relative;top: 10px;margin-left: 10px;" name="payment" type="radio" value="<?php echo $_smarty_tpl->tpl_vars['payment']->value['id'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['payment']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['payment']->value['id']==$_smarty_tpl->tpl_vars['default_payment']->value){?>checked="checked"<?php }?> />
									<?php if ($_smarty_tpl->tpl_vars['payment']->value['id']=='paypalwpp'){?><ins class="icon_pay_Paypal"></ins><strong><?php echo @constant('TEXT_PAYMENT_PAYPAL');?>
</strong>
									<?php }elseif($_smarty_tpl->tpl_vars['payment']->value['id']=='wire'){?><ins class="icon_pay_HSBC"></ins><strong><?php echo @constant('TEXT_PAYMENT_HSBC');?>
</strong>
									<?php }elseif($_smarty_tpl->tpl_vars['payment']->value['id']=='wirebc'){?><ins class="icon_pay_China"></ins><strong><?php echo @constant('TEXT_PAYMENT_BC');?>
</strong>
									<?php }elseif($_smarty_tpl->tpl_vars['payment']->value['id']=='westernunion'){?><ins class="icon_pay_Union"></ins><strong><?php echo @constant('TEXT_PAYMENT_WESTERN');?>
</strong>
									<?php }elseif($_smarty_tpl->tpl_vars['payment']->value['id']=='gcCreditCard'){?><ins class="icon_pay_Card"></ins><strong><?php echo @constant('MODULE_PAYMENT_GCCREDITCARD_TEXT_HEAD');?>
</strong>
									<?php }elseif($_smarty_tpl->tpl_vars['payment']->value['id']=='braintree'){?><ins class="icon_pay_braintree"></ins><?php echo @constant('MODULE_PAYMENT_BRAINTREE_TEXT_HEAD');?>
</strong>
									<?php }elseif($_smarty_tpl->tpl_vars['payment']->value['id']=='braintree-google'){?><ins class="icon_pay_braintree_google"></ins><strong>Google Pay</strong>
									<?php }elseif($_smarty_tpl->tpl_vars['payment']->value['id']=='braintree-apple'){?><ins class="icon_pay_braintree_apple"></ins><strong>Apple Pay</strong>
									<?php }?>
						</label></li>
								<?php }?>
							<?php }?>
						<?php }?>	
					<?php } ?>
					
					<li type="moneygram" <?php if ('moneygram'==$_smarty_tpl->tpl_vars['default_payment']->value){?>class="chose"<?php }?>><label><input style="position: relative;top: 10px;margin-left: 10px;" name="payment" type="radio" value="moneygram" <?php if ('moneygram'==$_smarty_tpl->tpl_vars['default_payment']->value){?>checked="checked"<?php }?> /><ins class="icon_money_gram"></ins><?php echo @constant('TEXT_PAYMENT_MONEY_GRAM');?>
</label></li>
				<?php }?>
				</ul>
			</div>

			<div class="right">
			    <div id="paypal_payment_box" <?php if ($_smarty_tpl->tpl_vars['message']->value['checkout_payment_size']<=0){?> style="display:none;"<?php }?>>
	        		<ins class="icon_error"></ins>
	        		<p id="paypal_payment_message"><?php echo $_smarty_tpl->tpl_vars['message']->value['checkout_payment'];?>
</p>
	        	</div>

			<?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']>0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']==0){?>
				<div class="right_cont_chinabank right_cont_balance sh">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['order_total']->value;?>
</span></h4>
					<div class="balance_info">
						<dl>
							<dt><?php echo @constant('TEXT_YOUR_CREDIT_ACCOUNT_BALANCE');?>
: <?php echo $_smarty_tpl->tpl_vars['cash_account_remaining_total']->value;?>
</dt>
							<dd><?php echo @constant('TEXT_PAY');?>
 <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['order_total']->value;?>
</span> <?php echo @constant('TEXT_FOR_THIS_ORDER');?>
</dd>
						</dl>
						<div class="clear"></div>						
					</div>
					<a href="javascript:void(0);" class="paynow_btn"><?php echo @constant('TEXT_PAID');?>
</a>
				</div>
			<?php }else{ ?>
				<!--	paypal	-->
				<div class="right_cont_chinabank right_cont_paypalwpp <?php if ('paypalwpp'==$_smarty_tpl->tpl_vars['default_payment']->value){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']!=0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']>0){?>
					<div class="balance_info">
						<dl>
							<dt><?php echo @constant('TEXT_YOUR_CREDIT_ACCOUNT_BALANCE');?>
: <?php echo $_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['text'];?>
</dt>
							<dd><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order_show'];?>
</dd>
							<dt><?php echo @constant('TEXT_PAYPAL');?>
</dt><dd><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order_left'];?>
</dd>
						</dl>
						<div class="clear"></div>
					</div>
					<?php }?>
					<div class="txt_paypal">
						<p>
							<img src="<?php echo @constant('HTTP_SERVER');?>
/includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>
/btn_xpressCheckout_243x40.png" />
							<!-- 添加安全图标@yifei.wang 2018.05.18 14:55 -->
							<img src="https://www.paypalobjects.com/digitalassets/c/website/marketing/na/us/logo-center/9_bdg_secured_by_pp_2line.png" border="0" alt="Secured by PayPal">
						</p>
						<p>
							<ins class="arrow"></ins>
							<span><?php echo @constant('TEXT_PAYMENT_PAY_US_CLICK');?>
</span>
						</p>
						<p>
							<a class="paynow_btn jq_paypalwpp" data-url="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pal_submit_url'];?>
" id="paypalwpp" onclick="javascript:openPaypalWindow();" href="javascript:void(0);"><?php echo @constant('TEXT_PAYMENT_PAY_NOW');?>
</a>
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
				<div class="right_cont_chinabank right_cont_braintree <?php if ('braintree'==$_smarty_tpl->tpl_vars['default_payment']->value||'braintree-credit'==$_smarty_tpl->tpl_vars['default_payment']->value){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<iframe id="braintree_iframe" scrolling="auto" width="555" frameborder=0 src="<?php echo @constant('HTTP_SERVER');?>
/index.php?main_page=checkout_braintree&order_id=<?php echo $_smarty_tpl->tpl_vars['message']->value['order_number_created'];?>
&go=<?php echo @constant('FILENAME_CHECKOUT_SUCCESS');?>
&action=credit" style="height:300px;"></iframe>
				</div>

				<div class="right_cont_chinabank right_cont_braintree-google <?php if ('braintree-google'==$_smarty_tpl->tpl_vars['default_payment']->value){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<iframe id="braintree_iframe" scrolling="auto" width="555" frameborder=0 src="<?php echo @constant('HTTP_SERVER');?>
/index.php?main_page=checkout_braintree&order_id=<?php echo $_smarty_tpl->tpl_vars['message']->value['order_number_created'];?>
&go=<?php echo @constant('FILENAME_CHECKOUT_SUCCESS');?>
&action=google" style="height:300px;"></iframe>
				</div>

				<div class="right_cont_chinabank right_cont_braintree-apple <?php if ('braintree-apple'==$_smarty_tpl->tpl_vars['default_payment']->value){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<iframe id="braintree_iframe" scrolling="auto" width="555" frameborder=0 src="<?php echo @constant('HTTP_SERVER');?>
/index.php?main_page=checkout_braintree&order_id=<?php echo $_smarty_tpl->tpl_vars['message']->value['order_number_created'];?>
&go=<?php echo @constant('FILENAME_CHECKOUT_SUCCESS');?>
&action=apple" style="height:300px;"></iframe>
				</div>

				<?php if ($_smarty_tpl->tpl_vars['message']->value['order_total_no_currency_left']>=$_smarty_tpl->tpl_vars['message']->value['order_total_wire_min']){?>		
				<!--	HSBC	-->
				<div class="right_cont_chinabank right_cont_wire <?php if ('wire'==$_smarty_tpl->tpl_vars['default_payment']->value){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']!=0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']>0){?>
					<div class="balance_info">
						<dl>
							<dt><?php echo @constant('TEXT_YOUR_CREDIT_ACCOUNT_BALANCE');?>
: <?php echo $_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['text'];?>
</dt><dd><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order_show'];?>
</dd>
							<dt><?php echo @constant('TEXT_PAYMENT_HSBC');?>
</dt><dd><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order_left'];?>
</dd>
						</dl>
						<div class="clear"></div>						
					</div>
					<?php }?>
					<div class="txt_chinabank">						
						<h5><span><?php echo @constant('TEXT_BANK_ACCOUNT_HSBC');?>
</span><a href="payment_files/<?php echo $_SESSION['languages_code'];?>
/Bank_Transfer(Citibank).txt" target="_blank" class="print" title="<?php echo @constant('TEXT_PAYMENT_PRINT');?>
"></a><a href="payment_files/<?php echo $_SESSION['languages_code'];?>
/Bank_Transfer(Citibank).doc" target="_blank" class="download" title="<?php echo @constant('TEXT_PAYMENT_DOWNLOAD');?>
"></a></h5>
						<?php echo $_smarty_tpl->tpl_vars['message']->value['wire']['title'];?>

						<div class="borderbt"></div>
					</div>
					<a class="paynow_btn" href="javascript:void(0);"><?php echo @constant('TEXT_SUBMIT');?>
</a>
				</div>
				
				<!--	Bank of China	-->
				<div class="right_cont_chinabank right_cont_wirebc <?php if ('wirebc'==$_smarty_tpl->tpl_vars['default_payment']->value){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']!=0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']>0){?>
					<div class="balance_info">
						<dl>
							<dt><?php echo @constant('TEXT_YOUR_CREDIT_ACCOUNT_BALANCE');?>
: <?php echo $_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['text'];?>
</dt><dd><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order_show'];?>
</dd>
							<dt><?php echo @constant('TEXT_BANK_ACCOUNT_BC');?>
</dt><dd><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order_left'];?>
</dd>
						</dl>
						<div class="clear"></div>						
					</div>
					<?php }?>
					<div class="txt_chinabank">						
						<h5><span><?php echo @constant('TEXT_BANK_ACCOUNT_BC');?>
</span><a href="payment_files/<?php echo $_SESSION['languages_code'];?>
/Bank_Transfer(Bank_of_China).txt" class="print" target="_blank" title="<?php echo @constant('TEXT_PAYMENT_PRINT');?>
"></a><a href="payment_files/<?php echo $_SESSION['languages_code'];?>
/Bank_Transfer(Bank_of_China).doc"  target="_blank" class="download" title="<?php echo @constant('TEXT_PAYMENT_DOWNLOAD');?>
"></a></h5>
						<?php echo $_smarty_tpl->tpl_vars['message']->value['wirebc']['title'];?>

						<div class="borderbt"></div>
					 </div>
					<a class="paynow_btn" href="javascript:void(0);"><?php echo @constant('TEXT_SUBMIT');?>
</a>
				</div>
				<?php }?>
				<!--	Westerm Union	-->
				<div class="right_cont_chinabank right_cont_westernunion <?php if ('westernunion'==$_smarty_tpl->tpl_vars['default_payment']->value){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']!=0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']>0){?>
					<div class="balance_info">
						<dl>
							<dt><?php echo @constant('TEXT_YOUR_CREDIT_ACCOUNT_BALANCE');?>
: <?php echo $_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['text'];?>
</dt><dd><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order_show'];?>
</dd>
							<dt><?php echo @constant('TEXT_WESTERN_UNION');?>
</dt><dd><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order_left'];?>
</dd>
						</dl>
						<div class="clear"></div>						
					</div>
					<?php }?>
					<div class="txt_chinabank">						
						<h5><span><?php echo @constant('TEXT_OUR_WESTERN_UNION_RECEIVER_INFO');?>
</span><a href="<?php echo @constant('HTTP_SERVER');?>
/payment_files/<?php echo $_SESSION['languages_code'];?>
/Western_Union.txt" target="_blank" class="print" title="<?php echo @constant('TEXT_PAYMENT_PRINT');?>
"></a><a href="<?php echo @constant('HTTP_SERVER');?>
/payment_files/<?php echo $_SESSION['languages_code'];?>
/Western_Union.doc" target="_blank" class="download" title="<?php echo @constant('TEXT_PAYMENT_DOWNLOAD');?>
"></a></h5>
						<?php echo $_smarty_tpl->tpl_vars['message']->value['westernunion']['title'];?>

						<div class="borderbt"></div>
					</div>
					<a class="paynow_btn" href="javascript:void(0);"><?php echo @constant('TEXT_SUBMIT');?>
</a>
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

				<!-- Monry Gram	-->
				<div class="right_cont_chinabank right_cont_moneygram <?php if ('moneygram'==$_smarty_tpl->tpl_vars['default_payment']->value){?>sh<?php }?>">
					<h4><strong><?php echo @constant('HEADING_TOTAL');?>
:</strong> <span class="font_red"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h4>
					<?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']!=0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']>0){?>
					<div class="balance_info">
						<dl>
							<dt><?php echo @constant('TEXT_YOUR_CREDIT_ACCOUNT_BALANCE');?>
: <?php echo $_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['text'];?>
</dt><dd><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order_show'];?>
</dd>
							<dt><?php echo @constant('TEXT_PAYMENT_MONEY_GRAM');?>
</dt><dd><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order_left'];?>
</dd>
						</dl>
						<div class="clear"></div>						
					</div>
					<?php }?>
					<div class="txt_chinabank">						
						<h5><span><?php echo @constant('TEXT_MONEY_GRAM_INFO');?>
</span><a href="payment_files/<?php echo $_SESSION['languages_code'];?>
/Money_Gram.txt" target="_blank" class="print" title="<?php echo @constant('TEXT_PAYMENT_PRINT');?>
"></a><a href="payment_files/<?php echo $_SESSION['languages_code'];?>
/Money_Gram.doc" target="_blank" class="download" title="<?php echo @constant('TEXT_PAYMENT_DOWNLOAD');?>
"></a></h5>
						<?php echo $_smarty_tpl->tpl_vars['message']->value['moneygram']['title'];?>
				 
						<div class="borderbt"></div>
					</div>
					<a class="paynow_btn" href="javascript:void(0);"><?php echo @constant('TEXT_SUBMIT');?>
</a>
				</div>
			<?php }?>
		
		  	</div>
			<div class="clear"></div>
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
</div>
<script>
<!--
$j(document).ready(function(){
	$j('.payment_cont .left li').click(function(){
		if($j(this).hasClass('chose')) return;

		$j('.payment_cont .left li.chose').removeClass('chose');
		$j(this).addClass('chose');
		$j('.right_cont_chinabank.sh').removeClass('sh');
		$j('.right_cont_chinabank.right_cont_'+$j(this).attr('type')).addClass('sh');
		$j('.paynotes.sh').removeClass('sh');
		$j('.paynotes.paynotes_'+$j(this).attr('type')).addClass("sh");
	})

	$j(".right a.paynow_btn").click(function(){
		if($j(this).attr('id') == 'paypalwpp'){
//			location.href = "<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pal_submit_url'];?>
";
		}else
			document.checkout_payment.submit();
	})
})
$j(function(){
    var host = $j("#http_server").val();
    $j("#paymentInfo").hide();
        var orderId = $j("#orderId").val();
        var paymentOrderId = $j("#paymentOrderId").val();
        var lastName = $j("#lastName").val();
        var firstName = $j("#firstName").val();
        var shippingFirstName = $j("#shippingFirstName").val();
        var shippingLastName = $j("#shippingLastName").val();
        var shippingStreet = $j("#shippingStreet").val();
        var shippinCountryCode = $j("#shippinCountryCode").val();
        var shippinZip = $j("#shippinZip").val();
        var merchantRef = $j("#merchantRef").val();
        var countryCode = $j("#countryCode").val();
        var lanuageCode = $j("#lanuageCode").val();
        var currencyCode = $j("#currencyCode").val();
        var price = $j("#price").val();
        var shippingCity = $j("#shippingCity").val();
        var shippingState = $j("#shippingState").val();
        var phoneNumber = $j("#phoneNumber").val();
        var email = $j("#email").val();
        var city = $j("#city").val();
        var state = $j("#state").val();
        var street = $j("#street").val();
        var type = $j("#type").val();
        $j("#loading").show();
        $j("#payIframe").hide();
        
        $j("#gcCreditCard").change(function(){
        $j("#loading").show();
        $j("#payIframe").hide();
        $j.ajax({
            type:"POST",
            url:"/payment1.php",
            data:"payCode=1&orderId="+orderId+"&paymentOrderId="+paymentOrderId+"&lastName="+lastName+"&firstName="+firstName+"&shippingFirstName="+shippingFirstName
                    +"&shippingLastName="+shippingLastName+"&shippingStreet="+shippingStreet+"&shippinCountryCode="+shippinCountryCode+"&shippinZip="+shippinZip+"&merchantRef="+
                                    merchantRef+"&price="+price+"&countryCode="+countryCode+"&lanuageCode="+lanuageCode+"&currencyCode="+currencyCode+"&shippingCity="+shippingCity
                                    +"&shippingState="+shippingState+"&phoneNumber="+phoneNumber+"&email="+email+"&city="+city+"&state="+state+"&street="+street+"&type="+type,
            success:function(msg){
                var response = eval('('+msg+')');
                if(response.status == 1){
                    $j("#gcFormActionUrl").ready(function(){
                        $j("#loading").hide();
                        $j("#payIframe").show();
                        $j("#gcFormActionUrl").attr("src",response.response);
                    }
                );
                } else if(response.status == 0 && response.response == '410120'){
                    $j("#loading").hide();
                    $j("#payIframe").show();
                        $j("#errorMessage").html(response.message);

                }
            }
        });
});
        $j(".gcPayment").change(function(){
            $j("#loading").show();
            $j("#payIframe").hide();
            var payCode = $j(this).val();
            $j.ajax({
                type:'POST',
                url:"/payment1.php",
                data:"payCode="+payCode+"&orderId="+orderId+"&paymentOrderId="+paymentOrderId+"&lastName="+lastName+"&firstName="+firstName+"&shippingFirstName="+shippingFirstName
                        +"&shippingLastName="+shippingLastName+"&shippingStreet="+shippingStreet+"&shippinCountryCode="+shippinCountryCode+"&shippinZip="+shippinZip+"&merchantRef="+
                        merchantRef+"&price="+price+"&countryCode="+countryCode+"&lanuageCode="+lanuageCode+"&currencyCode="+currencyCode+"&shippingCity="+
                        shippingCity+"&shippingState="+shippingState+"&phoneNumber="+phoneNumber+"&email="+email+"&city="+city+"&state="+state+"&street="+street+"&type="+type,
                success:function(msg){
                    var response = eval('('+msg+')');
                    if(response.status == 1) {
                        $j("#gcFormActionUrl").ready(function(){
                        $j("#loading").hide();
                        $j("#payIframe").show();
                        $j("#gcFormActionUrl").attr("src",response.response);
//                    alert(eval('(' + msg + ')'));
//                    alert(JSON.parse(msg));
                        });
                    } else if(response.status == 0 && response.response == '410120') {
                        $j("#loading").hide();
                        $j("#payIframe").show();
                        $j("#errorMessage").html(response.message);
                    }
                }
            });
        });
		$j("#webMoney_button").click(function(){
	        $j("#loadingWM").show();
	        //$j("#payIframeWM").hide();
	        $j.ajax({
	            type:"POST",
	            url:"<<?php ?>?php echo HTTP_SERVER;?<?php ?>>/paymentWM.php",
	            data:"payCode=841&orderId="+orderId+"&paymentOrderId="+paymentOrderId+"&lastName="+lastName+"&firstName="+firstName+"&shippingFirstName="+shippingFirstName
	                    +"&shippingLastName="+shippingLastName+"&shippingStreet="+shippingStreet+"&shippinCountryCode="+shippinCountryCode+"&shippinZip="+shippinZip+"&merchantRef="+
	                                    merchantRef+"&price="+price+"&countryCode="+countryCode+"&lanuageCode="+lanuageCode+"&currencyCode="+currencyCode+"&shippingCity="+shippingCity
	                                    +"&shippingState="+shippingState+"&phoneNumber="+phoneNumber+"&email="+email+"&city="+city+"&state="+state+"&street="+street+"&type="+type,
	            success:function(msg){
	                var response = eval('('+msg+')');
	                if(response.status == 1){
		                window.location.href = response.response;
		                return false;
	                    $j("#gcFormActionUrlWM").ready(function(){
	                    $j("#loadingWM").hide();
	                    $j("#payIframeWM").show();
	                    $j("#gcFormActionUrlWM").attr("src",response.response);
	                });
	                } else if(response.status == 0){
		                if (response.response == '410120'){
		                    $j("#loadingWM").hide();
		                    $j("#payIframeWM").show();
	                        $j("#errorMessage").html(response.message);
		                }else{
		                    $j("#loadingWM").hide();
		                    $j("#payIframeWM").show();
	                        $j("#errorMessage").html(response.messageOriginal);
		                }
	                }
	            }
	        });
    	});
        $j("#use_coupon").click(function(){
            $j("#loading").show();
            $j("#payIframe").hide();
    		if($j(".gcPayment").checked = "checked"){
    			var payCode = $j(".gcPayment").val();
    		}
            $j.ajax({
                type:'POST',
                url:'/payment1.php',
                data:"payCode="+payCode+"&orderId="+orderId+"&paymentOrderId="+paymentOrderId+"&lastName="+lastName+"&firstName="+firstName+"&shippingFirstName="+shippingFirstName
                        +"&shippingLastName="+shippingLastName+"&shippingStreet="+shippingStreet+"&shippinCountryCode="+shippinCountryCode+"&shippinZip="+shippinZip+"&merchantRef="+
                        merchantRef+"&price="+price+"&countryCode="+countryCode+"&lanuageCode="+lanuageCode+"&currencyCode="+currencyCode+"&shippingCity="+
                        shippingCity+"&shippingState="+shippingState+"&phoneNumber="+phoneNumber+"&email="+email+"&city="+city+"&state="+state+"&street="+street+"&type="+type,
                success:function(msg){
                    var response = eval('('+msg+')');
                    if(response.status == 1) {
                        $j("#gcFormActionUrl").ready(function(){
                        $j("#loading").hide();
                        $j("#payIframe").show();
                        $j("#gcFormActionUrl").attr("src",response.response);
//                    alert(eval('(' + msg + ')'));
//                    alert(JSON.parse(msg));
                    });
                    } else if(response.status == 0 && response.response == '410120') {
                        $j("#loading").hide();
                        $j("#payIframe").show();
                        $j("#errorMessage").html(response.message);
                    }
                }
            });
        });
		$j(".redclose").click(function(){
			   $j(this).next(".successtips2").hide(); 
			   })
			   
		$j(".icon_question").mouseover(function(){
			$j(this).next(".successtips2").show();
			})
	    $j(".icon_question").mouseout (function(){
			$j(this).next(".successtips2").hide();
			})

	    $j(".remark_order").mouseover(function(){
			products_id = $j(this).attr('aid');
			$j("#show_note_"+products_id).show();
		})
	    $j(".remark_order").mouseout(function(){
			products_id = $j(this).attr('aid');
			$j("#show_note_"+products_id).hide();
		})
})
-->

</script>
<!-- payment templates end --><?php }} ?>