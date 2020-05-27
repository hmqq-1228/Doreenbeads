<?php
	require(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', 'define_sidebox_promotion.php', 'false'));
	if(!($_GET['main_page'] == 'index' && $_GET['cPath'] == '')){ 
		$recently_products_arr = get_recently_viewed_products(true);
		$customers_recently_products = '';
			
		if(sizeof($recently_products_arr) > 0){
			$customers_recently_products .= '<div class="sidesafe_icon" style="padding-top:0px;float: inherit;" >
			<h4>' . TEXT_RECENTLY_VIEWED . '</h4>';
			foreach ($recently_products_arr as $values){
				$customers_recently_products .= '<div class="recently_pic"><a class="imglist" href="' . $values['product_link'] . '">' . $values['product_image'] . '</a></div>';
			}
			$customers_recently_products .= '</div>';
		}
	}
	echo $customers_recently_products;
	//require($template->get_template_dir('tpl_order_guide.php', DIR_WS_TEMPLATE, $current_page_base, 'sideboxes') . '/tpl_order_guide.php');

?>