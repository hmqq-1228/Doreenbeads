<?php /* Smarty version Smarty-3.1.13, created on 2020-03-11 18:15:45
         compiled from "includes\templates\checkout\tpl_checkout_head.html" */ ?>
<?php /*%%SmartyHeaderCode:198375e68ba51dfa4a5-85079020%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b3a7bdb0dddf8af8d614a7790f87562504ec7f0d' => 
    array (
      0 => 'includes\\templates\\checkout\\tpl_checkout_head.html',
      1 => 1575421047,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '198375e68ba51dfa4a5-85079020',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'style_step1' => 0,
    'style_step2' => 0,
    'style_step3' => 0,
    'style_step4' => 0,
    'open_live_chat_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e68ba51e63192_33310095',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e68ba51e63192_33310095')) {function content_5e68ba51e63192_33310095($_smarty_tpl) {?><div id="min_hd">
	 <div class="logo fleft">
        <a href="<?php echo @constant('HTTP_SERVER');?>
"><img src="includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>
/logo1.png"></a>
        <p class="font14"><a href="<?php echo @constant('HTTP_SERVER');?>
/page.html?id=159"><?php echo @constant('TEXT_LOGO_TITLE');?>
</a></p>
     </div>
    <div class="step" >
    	<ul>
        	<li class="<?php echo $_smarty_tpl->tpl_vars['style_step1']->value;?>
"><?php echo @constant('TEXT_CHECKOUT_STEP1');?>
</li>
            <li class="<?php echo $_smarty_tpl->tpl_vars['style_step2']->value;?>
"><?php echo @constant('TEXT_CHECKOUT_STEP2');?>
</li> 
            <li class="<?php echo $_smarty_tpl->tpl_vars['style_step3']->value;?>
"><?php echo @constant('TEXT_CHECKOUT_STEP3');?>
</li>
            <li class="<?php echo $_smarty_tpl->tpl_vars['style_step4']->value;?>
"><?php echo @constant('TEXT_CHECKOUT_STEP4');?>
</li>
        </ul>
    </div>
   
   
<!--     <div class="livechat"><a href="javascript:void(0);" <?php echo $_smarty_tpl->tpl_vars['open_live_chat_url']->value;?>
><img src="includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>
/help.png" /></a></div>
 -->

<div class="consult">
		<a rel="nofollow" href="javascript:void(0);"><img src="includes/templates/cherry_zen/images/<?php echo $_SESSION['language'];?>
/help.png" /></a>
	</div>

</div>
<div class="min_yellowline"></div>
<?php }} ?>