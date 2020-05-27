<?php

/**

 * paypal EC button display template

 *

 * @package paymentMethod

 * @copyright Copyright 2003-2007 Zen Cart Development Team

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: tpl_ec_button.php 6528 2007-06-25 23:25:27Z drbyte $

 */



$paypalec_enabled = (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True');

if ($paypalec_enabled && ($_SESSION['cart']->count_contents() > 0 && $_SESSION['cart']->total > 0)) {

    // If they're here, they're either about to go to PayPal or were

    // sent back by an error, so clear these session vars.

    unset($_SESSION['paypal_ec_temp']);

    unset($_SESSION['paypal_ec_token']);

    unset($_SESSION['paypal_ec_payer_id']);

    unset($_SESSION['paypal_ec_payer_info']);



    include DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/payment/paypalwpp.php';

?>

<div id="PPECbutton" class="buttonRow">

    <a href="

      <?php

         if($_SESSION['valid_to_checkout'] == false)

               echo zen_href_link(FILENAME_SHOPPING_CART); 

         else 

               echo zen_href_link('ipn_main_handler.php', 'type=ec', 'SSL', true, true, true); ?>"

    >

         <img src="<?php echo MODULE_PAYMENT_PAYPALWPP_EC_BUTTON_IMG ?>" alt="<?php echo MODULE_PAYMENT_PAYPALWPP_TEXT_BUTTON_ALTTEXT; ?>" />

     </a>

    

</div>

<?php

}

?>