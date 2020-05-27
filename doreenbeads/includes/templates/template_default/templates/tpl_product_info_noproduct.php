<?php
/**
 * Page Template
 *
 * Displays simple "product not found" message if the selected product's details cannot be located in the database
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_info_noproduct.php 2578 2005-12-15 19:31:34Z drbyte $
 */
?>
<?php 
include($define_page);
$define_page_system_page_baner_content = trim(file_get_contents($define_page_system_page_baner));
if(!empty($define_page_system_page_baner) && is_file($define_page_system_page_baner) && !empty($define_page_system_page_baner_content)) {
	echo '<h2 class="search_error_title">' . TEXT_SEARCH_RESULT_FIND_MORE . '</h2>';
	echo '<div>';
	include($define_page_system_page_baner);
	echo '</div>';
}
?>