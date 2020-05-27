<?php
/**
 * html_output.php
 * HTML-generating functions used throughout the core
 *
 * @package functions
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: html_output.php 14753 2009-11-07 19:58:13Z drbyte $
 */

/*
 * The HTML href link wrapper function
 */
//  function zen_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true, $static = false, $use_dir_ws_catalog = true) {
//    global $request_type, $session_started, $http_domain, $https_domain;
//
//    if (!zen_not_null($page)) {
//      die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine the page link!</strong><br /><br /><!--' . $page . '<br />' . $parameters . ' -->');
//    }
//
//    if ($connection == 'NONSSL') {
//      $link = HTTP_SERVER;
//    } elseif ($connection == 'SSL') {
//      if (ENABLE_SSL == 'true') {
//        $link = HTTPS_SERVER ;
//      } else {
//        $link = HTTP_SERVER;
//      }
//    } else {
//      die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</strong><br /><br />');
//    }
//
//    if ($use_dir_ws_catalog) {
//      if ($connection == 'SSL' && ENABLE_SSL == 'true') {
//        $link .= DIR_WS_HTTPS_CATALOG;
//      } else {
//        $link .= DIR_WS_CATALOG;
//      }
//    }
//
//    if (!$static) {
//      if (zen_not_null($parameters)) {
//        $link .= 'index.php?main_page='. $page . "&" . zen_output_string($parameters);
//      } else {
//        $link .= 'index.php?main_page=' . $page;
//      }
//    } else {
//      if (zen_not_null($parameters)) {
//        $link .= $page . "?" . zen_output_string($parameters);
//      } else {
//        $link .= $page;
//      }
//    }
//
//    $separator = '&';
//
//    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);
//// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
//    if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
//      if (defined('SID') && zen_not_null(SID)) {
//        $sid = SID;
////      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL_ADMIN == 'true') ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
//      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == 'true') ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
//        if ($http_domain != $https_domain) {
//          $sid = zen_session_name() . '=' . zen_session_id();
//        }
//      }
//    }
//
//// clean up the link before processing
//    while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);
//    while (strstr($link, '&amp;&amp;')) $link = str_replace('&amp;&amp;', '&amp;', $link);
//
//    if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
//      while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);
//
//      $link = str_replace('&amp;', '/', $link);
//      $link = str_replace('?', '/', $link);
//      $link = str_replace('&', '/', $link);
//      $link = str_replace('=', '/', $link);
//
//      $separator = '?';
//    }
//
//    if (isset($sid)) {
//      $link .= $separator . zen_output_string($sid);
//    }
//
//// clean up the link after processing
//    while (strstr($link, '&amp;&amp;')) $link = str_replace('&amp;&amp;', '&amp;', $link);
//
//    $link = preg_replace('/&/', '&amp;', $link);
//    return $link;
//  }


function zen_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true, $static = false, $use_dir_ws_catalog = true) {

		/* QUICK AND DIRTY WAY TO DISABLE REDIRECTS ON PAGES WHEN SEO_URLS_ONLY_IN is enabled IMAGINADW.COM */
		$sefu = explode(",", ereg_replace( ' +', '', SEO_URLS_ONLY_IN ));
		if((SEO_URLS_ONLY_IN!="") && !in_array($page,$sefu)) {
			return original_zen_href_link($page, $parameters, $connection, $add_session_id, $search_engine_safe, $static, $use_dir_ws_catalog);
		}

		if (!isset($GLOBALS['seo_urls']) && !is_object($GLOBALS['seo_urls'])) {
			include_once(DIR_WS_CLASSES . 'seo.url.php');

			$GLOBALS['seo_urls'] = &new SEO_URL($_SESSION['languages_id']);
		}

		return $GLOBALS['seo_urls']->href_link($page, $parameters, $connection, $add_session_id, $static, $use_dir_ws_catalog);
  }


  function original_zen_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true, $static = false, $use_dir_ws_catalog = true) {
    global $request_type, $session_started, $http_domain, $https_domain;

    if (!zen_not_null($page)) {
      die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine the page link!</strong><br /><br /><!--' . $page . '<br />' . $parameters . ' -->');
    }

    if ($connection == 'NONSSL') {
      $link = HTTP_SERVER;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL == 'true') {
        $link = HTTPS_SERVER ;
      } else {
        $link = HTTP_SERVER;
      }
    } else {
      die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</strong><br /><br />');
    }

    if ($use_dir_ws_catalog) {
      if ($connection == 'SSL' && ENABLE_SSL == 'true') {
        $link .= DIR_WS_HTTPS_CATALOG;
      } else {
        $link .= DIR_WS_CATALOG;
      }
    }
   //$parameters;
         if(strstr($parameters,"language=")){
            if(substr($parameters,(strpos($parameters,"language=")+9),2)=='en'){
            $link.="./";
            }else{
            $link.=substr($parameters,(strpos($parameters,"language=")+9),2)."/";
            }
         	$parameters=substr($parameters,0,strpos($parameters,"language="));
  }elseif(isset($_SESSION["languages_id"])&&$_SESSION["languages_id"]!=1){
  $link .= $_SESSION["languages_code"]."/";
  }
    if (!$static) {
      if (zen_not_null($parameters)) {
        $link .= 'index.php?main_page='. $page . "&" . zen_output_string($parameters);
      } else {
        $link .= 'index.php?main_page=' . $page;
      }
    } else {
      if (zen_not_null($parameters)) {
        $link .= $page . "?" . zen_output_string($parameters);
      } else {
        $link .= $page;
      }
    }

    $separator = '&';

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);
// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
    if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
      if (defined('SID') && zen_not_null(SID)) {
        $sid = SID;
//      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL_ADMIN == 'true') ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == 'true') ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
        if ($http_domain != $https_domain) {
          $sid = zen_session_name() . '=' . zen_session_id();
        }
      }
    }

// clean up the link before processing
    while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);
    while (strstr($link, '&amp;&amp;')) $link = str_replace('&amp;&amp;', '&amp;', $link);

    if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
      while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);

      $link = str_replace('&amp;', '/', $link);
      $link = str_replace('?', '/', $link);
      $link = str_replace('&', '/', $link);
      $link = str_replace('=', '/', $link);

      $separator = '?';
    }

    if (isset($sid)) {
      $link .= $separator . zen_output_string($sid);
    }

// clean up the link after processing
    while (strstr($link, '&amp;&amp;')) $link = str_replace('&amp;&amp;', '&amp;', $link);

    $link = ereg_replace('&', '&amp;', $link);
    return $link;
  }

/*
 * The HTML image wrapper function for non-proportional images
 * used when "proportional images" is turned off or if calling from a template directory
 */
  function zen_image_OLD($src, $alt = '', $width = '', $height = '', $parameters = '') {
    global $template_dir;

//auto replace with defined missing image
    if ($src == DIR_WS_IMAGES and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
      $src = DIR_WS_IMAGES . PRODUCTS_IMAGE_NO_IMAGE;
    }

    if ( (empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false') ) {
      return false;
    }

    // if not in current template switch to template_default
    if (!file_exists($src)) {
      $src = str_replace(DIR_WS_TEMPLATES . $template_dir, DIR_WS_TEMPLATES . 'template_default', $src);
    }

// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
    $image = '<img src="' . zen_output_string($src) . '" alt="' . zen_output_string($alt) . '"';

    if (zen_not_null($alt)) {
      $image .= ' title=" ' . zen_output_string($alt) . ' "';
    }

    if ( (CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height)) ) {
      if ($image_size = @getimagesize($src)) {
        if (empty($width) && zen_not_null($height)) {
          $ratio = $height / $image_size[1];
          $width = $image_size[0] * $ratio;
        } elseif (zen_not_null($width) && empty($height)) {
          $ratio = $width / $image_size[0];
          $height = $image_size[1] * $ratio;
        } elseif (empty($width) && empty($height)) {
          $width = $image_size[0];
          $height = $image_size[1];
        }
      } elseif (IMAGE_REQUIRED == 'false') {
        return false;
      }
    }

    if (zen_not_null($width) && zen_not_null($height)) {
      $image .= ' width="' . zen_output_string($width) . '" height="' . zen_output_string($height) . '"';
    }

    if (zen_not_null($parameters)) $image .= ' ' . $parameters;

    $image .= ' />';

    return $image;
  }


/*
 * The HTML image wrapper function
 */
   function zen_image($src, $alt = '', $width = '', $height = '', $parameters = '') {
    global $template_dir;

    // soft clean the alt tag
    $alt = zen_clean_html($alt);

    // use old method on template images
    if (strstr($src, 'includes/templates') or strstr($src, 'includes/languages') or PROPORTIONAL_IMAGES_STATUS == '0') {
      return zen_image_OLD($src, $alt, $width, $height, $parameters);
    }

//auto replace with defined missing image
    if ($src == DIR_WS_IMAGES and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
      $src = DIR_WS_IMAGES . PRODUCTS_IMAGE_NO_IMAGE;
    }

    if ( (empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false') ) {
      return false;
    }

    // if not in current template switch to template_default
    if (!file_exists($src)) {
      $src = str_replace(DIR_WS_TEMPLATES . $template_dir, DIR_WS_TEMPLATES . 'template_default', $src);
    }
    // hook for handle_image() function such as Image Handler etc
    if (function_exists('handle_image')) {
      $newimg = handle_image($src, $alt, $width, $height, $parameters);
      list($src, $alt, $width, $height, $parameters) = $newimg;
    }
    // Convert width/height to int for proper validation.
    // intval() used to support compatibility with plugins like image-handler
    $width = empty($width) ? $width : intval($width);
    $height = empty($height) ? $height : intval($height);

// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
	if(strstr($parameters, 'class="lazy"')){
	  $image = '<img src="includes/templates/cherry_zen/images/loading2.gif" data-original="' . zen_output_string($src) . '" alt="' . zen_output_string($alt) . '"' ;
	   //$image = '<img src="' . zen_output_string($src) . '" alt="' . zen_output_string($alt) . '"';
	}else{
	   $image = '<img src="' . zen_output_string($src) . '" alt="' . zen_output_string($alt) . '"';
	}

    if (zen_not_null($alt)) {
      $image .= ' title=" ' . zen_output_string($alt) . ' "';
    }

    if ( ((CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height))) ) {
      if ($image_size = @getimagesize($src)) {
        if (empty($width) && zen_not_null($height)) {
          $ratio = $height / $image_size[1];
          $width = $image_size[0] * $ratio;
        } elseif (zen_not_null($width) && empty($height)) {
          $ratio = $width / $image_size[0];
          $height = $image_size[1] * $ratio;
        } elseif (empty($width) && empty($height)) {
          $width = $image_size[0];
          $height = $image_size[1];
        }
      } elseif (IMAGE_REQUIRED == 'false') {
        return false;
      }
    }


    if (zen_not_null($width) && zen_not_null($height) and file_exists($src)) {
//      $image .= ' width="' . zen_output_string($width) . '" height="' . zen_output_string($height) . '"';
// proportional images
      $image_size = @getimagesize($src);
      // fix division by zero error
      $ratio = ($image_size[0] != 0 ? $width / $image_size[0] : 1);
      if ($image_size[1]*$ratio > $height) {
        $ratio = $height / $image_size[1];
        $width = $image_size[0] * $ratio;
      } else {
        $height = $image_size[1] * $ratio;
      }
// only use proportional image when image is larger than proportional size
      if ($image_size[0] < $width and $image_size[1] < $height) {
        $image .= ' width="' . $image_size[0] . '" height="' . intval($image_size[1]) . '"';
      } else {
        $image .= ' width="' . round($width) . '" height="' . round($height) . '"';
      }
    } else {
       // override on missing image to allow for proportional and required/not required
      if (IMAGE_REQUIRED == 'false') {
        return false;
      } else {
        $image .= ' width="' . intval(SMALL_IMAGE_WIDTH) . '" height="' . intval(SMALL_IMAGE_HEIGHT) . '"';
      }
    }

    // inject rollover class if one is defined. NOTE: This could end up with 2 "class" elements if $parameters contains "class" already.
    if (defined('IMAGE_ROLLOVER_CLASS') && IMAGE_ROLLOVER_CLASS != '') {
    	$parameters .= (zen_not_null($parameters) ? ' ' : '') . 'class="rollover"';
    }
    // add $parameters to the tag output
    if (zen_not_null($parameters)) $image .= ' ' . $parameters;

    $image .= ' />';

    return $image;
  }

/*
 * The HTML form submit button wrapper function
 * Outputs a "submit" button in the selected language
 */
  function zen_image_submit($image, $alt = '', $parameters = '', $sec_class = '') {
    global $template, $current_page_base, $zco_notifier;
    if (strtolower(IMAGE_USE_CSS_BUTTONS) == 'yes' && strlen($alt)<30) return zenCssButton($image, $alt, 'submit', $sec_class /*, $parameters = ''*/ );
    $zco_notifier->notify('PAGE_OUTPUT_IMAGE_SUBMIT');

    $image_submit = '<input type="image" src="' . zen_output_string($template->get_template_dir($image, DIR_WS_TEMPLATE, $current_page_base, 'buttons/' . $_SESSION['language'] . '/') . $image) . '" alt="' . zen_output_string($alt) . '"';

    if (zen_not_null($alt)) $image_submit .= ' title=" ' . zen_output_string($alt) . ' "';

    if (zen_not_null($parameters)) $image_submit .= ' ' . $parameters;

    $image_submit .= ' />';

    return $image_submit;
  }

/*
 * Output a function button in the selected language
 */
  function zen_image_button($image, $alt = '', $parameters = '', $sec_class = '') {
    global $template, $current_page_base, $zco_notifier;

    // inject rollover class if one is defined. NOTE: This could end up with 2 "class" elements if $parameters contains "class" already.
    if (defined('IMAGE_ROLLOVER_CLASS') && IMAGE_ROLLOVER_CLASS != '') {
    	$parameters .= (zen_not_null($parameters) ? ' ' : '') . 'class="rollover"';
    }

    $zco_notifier->notify('PAGE_OUTPUT_IMAGE_BUTTON');
    if (strtolower(IMAGE_USE_CSS_BUTTONS) == 'yes') return zenCssButton($image, $alt, 'button', $sec_class, $parameters = '');
    return zen_image($template->get_template_dir($image, DIR_WS_TEMPLATE, $current_page_base, 'buttons/' . $_SESSION['language'] . '/') . $image, $alt, '', '', $parameters);
  }


/**
 * generate CSS buttons in the current language
 * concept from contributions by Seb Rouleau and paulm, subsequently adapted to Zen Cart
 * note: any hard-coded buttons will not be able to use this function
**/
  function zenCssButton($image = '', $text, $type, $sec_class = '', $parameters = '') {

    // automatic width setting depending on the number of characters
    $min_width = 80; // this is the minimum button width, change the value as you like
    $character_width = 6.5; // change this value depending on font size!
    // end settings
    // added html_entity_decode function to prevent html special chars to be counted as multiple characters (like &amp;)
    $width = strlen(html_entity_decode($text)) * $character_width;
    $width = (int)$width;
    if ($width < $min_width) $width = $min_width;
    $style = ' style="width: ' . $width . 'px;"';
    // if no secondary class is set use the image name for the sec_class
    if (empty($sec_class)) $sec_class = basename($image, '.gif');
    if(!empty($sec_class))$sec_class = ' ' . $sec_class;
    if(!empty($parameters))$parameters = ' ' . $parameters;
    $mouse_out_class  = 'cssButton' . $sec_class;
    $mouse_over_class = 'cssButtonHover' . $sec_class . $sec_class . 'Hover';
    // javascript to set different classes on mouseover and mouseout: enables hover effect on the buttons
    // (pure css hovers on non link elements do work work in every browser)
    $css_button_js .=  'onmouseover="this.className=\''. $mouse_over_class . '\'" onmouseout="this.className=\'' . $mouse_out_class . '\'"';

    if ($type == 'submit'){
// form input button
   $css_button = '<input class="' . $mouse_out_class . '" ' . $css_button_js . ' type="submit" value="' .$text . '"' . $parameters . $style . ' />';
    }

    if ($type=='button'){
// link button
   $css_button = '<span class="' . $mouse_out_class . '" ' . $css_button_js . $style . ' >&nbsp;' . $text . '&nbsp;</span>'; // add $parameters ???
    }
    return $css_button;
  }


/*
 *  Output a separator either through whitespace, or with an image
 */
  function zen_draw_separator($image = 'true', $width = '100%', $height = '1') {

    // set default to use from template - zen_image will translate if not found in current template
    if ($image == 'true') {
      $image = DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_BLACK_SEPARATOR;
    } else {
      if (!strstr($image, DIR_WS_TEMPLATE_IMAGES)) {
        $image = DIR_WS_TEMPLATE_IMAGES . $image;
      }
    }
    return zen_image($image, '', $width, $height);
  }

/*
 *  Output a form
 */
  function zen_draw_form($name, $action, $method = 'post', $parameters = '') {
    $form = '<form name="' . zen_output_string($name) . '" action="' . zen_output_string($action) . '" method="' . zen_output_string($method) . '"';

    if (zen_not_null($parameters)) $form .= ' ' . $parameters;

    $form .= '>';

    return $form;
  }

/*
 *  Output a form input field
 */
  function zen_draw_input_field($name, $value = '', $parameters = '', $type = 'text', $reinsert_value = true) {
    $field = '<input type="' . zen_output_string($type) . '" name="' . zen_output_string($name) . '"';
    if ( (isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) && ($reinsert_value == true) ) {
      $field .= ' value="' . zen_output_string(stripslashes($GLOBALS[$name])) . '"';
    } elseif (zen_not_null($value)) {
      $field .= ' value="' . zen_output_string($value) . '"';
    }

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= ' />';

    return $field;
  }

/*
 *  Output a form password field
 */
  function zen_draw_password_field($name, $value = '', $parameters = 'maxlength="40"') {
    return zen_draw_input_field($name, $value, $parameters, 'password', true);
  }

/*
 *  Output a selection field - alias function for zen_draw_checkbox_field() and zen_draw_radio_field()
 */
  function zen_draw_selection_field($name, $type, $value = '', $checked = false, $parameters = '') {
    $selection = '<input type="' . zen_output_string($type) . '" name="' . zen_output_string($name) . '"';

    if (zen_not_null($value)) $selection .= ' value="' . zen_output_string($value) . '"';

    if ( ($checked == true) || ( isset($GLOBALS[$name]) && is_string($GLOBALS[$name]) && ( ($GLOBALS[$name] == 'on') || (isset($value) && (stripslashes($GLOBALS[$name]) == $value)) ) ) ) {
      $selection .= ' checked="checked"';
    }

    if (zen_not_null($parameters)) $selection .= ' ' . $parameters;

    $selection .= ' />';

    return $selection;
  }

/*
 *  Output a form checkbox field
 */
  function zen_draw_checkbox_field($name, $value = '', $checked = false, $parameters = '') {
    return zen_draw_selection_field($name, 'checkbox', $value, $checked, $parameters);
  }

/*
 * Output a form radio field
 */
  function zen_draw_radio_field($name, $value = '', $checked = false, $parameters = '') {
    return zen_draw_selection_field($name, 'radio', $value, $checked, $parameters);
  }

/*
 *  Output a form textarea field
 */
  function zen_draw_textarea_field($name, $width, $height, $text = '~*~*#', $parameters = '', $reinsert_value = true) {
    $field = '<textarea name="' . zen_output_string($name) . '" cols="' . zen_output_string($width) . '" rows="' . zen_output_string($height) . '"';

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if ($text == '~*~*#' && (isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) && ($reinsert_value == true) ) {
      $field .= stripslashes($GLOBALS[$name]);
    } elseif ($text != '~*~*#' && zen_not_null($text)) {
      $field .= $text;
    }

    $field .= '</textarea>';

    return $field;
  }

/*
 *  Output a form hidden field
 */
  function zen_draw_hidden_field($name, $value = '', $parameters = '') {
    $field = '<input type="hidden" name="' . zen_output_string($name) . '"';

    if (zen_not_null($value)) {
      $field .= ' value="' . zen_output_string($value) . '"';
    } elseif (isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) {
      $field .= ' value="' . zen_output_string(stripslashes($GLOBALS[$name])) . '"';
    }

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= ' />';

    return $field;
  }

/*
 * Output a form file-field
 */
  function zen_draw_file_field($name, $required = false) {
    $field = zen_draw_input_field($name, '', ' size="50" ', 'file');

    return $field;
  }


/*
 *  Hide form elements while including session id info
 *  IMPORTANT: This should be used in every FORM that has an OnSubmit() function tied to it, to prevent unexpected logouts
 */
  function zen_hide_session_id() {
    global $session_started;

    if ( ($session_started == true) && defined('SID') && zen_not_null(SID) ) {
      return zen_draw_hidden_field(zen_session_name(), zen_session_id());
    }
  }

/*
 *  Output a form pull down menu
 *  Pulls values from a passed array, with the indicated option pre-selected
 */
  function zen_draw_pull_down_menu($name, $values, $default = '', $parameters = '', $required = false) {
    $field = '<select name="' . zen_output_string($name) . '"';

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>' . "\n";

    if (empty($default) && isset($GLOBALS[$name]) && is_string($GLOBALS[$name]) ) $default = stripslashes($GLOBALS[$name]);

    for ($i=0, $n=sizeof($values); $i<$n; $i++) {
      $field .= '  <option value="' . zen_output_string($values[$i]['id']) . '"';
      if ($default == $values[$i]['id']) {
        $field .= ' selected="selected"';
      }

      $field .= '>' . zen_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>' . "\n";
    }
    $field .= '</select>' . "\n";

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
  }

/*
 * Creates a pull-down list of countries
 */
  function zen_get_country_list($name, $selected = '', $parameters = '') {
    $countries_array = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT));
    $countries = zen_get_countries();

    for ($i=0, $n=sizeof($countries); $i<$n; $i++) {
      $countries_array[] = array('id' => $countries[$i]['countries_id'], 'text' => $countries[$i]['countries_name']);
    }

    return zen_draw_pull_down_menu($name, $countries_array, $selected, $parameters);
  }

/*
 * Assesses suitability for additional parameters such as rel=nofollow etc
 */
  function zen_href_params($page = '', $parameters = '') {
    global $current_page_base;
    $addparms = '';
    // if nofollow has already been set, ignore this function
    if (stristr($parameters, 'nofollow')) return $parameters;
    // if list of skippable pages has been set in meta_tags.php lang file (is by default), use that to add rel=nofollow params
    if (defined('ROBOTS_PAGES_TO_SKIP') && in_array($page, explode(",", constant('ROBOTS_PAGES_TO_SKIP')))
        || $current_page_base=='down_for_maintenance') $addparms = 'rel="nofollow"';
    return ($parameters == '' ? $addparms : $parameters . ' ' . $addparms);
  }


  //jessa 2010-05-03 锟斤拷锟斤拷一锟斤拷锟斤拷页锟斤拷锟斤拷示锟斤拷锟斤拷, 锟斤拷锟节匡拷锟斤拷锟斤拷锟侥Ｊ斤拷锟�
  function zen_split_show_info($start_num, $end_num, $total_num, $total_page_num, $current_page_num = '', $link, $border = 'bottom', $prod = true){
  	if ($prod == true){
  		$show_catg = 'products)';
  	} else {
  		$show_catg = 'categories)';
  	}

  	if ($border == 'bottom'){
		$border_style = "border-bottom:1px solid #CCCCCC;";
	}else{
		$border_style = "border-top:1px solid #CCCCCC;";
	}
  	$content = '<table width="100%" border="0" cellspacing="0" cellpadding="0">' . "\n";
	$content .= '	<tr>' . "\n";
	$content .= '		<td width="50%" align="left" style="padding:5px 0px; ' . $border_style . '">Displaying <span style="font-weight:bold;">' . $start_num . '</span> to <span style="font-weight:bold;">'. $end_num . '</span> (of <span style="font-weight:bold;">' . $total_num . '</span> ' . $show_catg . '</td>';
	$content .= '		<td width="50%" align="right" style="padding:5px 0px; ' . $border_style . '">' . "\n";
	if ($total_page_num > 1){
		if (isset($current_page_num) && $current_page_num != ''){
			$current_page_num = $current_page_num;
		}else{
			$current_page_num = 1;
		}

		if ($current_page_num > 1){
			$content .= '<a href="' . zen_href_link($link . '&page=' . ($current_page_num - 1)) . '">[&lt;&lt;&nbsp;Prev]</a>';
		}

		if ($total_page_num <= 5){
			$page_count = 1;
			while($page_count <= $total_page_num){
				if ($current_page_num != $page_count){
					$content .= '&nbsp;&nbsp;<a href="' . zen_href_link($link . '&page=' . $page_count) . '">' . $page_count . '</a>';
				}else{
					$content .= '&nbsp;&nbsp;<span style="font-weight:bold;">' . $page_count . '</span>';
				}
				$page_count++;
			}
		}else{
			$multiples_of_5 = ceil($current_page_num / 5);
			if ($multiples_of_5 > 1){
				$content .= '&nbsp;&nbsp;<a href="' . zen_href_link($link . '&page=' . ($multiples_of_5 - 1) * 5) . '">...</a>';
			}

			$multi_start_num = ($multiples_of_5 - 1) * 5 + 1;
			if ($multiples_of_5 * 5 <= $total_page_num){
				$multi_end_num = $multiples_of_5 * 5;
			}else{
				$multi_end_num = $total_page_num;
			}

			while($multi_start_num <= $multi_end_num){
				if ($current_page_num != $multi_start_num){
					$content .= '&nbsp;&nbsp;<a href="' . zen_href_link($link . '&page=' . $multi_start_num) . '">' . $multi_start_num . '</a>';
				}else{
					$content .= '&nbsp;&nbsp;<span style="font-weight:bold;">' . $multi_start_num . '</span>';
				}
				$multi_start_num++;
			}

			if ($multiples_of_5 < ceil($total_page_num / 5)){
				$content .= '&nbsp;&nbsp;<a href="' . zen_href_link($link . '&page=' . ($multiples_of_5 * 5 + 1)) . '">...</a>';
			}
		}

		if ($current_page_num < $total_page_num){
			$content .= '&nbsp;&nbsp;<a href="' . zen_href_link($link . '&page=' . ($current_page_num + 1)) . '">[Next&nbsp;&gt;&gt;]</a>';
		}
	}
	$content .= '		&nbsp;</td>' . "\n";
	$content .= '	</tr>' . "\n";
	$content .= '</table>' . "\n";
	return $content;
  }
  //eof jessa 2010-05-03

  ////jessa 2010-05-03
  function zen_image_quick_view($src, $alt = '', $width = '', $height = '', $parameters = '') {
    global $template_dir;
    if (strstr($src, 'includes/templates') or strstr($src, 'includes/languages') or PROPORTIONAL_IMAGES_STATUS == '0') {
      return zen_image_OLD($src, $alt, $width, $height, $parameters);
    }

    if ($src == DIR_WS_IMAGES and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
      $src = DIR_WS_IMAGES . PRODUCTS_IMAGE_NO_IMAGE;
    }

    if ( (empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false') ) {
      return false;
    }

    if (!file_exists($src)) {
      $src = str_replace(DIR_WS_TEMPLATES . $template_dir, DIR_WS_TEMPLATES . 'template_default', $src);
    }

    if (function_exists('handle_image')) {
      $newimg = handle_image($src, $alt, $width, $height, $parameters);
      list($src, $alt, $width, $height, $parameters) = $newimg;
    }

    $width = empty($width) ? $width : intval($width);
    $height = empty($height) ? $height : intval($height);

    $image = '<img src="' . zen_output_string($src) . '"';
    $image .= ' width="' . round($width) . '" height="' . round($height) . '"';
    if (defined('IMAGE_ROLLOVER_CLASS') && IMAGE_ROLLOVER_CLASS != '') {
    	$parameters .= (zen_not_null($parameters) ? ' ' : '') . 'class="rollover"';
    }
    if (zen_not_null($parameters)) $image .= ' ' . $parameters;

    $image .= ' />';

    return $image;

    if ( ((CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height))) ) {
      if ($image_size = @getimagesize($src)) {
        if (empty($width) && zen_not_null($height)) {
          $ratio = $height / $image_size[1];
          $width = $image_size[0] * $ratio;
        } elseif (zen_not_null($width) && empty($height)) {
          $ratio = $width / $image_size[0];
          $height = $image_size[1] * $ratio;
        } elseif (empty($width) && empty($height)) {
          $width = $image_size[0];
          $height = $image_size[1];
        }
      } elseif (IMAGE_REQUIRED == 'false') {
        return false;
      }
    }


    if (zen_not_null($width) && zen_not_null($height) and file_exists($src)) {
      $image_size = @getimagesize($src);
      $ratio = ($image_size[0] != 0 ? $width / $image_size[0] : 1);
      if ($image_size[1]*$ratio > $height) {
        $ratio = $height / $image_size[1];
        $width = $image_size[0] * $ratio;
      } else {
        $height = $image_size[1] * $ratio;
      }
      if ($image_size[0] < $width and $image_size[1] < $height) {
        $image .= ' width="' . $image_size[0] . '" height="' . intval($image_size[1]) . '"';
      } else {
        $image .= ' width="' . round($width) . '" height="' . round($height) . '"';
      }
    } else {
      if (IMAGE_REQUIRED == 'false') {
        return false;
      } else {
        $image .= ' width="' . intval(SMALL_IMAGE_WIDTH) . '" height="' . intval(SMALL_IMAGE_HEIGHT) . '"';
      }
    }
    if (defined('IMAGE_ROLLOVER_CLASS') && IMAGE_ROLLOVER_CLASS != '') {
    	$parameters .= (zen_not_null($parameters) ? ' ' : '') . 'class="rollover"';
    }
    if (zen_not_null($parameters)) $image .= ' ' . $parameters;

    $image .= ' />';

    return $image;
  }

  function getstrbylength($str,$length){
  	if(strlen($str)<=$length) return $str;
  	else {
  		//echo substr($str, 0,$length)."...";
  		//exit;
  		return mb_substr($str, 0,$length,'utf-8')."...";
  	}


  }

 	  //function country select display and data select
 	  function zen_get_priority_country($priority_country){
 	  	global $db;

 	  	$countries_array = array();

 	  	$countries = "select countries_id, countries_name, countries_zip_code_rule, countries_zip_code_example
                    from " . TABLE_COUNTRIES . "
                    where countries_id in (".$priority_country.")
                    order by field(countries_id, ".$priority_country.")";

 	  	$countries_values = $db->Execute($countries);

 	  	while (!$countries_values->EOF) {
 	  		$countries_array[] = array(
 	  				'countries_id' => $countries_values->fields['countries_id'],
 	  				'countries_name' => $countries_values->fields['countries_name'],
        			'countries_zip_code_rule' => $countries_values->fields['countries_zip_code_rule'],
        			'countries_zip_code_example' => $countries_values->fields['countries_zip_code_example']
        );
 	  		$countries_values->MoveNext();
 	  	}
 	  	return $countries_array;
 	  }
 	  function zen_get_countries_select($name, $country_select_name = 'zone_country_id',$divName = '#add_new_address') {

 	  	$default_country_en="'223','13','222','38','81','176','73','195','150','153','103','203','105','72','160','107'";
 	  	$priority_country_array=zen_get_priority_country( $default_country_en);
 	  	$countries_all_array = zen_get_countries();
 	  	$selected=($selected!='')?$selected:'223';
 	  	$selected_country=zen_get_country_name($selected);
 	  	$content='';
 	  	$content.='<div class="dateclick" style="width:298px;top:5px;*top:3px;">';
 	  	$content.='<p class="selectdate" style="width:298px;">';
 	  	$content.='<span class="date province">'.$selected_country.'</span><span class="datebeat"></span></p>';
 	  	$content.='<div class="clearfix"></div>';
 	  	$content.='<ul class="datelist" style="width:298px; height:250px; overflow:auto;">';
 	  	$content.='<li id="country_list_1"  class="country_list_line" >---------</li>';
 	  	foreach($priority_country_array as $key=>$val){
 	  		$countryLi = "'".$val['countries_id']."&".$val['countries_name']."'";
 	  		$content.= '<li id="country_list_'.$val['countries_id'].'" class="country_list_item" onclick="country_select_sub_zones('.$divName.','.$countryLi.')">'.$val['countries_name'].'</li>';
 	  	}
 	  	$content.='<li id="country_list_1"  class="country_list_line" >---------</li>';
 	  	foreach($countries_all_array as $key2=>$val2){
 	  		$countryLi = "'".$val2['countries_id']."&".$val2['countries_name']."'";
 	  		$defaultName = "'".'#add_new_address'."'";
 	  		$content.= '<li id="country_list_'.$val2['countries_id'].'" class="country_list_item" onclick="country_select_sub_zones('.$divName.','.$countryLi.')">'.$val2['countries_name'].'</li>';
 	  	}
 	  	$content.='</ul></div><input id="zone_country_id" type="hidden" value="223" name="zone_country_id">';
 	  	return $content;

 	  }

 	  function zen_get_select_sub_zones($select_country){
 	  	$content = '';
 	  	if (count($select_country) > 0){
 	  		$content.= '<select id="stateZone"  name="zone_id">';
 	  		foreach ($select_country as $s){
 	  			$country = split('&',$s);
 	  			$content.= '<option value='.$country[1].'>'.$country[0].'</option>';
 	  		}
 	  		$content.= '</select>';
 	  	}
 	  	$content.='<input id="state"  style="display:none" type="" value="" name="state" >';
 	  	echo $content;
 	  }

  function zen_get_country_select($name, $selected = '', $priority_country = '',$para='') {

 	  	$default_country_en="'223','13','222','38','81','176','73','195','150','153','103','203','105','72','160','107'";  //默认优先国家设置
		$default_country_de="'81','14','204','150','176','73','33','97','124','105','195','222','117','56','72'";
		$default_country_ru="'176','20','220','109','123','117','11','67','80','140'";

		if ($priority_country == '') {
			switch ($_SESSION['languages_id']){
				case 1 : $priority_country = $default_country_en; break;
				case 3 : $priority_country = $default_country_ru; break;
				default: $priority_country = $default_country_en; break;
			}
		}else{
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
		}

 	  	$priority_country_array=zen_get_priority_country($priority_country);

 	  	$countries_all_array = zen_get_countries();

 	  	if ($selected != '') {
 	  		$selected = $selected;
 	  	}else{
 	  		switch ($_SESSION['languages_id']){
 	  			case 1 : $selected = 223; break;
 	  			case 3 : $selected = 176; break;
				default: $selected = 223; break;
 	  		}
 	  	}

 	  	$selected_country=zen_get_country_name($selected); 
 	  	$selected_country_info = zen_get_countries($selected);

 	  	$content='';

 	  	$content.='<div  class="country_select_div" id="country_choose"><a class="choose_single" href="javascript:void(0)" ><span>'.$selected_country.'</span><div><b></b></div></a>';

 	  	$content.='<div class="country_select_drop">';

 	  	$content.='<div class="choose_search"><input type="text" autocomplete="off" class=""></div>';

 	  	$content .= '<div id="select_coutry_zip_code_info" style="diplay:none;" zip_code_rule="' . $selected_country_info['countries_zip_code_rule'] . '" zip_code_example="' . $selected_country_info['countries_zip_code_example'] . '"></div>';
 	  	 
 	  	$content.='<ul>';

 	  	$content.='<li id="country_list_1"  class="country_list_line" >---------</li>';
 	  	foreach($priority_country_array as $key=>$val){
 	  		if($val['countries_id']==$selected){
 	  			$default_id=$key+2;
 	  			$content.= '<li id="country_list_'.($key+2).'" cListId="'.$val['countries_id'].'" class="country_list_item" zip_code_rule="' . $val['countries_zip_code_rule'] . '" zip_code_example="' . $val['countries_zip_code_example'] . '">'.$val['countries_name'].'</li>';
 	  		}else{
 	  			$content.= '<li id="country_list_'.($key+2).'" cListId="'.$val['countries_id'].'" class="country_list_item" zip_code_rule="' . $val['countries_zip_code_rule'] . '" zip_code_example="' . $val['countries_zip_code_example'] . '">'.$val['countries_name'].'</li>';
 	  		}
 	  	}

 	  	$content.='<li id="country_list_'.($key+3).'"  class="country_list_line" >---------</li>';
 	  	foreach($countries_all_array as $key2=>$val2){

 	  		if(($val2['countries_id']==$selected)&&!(isset($default_id)&&$default_id!='')){
 	  			$default_id=$key+4+$key2;
 	  			$content.= '<li id="country_list_'.($key+4+$key2).'" cListId="'.$val2['countries_id'].'" class="country_list_item" zip_code_rule="' . $val2['countries_zip_code_rule'] . '" zip_code_example="' . $val2['countries_zip_code_example'] . '">'.$val2['countries_name'].'</li>';
 	  		}
 	  		else{
 	  		 $content.= '<li id="country_list_'.($key+4+$key2).'" cListId="'.$val2['countries_id'].'" class="country_list_item" zip_code_rule="' . $val2['countries_zip_code_rule'] . '" zip_code_example="' . $val2['countries_zip_code_example'] . '">'.$val2['countries_name'].'</li>';
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
  ////eof jessa 2010-005-03

 	  function zen_get_words($base,$quantity,$replace=''){
 	  	if($quantity>1){
 	  		$new_base=$base.'_2';
 	  		if($replace!=''){
 	  			return sprintf(constant(strtoupper($new_base)),$replace);
 	  		}else{
 	  			return constant(strtoupper($new_base));
 	  		}
 	  	}else{
 	  		if($replace!=''){
 	  			return sprintf(constant(strtoupper($base)),$replace);
 	  		}else{
 	  			return constant(strtoupper($base));
 	  		}
 	  	}
 	  }
 	  
	 /**
	   * 促销连接是否显示在导航
	   */
	  function zen_is_promotion_display(){
	    $obj = json_decode(SHOW_PROMOTION_AREA_NAVIGATION); 
	    if($obj->status == 1 && strstr($obj->languages, $_SESSION['languages_code']) != '') {
	      return true;
	    }
	    return false;
	  }
	  
	  /**
	   * 指定促销区是否显示等信息
	   * @param number $area_id
	   */
	  function zen_is_promotion_area_display_info($area_id = 1)
	  {
	  	$display_info = array(
	  			"is_display" => false,
	  			"promotion_area_id"=>$area_id,
	  			"promotion_area_name"=>''
	  	);

	  	 $languages_id = intval($_SESSION['languages_id']);
	  	 $promotion_area_info = get_promotion_area_info_from_memcache($area_id);

	  	 if($promotion_area_info)
	  	 {
	  	 	$display_info['promotion_area_name'] = $promotion_area_info['promotion_area_name'];
  	 		if($promotion_area_info['desc_info'])
  	 		{
  	 			$display_info['promotion_area_name'] = $promotion_area_info['desc_info'][$languages_id];
  	 		}
  	 		
	  	 	if($promotion_area_info['promotion_area_status'] == 1 && in_array($languages_id, explode(',', $promotion_area_info['promotion_area_languages'])))
	  	 	{ 
	  	 		$display_info['is_display'] = true;
	  	 	} 
	  	 }
	  	 
	  	 return $display_info;
	  }

//  	  function zen_is_promotion_time(){ 
//  	  	if(time()>=strtotime(SHOW_PROMOTION_AREA_START_TIME)&&time()<strtotime(SHOW_PROMOTION_AREA_END_TIME)&&SHOW_PROMOTION_AREA_STATUS){
//  	  		return true;
//  	  	}else{
//  	  		return false;
//  	  	}
//  	  }

	/**
	* 是否在facebook like 送礼活动期间
	*/
	function zen_is_facebook_like_time(){
		$dateNow = date('Y-m-d H:i:s');
		return $dateNow >= FACEBOOK_LIKE_START_TIME && $dateNow <= FACEBOOK_LIKE_END_TIME;
	}

	/**
	* fb 抽奖次数
	*/
	function zen_count_facebook_lottery_times(){
		global $db;
		//	可抽奖次数：1、2，默认1
		//	已抽奖次数：0、1、2，默认0
		if(! $_SESSION['customer_id']) return array(1, 0);
		$customer = $db->Execute("Select has_gift From " . TABLE_CUSTOMERS . " Where customers_id ='" . intval($_SESSION['customer_id']) . "'");
		return array(substr($customer->fields['has_gift'], 0, 1), substr($customer->fields['has_gift'], 1, 1));
	}

	/**
	* fb 抽奖 验证编号是否是礼品编号
	*/
	function zen_check_facebook_lottery_prodmodel($pmodel){
		return in_array($pmodel, array(SPINTOWIN_PRODUCT1_CODE,SPINTOWIN_PRODUCT2_CODE,SPINTOWIN_PRODUCT3_CODE));
	}

	function zen_get_text_days($shipping_method, $days = ''){
	  	switch ($shipping_method){
	  		case 'upssk':
	  		case 'upskj':
	  		case 'bpost':
	  		case 'upsdh':
  			//bof to russian method
  			case 'sfhyzxb':
  			case 'sfhky':
  			case 'trstma':
  			case 'ynkqy':
  			case 'trstm':
  			case 'eyoubao':
  			case 'agent':
  			case 'chinapost':
  			case 'airmail':
  			case 'ywelsxb':
  			//eof
  			case 'etk':
  			case 'bybpy':
			case 'cnegh':
			case 'xxeub':
	  			$text_days = TEXT_WORKDAYS;
	  			if ($_SESSION['languages_id'] == 3) {
	  				switch ($days) {
	  					case 1 : $text_days = TEXT_WORKDAYS; break;
	  					case 2 :
	  					case 3 :
	  					case 4 : $text_days = TEXT_WORKDAYS_24; break;
	  					default: $text_days = TEXT_WORKDAYS_ELSE; break;
	  				}
	  			}
	  			break;
	  		default:
	  			$text_days = TEXT_DAYS_LAN;
	  			if ($_SESSION['languages_id'] == 3) {
	  				switch ($days) {
	  					case 1 : $text_days = TEXT_DAYS_LAN; break;
	  					case 2 :
	  					case 3 :
	  					case 4 : $text_days = TEXT_DAYS_LAN_24; break;
	  					default: $text_days = TEXT_DAYS_LAN_ELSE; break;
	  				}
	  			}
	  	}
	  	return $text_days;
	}

function zen_get_order_total_str($order_total_array,$coupon=false){
	global $currencies,$order;
	$order_total_str='';
	$_SESSION['cart']->get_isvalid_checkout_products_optimize();
    $total_amount_original = $currencies->format($_SESSION ['cart']->show_origin_amount (), false);
    $total_amount_discount = $currencies->format($_SESSION ['cart']->show_discount_amount (), false);
	$original_prices = $_SESSION ['cart']->show_total_original();
	$cash_account = 0;
	$grand_total = 0;
    $order_discount = 0;
    $vip = 0 ;
    $rcd = 0;
    $special_discount = 0;
    $coupon_amount = 0;
    $manjian_discount = 0;
    for ($i = 0, $n = sizeof($order_total_array); $i < $n; $i++){
        if($order_total_array[$i]['code'] == 'ot_order_discount'){
            $order_discount += $currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $order_discount += 0;
        }
        if($order_total_array[$i]['code'] == 'ot_group_pricing'){
            $vip +=$currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $vip +=0;
        }
        if($order_total_array[$i]['code'] == 'ot_coupon'){
            $rcd +=$currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $rcd +=0;
        }
        if($order_total_array[$i]['code'] == 'ot_big_orderd'){
            $special_discount +=$currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $special_discount +=0;
        }
        if($order_total_array[$i]['code'] == 'ot_discount_coupon'){
            $coupon_amount +=$currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $coupon_amount +=0;
        }
        if($order_total_array[$i]['code'] == 'ot_promotion'){
            $manjian_discount +=$currencies->format_cl($order_total_array[$i]['value']);
        }else{
            $manjian_discount +=0;
        }
    }
    $vip_rcd = $vip + $rcd;
    if($order_discount >= $vip_rcd){
        $discounts = $order_discount + $special_discount + $manjian_discount;
    }else{
        $discounts = $vip_rcd +$special_discount + $manjian_discount;
    }

	foreach($order_total_array as $key=>$val){
		if($key == 0){		//	subtotal
			$total_price = $order->info['subtotal_show'];//$currencies->format_cl($val['value']);
			$order_total_str .= '<dt>' . TEXT_CART_ORIGINAL_PRICES . ':</dt><dd> '.$currencies->format($original_prices, false).'<ins class="question_icon"></ins><div class="pricetips" style="display: none;"><span class="bot"></span><span class="top"></span><p>' . TEXT_CART_ORIGINAL_PRICES . ' = ' . TEXT_REGULAR_AMOUNT . ' + ' . TEXT_CART_PRODUCT_DISCOUNTS . '</p>'.$currencies->format($original_prices, false).'  = '.$total_amount_original.' + '.$total_amount_discount.'</div></dd>';

			if($discounts+$original_prices-$total_price > 0){
                $order_total_str .= '<dt>'.TEXT_CART_DISCOUNT.':</dt><dd>- '.$currencies->format($discounts+$original_prices-$total_price,false).'<span class="image_down_arrow">'.'</span><span class="image_up_arrow" style="display:none;"></span>'.'</dd>';
            }

            $order_total_str .='<table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;">';

			if($original_prices-$total_price > 0){
                $order_total_str .='<table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none; border:none"><tr><th>'.TEXT_PROMOTION_SAVE.':</th><td>- '.$currencies->format( ($original_prices-$total_price), false).'</td></tr></table>';
            }

			$grand_total = $total_price;
        }elseif($val['code'] == 'ot_coupon'){   //  coupon
          if($coupon){
              $trail = zen_not_null($val['percentage_discount']) ? ' <font color="red">('.round($val['percentage_discount'],2).'% ' . TEXT_DISCOUNT_OFF . ')</font>' : '';
              if(substr($val['text'],0,1) == '-'){
                  $grand_total -= $currencies->format_cl($val['value']);
              
                  $order_total_str .='<table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none; border:none"><tr><th>'.$val['title'].$trail.':</th><td>- '.substr($val['text'],1).'</td></tr></table>';
              }else{
                  $grand_total += $currencies->format_cl($val['value']);

                  $order_total_str .='<table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;"><tr><th>'.($coupon==1? '<span class="arrow"></span>' : '').$val['title'].$trail.':</th><td> '.$val['text'].'</td></tr></table>';
              }
          }
		}elseif($val['code'] == 'ot_cash_account'){		//	not show cash
			if($val['value']!=0 || $val['value']!=''){
				$cash_account = $currencies->format_cl($val['value']);
			}
			continue;
		}elseif($key == (sizeof($order_total_array)-1)){	//	total
			if($grand_total<0) $grand_total = 0;
			$show_grand_total = ( $cash_account!=0 ? $currencies->format($grand_total, false) : $currencies->format($val['value']) );
			$order_total_str.='<dt><strong>' . TABLE_HEADING_TOTAL . ':</strong></dt><dd><strong>'.$show_grand_total.'</strong></dd>';
		
		}elseif($val['code'] == 'ot_big_orderd'){
            if(substr($val['text'],4) >0){
                $order_total_str .='<table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;border:none"><tr><th>'.$val['title'].'</th><td>- '.substr($val['text'],1).'</td></tr></table>';
            }
            $grand_total -= $currencies->format_cl($val['value']);
        }elseif ($val['code'] == 'ot_promotion'){
		    $grand_total -= $currencies->format_cl($val['value']);
            $order_total_str .='<table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;border:none"><tr><th>'.$val['title'].':</th><td>- '.substr($val['text'],1).'</td></tr></table>';
		}else if($val['code']=='ot_discount_coupon'){
            $grand_total -= $currencies->format_cl($val['value']);
            $order_total_str .='<dt>'.TEXT_MY_COUPON.':</dt><dd>- '.$currencies->format($coupon_amount,false).'</dd>';
        }else{	//	others
            $title = $trail = '';
            if($val['code']=='ot_shipping')
                $title = TEXT_SHIPPING_CHARGE;
            else if($val['code']=='ot_group_pricing'){
                $title = TEXT_CART_VIP_DISCOUNT;
                $trail = zen_not_null($val['percentage_discount']) ? '<font color="red">('.round($val['percentage_discount'],2).'% ' . TEXT_DISCOUNT_OFF . ')</font>' : '';

            }else{
                $title = $val['title'];
            }

            if(substr($val['text'],0,1) == '-'){
                $grand_total -= $currencies->format_cl($val['value']);
                $val['text'] = '- '.substr($val['text'],1);
                $order_total_str .= '<table cellpadding="0" cellspacing="0" border="0" class="price_sub" style="display:none;border:none"><tr><th>'.$title.$trail.':</th><td>'.$val['text'].'</td></tr></table>';
            }else if($val['code']=='ot_handing_fee'){
                //handinn fee 收取
                $grand_total += $currencies->format_cl($val['value']);
                $order_total_str .= '<dt>'.$title.$trail.'</dt><dd>'.$val['text'].'<ins class="question_icon"></ins><div class="pricetips" style="display: none;"><span class="bot"></span><span class="top"></span><p>'.TEXT_HANDINGFEE_INFO.'</p></div></dd>';
            }else{
                $grand_total += $currencies->format_cl($val['value']);
                $val['text'] = $val['text']==TEXT_FREE_SHIPPING ? $val['text'] : ' '.$val['text'];
                $order_total_str .= '<dt>'.$title.$trail.'</dt><dd>'.$val['text'].'</dd>';
            }
		}
	}
	
	return $order_total_str;
}

function zen_get_country_select_new($name, $selected = '', $priority_country = '',$para='') {
	$default_country_en="'223','13','222','38','81','176','73','195','150','153','103','203','105','72','160','107'";
	$default_country_de="'81','14','204','150','176','73','33','97','124','105','195','222','117','56','72'";
	$default_country_ru="'176','20','220','109','123','117','11','67','80','140'";
	switch($priority_country){
		case 1:
			$priority_country=	$default_country_en;
			$selected=($selected!='')?$selected:223;
			break;
		case 2:
			$priority_country=	$default_country_de;
			$selected=($selected!='')?$selected:81;
			break;
		case 3:
			$priority_country=	$default_country_ru;
			$selected=($selected!='')?$selected:176;
			break;
		default:
			$priority_country=	$default_country_en;
			$selected=($selected!='')?$selected:223;
	}
	$priority_country_array = zen_get_priority_country($priority_country);
	$countries_all_array = zen_get_countries();

	$selected_country=zen_get_country_name($selected);
	$selected_country_info = zen_get_countries($selected);
	$content='<select name="' . zen_output_string($name) . '" id="zone_country_id">';
	$has_selected = false;
	foreach($priority_country_array as $key=>$val){
		if($val['countries_id']==$selected){
			$has_selected = true;
			$content.= '<option value="' . zen_output_string($val['countries_id']) . '" zip_code_rule="' . $val['countries_zip_code_rule'] . '" zip_code_example="' . $val['countries_zip_code_example'] . '" selected>' . $val['countries_name'] . '</option>';
		}else{
			$content.= '<option value="' . zen_output_string($val['countries_id']) . '" zip_code_rule="' . $val['countries_zip_code_rule'] . '" zip_code_example="' . $val['countries_zip_code_example'] . '">' . $val['countries_name'] . '</option>';
		}
	}
	foreach($countries_all_array as $key2=>$val2){
		if($val2['countries_id']==$selected && !$has_selected){
			$content.= '<option value="' . zen_output_string($val2['countries_id']) . '" zip_code_rule="' . $val2['countries_zip_code_rule'] . '" zip_code_example="' . $val2['countries_zip_code_example'] . '" selected>' . $val2['countries_name'] . '</option>';
		}else{
			$content.= '<option value="' . zen_output_string($val2['countries_id']) . '" zip_code_rule="' . $val2['countries_zip_code_rule'] . '" zip_code_example="' . $val2['countries_zip_code_example'] . '">' . $val2['countries_name'] . '</option>';
		}
	}
	$content.='</select>';
	
	$content .= '<div id="select_coutry_zip_code_info" style="diplay:none;" zip_code_rule="' . $selected_country_info['countries_zip_code_rule'] . '" zip_code_example="' . $selected_country_info['countries_zip_code_example'] . '"></div>';
	$content.='<input type="hidden" name="zip_code_rule" id="zip_code_rule" value="'.$selected_country_info['countries_zip_code_rule'].'">';
	$content.='<input type="hidden" name="zip_code_example" id="zip_code_example" value="'.$selected_country_info['countries_zip_code_example'].'">';
	$content.='<input type="hidden" id="cSelectId" value="'.$selected.'">';
	return $content;
}

function zen_get_qty_input_and_button($product_info, $page_name, $page_type, $bool_in_cart, $procuct_qty,$new=false){
	global $db;
	if(!is_array($product_info)){
		$products=$product_info;
		unset($product_info);
		$product_info['products_quantity']=$products->products_quantity;
		$product_info['products_id']=$products->products_id;
		$product_info['products_quantity_order_min']=1;
		$product_info['products_model']=$products->products_model;
		$product_info['products_limit_stock']=0;
	}
	/*
	$check_product = $db->Execute("select wl_products_id from ".TABLE_WISH." where wl_products_id = " . (int)$product_info['products_id'] . " and wl_customers_id = " . (int)$_SESSION['customer_id']);
	$product_in_wishlist = ($check_product->RecordCount() == 0) ? false : true;
	if($product_in_wishlist){
		$wilshlist_class = "addcollects addcollect-btn-success addcollect_".$product_info['products_id'];
		$clicktxt = 'onclick = "Addtowishlist('.$product_info['products_id'].',1,\''. $_SESSION['language'].'\')"';
	} else {
		$wilshlist_class = "addtowish addcollect_".$product_info['products_id'];
		$clicktxt = 'onclick = "Addtowishlist('.$product_info['products_id'].',1,\''. $_SESSION['language'].'\')"';

	}
	*/
	if($product_info['products_quantity']==0){
		//$content='<li><a class="restock-btn" href="javascript:void(0);" onclick="restockNotification(\''.$product_info['products_id'].'\', \''.$page_type.'\', \''.$_SESSION['language'].'\');">'. TEXT_RESTOCK_NOTIFY.'</a></li>' . '<li><a class="soldoutbtn" href="javascript:void(0)"><ins></ins>'.TEXT_SOLD_OUT.'</a></li>';
		$content='</li>' . '<li><a class="soldoutbtn" href="javascript:void(0)"><ins></ins>'.TEXT_SOLD_OUT.'</a></li>';
	}else{
		$content = '<li><input type="text" maxlength="5"  class="addToCart" id="product_listing_' . $product_info['products_id'] . '" name="products_id[' . $product_info['products_id'] . ']" value="' . ($bool_in_cart ? $procuct_qty : $product_info['products_quantity_order_min']) . '" size="4" />';
		$content .= '<input type="hidden" id="MDO_' . $product_info['products_id'] . '" value="' . $bool_in_cart . '" />
  				<input type="hidden" id="incart_' . $product_info['products_id'] . '" value="' . ($bool_in_cart ? $procuct_qty : 0) . '" /></li>';
		if($bool_in_cart){
			$content .= '<li><a href="javascript:void(0)" class="updatecart" id="submitp_' . $product_info['products_id'] .  '" onclick="Addtocart('.$product_info['products_id'].','.$page_type.', \''. $_SESSION['language'].'\'); return false;"><ins></ins>'.IMAGE_BUTTON_UPDATE_CART.'</a></li>';
		} else {
			$content .= '<li><a href="javascript:void(0)" class="addcart" id="submitp_' . $product_info['products_id'] . '" onclick="Addtocart('.$product_info['products_id'].','.$page_type.', \''. $_SESSION['language'].'\'); return false;"><ins></ins>'.TEXT_CART_ADD_TO_CART.'</a></li>';
		}
	}
	$content .= '<li><a class="addtowish" id="wishlist_'.$product_info['products_id'].'" name="wishlish_'.$product_info['products_id'].'" href="javascript:void(0)" onclick = "Addtowishlist('.$product_info['products_id'].','.$page_type.',\''. $_SESSION['language'].'\')">+ '.TEXT_CART_MOVE_TO_WISHLIST.'</a></li>';

	return $content;
}

function zen_get_qty_input_and_button_gallery($product_info, $bool_in_cart, $procuct_qty, $page_type){
	global $db;
	if(!is_array($product_info)){
		$products=$product_info;
		unset($product_info);
		$product_info['products_quantity']=$products->products_quantity;
		$product_info['products_id']=$products->products_id;
		$product_info['products_quantity_order_min']=1;
		$product_info['products_model']=$products->products_model;
		$product_info['products_limit_stock']=0;
	}

	$content = '<div class="cartcont">';
	if($product_info['products_quantity']==0){
		$content.='<a class="soldtext" href="javascript:void(0);" onclick="restockNotification(\''.$product_info['products_id'].'\', \''.$page_type.'\', \''.$_SESSION['language'].'\');">'. TEXT_RESTOCK_NOTIFY.'</a>'
			.'<a class="soldoutbtn" href="javascript:void(0)"><ins></ins>'.TEXT_SOLD_OUT.'</a>';
	}else{
		$content .= '<input type="text" maxlength="5" class="addToCart" id="product_listing_' . $product_info['products_id'] . '" name="products_id[' . $product_info['products_id'] . ']" value="' . ($bool_in_cart ? $procuct_qty : $product_info['products_quantity_order_min']) . '" size="4" />';
		$content .= '<input type="hidden" id="MDO_' . $product_info['products_id'] . '" value="' . $bool_in_cart . '" />
  				<input type="hidden" id="incart_' . $product_info['products_id'] . '" value="' . ($bool_in_cart ? $procuct_qty : 0) . '" />';
		if($bool_in_cart){
			$content .= '<a href="javascript:void(0)" class="updatecart" id="submitp_' . $product_info['products_id'] .  '" onclick="Addtocart('.$product_info['products_id'].','.$page_type.', \''. $_SESSION['language'].'\'); return false;"><ins></ins>'.IMAGE_BUTTON_UPDATE_CART.'</a>';
		} else {
			$content .= '<a href="javascript:void(0)" class="addcart" id="submitp_' . $product_info['products_id'] . '" onclick="Addtocart('.$product_info['products_id'].','.$page_type.', \''. $_SESSION['language'].'\'); return false;"><ins></ins>'.TEXT_CART_ADD_TO_CART.'</a>';
		}
	}
	$content .= '<a class="addcollect" id="wishlist_'.$product_info['products_id'].'" name="wishlish_'.$product_info['products_id'].'" href="javascript:void(0)" onclick = "Addtowishlist('.$product_info['products_id'].','.$page_type.',\''. $_SESSION['language'].'\')">+ '.TEXT_CART_MOVE_TO_WISHLIST.'</a>
			</div>';

	return $content;
}

function zen_name_add_space($name){
	$name = htmlspecialchars_decode($name);
	return str_replace(array(',','-',':','(','&'),array(', ',' - ',': ',' (',' &'),$name);
}

function zen_get_selected_country($id){
	switch($id){
		case 1:
			$country=223;
			break;
		case 2:
			$country=81;
			break;
		case 3:
			$country=176;
			break;
		default:
			$country=223;
	}
	return $country;
}

function zen_get_order_total_str_mobilesite($order_total_array){
	$order_total_str = '';
	foreach($order_total_array as $key => $val){
		if ($val['code'] == 'ot_subtotal') {
			$title = TEXT_CART_TOTAL_PRODUCT_PRICE;
		} else if($val['code'] == 'ot_shipping'){
			$title = TEXT_SHIPPING_CHARGE;
		} else if($val['code']=='ot_group_pricing'){
			$title = TEXT_CART_VIP_DISCOUNT;
		} else {
			$title = $val['title'];
		}
		if (substr(trim($title), -1, 1) == ':') {
			$title = substr(trim($title), 0, -1);
		}
		if ($val['percentage_discount'] > 0) {
			$title .= '<span class="percentage_color"> (' . round($val['percentage_discount'], 2) . '%)</span>';
		}
		if (substr($val['text'], 0, 1) == '-') {
			$text = '(-) ' . substr($val['text'], 1);
		}else{
			$text = $val['text'];
		}
		$order_total_str .= '<tr><th>' . $title . ':</td><td class="total_pice price_color">' .$text . '</td></tr>';
	}
	return $order_total_str;
}

  /**
   * WSL
   * 折扣图标
   * @param float $dsicount
   */
  function draw_discount_img($discount_amount,$label,$class='icon_discount'){
  	if($label == 'span'){
  		$discount_img = '<span class="' .$class. '">' . (( $_SESSION['languages_id']=='2' || $_SESSION['languages_id']=='3' || $_SESSION['languages_id']=='4')?('<ins>-'.$discount_amount.'%</ins>'):('<ins>'.$discount_amount.'%<br>off</ins>' )) . '</span>';
  	}elseif ($label == 'div'){
  		$discount_img = '<div class="' .$class. '">' . (( $_SESSION['languages_id']=='2' || $_SESSION['languages_id']=='3' || $_SESSION['languages_id']=='4' )?('<ins>-'.$discount_amount.'%</ins>'):('<ins>'.$discount_amount.'%<br>off</ins>' )) . '</div>';  		
  	} 	   	 
  	return  $discount_img;
  }

  /*
   * check small size product by last character 'S' for other_package_size
  */
  function check_small_size($products_model){
    if(substr($products_model, -1)=='S'){
      return true;
    }else{
      return false;
    }     
  }
  
  