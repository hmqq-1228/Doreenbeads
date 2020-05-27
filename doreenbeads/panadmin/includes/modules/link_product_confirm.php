<?php
/**
 * @package admin
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: copy_to_confirm.php 4861 2006-10-29 17:15:42Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

if (isset($_POST['productcheckbox']) && $ifUnLink==1){
//        	var_dump($_POST['productcheckbox']);
//        	exit;
        	$productIDs = zen_db_prepare_input($_POST['productcheckbox']);
        	$productID_string='(';
        	
          	foreach ($productIDs as $key=>$val){
          		if($key==(sizeof($productIDs)-1)){
          			$productID_string.=$val;
          		}else{
          			$productID_string.=$val.',';
          		}
          		
          	}
          	$productID_string.=')';	
          	$db->Execute(" update ".TABLE_PRODUCTS."  set  	products_quantity='0' where products_id in ".$productID_string." ");
        	zen_redirect(zen_href_link(FILENAME_CATEGORIES, zen_get_all_get_params(array('action')), 'NONSSL'));
          	           
        }elseif(isset($_POST['productcheckbox'])){
        	
        	$productIDs = zen_db_prepare_input($_POST['productcheckbox']);
        	$productID_string='(';
        	
          	foreach ($productIDs as $key=>$val){
          		if($key==(sizeof($productIDs)-1)){
          			$productID_string.=$val;
          		}else{
          			$productID_string.=$val.',';
          		}
          		
          	}
          	$productID_string.=')';	
          	$db->Execute(" update ".TABLE_PRODUCTS."  set  	products_quantity='5000' where products_id in ".$productID_string." ");
        	zen_redirect(zen_href_link(FILENAME_CATEGORIES, zen_get_all_get_params(array('action')), 'NONSSL'));
          	           
        }
       
?>