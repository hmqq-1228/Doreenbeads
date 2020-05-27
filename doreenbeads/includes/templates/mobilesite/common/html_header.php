<?php
/**
 * Common Template
 *
 * outputs the html header. i,e, everything that comes before the \</head\> tag <br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: html_header.php 4368 2006-09-03 19:31:00Z drbyte $
 */
/**
 * load the module for generating page meta-tags
 */
require (DIR_WS_MODULES . zen_get_module_directory ( 'meta_tags.php' ));
/**
 * output main page HEAD tag and related headers/meta-tags, etc
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<title><?php echo META_TAG_TITLE; ?></title>
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no,initial-scale=1" name="viewport">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>" />
<meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>" />
<?php if($_GET['main_page']==$this_is_home_page){ ?>
<meta content="index,follow" name="robots" />
<meta content="index,follow" name="GOOGLEBOT" />
<meta content="Beads Wholesale" name="Author" />
<?php } ?>
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name='apple-touch-fullscreen' content='yes'> 
<meta name="full-screen" content="yes"> 
<meta http-equiv="imagetoolbar" content="no" />
<meta name="author" content="http://www.8season-knitting.com" />
<meta name="verify-v1" content="er+Vol32KIC1eD3tjyNZojGyvLudSG34JAIVck5UET4=" />
<meta name="generator" content="zend studio" />
<?php if (defined('ROBOTS_PAGES_TO_SKIP') && in_array($current_page_base,explode(",",constant('ROBOTS_PAGES_TO_SKIP'))) || $current_page_base=='down_for_maintenance') { ?>
<meta name="robots" content="noindex, nofollow" />
<?php } ?>
<?php if (defined('FAVICON')) { ?>
<link rel="icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<?php } //endif FAVICON ?>

<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ); ?>" />

<?php
define ( 'MINIFY_MIN_DIR', 'min' );
$min_app ['groups'] = (require MINIFY_MIN_DIR . '/groupsConfigMobile.php');
$getMainPageCss = $current_page_base . '.css';
$getMainPageJs = $current_page_base . '.js';
$getMainPageCss = (is_array ( $min_app ['groups'] [$getMainPageCss] ) && $min_app ['groups'] [$getMainPageCss] != '') ? $getMainPageCss : 'webDefault.css';
$getMainPageJs = (is_array ( $min_app ['groups'] [$getMainPageJs] ) && $min_app ['groups'] [$getMainPageJs] != '') ? $getMainPageJs : 'webDefault.js';
$chooseCssLang = 'css_' . $_SESSION ['languages_code'] . '_lang/';
$chooseJsLang = 'js_' . $_SESSION ['languages_code'] . '_lang/';
?>
<link href="<?php echo CURRENCY_CSS_JS_VERSION;?>/<?php echo $chooseCssLang;?>min/<?php echo $getMainPageCss;?>" rel="stylesheet" type="text/css">
<script src="<?php echo CURRENCY_CSS_JS_VERSION;?>/<?php echo $chooseJsLang;?>min/<?php echo $getMainPageJs;?>" type="text/javascript"></script>

<script type="text/javascript">
!function(e){if(!window.pintrk){window.pintrk=function(){window.pintrk.queue.push(Array.prototype.slice.call(arguments))};var n=window.pintrk;n.queue=[],n.version="3.0";var t=document.createElement("script");t.async=!0,t.src=e;var r=document.getElementsByTagName("script")[0];r.parentNode.insertBefore(t,r)}}("https://s.pinimg.com/ct/core.js");pintrk('load','2612416394623');
pintrk('page', {
	page_name: 'My Page',
	page_category: 'My Page Category'
});</script><noscript><img height="1" width="1" style="display:none;" alt=""src="https://ct.pinterest.com/v3/?tid=2612416394623&noscript=1" />
</noscript>

<?php
/**
 * include content from all page-specific jscript_*.php files from
 * includes/modules/pages/PAGENAME, alphabetically.
 */
$directory_array = $template->get_template_part ( $page_directory, '/^jscript_/' );
while ( list ( $key, $value ) = each ( $directory_array ) ) {
	/**
	 * include content from all page-specific jscript_*.php files from
	 * includes/modules/pages/PAGENAME, alphabetically.
	 * These .PHP files can be manipulated by PHP when they're called, and are
	 * copied in-full to the browser page
	 */
	require ($page_directory . '/' . $value);
	echo "\n";
}

?>

<?php
/**
 * tpl_footer_googleanalytics.php
 *
 * @package zen-cart analytics
 * @copyright Copyright 2004-2008 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer_googleanalytics.php, v 2.2.1 01.09.2008 01:23 Andrew Berezin $
 */
@define('GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_BRACKETS', '[]');
@define('GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_DELIMITER', '; ');
@define('GOOGLE_ANALYTICS_USE_PAGENAME', 'false');
@define('GOOGLE_ANALYTICS_DOMAINNAME', '');
@define('GOOGLE_ANALYTICS_ALLOWLINKER', 'false');

@define('GOOGLE_CONVERSION_ACTIVE', 'true');
@define('GOOGLE_CONVERSION_ID', '');
@define('GOOGLE_CONVERSION_LANGUAGE', 'en_EN');

if(GOOGLE_ANALYTICS_USE_PAGENAME == 'true') {
  $google_analytics_page = '"' . zen_output_string_protected($breadcrumb->last()) . (isset($_GET['page']) ? ' (' . sprintf(PREVNEXT_TITLE_PAGE_NO, $_GET['page']) . ')' : '') . '"';
} else {
  $google_analytics_page = '';
}
$siteName = 'auto';

$google_analytics_code_arr = explode(';', GOOGLE_ANALYTICS_CODE_MOBILE);
	$siteCode = $google_analytics_code_arr[0];
if($_SESSION['languages_id'] == 2) {
	$siteCode = $google_analytics_code_arr[1];
}elseif($_SESSION['languages_id'] == 3) {
	$siteCode = $google_analytics_code_arr[2];
}elseif($_SESSION['languages_id'] == 4) {
	$siteCode = $google_analytics_code_arr[3];
}
?>
<script type="text/javascript">
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', '<?php echo $siteCode;?>', '<?php echo $siteName;?>');
	  ga('require', 'displayfeatures');
	  ga('send', 'pageview');
	

<?php
 unset($_SESSION['google_analytics']);
// http://www.google.ru/support/googleanalytics/bin/answer.py?answer=55528
if($_GET['main_page'] == FILENAME_CHECKOUT_PAYMENT && (!isset($_SESSION['google_analytics']) || !in_array($zv_orders_id, $_SESSION['google_analytics']))) {
  if(!isset($_SESSION['google_analytics'])) $_SESSION['google_analytics'] = array();
  $zv_orders_id = $_SESSION['order_number_created'];
  $_SESSION['google_analytics'][] = $zv_orders_id;
  $_trackTrans = "ga('require', 'ecommerce', 'ecommerce.js');\r\n";
  require_once(DIR_WS_CLASSES . 'order.php');
  $order = new order($zv_orders_id);
//echo '<pre>';var_export($order);echo '</pre>';
  switch (GOOGLE_ANALYTICS_TARGET) {
    case 'delivery':
      $google_analytics = $order->delivery;
      break;
    case 'billing':
      $google_analytics = $order->billing;
      break;
    case 'customers':
    default:
      $google_analytics = $order->customer;
      break;
  }

  $google_analytics['ot_shipping'] = 0;
  $totals = $db->Execute("SELECT value
                          FROM " . TABLE_ORDERS_TOTAL . "
                          WHERE orders_id = '" . (int)$zv_orders_id . "'
                            AND class = 'ot_shipping'");
  if (!$totals->EOF) {
    $google_analytics['ot_shipping'] = $totals->fields['value'];
  }
	
  	$_trackTrans .="ga('ecommerce:addTransaction', {
		  'id': '".$zv_orders_id."',
		  'affiliation': '".$siteName."',
		  'revenue': '".number_format($order->info['total'], 3, '.', '')."',
		  'shipping': '".number_format($google_analytics['ot_shipping'], 3, '.', '')."',
		  'tax': '".number_format($order->info['tax'], 3, '.', '')."'
		});"."\n";

  for ($i=0; $i<sizeof($order->products); $i++) {
/*
    $category_query = "SELECT cd.categories_name
                       FROM " . TABLE_PRODUCTS . " p
                         LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " cd ON (cd.categories_id = p.master_categories_id)
                       WHERE p.products_id = :productsID
                         AND cd.language_id = :languagesID
                       LIMIT 1";
    $category_query = $db->bindVars($category_query, ':languagesID', $_SESSION['languages_id'], 'integer');
    $category_query = $db->bindVars($category_query, ':productsID', zen_get_prid($order->products[$i]['id']), 'integer');
    $category = $db->Execute($category_query);
    $categories_name = $category->fields['categories_name'];
*/
    $categories_name = zen_get_categories_name_from_product(zen_get_prid($order->products[$i]['id']));
    if(GOOGLE_ANALYTICS_SKUCODE == 'products_model') {
      $products_skucode = $order->products[$i]['model'];
    } else {
      $products_skucode = $order->products[$i]['id'];
    }
    $products_attributes_name = '';
    if (isset($order->products[$i]['attributes'])) {
      for ($j=0; $j<sizeof($order->products[$i]['attributes']); $j++) {
        $products_attributes_name .= $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_DELIMITER;
      }
      $products_attributes_name = substr(GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_BRACKETS, 0, 1) . rtrim($products_attributes_name, GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_DELIMITER) . substr(GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_BRACKETS, 1, 1);
    }

    $_trackTrans.="ga('ecommerce:addItem', {
		  'id': '".$zv_orders_id."',
		  'name': '".zen_output_string_protected(addslashes($order->products[$i]['name'] . $products_attributes_name))."',
		  'sku': '".zen_output_string_protected($products_skucode)."',
		  'category': '".zen_output_string_protected(addslashes($categories_name))."',
		  'price': '".number_format($order->products[$i]['final_price'], 2, '.', '')."',
		  'quantity': '".$order->products[$i]['qty']."'
		}); ". "\n";

    }

    $_trackTrans .= "ga('ecommerce:send');";

    echo $_trackTrans;
    unset($_SESSION['paid_by_ec']);
    unset($_SESSION['google_analytics']);
}
?>
 </script>
 
 <!-- Global site tag (gtag.js) - Google AdWords: 1047889670 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo ADWORDS_SITE_TAG_CODE;?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo ADWORDS_SITE_TAG_CODE;?>');
</script>

<?php 
if($_GET['main_page'] == FILENAME_CHECKOUT_SUCCESS){?>
<!-- Event snippet for 下单成功 conversion page -->
<script>
  gtag('event', 'conversion', {
      'send_to': '<?php echo ADWORDS_SITE_TAG_CODE;?>/HgnBCMzCqlkQsMLQ1AM',
      'value': <?php echo $order->info['total']?>,
      'currency': 'USD',
      'transaction_id': '<?php echo $zv_orders_id;?>'
  });
</script>
<?php 	
}
?>

</head>