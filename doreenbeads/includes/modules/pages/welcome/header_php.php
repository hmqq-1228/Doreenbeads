<?php 
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

if (!$_SESSION['customer_id']) {

  $_SESSION['navigation']->set_snapshot();

  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));

}
$breadcrumb->add(TEXT_HEADER_MY_ACCOUNT);

$r_products = get_new_arrival_products();
$currency_symbol_left = $currencies->currencies [$_SESSION ['currency']] ['symbol_left'];
$cVipInfo = getCustomerVipInfo ();
$total_all = $_SESSION ['cart']->show_total_new () - $cVipInfo ['amount'];
?>
