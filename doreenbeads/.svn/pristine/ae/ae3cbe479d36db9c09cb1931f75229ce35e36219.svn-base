<?php
require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/product_info.php');
$customer_query = "SELECT customers_firstname, customers_lastname, customers_email_address FROM " . TABLE_CUSTOMERS . " WHERE customers_id = :customersID";
$customer_query = $db->bindVars ( $customer_query, ':customersID', $_SESSION ['customer_id'], 'integer' );
$customer = $db->Execute ( $customer_query );
$sql = "select p.products_id, pd.products_name, p.products_model, p.products_image from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = 1 and p.products_id = '" . ( int ) $_GET ['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . ( int ) $_SESSION ['languages_id'] . "'";
$product_info = $db->Execute ( $sql );
$p = array();
$p ['id'] = $product_info->fields ['products_id'];
$p ['name'] = $product_info->fields ['products_name'];
$p ['model'] = $product_info->fields ['products_model'];
$p ['image'] = $product_info->fields ['products_image'];

$imgsrc = HTTP_IMG_SERVER. 'bmz_cache/' .  get_img_size($p ['image'],"130","130");
$p ['image_show'] = '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $p ['id']) . '" class="dlist-img" alt="'. $p ['name'].'">' . zen_image($imgsrc, $p ['name'], 120, 100) . '</a>';
$p ['name_show'] = '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $p ['id']) . '" class="dlist-img" alt="'. $p ['name'].'">' . $p ['name'] . '</a>';

$smarty->assign('p', $p);
$c = array();
if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '') {
	$sql = "select customers_firstname,customers_lastname,customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = " . $_SESSION ['customer_id'];
	$customer_info = $db->Execute ( $sql );
	$c ['fname'] = $customer_info->fields ['customers_firstname'];
	$c ['email'] = $customer_info->fields ['customers_email_address'];
	$c ['lname'] = $customer_info->fields ['customers_lastname'];
	$c ['fullname'] = $customers_firstname . " " . $customers_lastname;
}
$smarty->assign('c', $c);
if ($_GET ['action'] == 'process') {
	$customers_firstname = zen_db_prepare_input ( $_POST ['firstinput'] );
	$customers_lastname = zen_db_prepare_input ( $_POST ['lastinput'] );
	$customers_email = zen_db_prepare_input ( $_POST ['emailinput'] );
	$customers_question = zen_db_prepare_input ( $_POST ['MESSAGE'] );
	$question_topic = zen_db_prepare_input ( $_POST ['question_topic'] );
	$customer_name = $customers_firstname . ' ' . $customers_lastname;
	$email_subject = sprintf ( EMAIL_QUESTION_SUBJECT, $question_topic );
	$email_top_description = sprintf ( EMAIL_QUESTION_TOP_DESCRIPTION, $p ['model'] );

	if(zen_validate_url($customers_question)){
        $str_product = '<div style="font-weight:bold;">
    			<div style="float:left;margin:0 25px 25px 0;"><img src="' . $imgsrc . '"></div>
    			<div ><a href="' . zen_href_link('product_info','products_id=' . $p ['id']) . '">' . $p ['name'] . '</a></div><br /><br />
	    		<div>' . TEXT_MODEL . ': ' . $p['model'] . '</div>
    	</div> ';
        // mail send to customer
        $html_msg ['EMAIL_MESSAGE_HTML'] = sprintf ( EMAIL_QUESTION_MESSAGE_HTML, $email_top_description, $customer_name, $customers_question, $str_product );
// 	zen_mail ( $customer_name, $customers_email, $email_subject, '', STORE_NAME, EMAIL_FROM, $html_msg, 'product_question' );
        // mail send to supplies
        $html_msg ['CONTACT_US_OFFICE_FROM'] = "<span style='font-weight:bold;'>" . TEXT_FROM_WORDS . "</span>" . $customer_name . "<br />\n<span style='font-weight:bold;'>Email:</span>" . $customers_email;
        $extra_info = email_collect_extra_info ( $customer_name, $customers_email, $customers_loginname, $customers_email_address );
        $html_msg ['EXTRA_INFO'] = $extra_info ['HTML'];
        $html_msg ['EMAIL_MESSAGE_HTML'] = $customers_question . "<br /><br />\n\n" . $str_product . "\n\n\n<br />";
        $to_sale_email_address = EMAIL_FROM;
        zen_mail ( 'mobilesite-supplises', $to_sale_email_address, $email_subject, '', $customer_name, $customers_email, $html_msg, 'contact_us' );
    }
    zen_redirect(zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $p['id']));

}
$smarty->assign('customers_question', $customers_question);
$smarty->assign('mt_rand', mt_rand());

?>