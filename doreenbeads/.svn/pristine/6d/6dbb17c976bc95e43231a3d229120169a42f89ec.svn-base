<?php
/**
 * Google XML Sitemap Feed
 *
 * @package Google XML Sitemap Feed
 * @copyright Copyright 2005-2007, Andrew Berezin eCommerce-Service.com
 * @copyright Portions Copyright 2005, Bobby Easland
 * @copyright Portions Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @link http://www.sitemaps.org/
 * @link http://www.google.com/webmasters/sitemaps/docs/en/about.html About Google Sitemap
 * @version $Id: googlesitemap.php, v 1.3.13 14.08.2007 10:32 Andrew Berezin $
 */

	@define('GOOGLE_SITEMAP_VERSION', 'v 1.3.13 14.08.2007 10:32');

	require_once('includes/application_top.php');

	$time_start = explode (' ', microtime());

	@define('GOOGLE_SITEMAP_COMPRESS', 'false');
	@define('GOOGLE_SITEMAP_PROD_CHANGE_FREQ', 'weekly');
	@define('GOOGLE_SITEMAP_CAT_CHANGE_FREQ', 'weekly');
	@define('GOOGLE_SITEMAP_LASTMOD_FORMAT', 'date');
	@define('GOOGLE_SITEMAP_CAT_CHANGE_PRIOR', 0.5);
	@define('GOOGLE_SITEMAP_USE_XSL', 'true');
	@define('GOOGLE_SITEMAP_USE_ROOT_DIRECTORY', 'true');
	@define('GOOGLE_SITEMAP_XML_FS_DIRECTORY', '');

	@define('GOOGLE_SITEMAP_EZPAGES_HEADER', 'true');
	@define('GOOGLE_SITEMAP_EZPAGES_SIDEBOX', 'true');
	@define('GOOGLE_SITEMAP_EZPAGES_FOOTER', 'true');
	@define('GOOGLE_SITEMAP_EZPAGES_CHANGE_FREQ', 'weekly');
	@define('GOOGLE_SITEMAP_EZPAGES_CHANGE_PRIOR', 0.5);

	@define('GOOGLE_SITEMAP_MAX_ENTRYS', 50000);
	@define('GOOGLE_SITEMAP_MAX_SIZE', 10000000); //10485760

	if(isset($_REQUEST["zenAdminID"])) define('START_FROM_ADMIN', true);

	if (!get_cfg_var('safe_mode') && function_exists('safe_mode')) {
		set_time_limit(0);
	}

	function timefmt($s) {
		$m = floor($s/60);
		$s = $s - $m*60;
		return $m . ":" . number_format($s, 4);
	}

echo 'Google Sitemap Generation (' . GOOGLE_SITEMAP_VERSION . ') started<br /><br />' . "\n\n";

$google = new GoogleSitemap(DB_SERVER, DB_SERVER_USERNAME, DB_DATABASE, DB_SERVER_PASSWORD);
$submit = true;

if(!isset($_GET['genxml']) || $_GET['genxml'] != 'no') {
echo '<br />';
if ($google->GenerateProductSitemap()){
	echo 'Generated Google Product Sitemap Successfully' . ' - <a href="' . $google->base_url . 'sitemapproducts.xml" target="_blank">' . $google->base_url . 'sitemapproducts.xml</a><br />' . "\n";
} else {
	$submit = false;
	echo '<span style="font-weight: bold; color: red;">ERROR: Google Product Sitemap Generation FAILED!</span><br />' . "\n\n";
}

echo '<br />';
if ($google->GenerateCategorySitemap()){
	echo 'Generated Google Category Sitemap Successfully' . ' - <a href="' . $google->base_url . 'sitemapcategories.xml" target="_blank">' . $google->base_url . 'sitemapcategories.xml</a><br />' . "\n";
} else {
	$submit = false;
	echo '<span style="font-weight: bold; color: red;">ERROR: Google Category Sitemap Generation FAILED!</span><br />' . "\n\n";
}

echo '<br />';
if ($google->GenerateEzpagesSitemap()){
	echo 'Generated Google EZPages Sitemap Successfully' . ' - <a href="' . $google->base_url . 'sitemapezpages.xml" target="_blank">' . $google->base_url . 'sitemapezpages.xml</a><br />' . "\n";
} else {
	$submit = false;
	echo '<span style="font-weight: bold; color: red;">ERROR: Google Category Sitemap Generation FAILED!</span><br />' . "\n\n";
}

////////////////////////////////////
// include the list of extra configure files
/*
	define('DIR_WS_GOOGLESITEMAP_PLUGINS', DIR_WS_INCLUDES . 'plugins/googlesitemap');
	if ($za_dir = @dir(DIR_WS_GOOGLESITEMAP_PLUGINS)) {
		while ($zv_file = $za_dir->read()) {
			if (preg_match('/\.php$/', $zv_file) > 0) {
				if ($google->GeneratePluginSitemap(DIR_WS_GOOGLESITEMAP_PLUGINS . '/' . $zv_file)){
					echo 'Generated Google Sitemap Plugin [' . basename(DIR_WS_GOOGLESITEMAP_PLUGINS . '/' . $zv_file, ".php") . '] Successfully<br />' . "\n\n";
				} else {
					$submit = false;
					echo '<span style="font-weight: bold; color: red;">ERROR: Google Sitemap Sitemap Plugin [' . basename(DIR_WS_GOOGLESITEMAP_PLUGINS . '/' . $zv_file) . '] Generation FAILED!</span><br />' . "\n\n";
				}
			}
		}
	}
*/
////////////////////////////////////
echo '<br />';
if ($google->GenerateSitemapIndex()){
	echo 'Generated Google Sitemap Index Successfully' . ' - <a href="' . $google->base_url . 'sitemapindex.xml" target="_blank">' . $google->base_url . 'sitemapindex.xml</a><br /><br />' . "\n\n";
} else {
	$submit = false;
	echo '<span style="font-weight: bold; color: red;">ERROR: Google Sitemap Index Generation FAILED!</span><br /><br />' . "\n\n";
}
}
if(isset($_GET['ping']) && $_GET['ping'] == 'yes') {
	$_GET['pinggoogle'] = (isset($_GET['pinggoogle']) ? $_GET['pinggoogle'] : $_GET['ping']);
	$_GET['pingyahoo']  = (isset($_GET['pingyahoo'])  ? $_GET['pingyahoo']  : $_GET['ping']);
	$_GET['pingask']    = (isset($_GET['pingask'])    ? $_GET['pingask']    : $_GET['ping']);
	$_GET['pingms']     = (isset($_GET['pingms'])     ? $_GET['pingms']     : $_GET['ping']);
}
if ($submit){
	if ((isset($_GET['pinggoogle']) && $_GET['pinggoogle'] == 'yes')
	 || (isset($_GET['pingyahoo']) && $_GET['pingyahoo'] == 'yes')
	 || (isset($_GET['pingask']) && $_GET['pingask'] == 'yes')
	 || (isset($_GET['pingms']) && $_GET['pingms'] == 'yes')
			) {
		echo '<br />Start Pinging ----------------------------------------------------------------------------------------';
		if(isset($_GET['pinggoogle']) && $_GET['pinggoogle'] == 'yes') {
			echo '<br />Google Ping...<br />';
			echo '<div style="background-color: #FFFFCC; border: 1px solid #000000; padding: 5px">';
			echo implode('', file('http://www.google.com/webmasters/sitemaps/ping?sitemap=' . $google->submit_url));
			echo '</div>';
		}
		if(isset($_GET['pingyahoo']) && $_GET['pingyahoo'] == 'yes') {
			echo '<br />Yahoo! Ping...<br />';
			echo '<div style="background-color: #FFFFCC; border: 1px solid #000000;">';
			echo implode('', file('http://search.yahooapis.com/SiteExplorerService/V1/ping?sitemap=' . $google->submit_url));
			echo '</div>';
		}
		if(isset($_GET['pingask']) && $_GET['pingask'] == 'yes') {
			echo '<br />Ask.com Ping...<br />';
			echo '<div style="background-color: #FFFFCC; border: 1px solid #000000;">';
			echo implode('', file('http://submissions.ask.com/ping?sitemap=' . $google->submit_url));
			echo '</div>';
		}
		if(isset($_GET['pingms']) && $_GET['pingms'] == 'yes') {
			echo '<br />Microsoft Ping...<br />';
			echo '<div style="background-color: #FFFFCC; border: 1px solid #000000;">';
			echo implode('', file('http://www.moreover.com/ping?u=' . $google->submit_url));
			echo '</div>';
		}
		echo '<br />End Pinging ----------------------------------------------------------------------------------------<br />';
	}
}

	$time_end = explode (' ', microtime());
	$total_time = $time_end[1]+$time_end[0]-$time_start[1]-$time_start[0];

	echo 'Total Execution Time ' . timefmt($total_time) . '<br />';

////////////////////////////////////////////////////////////////////////
// Google Sitemap Base Class

class GoogleSitemap{
	var $filename;
	var $savepath;
	var $base_url;
	var $submit_url;
	var $duplicated_links;

	function GoogleSitemap(){
		global $db;
		$this->filename = "sitemap";
		$this->duplicated_links = array();
		if(GOOGLE_SITEMAP_XML_FS_DIRECTORY == '') {
			$this->savepath = DIR_FS_CATALOG;
			$this->base_url = HTTP_SERVER . DIR_WS_CATALOG;
		} else {
			$this->savepath = rtrim(GOOGLE_SITEMAP_XML_FS_DIRECTORY, '/') . '/';
			$this->base_url = HTTP_SERVER . '/';
		}
		$this->submit_url = utf8_encode(urlencode($this->base_url . 'sitemapindex.xml'));
		echo 'Save path - "' . $this->savepath . '"' . '<br />';
		echo 'Base URL - "' . $this->base_url . '"' . '<br />';
	}

// save the sitemap data to file as either XML or XML.GZ format
	function SaveFileXML($data, $type, $records){
		$filename = $this->savepath . $this->filename . $type;
		$compress = defined('GOOGLE_SITEMAP_COMPRESS') ? GOOGLE_SITEMAP_COMPRESS : 'false';
		if ($type == 'index') $compress = 'false';
		switch($compress){
			case 'true':
				$filename .= '.xml.gz';
				echo 'Processing file: ' . $filename;
				if ($gz = gzopen($filename,'wb9')){
					gzwrite($gz, $data, strlen($data));
					gzclose($gz);
					echo ' OK! Written ' . $records . ' records, ' . strlen($data) . ' bytes <br />';
					return true;
				} else {
					echo ' Failed!<br />';
					$file_check = file_exists($filename) ? 'true' : 'false';
					return false;
				}
				break;
			default:
				$filename .= '.xml';
				echo 'Processing file: ' . $filename;
				if ($fp = fopen($filename, 'w+')){
					fwrite($fp, $data, strlen($data));
					fclose($fp);
					echo ' OK! Written ' . $records . ' records, ' . strlen($data) . ' bytes <br />';
					return true;
				} else {
					echo ' Failed!<br />';
					$file_check = file_exists($filename) ? 'true' : 'false';
					return false;
				}
				break;
		}
	}

// generate sitemap file from data
	function GenerateSitemap($data, $file){
		$contentXML = "";
		$number = 0;
		$file_num = 1;
		$ret = false;
		if(!is_array($data) || sizeof($data) <= 0) {
			return $this->SaveFileXML('', $file, 0);
		}
		foreach ($data as $url){
			if ($number >= GOOGLE_SITEMAP_MAX_ENTRYS || strlen($contentXML) >= GOOGLE_SITEMAP_MAX_SIZE) {
				$ret = $this->SaveFileXML($this->GoogleXMLHeader('urlset') . $contentXML . '</urlset>', $file . substr('000' . $file_num, -3), $number);
				$file_num++;
				$contentXML = "";
				$number = 0;
			}
			$number++;
			$contentXML .= ' <url>' . "\n";
			$contentXML .= '  <loc>' . utf8_encode($url['loc']) . '</loc>' . "\n";
			if(isset($url['lastmod']) && $url['lastmod'] != '')
				$contentXML .= '  <lastmod>' . $this->LastMod($url['lastmod']) . '</lastmod>' . "\n";
			if(isset($url['changefreq']) && $url['changefreq'] != '')
				$contentXML .= '  <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
			if(isset($url['priority']) && $url['priority'] != '')
				$contentXML .= '  <priority>' . $url['priority'] . '</priority>' . "\n";
			$contentXML .= ' </url>' . "\n";
		}
		if ($contentXML != "") {
			$ret = $this->SaveFileXML($this->GoogleXMLHeader('urlset') . $contentXML . '</urlset>', $file . ($file_num == 1 ? '' : substr('000' . $file_num, -3)), $number);
		}
		return $ret;
	}

// generate sitemap index file
	function GenerateSitemapIndex(){
		$content = $this->GoogleXMLHeader('sitemapindex');
		$records_count = 0;
		if ($za_dir = @dir(rtrim($this->savepath, '/'))) {
			while ($filename = $za_dir->read()) {
				$pattern = (GOOGLE_SITEMAP_COMPRESS == 'true' ? '(?:\.xml|\.gz)' : '\.xml');
				if (preg_match('/^' . $this->filename . '.*' . $pattern . '$/', $filename) > 0) {
					if (strpos($filename, $this->filename . 'index.') === 0) continue;
					clearstatcache();
					if (!filesize($this->savepath . $filename)) continue;
					$content .= ' <sitemap>' . "\n";
					$content .= '  <loc>' . $this->base_url . basename($filename) . '</loc>' . "\n";
					$content .= '  <lastmod>' . $this->LastMod(filemtime($this->savepath . $filename)) . '</lastmod>' . "\n";
					$content .= ' </sitemap>' . "\n";
					$records_count++;
				}
			}
		}
		$content .= '</sitemapindex>';
		return $this->SaveFileXML($content, 'index', $records_count);
	}

// generate product sitemap data
	function GenerateProductSitemap(){
		global $db;
		$container = array();
		$products = $db->Execute("SELECT max(products_ordered) as max_products_ordered
															FROM " . TABLE_PRODUCTS . "
															WHERE products_status = '1'");
		$max_products_ordered = $products->fields[max_products_ordered];

		$products = $db->Execute("SELECT p.products_id, GREATEST(p.products_date_added, IFNULL(p.products_last_modified, 0)) AS last_date, p.products_ordered, l.code
															FROM " . TABLE_PRODUCTS . " p
																LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON (p.products_id = pd.products_id)
																LEFT JOIN " . TABLE_LANGUAGES . " l ON (pd.language_id = l.languages_id)
															WHERE p.products_status = '1'
															ORDER BY p.products_ordered desc");
		while(!$products->EOF){
			$ratio = ($max_products_ordered > 0 ? number_format($products->fields['products_ordered']/$max_products_ordered, 2) : 1);
			if (defined('GOOGLE_SITEMAP_PROD_CHANGE_PRIOR') && GOOGLE_SITEMAP_PROD_CHANGE_PRIOR != 0)
				$priority = GOOGLE_SITEMAP_PROD_CHANGE_PRIOR;
			else
				$priority = $ratio < 0.1 ? 0.1 : $ratio;
			if($products->fields['code'] != DEFAULT_LANGUAGE)
				$product_url_add = '&language=' . $products->fields['code'];
			else
				$product_url_add = '';
			$link = zen_href_link('product_info', 'products_id=' . $products->fields['products_id'] . $product_url_add, 'NONSSL', false);
			if(!isset($this->duplicated_links[$link])) {
				$this->duplicated_links[$link] = true;
				$container[$link] = array('loc' => $link,
														 'lastmod' => strtotime($products->fields['last_date']),
														 'changefreq' => GOOGLE_SITEMAP_PROD_CHANGE_FREQ,
														 'priority' => $priority);
			}
			$products->MoveNext();
		}
		return $this->GenerateSitemap($container, 'products');
	}

// generate category sitemap data
	function GenerateCategorySitemap(){
		global $db;
		$container = array();
		$categories = $db->Execute("SELECT c.categories_id, GREATEST(c.date_added, IFNULL(c.last_modified, 0)) AS last_date, l.code
																FROM " . TABLE_CATEGORIES . " c
																	LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " cd ON (cd.categories_id = c.categories_id)
																	LEFT JOIN " . TABLE_LANGUAGES . " l ON (cd.language_id = l.languages_id)
																WHERE c.categories_status = '1'
																ORDER BY c.sort_order ASC, c.parent_id ASC, c.categories_id ASC");
		while(!$categories->EOF){
			$link = zen_href_link(FILENAME_DEFAULT, ($categories->fields['code'] != DEFAULT_LANGUAGE ? 'language=' . $categories->fields['code'] : "") . '&cPath=' . $this->GetFullcPath($categories->fields['categories_id']), 'NONSSL', false);
			if(!isset($this->duplicated_links[$link])) {
				$this->duplicated_links[$link] = true;
				$container[$link] = array('loc' => $link,
																	'lastmod' => strtotime($categories->fields['last_date']),
																	'changefreq' => GOOGLE_SITEMAP_CAT_CHANGE_FREQ,
																	'priority' => GOOGLE_SITEMAP_CAT_CHANGE_PRIOR);
			}
			$categories->MoveNext();
		}
		return $this->GenerateSitemap($container, 'categories');
	}

// generate Ezpages sitemap data
	function GenerateEzpagesSitemap(){
		global $db;
		$where = array();
// 		if(GOOGLE_SITEMAP_EZPAGES_HEADER == 'true')  $where[] = '(status_header = 1 AND header_sort_order > 0)';
// 		if(GOOGLE_SITEMAP_EZPAGES_SIDEBOX == 'true') $where[] = '(status_sidebox = 1 AND sidebox_sort_order > 0)';
// 		if(GOOGLE_SITEMAP_EZPAGES_FOOTER == 'true')  $where[] = '(status_footer = 1 AND footer_sort_order > 0)';
		if(sizeof($where) == 0) return false;
		$container = array();
		$page_query = $db->Execute("SELECT *
																FROM " . TABLE_EZPAGES . "
																WHERE " . implode('OR',$where));
		while (!$page_query->EOF) {
			if($page_query->fields['alt_url_external'] == '') { // skip external link
				if($page_query->fields['alt_url'] != '') { // internal link
					$link = (substr($page_query->fields['alt_url'],0,4) == 'http') ?
						$page_query->fields['alt_url'] :
						zen_href_link($page_query->fields['alt_url'], '', ($page_query->fields['page_is_ssl']=='0' ? 'NONSSL' : 'SSL'), true, true, true);
				} else { // use EZPage ID to create link
					$link = zen_href_link(FILENAME_EZPAGES, 'id=' . $page_query->fields['pages_id'] . '&chapter=' . $page_query->fields['toc_chapter'], ($page_query->fields['page_is_ssl']=='0' ? 'NONSSL' : 'SSL'));
				}
				if(!isset($this->duplicated_links[$link])) {
					$this->duplicated_links[$link] = true;
					$container[$link] = array('loc' => $link,
	//														 'lastmod' => time(),
																	 'changefreq' => GOOGLE_SITEMAP_EZPAGES_CHANGE_FREQ,
																	 'priority' => GOOGLE_SITEMAP_EZPAGES_CHANGE_PRIOR);
				}
			}
			$page_query->MoveNext();
		}
		return $this->GenerateSitemap($container, 'ezpages');
	}

//
	function GeneratePluginSitemap($plugin_file){
		$sitemap_container = array();
		$sitemap_filename = basename($plugin_file, ".php");
		include($plugin_file);
		if(sizeof($sitemap_container) > 0)
			return $this->GenerateSitemap($sitemap_container, $sitemap_filename);
		return false;
	}

// retrieve full cPath from category ID
	function GetFullcPath($cID){
		global $db;
		static $parent_cache = array();
		$cats = array();
		$cats[] = $cID;
		$parent = $db->Execute("SELECT parent_id, categories_id
														FROM " . TABLE_CATEGORIES . "
														WHERE categories_id=" . (int)$cID);
		while(!$parent->EOF && $parent->fields['parent_id'] != 0) {
			$parent_cache[(int)$parent->fields['categories_id']] = (int)$parent->fields['parent_id'];
			$cats[] = $parent->fields['parent_id'];
			if(isset($parent_cache[(int)$parent->fields['parent_id']])) {
				$parent->fields['parent_id'] = $parent_cache[(int)$parent->fields['parent_id']];
			} else {
				$parent = $db->Execute("SELECT parent_id, categories_id
																FROM " . TABLE_CATEGORIES . "
																WHERE categories_id=" . (int)$parent->fields['parent_id']);
			}
		}
		$cats = array_reverse($cats);
		$cPath = implode('_', $cats);
		return $cPath;
	}

// format the LastMod field
	function LastMod($date){
		if(GOOGLE_SITEMAP_LASTMOD_FORMAT == 'full') {
			$timezone = date('O',$date);
			return gmdate('Y-m-d\TH:i:s', $date) . substr($timezone, 0, 3) . ":" . substr($timezone, 3, 2);
		} else {
			return gmdate('Y-m-d', $date);
		}
	}

// Utility function to format the Google XML Header
	function GoogleXMLHeader($tag){
		return '<?xml version="1.0" encoding="UTF-8"?'.'>' . "\n" .
					(GOOGLE_SITEMAP_USE_XSL == 'true' ? '<?xml-stylesheet type="text/xsl" href="gss.xsl"?'.'>' . "\n" : "") .
					 '<' . $tag . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\n" .
					 '        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' . "\n" .
					 '        http://www.sitemaps.org/schemas/sitemap/0.9/' . ($tag == 'urlset' ? 'sitemap' : 'siteindex') . '.xsd"' . "\n" .
					 '        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	}

}
?>