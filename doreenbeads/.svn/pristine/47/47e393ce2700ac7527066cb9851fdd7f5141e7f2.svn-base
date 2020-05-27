<?php
require ('includes/application_top.php');

$product_id = $_POST ['product_id'];
$page = $_POST ['page']; 

$reviews_html = '';

if (is_numeric($product_id) && $product_id >0)
{
	$reviews_html = get_product_reviews_by_page($product_id, $smarty,$page);
}

echo $reviews_html;

?>