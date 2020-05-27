<?php /* Smarty version Smarty-3.1.13, created on 2020-04-16 16:03:23
         compiled from "includes\templates\checkout\tpl_products_foryour_consider.html" */ ?>
<?php /*%%SmartyHeaderCode:33645e98114b676d52-33497655%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f9321297e9bc56d94acc93574350e993892e1ab' => 
    array (
      0 => 'includes\\templates\\checkout\\tpl_products_foryour_consider.html',
      1 => 1575421047,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '33645e98114b676d52-33497655',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products_for_your' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e98114b6bcac2_12587865',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e98114b6bcac2_12587865')) {function content_5e98114b6bcac2_12587865($_smarty_tpl) {?><!-- Products for your considersation -->
<?php if ($_smarty_tpl->tpl_vars['products_for_your']->value){?>
<div class="caption_recent">
	<h3><?php echo @constant('TEXT_PRODUCTS_FOR_CONSIDERATION');?>
</h3>
</div>	 
<div class="pic_list product_list gallery">
	<ul>
	<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['products_for_your']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['product']->key;
?>
		<li>
			<?php echo $_smarty_tpl->tpl_vars['product']->value['img'];?>

			<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>

			<?php echo $_smarty_tpl->tpl_vars['product']->value['price'];?>

			<?php echo $_smarty_tpl->tpl_vars['product']->value['button'];?>

		</li>
	<?php } ?>
		<div class="clear"></div>
	</ul>
</div>
<?php }?>
<?php }} ?>