<?php
chdir("../");
@ set_time_limit(0);
@ ini_set('memory_limit', '2048M');
require ("includes/application_top.php");
require_once(DIR_WS_FUNCTIONS . "functions_search.php");
//require("includes/access_ip_limit.php");
//include ("includes/SolrPhpClient/Apache/Solr/Service.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if (isset($_GET['action']) && $_GET['action'] == "update_memcache") {

	$getDataTime = microtime(true);
	$date_created = date("Y-m-d H:i:s");
	
	$db->Execute("truncate table " . TABLE_SEARCH_AUTO_MATCH . "");
	$db->Execute("truncate table " . TABLE_SEARCH_RELATED . "");
	$db->Execute("insert into " . TABLE_SEARCH_AUTO_MATCH . " (languages_id, keyword, keyword_type, keyword_status, date_created) select language_id, categories_name, 10, 1, NOW() from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id in(select categories_id from " . TABLE_CATEGORIES . " where categories_status=1) order by categories_id desc");
	$db->Execute("insert into " . TABLE_SEARCH_RELATED . " (languages_id, keyword, keyword_display, keyword_type, keyword_status, date_created) select languages_id, keyword, keyword, 20, 1, now() from " . TABLE_SEARCH_HOT . " where keyword_status=1 order by auto_id desc");
	
	$db->Execute("insert into " . TABLE_SEARCH_AUTO_MATCH . " (languages_id, keyword, keyword_type, keyword_status, date_created) select languages_id, keyword, 20, 1, now() from " . TABLE_SEARCH_HOT . " where keyword_status=1 order by auto_id desc");
	$db->Execute("insert into " . TABLE_SEARCH_RELATED . " (languages_id, keyword, keyword_display, keyword_type, keyword_status, date_created) select language_id, categories_name, categories_name, 10, 1, NOW() from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id in(select categories_id from " . TABLE_CATEGORIES . " where categories_status=1) order by categories_id desc");
	

	$docs = array ();
	$i = 0;
	$memcache_data = array();
	/*
	$result = $db->Execute("select * from " . TABLE_SEARCH_AUTO_MATCH . "");
	while (!$result->EOF) {
		$docs[$i] = array (
			'id' => 'search_auto_match_' . $i,
			'auto_id' => "1" . $i,
			'languages_id' => $result->fields['languages_id'],
			'keyword' => trim($result->fields['keyword']),
			'keyword_general' => trim($result->fields['keyword']),
			'keyword_status' => $result->fields['keyword_status'],
			'date_created' => $result->fields['date_created'],
			'extra_score' => 0
		);
		$memcache_data[$result->fields['languages_id']][] = trim($result->fields['keyword']);
		$i++;
		$result->MoveNext();
	}
	*/
	
	$result = $db->Execute("select * from " . TABLE_SUBJECT_AREAS . " order by id desc");
	$insert_auto_match = "insert into " . TABLE_SEARCH_AUTO_MATCH . " (languages_id, keyword, keyword_type, keyword_status, date_created) values ";
	$insert_related = "insert into " . TABLE_SEARCH_RELATED . " (languages_id, keyword, keyword_display, keyword_type, keyword_status, date_created) values ";
	while (!$result->EOF) {
		$name = unserialize($result->fields['name']);
		foreach($name as $key => $value) {
			$docs[$i] = array (
				'id' => 'search_auto_match_' . $i,
				'auto_id' => "2" . $i,
				'languages_id' => $key,
				'keyword' => trim($value),
				'keyword_status' => 1,
				'date_created' => $date_created,
				'extra_score' => 0
			);
			
			//$db->Execute("insert into " . TABLE_SEARCH_AUTO_MATCH . " (languages_id, keyword, keyword_type, keyword_status, date_created) values (" . $key . ", '" . addslashes(trim($value)) . "', 30, 1, '" . $date_created . "')");
			//$db->Execute("insert into " . TABLE_SEARCH_RELATED . " (languages_id, keyword, keyword_display, keyword_type, keyword_status, date_created) values (" . $key . ", '" . addslashes(trim($value)) . "', '" . addslashes(trim($value)) . "', 30, 1, '" . $date_created . "')");
			$insert_auto_match .= "(" . $key . ", '" . addslashes(trim($value)) . "', 30, 1, '" . $date_created . "'),";
			$insert_related .= "(" . $key . ", '" . addslashes(trim($value)) . "', '" . addslashes(trim($value)) . "', 30, 1, '" . $date_created . "'),";
			//$memcache_data[$key][] = trim($value);
			$i++;
		}
		$result->MoveNext();
	}
	$insert_auto_match = substr($insert_auto_match, 0, strlen($insert_auto_match) - 1);
	$insert_related = substr($insert_related, 0, strlen($insert_related) - 1);
	$db->Execute($insert_auto_match);
	$db->Execute($insert_related);

	$result = $db->Execute("select * from " . TABLE_SEARCH_AUTO_MATCH . " order by auto_id asc");
	
	$condition['sort'] = 'products_ordered desc, products_quantity desc, products_date_added desc';
	//$condition['sort'] = '';
	$condition['facet'] = 'true';
	$condition['facet.mincount'] = '1';
	$condition['facet.limit'] = '-1';
	//count product group by property
	$condition['facet.field'] = 'properties_id';
	$condition['f.properties_id.facet.missing'] = 'false';
	$condition['f.properties_id.facet.method'] = 'enum';
	//range of one fields
	//$condition['facet.range'] = 'products_price';
	//$condition['f.products_price.facet.range.start'] = '0';
	//$condition['f.products_price.facet.range.end'] = '999';
	//$condition['facet.range.gap'] = '1';
	
	//select returned fields list
	$condition['fl'] = 'products_id, score,is_promotion,is_hot_seller,is_new,products_name,extra_score,stock_sort';
	
	//parser for boost
	$condition['defType'] = 'edismax';
	//query fields
	$condition['pf'] = 'products_name products_description';
	//boost score
	$condition['qf'] = 'products_name^0.18 products_description^0.16';
	//$condition['pf']='products_name^2 categories_name^5 products_name_without_catg^1';
	//score for some value of fields
	//$condition['bq']='is_promotion:1^0.1 is_hot_seller:1^0.8 is_new:1^0.1 is_featured:1^3';
	$condition['bf'] = 'extra_score^0.2 stock_sort^0.04';
	
	$languages = new language();
	$catalog_languages = $languages->catalog_languages;
	
	$i = 0;
	$array_auto_match_delete = array();
	while (!$result->EOF) {
		$result->fields['keyword'] = trim($result->fields['keyword']);
		
		$num_products_count = 0;
		$memcache_key = md5($result->fields['languages_id'] . $result->fields['keyword']);
		$data = $memcache->get($memcache_key);
	  	if($data || gettype($data) != 'boolean') {
	  		$num_products_count = $data;
	  	}
	  	
	  	if(intval($num_products_count) <= 0) {
	  		foreach($catalog_languages as $catalog_key => $catalog_value) {
				if($catalog_value['id'] == $result->fields['languages_id']) {
					$languages_code = $catalog_key;
				}
			}
			$solr = new Apache_Solr_service(SOLR_HOST, SOLR_PORT, '/solr/dorabeads_' . $languages_code);
			$keywords = get_keywrods_to_solr(trim($result->fields['keyword']), $result->fields['languages_id']);
			$package_filter = "";
			$extra_select_str = $keywords .  $package_filter;
			$extra_select_str = " AND " . $keywords .  $package_filter;
			$count_res = search_by_solr($solr, $condition, $extra_select_str, "", 10, ITEM_PERPAGE_DEFAULT);
			$num_products_count = $count_res->response->numFound;
			if($num_products_count > 10) {
				$memcache->set($memcache_key, $num_products_count, false, mt_rand(86400, 86400 * 7));
			}
			if($num_products_count <= 0) {
				array_push($array_auto_match_delete, $result->fields['auto_id']);
			}
	  	}
		
		/*
		$update_data = array(
				"search_number" =>  $num_products_count
		);
		zen_db_perform(TABLE_SEARCH_AUTO_MATCH, $update_data, "update","auto_id = " . $result->fields['auto_id']);
		*/
		
		if($num_products_count > 0) {
			$docs[$i] = array (
				'id' => 'search_auto_match_' . $i,
				'auto_id' => "1" . $i,
				'languages_id' => $result->fields['languages_id'],
				'keyword' => trim($result->fields['keyword']),
				'keyword_general' => trim($result->fields['keyword']),
				'keyword_status' => $result->fields['keyword_status'],
				'date_created' => $result->fields['date_created'],
				'extra_score' => 0
			);
			$i++;
			$memcache_data[$result->fields['languages_id']][] = trim($result->fields['keyword']);
		}
		$result->MoveNext();
	}
	
	if(!empty($array_auto_match_delete)) {
		$auto_ids = implode(",", $array_auto_match_delete);
		$sql = "delete FROM " . TABLE_SEARCH_AUTO_MATCH . " WHERE auto_id in(" . $auto_ids . ")";
		$result = $db->Execute($sql);
		
		$sql = "delete FROM " . TABLE_SEARCH_RELATED . " where auto_id not in(" . $auto_ids . ")";
		$result = $db->Execute($sql);
	}
	
	foreach($memcache_data as $key => $value) {
		$memcache_key = md5(MEMCACHE_PREFIX . "search_auto_match_" . $key);
		$memcache->set($memcache_key, $memcache_data[$key], false, 604800);
	}
	
	/*
	$solr_core = '8seasons_search_auto_match_all_languages';
	$solr = new Apache_Solr_service(SOLR_HOST, SOLR_PORT, '/solr/' . $solr_core);
	if (!$solr->ping()) {
		echo 'Solr server not responding';
		exit;
	}
	$solr->deleteByQuery("*:*");
	$solr->commit();

	$documents = array ();
	foreach ($docs as $item => $fields) {
		$solrdoc = new Apache_Solr_Document();
		foreach ($fields as $key => $value) {
			$solrdoc-> $key = $value;
		}
		$documents[] = $solrdoc;
	}
	try {
		$solr->addDocuments($documents);
		$solr->commit();
		$solr->optimize();
	} catch (Exception $ex) {
		echo $ex->getMessage();
	}

	$lastime = microtime(true);
	echo '提交数量量为: <font color=red>' . count($docs) . '</font>条<br>';
	echo '数据组装花费: ' . round(($getDataTime - $startime), 4) . '<br>';
	echo 'solr数据提交花费: ' . round(($lastime - $getDataTime), 4) . '<br>';
	echo '总花费: ' . round(($lastime - $startime), 4) . '<br>';
	*/
	echo 'success';
}
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>