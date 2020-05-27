<?php /* Smarty version Smarty-3.1.13, created on 2019-12-04 11:34:50
         compiled from "includes\templates\mobilesite\tpl\tpl_index_category_list.html" */ ?>
<?php /*%%SmartyHeaderCode:158675de7295ad7ba79-22648745%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a7383299aacaea2070acb2d68744eeb794bbfcc2' => 
    array (
      0 => 'includes\\templates\\mobilesite\\tpl\\tpl_index_category_list.html',
      1 => 1575421067,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '158675de7295ad7ba79-22648745',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category_info' => 0,
    'subCategories' => 0,
    'category' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5de7295ade20a3_51793044',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5de7295ade20a3_51793044')) {function content_5de7295ade20a3_51793044($_smarty_tpl) {?><div class=" categories mian_wrap">
	<h3><?php echo $_smarty_tpl->tpl_vars['category_info']->value['categories_name'];?>
</h3>
	<ul>
		<?php if (is_array($_smarty_tpl->tpl_vars['subCategories']->value)&&$_smarty_tpl->tpl_vars['subCategories']->value){?>
		<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['subCategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
		<li>
			<a href="<?php echo $_smarty_tpl->tpl_vars['category']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/178.gif" data-size="178" data-lazyload="<?php echo $_smarty_tpl->tpl_vars['category']->value['categories_image_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
" ><p><?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
</p></a>
		</li>
		<?php } ?>
		<?php }?>
		<div class="clearfix"></div>
	</ul>
</div><?php }} ?>