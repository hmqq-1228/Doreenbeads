<?php /* Smarty version Smarty-3.1.13, created on 2019-12-04 11:34:34
         compiled from "includes\languages\english\html_includes\define_mobile_homepage.php" */ ?>
<?php /*%%SmartyHeaderCode:135815de7294a669f06-66934812%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f5e4dab8d9e42a52a8d7aef7af3790db63787a6e' => 
    array (
      0 => 'includes\\languages\\english\\html_includes\\define_mobile_homepage.php',
      1 => 1575421082,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '135815de7294a669f06-66934812',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5de7294a766858_27916064',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5de7294a766858_27916064')) {function content_5de7294a766858_27916064($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\www\\doreenbeads\\includes\\libs\\plugins\\modifier.date_format.php';
?><?php if (smarty_modifier_date_format(time(),"%w")==0||smarty_modifier_date_format(time(),"%w")==5||smarty_modifier_date_format(time(),"%w")==6){?>

<li><a href="http://www.doreenbeads.com/index.php?main_page=promotion_price&g=6"><img alt="Weekend Deals"  height="292" src="http://img.doreenbeads.com/promotion_photo/en/images/20150610/weekend-deals.jpg" width="764px" /></a></li>
<?php }?>


<div class="banner mian_wrap">
    <a href="#">
        <img src="/includes/templates/mobilesite/css/en/images/free.jpg">
    </a>
    <a href="#">
        <img src="/includes/templates/mobilesite/css/en/images/banner.jpg">
    </a>
    <a href="#">
        <img src="/includes/templates/mobilesite/css/en/images/banner1.jpg">
    </a>
    <a href="#">
        <img src="/includes/templates/mobilesite/css/en/images/banner2.jpg">
    </a>
</div>

<?php echo smarty_modifier_date_format((time()-20),"%w");?>


<div class="min_banner">
    <ul>
        <li>
            <a href="#">
                <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/310.gif" data-size="310"
                     data-lazyload="/includes/templates/mobilesite/css/en/images/01-banner.jpg">
            </a>
        </li>
        <li>
            <a href="#">
                <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/310.gif" data-size="310"
                     data-lazyload="/includes/templates/mobilesite/css/en/images/01-banner.jpg">
            </a>
        </li>
        <li>
            <a href="#">
                <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/310.gif" data-size="310"
                     data-lazyload="/includes/templates/mobilesite/css/en/images/01-banner.jpg">
            </a>
        </li>
        <li>
            <a href="#">
                <img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/310.gif" data-size="310"
                     data-lazyload="/includes/templates/mobilesite/css/en/images/01-banner.jpg">
            </a>
        </li>
    </ul>
    <div class="clearfix"></div>
</div><?php }} ?>