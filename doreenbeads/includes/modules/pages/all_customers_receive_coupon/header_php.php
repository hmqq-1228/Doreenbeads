<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$time = date('Y-m-d H:i:s');
if(REVEICE_COUPON_EVENT_START_TIME > $time || REVEICE_COUPON_EVENT_END_TIME < $time ){
    zen_redirect ( zen_href_link ( FILENAME_DEFAULT ) );
}
$coupon_array = array('CP2019041102', 'CP2019041105', 'CP2019041110', 'CP2019041120', 'CP2019041125');
$coupon_array_str = "'CP2019041102', 'CP2019041105', 'CP2019041110', 'CP2019041120', 'CP2019041125'";
$action = trim($_POST['action']);
switch ($action){
    case 'receive_coupon':
        $return_array = array('error' => false, 'error_type' => 0, 'error_info' => '', 'redirect_url' => '');
        
        if(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0){
            $customer_id = $_SESSION['customer_id'];
            
                $check_customers_receive_coupon_query = $db->Execute('SELECT cc_id from ' . TABLE_COUPON_CUSTOMER . ' cc INNER JOIN  ' . TABLE_COUPONS . ' c on cc.cc_coupon_id = c.coupon_id where  cc.cc_customers_id = ' . $customer_id . ' and  c.coupon_code in (' . $coupon_array_str . ')');
                
                if($check_customers_receive_coupon_query->RecordCount() <= 0){
                    foreach ($coupon_array as $coupon_code){
                        add_coupon_code($coupon_code, false);
                    }
                    $return_array['error_info'] = TEXT_RECEIVE_COUPON_HAVE_RECEIVE;
                }else{
                    $return_array['error'] = true;
                    $return_array['error_type'] = 2;
                    $return_array['error_info'] = TEXT_RECEIVE_COUPON_OLD_CUSOMERS_ERROR;
                }
            
        }else{
            $return_array['error'] = true;
            $return_array['error_type'] = 1;
            $return_array['redirect_url'] = zen_href_link(FILENAME_LOGIN);
        }
        echo json_encode($return_array);
        exit;
        break;
        
}

$receivable = true;
if( isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0 ){
    $check_customers_receive_coupon_query = $db->Execute('SELECT cc_id from ' . TABLE_COUPON_CUSTOMER . ' cc INNER JOIN  ' . TABLE_COUPONS . ' c on cc.cc_coupon_id = c.coupon_id where  cc.cc_customers_id = ' . $_SESSION['customer_id'] . ' and  c.coupon_code in (' . $coupon_array_str . ')');
    
    if($check_customers_receive_coupon_query->RecordCount() > 0){
        $receivable = false;
    }
}

?>