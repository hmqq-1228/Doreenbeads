<?php /* Smarty version Smarty-3.1.13, created on 2020-04-17 09:06:02
         compiled from "includes\templates\mobilesite\tpl\tpl_index_product_gallery.html" */ ?>
<?php /*%%SmartyHeaderCode:127545e9900fa707eb5-93180161%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '379d891349aae89c97825b651ff5b79b3060b5bf' => 
    array (
      0 => 'includes\\templates\\mobilesite\\tpl\\tpl_index_product_gallery.html',
      1 => 1575421067,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '127545e9900fa707eb5-93180161',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'body_header_title' => 0,
    'view_only_sale_url' => 0,
    'related_str' => 0,
    'result_count' => 0,
    'product_info_list' => 0,
    'product_info' => 0,
    'split_page_link_info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e9900fa8a5b66_02761432',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e9900fa8a5b66_02761432')) {function content_5e9900fa8a5b66_02761432($_smarty_tpl) {?><script type="text/javascript">

$(function(){	
	$('.products_list li img').each(function(){
		var imgwidth = $('.products_list li img').width();
		$(this).css("height", imgwidth)
	});			
	$(window).resize(function(){
		$('.products_list li img').each(function(){
			var imgwidth = $(this).width();
			$(this).css("height", imgwidth)
		});		
	});	
});

</script>
<div class="mian_wrap products_list">
  <h3><?php echo $_smarty_tpl->tpl_vars['body_header_title']->value;?>
</h3>
  <?php if ($_GET['main_page']!="promotion"){?>
  <span class="products_filter_onsale"><a href="<?php echo $_smarty_tpl->tpl_vars['view_only_sale_url']->value;?>
"><?php echo @constant('TEXT_VIEW_ONLY_SALE_ITEMS');?>
 <span><img src="/includes/templates/mobilesite/images/view_only_sale_items_<?php if ($_GET['products_filter_onsale']){?>on<?php }else{ ?>off<?php }?>.png" /></span></a></span>
  <?php }?>

  <div class="clearfix"></div>
  <?php if ($_smarty_tpl->tpl_vars['related_str']->value!=''){?>
  <p class="search_related"><b>Related: </b><span class='jq_related_item'><?php echo $_smarty_tpl->tpl_vars['related_str']->value;?>
</span></p>
  <?php }?>
  
  <div class="filter_wap">
	<div class="filter"><a href="javascript:void(0);" id="btnChangeSortBy"><span><?php echo @constant('TEXT_SORT_BY');?>
</span> <ins class="icon_arrow_up"></ins></a></div>
	<?php if ($_GET['main_page']!="products_common_list"&&$_GET['aId']!="1"){?>
	<div class="filter"><a href="javascript:void(0);" id="btnChangeFilterBy"><span><?php echo @constant('TEXT_FILTER_BY');?>
</span> <ins class="icon_arrow_up"></ins></a></div>
	<?php }?>
	<span class="products_total">( <?php echo $_smarty_tpl->tpl_vars['result_count']->value;?>
 <?php echo @constant('TEXT_RESULTS');?>
 )</span> 
  </div>
  
  <div class="clearfix"></div>
   <ul>
   		<?php if ($_smarty_tpl->tpl_vars['product_info_list']->value&&is_array($_smarty_tpl->tpl_vars['product_info_list']->value)){?>
	   		<?php  $_smarty_tpl->tpl_vars['product_info'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product_info']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product_info_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product_info']->key => $_smarty_tpl->tpl_vars['product_info']->value){
$_smarty_tpl->tpl_vars['product_info']->_loop = true;
?>
	       <li>
	       	<?php if ($_smarty_tpl->tpl_vars['product_info']->value['products_status']!=0){?><a href="<?php echo $_smarty_tpl->tpl_vars['product_info']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product_info']->value['products_name'];?>
"><?php }?> 
	       		<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/310.gif" data-size="310" data-lazyload="<?php echo $_smarty_tpl->tpl_vars['product_info']->value['main_image_src'];?>
" alt = "<?php echo $_smarty_tpl->tpl_vars['product_info']->value['products_name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product_info']->value['products_name'];?>
" >
	       		<?php if ($_smarty_tpl->tpl_vars['product_info']->value['discount_amount']&&$_smarty_tpl->tpl_vars['product_info']->value['discount_amount']>0){?>
	       		<?php if ($_SESSION['languages_id']==1){?>
				<div class="floatprice"><span><?php echo $_smarty_tpl->tpl_vars['product_info']->value['discount_amount'];?>
% <br /> <?php echo @constant('TEXT_OFF');?>
</span></div>
				<?php }else{ ?>
				<div class="floatprice"><span>-<?php echo $_smarty_tpl->tpl_vars['product_info']->value['discount_amount'];?>
%</span></div>
				<?php }?><?php }?>
	       		<p class="pro_name"><?php echo $_smarty_tpl->tpl_vars['product_info']->value['show_name'];?>
</p>
	       	<?php if ($_smarty_tpl->tpl_vars['product_info']->value['products_status']!=0){?></a><?php }?> 
	        <div class="pro_price">
	        	<p class="lf"><?php echo @constant('TEXT_PRICE_LOWEST');?>
 :</p>
	        	<p class="rt">
	        		<?php echo $_smarty_tpl->tpl_vars['product_info']->value['price_html'];?>

	        	</p>
	        </div>
	        <div class="clearfix"></div>
	        <div class="button">
	        	<?php if ($_smarty_tpl->tpl_vars['product_info']->value['products_status']==1){?> 
	        	<a class="btn_orange btn_with150 btnProductListBuy" id="btnProductListBuy_<?php echo $_smarty_tpl->tpl_vars['product_info']->value['products_id'];?>
" href="javascript:void(0);" data-id="<?php echo $_smarty_tpl->tpl_vars['product_info']->value['products_id'];?>
" data-oldqty="1"><ins class="btn_cart"></ins></a>
				<a class="btn_wishlist btn_rt btnProductWishlist" href="javascript:void(0)" id="btnProductWishlist_<?php echo $_smarty_tpl->tpl_vars['product_info']->value['products_id'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['product_info']->value['products_id'];?>
"></a>
	        	<?php }else{ ?>
	        	<a class="btn_grey btn_with150" href="javascript:void(0);" data-id="<?php echo $_smarty_tpl->tpl_vars['product_info']->value['products_id'];?>
" data-oldqty="1"><?php echo @constant('TEXT_REMOVED');?>
</a>
	        	<?php }?>
	        </div> 
			<p class="stock">
	            <?php if ($_smarty_tpl->tpl_vars['product_info']->value['products_limit_stock']==1&&$_smarty_tpl->tpl_vars['product_info']->value['products_quantity']>0){?>
	            <?php echo $_smarty_tpl->tpl_vars['product_info']->value['products_quantity'];?>
 <?php echo @constant('TEXT_STOCK_REMAINING');?>
 
	            <?php }else{ ?>
	            &nbsp;
	            <?php }?>
	        </p>
	        </li>
	        <?php } ?>
        <?php }?>
         <div class="clearfix"></div>
    </ul>
    <div class="page">
    	<?php echo $_smarty_tpl->tpl_vars['split_page_link_info']->value;?>

    </div>
    <div class="clearfix"></div> 
</div>
<?php }} ?>