<?php
chdir("../");
@ set_time_limit(0);
@ ini_set("memory_limit', '2048M");
require ("includes/application_top.php");
include_once(DIR_WS_CLASSES . 'Mailchimp.php');
include_once(DIR_WS_CLASSES . 'config.inc');

function update_event_status($event_id, $new_status, $request_time){
	global $db;
	if ($event_id == '') {
		return false;
	}
	$sql_data = array('event_status' => $new_status, 'request_time' => $request_time+1, 'last_modify' => date('Y-m-d H:i:s'));
	zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_EVENT, $sql_data, 'update', "id = " . $event_id);
}

function insert_event_log($event, $new_status, $json_array){
	global $db;
	if ((int)$event['id'] == 0) {
		return false;
	}

	$sql_data = array(
		'event_id' => $event['id'],
		'customers_email_address' => $event['customers_email_address'],
		'list_id' => $event['list_id'],
		'event_type' => $event['event_type'],
		'event_status' => $new_status,
		'date_created' => date('Y-m-d H:i:s')
		);

	if (isset($json_array['detail'])) {
		$sql_data_2 = array(
			'response_title' => $json_array['detail'],
			'response_json' => json_encode($json_array)
			);
	}else{
		$sql_data_2 = array(
			'response_title' => $json_array['status'],
			'response_json' => json_encode($json_array)
			);
	}

	zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_EVENT_LOG, array_merge($sql_data, $sql_data_2));
}

$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");
$event_array = $param = array();
$member_status = '';

if(isset ($_GET['action']) && $_GET['action'] == 'execute_mailchimp_event') {

	$event_sql = "SELECT * FROM " . TABLE_CUSTOMERS_FOR_MAILCHIMP_EVENT . " WHERE event_status = 10 and list_id != '' and event_type in (10, 20) ";

	$event_sql_query = $db->Execute($event_sql);

	if($event_sql_query->RecordCount() > 0) {
		while (!$event_sql_query->EOF){
			$event_array[] = $event_sql_query->fields;
			$event_sql_query->MoveNext();
		}
	}

	foreach ($event_array as $key => $event) {

        $api = new Mailchimp( $apikey );

        //$interestGroupings = $api->interestGroupings($event['list_id']);
        $members_info = $api->getMembers($event['list_id'], $event['customers_email_address']);

        if (isset($members_info['unique_email_id'])) { 
        	$member_status = $members_info['status']; 
        } else {
        	$member_status = '';
        }

        switch ($event['event_type']) {
        	case '10':// subscribe

        		$param = array(
		        	'FNAME'=>$event['customers_firstname'], 
		        	'LNAME'=>$event['customers_lastname'], 
		        	);
		        $subscribe_info = $api->subscribe( $event['list_id'], $event['customers_email_address'], $param );
		        //print_r($subscribe_info);

		        if ($subscribe_info['status'] == 'subscribed' || $subscribe_info['status'] == 400) { // 400 Member exists
		        	$event_status = 20; // completed
		        }else{
		        	$event_status = $event['event_status']; // have no change
		        }

		        update_event_status($event['id'], $event_status, $event['request_time']);
        		insert_event_log($event, $event_status, $subscribe_info);

        		break;

        	case '20':// unsubscribe
        		$unsubscribe_info = $api->unsubscribe( $event['list_id'], $event['customers_email_address']);
        		if ($unsubscribe_info['status'] == 'unsubscribed') { 
		        	$event_status = 20; // completed
		        }else{
		        	$event_status = $event['event_status']; // have no change
		        }
		        update_event_status($event['id'], $event_status, $event['request_time']);
        		insert_event_log($event, $event_status, $unsubscribe_info);
        		print_r($unsubscribe_info);
        		break;

        	default:
        		if (isset($members_info['status']) && $members_info['status'] == 404) {
        			update_event_status($event['id'], $event['event_status'], $event['request_time']);
        			insert_event_log($event, $event['event_status'], $members_info);
        		}
        		break;
        }
       
	}
	
}elseif(isset ($_GET['action']) && $_GET['action'] == 'refresh_mailchimp_subscribe_status') {
	$api = new Mailchimp( $apikey );
	//$info = $api->getAllMembers();
	foreach ($listIdArray as $lang => $value) {
		$info = $param = $members = array();

		$info = $api->getMembers($value, '', $param);
		//print_r($info);
		
		$members_count = $info['total_items'];
		for ($offset = 0; $offset < $members_count; $offset += 50) { 

			$data = array(
				'offset' => $offset,
				'count'  => 50
			);

			$members_offset = $api->getMembers($value, '', $data);
			$members = $members_offset['members'];

			if (!empty($members)) {
				foreach ($members as $key => $members_info) {
					$members_info['email_address'] = trim(addslashes($members_info['email_address']));
					$members_info['status'] = trim($members_info['status']);

					if (in_array(strtolower($members_info['status']), array('subscribed', 'pending'))) {
						$members_status = 10;
					} else {
						$members_status = 20;
					}

					$customers_id = 0;
					$customers_email_address = '';

					$check_member_query = $db->Execute('SELECT * from ' . TABLE_CUSTOMERS_FOR_MAILCHIMP . ' WHERE customers_for_mailchimp_email = "' . $members_info['email_address'] . '" LIMIT 1');
					$customers_id = $check_member_query->fields['customers_for_mailchimp_id'];
					$customers_email_address = addslashes($check_member_query->fields['customers_for_mailchimp_email']);

					if ($check_member_query->RecordCount() > 0) { // 网站有记录
						if ( $check_member_query->fields['subscribe_status'] != $members_status ) { //网站与MC上状态不一致
							switch ($members_status) {
								case '10':// 订阅
									$customers_newsletter = 1;
									$check_customer_query = $db->Execute("SELECT * FROM ". TABLE_CUSTOMERS . " WHERE customers_id = ". $customers_id ." LIMIT 1");
									if ($check_customer_query->RecordCount() > 0) {
										$db->Execute("UPDATE " . TABLE_CUSTOMERS ." SET customers_newsletter = ".$customers_newsletter." where customers_id = " . $customers_id);
									}
									$subscribe_sql_data = array('customers_for_mailchimp_email' => $customers_email_address,
							            'customers_for_mailchimp_id' => $customers_id,
							            'website_code' => WEBSITE_CODE,
							            'languages_id' => $lang+1,
							            'subscribe_status' => $members_status,
							            'subscribe_from' => 999,
							            'ip_address' => zen_get_ip_address()
							            );
									$update_sql_array = array('last_modified' => date('Y-m-d H:i:s'));
	    							$insert_sql_array = array('date_created' => date('Y-m-d H:i:s'));

	    							$update_sql_data = array_merge($subscribe_sql_data, $update_sql_array);
	    							$insert_sql_data = array_merge($subscribe_sql_data, $insert_sql_array);
	    							
							        zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP, $subscribe_sql_data, 'update', 'customers_for_mailchimp_email = "' . $customers_email_address . '"');
									zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_SUBSCRIBE_LOG, $insert_sql_data);
									break;

								case '20'://取消订阅(退订)
									$customers_newsletter = 10;
									$check_customer_query = $db->Execute("SELECT * FROM ". TABLE_CUSTOMERS . " WHERE customers_id = ". $customers_id ." LIMIT 1");
									if ($check_customer_query->RecordCount() > 0) {
										$db->Execute("UPDATE " . TABLE_CUSTOMERS ." SET customers_newsletter = ".$customers_newsletter." where customers_id = " . $customers_id);
									}
									$subscribe_sql_data = array('customers_for_mailchimp_email' => $customers_email_address,
							            'customers_for_mailchimp_id' => $customers_id,
							            'website_code' => WEBSITE_CODE,
							            'languages_id' => $lang+1,
							            'subscribe_status' => $members_status,
							            'subscribe_from' => 999,
							            'ip_address' => zen_get_ip_address()
							            );
									$update_sql_array = array('last_modified' => date('Y-m-d H:i:s'));
	    							$insert_sql_array = array('date_created' => date('Y-m-d H:i:s'));

	    							$update_sql_data = array_merge($subscribe_sql_data, $update_sql_array);
	    							$insert_sql_data = array_merge($subscribe_sql_data, $insert_sql_array);
	    							
							        zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP, $subscribe_sql_data, 'update', 'customers_for_mailchimp_email = "' . $customers_email_address . '"');
									zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_UNSUBSCRIBE_LOG, $insert_sql_data);
									break;

								default:
									# code...
									break;
							}
						}
					}else{ // 网站无记录
						if (in_array(strtolower($members_info['status']), array('subscribed', 'pending'))) {
							$customers_newsletter = 1;
							$members_status = 10;
						} else {
							$customers_newsletter = 10;//退订
							$members_status = 20;
						}
													
						$check_customer_email_query = $db->Execute('SELECT * FROM '. TABLE_CUSTOMERS . ' WHERE customers_email_address = "'. $members_info['email_address'] .'" LIMIT 1');
						if ($check_customer_email_query->RecordCount() > 0 && $check_customer_email_query->fields['customers_newsletter'] != $customers_newsletter) {
							$db->Execute('UPDATE ' . TABLE_CUSTOMERS .' SET customers_newsletter = '.$customers_newsletter.' where customers_email_address = "' . $members_info['email_address'] . '"');
							
							$subscribe_sql_data = array('customers_for_mailchimp_email' => $members_info['email_address'],
						            'website_code' => WEBSITE_CODE,
						            'languages_id' => $lang+1,
						            'subscribe_status' => $members_status,
						            'subscribe_from' => 999,
						            'list_id' => $value,
						            'customers_firstname' => $members_info['merge_fields']['FNAME'],
						            'customers_lastname' => $members_info['merge_fields']['LNAME'],
						            'browser_user_agent' => $_SERVER['HTTP_USER_AGENT'],
						            'ip_address' => zen_get_ip_address(),
						            'date_created' => date('Y-m-d H:i:s')
						            );
							zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP, $subscribe_sql_data);
							zen_db_perform(TABLE_CUSTOMERS_FOR_MAILCHIMP_SUBSCRIBE_LOG, $subscribe_sql_data);	
						}
					}
				}
			}
		}
		
	}
}elseif(isset ($_GET['action']) && $_GET['action'] == 'execute_mailchimp_order_event'){ // event_type = 30;
	$event_sql = "SELECT * FROM " . TABLE_CUSTOMERS_FOR_MAILCHIMP_EVENT . " WHERE event_status = 10 and event_type = 30 and orders_id > 0 and (request_time = 0 or (request_time > 0 and date_created>FROM_UNIXTIME(unix_timestamp() - (86400 * 5))))";

	$event_sql_query = $db->Execute($event_sql);

	if($event_sql_query->RecordCount() > 0) {
		require(DIR_WS_CLASSES . 'order.php');

		$api = new Mailchimp( $apikey );		
		$event = array();

		while (!$event_sql_query->EOF){

			$event = $event_sql_query->fields;
			$order = new order($event['orders_id']);
			$products_array = array();
			
			$date_created =  strtotime($order->info['date_purchased']) - 28800;
			$processed_at_foreign = date("Y-m-d", $date_created) . "T" . date("H:i:s", $date_created) . "+00:00";
			
			$mcorder = array(
                'id' => $event['orders_id'],
                'customer' => ['id' => $event['mc_eid'], 'email_address'=> $event['customers_email_address'], 'opt_in_status' => true],
                'campaign_id'=>$event['campaign_id'],
                'currency_code' => 'USD',
                'order_total'=> $order->info['total'],
                'tax'  =>$order->info['tax'],
                'processed_at_foreign' => $processed_at_foreign,
                'updated_at_foreign' => $processed_at_foreign,
                'lines'=>array()
                );

	        foreach($order->products as $line=>$product){
	            $item = array();
	            $products_info = get_products_info_memcache($product['id']);
	            
	            $item['id'] = $product['id'];
	            $item['product_id'] = $product['id'];
	            $item['product_variant_id'] = $product['model'];
	            $item['title'] = $product['model'];
	            $item['variants'] = array(array('id' => $product['model'], 'title' => strip_tags($product['name'])));
	            $item['quantity'] = $product['qty'];
	            $item['price'] = $product['final_price'];
	            $item['image_url'] = HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_info['products_image'], 80, 80);
	            $products_array[] = $item; 
	            // add products to mc
	        	$post_products = $api->operateEcommerceProducts('post', $event['store_id'], '', $item);
	        	//var_dump($post_products);die;
	        	if ($post_products['status'] == 400) {
	        		continue;
	        	}	                       
	        }
	        $mcorder['lines'] = $products_array;
	        //print_r($mcorder);die;
	        $add_orders = $api->addEcommerceOrder($event['store_id'], $mcorder);
			//print_r($add_orders);die;
	        if ((isset($add_orders['id']) && $add_orders['id'] != '') /*|| ($add_orders['status'] == 400 && $add_orders['title'] == 'Bad Request')*/) { // 400 Order exists
	        	$event_status = 20; // completed
	        }else{
	        	$event_status = $event['event_status']; // have no change
	        }
	        update_event_status($event['id'], $event_status, $event['request_time']);
    		insert_event_log($event, $event_status, $add_orders);

			$event_sql_query->MoveNext();
		}
	}
} else if(isset ($_GET['action']) && $_GET['action'] == 'execute_mailchimp_product_event') {//Tianwen.Wan20171005->更新之前所有产品的图片
	$event_sql = "SELECT * FROM " . TABLE_CUSTOMERS_FOR_MAILCHIMP_EVENT . " WHERE orders_id > 0";

	$event_sql_query = $db->Execute($event_sql);

	if($event_sql_query->RecordCount() > 0) {
		require(DIR_WS_CLASSES . 'order.php');

		$api = new Mailchimp( $apikey );		
		$event = array();

		while (!$event_sql_query->EOF){

			$event = $event_sql_query->fields;
			$order = new order($event['orders_id']);

	        foreach($order->products as $line=>$product){
	            $item = array();
	            $products_info = get_products_info_memcache($product['id']);

	            $item['image_url'] = HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_info['products_image'], 80, 80);
	            // update products to mc
	        	$post_products = $api->operateEcommerceProducts('patch', $event['store_id'], $product['id'], $item);
	        	//var_dump($post_products);die;
	        	if ($post_products['status'] == 400) {
	        		continue;
	        	}
	        }
			$event_sql_query->MoveNext();
		}
	}
} else if(isset ($_GET['action']) && $_GET['action'] == 'download_mailchimp_data') {//Tianwen.Wan->20171215，临时下载mailchimp数据用
	$api = new Mailchimp( $apikey );
	//$info = $api->getAllMembers();
	foreach ($listIdArray as $lang => $value) {
		$info = $param = $members = array();

		$info = $api->getMembers($value, '', $param);
		//print_r($info);
		
		$members_count = $info['total_items'];
		for ($offset = 0; $offset < $members_count; $offset += 50) { 

			$data = array(
				'offset' => $offset,
				'count'  => 50
			);

			$members_offset = $api->getMembers($value, '', $data);
			$members = $members_offset['members'];

			if (!empty($members)) {
				foreach ($members as $key => $members_info) {
					$members_info['email_address'] = trim(addslashes($members_info['email_address']));
					$members_info['status'] = trim($members_info['status']);
					$mailchimp_MMERGE12 = $members_info['MMERGE12'];
					$mailchimp_timestamp_signup = str_replace("T", " ", substr($members_info['timestamp_signup'], 0, 19));
					$mailchimp_timestamp_opt = str_replace("T", " ", substr($members_info['timestamp_opt'], 0, 19));
					$mailchimp_last_changed = str_replace("T", " ", substr($members_info['last_changed'], 0, 19));

					//$result = $db->Execute("select customers_email_address from temp_mailchimp where list_id='" . $value . "' and customers_email_address='" . $members_info['email_address'] . "'");
					//if($result->RecordCount() <= 0) {
						$db->Execute("replace into temp_mailchimp_20180105_17 (list_id, customers_email_address, mailchimp_status, mailchimp_MMERGE12, mailchimp_timestamp_signup, mailchimp_timestamp_opt, mailchimp_last_changed, json_data, date_created) values ('" . $value . "', '" . $members_info['email_address'] . "', '" . $members_info['status'] . "', '" . $mailchimp_MMERGE12 . "', '" . $mailchimp_timestamp_signup . "', '" . $mailchimp_timestamp_opt . "', '" . $mailchimp_last_changed . "', '" . addslashes(json_encode($members_info)) . "', now())");
					//} else {
					//	echo $value . "|" . $members_info['email_address'] . " exists.\n";
					//}
				}
			}
		}
		
	}
} else if(isset ($_GET['action']) && $_GET['action'] == 'repair_mailchimp_data') {//Tianwen.Wan->20171215，临时修复数据用
	$event_sql = "select t.customers_email_address, (select list_id from temp_mailchimp_20180105_17 where customers_email_address=t.customers_email_address order by mailchimp_last_changed desc limit 1) list_id, (select mailchimp_status from temp_mailchimp_20180105_17 where customers_email_address=t.customers_email_address order by mailchimp_last_changed desc limit 1) mailchimp_status, (select mailchimp_timestamp_signup from temp_mailchimp_20180105_17 where customers_email_address=t.customers_email_address order by mailchimp_timestamp_signup desc limit 1) mailchimp_timestamp_signup, (select mailchimp_timestamp_opt from temp_mailchimp_20180105_17 where customers_email_address=t.customers_email_address order by mailchimp_timestamp_opt desc limit 1) mailchimp_timestamp_opt, (select mailchimp_last_changed from temp_mailchimp_20180105_17 where customers_email_address=t.customers_email_address order by mailchimp_last_changed desc limit 1) mailchimp_last_changed from temp_mailchimp_20180105_17 t GROUP BY customers_email_address";
	$event_sql_query = $db->Execute($event_sql);

	if($event_sql_query->RecordCount() > 0) {
		while (!$event_sql_query->EOF){
			$event_sql_query->fields['customers_email_address'] = addslashes($event_sql_query->fields['customers_email_address']);
			$languages_id = 0;
			$subscribe_status = 10;
			
			$mailchimp_time = $event_sql_query->fields['mailchimp_last_changed'];
			if($mailchimp_time == "0000-00-00 00:00:00") {
				$mailchimp_time = $event_sql_query->fields['mailchimp_timestamp_opt'];
			}
			if($mailchimp_time == "0000-00-00 00:00:00") {
				$mailchimp_time = $event_sql_query->fields['mailchimp_timestamp_signup'];
			}
			if($mailchimp_time == "0000-00-00 00:00:00") {
				$mailchimp_time = date("Y-m-d H:i:s");
			}
		
			foreach($listIdArray as $key => $list_id) {
				if($list_id == $event_sql_query->fields['list_id']) {
					$languages_id = $key+1;
				}
			}
			
			if (in_array(strtolower($event_sql_query->fields['mailchimp_status']), array('subscribed', 'pending'))) {
				$customers_newsletter = 1;
				$subscribe_status = 10;
			} else {
				$customers_newsletter = 10;
				$subscribe_status = 20;
			}

			$customers_for_mailchimp_sql = "select customers_for_mailchimp_email from t_customers_for_mailchimp where customers_for_mailchimp_email='" . $event_sql_query->fields['customers_email_address'] . "'";
			$customers_for_mailchimp_result = $db->Execute($customers_for_mailchimp_sql);
			$insert = 0;
			if($customers_for_mailchimp_result->RecordCount() > 1) {
				$insert = 1;
				$db->Execute("delete from t_customers_for_mailchimp where customers_for_mailchimp_email='" . $event_sql_query->fields['customers_email_address'] . "'");
			} else if($customers_for_mailchimp_result->RecordCount() == 1) {
				$insert = 0;
				$db->Execute("update t_customers_for_mailchimp set list_id='" . $event_sql_query->fields['list_id'] . "', languages_id=" . $languages_id . ", subscribe_status=" . $subscribe_status . ", last_modified=now(), date_created='" . $mailchimp_time . "' where customers_for_mailchimp_email='" . $event_sql_query->fields['customers_email_address'] . "'");
			} else {
				$insert = 1;
			}
			if($insert == 1) {
				$customers_info_result = $db->Execute("select customers_id, customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_email_address='" . $event_sql_query->fields['customers_email_address'] . "'");
				$customers_for_mailchimp_id = 0;
				$customers_firstname = $customers_lastname = "";
				if($customers_info_result->RecordCount() > 0) {
					$customers_for_mailchimp_id = $customers_info_result->fields['customers_id'];
					$customers_firstname = addslashes($customers_info_result->fields['customers_firstname']);
					$customers_lastname = addslashes($customers_info_result->fields['customers_lastname']);
				}
				$db->Execute("insert into t_customers_for_mailchimp (customers_for_mailchimp_email, customers_for_mailchimp_id, session_customers_id, session_customers_email_address, list_id, website_code, languages_id, subscribe_from, customers_firstname, customers_lastname, subscribe_status, browser_user_agent, ip_address, date_created) 
						values ('" . $event_sql_query->fields['customers_email_address'] . "', " . $customers_for_mailchimp_id . ", 0, '', '" .$event_sql_query->fields['list_id'] . "', '" . WEBSITE_CODE . "', '" . $languages_id . "', 999, '" . $customers_firstname . "', '" . $customers_lastname . "', '" . $subscribe_status . "', 'system', '127.0.0.1', '" . $mailchimp_time . "')");
			}
			
			$event_sql_query->MoveNext();
		}
	}
}


echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>