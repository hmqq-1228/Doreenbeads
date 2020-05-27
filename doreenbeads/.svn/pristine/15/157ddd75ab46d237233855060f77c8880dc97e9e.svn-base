<?php
/**
 * product_listing module
 *
 * @package modules
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: product_listing.php 4655 2006-10-02 01:02:38Z ajeh $
 * UPDATED TO WORK WITH COLUMNAR PRODUCT LISTING For Zen Cart v1.3.6 - 10/25/2006
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
// Column Layout Support originally added for Zen Cart v 1.1.4 by Eric Stamper - 02/14/2004
// Upgraded to be compatible with Zen-cart v 1.2.0d by Rajeev Tandon - Aug 3, 2004
// Column Layout Support (Grid Layout) upgraded for v1.3.0 compatibility DrByte 04/04/2006
//
if (!defined('PRODUCT_LISTING_LAYOUT_STYLE')) define('PRODUCT_LISTING_LAYOUT_STYLE','rows');
if (!defined('PRODUCT_LISTING_COLUMNS_PER_ROW')) define('PRODUCT_LISTING_COLUMNS_PER_ROW',3);
$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

$max_results = (PRODUCT_LISTING_LAYOUT_STYLE=='columns' && PRODUCT_LISTING_COLUMNS_PER_ROW>0) ? (PRODUCT_LISTING_COLUMNS_PER_ROW * (int)(MAX_DISPLAY_PRODUCTS_LISTING/PRODUCT_LISTING_COLUMNS_PER_ROW)) : MAX_DISPLAY_PRODUCTS_LISTING;


$show_submit = zen_run_normal();
//$number_of_products_per_page = isset($_SESSION['per_page']) ? $_SESSION['per_page'] : 48;
//$search_offset = ($current_page-1) * $item_per_page;
//
//$solrConfig = simplexml_load_file("panadmin/solrConfig.xml");
//include_once("solrclient/Apache/Solr/Service.php");
//$solrCore = "/solr/dorabeads_".$solrConfig->config->switch;
//$solr = new Apache_Solr_service('localhost' , '8080' ,$solrCore);
//if (!$solr->ping()) {
//    die("sorry, search have some problem,please visit a moment later");
//}
//switch ($_GET ['disp_order']) {
//    case 3:
//        $search_sort = 'products_price asc';
//        break;
//    case 4:
//        $search_sort = 'products_price desc';
//        break;
//    case 5:
//        $search_sort = 'products_model desc';
//        break;
//    case 6:
//        $search_sort = 'products_date_added desc';
//        break;
//    case 7:
//        $search_sort = 'products_date_added desc';
//        break;
//    default:
//        $search_sort = '';
//        break;
//}
//$keywords_special_array = array('^','*','#','~','@','!','$','%','&','(',')','_','+','=','<','>','/','{','}','[',']','\\','|','`');
//foreach($keywords_special_array as $single_char){
//        if(stristr($keywords,$single_char)){
//                $error = true;
//                break;
//        }
//}
//if ($error == true) {
//        $solr_res->response->numFound = 0;
//}else{
//        $solr_search_words = strtolower($keywords);
////        if(isset($_GET ['categories_id']) && $_GET ['categories_id']!='') $solr_search_words.=" AND categories_id:".$_GET ['categories_id'];
//        $solr_res = $solr->search($solr_search_words , $search_offset ,$number_of_products_per_page,array('sort' => $search_sort));
//}
//$listing_split = new splitPageResults('', $number_of_products_per_page, '', 'page',false,$solr_res->response->numFound);
//echo '<pre>';
//print_r($listing_split);
//echo '</pre>';
//original_$listing_split
//$listing_split = new splitPageResults($listing_sql, $number_of_products_per_page, 'p.products_id', 'page');
$how_many = 0;

// Begin Row Layout Header
if (PRODUCT_LISTING_LAYOUT_STYLE == 'rows') {		// For Column Layout (Grid Layout) add on module

  $list_box_contents[0] = array('params' => 'class="productlist_title"');

  $zc_col_count_description = 0;
  $lc_align = '';
  for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    switch ($column_list[$col]) {
      case 'PRODUCT_LIST_MODEL':
        $lc_text = TABLE_HEADING_MODEL;
        $lc_align = '';
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_NAME':
        $lc_text = TABLE_HEADING_PRODUCTS;
        $lc_align = '';
        $lc_params = 'class="productItemtit"';
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $lc_text = TABLE_HEADING_MANUFACTURER;
        $lc_align = '';
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_PRICE':
        $lc_text = TABLE_HEADING_PRICE;
        $lc_align = 'right' . (PRODUCTS_LIST_PRICE_WIDTH > 0 ? '" width="' . PRODUCTS_LIST_PRICE_WIDTH : '');
        $lc_params = 'class="productpricetit"';
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $lc_text = TABLE_HEADING_QUANTITY;
        $lc_align = 'right';
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $lc_text = TABLE_HEADING_WEIGHT;
        $lc_align = 'right';
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_IMAGE':
        $lc_text = TABLE_HEADING_IMAGE;
        $lc_align = 'center';
        $lc_params = 'class="productimgtit"';
        $zc_col_count_description++;
        break;
    }

    if ( ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
      $lc_text = zen_create_sort_heading($_GET['sort'], $col+1, $lc_text);
    }

    $list_box_contents[0][$col] = array('align' => $lc_align,
                                        'params' => $lc_params,
                                        'text' => $lc_text );
  }

} // End Row Layout Header used in Column Layout (Grid Layout) add on module

/////////////  HEADER ROW ABOVE /////////////////////////////////////////////////

$num_products_count = $listing_split->number_of_rows;

if ($listing_split->number_of_rows > 0) {
  $rows = 0;
  // Used for Column Layout (Grid Layout) add on module
  $column = 0;	
  if (PRODUCT_LISTING_LAYOUT_STYLE == 'columns') {
    if ($num_products_count < PRODUCT_LISTING_COLUMNS_PER_ROW || PRODUCT_LISTING_COLUMNS_PER_ROW == 0 ) {
      $col_width = floor(100/$num_products_count);
    } else {
      $col_width = floor(100/PRODUCT_LISTING_COLUMNS_PER_ROW);
    }
  }
  // Used for Column Layout (Grid Layout) add on module


//  $listing = $db->Execute($listing_split->sql_query);
  $extra_row = 0;
//  while (!$listing->EOF) {
  foreach ($solr_res->response->docs as $doc) {
  	// add by zale 
	$page_name = "product_listing";
    $page_type = 4;
//    echo '<pre>';
//    print_r($_SESSION['cart']);
//    echo '<pre>';
    if($_SESSION['cart']->in_cart($doc->products_id)){		//if item already in cart
    	$procuct_qty = $_SESSION['cart']->get_quantity($doc->products_id);
    	$bool_in_cart = 1;
    }else {
    	$procuct_qty = 0;
    	$bool_in_cart = 0;
    }
    //eof
    if (PRODUCT_LISTING_LAYOUT_STYLE == 'rows') { // Used in Column Layout (Grid Layout) Add on module
      $rows++;

//       if ((($rows-$extra_row)/2) == floor(($rows-$extra_row)/2)) {
//         $list_box_contents[$rows] = array('params' => 'class="productListing-even"');
//       } else {
//         $list_box_contents[$rows] = array('params' => 'class="productListing-odd"');
//       }
      $list_box_contents[$rows] = array('params' => 'class="productlist_cont"');
      $cur_row = sizeof($list_box_contents) - 1;
    }   // End of Conditional execution - only for row (regular style layout)

    $product_contents = array(); // Used For Column Layout (Grid Layout) Add on module

    for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
      $lc_align = '';

      switch ($column_list[$col]) {
        case 'PRODUCT_LIST_MODEL':
          $lc_align = '';
          $lc_text = $doc->products_model;
          break;
        case 'PRODUCT_LIST_NAME':
          $lc_align = '';
          $lc_params = 'class="productItem"';
          
          $lc_text = '<div class="proimgdetail"><span class="arrowimg"></span><p><img></p></div>';
          $lc_text .= '<p class="productdes"><a href="' . zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $doc->products_id) . '">' . $doc->products_name . '</a></p>';          
          
		  //jessa 2010-01-29 ��ʼ��ʾ��Ʒ�ļ۸��
		 //��ĺ���zen_display_products_quantity_discountΪzen_display_products_quantity_discounts��ͳһ��� Robbie
		  if (zen_display_products_quantity_discounts($doc->products_id) != ''){
		  	$lc_text .= zen_display_products_quantity_discounts($doc->products_id);
		  }else{
		  	$lc_text .= '<span style="display:block; text-align:left;font-weight:bold;color:#9F1C00">Price: ' . zen_get_products_display_price($doc->products_id) . '</span>';
		  }		  
		  //eof jessa 2010-01-29
		  
		  $lc_text .= '<p>' . TEXT_MODEL . ': ' . $doc->products_model;
          break;
        case 'PRODUCT_LIST_MANUFACTURER':
          $lc_align = '';
          $lc_text = '<a href="' . zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing->fields['manufacturers_id']) . '">' . $listing->fields['manufacturers_name'] . '</a>';
          break;
        case 'PRODUCT_LIST_PRICE':
          $lc_params = 'class="productprice"';
          $lc_price = '<span class="listingPrice">' . zen_get_products_display_price($doc->products_id) . '</span>';
//		  $lc_price = '';
          $lc_align = 'right';
          
          //ֻ��Special�ļ۸����Add to chart����ʾ robbie
          $product_specials = $db->execute('Select products_discount_type From ' . TABLE_PRODUCTS . ' Where products_id = ' . $doc->products_id);
          if ($product_specials->RecordCount() > 0) {
          	 if ($product_specials->fields['products_discount_type'] <> 0 and strpos($lc_price, 'off') < 1) $lc_price = '';
          }
          
          $lc_text =  $lc_price;

          // more info in place of buy now
          $lc_button = '';
          if (zen_has_product_attributes($doc->products_id) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {
            $lc_button = '<a href="' . zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $doc->products_id) . '">' . MORE_INFO_TEXT . '</a>';
          } else {
            if (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART != 0) {
            if (
                // not a hide qty box product
                $doc->products_qty_box_status != 0 &&
                // product type can be added to cart
                zen_get_products_allow_add_to_cart($doc->products_id) != 'N'
                &&
                // product is not call for price
                $doc->product_is_call == 0
                &&
                // product is in stock or customers may add it to cart anyway
                ($doc->products_quantity > 0 || SHOW_PRODUCTS_SOLD_OUT_IMAGE == 0) ) {
                    $how_many++;
                  }
            // hide quantity box
            if ($doc->products_qty_box_status == 0) {
              $lc_button = '<p class="productadd"><a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $doc->products_id) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"') . '</a></p>';
            } else {
              $lc_button = '<p class="productadd">Add:<input type="text" id="' . $page_name  .'_' . $doc->products_id . '" name="products_id[' . $doc->products_id . ']" value="' . ($bool_in_cart ? $procuct_qty : $doc->products_quantity_order_min) . '" class="addinput" size="6"/><input type="hidden" id="MDO_' . $doc->products_id . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $doc->products_id . '" value="'.$procuct_qty.'" /></p>';
              
			  $lc_button .= '<p class="addbtn">' . zen_image_submit('button_in_cart_green.gif', BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submitp_' . $doc->products_id . '" name="submitp_' .  $doc->products_id . '" onclick="Addtocart('.$doc->products_id.','.$page_type.'); return false;" name="submitp_' . $doc->products_id . '" class="addcartbtn"') . '</p>';
			  
			  //eof jessa 2010-01-29
            }
          } else {
// qty box with add to cart button
	            if (PRODUCT_LIST_PRICE_BUY_NOW == '2' && $doc->products_qty_box_status != 0) {
	              $lc_button= zen_draw_form('cart_quantity', zen_href_link('product_info', zen_get_all_get_params(array('action')) . 'action=add_product&products_id=' . $doc->products_id), 'post', 'enctype="multipart/form-data"') . '<input type="text" id="'.$page_name.'_'.$doc->products_id.'" name="cart_quantity" value="' . (zen_get_buy_now_qty($doc->products_id)) . '" maxlength="6" size="4" /><input type="hidden" id="MDO_' . $doc->products_id . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $doc->products_id . '" value="'.$procuct_qty.'" /><br />' . zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT, 'id="submitp_' . $doc->products_id . '" onclick="Addtocart('.$doc->products_id.','.$page_type.'); return false;" name="submitp_' . $doc->products_id . '" name="submitp_' . $doc->products_id . '"') . '</form>';
	            } else {
	              $lc_button = '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $doc->products_id) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"') . '</a>';
	            }
            }
          }
          $the_button = $lc_button;
        $products_link = '<a href="' . zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $doc->products_id) . '">' . MORE_INFO_TEXT . '</a>';
          $lc_text .= zen_get_buy_now_button($doc->products_id, $the_button, $products_link) . '<p style="text-align:center;">'.zen_get_products_quantity_min_units_display($doc->products_id).'</p>';
          $lc_text .= '' . (zen_get_show_product_switch($doc->products_id, 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') ? (zen_get_product_is_always_free_shipping($doc->products_id) ? TEXT_PRODUCT_FREE_SHIPPING_ICON . '<br />' : '') : '');
	         
		  //jessa 2010-08-16 add wishlist 
		  if ($current_page != FILENAME_ADVANCED_SEARCH_RESULT){
	          $lc_text .= '<script type="text/javascript">document.write(\'<p class="addwishlist">' . zen_image_submit('button_in_wishlist_green.gif', 'wishlist', 'class="addwishlistbutton" id="wishlist_' . $doc->products_id . '" name="wishlist_' . $doc->products_id . '" onclick="Addtowishlist(' . $doc->products_id . ','.$page_type.'); return false;"') . '</p>\')</script>' . "\n";
	          $lc_text .= '<noscript><div style="margin-right:-5px;"><a href="' . zen_href_link('wishlist', 'action=addwishlist&pid=' . $doc->products_id) . '">' . zen_image_button('button_in_wishlist_green.gif', 'addwishlist') . '</a></div></noscript>';
		  } else {
		  	//$lc_text .= '<div class="addwishlist" style="margin-right:-5px;"><a href="' . zen_href_link('wishlist', 'action=addwishlist&pid=' . $doc->products_id) . '">' . zen_image_button('button_in_wishlist_green.gif', 'addwishlist') . '</a></div>';
		  }
          //eof jessa 2010-08-16
		  //on 2010-12-12 add products ratings reviews
          if (zen_get_product_rating($doc->products_id) != 0){
          	$lc_text .= '<div>
          				  <table border="0" cellpadding="0" cellspacing="0" width="100%">
						    <tr>
						      <td colspan="2" style="padding:3px 0px;padding-left:30px;text-align:left;"><a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . $doc->products_id) . '" target="_blank">' . 'Read all reviews</a></td>
						    </tr>
						    <tr>
						      <td colspan="2" style="padding:3px 0px;padding-left:30px;text-align:left;"><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $doc->products_id) . '#reviewsWritemodule' . '">' . 'Write a review</a></td>
						    </tr>
          				  </table>
          				 </div>';
          } else {
          	$lc_text .= '<div style="">
          				   <table border="0" cellpadding="0" cellspacing="0" width="100%">
          				     <tr>
          				       <td style="padding:3px 0px;padding-left:30px;text-align:left;">Be the first to</td>
          				     </tr>
          				     <tr>
          				       <td style="padding:3px 0px;padding-left:30px;text-align:left;"><a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $doc->products_id) . '#reviewsWritemodule' . '">Write a review</a></td>
          				     </tr>
          				   </table>
          				 </div>';
          }
          //eof 2010-12-12
          break;
        case 'PRODUCT_LIST_QUANTITY':
          $lc_align = 'right';
          $lc_text = $listing->fields['products_quantity'];
          break;
        case 'PRODUCT_LIST_WEIGHT':
          $lc_align = 'right';
          $lc_text = $listing->fields['products_weight'];
          break;
        case 'PRODUCT_LIST_IMAGE':
        	$lc_params = 'class="productimg"';
          $lc_align = 'center';
        if ($doc->products_image == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) {
          $lc_text = '';
        } else {
          $lc_text = '<a  href="' . zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $doc->products_id) . '"><img src="includes/templates/cherry_zen/images/loading2.gif" data-original="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($doc->products_image, 130, 130) . '" width="110" height="110" class="lazy" id="anchor' . $doc->products_id . '"></a>';
        }
		//add the products model jessa 2010-01-29
          break;
      }

      $product_contents[] = $lc_text; // Used For Column Layout (Grid Layout) Option

      if (PRODUCT_LISTING_LAYOUT_STYLE == 'rows') {
        $list_box_contents[$rows][$col] = array('align' => $lc_align,
        										'product_id'=>$doc->products_id,	
                                                'params' => $lc_params,
                                                'text'  => $lc_text);
      }
    }

    // add description and match alternating colors
    //if (PRODUCT_LIST_DESCRIPTION > 0) {
    //  $rows++;
    //  if ($extra_row == 1) {
    //    $list_box_description = "productListing-data-description-even";
    //    $extra_row=0;
    //  } else {
    //    $list_box_description = "productListing-data-description-odd";
    //    $extra_row=1;
    //  }
    //  $list_box_contents[$rows][] = array('params' => 'class="' . $list_box_description . '" colspan="' . $zc_col_count_description . '"',
    //  'text' => zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($doc->products_id, $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION));
    //}

    // Following code will be executed only if Column Layout (Grid Layout) option is chosen
    if (PRODUCT_LISTING_LAYOUT_STYLE == 'columns') {
      $lc_text = implode('', $product_contents);
      $list_box_contents[$rows][$column] = array('params' => 'class="centerBoxContentsProducts centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
      											 'product_id'=>$doc->products_id,
                                                 'text'  => $lc_text);
      $column ++;
      if ($column >= PRODUCT_LISTING_COLUMNS_PER_ROW) {
        $column = 0;
        $rows ++;
      }
    }
    // End of Code fragment for Column Layout (Grid Layout) option in add on module
//    $listing->MoveNext();
  }
  $error_categories = false;
} else {
  $list_box_contents = array();

  $list_box_contents[0] = array('params' => 'class="productListing-odd"');
  $list_box_contents[0][] = array('params' => 'class="productListing-data"',
                                  'text' => TEXT_NO_PRODUCTS);

  $error_categories = true;
}
//echo '<pre>';
//print_r($list_box_contents);
//echo '</pre>';

if (($how_many > 0 and $show_submit == true and $listing_split->number_of_rows > 0) and (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART == 1 or  PRODUCT_LISTING_MULTIPLE_ADD_TO_CART == 3) ) {
  $show_top_submit_button = true;
} else {
  $show_top_submit_button = false;
}
if (($how_many > 0 and $show_submit == true and $listing_split->number_of_rows > 0) and (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART >= 2) ) {
  $show_bottom_submit_button = true;
} else {
  $show_bottom_submit_button = false;
}
?>