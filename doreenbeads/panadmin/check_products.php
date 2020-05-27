<?php
/**
 * check_products.php
 */

  require('includes/application_top.php');
  session_start();
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  
  $disp_order = '';
  switch ($action){
  	case 'pricehightolow':
  		$disp_order = " order by p.products_price desc, p.products_model";
  		break;
  	case 'pricelowtohigh':
  		$disp_order = " order by p.products_price, p.products_model";
  		break;
  	case 'pricerange':
  		$low_price = $_GET['lowprice'];
  		$high_price = $_GET['highprice'];
  		if (zen_not_null($low_price) && zen_not_null($high_price)){
  			$disp_order = " and p.products_price >= " . (float)$low_price . " and p.products_price <= " . (float)$high_price . " order by p.products_price";
  		} else {
  			if (zen_not_null($low_price) && !zen_not_null($high_price)){
  				$disp_order = " and p.products_price >= " . (float)$low_price . " order by p.products_price";
  			} elseif (!zen_not_null($low_price) && zen_not_null($high_price)){
  				$disp_order = " and p.products_price <= " . (float)$high_price . " order by p.products_price";
  			}
  		}
  		break;
  	default:
  		$disp_order = " order by p.products_price desc, p.products_model";
  	    break;
  }

  $check_products_query = "select p.products_id, p.products_model, p.products_quantity, p.products_image, p.products_status,
                                  p.products_price, pd.products_name
                             from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                            where p.products_id = pd.products_id" . $disp_order;
  $check_products_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $check_products_query, $check_products_numrows);
  $check_products = $db->Execute($check_products_query);
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
<body onLoad="init()">
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
            <td class="pageHeading" height="35"><?php echo 'Check All Products'; ?></td>
            <td class="pageHeading" align="right">
              <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <td style="text-align:right;padding:5px 0px;">
                  <?php
                    echo zen_draw_form('disp_order', 'check_products.php', '', 'get'); 
              		if (isset($_GET['page']) && $_GET['page'] != '') echo zen_draw_hidden_field('page', $_GET['page']);
                    echo 'Product Display Order:' . zen_draw_pull_down_menu('action', array(array('id'=>'pricehightolow', 'text'=>'Price: High to Low'), array('id'=>'pricelowtohigh', 'text'=>'Price: Low to High')), '', 'onchange="this.form.submit();"'); 
                  ?>
                  </form>
                  </td>
                </tr>
                <tr>
                  <td style="text-align:right;">
                  <?php 
                    echo zen_draw_form('priceto', 'check_products.php', '', 'get');
                    echo zen_draw_hidden_field('action', 'pricerange');
                    echo 'Price: From ' . zen_draw_input_field('lowprice', (isset($_GET['lowprice']) ? $_GET['lowprice'] : '')) . ' To ' . zen_draw_input_field('highprice', (isset($_GET['highprice']) ? $_GET['highprice'] : '')) . '<input type="submit" value="submit" style="display:none;">'; 
                  ?>
                  </form>
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
              <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr class="dataTableHeadingRow">
                  <td class="dataTableHeadingContent" style="padding:5px 3px;" width="10%"><?php echo 'Products ID'; ?></td>
                  <td class="dataTableHeadingContent" style="padding:5px 3px;" width="10%" align="center"><?php echo 'Model'; ?></td>
                  <td class="dataTableHeadingContent" style="padding:5px 3px;" width="10%" align="center"><?php echo 'Quantity'; ?></td>
                  <td class="dataTableHeadingContent" style="padding:5px 3px;" width="42%" align="center"><?php echo 'Name'; ?></td>
				  <td class="dataTableHeadingContent" style="padding:5px 3px;" width="8%" align="center"><?php echo 'Status'; ?></td>
                  <td class="dataTableHeadingContent" style="padding:5px 3px;" width="10%" align="center"><?php echo 'Price'; ?></td>
                </tr>
                <?php 
                  $i = 0;
                  while (!$check_products->EOF){ 
                ?>
                <?php if (($i % 2) == 0){ ?>
                <tr class="defaultSelected">
                <?php } else { ?>
                <tr class="dataTableRow">
                <?php } ?>
                  <td class="dataTableContent" style="padding:5px 3px;"><?php echo $check_products->fields['products_id']; ?></td>
                  <td class="dataTableContent" style="padding:5px 3px;" align="center"><?php echo $check_products->fields['products_model']; ?></td>
                  <td class="dataTableContent" style="padding:5px 3px;" align="center"><?php echo $check_products->fields['products_quantity']; ?></td>
                  <td class="dataTableContent" style="padding:5px 3px;"><?php echo $check_products->fields['products_name']; ?></td>
				  <td class="dataTableContent" style="padding:5px 3px;" align="center"><?php echo (($check_products->fields['products_status'] == 1) ? zen_image(DIR_WS_IMAGES . 'icon_green_on.gif') : zen_image(DIR_WS_IMAGES . 'icon_red_on.gif')); ?></td>
                  <td class="dataTableContent" style="padding:5px 3px;" align="right"><b><?php echo $check_products->fields['products_price']; ?></b></td>
                </tr>
                <?php 
                    $check_products->MoveNext();
                    $i++;
                  } 
                ?>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td style="padding:5px 0px; text-align:left;"><?php echo $check_products_split->display_count($check_products_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_COUNTRIES); ?></td>
                  <td style="padding:5px 0px; text-align:right;"><?php echo $check_products_split->display_links($check_products_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page'))); ?></td>
                </tr>
              </table>
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