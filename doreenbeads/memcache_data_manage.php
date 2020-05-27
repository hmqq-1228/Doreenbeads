<?php
@set_time_limit(50000);
@ini_set('memory_limit','2048M');
require("includes/application_top.php");
require("includes/access_ip_limit.php");

if(!isset($_GET['type']) || $_GET['type']==''){
	die('need type');
}
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");
$memcache = new Memcache;
$memcache->connect(MEMCACHE_HOST, MEMCACHE_PORT) or die ("Could not connect");
switch($_GET['type']){
	case 'property':
		$key_prefix = 'property_';
		$language_query = $db->Execute("select languages_id from ".TABLE_LANGUAGES);
		while(!$language_query->EOF){
			$lang_id = $language_query->fields['languages_id'];
			$property_query = $db->Execute("select p.property_id,p.property_group_id,p.sort_order,pd.property_name from ".TABLE_PROPERTY." p, ".TABLE_PROPERTY_DESCRIPTION." pd
							where pd.property_id=p.property_id and p.property_status=1 and pd.languages_id='".$lang_id."'");
			while(!$property_query->EOF){
				$data_key = $key_prefix.$property_query->fields['property_id'].'_'.$lang_id;
				
				$data_object = new stdClass;
				$data_object->name= $property_query->fields['property_name'];
				$data_object->group_id = $property_query->fields['property_group_id'];
				$data_object->sort_order = $property_query->fields['sort_order'];
				
				$memcache->set($data_key, $data_object, false, 86400*7);
				$property_query->MoveNext();
			}
			$language_query->MoveNext();
		}
		
		break;
	default:
		break;
}



$lastime = microtime(true);

echo '总花费: '.round(($lastime-$startime),4).'<br>';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>