<?php
/**
 * wishlist.php
 * 
 */

  require('includes/application_top.php');
  
  $filter = (isset($_GET['filter']) ? $_GET['filter'] : '');
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  
  if (zen_not_null($filter)){
	  switch ($filter){
	  	case 'byproductmodel':
	  		$products_model = $_GET['model'];
	  		$wishlist_query = "select p.products_id, p.products_model, c.customers_firstname,
	  								  c.customers_email_address, w.wl_date_added
	  							 from " . TABLE_PRODUCTS . " p, " . TABLE_CUSTOMERS . " c, t_wishlist w
	  							where p.products_model = '" . $products_model . "'
	  							  and p.products_id = w.wl_products_id
	  							  and w.wl_customers_id = c.customers_id
	  						 order by w.wl_date_added desc";
	  		break;
	  	case 'bycustomeremail':
	  		$customer_email = $_GET['email'];
	  		$wishlist_query = "select p.products_id, p.products_model, c.customers_firstname,
	  								  c.customers_email_address, w.wl_date_added
	  							 from " . TABLE_PRODUCTS . " p, " . TABLE_CUSTOMERS . " c, t_wishlist w
	  							where w.wl_customers_id = c.customers_id
	  							  and c.customers_email_address = '" . $customer_email . "'
	  							  and w.wl_products_id = p.products_id
	  						 order by w.wl_date_added desc, p.products_model";
	  		break;
	  }
  
	  $wishlist_split = new splitPageResults($_GET['page'], 25, $wishlist_query, $wishlist_query_numrows);
	  $wishlist = $db->Execute($wishlist_query);
  } elseif (zen_not_null($action)) {
  	if ($action == 'groupby'){
  		$group = $_GET['group'];
  		if($group == ''){
  			$group = 'products';
  			$_GET['group'] = 'products';
  		}
  		switch ($group){
  			case 'products':
  				$wishlist_query = "select count(p.products_id) as num, p.products_model
  									 from " . TABLE_PRODUCTS . " p, t_wishlist w
  									where w.wl_products_id = p.products_id
  								 group by p.products_id
  								 order by num desc";
  				break;
  			case 'customers':
  				$wishlist_query = "select count(c.customers_id) as num, c.customers_firstname, c.customers_email_address
  				        			 from " . TABLE_CUSTOMERS . " c, t_wishlist w
  				        			where w.wl_customers_id = c.customers_id
  				        		 group by c.customers_id
  				        		 order by num desc";
  				break;
  		}
  		$wishlist_split = new splitPageResults($_GET['page'], 25, $wishlist_query, $wishlist_query_numrows);
  		$wishlist = $db->Execute($wishlist_query);
  	}
  }else{
  	zen_redirect(zen_href_link('wishlist', 'action=groupby&group=products', 'NONSSL'));
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
</head>
<body onload="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->


<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading" style="padding:15px 0px;"><?php echo 'Wishlist'; ?></td>
            <td align="right">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td style="text-align:right;padding:5px 0px;"><b>
                    <?php
                      echo zen_draw_form('wishlistemail', 'wishlist.php', '', 'get');
                      echo zen_draw_hidden_field('filter', 'bycustomeremail');
                      echo 'Filter By Customer Email: ' . zen_draw_input_field('email');
                    ?>
                    </form>
                    </b>
                  </td>
                </tr>
                <tr>
                  <td style="text-align:right;padding:5px 0px;"><b>
                    <?php
                      echo zen_draw_form('wishlistmodel', 'wishlist.php', '', 'get');
                      echo zen_draw_hidden_field('filter', 'byproductmodel');
                      echo 'Filter By Product Model: ' . zen_draw_input_field('model');
                    ?>
                    </form>
                    </b>
                  </td>
                </tr>
                <tr>
                  <td style="padding:5px 0px; text-align:right;"><b>
                    <?php
                      echo zen_draw_form('wishlistsortorder', 'wishlist.php', '', 'get');
                      echo zen_draw_hidden_field('action', 'groupby');
                      echo 'Group By: <select name="group" onchange="this.form.submit();">' . "\n";
                      echo '  <option value="">Select One</option>';
                      echo '  <option value="products" ' . ($_GET['group'] == 'products' ? 'selected="selected"' : '') . '>Products</option>' . "\n";
                      echo '  <option value="customers" ' . ($_GET['group'] == 'customers' ? 'selected="selected"' : '') . '>Customers</option>' . "\n";
                      echo '<input type="submit" value ="提交" style="display:none;">';
                    ?>
                    </form>
                    </b>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
              <?php
                if (zen_not_null($filter)){
              ?>
              <table border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr class="dataTableHeadingRow">
                  <td class="dataTableHeadingContent" width="10%" align="left"><?php echo 'Products Model'; ?></td>
                  <td class="dataTableHeadingContent" width="20%" align="left"><?php echo 'Customer Name'; ?></td>
                  <td class="dataTableHeadingContent" width="20%" align="left"><?php echo 'Customer Email'; ?></td>
                  <td class="dataTableHeadingContent" width="20%" align="center"><?php echo 'Date Added'; ?></td>
                </tr>
                <?php 
                  if ($wishlist->RecordCount() > 0){
                  	$wishlist_array = array();
                  	while (!$wishlist->EOF){
                  		$wishlist_array[] = array('id' => $wishlist->fields['products_id'],
                  								  'model' => $wishlist->fields['products_model'],
                  								  'name' => $wishlist->fields['customers_firstname'],
                  								  'email' => $wishlist->fields['customers_email_address'],
                  								  'date_added' => $wishlist->fields['wl_date_added']);
                  		$wishlist->MoveNext();
                  	}
                  }
                ?>
                <?php
                  for ($i = 0; $i < sizeof($wishlist_array); $i++){
                  	if ($i % 2 == 0){
                  		$class = 'defaultSelected';
                  	} else {
                  		$class = 'dataTableRow';
                  	}
                ?>
                <tr class="<?php echo $class; ?>">
                  <td style="padding:3px 0px;" class="dataTableContent" align="left"><?php echo $wishlist_array[$i]['model']; ?></td>
                  <td style="padding:3px 0px;" class="dataTableContent" align="left"><?php echo $wishlist_array[$i]['name']; ?></td>
                  <td style="padding:3px 0px;" class="dataTableContent" align="left"><?php echo $wishlist_array[$i]['email']; ?></td>
                  <td style="padding:3px 0px;" class="dataTableContent" align="center"><?php echo $wishlist_array[$i]['date_added']; ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td colspan="5">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr class="dataTableHeadingRow">
                        <td style="padding:5px 0px;text-align:left;" width="50%"><?php echo $wishlist_split->display_count($wishlist_query_numrows, 25, $_GET['page'], 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> products)'); ?></td>
                        <td style="padding:5px 0px;text-align:right;" width="50%"><?php echo $wishlist_split->display_links($wishlist_query_numrows, 25, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page'))); ?></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>  
              <?php
                } elseif (zen_not_null($action)){
                	if ($wishlist->RecordCount() > 0){
                		switch ($group){
                			case 'products':
		                		$wishlist_array = array();
		                		while (!$wishlist->EOF){
		                			$wishlist_array[] = array('id' => $wishlist->fields['products_id'],
		                									  'model' => $wishlist->fields['products_model'],
		                									  'num' => $wishlist->fields['num']);
		                			$wishlist->MoveNext();						  
		                		}
		                	break;
                			case 'customers':
                				$wishlist_array = array();
                				while (!$wishlist->EOF){
                					$wishlist_array[] = array('name' => $wishlist->fields['customers_firstname'],
                											  'email' => $wishlist->fields['customers_email_address'],
                											  'num' => $wishlist->fields['num']);
                					$wishlist->MoveNext();						  
                				}
                			break;
                		}
                	}
              ?>
              <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <?php 
                  switch ($group){
                  	case 'products':
                  		echo '<tr class="dataTableHeadingRow">
			                    <td class="dataTableHeadingContent" width="33%" align="center">Products Model</td>
			                    <td class="dataTableHeadingContent" width="33%" align="right">Wished Num</td>
			                  </tr>';
                  		for ($i = 0; $i < sizeof($wishlist_array); $i++){
                  			if ($i % 2 == 0){
                  				$class = 'defaultSelected';
                  			} else {
                  				$class = 'dataTableRow';
                  			}
                  			echo '<tr class="' . $class . '">
                  			        <td calss="dataTableContent" style="padding:3px;" align="center"><a href="' . zen_href_link('wishlist.php', 'filter=byproductmodel&model=' . $wishlist_array[$i]['model']) . '">' . $wishlist_array[$i]['model'] . '</a></td>
                  			        <td calss="dataTableContent" style="padding:3px; padding-right:10px;" align="right"><b>' . $wishlist_array[$i]['num'] . '</b></td>
                  			      </tr>';
                  		}
                  		break;
                  	case 'customers':
                  		echo '<tr class="dataTableHeadingRow">
                  			    <td class="dataTableHeadingContent" width="33%" align="left" style="padding:3px 0px;">Customer Name</td>
			                    <td class="dataTableHeadingContent" width="33%" align="center">Customer Email</td>
			                    <td class="dataTableHeadingContent" width="33%" align="right">Wished Num</td>
			                  </tr>';
                  		for ($i = 0; $i < sizeof($wishlist_array); $i++){
                  			if ($i % 2 == 0){
                  				$class = 'defaultSelected';
                  			} else {
                  				$class = 'dataTableRow';
                  			}
                  			echo '<tr class="' . $class . '">
                  			        <td class="dataTableContent" style="padding:8px;"><a href="' . zen_href_link('wishlist.php', 'filter=bycustomeremail&email=' . $wishlist_array[$i]['email']) . '">' . $wishlist_array[$i]['name'] . '</a></td>
                  			        <td calss="dataTableContent" style="padding:8px;" align="center"><a href="' . zen_href_link('wishlist.php', 'filter=bycustomeremail&email=' . $wishlist_array[$i]['email']) . '">' . $wishlist_array[$i]['email'] . '</a></td>
                  			        <td calss="dataTableContent" style="padding:8px; padding-right:10px;" align="right"><b>' . $wishlist_array[$i]['num'] . '</b></td>
                  			      </tr>';
                  		}
                  }
                ?>
                <tr>
                  <td colspan="3">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr class="dataTableHeadingRow">
                        <td style="padding:5px 0px;text-align:left;" width="50%"><?php echo $wishlist_split->display_count($wishlist_query_numrows, 25, $_GET['page'], 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> customers)');?></td>
                        <td style="padding:5px 0px;text-align:right;" width="50%"><?php echo $wishlist_split->display_links($wishlist_query_numrows, 25, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page'))); ?></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <?php
                }
              ?>
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->


<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>