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
//if($getsProInfoStr)$extra_params.=$getsProInfoStr;
?>
<?php 
echo zen_draw_form('sorter_form', zen_href_link($_GET['main_page'],zen_get_all_get_params()), 'get' ,'class="fleft" onchange=" $(this).submit();"');
// $seo_pages = array(		
// 		FILENAME_PRODUCTS_NEW,
// 		FILENAME_FEATURED_PRODUCTS,
// 		FILENAME_PRODUCTS_BEST_SELLER
// );
// if(!in_array($_GET['main_page'], $seo_pages)){
// 	echo zen_draw_hidden_field('main_page', $_GET['main_page']);
// }
//echo zen_draw_hidden_field('page', (isset($_GET['page']) && $_GET['page'] != '' ? $_GET['page'] : 1));  
if (isset($_GET['cPath']) && $_GET['cPath'] != '') echo zen_draw_hidden_field('cPath', $_GET['cPath']);
if (isset($_GET['categories_id'])) echo zen_draw_hidden_field('categories_id', $_GET['categories_id']);
if (isset($_GET['products_id'])) echo zen_draw_hidden_field('products_id', $_GET['products_id']);
if (isset($_GET['cId'])) echo zen_draw_hidden_field('cId', $_GET['cId']);
if (isset($_GET['off'])) echo zen_draw_hidden_field('off', $_GET['off']);
if (isset($_GET['keyword'])) echo zen_draw_hidden_field('keyword', $_GET['keyword']);
//echo $extra_params;
echo zen_hide_session_id();
switch ($_GET['disp_order']){
	case '10' : $sort_title = TEXT_INFO_SORT_BY_QTY_DATE; break;
	case '6' : $sort_title = TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC; break;
	case '7' : $sort_title = TEXT_INFO_SORT_BY_PRODUCTS_DATE; break;
	case '3' : $sort_title = TEXT_INFO_SORT_BY_PRODUCTS_PRICE; break;
	case '4' : $sort_title = TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC; break;
	//case '5' : $sort_title = TEXT_INFO_SORT_BY_PRODUCTS_MODEL; break;
	case '30': $sort_title = WEBSITE_PRODUCTS_SORT_TYPE == 'score' ? TEXT_INFO_SORT_BY_BEST_MATCH : TEXT_INFO_SORT_BY_BEST_SELLERS; break;
	default : $sort_title = TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC;
}
?>
<select name="disp_order">
	<option value="5">Sort by</option>
	<option value="3" <?php if(isset($_GET['disp_order']) && $_GET['disp_order'] = "3") echo "selected";?>>Price &uarr;</option>
	<option value="4" <?php if(isset($_GET['disp_order']) && $_GET['disp_order'] = "4") echo "selected";?>>Price &darr;</option>
	<option value="6" <?php if(isset($_GET['disp_order']) && $_GET['disp_order'] = "6") echo "selected";?>>New-Old</option>
	<option value="7" <?php if(isset($_GET['disp_order']) && $_GET['disp_order'] = "7") echo "selected";?>>Old-New</option></select>
</form>