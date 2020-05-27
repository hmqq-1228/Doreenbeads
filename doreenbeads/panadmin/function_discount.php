<?php
/**�����ļ� jessa
 * function_discount.php
 * 2010-03-01
 */
//bof by herbert for price discount
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
  
function check_product_in_category($product_id,$cateid=673){
		global $db;
		zen_get_subcategories(&$subcategories_array, $cateid);  
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
//eof by herbert for price discount	
	function zen_insert_product_dist_qty($product_id, $old_price_times, $new_price_times, $product_weight, $old_weight, $new_net_price, $old_net_price){
		global $db;
		$new_insert_proudct = $db->Execute("select products_quantity_order_min from " . TABLE_PRODUCTS . " where products_id = " . $product_id);
		////check whether the product is in shamballa category
		$addgroup = check_product_in_category($product_id);
		if ($new_price_times > 0){
			if ($new_insert_proudct->fields['products_quantity_order_min'] <= 0){
				$db->Execute("update " . TABLE_PRODUCTS . " set products_quantity_order_min = 1, products_discount_type = 1, products_discount_type_from = 1 where products_id = " . $product_id);
			}else{
				$db->Execute("update " . TABLE_PRODUCTS . " set products_discount_type = 1, products_discount_type_from = 1 where products_id = " . $product_id);
			}
			if ($old_price_times != $new_price_times || $new_net_price != $old_net_price || $product_weight != $old_weight){
				
				$db->Execute("delete from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id = " . $product_id);
				if ($new_price_times == 4){
				//��Ϊ�ĸ���𣬼���ԭʼ��1-2����飬һ��Ӧ����5�����Ҫ��¼����ݿ�����ĸ����
					$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
						 (1, " . $product_id . ", 3, 20),
						 (2, " . $product_id . ", 5, 30),
						 (3, " . $product_id . ", 7, 35),
						 (4, " . $product_id . ", 10, 45);");
					//if in shamballa category
					if($addgroup)
						$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(5, " . $product_id . ", 60, 50);");
			
				}elseif($new_price_times == 3.2){
					$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
						 (1, " . $product_id . ", 3, 13),
						 (2, " . $product_id . ", 5, 19),
						 (3, " . $product_id . ", 8, 31);");
					if($addgroup)
						$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(4, " . $product_id . ", 60, 38);");
				}elseif($new_price_times == 2.8){
					$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
						 (1, " . $product_id . ", 3, 7),
						 (2, " . $product_id . ", 6, 21);");
					if($addgroup)
						$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(3, " . $product_id . ", 30, 29);");	 
				}elseif($new_price_times == 2.6){
					$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
						 (1, " . $product_id . ", 3, 8),
						 (2, " . $product_id . ", 5, 15);");
					if($addgroup)
						$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(3, " . $product_id . ", 30, 23);");
				}elseif($new_price_times == 2.4){
					$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
						 (1, " . $product_id . ", 3, 8),
						 (2, " . $product_id . ", 5, 17);");
					if($addgroup)
						$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(3, " . $product_id . ", 30, 25);");
				}
			elseif($new_price_times == 2.2){
					$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
						 (1, " . $product_id . ", 3, 9),
						 (2, " . $product_id . ", 5, 18);");
					if($addgroup)
						$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(3, " . $product_id . ", 30, 27);");
				}
			elseif($new_price_times == 2){
					$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
						 (1, " . $product_id . ", 3, 10);");
					if($addgroup)
						$db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(2, " . $product_id . ", 20, 20);");
				}
			}
		}else{
			$db->Execute("delete from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " where products_id = " . $product_id);
			$db->Execute("update " . TABLE_PRODUCTS . " set products_discount_type = 0, products_discount_type_from = 0 where products_id = " . $product_id);
		}
	}
	
////supplies�ĺ�����ʽ
	////ֻ�� $adc_price_times ����ı��˲ŵ��øú���ɾ��ԭ�е�ֱ��������ӹ�
	function zen_refresh_products_price($as_product_id, $adc_price_times, $ab_special = false, &$as_errmsg){
		global $db;
		//echo "bbb";exit;
		$addgroup = check_product_in_category($as_product_id);
		if ($as_product_id < 0) {
			$as_errmsg = 'δ��ȷ�����Ʒ��ţ�' . $as_product_id . ', δ��ɲ�Ʒ�����ۿۡ�';
			return -1;
		}
//		echo "Delete From " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " Where products_id = " . $as_product_id;
//		exit;
		$db->Execute("Delete From " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " Where products_id = " . $as_product_id);
		switch ($adc_price_times) {
            case 4:
                $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
								 (1, " . $as_product_id . ", 3, 20),
								 (2, " . $as_product_id . ", 5, 30),
								 (3, " . $as_product_id . ", 7, 35),
								 (4, " . $as_product_id . ", 10, 45);");
                if ($addgroup)
                    $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(5, " . $as_product_id . ", 60, 50);");
                break;
            case 3.2:
                $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
								 (1, " . $as_product_id . ", 3, 13),
								 (2, " . $as_product_id . ", 5, 19),
								 (3, " . $as_product_id . ", 8, 31);");
                if ($addgroup)
                    $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(4, " . $as_product_id . ", 60, 38);");
                break;
            case 2.8:
                $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
								 (1, " . $as_product_id . ", 3, 7),
								 (2, " . $as_product_id . ", 6, 21);");
                if ($addgroup)
                    $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(3, " . $as_product_id . ", 30, 29);");
                break;
            case 2.6:
                $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
								 (1, " . $as_product_id . ", 3, 8),
								 (2, " . $as_product_id . ", 5, 15);");
                if ($addgroup)
                    $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(3, " . $as_product_id . ", 30, 23);");
                break;
            case 2.4:
                $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
						 (1, " . $as_product_id . ", 3, 8),
						 (2, " . $as_product_id . ", 5, 17)");
                if ($addgroup)
                    $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(3, " . $as_product_id . ", 30, 25);");
                break;
            case 2.2:
                $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
						 (1, " . $as_product_id . ", 3, 9),
						 (2, " . $as_product_id . ", 5, 18)");
                if ($addgroup)
                    $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(3, " . $as_product_id . ", 30, 27);");
                break;
            case 2:
                $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
						 (1, " . $as_product_id . ", 3, 10)");
                if ($addgroup)
                    $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values 
							(2, " . $as_product_id . ", 20, 20);");
                break;
            default:
                $as_errmsg = 'δ��ȷ��������ۿ۱?�Ҳ���ʶ�۸�ϵ��' . $adc_price_times . ', �����Ƿ���ȷ¼�롣';
                return -1;
		}else{
            switch ($adc_price_times) {
                case 2.8:
                    $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                                 (1, " . $as_product_id . ", 5, 21),
                                 (2, " . $as_product_id . ", 10, 32;");

                    break;
                case 2.2:
                    $db->Execute ( "insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                                 (1, " . $as_product_id . ", 3, 14);" );
                    break;
                case 2:
                    $db->Execute("insert into " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " values
                                 (1, " . $as_product_id . ", 3, 5);");
                    break;
                case 1.9:
                default:
                    break;
            }
        }
		
		return 1;
	}
?>