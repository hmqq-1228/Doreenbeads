<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action']) && $_GET['action'] == 'download') {
    $date_now = date("Ymd");
    $hour = date("H");
    $extract_dir = "file/products_preorder/";

    if(!isset($_GET['debug']) || $_GET['debug'] != 'true') {
        $filename = download_file(HTTP_ERP_URL . "/download/erp_products_ispreorder_doreenbeads_" . $date_now . ".zip", $extract_dir, "erp_products_ispreorder_doreenbeads_" . $date_now . ".zip", true);
    }

    $zip = new ZipArchive;
    if($zip->open($extract_dir . "erp_products_ispreorder_doreenbeads_" . $date_now . ".zip") === true) {
        $zip->extractTo($extract_dir);
    }
    
    if(is_file($extract_dir . "doreenbeads_erp_products_ispreorder_" . $date_now . ".txt")) {
        $db->begin();
        
        $prod_info = file_get_contents($extract_dir . "doreenbeads_erp_products_ispreorder_" . $date_now . ".txt");
        $prod_info_array = explode("\r\n", $prod_info);
        $products_model_array = array();
        
        for($index = 1; $index < count($prod_info_array); $index++) {
            $product = explode("|^", $prod_info_array[$index]);
            $model = zen_db_prepare_input($product[0]);
            $is_preorder = zen_db_prepare_input($product[1]);
            
            if($model != '' && in_array($is_preorder, array(1, 0))){
                $products_preorder_sql = 'update ' . TABLE_PRODUCTS . ' set is_preorder = ' . $is_preorder .' where products_model ="' . $model . '" and products_status != 10';
                $db->Execute($products_preorder_sql);
                
                $products_model_array[] = '"' . $model . '"';
            }
        }
        
        $db->commit();
        unlink($extract_dir . "doreenbeads_erp_products_ispreorder_" . $date_now . ".txt");
        
        $products_model_str = implode(',', $products_model_array);
        
        $products_id_query = $db->Execute('select products_id from ' . TABLE_PRODUCTS . ' where products_model in (' . $products_model_str . ')');
        if($products_id_query->RecordCount() > 0){
            while (!$products_id_query->EOF){
                $products_id = $products_id_query->fields['products_id'];
                remove_product_memcache($products_id);
                
                $products_id_query->MoveNext();
            }
        }
    }
}

echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>