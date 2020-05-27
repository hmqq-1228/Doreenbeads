<!-- learning center index -->
    <!-- menu -->
	<div class="learn_wrap">
     <div class="sidebar">
     	<div class="menu">
        	<h3><?php echo HEADER_TITLE_LEARNING_CENTER ?></h3>
            <div class="menu_cont">
                <?php foreach ($lc_categories_array_result as $key => $value) { ?>                                    
                    <h4>
                        <a href="javascript:void(0);" class="clicktocat clicktocat_<?php echo $value['id'] ?>" style="word-wrap:break-word;" cate_id="<?php echo $value['id'] ?>"><?php echo getstrbylength($value['name'],40) ?></a>
                    </h4>
                    <ul  class="highLight"> 
                    <?php foreach ($value[$value['id']] as $key2 => $val2) { ?>               
                        <?php if (!empty($val2[$val2['id']])) { ?>
                           <li class="hover_li more">
                        <?php }else{  ?>                 
                        <li class="hover_li">
                        <?php } ?>
                            <a href="javascript:void(0);" class="second_click second_click_<?php echo $val2['id'] ?> " style="word-wrap:break-word;"  first_id="<?php echo $value['id'] ?>" second_id="<?php echo $val2['id'] ?>" ><?php echo getstrbylength( $val2['name'], 40) ?></a>
                            <?php if (!empty($val2[$val2['id']])) { ?>
                               <div class="threemore" style="display:none">
                                    <ul>
                                    <?php foreach ($val2[$val2['id']] as $key3 => $val3) { ?>
                                        <li><a href="javascript:void(0);" tid="<?php echo $val3['id'] ?>" first_id="<?php echo $value['id'] ?>" second_id="<?php echo $val2['id'] ?>" class="third_click second_click_<?php echo $val2['id'] ?> " style="word-wrap:break-word;"><?php echo zen_trunc_string($val3['name'], 20) ?></a></li>
                                    <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>                       
                        </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        </div>
        <div class="articles">
        	<h3><?php echo TEXT_RECENTLY_ARTICLES ?></h3>
            <?php foreach ($recently_article_array as $key => $value) { ?>
                <p>-<a href="javascript:void(0);"  aid="<?php echo $value['aid'] ?>" class="article_click"><?php echo getstrbylength($value['title'],20) ?></a></p>
            <?php } ?>
        </div>
    </div>

    <!-- index -->
    <div id="lc_index" class="main_wrap">
        
     	<h3><?php echo LC_INDEX_TITLE_EN ?></h3>
        
        <img src="<?php echo DIR_WS_IMAGES.LC_INDEX_IMG_EN ?>"  /><br/>
   
        <?php echo LC_INDEX_DESC_EN ?>
        
        <?php foreach ($lc_categories_array_list as $key => $value) { ?>
            <div class="projects"> 
                <h3><?php echo $value['name'] ?></h3>
                <?php echo $value['desc'] ?>               
                <ul>
                    <?php foreach ($lc_categories_array as $key1 => $val1) { ?>
                        <?php foreach ($val1 as $key2 => $val2) { ?> 
                            <?php if($val2['parent_id'] == $value['id']){ ?>
                            <li>
                                <a second_id="<?php echo $val2['id'] ?>" first_id="<?php echo $value['id'] ?>" style="cursor:pointer" class="second_click"><img width="180px" height="180px" src="<?php echo DIR_WS_IMAGES.$val2['images'] ?>" />
                                <p><?php echo $val2['name'] ?></p></a>
                            </li>
                            <?php if($key2 == '3'){ ?>
                            </ul><div class="clearfix"></div><ul>
                            <?php } ?>
                            <?php if(count($val1) >= '9') { ?>
                            <?php if( $key2 == '6'){ ?>
                            <li><a href="javascript:void(0);" class="clicktocat" data-viewall="1"  cate_id="<?php echo $value['id'] ?>" ><img src="/includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']; ?>/images/view_all.jpg" /><p><?php echo TEXT_VIEW_ALL ?></p> </a></li>
                        <?php break;}}}} ?>
                    <?php } ?>
               </ul>                
     	  </div>
        <?php } ?>        
    </div>

    
    <!-- first list -->
    <div id="first_list" class="main_wrap">
        
    </div>

    <!-- other list -->
    <div id="second_list" class="main_wrap">
        
    </div>

    <div id="third_list" class="main_wrap">
        
    </div>

    <!-- article details -->
    <div id="article_details" class="main_wrap">
        
    </div>
    <div class="clearfix"></div>
    </div>

<!-- learning center categories -->