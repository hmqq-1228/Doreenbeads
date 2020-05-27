<?php /* Smarty version Smarty-3.1.13, created on 2020-04-08 16:25:15
         compiled from "includes\templates\products_list.html" */ ?>
<?php /*%%SmartyHeaderCode:261795e8d8a6b65f488-70614440%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7275dd1d6d2096ad7913313e7c9a6909e371aadf' => 
    array (
      0 => 'includes\\templates\\products_list.html',
      1 => 1575421047,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '261795e8d8a6b65f488-70614440',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tabular' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e8d8a6b6b27c6_94695018',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8d8a6b6b27c6_94695018')) {function content_5e8d8a6b6b27c6_94695018($_smarty_tpl) {?><ul class="list">
    <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tabular']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
    <li><?php echo $_smarty_tpl->tpl_vars['value']->value['maximage'];?>
<?php echo $_smarty_tpl->tpl_vars['value']->value['image'];?>
<div class="product_info"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
<?php echo $_smarty_tpl->tpl_vars['value']->value['price'];?>
<?php echo $_smarty_tpl->tpl_vars['value']->value['model'];?>
</div><div class="product_btn"><?php echo $_smarty_tpl->tpl_vars['value']->value['cart'];?>
</div><div class="clearfix"></div></li>
    <?php } ?> 
</ul><?php }} ?>