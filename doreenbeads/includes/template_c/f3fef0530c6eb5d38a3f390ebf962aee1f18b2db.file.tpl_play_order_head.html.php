<?php /* Smarty version Smarty-3.1.13, created on 2020-04-17 09:06:13
         compiled from "includes\templates\mobilesite\tpl\tpl_play_order_head.html" */ ?>
<?php /*%%SmartyHeaderCode:26935e99010591ff83-74598929%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3fef0530c6eb5d38a3f390ebf962aee1f18b2db' => 
    array (
      0 => 'includes\\templates\\mobilesite\\tpl\\tpl_play_order_head.html',
      1 => 1575421067,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26935e99010591ff83-74598929',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e9901059b2ea3_30504585',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e9901059b2ea3_30504585')) {function content_5e9901059b2ea3_30504585($_smarty_tpl) {?><div class="shop-process">
	<ul class="shopprocess-list">
	   <li class="current-1 <?php if ($_GET['main_page']=='checkout'||$_GET['main_page']=='checkout_payment'||$_GET['main_page']=='checkout_success'){?> now<?php }?>"><span>1</span><strong><?php echo @constant('HEADER_PROCESS1');?>
</strong></li>
	   <li class="current-2 <?php if ($_GET['main_page']=='checkout'){?> now <?php }elseif($_GET['main_page']=='checkout_payment'||$_GET['main_page']=='checkout_success'){?> now-1<?php }?>"><span>2</span><strong><?php echo @constant('HEADER_PROCESS2');?>
</strong></li>
	   <li class="current-3 <?php if ($_GET['main_page']=='checkout_payment'){?> now <?php }elseif($_GET['main_page']=='checkout_success'){?> now-1<?php }?>"><span>3</span><strong><?php echo @constant('HEADER_PROCESS3');?>
</strong></li>
	   <li class="current-4<?php if ($_GET['main_page']=='checkout_success'){?> now<?php }?>"><span>4</span><strong><?php echo @constant('HEADER_PROCESS4');?>
</strong></li>
	</ul>
</div><?php }} ?>