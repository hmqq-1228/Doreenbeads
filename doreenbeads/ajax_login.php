<?php
require('includes/application_top.php');
$action = isset ($_POST ['action']) && $_POST ['action'] != '' ? $_POST ['action'] : '';
$error = false;
switch ($action) {
    case 'is_login':
        $returnArray = array('error' => 1, 'error_info' => "");
        if (!empty($_SESSION['customer_id'])) {
            $returnArray['error'] = 0;
        } else {
            $returnArray['error'] = 1;
            $returnArray['error_info'] = 'logout';
        }
        echo json_encode($returnArray);
        $_SESSION['navigation']->clear_snapshot();
        break;
    case 'check_is_skeleton_key':
        $password = $_POST['password'];
        $is_mobilesite = $_POST['is_mobilesite'];
        $result_array = array('is_master_pass' => 0, 'auth_content' => '');

        if ($password == MASTER_PASS) {
            $result_array['is_master_pass'] = 1;
            if (!$is_mobilesite) {

                $result_array['auth_content'] = '<tr class="auth_tr">
	               	   <td align="right"><strong>Authorization Code:</strong></td>
	                   <td>
	                   <input type="password" name="auth_key" size="18" id="auth_key"> <br><div style="margin:5px 0;"><span class="alert" id="auth_code_error"></span></div>
	                   </td>
               		</tr>';
            } else {
                $result_array['auth_content'] = '<input type="password" placeholder="Authorization Code" id="auth_key" class="signin_input auth_tr" name="auth_key"/><span id="auth_code_error"></span>';
            }
        }
        echo json_encode($result_array);
        break;
    case 'show_auth_code':
        $return_arr = array('is_display' => false, 'show_content' => '');
        if ($_SESSION['auto_auth_code_display']['testimonial'] >= 3) {
            $return_arr['is_display'] = true;
            $return_arr['show_content'] = '<td width="100"><span style="color:#ff0000;margin:0 5px 0 0;position:static;">*</span>' . FOOTER_TESTIMONIAL_VERIFY_NUMBER . ':</td>
          	<td><input type="text" class="ts_input_checkcode" style="width:80px;margin-right:20px;"/><img id="ts_check_code" onClick="this.src=\'./check_code.php?code_suffix=login&\'+Math.random();" style="top: 8px;position: relative;float:none;" /><div class="font_red ts_error"></div></td>
          ';
        }
        echo json_encode($return_arr);
        exit;
        break;
    case 'login' :
        // 判断是否需要验证验证码
        if ($_POST['verify_validate'] == 1) {
            // 获取提交的验证码
            $verify_number = zen_db_prepare_input($_POST['verify_number']);
            // 获取验证码后缀
            $code_suffix = zen_db_prepare_input($_POST['code_suffix']);
            empty($code_suffix) && $code_suffix = 'login';
            // 判断验证码是否正确

            if (empty($verify_number) || $_SESSION['verification_code_' . $code_suffix] != strtolower($verify_number)) {
                // 如果不正确返回错误数据
                echo TEXT_INPUT_RIGHT_CODE;
                die;
            }
        }
        $returnArray = array();
        $email_address = zen_db_prepare_input($_POST ['email']);
        $password = zen_db_prepare_input($_POST ['password']);

        if (strlen($email_address) > 0 && zen_validate_email($email_address)) {
            if (strlen($password) > 0) {
                include(DIR_WS_MODULES . zen_get_module_directory('share_account.php'));        //	share account with 8seasons
                $check_customer_query = "SELECT customers_id, customers_firstname, customers_password,
                                  customers_email_address, customers_default_address_id,
                                  customers_authorization, customers_referral,register_useragent_language,customers_facebookid
                             FROM " . TABLE_CUSTOMERS . "
                            WHERE customers_email_address = :email";

                $check_customer_query = $db->bindVars($check_customer_query, ':email', $email_address, 'string');
                $check_customer = $db->Execute($check_customer_query);
                if (!$check_customer->RecordCount()) {
                    $error = true;
                } elseif ($check_customer->fields ['customers_authorization'] == '4') {
                    $error = true;
                } else if ($password != MASTER_PASS && $check_customer->fields['customers_password'] == '' && $check_customer->fields['customers_facebookid'] != '') {    //	是经过fb注册的。没有密码。
                    echo 'Please use Login With Facebook';
                    exit();
                } else {
                    if (!zen_validate_password($password, $check_customer->fields ['customers_password'])) {
                        $error = true;
                    } else {
                        $ls_old_cookie = $_SESSION ['cookie_cart_id'];
                        if (SESSION_RECREATE == 'True') {
                            zen_session_recreate();
                        }

                        if ($check_customer->fields ['register_useragent_language'] == '') {
                            $update_browser_lang = "update " . TABLE_CUSTOMERS . " set register_useragent_language= '" . $_SERVER ["HTTP_ACCEPT_LANGUAGE"] . "' where customers_id= " . $check_customer->fields ['customers_id'] . " ";
                            $db->Execute($update_browser_lang);
                        }

                        $check_country_query = "SELECT entry_country_id, entry_zone_id
                                FROM " . TABLE_ADDRESS_BOOK . "
                               WHERE customers_id = :customersID
                                 AND address_book_id = :adressBookID";

                        $check_country_query = $db->bindVars($check_country_query, ':customersID', $check_customer->fields ['customers_id'], 'integer');
                        $check_country_query = $db->bindVars($check_country_query, ':adressBookID', $check_customer->fields ['customers_default_address_id'], 'integer');
                        $check_country = $db->Execute($check_country_query);

                        $_SESSION ['customer_id'] = $check_customer->fields ['customers_id'];

                        $_SESSION ['customer_default_address_id'] = $check_customer->fields ['customers_default_address_id'];

                        $_SESSION ['has_valid_order'] = zen_customer_has_valid_order();

                        $_SESSION ['customers_authorization'] = $check_customer->fields ['customers_authorization'];
                        $_SESSION ['customer_first_name'] = $check_customer->fields ['customers_firstname'];
                        $_SESSION ['customer_country_id'] = $check_country->fields ['entry_country_id'];
                        $_SESSION ['customer_zone_id'] = $check_country->fields ['entry_zone_id'];

                        setcookie("zencart_cookie_validate_email", md5($check_customer->fields['customers_email_address']), time() + 7776000, '/', '.' . BASE_SITE);

                        add_customers_message($_SESSION ['customer_id']);

                        $sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
                 SET customers_info_date_of_last_logon = now(),
                     customers_info_number_of_logons = customers_info_number_of_logons+1
               WHERE customers_info_id = :customersID";

                        $sql = $db->bindVars($sql, ':customersID', $_SESSION ['customer_id'], 'integer');
                        $db->Execute($sql);

                        if ($password != MASTER_PASS) {
                            $_SESSION ['cart']->restore_contents($ls_old_cookie);
                            setcookie("cookie_cart_id", "", time() - 3600, '/', '.' . BASE_SITE);
                        }

                        if ($_POST ["permLogin"]) {
                            unset ($c);
                            $c [] = $_SESSION ['customer_id'];
                            $c [] = $_SESSION ['customer_default_address_id'];
                            $c [] = $_SESSION ['customers_authorization'];
                            $c [] = $_SESSION ['customer_first_name'];
                            $c [] = $_SESSION ['customer_last_name'];
                            $c [] = $_SESSION ['customer_country_id'];
                            $c [] = $_SESSION ['has_valid_order'];
                            $c [] = $check_customer->fields ['customers_password'];
                            $c_str = implode("~~~", $c);

                            setcookie("zencart_cookie_autologin", $c_str, time() + 7776000, '/', '.' . BASE_SITE);
                        }
                        //$_SESSION['cart']->calculate();
                        //Tianwen.Wan20160624购物车优化
                        $products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize();
                    }
                }
            } else {
                $error = true;
                $error_info = ENTRY_PASSWORD_ERROR;
            }
        } else {
            $error = true;
            $error_info = ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
        }
        if ($error) {
            if (isset($_SESSION['login_error_times'])) {
                $_SESSION['login_error_times']++;
            } else {
                $_SESSION['login_error_times'] = 1;
            }
            if($error_info == ''){
                $error_info = TEXT_LOGIN_ERROR;
            }
            echo $error_info;
            exit ();
        }
        break;
    // 注册处理逻辑
    case 'create' :
        require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/mail_welcome.php');
        require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/create_account.php');
        //include_once (DIR_WS_CLASSES . 'MCAPI.class.php');
        //include_once (DIR_WS_CLASSES . 'config.inc');

        /**
         * 验证码
         * @author yifei.wang
         */
        if (isset($_POST['verify_number'])) {
            // 获取提交的验证码
            $verify_number = zen_db_prepare_input($_POST['verify_number']);
            // 判断验证码是否正确
            if (empty($verify_number) || $_SESSION['verification_code_register'] != strtolower($verify_number)) {
                // 如果不正确返回错误数据
                echo TEXT_INPUT_RIGHT_CODE;
                die;
            }
        }

        $process = false;
        $zone_name = '';
        $entry_state_has_zones = '';
        $error_state_input = false;
        $state = '';
        $zone_id = 0;
        $error = false;
        $email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
        $newsletter = (ACCOUNT_NEWSLETTER_STATUS != '1' && $_POST ['subscribe'] ? true : false);
        $returnArray = array();
        $index_register = false;

        $firstname = zen_db_prepare_input($_POST ['firstname']);
        $lastname = zen_db_prepare_input($_POST ['lastname']);
        $email_address = zen_db_prepare_input($_POST ['email_address']);
        $country = zen_db_prepare_input($_POST ['zone_country_id']);
        $password = zen_db_prepare_input($_POST ['password']);
        $confirmation = zen_db_prepare_input($_POST ['confirmation']);
        $twitter_customers_id = '';
        $vk_customers_id = '';

        if (isset($_SESSION['api_login_type'])) {
            if ($_SESSION['api_login_type'] == 'Twitter') {
                $register_entry = 7;
                $twitter_customers_id = $_SESSION['api_customers_id'];
            } else {
                $register_entry = 6;
                $vk_customers_id = $_SESSION['api_customers_id'];
            }
        } else {
            $register_entry = (int)$_POST['register_entry'];
        }
        if (isset($_POST['no_password_confirm']) && $_POST['no_password_confirm'] == 1) {
            $confirmation = $password;
        }
        $is_return_array = zen_db_prepare_input($_POST ['is_return_array']) == 1 ? true : false;
        $is_return_success_page = zen_db_prepare_input($_POST ['is_return_success_page']) == 1 ? true : false;

        $ip_address = zen_get_ip_address();

        $check_mailchimp_email_query = $db->Execute("SELECT * FROM " . TABLE_CUSTOMERS_FOR_MAILCHIMP . " WHERE customers_for_mailchimp_email = '" . $email_address . "' LIMIT 1");
        if (isset($_POST ['no_subscribe']) && $_POST ['no_subscribe'] == 1) {
            $index_register = true;
            $newsletter = (int)$_POST['newsletter_general'];
            if ($check_mailchimp_email_query->RecordCount() > 0) {
                if ($check_mailchimp_email_query->fields['subscribe_status'] == 10) {
                    $newsletter = 1;
                }
            }
        }
        if (!isset($firstname) || !empty($firstname)) {
            $firstname = strstr($email_address, '@', true);
        }

        $check_email_query = "select count(*) as total
                            from " . TABLE_CUSTOMERS . "
                            where customers_email_address = '" . zen_db_input($email_address) . "'";
        $check_email_query = "select customers_id,customers_password,customers_facebookid 
                            from " . TABLE_CUSTOMERS . "
                            where customers_email_address = '" . zen_db_input($email_address) . "'";
        $check_email = $db->Execute($check_email_query);

        //if ($check_email->fields ['total'] > 0) {
        if ($check_email->RecordCount() > 0) {
            if ($check_email->fields['customers_facebookid'] != '') {
                $error = true;
                if ($is_return_array) {
                    $returnArray['error_info']['reg_email_error'] = 'This email is taken. Please use Login With Facebook';
                } else {
                    echo 'This email is taken. Please use Login With Facebook';
                    die();
                }
            } else {
                $error = true;
                if ($is_return_array) {
                    $returnArray['error_info']['reg_email_error'] = ENTRY_EMAIL_ADDRESS_ERROR_EXISTS_MOBILE;
                } else {
                    echo ENTRY_EMAIL_ADDRESS_ERROR_EXISTS;
                    die();
                }
            }

            if ($error && !empty($returnArray)) {
                echo json_encode($returnArray);
                die;
            }
        }

        $currency_preference = isset ($_SESSION ['currency']) ? $_SESSION ['currency'] : 'USD';
        $get_currency_sql = "select currencies_id from " . TABLE_CURRENCIES . " where code='" . $currency_preference . "'";
        $get_currency_id = $db->Execute($get_currency_sql);
        $currency_id = $get_currency_id->fields ['currencies_id'];

        $sql_data_array = array(
            'customers_firstname' => $firstname,
            'customers_lastname' => $lastname,
            'customers_email_address' => $email_address,
            'customers_newsletter' => ( int )$newsletter,
            'customers_email_format' => $email_format,
            'customers_default_address_id' => 0,
            'customers_twitter_id' => $twitter_customers_id,
            'customers_vk_id' => $vk_customers_id,
            'customers_password' => zen_encrypt_password($password),
            'customers_authorization' => ( int )CUSTOMERS_APPROVAL_AUTHORIZATION,
            'signin_ip' => $ip_address,
            'register_languages_id' => ($_SESSION['languages_id'] ? $_SESSION['languages_id'] : 1),
            'lang_preference' => ($_SESSION['languages_id'] ? $_SESSION['languages_id'] : 1),
            'register_useragent_language' => $_SERVER ['HTTP_ACCEPT_LANGUAGE'],
            'customers_country_id' => $country,
            'currencies_preference' => $currency_id,
            'register_entry' => $register_entry
        );

        if ((CUSTOMERS_REFERRAL_STATUS == '2' and $customers_referral != '')) {
            $sql_data_array ['customers_referral'] = $customers_referral;
        }

        if ($fun_inviteFriends->hasRefer()) {
            $sql_data_array['referrer_id'] = intval($fun_inviteFriends->getRefer());
        }

        $sql_data_array1 = array(
            'customers_gender' => 'm',
            'customers_dob' => '0001-01-01 00:00:00',
            'customers_nick' => '',
            'customers_telephone' => '',
            'customers_cell_phone' => '',
            'customers_fax' => '',
            'customers_group_pricing' => 0,
            'customers_referral' => '',
            'customers_paypal_payerid' => '',
            'customers_paypal_ec' => ''
        );
        $sql_data_array = array_merge($sql_data_array, $sql_data_array1);
        zen_db_perform(TABLE_CUSTOMERS, $sql_data_array);
        $_SESSION ['customer_id'] = $db->Insert_ID();

        $sql = "insert into " . TABLE_CUSTOMERS_INFO . "
                          (customers_info_id, customers_info_number_of_logons,
                           customers_info_date_account_created)
              values ('" . ( int )$_SESSION ['customer_id'] . "', '0', now())";

        $db->Execute($sql);

        write_file("log/customers_log/", "customers_firstname_" . date("Ym") . ".txt", "customers_id: " . $_SESSION ['customer_id'] . "\n customers_email_address: " . $email_address . "\n firstname: " . $firstname . "\n lastname: " . $lastname . "\n ip: " . zen_get_ip_address() . "\n WEBSITE_CODE: " . WEBSITE_CODE . "\n create_time: " . date("Y-m-d H:i:s") . "\n entrance: " . __FILE__ . " on line " . __LINE__ . "\n json_data: " . json_encode($sql_data_array) . "\n===========================================================\n\n\n");

        if (WEBSITE_CODE == 40) {
            $db->Execute("update " . TABLE_CUSTOMERS . " set from_mobile=1 where customers_id='" . (int)$_SESSION['customer_id'] . "'");
        }

        //create account success  send register coupon WSL
        add_coupon_code(REGISTER_COUPON_CODE, false);

        $_SESSION ['customer_first_name'] = $firstname;
        $_SESSION ['customer_default_address_id'] = '';
        $_SESSION ['customer_country_id'] = $country;
        $_SESSION ['customer_zone_id'] = $zone_id;
        $_SESSION ['customers_authorization'] = $customers_authorization;

        setcookie("zencart_cookie_validate_email", md5($email_address), time() + 7776000, '/', '.' . BASE_SITE);

        $ls_old_cookie = $_SESSION ['cookie_cart_id'];
        if (SESSION_RECREATE == 'True') {
            zen_session_recreate();
        }
        if ($password != MASTER_PASS) {
            $_SESSION ['cart']->restore_contents($ls_old_cookie);
            setcookie("cookie_cart_id", "", time() - 3600, '/', '.' . BASE_SITE);
        }

        $zco_notifier->notify('NOTIFY_LOGIN_SUCCESS_VIA_CREATE_ACCOUNT');

        // build the message content
        $name = $firstname . ' ' . $lastname;

        /* if (ACCOUNT_GENDER == 'true') {
            if ($gender == 'm') {
                $email_text = sprintf ( EMAIL_GREET_MR, $lastname );
            } else {
                $email_text = sprintf ( EMAIL_GREET_MS, $lastname );
            }
        } else {
            $email_text = sprintf ( EMAIL_GREET_NONE, $firstname );
        } */
        $email_text = sprintf(TEXT_DEAR_FN, $firstname) . ",\n\n";
        $html_msg ['EMAIL_GREETING'] = str_replace('\n', '', $email_text);
        $html_msg ['EMAIL_FIRST_NAME'] = $firstname;
        $html_msg ['EMAIL_LAST_NAME'] = $lastname;

        // initial welcome
        $email_text .= EMAIL_WELCOME;
        $html_msg ['EMAIL_WELCOME'] = str_replace('\n', '', EMAIL_WELCOME);

        $email_text .= EMAIL_CUSTOMER_EMAILADDRESS . $email_address;
        $html_msg ['EMAIL_CUSTOMER_EMAILADDRESS'] = EMAIL_SEPARATOR . '<br />' . EMAIL_CUSTOMER_EMAILADDRESS . $email_address;
        $email_text .= EMAIL_CUSTOMER_PASSWORD . $password;
        $html_msg ['EMAIL_CUSTOMER_PASSWORD'] = EMAIL_CUSTOMER_PASSWORD . $password . '<br />' . EMAIL_SEPARATOR;

        $email_text .= EMAIL_KINDLY_NOTE;
        $html_msg ['EMAIL_KINDLY_NOTE'] = str_replace('\n', '', EMAIL_KINDLY_NOTE);
        $email_text .= EMAIL_CUSTOMER_REG_DESCRIPTION;
        $html_msg ['EMAIL_CUSTOMER_REG_DESCRIPTION'] = EMAIL_CUSTOMER_REG_DESCRIPTION;

        if (NEW_SIGNUP_DISCOUNT_COUPON != '' and NEW_SIGNUP_DISCOUNT_COUPON != '0') {
            $coupon_id = NEW_SIGNUP_DISCOUNT_COUPON;
            $coupon = $db->Execute("select * from " . TABLE_COUPONS . " where coupon_id = '" . $coupon_id . "'");
            $coupon_desc = $db->Execute("select coupon_description from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $coupon_id . "' and language_id = '" . $_SESSION ['languages_id'] . "'");
            $db->Execute("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $coupon_id . "', '0', 'Admin', '" . $email_address . "', now() )");

            $text_coupon_help = sprintf(TEXT_COUPON_HELP_DATE, zen_date_short($coupon->fields ['coupon_start_date']), zen_date_short($coupon->fields ['coupon_expire_date']));

            $email_text .= "\n" . EMAIL_COUPON_INCENTIVE_HEADER . (!empty ($coupon_desc->fields ['coupon_description']) ? $coupon_desc->fields ['coupon_description'] . "\n\n" : '') . $text_coupon_help . "\n\n" . strip_tags(sprintf(EMAIL_COUPON_REDEEM, ' ' . $coupon->fields ['coupon_code'])) . EMAIL_SEPARATOR;

            $html_msg ['COUPON_TEXT_VOUCHER_IS'] = EMAIL_COUPON_INCENTIVE_HEADER;
            $html_msg ['COUPON_DESCRIPTION'] = (!empty ($coupon_desc->fields ['coupon_description']) ? '<strong>' . $coupon_desc->fields ['coupon_description'] . '</strong>' : '');
            $html_msg ['COUPON_TEXT_TO_REDEEM'] = str_replace("\n", '', sprintf(EMAIL_COUPON_REDEEM, ''));
            $html_msg ['COUPON_CODE'] = $coupon->fields ['coupon_code'] . $text_coupon_help;
        } // endif coupon

        if (NEW_SIGNUP_GIFT_VOUCHER_AMOUNT > 0) {
            $coupon_code = zen_create_coupon_code();
            $insert_query = $db->Execute("insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $coupon_code . "', 'G', '" . NEW_SIGNUP_GIFT_VOUCHER_AMOUNT . "', now())");
            $insert_id = $db->Insert_ID();
            $db->Execute("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id . "', '0', 'Admin', '" . $email_address . "', now() )");
            $email_text .= "\n\n" . sprintf(EMAIL_GV_INCENTIVE_HEADER, $currencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)) . sprintf(EMAIL_GV_REDEEM, $coupon_code) . EMAIL_GV_LINK . zen_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code, 'NONSSL', false) . "\n\n" . EMAIL_GV_LINK_OTHER . EMAIL_SEPARATOR;
            $html_msg ['GV_WORTH'] = str_replace('\n', '', sprintf(EMAIL_GV_INCENTIVE_HEADER, $currencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)));
            $html_msg ['GV_REDEEM'] = str_replace('\n', '', str_replace('\n\n', '<br />', sprintf(EMAIL_GV_REDEEM, '<strong>' . $coupon_code . '</strong>')));
            $html_msg ['GV_CODE_NUM'] = $coupon_code;
            $html_msg ['GV_CODE_URL'] = str_replace('\n', '', EMAIL_GV_LINK . '<a href="' . zen_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code, 'NONSSL', false) . '">' . TEXT_GV_NAME . ': ' . $coupon_code . '</a>');
            $html_msg ['GV_LINK_OTHER'] = EMAIL_GV_LINK_OTHER;
        } // endif voucher

        // add in regular email welcome text
        $email_text .= "\n\n" . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_GV_CLOSURE;

        $html_msg ['EMAIL_MESSAGE_HTML'] = str_replace('\n', '', EMAIL_TEXT);
        $html_msg ['EMAIL_CONTACT_OWNER'] = str_replace('\n', '', EMAIL_CONTACT);

        $html_msg ['EMAIL_CLOSURE'] = nl2br(EMAIL_GV_CLOSURE);

        $html_msg['TEXT_EMAIL_NEWSLETTER'] = TEXT_EMAIL_NEWSLETTER;
        $email_order .= TEXT_EMAIL_NEWSLETTER;

        // include create-account-specific disclaimer
        $email_text .= "\n\n" . sprintf(EMAIL_DISCLAIMER_NEW_CUSTOMER, STORE_OWNER_EMAIL_ADDRESS) . "\n\n";
        $html_msg ['EMAIL_DISCLAIMER'] = sprintf(EMAIL_DISCLAIMER_NEW_CUSTOMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">' . STORE_OWNER_EMAIL_ADDRESS . ' </a>');

        // send welcome email
        zen_mail($name, $email_address, EMAIL_SUBJECT, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'welcome');

        $db->Execute('INSERT INTO ' . TABLE_CHECK_EMAIL_RESULT . ' (`email_address`, `create_date`) VALUES ("' . $email_address . '", "' . date('Y-m-d H:i:s') . '")');

        // send additional emails
        if (SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_STATUS == '1' and SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO != '') {
            if ($_SESSION ['customer_id']) {
                $account_query = "select customers_firstname, customers_lastname, customers_email_address, customers_telephone, customers_fax
                            from " . TABLE_CUSTOMERS . "
                            where customers_id = '" . ( int )$_SESSION ['customer_id'] . "'";

                $account = $db->Execute($account_query);
            }

            $extra_info = email_collect_extra_info($name, $email_address, $account->fields ['customers_firstname'] . ' ' . $account->fields ['customers_lastname'], $account->fields ['customers_email_address'], $account->fields ['customers_telephone'], $account->fields ['customers_fax']);
            $html_msg ['EXTRA_INFO'] = $extra_info ['HTML'];
            zen_mail('', SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO, SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT . ' ' . EMAIL_SUBJECT, $email_text . $extra_info ['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'welcome_extra');
        } // endif send extra emails
        /*$subscribe = true;
        if(stristr($email_address,'163.com') || stristr($email_address,'126.com')
                        || stristr($email_address,'qq.com')
                        || stristr($email_address,'sina.com.cn')
                        || stristr($email_address,'sina.cn')
                        || stristr($email_address,'139.com')
                        || stristr($email_address,'souhu.com')
                        || stristr($email_address,'tom.com')){
                        $subscribe = false;
        }*/
        $db->Execute("INSERT INTO  " . TABLE_CUSTOMERS_SUBSCRIBE . " (`subscribe_email` ,`subscribe_date_add` ,`subscribe_type`,`languages_id`)VALUES ('" . $email_address . "',  now(),  '2'," . $_SESSION['languages_id'] . ")");

        $subscribe_param = array(
            'firstname' => $firstname,
            'lastname' => $lastname
        );

        if (!$index_register) {
            /* if ($newsletter) {
                $event_type = 10;
                $res = customers_for_mailchimp_subscribe_event($email_address, $event_type, 30, $subscribe_param );
            }else{
                $event_type = 20;
                $check_mailchimp_email_query = $db->Execute("SELECT * FROM ". TABLE_CUSTOMERS_FOR_MAILCHIMP. " WHERE customers_for_mailchimp_email = '" . $email_address . "'");
                if ($check_mailchimp_email_query->RecordCount() > 0) {
                  $res = customers_for_mailchimp_subscribe_event($email_address, $event_type, 30, $subscribe_param );
                }
            } */
        }

        if ($newsletter == 1) {
            //$db->Execute("INSERT INTO  ".TABLE_CUSTOMERS_SUBSCRIBE." (`subscribe_email` ,`subscribe_date_add` ,`subscribe_type`,`languages_id`)VALUES ('".$email_address."',  now(),  '5',".$_SESSION['languages_id'].");");
            $event_type = 10;
            $res = customers_for_mailchimp_subscribe_event($email_address, $event_type, 40, $subscribe_param);
        } else {
            $event_type = 20;
            if ($check_mailchimp_email_query->RecordCount() > 0) {
                $res = customers_for_mailchimp_subscribe_event($email_address, $event_type, 40, $subscribe_param);
            }
        }

        /*if ($newsletter && $subscribe) {
            if (isset ( $_POST ['action'] ) && ($_POST ['action'] == 'create')) {
                $api = new MCAPI ( $apikey );
                if ($api->errorCode != '') {
                    // an error occurred while logging in
                    //echo "code:" . $api->errorCode . "\n";
                    //echo "msg :" . $api->errorMessage . "\n";
                    //die ();
                }
                $optin = false; // yes, send optin emails
                $up_exist = true; // yes, update currently subscribed users
                $replace_int = true; // no, add interest, don't replace
                $vals = $api->listInterestGroupings ( $listId );
                $lan = $_SESSION ["languages_id"] - 1;
                $groups = $vals [$lan] ["groups"];
                //var_dump ( $groups );
                $groupings = $api->listInterestGroupings ( $listId );
                //var_dump ( $groupings );
                $grouping_id = $groupings [$lan] ['id']; // exit;
                                                         // echo $grouping_id ;
                $grouplength = sizeof ( $groups );
                $currentgroup = $groups [$grouplength - 1];
                // var_dump($currentgroup);exit;
                // Adding group if the last group subscriber exceeds 3000
                if ($currentgroup ['subscribers'] >= $grouplimit) {
                    $partno = $grouplength + 1;
                    $group_name = 'Part-' . $_SESSION ['languages_code'] . '-' . $partno;
                }
                $partno = $grouplength;
                $group = array (
                        array (
                                'id' => $grouping_id,
                                'groups' => 'Part-' . $_SESSION ['languages_code'] . '-1'
                        )
                );
                $batch [0] = array (
                        'EMAIL' => $email_address,
                        'FNAME' => $firstname,
                         'LNAME' => $lastname,
                        'GROUPINGS' => $group
                );
                $vals = $api->listBatchSubscribe ( $listId, $batch, $optin, $up_exist, $replace_int );
                if ($api->errorCode) {
                    //echo "Batch Subscribe failed!\n";
                    //echo "code:" . $api->errorCode . "\n";
                    //echo "msg :" . $api->errorMessage . "\n";
                    //die ();
                }
            }
        }*/

        if ($is_return_array) {
            if (sizeof($_SESSION['navigation']->snapshot) > 0) {
                $returnArray['success_info']['register_success_href'] = zen_href_link($_SESSION['navigation']->snapshot['page'], zen_array_to_string($_SESSION['navigation']->snapshot['get'], array(zen_session_name())), $_SESSION['navigation']->snapshot['mode']);
                $_SESSION['navigation']->clear_snapshot();
            } else {
                if ($is_return_success_page) {
                    $returnArray['success_info']['register_success_href'] = zen_href_link(FILENAME_REGISTER_SUCCESSFULLY);
                } else {
                    $returnArray['success_info']['register_success_href'] = '';
                }
            }

            echo json_encode($returnArray);
        }

        break;
    case 'subscribe' :
        //include_once (DIR_WS_CLASSES . 'MCAPI.class.php');
        //include_once (DIR_WS_CLASSES . 'config.inc');
        $email_address = zen_db_prepare_input($_POST ['email_address']);
        $firstname = zen_db_prepare_input($_POST ['firstname']);
        $lastname = '';
        //$subscribe = true;

        if ($first_name == '') {
            $first_name = substr($email_address, 0, strrpos($email_address, '@'));
        }

        //  判断用户是否已经注册
        $check_mailchimp_exist_query = $db->Execute("SELECT * FROM " . TABLE_CUSTOMERS_FOR_MAILCHIMP . " WHERE customers_for_mailchimp_email = '" . $email_address . "' AND subscribe_status = 10 LIMIT 1");
        if ($check_mailchimp_exist_query->RecordCount() > 0) {
            $response['error'] = true;
            $response['error_message'] = TEXT_EMAIL_HAS_SUBSCRIBED;
        } else {
            $response = customers_for_mailchimp_subscribe_event($email_address, 10, 10, array('firstname' => $first_name, 'lastname' => $last_name));
        }
        echo json_encode($response);
        /*if(stristr($email_address,'163.com') || stristr($email_address,'126.com')
                        || stristr($email_address,'qq.com')
                        || stristr($email_address,'sina.com.cn')
                        || stristr($email_address,'sina.cn')
                        || stristr($email_address,'139.com')
                        || stristr($email_address,'souhu.com')
                        || stristr($email_address,'tom.com')){
                        $subscribe = false;
        }*/
        /*if($subscribe){
            $api = new MCAPI ( $apikey );
            if ($api->errorCode != '') {
                // an error occurred while logging in
                echo "code:" . $api->errorCode . "\n";
                echo "msg :" . $api->errorMessage . "\n";
                die ();
            }
            $optin = false; // yes, send optin emails
            $up_exist = true; // yes, update currently subscribed users
            $replace_int = true; // no, add interest, don't replace
            $vals = $api->listInterestGroupings ( $listId );
            $lan = $_SESSION ["languages_id"] - 1;
            $groups = $vals [$lan] ["groups"];
            var_dump ( $groups );
            $groupings = $api->listInterestGroupings ( $listId );
            var_dump ( $groupings );
            $grouping_id = $groupings [$lan] ['id']; // exit;
            // echo $grouping_id ;
            $grouplength = sizeof ( $groups );
            $currentgroup = $groups [$grouplength - 1];
            // var_dump($currentgroup);exit;
            // Adding group if the last group subscriber exceeds 3000
            if ($currentgroup ['subscribers'] >= $grouplimit) {
                $partno = $grouplength + 1;
                $group_name = 'Part-' . $_SESSION ['languages_code'] . '-' . $partno;
            }
            $partno = $grouplength;
            $group = array (
                    array (
                            'id' => $grouping_id,
                            'groups' => 'Part-' . $_SESSION ['languages_code'] . '-1'
                    )
            );
            $batch [0] = array (
                    'EMAIL' => $email_address,
                    'FNAME' => $firstname,
                    'LNAME' => $lastname,
                    'GROUPINGS' => $group
            );
            $vals = $api->listBatchSubscribe ( $listId, $batch, $optin, $up_exist, $replace_int );
            if ($api->errorCode) {
                echo "Batch Subscribe failed!\n";
                echo "code:" . $api->errorCode . "\n";
                echo "msg :" . $api->errorMessage . "\n";
                die ();
            }
        }*/
        break;
    case 'getinfo' :
        if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') {
            $customer_info = zen_get_customer_info($_SESSION['customer_id']);
            echo $customer_info['name'] . '||' . $customer_info['email'];
        } else {
            echo '';
        }
        break;
    case 'testimonial' :
        //$testimonial_content = htmlspecialchars(stripslashes(strip_tags(zen_db_prepare_input($_POST['content']))));
        $testimonial_content = stripslashes(zen_db_prepare_input($_POST['content']));
        if (zen_not_null($testimonial_content) && isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') {
            if (zen_validate_url($testimonial_content)) {
                require('includes/languages/' . $_SESSION['language'] . '/testimonial.php');
                $customer_info = zen_get_customer_info($_SESSION['customer_id']);
                $customer_name = $customer_info['name'];
                $customer_email = $customer_info['email'];
                $date = date('Ymd');
                $testimonial_array = array(
                    'tm_content' => $testimonial_content,
                    'tm_customer_id' => $_SESSION['customer_id'],
                    'tm_customer_email' => $customer_email,
                    'tm_customer_name' => $customer_name,
                    'tm_status' => '1',
                    'tm_date_added' => $date,
                    'language_id' => $_SESSION['languages_id']
                );
                zen_db_perform(TABLE_TESTIMONIAL, $testimonial_array);
                //$db->Execute("Insert Into " . TABLE_TESTIMONIAL . " (tm_content, tm_customer_id, tm_customer_email, tm_customer_name, tm_status, tm_date_added, language_id) Values ('" . $testimonial_content . "', " . $_SESSION['customer_id'] . ", '" . $customer_email . "', '" . $customer_name . "', 1, " . $date . ", " . $_SESSION['languages_id'] . ")");

                $email_text = sprintf(EMAIL_TESTIMONIAL_CONTENT_DETAILS, $testimonial_content) . "\n\n";
                $email_subject = 'Customer Testimonial - ' . $_SESSION['languages_code'];
                $html_msg ['EMAIL_SUBJECT'] = 'Customer Testimonial - ' . $_SESSION['languages_code'];
//			$html_msg ['EMAIL_MESSAGE_HTML'] = sprintf ( EMAIL_TESTIMONIAL_CUSTOMER_NAME, $customer_name ) . '<br/>' . sprintf ( EMAIL_TESTIMONIAL_CUSTOMER_EMAIL, $customer_email ) . '<br />Date Added: ' . date ( "m/d/Y" ) . '<br />' . sprintf ( EMAIL_TESTIMONIAL_COMMENT, $testimonial_content ) . "<br/>";
                $td = '<td style="border: 1px solid #D0CFCF;color: #000000;line-height: 18px;padding: 5px 5px;">';
                $html_msg ['EMAIL_MESSAGE_HTML'] = '<table cellspacing="0" cellpadding="0" border="1" style="border-collapse: collapse; border: 1px solid rgb(102, 102, 102);">
				<tr><th style="border: 1px solid #D0CFCF;color: #000000;line-height: 18px;padding: 5px 5px;" align="center" colspan="4">Customer Testimonial</th></tr>
				<tr>' . $td . '<strong>Customer Name:</strong>' . $customer_name . '</td></tr>
				<tr>' . $td . '<strong>Email:</strong><a href="mailto:' . $customer_email . '">' . $customer_email . '</a></td></tr>
				<tr>' . $td . '<strong>Testimonial:</strong>' . nl2br($testimonial_content) . '</td></tr>
				</table>';
                $extra_info = email_collect_extra_info(STORE_NAME, EMAIL_FROM, $customer_name, $customer_email);
                $html_msg ['EXTRA_INFO'] = $extra_info ['HTML'];
                //zen_mail ( '', SEND_EXTRA_TESTIMONIAL_NOTIFICATION_EMAILS_TO, $email_subject, $email_text . $extra_info ['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'testimonial_extra', '','false',TESTIMONIAL_CC_ADDRESS );
                zen_mail('', SALES_EMAIL_ADDRESS, $email_subject, $email_text . $extra_info ['TEXT'], $customer_name, $customer_email, $html_msg, 'testimonial_extra', '', 'false', '');

                if ($_SESSION['auto_auth_code_display']['testimonial'] > 0) {
                    $_SESSION['auto_auth_code_display']['testimonial'] += 1;
                } else {
                    $_SESSION['auto_auth_code_display']['testimonial'] = 1;
                }
            } else {
                echo 'fail';
            }
        } else {
            echo 'fail';
        }
        break;
    case 'reviews':
        $rating = zen_db_prepare_input($_POST['starval']);
        $review_text = substr(zen_db_prepare_input($_POST['reviewtext']), 0, 1000);
        $cname = zen_db_prepare_input($_POST['name']);
        if ($cname == '') {
            $customer_info = zen_get_customer_info($_SESSION['customer_id']);
            $cname = $customer_info['name'];
        }
        $pid = zen_db_prepare_input($_POST['pid']);
        $sql = "INSERT INTO " . TABLE_REVIEWS . " (products_id, customers_id, customers_name, reviews_rating, date_added, status)
	            			VALUES (:productsID, :customersID, :customersName, :rating, now(), 1)";
        $sql = $db->bindVars($sql, ':productsID', $pid, 'string');
        $sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
        $sql = $db->bindVars($sql, ':customersName', $cname, 'string');
        $sql = $db->bindVars($sql, ':rating', $rating, 'string');
        $db->Execute($sql);
        $insert_id = $db->Insert_ID();
        $sql = "INSERT INTO " . TABLE_REVIEWS_DESCRIPTION . " (reviews_id, languages_id, reviews_text)
	            VALUES (:insertID, :languagesID, :reviewText)";

        $sql = $db->bindVars($sql, ':insertID', $insert_id, 'integer');
        $sql = $db->bindVars($sql, ':languagesID', $_SESSION['languages_id'], 'integer');
        $sql = $db->bindVars($sql, ':reviewText', $review_text, 'string');
        $db->Execute($sql);
        break;
    case 'addsingletowishlist':
        $product_id = zen_db_prepare_input($_POST['pid']);
        $wishlist_check = $db->Execute('select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . $product_id . ' and wl_customers_id = ' . $_SESSION ['customer_id']);
        if ($wishlist_check->RecordCount() == 0) {
            $sql = 'insert into ' . TABLE_WISH . ' (wl_products_id, wl_customers_id, wl_date_added) values (' . $product_id . ', ' . $_SESSION ["customer_id"] . ', "' . date('y-m-d H:i:s') . '")';
            $db->Execute($sql);
            update_products_add_wishlist(intval($product_id));
        }
        break;
    case 'addalltowishlist':
        //$products = $_SESSION ['cart']->get_products ( false );
        //Tianwen.Wan20160624购物车优化
        $products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize();
        $products = $products_array['data'];
        if (zen_not_null($products)) {
            $sql = '';
            for ($i = 0; $i < sizeof($products); $i++) {
                $wishlist_check = $db->Execute('select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . $products[$i]['id'] . ' and wl_customers_id = ' . $_SESSION ['customer_id']);
                if ($wishlist_check->RecordCount() == 0) {
                    $sql .= '(' . $products[$i]['id'] . ', ' . $_SESSION ["customer_id"] . ', "' . date('y-m-d H:i:s') . '"), ';
                    update_products_add_wishlist(intval($products[$i]['id']));
                }
            }
            if ($sql != '') {
                $sql = 'insert into ' . TABLE_WISH . ' (wl_products_id, wl_customers_id, wl_date_added) values ' . substr($sql, 0, -2);
                $db->Execute($sql);
            }
        }
        break;

    /*
    * v1.50 lvxiaoyong
    */
    case 'removewishlist':
        $product_id = zen_db_prepare_input($_POST['pid']);
        $wishlist_sql = 'select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . (int)$product_id . ' and wl_customers_id = ' . (int)$_SESSION['customer_id'] . ' limit 1';
        $wishlist_query = $db->Execute($wishlist_sql);
        if ($wishlist_query->RecordCount() > 0) {
            $db->Execute("delete from " . TABLE_WISH . " where wl_products_id = " . (int)$product_id . " and wl_customers_id = " . (int)$_SESSION['customer_id']);
            update_products_add_wishlist(intval($product_id), 'remove');
        }
        break;

    case 'customer_question':
        $question = zen_db_prepare_input($_POST['customer_question']);
        $return_arr = array('is_error' => false, 'error_info' => '', 'add_auth_code' => false, 'add_content' => '');

        if (zen_not_null($question) && isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != '') {
            if (zen_validate_url($question)) {
                if (file_exists($language_page_directory . $template_dir . '/customer_service.php')) {
                    require($language_page_directory . $template_dir . '/customer_service.php');
                } else if (file_exists($language_page_directory . 'customer_service.php')) {
                    require($language_page_directory . 'customer_service.php');
                }
                $customer_query = "SELECT customers_firstname, customers_lastname, customers_email_address FROM " . TABLE_CUSTOMERS . " WHERE customers_id = :customersID";
                $customer_query = $db->bindVars($customer_query, ':customersID', $_SESSION['customer_id'], 'integer');
                $customer = $db->Execute($customer_query);
                $max_question_id = $db->Execute('select max(question_id) max_qid from ' . TABLE_CUSTOMER_QUESTION);
                $insert_qid = $max_question_id->fields['max_qid'] + 1;
                $db->Execute('insert into ' . TABLE_CUSTOMER_QUESTION . ' (question_id, customer_id, submit_time, question_content, language_id) value(' . $insert_qid . ',' . $_SESSION['customer_id'] . ', "' . date('Y-m-d H:i:m') . '","' . $question . '", ' . $_SESSION['languages_id'] . ')');

                $email_subject = TEXT_QUESEMAIL_TITLE;
                $html_msg['EMAIL_MESSAGE_HTML'] = TEXT_QUESEMAIL_QUESTION . ': ' . $question . "<br />\n";
                $html_msg['EMAIL_MESSAGE_HTML'] .= TEXT_QUESEMAIL_NAME . ': ' . $customer->fields['customers_lastname'] . " " . $customer->fields['customers_firstname'] . "<br />\n";
                $html_msg['EMAIL_MESSAGE_HTML'] .= TEXT_QUESEMAIL_EMAIL . ": <a href='mailto:" . $customer->fields['customers_email_address'] . "'>" . $customer->fields['customers_email_address'] . "</a><br />\n";
                $html_msg['EMAIL_MESSAGE_SUPPLIES'] = $html_msg['EMAIL_MESSAGE_HTML'];
                $emai_array = explode(",", EMAIL_ARRAY);
                $send_to_email = $emai_array[(int)$_SESSION['languages_id'] - 1];
                if ($send_to_email == "") {
                    $send_to_email = $emai_array[0];
                }
                if ($_SESSION['auto_auth_code_display']['FAQ'] > 0) {
                    $_SESSION['auto_auth_code_display']['FAQ'] += 1;
                } else {
                    $_SESSION['auto_auth_code_display']['FAQ'] = 1;
                }

                //Tianwen.Wan20160415->SEND_EXTRA_CUSTOMER_QUESTION_EMAILS_TO
                zen_mail('Doreenbeads', $send_to_email, $email_subject, '', STORE_NAME, EMAIL_FROM, $html_msg, 'ex_customer_question');
            } else {
                $return_arr['is_error'] = true;
                $return_arr['error_info'] = TEXT_CHECK_URL;
            }

        } else {
            $return_arr['is_error'] = true;
            $return_arr['error_info'] = 'fail';
        }

        if ($_SESSION['auto_auth_code_display']['FAQ'] >= 3) {
            $return_arr['add_auth_code'] = true;
            $return_arr['add_content'] = '<span style="width:50px;position: relative;top:1px;display:inline-block;line-height: 18px;" class="auth_code_span">' . TEXT_VERIFY_NUMBER . ':</span>' . zen_draw_input_field('check_code', '', 'size="25" id="check_code_input" class="auth_code_span" style="WIDTH: 50PX;line-height: 20px;position: relative;top: -8px; margin-left:10px;"') . '<img  id="check_code" src="./check_code.php?code_suffix=login" style="margin-left: 15px;height:24px;" onClick="this.src=\'./check_code.php?code_suffix=login&\'+Math.random();" />';
        }

        echo json_encode($return_arr);
        exit;
        break;

    case 'shipping_calculator':
        require(DIR_WS_CLASSES . 'shipping.php');
        require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/cherry_zen/shipping_calculator.php');
//         $shipping_modules = new shipping;
        $weight = isset($_POST['weight']) ? zen_db_prepare_input($_POST['weight']) : '';;
        $net_weight = round($net_weight, 2);
        $_SESSION['net_weight'] = $weight;
        $country = zen_db_prepare_input($_POST['country']);
        $_SESSION['country'] = $country;
        $post_city = zen_db_prepare_input($_POST['city']);
        $_SESSION['city'] = $city;
        $post_postcode = zen_db_prepare_input($_POST['zip']);
        $_SESSION['zip'] = $zip;
        $quick_zone_id = $db->Execute("select countries_iso_code_2 from " . TABLE_COUNTRIES . " where countries_id = " . (int)$country);
        $countries_iso_code_2 = $quick_zone_id->fields['countries_iso_code_2'];
        //$shipping_modules->quote($country, $weight, $zip, $city);
        //$shipping_modules->reduce_airmail_cost();
        //$show_method_cal = $shipping_modules->reduce_result;
        //$special_discount = $shipping_modules->special_result;
        if (empty($countries_iso_code_2)) {
            $countries_iso_code_2 = get_default_country_code(array('customers_id' => $_SESSION['customer_id'], 'address_book_id' => 0));
        }

        $shipping_modules = new shipping ('', $countries_iso_code_2, $weight, $post_postcode, $post_city);
        $shipping_data = $shipping_modules->get_default_shipping_info(array('customers_id' => $_SESSION['customer_id'], 'countries_iso_code_2' => $countries_iso_code_2, 'address_book_id' => 0));
        $shipping_list = $shipping_data['shipping_list'];
        $shipping_info = $shipping_data['shipping_info'];
        $special_discount = $shipping_data['special_discount'];

        $result_code = "<tr>
								<th width = '30%'>" . TEXT_SHIPPING_METHOD . "</th>
				  				<th width = '13%'>" . TEXT_DAYS . "</th>
				  				<th width = '10%'>" . TEXT_PACKAGE_NUMBER . "</th>
				  				<th width = '13%'>" . TEXT_SERVER . "</th>
				  				<th width = '18%'>" . TEXT_RESULT_COST . "</th>
								" . (sizeof($special_discount) > 0 ? '<th><a href="javascript:void(0);" style="color:#000000;" title="' . TEXT_SINCE_SHIPPING_COST . '">' . TEXT_SPECIAL_DISCOUNT . '</a></th>' : '') . "
				  			</tr>";
        foreach ($shipping_list as $type => $val) {
            switch ($type) {
                case 'trstma' :
                    $to_door = TEXT_NOT_DOOR_TO_DOOR . '<a title="' . TEXT_MOSCOW_ST . '"><font size="1" color="#c89469" style="cursor:pointer;">[?]</font></a>';
                    break;
                case 'trstm' :
                    $to_door = TEXT_NOT_DOOR_SHIP_TO_MOSCOW;
                    break;
                case 'sfhyzxb' :
                    $to_door = TEXT_NOT_DOOR_SHIP_TO_LOCAL;
                    break;
                case 'ynkqy' :
                    $to_door = TEXT_NOT_DOOR_TO_DOOR . '<a title="' . TEXT_ST_PETERSBURG . '"><font size="1" color="#c89469" style="cursor:pointer;">[?]</font></a>';
                    break;
                default :
                    $to_door = TEXT_DOOR_TO_DOOR;
            }
            $time_unit = TEXT_DAYS_LAN;
            if ($val['time_unit'] == 20) {
                $time_unit = TEXT_WORKDAYS;
            }
            $result_code .= '<tr cost="' . round($val['final_cost'], 2) . '" day="' . ($val['day_low'] * 10 + $val['day_high']) . '">
									<td align = "left" style="padding:8px 8px;">' . $val['title'] . '</td>
									<td align = "center" style="padding:8px 8px;">' . $val['days'] . ' ' . $time_unit . '</td>
									<td align = "center" style="padding:8px 8px;">' . $val['box'] . '</td>
									<td align = "center" style="padding:8px 8px;">' . $to_door . '</td>
									<td align = "center" style="padding:8px 8px;">' . (($val['final_cost'] == 0 && $val['code'] != 'agent') ? TEXT_FREE_SHIPPING : $currencies->format($val['final_cost'])) . '</td>
									' . (sizeof($special_discount) > 0 ? '<td align="center" style="color:#ff0000;">' . ($special_discount[$val['code']] > 0 ? '-' . $currencies->format($special_discount[$val['code']]) : '') . '</td>' : '') . '
								 </tr>';
        }
        $result_code .= '<tr><td colspan="' . (sizeof($special_discount) > 0 ? 6 : 5) . '" align="right"><a style="color:#008FED;" target="_blank" href = "index.php?main_page=who_we_are&id=99999" >[' . SHIPPING_CONTACT_US . ']</a></td></tr>';
        echo $result_code;
        break;
}
?>
