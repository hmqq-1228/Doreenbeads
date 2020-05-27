<?php
/**
 * functions_lookups.php
 * Lookup Functions for various Zen Cart activities such as countries, prices, products, product types, etc
 *
 * @package functions
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_lookups.php 6485 2007-06-12 06:46:08Z ajeh $
 */


/**
 * Returns an array with countries
 *
 * @param int If set limits to a single country
 * @param boolean If true adds the iso codes to the array
 */
function zen_get_countries($countries_id = '', $with_iso_codes = false)
{
    global $db;
    $countries_array = array();
    if (zen_not_null($countries_id)) {
        if ($with_iso_codes == true) {
            $countries = "select countries_name, countries_iso_code_2, countries_iso_code_3, countries_zip_code_rule, countries_zip_code_example
                      from " . TABLE_COUNTRIES . "
                      where countries_id = '" . (int)$countries_id . "'
                      order by countries_name";

            $countries_values = $db->Execute($countries);

            $countries_array = array('countries_name' => $countries_values->fields['countries_name'],
                'countries_iso_code_2' => $countries_values->fields['countries_iso_code_2'],
                'countries_iso_code_3' => $countries_values->fields['countries_iso_code_3'],
                'countries_zip_code_rule' => $countries_values->fields['countries_zip_code_rule'],
                'countries_zip_code_example' => $countries_values->fields['countries_zip_code_example']
            );
        } else {
            $countries = "select countries_name, countries_zip_code_rule, countries_zip_code_example
                      from " . TABLE_COUNTRIES . "
                      where countries_id = '" . (int)$countries_id . "'";

            $countries_values = $db->Execute($countries);

            $countries_array = array(
                'countries_name' => $countries_values->fields['countries_name'],
                'countries_zip_code_rule' => $countries_values->fields['countries_zip_code_rule'],
                'countries_zip_code_example' => $countries_values->fields['countries_zip_code_example']
            );
        }
    } else {
        $countries = "select countries_id, countries_name,countries_iso_code_2 , countries_zip_code_rule, countries_zip_code_example
                    from " . TABLE_COUNTRIES . "
                    order by countries_name";

        $countries_values = $db->Execute($countries);

        $black_shipping = array();
        if (zen_is_facebook_like_time()) {    //	送产品活动期间，运送地址屏蔽这些国家 lvxiaoyong 20150730
            $black_shipping = explode(',', FACEBOOK_LIKE_BLACK_COUNTRY_SHIPPING);
        }
        while (!$countries_values->EOF) {
            if (!in_array($countries_values->fields['countries_iso_code_2'], $black_shipping)) {
                $countries_array[] = array(
                    'countries_id' => $countries_values->fields['countries_id'],
                    'countries_name' => $countries_values->fields['countries_name'],
                    'countries_zip_code_rule' => $countries_values->fields['countries_zip_code_rule'],
                    'countries_zip_code_example' => $countries_values->fields['countries_zip_code_example']
                );
            }
            $countries_values->MoveNext();
        }
    }

    return $countries_array;
}

/*
 *  Alias function to zen_get_countries()
 */
function zen_get_country_name($country_id)
{
    $country_array = zen_get_countries($country_id);

    return $country_array['countries_name'];
}

function zen_get_customer_country_name($customer_id)
{
    global $db;
    if ($customer_id != '') {
        $customer_country_query = $db->Execute('select customers_country_id from ' . TABLE_CUSTOMERS . ' where customers_id = ' . $customer_id);
        $country_id = $customer_country_query->fields['customers_country_id'];
        if ($country_id == 0 || !zen_not_null($country_id)) {
            $country_id_query = $db->Execute('select ab.entry_country_id from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_ADDRESS_BOOK . ' ab where c.customers_id = ' . $customer_id . ' and c.customers_default_address_id = ab.address_book_id');
            $country_id = $country_id_query->fields['entry_country_id'];
        } else {
            $country_id = $customer_country_query->fields['customers_country_id'];
        }
        return zen_get_country_name($country_id);
    } else {
        return '';
    }
}

/**
 * Alias function to zen_get_countries, which also returns the countries iso codes
 *
 * @param int If set limits to a single country
 */
function zen_get_countries_with_iso_codes($countries_id)
{
    return zen_get_countries($countries_id, true);
}

/*
 * Return the zone (State/Province) name
 * TABLES: zones
 */
function zen_get_zone_name($country_id, $zone_id, $default_zone)
{
    global $db;
    $zone_query = "select zone_name
                   from " . TABLE_ZONES . "
                   where zone_country_id = '" . (int)$country_id . "'
                   and zone_id = '" . (int)$zone_id . "'";

    $zone = $db->Execute($zone_query);

    if ($zone->RecordCount()) {
        return $zone->fields['zone_name'];
    } else {
        return $default_zone;
    }
}

/*
 * Returns the zone (State/Province) code
 * TABLES: zones
 */
function zen_get_zone_code($country_id, $zone_id, $default_zone)
{
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


/*
 *  validate products_id
 */
function zen_products_id_valid($valid_id)
{
    global $db;
    $check_valid = $db->Execute("select p.products_id
                                 from " . TABLE_PRODUCTS . " p
                                 where products_id='" . (int)$valid_id . "' limit 1");
    if ($check_valid->EOF) {
        return false;
    } else {
        return true;
    }
}

/**
 * Return a product's name.
 *
 * @param int The product id of the product who's name we want
 * @param int The language id to use. If this is not set then the current language is used
 */
function zen_get_products_name($product_id, $language = '')
{
    global $db;

    if (empty($language)) $language = $_SESSION['languages_id'];

    $product_query = "select products_name
                      from " . TABLE_PRODUCTS_DESCRIPTION . "
                      where products_id = '" . (int)$product_id . "'
                      and language_id = '" . (int)$language . "'";

    $product = $db->Execute($product_query);

    return $product->fields['products_name'];
}


/**
 * Return a product's stock count.
 *
 * @param int The product id of the product who's stock we want
 */
function zen_get_products_stock($products_id)
{
    global $db;
    $products_id = zen_get_prid($products_id);
    $stock_query = "select products_quantity
                    from " . TABLE_PRODUCTS_STOCK . "
                    where products_id = '" . (int)$products_id . "'";

    $stock_values = $db->Execute($stock_query);

    return $stock_values->fields['products_quantity'];
}

/**
 * Check if the required stock is available.
 *
 * If insufficent stock is available return an out of stock message
 *
 * @param int The product id of the product whos's stock is to be checked
 * @param int Is this amount of stock available
 *
 * @TODO naughty html in a function
 */
function zen_check_stock($products_id, $products_quantity)
{
    $stock_left = zen_get_products_stock($products_id) - $products_quantity;
    $out_of_stock = '';

    if ($stock_left < 0) {
        $out_of_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
    }

    return $out_of_stock;
}

/*
 * List manufacturers (returned in an array)
 */
function zen_get_manufacturers($manufacturers_array = '', $have_products = false)
{
    global $db;
    if (!is_array($manufacturers_array)) $manufacturers_array = array();

    if ($have_products == true) {
        $manufacturers_query = "select distinct m.manufacturers_id, m.manufacturers_name
                              from " . TABLE_MANUFACTURERS . " m
                              left join " . TABLE_PRODUCTS . " p on m.manufacturers_id = p.manufacturers_id
                              where p.manufacturers_id = m.manufacturers_id
                              and (p.products_status = 1
                              and p.products_quantity > 0)
                              order by m.manufacturers_name";
    } else {
        $manufacturers_query = "select manufacturers_id, manufacturers_name
                              from " . TABLE_MANUFACTURERS . " order by manufacturers_name";
    }

    $manufacturers = $db->Execute($manufacturers_query);

    while (!$manufacturers->EOF) {
        $manufacturers_array[] = array('id' => $manufacturers->fields['manufacturers_id'], 'text' => $manufacturers->fields['manufacturers_name']);
        $manufacturers->MoveNext();
    }

    return $manufacturers_array;
}

/*
 *  Check if product has attributes
 */
function zen_has_product_attributes($products_id, $not_readonly = 'true')
{
    global $db;
    return false;  /*wsl2014-12-15*/
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

    if ($attributes->recordCount() > 0 && $attributes->fields['products_attributes_id'] > 0) {
        return true;
    } else {
        return false;
    }
}

/*
 *  Check if product has attributes values
 */
function zen_has_product_attributes_values($products_id)
{
    global $db;
    return false;  /*wsl2014-12-15*/
    $attributes_query = "select sum(options_values_price) as total
                         from " . TABLE_PRODUCTS_ATTRIBUTES . "
                         where products_id = '" . (int)$products_id . "'";

    $attributes = $db->Execute($attributes_query);

    if ($attributes->fields['total'] != 0) {
        return true;
    } else {
        return false;
    }
}


/*
 * Return a product's manufacturer's name, from ID
 * TABLES: products, manufacturers
 */
function zen_get_products_manufacturers_name($product_id)
{
    global $db;
    return "";/*t_products的manufacturers_id为0或null wsl*/
    /* $product_query = "select m.manufacturers_name
                      from " . TABLE_PRODUCTS . " p, " .
                            TABLE_MANUFACTURERS . " m
                      where p.products_id = '" . (int)$product_id . "'
                      and p.manufacturers_id = m.manufacturers_id";

    $product =$db->Execute($product_query);

    return ($product->RecordCount() > 0) ? $product->fields['manufacturers_name'] : ""; */
}

/*
 * Return a product's manufacturer's image, from Prod ID
 * TABLES: products, manufacturers
 */
function zen_get_products_manufacturers_image($product_id)
{
    global $db;
    return "";
    /*   $product_query = "select m.manufacturers_image
                        from " . TABLE_PRODUCTS . " p, " .
                              TABLE_MANUFACTURERS . " m
                        where p.products_id = '" . (int)$product_id . "'
                        and p.manufacturers_id = m.manufacturers_id";

      $product =$db->Execute($product_query);

      return $product->fields['manufacturers_image']; */
}

/*
 * Return a product's manufacturer's id, from Prod ID
 * TABLES: products
 */
function zen_get_products_manufacturers_id($product_id)
{
    global $db;

    $product_query = "select p.manufacturers_id
                      from " . TABLE_PRODUCTS . " p
                      where p.products_id = '" . (int)$product_id . "'";

    $product = $db->Execute($product_query);

    return $product->fields['manufacturers_id'];
}

/*
 * Return attributes products_options_sort_order
 * TABLE: PRODUCTS_ATTRIBUTES
 */
function zen_get_attributes_sort_order($products_id, $options_id, $options_values_id)
{
    global $db;
    $check = $db->Execute("select products_options_sort_order
                             from " . TABLE_PRODUCTS_ATTRIBUTES . "
                             where products_id = '" . (int)$products_id . "'
                             and options_id = '" . (int)$options_id . "'
                             and options_values_id = '" . (int)$options_values_id . "' limit 1");

    return $check->fields['products_options_sort_order'];
}

/*
 *  return attributes products_options_sort_order
 *  TABLES: PRODUCTS_OPTIONS, PRODUCTS_ATTRIBUTES
 */
function zen_get_attributes_options_sort_order($products_id, $options_id, $options_values_id)
{
    global $db;
    $check = $db->Execute("select products_options_sort_order
                             from " . TABLE_PRODUCTS_OPTIONS . "
                             where products_options_id = '" . (int)$options_id . "' limit 1");

    $check_options_id = $db->Execute("select products_id, options_id, options_values_id, products_options_sort_order
                             from " . TABLE_PRODUCTS_ATTRIBUTES . "
                             where products_id='" . (int)$products_id . "'
                             and options_id='" . (int)$options_id . "'
                             and options_values_id = '" . (int)$options_values_id . "' limit 1");


    return $check->fields['products_options_sort_order'] . '.' . str_pad($check_options_id->fields['products_options_sort_order'], 5, '0', STR_PAD_LEFT);
}

/*
 *  check if attribute is display only
 */
function zen_get_attributes_valid($product_id, $option, $value)
{
    global $db;

// regular attribute validation
    $check_attributes = $db->Execute("select attributes_display_only, attributes_required from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id='" . (int)$product_id . "' and options_id='" . (int)$option . "' and options_values_id='" . (int)$value . "'");

    $check_valid = true;

// display only cannot be selected
    if ($check_attributes->fields['attributes_display_only'] == '1') {
        $check_valid = false;
    }

// text required validation
    if (ereg('^txt_', $option)) {
        $check_attributes = $db->Execute("select attributes_display_only, attributes_required from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id='" . (int)$product_id . "' and options_id='" . (int)ereg_replace('txt_', '', $option) . "' and options_values_id='0'");
// text cannot be blank
        if ($check_attributes->fields['attributes_required'] == '1' and empty($value)) {
            $check_valid = false;
        }
    }

    return $check_valid;
}

/*
 * Return Options_Name from ID
 */

function zen_options_name($options_id)
{
    global $db;

    $options_id = str_replace('txt_', '', $options_id);

    $options_values = $db->Execute("select products_options_name
                                    from " . TABLE_PRODUCTS_OPTIONS . "
                                    where products_options_id = '" . (int)$options_id . "'
                                    and language_id = '" . (int)$_SESSION['languages_id'] . "'");

    return $options_values->fields['products_options_name'];
}

/*
 * Return Options_values_name from value-ID
 */
function zen_values_name($values_id)
{
    global $db;

    $values_values = $db->Execute("select products_options_values_name
                                   from " . TABLE_PRODUCTS_OPTIONS_VALUES . "
                                   where products_options_values_id = '" . (int)$values_id . "'
                                   and language_id = '" . (int)$_SESSION['languages_id'] . "'");

    return $values_values->fields['products_options_values_name'];
}

/*
 *  configuration key value lookup
 *  TABLE: configuration
 */
function zen_get_configuration_key_value($lookup)
{
    global $db;
    $configuration_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='" . $lookup . "'");
    $lookup_value = $configuration_query->fields['configuration_value'];
    if (!($lookup_value)) {
        $lookup_value = '<span class="lookupAttention">' . $lookup . '</span>';
    }
    return $lookup_value;
}

/*
 *  Return products description, based on specified language (or current lang if not specified)
 */
function zen_get_products_description($product_id, $language = '')
{
    global $db;

    if (empty($language)) $language = $_SESSION['languages_id'];

    $product_query = "select products_description
                      from " . TABLE_PRODUCTS_INFO . "
                      where products_id = '" . (int)$product_id . "'
                      and language_id = '" . (int)$language . "'";

    $product = $db->Execute($product_query);

    return $product->fields['products_description'];
}


/*
 * Get accepted credit cards
 * There needs to be a define on the accepted credit card in the language file credit_cards.php example: TEXT_CC_ENABLED_VISA
 */
function zen_get_cc_enabled($text_image = 'TEXT_', $cc_seperate = ' ', $cc_make_columns = 0)
{
    global $db;
    $cc_check_accepted_query = $db->Execute(SQL_CC_ENABLED);
    $cc_check_accepted = '';
    $cc_counter = 0;
    if ($cc_make_columns == 0) {
        while (!$cc_check_accepted_query->EOF) {
            $check_it = $text_image . $cc_check_accepted_query->fields['configuration_key'];
            if (defined($check_it)) {
                $cc_check_accepted .= constant($check_it) . $cc_seperate;
            }
            $cc_check_accepted_query->MoveNext();
        }
    } else {
        // build a table
        $cc_check_accepted = '<table class="ccenabled">' . "\n";
        $cc_check_accepted .= '<tr class="ccenabled">' . "\n";
        while (!$cc_check_accepted_query->EOF) {
            $check_it = $text_image . $cc_check_accepted_query->fields['configuration_key'];
            if (defined($check_it)) {
                $cc_check_accepted .= '<td class="ccenabled">' . constant($check_it) . '</td>' . "\n";
            }
            $cc_check_accepted_query->MoveNext();
            $cc_counter++;
            if ($cc_counter >= $cc_make_columns) {
                $cc_check_accepted .= '</tr>' . "\n" . '<tr class="ccenabled">' . "\n";
                $cc_counter = 0;
            }
        }
        $cc_check_accepted .= '</tr>' . "\n" . '</table>' . "\n";
    }
    return $cc_check_accepted;
}

/*
 * configuration key value lookup in TABLE_PRODUCT_TYPE_LAYOUT
 * Used to determine keys/flags used on a per-product-type basis for template-use, etc
 */
function zen_get_configuration_key_value_layout($lookup, $type = 1)
{
    global $db;
    $configuration_query = $db->Execute("select configuration_value from " . TABLE_PRODUCT_TYPE_LAYOUT . " where configuration_key='" . $lookup . "' and product_type_id='" . (int)$type . "'");
    $lookup_value = $configuration_query->fields['configuration_value'];
    if (!($lookup_value)) {
        $lookup_value = '<span class="lookupAttention">' . $lookup . '</span>';
    }
    return $lookup_value;
}

/*
 * look up a products image and send back the image's HTML \<IMG...\> tag
 */
function zen_get_products_image($product_id, $width = SMALL_IMAGE_WIDTH, $height = SMALL_IMAGE_HEIGHT)
{
    global $db;

    $sql = "select p.products_image from " . TABLE_PRODUCTS . " p  where products_id='" . (int)$product_id . "'";
    $look_up = $db->Execute($sql);

    return '<img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($look_up->fields['products_image'], 80, 80) . '" width="' . $width . '" height="' . $height . '">';
}

/*
 * look up whether a product is virtual
 */
function zen_get_products_virtual($lookup)
{
    global $db;

    $sql = "select p.products_virtual from " . TABLE_PRODUCTS . " p  where p.products_id='" . (int)$lookup . "'";
    $look_up = $db->Execute($sql);

    if ($look_up->fields['products_virtual'] == '1') {
        return true;
    } else {
        return false;
    }
}

/*
 * Look up whether the given product ID is allowed to be added to cart, according to product-type switches set in Admin
 */
function zen_get_products_allow_add_to_cart($lookup)
{
    global $db;

    /* $sql = "select products_type from " . TABLE_PRODUCTS . " where products_id='" . (int)$lookup . "'";
    $type_lookup = $db->Execute($sql); */
    $type_lookup = new stdClass();
    $type_lookup->fields = get_products_info_memcache((int)$zf_product_id, 'products_type');
    $sql = "select allow_add_to_cart from " . TABLE_PRODUCT_TYPES . " where type_id = '" . (int)$type_lookup->fields['products_type'] . "'";
    $allow_add_to_cart = $db->Execute($sql);

    return $allow_add_to_cart->fields['allow_add_to_cart'];
}

/*
 * Look up SHOW_XXX_INFO switch for product ID and product type
 */
function zen_get_show_product_switch_name($lookup, $field, $suffix = 'SHOW_', $prefix = '_INFO', $field_prefix = '_', $field_suffix = '')
{
    global $db;

    /* $sql = "select products_type from " . TABLE_PRODUCTS . " where products_id='" . (int)$lookup . "'";
    $type_lookup = $db->Execute($sql); */
    $type_lookup = new stdClass();
    $type_lookup->fields = get_products_info_memcache((int)$zf_product_id, 'products_type');
    $sql = "select type_handler from " . TABLE_PRODUCT_TYPES . " where type_id = '" . (int)$type_lookup->fields['products_type'] . "'";
    $show_key = $db->Execute($sql);


    $zv_key = strtoupper($suffix . $show_key->fields['type_handler'] . $prefix . $field_prefix . $field . $field_suffix);

    return $zv_key;
}

/*
 * Look up SHOW_XXX_INFO switch for product ID and product type
 */
function zen_get_show_product_switch($lookup, $field, $suffix = 'SHOW_', $prefix = '_INFO', $field_prefix = '_', $field_suffix = '')
{
    global $db;

    /* $sql = "select products_type from " . TABLE_PRODUCTS . " where products_id='" . zen_db_prepare_input($lookup) . "'";
    $type_lookup = $db->Execute($sql); */
    $type_lookup = new stdClass();
    $type_lookup->fields = get_products_info_memcache((int)$zf_product_id, 'products_type');
    $sql = "select type_handler from " . TABLE_PRODUCT_TYPES . " where type_id = '" . $type_lookup->fields['products_type'] . "'";
    $show_key = $db->Execute($sql);


    $zv_key = strtoupper($suffix . $show_key->fields['type_handler'] . $prefix . $field_prefix . $field . $field_suffix);

    $sql = "select configuration_key, configuration_value from " . TABLE_PRODUCT_TYPE_LAYOUT . " where configuration_key='" . $zv_key . "'";
    $zv_key_value = $db->Execute($sql);
    if ($zv_key_value->RecordCount() > 0) {
        return $zv_key_value->fields['configuration_value'];
    } else {
        $sql = "select configuration_key, configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='" . $zv_key . "'";
        $zv_key_value = $db->Execute($sql);
        if ($zv_key_value->RecordCount() > 0) {
            return $zv_key_value->fields['configuration_value'];
        } else {
            return false;
        }
    }
}

/*
 * look up the product type from product_id and return an info page name (for template/page handling)
 */
function zen_get_info_page($zf_product_id)
{
    global $db;
    return 'product_info';
    $sql = "select products_type from " . TABLE_PRODUCTS . " where products_id = '" . (int)$zf_product_id . "'";
    $zp_type = $db->Execute($sql);
    if ($zp_type->RecordCount() == 0) {
        return 'product_info';
    } else {
        $zp_product_type = $zp_type->fields['products_type'];
        $sql = "select type_handler from " . TABLE_PRODUCT_TYPES . " where type_id = '" . (int)$zp_product_type . "'";
        $zp_handler = $db->Execute($sql);
        return $zp_handler->fields['type_handler'] . '_info';
    }
}

/*
 *  Look up whether a product is always free shipping
 */
function zen_get_product_is_always_free_shipping($lookup)
{
    global $db;

    $sql = "select p.product_is_always_free_shipping from " . TABLE_PRODUCTS . " p  where p.products_id='" . (int)$lookup . "'";
    $look_up = $db->Execute($sql);

    if ($look_up->fields['product_is_always_free_shipping'] == '1') {
        return true;
    } else {
        return false;
    }
}

/*
 *  stop regular behavior based on customer/store settings
 *  Used to disable various activities if store is in an operating mode that should prevent those activities
 */
function zen_run_normal()
{
    $zc_run = false;
    switch (true) {
        case (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])):
            // down for maintenance not for ADMIN
            $zc_run = true;
            break;
        case (DOWN_FOR_MAINTENANCE == 'true'):
            // down for maintenance
            $zc_run = false;
            break;
        case (STORE_STATUS >= 1):
            // showcase no prices
            $zc_run = false;
            break;
        case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
            // customer must be logged in to browse
            $zc_run = false;
            break;
        case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
            // show room only
            // customer may browse but no prices
            $zc_run = false;
            break;
        case (CUSTOMERS_APPROVAL == '3'):
            // show room only
            $zc_run = false;
            break;
        case (CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and $_SESSION['customer_id'] == ''):
            // customer must be logged in to browse
            $zc_run = false;
            break;
        case (CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and $_SESSION['customers_authorization'] > '0'):
            // customer must be logged in to browse
            $zc_run = false;
            break;
        default:
            // proceed normally
            $zc_run = true;
            break;
    }
    return $zc_run;
}

/*
 *  Look up whether to show prices, based on customer-authorization levels
 */
function zen_check_show_prices()
{
    if (!(CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == '') and !((CUSTOMERS_APPROVAL_AUTHORIZATION > 0 and CUSTOMERS_APPROVAL_AUTHORIZATION < 3) and ($_SESSION['customers_authorization'] > '0' or $_SESSION['customer_id'] == '')) and STORE_STATUS != 1) {
        return true;
    } else {
        return false;
    }
}

/*
 * Return any field from products or products_description table
 * Example: zen_products_lookup('3', 'products_date_added');
 */
function zen_products_lookup($product_id, $what_field = 'products_name', $language = '')
{
    global $db;

    if (empty($language)) $language = $_SESSION['languages_id'];

    $product_lookup = $db->Execute("select " . $what_field . " as lookup_field
                              from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                              where p.products_id ='" . (int)$product_id . "'
                              and pd.language_id = '" . (int)$language . "'");

    $return_field = $product_lookup->fields['lookup_field'];

    return $return_field;
}

/*
 * Find index_filters directory
 * suitable for including template-specific immediate /modules files, such as:
 * new_products, products_new_listing, featured_products, featured_products_listing, product_listing, specials_index, upcoming,
 * products_all_listing, products_discount_prices, also_purchased_products
 */
function zen_get_index_filters_directory($check_file, $dir_only = 'false')
{
    global $template_dir;

    $zv_filename = $check_file;
    if (!strstr($zv_filename, '.php')) $zv_filename .= '.php';

    if (file_exists(DIR_WS_INCLUDES . 'index_filters/' . $template_dir . '/' . $zv_filename)) {
        $template_dir_select = $template_dir . '/';
    } else {
        $template_dir_select = '';
    }

    if (!file_exists(DIR_WS_INCLUDES . 'index_filters/' . $template_dir_select . '/' . $zv_filename)) {
        $zv_filename = 'default';
    }

    if ($dir_only == 'true') {
        return 'index_filters/' . $template_dir_select;
    } else {
        return 'index_filters/' . $template_dir_select . $zv_filename;
    }
}

////
// get define of New Products
function zen_get_products_new_timelimit($time_limit = false)
{
    if ($time_limit == false) {
        $time_limit = SHOW_NEW_PRODUCTS_LIMIT;
    }
    switch (true) {
        case ($time_limit == '0'):
            $display_limit = '';
            break;
        case ($time_limit == '1'):
            $display_limit = " and date_format(p.products_date_added, '%Y%m') >= date_format(now(), '%Y%m')";
            break;
        case ($time_limit == '7'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 7';
            break;
        case ($time_limit == '14'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 14';
            break;
        case ($time_limit == '30'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 30';
            break;
        case ($time_limit == '60'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 60';
            break;
        case ($time_limit == '90'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 90';
            break;
        case ($time_limit == '120'):
            $display_limit = ' and TO_DAYS(NOW()) - TO_DAYS(p.products_date_added) <= 120';
            break;
    }
    return $display_limit;
}

////
// check if Product is set to use downloads
// does not validate download filename
function zen_has_product_attributes_downloads_status($products_id)
{
    global $db;
    if (DOWNLOAD_ENABLED == 'true') {
        $download_display_query_raw = "select pa.products_attributes_id, pad.products_attributes_filename
                                    from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                    where pa.products_id='" . (int)$products_id . "'
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

// build date range for new products
function zen_get_new_date_range($time_limit = false)
{
    if ($time_limit == false) {
        $time_limit = SHOW_NEW_PRODUCTS_LIMIT;
    }
    // 120 days; 24 hours; 60 mins; 60secs
    $date_range = time() - ($time_limit * 24 * 60 * 60);
    $upcoming_mask_range = time();
    $upcoming_mask = date('Ymd', $upcoming_mask_range);

// echo 'Now:      '. date('Y-m-d') ."<br />";
// echo $time_limit . ' Days: '. date('Ymd', $date_range) ."<br />";
    $zc_new_date = date('Ymd', $date_range);
    switch (true) {
        case (SHOW_NEW_PRODUCTS_LIMIT == 0):
            $new_range = '';
            break;
        case (SHOW_NEW_PRODUCTS_LIMIT == 1):
            $zc_new_date = date('Ym', time()) . '01';
            $new_range = ' and p.products_date_added >=' . $zc_new_date;
            break;
        default:
            $new_range = ' and p.products_date_added >=' . $zc_new_date;
    }

    if (SHOW_NEW_PRODUCTS_UPCOMING_MASKED == 0) {
        // do nothing upcoming shows in new
    } else {
        // do not include upcoming in new
        $new_range .= " and (p.products_date_available <=" . $upcoming_mask . " or p.products_date_available IS NULL)";
    }
    return $new_range;
}


// build date range for upcoming products
function zen_get_upcoming_date_range()
{
    // 120 days; 24 hours; 60 mins; 60secs
    $date_range = time();
    $zc_new_date = date('Ymd', $date_range);
// need to check speed on this for larger sites
//    $new_range = ' and date_format(p.products_date_available, \'%Y%m%d\') >' . $zc_new_date;
    $new_range = ' and p.products_date_available >' . $zc_new_date . '235959';

    return $new_range;
}

function zen_display_links($max_page_links, $parameters = '', $current_page_number, $number_of_pages, $inputMore = '1', $page_name = 'page', $request_type = 'NONSSL')
{
    $display_links_string = $inputMore ? '<div class="pagelist_r">' : '';
    $display_links_trail = $inputMore ? '</div>' : '';
    $class = '';

    if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';

    // previous button - not displayed on first page
    if ($current_page_number > 1) {
        $display_links_string .= '<span><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=' . ($current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' " rel="nofollow"><</a></span>';
    }

    if ($number_of_pages <= 1) {
        return '&nbsp;';
    } elseif ($number_of_pages <= $max_page_links) {    //	1 < total page <= 5
        //	always show first page
        if ($current_page_number == 1) {
            $display_links_string .= '<span class="split_current_page">1</span>';
        } else {
            $display_links_string .= '<span><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=1', $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, 1) . ' " rel="nofollow">1</a></span>';
        }
        //	show second page to last page
        for ($jump_to_page0 = 2; $jump_to_page0 <= $number_of_pages - 1; $jump_to_page0++) {
            if ($jump_to_page0 == $current_page_number) {
                $display_links_string .= '<span class="split_current_page">' . $jump_to_page0 . '</span>';
            } else {
                $display_links_string .= '<span><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=' . $jump_to_page0, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, 1) . ' " rel="nofollow">' . $jump_to_page0 . '</a></span>';
            }
        }
    } else {
        //	bof show 3 pages when total page > 5

        //	bof always show first page
        if ($current_page_number == 1) {
            $display_links_string .= '<span class="split_current_page">1</span>';
            for ($jump_to_page0 = 2; $jump_to_page0 <= $max_page_links - 1; $jump_to_page0++) {
                if ($jump_to_page0 == $current_page_number) {
                    $display_links_string .= '<span class="split_current_page">' . $jump_to_page0 . '</span>';
                } else {
                    $display_links_string .= '<span><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=' . $jump_to_page0, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page0) . ' " rel="nofollow">' . $jump_to_page0 . '</a></span>';
                }
            }
        } else {
            $display_links_string .= '<span><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=1', $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, 1) . ' " rel="nofollow">1</a></span>';
        }
        //	eof always show first page

        if ($current_page_number > $max_page_links - 1) {    //	3 or more pages between first page and current page
            $display_links_string .= '<span class="ellipsis"><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=' . ($current_page_number - ($max_page_links - 2)), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE, ($max_page_links - 2)) . ' " rel="nofollow">...</a></span>';
        } elseif ($current_page_number > 2) {
            $display_links_string .= '<span class="ellipsis"><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=2', $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE, ($current_page_number - 2)) . ' " rel="nofollow">...</a></span>';
        }

        for ($jump_to_page = $current_page_number; ($jump_to_page < ($current_page_number + $max_page_links - 2)) && $current_page_number < $number_of_pages - $max_page_links + 2 && $current_page_number > 1; $jump_to_page++) {
            if ($jump_to_page == $current_page_number) {
                $display_links_string .= '<span class="split_current_page">' . $jump_to_page . '</span>';
            } else {
                $display_links_string .= '<span><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=' . $jump_to_page, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' " rel="nofollow">' . $jump_to_page . '</a></span>';
            }
        }
        for ($jump_to_page1 = $number_of_pages - $max_page_links + 2; $jump_to_page1 < $number_of_pages && $current_page_number >= $number_of_pages - $max_page_links + 2; $jump_to_page1++) {
            if ($jump_to_page1 == $current_page_number) {
                $display_links_string .= '<span class="split_current_page">' . $jump_to_page1 . '</span>';
            } else {
                $display_links_string .= '<span><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=' . $jump_to_page1, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page1) . ' " rel="nofollow">' . $jump_to_page1 . '</a></span>';
            }
        }
        if ($current_page_number + $max_page_links - 2 >= $number_of_pages) {

        } else {
            if ($number_of_pages - $current_page_number > $max_page_links) {    //	3 or more pages between current page and last page
                $display_links_string .= '<span class="ellipsis"><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=' . ($current_page_number + $max_page_links - 2), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE, ($max_page_links - 2)) . ' " rel="nofollow">...</a></span>';
            } else {
                $display_links_string .= '<span class="ellipsis"><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=' . ($number_of_pages + 2 - $max_page_links), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE, ($number_of_pages - $current_page_number - $max_page_links + 2)) . ' " rel="nofollow">...</a></span>';
            }
        }
    }
    //eof show 3 pages when total page > 5

    //bof always show last page
    if ($current_page_number == $number_of_pages) {
        $display_links_string .= '<span class="split_current_page">' . $number_of_pages . '</span>';
    } else {
        $display_links_string .= '<span><a href="' . zen_href_link($_GET['main_page'], $parameters . $page_name . '=' . $number_of_pages, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $number_of_pages) . ' " rel="nofollow">' . $number_of_pages . '</a></span>';
    }
    //eof always show last page

    //next button
    if ($current_page_number < $number_of_pages) {
        $display_links_string .= '<span><a href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' " rel="nofollow">' . PREVNEXT_BUTTON_NEXT_NEW . '&nbsp;></a></span>';
    }
    $display_links_string .= $display_links_trail;
    return $display_links_string;
}


function zen_promotion_display_area_data()
{
    global $db;
    require './includes/extra_configures/times_language.php';

    $languageId = (int)$_SESSION["languages_id"] - 1;
    $promotion_display_area_sql = 'SELECT
									zpda.display_area_id,
									zpda.promotion_id,
									zpda.promotion_type,
									zpdd.display_picture_url,
									zpdd.display_area_description
								FROM ' . TABLE_PROMOTION_DISPLAY_AREA . ' zpda
								INNER JOIN ' . TABLE_PROMOTION_DISPLAY_AREA_DESCRIPTION . ' zpdd ON zpda.display_area_id = zpdd.display_area_id
								WHERE zpdd.languages_id = "' . (int)$_SESSION['languages_id'] . '" and zpda.display_status = 10 order by zpda.display_level desc, zpda.display_area_id desc';

    $promotion_display_area_query = $db->Execute($promotion_display_area_sql);

    if ($promotion_display_area_query->RecordCount() > 0) {
        $i = 1;
        while (!$promotion_display_area_query->EOF) {
            $promotion_id = $promotion_display_area_query->fields['promotion_id'];
            $promotion_type = $promotion_display_area_query->fields['promotion_type'];

            if (in_array($promotion_type, array(10, 20))) {
                $promotion_query = $db->Execute('SELECT zpa.related_promotion_ids, zpd.promotion_area_name FROM ' . TABLE_PROMOTION_AREA . ' zpa inner join ' . TABLE_PROMOTION_AREA_DESCRIPTION . ' zpd on zpa.promotion_area_id = zpd.promotion_area_id WHERE zpa.promotion_area_status = 1 and zpa.promotion_area_id = "' . $promotion_id . '" and zpd.languages_id = "' . $_SESSION['languages_id'] . '"');
                if ($promotion_query->RecordCount() > 0) {
                    $discount_area = str_replace(',', '_', $promotion_query->fields['related_promotion_ids']);

                    $discount_area_query = $db->Execute('SELECT promotion_id , promotion_start_time , promotion_end_time FROM ' . TABLE_PROMOTION . ' WHERE  promotion_id in (' . strval($promotion_query->fields['related_promotion_ids']) . ') and promotion_start_time < now() and promotion_end_time > now() AND promotion_status = 1');
                    if ($discount_area_query->RecordCount() > 0) {
                        $min_datetime = $discount_area_query->fields['promotion_start_time'];
                        $max_datetime = $discount_area_query->fields['promotion_end_time'];

                        while (!$discount_area_query->EOF) {
                            if (strtotime($min_datetime) > strtotime($discount_area_query->fields['promotion_start_time'])) {
                                $min_datetime = $discount_area_query->fields['promotion_start_time'];
                            }

                            if (strtotime($max_datetime) < strtotime($discount_area_query->fields['promotion_end_time'])) {
                                $max_datetime = $discount_area_query->fields['promotion_end_time'];
                            }
                            $discount_area_query->MoveNext();
                        }
                        $cate_year = (int)substr($min_datetime, 0, 4);
                        $cate_monthNUM = ((int)substr($min_datetime, 5, 2)) - 1;
                        $cate_day = (int)substr($min_datetime, 8, 2);

                        $promotion_time = $time_months[$languageId][$cate_monthNUM] . ' ' . $cate_day . ', ' . $cate_year;

                        $cate_year = (int)substr($max_datetime, 0, 4);
                        $cate_monthNUM = ((int)substr($max_datetime, 5, 2)) - 1;
                        $cate_day = (int)substr($max_datetime, 8, 2);

                        $promotion_time .= ' - ' . $time_months[$languageId][$cate_monthNUM] . ' ' . $cate_day . ', ' . $cate_year;

                        switch ($promotion_type) {
                            case 10:
                                $picture_href = zen_href_link(FILENAME_PROMOTION, 'aId=' . $promotion_id . '&off=' . $discount_area);
                                break;
                            case 20:
                                $picture_href = zen_href_link(FILENAME_PROMOTION_DEALS, 'aId=' . $promotion_id . '&off=' . $discount_area);
                                break;
                        }

                        $display_area_info_array[$i] = array(
                            'display_area_id' => $promotion_display_area_query->fields['display_area_id'],
                            'promotion_id' => $promotion_id,
                            'promotion_type' => $promotion_type,
                            'picture_url' => $promotion_display_area_query->fields['display_picture_url'],
                            'picture_href' => $picture_href,
                            'promotion_time' => $promotion_time,
                            'area_name' => $promotion_query->fields['promotion_area_name']
                        );
                        $i++;
                    } else {
                        $promotion_display_area_query->MoveNext();
                        continue;
                    }
                } else {
                    $promotion_display_area_query->MoveNext();
                    continue;
                }

            } else {
                $dailydeal_info_query = $db->Execute('SELECT zdd.area_name , zda.start_date , zda.end_date FROM ' . TABLE_DAILYDEAL_AREA . ' zda inner join ' . TABLE_DAILYDEAL_AREA_DESCRIPTION . ' zdd on zda.dailydeal_area_id = zdd.area_id WHERE zda.dailydeal_area_id = "' . $promotion_id . '" AND zda.area_status = 1 AND zda.start_date < NOW() AND zda.end_date > NOW() and zdd.languages_id = "' . $_SESSION['languages_id'] . '"');

                $cate_year = (int)substr($dailydeal_info_query->fields['start_date'], 0, 4);
                $cate_monthNUM = ((int)substr($dailydeal_info_query->fields['start_date'], 5, 2)) - 1;
                $cate_day = (int)substr($dailydeal_info_query->fields['start_date'], 8, 2);

                $promotion_time = $time_months[$languageId][$cate_monthNUM] . ' ' . $cate_day . ', ' . $cate_year;

                $cate_year = (int)substr($dailydeal_info_query->fields['end_date'], 0, 4);
                $cate_monthNUM = ((int)substr($dailydeal_info_query->fields['end_date'], 5, 2)) - 1;
                $cate_day = (int)substr($dailydeal_info_query->fields['end_date'], 8, 2);

                $promotion_time .= ' - ' . $time_months[$languageId][$cate_monthNUM] . ' ' . $cate_day . ', ' . $cate_year;

                if ($dailydeal_info_query->RecordCount() > 0) {
                    $picture_href = zen_href_link(FILENAME_PROMOTION_PRICE, 'g=' . $promotion_id);

                    $display_area_info_array[$i] = array(
                        'display_area_id' => $promotion_display_area_query->fields['display_area_id'],
                        'promotion_id' => $promotion_id,
                        'promotion_type' => $promotion_type,
                        'picture_url' => $promotion_display_area_query->fields['display_picture_url'],
                        'picture_href' => $picture_href,
                        'promotion_time' => $promotion_time,
                        'area_name' => $dailydeal_info_query->fields['area_name']
                    );
                    $i++;
                }
            }

            $promotion_display_area_query->MoveNext();
        }
    }

    return $display_area_info_array;
}

function zen_get_product_row_solr_str()
{
    global $db;
    $properties_select = ' ';
    $delArray = array();
    $getsInfoArray = array();
    $propertyGet = '';
    $return_array = array();

    if (!isset($_GET['action'])) {
        if (!isset($_SESSION['display_mode'])) $_SESSION['display_mode'] = 'normal';
    } else {
        if ($_GET['action'] == 'quick') {
            $_SESSION['display_mode'] = 'quick';
        } else {
            $_SESSION['display_mode'] = 'normal';
        }
    }

    if (isset ($_GET ['cId']) && $_GET ['cId'] != 0) {
        $last_category_id = $_GET ['cId'];
    }

    if (isset($_GET['pcount']) && $_GET['pcount'] > 0) {
        $property_by_group = array();
        for ($cnt = 1; $cnt <= $_GET['pcount']; $cnt++) {
            if ($_GET['p' . $cnt] > 0) {
                $propertyGet = '&p' . $cnt . '=' . $_GET['p' . $cnt] . $propertyGet;
                $getsInfoArray['p' . $cnt] = $_GET['p' . $cnt];

                $delArray[] = 'p' . $cnt;
                $group_query = $db->Execute("select property_group_id from " . TABLE_PROPERTY . " where property_id='" . $_GET['p' . $cnt] . "' limit 1");
                $property_by_group[$group_query->fields['property_group_id']][] = $_GET['p' . $cnt];
            }
        }

        foreach ($property_by_group as $pg => $pv) {
            $properties_select .= ' AND (';
            for ($prop_cnt = 0; $prop_cnt < sizeof($pv); $prop_cnt++) {
                if ($prop_cnt > 0) $properties_select .= ' OR ';
                $properties_select .= ' properties_id:' . $pv[$prop_cnt];
            }
            $properties_select .= ' )';
        }
        $propertyGet = $propertyGet . '&pcount=' . $_GET['pcount'];
    }
    $delArray [] = 'pcount';
    $delArray [] = 'page';

    $solr_select_query = '';
    $extra_select_str = $last_category_id ? ' AND categories_id:' . $last_category_id . ' ' : '';

    $return_array['properties_select'] = $properties_select;
    $return_array['delArray'] = $delArray;
    $return_array['getsInfoArray'] = $getsInfoArray;
    $return_array['propertyGet'] = $propertyGet;
    $return_array['extra_select_str'] = $extra_select_str;
    $return_array['property_by_group'] = $property_by_group;

    return $return_array;

}

function zen_get_product_row_solr($solr, $solr_order_str, $solr_select_query, $search_offset, $item_per_page)
{
    $return_array = array();

    $condition['sort'] = $solr_order_str;
    $condition['facet'] = 'true';
    $condition['facet.mincount'] = '1';
    $condition['facet.limit'] = '-1';

    $condition['facet.field'][] = 'properties_id';
    $condition['f.properties_id.facet.missing'] = 'true';
    $condition['f.properties_id.facet.method'] = 'enum';

    $condition['facet.field'][] = 'categories_id';
    $condition['f.categories_id.facet.missing'] = 'true';
    $condition['f.categories_id.facet.method'] = 'enum';
    $condition['fl'] = 'products_id,is_promotion,is_hot_seller, score';

    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) {
        $products_display_solr_str = '';
    } else {
        $products_display_solr_str = ' AND is_display:1';
    }
    $solr_select_query .= $products_display_solr_str;

    $count_res = $solr->search($solr_select_query, $search_offset, $item_per_page, $condition);
    $num_products_count = $count_res->response->numFound;
    $products_new_split = new splitPageResults('', $item_per_page, '', 'page', false, $num_products_count);

    $product_all = $count_res->response->docs;
    $properties_facet = $count_res->facet_counts->facet_fields->properties_id;
    $categories_facet = $count_res->facet_counts->facet_fields->categories_id;
    $categories_refine_by = get_refine_by_category_tree($categories_facet);

    $return_array['count_res'] = $count_res;
    $return_array['num_products_count'] = $num_products_count;
    $return_array['products_new_split'] = $products_new_split;
    $return_array['properties_facet'] = $properties_facet;
    $return_array['categories_facet'] = $categories_facet;
    $return_array['categories_refine_by'] = $categories_refine_by;
    $return_array['product_all'] = $product_all;
    $return_array['condition'] = $condition;

    return $return_array;
}


?>