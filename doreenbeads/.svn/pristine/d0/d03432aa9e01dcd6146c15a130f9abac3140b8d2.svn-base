<?php
chdir("../");
require('includes/application_top.php');
$action=zen_db_prepare_input($_POST['action']);
$customers_basket_id = intval($_POST['customers_basket_id']);
$customers_basket_ids = zen_db_prepare_input($_POST['customers_basket_ids']);
$wl_id = intval($_POST['wl_id']);
$wl_ids = zen_db_prepare_input($_POST['wl_ids']);
$return_array = array('error' => 1, 'error_info' => "");

if($action == "shopping_cart_delete_one") {
	$sql = "delete from " . TABLE_CUSTOMERS_BASKET . " where (customers_basket_id=:customers_basket_id and customers_id=:customers_id) or (customers_basket_id=:customers_basket_id and cookie_id=:cookie_id)";
	$sql = $db->bindVars($sql, ':customers_basket_id', $customers_basket_id, 'integer');
	$sql = $db->bindVars($sql, ':customers_id',  $_SESSION['customer_id'], 'integer');
	$sql = $db->bindVars($sql, ':cookie_id', $_SESSION['cookie_cart_id'], 'string');
	$db->Execute($sql);
	$return_array['error'] = 0;
	
} else if($action == "shopping_cart_delete_all") {
	if(!empty($customers_basket_ids)) {
		$sql = "delete from " . TABLE_CUSTOMERS_BASKET . " where customers_basket_id in(" . $customers_basket_ids . ") and (customers_id=:customers_id or cookie_id=:cookie_id)";
		$sql = $db->bindVars($sql, ':customers_id',  $_SESSION['customer_id'], 'integer');
		$sql = $db->bindVars($sql, ':cookie_id', $_SESSION['cookie_cart_id'], 'string');
		$db->Execute($sql);
		$return_array['error'] = 0;
	}
	
} elseif($action == "wishlist_delete_one") {
	$sql = "delete from " . TABLE_WISH . " where wl_id=:wl_id and wl_customers_id=:wl_customers_id";
	$sql = $db->bindVars($sql, ':wl_id', $wl_id, 'integer');
	$sql = $db->bindVars($sql, ':wl_customers_id',  $_SESSION['customer_id'], 'integer');
	$db->Execute($sql);
	$return_array['error'] = 0;
} else if($action == "wishlist_delete_all") {
	if(!empty($wl_ids)) {
		$sql = "delete from " . TABLE_WISH . " where wl_id in(" . $wl_ids . ") and wl_customers_id=:wl_customers_id";
		$sql = $db->bindVars($sql, ':wl_ids',  $wl_ids, 'string');
		$sql = $db->bindVars($sql, ':wl_customers_id', $_SESSION['customer_id'], 'integer');
		$db->Execute($sql);
		$return_array['error'] = 0;
	}

}elseif($action == "wishlist_invalid_split"){
	$page = zen_db_input($_POST['nextPage']) >= 1 ? zen_db_input($_POST['nextPage']) : 1;
	$page_size = 5;

	$check_invalid = $db->Execute("select w.wl_id, p.products_id, p.products_model, p.products_image, pd.products_name  from ".TABLE_WISH." w inner join ".TABLE_PRODUCTS." p on w.wl_products_id=p.products_id inner join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id=pd.products_id
							where w.wl_customers_id = " . $_SESSION['customer_id'] . " and (p.products_status !=1 or exists (select products_id from " . TABLE_MY_PRODUCTS . " mp where w.wl_products_id=mp.products_id)) and pd.language_id = " . $_SESSION['languages_id'] . "");
	$products_notify_array = $products_notify_products_id = $products_notify_also_like_array = array();
	if($check_invalid->RecordCount()>0){
		while(!$check_invalid->EOF){
			$check_invalid->fields['products_image'] = HTTP_IMG_SERVER. 'bmz_cache/' .  get_img_size($check_invalid->fields['products_image'], 80, 80);
			$check_invalid->fields['products_name'] = getstrbylength(htmlspecialchars(zen_clean_html($check_invalid->fields['products_name'])), 60);
			array_push($products_notify_array, $check_invalid->fields);
			array_push($products_notify_products_id, $check_invalid->fields['products_id']);
			$check_invalid->MoveNext();
		}
	}

	$total_num = sizeof($products_notify_array);
	$products_notify_array = array_slice($products_notify_array, ($page -1) * $page_size, $page_size);

	$return_array = array();
	$return_html = $return_fenye = '';

	if(!empty($products_notify_products_id)) {
		$products_notify_also_like_array = get_products_without_catg_relation($products_notify_products_id);
	}
	
	
	foreach ($products_notify_array as $products_notify_key => $products_notify_value) {
		$also_like_str = "";
		if(isset($products_notify_also_like_array[$products_notify_value['products_id']])) {
			$also_like_str = "<a href='" . zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=similar&products_id=' . $products_notify_value['products_id']) . "' target='_blank'>" . TEXT_SHOPING_CART_SELECT_SIMILAR_ITEMS . "</a>&nbsp;&nbsp;";
		}
		$return_html .= '<div class="jq_products_list_'.$products_notify_value['wl_id'].'">
						<p><img src="'.$products_notify_value['products_image'].'" /><span>'.$products_notify_value['products_name'].',  ['.$products_notify_value['products_model'].'</span> </p>
				
						<div class="products_invalid_operation">
							'.$also_like_str.'<a href="javascript:void(0);" class="jq_products_invalid_one" data-id="'.$products_notify_value['wl_id'].'">'.TEXT_DELETE.'</a>
						</div>
					</div>';
	}

	if($total_num > $page_size){
		$_GET['page']=$page;
		$invalid_items_split = new splitPageResults ( '', $page_size, '', 'page', false, $total_num );
		$return_fenye = $invalid_items_split->display_links_mobile_for_shoppingcart ( MAX_DISPLAY_PAGE_LINKS, '', true );
	}

	$return_array['return_html'] = $return_html;
	$return_array['return_fenye'] = $return_fenye;
}
echo json_encode($return_array);
?>