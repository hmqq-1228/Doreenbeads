<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'download') {
 global $memcache;
 
    $date_now = date("Ymd");
	$extract_dir = "file/products_price/";

    if(!isset($_GET['debug']) || $_GET['debug'] != 'true') {
        $filename = download_file(HTTP_ERP_URL . "/download/erp_products_price_doreenbeads_" . $date_now . ".zip", $extract_dir, "erp_products_price_doreenbeads_" . $date_now . ".zip", true);
    }
    $zip = new ZipArchive;
	if($zip->open($extract_dir . "erp_products_price_doreenbeads_" . $date_now . ".zip") === true) {
		$zip->extractTo($extract_dir);
	}
    if(is_file($extract_dir . "doreenbeads_erp_products_price_" . $date_now . ".txt")) {
        $prod_group = file_get_contents($extract_dir . "doreenbeads_erp_products_price_" . $date_now . ".txt");  
        $prod_group_array = explode("\r\n", $prod_group);

        for($index = 1; $index < count($prod_group_array); $index++) {
        	$products =  explode("|^", $prod_group_array[$index]);
    	    $products_model = zen_db_prepare_input($products[0]);
    	    $price = zen_db_prepare_input($products[1]);
    	    $price_times = zen_db_prepare_input($products[2]);
            $products_stocking_days = zen_db_prepare_input($products[3]);

            $sql= 'select products_id from ' . TABLE_PRODUCTS . ' where products_model = "' . $products_model .'" and products_status != 10';
            $products_id_result = $db->Execute($sql);
            if($products_id_result->RecordCount() > 0){
                $products_id = $products_id_result->fields['products_id'];

                $price_manager_query = $db->Execute('select price_manager_id,products_weight from ' . TABLE_PRODUCTS . ' where products_model = "'. $products_model .'" and products_status != 10');

                if($price > 0  && !empty($price_times) && !empty($products_model)) {
                    $products_weight = $price_manager_query->fields['products_weight'];
                    $price_manager_id = $price_manager_query->fields['price_manager_id'];

                    if(!(substr($products_model, -1)=='H' || substr($products_model, -1)=='Q') && $price_manager_id > 0){
                        $price_manager_value = $db->Execute("SELECT price_manager_value FROM " . TABLE_PRICE_MANAGER . " where price_manager_id = " . $price_manager_id . " order by price_manager_id desc ");
                        $price_after_manager = $price * ($price_manager_value->fields['price_manager_value'] / 100 + 1);
                    }else{
                        $price_manager_id = 0;
                        $price_after_manager = $price;
                    }

                    $update_prod_group = "update " . TABLE_PRODUCTS . " set product_price_times = " . $price_times . ', price_manager_id = ' . $price_manager_id . ', products_net_price =' . $price . ', products_stocking_days =' . $products_stocking_days . ', products_last_modified = now() where products_model = "' . $products_model . '"  and products_status != 10';
                    $db->Execute($update_prod_group);

                    zen_refresh_products_price($products_id, $price_after_manager, $products_weight, $price_times );

                    remove_product_memcache($products_id);
                }
            }

        }
        unlink($extract_dir ."doreenbeads_erp_products_price_" . $date_now . ".txt");
    }
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>