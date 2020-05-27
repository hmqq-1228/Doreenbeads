<?php
//
/**
 * @package admin
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: move_product_confirm.php 3009 2006-02-11 15:41:10Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
      if (isset($_POST['products_id']) && isset($_POST['move_to_category_id'])) {
        $products_id = zen_db_prepare_input($_POST['products_id']);
        $new_parent_id = zen_db_prepare_input($_POST['move_to_category_id']);

        $duplicate_check = $db->Execute("select count(*) as total
                                        from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                                        where products_id = '" . (int)$products_id . "'
                                        and categories_id = '" . (int)$new_parent_id . "'");

        if ($duplicate_check->fields['total'] < 1) {
          $db->Execute("update " . TABLE_PRODUCTS_TO_CATEGORIES . "
                        set categories_id = '" . (int)$new_parent_id . "'
                        where products_id = '" . (int)$products_id . "'
                        and categories_id = '" . (int)$current_category_id . "'");

          // reset master_categories_id if moved from original master category
          $check_master = $db->Execute("select products_id, master_categories_id from " . TABLE_PRODUCTS . " where products_id='" .  (int)$products_id . "'");
          if ($check_master->fields['master_categories_id'] == (int)$current_category_id) {
            $db->Execute("update " . TABLE_PRODUCTS . "
                          set master_categories_id='" . (int)$new_parent_id . "'
                          where products_id = '" . (int)$products_id . "'");
          }
          
          zen_get_parent_categories($categories_all,$new_parent_id);
          if(count($categories_all) == 0){
          	$db->Execute("update  ".TABLE_PRODUCTS_TO_CATEGORIES." set first_categories_id = ".$new_parent_id." ,second_categories_id = 0,three_categories_id = 0,four_categories_id = 0,five_categories_id= 0,six_categories_id = 0  where products_id =  ".(int)$products_id." AND categories_id = ".$new_parent_id."");
          }elseif(count($categories_all) == 1){
          	$update_categories = " first_categories_id = $categories_all[0] , second_categories_id = ".$new_parent_id.",three_categories_id = 0,four_categories_id = 0,five_categories_id= 0,six_categories_id = 0";
          }elseif (count($categories_all) == 2){
          	$update_categories = " first_categories_id = $categories_all[1],second_categories_id = $categories_all[0],three_categories_id = ".$new_parent_id.",four_categories_id = 0,five_categories_id= 0,six_categories_id = 0";
          }elseif (count($categories_all) == 3){
          	$update_categories = " first_categories_id = $categories_all[2],second_categories_id = $categories_all[1],three_categories_id = $categories_all[0],four_categories_id = ".$new_parent_id.",five_categories_id= 0,six_categories_id = 0";
          }elseif (count($categories_all) == 4){
          	$update_categories = " first_categories_id = $categories_all[3],second_categories_id = $categories_all[2],three_categories_id = $categories_all[1],four_categories_id = ".$categories_all[0].",five_categories_id= ".$new_parent_id.",six_categories_id = 0";
          }elseif (count($categories_all) == 5){
          	$update_categories = " first_categories_id = $categories_all[4],second_categories_id = $categories_all[3],three_categories_id = $categories_all[2],four_categories_id = ".$categories_all[1].",five_categories_id= ".$categories_all[0].",six_categories_id = ".$new_parent_id."";
          }
          if($update_categories!=""){
          	$db->Execute("update  ".TABLE_PRODUCTS_TO_CATEGORIES." set $update_categories  where products_id =  ".(int)$products_id." AND categories_id = ".$new_parent_id."");
          	unset($update_categories);
          }

          // reset products_price_sorter for searches etc.
          zen_update_products_price_sorter((int)$products_id);
        } else {
          $messageStack->add_session(ERROR_CANNOT_MOVE_PRODUCT_TO_CATEGORY_SELF, 'error');
        }

        zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $new_parent_id . '&pID=' . $products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
      }elseif (isset($_POST['productcheckbox']) && isset($_POST['move_to_category_id'])){
      	    $products_Ids=$_POST['productcheckbox'];

    	    $new_parent_id = zen_db_prepare_input($_POST['move_to_category_id']);

            $error_info_array=array();
            $error = false;
      	    foreach ($products_Ids as $val){   

                // reset master_categories_id if moved from original master category
                $check_master = $db->Execute("select products_model, master_categories_id from " . TABLE_PRODUCTS . " where products_id='" .  (int)$val . "'");
                if ($check_master->fields['master_categories_id'] == (int)$current_category_id) {
                   // $db->Execute("update " . TABLE_PRODUCTS . " set master_categories_id='" . (int)$new_parent_id . "' where products_id = '" . (int)$val . "'");
                    $products_model = $check_master->fields['products_model'];
                    $error_info_array[] = $products_model . ' 不能从主类别下移除';
                    $error = true;
                    continue;
                }  

                if (!$error) {
                      $duplicate_check = $db->Execute("select count(*) as total
                                        from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                                        where products_id = '" . (int)$val . "'
                                        and categories_id = '" . (int)$new_parent_id . "'");

                    if ($duplicate_check->fields['total'] < 1) {
                        $db->Execute("update " . TABLE_PRODUCTS_TO_CATEGORIES . " set categories_id = '" . (int)$new_parent_id . "' where products_id = '" . (int)$val . "' and categories_id = '" . (int)$current_category_id . "'");

                        zen_get_parent_categories($categories_all,$new_parent_id);

                        if(count($categories_all) == 0){
                              $db->Execute("update  ".TABLE_PRODUCTS_TO_CATEGORIES." set first_categories_id = ".$new_parent_id." ,second_categories_id = 0,three_categories_id = 0,four_categories_id = 0,five_categories_id= 0,six_categories_id = 0  where products_id =  ".(int)$val." AND categories_id = ".$new_parent_id."");
                        }elseif(count($categories_all) == 1){
                                $update_categories = " first_categories_id = $categories_all[0] , second_categories_id = ".$new_parent_id.",three_categories_id = 0,four_categories_id = 0,five_categories_id= 0,six_categories_id = 0";
                        }elseif (count($categories_all) == 2){
                                $update_categories = " first_categories_id = $categories_all[1],second_categories_id = $categories_all[0],three_categories_id = ".$new_parent_id.",four_categories_id = 0,five_categories_id= 0,six_categories_id = 0";
                        }elseif (count($categories_all) == 3){
                                $update_categories = " first_categories_id = $categories_all[2],second_categories_id = $categories_all[1],three_categories_id = $categories_all[0],four_categories_id = ".$new_parent_id.",five_categories_id= 0,six_categories_id = 0";
                        }elseif (count($categories_all) == 4){
                                $update_categories = " first_categories_id = $categories_all[3],second_categories_id = $categories_all[2],three_categories_id = $categories_all[1],four_categories_id = ".$categories_all[0].",five_categories_id= ".$new_parent_id.",six_categories_id = 0";
                        }elseif (count($categories_all) == 5){
                                $update_categories = " first_categories_id = $categories_all[4],second_categories_id = $categories_all[3],three_categories_id = $categories_all[2],four_categories_id = ".$categories_all[1].",five_categories_id= ".$categories_all[0].",six_categories_id = ".(int)$val."";
                        }
                        if($update_categories!=""){
                                $db->Execute("update  ".TABLE_PRODUCTS_TO_CATEGORIES." set $update_categories  where products_id =  ".(int)$val." AND categories_id = ".$new_parent_id."");
                                unset($categories_all);
                                unset($update_categories);
                        }

                        // reset products_price_sorter for searches etc.
                        zen_update_products_price_sorter((int)$val);
                    }else {
                        $messageStack->add_session(ERROR_CANNOT_MOVE_PRODUCT_TO_CATEGORY_SELF, 'error');
                    }
                }  
      	    }

            if(sizeof($error_info_array)>=1){
                foreach($error_info_array as $val){
                    $messageStack->add_session($val,'error');
                }
            }else{
                $messageStack->add_session('修改成功','success');
            }
            zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $new_parent_id .(isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
      
        }
?>