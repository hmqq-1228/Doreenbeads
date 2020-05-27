<?php
require_once("includes/application_top.php");
// require("solrclient/Apache/Solr/Service.php");
@set_time_limit(600);
ini_set('memory_limit','512M');
$start = microtime(true);
global $db;

$pid_list = array();
$solr_queue = $db->Execute("select products_id from t_solr_logs where status=0 group by products_id order by weight desc");
if($solr_queue->RecordCount()<1) exit;
while(!$solr_queue->EOF){
	if(!in_array($solr_queue->fields['products_id'], $pid_list)){
		$pid_list[] = $solr_queue->fields['products_id'];
	}
	$solr_queue->MoveNext();

}

$solr_cores = array('/solr/dorabeads_1','/solr/dorabeads_2');

//all languages
foreach($solr_cores as $core_name){
	$solr = new Apache_Solr_service(SOLR_HOST , SOLR_PORT ,$core_name);
	if( !$solr->ping() ) {
		echo'Solr server not responding';
		exit;
	}

	foreach($pid_list as $pid){
		$solr->deleteById('en-'.$pid);
		$solr->commit();
		$product_info = $db->Execute("select p.products_qty_box_status,p.products_quantity_order_max,p.products_id as products_id ,products_quantity_order_min,products_model,
									products_price,products_price_sorter,products_image,products_date_added,products_weight,products_name,
									products_description,products_name_without_catg,products_status
								from t_products p, t_products_description pd 
								where p.products_id = pd.products_id and pd.language_id=1 and p.products_id = '".$pid."' limit 1");
		if($product_info->fields['products_status']>0){
			//product to categories
			$categories_query=$db->Execute("select categories_id,first_categories_id,second_categories_id,three_categories_id,four_categories_id,five_categories_id,six_categories_id from t_products_to_categories where products_id='".$product_info->fields['products_id']."'");
			if($categories_query->RecordCount()<1) continue;
			$categories_list=array();
			$categories_name=array();
			while(!$categories_query->EOF){
				$fid=$categories_id->fields['first_categories_id'];
				$sid=$categories_id->fields['second_categories_id'];
				$tid=$categories_id->fields['three_categories_id'];
				$oid=$categories_id->fields['four_categories_id'];
				$iid=$categories_id->fields['five_categories_id'];
				$xid=$categories_id->fields['six_categories_id'];
				$catearray=array($fid,$sid,$tid,$oid,$iid,$xid);
				foreach ($catearray as $cid){
					if(!in_array($cid, $categories_list)){
						$categories_list[] = $cid;
						$cate_name = $db->Execute("select categories_name from t_categories_description where categories_id='".$cid."' and language_id=1");
						$categories_name[] = $cate_name->fields['categories_name'];
					}
				}
				$categories_query->MoveNext();
			}
			$product_info->fields['products_quantity'] = zen_get_products_stock($product_info->fields['products_id']);
			 $doc = array(
                'id' => 'en-'.$product_info->fields['products_id'],
	 			'products_id' =>$product_info->fields['products_id'],
	 			'products_model' => $product_info->fields['products_model'],
	 			'products_image' => $product_info->fields['products_image'],
	 			'products_weight' => $product_info->fields['products_weight'],
	 			'products_date_added' => $product_info->fields['products_date_added'],
	 			'products_name' => $product_info->fields['products_name'],
	 			//'products_name_en' => $product_info->fields['products_name'],
	 			'products_description' => str_replace('&nbsp;', ' ', strip_tags($product_info->fields['products_description'])),
	 			'products_quantity' => $product_info->fields['products_quantity'],
	 			'products_status' => $product_info->fields['products_status'],
	 			'products_price' => $product_info->fields['products_price'],
       		 	'products_price_sorter' => $product_info->fields['products_price_sorter'],
	 			'products_name_without_catg' => $product_info->fields['products_name_without_catg'],
	 			'categories_id' => $categories_list,
                'categories_name' => $categories_name,
                'products_quantity_order_min'=> $product_info->fields['products_quantity_order_min'],
                'products_quantity_order_max'=> $product_info->fields['products_quantity_order_max'],
                'products_qty_box_status'=> $product_info->fields['products_qty_box_status']
            );
			//print_r($doc);
			$solrdoc = new Apache_Solr_Document();
			foreach ( $doc as $solr_key => $solr_value ) {
				$solrdoc->$solr_key = $solr_value;
			}
			try {
				$solr->addDocument( $solrdoc );
				$solr->commit();
				$solr->optimize();
				$db->Execute("update t_solr_logs set status=1, action='update', date_finished='".date('Y-m-d H:i:s')."' where products_id='".$product_info->fields['products_id']."' and status=0");

			}
			catch ( Exception $ex ) {
				echo $ex->getMessage();
			}
		}else{
			$db->Execute("update  t_solr_logs set status=1, action='delete', date_finished='".date('Y-m-d H:i:s')."' where products_id='".$product_info->fields['products_id']."' and status=0");
		}
	}
}

$end = microtime(true);
$duration=round(($end-$start),2);
echo '<br/>indexes are generated in '.$duration.' seconds';
?>