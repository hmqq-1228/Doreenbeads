<?php
// bof 2.0
define('HEADING_TITLE', 'Shopping Cart');
define('TEXT_CART_IS_EMPTY_DO_SHOPPING', 'Your shopping cart is empty, do some shopping now!');
define('TEXT_CART_IS_EMPTY_SHOP', 'Shop!');
define('TEXT_CART_GO_HOMEPAGE', 'GO to homepage.');
define('TEXT_CART_CONTINUE_SHOPPING', 'Continue Shopping');
define('TEXT_CART_CHECKOUT', 'Checkout');
define('TEXT_CART_MY_CART', 'My Cart');
define('TEXT_CART_MY_VIP', 'My VIP Level');
define('TEXT_CART_OFF', 'OFF');
define('TEXT_CART_EMPTY_CART', 'Delete Selected');
define('TEXT_CART_P_IMG', 'Image');
define('TEXT_CART_P_NUMBER', 'Part No.');
define('TEXT_CART_P_WEIGHT', 'Weight');
define('TEXT_CART_P_V_WEIGHT', 'Volumetric Weight');
define('TEXT_CART_P_NAME', 'Product name');
define('TEXT_CART_P_PRICE', 'Price');
define('TEXT_CART_P_QTY', 'Qty');
define('TEXT_CART_P_SUBTOTAL', 'Subtotal');
define('TEXT_CART_WORD_TOTAL', 'Total');
define('TEXT_CART_WORD_TOTAL1', 'Total');
define('TEXT_CART_WORD_SELECTED', 'Selected');
define('TEXT_CART_ITEM', 'item');
define('TEXT_CART_ITEMS', 'items');
define('TEXT_CART_AMOUNT', 'Amount');
define('TEXT_HANDINGFEE_INFO','Due to the  labor cost increase, we add 0.99 USD handling fee on a few parcels. Only when an order\'s item amount is less than 9.99USD, the handling fee is needed.');
define('TEXT_CART_QUICK_ORDER_BY', 'Quick Add Products');
define('TEXT_CART_QUICK_ORDER_BY_CONTENT', 'You can add products to the shopping cart directly by entering Part No. or in the form of spreadsheet.');

define('TEXT_CART_JS_MOVE_ALL', 'Do you confirm to move selected items to wishlist?');
define('TEXT_CART_JS_MOVE_TO_WISHLIST', 'Do you confirm to move to wishlist?');
define('TEXT_CART_JS_EMPTY_CART', 'Do you confirm to delete selected items in shopping cart?');
define('TEXT_CART_JS_REMOVE_ITEM', 'Are you sure to delete this item?');

define('TEXT_WORD_UPDATE', 'update');
define('TEXT_WORD_ALREADY_UPDATE', 'Saved');

define('TEXT_CART_ORIGINAL_PRICE', 'Original Price');
define('TEXT_CART_PROMOTION_DISCOUNT', 'Promotion Discount');
define('TEXT_CART_SHIPPING_COST', 'Est.Shipping Cost');

/* bof shipping calculator */
define('TEXT_CART_SHIPPING_INFO', 'Shipping Information');
define('TEXT_CART_SHIPPING_COUNTRY', 'Country');
define('TEXT_CART_SHIPPING_CITY', 'City / Town');
define('TEXT_CART_SHIPPING_POSTCODE', 'Zip / Postal code');
define('TEXT_CART_SHIPPING_CAL', 'Calculate');
define('TEXT_CART_SHIPPING_COMPANY', 'Shipping Company');
define('TEXT_CART_SHIPPING_EST_TIME', 'Estimated Shipping Time');
define('TEXT_CART_SHIPPING_EST_COST', 'Shipping Cost');
define('TEXT_CART_SHIPPING_EST_SPECIAL', 'Special Discount');

define('TEXT_CART_SHIPPING_EST_TIME_CODE', '<font title="The following shipping day is just for reference.The actual shipping time may be different for different countries. It will be affected by the distance from China and the local customs policy. ">Est. Shipping Time</font>');
/* eof */

/* bof recently viewed products */
define('TEXT_CART_RECENTLY_VIEWED', 'Recently Viewed');
define('TEXT_CART_RECENTLY_VIEWED_NO_P', 'You haven’t read any goods.');
define('TEXT_CART_RECENTLY_ADD_SUCCESSFULLY', 'Add to cart successfully');
define('TEXT_CART_RECENTLY_ITEMS_TOTALLY', 'Item(s) total');
define('TEXT_CART_RECENTLY_VIEW_CART', 'View Cart');
define('TEXT_CART_RECENTLY_CLOSE', 'Close');

/* eof */

define('ERROR_CART_RECOMMEND_LOGIN', 'To save the items already added in your shopping cart securely, we strongly recommend you to <a href="' . zen_href_link ( FILENAME_LOGIN ) . '">login</a> or <a href="' . zen_href_link ( FILENAME_LOGIN ) . '">register</a> first.');

define('TEXT_CART_REMOVE_THIS_ITEM', 'Remove this item?');

define('TEXT_CART_WEIGHT_UNIT', 'g');

define('TEXT_SERVICE', 'Service');
define('TEXT_SHIPPING_COST_INOF', 'Shipping Cost is calculated by Product Weight plus Package Box Weight.');
define('TEXT_CART_EST_SHIPPING_COST', 'You could change shipping method in the next page.');
define('Text_CART_NEXT_PAGE', 'This discount will be applied by clicking "Use it" button in the next page.');
define('Text_CART_COUPON_AMOUNT', 'Discount Coupon:');

// eof

define('TEXT_UPDATE_QTY_SUCCESS', 'Purchase quantity update successfully!');
define('TEXT_UPDATE_QTY_SUCCESS_MOBILE', 'The quantity is updated to %s.');
define('TEXT_ADDCART_MAX_NOTE', 'Only %s pack(s) of %s are available now. The quantity is updated to %s automatically.');
define('TEXT_ADDCART_MAX_NOTE_ALERT', 'We are sorry but we only have %s packs of %s available at this time. Please kindly update the quantity. Any question, kindly contact us at <a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a>');

define('TEXT_CART_SPECIAL_DISCOUNT', 'Special Discount');

define('TEXT_CART_ADD_WISHLIST_SUCCESS', 'Item(s) Added Successfully into Your Wishlist!');
define('TEXT_CART_VIEW_WISHLIST', 'View Wishlist');
define('TEXT_CART_AVAILABLE_PAYMENT', 'Available Payment Methods');

define('TEXT_SHOPPING_CART_OR', 'or');
define('TEXT_QUESTION_SUBMIT','Submit');
define('CHECKOUT_ADDRESS_BOOK_CANCEL','Cancel');
define('TEXT_NOTE_MAXCHAAR','<b id="rest_characters">254</b> characters remaining');

// readd deleted products into the cart
define('HAS_BEEN_REMOVED', ' has been removed from the shopping cart.');
define('RE_ADD', 'Re-add');

define('TEXT_CART_GO_SHOPPING', 'Go shopping');
define('TEXT_CART_INVALID_ITEMS', 'Invalid Items');
define('TEXT_CART_EMPTY_INVALID_ITEMS', 'Empty Invalid Items');
define('TEXT_CART_SAVE_PRICE', 'Original Price is %s. You Save %s.');

define('TEXT_SHOPPING_CART_COUPON_TIPS', 'You can use the following coupons to reduce order amount only when item price reaches minimum amount below.');
define('TEXT_MY_AVTIVE_COUPONS', 'My Active Coupons');

define('TEXT_BY_SPREADSHEET_TIPS', '1.<a href="'.HTTP_SERVER.'/file/template_spreadsheet.xls"><font color="#06c">Click here</font></a> to download the spreadsheet.<br/>
									2.Fill in the spreadsheet with the items\' part no. and quantities you need. <br/>
									3.Add the attachment and upload it,and the items will be added to your cart successfully.
								');

define('TEXT_UPLOAD_EXCEL_ERROR_TIPS', 'Format only Accept: .xlsx,.xls .One file should be no more than 2MB.');
?>