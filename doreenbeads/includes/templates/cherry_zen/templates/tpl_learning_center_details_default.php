<!-- learning center details -->
    <div class="main_wrap"> 
             <!--制作步骤2开始 -->
        <div class="project2">
			<div id="current_nav_hidethis_detail" style="display:none;"><?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?></div>
            <h3><?php echo $article_list_array['title'] ?></h3>

            <?php if($article_list_array['video_position'] == '10') echo $article_list_array['video_code'].'<br/>' ?>

            <?php if(!empty($article_list_array['article_images'])){ ?> 
            <img src="<?php echo DIR_WS_IMAGES.$article_list_array['article_images'] ?>" /><br/>
            <?php } ?>

            <?php if($article_list_array['video_position'] == '20') echo $article_list_array['video_code'].'<br/>' ?>

            <div class="clearfix"></div>
        </div>
        <!-- article summary -->
        <?php echo $article_list_array['article_summary'].'<br/>' ?>
        <p class="fourlink1" style="line-height: 24px;">
            <span title="<?php echo TEXT_SHARE_TO_YOUR_GOOGLE;?>" class='st_googleplus'></span>
            <!--<span title="<?php echo TEXT_SHARE_TO_YOUR_FACEBOOK;?>" class='st_facebook'></span>-->
            <!--<span class="fb-like" data-layout="button" data-action="like" data-show-faces="false" data-share="false" style="top:6px;"></span>-->
            <span title="<?php echo TEXT_SHARE_TO_YOUR_TWITTER;?>" class='st_twitter'></span>
            <span title="<?php echo TEXT_SHARE_TO_YOUR_PINTEREST;?>" class='st_pinterest'></span>
            <span class="fb-like" data-href="https://www.facebook.com/doreenbeads" data-layout="button" data-action="like" data-show-faces="false" data-share="false" style="top:6px;"></span>
            <span class="fb-share-button" data-layout="button" style="top:6px;"></span>
            <style>#___ytsubscribe_0{position:relative;top:7px;}</style>
            <span class="g-ytsubscribe" data-channelid="UCRvI1TH9x5othhfAMts6jpQ" data-layout="default" data-count="hidden"></span>
            <script type="text/javascript">var switchTo5x=true;</script>
            <!-- <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script> -->
            <script type="text/javascript">//stLight.options({publisher: "8c9fa0f5-056b-4e6c-91ed-b8398b2cbe74"}); </script>
        </p>

        <?php if($article_list_array['video_position'] == '30') echo $article_list_array['video_code'].'<br/>' ?>

        <!-- article material list -->
        <?php echo $article_list_array['material_list'] ?><br/>

        <?php if($article_list_array['video_position'] == '40') echo $article_list_array['video_code'].'<br/>' ?>
               
        <!--Production steps -->
        <?php foreach ($article_steps_array as $key => $val) { ?>        
        <div class="project2">
            <div class="course_wrap_img">
                <?php if (!empty($val['article_steps_url'])) { ?>
                <a href="<?php echo $val['article_steps_url'] ?>"><img src="<?php echo DIR_WS_IMAGES.$val['article_steps_images'] ?>" /></a><br/>
                <?php }elseif(!empty($val['article_steps_images'])){ ?>
                <img src="<?php echo DIR_WS_IMAGES.$val['article_steps_images'] ?>" /><br/>
                <?php } ?>
            </div>
            <div class="clearfix"></div>    
            <?php echo $val['article_steps_summary'] ?><br/>
        </div>
        <?php } ?>

        <?php if($article_list_array['video_position'] == '50') echo $article_list_array['video_code'].'<br/>' ?>

        
        <div class="clearfix"></div>
        <?php if (!empty($product_res1)) { ?>       
        <div class="components product_list">
            <h3 class="title"><?php echo TEXT_PURCHASE_IDEA_KIT_COMPONENTS ?></h3>
            <a style="cursor:pointer" class="btn_violet partsadd" type="parts" aid="<?php echo $article_list_array['aid'] ?>"><?php echo TEXT_ADD_ALL_TO_CART ?></a>
            <div class="clearfix"></div>
            <?php
                $product_res = $product_res1;
                $products_new_split->number_of_rows = count($product_res1);
                include (DIR_WS_MODULES . zen_get_module_directory ( 'product_list_by_property' ));
                $smarty->assign('tabular',$list_box_contents_property);
                isset($_GET['page']) ? $sPage = $_GET['page'] : $sPage = 1;
                $smartyId = $_GET['cPath'].'__'.$sPage;
                $smarty->display(DIR_WS_INCLUDES.'templates/products_list.html',$smartyId);
            ?>
            <div class="clearfix"></div>
        </div>
        <?php } ?>

        <?php if($article_list_array['video_position'] == '60') echo $article_list_array['video_code'].'<br/>' ?>

        <?php if (!empty($product_res2)) { ?>
        <div class="components product_list">
         <h3 class="title"><?php echo TEXT_PURCHASE_TOOLS_SUPPLIES ?></h3>
         <a style="cursor:pointer" class="btn_violet partsadd" type="tools" aid="<?php echo $article_list_array['aid'] ?>"><?php echo TEXT_ADD_ALL_TO_CART ?></a>
         <div class="clearfix"></div>
         <?php
            $product_res = $product_res2;
            $list_box_contents_property = array();
            $products_new_split->number_of_rows = count($product_res2);
            include (DIR_WS_MODULES . zen_get_module_directory ( 'product_list_by_property' ));
            $smarty->assign('tabular',$list_box_contents_property);
            isset($_GET['page']) ? $sPage = $_GET['page'] : $sPage = 1;
            $smartyId = $_GET['cPath'].'__'.$sPage;
            $smarty->display(DIR_WS_INCLUDES.'templates/products_list.html',$smartyId);
         ?>
         <div class="clearfix"></div>
        </div>
        <?php } ?>
        <?php if($article_list_array['video_position'] == '70') echo $article_list_array['video_code'].'<br/>' ?>
       </div>
     <div class="clearfix"></div>
     <script>
        $j(function(){
            $j("img.lazy").lazyload({
                effect:"show",
                threshold : 400
            });
        });
     </script>
