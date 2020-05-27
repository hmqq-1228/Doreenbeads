<?php /* Smarty version Smarty-3.1.13, created on 2020-04-10 15:51:31
         compiled from "includes\templates\checkout\tpl_checkout_shipping.html" */ ?>
<?php /*%%SmartyHeaderCode:302795e9025832d60f5-71655499%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6b21f3e9334c2fd6ee42279a2af217d15148bb90' => 
    array (
      0 => 'includes\\templates\\checkout\\tpl_checkout_shipping.html',
      1 => 1575421047,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '302795e9025832d60f5-71655499',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'paypal_success_url' => 0,
    'obj_info' => 0,
    'address_num' => 0,
    'address_info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e90258359f8c4_23161685',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e90258359f8c4_23161685')) {function content_5e90258359f8c4_23161685($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('includes/templates/checkout/tpl_checkout_head.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<input type="hidden" id="paypal_success_url" value="<?php echo $_smarty_tpl->tpl_vars['paypal_success_url']->value;?>
">
<div class="min_main">
	<div class="caption_shopgray" numVal="n<?php echo $_smarty_tpl->tpl_vars['obj_info']->value['info_customers_id'];?>
" sto='<?php echo $_smarty_tpl->tpl_vars['obj_info']->value["sendto"];?>
' lang='<?php echo $_smarty_tpl->tpl_vars['obj_info']->value["langs"];?>
' listShow="<?php echo $_smarty_tpl->tpl_vars['obj_info']->value['add_show'];?>
">
		<a name="marked1"></a><h3>1.<?php echo @constant('TEXT_ADDRESS_INFOMATION');?>
</h3><p><label>*</label><?php echo @constant('TEXT_REQUIRED_FIELDS');?>
</p>
	</div>
	<div class="captioncontent captionloading">
		<p id="shipping_address_show" class="addrtit" style="display:none"><?php echo @constant('TABLE_HEADING_ADDRESS_LINE');?>
:</p>
		<?php if ($_smarty_tpl->tpl_vars['address_num']->value==0){?>
			<form class="addrform" id="new_address_book" name="new_address_book" style="display:none" onsubmit='return false'>
				<table width="900" style="table-layout:fixed;">
					<tr><td width="150"><label>*</label><?php echo @constant('TEXT_TITLE');?>
:</td><td><!-- <input type="radio" value="m" name="gender" id="gender" style="float: none;" checked />&nbsp;&nbsp;&nbsp;<?php echo @constant('MALE');?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="gender" id="gender" value="f" style="float: none;" />&nbsp;&nbsp;&nbsp;<?php echo @constant('FEMALE');?>
 -->
					<select name="gender" id="gender" style="width:80px;">
						<option value="m" selected><?php echo @constant('MALE');?>
</option>
						<option value="f"><?php echo @constant('FEMALE');?>
</option>
					</select>
					</td></tr>
					<tr>
						<td><label>*</label><?php echo @constant('TEXT_NAME');?>
:</td><td width="400"><input type="text" name="firstname" id="firstname" class="firstname myrequired"/><input type="text" name="lastname" id="lastname" class="lastname myrequired"/>
							<div><span class="firstn error firstn_error"></span><span class="lastn error lastn_error"></span></div>
							<dl class="name">
								<dd>*</dd><dt><?php echo @constant('TEXT_FIRST_NAME');?>
</dt><dd>*</dd><dt><?php echo @constant('TEXT_LAST_NAME');?>
</dt>
							</dl>
						</td>
					</tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo @constant('TEXT_CHECKOUT_COMPANY_NAME');?>
:</td><td><input type="text" name="company" id="company" class="companyname"/></td></tr>
					<tr>
						<td><label>*</label><?php echo @constant('TABLE_HEADING_ADDRESS_LINE');?>
 1:</td>
						<td><input type="text" name="street_address" id="street_address" class="addresstext myrequired street"/><span class="error street_error"></span>
							<div class="note"><span>&bull;</span><?php echo @constant('TEXT_CHECKOUT_FILL_DETAIL');?>
</div><div class="note note1"><span>&bull;</span><?php echo @constant('TEXT_CHECKOUT_SUGGEST_ENGLISH');?>
<ins class="question_icon"></ins>
								<div class="addrtips"><span class="bot"></span><span class="top"></span><?php echo @constant('TEXT_CHECKOUT_SUGGEST_ENGLISH_INFO');?>
</div>
							</div>
						</td>
					</tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo @constant('TABLE_HEADING_ADDRESS_LINE');?>
 2:</td><td><input type="text" name="suburb" id="suburb" class="addresstext"/><br/><span class="error suburb_error"></span></td></tr>
					<tr><td><label>*</label><?php echo @constant('TEXT_CITY');?>
:</td><td><input type="text" name='city' id='city' class="city myrequired"/><span class="error city_error"></span></td></tr>
					<tr><td><label>*</label><?php echo @constant('ENTRY_COUNTRY');?>
</td><td><?php echo $_smarty_tpl->tpl_vars['obj_info']->value["country_select"];?>
<span class="error country_error"></span></td></tr>
					<tr><td><label>*</label><?php echo @constant('TEXT_CHECKOUT_STATE');?>
:</td><td><?php echo $_smarty_tpl->tpl_vars['obj_info']->value["pulldown_states"];?>
<span class="error state_error"></span><div class="note"><span>&bull;</span><?php echo @constant('TEXT_CHECKOUT_BETTER_FULFILL');?>
 </div></td></tr>
					<tr><td><label>*</label><?php echo @constant('TEXT_CHECKOUT_POSTAL_CODE');?>
:</td><td><input type="text" name='postcode' id='postcode' class="myrequired postal"/><span class="error postcode_error"></span></td></tr>
					<tr><td><label>*</label><?php echo @constant('TEXT_CHECKOUT_PHONE_NUMBER');?>
:</td><td><input type="text" name='telephone' id='telephone' class="tel myrequired"/><span class="error telephone_error"></span><div class="note"><span>&bull;</span><?php echo @constant('TEXT_CHECKOUT_PHONE_NUMBER_REQUIRED');?>
</div></td></tr>
					<tr><td><span style="color:black;"><?php echo @constant('TEXT_CUSTOM_NO');?>
:</span></td><td><input type="text" name='tariff_number' id='tariff_number'><br><span class='tar myrequired'></span><br/><span class="error" id="tariff_number_error"></span></td></tr>
					<tr><td><span style="color:black;"><?php echo @constant('ENTRY_EMAIL_ADDRESS');?>
</span></td><td><input type="text" name='email_address' id='email_address'><br><span class='backup_email myrequired'></span><br/><span class="error" id="email_address_error"></span></td></tr>
					<tr><td></td><td><button class="addresssubmit" id="save_address"><?php echo @constant('TABLE_SAVE_ADDRESS');?>
</button></td></tr>
				</table>
			</form>
		<?php }?>
	</div>

	<div class="caption_shopgray">
		<a name="marked2"></a><h3>2.<?php echo @constant('TEXT_SHIPPING_METHOD');?>
</h3>
	</div>
	<div class="captioncontent captionloading">
	</div>

	<div class="caption_shopgray" nccemcy="<?php echo $_smarty_tpl->tpl_vars['obj_info']->value['curreny'];?>
">
		<a name="marked3"></a><h3>3.<?php echo @constant('TEXT_INVOICE_COMMENTS');?>
</h3>
	</div>
	<div class="captioncontent captionloading">
	</div>

	<div class="caption_shopgray">
		<h3>4.<?php echo @constant('TEXT_REVIEW_ORDER');?>
</h3>
	</div>
	<div class="captioncontent captionloading" id="order_shopcart">
	</div>

</div>

<div class="windowbody" style="display:none;"></div>
<!-- window of edit/add address -->
<div class="smallwindow windowaddress" style="display:none;">
	<div class="smallwindowtit"><strong><?php echo @constant('TEXT_EDIT_ADDRESS_INFO');?>
</strong><a href="javascript:void(0);" class="addressclose">X</a></div>
	<div class="addresscont">
		<form id="new_address_book" name="new_address_book">
			<table width="92%"><tbody>
				<tr><th width="150"><span class="font_red">*</span><label><?php echo @constant('TEXT_TITLE');?>
:</label></th>
					<td width="296">
						<select name="gender" style="width:80px;" id="gender">
							<option value='m' <?php if ($_smarty_tpl->tpl_vars['address_info']->value["entry_gender"]=='m'||$_smarty_tpl->tpl_vars['address_info']->value["entry_gender"]==''){?>selected <?php }?>><?php echo @constant('TEXT_MALE');?>
</option>
							<option value='f' <?php if ($_smarty_tpl->tpl_vars['address_info']->value["entry_gender"]=='f'){?>selected <?php }?>><?php echo @constant('TEXT_FEMALE');?>
</option>
						</select>
<!-- 					<input type="radio" value="m" name="gender" id="gender" style="float: none;" checked />&nbsp;<?php echo @constant('MALE');?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="gender" id="gender" value="f" style="float: none;" />&nbsp;<?php echo @constant('FEMALE');?>
 -->
					</td>
				</tr>
				<tr>
					<th><span class="font_red">*</span><label><?php echo @constant('TEXT_NAME');?>
:</label></th><td><input type="text" name="firstname" id="firstname" class="firstn firstname myrequired" value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_firstname"];?>
'/><input type="text" name="lastname" id="lastname" class="lastn lastname myrequired" value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_lastname"];?>
'/>
						<div><span class="firstn error firstn_error"></span><span class="lastn error lastn_error"></span></div>
						<dl>
							<dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>*</span><?php echo @constant('TEXT_FIRST_NAME');?>
<dd>
							<dt><span class="last">*</span><?php echo @constant('TEXT_LAST_NAME');?>
</dt>
						</dl>
					</td>
				</tr>
				
				<tr>
					<th><span class="font_red">*</span><label><?php echo @constant('TABLE_HEADING_ADDRESS_LINE');?>
 1:</label></th>
					<td><input type="text" name="street_address" id="street_address" class="addresstext myrequired street" value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_street_address"];?>
'/>
						<span class="error street_error"></span>
						<div class="note"><span>&bull;</span><?php echo @constant('TEXT_CHECKOUT_FILL_DETAIL');?>
</div><div class="note note1"><span>&bull;</span><?php echo @constant('TEXT_CHECKOUT_SUGGEST_ENGLISH');?>
<ins class="question_icon"></ins>
							<div class="addrtips"><span class="bot"></span><span class="top"></span><?php echo @constant('TEXT_CHECKOUT_SUGGEST_ENGLISH_INFO');?>
</div>
						</div>
					</td>
				</tr>
				<tr><th><span class="font_red">&nbsp;&nbsp;</span><label><?php echo @constant('TABLE_HEADING_ADDRESS_LINE');?>
 2:</label></th><td><input type="text" name="suburb" id="suburb" class="addresstext" value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_suburb"];?>
'/><span class="error suburb_error"></td></tr>
				<tr><th><span class="font_red">*</span><label><?php echo @constant('TEXT_CITY');?>
:</label></th><td><input type="text" name='city' id='city' class="citytext city myrequired" value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_city"];?>
'/><span class="error city_error"></td></tr>
				<tr><th><span class="font_red">*</span><label><?php echo @constant('ENTRY_COUNTRY');?>
:</label></th><td><?php echo $_smarty_tpl->tpl_vars['obj_info']->value["country_select"];?>
</td></tr>
				<tr><th><span class="font_red">*</span><label><?php echo @constant('TEXT_CHECKOUT_STATE');?>
:</label></th><td><?php echo $_smarty_tpl->tpl_vars['obj_info']->value["pulldown_states"];?>
<span class="error state_error"></span><div class="note"><span>&bull;</span><?php echo @constant('TEXT_CHECKOUT_BETTER_FULFILL');?>
 </div></td></tr>
				<tr><th><span class="font_red">*</span><label><?php echo @constant('TEXT_CHECKOUT_POSTAL_CODE');?>
:</label></th><td><input type="text" name='postcode' id='postcode' class="myrequired postal" value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_postcode"];?>
'/><span class="error postcode_error"></span></td></tr>
				<tr><th><span class="font_red">*</span><label><?php echo @constant('TEXT_CHECKOUT_PHONE_NUMBER');?>
:</label></th><td><input type="text" name='telephone' id='telephone' class="tel myrequired" value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["telephone_number"];?>
'/><span class="error telephone_error"></span><div class="note"><span>&bull;</span><?php echo @constant('TEXT_CHECKOUT_PHONE_NUMBER_REQUIRED');?>
</div></td></tr>
				<tr><th><span class="font_red"></span><label><?php echo @constant('TEXT_CHECKOUT_COMPANY_NAME');?>
:</label></th><td><input type="text" name="company" id="company" value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["entry_company"];?>
'/></td></tr>
			    <tr><th><span style="color:black;"><label><?php echo @constant('TEXT_CUSTOM_NO');?>
:</label></span></th><td><input type="text" name='tariff_number' id='tariff_number' class='tar myrequired' value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["tariff_number"];?>
'><br><div class="note"><span>&bull;</span><?php echo @constant('ENTRY_TARIFF_REQUIRED_TEXT');?>
</div></td></tr>
                <tr><th><span style="color:black;"><label><?php echo @constant('ENTRY_EMAIL_ADDRESS');?>
</label></span></th><td><input type="text" name='email_address' id='email_address' class='backup_email myrequired' value='<?php echo $_smarty_tpl->tpl_vars['address_info']->value["backup_email_address"];?>
'><br><div class="note"><span>&bull;</span><?php echo @constant('ENTRY_BACKUP_EMAIL_REQUESTED_TEXT');?>
</div></td></tr>
			</tbody></table>
			<div class="formbtn">
				<button class="addresssubmit" id="save_address"><?php echo @constant('TABLE_SAVE_ADDRESS');?>
</button>
				<button class="orderbtn_grey" id="cancel_address"><?php echo @constant('TEXT_CANCEL');?>
</button>
			</div>
		</form>
	</div>
</div>

<!-- window of pack tips -->
<div class="extrawindow smallwindow" style="display:none;position: fixed;" id="open_window_checkout">
	<h2><a class="checkoutclose" href="javascript:void(0)">X</a></h2>
	<div class="packing_title_div">
	</div>
	<div class="extra_tips">
			( <font> <?php echo @constant('TEXT_EXTRA_TIPS');?>
<ins class="icon_question"></ins></font> )
			<div class="extratips" style="display:none;">
				<span class="bot"></span>
				<span class="top"></span>
				<?php echo @constant('TEXT_EXTAR_SHIPPING_FEE');?>

			</div>
		</div>
	<div class="error_packing_info"><?php echo @constant('TEXT_ERROR_PACKING_TIPS');?>
</div>
	<p class="doublebutton">
		<button class="purplecolor_btn"><?php echo @constant('TEXT_PLACE_YOUR_ORDER');?>
</button>
		<button class="greycolor_btn"><span><strong><?php echo @constant('TEXT_CANCEL');?>
</strong></span></button>
	</p>
</div>
<?php }} ?>