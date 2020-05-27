<?php
/*
	session_start();
	header("Content-type: text/html; charset=utf-8");
	define('IS_ADMIN_FLAG',false);
	error_reporting(0);
	include('includes/configure.php');
	include('includes/classes/class.base.php');
	include('includes/classes/db/mysql/query_factory.php');

//	require('includes/application_top.php');
	global $db;
	if (! is_object ( $db )) {
		$db = new queryFactory ();
		$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, '', false);
	}
	if(isset($_POST['languages_id'])){
		$languages_id = intval($_POST['languages_id']);
	}else{
		$languages_id = 1;
	}
   
	if(!$db) {
		echo 'ERROR: Could not connect to the database.';
	}else {
		$categories = DB_PREFIX.'categories_description';
		$isresult = 0;
		$count = 0;
		if(isset($_POST['queryString'])) {
			$limitsize = 10;
			$queryString = $db->prepare_input($_POST['queryString']);
			$queryString = trim($queryString);
			$queryString = str_replace("%", "", $queryString);
			if(strlen($queryString) >0) {
				$query = $db->Execute("SELECT distinct categories_name FROM $categories 
									WHERE categories_name LIKE '$queryString%' and language_id = $languages_id 
									order by categories_name LIMIT $limitsize");
				if($query->RecordCount()>0) {
					$i = 0;
					while (!$query->EOF) {
						$i++;
						$isresult = 1;
						$count++;
						$categories_name = $db->prepare_input($query->fields['categories_name']);
						$str = $query->fields['categories_name'];
						$str = strtolower($str);
						$str = preg_replace('/'.strtolower($queryString).'/',"<span>".ucwords($_POST['queryString'])."</span>",$str,1);
	         			echo '<li id="li_'.$count.'" value="'.$query->fields['categories_name'].'"  onClick="fill(\''.$categories_name.'\');">'.$str.'</li>';
						$query->MoveNext();	  
					}
				}
			}
			if($isresult==0){
				echo '<script>$j(".searchlist").hide();</script>';
			}
		} else {
			echo 'There should be no direct access to this script!';
		}
	}
	*/
chdir("../");
require ("includes/application_top.php");
//require ("includes/SolrPhpClient/Apache/Solr/Service.php");

if (isset ($_POST['queryString'])) {
	$limitsize = 10;
	$queryString = trim($db->prepare_input($_POST['queryString']));
	$queryString = str_replace("  ", " ", str_replace("　", " ", $queryString));//两个空格或中文空格替换成一个空格

	$memcache_key = md5(MEMCACHE_PREFIX . "search_auto_match_" . $_SESSION['languages_id']);
    $data_auto_match = $memcache->get($memcache_key);
    $match_array = array();
    
    $fetch_row = 0;
    foreach($data_auto_match as $key => $value) {
    	//只取所要数据的2倍数据即可，下面要排除重复
    	if($fetch_row >= $limitsize + 10) {
    		break;
    	}
    	$match_data = preg_match("/^" . $queryString . "/i", $value, $match);
    	if($match_data) {
    		array_push($match_array, ucfirst($value));
    		$fetch_row++;
    	}
    }
    $match_array = array_unique($match_array);
    $match_array = array_splice($match_array, 0, $limitsize);
    sort($match_array);
    $count = 1;
    foreach($match_array as $value) {
    	if($count >= $limitsize + 1) {
    		break;
    	}
    	$str = strtolower($value);
		$str = stripslashes(preg_replace('/' . strtolower($queryString) . '/', "<span>" . ucwords($queryString) . "</span>", $str, 1));
		$value = $db->prepare_input($value);
		echo '<li id="li_' . $count . '" value="' . $value . '"  onClick="fill(\'' . $value . '\');">' . $str . '</li>';
    	$count++;
    }
    
    /*Tianwen.Wan20160121不用solr，用上面memcache方式效率更高
    $solr_core = '8seasons_search_auto_match_all_languages';
	$solr_fetch = new Apache_Solr_service(SOLR_HOST, SOLR_PORT, '/solr/' . $solr_core);

	if (!empty ($_SESSION['languages_id'])) {
		$last_category_id = ' AND languages_id:' . $_SESSION['languages_id'];
	}

	//$condition['sort']='extra_score desc';
	$condition['sort'] = 'id asc';
	$condition['facet'] = 'true';
	$condition['facet.mincount'] = '1';
	$condition['facet.limit'] = '-1';
	//count product group by property
	$condition['facet.field'] = 'languages_id';
	$condition['f.properties_id.facet.missing'] = 'false';
	$condition['f.properties_id.facet.method'] = 'enum';
	//range of one fields
	//$condition['facet.range'] = 'products_price';
	//$condition['f.products_price.facet.range.start'] = '0';
	//$condition['f.products_price.facet.range.end'] = '999';
	//$condition['facet.range.gap'] = '1';

	//select returned fields list
	$condition['fl'] = 'keyword,languages_id';

	//parser for boost
	$condition['defType'] = 'edismax';
	//query fields
	$condition['pf'] = 'keyword languages_id';
	//boost score
	$condition['qf'] = 'keyword^0.82 languages_id^0.18';
	//$condition['pf']='products_name^2 categories_name^5 products_name_without_catg^1';
	//score for some value of fields
	//$condition['bq']='is_promotion:1^0.1 is_hot_seller:1^0.8 is_new:1^0.1 is_featured:1^3';
	$condition['bf'] = 'extra_score^0.2 languages_id^0.04';
	//$package_filter = ' AND package_size:0';
	$extra_select_str = 'keyword_general:' . $queryString . '*';
	$extra_select_str .= $last_category_id;
	
	$count_res = $solr_fetch->search($extra_select_str, 0, $limitsize, $condition);
	$num_products_count = $count_res->response->numFound;
	$products_new_split = new splitPageResults('', $item_per_page, '', 'page', false, $num_products_count);
	//$properties_facet = $count_res->facet_counts->facet_fields->properties_id;
	$product_all = $count_res->response->docs;

	$count = 0;
	foreach ($product_all as $prod_val) {
		$product_res[] = $prod_val->keyword;

		$str = strtolower($prod_val->keyword);
		$str = preg_replace('/' . strtolower($queryString) . '/', "<font color='blue'>" . ucwords($queryString) . "</font>", $str, 1);
		echo '<li id="li_' . $count . '" value="' . $prod_val->keyword . '"  onClick="fill(\'' . $prod_val->keyword . '\');">' . $str . '</li>';
		$count++;
	}
	*/
	if ($count <= 0) {
		echo '<script>$j("#suggestions").hide();</script>';
	}
}
?>