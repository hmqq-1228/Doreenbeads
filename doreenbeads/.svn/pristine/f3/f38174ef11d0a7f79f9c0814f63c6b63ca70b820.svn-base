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