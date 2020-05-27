<?php
require ('includes/application_top.php');

if(isset($_POST['did']) && $_POST['did']){

  $sql = "update t_orders set display = 0 where orders_id = ".$_POST['did'];
	
  $result = $db->Execute($sql);
	
	if($result){
		$array = array('status'=>1,'content'=>'success');
		exit(json_encode($array));
	}
}