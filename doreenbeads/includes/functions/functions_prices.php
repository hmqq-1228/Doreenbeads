<?php
/**
 * functions_prices
 *
 * @package functions
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_prices.php 6905 2007-09-01 20:05:11Z ajeh $
 */

////
//get specials price or sale price
function zen_get_products_special_price($product_id, $specials_price_only = false, $basic_price = 0)
{
    global $db;
    if ($basic_price) {
        $product_price = $basic_price;
    } else {
        $product = new stdClass();
        $product->fields = get_products_info_memcache((int)$product_id);
        //$product = $db->Execute("select products_price, products_model, products_priced_by_attribute from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
        if (sizeof($product->fields) > 0) {
            $product_price = $product->fields['products_price'];
            //$product_price = zen_get_products_base_price($product_id);
        } else {
            return false;
        }
    }
    /*  $specials = $db->Execute("select specials_new_products_price from " . TABLE_SPECIALS . " where products_id = '" . (int)$product_id . "' and status='1'");
     if ($specials->RecordCount() > 0) {
 //      if ($product->fields['products_priced_by_attribute'] == 1) {
           $special_price = $specials->fields['specials_new_products_price'];
     } else {
         $special_price = false;
     }
     */
    $special_price = false;

    if (substr($product->fields['products_model'], 0, 4) == 'GIFT') {    //Never apply a salededuction to Ian Wilson's Giftvouchers
        if (zen_not_null($special_price)) {
            return $special_price;
        } else {
            return false;
        }
    }
// return special price only
    if ($specials_price_only == true) {
        if (zen_not_null($special_price)) {
            return $special_price;
        } else {
            return false;
        }
    } else {
// get sale price

// changed to use master_categories_id
//      $product_to_categories = $db->Execute("select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "'");
//      $category = $product_to_categories->fields['categories_id'];

        //robbie master_categories
//      $product_to_categories = $db->Execute("select master_categories_id from " . TABLE_PRODUCTS . " where products_id = '" . $product_id . "'");
//      $category = $product_to_categories->fields['master_categories_id'];
//
//      $sale = $db->Execute("select sale_specials_condition, sale_deduction_value, sale_deduction_type from " . TABLE_SALEMAKER_SALES . " where sale_categories_all like '%," . $category . ",%' and sale_status = '1' and (sale_date_start <= now() or sale_date_start = '0001-01-01') and (sale_date_end >= now() or sale_date_end = '0001-01-01') and (sale_pricerange_from <= '" . $product_price . "' or sale_pricerange_from = '0') and (sale_pricerange_to >= '" . $product_price . "' or sale_pricerange_to = '0')");
        $daily_deal_price = get_daily_deal_price_by_products_id($product_id);
        if ($daily_deal_price) {
            return $daily_deal_price;
        }
        $promotion_discount = get_products_discount_by_products_id($product_id);
        if ($promotion_discount) {
            return number_format(($product_price - ($product_price * $promotion_discount / 100)), 4, '.', '');
        }
        /*
    	if(zen_is_promotion_time()){
    		$promotion_discount_query='select p.promotion_discount from '.TABLE_PROMOTION.' p , '.TABLE_PROMOTION_PRODUCTS.' pp where pp.pp_products_id='.$product_id.' and pp.pp_promotion_id=p.promotion_id and p.promotion_status=1 and p.promotion_start_time<="'.date('Y-m-d H:i:s').'" and p.promotion_end_time>"'.date('Y-m-d H:i:s').'" ';
    		$promotion_discount=$db->Execute($promotion_discount_query);
    		if($promotion_discount->fields['promotion_discount']>0){
    			return number_format(($product_price-($product_price*$promotion_discount->fields['promotion_discount']/100)), 4, '.', '');
    		}
    	}
    	*/
        /*
    	if($current_category_id == 1469 || $cPath_array[(sizeof($cPath_array)-1)] == 1469){
			$sale = $db->Execute("Select sale_specials_condition, sale_deduction_value, sale_deduction_type
					      	 From " . TABLE_SALEMAKER_SALES . ", " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_CATEGORIES . " c
					      	Where
							  (sale_categories_selected = c.parent_id
							  or sale_categories_selected = ptc.categories_id)
					      	  And products_id = " . $product_id . "
					      	  And sale_status = '1'
							  And (sale_date_start <= now()
							   or sale_date_start = '0001-01-01 00:00:00')
							  And (sale_date_end >= now()
							   Or sale_date_end = '0001-01-01 00:00:00')
							  And (sale_pricerange_from <= '" . $product_price . "'
							   or sale_pricerange_from = '0')
							  And (sale_pricerange_to >= '" . $product_price . "'
							   or sale_pricerange_to = '0')");
		}else{
    		$sale = $db->Execute("Select distinct(sale_deduction_value), sale_specials_condition, sale_deduction_type
					      	 From " . TABLE_SALEMAKER_SALES . ", " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc
					      	Where find_in_set( ptc.categories_id,sale_categories_all)> 0

					      	  And products_id = " . $product_id . "
					      	  And sale_status = '1'
							  And (sale_date_start <= now()
							   or sale_date_start = '0001-01-01 00:00:00')
							  And (sale_date_end >= now()
							   Or sale_date_end = '0001-01-01 00:00:00')
							  And (sale_pricerange_from <= '" . $product_price . "'
							   or sale_pricerange_from = '0')
							  And (sale_pricerange_to >= '" . $product_price . "'
							   or sale_pricerange_to = '0')");

		}
	  if ($sale->RecordCount() < 1) {
         return $special_price;
      }
      */

        if (!$special_price) {
            $tmp_special_price = $product_price;
        } else {
            $tmp_special_price = $special_price;
        }
        /*
        switch ($sale->fields['sale_deduction_type']) {
          case 0:
            $sale_product_price = $product_price - $sale->fields['sale_deduction_value'];
            $sale_special_price = $tmp_special_price - $sale->fields['sale_deduction_value'];
            break;
          case 1:
            $sale_product_price = $product_price - (($product_price * $sale->fields['sale_deduction_value']) / 100);
            $sale_special_price = $tmp_special_price - (($tmp_special_price * $sale->fields['sale_deduction_value']) / 100);
            break;
          case 2:
            $sale_product_price = $sale->fields['sale_deduction_value'];
            $sale_special_price = $sale->fields['sale_deduction_value'];
            break;
          default:
            return $special_price;
        }

        if ($sale_product_price < 0) {
          $sale_product_price = 0;
        }

        if ($sale_special_price < 0) {
          $sale_special_price = 0;
        }

        if (!$special_price) {
          return number_format($sale_product_price, 4, '.', '');
          } else {
          switch($sale->fields['sale_specials_condition']){
            case 0:
              return number_format($sale_product_price, 4, '.', '');
              break;
            case 1:
              return number_format($special_price, 4, '.', '');
              break;
            case 2:
              return number_format($sale_special_price, 4, '.', '');
              break;
            default:
              return number_format($special_price, 4, '.', '');
          }
        }
        */
    }
    return $tmp_special_price;
}


////
// computes products_price + option groups lowest attributes price of each group when on
function zen_get_products_base_price($products_id)
{
    global $db, $memcache;
    $product_check = new stdClass();
    $product_check->fields = get_products_info_memcache((int)$products_id);
    //$product_check = $db->Execute("select products_price, products_priced_by_attribute from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");
    $products_price = $product_check->fields['products_price'];
    return $products_price;
    /*wsl*/
    // do not select display only attributes and attributes_price_base_included is true
    /*  $product_att_query = $db->Execute("select options_id, price_prefix, options_values_price, attributes_display_only, attributes_price_base_included from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$products_id . "' and attributes_display_only != '1' and attributes_price_base_included='1'". " order by options_id, price_prefix, options_values_price");

     $the_options_id= 'x';
     $the_base_price= 0; */
// add attributes price to price
    /*$product_check->fields['products_priced_by_attribute'] == 0*/
    /*  if ($product_check->fields['products_priced_by_attribute'] == '1' and $product_att_query->RecordCount() >= 1) {
       while (!$product_att_query->EOF) {
         if ( $the_options_id != $product_att_query->fields['options_id']) {
           $the_options_id = $product_att_query->fields['options_id'];
           $the_base_price += $product_att_query->fields['options_values_price'];
         }
         $product_att_query->MoveNext();
       }

       $the_base_price = $products_price + $the_base_price;
     } else {
       $the_base_price = $products_price;
     }
     return $the_base_price; */
}


////
// Display Price Retail
// Specials and Tax Included
function zen_get_products_display_price($products_id)
{
    global $db, $currencies;

    $free_tag = "";
    $call_tag = "";
// 0 = normal shopping
// 1 = Login to shop
// 2 = Can browse but no prices
    // verify display of prices

    switch (true) {
        case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
            // customer must be logged in to browse
            return '';
            break;
        case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
            // customer may browse but no prices
            return TEXT_LOGIN_FOR_PRICE_PRICE;
            break;
        case (CUSTOMERS_APPROVAL == '3' and TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM != ''):
            // customer may browse but no prices
            return TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM;
            break;
        case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customer_id'] == ''):
            // customer must be logged in to browse
            return TEXT_AUTHORIZATION_PENDING_PRICE;
            break;
        case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customers_authorization'] > '0'):
            // customer must be logged in to browse
            return TEXT_AUTHORIZATION_PENDING_PRICE;
            break;
        default:
            // proceed normally
            break;
    }

// show case only
    if (STORE_STATUS != '0') {
        if (STORE_STATUS == '1') {
            return '';
        }
    }

    $product_check = new stdClass();
    $product_check->fields = get_products_info_memcache($products_id);
    $show_display_price = '';
    $display_normal_price = zen_get_products_base_price($products_id);
    $display_special_price = zen_get_products_special_price($products_id, false);
    $display_sale_price = zen_get_products_special_price($products_id, false);
    $ldc_sale_discount = $display_sale_price / $display_normal_price;
    if ($ldc_sale_discount == 0) $ldc_sale_discount = 1;

    //jessa 2010-01-29
    if ($product_check->fields['products_discount_type'] > 0) {
        $low_discount = get_products_info_memcache($products_id, 'low_discount');
        if (!$low_discount or $low_discount <= 0) {
            $qty_discount = 0;
        } else {
            $qty_discount = $low_discount;
            $new_normal_price = $currencies->display_price($qty_discount, (int)zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . ' ~ ';

            ////dorabeads price robbie
            $new_special_price = $currencies->display_price(number_format($qty_discount * $ldc_sale_discount, 2),
                    zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . ' ~ ';
            $new_sale_price = $currencies->display_price(number_format($qty_discount, 2), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . ' ~ ';
        }
    }

    $show_sale_discount = '';

    if (SHOW_SALE_DISCOUNT_STATUS == '1' and ($display_special_price != 0 or $display_sale_price != 0)) {
        if ($display_sale_price) {
            if (SHOW_SALE_DISCOUNT == 1) {
                if ($display_normal_price != 0) {
                    $show_discount_amount = number_format(100 - (($display_sale_price / $display_normal_price) * 100), SHOW_SALE_DISCOUNT_DECIMALS);
                } else {
                    $show_discount_amount = '';
                }
                global $save_is_true;
                if ($save_is_true) {
                    ///让折扣浮动在图片上
                    $show_sale_discount = '<div  class="show_discount_div"><span class="show_discount_amount">' . $show_discount_amount . '</span>%<br>off</div>';
                } else {
                    $show_sale_discount = '<span class="productPriceDiscount">' . '<br />' . PRODUCT_PRICE_DISCOUNT_PREFIX . $show_discount_amount . PRODUCT_PRICE_DISCOUNT_PERCENTAGE . '</span>';
                }
            } else {
                $show_sale_discount = '<span class="productPriceDiscount">' . '<br />' . PRODUCT_PRICE_DISCOUNT_PREFIX . $currencies->display_price(($display_normal_price - $display_sale_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT . '</span>';
            }
        } else {
            if (SHOW_SALE_DISCOUNT == 1) {
                $show_sale_discount = '<span class="productPriceDiscount">' . '<br />' . PRODUCT_PRICE_DISCOUNT_PREFIX . number_format(100 - (($display_special_price / $display_normal_price) * 100), SHOW_SALE_DISCOUNT_DECIMALS) . PRODUCT_PRICE_DISCOUNT_PERCENTAGE . '</span>';
            } else {
                $show_sale_discount = '<span class="productPriceDiscount">' . '<br />' . PRODUCT_PRICE_DISCOUNT_PREFIX . $currencies->display_price(($display_normal_price - $display_special_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT . '</span>';
            }
        }
    }

    if ($display_special_price) {
        $show_normal_price = '<span class="normalprice">' . $new_normal_price . $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . ' </span>';
        if ($display_sale_price && $display_sale_price != $display_special_price) {
            $show_special_price = '<br />' . '<span class="productSpecialPriceSale">' . $new_special_price . $currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>';
            if ($product_check->fields['product_is_free'] == '1') {
                $show_sale_price = '<br />' . '<span class="productSalePrice">' . PRODUCT_PRICE_SALE . '<s>' . $new_normal_price . $currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</s>' . '</span>';
            } else {
                $show_sale_price = '<br />' . '<span class="productSalePrice">' . PRODUCT_PRICE_SALE . $new_sale_price
                    . $currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>';
            }
        } else {
            if ($product_check->fields['product_is_free'] == '1') {
                $show_special_price = '<br />' . '<span class="productSpecialPrice">' . '<s>' . $new_special_price . $currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</s>' . '</span>';
            } else {
                $show_special_price = '<br />' . '<span class="productSpecialPrice">' . $new_special_price . $currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>';
            }
            $show_sale_price = '';
        }
    } else {
        if ($display_sale_price) {
            $show_normal_price = '<span class="normalprice">' . $new_normal_price . $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . ' </span>';
            $show_special_price = '';
            $show_sale_price = '<br />' . '<span class="productSalePrice">' . PRODUCT_PRICE_SALE . $new_normal_price
                . $currencies->display_price($display_sale_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</span>';
        } else {
            if ($product_check->fields['product_is_free'] == '1') {
                $show_normal_price = '<s>' . $new_normal_price . $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '</s>';
            } else {
                $show_normal_price = $new_normal_price . $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id']));
            }
            $show_special_price = '';
            $show_sale_price = '';
        }
    }

    //if(zen_is_promotion_price_time()){
    if (get_products_promotion_price($products_id)) {
        $show_special_price = '<br />' . '<strong>' . $currencies->format(get_daily_deals_price($products_id)) . '</strong>';
    }
    //}

    if ($display_normal_price == 0) {
        // don't show the $0.00
        $final_display_price = $show_special_price . $show_sale_price . $show_sale_discount;
    } else {
        $final_display_price = $show_normal_price . $show_special_price . $show_sale_price . $show_sale_discount;
    }

    // If Free, Show it
    if ($product_check->fields['product_is_free'] == '1') {
        if (OTHER_IMAGE_PRICE_IS_FREE_ON == '0') {
            $free_tag = '<br />' . PRODUCTS_PRICE_IS_FREE_TEXT;
        } else {
            $free_tag = '<br />' . zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_PRICE_IS_FREE, PRODUCTS_PRICE_IS_FREE_TEXT);
        }
    }

    // If Call for Price, Show it
    if ($product_check->fields['product_is_call']) {
        if (PRODUCTS_PRICE_IS_CALL_IMAGE_ON == '0') {
            $call_tag = '<br />' . PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT;
        } else {
            $call_tag = '<br />' . zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_CALL_FOR_PRICE, PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT);
        }
    }

    return $final_display_price . $free_tag . $call_tag;
}

//	lvxiaoyong 1.30
function zen_get_products_display_price_new($products_id, $for_page = '', $is_min = false)
{
    global $db, $currencies;

    switch (true) {
        case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
            // customer must be logged in to browse
            return '';
            break;
        case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
            // customer may browse but no prices
            return TEXT_LOGIN_FOR_PRICE_PRICE;
            break;
        case (CUSTOMERS_APPROVAL == '3' and TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM != ''):
            // customer may browse but no prices
            return TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM;
            break;
        case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customer_id'] == ''):
            // customer must be logged in to browse
            return TEXT_AUTHORIZATION_PENDING_PRICE;
            break;
        case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customers_authorization'] > '0'):
            // customer must be logged in to browse
            return TEXT_AUTHORIZATION_PENDING_PRICE;
            break;
        default:
            // proceed normally
            break;
    }

    // show case only
    if (STORE_STATUS != '0') {
        if (STORE_STATUS == '1') {
            return '';
        }
    }

    $show_display_price = '';
    $display_normal_price = get_products_info_memcache($products_id, 'products_price');
    $display_special_price = zen_get_products_special_price($products_id, false, $display_normal_price);
    $display_sale_price = $display_special_price;
    $ldc_sale_discount = round($display_sale_price / $display_normal_price, 2);
    if ($ldc_sale_discount == 0) $ldc_sale_discount = 1;
    if ($display_special_price == $display_normal_price) {
        $display_special_price = 0;
    }

    //$product_check = $db->Execute("select products_tax_class_id, products_price, products_priced_by_attribute, product_is_free, product_is_call, products_discount_type from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
    $product_check = new stdClass();
    $product_check->fields = get_products_info_memcache($products_id);
    if ($product_check->fields['products_discount_type'] > 0) {
        $low_discount = $product_check->fields['low_discount'];

        if (!$low_discount or $low_discount <= 0) {
            $qty_discount = -1;
            $new_normal_price = $currencies->display_price($display_normal_price, (int)zen_get_tax_rate($product_check->fields['products_tax_class_id']));
            $new_special_price = $currencies->display_price($display_special_price, (int)zen_get_tax_rate($product_check->fields['products_tax_class_id']));
        } else {
            $qty_discount = $low_discount;
            $new_normal_price = $currencies->display_price($qty_discount, (int)zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '';
            $new_special_price = $currencies->display_price(number_format($qty_discount * $ldc_sale_discount, 2), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '';
            $new_sale_price = $currencies->display_price(number_format($qty_discount, 2), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . '';
        }
    }
    // V2.60
    if ($is_min) {
        $min_price = $qty_discount > 0 ? number_format($qty_discount * $ldc_sale_discount, 2) : number_format($display_normal_price * $ldc_sale_discount, 2);
        return $min_price;
    }
    //
    //$show_normal_price = $new_normal_price . $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id']));
    $show_normal_price = $new_normal_price;
    if ($display_special_price) {
        //$show_special_price = $new_special_price . $currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id']));
        $show_special_price = $new_special_price;
    } else {
        $show_special_price = '';
    }
    /*
	if(zen_is_promotion_price_time()){
		if(get_products_promotion_price($products_id)){
			$show_special_price = '<strong>'.$currencies->format(get_daily_deals_price($products_id)).'</strong>';
		}
	}
	*/
    $daily_deal_price = get_daily_deal_price_by_products_id($products_id);
    if ($daily_deal_price) {
        $show_special_price = '<strong>' . $currencies->format($daily_deal_price) . '</strong>';
    }

    //744修改 as low as 为 价格区间
    $products_tax_class_id = $product_check->fields['products_tax_class_id'];
    $products_discount_type = 2;
    $products_id_current = $products_id;
    $quantityDiscounts = zen_get_products_quantity_discounts($products_id, 0);

    if (count($quantityDiscounts) > 1) {
        foreach ($quantityDiscounts as $discount) {
            $temp[] = $discount;
        }

        $max_price_temp = round(max($temp), 2);
        $display_max_price = $currencies->display_price($max_price_temp, zen_get_tax_rate($products_tax_class_id));
        $min_price_temp = round(min($temp), 2);
        $display_min_price = $currencies->display_price($min_price_temp, zen_get_tax_rate($products_tax_class_id));

    }

    switch ($for_page) {
        case 'quick_browse_display':
            if ($display_special_price) {
                $lb_discount = zen_get_product_discount($products_id);
                $display_discount_max_price = $currencies->display_price(round($max_price_temp * $lb_discount, 2), zen_get_tax_rate($products_tax_class_id));
                $display_discount_min_price = $currencies->display_price(round($min_price_temp * $lb_discount, 2), zen_get_tax_rate($products_tax_class_id));
                $show_normal_price = '<del>' . $display_min_price . ' ~ ' . $display_max_price . '</del>';
                $show_special_price = '<ins><strong style="#d20c0c;">' . $display_discount_min_price . ' ~ ' . $display_discount_max_price . '</strong></ins>';
            } else {
                $show_normal_price = '<del></del><ins><strong style="color:#d20c0c;">' . $display_min_price . ' ~ ' . $display_max_price . '</strong></ins>';
            }
            break;
        case 'product_info' :
            if ($display_special_price) {
                $show_normal_price = '<span class="oldprice">' . TEXT_PRICE_AS_LOW_AS . ':' . $show_normal_price . TEXT_PER_PACK . '</span><br>';
                $show_special_price = '<strong><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong>' . $show_special_price . '</strong> ' . TEXT_PER_PACK;
            } else {
                $show_normal_price = '<strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong><strong>' . $show_normal_price . '</strong> ' . TEXT_PER_PACK;
            }
            break;
        case 'matching':
            if ($display_special_price) {
                $show_normal_price = '<p class="oldprice">' . TEXT_PRICE_AS_LOW_AS . ':' . $show_normal_price . '</p>';
                $show_special_price = '<p class="nowprice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong><strong>' . $show_special_price . '</strong></p>';
            } else {
                $show_normal_price = '<p class="oldprice"></p><p class="nowprice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong><strong>' . $show_normal_price . '</strong></p>';
            }
            break;
        case 'foryour_consider':
            if ($display_special_price) {
                $show_normal_price = '<p class="oldprice">' . TEXT_PRICE_AS_LOW_AS . ':' . $show_normal_price . '</p>';
                $show_special_price = '<p class="newprice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong>' . $show_special_price . '</p>';
            } else {
                $show_normal_price = '<p class="oldprice"></p><p class="newprice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong>' . $show_normal_price . '</p>';
            }
            break;
        case 'recent':
            if ($display_special_price) {
                $show_normal_price = '<p class="oldprice">' . TEXT_PRICE_AS_LOW_AS . ':' . $show_normal_price . '</p>';
                $show_special_price = '<p class="newprice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong>' . $show_special_price . '</p>';
            } else {
                $show_normal_price = '<p class="oldprice"></p><p class="newprice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong>' . $show_normal_price . '</p>';
            }
            break;
        case 'wishlist':
            if ($display_special_price) {
                $show_normal_price = '<span class="oldprice">' . TEXT_PRICE_AS_LOW_AS . ':' . $show_normal_price . '</span>';
                $show_special_price = '<span class="nowprice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong>' . $show_special_price . '</span>';
            } else {
                $show_normal_price = '<span class="nowprice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong>' . $show_normal_price . '</span>';
            }
            break;
        case 'mobile_list':
            if ($display_special_price) {
                $show_normal_price = '<li class="oldprice">' . TEXT_PRICE_AS_LOW_AS . ':' . $show_normal_price . '</li>';
                $show_special_price = '<li class="nowprice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong>' . $show_special_price . '</li>';
            } else {
                $show_normal_price = '<li class="nowprice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong>' . $show_normal_price . '</li>';
            }
            break;
        case 'mobile_gallery':
            if ($display_special_price) {
                $price_temp = $show_normal_price;
                $show_normal_price = '<b>' . $show_special_price . '</b>';
                $show_special_price = '<br/><del>' . $price_temp . '</del>';
            } else {
                $show_normal_price = '<b>' . $show_normal_price . '</b>';
            }
            break;
        default:
            if ($display_special_price) {
                $show_normal_price = '<br /><span class="normalprice">' . TEXT_PRICE_AS_LOW_AS . ':' . $show_normal_price . '</span>';
                $show_special_price = '<br /><span class="productSpecialPrice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':</strong>' . $show_special_price . '</span>';
            } else {
                $show_normal_price = '<span class="productSpecialPrice"><strong style="color: #000;">' . TEXT_PRICE_AS_LOW_AS . ':' . $show_normal_price . '</span>';
            }
    }

    if ($display_normal_price == 0) {
        // don't show the $0.00
        $final_display_price = $show_special_price;
    } else {
        $final_display_price = $show_normal_price . $show_special_price;
    }

    return $final_display_price;
}

function zen_get_product_discount($product_id)
{

    global $db, $currencies;

    $products_query = new stdClass();
    $products_query->fields = get_products_info_memcache((int)$product_id);
    $display_normal_price = get_products_info_memcache($product_id, 'products_price');
    $display_sale_price = zen_get_products_special_price($product_id, false, $display_normal_price);
    @$ldc_special_discount = round($display_sale_price / $display_normal_price, 2);
    $origin_price = $products_query->fields["products_price"];
    $products_discount_type = $products_query->fields["products_discount_type"];
    $products_discount_type_from = $products_query->fields["products_discount_type_from"];
    $origin_price = $products_query->fields["products_price"];

    if ($ldc_special_discount == 0) {
        $ldc_special_discount = 1;
    }

    return $ldc_special_discount;
}

// Is the product free?
function zen_get_products_price_is_free($products_id)
{
    global $db;
    $product_check = $db->Execute("select product_is_free from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
    if ($product_check->fields['product_is_free'] == '1') {
        $the_free_price = true;
    } else {
        $the_free_price = false;
    }
    return $the_free_price;
}


////
// Is the product call for price?
function zen_get_products_price_is_call($products_id)
{
    global $db;
    $product_check = $db->Execute("select product_is_call from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
    if ($product_check->fields['product_is_call'] == '1') {
        $the_call_price = true;
    } else {
        $the_call_price = false;
    }
    return $the_call_price;
}

////
// Is the product priced by attributes?
function zen_get_products_price_is_priced_by_attributes($products_id)
{
    global $db;
    $product_check = $db->Execute("select products_priced_by_attribute from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
    if ($product_check->fields['products_priced_by_attribute'] == '1') {
        $the_products_priced_by_attribute = true;
    } else {
        $the_products_priced_by_attribute = false;
    }
    return $the_products_priced_by_attribute;
}

////
// Return a product's minimum quantity
// TABLES: products
function zen_get_products_quantity_order_min($product_id)
{
    global $db;
    $the_products_quantity_order_min = new stdClass();
    $the_products_quantity_order_min->fields = get_products_info_memcache((int)$product_id);
    //$the_products_quantity_order_min = $db->Execute("select products_id, products_quantity_order_min from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    return $the_products_quantity_order_min->fields['products_quantity_order_min'];
}


////
// Return a product's minimum unit order
// TABLES: products
function zen_get_products_quantity_order_units($product_id)
{
    global $db;
    $the_products_quantity_order_units = new stdClass();
    $the_products_quantity_order_units->fields = get_products_info_memcache((int)$product_id);
    //$the_products_quantity_order_units = $db->Execute("select products_id, products_quantity_order_units from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    return $the_products_quantity_order_units->fields['products_quantity_order_units'];
}

////
// Return a product's maximum quantity
// TABLES: products
function zen_get_products_quantity_order_max($product_id)
{
    return 0;
    global $db;
    $the_products_quantity_order_max = new stdClass();
    $the_products_quantity_order_max->fields = get_products_info_memcache((int)$product_id);
    //$the_products_quantity_order_max = $db->Execute("select products_id, products_quantity_order_max from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    return $the_products_quantity_order_max->fields['products_quantity_order_max'];
}

////
// Find quantity discount quantity mixed and not mixed
function zen_get_products_quantity_discount_mixed($product_id, $qty)
{
    global $db;
    global $cart;
    $product_discounts = new stdClass();
    $product_discounts->fields = get_products_info_memcache((int)$product_id);
    //$product_discounts = $db->Execute("select products_price, products_quantity_mixed, product_is_free from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");

    if ($product_discounts->fields['products_quantity_mixed']) {
        if ($new_qty = $_SESSION['cart']->count_contents_qty($product_id)) {
            $qty = $new_qty;
        }
    }
    return $qty;
}


////
// Return a product's quantity box status
// TABLES: products
function zen_get_products_qty_box_status($product_id)
{
    global $db;
    $the_products_qty_box_status = new stdClass();
    $the_products_qty_box_status->fields = get_products_info_memcache((int)$product_id);
    //$the_products_qty_box_status = $db->Execute("select products_id, products_qty_box_status  from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    return $the_products_qty_box_status->fields['products_qty_box_status'];
}

////
// Return a product mixed setting
// TABLES: products
function zen_get_products_quantity_mixed($product_id)
{
    global $db;
    return 'none'; /*wsl 只执行else*/
// don't check for mixed if not attributes
    $chk_attrib = zen_has_product_attributes((int)$product_id);
    if ($chk_attrib == true) {
        $the_products_quantity_mixed = $db->Execute("select products_id, products_quantity_mixed from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
        if ($the_products_quantity_mixed->fields['products_quantity_mixed'] == '1') {
            $look_up = true;
        } else {
            $look_up = false;
        }
    } else {
        $look_up = 'none';
    }

    return $look_up;
}


////
// Return a products quantity minimum and units display
function zen_get_products_quantity_min_units_display($product_id, $include_break = true, $shopping_cart_msg = false)
{
    $check_min = zen_get_products_quantity_order_min($product_id);
    $check_units = zen_get_products_quantity_order_units($product_id);

    $the_min_units = '';

    if ($check_min != 1 or $check_units != 1) {
        if ($check_min != 1) {
            //jessa 2009-11-26 if the $check_min = 0 then don't display the min order qty
            if ($check_min == 0) {
                $the_min_units .= '';
            } else {
                $the_min_units .= PRODUCTS_QUANTITY_MIN_TEXT_LISTING . '&nbsp;' . $check_min;
            }
            //eof jessa 2009-11-26
        }
        if ($check_units != 1) {
            $the_min_units .= ($the_min_units ? ' ' : '') . PRODUCTS_QUANTITY_UNIT_TEXT_LISTING . '&nbsp;' . $check_units;
        }

// don't check for mixed if not attributes
        $chk_mix = zen_get_products_quantity_mixed((int)$product_id);
        if ($chk_mix != 'none') {
            if (($check_min > 0 or $check_units > 0)) {
                if ($include_break == true) {
                    $the_min_units .= '<br />' . ($shopping_cart_msg == false ? TEXT_PRODUCTS_MIX_OFF : TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART);
                } else {
                    $the_min_units .= '&nbsp;&nbsp;' . ($shopping_cart_msg == false ? TEXT_PRODUCTS_MIX_OFF : TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART);
                }
            } else {
                if ($include_break == true) {
                    $the_min_units .= '<br />' . ($shopping_cart_msg == false ? TEXT_PRODUCTS_MIX_ON : TEXT_PRODUCTS_MIX_ON_SHOPPING_CART);
                } else {
                    $the_min_units .= '&nbsp;&nbsp;' . ($shopping_cart_msg == false ? TEXT_PRODUCTS_MIX_ON : TEXT_PRODUCTS_MIX_ON_SHOPPING_CART);
                }
            }
        }
    }

    // quantity max
    $check_max = zen_get_products_quantity_order_max($product_id);

    if ($check_max != 0) {
        if ($include_break == true) {
            $the_min_units .= ($the_min_units != '' ? '<br />' : '') . PRODUCTS_QUANTITY_MAX_TEXT_LISTING . '&nbsp;' . $check_max;
        } else {
            $the_min_units .= ($the_min_units != '' ? '&nbsp;&nbsp;' : '') . PRODUCTS_QUANTITY_MAX_TEXT_LISTING . '&nbsp;' . $check_max;
        }
    }

    return $the_min_units;
}


////
// Return quantity buy now
function zen_get_buy_now_qty($product_id)
{
    global $cart;
    $check_min = zen_get_products_quantity_order_min($product_id);
    $check_units = zen_get_products_quantity_order_units($product_id);
    $buy_now_qty = 1;
// works on Mixed ON
    switch (true) {
        case ($_SESSION['cart']->in_cart_mixed($product_id) == 0):
            if ($check_min >= $check_units) {
                $buy_now_qty = $check_min;
            } else {
                $buy_now_qty = $check_units;
            }
            break;
        case ($_SESSION['cart']->in_cart_mixed($product_id) < $check_min):
            $buy_now_qty = $check_min - $_SESSION['cart']->in_cart_mixed($product_id);
            break;
        case ($_SESSION['cart']->in_cart_mixed($product_id) > $check_min):
            // set to units or difference in units to balance cart
            $new_units = $check_units - fmod_round($_SESSION['cart']->in_cart_mixed($product_id), $check_units);
//echo 'Cart: ' . $_SESSION['cart']->in_cart_mixed($product_id) . ' Min: ' . $check_min . ' Units: ' . $check_units . ' fmod: ' . fmod($_SESSION['cart']->in_cart_mixed($product_id), $check_units) . '<br />';
            $buy_now_qty = ($new_units > 0 ? $new_units : $check_units);
            break;
        default:
            $buy_now_qty = $check_units;
            break;
    }
    if ($buy_now_qty <= 0) {
        $buy_now_qty = 1;
    }
    return $buy_now_qty;
}


////
// compute product discount to be applied to attributes or other values
function zen_get_discount_calc($product_id, $attributes_id = false, $attributes_amount = false, $check_qty = false)
{
    global $discount_type_id, $sale_maker_discount;
    global $cart;

    // no charge
    if ($attributes_id > 0 and $attributes_amount == 0) {
        return 0;
    }

    $new_products_price = zen_get_products_base_price($product_id);
    $new_special_price = zen_get_products_special_price($product_id, true);
    $new_sale_price = zen_get_products_special_price($product_id, false);

    $discount_type_id = zen_get_products_sale_discount_type($product_id);

    if ($new_products_price != 0) {
        $special_price_discount = ($new_special_price != 0 ? ($new_special_price / $new_products_price) : 1);
    } else {
        $special_price_discount = '';
    }
    $sale_maker_discount = zen_get_products_sale_discount_type($product_id, '', 'amount');

    // percentage adjustment of discount
    if (($discount_type_id == 120 or $discount_type_id == 1209) or ($discount_type_id == 110 or $discount_type_id == 1109)) {
        $sale_maker_discount = ($sale_maker_discount != 0 ? (100 - $sale_maker_discount) / 100 : 1);
    }

    $qty = $check_qty;

// fix here
// BOF: percentage discounts apply to price
    switch (true) {
        case (zen_get_discount_qty($product_id, $qty) and !$attributes_id):
            // discount quanties exist and this is not an attribute
            // $this->contents[$products_id]['qty']
            $check_discount_qty_price = zen_get_products_discount_price_qty($product_id, $qty, $attributes_amount);
//echo 'How much 1 ' . $qty . ' : ' . $attributes_amount . ' vs ' . $check_discount_qty_price . '<br />';
            return $check_discount_qty_price;
            break;

        case (zen_get_discount_qty($product_id, $qty) and zen_get_products_price_is_priced_by_attributes($product_id)):
            // discount quanties exist and this is not an attribute
            // $this->contents[$products_id]['qty']
            $check_discount_qty_price = zen_get_products_discount_price_qty($product_id, $qty, $attributes_amount);
//echo 'How much 2 ' . $qty . ' : ' . $attributes_amount . ' vs ' . $check_discount_qty_price . '<br />';

            return $check_discount_qty_price;
            break;

        case ($discount_type_id == 5):
            // No Sale and No Special
//        $sale_maker_discount = 1;
            if (!$attributes_id) {
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    if ($special_price_discount != 0) {
                        $calc = ($attributes_amount * $special_price_discount);
                    } else {
                        $calc = $attributes_amount;
                    }

                    $sale_maker_discount = $calc;
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
//echo 'How much 3 - ' . $qty . ' : ' . $product_id . ' : ' . $qty . ' x ' .  $attributes_amount . ' vs ' . $check_discount_qty_price . ' - ' . $sale_maker_discount . '<br />';
            break;
        case ($discount_type_id == 59):
            // No Sale and Special
//        $sale_maker_discount = $special_price_discount;
            if (!$attributes_id) {
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount * $special_price_discount);
                    $sale_maker_discount = $calc;
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
// EOF: percentage discount apply to price

// BOF: percentage discounts apply to Sale
        case ($discount_type_id == 120):
            // percentage discount Sale and Special without a special
            if (!$attributes_id) {
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount * $sale_maker_discount);
                    $sale_maker_discount = $calc;
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
        case ($discount_type_id == 1209):
            // percentage discount on Sale and Special with a special
            if (!$attributes_id) {
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount * $special_price_discount);
                    $calc2 = $calc - ($calc * $sale_maker_discount);
                    $sale_maker_discount = $calc - $calc2;
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
// EOF: percentage discounts apply to Sale

// BOF: percentage discounts skip specials
        case ($discount_type_id == 110):
            // percentage discount Sale and Special without a special
            if (!$attributes_id) {
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount * $sale_maker_discount);
                    $sale_maker_discount = $calc;
                } else {
//            $sale_maker_discount = $sale_maker_discount;
                    if ($attributes_amount != 0) {
//            $calc = ($attributes_amount * $special_price_discount);
//            $calc2 = $calc - ($calc * $sale_maker_discount);
//            $sale_maker_discount = $calc - $calc2;
                        $calc = $attributes_amount - ($attributes_amount * $sale_maker_discount);
                        $sale_maker_discount = $calc;
                    } else {
                        $sale_maker_discount = $sale_maker_discount;
                    }
                }
            }
            break;
        case ($discount_type_id == 1109):
            // percentage discount on Sale and Special with a special
            if (!$attributes_id) {
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount * $special_price_discount);
//            $calc2 = $calc - ($calc * $sale_maker_discount);
//            $sale_maker_discount = $calc - $calc2;
                    $sale_maker_discount = $calc;
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
// EOF: percentage discounts skip specials

// BOF: flat amount discounts
        case ($discount_type_id == 20):
            // flat amount discount Sale and Special without a special
            if (!$attributes_id) {
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount - $sale_maker_discount);
                    $sale_maker_discount = $calc;
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
        case ($discount_type_id == 209):
            // flat amount discount on Sale and Special with a special
            if (!$attributes_id) {
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount * $special_price_discount);
                    $calc2 = ($calc - $sale_maker_discount);
                    $sale_maker_discount = $calc2;
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
// EOF: flat amount discounts

// BOF: flat amount discounts Skip Special
        case ($discount_type_id == 10):
            // flat amount discount Sale and Special without a special
            if (!$attributes_id) {
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount - $sale_maker_discount);
                    $sale_maker_discount = $calc;
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
        case ($discount_type_id == 109):
            // flat amount discount on Sale and Special with a special
            if (!$attributes_id) {
                $sale_maker_discount = 1;
            } else {
                // compute attribute amount based on Special
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount * $special_price_discount);
                    $sale_maker_discount = $calc;
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
// EOF: flat amount discounts Skip Special

// BOF: New Price amount discounts
        case ($discount_type_id == 220):
            // New Price amount discount Sale and Special without a special
            if (!$attributes_id) {
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount * $special_price_discount);
                    $sale_maker_discount = $calc;
//echo '<br />attr ' . $attributes_amount . ' spec ' . $special_price_discount . ' Calc ' . $calc . 'Calc2 ' . $calc2 . '<br />';
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
        case ($discount_type_id == 2209):
            // New Price amount discount on Sale and Special with a special
            if (!$attributes_id) {
//          $sale_maker_discount = $sale_maker_discount;
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount * $special_price_discount);
//echo '<br />attr ' . $attributes_amount . ' spec ' . $special_price_discount . ' Calc ' . $calc . 'Calc2 ' . $calc2 . '<br />';
                    $sale_maker_discount = $calc;
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
// EOF: New Price amount discounts

// BOF: New Price amount discounts - Skip Special
        case ($discount_type_id == 210):
            // New Price amount discount Sale and Special without a special
            if (!$attributes_id) {
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount * $special_price_discount);
                    $sale_maker_discount = $calc;
//echo '<br />attr ' . $attributes_amount . ' spec ' . $special_price_discount . ' Calc ' . $calc . 'Calc2 ' . $calc2 . '<br />';
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
        case ($discount_type_id == 2109):
            // New Price amount discount on Sale and Special with a special
            if (!$attributes_id) {
//          $sale_maker_discount = $sale_maker_discount;
                $sale_maker_discount = $sale_maker_discount;
            } else {
                // compute attribute amount
                if ($attributes_amount != 0) {
                    $calc = ($attributes_amount * $special_price_discount);
//echo '<br />attr ' . $attributes_amount . ' spec ' . $special_price_discount . ' Calc ' . $calc . 'Calc2 ' . $calc2 . '<br />';
                    $sale_maker_discount = $calc;
                } else {
                    $sale_maker_discount = $sale_maker_discount;
                }
            }
            break;
// EOF: New Price amount discounts - Skip Special

        case ($discount_type_id == 0 or $discount_type_id == 9):
            // flat discount
            return $sale_maker_discount;
            break;
        default:
            $sale_maker_discount = 7000;
            break;
    }

    return $sale_maker_discount;
}

////
// look up discount in sale makers - attributes only can have discounts if set as percentages
// this gets the discount amount this does not determin when to apply the discount
function zen_get_products_sale_discount_type($product_id = false, $categories_id = false, $return_value = false)
{
    global $currencies;
    global $db;

    /*

    0 = flat amount off base price with a special
    1 = Percentage off base price with a special
    2 = New Price with a special

    5 = No Sale or Skip Products with Special

    special options + option * 10
    0 = Ignore special and apply to Price
    1 = Skip Products with Specials switch to 5
    2 = Apply to Special Price

    If a special exist * 10+9

    0*100 + 0*10 = flat apply to price = 0 or 9
    0*100 + 1*10 = flat skip Specials = 5 or 59
    0*100 + 2*10 = flat apply to special = 20 or 209

    1*100 + 0*10 = Percentage apply to price = 100 or 1009
    1*100 + 1*10 = Percentage skip Specials = 110 or 1109 / 5 or 59
    1*100 + 2*10 = Percentage apply to special = 120 or 1209

    2*100 + 0*10 = New Price apply to price = 200 or 2009
    2*100 + 1*10 = New Price skip Specials = 210 or 2109 / 5 or 59
    2*100 + 2*10 = New Price apply to Special = 220 or 2209

    */

// get products category
    if ($categories_id == true) {
        $check_category = $categories_id;
    } else {
        $check_category = get_products_info_memcache($product_id, 'categories_id');
    }
    /*
        $deduction_type_array = array(array('id' => '0', 'text' => DEDUCTION_TYPE_DROPDOWN_0),
                                      array('id' => '1', 'text' => DEDUCTION_TYPE_DROPDOWN_1),
                                      array('id' => '2', 'text' => DEDUCTION_TYPE_DROPDOWN_2));
    */
    $sale_exists = 'false';
    $sale_maker_discount = '';
    $sale_maker_special_condition = '';
    $salemaker_sales = $db->Execute("select sale_id, sale_status, sale_name, sale_categories_all, sale_deduction_value, sale_deduction_type, sale_pricerange_from, sale_pricerange_to, sale_specials_condition, sale_categories_selected, sale_date_start, sale_date_end, sale_date_added, sale_date_last_modified, sale_date_status_change from " . TABLE_SALEMAKER_SALES . " where sale_status='1'");
    while (!$salemaker_sales->EOF) {
        $categories = explode(',', $salemaker_sales->fields['sale_categories_all']);
        while (list($key, $value) = each($categories)) {
            if ($value == $check_category) {
                $sale_exists = 'true';
                $sale_maker_discount = $salemaker_sales->fields['sale_deduction_value'];
                $sale_maker_special_condition = $salemaker_sales->fields['sale_specials_condition'];
                $sale_maker_discount_type = $salemaker_sales->fields['sale_deduction_type'];
                break;
            }
        }
        $salemaker_sales->MoveNext();
    }

    $check_special = zen_get_products_special_price($product_id, true);

    if ($sale_exists == 'true' and $sale_maker_special_condition != 0) {
        $sale_maker_discount_type = (($sale_maker_discount_type * 100) + ($sale_maker_special_condition * 10));
    } else {
        $sale_maker_discount_type = 5;
    }

    if (!$check_special) {
        // do nothing
    } else {
        $sale_maker_discount_type = ($sale_maker_discount_type * 10) + 9;
    }

    switch (true) {
        case (!$return_value):
            return $sale_maker_discount_type;
            break;
        case ($return_value == 'amount'):
            return $sale_maker_discount;
            break;
        default:
            return 'Unknown Request';
            break;
    }
}

////
// look up discount in sale makers - attributes only can have discounts if set as percentages
// this gets the discount amount this does not determin when to apply the discount
function zen_get_products_sale_discount($product_id = false, $categories_id = false, $display_type = false)
{
    global $currencies;
    global $db;

// NOT USED
    echo '<br />' . 'I SHOULD use zen_get_discount_calc' . '<br />';

    /*

    0 = flat amount off base price with a special
    1 = Percentage off base price with a special
    2 = New Price with a special

    5 = No Sale or Skip Products with Special

    special options + option * 10
    0 = Ignore special and apply to Price
    1 = Skip Products with Specials switch to 5
    2 = Apply to Special Price

    If a special exist * 10

    0+7 + 0+10 = flat apply to price = 17 or 170
    0+7 + 1+10 = flat skip Specials = 5 or 50
    0+7 + 2+10 = flat apply to special = 27 or 270

    1+7 + 0+10 = Percentage apply to price = 18 or 180
    1+7 + 1+10 = Percentage skip Specials = 5 or 50
    1+7 + 2+10 = Percentage apply to special = 20 or 200

    2+7 + 0+10 = New Price apply to price = 19 or 190
    2+7 + 1+10 = New Price skip Specials = 5 or 50
    2+7 + 2+10 = New Price apply to Special = 21 or 210

    */

    /*
    // get products category
        if ($categories_id == true) {
          $check_category = $categories_id;
        } else {
          $check_category = get_products_info_memcache($product_id , 'categories_id');
        }

        $deduction_type_array = array(array('id' => '0', 'text' => DEDUCTION_TYPE_DROPDOWN_0),
                                      array('id' => '1', 'text' => DEDUCTION_TYPE_DROPDOWN_1),
                                      array('id' => '2', 'text' => DEDUCTION_TYPE_DROPDOWN_2));

        $sale_maker_discount = 0;
        $salemaker_sales = $db->Execute("select sale_id, sale_status, sale_name, sale_categories_all, sale_deduction_value, sale_deduction_type, sale_pricerange_from, sale_pricerange_to, sale_specials_condition, sale_categories_selected, sale_date_start, sale_date_end, sale_date_added, sale_date_last_modified, sale_date_status_change from " . TABLE_SALEMAKER_SALES . " where sale_status='1'");
        while (!$salemaker_sales->EOF) {
          $categories = explode(',', $salemaker_sales->fields['sale_categories_all']);
            while (list($key,$value) = each($categories)) {
              if ($value == $check_category) {
                $sale_maker_discount = $salemaker_sales->fields['sale_deduction_value'];
                $sale_maker_discount_type = $salemaker_sales->fields['sale_deduction_type'];
                break;
            }
          }
          $salemaker_sales->MoveNext();
        }

        switch(true) {
          // percentage discount only
          case ($sale_maker_discount_type == 1):
            $sale_maker_discount = (1 - ($sale_maker_discount / 100));
            break;
          case ($sale_maker_discount_type == 0 and $display_type == true):
            $sale_maker_discount = $sale_maker_discount;
            break;
          case ($sale_maker_discount_type == 0 and $display_type == false):
            $sale_maker_discount = $sale_maker_discount;
            break;
          case ($sale_maker_discount_type == 2 and $display_type == true):
            $sale_maker_discount = $sale_maker_discount;
            break;
          default:
            $sale_maker_discount = 1;
            break;
        }

        if ($display_type == true) {
          if ($sale_maker_discount != 1 and $sale_maker_discount !=0) {
            switch(true) {
              case ($sale_maker_discount_type == 0):
                $sale_maker_discount = $currencies->format($sale_maker_discount) . ' ' . $deduction_type_array[$sale_maker_discount_type]['text'];
                break;
              case ($sale_maker_discount_type == 2):
                $sale_maker_discount = $currencies->format($sale_maker_discount) . ' ' . $deduction_type_array[$sale_maker_discount_type]['text'];
                break;
              case ($sale_maker_discount_type == 1):
                $sale_maker_discount = number_format( (1.00 - $sale_maker_discount),2,".","") . ' ' . $deduction_type_array[$sale_maker_discount_type]['text'];
                break;
            }
          } else {
            $sale_maker_discount = '';
          }
        }
        return $sale_maker_discount;
    */

}

////
// Actual Price Retail
// Specials and Tax Included
function zen_get_products_actual_price($products_id, $products_info = null)
{
    global $db, $currencies;
    //$product_check = $db->Execute("select products_tax_class_id, products_price, products_priced_by_attribute, product_is_free, product_is_call from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
    if (is_array($products_info) && isset($products_info['products_price'])) {
        $display_normal_price = $products_info['products_price'];
        $display_special_price = zen_get_products_special_price($products_id, true, $products_info['products_price']);
        $display_sale_price = zen_get_products_special_price($products_id, false, $products_info['products_price']);
    } else {
        $product_check = new stdClass();
        $products_info = get_products_info_memcache($products_id);
        $display_normal_price = $products_info['products_price'];
        $display_special_price = zen_get_products_special_price($products_id, true, $products_info['products_price']);
        $display_sale_price = zen_get_products_special_price($products_id, false, $products_info['products_price']);
    }

    $products_actual_price = $display_normal_price;

    if ($display_special_price) {
        $products_actual_price = $display_special_price;
    }
    if ($display_sale_price) {
        $products_actual_price = $display_sale_price;
    }

    // If Free, Show it
    if ($products_info['product_is_free'] == '1') {
        $products_actual_price = 0;
    }

    return $products_actual_price;
}

////
// return attributes_price_factor
function zen_get_attributes_price_factor($price, $special, $factor, $offset)
{
    if (ATTRIBUTES_PRICE_FACTOR_FROM_SPECIAL == '1' and $special) {
        // calculate from specials_new_products_price
        $calculated_price = $special * ($factor - $offset);
    } else {
        // calculate from products_price
        $calculated_price = $price * ($factor - $offset);
    }
//    return '$price ' . $price . ' $special ' . $special . ' $factor ' . $factor . ' $offset ' . $offset;
    return $calculated_price;
}


////
// return attributes_qty_prices or attributes_qty_prices_onetime based on qty
function zen_get_attributes_qty_prices_onetime($string, $qty)
{
    $attribute_qty = split("[:,]", $string);
    $new_price = 0;
    $size = sizeof($attribute_qty);
// if an empty string is passed then $attributes_qty will consist of a 1 element array
    if ($size > 1) {
        for ($i = 0, $n = $size; $i < $n; $i += 2) {
            $new_price = $attribute_qty[$i + 1];
            if ($qty <= $attribute_qty[$i]) {
                $new_price = $attribute_qty[$i + 1];
                break;
            }
        }
    }
    return $new_price;
}


////
// Check specific attributes_qty_prices or attributes_qty_prices_onetime for a given quantity price
function zen_get_attributes_quantity_price($check_what, $check_for)
{
// $check_what='1:3.00,5:2.50,10:2.25,20:2.00';
// $check_for=50;
    $attribute_table_cost = split("[:,]", $check_what);
    $size = sizeof($attribute_table_cost);
    for ($i = 0, $n = $size; $i < $n; $i += 2) {
        if ($check_for >= $attribute_table_cost[$i]) {
            $attribute_quantity_check = $attribute_table_cost[$i];
            $attribute_quantity_price = $attribute_table_cost[$i + 1];
        }
    }
//          echo '<br>Cost ' . $check_for . ' - '  .  $attribute_quantity_check . ' x ' . $attribute_quantity_price;
    return $attribute_quantity_price;
}


////
// attributes final price
function zen_get_attributes_price_final($attribute, $qty = 1, $pre_selected, $include_onetime = 'false')
{
    global $db;
    global $cart;

    $attributes_price_final = 0;

    if ($pre_selected == '' or $attribute != $pre_selected->fields["products_attributes_id"]) {
        $pre_selected = $db->Execute("select pa.* from " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_attributes_id= '" . (int)$attribute . "'");
    } else {
        // use existing select
    }

    // normal attributes price
    if ($pre_selected->fields["price_prefix"] == '-') {
        $attributes_price_final -= $pre_selected->fields["options_values_price"];
    } else {
        $attributes_price_final += $pre_selected->fields["options_values_price"];
    }
    // qty discounts
    $attributes_price_final += zen_get_attributes_qty_prices_onetime($pre_selected->fields["attributes_qty_prices"], $qty);

    // price factor
    $display_normal_price = zen_get_products_actual_price($pre_selected->fields["products_id"]);
    $display_special_price = zen_get_products_special_price($pre_selected->fields["products_id"]);

    $attributes_price_final += zen_get_attributes_price_factor($display_normal_price, $display_special_price, $pre_selected->fields["attributes_price_factor"], $pre_selected->fields["attributes_price_factor_offset"]);

    // per word and letter charges
    if (zen_get_attributes_type($attribute) == PRODUCTS_OPTIONS_TYPE_TEXT) {
        // calc per word or per letter
    }

// onetime charges
    if ($include_onetime == 'true') {
        $pre_selected_onetime = $pre_selected;
        $attributes_price_final += zen_get_attributes_price_final_onetime($pre_selected->fields["products_attributes_id"], 1, $pre_selected_onetime);
    }

    return $attributes_price_final;
}


////
// attributes final price onetime
function zen_get_attributes_price_final_onetime($attribute, $qty = 1, $pre_selected_onetime)
{
    global $db;
    global $cart;

    if ($pre_selected_onetime == '' or $attribute != $pre_selected_onetime->fields["products_attributes_id"]) {
        $pre_selected_onetime = $db->Execute("select pa.* from " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_attributes_id= '" . (int)$attribute . "'");
    } else {
        // use existing select
    }

// one time charges
    // onetime charge
    $attributes_price_final_onetime += $pre_selected_onetime->fields["attributes_price_onetime"];

    // price factor
    $display_normal_price = zen_get_products_actual_price($pre_selected_onetime->fields["products_id"]);
    $display_special_price = zen_get_products_special_price($pre_selected_onetime->fields["products_id"]);

    // price factor one time
    $attributes_price_final_onetime += zen_get_attributes_price_factor($display_normal_price, $display_special_price, $pre_selected_onetime->fields["attributes_price_factor_onetime"], $pre_selected_onetime->fields["attributes_price_factor_onetime_offset"]);

    // onetime charge qty price
    $attributes_price_final_onetime += zen_get_attributes_qty_prices_onetime($pre_selected_onetime->fields["attributes_qty_prices_onetime"], 1);

    return $attributes_price_final_onetime;
}


////
// get attributes type
function zen_get_attributes_type($check_attribute)
{
    global $db;
    $check_options_id_query = $db->Execute("select options_id from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_attributes_id='" . (int)$check_attribute . "'");
    $check_type_query = $db->Execute("select products_options_type from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id='" . (int)$check_options_id_query->fields['options_id'] . "'");
    return $check_type_query->fields['products_options_type'];
}


////
// calculate words
function zen_get_word_count($string, $free = 0)
{
    $string = str_replace(array("\r\n", "\n", "\r", "\t"), ' ', $string);

    if ($string != '') {
        while (strstr($string, '  ')) $string = str_replace('  ', ' ', $string);
        $string = trim($string);
        $word_count = substr_count($string, ' ');
        return (($word_count + 1) - $free);
    } else {
        // nothing to count
        return 0;
    }
}


////
// calculate words price
function zen_get_word_count_price($string, $free = 0, $price)
{

    $word_count = zen_get_word_count($string, $free);
    if ($word_count >= 1) {
        return ($word_count * $price);
    } else {
        return 0;
    }
}


////
// calculate letters
function zen_get_letters_count($string, $free = 0)
{
    $string = str_replace(array("\r\n", "\n", "\r", "\t"), ' ', $string);

    while (strstr($string, '  ')) $string = str_replace('  ', ' ', $string);
    $string = trim($string);
    if (TEXT_SPACES_FREE == '1') {
        $letters_count = strlen(str_replace(' ', '', $string));
    } else {
        $letters_count = strlen($string);
    }
    if ($letters_count - $free >= 1) {
        return ($letters_count - $free);
    } else {
        return 0;
    }
}


////
// calculate letters price
function zen_get_letters_count_price($string, $free = 0, $price)
{

    $letters_price = zen_get_letters_count($string, $free) * $price;
    if ($letters_price <= 0) {
        return 0;
    } else {
        return $letters_price;
    }
}


////
// compute discount based on qty
function zen_get_products_discount_price_qty($product_id, $check_qty, $check_amount = 0, $use_special_price = true, $products_info = null)
{
    global $db, $cart;
    //Tianwen.Wan20160624购物车优化
    /*
    $new_qty = $_SESSION['cart']->in_cart_mixed_discount_quantity($product_id);
    // check for discount qty mix
    if ($new_qty > $check_qty) {
      $check_qty = $new_qty;
    }
    */
    $product_id = (int)$product_id;
    $products_query = new stdClass();
    if (is_array($products_info)) {
        $products_query->fields = $products_info;
    } else {
        $products_query->fields = get_products_info_memcache($product_id);
    }
    //$products_query = $db->Execute("select products_discount_type, products_discount_type_from, products_priced_by_attribute from " . TABLE_PRODUCTS . " where products_id='" . (int)$product_id . "'");
    $products_discounts_query = $db->Execute("select * from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id='" . (int)$product_id . "' and discount_qty <='" . (float)$check_qty . "' order by discount_qty desc");
    $display_price = zen_get_products_base_price($product_id);
    if ($use_special_price)
        $display_specials_price = zen_get_products_special_price($product_id, false, $products_query->fields['products_price']);
    $ldc_special_discount = $display_specials_price / $display_price;
    if ($ldc_special_discount == 0) $ldc_special_discount = 1;

    switch ($products_query->fields['products_discount_type']) {
        // none
        case ($products_discounts_query->EOF):
            //no discount applies
            if ($use_special_price)
                $discounted_price = zen_get_products_actual_price($product_id, $products_query->fields);
            else
                $discounted_price = $display_price;
            break;
        case '0':
            $discounted_price = zen_get_products_actual_price($product_id, $products_query->fields);
            break;
        // percentage discount
        case '1':
            if ($products_query->fields['products_discount_type_from'] == '0') {
                // priced by attributes
                if ($check_amount != 0) {
                    $discounted_price = $check_amount - ($check_amount * ($products_discounts_query->fields['discount_price'] / 100));
//echo 'ID#' . $product_id . ' Amount is: ' . $check_amount . ' discount: ' . $discounted_price . '<br />';
//echo 'I SEE 2 for ' . $products_query->fields['products_discount_type'] . ' - ' . $products_query->fields['products_discount_type_from'] . ' - '. $check_amount . ' new: ' . $discounted_price . ' qty: ' . $check_qty;
                } else {
                    $discounted_price = $display_price - ($display_price * ($products_discounts_query->fields['discount_price'] / 100));
                }
            } else {
                if (!$display_specials_price) {
                    // priced by attributes
                    if ($check_amount != 0) {
                        $discounted_price = $check_amount - ($check_amount * ($products_discounts_query->fields['discount_price'] / 100));
                    } else {
                        $discounted_price = $display_price - ($display_price * ($products_discounts_query->fields['discount_price'] / 100));
                    }
                } else {
                    $discounted_price = $display_specials_price - ($display_specials_price * ($products_discounts_query->fields['discount_price'] / 100));
                }
            }

            break;
        // actual price
        case '2':
            if ($products_query->fields['products_discount_type_from'] == '0') {
                $discounted_price = $products_discounts_query->fields['discount_price'];
            } else {
                $discounted_price = $products_discounts_query->fields['discount_price'] * $ldc_special_discount;
            }
            break;
        // amount offprice
        case '3':
            if ($products_query->fields['products_discount_type_from'] == '0') {
                $discounted_price = $display_price - $products_discounts_query->fields['discount_price'];
            } else {
                if (!$display_specials_price) {
                    $discounted_price = $display_price - $products_discounts_query->fields['discount_price'];
                } else {
                    $discounted_price = $display_specials_price - $products_discounts_query->fields['discount_price'];
                }
            }
            break;
    }

    return $discounted_price;
}


////
// are there discount quanties
function zen_get_discount_qty($product_id, $check_qty)
{
    global $db;

    $product_id = (int)$product_id;

    $discounts_qty_query = $db->Execute("select * from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id='" . (int)$product_id . "' and discount_qty != 0");
//echo 'zen_get_discount_qty: ' . $product_id . ' - ' . $check_qty . '<br />';
    if ($discounts_qty_query->RecordCount() > 0 and $check_qty > 0) {
        return true;
    } else {
        return false;
    }
}

////
// set the products_price_sorter
function zen_update_products_price_sorter($product_id)
{
    global $db;

    $products_price_sorter = zen_get_products_actual_price($product_id);

    $db->Execute("update " . TABLE_PRODUCTS . " set
                  products_price_sorter='" . zen_db_prepare_input($products_price_sorter) . "'
                  where products_id='" . (int)$product_id . "'");
}

////
// salemaker categories array
function zen_parse_salemaker_categories($clist)
{
    $clist_array = explode(',', $clist);

// make sure no duplicate category IDs exist which could lock the server in a loop
    $tmp_array = array();
    $n = sizeof($clist_array);
    for ($i = 0; $i < $n; $i++) {
        if (!in_array($clist_array[$i], $tmp_array)) {
            $tmp_array[] = $clist_array[$i];
        }
    }
    return $tmp_array;
}

////
// update salemaker product prices per category per product
function zen_update_salemaker_product_prices($salemaker_id)
{
    global $db;
    $zv_categories = $db->Execute("select sale_categories_selected from " . TABLE_SALEMAKER_SALES . " where sale_id = '" . (int)$salemaker_id . "'");

    $za_salemaker_categories = zen_parse_salemaker_categories($zv_categories->fields['sale_categories_selected']);
    $n = sizeof($za_salemaker_categories);
    for ($i = 0; $i < $n; $i++) {
        $update_products_price = $db->Execute("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id='" . (int)$za_salemaker_categories[$i] . "'");
        while (!$update_products_price->EOF) {
            zen_update_products_price_sorter($update_products_price->fields['products_id']);
            $update_products_price->MoveNext();
        }
    }
}


/* �õ�Discount Price Table��Table html����

 * Robbie wei

 * 2009-4-1  */

function zen_display_products_quantity_discount($product_id)
{
    global $db, $currencies;

    //$currencies = new currencies();
    $products_query = new stdClass();
    $products_query->fields = get_products_info_memcache((int)$product_id);
    //$products_query = $db->Execute("select products_discount_type, products_discount_type_from, products_price from " . TABLE_PRODUCTS . " where products_id='" . (int)$product_id . "'");
    $display_normal_price = zen_get_products_base_price($product_id);
    $display_sale_price = zen_get_products_special_price($product_id, false);
    @$ldc_special_discount = $display_sale_price / $display_normal_price;
    $products_discount_type = $products_query->fields["products_discount_type"];
    $products_discount_type_from = $products_query->fields["products_discount_type_from"];
    $origin_price = $products_query->fields["products_price"];

    $lc_text = '';
    if ($products_discount_type <> 0) {
        $products_id_current = $product_id;

        require(DIR_WS_MODULES . 'products_quantity_discounts.php');

        switch ($products_discount_type) {
            case '1':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE;
                break;
            case '2':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE;
                break;
            case '3':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF;
                break;
        }
        if ($display_specials_price) {
            $lc_text .= '<br /><div id="productQuantityDiscountsTitle"><table border="1" cellspacing="2" cellpadding="2">
								<tr>
									<td colspan="' . zen_output_string($columnCount + 1) . '" align="center">' . $header_text . '</td>' .
                '</tr>
								 <tr>';
            foreach ($quantityDiscounts as $key => $quantityDiscount) {
                $lc_text .= '<td align="center">' . $quantityDiscount['show_qty'] . '<br />' . '<span class="normalprice">' . $currencies->display_price($quantityDiscount['discounted_price'],
                        zen_get_tax_rate($products_tax_class_id)) . '</span><br />' . '<span class="productSpecialPrice">' . $currencies->display_price($quantityDiscount['discounted_price'] * $ldc_special_discount,
                        zen_get_tax_rate($products_tax_class_id)) . '</span></td>';
                $disc_cnt++;

                if ($discount_col_cnt == $disc_cnt && !($key == sizeof($quantityDiscount))) {
                    $disc_cnt = 0;
                    $disct_table .= '</tr><tr>';
                }
            }
        } else {
            $lc_text .= '<br /><div id="productQuantityDiscountsTitle"><table border="1" cellspacing="2" cellpadding="2">
						<tr>
							<td colspan="' . zen_output_string($columnCount + 1) . '" align="center">' . $header_text . '</td>' .
                '</tr>
						 <tr>';

            foreach ($quantityDiscounts as $key => $quantityDiscount) {
                $lc_text .= '<td align="center">' . $quantityDiscount['show_qty'] . '<br />'
                    . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</td>';
                $disc_cnt++;

                if ($discount_col_cnt == $disc_cnt && !($key == sizeof($quantityDiscount))) {
                    $disc_cnt = 0;
                    $disct_table .= '</tr><tr>';
                }
            }
        }

        if ($disc_cnt < $columnCount) {
            $lc_text .= '<td align="center" colspan=" ' . ($columnCount + 1 - $disc_cnt) + 1 . '"> &nbsp; </td>';
        }
        $lc_text .= '</tr>';

        if (zen_has_product_attributes($products_id_current)) {
            $lc_text .= '<tr>
					      <td colspan="' . ($columnCount + 1) . '" align="center"> ' . TEXT_FOOTER_DISCOUNT_QUANTITIES . '</td>
					    </tr>';
        }

        $lc_text .= '</table></div>';
    }

    return $lc_text;
}

//jessa 2010-05-03
function zen_display_products_quantity_discounts($product_id)
{
    global $db, $currencies;

    $products_query = new stdClass();
    $products_query->fields = get_products_info_memcache((int)$product_id);
    $display_normal_price = get_products_info_memcache($product_id, 'products_price');
    $display_sale_price = zen_get_products_special_price($product_id, false, $display_normal_price);
    @$ldc_special_discount = round($display_sale_price / $display_normal_price, 2);
    $origin_price = $products_query->fields["products_price"];
    $products_discount_type = $products_query->fields["products_discount_type"];
    $products_discount_type_from = $products_query->fields["products_discount_type_from"];
    $origin_price = $products_query->fields["products_price"];

    if ($ldc_special_discount == 0) {
        $ldc_special_discount = 1;
    }

    $lc_text = '';

    if ($products_discount_type <> 0) {
        $products_id_current = $product_id;
        require(DIR_WS_MODULES . 'products_quantity_discounts.php');

        if (count($quantityDiscounts) <= 1) {
            return "";
        }

        switch ($products_discount_type) {
            case '1':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE;
                break;
            case '2':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE;
                break;
            case '3':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF;
                break;
        }

        if ($display_specials_price) {
            $lc_text .= '<br /><table border="1" cellspacing="0" cellpadding="0" width="400" class="show_detail" style="border-collapse:collapse;border:1px solid #666;"><tr><td colspan="' . zen_output_string($columnCount + 1) . '" align="center" style="padding:5px 0px;">' . $header_text . '</td></tr><tr>';

            foreach ($quantityDiscounts as $key => $quantityDiscount) {
                $discounted_price = $quantityDiscount['discounted_price'];
                $daily_deal_price = get_daily_deal_price_by_products_id($products_id_current);
                if ($daily_deal_price) {
                    $discounted_price = $daily_deal_price;
                    $ldc_special_discount = 1;
                }

                $lc_text .= '<td align="center"><span>' . $quantityDiscount['show_qty'] . '</span><br />' . '<span class="linethrough">' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</span><br />' . '<span class="nprice">' . $currencies->display_price($discounted_price * $ldc_special_discount, zen_get_tax_rate($products_tax_class_id)) . '</span></td>';
                $disc_cnt++;
                if ($discount_col_cnt == $disc_cnt && !($key == sizeof($quantityDiscount))) {
                    $disc_cnt = 0;
                    $disct_table .= '</tr><tr>';
                }
            }
        } else {
            $lc_text .= '<br /><table border="1" cellspacing="0" cellpadding="0" width="400" class="show_detail" style="border-collapse:collapse;border:1px solid #666;"><tr><td colspan="' . zen_output_string($columnCount + 1) . '" align="center" style="padding:5px 0px;">' . $header_text . '</td></tr><tr>';
            //jessa eof

            foreach ($quantityDiscounts as $key => $quantityDiscount) {
                // var_dump($currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)));exit;
                $lc_text .= '<td align="center"><span>' . $quantityDiscount['show_qty'] . '</span><br />' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</td>';
                $disc_cnt++;
                if ($discount_col_cnt == $disc_cnt && !($key == sizeof($quantityDiscount))) {
                    $disc_cnt = 0;
                    $disct_table .= '</tr><tr>';
                }
            }
        }
        if ($disc_cnt < $columnCount) $lc_text .= '<td align="center" colspan=" ' . ($columnCount + 1 - $disc_cnt) + 1 . '"> &nbsp; </td>';
        $lc_text .= '</tr>';

        if (zen_has_product_attributes($products_id_current)) {
            $lc_text .= '<tr><td colspan="' . ($columnCount + 1) . '" align="center"> ' . TEXT_FOOTER_DISCOUNT_QUANTITIES . '</td></tr>';
        }
        $lc_text .= '</table>';
    }

    return $lc_text;
}

//eof jessa 2010-05-03

//	lvxiaoyong 1.30
function zen_display_products_quantity_discounts_new($product_id, $for_page = '')
{
    global $db, $currencies;
    $products_query = new stdClass();
    $products_query->fields = get_products_info_memcache((int)$product_id);
    //$products_query = $db->Execute("select products_discount_type, products_discount_type_from, products_price from " . TABLE_PRODUCTS . " where products_id='" . (int)$product_id . "'");
    $display_normal_price = zen_get_products_base_price($product_id);
    $display_sale_price = zen_get_products_special_price($product_id, false);
    @$ldc_special_discount = $display_sale_price / $display_normal_price;
    $origin_price = $products_query->fields["products_price"];
    if ($ldc_special_discount == 0) $ldc_special_discount = 1;
    //$currencies = new currencies();
    //$products_query = new stdClass();
    //$products_query->fields = get_products_info_memcache((int)$product_id);
    /* $products_query = $db->Execute("Select products_discount_type, products_discount_type_from, products_price
                                      From " . TABLE_PRODUCTS . "
                                     Where products_id='" . (int)$product_id . "'"); */
    $products_discount_type = $products_query->fields["products_discount_type"];

    $products_discount_type_from = $products_query->fields["products_discount_type_from"];
    $origin_price = $products_query->fields["products_price"];

    $lc_text = '';
    if ($products_discount_type <> 0) {
        $products_id_current = $product_id;
        require(DIR_WS_MODULES . 'products_quantity_discounts.php');

        switch ($products_discount_type) {
            case '1':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE;
                break;
            case '2':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE;
                break;
            case '3':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF;
                break;
        }

        switch ($for_page) {
            case 'product_listing':
                $lc_text .= '<table cellspacing="0" cellpadding="0"><tr><th colspan="' . zen_output_string($columnCount + 1) . '">' . $header_text . '</th></tr><tr>';
                if ($display_specials_price) {
                    foreach ($quantityDiscounts as $key => $quantityDiscount) {
                        $discounted_price = $quantityDiscount['discounted_price'];
                        //if(zen_is_promotion_price_time()){
                        if (get_products_promotion_price((int)$products_id_current)) {
                            $discounted_price = get_daily_deals_price((int)$products_id_current);
                            $ldc_special_discount = 1;
                        }
                        //}
                        $lc_text .= '<td><span class="grey">' . $quantityDiscount['show_qty'] . '</span><del>' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</del><ins>' . $currencies->display_price($discounted_price * $ldc_special_discount, zen_get_tax_rate($products_tax_class_id)) . '</ins></td>';
                    }
                } else {
                    foreach ($quantityDiscounts as $key => $quantityDiscount) {
                        $lc_text .= '<td><span class="grey">' . $quantityDiscount['show_qty'] . '</span>' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</td>';
                    }
                }
                $lc_text .= '</tr>';

                if (zen_has_product_attributes($products_id_current)) {
                    $lc_text .= '<tr><td colspan="' . ($columnCount + 1) . '" align="center"> ' . TEXT_FOOTER_DISCOUNT_QUANTITIES . '</td></tr>';
                }
                $lc_text .= '</table>';
                break;

            default:
                $lc_text .= '<br /><table border="1" cellspacing="0" cellpadding="0" width="400" class="show_detail" style="border-collapse:collapse;border:1px solid #666;"><tr><td colspan="' . zen_output_string($columnCount + 1) . '" align="center" style="padding:5px 0px;">' . $header_text . '</td></tr><tr>';

                if ($display_specials_price) {
                    foreach ($quantityDiscounts as $key => $quantityDiscount) {
                        $discounted_price = $quantityDiscount['discounted_price'];
                        //if(zen_is_promotion_price_time()){
                        if (get_products_promotion_price((int)$products_id_current)) {
                            $discounted_price = get_daily_deals_price((int)$products_id_current);
                            $ldc_special_discount = 1;
                        }
                        //}
                        $lc_text .= '<td align="center">' . $quantityDiscount['show_qty'] . '<br />' . '<span class="normalprice">' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</span><br />' . '<span class="productSpecialPrice">' . $currencies->display_price($discounted_price * $ldc_special_discount, zen_get_tax_rate($products_tax_class_id)) . '</span></td>';
                    }
                } else {
                    foreach ($quantityDiscounts as $key => $quantityDiscount) {
                        $lc_text .= '<td align="center" style="border:1px solid #666">' . $quantityDiscount['show_qty'] . '<br />'
                            . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</td>';
                    }
                }
                $lc_text .= '</tr>';

                if (zen_has_product_attributes($products_id_current)) {
                    $lc_text .= '<tr><td colspan="' . ($columnCount + 1) . '" align="center"> ' . TEXT_FOOTER_DISCOUNT_QUANTITIES . '</td></tr>';
                }
                $lc_text .= '</table>';
        }
    }

    return $lc_text;
}

function check_product_in_discountgroup($product_id)
{
    global $db;
    $product = new stdClass();
    $product = get_products_info_memcache((int)$product_id);
    //$product = $db->Execute("select products_price, products_model, products_priced_by_attribute from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    if (sizeof($product) > 0) {
        $product_price = zen_get_products_base_price($product_id);
        return 0;
    }

}

function get_ems_perg_fee()
{
    global $db;
    $lds_conf = $db->Execute("Select configuration_value
				            	    From " . TABLE_CONFIGURATION . "
				           		   Where configuration_key = 'EMS_UK2KG_FEE'");
    $ldc_ems2kg_fee = $lds_conf->fields['configuration_value'];
    $lds_conf = $db->Execute("Select configuration_value
				            	    From " . TABLE_CONFIGURATION . "
				           		   Where configuration_key = 'EMS_DISCOUNT'");
    $ldc_ems_dist = $lds_conf->fields['configuration_value'];
    $ldc_perg_fee = ($ldc_ems2kg_fee * $ldc_ems_dist) / 2000;
    return $ldc_perg_fee;
}

function zen_show_discount_amount($product_id)
{

    global $db, $currencies;
    if (!zen_not_null($product_id)) {
        return '';
    }
    $show_sale_discount = '';

    if (get_products_promotion_price($product_id)) {
        $show_sale_discount = '';
        return $show_sale_discount;
    }
    $show_sale_discount = get_products_discount_by_products_id($product_id);
    return $show_sale_discount;
}

/**
 * 获取单一商品最低折扣价或分段折扣价
 * @param type $product_id
 * @param type $limit 0=不限制||1=限制1个
 * @return mix
 * @global type $db
 */
function zen_get_products_quantity_discounts($product_id, $limit = 1)
{
    global $db;

    $limitStr = $limit ? 'limit 1' : '';
    $products_discount_quantity = $db->Execute("SELECT discount_price FROM  " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id = '" . $product_id . "' order by discount_qty asc {$limitStr}");

    if ($limit) {
        $products_price = $products_discount_quantity->fields['discount_price'];
    } else {
        $temp = array();
        while (!$products_discount_quantity->EOF) {
            $temp[] = $products_discount_quantity->fields['discount_price'];
            $products_discount_quantity->MoveNext();
        }
        return $temp;
    }
    return $products_price;
}

function zen_display_products_quantity_discounts_mobile($product_id, $smarty = null)
{
    global $db, $currencies;
    $products_query = new stdClass();
    $products_query->fields = get_products_info_memcache((int)$product_id);
    //$products_query = $db->Execute("select products_discount_type, products_discount_type_from, products_price from " . TABLE_PRODUCTS . " where products_id='" . (int)$product_id . "'");
    $display_normal_price = zen_get_products_base_price($product_id);
    $display_sale_price = zen_get_products_special_price($product_id, false);
    @$ldc_special_discount = $display_sale_price / $display_normal_price;
    $origin_price = $products_query->fields["products_price"];
    if ($ldc_special_discount == 0) $ldc_special_discount = 1;

    //$currencies = new currencies();
    $products_query = new stdClass();
    $products_query->fields = get_products_info_memcache((int)$product_id);
    /* $products_query = $db->Execute("Select products_discount_type, products_discount_type_from, products_price
                                    From " . TABLE_PRODUCTS . "
                                   Where products_id='" . (int)$product_id . "'"); */
    $products_discount_type = $products_query->fields["products_discount_type"];

    $products_discount_type_from = $products_query->fields["products_discount_type_from"];
    $origin_price = $products_query->fields["products_price"];

    $lc_text = '';

    if ($products_discount_type <> 0) {
        $products_id_current = $product_id;
        require(DIR_WS_MODULES . 'products_quantity_discounts.php');

        switch ($products_discount_type) {
            case '1':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE;
                break;
            case '2':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE;
                break;
            case '3':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF;
                break;
        }

        if ($smarty) {
            $price_template_file = DIR_WS_TEMPLATE . 'tpl/tpl_product_price_info.html';

            $price_infos = array();
            $is_promotion_price_time = true;//zen_is_promotion_price_time();
            $products_tax_class_rate = zen_get_tax_rate($products_tax_class_id);

            foreach ($quantityDiscounts as $key => $quantityDiscount) {
                $discounted_price = $quantityDiscount['discounted_price'];
                $price_info['orginal_discount_rate'] = $discounted_price;
                $price_info['show_qty'] = $quantityDiscount['show_qty'];


                if ($display_specials_price && $is_promotion_price_time) {
                    if (get_products_promotion_price((int)$products_id_current)) {
                        $discounted_price = get_daily_deals_price((int)$products_id_current);
                        $ldc_special_discount = 1;
                    }
                }

                $price_info['current_discount_rate'] = $discounted_price;
                $price_info['price_normal'] = $currencies->display_price($quantityDiscount['discounted_price'], $products_tax_class_rate);
                $price_info['price_final'] = $currencies->display_price($discounted_price * $ldc_special_discount, zen_get_tax_rate($products_tax_class_id));

                $price_info['price_is_same'] = $price_info['price_normal'] == $price_info['price_final'];

                $price_infos[] = $price_info;
            }

            $smarty->assign('products_discount_type', $products_discount_type);
            $smarty->assign('price_header_text', $header_text);
            $smarty->assign('display_specials_price', $display_specials_price);
            $smarty->assign('price_infos', $price_infos);
            //var_dump($price_infos);die();
            $lc_text = $smarty->fetch($price_template_file);
        } else {
            if ($display_specials_price) {
                $lc_text .= '<table class="pricetab"><tr><td colspan="' . zen_output_string($columnCount + 1) . '">' . $header_text . '</td></tr><tr>';
                foreach ($quantityDiscounts as $key => $quantityDiscount) {
                    $discounted_price = $quantityDiscount['discounted_price'];
                    //if(zen_is_promotion_price_time()){
                    if (get_products_promotion_price((int)$products_id_current)) {
                        $discounted_price = get_daily_deals_price((int)$products_id_current);
                        $ldc_special_discount = 1;
                    }
                    //}
                    $lc_text .= '<td><span>' . $quantityDiscount['show_qty'] . '</span><br />' . '<span class="linethrough">' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</span><br />' . '<span class="nprice">' . $currencies->display_price($discounted_price * $ldc_special_discount, zen_get_tax_rate($products_tax_class_id)) . '</span></td>';
                    $disc_cnt++;
                    if ($discount_col_cnt == $disc_cnt && !($key == sizeof($quantityDiscount))) {
                        $disc_cnt = 0;
                        $disct_table .= '</tr><tr>';
                    }
                }
            } else {
                $lc_text .= '<table class="pricetab"><tr><td colspan="' . zen_output_string($columnCount + 1) . '">' . $header_text . '</td></tr><tr>';
                foreach ($quantityDiscounts as $key => $quantityDiscount) {
                    $lc_text .= '<td><span>' . $quantityDiscount['show_qty'] . '</span><br />' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</td>';
                    $disc_cnt++;
                    if ($discount_col_cnt == $disc_cnt && !($key == sizeof($quantityDiscount))) {
                        $disc_cnt = 0;
                        $disct_table .= '</tr><tr>';
                    }
                }
            }
            if ($disc_cnt < $columnCount) $lc_text .= '<td colspan=" ' . ($columnCount + 1 - $disc_cnt) + 1 . '"> &nbsp; </td>';
            $lc_text .= '</tr>';

            if (zen_has_product_attributes($products_id_current)) {
                $lc_text .= '<tr><td colspan="' . ($columnCount + 1) . '"> ' . TEXT_FOOTER_DISCOUNT_QUANTITIES . '</td></tr>';
            }
            $lc_text .= '</table>';
        }

    }

    return $lc_text;
}

function zen_get_unit_price($products_id)
{
    global $db, $currencies;

    $min_price = zen_get_products_display_price_new($products_id, '', true);
    if (!$min_price) return false;

    // $min_price = $currencies->value($min_price);
    $max_price = 10;
    // $pack_query = $db->Execute("select p.per_pack_qty, pu.unit_name from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_UNIT_DESCRIPTION." pu
    // 			where p.min_unit=pu.unit_id
    // 			and p.products_id='".$products_id."'
    // 			and pu.languages_id='".$_SESSION['languages_id']."'");
    $display_unit_price = '';
    // if($pack_query->RecordCount()>0){
    // 	if($pack_query->fields['per_pack_qty']!=1){
    // 		$unit_price = $min_price/$pack_query->fields['per_pack_qty'];
    // 		$number_array = explode('.', $unit_price);

    // 		$unit_price = number_format(floor($unit_price*100)/100,2);
    // 		if(substr($number_array[1],2,1)>0){
    // 			$unit_price+=0.01;
    // 		}
    // 	}else{
    // 		$unit_price = $min_price;
    // 	}
    $display_unit_price .= sprintf(TEXT_UNIT_PRICE, $currencies->format_cl($min_price, false), $currencies->format_cl($max_price, false));
    // }
    return $display_unit_price;
}

//获取Daily Deals的产品单价
function get_daily_deals_price($product_id)
{
    return get_daily_deal_price_by_products_id($product_id);
//    global $db;
//    $daily_deals_product=$db->Execute("SELECT dp.dailydeal_price
//								FROM ".TABLE_DAILYDEAL_PROMOTION." dp
//								WHERE  dp.dailydeal_products_start_date <=  '". date('Y-m-d H:i:s') ."'
//								 AND dp.dailydeal_products_end_date >  '". date('Y-m-d H:i:s') ."'
//								AND dp.dailydeal_is_forbid =10
//    							AND dp.dailydeal_price>0
//  								AND dp.products_id = " . (int)$product_id);
//    //$daily_deals_product = $db->Execute("select dailydeal_price  from " . TABLE_DAILYDEAL_PROMOTION . " where products_id = '" . (int)$product_id . "' and dailydeal_price > 0");
//	$product_price = 0;
//    if ($daily_deals_product->RecordCount() > 0) {
//  	  $product_price = $daily_deals_product->fields['dailydeal_price'];      
//    }	
//	return $product_price;	
}

/**
 *
 * get_products_discount_by_products_id
 * @param int $products_id
 * return int
 * @author hongliu 2014-12-12
 */
function get_products_discount_by_products_id($products_id)
{
    global $db, $memcache;
    $products_id = intval($products_id);
    $products_discount = 0;

    $memcache_key = md5(MEMCACHE_PREFIX . 'get_products_discount_by_products_id' . $products_id);
    $data = $memcache->get($memcache_key);

    if (gettype($data) != 'boolean') {
        if (is_array($data) && $data['promotion_discount'] > 0 && $data['pp_promotion_start_time'] <= date('Y-m-d H:i:s') && $data['pp_promotion_end_time'] > date('Y-m-d H:i:s')) {
            $products_discount = (int)$data['promotion_discount'];
        }
    } else {
        $current_time = date('Y-m-d H:i:s');
        $promotion_discount_query = 'select p.promotion_discount,p.promotion_status,pp.pp_promotion_start_time,pp.pp_promotion_end_time from ' . TABLE_PROMOTION . ' p , ' . TABLE_PROMOTION_PRODUCTS . ' pp where pp.pp_products_id=' . $products_id . ' and pp.pp_promotion_id=p.promotion_id and pp.pp_is_forbid = 10 and p.promotion_status = 1 and pp.pp_promotion_end_time > "' . date('Y-m-d H:i:s') . '" limit 1';
        $promotion_discount = $db->Execute($promotion_discount_query);

        if ($promotion_discount->RecordCount() == 0) {
            $promotion_discount->fields = array();
        }
        $memcache->set($memcache_key, $promotion_discount->fields, false, 24 * 60 * 60);

        if ($promotion_discount->fields['promotion_discount'] > 0 && $promotion_discount->fields['pp_promotion_start_time'] <= date('Y-m-d H:i:s') && $promotion_discount->fields['pp_promotion_end_time'] > date('Y-m-d H:i:s')) {
            $products_discount = (int)$promotion_discount->fields['promotion_discount'];
        }
    }

    return $products_discount;

}

/*20151130*/
function get_dailydeal_discount_by_products_id($products_id)
{
    global $db, $memcache;
    $products_id = intval($products_id);
    $memcache_key = md5(MEMCACHE_PREFIX . 'get_dailydeal_discount_by_products_id' . $products_id);
//         if(!zen_is_promotion_time()){
//             return 0;
//         }else{
    $data = $memcache->get($memcache_key);
    if (is_array($data) && $data['dailydeal_is_forbid'] == 10 && $data['dailydeal_products_start_date'] <= date('Y-m-d H:i:s') && $data['dailydeal_products_end_date'] > date('Y-m-d H:i:s')) {
        $dailydeal = ($data['products_price'] - $data['dailydeal_price']) / $data['products_price'];
        return round($dailydeal * 100);
    } else if (!is_bool($data)) {
        return 0;
    }

    $dailydeal_discount_query = 'select dp.dailydeal_price,dp.dailydeal_products_start_date,dp.dailydeal_products_end_date,dp.dailydeal_is_forbid,p.products_price from  ' . TABLE_PRODUCTS . ' p , ' . TABLE_DAILYDEAL_PROMOTION . ' dp INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on dp.area_id = zda.dailydeal_area_id where dp.products_id=' . $products_id . ' and dp.products_id = p.products_id  and dailydeal_products_start_date <= "' . date('Y-m-d H:i:s') . '" AND dailydeal_products_end_date >= "' . date('Y-m-d H:i:s') . '" and dp.dailydeal_is_forbid = 10 and zda.area_status = 1 order by dp.products_id desc limit 1';
    $dailydeal_discount = $db->Execute($dailydeal_discount_query);
    if ($dailydeal_discount->RecordCount() == 0) {
        $dailydeal_discount->fields = array();
    }
    $memcache->set($memcache_key, $dailydeal_discount->fields, false, 86400 * 7);
    if ($dailydeal_discount->fields['dailydeal_is_forbid'] == 10 && $dailydeal_discount->fields['dailydeal_products_start_date'] <= date('Y-m-d H:i:s') && $dailydeal_discount->fields['dailydeal_products_end_date'] > date('Y-m-d H:i:s')) {
        $dailydeal = ($dailydeal_discount->fields['products_price'] - $dailydeal_discount->fields['dailydeal_price']) / $dailydeal_discount->fields['products_price'];
        return round($dailydeal * 100);
    } else {
        return 0;
    }
//         }
}

/**
 *
 * get_daily_deal_price_by_products_id
 * @param int $products_id
 * return int
 * @author hongliu 2014-12-12
 */
function get_daily_deal_price_by_products_id($products_id)
{
    global $db, $memcache;
    $products_id = intval($products_id);
    $dailydeal_price = 0;

    $memcache_key = md5(MEMCACHE_PREFIX . 'get_daily_deal_price_by_products_id' . $products_id);
    $data = $memcache->get($memcache_key);

    if (gettype($data) != 'boolean') {
        if (is_array($data) && $data['dailydeal_is_forbid'] == 10 && $data['dailydeal_products_start_date'] <= date('Y-m-d H:i:s') && $data['dailydeal_products_end_date'] > date('Y-m-d H:i:s')) {
            $dailydeal_price = $data['dailydeal_price'];
        }
    } else {
        $sql_date = $db->Execute("SELECT dailydeal_price,products_id,dp.dailydeal_products_start_date,dp.dailydeal_products_end_date,dp.dailydeal_is_forbid 
        								FROM " . TABLE_DAILYDEAL_PROMOTION . " dp INNER JOIN " . TABLE_DAILYDEAL_AREA . " zda on dp.area_id = zda.dailydeal_area_id 
        								WHERE dp.products_id = " . $products_id . " and dp.dailydeal_is_forbid = 10 and zda.area_status = 1 and now()<dp.dailydeal_products_end_date order by dp.dailydeal_products_start_date asc limit 1");
        if ($sql_date->RecordCount() == 0) {
            $sql_date = new stdClass();
            $sql_date->fields = array();
        } else {
            if ($sql_date->fields['dailydeal_is_forbid'] == 10 && $sql_date->fields['dailydeal_products_start_date'] <= date('Y-m-d H:i:s') && $sql_date->fields['dailydeal_products_end_date'] > date('Y-m-d H:i:s')) {
                $dailydeal_price = $sql_date->fields['dailydeal_price'];
            }
        }
        $memcache->set($memcache_key, $sql_date->fields, false, 24 * 60 * 60);
    }

    return $dailydeal_price;
}

function get_products_max_sale_price($products_id)
{
    global $db, $memcache;
    $memcache_key = md5(MEMCACHE_PREFIX . 'products_discount_quantity_modules' . $products_id);
    $data = $memcache->get($memcache_key);
    if ($data && sizeof($data) > 0) {
        $products_discounts_query = $data;
    } else {
        $products_discounts_result = $db->Execute("select * from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id='" . (int)$products_id . "' and discount_qty !=0 " . " order by discount_qty");
        if ($products_discounts_result->RecordCount() > 0) {
            while (!$products_discounts_result->EOF) {
                $products_discounts_query[] = array(
                    'discount_id' => $products_discounts_result->fields['discount_id'],
                    'products_id' => $products_discounts_result->fields['products_id'],
                    'discount_qty' => $products_discounts_result->fields['discount_qty'],
                    'discount_price' => $products_discounts_result->fields['discount_price']
                );
                $products_discounts_result->MoveNext();
            }

            $memcache->set($memcache_key, $products_discounts_query, false, 604800);
        }

    }
    return $products_discounts_query;
}

/**
 *
 * zen_refresh_products_price
 * copy from panadmin
 * return bool
 */
function zen_refresh_products_price($as_product_id, $adc_net_price, $adc_product_weight, $adc_price_times, $ab_special = false, $old_price = '', $update_option_array = array('insert' => false, 'record_log' => true, 'batch_update' => false, 'currrency_last_modified' => null))
{
    global $db;
    if ($update_option_array['batch_update'] && empty($update_option_array['currrency_last_modified'])) { // 如果批量update，必须指定时间
        return false;
    }

    $price_after_manager = $adc_net_price;
    $airmail_info = get_airmail_info();
    $ldc_perg_fee = MODULE_SHIPPING_AIRMAIL_ARGUMENT * $airmail_info['discount'] / 1000 / MODULE_SHIPPING_CHIANPOST_CURRENCY;
    $ldc_shipping_fee = $ldc_perg_fee * $adc_product_weight * $airmail_info['extra_times'];

    $products_model = get_products_info_memcache($as_product_id, 'products_model');
    $is_h_q_product = (substr($products_model, -1) == 'H' || substr($products_model, -1) == 'Q');

    if (!$is_h_q_product) {
        $price_manager_id = $db->Execute('select price_manager_id,products_model,products_price from ' . TABLE_PRODUCTS . ' where products_id = ' . $as_product_id . ' limit 1');

        $update = true;
        switch (true) {
            case ($adc_price_times >= 8) :
                $p1 = 0;
                $p2 = 0.125;
                $p3 = 0.25;
                break;
            case ($adc_price_times >= 4 && $adc_price_times < 8) :
                $p1 = 0.2;
                $p2 = 0.3;
                $p3 = 0.35;
                break;
            case ($adc_price_times >= 3.2 && $adc_price_times < 4) :
                $p1 = 0.13;
                $p2 = 0.19;
                $p3 = 0.31;
                break;
            case ($adc_price_times >= 2.8 && $adc_price_times < 3.2) :
                $p1 = 0;
                $p2 = 0.07;
                $p3 = 0.1;
                break;
            case ($adc_price_times >= 2.6 && $adc_price_times < 2.8) :
                $p1 = 0;
                $p2 = 0.08;
                $p3 = 0.15;
                break;
            case ($adc_price_times >= 2.4 && $adc_price_times < 2.6) :
                $p1 = 0;
                $p2 = 0.08;
                $p3 = 0.17;
                break;
            case ($adc_price_times >= 2.2 && $adc_price_times < 2.4) :
                $p1 = 0.09;
                $p2 = 0.18;
                $p3 = 0.2;
                break;
            case ($adc_price_times >= 2 && $adc_price_times < 2.2) :
                $p1 = 0.09;
                $p2 = 0.1;
                $p3 = 0.15;
                break;
            default:
                $p1 = 0;
                $p2 = 0;
                $p3 = 0;
                $update = false;
        }
        //$db->Execute('Delete from ' . TABLE_PRODUCTS_DISCOUNT_QUANTITY . ' Where products_id = ' . $as_product_id);
        if ($update_option_array['insert'] && $adc_price_times >= 2) {
            $update = false;
            $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
           (1, " . $as_product_id . ", 1, " . ($price_after_manager * (1 - $p1) + $ldc_shipping_fee) . ", now()),
           (2, " . $as_product_id . ", 3, " . ($price_after_manager * (1 - $p2) + $ldc_shipping_fee) . ", now()),
           (3, " . $as_product_id . ", 5, " . ($price_after_manager * (1 - $p3) + $ldc_shipping_fee) . ", now())");
        }

        $where_batch_update = "";
        if ($update_option_array['batch_update'] && !empty($update_option_array['currrency_last_modified'])) {
            $where_batch_update .= " and last_modified <= '" . $update_option_array['currrency_last_modified'] . "'";
        }

        if ($update) {
            $db->Execute("update " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " SET discount_price =  CASE discount_qty 
              WHEN 1 THEN " . ($price_after_manager * (1 - $p1) + $ldc_shipping_fee) . "
              WHEN 3 THEN " . ($price_after_manager * (1 - $p2) + $ldc_shipping_fee) . "
              WHEN 5 THEN " . ($price_after_manager * (1 - $p3) + $ldc_shipping_fee) . " 
              END,
              last_modified =  now() 
              WHERE products_id = " . $as_product_id . $where_batch_update
            );
        }
    } else {
        $db->Execute("DELETE FROM " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " WHERE products_id = " . $as_product_id);
        $price_after_manager = $adc_net_price;

        switch (true) {
            case ($adc_price_times >= 2.8 && $adc_price_times <= 4):
                $p1 = 0;
                $p2 = 0.21;
                $p3 = 0.32;

                $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                               (1, " . $as_product_id . ", 1, " . ($price_after_manager * (1 - $p1) + $ldc_shipping_fee) . ", now()),
                               (2, " . $as_product_id . ", 5, " . ($price_after_manager * (1 - $p2) + $ldc_shipping_fee) . ", now()),
                               (3, " . $as_product_id . ", 10, " . ($price_after_manager * (1 - $p3) + $ldc_shipping_fee) . ", now())");

                break;
            case ($adc_price_times >= 2.2 && $adc_price_times < 2.8):
                $p1 = 0;
                $p2 = 0.14;

                $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                               (1, " . $as_product_id . ", 1, " . ($price_after_manager * (1 - $p1) + $ldc_shipping_fee) . ", now()),
                               (2, " . $as_product_id . ", 3, " . ($price_after_manager * (1 - $p2) + $ldc_shipping_fee) . ", now())");
                break;
            case ($adc_price_times >= 2 && $adc_price_times < 2.2):
                $p1 = 0;
                $p2 = 0.05;

                $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                               (1, " . $as_product_id . ", 1, " . ($price_after_manager * (1 - $p1) + $ldc_shipping_fee) . ", now()),
                               (2, " . $as_product_id . ", 3, " . ($price_after_manager * (1 - $p2) + $ldc_shipping_fee) . ", now())");
                break;
            case ($adc_price_times >= 1.6 && $adc_price_times < 2):
            default:
                $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                                (1, " . $as_product_id . ", 1, " . ($price_after_manager + $ldc_shipping_fee) . ", now())"
                );
                break;
        }


    }

    $ldc_price = $price_after_manager + $ldc_shipping_fee;

    if ($adc_price_times == 0) {
        $db->Execute("Update " . TABLE_PRODUCTS . "
               Set products_quantity_order_min = 1,
                 products_discount_type_from = 1,
                 products_price = " . $ldc_price . ",
                 product_price_times = " . $adc_price_times . "
               Where products_id = " . $as_product_id);
    } else {
        $db->Execute("Update " . TABLE_PRODUCTS . "
                 Set products_quantity_order_min = 1,
                   products_discount_type = 2,
                   products_discount_type_from = 1,
                   products_price = " . $ldc_price . ",
                   product_price_times = " . $adc_price_times . "
                 Where products_id = " . $as_product_id);
        if ($ab_special) {
            zen_update_products_price_sorter($as_product_id);
        }
    }
    if ($update_option_array['record_log']) {
        $operate_content = '商品 products_price 变更: from ' . $price_manager_id->fields['products_price'] . ' to ' . $ldc_price . ' and products_net_price 变更: from ... ' . $adc_net_price . ' in ' . __FILE__ . ' on line: ' . __LINE__;
        zen_insert_operate_logs($_SESSION ['admin_id'], $price_manager_id->fields['products_model'], $operate_content, 2);
    }

    return true;
}

function show_products_price_area($product_id, $show_promotion_discount_price = false)
{
    global $db, $currencies;
    $return_info = array('show_content' => '', 'price_area' => '', 'is_simple_price' => false);
    $products_query = new stdClass();
    $products_query->fields = get_products_info_memcache((int)$product_id);
    $display_normal_price = zen_get_products_base_price($product_id);
    $display_sale_price = zen_get_products_special_price($product_id, false);
    @$ldc_special_discount = $display_sale_price / $display_normal_price;
    $origin_price = $products_query->fields["products_price"];
    if ($ldc_special_discount == 0) $ldc_special_discount = 1;
    $products_discount_type = $products_query->fields["products_discount_type"];

    $products_discount_type_from = $products_query->fields["products_discount_type_from"];
    $origin_price = $products_query->fields["products_price"];

    $lc_text = '';
    if ($products_discount_type <> 0) {
        $products_id_current = $product_id;
        require(DIR_WS_MODULES . 'products_quantity_discounts.php');

        switch ($products_discount_type) {
            case '1':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE;
                break;
            case '2':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE;
                break;
            case '3':
                $header_text = TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF;
                break;
        }


        $lc_text .= '<table border="1" cellspacing="0" cellpadding="0" width="500" class="show_detail" style="border-collapse:collapse;border:1px solid #666;"><tr><td colspan="' . zen_output_string($columnCount + 1) . '" align="center" style="padding:5px 0px;">' . $header_text . '</td></tr><tr>';

        if ($display_specials_price) {
            foreach ($quantityDiscounts as $key => $quantityDiscount) {
                $discounted_price = $quantityDiscount['discounted_price'];
                //if(zen_is_promotion_price_time()){
                if (get_products_promotion_price((int)$products_id_current)) {
                    $discounted_price = get_daily_deals_price((int)$products_id_current);
                    $ldc_special_discount = 1;
                }
                //}
                $lc_text .= '<td align="center">' . $quantityDiscount['show_qty'] . '<br />' . '<span class="normalprice">' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</span><br />' . '<span class="productSpecialPrice">' . $currencies->display_price($discounted_price * $ldc_special_discount, zen_get_tax_rate($products_tax_class_id)) . '</span></td>';
            }
        } else {
            foreach ($quantityDiscounts as $key => $quantityDiscount) {
                $lc_text .= '<td align="center" style="border:1px solid #666">' . $quantityDiscount['show_qty'] . '<br />'
                    . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</td>';
            }
        }
        $lc_text .= '</tr>';

        if (zen_has_product_attributes($products_id_current)) {
            $lc_text .= '<tr><td colspan="' . ($columnCount + 1) . '" align="center"> ' . TEXT_FOOTER_DISCOUNT_QUANTITIES . '</td></tr>';
        }
        $lc_text .= '</table>';

    }

    $return_info['show_content'] = $lc_text;
    $lowest_price_arr = array_pop($quantityDiscounts);

// 	    if(zen_is_promotion_price_time()){
    if (get_products_promotion_price((int)$products_id_current)) {
        $return_info['is_simple_price'] = true;
        $return_info['price_area'] = $currencies->display_price(get_daily_deals_price((int)$products_id_current), zen_get_tax_rate($products_tax_class_id));
    } else {

        $lowest_price = $currencies->display_price($lowest_price_arr['discounted_price'], zen_get_tax_rate($products_tax_class_id));
        $heightest_price = $currencies->display_price($quantityDiscounts[0]['discounted_price'], zen_get_tax_rate($products_tax_class_id));
        $heightest_price_arr = explode(' ', $heightest_price, 2);
        if ($_SESSION['currency'] != 'EUR') { //请注意这个特殊规则，价格符号位置不同引起的
            $heightest_price = trim($heightest_price_arr[1]);
        }

        $return_info['price_area'] = $lowest_price . '~' . $heightest_price;
    }
    if ($show_promotion_discount_price && get_products_discount_by_products_id((int)$products_id_current)) {

        $discount = get_products_discount_by_products_id((int)$products_id_current);

        $lowest_price = $currencies->display_price($lowest_price_arr['discounted_price'] * (1 - $discount / 100), zen_get_tax_rate($products_tax_class_id));
        $heightest_price = $currencies->display_price($quantityDiscounts[0]['discounted_price'] * (1 - $discount / 100), zen_get_tax_rate($products_tax_class_id));
        $heightest_price_arr = explode(' ', $heightest_price, 2);
        if ($_SESSION['currency'] != 'EUR') { //请注意这个特殊规则，价格符号位置不同引起的
            $heightest_price = trim($heightest_price_arr[1]);
        }

        $return_info['price_area_promotion'] = $lowest_price . '~' . $heightest_price;
    }
//   		}else{
//   			$lowest_price_arr = array_pop($quantityDiscounts);
//   			$lowest_price = $currencies->display_price($lowest_price_arr['discounted_price'], zen_get_tax_rate($products_tax_class_id));
//   			$heightest_price = $currencies->display_price($quantityDiscounts[0]['discounted_price'], zen_get_tax_rate($products_tax_class_id));
// 			$heightest_price_arr = explode(' ' , $heightest_price , 2);
// 	  		if($_SESSION['currency'] != 'EUR'){ //请注意这个特殊规则，价格符号位置不同引起的
// 				$heightest_price = trim($heightest_price_arr[1]);
// 			}

//   			$return_info['price_area'] = $lowest_price.'~'. $heightest_price;
//   		}

    return $return_info;

}

?>