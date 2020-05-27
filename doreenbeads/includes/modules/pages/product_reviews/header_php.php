<?php
/**
 * Product Reviews
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 3117 2006-03-05 20:38:44Z ajeh $
 */

  // This should be first line of the script:
  $zco_notifier->notify('NOTIFY_HEADER_START_PRODUCT_REVIEWS');

// check product exists and current
// if product does not exist or is status 0 send to _info page
    $products_reviews_check_query = "SELECT count(*) AS count
                                     FROM " . TABLE_PRODUCTS . " p
                                     WHERE p.products_id= :productsID
                                     AND p.products_status = 1";

    $products_reviews_check_query = $db->bindVars($products_reviews_check_query, ':productsID', $_GET['products_id'], 'integer');
    $products_reviews_check = $db->Execute($products_reviews_check_query);

    if ($products_reviews_check->fields['count'] < 1) {
      zen_redirect(zen_href_link('product_info', 'products_id=' . (int)$_GET['products_id']));
    }

  $review_query_raw = "SELECT p.products_id, p.products_price, p.products_tax_class_id, p.products_image, p.products_model, pd.products_name
                       FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                       WHERE p.products_id = :productsID
                       AND p.products_status = 1
                       AND p.products_id = pd.products_id
                       AND pd.language_id = :languagesID";

  $review_query_raw = $db->bindVars($review_query_raw, ':productsID', $_GET['products_id'], 'integer');
  $review_query_raw = $db->bindVars($review_query_raw, ':languagesID', $_SESSION['languages_id'], 'integer');
  $review = $db->Execute($review_query_raw);

  $products_price = zen_get_products_display_price($review->fields['products_id']);

  // bof Zen Lightbox v1.4 aclarke 2007-09-20
  $products_name_reviews_page = $review->fields['products_name'];
  // eof Zen Lightbox v1.4 aclarke 2007-09-20
  if (zen_not_null($review->fields['products_model'])) {
    $products_name = $review->fields['products_name'] . '<br /><span class="smallText">[' . $review->fields['products_model'] . ']</span>';
  } else {
    $products_name = $review->fields['products_name'];
  }

// set image
//  $products_image = $review->fields['products_image'];
  if ($review->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
    $products_image = PRODUCTS_IMAGE_NO_IMAGE;
  } else {
    $products_image = $review->fields['products_image'];
  }

  $review_status = " and r.status = 1";

  $reviews_query_raw = "SELECT r.reviews_id, rd.reviews_text as reviews_text, r.reviews_rating, r.date_added, r.customers_id, r.customers_name, rd.reviews_reply_text 
                        FROM " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
                        WHERE r.products_id = :productsID
                        AND r.reviews_id = rd.reviews_id
                        AND rd.languages_id = :languagesID " . $review_status . "
                        ORDER BY r.reviews_id desc";

  $reviews_query_raw = $db->bindVars($reviews_query_raw, ':productsID', $_GET['products_id'], 'integer');
  $reviews_query_raw = $db->bindVars($reviews_query_raw, ':languagesID', $_SESSION['languages_id'], 'integer');
  $reviews_split = new splitPageResults($reviews_query_raw, MAX_DISPLAY_NEW_REVIEWS);
  $reviews = $db->Execute($reviews_split->sql_query);
  $reviewsArray = array();
  while (!$reviews->EOF) {
  	$customer_info = zen_get_customers_info($reviews->fields['customers_id']);
  	$nameArray = explode(" ", $reviews->fields['customers_name']);
    array_pop($nameArray);
    $reviews->fields['customers_name'] = implode($nameArray).',&nbsp;' . $customer_info['default_country'];
  	$reviewsArray[] = array('id'=>$reviews->fields['reviews_id'],
  	                        'customersName'=>$reviews->fields['customers_name'],
  	                        'dateAdded'=>$reviews->fields['date_added'],
  	                        'reviewsText'=>$reviews->fields['reviews_text'],
  	                        'reviewsRating'=>$reviews->fields['reviews_rating'],
  	                        'reviews_reply_text'=>$reviews->fields['reviews_reply_text']);
    $reviews->MoveNext();
  }


  $sql = "select count(*) as total
          from " . TABLE_PRODUCTS . " p, " .
                   TABLE_PRODUCTS_DESCRIPTION . " pd
          where    p.products_status = '1'
          and      p.products_id = '" . (int)$_GET['products_id'] . "'
          and      pd.products_id = p.products_id
          and      pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";


  $res = $db->Execute($sql);

  if ( $res->fields['total'] < 1 ) {

    $tpl_page_body = '/tpl_product_info_noproduct.php';

  } else {

    $tpl_page_body = '/tpl_product_info_display.php';


    $sql = "select p.products_id, pd.products_name,
                   p.products_model,
                  p.products_quantity, p.products_image,
                  pd.products_url, p.products_price,
                  p.products_tax_class_id, p.products_date_added,
                  p.products_date_available, p.manufacturers_id, p.products_quantity,
                  p.products_weight, p.products_priced_by_attribute, p.product_is_free,
                  p.products_qty_box_status,
                  p.products_quantity_order_max,
                  p.products_volume_weight,
                  p.products_discount_type, p.products_discount_type_from, p.products_sort_order, p.products_price_sorter
           from   " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
           where  p.products_status = '1'
           and    p.products_id = '" . (int)$_GET['products_id'] . "'
           and    pd.products_id = p.products_id
           and    pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";

    $product_info = $db->Execute($sql);

    $products_price_sorter = $product_info->fields['products_price_sorter'];

    $products_price = $currencies->display_price($product_info->fields['products_price'],
                      zen_get_tax_rate($product_info->fields['products_tax_class_id']));

    $manufacturers_name= zen_get_products_manufacturers_name((int)$_GET['products_id']);

    if ($new_price = zen_get_products_special_price($product_info->fields['products_id'])) {

      $specials_price = $currencies->display_price($new_price,
                        zen_get_tax_rate($product_info->fields['products_tax_class_id']));

    }
  }
  $products_name = $product_info->fields['products_name'];
  $products_model = $product_info->fields['products_model'];
  $products_weight = $product_info->fields['products_weight'];
  $products_quantity = $product_info->fields['products_quantity'];

  $products_discount_type = $product_info->fields['products_discount_type'];	

  require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
  $breadcrumb->add(NAVBAR_TITLE);

  // This should be last line of the script:
  $zco_notifier->notify('NOTIFY_HEADER_END_PRODUCT_REVIEWS');
?>