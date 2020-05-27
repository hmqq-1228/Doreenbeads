<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |   
// | http://www.zen-cart.com/index.php                                    |   
// |                                                                      |   
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  $Id: currencies.php 1969 2005-09-13 06:57:21Z drbyte $
//

////
// Class to handle currencies
// TABLES: currencies
  class currencies {
    var $currencies;

// class constructor
    function currencies() {
      global $db;
      $this->currencies = array();
      $currencies = $db->Execute("select code, title, symbol_left, symbol_right, decimal_point, 
                                         thousands_point, decimal_places, value 
                                  from " . TABLE_CURRENCIES);

      while (!$currencies->EOF) {
	$this->currencies[$currencies->fields['code']] = array('title' => $currencies->fields['title'],
                                                       'symbol_left' => $currencies->fields['symbol_left'],
                                                       'symbol_right' => $currencies->fields['symbol_right'],
                                                       'decimal_point' => $currencies->fields['decimal_point'],
                                                       'thousands_point' => $currencies->fields['thousands_point'],
                                                       'decimal_places' => $currencies->fields['decimal_places'],
                                                       'value' => $currencies->fields['value']);
        $currencies->MoveNext();
      }
    }

// class methods
    function format($number, $calculate_currency_value = true, $currency_type = DEFAULT_CURRENCY, $currency_value = '') {
      if ($calculate_currency_value) {
        $rate = ($currency_value) ? $currency_value : $this->currencies[$currency_type]['value'];
        if ($currency_type == 'EUR') {
          $format_string = number_format(zen_round($number * $rate, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'] . ' ' . $this->currencies[$currency_type]['symbol_left'];
        }else{
           $format_string = $this->currencies[$currency_type]['symbol_left'] .' '. number_format(zen_round($number * $rate, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
        }
// if the selected currency is in the european euro-conversion and the default currency is euro,
// the currency will displayed in the national currency and euro currency
        if ( (DEFAULT_CURRENCY == 'EUR') && ($currency_type == 'DEM' || $currency_type == 'BEF' || $currency_type == 'LUF' || $currency_type == 'ESP' || $currency_type == 'FRF' || $currency_type == 'IEP' || $currency_type == 'ITL' || $currency_type == 'NLG' || $currency_type == 'ATS' || $currency_type == 'PTE' || $currency_type == 'FIM' || $currency_type == 'GRD') ) {
          $format_string .= ' <small>[' . $this->format($number, true, 'EUR') . ']</small>';
        }
      } else {
        if ($currency_type == 'EUR') {
          $format_string = number_format(zen_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'] . ' ' . $this->currencies[$currency_type]['symbol_left'];
        }else{
          $format_string = $this->currencies[$currency_type]['symbol_left'] .' '. number_format(zen_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
        }
      }

      return $format_string;
    }

	function format_cl($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
    if (empty($currency_type)) $currency_type = $_SESSION['currency'];

    if ($calculate_currency_value == true) {
      $rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
      $format_string =  zen_round($number * $rate, $this->currencies[$currency_type]['decimal_places']);
    } else {
      $format_string = zen_round($number, $this->currencies[$currency_type]['decimal_places']);
    }

    if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
      $format_string= '';
    }

    return $format_string;
  }

    function get_value($code) {
      return $this->currencies[$code]['value'];
    }
    function get_symbol_left($code) {
    	return $this->currencies [$code] ['symbol_left'];
    }
    function display_price($products_price, $products_tax, $quantity = 1) {
      return $this->format(zen_add_tax($products_price, $products_tax) * $quantity);
    }
    function format_number($number, $calculate_currency_value = false, $currency_type = '', $currency_value = ''){
    	if (empty($currency_type)) $currency_type = $_SESSION['currency'];
    	if ($calculate_currency_value == true) {
    		$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
    		$format_string = number_format(zen_round($number * $rate, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places']);
    	} else {
    		$format_string = number_format(zen_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places']);
    	}
    
    	if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
    		$format_string= '';
    	}
    
    	return $format_string;
    }
  }
?>