<?php
// BOF MIN ORDER AMOUNT
// check order total minimum
if(substr($_GET['main_page'], 0, 8) == 'checkout')  {
  if ($_SESSION['cart']->total < MIN_ORDER_AMOUNT) {
    zen_redirect(zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'));
  }
}

?>