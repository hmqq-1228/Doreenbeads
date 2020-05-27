<?php
/**
 * initialise currencies
 * see {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
 * @package initSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_currencies.php 2753 2005-12-31 19:17:17Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

//setcookie("zencurrency_code", 'USD', time() - 31536000, '/', '.' . BASE_SITE);

if(!isset($_COOKIE["zencurrency_code"])){		
  	    setcookie("zencurrency_code", LANGUAGE_CURRENCY, time() + 31536000,'/', '.' . BASE_SITE);
	}

if(isset($_SESSION['customer_id'])&&$_SESSION['customer_id']!=''){
	if (isset($_GET['currency'])){
		$currency_get = zen_db_prepare_input(trim(strtoupper($_GET['currency'])));
		$currency_query = $db->Execute('select currencies_id from ' . TABLE_CURRENCIES . ' where code = "' . $currency_get . '" limit 1');
		if ($currency_query->RecordCount() == 1){
			unset($_SESSION['currency_get_de']);
			setcookie("zencurrency_code", $currency_get, time() + 31536000,'/', '.' . BASE_SITE);
			$set_sqls="update  " .TABLE_CUSTOMERS. "  set currencies_preference = (select currencies_id from ".TABLE_CURRENCIES." where code='".$currency_get."') where customers_id=".$_SESSION['customer_id'];
			$db->Execute($set_sqls);
			if($_SESSION['languages_id']!=1){
				$_SESSION['currency_get_de']=true;
			}
			$_SESSION['currency']=$currency_get;
		}		    	
	}else{
		$get_sqls="select currencies_preference , code from  " .TABLE_CUSTOMERS. " c , ".TABLE_CURRENCIES." cu  where customers_id = ".$_SESSION["customer_id"]." and  c.currencies_preference=cu.currencies_id ";
	    $get_currency=$db->Execute($get_sqls);
		$selected_currency=$get_currency->fields["code"] != '' ? $get_currency->fields["code"] : LANGUAGE_CURRENCY;
		if($selected_currency=='USD'&&($_SESSION['languages_code']=='de'||$_SESSION['languages_code']=='fr')&&!isset($_SESSION['currency_get_de'])){
		 $_SESSION['currency']='EUR';
		}else{
		 $_SESSION['currency']=$selected_currency;	
		}		
	}	
}else{
	if (isset($_GET['currency'])){
		$currency_get = zen_db_prepare_input(trim(strtoupper($_GET['currency'])));
		$currency_query = $db->Execute('select currencies_id from ' . TABLE_CURRENCIES . ' where code = "' . $currency_get . '" limit 1');
		if ($currency_query->RecordCount() == 1){
	 		unset($_SESSION['currency_get']);
	 		if($_SESSION['languages_id']!=1){
	     		$_SESSION['currency_get']=true;
	     	}
			setcookie("zencurrency_code", $currency_get, time() + 31536000,'/', '.' . BASE_SITE);
			$_SESSION['currency']=$currency_get;
		}
	}else{
 		if($_COOKIE["zencurrency_code"]=='USD'&&($_SESSION['languages_code']=='de'||$_SESSION['languages_code']=='fr')&&!isset($_SESSION['currency_get'])){
 		 	$_SESSION['currency']='EUR';
 		}elseif($_COOKIE["zencurrency_code"]=='USD'&&$_SESSION['languages_code']=='ru'&&!isset($_SESSION['currency_get'])){
 			$_SESSION['currency']='RUB';
 		}else{
		 	$_SESSION['currency']=empty($_COOKIE["zencurrency_code"])?LANGUAGE_CURRENCY:$_COOKIE["zencurrency_code"];	
		}	
	}
}

?>