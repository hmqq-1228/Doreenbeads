<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: general.php 14753 2009-11-07 19:58:13Z drbyte $
 */

////
// Redirect to another page or site
  function zen_redirect($url) {
    global $logger;

// clean up URL before executing it
    while (strstr($url, '&&')) $url = str_replace('&&', '&', $url);
    while (strstr($url, '&amp;&amp;')) $url = str_replace('&amp;&amp;', '&amp;', $url);
    // header locates should not have the &amp; in the address it breaks things
    while (strstr($url, '&amp;')) $url = str_replace('&amp;', '&', $url);

    if(strpos($url , 'login') !== false){
    	if(strpos($url , '?')){
    		$connect_symbol = '&';
    	}else{
    		$connect_symbol = '?';
    	}
    	if (ENABLE_SSL ) {
    		$url .= $connect_symbol . 'redirect_url=' . urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    	}else {
    		$url .= $connect_symbol . 'redirect_url=' . urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    	}
    }
    
    header('Location: ' . $url);

    if (STORE_PAGE_PARSE_TIME == 'true') {
      if (!is_object($logger)) $logger = new logger;
      $logger->timer_stop();
    }

    exit;
  }

////
// Parse the data used in the html tags to ensure the tags will not break
  function zen_parse_input_field_data($data, $parse) {
    return strtr(trim($data), $parse);
  }


  function zen_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
      return htmlspecialchars($string);
    } else {
      if ($translate == false) {
        return zen_parse_input_field_data($string, array('"' => '&quot;'));
      } else {
        return zen_parse_input_field_data($string, $translate);
      }
    }
  }


  function zen_output_string_protected($string) {
    return zen_output_string($string, false, true);
  }


  function zen_sanitize_string($string) {
    $string = ereg_replace(' +', ' ', $string);

    return preg_replace("/[<>]/", '_', $string);
  }


  function zen_customers_name($customers_id) {
    global $db;
    $customers_values = $db->Execute("select customers_firstname, customers_lastname
                               from " . TABLE_CUSTOMERS . "
                               where customers_id = '" . (int)$customers_id . "'");

    return $customers_values->fields['customers_firstname'] . ' ' . $customers_values->fields['customers_lastname'];
  }


  function zen_get_path($current_category_id = '') {
    global $cPath_array, $db;
// set to 0 if Top Level
    if ($current_category_id == '') {
      if (empty($cPath_array)) {
        $cPath_new= '';
      } else {
        $cPath_new = implode('_', $cPath_array);
      }
    } else {
      if (sizeof($cPath_array) == 0) {
        $cPath_new = $current_category_id;
      } else {
        $cPath_new = '';
        $last_category = $db->Execute("select parent_id
                                       from " . TABLE_CATEGORIES . "
                                       where categories_id = '" . (int)$cPath_array[(sizeof($cPath_array)-1)] . "'");

        $current_category = $db->Execute("select parent_id
                                          from " . TABLE_CATEGORIES . "
                                           where categories_id = '" . (int)$current_category_id . "'");

        if ($last_category->fields['parent_id'] == $current_category->fields['parent_id']) {
          for ($i = 0, $n = sizeof($cPath_array) - 1; $i < $n; $i++) {
            $cPath_new .= '_' . $cPath_array[$i];
          }
        } else {
          for ($i = 0, $n = sizeof($cPath_array); $i < $n; $i++) {
            $cPath_new .= '_' . $cPath_array[$i];
          }
        }

        $cPath_new .= '_' . $current_category_id;

        if (substr($cPath_new, 0, 1) == '_') {
          $cPath_new = substr($cPath_new, 1);
        }
      }
    }

    return 'cPath=' . $cPath_new;
  }


  function zen_get_all_get_params($exclude_array = '') {
    global $_GET;

    if ($exclude_array == '') $exclude_array = array();

    $get_url = '';

    reset($_GET);
    while (list($key, $value) = each($_GET)) {
      if (($key != zen_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array))) $get_url .= $key . '=' . $value . '&';
    }

    return $get_url;
  }


  function zen_date_long($raw_date) {
    if ( ($raw_date == '0001-01-01 00:00:00') || ($raw_date == '') ) return false;

    $year = (int)substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

    return strftime(DATE_FORMAT_LONG, mktime($hour, $minute, $second, $month, $day, $year));
  }

  function zen_date_long_order($raw_date,$lang) {
    if ( ($raw_date == '0001-01-01 00:00:00') || ($raw_date == '') ) return false;
    global $time_months;
  global $time_days;
    $year = (int)substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
  $dayNum=(int)date("w", strtotime($raw_date))-1;
  $monthNum= $month-1;
    $languageId=$lang;
    $longtime=$time_days[$languageId][$dayNum]." ".$day ." ".$time_months[$languageId][$monthNum].",".$year;
    if ((int)$languageId == 5) {
      $array_days = array('一', '二', '三', '四', '五', '六', '七', '八', '九', '十');
      if ($day > 10) {
        $days = $array_days[floor($day / 10) - 1] . '十' . $array_days[$day % 10 - 1];
      }else{
        $days = $array_days[$day - 1];
      }
      $longtime=$year . '年 '.$time_months[$languageId][$monthNum] . ' ' . $days ." 日";
    }
    return $longtime;
  }

  function zen_get_orders_status_by_lang($status,$lang){

    global $db;


    $orders_status = $db->Execute("select orders_status_id, orders_status_name
                                   from " . TABLE_ORDERS_STATUS . "
                                   where language_id = '" . (int)$lang . "'
                                   and orders_status_id= '" . (int)$status . "'
                                   order by orders_status_id");

    return $orders_status->fields['orders_status_name'];

}

////
// Output a raw date string in the selected locale date format
// $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
// NOTE: Includes a workaround for dates before 01/01/1970 that fail on windows servers
  function zen_date_short($raw_date) {
    if ( ($raw_date == '0001-01-01 00:00:00') || ($raw_date == '') ) return false;

    $year = substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

// error on 1969 only allows for leap year
    if ($year != 1969 && @date('Y', mktime($hour, $minute, $second, $month, $day, $year)) == $year) {
      return date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
    } else {
      return ereg_replace('2037' . '$', $year, date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, 2037)));
    }

  }


  function zen_datetime_short($raw_datetime) {
    if ( ($raw_datetime == '0001-01-01 00:00:00') || ($raw_datetime == '') ) return false;

    $year = (int)substr($raw_datetime, 0, 4);
    $month = (int)substr($raw_datetime, 5, 2);
    $day = (int)substr($raw_datetime, 8, 2);
    $hour = (int)substr($raw_datetime, 11, 2);
    $minute = (int)substr($raw_datetime, 14, 2);
    $second = (int)substr($raw_datetime, 17, 2);

    return strftime(DATE_TIME_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
  }


  function zen_get_category_tree($parent_id = '0', $spacing = '', $exclude = '', $category_tree_array = '', $include_itself = false, $category_has_products = false, $limit = false) {
    global $db;

    if ($limit) {
      $limit_count = " limit 1";
    } else {
      $limit_count = '';
    }

    if (!is_array($category_tree_array)) $category_tree_array = array();
    if ( (sizeof($category_tree_array) < 1) && ($exclude != '0') ) $category_tree_array[] = array('id' => '0', 'text' => TEXT_TOP);

    if ($include_itself) {
      $category = $db->Execute("select cd.categories_name
                                from " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                where cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                and cd.categories_id = '" . (int)$parent_id . "'");

      $category_tree_array[] = array('id' => $parent_id, 'text' => $category->fields['categories_name']);
    }

    $categories = $db->Execute("select c.categories_id, cd.categories_name, c.parent_id
                                from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                where c.categories_id = cd.categories_id
                                and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                and c.parent_id = '" . (int)$parent_id . "'
                                order by c.sort_order, cd.categories_name");

    while (!$categories->EOF) {
      if ($category_has_products == true and zen_products_in_category_count($categories->fields['categories_id'], '', false, true) >= 1) {
        $mark = '*';
      } else {
        $mark = '&nbsp;&nbsp;';
      }
      if ($exclude != $categories->fields['categories_id']) $category_tree_array[] = array('id' => $categories->fields['categories_id'], 'text' => $spacing . $categories->fields['categories_name'] . $mark);
//      $category_tree_array = zen_get_category_tree($categories->fields['categories_id'], $spacing . '&nbsp;&nbsp;&nbsp;', $exclude, $category_tree_array, '', $category_has_products);
      $category_tree_array = zen_get_category_tree($categories->fields['categories_id'], '&#65279;' . $spacing . '&nbsp;&nbsp;&nbsp;', $exclude, $category_tree_array, '', $category_has_products);
      $categories->MoveNext();
    }
    return $category_tree_array;
  }


////
// products with name, model and price pulldown
  function zen_draw_products_pull_down($name, $parameters = '', $exclude = '', $show_id = false, $set_selected = false, $show_model = false, $show_current_category = false) {
    global $currencies, $db, $current_category_id;

    if ($exclude == '') {
      $exclude = array();
    }

    $select_string = '<select name="' . $name . '"';

    if ($parameters) {
      $select_string .= ' ' . $parameters;
    }

    $select_string .= '>';

    if ($show_current_category) {
// only show $current_categories_id
      $products = $db->Execute("select p.products_id, pd.products_name, p.products_price, p.products_model, ptc.categories_id
                                from " . TABLE_PRODUCTS . " p
                                left join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on ptc.products_id = p.products_id, " .
                                TABLE_PRODUCTS_DESCRIPTION . " pd
                                where p.products_id = pd.products_id
                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                and ptc.categories_id = '" . $current_category_id . "'
                                order by products_name");
    } else {
      $products = $db->Execute("select p.products_id, pd.products_name, p.products_price, p.products_model
                                from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                                where p.products_id = pd.products_id
                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                order by products_name");
    }

    while (!$products->EOF) {
      if (!in_array($products->fields['products_id'], $exclude)) {
        $display_price = zen_get_products_base_price($products->fields['products_id']);
        $select_string .= '<option value="' . $products->fields['products_id'] . '"';
        if ($set_selected == $products->fields['products_id']) $select_string .= ' SELECTED';
        $select_string .= '>' . $products->fields['products_name'] . ' (' . $currencies->format($display_price) . ')' . ($show_model ? ' [' . $products->fields['products_model'] . '] ' : '') . ($show_id ? ' - ID# ' . $products->fields['products_id'] : '') . '</option>';
      }
      $products->MoveNext();
    }

    $select_string .= '</select>';

    return $select_string;
  }


  function zen_options_name($options_id) {
    global $db;

    $options_id = str_replace('txt_','',$options_id);

    $options_values = $db->Execute("select products_options_name
                                    from " . TABLE_PRODUCTS_OPTIONS . "
                                    where products_options_id = '" . (int)$options_id . "'
                                    and language_id = '" . (int)$_SESSION['languages_id'] . "'");

    return $options_values->fields['products_options_name'];
  }


  function zen_values_name($values_id) {
    global $db;

    $values_values = $db->Execute("select products_options_values_name
                                   from " . TABLE_PRODUCTS_OPTIONS_VALUES . "
                                   where products_options_values_id = '" . (int)$values_id . "'
                                   and language_id = '" . (int)$_SESSION['languages_id'] . "'");

    return $values_values->fields['products_options_values_name'];
  }


  function zen_info_image($image, $alt, $width = '', $height = '') {
    if (zen_not_null($image) && (file_exists(DIR_FS_CATALOG_IMAGES . $image)) ) {
      $image = zen_image(DIR_WS_CATALOG_IMAGES . $image, $alt, $width, $height);
    } else {
      $image = TEXT_IMAGE_NONEXISTENT;
    }

    return $image;
  }


  function zen_break_string($string, $len, $break_char = '-') {
    $l = 0;
    $output = '';
    for ($i=0, $n=strlen($string); $i<$n; $i++) {
      $char = substr($string, $i, 1);
      if ($char != ' ') {
        $l++;
      } else {
        $l = 0;
      }
      if ($l > $len) {
        $l = 1;
        $output .= $break_char;
      }
      $output .= $char;
    }

    return $output;
  }


  function zen_get_country_name($country_id) {
    global $db;
    $country = $db->Execute("select countries_name
                             from " . TABLE_COUNTRIES . "
                             where countries_id = '" . (int)$country_id . "'");

    if ($country->RecordCount() < 1) {
      return $country_id;
    } else {
      return $country->fields['countries_name'];
    }
  }


  function zen_get_country_name_cfg() {
    global $db;
    $country = $db->Execute("select countries_name
                             from " . TABLE_COUNTRIES . "
                             where countries_id = '" . (int)$country_id . "'");

    if ($country->RecordCount() < 1) {
      return $country_id;
    } else {
      return $country->fields['countries_name'];
    }
  }


  function zen_get_zone_name($country_id, $zone_id, $default_zone) {
    global $db;
    $zone = $db->Execute("select zone_name
                                from " . TABLE_ZONES . "
                                where zone_country_id = '" . (int)$country_id . "'
                                and zone_id = '" . (int)$zone_id . "'");

    if ($zone->RecordCount() > 0) {
      return $zone->fields['zone_name'];
    } else {
      return $default_zone;
    }
  }


  function zen_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } elseif( is_a( $value, 'queryFactoryResult' ) ) {
      if (sizeof($value->result) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if ( (is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }


  function zen_browser_detect($component) {

    return stristr($_SERVER['HTTP_USER_AGENT'], $component);
  }


  function zen_tax_classes_pull_down($parameters, $selected = '') {
    global $db;
    $select_string = '<select ' . $parameters . '>';
    $classes = $db->Execute("select tax_class_id, tax_class_title
                             from " . TABLE_TAX_CLASS . "
                             order by tax_class_title");

    while (!$classes->EOF) {
      $select_string .= '<option value="' . $classes->fields['tax_class_id'] . '"';
      if ($selected == $classes->fields['tax_class_id']) $select_string .= ' SELECTED';
      $select_string .= '>' . $classes->fields['tax_class_title'] . '</option>';
      $classes->MoveNext();
    }
    $select_string .= '</select>';

    return $select_string;
  }


  function zen_geo_zones_pull_down($parameters, $selected = '') {
    global $db;
    $select_string = '<select ' . $parameters . '>';
    $zones = $db->Execute("select geo_zone_id, geo_zone_name
                                 from " . TABLE_GEO_ZONES . "
                                 order by geo_zone_name");

    while (!$zones->EOF) {
      $select_string .= '<option value="' . $zones->fields['geo_zone_id'] . '"';
      if ($selected == $zones->fields['geo_zone_id']) $select_string .= ' SELECTED';
      $select_string .= '>' . $zones->fields['geo_zone_name'] . '</option>';
      $zones->MoveNext();
    }
    $select_string .= '</select>';

    return $select_string;
  }


  function zen_get_geo_zone_name($geo_zone_id) {
    global $db;
    $zones = $db->Execute("select geo_zone_name
                           from " . TABLE_GEO_ZONES . "
                           where geo_zone_id = '" . (int)$geo_zone_id . "'");

    if ($zones->RecordCount() < 1) {
      $geo_zone_name = $geo_zone_id;
    } else {
      $geo_zone_name = $zones->fields['geo_zone_name'];
    }

    return $geo_zone_name;
  }


// USED FROM functions_customers
/*
  function zen_address_format($address_format_id, $address, $html, $boln, $eoln) {
    global $db;
    $address_format = $db->Execute("select address_format as format
                             from " . TABLE_ADDRESS_FORMAT . "
                             where address_format_id = '" . (int)$address_format_id . "'");

    $company = zen_output_string_protected($address['company']);
    if (isset($address['firstname']) && zen_not_null($address['firstname'])) {
      $firstname = zen_output_string_protected($address['firstname']);
      $lastname = zen_output_string_protected($address['lastname']);
    } elseif (isset($address['name']) && zen_not_null($address['name'])) {
      $firstname = zen_output_string_protected($address['name']);
      $lastname = '';
    } else {
      $firstname = '';
      $lastname = '';
    }
    $street = zen_output_string_protected($address['street_address']);
    $suburb = zen_output_string_protected($address['suburb']);
    $city = zen_output_string_protected($address['city']);
    $state = zen_output_string_protected($address['state']);
    if (isset($address['country_id']) && zen_not_null($address['country_id'])) {
      $country = zen_get_country_name($address['country_id']);

      if (isset($address['zone_id']) && zen_not_null($address['zone_id'])) {
        $state = zen_get_zone_code($address['country_id'], $address['zone_id'], $state);
      }
    } elseif (isset($address['country']) && zen_not_null($address['country'])) {
      $country = zen_output_string_protected($address['country']);
    } else {
      $country = '';
    }
    $postcode = zen_output_string_protected($address['postcode']);
    $zip = $postcode;

    if ($html) {
// HTML Mode
      $HR = '<hr />';
      $hr = '<hr />';
      if ( ($boln == '') && ($eoln == "\n") ) { // Values not specified, use rational defaults
        $CR = '<br />';
        $cr = '<br />';
        $eoln = $cr;
      } else { // Use values supplied
        $CR = $eoln . $boln;
        $cr = $CR;
      }
    } else {
// Text Mode
      $CR = $eoln;
      $cr = $CR;
      $HR = '----------------------------------------';
      $hr = '----------------------------------------';
    }

    $statecomma = '';
    $streets = $street;
    if ($suburb != '') $streets = $street . $cr . $suburb;
    if ($country == '') $country = zen_output_string_protected($address['country']);
    if ($state != '') $statecomma = $state . ', ';

    $fmt = $address_format->fields['format'];
    eval("\$address = \"$fmt\";");

    if ( (ACCOUNT_COMPANY == 'true') && (zen_not_null($company)) ) {
      $address = $company . $cr . $address;
    }

    return $address;
  }
*/

  ////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // Function    : zen_get_zone_code
  //
  // Arguments   : country_id           country code string
  //               zone_id              state/province zone_id
  //               default_zone         default string if zone==0
  //
  // Return      : state_prov_code   s  tate/province code
  //
  // Description : Function to retrieve the state/province code (as in FL for Florida etc)
  //
  ////////////////////////////////////////////////////////////////////////////////////////////////
  function zen_get_zone_code($country_id, $zone_id, $default_zone) {
    global $db;
    $zone_query = "select zone_code
                   from " . TABLE_ZONES . "
                   where zone_country_id = '" . (int)$country_id . "'
                   and zone_id = '" . (int)$zone_id . "'";

    $zone = $db->Execute($zone_query);

    if ($zone->RecordCount() > 0) {
      return $zone->fields['zone_code'];
    } else {
      return $default_zone;
    }
  }

  function zen_get_uprid($prid, $params) {
    $uprid = $prid;
    if ( (is_array($params)) && (!strstr($prid, '{')) ) {
      while (list($option, $value) = each($params)) {
        $uprid = $uprid . '{' . $option . '}' . $value;
      }
    }

    return $uprid;
  }


  function zen_get_prid($uprid) {
    $pieces = explode('{', $uprid);

    return $pieces[0];
  }


  function zen_get_languages() {
    global $db;
    $languages = $db->Execute("select languages_id, name, code, image, directory, chinese_name
                               from " . TABLE_LANGUAGES . " order by sort_order");

    while (!$languages->EOF) {
      $languages_array[] = array('id' => $languages->fields['languages_id'],
                                 'name' => $languages->fields['name'],
                                 'code' => $languages->fields['code'],
                                 'image' => $languages->fields['image'],
                                 'directory' => $languages->fields['directory'],
                                 'chinese_name' => $languages->fields['chinese_name']);
      $languages->MoveNext();
    }

    return $languages_array;
  }


  function zen_get_category_name($category_id, $language_id) {
    global $db;
    $category = $db->Execute("select categories_name
                              from " . TABLE_CATEGORIES_DESCRIPTION . "
                              where categories_id = '" . (int)$category_id . "'
                              and language_id = '" . (int)$language_id . "'");

    return $category->fields['categories_name'];
  }


  function zen_get_category_description($category_id, $language_id) {
    global $db;
    $category = $db->Execute("select categories_description
                              from " . TABLE_CATEGORIES_DESCRIPTION . "
                              where categories_id = '" . (int)$category_id . "'
                              and language_id = '" . (int)$language_id . "'");

    return $category->fields['categories_description'];
  }


  function zen_get_orders_status_name($orders_status_id, $language_id = '') {
    global $db;

    if (!$language_id) $language_id = $_SESSION['languages_id'];
    $orders_status = $db->Execute("select orders_status_name
                                   from " . TABLE_ORDERS_STATUS . "
                                   where orders_status_id = '" . (int)$orders_status_id . "'
                                   and language_id = '" . (int)$language_id . "'");

    return $orders_status->fields['orders_status_name'];
  }


  function zen_get_orders_status() {
    global $db;

    $orders_status_array = array();
    $orders_status = $db->Execute("select orders_status_id, orders_status_name
                                   from " . TABLE_ORDERS_STATUS . "
                                   where language_id = '" . (int)$_SESSION['languages_id'] . "'
                                   order by orders_status_id");

    while (!$orders_status->EOF) {
      $orders_status_array[] = array('id' => $orders_status->fields['orders_status_id'],
                                     'text' => $orders_status->fields['orders_status_name']);
      $orders_status->MoveNext();
    }

    return $orders_status_array;
  }


  function zen_get_products_name($product_id, $language_id = 0) {
    global $db;

    if ($language_id == 0) $language_id = $_SESSION['languages_id'];
    $product = $db->Execute("select products_name
                             from " . TABLE_PRODUCTS_DESCRIPTION . "
                             where products_id = '" . (int)$product_id . "'
                             and language_id = '" . (int)$language_id . "'");

    return $product->fields['products_name'];
  }

  function zen_get_products_name_without_catg($product_id, $language_id = 0) {
  	global $db;
  
  	if ($language_id == 0) $language_id = $_SESSION['languages_id'];
  	$product = $db->Execute("select products_name_without_catg
                             from " . TABLE_PRODUCTS_DESCRIPTION . "
                             where products_id = '" . (int)$product_id . "'
                             and language_id = '" . (int)$language_id . "'");
  
  	return $product->fields['products_name_without_catg'];
  }
  
  function zen_get_products_description($product_id, $language_id) {
    global $db;
    $product = $db->Execute("select products_description
                             from " . TABLE_PRODUCTS_INFO . "
                             where products_id = '" . (int)$product_id . "'
                             and language_id = '" . (int)$language_id . "'");

    return $product->fields['products_description'];
  }

  
  function zen_get_products_url($product_id, $language_id) {
    global $db;
    $product = $db->Execute("select products_url
                             from " . TABLE_PRODUCTS_DESCRIPTION . "
                             where products_id = '" . (int)$product_id . "'
                             and language_id = '" . (int)$language_id . "'");

    return $product->fields['products_url'];
  }


////
// Return the manufacturers URL in the needed language
// TABLES: manufacturers_info
  function zen_get_manufacturer_url($manufacturer_id, $language_id) {
    global $db;
    $manufacturer = $db->Execute("select manufacturers_url
                                  from " . TABLE_MANUFACTURERS_INFO . "
                                  where manufacturers_id = '" . (int)$manufacturer_id . "'
                                  and languages_id = '" . (int)$language_id . "'");

    return $manufacturer->fields['manufacturers_url'];
  }


////
// Wrapper for class_exists() function
// This function is not available in all PHP versions so we test it before using it.
  function zen_class_exists($class_name) {
    if (function_exists('class_exists')) {
      return class_exists($class_name);
    } else {
      return true;
    }
  }


////
// Count how many products exist in a category
// TABLES: products, products_to_categories, categories
  function zen_products_in_category_count($categories_id, $include_deactivated = false, $include_child = true, $limit = false) {
    global $db;
    $products_count = 0;

    if ($limit) {
      $limit_count = ' limit 1';
    } else {
      $limit_count = '';
    }

    if ($include_deactivated) {

      $products = $db->Execute("select count(*) as total
                                from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                                where p.products_id = p2c.products_id
                                and p2c.categories_id = '" . (int)$categories_id . "'" . $limit_count);
    } else {
      $products = $db->Execute("select count(*) as total
                                from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                                where p.products_id = p2c.products_id
                                and p.products_status = 1
                                and p2c.categories_id = '" . (int)$categories_id . "'" . $limit_count);

    }

    $products_count += $products->fields['total'];

    if ($include_child) {
      $childs = $db->Execute("select categories_id from " . TABLE_CATEGORIES . "
                              where parent_id = '" . (int)$categories_id . "'");
      if ($childs->RecordCount() > 0 ) {
        while (!$childs->EOF) {
          $products_count += zen_products_in_category_count($childs->fields['categories_id'], $include_deactivated);
          $childs->MoveNext();
        }
      }
    }
    return $products_count;
  }


////
// Count how many subcategories exist in a category
// TABLES: categories
  function zen_childs_in_category_count($categories_id) {
    global $db;
    $categories_count = 0;

    $categories = $db->Execute("select categories_id
                                from " . TABLE_CATEGORIES . "
                                where parent_id = '" . (int)$categories_id . "'");

    while (!$categories->EOF) {
      $categories_count++;
      $categories_count += zen_childs_in_category_count($categories->fields['categories_id']);
      $categories->MoveNext();
    }

    return $categories_count;
  }


////
// Returns an array with countries
// TABLES: countries
  function zen_get_countries($default = '') {
    global $db;
    $countries_array = array();
    if ($default) {
      $countries_array[] = array('id' => '',
                                 'countries_iso_code_2' => $countries->fields['countries_iso_code_2'],
                                 'text' => $default);
    }
    $countries = $db->Execute("select countries_id, countries_name, countries_iso_code_2
                               from " . TABLE_COUNTRIES . "
                               order by countries_name");

    while (!$countries->EOF) {
      $countries_array[] = array('id' => $countries->fields['countries_id'],
                                 'countries_iso_code_2' => $countries->fields['countries_iso_code_2'],
                                 'text' => $countries->fields['countries_name']);
      $countries->MoveNext();
    }

    return $countries_array;
  }


////
// return an array with country zones
  function zen_get_country_zones($country_id) {
    global $db;
    $zones_array = array();
    $zones = $db->Execute("select zone_id, zone_name
                           from " . TABLE_ZONES . "
                           where zone_country_id = '" . (int)$country_id . "'
                           order by zone_name");

    while (!$zones->EOF) {
      $zones_array[] = array('id' => $zones->fields['zone_id'],
                             'text' => $zones->fields['zone_name']);
      $zones->MoveNext();
    }

    return $zones_array;
  }


  function zen_prepare_country_zones_pull_down($country_id = '') {
// preset the width of the drop-down for Netscape
    $pre = '';
    if ( (!zen_browser_detect('MSIE')) && (zen_browser_detect('Mozilla/4')) ) {
      for ($i=0; $i<45; $i++) $pre .= '&nbsp;';
    }

    $zones = zen_get_country_zones($country_id);

    if (sizeof($zones) > 0) {
      $zones_select = array(array('id' => '', 'text' => PLEASE_SELECT));
      $zones = array_merge($zones_select, $zones);
    } else {
      $zones = array(array('id' => '', 'text' => TYPE_BELOW));
// create dummy options for Netscape to preset the height of the drop-down
      if ( (!zen_browser_detect('MSIE')) && (zen_browser_detect('Mozilla/4')) ) {
        for ($i=0; $i<9; $i++) {
          $zones[] = array('id' => '', 'text' => $pre);
        }
      }
    }

    return $zones;
  }


////
// Get list of address_format_id's
  function zen_get_address_formats() {
    global $db;
    $address_format_values = $db->Execute("select address_format_id
                                           from " . TABLE_ADDRESS_FORMAT . "
                                           order by address_format_id");

    $address_format_array = array();
    while (!$address_format_values->EOF) {
      $address_format_array[] = array('id' => $address_format_values->fields['address_format_id'],
                                      'text' => $address_format_values->fields['address_format_id']);
      $address_format_values->MoveNext();
    }
    return $address_format_array;
  }


////
  function zen_cfg_select_coupon_id($coupon_id, $key = '') {
    global $db;
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    $coupons = $db->execute("select cd.coupon_name, c.coupon_id from " . TABLE_COUPONS ." c, ". TABLE_COUPONS_DESCRIPTION . " cd where cd.coupon_id = c.coupon_id and cd.language_id = '" . $_SESSION['languages_id'] . "'");
    $coupon_array[] = array('id' => '0',
                            'text' => 'None');

    while (!$coupons->EOF) {
      $coupon_array[] = array('id' => $coupons->fields['coupon_id'],
                              'text' => $coupons->fields['coupon_name']);
      $coupons->MoveNext();
    }
    return zen_draw_pull_down_menu($name, $coupon_array, $coupon_id);
  }


////
// Alias function for Store configuration values in the Administration Tool
  function zen_cfg_pull_down_country_list($country_id, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return zen_draw_pull_down_menu($name, zen_get_countries(), $country_id);
  }


////
  function zen_cfg_pull_down_country_list_none($country_id, $key = '') {
    $country_array = zen_get_countries('None');
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return zen_draw_pull_down_menu($name, $country_array, $country_id);
  }


////
  function zen_cfg_pull_down_zone_list($zone_id, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return zen_draw_pull_down_menu($name, zen_get_country_zones(STORE_COUNTRY), $zone_id);
  }


////
  function zen_cfg_pull_down_tax_classes($tax_class_id, $key = '') {
    global $db;
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $tax_class = $db->Execute("select tax_class_id, tax_class_title
                               from " . TABLE_TAX_CLASS . "
                               order by tax_class_title");

    while (!$tax_class->EOF) {
      $tax_class_array[] = array('id' => $tax_class->fields['tax_class_id'],
                                 'text' => $tax_class->fields['tax_class_title']);
      $tax_class->MoveNext();
    }

    return zen_draw_pull_down_menu($name, $tax_class_array, $tax_class_id);
  }


////
// Function to read in text area in admin
 function zen_cfg_textarea($text, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return zen_draw_textarea_field($name, false, 60, 5, $text);
  }


////
// Function to read in text area in admin
 function zen_cfg_textarea_small($text, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
    return zen_draw_textarea_field($name, false, 35, 1, $text);
  }


  function zen_cfg_get_zone_name($zone_id) {
    global $db;
    $zone = $db->Execute("select zone_name
                          from " . TABLE_ZONES . "
                          where zone_id = '" . (int)$zone_id . "'");

    if ($zone->RecordCount() < 1) {
      return $zone_id;
    } else {
      return $zone->fields['zone_name'];
    }
  }

  function zen_cfg_pull_down_htmleditors($html_editor, $key = '') {
    global $editors_list;
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $editors_pulldown = array();
    foreach($editors_list as $key=>$value) {
      $editors_pulldown[] = array('id' => $key, 'text' => $value['desc']);
    }
    return zen_draw_pull_down_menu($name, $editors_pulldown, $html_editor);
  }

  function zen_cfg_password_input($value, $key = '') {
    return zen_draw_password_field('configuration[' . $key . ']', $value);
  }

  function zen_cfg_password_display($value) {
    $length = strlen($value);
    return str_repeat('*', ($length > 16 ? 16 : $length));
  }

////
// Sets the status of a product
  function zen_set_product_status($products_id, $status) {
    global $db;
    if ($status == '1') {
      return $db->Execute("update " . TABLE_PRODUCTS . "
                           set products_status = 1, products_last_modified = now()
                           where products_id = '" . (int)$products_id . "'");

    } elseif ($status == '0') {
      return $db->Execute("update " . TABLE_PRODUCTS . "
                           set products_status = 0, products_last_modified = now()
                           where products_id = '" . (int)$products_id . "'");

    } else {
      return -1;
    }
  }


////
// Sets timeout for the current script.
// Cant be used in safe mode.
  function zen_set_time_limit($limit) {
    if (!get_cfg_var('safe_mode')) {
      @set_time_limit($limit);
    }
  }


////
// Alias function for Store configuration values in the Administration Tool
  function zen_cfg_select_option($select_array, $key_value, $key = '') {
    $string = '';

    for ($i=0, $n=sizeof($select_array); $i<$n; $i++) {
      $name = ((zen_not_null($key)) ? 'configuration[' . $key . ']' : 'configuration_value');

      $string .= '<br><input type="radio" name="' . $name . '" value="' . $select_array[$i] . '"';

      if ($key_value == $select_array[$i]) $string .= ' CHECKED';

      $string .= ' id="' . strtolower($select_array[$i] . '-' . $name) . '"> ' . '<label for="' . strtolower($select_array[$i] . '-' . $name) . '" class="inputSelect">' . $select_array[$i] . '</label>';
    }

    return $string;
  }


  function zen_cfg_select_drop_down($select_array, $key_value, $key = '') {
    $string = '';

    $name = ((zen_not_null($key)) ? 'configuration[' . $key . ']' : 'configuration_value');
    return zen_draw_pull_down_menu($name, $select_array, (int)$key_value);
  }

////
// Alias function for module configuration keys
  function zen_mod_select_option($select_array, $key_name, $key_value) {
    reset($select_array);
    while (list($key, $value) = each($select_array)) {
      if (is_int($key)) $key = $value;
      $string .= '<br><input type="radio" name="configuration[' . $key_name . ']" value="' . $key . '"';
      if ($key_value == $key) $string .= ' CHECKED';
      $string .= '> ' . $value;
    }

    return $string;
  }

////
// Retreive server information
  function zen_get_system_information() {
    global $db;

    // determine database size stats
    $indsize = 0;
    $datsize = 0;
    $result = $db->Execute("SHOW TABLE STATUS" . (DB_PREFIX == '' ? '' : " LIKE '" . str_replace('_', '\_', DB_PREFIX) . "%'"));
    while (!$result->EOF) {
      $datsize += $result->fields['Data_length'];
      $indsize += $result->fields['Index_length'];
      $result->MoveNext();
    }
    $mysql_in_strict_mode = false;
    $result = $db->Execute("SHOW VARIABLES LIKE 'sql\_mode'");
    while (!$result->EOF) {
      if (strstr($result->fields['Value'], 'strict_')) $mysql_in_strict_mode = true;
      $result->MoveNext();
    }

    $db_query = $db->Execute("select now() as datetime");
    list($system, $host, $kernel) = preg_split('/[\s,]+/', @exec('uname -a'), 5);
    if ($host == '') list($system, $host, $kernel) = array('', $_SERVER['SERVER_NAME'], php_uname());

    return array('date' => zen_datetime_short(date('Y-m-d H:i:s')),
                 'system' => $system,
                 'kernel' => $kernel,
                 'host' => $host,
                 'ip' => gethostbyname($host),
                 'uptime' => (DISPLAY_SERVER_UPTIME == 'true' ? @exec('uptime 2>&1') : 'Unchecked'),
                 'http_server' => $_SERVER['SERVER_SOFTWARE'],
                 'php' => PHP_VERSION,
                 'zend' => (function_exists('zend_version') ? zend_version() : ''),
                 'db_server' => DB_SERVER,
                 'db_ip' => gethostbyname(DB_SERVER),
                 'db_version' => 'MySQL ' . (function_exists('mysql_get_server_info') ? mysql_get_server_info() : ''),
                 'db_date' => zen_datetime_short($db_query->fields['datetime']),
                 'php_memlimit' => @ini_get('memory_limit'),
                 'php_safemode' => strtolower(@ini_get('safe_mode')),
                 'php_file_uploads' => strtolower(@ini_get('file_uploads')),
                 'php_uploadmaxsize' => @ini_get('upload_max_filesize'),
                 'php_postmaxsize' => @ini_get('post_max_size'),
                 'database_size' => $datsize,
                 'index_size' => $indsize,
                 'mysql_strict_mode' => $mysql_in_strict_mode,
                 );
  }

  function zen_generate_category_path($id, $from = 'category', $categories_array = '', $index = 0) {
    global $db;

    if (!is_array($categories_array)) $categories_array = array();

    if ($from == 'product') {
      $categories = $db->Execute("select categories_id
                                  from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                                  where products_id = '" . (int)$id . "'");

      while (!$categories->EOF) {
        if ($categories->fields['categories_id'] == '0') {
          $categories_array[$index][] = array('id' => '0', 'text' => TEXT_TOP);
        } else {
          $category = $db->Execute("select cd.categories_name, c.parent_id
                                    from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                    where c.categories_id = '" . (int)$categories->fields['categories_id'] . "'
                                    and c.categories_id = cd.categories_id
                                    and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");

          $categories_array[$index][] = array('id' => $categories->fields['categories_id'], 'text' => $category->fields['categories_name']);
          if ( (zen_not_null($category->fields['parent_id'])) && ($category->fields['parent_id'] != '0') ) $categories_array = zen_generate_category_path($category->fields['parent_id'], 'category', $categories_array, $index);
          $categories_array[$index] = array_reverse($categories_array[$index]);
        }
        $index++;
        $categories->MoveNext();
      }
    } elseif ($from == 'category') {
      $category = $db->Execute("select cd.categories_name, c.parent_id
                                from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                where c.categories_id = '" . (int)$id . "'
                                and c.categories_id = cd.categories_id
                                and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");

      $categories_array[$index][] = array('id' => $id, 'text' => $category->fields['categories_name']);
      if ( (zen_not_null($category->fields['parent_id'])) && ($category->fields['parent_id'] != '0') ) $categories_array = zen_generate_category_path($category->fields['parent_id'], 'category', $categories_array, $index);
    }

    return $categories_array;
  }

  function zen_output_generated_category_path($id, $from = 'category') {
    $calculated_category_path_string = '';
    $calculated_category_path = zen_generate_category_path($id, $from);
    for ($i=0, $n=sizeof($calculated_category_path); $i<$n; $i++) {
      for ($j=0, $k=sizeof($calculated_category_path[$i]); $j<$k; $j++) {
//        $calculated_category_path_string .= $calculated_category_path[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
        $calculated_category_path_string = $calculated_category_path[$i][$j]['text'] . '&nbsp;&gt;&nbsp;' . $calculated_category_path_string;
      }
      $calculated_category_path_string = substr($calculated_category_path_string, 0, -16) . '<br>';
    }
    $calculated_category_path_string = substr($calculated_category_path_string, 0, -4);

    if (strlen($calculated_category_path_string) < 1) $calculated_category_path_string = TEXT_TOP;

    return $calculated_category_path_string;
  }

  function zen_get_generated_category_path_ids($id, $from = 'category') {
    global $db;
    $calculated_category_path_string = '';
    $calculated_category_path = zen_generate_category_path($id, $from);
    for ($i=0, $n=sizeof($calculated_category_path); $i<$n; $i++) {
      for ($j=0, $k=sizeof($calculated_category_path[$i]); $j<$k; $j++) {
        $calculated_category_path_string .= $calculated_category_path[$i][$j]['id'] . '_';
      }
      $calculated_category_path_string = substr($calculated_category_path_string, 0, -1) . '<br>';
    }
    $calculated_category_path_string = substr($calculated_category_path_string, 0, -4);

    if (strlen($calculated_category_path_string) < 1) $calculated_category_path_string = TEXT_TOP;

    return $calculated_category_path_string;
  }

  function zen_remove_category($category_id) {
    global $db;
    $db->Execute("update ".TABLE_CATEGORIES." set categories_status=-2 where categories_id = '" . (int)$category_id . "'");
    return true;
    $category_image = $db->Execute("select categories_image
                                    from " . TABLE_CATEGORIES . "
                                    where categories_id = '" . (int)$category_id . "'");

    $duplicate_image = $db->Execute("select count(*) as total
                                     from " . TABLE_CATEGORIES . "
                                     where categories_image = '" .
                                           zen_db_input($category_image->fields['categories_image']) . "'");
    if ($duplicate_image->fields['total'] < 2) {
      if (file_exists(DIR_FS_CATALOG_IMAGES . $category_image->fields['categories_image'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $category_image->fields['categories_image']);
      }
    }

    $db->Execute("delete from " . TABLE_CATEGORIES . "
                  where categories_id = '" . (int)$category_id . "'");

    $db->Execute("delete from " . TABLE_CATEGORIES_DESCRIPTION . "
                  where categories_id = '" . (int)$category_id . "'");

    $db->Execute("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                  where categories_id = '" . (int)$category_id . "'");

    $db->Execute("delete from " . TABLE_METATAGS_CATEGORIES_DESCRIPTION . "
                  where categories_id = '" . (int)$category_id . "'");
    
    remove_categores_memcache_by_categories_id((int)$category_id);
  }

  function zen_remove_product($product_id, $ptc = 'true') {
    global $db;
	//Tianwen.Wan20160126删除商品，只改变状态(已删除:10)
    $db->Execute("update ".TABLE_PRODUCTS." set products_status=10 where products_id = '" . (int)$product_id . "'");
    $operate_content= '商品被删除';
    zen_insert_operate_logs($_SESSION['admin_id'],zen_get_products_model($product_id),$operate_content,2);
    return true;
    $product_image = $db->Execute("select products_image
                                   from " . TABLE_PRODUCTS . "
                                   where products_id = '" . (int)$product_id . "'");

    $duplicate_image = $db->Execute("select count(*) as total
                                     from " . TABLE_PRODUCTS . "
                                     where products_image = '" . zen_db_input($product_image->fields['products_image']) . "'");

    if ($duplicate_image->fields['total'] < 2 and $product_image->fields['products_image'] != '') {
      $products_image = $product_image->fields['products_image'];
      $products_image_extension = substr($products_image, strrpos($products_image, '.'));
			$products_image_base = ereg_replace($products_image_extension, '', $products_image);

      $filename_medium = 'medium/' . $products_image_base . IMAGE_SUFFIX_MEDIUM . $products_image_extension;
			$filename_large = 'large/' . $products_image_base . IMAGE_SUFFIX_LARGE . $products_image_extension;

      if (file_exists(DIR_FS_CATALOG_IMAGES . $product_image->fields['products_image'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $product_image->fields['products_image']);
      }
      if (file_exists(DIR_FS_CATALOG_IMAGES . $filename_medium)) {
        @unlink(DIR_FS_CATALOG_IMAGES . $filename_medium);
      }
      if (file_exists(DIR_FS_CATALOG_IMAGES . $filename_large)) {
        @unlink(DIR_FS_CATALOG_IMAGES . $filename_large);
      }
    }

    $db->Execute("delete from " . TABLE_SPECIALS . "
                  where products_id = '" . (int)$product_id . "'");

    $db->Execute("delete from " . TABLE_PRODUCTS . "
                  where products_id = '" . (int)$product_id . "'");

//    if ($ptc == 'true') {
      $db->Execute("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                    where products_id = '" . (int)$product_id . "'");
//    }

    $db->Execute("delete from " . TABLE_PRODUCTS_DESCRIPTION . "
                  where products_id = '" . (int)$product_id . "'");
	
    $db->Execute("delete from " . TABLE_PRODUCTS_INFO . "
                  where products_id = '" . (int)$product_id . "'");
    
    $db->Execute("delete from " . TABLE_META_TAGS_PRODUCTS_DESCRIPTION . "
                  where products_id = '" . (int)$product_id . "'");

    zen_products_attributes_download_delete($product_id);

    $db->Execute("delete from " . TABLE_PRODUCTS_ATTRIBUTES . "
                  where products_id = '" . (int)$product_id . "'");

    $db->Execute("delete from " . TABLE_CUSTOMERS_BASKET . "
                  where products_id = '" . (int)$product_id . "'");

    $db->Execute("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                  where products_id = '" . (int)$product_id . "'");


    $product_reviews = $db->Execute("select reviews_id
                                     from " . TABLE_REVIEWS . "
                                     where products_id = '" . (int)$product_id . "'");

    while (!$product_reviews->EOF) {
      $db->Execute("delete from " . TABLE_REVIEWS_DESCRIPTION . "
                    where reviews_id = '" . (int)$product_reviews->fields['reviews_id'] . "'");
      $product_reviews->MoveNext();
    }
    $db->Execute("delete from " . TABLE_REVIEWS . "
                  where products_id = '" . (int)$product_id . "'");

    $db->Execute("delete from " . TABLE_FEATURED . "
                  where products_id = '" . (int)$product_id . "'");

    $db->Execute("delete from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . "
                  where products_id = '" . (int)$product_id . "'");

  }

  function zen_products_attributes_download_delete($product_id) {
    global $db;
  // remove downloads if they exist
    $remove_downloads= $db->Execute("select products_attributes_id from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id= '" . $product_id . "'");
    while (!$remove_downloads->EOF) {
      $db->Execute("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id= '" . $remove_downloads->fields['products_attributes_id'] . "'");
      $remove_downloads->MoveNext();
    }
  }

  function zen_remove_order($order_id, $restock = false) {
    global $db;
    if ($restock == 'on') {
      $order = $db->Execute("select products_id, products_quantity
                             from " . TABLE_ORDERS_PRODUCTS . "
                             where orders_id = '" . (int)$order_id . "'");

      while (!$order->EOF) {
        $db->Execute("update " . TABLE_PRODUCTS . "
                      set products_status = 1,  products_ordered = products_ordered - " . $order->fields['products_quantity'] . " where products_id = '" . (int)$order->fields['products_id'] . "'");
        $db->Execute("update " . TABLE_PRODUCTS_STOCK . " set products_quantity = products_quantity + " . $order->fields['products_quantity'] . " where products_id = " . (int)$order->fields['products_id'] );
        $order->MoveNext();
      }
    }

    $db->Execute("delete from " . TABLE_ORDERS . " where orders_id = '" . (int)$order_id . "'");
    $db->Execute("delete from " . TABLE_ORDERS_PRODUCTS . "
                  where orders_id = '" . (int)$order_id . "'");

    $db->Execute("delete from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
                  where orders_id = '" . (int)$order_id . "'");

    $db->Execute("delete from " . TABLE_ORDERS_STATUS_HISTORY . "
                  where orders_id = '" . (int)$order_id . "'");

    $db->Execute("delete from " . TABLE_ORDERS_TOTAL . "
                  where orders_id = '" . (int)$order_id . "'");

  }
  
  function zen_order_to_remove($order_id, $restock = false){
  	global $db;
  	if ($restock == 'on') {
  		$order = $db->Execute("select products_id, products_quantity
                             from " . TABLE_ORDERS_PRODUCTS . "
                             where orders_id = '" . (int)$order_id . "'");
  		 
  		while (!$order->EOF) {
  			$db->Execute("update " . TABLE_PRODUCTS . "
                      set products_ordered = products_ordered - " . $order->fields['products_quantity'] . " where products_id = '" . (int)$order->fields['products_id'] . "'");
  			$db->Execute("update " . TABLE_PRODUCTS_STOCK . " set products_quantity = products_quantity + " . $order->fields['products_quantity'] . " where products_id = " . (int)$order->fields['products_id'] );
  			$order->MoveNext();
  		}
  	}
  	 
  	$db->Execute("update " . TABLE_ORDERS . " set orders_status = '5',  last_modified = now()
                        where orders_id = '" . (int)$order_id . "'");
  	$db->Execute("insert into " . TABLE_ORDERS_STATUS_HISTORY . "
                      (orders_id, orders_status_id, date_added, customer_notified, comments)
                      values ('" . (int)$order_id . "','5',now(), 0,'Order is deleted---".$_SESSION['admin_id']."')");
  }

  function zen_get_file_permissions($mode) {
// determine type
    if ( ($mode & 0xC000) == 0xC000) { // unix domain socket
      $type = 's';
    } elseif ( ($mode & 0x4000) == 0x4000) { // directory
      $type = 'd';
    } elseif ( ($mode & 0xA000) == 0xA000) { // symbolic link
      $type = 'l';
    } elseif ( ($mode & 0x8000) == 0x8000) { // regular file
      $type = '-';
    } elseif ( ($mode & 0x6000) == 0x6000) { //bBlock special file
      $type = 'b';
    } elseif ( ($mode & 0x2000) == 0x2000) { // character special file
      $type = 'c';
    } elseif ( ($mode & 0x1000) == 0x1000) { // named pipe
      $type = 'p';
    } else { // unknown
      $type = '?';
    }

// determine permissions
    $owner['read']    = ($mode & 00400) ? 'r' : '-';
    $owner['write']   = ($mode & 00200) ? 'w' : '-';
    $owner['execute'] = ($mode & 00100) ? 'x' : '-';
    $group['read']    = ($mode & 00040) ? 'r' : '-';
    $group['write']   = ($mode & 00020) ? 'w' : '-';
    $group['execute'] = ($mode & 00010) ? 'x' : '-';
    $world['read']    = ($mode & 00004) ? 'r' : '-';
    $world['write']   = ($mode & 00002) ? 'w' : '-';
    $world['execute'] = ($mode & 00001) ? 'x' : '-';

// adjust for SUID, SGID and sticky bit
    if ($mode & 0x800 ) $owner['execute'] = ($owner['execute'] == 'x') ? 's' : 'S';
    if ($mode & 0x400 ) $group['execute'] = ($group['execute'] == 'x') ? 's' : 'S';
    if ($mode & 0x200 ) $world['execute'] = ($world['execute'] == 'x') ? 't' : 'T';

    return $type .
           $owner['read'] . $owner['write'] . $owner['execute'] .
           $group['read'] . $group['write'] . $group['execute'] .
           $world['read'] . $world['write'] . $world['execute'];
  }

  function zen_remove($source) {
    global $messageStack, $zen_remove_error;

    if (isset($zen_remove_error)) $zen_remove_error = false;

    if (is_dir($source)) {
      $dir = dir($source);
      while ($file = $dir->read()) {
        if ( ($file != '.') && ($file != '..') ) {
          if (is_writeable($source . '/' . $file)) {
            zen_remove($source . '/' . $file);
          } else {
            $messageStack->add(sprintf(ERROR_FILE_NOT_REMOVEABLE, $source . '/' . $file), 'error');
            $zen_remove_error = true;
          }
        }
      }
      $dir->close();

      if (is_writeable($source)) {
        rmdir($source);
      } else {
        $messageStack->add(sprintf(ERROR_DIRECTORY_NOT_REMOVEABLE, $source), 'error');
        $zen_remove_error = true;
      }
    } else {
      if (is_writeable($source)) {
        unlink($source);
      } else {
        $messageStack->add(sprintf(ERROR_FILE_NOT_REMOVEABLE, $source), 'error');
        $zen_remove_error = true;
      }
    }
  }

////
// Output the tax percentage with optional padded decimals
  function zen_display_tax_value($value, $padding = TAX_DECIMAL_PLACES) {
    if (strpos($value, '.')) {
      $loop = true;
      while ($loop) {
        if (substr($value, -1) == '0') {
          $value = substr($value, 0, -1);
        } else {
          $loop = false;
          if (substr($value, -1) == '.') {
            $value = substr($value, 0, -1);
          }
        }
      }
    }

    if ($padding > 0) {
      if ($decimal_pos = strpos($value, '.')) {
        $decimals = strlen(substr($value, ($decimal_pos+1)));
        for ($i=$decimals; $i<$padding; $i++) {
          $value .= '0';
        }
      } else {
        $value .= '.';
        for ($i=0; $i<$padding; $i++) {
          $value .= '0';
        }
      }
    }

    return $value;
  }


  function zen_get_tax_class_title($tax_class_id) {
    global $db;
    if ($tax_class_id == '0') {
      return TEXT_NONE;
    } else {
      $classes = $db->Execute("select tax_class_title
                               from " . TABLE_TAX_CLASS . "
                               where tax_class_id = '" . (int)$tax_class_id . "'");

      return $classes->fields['tax_class_title'];
    }
  }

  function zen_banner_image_extension() {
    if (function_exists('imagetypes')) {
      if (imagetypes() & IMG_PNG) {
        return 'png';
      } elseif (imagetypes() & IMG_JPG) {
        return 'jpg';
      } elseif (imagetypes() & IMG_GIF) {
        return 'gif';
      }
    } elseif (function_exists('imagecreatefrompng') && function_exists('imagepng')) {
      return 'png';
    } elseif (function_exists('imagecreatefromjpeg') && function_exists('imagejpeg')) {
      return 'jpg';
    } elseif (function_exists('imagecreatefromgif') && function_exists('imagegif')) {
      return 'gif';
    }

    return false;
  }

////
// Wrapper function for round()
  function zen_round($number, $precision) {
/// fix rounding error on GVs etc.
    $number = round($number, $precision);

    return $number;
  }

////
// Add tax to a products price
  function zen_add_tax($price, $tax) {
    global $currencies;

    if (DISPLAY_PRICE_WITH_TAX_ADMIN == 'true') {
      return zen_round($price, $currencies->currencies[DEFAULT_CURRENCY]['decimal_places']) + zen_calculate_tax($price, $tax);
    } else {
      return zen_round($price, $currencies->currencies[DEFAULT_CURRENCY]['decimal_places']);
    }
  }

// Calculates Tax rounding the result
  function zen_calculate_tax($price, $tax) {
    global $currencies;

    return zen_round($price * $tax / 100, $currencies->currencies[DEFAULT_CURRENCY]['decimal_places']);
  }

////
// Returns the tax rate for a zone / class
// TABLES: tax_rates, zones_to_geo_zones
  function zen_get_tax_rate($class_id, $country_id = -1, $zone_id = -1) {
    global $db;
    global $customer_zone_id, $customer_country_id;

    if ( ($country_id == -1) && ($zone_id == -1) ) {
      if (!$_SESSION['customer_id']) {
        $country_id = STORE_COUNTRY;
        $zone_id = STORE_ZONE;
      } else {
        $country_id = $customer_country_id;
        $zone_id = $customer_zone_id;
      }
    }

    $tax = $db->Execute("select SUM(tax_rate) as tax_rate
                         from (" . TABLE_TAX_RATES . " tr
                         left join " . TABLE_ZONES_TO_GEO_ZONES . " za
                         ON tr.tax_zone_id = za.geo_zone_id
                         left join " . TABLE_GEO_ZONES . " tz ON tz.geo_zone_id = tr.tax_zone_id )
                         WHERE (za.zone_country_id IS NULL
                         OR za.zone_country_id = 0
                         OR za.zone_country_id = '" . (int)$country_id . "')
                         AND (za.zone_id IS NULL OR za.zone_id = 0
                         OR za.zone_id = '" . (int)$zone_id . "')
                         AND tr.tax_class_id = '" . (int)$class_id . "'
                         GROUP BY tr.tax_priority");

    if ($tax->RecordCount() > 0) {
      $tax_multiplier = 0;
      while (!$tax->EOF) {
        $tax_multiplier += $tax->fields['tax_rate'];
		$tax->MoveNext();
      }
      return $tax_multiplier;
    } else {
      return 0;
    }
  }

////
// Returns the tax rate for a tax class
// TABLES: tax_rates
  function zen_get_tax_rate_value($class_id) {
    return zen_get_tax_rate($class_id);
  }

  function zen_call_function($function, $parameter, $object = '') {
    if ($object == '') {
      return call_user_func($function, $parameter);
    } elseif (PHP_VERSION < 4) {
      return call_user_method($function, $object, $parameter);
    } else {
      return call_user_func(array($object, $function), $parameter);
    }
  }

  function zen_get_zone_class_title($zone_class_id) {
    global $db;
    if ($zone_class_id == '0') {
      return TEXT_NONE;
    } else {
      $classes = $db->Execute("select geo_zone_name
                               from " . TABLE_GEO_ZONES . "
                               where geo_zone_id = '" . (int)$zone_class_id . "'");

      return $classes->fields['geo_zone_name'];
    }
  }

////
  function zen_cfg_pull_down_zone_classes($zone_class_id, $key = '') {
    global $db;
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $zone_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $zone_class = $db->Execute("select geo_zone_id, geo_zone_name
                                from " . TABLE_GEO_ZONES . "
                                order by geo_zone_name");

    while (!$zone_class->EOF) {
      $zone_class_array[] = array('id' => $zone_class->fields['geo_zone_id'],
                                  'text' => $zone_class->fields['geo_zone_name']);
      $zone_class->MoveNext();
    }

    return zen_draw_pull_down_menu($name, $zone_class_array, $zone_class_id);
  }


////
  function zen_cfg_pull_down_order_statuses($order_status_id, $key = '') {
    global $db;
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $statuses_array = array(array('id' => '0', 'text' => TEXT_DEFAULT));
    $statuses = $db->Execute("select orders_status_id, orders_status_name
                              from " . TABLE_ORDERS_STATUS . "
                              where language_id = '" . (int)$_SESSION['languages_id'] . "'
                              order by orders_status_id");

    while (!$statuses->EOF) {
      $statuses_array[] = array('id' => $statuses->fields['orders_status_id'],
                                'text' => $statuses->fields['orders_status_name'] . ' [' . $statuses->fields['orders_status_id'] . ']');
      $statuses->MoveNext();
    }

    return zen_draw_pull_down_menu($name, $statuses_array, $order_status_id);
  }

  function zen_get_order_status_name($order_status_id, $language_id = '') {
    global $db;

    if ($order_status_id < 1) return TEXT_DEFAULT;

    if (!is_numeric($language_id)) $language_id = $_SESSION['languages_id'];

    $status = $db->Execute("select orders_status_name
                            from " . TABLE_ORDERS_STATUS . "
                            where orders_status_id = '" . (int)$order_status_id . "'
                            and language_id = '" . (int)$language_id . "'");

    return $status->fields['orders_status_name'] . ' [' . (int)$order_status_id . ']';
  }

////
// Return a random value
  function zen_rand($min = null, $max = null) {
    static $seeded;

    if (!$seeded) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }

    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }

// nl2br() prior PHP 4.2.0 did not convert linefeeds on all OSs (it only converted \n)
  function zen_convert_linefeeds($from, $to, $string) {
    if ((PHP_VERSION < "4.0.5") && is_array($from)) {
      return ereg_replace('(' . implode('|', $from) . ')', $to, $string);
    } else {
      return str_replace($from, $to, $string);
    }
  }

  function zen_string_to_int($string) {
    return (int)$string;
  }

////
// Parse and secure the cPath parameter values
  function zen_parse_category_path($cPath) {
// make sure the category IDs are integers
    $cPath_array = array_map('zen_string_to_int', explode('_', $cPath));

// make sure no duplicate category IDs exist which could lock the server in a loop
    $tmp_array = array();
    $n = sizeof($cPath_array);
    for ($i=0; $i<$n; $i++) {
      if (!in_array($cPath_array[$i], $tmp_array)) {
        $tmp_array[] = $cPath_array[$i];
      }
    }

    return $tmp_array;
  }
////
// Create a Coupon Code. length may be between 1 and 16 Characters
// $salt needs some thought.

  function create_coupon_code($salt="secret", $length=SECURITY_CODE_LENGTH) {
    global $db;
    $ccid = md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    srand((double)microtime()*1000000); // seed the random number generator
    $random_start = @rand(0, (128-$length));
    $good_result = 0;
    while ($good_result == 0) {
      $id1=substr($ccid, $random_start,$length);
      $query = $db->Execute("select coupon_code
                             from " . TABLE_COUPONS . "
                             where coupon_code = '" . $id1 . "'");

      if ($query->RecordCount() < 1 ) $good_result = 1;
    }
    return $id1;
  }
////
// Update the Customers GV account
  function zen_gv_account_update($customer_id, $gv_id) {
    global $db;
    $customer_gv = $db->Execute("select amount
                                 from " . TABLE_COUPON_GV_CUSTOMER . "
                                 where customer_id = '" . $customer_id . "'");

    $coupon_gv = $db->Execute("select coupon_amount
                               from " . TABLE_COUPONS . "
                               where coupon_id = '" . $gv_id . "'");

    if ($customer_gv->RecordCount() > 0) {
      $new_gv_amount = $customer_gv->fields['amount'] + $coupon_gv->fields['coupon_amount'];
      $gv_query = $db->Execute("update " . TABLE_COUPON_GV_CUSTOMER . "
                                set amount = '" . $new_gv_amount . "'
                                where customer_id = '" . $customer_id . "'");

    } else {
      $db->Execute("insert into " . TABLE_COUPON_GV_CUSTOMER . " (customer_id, amount) values ('" . $customer_id . "', '" . $coupon_gv->fields['coupon_amount'] . "')");
    }
  }
////
// Output a day/month/year dropdown selector
function zen_draw_date_selector($prefix, $date='') {
    $month_array = array();
    $month_array[1] =_JANUARY;
    $month_array[2] =_FEBRUARY;
    $month_array[3] =_MARCH;
    $month_array[4] =_APRIL;
    $month_array[5] =_MAY;
    $month_array[6] =_JUNE;
    $month_array[7] =_JULY;
    $month_array[8] =_AUGUST;
    $month_array[9] =_SEPTEMBER;
    $month_array[10] =_OCTOBER;
    $month_array[11] =_NOVEMBER;
    $month_array[12] =_DECEMBER;
    $usedate = getdate($date);
    $day = $usedate['mday'];
    $month = $usedate['mon'];
    $year = $usedate['year'];
    $hour = $usedate['hours'];
    $date_selector = '时: <select name="'. $prefix .'_hour">';
    for ($i=0;$i<24;$i++){    /*time  from 0 to 23 fix by weishuiliang*/
    	$date_selector .= '<option value="' . $i . '"';
    	if ($i==$hour) $date_selector .= 'selected';
    	$date_selector .= '>' . $i . '</option>';
    }
    $date_selector .= '</select>';
    $date_selector .= ' 日: <select name="'. $prefix .'_day">';
    for ($i=1;$i<32;$i++){
      $date_selector .= '<option value="' . $i . '"';
      if ($i==$day) $date_selector .= 'selected';
      $date_selector .= '>' . $i . '</option>';
    }
    $date_selector .= '</select>';
    $date_selector .= ' 月: <select name="'. $prefix .'_month">';
    for ($i=1;$i<13;$i++){
      $date_selector .= '<option value="' . $i . '"';
      if ($i==$month) $date_selector .= 'selected';
      $date_selector .= '>' . $month_array[$i] . '</option>';
    }
    $date_selector .= '</select>';
    $date_selector .= ' 年: <select name="'. $prefix .'_year">';
    for ($i=2001;$i<=$year+1;$i++){
      $date_selector .= '<option value="' . $i . '"';
      if ($i==$year) $date_selector .= 'selected';
      $date_selector .= '>' . $i . '</option>';
    }
    $date_selector .= '</select>';
    return $date_selector;
  }

////
// Validate Option Name and Option Type Match
  function zen_validate_options_to_options_value($products_options_id, $products_options_values_id) {
    global $db;
    $check_options_to_values_query= $db->Execute("select products_options_id
                                                  from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . "
                                                  where products_options_id= '" . $products_options_id . "'
                                                  and products_options_values_id='" . $products_options_values_id .
                                                  "' limit 1");

    if ($check_options_to_values_query->RecordCount() != 1) {
      return false;
    } else {
      return true;
    }
  }

////
// look-up Attributues Options Name products_options_values_to_products_options
  function zen_get_products_options_name_from_value($lookup) {
    global $db;

    if ($lookup==0) {
      return 'RESERVED FOR TEXT/FILES ONLY ATTRIBUTES';
    }

    $check_options_to_values = $db->Execute("select products_options_id
                    from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . "
                    where products_options_values_id='" . $lookup . "'");

    $check_options = $db->Execute("select products_options_name
                      from " . TABLE_PRODUCTS_OPTIONS . "
                      where products_options_id='" . $check_options_to_values->fields['products_options_id']
                      . "' and language_id='" . $_SESSION['languages_id'] . "'");

    return $check_options->fields['products_options_name'];
  }


////
// lookup attributes model
  function zen_get_products_model($products_id) {
    global $db;
    $check = $db->Execute("select products_model
                    from " . TABLE_PRODUCTS . "
                    where products_id='" . $products_id . "'");

    return $check->fields['products_model'];
  }


////
// Check if product has attributes
  function zen_has_product_attributes_OLD($products_id) {
    global $db;
    $attributes = $db->Execute("select count(*) as count
                         from " . TABLE_PRODUCTS_ATTRIBUTES . "
                         where products_id = '" . (int)$products_id . "'");

    if ($attributes->fields['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }

////
// Check if product has attributes
  function zen_has_product_attributes($products_id, $not_readonly = 'true') {
    global $db;

    if (PRODUCTS_OPTIONS_TYPE_READONLY_IGNORED == '1' and $not_readonly == 'true') {
      // don't include READONLY attributes to determin if attributes must be selected to add to cart
      $attributes_query = "select pa.products_attributes_id
                           from " . TABLE_PRODUCTS_ATTRIBUTES . " pa left join " . TABLE_PRODUCTS_OPTIONS . " po on pa.options_id = po.products_options_id
                           where pa.products_id = '" . (int)$products_id . "' and po.products_options_type != '" . PRODUCTS_OPTIONS_TYPE_READONLY . "' limit 1";
    } else {
      // regardless of READONLY attributes no add to cart buttons
      $attributes_query = "select pa.products_attributes_id
                           from " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                           where pa.products_id = '" . (int)$products_id . "' limit 1";
    }

    $attributes = $db->Execute($attributes_query);

    if ($attributes->fields['products_attributes_id'] > 0) {
      return true;
    } else {
      return false;
    }
  }

////
// Check if product_id is valid
  function zen_products_id_valid($products_id) {
    global $db;
    $products_valid_query = "select count(*) as count
                         from " . TABLE_PRODUCTS . "
                         where products_id = '" . (int)$products_id . "'";

    $products_valid = $db->Execute($products_valid_query);

    if ($products_valid->fields['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }

function zen_copy_products_attributes($products_id_from, $products_id_to) {
  global $db;
  global $messageStack;
  global $copy_attributes_delete_first, $copy_attributes_duplicates_skipped, $copy_attributes_duplicates_overwrite, $copy_attributes_include_downloads, $copy_attributes_include_filename;

// Check for errors in copy request
  if ( (!zen_has_product_attributes($products_id_from, 'false') or !zen_products_id_valid($products_id_to)) or $products_id_to == $products_id_from ) {
    if ($products_id_to == $products_id_from) {
      // same products_id
      $messageStack->add_session('<b>WARNING: Cannot copy from Product ID #' . $products_id_from . ' to Product ID # ' . $products_id_to . ' ... No copy was made' . '</b>', 'caution');
    } else {
      if (!zen_has_product_attributes($products_id_from, 'false')) {
        // no attributes found to copy
        $messageStack->add_session('<b>WARNING: No Attributes to copy from Product ID #' . $products_id_from . ' for: ' . zen_get_products_name($products_id_from) . ' ... No copy was made' . '</b>', 'caution');
      } else {
        // invalid products_id
        $messageStack->add_session('<b>WARNING: There is no Product ID #' . $products_id_to . ' ... No copy was made' . '</b>', 'caution');
      }
    }
  } else {
// FIX HERE - remove once working

// check if product already has attributes
    $check_attributes = zen_has_product_attributes($products_id_to, 'false');

    if ($copy_attributes_delete_first=='1' and $check_attributes == true) {
// die('DELETE FIRST - Copying from ' . $products_id_from . ' to ' . $products_id_to . ' Do I delete first? ' . $copy_attributes_delete_first);
      // delete all attributes first from products_id_to
      zen_products_attributes_download_delete($products_id_to);
      $db->Execute("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $products_id_to . "'");
    }

// get attributes to copy from
    $products_copy_from= $db->Execute("select * from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id='" . $products_id_from . "'" . " order by products_attributes_id");

    while ( !$products_copy_from->EOF ) {
// This must match the structure of your products_attributes table

      $update_attribute = false;
      $add_attribute = true;
      $check_duplicate = $db->Execute("select * from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id='" . $products_id_to . "'" . " and options_id= '" . $products_copy_from->fields['options_id'] . "' and options_values_id='" . $products_copy_from->fields['options_values_id'] .  "'");
      if ($check_attributes == true) {
        if ($check_duplicate->RecordCount() == 0) {
          $update_attribute = false;
          $add_attribute = true;
        } else {
          if ($check_duplicate->RecordCount() == 0) {
            $update_attribute = false;
            $add_attribute = true;
          } else {
            $update_attribute = true;
            $add_attribute = false;
          }
        }
      } else {
        $update_attribute = false;
        $add_attribute = true;
      }

// die('UPDATE/IGNORE - Checking Copying from ' . $products_id_from . ' to ' . $products_id_to . ' Do I delete first? ' . ($copy_attributes_delete_first == '1' ? TEXT_YES : TEXT_NO) . ' Do I add? ' . ($add_attribute == true ? TEXT_YES : TEXT_NO) . ' Do I Update? ' . ($update_attribute == true ? TEXT_YES : TEXT_NO) . ' Do I skip it? ' . ($copy_attributes_duplicates_skipped=='1' ? TEXT_YES : TEXT_NO) . ' Found attributes in From: ' . $check_duplicate->RecordCount());

      if ($copy_attributes_duplicates_skipped == '1' and $check_duplicate->RecordCount() != 0) {
        // skip it
          $messageStack->add_session(TEXT_ATTRIBUTE_COPY_SKIPPING . $products_copy_from->fields['products_attributes_id'] . ' for Products ID#' . $products_id_to, 'caution');
      } else {
        if ($add_attribute == true) {
          // New attribute - insert it
          $db->Execute("insert into " . TABLE_PRODUCTS_ATTRIBUTES . " (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, products_options_sort_order, product_attribute_is_free, products_attributes_weight, products_attributes_weight_prefix, attributes_display_only, attributes_default, attributes_discounted, attributes_image, attributes_price_base_included, attributes_price_onetime, attributes_price_factor, attributes_price_factor_offset, attributes_price_factor_onetime, attributes_price_factor_onetime_offset, attributes_qty_prices, attributes_qty_prices_onetime, attributes_price_words, attributes_price_words_free, attributes_price_letters, attributes_price_letters_free, attributes_required) values (0, '" . $products_id_to . "',
          '" . $products_copy_from->fields['options_id'] . "',
          '" . $products_copy_from->fields['options_values_id'] . "',
          '" . $products_copy_from->fields['options_values_price'] . "',
          '" . $products_copy_from->fields['price_prefix'] . "',
          '" . $products_copy_from->fields['products_options_sort_order'] . "',
          '" . $products_copy_from->fields['product_attribute_is_free'] . "',
          '" . $products_copy_from->fields['products_attributes_weight'] . "',
          '" . $products_copy_from->fields['products_attributes_weight_prefix'] . "',
          '" . $products_copy_from->fields['attributes_display_only'] . "',
          '" . $products_copy_from->fields['attributes_default'] . "',
          '" . $products_copy_from->fields['attributes_discounted'] . "',
          '" . $products_copy_from->fields['attributes_image'] . "',
          '" . $products_copy_from->fields['attributes_price_base_included'] . "',
          '" . $products_copy_from->fields['attributes_price_onetime'] . "',
          '" . $products_copy_from->fields['attributes_price_factor'] . "',
          '" . $products_copy_from->fields['attributes_price_factor_offset'] . "',
          '" . $products_copy_from->fields['attributes_price_factor_onetime'] . "',
          '" . $products_copy_from->fields['attributes_price_factor_onetime_offset'] . "',
          '" . $products_copy_from->fields['attributes_qty_prices'] . "',
          '" . $products_copy_from->fields['attributes_qty_prices_onetime'] . "',
          '" . $products_copy_from->fields['attributes_price_words'] . "',
          '" . $products_copy_from->fields['attributes_price_words_free'] . "',
          '" . $products_copy_from->fields['attributes_price_letters'] . "',
          '" . $products_copy_from->fields['attributes_price_letters_free'] . "',
          '" . $products_copy_from->fields['attributes_required'] . "')");
          $messageStack->add_session(TEXT_ATTRIBUTE_COPY_INSERTING . $products_copy_from->fields['products_attributes_id'] . ' for Products ID#' . $products_id_to, 'caution');
        }
        if ($update_attribute == true) {
          // Update attribute - Just attribute settings not ids
          $db->Execute("update " . TABLE_PRODUCTS_ATTRIBUTES . " set
          options_values_price='" . $products_copy_from->fields['options_values_price'] . "',
          price_prefix='" . $products_copy_from->fields['price_prefix'] . "',
          products_options_sort_order='" . $products_copy_from->fields['products_options_sort_order'] . "',
          product_attribute_is_free='" . $products_copy_from->fields['product_attribute_is_free'] . "',
          products_attributes_weight='" . $products_copy_from->fields['products_attributes_weight'] . "',
          products_attributes_weight_prefix='" . $products_copy_from->fields['products_attributes_weight_prefix'] . "',
          attributes_display_only='" . $products_copy_from->fields['attributes_display_only'] . "',
          attributes_default='" . $products_copy_from->fields['attributes_default'] . "',
          attributes_discounted='" . $products_copy_from->fields['attributes_discounted'] . "',
          attributes_image='" . $products_copy_from->fields['attributes_image'] . "',
          attributes_price_base_included='" . $products_copy_from->fields['attributes_price_base_included'] . "',
          attributes_price_onetime='" . $products_copy_from->fields['attributes_price_onetime'] . "',
          attributes_price_factor='" . $products_copy_from->fields['attributes_price_factor'] . "',
          attributes_price_factor_offset='" . $products_copy_from->fields['attributes_price_factor_offset'] . "',
          attributes_price_factor_onetime='" . $products_copy_from->fields['attributes_price_factor_onetime'] . "',
          attributes_price_factor_onetime_offset='" . $products_copy_from->fields['attributes_price_factor_onetime_offset'] . "',
          attributes_qty_prices='" . $products_copy_from->fields['attributes_qty_prices'] . "',
          attributes_qty_prices_onetime='" . $products_copy_from->fields['attributes_qty_prices_onetime'] . "',
          attributes_price_words='" . $products_copy_from->fields['attributes_price_words'] . "',
          attributes_price_words_free='" . $products_copy_from->fields['attributes_price_words_free'] . "',
          attributes_price_letters='" . $products_copy_from->fields['attributes_price_letters'] . "',
          attributes_price_letters_free='" . $products_copy_from->fields['attributes_price_letters_free'] . "',
          attributes_required='" . $products_copy_from->fields['attributes_required'] . "'"
           . " where products_id='" . $products_id_to . "'" . " and options_id= '" . $products_copy_from->fields['options_id'] . "' and options_values_id='" . $products_copy_from->fields['options_values_id'] . "'");
//           . " where products_id='" . $products_id_to . "'" . " and options_id= '" . $products_copy_from->fields['options_id'] . "' and options_values_id='" . $products_copy_from->fields['options_values_id'] . "' and attributes_image='" . $products_copy_from->fields['attributes_image'] . "' and attributes_price_base_included='" . $products_copy_from->fields['attributes_price_base_included'] .  "'");
          $messageStack->add_session(TEXT_ATTRIBUTE_COPY_UPDATING . $products_copy_from->fields['products_attributes_id'] . ' for Products ID#' . $products_id_to, 'caution');
        }
      }

      $products_copy_from->MoveNext();
    } // end of products attributes while loop

     // reset products_price_sorter for searches etc.
     zen_update_products_price_sorter($products_id_to);
  } // end of no attributes or other errors
} // eof: zen_copy_products_attributes

////
// warning message
  function zen_output_warning($warning) {
    new errorBox(array(array('text' => zen_image(DIR_WS_ICONS . 'warning.gif', ICON_WARNING) . ' ' . $warning)));
  }


// function to return field type
// uses $tbl = table name, $fld = field name

  function zen_field_type($tbl, $fld) {
    global $db;
    $rs = $db->MetaColumns($tbl);
    $type = $rs[strtoupper($fld)]->type;
    return $type;
  }

// function to return field length
// uses $tbl = table name, $fld = field name
  function zen_field_length($tbl, $fld) {
    global $db;
    $rs = $db->MetaColumns($tbl);
    $length = $rs[strtoupper($fld)]->max_length;
    return $length;
  }

////
// return the size and maxlength settings in the form size="blah" maxlength="blah" based on maximum size being 50
// uses $tbl = table name, $fld = field name
// example: zen_set_field_length(TABLE_CATEGORIES_DESCRIPTION, 'categories_name')
  function zen_set_field_length($tbl, $fld, $max=50, $override=false) {
    $field_length= zen_field_length($tbl, $fld);
    switch (true) {
      case (($override == false and $field_length > $max)):
        $length= 'size = "' . ($max+1) . '" maxlength= "' . $field_length . '"';
        break;
      default:
        $length= 'size = "' . ($field_length+1) . '" maxlength = "' . $field_length . '"';
        break;
    }
    return $length;
  }


////
// Lookup Languages Icon
  function zen_get_language_icon($lookup) {
    global $db;
    $languages_icon = $db->Execute("select directory, image from " . TABLE_LANGUAGES . " where languages_id = '" . $lookup . "'");
    $icon= zen_image(DIR_WS_CATALOG_LANGUAGES . $languages_icon->fields['directory'] . '/images/' . $languages_icon->fields['image']);
    return $icon;
  }

////
// Get the Option Name for a particular language
  function zen_get_option_name_language($option, $language) {
    global $db;
    $lookup = $db->Execute("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id= '" . $option . "' and language_id = '" . $language . "'");
    return $lookup->fields['products_options_name'];
  }

////
// Get the Option Name for a particular language
  function zen_get_option_name_language_sort_order($option, $language) {
    global $db;
    $lookup = $db->Execute("select products_options_id, products_options_name, products_options_sort_order from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id= '" . $option . "' and language_id = '" . $language . "'");
    return $lookup->fields['products_options_sort_order'];
  }

////
// lookup attributes model
  function zen_get_language_name($lookup) {
    global $db;
    $check_language= $db->Execute("select directory from " . TABLE_LANGUAGES . " where languages_id = '" . $lookup . "'");
    return $check_language->fields['directory'];
  }


////
// Delete all product attributes
  function zen_delete_products_attributes($delete_product_id) {
    global $db;
    // delete associated downloads
    $products_delete_from= $db->Execute("select pa.products_id, pad.products_attributes_id from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad  where pa.products_id='" . $delete_product_id . "' and pad.products_attributes_id= pa.products_attributes_id");
    while (!$products_delete_from->EOF) {
      $db->Execute("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . $products_delete_from['products_attributes_id'] . "'");
      $products_delete_from->MoveNext();
    }

    $db->Execute("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $delete_product_id . "'");
}


////
// Set Product Attributes Sort Order to Products Option Value Sort Order
  function zen_update_attributes_products_option_values_sort_order($products_id) {
    global $db;
    $attributes_sort_order = $db->Execute("select distinct pa.products_attributes_id, pa.options_id, pa.options_values_id, pa.products_options_sort_order, pov.products_options_values_sort_order from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . $products_id . "' and pa.options_values_id = pov.products_options_values_id");
    while (!$attributes_sort_order->EOF) {
      $db->Execute("update " . TABLE_PRODUCTS_ATTRIBUTES . " set products_options_sort_order = '" . $attributes_sort_order->fields['products_options_values_sort_order'] . "' where products_id = '" . $products_id . "' and products_attributes_id = '" . $attributes_sort_order->fields['products_attributes_id'] . "'");
      $attributes_sort_order->MoveNext();
    }
  }

////
// product pulldown with attributes
  function zen_draw_products_pull_down_attributes($name, $parameters = '', $exclude = '') {
    global $db, $currencies;

    if ($exclude == '') {
      $exclude = array();
    }

    $select_string = '<select name="' . $name . '"';

    if ($parameters) {
      $select_string .= ' ' . $parameters;
    }

    $select_string .= '>';

    $new_fields=', p.products_model';

    $products = $db->Execute("select distinct p.products_id, pd.products_name, p.products_price" . $new_fields .
        " from " . TABLE_PRODUCTS . " p, " .
        TABLE_PRODUCTS_DESCRIPTION . " pd, " .
        TABLE_PRODUCTS_ATTRIBUTES . " pa " .
        " where p.products_id= pa.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by products_name");

    while (!$products->EOF) {
      if (!in_array($products->fields['products_id'], $exclude)) {
        $display_price = zen_get_products_base_price($products->fields['products_id']);
        $select_string .= '<option value="' . $products->fields['products_id'] . '">' . $products->fields['products_name'] . ' (' . TEXT_MODEL . ' ' . $products->fields['products_model'] . ') (' . $currencies->format($display_price) . ')</option>';
      }
      $products->MoveNext();
    }

    $select_string .= '</select>';

    return $select_string;
  }


////
// categories pulldown with products
  function zen_draw_products_pull_down_categories($name, $parameters = '', $exclude = '', $show_id = false, $show_parent = false) {
    global $db, $currencies;

    if ($exclude == '') {
      $exclude = array();
    }

    $select_string = '<select name="' . $name . '"';

    if ($parameters) {
      $select_string .= ' ' . $parameters;
    }

    $select_string .= '>';

    $categories = $db->Execute("select distinct c.categories_id, cd.categories_name " .
        " from " . TABLE_CATEGORIES . " c, " .
        TABLE_CATEGORIES_DESCRIPTION . " cd, " .
        TABLE_PRODUCTS_TO_CATEGORIES . " ptoc " .
        " where ptoc.categories_id = c.categories_id and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by categories_name");

    while (!$categories->EOF) {
      if (!in_array($categories->fields['categories_id'], $exclude)) {
        if ($show_parent == true) {
          $parent = zen_get_products_master_categories_name($categories->fields['categories_id']);
          if ($parent != '') {
            $parent = ' : in ' . $parent;
          }
        } else {
          $parent = '';
        }
        $select_string .= '<option value="' . $categories->fields['categories_id'] . '">' . $categories->fields['categories_name'] . $parent . ($show_id ? ' - ID#' . $categories->fields['categories_id'] : '') . '</option>';
      }
      $categories->MoveNext();
    }

    $select_string .= '</select>';

    return $select_string;
  }

////
// categories pulldown with products with attributes
  function zen_draw_products_pull_down_categories_attributes($name, $parameters = '', $exclude = '') {
    global $db, $currencies;

    if ($exclude == '') {
      $exclude = array();
    }

    $select_string = '<select name="' . $name . '"';

    if ($parameters) {
      $select_string .= ' ' . $parameters;
    }

    $select_string .= '>';

    $categories = $db->Execute("select distinct c.categories_id, cd.categories_name " .
        " from " . TABLE_CATEGORIES . " c, " .
        TABLE_CATEGORIES_DESCRIPTION . " cd, " .
        TABLE_PRODUCTS_TO_CATEGORIES . " ptoc, " .
        TABLE_PRODUCTS_ATTRIBUTES . " pa " .
        " where pa.products_id= ptoc.products_id and ptoc.categories_id= c.categories_id and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by categories_name");
    while (!$categories->EOF) {
      if (!in_array($categories->fields['categories_id'], $exclude)) {
        $select_string .= '<option value="' . $categories->fields['categories_id'] . '">' . $categories->fields['categories_name'] . '</option>';
      }
      $categories->MoveNext();
    }

    $select_string .= '</select>';

    return $select_string;
  }

  function zen_get_top_level_domain($url) {
    if (strpos($url, '://')) {
      $url = parse_url($url);
      $url = $url['host'];
    }
    $domain_array = explode('.', $url);
    $domain_size = sizeof($domain_array);
    if ($domain_size > 1) {
      if (SESSION_USE_FQDN == 'True') return $url;
      if (is_numeric($domain_array[$domain_size-2]) && is_numeric($domain_array[$domain_size-1])) {
        return false;
      } else {
        if ($domain_size > 3) {
          return $domain_array[$domain_size-3] . '.' . $domain_array[$domain_size-2] . '.' . $domain_array[$domain_size-1];
        } else {
          return $domain_array[$domain_size-2] . '.' . $domain_array[$domain_size-1];
        }
      }
    } else {
      return false;
    }
  }

////
// Check if a demo is active
  function zen_admin_demo() {
    global $db;
    if (ADMIN_DEMO == '1') {
      $admin_current = $db->Execute("select admin_level from " . TABLE_ADMIN . " where admin_id='" . $_SESSION['admin_id'] . "'");
      if ($admin_current->fields['admin_level'] == '1') {
        $demo_on = false;
      } else {
        $demo_on = true;
      }
    } else {
      $demo_on = false;
    }
    return $demo_on;
  }

////
//
  function zen_has_product_attributes_downloads($products_id, $check_valid=false) {
    global $db;
    if (DOWNLOAD_ENABLED == 'true') {
      $download_display_query_raw ="select pa.products_attributes_id, pad.products_attributes_filename
                                    from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                    where pa.products_id='" . $products_id . "'
                                      and pad.products_attributes_id= pa.products_attributes_id";
      $download_display = $db->Execute($download_display_query_raw);
      if ($check_valid == true) {
        $valid_downloads = '';
        while (!$download_display->EOF) {
          if (!file_exists(DIR_FS_DOWNLOAD . $download_display->fields['products_attributes_filename'])) {
            $valid_downloads .= '<br />&nbsp;&nbsp;' . zen_image(DIR_WS_IMAGES . 'icon_status_red.gif') . ' Invalid: ' . $download_display->fields['products_attributes_filename'];
            // break;
          } else {
            $valid_downloads .= '<br />&nbsp;&nbsp;' . zen_image(DIR_WS_IMAGES . 'icon_status_green.gif') . ' Valid&nbsp;&nbsp;: ' . $download_display->fields['products_attributes_filename'];
          }
          $download_display->MoveNext();
        }
      } else {
        if ($download_display->RecordCount() != 0) {
          $valid_downloads = $download_display->RecordCount() . ' files';
        } else {
          $valid_downloads = 'none';
        }
      }
    } else {
      $valid_downloads = 'disabled';
    }
    return $valid_downloads;
  }

////
// check if Product is set to use downloads
// does not validate download filename
  function zen_has_product_attributes_downloads_status($products_id) {
    global $db;
    if (DOWNLOAD_ENABLED == 'true') {
      $download_display_query_raw ="select pa.products_attributes_id, pad.products_attributes_filename
                                    from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                    where pa.products_id='" . $products_id . "'
                                      and pad.products_attributes_id= pa.products_attributes_id";

      $download_display = $db->Execute($download_display_query_raw);
      if ($download_display->RecordCount() != 0) {
        $valid_downloads = false;
      } else {
        $valid_downloads = true;
      }
    } else {
      $valid_downloads = false;
    }
    return $valid_downloads;
  }

////
// Construct a category path to the product
// TABLES: products_to_categories
  function zen_get_product_path($products_id, $status_override = '1') {
    global $db;
    $cPath = '';

    $category_query = "select p2c.categories_id
                       from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                       where p.products_id = '" . (int)$products_id . "' " .
                       ($status_override == 1 ? " and p.products_status = 1 " : '') . "
                       and p.products_id = p2c.products_id limit 1";

    $category = $db->Execute($category_query);

    if ($category->RecordCount() > 0) {

      $categories = array();
      zen_get_parent_categories($categories, $category->fields['categories_id']);

      $categories = array_reverse($categories);

      $cPath = implode('_', $categories);

      if (zen_not_null($cPath)) $cPath .= '_';
      $cPath .= $category->fields['categories_id'];
    }

    return $cPath;
  }

////
// Recursively go through the categories and retreive all parent categories IDs
// TABLES: categories
  function zen_get_parent_categories(&$categories, $categories_id) {
    global $db;
    $parent_categories_query = "select parent_id
                                from " . TABLE_CATEGORIES . "
                                where categories_id = '" . (int)$categories_id . "'";

    $parent_categories = $db->Execute($parent_categories_query);

    while (!$parent_categories->EOF) {
      if ($parent_categories->fields['parent_id'] == 0) return true;
      $categories[sizeof($categories)] = $parent_categories->fields['parent_id'];
      if ($parent_categories->fields['parent_id'] != $categories_id) {
        zen_get_parent_categories($categories, $parent_categories->fields['parent_id']);
      }
      $parent_categories->MoveNext();
    }
  }

////
// Return a product's category
// TABLES: products_to_categories
  function zen_get_products_category_id($products_id) {
    global $db;

    $the_products_category_query = "select products_id, categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $products_id . "'" . " order by products_id,categories_id";
    $the_products_category = $db->Execute($the_products_category_query);

    return $the_products_category->fields['categories_id'];
  }


////
// Count how many subcategories exist in a category
// TABLES: categories
// old name zen_get_parent_category_name
  function zen_get_products_master_categories_name($categories_id) {
    global $db;

    $categories_lookup = $db->Execute("select parent_id
                                from " . TABLE_CATEGORIES . "
                                where categories_id = '" . (int)$categories_id . "'");

    $parent_name = zen_get_category_name($categories_lookup->fields['parent_id'], (int)$_SESSION['languages_id']);

    return $parent_name;
  }


////
// configuration key value lookup
  function zen_get_configuration_key_value($lookup) {
    global $db;
    $configuration_query= $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='" . $lookup . "'");
    $lookup_value= $configuration_query->fields['configuration_value'];
    if ( $configuration_query->RecordCount() == 0 ) {
      $lookup_value='<span class="lookupAttention">' . $lookup . '</span>';
    }
    return $lookup_value;
  }


////
// enable shipping
  function zen_get_shipping_enabled($shipping_module) {
    global $PHP_SELF, $cart, $order;

    // for admin always true if installed
    if (strstr($PHP_SELF, FILENAME_MODULES)) {
      return true;
    }

    $check_cart_free = $_SESSION['cart']->in_cart_check('product_is_always_free_shipping','1');
    $check_cart_cnt = $_SESSION['cart']->count_contents();
    $check_cart_weight = $_SESSION['cart']->show_weight();

    switch(true) {
      // for admin always true if installed
      case (strstr($PHP_SELF, FILENAME_MODULES)):
        return true;
        break;
      // Free Shipping when 0 weight - enable freeshipper - ORDER_WEIGHT_ZERO_STATUS must be on
      case (ORDER_WEIGHT_ZERO_STATUS == '1' and ($check_cart_weight == 0 and $shipping_module == 'freeshipper')):
        return true;
        break;
      // Free Shipping when 0 weight - disable everyone - ORDER_WEIGHT_ZERO_STATUS must be on
      case (ORDER_WEIGHT_ZERO_STATUS == '1' and ($check_cart_weight == 0 and $shipping_module != 'freeshipper')):
        return false;
        break;
      // Always free shipping only true - enable freeshipper
      case (($check_cart_free == $check_cart_cnt) and $shipping_module == 'freeshipper'):
        return true;
        break;
      // Always free shipping only true - disable everyone
      case (($check_cart_free == $check_cart_cnt) and $shipping_module != 'freeshipper'):
        return false;
        break;
      // Always free shipping only is false - disable freeshipper
      case (($check_cart_free != $check_cart_cnt) and $shipping_module == 'freeshipper'):
        return false;
        break;
      default:
        return true;
        break;
    }
  }

  function zen_get_handler_from_type($product_type) {
    global $db;

    $sql = "select type_handler from " . TABLE_PRODUCT_TYPES . " where type_id = '" . $product_type . "'";
    $handler = $db->Execute($sql);
	return $handler->fields['type_handler'];
  }

/*
////
// Sets the status of a featured product
  function zen_set_featured_status($featured_id, $status) {
    global $db;
    if ($status == '1') {
      return $db->Execute("update " . TABLE_FEATURED . "
                           set status = '1', expires_date = NULL, date_status_change = NULL
                           where featured_id = '" . (int)$featured_id . "'");

    } elseif ($status == '0') {
      return $db->Execute("update " . TABLE_FEATURED . "
                           set status = '0', date_status_change = now()
                           where featured_id = '" . (int)$featured_id . "'");

    } else {
      return -1;
    }
  }
*/

////
// Sets the status of a product review
  function zen_set_reviews_status($review_id, $status) {
    global $db;
    if ($status == '1') {
      return $db->Execute("update " . TABLE_REVIEWS . "
                           set status = 1
                           where reviews_id = '" . (int)$review_id . "'");

    } elseif ($status == '0') {
      return $db->Execute("update " . TABLE_REVIEWS . "
                           set status = 0
                           where reviews_id = '" . (int)$review_id . "'");

    } else {
      return -1;
    }
  }






////
// set the products_price_sorter
  function zen_update_products_price_sorter($product_id) {
    global $db;

    $products_price_sorter = zen_get_products_actual_price($product_id);

    $db->Execute("update " . TABLE_PRODUCTS . " set
         products_price_sorter='" . zen_db_prepare_input($products_price_sorter) . "'
         where products_id='" . $product_id . "'");

  }

////
// configuration key value lookup in TABLE_PRODUCT_TYPE_LAYOUT
  function zen_get_configuration_key_value_layout($lookup, $type=1) {
    global $db;
    $configuration_query= $db->Execute("select configuration_value from " . TABLE_PRODUCT_TYPE_LAYOUT . " where configuration_key='" . $lookup . "' and product_type_id='". $type . "'");
    $lookup_value= $configuration_query->fields['configuration_value'];
    if ( !($lookup_value) ) {
      $lookup_value='<span class="lookupAttention">' . $lookup . '</span>';
    }
    return $lookup_value;
  }

////
// Return true if the category has subcategories
// TABLES: categories
  function zen_has_category_subcategories($category_id) {
    global $db;
    $child_category_query = "select count(*) as count
                             from " . TABLE_CATEGORIES . "
                             where parent_id = '" . (int)$category_id . "'";

    $child_category = $db->Execute($child_category_query);

    if ($child_category->fields['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }

////
  function zen_get_categories($categories_array = '', $parent_id = '0', $indent = '') {
    global $db;

    if (!is_array($categories_array)) $categories_array = array();

    $categories_query = "select c.categories_id, cd.categories_name
                         from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                         where parent_id = '" . (int)$parent_id . "'
                         and c.categories_id = cd.categories_id
                         and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                         order by sort_order, cd.categories_name";

    $categories = $db->Execute($categories_query);

    while (!$categories->EOF) {
      $categories_array[] = array('id' => $categories->fields['categories_id'],
                                  'text' => $indent . $categories->fields['categories_name']);

      if ($categories->fields['categories_id'] != $parent_id) {
        $categories_array = zen_get_categories($categories_array, $categories->fields['categories_id'], $indent . '&nbsp;&nbsp;');
      }
      $categories->MoveNext();
    }

    return $categories_array;
  }

  /**
   * WSL
   * @param int $categories_id
   * @return object|queryFactoryResult
   */
  function get_parent_id_from_categories($categories_id){
  	global $db,$memcache;
  	$memcache_key = md5(MEMCACHE_PREFIX . 'parent_id' . $categories_id);
  	$data = $memcache->get($memcache_key);
  	if ($data || gettype($data) != 'boolean') {
  		return $data;
  	}
  	$categories_sql = "SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE categories_id = " . (int)$categories_id;
  	$categories_query = $db->Execute($categories_sql);
  	$memcache->set($memcache_key,$categories_query,false,604800);
  	return $categories_query;
  
  }
  /**
   * return categories info by categories
   * WSL
   * @param int $categories_id
   * @return array|multitype:
   */
  function get_categories_info($categories_id){
  	global $db,$memcache;
  	$memcache_key = md5(MEMCACHE_PREFIX . 'categories_info' . $categories_id);
  	$data = $memcache->get($memcache_key);
  	if($data || gettype($data) != 'boolean' ){
  		return $data;
  	}
  	$categories_sql = "SELECT categories_id, categories_code,categories_image,parent_id,sort_order,date_added,last_modified,categories_status,categories_level,display_pic,chinese_info FROM " . TABLE_CATEGORIES . " WHERE categories_id = " . (int)$categories_id;
  	$categories_query = $db->Execute($categories_sql);
  	if($categories_query->RecordCount() > 0){
  		$return_array = array();
  		while(!$categories_query->EOF){
  			$return_array = $categories_query->fields;
  			$categories_query->MoveNext();
  		}
  	}
  	$memcache->set($memcache_key,$return_array,false,604800);
  	return $return_array;
  }
  
  /**
   * return table categories_description info
   * WSL
   * @param int $category_id
   * @param int $languages_id
   * @return array|queryFactoryResult
   */
  function get_categories_description($category_id,$languages_id){
  	global $db,$memcache;
  	if(isset($languages_id) && $languages_id != ''){
  		$languages_id = $languages_id;
  	}else{
  		$languages_id = '1';//english
  	}
  	$memcache_key = md5(MEMCACHE_PREFIX . 'categories_description' . $category_id . $languages_id);
  	$data = $memcache->get($memcache_key);
  	if($data || gettype($data) != 'boolean'){
  		return $data;
  	}
  	$sql = "select categories_name,categories_description,categories_id,language_id from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = " . (int)$category_id . " AND language_id = '" . (int)$languages_id . "'";
  	$categories_query = $db->Execute($sql);
  	$return_array = array();
  	if($categories_query->RecordCount() > 0){
  		while(!$categories_query->EOF){
  			$return_array = $categories_query->fields;
  			$categories_query->MoveNext();
  		}
  	}
  	$memcache->set($memcache_key,$return_array,false,604800);
  	return $return_array;
  }
  
////
// Get the status of a category
  function zen_get_categories_status($categories_id) {
    global $db;
    $sql = "select categories_status from " . TABLE_CATEGORIES . (zen_not_null($categories_id) ? " where categories_id=" . $categories_id : "");
    $check_status = $db->Execute($sql);
    return $check_status->fields['categories_status'];
  }

////
// Get the status of a product
  function zen_get_products_status($product_id) {
    global $db;
    $sql = "select products_status from " . TABLE_PRODUCTS . (zen_not_null($product_id) ? " where products_id=" . $product_id : "");
    $check_status = $db->Execute($sql);
    return $check_status->fields['products_status'];
  }

////
// check if linked
  function zen_get_product_is_linked($product_id, $show_count = 'false') {
    global $db;

    $sql = "select * from " . TABLE_PRODUCTS_TO_CATEGORIES . (zen_not_null($product_id) ? " where products_id=" . $product_id : "");
    $check_linked = $db->Execute($sql);
    if ($check_linked->RecordCount() > 1) {
      if ($show_count == 'true') {
        return $check_linked->RecordCount();
      } else {
        return 'true';
      }
    } else {
      return 'false';
    }
  }


////
// TABLES: categories_name from products_id
  function zen_get_categories_name_from_product($product_id) {
    global $db;

    $check_products_category= $db->Execute("select products_id, categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id='" . $product_id . "' limit 1");
    $the_categories_name= $db->Execute("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id= '" . $check_products_category->fields['categories_id'] . "' and language_id= '" . $_SESSION['languages_id'] . "'");

    return $the_categories_name->fields['categories_name'];
  }

  function zen_count_products_in_cats($category_id) {
    global $db;
    $cat_products_query = "select count(if (p.products_status=1,1,NULL)) as pr_on, count(*) as total
                           from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                           where p.products_id = p2c.products_id
                           and p2c.categories_id = '" . (int)$category_id . "'";

    $pr_count = $db->Execute($cat_products_query);
//    echo $pr_count->RecordCount();
    $c_array['this_count'] += $pr_count->fields['total'];
    $c_array['this_count_on'] += $pr_count->fields['pr_on'];

    $cat_child_categories_query = "select categories_id
                               from " . TABLE_CATEGORIES . "
                               where parent_id = '" . (int)$category_id . "'";

    $cat_child_categories = $db->Execute($cat_child_categories_query);

    if ($cat_child_categories->RecordCount() > 0) {
      while (!$cat_child_categories->EOF) {
          $m_array = zen_count_products_in_cats($cat_child_categories->fields['categories_id']);
          $c_array['this_count'] += $m_array['this_count'];
          $c_array['this_count_on'] += $m_array['this_count_on'];

//          $this_count_on += $pr_count->fields['pr_on'];
        $cat_child_categories->MoveNext();
      }
    }
    return $c_array;
 }

////
// Return the number of products in a category
// TABLES: products, products_to_categories, categories
// syntax for count: zen_get_products_to_categories($categories->fields['categories_id'], true)
// syntax for linked products: zen_get_products_to_categories($categories->fields['categories_id'], true, 'products_active')
  function zen_get_products_to_categories($category_id, $include_inactive = false, $counts_what = 'products') {
    global $db;

    $products_count = 0;
    if ($include_inactive == true) {
      switch ($counts_what) {
        case ('products'):
        $cat_products_query = "select count(*) as total
                           from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                           where p.products_id = p2c.products_id
                           and p2c.categories_id = '" . (int)$category_id . "'";
        break;
        case ('products_active'):
        $cat_products_query = "select p.products_id
                           from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                           where p.products_id = p2c.products_id
                           and p2c.categories_id = '" . (int)$category_id . "'";
        break;
      }

    } else {
      switch ($counts_what) {
        case ('products'):
          $cat_products_query = "select count(*) as total
                             from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                             where p.products_id = p2c.products_id
                             and p.products_status = 1
                             and p2c.categories_id = '" . (int)$category_id . "'";
        break;
        case ('products_active'):
          $cat_products_query = "select p.products_id
                             from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                             where p.products_id = p2c.products_id
                             and p.products_status = 1
                             and p2c.categories_id = '" . (int)$category_id . "'";
        break;
      }

    }
    $cat_products = $db->Execute($cat_products_query);
      switch ($counts_what) {
        case ('products'):
          $cat_products_count += $cat_products->fields['total'];
          break;
        case ('products_active'):
        while (!$cat_products->EOF) {
          if (zen_get_product_is_linked($cat_products->fields['products_id']) == 'true') {
            return $products_linked = 'true';
          }
          $cat_products->MoveNext();
        }
          break;
      }

    $cat_child_categories_query = "select categories_id
                               from " . TABLE_CATEGORIES . "
                               where parent_id = '" . (int)$category_id . "'";

    $cat_child_categories = $db->Execute($cat_child_categories_query);

    if ($cat_child_categories->RecordCount() > 0) {
      while (!$cat_child_categories->EOF) {
      switch ($counts_what) {
        case ('products'):
          $cat_products_count += zen_get_products_to_categories($cat_child_categories->fields['categories_id'], $include_inactive);
          break;
        case ('products_active'):
          if (zen_get_products_to_categories($cat_child_categories->fields['categories_id'], true, 'products_active') == 'true') {
            return $products_linked = 'true';
          }
          break;
        }
        $cat_child_categories->MoveNext();
      }
    }


      switch ($counts_what) {
        case ('products'):
          return $cat_products_count;
          break;
        case ('products_active'):
          return $products_linked;
          break;
      }
  }

////
// master category selection
  function zen_get_master_categories_pulldown($product_id) {
    global $db;

    $master_category_array = array();

    $master_categories_query = $db->Execute("select ptc.products_id, cd.categories_name, cd.categories_id
                                    from " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc
                                    left join " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                    on cd.categories_id = ptc.categories_id
                                    where ptc.products_id='" . $product_id . "'
                                    and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                    ");

    $master_category_array[] = array('id' => '0', 'text' => TEXT_INFO_SET_MASTER_CATEGORIES_ID);
    while (!$master_categories_query->EOF) {
      $master_category_array[] = array('id' => $master_categories_query->fields['categories_id'], 'text' => $master_categories_query->fields['categories_name'] . TEXT_INFO_ID . $master_categories_query->fields['categories_id']);
      $master_categories_query->MoveNext();
    }

    return $master_category_array;
  }

////
// get products type
  function zen_get_products_type($product_id) {
    global $db;

    $check_products_type = $db->Execute("select products_type from " . TABLE_PRODUCTS . " where products_id='" . $product_id . "'");
    return $check_products_type->fields['products_type'];
  }

 /* function zen_draw_admin_box($zf_header, $zf_content) {
    $zp_boxes = '<li class="submenu"><a target="_top" href="' . $zf_header['link'] . '">' . $zf_header['text'] . '</a>';
    $zp_boxes .= '<UL>' . "\n";
    for ($i=0; $i<sizeof($zf_content); $i++) {
      $zp_boxes .= '<li>';
      $zp_boxes .= '<a href="' . $zf_content[$i]['link'] . '">' . $zf_content[$i]['text'] . '</a>';
      $zp_boxes .= '</li>' . "\n";
    }
    $zp_boxes .= '</UL>' . "\n";
    $zp_boxes .= '</li>' . "\n";
    return $zp_boxes;
  }
  */

function zen_draw_admin_box ($zf_header, $zf_content)
{
  $zp_boxes = '  <li class="submenu">' . "\n";
  $zp_boxes .= '    <a target="_top" href="' . $zf_header['link'] . '">' . $zf_header['text'] . '</a>' . "\n";
  $zp_boxes .= '    <ul>' . "\n";
  for ($i = 0, $sizeof = sizeof($zf_content); $i < $sizeof; ++$i)
  {
    if (page_allowed(extract_page($zf_content[$i]['link'])))
    {
      $zp_boxes .= '      <li><a href="' . $zf_content[$i]['link'] . '">' . $zf_content[$i]['text'] . '</a></li>' . "\n";
    }
  }
  $zp_boxes .= '    </ul>' . "\n";
  $zp_boxes .= '  </li>' . "\n";
  return $zp_boxes;
}





////
//  ++++ modified for UPS Choice 1.8 and USPS Methods 2.5 by Brad Waite and Fritz Clapp ++++
//  ++++ modified for USPS Methods 2.5 08/02/03 by Brad Waite and Fritz Clapp ++++
// USPS Methods 2.5
// Alias function for Store configuration values in the Administration Tool
  function zen_cfg_select_multioption($select_array, $key_value, $key = '') {
    for ($i=0; $i<sizeof($select_array); $i++) {
      $name = (($key) ? 'configuration[' . $key . '][]' : 'configuration_value');
      $string .= '<br><input type="checkbox" name="' . $name . '" value="' . $select_array[$i] . '"';
      $key_values = explode( ", ", $key_value);
      if ( in_array($select_array[$i], $key_values) ) $string .= ' CHECKED';
      $string .= ' id="' . strtolower($select_array[$i] . '-' . $name) . '"> ' . '<label for="' . strtolower($select_array[$i] . '-' . $name) . '" class="inputSelect">' . $select_array[$i] . '</label>' . "\n";
    }
    $string .= '<input type="hidden" name="' . $name . '" value="--none--">';
    return $string;
  }

////
// get products image
  function zen_get_products_image($product_id) {
    global $db;
    $product_image = $db->Execute("select products_image
                                   from " . TABLE_PRODUCTS . "
                                   where products_id = '" . (int)$product_id . "'");

    return $product_image->fields['products_image'];
  }


////
// remove common HTML from text for display as paragraph
  function zen_clean_html($clean_it) {

    $clean_it = preg_replace('/\r/', ' ', $clean_it);
    $clean_it = preg_replace('/\t/', ' ', $clean_it);
    $clean_it = preg_replace('/\n/', ' ', $clean_it);

    $clean_it= nl2br($clean_it);

// update breaks with a space for text displays in all listings with descriptions
    while (strstr($clean_it, '<br>')) $clean_it = str_replace('<br>', ' ', $clean_it);
    while (strstr($clean_it, '<br />')) $clean_it = str_replace('<br />', ' ', $clean_it);
    while (strstr($clean_it, '<br/>')) $clean_it = str_replace('<br/>', ' ', $clean_it);
    while (strstr($clean_it, '<p>')) $clean_it = str_replace('<p>', ' ', $clean_it);
    while (strstr($clean_it, '</p>')) $clean_it = str_replace('</p>', ' ', $clean_it);

    while (strstr($clean_it, '  ')) $clean_it = str_replace('  ', ' ', $clean_it);

// remove other html code to prevent problems on display of text
    $clean_it = strip_tags($clean_it);
    return $clean_it;
  }


////
// find template or default file
  function zen_get_file_directory($check_directory, $check_file, $dir_only = 'false') {
    global $template_dir;

    $zv_filename = $check_file;
    if (!strstr($zv_filename, '.php')) $zv_filename .= '.php';

    if (file_exists($check_directory . $template_dir . '/' . $zv_filename)) {
      $zv_directory = $check_directory . $template_dir . '/';
    } else {
      $zv_directory = $check_directory;
    }

    if ($dir_only == 'true') {
      return $zv_directory;
    } else {
      return $zv_directory . $zv_filename;
    }
  }

////
// Recursive algorithim to restrict all sub_categories to a rpoduct type
  function zen_restrict_sub_categories($zf_cat_id, $zf_type) {
    global $db;
    $zp_sql = "select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . $zf_cat_id . "'";
    $zq_sub_cats = $db->Execute($zp_sql);
    while (!$zq_sub_cats->EOF) {
      $zp_sql = "select * from " . TABLE_PRODUCT_TYPES_TO_CATEGORY . "
                         where category_id = '" . $zq_sub_cats->fields['categories_id'] . "'
                         and product_type_id = '" . $zf_type . "'";

      $zq_type_to_cat = $db->Execute($zp_sql);

      if ($zq_type_to_cat->RecordCount() < 1) {
        $za_insert_sql_data = array('category_id' => $zq_sub_cats->fields['categories_id'],
                                    'product_type_id' => $zf_type);
        zen_db_perform(TABLE_PRODUCT_TYPES_TO_CATEGORY, $za_insert_sql_data);
      }
      zen_restrict_sub_categories($zq_sub_cats->fields['categories_id'], $zf_type);
      $zq_sub_cats->MoveNext();
    }
  }


////
// Recursive algorithim to restrict all sub_categories to a rpoduct type
  function zen_remove_restrict_sub_categories($zf_cat_id, $zf_type) {
    global $db;
    $zp_sql = "select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . $zf_cat_id . "'";
    $zq_sub_cats = $db->Execute($zp_sql);
    while (!$zq_sub_cats->EOF) {
        $sql = "delete from " .  TABLE_PRODUCT_TYPES_TO_CATEGORY . "
                where category_id = '" . $zq_sub_cats->fields['categories_id'] . "'
                and product_type_id = '" . $zf_type . "'";

        $db->Execute($sql);
      zen_remove_restrict_sub_categories($zq_sub_cats->fields['categories_id'], $zf_type);
      $zq_sub_cats->MoveNext();
    }
  }


// build configuration_key based on product type and return its value
// example: To get the settings for metatags_products_name_status for a product use:
// zen_get_show_product_switch($_GET['pID'], 'metatags_products_name_status')
// the product is looked up for the products_type which then builds the configuration_key example:
// SHOW_PRODUCT_INFO_METATAGS_PRODUCTS_NAME_STATUS
// the value of the configuration_key is then returned
// NOTE: keys are looked up first in the product_type_layout table and if not found looked up in the configuration table.
    function zen_get_show_product_switch($lookup, $field, $suffix= 'SHOW_', $prefix= '_INFO', $field_prefix= '_', $field_suffix='') {
      global $db;

      $sql = "select products_type from " . TABLE_PRODUCTS . " where products_id='" . $lookup . "'";
      $type_lookup = $db->Execute($sql);

      $sql = "select type_handler from " . TABLE_PRODUCT_TYPES . " where type_id = '" . $type_lookup->fields['products_type'] . "'";
      $show_key = $db->Execute($sql);

      $zv_key = strtoupper($suffix . $show_key->fields['type_handler'] . $prefix . $field_prefix . $field . $field_suffix);

      $sql = "select configuration_key, configuration_value from " . TABLE_PRODUCT_TYPE_LAYOUT . " where configuration_key='" . $zv_key . "'";
      $zv_key_value = $db->Execute($sql);
//echo 'I CAN SEE - look ' . $lookup . ' - field ' . $field . ' - key ' . $zv_key . ' value ' . $zv_key_value->fields['configuration_value'] .'<br>';

      if ($zv_key_value->RecordCount() > 0) {
        return $zv_key_value->fields['configuration_value'];
      } else {
        $sql = "select configuration_key, configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='" . $zv_key . "'";
        $zv_key_value = $db->Execute($sql);
        if ($zv_key_value->RecordCount() > 0) {
          return $zv_key_value->fields['configuration_value'];
        } else {
          return $zv_key_value->fields['configuration_value'];
        }
      }
    }


////
// return switch name
    function zen_get_show_product_switch_name($lookup, $field, $suffix= 'SHOW_', $prefix= '_INFO', $field_prefix= '_', $field_suffix='') {
      global $db;

      $sql = "select products_type from " . TABLE_PRODUCTS . " where products_id='" . $lookup . "'";
      $type_lookup = $db->Execute($sql);

      $sql = "select type_handler from " . TABLE_PRODUCT_TYPES . " where type_id = '" . $type_lookup->fields['products_type'] . "'";
      $show_key = $db->Execute($sql);


      $zv_key = strtoupper($suffix . $show_key->fields['type_handler'] . $prefix . $field_prefix . $field . $field_suffix);

      return $zv_key;
    }


////
// compute the days between two dates
  function zen_date_diff($date1, $date2) {
  //$date1  today, or any other day
  //$date2  date to check against

    $d1 = explode("-", $date1);
    $y1 = $d1[0];
    $m1 = $d1[1];
    $d1 = $d1[2];

    $d2 = explode("-", $date2);
    $y2 = $d2[0];
    $m2 = $d2[1];
    $d2 = $d2[2];

    $date1_set = mktime(0,0,0, $m1, $d1, $y1);
    $date2_set = mktime(0,0,0, $m2, $d2, $y2);

    return(round(($date2_set-$date1_set)/(60*60*24)));
  }

////
// check that a download filename exists
  function zen_orders_products_downloads($check_filename) {
    global $db;

    $valid_downloads = true;

    // Moved to /admin/includes/configure.php
    if (!defined('DIR_FS_DOWNLOAD')) define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');

    if (!file_exists(DIR_FS_DOWNLOAD . $check_filename)) {
      $valid_downloads = false;
    // break;
    } else {
      $valid_downloads = true;
    }

    return $valid_downloads;
  }

////
// salemaker categories array
  function zen_parse_salemaker_categories($clist) {
    $clist_array = explode(',', $clist);

// make sure no duplicate category IDs exist which could lock the server in a loop
    $tmp_array = array();
    $n = sizeof($clist_array);
    for ($i=0; $i<$n; $i++) {
      if (!in_array($clist_array[$i], $tmp_array)) {
        $tmp_array[] = $clist_array[$i];
      }
    }
    return $tmp_array;
  }

////
// update salemaker product prices per category per product
  function zen_update_salemaker_product_prices($salemaker_id) {
    global $db;
    $zv_categories = $db->Execute("select sale_categories_selected from " . TABLE_SALEMAKER_SALES . " where sale_id = '" . $salemaker_id . "'");

    $za_salemaker_categories = zen_parse_salemaker_categories($zv_categories->fields['sale_categories_selected']);
    $n = sizeof($za_salemaker_categories);
    for ($i=0; $i<$n; $i++) {
      $update_products_price = $db->Execute("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id='" . $za_salemaker_categories[$i] . "'");
      while (!$update_products_price->EOF) {
        zen_update_products_price_sorter($update_products_price->fields['products_id']);
        $update_products_price->MoveNext();
      }
    }
  }

////
// check if products has discounts
  function zen_has_product_discounts($look_up) {
    global $db;

    $check_discount_query = "select products_id from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id='" . $look_up . "'";
    $check_discount = $db->Execute($check_discount_query);

    if ($check_discount->RecordCount() > 0) {
      return 'true';
    } else {
      return 'false';
    }
  }

////
//copy discounts from product to another
  function zen_copy_discounts_to_product($copy_from, $copy_to) {
    global $db;

    $check_discount_type_query = "select products_discount_type, products_discount_type_from, products_mixed_discount_quantity from " . TABLE_PRODUCTS . " where products_id='" . $copy_from . "'";
    $check_discount_type = $db->Execute($check_discount_type_query);

    $db->Execute("update " . TABLE_PRODUCTS . " set products_discount_type='" . $check_discount_type->fields['products_discount_type'] . "', products_discount_type_from='" . $check_discount_type->fields['products_discount_type_from'] . "', products_mixed_discount_quantity='" . $check_discount_type->fields['products_mixed_discount_quantity'] . "' where products_id='" . $copy_to . "'");

    $check_discount_query = "select * from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id='" . $copy_from . "' order by discount_id";
    $check_discount = $db->Execute($check_discount_query);
    $cnt_discount=1;
    while (!$check_discount->EOF) {
      $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . "
                  (discount_id, products_id, discount_qty, discount_price )
                  values ('" . $cnt_discount . "', '" . $copy_to . "', '" . $check_discount->fields['discount_qty'] . "', '" . $check_discount->fields['discount_price'] . "')");
      $cnt_discount++;
      $check_discount->MoveNext();
    }
  }


////
// return products master_categories_id
// TABLES: categories
  function zen_get_parent_category_id($product_id) {
    global $db;

    $categories_lookup = $db->Execute("select master_categories_id
                                from " . TABLE_PRODUCTS . "
                                where products_id = '" . (int)$product_id . "'");

    $parent_id = $categories_lookup->fields['master_categories_id'];

    return $parent_id;
  }

// replacement for fmod to manage values < 1
  function fmod_round($x, $y) {
    $x = strval($x);
    $y = strval($y);
    $zc_round = ($x*1000)/($y*1000);
    $zc_round_ceil = (int)($zc_round);
    $multiplier = $zc_round_ceil * $y;
    $results = abs(round($x - $multiplier, 6));
     return $results;
  }

////
// return any field from products or products_description table
// Example: zen_products_lookup('3', 'products_date_added');
//  function zen_products_lookup($product_id, $what_field = 'products_name', $language = $_SESSION['languages_id']) {
  function zen_products_lookup($product_id, $what_field = 'products_name', $language = '') {
    global $db;

    if (empty($language)) $language = $_SESSION['languages_id'];

    $product_lookup = $db->Execute("select " . $what_field . " as lookup_field
                              from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                              where p.products_id ='" . $product_id . "'
                              and pd.language_id = '" . $language . "'");

    $return_field = $product_lookup->fields['lookup_field'];

    return $return_field;
  }

  function zen_count_days($start_date, $end_date, $lookup = 'm') {
    if ($lookup == 'd') {
    // Returns number of days
      $start_datetime = gmmktime (0, 0, 0, substr ($start_date, 5, 2), substr ($start_date, 8, 2), substr ($start_date, 0, 4));
      $end_datetime = gmmktime (0, 0, 0, substr ($end_date, 5, 2), substr ($end_date, 8, 2), substr ($end_date, 0, 4));
      $days = (($end_datetime - $start_datetime) / 86400) + 1;
      $d = $days % 7;
      $w = date("w", $start_datetime);
      $result = floor ($days / 7) * 5;
      $counter = $result + $d - (($d + $w) >= 7) - (($d + $w) >= 8) - ($w == 0);
    }
    if ($lookup == 'm') {
    // Returns whole-month-count between two dates
    // courtesy of websafe<at>partybitchez<dot>org
      $start_date_unixtimestamp = strtotime($start_date);
      $start_date_month = date("m", $start_date_unixtimestamp);
      $end_date_unixtimestamp = strtotime($end_date);
      $end_date_month = date("m", $end_date_unixtimestamp);
      $calculated_date_unixtimestamp = $start_date_unixtimestamp;
      $counter=0;
      while ($calculated_date_unixtimestamp < $end_date_unixtimestamp) {
        $counter++;
        $calculated_date_unixtimestamp = strtotime($start_date . " +{$counter} months");
      }
      if ( ($counter==1) && ($end_date_month==$start_date_month)) $counter=($counter-1);
    }
    return $counter;
  }

////
// Get all products_id in a Category and its SubCategories
// use as:
// $my_products_id_list = array();
// $my_products_id_list = zen_get_categories_products_list($categories_id)
  function zen_get_categories_products_list($categories_id, $include_deactivated = false, $include_child = true) {
    global $db;
    global $categories_products_id_list;

    if ($include_deactivated) {

      $products = $db->Execute("select p.products_id
                                from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                                where p.products_id = p2c.products_id
                                and p2c.categories_id = '" . (int)$categories_id . "'");
    } else {
      $products = $db->Execute("select p.products_id
                                from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                                where p.products_id = p2c.products_id
                                and p.products_status = '1'
                                and p2c.categories_id = '" . (int)$categories_id . "'");
    }

    while (!$products->EOF) {
// categories_products_id_list keeps resetting when category changes ...
//      echo 'Products ID: ' . $products->fields['products_id'] . '<br>';
      $categories_products_id_list[] = $products->fields['products_id'];
      $products->MoveNext();
    }

    if ($include_child) {
      $childs = $db->Execute("select categories_id from " . TABLE_CATEGORIES . "
                              where parent_id = '" . (int)$categories_id . "'");
      if ($childs->RecordCount() > 0 ) {
        while (!$childs->EOF) {
          zen_get_categories_products_list($childs->fields['categories_id'], $include_deactivated);
          $childs->MoveNext();
        }
      }
    }
    $products_id_listing = $categories_products_id_list;
    return $products_id_listing;
  }

  function zen_geo_zones_pull_down_coupon($parameters, $selected = '') {
    global $db;
    $select_string = '<select ' . $parameters . '>';
    $zones = $db->Execute("select geo_zone_id, geo_zone_name
                                 from " . TABLE_GEO_ZONES . "
                                 order by geo_zone_name");

    if ($selected == 0) {
      $select_string .= '<option value=0 SELECTED>' . TEXT_NONE . '</option>';
    } else {
      $select_string .= '<option value=0>' . TEXT_NONE . '</option>';
    }

    while (!$zones->EOF) {
      $select_string .= '<option value="' . $zones->fields['geo_zone_id'] . '"';
      if ($selected == $zones->fields['geo_zone_id']) $select_string .= ' SELECTED';
      $select_string .= '>' . $zones->fields['geo_zone_name'] . '</option>';
      $zones->MoveNext();
    }
    $select_string .= '</select>';

    return $select_string;
  }

// customer lookup of address book
  function zen_get_customers_address_book($customer_id) {
    global $db;

    $customer_address_book_count_query = "SELECT c.*, ab.* from " .
                                          TABLE_CUSTOMERS . " c
                                          left join " . TABLE_ADDRESS_BOOK . " ab on c.customers_id = ab.customers_id
                                          WHERE c.customers_id = '" . (int)$customer_id . "'";

    $customer_address_book_count = $db->Execute($customer_address_book_count_query);
    return $customer_address_book_count;
  }

// get customer comments
  function zen_get_orders_comments($orders_id) {
    global $db;
    $orders_comments_query = "SELECT osh.comments from " .
                              TABLE_ORDERS_STATUS_HISTORY . " osh
                              where osh.orders_id = '" . $orders_id . "'
                              order by osh.date_added
                              limit 1";

    $orders_comments = $db->Execute($orders_comments_query);
    return $orders_comments->fields['comments'];
  }
  /**
   * �Զ��庯��,���ڻ�ÿͻ�������Ϣ
   */
  function zen_get_testimonial_info($id){
  	global $db;
  	
  	$testimonial_query = "Select tm_title, tm_content, tm_customer_id, tm_customer_email, 
  								 tm_customer_name, tm_date_added, tm_status, tm_reply, is_stick, language_id, modify_admin, modify_datetime
  							From " . TABLE_TESTIMONIAL . "
  						   Where tm_id = " . (int)$id . "
  						Order By tm_date_added Desc";
  	$testimonial = $db->Execute($testimonial_query);
  	
  	$testimonial_array = array();
  	if ($testimonial->RecordCount() > 0){
  		$customer_id = stripslashes($testimonial->fields['tm_customer_id']);
  		$title = stripslashes($testimonial->fields['tm_title']);
  		$content = stripslashes($testimonial->fields['tm_content']);
  		$email = stripslashes($testimonial->fields['tm_customer_email']);
  		$name = stripslashes($testimonial->fields['tm_customer_name']);
  		$date_added = stripslashes($testimonial->fields['tm_date_added']);
  		$status = stripslashes($testimonial->fields['tm_status']);
		$reply = stripslashes($testimonial->fields['tm_reply']);
		$is_stick = stripslashes($testimonial->fields['is_stick']);
		$language_id = stripslashes($testimonial->fields['language_id']);
		$modify_admin = stripslashes($testimonial->fields['modify_admin']);
		$modify_datetime = stripslashes($testimonial->fields['modify_datetime']);
  		
  		if ((int)$customer_id != 0){
  			$customer_query = "Select customers_firstname, customers_lastname, customers_email_address
  								 From " . TABLE_CUSTOMERS . "
  								Where customers_id = " . (int)$customer_id;
  			$customer = $db->Execute($customer_query);
  			$testimonial_array = array('title' => $title,
  									   'content' => $content,
  									   'customer_email' => stripslashes($customer->fields['customers_email_address']),
  									   'customer_name' => stripslashes($customer->fields['customers_firstname']) . ' ' . stripslashes($customer->fields['customers_lastname']),
  									   'date_added' => $date_added,
										'reply' => $reply,
  										'had_reply' => ($reply != '' ? 1 : 0),
                          			    'status' => $status,
                          			    'is_stick' => $is_stick,
                          			    'language_id' => $language_id,
                          			    'modify_admin' => $modify_admin,
                          			    'modify_datetime' => $modify_datetime
  			);
  		} else {
  			$testimonial_array = array('title' => $title,
  									   'content' => $content,
  									   'customer_email' => $email,
  									   'customer_name' => $name,
  									   'date_added' => $date_added,
									   'reply' => $reply,
  									   'had_reply' => ($reply != '' ? 1 : 0),
                          			    'status' => $status,
                          			    'is_stick' => $is_stick,
                          			    'language_id' => $language_id,
                          			    'modify_admin' => $modify_admin,
                          			    'modify_datetime' => $modify_datetime
  			    
  			);
  		}
  	}
  	return $testimonial_array;
  }

  //��number_format����ת������ַ����ת��Ϊ�������
  function zen_trans_number_format_to_float($string){
  	$float = 0;
  	if (strstr($string, ',')) $string = str_replace(',', '', $string);
  	$float = (float)$string;
  	return $float;
  }
  
  function zen_get_customer_info($customer_id){
  	global $db;
  	$customer_info_query = "Select customers_firstname, customers_lastname, customers_email_address
  							  From " . TABLE_CUSTOMERS . "
  							 Where customers_id = " . (int)$customer_id;
  	$customer_info = $db->Execute($customer_info_query);
  	
  	$customer_info_array = array();
  	if ($customer_info->RecordCount() > 0){
  		$customer_info_array = array('name' => stripslashes($customer_info->fields['customers_firstname']) . ' ' . stripslashes($customer_info->fields['customers_lastname']),
  									 'email' => stripslashes($customer_info->fields['customers_email_address']));
  		
  	}
  	
  	return $customer_info_array;
  }
  
  //function create zip file
  function zen_create_zip($file_array = array(), $destination = '', $overwrite = false){
  	if (file_exists($destination) && !$overwrite) return false;
  	
  	$valid_files = array();
  	if (is_array($file_array)){
  		foreach ($file_array as $file){
  			if (file_exists($file)){
  				$valid_files[] = $file;
  			}
  		}
  	}
  	
  	if (sizeof($valid_files) > 0){
  		$zip = new ZipArchive();
  		if($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true){
			return false;
		}
		
		foreach ($valid_files as $zip_file){
			$zip->addFile($zip_file, $zip_file);
		}
		
		$zip->close();
		return file_exists($destination);
  	} else {
  		return false;
  	}
  }
  
  //��ù���Ա������
  function zen_get_admin_name($admin_id){
  	global $db;
  	$admin_query = "select admin_name from " . TABLE_ADMIN . " where admin_id = " . (int)$admin_id;
  	$admin = $db->Execute($admin_query);
  	
  	if ($admin->RecordCount() > 0) return $admin->fields['admin_name'];
  	return false;
  }

  function zen_change_customers_level($al_customers_id, $ai_new_level){
		global $db;
		
		if (!zen_not_null($al_customers_id) or $al_customers_id == '') return -1;
		if ($ai_new_level == 0) return 0;
		
		$db->Execute('Update ' . TABLE_CUSTOMERS . ' 
						Set customers_level = ' . $ai_new_level . ' 
						Where customers_id = ' . (int)$al_customers_id);
		
		return $ai_new_level;
  }

 function get_category_num($cate_parent_id = 0){
		global $db;
		$categories_num = 0;
		if ($cate_parent_id > 0) {
			$cate_query = "select parent_id from " . TABLE_CATEGORIES . ' where categories_id = ' . $cate_parent_id;
			$cate_return = $db->Execute($cate_query);
			if ($cate_return->RecordCount() > 0) {
				if ($cate_return->fields['parent_id'] > 0) {
					$categories_num ++;
					$categories_num += get_category_num($cate_return->fields['parent_id']);
				}
			}
		}else{
			$categories_num = 0;
		}
		return $categories_num;
	}
	
	function process_xls_data($method_code, $method_id, $objPHPExcel, $type = 'postage'){
		global $db, $messageStack;
		$area_data_valid = true;
		$postage_data_valid = true;
		
		$max_id = $db->Execute('select id from t_area_' . $type . ' order by id desc limit 1');	
		if ($max_id->RecordCount() == 1){
			$max_id = (int)$max_id->fields['id'];
		}else{
			$max_id = 0;
		}
		
		$a1 = $objPHPExcel->getActiveSheet()->getCell('A1')->getValue();
		$b1 = $objPHPExcel->getActiveSheet()->getCell('B1')->getValue();
		$c1 = $objPHPExcel->getActiveSheet()->getCell('C1')->getValue();
		$d1 = $objPHPExcel->getActiveSheet()->getCell('D1')->getValue();
		$d2 = $objPHPExcel->getActiveSheet()->getCell('D2')->getValue();
		if ($type == 'postage'){
		    $e1 = $objPHPExcel->getActiveSheet()->getCell('E1')->getValue();
		    $f1 = $objPHPExcel->getActiveSheet()->getCell('F1')->getValue();
		    $g1 = $objPHPExcel->getActiveSheet()->getCell('G1')->getValue();
		    $h1 = $objPHPExcel->getActiveSheet()->getCell('H1')->getValue();
		    $i2 = $objPHPExcel->getActiveSheet()->getCell('I2')->getValue();
		}else{
		    $i2 = $objPHPExcel->getActiveSheet()->getCell('E2')->getValue();
		}
// 			switch (true){
// 				case (trim($a1) == 'apo_postage_id'):
// 				case (trim($b1) == 'apo_trans_type'):
// 				case (trim($c1) == 'apo_area_id'):
// 				case (trim($d1) == 'apo_weight'):
// 				case (trim($e1) == 'apo_amt'):
// 				case (trim($f1) == 'apo_add_type'):
// 				case (trim($g1) == 'apo_increment'):
// 				case (trim($h1) == 'apo_price'): $postage_data_valid = true;break;
// 				default: $postage_data_valid = false;
// 			}
// 		}else if ($type == 'country'){			
//       $i2 = $objPHPExcel->getActiveSheet()->getCell('E2')->getValue();
// 			switch (true){
// 				case (trim($a1) == 'ac_id'):
// 				case (trim($b1) == 'ac_country'):
// 				case (trim($c1) == 'ac_area_id'):
// 				case (trim($d1) == 'ac_trans_type'): $area_data_valid = true;break;
// 				default: $area_data_valid = false;
// 			}
// 		}
// 		if (!$postage_data_valid){
// 			$messageStack->add_session('地域运费表格有误，请检查后重新操作!', 'error');
// 			return false;
// 		}
// 		if (!$area_data_valid){
// 			$messageStack->add_session('国家分区表格有误，请检查后重新操作!', 'error');
// 			return false;
// 		}
		if ($type == 'postage' && (trim($i2) != $method_code)){
			$messageStack->add_session('输入的运送方式和地域运费表格中的运送方式不一样，请检查后再更新!', 'error');
			return false;
		}
		if ($type == 'country' && (trim($i2) != $method_code)){
			$messageStack->add_session('输入的运送方式和国家分区表格中的运送方式不一样，请检查后再更新!', 'error');
			return false;
		}
		$allRow = $objPHPExcel->getActiveSheet()->getHighestRow();
		$sql = "insert into t_area_" . $type . " values";
		for ($i = 1; $i <= $allRow; $i++) {
			$a = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
			if ((int)$a == '') continue;
			$b = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
			$c = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
			$d = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
			$e = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
			$f = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
			$g = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getValue();
			$h = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getValue();
      $z = $method_id;
			$insert_id = $max_id + 1;
			if ($type == 'postage'){
				$sql .= "(" . $insert_id . "," . $z . ",'" . $c . "','" . $d . "','" . $e . "',$f,'" . $g . "','" . $h . "'),";
        $update_sql = 'update t_shipping set erp_id = "'.$b.'" where id = '.$method_id;
			}else if ($type == 'country'){
				$sql .= "(" . $insert_id . ",'" . $b . "','" . $c . "'," . $z . "),";
        $update_sql = 'update t_shipping set erp_id = "'.$d.'" where id = '.$method_id;
      }
			$max_id++;
		}
		if ($allRow > 1){
			$date = date('Ymd');
			$db->Execute('DROP TABLE IF EXISTS t_area_' . $type . '_bak');
			$db->Execute('create table if not exists t_area_' . $type . '_bak select * from t_area_' . $type . ' where 1=1');
			$method_query = $db->Execute('select * from t_area_' . $type . ' where ' . ($type == 'postage' ? $type . '_' : '') . 'trans_type = ' . $method_id);
			if ($method_query->RecordCount() > 0){
				$db->Execute('delete from t_area_' . $type . ' where ' . ($type == 'postage' ? $type . '_' : '') . 'trans_type = ' . $method_id);
			}
			$db->Execute(substr($sql, 0, -1));
      $db->Execute($update_sql);
			$messageStack->add_session(($type == 'postage' ? '地域运费' : '国家分区') . '更新成功!', 'success');
		}
	}
	
	function zen_get_next_subcategories($cate_id = '0', $count = 1, $status_setting = '') {
		global $db;
		$categories_array = array ();
		// show based on status
		if ($status_setting != '') {
			$zc_status = " c.categories_status='" . ( int ) $status_setting . "' and ";
		} else {
			$zc_status = '';
		}
		
		$categories_query = "select c.categories_id, cd.categories_name, c.categories_status
	                         from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
	                         where " . $zc_status . "
	                         parent_id = '" . ( int ) $cate_id . "'
	                         and c.categories_id = cd.categories_id
	                         and cd.language_id = '" . ( int ) $_SESSION ['languages_id'] . "'
	                         order by cd.categories_name, sort_order";
		
		$categories = $db->Execute ( $categories_query );
		$count ++;
		$i = 0;
		while ( ! $categories->EOF ) {			
			$categories_array [] = array (
					'id' => $categories->fields ['categories_id'],
					'next_cid' => zen_get_next_subcategories ( $categories->fields ['categories_id'], $count ),
					'count' => $count 
			);
			$categories_array_count [$i] = $count;
			$i ++;
			$categories->MoveNext ();
		}
		
		return $categories_array;
	}
	function getmaxdim($vDim) {
		if (! is_array ( $vDim )) {
			return 0;
		} else {
			$max1 = 0;			
			foreach ( $vDim as $item1 ) {
				$t1 = getmaxdim ( $item1 ['next_cid'] );				
				if ($t1 > $max1){
					$max1 = $t1;
				}
			}			
			return $max1 + 1;
		}
	}
	function get_img_size($src,$width,$height){
		$extension = substr($src, strrpos($src , '.'));
		if(strpos($src,"_01") > 0 || strpos($src,"_02") > 0){
			$src = str_replace($extension ,'_'.$width.'_'.$height.$extension ,$src);
			$src = str_replace('_01_' ,'B_' ,$src);
			$src = str_replace('_02_' ,'C_' ,$src);
		}else{
			$src = str_replace($extension ,'A_'.$width.'_'.$height.$extension ,$src);
		}
		$src = 'watermarkimg_new/'.$src;
		return $src;
	}
	function zen_get_country_list($name, $selected = '', $parameters = '') {
		$countries = zen_get_countries();
	
		for ($i=0, $n=sizeof($countries); $i<$n; $i++) {
			$countries_array[] = array('id' => $countries[$i]['id'], 'text' => $countries[$i]['text']);
		}
	
		return zen_draw_pull_down_menu($name, $countries_array, $selected, $parameters);
	}
  /**
   * get airmail discount and extra times
   * author zale
   * date 2013-10-24
   * return array
   **/
  function get_airmail_info(){
  	global $db;
  	$airmail = array('discount' => 1, 'extra_times' => 1.1);
  	$query = $db->Execute('select discount, extra_times from ' . TABLE_SHIPPING . ' where id = 58');
  	if ($query->RecordCount() > 0){
  		$airmail = array('discount' => $query->fields['discount'], 'extra_times' => $query->fields['extra_times']);
  	}
  	return $airmail;
  }
  
  function zen_draw_date_selector_new($prefix, $date='') {
  	$usedate = getdate($date);
  	$day = $usedate['mday'];
  	$month = $usedate['mon'];
  	$year = $usedate['year'];
  	$hour = $usedate['hours'];
  	$date_selector = '<select name="'. $prefix .'_year">';
  	for ($i=2001;$i<2019;$i++){
  		$date_selector .= '<option value="' . $i . '"';
  		if ($i==$year) $date_selector .= 'selected';
  		$date_selector .= '>' . $i . '</option>';
  	}
  	$date_selector .= '</select>年';
  	$date_selector .= '<select name="'. $prefix .'_month">';
  	for ($i=1;$i<=12;$i++){
  		$date_selector .= '<option value="' . $i . '"';
  		if ($i==$month) $date_selector .= 'selected';
  		$date_selector .= '>' . $i . '</option>';
  	}
  	$date_selector .= '</select>月';
  	$date_selector .= '<select name="'. $prefix .'_day">';
  	for ($i=1;$i<32;$i++){
  		$date_selector .= '<option value="' . $i . '"';
  		if ($i==$day) $date_selector .= 'selected';
  		$date_selector .= '>' . $i . '</option>';
  	}
  	$date_selector .= '</select>日';
  	$date_selector .= '<select name="'. $prefix .'_hour">';
  	for ($i=0;$i<=23;$i++){
  		$date_selector .= '<option value="' . $i . '"';
  		if ($i==$hour) $date_selector .= 'selected';
  		$date_selector .= '>' . $i . '</option>';
  	}
  	$date_selector .= '</select>时';
  	return $date_selector;
  }
  
  /**
   * 记录用户操作日志
   * @param int $operator:管理员ID，系统为0
   * @param $target 操作对象订单为订单ID，产品为产品编号......唯一标识
   * @param string $content:操作内容
   * @param int $category:1:订单相关、2:商品相关、3:类别相关、4、用户相关
   */
  function zen_insert_operate_logs($operator,$target,$content,$category){
  	global $db;
  	if($operator=='0'){
  		$operator='system';
  	}else{
  		$admin_query=$db->Execute('select admin_name from '.TABLE_ADMIN.' where  admin_id="'.$operator.'" order by admin_id limit 1 ');
  		$operator=$admin_query->fields['admin_name'];
  	}
  	$sql_data_array = array('ol_logs_operator' => $operator,
  			'ol_logs_target' => $target,
  			'ol_logs_content' => $content,
  			'ol_logs_date' => date('Y-m-d H:i:s'),
  			'ol_logs_cate' => $category);
  	 
  	zen_db_perform(TABLE_OPERATION_LOGS, $sql_data_array);
  }
  
  function zen_get_customer_create($customer_id){
 	global $db;
 	if (isset($customer_id)){
 		$customer_create = $db->Execute('select customers_info_date_account_created from ' . TABLE_CUSTOMERS_INFO . ' where customers_info_id = ' . $customer_id);
		if($customer_create->fields['customers_info_date_account_created'] > '2014-04-15 11:00:00'){
			return true;
		}else{
			return false;
		}
 		//return $customer_cartid->fields['cartid'];
 	}else {
 		return false;
 	}
 }
 

 function zen_get_customer_basket_info($customer_id, $currencies_code = 'USD'){
 	global $db, $currencies;
 	$customer_basket_info = array(
 			'total' => 0,
 			'total_new' => 0,
 			'total_original' => 0,
 			'volume_weight' => 0,
 			'weight' => 0
 	);
 	if (!zen_not_null($customer_id)) return ;
 	$product = $db->Execute("select p.products_id, p.products_price, p.products_tax_class_id, p.products_weight,
			                          p.products_priced_by_attribute, p.product_is_always_free_shipping, p.products_discount_type,
			                          p.products_discount_type_from, p.products_virtual, p.products_model, p.products_volume_weight,
			                          cb.customers_basket_quantity
			                     from " . TABLE_PRODUCTS . " p, " . TABLE_CUSTOMERS_BASKET . " cb
			                    where cb.customers_id = " . $customer_id . "
			                      and p.products_id = cb.products_id");
 	if ($product->RecordCount() > 0){
 		while (!$product->EOF) {
 			$qty = (float)$product->fields['customers_basket_quantity'];
 			$prid = $product->fields['products_id'];
 			$products_tax = zen_get_tax_rate($product->fields['products_tax_class_id']);
 			$products_price = $product->fields['products_price'];
 
 			if ($product->fields['product_is_always_free_shipping'] != 1 and $product->fields['products_virtual'] != 1) {
 				if ($product->fields['products_volume_weight'] > 0) {
 					$products_vol_weight = $product->fields['products_volume_weight'];
 				} else {
 					$products_vol_weight = $product->fields['products_weight'];
 				}
 				$products_weight = $product->fields['products_weight'];
 			} else {
 				$products_weight = 0;
 			}
 
 			$special_price = zen_get_products_special_price($prid, false);
 			if ($special_price and $product->fields['products_priced_by_attribute'] == 0) {
 				$products_price = $special_price;
 			} else {
 				$special_price = 0;
 			}
 
 			if (zen_get_products_price_is_free($product->fields['products_id'])) {
 				$products_price = 0;
 			}
 			$original_price = $product->fields['products_price'];
 			if ($product->fields['products_priced_by_attribute'] == '1' and zen_has_product_attributes($product->fields['products_id'], 'false')) {
 				if ($special_price) {
 					$products_price = $special_price;
 				} else {
 					$products_price = $product->fields['products_price'];
 				}
 			} else {
 				if ($product->fields['products_discount_type'] != '0') {
 					$products_price = zen_get_products_discount_price_qty($product->fields['products_id'], $qty);
 					$original_price = zen_get_products_discount_price_qty($product->fields['products_id'], $qty, 0, false);
 				}
 			}
 			$customer_basket_info['total'] += zen_add_tax($products_price, $products_tax) * $qty;
 			$customer_basket_info['total_new'] += $currencies->format_cl(zen_add_tax($products_price, $products_tax), true, $currencies_code) * $qty;
 			$customer_basket_info['total_original'] += $currencies->format_cl(zen_add_tax($original_price, $products_tax), true, $currencies_code) * $qty;
 			$customer_basket_info['volume_weight'] += ($qty * $products_vol_weight);
 			$customer_basket_info['weight'] += ($qty * $products_weight);
 			$product->MoveNext();
 		}
 	}
 	return $customer_basket_info;
 }
 
 
/**
   获取是否使用VIP折扣
   author wei.liang
   return true or false
   **/
  function get_with_vip($product_id){
  	global $db;
  	$promotion_discount_query= 'select p.with_vip from '. TABLE_PROMOTION .' p , '. TABLE_PROMOTION_PRODUCTS .' pp where pp.pp_products_id = '. $product_id .' and pp.pp_promotion_id = p.promotion_id and p.promotion_status = 1 and pp.pp_promotion_start_time <= "'. date('Y-m-d H:i:s') .'" and pp.pp_promotion_end_time > "'. date('Y-m-d H:i:s') .'" ';
  	$promotion_discount= $db->Execute($promotion_discount_query);
  	if(isset($promotion_discount->fields['with_vip']) && (int)$promotion_discount->fields['with_vip'] == 0){
  		return false;
  	}else{
  		return true;
  	}
  }
  
  /**
   * 2014-08-19 by zhanghongliang
   * Aug. promotion
   **/
  function present_promotion_coupon_bak20150713($customers_id, $orders_id=0){
  	global $db,$order;
  	if(!$customers_id) return false;
  
  	$vip_discount = 0;
  	$rcd_discount = 0;
  	$ot_subtotal = 0;
  	for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++){
  		if($order->totals[$i]['class'] == 'ot_subtotal'){
  			$ot_subtotal = $order->totals[$i]['value'];
  		}elseif($order->totals[$i]['class'] == 'ot_group_pricing'){
  			$vip_discount = $order->totals[$i]['value'];
  		}elseif($order->totals[$i]['class'] == 'ot_coupon'){
  			$rcd_discount = $order->totals[$i]['value'];
  		}
  	}
  	//$item_total = $ot_subtotal - $vip_discount - $rcd_discount;
  	$item_total = $ot_subtotal;
	/*
    if($item_total>=111 && $item_total<222){
		$coupon_code = 'CP2014111101';
	}elseif($item_total>=222 && $item_total<444){
		$coupon_code = 'CP2014111102';
	}elseif($item_total>=444 && $item_total<555){
		$coupon_code = 'CP2014111103';
	}elseif($item_total>=555 && $item_total<888){
		$coupon_code = 'CP2014111104';
	}elseif($item_total>=888 && $item_total<999){
		$coupon_code = 'CP2014111105';
	}elseif($item_total>=999){
		$coupon_code = 'CP2014111106';
	}else{
		return false;
	}
	*/
	if($item_total>=300){
		$coupon_code = 'CP20141121';
	}else{
		return false;
	}

	$check_from_order = $db->Execute("select cc_coupon_id from ".TABLE_COUPON_CUSTOMER." where cc_customers_id='".$customers_id."' and coupon_from='".$orders_id."'");
	if($check_from_order->RecordCount()==0){
		$coupon_query = $db->Execute("select coupon_id,coupon_amount from ".TABLE_COUPONS." where coupon_code='".$coupon_code."' limit 1");
		$coupon_data_array = array(
			'cc_coupon_id'=>(int)$coupon_query->fields['coupon_id'],
			'cc_customers_id'=>$customers_id,
			'cc_amount'=>$coupon_query->fields['coupon_amount'],
			'cc_coupon_start_time'=>date('Y-m-d H:i:s'),
			'cc_coupon_end_time'=>date('Y-m-d H:i:s', strtotime("+15 day")),
			'coupon_from'=>$orders_id,
			'cc_coupon_status'=>10,
			'date_created'=>'now()'
		);
		zen_db_perform(TABLE_COUPON_CUSTOMER, $coupon_data_array);
		return true;
	}else{
		return false;
	}
  } 
  
  
  /**
   *
   * get_products_quantity
   * @author hongliu 2015-1-5
   * @param array $array
   * @return int/boolean
   */
  function get_products_quantity($array){
  	global $db;
  	$products_id = intval($array['products_id']);
  	$quantity = 0;
  	if(!$products_id){
  		return false;
  	}
  	$sql = 'select products_quantity from ' . TABLE_PRODUCTS_STOCK . ' where products_id = ' . $products_id;
  	$products_quantity = $db->Execute($sql);
  	if(!$products_quantity->EOF){
  		$quantity = $products_quantity->fields['products_quantity'];
  	}
  	return $quantity;
  }
  
  /**
   * @author Tianwen.Wan
   * @param array $data
   */
  function update_products_quantity($data) {
  	global $db;
    if(empty($data)) {
      return false;
    }
    $products_quantity = (int) $data['products_quantity'];
    $products_id = (int) $data['products_id'];
    $sql = 'update ' . TABLE_PRODUCTS_STOCK . ' set products_quantity=:products_quantity where products_id=:products_id';
  	$sql = $db->bindVars($sql, ':products_quantity', $products_quantity, 'integer');
  	$sql = $db->bindVars($sql, ':products_id', $products_id, 'integer');
  	$result = $db->Execute($sql);

// 	if(isset($data['products_quantity']) && $data['products_quantity'] <= 0) {
// 		$check_products_promotion_status_sql = 'SELECT zpp.pp_id FROM ' . TABLE_PROMOTION_PRODUCTS . ' zpp INNER JOIN ' . TABLE_PROMOTION . ' zp on zp.promotion_id = zpp.pp_promotion_id WHERE zpp.pp_promotion_start_time < now() AND zpp.pp_promotion_end_time > now() and zp.promotion_status = 1 and zpp.pp_is_forbid = 10 and zpp.pp_products_id = ' . ( int ) $products_id;
// 		$check_products_promotion_status_query = $db->Execute($check_products_promotion_status_sql);
		
// 		if($check_products_promotion_status_query->RecordCount() > 0){
// 			while(!$check_products_promotion_status_query->EOF){
// 				$pp_id = $check_products_promotion_status_query->fields['pp_id'];
// 				$db->Execute('update ' . TABLE_PROMOTION_PRODUCTS . ' set pp_is_forbid = 20 WHERE pp_id = ' . $pp_id);
					
// 				$check_products_promotion_status_query->MoveNext();
// 			}
// 		}
			
// 		$check_products_deals_status_sql = 'SELECT zdp.dailydeal_promotion_id from ' . TABLE_DAILYDEAL_PROMOTION . ' zdp INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on zdp.area_id = zda.dailydeal_area_id  where dailydeal_products_start_date < now() and dailydeal_products_end_date > NOW() and dailydeal_is_forbid = 10 and zda.area_status = 1 and zdp.products_id = ' . ( int ) $products_id;
// 		$check_products_deals_status_query = $db->Execute($check_products_deals_status_sql);
			
// 		if($check_products_deals_status_query->RecordCount() > 0){
// 			while (!$check_products_deals_status_query->EOF){
// 				$dailydeal_promotion_id = $check_products_deals_status_query->fields['dailydeal_promotion_id'];
// 				$db->Execute('update ' . TABLE_DAILYDEAL_PROMOTION . ' set dailydeal_is_forbid = 20 where dailydeal_promotion_id = ' . $dailydeal_promotion_id);
					
// 				$check_products_deals_status_query->MoveNext();
// 			}
// 		}
// 	}
    return true;
  }
  
  /**
   * copy from 8seasons
   * @author Tianwen.Wan
   * @param int $products_id
   * @param bool
   */
  function remove_product_memcache($products_id){
      global $db,$lng,$memcache;
  	if(empty($products_id)) {
  		return null;
  	}
  	if (!isset($lng) || (isset($lng) && !is_object($lng))) {
  		$lng = new language;
  	}
  	
  	$sql = "select products_model from " . TABLE_PRODUCTS . " where products_id = $products_id";
  	$sql_query = $db->Execute($sql);
  	$products_model = $sql_query->fields['products_model'];
  	$number = 500;
  	if(!empty($products_model)){
  	    $memcache->delete(md5(MEMCACHE_PREFIX . 'get_products_group_of_products' . $products_model . '0' . $number));
  	}
  	
  	foreach ($lng->catalog_languages as $val){
  		$memcache->delete(md5(MEMCACHE_PREFIX.'get_products_description_memcache' . $products_id . $val['id']));
  		$memcache->delete(md5(MEMCACHE_PREFIX . 'get_product_unit_other_package_size' . $products_id . $val['id']));
  	}
  	$memcache->delete(md5(MEMCACHE_PREFIX.'get_products_info_memcache' . $products_id));
  	$memcache->delete(md5(MEMCACHE_PREFIX . 'get_daily_deal_price_by_products_id' . $products_id));
  	$memcache->delete(md5(MEMCACHE_PREFIX . 'get_products_discount_by_products_id' . $products_id));
  	$memcache->delete(md5(MEMCACHE_PREFIX.'get_promotion_discount_by_products_id'.$products_id));
  	$memcache->delete(md5(MEMCACHE_PREFIX.'zen_show_discount_amount' . (int)$products_id . false));
  	$memcache->delete(md5(MEMCACHE_PREFIX.'products_discount_quantity_modules' . (int)$products_id ));
  	$memcache->delete(md5(MEMCACHE_PREFIX.'get_products_breadcrumb_memcache' . $products_id));
    $memcache->delete(md5(MEMCACHE_PREFIX.'get_dailydeal_discount_by_products_id' . (int)$products_id ));//清除deals折扣
  		
  	$data = $memcache->get(md5(MEMCACHE_PREFIX.'get_products_package_id_by_other_products_id'.$products_id));
  	if($data){
  		$memcache->delete(md5(MEMCACHE_PREFIX.'get_products_package_id_by_products_id' . $data));
  	}
  	$memcache->delete(md5(MEMCACHE_PREFIX.'get_products_package_id_by_other_products_id'.$products_id));
  	return true;
  }
  
  function zen_memcache_flush(){
  	global $memcache;
  
  	$memcache->flush();
  }
  
  function remove_categores_memcache_by_categories_id($categories_id){
  	global $lng,$memcache,$db;
  	if(!$categories_id) return null;
  	if (!isset($lng) || (isset($lng) && !is_object($lng))) {
  		$lng = new language;
  	}
  	
  	$data = $db->Execute('select parent_id from ' . TABLE_CATEGORIES . ' where categories_id = "' . $categories_id . '"');
  	
  	foreach ($lng->catalog_languages as $val){  		  		
  		$memcache->delete(md5(MEMCACHE_PREFIX . 'get_category_category_description' . $data->fileds['parent_id'] . $val['id'] ));		
  		$memcache->delete(md5(MEMCACHE_PREFIX . 'get_category_category_description_mobilesite' . $data->fileds['parent_id'] . $val['id'] ));
  	}
  	$memcache->delete(md5(MEMCACHE_PREFIX . 'category_redirect' . $categories_id));
  	$memcache->delete(md5(MEMCACHE_PREFIX . 'categories_info_new_' . $categories_id));
  	return true;
  }

  /**
   * 清除类别数组缓存
   * @author Tianwen.Wan
   */
  function remove_all_cate_array_memcache(){
  	global $lng,$memcache;
  	if (!isset($lng) || (isset($lng) && !is_object($lng))) {
  		$lng = new language;
  	}
  	foreach ($lng->catalog_languages as $val){
  		$memcache->delete(md5(MEMCACHE_PREFIX . 'zen_get_all_cate_array' . $val['id']));
  	}
  	return true;
  }
  
  function remove_promotion_area_info_from_memcache($area_id)
  {
  	global $memcache;
  	$memcache_key = md5(MEMCACHE_PREFIX . 'get_normal_promotion_area_info_memcache' .$area_id );
  	$memcache->delete($memcache_key);
  }
  
 function present_promotion_coupon($customers_id, $orders_id=0, $cu_info=array()){
	global $db,$order,$currencies;
 	
	if(!$customers_id) return false;

	$date = date('Y-m-d H:i:s');
	if($date<PRESENT_COUPON_START_TIME || $date>PRESENT_COUPON_END_TIME) return false;
	
	/*$ot_balance = 0;	
	for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++){
		if($order->totals[$i]['class'] == 'ot_cash_account'){
			$ot_balance = $order->totals[$i]['value'];
		}
	}
	if($ot_balance>0){
		$pay_total = $order->info['total'] + $ot_balance;
	}else{
		$pay_total = $order->info['total'];
	}*/
	$pay_total = $order->info['total'];
	
	if($pay_total>=35 && $pay_total<80){
		$coupon_code = 'CP2015071505';
	}elseif($pay_total>=80 && $pay_total<150){
		$coupon_code = 'CP2015071512';
	}elseif($pay_total>=150){
		$coupon_code = 'CP2015071525';
	}else{
		return false;
	}
	
	$check_from_order = $db->Execute("select cc_coupon_id from ".TABLE_COUPON_CUSTOMER." where cc_customers_id='".$customers_id."' and coupon_from='".$orders_id."'");
	$coupon_query = $db->Execute("select coupon_id,coupon_amount from ".TABLE_COUPONS." where coupon_code='".$coupon_code."'");
		
	if($check_from_order->RecordCount()==0 && $coupon_query->RecordCount()>0){
		$coupon_data_array = array(
			'cc_coupon_id'=>(int)$coupon_query->fields['coupon_id'],
			'cc_customers_id'=>$customers_id,
			'cc_amount'=>$coupon_query->fields['coupon_amount'],
			'cc_coupon_start_time'=>date('Y-m-d H:i:s'),
			'cc_coupon_end_time'=>date('Y-m-d H:i:s', strtotime("+20 day")),
			'coupon_from'=>$orders_id,
			'cc_coupon_status'=>10,
			'date_created'=>'now()'
		);
		zen_db_perform(TABLE_COUPON_CUSTOMER, $coupon_data_array);
		
		$coupon_name = $currencies->format($coupon_query->fields['coupon_amount'], true, $order->info['currency']);
		$email_subject = str_replace('&euro;', '€', sprintf(EMAIL_CURRENCY_SUBJECT, $coupon_name));
		$email_name =  $cu_info[1]!='' ? $cu_info[1] : TEXT_CUSTOMER;	
		$email_text = sprintf(EMAIL_CURRENCY_BODY, $email_name, $coupon_name);
		$html_msg['EMAIL_MESSAGE_HTML'] = $email_text;
		$first_name = ucfirst($cu_info[1]);
		$last_name = ucfirst($cu_info[2]);
		zen_mail($first_name . ' ' . $last_name, $cu_info[0], $email_subject, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'default');
		return $coupon_query->fields['coupon_amount'];
	}else{
		return $coupon_query->fields['coupon_amount'];
	}
 }
 
 /**
  * string.Format like C#,use as : $result = zend_format('Hello,{0}: today is {1}!','phc',Date('Y-m-d'));
  * $result maybe like "Hello,phc: today is 2015-07-30"
  * @param string $format like "Hello,{0}: today is {1}!"
  * @return string
  */
 function zend_format($format) {
 	$args = func_get_args();
 	$format = array_shift($args);//remove $format param
 
 	preg_match_all('/(?=\{)\{(\d+)\}(?!\})/', $format, $matches, PREG_OFFSET_CAPTURE);
 	$offset = 0;
 	foreach ($matches[1] as $data) {
 		$i = $data[0];
 		$format = substr_replace($format, @$args[$i], $offset + $data[1] - 1, 2 + strlen($i));
 		$offset += strlen(@$args[$i]) - 2 - strlen($i);
 	}
 
 	return $format;
 }
 
 /* 
* 功能：PHP图片水印 (水印支持图片或文字) 
* 参数： 
*      $groundImage    背景图片，即需要加水印的图片，暂只支持GIF,JPG,PNG格式； 
*      $waterPos        水印位置，有10种状态，0为随机位置； 
*                        1为顶端居左，2为顶端居中，3为顶端居右； 
*                        4为中部居左，5为中部居中，6为中部居右； 
*                        7为底端居左，8为底端居中，9为底端居右； 
*      $waterImage        图片水印，即作为水印的图片，暂只支持GIF,JPG,PNG格式； 
*      $waterText        文字水印，即把文字作为为水印，支持ASCII码，不支持中文； 
*      $textFont        文字大小，值为1、2、3、4或5，默认为5； 
*      $textColor        文字颜色，值为十六进制颜色值，默认为#FF0000(红色)； 
* 
* 注意：Support GD 2.0，Support FreeType、GIF Read、GIF Create、JPG 、PNG 
*      $waterImage 和 $waterText 最好不要同时使用，选其中之一即可，优先使用 $waterImage。 
*      当$waterImage有效时，参数$waterString、$stringFont、$stringColor均不生效。 
*      加水印后的图片的文件名和 $groundImage 一样。 
* 作者：longware @ 2004-11-3 14:15:13 
*/ 
function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$waterText="",$textFont=5,$textColor="#FF0000")
{ 
    $isWaterImage = FALSE; 
    $formatMsg = "暂不支持该文件格式，请用图片处理软件将图片转换为GIF、JPG、PNG格式。"; 

    //读取水印文件 
    if(!empty($waterImage) && file_exists($waterImage)) 
    { 
        $isWaterImage = TRUE; 
        $water_info = getimagesize($waterImage); 
        $water_w    = $water_info[0];//取得水印图片的宽 
        $water_h    = $water_info[1];//取得水印图片的高 

        switch($water_info[2])//取得水印图片的格式 
        { 
            case 1:$water_im = imagecreatefromgif($waterImage);break; 
            case 2:$water_im = imagecreatefromjpeg($waterImage);break; 
            case 3:$water_im = imagecreatefrompng($waterImage);break; 
            default:die($formatMsg); 
        } 
    } 

    //读取背景图片 
    if(!empty($groundImage) && file_exists($groundImage)) 
    { 
        $ground_info = getimagesize($groundImage); 
        $ground_w    = $ground_info[0];//取得背景图片的宽 
        $ground_h    = $ground_info[1];//取得背景图片的高 

        switch($ground_info[2])//取得背景图片的格式 
        { 
            case 1:$ground_im = imagecreatefromgif($groundImage);break; 
            case 2:$ground_im = imagecreatefromjpeg($groundImage);break; 
            case 3:$ground_im = imagecreatefrompng($groundImage);break; 
            default:die($formatMsg); 
        } 
    } 
    else 
    { 
        die("需要加水印的图片不存在！"); 
    } 

    //水印位置 
    if($isWaterImage)//图片水印 
    { 
        $w = $water_w; 
        $h = $water_h; 
        $label = "图片的"; 
    } 
    else//文字水印 
    { 
        $temp = imagettfbbox(ceil($textFont*2.5),0,"./cour.ttf",$waterText);//取得使用 TrueType 字体的文本的范围 
        $w = $temp[2] - $temp[6]; 
        $h = $temp[3] - $temp[7]; 
        unset($temp); 
        $label = "文字区域"; 
    } 
    if( ($ground_w<$w) || ($ground_h<$h) ) 
    { 
        echo "需要加水印的图片的长度或宽度比水印".$label."还小，无法生成水印！"; 
        return; 
    } 
    switch($waterPos) 
    { 
        case 0://随机 
            $posX = rand(0,($ground_w - $w)); 
            $posY = rand(0,($ground_h - $h)); 
            break; 
        case 1://1为顶端居左 
            $posX = 0; 
            $posY = 0; 
            break; 
        case 2://2为顶端居中 
            $posX = ($ground_w - $w) / 2; 
            $posY = 0; 
            break; 
        case 3://3为顶端居右 
            $posX = $ground_w - $w; 
            $posY = 0; 
            break; 
        case 4://4为中部居左 
            $posX = 0; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 5://5为中部居中 
            $posX = ($ground_w - $w) / 2; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 6://6为中部居右 
            $posX = $ground_w - $w; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 7://7为底端居左 
            $posX = 0; 
            $posY = $ground_h - $h; 
            break; 
        case 8://8为底端居中 
            $posX = ($ground_w - $w) / 2; 
            $posY = $ground_h - $h; 
            break; 
        case 9://9为底端居右 
            $posX = $ground_w - $w; 
            $posY = $ground_h - $h; 
            break; 
        default://随机 
            $posX = rand(0,($ground_w - $w)); 
            $posY = rand(0,($ground_h - $h)); 
            break;     
    } 

    //设定图像的混色模式 
    imagealphablending($ground_im, true); 

    if($isWaterImage)//图片水印 
    { 
        imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//拷贝水印到目标文件         
    } 
    else//文字水印 
    { 
        if( !empty($textColor) && (strlen($textColor)==7) ) 
        { 
            $R = hexdec(substr($textColor,1,2)); 
            $G = hexdec(substr($textColor,3,2)); 
            $B = hexdec(substr($textColor,5)); 
        } 
        else 
        { 
            die("水印文字颜色格式不正确！"); 
        } 
        imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));         
    } 

    //生成水印后的图片 
    @unlink($groundImage); 
    switch($ground_info[2])//取得背景图片的格式 
    { 
        case 1:imagegif($ground_im,$groundImage);break; 
        case 2:imagejpeg($ground_im,$groundImage);break; 
        case 3:imagepng($ground_im,$groundImage);break; 
        default:die($errorMsg); 
    } 

    //释放内存 
    if(isset($water_info)) unset($water_info); 
    if(isset($water_im)) imagedestroy($water_im); 
    unset($ground_info); 
    imagedestroy($ground_im); 
} 

    /**
   * return shipping_method conditions in orders.php
   * fy
   * @return array
   */
  function get_shipping_method_conditions_memcache(){
    global $db,$memcache;
    $memcache_key = md5('shipping_method_conditions');
    $data = $memcache->get($memcache_key);
    if($data || gettype($data) != 'boolean'){
      return $data;
    }
    $sql = "select s.`code`,s.`name` from ". TABLE_SHIPPING ." s, ". TABLE_ORDERS ." o where s.`code` = o.shipping_module_code GROUP BY s.`code`";
    $method_query = $db->Execute($sql);
    $return_array = array();
    if($method_query->RecordCount() > 0){
      while(!$method_query->EOF){
        $return_array[] = $method_query->fields;
        $method_query->MoveNext();
      }
    }
    $memcache->set($memcache_key,$return_array,false,86400);
    return $return_array;
  }

  
/*
* 提交请求
* @param $header array 需要配置的域名等header设置 array("Host: devzc.com");
* @param $data string 需要提交的数据 'user=xxx&qq=xxx&id=xxx&post=xxx'....
* @param $url string 要提交的url 'http://192.168.1.12/xxx/xxx/api/';
*/
function curl_post($header,$data,$url)
{
    $ch = curl_init();
    $res= curl_setopt ($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
    $result = curl_exec ($ch);
    curl_close($ch);
    if ($result == NULL) {
        return 0;
    }
    return $result;
}

function getParent($cid, $arr){
	global $db;

	if(! $cid) return $arr;

	$c = $db->Execute("select categories_id,parent_id from ".TABLE_CATEGORIES." where categories_id = ".$cid);
	while(!$c->EOF){
		$arr[] = $c->fields['categories_id'];
		return getParent($c->fields['parent_id'], $arr);
	}
	return $arr;
}

function move_products_to_new_categories($products_id, $category_id){
    $cpid = array_reverse(getParent($category_id, array()));
    $first = zen_db_prepare_input(isset($cpid[0]) ? $cpid[0] : 0);
    $second = zen_db_prepare_input(isset($cpid[1]) ? $cpid[1] : 0);
    $third = zen_db_prepare_input(isset($cpid[2]) ? $cpid[2] : 0);
    
    $new_relation_data = array(
        'products_id'         => $products_id,
        'categories_id'       => (int)$category_id,
        'first_categories_id' => $first,
        'second_categories_id'=> $second,
        'three_categories_id' => $third,
    );
    zen_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $new_relation_data);
}
?>