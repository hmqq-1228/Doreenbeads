<?php 
/**
 * ez_pages ("page") header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 4881 2006-11-04 17:51:31Z ajeh $
 */
/*
* This "page" page is the display component of the ez-pages module
* It is called "page" instead of "ez-pages" due to the way the URL would display in the browser
* Aesthetically speaking, "page" is more professional in appearance than "ez-page" in the URL
*
* The EZ-Pages concept was adapted from the InfoPages contribution for Zen Cart v1.2.x, with thanks to Sunrom et al.
*/

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_EZPAGE');

$ezpage_id = (int)$_GET['id'];
if ($ezpage_id == 0) zen_redirect(zen_href_link(FILENAME_DEFAULT));

$var_pageDetails = $db->Execute("select ze.pages_id , zed.pages_title , zed.pages_breadcrumb , zed.pages_html_text_mobile from " . TABLE_EZPAGES . " ze inner join " . TABLE_EZPAGES_DESCRIPTION . " zed on zed.pages_id = ze.pages_id where status_page_mobile = 10 and 
											zed.languages_id= ".$_SESSION['languages_id'] . "
											and ze.pages_id = " . (int)$ezpage_id);


if($var_pageDetails->RecordCount() == 0 || trim($var_pageDetails->fields['pages_html_text_mobile']) == ''){
	header('HTTP/1.1 302 Object Moved');
	zen_redirect(zen_href_link(FILENAME_DEFAULT, '', 'NONSSL'));
}

// set Page Title for heading, navigation, etc
// define('NAVBAR_TITLE', $var_pageDetails->fields['pages_title']);
// define('HEADING_TITLE', $var_pageDetails->fields['pages_title']);
$breadcrumb->add($var_pageDetails->fields['pages_breadcrumb']);

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

// end flag settings for sections to disable
$smarty->assign ('pageID' , $_GET['id']);
$smarty->assign ('var_pageDetails' , $var_pageDetails->fields);
// $smarty->assign ('counter' , $counter);
// $smarty->assign ('prev_link' , $prev_link);
// $smarty->assign ('next_link' , $next_link);
// $smarty->assign ('next_item_button' , $next_item_button);
// $smarty->assign ('previous_button' , $previous_button);
// $smarty->assign ('home_button' , zen_back_link() . $home_button);
// $smarty->assign ('pages_listing_num' , $pages_listing->RecordCount() );

// $i = 0;
// while(!$pages_listing->EOF){
// 	$pages_listing_array[$i] = $pages_listing->fields;
// 	$pages_listing_array[$i]['link'] = zen_ez_pages_link($pages_listing->fields['pages_id']);
// 	$i++;
// 	$pages_listing->MoveNext();
// }
// $smarty->assign ('pages_listing' , $pages_listing_array);

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_EZPAGE');
?>