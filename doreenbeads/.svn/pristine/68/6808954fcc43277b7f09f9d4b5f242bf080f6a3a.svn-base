
<script>window.lang_wdate='en';</script>
<script type="text/javascript" src="includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
function removeWishlist(p_id){
	if(confirm("<?php echo TEXT_CART_ARE_U_SURE_DELETE;?>")){
		$j.post('./ajax_login.php', {action:"removewishlist", pid:""+p_id+""}, function(data){
			window.location.reload();
		});
	}
}

$j(function(){
	if("<?php echo $all_select_in_cart?>"){
		if(confirm('<?php echo TEXT_ALL_PRODUCTS_IN_CART;?>')){
			window.location.href = 'index.php?main_page=shopping_cart';
		}
	}
	$j('.wish_checkbox').click(function(){
		var select = $j(this).attr('checked') ? true : false;
		$j('.wish_checkbox_list').attr('checked', select);
	});
	$j('.form_wish_products .commonbtn').click(function(){
		if($j('.wish_checkbox_list:checked').length <= 0){
			alert('<?php echo TEXT_PLEASE_SELECT_PRODUCT;?>');
		}else{
			$j('input[name="action"]').val('add');
			$j('form[name="wish_products"]').submit();
		}
	});
	$j('.form_wish_products .commonbtn_grey').click(function(){
		if($j('.wish_checkbox_list:checked').length <= 0){
			alert('<?php echo TEXT_PLEASE_SELECT_PRODUCT;?>');
		}else{
			if(confirm('Sure to delete all selected?')){
				$j('input[name="action"]').val('delete');
				$j('form[name="wish_products"]').submit();
			}
		}
	});
	setTimeout(function(){
		$j('.batchtips_inner').hide();
	}, 3000);

	
	$j(".wishlist_question").mouseover(function(){
		var products_id = $j(this).attr("products_id");
		$j("#wishlist_price_area_"+products_id).show();
	});
	$j(".wishlist_question").mouseleave(function(){
		var products_id = $j(this).attr("products_id");
		$j("#wishlist_price_area_"+products_id).hide();
	});
	
});
</script>

<div class="mycashaccount">
	<p class="mycashtit"><strong><?php echo HEADING_TITLE . ($wishlist_products_count > 0 ? ' <font color="#999">(' . $wishlist_products_count . ')</font>' : '');?></strong></p>
	
	<form class="filter_form" method="get" name="filterby" action="<?php echo zen_href_link('wishlist')?>" style="display: inline-block; width:100%;">
			<input type="hidden" name="main_page" value="wishlist" />
			<input type="hidden" name="is_search" value="true" />
			<table style="width:100%;">
				<tr>
					<td style="text-align:right;"><strong><?php echo KEYWORD_FORMAT_STRING;?>:</strong></td>
					<td>
						<input type="text" name="wishlist_keyword" value="<?php echo $wishlist_keyword;?>" />
					</td>
					<td style="text-align:right;"><strong><?php echo TEXT_DATE_ADDED;?>:</strong></td>
					<td>
						<input type="text" name="wishlist_startdate" value="<?php echo $wishlist_startdate;?>" style="width:80px;" onclick="WdatePicker({dateFmt:'MM-dd-yyyy',lang:'<?php echo $_SESSION['languages_code'];?>'});" /> <?php echo TEXT_TO;?> <input type="text" name="wishlist_enddate" value="<?php echo $wishlist_enddate;?>" style="width:80px;" onclick="WdatePicker({dateFmt:'MM-dd-yyyy',lang:'<?php echo $_SESSION['languages_code'];?>'});" />
					</td>
				</tr>
				<tr>
					<td style="text-align:right;"><strong><?php echo TEXT_FILTER_BY;?>:</strong></td>
					<td>
						<select name="categories">
							<option value=""><?php echo TEXT_ALL_CATEGORIES;?></option>
							<?php for ($i = 0; $i < sizeof($wishlist_categories_info_array); $i++){ 
								$selected = "";
								if ($_GET['categories'] == $wishlist_categories_info_array[$i]['categories_id']) {
									$selected= "selected=\"selected\"";
								}
							?>
							<option value="<?php echo $wishlist_categories_info_array[$i]['categories_id'];?>" <?php echo $selected;?>><?php echo $wishlist_categories_info_array[$i]['categories_name'];?></option>
							<?php }?>
						</select>
					</td>
					<td></td>
					<td><input class="commonbtn" type="submit" value="<?php echo TEXT_FILTER;?>" /></td>
				</tr>
			</table>
	</form>

	<form method="post" name="wish_products" class="form_wish_products" action="<?php echo zen_href_link('wishlist')?>">
	<input type="hidden" name="action">
	<div class="clearBoth"></div>
	<div class="batchcont">	
		<div class="batchcont_l">
			<div class="batchtips">
				<div class="batchtips_inner" style="display:<?php echo $add_cart_success ? 'block' : 'none';?>;">
					<span class="bot"></span>
					<span class="top"></span>
					<?php echo TEXT_ITEM_ADDED_SUCCESSFULLY_TO_CART;?><br/>
					<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART);?>"><?php echo TEXT_VIEW_SHOPPING_CART;?></a>
				</div>
				<a href="javascript:void(0);" class="commonbtn"><?php echo TEXT_BATCH_ADD_TO_CART;?></a>
			</div>
			<a href="javascript:void(0);" class="commonbtn_grey"><?php echo TEXT_BATCH_REMOVE;?></a>
		</div>		
		<div class="propagelist"><?php echo $wishlist_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
		<div class="clearBoth"></div>
	</div>
	<table class="wishlisttab list product_list" width="100%">
		<tr><th width="30"><input type="checkbox" class="wish_checkbox"/></th><th width="90">&nbsp;</th><th width="200"><?php echo TEXT_ITEM;?></th><th width="115"><?php echo TEXT_PRICE;?></th><th width="150"><?php echo TEXT_DATE_ADDED;?></th><th width="100">&nbsp;</th></tr>
<?php
if ($wishlist_split->number_of_rows > 0){
	$greybg = 'class="greybg"';
	for ($i = 0; $i < sizeof($wishlist_array); $i++){
		$product_id = $wishlist_array[$i]['product_id'];
		$page_name = "product_listing";
		$page_type = 4;
		if($_SESSION['cart']->in_cart($product_id)){
			$procuct_qty = $_SESSION['cart']->get_quantity($product_id);
			$bool_in_cart = 1;
		}else {
			$procuct_qty = 0;
			$bool_in_cart = 0;
		}

		$link = zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id);
		$discount_amount = zen_show_discount_amount($product_id);

		if($greybg != '') $greybg = '';
		else $greybg = 'class="greybg"';
?>
		<tr <?php echo $greybg; ?>>
			<td align="center"><input type="checkbox"<?php echo (isset($products[$wishlist_array[$i]['product_id']]) ? 'checked="checked"' : '');?> name="wish_checkbox[<?php echo $wishlist_array[$i]['product_id'];?>]" class="wish_checkbox_list" /></td>
			<td align="center">
				<div class="maximg notLoadNow"><s></s><span></span><img /></div>
				<div class="wishlist_pro">
					<?php if($discount_amount!='' && $discount_amount>0) echo draw_discount_img($discount_amount,'span'); ?>
					<a href="<?php echo $link; ?>" target="_blank" class="wishlist_img proimg"><img src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="<?php echo HTTP_IMG_SERVER.'bmz_cache/'.get_img_size($wishlist_array[$i]['product_image'], 130, 130); ?>" data-original="<?php echo HTTP_IMG_SERVER.'bmz_cache/'.get_img_size($wishlist_array[$i]['product_image'], 130, 130); ?>" width="80px" id="anchor<?php echo $product_id; ?>" alt="<?php echo $wishlist_array[$i]['product_name']; ?>" class="lazy lazy-img" /></a>
				</div>
			</td>
			<td>
				<p><a href="<?php echo $link; ?>" target="_blank"><?php echo $wishlist_array[$i]['product_name']; ?></a></p>
				<span class="partno"><?php echo TEXT_MODEL;?>: <?php echo $wishlist_array[$i]['product_model']; ?></span>
				<ins class="cartno cartno_<?php echo $product_id; ?>"><?php if($bool_in_cart) echo TEXT_QUANTITY_ALREADY_IN_CART . $procuct_qty; ?></ins>
			</td>
			<td align="center" style="position: relative;">
				<?php echo $wishlist_array[$i]['price_area']; ?>
				<?php if($wishlist_array[$i]['is_simple_price'] == false){
					echo '<a class="icon_question wishlist_question" href="javascript:void(0)" products_id="'. $product_id . '"></a>';
					echo '<div class="price_area" id="wishlist_price_area_' . $product_id . '">' . $wishlist_array[$i]['show_content'] . '</div>';
				 }?>
			</td>
			<td align="center"><?php echo $wishlist_array[$i]['date_added']; ?></td>
			<td class="addwishno">
<?php
	if ($wishlist_array[$i]['product_quantity'] > 0) {
		$cart_text = TEXT_CART_ADD_TO_CART;
	}else{
		$cart_text = TEXT_BACKORDER;
	}
	//if($wishlist_array[$i]['product_quantity'] > 0){
		echo '<div class="numtips successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';
		echo '<input class="wishinput addcart_qty_input" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" id="' . $page_name  .'_' . $product_id . '" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" orig_value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="MDO_' . $product_id . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $product_id . '" value="'.$procuct_qty.'" />';
		echo '<div class="addtips successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
		echo '<a class="addtocart2" href="javascript:void(0);" id="submitp_' . $product_id . '" name="submitp_' . $product_id . '" onclick="Addtocart_list('.$product_id.','.$page_type.',this); return false;">'. ($bool_in_cart ? TEXT_UPDATE : $cart_text) .'</a><br/>';
	/*}else{
		$lc_button = '<a class="addtocart2 restock_noti" id="restock_'.$product_id.'" onclick="beforeRestockNotification(' . $product_id . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a><br/>';
				
		
		$lc_button .= '<input type="hidden" id="MDO_' . $product_id . '" value="'.$bool_in_cart.'" />
							   <input type="hidden" id="incart_' . $product_id . '" value="'.$procuct_qty.'" /><br />';
		if($wishlist_array[$i]['is_sold_out'] == 1){
			$lc_button .= '<a rel="nofollow" class="icon_soldout" href="javascript:void(0);">' . TEXT_SOLD_OUT . '</a>';
		}else{
			$lc_button .= '<div class="tipsbox"><div class="addtips successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
			$lc_button .= '<a rel="nofollow" class="icon_backorder" id="submitp_' . $product_id . '" onclick="makeSureCart('.$product_id.','.$page_type.',\''.$page_name.'\',\''.get_backorder_info($product_id).'\')"  href="javascript:void(0);">' . TEXT_BACKORDER . '</a></div>';
		}
		echo $lc_button;
	}*/
	echo '<a href="javascript:void(0);" class="remove" onclick="removeWishlist('.$product_id.')">' . TEXT_REMOVE . '</a><br/>';
	if ($wishlist_array[$i]['product_quantity'] <= 0) {
		echo '<span style="color:#999;">'.($wishlist_array[$i]['products_stocking_days'] > 7 ? TEXT_AVAILABLE_IN715 : TEXT_AVAILABLE_IN57).'</span>';
	}
?>
			</td>
		</tr>
<?php
	}
?>
	</table>
	</form>
	<div style="float:left;"><?php echo $wishlist_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS);?></div>
	<div class="propagelist" style="float:right;"><?php echo $wishlist_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
	<div class="clearfix"></div>
	<div class="shopping_cart_products_error" <?php echo ($wishlist_products_down_note == '' ? 'style="display:none;"' : '');?>><?php echo $wishlist_products_down_note;?></div>
<?php
}else{
?>
		<tr><td colspan="5" align="center"><h3>
		<?php 
			if($is_search == "true") {
				echo TEXT_NO_WISHLIST_PRO_MATCHED;
			} else {
				echo TEXT_NO_PRODUCT_EXISTS;
			}
		?>
		</h3></td></tr>
	</table>
	<div class="shopping_cart_products_error" <?php echo ($wishlist_products_down_note == '' ? 'style="display:none;"' : '');?>><?php echo $wishlist_products_down_note;?></div>
<?php
}
?>
</div>
