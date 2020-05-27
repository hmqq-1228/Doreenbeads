<?php
/**
* GOOGLE FEED for dorabeads
* xiaoyong.lv@20140903
*/

require('includes/application_top.php');
require_once(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping();
set_time_limit(0);
ini_set('memory_limit','2048M');

$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

function noBreakWord($string, $max){
	$testChar = substr($string, $max, 1);
	if ($testChar == " ") {
		return substr($string, 0, $max); 
	} else {
		while ($testChar<>" "){
			$testChar = substr($string, $max, 1);
			if ($testChar == " "){
				return substr($string, 0, $max);
			} else {
				$max = $max-1;
			}
		}
	}
}
function get_enhtml($string){
	$pattern=array ("'<script[^>]*?>.*?</script>'si",// 去掉 javascript
		"'<style[^>]*?>.*?</style>'si",// 去掉 HTML 标记
		"'<[/!]*?[^<>]*?>'si",//去掉 HTML 标记
		"'<!--[/!]*?[^<>]*?>'si", // 去掉 注释标记
		"'&(quot|#34);'i",
		"'&(amp|#38);'i",
		"'&(lt|#60);'i",
		"'&(gt|#62);'i",
		"'&(nbsp|#160);'i",
		"'&(iexcl|#161);'i",
		"'&(cent|#162);'i",
		"'&(pound|#163);'i",
		"'&(copy|#169);'i",
		"'&#(d+);'e");
	$replace=array ("", "", "", "", "1", "", "&", "", "", " ", chr(161), chr(162), chr(163), chr(169), "chr(1)");
	$string=preg_replace($pattern, $replace, $string);
	$string=preg_replace("/<(.*?)>/","",$string);
	$string=str_replace("\n","",$string);
	$string=str_replace("\r","",$string);
	$string=str_replace("  ","",$string);
	$string=str_replace("  ","",$string);
	$string=str_replace("\t"," ",$string);
	$string=str_replace("\"","",$string);
	$string=str_replace("<br/>","",$string);
	$string=str_replace("<br />","",$string);
	return addslashes(trim($string));
}

/**
 * 得到google类别ID(通过产品ID)
 * @param int $products_id
 * @return array
 */
function get_google_category_by_products_id($products_id) {
	global $db;
	
	$array_google_categories = array(
		array('32' => array('first_categories_id' => 1729, 'second_categories_id' => 1730)),
		array('197' => array('first_categories_id' => 1729, 'second_categories_id' => 1761)),
		array('502979' => array('first_categories_id' => 1729, 'second_categories_id' => 1762)),
		array('502979' => array('first_categories_id' => 1729, 'second_categories_id' => 1768)),
		array('505408' => array('first_categories_id' => 1729, 'second_categories_id' => 1803)),
		array('192' => array('first_categories_id' => 1729, 'second_categories_id' => 1831)),
		array('5996' => array('first_categories_id' => 1729, 'second_categories_id' => 1791)),
		array('175' => array('first_categories_id' => 1729, 'second_categories_id' => 1823)),
		array('192' => array('first_categories_id' => 1729, 'second_categories_id' => 1785)),
		array('6102' => array('first_categories_id' => 1729, 'second_categories_id' => 1860)),
		array('4226' => array('first_categories_id' => 1729, 'second_categories_id' => 2310)),
		array('504639' => array('first_categories_id' => 1888)),
		array('188' => array('first_categories_id' => 1869)),
		array('4226' => array('first_categories_id' => 1909, 'second_categories_id' => 1920)),
		array('505393' => array('first_categories_id' => 1909, 'second_categories_id' => 1928)),
		array('7016' => array('first_categories_id' => 1974, 'second_categories_id' => 2140))
	);

	$data = array('success' => 1, 'google_category' => 505372);
	$query = "SELECT * FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " WHERE products_id = :products_id";
	$query = $db->bindVars($query, ':products_id', $products_id, 'integer');
	$result = $db->Execute($query);
	$products_categories = array();
	while(!$result->EOF) {
		array_push($products_categories, $result->fields);
		$result->MoveNext();
	}
	foreach($products_categories as $category_value) {
		foreach($array_google_categories as $temp_key => $temp_value) {
			foreach($temp_value as $google_category_key => $google_category_value) {
				if(!empty($google_category_value['first_categories_id']) && !empty($google_category_value['second_categories_id'])) {
					if($google_category_value['first_categories_id'] == $category_value['first_categories_id'] && $google_category_value['second_categories_id'] == $category_value['second_categories_id']) {
						$data['google_category'] = $google_category_key;
					}
				} elseif(!empty($google_category_value['first_categories_id']) && empty($google_category_value['second_categories_id'])) {
					if($google_category_value['first_categories_id'] == $category_value['first_categories_id']) {
						$data['google_category'] = $google_category_key;
					}
				}
			}
		}
	}
	return $data;
}

//	US USD	GB GBP	AU AUD	CA CAD	NZ NZD	RU RUB	DE EUR	FR EUR	ES EUR	IT EUR	JP JPY
//$huobi = 'EUR';
//$guojia = 'DE';
//$lang = 2;
$huobi = $_SESSION['currency'] = $_GET['huobi'];//USD
$guojia = $_GET['guojia'];//US
$lang = intval($_GET['lang']);//1
$limit_stock = $_GET['limit_stock'];
if(empty($huobi) || empty($guojia) || empty($lang)) {
	die("Error");
}

$array_country = array(
	'US' => array(
		'time' => -16,
		'zone' => "-08:00"
	),
	'GB' => array(
		'time' => -8,
		'zone' => "+00:00"
	),
	'DE' => array(
		'time' => -7,
		'zone' => "+01:00"
	),
	'FR' => array(
		'time' => -7,
		'zone' => "+01:00"
	),
	'AU' => array(
		'time' => 2,
		'zone' => "+10:00"
	),
	'CA' => array(
		'time' => -13,
		'zone' => "-05:00"
	),
	'IT' => array(
		'time' => -7,
		'zone' => "+01:00"
	),
	'JP' => array(
		'time' => 1,
		'zone' => "+09:00"
	),
    'NZ' => array(
        'time' => 4,
        'zone' => "+12:00"
    ),
    'SG' => array(
        'time' => 0,
        'zone' => "+08:00"
    )
);

if(!isset($array_country[$guojia])) {
	die("Error");
}

$limit_stock_where = " and p.products_limit_stock = 0";
//if($limit_stock == "NEW") {
//	$limit_stock_where = "";
//}

$catalog_languages = new language();
foreach($catalog_languages->catalog_languages as $catalog_languages_key => $catalog_languages_value) {
	if($catalog_languages_value['id'] == $lang) {
		$_SESSION["languages_id"] = $lang;
		$_SESSION["languages_code"] = $catalog_languages_key;
	}
}

$time_30 = date('Y-m-d H:i:s', (time() - (86400 * 30)));
//Tianwen.Wan20170118->利用solr服务器上最近一个月的产品销量数据
$products_ordered_array = json_decode(file_get_contents(HTTP_IMG_SERVER . "log/data_cache/products_ordered_array.txt"), true);

$file_name_feed_temp = 'feed/DoreenbeadsFeed_'. $guojia . $huobi . $limit_stock . '_temp.txt';
$file_name_feed = 'feed/DoreenbeadsFeed_'. $guojia . $huobi . $limit_stock . '.txt';
$fp = fopen($file_name_feed_temp, 'w');
$head = array('id','title','description','google product category','product type','link','image link','condition','availability','price','sale_price','sale_price_effective_date','mpn','brand','tax','shipping','shipping weight','custom_label_0','custom_label_1');//,'is_Preorder'
$h = implode("\t", $head);
//fputcsv($fp, $head);
fputs($fp, $h."\n");

//Featured Catagories, Jewelry Supplies, jewelry tools
$sql = "select p.products_id,p.products_weight,p.products_model,p.products_price,p.products_image,p.products_date_added,is_preorder,ps.products_quantity,p.products_limit_stock
	from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_STOCK . " ps
	where p.products_id = ps.products_id
	and p.products_status = 1
	" . $limit_stock_where . " 
	and (ps.products_quantity > 10 or p.is_preorder = 1)
	order by p.products_id asc";

$res = $db->Execute($sql);
$n = 0;
while(! $res->EOF){
	$id = $res->fields['products_id'];
	$data = array();

	$data[] = $id;
	$products_name = get_products_description_memcache($id, $lang);
	$products_name = str_replace('(','',$products_name);
	$products_name = str_replace(')','',$products_name);
	$products_name = str_replace(',','',$products_name);
	$products_name = str_replace('/','',$products_name);
	$products_name = str_replace("\/\/",'',$products_name);
	$data[] = getstrbylength(zen_clean_html($products_name), 60);
	$desc = $db->Execute("select products_description from t_products_info where products_id=".(int)$id." and language_id=".$lang);
	$products_description = "";
    if(!empty($desc->fields['products_description'])) {
    	$products_description = $desc->fields['products_description'];
    }
    $data[] = get_enhtml($products_description);

    $cPath = zen_get_product_path($id);
    $cPath_array = zen_parse_category_path($cPath);
    $c_str = '';
    for ($i=0, $n=sizeof($cPath_array); $i<$n; $i++) {
        $categories_query = "select categories_name
							   from " . TABLE_CATEGORIES_DESCRIPTION . "
							   where categories_id = '" . (int)$cPath_array[$i] . "'
							   and language_id = '" . $lang . "'";
        $categories = $db->Execute($categories_query);
        if ($categories->RecordCount() > 0) {
            $c_str .= ($c_str=='' ? '' : ' > ').get_enhtml($categories->fields['categories_name']);
        } else {
            break;
        }
    }
/*
	$c_arr = array();
	$c_arr[1] = 'Arts & Entertainment > Hobbies & Creative Arts > Crafts & Hobbies > Jewelry Making';	//	en
	$c_arr[2] = 'Kunst & Unterhaltung > Hobby & Kunst > Kunsthandwerk & Hobby > Schmuckherstellung';	//	de
	$c_arr[3] = 'Искусство и развлечения > Хобби и творчество > Рукоделие и хобби > Ювелирные изделия и бижутерия';	//	ru
	$c_arr[4] = 'Arts et loisirs Loisirs et arts créatifs > Travaux manuels et hobbies > Fabrification de bijoux > Accessoires pour bijoux';		//	fr
	$c_str = $c_arr[$lang];
*/
	$google_category_data = get_google_category_by_products_id($res->fields['products_id']);
	$data[] = $google_category_data['google_category'];//google product category
	$data[] = $c_str;//product type
	//	product type
	//$data[] = 505372;//$c_str;
	
	$data[] = zen_href_link('product_info', 'products_id=' . $id . '&currency=' . $huobi, 'NONSSL');
	//	img
	$dir = substr($res->fields['products_model'], 0, 1) . '/' . substr($res->fields['products_model'], 0, 3) . '/';
	//$data[] = 'http://img.8seasons.com/bmz_cache/images/watermarkimg_new/' . $dir . $res->fields['products_model'] . 'A_310_310.JPG';
	$data[] = HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($res->fields['products_image'], 310, 310, 'no_watermarkimg');

	$data[] = 'New';
//    if($res->fields['is_preorder'] == 1){
//        $data[] = 'Preorder';
//    }else{
        if($res->fields['products_quantity'] != 0 ){
            $data[] = 'In Stock';
        }else{
            $data[] = 'Out of Stock';
        }

//    }

	$rate = $currencies->currencies[$huobi]['value'];
	$base_price = $price = zen_get_products_discount_price_qty($id, 1, 0, false);
	$price = zen_round($price, 2);
	$data[] = number_format(zen_round($price * $rate, $currencies->currencies[$huobi]['decimal_places']), $currencies->currencies[$huobi]['decimal_places'], $currencies->currencies[$huobi]['decimal_point'], $currencies->currencies[$huobi]['thousands_point']).' '.$huobi;
	$promotion_discount_price = "";
	$promotion_discount_time = "";
	//$promotion_discount = get_promotion_discount_by_products_id($res->fields['products_id']);
	/*
	if($res->fields['pp_is_forbid'] == 10 && $res->fields['promotion_status'] == 1 && $res->fields['pp_promotion_end_time'] > $startdate) {
		$promotion_discount_price = $res->fields['products_price']-($res->fields['products_price']*$res->fields['promotion_discount']/100);
	    $promotion_discount_price = number_format(zen_round($promotion_discount_price * $rate, $currencies->currencies[$huobi]['decimal_places']), $currencies->currencies[$huobi]['decimal_places'], $currencies->currencies[$huobi]['decimal_point'], $currencies->currencies[$huobi]['thousands_point']).' '.$huobi;
    	$promotion_discount_time = str_replace(" ", "T", $promotion_discount->fields['pp_promotion_start_time']) . "-0800" . "/" . str_replace(" ", "T", $promotion_discount->fields['pp_promotion_end_time']) . "-0800";
	}
	*/
	
    
    $dailydeal_protion_query='select dp.dailydeal_price, dp.dailydeal_products_start_date, dp.dailydeal_products_end_date from ' . TABLE_DAILYDEAL_AREA . ' da inner join '. TABLE_DAILYDEAL_PROMOTION . ' dp on dp.area_id = da.dailydeal_area_id where da.area_status = 1
											AND dp.products_id = ' . $res->fields['products_id'] . '
											AND dp.dailydeal_products_start_date <= NOW()
											AND dp.dailydeal_products_end_date > NOW()
											AND dp.dailydeal_is_forbid = 10 limit 1';

    $dailydeal_protion=$db->Execute($dailydeal_protion_query);
    if($dailydeal_protion->RecordCount() > 0) {
    	$promotion_discount_price = $dailydeal_protion->fields['dailydeal_price'];
	    $promotion_discount_price = number_format(zen_round($promotion_discount_price * $rate, $currencies->currencies[$huobi]['decimal_places']), $currencies->currencies[$huobi]['decimal_places'], $currencies->currencies[$huobi]['decimal_point'], $currencies->currencies[$huobi]['thousands_point']).' '.$huobi;
    	$promotion_discount_time = str_replace(" ", "T", date("Y-m-d H:i:s", strtotime($dailydeal_protion->fields['dailydeal_products_start_date']) + ($array_country[$guojia]['time'] * 3600))) . $array_country[$guojia]['zone'] . "/" . str_replace(" ", "T", date("Y-m-d H:i:s", strtotime($dailydeal_protion->fields['dailydeal_products_end_date']) + ($array_country[$guojia]['time'] * 3600))) . $array_country[$guojia]['zone'];
    } else {
    	$promotion_discount_query='select p.promotion_discount, p.promotion_status, pp.pp_promotion_start_time, pp.pp_promotion_end_time from '.TABLE_PROMOTION.' p , '.TABLE_PROMOTION_PRODUCTS.' pp where pp.pp_products_id='.$res->fields['products_id'].' and pp.pp_promotion_id=p.promotion_id and pp.pp_is_forbid = 10 and p.promotion_status = 1  and pp.pp_promotion_start_time < now()  and pp.pp_promotion_end_time > now() limit 1';
	    $promotion_discount=$db->Execute($promotion_discount_query);
	    if($promotion_discount->RecordCount() > 0) {
	    	$promotion_discount_price = $base_price-($base_price*$promotion_discount->fields['promotion_discount']/100);
	    	$promotion_discount_price = number_format(zen_round($promotion_discount_price * $rate, $currencies->currencies[$huobi]['decimal_places']), $currencies->currencies[$huobi]['decimal_places'], $currencies->currencies[$huobi]['decimal_point'], $currencies->currencies[$huobi]['thousands_point']).' '.$huobi;
	    	$promotion_discount_time = str_replace(" ", "T", date("Y-m-d H:i:s", strtotime($promotion_discount->fields['pp_promotion_start_time']) + ($array_country[$guojia]['time'] * 3600))) . $array_country[$guojia]['zone'] . "/" . str_replace(" ", "T", date("Y-m-d H:i:s", strtotime($promotion_discount->fields['pp_promotion_end_time']) + ($array_country[$guojia]['time'] * 3600))) . $array_country[$guojia]['zone'];
	    }
    }

	$data[] = $promotion_discount_price;
	$data[] = $promotion_discount_time;
	$data[] = $res->fields['products_model'];
	$data[] = 'Doreenbeads';
	$data[] = $guojia.'::0:';		//	tax

	//	shipping
	$products_weight = $res->fields['products_weight'] > 50000 ? $res->fields['products_weight'] * 1.06 : $res->fields['products_weight'] * 1.1;
//	$shipping_modules->quote($guojia, $products_weight);
//	$shipping_modules->reduce_airmail_cost();
    $shipping = new shipping('', $guojia, '', '', '', true, $id);
    $shipping_data = $shipping->get_default_shipping_info();
    $shipping_list = $shipping_data['shipping_list'];

	$s_str = '';
	foreach($shipping_list as $code=>$s){
		$title = get_enhtml($s['title']);
		$title = str_replace('[?]', '', $title);
		$s_str .= ($s_str=='' ? '' : ',').$guojia.'::'.$title.':'.number_format(zen_round($s['final_cost'] * $rate, $currencies->currencies[$huobi]['decimal_places']), $currencies->currencies[$huobi]['decimal_places']).' '.$huobi;
	}
	$data[] = $s_str;

	//	shipping weight
	$data[] = $res->fields['products_weight'].' g';
	
	$custom_label_0 = $custom_label_1 = "";
	if(isset($products_ordered_array[$res->fields['products_id']]) && $products_ordered_array[$res->fields['products_id']] >= 30) {
		$custom_label_0 = "best seller";
	}
	
	if($res->fields['products_date_added'] >= $time_30) {
		$custom_label_1 = "new arrival";
	}
	$data[] = $custom_label_0;
	$data[] = $custom_label_1;
//	$data[] = $res->fields['is_preorder'];

	$d = implode("\t", $data);
	//fputcsv($fp, $data);
	fputs($fp, $d."\n");



	$n++;
	$res->MoveNext();
}

fclose($fp);
@unlink($file_name_feed);
@rename($file_name_feed_temp, $file_name_feed);
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
echo "success";
?>