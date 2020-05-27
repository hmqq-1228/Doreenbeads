<?php /* Smarty version Smarty-3.1.13, created on 2019-12-04 11:34:34
         compiled from "includes\templates\mobilesite\tpl\tpl_index_homepage.html" */ ?>
<?php /*%%SmartyHeaderCode:9325de7294a536c61-62285025%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64d47ed520bc8007edd8facde8ee803678645406' => 
    array (
      0 => 'includes\\templates\\mobilesite\\tpl\\tpl_index_homepage.html',
      1 => 1575421066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9325de7294a536c61-62285025',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'define_page' => 0,
    'index_root_categories_array' => 0,
    'category' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5de7294a65e4b6_78799939',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5de7294a65e4b6_78799939')) {function content_5de7294a65e4b6_78799939($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['define_page']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

 
<div class="menu">
  <div class="menu_title">
    <h3><?php echo @constant('TEXT_SHOP_CATEGORIES');?>
</h3>
  </div> 
  
  <ul>
    <?php if (is_array($_smarty_tpl->tpl_vars['index_root_categories_array']->value)&&$_smarty_tpl->tpl_vars['index_root_categories_array']->value){?>
	    <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['index_root_categories_array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
	    	<?php if ($_smarty_tpl->tpl_vars['category']->value['level']<=$_SESSION['customers_level']){?>
	    		<li><a href="<?php echo zen_href_link(@constant('FILENAME_DEFAULT'),$_smarty_tpl->tpl_vars['category']->value['cPath']);?>
"><span><?php echo $_smarty_tpl->tpl_vars['category']->value['text'];?>
</span> <ins class="<?php echo $_smarty_tpl->tpl_vars['category']->value['class_name'];?>
"></ins></a></li> 
	    	<?php }?>
		<?php } ?>  
    <?php }?>
  </ul>
</div>
<?php }} ?>