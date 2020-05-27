<style>
    #contentMainWrapper .outer {padding:0px;}
    a{
        color:#0088cc;
        text-decoration:none;
    }
    a:hover{
        text-decoration:underline;
    }
    a.more_arrow{
        background:#fff url(images/icon-marrow.gif) top right no-repeat;
        padding-right:10px;
        position:relative;
        left:0px;
    }
    .f_green{
        color:#4aaf00;
        font-weight:bold;
        font-size:14px;
    }
    .f_org{
        color:#f60;
        font-weight:bold;
        font-size:14px;
    }
    .f_red{
        color:#cb0000;
        font-weight:bold;
    }
    #help_wap{
        width: 100%;
        overflow:hidden;
        margin:0 auto;
    }
    FIELDSET {
        padding: 0.5em;
        margin: 0.5em 0em;
        border: 1px solid #cccccc;
    }

    /****************
    **********帮助中心左侧样式
    ***********************************************/
    .help_left{
        width:210px;
        float:left;
    }
    .menu_aboutus{border:1px solid #cfcfcf;border-bottom:0;}
    .menu_aboutus h3{background:#e7e6e6;color:#010101;font-size:14px;text-align:center;line-height:32px;border-bottom:1px solid #cfcfcf;}
    .menu_aboutus ul li{border-top:1px solid #fff;background:#f7f7f7;line-height:30px;border-bottom:1px solid #cfcfcf;}
    .menu_aboutus ul li a{padding-left:25px;display:block;color:#141414;font-size:14px;}
    .menu_aboutus ul li.current a{background:#ffffff;color:#9133b0;}
    .menu_aboutus ul li a:hover{background:#ffffff;color:#9133b0;text-decoration:none}

    /****************
    **********帮助中心右侧样式
    ***********************************************/
    .help_right{
        width:780px;
        padding-left:6px;
        float:right;
        overflow:hidden;
    }
    .help_right .top_nav{
        height:32px;
        line-height:32px;
        color:#bbb;
        font-size:13px;
    }
    .help_right .top_nav a{
        color:#0481db;
    }
    .help_right .top_nav span{
        padding:0 8px;
    }
    .help_right h2{
        font-family:Tahoma, Geneva, sans-serif;
        font-size:23px;
        display:block;
        height:60px;
        border-top:#ccc 1px solid;
        background:#fff url(images/topbg.jpg) top center no-repeat;
        font-weight:normal;
        line-height:50px;
    }
    .help_right h4{
        font-size:12px;
        font-weight:bold;
        display:block;
        padding:18px 0 5px 0;
    }
    .help_right h4 img{
        margin:10px 0 7px;
    }
    .help_right p{
        padding:0 15px 16px 0;
    }
    .help_right .greybg{
        background:#fff url(images/midbg.jpg) top center no-repeat;
        margin-top:35px;
    }
    #help_wap .help_right .greybg td{
        padding-bottom:10px;
        padding-left:20px;
        vertical-align:top;
    }
    .help_right .greybg td.line{
        background:url(images/About-us-jg.jpg) top left no-repeat;
        padding-left:20px;
    }
    .help_right .greybg td p{
        padding:0;
    }
    .help_right .greybg td p.pright{
        padding:0 40px 0 0;
    }
    .help_right h3{
        font-size:16px;
        font-weight:bold;
        padding:10px 0 10px;
        display:block;
        color:#333;
    }
    .help_right h5{
        font-size:14px;
        color:#0153ae;
        font-weight:bold;
        padding:20px 0 10px;
        display:block;
    }
    .help_right .greybg ul.oteam{
        padding:15px 0;
    }
    .help_right .greybg ul.oteam li{
        padding-bottom:10px;
    }
    .help_right .greybg ul.oteam li strong{
        font-size:14px;
    }
    .help_right .faq_list span.arrow,.help_right .faq_list span.arrow2{
        width:12px;
        height:12px;
        overflow:hidden;
        display:inline-table;
        cursor:pointer;
        margin-left:7px;
    }
    .help_right .faq_list span.arrow{
        background:url(images/icon_arrowupdown.gif) no-repeat;
    }
    .help_right .faq_list span.arrow2{
        background:url(images/icon_arrowupdown.gif) bottom no-repeat;
    }
    .help_right .faq_list{
        padding-top:15px;
    }
    .help_right .faq_list dt{
        line-height:24px;
        display:block;
        width:100%;
        font-size:14px;
        padding-bottom:7px;
    }
    .help_right .faq_list dd{
        padding:0 10px 10px;
        line-height:22px;
        color:#777;
    }
    .help_right .qc_photo{
        border: 1px solid #D9D9D9;
        padding: 10px 7px 6px;
        text-align:center;
        font-weight:bold;
    }
    .help_right .qc_photo img{
        margin-bottom:5px;
    }
    .help_right .yinhao{
        float: left;
        width: 20px;
    }
    .help_right .qc_lettertext{
        background: url(images/yinbottom.jpg) right bottom no-repeat;
        line-height: 19px;
        color: #333;
        font-size: 13px;
        padding:0 0 0 10px;
        text-align: justify;
        float:left;
        width:540px;
    }
    .help_right .qc_photoimg img{
        border:#d9d9d9 1px solid;
        padding:7px;
    }
    .contact_us_div{
        font-size:12px;
        font-family:Arial, Helvetica, sans-serif;
    }
    .contact_us_div h4 img{
        width:32px;
        height:32px;
        border:0px solid #000;
        margin-right:4px;
    }
    .contact_us_div h4{
        padding:0px;
        margin-top:30px;
    }
    .contact_us_div hr{
        padding:0px;
        margin:12px 0px 12px 0px;
        color:#C0C0C0
    }
    .header_green_words {
        color:#DF57D5;
        font-size: 20px;
        font-weight: bold;
    }
    #check_code{
        top: -2px;
        left: 15px;
    }
    .quickbtnbig_yellow{
        width:110px;
    }
    .quickbtnbig_yellow span {
        background: url(/includes/templates/cherry_zen/css/en/images/btn_bgyellows2.png) right -504px no-repeat;
        height: 30px;
        line-height: 30px;
        padding-right: 30px;
        display: block;
        cursor: pointer;
    }
    .quickbtnbig_yellow span strong {
        background: url(/includes/templates/cherry_zen/css/en/images/btn_bgyellows2.png) left -470px no-repeat;
        font-size: 14px;
        height: 30px;
        color: #623500;
        line-height: 30px;
        width: 90px;
        min-width: 90px;
        padding: 0 0 0 8px;
        text-shadow: 1px 1px 0 #FFF;
        white-space: nowrap;
        display: block;
    }
    #clock{
        font: bold 24pt sans;
        padding:10px;
    }
    .alert{
        display: inline-block;
        font-size:15px;
        padding: 5px;
    }
</style>
<script>
    Date.prototype.Format = function (fmt) { //author: meizz
        var o = {
            "M+": this.getMonth() + 1, //月份
            "d+": this.getDate(), //日
            "H+": this.getHours(), //小时
            "m+": this.getMinutes(), //分
            "s+": this.getSeconds(), //秒
            "q+": Math.floor((this.getMonth() + 3) / 3), //季度
            "S": this.getMilliseconds() //毫秒
        };
        if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }
    function displayTime(){
        var elt = document.getElementById("clock");
        var now = new Date();
        elt.innerHTML = now.Format("HH:mm:ss");;
        setTimeout(displayTime,1000) /*每过一秒执行一次displayTime*/
    }
    $j(document).ready(displayTime);
</script>
<div id="help_wap">
    <div class="help_left">
        <div class="menu_aboutus">
            <h3 style="padding-left: 25px;text-align:left;"><?php echo TEXT_ABOUT_US;?></h3><!-- 根据需求要求，此单位需要居左显示 -->
            <ul>
                <!-- <li<?php echo (($_GET['id'] == 162 || !isset($_GET['id'])) ? ' class="current"' : '');?>><a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG .  'index.php?main_page=who_we_are&id=162';?>"><?php echo TEXT_ABOUT_US;?></a></li> -->
                <li<?php echo (($_GET['id'] == 163 || !isset($_GET['id'])) ? ' class="current"' : '');?>><a href="<?php echo HTTP_SERVER . '/index.php?main_page=who_we_are&id=163';?>"><?php echo TEXT_OUR_TEAM;?></a></li>
                <li<?php echo ($_GET['id'] == 164 ? ' class="current"' : '');?>><a href="<?php echo HTTP_SERVER . '/index.php?main_page=who_we_are&id=164';?>"><?php echo TEXT_QUALITY_CONTROL;?></a></li>
                <!-- <li<?php echo ($_GET['id'] == 165 ? ' class="current"' : '');?>><a href="<?php echo HTTP_SERVER . '/index.php?main_page=who_we_are&id=165';?>"><?php echo TEXT_SHIPPING_INFO;?></a></li>
         <li><a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG .  'index.php?main_page=testimonial';?>"><?php echo TEXT_TESTIMONIALS;?></a></li>
         <li<?php echo ($_GET['id'] == 157 ? ' class="current"' : '');?>><a href="<?php echo HTTP_SERVER . '/index.php?main_page=who_we_are&id=157';?>"><?php echo TEXT_TERMS_AND_CONDITIONS;?></a></li>
         <li<?php echo ($_GET['id'] == 9 ? ' class="current"' : '');?>><a href="<?php echo HTTP_SERVER . '/index.php?main_page=who_we_are&id=9';?>"><?php echo FOOTER_LINE2_PRIVACY_POLICY;?></a></li> -->
                <li<?php echo ($_GET['id'] == 99999 ? ' class="current"' : '');?>><a href="<?php echo HTTP_SERVER . '/index.php?main_page=who_we_are&id=99999';?>"><?php echo TEXT_CONTACT_US;?></a></li>
            </ul>
        </div>
    </div>
    <div class="help_right">
        <!--
		<div class="top_nav"> 
			<?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG .  'index.php?main_page=who_we_are&id=162">'; ?><?php echo TEXT_ABOUT_US;?></a><span>|</span> 
			<?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG .  'index.php?main_page=who_we_are&id=163">'; ?><?php echo TEXT_OUR_TEAM;?></a><span>|</span> 
			<?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG .  'index.php?main_page=who_we_are&id=164">'; ?><?php echo TEXT_QUALITY_CONTROL;?></a><span>|</span> 
			<a href="<?php echo zen_href_link(FILENAME_CUSTOMER_SERVICE); ?>">Help center</a><span>|</span> 			
			<?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG .  'index.php?main_page=who_we_are&id=165">'; ?><?php echo TEXT_SHIPPING_INFO;?></a>
		</div> -->
        <?php
        switch($_GET['id']){
            case 1:
                $define_about_us = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_ABOUT_US, 'false');
                require($define_about_us);
                break;
            case 2:
                $get_ez_c=$db->Execute("select pages_html_text_web from ".TABLE_EZPAGES." ze inner join " . TABLE_EZPAGES_DESCRIPTION. " zed on zed.pages_id = ze.pages_id where ze.pages_id=180  and languages_id =".$_SESSION['languages_id']." ");
                echo $get_ez_c->fields['pages_html_text_web'];
                break;
            case 3:
                $define_privacy = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_PRIVACY, 'false');
                require($define_privacy);
                break;
            case 162:
                $get_ez_c=$db->Execute("select pages_html_text_web from ".TABLE_EZPAGES." ze inner join " . TABLE_EZPAGES_DESCRIPTION. " zed on zed.pages_id = ze.pages_id where ze.pages_id=162  and languages_id =".$_SESSION['languages_id']." ");
                echo $get_ez_c->fields['pages_html_text_web'];
                break;
            case 163:
                $get_ez_c=$db->Execute("select pages_html_text_web from ".TABLE_EZPAGES." ze inner join " . TABLE_EZPAGES_DESCRIPTION. " zed on zed.pages_id = ze.pages_id where ze.pages_id=163  and languages_id =".$_SESSION['languages_id']." ");
                echo $get_ez_c->fields['pages_html_text_web'];
                break;
            case 164:
                $get_ez_c=$db->Execute("select pages_html_text_web from ".TABLE_EZPAGES." ze inner join " . TABLE_EZPAGES_DESCRIPTION. " zed on zed.pages_id = ze.pages_id where ze.pages_id=164  and languages_id =".$_SESSION['languages_id']." ");
                echo $get_ez_c->fields['pages_html_text_web'];
                break;
            case 165:
                $get_ez_c=$db->Execute("select pages_html_text_web from ".TABLE_EZPAGES." ze inner join " . TABLE_EZPAGES_DESCRIPTION. " zed on zed.pages_id = ze.pages_id where ze.pages_id=165  and languages_id =".$_SESSION['languages_id']." ");
                echo $get_ez_c->fields['pages_html_text_web'];
                break;
            case 99999:
                ?>
                <h2><?php echo TEXT_CONTACT_US;?></h2>
                <div style="padding:6px; border:1px dashed #EFDEEC;">
                    <span style="font-weight:bold;line-height:150%;"><?php echo TEXT_CUSTOMER_SERVICE_HOURS;?></span><br />
                    <?php echo TEXT_FOR_YOUR_CONTACTING;?>
                    <div style="text-align:center;padding:10px;">
                        <!--<embed width="180" height="180" type="application/x-shockwave-flash" wmode="transparent" src="http://www.worldtimeserver.com/clocks/wtsclock024.swf?color=6495ED&amp;wtsid=CN"><br />--><b><?php echo TEXT_BEIJING_TIME;?></b>
                        <br/><span style="font-size:28px; font-weight:bold;display: block;margin-top: 10px;"><span id="clock"></span></span>
                    </div>
                </div>
                <div style="margin-top:20px" class="contact_us_div">
                    <h4 style="margin-top:24px"><span class="header_green_words"><?= EMAIL_TITLE ?></span></h4>
                    <hr size="1" />
                    <span><?= CUSTOMER_SERVICE ?>: <a href="mailto:sale@doreenbeads.com" style="color:#DF57D5;"> <?= CUSTOMER_SERVICE_EMAIL ?></a></span><br />
                    <br />
                </div>
                <div >
                    <?php echo zen_draw_form('contact_us', zen_href_link('who_we_are', 'action=send&id=99999#contactus'),'POST', 'id="contactus" onsubmit="return checkForm();"'); ?>
                    <?php if ($messageStack->size('contact') > 0) echo $messageStack->output('contact'); ?>

                    <br class="clearBoth" />

                    <div >
                        <span style="color: red;">*</span><span style=" font-size: 18px;width: 105px;display: inline-block;"><?php echo ENTRY_NAME; ?></span>
                        <?php echo zen_draw_input_field('contactname', $name, ' size="30" id="contactname" style="height: 20px;margin-left: 5px;"') ; ?>
                    </div>
                    <div><span id="name_error" class="alert"></span></div>
                    <br class="clearBoth" />
                    <div>
                        <span style="color: red;">*</span><span style="font-size: 18px; width: 105px;display: inline-block;"><?php echo ENTRY_EMAIL; ?></span>
                        <?php echo zen_draw_input_field('email', ($error ? $_POST['email'] : $email), ' size="30" id="email-address" style="height: 20px;margin-left: 5px;"'); ?>
                    </div>
                    <div><span id="email_error" class="alert"></span></div>
                    <br class="clearBoth" />
                    <div>
                        <span style="color: red;float:left;">*</span><label for="enquiry"><span style="font-size: 18px;float:left;width: 105px;"><?php echo ENTRY_ENQUIRY . '</span>'; ?></label>
                        <?php echo zen_draw_textarea_field('enquiry', '25', '10', '', 'id="enquiry" style="width:80%;margin-left:7px;display:inline-block;"'); ?>
                    </div>
                    <div>
                        <span id="enquiry_error" class="alert""></span>
                    </div>
                    <br class="clearBoth" />

                    <?php if ($_SESSION['auto_auth_code_display']['contact_us'] >=3  ){?>
                        <div style="position: relative;top: 15px;">
                            <span style="font-size: 18px;color: darkgrey; float: left;width: 105px;display: inline-block;"> &nbsp</span>
                            <input type="text" size="4" id="check_code_input" style="height: 20px;margin-left: 12px;position: relative;top: -10px;">
                            <img id="check_code" src="./check_code.php?<?php echo rand();?>" onclick="this.src='./check_code.php?'+Math.random();" style="height: 25px;position:relative;">
                            <span id="varify_error" class="alert" style="margin-left: 20px;" ></span>
                        </div>
                    <?php }?>

                    <br class="clearBoth" />
                    <div>
                        <span style="font-size: 18px;color: darkgrey; float: left;width: 105px;display: inline-block;"> &nbsp</span>
                        <p style="float:left;display:inline-block;margin-left:12px;margin-top:10px;">
                            <button class="quickbtnbig_yellow forward">
				                <span>
				                    <strong><?php echo TEXT_SUBMIT;?></strong>
				                </span>
                            </button>
                        </p>
                    </div>
                    <div class="clearBoth"></div>
                </div>
                </form>
                <?php require('includes/languages/'. $_SESSION['language'] . '/html_includes/define_contact_us.php');?>

                <?php
                break;
            default:
                $_GET['id'] = !isset($_GET['id']) ? 162 : $_GET['id'];
                $get_ez_c=$db->Execute("select pages_html_text_web from ".TABLE_EZPAGES_DESCRIPTION." where pages_id=" . $_GET['id'] . " and languages_id =".$_SESSION['languages_id']." ");
                echo $get_ez_c->fields['pages_html_text_web'];
                break;
        }
        ?>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    function checkForm(){
        var contactname = $j("#contactname").val();
        var email = $j.trim($j("#email-address").val());
        var message = $j("#enquiry").val();
        var reg=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
        var error = false;

        $j("#name_error").text("");
        $j("#email_error").text("");
        $j("#enquiry_error").text("");
        $j("#varify_error").text("");


        if(contactname == '' || contactname == null){
            $j("#name_error").text("<?php echo ENTRY_EMAIL_NAME_CHECK_ERROR;?>");
            error = true;
        }

        if(email == '' || email == null || !reg.test(email)){
            $j("#email_error").text("<?php echo ENTRY_EMAIL_ADDRESS_CHECK_ERROR;?>");
            error = true;
        }

        if(message == '' || message == null){
            $j("#enquiry_error").text("<?php echo ENTRY_EMAIL_CONTENT_CHECK_ERROR;?>");
            error = true;
        }

        if($j('#check_code_input').length > 0){
            var form_code = $j('#check_code_input').val().toLowerCase();

            if(form_code.length == 0){
                $j("#varify_error").text("<?php echo TEXT_INPUT_RIGHT_CODE;?>");
                error = true;
            }else{
                $j.ajax({
                    url: './checkCode.php',
                    type: 'POST',
                    async: false,
                    data: {form_code: form_code},
                    success: function(data){
                        if(data.length > 0){
                            $j("#varify_error").text("<?php echo TEXT_INPUT_RIGHT_CODE;?>");
                            error = true;
                        }
                    }
                });
            }

        }

        if(!error){
            return true;
        }else{
            return false;
        }
    }

</script>
	
