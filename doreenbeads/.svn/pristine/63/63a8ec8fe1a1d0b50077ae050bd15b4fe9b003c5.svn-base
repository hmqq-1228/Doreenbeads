<?php
require('includes/application_top.php');
echo "后面跟  '?status=g' 开始刷。";
if (isset($_GET['status']) && $_GET['status'] == 'g') {

	$is_exist = $db->Execute("select dailydeal_promotion_id from ".TABLE_DAILYDEAL_PROMOTION." where  dailydeal_is_forbid=10 AND group_id=3 ");
	
	if ($is_exist->RecordCount() >0) {
		echo "更新上货...";
		$sql_up = "select max(dailydeal_promotion_id) as id, dailydeal_products_start_date, dailydeal_products_end_date from ".TABLE_DAILYDEAL_PROMOTION." where dailydeal_is_forbid = 10 AND group_id=3 ";
		$max_id_result = $db->Execute($sql_up);
		
		$time_max = date('Y-m-d',strtotime($max_id_result->fields['dailydeal_products_start_date']));
		$time_now = date('Y-m-d',time());
		$day = (strtotime($time_now) - strtotime($time_max))/(24*60*60);
		
		if($day>=2){
		
			$next_sql = "select dailydeal_promotion_id, products_id from " . TABLE_DAILYDEAL_PROMOTION . "  where dailydeal_promotion_id >". $max_id_result->fields['id'] ."  AND dailydeal_is_forbid=20 AND group_id=3 GROUP BY dailydeal_promotion_id order by dailydeal_promotion_id ASC ";
			$next_result = $db->Execute($next_sql);
			$i=0;
			while (!$next_result->EOF){
				$p_q = $db->Execute("select products_id, products_quantity from ".TABLE_PRODUCTS_STOCK." where products_id = ".$next_result->fields['products_id']);
				
				$products_status = get_products_info_memcache($next_result->fields['products_id'],'products_status');
				if($p_q->fields['products_quantity']>0 && $products_status==1){
					$db->Execute("update " . TABLE_DAILYDEAL_PROMOTION . " set dailydeal_products_start_date = now(), dailydeal_products_end_date = DATE_ADD(NOW(),INTERVAL 2 day), dailydeal_is_forbid =10 where dailydeal_promotion_id =".$next_result->fields['dailydeal_promotion_id']) . ' and dailydeal_is_forbid = 20' ;
					
					$i++;		
					remove_product_memcache($next_result->fields['products_id']);
				}
				if($i>14){
					break;
				}
				$next_result->MoveNext();
			}
			
			$pre_sql = "select dailydeal_promotion_id, products_id from " . TABLE_DAILYDEAL_PROMOTION . "  where dailydeal_promotion_id <=". $max_id_result->fields['id'] ."  AND dailydeal_is_forbid=10 AND group_id=3 GROUP BY dailydeal_promotion_id order by dailydeal_promotion_id ASC ";
		
			$pre_result = $db->Execute($pre_sql);
			while (!$pre_result->EOF){
		
				$db->Execute("update " . TABLE_DAILYDEAL_PROMOTION . " set dailydeal_is_forbid =20 where dailydeal_promotion_id =".$pre_result->fields['dailydeal_promotion_id']) ;
				
				$pre_result->MoveNext();
			}			
			echo "上货完成";			
		}
		
	}else{
		echo "第一次上货。。。";
		$init_sql = "select dailydeal_promotion_id, products_id from " . TABLE_DAILYDEAL_PROMOTION . " where  dailydeal_is_forbid=20 AND group_id=3 GROUP BY dailydeal_promotion_id order by dailydeal_promotion_id ASC ";
	
		$init_result = $db->Execute($init_sql);
		$i=0;
		while (!$init_result->EOF){
	
			$p_q = $db->Execute("select products_id, products_quantity from ".TABLE_PRODUCTS_STOCK." where products_id = ".$init_result->fields['products_id']);
	
			$products_status = get_products_info_memcache($init_result->fields['products_id'],'products_status');
	
			if($p_q->fields['products_quantity']>0 && $products_status==1){
				$db->Execute("update " . TABLE_DAILYDEAL_PROMOTION . " set dailydeal_products_start_date = now(), dailydeal_products_end_date = DATE_ADD(NOW(),INTERVAL 2 day), dailydeal_is_forbid = 10 where dailydeal_promotion_id =".$init_result->fields['dailydeal_promotion_id']) . ' and dailydeal_is_forbid = 20';		
				$i++;				
				remove_product_memcache($init_result->fields['products_id']);
			}
			if($i>14){
				break;
			}
			$init_result->MoveNext();
		}
		echo "上货完成";
	}
	
}