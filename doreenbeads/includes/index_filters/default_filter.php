<?php
/**
 * default_filter.php  for index filters
 *
 * index filter for the default product type
 * show the products of a specified manufacturer
 *
 * @package productTypes
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @todo Need to add/fine-tune ability to override or insert entry-points on a per-product-type basis
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: default_filter.php 4770 2006-10-17 05:12:23Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

//	echo 'i am robbie';
  // for alpha_filter_id parameter
  if (isset($_GET['alpha_filter_id']) && (int)$_GET['alpha_filter_id'] > 0) {
    $alpha_sort = " and pd.products_name LIKE '" . chr((int)$_GET['alpha_filter_id']) . "%' ";
  } else {
    $alpha_sort = '';
  }
  
  
  if (!isset($select_column_list)) 
  	$select_column_list = "";
  	
   // show the products of a specified manufacturer
   
//    for the request that contains one parameter of manufacturers_id
//   if (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] != '' ) {
//     if (isset($_GET['filter_id']) && zen_not_null($_GET['filter_id'])) {
// // We are asked to show only a specific category
//       $listing_sql = "select " . $select_column_list . " p.products_id, p.products_type, p.manufacturers_id, p.products_price, p.products_tax_class_id, pd.products_description, if(s.status = 1, s.specials_new_products_price, NULL) AS specials_new_products_price, IF(s.status = 1, s.specials_new_products_price, p.products_price) as final_price, p.products_sort_order, p.product_is_call, p.product_is_always_free_shipping, p.products_qty_box_status, p.products_model
//        from " . TABLE_PRODUCTS . " p 
//        left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id , " .
//        TABLE_PRODUCTS_DESCRIPTION . " pd, " .
//        TABLE_MANUFACTURERS . " m, " .
//        TABLE_PRODUCTS_TO_CATEGORIES . " p2c
//        where p.products_status = 1
//          and p.manufacturers_id = m.manufacturers_id
//          and m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'
//          and p.products_id = p2c.products_id
//          and pd.products_id = p2c.products_id
//          and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
//          and p2c.categories_id = '" . (int)$_GET['filter_id'] . "'" .
//          $alpha_sort;
//     } else {
// // We show them all
//       $listing_sql = "select " . $select_column_list . " p.products_id, p.products_type, p.manufacturers_id, p.products_price, p.products_tax_class_id, pd.products_description, IF(s.status = 1, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status = 1, s.specials_new_products_price, p.products_price) as final_price, p.products_sort_order, p.product_is_call, p.product_is_always_free_shipping, p.products_qty_box_status, p.products_model
//       from " . TABLE_PRODUCTS . " p
//       left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " .
//       TABLE_PRODUCTS_DESCRIPTION . " pd, " .
//       TABLE_MANUFACTURERS . " m
//       where p.products_status = 1
//         and pd.products_id = p.products_id
//         and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
//         and p.manufacturers_id = m.manufacturers_id
//         and m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'" .
//         $alpha_sort;
//     }
//   }

//   else   //no manufaturers
  
//   {
// 	// show the products in a given category
//     if (isset($_GET['filter_id']) && zen_not_null($_GET['filter_id'])) {
// 	  // We are asked to show only specific category
//       $listing_sql = "select " . $select_column_list . " p.products_id, p.products_type, p.manufacturers_id, p.products_price, p.products_tax_class_id, pd.products_description, IF(s.status = 1, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status = 1, s.specials_new_products_price, p.products_price) as final_price, p.products_sort_order, p.product_is_call, p.product_is_always_free_shipping, p.products_qty_box_status, p.products_model
//       from " . TABLE_PRODUCTS . " p 
//       left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " .
//       TABLE_PRODUCTS_DESCRIPTION . " pd, " .
//       TABLE_MANUFACTURERS . " m, " .
//       TABLE_PRODUCTS_TO_CATEGORIES . " p2c
//       where p.products_status = 1
//         and p.manufacturers_id = m.manufacturers_id
//         and m.manufacturers_id = '" . (int)$_GET['filter_id'] . "'
//         and p.products_id = p2c.products_id
//         and pd.products_id = p2c.products_id
//         and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
//         and p2c.categories_id = '" . (int)$current_category_id . "'" .
//         $alpha_sort;
//     }
//     else   //no manufacturers_id no filter 
//     {

//      if($category_depth == 'nested'){
// 		 $listing_sql = "select distinct p.products_id, " . $select_column_list . " p.products_type, p.manufacturers_id, p.products_price, p.products_tax_class_id, pd.products_description, p.products_sort_order, p.product_is_call, p.product_is_always_free_shipping, p.products_qty_box_status, p.products_model, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
// 	       from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " .
// 			       TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c on p2c.products_id = p.products_id
// 	       where p.products_status = 1
//          	 and p.products_id = p2c.products_id
// 	         and pd.products_id = p2c.products_id
// 	         and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
//          and p2c.categories_id in $range_categories " .    
//          $alpha_sort;
// //         echo $listing_sql;
// 	  }	else {
// /* 		$listing_sql = "select " . $select_column_list . " p.products_id, p.products_type, p.manufacturers_id, p.products_price, p.products_tax_class_id, pd.products_description, IF(s.status = 1, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status =1, s.specials_new_products_price, p.products_price) as final_price, p.products_sort_order, p.product_is_call, p.product_is_always_free_shipping, p.products_qty_box_status, p.products_model, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
//        from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " .
//        TABLE_PRODUCTS . " p 
//        left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id, " .
//        TABLE_PRODUCTS_TO_CATEGORIES . " p2c left join " . TABLE_SPECIALS . " s on p2c.products_id = s.products_id
//        where p.products_status = 1
//          and p.products_id = p2c.products_id
//          and pd.products_id = p2c.products_id
//          and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
//          and p2c.categories_id = '" . (int)$current_category_id . "'" .
//          $alpha_sort; */
		
// 		$listing_sql = "select distinct p.products_id, " . $select_column_list . "  p.products_type, p.manufacturers_id, p.products_price, p.products_tax_class_id, pd.products_description, p.products_sort_order, p.product_is_call, p.product_is_always_free_shipping, p.products_qty_box_status, p.products_model, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight
// 	       from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " .
// 			       TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c on p2c.products_id = p.products_id
// 	       where p.products_status = 1
//          	 and p.products_id = p2c.products_id
// 	         and pd.products_id = p2c.products_id
// 	         and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
// 	         and p2c.categories_id = '" . (int)$current_category_id . "'" .
//          	 $alpha_sort;
//       }

//     }
//   }

  if($category_depth == 'nested'){
  	switch (count($cPath_array)){
  		case 1:
  			$categories_str = 'first_categories_id = ' . (int)$current_category_id . '';
  			$categories_filter = ' first_categories_id ';
  			break;
  		case 2:
  			$categories_str = 'second_categories_id = ' . (int)$current_category_id . '';
  			$categories_filter = ' second_categories_id ';
  			break;
  		case 3:
  			$categories_str = 'three_categories_id = ' . (int)$current_category_id . '';
  			$categories_filter = ' three_categories_id ';
  			break;
  		case 4:
  			$categories_str = 'four_categories_id = ' . (int)$current_category_id . '';
  			$categories_filter = ' four_categories_id ';
  			break;
  		case 5:
  			$categories_str = 'five_categories_id = ' . (int)$current_category_id . '';
  			$categories_filter = ' five_categories_id ';
  			break;
  		case 6:
  			$categories_str = 'six_categories_id = ' . (int)$current_category_id . '';
  			$categories_filter = ' six_categories_id ';
  			break;
  		default:
  			$categories_str = 'p2c.categories_id = ' . (int)$current_category_id . '';
  			$categories_filter = 'p2c.categories_id ';
  			break;
  	}
  	$listing_sql = "select " . $select_column_list . " p.products_id,p.products_weight , p.products_type,  ".$filter_id."   p.product_is_call, p.products_qty_box_status, p.products_model, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight, products_limit_stock
	       from ".TABLE_PRODUCTS." p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id  left join  " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c on p2c.products_id = p.products_id left join ".TABLE_CATEGORIES." c on ".$categories_filter." = c.categories_id
	       where
	       pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
	         and  p.products_status = 1
	         and ".$categories_str."
	         and categories_status = 1 group by p.products_id";
  	 
  }	else {
  		
         zen_get_subcategories ( $subcategories_array, (int)$current_category_id);
         $subcategory_id = @implode ( ',', $subcategories_array );
         if (zen_not_null ( $subcategory_id )) {
            $subcategory_id .= ',' . (int)$current_category_id;
            $filter_str = " AND p2c.categories_id in (" . $subcategory_id . ") ";
         } else {
            $filter_str = " AND p2c.categories_id = '" . (int)$current_category_id . "' ";
         }

  	$listing_sql = "select " . $select_column_list . " p.products_id,p.products_weight , p.products_type,  ".$filter_id."   p.product_is_call,  p.products_qty_box_status, p.products_model, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight, products_limit_stock
	       from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " .
  	       TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c on p2c.products_id = p.products_id left join ".TABLE_CATEGORIES." c on p2c.categories_id = c.categories_id
	       where p.products_status = 1
	         and pd.products_id = p2c.products_id
	         and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
	         " .$filter_str. " and categories_status = 1
	          group by p.products_id";
  }

// set the default sort order setting from the Admin when not defined by customer
  if (!isset($_GET['sort']) and PRODUCT_LISTING_DEFAULT_SORT_ORDER != '') {
    $_GET['sort'] = PRODUCT_LISTING_DEFAULT_SORT_ORDER;
  }

  if (isset($column_list)) {
  	//jessa 2010-03-29 �����ж�������������disp_order���ڣ�����ѡ����������ʾ��Ʒ������Ĭ�ϵ���ʾ
  	if ((!isset($_GET['disp_order']) || (isset($_GET['disp_order']) && $_GET['disp_order'] == '')) && !isset($_GET['sort'])){
	    if ((!isset($_GET['sort'])) || (isset($_GET['sort']) && !ereg('[1-8][ad]', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > sizeof($column_list)) ) {
	      for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
	        if (isset($column_list[$i]) && $column_list[$i] == 'PRODUCT_LIST_NAME') {
	          $_GET['sort'] = $i+1 . 'a';
	          $listing_sql .= " order by p.products_sort_order, pd.products_name";
	          break;
	        } else {
				if(strpos($_GET['cPath'],'1711') === false){
					$listing_sql .= " order by p.products_date_added desc, p.products_sort_order, pd.products_name";
				}else{
					//$listing_sql .= " order by p.products_quantity desc, pd.products_name";
					$listing_sql .= " order by  pd.products_name";
				}
	          
	          break;
	        }
	      }
	    }
  	}elseif((isset($_GET['disp_order']) && $_GET['disp_order'] != '') && !isset($_GET['sort'])){
  		$disp_order = $_GET['disp_order'];
      	switch($_GET['disp_order']){
    		case 1:
				$listing_sql .= " order by pd.products_name";
			break;
			case 2:
				$listing_sql .= " order by pd.products_name DESC";
			break;
			case 3:
				$listing_sql .= " order by p.products_price_sorter, pd.products_name";
			break;
			case 4:
				$listing_sql .= " order by p.products_price_sorter DESC, pd.products_name";
			break;
			case 5:
				$listing_sql .= " order by p.products_model";
			break;
			case 6:
			    $listing_sql .= " order by p.products_date_added DESC, pd.products_name";
			break;
			case 7:
				$listing_sql .= " order by p.products_date_added, pd.products_name";
			break;
			case 9:
				$listing_sql .= " order by p.products_ordered DESC, pd.products_name";
//			case 10:
//				$listing_sql .= " order by p.products_quantity desc, pd.products_name";
			break;
			default: 
				$listing_sql .= " order by p.products_date_added DESC, pd.products_name";
			break;
    	}
  	}elseif(isset($_GET['sort']) && $_GET['sort'] == '21d'){
  		$listing_sql .= " order by p.products_ordered desc, pd.products_name";
  	}
  } else {
      $sort_col = substr($_GET['sort'], 0 , 1);
      $sort_order = substr($_GET['sort'], 1);
      $listing_sql .= ' order by ';
      switch ($column_list[$sort_col-1]) {
        case 'PRODUCT_LIST_MODEL':
          $listing_sql .= "p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'PRODUCT_LIST_NAME':
          $listing_sql .= "pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
          break;
        case 'PRODUCT_LIST_MANUFACTURER':
          $listing_sql .= "m.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
//        case 'PRODUCT_LIST_QUANTITY':
//          $listing_sql .= "p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
//          break;
        case 'PRODUCT_LIST_IMAGE':
          $listing_sql .= "pd.products_name";
          break;
        case 'PRODUCT_LIST_WEIGHT':
          $listing_sql .= "p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'PRODUCT_LIST_PRICE':
//          $listing_sql .= "final_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          $listing_sql .= "p.products_price_sorter " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
      }
    }
// optional Product List Filter
  if (PRODUCT_LIST_FILTER > 0) {
    if (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] != '') {
      $filterlist_sql = "select distinct c.categories_id as id, cd.categories_name as name
      from " . TABLE_PRODUCTS . " p, " .
      TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " .
      TABLE_CATEGORIES . " c, " .
      TABLE_CATEGORIES_DESCRIPTION . " cd
      where p.products_status = 1
        and p.products_id = p2c.products_id
        and p2c.categories_id = c.categories_id
        and p2c.categories_id = cd.categories_id
        and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
        and p.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'
      order by cd.categories_name";
    } else {
      $filterlist_sql= "select distinct m.manufacturers_id as id, m.manufacturers_name as name
      from " . TABLE_PRODUCTS . " p, " .
      TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " .
      TABLE_MANUFACTURERS . " m
      where p.products_status = 1
        and p.manufacturers_id = m.manufacturers_id
        and p.products_id = p2c.products_id
        and p2c.categories_id = '" . (int)$current_category_id . "'
      order by m.manufacturers_name";
    }
    $do_filter_list = false;
    $filterlist = $db->Execute($filterlist_sql);
    if ($filterlist->RecordCount() > 1) {
        $do_filter_list = true;
      if (isset($_GET['manufacturers_id'])) {
        $getoption_set =  true;
        $get_option_variable = 'manufacturers_id';
        $options = array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES));
      } else {
        $options = array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS));
      }
      while (!$filterlist->EOF) {
        $options[] = array('id' => $filterlist->fields['id'], 'text' => $filterlist->fields['name']);
        $filterlist->MoveNext();
      }
    }
  }

// Get the right image for the top-right
  $image = DIR_WS_TEMPLATE_IMAGES . 'table_background_list.gif';
  if (isset($_GET['manufacturers_id'])) {
    $sql = "select manufacturers_image
              from   " . TABLE_MANUFACTURERS . "
              where      manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'";

    $image_name = $db->Execute($sql);
    $image = $image_name->fields['manufacturers_image'];

  } elseif ($current_category_id) {

    $sql = "select categories_image from " . TABLE_CATEGORIES . "
            where  categories_id = '" . (int)$current_category_id . "'";

    $image_name = $db->Execute($sql);
    $image = $image_name->fields['categories_image'];
  }
?>
