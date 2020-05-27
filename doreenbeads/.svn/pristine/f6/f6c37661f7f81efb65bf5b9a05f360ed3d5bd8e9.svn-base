<?php
/**
 * category_tree Class.
 *
 * @package classes
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: category_tree.php 3041 2006-02-15 21:56:45Z wilt $
 * expand all categories at this file  robbie wei 09-01-18
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access'); 
}
/**
 * category_tree Class.
 * This class is used to generate the category tree used for the categories sidebox
 *
 * @package classes 
 */
class category_tree extends base {

  function zen_category_tree($product_type = "all") {
    global $db, $cPath, $cPath_array;
    if ($product_type != 'all') {
      $sql = "select type_master_type from " . TABLE_PRODUCT_TYPES . "
                where type_master_type = " . $product_type . "";
      $master_type_result = $db->Execute($sql);
      $master_type = $master_type_result->fields['type_master_type'];
    }
    $this->tree = array();
    $top_category = array();
    if ($product_type == 'all') { //search for all the top  categories
      $categories_query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_level, c.categories_image
                             from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                             where c.parent_id = 0
                             and c.categories_id = cd.categories_id
                             and c.categories_level <= " . (int)$_SESSION['customers_level'] . "
                             and cd.language_id='" . (int)$_SESSION['languages_id'] . "'
                             and c.categories_status= 1
                             and c.left_display = 10
                             order by sort_order, cd.categories_name";      
    } else {
      $categories_query = "select ptc.category_id as categories_id, cd.categories_name, c.parent_id, c.categories_image
                             from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd, " . TABLE_PRODUCT_TYPES_TO_CATEGORY . " ptc
                             where c.parent_id = 0
                             and ptc.category_id = cd.categories_id
                             and ptc.product_type_id = " . $master_type . "
                             and c.categories_id = ptc.category_id
                             and cd.language_id=" . (int)$_SESSION['languages_id'] ."
                             and c.categories_status= 1
                             and c.left_display = 10
                             order by sort_order, cd.categories_name";
    }
    $categories = $db->Execute($categories_query, '', true, 150);
    while (!$categories->EOF)  {
      $top_category[] = $categories->fields['categories_id'];
      $current_categories_id = $categories->fields['categories_id'];
  	  $this->tree[$categories->fields['categories_id']] = array('name' => $categories->fields['categories_name'],
														        'parent' => $categories->fields['parent_id'],
														        'level' => 0,
														        'path' => $categories->fields['categories_id'],
														        'image' => $categories->fields['categories_image'],
														        'next_id' => false);
      if (isset($parent_id)) {
        $this->tree[$parent_id]['next_id'] = $categories->fields['categories_id'];
      }

      $parent_id = $categories->fields['categories_id'];

      if (!isset($first_element)) {
        $first_element = $categories->fields['categories_id'];
      }
      $categories->MoveNext();
    }
    
    for($index = 0; $index < sizeof($top_category); $index++){
    	$top_id = $top_category[$index];
    	unset($parent_id);
    	unset($first_id);
    	if ($product_type == 'all') {
    		//�ڿͻ�δ��¼������£�����ʾ235 225��2����
	        $categories_query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_level, c.categories_image
	                                 from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
	                                where c.parent_id = " . (int)$top_id . "
	                                  and c.categories_id = cd.categories_id
	                                  and c.categories_level <= " . (int)$_SESSION['customers_level'] . "
	                                  and cd.language_id=" . (int)$_SESSION['languages_id'] . "
	                                  and c.categories_status= 1
	                                  and c.left_display = 10
	                             order by sort_order, cd.categories_name";
        } else {
          $categories_query = "select ptc.category_id as categories_id, cd.categories_name, c.parent_id, c.categories_image
                             from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd, " . TABLE_PRODUCT_TYPES_TO_CATEGORY . " ptc
                             where c.parent_id = " . (int)$top_id . "
                             and ptc.category_id = cd.categories_id
                             and ptc.product_type_id = " . $master_type . "
                             and c.categories_id = ptc.category_id
                             and cd.language_id=" . (int)$_SESSION['languages_id'] ."
                             and c.categories_status= 1
                             and c.left_display = 10
                             order by sort_order, cd.categories_name";
        }
        $second_categories = $db->Execute($categories_query);
        if($second_categories->RecordCount()>0){
        	while(!$second_categories->EOF){
        		 
        		$this->tree[$second_categories->fields['categories_id']] = array('name' => $second_categories->fields['categories_name'],
																	            'parent' => $second_categories->fields['parent_id'],
																	            'level' => 1,
																	            'path' => $top_id.'_' . $second_categories->fields['categories_id'],
																	            'image' => $second_categories->fields['categories_image'],
																	            'next_id' => false);
	            if(isset($parent_id)){
	            	$this->tree[$parent_id]['next_id'] = $second_categories->fields['categories_id'];
	            }
	            
	            $parent_id = $second_categories->fields['categories_id'];
                if (!isset($first_id)) {
		              $first_id = $second_categories->fields['categories_id'];
		        }
                $last_id = $second_categories->fields['categories_id'];
                $second_categories->MoveNext();
        	}
    	    $this->tree[$last_id]['next_id'] = $this->tree[$top_id]['next_id'];
            $this->tree[$top_id]['next_id'] = $first_id;
        }
    }
    
    
    


    if (zen_not_null($cPath)) {
      $new_path = '';
      reset($cPath_array);
      next($cPath_array);
      while (list($key, $value) = each($cPath_array)) {
        unset($parent_id);
        unset($first_id);
        if ($product_type == 'all') {
          $categories_query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_level,c.categories_image
                               from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                               where c.parent_id = " . (int)$value . "
                               and c.categories_id = cd.categories_id
                               and c.categories_level <= " . (int)$_SESSION['customers_level'] . "
                               and cd.language_id=" . (int)$_SESSION['languages_id'] . "
                               and c.categories_status= 1
                               and c.left_display = 10
                               order by sort_order, cd.categories_name";
        } else {
          $categories_query = "select ptc.category_id as categories_id, cd.categories_name, c.parent_id, c.categories_image
                             from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd, " . TABLE_PRODUCT_TYPES_TO_CATEGORY . " ptc
                             where c.parent_id = " . (int)$value . "
                             and ptc.category_id = cd.categories_id
                             and ptc.product_type_id = " . $master_type . "
                             and c.categories_id = ptc.category_id
                             and cd.language_id=" . (int)$_SESSION['languages_id'] ."
                             and c.categories_status= 1
                             and c.left_display = 10
                             order by sort_order, cd.categories_name";

        }

          $rows = $db->Execute($categories_query);

       if ($rows->RecordCount()>0) {
          $new_path .= $value;
          while (!$rows->EOF) {
            $this->tree[$rows->fields['categories_id']] = array('name' => $rows->fields['categories_name'],
            'parent' => $rows->fields['parent_id'],
            'level' => $key+1,
            'path' => $new_path . '_' . $rows->fields['categories_id'],
            'image' => $categories->fields['categories_image'],
            'next_id' => false);

            if (isset($parent_id)) {
              $this->tree[$parent_id]['next_id'] = $rows->fields['categories_id'];
            }

            $parent_id = $rows->fields['categories_id'];
            if (!isset($first_id)) {
              $first_id = $rows->fields['categories_id'];
            }

            $last_id = $rows->fields['categories_id'];
            $rows->MoveNext();
          }
          $this->tree[$last_id]['next_id'] = $this->tree[$value]['next_id'];
          $this->tree[$value]['next_id'] = $first_id;
          $new_path .= '_';
        } else {
          break;
        }
      }
    }


    $row = 0;
    return $this->zen_show_category($first_element, $row);
  }

  function zen_show_category($counter,$ii) {
    global $cPath_array;

    $this->categories_string = "";

    for ($i=0; $i<$this->tree[$counter]['level']; $i++) {
      if ($this->tree[$counter]['parent'] != 0) {
/*jessa 2009-09-21 delete "CATEGORIES_SUBCATEGORIES_INDENT(�������ʱ�����������������ǰ����������ո�nbsp;��)" �޸� "categories"����ʾ��ʽ*/

        $this->categories_string .= "";
		
//eof jessa 2009-09-21
      }
    }


    if ($this->tree[$counter]['parent'] == 0) {
      $cPath_new = 'cPath=' . $counter;
      $this->box_categories_array[$ii]['top'] = 'true';
    } else {
      $this->box_categories_array[$ii]['top'] = 'false';
      $cPath_new = 'cPath=' . $this->tree[$counter]['path'];
/*jessa 2009-09-21 update "categories_string .= CATEGORIES_SEPARATOR_SUBS" ��Ϊ�ڲ�Ʒ��ʾʱ�����"|_"�������Ϊ���ַ�*/

      $this->categories_string .= "";
	  
//eof jessa 2009-09-21
    }
    $this->box_categories_array[$ii]['path'] = $cPath_new;
    $this->box_categories_array[$ii]['level'] = $this->tree[$counter]['level'];

    if (isset($cPath_array) && in_array($counter, $cPath_array)) {
      $this->box_categories_array[$ii]['current'] = true;
    } else {
      $this->box_categories_array[$ii]['current'] = false;
    }

    // display category name
   //robbie_wei
    //����Ʒ��Ϊ0ʱ������ʾ�����
    $products_count = get_category_info_memcache($counter , 'products_count');
    if ($products_count == 0):
    	$this->box_categories_array[$ii]['name'] = "";
    else:
    	$this->box_categories_array[$ii]['name'] = $this->categories_string . $this->tree[$counter]['name'];
	endif;
	//end robbie

    // make category image available in case needed
    $this->box_categories_array[$ii]['image'] = $this->tree[$counter]['image'];

    $have_subcate = sizeof(get_category_info_memcache($counter , 'subcate')) > 0 ? true : false; 
    if ($have_subcate) {
      $this->box_categories_array[$ii]['has_sub_cat'] = true;
    } else {
      $this->box_categories_array[$ii]['has_sub_cat'] = false;
    }

    if (SHOW_COUNTS == 'true') {
      if ($products_count > 0) {
        $this->box_categories_array[$ii]['count'] = $products_count;
      } else {
        $this->box_categories_array[$ii]['count'] = 0;
      }
    }

    if ($this->tree[$counter]['next_id'] != false) {
      $ii++;
      $this->zen_show_category($this->tree[$counter]['next_id'], $ii);
    }
    return $this->box_categories_array;
  }
}
?>