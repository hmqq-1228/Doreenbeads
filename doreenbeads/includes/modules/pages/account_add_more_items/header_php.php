<?php
/**
 * Header code file for the Account History Information/Details page (which displays details for a single specific order)
 *
 * @package page
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 2943 2006-02-02 15:56:09Z wilt $
 */
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_ACCOUNT_QUICK_REORDER');
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add('My Account', zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add('Add More Items', zen_href_link(FILENAME_ACCOUNT_ADD_MORE_ITEMS, '', 'SSL'));
if (isset($_GET['action']) && $_GET['action'] == 'addconfirm'){
	//客户要添加历史订单里的产品
	for ($i = 0; $i < sizeof($_POST['products_id']); $i++){
		$ls_get_prod= strtoupper(trim(trim($_POST['products_id'][$i]),"\t"));
		$li_products_qty = $_POST['cart_quantity'][$i];
		if (!zen_not_null($ls_get_prod)) continue;
		$lds_products = $db->Execute("select products_model from " . TABLE_PRODUCTS ."
												 where products_model = '" . $ls_get_prod ."'");
		$ls_prod_model= $lds_products->fields['products_model'];
		
		if ($ls_prod_model == $ls_get_prod){
			if (is_numeric($li_products_qty) and $li_products_qty > 0){
				////加入shopping cart
				$lds_products = $db->Execute("select products_id from " . TABLE_PRODUCTS ."
											                       where products_model = '" . $ls_get_prod ."'");
			    $lds_products_id= $lds_products->fields['products_id'];
				//echo '$products_id:' . $ls_get_prod .'$qty:' . $li_products_qty . '$ls_prod_model:' . $ls_prod_model . '$lds_products_id:' .$lds_products_id. '<br />';
				$_SESSION['cart']->addselectedtocart($lds_products_id, $li_products_qty);
				//$li_products_qty += $li_products_qty;
	    	}else {
	    		$messageStack->add_session('header', 'The products\' quantity must be larger than zero.', 'error');
	    		zen_redirect(zen_href_link(FILENAME_ACCOUNT_ADD_MORE_ITEMS));
	    	}
		}else {
			$messageStack->add_session('header', 'Dear friend, we are sorry for the inconvenience, but we were unable to add the following item(s) to your cart: '. $ls_get_prod .' Item Not Found', 'error');
	    	zen_redirect(zen_href_link(FILENAME_ACCOUNT_ADD_MORE_ITEMS));
		}
	}
	$messageStack->add_session('header', 'Your items have been added to shopping cart successfully!', 'success');
		//die();
	zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
}

?>