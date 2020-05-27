<?php
  chdir("../");
  require ("includes/application_top.php");
  $customer_dropper_id_sql = " select prometers_commission_id,customers_dropper_id,paypal,payment_method from " . TABLE_PROMETERS_COMMISSION ;
  $customers_dropper_id_res = $db->Execute($customer_dropper_id_sql);
  $customers_dropper_id = $customers_dropper_id_res->fields['customers_dropper_id'];
  if($customers_dropper_id_res->RecordCount() > 0){
  	while ( ! $customers_dropper_id_res->EOF ) {
	   	

	       $customers_method [$customers_dropper_id_res->fields ['prometers_commission_id']] = array (
   	            'customers_dropper_id' => $customers_dropper_id_res->fields ['customers_dropper_id'],
   	            'payment_method' =>$customers_dropper_id_res->fields['payment_method'],
   	            'paypal' => $customers_dropper_id_res->fields['paypal']
				
	  	   );
	     	$customers_dropper_id_res->MoveNext();
	    }
	    
  }
  foreach($customers_method as $val){
  	$db->Execute("insert into " . TABLE_PROMETERS_COMMISSION_INFO . "(customers_dropper_id,orders_pay_time,pay_time,payment_method,paypal,commission_status) values('".$val['customers_dropper_id']."',now(),date_add(NOW(), interval 1 MONTH),'".$val['payment_method'] ."','".$val['paypal']."',10)");
  }
 
?>