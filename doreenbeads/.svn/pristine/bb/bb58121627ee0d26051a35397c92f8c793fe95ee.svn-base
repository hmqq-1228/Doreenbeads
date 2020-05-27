<div class="viewleft">
<?php
	$extra_params = '';
	if (isset($_GET['cPath']) && $_GET['cPath'] != '') $extra_params .= '&cPath=' . $_GET['cPath'];
	if (isset($_GET['inc_subcat']) && $_GET['inc_subcat'] != '') $extra_params .= '&inc_subcat=' . $_GET['inc_subcat'];
	if (isset($_GET['search_in_description']) && $_GET['search_in_description'] != '') $extra_params .= '&search_in_description=' . $_GET['search_in_description'];
	if (isset($_GET['keyword']) && $_GET['keyword'] != '') $extra_params .= '&keyword=' . $_GET['keyword'];
	if (isset($_GET['categories_id']) && $_GET['categories_id'] != '') $extra_params .= '&categories_id=' . $_GET['categories_id'];
	if (isset($_GET['disp_order']) && $_GET['disp_order'] != '') $extra_params .= '&disp_order='.$_GET['disp_order'];
	if (isset($_GET['per_page']) && $_GET['per_page'] != '') $extra_params .= '&per_page='.$_SESSION['per_page'];
	if (isset($_GET['page']) && $_GET['page'] != '') $extra_params .= '&page='.$_GET['page'];
	if (isset($_GET['products_id']) && $_GET['products_id'] != '') $extra_params .= '&products_id='.$_GET['products_id'];
	if (isset($_GET['cId'])) $extra_params .= '&cId='.$_GET['cId'];
	if (isset($_GET['off'])) $extra_params .= '&off='.$_GET['off'];
	if (isset($_GET['pn']))  $extra_params .= '&pn=' . $_GET['pn'];
	if (isset($_GET['pid'])) $extra_params .= '&pid=' . $_GET['pid'];
	if (isset($_GET['aId'])) $extra_params .= '&aId=' . $_GET['aId'];
	if (isset($_GET['referer_level2'])) $extra_params .= '&referer_level2=' . $_GET['referer_level2'];
	if($getsProInfoStr){
		$extra_params .= $getsProInfoStr;
	}
	
	if ($_SESSION['display_mode'] == 'quick'){
?>
	<?php echo TEXT_VIEW;?> : <a rel="nofollow" class="list" title="<?php echo TEXT_VIEW_LIST;?>" href="<?php echo zen_href_link($_GET['main_page'], 'action=normal' . $extra_params);?>"></a><a rel="nofollow" class="gallery" title="<?php echo TEXT_VIEW_GALLERY;?>" href="javascript:void(0);"></a>
<?php 		
	}
	if ($_SESSION['display_mode'] == 'normal'){
?>
	<?php echo TEXT_VIEW;?> : <a rel="nofollow" class="list2" title="<?php echo TEXT_VIEW_LIST;?>" href="javascript:void(0);"></a><a rel="nofollow" class="gallery2" title="<?php echo TEXT_VIEW_GALLERY;?>" href="<?php echo zen_href_link($_GET['main_page'], 'action=quick' . $extra_params);?>"></a>
<?php	
	}
?>
</div>
