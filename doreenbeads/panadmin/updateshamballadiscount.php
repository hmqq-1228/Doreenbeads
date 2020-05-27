<?php
require('includes/application_top.php');

function zen_get_subcategories(&$subcategories_array, $parent_id = 0) {
    global $db;
    $subcategories_query = "select categories_id
                            from " . TABLE_CATEGORIES . "
                            where parent_id = '" . (int)$parent_id . "'";

    $subcategories = $db->Execute($subcategories_query);

    while (!$subcategories->EOF) {
      $subcategories_array[sizeof($subcategories_array)] = $subcategories->fields['categories_id'];
      if ($subcategories->fields['categories_id'] != $parent_id) {
        zen_get_subcategories($subcategories_array, $subcategories->fields['categories_id']);
      }
      $subcategories->MoveNext();
    }
  }
  
//eof by herbert for exists shambolla products price discount update
		function zen_refresh_existshambolla_products_price($as_product_id, $adc_net_price, $adc_product_weight, $adc_price_times, $ab_special = false, &$as_errmsg){
		echo "<font color='red'>Update discount for product".$as_product_id."<br /></font>";
		global $db;
		
		////postage_dist_mana.php 也是用这个参数，不可用常量
		$lds_conf = $db->Execute("Select configuration_value 
				            	    From " . TABLE_CONFIGURATION . "
				           		   Where configuration_key = 'EMS_UK2KG_FEE'");
		$ldc_ems2kg_fee = $lds_conf->fields['configuration_value'];
		echo "ldc_ems2kgfee".$ldc_ems2kg_fee;
		$lds_conf = $db->Execute("Select configuration_value 
				            	    From " . TABLE_CONFIGURATION . "
				           		   Where configuration_key = 'EMS_DISCOUNT'");
		$ldc_ems_dist = $lds_conf->fields['configuration_value'];
		echo "ldc_ems_dist".$ldc_ems_dist;
		
		$ldc_perg_fee = ($ldc_ems2kg_fee * $ldc_ems_dist) / 2000;
		echo "$ldc_perg_fee".$ldc_perg_fee;
		if ($ldc_perg_fee <= 0) {
			$as_errmsg = 'Error, the shipping fee of per gram fee is:' . $ldc_perg_fee;
			return -1;
		}
		echo 
		$ldc_shipping_fee = $ldc_perg_fee * $adc_product_weight;
		echo "ldc_shipping_fee".$ldc_shipping_fee;
		$ldc_price = $adc_net_price + $ldc_shipping_fee;
		echo "aaaa".$adc_net_price;
		
		//dorabeads的都删除t_products_discount_quantity
		$db->Execute('Delete from ' . TABLE_PRODUCTS_DISCOUNT_QUANTITY . ' Where products_id = ' . $as_product_id);
		switch ($adc_price_times) {
			case 4:
				$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
					 (1, " . $as_product_id . ", 3, " . ($adc_net_price * (1 - 0.2) + $ldc_shipping_fee) . "),
					 (2, " . $as_product_id . ", 5, " . ($adc_net_price * (1 - 0.3) + $ldc_shipping_fee) . "),
					 (3, " . $as_product_id . ", 7, " . ($adc_net_price * (1 - 0.35) + $ldc_shipping_fee) . "),
					 (4, " . $as_product_id . ", 10, " . ($adc_net_price * (1 - 0.45) + $ldc_shipping_fee) . "),
					 (4, " . $as_product_id . ", 60, " . ($adc_net_price * (1 - 0.5) + $ldc_shipping_fee) . ")");
				break;
			case 3.2:
				$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
					 (1, " . $as_product_id . ", 3, " . ($adc_net_price * (1 - 0.13) + $ldc_shipping_fee) . "),
					 (2, " . $as_product_id . ", 5, " . ($adc_net_price * (1 - 0.19) + $ldc_shipping_fee) . "),
					 (3, " . $as_product_id . ", 8, " . ($adc_net_price * (1 - 0.31) + $ldc_shipping_fee) . "),
					 (4, " . $as_product_id . ", 60, " . ($adc_net_price * (1 - 0.38) + $ldc_shipping_fee) . ")");
				 break;
			case 2.8:
				$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
					 (1, " . $as_product_id . ", 3, " . ($adc_net_price * (1 - 0.07) + $ldc_shipping_fee) . "),
					 (2, " . $as_product_id . ", 6, " . ($adc_net_price * (1 - 0.21) + $ldc_shipping_fee) . "),
					 (3, " . $as_product_id . ", 30, " . ($adc_net_price * (1 - 0.29) + $ldc_shipping_fee) . ")");
				 break;
			case 2.6:
				$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
					 (1, " . $as_product_id . ", 3, " . ($adc_net_price * (1 - 0.08) + $ldc_shipping_fee ). "),
					 (2, " . $as_product_id . ", 5, " . ($adc_net_price * (1 - 0.15) + $ldc_shipping_fee) . "),
					 (3, " . $as_product_id . ", 30, " . ($adc_net_price * (1 - 0.23) + $ldc_shipping_fee) . ")");
				break;
			case 2.4:
				$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
						 (1, " . $as_product_id . ", 3, " . ($adc_net_price * (1 - 0.08) + $ldc_shipping_fee ). "),
						 (2, " . $as_product_id . ", 5, " . ($adc_net_price * (1 - 0.17) + $ldc_shipping_fee) . "),
						 (3, " . $as_product_id . ", 30, " . ($adc_net_price * (1 - 0.25) + $ldc_shipping_fee) . ")");
				break;
			case 2.2:
				$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
						 (1, " . $as_product_id . ", 3, " . ($adc_net_price * (1 - 0.09) + $ldc_shipping_fee ). "),
						 (2, " . $as_product_id . ", 5, " . ($adc_net_price * (1 - 0.18) + $ldc_shipping_fee) . "),
						 (3, " . $as_product_id . ", 30, " . ($adc_net_price * (1 - 0.27) + $ldc_shipping_fee) . ")");
				break;
			case 2:
				$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
						 (1, " . $as_product_id . ", 3, " . ($adc_net_price * (1 - 0.1) + $ldc_shipping_fee ). "),
						 (2, " . $as_product_id . ", 20, " . ($adc_net_price * (1 - 0.2) + $ldc_shipping_fee ). ")");
				break;
			case 0:
				break;
			 default:
				$as_errmsg = '未正确生成数量折扣表，我不认识价格系数：' . $adc_price_times . ', 请检查是否正确录入。';
				return -1;
		}
		
		return 1;
	}
	function update_products_discount_by_category($categoryid){
	global $db;
	zen_get_subcategories(&$subcategories_array, $categoryid);  
	$catids = "(".implode($subcategories_array,',').")";
	//echo $catids;
	$sql = "select pd.products_id,products_weight,products_net_price,product_price_times from t_products as pd, t_products_to_categories as ptc
where ptc.categories_id in ".$catids." and pd.products_id = ptc.products_id";
	$db->Execute($sql);
	$record = $db->Execute($sql);
	while(!$record->EOF){
		zen_refresh_existshambolla_products_price($record->fields['products_id'],$record->fields['products_net_price'],$record->fields['products_weight'] ,$record->fields['product_price_times']);
		$record->moveNext();
	}
	}
	echo "<div style='text-align:center'><font color='red' style='font-weight:bold'>Update logs:<br /></font></div>";
	update_products_discount_by_category(1527);
?>