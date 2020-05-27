<?php
/**
 * Module Template
 *
 * Loaded automatically by index.php?main_page=featured_products.<br />
 * Displays listing of Featured Products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_products_featured_listing.php 6096 2007-04-01 00:43:21Z ajeh $
 */
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
		<td width="25%" class="allproductListing-heading"><?php echo 'Product Image'; ?></td>
		<td width="50%" class="allproductListing-heading"><?php echo 'Item Name'; ?></td>
		<td width="25%" class="allproductListing-heading"><?php echo 'Price'; ?></td>
  	</tr>
<?php
  $group_id = zen_get_configuration_key_value('PRODUCT_FEATURED_LIST_GROUP_ID');

  if ($featured_products_split->number_of_rows > 0) {
    $featured_products = $db->Execute($featured_products_split->sql_query);

    while (!$featured_products->EOF) {
		// add by zale 2011-10-13
    	$page_name = "product_listing";
		$page_type = 4;		
    	if($_SESSION['cart']->in_cart($featured_products->fields['products_id'])){		//if item already in cart
    		$procuct_qty = $_SESSION['cart']->get_quantity($featured_products->fields['products_id']);
    		$bool_in_cart = 1;
    	}else {
    		$procuct_qty = 0;
    		$bool_in_cart = 0;
    	}
    	//eof

      if (PRODUCT_FEATURED_LIST_IMAGE != '0') {
        if ($featured_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) {
          $display_products_image = str_repeat('', substr(PRODUCT_FEATURED_LIST_IMAGE, 3, 1));
        } else {
          $display_products_image = '<a onmouseover="showlargeimage(\''.HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($featured_products->fields['products_image'], 500, 500).'\')" onmouseout="hidetrail();" href="' . zen_href_link('product_info', 'products_id=' . $featured_products->fields['products_id']) . '"><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($featured_products->fields['products_image'], 130, 130) . '" width="110" height="110" class="lazy listingProductImage" id="anchor' . $featured_products->fields['products_id'] . '"></a>' . str_repeat('', substr(PRODUCT_NEW_LIST_IMAGE, 3, 1));
        }
      } else {
        $display_products_image = '';
      }

      if (PRODUCT_FEATURED_LIST_NAME != '0') {
        $display_products_name = '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($featured_products->fields['master_categories_id'] , 'cPath') . '&products_id=' . $featured_products->fields['products_id']) . '"><strong>' . $featured_products->fields['products_name'] . '</strong></a>' . str_repeat('', substr(PRODUCT_FEATURED_LIST_NAME, 3, 1));
      } else {
        $display_products_name = '';
      }

      if (PRODUCT_FEATURED_LIST_MODEL != '0' and zen_get_show_product_switch($featured_products->fields['products_id'], 'model')) {
        //$display_products_model = TEXT_PRODUCTS_MODEL . $featured_products->fields['products_model'] . str_repeat('', substr(PRODUCT_FEATURED_LIST_MODEL, 3, 1));
        $display_products_model = 'Part No.:' . $featured_products->fields['products_model'] . str_repeat('', substr(PRODUCT_FEATURED_LIST_MODEL, 3, 1));
      } else {
        $display_products_model = '';
      }

      if (PRODUCT_FEATURED_LIST_WEIGHT != '0' and zen_get_show_product_switch($featured_products->fields['products_id'], 'weight')) {
        //$display_products_weight = TEXT_PRODUCTS_WEIGHT . $featured_products->fields['products_weight'] . TEXT_SHIPPING_WEIGHT . str_repeat('', substr(PRODUCT_FEATURED_LIST_WEIGHT, 3, 1));
        $display_products_weight = $featured_products->fields['products_weight'] . TEXT_SHIPPING_WEIGHT . str_repeat('', substr(PRODUCT_FEATURED_LIST_WEIGHT, 3, 1));
      } else {
        $display_products_weight = '';
      }

      if (PRODUCT_FEATURED_LIST_QUANTITY != '0' and zen_get_show_product_switch($featured_products->fields['products_id'], 'quantity')) {
        if ($featured_products->fields['products_quantity'] <= 0) {
          $display_products_quantity = TEXT_OUT_OF_STOCK . str_repeat('', substr(PRODUCT_FEATURED_LIST_QUANTITY, 3, 1));
        } else {
          $display_products_quantity = TEXT_PRODUCTS_QUANTITY . $featured_products->fields['products_quantity'] . str_repeat('', substr(PRODUCT_FEATURED_LIST_QUANTITY, 3, 1));
        }
      } else {
        $display_products_quantity = '';
      }

      if (PRODUCT_FEATURED_LIST_DATE_ADDED != '0' and zen_get_show_product_switch($featured_products->fields['products_id'], 'date_added')) {
        $display_products_date_added = TEXT_DATE_ADDED . ' ' . zen_date_long($featured_products->fields['products_date_added']) . str_repeat('', substr(PRODUCT_FEATURED_LIST_DATE_ADDED, 3, 1));
      } else {
        $display_products_date_added = '';
      }

      if (PRODUCT_FEATURED_LIST_MANUFACTURER != '0' and zen_get_show_product_switch($featured_products->fields['products_id'], 'manufacturer')) {
        $display_products_manufacturers_name = ($featured_products->fields['manufacturers_name'] != '' ? TEXT_MANUFACTURER . ' ' . $featured_products->fields['manufacturers_name'] . str_repeat('', substr(PRODUCT_FEATURED_LIST_MANUFACTURER, 3, 1)) : '');
      } else {
        $display_products_manufacturers_name = '';
      }

      if ((PRODUCT_FEATURED_LIST_PRICE != '0' and zen_get_products_allow_add_to_cart($featured_products->fields['products_id']) == 'Y')  and zen_check_show_prices() == true) {
        if ($featured_products->fields['products_discount_type'] == '0') {
			$products_price = zen_get_products_display_price($featured_products->fields['products_id']);
		} else {
			$products_price = zen_display_products_quantity_discount($featured_products->fields['products_id']);
		}
        $display_products_price = $products_price . str_repeat('', substr(PRODUCT_NEW_LIST_PRICE, 3, 1)) . (zen_get_show_product_switch($featured_products->fields['products_id'], 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') ? (zen_get_product_is_always_free_shipping($featured_products->fields['products_id']) ? TEXT_PRODUCT_FREE_SHIPPING_ICON . '<br />' : '') : '');
      } else {
        $display_products_price = '';
      }

// more info in place of buy now
      if (PRODUCT_FEATURED_BUY_NOW != '0' and zen_get_products_allow_add_to_cart($featured_products->fields['products_id']) == 'Y') {
        if (zen_has_product_attributes($featured_products->fields['products_id'])) {
          $link = '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($featured_products->fields['master_categories_id'] , 'cPath') . '&products_id=' . $featured_products->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        } else {
//          $link= '<a href="' . zen_href_link(FILENAME_FEATURED_PRODUCTS, zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $featured_products->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT) . '</a>';
          if (PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART > 0 && $featured_products->fields['products_qty_box_status'] != 0) {
//            $how_many++;
             $link = "<input type=\"text\" id=\"".$page_name.'_'.$featured_products->fields['products_id']."\" name=\"products_id[" . $featured_products->fields['products_id'] . "]\" value=\"".($bool_in_cart ? $procuct_qty : $featured_products->fields['products_quantity_order_min'])."\" size=\"4\" />".'<input type="hidden" id="MDO_' . $featured_products->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $featured_products->fields['products_id'] . '" value="'.$procuct_qty.'" />';
          } else {
            $link = '<a href="' . zen_href_link(FILENAME_FEATURED_PRODUCTS, zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $featured_products->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT) . '</a>&nbsp;';
          }
        }

        $the_button = $link;
        $products_link = '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($featured_products->fields['master_categories_id'] , 'cPath') . '&products_id=' . $featured_products->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $display_products_button = zen_get_buy_now_button($featured_products->fields['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($featured_products->fields['products_id']) . str_repeat('', substr(PRODUCT_FEATURED_BUY_NOW, 3, 1));
      } else {
        $link = '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($featured_products->fields['master_categories_id'] , 'cPath') . '&products_id=' . $featured_products->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $the_button = $link;
        $products_link = '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($featured_products->fields['master_categories_id'] , 'cPath') . '&products_id=' . $featured_products->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
        $display_products_button = zen_get_buy_now_button($featured_products->fields['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($featured_products->fields['products_id']) . str_repeat('', substr(PRODUCT_FEATURED_BUY_NOW, 3, 1));
      }

      if (PRODUCT_FEATURED_LIST_DESCRIPTION > '0') {
        $disp_text = zen_get_products_description($featured_products->fields['products_id']);
        $disp_text = zen_clean_html($disp_text);

        $display_products_description = stripslashes(zen_trunc_string($disp_text, PRODUCT_FEATURED_LIST_DESCRIPTION, '<a href="' . zen_href_link('product_info', 'cPath=' . get_products_info_memcache($featured_products->fields['master_categories_id'] , 'cPath') . '&products_id=' . $featured_products->fields['products_id']) . '"> ' . MORE_INFO_TEXT . '</a>'));
      } else {
        $display_products_description = '';
      }

?>
          <tr>
            <td class="allproductListing-data">
              <?php
                $disp_sort_order = $db->Execute("select configuration_key, configuration_value from " . TABLE_CONFIGURATION . " where configuration_group_id='" . $group_id . "' and (configuration_value >= 1000 and configuration_value <= 1999) order by LPAD(configuration_value,11,0)");
                while (!$disp_sort_order->EOF) {
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_IMAGE') {
                    echo $display_products_image;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_QUANTITY') {
                    echo $display_products_quantity;
                  }
                  
//                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_BUY_NOW') {
//                    echo $display_products_button;
//                  }

                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_NAME') {
                    echo $display_products_name;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_MODEL') {
                    echo $display_products_model;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_MANUFACTURER') {
                    echo $display_products_manufacturers_name;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_PRICE') {
                    echo $display_products_price;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_WEIGHT') {
                    echo $display_products_weight;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_DATE_ADDED') {
                    echo $display_products_date_added;
                  }
                  $disp_sort_order->MoveNext();
                }
                echo '<br />' . $display_products_model;
              ?>
            </td>
            <td align="left" class="allproductListing-data"><span style="display:block; text-align:left;">
              <?php
                $disp_sort_order = $db->Execute("select configuration_key, configuration_value from " . TABLE_CONFIGURATION . " where configuration_group_id='" . $group_id . "' and (configuration_value >= 2000 and configuration_value <= 2999) order by LPAD(configuration_value,11,0)");
                while (!$disp_sort_order->EOF) {
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_IMAGE') {
                    echo $display_products_image;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_QUANTITY') {
                    echo $display_products_quantity;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_BUY_NOW') {
                    echo $display_products_button;
                  }

                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_NAME') {
                    echo $display_products_name;
                  }
                  
//                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_MODEL') {
//                    echo $display_products_model;
//                  }

                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_MANUFACTURER') {
                    echo $display_products_manufacturers_name;
                  }
                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_PRICE') {
                    echo $display_products_price;
                  }
                  
//                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_WEIGHT') {
//                    echo $display_products_weight;
//                  }

                  if ($disp_sort_order->fields['configuration_key'] == 'PRODUCT_FEATURED_LIST_DATE_ADDED') {
                    echo $display_products_date_added;
                  }
                  $disp_sort_order->MoveNext();
                }
              ?>
              </span>
            </td>
            <td class="allproductListing-data">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            		<?php if ($display_products_weight != ''){ ?>
        			<tr>
						<td width="40%" height="30" align="right">Weight:</td>
						<td width="60%" height="30" align="left">&nbsp;<?php echo $display_products_weight; ?></td>
					 </tr>
            		<?php } ?>
            		<?php if ($featured_products->fields['products_quantity'] <= 0){ ?>
            		<tr>
						<td colspan="2" align="center">
						<?php 
							echo $display_products_button;
							//jessa 2010-09-06 add wishlist button
							echo '<div style="padding-right:5px;">';
							echo '<script type="text/javascript">document.write(\'<div>' . zen_image_submit('button_in_wishlist_green.gif', TEXT_IMAGE_WISHLIST_ALT, 'class="addwishlistbutton" id="wishlist_' . $featured_products->fields['products_id'] . '" onclick="Addtowishlist(' . $featured_products->fields['products_id'] . ','.$page_type.'); return false;"') . '</div>\')</script>' . "\n";
							echo '<noscript><div class="addwishlist" style="margin-right:-5px;"><a href="' . zen_href_link('wishlist', 'action=addwishlist&pid=' . $featured_products->fields['products_id']) . '">' . zen_image_button('button_in_wishlist_green.gif', 'addwishlist') . '</a></div></noscript>';
							echo '</div>';
							//eof jessa 2010-09-06  
						?>
						</td>
					</tr>
            		<?php }else{ ?>
            		<tr>
						<td align="right">add:</td>
						<td align="left"><?php echo $display_products_button; ?></td>
					</tr>
            		<?php } ?>
            		<tr>
						<td height="30" colspan="2" align="center">
						<?php 
							if ($featured_products->fields['products_quantity'] > 0){
								echo zen_image_submit('button_in_cart_green.gif', BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submitp_' . $featured_products->fields['products_id'] . '" onclick="Addtocart('.$featured_products->fields['products_id'].','.$page_type.'); return false;" name="submitp_' .  $featured_products->fields['products_id'] . '"');
								//jessa 2010-09-06 add wishlist button
								echo '<div style="padding-right:5px;">';
								echo '<script type="text/javascript">document.write(\'<div style="margin-right:-25px;">' . zen_image_submit('button_in_wishlist_green.gif', TEXT_IMAGE_WISHLIST_ALT, 'class="addwishlistbutton" id="wishlist_' . $featured_products->fields['products_id'] . '" onclick="Addtowishlist(' . $featured_products->fields['products_id'] . ','.$page_type.'); return false;"') . '</div>\')</script>' . "\n";
								echo '<noscript><div class="addwishlist" style="margin-right:-5px;"><a href="' . zen_href_link('wishlist', 'action=addwishlist&pid=' . $featured_products->fields['products_id']) . '">' . zen_image_button('button_in_wishlist_green.gif', 'addwishlist', 'id="wishlist_' . $featured_products->fields['products_id'] . '" onclick="Addtowishlist(' . $featured_products->fields['products_id'] . ','.$page_type.'); return false;"') . '</a></div></noscript>';
								echo '</div>';
								//eof jessa 2010-09-06 
							}
						?>
						</td>
					 </tr>
            	</table>
            </td>
          </tr>
           <tr><td colspan="10"><div id="<?php echo $page_name.$featured_products->fields['products_id'];?>"></div></td></tr>
<?php if (PRODUCT_FEATURED_LIST_DESCRIPTION > '0') { ?>
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
      $featured_products->MoveNext();
    }
  } else {
?>
          <tr>
            <td class="main" colspan="2"><?php echo TEXT_NO_FEATURED_PRODUCTS; ?></td>
          </tr>
<?php
  }
?>
</table>
