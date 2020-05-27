<?php 
chdir("../");
require ('includes/application_top.php');

$action = zen_db_prepare_input(trim($_POST['action']));
$data = (array)json_decode($_POST['data']);
$network = zen_db_prepare_input(trim($_POST['network']));
$redirct_url = zen_db_prepare_input(trim($_POST['origin_url']));
$return_array =array();

if(isset($action) && $action == 'api_login'){
    switch ($network){
        case 'Twitter': 
            $customers_twitter_id = $data['id_str'];
            $customers_first_name = $data['first_name'];
            $customers_last_name = $data['last_name'];
            $customers_thumbnail = $data['thumbnail'];
            
            if($customers_twitter_id){
                $check_sql = "SELECT customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id, customers_authorization, customers_referral,register_useragent_language FROM " . TABLE_CUSTOMERS . " WHERE customers_twitter_id = :twitterid";
                $check_sql = $db->bindVars($check_sql, ':twitterid', $customers_twitter_id, 'string');
                $check_res = $db->Execute($check_sql);
                
                if($check_res->RecordCount() > 0){
                    zen_api_login($check_res->fields);
                    
                    $return_array = array(
                        'error' => false,
                        'error_info' => '',
                        'redirct_url' => $redirct_url != '' ? $redirct_url : zen_href_link(FILENAME_MY_ACCOUNT)
                    );
                }else{
                    $_SESSION['api_login_type'] = $network;
                    $_SESSION['api_customers_id'] = $customers_twitter_id;
                    $_SESSION['api_first_name'] = $customers_first_name;
                    $_SESSION['api_last_name'] = $customers_last_name;
                    $_SESSION['api_customers_thumbnail'] = $customers_thumbnail;
                    
                    $return_array = array(
                        'error' => false,
                        'error_info' => '',
                        'redirct_url' => zen_href_link(FILENAME_LOGIN)
                    );
                }
            }else{
                $return_array = array(
                  'error' => true,
                  'error_info' => 'Twitter Info Error!',
                  'redirct_url' => zen_href_link(FILENAME_LOGIN)
                );
            }
            
            echo json_encode($return_array);
            exit;
            break;
        case 'VK':
            $customers_info = (array)$data['user'];
            $customers_vk_id = $customers_info['id'];
            $customers_first_name = $customers_info['first_name'];
            $customers_last_name = $customers_info['last_name'];
            
            if($customers_vk_id){
                $check_sql = "SELECT customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id, customers_authorization, customers_referral,register_useragent_language FROM " . TABLE_CUSTOMERS . " WHERE customers_vk_id = :vkid";
                $check_sql = $db->bindVars($check_sql, ':vkid', $customers_vk_id, 'string');
                $check_res = $db->Execute($check_sql);
                
                if($check_res->RecordCount()){
                    zen_api_login($check_res->fields);
                    
                    $return_array = array(
                        'error' => false,
                        'error_info' => '',
                        'redirct_url' => $redirct_url != '' ? $redirct_url : zen_href_link(FILENAME_MY_ACCOUNT)
                    );
                }else{
                    $_SESSION['api_login_type'] = $network;
                    $_SESSION['api_customers_id'] = $customers_vk_id;
                    $_SESSION['api_first_name'] = $customers_first_name;
                    $_SESSION['api_last_name'] = $customers_last_name;
                    
                    $return_array = array(
                        'error' => false,
                        'error_info' => '',
                        'redirct_url' => zen_href_link(FILENAME_LOGIN)
                    );
                }
            }else{
                $return_array = array(
                    'error' => true,
                    'error_info' => 'Twitter Info Error!',
                    'redirct_url' => zen_href_link(FILENAME_LOGIN)
                );
            }
            
            echo json_encode($return_array);
            exit;
            break;
        
    }
}

function zen_api_login($rs){
    global $db;
    
    $ls_old_cookie = $_SESSION['cookie_cart_id'];
    if (SESSION_RECREATE == 'True') {
        zen_session_recreate();
    }
    
    $check_country_query = "SELECT entry_country_id, entry_zone_id
							  FROM " . TABLE_ADDRESS_BOOK . "
							 WHERE customers_id = :customersID
								AND address_book_id = :adressBookID";
    $check_country_query = $db->bindVars($check_country_query, ':customersID', $rs['customers_id'], 'integer');
    $check_country_query = $db->bindVars($check_country_query, ':adressBookID', $rs['customers_default_address_id'], 'integer');
    $check_country = $db->Execute($check_country_query);
    
    $_SESSION['customer_id'] = $rs['customers_id'];
    $_SESSION['customer_default_address_id'] = $rs['customers_default_address_id'];
    //	$_SESSION['has_valid_order'] = zen_customer_has_valid_order();
    $_SESSION['customers_authorization'] = $rs['customers_authorization'];
    $_SESSION['customer_first_name'] = $rs['customers_firstname'];
    $_SESSION['customer_country_id'] = $check_country->fields['entry_country_id'];
    $_SESSION['customer_zone_id'] = $check_country->fields['entry_zone_id'];
    
    setcookie("zencart_cookie_validate_email", md5($rs['customers_email_address']), time() + 7776000, '/', '.' . BASE_SITE);
    
    $sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
			SET customers_info_date_of_last_logon = now(),
			customers_info_number_of_logons = customers_info_number_of_logons+1
			WHERE customers_info_id = :customersID";
    $sql = $db->bindVars($sql, ':customersID',  $_SESSION['customer_id'], 'integer');
    $db->Execute($sql);
    
    if($ls_old_cookie) $_SESSION['cart']->restore_contents($ls_old_cookie);
    setcookie("cookie_cart_id", "", time() - 3600, '/', '.' . BASE_SITE);
    
    if ($_POST["permLogin"]) {
        unset($c);
        $c[] = $_SESSION['customer_id'];
        $c[] = $_SESSION['customer_default_address_id'];
        $c[] = $_SESSION['customers_authorization'];
        $c[] = $_SESSION['customer_first_name'];
        $c[] = $_SESSION['customer_last_name'];
        $c[] = $_SESSION['customer_country_id'];
        $c[] = $_SESSION['has_valid_order'];
        $c[] = $rs['customers_password'];
        $c_str = implode("~~~", $c);
        setcookie("zencart_cookie_autologin", $c_str, time() + 7776000, '/', '.' . BASE_SITE);
    }
}

?>