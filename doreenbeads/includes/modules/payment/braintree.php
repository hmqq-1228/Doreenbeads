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

// $Id: westernunion.php,v 1.0 2004/05/02 Farrukh Saeed

//



  class braintree  {

    var $code, $title, $description, $enabled;



// class constructor

    function braintree () {

      global $order ,$db;
	  /*
	    if(isset($order->delivery['country'])){
			$countries = $db->Execute("select c.countries_id from ".TABLE_CUSTOMERS_GC_COUNTRY." cw ,".TABLE_COUNTRIES." c where c.countries_id = cw.countries_id and c.countries_name = '".trim($order->delivery['country'])."'");
			 if($countries->RecordCount() > 0){
				$gc_payment_customers = $db->Execute("select c.customers_id,c.customers_email_address,cw.create_time,operator from ".TABLE_CUSTOMERS_GC." cw ,".TABLE_CUSTOMERS." c where c.customers_id = cw.customers_id and  cw.customers_id = " . (int)$_SESSION['customer_id'] . "");
				if($gc_payment_customers->RecordCount() > 0){
					
				}else{
					return false;
				}
			 }
		}else{
			return false;
		}
		*/
      $this->code = 'braintree';
//      $discount="";
//      if($order->info['total']>=1500){
//      	$discount = MODULE_PAYMENT_WESTERNUNION_TEXT_DISCOUNT;
//      }

      //$this->title = MODULE_PAYMENT_GCCREDITCARD_TEXT_HEAD;

      //$this->description = MODULE_PAYMENT_GCCREDITCARD_TEXT_DESCRIPTION;

      //$this->sort_order = 100;

      //$this->enabled = true;

	  $this->title = MODULE_PAYMENT_BRAINTREE_TEXT_HEAD;

      $this->description = MODULE_PAYMENT_BRAINTREE_TEXT_DESCRIPTION;

      $this->sort_order = 100;

      $this->enabled = true;

			

			

			

//	  if ((int)MODULE_PAYMENT_WESTERNUNION_ORDER_STATUS_ID > 0) {
//
//        $this->order_status = MODULE_PAYMENT_WESTERNUNION_ORDER_STATUS_ID;
//
//      }



      if (is_object($order)) $this->update_status();

      

      

//      $this->email_footer = MODULE_PAYMENT_WESTERNUNION_TEXT_EMAIL_FOOTER;



    }

    



   

// class methods



function update_status() {

//      global $order, $db;



//      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_WESTERNUNION_ZONE > 0) ) {
//
//        $check_flag = false;
//
//        $check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_WESTERNUNION_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
//
//        while (!$check->EOF) {
//
//          if ($check->fields['zone_id'] < 1) {
//
//            $check_flag = true;
//
//            break;
//
//          } elseif ($check->fields['zone_id'] == $order->billing['zone_id']) {
//
//            $check_flag = true;
//
//            break;
//
//          }
//
//          $check->MoveNext();
//
//        }
//
//
//
//        if ($check_flag == false) {
//
//          $this->enabled = false;
//
//        }
//
//      }

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

      return array('title' => MODULE_PAYMENT_GCCREDITCARD_TEXT_DESCRIPTION);

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

//    	global $db;
//
//      if (!isset($this->_check)) {
//
//        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_WESTERNUNION_STATUS'");
//
//        $this->_check = $check_query->RecordCount();
//
//      }
//
//      return $this->_check;
        return 1;

    }



    function install() {
    	global $db, $language;

		if (!defined('MODULE_PAYMENT_GCCREDITCARD_RECEIVER_FIRST_NAME'))

			 include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $this->code . '.php');

}



    function remove() {

    	global $db;

     



      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");



    }



    function keys() {

      return array('MODULE_PAYMENT_WESTERNUNION_STATUS' , 'MODULE_PAYMENT_WESTERNUNION_NOTE','MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME', 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME', 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS', 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP', 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY', 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY', 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE', 'MODULE_PAYMENT_WESTERNUNION_SORT_ORDER','MODULE_PAYMENT_WESTERNUNION_ORDER_STATUS_ID');

    }

  }

?>