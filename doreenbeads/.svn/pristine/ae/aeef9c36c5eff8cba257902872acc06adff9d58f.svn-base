<?php
/*
*wei.liang 2011.10.12
*addwishilist.php
*本页面用于不刷新addwishilist
*/

	require('includes/application_top.php');
	$pid = intval($_POST['productid']);//产品ID
	$qty = $_POST['number'];//个数
	if(!$pid){
		echo "";exit;
	}

	if (isset($_SESSION['customer_id'])){		
		$check_product = $db->Execute("select wl_products_id from t_wishlist where wl_products_id = " . (int)$pid . " and wl_customers_id = " . (int)$_SESSION['customer_id']);
		if ($check_product->RecordCount() == 0){
			$db->Execute("insert into t_wishlist (wl_products_id, wl_customers_id, wl_product_num, wl_date_added)
			  			values (" . (int)$pid . ", " . (int)$_SESSION['customer_id'] . ", " . (int)$qty . ", '" . date('YmdHis') . "')");
			update_products_add_wishlist(intval($pid));
			$check_product_wishli_num = $db->Execute("select count(wl_products_id) as wishicount from ".TABLE_WISH." where  wl_customers_id = " . (int)$_SESSION['customer_id']." limit 1");
			echo 3;//成功
			echo "|";
			echo  $check_product_wishli_num->fields["wishicount"];
		}else{
			echo 2;//已经存在
		}
	}
	else{
		if(!empty($_SERVER['HTTP_REFERER']) || !empty($_GET['redirect_url'])){
			$refer_url = $_GET['redirect_url'] ? urldecode($_GET['redirect_url']) : $_SERVER['HTTP_REFERER'];
			$refer_url = $refer_url . (preg_match('/^(.*)-p-(.*).html$/', $refer_url) && $_GET['click'] == 'write_reviews' ? '#reviewcontent' : '');
		    $_SESSION['redirect_url_after_login'] = $refer_url;
		}
		echo 1;//没有登录
	}
	
	

?>
