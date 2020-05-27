<?php 
chdir("../");
require('includes/application_top.php');
$action=$_POST['action'];
$return_info = array('error' => 0);

$time = date('Y-m-d H:i:s');
switch($action){
	case 'send_coupon':
		if(GET_COUPON_EVENT_START_TIME > $time || GET_COUPON_EVENT_END_TIME < $time || GET_COUPON_EVENT_IDS == '') {
			$return_info['error'] = 1;
			$return_info['error_code'] = 'expired';
			$return_info['message'] = $return_info['message_mobile'] = TEXT_GET_COUPON_EXPIRED;
			$return_info['message'] = '<h3><span id="closebtnlogin">X</span></h3><div style="font-size:16px;padding:0px 30px 15px 30px;line-height:32px">'.$return_info['message'].'</div>';
		} else if(empty($_SESSION['customer_id'])) {
			$return_info = array('error' => 1, 'error_code' => 'login');
			$_SESSION['redirect_url_after_login'] = zen_href_link('get_coupon', '', 'NONSSL');
		} else {
				$coupon_code = zen_db_prepare_input($_POST['coupon']);
				$coupon_array = explode(",", $coupon_code);
				$coupon_string = "'" . implode("','", $coupon_array) . "'";
				
				$coupon_query = $db->Execute("select coupon_id,coupon_amount,coupon_type,day_after_add from ".TABLE_COUPONS." where coupon_code in (" . $coupon_string . ")");
				$check_exist = $db->Execute("select cc_id from ".TABLE_COUPON_CUSTOMER." where cc_coupon_id='".$coupon_query->fields['coupon_id']."' and cc_customers_id='".$_SESSION['customer_id']."'");
				if($check_exist->RecordCount()>0){
					$return_info = array('error' => 1);
					$return_info['message'] = $return_info['message_mobile'] = TEXT_ALREADY_GET;
					$return_info['message'] = '<h3><span id="closebtnlogin">X</span></h3><div style="font-size:16px;padding:0px 30px 15px 30px;line-height:32px">'.$return_info['message'].'</div>';
				}else {
					$coupon_amount_total = 0;
					while(!$coupon_query->EOF) {
						$coupon_amount_total += $coupon_query->fields['coupon_amount'];
						$customer_coupon_data = array(
							'cc_coupon_id'=>$coupon_query->fields['coupon_id'],
							'cc_customers_id'=>$_SESSION['customer_id'],
							'cc_amount'=>$coupon_query->fields['coupon_amount'],
							'cc_coupon_status'=>10,
							'admin_email_or_customers_email_address' => $_SESSION['customer_email'],
							'website_code'=>WEBSITE_CODE,
							'date_created'=>'now()'
							
						);
						if($coupon_query->fields['coupon_type'] == 'C') {
							$day_after_add = $coupon_query->fields['day_after_add'];
							if(empty($day_after_add)) {
								$day_after_add = 30;
							}
							$cc_coupon_start_time = date("Y-m-d H:i:s");
							$customer_coupon_data['cc_coupon_start_time'] = $cc_coupon_start_time;
							$customer_coupon_data['cc_coupon_end_time'] = date("Y-m-d H:i:s", strtotime($cc_coupon_start_time) + (86400 * $day_after_add));
						}
						zen_db_perform(TABLE_COUPON_CUSTOMER, $customer_coupon_data);
						
						$coupon_query->MoveNext();
					}
					
					$return_info['message'] = '<h3><span id="closebtnlogin">X</span></h3><div style="font-size:16px;padding:0px 30px 15px 30px;line-height:32px">'.sprintf(TEXT_GET_COUPON, '<font color=red>USD ' . round($coupon_amount_total) . '</font>').'</div>';;
					$return_info['message_mobile'] = strip_tags(sprintf(TEXT_GET_COUPON, 'USD ' . round($coupon_amount_total)));
					$return_info['error'] = 0;
				}
		}
		echo json_encode($return_info);
		break;
	default:

		break;
}
?>