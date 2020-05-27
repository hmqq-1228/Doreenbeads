<?php
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));
//error_reporting(E_ALL^E_NOTICE);


if (! isset ( $_SESSION ['customer_id'] )) {
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}

$action = zen_db_prepare_input($_POST['action']);
switch ($action) {
	case 'add_coupon':
		$result_info_array = array('is_error' => false , 'error_info' => '' , 'link' => '' , 'coupon_display' => '' , 'order_info' => '' ,  'success_info' => TEXT_ADD_COUPON_DESCRIPTION);
		$error_info = array();

		$cp_code = zen_db_prepare_input($_POST['code']);
		$error_info = add_coupon_code($cp_code);
		
		$result_info_array['error_info'] = $error_info['error_info'];
		$result_info_array['is_error'] = $error_info['is_error'];
		echo json_encode($result_info_array);
		exit;
		break;
	
	case 'coupon_split':
		$page = zen_db_input($_POST['nextPage']) >= 1 ? zen_db_input($_POST['nextPage']) : 1;
		$cp_status = zen_db_input($_POST['cp_status']);
		$return_array = $coupon_show_array = array();
		$return_html = '';
		$error = false;
		$page_size = MAX_DISPLAY_ORDER_HISTORY;

		$coupon_show_array = get_customer_coupons($cp_status);		
		$coupon_count = sizeof($coupon_show_array);
		$coupon_show_array = array_slice($coupon_show_array, ($page -1) * $page_size, MAX_DISPLAY_ORDER_HISTORY);

		if (empty($coupon_show_array)) {
			$error = true;
		}else{
			foreach ($coupon_show_array as $key => $value) {
				$return_html .= '<table>';
	      		$return_html .= '<tr><th>'.TEXT_COUPON_CODE.':</th><td>'.$value['coupon_code'].'</td></tr>
							     <tr><th>'.TEXT_COUPON_PAR_VALUE.':</th><td>'.$value['value'].'</td></tr>
							     <tr><th>'.TEXT_COUPON_MIN_ORDER.':</th><td>'.$value['min_order'].'</td></tr>';
				if ($cp_status == 1) {
					$return_html .= '<tr><th>'.TEXT_DATE_ADDED.':</th><td>'.$value['date_created'].'</td></tr>';
				}
				if ($value['coupon_description'] != '' && $cp_status == 1) {
					$return_html .= '<tr><th>'.TEXT_MEMO.':</th><td>'.$value['coupon_description'].'</td></tr>';
				}
				if ($cp_status == 0) {
					$orders =  $used_time = '/';
					if ($value['orders_id'] != '') {
						$orders = $value['orders_id'];
					}
					if ($value['used_time'] != '') {
						$used_time = $value['used_time'];
					}
		      		$return_html .= '<tr><th>'.TEXT_COUPON_STATUS.':</th><td>'.$value['status'].'</td></tr>
		      						<tr><th>'.TEXT_COUPON_ORDER_NUMBER.':</th><td>'. $orders .'</td></tr>
		      						<tr><th>'.TEXT_COUPON_USED_TIME.':</th><td>'. $used_time .'</td></tr>';
		      	}		      	
				$return_html .= '</table>';
			}
		}

		if($coupon_count > $page_size){
			$_GET['page']=$page;
			$coupon_split = new splitPageResults ( '', $page_size, '', 'page', false, $coupon_count );
			$return_fenye = $coupon_split->display_links_mobile_for_shoppingcart ( MAX_DISPLAY_PAGE_LINKS, '', true );
		}

		$return_array['return_fenye'] = $return_fenye;
		$return_array['return_html'] = $return_html;
		$return_array['error'] = $error;
		echo json_encode($return_array);
		exit;
		break;

		default:
		break;
}

$coupon_show_array=array();
$empty = false;
$page_size = MAX_DISPLAY_ORDER_HISTORY;

$cp_status = zen_db_prepare_input($_GET['status']);
if (!isset($cp_status)) {
	$cp_status = 1;
}

if($cp_status == 0){

	$cp_status_name = TEXT_INACTIVE_COUPONS;
	$coupon_show_array = get_customer_coupons(0);

}elseif($cp_status == 1){	

	$cp_status_name = TEXT_ACTIVE_COUPONS;
	$coupon_show_array = get_customer_coupons();

}

if (sizeof($coupon_show_array) <= 0) {
	$empty = true;
}
//var_dump($coupon_show_array);
$coupon_count = sizeof($coupon_show_array);
$coupon_show_array = array_slice($coupon_show_array, 0, MAX_DISPLAY_ORDER_HISTORY);

if ($coupon_count > MAX_DISPLAY_ORDER_HISTORY) {
	$coupon_split = new splitPageResults('', MAX_DISPLAY_ORDER_HISTORY, '', '', false, $coupon_count);
	$coupon_fen_ye = '<div class="page">' . $coupon_split->display_links_mobile_for_shoppingcart ( MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params ( array('page', 'info', 'x', 'y', 'main_page') ) ,true) . '</div>';
}else{
	$coupon_fen_ye = '';
}

$smarty->assign('empty', $empty );
$smarty->assign('coupon_fen_ye', $coupon_fen_ye );
$smarty->assign('coupon_show_array', $coupon_show_array);
$smarty->assign('status', $cp_status);
$smarty->assign('mycoupon_link', zen_href_link(FILENAME_MY_COUPON));
$smarty->assign('cp_status_name', $cp_status_name );

?>



