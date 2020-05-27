<?php
/**
 * File contains just the shopping cart class
 *
 * @package classes
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: shopping_cart.php 4884 2006-11-05 00:32:55Z ajeh $
 */
/**
 * Class for managing the Shopping Cart
 *
 * @package classes
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
class shoppingCart extends base {
    /**
     * is the shopping cart has gidt already?
     * @var boolean robbie
     */
    var $have_gift = false;
    /**
     * is the shopping cart has gidt already?
     * @var boolean robbie
     */
    var $gift_id;
    /**
     * shopping cart total price
     * @var decimal
     */
    var $total;

    var $total_new;

    var $total_original;

    /**
     * shopping cart total weight
     * @var decimal
     */

    public $promotion_total;
    public $promotion_weight;

    var $weight;

    /**
     * shopping cart total weight Including Volume weight
     * @var decimal
     * add by robbie
     */
    var $volume_weight;

    /**
     * shopping cart total weight
     * @var decimal
     * add by robbie
     */
    var $volume_shipping_weight;

    /**
     * cart identifier
     * @var integer
     */
    var $cartID;
    /**
     * overall content type of shopping cart
     * @var string
     */
    var $content_type;
    /**
     * constructor method
     *
     * Simply resets the users cart.
     * @return void
     */
    var $discount_num;
    var $deduct_shippingfee;
    private $products_volume_weight_orgin;

    function shoppingCart() {
        $this->notify('NOTIFIER_CART_INSTANTIATE_START');
        $this->reset();
        if (!isset($_SESSION['customer_id']) && !isset($_SESSION['cookie_cart_id'])) $this->set_cookie_id();
        $this->notify('NOTIFIER_CART_INSTANTIATE_END');
    }
    /**
     * Method to restore cart contents
     *
     * For customers who login, cart contents are also stored in the database.
     * {TABLE_CUSTOMER_BASKET et al}. This allows the system to remember the
     * contents of their cart over multiple sessions.
     * This method simply retrieve the content of the databse store cart
     * for a given customer. Note also that if the customer already has
     * some items in their cart before they login, these are merged with
     * the stored contents.
     *
     * @return void
     * @global object access to the db object
     */
    /**
     * paypalwpp.php
     * login/header_php.php
     * time_out/header_php.php
     * index/header_php.php
     * create_account/header_php.php
     * @return unknown
     */
    function restore_contents($as_old_cookie = '/') {
        global $db;

        if (!$_SESSION['customer_id'])
            return false;
        $this->notify('NOTIFIER_CART_RESTORE_CONTENTS_START');
        // insert current cart contents in database

        if (zen_not_null($as_old_cookie)) {
            $this->shopping_cart_merge_items = array ();
            $cookie_products_query = "select *
				    							from " . TABLE_CUSTOMERS_BASKET . "
				    						   where cookie_id = '" . $as_old_cookie . "'";
            $cookie_products = $db->Execute($cookie_products_query);

            if ($cookie_products->RecordCount() > 0) {
                while (!$cookie_products->EOF) {
                    $products_id = $cookie_products->fields['products_id'];
                    $qty = $cookie_products->fields['customers_basket_quantity'];

                    $product_query = "select products_id, customers_basket_id
					                            from " . TABLE_CUSTOMERS_BASKET . "
					                           where customers_id = " . $_SESSION['customer_id'] . "
					                             and products_id = " . zen_db_input($products_id);
                    $product = $db->Execute($product_query);

                    if ($product->RecordCount() <= 0) {
                        $sql = "update " . TABLE_CUSTOMERS_BASKET . "
						          			 set customers_id = " . $_SESSION['customer_id'] . ",
						          			     cookie_id = ''
						          		   where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
						          		     and products_id = " . zen_db_input($products_id);
                        $db->Execute($sql);


                    } else {
                        $sql = "update " . TABLE_CUSTOMERS_BASKET . "
						                     set customers_basket_quantity = customers_basket_quantity + " . $qty . "
						                   where customers_id = " . $_SESSION['customer_id'] . "
						                     and products_id = " . zen_db_input($products_id);
                        $db->Execute($sql);

                        $db->Execute("delete from " . TABLE_CUSTOMERS_BASKET . "
						          				 where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
						          				   and customers_id = 0
						          				   and products_id = " . zen_db_input($products_id));
                        if ($qty > 0) {
                            $this->shopping_cart_merge_items[$product->fields['customers_basket_id']] = $qty;
                        }
                    }
                    $cookie_products->MoveNext();
                }
            }
        }

        setcookie("cookie_cart_id", "", time() - 3600, '/', '.' . BASE_SITE);
        unset ($_SESSION['cookie_cart_id']);
        unset ($_SESSION['count_cart']);
        $this->notify('NOTIFIER_CART_RESTORE_CONTENTS_END');
        $this->cleanup();
    }
    /**
     * Method to reset cart contents
     *
     * resets the contents of the session cart(e,g, empties it)
     * Depending on the setting of the $reset_database parameter will
     * also empty the contents of the database stored cart. (Only relevant
     * if the customer is logged in)
     *
     * @param boolean whether to reset customers db basket
     * @return void
     * @global object access to the db object
     */
    function reset($reset_database = false) {


        unset($this->cartID);
        $_SESSION['cartID'] = '';
        $this->notify('NOTIFIER_CART_RESET_END');
    }
    /**
     * Method to add an item to the cart
     *
     * This method is usually called as the result of a user action.
     * As the method name applies it adds an item to the uses current cart
     * and if the customer is logged in, also adds to the database sored
     * cart.
     *
     * @param integer the product ID of the item to be added
     * @param decimal the quantity of the item to be added
     * @param array any attributes that are attache to the product
     * @param boolean whether to add the product to the notify list
     * @return string
     * @global object access to the db object
     * @todo ICW - documentation stub
     */
    function add_cart($products_id, $qty = '1', $attributes = '', $notify = true) {
        global $db, $messageStack;
        $action = "insert";

        $this->notify('NOTIFIER_CART_ADD_CART_START');

        $products_id = zen_get_uprid($products_id, $attributes);
        if ($notify == true) {
            $_SESSION['new_products_id_in_cart'] = $products_id;
        }

        $qty = $this->adjust_quantity($qty, $products_id, 'shopping_cart');
        if($products_id == $_SESSION['gift_id']){
            $qty = 1;
            if (isset($_SESSION['customer_id'])&& $_SESSION['customer_gift']>0) {
                $check_qty = $db->Execute("select products_id from ".TABLE_PRODUCTS." where products_id='".$_SESSION['gift_id']."' and products_status=1");
                if($check_qty->RecordCount()<1){
                    return false;
                }else{
                    $check_quantity = zen_get_products_stock($check_qty->fields['products_id']);
                    if($check_quantity<1){
                        return false;
                    }
                }
            }else{
                return false;
            }
        }
        if ($this->in_cart($products_id)) {
            $action = "update";
            $this->update_quantity($products_id, $qty, $attributes);
        } else {
            // insert into database
            if (isset($_SESSION['customer_id'])) {
                $li_customer_id = $_SESSION['customer_id'];
                $ls_cookie_id = '';
            } else {
                $li_customer_id = 0;
                $ls_cookie_id = $_SESSION['cookie_cart_id'];
            }

            $sql = "insert into " . TABLE_CUSTOMERS_BASKET . "
    	      (customers_id, cookie_id, products_id, customers_basket_quantity, customers_basket_date_added, last_modify)
              values (" . $li_customer_id . ", '" . $ls_cookie_id . "', " . zen_db_input($products_id) . ", " . $qty . ", " . date('Ymd') . ", '" . date('Y-m-d H:i:s') . "')";

            $db->Execute($sql);

            if (is_array($attributes)) {
                reset($attributes);
                while (list($option, $value) = each($attributes)) {
                    //CLR 020606 check if input was from text box.  If so, store additional attribute information
                    //CLR 020708 check if text input is blank, if so do not add to attribute lists
                    //CLR 030228 add htmlspecialchars processing.  This handles quotes and other special chars in the user input.
                    $attr_value = NULL;
                    $blank_value = FALSE;
                    if (strstr($option, TEXT_PREFIX)) {
                        if (trim($value) == NULL) {
                            $blank_value = TRUE;
                        } else {
                            $option = substr($option, strlen(TEXT_PREFIX));
                            $attr_value = stripslashes($value);
                            $value = PRODUCTS_OPTIONS_VALUES_TEXT_ID;
                        }
                    }

                    if (!$blank_value) {
                        // insert into database
                        //CLR 020606 update db insert to include attribute value_text. This is needed for text attributes.
                        //CLR 030228 add zen_db_input() processing
                        if (isset($_SESSION['customer_id'])) {
                            //              if (zen_session_is_registered('customer_id')) zen_db_query("insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " (customers_id, products_id, products_options_id, products_options_value_id, products_options_value_text) values ('" . (int)$customer_id . "', '" . zen_db_input($products_id) . "', '" . (int)$option . "', '" . (int)$value . "', '" . zen_db_input($attr_value) . "')");
                            if (is_array($value) ) {
                                reset($value);
                                while (list($opt, $val) = each($value)) {
                                    $products_options_sort_order= zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $opt);
                                    $sql = "insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                          (customers_id, products_id, products_options_id, products_options_value_id, products_options_sort_order)
                          values (" . $_SESSION['customer_id'] . ", " . zen_db_input($products_id) . ", '" . (int)$option.'_chk'.$val . "', '" . $val . "',  '" . $products_options_sort_order . "')";
                                    $db->Execute($sql);
                                }
                            } else {
                                if ($attr_value) {
                                    $attr_value = zen_db_input($attr_value);
                                }
                                $products_options_sort_order= zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $value);
                                $sql = "insert into " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                        (customers_id, products_id, products_options_id, products_options_value_id, products_options_value_text, products_options_sort_order)
                        values (" . $_SESSION['customer_id'] . ", " . zen_db_input($products_id) . ", '" . (int)$option . "', '" . $value . "', '" . $attr_value . "', '" . $products_options_sort_order . "')";
                                $db->Execute($sql);
                            }
                        }
                    }
                }
            }
        }

        $this->cleanup();
        // assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure

        $_SESSION['count_cart'] = $this->get_products_items();
        $this->cartID = $this->generate_cart_id();
        $this->notify('NOTIFIER_CART_ADD_CART_END');
        return $action;
    }

    function addselectedtocart($products_id, $qty, $attributes = '', $notify = true) {
        $add_max = zen_get_products_quantity_order_max($products_id);
        $cart_qty = $this->in_cart_mixed($products_id);
        $new_qty = $qty;
        //die('I see Buy Now Cart: ' . $add_max . ' - cart qty: ' . $cart_qty . ' - newqty: ' . $new_qty);
        if (($add_max == 1 and $cart_qty == 1)) {
            // do not add
            $new_qty = 0;
        } else {
            // adjust quantity if needed
            if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
                $new_qty = $add_max - $cart_qty;
            }
        }
        if ((zen_get_products_quantity_order_max($products_id) == 1 and $this->in_cart_mixed($products_id) == 1)) {
            // do not add
        } else {
            // check for min/max and add that value or 1
            // $add_qty = zen_get_buy_now_qty($_GET['products_id']);
            $this->add_cart($products_id, $this->get_quantity($products_id)+$new_qty);
        }
        $_SESSION['count_cart'] = $this->get_products_items();
    }
    /**
     * Method to update a cart items quantity
     *
     * Changes the current quamtity of a certain item in the cart to
     * a new value. Also updates the database sored cart if customer is
     * logged in.
     *
     * @param mixed product ID of item to update
     * @param decimal the quantity to update the item to
     * @param array product atributes attached to the item
     * @return void
     * @global object access to the db object
     */
    function update_quantity($products_id, $quantity = '', $attributes = '', $update_last_modify = true) {
        global $db;
        $this->notify('NOTIFIER_CART_UPDATE_QUANTITY_START');
        if (empty($quantity)) return true; // nothing needs to be updated if theres no quantity, so we return true..
        if ($update_last_modify){
            $str_last_modify = ", last_modify = '" . date('Y-m-d H:i:s') . "' ";
        }else{
            $str_last_modify = "";
        }
        // update database
        if (isset($_SESSION['customer_id'])) {
            $sql = "update " . TABLE_CUSTOMERS_BASKET . "
                 set customers_basket_quantity = " . $quantity . "" . $str_last_modify . "
               where customers_id = " . $_SESSION['customer_id'] . "
                 and products_id = " . zen_db_input($products_id) . "";
            $db->Execute($sql);
        } else {
            $sql = "update " . TABLE_CUSTOMERS_BASKET . "
	 		     set customers_basket_quantity = " . $quantity . "" . $str_last_modify . "
	 		   where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
	 		     and products_id = " . zen_db_input($products_id);
            $db->Execute($sql);
        }

        if (is_array($attributes)) {
            reset($attributes);
            while (list($option, $value) = each($attributes)) {
                $attr_value = NULL;
                $blank_value = FALSE;
                if (strstr($option, TEXT_PREFIX)) {
                    if (trim($value) == NULL) {
                        $blank_value = TRUE;
                    } else {
                        $option = substr($option, strlen(TEXT_PREFIX));
                        $attr_value = stripslashes($value);
                        $value = PRODUCTS_OPTIONS_VALUES_TEXT_ID;
                    }
                }

                if (!$blank_value) {
                    if ($attr_value) {
                        $attr_value = zen_db_input($attr_value);
                    }
                    if (is_array($value)) {
                        reset($value);
                        while (list($opt, $val) = each($value)) {
                            $products_options_sort_order= zen_get_attributes_options_sort_order(zen_get_prid($products_id), $option, $opt);
                            if (isset($_SESSION['customer_id'])){
                                $sql = "update " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                           set products_options_value_id = '" . $val . "'
                         where customers_id = " . $_SESSION['customer_id'] . "
                           and products_id = " . zen_db_input($products_id) . "
                           and products_options_id = '" . (int)$option.'_chk'.$val . "'";
                            } else {
                                $sql = "update " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                           set products_options_value_id = '" . $val . "'
                         where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
                           and products_id = " . zen_db_input($products_id) . "
                           and products_options_id = '" . (int)$option.'_chk'.$val . "'";
                            }
                            $db->Execute($sql);
                        }
                    } else {
                        if (isset($_SESSION['customer_id'])) {
                            $sql = "update " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                           set products_options_value_id = '" . $value . "', products_options_value_text = '" . $attr_value . "'
                         where customers_id = " . $_SESSION['customer_id'] . "
                           and products_id = " . zen_db_input($products_id) . "
                           and products_options_id = '" . (int)$option . "'";
                        } else {
                            $sql = "update " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
                           set products_options_value_id = '" . $value . "', products_options_value_text = '" . $attr_value . "'
                         where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
                           and products_id = " . zen_db_input($products_id) . "
                           and products_options_id = '" . (int)$option . "'";
                        }
                        $db->Execute($sql);
                    }
                }
            }
        }
        $_SESSION['count_cart'] = $this->get_products_items();
        $this->notify('NOTIFIER_CART_UPDATE_QUANTITY_END');
    }
    /**
     * Method to clean up carts contents
     *
     * For various reasons, the quantity of an item in the cart can
     * fall to zero. This method removes from the cart
     * all items that have reached this state. The database-stored cart
     * is also updated where necessary
     *
     * @return void
     * @global object access to the db object
     */
    function cleanup() {
        global $db, $messageStack;

        $this->notify('NOTIFIER_CART_CLEANUP_START');
        if (isset($_SESSION['customer_id'])){
            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
    		   where customers_id = " . $_SESSION['customer_id'] . "
    		     and customers_basket_quantity <= 0";
        } else {
            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
      		   where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
      		     and customers_id <> 0
      		     and customers_basket_quantity <= 0";
        }
        $db->Execute($sql);
        $this->notify('NOTIFIER_CART_CLEANUP_END');

//    $products = $this->customers_basket();
//    while (!$products->EOF) {
//    	$key = $products->fields['products_id'];
//        if ($products->fields['customers_basket_quantity'] <= 0) {
//          if (isset($_SESSION['customer_id'])){
//            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
//                     where customers_id = '" . (int)$_SESSION['customer_id'] . "'
//                       and products_id = '" . $key . "'";
//            $db->Execute($sql);
//
//            $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
//                     where customers_id = '" . (int)$_SESSION['customer_id'] . "'
//                       and products_id = '" . $key . "'";
//            $db->Execute($sql);
//          } else {
//          	$sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
//                     where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
//                       and customers_id = 0
//                       and products_id = '" . $key . "'";
//            $db->Execute($sql);
//
//            $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
//                     where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
//                       and customers_id = 0
//                       and products_id = '" . $key . "'";
//            $db->Execute($sql);
//          }
//        }
//        $products->MoveNext();
//    }
    }
    /**
     * Method to count total number of items in cart
     *
     * Note this is not just the number of distinct items in the cart,
     * but the number of items adjusted for the quantity of each item
     * in the cart, So we have had 2 items in the cart, one with a quantity
     * of 3 and the other with a quantity of 4 our total number of items
     * would be 7
     * @return total number of items in cart
     */
    function count_contents() {
        global $db;
        $this->notify('NOTIFIER_CART_COUNT_CONTENTS_START');
        $total_items = 0;
        if (isset($_SESSION['customer_id'])){
            $products_query = "select sum(customers_basket_quantity) as total_items
    					     from " . TABLE_CUSTOMERS_BASKET . "
    					    where customers_id = " . (int)$_SESSION['customer_id'];
        } else {
            $products_query = "select sum(customers_basket_quantity) as total_items
    						 from " . TABLE_CUSTOMERS_BASKET . "
    						where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
    						  and customers_id = 0";
        }
        $products = $db->Execute($products_query);
        $total_items = (float)$products->fields['total_items'];
        $this->notify('NOTIFIER_CART_COUNT_CONTENTS_END');
        return $total_items;
    }
    /**
     * Method to get the quantity of an item in the cart
     *
     * @param mixed product ID of item to check
     * @return decimal the quantity of the item
     */
    function get_quantity($products_id) {
        global $db;
        $this->notify('NOTIFIER_CART_GET_QUANTITY_START');
        $quantity = $this->customers_basket($products_id);
        $this->notify('NOTIFIER_CART_GET_QUANTITY_END');
        return (float)$quantity->fields['customers_basket_quantity'];
    }
    /**
     * Method to check whether a product exists in the cart
     *
     * @param mixed product ID of item to check
     * @return boolean
     */
    function in_cart($products_id) {
        global $db;
        $this->notify('NOTIFIER_CART_IN_CART_START');
        $cart = $this->customers_basket($products_id);
        $this->notify('NOTIFIER_CART_IN_CART_END');

        if ($cart->RecordCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method to remove an item from the cart
     *
     * @param mixed product ID of item to remove
     * @param booelan refresh_cart_info
     * @return void
     * @global object access to the db object
     */
    function remove($products_id, $refresh_cart_info = true) {
        global $db, $messageStack;
        $this->notify('NOTIFIER_CART_REMOVE_START');

        //Tianwen.Wan20160624购物车优化->是数组现时批量删除
        $products_id_where = "=" . zen_db_input($products_id);
        if(!empty($products_id) && is_array($products_id)) {
            $products_id_where = "in(" . implode($products_id, ",") . ")";
        }

        if ($_SESSION['customer_id']) {
            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
               where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                 and products_id " . $products_id_where;
            $db->Execute($sql);

            $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
               where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                 and products_id " . $products_id_where;
            $db->Execute($sql);
        } else {
            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
      		   where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
      		     and customers_id = 0
      		     and products_id " . $products_id_where;
            $db->Execute($sql);

            $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
      		   where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
      		     and customers_id = 0
      		     and products_id " . $products_id_where;
            $db->Execute($sql);
        }

        // assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
        $this->cartID = $this->generate_cart_id();
        //Tianwen.Wan20160624购物车优化->加判断循环调用此方法时不调用
        if ($refresh_cart_info) {
            //$this->calculate();
            $this->get_isvalid_checkout_products_optimize();
            $_SESSION['count_cart'] = $this->get_products_items();
        }
        $this->notify('NOTIFIER_CART_REMOVE_END');
    }
    /**
     * Method remove all products from the cart
     *
     * @return void
     */
    function remove_all($is_include_not_checked = true) {
        global $db, $messageStack;

        $this->notify('NOTIFIER_CART_REMOVE_ALL_START');
        $is_checked_where = "";
        if($is_include_not_checked == false) {
            $is_checked_where .= " and is_checked = 1";
        }
        if (isset($_SESSION['customer_id'])){
//    	$messageStack->add_session('header', 'Delete the product at remove_all in sp', 'caution');
            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
    			 where customers_id = " . $_SESSION['customer_id'] . $is_checked_where;
            $db->Execute($sql);

            $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
    			 where customers_id = " . $_SESSION['customer_id'];
            $db->Execute($sql);
        } else {
//    	$messageStack->add_session('header', 'Delete the product at remove_all2 in sp', 'caution');
            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
    			 where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
    			   and customers_id = 0" . $is_checked_where;
            $db->Execute($sql);

            $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
    			 where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
    			   and customers_id = 0";
            $db->Execute($sql);
        }
        $_SESSION['count_cart'] = $this->get_products_items();
        $this->notify('NOTIFIER_CART_REMOVE_ALL_END');
    }
    /**
     * Method return a comma separated list of all products in the cart
     *
     * @return string
     * @todo ICW - is this actually used anywhere?
     */
    function get_product_id_list() {
        global $db;
        $product_id_list = '';
        $products_list = $this->customers_basket();
        if ($products_list->RecordCount() > 0){
            while (!$products_list->EOF){
                $product_id_list .= $products_list->fields['products_id'] . ', ';
                $products_list->MoveNext();
            }
            $product_id_list = substr($product_id_list, 0, -2);
        }
        return $product_id_list;
    }

    /**
     * Method to calculate price of attributes for a given item
     *
     * @param mixed the product ID of the item to check
     * @return decimal the pice of the items attributes
     * @global object access to the db object
     */
    function attributes_price($products_id) {
        global $db;

        $attributes_price = 0;
        $products = $this->customers_basket($products_id);
        $products_attribute = $this->customers_basket_attribute($products_id);

        $qty = $products->fields['customers_basket_quantity'];

        if ($products_attribute->RecordCount() > 0) {
            while (!$products_attribute->EOF) {
                $option = $products_attribute->fields['products_options_id'];
                $value = $products_attribute->fields['products_options_value_id'];

                $attribute_price_query = "select *
                                    from " . TABLE_PRODUCTS_ATTRIBUTES . "
                                   where products_id = '" . (int)$products_id . "'
                                     and options_id = '" . (int)$option . "'
                                     and options_values_id = '" . (int)$value . "'";
                $attribute_price = $db->Execute($attribute_price_query);

                $new_attributes_price = 0;
                $discount_type_id = '';
                $sale_maker_discount = '';

                //          if ($attribute_price->fields['product_attribute_is_free']) {
                if ($attribute_price->fields['product_attribute_is_free'] == '1' and zen_get_products_price_is_free((int)$products_id)) {
                    // no charge
                } else {
                    // + or blank adds
                    if ($attribute_price->fields['price_prefix'] == '-') {
                        // calculate proper discount for attributes
                        if ($attribute_price->fields['attributes_discounted'] == '1') {
                            $discount_type_id = '';
                            $sale_maker_discount = '';
                            $new_attributes_price = zen_get_discount_calc($products_id, $attribute_price->fields['products_attributes_id'], $attribute_price->fields['options_values_price'], $qty);
                            $attributes_price -= ($new_attributes_price);
                        } else {
                            $attributes_price -= $attribute_price->fields['options_values_price'];
                        }
                    } else {
                        if ($attribute_price->fields['attributes_discounted'] == '1') {
                            // calculate proper discount for attributes
                            $discount_type_id = '';
                            $sale_maker_discount = '';
                            $new_attributes_price = zen_get_discount_calc($products_id, $attribute_price->fields['products_attributes_id'], $attribute_price->fields['options_values_price'], $qty);
                            $attributes_price += ($new_attributes_price);
                        } else {
                            $attributes_price += $attribute_price->fields['options_values_price'];
                        }
                    }

                    //////////////////////////////////////////////////
                    // calculate additional charges
                    // products_options_value_text
                    if (zen_get_attributes_type($attribute_price->fields['products_attributes_id']) == PRODUCTS_OPTIONS_TYPE_TEXT) {
                        $text_words = zen_get_word_count_price($products_attribute->fields['products_options_value_text'], $attribute_price->fields['attributes_price_words_free'], $attribute_price->fields['attributes_price_words']);
                        $text_letters = zen_get_letters_count_price($products_attribute->fields['products_options_value_text'], $attribute_price->fields['attributes_price_letters_free'], $attribute_price->fields['attributes_price_letters']);
                        $attributes_price += $text_letters;
                        $attributes_price += $text_words;
                    }
                    // attributes_price_factor
                    $added_charge = 0;
                    if ($attribute_price->fields['attributes_price_factor'] > 0) {
                        $chk_price = zen_get_products_base_price($products_id);
                        $chk_special = zen_get_products_special_price($products_id, false);
                        $added_charge = zen_get_attributes_price_factor($chk_price, $chk_special, $attribute_price->fields['attributes_price_factor'], $attribute_price->fields['attributes_price_factor_offset']);
                        $attributes_price += $added_charge;
                    }
                    // attributes_qty_prices
                    $added_charge = 0;
                    if ($attribute_price->fields['attributes_qty_prices'] != '') {
                        $chk_price = zen_get_products_base_price($products_id);
                        $chk_special = zen_get_products_special_price($products_id, false);
                        $added_charge = zen_get_attributes_qty_prices_onetime($attribute_price->fields['attributes_qty_prices'], $qty);
                        $attributes_price += $added_charge;
                    }

                    //////////////////////////////////////////////////
                }
                // Validate Attributes
                if ($attribute_price->fields['attributes_display_only']) {
                    $_SESSION['valid_to_checkout'] = false;
                    $_SESSION['cart_errors'] .= zen_get_products_name($attribute_price->fields['products_id'], $_SESSION['languages_id']) . ERROR_PRODUCT_OPTION_SELECTION . '<br />';
                }

                $products_attribute->MoveNext();
            }
        }

        return $attributes_price;
    }
    /**
     * Method to calculate one time price of attributes for a given item
     *
     * @param mixed the product ID of the item to check
     * @param decimal item quantity
     * @return decimal the pice of the items attributes
     * @global object access to the db object
     */
    function attributes_price_onetime_charges($products_id, $qty) {
        global $db;

        $attributes_price_onetime = 0;
        $products_attribute = $this->customers_basket_attribute($products_id);

        if ($products_attribute->RecordCount() > 0) {
            while (!$products_attribute->EOF) {
                $option = $products_attribute->fields['products_options_id'];
                $value = $products_attribute->fields['products_options_value_id'];

                $attribute_price_query = "select *
                                    from " . TABLE_PRODUCTS_ATTRIBUTES . "
                                   where products_id = '" . (int)$products_id . "'
                                     and options_id = '" . (int)$option . "'
                                     and options_values_id = '" . (int)$value . "'";

                $attribute_price = $db->Execute($attribute_price_query);

                $new_attributes_price = 0;
                $discount_type_id = '';
                $sale_maker_discount = '';

                //          if ($attribute_price->fields['product_attribute_is_free']) {
                if ($attribute_price->fields['product_attribute_is_free'] == '1' and zen_get_products_price_is_free((int)$products_id)) {
                    // no charge
                } else {
                    $discount_type_id = '';
                    $sale_maker_discount = '';
                    $new_attributes_price = zen_get_discount_calc($products_id, $attribute_price->fields['products_attributes_id'], $attribute_price->fields['options_values_price'], $qty);

                    if ($attribute_price->fields['attributes_price_onetime'] > 0) {
                        if ((int)$products_id != $products_id) {
                            die('I DO NOT MATCH ' . $products_id);
                        }
                        $attributes_price_onetime += $attribute_price->fields['attributes_price_onetime'];
                    }
                    // attributes_price_factor_onetime
                    $added_charge = 0;
                    if ($attribute_price->fields['attributes_price_factor_onetime'] > 0) {
                        $chk_price = zen_get_products_base_price($products_id);
                        $chk_special = zen_get_products_special_price($products_id, false);
                        $added_charge = zen_get_attributes_price_factor($chk_price, $chk_special, $attribute_price->fields['attributes_price_factor_onetime'], $attribute_price->fields['attributes_price_factor_onetime_offset']);

                        $attributes_price_onetime += $added_charge;
                    }
                    // attributes_qty_prices_onetime
                    $added_charge = 0;
                    if ($attribute_price->fields['attributes_qty_prices_onetime'] != '') {
                        $chk_price = zen_get_products_base_price($products_id);
                        $chk_special = zen_get_products_special_price($products_id, false);
                        $added_charge = zen_get_attributes_qty_prices_onetime($attribute_price->fields['attributes_qty_prices_onetime'], $qty);
                        $attributes_price_onetime += $added_charge;
                    }

                    //////////////////////////////////////////////////
                }
            }
        }

        return $attributes_price_onetime;
    }
    /**
     * Method to calculate weight of attributes for a given item
     *
     * @param mixed the product ID of the item to check
     * @return decimal the weight of the items attributes
     */
    function attributes_weight($products_id) {
        global $db;

        $attribute_weight = 0;
        $products_attribute = $this->customers_basket_attribute($products_id);

        if ($products_attribute->RecordCount() > 0) {
            while (!$products_attribute->EOF) {
                $option = $products_attribute->fields['products_options_id'];
                $value = $products_attribute->fields['products_options_value_id'];

                $attribute_weight_query = "select products_attributes_weight, products_attributes_weight_prefix
                                     from " . TABLE_PRODUCTS_ATTRIBUTES . "
                                    where products_id = '" . (int)$products_id . "'
                                      and options_id = '" . (int)$option . "'
                                      and options_values_id = '" . (int)$value . "'";

                $attribute_weight_info = $db->Execute($attribute_weight_query);

                // adjusted count for free shipping
                $product = $db->Execute("select products_id, product_is_always_free_shipping
		                           from " . TABLE_PRODUCTS . "
		                          where products_id = '" . (int)$products_id . "'");

                if ($product->fields['product_is_always_free_shipping'] != 1) {
                    $new_attributes_weight = $attribute_weight_info->fields['products_attributes_weight'];
                } else {
                    $new_attributes_weight = 0;
                }

                // + or blank adds
                if ($attribute_weight_info->fields['products_attributes_weight_prefix'] == '-') {
                    $attribute_weight -= $new_attributes_weight;
                } else {
                    $attribute_weight += $attribute_weight_info->fields['products_attributes_weight'];
                }
            }
        }

        return $attribute_weight;
    }
    /**
     * Method to return details of all products in the cart
     *
     * @param boolean whether to check if cart contents are valid
     * @return array
     */

    //jessa 2010-09-26
    function get_products_num() {
        global $db;
        if (isset($_SESSION['customer_id'])){
            $products_query = "select count(products_id) as products_num
  	  					   from " . TABLE_CUSTOMERS_BASKET . "
  	  					  where customers_id = " . (int)$_SESSION['customer_id'];
        } else {
            $products_query = "select count(products_id) as products_num
  	  					   from " . TABLE_CUSTOMERS_BASKET . "
  	  					  where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'";
        }
        $products = $db->Execute($products_query);

        if ($products->RecordCount() > 0){
            return (float)$products->fields['products_num'];
        } else {
            return 0;
        }
    }
    //eof jessa 2010-09-26

    function get_products_items() {
        global $db;
        if (isset($_SESSION['customer_id'])){
            $products_query = 'select count(1) as count
  	  						from ' . TABLE_CUSTOMERS_BASKET . ' cb inner join ' . TABLE_PRODUCTS . ' p on cb.products_id = p.products_id and p.products_status = 1
  	  					    where cb.customers_id = ' . $_SESSION['customer_id'];
        } else {
            if(empty($_SESSION['cookie_cart_id'])) {
                return 0;
            }
            $products_query = 'select count(1) as count
  	  						from ' . TABLE_CUSTOMERS_BASKET . ' cb inner join ' . TABLE_PRODUCTS . ' p on cb.products_id = p.products_id and p.products_status = 1
  	  					    where cb.cookie_id = "' . $_SESSION['cookie_cart_id'] . '"';
        }
        $products = $db->Execute($products_query);

        if ($products->RecordCount() > 0){
            return $products->fields['count'];
        } else {
            return 0;
        }
    }

    function removemultiple($products_array){
        global $db, $messageStack;
        if (!is_array($products_array)) return false;

        $products_id_list = '';
        for ($i = 0; $i < sizeof($products_array); $i++){
            $products_id_list .= $products_array[$i] . ', ';
        }
        $products_id_list = substr($products_id_list, 0, -2);

        if (isset($_SESSION['customer_id'])){
//    	$messageStack->add_session('header', 'Delete the product at removemultiple in sp', 'caution');
            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
  		 		 where products_id in (" . $products_id_list . ")
  		 		   and customers_id = " . (int)$_SESSION['customer_id'];
            $db->Execute($sql);

            $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
  				 where products_id in (" . $products_id_list . ")
  				   and customers_id = " . (int)$_SESSION['customer_id'];
            $db->Execute($sql);
        } else {
//    	$messageStack->add_session('header', 'Delete the product at removemultiple2 in sp', 'caution');
            $sql = "delete from " . TABLE_CUSTOMERS_BASKET . "
  				 where products_id in (" . $products_id_list . ")
  				   and cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
  				   and customers_id = 0";
            $db->Execute($sql);

            $sql = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
  				 where products_id in (" . $products_id_list . ")
  				   and cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
  				   and customers_id = 0";
            $db->Execute($sql);
        }
        $_SESSION['count_cart'] = $this->get_products_items();
    }


    /**
     * Method to calculate total price of items in cart
     *
     * @return decimal Total Price
     */
    function show_total() {
        return $this->total;
    }

    /**
     * author zale
     * date 20130403
     * version 2.0
     * Method to calculate original total price of items in cart, Have convert rates
     * @return decimal Original Total Price
     */
    function show_total_original() {
        return $this->total_original;
    }


    function show_total_new() {
        return $this->total_new;
    }
    
    function  get_volume_weight_orgin(){
        return $this->products_volume_weight_orgin;
    }

    function show_promotion_total(){
        return $this->promotion_total;
    }
    function show_daily_deal_total(){
        return $this->daily_deal_total;
    }
    function show_promotion_total_usd (){
        return $this->promotion_total_usd;
    }
    /**
     * Method to calculate total weight of items in cart
     *
     * @return decimal Total Weight
     */
    function show_weight() {
        return $this->weight;
    }

    function promotion_weight() {
        return $this->promotion_weight;
    }

    /**
     * Method to calculate total weight of items in cart including volume weight
     *
     * @return decimal Volume Shipping Weight
     * By Robbie 2010-05-04
     * ���Ӹú���õ�����������
     */
    function show_volume_weight() {
        return $this->volume_weight;
    }
    function show_volume_weight_ems() {
        return $this->volume_weight_ems;
    }

    /**
     * Method to calculate total shipping weight of items in cart including volume weight
     *
     * @return decimal Volume Shipping Weight
     * By Robbie 2010-05-04
     * ���Ӹú���õ���������������
     */
    function show_shipping_volume_weight() {
        $this->volume_shipping_weight = ($this->show_volume_weight() > 50000 ? $this->volume_weight * 1.06 : $this->volume_weight * 1.1);
        return $this->volume_shipping_weight;
    }
    function show_shipping_volume_weight_ems() {
        $this->volume_shipping_weight_ems = ($this->show_volume_weight_ems() > 50000 ? $this->volume_weight_ems * 1.06 : $this->volume_weight_ems * 1.1);
        return $this->volume_shipping_weight_ems;
    }

    function show_discount_num() {
        return $this->discount_num;
    }

    function show_deduct_shippingfee(){
        return $this->deduct_shippingfee;
    }

    function show_discount_amount(){
        return $this->discount_amount;
    }
    function show_origin_amount(){
        return $this->origin_amount;
    }

    /**
     * 得到包裹重量
     * @param $is_calc_volume 是否计算体积
     * @return $box_weight 包裹重量
     */
    function show_shipping_package_box_weight($is_calc_volume = 0) {
        $box_weight = 0;
        if($is_calc_volume) {
            $box_weight = max($this->volume_weight, $this->weight);
            if($box_weight >= 50000) {
                $box_weight = $box_weight * 0.06;
            } else {
                $box_weight = $box_weight * 0.1;
            }
        } else {
            if($this->volume_weight >= $this->weight * MODULE_SHIPPING_WEIGHT_ARGUMENT_ONE) {
                if($this->weight >= 20000) {
                    $box_weight = $this->weight * MODULE_SHIPPING_WEIGHT_ARGUMENT_TWO;
                } else {
                    $box_weight = $this->weight * MODULE_SHIPPING_WEIGHT_ARGUMENT_THREE;
                }
            } else {
                if($this->weight >= 50000) {
                    $box_weight = $this->weight * MODULE_SHIPPING_WEIGHT_ARGUMENT_FOUR;
                } else {
                    $box_weight = $this->weight * MODULE_SHIPPING_WEIGHT_ARGUMENT_FIVE;
                }
            }
        }
        return round($box_weight, 2);
    }
    
    /**
     * 得到虚拟海外仓包裹重量
     */
    function show_shipping_package_box_weight_virtual($cal_type = 10) {
        $box_weight = 0;
        
        switch ($cal_type){
            case 10:
                $box_weight = $this->weight;
                break;
            case 20:
                $box_weight = $this->volume_weight;
                break;
            case 30:
                $box_weight = max($this->volume_weight, $this->weight);
                break;
        }
        
        $box_weight = $box_weight * 0.1;
        return round($box_weight, 2);
    }

    /**
     * Method to generate a cart ID
     *
     * @param length of ID to generate
     * @return string cart ID
     */
    function generate_cart_id($length = 5) {
        return zen_create_random_value($length, 'digits');
    }
    /**
     * Method to calculate the content type of a cart
     *
     * @param boolean whether to test for Gift Vouchers only
     * @return string
     */
    function get_content_type($gv_only = 'false') {
        global $db;

        $this->content_type = false;
        $gift_voucher = 0;

        if ( $this->count_contents() > 0 ) {
            $products = $this->customers_basket();

            while (!$products->EOF) {
                $products_id = $products->fields['products_id'];
                $qty = $products->fields['customers_basket_quantity'];

                $free_ship_check = $db->Execute("select products_virtual, products_model, products_price, product_is_always_free_shipping
        								   from " . TABLE_PRODUCTS . "
        								  where products_id = '" . zen_get_prid($products_id) . "'");
                $virtual_check = false;
                if (ereg('^GIFT', addslashes($free_ship_check->fields['products_model']))) {
                    $gift_voucher += ($free_ship_check->fields['products_price'] + $this->attributes_price($products_id)) * $qty;
                }

                $products_attribute = $this->customers_basket_attribute($products_id);

                if (($products_attribute->RecordCount() > 0) and $free_ship_check->fields['product_is_always_free_shipping'] != 2) {
                    while (!$products_attribute->EOF) {
                        $value = $products_attribute->fields['products_options_value_id'];

                        $virtual_check_query = "select count(*) as total
                                      from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                     where pa.products_id = '" . (int)$products_id . "'
                                       and pa.options_values_id = '" . (int)$value . "'
                                       and pa.products_attributes_id = pad.products_attributes_id";

                        $virtual_check = $db->Execute($virtual_check_query);

                        if ($virtual_check->fields['total'] > 0) {
                            switch ($this->content_type) {
                                case 'physical':
                                    $this->content_type = 'mixed';
                                    if ($gv_only == 'true') {
                                        return $gift_voucher;
                                    } else {
                                        return $this->content_type;
                                    }
                                    break;
                                default:
                                    $this->content_type = 'virtual';
                                    break;
                            }
                        } else {
                            switch ($this->content_type) {
                                case 'virtual':
                                    if ($free_ship_check->fields['products_virtual'] == '1') {
                                        $this->content_type = 'virtual';
                                    } else {
                                        $this->content_type = 'mixed';
                                        if ($gv_only == 'true') {
                                            return $gift_voucher;
                                        } else {
                                            return $this->content_type;
                                        }
                                    }
                                    break;
                                case 'physical':
                                    if ($free_ship_check->fields['products_virtual'] == '1') {
                                        $this->content_type = 'mixed';
                                        if ($gv_only == 'true') {
                                            return $gift_voucher;
                                        } else {
                                            return $this->content_type;
                                        }
                                    } else {
                                        $this->content_type = 'physical';
                                    }
                                    break;
                                default:
                                    if ($free_ship_check->fields['products_virtual'] == '1') {
                                        $this->content_type = 'virtual';
                                    } else {
                                        $this->content_type = 'physical';
                                    }
                            }
                        }
                    }
                } else {
                    switch ($this->content_type) {
                        case 'virtual':
                            if ($free_ship_check->fields['products_virtual'] == '1') {
                                $this->content_type = 'virtual';
                            } else {
                                $this->content_type = 'mixed';
                                if ($gv_only == 'true') {
                                    return $gift_voucher;
                                } else {
                                    return $this->content_type;
                                }
                            }
                            break;
                        case 'physical':
                            if ($free_ship_check->fields['products_virtual'] == '1') {
                                $this->content_type = 'mixed';
                                if ($gv_only == 'true') {
                                    return $gift_voucher;
                                } else {
                                    return $this->content_type;
                                }
                            } else {
                                $this->content_type = 'physical';
                            }
                            break;
                        default:
                            if ($free_ship_check->fields['products_virtual'] == '1') {
                                $this->content_type = 'virtual';
                            } else {
                                $this->content_type = 'physical';
                            }
                    }
                }
                $products->MoveNext();
            }
        } else {
            $this->content_type = 'physical';
        }

        if ($gv_only == 'true') {
            return $gift_voucher;
        } else {
            return $this->content_type;
        }
    }
    /**
     * Method to unserialize a cart object
     *
     * @deprecated
     * @private
     */
    function unserialize($broken) {
        for(reset($broken);$kv=each($broken);) {
            $key=$kv['key'];
            if (gettype($this->$key)!="user function")
                $this->$key=$kv['value'];
        }
    }
    /**
     * Method to calculate item quantity, bounded the mixed/min units settings
     *
     * @param boolean product id of item to check
     * @return deciaml
     */
    function in_cart_mixed($products_id) {
        global $db;

        $product = $db->Execute("select products_id, products_quantity_mixed from " . TABLE_PRODUCTS . " where products_id='" . zen_get_prid($products_id) . "' limit 1");

        // if mixed attributes is off return qty for current attribute selection
        if ($product->fields['products_quantity_mixed'] == '0') {
            return $this->get_quantity($products_id);
        }

        // compute total quantity regardless of attributes
        $in_cart_mixed_qty = 0;
        $chk_products_id= zen_get_prid($products_id);

        $products = $this->customers_basket();

        while (!$products->EOF) {
            //$products_id = $products->fields['products_id'];
            //$test_id = zen_get_prid($products_id);
            //if ($test_id == $chk_products_id) {
            $in_cart_mixed_qty += $products->fields['customers_basket_quantity'];
            //}
            $products->MoveNext();
        }
        return $in_cart_mixed_qty;
    }
    /**
     * Method to calculate item quantity, bounded the mixed/min units settings
     *
     * @param boolean product id of item to check
     * @return deciaml
     */
    function in_cart_mixed_discount_quantity($products_id) {
        global $db;

        $product = $db->Execute("select products_id, products_mixed_discount_quantity from " . TABLE_PRODUCTS . " where products_id='" . zen_get_prid($products_id) . "' limit 1");

        // if mixed attributes is off return qty for current attribute selection
        if ($product->fields['products_mixed_discount_quantity'] == '0') {
            return $this->get_quantity($products_id);
        }

        // compute total quantity regardless of attributes
        $in_cart_mixed_qty_discount_quantity = 0;
        $chk_products_id= zen_get_prid($products_id);

        $products = $this->customers_basket($products_id);

        while (!$products->EOF) {
            // $products_id = $products->fields['products_id'];
            //$test_id = zen_get_prid($products_id);
            //if ($test_id == $chk_products_id) {
            $in_cart_mixed_qty_discount_quantity += $products->fields['customers_basket_quantity'];
            //}
            $products->MoveNext();
        }
        return $in_cart_mixed_qty_discount_quantity;
    }
    /**
     * Method to calculate the number of items in a cart based on an abitrary property
     *
     * $check_what is the fieldname example: 'products_is_free'
     * $check_value is the value being tested for - default is 1
     * Syntax: $_SESSION['cart']->in_cart_check('product_is_free','1');
     *
     * @param string product field to check
     * @param mixed value to check for
     * @return integer number of items matching restraint
     */
    function in_cart_check($check_what, $check_value='1') {
        global $db;

        $in_cart_check_qty = 0;

        $products = $this->customers_basket();

        //robbie
        if (isset($_SESSION['customer_id'])){
            $products = $db->Execute("Select Sum(Case When " . $check_what . " Then 1 Else 0 End) as check_result
      							  From " . TABLE_PRODUCTS . " as p, " . TABLE_CUSTOMERS_BASKET . " as cb
      						     Where p.products_id = cb.products_id
      						       and customers_id = " . (int)$_SESSION['customer_id']);
        } else {
            $products = $db->Execute("Select Sum(Case When " . $check_what . " Then 1 Else 0 End) as check_result
      							  From " . TABLE_PRODUCTS . " as p, " . TABLE_CUSTOMERS_BASKET . " as cb
      						     Where p.products_id = cb.products_id
      						       and cookie_id = '" . $_SESSION['cookie_cart_id'] . "'");
        }
        $in_cart_check_qty = $products->fields['check_result'];
//    while (!$products->EOF) {
//      $products_id = $products->fields['products_id'];
//      $testing_id = zen_get_prid($products_id);
//
//      $product_check = $db->Execute("select " . $check_what . " as check_it from " . TABLE_PRODUCTS . " where products_id='" . $testing_id . "' limit 1");
//      if ($product_check->fields['check_it'] == $check_value) {
//        $in_cart_check_qty += $products->fields['customers_basket_quantity'];
//      }
//      $products->MoveNext();
//    }
        return $in_cart_check_qty;
    }
    /**
     * Method to check whether cart contains only Gift Vouchers
     *
     * @return mixed value of Gift Vouchers in cart
     */
    function gv_only() {
        $gift_voucher = $this->get_content_type(true);
        return $gift_voucher;
    }

    /**
     * Method to handle cart Action - update product
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionUpdateProduct($goto, $parameters) {
        global $messageStack;

        $products_id_array = $_POST['products_id'];
        $update_products_array = array();
        for ($i = 0; $i < sizeof($products_id_array); $i++){
            if ($_POST['old_num'][$i] != $_POST['cart_quantity'][$i]){
                $update_products_array[] = array('id' => $products_id_array[$i],
                    'old_num' => $_POST['old_num'][$i],
                    'new_num' => $_POST['cart_quantity'][$i]);
            }
        }

        for ($i = 0, $n = sizeof($update_products_array); $i < $n; $i++){
            if ($update_products_array[$i]['new_num'] == 0){
                $this->remove($update_products_array[$i]['id']);
            } else {
                $adjust_max = 'false';
                $add_max = zen_get_products_quantity_order_max($update_products_array[$i]['id']);
                $cart_qty = $this->in_cart_mixed($update_products_array[$i]['id']);
                $new_qty = $update_products_array[$i]['new_num'];

                $new_qty = $this->adjust_quantity($new_qty, $update_products_array[$i]['id'], 'shopping_cart');

                if ($add_max == 1 && $cart_qty == 1){
                    $adjust_max = 'true';
                } else {
                    if ($new_qty > $add_max && $add_max != 0){
                        $adjust_max = 'true';
                        $new_qty = $add_max;
                    }
                    $attributes = ($_POST['id'][$update_products_array[$i]['id']]) ? $_POST['id'][$update_products_array[$i]['id']] : '';

                    $this->add_cart($update_products_array[$i]['id'], $new_qty, $attributes, false);
                    //Tianwen.Wan20160624购物车优化->加判断循环调用此方法时不调用
                    //$this->calculate();
                }
                if ($adjust_max == 'true') {
                    $messageStack->add_session('shopping_cart', ERROR_MAXIMUM_QTY . ' A: - ' . zen_get_products_name($update_products_array[$i]['id']), 'caution');
                } else {
                    if (DISPLAY_CART == 'false' && $_GET['main_page'] != FILENAME_SHOPPING_CART) {
                        $messageStack->add_session('header', SUCCESS_ADDED_TO_CART_PRODUCT, 'success');
                    }
                }
            }
        }

        $this->get_isvalid_checkout_products_optimize();
        zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
    }
    /**
     * Method to handle cart Action - add product
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionAddProduct($goto, $parameters) {
        global $messageStack, $db;
        if (isset($_POST['products_id']) && is_numeric($_POST['products_id'])) {
            // verify attributes and quantity first
            $the_list = '';
            $adjust_max= 'false';
            if (isset($_POST['id'])) {
                foreach ($_POST['id'] as $key => $value) {
                    $check = zen_get_attributes_valid($_POST['products_id'], $key, $value);
                    if ($check == false) {
                        $the_list .= TEXT_ERROR_OPTION_FOR . '<span class="alertBlack">' . zen_options_name($key) . '</span>' . TEXT_INVALID_SELECTION . '<span class="alertBlack">' . (zen_values_name($value) == 'TEXT' ? TEXT_INVALID_USER_INPUT : zen_values_name($value)) . '</span>' . '<br />';
                    }
                }
            }

//die('I see Add to Cart: ' . $_POST['products_id'] . 'real id ' . zen_get_uprid($_POST['products_id'], $real_ids) . ' add qty: ' . $add_max . ' - cart qty: ' . $cart_qty . ' - newqty: ' . $new_qty);
            $add_max = zen_get_products_quantity_order_max($_POST['products_id']);
            $cart_qty = $this->in_cart_mixed($_POST['products_id']);
            $new_qty = $_POST['cart_quantity'];

//echo 'I SEE actionAddProduct: ' . $_POST['products_id'] . '<br>';
            $new_qty = $this->adjust_quantity($new_qty, $_POST['products_id'], 'shopping_cart');

            if (($add_max == 1 and $cart_qty == 1)) {
                // do not add
                $new_qty = 0;
                $adjust_max= 'true';
            } else {
                // adjust quantity if needed
                if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
                    $adjust_max= 'true';
                    $new_qty = $add_max - $cart_qty;
                }
            }
            if ((zen_get_products_quantity_order_max($_POST['products_id']) == 1 and $this->in_cart_mixed($_POST['products_id']) == 1)) {
                // do not add
            } else {
                // process normally
                // bof: set error message
                if ($the_list != '') {
                    $messageStack->add('product_info', ERROR_CORRECTIONS_HEADING . $the_list, 'caution');
//          $messageStack->add('header', 'REMOVE ME IN SHOPPING CART CLASS BEFORE RELEASE<br/><BR />' . ERROR_CORRECTIONS_HEADING . $the_list, 'error');
                } else {
                    // process normally
                    // iii 030813 added: File uploading: save uploaded files with unique file names
                    $real_ids = isset($_POST['id']) ? $_POST['id'] : "";
                    if (isset($_GET['number_of_uploads']) && $_GET['number_of_uploads'] > 0) {
                        /**
                         * Need the upload class for attribute type that allows user uploads.
                         *
                         */
                        include(DIR_WS_CLASSES . 'upload.php');
                        for ($i = 1, $n = $_GET['number_of_uploads']; $i <= $n; $i++) {
                            if (zen_not_null($_FILES['id']['tmp_name'][TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]]) and ($_FILES['id']['tmp_name'][TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] != 'none')) {
                                $products_options_file = new upload('id');
                                $products_options_file->set_destination(DIR_FS_UPLOADS);
                                $products_options_file->set_output_messages('session');
                                if ($products_options_file->parse(TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i])) {
                                    $products_image_extension = substr($products_options_file->filename, strrpos($products_options_file->filename, '.'));
                                    if ($_SESSION['customer_id']) {
                                        $db->Execute("insert into " . TABLE_FILES_UPLOADED . " (sesskey, customers_id, files_uploaded_name) values('" . $_SESSION['cookie_cart_id'] . "', '" . $_SESSION['customer_id'] . "', '" . zen_db_input($products_options_file->filename) . "')");
                                    } else {
                                        $db->Execute("insert into " . TABLE_FILES_UPLOADED . " (sesskey, files_uploaded_name) values('" . $_SESSION['cookie_cart_id'] . "', '" . zen_db_input($products_options_file->filename) . "')");
                                    }
                                    $insert_id = $db->Insert_ID();
                                    $real_ids[TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] = $insert_id . ". " . $products_options_file->filename;
                                    $products_options_file->set_filename("$insert_id" . $products_image_extension);
                                    if (!($products_options_file->save())) {
                                        break;
                                    }
                                } else {
                                    break;
                                }
                            } else { // No file uploaded -- use previous value
                                $real_ids[TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] = $_POST[TEXT_PREFIX . UPLOAD_PREFIX . $i];
                            }
                        }
                    }

                    //����Ƿ������Ʒ
                    //robbie $have_gift
                    $prodId = $_POST['products_id'];
                    if ($this->is_gift($prodId)){
                        if($this->have_gift){
                            $messageStack->add_session('shopping_cart', ERROR_ADD_GIFT_ALREADY_ONE, 'caution');
                        }
                        else {
                            if ($_SESSION['cart']->total < 100) {
                                $_SESSION['failed_gift'] = $prodId;
                                $messageStack->add_session('shopping_cart', ERROR_ADD_GIFT, 'caution');
                            }
                            else {
                                $this->have_gift = true;
                                $this->gift_id = $prodId;
                                $this->add_cart($prodId, 1);
                                $adjust_max = false;
                            }
                        }
                    }
                    else {
                        $this->add_cart($_POST['products_id'], $this->get_quantity(zen_get_uprid($_POST['products_id'], $real_ids))+($new_qty), $real_ids);
                    }

//          $this->add_cart($_POST['products_id'], $this->get_quantity(zen_get_uprid($_POST['products_id'], $real_ids))+($new_qty), $real_ids);
                    // iii 030813 end of changes.
                } // eof: set error message
            } // eof: quantity maximum = 1

            if ($adjust_max == 'true') {
                $messageStack->add_session('shopping_cart', ERROR_MAXIMUM_QTY . ' B: - ' . zen_get_products_name($_POST['products_id']), 'caution');
            }
        }
        if ($the_list == '') {


            ////jessa 2010-05-05 ���˴ι����¼����Ӧ�����ģʽ��,ÿ������Ӧ��ģʽ�¼�1
            $today_date = date('Ymd');
            $find_recordset = $db->Execute("Select bam_date, bam_quick_mode, bam_normal_mode
	    								  From " . TABLE_BASKET_ADD_MODE . "
	    								 Where bam_date = '" . $today_date . "'");
            $find_recordset_num = $find_recordset->RecordCount();
            if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
                if ($find_recordset_num > 0){
                    $quick_mode_num = (int)$find_recordset->fields['bam_quick_mode'];
                    $new_num = $quick_mode_num + 1;
                    $db->Execute("Update " . TABLE_BASKET_ADD_MODE . "
	    						 Set bam_quick_mode = " . $new_num . "
	    					   Where bam_date = '" . $today_date . "'");
                } else {
                    $db->Execute("Insert Into " . TABLE_BASKET_ADD_MODE . "
	    					  Values('" . $today_date . "', 1, 0)");
                }
            } else {
                if ($find_recordset_num > 0){
                    $normal_mode_num = (int)$find_recordset->fields['bam_normal_mode'];
                    $new_num = $normal_mode_num + 1;
                    $db->Execute("Update " . TABLE_BASKET_ADD_MODE . "
	    						 Set bam_normal_mode = " . $new_num . "
	    					   Where bam_date = '" . $today_date . "'");
                } else {
                    $db->Execute("Insert Into " . TABLE_BASKET_ADD_MODE . "
	    					  Values('" . $today_date . "', 0, 1)");
                }
            }
            ////eof jessa 2010-05-05

            if (DISPLAY_CART == 'false' && $_GET['main_page'] != FILENAME_SHOPPING_CART) {
                $messageStack->add_session('header', SUCCESS_ADDED_TO_CART_PRODUCT, 'success');
            }
            zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
        } else {
            // errors - display popup message
        }
    }
    /**
     * Method to handle cart Action - buy now
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionBuyNow($goto, $parameters) {
        global $messageStack;
        if (isset($_GET['products_id'])) {
            if (zen_has_product_attributes($_GET['products_id'])) {
                zen_redirect(zen_href_link('product_info', 'products_id=' . $_GET['products_id']));
            } else {
                $add_max = zen_get_products_quantity_order_max($_GET['products_id']);
                $cart_qty = $this->in_cart_mixed($_GET['products_id']);
                $new_qty = zen_get_buy_now_qty($_GET['products_id']);
//die('I see Buy Now Cart: ' . $add_max . ' - cart qty: ' . $cart_qty . ' - newqty: ' . $new_qty);
                if (($add_max == 1 and $cart_qty == 1)) {
                    // do not add
                    $new_qty = 0;
                } else {
                    // adjust quantity if needed
                    if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
                        $new_qty = $add_max - $cart_qty;
                    }
                }
                if ((zen_get_products_quantity_order_max($_GET['products_id']) == 1 and $this->in_cart_mixed($_GET['products_id']) == 1)) {
                    // do not add
                } else {
                    // check for min/max and add that value or 1
                    // $add_qty = zen_get_buy_now_qty($_GET['products_id']);
                    $this->add_cart($_GET['products_id'], $this->get_quantity($_GET['products_id'])+$new_qty);
                }
            }
        }
// display message if all is good and not on shopping_cart page
        if (DISPLAY_CART == 'false' && $_GET['main_page'] != FILENAME_SHOPPING_CART) {
            $messageStack->add_session('header', SUCCESS_ADDED_TO_CART_PRODUCT, 'success');
        }
        zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
    }
    /**
     * Method to handle cart Action - multiple add products
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionMultipleAddProduct($goto, $parameters) {
        global $messageStack, $db;
        ////jessa 2010-05-03 �����ڹ˿͹����Ʒʱ��¼�˿͹����Ʒ�ĸ�������
        $products_id_array = array();
        ////eof jessa 2010-05-03
        while ( list( $key, $val ) = each($_POST['products_id']) ) {
            if ($val > 0) {
                $adjust_max = false;
                $prodId = $key;
                ////jessa 2010-05-03 ����Ʒ��ID��¼��������
                $products_id_array[] = $prodId;
                ////eof jessa 2010-05-03
                $qty = $val;
                $add_max = zen_get_products_quantity_order_max($prodId);
                $cart_qty = $this->in_cart_mixed($prodId);
                //        $new_qty = $qty;
                //echo 'I SEE actionMultipleAddProduct: ' . $prodId . '<br>';
                $new_qty = $this->adjust_quantity($qty, $prodId, 'shopping_cart');

                if (($add_max == 1 and $cart_qty == 1)) {
                    // do not add
                    $adjust_max= 'true';
                } else {
                    // adjust quantity if needed
                    if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
                        $adjust_max= 'true';
                        $new_qty = $add_max - $cart_qty;
                    }
//          $this->add_cart($prodId, $this->get_quantity($prodId)+($new_qty));
                    //����Ƿ������Ʒ
                    //robbie $have_gift
                    if ($this->is_gift($prodId)){
                        if($this->have_gift){
                            $messageStack->add_session('shopping_cart', ERROR_ADD_GIFT_ALREADY_ONE, 'caution');
                        }
                        else {
                            if ($_SESSION['cart']->total < 100) {
                                $_SESSION['failed_gift'] = $prodId;
                                $messageStack->add_session('shopping_cart', ERROR_ADD_GIFT, 'caution');
                            }
                            else {
                                $this->have_gift = true;
                                $this->gift_id = $prodId;
                                $this->add_cart($prodId, 1);
                            }
                        }
                    }
                    else {
                        $this->add_cart($prodId, $this->get_quantity($prodId)+($new_qty));
                    }
                    //eof robbie
                }
                if ($adjust_max == 'true') {
                    $messageStack->add_session('shopping_cart', ERROR_MAXIMUM_QTY . ' C: - ' . zen_get_products_name($prodId), 'caution');
                }
            }
        }

        ////jessa 2010-05-03 �жϹ˿�Ŀǰ������ģʽ,�����ڸ�ģʽ�¹���Ĳ�Ʒ������¼����Ӧ��ģʽ��
        $add_products_num = sizeof($products_id_array);
        $today_date = date('Ymd');
        $find_recordset = $db->Execute("Select bam_date, bam_quick_mode, bam_normal_mode
    								  From " . TABLE_BASKET_ADD_MODE . "
    							     Where bam_date = '" . $today_date . "'");
        $find_recordset_num = $find_recordset->RecordCount();

        if (isset($_SESSION['display_mode']) && $_SESSION['display_mode'] == 'quick'){
            if ($find_recordset_num > 0){
                $quick_mode_num = (int)$find_recordset->fields['bam_quick_mode'];
                $new_num = $quick_mode_num + $add_products_num;
                $db->Execute("Update " . TABLE_BASKET_ADD_MODE . "
    						 Set bam_quick_mode = " . $new_num . "
    					   Where bam_date = '" . $today_date . "'");
            } else {
                $db->Execute("Insert into " . TABLE_BASKET_ADD_MODE . "
    					  Values ('" . $today_date . "', " . $add_products_num . ", 0)");
            }
        } else {
            if ($find_recordset_num > 0){
                $normal_mode_num = (int)$find_recordset->fields['bam_normal_mode'];
                $new_num = $normal_mode_num + $add_products_num;
                $db->Execute("Update " . TABLE_BASKET_ADD_MODE . "
    						 Set bam_normal_mode = " . $new_num . "
    					   Where bam_date = '" . $today_date . "'");
            } else {
                $db->Execute("Insert into " . TABLE_BASKET_ADD_MODE . "
    					  Values ('" . $today_date . "', 0, " . $add_products_num . ")");
            }
        }
        ////eof jessa 2010-05-03


// display message if all is good and not on shopping_cart page
        if (DISPLAY_CART == 'false' && $_GET['main_page'] != FILENAME_SHOPPING_CART) {
            $messageStack->add_session('header', SUCCESS_ADDED_TO_CART_PRODUCTS, 'success');
        }
        zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
    }
    /**
     * Method to handle cart Action - notify
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionNotify($goto, $parameters) {
        global $db;
        if ($_SESSION['customer_id']) {
            if (isset($_GET['products_id'])) {
                $notify = $_GET['products_id'];
            } elseif (isset($_GET['notify'])) {
                $notify = $_GET['notify'];
            } elseif (isset($_POST['notify'])) {
                $notify = $_POST['notify'];
            } else {
                zen_redirect(zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action', 'notify', 'main_page'))));
            }
            if (!is_array($notify)) $notify = array($notify);
            for ($i=0, $n=sizeof($notify); $i<$n; $i++) {
                $check_query = "select count(*) as count
                          from " . TABLE_PRODUCTS_NOTIFICATIONS . "
                          where products_id = '" . $notify[$i] . "'
                          and customers_id = '" . $_SESSION['customer_id'] . "'";
                $check = $db->Execute($check_query);
                if ($check->fields['count'] < 1) {
                    $sql = "insert into " . TABLE_PRODUCTS_NOTIFICATIONS . "
                    (products_id, customers_id, date_added)
                     values ('" . $notify[$i] . "', '" . $_SESSION['customer_id'] . "', now())";
                    $db->Execute($sql);
                }
            }
//      zen_redirect(zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action', 'notify', 'main_page'))));
            zen_redirect(zen_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, zen_get_all_get_params(array('action', 'notify', 'main_page'))));
        } else {
            $_SESSION['navigation']->set_snapshot();
            zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
        }
    }
    /**
     * Method to handle cart Action - notify remove
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionNotifyRemove($goto, $parameters) {
        global $db, $messageStack;

        if ($_SESSION['customer_id'] && isset($_GET['products_id'])) {
            $check_query = "select count(*) as count
                        from " . TABLE_PRODUCTS_NOTIFICATIONS . "
                        where products_id = '" . $_GET['products_id'] . "'
                        and customers_id = '" . $_SESSION['customer_id'] . "'";

            $check = $db->Execute($check_query);
            if ($check->fields['count'] > 0) {
//    	$messageStack->add_session('header', 'Delete the product at actionNotifyRemove in sp', 'caution');
                $sql = "delete from " . TABLE_PRODUCTS_NOTIFICATIONS . "
                  where products_id = '" . $_GET['products_id'] . "'
                  and customers_id = '" . $_SESSION['customer_id'] . "'";
                $db->Execute($sql);
            }
            zen_redirect(zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action', 'main_page'))));
        } else {
            $_SESSION['navigation']->set_snapshot();
            zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
        }
    }
    /**
     * Method to handle cart Action - Customer Order
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionCustomerOrder($goto, $parameters) {
        global $zco_page;
        global $messageStack;
        if ($_SESSION['customer_id'] && isset($_GET['pid'])) {
            if (zen_has_product_attributes($_GET['pid'])) {
                zen_redirect(zen_href_link('product_info', 'products_id=' . $_GET['pid']));
            } else {
                $this->add_cart($_GET['pid'], $this->get_quantity($_GET['pid'])+1);
            }
        }
// display message if all is good and not on shopping_cart page
        if (DISPLAY_CART == 'false' && $_GET['main_page'] != FILENAME_SHOPPING_CART) {
            $messageStack->add_session('header', SUCCESS_ADDED_TO_CART_PRODUCT, 'success');
        }
        zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
    }
    /**
     * Method to handle cart Action - remove product
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionRemoveProduct($goto, $parameters) {
        if (isset($_GET['product_id']) && zen_not_null($_GET['product_id'])) $this->remove($_GET['product_id']);
        zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
    }
    /**
     * Method to handle cart Action - user action
     *
     * @param string forward destination
     * @param url parameters
     */
    function actionCartUserAction($goto, $parameters) {
        $this->notify('NOTIFY_CART_USER_ACTION');
    }

//     $qty = $this->adjust_quantity($qty, (int)$products_id, 'shopping_cart');

// temporary fixed on messagestack used for check and message needs better separation
    function adjust_quantity($check_qty, $products, $message=false) {
        global $messageStack;
        $old_quantity = $check_qty;
        if (QUANTITY_DECIMALS != 0) {
            //          $new_qty = round($new_qty, QUANTITY_DECIMALS);
            $fix_qty = $check_qty;
            switch (true) {
                case (!strstr($fix_qty, '.')):
                    $new_qty = $fix_qty;
//            $messageStack->add_session('shopping_cart', ERROR_QUANTITY_ADJUSTED . ' - ' . zen_get_products_name($products) . ' - ' . $old_quantity . ' => ' . $new_qty, 'caution');
                    break;
                default:
                    $new_qty = preg_replace('/[0]+$/','', $check_qty);
//            $messageStack->add_session('shopping_cart', 'A: ' . ERROR_QUANTITY_ADJUSTED . ' - ' . zen_get_products_name($products) . ' - ' . $old_quantity . ' => ' . $new_qty, 'caution');
                    break;
            }
        } else {
            if ($check_qty != round($check_qty, QUANTITY_DECIMALS)) {
                $new_qty = round($check_qty, QUANTITY_DECIMALS);
                $messageStack->add_session('shopping_cart', ERROR_QUANTITY_ADJUSTED . ' - ' . zen_get_products_name($products) . ' - ' . $old_quantity . ' => ' . $new_qty, 'caution');
            } else {
                $new_qty = $check_qty;
            }
        }
        return $new_qty;
    }
    /**
     * �ж�һ����Ʒ�Ƿ�ΪGift ��Ҫ�޸�Path����
     * ���� robbie wei 2010-10-18  ����������ˣ�������False
     * @param mixed product ID of item to remove
     * @return void
     * @global object access to the db object
     */
    function is_gift($gift_id){
//  	global $db;
//
//  	if (!(zen_not_null($gift_id) && $gift_id <> '' )) return true;
//
//  	$gift_cat = $db->Execute('Select products_id from ' . TABLE_PRODUCTS_TO_CATEGORIES . ' Where products_id = '
//  					. $gift_id . ' And categories_id = 198');
//
//  	if ($gift_cat->RecordCount() < 1) return false;

        return false;
    }
    /**
     * �õ�shopping cart cookieID
     * ���� robbie wei 2010-10-21
     * @param
     * @return void
     */
    function set_cookie_id(){
        if ($_SESSION['customer_id']) return;
        if (isset($_COOKIE['cookie_cart_id'])) return;

        $ls_cookie_id = date('Ymd-His') . '-' . Rand(1, 10000);
        setcookie("cookie_cart_id", $ls_cookie_id, time() + 63113850, '/', '.' . BASE_SITE);
        $_SESSION['cookie_cart_id'] = $ls_cookie_id;

        return;
    }

    //jessa 2010-10-12 ������������
    function customers_basket($products_id = ''){
        global $db;

        if (isset($_SESSION['customer_id'])){
            if (zen_not_null($products_id)){
                $products_query = "select *
  								 from " . TABLE_CUSTOMERS_BASKET . "
  								where customers_id = " . (int)$_SESSION['customer_id'] . "
  								  and products_id = '" . zen_db_input($products_id) . "'";
            } else {
                $products_query = "select *
  								 from " . TABLE_CUSTOMERS_BASKET . "
  								where customers_id = " . (int)$_SESSION['customer_id'];
            }
        } else {
            if (zen_not_null($products_id)){
                $products_query = "select *
  								 from " . TABLE_CUSTOMERS_BASKET . "
  								where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
  								  and products_id = '" . zen_db_input($products_id) . "'";
            } else {
                $products_query = "select *
  								 from " . TABLE_CUSTOMERS_BASKET . "
  								where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'";
            }
        }

        $products = $db->Execute($products_query);
        return $products;
    }

    function customers_basket_attribute($products_id = ''){
        global $db;

        if (isset($_SESSION['customer_id'])){
            if (zen_not_null($products_id)){
                $products_query = "select *
	  	  					   from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
	  	  					  where customers_id = " . (int)$_SESSION['customer_id'] . "
	  	  					    and products_id = '" . zen_db_input($products_id) . "'";
            } else {
                $products_query = "select *
  	  						 from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
  	  						where customers_id = " . (int)$_SESSION['customer_id'];
            }
        } else {
            if (zen_not_null($products_id)){
                $products_query = "select *
  	  						 from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
  	  						where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'
  	  						  and products_id = '" . zen_db_input($products_id) . "'";
            } else {
                $products_query = "select *
  	  						 from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . "
  	  						where cookie_id = '" . $_SESSION['cookie_cart_id'] . "'";
            }
        }
        $products = $db->Execute($products_query);
        return $products;
    }

    /**
     * author Tianwen.Wan20160722
     * 获取用户购物车数据(function get_isvalid_checkout、function get_products、function calculate三个方法合并)
     * @param $page_size int 获取数据大小
     * @param $page int 获取第几页数据
     * @param $is_include_invalid_product boolean 是否包含失效产品
     * @param $is_mobilesite booelan 是否是手机网站
     * @param $is_include_not_checked booelan 是否包含未选中的商品
     */
    function get_isvalid_checkout_products_optimize($page_size = 0, $page = 0, $is_include_invalid_product = false, $is_mobilesite = false, $is_include_not_checked = false) {
        global $db, $currencies;

        $this->discount_num = 0;
        $this->deduct_shippingfee = 0;
        $this->total = 0;
        $this->total_new = 0;
        $this->total_original = 0;
        $this->weight = 0;
        $this->volume_weight = 0;
        $this->volume_weight_ems = 0;
        $this->volume_shipping_weight = 0;
        $this->discount_amount = 0;
        $this->origin_amount = 0;
        $this->products_volume_weight_orgin = 0;

        // shipping adjustment
        $this->promotion_total = 0;
        $this->promotion_total_usd = 0;
        $this->daily_deal_total = 0;
        $this->promotion_weight = 0;
        $this->products_products_checked = array();

        $session_customer_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;
        $session_cookie_cart_id = isset($_SESSION['cookie_cart_id']) ? $_SESSION['cookie_cart_id'] : '';
        $shopping_cart_sql = "call get_isvalid_checkout_products_optimize(" . $session_customer_id . ", '" . $session_cookie_cart_id . "', " . $_SESSION['languages_id'] . ")";
        $shopping_cart_datas = $db->multi_query($shopping_cart_sql);
        $shopping_cart_products = $shopping_cart_datas[0];
        if($_SESSION['cart_sort_by'] != "customers_basket_id" || $_SESSION['cart_sort_type'] != "desc") {
            $shopping_cart_products = array_sort($shopping_cart_products, $_SESSION['cart_sort_by'], $_SESSION['cart_sort_type']);
        }

        $fix_once = 0;

        $_SESSION['cart_errors'] = $_SESSION['cart_products_errors'] = $_SESSION['cart_products_down_errors'] = $_SESSION['cart_products_out_stoct_errors'] = '';

        /*
        if (MIN_ORDER_AMOUNT > 0) {
            if ($_SESSION['cart']->total < MIN_ORDER_AMOUNT) {
                $_SESSION['valid_to_checkout'] = false;
                $_SESSION['cart_errors'] .= 'Minimum amount for wholesale order is ' . MIN_ORDER_AMOUNT . ' US$. Your current total is ' . $_SESSION['cart']->total . ' US$.<br/>';
            }
        }
        */

        $products_down_s = '<table cellpadding="0" cellspacing="0" class="pro_removed" style="display:none;">
				      <tr>
				        <td colspan="3" style="border-top:0px;"></td>
				        <td style="text-align:center; border-top:0px;"><a href="javascript:void(0);" class="jq_products_invalid_all">' . TEXT_SHOPING_CART_EMPTY_INVALID_ITEMS . '</a></td>
				      </tr>
				      <tr>
				        <th>' . TEXT_CART_P_IMG . '</th>
				        <th>' . TEXT_MODEL . '</th>
				        <th class="name">' . TEXT_CART_P_NAME . ' </th>
				        <th>' . TEXT_ACTION . '</th>
				      </tr>';
        $products_array = $products_array_all = $products_notify_array = $products_id_remove_array = array ();
        $is_checked_count = 0;

        foreach($shopping_cart_products as $shopping_cart_products_value) {
            $products_qty_update_auto_note = "";
            $qty = $shopping_cart_products_value['customers_basket_quantity'];
            $prid = $shopping_cart_products_value['id'] = $shopping_cart_products_value['products_id'];
            $shopping_cart_products_value['quantity'] = $shopping_cart_products_value['products_quantity'];
            $products_tax = zen_get_tax_rate($product->fields['products_tax_class_id']);

            //show promotion max num per order
            $promotion_info = get_product_promotion_info($prid);
            if (isset($promotion_info['pp_max_num_per_order']) && $promotion_info['pp_max_num_per_order'] > 0) {
                $pp_max_num_per_order = $promotion_info['pp_max_num_per_order'];
                if ($qty > $pp_max_num_per_order) {
                    $shopping_cart_products_value['final_price'] = $shopping_cart_products_value['original_price'];
                }
            }

            $products_price = zen_add_tax($shopping_cart_products_value['final_price']);
            $original_price = zen_add_tax($shopping_cart_products_value['original_price']);
            $shopping_cart_products_value['products_image_80'] = HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($shopping_cart_products_value['products_image'], 80, 80);

            if ($shopping_cart_products_value['products_status'] != 1 && $shopping_cart_products_value['products_status_my_products'] == 0) {
                if(!isset($my_products_array[$shopping_cart_products_value['products_id']]) || (isset($my_products_array[$shopping_cart_products_value['products_id']]) && !in_array($_SESSION['customer_id'], $my_products_array[$shopping_cart_products_value['products_id']]))) {
                    array_push($products_notify_array,$shopping_cart_products_value);
                    //$this->remove($shopping_cart_products_value['products_id'], false);
                    array_push($products_id_remove_array, $shopping_cart_products_value['products_id']);
                    continue;
                }
            }

            if (isset ($my_products_array[$shopping_cart_products_value['products_id']]) && !in_array($_SESSION['customer_id'], $my_products_array[$shopping_cart_products_value['products_id']])) {
                array_push($products_notify_array, $shopping_cart_products_value);
                array_push($products_id_remove_array, $shopping_cart_products_value['products_id']);
                continue;
            }

            /*
            if($shopping_cart_products_value['is_sold_out']==0 && !check_my_product($_SESSION['customer_id'], $shopping_cart_products_value['products_id'])) {
                $products_down .= '<tr>
                    <td><div class="totalimg"><a class="imgborder"><img alt="'. htmlspecialchars(zen_clean_html($products_name)) .'" src="'. HTTP_IMG_SERVER .'bmz_cache/'. DIR_WS_IMAGES . get_img_size( $shopping_cart_products_value['products_image'] ,80,80).'"></a>      </div></td>
                    <td>'. $shopping_cart_products_value['products_model'] .'</td>
                    <td>'. $shopping_cart_products_value['customers_basket_quantity'] .'</td>
                    <td class="name">'. $products_name .'</td>
                  </tr>';
                $pdown ++;
                $this->remove($shopping_cart_products_value['products_id']);

                $products_result->MoveNext();
                continue;
            }
            */

            if ($shopping_cart_products_value['products_quantity_order_min'] > 1 && $shopping_cart_products_value['customers_basket_quantity'] < $shopping_cart_products_value['products_quantity_order_min']) {
                if($shopping_cart_products_value['products_quantity_order_min'] > 0) {
                    $_SESSION['cart_products_errors'] .= ($_SESSION['cart_products_errors'] != '' ? '<br /><ins></ins>' : '') . sprintf(TEXT_ADDCART_MIN_COUNT, $shopping_cart_products_value['products_model'], $shopping_cart_products_value['products_quantity_order_min'], $shopping_cart_products_value['products_quantity_order_min']);
                    $products_qty_update_auto_note = sprintf(TEXT_ADDCART_MIN_COUNT, $shopping_cart_products_value['products_model'], $shopping_cart_products_value['products_quantity_order_min'], $shopping_cart_products_value['products_quantity_order_min']);
                    $this->update_quantity($shopping_cart_products_value['products_id'], $shopping_cart_products_value['products_quantity_order_min']);
                    $qty = $shopping_cart_products_value['products_quantity_order_min'];
                }else {
                    array_push($products_notify_array, $shopping_cart_products_value);
                    array_push($products_id_remove_array, $shopping_cart_products_value['products_id']);
                    continue;
                }

            }

            if ($shopping_cart_products_value['products_limit_stock'] == 1 && $shopping_cart_products_value['customers_basket_quantity'] > $shopping_cart_products_value['products_quantity']) {
                if($shopping_cart_products_value['products_quantity'] > 0) {
                    $_SESSION['cart_products_errors'] .= ($_SESSION['cart_products_errors'] != '' ? '<br /><ins></ins>' : '') . sprintf(TEXT_CART_ERROR_NOTE_PRODUCT_LESS, $shopping_cart_products_value['products_quantity'], $shopping_cart_products_value['products_model'], $shopping_cart_products_value['products_quantity']);
                    $products_qty_update_auto_note = sprintf(TEXT_CART_ERROR_NOTE_PRODUCT_LESS, $shopping_cart_products_value['products_quantity'], $shopping_cart_products_value['products_model'], $shopping_cart_products_value['products_quantity']);
                    $this->update_quantity($shopping_cart_products_value['products_id'], $shopping_cart_products_value['products_quantity']);
                    $qty = $shopping_cart_products_value['products_quantity'];
                } else {
                    $shopping_cart_products_value['products_status'] = 0;
                    array_push($products_notify_array, $shopping_cart_products_value);
                    array_push($products_id_remove_array, $shopping_cart_products_value['products_id']);
                    continue;
                }
            }

            //doreenbeads和8seasons不同逻辑
            if ($shopping_cart_products_value['products_quantity_order_units'] != 1 && $shopping_cart_products_value['customers_basket_quantity'] != $shopping_cart_products_value['products_quantity_order_units']) {
                if($shopping_cart_products_value['products_quantity_order_units'] > 0) {
                    $_SESSION['cart_products_errors'] .= ($_SESSION['cart_products_errors'] != '' ? '<br /><ins></ins>' : '') . sprintf(TEXT_CART_ERROR_NOTE_PRODUCT_LESS, $shopping_cart_products_value['products_quantity'], $shopping_cart_products_value['products_model'], $shopping_cart_products_value['products_quantity']);
                    $this->update_quantity($shopping_cart_products_value['products_id'], $shopping_cart_products_value['products_quantity_order_units']);
                    $qty = $shopping_cart_products_value['products_quantity_order_units'];
                } else {
                    array_push($products_notify_array, $shopping_cart_products_value);
                    array_push($products_id_remove_array, $shopping_cart_products_value['products_id']);
                    continue;
                }
            }
            if (sizeof($this->shopping_cart_merge_items) > 0) {
                foreach ($this->shopping_cart_merge_items as $cart_id => $plus_qty) {
                    if ($shopping_cart_products_value['customers_basket_id'] == $cart_id) {
                        $products_qty_update_auto_note = sprintf(TEXT_UPDATE_QTY_SUCCESS_MOBILE, $qty);
                    }
                }
            }
            if (QUANTITY_DECIMALS != 0) {
                $fix_qty = $shopping_cart_products_value['customers_basket_quantity'];
                switch (true) {
                    case (!strstr($fix_qty, '.')) :
                        $qty = $fix_qty;
                        break;
                    default :
                        $qty = preg_replace('/[0]+$/', '', $shopping_cart_products_value['customers_basket_quantity']);
                        break;
                }
            }

            //$check_unit_decimals = zen_get_products_quantity_order_units((int)$shopping_cart_products_value['products_id']);
            $check_unit_decimals = $shopping_cart_products_value['products_quantity_order_units'];
            if (strstr($check_unit_decimals, '.')) {
                $qty = round($qty, QUANTITY_DECIMALS);
            } else {
                $qty = round($qty, 0);
            }

            // adjusted count for free shipping
            if ($shopping_cart_products_value['product_is_always_free_shipping'] != 1 && $shopping_cart_products_value['products_virtual'] != 1) {
                $products_vol_weight_orgin = $shopping_cart_products_value['products_volume_weight'];
                if ($shopping_cart_products_value['products_volume_weight'] > $shopping_cart_products_value['products_weight']) {
                    $products_vol_weight = $shopping_cart_products_value['products_volume_weight'];
                    if ($shopping_cart_products_value['products_volume_weight'] * 0.625 > $shopping_cart_products_value['products_weight']) {
                        $products_vol_weight_ems = $shopping_cart_products_value['products_volume_weight'] * 0.625;
                    } else {
                        $products_vol_weight_ems = $shopping_cart_products_value['products_weight'];
                    }
                } else {
                    $products_vol_weight = $shopping_cart_products_value['products_weight'];
                    $products_vol_weight_ems = $shopping_cart_products_value['products_weight'];
                }
                $products_weight = $shopping_cart_products_value['products_weight'];
            } else {
                $products_weight = 0;
            }

            if($shopping_cart_products_value['is_checked'] == 1) {
                $is_checked_count++;

                $this->products_products_checked[] = $shopping_cart_products_value['products_id'];

                /*Tianwen.Wan20141015购物车优化->废弃Tianwen.Wan->已经没有免费商品
                $zen_get_products_price_is_free = zen_get_products_price_is_free($shopping_cart_products_value['products_id']);
                if ($zen_get_products_price_is_free) {
                  // no charge
                  $products_price = 0;
                }
                */

                //没有不等于0的数据
                //if ($shopping_cart_products_value['products_discount_type'] != '0') {
                //$products_price = zen_get_products_discount_price_qty($shopping_cart_products_value['products_id'], $qty, 0, true, $shopping_cart_products_value);
                //$original_price = zen_get_products_discount_price_qty($shopping_cart_products_value['products_id'], $qty, 0, false, $shopping_cart_products_value);
                //}

                //if (zen_is_promotion_price_time()) {
                if ($shopping_cart_products_value['dailydeal_price'] > 0) {
                    $this->daily_deal_total += $shopping_cart_products_value['dailydeal_price'] * $qty;
                }
                //}


                /*
                if (zen_is_promotion_time_fixed_price() || zen_is_daily_deals_promotion_time()) {
                    $get_products_promotion_price = get_products_promotion_price($shopping_cart_products_value['products_id']);
                    if ($current_promotion_price_list = $get_products_promotion_price) {
                        //$this->total_new_promotion += ($currencies->format_cl(zen_get_products_base_price($shopping_cart_products_value['products_id'])  - $current_promotion_price_list)) * $qty;
                        //Tianwen.Wan20141015购物车优化->上面已经有
                        $this->total_new_promotion += ($currencies->format_cl($shopping_cart_products_value['products_price'] - $current_promotion_price_list)) * $qty;
                    }
                }
                */

                $get_with_vip = get_with_vip($shopping_cart_products_value['products_id']);
                if (!$get_with_vip) {
                    $this->promotion_weight += ($qty * $products_weight);
                    $promotion_info = get_product_promotion_info($shopping_cart_products_value['products_id']);
                    if (isset($promotion_info['pp_max_num_per_order']) && $promotion_info['pp_max_num_per_order'] > 0) {
                        $pp_max_num_per_order = $promotion_info['pp_max_num_per_order'];
                        if ($qty > $pp_max_num_per_order) {
                            $this->normal_total_usd += $products_price * $qty;
                        }else{
                            $this->promotion_total += $currencies->format_cl(zen_add_tax($products_price, $products_tax)) * $qty;
                            $this->promotion_total_usd += zen_add_tax($products_price, $products_tax) * $qty;
                        }
                    }else{
                        $this->promotion_total += $currencies->format_cl(zen_add_tax($products_price, $products_tax)) * $qty;
                        $this->promotion_total_usd += zen_add_tax($products_price, $products_tax) * $qty;
                    }

                }

                $this->volume_weight += ($qty * $products_vol_weight);
                $this->volume_weight_ems += ($qty * $products_vol_weight_ems);
                $this->products_volume_weight_orgin += ($qty * $products_vol_weight_orgin);
                $this->weight += ($qty * $products_weight);

                $this->total_original += $currencies->format_cl(zen_add_tax($original_price, $products_tax)) * $qty;
                $this->total += zen_add_tax($products_price, $products_tax) * $qty;
                $this->total_new += $currencies->format_cl(zen_add_tax($products_price, $products_tax)) * $qty;
                if($products_price == $original_price){
                    $this->origin_amount += $currencies->format_cl(zen_add_tax($original_price, $products_tax)) * $qty;
                }else{
                    $this->discount_amount += $currencies->format_cl(zen_add_tax($original_price, $products_tax)) * $qty;
                }
            }
            /*functino calculate程序结束*/

            $products_array_temp = array (
                'id' => $prid,
                'customers_basket_id' => $shopping_cart_products_value['customers_basket_id'],
                'qty' => $shopping_cart_products_value['products_quantity'],
                //'category' => $shopping_cart_products_value['master_categories_id'],
                'name' => $shopping_cart_products_value['products_name'],
                'model' => $shopping_cart_products_value['products_model'],
                'image' => $shopping_cart_products_value['products_image'],
                'price' => $products_price,
                'quantity' => $qty,
                'weight' => round($shopping_cart_products_value['products_weight'], 2),
                'volume_weight' => round($shopping_cart_products_value['products_volume_weight'], 2),
                // fix here
                'final_price' => $products_price,
                'onetime_charges' => 0,
                'tax_class_id' => $shopping_cart_products_value['products_tax_class_id'],
                //'attributes' => ((isset($products_attribute_array) && sizeof($products_attribute_array) > 0) ? $products_attribute_array[$prid]['attributes'] : ''),//�д��޸�jessa
                //'attributes_values' => ((isset($products_attribute_value_array) && sizeof($products_attribute_value_array) > 0) ? $products_attribute_value_array[$prid]['attributes_values'] : ''),
                'products_priced_by_attribute' => $shopping_cart_products_value['products_priced_by_attribute'],
                'product_is_free' => $shopping_cart_products_value['product_is_free'],
                'products_discount_type' => $shopping_cart_products_value['products_discount_type'],
                'original_price' => $original_price,
                'products_discount_type_from' => $shopping_cart_products_value['products_discount_type_from'],
                'product_quantity' => $shopping_cart_products_value['products_quantity'],
                'is_checked' => $shopping_cart_products_value['is_checked'],
                'note' => $shopping_cart_products_value['note'],
                'products_qty_update_auto_note' => $products_qty_update_auto_note,
                'products_stocking_days' => get_products_info_memcache($prid, 'products_stocking_days'),
            );
            //$products_result->MoveNext();
            if($products_array_temp['is_checked'] == 1) {
                array_push($products_array, $products_array_temp);
            }
            array_push($products_array_all, $products_array_temp);
        }
        if($is_include_invalid_product == true) {
            $products_array = array_merge($products_array, $products_notify_array);
            $products_array_all = array_merge($products_array_all, $products_notify_array);
        }

        //if (!$is_mobilesite) {
        //  if (!empty ($products_id_remove_array)) {
        //    $this->remove($products_id_remove_array);
        //  }
        //}
        unset($this->shopping_cart_merge_items);

        //if ($pdown > 0) {
        //	$_SESSION['cart_products_errors'] .= ($_SESSION['cart_products_errors'] != '' ? '<br /><ins></ins> ' : '') . ($pdown > 1 ? TEXT_CART_ERROR_NOTE_PRODUCT_DOWN : TEXT_CART_ERROR_NOTE_PRODUCT_DOWN_SINGLE) . '<a class="btn_show" href="javascript:void(0)">' . TEXT_VIEW_DETAILS . '<ins></ins></a><a class="btn_close" style="display:none;" href="javascript:void(0)">' . TEXT_VIEW_LESS . '<ins></ins></a>' . $products_down_s . $products_down . '</table>';
        //}

        $products_notify_also_like_array = array();
        if (!empty ($products_notify_array)) {
            $products_notify_also_like_array = get_products_without_catg_relation($products_id_remove_array);
            if ($is_mobilesite) {
                $_SESSION['cart_products_down_errors'] .= TEXT_SHOPPING_CART_DOWN_NOTE . '<p style="display:none;">';
                foreach ($products_notify_array as $products_notify_key => $products_notify_value) {
                    $products_notify_array[$products_notify_key]['also_like_str'] = "";
                    if(isset($products_notify_also_like_array[$products_notify_value['products_id']])) {
                        $products_notify_array[$products_notify_key]['also_like_str'] = $also_like_str = "<a href='" . zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=similar&products_id=' . $products_notify_value['products_id']) . "' target='_blank'>" . TEXT_SHOPING_CART_SELECT_SIMILAR_ITEMS . "</a>&nbsp;&nbsp;";
                    }
                    $_SESSION['cart_products_down_errors'] .= '<span class="fontblue">[' . $products_notify_value['products_model'] . ']</span> ' . getstrbylength(htmlspecialchars(zen_clean_html($products_notify_value['products_name'])), 60) . '<br>';;
                }
                $_SESSION['cart_products_down_errors'] .= '</p><br/><a class="btn_show" href="javascript:void(0);">' . TEXT_VIEW_DETAILS . '</a><a style="display:none;" class="btn_close" href="javascript:void(0);">' . TEXT_VIEW_LESS_SHOPPING_CART . '</a></div>';
            } else {
                $_SESSION['cart_products_down_errors'] .= TEXT_SHOPPING_CART_DOWN_NOTE . '<a class="btn_show" href="javascript:void(0)">' . TEXT_VIEW_DETAILS . '<ins></ins></a><a class="btn_close" style="display:none;" href="javascript:void(0)">' . TEXT_VIEW_LESS_SHOPPING_CART . '<ins></ins></a>' . $products_down_s;
                foreach ($products_notify_array as $products_notify_value) {
                    $also_like_str = "";
                    if(isset($products_notify_also_like_array[$products_notify_value['products_id']])) {
                        $also_like_str = "<a href='" . zen_href_link(FILENAME_PRODUCTS_COMMON_LIST, 'pn=similar&products_id=' . $products_notify_value['products_id']) . "' target='_blank'>" . TEXT_SHOPING_CART_SELECT_SIMILAR_ITEMS . "</a><br/>";
                    }
                    $_SESSION['cart_products_down_errors'] .= '<tr>
														<td><div class="totalimg"><a class="imgborder"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . $products_notify_value['products_image_80'] . '" alt="' .htmlspecialchars($products_notify_value['products_name'], ENT_QUOTES) . '"></a>      </div></td> 
														<td>' . $products_notify_value['products_model'] . '</td>
														<td class="name">' . getstrbylength(htmlspecialchars(zen_clean_html($products_notify_value['products_name'])), 100) . '</td>
														<td>' . $also_like_str . '<a href="javascript:void(0);" class="jq_products_invalid_one" data-id="' . $products_notify_value['customers_basket_id'] . '">' . TEXT_DELETE . '</a></td>
														  </tr>';
                }
                $_SESSION['cart_products_down_errors'] .= '<tr>
			        <td colspan="3" style="text-align:left;"><a class="btn_close" style="display: inline;" href="javascript:void(0)">' . TEXT_VIEW_LESS_SHOPPING_CART . '<ins></ins></a></td>
			        <td style="text-align:center;"><a href="javascript:void(0);" class="jq_products_invalid_all">' . TEXT_SHOPING_CART_EMPTY_INVALID_ITEMS . '</a></td>
			      </tr>';
                $_SESSION['cart_products_down_errors'] .= '</table>';
            }

        }
        /*
        if (!empty ($products_zero_array)) {
            $_SESSION['cart_products_out_stoct_errors'] .= TEXT_SHOPPING_CART_OUTSTOCK_NOTE;
            foreach ($products_zero_array as $products_zero_value) {
                $_SESSION['cart_products_out_stoct_errors'] .= '<br /><span style="color:#008FED;font-weight:700;">[' . $products_zero_value['products_model'] . ']</span> ' . '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_zero_value['products_id']) . '" target="_blank">' . $products_zero_value['products_name'] . '</a>';
            }
        }
        */

        //Tianwen.Wan20160624购物车优化,，is_sold_out的商品以后不需要了
        /*
        if ($pzero > 0) {
            $_SESSION['cart_products_errors'] .= ($_SESSION['cart_products_errors'] != '' ? '<br /><ins></ins> ' : '') . ($pzero > 1 ? TEXT_CART_ERROR_NOTE_PRODUCT_ZERO : TEXT_CART_ERROR_NOTE_PRODUCT_ZERO_SINGLE) . $products_qty_zero;
        }
        */

        if($is_include_not_checked) {
            $products_array = $products_array_all;
        }

        $_SESSION['count_cart'] = count($products_array_all);
        $count = count($products_array);
        if($is_include_invalid_product == false) {
            $count+= count($products_notify_array);
        }
        $is_checked_all = count($products_array) == $is_checked_count ? 1 : 0;
        if ($page_size > 0) {
            $products_array_count = count($products_array);
            $products_array_new = null;
            $products_array_new = array_slice($products_array, ($page -1) * $page_size, $page_size);
            return array (
                'data' => $products_array_new,
                'count' => $count,
                'is_checked_count' => $is_checked_count,
                'is_checked_all' => $is_checked_all,
                'products_removed_array' => $products_notify_array,
                'products_id_remove_array' => $products_id_remove_array
            );
        }
        return array (
            'data' => $products_array,
            'count' => $count,
            'is_checked_count' => $is_checked_count,
            'is_checked_all' => $is_checked_all,
            'products_removed_array' => $products_notify_array,
            'products_id_remove_array' => $products_id_remove_array
        );
    }



    /**
     * Method return all products model in the cart
     * @return string, 'B10198', 'B16383', 'B13511'
     * add by zale
     */
    function get_product_model_list() {
        global $db;
        $product_id_list = $this->get_product_id_list();
        if (zen_not_null($product_id_list)){
            $products_model = $db->Execute("select products_model from ".TABLE_PRODUCTS." where products_id in(" . $product_id_list . ")");
            if ($products_model->RecordCount() > 0){
                while (!$products_model->EOF){
                    $product_model_list .= "'".$products_model->fields['products_model']."', ";
                    $products_model->MoveNext();
                }
            }
            $product_model_list = substr($product_model_list, 0, -2);
        }
        return $product_model_list;
    }

    function move_to_wishlist($product_id){
        global $db;
        if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '' && (int)$product_id != '') {
            $wishlist_check = $db->Execute ( 'select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . (int)$product_id . ' and wl_customers_id = ' . $_SESSION ['customer_id'] );
            if ($wishlist_check->RecordCount () == 0) {
                $sql = 'insert into ' . TABLE_WISH . ' (wl_products_id, wl_customers_id, wl_date_added) values (' . (int)$product_id . ', ' . $_SESSION ["customer_id"] . ', "' . date ( 'Y-m-d H:i:s' ) . '")';
                $db->Execute ( $sql );
                update_products_add_wishlist(intval($product_id));
            }
            $this->remove ( (int)$product_id );
        }
    }

    /**
     * check and refresh christmas gift
     */
    function check_gift(){
        return false;//	lvxiaoyong 20150707
        if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != ''){
            $this->remove($_SESSION['gift_id']);
            if($this->show_total ()>=30 && $_SESSION['customer_gift']>0){
                $this->add_cart($_SESSION['gift_id']);
            }
            $_SESSION['cartID'] = $this->cartID;
            return $this->cartID;
        }else{
            return false;
        }
    }

    function product_in_wishlist($product_id){
        global $db;
        $check = false;
        if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '' && (int)$product_id != '') {
            $wishlist_check = $db->Execute ( 'select wl_products_id from ' . TABLE_WISH . ' where wl_products_id = ' . (int)$product_id . ' and wl_customers_id = ' . $_SESSION ['customer_id'] );
            if ($wishlist_check->RecordCount () > 0) {
                $check = true;
            }
        }
        return $check;
    }
}
?>