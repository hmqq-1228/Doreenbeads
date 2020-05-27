<?php
/**
 * Module Template
 *
 * Loaded automatically by index.php?main_page=products_all.<br />
 * Displays listing of All Products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_products_all_listing.php 6096 2007-04-01 00:43:21Z ajeh $
 */
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="allproductListing-heading">Product Image</td>
    <td class="allproductListing-heading">Item Name</td>
    <td class="allproductListing-heading">Price</td>
  </tr>
<?php
  $group_id = zen_get_configuration_key_value('PRODUCT_ALL_LIST_GROUP_ID');

  if ($products_all_split->number_of_rows > 0) {
    $products_all = $db->Execute($products_all_split->sql_query);
    $row_counter = 0;
    while (!$products_all->EOF) {
      $row_counter++;
      
      $page_name = "product_listing";
      $page_type = 4;
       
      if($_SESSION['cart']->in_cart($products_all->fields['products_id'])){		//if item already in cart
      	$procuct_qty = $_SESSION['cart']->get_quantity($products_all->fields['products_id']);
      	$bool_in_cart = 1;
      }else {
      	$procuct_qty = 0;
      	$bool_in_cart = 0;
      }

      if (PRODUCT_ALL_LIST_IMAGE != '0') {
        if ($products_all->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) {
          $display_products_image = str_repeat('', substr(PRODUCT_ALL_LIST_IMAGE, 3, 1));
        } else {
          $display_products_image = '<a onmouseover="showlargeimage(\''.HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_all->fields['products_image'], 500, 500).'\')" onmouseout="hidetrail();" href="' . zen_href_link('product_info', 'products_id=' . $products_all->fields['products_id']) . '"><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_all->fields['products_image'], 130, 130) . '" width="110" height="110"></a>' . str_repeat('', substr(PRODUCT_ALL_LIST_IMAGE, 3, 1));
        }
      } else {
        $display_products_image = '';
      }
      if (PRODUCT_ALL_LIST_NAME != '0') {
        $display_products_name = '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($products_all->fields['master_categories_id'] , 'cPath') . '&products_id=' . $products_all->fields['products_id']) . '"><strong>' . $products_all->fields['products_name'] . '</strong></a>' . str_repeat('', substr(PRODUCT_ALL_LIST_NAME, 3, 1));
      } else {
        $display_products_name = '';
      }

      if (PRODUCT_ALL_LIST_MODEL != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'model')) {
		
		$display_products_model = 'Part No.: ' . $products_all->fields['products_model'] . str_repeat('', substr(PRODUCT_ALL_LIST_NAME, 3, 1));
		
      } else {
        $display_products_model = '';
      }

      if (PRODUCT_ALL_LIST_WEIGHT != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'weight')) {
        $display_products_weight = $products_all->fields['products_weight'] . TEXT_SHIPPING_WEIGHT . str_repeat('', substr(PRODUCT_ALL_LIST_WEIGHT, 3, 1));
      } else {
        $display_products_weight = '';
      }

      if (PRODUCT_ALL_LIST_QUANTITY != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'quantity')) {
        if ($products_all->fields['products_quantity'] <= 0) {
          $display_products_quantity = TEXT_OUT_OF_STOCK . str_repeat('', substr(PRODUCT_ALL_LIST_QUANTITY, 3, 1));
        } else {
          $display_products_quantity = TEXT_PRODUCTS_QUANTITY . $products_all->fields['products_quantity'] . str_repeat('', substr(PRODUCT_ALL_LIST_QUANTITY, 3, 1));
        }
      } else {
        $display_products_quantity = '';
      }

      if (PRODUCT_ALL_LIST_DATE_ADDED != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'date_added')) {
        $display_products_date_added = TEXT_DATE_ADDED . ' ' . zen_date_long($products_all->fields['products_date_added']) . str_repeat('', substr(PRODUCT_ALL_LIST_DATE_ADDED, 3, 1));
      } else {
        $display_products_date_added = '';
      }

      if (PRODUCT_ALL_LIST_MANUFACTURER != '0' and zen_get_show_product_switch($products_all->fields['products_id'], 'manufacturer')) {
        $display_products_manufacturers_name = ($products_all->fields['manufacturers_name'] != '' ? TEXT_MANUFACTURER . ' ' . $products_all->fields['manufacturers_name'] . str_repeat('', substr(PRODUCT_ALL_LIST_MANUFACTURER, 3, 1)) : '');
      } else {
        $display_products_manufacturers_name = '';
      }

      if ((PRODUCT_ALL_LIST_PRICE != '0' and zen_get_products_allow_add_to_cart($products_all->fields['products_id']) == 'Y') and zen_check_show_prices() == true) {
	  	//jessa 2010-01-29 add the discount price show
		if ($products_all->fields['products_discount_type'] == '0'){
		
			$products_price = '<span style="display:block; text-align:left;font-weight:bold;color:#9F1C00;">Price: ' . zen_get_products_display_price($products_all->fields['products_id']) . '</span>';
			
		}else{
		
			$products_price = zen_display_products_quantity_discount($products_all->fields['products_id']);
			
		}
        //$products_price = zen_get_products_display_price($products_all->fields['products_id']);
		
        $display_products_price = $products_price . str_repeat('', substr(PRODUCT_ALL_LIST_PRICE, 3, 1)) . (zen_get_show_product_switch($products_all->fields['products_id'], 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') ? (zen_get_product_is_always_free_shipping($products_all->fields['products_id']) ? TEXT_PRODUCT_FREE_SHIPPING_ICON . '' : '') : '');
		
      } else {
	  
        $display_products_price = '';
		
      }
	  //eof jessa 2010-01-29
	  
// more info in place of buy now
      if (PRODUCT_ALL_BUY_NOW != '0' and zen_get_products_allow_add_to_cart($products_all->fields['products_id']) == 'Y') {
        if (zen_has_product_attributes($products_all->fields['products_id'])) {
          $link = '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($products_all->fields['master_categories_id'] , 'cPath') . '&products_id=' . $products_all->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        } else {
//          $link= '<a href="' . zen_href_link(FILENAME_PRODUCTS_ALL, zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_all->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT) . '</a>';
          if (PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART > 0 && $products_all->fields['products_qty_box_status'] != 0) {
//            $how_many++;
            
            $link = "<input type=\"text\" id=\"" .$page_name.'_'. $products_all->fields['products_id'] . "\" name=\"products_id[" . $products_all->fields['products_id'] . "]\" value=\"".($bool_in_cart ? $procuct_qty : $products_all->fields['products_quantity_order_min'])."\" size=\"4\" />";
            $link .= '<input type="hidden" id="MDO_'.$products_all->fields['products_id'].'" value="'.$bool_in_cart.'">';
            $link .= '<input type="hidden" id="incart_'.$products_all->fields['products_id'].'" value="'.$procuct_qty.'">';
            
          } else {
            $link = '<a href="' . zen_href_link(FILENAME_PRODUCTS_ALL, zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_all->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT) . '</a>&nbsp;';
          }
        }

        $the_button = $link;
        $products_link = '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($products_all->fields['master_categories_id'] , 'cPath') . '&products_id=' . $products_all->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $display_products_button = zen_get_buy_now_button($products_all->fields['products_id'], $the_button, $products_link) . zen_get_products_quantity_min_units_display($products_all->fields['products_id']) . str_repeat('', substr(PRODUCT_ALL_BUY_NOW, 3, 1));
      } else {
        $link = '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($products_all->fields['master_categories_id'] , 'cPath') . '&products_id=' . $products_all->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $the_button = $link;
        $products_link = '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($products_all->fields['master_categories_id'] , 'cPath') . '&products_id=' . $products_all->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $display_products_button = zen_get_buy_now_button($products_all->fields['products_id'], $the_button, $products_link) . zen_get_products_quantity_min_units_display($products_all->fields['products_id']) . str_repeat('', substr(PRODUCT_ALL_BUY_NOW, 3, 1));
      }

      if (PRODUCT_ALL_LIST_DESCRIPTION > '0') {
        $disp_text = zen_get_products_description($products_all->fields['products_id']);
        $disp_text = zen_clean_html($disp_text);

        $display_products_description = stripslashes(zen_trunc_string($disp_text, PRODUCT_ALL_LIST_DESCRIPTION, '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($products_all->fields['master_categories_id'] , 'cPath') . '&products_id=' . $products_all->fields['products_id']) . '"> ' . MORE_INFO_TEXT . '</a>'));
      } else {
        $display_products_description = '';
      }

?>
  <tr>
    <td width="20%" class="allproductListing-data"><?php echo $display_products_image; ?><br />
	<?php echo $display_products_model; ?></td>
    <td width="50%" class="allproductListing-data"><span style="display:block; text-align:left;"><?php echo $display_products_name; ?></span>
	<?php echo $display_products_price; ?></td>
	<td width="30%" class="allproductListing-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <?php
		  	if ($display_products_weight != ''){
		  ?>
		  <tr>
			<td width="40%" height="30" align="right">Weight:</td>
			<td width="60%" height="30" align="left">&nbsp;
				<?php echo $display_products_weight; ?>			</td>
		  </tr>
		  <?php
		  	}
		  ?>
		  <?php
		  	if ($products_all->fields['products_quantity'] <= 0){
		  ?>
		    <tr>
				<td colspan="2">
				<?php 
					echo $display_products_button; 
					//jessa 2010-09-06 add wishlist button
					echo '<div style="padding-right:10px;">';
					echo '<script type="text/javascript">document.write(\'<div class="addwishlist">' . zen_image_submit('button_in_wishlist_green.gif', 'wishlist', 'class="addwishlistbutton" onclick="return changeAction(' . $products_all->fields['products_id'] . ');"') . '</div>\')</script>' . "\n";
					echo '<noscript><div class="addwishlist" style="margin-right:-5px;"><a href="' . zen_href_link('wishlist', 'action=addwishlist&pid=' . $products_all->fields['products_id']) . '">' . zen_image_button('button_in_wishlist_green.gif', 'addwishlist') . '</a></div></noscript>';
					echo '</div>';
					//eof jessa 2010-09-06 
				?>
				</td>
			</tr>
		  <?php
			}
			else{
		  ?>
		  	<tr>
				<td width="40%" height="30" align="right">Add:</td>
				<td width="60%" height="30" align="left"><?php echo zen_get_buy_now_button($products_all->fields['products_id'], $the_button, $products_link); ?></td>
			</tr>
		  <?php
		  	}
		  ?>
		  
		  <?php if ($products_all->fields['products_quantity'] > 0 && zen_get_products_quantity_min_units_display($products_all->fields['products_id']) != ''){ ?>
			<tr>
				<td width="40%" height="30" align="right">&nbsp;</td>
				<td width="60%" height="30" align="left">&nbsp;
					<?php echo zen_get_products_quantity_min_units_display($products_all->fields['products_id']); ?>							
				</td>
			</tr>
			<?php }?>
		  <tr>
			<td height="30" colspan="2" align="center">
			<?php 
				if ($products_all->fields['products_quantity'] > 0){
					echo zen_image_submit('button_in_cart_green.gif', BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submitp_' . $products_all->fields['products_id'] . '" onclick="Addtocart('.$products_all->fields['products_id'].','.$page_type.'); return false;" name="submitp_' .  $products_all->fields['products_id'] . '"');					
					//jessa 2010-09-06 add wishlist button
					echo '<div style="padding-right:10px;">';
					echo '<script type="text/javascript">document.write(\'<div class="addwishlist">' . zen_image_submit('button_in_wishlist_green.gif', 'wishlist', 'class="addwishlistbutton" onclick="return changeAction(' . $products_all->fields['products_id'] . ');"') . '</div>\')</script>' . "\n";
					echo '<noscript><div class="addwishlist" style="margin-right:-5px;"><a href="' . zen_href_link('wishlist', 'action=addwishlist&pid=' . $products_all->fields['products_id']) . '">' . zen_image_button('button_in_wishlist_green.gif', 'addwishlist') . '</a></div></noscript>';
					echo '</div>';
					//eof jessa 2010-09-06
				}
			?></td>
		  </tr>
	  </table>
	</td>
  </tr>
  <?php
      $products_all->MoveNext();
    }
  }else {
?>
          <tr>
            <td class="main" colspan="2"><?php echo TEXT_NO_ALL_PRODUCTS; ?></td>
          </tr>
<?php
  }
?>
</table>
