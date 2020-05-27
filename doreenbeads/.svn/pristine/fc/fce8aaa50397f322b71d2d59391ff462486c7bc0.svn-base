<?php
/**
* 功能: 促销Ajax
* 作者: phc
* 时间: 2015年8月7日
* 文件: promotion_ajax.php
*/ 
require('includes/application_top.php');

$action=$_POST['action']; 

switch($action){
	case 'promotion_vartify':
		promotion_vartify();
		break;
	case 'subject_category_tree':
		subject_category_tree(); 
		break;
	case 'promotion_area_discount_info':
		promotion_area_discount_info();
		break;
		
	default:

		break;
}

function promotion_vartify() {
	global $db;
	$pId = intval($_POST['pId']);
	$pDiscount = intval($_POST['pDiscount']);
	
	$sql = "SELECT COUNT(*) AS data_count FROM ".TABLE_PROMOTION." WHERE promotion_discount = :promotion_discount AND promotion_id != :promotion_id ";
	$sql = $db->bindVars($sql, ':promotion_discount', $pDiscount, 'integer');
	$sql = $db->bindVars($sql, ':promotion_id', $pId, 'integer');
	
	$result=$db->Execute($sql);
	 
	if($result->RecordCount() > 0)
	{
		$return_info = array("isSuccess"=>false,"errorMsg"=>"数据库已经存在折扣为[".$pDiscount."]的促销折扣区!");
	}else 
	{
		$return_info = array("isSuccess"=>true);
	}

	echo json_encode($return_info);
}

function subject_category_tree()
{ 
	global $db;
	$id = intval($_POST['sId']);
	
	$result_html = ''; 
	if($id >0)
	{
		$sql_query_subject_category = "select DISTINCT `first_categories_id`,`second_categories_id`,`three_categories_id`
																		from ".TABLE_SUBJECT_AREAS_PRODUCTS." AS sap
																		inner join  ".TABLE_PRODUCTS_TO_CATEGORIES." AS ptc ON ptc.`products_id` = sap.`products_id`
																		where `areas_id` = ".$id;
		$sql_query_subject_category_result = $db->Execute($sql_query_subject_category);
		
		if($sql_query_subject_category_result->RecordCount() >0)
		{ 	
			$category_tree = array();
					
			while(!$sql_query_subject_category_result->EOF){
				$first_categories_id = $sql_query_subject_category_result->fields['first_categories_id']; 
				$second_categories_id = $sql_query_subject_category_result->fields['second_categories_id'];
				$three_categories_id =  $sql_query_subject_category_result->fields['three_categories_id'];
				
				if(!array_key_exists($first_categories_id, $category_tree))
				{
					$category_tree[$first_categories_id]  = array(
																	"category"=>get_categories_info($first_categories_id),
																	"category_desc"=>get_categories_description($first_categories_id,'1'),
																	"sub_categories" =>array()
																);
				}
				
				if(!array_key_exists($second_categories_id, $category_tree[$first_categories_id]["sub_categories"]))
				{
					$category_tree[$first_categories_id]["sub_categories"][$second_categories_id] = array(
																	"category"=>get_categories_info($second_categories_id),
																	"category_desc"=>get_categories_description($second_categories_id,'1'),
																	"sub_categories" =>array()
																); 
				} 
				
				if($three_categories_id && !array_key_exists($three_categories_id, $category_tree[$first_categories_id]["sub_categories"][$second_categories_id]["sub_categories"]) )
				{
					$category_tree[$first_categories_id]["sub_categories"][$second_categories_id]["sub_categories"][$three_categories_id] =  array( 
							"category"=>get_categories_info($three_categories_id),
							"category_desc"=>get_categories_description($three_categories_id,'1'),
							"sub_categories" =>array()
					);
				} 
				
				$sql_query_subject_category_result->MoveNext();
			} 
			
			if($category_tree)
			{
				foreach ($category_tree as $first_key=>$first_item) {
					$result_html .= zend_format('<option value="{0}" level="{3}" style="font-weight:bold;font-size: 14px;">{1}{2}</option>',$first_key,str_repeat("&nbsp;",0),$first_item["category_desc"]["categories_name"],1);
					if($first_item["sub_categories"])
					{
						foreach ($first_item["sub_categories"] as $second_key=>$second_item) {
							$result_html .= zend_format('<option value="{0}" level="{3}" style="font-size: 12px;">{1}{2}</option>',$second_key,str_repeat("&nbsp;",4),$second_item["category_desc"]["categories_name"],2);
							if($second_item["sub_categories"])
							{
								foreach ($second_item["sub_categories"] as $third_key=>$third_item) { 
									$result_html .= zend_format('<option value="{0}" level="{3}" style="font-size: 10px;">{1}{2}</option>',$third_key,str_repeat("&nbsp;",8),$third_item["category_desc"]["categories_name"],3);
								}
							}
						}
					}
				}
			}
		} 
	}
	
	echo $result_html;
}


function promotion_area_discount_info()
{
	global $db;
	$id = intval($_POST['aId']);
	$related_id = $_POST['related_id'];
	
	$result_json = array(
			"isSuccess"=>true,
			"discount_info"=>"",
			"category_info"=>"",
			"errorMsg"=>""
	);
	
	if($id >0 && $related_id)
	{
		//加载促销区折扣信息
		$promotion_discounts = array();
		
		$sql_query_promotion = "SELECT promotion_id,promotion_discount,promotion_start_time,promotion_end_time,promotion_status,promotion_type 
								FROM ".TABLE_PROMOTION." p  
								WHERE  p.promotion_id IN(".$related_id.") 
								ORDER BY p.promotion_id DESC";
		
		$sql_query_promotion_result = $db->Execute($sql_query_promotion);
		
		if($sql_query_promotion_result->RecordCount() >0)
		{
			while(!$sql_query_promotion_result->EOF){
				
				$promotion_discounts [] = $sql_query_promotion_result->fields;
				
				$sql_query_promotion_result->MoveNext();
			}
		}
		
		//折扣信息
		if($promotion_discounts)
		{
			$promotion_discount_html = '';
			
			$discount_format = '<span style="margin-right: 5px;" class="discount_box">
										<input id="pDiscount{0}" name="pDiscount" value="{0}" type="checkbox">
										<label for="pDiscount{0}">[ID:{0}] {1}% off</label>
									</span>';
			
			foreach ($promotion_discounts as $item) {
				
				$promotion_discount_html .=zend_format($discount_format,$item['promotion_id'],round($item['promotion_discount'],2));
			}
			
			$result_json['discount_info'] = $promotion_discount_html;
		}
		
		
		
		//加载促销区类别信息
		$sql_query_promotion_category = "SELECT DISTINCT `first_categories_id`,`second_categories_id`,`three_categories_id`
									FROM ".TABLE_PROMOTION_PRODUCTS." pp  
									INNER JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." AS ptc ON ptc.products_id = pp.pp_products_id
									WHERE  pp.pp_promotion_id IN(".$related_id.") and pp.pp_is_forbid = 10";
											
		$sql_query_promotion_category_result = $db->Execute($sql_query_promotion_category);
		
		if($sql_query_promotion_category_result->RecordCount() >0)
		{
			$category_tree = array();
				
			while(!$sql_query_promotion_category_result->EOF){
				$first_categories_id = $sql_query_promotion_category_result->fields['first_categories_id'];
				$second_categories_id = $sql_query_promotion_category_result->fields['second_categories_id'];
				$three_categories_id =  $sql_query_promotion_category_result->fields['three_categories_id'];

				if(!array_key_exists($first_categories_id, $category_tree))
				{
					$category_tree[$first_categories_id]  = array(
							"category"=>get_categories_info($first_categories_id),
							"category_desc"=>get_categories_description($first_categories_id,'1'),
							"sub_categories" =>array()
					);
				}

				if(!array_key_exists($second_categories_id, $category_tree[$first_categories_id]["sub_categories"]))
				{
					$category_tree[$first_categories_id]["sub_categories"][$second_categories_id] = array(
							"category"=>get_categories_info($second_categories_id),
							"category_desc"=>get_categories_description($second_categories_id,'1'),
							"sub_categories" =>array()
					);
				}

				if($three_categories_id && !array_key_exists($three_categories_id, $category_tree[$first_categories_id]["sub_categories"][$second_categories_id]["sub_categories"]) )
				{
					$category_tree[$first_categories_id]["sub_categories"][$second_categories_id]["sub_categories"][$three_categories_id] =  array(
							"category"=>get_categories_info($three_categories_id),
							"category_desc"=>get_categories_description($three_categories_id,'1'),
							"sub_categories" =>array()
					);
				}

				$sql_query_promotion_category_result->MoveNext();
			}
			
			//类别信息
			if($category_tree)
			{
				$promotion_category_html = '';
				
				foreach ($category_tree as $first_key=>$first_item) {
					$promotion_category_html .= zend_format('<option value="{0}" level="{3}" style="font-weight:bold;font-size: 14px;">{1}{2}</option>',$first_key,str_repeat("&nbsp;",0),$first_item["category_desc"]["categories_name"],1);
					if($first_item["sub_categories"])
					{
						foreach ($first_item["sub_categories"] as $second_key=>$second_item) {
							$promotion_category_html .= zend_format('<option value="{0}" level="{3}" style="font-size: 12px;">{1}{2}</option>',$second_key,str_repeat("&nbsp;",4),$second_item["category_desc"]["categories_name"],2);
							if($second_item["sub_categories"])
							{
								foreach ($second_item["sub_categories"] as $third_key=>$third_item) {
									$promotion_category_html .= zend_format('<option value="{0}" level="{3}" style="font-size: 10px;">{1}{2}</option>',$third_key,str_repeat("&nbsp;",8),$third_item["category_desc"]["categories_name"],3);
								}
							}
						}
					}
				}
				
				$result_json['category_info'] = $promotion_category_html;
			} 
		}
	}
	
	echo json_encode($result_json);
}

exit(); 
?>