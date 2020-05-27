<?php
require ('includes/application_top.php');
$aid = zen_db_prepare_input ( $_POST ['aid'] );
$type = zen_db_prepare_input ( $_POST ['type'] );

if($type == 'parts'){ 
	$article_sql = "select parts_num
					from ".TABLE_LC_ARTICLE."  
					where article_id = ".$aid." 	 
					and language_id = '" . $_SESSION['languages_id'] . "' 
					and article_status=1 ";
	$article_result = $db->Execute($article_sql);
	if($article_result->RecordCount()>0){
		while (!$article_result->EOF) {
			$article_list_array = array("parts_num" => $article_result->fields['parts_num']);
			$article_result->MoveNext();
		}
	}

	$parts_num = explode(',', $article_list_array['parts_num']);
		foreach ($parts_num as $key => $value) {
			$parts_arr[] = "'".$value."'";
		}
	$parts_num1 = implode(',', $parts_arr);

	$parts_num_sql = "select products_id, products_quantity, products_model
							from ".TABLE_PRODUCTS."  
							where products_model in (".$parts_num1.")
							and products_status = 1 ";

	$parts_num_result = $db->Execute($parts_num_sql);
	$product_res1 = array();
	if($parts_num_result->RecordCount()>0){
		while (!$parts_num_result->EOF) {
			$product_res1[] = array("products_id" => $parts_num_result->fields['products_id'],
									"qty" => $parts_num_result->fields['products_quantity'],
									"products_model" => $parts_num_result->fields['products_model']
				);
			$parts_num_result->MoveNext();
		}
	}

	$products_in_cart = '';
	$j = 0;
	for($i = 0, $n = sizeof ( $product_res1 ); $i < $n; $i ++) {
		$products_id = $product_res1[$i]['products_id'];
		$products_qty = $product_res1[$i]['qty'];
		$products_model = $product_res1[$i] ['products_model'];
		

		if ($_SESSION ['cart']->in_cart ( $products_id )) {
			$products_in_cart .= $products_model . ', ';
		} else {
			$_SESSION ['cart']->add_cart ( $products_id, '1' );
			$j++;
		}
	}
	$products_in_cart = substr($products_in_cart, 0, -2);
	if ($j === 0){ //all products in cart
		$type = 0;
		$text = TEXT_ALREADY_INCART0;
	}elseif($j == $i){ // no products in cart
		$type = 1;
	}else{ //some products in cart
		$type = 2;
		if ($n - $j - 1 > 1){
			$text = sprintf(TEXT_ALREADY_INCART2, $products_in_cart);
		}else{
			$text = sprintf(TEXT_ALREADY_INCART1, $products_in_cart);
		}	
	}
}elseif($type == 'tools'){
	$article_sql1 = "select tools_num
					from ".TABLE_LC_ARTICLE."  
					where article_id = ".$aid." 	 
					and language_id = '" . $_SESSION['languages_id'] . "' 
					and article_status=1 ";
	$article_result1 = $db->Execute($article_sql1);
	if($article_result1->RecordCount()>0){
		while (!$article_result1->EOF) {
			$article_list_array1 = array("tools_num" => $article_result1->fields['tools_num']);
			$article_result1->MoveNext();
		}
	}

	$tools_num = explode(',', $article_list_array1['tools_num']);
		foreach ($tools_num as $key => $value) {
			$tools_arr[] = "'".$value."'";
		}
	$tools_num1 = implode(',', $tools_arr);

	$tools_num_sql = "select products_id, products_quantity, products_model
							from ".TABLE_PRODUCTS."  
							where products_model in (".$tools_num1.")
							and products_status = 1 ";

	$tools_num_result = $db->Execute($tools_num_sql);
	$product_res1 = array();
	if($tools_num_result->RecordCount()>0){
		while (!$tools_num_result->EOF) {
			$product_res1[] = array("products_id" => $tools_num_result->fields['products_id'],
									"qty" => $tools_num_result->fields['products_quantity'],
									"products_model" => $tools_num_result->fields['products_model']
				);
			$tools_num_result->MoveNext();
		}
	}

	$products_in_cart = '';
	$j = 0;
	for($i = 0, $n = sizeof ( $product_res1 ); $i < $n; $i ++) {
		$products_id = $product_res1[$i]['products_id'];
		$products_qty = $product_res1[$i]['qty'];
		$products_model = $product_res1[$i] ['products_model'];
		
		if ($_SESSION ['cart']->in_cart ( $products_id )) {
			$products_in_cart .= $products_model . ', ';
		} else {
			$_SESSION ['cart']->add_cart ( $products_id, '1' );
			$j++;
		}
	}
	$products_in_cart = substr($products_in_cart, 0, -2);
	if ($j === 0){ //all products in cart
		$type = 0;
		$text = TEXT_ALREADY_INCART0;
	}elseif($j == $i){ // no products in cart
		$type = 1;
	}else{ //some products in cart
		$type = 2;
		if ($n - $j - 1 > 1){
			$text = sprintf(TEXT_ALREADY_INCART2, $products_in_cart);
		}else{
			$text = sprintf(TEXT_ALREADY_INCART1, $products_in_cart);
		}	
	}
}elseif($type == 'all'){
	$article_sql1 = "select tools_num, parts_num
					from ".TABLE_LC_ARTICLE."  
					where article_id = ".$aid." 	 
					and language_id = '" . $_SESSION['languages_id'] . "' 
					and article_status=1 ";
	$article_result1 = $db->Execute($article_sql1);
	if($article_result1->RecordCount()>0){
		while (!$article_result1->EOF) {
			$article_list_array1 = array("tools_num" => $article_result1->fields['tools_num'],
										"parts_num" => $article_result1->fields['parts_num']);
			$article_result1->MoveNext();
		}
	}

	$tools_num = explode(',', $article_list_array1['tools_num']);
	foreach ($tools_num as $key => $value) {
		$tools_arr[] = "'".$value."'";
	}
	$parts_num = explode(',', $article_list_array1['parts_num']);
	foreach ($parts_num as $key => $value) {
		$tools_arr[] = "'".$value."'";
	}

	$nums = implode(',', $tools_arr);
	if($nums == '') exit();

	$tools_num_sql = "select products_id, products_quantity, products_model
							from ".TABLE_PRODUCTS."  
							where products_model in (".$nums.")
							and products_status = 1 ";

	$tools_num_result = $db->Execute($tools_num_sql);
	$product_res1 = array();
	if($tools_num_result->RecordCount()>0){
		while (!$tools_num_result->EOF) {
			$product_res1[] = array("products_id" => $tools_num_result->fields['products_id'],
									"qty" => $tools_num_result->fields['products_quantity'],
									"products_model" => $tools_num_result->fields['products_model']
				);
			$tools_num_result->MoveNext();
		}
	}

	$products_in_cart = '';
	$j = 0;
	for($i = 0, $n = sizeof ( $product_res1 ); $i < $n; $i ++) {
		$products_id = $product_res1[$i]['products_id'];
		$products_qty = $product_res1[$i]['qty'];
		$products_model = $product_res1[$i] ['products_model'];
		
		if ($_SESSION ['cart']->in_cart ( $products_id )) {
			$products_in_cart .= $products_model . ', ';
		} else {
			$_SESSION ['cart']->add_cart ( $products_id, '1' );
			$j++;
		}
	}
	$products_in_cart = substr($products_in_cart, 0, -2);
	if ($j === 0){ //all products in cart
		$type = 0;
		$text = TEXT_ALREADY_INCART0;
	}elseif($j == $i){ // no products in cart
		$type = 1;
	}else{ //some products in cart
		$type = 2;
		if ($n - $j - 1 > 1){
			$text = sprintf(TEXT_ALREADY_INCART2, $products_in_cart);
		}else{
			$text = sprintf(TEXT_ALREADY_INCART1, $products_in_cart);
		}	
	}
}
//echo $text;
?>