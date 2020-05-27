<?php
	$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
	$per_page_parameters = zen_get_all_get_params(array('per_page', 'page'));
//	$per_page_parameters .= '&page=' . $page;
?>
<div class="selectlike">
	<label><?php echo TEXT_SHOW;?>: </label>
	<p class="selectnum">
		<span class="text_left1"><?php echo $per_page_num; ?></span>
		<span class="arrow_right1"></span>
	</p>
	<ul class="numlist" style="display: none;">
		<li><a rel="nofollow" href="<?php echo zen_href_link($_GET['main_page'], $per_page_parameters . '&per_page='.ITEM_PERPAGE_SMALL); ?>"><?php echo ITEM_PERPAGE_SMALL?></a></li>
		<li><a rel="nofollow" href="<?php echo zen_href_link($_GET['main_page'], $per_page_parameters . '&per_page='.ITEM_PERPAGE_DEFAULT); ?>"><?php echo ITEM_PERPAGE_DEFAULT?></a></li>
		<li><a rel="nofollow" href="<?php echo zen_href_link($_GET['main_page'], $per_page_parameters . '&per_page='.ITEM_PERPAGE_LARGE); ?>"><?php echo ITEM_PERPAGE_LARGE?></a></li>
	</ul>
</div>
