<?php
/**
 * functions_general.php
 * General functions used throughout Zen Cart
 *
 * @package functions
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_general.php 14754 2009-11-07 20:35:18Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
/**
 * Stop from parsing any further PHP code
 */
function zen_exit() {
    session_write_close();
    exit();
}

/**
 * Redirect to another page or site
 * @param string The url to redirect to
 */
function zen_redirect($url) {
    global $request_type;
    // Are we loading an SSL page?
    if ( (ENABLE_SSL == true) && ($request_type == 'SSL') ) {
        // yes, but a NONSSL url was supplied
        if (substr($url, 0, strlen(HTTP_SERVER . DIR_WS_CATALOG)) == HTTP_SERVER . DIR_WS_CATALOG) {
            // So, change it to SSL, based on site's configuration for SSL
            $url = HTTPS_SERVER . DIR_WS_HTTPS_CATALOG . substr($url, strlen(HTTP_SERVER . DIR_WS_CATALOG));
        }
    }

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

    zen_exit();
}

/**
 * Parse the data used in the html tags to ensure the tags will not break.
 * Basically just an extension to the php strstr function
 * @param string The string to be parsed
 * @param string The needle to find
 */
// Parse the data used in the html tags to ensure the tags will not break
function zen_parse_input_field_data($data, $parse) {
    return strtr(trim($data), $parse);
}

/**
 * Returns a string with conversions for security.
 * @param string The string to be parsed
 * @param string contains a string to be translated, otherwise just quote is translated
 * @param boolean Do we run htmlspecialchars over the string
 */
function zen_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
        return htmlspecialchars($string,ENT_QUOTES);
    } else {
        if ($translate == false) {
            return zen_parse_input_field_data($string, array('"' => '&quot;'));
        } else {
            return zen_parse_input_field_data($string, $translate);
        }
    }
}

/**
 * Returns a string with conversions for security.
 *
 * Simply calls the zen_ouput_string function
 * with parameters that run htmlspecialchars over the string
 * and converts quotes to html entities
 *
 * @param string The string to be parsed
 */
function zen_output_string_protected($string) {
    return zen_output_string($string, false, true);
}

/**
 * Returns a string with conversions for security.
 *
 * @param string The string to be parsed
 */

function zen_sanitize_string($string) {
    $string = eregi_replace(' +|select |update |insert |delete |replace |where |from ', ' ', $string);
    return preg_replace("/[<>]/", '_', $string);
}


/**
 * Break a word in a string if it is longer than a specified length ($len)
 *
 * @param string The string to be broken up
 * @param int The maximum length allowed
 * @param string The character to use at the end of the broken line
 */
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

/**
 * Return all HTTP GET variables, except those passed as a parameter
 *
 * The return is a urlencoded string
 *
 * @param mixed either a single or array of parameter names to be excluded from output
 */
// Return all HTTP GET variables, except those passed as a parameter
function zen_get_all_get_params($exclude_array = '', $search_engine_safe = true) {

    if (!is_array($exclude_array)) $exclude_array = array();
  
    $get_url = '';
    if (is_array($_GET) && (sizeof($_GET) > 0)) {
      
        reset($_GET);

        while (list($key, $value) = each($_GET)) {
            
            if ( (strlen($value) > 0) && ($key != 'main_page') && ($key != zen_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y') ) {  
                
                if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
//    die ('here');
                    $get_url .= $key . '/' . rawurlencode(stripslashes($value)) . '/';

                } else {
                    $get_url .= $key . '=' . rawurlencode(stripslashes($value)) . '&';

                }
            }
        }
    }
    while (strstr($get_url, '&&')) $get_url = str_replace('&&', '&', $get_url);
    while (strstr($get_url, '&amp;&amp;')) $get_url = str_replace('&amp;&amp;', '&amp;', $get_url);
    
    return $get_url;
}


////
// Returns the clients browser
function zen_browser_detect($component) {
    global $HTTP_USER_AGENT;

    return stristr($HTTP_USER_AGENT, $component);
}


////
// Wrapper function for round()
function zen_round($number, $precision) {
/// fix rounding error on GVs etc.
    $number = round($number, $precision);
    $m = strrpos($number, '.') ? strlen(substr($number, 0, strrpos($number, '.'))) : strlen($number);	//整数位数
    $n = strrpos($number, '.') ? strlen(substr($number, strrpos($number, '.') + 1)) : 0; //小数点位数
    if ($n < $precision){
        $t = $m + 1 + $precision; //final length
        $number = str_pad($number . (strrpos($number, '.') ? '' : '.'), $t, '0', STR_PAD_RIGHT);
    }

    return $number;
}


////
// default filler is a 0 or pass filler to be used
function zen_row_number_format($number, $filler='0') {
    if ( ($number < 10) && (substr($number, 0, 1) != '0') ) $number = $filler . $number;

    return $number;
}


// Output a raw date string in the selected locale date format
// $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
/*function zen_date_long($raw_date) {
  if ( ($raw_date == '0001-01-01 00:00:00') || ($raw_date == '') ) return false;

  $year = (int)substr($raw_date, 0, 4);
  $month = (int)substr($raw_date, 5, 2);
  $day = (int)substr($raw_date, 8, 2);
  $hour = (int)substr($raw_date, 11, 2);
  $minute = (int)substr($raw_date, 14, 2);
  $second = (int)substr($raw_date, 17, 2);

  return strftime(DATE_FORMAT_LONG, mktime($hour,$minute,$second,$month,$day,$year));
}*/

function zen_date_long($raw_date) {
    if ( ($raw_date == '0001-01-01 00:00:00') || ($raw_date == '') ) return false;
    global $time_months;
    global $time_days;
    $year = (int)substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);

    $day = (int)substr($raw_date, 8, 2);
    $dayNum=(int)date("w", strtotime($raw_date))-1;
    $monthNum= $month-1;
    $languageId=(int)$_SESSION["languages_id"]-1;
    $longtime=$time_days[$languageId][$dayNum]." ".$day ." ".$time_months[$languageId][$monthNum].",".$year;
    if ((int)$_SESSION["languages_id"] == 6) {
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
////
// Output a raw date string in the selected locale date format
// $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
// NOTE: Includes a workaround for dates before 01/01/1970 that fail on windows servers
function zen_date_short($raw_date) {
    if ( ($raw_date == '0001-01-01 00:00:00') || empty($raw_date) ) return false;

    $year = substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

// error on 1969 only allows for leap year
    if ($year != 1969 && @date('Y', mktime($hour, $minute, $second, $month, $day, $year)) == $year) {
        return strftime(DATE_FORMAT_SHORT, mktime($hour, $minute, $second, $month, $day, $year));
    } else {
        return ereg_replace('2037' . '$', $year, date(DATE_FORMAT_SHORT, mktime($hour, $minute, $second, $month, $day, 2037)));
    }
}

////
// Parse search string into indivual objects
function zen_parse_search_string($search_str = '', &$objects) {
    $search_str = trim(strtolower($search_str));

// Break up $search_str on whitespace; quoted string will be reconstructed later
    $pieces = preg_split('/[[:space:]]+/', $search_str);
    $objects = array();
    $tmpstring = '';
    $flag = '';

    for ($k=0; $k<count($pieces); $k++) {
        while (substr($pieces[$k], 0, 1) == '(') {
            $objects[] = '(';
            if (strlen($pieces[$k]) > 1) {
                $pieces[$k] = substr($pieces[$k], 1);
            } else {
                $pieces[$k] = '';
            }
        }

        $post_objects = array();

        while (substr($pieces[$k], -1) == ')')  {
            $post_objects[] = ')';
            if (strlen($pieces[$k]) > 1) {
                $pieces[$k] = substr($pieces[$k], 0, -1);
            } else {
                $pieces[$k] = '';
            }
        }

// Check individual words

        if ( (substr($pieces[$k], -1) != '"') && (substr($pieces[$k], 0, 1) != '"') ) {
            $objects[] = trim($pieces[$k]);

            for ($j=0; $j<count($post_objects); $j++) {
                $objects[] = $post_objects[$j];
            }
        } else {
            /* This means that the $piece is either the beginning or the end of a string.
               So, we'll slurp up the $pieces and stick them together until we get to the
               end of the string or run out of pieces.
            */

// Add this word to the $tmpstring, starting the $tmpstring
            $tmpstring = trim(preg_replace('/"/', ' ', $pieces[$k]));

// Check for one possible exception to the rule. That there is a single quoted word.
            if (substr($pieces[$k], -1 ) == '"') {
// Turn the flag off for future iterations
                $flag = 'off';

                $objects[] = trim($pieces[$k]);

                for ($j=0; $j<count($post_objects); $j++) {
                    $objects[] = $post_objects[$j];
                }

                unset($tmpstring);

// Stop looking for the end of the string and move onto the next word.
                continue;
            }

// Otherwise, turn on the flag to indicate no quotes have been found attached to this word in the string.
            $flag = 'on';

// Move on to the next word
            $k++;

// Keep reading until the end of the string as long as the $flag is on

            while ( ($flag == 'on') && ($k < count($pieces)) ) {
                while (substr($pieces[$k], -1) == ')') {
                    $post_objects[] = ')';
                    if (strlen($pieces[$k]) > 1) {
                        $pieces[$k] = substr($pieces[$k], 0, -1);
                    } else {
                        $pieces[$k] = '';
                    }
                }

// If the word doesn't end in double quotes, append it to the $tmpstring.
                if (substr($pieces[$k], -1) != '"') {
// Tack this word onto the current string entity
                    $tmpstring .= ' ' . $pieces[$k];

// Move on to the next word
                    $k++;
                    continue;
                } else {
                    /* If the $piece ends in double quotes, strip the double quotes, tack the
                       $piece onto the tail of the string, push the $tmpstring onto the $haves,
                       kill the $tmpstring, turn the $flag "off", and return.
                    */
                    $tmpstring .= ' ' . trim(preg_replace('/"/', ' ', $pieces[$k]));

// Push the $tmpstring onto the array of stuff to search for
                    $objects[] = trim($tmpstring);

                    for ($j=0; $j<count($post_objects); $j++) {
                        $objects[] = $post_objects[$j];
                    }

                    unset($tmpstring);

// Turn off the flag to exit the loop
                    $flag = 'off';
                }
            }
        }
    }

// add default logical operators if needed
    $temp = array();
    for($i=0; $i<(count($objects)-1); $i++) {
        $temp[] = $objects[$i];
        if ( ($objects[$i] != 'and') &&
            ($objects[$i] != 'or') &&
            ($objects[$i] != '(') &&
            ($objects[$i+1] != 'and') &&
            ($objects[$i+1] != 'or') &&
            ($objects[$i+1] != ')') ) {
            $temp[] = ADVANCED_SEARCH_DEFAULT_OPERATOR;
        }
    }
    $temp[] = $objects[$i];
    $objects = $temp;

    $keyword_count = 0;
    $operator_count = 0;
    $balance = 0;
    for($i=0; $i<count($objects); $i++) {
        if ($objects[$i] == '(') $balance --;
        if ($objects[$i] == ')') $balance ++;
        if ( ($objects[$i] == 'and') || ($objects[$i] == 'or') ) {
            $operator_count ++;
        } elseif ( ($objects[$i]) && ($objects[$i] != '(') && ($objects[$i] != ')') ) {
            $keyword_count ++;
        }
    }

    if ( ($operator_count < $keyword_count) && ($balance == 0) ) {
        return true;
    } else {
        return false;
    }
}


////
// Check date
function zen_checkdate($date_to_check, $format_string, &$date_array) {
    $separator_idx = -1;

    $separators = array('-', ' ', '/', '.');
    $month_abbr = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');
    $no_of_days = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    $format_string = strtolower($format_string);

    if (strlen($date_to_check) != strlen($format_string)) {
        return false;
    }

    $size = sizeof($separators);
    for ($i=0; $i<$size; $i++) {
        $pos_separator = strpos($date_to_check, $separators[$i]);
        if ($pos_separator != false) {
            $date_separator_idx = $i;
            break;
        }
    }

    for ($i=0; $i<$size; $i++) {
        $pos_separator = strpos($format_string, $separators[$i]);
        if ($pos_separator != false) {
            $format_separator_idx = $i;
            break;
        }
    }

    if ($date_separator_idx != $format_separator_idx) {
        return false;
    }

    if ($date_separator_idx != -1) {
        $format_string_array = explode( $separators[$date_separator_idx], $format_string );
        if (sizeof($format_string_array) != 3) {
            return false;
        }

        $date_to_check_array = explode( $separators[$date_separator_idx], $date_to_check );
        if (sizeof($date_to_check_array) != 3) {
            return false;
        }

        $size = sizeof($format_string_array);
        for ($i=0; $i<$size; $i++) {
            if ($format_string_array[$i] == 'mm' || $format_string_array[$i] == 'mmm') $month = $date_to_check_array[$i];
            if ($format_string_array[$i] == 'dd') $day = $date_to_check_array[$i];
            if ( ($format_string_array[$i] == 'yyyy') || ($format_string_array[$i] == 'aaaa') ) $year = $date_to_check_array[$i];
        }
    } else {
        if (strlen($format_string) == 8 || strlen($format_string) == 9) {
            $pos_month = strpos($format_string, 'mmm');
            if ($pos_month != false) {
                $month = substr( $date_to_check, $pos_month, 3 );
                $size = sizeof($month_abbr);
                for ($i=0; $i<$size; $i++) {
                    if ($month == $month_abbr[$i]) {
                        $month = $i;
                        break;
                    }
                }
            } else {
                $month = substr($date_to_check, strpos($format_string, 'mm'), 2);
            }
        } else {
            return false;
        }

        $day = substr($date_to_check, strpos($format_string, 'dd'), 2);
        $year = substr($date_to_check, strpos($format_string, 'yyyy'), 4);
    }

    if (strlen($year) != 4) {
        return false;
    }

    if (!settype($year, 'integer') || !settype($month, 'integer') || !settype($day, 'integer')) {
        return false;
    }

    if ($month > 12 || $month < 1) {
        return false;
    }

    if ($day < 1) {
        return false;
    }

    if (zen_is_leap_year($year)) {
        $no_of_days[1] = 29;
    }

    if ($day > $no_of_days[$month - 1]) {
        return false;
    }

    $date_array = array($year, $month, $day);

    return true;
}


////
// Check if year is a leap year
function zen_is_leap_year($year) {
    if ($year % 100 == 0) {
        if ($year % 400 == 0) return true;
    } else {
        if (($year % 4) == 0) return true;
    }

    return false;
}

////
// Return table heading with sorting capabilities
function zen_create_sort_heading($sortby, $colnum, $heading) {
    global $PHP_SELF;

    $sort_prefix = '';
    $sort_suffix = '';

    if ($sortby) {
        $sort_prefix = '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('page', 'info', 'sort')) . 'page=1&sort=' . $colnum . ($sortby == $colnum . 'a' ? 'd' : 'a')) . '" title="' . zen_output_string(TEXT_SORT_PRODUCTS . ($sortby == $colnum . 'd' || substr($sortby, 0, 1) != $colnum ? TEXT_ASCENDINGLY : TEXT_DESCENDINGLY) . TEXT_BY . $heading) . '" class="productListing-heading">' ;
        $sort_suffix = (substr($sortby, 0, 1) == $colnum ? (substr($sortby, 1, 1) == 'a' ? PRODUCT_LIST_SORT_ORDER_ASCENDING : PRODUCT_LIST_SORT_ORDER_DESCENDING) : '') . '</a>';
    }

    return $sort_prefix . $heading . $sort_suffix;
}


////
// Return a product ID with attributes
/*
  function zen_get_uprid_OLD($prid, $params) {
    $uprid = $prid;
    if ( (is_array($params)) && (!strstr($prid, '{')) ) {
      while (list($option, $value) = each($params)) {
        $uprid = $uprid . '{' . $option . '}' . $value;
      }
    }

    return $uprid;
  }
*/


////
// Return a product ID with attributes
function zen_get_uprid($prid, $params) {
//print_r($params);
    $uprid = $prid;
    if ( (is_array($params)) && (!strstr($prid, ':')) ) {
        while (list($option, $value) = each($params)) {
            if (is_array($value)) {
                while (list($opt, $val) = each($value)) {
                    $uprid = $uprid . '{' . $option . '}' . trim($opt);
                }
                break;
            }
            //CLR 030714 Add processing around $value. This is needed for text attributes.
            $uprid = $uprid . '{' . $option . '}' . trim($value);
        }
        //CLR 030228 Add else stmt to process product ids passed in by other routines.
        $md_uprid = '';

        $md_uprid = md5($uprid);
        return $prid . ':' . $md_uprid;
    } else {
        return $prid;
    }
}


////
// Return a product ID from a product ID with attributes
function zen_get_prid($uprid) {
    $pieces = explode(':', $uprid);

    return $pieces[0];
}



////
// Get the number of times a word/character is present in a string
function zen_word_count($string, $needle) {
    $temp_array = preg_split('/'.$needle.'/', $string);

    return sizeof($temp_array);
}


////
function zen_count_modules($modules = '') {
    $count = 0;

    if (empty($modules)) return $count;

    $modules_array = preg_split('/;/', $modules);

    for ($i=0, $n=sizeof($modules_array); $i<$n; $i++) {
        $class = substr($modules_array[$i], 0, strrpos($modules_array[$i], '.'));

        if (is_object($GLOBALS[$class])) {
            if ($GLOBALS[$class]->enabled) {
                $count++;
            }
        }
    }

    return $count;
}

////
function zen_count_payment_modules() {
    return zen_count_modules(MODULE_PAYMENT_INSTALLED);
}

////
function zen_count_shipping_modules() {
    return zen_count_modules(MODULE_SHIPPING_INSTALLED);
}

////
function zen_create_random_value($length, $type = 'mixed') {
    if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;

    $rand_value = '';
    while (strlen($rand_value) < $length) {
        if ($type == 'digits') {
            $char = zen_rand(0,9);
        } else {
            $char = chr(zen_rand(0,255));
        }
        if ($type == 'mixed') {
            if (preg_match('/^[a-z0-9]$/i', $char)) $rand_value .= $char;
        } elseif ($type == 'chars') {
            if (preg_match('/^[a-z]$/i', $char)) $rand_value .= $char;
        } elseif ($type == 'digits') {
            if (preg_match('/^[0-9]$/', $char)) $rand_value .= $char;
        }
    }

    return $rand_value;
}

////
function zen_array_to_string($array, $exclude = '', $equals = '=', $separator = '&') {
    if (!is_array($exclude)) $exclude = array();
    if (!is_array($array)) $array = array();

    $get_string = '';
    if (sizeof($array) > 0) {
        while (list($key, $value) = each($array)) {
            if ( (!in_array($key, $exclude)) && ($key != 'x') && ($key != 'y') ) {
                $get_string .= $key . $equals . $value . $separator;
            }
        }
        $remove_chars = strlen($separator);
        $get_string = substr($get_string, 0, -$remove_chars);
    }

    return $get_string;
}

////
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
        if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
            return true;
        } else {
            return false;
        }
    }
}


////
// Checks to see if the currency code exists as a currency
// TABLES: currencies
function zen_currency_exists($code, $getFirstDefault = false) {
    global $db;
    $code = zen_db_prepare_input($code);

    $currency_code = "select code
                      from " . TABLE_CURRENCIES . "
                      where code = '" . zen_db_input($code) . "' LIMIT 1";

    $currency_first = "select code
                      from " . TABLE_CURRENCIES . "
                      order by value ASC LIMIT 1";

    $currency = $db->Execute(($getFirstDefault == false) ? $currency_code : $currency_first);

    if ($currency->RecordCount()) {
        return strtoupper($currency->fields['code']);
    } else {
        return false;
    }
}

////
function zen_string_to_int($string) {
    return (int)$string;
}

////
// Return a random value
function zen_rand($min = null, $max = null) {
    static $seeded;

    if (!isset($seeded)) {
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

////
function zen_get_top_level_domain($url) {
    if (strpos($url, '://')) {
        $url = parse_url($url);
        $url = $url['host'];
    }
//echo $url;

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
function zen_setcookie($name, $value = '', $expire = 0, $path = '/', $domain = '', $secure = 0) {
    setcookie($name, $value, $expire, $path, $domain, $secure);
}

////
function zen_get_ip_address() {
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } else {
            $ip = getenv('REMOTE_ADDR');
        }
    }

    return $ip;
}


// nl2br() prior PHP 4.2.0 did not convert linefeeds on all OSs (it only converted \n)
function zen_convert_linefeeds($from, $to, $string) {
    if ((PHP_VERSION < "4.0.5") && is_array($from)) {
        return preg_replace('/(' . implode('|', $from) . ')/', $to, $string);
    } else {
        return str_replace($from, $to, $string);
    }
}

function validate_for_product($product_id, $coupon_id) {
    global $db;
    $sql = "SELECT * FROM " . TABLE_COUPON_RESTRICT . "
            WHERE product_id = " . (int)$product_id . "
            AND coupon_id = " . (int)$coupon_id . " LIMIT 1";
    $result = $db->execute($sql);
    if ($result->recordCount() > 0) {
        if ($result->fields['coupon_restrict'] == 'N') return true;
        if ($result->fields['coupon_restrict'] == 'Y') return false;
    } else {
        return 'none';
    }
}

////
function zen_db_input($string) {
    return addslashes($string);
}

function zen_db_output_new($string) {
    $string = htmlspecialchars($string);
    $string = preg_replace('/(?<= ) /', '&nbsp;', $string);
    $string = nl2br($string);
    return $string;
}

////
function zen_db_prepare_input($string) {
    if (is_string($string)) {
        return trim(zen_sanitize_string(stripslashes($string)));
    } elseif (is_array($string)) {
        reset($string);
        while (list($key, $value) = each($string)) {
            $string[$key] = zen_db_prepare_input($value);
        }
        return $string;
    } else {
        return $string;
    }
}

////
function zen_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    global $db;
    reset($data);
    if (strtolower($action) == 'insert') {
        $query = 'INSERT INTO ' . $table . ' (';
        while (list($columns, ) = each($data)) {
            $query .= $columns . ', ';
        }
        $query = substr($query, 0, -2) . ') VALUES (';
        reset($data);
        while (list(, $value) = each($data)) {
            switch ((string)$value) {
                case 'now()':
                    $query .= 'now(), ';
                    break;
                case 'null':
                    $query .= 'null, ';
                    break;
                default:
                    $query .= '\'' . zen_db_input($value) . '\', ';
                    break;
            }
        }
        $query = substr($query, 0, -2) . ')';
    } elseif (strtolower($action) == 'update') {
        $query = 'UPDATE ' . $table . ' SET ';
        while (list($columns, $value) = each($data)) {
            switch ((string)$value) {
                case 'now()':
                    $query .= $columns . ' = now(), ';
                    break;
                case 'null':
                    $query .= $columns .= ' = null, ';
                    break;
                default:
                    $query .= $columns . ' = \'' . zen_db_input($value) . '\', ';
                    break;
            }
        }
        $query = substr($query, 0, -2) . ' WHERE ' . $parameters;
    }
    return $db->Execute($query);
}

////
function zen_db_output($string) {
    return htmlspecialchars($string);
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
// return the size and maxlength settings in the form size="blah" maxlength="blah" based on maximum size being 70
// uses $tbl = table name, $fld = field name
// example: zen_set_field_length(TABLE_CATEGORIES_DESCRIPTION, 'categories_name')
function zen_set_field_length($tbl, $fld, $max=70) {
    $field_length= zen_field_length($tbl, $fld);
    switch (true) {
        case ($field_length > $max):
            $length= 'size = "' . ($max+1) . '" maxlength= "' . $field_length . '"';
            break;
        default:
            $length= 'size = "' . ($field_length+1) . '" maxlength = "' . $field_length . '"';
            break;
    }
    return $length;
}


////
// Set back button
function zen_back_link() {
    if (sizeof($_SESSION['navigation']->path)-2 > 0) {
        $back = sizeof($_SESSION['navigation']->path)-2;
        $link = '<a href="' . zen_href_link($_SESSION['navigation']->path[$back]['page'], zen_array_to_string($_SESSION['navigation']->path[$back]['get'], array('action')), $_SESSION['navigation']->path[$back]['mode']) . '">';
    } else {
        if (isset($_SERVER['HTTP_REFERER']) && strstr(HTTP_SERVER, $_SERVER['HTTP_REFERER'])) {
            $link= $_SERVER['HTTP_REFERER'];
        } else {
            $link = '<a href="' . zen_href_link(FILENAME_DEFAULT) . '">';
        }
        $_SESSION['navigation'] = new navigationHistory;
    }
    return $link;
}


////
// Set back link only
function zen_back_link_only($link_only = false) {
    if (sizeof($_SESSION['navigation']->path)-2 > 0) {
        $back = sizeof($_SESSION['navigation']->path)-2;
        $link = zen_href_link($_SESSION['navigation']->path[$back]['page'], zen_array_to_string($_SESSION['navigation']->path[$back]['get'], array('action')), $_SESSION['navigation']->path[$back]['mode']);
    } else {
        if (strstr(HTTP_SERVER, $_SERVER['HTTP_REFERER'])) {
            $link= $_SERVER['HTTP_REFERER'];
        } else {
            $link = zen_href_link(FILENAME_DEFAULT);
        }
        $_SESSION['navigation'] = new navigationHistory;
    }

    if ($link_only == true) {
        return $link;
    } else {
        return '<a href="' . $link . '">';
    }
}

////
// Return a random row from a database query
function zen_random_select($query) {
    global $db;
    $random_product = '';
    $random_query = $db->Execute($query);
    $num_rows = $random_query->RecordCount();
    if ($num_rows > 1) {
        $random_row = zen_rand(0, ($num_rows - 1));
        $random_query->Move($random_row);
    }
    return $random_query;
}


////
// Truncate a string
function zen_trunc_string($str = "", $len = 150, $more = 'true') {
    if ($str == "") return $str;
    if (is_array($str)) return $str;
    $str = trim($str);
    // if it's les than the size given, then return it
    if (strlen($str) <= $len) return $str;
    // else get that size of text
    $str = substr($str, 0, $len);
    // backtrack to the end of a word
    if ($str != "") {
        // check to see if there are any spaces left
        if (!substr_count($str , " ")) {
            if ($more == 'true') $str .= "...";
            return $str;
        }
        // backtrack
        while(strlen($str) && ($str[strlen($str)-1] != " ")) {
            $str = substr($str, 0, -1);
        }
        $str = substr($str, 0, -1);
        if ($more == 'true') $str .= "...";
        if ($more != 'true' and $more != 'false') $str .= $more;
    }
    return $str;
}



////
// set current box id
function zen_get_box_id($box_id) {
    while (strstr($box_id, '_')) $box_id = str_replace('_', '', $box_id);
    $box_id = str_replace('.php', '', $box_id);
    return $box_id;
}


//jessa 2010-01-22 ���¶����������Ŀ����ʹ��products restock
function zen_get_buy_now_button($product_id, $link, $additional_link = false){
    global $db,$page_name,$bool_in_cart,$procuct_qty;

    switch (true){
        case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
            $login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE . '</a>';
            return $login_for_price;
            break;

        case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
            if (TEXT_LOGIN_FOR_PRICE_PRICE == ''){
                return TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE;
            }else{
                $login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE . '</a>';
            }
            return $login_for_price;
            break;

        case (CUSTOMERS_APPROVAL == '3'):
            $login_for_price = TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM;
            return $login_for_price;
            break;

        case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customer_id'] == ''):
            $login_for_price = TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE;
            return $login_for_price;
            break;

        case ((CUSTOMERS_APPROVAL_AUTHORIZATION == '3') and $_SESSION['customer_id'] == ''):
            $login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE . '</a>';
            return $login_for_price;
            break;

        case (CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and $_SESSION['customers_authorization'] > '0'):
            $login_for_price = TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE;
            return $login_for_price;
            break;

        default:
            break;
    }

    if (STORE_STATUS != '0') {
        return '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">' .  TEXT_SHOWCASE_ONLY . '</a>';
    }

    $request_type = (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1' || strstr(strtoupper($_SERVER['HTTP_X_FORWARDED_BY']),'SSL') || strstr(strtoupper($_SERVER['HTTP_X_FORWARDED_HOST']),'SSL'))  ? 'SSL' : 'NONSSL';

    $button_check = new stdClass();
    $button_check->fields = get_products_info_memcache((int)$product_id);
    $button_check->fields['products_quantity'] = zen_get_products_stock($product_id);
    
    switch (true){
        case (zen_get_products_allow_add_to_cart($product_id) == 'N'):
            return $additional_link;
            break;
        case ($button_check->fields['product_is_call'] == '1'):
            $return_button = '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">' . TEXT_CALL_FOR_PRICE . '</a>';
            break;
        case ($button_check->fields['products_quantity'] <= 0 && $button_check->fields['is_sold_out'] == 1 and SHOW_PRODUCTS_SOLD_OUT_IMAGE == '1'):
            if ($_GET['main_page'] == 'product_info'){
                $return_button = '<ul class="product_info_qty_input list"><li>';
                $return_button .= '<span class="soldout_text"><a rel="nofollow"  id="restock_'.$product_id.'" onclick="beforeRestockNotification(' . $product_id . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span><a rel="nofollow" class="icon_soldout" href="javascript:void(0);">' . TEXT_SOLD_OUT. '</a>';
                $return_button .= '<div class="successtips_add successtips_add3"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
                $return_button .= '<a rel="nofollow" class="text btn_addwishlist" href="javascript:void(0);" id="wishlist_' . $product_id . '" name="wishlist_' . $product_id . '" onclick="beforeAddtowishlist(' . $product_id . '); return false;">' . IMAGE_BUTTON_ADD_WISHLIST . '</a>';
                $return_button .= '</li></ul>';
                return $return_button;
            }else{
                $return_button = '<p class="productadd">' . zen_image_button(BUTTON_IMAGE_SOLD_OUT_SMALL, BUTTON_SOLD_OUT_SMALL_ALT);
            }
            $additional_link = false;
            $return_button .= '<br /><a href="' . zen_href_link('product_info', zen_get_all_get_params(array('action')) . 'action=notify&number_of_uploads=0&products_id=' . $product_id, $request_type) . '">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a>';
            if ($_GET['main_page'] != 'product_info'){
                $return_button .= '</p>';
            }
            break;
        case ($button_check->fields['products_quantity'] <= 0 && $button_check->fields['is_sold_out'] == 0 and SHOW_PRODUCTS_SOLD_OUT_IMAGE == '1'):
            if ($_GET['main_page'] == 'product_info'){
                /*
                     $return_button = '<ul class="product_info_qty_input list"><li>';
                    $return_button .= '<div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
                     $return_button .= '<input type="hidden" id="MDO_'.$_GET['products_id'].'"  value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $_GET['products_id'] . '" value="'.$procuct_qty.'" /><span class="soldout_text"><a rel="nofollow" id="restock_'.$product_id.'" onclick="beforeRestockNotification(' . $product_id . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span><a rel="nofollow" class="icon_backorder" id="submitp_' . $product_id . '" onclick="makeSureCart('.$product_id.',4,\''.$page_name.'\',\''.get_backorder_info($product_id).'\')"  href="javascript:void(0);">' . TEXT_BACKORDER . '</a>';
                     $return_button .= '<div class="successtips_add successtips_add3"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
                     $return_button .= '<a rel="nofollow" class="text btn_addwishlist" href="javascript:void(0);" id="wishlist_' . $product_id . '" name="wishlist_' . $product_id . '" onclick="beforeAddtowishlist(' . $product_id . '); return false;">' . IMAGE_BUTTON_ADD_WISHLIST . '</a>';
                     $return_button .= '</li></ul>';
                */
                //return $return_button;

                $button_arr = explode('<div class="clearfix behind_add"></div></div>', $link);
                $return_button = $button_arr[0] . '<div class="clearfix behind_add"></div></div>';
                if($button_check->fields['is_s_level_product'] != 1 ){
                    $return_button .= '<div style="padding:5px; background:#f1f1f1; margin:10px 0 10px 10px;">'.( ($button_check->fields['products_stocking_days'] > 7  ? TEXT_AVAILABLE_IN715 : TEXT_AVAILABLE_IN57)).'</div>';
                }
                $return_button .= $button_arr[1];
                //$return_button = $link.'<div class="clearfix"></div><div style="padding:5px; background:#f1f1f1; margin:10px 0 0 10px;">'.TEXT_AVAILABLE_IN715.'</div>';
                break;
            }else{
                $return_button = '<p class="productadd">' . zen_image_button(BUTTON_IMAGE_SOLD_OUT_SMALL, BUTTON_SOLD_OUT_SMALL_ALT);
            }
            $additional_link = false;
            $return_button .= '<br /><a href="' . zen_href_link('product_info', zen_get_all_get_params(array('action')) . 'action=notify&number_of_uploads=0&products_id=' . $product_id, $request_type) . '">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a>';
            if ($_GET['main_page'] != 'product_info'){
                $return_button .= '</p>';
            }
            break;
        default:
            $return_button = $link;

            break;
    }

    if ($return_button != $link and $additional_link != false){
        return $additional_link . '<br />' . $return_button;
    }else{
        return $return_button;
    }
}
//eof jessa 2010-01-22 �º��������



//jessa 2010-05-03 �����������ڿ������ģʽ��
function zen_get_buy_now_button_quick_view($product_id, $link, $additional_link = false) {
    global $db;
    switch (true) {
        case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
            $login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE . '</a>';
            return $login_for_price;
            break;
        case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
            if (TEXT_LOGIN_FOR_PRICE_PRICE == '') {
                return TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE;
            } else {
                $login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE . '</a>';
            }
            return $login_for_price;
            break;
        case (CUSTOMERS_APPROVAL == '3'):
            $login_for_price = TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM;
            return $login_for_price;
            break;
        case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customer_id'] == ''):
            $login_for_price = TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE;
            return $login_for_price;
            break;
        case ((CUSTOMERS_APPROVAL_AUTHORIZATION == '3') and $_SESSION['customer_id'] == ''):
            $login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE . '</a>';
            return $login_for_price;
            break;
        case (CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and $_SESSION['customers_authorization'] > '0'):
//      customer must be logged in to browse
            $login_for_price = TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE;
            return $login_for_price;
            break;
        default:
//      proceed normally
            break;
    }
//  show case only
    if (STORE_STATUS != '0') {
        return '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">' .  TEXT_SHOWCASE_ONLY . '</a>';
    }
//  robbie wei
    $request_type = (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1' || strstr(strtoupper($_SERVER['HTTP_X_FORWARDED_BY']),'SSL') || strstr(strtoupper($_SERVER['HTTP_X_FORWARDED_HOST']),'SSL'))  ? 'SSL' : 'NONSSL';
//  eof robbie
    $button_check = $db->Execute("select product_is_call from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    $button_check->fields['products_quantity'] = zen_get_products_stock($product_id);
    switch (true) {
//  cannot be added to the cart
        case (zen_get_products_allow_add_to_cart($product_id) == 'N'):
            return $additional_link;
            break;
        case ($button_check->fields['product_is_call'] == '1'):
            $return_button = '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">' . TEXT_CALL_FOR_PRICE . '</a>';
            break;
        case ($button_check->fields['products_quantity'] <= 0 and SHOW_PRODUCTS_SOLD_OUT_IMAGE == '1'):
            $additional_link = false;
            $return_button .= '<br /><a href="' . zen_href_link('product_info', zen_get_all_get_params(array('action')) . 'action=notify&number_of_uploads=0&products_id=' . $product_id, $request_type) . '">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a>';
            break;
        default:
            $return_button = $link;
            break;
    }
    if ($return_button != $link and $additional_link != false) {
        return $additional_link . '<br />' . $return_button;
    } else {
        return $return_button;
    }
}
//eof jessa 2010-05-03


////
// Switch buy now button based on call for price sold out etc.
//  function zen_get_buy_now_button($product_id, $link, $additional_link = false) {
//    global $db;
//
//// show case only superceeds all other settings
//    if (STORE_STATUS != '0') {
//      return '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">' .  TEXT_SHOWCASE_ONLY . '</a>';
//    }
//
//// 0 = normal shopping
//// 1 = Login to shop
//// 2 = Can browse but no prices
//    // verify display of prices
//      switch (true) {
//        case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
//        // customer must be logged in to browse
//        $login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE . '</a>';
//        return $login_for_price;
//        break;
//        case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
//        if (TEXT_LOGIN_FOR_PRICE_PRICE == '') {
//          // show room only
//          return TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE;
//        } else {
//          // customer may browse but no prices
//          $login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE . '</a>';
//        }
//        return $login_for_price;
//        break;
//        // show room only
//        case (CUSTOMERS_APPROVAL == '3'):
//          $login_for_price = TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM;
//          return $login_for_price;
//        break;
//        case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and CUSTOMERS_APPROVAL_AUTHORIZATION != '3') and $_SESSION['customer_id'] == ''):
//        // customer must be logged in to browse
//        $login_for_price = TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE;
//        return $login_for_price;
//        break;
//        case ((CUSTOMERS_APPROVAL_AUTHORIZATION == '3') and $_SESSION['customer_id'] == ''):
//        // customer must be logged in and approved to add to cart
//        $login_for_price = '<a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">' .  TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE . '</a>';
//        return $login_for_price;
//        break;
//        case (CUSTOMERS_APPROVAL_AUTHORIZATION != '0' and $_SESSION['customers_authorization'] > '0'):
//        // customer must be logged in to browse
//        $login_for_price = TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE;
//        return $login_for_price;
//        break;
//        default:
//        // proceed normally
//        break;
//      }
//
//    $button_check = $db->Execute("select product_is_call, products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
//    switch (true) {
//// cannot be added to the cart
//    case (zen_get_products_allow_add_to_cart($product_id) == 'N'):
//      return $additional_link;
//      break;
//    case ($button_check->fields['product_is_call'] == '1'):
//      $return_button = '<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">' . TEXT_CALL_FOR_PRICE . '</a>';
//      break;
//    case ($button_check->fields['products_quantity'] <= 0 and SHOW_PRODUCTS_SOLD_OUT_IMAGE == '1'):
//      if ($_GET['main_page'] == 'product_info') {
//        $return_button = zen_image_button(BUTTON_IMAGE_SOLD_OUT, BUTTON_SOLD_OUT_ALT);
//      } else {
//        $return_button = zen_image_button(BUTTON_IMAGE_SOLD_OUT_SMALL, BUTTON_SOLD_OUT_SMALL_ALT);
//      }
//      break;
//    default:
//      $return_button = $link;
//      break;
//    }
//    if ($return_button != $link and $additional_link != false) {
//      return $additional_link . '<br />' . $return_button;
//    } else {
//      return $return_button;
//    }
//  }


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
        case (($_SESSION['cart']->free_shipping_items() == $check_cart_cnt) and $shipping_module == 'freeshipper'):
            return true;
            break;
        case (($_SESSION['cart']->free_shipping_items() == $check_cart_cnt) and $shipping_module != 'freeshipper'):
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


////
function zen_html_entity_decode($given_html, $quote_style = ENT_QUOTES) {
    $trans_table = array_flip(get_html_translation_table( HTML_SPECIALCHARS, $quote_style ));
    $trans_table['&#39;'] = "'";
    return ( strtr( $given_html, $trans_table ) );
}

////
//CLR 030228 Add function zen_decode_specialchars
// Decode string encoded with htmlspecialchars()
function zen_decode_specialchars($string){
    $string=str_replace('&gt;', '>', $string);
    $string=str_replace('&lt;', '<', $string);
    $string=str_replace('&#039;', "'", $string);
    $string=str_replace('&quot;', "\"", $string);
    $string=str_replace('&amp;', '&', $string);

    return $string;
}

////
// remove common HTML from text for display as paragraph
function zen_clean_html($clean_it, $extraTags = '') {
    if (!is_array($extraTags)) $extraTags = array($extraTags);

    $clean_it = preg_replace('/\r/', ' ', $clean_it);
    $clean_it = preg_replace('/\t/', ' ', $clean_it);
    $clean_it = preg_replace('/\n/', ' ', $clean_it);

    $clean_it= nl2br($clean_it);

// update breaks with a space for text displays in all listings with descriptions
    while (strstr($clean_it, '<br>'))   $clean_it = str_replace('<br>',   ' ', $clean_it);
    while (strstr($clean_it, '<br />')) $clean_it = str_replace('<br />', ' ', $clean_it);
    while (strstr($clean_it, '<br/>'))  $clean_it = str_replace('<br/>',  ' ', $clean_it);
    while (strstr($clean_it, '<p>'))    $clean_it = str_replace('<p>',    ' ', $clean_it);
    while (strstr($clean_it, '</p>'))   $clean_it = str_replace('</p>',   ' ', $clean_it);

// temporary fix more for reviews than anything else
    while (strstr($clean_it, '<span class="smallText">')) $clean_it = str_replace('<span class="smallText">', ' ', $clean_it);
    while (strstr($clean_it, '</span>')) $clean_it = str_replace('</span>', ' ', $clean_it);

// clean general and specific tags:
    $taglist = array('strong','b','u','i','em');
    $taglist = array_merge($taglist, (is_array($extraTags) ? $extraTags : array($extraTags)));
    foreach ($taglist as $tofind) {
        if ($tofind != '') $clean_it = preg_replace("/<[\/\!]*?" . $tofind . "[^<>]*?>/si", ' ', $clean_it);
    }

// remove any double-spaces created by cleanups:
    while (strstr($clean_it, '  ')) $clean_it = str_replace('  ', ' ', $clean_it);

// remove other html code to prevent problems on display of text
    $clean_it = strip_tags($clean_it);
    return $clean_it;
}


////
// find module directory
// include template specific immediate /modules files
// new_products, products_new_listing, featured_products, featured_products_listing, product_listing, specials_index, upcoming,
// products_all_listing, products_discount_prices, also_purchased_products
function zen_get_module_directory($check_file, $dir_only = 'false') {
    global $template_dir;

    $zv_filename = $check_file;
    if (!strstr($zv_filename, '.php')) $zv_filename .= '.php';

    if (file_exists(DIR_WS_MODULES . $template_dir . '/' . $zv_filename)) {
        $template_dir_select = $template_dir . '/';
    } else {
        $template_dir_select = '';
    }

    if ($dir_only == 'true') {
        return $template_dir_select;
    } else {
        return $template_dir_select . $zv_filename;
    }
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

// check to see if database stored GET terms are in the URL as $_GET parameters
function zen_check_url_get_terms() {
    global $db;
    return false;
    $zp_sql = "select * from " . TABLE_GET_TERMS_TO_FILTER;
    $zp_filter_terms = $db->Execute($zp_sql);
    $zp_result = false;
    while (!$zp_filter_terms->EOF) {
        if (isset($_GET[$zp_filter_terms->fields['get_term_name']]) && zen_not_null($_GET[$zp_filter_terms->fields['get_term_name']])) $zp_result = true;
        $zp_filter_terms->MoveNext();
    }
    return $zp_result;
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
// return truncated paragraph
function zen_truncate_paragraph($paragraph, $size = 100, $word = ' ') {
    $zv_paragraph = "";
    $word = explode(" ", $paragraph);
    $zv_total = count($word);
    if ($zv_total > $size) {
        for ($x=0; $x < $size; $x++) {
            $zv_paragraph = $zv_paragraph . $word[$x] . " ";
        }
        $zv_paragraph = trim($zv_paragraph);
    } else {
        $zv_paragraph = trim($paragraph);
    }
    return $zv_paragraph;
}



/**
 * return an array with zones defined for the specified country
 */
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

/**
 * return an array with country names and matching zones to be used in pulldown menus
 */
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

/**
 * supplies javascript to dynamically update the states/provinces list when the country is changed
 * TABLES: zones
 *
 * return string
 */
function zen_js_zone_list($country, $form, $field) {
    global $db;
    $countries = $db->Execute("select distinct zone_country_id
                               from " . TABLE_ZONES . "
                               order by zone_country_id");
    $num_country = 1;
    $output_string = '';
    while (!$countries->EOF) {
        if ($num_country == 1) {
            $output_string .= '  if (' . $country . ' == "' . $countries->fields['zone_country_id'] . '") {' . "\n";
        } else {
            $output_string .= '  } else if (' . $country . ' == "' . $countries->fields['zone_country_id'] . '") {' . "\n";
        }

        $states = $db->Execute("select zone_name, zone_id
                              from " . TABLE_ZONES . "
                              where zone_country_id = '" . $countries->fields['zone_country_id'] . "'
                              order by zone_name");
        $num_state = 1;
        while (!$states->EOF) {
            if ($num_state == '1') $output_string .= '    ' . $form . '.' . $field . '.options[0] = new Option("' . PLEASE_SELECT . '", "");' . "\n";
            $output_string .= '    ' . $form . '.' . $field . '.options[' . $num_state . '] = new Option("' . $states->fields['zone_name'] . '", "' . $states->fields['zone_id'] . '");' . "\n";
            $num_state++;
            $states->MoveNext();
        }
        $num_country++;
        $countries->MoveNext();
        $output_string .= '    hideStateField(' . $form . ');' . "\n" ;
    }
    $output_string .= '  } else {' . "\n" .
        '    ' . $form . '.' . $field . '.options[0] = new Option("' . TYPE_BELOW . '", "");' . "\n" .
        '    showStateField(' . $form . ');' . "\n" .
        '  }' . "\n";
    return $output_string;
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


/**
 * strip out accented characters to reasonable approximations of english equivalents
 */
function replace_accents($s) {
    $s = htmlentities($s);
    $s = preg_replace ('/&([a-zA-Z])(uml|acute|elig|grave|circ|tilde|cedil|ring|quest|slash|caron);/', '$1', $s);
    $s = html_entity_decode($s);
    return $s;
}

/**
 * function to override PHP's is_writable() which can occasionally be unreliable due to O/S and F/S differences
 * attempts to open the specified file for writing. Returns true if successful, false if not.
 * if a directory is specified, uses PHP's is_writable() anyway
 *
 * @var string
 * @return boolean
 */
function is__writeable($filepath) {
    if (is_dir($filepath)) return is_writable($filepath);
    $fp = @fopen($filepath, 'a');
    if ($fp) {
        @fclose($fp);
        return true;
    }
    return false;
}

function zen_get_order_status($order_id){
    global $db;
    $order_status_name = '';
    $order_status_query = "Select orders_status_name
  							 From " . TABLE_ORDERS . " o, " . TABLE_ORDERS_STATUS . " os
  							Where o.orders_id = " . (int)$order_id . "
  							  And o.orders_status = os.orders_status_id";
    $order_status = $db->Execute($order_status_query);
    $order_status_name = $order_status->fields['orders_status_name'];

    return $order_status_name;
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

function zen_get_customer_info($customer_id){
    global $db;
    $customer_info_query = "Select customers_firstname, customers_lastname, customers_email_address
  							  From " . TABLE_CUSTOMERS . "
  							 Where customers_id = " . (int)$customer_id;
    $customer_info = $db->Execute($customer_info_query);

    $customer_info_array = array();
    if ($customer_info->RecordCount() > 0){
        $customer_info_array = array('name' => stripslashes($customer_info->fields['customers_firstname']) . ' ' . stripslashes($customer_info->fields['customers_lastname']),
            'email' => stripslashes($customer_info->fields['customers_email_address']),
            'lname' => $customer_info->fields['customers_lastname']);

    }

    return $customer_info_array;
}
/**
 * �Զ��庯��,���ڻ�ÿͻ�������Ϣ
 */
function zen_get_testimonial_info($id){
    global $db;


    $testimonial_query = "Select tm_content, tm_customer_id, tm_customer_email,
  								 tm_customer_name, tm_date_added, tm_status, tm_reply, customers_info_avatar
  							From " . TABLE_TESTIMONIAL . " t left join  ".TABLE_CUSTOMERS_INFO." ci on t.tm_customer_id=ci.customers_info_id
  						   Where tm_id = " . (int)$id . " 
  						Order By tm_date_added Desc";
    $testimonial = $db->Execute($testimonial_query);


    $testimonial_array = array();
    if ($testimonial->RecordCount() > 0){
        $customer_id = stripslashes($testimonial->fields['tm_customer_id']);
        $content = stripslashes($testimonial->fields['tm_content']);
        $email = stripslashes($testimonial->fields['tm_customer_email']);
        $name = stripslashes($testimonial->fields['tm_customer_name']);
        $date_added = stripslashes($testimonial->fields['tm_date_added']);
        $status = stripslashes($testimonial->fields['tm_status']);
        $reply = stripslashes($testimonial->fields['tm_reply']);
        $avatar=stripslashes($testimonial->fields['customers_info_avatar']);

        if ((int)$customer_id != 0){
            $customer_query = "Select customers_firstname, customers_lastname, customers_email_address
  								 From " . TABLE_CUSTOMERS . "
  								Where customers_id = " . (int)$customer_id;
            $customer = $db->Execute($customer_query);
            $testimonial_array = array('content' => $content,
                'customer_email' => stripslashes($customer->fields['customers_email_address']),
                'customer_name' => stripslashes($customer->fields['customers_firstname']),
                'date_added' => $date_added,
                'status' => $status,
                'reply' => $reply,
                'avatar'=>$avatar ? $avatar : 'Default/8seasons.jpg',
                'customer_id' => $customer_id);
        } else {
            $testimonial_array = array('content' => $content,
                'customer_email' => $email,
                'customer_name' => $name,
                'date_added' => $date_added,
                'status' => $status,
                'reply' => $reply,
                'avatar'=>'Default/8seasons.jpg',
                'customer_id' => '0');
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

//2010-12-10  on
function zen_change_customers_level($al_customers_id, $ai_new_level){
    global $db;

    if (!zen_not_null($al_customers_id) or $al_customers_id == '') return -1;
    if ($ai_new_level == 0) return 0;

    $db->Execute('Update ' . TABLE_CUSTOMERS . '
						Set customers_level = ' . $ai_new_level . '
						Where customers_id = ' . (int)$al_customers_id);

    return $ai_new_level;
}
//eof on
//jessa 2010-08-16 ��ȡĳ����Ʒ��reviews ratingֵ
function zen_get_product_rating($product_id){
    global $db;
    $reviews_query = "select products_id, reviews_rating
  					    from " . TABLE_REVIEWS . "
  					   where products_id = " . (int)$product_id . "
  					     and status = 1";
    $reviews = $db->Execute($reviews_query);

    $reviews_num = $reviews->RecordCount();
    $rating = 0;
    while (!$reviews->EOF){
        $rating = $rating + (int)$reviews->fields['reviews_rating'];
        $reviews->MoveNext();
    }
    if ($reviews_num !=0) {
        $rating = ($rating / $reviews_num);
    }

    return $rating;
}

function zen_get_latest_reviews_text($product_id){
    global $db;
    $reviews_text_query = "select left(rd.reviews_text, 100) as text
  							 from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
  							where r.status = 1
  							  and r.products_id = " . (int)$product_id . "
  							  and r.reviews_id = rd.reviews_id
  						 order by date_added desc
  						    limit 0, 1";
    $reviews_text = $db->Execute($reviews_text_query);
    return $reviews_text->fields['text'];
}
//eof jessa 2010-08-16

function zen_check_static($file_name, $time_limit=1800){
    if(STATIC_SWITCH && file_exists($file_name) && (time()-filemtime($file_name))<$time_limit){
        return true;
    }else{
        return false;
    }
}

//bof for first order customer
function first_order(){
    $_SESSION['has_valid_order'] = zen_customer_has_valid_order();
    $_SESSION['has_first_coupon']=zen_check_first_coupon();
    if ($_SESSION['customer_id'] && !$_SESSION['has_valid_order']){
        return true;
    }else {
        return false;
    }
}
//eof



function get_img_size($src,$width,$height, $watermarkimg = 'watermarkimg_new'){
    $extension = substr($src, strrpos($src , '.'));
    if(strpos($src,"_01") > 0 || strpos($src,"_02") > 0 || strpos($src,"_03") > 0 || strpos($src,"_04") > 0 || strpos($src,"_05") > 0){
        $src = str_replace($extension ,"_".$width.'_'.$height.$extension ,$src);
        $src = str_replace("_01_" ,"B_" ,$src);
        $src = str_replace("_02_" ,"C_" ,$src);
        $src = str_replace("_03_" ,"D_" ,$src);
        $src = str_replace("_04_" ,"E_" ,$src);
        $src = str_replace("_05_" ,"F_" ,$src);
    }else{
        $src = str_replace($extension ,'A_'.$width.'_'.$height.$extension ,$src);
    }

    $src = $watermarkimg . '/'.$src;
    return $src;
}

/**
 *
 * Get total image amount of product
 * @author zhanghongliang 2013-07-31
 * @param int $products_id
 * @return int $image_count
 */
function get_img_count($products_id){
    global $db;
    $image_count=3;

    $image_count_query = $db->Execute("select image_total from ".TABLE_PRODUCTS_IMAGE_COUNT." where products_id='".$products_id."' limit 1");
    if($image_count_query->RecordCount()>0){
        $image_count = $image_count_query->fields['image_total'];
    } else{
        $products_query = $db->Execute("select products_model from ".TABLE_PRODUCTS." where products_id='".$products_id."'");
        $image_count = file_get_contents(HTTP_IMG_SERVER.'count_product_img.php?model='.$products_query->fields['products_model']);
        if($image_count>0){
            $sql_data_array = array(
                'products_id' => (int)$products_id,
                'image_total' => (int)$image_count,
                'last_modify_time' => date('Y-m-d H:i:s')
            );
            zen_db_perform(TABLE_PRODUCTS_IMAGE_COUNT, $sql_data_array);
        }else{
            $image_count=3;
        }
    }
    return $image_count;
}

/**
author wei.liang
return GUID
 **/
function create_guid() {
    $charid = strtoupper(md5(uniqid(mt_rand(), true)));
    $hyphen = chr(45);// "-"
    $uuid = substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12);// ""
    return $uuid;
}


/**
获取是否使用VIP折扣
author wei.liang
return true or false
 **/
function get_with_vip($product_id){
    global $db;
    //if(zen_is_promotion_price_time()){
    if(get_products_promotion_price($product_id)){
        return false;
    }
    //}
    if (zen_show_discount_amount($product_id) > 0) {
        return false;
    }
//   	if(!zen_is_promotion_time()){
//   		return true;
//   	}
    $promotion_discount_query= 'select p.with_vip from '. TABLE_PROMOTION .' p , '. TABLE_PROMOTION_PRODUCTS .' pp where pp.pp_products_id = '. $product_id .' and pp.pp_promotion_id = p.promotion_id and p.promotion_status = 1 and pp.pp_promotion_start_time <= "'. date('Y-m-d H:i:s') .'" and pp.pp_promotion_end_time > "'. date('Y-m-d H:i:s') .'" and pp.pp_is_forbid = 10';
    $promotion_discount= $db->Execute($promotion_discount_query);
    if(isset($promotion_discount->fields['with_vip']) && (int)$promotion_discount->fields['with_vip'] == 0){
        return false;
    }else{
        if(isset($promotion_discount->fields['with_vip']) && (int)$promotion_discount->fields['with_vip'] == 1){
            return true;
        }else{
            return true;
        }

    }
}

function zen_get_wishlist_item_count($customer_id){
    global $db;
    if(!$customer_id) return 0;
    $check_product_wishli_num = $db->Execute("select count(wl_products_id) as wishicount from ".TABLE_WISH." where  wl_customers_id = " . (int)$customer_id." limit 1");
    if(intval($check_product_wishli_num->fields["wishicount"]) > 0){
        $wishlist_num = intval($check_product_wishli_num->fields["wishicount"]);
    }else{
        $wishlist_num = 0;
    }
    return $wishlist_num;
}

/**
 * @author zale
 * @date 2013/02/27
 * @param $next_vip 是否取下一等级的VIP信息
 * @param $vipinfo_data 传进来的VIP信息，不用再查询数据库
 * @return array
 */
function getCustomerVipInfo($next_vip = false, $vipinfo_data = array(), $total_amount = 0){
    global $db, $currencies;
    $ls_customer_group = HEADER_TITLE_NORMAL;
    $li_max_amt = $li_group_percentage = $ls_discount_amount_text = 0;
    $ls_vip_amount = 0;
    $discount = 0;
    $ls_discount_amount = 0;
    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') {
        if ($total_amount < 0){
            $total_amount = 0;
        }elseif ($total_amount == 0){
            $total_amount = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total();
            /*满减活动*/
            if(date('Y-m-d H:i:s') > PROMOTION_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_DISCOUNT_FULL_SET_MINUS_END_TIME){
                if ($total_amount > $currencies->format_cl( 49 )) {
                    $discount = floor($total_amount/$currencies->format_cl( 49 ))*$currencies->format_wei( 4 );
                    $total_amount = $total_amount - $discount;
                }
            }
            /*阶梯式满减活动*/
            if(date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && !$_SESSION['channel']){
                if ($total_amount > $currencies->format_cl( 379 )) {
                    $discount = 25;
                }elseif($total_amount > $currencies->format_cl( 259 )){
                    $discount = 20;
                }elseif($total_amount > $currencies->format_cl( 149 )){
                    $discount = 10;
                }elseif($total_amount > $currencies->format_cl( 49 )){
                    $discount = 5;
                }elseif($total_amount > $currencies->format_cl( 19 )){
                    $discount = 1;
                }else{
                    $discount = 0;
                }
                
                $discount = $currencies->format_cl($discount);
                $total_amount = $total_amount - $discount;
            }
        }
        
        //echo $total_amount;
        $check_channel = get_with_channel();
        if(!empty($vipinfo_data) && isset($vipinfo_data['current']) && !empty($vipinfo_data['current']['group_percentage']) && !$next_vip) {
            $customer_group =  new stdClass();
            $customer_group->fields = $vipinfo_data['current'];
        } else if(!empty($vipinfo_data) && isset($vipinfo_data['next']) && !empty($vipinfo_data['next']['group_percentage']) && $next_vip) {
            $customer_group =  new stdClass();
            $customer_group->fields = $vipinfo_data['next'];
        }else {
            $customer_group = $db->Execute('Select gpd.group_name, gp.group_percentage, gp.max_amt, gp.min_amt
										  From ' . TABLE_GROUP_PRICING . ' gp, ' . TABLE_GROUP_PRICING_DESCRIPTION . ' gpd, ' . TABLE_CUSTOMERS . ' c
										 Where c.customers_group_pricing = gp.group_id' . ($next_vip ? '-1' : '') . '
	  									   and gpd.group_id = gp.group_id
	  									   and gpd.language_id = ' . $_SESSION['languages_id'] . '
										   And c.customers_id = ' . $_SESSION['customer_id']);
        }
        if($check_channel){
            $customer_group->fields['group_percentage'] = 15.00;
        }
        if ($customer_group->RecordCount() != 0 || $check_channel) {
            $ls_customer_group = $customer_group->fields['group_name'];
            $li_group_percentage = $customer_group->fields['group_percentage'];
            $li_max_amt = $next_vip ? $customer_group->fields['min_amt'] : ($customer_group->fields['max_amt'] != 0 ? $customer_group->fields['max_amt'] : 50000);
            $ls_vip_amount = $total_amount * $li_group_percentage / 100;
            if($ls_vip_amount == 0 && $_SESSION['cart']->show_total_new() != $_SESSION['cart']->show_promotion_total()){
                if(zen_customer_is_new()){
                    $ls_discount_amount = 6.01;
                    $ls_discount_amount_text = $currencies->format_cl($ls_discount_amount, true);
                }else{
                    $ls_discount_amount = $total_amount * 3 / 100;
                    $ls_discount_amount_text = $currencies->format_cl($ls_discount_amount, false);
                }
            }
        }elseif ($next_vip){
            $customer_group = $db->Execute('Select gpd.group_name, gp.group_percentage, gp.max_amt, gp.min_amt
									  From ' . TABLE_GROUP_PRICING . ' gp, ' . TABLE_GROUP_PRICING_DESCRIPTION . ' gpd
  									  where gpd.group_id = gp.group_id
  									  and gpd.language_id = ' . $_SESSION['languages_id'] . '
  									  order by gp.group_id limit 1');
            $ls_customer_group = $customer_group->fields['group_name'];
            $li_group_percentage = $customer_group->fields['group_percentage'];
            $li_max_amt = $customer_group->fields['min_amt'];
            $ls_vip_amount = $total_amount * $li_group_percentage / 100;
        }
    }
    return array('customer_group' => $ls_customer_group,
        'group_percentage' => floor($li_group_percentage),
        'max_amt' => round($li_max_amt),
        'amount' => $ls_vip_amount,
        'discount_amount' => $ls_discount_amount_text);

}

//二维数组排序
function array_sort_checkout($arr, $keys, $type = 'asc') {
    $keysvalue = $new_array = array ();
    //$i = 0;
    foreach ( $arr as $k => $v ) {
        $keysvalue [$k] = $v [$keys];
        //$i++;
    }
    if ($type == 'asc') {
        asort ( $keysvalue );
    } else {
        arsort ( $keysvalue );
    }
    reset ( $keysvalue );
    $i = 0;
    foreach ( $keysvalue as $k => $v ) {
        $new_array [$i] = $arr [$k];
        $i++;
    }
    return $new_array;
}

function get_recently_viewed_products($is_index = false){
    global $db;
    $r_products = array();

    if (isset ( $_SESSION ['recent_products'] ) && sizeof($_SESSION ['recent_products']) > 0) {
        $productid_array = array_unique ( array_reverse ( $_SESSION ['recent_products'] ) );
        $recent = array_slice ( $productid_array, 0, 6 );

        $sub_query = " where p.products_id in (";
        $field = "";
        foreach ( $recent as $value ) {
            $sub_query .= "'" . $value . "', ";
            $field .= "'".$value."', ";
        }

        $sub_query = substr ( $sub_query, 0, (strlen ( $sub_query ) - 2) );
        $field = substr ( $field, 0, -2 );
        $sub_query .= ")";
        $recent_products_query = "select p.products_id, p.products_image, pd.products_name, p.is_sold_out, p.products_price, p.products_model, p.products_limit_stock, p.products_status, products_stocking_days
  					from " . TABLE_PRODUCTS . " as p, " . TABLE_PRODUCTS_DESCRIPTION . " as pd " . $sub_query . "
					and pd.language_id = " . $_SESSION ['languages_id'] . "
					and p.products_status != 10
  					and p.products_id = pd.products_id order by field(p.products_id, $field)";
        $recent_products = $db->Execute($recent_products_query);
        if ($recent_products->RecordCount() > 0){
            while (!$recent_products->EOF){
                if($recent_products->fields['products_status']==0){
                    $recent_products->MoveNext();
                    continue;
                }
                $rp_id = $recent_products->fields['products_id'];
                $recent_products->fields['products_quantity'] = zen_get_products_stock($rp_id);
                $rp_image = $recent_products->fields['products_image'];
                $rp_name = $recent_products->fields['products_name'];
                $rp_qty = $recent_products->fields['products_quantity'];
                $model = $recent_products->fields['products_model'];
                $discount_amount = zen_show_discount_amount ( $rp_id );
                $product_name = htmlspecialchars ( zen_clean_html ( $rp_name ) );
                $product_link = zen_href_link ( FILENAME_PRODUCT_INFO, 'products_id=' . $rp_id );
                if ($is_index ==false){
                    $product_image = (IMAGE_SHOPPING_CART_STATUS == 1 ? '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="' . HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $rp_image, 130, 130 ) . '" alt="' . $product_name . '">' : '');
                }else {
                    $product_image = (IMAGE_SHOPPING_CART_STATUS == 1 ? '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $rp_image, 80, 80 ) . '" alt="' . $product_name . '">' : '');
                }
                $unit_price = zen_get_unit_price($rp_id);
                if($_SESSION['languages_id']==3 && $_SESSION['currency']=='RUB' && $unit_price!=''){
                    $rp_display_price = $unit_price;
                }else{
                    $rp_display_price = zen_get_products_display_price_new($rp_id, 'recent');
                }

                if($recent_products->fields['is_sold_out']==1){
                    $btn_class = ($rp_qty <= 0 ? 'icon_soldout' :'cartbuy rp_btn');
                }else{
                    $btn_class = ($rp_qty <= 0 ? 'icon_backorder' :'cartbuy rp_btn');
                }

                $result= array (
                    'lang'=>$_SESSION['languages_id'],
                    'product_link' => $product_link,
                    'product_image' => $product_image,
                    'product_name' => getstrbylength ( $product_name, 28 ),
                    'product_name_all' => $product_name,
                    'product_id' => $rp_id,
                    'display_price' => $rp_display_price,
                    'discount' => $discount_amount,
                    'btn_class' => $btn_class,
                    'product_qty' => $rp_qty,
                    'product_cart_qty' => 1
                );

                $r_products [] = array_merge($recent_products->fields,$result);

                $recent_products->MoveNext();
            }
        }
    }
    return $r_products;
}

/**
 * @param bool $is_index
 * @return array
 */
function get_recently_viewed_lazy_products($is_index = false){
    global $db;
    $r_products = array();

    if (isset ( $_SESSION ['recent_products'] ) && sizeof($_SESSION ['recent_products']) > 0) {
        $productid_array = array_unique ( array_reverse ( $_SESSION ['recent_products'] ) );
        $recent = array_slice ( $productid_array, 0, 6 );

        $sub_query = " where p.products_id in (";
        $field = "";
        foreach ( $recent as $value ) {
            $sub_query .= "'" . $value . "', ";
            $field .= "'".$value."', ";
        }

        $sub_query = substr ( $sub_query, 0, (strlen ( $sub_query ) - 2) );
        $field = substr ( $field, 0, -2 );
        $sub_query .= ")";
        $recent_products_query = "select p.products_id, p.products_image, pd.products_name, p.is_sold_out, p.products_price, p.products_model, p.products_limit_stock, p.products_status, products_stocking_days
  					from " . TABLE_PRODUCTS . " as p, " . TABLE_PRODUCTS_DESCRIPTION . " as pd " . $sub_query . "
					and pd.language_id = " . $_SESSION ['languages_id'] . "
					and p.products_status != 10
  					and p.products_id = pd.products_id order by field(p.products_id, $field)";
        $recent_products = $db->Execute($recent_products_query);
        if ($recent_products->RecordCount() > 0){
            while (!$recent_products->EOF){
                if($recent_products->fields['products_status']==0){
                    $recent_products->MoveNext();
                    continue;
                }
                $rp_id = $recent_products->fields['products_id'];
                $recent_products->fields['products_quantity'] = zen_get_products_stock($rp_id);
                $rp_image = $recent_products->fields['products_image'];
                $rp_name = $recent_products->fields['products_name'];
                $rp_qty = $recent_products->fields['products_quantity'];
                $model = $recent_products->fields['products_model'];
                $discount_amount = zen_show_discount_amount ( $rp_id );
                $product_name = htmlspecialchars ( zen_clean_html ( $rp_name ) );
                $product_link = zen_href_link ( FILENAME_PRODUCT_INFO, 'products_id=' . $rp_id );
                if ($is_index ==false){
                    $product_image = (IMAGE_SHOPPING_CART_STATUS == 1 ? '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="' . HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $rp_image, 130, 130 ) . '" alt="' . $product_name . '">' : '');
                }else {
                    $product_image = (IMAGE_SHOPPING_CART_STATUS == 1 ? '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $rp_image, 80, 80 ) . '" alt="' . $product_name . '">' : '');
                }
                $unit_price = zen_get_unit_price($rp_id);
                if($_SESSION['languages_id']==3 && $_SESSION['currency']=='RUB' && $unit_price!=''){
                    $rp_display_price = $unit_price;
                }else{
                    $rp_display_price = zen_get_products_display_price_new($rp_id, 'recent');
                }

                if($recent_products->fields['is_sold_out']==1){
                    $btn_class = ($rp_qty <= 0 ? 'icon_soldout' :'cartbuy rp_btn');
                }else{
                    $btn_class = ($rp_qty <= 0 ? 'icon_backorder' :'cartbuy rp_btn');
                }

                $result= array (
                    'lang'=>$_SESSION['languages_id'],
                    'product_link' => $product_link,
                    'product_image' => $product_image,
                    'product_name' => getstrbylength ( $product_name, 28 ),
                    'product_name_all' => $product_name,
                    'product_id' => $rp_id,
                    'display_price' => $rp_display_price,
                    'discount' => $discount_amount,
                    'btn_class' => $btn_class,
                    'product_qty' => $rp_qty,
                    'product_cart_qty' => 1
                );

                $r_products [] = array_merge($recent_products->fields,$result);

                $recent_products->MoveNext();
            }
        }
    }
    return $r_products;
}

function get_new_arrival_products(){
    $solr = new Apache_Solr_service(SOLR_HOST, SOLR_PORT, '/solr/dorabeads_' . $_SESSION['languages_code']);

    $extra_select_str ='is_new:1 and new_arrivals_display:10';
    $solr_select_query = $extra_select_str;

    $solr_order_str = "products_ordered desc, products_quantity desc, products_date_added desc";
    $condition['sort'] = $solr_order_str;
    $condition['facet'] = 'true';
    $condition['facet.mincount'] = '1';
    $condition['facet.limit'] = '-1';
    $condition['facet.field'] = 'properties_id';
    $condition['f.properties_id.facet.missing'] = 'true';
    $condition['f.properties_id.facet.method'] = 'enum';

    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) {
        $products_display_solr_str = '';
    } else {
        $products_display_solr_str = ' AND is_display:1';
    }
    $solr_select_query .= $products_display_solr_str;

    $count_res = $solr->search($solr_select_query, 0, 6 ,$condition);
    $num_products_count = $count_res->response->numFound;
//    $products_new_split = new splitPageResults('', 15, '', 'page',false,$num_products_count);
//    $properties_facet = $count_res->facet_counts->facet_fields->properties_id;

    $product_all = $count_res->response->docs;
    $display_product_cnt = 0;
    foreach($product_all as $prod_val){
        $display_products_array[$prod_val->products_id] = $prod_val->products_id;
        $display_product_cnt++;
    }

    foreach ($display_products_array as $rp_id) {
        $products_info = get_products_info_memcache($rp_id);
        if(!is_array($products_info) || empty($products_info)){
            continue;
        }
        $products_name = get_products_description_memcache($rp_id, (int) $_SESSION['languages_id']);
        $products_info['products_quantity'] = zen_get_products_stock($rp_id);
        $rp_image = $products_info['products_image'];
        $rp_name = $products_name;
        $rp_qty = $products_info['products_quantity'];
//        $model = $products_info['products_model'];
        $discount_amount = zen_show_discount_amount ( $rp_id );
        $product_name = htmlspecialchars ( zen_clean_html ( $rp_name ) );
        $product_link = zen_href_link ( FILENAME_PRODUCT_INFO, 'products_id=' . $rp_id );
//        if ($is_index ==false){
            $product_image = (IMAGE_SHOPPING_CART_STATUS == 1 ? '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="' . HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $rp_image, 130, 130 ) . '" alt="' . $product_name . '">' : '');
//        }else {
//            $product_image = (IMAGE_SHOPPING_CART_STATUS == 1 ? '<img src="' . HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $rp_image, 80, 80 ) . '" alt="' . $product_name . '">' : '');
//        }
        $unit_price = zen_get_unit_price($rp_id);
        if($_SESSION['languages_id']==3 && $_SESSION['currency']=='RUB' && $unit_price!=''){
            $rp_display_price = $unit_price;
        }else{
            $rp_display_price = zen_get_products_display_price_new($rp_id, 'recent');
        }

        if($products_info['is_sold_out']==1){
            $btn_class = ($rp_qty <= 0 ? 'icon_soldout' :'cartbuy rp_btn');
        }else{
            $btn_class = ($rp_qty <= 0 ? 'icon_backorder' :'cartbuy rp_btn');
        }

        $result= array (
            'lang'=>$_SESSION['languages_id'],
            'product_link' => $product_link,
            'product_image' => $product_image,
            'product_name' => getstrbylength ( $product_name, 28 ),
            'product_name_all' => $product_name,
            'product_id' => $rp_id,
            'display_price' => $rp_display_price,
            'discount' => $discount_amount,
            'btn_class' => $btn_class,
            'product_qty' => $rp_qty,
            'product_cart_qty' => 1
        );

        $r_products [] = array_merge($products_info,$result);
    }

    return $r_products;
}
//   function zen_is_promotion_price_time(){
//   	if(time()>=strtotime(SHOW_PROMOTION_PRICE_START_TIME)&&time()<strtotime(SHOW_PROMOTION_PRICE_END_TIME)){
//   		return true;
//   	}else{
//   		return false;
//   	}
//   }

function get_products_promotion_price($products_id){
    $promotion_price = get_daily_deal_price_by_products_id($products_id);
    /*
    $promotion_price = false;
    if ( zen_not_null($products_id) ) {
        $sql_date=$db->Execute("SELECT products_id
                              FROM ".TABLE_DAILYDEAL_PROMOTION." dp
                              WHERE  dp.dailydeal_products_start_date <=  '". date('Y-m-d H:i:s') ."'
                               AND dp.dailydeal_products_end_date >  '". date('Y-m-d H:i:s') ."'
                              AND dp.dailydeal_is_forbid =10
                                AND dp.products_id = " . $products_id . "
                              ORDER BY dp.dailydeal_products_end_date ASC");
        if ($sql_date->RecordCount() > 0) {
            $promotion_price = true;
        }
    }
    */
    return $promotion_price;
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

function check_default_address_phone(){
    global $db;
    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != ''){
        $check = $db->Execute('select ab.entry_telephone from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_ADDRESS_BOOK . ' ab where c.customers_id = ' . $_SESSION['customer_id'] . ' and c.customers_id = ab.customers_id and c.customers_default_address_id = ab.address_book_id');
        if ($check->RecordCount() > 0){
            if (zen_not_null($check->fields['entry_telephone'])){
                return true;
            }
        }
    }
    return false;
}

/**
获取是否是渠道商客户
author wei.liang
return true or false
 **/
function get_with_channel(){
    global $db;
    //Tianwen.Wan20141113优化重复查询zen_customers
    if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '') {
        //$channel = $db->Execute("select c.customers_id from ".TABLE_CHANNEL." cn ,".TABLE_CUSTOMERS." c where c.customers_id = cn.channel_customers_id and  cn.channel_customers_id = " . $_SESSION ['customer_id'] . "");
        //Tianwen.Wan20141113优化重复查询->只需要查询一张表即可
        $channel = $db->Execute("select cn.channel_customers_id from ".TABLE_CHANNEL." cn where cn.channel_customers_id = " . $_SESSION ['customer_id'] . " and channel_status in (10 , 20)");
        if ($channel->RecordCount () > 0) {
            return true;
        }else{
            return false;
        }
    }
    return false;
}

/**
获取有效的coupon列表(具体金额)
return array
 **/
function get_coupon_select($is_mobilesite = false){
    global $db,$order,$currencies,$order_totals;
    $coupon_select = array();
    if (!isset ( $_SESSION ['customer_id'] ) || $_SESSION ['customer_id'] == ''){
        return $coupon_select;
    }
    if($is_mobilesite){
        $coupon = $db->Execute('select cc.cc_id, coupon_id, coupon_type, coupon_code, coupon_amount, coupon_currency_code, coupon_minimum_order,minimum_order_currency_code, coupon_start_date, coupon_expire_date, uses_per_user, cp.date_created,coupon_usage,with_promotion,cc.cc_coupon_start_time,cc.cc_coupon_end_time from '.TABLE_COUPONS.' cp ,'.TABLE_COUPON_CUSTOMER.' cc where cc.cc_customers_id = ' . $_SESSION ['customer_id'] . ' and cc.cc_coupon_status=10 and cp.coupon_active = "Y"  and cp.coupon_id = cc.cc_coupon_id order by coupon_amount desc');
        $promotion_total = 0;
        for ($j = 0, $m = sizeof($order->products); $j < $m; $j++){
            if(get_with_vip($order->products[$j]['id'])){
            }else{
                $promotion_total += round(($currencies->format_cl(zen_add_tax($order->products[$j]['final_price'], $order->products[$j]['tax']),false) * $order->products[$j]['qty']),2);
            }
        }
        
        if ($coupon->RecordCount () > 0) {
            $coupon_array = array();
            while (!$coupon->EOF){
                $conpon_value=number_format($coupon->fields['coupon_amount'],2) . '%&nbsp;off';
                if($coupon->fields['coupon_type']=='P'){
                    $conpon_value=number_format($coupon->fields['coupon_amount'],2) . '%&nbsp;off';
                }elseif($coupon->fields['coupon_type']=='F'){
                    $conpon_value=$currencies->format($coupon->fields['coupon_amount']);
                }elseif($coupon->fields['coupon_type']=='C'){
                    $conpon_value=$currencies->format($coupon->fields['coupon_amount']);
                }
                if($coupon->fields['coupon_type'] == 'C'){
                    if($coupon->fields['cc_coupon_start_time'] <= date('Y-m-d H:i:s') && $coupon->fields['cc_coupon_end_time'] > date('Y-m-d H:i:s')) {
                        $coupon_end_time_original=$coupon->fields['cc_coupon_end_time'];
                    }else{
                        $coupon->MoveNext();
                        continue;
                    }
                }else{
                    if($coupon->fields['coupon_start_date'] <= date('Y-m-d H:i:s') && $coupon->fields['coupon_expire_date'] > date('Y-m-d H:i:s')) {
                        $coupon_end_time_original=$coupon->fields['coupon_end_time'];
                    }else{
                        $coupon->MoveNext();
                        continue;
                    }
                }
                
                $deadlinetimeformat=$coupon_end_time != '0000-00-00 00:00:00' ? $coupon_end_time_original : '';
                
                if((in_array($coupon->fields['coupon_code'], array('CP2014040901','CP2014040902','CP2014040903')))){
                    $order_coupon = $db->Execute("select cc_orders_id from " . TABLE_COUPON_CUSTOMER . " where  cc_customers_id =  ".$_SESSION['customer_id']." and cc_coupon_id = ".$coupon->fields['coupon_id']."");
                    
                    if($order_coupon->RecordCount() > 0 && !isset($coupon_array[$order_coupon->fields['cc_orders_id']])){
                        $coupon_array[$order_coupon->fields['cc_orders_id']] = $order_coupon->RecordCount();
                    }
                    
                    $promotion = 0;
                }else{
                    $promotion = $promotion_total;
                }
                if($coupon->fields['with_promotion']==1){
                    $promotion = 0;
                }
                if($order->info['currency'] != $coupon->fields['minimum_order_currency_code']){
                    $coupon->fields['coupon_minimum_order'] = zen_change_currency($coupon->fields['coupon_minimum_order'],$coupon->fields['minimum_order_currency_code'],'USD');
                    
                    $coupon->fields['coupon_minimum_order'] = $currencies->format_cl($coupon->fields['coupon_minimum_order'], true, 'USD');
                    
                }
                $coupon->fields['coupon_minimum_order_str'] = $currencies->format($coupon->fields['coupon_minimum_order']);
                
                if(($order_totals - $promotion) >= $coupon->fields['coupon_minimum_order']){
                    $coupon_select [$coupon->fields['coupon_id']]= array('coupon_id' => $coupon->fields['coupon_id'],
                        'coupon_type' => $coupon->fields['coupon_type'],
                        'coupon_amount' => $conpon_value,
                        'coupon_minimum_order' => $coupon->fields['coupon_minimum_order'],
                        'coupon_minimum_order_str'=>$coupon->fields['coupon_minimum_order_str'],
                        'coupon_code'=>$coupon->fields['coupon_code'],
                        'coupou_create_time'=>$coupon->fields['coupou_create_time'],
                        'deadlineformat'=>date('d/m/Y', strtotime($deadlinetimeformat)),
                        'coupon_expire_date'=>$coupon->fields['coupon_expire_date'],
                        'coupon_currency_code'=>$coupon->fields['coupon_currency_code'],
                        'coupon_to_customer_id'=>$coupon->fields['cc_id'],
                        'coupon_start_time_format' => date('d/m/Y', strtotime($coupon->fields['cc_coupon_start_time']))
                    );
                    if(in_array( $_SESSION['languages_id'], array(1,2,4,5))){
                        $coupon_select [$coupon->fields['coupon_id']]['coupon_description'] = sprintf(TEXT_DISCOUNT_COUPON_DESC, $conpon_value ,$coupon->fields['coupon_minimum_order_str']);
                    }else{
                        $coupon_select [$coupon->fields['coupon_id']]['coupon_description'] = sprintf(TEXT_DISCOUNT_COUPON_DESC, $coupon->fields['coupon_minimum_order_str'], $conpon_value );
                    }
                }else{
                    $coupon_unselect[$coupon->fields['coupon_id']] = array('coupon_id' => $coupon->fields['coupon_id'],
                        'coupon_type' => $coupon->fields['coupon_type'],
                        'coupon_amount' => $conpon_value,
                        'coupon_minimum_order' => $coupon->fields['coupon_minimum_order'],
                        'coupon_minimum_order_str'=>$coupon->fields['coupon_minimum_order_str'],
                        'coupon_code'=>$coupon->fields['coupon_code'],
                        'coupou_create_time'=>$coupon->fields['coupou_create_time'],
                        'deadlineformat'=>date('d/m/Y', strtotime($deadlinetimeformat)),
                        'coupon_expire_date'=>$coupon->fields['coupon_expire_date'],
                        'coupon_currency_code'=>$coupon->fields['coupon_currency_code'],
                        'coupon_to_customer_id'=>$coupon->fields['cc_id'],
                        'coupon_start_time_format' => date('d/m/Y', strtotime($coupon->fields['cc_coupon_start_time']))
                    );
                    if(in_array( $_SESSION['languages_id'], array(1,2,4,5))){
                        $coupon_unselect [$coupon->fields['coupon_id']]['coupon_description'] = sprintf(TEXT_DISCOUNT_COUPON_DESC, $conpon_value ,$coupon->fields['coupon_minimum_order_str']);
                    }else{
                        $coupon_unselect [$coupon->fields['coupon_id']]['coupon_description'] = sprintf(TEXT_DISCOUNT_COUPON_DESC, $coupon->fields['coupon_minimum_order_str'], $conpon_value );
                    }
                }
                
                $coupon->MoveNext();
            }
        }
        $return_array = array('coupon_select' => $coupon_select, 'coupon_unselect' => $coupon_unselect);
        return $return_array;
    }else{
        if (!isset ( $_SESSION ['customer_id'] ) || $_SESSION ['customer_id'] == '')
            return $coupon_select;
            
            $coupon = $db->Execute('select cc.cc_id, coupon_id, coupon_type, coupon_code, coupon_amount, coupon_currency_code, coupon_minimum_order,minimum_order_currency_code, coupon_start_date, coupon_expire_date, uses_per_user, cp.date_created,coupon_usage,with_promotion,cc.cc_coupon_start_time,cc.cc_coupon_end_time from '.TABLE_COUPONS.' cp ,'.TABLE_COUPON_CUSTOMER.' cc where cc.cc_customers_id = ' . $_SESSION ['customer_id'] . ' and cc.cc_coupon_status=10 and cp.coupon_active = "Y"  and cp.coupon_id = cc.cc_coupon_id order by coupon_amount desc');
            $promotion_total = 0;
            for ($j = 0, $m = sizeof($order->products); $j < $m; $j++){
                if(get_with_vip($order->products[$j]['id'])){
                }else{
                    $promotion_total += round(($currencies->format_cl(zen_add_tax($order->products[$j]['final_price'], $order->products[$j]['tax']),false) * $order->products[$j]['qty']),2);
                }
            }
            
            if ($coupon->RecordCount () > 0) {
                $coupon_use_array = array();
                $coupon_array = array();
                while (!$coupon->EOF){
                    if($coupon->fields['coupon_type'] == 'C'){
                        if($coupon->fields['cc_coupon_start_time'] <= date('Y-m-d H:i:s') && $coupon->fields['cc_coupon_end_time'] > date('Y-m-d H:i:s')) {
                        }else{
                            $coupon->MoveNext();
                            continue;
                        }
                    }else{
                        if($coupon->fields['coupon_start_date'] <= date('Y-m-d H:i:s') && $coupon->fields['coupon_expire_date'] > date('Y-m-d H:i:s')) {
                            
                        }else{
                            $coupon->MoveNext();
                            continue;
                        }
                    }
                    
                    if((in_array($coupon->fields['coupon_code'], array('CP2014040901','CP2014040902','CP2014040903')))){
                        $order_coupon = $db->Execute("select cc_orders_id from " . TABLE_COUPON_CUSTOMER . " where  cc_customers_id =  ".$_SESSION['customer_id']." and cc_coupon_id = ".$coupon->fields['coupon_id']."");
                        
                        if($order_coupon->RecordCount() > 0 && !isset($coupon_array[$order_coupon->fields['cc_orders_id']])){
                            $coupon_array[$order_coupon->fields['cc_orders_id']] = $order_coupon->RecordCount();
                        }
                        
                        $promotion = 0;
                    }else{
                        $promotion = $promotion_total;
                    }
                    if($coupon->fields['with_promotion']==1){
                        $promotion = 0;
                    }
                    if($order->info['currency'] != $coupon->fields['minimum_order_currency_code']){
                        $coupon->fields['coupon_minimum_order'] = zen_change_currency($coupon->fields['coupon_minimum_order'],$coupon->fields['minimum_order_currency_code'],'USD');
                        
                        $coupon->fields['coupon_minimum_order'] = $currencies->format_cl($coupon->fields['coupon_minimum_order'], true, 'USD');
                        
                    }
                    
                    if($order_totals - $promotion >= $coupon->fields['coupon_minimum_order']){
                        $include = true;
                        if ($coupon->fields['coupon_usage'] == 'ru_only') {
                            if ($_SESSION['languages_id'] != 3) {
                                $include = false;
                            }
                        }
                        if ($include) {
                            $coupon_select []= array(
                                'coupon_id' => $coupon->fields['coupon_id'],
                                'coupon_type' => $coupon->fields['coupon_type'],
                                'coupon_amount' => $coupon->fields['coupon_amount'],
                                'coupon_usage' => $coupon->fields['coupon_usage'],
                                'coupon_code'=>$coupon->fields['coupon_code'],
                                'coupou_create_time'=>$coupon->fields['date_created'],
                                'coupon_expire_date'=>$coupon->fields['coupon_expire_date'],
                                'coupon_currency_code'=>$coupon->fields['coupon_currency_code'],
                                'coupon_to_customer_id'=>$coupon->fields['cc_id']
                            );
                        }
                    }
                    
                    $coupon->MoveNext();
                }
            }
            return $coupon_select;
    }
}
/**
获取具体的couppon(具体金额)
return string
 **/
function get_coupon_value($coupon_id){
    global $db,$order,$currencies;
    $coupon_value = 0;
    if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '' && $coupon_id > 0) {
        $coupon = $db->Execute('select coupon_id, coupon_type, coupon_amount, coupon_start_date,coupon_expire_date, uses_per_user,with_promotion,cc.cc_coupon_start_time,cc.cc_coupon_end_time from '.TABLE_COUPONS.' cp ,'.TABLE_COUPON_CUSTOMER.' cc where cc.cc_customers_id = ' . $_SESSION ['customer_id'] . ' and cp.coupon_active = "Y"  and cp.coupon_id = cc.cc_coupon_id and cp.coupon_id = '.$coupon_id.' order by cc_id desc');
        if ($coupon->RecordCount () > 0) {
            while (!$coupon->EOF) {	//	xiaoyong.lv 20150506 coupon_id取值问题,临时解决方法
                if($coupon->fields['coupon_type'] == "P"){
                    if($coupon->fields['coupon_start_date'] <= date('Y-m-d H:i:s') && $coupon->fields['coupon_expire_date'] > date('Y-m-d H:i:s')) {
                        //	lvxiaoyong 20140217 changge 'subtotal' to 'total'
                        $order_total = $order->info['subtotal'];
                        if($coupon->fields['with_promotion']==0){
                            $order_total = $order->info['subtotal'] - $order->info['promotion_total'];
                        }
                        $coupon_value = round($order_total * ($coupon->fields['coupon_amount'] / 100),2);
                        break;
                    }else{
                        $coupon->MoveNext();
                        continue;
                    }
                }elseif($coupon->fields['coupon_type'] == "F" || $coupon->fields['coupon_type'] == "C"){
                    if($coupon->fields['coupon_type'] == 'C'){
                        if($coupon->fields['cc_coupon_start_time'] <= date('Y-m-d H:i:s') && $coupon->fields['cc_coupon_end_time'] > date('Y-m-d H:i:s')) {

                        }else{
                            $coupon->MoveNext();
                            continue;
                        }
                    }else{
                        if($coupon->fields['coupon_start_date'] <= date('Y-m-d H:i:s') && $coupon->fields['coupon_expire_date'] > date('Y-m-d H:i:s')) {

                        }else{
                            $coupon->MoveNext();
                            continue;
                        }
                    }

                    $coupon_value = $coupon->fields['coupon_amount'];
                    break;
                }
            }
        }
    }
    return $coupon_value;
}

function zen_get_all_get_params_reverse($exclude_array = '', $search_engine_safe = true) {

    if (!is_array($exclude_array)) $exclude_array = array();

    $get_url = '';

    if (is_array($_GET) && (sizeof($_GET) > 0)) {
        reset($_GET);
        $getArr=array_reverse($_GET);
        while (list($key, $value) = each($getArr)) {
            if ( (strlen($value) > 0) && ($key != 'main_page') && ($key != zen_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y') ) {
                if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
                    //	  die ('here');
                    $get_url .= $key . '/' . rawurlencode(stripslashes($value)) . '/';
                } else {
                    $get_url .= $key . '=' . rawurlencode(stripslashes($value)) . '&';
                }
            }
        }
    }
    while (strstr($get_url, '&&')) $get_url = str_replace('&&', '&', $get_url);
    while (strstr($get_url, '&amp;&amp;')) $get_url = str_replace('&amp;&amp;', '&amp;', $get_url);

    return $get_url;
}
function array_sort($arr, $keys, $type = 'asc') {
    $keysvalue = $new_array = array ();
    foreach ( $arr as $k => $v ) {
        $keysvalue [$k] = $v [$keys];
    }
    if ($type == 'asc') {
        asort ( $keysvalue );
    } else {
        arsort ( $keysvalue );
    }
    reset ( $keysvalue );
    foreach ( $keysvalue as $k => $v ) {
        $new_array [$k] = $arr [$k];
    }
    return $new_array;
}

/**
 * check product is avaliable or not for my products page
 * @author zhanghongliang 2013-09-16
 * @param int $customers_id
 * @param int $products_id
 */
function check_my_product($customers_id, $products_id){
    global $db;
    if($customers_id=='' || $products_id=='') return false;
    $check_query = $db->Execute("select myid from ".TABLE_MY_PRODUCTS." where customers_id='".(int)$customers_id."' and products_id='".(int)$products_id."'");
    if($check_query->RecordCount()>0){
        return true;
    }else{
        return false;
    }
}

/**
 * copy from 8seasons
 * @author Tianwen.Wan
 * @param int $products_id
 * @param string $cloumn
 * @return array or string
 */
function get_products_info_memcache($products_id, $cloumn = null) {
    global $db, $memcache;
    $products_id = (int) $products_id;
    if(empty($products_id)) {
        return null;
    }
    $memcache_key = md5(MEMCACHE_PREFIX . 'get_products_info_memcache' . $products_id);
    $data = $memcache->get($memcache_key);

    if($data && sizeof($data) > 0) {
        if(!empty($cloumn) && isset($data[$cloumn])) {
            return $data[$cloumn];
        }
        return $data;
    }
    $sql = 'select p.products_id, p.products_model, p.products_image, p.products_weight, p.is_sold_out, p.products_status, p.products_limit_stock, p.product_is_call, p.products_type, p.products_price_sorter, p.products_tax_class_id, p.products_date_available, master_categories_id,
        p.products_price, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight, p.products_qty_box_status, p.min_unit, p.per_pack_qty, p.products_discount_type, p.products_discount_type_from, p.products_quantity_order_units, p.products_quantity_mixed,
        p.products_date_added, p.products_mixed_discount_quantity, p.products_priced_by_attribute,p.products_is_perorder, p.products_stocking_days,p.is_preorder, p.is_display from ' . TABLE_PRODUCTS . ' p where p.products_id=:products_id';
    $sql = $db->bindVars($sql, ':products_id', $products_id, 'integer');
    $result = $db->Execute($sql);
    $result_return = array();
    if($result->RecordCount() > 0){
        $result_return = $result->fields;

        $the_products_category_query = "select products_id, categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$products_id . "'" . " order by products_id,categories_id";
        $the_products_category = $db->Execute($the_products_category_query);
        $result_return['categories_id'] = $the_products_category->fields['categories_id'];
        
        $low_discount = $db->Execute("select Min(discount_price) as low_discount
								      from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . "
								      Where products_id = '" . (int)$products_id . "'");
        
        if($low_discount->RecordCount() > 0){
            $result_return['low_discount'] = $low_discount->fields['low_discount'];
        }
        
        $products_s_level_sql = 'select auto_id from ' . TABLE_PRODUCTS_S_LEVEL . ' where products_id = :products_id';
        $products_s_level_sql = $db->bindVars($products_s_level_sql, ':products_id', $products_id, 'integer');
        $products_s_level_query = $db->Execute($products_s_level_sql);
        
        if($products_s_level_query->RecordCount() > 0){
            $result_return['is_s_level_product'] = 1;
        }else{
            $result_return['is_s_level_product'] = 0;
        }
    }

    if(is_array($result_return) && sizeof($result_return)>0){
        $memcache->set($memcache_key, $result_return, false, 604800);
    }
    if(!empty($cloumn) && isset($result_return[$cloumn])) {
        return $result_return[$cloumn];
    }
    return $result_return;

}

function get_in_customers_id_memcache($customers_id){
    global $db , $memcache;
    $customers_id = (int) $customers_id;
    if(empty($customers_id)) {
        return null;
    }
    $memcache_key = md5(MEMCACHE_PREFIX . 'get_in_customers_id_memcache' . $customers_id);
    $data = $memcache->get($memcache_key);
    if($data || gettype($data) != 'boolean') {
        return $data;
    }
    $sql = "select customers_dropper_id,in_customers_id from " .TABLE_PROMETERS_IN_CUSTOMERS . " where in_customers_id = " . $customers_id ;
    $result = $db->Execute($sql);
    if($result->RecordCount() > 0){
        $memcache->set($memcache_key, $result, false, 604800);
        return $result;
    }
}
////
// Construct a category path to the product
// TABLES: products_to_categories
function zen_get_product_path($products_id) {
    global $db , $memcache;
    $cPath = '';

    $memcache_key = md5(MEMCACHE_PREFIX . 'get_products_breadcrumb_memcache' . $products_id);
    $data = $memcache->get($memcache_key);

    if($data || gettype($data) != 'boolean') {
        return $data;
    }else{
        $category_id = get_products_info_memcache($products_id, 'master_categories_id');
        $categories = array('is_error' => false , 'categories_arr' => array());

        if($category_id > 0 && $category_id != ''){
            $category_status = get_category_info_memcache($category_id , 'categories_status') == 1 ? true : false;
            if($category_status){
                zen_get_parent_categories_new($categories, $category_id);
            }else{
                $categories['is_error'] = true;
            }
        }else{
            $categories['is_error'] = true;
        }

        if($categories['is_error']){
            $categories = array('is_error' => false , 'categories_arr' => array());
            $product_to_categories_query = "select p2c.categories_id
                             from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                             where p.products_id = '" . (int)$products_id . "'
                             and p.products_status = '1'
                             and p.products_id = p2c.products_id";
            $product_to_categories = $db->Execute($product_to_categories_query);

            if($product_to_categories->RecordCount() > 0){
                while(!$product_to_categories->EOF){
                    $category_status = get_category_info_memcache($product_to_categories->fields['categories_id'] , 'categories_status') == 1 ? true : false;
                    if($category_status){
                        $category_id = $product_to_categories->fields['categories_id'];
                        zen_get_parent_categories_new($categories, $category_id);
                    }else{
                        $categories['is_error'] = true;
                    }

                    if(!$categories['is_error']){
                        break;
                    }else{
                        $categories = array('is_error' => false , 'categories_arr' => array());
                    }

                    $product_to_categories->MoveNext();
                }
            }
        }

        if(!$categories['is_error'] && sizeof($categories['categories_arr']) > 0){
            $categories_arr = array_reverse($categories['categories_arr']);

            $cPath = implode('_', $categories_arr);

            if (zen_not_null($cPath)) {
                $cPath .= '_';
            }

            $cPath .= $category_id;
        }else{
            $cPath = '';
        }

        $memcache->set($memcache_key, $cPath, false, 604800);
        return $cPath;

    }
}

/**
 * copy from 8seasons
 * @author Tianwen.Wan
 * @param int $products_id
 * @param int $language_id
 * @return string
 */
function get_products_description_memcache($products_id, $language_id = 1) {
    global $db, $memcache;
    $products_id = (int) $products_id;
    if(!$products_id) {
        return null;
    }
    $memcache_key = md5(MEMCACHE_PREFIX . 'get_products_description_memcache' . $products_id . $language_id);
    $data = $memcache->get($memcache_key);
    if($data || gettype($data) != 'boolean') {
        return $data;
    }
    $sql = 'select language_id, products_name from ' . TABLE_PRODUCTS_DESCRIPTION . ' where products_id=:products_id';
    $sql = $db->bindVars($sql, ':products_id', $products_id, 'integer');
    $result = $db->Execute($sql);
    $result_return = '';
    if($result->RecordCount() > 0){
        while(!$result->EOF) {
            if($result->fields['language_id'] == $language_id) {
                $result_return = $result->fields['products_name'];
            }
            $result->MoveNext();
        }
    }
    $memcache->set($memcache_key, $result_return, false, 604800);
    return $result_return;
}

/**
 * 通过socket调试php
 * @param string $s
 */
function console($s) {
    /* 指定调试输出的端口， 可以换掉 */
    $service_port = '18889';
    /* 指定本机IP */
    $address = 'localhost';
    /* 停止字符串设置 */
    $s_eof = "END";

    /* 创建一个 TCP/IP socket对象.还是静态的 */
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        return false;
    }
    /* socket连接 */
    $result = socket_connect($socket, $address, $service_port);
    if ($result === false) {
        return false;
    }
    $in = $s . "\n" . $s_eof;
    socket_write($socket, $in, strlen($in));
    socket_close($socket);
}

/**
 * 读取缓存文件
 * @author hongliu 2014-10-24
 * @param string $time_path
 * @param string $filename
 * return false or string $file_str
 */
function file_cache_read($time_path = 30,$filename = ''){
    if(!$filename){
        return false;
    }
    $time_array = array(10,30,60,120,300,600,1440);
    if(!in_array($time_path,$time_array)){
        return false;
    }
    $file = DIR_FILE_CACHE_PATH . $time_path . '/' . $_SESSION['language'] . '/' . $filename;
    if (file_exists($file)){
        $file_str = file_get_contents($file);
        if(strlen($file_str)<=3){
            return false;
        }else{
            return $file_str;
        }
    }
}


/**
 * 写缓存文件
 * @author hongliu 2014-10-24
 * @param string $time_path
 * @param string $filename
 * @param string $str
 * return boolean
 */
function file_cache_write($time_path = 30 , $filename , $str){
    $path = DIR_FILE_CACHE_PATH.$time_path.'/'.$_SESSION['language'];
    $dir ='';
    $dir_array = explode('/',$path);
    foreach($dir_array as $key=>$value){
        if(!file_exists($dir.$value)){
            @mkdir($dir.$value,0777);
        }
        $dir .= $value . '/';
    }
    $time_array = array(10,30,60,120,300,600,1440);
    if(!in_array($time_path,$time_array)){
        return false;
    }
    $file = $path .  '/' . $filename;
    $file = fopen($file, 'wb');
    if(flock($file , LOCK_EX)){
        fwrite($file, $str);
        fclose($file);
        return true;
    }else{
        fclose($file);
        return false;
    }
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
    $memcache->delete(md5(MEMCACHE_PREFIX . 'get_products_breadcrumb_memcache' . $products_id));
    $memcache->delete(md5(MEMCACHE_PREFIX.'products_discount_quantity_modules' . (int)$products_id ));
    $memcache->delete(md5(MEMCACHE_PREFIX.'get_dailydeal_discount_by_products_id' . (int)$products_id ));//清除deals折扣

//	$data = $memcache->get(md5(MEMCACHE_PREFIX.'get_products_package_id_by_other_products_id'.$products_id));
//	if($data){
    $memcache->delete(md5(MEMCACHE_PREFIX.'get_products_package_id_by_products_id' . $data));
//	}
    $memcache->delete(md5(MEMCACHE_PREFIX.'get_products_package_id_by_other_products_id'.$products_id));

    return true;
}

/**
 *
 * get_products_info_description
 * @author hongliu 2015-01-12
 * @param int $products_id
 * @param int $language_id
 * @return string
 */
function get_products_info_description($products_id,$language_id){
    global $db,$memcache;
    $products_id = intval($products_id);
    if(!$products_id){
        return null;
    }
    $memcache_key = md5(MEMCACHE_PREFIX . 'get_products_info_description' . $products_id . $language_id);
    $description = $memcache->get($memcache_key);
    if($description || gettype($description)!='boolean'){
        return $description;
    }
    $description_query = $db->Execute("select products_description from ".TABLE_PRODUCTS_INFO." 
  				where products_id='".(int)$product_id."'
  				and language_id='".(int)$_SESSION['languages_id']."'");
    if($description_query->RecordCount()==0 || trim($description_query->fields['products_description'])==''){
        $description_query = $db->Execute("select products_description from ".TABLE_PRODUCTS_INFO."
  				where products_id='".(int)$product_id."'
  				and language_id=1");
        $memcache->set($memcache_key,$description_query->fields['products_description'],false,86400*7);
    }else{
        $memcache->set($memcache_key,$description_query->fields['products_description'],false,86400*7);
    }
    return $description_query->fields['products_description'];
}

/**
 *
 * get_products_package_id_by_products_id
 * @author hongliu 2015-01-19
 * @param int $products_id
 * return array
 */
function get_products_package_id_by_products_id($products_id){
    global $db,$memcache;

    $products_id = intval($products_id);
    //抗疫产品的缘故临时去掉缓存
//    $memcache_key = md5(MEMCACHE_PREFIX . 'get_products_package_id_by_products_id'.$products_id);
//    $data = $memcache->get($memcache_key);
//    if(is_array($data)){
//        return $data;
//    }
    $products_package_id_sql = 'select other_size_product_id from ' . TABLE_PRODUCTS_PACKAGE_RELATION . ' where main_product_id=' .$products_id .' ORDER BY package_type ASC';
    $products_package_id = $db->Execute($products_package_id_sql);
    $return_array = array();
    while(!$products_package_id->EOF){
        $other_package_id_result = get_products_info_memcache($products_package_id->fields['other_size_product_id']);
        if (!(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) && $other_package_id_result['is_display'] == 0) {
            $products_package_id->MoveNext();
            continue;
        }
        if($other_package_id_result['products_status']){
            $return_array[] = $products_package_id->fields['other_size_product_id'];
//            $other_package_memcache_key = md5(MEMCACHE_PREFIX . 'get_products_package_id_by_other_products_id'.$products_package_id->fields['other_size_product_id']);
//            $memcache->set($other_package_memcache_key,$products_id ,false,604800);
        }
        $products_package_id->MoveNext();
    }
//    $memcache->set($memcache_key,$return_array,false,604800);
    return $return_array;
}
/**
 * WSL
 * get product unit for other package size products
 * @param int $products_id
 * @param int $languages_id
 * @return array( unit_number unit_name)
 */
function get_product_unit_memcache($products_id,$languages_id = 1){
    global $db,$memcache;
    $arr = array();
    if(!$products_id){
        return null;
    }
    $languages_id = $_SESSION['languages_id'];
    $memcache_key = md5(MEMCACHE_PREFIX . 'get_product_unit_other_package_size' . $products_id . $languages_id);
    $get_product_unit_other_package_size = $memcache->get($memcache_key);
    if($get_product_unit_other_package_size || gettype($get_product_unit_other_package_size)!='boolean'){
        return $get_product_unit_other_package_size;
    }
    $sql = 'select distinct products_id, products_unit_id,unit_number from ' . TABLE_PRODUCTS_TO_UNIT . ' where products_id = '. $products_id;
    $result = $db->Execute($sql);

    /*单数为1，复数为2，俄语大于5的复数为5*/
    if ($result->fields['unit_number'] > 1) {
        if($languages_id == 3 && $result->fields['unit_number'] > 5){
            $unit_type = 3;
        }else{
            $unit_type = 2;
        }
    }else{
        $unit_type = 1;
    }
    $sql2 = 'select unit_name from ' . TABLE_PRODUCTS_UNIT_DESCRIPTION . ' where unit_id = ' . intval($result->fields['products_unit_id']) . ' and unit_type = ' . $unit_type . ' and languages_id = ' . $languages_id;
    $result2 = $db->Execute($sql2);
    $arr = array(
        'unit_number' => $result->fields['unit_number'],
        'unit_name'   => $result2->fields['unit_name']
    );
    $memcache->set($memcache_key,$arr,false,86400*30);
    return $arr;
}
/**
 *
 * WSL send register coupon
 * @param int $customer_id
 * @return boolean
 */
function send_register_coupon($customer_id,$coupon_id){
    global $db;
    $sql = "insert into " . TABLE_COUPON_CUSTOMER . "(cc_coupon_id, cc_customers_id, cc_coupon_start_time,`cc_coupon_status`,`date_created`) values( ". $coupon_id .", ". $customer_id .", now(), 10, now())";
    $db->Execute($sql);
    $insert_id = $db->Insert_ID();
    if ($insert_id) {
        return true;
    }else{
        return false;
    }
}

function get_product_related_properties($product_id)
{
    global $db;

    $product_id = intval($product_id);

    if(isset($languages_id) && $languages_id != ''){
        $languages_id = $languages_id;
    }else{
        $languages_id = $_SESSION['languages_id'];
    }

    $sql = 'SELECT  
				ptp.product_id,pg.property_group_id,pg.group_code,pg.group_value,pgd.property_group_name,pg.sort_order,p.property_id,p.property_code,p.property_value,pd.property_name,p.sort_order
			FROM  '.TABLE_PRODUCTS_TO_PROPERTY.' AS ptp
			INNER JOIN '.TABLE_PROPERTY.' AS p ON ptp.property_id = p.property_id 
			INNER JOIN '.TABLE_PROPERTY_GROUP.' AS pg ON ptp.property_group_id = pg.property_group_id
			INNER JOIN '.TABLE_PROPERTY_DESCRIPTION.' AS pd ON pd.property_id = p.property_id AND pd.languages_id = :languages_id
			INNER JOIN '.TABLE_PROPERTY_GROUP_DESCRIPTION.' AS pgd ON pgd.property_group_id = pg.property_group_id AND pgd.languages_id = :languages_id
			WHERE ptp.product_id = :products_id AND p.property_status = 1 AND pg.group_status = 1
			ORDER BY pg.sort_order,p.sort_order';

    $sql = $db->bindVars($sql, ':products_id', $product_id, 'integer');
    $sql = $db->bindVars($sql, ':languages_id', $languages_id, 'integer');

    $result = $db->Execute($sql);
    $result_return = array();
    if($result->RecordCount() > 0){
        while(!$result->EOF) {
            $result_return[] = $result->fields;

            $result->MoveNext();
        }

    }

    return $result_return;
}

function get_product_reviews_by_page($product_id,$smarty,$page = 1,$page_size = 5)
{
    global $db;

    $reviews_query_count = 'select count(r.reviews_id) as count from ' . TABLE_REVIEWS . ' r, ' . TABLE_REVIEWS_DESCRIPTION . ' rd where r.products_id = ' . $product_id. ' and r.reviews_id = rd.reviews_id and r.status = 1';
    $reviews_total_result = $db->Execute ( $reviews_query_count );

    $reviews_count = $reviews_total_result->fields ['count'];
    $reviews_split = new splitPageResults('', $page_size, '', 'page',false,$reviews_count);

    $num_pages = ceil($reviews_count / $page_size);
    if ($page > $num_pages) {
        $page = $num_pages;
    }

    if ($reviews_count && $reviews_count >0)
    {

        $offset = ($page_size * ($page - 1));

        $sql_limit = " limit " . $offset . ", " . $page_size;

        $reviews_query_raw = "SELECT r.reviews_id, rd.reviews_text as reviews_text, r.reviews_rating, r.date_added, r.customers_id, r.customers_name, rd.reviews_reply_text
	                        FROM " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
	                        WHERE r.products_id = :productsId
	                        AND r.reviews_id = rd.reviews_id
	                        AND r.status = 1
	                        ORDER BY r.reviews_id desc".$sql_limit;
        $reviews_query_raw = $db->bindVars ( $reviews_query_raw, ':productsId', $product_id, 'integer' );
        $reviews = $db->Execute ($reviews_query_raw);

        $reviewsArray = array ();
        while ( ! $reviews->EOF ) {
            $customer_info = zen_get_customers_info ( $reviews->fields ['customers_id'] );
            $nameArray = explode ( " ", $reviews->fields ['customers_name'] );
            array_pop ( $nameArray );
            $reviews->fields ['customers_name'] = implode ( $nameArray );

            $reviewsArray [] = array (
                'id' => $reviews->fields ['reviews_id'],
                'customersName' => $reviews->fields ['customers_name'],
                'customer_info '=>$customer_info,
                'country' => $customer_info ['default_country'],
                'dateAdded' => date ( 'M d , Y', strtotime ( $reviews->fields ['date_added'] ) ),
                'reviewsText' => $reviews->fields ['reviews_text'],
                'reviewsRating' => $reviews->fields ['reviews_rating'],
                'reviewsRatingArray' => array_pad(array_fill(1, intval($reviews->fields ['reviews_rating']),1), 5, 0),
                'reviews_reply_text' => $reviews->fields ['reviews_reply_text']
            );

            $reviews->MoveNext ();
        }
    }
    //round(zen_get_product_rating($pid))
    $product_rating = round ( zen_get_product_rating ($product_id ) );
    $product_rating_array = array_pad(array_fill(1, $product_rating,1), 5, 0);
    //var_dump($reviewsArray);die();
    $smarty->assign ( 'page', $page );
    $smarty->assign ( 'page_size', $page_size );
    $smarty->assign ( 'product_rating',  $product_rating);
    $smarty->assign ( 'product_rating_array',  $product_rating_array);
    $smarty->assign ( 'reviews_count',$reviews_count);
    $smarty->assign ( 'reviews_infos', $reviewsArray );
    $smarty->assign ( 'num_pages', $num_pages );
    //$smarty->assign ( 'reviews_display_count', $reviews_split->display_count ( TEXT_DISPLAY_NUMBER_OF_REVIEWS ) );
    $smarty->assign ( 'reviews_display_link', $reviews_split->display_links_mobile ($page_size, zen_get_all_get_params ( array ('page', 'info', 'x', 'y', 'main_page' ) ) ,true));

    //$smarty->assign ( 'based_on', sprintf(TEXT_INFO_BASED_ON_1, $reviews_count) );

    //var_dump(!empty($reviews_display_link));die();

    $price_template_file = DIR_WS_TEMPLATE.'tpl/tpl_product_reviews_info.html';

    $review_html = $smarty->fetch($price_template_file);

    //var_dump($reviews_query_count);die();

    return $review_html;
}

function get_matching_products($product_id,$smarty)
{
    global $db;

    $assgins = array();

    //fetch data
    if ($product_id) {
        $main_products_id = trim ($product_id);
        if (!(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0)) {
            $products_display_solr_str = ' and is_display = 1 ';
        }
        $match_products_query = $db->Execute ( "select zpm.match_products_id from ".TABLE_PRODUCTS_MATCH_PROD_LIST . " zpm inner join " . TABLE_PRODUCTS . " zp on zpm.match_products_id = zp.products_id where zpm.products_id = ".(int)$main_products_id . " and zp.products_status != 10" . $products_display_solr_str );
        if ($match_products_query->RecordCount () > 0) {
            while (!$match_products_query->EOF){
                $match_products_id_arr[] = array(
                    'match_products_id' => $match_products_query->fields['match_products_id'],
                );
                $match_products_query->MoveNext();
            }

            $sql_match_query = '';
            foreach ($match_products_id_arr as $key => $value){
                $sql_match_query .= $value['match_products_id'].',';
            }
            $sql_match_query = substr ( $sql_match_query, 0, - 1 );

            $match_products = $db->Execute ( "select distinct p.products_id, p.products_image, pd.products_name, p.products_price,
											p.products_model, p.products_weight, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
											from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
											where p.products_id in (" . $sql_match_query . ")
											and p.products_id = pd.products_id
											and p.products_id <> '" . $main_products_id . "'
											and products_type = 1
											And p.products_status = 1
											and pd.language_id = " . $_SESSION ['languages_id']."
											order by p.products_model" );
            while ( ! $match_products->EOF ) {
                $product_info = $match_products->fields;
                $product_id = $match_products->fields ['products_id'];
                $product_info['products_quantity'] = zen_get_products_stock($product_id);
                $product_info['name'] = htmlspecialchars ( zen_clean_html ( $product_info['products_name'] ) ) ;
                $product_info['show_name'] = zen_name_add_space(getstrbylength ( htmlspecialchars ( zen_clean_html ($product_info['products_name']) ), 80 ));
                $product_info['is_in_cart'] = $bool_in_cart;
                $product_info['cart_qty'] = $procuct_qty;
                $product_info['link'] = zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id);
                $product_info['main_image_src'] = HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_info['products_image'], 310, 310);
                $product_info['price_html'] = zen_get_products_display_price_new($product_info['products_id'], 'mobile_gallery');

                $related_products[] = $product_info;

                $match_products->MoveNext ();
            }
        }
    }

    //var_dump($related_products);die();

    $assgins['related_products'] = $related_products;

    $render_html = get_rended_product_related_products('match',$smarty,$assgins);

    return $render_html;
}

function get_also_like_products($product_id,$smarty)
{
    global $db;

    $assgins = array();

    if ($product_id) {
        $products_title = $db->Execute("select distinct tag_id from " . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . " where products_id = " .(int)$_GET ['products_id'] . " limit 1");
        if ($products_title->RecordCount () == 1) {
            if (!(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0)) {
                $products_display_solr_str = ' and is_display = 1 ';
            }
            $also_like_products = $db->Execute ( "Select distinct p.products_id, p.products_image, pd.products_name, p.products_price,
											p.products_model, p.products_weight, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
													     From " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . " pr, " . TABLE_PRODUCTS_DESCRIPTION . " pd
													     Where pr.tag_id = '" . zen_db_input ( $products_title->fields ['tag_id'] ) . "'
													      And p.products_id = pd.products_id
														  and p.products_id = pr.products_id
													      And p.products_id != " . ( int ) $_GET ['products_id'] . "
													      " . $products_display_solr_str . "
													      And p.products_status = 1
														  and pd.language_id = " . $_SESSION ['languages_id'] . " order by pr.created desc limit 40" ) ;

            if ($also_like_products->RecordCount () > 0) {

                while ( ! $also_like_products->EOF ) {
                    $procuct_qty = 1;
                    $bool_in_cart = 0;

                    $product_info = $also_like_products->fields;
                    $product_id = $also_like_products->fields ['products_id'];
                    $product_info['products_quantity'] = zen_get_products_stock($product_id);
                    $product_info['name'] = htmlspecialchars ( zen_clean_html ( $product_info['products_name'] ) ) ;
                    $product_info['show_name'] = zen_name_add_space(getstrbylength ( htmlspecialchars ( zen_clean_html ($product_info['products_name']) ), 80 ));
                    $product_info['is_in_cart'] = $bool_in_cart;
                    $product_info['cart_qty'] = $procuct_qty;
                    $product_info['link'] = zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id);
                    $product_info['main_image_src'] = HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_info['products_image'], 310, 310);
                    $product_info['price_html'] = zen_get_products_display_price_new($product_info['products_id'], 'mobile_gallery');

                    $related_products[] = $product_info;

                    $also_like_products->MoveNext ();
                }
            }
        }
    }

    $assgins['related_products'] = $related_products;
    $render_html = get_rended_product_related_products('also_like',$smarty,$assgins);

    return $render_html;
}

function get_also_purchased_products($product_id,$smarty)
{
    global $db;

    $assgins = array();

    if ($product_id) {
        if (!(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0)) {
            $products_display_solr_str = ' and is_display = 1 ';
        }
        $also_purchased_products = $db->Execute("select p.products_id, p.products_image, p.products_price, p.products_model, products_weight, pd.products_name
                     	from " . TABLE_ALSO_PURCHASED . " ap, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
  						where ap.also_purchased_id=p.products_id
						and ap.also_purchased_id = pd.products_id
  						and ap.origin_products_id='".(int)$_GET['products_id']."'
  						and p.products_status=1
						and pd.language_id = " . $_SESSION ['languages_id']."
						" . $products_display_solr_str . "
  						group by p.products_id
                     	order by p.products_date_added desc
                     	limit " . MAX_DISPLAY_ALSO_PURCHASED );

        if ($also_purchased_products->RecordCount () > 0) {

            while ( ! $also_purchased_products->EOF ) {
//   				$product_id = $also_purchased_products->fields ['products_id'];
//   				$also_purchased_products->fields ['products_quantity'] = zen_get_products_stock($product_id);
//   				//			if($also_purchased_products->fields ['products_quantity']<=0){
//   				//			    $also_purchased_products->MoveNext();
//   				//			    continue;
//   				//			}
//   				$product_quantity = $also_purchased_products->fields ['products_quantity'];
//   				$product_image = $also_purchased_products->fields ['products_image'];
//   				$product_name = $also_purchased_products->fields ['products_name'];
//   				$product_min_order = $also_purchased_products->fields ['products_quantity_order_min'];
//   				$product_max_order = $also_purchased_products->fields ['products_quantity_order_max'];

//   				//			if (isset ( $customer_basket_products [$product_id] )) {
//   				//				$procuct_qty = $customer_basket_products [$product_id];
//   				//				$bool_in_cart = 1;
//   				//			} else {
                $procuct_qty = 0;
                $bool_in_cart = 0;
//   				//			}

//   				$also_purchased_products_content[$disp_sum]['img'] = '<a title="' . htmlspecialchars ( zen_clean_html ( $product_name ) ) . '" href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id) . '" class="dlgallery-img"><img src="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_image, 130, 130) . '" alt="' . htmlspecialchars(zen_clean_html($product_name)) . '"/></a>';
//   				$also_purchased_products_content[$disp_sum]['price'] = zen_get_products_display_price_new($product_id, 'matching');
//   				$also_purchased_products_content[$disp_sum]['button'] = '<div class="cartcont">';
//   				if ($product_quantity > 0) {
//   					$also_purchased_products_content[$disp_sum]['button'] .= '<input class="qty addcart_qty_input" orig_value="'.($bool_in_cart ? $procuct_qty : 1).'" type="text" id="pid_' . $product_id . '" value="' . ($bool_in_cart ? $procuct_qty : 1) . '" /><input type="hidden" id="incart_' . $product_id . '" value="' . $procuct_qty . '" /><a href="javascript:void(0);" class="'. ($bool_in_cart ? 'updatecart' : 'addcart') .'" title="'.($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART).'" id="submitp_' . $product_id . '">' . ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART) . '</a>';
//   				} else {
//   					$also_purchased_products_content[$disp_sum]['button'] .= '<a href="javascript:void(0);" class="restock_notification">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
//   					$also_purchased_products_content[$disp_sum]['button'] .= '<a class="soldtext" title="' . TEXT_SOLD_OUT . '" href="javascript:void(0);"></a>';
//   				}
//   				$also_purchased_products_content[$disp_sum]['button'] .= '<a class="text addwishilist-btn addcollect" title="' . TEXT_CART_MOVE_TO_WISHLIST . '" href="javascript:void(0);">+ ' . TEXT_CART_MOVE_TO_WISHLIST . '</a><input type="hidden" class="product_id" value="' . $product_id . '">';
//   				$also_purchased_products_content[$disp_sum]['button'] .= '</div>';
//   				$disp_sum++;

                $product_info = $also_purchased_products->fields;
                $product_id = $also_purchased_products->fields ['products_id'];
                $product_info['products_quantity'] = zen_get_products_stock($product_id);
                $product_info['name'] = htmlspecialchars ( zen_clean_html ( $product_info['products_name'] ) ) ;
                $product_info['show_name'] = zen_name_add_space(getstrbylength ( htmlspecialchars ( zen_clean_html ($product_info['products_name']) ), 80 ));
                $product_info['is_in_cart'] = $bool_in_cart;
                $product_info['cart_qty'] = $procuct_qty;
                $product_info['link'] = zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id);
                $product_info['main_image_src'] = HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_info['products_image'], 310, 310);
                $product_info['price_html'] = zen_get_products_display_price_new($product_info['products_id'], 'mobile_gallery');

                $related_products[] = $product_info;

                $also_purchased_products->MoveNext ();
            }
        }
    }

    //var_dump($related_products);die();
    $assgins['related_products'] = $related_products;
    $render_html = get_rended_product_related_products('also_purchased',$smarty,$assgins);

    return $render_html;
}

function get_recently_viewed_products_html($smarty)
{
    global $db;

    $assgins = array();

    $recently_viewed_products = get_recently_viewed_products();

    if ($recently_viewed_products && is_array($recently_viewed_products))
    {
        foreach ($recently_viewed_products as $viewed_product) {
            $product_info = $viewed_product;
            $product_id = $viewed_product['products_id'];
            $product_info['products_quantity'] = $viewed_product['product_cart_qty'];
            $product_info['name'] = htmlspecialchars ( zen_clean_html ( $product_info['products_name'] ) ) ;
            $product_info['show_name'] = zen_name_add_space(getstrbylength ( htmlspecialchars ( zen_clean_html ($product_info['product_name_all']) ), 80 ));
            $product_info['is_in_cart'] = $viewed_product['product_cart_qty'] && is_numeric($viewed_product['product_cart_qty']) && $viewed_product['product_cart_qty'] >0;
            $product_info['cart_qty'] = $viewed_product['product_cart_qty'];
            $product_info['link'] = $product_info['product_link'];//zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_id);
            $product_info['main_image_src'] = HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_info['products_image'], 310, 310);
            $product_info['price_html'] = zen_get_products_display_price_new($product_id, 'mobile_gallery');

            $related_products[] = $product_info;
        }
    }

//   	$r_products [] = array (
//   			'lang'=>$_SESSION['languages_id'],
//   			'product_link' => $product_link,
//   			'product_image' => $product_image,
//   			'product_name' => getstrbylength ( $product_name, 28 ),
//   			'product_name_all' => $product_name,
//   			'product_id' => $rp_id,
//   			'display_price' => $rp_display_price,
//   			'discount' => $discount_amount,
//   			'btn_class' => $btn_class,
//   			'product_qty' => $rp_qty,
//   			'product_cart_qty' => 1
//   	);

    //var_dump($recently_viewed_products);
    //var_dump($products);
    //die();

    //var_dump($related_products);die();
    $assgins['related_products'] = $related_products;
    $render_html = get_rended_product_related_products('recently_viewed',$smarty,$assgins);

    return $render_html;
}

function get_rended_product_related_products($related_type = '',$smarty,$assgins)
{
    $price_template_file = DIR_WS_TEMPLATE.'tpl/tpl_product_relate_products_info.html';

    $smarty->assign ( 'related_type', $related_type );

    if ($assgins && is_array($assgins))
    {
        foreach ($assgins as $key=>$value) {
            $smarty->assign ( $key, $value );
        }
    }


    $render_html = $smarty->fetch($price_template_file);

    return $render_html;
}

function get_subject_area_info($area_id)
{
    global $db;

    $subject_area_vo = array();

    $subject_area_po = $db->Execute("SELECT * FROM ".TABLE_SUBJECT_AREAS." WHERE id='".$area_id."' LIMIT 1");
    if($subject_area_po->RecordCount() > 0){
        $subject_area_vo = $subject_area_po->fields;
        $subject_area_vo['language_name'] = unserialize($subject_area_po->fields['name']);
    }

    return $subject_area_vo;
}

function get_deals_marketing_info($languages_id)
{
    global $db, $memcache;


    $languages_id = $languages_id?$languages_id:intval($_SESSION['languages_id']);


    $memcache_key = md5(MEMCACHE_PREFIX . 'get_deals_marketing_info_memcache' . $languages_id);
    $data = $memcache->get($memcache_key);
    if($data || gettype($data) != 'boolean') {
        return $data;
    }

    $sql = 'SELECT marketing_title FROM '.TABLE_DAILYDEAL_MARKETING_DESC.' WHERE languages_id = :languages_id';
    $sql = $db->bindVars($sql, ':languages_id', $languages_id, 'integer');
    $result = $db->Execute($sql);

    $result_return = array();
    if($result->RecordCount() > 0){
        while (!$result->EOF) {
            $result_return[] = $result->fields['marketing_title'];

            $result->MoveNext();
        }
    }

    if(is_array($result_return) && sizeof($result_return)>0)
    {
        $memcache->set($memcache_key, $result_return, false, 60*60*24);
    }

    return $result_return;
}

function get_deals_sold_info($product_id, $real=0)
{
    global $db;

    $result_qty = 0;
    $product_id = $product_id?$product_id:0;
    if($product_id)
    {
        $sql = 'SELECT 
				  products_sold_id,
				  products_id,
				  init_qty,
				  current_qty,
				  last_refresh_date,
				  add_date 
				FROM '.TABLE_DAILYDEAL_PRODUCTS_SOLD.' 
				WHERE products_id = :products_id
				LIMIT 1;';
        $sql = $db->bindVars($sql, ':products_id', $product_id, 'integer');
        $result = $db->Execute($sql);

        $product_sold_info = array();
        if($result->RecordCount() > 0){
            $product_sold_info = $result->fields;
        }

        $last_refresh_date = date('Y-m-d H:i:s');

        if($product_sold_info)
        {
            //已存在则刷新
            $result_qty = $product_sold_info['current_qty'];
            $period_info = zend_get_datetime_diff($product_sold_info['last_refresh_date'],$last_refresh_date);
            if($period_info && $period_info['sec'] >0)
            {
                $result_qty += mt_rand(2,5) * $period_info['hour'];
                $result_qty += $real * 3;

                $update_data = array(
                    "current_qty" =>  $result_qty,
                    "last_refresh_date"=>$last_refresh_date
                );
                zen_db_perform(TABLE_DAILYDEAL_PRODUCTS_SOLD, $update_data, 'update',"products_sold_id = " . intval($product_sold_info['products_sold_id']) . "");
            }
        }else
        {
            //不存在则新增
            $result_qty = mt_rand(300,1000);
            $insert_data = array(
                "products_id" => $product_id,
                "init_qty"=>$result_qty,
                "current_qty" =>$result_qty,
                "last_refresh_date"=>$last_refresh_date,
                "add_date"=> $last_refresh_date
            );

            zen_db_perform(TABLE_DAILYDEAL_PRODUCTS_SOLD, $insert_data,'insert');
        }
    }

    if ($real == 0) {
        return $result_qty;
    }
}



function get_product_promotion_area_info($area_id,$languages_id , $area_type = 1)
{
    global $db;

    $languages_id = $languages_id?$languages_id:intval($_SESSION['languages_id']);

    $area_info_sql = 'SELECT 
						  pa.promotion_area_id,
						  pa.promotion_area_type,
						  pa.related_promotion_ids,
						  pa.promotion_area_name AS promotion_area_name_en,
						  pa.promotion_area_status,
						  pa.promotion_area_languages,
						  pa.show_index,
  						  pa.show_mobile_index,
						  pad.promotion_area_name
						FROM '.TABLE_PROMOTION_AREA.' AS pa
						INNER JOIN '.TABLE_PROMOTION_AREA_DESCRIPTION.' AS pad ON pad.promotion_area_id = pa.promotion_area_id
						WHERE pa.promotion_area_id = :area_id AND pad.languages_id = :languages_id AND pa.promotion_area_type = ' . $area_type . '
						LIMIT 0,1';

    $area_info_sql = $db->bindVars($area_info_sql, ':area_id', $area_id, 'integer');
    $area_info_sql = $db->bindVars($area_info_sql, ':languages_id', $languages_id, 'integer');

    $result = $db->Execute($area_info_sql);

    return $result;
}

function get_product_promotion_deals_info($area_id,$related_promotion_ids)
{
    global $db;

    //活动并且是开启了对应语种的猜显示对应商品信息
    $today_begin = date('Y-m-d 00:00:00');
    $today_end = date('Y-m-d 23:59:59');

    $detail_sql = 'SELECT DISTINCT
							  pp_products_id,
							  promotion_discount,
							  pp.pp_promotion_start_time,
							  pp.pp_promotion_end_time
							FROM '.TABLE_PROMOTION_PRODUCTS.' AS pp
							INNER JOIN '.TABLE_PROMOTION.' AS p ON p.promotion_id = pp.pp_promotion_id
							WHERE  pp_promotion_id IN(' . $related_promotion_ids . ') AND p.promotion_type = 2 AND p.promotion_status = 1 AND pp.pp_promotion_start_time <= "'. date('Y-m-d H:i:s') .'" AND pp.pp_promotion_end_time > "'. date('Y-m-d H:i:s') .'" and pp.pp_is_forbid = 10
							ORDER BY pp_id ASC';
    //WHERE  pp_promotion_id IN(:promotion_id) AND p.promotion_type = 2 AND p.promotion_status = 1 AND p.promotion_start_time >= :today_begin AND p.promotion_end_time <= :today_end
    //$detail_sql = $db->bindVars($detail_sql, ':promotion_id', $related_promotion_ids, 'string');
// 		$detail_sql = $db->bindVars($detail_sql, ':today_begin', $today_begin, 'date');
// 		$detail_sql = $db->bindVars($detail_sql, ':today_end', $today_end, 'date');

    $detail_result = $db->Execute($detail_sql);

    return $detail_result;
}

/*
 * get products info from TABLE_PROMOTION_PRODUCTS
 * @param $products_id
 * return array
*/
function get_product_promotion_info($products_id)
{
    global $db;
    $return_info = array();

    $product_promotion_info_sql = 'SELECT pp_max_num_per_order FROM '.TABLE_PROMOTION_PRODUCTS.' pp, '.TABLE_PROMOTION.' p WHERE pp.pp_promotion_id=p.promotion_id and p.promotion_status=1 and pp.pp_is_forbid = 10  and pp.pp_promotion_start_time <= "'. date('Y-m-d H:i:s') .'" and pp.pp_promotion_end_time > "'. date('Y-m-d H:i:s') .'" and pp.pp_products_id='.(int)$products_id.' LIMIT 1 ';
    $product_promotion_info_query = $db->Execute($product_promotion_info_sql);

    if ($product_promotion_info_query->RecordCount() > 0) {
        $return_info = array ('pp_max_num_per_order' => $product_promotion_info_query->fields['pp_max_num_per_order']
        );
    }
    if(get_products_promotion_price($products_id)){
        $product_deals_info_sql = "SELECT max_num_per_order
                                            FROM ".TABLE_DAILYDEAL_PROMOTION." dp INNER JOIN " . TABLE_DAILYDEAL_AREA . " zda on dp.area_id = zda.dailydeal_area_id
                                            WHERE  dp.dailydeal_products_start_date <=  '". date('Y-m-d H:i:s') ."'
                                            AND dp.dailydeal_products_end_date >  '". date('Y-m-d H:i:s') ."'
                                            AND dp.dailydeal_is_forbid = 10
                                            and zda.area_status = 1
                                            AND dp.products_id = ".$products_id."
                                             LIMIT 1";
        $product_deals_info_query = $db->Execute($product_deals_info_sql);
        if ($product_deals_info_query->RecordCount() > 0) {
            $return_info = array ('pp_max_num_per_order' => $product_deals_info_query->fields['max_num_per_order']
            );
        }
    }
    return $return_info;
}

function get_product_dailydeal_area_info($area_id,$languages_id='')
{
    global $db;

    $languages_id = $languages_id?$languages_id:intval($_SESSION['languages_id']);

    $area_info_sql = 'SELECT 
						  da.dailydeal_area_id,
						  da.area_name AS area_name_en,
						  da.start_date,
						  da.end_date,
						  da.expire_interval,
						  da.area_status ,
						  dad.area_name
						FROM '.TABLE_DAILYDEAL_AREA.' AS da
						INNER JOIN '.TABLE_DAILYDEAL_AREA_DESCRIPTION.' AS dad ON dad.area_id = da.dailydeal_area_id
						WHERE da.dailydeal_area_id = :area_id AND area_status = 1 AND dad.languages_id = :languages_id AND da.start_date <= NOW() AND da.end_date >=NOW()
						LIMIT 0,1';

    $area_info_sql = $db->bindVars($area_info_sql, ':area_id', $area_id, 'integer');
    $area_info_sql = $db->bindVars($area_info_sql, ':languages_id', $languages_id, 'integer');

    $result = $db->Execute($area_info_sql);

    return $result;
}

function get_product_dailydeal_product_info($area_id)
{
    global $db , $memcache;
    $data = array();

    $memcache_key = md5(MEMCACHE_PREFIX . 'get_product_dailydeal_product_info' . $area_id);
    $data = $memcache->get($memcache_key);

    if( gettype($data) != 'boolean') {
        return $data;
    }else{
        //活动并且是开启了对应语种的猜显示对应商品信息
        $today_begin = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $detail_sql = 'SELECT  
							  dailydeal_promotion_id,
							  tdp.products_id,
							  dailydeal_products_start_date,
							  dailydeal_products_end_date,
							  products_img,
							  dailydeal_is_forbid,
							  group_id,
							  dailydeal_price,
							  area_id 
							FROM ('.TABLE_DAILYDEAL_PROMOTION.' tdp INNER JOIN ' . TABLE_DAILYDEAL_AREA . ' zda on tdp.area_id = zda.dailydeal_area_id ) inner join ' . TABLE_PRODUCTS . ' tp on tp.products_id = tdp.products_id
							WHERE area_id = :area_id AND dailydeal_is_forbid = 10 and zda.area_status = 1 AND products_status = 1 AND dailydeal_products_end_date >= "'. date('Y-m-d H:i:s') .'" AND tdp.products_id NOT IN (select products_id from ' . TABLE_MY_PRODUCTS . ') 
							order by tdp.dailydeal_products_start_date asc ';

        $detail_sql = $db->bindVars($detail_sql, ':area_id', $area_id, 'integer');
        $detail_result = $db->Execute($detail_sql);

        if($detail_result->RecordCount() > 0){
            while (!$detail_result->EOF){
                $promotion_price_array[] = $detail_result->fields;

                $detail_result->MoveNext();
            }
        }

        $data = array('promotion_price_info' => $promotion_price_array);
        $memcache->set($memcache_key, $data, false, 24 * 60 * 60);

    }
    return $data;
}

function remove_promotion_area_info_from_memcache($area_id=1)
{
    global $memcache;
    $memcache_key = md5(MEMCACHE_PREFIX . 'get_normal_promotion_area_info_memcache' .$area_id );
    $memcache->delete($memcache_key);
}

function get_promotion_area_info_from_memcache($area_id=1)
{
    global $db, $memcache;
    $area_id = intval($area_id);

    $memcache_key = md5(MEMCACHE_PREFIX . 'get_normal_promotion_area_info_memcache' .$area_id );
    $data = $memcache->get($memcache_key);
    if($data || gettype($data) != 'boolean') {
        return $data;
    }

    $sql = 'SELECT 
				  promotion_area_id,  
				  promotion_area_status,
				  promotion_area_languages, 
				  promotion_area_name
				FROM '.TABLE_PROMOTION_AREA.'
				WHERE promotion_area_id = :area_id ';

    $sql = $db->bindVars($sql, ':area_id', $area_id, 'integer');
    $result = $db->Execute($sql);

    $result_return = array();
    if($result->RecordCount() > 0){
        $result_return = $result->fields;

        $sql_desc = 'SELECT languages_id,promotion_area_name FROM t_promotion_area_description WHERE promotion_area_id = :area_id';

        $sql_desc = $db->bindVars($sql_desc, ':area_id', $area_id, 'integer');
        $result_desc =  $db->Execute($sql_desc);

        if($result_desc->RecordCount() > 0)
        {
            while (!$result_desc->EOF) {
                $result_return['desc_info'][$result_desc->fields['languages_id']] = $result_desc->fields['promotion_area_name'];

                $result_desc->MoveNext();
            }
        }
    }

    if(is_array($result_return) && sizeof($result_return)>0)
    {
        $memcache->set($memcache_key, $result_return, false, 604800);
    }

    return $result_return;
}



function get_product_image_src($image_name,$width='',$height='')
{
    if($width >0 && $height >0)
    {
        return HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size ( $image_name, $width, $height );
    }

    return  HTTP_IMG_SERVER . 'bmz_cache/' . $image_name;
}



function zend_get_datetime_diff($start_datetime,$end_datetime)
{
    if(gettype($start_datetime) == 'string')
    {
        $start_datetime = strtotime($start_datetime);
    }

    if(gettype($end_datetime) == 'string')
    {
        $end_datetime = strtotime($end_datetime);
    }

    //计算天数
    $timediff = $end_datetime - $start_datetime;
    $days = intval($timediff/86400);
    //计算小时数
    $remain = $timediff%86400;
    $hours = intval($remain/3600);
    //计算分钟数
    $remain = $remain%3600;
    $mins = intval($remain/60);
    //计算秒数
    $secs = $remain%60;

    $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);

    return $res;
}



/**
 * convert a std class to array with key and value
 * @param stdClass $stdclassobject
 * @return array(field_name=>field_value)
 */
function zend_std_class_array_to_array($stdclassarray)
{
    $results = array();

    foreach ($stdclassarray as $key => $value) {
        $results[$key] = $value;
    }

    return $results;
}

function zend_get_all_url_params($url)
{
    $params = array();

    if(preg_match_all('/(\w+)=([^&]*)/i', $url, $regex_matchs))
    {
        if ($regex_matchs && is_array($regex_matchs) && count($regex_matchs) >0) {
            foreach ($regex_matchs[0] as $item) {
                $key_value = explode('=',$item);
                if($key_value && count($key_value)>0)
                {
                    $params[$key_value[0]] = $key_value[1];
                }
            }
        }
    }

    return $params;
}

function zend_get_url_param($url,$param_key,$param_value)
{
    $all_params = zend_get_all_url_params($url);
    if($all_params && is_array($all_params) && array_key_exists($param_key, $all_params))
    {
        return $all_params[$param_key];
    }

    return '';
}

/**
 * set url param value
 * @param string $url
 * @param string $param_key
 * @param mix $param_value
 * @return new url with set param value
 */
function zend_set_url_param($url,$param_key,$param_value)
{
    $url = $url |'';
    $param_value = $param_value | '';

    $url_info = parse_url($url);
    $query_string =  $url_info['query'];
    $base_url = str_ireplace($query_string, '',$url);
    $query_string_array = split('[&]',$query_string);

    $new_url = $base_url;
    if ($param_key && $query_string_array)
    {
        $new_url .=strpos($new_url, '?') !==false ? '': '?';

        $query_string_array[] = $param_key.'='.($param_value|'');
        $i = 1;

        foreach ($query_string_array as $key_value) {
            if (zend_start_with($key_value,$param_key)) {
                $new_url .=  ($i==1?'':'&').$param_key.'='.($param_value|'');
            }else
            {
                $new_url .= ($i==1?'':'&').$key_value;
            }

            $i ++;
        }

    }else
    {
        $new_url = $url;
    }


    return $new_url;
}

function zend_set_url_params($url,$params = array())
{
    $url = $url |'';
    foreach ($params as $param_key => $param_value) {
        $url = zend_set_url_param($url,$param_key,$param_value);
    }

    return $url;
}

/**
 * remove url param
 * @param string $url
 * @param string $param_key
 * @return boolean
 */
function zend_remove_url_param($url,$param_key)
{
    $url = $url |'';
    $param_value = $param_value | '';

    $url_info = parse_url($url);
    $query_string =  $url_info['query'];
    $base_url = str_ireplace($query_string, '',$url);
    $query_string_array = split('[&]',$query_string);

    $new_url = $base_url;
    if ($param_key && $query_string_array)
    {
        $new_url .=strpos($new_url, '?') !==false ? '': '?';

        $i = 1;

        foreach ($query_string_array as $key_value) {
            if (!zend_start_with($key_value,$param_key)) {
                $new_url .= ($i==1?'':'&').$key_value;
            }

            $i ++;
        }

    }else
    {
        $new_url = $url;
    }


    return $new_url;
}

function zend_remove_url_params($url,$param_keys=array())
{
    $url = $url |'';
    foreach ($param_keys as $param) {
        $url = zend_remove_url_param($url,$param);
    }
    return $url;
}

function zend_start_with($str, $needle) {

    return strpos($str, $needle) === 0;

}



function zend_end_with($haystack, $needle)
{
    $length = strlen($needle);
    if($length == 0)
    {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
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

/**
 * 记录用户操作日志(从后台copy过来)
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

/**
 * 得到搜索相关词
 * @param string $keyword:搜索关键词
 * @param int $languages_id
 * @param int $number 返回的数据条数
 * @return array
 */
function get_search_related_array($keyword, $languages_id = 1, $number = 5) {
    global $db;
    $array = array();
    $sql = 'SELECT keyword, keyword_display, keyword_type FROM ' . TABLE_SEARCH_RELATED . ' WHERE languages_id = :languages_id and keyword like :keyword order by auto_id asc limit ' . ($number + 1);
    $sql = $db->bindVars($sql, ':languages_id', $languages_id, 'integer');
    $sql = $db->bindVars($sql, ':keyword', '%' . $keyword . '%', 'string');
    $result = $db->Execute($sql);
    $array_unique = array($keyword);//初始化将自己放进去，因为要排除自己所以sql查询时要$number + 1
    $index = 0;
    while (!$result->EOF) {
        if($index >= $number) {
            $result->MoveNext();
            break;
        }
        if(!in_array($result->fields['keyword_display'], $array_unique) && strtolower($keyword) != strtolower($result->fields['keyword_display'])) {
            $array[] = $result->fields;
            $index++;
        }
        array_push($array_unique, $result->fields['keyword_display']);
        $result->MoveNext();
    }
    //排序
    $array = array_sort_checkout($array, "keyword_display");
    return $array;
}

/**
 * 得到同义词
 * @param string $keyword:查找的词
 * @param int $languages_id
 * @param int $number 返回的数据条数
 * @return array
 */
function get_search_synonym_array($keyword_main, $languages_id = 1, $number = 5) {
    global $db;
    $array = array();
    $sql = 'SELECT keyword_synonym FROM ' . TABLE_SEARCH_SYNONYM . ' WHERE languages_id = :languages_id and keyword_status = :keyword_status and keyword_main = :keyword_main order by keyword_synonym asc limit ' . $number;
    $sql = $db->bindVars($sql, ':languages_id', $languages_id, 'integer');
    $sql = $db->bindVars($sql, ':keyword_status', 1, 'integer');
    $sql = $db->bindVars($sql, ':keyword_main',  $keyword_main, 'string');
    $result = $db->Execute($sql);
    while (!$result->EOF) {
        array_push($array,$result->fields['keyword_synonym'] );
        $result->MoveNext();
    }
    return $array;
}
/**
 *
 * 更新products_add_wishlist表中商品的添加wishlist的实际数量和展示数量。
 * pid:商品编号
 * action:默认为增加商品添加wishlist的实际数量和展示数量 ，remove为前台删除wishlist中的商品时减少表中的数量
 * num:在action为remove时需要减少的数量
 *
 * */
function update_products_add_wishlist($pid , $action = 'update' , $num = 1) {
    global $db;
    if($action == 'update'){
        $add_num_sql = 'select products_id , really_num , show_num from ' . TABLE_PRODUCTS_ADD_WISHLIST . ' where products_id = ' .  $pid. ' limit 1';
        $add_num_query = $db->Execute($add_num_sql);
        if($add_num_query->RecordCount() != 0){
            $sql_data_array = array(
                'really_num' => intval($add_num_query->fields['really_num']) + 1,
                'show_num' => intval($add_num_query->fields['show_num']) + rand(5 , 15)
            );

            zen_db_perform(TABLE_PRODUCTS_ADD_WISHLIST , $sql_data_array , 'update' , ' products_id = ' . $pid);
        }else {
            $sql_data_array = array(
                'products_id' => $pid,
                'really_num' => 1,
                'show_num' => rand(5 , 15)
            );
            zen_db_perform(TABLE_PRODUCTS_ADD_WISHLIST , $sql_data_array);

        }
    }elseif ($action == 'remove'){
        $add_num_sql = 'select products_id , really_num , show_num from ' . TABLE_PRODUCTS_ADD_WISHLIST . ' where products_id = ' .  $pid. ' limit 1';
        $add_num_query = $db->Execute($add_num_sql);
        if($add_num_query->RecordCount() != 0){
            $sql_data_array = array(
                'really_num' => intval($add_num_query->fields['really_num']) - $num,
                'show_num' => intval($add_num_query->fields['show_num']) - $num
            );

            zen_db_perform(TABLE_PRODUCTS_ADD_WISHLIST , $sql_data_array , 'update' , ' products_id = ' . $pid);
        }
    }
}

function zen_get_discount_note($new=false,$total='',$shipping=''){
    global $currencies,$order,$db;
    $str = '';

    if (MODULE_ORDER_TOTAL_ORDER_DISCOUNT_STATUS == 'true'){
        $show_total = $_SESSION['cart']->show_total_new() - $_SESSION['cart']->show_promotion_total();
        $order_total = $currencies->value($show_total, true, 'USD');
        $order_discount_grade = 0;
        if($order_total < MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE1) {
            $order_discount_top = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE1;
            $next_order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE1;
        }elseif($order_total < MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE2) {
            $order_discount_top = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE2;
            $next_order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE2;
        }elseif($order_total < MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE3) {
            $order_discount_top = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE3;
            $next_order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE3;
        }elseif($order_total < MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE4) {
            $order_discount_top = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_SUBTOTAL_GRADE4;
            $next_order_discount_grade = MODULE_ORDER_TOTAL_ORDER_DISCOUNT_GRADE4;
        }else{
            $order_discount_top = 0;
        }

        if ($order_discount_top > 0 && $order_total >= $order_discount_top * 0.6){
            $str = str_replace(array('{TOTAL}', '{NEXT}', '{REACH}'), array($currencies->format($show_total, false), $next_order_discount_grade . '%', $currencies->format($order_discount_top)), TEXT_PROMOTION_DISCOUNT_NOTE);
        }
    }

    return $str;
}

/**
 * @author Tianwen.Wan
 * @param string $dir
 * @param string $file
 * @param string $content
 * @param string $mode
 */
function write_file($dir, $file, $content, $mode = 'a') {
    if(!is_dir(DIR_FS_CATALOG . $dir)) {
        @mkdirs(DIR_FS_CATALOG . $dir);
    }
    $handle = fopen(DIR_FS_CATALOG . $dir . $file, $mode);
    fwrite($handle, $content);
    fclose($handle);
}

/**
 * @author Tianwen.Wan
 * @param string $dir
 */
function mkdirs($dir) {
    if (!is_dir($dir)) {
        if (!mkdirs(dirname($dir))) {
            return false;
        }
        if (!mkdir($dir, 0777)) {
            return false;
        }
    }
    return true;
}

/**
 * @author Tianwen.Wan
 * @param string $download_url
 * @param string $save_dir
 * @param string $filename
 * @param boolean $unlink
 * @return string
 */
function download_file($download_url, $save_dir = "", $filename = "", $unlink = false) {
    if(empty($download_url)) {
        return "";
    }
    if(empty($filename)) {
        $ext=strrchr($download_url, ".");
        $filename=date("YmdHis") . mt_rand(100, 999) . $ext;
    }
    if(is_file($save_dir . $filename)) {
        if($unlink == true) {
            unlink($save_dir . $filename);
        } else {
            return $filename;
        }
    }

    ob_start();
    readfile($download_url);
    $img = ob_get_contents();
    ob_end_clean();
    $size = strlen($img);
    if($size > 0) {
        $fp2 = @fopen($save_dir . $filename, 'a');
        fwrite($fp2, $img);
        fclose($fp2);
    }
    return $filename;
}

/*
* 得到系列产品
* @param int $languages_id
* @param varchar $products_model
* @param int $products_id
* @return array or false
*/
function get_products_group_of_products($languages_id, $products_model, $products_id = 0, $number = 500){
    global $db, $memcache;
    $return_data = $return_temp = array();
    $memcache_key = md5(MEMCACHE_PREFIX . 'get_products_group_of_products' . $products_model . $products_id . $number);//$languages_id不用作为缓存key
    
    $data = $memcache->get($memcache_key);
    if($data || gettype($data) != 'boolean') {
        if(isset($data[$languages_id])) {
            return array('data' => $data[$languages_id]);
        }
        return array('data' => array());
    }

    if(!intval($products_id) && empty($products_model)){
        return $return_data;
    }
    $sql = "select p.products_id, p.products_model, p.products_image, pd.language_id, pd.products_name from " . TABLE_PRODUCTS . " p INNER JOIN (select DISTINCT(pgd1.pgd_prod_no) as pgd_prod_no from " . TABLE_PRODUCTS_GROUP_DET . " pgd1 inner join(select pgd.pgd_group_id from " . TABLE_PRODUCTS_GROUP_DET . " pgd INNER JOIN  " . TABLE_PRODUCTS_GROUP . "  pg on pg.pg_group_id=pgd.pgd_group_id where pg.pg_status='A' and pgd.pgd_prod_no='" . $products_model . "')t on pgd1.pgd_group_id=t.pgd_group_id) t1 on p.products_model=t1.pgd_prod_no inner join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id=pd.products_id where p.products_status=1 limit " . $number;
    $sql_query = $db->Execute($sql);
    if ($sql_query->RecordCount() <= 0) {
        $memcache->set($memcache_key, $return_data, false, mt_rand(43200, 86400));
        return $return_data;
    }else{
        while (!$sql_query->EOF) {
            $return_temp[$sql_query->fields['language_id']][] = $sql_query->fields;
            $sql_query->MoveNext();
        }
        if(!empty($return_temp)) {
            $memcache->set($memcache_key, $return_temp, false, mt_rand(43200, 86400));
            return array('data' => $return_temp[$languages_id]);
        }
    }
}

/***
 * 记录无效链接
 * @param string $have_condition 是否有需要判断条件
 * @param unknown $parameter 需要判断的参数
 * @param unknown $record_condition 记录无效链接时参数应满足的条件
 */
function record_valid_url($have_condition = false , $parameter , $record_condition){
    $record_flag = true;

    if(isset($_GET['source_code'])){
        if($have_condition){
            if($parameter != $record_condition){
                $record_flag = false;
            }
        }
        if($record_flag){
            $url = HTTP_SERVER . $_SERVER['REQUEST_URI'];
            $ip = zen_get_ip_address();
            $referer_url = $_SERVER['HTTP_REFERER'];
            $customers_id = $_SESSION['customer_id'];

            $data_array= array(
                'invalid_url' => $url,
                'from_url' => $referer_url,
                'ip_address' => $ip,
                'customers_id' => $customers_id,
                'date_created' => 'now()'
            );

            zen_db_perform(TABLE_INVALID_URL, $data_array);
        }

    }

}

/**
 * 通过ip地址得到国家信息
 * @param string ip地址
 * @return array 国家信息
 */
function get_country_info_by_ip_address($ip_address){
    global $db;
    $array = array('success' => 0, 'data' => array('country_code' => '', 'country_name' => ''));
    $ip_array = explode('.', $ip_address);
    $ip_number = ($ip_array[3] + $ip_array[2] * 256 + $ip_array[1] * 256 * 256 + $ip_array[0] * 256 * 256 * 256);

    $query = 'SELECT country_code, country_name FROM ip_country WHERE ip_to >= :ipno and ip_from <= :ipno order by ip_to LIMIT 1';
    $query = $db->bindVars($query, ':ipno', $ip_number, 'integer');
    $result = $db->Execute($query);
    if($result->RecordCount() > 0 && $result->fields['country_code'] != "-") {
        $array['success'] = 1;
        $array['data'] = $result->fields;
    }
    return $array;
}

/**
 * 查询某个表中按销量排序
 * @param string $table
 * @return array or string
 */
function get_oem_sourcing_products_memcache($table = TABLE_OEM_SOURCING_PRODUCTS) {
    global $db, $memcache;
    $time = time();
    $time_30 = date('Y-m-d H:i:s', ($time - (86400 * 30)));
    $memcache_key = md5('get_oem_sourcing_products_memcache' . $table);
    $data = $memcache->get($memcache_key);
    if($data || gettype($data) != 'boolean') {
        return $data;
    }
    $sql = 'SELECT op.products_id, sum(products_quantity) as products_ordered  from ' . TABLE_ORDERS_PRODUCTS . ' op INNER JOIN '. $table .' osp on op.products_id = osp.products_id where orders_id in (select orders_id from ' . TABLE_ORDERS . ' where date_purchased>"' . $time_30 . '" and orders_status in (' . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ')) GROUP BY op.products_id ORDER BY products_ordered DESC';
    $result = $db->Execute($sql);
    $result_return = array();
    if($result->RecordCount() > 0){
        while (!$result->EOF) {
            $result_return[] = $result->fields;

            $result->MoveNext();
        }
    }
    if(!empty($result_return)) $memcache->set($memcache_key, $result_return, false, 604800);//Tianwen.Wan20141120缓存7天
    if(!empty($cloumn) && isset($result_return[$cloumn])) {
        return $result_return[$cloumn];
    }
    return $result_return;
}
/*
 * 显示coupon顶部通知
 * $website手机还是网页
 * $is_header_new控制样式
 * 
 */
function show_coupon_letter($website , $is_header_new = false){
    global $db;
    if(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0){
        $station_letter_content = '';
        $languages_id = intval($_SESSION["languages_id"])>0 ? intval($_SESSION["languages_id"]) : 1;
        $customers_id = intval($_SESSION['customer_id']);
        $station_letter_sql = 'SELECT zl.station_letter_id , zl.website_code , zl.station_letter_type , zl.display_languages , zd.station_letter_title , zd.station_letter_discription from (' . TABLE_STATION_LETTER_CUSTOMERS . ' zc INNER JOIN ' . TABLE_STATION_LETTER . ' zl on zc.station_letter_id = zl.station_letter_id) INNER JOIN ' . TABLE_STATION_LETTER_DESCRIPTION . ' zd on zd.station_letter_id = zl.station_letter_id where zd.lanaguges_id = ' . $languages_id . ' and zc.station_letter_status = 10 and zc.customers_id = ' . $customers_id . ' and zl.website_code = ' . WEBSITE_CODE . ' and zl.display_languages like "%,' . $languages_id . ',%" ORDER BY sc_id DESC limit 1';
        $station_letter_query = $db->Execute($station_letter_sql);

        if($station_letter_query->RecordCount() > 0){
            $station_letter_type = $station_letter_query->fields['station_letter_type'];
            $station_letter_description = $station_letter_query->fields['station_letter_discription'];
            $letter_link_sql = 'SELECT station_letter_link FROM ' . TABLE_STATION_LETTER_LINK_RULE . ' WHERE station_letter_type = ' . $station_letter_type . ' AND website_code = ' . WEBSITE_CODE;
            $letter_link_query = $db->Execute($letter_link_sql);

            if($letter_link_query->RecordCount() > 0){
                $link = HTTP_SERVER . '/' . $letter_link_query->fields['station_letter_link'];

                if($website == 'mobiesite'){
                    $station_letter_content = '<div class="reminder_wrap" station_letter_id="' . $station_letter_query->fields['station_letter_id'] . '" ' . ($is_header_new ? 'style="margin-top: 5px;"' : '') . '>
			        			<div class="coupon_reminder">
			            		<div class="coupon_title"><span>' . $station_letter_query->fields['station_letter_title']. '</span></div>
			          			<div class="coupon_message_content" style="right: ' . ($_GET['main_page'] == 'index' ? '4px' : '2px') . ';">
			            			<span>' . $station_letter_description. '
			                			<a href="' . $link. '" onclick="return closeLetter(30);">' . TEXT_TO_VIEW. '</a>
			                		</span>
			                		<a href="javascript:void(0);" class="close" onclick=" return closeLetter(20);"><span></span></a>
			                	</div>
			            	</div>
			        	</div>';
                }else{
                    $station_letter_content = '
								<div class="reminder_wrap" station_letter_id="' . $station_letter_query->fields['station_letter_id'] . '">
				    				<div class="coupon_reminder">
				        				<p><span>' . $station_letter_description . '</span>
				            				<a href="' . $link . '" onclick="closeLetter(30);">' . TEXT_TO_VIEW . '</a>
				            			</p><a href="javascript:void(0);" class="close" onclick="closeLetter(20);"><span></span></a>
				        			</div>
				    			</div>';
                }
            }
        }
        return $station_letter_content;
    }
}

/**
 * 查询所有产品配送受限记录
 * @return array
 */
function get_products_shipping_restriction(){
    global $db, $memcache;
    $memcache_key = md5(MEMCACHE_PREFIX . 'get_products_shipping_restriction');
    $data = $memcache->get($memcache_key);
    if(is_array($data)) {
        return $data;
    }

    $result=$db->Execute("SELECT products_id, shipping_code_str FROM " . TABLE_PRODUCTS_SHIPPING_RESTRICTION);
    $data = array();
    while (!$result->EOF){
        $data[$result->fields['products_id']] = array('shipping_code_str' => $result->fields['shipping_code_str']);
        $result->MoveNext();
    }
    $memcache->set($memcache_key, $data, false, 600);
    return $data;
}

/**
 * 查询关联产品
 * @param array $products_id_array
 * @return array
 */
function get_products_without_catg_relation($products_id_array){
    global $db, $memcache;
    if(empty($products_id_array)) {
        return array();
    }
    $memcache_key = md5(MEMCACHE_PREFIX . 'get_products_without_catg_relation' . json_encode($products_id_array));
    $data = $memcache->get($memcache_key);
    if(is_array($data)) {
        return $data;
    }

    $products_id_str = implode(",", $products_id_array);
    $products_also_like_sql = "select t1.products_id, count(t1.products_id) count from (select products_id, tag_id from " . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . " where products_id in(" . $products_id_str . ")) t1 inner join " . TABLE_PRODUCTS_NAME_WITHOUT_CATG_RELATION . " pnwcr on pnwcr.tag_id=t1.tag_id where exists(select products_id from " . TABLE_PRODUCTS . " p where p.products_id=pnwcr.products_id and products_status=1) group by t1.products_id";
    $products_also_like_result = $db->Execute($products_also_like_sql);
    $data = array();
    while(!$products_also_like_result->EOF) {
        if($products_also_like_result->fields['count'] > 0) {
            $data[$products_also_like_result->fields['products_id']] = 1;
        }
        $products_also_like_result->MoveNext();
    }
    $memcache->set($memcache_key, $data, false, 3600);
    return $data;
}

/**
 * 得到默认国家
 * @param array $customers_info  customers_id:客户ID、address_book_id:选择的地址薄自增ID
 * @return string 国家二级编码
 */
function get_default_country_code($customers_info = array('customers_id' => 0, 'address_book_id' => 0)){
    global $db, $memcache;
    $customers_id = 0;
    if(isset($customers_info['customers_id'])) {
        $customers_id = $customers_info['customers_id'];
    }
    $countries_iso_code_2_address_book = "";

    if(isset($_SESSION['cart_country_code']) && !empty($_SESSION['cart_country_code']) && empty($customers_info['address_book_id'])) {
        return $_SESSION['cart_country_code'];
    }

    $countries_iso_code_2 = isset($_COOKIE['zencountry_code']) ? $_COOKIE['zencountry_code'] : "";
    if(empty($countries_iso_code_2) || $countries_iso_code_2 == "-") {
        $countries_iso_code_2 = "US";
    }

    if(!empty($customers_info['address_book_id'])) {
        $select_country_id_sql = "select c.countries_iso_code_2 from " . TABLE_ADDRESS_BOOK . " ab inner join " . TABLE_COUNTRIES . " c on ab.entry_country_id = c.countries_id  where ab.address_book_id = :address_book_id";
        $select_country_id_sql = $db->bindVars($select_country_id_sql, ':address_book_id', $customers_info['address_book_id'], 'integer');
        $select_country_id_result = $db->Execute($select_country_id_sql);

        if ($select_country_id_result->RecordCount() >= 1) {
            $countries_iso_code_2_address_book = $select_country_id_result->fields['countries_iso_code_2'];
        }
    }

    if(!empty($countries_iso_code_2_address_book)) {
        $countries_iso_code_2 = $countries_iso_code_2_address_book;
    } else {
        if(!empty($customers_info['customers_id'])) {
            $default_address_id_sql = 'select co.countries_iso_code_2 from ' . TABLE_CUSTOMERS . ' c inner join ' . TABLE_ADDRESS_BOOK . ' ab on c.customers_default_address_id = ab.address_book_id inner join ' . TABLE_COUNTRIES . ' co on ab.entry_country_id = co.countries_id where c.customers_id = ' . $customers_info['customers_id'];
            $default_address_id_result = $db->Execute ($default_address_id_sql);
            if ($default_address_id_result->RecordCount() > 0) {
                $countries_iso_code_2 = $default_address_id_result->fields['countries_iso_code_2'];
            }
        }
    }


    return $countries_iso_code_2;
}

function zen_num_change_to_char($num){
    $double=(int)($num/94);
    $start='';
    if($double>=1){
        for($i=1;$i<=$double;$i++){
            $start.=chr(128);
        }
        $start.=chr($num%94+34);
    }else{
        $start=chr($num);
    }

    return $start;
}

/**
 * get products preorder/backorder information
 */
function get_backorder_info($products_id){
    global $db;
    $extra_note = '';
    $stock_info_query = $db->Execute("select ready_days, arrival_date from ".TABLE_STOCK_MANAGER." where products_id='".$products_id."' limit 1");
    if(strtotime($stock_info_query->fields['arrival_date'])>time()){
        $extra_note = sprintf(TEXT_ARRIVAL_DATE, date('m/d/Y',strtotime($stock_info_query->fields['arrival_date'])));
    }elseif($stock_info_query->fields['ready_days']>0){

        $extra_note = sprintf(TEXT_READY_DAYS, $stock_info_query->fields['ready_days']);
    }else{
        $extra_note = sprintf(TEXT_ESTIMATE_DAYS, '5-15');
    }
    return $extra_note;
}

/**
 * 获得用户站内信
 * @author Tianwen.Wan
 * @param int $customers_id
 * @param int $languages_id
 * @param int $is_mobile
 * @param int $limit
 * @param array $filter_data
 * @return array
 */
function get_customers_message_memcache($customers_id, $languages_id, $is_mobile = 0, $limit = 5, $filter_data = array()) {
    global $db, $memcache;
    if(empty($customers_id) || empty($languages_id)) {
        return null;
    }
    $memcache_key = md5('get_customers_message_memcache' . $customers_id . $languages_id . $is_mobile . $limit . json_encode($filter_data));
    $data = $memcache->get($memcache_key);
    if($data && sizeof($data) > 0) {
        return $data;
    }

    $where = "";
    $message_sql = "select mtd.title title_type, mld.title title_list, mtc.auto_id, mtc.customers_id, mtc.is_read, mtc.is_ignore, mtc.is_delete, mtc.date_created from " . TABLE_MESSAGE_TO_CUSTOMERS . " mtc inner join " . TABLE_MESSAGE_TYPE_DESCRIPTION . " mtd on mtd.type_id=mtc.type_id inner join " . TABLE_MESSAGE_LIST_DESCRIPTION . " mld on mld.list_id=mtc.list_id where mtc.customers_id=:customers_id and mtd.languages_id=:languages_id and mld.languages_id=:languages_id and mtc.is_delete=0 and mtc.is_read=0 and is_ignore=0 and is_mobile=:is_mobile" . $where . " order by mtc.auto_id desc limit " . $limit;

    $message_sql=$db->bindVars($message_sql,':customers_id', $customers_id,'integer');
    $message_sql=$db->bindVars($message_sql,':languages_id', $languages_id,'integer');
    $message_sql=$db->bindVars($message_sql,':is_mobile', $is_mobile,'integer');
    $message_result = $db->Execute($message_sql);
    $result_return = array();
    while(!$message_result->EOF) {
        $result_return['list'][] = $message_result->fields;
        $message_result->MoveNext();
    }

    if(!empty($result_return['list'])) {
        $message_sql = "select count(1) count from " . TABLE_MESSAGE_TO_CUSTOMERS . " mtc inner join " . TABLE_MESSAGE_TYPE_DESCRIPTION . " mtd on mtd.type_id=mtc.type_id inner join " . TABLE_MESSAGE_LIST_DESCRIPTION . " mld on mld.list_id=mtc.list_id where mtc.customers_id=:customers_id and mtd.languages_id=:languages_id and mld.languages_id=:languages_id and mtc.is_delete=0 and mtc.is_read=0 and is_ignore=0 and is_mobile=:is_mobile" . $where . " order by mtc.auto_id desc";
        $message_sql=$db->bindVars($message_sql,':customers_id', $customers_id,'integer');
        $message_sql=$db->bindVars($message_sql,':languages_id', $languages_id,'integer');
        $message_sql=$db->bindVars($message_sql,':is_mobile', $is_mobile,'integer');
        $message_result = $db->Execute($message_sql);
        $result_return['count'] = $message_result->fields['count'];

        $memcache->set($memcache_key, $result_return, false, 1);
    }
    return $result_return;
}

/**
 * 添加后台发送给所有客户的站内给到客户站内信表
 * @author Tianwen.Wan
 * @param int $customers_id
 * @return boolean
 */
function add_customers_message($customers_id) {
    global $db;
    if(empty($customers_id)) {
        return true;
    }
    $add_sql = "insert into " . TABLE_MESSAGE_TO_CUSTOMERS . "(customers_id, type_id, list_id, is_read, is_ignore, is_delete, admin_name, date_created) select :customers_id, mtca.type_id, mtca.list_id, 0, 0, 0, mtca.admin_name, NOW() from " . TABLE_MESSAGE_TO_CUSTOMERS_ALL . " mtca inner join " . TABLE_MESSAGE_LIST . " ml on ml.auto_id=mtca.list_id where ml.list_status=10 and date_add(mtca.date_created, interval ml.message_expire_days day) > NOW() and not exists (select customers_id, type_id, list_id from " . TABLE_MESSAGE_TO_CUSTOMERS . " where mtca.type_id=type_id and mtca.list_id=list_id and customers_id=:customers_id) and (select customers_info_id from " . TABLE_CUSTOMERS_INFO . " where customers_info_id=:customers_id and customers_info_date_account_created<mtca.date_created and (customers_info_message_receive_type=30 or (customers_info_message_receive_type=20 and instr(customers_info_message_receive_appoint, concat(',', mtca.type_id, ',')) > 0))) is not null";

    $add_sql=$db->bindVars($add_sql,':customers_id', $customers_id,'integer');
    $add_result = $db->Execute($add_sql);
    return true;
}

function get_solo_product_shipping_package_box_weight($is_calc_volume = 0, $net_weight = 0, $volume_weight = 0) {
    $box_weight = 0;

    if($is_calc_volume) {
        $box_weight = max($volume_weight, $net_weight);
        if($box_weight >= 50000) {
            $box_weight = $box_weight * 0.06;
        } else {
            $box_weight = $box_weight * 0.1;
        }
    } else {
        if($volume_weight >= $net_weight * MODULE_SHIPPING_WEIGHT_ARGUMENT_ONE) {
            if($net_weight >= 20000) {
                $box_weight = $net_weight * MODULE_SHIPPING_WEIGHT_ARGUMENT_TWO;
            } else {
                $box_weight = $net_weight * MODULE_SHIPPING_WEIGHT_ARGUMENT_THREE;
            }
        } else {
            if($net_weight >= 50000) {
                $box_weight = $net_weight * MODULE_SHIPPING_WEIGHT_ARGUMENT_FOUR;
            } else {
                $box_weight = $net_weight * MODULE_SHIPPING_WEIGHT_ARGUMENT_FIVE;
            }
        }
    }
    return round($box_weight, 2);
}

/////////////////////////////////////////////
////
// call additional function files
// prices and quantities
require(DIR_WS_FUNCTIONS . 'functions_prices.php');
// taxes
require(DIR_WS_FUNCTIONS . 'functions_taxes.php');
// gv and coupons
require(DIR_WS_FUNCTIONS . 'functions_gvcoupons.php');
// categories, paths, pulldowns
require(DIR_WS_FUNCTIONS . 'functions_categories.php');
// customers and addresses
require(DIR_WS_FUNCTIONS . 'functions_customers.php');
// lookup information
require(DIR_WS_FUNCTIONS . 'functions_lookups.php');
// shipping method
require(DIR_WS_FUNCTIONS . 'functions_shipping.php');
// promotion method
require(DIR_WS_FUNCTIONS . 'functions_promotion.php');
////
/////////////////////////////////////////////
?>