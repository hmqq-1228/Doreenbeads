<?php /* Smarty version Smarty-3.1.13, created on 2020-04-16 15:05:59
         compiled from "includes\templates\checkout\tpl_recently_viewed_products.html" */ ?>
<?php /*%%SmartyHeaderCode:42915e68ba52b6ca50-04730026%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '358e4749f0246b388d31fe2221e4b5d5fc4ef7d6' => 
    array (
      0 => 'includes\\templates\\checkout\\tpl_recently_viewed_products.html',
      1 => 1587010071,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '42915e68ba52b6ca50-04730026',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e68ba52dabc25_51427638',
  'variables' => 
  array (
    'r_products' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e68ba52dabc25_51427638')) {function content_5e68ba52dabc25_51427638($_smarty_tpl) {?><?php if (count($_smarty_tpl->tpl_vars['r_products']->value)>0){?>
<!-- Recently Viewed -->
<div class="caption_recent">
	<h3><?php echo @constant('TEXT_RECENTLY_VIEWED');?>
</h3>
</div>
<div class="pic_list">
	<ul>
		<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['r_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
		<li <?php if ($_smarty_tpl->tpl_vars['value']->value['lang']==3){?>style="width:151px;"<?php }elseif($_smarty_tpl->tpl_vars['value']->value['lang']==2||$_smarty_tpl->tpl_vars['value']->value['lang']==4){?>style="width:145px;"<?php }?>>
			<div class="galleryimg">
				<?php if ($_smarty_tpl->tpl_vars['value']->value['discount']>0){?>
            	<div class="discountbg"><?php if (($_SESSION['languages_id']=='2'||$_SESSION['languages_id']=='3'||$_SESSION['languages_id']=='4')){?>-<?php echo $_smarty_tpl->tpl_vars['value']->value['discount'];?>
%<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['value']->value['discount'];?>
%<br>off<?php }?><br/></div>
				<?php }?>
                <p class="galleryimgshow"><a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_name_all'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['product_image'];?>
</a></p>
            </div>

            <p class="ptext"><a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_name_all'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['product_name'];?>
</a></p>
            <p class="partprice"><?php echo $_smarty_tpl->tpl_vars['value']->value['display_price'];?>
</p>

            <div class="detailinput">
            <?php if ($_smarty_tpl->tpl_vars['value']->value['btn_class']=='cartbuy rp_btn'){?>
            	<input name="rp_qty" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" class='rp_qty_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
' id='product_listing_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
' value="<?php if ($_smarty_tpl->tpl_vars['value']->value['product_cart_qty']<=0){?>1<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['value']->value['product_cart_qty'];?>
<?php }?>" onpaste="return false;" />
            	<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_cart_qty'];?>
" class='rp_oqty_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
' />
            	<a href="javascript:void(0);" class="<?php echo $_smarty_tpl->tpl_vars['value']->value['btn_class'];?>
" id="rp_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
"></a>
            	<a href="javascript:void(0);" class="addcollect" id="wishlist_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
" onclick="beforeAddtowishlist('<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
');"></a>
            <?php }elseif($_smarty_tpl->tpl_vars['value']->value['btn_class']=='icon_backorder'){?>
				<input name="rp_qty" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" class='rp_qty_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
' id='product_listing_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
' value="<?php if ($_smarty_tpl->tpl_vars['value']->value['product_cart_qty']<=0){?>1<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['value']->value['product_cart_qty'];?>
<?php }?>" onpaste="return false;" />
            	<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['product_cart_qty'];?>
" class='rp_oqty_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
' />
            	<a href="javascript:void(0);" class="cartbuy rp_btn" id="rp_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
"></a>
            	<a href="javascript:void(0);" class="addcollect" id="wishlist_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
" onclick="beforeAddtowishlist('<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
');"></a>
				<div class="clearfix"></div><div style="color:#999">
		             <?php if ($_smarty_tpl->tpl_vars['value']->value['products_stocking_days']>7){?>
		                <p class="pro_time"><?php echo @constant('TEXT_AVAILABLE_IN715');?>
</p>
		             <?php }else{ ?>
		                <p class="pro_time"><?php echo @constant('TEXT_AVAILABLE_IN57');?>
</p>
		             <?php }?>
                </div>
			
			<?php }else{ ?>
				<div class="detailinput protips">
            		<p>
            			<input type="hidden" id="MDO_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
" value="0">
            			<input type="hidden" id="incart_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
" value="0">
            			<span class="soldout_text">
            				<a rel="nofollow" href="javascript:void(0);" id="restock_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
" onclick="beforeRestockNotification(<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
); return false;">
            					<?php echo @constant('TEXT_RESTOCK');?>
&nbsp;<?php echo @constant('TEXT_NOTIFICATION');?>

           					</a>
        				</span>
        				<a rel="nofollow" class="<?php echo $_smarty_tpl->tpl_vars['value']->value['btn_class'];?>
" id="submitp_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
" style="color:#000;text-deracotion:none;" href="javascript:void(0);">
        					<?php echo @constant('TEXT_SOLD_OUT');?>

       					</a>
       					<a rel="nofollow" class="text addcollect" title="Add to Wishlist" id="wishlist_<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
" onclick="beforeAddtowishlist(<?php echo $_smarty_tpl->tpl_vars['value']->value['product_id'];?>
,0); return false;" href="javascript:void(0);">
       					</a>
       				</p>
     				<div class="successtips_add successtips_add1">
      					<span class="bot"></span>
      					<span class="top"></span>
      					<ins class="sh">Please enter the right quantity!</ins>
    				</div>
    				<div class="successtips_add successtips_add2">
    					<span class="bot"></span>
    					<span class="top"></span>
    					<ins class="sh"></ins>
   					</div>
   					<div class="successtips_add successtips_add3">
   						<span class="bot"></span>
   						<span class="top"></span>
   						<ins class="sh"></ins>
  					</div>
				</div>
            <?php }?>
       	  	</div>

		</li>
		<?php } ?>
	</ul>
	<div class="clearBoth"></div>
</div>
<?php }?><?php }} ?>