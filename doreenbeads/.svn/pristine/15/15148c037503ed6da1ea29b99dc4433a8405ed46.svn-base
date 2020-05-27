<?php
	$breadcrumb->add('Download New Products');
	require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

	if (isset($_POST['models']) && $_POST['models'] != ''){
		//bof get the post data
		$input_products_model = stripslashes(trim($_POST['models']));
		//eof get the post data
		$download_new_products = $db->Execute("select p.products_id, p.products_price, p.products_image, pd.products_name, p.products_model 
											   from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd 
											   where p.products_id = pd.products_id
											   and p.products_status = 1
											
											   and p.products_model in (" . $input_products_model . ")
											   order by products_date_added desc");
		$download_new_products_num = $download_new_products->RecordCount();
		
		$download_count = 0;
		$download_new_products_array = array();
		while(!$download_new_products->EOF){
			$download_new_products_array[$download_count] = array('id' => $download_new_products->fields['products_id'],
																  'model' => $download_new_products->fields['products_model'],
																  'price' => $download_new_products->fields['products_price'],
																  'image' => $download_new_products->fields['products_image'],
																  'name' => $download_new_products->fields['products_name']);
			$download_count++;
			$download_new_products->MoveNext();
		}
		
		$row = 0;
		$col = 0;
		$count = 0;
		$show_download_new_products = array();
		while($count < sizeof($download_new_products_array)){
			if ($count == 0){
				$show_download_new_products[$row][$col] = array('text' => '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $download_new_products_array[$count]['id']) . '">' . zen_image(HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $download_new_products_array[$count]['image'], $download_new_products_array[$count]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br />' . '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $download_new_products_array[$count]['id']) . '">' . $download_new_products_array[$count]['name'] . '</a><br /><span class="listingPrice">' . zen_get_products_display_price($download_new_products_array[$count]['id']) . '</span>');
			}else{
				if ($download_new_products_array[$count]['model'] != $download_new_products_array[$count - 1]['model']){
					$show_download_new_products[$row][$col] = array('text' => '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $download_new_products_array[$count]['id']) . '">' . zen_image(HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $download_new_products_array[$count]['image'], $download_new_products_array[$count]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br />' . '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $download_new_products_array[$count]['id']) . '">' . $download_new_products_array[$count]['name'] . '</a><br /><span class="listingPrice">' . zen_get_products_display_price($download_new_products_array[$count]['id']) . '</span>');
				}
			}
			$col++;
			if ($col > 2){
				$col = 0;
				$row++;
			}
			$count++;
		}	
	}else{
		zen_redirect(HTTP_SERVER . DIR_WS_CATALOG);
	}
	
?>