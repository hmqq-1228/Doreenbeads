        <div class="projects">
			<div id="current_nav_hidethis_third" style="display:none;"><?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?></div>
            <h3><?php echo $third_name ?></h3>
            <p><?php echo $third_desc ?></p>
            <ul>
                <?php foreach ($third_list_array as $key => $value) { ?> 
                    <?php if( $key < '15'){ ?>
                    <li><a href="javascript:void(0);" aid="<?php echo $value['aid'] ?>" first_id="<?php echo $first_id ?>" second_id="<?php echo $second_id ?>" class="article_click"><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['title'], 20) ?></p> </a></li>
                    <?php }else{ ?> 
                    <li style="display:none" class="hideThisLi"><a href="javascript:void(0);" aid="<?php echo $value['aid'] ?>" first_id="<?php echo $first_id ?>" second_id="<?php echo $second_id ?>" class="article_click"><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['title'], 20) ?></p> </a></li>

                    <?php if(($key + 1) % 4 == '0'){ ?>
                    </ul><div class="clearfix"></div><ul>
                    <?php } ?>

                    <?php if(count($second_list_array) >= '17') { ?>
                    <?php if( $key == '14'){ ?>
                    <li><a href="javascript:void(0);" class="viewHere"><img src="/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']; ?>/images/view_all.jpg " /><p><?php echo TEXT_VIEW_ALL ?></p> </a></li>
                <?php }}}} ?>
            </ul>
            
        </div>
        <div class="clearfix"></div>