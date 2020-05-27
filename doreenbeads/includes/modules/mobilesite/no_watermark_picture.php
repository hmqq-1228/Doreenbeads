<?php
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

$action = $_POST['action'];
switch ($action){
	case 'check_file':
		$return_array = array('error' => false, 'error_info' => '');
		$file = $_FILES['products_mode_file'];
		if($file['error'] == 0 && !empty($file)){
			$filename = basename($file['name']);
			if(substr($filename, '-4') == 'xlsx' || substr($filename, '-3') == 'xls'){
				$file_from = $file['tmp_name'];
				set_time_limit(0);
				set_include_path('./Classes/');
				include 'PHPExcel.php';
				if(substr($filename, '-4')=='xlsx'){
					include 'PHPExcel/Reader/Excel2007.php';
					$objReader = new PHPExcel_Reader_Excel2007;
				}else{
					include 'PHPExcel/Reader/Excel5.php';
					$objReader = new PHPExcel_Reader_Excel5;
				}
				$objPHPExcel = $objReader->load($file_from);
				$sheet = $objPHPExcel->getActiveSheet();
				$products_model_num = $sheet->getHighestRow();
				
				if($products_model_num > 201){
					$return_array['error'] = true;
					$return_array['error_info'] = TEXT_NO_WATERMARK_UPLOAD_LIMIT;
				}
			}else{
				$return_array['error'] = true;
				$return_array['error_info'] = TEXT_NO_WATERMARK_UPLOAD_FILE_FORMAT_ERROR;
			}
		}else{
			$return_array['error'] = true;
			$return_array['error_info'] = TEXT_NO_WATERMARK_UPLOAD_FILE_EMPTY;
		}
		
		die(json_encode($return_array));
	exit;
	break;
	case 'upload_file':
		if(isset($_SESSION['customer_email']) && isset($_SESSION['customer_id'])){
			$file = $_FILES['products_mode_file'];
			if($file['error'] == 0 && !empty($file)){
				$filename = basename($file['name']);
				if(substr($filename, '-4') == 'xlsx' || substr($filename, '-3') == 'xls'){
					$file_from = $file['tmp_name'];
					$extra_file_url = 'file/no_watermark_picture/';
					$new_filename = $extra_file_url . date('YmdHis') . '_' . $_SESSION['customers_email'] . $filename;
					$res = move_uploaded_file($file_from, $new_filename);
					$attachments_list['file'] = $new_filename;
					
					if($res){
						$vip_discount_query = $db->Execute('select group_percentage from ' . TABLE_GROUP_PRICING . ' where group_id = ' . $_SESSION['customers_group_pricing']);
						
						if($vip_discount_query->RecordCount() > 0){
							$vip_discount = $vip_discount_query->fields['group_percentage'];
						}else{
							$vip_discount = 0;
						}
						$service_array = explode(',', EMAIL_ARRAY);
						if($_SESSION['languages_id'] == 6){
							$customers_name = $_SESSION['customer_last_name'] . $_SESSION['customer_first_name'];
						}else{
							$customers_name = $_SESSION['customer_first_name'] . ' ' . $_SESSION['customer_last_name'];
						}
						
						$html_msg['CUSTOMERS_NAME'] = TEXT_QUESEMAIL_NAME . ':</span><span>' . $customers_name;
						$html_msg['CUSTOMERS_EMAIL_ADDRESS'] = ENTRY_EMAIL_ADDRESS . ' : </span><span>' . $_SESSION['customer_email'];
						$html_msg['CUSTOMERS_VIP_DISCOUNT'] = TEXT_VIP_GROUNP_DISCOUNT . '：</span><span>' . $vip_discount . '%';
						
						$email_text = TEXT_QUESEMAIL_NAME . ':' . $customers_name . '\n\r' . ENTRY_EMAIL_ADDRESS . ' : ' . $_SESSION['customer_email'] . '\n\r' . TEXT_VIP_GROUNP_DISCOUNT . '：' . $vip_discount . '%';
						
						zen_mail(strstr($service_array[$_SESSION['languages_id']-1], '@', true), $service_array[$_SESSION['languages_id']-1], sprintf(TEXT_NO_WATERMARK_EMAIL_TITLE , $customers_name), $email_text, $customers_name, EMAIL_FROM, $html_msg, 'no_watermark_picture', $attachments_list);
						unlink($file_from);
						zen_redirect(zen_href_link(FILENAME_NO_WATERMARK_PICTURE));
					}else{
						zen_redirect(zen_href_link(FILENAME_NO_WATERMARK_PICTURE));
					}
				}else{
					zen_redirect(zen_href_link(FILENAME_NO_WATERMARK_PICTURE));
				}
			}else{
				zen_redirect(zen_href_link(FILENAME_NO_WATERMARK_PICTURE));
			}
		}else{
			zen_redirect(zen_href_link(FILENAME_NO_WATERMARK_PICTURE));
		}
	break;
}

?>