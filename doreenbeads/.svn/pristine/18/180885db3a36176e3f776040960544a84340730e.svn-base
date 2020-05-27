<?php	
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
  
function check_product_in_category($product_id,$cateid=1527){
		global $db;

		zen_get_subcategories($subcategories_array, $cateid);  

		//var_dump($subcategories_array);exit;
		$sql = "select categories_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id = :products_id";
		$sql = $db->bindVars($sql,':products_id',$product_id,'integer');
		$record = $db->Execute($sql);
		$categories = array();
		while(!$record->EOF){
			$categories[sizeof($categories)] = $record->fields['categories_id'];
			if(in_array($record->fields['categories_id'],$subcategories_array)){
				return true;
			}	
			$record->moveNext();
		}
		return false;
	}					
	function zen_insert_product_dist_qty($product_id, $old_price_times, $new_price_times, $product_weight, $old_weight, $new_net_price, $old_net_price, $kg_free_result = '', $ems_discount = ''){
		global $db;
		////check whether the product is in shamballa category
		$new_insert_proudct = $db->Execute("select products_quantity_order_min from " . TABLE_PRODUCTS . " where products_id = " . $product_id);
		
		if ($new_price_times > 0){
			if ($new_insert_proudct->fields['products_quantity_order_min'] <= 0){
				$db->Execute("update " . TABLE_PRODUCTS . " set products_quantity_order_min = 1, products_discount_type = 2, products_discount_type_from = 1 where products_id = " . $product_id);
			}else{
				$db->Execute("update " . TABLE_PRODUCTS . " set products_discount_type = 2, products_discount_type_from = 1 where products_id = " . $product_id);
			}
			if ($old_price_times != $new_price_times || $new_net_price != $old_net_price || $product_weight != $old_weight || $function_kg_free_result != '' || $funciton_ems_discount != ''){
				$airmail_info = get_airmail_info();
				$ldc_perg_fee = MODULE_SHIPPING_AIRMAIL_ARGUMENT * $airmail_info['discount'] / 1000 / MODULE_SHIPPING_CHIANPOST_CURRENCY * 1.1;
				$ldc_shipping_fee = $ldc_perg_fee * $product_weight * $airmail_info['extra_times'];
				$db->Execute("delete from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id = " . $product_id);
				$addgroup = check_product_in_category($product_id);
				
				switch ($new_price_times) {
					case 4:
						$p1 = 0.2;
						$p2 = 0.3;
						$p3 = 0.35;
						break;
					case 3.2:
						$p1 = 0.13;
						$p2 = 0.19;
						$p3 = 0.31;
						break;
					case 2.8:
						$p1 = 0;
						$p2 = 0.07;
						$p3 = 0.1;
						break;
					case 2.6:
						$p1 = 0;
						$p2 = 0.08;
						$p3 = 0.15;
						break;
					case 2.4:
						$p1 = 0;
						$p2 = 0.08;
						$p3 = 0.17;
						break;
					case 2.2:
						$p1 = 0.09;
						$p2 = 0.18;
						$p3 = 0.2;
						break;
					case 2:
						$p1 = 0.09;
						$p2 = 0.1;
						$p3 = 0.15;
						break;
					case 0:
						break;
				}
				$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
					 (1, " . $product_id . ", 1, " . ($new_net_price * (1 - $p1) + $ldc_shipping_fee) . "),
					 (2, " . $product_id . ", 3, " . ($new_net_price * (1 - $p2) + $ldc_shipping_fee) . "),
					 (3, " . $product_id . ", 5, " . ($new_net_price * (1 - $p3) + $ldc_shipping_fee) . ")");				
			}
		}else{
			$db->Execute("delete from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id = " . $product_id);
			$db->Execute("update " . TABLE_PRODUCTS . " set products_discount_type = 0, products_discount_type_from = 0 where products_id = " . $product_id);
		}
	}
	
	function zen_refresh_products_price($as_product_id, $adc_net_price, $adc_product_weight, $old_price_times, $adc_price_times, $ab_special = false, $old_price = '', $update_option_array = array('insert' => false, 'record_log' => true, 'batch_update' => false, 'currrency_last_modified' => null)){
        global $db;
        if($update_option_array['batch_update'] && empty($update_option_array['currrency_last_modified'])) { // 如果批量update，必须指定时间
            return false;
        }

        $price_after_manager = $adc_net_price;
        $airmail_info = get_airmail_info();
        $ldc_perg_fee = MODULE_SHIPPING_AIRMAIL_ARGUMENT * $airmail_info['discount'] / 1000 / MODULE_SHIPPING_CHIANPOST_CURRENCY * 1.1;

        $ldc_shipping_fee = $ldc_perg_fee * $adc_product_weight;

        $products_model_query = $db->Execute('select products_model from ' . TABLE_PRODUCTS . ' where products_id = "' . $as_product_id . '"');
        if($products_model_query->RecordCount() > 0) {
          $products_model = strtoupper($products_model_query->fields['products_model']);
          $is_h_q_product = (substr($products_model, -1) == 'H' || substr($products_model, -1) == 'Q');

          if (!$is_h_q_product) {
              $price_manager_id = $db->Execute('select price_manager_id,products_model,products_price from ' . TABLE_PRODUCTS . ' where products_id = ' . $as_product_id . ' limit 1');

              $update = true;
              $delete = false;
              switch (true) {
                  case ($adc_price_times >= 8) :
                      $p1 = 0;
                      $p2 = 0.125;
                      $p3 = 0.25;
                      break;
                  case ($adc_price_times >= 4 && $adc_price_times < 8) :
                      $p1 = 0.2;
                      $p2 = 0.3;
                      $p3 = 0.35;
                      break;
                  case ($adc_price_times >= 3.2 && $adc_price_times < 4) :
                      $p1 = 0.13;
                      $p2 = 0.19;
                      $p3 = 0.31;
                      break;
                  case ($adc_price_times >= 2.8 && $adc_price_times < 3.2) :
                      $p1 = 0;
                      $p2 = 0.07;
                      $p3 = 0.1;
                      break;
                  case ($adc_price_times >= 2.6 && $adc_price_times < 2.8) :
                      $p1 = 0;
                      $p2 = 0.08;
                      $p3 = 0.15;
                      break;
                  case ($adc_price_times >= 2.4 && $adc_price_times < 2.6) :
                      $p1 = 0;
                      $p2 = 0.08;
                      $p3 = 0.17;
                      break;
                  case ($adc_price_times >= 2.2 && $adc_price_times < 2.4) :
                      $p1 = 0.09;
                      $p2 = 0.18;
                      $p3 = 0.2;
                      break;
                  case ($adc_price_times >= 2 && $adc_price_times < 2.2) :
                      $p1 = 0.09;
                      $p2 = 0.1;
                      $p3 = 0.15;
                      break;
                  default:
                      $p1 = 0;
                      $p2 = 0;
                      $p3 = 0;
                      $update = false;
                      $delete = true;
              }
              //$db->Execute('Delete from ' . TABLE_PRODUCTS_DISCOUNT_QUANTITY . ' Where products_id = ' . $as_product_id);

              $insert_prices = $delete_prices = false;
              if ($update_option_array['insert'] && $adc_price_times >= 2) {
                  $update = false;
                  $insert_prices = true;
              }
              if ($delete == false && $old_price_times != $adc_price_times) {
                  if ($adc_price_times >= 2) {
                      $insert_prices = true;
                  }
                  $delete_prices = true;
              }

              if ($delete) {
                  $delete_prices = true;
              }

              if ($delete_prices) {
                  $db->Execute("DELETE FROM " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " WHERE products_id = " . $as_product_id);
              }

              if ($insert_prices == true) {
                  $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                               (1, " . $as_product_id . ", 1, " . ($price_after_manager * (1 - $p1) + $ldc_shipping_fee) . ", now()),
                               (2, " . $as_product_id . ", 3, " . ($price_after_manager * (1 - $p2) + $ldc_shipping_fee) . ", now()),
                               (3, " . $as_product_id . ", 5, " . ($price_after_manager * (1 - $p3) + $ldc_shipping_fee) . ", now())");
              }

              $where_batch_update = "";
              if ($update_option_array['batch_update'] && !empty($update_option_array['currrency_last_modified'])) {
                  $where_batch_update .= " and last_modified <= '" . $update_option_array['currrency_last_modified'] . "'";
              }

              if ($update && $old_price_times == $adc_price_times) {
                  $db->Execute("update " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " SET discount_price =  CASE discount_qty 
                                WHEN 1 THEN " . ($price_after_manager * (1 - $p1) + $ldc_shipping_fee) . "
                                WHEN 3 THEN " . ($price_after_manager * (1 - $p2) + $ldc_shipping_fee) . "
                                WHEN 5 THEN " . ($price_after_manager * (1 - $p3) + $ldc_shipping_fee) . " 
                                END,
                                last_modified =  now() 
                                WHERE products_id = " . $as_product_id . $where_batch_update
                  );
              }

          } else {
              $db->Execute("DELETE FROM " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " WHERE products_id = " . $as_product_id);
              $price_after_manager = $adc_net_price;

              switch (true) {
                  case ($adc_price_times >= 2.8 && $adc_price_times <= 4):
                      $p1 = 0;
                      $p2 = 0.21;
                      $p3 = 0.32;

                      $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                               (1, " . $as_product_id . ", 1, " . ($price_after_manager * (1 - $p1) + $ldc_shipping_fee) . ", now()),
                               (2, " . $as_product_id . ", 5, " . ($price_after_manager * (1 - $p2) + $ldc_shipping_fee) . ", now()),
                               (3, " . $as_product_id . ", 10, " . ($price_after_manager * (1 - $p3) + $ldc_shipping_fee) . ", now())");

                      break;
                  case ($adc_price_times >= 2.2 && $adc_price_times < 2.8):
                      $p1 = 0;
                      $p2 = 0.14;

                      $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                               (1, " . $as_product_id . ", 1, " . ($price_after_manager * (1 - $p1) + $ldc_shipping_fee) . ", now()),
                               (2, " . $as_product_id . ", 3, " . ($price_after_manager * (1 - $p2) + $ldc_shipping_fee) . ", now())");
                      break;
                  case ($adc_price_times >= 2 && $adc_price_times < 2.2):
                      $p1 = 0;
                      $p2 = 0.05;

                      $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                               (1, " . $as_product_id . ", 1, " . ($price_after_manager * (1 - $p1) + $ldc_shipping_fee) . ", now()),
                               (2, " . $as_product_id . ", 3, " . ($price_after_manager * (1 - $p2) + $ldc_shipping_fee) . ", now())");
                      break;
                  case ($adc_price_times >= 1.6 && $adc_price_times < 2):
                  default:
                      $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                                (1, " . $as_product_id . ", 1, " . ($price_after_manager + $ldc_shipping_fee) . ", now())"
                      );
                      break;
              }


          }

          $ldc_price = $price_after_manager + $ldc_shipping_fee;

          if ($adc_price_times == 0) {
              $db->Execute("Update " . TABLE_PRODUCTS . "
               Set 
                 products_discount_type_from = 1,
                 products_price = " . $ldc_price . ",
                 product_price_times = " . $adc_price_times . "
               Where products_id = " . $as_product_id);
          } else {
              $db->Execute("Update " . TABLE_PRODUCTS . "
                 Set 
                   products_discount_type = 2,
                   products_discount_type_from = 1,
                   products_price = " . $ldc_price . ",
                   product_price_times = " . $adc_price_times . "
                 Where products_id = " . $as_product_id);
              if ($ab_special) {
                  zen_update_products_price_sorter($as_product_id);
              }
          }
          if ($update_option_array['record_log']) {
              $operate_content = '商品 products_price 变更: from ' . $price_manager_id->fields['products_price'] . ' to ' . $ldc_price . ' and products_net_price 变更: from ... ' . $adc_net_price . ' in ' . __FILE__ . ' on line: ' . __LINE__;
              zen_insert_operate_logs($_SESSION ['admin_id'], $price_manager_id->fields['products_model'], $operate_content, 2);
          }
      }
     
      return true;
    }
?>