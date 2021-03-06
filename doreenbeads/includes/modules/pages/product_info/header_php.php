<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
require(DIR_WS_LANGUAGES . 'english/tell_a_friend.php');
require 'includes/extra_configures/times_language.php';

//获取改商品被添加wishlist的次数
$wish_add_num = 0;
if (zen_not_null($_GET['products_id'])) {
    $products_id = intval($_GET['products_id']);
    $add_num_sql = 'select products_id , show_num from ' . TABLE_PRODUCTS_ADD_WISHLIST . ' where products_id = ' . $products_id . ' limit 1';
    $add_num_query = $db->Execute($add_num_sql);

    $products_info = get_products_info_memcache($products_id);

    if(isset($products_info['is_display'])){
        if($products_info['is_display'] == 0 && !(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0)){
            zen_redirect(zen_href_link(FILENAME_DEFAULT));
        }
    }

    if ($add_num_query->RecordCount() != 0) {
        $wish_add_num = $add_num_query->fields['show_num'];
    }
    $_SESSION ['recent_products'] [] = $_GET ['products_id'];
}

if (isset ($_POST ['action']) && $_POST ['action'] == 'write_review' && (isset ($_SESSION ['customer_id']) && $_SESSION ['customer_id'] != '')) {
    $rating = zen_db_prepare_input($_POST ['review_rating']);
    $review_text = substr(zen_db_prepare_input($_POST ['review_text']), 0, 1000);
    $cname = zen_db_prepare_input($_POST ['review_name']);
    $pid = $_GET ['products_id'];

    if (zen_validate_url($review_text)) {
        $sql = "INSERT INTO " . TABLE_REVIEWS . " (products_id, customers_id, customers_name, reviews_rating, date_added, status)
                                VALUES (:productsID, :customersID, :customersName, :rating, now(), 1)";
        $sql = $db->bindVars($sql, ':productsID', $pid, 'string');
        $sql = $db->bindVars($sql, ':customersID', $_SESSION ['customer_id'], 'integer');
        $sql = $db->bindVars($sql, ':customersName', $cname, 'string');
        $sql = $db->bindVars($sql, ':rating', $rating, 'string');
        $db->Execute($sql);
        $insert_id = $db->Insert_ID();
        $sql = "INSERT INTO " . TABLE_REVIEWS_DESCRIPTION . " (reviews_id, languages_id, reviews_text)
                    VALUES (:insertID, :languagesID, :reviewText)";

        $sql = $db->bindVars($sql, ':insertID', $insert_id, 'integer');
        $sql = $db->bindVars($sql, ':languagesID', $_SESSION ['languages_id'], 'integer');
        $sql = $db->bindVars($sql, ':reviewText', $review_text, 'string');
        $db->Execute($sql);
        unset ($_SESSION ['reviews_post_rate']);
        unset ($_SESSION ['reviews_post_name']);
        unset ($_SESSION ['reviews_post_text']);

        // send review-notification email to admin
        if (SEND_EXTRA_REVIEW_NOTIFICATION_EMAILS_TO_STATUS == '1' and defined('SEND_EXTRA_REVIEW_NOTIFICATION_EMAILS_TO') and SEND_EXTRA_REVIEW_NOTIFICATION_EMAILS_TO != '') {
            $customer_query = "SELECT customers_firstname, customers_lastname, customers_email_address
                             FROM " . TABLE_CUSTOMERS . "
                             WHERE customers_id = :customersID";

            $customer_query = $db->bindVars($customer_query, ':customersID', $_SESSION ['customer_id'], 'integer');
            $customer = $db->Execute($customer_query);
            $customers_email_address = $customer->fields ['customers_email_address'];
            $products_query = "select products_model,products_image
                              from " . TABLE_PRODUCTS . "
                             where products_id = " . $_GET ['products_id'];
            $lds_products = $db->Execute($products_query);
            $ls_products_model = $lds_products->fields ['products_model'];

            $email_text = '<p>Review Details: <font style="color:#4444FB;padding-left:12px;">' . $review_text . '</font></p>';
            $email_subject = 'Product Review - ' . $_SESSION['languages_code'];
            $html_msg ['EMAIL_SUBJECT'] = 'Product Review - ' . $_SESSION['languages_code'];
            $td = '<td style="border: 1px solid #D0CFCF;color: #000000;line-height: 18px;padding: 5px 15px;">';

            $html_msg ['EMAIL_MESSAGE_HTML'] = '<table cellspacing="0" cellpadding="0" border="1" style="border-collapse: collapse; border: 1px solid rgb(102, 102, 102);">
                <tr><th style="border: 1px solid #D0CFCF;color: #000000;line-height: 18px;padding: 5px 5px;" align="center" colspan="4">' . TEXT_PRODUCT_REVIEW . '</th></tr>
                <tr>' . $td . '<strong>' . TEXT_MODEL . '</strong>:<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $_GET ['products_id']) . '">' . $ls_products_model . '</a></td></tr>
                <tr>' . $td . '<strong>' . TEXT_EMAIL . ':</strong><a href="mailto:' . $customers_email_address . '">' . $customers_email_address . '</a></td></tr>
                <tr>' . $td . '<strong>' . TEXT_CUSTOMER_NAME . ':</strong>' . $cname . '</td></tr>
                <tr>' . $td . '<strong>' . TEXT_STAR . ':</strong>' . $rating . '</td></tr>
                <tr>' . $td . ' <strong>' . TEXT_REVIEW . ':</strong>' . nl2br($review_text) . '</td></tr>
                </table>';
            //$send_email_array = explode ( ',', SEND_EXTRA_REVIEW_NOTIFICATION_EMAILS_TO );
            $send_email_array = explode(',', SALES_EMAIL_ADDRESS);
            foreach ($send_email_array as $val) {
                $email = trim($val);
                if (zen_not_null($email)) {
                    zen_mail('', $email, $email_subject, $email_text, STORE_NAME, $customers_email_address, $html_msg, 'reviews_extra', '', 'false', '');
                }
            }

        }
    } else {
        $_SESSION['review_tip'] = TEXT_CHECK_URL;
    }

    zen_redirect(zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $_GET ['products_id']) . '#reviewcontent');
}
?>