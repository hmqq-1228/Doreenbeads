<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_listing_display_order.php 3369 2006-04-03 23:09:13Z drbyte $
 */
?>

<div id="sorter">
<label for="disp-order-sorter"><?php echo TEXT_INFO_SORT_BY; ?></label>
<?php
  echo zen_draw_form('sorter_form', zen_href_link($_GET['main_page']), 'get');
  echo zen_draw_hidden_field('main_page', $_GET['main_page']);
  //jessa 2010-03-29 ����һ������������ʱ�������Ĳ�Ʒ��ʾҳ�棬����ѡ������ʱ��¼������
  if (isset($_GET['cPath']) && $_GET['cPath'] != '') echo zen_draw_hidden_field('cPath', $_GET['cPath']);
  //eof jessa 2010-03-29
  
  //jessa 2010-03-31 ����һЩ��ѯ�����������������µ�����
  if (isset($_GET['inc_subcat'])) echo zen_draw_hidden_field('inc_subcat', $_GET['inc_subcat']);
  if (isset($_GET['search_in_description'])) echo zen_draw_hidden_field('search_in_description', $_GET['search_in_description']);
  if (isset($_GET['keyword'])) echo zen_draw_hidden_field('keyword', $_GET['keyword']);
  if (isset($_GET['categories_id'])) echo zen_draw_hidden_field('categories_id', $_GET['categories_id']);
  if (isset($_GET['manufacturers_id'])) echo zen_draw_hidden_field('manufacturers_id', $_GET['manufacturers_id']);
  if (isset($_GET['pfrom'])){
  	if ($_GET['pfrom'] == ''){
		$input_pfrom = '';
	}else{
		$input_pfrom = $_GET['pfrom'];
	}
  	echo zen_draw_hidden_field('pfrom', $input_pfrom);
  }
  if (isset($_GET['pto'])){ 
  	if ($_GET['pto'] == ''){
		$input_pto = '';
	}else{
		$input_pto = $_GET['pto'];
	}
  	echo zen_draw_hidden_field('pto', $input_pto);
  }
  if (isset($_GET['dfrom'])) echo zen_draw_hidden_field('dfrom', $_GET['dfrom']);
  if (isset($_GET['dto'])) echo zen_draw_hidden_field('dto', $_GET['dto']);
  if (isset($_GET['x'])) echo zen_draw_hidden_field('x', $_GET['x']);
  if (isset($_GET['y'])) echo zen_draw_hidden_field('y', $_GET['y']);
  if (isset($_GET['cId'])) echo zen_draw_hidden_field('cId', $_GET['cId']);
  if (isset($_GET['off'])) echo zen_draw_hidden_field('off', $_GET['off']);  
 
  //eof jessa 2010-03-31
  
  echo zen_hide_session_id();
?>
    <select name="disp_order" onchange="this.form.submit();" id="disp-order-sorter">
<?php if ($disp_order != $disp_order_default) { ?>
    <option value="<?php echo $disp_order_default; ?>" <?php echo ($disp_order == $disp_order_default ? 'selected="selected"' : ''); ?>><?php echo PULL_DOWN_ALL_RESET; ?></option>
<?php } // reset to store default ?>
<!--
jessa 2010-03-29 delete the sort order about name(asc and desc)
    <option value="1" <?php //echo ($disp_order == '1' ? 'selected="selected"' : ''); ?>><?php //echo TEXT_INFO_SORT_BY_PRODUCTS_NAME; ?></option>
    <option value="2" <?php //echo ($disp_order == '2' ? 'selected="selected"' : ''); ?>><?php //echo TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC; ?></option>
eof jessa 2010-03-29
-->
    <option value="3" <?php echo ($disp_order == '3' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_PRICE; ?></option>
    <option value="4" <?php echo ($disp_order == '4' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC; ?></option>
   <!-- <option value="5" <?php echo ($disp_order == '5' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_MODEL; ?></option>-->
    <option value="6" <?php echo ($disp_order == '6' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC; ?></option>
    <option value="7" <?php echo ($disp_order == '7' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_DATE; ?></option>
	<?php if ($_SESSION['has_valid_order']){ ?>
    <option value="9" <?php echo ($disp_order == '9' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_ORDER; ?></option>
	<?php } ?>
	<?php if($_GET['main_page'] == 'promotion'){ ?>
    <option id="opt6" value="40" <?php echo ($disp_order == '40' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_STOCK_LIMIT; ?></option>
	<?php } ?>	
    </select></form></div>