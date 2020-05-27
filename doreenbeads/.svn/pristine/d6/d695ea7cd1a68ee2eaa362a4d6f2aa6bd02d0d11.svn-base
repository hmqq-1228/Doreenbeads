<?php
require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/product_info.php');

if (isset ( $_GET ['action'] ) && ($_GET ['action'] == 'process')) {
	//instanceFollowRedirects(false);

	$rating = zen_db_prepare_input ( $_GET ['rating'] );
	
	$review_text = zen_db_prepare_input ( $_GET ['review_text'] );
	
/* 	function curl_post($url,$post){
		$options =array(
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HEADER		   => TRUE,
			CURLOPT_PORT		   => TRUE,
			CURLOPT_POSTFIELDS	   => $post	 				
		);
		$ch = curl_init($url);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}	
	$data = curl_post(zen_href_link(FILENAME_LOGIN), array('rating'=>$rating,'review_text'=>$review_text)); */
	
	if (! $_SESSION ['customer_id']) {
		$_SESSION ['navigation']->set_snapshot ();

		zen_redirect ( zen_href_link ( FILENAME_LOGIN,'','SSL') );
	}
	
    if(zen_validate_url($review_text)){
        $sql = "INSERT INTO " . TABLE_REVIEWS . " (products_id, customers_id, customers_name, reviews_rating, date_added, status) VALUES (:productsID, :customersID, :customersName, :rating, now(), 1)";
        $sql = $db->bindVars ( $sql, ':productsID', $_GET ['products_id'], 'integer' );
        $sql = $db->bindVars ( $sql, ':customersID', $_SESSION ['customer_id'], 'integer' );
        $sql = $db->bindVars ( $sql, ':customersName', $_SESSION ['customer_first_name'] . ' ' . $_SESSION ['customer_last_name'], 'string' );
        $sql = $db->bindVars ( $sql, ':rating', $rating, 'string' );
        $db->Execute ( $sql );
        $insert_id = $db->Insert_ID ();

        $sql = "INSERT INTO " . TABLE_REVIEWS_DESCRIPTION . " (reviews_id, languages_id, reviews_text) VALUES (:insertID, :languagesID, :reviewText)";
        $sql = $db->bindVars ( $sql, ':insertID', $insert_id, 'integer' );
        $sql = $db->bindVars ( $sql, ':languagesID', $_SESSION ['languages_id'], 'integer' );
        $sql = $db->bindVars ( $sql, ':reviewText', $review_text, 'string' );
        $db->Execute ( $sql );
        $email_text = sprintf ( EMAIL_PRODUCT_REVIEW_CONTENT_INTRO, $product_info->fields ['products_name'] ) . "\n\n";
        $email_text .= sprintf ( EMAIL_PRODUCT_REVIEW_CONTENT_DETAILS, $review_text ) . "\n\n";
        $email_subject = sprintf ( EMAIL_REVIEW_PENDING_SUBJECT, $product_info->fields ['products_name'] );
        $html_msg ['EMAIL_SUBJECT'] = sprintf ( EMAIL_REVIEW_PENDING_SUBJECT, $product_info->fields ['products_name'] );
        $html_msg ['EMAIL_MESSAGE_HTML'] = str_replace ( '\n', '', sprintf ( EMAIL_PRODUCT_REVIEW_CONTENT_INTRO, $product_info->fields ['products_name'] ) );
        $html_msg ['EMAIL_MESSAGE_HTML'] .= '<br />';
        $html_msg ['EMAIL_MESSAGE_HTML'] .= $product_info->fields ['products_model'];
        $html_msg ['EMAIL_MESSAGE_HTML'] .= '<br />';
        $html_msg ['EMAIL_MESSAGE_HTML'] .= str_replace ( '\n', '', sprintf ( EMAIL_PRODUCT_REVIEW_CONTENT_DETAILS, $review_text ) );
        zen_mail ( '', NOTIFICATION_EMAIL_ADDRESS_MOBILE, $email_subject, $email_text . $extra_info ['TEXT'], STORE_NAME, NOTIFICATION_EMAIL_ADDRESS, $html_msg, 'reviews_extra', '', 'false', '' );
    }
	zen_redirect ( zen_href_link ( FILENAME_PRODUCT_REVIEWS, 'products_id=' . $_GET ['products_id'] ) );
	
}

$reviews_query_raw = "SELECT r.reviews_id, rd.reviews_text as reviews_text, r.reviews_rating, r.date_added, r.customers_id, r.customers_name, rd.reviews_reply_text
                        FROM " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
                        WHERE r.products_id = :productsID
                        AND r.reviews_id = rd.reviews_id
                        AND r.status = 1
                        ORDER BY r.reviews_id desc";
$reviews_query_raw = $db->bindVars ( $reviews_query_raw, ':productsID', $_GET ['products_id'], 'integer' );
$page_size = MAX_DISPLAY_NEW_REVIEWS;
$page_size = 5;
$reviews_split = new splitPageResults ( $reviews_query_raw, $page_size );
$reviews = $db->Execute ( $reviews_split->sql_query );
$reviewsArray = array ();

$reviews_query = 'select count(r.reviews_id) as count from ' . TABLE_REVIEWS . ' r, ' . TABLE_REVIEWS_DESCRIPTION . ' rd where r.products_id = ' . $_GET ['products_id'] . ' and r.reviews_id = rd.reviews_id and r.status = 1';
$reviews_total_result = $db->Execute ( $reviews_query );
$reviews_count = $reviews_total_result->fields ['count'];

while ( ! $reviews->EOF ) {
	$customer_info = zen_get_customers_info ( $reviews->fields ['customers_id'] );
	$nameArray = explode ( " ", $reviews->fields ['customers_name'] );
	array_pop ( $nameArray );
	$reviews->fields ['customers_name'] = implode ( $nameArray );
	$reviewsArray [] = array (
			'id' => $reviews->fields ['reviews_id'],
			'customersName' => $reviews->fields ['customers_name'],
			'country' => $customer_info ['default_country'],
			'dateAdded' => date ( 'M d , Y', strtotime ( $reviews->fields ['date_added'] ) ),
			'reviewsText' => $reviews->fields ['reviews_text'],
			'reviewsRating' => $reviews->fields ['reviews_rating'],
			'reviews_reply_text' => $reviews->fields ['reviews_reply_text']
	);
	$reviews->MoveNext ();
}
$smarty->assign ( 'reviewsArray', $reviewsArray );
$smarty->assign ( 'reviews_display_count', $reviews_split->display_count ( TEXT_DISPLAY_NUMBER_OF_REVIEWS ) );
$smarty->assign ( 'reviews_display_link', $reviews_split->display_links_mobile ( 3, zen_get_all_get_params ( array ('page', 'info', 'x', 'y', 'main_page' ) ) ) );
$smarty->assign ( 'characters_remaining', sprintf ( TEXT_INFO_CHARACTERS_REMAINING, 1000 ) );
$smarty->assign ( 'product_rating', ceil ( zen_get_product_rating ( $_GET ['products_id'] ) ) );
$smarty->assign ( 'based_on', sprintf(TEXT_INFO_BASED_ON_1, $reviews_count) );
$smarty->assign( 'reviews_count',$reviews_count);

?>