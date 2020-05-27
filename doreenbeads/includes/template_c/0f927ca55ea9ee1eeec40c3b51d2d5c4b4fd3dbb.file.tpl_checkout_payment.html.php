<?php /* Smarty version Smarty-3.1.13, created on 2020-04-17 09:07:18
         compiled from "includes\templates\mobilesite\tpl\tpl_checkout_payment.html" */ ?>
<?php /*%%SmartyHeaderCode:233255e9901469eac30-66802171%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f927ca55ea9ee1eeec40c3b51d2d5c4b4fd3dbb' => 
    array (
      0 => 'includes\\templates\\mobilesite\\tpl\\tpl_checkout_payment.html',
      1 => 1575421066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '233255e9901469eac30-66802171',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'message' => 0,
    'order_total' => 0,
    'order_totals_arr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e990147400e29_55876387',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e990147400e29_55876387')) {function content_5e990147400e29_55876387($_smarty_tpl) {?><div class="order_main">
    <div class="payment_top">
        <p><?php echo $_smarty_tpl->tpl_vars['message']->value['order_succ'];?>
</p>
        <p><?php echo $_smarty_tpl->tpl_vars['message']->value['order_number'];?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_details'];?>
" class="link_text"><?php echo $_smarty_tpl->tpl_vars['message']->value['order_number_created'];?>
</a></p>
        <div class="balance">
            <p> <?php echo $_smarty_tpl->tpl_vars['message']->value['payment_total_amount'];?>
: <b class="price_color"><?php echo $_smarty_tpl->tpl_vars['order_total']->value;?>
</b></p>
            <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_show_balance_html_or_not']){?>
                <p>Total credit account balance:<span class="price_color"> <?php echo $_smarty_tpl->tpl_vars['message']->value['payment_total_balance_old'];?>
</span>.</p>
                <p>Use <span class="price_color"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order_show'];?>
</span> for this order.</p>
                <p><b>Need to Pay:<span class="price_color"> <?php echo $_smarty_tpl->tpl_vars['message']->value['payment_need_to_pay'];?>
</span></b></p>
            <?php }?>
        </div>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['message']->value['checkout_payment_size']>0){?>
    <div class="comllete_error"><ins></ins>
      <p><?php echo $_smarty_tpl->tpl_vars['message']->value['checkout_payment'];?>
</p>
    </div>
    <?php }?>
    <div id="errorMessage" style="font-size:14px;line-height:20px;padding-bottom:10px;color:#C00;"></div>
    <div class="payment_wrap">
        <p class="payment_title"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_methods'];?>
:</p>
        <ul class="jq_show_payment_li">
            <!-- paypal -->
            <li>
                <form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit'];?>
" method="post">
                    <input type="hidden" name="paypal_url" value="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pal_submit_url'];?>
"/>
                    <input name="payment" type="hidden" id="paypalwpp" value="paypalwpp"/>
                    <h4 class="payment_meta"><ins class="paypal" ></ins><span><?php echo @constant('TEXT_PAYPAL');?>
</span></h4>
                    <div class="payment_show" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='paypalwpp'){?>style="display: block;"<?php }?>>
                        <p class="grey_6">-<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_paypal_clicking'];?>
</p>
                        <p class="grey_6">-<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_paypal_directly'];?>
</p>
                        <button class="btn_blue btn_with230" type="submit"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_now'];?>
</button>
                    </div>
                </form>
            </li>
            <!-- braintree -->
            <li>
                <form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit'];?>
" method="post">
                    <input name="payment" type="hidden" id="braintree" value="braintree"/>
                    <h4 class="payment_meta"><ins class="braintree"></ins><span><?php echo @constant('TEXT_BRAINTREE');?>
</span></h4>
                    <div class="payment_show" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='braintree'||$_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='braintree-credit'){?>style="display: block;"<?php }?>>
                        <iframe id="braintree_iframe" scrolling="auto" width="100%" frameborder=0 src="<?php echo @constant('HTTP_SERVER');?>
/index.php?main_page=checkout_braintree&order_id=<?php echo $_smarty_tpl->tpl_vars['message']->value['order_number_created'];?>
&go=<?php echo @constant('FILENAME_CHECKOUT_SUCCESS');?>
&action=credit" style="height:266px;"></iframe>
                    </div>
                </form>
            </li>

            <li>
                <form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit'];?>
" method="post">
                    <input name="payment" type="hidden" id="braintree-google" value="braintree-google"/>
                    <h4 class="payment_meta"><ins class="braintree-google"></ins><span><strong>Google Pay</strong></span></h4>
                    <div class="payment_show" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='braintree-google'){?>style="display: block;"<?php }?>>
                    <iframe id="braintree_iframe" scrolling="auto" width="100%" frameborder=0 src="<?php echo @constant('HTTP_SERVER');?>
/index.php?main_page=checkout_braintree&order_id=<?php echo $_smarty_tpl->tpl_vars['message']->value['order_number_created'];?>
&go=<?php echo @constant('FILENAME_CHECKOUT_SUCCESS');?>
&action=google" style="height:266px;"></iframe>
                    </div>
                </form>
            </li>

            <li>
                <form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit'];?>
" method="post">
                    <input name="payment" type="hidden" id="braintree-apple" value="braintree-apple"/>
                    <h4 class="payment_meta"><ins class="braintree-apple"></ins><span><strong>Apple Pay</strong></span></h4>
                    <div class="payment_show" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='braintree-apple'){?>style="display: block;"<?php }?>>
                    <iframe id="braintree_iframe" scrolling="auto" width="100%" frameborder=0 src="<?php echo @constant('HTTP_SERVER');?>
/index.php?main_page=checkout_braintree&order_id=<?php echo $_smarty_tpl->tpl_vars['message']->value['order_number_created'];?>
&go=<?php echo @constant('FILENAME_CHECKOUT_SUCCESS');?>
&action=apple" style="height:266px;"></iframe>
                    </div>
                </form>
            </li>
            <!-- HSBC -->
            <?php if ($_smarty_tpl->tpl_vars['message']->value['order_total_no_currency_left']>=$_smarty_tpl->tpl_vars['message']->value['order_total_wire_min']){?>
            <li>
                <form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit'];?>
" method="post">
                    <input name="payment" type="hidden" id="wire" value="wire"/>
                    <h4 class="payment_meta"><ins class="hsbc"></ins><span><?php echo @constant('TEXT_BANK_ACCOUNT_HSBC');?>
</span></h4>
                    <div class="payment_show" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='wire'){?>style="display: block;"<?php }?>> 
                        <table>
                            <tr><td colspan="2"> <p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_bank_hsbc'];?>
:</strong></p></td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY_BANK');?>
 </th><td><?php echo @constant('MODULE_PAYMENT_WIRE_BENEFICIARY_BANK');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WIRE_TEXT_SWIFT_CODE');?>
 </th><td><?php echo @constant('MODULE_PAYMENT_WIRE_SWIFT_CODE');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WIRE_TEXT_BANK_ADDRESS');?>
</th><td ><?php echo @constant('MODULE_PAYMENT_WIRE_BANK_ADDRESS');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WIRE_TEXT_ACCOUNT_NO');?>
</th><td><?php echo @constant('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY');?>
</th><td ><?php echo @constant('MODULE_PAYMENT_WIRE_BENEFICIARY');?>
</td></tr>
                        </table>
                        <button class="btn_blue btn_with230" type="submit"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_button_submit'];?>
</button>
                        <div class="note">
                            <b><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_note'];?>
:</b>
                            <?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_hsbs_china'];?>

                        </div>
                    </div>
                </form>
            </li>
            <!-- Bank of China -->
            <li>
                <form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit'];?>
" method="post">
                    <input name="payment" type="hidden" id="wirebc" value="wirebc"/>
                    <h4 class="payment_meta"><ins class="china_bank"></ins><span><?php echo @constant('TEXT_BANK_ACCOUNT_BC');?>
</span></h4>
                    <div class="payment_show" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='wirebc'){?>style="display: block;"<?php }?>> 
                        <table>
                            <tr><td colspan="2"><p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_bank_china'];?>
:</strong></p></td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_BENEFICIARY_BANK');?>
 </th><td><?php echo @constant('MODULE_PAYMENT_WIREBC_BENEFICIARY_BANK');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_1');?>
 </th><td><?php echo @constant('MODULE_PAYMENT_WIREBC_SWIFT_CODE');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_NAME');?>
</th><td ><?php echo @constant('MODULE_PAYMENT_WIREBC_HOLDER_NAME');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_ACCOUNT_NUMBER');?>
</th><td><?php echo @constant('MODULE_PAYMENT_WIREBC_ACCOUNT_NUMBER');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_BANK_ADDRESS');?>
</th><td ><?php echo @constant('MODULE_PAYMENT_WIREBC_BANK_ADDRESS');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_PHONE');?>
 </th><td ><?php echo @constant('MODULE_PAYMENT_WIREBC_HOLDER_PHONE');?>
</td></tr>
                        </table>
                        <button class="btn_blue btn_with230" type="submit"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_button_submit'];?>
</button>
                        <div class="note">
                            <b><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_note'];?>
:</b>
                            <?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_hsbs_china'];?>

                        </div>
                    </div>
                </form>
            </li>
            <?php }?>
            <!-- westernunion -->
            <li>
                <form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit'];?>
" method="post">
                    <input name="payment" type="hidden" id="westernunion" value="westernunion"/>
                    <h4 class="payment_meta"><ins class="western"></ins><span><?php echo @constant('TEXT_WESTERN_UNION');?>
</span></h4>
                    <div class="payment_show" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='westernunion'){?>style="display: block;"<?php }?>> 
                        <table>
                            <tr><td colspan="2"><p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_bank_western_union'];?>
:</strong></p></td></tr>
                            <tr><td><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME');?>
 </th><td><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME');?>
 </th><td><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS');?>
</th><td ><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP');?>
</th><td><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY');?>
</th><td ><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY');?>
</th><td ><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE');?>
</th><td ><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE');?>
</td></tr>
                        </table>
                        <button class="btn_blue btn_with230" type="submit"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_button_submit'];?>
</button>
                        <div class="note">
                            <b><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_note'];?>
:</b>
                            <?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_wumt'];?>

                        </div>
                    </div>
                </form>
            </li>
            <!-- moneygram -->
            <li>
                <form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit'];?>
" method="post">
                    <input name="payment" type="hidden" id="moneygram" value="moneygram"/>
                    <h4 class="payment_meta"><ins class="money_gram"></ins><span><?php echo @constant('TEXT_MONEY_GRAM_INFO');?>
</span></h4>
                    <div class="payment_show" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='moneygram'){?>style="display: block;"<?php }?>> 
                        <table>
                            <tr><td colspan="2"> <p><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_TEXT_HEAD');?>
:</p></td></tr>
                            <tr><td><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_FIRST_NAME');?>
 </th><td width="58%"><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_FIRST_NAME');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_LAST_NAME');?>
 </th><td><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_LAST_NAME');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_ADDRESS');?>
</th><td ><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_ADDRESS');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_ZIP');?>
</th><td><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_ZIP');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_CITY');?>
</th><td ><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_CITY');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_COUNTRY');?>
 </th><td ><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_COUNTRY');?>
</td></tr>
                            <tr><th><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_PHONE');?>
 </th><td ><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_PHONE');?>
</td></tr>
                        </table>
                        <button class="btn_blue btn_with230" type="submit"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_button_submit'];?>
</button>
                        <div class="note">
                            <b><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_note'];?>
:</b>
                            <p>1.&nbsp;<?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_money_gram'];?>
</p>
                                <?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_money_gram_2'];?>

                        </div>
                    </div>
                </form>
            </li>
        </ul>
    </div>
</div>

<!-- <div class="maincontent">
    <div class="completecont">
      <h3 class="payment-tit"><?php echo $_smarty_tpl->tpl_vars['message']->value['order_succ'];?>
<br/><p><br/><?php echo $_smarty_tpl->tpl_vars['message']->value['order_number'];?>
 <ins><a href="<?php echo $_smarty_tpl->tpl_vars['message']->value['success_order_details'];?>
"><?php echo $_smarty_tpl->tpl_vars['message']->value['order_number_created'];?>
</a></ins> </p></h3>
      <p class="kindlytips"><?php echo @constant('TEXT_PAYMENT_CHECK_ADDRESS');?>
</p>    
      <p id="errorMessage" style="color:red;"></p>
   <h3 class="h3tit"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_methods'];?>
</h3>
<div class="Payment-methods">
<?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']>0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']==0){?>
 <h3><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_total_amount'];?>
 <span><?php echo $_smarty_tpl->tpl_vars['order_total']->value;?>
</span></h3>
  <?php }else{ ?>
    <h3><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_total_amount'];?>
 <span><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_order_total'];?>
</span></h3>
 <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']>0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']==0){?>
    <form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit_succ'];?>
" method="post">
    <?php }else{ ?>
    <form name="checkout_payment" action="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_submit'];?>
" method="post">
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']>0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']==0){?>
 <p class="creditcont">
     <?php echo $_smarty_tpl->tpl_vars['message']->value['payment_credit_account_blance'];?>
:<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_total_balance_old'];?>

     <br/><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order'];?>

     <br/><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_balance_left'];?>

 </p>
 <?php }else{ ?>
        <?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']!=0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']>0){?>
        <p class="creditcont"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_credit_account_blance'];?>
: <?php echo $_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['text'];?>
 <br/><label><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_for_this_order'];?>
</label>
        <br><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_need_to_pay'];?>
</p>
        <?php }?>
 <?php }?>
 <?php if ($_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_cash_account']['value']>0&&$_smarty_tpl->tpl_vars['order_totals_arr']->value['ot_total']['value']==0){?>
  <ul class="methodlist">
    <li><label><input name="payment" type="radio" value="balance" checked="checked" /> <?php echo @constant('TEXT_CREDIT_ACCOUNT_BALANCE');?>
</label>
    <button class="pay-button"><?php echo $_smarty_tpl->tpl_vars['message']->value['paid'];?>
</button></li>
    </ul> 
 <?php }else{ ?>
 <input type="hidden" name="paypal_url" value="<?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pal_submit_url'];?>
"/> 
  <ul class="methodlist">
     <li><label for="paypalwpp"><input name="payment" type="radio" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']==''||$_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='Balance'||$_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='paypalwpp'||$_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='Credit Balane'){?>checked="checked"<?php }?> id="paypalwpp" value="paypalwpp"/><span class="paypal1"></span><span class="paypal"><?php echo @constant('TEXT_PAYPAL');?>
</span></label>         
        <div class="submethods" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']==''||$_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='Balance'||$_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='paypalwpp'){?>style="display: block;"<?php }?>> 
           <p class="paytext"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_paypal_clicking'];?>
</p>
            <button class="pay-button"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_pay_now'];?>
</button>
           <p class="paytext"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_paypal_directly'];?>
</p>
         </div>
     </li>
       <li><label for="braintree"><input name="payment" type="radio" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='braintree'){?>checked="checked"<?php }?> id="braintree" value="braintree"/><span class="braintree"></span><span class="paypal"><?php echo @constant('TEXT_BRAINTREE');?>
</span></label>         
                      <div class="submethods" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='braintree'){?>style="display: block;"<?php }?>> 
                         <iframe id="braintree_iframe" scrolling="auto" width="100%" frameborder=0 src="<?php echo @constant('HTTP_SERVER');?>
/index.php?main_page=checkout_braintree&order_id=<?php echo $_smarty_tpl->tpl_vars['message']->value['order_number_created'];?>
&go=<?php echo @constant('FILENAME_CHECKOUT_SUCCESS');?>
" style="height:266px;"></iframe>
                       </div>
                   </li>
     <?php if ($_smarty_tpl->tpl_vars['message']->value['order_total_no_currency_left']>=$_smarty_tpl->tpl_vars['message']->value['order_total_wire_min']){?>
     <li><label for="wire"><input name="payment" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='wire'){?>checked="checked"<?php }?> type="radio" id="wire" value="wire"/><span class="hsbc"></span><span class="paypal"><?php echo @constant('TEXT_BANK_ACCOUNT_HSBC');?>
</span></label>
               <div class="submethods" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='wire'){?>style="display: block;"<?php }?>>
        <p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_bank_hsbc'];?>
:</strong></p>
          <div class="credit purplebg">
          <table>
          <tr><td colspan="2"> <p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_bank_hsbc'];?>
:</strong></p></td></tr>
               <tr><td width="42%" class="credit-left"><?php echo @constant('MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY_BANK');?>
 </td><td width="58%"><?php echo @constant('MODULE_PAYMENT_WIRE_BENEFICIARY_BANK');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WIRE_TEXT_SWIFT_CODE');?>
 </td><td><?php echo @constant('MODULE_PAYMENT_WIRE_SWIFT_CODE');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WIRE_TEXT_BANK_ADDRESS');?>
</td><td ><?php echo @constant('MODULE_PAYMENT_WIRE_BANK_ADDRESS');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WIRE_TEXT_ACCOUNT_NO');?>
</td><td><?php echo @constant('MODULE_PAYMENT_WIRE_ACCOUNT_NO');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY');?>
</td><td ><?php echo @constant('MODULE_PAYMENT_WIRE_BENEFICIARY');?>
</td></tr>                 
           </table>
           </div>
           <button class="Submit-button"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_button_submit'];?>
</button>
           <p><b><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_note'];?>
:</b></p>
           <?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_hsbs_china'];?>

       </div>
            </li>
     <li><label for="wirebc"><input name="payment" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='wirebc'){?>checked="checked"<?php }?> type="radio" id="wirebc" value="wirebc"/><span class="china"></span><span class="paypal"><?php echo @constant('TEXT_BANK_ACCOUNT_BC');?>
</span></label>
       <div class="submethods" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='wirebc'){?>style="display: block;"<?php }?>>
        <p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_bank_china'];?>
:</strong></p>
         <div class="credit purplebg">
          <table>
          <tr><td colspan="2"><p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_bank_china'];?>
:</strong></p></td></tr>
               <tr><td width="42%" class="credit-left"><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_BENEFICIARY_BANK');?>
 </td><td width="58%"><?php echo @constant('MODULE_PAYMENT_WIREBC_BENEFICIARY_BANK');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_1');?>
 </td><td><?php echo @constant('MODULE_PAYMENT_WIREBC_SWIFT_CODE');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_NAME');?>
</td><td ><?php echo @constant('MODULE_PAYMENT_WIREBC_HOLDER_NAME');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_ACCOUNT_NUMBER');?>
</td><td><?php echo @constant('MODULE_PAYMENT_WIREBC_ACCOUNT_NUMBER');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_BANK_ADDRESS');?>
</td><td ><?php echo @constant('MODULE_PAYMENT_WIREBC_BANK_ADDRESS');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_PHONE');?>
 </td><td ><?php echo @constant('MODULE_PAYMENT_WIREBC_HOLDER_PHONE');?>
</td></tr>
           </table>
           </div>
           <button class="Submit-button"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_button_submit'];?>
</button>
           <p><b><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_note'];?>
:</b></p>
           <?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_hsbs_china'];?>

       </div>
     </li>
     <?php }?>
     <li><label for="westernunion"><input name="payment"  <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='westernunion'){?>checked="checked"<?php }?> type="radio" id="westernunion" value="westernunion"/><span class="westen"></span><span class="paypal"><?php echo @constant('TEXT_WESTERN_UNION');?>
</span></label>
             <div class="submethods" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='westernunion'){?>style="display: block;"<?php }?>>
        <p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_bank_western_union'];?>
:</strong></p>
         <div class="credit purplebg">
          <table>
               <tr><td colspan="2"><p><strong><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_bank_western_union'];?>
:</strong></p></td></tr>
               <tr><td width="42%" class="credit-left"><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME');?>
 </td><td width="58%"><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME');?>
 </td><td><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS');?>
</td><td ><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP');?>
</td><td><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY');?>
</td><td ><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY');?>
</td></tr>
                      <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY');?>
</td><td ><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY');?>
</td></tr>
                      <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE');?>
</td><td ><?php echo @constant('MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE');?>
</td></tr>
               
           </table>
           </div>
           <button class="Submit-button"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_button_submit'];?>
</button>
           <p><b><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_note'];?>
:</b></p>
           <?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_wumt'];?>

       </div>
            </li>
     <li><label for="moneygram"><input name="payment" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='moneygram'){?>checked="checked"<?php }?> type="radio" id="moneygram" value="moneygram"/><span class="money-gram"></span><span class="paypal"><?php echo @constant('TEXT_MONEY_GRAM_INFO');?>
</span></label>
               <div class="submethods" <?php if ($_smarty_tpl->tpl_vars['message']->value['payment_module_code']=='moneygram'){?>style="display: block;"<?php }?>>
         <p><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_TEXT_HEAD');?>
:</p>
         <div class="credit purplebg">
          <table>
          <tr><td colspan="2"> <p><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_TEXT_HEAD');?>
:</p></td></tr>
               <tr><td width="42%" class="credit-left"><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_FIRST_NAME');?>
 </td><td width="58%"><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_FIRST_NAME');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_LAST_NAME');?>
 </td><td><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_LAST_NAME');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_ADDRESS');?>
</td><td ><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_ADDRESS');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_ZIP');?>
</td><td><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_ZIP');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_CITY');?>
</td><td ><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_CITY');?>
</td></tr>
               <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_COUNTRY');?>
 </td><td ><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_COUNTRY');?>
</td></tr>
                      <tr><td class="credit-left"><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_ENTRY_PHONE');?>
 </td><td ><?php echo @constant('MODULE_PAYMENT_MONEYGRAM_RECEIVER_PHONE');?>
</td></tr>
           </table>
           </div>
           <button class="Submit-button"><?php echo $_smarty_tpl->tpl_vars['message']->value['payment_button_submit'];?>
</button>
           <p><b><?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_note'];?>
:</b></p>
          <p>1.&nbsp;<?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_money_gram'];?>
</p>
             <?php echo $_smarty_tpl->tpl_vars['message']->value['account_payment_money_gram_2'];?>

       </div>
            </li>
  </ul>
    <?php }?>
    </form>
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
<div class="methods"><a href="" class="back-button"><?php echo @constant('TEXT_BACK');?>
</a></div>

    </div>  
</div> -->
<?php }} ?>