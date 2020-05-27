<?php
/**
 * search_field_header.php
 * HTML-generating functions used throughout the core
 *
 * @package functions
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: html_output.php 4792 2006-10-20 04:41:38Z drbyte $
 */

/*
 *  Output a form input field
 */
  function zen_draw_search_field($name, $value = '', $parameters = '', $type = 'search', $reinsert_value = true) {
    $field = '<input type="' . zen_output_string($type) . '" name="' . zen_output_string($name) . '"';

    if ( (isset($GLOBALS[$name])) && ($reinsert_value == true) ) {
      $field .= ' value="' . zen_output_string(stripslashes($GLOBALS[$name])) . '"';
    } elseif (zen_not_null($value)) {
      $field .= ' value="' . zen_output_string($value) . '"';
    }

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= ' />';

    return $field;
  }
  
?>