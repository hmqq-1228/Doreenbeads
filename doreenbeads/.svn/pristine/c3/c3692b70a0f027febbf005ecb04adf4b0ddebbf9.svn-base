<?php
switch($current_page_base){
	case 'promotion':
		if(isset ( $_GET ['off'] ) && $_GET ['off'])
		{
			$promotion_off_info = str_replace('_', ',' , $_GET ['off']);
			$refine_by_off = ' AND pm.promotion_id in (' . $promotion_off_info . ')';
		}
		$products_mixed_sql= "SELECT  p.products_id,p2c.categories_id,p2c.first_categories_id,p2c.second_categories_id,p2c.three_categories_id
                                   FROM " . TABLE_PRODUCTS . " p , ".TABLE_PRODUCTS_TO_CATEGORIES." p2c , ".TABLE_PROMOTION." pm , ".TABLE_PROMOTION_PRODUCTS." pp                        
                                   WHERE p.products_status=1 
                                   AND pp.pp_products_id=p.products_id
                                   AND p.products_id=p2c.products_id
                                   AND pp.pp_promotion_id=pm.promotion_id
                                   AND pp.pp_is_forbid = 10
                                   AND pm.promotion_status=1
                                   AND p.master_categories_id=p2c.categories_id
                                   ".$refine_by_off."
                             	   AND pp.pp_promotion_start_time<='".date('Y-m-d H:i:s')."'
                             	   AND pp.pp_promotion_end_time>'".date('Y-m-d H:i:s')."'
                                   ";
		$list_category_array=zen_get_categories_filter($products_mixed_sql);
		 break;
	default:
}
require($template->get_template_dir('tpl_category_refine.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_category_refine.php');
