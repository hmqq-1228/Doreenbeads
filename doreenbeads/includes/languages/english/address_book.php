<?php
require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_shipping.php');
define('NAVBAR_TITLE_1', 'My Account');
define('NAVBAR_TITLE_2', 'Address Book');
define('HEADING_TITLE', 'My Personal Address Book');
define('PRIMARY_ADDRESS_TITLE', 'Primary Address');
define('PRIMARY_ADDRESS_DESCRIPTION', 'This address is used as the pre-selected shipping and billing address for orders placed on this store.<br /><br />');
define('ADDRESS_BOOK_TITLE', 'Address Book Entries');
define('SHIPPING_ADDRESS_TITLE', 'Shipping Address');
define('PRIMARY_ADDRESS', '(primary address)');
define('TEXT_MAXIMUM_ENTRIES', 'A maximum of %s address book entries allowed.');

define('TEXT_PLEASEENTER_CHARLEAST', 'please enter %s characters at least.');
define('TEXT_PLEASEENTER_RIGHTSTATE', 'Please enter right state/province/region.');

define('TEXT_DEFAULT_SHIPPING_ADDRESS', 'Your Default Shipping Address');
define('TEXT_ADD_NEW_ADDRESS', 'Add a new address');
define('TEXT_NAME_REQUIRE_MINIMUM', 'your name requires a minimum of 2 characters');
?>
