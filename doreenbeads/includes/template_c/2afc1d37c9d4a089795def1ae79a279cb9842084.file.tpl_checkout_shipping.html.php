<?php /* Smarty version Smarty-3.1.13, created on 2020-04-17 09:07:00
         compiled from "includes\templates\mobilesite\tpl\checkout\tpl_checkout_shipping.html" */ ?>
<?php /*%%SmartyHeaderCode:143115e99013491f3c9-08054276%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2afc1d37c9d4a089795def1ae79a279cb9842084' => 
    array (
      0 => 'includes\\templates\\mobilesite\\tpl\\checkout\\tpl_checkout_shipping.html',
      1 => 1575421066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143115e99013491f3c9-08054276',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'shipping_methods_show' => 0,
    'k' => 0,
    'default_shipping_method' => 0,
    'v' => 0,
    'n' => 0,
    'shipping_methods_unshow' => 0,
    'shipping_method_limit' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e990134af6ec2_92640672',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e990134af6ec2_92640672')) {function content_5e990134af6ec2_92640672($_smarty_tpl) {?><div class="order_main">
    <div class="order_warp">
		<div class="ship_methods">
        	<div class="price_sort">
	          	<div class="currency_nav" style="margin-bottom: 15px;">
		            <select class="sc_sort">
			            <option value="drise"><?php echo @constant('TEXT_DAYS_ALT_S_Q');?>
</option>
			            <option value="ddown"><?php echo @constant('TEXT_DAYS_ALT_Q_S');?>
</option>
			            <option value="prise" selected><?php echo @constant('TEXT_PRICE_ALT_L_H');?>
</option>
			            <option value="pdown"><?php echo @constant('TEXT_PRICE_ALT_H_L');?>
</option>
			        </select>
	          	</div>
	        </div>
        	<ul class="address shipping_ul">
        		<?php $_smarty_tpl->tpl_vars['n'] = new Smarty_variable(1, null, 0);?>
			    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['shipping_methods_show']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
          		<li >
	          		<div <?php if ($_smarty_tpl->tpl_vars['k']->value==$_smarty_tpl->tpl_vars['default_shipping_method']->value){?>class="shippingcontContentSelect"<?php }?> style="margin: 15px 0 15px 0;">
			            <p>
			            	<span class="price_color"><?php echo $_smarty_tpl->tpl_vars['v']->value['cost_show'];?>
</span><br />
			              	<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
<br /><?php echo $_smarty_tpl->tpl_vars['v']->value['days_show'];?>

			              	<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['code'];?>
" class="code">
			              	<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['final_cost'];?>
" class="cost">
			              	<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['day']*100+$_smarty_tpl->tpl_vars['v']->value['day_high'];?>
" class="day">
			            </p>
			            <?php if ($_smarty_tpl->tpl_vars['v']->value['show_note']!=''){?>
				            <img src="/includes/templates/mobilesite/css/<?php echo $_SESSION['languages_code'];?>
/images/addr_info.png" style="margin-top: 25px;margin-right: 10px;" href="javascript:void(0);"class="notebook">
			    		<?php }?>
		    		</div>
		    		<?php if ($_smarty_tpl->tpl_vars['v']->value['show_note']!=''){?>
		    			<div style="position:relative;">
				    		<div class="tip_wrap" style="position: absolute;z-index: 2;top:-10px">
				                <div class="tip_msg"><?php echo $_smarty_tpl->tpl_vars['v']->value['show_note'];?>
</div>
				    		</div>
			    		</div>
				    <?php }?>
           		</li>
           		<?php $_smarty_tpl->tpl_vars['n'] = new Smarty_variable($_smarty_tpl->tpl_vars['n']->value+1, null, 0);?>
		        <?php } ?>
		        <?php if (sizeof($_smarty_tpl->tpl_vars['shipping_methods_unshow']->value)>0){?>
		        	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['shipping_methods_unshow']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
		        	<?php if (!$_smarty_tpl->tpl_vars['shipping_method_limit']->value[$_smarty_tpl->tpl_vars['v']->value['id']]){?>
		        		<li class="not_show" >
		        			<div <?php if ($_smarty_tpl->tpl_vars['k']->value==$_smarty_tpl->tpl_vars['default_shipping_method']->value){?>shippingcontContentSelect<?php }?> style="margin: 15px 0 15px 0;">
					            <p>
					            	<span class="price_color"><?php echo $_smarty_tpl->tpl_vars['v']->value['cost_show'];?>
</span><br />
					              	<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
<br /><?php echo $_smarty_tpl->tpl_vars['v']->value['days_show'];?>

					              	<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['code'];?>
" class="code">
					              	<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['final_cost'];?>
" class="cost">
					              	<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['day']*100+$_smarty_tpl->tpl_vars['v']->value['day_high'];?>
" class="day">
					            </p>
					            <?php if ($_smarty_tpl->tpl_vars['v']->value['show_note']!=''){?>
						            <a style="margin-top: 17px;" href="javascript:void(0);"class="notebook"></a> 
					    		<?php }?>
				    		</div>
				    		<?php if ($_smarty_tpl->tpl_vars['v']->value['show_note']!=''){?>
				    			<div style="position:relative;">
						    		<div class="tip_wrap" style="position: absolute;z-index: 2;top:-10px">
						                <div class="tip_msg"><?php echo $_smarty_tpl->tpl_vars['v']->value['show_note'];?>
</div>
						    		</div>
					    		</div>
						    <?php }?>
		           		</li>
		        	<?php }?>
		        	<?php } ?>
		        <?php }?>
		        <!-- 被限制的运输方式需要排在最下面，并且不可排序。 -->
		        <?php $_smarty_tpl->tpl_vars['n'] = new Smarty_variable(1, null, 0);?>
			    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['shipping_methods_show']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
			    <?php if ($_smarty_tpl->tpl_vars['shipping_method_limit']->value[$_smarty_tpl->tpl_vars['v']->value['code']]){?>	   
					<li class="shipping_method_limit_tr">
						<div <?php if ($_smarty_tpl->tpl_vars['k']->value==$_smarty_tpl->tpl_vars['default_shipping_method']->value){?>shippingcontContentSelect<?php }?> style="margin: 15px 0 15px 0;">
				            <p>
				            	<span class="price_color"><?php echo $_smarty_tpl->tpl_vars['v']->value['cost_show'];?>
</span><br />
				              	<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
<br /><?php echo $_smarty_tpl->tpl_vars['v']->value['days_show'];?>

				              	<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['code'];?>
" class="code">
				              	<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['final_cost'];?>
" class="cost">
				              	<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['day']*100+$_smarty_tpl->tpl_vars['v']->value['day_high'];?>
" class="day">
				            </p>
				            <?php if ($_smarty_tpl->tpl_vars['v']->value['show_note']!=''){?>
					            <a style="margin-top: 17px;" href="javascript:void(0);"class="notebook"></a> 
				    		<?php }?>
			    		</div>
			    		<?php if ($_smarty_tpl->tpl_vars['v']->value['show_note']!=''){?>
			    			<div style="position:relative;">
					    		<div class="tip_wrap" style="position: absolute;z-index: 2;top:-10px">
					                <div class="tip_msg"><?php echo $_smarty_tpl->tpl_vars['v']->value['show_note'];?>
</div>
					    		</div>
				    		</div>
					    <?php }?>
	           		</li>
				<?php }?>
				<?php $_smarty_tpl->tpl_vars['n'] = new Smarty_variable($_smarty_tpl->tpl_vars['n']->value+1, null, 0);?>
		        <?php } ?>
        	</ul>
        	<?php if (sizeof($_smarty_tpl->tpl_vars['shipping_methods_unshow']->value)>0){?>
			<div class="shipping_method_display_tips"><?php echo @constant('TEXT_SHIPPING_METHOD_DISPLAY_TIPS');?>
</div>
			<?php }?>
      	</div>
	</div>
</div> <?php }} ?>