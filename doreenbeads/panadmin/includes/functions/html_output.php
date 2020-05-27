<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  $Id: html_output.php 3089 2006-03-01 18:32:25Z ajeh $
//

////
// The HTML href link wrapper function
  function zen_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true) {
    global $request_type, $session_started, $http_domain, $https_domain;
    if ($page == '') {
      die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine the page link!<br><br>Function used:<br><br>zen_href_link(\'' . $page . '\', \'' . $parameters . '\', \'' . $connection . '\')</b>');
    }

    if ($connection == 'NONSSL') {
      $link = HTTP_SERVER . DIR_WS_ADMIN;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL_ADMIN == 'true') {
        $link = HTTPS_SERVER . DIR_WS_HTTPS_ADMIN;
      } else {
        $link = HTTP_SERVER . DIR_WS_ADMIN;
      }
    } else {
      die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL SSL<br><br>Function used:<br><br>zen_href_link(\'' . $page . '\', \'' . $parameters . '\', \'' . $connection . '\')</b>');
    }
    if (!strstr($page, '.php')) $page .= '.php';
    if ($parameters == '') {
      $link = $link . $page;
      $separator = '?';
    } else {
      $link = $link . $page . '?' . $parameters;
      $separator = '&';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
    if ( ($add_session_id == true) && ($session_started == true) ) {
      if (defined('SID') && zen_not_null(SID)) {
        $sid = SID;
      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL_ADMIN == 'true') ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
//die($connection);
        if ($http_domain != $https_domain) {
          $sid = zen_session_name() . '=' . zen_session_id();
        }
      }
    }

    if (isset($sid)) {
      $link .= $separator . $sid;
    }

    return $link;
  }

  function zen_catalog_href_link($page = '', $parameters = '', $connection = 'NONSSL') {
    if ($connection == 'NONSSL') {
      $link = HTTP_CATALOG_SERVER . DIR_WS_CATALOG;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL_CATALOG == 'true') {
        $link = HTTPS_CATALOG_SERVER . DIR_WS_HTTPS_CATALOG;
      } else {
        $link = HTTP_CATALOG_SERVER . DIR_WS_CATALOG;
      }
    } else {
      die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL SSL<br><br>Function used:<br><br>zen_href_link(\'' . $page . '\', \'' . $parameters . '\', \'' . $connection . '\')</b>');
    }
    if ($parameters == '') {
      $link .= 'index.php?main_page='. $page;
    } else {
      $link .= 'index.php?main_page='. $page . "&" . zen_output_string($parameters);
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

    return $link;
  }

////
// The HTML image wrapper function
  function zen_image($src, $alt = '', $width = '', $height = '', $params = '') {
    $image = '<img src="' . $src . '" border="0" alt="' . $alt . '"';
    if ($alt) {
      $image .= ' title=" ' . $alt . ' "';
    }
    if ($width) {
      $image .= ' width="' . $width . '"';
    }
    if ($height) {
      $image .= ' height="' . $height . '"';
    }
    if ($params) {
      $image .= ' ' . $params;
    }
    $image .= '>';

    return $image;
  }

////
// The HTML form submit button wrapper function
// Outputs a button in the selected language
  function zen_image_submit($image, $alt = '', $parameters = '') {
    global $language;

    $image_submit = '<input type="image" src="' . zen_output_string(DIR_WS_LANGUAGES . $_SESSION['language'] . '/images/buttons/' . $image) . '" border="0" alt="' . zen_output_string($alt) . '"';

    if (zen_not_null($alt)) $image_submit .= ' title=" ' . zen_output_string($alt) . ' "';

    if (zen_not_null($parameters)) $image_submit .= ' ' . $parameters;

    $image_submit .= '>';

    return $image_submit;
  }

////
// Draw a 1 pixel black line
  function zen_black_line() {
    return zen_image(DIR_WS_IMAGES . 'pixel_black.gif', '', '100%', '1');
  }

////
// Output a separator either through whitespace, or with an image
  function zen_draw_separator($image = 'pixel_black.gif', $width = '100%', $height = '1') {
    return zen_image(DIR_WS_IMAGES . $image, '', $width, $height);
  }

////
// Output a function button in the selected language
  function zen_image_button($image, $alt = '', $params = '') {
    global $language;

    return zen_image(DIR_WS_LANGUAGES . $_SESSION['language'] . '/images/buttons/' . $image, $alt, '', '', $params);
  }

////
// javascript to dynamically update the states/provinces list when the country is changed
// TABLES: zones
  function zen_js_zone_list($country, $form, $field) {
    global $db;
    $countries = $db->Execute("select distinct zone_country_id
                               from " . TABLE_ZONES . "
                               order by zone_country_id");

    $num_country = 1;
    $output_string = '';
    while (!$countries->EOF) {
      if ($num_country == 1) {
        $output_string .= '  if (' . $country . ' == "' . $countries->fields['zone_country_id'] . '") {' . "\n";
      } else {
        $output_string .= '  } else if (' . $country . ' == "' . $countries->fields['zone_country_id'] . '") {' . "\n";
      }

      $states = $db->Execute("select zone_name, zone_id
                              from " . TABLE_ZONES . "
                              where zone_country_id = '" . $countries->fields['zone_country_id'] . "'
                              order by zone_name");


      $num_state = 1;
      while (!$states->EOF) {
        if ($num_state == '1') $output_string .= '    ' . $form . '.' . $field . '.options[0] = new Option("' . PLEASE_SELECT . '", "");' . "\n";
        $output_string .= '    ' . $form . '.' . $field . '.options[' . $num_state . '] = new Option("' . $states->fields['zone_name'] . '", "' . $states->fields['zone_id'] . '");' . "\n";
        $num_state++;
        $states->MoveNext();
      }
      $num_country++;
      $countries->MoveNext();
    }
    $output_string .= '  } else {' . "\n" .
                      '    ' . $form . '.' . $field . '.options[0] = new Option("' . TYPE_BELOW . '", "");' . "\n" .
                      '  }' . "\n";

    return $output_string;
  }

////
// Output a form
  function zen_draw_form($name, $action, $parameters = '', $method = 'post', $params = '', $usessl = 'false') {
  	//update wei.liang
  	if($name=='new_product'){
  		$form = '<form onsubmit="return functionjs(this);" name="' . zen_output_string($name) . '" action="';
  	}else{
  		 $form = '<form name="' . zen_output_string($name) . '" action="';
  	}
    //out update wei.liang
    if (zen_not_null($parameters)) {
      if ($usessl) {
        $form .= zen_href_link($action, $parameters, 'NONSSL');
      } else {
        $form .= zen_href_link($action, $parameters, 'NONSSL');
      }
    } else {
      if ($usessl) {
        $form .= zen_href_link($action, '', 'NONSSL');
      } else {
        $form .= zen_href_link($action, '', 'NONSSL');
      }
    }
    $form .= '" method="' . zen_output_string($method) . '"';
    if (zen_not_null($params)) {
      $form .= ' ' . $params;
    }
    $form .= '>';
    return $form;
  }

////
// Output a form input field
  function zen_draw_input_field($name, $value = '', $parameters = '', $required = false, $type = 'text', $reinsert_value = true) {
    $field = '<input type="' . zen_output_string($type) . '" name="' . zen_output_string($name) . '"';

    if (isset($GLOBALS[$name]) && ($reinsert_value == true) && is_string($GLOBALS[$name])) {
      $field .= ' value="' . zen_output_string(stripslashes($GLOBALS[$name])) . '"';
    } elseif (zen_not_null($value)) {
      $field .= ' value="' . zen_output_string($value) . '"';
    }

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
  }

////
// Output a form password field
  function zen_draw_password_field($name, $value = '', $required = false) {
    $field = zen_draw_input_field($name, $value, 'maxlength="40"', $required, 'password', false);

    return $field;
  }

////
// Output a form filefield
  function zen_draw_file_field($name, $required = false) {
    $field = zen_draw_input_field($name, '', ' size="50" ', $required, 'file');

    return $field;
  }

////
// Output a selection field - alias function for zen_draw_checkbox_field() and zen_draw_radio_field()
  function zen_draw_selection_field($name, $type, $value = '', $checked = false, $compare = '', $parameters = '') {
    $selection = '<input type="' . zen_output_string($type) . '" name="' . zen_output_string($name) . '"';

    if (zen_not_null($value)) $selection .= ' value="' . zen_output_string($value) . '"';

    if ( ($checked == true) || (isset($GLOBALS[$name]) && is_string($GLOBALS[$name]) && ($GLOBALS[$name] == 'on')) || (isset($value) && isset($GLOBALS[$name]) && (stripslashes($GLOBALS[$name]) == $value)) || (zen_not_null($value) && zen_not_null($compare) && ($value == $compare)) ) {
      $selection .= ' CHECKED';
    }

    if (zen_not_null($parameters)) $selection .= ' ' . $parameters;

    $selection .= '>';

    return $selection;
  }

////
// Output a form checkbox field
  function zen_draw_checkbox_field($name, $value = '', $checked = false, $compare = '', $parameters = '') {
    return zen_draw_selection_field($name, 'checkbox', $value, $checked, $compare, $parameters);
  }

////
// Output a form radio field
  function zen_draw_radio_field($name, $value = '', $checked = false, $compare = '', $parameters = '') {
    return zen_draw_selection_field($name, 'radio', $value, $checked, $compare, $parameters);
  }

////
// Output a form textarea field
  function zen_draw_textarea_field($name, $wrap, $width, $height, $text = '', $parameters = '', $reinsert_value = true) {
    $field = '<textarea name="' . zen_output_string($name) . '" wrap="' . zen_output_string($wrap) . '" cols="' . zen_output_string($width) . '" rows="' . zen_output_string($height) . '"';

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if ( (isset($GLOBALS[$name])) && ($reinsert_value == true) ) {
      $field .= stripslashes($GLOBALS[$name]);
    } elseif (zen_not_null($text)) {
      $field .= $text;
    }

    $field .= '</textarea>';

    return $field;
  }

////
// Output a form hidden field
  function zen_draw_hidden_field($name, $value = '', $parameters = '') {
    $field = '<input type="hidden" name="' . zen_output_string($name) . '"';

    if (zen_not_null($value)) {
      $field .= ' value="' . zen_output_string($value) . '"';
    } elseif (isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) {
      $field .= ' value="' . zen_output_string(stripslashes($GLOBALS[$name])) . '"';
    }

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    return $field;
  }

////
// Output a form pull down menu
  function zen_draw_pull_down_menu($name, $values, $default = '', $parameters = '', $required = false) {
//    $field = '<select name="' . zen_output_string($name) . '"';
    $field = '<select rel="dropdown" name="' . zen_output_string($name) . '"';

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

//     if (empty($default) && isset($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);

    for ($i=0, $n=sizeof($values); $i<$n; $i++) {
      $field .= '<option value="' . zen_output_string($values[$i]['id']) . '"';
      if ($default == $values[$i]['id']) {
        $field .= ' SELECTED';
      }

      $field .= '>' . zen_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>';
    }
    $field .= '</select>';

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
  }
////
// Hide form elements
  function zen_hide_session_id() {
    global $session_started;

    if ( ($session_started == true) && defined('SID') && zen_not_null(SID) ) {
      return zen_draw_hidden_field(zen_session_name(), zen_session_id());
    }
  }
  function zen_output_if_null($content){
  	if($content==''){
  		return "&nbsp;";
  	}else{
  		return $content;
  	}
  }
  
  function zen_catalog_href_link_seo($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = false, $search_engine_safe = true, $static = false, $use_dir_ws_catalog = true, $languages_code='') {
  	if (!isset($GLOBALS['seo_urls']) && !is_object($GLOBALS['seo_urls'])) {
  		include_once('../'.DIR_WS_CLASSES . 'seo.url.php');
  		$GLOBALS['seo_urls'] = &new SEO_URL($_SESSION['languages_id']);
  	}
  
  	return $GLOBALS['seo_urls']->href_link($page, $parameters, $connection, $add_session_id, $static, $use_dir_ws_catalog,$languages_code);
  }
  
  //by zale, 2012-06-19
  function get_vip_message($customer_id){
  		global $db,$currencies;
  		$customer_group = $db->Execute('Select gp.group_name, gp.group_percentage 
											  From ' . TABLE_GROUP_PRICING . ' as gp, ' . TABLE_CUSTOMERS . ' as c, ' . TABLE_GROUP_PRICING_DESCRIPTION . ' as gpd
											 Where c.customers_group_pricing = gp.group_id 
											 and gp.group_id = gpd.group_id
											 and gpd.language_id= ' . $_SESSION["languages_id"] . '
											   And c.customers_id = ' . $customer_id);
		if ($customer_group->RecordCount() == 0) {
			$vip_message['group_name'] = 'Normal';
			$vip_message['group_percentage'] = 0;
		} else {
			$vip_message['group_name'] = $customer_group->fields['group_name'];
			$vip_message['group_percentage'] = $customer_group->fields['group_percentage'];
		}
		
		return $vip_message;
  }
  function zen_get_priority_country($priority_country){
  	global $db;
  
  	$countries_array = array();
  
  	$countries = "select countries_id, countries_name
                    from " . TABLE_COUNTRIES . "
                    where countries_id in (".$priority_country.")
                    order by field(countries_id, ".$priority_country.")";
  	$countries_values = $db->Execute($countries);
  
  	while (!$countries_values->EOF) {
  		$countries_array[] = array('countries_id' => $countries_values->fields['countries_id'],
  				'countries_name' => $countries_values->fields['countries_name']);
  		$countries_values->MoveNext();
  	}
  	return $countries_array;
  }
  
  /**
   * Returns an array with countries
   *
   * @param int If set limits to a single country
   * @param boolean If true adds the iso codes to the array
   */
  function zen_get_countries_new($countries_id = '', $with_iso_codes = false) {
  	global $db;
  	$countries_array = array();
  	if (zen_not_null($countries_id)) {
  		if ($with_iso_codes == true) {
  			$countries = "select countries_name, countries_iso_code_2, countries_iso_code_3
                      from " . TABLE_COUNTRIES . "
                      where countries_id = '" . (int)$countries_id . "'
                      order by countries_name";
  
  			$countries_values = $db->Execute($countries);
  
  			$countries_array = array('countries_name' => $countries_values->fields['countries_name'],
  					'countries_iso_code_2' => $countries_values->fields['countries_iso_code_2'],
  					'countries_iso_code_3' => $countries_values->fields['countries_iso_code_3']);
  		} else {
  			$countries = "select countries_name
                      from " . TABLE_COUNTRIES . "
                      where countries_id = '" . (int)$countries_id . "'";
  
  			$countries_values = $db->Execute($countries);
  
  			$countries_array = array('countries_name' => $countries_values->fields['countries_name']);
  		}
  	} else {
  		$countries = "select countries_id, countries_name, countries_iso_code_2
                    from " . TABLE_COUNTRIES . "
                    order by countries_name";
  
  		$countries_values = $db->Execute($countries);
  
  		while (!$countries_values->EOF) {
  			$countries_array[] = array('countries_id' => $countries_values->fields['countries_id'],
  					'countries_name' => $countries_values->fields['countries_name'],
  			    'countries_iso_code_2' => $countries_values->fields['countries_iso_code_2']
  			);
  
  			$countries_values->MoveNext();
  		}
  	}
  
  	return $countries_array;
  }
  
  function zen_get_country_select($name, $selected = '', $priority_country = '',$para='') {
  	$default_country_en="'223','13','222','38','81','176','73','195','150','153','103','203','105','72','160','107'";  //默认优先国家设置
  	$default_country_de="'81','14','204','150','176','73','33','97','124','105','195','222','117','56','72'";
  	$default_country_ru="'176','20','220','109','123','117','11','67','80','140'";
  	switch($priority_country){
  		case 1:
  			$priority_country=	$default_country_en;
  			break;
  		case 2:
  			$priority_country=	$default_country_de;
  			break;
  		case 3:
  			$priority_country=	$default_country_ru;
  			break;
  		default:
  			$priority_country=	$default_country_en;
  	}
  	$priority_country_array=zen_get_priority_country($priority_country);
  	$countries_all_array = zen_get_countries_new();
  	$selected=($selected!='')?$selected:'223';
  	$selected_country=zen_get_country_name($selected);
  	$content='';
  	$content.='<div  class="country_select_div" id="country_choose"><a class="choose_single" href="javascript:void(0)" ><span>'.$selected_country.'</span><div><b></b></div></a>';
  	$content.='<div class="country_select_drop">';
  	$content.='<div class="choose_search"><input type="text" autocomplete="off" class=""></div>';
  	$content.='<ul>';
  	$content.='<li id="country_list_1"  class="country_list_line" >---------</li>';
  	foreach($priority_country_array as $key=>$val){
  		if($val['countries_id']==$selected){
  			$default_id=$key+2;
  			$content.= '<li id="country_list_'.($key+2).'" cListId="'.$val['countries_id'].'" class="country_list_item">'.$val['countries_name'].'</li>';
  		}else{
  			$content.= '<li id="country_list_'.($key+2).'" cListId="'.$val['countries_id'].'" class="country_list_item">'.$val['countries_name'].'</li>';
  		}
  	}
  	$content.='<li id="country_list_'.($key+3).'"  class="country_list_line" >---------</li>';
  	foreach($countries_all_array as $key2=>$val2){
  		if(($val2['countries_id']==$selected)&&!(isset($default_id)&&$default_id!='')){
  			$default_id=$key+4+$key2;
  			$content.= '<li id="country_list_'.($key+4+$key2).'" cListId="'.$val2['countries_id'].'" class="country_list_item">'.$val2['countries_name'].'</li>';
  		}
  		else{
  			$content.= '<li id="country_list_'.($key+4+$key2).'" cListId="'.$val2['countries_id'].'" class="country_list_item">'.$val2['countries_name'].'</li>';
  		}
  	}
  	$content.='</ul></div>';
  
  	if(zen_not_null($para)){
  		$others=$para;
  	}else{
  		$others='id="'.$name.'"';
  	}
  	$content.='</div><input type="hidden" name="'.$name.'" value="'.$selected.'" '.$others.'>';
  	$content.='<input type="hidden" id="cSelectId" value="'.$default_id.'" class="">';
  	return $content;
  }
  //eof
?>