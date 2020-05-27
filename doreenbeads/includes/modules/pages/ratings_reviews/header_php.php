<?php
/**
 * header_php.php
 * ratings and reviews
 */
  
  require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
  $breadcrumb->add('Ratings and Reviews', zen_href_link('ratings_reviews'));
  
  $show_ratings_reviews = false;
  
  //这里是直接从product表中读取产品的类别的, 是不是要从products_to_categories表中来读取产品的类别, 有待研究
  $reviews_categories_query = "select count(c.categories_id) as counts, cd.categories_name, c.categories_id
  							   from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p,
									" . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd							   		
  							  where r.reviews_id = rd.reviews_id
  							    and r.status = 1
  							    and r.products_id = p.products_id<
  							    and p.master_categories_id = c.categories_id
  							    and c.categories_id = cd.categories_id
  						   group by c.categories_id
  						   order by counts desc";
  $reviews_categories = $db->Execute($reviews_categories_query);
  
  $reviews_categories_array = array();
  if ($reviews_categories->RecordCount() > 0){
  	$show_ratings_reviews = true;
  	while (!$reviews_categories->EOF){
  		$reviews_categories_array[] = array('categories_id' => $reviews_categories->fields['categories_id'],
  										    'categories_name' => $reviews_categories->fields['categories_name'],
  										    'counts' => $reviews_categories->fields['counts']); 
  		$reviews_categories->MoveNext();
  	}
  }
  
  $row = 0;
  $col = 0;
  $cnt = 0;
  $show_reviews_array = array();
  while ($cnt < sizeof($reviews_categories_array)){
  	$show_reviews_array[$row][$col] = array('text' => '<a href="' . zen_href_link('categories_reviews', 'categorie_id=' . $reviews_categories_array[$cnt]['categories_id']) . '">' . $reviews_categories_array[$cnt]['categories_name'] . '</a>&nbsp;&nbsp;' . $reviews_categories_array[$cnt]['counts'] . TEXT_REVIEWS);
  	$col++;
  	if ($col > 1){
  		$col = 0;
  		$row++;
  	}
  	$cnt++;
  }
  
  //获得reviews最多的6个产品
  $show_reviews_products = false;
  $reviews_products_query = "select count(r.products_id) as counts, p.products_id, p.products_model, p.products_image, 
  							 		pd.products_name
  							   from " . TABLE_REVIEWS . " r, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
  							  where r.status = 1
  							    and r.products_id = p.products_id
  							    and p.products_id = pd.products_id
  						   group by r.products_id
  						   order by counts desc
  						      limit 0, 6";
  $reviews_products = $db->Execute($reviews_products_query);
  
  $reviews_products_array = array();
  if ($reviews_products->RecordCount() > 0){
  	$show_reviews_products = true;
  	while (!$reviews_products->EOF){
  		$reviews_products_array[] = array('products_id' => $reviews_products->fields['products_id'],
  										  'products_model' => $reviews_products->fields['products_model'],
  										  'products_image' => $reviews_products->fields['products_image'],
  										  'products_name' => $reviews_products->fields['products_name'],
  										  'counts' => $reviews_products->fields['counts']);
  		$reviews_products->MoveNext();
  	}
  }
  $row = 0;
  $col = 0;
  $cnt = 0;
  $show_products_reviews_array = array();
  while ($cnt < sizeof($reviews_products_array)){
  	$show_products_reviews_array[$row][$col] = array('text' => '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . $reviews_products_array[$cnt]['products_id']) . '">' . 
  													            zen_image(DIR_WS_IMAGES . $reviews_products_array[$cnt]['products_image'], IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT) . '</a><br />' . 
  													            '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . $reviews_products_array[$cnt]['products_id']) . '">' . 
  													            $reviews_products_array[$cnt]['products_name'] . '</a>' . ' ( ' . $reviews_products_array[$cnt]['counts'] . ' )');
  	$col++;
  	if ($col > 2){
  		$col = 0;
  		$row++;
  	}
  	$cnt++;
  }
?>