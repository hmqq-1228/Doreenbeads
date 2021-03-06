<?php
@setlocale ( LC_TIME, 'en_US.utf8');
define('DATE_FORMAT_SHORT', '%m/%d/%Y'); // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

if (! function_exists('zen_date_raw')) {
	function zen_date_raw($date, $reverse = false) {
		if ($reverse) {
			return substr ( $date, 3, 2 ) . substr ( $date, 0, 2 ) . substr ( $date, 6, 4 );
		} else {
			return substr ( $date, 6, 4 ) . substr ( $date, 0, 2 ) . substr ( $date, 3, 2 );
		}
	}
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead
// of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'USD');

// Global entries for the <html> tag
define('HTML_PARAMS', 'dir="ltr" lang="en"');
define('TEXT_QUESEMAIL_NAME', 'Customer’s Name');
// charset for web pages and emails
define('CHARSET', 'utf-8');

define('TEXT_TEL_NUMBER', '(+86) 579-85335690');

// Define the name of your Gift Certificate as Gift Voucher, Gift Certificate,
// Zen Cart Dollars, etc. here for use through out the shop
define('TEXT_GV_NAME', 'Gift Certificate');
define('TEXT_GV_NAMES', 'Gift Certificates');

// used for redeem code, redemption code, or redemption id
define('TEXT_GV_REDEEM', 'Redemption Code');

// used for redeem code sidebox
define('BOX_HEADING_GV_REDEEM', TEXT_GV_NAME );
define('BOX_GV_REDEEM_INFO', 'Redemption code: ');
define('TEXT_TIME','Time');
define('DISCRIPTION', 'Description');
define('TEXT_CREATE_MEMO','Memo');
define('TEXT_NO_WATERMARK_PICTURE', 'Non-watermarked Pictures Service');
define('CHECKOUT_ZIP_CODE_ERROR', 'Please check your zip code, the correct format is as follows:');
define('TEXT_OR', 'or');
// text for gender
define('MALE', 'Mr.');
define('FEMALE', 'Ms.');
define('TEXT_MALE','Male');
define('TEXT_FEMALE','Female');
define('MALE_ADDRESS', 'Mr.');
define('FEMALE_ADDRESS', 'Ms.');

// text for date of birth example
define('DOB_FORMAT_STRING', 'mm/dd/yyyy');

// text for sidebox heading links
define('BOX_HEADING_LINKS', '');

// categories box text in sideboxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Categories');

// manufacturers box text in sideboxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Manufacturers');
define('HEADER_TITLE_PACKING_SLIP', 'Packing Slip');

// whats_new box text in sideboxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'New Products');
define('CATEGORIES_BOX_HEADING_WHATS_NEW', 'New Products ...');

define('BOX_HEADING_FEATURED_PRODUCTS', 'Featured');
define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', 'Featured Products ...');
define('TEXT_NO_FEATURED_PRODUCTS', 'More featured products will be added soon. Please check back later.');

define('TEXT_NO_ALL_PRODUCTS', 'More products will be added soon. Please check back later.');
define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', 'All Products ...');

// quick_find box text in sideboxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Search');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Advanced Search');

// specials box text in sideboxes/specials.php
define('BOX_HEADING_SPECIALS', 'Specials');
define('CATEGORIES_BOX_HEADING_SPECIALS', 'Specials ...');

// reviews box text in sideboxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Reviews');
define('BOX_REVIEWS_WRITE_REVIEW', 'Write a review on this product.');
define('BOX_REVIEWS_NO_REVIEWS', 'There are currently no product reviews.');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s of 5 Stars!');

// shopping_cart box text in sideboxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Shopping Cart');
define('BOX_SHOPPING_CART_EMPTY', 'Your cart is empty.');
define('BOX_SHOPPING_CART_DIVIDER', 'ea.-&nbsp;');

// order_history box text in sideboxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Quick Re-Order');

define('TEXT_PROMOTION', 'Promotion');

// best_sellers box text in sideboxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Bestsellers');
define('BOX_HEADING_BESTSELLERS_IN', 'Bestsellers in<br />&nbsp;&nbsp;');

// notifications box text in sideboxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Notifications');
define('BOX_NOTIFICATIONS_NOTIFY', 'Notify me of updates to <strong>%s</strong>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Do not notify me of updates to <strong>%s</strong>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Manufacturer Info');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Other products');

// languages box text in sideboxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Languages');

// currencies box text in sideboxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Currencies');

// information box text in sideboxes/information.php
define('BOX_HEADING_INFORMATION', 'Information');
define('BOX_INFORMATION_PRIVACY', 'Privacy Notice');
define('BOX_INFORMATION_CONDITIONS', 'Conditions of Use');
define('BOX_INFORMATION_SHIPPING', 'Shipping &amp; Returns');
define('BOX_INFORMATION_CONTACT', 'Contact Us');
define('BOX_BBINDEX', 'Forum');
define('BOX_INFORMATION_UNSUBSCRIBE', 'Newsletter Unsubscribe');

define('BOX_INFORMATION_SITE_MAP', 'Site Map');

// information box text in sideboxes/more_information.php - were TUTORIAL_
define('BOX_HEADING_MORE_INFORMATION', 'More Information');
define('BOX_INFORMATION_PAGE_2', 'Page 2');
define('BOX_INFORMATION_PAGE_3', 'Page 3');
define('BOX_INFORMATION_PAGE_4', 'Page 4');

// tell a friend box text in sideboxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Tell A Friend');
define('BOX_TELL_A_FRIEND_TEXT', 'Tell someone you know about this product.');

// wishlist box text in includes/boxes/wishlist.php
define('BOX_HEADING_CUSTOMER_WISHLIST', 'My Wishlist');
define('BOX_WISHLIST_EMPTY', 'You have no items on your Wishlist');
define('IMAGE_BUTTON_ADD_WISHLIST', 'Add to Wishlist');
define('TEXT_MOVE_TO_WISHLIST', 'Move to wishlist');
define('TEXT_WISHLIST_COUNT', 'Currently %s items are on your Wishlist.');
define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> items on your wishlist)');

// New billing address text
define('SET_AS_PRIMARY', 'Set as Primary Address');
define('NEW_ADDRESS_TITLE', 'Billing Address');

// javascript messages
define('JS_ERROR', 'Errors have occurred during the processing of your form.\n\nPlease make the following corrections:\n\n');

define('JS_REVIEW_TEXT', '* Please add a few more words to your comments. The review needs to have at least ' . REVIEW_TEXT_MIN_LENGTH . ' characters.');
define('JS_REVIEW_RATING', '* Please choose a rating for this item.');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Please select a payment method for your order.');

define('JS_ERROR_SUBMITTED', 'This form has already been submitted. Please press OK and wait for this process to be completed.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Please select a payment method for your order.');
define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Please confirm the terms and conditions bound to this order by ticking the box below.');
define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', 'Please confirm the privacy statement by ticking the box below.');

define('CATEGORY_COMPANY', 'Company Details');
define('CATEGORY_PERSONAL', 'Your Personal Details');
define('CATEGORY_ADDRESS', 'Your Address');
define('CATEGORY_CONTACT', 'Your Contact Information');
define('CATEGORY_OPTIONS', 'Options');
define('CATEGORY_PASSWORD', 'Your Password');
define('CATEGORY_LOGIN', 'Login');
define ( 'CREATE_NEW_ACCOUNT', 'Create New Account' );
define('PULL_DOWN_DEFAULT', 'Please Choose Your Country');
define('PLEASE_SELECT', 'Please select ...');
define('TYPE_BELOW', 'Type a choice below ...');

define('TEXT_NEW_CUSTOMER','New Customer');
define('TEXT_RETURN_CUSTOMER','Return Customer');
define('TEXT_PLACEHOLDER1','Enter your email or telephone number');
define('TEXT_PLACEHOLDER2','Enter your paypal account');
define('ENTRY_COMPANY', 'Company Name:');
define('ENTRY_COMPANY_ERROR', 'Please enter a company name.');
define('ENTRY_COMPANY_TEXT', '');
//define('ENTRY_GENDER', 'Salutation:');
define('ENTRY_GENDER', 'Gender:');
define('ENTRY_GENDER_ERROR', 'Please choose a salutation.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'First Name:');
define('ENTRY_FIRST_NAME_ERROR', 'Please enter your first name(at least 1 character).');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Last Name:');
define('ENTRY_LAST_NAME_ERROR', 'Please enter your last name(at least 1 character).');
define('ENTRY_FL_NAME_SAME_ERROR', 'The Last Name is the same as the First Name. Please change it.'); 
/*address line 1 2 same error*/
define('ENTRY_FS_ADDRESS_SAME_ERROR','We noticed that your address Line 2 is the same as Address Line 1，please rewrite the Address Line 2 or just leave it empty.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Date of Birth:');

define('ENTRY_DATE_OF_BIRTH_ERROR', 'The entire date of birth (Year-Month-Day) is required for registration');
define('ENTRY_DATE_OF_BIRTH_TEXT', '*');
define('ENTRY_EMAIL_ADDRESS', 'Email Address');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Is your email address correct? It should contain at least ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' characters. Please try again.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Sorry, my system does not understand your email address. Please try again.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Our system already has a record of that email address - please try logging in with that email address. If you do not use that address any longer you can correct it in the My Account area.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS_MOBILE', 'The email address is in our records - please <a href="'.zen_href_link(FILENAME_LOGIN).'">Login</a> directly.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_NICK', 'Forum Nick Name:');
define('ENTRY_NICK_TEXT', '*'); // note to display beside nickname input
                                   // field
define('ENTRY_NICK_DUPLICATE_ERROR', 'That Nick Name is already being used. Please try another.');
define('ENTRY_NICK_LENGTH_ERROR', 'Please try again. Your Nick Name must contain at least ' . ENTRY_NICK_MIN_LENGTH . ' characters.');
define('ENTRY_STREET_ADDRESS', 'Street Address:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Your Street Address must contain a minimum of ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Address Line 2:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Zip/Postal Code:');
define('ENTRY_POST_CODE_ERROR', 'Your Post/ZIP Code must contain a minimum of ' . ENTRY_POSTCODE_MIN_LENGTH . ' characters.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'City:');
define('ENTRY_CUSTOMERS_REFERRAL', 'Referral Code:');

define('ENTRY_CITY_ERROR', 'Your City must contain a minimum of ' . ENTRY_CITY_MIN_LENGTH . ' characters.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'State/Province:');
define('ENTRY_STATE_ERROR', 'Your State must contain a minimum of ' . ENTRY_STATE_MIN_LENGTH . ' characters.');
define('ENTRY_STATE_ERROR_SELECT', 'Please select a state from the States pull down menu.');
define('ENTRY_EXISTS_ERROR', 'This address already exists.');
define('ENTRY_STATE_TEXT', '*');
define('JS_STATE_SELECT', '-- Please Choose --');
define('ENTRY_COUNTRY', 'Country:');
define('ENTRY_COUNTRY_ERROR', 'You must select a country from the Countries pull down menu.');
define('ENTRY_AGREEN_ERROR_SELECT', 'You do not agree Doreenbeads.com <a href="page.html?id=137" target="_blank" style="color:#900;text-decoration:underline">Terms and Conditions</a>');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_PUERTORICO_ERROR', 'You must select "Puerto Rico" from the Countries pull down menu as country,for your state is "Puerto Rico".');
define('ENTRY_TELEPHONE_NUMBER', 'Telephone:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Your Telephone Number must contain a minimum of ' . ENTRY_TELEPHONE_MIN_LENGTH . ' characters.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Fax Number:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Subscribe to Our Newsletter.');
define('ENTRY_NEWSLETTER_TEXT', 'Subscribe');
define('ENTRY_NEWSLETTER_YES', 'Subscribed');
define('ENTRY_NEWSLETTER_NO', 'Unsubscribed');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Password:');
define('ENTRY_PASSWORD_ERROR', 'This should be at least ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters (must contain letters and numbers).');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'The Password Confirmation must match your Password.');
define('ENTRY_PASSWORD_TEXT', '* (at least ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters)');
define('ENTRY_PASSWORD_CONFIRMATION', 'Confirm Password:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Current Password:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Your Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW', 'New Password:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Your new Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'The Password Confirmation must match your new Password.');
define('PASSWORD_HIDDEN', '--HIDDEN--');

define('FORM_REQUIRED_INFORMATION', '* Required information');
define('ENTRY_REQUIRED_SYMBOL', '*');

// constants for use in zen_prev_next_display function
define('TEXT_RESULT_PAGE', '');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> products)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> orders)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> reviews)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> new products)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> specials)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> featured products)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> products)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'First Page');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Previous Page');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Next Page');
define('PREVNEXT_TITLE_LAST_PAGE', 'Last Page');
define('PREVNEXT_TITLE_PAGE_NO', 'Page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Previous Set of %d Pages');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next Set of %d Pages');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;FIRST');
define('PREVNEXT_BUTTON_PREV', '[<< Prev]');
define('PREVNEXT_BUTTON_NEXT', '[Next >>]');
define('PREVNEXT_BUTTON_LAST', 'LAST>>');
define('PREVNEXT_BUTTON_NEXT_NEW', 'Next');

define('TEXT_BASE_PRICE', 'Starting at: ');

define('TEXT_CLICK_TO_ENLARGE', 'larger image');

define('TEXT_SORT_PRODUCTS', 'Sort products ');
define('TEXT_DESCENDINGLY', 'descendingly');
define('TEXT_ASCENDINGLY', 'ascendingly');
define('TEXT_BY', ' by ');

define('TEXT_REVIEW_BY', ' %s');
define('TEXT_REVIEW_WORD_COUNT', '%s words');
define('TEXT_REVIEW_RATING', 'Rating: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date Added: %s');
define('TEXT_NO_REVIEWS', 'There are currently no product reviews.');

define('TEXT_NO_NEW_PRODUCTS', 'Sorry，no product was found. You could try to filter by other conditions.');

define('TEXT_UNKNOWN_TAX_RATE', 'Sales Tax');

define('TEXT_REQUIRED', '<span class="errorText">Required</span>');

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warning: Installation directory exists at: %s. Please remove this directory for security reasons.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: I am able to write to the configuration file: %s. This is a potential security risk - please set the right user permissions on this file (read-only, CHMOD 644 or 444 are typical). You may need to use your webhost control panel/file-manager to change the permissions effectively. Contact your webhost for assistance. <a href="http://tutorials.zen-cart.com/index.php?article=90" target="_blank">See this FAQ</a>');
define('ERROR_FILE_NOT_REMOVEABLE', 'Error: Could not remove the file specified. You may have to use FTP to remove the file, due to a server-permissions configuration limitation.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warning: The sessions directory does not exist: ' . zen_session_save_path () . '. Sessions will not work until this directory is created.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the sessions directory: ' . zen_session_save_path () . '. Sessions will not work until the right user permissions are set.');
define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is enabled - please disable this PHP feature in php.ini and restart the web server.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: The downloadable products directory does not exist: ' . DIR_FS_DOWNLOAD . '. Downloadable products will not work until this directory is valid.');
define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT', 'Warning: The SQL cache directory does not exist: ' . DIR_FS_SQL_CACHE . '. SQL caching will not work until this directory is created.');
define('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the SQL cache directory: ' . DIR_FS_SQL_CACHE . '. SQL caching will not work until the right user permissions are set.');
define('WARNING_DATABASE_VERSION_OUT_OF_DATE', 'Your database appears to need patching to a higher level. See Admin->Tools->Server Information to review patch levels.');
define('WARNING_COULD_NOT_LOCATE_LANG_FILE', 'WARNING: Could not locate language file: ');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'The expiration date entered for the credit card is invalid. Please check the date and try again.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'The credit card number entered is invalid. Please check the number and try again.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'The credit card number starting with %s was not entered correctly, or we do not accept that kind of card. Please try again or use another credit card.');

define('BOX_INFORMATION_DISCOUNT_COUPONS', 'Discount Coupons');
define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' FAQ');
define('VOUCHER_BALANCE', TEXT_GV_NAME . ' Balance ');
define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' Account');
define('GV_FAQ', TEXT_GV_NAME . ' FAQ');
define('ERROR_REDEEMED_AMOUNT', 'Congratulations, you have redeemed ');
define('ERROR_NO_REDEEM_CODE', 'You did not enter a ' . TEXT_GV_REDEEM . '.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Invalid ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM );
define('TABLE_HEADING_CREDIT', 'Credits Available');
define('GV_HAS_VOUCHERA', 'You have funds in your ' . TEXT_GV_NAME . ' Account. If you want <br />you can send those funds by <a class="pageResults" href="');

define('GV_HAS_VOUCHERB', '"><strong>email</strong></a> to someone');
define('ENTRY_AMOUNT_CHECK_ERROR', 'You do not have enough funds to send this amount.');
define('BOX_SEND_TO_FRIEND', 'Send ' . TEXT_GV_NAME . ' ');

define('VOUCHER_REDEEMED', TEXT_GV_NAME . ' Redeemed');
define('CART_COUPON', 'Coupon :');
define('CART_COUPON_INFO', 'more info');
define('TEXT_SEND_OR_SPEND', 'You have a balance available in your ' . TEXT_GV_NAME . ' account. You may spend it or send it to someone else. To send click the button below.');
define('TEXT_BALANCE_IS', 'Your ' . TEXT_GV_NAME . ' balance is: ');
define('TEXT_AVAILABLE_BALANCE', 'Your ' . TEXT_GV_NAME . ' Account');

define('TABLE_HEADING_PAYMENT_METHOD', 'Payment Method');
// payment method is GV/Discount
define('PAYMENT_METHOD_GV', 'Gift Certificate/Coupon');
define('PAYMENT_MODULE_GV', 'GV/DC');

define('TABLE_HEADING_CREDIT_PAYMENT', 'Credits Available');

define('TEXT_INVALID_REDEEM_COUPON', 'Invalid Coupon Code');
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', 'You must spend at least %s to redeem this coupon');
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM_1', '%s coupon will avialable to use when your order amount reach %s.');
define('TEXT_INVALID_STARTDATE_COUPON', 'This coupon is not available yet');
define('TEXT_INVALID_FINISHDATE_COUPON', 'This coupon has expired');
define('TEXT_INVALID_USES_COUPON', 'This coupon could only be used ');
define('TIMES', ' times.');
define('TIME', ' time.');
define('TEXT_INVALID_USES_USER_COUPON', 'You have used coupon code: %s the maximum number of times allowed per customer. ');
define('REDEEMED_COUPON', 'a coupon worth ');
define('REDEEMED_MIN_ORDER', 'on orders over ');
define('REDEEMED_RESTRICTIONS', ' [Product-Category restrictions apply]');
define('TEXT_ERROR', 'An error has occurred');
define('TEXT_INVALID_COUPON_PRODUCT', 'This coupon code is not valid for any product currently in your cart.');
define('TEXT_VALID_COUPON', 'Congratulations you have redeemed the Discount Coupon');
define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'The coupon code you entered is not valid for the address you have selected.');

// more info in place of buy now
define('MORE_INFO_TEXT', '... more info');

// IP Address
define('TEXT_YOUR_IP_ADDRESS', 'Your IP Address is:');

// Generic Address Heading
define('HEADING_ADDRESS_INFORMATION', 'Address Information');

// cart contents
define('PRODUCTS_ORDER_QTY_TEXT_IN_CART', 'Quantity in Cart: ');
define('PRODUCTS_ORDER_QTY_TEXT', 'Add to Cart: ');

define('TEXT_PRODUCT_WEIGHT_UNIT', 'grams');

// Shipping
// jessa 2009-08-11
// update define('TEXT_SHIPPING_WEIGHT','lbs');
define('TEXT_SHIPPING_WEIGHT', 'grams');
define('TEXT_SHIPPING_BOXES', 'Boxes');
// eof jessa

// Discount Savings
define('PRODUCT_PRICE_DISCOUNT_PREFIX', 'Save: ');
define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE', '% off');
define('PRODUCT_PRICE_DISCOUNT_AMOUNT', ' off');

// Sale Maker Sale Price
define('PRODUCT_PRICE_SALE', 'Sale:&nbsp;');

// universal symbols
define('TEXT_NUMBER_SYMBOL', '# ');

// banner_box
define('BOX_HEADING_BANNER_BOX', 'Sponsors');
define('TEXT_BANNER_BOX', 'Please Visit Our Sponsors ...');

// banner box 2
define('BOX_HEADING_BANNER_BOX2', 'Have you seen ...');
define('TEXT_BANNER_BOX2', 'Check this out today!');

// banner_box - all
define('BOX_HEADING_BANNER_BOX_ALL', 'Sponsors');
define('TEXT_BANNER_BOX_ALL', 'Please Visit Our Sponsors ...');

// boxes defines
define('PULL_DOWN_ALL', 'Please Select');
define('PULL_DOWN_MANUFACTURERS', '- Reset -');
// shipping estimator
define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', 'Please Select');

// general Sort By
define('TEXT_INFO_SORT_BY', 'Sort by: ');

// close window image popups
define('TEXT_CLOSE_WINDOW', ' - Click Image to Close');
// close popups
define('TEXT_CURRENT_CLOSE_WINDOW', '[ Close Window ]');

// iii 031104 added: File upload error strings
define('ERROR_FILETYPE_NOT_ALLOWED', 'Error:  File type not allowed.');
define('WARNING_NO_FILE_UPLOADED', 'Warning:  no file uploaded.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Success:  file saved successfully.');
define('ERROR_FILE_NOT_SAVED', 'Error:  File not saved.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Error:  destination not writeable.');
define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Error: destination does not exist.');
define('ERROR_FILE_TOO_BIG', 'Warning: File was too large to upload!<br />Order can be placed but please contact the site for help with upload');
// End iii added

define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'NOTICE: This website is scheduled to be down for maintenance on: ');
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'NOTICE: The website is currently Down For Maintenance to the public');

define('PRODUCTS_PRICE_IS_FREE_TEXT', 'It’s Free!');
define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT', 'Call for Price');
define('TEXT_CALL_FOR_PRICE', 'Call for price');

define('TEXT_INVALID_SELECTION', ' You picked an Invalid Selection: ');
define('TEXT_ERROR_OPTION_FOR', ' On the Option for: ');
define('TEXT_INVALID_USER_INPUT', 'User Input Required<br />');

// product_listing
define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING', 'Min: ');
define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING', 'Units: ');
define('PRODUCTS_QUANTITY_IN_CART_LISTING', 'In cart:');
define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING', 'Add Additional:');

define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING', 'Max:');

define('TEXT_PRODUCTS_MIX_OFF', '*Mixed OFF');
define('TEXT_PRODUCTS_MIX_ON', '*Mixed ON');

define('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART', '<br />*You can not mix the options on this item to meet the minimum quantity requirement.*<br />');
define('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART', '*Mixed Option Values is ON<br />');

define('ERROR_MAXIMUM_QTY', 'The quantity added to your cart has been adjusted because of a restriction on maximum you are allowed. See this item: ');
define('ERROR_CORRECTIONS_HEADING', 'Please correct the following: <br />');
define('ERROR_QUANTITY_ADJUSTED', 'The quantity added to your cart has been adjusted. The item you wanted is not available in fractional quantities. The quantity of item: ');
define('ERROR_QUANTITY_CHANGED_FROM', ', has been changed from: ');
define('ERROR_QUANTITY_CHANGED_TO', ' to ');

// Downloads Controller
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG', 'NOTE: Downloads are not available until payment has been confirmed');
define('TEXT_FILESIZE_BYTES', ' bytes');
define('TEXT_FILESIZE_MEGS', ' MB');

// shopping cart errors
define('ERROR_PRODUCT', 'The Item: ');
define('ERROR_PRODUCT_STATUS_SHOPPING_CART', '<br />We are sorry but this product has been removed from our inventory at this time.<br />This item has been removed from your shopping cart.');
define('ERROR_PRODUCT_QUANTITY_MIN', ' ... Minimum Quantity errors - ');
define('ERROR_PRODUCT_QUANTITY_UNITS', ' ... Quantity Units errors - ');
define('ERROR_PRODUCT_OPTION_SELECTION', '<br /> ... Invalid Option Values Selected ');
define('ERROR_PRODUCT_QUANTITY_ORDERED', '<br /> You ordered a total of: ');
define('ERROR_PRODUCT_QUANTITY_MAX', ' ... Maximum Quantity errors - ');
define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART', ', has a minimum quantity restriction. ');
define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART', ' ... Quantity Units errors - ');
define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART', ' ... Maximum Quantity errors - ');

define('WARNING_SHOPPING_CART_COMBINED', 'NOTICE: You will check out all items in this shopping cart, which has been combined with the items you added previously. So please review your shopping cart before checking out.');

// error on checkout when $_SESSION['customers_id' does not exist in customers
// table
define('ERROR_CUSTOMERS_ID_INVALID', 'Customer information cannot be validated!<br />Please login or recreate your account ...');

define('TABLE_HEADING_FEATURED_PRODUCTS', '<a href="featured_products.html" id="featured_products">Featured Products</a>');

define('TABLE_HEADING_NEW_PRODUCTS', '<a href="products_new.html" id="products_new">New Products For %s</a>');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Upcoming Products');
define('TABLE_HEADING_DATE_EXPECTED', 'Date Expected');
// define('TABLE_HEADING_SPECIALS_INDEX', '<a href="specials.html"
// id="specials">Monthly Specials For %s</a>');
define('TABLE_HEADING_SPECIALS_INDEX', '<a href="https://www.doreenbeads.com/40-off-huge-discounts-c-1375.html" id="specials">Exclusive Huge Discounts</a>');
define('CAPTION_UPCOMING_PRODUCTS', 'These items will be in stock soon');
define('SUMMARY_TABLE_UPCOMING_PRODUCTS', 'table contains a list of products that are due to be in stock soon and the dates the items are expected');

// meta tags special defines
define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT', 'It’s Free!');

// customer login
define('TEXT_SHOWCASE_ONLY', 'Contact Us');
// set for login for prices
define('TEXT_LOGIN_FOR_PRICE_PRICE', 'Price Unavailable');
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE', 'Login for price');
// set for show room only
define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or
                                                      // enter
                                                      // your own text
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM', 'Show Room Only');

// authorization pending
define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Price Unavailable');
define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'APPROVAL PENDING');
define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE', 'Login to Shop');

// text pricing
define('TEXT_CHARGES_WORD', 'Calculated Charge:');
define('TEXT_PER_WORD', '<br />Price per word: ');
define('TEXT_WORDS_FREE', ' Word(s) free ');
define('TEXT_CHARGES_LETTERS', 'Calculated Charge:');
define('TEXT_PER_LETTER', '<br />Price per letter: ');
define('TEXT_LETTERS_FREE', ' Letter(s) free ');
define('TEXT_ONETIME_CHARGES', '*onetime charges = ');
define('TEXT_ONETIME_CHARGES_EMAIL', "\t" . '*onetime charges = ');
define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'Option Quantity Discounts');
define('TABLE_ATTRIBUTES_QTY_PRICE_QTY', 'QTY');
define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE', 'PRICE');
define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'Option Quantity Discounts Onetime Charges');

// textarea attribute input fields
define('TEXT_MAXIMUM_CHARACTERS_ALLOWED', ' maximum characters allowed');
define('TEXT_REMAINING', 'remaining');

// Shipping Estimator
define('CART_SHIPPING_OPTIONS', 'Estimate Shipping Costs');
define('CART_SHIPPING_OPTIONS_LOGIN', 'Please <a href="' . zen_href_link ( FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Log In</span></a>, to display your personal shipping costs.');
define('CART_SHIPPING_METHOD_TEXT', 'Available Shipping Methods');
define('CART_SHIPPING_METHOD_RATES', 'Rates');
define('CART_SHIPPING_METHOD_TO', 'Ship to: ');
define('CART_SHIPPING_METHOD_TO_NOLOGIN', 'Ship to: <a href="' . zen_href_link ( FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Log In</span></a>');
define('CART_SHIPPING_METHOD_FREE_TEXT', 'Free Shipping');
define('CART_SHIPPING_METHOD_ALL_DOWNLOADS', '- Downloads');
define('CART_SHIPPING_METHOD_RECALCULATE', 'Recalculate');
define('CART_SHIPPING_METHOD_ZIP_REQUIRED', 'true');
define('CART_SHIPPING_METHOD_ADDRESS', 'Address:');
define('CART_OT', 'Total Cost Estimate:');
define('CART_OT_SHOW', 'true'); // set to false if you don't want order
                                   // totals
define('CART_ITEMS', 'Items in Cart: ');
define('CART_SELECT', 'Select');
define('ERROR_CART_UPDATE', '<strong>Please continue shopping...</strong><br/>');
define('IMAGE_BUTTON_UPDATE_CART', 'Update');
define('EMPTY_CART_TEXT_NO_QUOTE', 'Whoops! Your session has expired ... Please update your shopping cart for Shipping Quote ...');
define('CART_SHIPPING_QUOTE_CRITERIA', 'Shipping quotes are based on the address information you selected:');

// multiple product add to cart
define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
// moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as
// BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
define ( 'TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Qty Discounts Off Price(Unit: Pack)' );
define ( 'TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'Discount Price by Qty(Unit: Pack)' );
define ( 'TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Qty Discounts Off Price(Unit: Pack)' );
define ( 'TEXT_FOOTER_DISCOUNT_QUANTITIES', '* Discounts may vary based on options above' );
define ( 'TEXT_HEADER_DISCOUNTS_OFF', 'Qty Discounts Unavailable ...' );
// sort order titles for dropdowns
define('PULL_DOWN_ALL_RESET', '- RESET - ');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', 'Product Name');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', 'Product Name - desc');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', 'Price - low to high');
define('TEXT_INFO_SORT_BY_QTY_DATE', 'Stock - more to less');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', 'Price - high to low');
define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'Part No.');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', 'Date Added - New to Old');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', 'Date Added - Old to New');
// jessa 2009-12-16
define('TEXT_INFO_SORT_BY_PRODUCTS_ORDER', 'Sold - High to Low');
// eof jessa 2009-12-16
define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'Default Display');
define('TEXT_INFO_SORT_BY_BEST_MATCH', 'Best Match');
define('TEXT_INFO_SORT_BY_BEST_SELLERS', 'Best Seller');

// downloads module defines
define('TABLE_HEADING_DOWNLOAD_DATE', 'Link Expires');
define('TABLE_HEADING_DOWNLOAD_COUNT', 'Remaining');
define('HEADING_DOWNLOAD', 'To download your files click the download button and choose "Save to Disk" from the popup menu.');
define('TABLE_HEADING_DOWNLOAD_FILENAME', 'Filename');
define('TABLE_HEADING_PRODUCT_NAME', 'Item Name');
define('TABLE_HEADING_PRODECT_PRICE', 'Price');
define('TABLE_HEADING_PRODUCT_IMAGE', 'Product Image');
define('TABLE_HEADING_PRODUCT_MODEL', 'Part No.');
define('TABLE_HEADING_BYTE_SIZE', 'File Size');
define('TEXT_DOWNLOADS_UNLIMITED', 'Unlimited');
define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---');

// misc
define('COLON_SPACER', ':&nbsp;&nbsp;');

// table headings for cart display and upcoming products
define('TABLE_HEADING_QUANTITY', 'Qty.');
define('TABLE_HEADING_PRODUCTS', 'Item Name');
define('TABLE_HEADING_PRICE', 'Price');
define('TABLE_HEADING_IMAGE', 'Product Image');
define('TABLE_HEADING_MODEL', 'Part No.');
define('TABLE_HEADING_TOTAL', 'Grand Total');

// create account - login shared
define('TABLE_HEADING_PRIVACY_CONDITIONS', 'Privacy Statement');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', 'Please acknowledge you agree with our privacy statement by ticking the following box. The privacy statement can be read <a href="' . zen_href_link ( FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">here</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', 'I have read and agreed to your privacy statement.');
define('TABLE_HEADING_ADDRESS_DETAILS', 'Address Details');
define('TABLE_HEADING_PHONE_FAX_DETAILS', 'Additional Contact Details');
define('TABLE_HEADING_DATE_OF_BIRTH', 'Verify Your Age');
define('TABLE_HEADING_LOGIN_DETAILS', 'Login Details');
define('TABLE_HEADING_REFERRAL_DETAILS', 'Were You Referred to Us?');

define('ENTRY_EMAIL_PREFERENCE', 'Newsletter and Email Details');
define('ENTRY_EMAIL_HTML_DISPLAY', 'HTML');
define('ENTRY_EMAIL_TEXT_DISPLAY', 'TEXT-Only');
define('EMAIL_SEND_FAILED', 'ERROR: Failed sending email to: "%s" <%s> with subject: "%s"');

define('DB_ERROR_NOT_CONNECTED', 'Error - Could not connect to Database');

// account
define('TEXT_TRANSACTIONS', 'Transactions');
define('TEXT_ORDER_STATUS_PENDING', 'Pending');
define('TEXT_ALL_ORDERS', 'All Orders');
define('TEXT_MY_ORDERS', 'My Orders');
define('TEXT_ORDER_STATUS_PROCESSING', 'Processing');
define('TEXT_ORDER_STATUS_SHIPPED', 'Shipped');
define('TEXT_UPDATE', 'Update');
define('TEXT_ORDER_CANCELED', 'Canceled');
define('TEXT_ORDER_STATUS_UPDATE', 'Update');
define('TEXT_DELIVERED', 'Delivered');
define('TEXT_ORDER_STATUS_CANCELLED', 'Canceled');
define('TEXT_ORDER_HISTORY', 'History');
define('TEXT_LATESTS', 'Latest News');
define('TEXT_PACKAGE_NUMBER', 'Package Number');
define('TEXT_RESULT_COST', 'Result cost');
define('TEXT_ACCOUNT_SERVICE', 'Account Service');
define('TEXT_MY_TICKETS', 'System Messages');
define('TEXT_DOWNLOAD_PRICTURES', 'Download Prictures');
define('TEXT_ADDRESS_BOOK', 'Address Book');
define('TEXT_ACCOUNT_SETTING', 'Account Setting');
define('TEXT_ACCOUNT_INFORMATION', 'Account Setting');
define('TEXT_ACCOUNT_PASSWORD', 'Account Password');
define('TEXT_CASH_ACOUNT', 'Credit Account');
define('TEXT_BLANCE', 'Balance');
define('TEXT_EMAIL_NOTIFICATIONS', 'Email Notifications');
define('TEXT_MODIFY_SUBSCRITION', 'Modify subscription');
define('TEXT_AFFILIATE_PROGRAM', 'Affiliate Program');
define('TEXT_MY_COMMISSION', 'My Commission');
define('TEXT_SETTING', 'Setting');
define('TEXT_REQUIRED_FIELDS', 'Indicates required fields');
define('TEXT_PRODUCTS_NOTIFICATION', 'Product notification');
define('ENTRY_SUBURB1', 'Address Line 1:');
define('TEXT_MAKE_PAYMENT', 'Make Payment');
define('TEXT_CART_MOVE_WISHLIST', 'Move Selected to Wishlist');
define('TEXT_PAYMENT_QUICK_PEORDER', 'Quick Reorder ');
define('TEXT_PAYMENT_ORDER_INQUIRY', '<a href="mailto:sale@doreenbeads.com">Order Inquiry</a>');
define('TEXT_PAYMENT_TRACK_INFO', 'Tracking Info');
define('TEXT_ACTION', 'Actions');
define('PRODUCTS_QUICK_ORDER_BY_NO', 'Quick Add Products');

// EZ-PAGES Alerts
define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'WARNING: EZ-PAGES HEADER - On for Admin IP Only');
define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'WARNING: EZ-PAGES FOOTER - On for Admin IP Only');
define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'WARNING: EZ-PAGES SIDEBOX - On for Admin IP Only');

// extra product listing sorter
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Items starting with ...');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- Reset --');

define('TEXT_INPUT_RIGHT_CODE', 'please input right validate code!');
define('BOX_HEADING_PACKING_SERVICE', 'Packing Service');
define('TEXT_PACKING_SERVICE_CONTENT', 'We offer you packing and processing service to meet your demands for any special packages or customized items.');
define('TEXT_PRODUCT_DETAILS', 'View Details');
define('TEXT_HEADER_MORE', 'More');
define('TEXT_HEADER_CLEARANCE', 'Clearance');
define('TEXT_CLEARANCE', 'Clearance');
define('TEXT_NO_PRODUCTS_IN_CLEARANCE', 'There is no product in clearance');
define('TEXT_CLEARANCE_CATE_HREF', 'View All %s ');
define('TEXT_HEADER_TOP_SELLER', 'Top Seller');

define('TEXT_TRUSTBOX_WIDGET_CONTENT', '<!-- TrustBox widget - Micro Review Count -->
<div style="left: -25px;position: relative;height: 10px;" class="trustpilot-widget" data-locale="en-US" data-template-id="5419b6a8b0d04a076446a9ad" data-businessunit-id="5742c0810000ff00058d3c5b" data-style-height="50px" data-style-width="100%" data-theme="light">
<a href="https://www.trustpilot.com/review/doreenbeads.com" target="_blank">Trustpilot</a>
</div>
<!-- End TrustBox widget -->');

define('TEXT_PRODUCT_IMAGE', 'Product Image');
define('TEXT_ITEM_NAMES', 'Item Name');
define('TEXT_PRICE_WORDS', 'Price');
define('TEXT_WEIGHT_WORDS', 'Weight:');
define('TEXT_ADD_WORDS', 'Add:');
define('TEXT_NO_PRODUCTS_IN_CLEARANCE', 'There is no product in clearance');

define('TEXT_DHL_REMOTE_FEE', '%s remote fee via DHL express is needed, EMS is not reachable to your adress!');
define('TEXT_WIN_POP_TITLE', '');
define('TEXT_WIN_POP_NOTICE', '');

define('NOTE_CHECKOUT_SHIPPING_AIRMAIL', 'Please read this important note >>');
define('NOTE_CHECKOUT_SHIPPING_AIRMAIL_CONTENT', 'A. Due to The eighteenth National Congress of the Communist Party of China, parcels via air mail may be delayed for certain days. We are very sorry about this. If items are need urgently, please kindly choose another shipping methods. <br>B. If your order contains watches, please kindly choose other kind of shipping method since custom do very strict check on all airmail parcel, it is not permitted to ship watches.<br><br>For more information, contact us at<a href=mailto:sale@doreenbeads.com> sale@doreenbeads.com</a>.');

// account add items 2013-4-12
define('TEXT_ACCOUNT_SET', 'Account Setting');
define('TEXT_PROFILE_SET', 'Profile Setting');
define('TEXT_CHANGE_PASSWORD', 'Change the Password');
define('TEXT_CHANGE_EMAIL', 'Change Email Address');
define('TEXT_AVARTAR', 'Avatar:');
define('TEXT_UPLOAD_FOR_CHECKING', 'Upload successfully, please wait for review.');
define('ENTRY_YOUR_BUSINESS_WEB', 'Your Business web:');
define('ENTRY_CELL_PHONE', 'Cell phone:');
define('TEXT_SUBMIT', 'Submit');
define('TEXT_UPLOAD', 'Upload');
define('TEXT_COPY','Copy');
define('TEXT_CHOOSE_SYSTEM_AVARTAR', 'Choose image from system base');
define('TEXT_UPLOAD_LOCAL_IMG', 'Upload media files from your computer');
define('TEXT_AVATAR_IS_PUBLIC_TO_OTHERS', 'Note: Your avatar is visible to other customers on our website.');
define('TEXT_CROPPED_PICTURE', 'Cropped picture');
define('TEXT_CUT', 'Crop');
define('TEXT_RECHANGE_PIC', 'RE-select the picture');
define('ENTRY_YOU_COUNTRY', 'Your Country:');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'Your Current Password did not match the password in our records. Please try again.');
define('ENTRY_NAME', 'Name:');

define('TEXT_LANG_YEAR', 'Year');
define('TEXT_LANG_MONTH', 'Month');
define('TEXT_LANG_DAY', 'Day');
// END OF account add items 2013-4-12

// login items 2013-4-16
define('TEXT_CREATE_ACCOUNT_BENEFITS', 'Register to get <b>US$ 6.01</b> cash account and enjoy VIP discount up to <b>10%</b>');
define('LOGIN_EMAIL_ADDRESS', 'Email:');
define('LENGHT_CHARACTERS', 'This should be at least 5 characters(must contain letters and numbers). ');
define('TEXT_YOUR_COUNTRY', 'Your Country: ');
define('SUBCIBBE_TO_RECEIVE_EMAIL', 'Subscribe to receive our E-mail special offers.');
define('AGREEN_TO_TERMS_AND_CONDITIONS', 'I agree to Doreenbeads.com <a href="https://www.doreenbeads.com/page.html?id=157" target="_blank">Terms and Conditions</a>.');
define('BY_CREATING_AGREEN_TO_TEAMS_AND_CONDITIONS', 'By creating an account, you agree to Doreenbeads.com’s  <a href="https://www.doreenbeads.com/page.html?id=157" target="_blank">Terms and Conditions</a>.');
// end of login items

// account_edit items 2013-4-19
define('TEXT_LANG_YEAR', 'year');
define('TEXT_LANG_MONTH', 'month');
define('SET_AS_RECIPIENT_ADDRESS', 'Set as default recipient address');
// end of account_edit items

// account_order items 2013-4-19
define('TEXT_ORDER_DATE', 'Order Date');
define('TEXT_ORDER_DATE_DATE', 'Order Date:');
define('TEXT_ORDER_NUMBER', 'Order Number');
define('TEXT_ORDER_NUMBER_LABEL', 'Order Number:');
define('TEXT_ORDER_TOTAL', 'Order Total');
define('TEXT_ORDER_STATUS', 'Order Status');
define('TEXT_ORDER_STATUS_LABEL', 'Order Status:');
define('TEXT_ORDER_DETAILS', 'Details');
define('TEXT_ORDER_PRODUCT_PART', 'Quick Add Products>>');
define('TEXT_ORDER_NO_EXISTS', 'No Order Exists');
define('TEXT_DISCOUNT_OFF_SHOW', 'off');
define('TEXT_HANDING_FEE', 'Handling Fee');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> orders)');
define('SUCCESS_PASSWORD_UPDATED', 'Your password has been successfully updated');
define('TEXT_AVATAR_UPLOAD_SUCCESSFULLY', 'Image have been approved. Thank you !');
define('TEXT_HEADER_MY_ACCOUNT','My Account');
// end of account_order items

// bof v1.0, zale 20130424
define('EXTRA_NOTE', '2-3 days is the delivery time from our warehouse to your China agent address.');
define('TEXT_NOTE_SPTYA', '<font color="red">Please add your China agent address in <a href="' . zen_href_link ( FILENAME_CHECKOUT_SHIPPING ) . '#comments">Order Comments.</a></font>');
define('TEXT_DETAILS_SPTYA', '<font color="red">Details:</font><br />
<font color="red">1、</font>Choose a shipping agent in China that you trust and are familiar with.<br />
<font color="red">2、</font>Provide us the address and contact information of this shipping agent ( better in Chinese if possible ) in <font weight="700" color="blue">Order Comments</font>.<br />
<font color="red">3、</font>We deliver your goods to its place. You just pay us shipping fee from our city to the address of shipping agent you choose. Normally only about <font color="blue">1-2 USD/kg</font>, you could pay it after you confirm the order and agent. And about 2-3 days the agent can get the parcel.<br /><br />
<span style="color:red;">Note:</span> Do not worry about custom problem, parcel will arrive you without charging tax.');

define('TEXT_DETAILS_TRSTV', '<font color="red">Details:</font><br />
<font color="red">1、</font>Your parcel will be shipped to our Suifenhe shipping agent (located in Heilongjiang province, China) at first.<br />
<font color="red">2、</font>Then our agent will ship your parcel to Vladivostok (Владивосток, located at southeast of Russia). <br />
<font color="red">3、</font>When parcel arriving there, the local shipping agent will contact you, inform you parcel arrives and then you can choose the shipping method for your parcel from Vladivostok to your city at your preference. Also you have to pay your domestic shipping fee.<br /><br />
<font color="red">In conclusion:</font><br />
The shipping cost = the amount has been shown from our company to Vladivostok (charged by dorabeads) + Cash on Delivery from Vladivostok to your place (charged by your local shipping carrier, an estimate is about <font color="blue">1-3 USD / kg</font>)<br/><br />

As Our Suifenhe shipping agent, it is an experienced and trustful shipping agent who have cooperated with us very well.<br /><br />
<span style="color:red;">Note:</span> Do not worry about custom problem, parcel will arrive you without charging tax.');

define('TEXT_DETAILS_TRSTM', '<font color="red">Details:</font> <br />
<font color="red">1、</font>We will ship the goods to China-Russia Logistic company（ located in Beijing, china）, who is responsible for carrying goods to Moscow. <br>
<font color="red">2、</font>When arriving Moscow, a logistics specialist will contact you, inform you parcel arrives and then you can choose the shipping method for your parcel from Moscow to your address at your preference. That person will ship the goods to you according to your instruction. Also you have to pay your domestic shipping fee. <br /><br />

<font color="red">In conclusion:</font><br />
The shipping cost = the amount has been shown from our company to Moscow (charged by dorabeads) + Cash on Delivery from Moscow to your place (charged by China-Russia Logistic company, an estimate is about <font color="blue">1 USD / kg</font>)<br /><br />

As China-Russia Logistic Company, it is an experienced and trustful shipping agent who has great insurance policy.  <span style="background:yellow;color:black;">Our parcels shipped by this shipping company always arrive smoothly.</span><br /><br />
<span style="color:red;">Note:</span> Do not worry about custom problem, parcel will arrive you without charging tax.');

define('TEXT_DETAILS_TRSTMA', 'Your goods will be shipped to one of following cities which is nearest to your shipping address by Air:
  <span style="color:#008FED;margin: 10px 0;">Moscow, St. Petersburg, Krasnoyarsk, Novosibirsk, Ekaterinburg, Irkutsk, Omsk, Kamchatka, Sakhalin, Yakutsk</span>
  a. When parcel arrives at the city which is near your location, our shipping agent will contact you. Then you could pick up parcel by yourself, in that case, you do not have to pay any additional shipping fee. (Please kindly note that if you live near Moscow, you should pick up parcel in time since storage fee will be charged for keeping parcel in Moscow warehouse.)<br><br>
  b. If you are unable to pick up parcel by yourself, you can ask the person who contact you to ship parcel to your address by the shipping method you like. That person will ship the goods to you according to your instruction. Also you have to pay for your domestic shipping fee.<br><br>
  The shipping cost = the amount has been shown when you checkout (charged by 8years) + Cash on Delivery from the city to your place (charged by Logistic company).<br><br>
  <font color="#ff0000">Note:</font> To make your parcel delivered successfully, the photo or copy of the addressee’s identity card was required by shipping company. Please kindly send it to <a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a>. Any question, please feel free to contact us.');
define('TEXT_TRSTM','a. We will ship the goods to the Logistic company who is responsible for carrying goods to Moscow.<br>
b. When arriving in Moscow, a logistics specialist will contact you, inform you that the parcel arrives and then you can choose the shipping method for your parcel from Moscow to your address at your preference. Also you have to pay your domestic shipping fee.<br>
<b>The shipping cost</b> = the amount has been shown when you checkout (charged by 8seasons) + Cash on Delivery from Moscow to your place (charged by Logistic company, an estimate shipping is about 0.3-0.5 USD / kg).');

define('TEXT_DETAILS_YNKQY', 'Your goods will be shipped to one of following cities which is nearest to your shipping address by <b>Car</b>:<br>
<span style="color:#008FED;margin: 10px 0;">Moscow, St. Petersburg, Krasnoyarsk, Novosibirsk, Ekaterinburg, Irkutsk, Omsk, Yakutsk, Ussuri, Khabarovsk, Tyumen, Vladivostok, Yakutsk</span><br>
a. When parcel arrives at the city,which is near your location, our shipping agent will contact you. Then you could pick up your parcel by yourself, in that case, you do not have to pay any additional shipping fee. (Please kindly note that if you are near Moscow, you should pick up parcel in time since storage fee will be charged for keeping parcel in the Moscow warehouse.)<br><br>
b. If you are unable to pick up parcel by yourself, you can ask the person who contact you to ship parcel to your address by the shipping way you like. That person will ship the goods to you according to your instruction. Also you have to pay for your domestic shipping fee.<br><br>
<b>The shipping cost</b> = the amount has been shown when you checkout (charged by doreenbeads) + Cash on Delivery from the city to your place (charged by Logistic company).<br><br>
<font color="#ff0000">Note:</font> To make your parcel delivered successfully , the photo or copy of the addressee’s  identity card was required by shipping company. Please kindly send it to <a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a>. Any question, please feel free to contact us.');

define('TEXT_READ_NOTE', 'Please read this note.');
define('TEXT_SPTYA', 'you should choose a ship-agent in China and then tell us his shipping address in China. Hope for your kind understanding, shipping fee from our city to your agent is on your account.');

define('EXTRA_NOTE_CN', 'We will charge the shipping fee based on your actual location.');

define('NOTE_EMS', '<font color="red">If you bought <strong>watches</strong> or <strong>something sharp</strong> Like scissors, please do not choose EMS, why?>></font>');
define('NOTE_EMS_CONTENT', '<span style=color:red;>To customer who bought Watches or sharp item:</span> If your order contains <strong>watches</strong> or <strong>something sharp</strong> Like scissors or sharp-nose pliers, please do not choose EMS.<div style="margin-top:8px; color:#333">Reason: Custom do strict check on them, if they found EMS parcel with watch or sharp item, parcel would be returned from custom, also post office will be punished by custom. <br/>If you prefer to use EMS or if the shipping fee of EMS is cheapest one, you may consider to order forbidden item separately with other items, or you could feel free contact us at <a href=mailto:sale@doreenbeads.com>sale@doreenbeads.com</a>, we will give you best suggestion.</div>');

define('NOTE_USPS', '<font color="red">If you bought <strong>watches</strong> or <strong>something sharp</strong> Like scissors, please do not choose USPS, why?>></font>');
define('NOTE_USPS_CONTENT', '<span style=color:red;>To customer who bought Watches or sharp item:</span> If your order contains <strong>watches</strong> or <strong>something sharp</strong> Like scissors or sharp-nose pliers, please do not choose USPS.<div style="margin-top:8px; color:#333">Reason: Custom do strict check on them, if they found USPS parcel with watch or sharp item, parcel would be returned from custom, also post office will be punished by custom. <br/>If you prefer to use USPS or if the shipping fee of USPS is cheapest one, you may consider to order forbidden item separately with other items, or you could feel free contact us at <a href=mailto:sale@doreenbeads.com>sale@doreenbeads.com</a>, we will give you best suggestion.</div>');

define('TEXT_NOTE_ABOUT_TAX', 'Please read the note about tax! Details>>');
define('TEXT_NOTE_ABOUT_TAX_CONTENT', 'Note about Tax:  According to our experience, TAX fee has a big chance to be charged for parcels shipped by Fedex to your country, So we suggest you put this information in your mind, choose most favorable shipping method.');

define('NOTE_FEDEX','<font color="red">Order with WATCHES not recommended using FedEx! Why? >></font>');
define('NOTE_FEDEX_CONTENT','To customer who bought Watches: If your order contains watches, we do not recommend you choose FedEx. You could choose any other shipping methods. <br/><font style="color:red;font-weight:bold;">Reason</font>: FedEx do strict check on electronic product, if they found parcel with watch, parcel would be hold in custom. <br/>If you prefer to use FedEx or have any question, you could feel free contact us at <a href=mailto:sale@doreenbeads.com>sale@doreenbeads.com</a>, we will give you best suggestion.');

define('TEXT_NOTE_USE_ENGLISH' , 'Fedex requires address in English, why？');
define('TEXT_NOTE_USE_ENGLISH_DESCRIPTION' , 'Fedex requires address in English, in order not to cause any delay in shipment, please leave a comment for your address in English during checking out. If you don’t have one, just contact our customer service: <a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a>');

define('TEXT_NOTE_ABOUT_WATCH', 'Please be sure to read note about watches. Details>>');
define('TEXT_NOTE_ABOUT_WATCH_CONTENT', 'If your order contents watches above 20% in quantity, please do not choose DHL(direct) since DHL do strict check on parcel with electric product, like watch. Parcel would not be permitted to shipped out.');

define('NOTE_TARIFF', 'Note about custom declare value');
define('NOTE_TARIFF_CONTENT', 'For this shipping method, we will mark proper value (about 15GBP-40GBP)on the parcel, so that you do not have to pay any tax. <br />If you want to mark real value on parcel, 20% of tax fee is needed, So we strongly suggest you that just leave it to us, we will handle it correctly.');
define('NOTE_TARIFF_CONTENT_US', 'For this kind of shipping method, we will mark proper value (about 15USD-40USD)on the parcel, so that you do not have to pay any tax. <br />If you want to mark real value on parcel, 20% of tax fee is needed, So we strongly suggest you that just leave it to us, we will handle it correctly.');

define('TEXT_HOW_DOES_IT_WORKS', 'How does it works?');
define('TEXT_HOW_DOES_IT_WORKS_1', 'How does it works? A copy of identity card was required.');

define('TEXT_POBOX_REMINDER', 'Reminder: To make sure your parcel being delivery smoothly, please kindly provide street address instead of PO box address only.');

define('TEXT_YOUR_ITEMS_BE_SHIPPED', 'Your items will be shipped out together in');
define('TEXT_BOXES', 'boxes');

define('TEXT_WOOD_PRODUCTS_NOTICE', 'Wood/bamboo product are not recommend shipped by DHL, why?');

define('NOTE_GREECE', '<a href="' . HTTP_SERVER . '/page.html?id=215' . '" target="_blank">Be sure to read the note about custom >></a>');

define('TEXT_DETAILS_SFHYZXB', 'It is NOT door to door service. You should pick up parcel from your local post office. When parcel arrives in local post office, you will receive a notification asking you to pick up your parcel with Valid ID. Do not worry about Custom, we will take care of everything. <br>
Kind note: Maxim weight: 30kg per parcel. If your order weighs more than 30 kg, we will separate it into several parcels.');

define('TEXT_DETAILS_SFHKY', 'Door to door service. Parcel will be sent to Уссури first, then being transported to your local post office by air plane. When it arrives in local post office, the post man will dispatch the parcel to your home. No worries about Custom, we will take care of everything. <br>Advantage: A. Free of tax problem B. Can be tracked online: <a href=http://www.sfhpost.com>www.sfhpost.com</a>.<br>Disadvantage: We only transport goods to local post office.<br>Kindly note: Maxim weight: 20kg. if your order weighs more that 20 kg, we will separate it into several parcels.');

define('TEXT_NOTE_SPTYA', '<font color="red">Please add your China agent address in <a href="' . zen_href_link ( FILENAME_CHECKOUT_SHIPPING ) . '#comments">Order Comments.</a></font>');

define('TEXT_NO_AVAILABLE_SHIPPING_METHOD', '<font color="red"><b>NOTE: </b></font>If there is no available shipping method for your delivery address, it would be a better choice to <a href="mailto:sale@doreenbeads.com">contact us</a> before you continue to checkout.');

define('TEXT_ITEM', 'Item');
define('TEXT_PRICE', 'Price');
define('TEXT_SHIPPING_METHOD', 'Shipping Method');
define('TEXT_SHIPPING_METHODS', 'Shipping Methods');
define('TEXT_DAYS', 'Days');
define('TEXT_NOTE', 'Note');
define('TEXT_DAYS_LAN', 'days');
define('TEXT_WORKDAYS', 'workdays');

define('TEXT_DAYS_ALT_S_Q', 'days from slow to quick');
define('TEXT_DAYS_ALT_Q_S', 'days from quick to slow');
define('TEXT_PRICE_ALT_L_H', 'price from low to high');
define('TEXT_PRICE_ALT_H_L', 'price from high to low');

define ( 'TEXT_SHIPPING_FEE', 'Shipping fee was calculated by volume and weight' );
define ( 'TEXT_CLICK_HERE_FOR_MORE_LINK', '<a href="' . HTTP_SERVER . '/page.html?id=160" target="_blank">Click here for detail.</a>' );
define('TEXT_SHIPPING_NOTE','Please kindly note that the above shipping fee has included the additional charge for remote area delivery (Required by the %s --- ');
define ( 'TEXT_TOTAL_BOX_NUMBER', 'Total Box Number' );
define('TEXT_SHIPPING_VIRTUAL_COUPON_ACTIVITY', 'Choose this service now, you can get a $2 coupon (no minimum consumption， one coupon per customer).');

// eof

// login items 2013-4-16
define('TEXT_CREATE_ACCOUNT_BENEFITS', 'Register to get <b>US$ 6.01</b> cash account and enjoy VIP discount up to <b>10%</b>');
define('LOGIN_EMAIL_ADDRESS', 'Email:');
define('LENGHT_CHARACTERS', 'This should be at least 5 characters. ');
define('TEXT_YOUR_COUNTRY', 'Your Country: ');
define('SUBCIBBE_TO_RECEIVE_EMAIL', 'Subscribe to receive our E-mail special offers.');
define('AGREEN_TO_TERMS_AND_CONDITIONS', 'I agree to Doreenbeads.com Terms and Conditions. ');
// end of login items

define('ENTRY_EMAIL_FORMAT_ERROR', 'Your email format is not correct, please try again.');
define('TEXT_VIEW_INVOICE', 'View Invoice');

define('TEXT_DISCOUNT_OFF', 'off');
define('TEXT_BE_THE_FIRST', 'Be the first to');
define('TEXT_WRITE_A_REVIEW', 'Write a review');
define('TEXT_READ_REVIEW', 'Read Review');
define('TEXT_SHIPPING_WEIGHT_LIST', 'Shipping Weight:');
define('TEXT_MODEL', 'Part No.');
define('TEXT_INFO_SORT_BY_STOCK_LIMIT', 'Stock - More to Less');
define('TEXT_STOCK_HAVE_LIMIT', '%s Stock Remaining');
define('TEXT_PROMOTION_ITEMS', 'for non-promotion items');

define('TEXT_PASSWORD_FORGOTTEN', 'Forgot your password?');
define('TEXT_LOGIN_ERROR', 'Sorry, there is no match for that email address and/or password.');

define('TEXT_ADDCART_MIN_COUNT', 'Minimum order amount of %s is %s. The quantity is updated to %s automatically.');
define('TEXT_ADDCART_MAX_COUNT', 'Maximum order amount of %s is %s. The quantity is updated to %s automatically.');
define('TEXT_ADDCART_NUM_ERROR', '<img height="20" width="20" title=" Caution " alt="Caution" src="includes/templates/template_default/images/icons/warning.gif">We are sorry but we only have %s packs of %s available at this time. Please kindly update the quantity. Any question, kindly contact us at sale@doreenbeads.com');
define('TEXT_ADDCART_NUM_ERROR_ALERT', 'The available quantity for this item are (%s). Please make a choice within the available quantity or you may prefer to shopping for other items. Thank you very much for your kind understanding!');

define('TEXT_MOVE_TO_WISHLIST_SUCCESS', 'Item(s) Added Successfully into Your Wishlist! <a href="' . zen_href_link('wishlist', '', 'SSL') . '">View Wishlist</a>');
define('TEXT_HAD_BEEN_IN_WISHLIST','This product has been in the wishlist! <a href="'.zen_href_link('wishlist','','SSL').'">View Wishlist Products</a>');
define('TEXT_MOVE_TO_WISHLIST_SUCCESS_NOTICE', 'All products allready in Your Wishlist! <a href="' . zen_href_link('wishlist', '', 'SSL') . '">View Wishlist</a>');
define('TEXT_VIEW_SHIPPING_WEIGHT', 'View Shipping Weight');
define('TEXT_PRODUCT_WEIGHT', 'Product Weight');
define('TEXT_WORD_PACKAGE_BOX_WEIGHT', 'Package Box Weight');
define('TEXT_WORD_SHIPPING_WEIGHT', 'Shipping Weight');
define('TEXT_WORD_VOLUME_WEIGHT', 'Volumetric Weight');
define('TEXT_CALCULATE_BY_VOLUME','Shipping fee was calculated according to parcel’s volume weight.');
define('TEXT_SHIPPING_COST_IS_CAL_BY', 'Shipping Cost is calculated by Product Weight plus Package Box Weight.');

define('TEXT_CART_TOTAL_PRODUCT_PRICE', 'Total Product Price');
define('TEXT_CART_ORIGINAL_PRICE', 'The Regular-priced amount');
define('TEXT_CART_PRODUCT_DISCOUNT', 'The discounted-priced amount');
define('TEXT_CART_DISCOUNT_PRICE', 'Discount on The discounted-priced');;
//2018 12 18 begin
define('TEXT_CART_ORIGINAL_PRICES','Original Price');
define('TEXT_REGULAR_AMOUNT','Regular amount');
define('TEXT_CART_PRODUCT_DISCOUNTS', 'discounted-priced amount');
define('TEXT_CART_DISCOUNT','Discount');
define('TEXT_PROMOTION_SAVE','Promotion Save');
define('TEXT_EXTRA_FEE','Extra Fee');
define('TEXT_CART_SPECIAL_DISCOUNT','Special Discount');
//2018 12 18 over
define('PROMOTION_SAVED', 'Saved');
define('PROMOTION_DAILY_DEALS', 'Weekend Deals');
define('FACEBOOK_DAILY_DEALS','Facebook Deals Spotlight');
//define('PROMOTION_DAILY_DEALS', '$0.79 Deals');

define('TEXT_FREE_SHIPPING', 'Free Shipping');

define('TEXT_CART_QUICK_ADD_NOW', 'Quick add now');
define('TEXT_CART_QUICK_ADD_NOW_TITLE', 'Please enter our porduct Part No.(for example B06512) and Quantity you want to order by using the below form:');
define('TEXT_CART_ADD_TO_CART', 'Add to Cart');
define('TEXT_ADD_TO_CART_SUCCESS', 'Add to cart successfully!');
define('TEXT_VIEW_CART', 'View Cart');

define('TEXT_CART_ADD_MORE_ITEMS_CART', 'Add more items');
define('TEXT_ITEMS_ADDED_SUCCESSFULLY', 'Items were added successfully.');
define('TEXT_QUICKADD_ERROR_EMPTY', 'Please enter at least one Product No. and Qty');
define('ERROR_PLEASE_CHOOSE_ONE', 'Please select at least one item.');
define('TEXT_QUICKADD_ERROR_WRONG', 'Sorry, some items were not available. Please remove the wrong Part No. / Qty');

define('TEXT_BY_PART_NO', 'by Part No.');
define('TEXT_BY_SPREADSHEET', 'by Spreadsheet');
define('TEXT_EXAMPLE', 'Example');
define('TEXT_SAMPLE_FROM_YOUR_SPREADSHEET', 'Sample: From your spreadsheet, copy and paste the shaded area - as shown above.');
define('TEXT_EXPORT_CART', 'Export Cart');
define('TEXT_PLEASE_ENTER_AT_LEAST', 'Please enter at least one Product No. and QTY.');
define('TEXT_ITEMS_NOT_FOUND', 'The following items were not added to your cart because the Part No. was not found. %s');
define('TEXT_ITEMS_WAS_REMOVED', 'The following items were not added to your cart because it was removed. %s');
define('TEXT_ITEMS_WERE_ALREADY_IN_YOUR_CART', 'The following items were already in your cart and the QTY are now updated. You can verify the item QTY if necessary. %s');
define('TEXT_ITEMS_QTY_WAT_NOT_FOUND', 'The following items were not added to your cart because the item QTY was not found. %s');
define('TEXT_ITEMS_MODIFIED_DUE_TO_LIMITED', 'The QTY of following items were modified due to limited availability. %s');

define('TEXT_CART_JS_WRONG_P_NO', 'Wrong Part No.. To continue, you should remove this item from your list.');
define('TEXT_CART_JS_SORRY_NOT_FIND', 'Sorry, some items were not found, Please remove the wrong Part No.');
define('TEXT_CART_JS_NO_STOCK', 'No Stock. To continue, you should remove this item from your list.');

define('TEXT_PAYMENT_DOWNLOAD', 'download');
define('TEXT_PAYMENT_PRINT', 'print');
define('TEXT_PAYMENT_PROMOTION_DISCOUNT', 'Promotion Discount');

define('TEXT_EYOUBAO', 'It is a kind of Sino-Russian logistics service launched by PONY EXPRESS and a Chinese logistics company, characterized by fast shipping speed, competitive freight, and security guarantee. It has gradually becoming the preferred choice by Sino-Russian Cross-border E-commerce sellers.<br><br>
Advantages: <br>
1 Electronic products allowed;<br>
2 End to end online tracking: You could track it on <a href="http://set.zhy-sz.com/" target="_blank">http://set.zhy-sz.com/</a> (official website) or <a href="http://www.ponyexpress.ru/en/trace.php" target="_blank">http://www.ponyexpress.ru/en/trace.php</a> (destination country) during the whole journey;<br>
3 Aging guarantee: If the parcel doesn’t reach the destination within 32 days, the total freight will be refunded if the shipping fee you paid is less than 50USD while 50USD will be refunded if the shipping fee you paid is more than 50USD. <br>
(Not including special causes: A. For the reason of buyers such as wrong shipping address, the recipient’s not in, no signature, etc. B. For the reason of force majeure factors such as war, disasters, air blast, etc. );<br>
4 About insurance: The insurance is optional. When your parcel is very large, you are sincerely advised to buy insurance which takes up 3% of parcel’s declared value. For example. If you want to declare 1000USD for your parcel, the insurance will be 30USD. And if the parcel is missing, 1000USD will be paid back.<br><br>
Disadvantages: <br>
1 Weight limitation: 31kg. If your parcel weighs more than 31kg, we will separate it into several parcels;<br>
2 Size limitation: 60cmx55cmx45cm;<br>
3 No contrabands.<br>');

define('TEXT_XXEUB', 'A means of transportation which only takes about 7-15 days for shipping. The parcel will be delivered to the recipient by the local post office. Tracking information is available on: <a href="https://tools.usps.com/go/TrackConfirmAction_input" target="_blank">https://tools.usps.com/go/TrackConfirmAction_input</a>.<br><br>
Advantages: <br>
1 Cost-efficient: Compared to airmail, it only takes 7-15 days to reach the destination. Sometimes, the parcel even could reach the recipient within 4-6 days. <br>
2 Free of tax problem;<br>
3 PO BOX address allowed;<br><br>
Disadvantages:<br>
Maximum weight: 2kg. If the parcel weighs more than 2kg, your order will be divided into two. <br><br>
Warm Note: a telephone number will greatly facilitate the delivery. <br>');
define('TEXT_HMJZ', '(Total Box Number: 1)');
// /////////////////////////////////////////////////////////
// dorabeads v1.5
define('TEXT_AVATAR_UPLOAD_TIPS', '<div style="font-weight:normal;font-size:15px;text-align:left;padding:0px 15px 0px 15px;line-height:23px;color:#ff6600">If you select a picture file from your computer, please be kindly noted :<p style="margin-top:5px">1. 50 KB max.<br>2. Jpg, gif, png, bmp only.<br>3. Size Recommended: 50x50, 100x100.<br>4.Your avatar is visible to other customers on <br>&nbsp;&nbsp;&nbsp;our website.</p></div>');
define('TEXT_CASH_CREATED_MEMO_1', 'Your credit amount has been used in order No. #%s');

define('TEXT_TARIFF_TITLE_1', 'Please write down your Customs No.. It helps customs clearance. <br/><br/>CPF/CNPJ No.:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/><br/><span style="padding-left:6.8em"></span>( optional field )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="CPF/CNPJ No."/>');

define('TEXT_TARIFF_TITLE_2', 'Please write down your Customs No.. It helps customs clearance.  <br /><br/><FONT COLOR="RED">*</FONT> CPF/CNPJ No.:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/><br/><span style="padding-left:7.6em"></span>( required )<input type="hidden" name="tariff_alert" id="tariff_alert" value="Please write down your CPF/CNPJ No.."/><input type="hidden" name="tariff_title" id="tariff_title" value="CPF/CNPJ No."/><br/><FONT COLOR="RED"><b>Note：</b></FONT>All parcels via Express to Brazil/Chile require CPF/CNPJ No.. If you have none, please try to select Airmail.');

define('TEXT_TARIFF_TITLE_3', 'Please write down your Customs No.. It helps customs clearance.  <br /><br/><FONT COLOR="RED">*</FONT> EORI No. :<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( required )<input type="hidden" name="tariff_alert" id="tariff_alert" value="Please write down your EORI No.."/><input type="hidden" name="tariff_title" id="tariff_title" value="EORI No."/><br /><br/><FONT COLOR="RED"><b>Note：</b></FONT>FedEx(by Agent) requires EORI No.. If you have none, please select other shipping method. ');

define('TEXT_TARIFF_TITLE_4', 'Please write down your Customs No.. It helps customs clearance.  <br /><br/>EORI No.:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( optional field )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="EORI No."/>');

define('TEXT_TARIFF_TITLE_5', 'Please write down your Customs No.. It helps customs clearance. <br /><br/>Custom No.:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( optional field )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="Custom No."/>');

// bof dorabeads v1.7, zale
define('TEXT_VERIFY_NUMBER', 'Verify Number');
define('TEXT_TRACKING_NUMBER', 'Tracking Number');
define('TEXT_TERMS_CONDITIONS', 'Terms and Conditions');
define('TEXT_PRIVACY_POLICY', 'Privacy Policy');
define('TEXT_SHOPPING_CART_OUTSTOCK_NOTE', 'Following products have been moved from your shopping cart to your wishlist since they are out of stock at the moment, which will be available again soon. Just click restock notification to get restock news in time.');
define('TEXT_SHOPPING_CART_DOWN_NOTE', 'Following products have been removed from your shopping cart since they have out of stock. If you need it, please contact us via <a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a>.');
define('TEXT_VIEW_LESS_SHOPPING_CART', 'View Less');
define('TEXT_SHOPING_CART_SELECT_SIMILAR_ITEMS', 'Select Similar Items');
define('TEXT_SHOPING_CART_EMPTY_INVALID_ITEMS', 'Empty Invalid Items');
define('TEXT_SHOPING_CART_CONFIRM_EMPTY_INVALID_ITEMS', 'Do you confirm to empty invalid items?');
define('PROMOTION_LEFT', 'Left');
define('TEXT_SIMILAR_PRODUCTS', 'Similar Products');

define('TEXT_CODE_DAY', 'D');
define('TEXT_CODE_HOUR', 'h');
define('TEXT_CODE_MIN', 'm');
define('TEXT_CODE_SECOND', 's');
// eof v1.7

define('TEXT_IMPORTANT_NOTE', 'Important note');
define('TEXT_PAY_SUCCESS_TIP_TiTLE', 'Warmly Notice:');
define('TEXT_PAY_SUCCESS_TIP', 'In view of the current tense situation in the global epidemic, flights will become increasingly tight, so there may be some delays on shipping, please understand.
We will do our best to let you receive the goods as soon as possible.');
define('TEXT_PLEASE_KINDLY_CHECK', 'Please kindly check your shipping address to confirm its correctness. Normally upon receiving your payment, we will dispatch your parcel in 1-2 days. Therefore, if you notice that your shipping address is not correct, please <a href="mailto:sale@doreenbeads.com" style="color:#008FED;">contact us</a> as soon as possible within 24 hours.');

define('TEXT_SEARCH_RESULT_TITLE', 'Search result:');
define('TEXT_SEARCH_RESULT_NORMAL', 'You searched for <span>%s</span>, <span>%d</span> results found for <span>%s</span>.');
define('TEXT_SEARCH_RESULT_SYNONYM', 'So we searched <i>%s</i> for you.');
define('TEXT_RELATED_SEARCH','Related');
define('TEXT_RELATED_SEARCH','Related');
define('TEXT_SEARCH_TIPS','<div class="search_error_cont">
        <dl>
            <dt>Kind Recommendation:</dt>
            <dd><span>-</span><p>Check the words you entered to make sure it’s correct.</p></dd>
            <dd><span>-</span><p>If the Part No. you searched is not available, please <a href="mailto:sale@doreenbeads.com">contact us</a>.</p></dd>
            <dd><span>-</span><p>Use the similar words with different spelling.</p></dd>
        </dl>
        <div class="action"><a href="'.zen_href_link(FILENAME_DEFAULT).'" class="continue_shopping">Continue Shopping</a><a href="'.zen_href_link(FILENAME_WHO_WE_ARE,'id=99999' ).'" class="contact_us">Contact Us</a></div>
    </div>');
define('TEXT_SEARCH_RESULT_FIND_MORE','Find more from the following');

define('TEXT_CART_ARE_U_SURE_DELETE', 'Are you sure to delete this item?');
define('TEXT_DOWNLOAD', 'download');
define('TEXT_SHIPPING_CHARGE', 'Shipping Charges:');
define('TEXT_CART_VIP_DISCOUNT', 'VIP Discount');
define('TEXT_CART_JS_WRONG_NO', 'Wrong Part No.');
define('TEXT_NO_STOCK', 'No Stock');
define('TEXT_YES', 'Yes');
define('TEXT_NO', 'No');
define('TEXT_PER_PACK', 'per pack');
define('TEXT_GRAMS', 'grams');
define('TEXT_CREDIT_BALANCE','Credit Balance:');

define('TEXT_UNIT_KG', 'kg');
define('TEXT_UNIT_GRAM', 'gram');
define('TEXT_UNIT_POUND', 'pound');
define('TEXT_UNIT_OUNCE', 'ounce');

define('TEXT_UBI_NOTE', 'UBI line is prohibited to ship any wood or bamboo products. Details》');
define('TEXT_UBI_NOTE_CONTENT', 'If the order includes wood or bamboo products, please do not choose UBI line as it is prohibited to ship any wood or bamboo products via this method. You could either change your shipping method for whole order or order those items separately via other methods. Need any help or advice, please click live chat or email us at <a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a> anytime.');

define('TEXT_VIEW_LIST', 'List');
define('TEXT_VIEW_GALLERY', 'Gallery');

define('HEADER_TITLE_NORMAL', 'Normal');
define('TEXT_SERVICE_EMAIL', 'sale@doreenbeads.com');
define('TEXT_SERVICE_SKYPE', 'service.8seasons');

// v2.20
define('TEXT_MY_COUPON', ' Coupon');

define('NOTE_RUSSIAN_NOTE', 'For this shipping method, parcel will be shipped out after Feb 5th. Details>>');
define('NOTE_RUSSIAN_NOTE_CONTENT', '<font style="color:#ff0000;">Warm tip:</font> This shipping way you chose won’t work during <font style="color:#ff0000;">January 21st to February 6th</font>, so we will have to ship out your parcel after the New Year holiday. If you need these items urgently, you are sincerely advised to change the shipping way(either airmail or EMS is available to use before <font style="color:#ff0000;">January 28th</font>). Thanks for your great understanding.');

define('TEXT_ESTSHIPPING_TIME', 'Est. Shipping Time');

define('TEXT_NEWSLETTER_SUCC', 'Success! Thanks for signing up!');
define('TEXT_NEWSLETTER_JOIN', 'JOIN');
define('TEXT_NEWSLETTER_EMAIL_ADDRESS', 'Email address');

define('TEXT_MORE_PRO','More');
define('TEXT_VIEW_LESS','Less');
define('TEXT_CLEAR_ALL','Clear All');
define('TEXT_ITEM_FOUND','<b>%s</b> item found');
define('TEXT_ITEM_FOUND_2','<b>%s</b> items found');
define('TEXT_REFINE_BY_WORDS','Refine By');

define('TEXT_SUB_WHICH_TYPE', 'Which Type You’re ?');
define('TEXT_SUB_WHOLESALER', 'Wholesaler');
define('TEXT_SUB_RETAILER', 'Retailer');
define('TEXT_SUB_DIY_FANS', 'DIY Fans');
define('TEXT_SUB_OTHERS', 'Others');

define('TEXT_SET_COUPON', "Congratulations！ %s Coupon has been credited in your account. You can check it in <a href='".HTTP_SERVER."/index.php?main_page=my_coupon' style='text-decoration: underline;'>My Coupon</a>.");

define('TEXT_JOIN_NOW_COUPON', 'REGISTER TO GET <span>$6.01 COUPON</span>');
define('TEXT_JOIN_PASSWORD', 'Password');
define('TEXT_JOIN_NOW_DISCOUNT_UP', 'VIP DISCOUNT UP TO 10% OFF');
define('TEXT_JOIN_NOW_SIGN_UP', 'SIGN UP FOR EXCLUSIVE OFFERS, HOT SALES,<br /> NEW ARRIVALS & MORE.');
define('TEXT_JOIN_NOW_DEAR_CUSTOMERS', 'dear customer');
define('TEXT_JOIN_NOW_RETURN_CUSTOMERS_LOGIN', 'Return Customers？<a href="'.zen_href_link(FILENAME_LOGIN).'" class="link_color">Login</a>');
define('TEXT_UNIT_PRICE', 'US$ <span class="productSpecialPrice">%s</span> &sim; US$ <span class="productSpecialPrice">%s</span>');
define('TEXT_SILVER_REPORT', 'Our sterling silver products have tested by formal institutions of China, which are widely recognized by both ILAC and APLAC members [<a target="_blank" href="silver_report.html">Click for Test Report</a>].');
define('TEXT_SWAROVSKI_CERTIFICATE', 'As a Swarovski agent, we have the official agent certificate, you will receive genuine Austrian Swarovski crystal elements <a target="_blank" href="swarovski_certificate.html">[Click here for certificate]</a>.');
/*ask a question*/
define('TEXT_PART_NO','Part No. :');
define("EMAIL_QUESTION_SUBJECT","Question for Details about the item");
define('EMAIL_QUESTION_TOP_DESCRIPTION',"Your Question About Item %s on Doreenbeads has been Received.");

define('EMAIL_QUESTION_MESSAGE_HTML',"%s<br /><br />\n\nDear %s,<br /><br />\n\nHave a nice day there!\n\n<br /><br />Thank you so much for contacting dorabeads.  We have received your question, one of our friendly Service Sales will get in touch with you as soon as possible within 24 hours. Please kindly wait in patience.<br /><br />\n\nIf you need prompt assistance, please contact us via Live Chat or call our Customer Service Department at (+86)579-85335690 on our working hours: 8:30 AM to 6:30 PM (GMT +08:00) Beijing, China Monday to Saturday.<br /><br />\n\nThank you for your time, we will be in touch with you soon!<br /><br />\n\n--------------------------------------Your Question---------------------------------------<br />%s<br /><br />%s<div style='clear:both;'>Kind Regards to You<br />\nDoreenbeads Team<br />\n<a href=".HTTP_SERVER.">www.doreenbeads.com</a></div>");

/*end*/
define('TEXT_QUESTION_HEADER','Product Question Confirmation');
define('EMAIL_PAYMENT_INFORMATION_ADDRESS','xiaolian.xie@panduo.com.cn');
define('TESTIMONIAL_CC_ADDRESS','dan.lin@panduo.com.cn,xiaolian.xie@panduo.com.cn');
define('AVATAR_CHECK_ADDRESS', 'sale@doreenbeads.com' );
define('AVATAR_CHECK_CC_ADDRESS', 'chahua.wang@panduo.com.cn' );
define('SALES_EMAIL_ADDRESS', 'sale@doreenbeads.com');
define('SALES_EMAIL_CC_TO', 'dan.lin@panduo.com.cn,yunan.zhang@panduo.com.cn,chahua.wang@panduo.com.cn');
define('TEXT_PRICE_AS_LOW_AS', 'As low as');

define('TEXT_BACKORDER', 'Backorder');
define('TEXT_ARRIVAL_DATE','Estimated Restocking Date: %s.');
define('TEXT_READY_DAYS', 'Estimated Restocking Cycle: %s days.');
define('TEXT_ESTIMATE_DAYS', 'Estimated Restocking Cycle: %s days.');
define('TEXT_PREORDER','<font style="color:#ff0000" class="text_preorder_class" title="This item is temporarily out of stock, and you have backordered it.">&lt;backorder&gt;</font> ');

define('TEXT_CART_ERROR_NOTE_PRODUCT_LESS','Only %s pack(s) of %s are available now. The quantity is updated to %s automatically.');
define('TEXT_CART_ERROR_HAS_BUY_FACEBOOKLIKE_PRODUCT','Each Facebook fan would get 1pc FREE sample kit %s. You have already got it in order %s, so it has been removed from your shopping cart.');
define('TEXT_GET_COUPON', 'Congratulations! You\'ve got %s Coupons. Please check in "<a href="'.zen_href_link(FILENAME_MY_COUPON).'">My Coupon</a>".');
define('TEXT_ALREADY_GET', 'Oops, one coupon can only be taken once.');
define('TEXT_GET_COUPON_EXPIRED', 'Sorry, you cannot get these coupons because this coupon event has already been over.');

// include email extras
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_EMAIL_EXTRAS )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS);
}

// include template specific header defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_HEADER )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_HEADER )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_HEADER);
}
// include template specific footer defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_FOOTER )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_FOOTER )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_FOOTER);
}

// include template specific button name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_BUTTON_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES);
}

// include template specific icon name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_ICON_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES);
}

// include template specific other image name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_OTHER_IMAGES_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES);
}

// credit cards
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_CREDIT_CARDS )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_CREDIT_CARDS )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_CREDIT_CARDS);
}

// include template specific whos_online sidebox defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_WHOS_ONLINE . '.php')) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php')) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php');
}

// include template specific meta tags defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/meta_tags.php')) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . 'meta_tags.php')) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . 'meta_tags.php');
}
// END OF EXTERNAL LANGUAGE LINKS

/*testimonial  mailto */
define('TESTIMONIAL_EMAILS_TO', 'sale@doreenbeads.com');
/*coupon about to expire notice*/
define('TEXT_COUPON_NOTICE_FIRST', '<p class="tleft">Your coupon is about to expire. <br />
					The coupon code is <span>%s</span>. The deadline is <span>%s</span>. ');
define('TEXT_COUPON_NITICE_SECOND', '<br />
					You are sincerely advised to use it as early as possible.</p>
					<a href="javascript:viod(0)" class="guidebtn">OK, I Know</a> ');		
define('TEXT_VIEW_MORE', 'View more');		
define('TEXT_REMOVED','Removed');
define('TEXT_REFUND_BALANCE', 'Returned credit balance for order: #');
/*facebook_coupon*/
define('FACEBOOK_LINK', 'https://www.facebook.com/Doreenbeadscom');

define('TEXT_PROMOTION_DISCOUNT_FULL_SET_MINUS', 'Fixed Amount Off');

define('TEXT_PAYMENT_PROMPT',"It is better to submit your payment receipt to help us confirm information.");
define('TEXT_PAYMENT_HSBS_CHINA','<p>1. When transferring money to us, please write down your order No. in the remarks column of the bank transfer form.</p>
<p>2. Please be sure to <a href="mailto:sale@doreenbeads.com" style="color:#008FED;">email us</a> the payment information after you transfer money so that we can confirm the money you transferred and ship your parcel timely.</p>
<p>3. 2% discount will be offered if total amount reach to 2000 US$, commission fee should be paid by payer.</p>');
/*other package size*/
define('TEXT_OTHER_PACKAGE_SIZE', 'Other Package Size');
define('TEXT_MAIN_PRODUCT','Main Product');
define('TEXT_PRODUCTS_WITH_OTHER_PACKAGE_SIZES','Products with Other Package Sizes');

define('TEXT_SHIPPING_CALCULATE_TIPS','<span style="color:red;font-weight:bold;">Note:</span> Please Kindly note that the Shipping Calculator here only applies to the orders <span style="font-weight:bold;">over US$ 19.99.</span> If the order is under US$ 19.99, we will charge US$ 2.99 shipping fee at least.');
define('TEXT_PACK_FOR_OTHER_PACKAGE', 'Pack');
define('TEXT_PRODUCTS_IN_SMALL_PACK', 'Products in Small Pack');
define('TEXT_PRODUCTS_IN_REGULAR_PACK', 'Products in Regular Pack');

define('TEXT_LOGO_TITLE', 'WORLDWIDE FREE SHIPPING');
define('TEXT_DEAR_FN','Dear %s' . "\n\n");
define('TEXT_DEAR_CUSTOMER','Dear customer');

define('TEXT_AVAILABLE_IN715','Ready Time: 7~15 workdays');
define('TEXT_AVAILABLE_IN57','Ready Time: 3~5 workdays');
define('TEXT_PRICE_TITLE_SHOW', 'Bulk wholesale price. If the inventory is not enough, it may take average 5-15 days for preparation.');
define('TEXT_PRODUCTS_DAYS_FOR_PREPARATION_TIP', 'It may take 5-15 days for preparation');

define('TEXT_NOTE_HOLIDAY_5','<p style="margin:0px; padding-top:5px;padding-right:20px;"><b>Holiday Notice:</b><br/>
Oct. 1st is our National Day. Our holiday will be from <b>Oct. 1 to Oct. 4 (GMT+8)</b>. During this period, our office will be closed. To avoid package delivery delay, we warmly suggest you to place order before <b>Sep. 29th</b>.	 
		<br/>Doreenbeads Team</p>');
define('TEXT_NOTE_HOLIDAY_6','<p style="margin:0px; padding-top:5px;padding-right:20px;"><b>Holiday Notice:</b><br/>
Dear customers, we have National Holiday from <b>Oct. 1st to Oct. 4th (GMT+8)</b>. During this period, you can place new orders as usual. We will arrange shipments as soon as we are back from the holiday on <b>Oct.5th (GMT+8)</b>, and we will handle the orders according to the rule of “first in, first out”. So we sincerely suggest that you’d better place orders as early as possible.	 
		<br/>Doreenbeads Team</p>');

define('ENTRY_EMAIL_ADDRESS_REMOTE_CHECK_ERROR','Invalid email. Please be sure to fill in the correct email.');

define('SET_AS_DEFAULT_ADDRESS', 'set as default address');
define('SET_AS_DEFAULT_ADDRESS_SUCCESS', 'Your Default Shipping Address update successfully.');

define('ALERT_EMAIL', "Please enter your email address. Thanks!");
define('ENTER_PASSWORD_PROMPT' , 'Please enter your password.');
define('TEXT_CONFIRM_PASSWORD', "Don’t forget to reenter your password!");
define('TEXT_ENTER_FIRESTNAME', 'Please enter your first name(at least 1 character).');
define('TEXT_ENTER_LASTNAME', 'Please enter your last name(at least 1 character).');
define('TEXT_CONFIRM_PASSWORD_PROMPT' , 'Please confirm your password.');
define('TEXT_EMAIL_NOTE','Be sure to fill in correct email.');

define('TEXT_PROMOTION_DISCOUNT_NOTE','The total price of original priced items has reached <b>{TOTAL}</b>. If the total price reaches <b>{REACH}</b>, you could enjoy <b>{NEXT}</b> off.');

define('TEXT_SMALL_PACK','Small Pack');

 define('TEXT_NDDBC_INFO_OUR_WEBSITE', 'To back to our website, please <a href="%s">click here >></a>');
 define('TEXT_NDDBC_INFO_PREVIOUS_PAGE', 'To go back to previous page,please <a href="%s">click here</a>');
 define('TEXT_NDDBC_INFO','<p class="STYLE1">Dear friend,</p>
<p class="STYLE1">
Thank you for visiting our website. <br /><br />
Currently there is something wrong with our website. When you enter it, you might be guided to this abnormal page. <br />
But please do not worry about it; your previous information on our website has been saved very well. <br /><br />

<strong>%s</strong><br /><br />

If you always see this page when you visit our website, please kindly email us at: <a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a><br />

We feel extremely sorry for any inconvenience brought to you. Thanks for your kind understanding.<br /><br />

Kind Regards <br />
Doreenbeads Team');

define('TEXT_LOG_OFF','Log Off');
define('TEXT_TO_VIEW', 'To view &gt;&gt;');
define('TEXT_CUSTOM_NO','Custom No.');
define('ENTRY_TARIFF_REQUIRED_TEXT' , 'Please write down your Customs No.. It helps customs clearance.');
define('ENTRY_BACKUP_EMAIL_REQUESTED_TEXT' , 'Please fill in your commonly used E-mail address, hence we can reach you in time.');
define('TEXT_EMAIL_HAS_SUBSCRIBED','This email address has subscribed before.');

define('TEXT_ENTER_BIRTHDAY_ERROR','Please choose a valid date of birth.');
define('TEXT_BIRTHDAY_TIPS', 'Fill in your date of birth to get a special gift on your birthday.');
define('TEXT_ENTER_BIRTHDAY_OVER_DATE','The date of birth cannot precede today');define('KEYWORD_FORMAT_STRING', 'Keywords');
define('ERROR_PRODUCT_PRODUCTS_BEEN_REMOVED','Add to Cart Failed，This product has been removed from our inventory at this time.');
define('KEYWORD_FORMAT_STRING', 'Keywords');
define('TEXT_DEAR_CUSTOMER_NAME', 'Customer');

define('TEXT_CHANGED_YOUR_EMAIL_TITLE','You Have Changed Your Email Address of doreenbeads Account');
define('TEXT_HANDINGFEE_INFO','Due to the  labor cost increase, we add 0.99 USD handling fee on a few parcels. Only when an order\'s item amount is less than 9.99USD, the handling fee is needed.');
define('TEXT_CHANGED_YOUR_EMAIL_CONTENT','Dear %s,<br/><br/>
You have successfully changed your email address for doreenbeads account.<br/><br/>

Your old email address: %s<br/>
Your new email address: %s<br/>
Updated time: %s<br/><br/>

If you didn’t request this change, please feel free to <a href="mailto:sale@doreenbeads.com">Contact Us</a>. <br/><br/>

Sincerely,<br/><br/>

Doreenbeads Team');
define('TEXT_SHIPPING_METHOD_DISPLAY_TIPS', 'We hide some shipping methods not often used, <a id="show_all_shipping">show all shipping methods>></a>');

define ( 'TEXT_PAYMENT_BANK_WESTERN_UNION', 'Our Western Union Contact Info ' );

define('TEXT_BUYER_PROTECTION','Buyer Protection');
define('TEXT_BUYER_PROTECTION_TIPS','<p>Full Refund <span>(if you don’t receive your order)</span></p><p>Full or Partial Refund <span>(if the items are not as described)</span></p>');
define('TEXT_FOOTER_ENTER_EMAIL_ADDRESS','Enter Email Address here');
define('TEXT_IMAGE','Image');
define('TEXT_DELETE', 'Delete');
define('TEXT_PRODUCTS_NAME', 'Product Name');
define('TEXT_SHIPPING_RESTRICTION', 'Shipping Restriction');
define('TEXT_SHIPPING_RESTRICTION_TIP', 'This product is prohibited to be carried via certain shipping methods.');

define('PROMOTION_DISPLAY_AREA' , 'Sale');
define('TEXT_SUBMIT_SUCCESS', 'Submitted successfully!');

define('TEXT_API_LOGIN_CUSTOMER', 'Bind Your Existing Account');
define('TEXT_API_REGISTE_NEW_ACCOUNT', 'Create Your doreenbeads Account And Connect With %s');
define('TEXT_API_BIND_ACCOUNT', 'If you already have a Doreenbeads account, you can bind your %s account with the account information.');
define('TEXT_API_REGISTER_ACCOUNT', 'If you don’t have a Doreenbeads account, you can create a new account and bind your %s account with the account information.');

define('TEXT_PAID','Paid');
define('TEXT_SHIPPING_INVOECE_COMMENTS', 'Shipping & Comments');
define('TEXT_SHIPPING_RESTRICTION_IMPORTANT_NOTE', '<b>Important note: </b><br/>Due to shipping restriction, some products in your order may be dispatched separately by airmail, <a href="'.HTTP_SERVER.'/page.html?id=211" style="color:#008fed;" target="_blank">why>></a>');

define('TEXT_DISCOUNT_PRODUCTS_MAX_NUMBER_TIPS', 'This discounted price is limited to %s packs only， otherwise at the original price.');

define('TEXT_TWO_REWARD_COUPONS', 'Two reward coupons only for you, USD 12 can be saved');
define('TEXT_IN_ORDER_TO_THANKS_FOR_YOU', 'In order to thanks for your first order with us, we have sent you 2 coupons to your account. <a href="' . zen_href_link(FILENAME_MY_COUPON) . '" target="_blank">View My Coupon >></a>');
define('EMAIL_ORDER_TRACK_REMIND_NEW','Please kindly have a check to see if there is any wrong information. If you want to correct shipping address, please email us: <a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a> before we ship your parcel out.');
define('TEXT_HOPE_TO_DO_MORE_KIND_BUSINESS','Hope to do more kind business with you. Have a lovely day there~~<br/><br/>
Best regards,<br/><br/>
Doreenbeads Team');
define('BOTTOM_VIP_POLICY', 'View <a style="color:#0786CB;text-decoration: underline;" href="' . zen_href_link(FILENAME_HELP_CENTER,'&id=65') . '" >Discount Policy</a>');
define('IMAGE_NEW_CATEGORY', 'New Category');
define('TEXT_COUPON_CODE','Coupon Code');
define('TEXT_COUPON_PAR_VALUE','Par Value');
define('TEXT_COUPON_MIN_ORDER','Minimum Items Amount');
define('TEXT_COUPON_DEADLINE','Deadline (GMT+8)');
define('TEXT_DISPATCH_FROM_WAREHOUSE', 'Dispatch from warehouse');
define('TEXT_ALL', 'ALL');
define('TEXT_DATE_ADDED','Date Added');
define('TEXT_FILTER_BY', 'Filter By');
define('TEXT_REGULAR_PACK','Regular pack');
define('TEXT_SMALL_PACK','Small pack');
define('TEXT_VIEW_ONLY_SALE_ITEMS', 'View Only Sale Items');
define('TEXT_EMAIL_REG_TIP', 'Email address format is wrong, please fill in the correct email address.');
define('TEXT_DELETE', 'Delete');
define('TEXT_NO_UNREAD_MESSAGE', 'There is no unread message.');
define('TEXT_SETTINGS', 'Setting');
define('TEXT_SEE_ALL_MESSAGES', 'See All Messages');
define('TEXT_TITLE', 'Title');
define('TEXT_MESSAGE', 'Message');
define('TEXT_MY_MESSAGE', 'My Messages');
define('TEXT_MESSAGE_SETTING', 'Messages Setting');
define('TEXT_ALL_MARKED_AS_READ', 'All marked as Read');
define('TEXT_DELETE_ALL', 'Delete All');
define('TEXT_UNREAD_MESSAGE', 'Unread messages');
define('TEXT_MARKED_AS_READ', 'Mark as Read');
define('TEXT_RECEIVE_ALL_MESSAGES', 'Receive all messages');
define('TEXT_RECEIVE_THE_SPECIFIED', 'Receive the specified type of message');
define('TEXT_REJECT_ALL_MESSAGES', 'Reject all messages');
define('TEXT_PLEASE_CHOOSE_AT_LEAST_MESSAGE', 'Please choose at least one type of message.');
define('TEXT_YOU_WILL_NO_LONGER_MESSAGE', 'You will no longer receive all our messages, are you sure?');
define('TEXT_ON_SALE', 'On Sale');
define('TEXT_IN_STOCK', 'In Stock');
define('TEXT_SHIPPING_FROM_USA', 'Ship From USA');
define('TEXT_CHECK_URL','The content you entered contains illegal links, please correct it.');
?>