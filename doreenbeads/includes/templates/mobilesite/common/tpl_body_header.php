<div class="header"> 
  <div class="top_nav">
  <a class="head_menu" href="javascript:void(0);" id="headShowSidebar"></a>
  <h1 class="head_logo"> 
  	<a href="<?php echo zen_href_link(FILENAME_DEFAULT)?>"></a>
  </h1>
  <div class="headert_lf"> 
	<a class="jq_head_cart head_cart<?php if(!empty($_SESSION['count_cart'])) {echo "_on";}?>" href="<?php echo zen_href_link(FILENAME_SHOPPING_CART)?>"><span><?php echo ($_SESSION['count_cart'] > 99 ? '99+': $_SESSION['count_cart']);?></span></a> 
  	<!--<a class="icon_person" href="<?php echo zen_href_link(FILENAME_MYACCOUNT)?>"></a>-->
  	<a class="icon_search toggle_search" href="javascript:void(0);"></a> 
  </div>
  <div class="clearfix"></div>
  </div> 
  <div class="search" id="headSearchDiv" style="display:none"> 
	<form action="index.php?main_page=advanced_search_result" name="quick_find" method="get">
		<input type="hidden" name="main_page" value="<?php echo FILENAME_ADVANCED_SEARCH_RESULT;?>">
		<a class="search_icon" href="javascript:void(0);" id="btnSearch" ></a>
		<input type="text" class="searchinput search_lf" id="inputString" name="keyword" value="<?php echo (isset($_GET['keyword']) && $_GET['keyword'] != '' ? $_GET['keyword'] : '');?>" placeholder="<?php echo HEADER_SEARCH_DEFAULT_TEXT;?>" autocomplete="off" maxlength="100"/>
		<ul class="searchlist" id="autoSuggestionsList"></ul>
		<?php 
		//echo zen_draw_hidden_field('main_page',FILENAME_ADVANCED_SEARCH_RESULT);
		echo zen_draw_hidden_field('inc_subcat', '1');
		//echo zen_draw_hidden_field('search_in_description', '1') . zen_hide_session_id();
		echo zen_draw_hidden_field('search_in_description', '1');
		echo zen_draw_hidden_field('add_report', '1');
		?> 
	</form>
  </div>
  <?php
	echo '<input type="hidden" id="c_lan" value="' . $_SESSION ['language'] . '">';
	echo '<input type="hidden" id="isLogin" value="' . $_SESSION ['customer_id'] . '">';
  ?>
</div>
<?php
	if(!($_GET['main_page'] == 'index' && $_GET['cPath'] == '')){
		echo show_coupon_letter('mobiesite');
	}
?>