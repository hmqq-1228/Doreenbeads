<?php

require('includes/application_top.php');
require("../solrclient/Apache/Solr/Service.php");
@set_time_limit(0);

isset($_GET['action']) ? ($action = $_GET['action']) : ($action = "update");

$solrConfig = simplexml_load_file("solrConfig.xml");
if ($solrConfig->config->switch == 1) {
    $solrSwitch = 2;
    $solrCore = "/solr/dorabeads_2";
} else {
    $solrSwitch = 1;
    $solrCore = "/solr/dorabeads_1";
}
$solr = new Apache_Solr_Service('localhost', '9999', $solrCore);
if (!$solr->ping()) {
    echo 'Solr service not responding.';
    exit;
}

$solr->deleteByQuery("*:*");
$solr->commit();

switch(true){
    case $action == "update":
        $start = microtime(true);
        global $db;
//        $sqlForProducts = "select p.products_id as products_id ,products_quantity_order_min,products_model,products_price,products_image,products_date_added,products_weight,products_name,products_description,products_name_without_catg,products_quantity,products_status from t_products p, t_products_description pd where p.products_id = pd.products_id and p.products_status > 0 LIMIT 0,30";
        $sqlForProducts = "select p.products_qty_box_status,p.products_quantity_order_max,p.products_id as products_id ,products_quantity_order_min,products_model,products_price,products_image,products_date_added,products_weight,products_name,products_description,products_name_without_catg,products_status from t_products p, t_products_description pd where p.products_id = pd.products_id and p.products_status > 0";
        $productsResult = $db->Execute($sqlForProducts);
        $parts = array();
        $i = 0;
        while (!$productsResult->EOF) {
            $categories_id=$db->Execute("select categories_id from t_products_to_categories where products_id='".$productsResult->fields['products_id']."'");
            while(!$categories_id->EOF){
//                echo $productsResult->fields['products_id']."++".$categories_id->fields['categories_id'].'==';
                $categories = array();
                zen_get_parent_categories($categories,$categories_id->fields['categories_id']);
                $categories_name = array();
                zen_get_parent_categories_name($categories_name,$categories_id->fields['categories_id']);
//                var_dump($categories_name);
                $categories_id->MoveNext();
            }
            $productsResult->fields['products_quantity'] = get_products_quantity(array('products_id'=>$productsResult->fields['products_id']));
            $parts[$i] = array(
                'id' => 'en-'.$productsResult->fields['products_id'],
	 	'products_id' =>$productsResult->fields['products_id'],
	 	'products_model' => $productsResult->fields['products_model'],
	 	'products_image' => $productsResult->fields['products_image'],
	 	'products_weight' => $productsResult->fields['products_weight'],
	 	'products_date_added' => $productsResult->fields['products_date_added'],
	 	'products_name' => $productsResult->fields['products_name'],
	 	'products_name_en' => $productsResult->fields['products_name'],
	 	'products_description' => str_replace('&nbsp;', ' ', strip_tags($productsResult->fields['products_description'])),
	 	'products_quantity' => $productsResult->fields['products_quantity'],
	 	'products_status' => $productsResult->fields['products_status'],
	 	'products_price' => $productsResult->fields['products_price'],
	 	'products_name_without_catg' => $productsResult->fields['products_name_without_catg'],
	 	'categories_id' => $categories,
                'categories_name' => $categories_name,
                'products_quantity_order_min'=> $productsResult->fields['products_quantity_order_min'],
                'products_quantity_order_max'=> $productsResult->fields['products_quantity_order_max'],
                'products_qty_box_status'=> $productsResult->fields['products_qty_box_status']
            );
            $productsResult->MoveNext();
            $i++;
        }
        foreach ($parts as $item => $fields) {
            $part = new Apache_Solr_Document();
            foreach ($fields as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $datum) {
                        $part->setMultiValue($key, $datum);
                    }
                } else {
                    $part->$key = $value;
                }
            }
            $documents[] = $part;
        }
        //var_dump($documents);
        // 创建索引
        try {
            $solr->addDocuments($documents);
            $solr->commit();
            $solr->optimize();
        } catch (Exception $e) {
            echo $e->getCode()."<br />";
            echo $e->getTraceAsString();
        }
        $end = microtime(true);
        $solrXml = simplexml_load_file("solrConfig.xml");
        $solrXml->config->switch = $solrSwitch;
        $newXml = $solrXml->asXML();
        $fp = fopen("solrConfig.xml","w+");
        if (fwrite($fp,$newXml)){
            echo 'switch is '.$solrSwitch.' now';
        }
        echo "take ".($end-$start)."s for generate core ".$solrCore." and the core now is ".$solrSwitch;
        break;
    case $action == "switch":
        $solrXml = simplexml_load_file("solrConfig.xml");
        $solrXml->config->switch = $solrSwitch;
        $newXml = $solrXml->asXML();
        $fp = fopen("solrConfig.xml","w+");
        if (fwrite($fp,$newXml)){
            echo 'switch is '.$solrSwitch.' now';
        }
        break;
    default :
        break;
}


function zen_get_parent_categories_name(&$categories, $categories_id) {
    global $db;
    $parent_categories_query = "select cd.categories_name,c.parent_id
                                from " . TABLE_CATEGORIES . " c,t_categories_description cd
                                where 
                                c.categories_id = cd.categories_id AND
                                c.categories_id = " . (int)$categories_id.""; 

    $parent_categories = $db->Execute($parent_categories_query);

    while (!$parent_categories->EOF) {
      if ($parent_categories->fields['parent_id'] == 0) return true;
      $categories[sizeof($categories)] = $parent_categories->fields['categories_name'];
      if ($parent_categories->fields['parent_id'] != $categories_id) {
        zen_get_parent_categories_name($categories, $parent_categories->fields['parent_id']);
      }
      $parent_categories->MoveNext();
    }
  }
