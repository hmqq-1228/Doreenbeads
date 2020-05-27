<?php
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

if (! isset ( $_GET ['action'] )) {
	if (! isset ( $_SESSION ['display_mode'] ))
		$_SESSION ['display_mode'] = 'normal';
} else {
	if ($_GET ['action'] == 'normal') {
		$_SESSION ['display_mode'] = 'normal';
	} elseif ($_GET ['action'] == 'quick') {
		$_SESSION ['display_mode'] = 'quick';
	}
}

$breadcrumb->add ( NAVBAR_TITLE );
$disp_order_default = PRODUCT_FEATURED_LIST_SORT_DEFAULT;
$solr_str_array = get_listing_display_order($disp_order_default);
$solr_order_str = $solr_str_array['solr_order_str'];
$order_by = $solr_str_array['order_by'];

$products_mixed_array = array ();

$products_mixed_query_raw = "SELECT p.products_id, pd.products_name, p.products_image, p.products_price,
                                    p.products_date_added,  p.products_model,
                                    ps.products_quantity, p.products_weight, p.products_discount_type, 
                                    p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight, p.products_qty_box_status
                             FROM " . TABLE_PRODUCTS_STOCK . " ps, " . TABLE_PRODUCTS . " p , " . TABLE_PRODUCTS_DESCRIPTION . " pd
                             WHERE p.products_status = 1
                             AND p.products_id = pd.products_id 
                             and p.products_id = ps.products_id 
                             AND is_mixed=1
                             AND pd.language_id = :languageID group by p.products_id " . $order_by;

$products_mixed_query_raw = $db->bindVars ( $products_mixed_query_raw, ':languageID', $_SESSION ['languages_id'], 'integer' );
$products_mixed_split = new splitPageResults ( $products_mixed_query_raw, $_SESSION ['per_page'], 'p.products_id' );  
?>