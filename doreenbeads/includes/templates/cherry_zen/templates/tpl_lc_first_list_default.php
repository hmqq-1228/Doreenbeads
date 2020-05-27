        <script type="text/javascript">
            var page =1;
            var height = $j('.imageGrowUp').next('div').height();
            var num = $j('.imageGrowUp').next('div').children().children('li').length;
            var len = 80;

            $j(document).on('click', '.imageGrowUp', function(){
                obj = $j(this);
                if (page == num) {
                    obj.next('div').children('ul').animate({top:0},'slow');
                    page = 1;
                }else{
                    obj.next('div').children('ul').animate({top:'-=' + len},'slow');
                    page++;
                };
            });
            $j(document).on('click', '.imageGrowDown', function(){
                obj = $j(this);
                if (page == 1) {
                    obj.prev('div').children('ul').animate({top:'-=' + len *(num-1)},'slow');
                    page = num;
                }else{
                    obj.prev('div').children('ul').animate({top:'+=' + len},'slow');
                    page--;
                };
            });
        </script>
		<div id="current_nav_hidethis" style="display:none;"><?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?></div>
        <h3><?php echo $cate_name ?></h3>
        <?php if(!empty($imgs_arr['0'])){  ?>
        <div class="banner">
             <ul class="lt_banner">
                <li class="getImage"><a href="javascript:void(0);"><img src="<?php echo DIR_WS_IMAGES.$imgs_arr['0'] ?>" /></a></li>
             </ul>
             <div class="rt_banner">
                <a class="arrowup imageGrowUp"></a>
                <div style="height:240px;overflow:hidden;">
                <ul style="position:relative">
                    <?php foreach ($imgs_arr as $key => $value) { ?>                                      
                    <li class="imageChange"><a href="javascript:void(0);"><img width="80px;" src="<?php echo DIR_WS_IMAGES.$value ?>" /></a></li>
                    <?php } ?>     
                </ul>
                </div>
                <a style="cursor:pointer" class="arrowdown imageGrowDown"></a>
                
             </div>
             
             <div class="clearfix"></div>
        </div>
        <?php } ?>
        <p><?php echo $cate_desc ?></p>
        <?php foreach ($cate_id_sql_result_array as $key => $value) { ?>
        <div class="projects"> 
            <h3><?php echo $value['name'] ?></h3>
            <ul>
            <?php foreach($double_sql_result_array as $sid => $sarr){ ?> 
                <?php if ($sid == $value['id']) { ?>
                    <?php foreach ($sarr as $key1 => $tarr) { ?>
                        <?php if (count($sarr) < 9) { ?>
                            <li><a style="cursor:pointer" cid="<?php echo $sid ?>" tid="<?php echo $tarr['id'] ?>" first_id="<?php echo $cate_id ?>" second_id="<?php echo $sid ?>"  class="third_click second_click_<?php echo $tarr['id'] ?>" ><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$tarr['images'] ?>" /><p><?php echo getstrbylength($tarr['name'], 20) ?></p> </a></li>
                        <?php }else{ ?>
                        <li><a style="cursor:pointer" cid="<?php echo $sid ?>" tid="<?php echo $tarr['id'] ?>" first_id="<?php echo $cate_id ?>" second_id="<?php echo $sid ?>"  class="third_click second_click_<?php echo $tarr['id'] ?>" ><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$tarr['images'] ?>" /><p><?php echo getstrbylength($tarr['name'], 20) ?></p> </a></li>
                        <?php if(($key1 +1) % 4 == '0'){ ?>
                        </ul><div class="clearfix"></div><ul>
                        <?php } ?>
                        <?php if( $key1 == '6'){ ?>
                        <li><a href="javascript:void(0);" second_id="<?php echo $sid ?>" first_id="<?php echo $cate_id ?>"  class="second_click second_click_<?php echo $tarr['pid'] ?>" data-viewall="1" ><img src="/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']; ?>/images/view_all.jpg " /><p><?php echo TEXT_VIEW_ALL ?></p> </a></li>
                        <?php break;} ?>
                    <?php }} ?>
                <?php } ?>
            <?php } ?>
            </ul>
            <ul>                
                <?php foreach ($article_array as $key3 => $value3) { ?>
                <?php if ($key3 == $value['id']) { ?>
                    <?php foreach ($value3 as $key4 => $value4) { ?>
                    
                    <li><a style="cursor:pointer" cid="<?php echo $value['id'] ?>" aid="<?php echo $value4['aid'] ?>" first_id="<?php echo $cate_id ?>" second_id="<?php echo $value['id'] ?>" class="article_click " ><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$value4['images'] ?>" /><p><?php echo getstrbylength($value4['title'], 20) ?></p> </a></li>
                    <?php if(($key4 + 1) % 4 == '0'){ ?>
                    </ul><div class="clearfix"></div><ul>
                    <?php }  ?>
                    <?php if(sizeof($value3) >= 9) { ?>
                    <?php if( $key4 == '6'){ ?>
                    <li><a href="javascript:void(0);" second_id="<?php echo $value['id'] ?>" first_id="<?php echo $cate_id ?>" class="second_click second_click_<?php echo $value['id'] ?>" data-viewall="1" ><img src="/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']; ?>/images/view_all.jpg " /><p><?php echo TEXT_VIEW_ALL ?></p> </a></li>
                    <?php break; } ?>
                <?php }}} ?>
                <?php } ?>
           </ul>
           
            
           <div class="clearfix"></div>
    
        </div>
        <?php } ?>
        <div class="clearfix"></div> 