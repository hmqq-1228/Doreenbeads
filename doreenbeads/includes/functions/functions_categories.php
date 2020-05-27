<?php
/**
 * functions_categories.php
 *
 * @package functions
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_categories.php 6424 2007-05-31 05:59:21Z ajeh $
 */
function zen_get_parent_categories_new(&$categories, $categories_id) {
    global $db;
    $categories_sql = "SELECT parent_id, categories_status FROM " . TABLE_CATEGORIES . " WHERE categories_id = " . (int)$categories_id;
    $categories_query = $db->Execute($categories_sql);
    if($categories_query->RecordCount() > 0){
        $parent_categories = $categories_query->fields['parent_id'];

        if ($parent_categories == 0) return true;

        $category_status = $categories_query->fields['categories_status'] == 1 ?　true : false;
        if($category_status){
            $categories['categories_arr'][sizeof($categories['categories_arr'])] = $parent_categories;
        }else{
            $categories['is_error'] = true;
            return true;
        }

        if ($parent_categories != $categories_id) {
            zen_get_parent_categories_new($categories, $parent_categories);
        }
    }

}
////
function zen_get_categories($categories_array = '', $parent_id = '0', $indent = '', $status_setting = '') {
    global $db;

    if (!is_array($categories_array)) $categories_array = array();

    // show based on status
    if ($status_setting != '') {
        $zc_status = " c.categories_status='" . (int)$status_setting . "' and ";
    } else {
        $zc_status = '';
    }

    $categories_query = "select c.categories_id, cd.categories_name, c.categories_status
                         from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                         where " . $zc_status . "
                         parent_id = '" . (int)$parent_id . "'
                         and c.categories_id = cd.categories_id
                         and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                         order by sort_order, cd.categories_name";

    $categories = $db->Execute($categories_query);

    while (!$categories->EOF) {
        $categories_array[] = array('id' => $categories->fields['categories_id'],
            'text' => $indent . $categories->fields['categories_name']);

        if ($categories->fields['categories_id'] != $parent_id) {
            $categories_array = zen_get_categories($categories_array, $categories->fields['categories_id'], $indent . '&nbsp;&nbsp;', '1');
        }
        $categories->MoveNext();
    }

    return $categories_array;
}

////
// Return all subcategory IDs
// TABLES: categories
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

function zen_get_first_cate($products_id){
    global $db;
    $cPath = zen_get_product_path($products_id);
    $cate = explode('_', $cPath);
    $first_cate = $cate[0];

    if ($first_cate != '') {
        $category_name = get_category_info_memcache($first_cate , 'categories_name' , $_SESSION['languages_id']);
        $first_cate_info = array('categories_id' => $first_cate, 'categories_name' =>$category_name);

        return $first_cate_info;
    }else{
        return '';
    }
}

function zen_get_shopping_cart_category($productsArr){
    global $db, $currencies;
    $first_cate = array();
    $cate_total_arr = array();
    $first_cate_str = '';
    if (isset($_SESSION['customer_id'])){
        $basket_products_query = "select p.products_id from " . TABLE_PRODUCTS . " p, " . TABLE_CUSTOMERS_BASKET . " cb
		                           where customers_id = " . $_SESSION['customer_id'] . " and cb.products_id = p.products_id";
    } else {
        $basket_products_query = "select p.products_id from " . TABLE_PRODUCTS . " p, " . TABLE_CUSTOMERS_BASKET . " cb
		                           where cookie_id = '" . $_SESSION['cookie_cart_id'] . "' and cb.products_id = p.products_id";
    }
    $products = $db->Execute($basket_products_query);
    while (!$products->EOF){
        $product_id = $products->fields['products_id'];
        $cPath = zen_get_product_path($product_id);
        $cate = explode('_', $cPath);
        if (zen_not_null($cate[0]) && !in_array($cate[0], $first_cate)) {
            $first_cate [] = $cate[0];
            $first_cate_str .= $cate[0] . ',';
        }
        $products->MoveNext();
    }
    $first_cate_str = trim(substr($first_cate_str, 0, -1), ',');
    if ($first_cate_str != '') {
        $first_cate_sort = $db->Execute('select c.categories_id from ' . TABLE_CATEGORIES . ' c, '. TABLE_CATEGORIES_DESCRIPTION . ' cd where c.categories_id = cd.categories_id and cd.language_id = ' . $_SESSION['languages_id'] . ' and c.categories_id in (' . $first_cate_str . ') order by c.sort_order, cd.categories_name');
        while (!$first_cate_sort->EOF){
            $cate_total = 0;
            $first_node = true;
            $products_gift = '';
            for($i = 0, $n = sizeof ( $productsArr ); $i < $n; $i ++) {
                if ($products_gift == '' && $_SESSION['gift_id'] == $productsArr [$i] ['id']) {
                    $products_gift = $productsArr [$i];
                }
                if ($productsArr [$i] ['cate_id'] == $first_cate_sort->fields['categories_id']) {
                    if ($first_node) {
                        $first_node = false;
                        $productsArr [$i] ['cate'] = true;
                        $node = $productsArr [$i] ['id'];
                    }
                    $productsArrNew [] = $productsArr [$i];
                    $cate_total += $productsArr [$i] ['total_number'];
                }
            }
            $cate_total_arr [$first_cate_sort->fields['categories_id']] = $currencies->format($cate_total, false);
            $first_cate_sort->MoveNext();
        }
        if ($products_gift != '') {
            array_unshift($productsArrNew, $products_gift);
        }
    }
    return array('productsArr' => $productsArrNew, 'cate_total_arr' => $cate_total_arr);
}

////
// Parse and secure the cPath parameter values
function zen_parse_category_path($cPath) {
// make sure the category IDs are integers
    $cPath_array = array_map('zen_string_to_int', explode('_', $cPath));

// make sure no duplicate category IDs exist which could lock the server in a loop
    $tmp_array = array();
    $n = sizeof($cPath_array);
    for ($i=0; $i<$n; $i++) {
        if (!in_array($cPath_array[$i], $tmp_array)) {
            $tmp_array[] = $cPath_array[$i];
        }
    }

    return $tmp_array;
}

function zen_product_in_category($product_id, $cat_id) {
    global $db;
    $in_cat=false;
    $category_query_raw = "select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "'";
    $category = $db->Execute($category_query_raw);

    while (!$category->EOF) {
        if ($category->fields['categories_id'] == $cat_id) $in_cat = true;
        if (!$in_cat) {
            $parent_categories = get_category_info_memcache($category->fields['categories_id'] , 'parent_id');

            if (($parent_categories !=0) ) {
                if (!$in_cat) $in_cat = zen_product_in_parent_category($product_id, $cat_id, $parent_categories->fields['parent_id']);
            }
        }
        $category->MoveNext();
    }
    return $in_cat;
}

function zen_product_in_parent_category($product_id, $cat_id, $parent_cat_id) {
    global $db;
    if ($cat_id == $parent_cat_id) {
        $in_cat = true;
    } else {
        $parent_categories = get_category_info_memcache((int)$parent_cat_id , 'parent_id');
        if ($parent_categories !=0 && !$incat) {
            $in_cat = zen_product_in_parent_category($product_id, $cat_id, $parent_categories);
        }
    }
    return $in_cat;
}

////
// look up categories product_type
function zen_get_product_types_to_category($lookup) {
    global $db;

    $lookup = str_replace('cPath=','',$lookup);
    $lookup_array = explode('_', $lookup);
    $lookup = $lookup_array[0];

    $sql = "select product_type_id from " . TABLE_PRODUCT_TYPES_TO_CATEGORY . " where category_id='" . (int)$lookup . "'";
    $look_up = $db->Execute($sql);

    if ($look_up->RecordCount() > 0) {
        return $look_up->fields['product_type_id'];
    } else {
        return false;
    }
}

////
// Get all products_id in a Category and its SubCategories
// use as:
// $my_products_id_list = array();
// $my_products_id_list = zen_get_categories_products_list($categories_id)
function zen_get_categories_products_list($categories_id, $include_deactivated = false, $include_child = true, $parent_category = '0', $display_limit = '') {
    global $db;
    global $categories_products_id_list;
    $childCatID = str_replace('_', '', substr($categories_id, strrpos($categories_id, '_')));

    $current_cPath = ($parent_category != '0' ? $parent_category . '_' : '') . $categories_id;

    $sql = "select p.products_id
            from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
            where p.products_id = p2c.products_id
			AND p.products_level <= " . (int)$_SESSION['customers_level'] . "
            and p2c.categories_id = '" . (int)$childCatID . "'" .
        ($include_deactivated ? " and p.products_status = 1" : "") .
        $display_limit;

    $products = $db->Execute($sql);
    while (!$products->EOF) {
        $categories_products_id_list[$products->fields['products_id']] = $current_cPath;
        $products->MoveNext();
    }

    if ($include_child) {
        $subcate = get_category_info_memcache((int)$childCatID, 'subcate');

        if(sizeof($subcate) > 0){
            foreach ($subcate as $child_cate){
                zen_get_categories_products_list($child_cate, $include_deactivated, $include_child, $current_cPath, $display_limit);
            }
        }

    }
    return $categories_products_id_list;
}

//// bof: manage master_categories_id vs cPath
function zen_generate_category_path($id, $from = 'category', $categories_array = '', $index = 0) {
    global $db;

    if (!is_array($categories_array)) $categories_array = array();

    if ($from == 'product') {
        $categories = $db->Execute("select categories_id
                                  from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                                  where products_id = '" . (int)$id . "'");

        while (!$categories->EOF) {
            if ($categories->fields['categories_id'] == '0') {
                $categories_array[$index][] = array('id' => '0', 'text' => TEXT_TOP);
            } else {
                $category = new stdClass();
                $categories_info = get_category_info_memcache($categories->fields['categories_id']);
                $categories_descriotion = get_category_info_memcache($categories->fields['categories_id'], 'detail', $_SESSION['languages_id']);
                if($categories_info){
                    $category->fields =  $categories_info;
                    $category->fields['categories_name'] = $categories_descriotion['categories_name'];
                }

                $categories_array[$index][] = array('id' => $categories->fields['categories_id'], 'text' => $category->fields['categories_name']);
                if ( (zen_not_null($category->fields['parent_id'])) && ($category->fields['parent_id'] != '0') ) $categories_array = zen_generate_category_path($category->fields['parent_id'], 'category', $categories_array, $index);
                $categories_array[$index] = array_reverse($categories_array[$index]);
            }
            $index++;
            $categories->MoveNext();
        }
    } elseif ($from == 'category') {
        $category = new stdClass();
        $categories_info = get_category_info_memcache($id);
        $categories_descriotion = get_category_info_memcache($id, 'detail', $_SESSION['languages_id']);
        if($categories_info){
            $category->fields =  $categories_info;
            $category->fields['categories_name'] = $categories_descriotion['categories_name'];
        }

        $categories_array[$index][] = array('id' => $id, 'text' => $category->fields['categories_name']);
        if ( (zen_not_null($category->fields['parent_id'])) && ($category->fields['parent_id'] != '0') ) $categories_array = zen_generate_category_path($category->fields['parent_id'], 'category', $categories_array, $index);
    }

    return $categories_array;
}

function zen_get_categories_filter($sql){
    global $db;
    $category_all_array=array();
    $featured_category_array=array();
    $has_count_product=array();
    $category_all_sql='select c.categories_id,c.sort_order,c.parent_id,cd.categories_name from  '.TABLE_CATEGORIES.' c , '.TABLE_CATEGORIES_DESCRIPTION.' cd where cd.categories_id=c.categories_id and c.categories_status = 1 and c.left_display = 10 and cd.language_id='.$_SESSION['languages_id'].' ';
    $category_all=$db->Execute($category_all_sql);
    while(!$category_all->EOF){
        $category_all_array[$category_all->fields['categories_id']]=array('sort_order'=>$category_all->fields['sort_order'],'categories_name'=>$category_all->fields['categories_name'],'parent_id'=>$category_all->fields['parent_id']);
        $category_all->MoveNext();
    }
    $featured_products_res=$db->Execute($sql);
    while(!$featured_products_res->EOF){
        $first_cid=$featured_products_res->fields['first_categories_id'];
        $second_cid=$featured_products_res->fields['second_categories_id'];
        $third_cid=$featured_products_res->fields['three_categories_id'];
        $pId=$featured_products_res->fields['products_id'];
        if(isset($_GET['cId'])&&$third_cid==$_GET['cId']){
            $currentCid=$second_cid;
        }
        if($category_all_array[$first_cid]['parent_id']!=0){
            $featured_products_res->MoveNext();continue;
        }
        if($second_cid!=0&&($first_cid!=$category_all_array[$second_cid]['parent_id'])){
            $featured_products_res->MoveNext();continue;
        }
        if($third_cid!=0&&($second_cid!=$category_all_array[$third_cid]['parent_id'])){
            $featured_products_res->MoveNext();continue;
        }

        if($first_cid!=0&&$category_all_array[$first_cid]!=''&&($category_all_array[$second_cid]!=''||$second_cid==0)&&($category_all_array[$third_cid]!=''||$third_cid==0)){
            $fisrt_sort=$category_all_array[$first_cid]['sort_order']?($category_all_array[$first_cid]['sort_order']+34):134;
            $first_cate=zen_num_change_to_char($fisrt_sort).'!'.$category_all_array[$first_cid]['categories_name'];
            $featured_category_array[$first_cate]=array('id'=>$first_cid,'name'=>$category_all_array[$first_cid]['categories_name'],'count'=>($featured_category_array[$first_cate]['count']+1),'level'=>0,'cPath'=>'cPath='.$first_cid);

            if($second_cid!=$first_cid&&$second_cid!=0&&$category_all_array[$second_cid]!=''){
                $second_sort=$category_all_array[$second_cid]['sort_order']?($category_all_array[$second_cid]['sort_order']+34):134;
                $second_cate=zen_num_change_to_char($fisrt_sort).'!'.$category_all_array[$first_cid]['categories_name'].'!'.zen_num_change_to_char($second_sort).'!'.$category_all_array[$second_cid]['categories_name'];
                $featured_category_array[$second_cate]=array('id'=>$second_cid,'name'=>$category_all_array[$second_cid]['categories_name'],'count'=>(!in_array($pId,$has_count_product[$second_cid])?($featured_category_array[$second_cate]['count']+1):$featured_category_array[$second_cate]['count']),'level'=>1,'cPath'=>'cPath='.$first_cid.'_'.$second_cid);

                if($third_cid!=$second_cid&&$third_cid!=$first_cid&&$third_cid!=0&&$category_all_array[$third_cid]!=''){
                    $third_sort=$category_all_array[$third_cid]['sort_order']?($category_all_array[$third_cid]['sort_order']+34):134;
                    $third_cate=zen_num_change_to_char($fisrt_sort).'!'.$category_all_array[$first_cid]['categories_name'].'!'.zen_num_change_to_char($second_sort).'!'.$category_all_array[$second_cid]['categories_name'].'!'.zen_num_change_to_char($third_sort).'!'.$category_all_array[$third_cid]['categories_name'];
                    $featured_category_array[$third_cate]=array('id'=>$third_cid,'name'=>$category_all_array[$third_cid]['categories_name'],'count'=>($featured_category_array[$third_cate]['count']+1),'level'=>2,'cPath'=>'cPath='.$first_cid.'_'.$second_cid.'_'.$third_cid);
                }
            }
            if(!in_array($pId,$has_count_product[$second_cid])){
                $has_count_product[$second_cid][]=$pId;
            }
        }
        $featured_products_res->MoveNext();
    }
    ksort($featured_category_array);
    $new_arr=array_chunk($featured_category_array,sizeof($featured_category_array));
    $featured_category_array[0]=$new_arr[0];
    $featured_category_array[1]=$currentCid;
    return $featured_category_array;
}

function zen_get_category_full_path_info($category_id){
    global $db;
    $path_array=array();
    $parent_cate_query = $db->Execute("select parent_id,categories_name from ".TABLE_CATEGORIES." c , ".TABLE_CATEGORIES_DESCRIPTION." cd where c.categories_id='".$category_id."' and cd.categories_id=c.categories_id and language_id='".$_SESSION['languages_id']."' ");
    if(!empty($parent_cate_query->fields)) {
        $parent_id = $parent_cate_query->fields['parent_id'];
        $cname=$parent_cate_query->fields['categories_name'];
        if($parent_id!='0'){
            $path_array=zen_get_category_full_path_info($parent_id);
        }
        $path_array[]=array('cId'=>$category_id,'cName'=>$cname);
    }
    return $path_array;

}

function zen_get_category_tree($parent_id = '0', $spacing = '0', $exclude = '', $category_tree_array = '', $cate_path='0',  $limit = false, $count=false, $extra_condition = '',$only_child=false, $is_mobilesite = false) {
    /*WSL*/
    global $db,$memcache;

    if ($limit) {
        $limit_count = " limit 1";
    } else {
        $limit_count = '';
    }

    if (!is_array($category_tree_array)) $category_tree_array = array();
    if(!$is_mobilesite){
        $memcache_key_category_description = md5(MEMCACHE_PREFIX . 'get_category_category_description' . $parent_id.(int)$_SESSION['languages_id'] );
        $data_category_description = $memcache->get($memcache_key_category_description);
    }else {
        $memcache_key_category_description = md5(MEMCACHE_PREFIX . 'get_category_category_description_mobilesite' . $parent_id.(int)$_SESSION['languages_id'] );
        $data_category_description = $memcache->get($memcache_key_category_description);
    }
    if($data_category_description || gettype($data_category_description) != 'boolean' ){
        $categories_array = $data_category_description;
    }else{
        if($is_mobilesite == false){
            $categories_result = $db->Execute("select c.categories_id, cd.categories_name, c.parent_id, c.display_pic,c.class_name , c.categories_level
	                                from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
	                                where c.categories_id = cd.categories_id
	                                and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
									and c.categories_status = 1
	    							and c.left_display = 10
	                                and c.parent_id = '" . $parent_id . "'" . " " . $extra_condition . "
	                                order by c.sort_order, cd.categories_name");
        }else{
            $categories_result = $db->Execute("select c.categories_id, cd.categories_name, c.parent_id, c.display_pic,c.class_name , c.categories_level
                                from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                where c.categories_id = cd.categories_id
                                and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
								and c.categories_status = 1
                                and c.parent_id = '" . $parent_id . "'" . " " . $extra_condition . "
                                order by c.sort_order, cd.categories_name");
        }

        if($categories_result->RecordCount() > 0){
            $categories_array = array();
            while(!$categories_result->EOF){
                $categories_array[] = array(
                    'categories_id'   => $categories_result->fields['categories_id'],
                    'categories_name' => $categories_result->fields['categories_name'],
                    'parent_id'		  => $categories_result->fields['parent_id'],
                    'display_pic'	  => $categories_result->fields['display_pic'],
                    'class_name'	  => $categories_result->fields['class_name'],
                );
                $categories_result->MoveNext();
            }
        }
        $memcache->set($memcache_key_category_description,$categories_array,false,604800);
    }

    foreach ($categories_array as $key => $value){
        if ($exclude != $value['categories_id']) {
            $products_count = get_category_info_memcache($value['categories_id'] , 'products_count');
            $count_show = $count ? $products_count : 0;
            $have_subcate = sizeof(get_category_info_memcache($value['categories_id'] , 'subcate')) > 0 ? true : false;
            if($count){
                if($count_show != 0 && $spacing == '0' && $have_subcate){
                    $category_tree_array[] = array('id' => $value['categories_id'], 'text' => $value['categories_name'],'level'=>$spacing,'class'=>'nav_category_'.$spacing,'cPath'=>'cPath='.substr($cate_path.'_'.$value['categories_id'],2),'top_has_sub'=>'true','count'=>$count_show,'pic'=>$value['display_pic'],'class_name'=>$value['class_name'],'categories_level'=>$value['categories_level']);
                }else if($count_show!=0){
                    $category_tree_array[] = array('id' => $value['categories_id'], 'text' => $value['categories_name'],'level'=>$spacing,'class'=>'nav_category_'.$spacing,'cPath'=>'cPath='.substr($cate_path.'_'.$value['categories_id'],2),'top_has_sub'=>'false','count'=>$count_show,'pic'=>$value['display_pic'],'class_name'=>$value['class_name'],'categories_level'=>$value['categories_level']);
                }
            } else {
                if($spacing=='0'&& $have_subcate){
                    $category_tree_array[] = array('id' => $value['categories_id'], 'text' => $value['categories_name'],'level'=>$spacing,'class'=>'nav_category_'.$spacing,'cPath'=>'cPath='.substr($cate_path.'_'.$value['categories_id'],2),'top_has_sub'=>'true','count'=>$count_show,'pic'=>$value['display_pic'],'class_name'=>$value['class_name'],'categories_level'=>$value['categories_level']);
                }else{
                    $category_tree_array[] = array('id' => $value['categories_id'], 'text' => $value['categories_name'],'level'=>$spacing,'class'=>'nav_category_'.$spacing,'cPath'=>'cPath='.substr($cate_path.'_'.$value['categories_id'],2),'top_has_sub'=>'false','count'=>$count_show,'pic'=>$value['display_pic'],'class_name'=>$value['class_name'],'categories_level'=>$value['categories_level']);
                }
            }
        }
        if (!$only_child){
            $category_tree_array = zen_get_category_tree($value['categories_id'], ($spacing+1), $exclude, $category_tree_array,$cate_path.'_'.$value['categories_id'], $limit, $count, $extra_condition,false,$is_mobilesite);
        }
        //$memcache->set($memcache_key, $category_tree_array, false, 604800);
    }

    return $category_tree_array;
}

function zen_get_all_cate_array(){
    global $db, $memcache;
    $result_return = array();
    $memcache_key = md5(MEMCACHE_PREFIX . 'zen_get_all_cate_array' . $_SESSION['languages_id']);
    $data = $memcache->get($memcache_key);
    if(isset($data) && gettype($data) != 'boolean') {
        return $data;
    }
    $get_all_cate_query="select c.categories_id,c.parent_id from ".TABLE_CATEGORIES." c where c.categories_status=1 and c.left_display = 10 and (c.parent_id = 0 or c.parent_id in(select categories_id from ".TABLE_CATEGORIES." where categories_status=1 and left_display = 10)) order by sort_order";
    $get_all_cate=$db->Execute($get_all_cate_query);
    $cateSortNum=34;
    $categoryListShowArray=array();
    if($get_all_cate->RecordCount()>0){
        while(!$get_all_cate->EOF){
            $tmp_array = get_category_info_memcache($get_all_cate->fields['categories_id'], 'detail', $_SESSION['languages_id']);
            $get_all_cate->fields['categories_name'] = $tmp_array['categories_name'];
            if($get_all_cate->fields['categories_name']!=''){
                $result_return[$get_all_cate->fields['categories_id']]=array(
                    'id'=>$get_all_cate->fields['categories_id'],
                    'name'=>$get_all_cate->fields['categories_name'],
                    'parent'=>$get_all_cate->fields['parent_id'],
                    'sort'=>$cateSortNum
                );
                $cateSortNum++;
            }
            $get_all_cate->MoveNext();
        }
        $memcache->set($memcache_key, $result_return, false, 86400);
    }
    return $result_return;
}

function zen_get_category_id_path($category_id){
    global $get_all_cate_array;
    if($get_all_cate_array[$category_id]['parent']!=0){
        $parentArr=zen_get_category_id_path($get_all_cate_array[$category_id]['parent']);
        $catePathInfo['cpath']=$parentArr['cpath'].'_'.$category_id;
        $catePathInfo['csort']=$parentArr['csort'].'-'.zen_num_change_to_char($get_all_cate_array[$category_id]['sort']);
        $catePathInfo['level']=$parentArr['level']+1;
    }else{
        $catePathInfo['cpath']=$category_id;
        $catePathInfo['csort']=zen_num_change_to_char($get_all_cate_array[$category_id]['sort']);
        $catePathInfo['level']=0;
    }
    return $catePathInfo;
}

/**
 * get refine by category tree by solr return category data-max level = 3
 * @param stdClass array $solr_categories
 */
function get_refine_by_category_tree($solr_categories)
{
    $category_tree_refine_by = array();

    $solr_category_array = zend_std_class_array_to_array($solr_categories);

    //get root category
    $root_categories = zen_get_category_tree('0', '0', '', null, '0', false, false, '',true);

    foreach ($root_categories as $category) {
        if(array_key_exists($category['id'],$solr_category_array))
        {
            $category['count'] = $solr_category_array[$category['id']];

            $root_category_bag = array("category"=>$category);

            //get second category
            $second_categories = zen_get_category_tree($category['id'], '0', '', null, '0', false, false, '',true);
            $root_category_sub_categories = array();

            if ($second_categories)
            {
                foreach ($second_categories as $second_category) {
                    if(array_key_exists($second_category['id'],$solr_category_array))
                    {
                        $second_category['count'] = $solr_category_array[$second_category['id']];
                        $second_category_bag = array("category"=>$second_category);

                        //get third category
                        $third_categories = zen_get_category_tree($category['id'], '0', '', null, '0', false, false, '',true);
                        $third_category_sub_categories = array();

                        if ($third_categories)
                        {
                            foreach ($third_categories as $third_category) {
                                if(array_key_exists($third_category['id'],$solr_category_array))
                                {
                                    $third_category['count'] = $solr_category_array[$third_category['id']];
                                    $third_category_bag = array("category"=>$third_category);

                                    $third_category_bag["sub_categories"] = array();

                                    $third_category_sub_categories[] = $third_category_bag;
                                }
                            }
                        }

                        $second_category_bag["sub_categories"] = $third_category_sub_categories;

                        $root_category_sub_categories[] = $second_category_bag;
                    }
                }
            }

            $root_category_bag["sub_categories"] = $root_category_sub_categories;

            //add to bag
            $category_tree_refine_by[] = $root_category_bag;
        }
    }

    return $category_tree_refine_by;
}

function get_listing_display_order($disp_order_default){
    $return_array = array();

    if (!isset($_GET['main_page']) || !zen_not_null($_GET['main_page'])){
        $_GET['main_page'] = 'index';
    }

    if (!isset($_GET['disp_order'])){
        if(strstr($_GET['cPath'], '1705_')){
            $disp_order_default = SORT_CLEARANCE; //clearance
        }

        if(!is_numeric($disp_order_default)){
            $disp_order_default = 30;
        }
        $_GET['disp_order'] = $disp_order_default;
    }

    $solr_order_str = "products_ordered desc, products_quantity desc, products_date_added desc";
    if(WEBSITE_PRODUCTS_SORT_TYPE == "score") {
        $solr_order_str = "extra_score desc, " . $solr_order_str;
    }

    switch ($_GET['disp_order']) {
        case 3:
            $solr_order_str = 'products_price asc';
            $order_by = " order by p.products_price_sorter, p.products_model";
            break;
        case 4:
            $solr_order_str = 'products_price desc';
            $order_by = " order by p.products_price_sorter DESC, p.products_model";
            break;
        case 5:
            $solr_order_str = 'products_model asc';
            $order_by = " order by p.products_model";
            break;
        case 6:
            $solr_order_str = 'products_date_added desc';
            $order_by = " order by p.products_date_added DESC, p.products_model";
            break;
        case 7:
            $solr_order_str = 'products_date_added asc';
            $order_by = " order by p.products_date_added, p.products_model";
            break;
        case 10 :
            $solr_order_str = '';
            $order_by = " order by pd.products_name";
            break;
        case 30:
            if($_GET['cPath']=='2066_2410'){
                $solr_order_str = 'products_quantity desc'; //small pack
            }
            break;
        case 40:
            $solr_order_str = "products_limit_stock desc ,  products_date_added desc";
            break;
        default:
            $solr_order_str = 'products_date_added desc';
            $order_by = " order by p.products_date_added DESC, p.products_model";
            break;

    }
    $return_array['solr_order_str'] = $solr_order_str;
    $return_array['order_by'] = $order_by;

    return $return_array;
}

function zen_product_property_display($item_per_page, $current_page){
    global $db;
    $return_array = array();
    $properties_select = ' ';
    $delArray = array ();
    $getsInfoArray = array ();
    $propertyGet = '';
    $current_time = time();

    if (isset ( $_GET ['cId'] ) && $_GET ['cId'] != 0) {
        $last_category_id = $_GET ['cId'];
    }

    if(isset($_GET['pcount']) && $_GET['pcount']>0){
        $property_by_group = array();
        for($cnt=1;$cnt<=$_GET['pcount'];$cnt++){
            if($_GET['p'.$cnt]>0){
                $propertyGet = '&p'.$cnt.'='.$_GET['p'.$cnt].$propertyGet;
                $getsInfoArray['p'.$cnt] = $_GET['p'.$cnt];
                $delArray[] = 'p'.$cnt;
                $group_query = $db->Execute("select property_group_id from ".TABLE_PROPERTY." where property_id='".zen_db_prepare_input($_GET['p'.$cnt])."' limit 1");
                $property_by_group[$group_query->fields['property_group_id']][] = $_GET['p'.$cnt];
            }
        }

        foreach($property_by_group as $pg=>$pv){
            $properties_select.= ' AND (';
            for($prop_cnt=0; $prop_cnt<sizeof($pv); $prop_cnt++){
                if($prop_cnt>0){
                    $properties_select .= ' OR ';
                }
                $properties_select .= ' properties_id:'.$pv[$prop_cnt];
            }
            $properties_select.=' )';
        }
        $propertyGet = $propertyGet.'&pcount='.$_GET['pcount'];
    }
    $delArray [] = 'pcount';
    $delArray [] = 'page';
    $search_offset = ($current_page - 1) * $item_per_page;
    $solr_select_query = '';
    $extra_select_str=$last_category_id?' AND categories_id:'.$last_category_id.' ':'';

    if(in_array($_GET['pack'], array('0', '1', '2'))){
        $extra_select_str .= ' AND package_size:' . $_GET['pack'];
    }
    if(is_numeric($_GET['products_filter_onsale']) && $_GET['products_filter_onsale'] == 1) {
        $extra_select_str .= ' AND ((+promotion_start_time:[0 TO ' . $current_time . '] AND +promotion_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']) OR (+daily_deal_start_time:[0 TO ' . $current_time . '] AND +daily_deal_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']))';
    }
    if(is_numeric($_GET['products_filter_in_stock']) && $_GET['products_filter_in_stock'] == 1) {
        $extra_select_str .= ' AND -products_quantity:0';
        //$extra_select_str .= ' AND +products_quantity:[1 TO ' . PHP_INT_MAX . ']';
    }
    if(is_numeric($_GET['products_filter_mixed']) && $_GET['products_filter_mixed'] == 1) {
        $extra_select_str .= ' AND is_mixed:1';
    }

    $return_array['delArray'] = $delArray;
    $return_array['propertyGet'] = $propertyGet;
    $return_array['getsInfoArray'] = $getsInfoArray;
    $return_array['extra_select_str'] = $extra_select_str;
    $return_array['search_offset'] = $search_offset;
    $return_array['properties_select'] = $properties_select;
    $return_array['property_by_group'] = $property_by_group;

    return $return_array;
}

function get_product_property_solr($solr, $solr_select_query, $solr_order_str, $search_offset, $item_per_page){
    $return_array = array();

    $condition ['sort'] = $solr_order_str;
    $condition ['facet'] = 'true';
    $condition ['facet.mincount'] = '1';
    $condition ['facet.limit'] = '-1';
    $condition ['facet.field'] = 'properties_id';
    $condition ['f.properties_id.facet.missing'] = 'true';
    $condition ['f.properties_id.facet.method'] = 'enum';
    $condition ['fl'] = 'products_id,is_promotion,is_hot_seller, score,categories_id, tag_id';

    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) {
        $products_display_solr_str = '';
    } else {
        $products_display_solr_str = ' AND is_display:1';
    }
    $solr_select_query .= $products_display_solr_str;

    $count_res = $solr->search ( $solr_select_query, $search_offset, $item_per_page, $condition );
    $return_array['num_products_count'] = $count_res->response->numFound;
    $return_array['properties_facet'] = $count_res->facet_counts->facet_fields->properties_id;
    $return_array['product_all'] = $count_res->response->docs;
    $return_array['products_new_split'] = new splitPageResults ( '', $item_per_page, '', 'page', false, $return_array['num_products_count'] );
    $return_array['condition'] = $condition;

    return $return_array;
}

function zen_get_property($solr, $properties_facet, $current_page_base, $delArray, $getsInfoArray, $property_by_group, $extra_select_str, $normal_category_list_show, $show_matched_property_listing, $search_offset, $item_per_page, $condition){
    global $memcache, $db;

    $return_array = array();
    $pcontents='';
    $properties_str='';
    $properties_group_array=array();
    $properties_show_array=array();
    $getsProInfo=array();
    $propery_count=34;

    foreach($properties_facet as $prop_id=>$cnt){
        if(is_numeric($prop_id)){
            $propery_num= $cnt;
            $property_name = '';
            $property_group_id = '';

            if(isset($memcache)){
                $mem_property_key = 'property_'.$prop_id.'_'.$_SESSION['languages_id'];
                $property_data = $memcache->get($mem_property_key);
                $property_name = $property_data->name;
                $property_group_id = $property_data->group_id;
                $property_sort = intval($property_data->sort_order);
            }
            if($property_name=='' || $property_group_id==''){
                $property_sql_query = $db->Execute('select p.property_id,property_group_id,p.sort_order,pd.property_name from '.TABLE_PROPERTY.' p, '.TABLE_PROPERTY_DESCRIPTION.' pd where pd.property_id=p.property_id and p.property_status=1 and pd.languages_id='.$_SESSION['languages_id'].' and p.property_id = '.(int)$prop_id.' order by p.sort_order,p.property_id');
                if($property_sql_query->RecordCount()>0){
                    $property_name = $property_sql_query->fields['property_name'];
                    $property_group_id = $property_sql_query->fields['property_group_id'];
                    $property_sort = intval($property_sql_query->fields['sort_order']);
                    $mem_data_object = new stdClass;
                    $mem_data_object->name = $property_name;
                    $mem_data_object->group_id = $property_group_id;
                    $mem_data_object->sort_order = $property_sort;
                    if(isset($memcache)) $memcache->set($mem_property_key, $mem_data_object, false, 86400*7);
                }else{
                    continue;
                }
            }
            $properties_group_array[$property_group_id][$prop_id]=
                array(
                    'id'=>$prop_id,
                    'name'=>$property_name,
                    'num'=>$propery_num,
                    'sort'=>zen_num_change_to_char($propery_num+34).'!'.zen_num_change_to_char($propery_count),
                    'sort_order'=>$property_sort
                );
            $propery_count++;
        }
    }

    if(sizeof($properties_group_array)>0){
        $keys_array=array_keys($properties_group_array);
        $keys_str=implode($keys_array, ',');
        $properties_group_query='select pg.property_group_id,pgd.property_group_name, pg.sort_type from '.TABLE_PROPERTY_GROUP.' pg ,'.TABLE_PROPERTY_GROUP_DESCRIPTION.' pgd where pg.property_group_id=pgd.property_group_id and group_status=1 and pgd.languages_id='.$_SESSION['languages_id'].' and pg.property_group_id in ('.$keys_str.')  order by pg.sort_order,pg.property_group_id ';

        $properties_group_result=$db->Execute($properties_group_query);
        while(!$properties_group_result->EOF){
            $properties_show_array[]=array('gid'=>$properties_group_result->fields['property_group_id'],'gname'=>$properties_group_result->fields['property_group_name'],'sort_type'=>$properties_group_result->fields['sort_type']);
            $properties_group_result->MoveNext();
        }
    }

    $pcontents .= '<div class="refinecont" style="display:' . ($normal_category_list_show && $show_matched_property_listing ? 'block' : 'none') . ';">';

    if(sizeof($properties_show_array)>0){
        $pcount=$_GET['pcount'];
        if($pcount){
            $pcontents.= '<p class="tit"><a rel="nofollow" href="'.zen_href_link($current_page_base,zen_get_all_get_params_reverse($delArray)).'">'.TEXT_CLEAR_ALL.'</a></p>';
        }
        $plink=zen_href_link($current_page_base,'p'.($pcount+1).'=%PRONUM%&'.zen_get_all_get_params_reverse(array('pcount','page')).'&pcount='.($pcount+1));
        $pchecknum=0;

        foreach($properties_show_array as $vals){
            $pcontents.= '<dl class="navlist_refine"><dt>'.$vals['gname'].'</dt><dd><ul class="navlist_list">';
            $pcheck=false;
            if($pchecknum<$pcount){
                foreach($getsInfoArray as $pkey=>$pget){
                    if(isset($properties_group_array[$vals['gid']][$pget])){
                        $pcheck=true;
                        $pchecknum++;
                        $pgetKey[$pget]=$pkey;
                        //break;
                    }
                }
            }

            //re-group selected property values
            if($pcheck){
                $properties_select_exclude='';
                foreach($property_by_group as $pg=>$pv){
                    if($pg!=$vals['gid']){
                        $properties_select_exclude.= ' AND (';
                        for($prop_cnt=0;$prop_cnt<sizeof($pv);$prop_cnt++){
                            if($prop_cnt>0) $properties_select_exclude.=' OR ';
                            $properties_select_exclude.=' properties_id:'.$pv[$prop_cnt];
                        }
                        $properties_select_exclude.=' )';
                    }
                }

                $property_solr_query = $extra_select_str . $properties_select_exclude;


                if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) {
                    $products_display_solr_str = '';
                } else {
                    $products_display_solr_str = ' AND is_display:1';
                }
                $property_solr_query .= $products_display_solr_str;

                $solr_property_data = $solr->search($property_solr_query, $search_offset, $item_per_page, $condition);
                $properties_facet_exclude = $solr_property_data->facet_counts->facet_fields->properties_id;

                $properties_group_array[$vals['gid']] = array();

                foreach($properties_facet_exclude as $prop_id=>$cnt){
                    if(is_numeric($prop_id)){
                        $propery_num= $cnt;
                        $property_name = '';
                        $property_group_id = '';
                        if(isset($memcache)){
                            $mem_property_key = 'property_'.$prop_id.'_'.$_SESSION['languages_id'];
                            $property_data = $memcache->get($mem_property_key);
                            $property_name = $property_data->name;
                            $property_group_id = $property_data->group_id;
                            $property_sort = intval($property_data->sort_order);
                        }
                        if($property_name==''){
                            $property_sql_query = $db->Execute('select p.property_id,property_group_id,p.sort_order,pd.property_name from '.TABLE_PROPERTY.' p, '.TABLE_PROPERTY_DESCRIPTION.' pd where pd.property_id=p.property_id and p.property_status=1 and pd.languages_id='.$_SESSION['languages_id'].' and p.property_id = '.(int)$prop_id);
                            if($property_sql_query->RecordCount()>0){
                                $property_name = $property_sql_query->fields['property_name'];
                                $property_group_id = $property_sql_query->fields['property_group_id'];
                                $property_sort = intval($property_sql_query->fields['sort_order']);
                                $mem_data_object = new stdClass;
                                $mem_data_object->name = $property_name;
                                $mem_data_object->group_id = $property_group_id;
                                $mem_data_object->sort_order = $property_sort;
                                if(isset($memcache)) $memcache->set($mem_property_key, $mem_data_object, false, 86400*7);
                            }else{
                                continue;
                            }
                        }
                        if($property_group_id==$vals['gid']){
                            $properties_group_array[$vals['gid']][$prop_id]=
                                array(
                                    'id'=>$prop_id,
                                    'name'=>$property_name,
                                    'num'=>$propery_num,
                                    'sort'=>zen_num_change_to_char($propery_num+34).'!'.zen_num_change_to_char($propery_count),
                                    'sort_order'=>$property_sort
                                );
                        }
                        $propery_count++;

                    }
                }

            }

            $prokey=0;
            if($vals['sort_type']==1){
                $propery_value_list=array_sort($properties_group_array[$vals['gid']],'sort_order','asc');
            }else{
                $propery_value_list=array_sort($properties_group_array[$vals['gid']],'sort','desc');
            }

            foreach($propery_value_list as $pro){
                if(in_array($pro['id'], $getsInfoArray)){
                    $ptrail=$pcount>1?'&pcount='.($pcount-1):'';
                    $pi=1;
                    $pstr='';
                    foreach($getsInfoArray as $gkey=>$gval){
                        if($gval!=$pro['id']){
                            $pstr='p'.$pi.'='.$gval.'&'.$pstr;
                            $pi++;
                        }
                    }

                    $checkLink=zen_href_link($current_page_base,$pstr.zen_get_all_get_params_reverse($delArray).$ptrail);
                    $getsProInfo[$pgetKey[$pro['id']]]=array('id'=>$pro['id'],'name'=>$pro['name'],'link'=>$checkLink);
                    $pcontents.= '<li class="selectedLi"><a rel="nofollow" href="'.$checkLink.'"><input type="checkbox" checked="checked"><span>'.$pro['name'].' ('.$pro['num'].')</span><ins></ins></a></li>';

                }else{
                    if($prokey>5 && !$pcheck){
                        $pcontents.= '<li class="hiddenLi"><a rel="nofollow" href="'.str_replace('%PRONUM%', $pro['id'], $plink).'"><input type="checkbox"><span>'.$pro['name'].' ('.$pro['num'].')</span></a></li>';
                    }else{
                        $pcontents.= '<li><a rel="nofollow" href="'.str_replace('%PRONUM%', $pro['id'], $plink).'"><input type="checkbox"><span>'.$pro['name'].' ('.$pro['num'].')</span></a></li>';
                    }
                }
                $prokey++;
            }
            $pcontents.= '</ul>';
            if(sizeof($properties_group_array[$vals['gid']])>6&& !$pcheck){
                $pcontents.= '<p class="navlist_more" style="display: block;"><a rel="nofollow" href="javascript:void(0);">'.TEXT_MORE_PRO.'...</a></p>';
            }

            $pcontents.= '</dd></dl>';
        }
    }
    $pcontents .= '</div>';

    $return_array['content'] = $pcontents;
    $return_array['getsProInfo'] = $getsProInfo;

    return $return_array;
}

function get_sub_categories_array($current_category_id){
    global $db;
    $return_array = array();

    $subcate = get_category_info_memcache($current_category_id, 'subcate');
    $return_array['subcategories'] = $subcate;

    $categories = array();
    foreach ($return_array['subcategories'] as $category_id){
        $category_info_memcache = get_category_info_memcache($category_id);
        $category_description_memcache = get_category_info_memcache($category_id, 'detail', $_SESSION['languages_id']);
        if($category_info_memcache['categories_status'] == '1' && $category_info_memcache['left_display'] == '10'  && $category_info_memcache['categories_id'] != '1582'){
            $categories[] = array(
                'categories_id'    => $category_info_memcache['categories_id'],
                'categories_name'  => $category_description_memcache['categories_name'],
                'categories_image' => $category_info_memcache['categories_image'],
                'parent_id'		   => $category_info_memcache['parent_id'],
            );
        }
    }

    $return_array['categoies_content'] = $categories;
    $return_array['sizeof_subcate'] = sizeof($return_array['subcategories']);

    return $return_array;
}

function get_product_list_by_property($products_new_split, $product_res){
    $return_array = array();
    $page_name = "product_listing";
    $page_type = 4;

    if ($products_new_split->number_of_rows > 0) {
        $is_products_listing=true;
        $rows = 0;
        $column = 0;
        $customer_basket_products = zen_get_customer_basket();

        foreach($product_res as $products_id){
            $procuct_qty = 0;
            $bool_in_cart = 0;
            $listing = new stdClass();
            $products_info = get_products_info_memcache($products_id);
            $products_info['products_name'] = get_products_description_memcache($products_id,(int)$_SESSION['languages_id']) ;
            $listing->fields = $products_info;
            if (sizeof($listing->fields) == 0) {
                continue;
            }
            $listing->fields['products_quantity'] = zen_get_products_stock($products_id);
            $link = zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing->fields['products_id']);
            // if($_SESSION['languages_id']==3 && $_SESSION['currency']=='RUB'){
            //     $unit_price = '<span class="unit_price_list">'.zen_get_unit_price($products_id).'</span>';
            // }
            $pro_array['maximage'] = '<div class="maximg notLoadNow" style="display: none;"><s></s><span></span><img src="/includes/templates/cherry_zen/images/loading/500.gif" /></div>';
            $discount_amount = zen_show_discount_amount($products_id);
            $pro_array['image'] = ($discount_amount!='' && $discount_amount>0) ? draw_discount_img($discount_amount,'span') : '';
            $pro_array['image'] .= '<a class="proimg" href="'.$link.'"><img src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($listing->fields['products_image'], 130, 130) . '" data-original="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($listing->fields['products_image'], 130, 130) . '" class="lazy lazy-img" id="anchor' . $listing->fields['products_id'] . '"></a>';
            $pro_array['name'] = '<h4><a href="'.$link.'">'.$listing->fields['products_name'].' ['.$listing->fields['products_model'].']</a></h4>';
            $other_package_products_array = get_products_package_id_by_products_id($products_id);

            $show_products_group_of_products = "";
            $products_group_of_products = get_products_group_of_products($_SESSION['languages_id'], $listing->fields['products_model']);
            if(!empty($products_group_of_products)) {
                $left_cursor = $right_cursor = "";
                if(count($products_group_of_products['data']) > 5) {
                    $left_cursor = '<a href="javascript:void(0);"><ins class="left_arrow_grey' . $right_cursor . ' jq_products_multi_design_left"></ins></a>';
                    $right_cursor = '<a href="javascript:void(0);"><ins class="right_arrow' . $right_cursor . ' jq_products_multi_design_right"></ins></a>';
                }
                $show_products_group_of_products .= '<div class="products_multi_design">' . $left_cursor . '<div><ul class="jq_products_multi_design_ul">';
                foreach($products_group_of_products['data'] as $products_group_value) {
                    $current = "";
                    if($listing->fields['products_model'] == $products_group_value['products_model']) {
                        $current .= " current";
                    }
                    $show_products_group_of_products .= '<li id="jq_products_multi_design_li" class="multi' . $current . '"><a title="' . htmlspecialchars($products_group_value['products_name'], ENT_QUOTES) . ' (' . $products_group_value['products_model'] . ')" href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_group_value['products_id']) . '"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_group_value['products_image'], 80, 80) . '" /></a></li>';
                }

                $show_products_group_of_products .= '</ul></div>' . $right_cursor . '</div><div class="clearfix"></div>';
            }

            $show_other_package_div = '';
            if(!empty($other_package_products_array)){
                $show_other_package_div = '<p style=" display:inline-block; float:right;cursor: pointer;><a href="javascript:void(0);" data-id="'.$products_id.'" style="text-decoration:underline;color:#008FED;" onclick="showOtherPackageSize(this);">'.TEXT_OTHER_PACKAGE_SIZE.'</a></p>';
            }
            $pro_array['model'] = $show_products_group_of_products . '<p style="display:inline-block; margin-top:3px;">' . TEXT_MODEL . ': ' . $listing->fields['products_model'].'</p>'.$show_other_package_div;
            $disp_pric = $unit_price.zen_display_products_quantity_discounts_new($listing->fields['products_id'], 'product_listing');
            $pro_array['price'] = $disp_pric != '' ? $disp_pric : zen_get_products_display_price($listing->fields['products_id']);
            
            //	add cart button
            if (zen_has_product_attributes($listing->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {
                $lc_button = '<a rel="nofollow" href="' . zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
            } else {
                if($listing->fields['products_status'] != 1) {
                    $lc_button = '<p class="addwishlist"><div style="background: none repeat scroll 0% 0% rgb(232, 232, 232); width: 75%; margin:  80px auto; border: 1px solid rgb(211, 211, 211); height: 28px; line-height: 28px;  border-radius: 5px; text-align: center;">' . TEXT_REMOVED . '</div></p>';
                } else {
                    if($listing->fields['products_quantity'] > 0){
                        $lc_button = '<div class="successtips_add successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';
                        $lc_button .= '<input class="qty addcart_qty_input" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" id="' . $page_name  .'_' . $listing->fields['products_id'] . '" name="products_id[' . $listing->fields['products_id'] . ']" value="' . ($bool_in_cart ? $procuct_qty : $listing->fields['products_quantity_order_min']) . '" orig_value="' . ($bool_in_cart ? $procuct_qty : $listing->fields['products_quantity_order_min']) . '" /><input type="hidden" id="MDO_' . $listing->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $listing->fields['products_id'] . '" value="'.$procuct_qty.'" /><br />';
                        $min_units = zen_get_products_quantity_min_units_display($listing->fields['products_id']);
                        $lc_button .= '<div class="clearfix"></div>'.($min_units ? '<p>'.$min_units.'</p>' : '') . ($listing->fields['products_limit_stock'] == 1 ? ( '<p>'.sprintf(TEXT_STOCK_HAVE_LIMIT,$listing->fields['products_quantity'])).'</p>' : '');
                        $lc_button .= '<div class="tipsbox"><div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
                        $lc_button .= '<a rel="nofollow" class="'. ($bool_in_cart ? 'icon_updates' : 'icon_addcart') .'" href="javascript:void(0);" id="submitp_' . $listing->fields['products_id'] . '" name="submitp_' .  $listing->fields['products_id'] . '" onclick="Addtocart_list('.$listing->fields['products_id'].','.$page_type.',this); return false;">'. ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART) .'</a></div>';
                        
                        if($listing->fields['is_s_level_product'] == 1){
                            $backtips = '';
                        }
                    }else{
                        $lc_button = '<div class="successtips_add successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';

                        $lc_button .= '<span class="soldout_text"><a rel="nofollow" id="restock_'.$listing->fields['products_id'].'" onclick="beforeRestockNotification(' . $listing->fields['products_id'] . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
                        $lc_button .= '<input type="hidden" id="MDO_' . $listing->fields['products_id'] . '" value="'.$bool_in_cart.'" />
								   <input type="hidden" id="incart_' . $listing->fields['products_id'] . '" value="'.$procuct_qty.'" /><br />';
                        if($listing->fields['is_sold_out'] == 1){
                            $lc_button .= '<a rel="nofollow" class="icon_soldout" href="javascript:void(0);">' . TEXT_SOLD_OUT . '</a>';
                        }else{
                            $lc_button .= '<input class="qty addcart_qty_input" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" id="' . $page_name  .'_' . $listing->fields['products_id'] . '" name="products_id[' . $listing->fields['products_id'] . ']" value="' . ($bool_in_cart ? $procuct_qty : $listing->fields['products_quantity_order_min']) . '" orig_value="' . ($bool_in_cart ? $procuct_qty : $listing->fields['products_quantity_order_min']) . '" />';
                            $lc_button .= '<div class="tipsbox"><div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
                            //						$lc_button .= '<a rel="nofollow" class="icon_backorder" id="submitp_' . $listing->fields['products_id'] . '" onclick="makeSureCart('.$listing->fields['products_id'].','.$page_type.',\''.$page_name.'\',\''.get_backorder_info($listing->fields['products_id']).'\')"  href="javascript:void(0);">' . TEXT_BACKORDER . 'aa</a></div>';
                            $lc_button .= '<a rel="nofollow" class="'. ($bool_in_cart ? 'icon_updates' : 'icon_addcart') .'" href="javascript:void(0);" id="submitp_' . $listing->fields['products_id'] . '" name="submitp_' .  $listing->fields['products_id'] . '" onclick="Addtocart_list('.$listing->fields['products_id'].','.$page_type.',this); return false;">'. ($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_BACKORDER) .'</a></div>';
                            if($listing->fields['is_s_level_product'] == 1){
                                $backtips = '';
                            }else{
                                if($listing->fields['products_stocking_days'] > 7){
                                    $backtips = '<span style="color:#999;float:right;position:relative;text-align:right;line-height:12px;">'. TEXT_AVAILABLE_IN715 . '</span>';
                                }else{
                                    $backtips = '<span style="color:#999;float:right;position:relative;text-align:right;line-height:12px;">'.TEXT_AVAILABLE_IN57.'</span>';
                                }
                            }
                        }
                    }
                    //	add wishlist button
                    if ($current_page != FILENAME_ADVANCED_SEARCH_RESULT){
                        $lc_button .= '<div class="tipsbox"><div class="successtips_add successtips_add3"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
                        $lc_button .= '<a rel="nofollow" class="text" href="javascript:void(0);" id="wishlist_' . $listing->fields['products_id'] . '" name="wishlist_' . $listing->fields['products_id'] . '" onclick="beforeAddtowishlist(' . $listing->fields['products_id'] . ','.$page_type.'); return false;">+ ' . TEXT_CART_MOVE_TO_WISHLIST . '</a></div>';
                    }
                }

            }
            $pro_array['cart'] = $lc_button.$backtips;
            $backtips = '';

            $list_box_contents_property[] = $pro_array;
        }
        $error_categories = false;
    }else{
        $list_box_contents_property = array();
        $list_box_contents_property[0][] = array('params' => 'class="productListing-data"', 'text' => TEXT_NO_PRODUCTS);
        $error_categories = true;
    }

    $return_array['list_box_contents_property'] = $list_box_contents_property;
    $return_array['error_categories'] = $error_categories;

    return $return_array;
}

function get_products_gallery_by_property($products_new_split, $product_res){
    global $db;
    $return_array = array();
    $page_type=8;
    $page_name="quick_view";

    if ($products_new_split->number_of_rows > 0) {
        $row = 0;
        $col = 0;
        $show_products_content = array();
        $is_products_listing=true;
        $customer_basket_products = zen_get_customer_basket();
        foreach($product_res as $products_id){
            $check_products_all = $db->Execute("select p.products_id,p.products_model, p.products_image,p.products_status, p.products_weight,
								 	p.products_price, pd.products_name, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight,is_sold_out
		       						from ".TABLE_PRODUCTS." p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id
		       						where pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
		       						and p.products_id='".$products_id."'");
            if ($check_products_all->RecordCount() == 0) {
                continue;
            }
            $check_products_all->fields['products_quantity'] = zen_get_products_stock($products_id);
            $is_s_level_product = get_products_info_memcache($products_id, 'is_s_level_product');
            $products_stock_days = get_products_info_memcache($products_id, 'products_stocking_days');
            
            $procuct_qty = 0;
            $bool_in_cart = 0;

            $link = zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $check_products_all->fields['products_id']);
            $discount_amount = zen_show_discount_amount($check_products_all->fields['products_id']);
            $pro_array['image'] = $discount_amount!='' && $discount_amount>0 ? draw_discount_img($discount_amount,'span') : '';
            $pro_array['image'] .= '<a href="' . $link . '"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/310.gif" data-size="310" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($check_products_all->fields['products_image'], 310, 310) . '" alt="' . htmlspecialchars(zen_clean_html($check_products_all->fields['products_name'])) . '" title="' . htmlspecialchars(zen_clean_html($check_products_all->fields['products_name']).' ['.$check_products_all->fields['products_model'].']') . '"></a>';

            $other_package_products_array = get_products_package_id_by_products_id($products_id);
            $show_other_package_div = '';
            if(!empty($other_package_products_array)){
                $show_other_package_div = '<p style="text-align:center;padding:0"><a href="javascript:void(0);" data-id="'.$products_id.'" style="text-decoration:underline;color:#008FED;cursor: pointer;" onclick="showOtherPackageSize(this);">'.TEXT_OTHER_PACKAGE_SIZE.'</a></p>';
            }

            $pro_array['name'] = $show_other_package_div . '<h4><a href="' . $link . '">' . getstrbylength(htmlspecialchars(zen_clean_html($check_products_all->fields['products_name'])), 54) . '&nbsp;[' .$check_products_all->fields['products_model'] . ']</a></h4>';

            $unit_price = zen_get_unit_price($products_id);
            if($_SESSION['languages_id']==3 && $_SESSION['currency']=='RUB' && $unit_price!=''){
                $text_price = '<p class="unit_price_gallery">'.$unit_price.'</p>';
            }else{
                $text_price = '<p class="price">'.zen_get_products_display_price_new($check_products_all->fields['products_id'], 'quick_browse_display').'</p>';
            }
            $pro_array['price'] = $text_price;
            $pro_array['cart'] = '<div class="protips" style=""><p>';
            
            $products_quantity = $check_products_all->fields['products_quantity'];
            if($check_products_all->fields['products_status'] != 1) {
                $pro_array['cart'] = '<p class="addwishlist"><div style="background: none repeat scroll 0% 0% rgb(232, 232, 232); width: 75%; margin:  0px auto; border: 1px solid rgb(211, 211, 211); height: 28px; line-height: 28px;  border-radius: 5px; text-align: center;">' . TEXT_REMOVED . '</div></p>';
            } else {
                if($products_quantity > 0){
                    $pro_array['cart'] .= '<input class="qty addcart_qty_input 1" maxlength="5" type="text" id="'.$page_name.'_'.$check_products_all->fields['products_id'].'" name="products_id[' . $check_products_all->fields['products_id'] . ']" value="'.($bool_in_cart ? $procuct_qty : $check_products_all->fields['products_quantity_order_min']).'" orig_value="'.($bool_in_cart ? $procuct_qty : $check_products_all->fields['products_quantity_order_min']).'" /><input type="hidden" id="MDO_' . $check_products_all->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $check_products_all->fields['products_id'] . '" value="'.$procuct_qty.'" />';
                    $pro_array['cart'] .= '<a rel="nofollow" class="'. ($bool_in_cart ? 'icon_updates' : 'icon_addcart') .'" title="'.($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART).'" id="submitp_' . $check_products_all->fields['products_id'] . '" name="submitp_' .  $check_products_all->fields['products_id'] . '" onclick="Addtocart_list('.$check_products_all->fields['products_id'].','.$page_type.',this); return false;" href="javascript:void(0);"></a>';
                    
                    if($is_s_level_product == 1){
                        $backtips = '';
                    }
                }else{
                    if($check_products_all->fields['is_sold_out'] == 1){
                        $pro_array['cart'] .= '<span class="soldout_text"><a rel="nofollow"  id="restock_'.$check_products_all->fields['products_id'].'" onclick="beforeRestockNotification(' . $check_products_all->fields['products_id'] . '); return false;">' . TEXT_RESTOCK . ' ' . TEXT_NOTIFICATION . '</a></span>';
                        $pro_array['cart'] .= '<a rel="nofollow" class="icon_soldout" href="javascript:void(0);">'.TEXT_SOLD_OUT.'</a>';
                        if($is_s_level_product == 1){
                            $backtips = '';
                        }
                    }else{
                        $pro_array['cart'] .= '<input class="qty addcart_qty_input 2" maxlength="5" type="text" id="'.$page_name.'_'.$check_products_all->fields['products_id'].'" name="products_id[' . $check_products_all->fields['products_id'] . ']" value="'.($bool_in_cart ? $procuct_qty : $check_products_all->fields['products_quantity_order_min']).'" orig_value="'.($bool_in_cart ? $procuct_qty : $check_products_all->fields['products_quantity_order_min']).'" /><input type="hidden" id="MDO_' . $check_products_all->fields['products_id'] . '" value="'.$bool_in_cart.'" /><input type="hidden" id="incart_' . $check_products_all->fields['products_id'] . '" value="'.$procuct_qty.'" />';
                        $pro_array['cart'] .= '<a rel="nofollow" class="icon_backorder" title="'.($bool_in_cart ? IMAGE_BUTTON_UPDATE_CART : TEXT_CART_ADD_TO_CART).'" id="submitp_' . $check_products_all->fields['products_id'] . '" name="submitp_' .  $check_products_all->fields['products_id'] . '" onclick="Addtocart_list('.$check_products_all->fields['products_id'].','.$page_type.',this); return false;" href="javascript:void(0);">'.TEXT_BACKORDER.'</a>';
                        if($products_stock_days > 7){
                            $backtips = '<span style="color:#999;">'.TEXT_AVAILABLE_IN715.'</span>';
                        }else{
                            $backtips = '<span style="color:#999;">'.TEXT_AVAILABLE_IN57.'</span>';
                        }
                    }
                }

                $pro_array['cart'] .= '<a rel="nofollow" class="text addcollect" title="' . HEADER_TITLE_WISHLIST . '" id="wishlist_'.$check_products_all->fields['products_id'].'" class="addwishlistbutton" onclick="beforeAddtowishlist(' . $check_products_all->fields['products_id'] . ','.$page_type.'); return false;" href="javascript:void(0);"></a>';
                $pro_array['cart'] .= '</p>';
                $pro_array['cart'] .= '<div class="successtips_add successtips_add1"><span class="bot"></span><span class="top"></span><ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins></div>';
                $pro_array['cart'] .= '<div class="successtips_add successtips_add2"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div>';
                $pro_array['cart'] .= '<div class="successtips_add successtips_add3"><span class="bot"></span><span class="top"></span><ins class="sh"></ins></div></div>';
                $pro_array['cart'] .= $backtips;
                $backtips = '';
                $pro_array['cart'] .= '<p class="stock_remain">'.zen_get_products_quantity_min_units_display($check_products_all->fields['products_id']). ($check_products_all->fields['products_limit_stock'] == 1 ? ( '<span>'.sprintf(TEXT_STOCK_HAVE_LIMIT,$products_quantity).'</span>') : '') . '</p>';
            }

            $show_products_content[] = $pro_array;
        }
    }

    $return_array['show_products_content'] = $show_products_content;

    return $return_array;
}


function get_categories_refine($current_page_base){
    global $db;

    $return_array = array();
    $refine_by_off = '';
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

    $return_array['list_category_array'] = $list_category_array;

    return $return_array;
}

/**
 * WSL
 * @param int|$curreny_category
 * @return object|queryFactoryResult
 */
function get_category_redirect($curreny_category){
    global $db,$memcache;
    $memcache_key = md5(MEMCACHE_PREFIX . 'category_redirect' . $curreny_category);
    $data = $memcache->get($memcache_key);
    if($data || gettype($data) != 'boolean'){
        return $data;
    }
    $check_redirect_query = $db->Execute("select new_category_id from ".TABLE_CATEGORY_REDIRECT." where old_category_id='".$curreny_category."'");
    $memcache->set($memcache_key,$check_redirect_query,false,604800);
    return $check_redirect_query ;

}

/*
 * Return Category Name from product ID
 * TABLES: categories_name
 */
function zen_get_categories_name_from_product($product_id) {
    global $db;

    $check_products_category =  get_products_info_memcache((int)$product_id , 'categories_id');
    $the_categories_name = get_category_info_memcache($check_products_category, 'categories_name', (int)$_SESSION['languages_id']);
    return $the_categories_name;
}

function get_categories_row($categories, $current_category_id, $cPath_array, $cPath){
    $list_box_contents = array();

    foreach ($categories as $key => $value){
        //jessa 2010-09-26
        if ($value['categories_id'] == '1318'){
            if (! isset($_SESSION['customer_id']) || ! zen_not_null($_SESSION['customer_id']))
                continue;
        }

        $categoryParam['count'] = get_category_info_memcache($value['categories_id'] , 'products_count');

        // Dont display the category that donot have products  add if statement
        if($categoryParam['count'] <= 0){
            continue;
        }
        if (!$value['categories_image']) $value['categories_image'] = 'pixel_trans.gif';
        $categoryParam['image']	= '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="'.DIR_WS_IMAGES . $value['categories_image'].'" title="'.$value['categories_name'].'" alt="'.$value['categories_name'].'" height="120" width="120">';
        $cPath_new = 'cPath=' . get_category_info_memcache($value['categories_id'] , 'cPath');
        // strip out 0_ from top level cats
        $categoryParam['link'] = zen_href_link(FILENAME_DEFAULT, $cPath_new);
        $categoryParam['name'] = $value['categories_name'];

        //	if this is category-level-2, show 4&5
// 		$categoryParam['sub'] = array();
// 		if($current_category_id == $cPath_array[1]){
// 			$categoryParam['sub'] = zen_get_category_tree($value['categories_id'], '0', '', null, '0_'.$cPath.'_'.$value['categories_id'], false, true);
// 		}

        $list_box_contents[] = $categoryParam;
    }

    return $list_box_contents;
}

function get_category_info_memcache($category_id , $type , $language_id){
    global $db , $memcache , $solr;
    $data = array();
    $return_array = array();
    $result = '';

    if(isset($category_id) && $category_id > 0){
        $memcache_key = md5(MEMCACHE_PREFIX . 'categories_info_new_' . $category_id);
//        $data = $memcache->get($memcache_key);
        //抗疫产品的缘故临时去掉缓存
        if(sizeof($data) > 0 && gettype($data) != 'boolean' ){
            $return_array = $data;
        }else{
            //类别详细信息
            $categories_sql = "SELECT 
								categories_id, 
								categories_code,
								categories_image,
								parent_id,
								sort_order,
								date_added,
								last_modified,
								categories_status,
								categories_level,
								display_pic,
								chinese_info,
								left_display
							FROM " . TABLE_CATEGORIES . " 
							WHERE categories_id = " . (int)$category_id;
            $categories_query = $db->Execute($categories_sql);
            if($categories_query->RecordCount() > 0){
                $return_array = $categories_query->fields;
            }
            //类别描述信息
            $sql = "select categories_name, categories_description, categories_id, language_id from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = " . (int)$category_id;
            $categories_query = $db->Execute($sql);

            $i = 1;
            if($categories_query->RecordCount() > 0){
                while(!$categories_query->EOF){
                    $return_array['detail'][$i] = $categories_query->fields;
                    $i++;

                    $categories_query->MoveNext();
                }
            }
            //类别cPath
            $categories = array();
            $result_array = array();

            zen_get_parent_categories_new($result_array, $category_id);
            $categories = $result_array['categories_arr'];

            $categories = array_reverse($categories);
            $categories_imploded = implode('_', $categories);

            if (zen_not_null($categories_imploded)){
                $categories_imploded .= '_';
            }

            $categories_imploded .= $category_id;
            $return_array['cPath'] = $categories_imploded;
            $return_array['cPath_array'] = explode('_', $categories_imploded);

            //类别下商品数量
            $products_count = 0;
            if (!isset($solr)) {
                require_once (DIR_FS_CATALOG . 'solrclient/Apache/Solr/Service.php');
                $solr = new Apache_Solr_service ( SOLR_HOST, SOLR_PORT, '/solr/dorabeads_' . $_SESSION ['languages_code'] );
            }

            $solr_select_query = 'categories_id:' . ( int ) $category_id;
            if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) {
                $products_display_solr_str = '';
            } else {
                $products_display_solr_str = ' AND is_display:1';
            }
            $solr_select_query .= $products_display_solr_str;
            $count_res = $solr->search ( $solr_select_query, 0, 0 );
            $products_count = $count_res->response->numFound;

            $return_array['products_count'] = $products_count;

            //子类别
            $child_category_query = "select categories_id
                             from " . TABLE_CATEGORIES . "
                             where parent_id = '" . (int)$category_id . "' ORDER BY sort_order";

            $child_category = $db->Execute($child_category_query);

            $child_categories_array = array();
            if($child_category->RecordCount() > 0){
                while (!$child_category->EOF){
                    $child_categories_array[] = $child_category->fields['categories_id'];

                    $child_category->MoveNext();
                }
            }

            $return_array['subcate'] = $child_categories_array;

            $memcache->set($memcache_key,$return_array,false,604800);
        }
    }

    if(!isset($language_id) || $language_id <= 0){
        $language_id = $_SESSION['languages_id'];
    }

    if(isset($type) && $type != ''){
        if(in_array($type, array('categories_name' , 'categories_description'))){
            $result = $return_array['detail'][$language_id][$type];
        }elseif($type == 'detail'){
            $result = $return_array[$type][$language_id];
        }else{
            $result = $return_array[$type];
        }
    }else{
        $result = $return_array;
    }

    return $result;
}
?>