<div class="warpper">
	<div class="trends_intro">
		<h3 class="test_jq"><?php echo strtoupper(PROMOTION_DISPLAY_AREA); ?></h3>
		<p><?php echo SALES_DESCRIPTION;?></p>
	</div>
	<div class="trends_main">
		<?php
		if(sizeof($display_area_data) > 0){
			foreach($display_area_data as $value){
				
				echo '<div class="category_block">
						  <div class="trends_head"><a href="' . $value['picture_href'] . '"><img src="' . $value['picture_url'] . '"></a>';
				
				echo '<div class="trends_cont">
						<h3>' . $value['area_name'] . '</h3>
						<p>'
						. $value['area_description'] .
						'</p>
					  </div>';
				echo '</div></div>';
			}
		}else{
			echo '<div>' . SALES_EMPTY . '</div>';
		}
		?>
		
		<div class="main_c_pagelist">
		 	<div class="propagelist spilttd"><?php echo zen_display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page','per_page')) , $_GET['page'] ? $_GET['page'] : 1  , $max_page_num , 0);?></div>
		</div>
	</div>
	<div class="trends_side">
		<h4><?php echo SUBSCRIBE_NEWSLETTER;?></h4>
		<ul class="subscribe">
			<li><ins></ins><?php echo NEW_PRODUCTS_ANNOUNCEMENTS;?></li>
			<li><ins></ins><?php echo SALE_ANNOUNCEMENTS;?></li>
			<li><ins></ins><?php echo WHAT_TRENDING;?></li>
		</ul>
		
		<h5><?php echo ENTRY_EMAIL_ADDRESS.':';?></h5>
		<div class="subscribe_email">
			<input type="text" class="text" value="<?php echo ENTRY_EMAIL_ADDRESS;?>" id="newsletter_bot_input" onblur="showTips(this,'<?php echo ENTRY_EMAIL_ADDRESS;?>')"  onfocus="clearTips(this,'<?php echo ENTRY_EMAIL_ADDRESS;?>')" >
            <input type="button" value="<?php echo SUBSCRIBE_INPUT;?>" class="subscribebtn btn" onclick="showSubscribe('<?php echo $_SESSION['language'];?>','<?php echo TEXT_ERROR_EMAIL_TIPS;?>','<?php echo ENTRY_NAME;?>','<?php echo ENTRY_LAST_NAME;?>','<?php echo ENTRY_EMAIL_ADDRESS;?>')">
		</div>
		<div class="pre_recording">
			<h4 class="line"><?php echo TRENDS_ARCHIVES; ?></h4>
			<ul class="list">
			<?php
				$i = 1;
				foreach ($display_area_info_array as $value){
					if($i <= 5){
						echo '<li class="show_date"><a href="' . $value['picture_href'] . '"><ins></ins>' . $value['area_name'] . ' </a></li>';
					}else{
						echo '<li class="hidden_date"><a href="' . $value['picture_href'] . '"><ins></ins>' . $value['area_name'] . ' </a></li>';
					}
					$i++;
				}
				
				if(sizeof($display_area_info_array) >= 5){
					echo '<li class="more"><span>' . TEXT_VIEW_MORE . '<ins></ins></span></li>	';
				}
			?>
			</ul>
		</div>
	</div>
	<div class="clearfix"></div>
</div>