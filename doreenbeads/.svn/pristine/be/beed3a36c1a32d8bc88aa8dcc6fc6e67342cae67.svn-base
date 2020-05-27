<?php
$extra_params = '';
if (isset($_GET['cPath'])) $extra_params .= '&cPath=' . $_GET['cPath'];
if (isset($_GET['inc_subcat'])) $extra_params .= '&inc_subcat=' . $_GET['inc_subcat'];
if (isset($_GET['search_in_description'])) $extra_params .= '&search_in_description=' . $_GET['search_in_description'];
if (isset($_GET['keyword'])) $extra_params .= '&keyword=' . $_GET['keyword'];
if (isset($_GET['categories_id'])) $extra_params .= '&categories_id=' . $_GET['categories_id'];
if (isset($_GET['disp_order'])) $extra_params .= '&disp_order='.$_GET['disp_order'];
if (isset($_GET['per_page'])) $extra_params .= '&per_page='.$_SESSION['per_page'];
if (isset($_GET['page'])) $extra_params .= '&page='.$_GET['page'];
if (isset($_GET['products_id'])) $extra_params .= '&products_id='.$_GET['products_id'];
if (isset($_GET['cId'])) $extra_params .= '&cId='.$_GET['cId'];
if (isset($_GET['off'])) $extra_params .= '&off='.$_GET['off'];


$display_sort_content = zen_draw_form('sorter_form', zen_href_link($_GET['main_page'],zen_get_all_get_params()), 'get' ,'class="fleft"');
$seo_pages = array(		
		FILENAME_PRODUCTS_NEW,
		FILENAME_FEATURED_PRODUCTS
);
if(!in_array($_GET['main_page'], $seo_pages)){
	$display_sort_content.= zen_draw_hidden_field('main_page', $_GET['main_page']);
}
//$display_sort_content.= zen_draw_hidden_field('page', (isset($_GET['page']) && $_GET['page'] != '' ? $_GET['page'] : 1));  
if (isset($_GET['cPath']) && $_GET['cPath'] != '') $display_sort_content.= zen_draw_hidden_field('cPath', $_GET['cPath']);
if (isset($_GET['categories_id'])) $display_sort_content.= zen_draw_hidden_field('categories_id', $_GET['categories_id']);
if (isset($_GET['products_id'])) $display_sort_content.= zen_draw_hidden_field('products_id', $_GET['products_id']);
if (isset($_GET['cId'])) $display_sort_content.= zen_draw_hidden_field('cId', $_GET['cId']);
if (isset($_GET['off'])) $display_sort_content.= zen_draw_hidden_field('off', $_GET['off']);
if (isset($_GET['pn'])) $display_sort_content.= zen_draw_hidden_field('pn', $_GET['pn']);
if (isset($_GET['keyword'])) $display_sort_content.= zen_draw_hidden_field('keyword', $_GET['keyword']);

$display_sort_content.= zen_hide_session_id();

$display_sort_content.= '<select name="disp_order" onchange="this.form.submit();">
	<option value="30" '.((!isset($_GET['disp_order']) || $_GET['disp_order'] == "30")?'selected="selected"':'').'>'.(WEBSITE_PRODUCTS_SORT_TYPE == 'score' ? TEXT_INFO_SORT_BY_BEST_MATCH : TEXT_INFO_SORT_BY_BEST_SELLERS).'</option>
	<option value="3" '.((isset($_GET['disp_order']) && $_GET['disp_order'] == "3")?'selected="selected"':'').'>'.TEXT_INFO_SORT_BY_PRODUCTS_PRICE.' &uarr;</option>
	<option value="4" '.((isset($_GET['disp_order']) && $_GET['disp_order'] == "4")?'selected="selected"':'').'>'.TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC.' &darr;</option>
	<option value="6" '.((isset($_GET['disp_order']) && $_GET['disp_order'] == "6")?'selected="selected"':'').'>'.TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC.'</option>
	<option value="7" '.((isset($_GET['disp_order']) && $_GET['disp_order'] == "7")?'selected="selected"':'').'>'.TEXT_INFO_SORT_BY_PRODUCTS_DATE.'</option>
	</select></form>';
?>
