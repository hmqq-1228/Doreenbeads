

<div class="wrap sourcing">
    <!-- 头部开始 -->
    <div id="header">
        <?php echo '<input type="hidden" id="c_lan" value="'.$_SESSION['language'].'">';?>
        <div id="logo_new">
            <div class="logo" style="float:left;">
                <a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>"><?php echo zen_image ( DIR_WS_LANGUAGE_IMAGES . 'logo1.jpg' );?></a>
                <p class="font14"><a href="<?php echo HTTP_SERVER;?>/page.html?id=159"><?php echo TEXT_LOGO_TITLE;?></a></p>
                <!--WEBSITE_SUCCESS-->
            </div>
        </div>
        <div class="clearfix"></div>
        <p style="font-size:0.55em"></p>
    </div>
    <!-- 头部结束 -->
    <!--     <div class="sourcing_header <?php echo $lang_code;?>">
    <h2><?php echo TEXT_OEM_AND_SOURCING_PRO;?></h2>
    <ul>
        <li class="simple"><i></i><?php echo TEXT_POST_BUY_REQUEST_IN_ONE_MINUTE;?></li>
        <li class="efficient"><i></i><?php echo TEXT_GET_QUOTATION_WITHIN_FEW_WORKING_DAYS;?></li>
        <li class="deal"><i></i><?php echo TEXT_SAMPLES_AND_DEALS;?></li>
        <div class="clearfix"></div>
    </ul> 
</div> -->

    <div class="source_head">
        <div class="en head_banner">
            <p><?php echo TEXT_OEM_HEARDER_BANNER; ?></p>
        </div>
        <ul>
            <li class="selected jq_product_souring"><a href="javascript:void(0);"><img src="includes/templates/cherry_zen/images/search.png" /><p><?php echo TEXT_PRO_SOURCING_SERVICE; ?></p></a></li>
            <li class="jq_custom_made"><a href="javascript:void(0);"><img src="includes/templates/cherry_zen/images/customization.png" /><p><?php echo TEXT_CUSTOM_MADE_SERVICE; ?></p></a></li>
            <li class="nomargin jq_repack_process"><a href="javascript:void(0);"><img src="includes/templates/cherry_zen/images/packed.png" /><p><?php echo TEXT_REPACKING_PROCESSING_SERVICE; ?></p></a></li>
        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="detail_info product jq_show_product">
        <p><?php echo TEXT_PRODUCT_DESC; ?></p>
    </div>

    <div class="detail_info custom jq_show_custom" style="display:none;">
        <p><?php echo TEXT_CUSTOM_DESC; ?></p>
        <ol>
            <li><?php echo TEXT_CUSTOM_DESC_LI1; ?></li>
            <li><?php echo TEXT_CUSTOM_DESC_LI2; ?></li>
        </ol>
    </div>
    <div class="detail_info packed jq_show_packed" style="display:none;">
        <p><?php echo TEXT_PACKED_DESC; ?></p>

    </div>

    <div style="background-color: red;margin-left: 25px;<?php if ($messageStack->size('oem_sourcing') > 0) echo 'padding: 10px;';?>">
        <?php if ($messageStack->size('oem_sourcing') > 0) echo $messageStack->output('oem_sourcing'); ?>
    </div>

    <div class="sourcing_detail">
        <form action='<?php echo zen_href_link(FILENAME_OEM_SOURCING)?>' method="POST" enctype="multipart/form-data" >
            <input type="hidden" name="action" value="oem_sourcing_process">
            <input type="hidden" name="oem_type" value="10" />
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th><span class="fred">*</span><p id="oem_product_title" style="display:inline-block;"><?php echo TEXT_PRODUCT_NAME_OR_LINK;?></p></th>
                    <td>
                        <input id="pid" name="pid" type="hidden" value="<?php echo $products_id;?>">
                        <input style="display:none;" id="oem_title_link" name="oem_title_link" class="input_text_wrap inputw715" type="text" value="" placeholder="<?php echo TEXT_WHAT_DO_YOU_WANT_TO_BUY;?>" maxlength=500 />
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr class="pro_details" style="display:none;">
                                <td class="pro_img"><img width='80' height='80' src="<?php echo HTTP_IMG_SERVER.'bmz_cache/images/'.get_img_size($products_image, 80, 80);?>" /></td>
                                <td class="pro_name"><?php echo $products_name . '<br/>' . $products_model ;?></td>
                                <td class="pro_change"><span class="fblue_mid"><ins></ins><span id="oem_change"><?php echo TEXT_CHANGE;?></span></span></td>
                                <input type="hidden" id="products_link" name="products_link" value="<?php echo $products_link;?>">
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr id="error1" style="color:red;"><th></th><td></td></tr>
                <tr>
                    <th><span class="fred">*</span><?php echo TEXT_DETAILS;?></th>
                    <td>

                        <div class="pro_info">
                            <iframe onload="show_iframe();" id="iframe_a" name="iframe_a" frameborder="0" style="width:700px;height:100%;border:none;" scrolling="no"></iframe>
                            <a href="/includes/templates/cherry_zen/html/<?php echo $lang_code;?>/souring_pro_info.html" target="iframe_a" class="info_temple" onclick="this.className='show_iframe'">
                                <?php echo TEXT_OEM_DETAIL_CONTENT;?>
                            </a>
                            <p class="info_warning"><?php echo TEXT_OEM_INFO_WARING;?></p>
                        </div>
                    </td>
                    <textarea id="hidden_textarea" name="textarea" value="" style="display: none;"></textarea>
                </tr>
                <tr id="error2" style="color:red;"><th></th><td></td></tr>
                <tr>
                    <th><span class="fred"></span><?php echo TEXT_ATTACHMENT;?></th>
                    <td>
                        <!-- <div class="pro_upload"><span>Add Attachment</span></div> -->
                        <input id="oem_loading_oem" type="hidden" name="oem_loading_oem" value="">
                        <div id="oem_file_loading_oem" style="float:left;">
                            <!-- <embed type="application/x-shockwave-flash" allowscriptaccess="always" quality="high" flashvars="postUrl=<?php echo $server_host;?>/image_upload.php?Action=oem_file&amp;maxSize=2097152&amp;minSize=0&amp;fileType=*.gif;*.png;*.jpeg;*.jpg;*.doc;*.docx;*.bmp;&amp;alertFun=ShowMessage&amp;upInfo=showUploadingFile&amp;pullBack=showAttachmentFile&amp;testAlert=flash_test&amp;UploadingTipId=loading_oem&amp;isAllowCNFileName=true&amp;postData=username=xm;userpassword=123;upath=/tmp" wmode="transparent" palette="transparent|transparent" src="<?php echo $server_host;?>/flash/SimpleSwfupload.swf" name="SimpleSwfupload" class="divComposeAttachFlash_Object" style="background:url('includes/templates/cherry_zen/css/<?php echo $lang_code;?>/images/btnbrowse.gif') no-repeat scroll 0 0 transparent;height: 27px;width:240px;position:relative;"> -->
                            <button type="button" id="browse" style="width:200px;height:25px;border:0;background:#969696;color:#fff;"><?php echo TEXT_ADD_ATTACHMENT; ?></button>
                        </div>
                        <ins class="upload_notice">
                            <div class="pop_note_tip">
                                <i class="top"></i><em class="top"></em>
                                <?php echo TEXT_UPLOAD_NOTICE;?>
                            </div>
                        </ins>
                        <div class="clearfix"></div>
                        <p style="display:none" id="loading_oem">
                            <input type="hidden" id="oem_count" value="0"/>
                        </p>
                        <p class="edit_warning fred"></p>
                    </td>
                </tr>
                <tr id="email_tr">
                    <input id="customer_id" name="customer_id" type="hidden" value="<?php echo $_SESSION['customer_id']?>">
                    <th><span class="fred">*</span><?php echo TEXT_EMAIL;?></th>
                    <td><input id="email" name="email" value="<?php echo $email;?>" class="input_text_wrap inputw290" type="text" style="color:#333"/></td>
                </tr>
                <tr id="error3" style="color:red;"><th></th><td></td></tr>
                <tr id="name_tr">
                    <th><span class="fred">*</span><?php echo TEXT_YOUR_NAME;?></th>
                    <td><input id="name" name="name" value="<?php echo $name;?>" class="input_text_wrap inputw290" type="text" style="color:#333"/></td>
                </tr>
                <tr id="error4" style="color:red;"><th></th><td></td></tr>
                <?php  if ($_SESSION['auto_auth_code_display']['oem_sourcing'] >=3 || !isset($_SESSION['customer_id']) || $_SESSION['customer_id'] == 0){?>
                    <tr id="name_tr">
                        <th><span class="fred">*</span><?php echo TEXT_VERIFY_NUMBER;?></th>
                        <td><?php echo zen_draw_input_field('check_code', '', 'size="25" id="check_code_input" class="input_text_wrap" style="WIDTH: 60PX;height: 25px;margin-right:15px;"'); ?><img  id="check_code" src="./check_code.php" style="height: 26px;"  onClick="this.src='./check_code.php?'+Math.random();" /></td>
                    </tr>
                    <tr style="color:red;"><th></th><td id="login_checkcode_error" ></td></tr>
                <?php  }?>

                <tr>
                    <th></th>
                    <td><button class="btn_orange btn_p30" type="submit"><?php echo TEXT_GET_QUOTATION;?></button></td>
                </tr>
            </table>
        </form>
        <div class="detail_requirement jq_show_product">
            <h5><?php echo TEXT_PRODUCT_DESC_QUESTION; ?></h5>
            <p><?php echo TEXT_PRODUCT_DESC_ANSWER; ?></p>
        </div>
        <div class="detail_requirement jq_show_custom" style="display:none;">
            <h5><?php echo TEXT_CUSTOM_DESC_QUESTION; ?></h5>
            <p><?php echo TEXT_CUSTOM_DESC_ANSWER; ?></p>
        </div>
        <div class="sourcing_example jq_show_product">
            <span class="jq_show_product"><?php echo TEXT_PRODUCT_EXAMPLES; ?></span>
            <!-- <span class="jq_show_custom" style="display:none;"><?php echo TEXT_CUSTOM_EXAMPLES; ?></span> -->
            <ul>
                <?php foreach ($oem_sourcing_products_array as $key => $value) {
                    $product_info = get_products_info_memcache($value['products_id']);
                    ?>
                    <li><a href="<?php echo zen_href_link('product_info', 'products_id=' . $product_info['products_id']) ?>"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="<?php echo HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($product_info['products_image'], 130, 130); ?>" /></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="service_detail jq_show_packed" style="display:none;">
        <div class="service_info">
            <h3><span><?php echo TEXT_REPACKING_SERVICE; ?></span></h3>
            <img src="includes/templates/cherry_zen/images/repack_service.jpg" />
        </div>
        <div class="service_info">
            <h3><span><?php echo TEXT_PROCESSING_SERVICE; ?></span></h3>
            <img src="includes/templates/cherry_zen/images/process_service.jpg" />
        </div>
        <div class="service_info">
            <h3><span><?php echo TEXT_HOW_TO_START_SERVICE; ?></span></h3>
            <p><?php echo TEXT_HOW_TO_START_SERVICE_ANSWER; ?></p>
        </div>
        <div class="service_info testimonial">
            <h3><span><?php echo TEXT_OEM_TESTIMONIAL_SERVICE; ?></span></h3>
            <div class="testimo_txt">
                <table cellpadding=0 cellspacing=0 border=0 id="show_testimonial_table">
                    <?php for ($i = 0; $i < sizeof($testimonial_array); $i++){  ?>
                        <tr <?php  echo ($i==0)?'class="first_tr"':'';?> id="testimonial_id_<?php echo  $testimonial_array[$i]['id'];?>">
                            <td class="avatar" width=80><?php echo zen_image(DIR_WS_USER_AVATAR.$testimonial_array[$i]['avatar'],'','50','50');?></td>
                            <td>
                                <div>
                                    <?php
                                    $customer_info = zen_get_customers_info($testimonial_array[$i]['customer_id']);
                                    ?>
                                    <b><?php echo $testimonial_array[$i]['customer_name'];?></b>&nbsp;&nbsp;<?php echo $customer_info['default_country']; ?>&nbsp;&nbsp;<?php echo $testimonial_array[$i]['date_added']; ?></div>
                                <div style="margin-top:5px;padding:5px 5px 0px 5px;font-family:verdana,fantasy,tahoma,arial;color:#000">
                                    <?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'left_quote.png');?>
                                    &nbsp;
                                    <?php echo $testimonial_array[$i]['content']; ?>
                                    &nbsp;
                                    <?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'right_quote.png');?>
                                </div>
                            </td>
                        </tr>
                        <?php
                        if($testimonial_array[$i]['reply']!=''){
                            ?>
                            <tr class='reply'><td colspan=2><div><table cellpadding=0 cellspacing=0 border=0 width='100%'><tr><td width=80 align='center'><b style="color:gray"><?php echo TEXT_REPLY;?></b></td><td style="color:gray"><?php echo $testimonial_array[$i]['reply'];?></td></tr></table></div></td></tr>
                            <?php
                        }
                        ?>
                        <?php
                    } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- 引用预加载JS文件 -->
<script src="/includes/templates/cherry_zen/jscript/lazyload.js"></script>