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

$action = $_POST['action'];
switch ($action){
    case 'add_auth_code':
        $return_arr = array( 'add_auth_code'=>false , 'auth_code_content' => '');

        if($_SESSION['auto_auth_code_display']['customized'] >= 3){
            $return_arr['add_auth_code'] = true;
            $return_arr['auth_code_content'] = '<p>&nbsp; &nbsp;&nbsp; ' . TEXT_VERIFY_NUMBER .':&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; ' . zen_draw_input_field('check_code', '', 'size="25" id="check_code_input" class="text" style="WIDTH: 60PX;height: 18px;margin-right:15px;margin-left: 2px;"') . '<img src="./check_code.php" style="height: 23px;position:relative;top:8px;left:5px"  onClick="this.src=\'./check_code.php?\'+Math.random();" /><span style="display:none;color:#f00;font-size:12px; margin-left: 20px;" id="auth_tips"> ' . TEXT_INPUT_RIGHT_CODE .'</span></p>';
        }

        echo json_encode($return_arr);
        exit;
        break;
}

$ezpage_id = (int)$_GET['id'];
if ($ezpage_id == 0) zen_redirect(zen_href_link(FILENAME_DEFAULT));

$var_pageDetails = $db->Execute("select ze.pages_id , ze.status_left_sidebox , zed.pages_title , zed.pages_breadcrumb , zed.pages_html_text_web from " . TABLE_EZPAGES . " ze inner join " . TABLE_EZPAGES_DESCRIPTION . " zed on zed.pages_id = ze.pages_id where 
											languages_id= ".$_SESSION['languages_id'] . "
											and ze.pages_id = " . (int)$ezpage_id  . ' and status_page_web = 10');

if($var_pageDetails->RecordCount() == 0 || trim($var_pageDetails->fields['pages_html_text_web']) == ''){
    header('HTTP/1.1 302 Object Moved');
    zen_redirect(zen_href_link(FILENAME_DEFAULT, '', 'NONSSL'));
}

//bof breadcrumb, back to help center
if (in_array($var_pageDetails->fields['pages_id'], array(45, 15))){
    $breadcrumb->add(TEXT_HEADER_HELP_CENTER, zen_href_link(FILENAME_CUSTOMER_SERVICE));
    $_SESSION['pages_breadcrumb'] = $var_pageDetails->fields['pages_breadcrumb'];
}
if (isset($_SESSION['pages_breadcrumb']) && preg_match('/ezpage-(15|45)/', $_SERVER['HTTP_REFERER'])){
    $breadcrumb->add(TEXT_HEADER_HELP_CENTER, zen_href_link(FILENAME_CUSTOMER_SERVICE));
    $breadcrumb->add($_SESSION['pages_breadcrumb'], $_SERVER['HTTP_REFERER']);
    unset($_SESSION['pages_breadcrumb']);
}
//eof

// set Page Title for heading, navigation, etc
// define('NAVBAR_TITLE', $var_pageDetails->fields['pages_title']);
// define('HEADING_TITLE', $var_pageDetails->fields['pages_title']);
$breadcrumb->add($var_pageDetails->fields['pages_breadcrumb']);

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_EZPAGE');