        <div id="current_nav_hidethis" style="display:none;"><?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?></div>
        <h3><?php echo $cate_name ?></h3>
        <p><?php echo $cate_desc ?></p>
        <div class="projects"> 
         <ul>
            <?php foreach ($cate_id_sql_result_array as $key => $value) { ?>
                <?php if($view){ ?> 
                    <li><a href="javascript:void(0);"  second_id="<?php echo $value['id'] ?>" first_id="<?php echo $cate_id ?>" class="second_click second_click_<?php echo $value['id'] ?>" ><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['name'], 20) ?></p> </a></li>
                    <?php if(($key + 1) % 4  == '0'){ ?>
                    </ul><div class="clearfix"></div><ul>
                    <?php } ?>
                <?php }elseif(count($cate_id_sql_result_array) >= '9'){  ?>
                    <?php if( $key < '7'){ ?>
                    <li><a href="javascript:void(0);" second_id="<?php echo $value['id'] ?>" first_id="<?php echo $cate_id ?>" class="second_click second_click_<?php echo $value['id'] ?>" ><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['name'], 20) ?></p> </a></li>
                    <?php }else{ ?> 
                    <li style="display:none" class="hideThisLi" ><a href="javascript:void(0);" second_id="<?php echo $value['id'] ?>" class="second_click" ><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['name'], 20) ?></p> </a></li>
                    <?php } ?>

                    <?php if(($key + 1) % 4  == '0'){ ?>
                    </ul><div class="clearfix"></div><ul>
                    <?php } ?>
                    
                    <?php if( $key == '6'){ ?>
                    <li><a href="javascript:void(0);" class="viewHere" ><img src="/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']; ?>/images/view_all.jpg" /><p><?php echo TEXT_VIEW_ALL ?></p> </a></li>
                <?php }}else{ ?>
                    <li><a href="javascript:void(0);" second_id="<?php echo $value['id'] ?>" first_id="<?php echo $cate_id ?>" class="second_click second_click_<?php echo $value['id'] ?>" ><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['name'], 20) ?></p> </a></li>
                    <?php if(($key + 1) % 4  == '0'){ ?>
                    </ul><div class="clearfix"></div><ul>
                    <?php } ?>
                <?php  }} ?>
        </ul>
        </div>
       
        <div class="clearfix"></div> 