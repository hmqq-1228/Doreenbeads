<?php
/**
 * ezpages functions - used to prepare links for EZ-Pages
 *
 * @package functions
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_ezpages.php 5662 2007-01-22 17:19:26Z drbyte $
 */


/**
 * look up page_id and create link for ez_pages
 * to use this link add '\<a href="' . zen_ez_pages_link($pages_id) . '">\</a>';
 */
// to use this link add '<a href="' . zen_ez_pages_link($pages_id) . '"></a>';
  function zen_ez_pages_link($ez_pages_id, $ez_pages_chapter = 0, $ez_pages_is_ssl = false, $ez_pages_open_new_window = false, $ez_pages_return_full_url = false) {
    global $db;
    $ez_link = 'unknown';
    $ez_pages_name = 'Click Here';

    if ($ez_pages_chapter == 0) {
         $page_query = $db->Execute("select ze.pages_id , ze.status_left_sidebox ,   zed.pages_title , zed.pages_breadcrumb , zed.pages_html_text_web from " . TABLE_EZPAGES . " ze inner join " . TABLE_EZPAGES_DESCRIPTION . " zed on zed.pages_id = ze.pages_id where 
											languages_id= ".$_SESSION['languages_id'] . "
											and ze.pages_id = " . (int)$ezpage_id  .  ' and status_page_web = 10 limit 1');

      $ez_pages_id = $page_query->fields['pages_id'];
      $ez_pages_name = $page_query->fields['pages_title'];
//       $ez_pages_alturl = $page_query->fields['alt_url'];
//       $ez_pages_chapter = $page_query->fields['toc_chapter'];
      $ez_pages_linkto = "";
//       $ez_pages_external = $page_query->fields['alt_url_external'];
//       switch (true) {
//         // external link new window or same window
//         case ($ez_pages_external != ''):
//           $ez_pages_linkto  = $ez_pages_external;
//           break;
//           // internal link new window
//         case ($ez_pages_alturl != '' and $ez_pages_open_new_window == '1'):
//           $ez_pages_linkto  = (substr($ez_pages_alturl,0,4) == 'http') ?
//                               $ez_pages_alturl :
//                               ($ez_pages_alturl=='' ? '' : zen_href_link($ez_pages_alturl, '', ($ez_pages_is_ssl=='0' ? 'NONSSL' : 'SSL'), true, true, true));
//           break;
//           // internal link same window
//         case ($ez_pages_alturl != '' and $ez_pages_open_new_window == '0'):
//           $ez_pages_linkto  = (substr($ez_pages_alturl,0,4) == 'http') ?
//                               $ez_pages_alturl :
//                               ($ez_pages_alturl=='' ? '' : zen_href_link($ez_pages_alturl, '', ($ez_pages_is_ssl=='0' ? 'NONSSL' : 'SSL'), true, true, true));
//           break;
//       }

      // if altURL is specified, use it; otherwise, use EZPage ID to create link
      $ez_link = ($ez_pages_linkto =='') ?
        zen_href_link(FILENAME_EZPAGES, 'id=' . $ez_pages_id . ((int)$ez_pages_chapter != 0 ? '&chapter=' . $ez_pages_chapter : ''), ($ez_pages_is_ssl=='0' ? 'NONSSL' : 'SSL')) :
        $ez_pages_linkto;
      $ez_link .= ($ez_pages_open_new_window == '1' ? '" target="_blank' : '');
    }

    //    echo 'I SEE ' . '<a href=' . $ez_link . '>' . $ez_page_query->fields['pages_title'] . '</a>' . '<br>';

    if ($ez_pages_return_full_url == false) {
      return $ez_link;
    } else {
      return '<a href="' . $ez_link . '">' . $ez_pages_name . '</a>';
    }
  }

  function zen_ezpages_display_style( $position){
  	global $db , $memcache;
  	$cPath = '';
  	$data = array( 'left_sidebox' => array());
  	 
  	if(in_array($position, array('left_sidebox'))){
  		$memcache_key = md5(MEMCACHE_PREFIX . 'get_ezpages_display_style');
  		$data = $memcache->get($memcache_key);
  
  		if($data[$position] && sizeof($data[$position])){
  			return $data[$position];
  		}else{
  			$sidebox_page_list_query = $db->Execute('SELECT pages_id from ' . TABLE_EZPAGES . ' where status_page_web = 10 and status_left_sidebox = 10');
  			if($sidebox_page_list_query->RecordCount() > 0){
  				while(!$sidebox_page_list_query->EOF){
  					$data['left_sidebox'][] = $sidebox_page_list_query->fields['pages_id'];
  
  					$sidebox_page_list_query->MoveNext();
  				}
  			}
  		}
  	}
  	
  	$memcache->set($memcache_key, $data, false, 7*24*60*60);
  	return $data[$position];
  	 
  }

?>