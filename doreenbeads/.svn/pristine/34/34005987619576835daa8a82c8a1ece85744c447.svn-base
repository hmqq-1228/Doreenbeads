<?php
chdir("../");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset($_GET['action']) && $_GET['action'] == 'synchronize'){
    $where = '';
    $max_synch_id = 0;

    $synch_ipn_id_query = $db->Execute('select synch_paypal_ipn_id, synch_datetime FROM ' . TABLE_PAYPAL_SYNCH_ID_RECORD . ' order by synch_paypal_ipn_id desc limit 1');

    if($synch_ipn_id_query->RecordCount() > 0){
        $max_paypal_ipn_id = $synch_ipn_id_query->fields['synch_paypal_ipn_id'];
        $max_synch_datetime = $synch_ipn_id_query->fields['synch_datetime'];

        $where = ' where paypal_ipn_id > "' . $max_paypal_ipn_id . '"';
    }else{
        $where = ' where date_added > "2019-04-01 00:00:00"';
    }

    if($where != ''){
        $paypal_info_query = $db->Execute('SELECT
                                                paypal_ipn_id,
                                                order_id,
                                                payer_email,
                                                payer_id
                                            FROM
                                                ' . TABLE_PAYPAL . '
                                                ' . $where .' order by paypal_ipn_id asc');

        while(!$paypal_info_query->EOF){
            $synch_paypal_id = $paypal_info_query->fields['paypal_ipn_id'];
            $orders_id = $paypal_info_query->fields['order_id'];

            $payer_email = $paypal_info_query->fields['payer_email'];
            $is_update = false;

            if($orders_id > 0){
                $order_info_query = $db->Execute('SELECT
                                                        customers_id,
                                                        customers_email_address,
                                                        payment_info
                                                    FROM
                                                        ' . TABLE_ORDERS . '
                                                    WHERE
                                                        orders_id = "' . $orders_id . '" limit 1');

                $customers_id = $order_info_query->fields['customers_id'];
                $customers_email = $order_info_query->fields['customers_email_address'];
                $payment_info = json_decode($order_info_query->fields['payment_info']);
                $payment_datetime = $payment_info->date_created;

                $synch_paypal_info_data = array(
                    'customers_id' => $customers_id,
                    'customers_email' => $customers_email,
                    'payer_account' => $payer_email,
                    'payment_datetime' => $payment_datetime
                );

                $check_customer_have_synch_query = $db->Execute('select customers_id from ' . TABLE_PAYPAL_SYNCH_DETAIL . ' where customers_id = "' . $customers_id . '"');

                if($check_customer_have_synch_query->RecordCount() > 0){
                    $is_update = true;
                    zen_db_perform(TABLE_PAYPAL_SYNCH_DETAIL, $synch_paypal_info_data, 'update', ' customers_id = "' . $customers_id . '"');
                }else{
                    zen_db_perform(TABLE_PAYPAL_SYNCH_DETAIL, $synch_paypal_info_data);
                }

                $synch_paypal_info_log_data = array(
                    'customers_id' => $customers_id,
                    'synch_status' => 10,
                    'add_datetime' => 'now()'
                );

                if($is_update){
                    zen_db_perform(TABLE_PAYPAL_SYNCH_LOG, $synch_paypal_info_log_data, 'update', ' customers_id = "' . $customers_id . '"');
                }else{
                    zen_db_perform(TABLE_PAYPAL_SYNCH_LOG, $synch_paypal_info_log_data);
                }
            }

            $paypal_info_query->MoveNext();
        }

        if($synch_paypal_id > 0){
            $synch_id_record_data = array(
                'synch_paypal_ipn_id' => $synch_paypal_id,
                'synch_datetime' => 'now()'
            );

            zen_db_perform(TABLE_PAYPAL_SYNCH_ID_RECORD, $synch_id_record_data);
        }

    }

}

echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>