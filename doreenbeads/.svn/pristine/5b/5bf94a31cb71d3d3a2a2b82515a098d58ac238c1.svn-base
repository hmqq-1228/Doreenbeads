<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The zen-cart developers                           |
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
// $Id: zones.php 1038 2005-03-18 07:09:17Z ajeh $
//
/*

  Note:
   China Post provides both domestic and international express mail service(EMS). 
  The rates are zone based. For international EMS, there are 11 zones 
  defined by China Post, each of them is a group of countries/areas. For domestic EMS, 
  the zones are not clearly defined by China Post and the rates may vary from area to area. 
  As an example, The domestic zones and rates published by GuangZhou Post on their website 
   are used in the module.
  
  They define 4 domestic zones, each of them is a  group of provinces. Therefore, 
  the module comes with support for 15 zones, 4 domestic and 11 international. 
  This can be easily changed by editing the 2 lines below in the zones constructor 
  that defines $this->num_domestic_zones and $this->num_inter_zones.

  The country codes of some countries/areas in zone 13 are nowhere to find, 
   so they are not inculded in the list: Canary Islands, Channel Islands, Curacao, Saipan, Jersey, St. Barthelemy,
   St. Eustatius, Tahiti, etc. 
  This module is based on zones.php, from which you can get more info on how it works and its limitations.
*/

  class chinapost {
    var $code, $title, $description, $enabled, $num_domestic_zones, $num_inter_zones, $num_zones;

// class constructor
    function chinapost() {
      $this->code = 'chinapost';
      $this->title = MODULE_SHIPPING_CHINAPOST_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_CHINAPOST_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_CHINAPOST_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_CHINAPOST_TAX_CLASS;
      // disable only when entire cart is free shipping
      if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_CHINAPOST_STATUS == 'True') ? true : false);
      }
      $this->num_zones = 12;
    }

// class methods
    function quote($method = '', $adc_shipping_weight = 0, $dest_zone_id = '') {
      global $order, $shipping_weight, $shipping_num_boxes;
      
      $shipping_total_weight = $_SESSION['cart']->show_weight() * 1.12;
      if ($adc_shipping_weight == 0) $adc_shipping_weight = $shipping_total_weight;
      if ($dest_zone_id == '') $dest_zone_id = $order->delivery['country']['iso_code_2'];
      $error = false;
      $err_msg;
      
       //�����������ʡ�ݲ�����Puerto Rico Robbie
      if ($dest_zone_id == 'US' and ($order->delivery['state'] == 'PR' or strstr($order->delivery['state'], 'Puerto Rico'))) {
      	$dest_zone_id = 'PR';
	  }
	  
	  $shipping_cost = $this->calculate($dest_zone_id, $adc_shipping_weight, $shipping_num_boxes, $err_msg);
	  
	  if ($shipping_cost == -1)
	  		$error = true;
	  $deduction = 0;
	  //����󶩵��ۿ�
	  if ($adc_shipping_weight >= MODULE_BIG_ORDER_DIST_MIN_WEIGHT) {
	  	include_once(DIR_WS_MODULES . 'order_total/ot_big_orderd.php');
	  	$big_order_distd = new ot_big_orderd;
	  	$deduction = $_SESSION['cart']->show_deduct_shippingfee();
	  	$big_order_amt = $big_order_distd->calculate_deductions($dest_zone_id, $adc_shipping_weight, $this->code . '_' . $this->code, $errmsg);
	  	if ($big_order_amt > 0 ) $big_order_amt = 0;
	  }
	  $module_title = MODULE_SHIPPING_CHINAPOST_TEXT_TITLE . MODULE_SHIPPING_CHINAPOST_SHIPPING_DAYS;
      if($shipping_num_boxes>1) $module_title = str_replace(')',', ship in '.$shipping_num_boxes.' boxes)',$module_title);
      $shipping_method = ' Total Box Number: '.$shipping_num_boxes;
      
	  if ($dest_zone_id == 'RE' && $order->delivery['postcode'] === '97480') $deduction += 200 / MODULE_SHIPPING_CHIANPOST_CURRENCY;

      if($deduction>0){
      	if(($shipping_cost+$deduction+$big_order_amt)>0&&($shipping_cost+$deduction+$big_order_amt)<5)
      	$cost = 0-$big_order_amt;
      	else 
      	$cost = $shipping_cost+$deduction;
      }
      else{
      		$cost = $shipping_cost+$deduction;
      }
      //echo $cost;exit;
//      $this->quotes = array('id' => $this->code,
//                            'module' =>$module_title,
//                            'methods' => array(array('id' => $this->code,
//                                                     'title' => '',
//                                                     'cost' => $cost-$big_order_amt,
//                                                     'big_orderd' => $big_order_amt)));
      $this->quotes = array('id' => $this->code,
                            'module' =>$module_title,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => '',
                                                     'cost' => $cost,
      												 'big_orderd' => $big_order_amt
                                                 )));
      if ($this->tax_class > 0) {
        $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }
	  
      if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

      if ($error == true) $this->quotes['error'] = $err_msg;//MODULE_SHIPPING_CHINAPOST_INVALID_ZONE;
	  
//      print_r($this->quotes);
      return $this->quotes;
    }
  /**
   * calculate shipping fee here
   *
   * @return unknown
   */
    function calculate($country = '', &$shipping_total_weight, &$num_boxes, &$err_msg){
    	$num_boxes = ceil($shipping_total_weight / 20000);
      	$shipping_weight = $shipping_total_weight / $num_boxes;
      	$dest_zone = 0;
      	$shipping = -1;
      	
    	for ($i=1; $i<=$this->num_zones; $i++) {
	        $zones_table = constant('MODULE_SHIPPING_CHINAPOST_ZONES_' . $i);
	        $zones = split("[,]", $zones_table);
	        if (in_array($country, $zones)) {
	          $dest_zone = $i;
	          break;
	        }
	    }
	    
	    if ($dest_zone == 0) {
	    	$err_msg = MODULE_SHIPPING_CHINAPOST_INVALID_ZONE;
	    	return -1;
	    }
    	$zones_cost = constant('MODULE_SHIPPING_CHINAPOST_COST_' . $dest_zone);
        $cost_table = split("[:,]" , $zones_cost);
        $size = sizeof($cost_table);
        
        if($size == 3){
        	//jessa 2009-12-04 ��ԭ����Ӳ�����Ϊ���´��룬ԭ����$weight = $shipping_weight/500
        	$weight = $shipping_weight/($cost_table[0]*1000);
        	//eof jessa 2009-12-04
        	$addNum =$shipping_weight>0?ceil($weight-1):0;
        	$base = $shipping_weight>0?$cost_table[1]:0;
            $shipping = ($base+$addNum*$cost_table[2])*$num_boxes*EMS_DISCOUNT/MODULE_SHIPPING_CHIANPOST_CURRENCY;
        }
        
        if ($shipping == -1) {
        	$err_msg = MODULE_SHIPPING_CHINAPOST_UNDEFINED_RATE.$shipping_weight.$cost_table[0].$cost_table[2].$cost_table[4];
          	return -1;
        }

        return ($shipping + constant('MODULE_SHIPPING_CHINAPOST_HANDLING_' . $dest_zone));
    }
    
    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_CHINAPOST_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;

      $ems_zones[0] = array('HK,MO','0.5:150,30','0');
      $ems_zones[1] = array('JP,KR,MN,KP','0.5:180,40','0');
      $ems_zones[2] = array('KH,MY,SG,TH,VN,ID,PH','0.5:190,45','0');
      $ems_zones[3] = array('AU,NZ,PG,BN,NC','0.5:210,55','0');
      $ems_zones[4] = array('BE,DK,FI,GR,DE,IE,IT,LU,MT,NL,NO,PT,SE,CH,GB,AT,FR,ES,VU,FJ','0.5:280,75','0');
      $ems_zones[5] = array('US,CA','0.5:240,75','0');
      $ems_zones[6] = array('LA,NP,PK,LK,TR,BD,IN,GI,LI,MC','0.5:325,90','0');
      $ems_zones[7] = array('BR,CU,GY,AR,CO,MX,PA,PE,BS,BB,BO,CL,CR,UY,DM,DO,EC,PY,SV,GD,GT,HT,HN,JM,TT,VE','0.5:335,100','0');
      $ems_zones[8] = array('BH,CI,DJ,IR,IQ,IL,JO,KE,KW,MG,OM,QA,SN,SY,TN,UG,AE,BW,BF,GH,CY,EG,ET,GA,GL,TD,GN,ML,ZR,MA,MZ,NE,NG,CG,RW,DZ,AO,BZ,BJ,BT,BI,MW,CM,CV,CF,GQ,TG,GM,GW,LB,LS,LR,LY,MV,MR,MU,NA,NI,SA,SC,SL,SO,ZA,SD,SR,SZ,TZ,ZM,YZ,ZW','0.5:445,120','0');
      $ems_zones[9] = array('BY,KY,CZ,KZ,LV,RU,HR,EZ,HU,PL,RO,UA,AF,AL,AS,AD,AI,AG,AM,AW,AZ,NR,BM,BG,MK,KM,CK,GF,GE,GP,GU,IS,TV,LT,MH,MQ,YT,MD,MS,AN,RE,PR,WS,ST,SK,SI,SB,KN,LC,VC,TJ,TO,TM,TC,UZ,VG,VI,YU','0.5:455,120','0');
      $ems_zones[10] = array('TW ','0.5:130,40','0'); 

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('China post EMS Shipping Module', 'MODULE_SHIPPING_CHINAPOST_STATUS', 'True', 'Do you want to provide the service?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax class', 'MODULE_SHIPPING_CHINAPOST_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_CHINAPOST_SORT_ORDER', '0', 'Sort order of China EMS post.', '6', '0', now())");
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('US dollar to RMB Curreny','MODULE_SHIPPING_CHIANPOST_CURRENCY', '7.35','Currency from US to RMB','6','0',now())");
	  
	  for ($i = 1; $i <= $this->num_zones; $i++) {
        $default_countries = '';
      
        $j = $i;
        $zone_name = 'International Zone ' . $j;
        $zone_desc1 = $zone_name . ' Country/Zone';
        $zone_desc2 =  'List this iso code';
        
        $k = $i - 1;

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . $zone_desc1 . "', 'MODULE_SHIPPING_CHINAPOST_ZONES_" . $i ."', '" . $ems_zones[$k][0] . "', '" . $zone_desc2 . " ', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('". $zone_name ." Fee table', 'MODULE_SHIPPING_CHINAPOST_COST_" . $i ."', '" . $ems_zones[$k][1]  ." ', 'For example: 3:8.50,50', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('". $zone_name ." Handler fee', 'MODULE_SHIPPING_CHINAPOST_HANDLING_" . $i."', '". $ems_zones[$k][2] ." ', '" . $zone_name . " Handle fee for shipping', '6', '0', now())");
      }
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_CHINAPOST_STATUS', 'MODULE_SHIPPING_CHINAPOST_TAX_CLASS', 'MODULE_SHIPPING_CHINAPOST_SORT_ORDER','MODULE_SHIPPING_CHIANPOST_CURRENCY');

      for ($i=1; $i<=$this->num_zones; $i++) {
        $keys[] = 'MODULE_SHIPPING_CHINAPOST_ZONES_' . $i;
        $keys[] = 'MODULE_SHIPPING_CHINAPOST_COST_' . $i;
        $keys[] = 'MODULE_SHIPPING_CHINAPOST_HANDLING_' . $i;
      }

      return $keys;
    }
  }
?>