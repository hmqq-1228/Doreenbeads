<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: postage_dist_mana.php,v 1.3 2007/04/28 00:00:00 DrByte Exp $
//

  define('OS_DELIM', '');

  require('includes/application_top.php');
  
  //jessa 2010-02-03 将设置discount价格表的函数引入进来
  require(DIR_WS_FUNCTIONS . 'function_discount.php');
  //eof jessa 2010-02-03
  
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if (zen_not_null($action)) {
  	switch ($action) {
  		case 'update1':
            $sql = "Select configuration_value, last_modified 
            		  From " . TABLE_CONFIGURATION . "
           			 Where configuration_group_id = 1010 order by sort_order asc";
		    $configures = $db->Execute($sql);
		    
		    $cur_currency = $configures->fields['configuration_value'];
		    $configures->MoveNext();
		    $cur_profit = $configures->fields['configuration_value'];
		    
		    $new_2fee = zen_db_prepare_input($_POST['currency']);
  			$new_dist = zen_db_prepare_input($_POST['profit']);
  			
  			if ($new_dist <= 0 || $new_2fee <= 0) {
  				echo ('填入的2公斤费用为:' . $new_2fee . '; 折扣为:' . $new_dist . '; 不符合要求，不进行更新.');
  				die();
  			}
  			
  			if($new_dist <> EMS_DISCOUNT or $new_2fee <> EMS_UK2KG_FEE){
  				$perg_fee = number_format($new_2fee * $new_dist / 2000, 6);
           	    
	  		  	$updateSql = "Update ".TABLE_CONFIGURATION. "
	  		  					 Set configuration_value = '".$new_2fee ."' , 
	  		  					 	 last_modified = now() 
	  		  				   Where configuration_key = 'EMS_UK2KG_FEE'";
	  		  	$db->Execute($updateSql);
	  		  	
	  		  	$updateSql = "Update " . TABLE_CONFIGURATION . " 
	  		  					 Set configuration_value = '" . $new_dist . "', 
	  		  					 	 last_modified = now() 
	  		  				   Where configuration_key = 'EMS_DISCOUNT'";
	  		  	$db->Execute($updateSql);
				
				//jessa 2010-02-03 在更新折扣价格的同时，对discount价格表进行更新
				$products_info = $db->Execute("Select products_id, products_net_price, product_price_times, products_weight,
													  products_price_sorter, products_price
												 From " . TABLE_PRODUCTS);
									
				while(!$products_info->EOF){
					$ls_products_id = $products_info->fields['products_id'];
					$ldc_net_price = $products_info->fields['products_net_price'];
					$ldc_price_times = $products_info->fields['product_price_times'];
					$ldc_product_weight = $products_info->fields['products_weight'];
					if ($products_info->fields['products_price_sorter'] <> $products_info->fields['products_price']) $lb_special = true;
					
					zen_refresh_products_price($ls_products_id, $ldc_net_price, $ldc_product_weight, 0, $ldc_price_times, $lb_special, &$as_errmsg);
					
					$products_info->MoveNext();
				}
				//eof jessa 2010-02-03 完成discount价格表的更新
  			}
  		break;
  	}
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
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

 <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
         </table>
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">

  <tr>
    <td colspan="2" align="left" style = "font-family:Verdana,sans-serif;font-size:15px;font-size-adjust:none;color:#003D00;
										  font-variant:small-caps;font-weight:bold;">
    	Update Postage Discount
    </td>
  </tr>
  <tr>
   <td>
  	<table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
             <table border="0" width="100%" cellspacing="0" cellpadding="2">
		              <tr class="dataTableHeadingRow">
		                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CURRENCY; ?></td>
		                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PROFIT; ?></td>
		                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_MODIFY_DATE; ?></td>
		                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
		              </tr>
		              <?php
		                echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(postage_dist_mana,'&action=edit') . '\'">' . "\n";
		                
		                $sql = "select configuration_value, last_modified from " . TABLE_CONFIGURATION . "
                                        						where configuration_group_id = 1010 order by sort_order asc";
		                $configures = $db->Execute($sql);
		                
		                
		              ?>					
		                <td class="dataTableContent">
		                     <?php
		                      $cur_currency = $configures->fields['configuration_value'];
		                	  echo  $cur_currency;
		                	  $configures->MoveNext();
		                	?>
		                </td>
		                <td class="dataTableContent">
		                	<?php
		                	  $cur_profit = $configures->fields['configuration_value'];
		                	  echo  $cur_profit;
		                	?>
		                </td>
		                <td class="dataTableContent">
		                	<?php
		                	  $last_modified = $configures->fields['last_modified'];
		                	  echo  $last_modified;
		                	?>
		                </td>
		                <td class="dataTableContent" align="right"><?php 
		                	  	echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); 
		                	 ?>
&nbsp;		                </td>
		                
		              </tr>
              </table>
            </td>
            
            <td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'edit':
      $heading[] = array('text' => '<b> Edit the Currency & Profit</b>');

      $contents = array('form' => zen_draw_form('currency', postage_dist_mana,'action=update1'));
      $contents[] = array('text' => 'Please make any neccesary changes:');
	  //jessa 2009-09-09 update "5KG Fee" => "2KG Fee"
      $contents[] = array('text' => '<br />New 2KG Fee(In US$)<br />' . zen_draw_input_field('currency', $cur_currency));
	  //eof jessa 2009-09-09
      $contents[] = array('text' => '<br />EMS Discount ( Like 0.41)<br />' . zen_draw_input_field('profit', $cur_profit));      
      $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_update.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . zen_href_link(postage_dist_mana) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
   default:
      $heading[] = array('text' => '<b>Currency & Profit</b>');
	  //jessa 2009-09-09 update "5KG Fee" => "2KG Fee"
      $contents[] = array('align' => 'left', 'text' => '<b>New 2KG Fee(In US$):</b> '.$cur_currency);     //eof jessa 2009-09-09
      $contents[] = array('align' => 'left', 'text' => '<b>EMS Discount ( Like 0.41)</b> '.$cur_profit);
      $contents[] = array('text' => '<br> <b>Last modified date:</b><br/> '.$last_modified );
      break;
  }

  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?></td>
            
          </tr>
      </table>
    </td>
  </tr>
</table>    
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>