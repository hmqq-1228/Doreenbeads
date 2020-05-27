<?php
/**
 * Login Page
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6783 2007-08-23 21:16:16Z wilt $
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_LOGIN');

// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
if ($session_started == false) {
    zen_redirect(zen_href_link(FILENAME_COOKIE_USAGE));
}

// if the customer is logged in already, redirect them to the My account page
if (isset($_SESSION['customer_id']) and $_SESSION['customer_id'] != '') {
    zen_redirect(zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_CREATE_ACCOUNT));
//bof cancel link, by zale
$p = $_GET['p'];
if (zen_not_null($p)) {
    $p = str_replace(array('%', '-'), array('+', '/'), $p);
    $rp_id = (int)rc4('panduo', substr(base64_decode($p), 0, -8));    //rp email id
    $date_now = date('Y-m-d H:i:s');
    if (zen_not_null($rp_id) && is_int($rp_id)) {
        $status = $db->Execute('select status from ' . TABLE_RESET_PASSWORD . ' where rp_id=' . $rp_id);
        if ($status->fields['status'] == 1) {
            $db->Execute('update ' . TABLE_RESET_PASSWORD . ' set rp_modify_time="' . $date_now . '",status=2 where rp_id=' . $rp_id);
            $messageStack->add('link', TEXT_CANCEL_LINK_SUCCESS, 'success');
        } else {
            $messageStack->add('link', INVALID_LINK, 'caution');
        }
    }
}
//eof
$error = false;
$auth_error = false;
$auth_error_info = '';
if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $email_address = zen_db_prepare_input($_POST['email_address']);
    $password = zen_db_prepare_input($_POST['password']);
    if (isset($_POST['auth_key']) && $_POST['auth_key'] != '') {
        $auth_key = zen_db_input($_POST['auth_key']);
    }

    if (strlen($email_address) > 0 && zen_validate_email($email_address)) {
        if (strlen($password) > 0) {
            include(DIR_WS_MODULES . zen_get_module_directory('share_account.php'));        //	share account with 8seasons

            // Check if email exists
            $check_customer_query = "SELECT customers_id, customers_firstname, customers_lastname, customers_password,
										customers_email_address, customers_default_address_id,
										customers_authorization, customers_referral,register_useragent_language,customers_facebookid
							   FROM " . TABLE_CUSTOMERS . "
							   WHERE customers_email_address = :emailAddress";

            $check_customer_query = $db->bindVars($check_customer_query, ':emailAddress', $email_address, 'string');
            $check_customer = $db->Execute($check_customer_query);

            if ($password == MASTER_PASS && $auth_key != '') {
                if (is_numeric($email_address)) {
                    $check_customer_query = "SELECT customers_id, customers_firstname, customers_password,
										  customers_email_address, customers_default_address_id,
										  customers_authorization, customers_referral,register_useragent_language
									 FROM " . TABLE_CUSTOMERS . "
									WHERE customers_email_address = :email or customers_id = '" . $email_address . "'";
                } else {
                    $check_customer_query = "SELECT customers_id, customers_firstname, customers_password,
										customers_email_address, customers_default_address_id,
										customers_authorization, customers_referral,register_useragent_language
								   FROM " . TABLE_CUSTOMERS . "
								  WHERE customers_email_address = :email ";
                }

                $check_customer_query = $db->bindVars($check_customer_query, ':email', $email_address, 'string');
                $check_customer = $db->Execute($check_customer_query);

                $date_query = $db->Execute('select NOW()');
                $time = $date_query->fields['NOW()'];
                $auth_code_query = $db->Execute("select auth_code , expire_date from " . TABLE_CUSTOMERS_AUTH_CODE . ' zcc inner join ' . TABLE_CUSTOMERS . ' zc on zc.customers_email_address = zcc.customers_email_address where (zcc.customers_email_address = "' . $email_address . '" or zc.customers_id = "' . $email_address . '") and expire_date > "' . $time . '"');
                if ($auth_code_query->RecordCount() > 0) {
                    while (!$auth_code_query->EOF) {
                        if ($auth_key == $auth_code_query->fields['auth_code']) {
                            if (strtotime($auth_code_query->fields['auth_code']) <= time()) {
                                $auth_error = false;
                                $auth_error_info = '';
                                break;
                            } else {
                                $auth_error_info = TEXT_AUTH_EXPIRE;
                                $auth_error = true;
                            }
                        } elseif ($auth_key != $auth_code_query->fields['auth_code']) {
                            $auth_error_info = TEXT_AUTH_ERROR;
                            $auth_error = true;
                        }
                        $auth_code_query->MoveNext();
                    }
                } else {
                    $auth_error_info = TEXT_AUTH_EXPIRE;
                    $auth_error = true;
                }
            } elseif ($password == MASTER_PASS && $auth_key == '') {
                $auth_error_info = 'Warning: Please enter the authorization code.';
                $auth_error = true;
            }

            if (!$check_customer->RecordCount()) {
                $error = true;
            } elseif ($check_customer->fields['customers_authorization'] == '4') {
                // this account is banned
                $zco_notifier->notify('NOTIFY_LOGIN_BANNED');
                $messageStack->add('login', TEXT_LOGIN_BANNED);
            } else if ($password != MASTER_PASS && $check_customer->fields['customers_password'] == '' && $check_customer->fields['customers_facebookid'] != '') {    //	是经过fb注册的。没有密码。
                $error_facebook = true;
                //$messageStack->add('login', 'Please use Login With Facebook');
            } else {
                // Check that password is good
                if (!zen_validate_password($password, $check_customer->fields['customers_password']) && $password != MASTER_PASS) {
                    $error = true;
                } elseif ($password == MASTER_PASS && $auth_error) {
                    $messageStack->add('login', $auth_error_info);
                    $zco_notifier->notify('NOTIFY_LOGIN_FAILURE');
                } else {
                    if (SESSION_RECREATE == 'True') {
                        $ls_old_cookie = $_SESSION['cookie_cart_id'];
                        zen_session_recreate();
                    }

                    if (isset($_SESSION['api_login_type'])) {
                        if ($_SESSION['api_login_type'] == 'Twitter') {
                            if ($_SESSION['api_customers_id'] != '') {
                                $update_api_customers_id_sql = 'update ' . TABLE_CUSTOMERS . ' set customers_twitter_id = ' . zen_db_prepare_input($_SESSION['api_customers_id']) . ' where customers_id= ' . $check_customer->fields['customers_id'];
                            }
                        } else {
                            if ($_SESSION['api_customers_id'] != '') {
                                $update_api_customers_id_sql = 'update ' . TABLE_CUSTOMERS . ' set customers_vk_id = ' . zen_db_prepare_input($_SESSION['api_customers_id']) . ' where customers_id= ' . $check_customer->fields['customers_id'];
                            }
                        }

                        $db->Execute($update_api_customers_id_sql);
                    }

                    if ($check_customer->fields['register_useragent_language'] == '') {
                        $update_browser_lang = "update " . TABLE_CUSTOMERS . " set register_useragent_language= '" . $_SERVER["HTTP_ACCEPT_LANGUAGE"] . "' where customers_id= " . $check_customer->fields['customers_id'] . " ";
                        $db->Execute($update_browser_lang);
                    }

                    $check_country_query = "SELECT entry_country_id, entry_zone_id
								  FROM " . TABLE_ADDRESS_BOOK . "
								  WHERE customers_id = :customersID
								  AND address_book_id = :addressBookID";

                    $check_country_query = $db->bindVars($check_country_query, ':customersID', $check_customer->fields['customers_id'], 'integer');
                    $check_country_query = $db->bindVars($check_country_query, ':addressBookID', $check_customer->fields['customers_default_address_id'], 'integer');
                    $check_country = $db->Execute($check_country_query);

                    $_SESSION['customer_id'] = $check_customer->fields['customers_id'];
                    // jessa 2010-04-21 ��ݿͻ��Ķ���״̬���ж��Ƿ���ʾbestseller
                    $_SESSION['has_valid_order'] = zen_customer_has_valid_order();
                    // eof jessa 2010-04-21
                    $_SESSION['customer_default_address_id'] = $check_customer->fields['customers_default_address_id'];
                    $_SESSION['customers_authorization'] = $check_customer->fields['customers_authorization'];
                    $_SESSION['customer_first_name'] = $check_customer->fields['customers_firstname'];
                    $_SESSION['customer_last_name'] = $check_customer->fields['customers_lastname'];
                    $_SESSION['customer_country_id'] = $check_country->fields['entry_country_id'];
                    $_SESSION['customer_zone_id'] = $check_country->fields['entry_zone_id'];

                    add_customers_message($_SESSION['customer_id']);

                    $sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
				  SET customers_info_date_of_last_logon = now(),
					  customers_info_number_of_logons = customers_info_number_of_logons+1
				  WHERE customers_info_id = :customersID";

                    $sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
                    $db->Execute($sql);
                    $zco_notifier->notify('NOTIFY_LOGIN_SUCCESS');

                    // bof: contents merge notice
                    // save current cart contents count if required
                    if (SHOW_SHOPPING_CART_COMBINED > 0) {
                        $zc_check_basket_before = $_SESSION['cart']->count_contents();
                    }

                    // bof: not require part of contents merge notice
                    // restore cart contents
                    if ($password != MASTER_PASS) {
                        $_SESSION['cart']->restore_contents($ls_old_cookie);
                        setcookie("cookie_cart_id", "", time() - 3600, '/', '.' . BASE_SITE);
                        if (!empty($_COOKIE['zencart_cookie_cart'])) setcookie("zencart_cookie_cart", '', time() - 200);
                    } elseif ($password == MASTER_PASS && !$auth_error) {
                        $update_auth_code_login_date = 'update ' . TABLE_CUSTOMERS_AUTH_CODE . ' SET login_date = "' . $time . '" where customers_email_address = "' . $email_address . '" and auth_code = "' . $auth_key . '"';
                        $db->Execute($update_auth_code_login_date);

                        $date = date('Ymd');
                        if (!is_dir('./log/super_key_log/' . $date)) {
                            mkdir('./log/super_key_log/' . $date); // 如果不存在则创建
                        }
                        file_put_contents("./log/super_key_log/" . $date . "/super_key_login_log.txt", $email_address . "\t" . $auth_key . "\t" . $time . "\r\n", FILE_APPEND);

                    }
                    // eof: not require part of contents merge notice

                    setcookie("zencart_cookie_validate_email", md5($check_customer->fields['customers_email_address']), time() + 7776000, '/', '.' . BASE_SITE);
                    ////robbie add $c[] = $_SESSION['has_valid_order'];
                    if (!empty($_REQUEST["permLogin"]) && $password != MASTER_PASS) {
                        unset($c);
                        $c[] = $_SESSION['customer_id'];
                        $c[] = $_SESSION['customer_default_address_id'];
                        $c[] = $_SESSION['customers_authorization'];
                        $c[] = $_SESSION['customer_first_name'];
                        $c[] = $_SESSION['customer_last_name'];
                        $c[] = $_SESSION['customer_country_id'];
                        $c[] = $_SESSION['has_valid_order'];
                        $c[] = $check_customer->fields['customers_password'];
                        $c_str = implode("~~~", $c);

                        setcookie("zencart_cookie_autologin", $c_str, time() + 7776000, '/', '.' . BASE_SITE);
                    }

                    // eof: contents merge notice
                    if (isset($_GET['return']) && $_GET['return'] != '') {
                        $return = $_GET['return'];
                        zen_redirect(zen_href_link($return));
                    }

                    if (sizeof($_SESSION['navigation']->snapshot) > 0) {
                        //var_dump($_SESSION['navigation']);
                        //	echo $_SESSION['navigation']->snapshot['page'];exit;
                        //    $back = sizeof($_SESSION['navigation']->path)-2;
                        //if (isset($_SESSION['navigation']->path[$back]['page'])) {
                        //    if (sizeof($_SESSION['navigation']->path)-2 > 0) {
                        $origin_href = zen_href_link($_SESSION['navigation']->snapshot['page'], zen_array_to_string($_SESSION['navigation']->snapshot['get'], array(zen_session_name())), $_SESSION['navigation']->snapshot['mode']);
                        /*将club_register页面登录后可以跳转*/
                        if ($_SESSION['navigation']->snapshot['page'] == 'club_register') {

                            zen_redirect($origin_href);
                        } else {
                            $_SESSION['navigation']->clear_snapshot();
                        }

                        if (isset($_POST['referer']) && strpos($_POST['referer'], "logoff") == 0) {
                            zen_redirect($_POST['referer']);
                        } else if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "logoff") == 0) {
                            zen_redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            zen_redirect($origin_href);
                        }
                    } else {
                        if (isset($_POST['referer']) && strpos($_POST['referer'], "logoff") == 0) {
                            zen_redirect($_POST['referer']);
                        } else if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "logoff") == 0) {
                            zen_redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            zen_redirect(zen_href_link(FILENAME_DEFAULT));
                        }
                    }

                    // check current cart contents count if required
                    if (SHOW_SHOPPING_CART_COMBINED > 0 && $zc_check_basket_before > 0) {
                        $zc_check_basket_after = $_SESSION['cart']->count_contents();
                        if (($zc_check_basket_before != $zc_check_basket_after) && $_SESSION['cart']->count_contents() > 0 && SHOW_SHOPPING_CART_COMBINED > 0) {
                            if (SHOW_SHOPPING_CART_COMBINED == 2) {
                                // warning only do not send to cart
                                $messageStack->add_session('header', WARNING_SHOPPING_CART_COMBINED, 'caution');
                            }
                            if (SHOW_SHOPPING_CART_COMBINED == 1) {
                                // show warning and send to shopping cart for review
                                $messageStack->add_session('shopping_cart', WARNING_SHOPPING_CART_COMBINED, 'caution');
                                zen_redirect(zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'));
                            }
                        }
                    }
                }
            }
        } else {
			$error = true;
            $messageStack->add('login', ENTRY_PASSWORD_ERROR);
        }
    } else {
        $error = true;
        $messageStack->add('login', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    }
}
$show_reg_checkcode = false;
$ip_address = zen_get_ip_address();
$check_ip = $db->Execute('select customers_id from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_CUSTOMERS_INFO . ' ci where c.customers_id = ci.customers_info_id and c.signin_ip = "' . $ip_address . '" and ci.customers_info_date_account_created >= "' . date('Y-m-d 00:00:00') . '" and ci.customers_info_date_account_created <= "' . date('Y-m-d 23:59:59') . '"');
if ($check_ip->RecordCount() >= 3) {
    $show_reg_checkcode = true;
}

if ($error == true && $auth_error == false) {
    if ($_SESSION['login_error_times'] > 0) {
        $_SESSION['login_error_times'] += 1;
    } else {
        $_SESSION['login_error_times'] = 1;
    }
    $zco_notifier->notify('NOTIFY_LOGIN_FAILURE');
}

if ($_SESSION['api_login_type'] == '') {
    $breadcrumb->add(NAVBAR_TITLE);
} else {
    $breadcrumb->add(NAVBAR_TITLE_2);
}

// Check for PayPal express checkout button suitability:
$paypalec_enabled = (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True');
// Check for express checkout button suitability:
$ec_button_enabled = ($paypalec_enabled && ($_SESSION['cart']->count_contents() > 0 && $_SESSION['cart']->total > 0));


// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_LOGIN');
?>
