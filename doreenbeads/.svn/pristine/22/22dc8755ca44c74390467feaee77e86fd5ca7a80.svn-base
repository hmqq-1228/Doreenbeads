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
// $Id: wire.php,v 1.0 2004/05/02 Farrukh Saeed
//

  class wire  {
    var $code, $title, $description, $enabled;

// class constructor
    function wire () {
      global $order;
      $this->code = 'wire';
      $this->title = MODULE_PAYMENT_WIRE_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_WIRE_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_WIRE_STATUS == 'True') ? true : false);
			
			
			
	  if ((int)MODULE_PAYMENT_WIRE_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_WIRE_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
      
      
      $this->email_footer = MODULE_PAYMENT_WIRE_TEXT_EMAIL_FOOTER;

    }
    

   
// class methods

function update_status() {
      global $order, $db;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_WIRE_ZONE > 0) ) {
        $check_flag = false;
        $check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_WIRE_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
        while (!$check->EOF) {
          if ($check->fields['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check->fields['zone_id'] == $order->billing['zone_id']) {
            $check_flag = true;
            break;
          }
          $check->MoveNext();
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }
    
    
    function javascript_validation() {
      return false;
    }

    function selection() {
      return array('id' => $this->code,
                   'module' => $this->title);
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      return array('title' => MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION);
    }

    function process_button() {
      return false;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      return false;
    }

    function get_error() {
      return false;
    }

    function check() {
    	global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_WIRE_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
    	global $db, $language;
		if (!defined('MODULE_PAYMENT_WIRE_RECEIVER_FIRST_NAME')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $this->code . '.php');
		
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_WIRE_TEXT_CONFIG_1_1 . "', 'MODULE_PAYMENT_WIRE_STATUS', 'True', '" . MODULE_PAYMENT_WIRE_TEXT_CONFIG_1_2 . "', '6', '1', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Comment by owner', 'MODULE_PAYMENT_WIRE_NOTE', '" . MODULE_PAYMENT_WIRE_NOTES . "' ,'', '6','1','zen_cfg_textarea(', now());");
      $db->Execute('insert into ' . TABLE_CONFIGURATION . ' (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ("' . MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY_BANK . '", "'.MODULE_PAYMENT_WIRE_BENEFICIARY_BANK.'","HSBC Hong Kong", "' . MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY_BANK . '" , "6", "3", now());');
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_WIRE_TEXT_SWIFT_CODE . "', 'MODULE_PAYMENT_WIRE_SWIFT_CODE', 'HSBCHKHHHKH', '" . MODULE_PAYMENT_WIRE_TEXT_SWIFT_CODE . "' , '6', '5', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_WIRE_TEXT_BANK_ADDRESS . "', 'MODULE_PAYMENT_WIRE_BANK_ADDRESS', '1 Queen\'s Road Central, Hong Kong', '" . MODULE_PAYMENT_WIRE_TEXT_BANK_ADDRESS . "' , '6', '6', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY . "', 'MODULE_PAYMENT_WIRE_BENEFICIARY', 'EIGHTSEASONS (HONGKONG) INDUSTRY CO., LIMITED', '" . MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY . "' , '6', '7', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_WIRE_TEXT_ACCOUNT_NO . "', 'MODULE_PAYMENT_WIRE_ACCOUNT_NO', '561 787847 838', '" . MODULE_PAYMENT_WIRE_TEXT_ACCOUNT_NO . "' , '6', '7', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_WIRE_TEXT_CONFIG_8_1 . "', 'MODULE_PAYMENT_WIRE_SORT_ORDER', '5', '" . MODULE_PAYMENT_WIRE_TEXT_CONFIG_8_2 . "', '6', '5', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_WIRE_TEXT_CONFIG_9_1 . "', 'MODULE_PAYMENT_WIRE_ORDER_STATUS_ID', '1', '" . MODULE_PAYMENT_WIRE_TEXT_CONFIG_9_2 . "', '6', '9', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");


    }

    function remove() {
    	global $db;
     

      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");

    }

    function keys() {
      return array(
			'MODULE_PAYMENT_WIRE_STATUS',
			'MODULE_PAYMENT_WIRE_NOTE',
			'MODULE_PAYMENT_WIRE_BENEFICIARY_BANK',
			'MODULE_PAYMENT_WIRE_SWIFT_CODE', 
			'MODULE_PAYMENT_WIRE_BANK_ADDRESS',
			'MODULE_PAYMENT_WIRE_BENEFICIARY', 
			'MODULE_PAYMENT_WIRE_ACCOUNT_NO', 
			'MODULE_PAYMENT_WIRE_SORT_ORDER',
			'MODULE_PAYMENT_WIRE_ORDER_STATUS_ID'
			);
    }
  }
?>
