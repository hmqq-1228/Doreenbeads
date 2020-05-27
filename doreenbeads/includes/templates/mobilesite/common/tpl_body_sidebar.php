<?php
	$current_full_url = HTTP_SERVER.$_SERVER["REQUEST_URI"];
	
	if(!$this_is_product_list_page){
	/**********begin 非商品列表头部类别菜单*****************/
	$index_root_categories_array =zen_get_category_tree('0', '0', '', null, '0', false, false, '',true , true );
	
	$smarty->assign ( 'index_root_categories_array', $index_root_categories_array );
?>
	<div class="categories_al_tl"><a href="<?php echo zen_href_link(FILENAME_SITE_MAP)?>"><?php echo TEXT_SELECT_ALL_CATE;?></a></div>
	<div class="categories_al active">
		<ul>
	<?php if($index_root_categories_array && is_array($index_root_categories_array)){
		foreach($index_root_categories_array as $category){
			if($category['level'] <= $_SESSION['customers_level']){
				echo '<li><a href="'.zen_href_link(FILENAME_DEFAULT, $category['cPath']).'"><span>'.$category['text'].'</span><ins></ins></a></li>';
			}
		}
	} ?>
		</ul>
	</div>
<?php 
/**********end 非商品列表头部类别菜单*****************/
}else{ 
/**********begin 商品列表头部类别菜单*****************/
?>	
<div class="wrap-sidebar">
	<div class="title_tab">
		<ul class="nav-tabs">
			<li ><a data-toggle="tab" data-target="#title_tab_all_category" href="javascript:void(0)"><?php echo $this_is_best_match_category ? TEXT_SELECT_MATCH_CATE : TEXT_SELECT_ALL_CATE ;?></a></li>
            <li class="active"><a data-toggle="tab" data-target="#title_tab_refine_by" href="javascript:void(0)"><?php echo TEXT_REFINE_BY;?></a></li>
        </ul> 
	</div>
	<div class="mh_categories" id="title_tab_all_category">
<?php
	if($this_is_best_match_category){
		/**********begin 非正常类别进入的商品列表头部类别菜单-match category*****************/
		//Tianwen.Wan20170619->屏蔽Featured Categories
		$featured_id = "2066";
		if ($categories_refine_by && is_array($categories_refine_by))
		{
			foreach ($categories_refine_by as $root_category) {  
				preg_match_all("/^" . $featured_id . "_/", $root_category['cPath'], $featured_matches);
				if($root_category["category"]["id"] == $featured_id || !empty($featured_matches[0])) {
					continue;
				}
?>
	        <dl>
			    <dt><a href="<?php echo zend_remove_url_param(zend_set_url_param($current_full_url,cId,$root_category["category"]["id"]), 'page');?>"><?php echo $root_category["category"]["text"];?></a></dt>
			    <?php 
			    	if ($root_category['sub_categories'] && is_array($root_category['sub_categories'])) {
			    		foreach ($root_category['sub_categories'] as $second_category) {
			    ?>
			    <dd><a href="<?php echo zend_remove_url_param(zend_set_url_param($current_full_url,cId,$second_category["category"]["id"]), 'page');?>"><?php echo $second_category["category"]["text"]?> <span>(<?php echo $second_category["category"]["count"]?>)</span></a></dd>
			    <?php 	}
					}
				?>
			</dl> 
<?php  
			}
		}
	/**********end  非正常类别进入的商品列表头部类别菜单-match category*****************/
}else{  
	/**********begin 正常类别进入的商品列表头部类别菜单-all category*****************/
	$root_categories_array = zen_get_category_tree('0', '0', '', null, '0', false, false, '', true, true);
?>	  
		<div class="categories_al active">
			<ul>
			<?php if($root_categories_array && is_array($root_categories_array)){
				foreach($root_categories_array as $category){
					if($category['level'] == 0){
						echo '<li><a href="'.zen_href_link(FILENAME_DEFAULT, $category['cPath']).'">'.$category['text'].'<ins></ins></a></li>';
					}
				}
			} ?>
			</ul>
		</div>
<?php  
	/**********end 正常类别进入的商品列表头部类别菜单-all category*****************/
} ?> 
	</div> 
	<div class="refine_by active" id="title_tab_refine_by"> 
        <div class="button"><a href="<?php echo $property_clear_all_link;?>" class="btn_grey btn_property_clear_all"><?php echo TEXT_CLEAR_ALL;?></a></div>
		<div class="clearfix"></div>
		<?php if($refine_by_properties && is_array($refine_by_properties)){
				if (!$getsInfoArray || !is_array($getsInfoArray))
				{
					$getsInfoArray = array();
				}		
					
				foreach($refine_by_properties as $property_bag){  
		?>	
		<dl>
		    <dt><?php echo $property_bag['property']['gname'];?></dt>
		    <?php if($property_bag['property_values'] && is_array($property_bag['property_values'])){
		    	$currenty_index = 1;
		    	foreach($property_bag['property_values'] as $property_value){ 
		    ?>
		    <dd <?php echo $currenty_index > 5 ? 'style="display:none;" class="property_more"':'';?>><label><input name="property_value" type="checkbox" value="<?php echo $property_value['id'];?>" <?php echo in_array($property_value['id'], $getsInfoArray)?'checked="checked"':'';?> /><?php echo $property_value['name'];?> (<?php echo $property_value['num'];?>)</label></dd>
		    <?php 
		    		$currenty_index ++;}
		    	}
		    ?>
		 </dl>  
		<?php if(count($property_bag['property_values']) > 5){?>
			<div class="button"><a href="javascript:void(0);" class="btn_grey btn_propery_refine_by" data-text-more="<?php echo TEXT_MORE_PRO;?>" data-text-less="<?php echo TEXT_VIEW_LESS;?>" data-text-current="m"><?php echo TEXT_MORE_PRO;?></a></div><div class="clearfix"></div>
		<?php }?>
		
		<?php 
			}
		} ?>
	</div>
	</div>
	<a href="javascript:void(0);" class="btn_apply btn_propery_apply" style="display:block;"><?php echo TEXT_APPLY;?></a>
<?php 
/**********end 商品列表头部类别菜单*****************/
} ?>