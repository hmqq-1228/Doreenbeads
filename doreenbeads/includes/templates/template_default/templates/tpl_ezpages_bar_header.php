<?php
/**
 * Page Template
 *
 * Displays EZ-Pages Header-Bar content.<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_ezpages_bar_header.php 3377 2006-04-05 04:43:11Z ajeh $
 */

  /**
   * require code to show EZ-Pages list
   */
include(DIR_WS_MODULES . zen_get_module_directory('ezpages_bar_header.php'));
?>
<?php
/*jessa 2009-08-12 ɾ����Щ���룬���õ���*/
/*<?php if (sizeof($var_linksList) >= 1) { ?>
<div id="navEZPagesTop">
<?php for ($i=1, $n=sizeof($var_linksList); $i<=$n; $i++) {  ?>
  <a href="<?php echo $var_linksList[$i]['link']; ?>"><?php echo $var_linksList[$i]['name']; ?></a><?php echo ($i < $n ? EZPAGES_SEPARATOR_HEADER : '') . "\n"; ?>
<?php } // end FOR loop ?>
</div>
<?php } ?>
*/
/*eof jessa*/
?>
<!--jessa 2009-08-18 ɾ��ul��li�����span��Ŀ����Ϊ��ʹ����Ŀ¼�ĳ�������Ӧ���Ӷ�ʹIE֧������Ӧ��-->
<div id="navMain">
&nbsp;&nbsp;<?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><?php echo HEADER_TITLE_CATALOG; ?></a>&nbsp;<span>|</span>&nbsp;
<a href="<?php echo zen_href_link(FILENAME_PRODUCTS_NEW, '', 'SSL'); ?>"><?php echo 'New Arrivals'; ?></a>&nbsp;<span>|</span>&nbsp;
<a href="mix-c-1680.html">Mix</a>&nbsp;<span>|</span>&nbsp;
<a href="preferential-bulk-sale-40-off-c-1375.html"><?php echo 'Huge Discounts'; ?></a>&nbsp;<span>|</span>&nbsp;
<a href="<?php echo zen_href_link(FILENAME_PROMOTION);/*(zen_is_promotion_time() ? zen_href_link(FILENAME_PROMOTION) : '30-off-stock-clearance-c-1469.html');*/ ?>">Clearance Sale</a><img src="includes/templates/cherry_zen/images/sale.gif">
<?php if (sizeof($var_linksList) >= 1) { ?>
<?php echo '<span>|</span>'; ?>
<?php for ($i=1, $n=sizeof($var_linksList); $i<=$n; $i++) {  ?>
  <a href="<?php echo $var_linksList[$i]['link']; ?>"><?php echo $var_linksList[$i]['name']; ?></a><?php echo ($i < $n ? '&nbsp;<span>|</span>' : ''); ?>
<?php } // end FOR loop ?>
<?php } ?>
		</div>
	
<div id="addsearch">	
<?php
  global $db;
  
  $content .= zen_draw_form('quick_find', zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get');
		$content .= zen_draw_hidden_field('main_page',FILENAME_ADVANCED_SEARCH_RESULT);
		$content .= zen_draw_hidden_field('inc_subcat', '1');
		$content .= zen_draw_hidden_field('search_in_description', '1') . zen_hide_session_id();
		$content .= zen_draw_hidden_field('add_report', '1');
	
		if (isset($_SESSION['cPath']) and !empty($_SESSION['cPath']) and $cpath == ''){
			if (strpos($_SESSION['cPath'], '_') > 0) {
				$cpath = substr($_SESSION['cPath'], strrpos($_SESSION['cPath'], '_') + 1,
					strlen($_SESSION['cPath']) - strrpos($_SESSION['cPath'], '_'));
			}
			else {
				$cpath = $_SESSION['cPath'];
			}
		}
		
		if (isset($_GET['main_page']) && ($_GET['main_page'] == 'advanced_search_result')) {
			$cpath = $_GET['categories_id'];
			if($cpath == '') $current_category = false;
			$keyword = $_GET['keyword'];
		}
		
		$current_categories_id = trim($_GET['categories_id']);
		$categories_cpath = trim($_GET['cPath']);
		$categories_cpath_array = explode('_', $categories_cpath);
		
		//ɾ���˳�����HEADER_SEARCH_DEFAULT_TEXT��������������Ĭ������²���ʾ�κζ���
		$content .= 'Keywords:';
		$keyword = ($keyword == '') ? '' : $keyword;
		$content .= zen_draw_input_field('keyword', '', ' size="24" maxlength="140" onfocus="if (this.value == \'' . '' . '\')
		    			this.value = \'\';" onblur="if (this.value == \'\') this.value = \'' . '' . 
		    			'\';"');
		
		$content .= ' In: ';
		
		$categories_top = $db->Execute("select c.categories_id, cd.categories_name, c.categories_status 
									    from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd 
										where c.categories_status = 1 
										and parent_id = 0 
										and c.categories_id = cd.categories_id 
										and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
										order by sort_order, cd.categories_name");
										
		$content .= '<select name="categories_id">' . "\n";
		$content .= '<option value=""';
		if ($current_categories_id == '' && (isset($categories_cpath) && $categories_cpath == '')){
			$content .= ' selected="selected"';
		}
		$content .= '>' . TEXT_ALL_CATEGORIES . '</option>' . "\n";
		while(!$categories_top->EOF){
			$content .= '<option value="' . $categories_top->fields['categories_id'] . '"';
//			if ((isset($current_categories_id) && $current_categories_id == $categories_top->fields['categories_id']) || (isset($categories_cpath) && $categories_cpath_array[0] == $categories_top->fields['categories_id'])){
//				$content .= ' selected="selected"';
//			}

			if (isset($_GET['categories_id']) && $_GET['categories_id'] == $categories_top->fields['categories_id']){
				$content .= ' selected="selected"';
			}
			$content .= '>' . $categories_top->fields['categories_name'] . '</option>' . "\n";
			$categories_top->MoveNext();
		}
		$content .= '</select>' . "\n";
		
		$content .= '<input type="submit" value="' . HEADER_SEARCH_BUTTON . '" style="width: 65px" />&nbsp;';
		$content .= '<a href="' . zen_href_link(FILENAME_ADVANCED_SEARCH) . '">' . BOX_SEARCH_ADVANCED_SEARCH . '</a>';

		$content .= "</form>&nbsp;&nbsp;";
		
		echo $content;
?>
</div>
<?php
//promotion countdown	
$prom_status = zen_get_configuration_key_value('PROMOTION_COUNTDOWN_STATUS');
	$prom_start_date = strtotime(zen_get_configuration_key_value('PROMOTION_COUNTDOWN_START'));
	$prom_end_date = strtotime(zen_get_configuration_key_value('PROMOTION_COUNTDOWN_END'));
	$current_time=time()-3600*16;
	if($prom_status=='True' && $current_time>$prom_start_date && $current_time<($prom_end_date+86400)){
		require(DIR_WS_TEMPLATE.'/common/tpl_promotion_countdown.php');
	}else{
		if(DISPLAY_SHOW_PROMOTION_STATUS && $_GET['main_page'] !='login'){
		$define_promotion_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_PROMOTION, 'false');		
		require($define_promotion_page);
	}}
?>	