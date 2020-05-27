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
$product_id = $_POST['product_id'];
$product_status = $_POST['product_status'];
$product_cPath = $_POST['product_cPath'];

if (isset($product_id)) {	
	for ($i=0, $n=sizeof($product_id);$i<$n; $i++){
		
		$status = $product_status[$i];
		$cPath = $product_cPath[$i];
		
		if ($status <= 0){
			$prod_parent_query = "select a.categories_id,categories_status from " . TABLE_CATEGORIES . " a, (select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = " . (int)$product_id[$i] . " ) b where a.categories_id = b.categories_id order by a.categories_id";
			$prod_parent = $db->Execute($prod_parent_query);
			
			while (!$prod_parent->EOF){
		  	 if (strstr($cPath, $prod_parent->fields['categories_id'])){
			  	if ($prod_parent->fields['categories_status'] != 1){
			  		//$messageStack->add((int)$_GET['pID'] . TEXT_CATEGORIES_PROD_CHANGE_WARNING, 'warning');
			  		$messageStack->add_session((int)$product_id[$i] . TEXT_CATEGORIES_PROD_CHANGE_WARNING, 'warning');
			  	}else{
			  		 $db->Execute("update " . TABLE_PRODUCTS . "
		                           set products_status = 1, products_last_modified = now()
		                           where products_id = '" . (int)$product_id[$i] . "'");
			  	}
			  }
		   	$prod_parent->MoveNext();
		   }
		}elseif ($status == 1) {
	      $db->Execute("update " . TABLE_PRODUCTS . "
	                           set products_status = 0, products_last_modified = now()
	                           where products_id = '" . (int)$product_id[$i] . "'");
	    }
	
	}
}
zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') .((isset($_GET['search']) && $_GET['search'] != '') ? ('&search=' . $_GET['search']) : '' )));
?>