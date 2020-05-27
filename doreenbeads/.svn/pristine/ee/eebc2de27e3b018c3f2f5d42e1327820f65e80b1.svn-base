<?php
/**
 * Module Template
 *
 * Loaded automatically by index.php?main_page=products_new.<br />
 * Displays listing of New Products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_products_new_listing.php 4629 2006-09-28 15:29:18Z ajeh $
 */

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="allproductListing-heading"><?php echo TEXT_PRODUCT_IMAGE; ?></td>
		<td class="allproductListing-heading"><?php echo TEXT_ITEM_NAMES; ?></td>
		<td class="allproductListing-heading"><?php echo TEXT_PRICE_WORDS; ?></td>
	</tr>
<?php
  $group_id = zen_get_configuration_key_value('PRODUCT_NEW_LIST_GROUP_ID');
  if ($products_new_split->number_of_rows > 0) {
    $products_new = $db->Execute($products_new_split->sql_query);
    while (!$products_new->EOF) {
    	// add by zale 2011-10-17    	
    	$page_name = "product_listing";
		$page_type = 4;
    	
    	if($_SESSION['cart']->in_cart($products_new->fields['products_id'])){		//if item already in cart
    		$procuct_qty = $_SESSION['cart']->get_quantity($products_new->fields['products_id']);
    		$bool_in_cart = 1;
    	}else {
    		$procuct_qty = 0;
    		$bool_in_cart = 0;
    	}
    	//eof   
      if (PRODUCT_NEW_LIST_IMAGE != '0') {
        if ($products_new->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) {
          $display_products_image = str_repeat('', substr(PRODUCT_NEW_LIST_IMAGE, 3, 1));
        } else {
          $display_products_image = '<a onmouseover="showlargeimage(\''.HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_new->fields['products_image'], 500, 500).'\')" onmouseout="hidetrail();" href="' . zen_href_link('product_info', 'products_id=' . $products_new->fields['products_id']) . '"><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_new->fields['products_image'], 130, 130) . '" width="110" height="110" class="lazy listingProductImage" id="anchor' . $products_new->fields['products_id'] . '"></a>' . str_repeat('', substr(PRODUCT_NEW_LIST_IMAGE, 3, 1));
        }
      } else {
        $display_products_image = '';
      }
      if (PRODUCT_NEW_LIST_NAME != '0') {
        $display_products_name = '<a href="' . zen_href_link('product_info', 'products_id=' . $products_new->fields['products_id']) . '"><strong>' . $products_new->fields['products_name'] . '</strong></a>' . str_repeat('', substr(PRODUCT_NEW_LIST_NAME, 3, 1));
      } else {
        $display_products_name = '';
      }
      if (PRODUCT_NEW_LIST_MODEL != '0' and zen_get_show_product_switch($products_new->fields['products_id'], 'model')) {
        $display_products_model = TEXT_PRODUCTS_MODEL . $products_new->fields['products_model'] . str_repeat('', substr(PRODUCT_NEW_LIST_MODEL, 3, 1));
      } else {
        $display_products_model = '';
      }
      if (PRODUCT_NEW_LIST_WEIGHT != '0' and zen_get_show_product_switch($products_new->fields['products_id'], 'weight')) {
        $display_products_weight = $products_new->fields['products_weight'] . TEXT_SHIPPING_WEIGHT . str_repeat('', substr(PRODUCT_NEW_LIST_WEIGHT, 3, 1));
      } else {
        $display_products_weight = '';
      }
      if (PRODUCT_NEW_LIST_QUANTITY != '0' and zen_get_show_product_switch($products_new->fields['products_id'], 'quantity')) {
        if ($products_new->fields['products_quantity'] <= 0) {
          $display_products_quantity = TEXT_OUT_OF_STOCK . str_repeat('', substr(PRODUCT_NEW_LIST_QUANTITY, 3, 1));
        } else {
          $display_products_quantity = TEXT_PRODUCTS_QUANTITY . $products_new->fields['products_quantity'] . str_repeat('', substr(PRODUCT_NEW_LIST_QUANTITY, 3, 1));
        }
      } else {
        $display_products_quantity = '';
      }
      if (PRODUCT_NEW_LIST_DATE_ADDED != '0' and zen_get_show_product_switch($products_new->fields['products_id'], 'date_added')) {
        $display_products_date_added = TEXT_DATE_ADDED . ' ' . zen_date_long($products_new->fields['products_date_added']) . str_repeat('', substr(PRODUCT_NEW_LIST_DATE_ADDED, 3, 1));
      } else {
        $display_products_date_added = '';
      }
      if (PRODUCT_NEW_LIST_MANUFACTURER != '0' and zen_get_show_product_switch($products_new->fields['products_id'], 'manufacturer')) {
        $display_products_manufacturers_name = ($products_new->fields['manufacturers_name'] != '' ? TEXT_MANUFACTURER . ' ' . $products_new->fields['manufacturers_name'] . str_repeat('', substr(PRODUCT_NEW_LIST_MANUFACTURER, 3, 1)) : '');
      } else {
        $display_products_manufacturers_name = '';
      }
      if ((PRODUCT_NEW_LIST_PRICE != '0' and zen_get_products_allow_add_to_cart($products_new->fields['products_id']) == 'Y') and zen_check_show_prices() == true) {
		if ($products_new->fields['products_discount_type'] == '0') {
			$products_price = zen_get_products_display_price($products_new->fields['products_id']);
		}
		else {
			$products_price = zen_display_products_quantity_discount($products_new->fields['products_id']);
		}
//        $display_products_price = TEXT_PRICE . ' ' . $products_price . str_repeat('', substr(PRODUCT_ALL_LIST_PRICE, 3, 1)) . (zen_get_show_product_switch($products_new->fields['products_id'], 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') ? (zen_get_product_is_always_free_shipping($products_new->fields['products_id']) ? TEXT_PRODUCT_FREE_SHIPPING_ICON . '<br />' : '') : '');
        $display_products_price = $products_price . str_repeat('', substr(PRODUCT_NEW_LIST_PRICE, 3, 1)) . (zen_get_show_product_switch($products_new->fields['products_id'], 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') ? (zen_get_product_is_always_free_shipping($products_new->fields['products_id']) ? TEXT_PRODUCT_FREE_SHIPPING_ICON . '<br />' : '') : '');
      } else {
        $display_products_price = '';
      }
// more info in place of buy now
      if (PRODUCT_NEW_BUY_NOW != '0' and zen_get_products_allow_add_to_cart($products_new->fields['products_id']) == 'Y') {
        if (zen_has_product_attributes($products_new->fields['products_id'])) {
          $link = '<a href="' . zen_href_link('product_info', 'products_id=' . $products_new->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        } else {
//          $link= '<a href="' . zen_href_link(FILENAME_PRODUCTS_NEW, zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_new->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT) . '</a>';
          if (PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART > 0 && $products_new->fields['products_qty_box_status'] != 0) {
//            $how_many++;
			//$link = TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART . "<input type=\"text\" name=\"products_id[" . $products_new->fields['products_id'] . "]\" value=\"0\" size=\"4\" />";
            $link = "<input type=\"text\" id=\"" .$page_name.'_'. $products_new->fields['products_id'] . "\" name=\"products_id[" . $products_new->fields['products_id'] . "]\" value=\"".($bool_in_cart ? $procuct_qty : $products_new->fields['products_quantity_order_min'])."\" size=\"4\" />";
            $link .= '<input type="hidden" id="MDO_'.$products_new->fields['products_id'].'" value="'.$bool_in_cart.'">';
            $link .= '<input type="hidden" id="incart_'.$products_new->fields['products_id'].'" value="'.$procuct_qty.'">';
            //$link .= zen_image_submit('button_in_cart_green.gif', BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submitp_' . $products_new->fields['products_id'] . '" name="submitp_' .  $products_new->fields['products_id'] . '"');
          } else {
            $link = '<a href="' . zen_href_link(FILENAME_PRODUCTS_NEW, zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_new->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT) . '</a>&nbsp;';
          }
        }

        $the_button = $link;
        $products_link = '<a href="' . zen_href_link('product_info', 'products_id=' . $products_new->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $display_products_button = zen_get_buy_now_button($products_new->fields['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($products_new->fields['products_id']) . str_repeat('', substr(PRODUCT_NEW_BUY_NOW, 3, 1));
      } else {
        $link = '<a href="' . zen_href_link('product_info', 'products_id=' . $products_new->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $the_button = $link;
        $products_link = '<a href="' . zen_href_link('product_info', 'products_id=' . $products_new->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $display_products_button = zen_get_buy_now_button($products_new->fields['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($products_new->fields['products_id']) . str_repeat('', substr(PRODUCT_NEW_BUY_NOW, 3, 1));
      }
      if (PRODUCT_NEW_LIST_DESCRIPTION != '0') {
        $disp_text = zen_get_products_description($products_new->fields['products_id']);
        $disp_text = zen_clean_html($disp_text);

        $display_products_description = stripslashes(zen_trunc_string($disp_text, 150, '<a href="' . zen_href_link('product_info', 'products_id=' . $products_new->fields['products_id']) . '"> ' . MORE_INFO_TEXT . '</a>'));
      } else {
        $display_products_description = '';
      }
?>
          <tr>
            <td width="30%" class="allproductListing-data">
              <?php
                $disp_sort_order = $db->Execute("select configuration_key, configuration_value from " . TABLE_CONFIGURATION . " where configuration_group_id='" . $group_id . "' and (configuration_value >= 1000 and configuration_value <= 1999) order by LPAD(configuration_value,11,0)");
                while (!$disp_sort_order->EOF) {
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_IMAGE') {
                    echo $display_products_image;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_QUANTITY') {
                    echo $display_products_quantity;
                  }
                  
//                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_BUY_NOW') {
//                    echo $display_products_button;
//                  }
               
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_NAME') {
                    echo $display_products_name;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_MODEL') {
                    echo $display_products_model;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_MANUFACTURER') {
                    echo $display_products_manufacturers_name;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_PRICE') {
                    echo $display_products_price;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_WEIGHT') {
                    echo $display_products_weight;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_DATE_ADDED') {
                    echo $display_products_date_added;
                  }
                  $disp_sort_order->MoveNext();
                }
               // echo '<br>' . $display_products_model;
               echo '<br>';
              ?>
            </td>
            <td width="40%" align="left" class="allproductListing-data"><span style="display:block; text-align:left;">
              <?php
                $disp_sort_order = $db->Execute("select configuration_key, configuration_value from " . TABLE_CONFIGURATION . " where configuration_group_id='" . $group_id . "' and (configuration_value >= 2000 and configuration_value <= 2999) order by LPAD(configuration_value,11,0)");
                while (!$disp_sort_order->EOF) {
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_IMAGE') {
                    echo $display_products_image;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_QUANTITY') {
                    echo $display_products_quantity;
                  }
//                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_BUY_NOW') {
//                    echo $display_products_button;
//                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_NAME') {
                    echo $display_products_name . '<br />';
                  }
//                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_MODEL') {
//                    echo $display_products_model;
//                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_MANUFACTURER') {
                    echo $display_products_manufacturers_name;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_PRICE') {
                    echo $display_products_price . '<br />';
                  }
//                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_WEIGHT') {
//                    echo $display_products_weight;
//                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_NEW_LIST_DATE_ADDED') {
                    //echo $display_products_date_added;
                  }
                  $disp_sort_order->MoveNext();
                }
                echo  $display_products_model;
                echo '<br>' .$display_products_date_added;
              ?>
              </span>
            </td>
            <td width="30%" class="allproductListing-data">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            		<?php if ($display_products_weight != ''){?>
            			<tr>
							<td width="40%" height="30" align="right"><?php echo TEXT_WEIGHT_WORDS;?></td>
							<td width="60%" height="30" align="left">&nbsp;<?php echo $display_products_weight; ?></td>
						</tr>
					<?php } ?>
					<?php if ($products_new->fields['products_quantity'] <= 0){ ?>
						<tr>
							<td colspan="2" align="center">
							<?php 
								echo $display_products_button; 
								//jessa 2010-09-06 add wishlist button
								echo '<div style="padding-right:15px;">';
								echo '<script type="text/javascript">document.write(\'<div style="margin-right:-35px;">' . zen_image_submit('button_in_wishlist_green.gif', TEXT_IMAGE_WISHLIST_ALT, 'class="addwishlistbutton" id="wishlist_' . $products_new->fields['products_id'] . '" onclick="Addtowishlist(' . $products_new->fields['products_id'] . ','.$page_type.'); return false;"') . '</div>\')</script>' . "\n";
	        					echo '<noscript><div style="margin-right:-35px;"><a href="' . zen_href_link('wishlist', 'action=addwishlist&pid=' . $products_new->fields['products_id']) . '">' . zen_image_button('button_in_wishlist_green.gif', TEXT_IMAGE_WISHLIST_ALT) . '</a></div></noscript>';
	        					echo '</div>';
	        					//eof jessa 2010-09-06
							?>
							</td>
						</tr>
					<?php }else{ ?>
						<tr>
							<td align="right"><?php echo TEXT_ADD_WORDS;?></td>
							<td align="left">
							<?php 
								echo $display_products_button; 
							?>
							</td>
						</tr>
					<?php } ?>
					<tr>
						<td height="30" colspan="2" align="center">
							<?php 
								if ($products_new->fields['products_quantity'] > 0){
									echo zen_image_submit('button_in_cart_green.gif', BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submitp_' . $products_new->fields['products_id'] . '" onclick="Addtocart('.$products_new->fields['products_id'].','.$page_type.'); return false;" name="submitp_' .  $products_new->fields['products_id'] . '"');
									//jessa 2010-09-06 add wishlist button
									echo '<div style="padding-right:12px;">';
									echo '<script type="text/javascript">document.write(\'<div style="margin-right:-35px;">' . zen_image_submit('button_in_wishlist_green.gif', TEXT_IMAGE_WISHLIST_ALT, 'class="addwishlistbutton" id="wishlist_' . $products_new->fields['products_id'] . '" onclick="Addtowishlist(' . $products_new->fields['products_id'] . ','.$page_type.'); return false;"') . '</div>\')</script>' . "\n";
	        						echo '<noscript><div style="margin-right:-35px;"><a href="' . zen_href_link('wishlist', 'action=addwishlist&pid=' . $products_new->fields['products_id']) . '">' . zen_image_button('button_in_wishlist_green.gif', TEXT_IMAGE_WISHLIST_ALT) . '</a></div></noscript>';
	        						echo '</div>';
	        						//eof jessa 2010-09-06
								}
							?>
						</td>
					</tr>
            	</table>
            </td>
          </tr>
          <tr><td width="100%" colspan="10"><div id="<?php echo $page_name.$products_new->fields['products_id'];?>" class="messageStackSuccess larger" style="display:none;"></div></td></tr>
<?php if (PRODUCT_NEW_LIST_DESCRIPTION != 0) { ?>
          <tr>
            <td colspan="3" valign="top" class="main">
              <?php
                //jessa 2009-09-24 ɾ�� New Arrivals ��Ʒ��ʾ�³��ֵ�Material: Rhinestone..�����ݡ�
			  
              	//echo $display_products_description;
			  
			  	//eof jessa 2009-09-24
              ?>
            </td>
          </tr>
<?php } ?>
<?php
      $products_new->MoveNext();
    }
  } else {
?>
          <tr>
            <td class="main" colspan="3"><?php echo TEXT_NO_NEW_PRODUCTS; ?></td>
          </tr>
<?php
  }
?>
</table>
