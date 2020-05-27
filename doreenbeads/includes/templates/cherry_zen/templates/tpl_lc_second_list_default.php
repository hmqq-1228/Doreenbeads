        <div class="projects"> 
			<div id="current_nav_hidethis_second" style="display:none;"><?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?></div>
            <h3><?php echo $second_name ?></h3>
            <p><?php echo $second_desc ?></p>
            <ul>
                <?php if (!empty($second_cate_array)) { ?>
                    <?php foreach ($second_cate_array as $key => $value) { ?>
                    <?php if($view){ ?> 
                        <li><a href="javascript:void(0);" tid="<?php echo $value['id'] ?>" first_id="<?php echo $first_id ?>" second_id="<?php echo $second_id ?>" class="third_click second_click_<?php echo $second_id ?>"><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['name'], 20) ?></p> </a></li>
                        <?php if(($key + 1) % 4 == '0'){ ?>
                        </ul><div class="clearfix"></div><ul>
                        <?php } ?>
                    <?php }elseif(count($second_cate_array) >= '17') { ?>
                        <?php if( $key < '15'){ ?>
                        <li><a href="javascript:void(0);" tid="<?php echo $value['id'] ?>" first_id="<?php echo $first_id ?>" second_id="<?php echo $second_id ?>" class="third_click second_click_<?php echo $second_id ?>"><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['name'], 20) ?></p> </a></li>
                        <?php }else{ ?> 
                        <li style="display:none" class="hideThisLi"><a href="javascript:void(0);" tid="<?php echo $value['id'] ?>" first_id="<?php echo $first_id ?>" second_id="<?php echo $second_id ?>" class="third_click second_click_<?php echo $second_id ?>"><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['name'], 20) ?></p> </a></li>
                        <?php } ?>

                        <?php if(($key + 1) % 4 == '0'){ ?>
                        </ul><div class="clearfix"></div><ul>
                        <?php } ?>

                        
                        <?php if( $key == '14'){ ?>
                        <li><a href="javascript:void(0);" class="viewHere" ><img src="/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']; ?>/images/view_all.jpg" /><p><?php echo TEXT_VIEW_ALL ?></p> </a></li>
                <?php }}else{ ?>
                    <li><a href="javascript:void(0);" tid="<?php echo $value['id'] ?>" first_id="<?php echo $first_id ?>" second_id="<?php echo $second_id ?>" class="third_click second_click_<?php echo $second_id ?>"><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['name'], 20) ?></p> </a></li>

                    <?php if(($key + 1) % 4 == '0'){ ?>
                        </ul><div class="clearfix"></div><ul>
                        <?php } ?>
                <?php }}?>
                <?php }else{ foreach ($second_list_array as $key => $value) { ?>
                    <?php if($view){ ?> 
                        <li><a href="javascript:void(0);" aid="<?php echo $value['aid'] ?>" first_id="<?php echo $first_id ?>" second_id="<?php echo $second_id ?>" class="article_click"><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['title'], 20) ?></p> </a></li>
                        <?php if(($key + 1) % 4 == '0'){ ?>
                        </ul><div class="clearfix"></div><ul>
                        <?php } ?>
                    <?php }elseif(count($second_list_array) >= '17') { ?>
                        <?php if( $key < '15'){ ?>
                        <li><a href="javascript:void(0);" aid="<?php echo $value['aid'] ?>" first_id="<?php echo $first_id ?>" second_id="<?php echo $second_id ?>" class="article_click"><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['title'], 20) ?></p> </a></li>
                        <?php }else{ ?> 
                        <li style="display:none" class="hideThisLi"><a href="javascript:void(0);" aid="<?php echo $value['aid'] ?>" first_id="<?php echo $first_id ?>" second_id="<?php echo $second_id ?>" class="article_click"><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['title'], 20) ?></p> </a></li>
                        <?php } ?>

                        <?php if(($key + 1) % 4 == '0'){ ?>
                        </ul><div class="clearfix"></div><ul>
                        <?php } ?>

                       
                        <?php if( $key == '14'){ ?>
                        <li><a href="javascript:void(0);" class="viewHere"><img src="/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']; ?>/images/view_all.jpg " /><p><?php echo TEXT_VIEW_ALL ?></p> </a></li>
                <?php }}else{ ?>
                        <li><a href="javascript:void(0);" aid="<?php echo $value['aid'] ?>" first_id="<?php echo $first_id ?>" second_id="<?php echo $second_id ?>" class="article_click"><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value['images'] ?>" /><p><?php echo getstrbylength($value['title'], 20) ?></p> </a></li>

                        <?php if(($key + 1) % 4 == '0'){ ?>
                        </ul><div class="clearfix"></div><ul>
                        <?php } ?>
                <?php }}} ?>
            </ul>
            
        </div>
        <div class="clearfix"></div>