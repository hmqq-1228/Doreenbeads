<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_login_default.php 5926 2007-02-28 18:15:39Z drbyte $
 */
?>

<style>
    #contentMainWrapper #content{
        float:left;
        clear:both;
        margin-left: 50px;
    }
    .registercont dt{
        margin-bottom:20px;
    }
    #country_choose {
        margin:0px;
        width:268px;
    }
    .country_select_drop {
        width:266px;
    }

    .registercont dt td span.alert{
        color:#BF0101;
    }
    .registercont dd td span.alert{
        color:#BF0101;
    }
    .registerbtn{
        margin-left: 130px;
    }
    .logtips{background:#eaf0ff;border:1px solid #d0d2eb;line-height:20px;padding:0 10px;margin:5px 0 10px 0;}
    .logtips span a{color:#a1170d;}
    .registercont .btn_like{background-color:#4865b4;text-align:center; color:#fff; font-size:18px; padding:5px 20px;margin-left:-30px;}
    .registercont .btn_like ins{ background:url(https://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/like_f0801.png) no-repeat; display:inline-block; width:12px; height:28px; padding-right:10px; position:relative; top:8px}
    .loginbtn, .registerbtn{background:none;background-color: #bc66d8; color: #fff; font-size: 16px; font-weight: bold; border-radius: 5px; text-shadow: 1px 1px 0 #8f4da5; border: 1px solid #974ADD;}
</style>
<!-- <div style="margin-top:5px;"><span style="font-size:16px;font-weight:700;"><?php echo NAVBAR_TITLE; ?></span></div> -->
<div class="registercont">
    <?php if ($messageStack->size('create_account') > 0) echo $messageStack->output('create_account'); ?>
    <?php if ($messageStack->size('login') > 0) echo $messageStack->output('login'); ?>
    <?php if ($messageStack->size('link') > 0) echo $messageStack->output('link'); ?>
    <div class="logtips"><?php echo TEXT_LOGIN_WITH_8SEASONS;?></div>
    <p class="registertit"><?php echo TEXT_LOGIN_REGISTER_TO_GET;?></p>
    <dl>
        <dd>
            <p class="logtit"><?php echo ($_SESSION['api_login_type'] == '' ? TEXT_RETURN_CUSTOMER : TEXT_API_LOGIN_CUSTOMER);?></p>
            <?php echo zen_draw_form('login', zen_href_link(FILENAME_LOGIN, zen_get_all_get_params(array('action')) . 'action=process', 'SSL'),'post','onsubmit="return check_login_form(login);"'); ?>
            <table>
                <tr>
                    <td width="85" align="right"><strong><?php echo LOGIN_EMAIL_ADDRESS; ?></strong></td>
                    <td>
                        <?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="login-emailaddress" class="loginemail required"'); ?>
                        <br/><div style="margin:5px 0;"><span class="alert" id="login_email_error"><?php echo ($error_facebook ? 'Please use Login With Facebook' : '');?></span></div>
                    </td>
                </tr>
                <tr class="password_tr">
                    <td align="right"><strong><?php echo ENTRY_PASSWORD; ?></strong>
                        <?php
                        if($_GET['main_page'] == "login" && !isset($_GET['action'])){
                            $refer_url = $_GET['redirect_url'] ? urldecode($_GET['redirect_url']) : $_SERVER['HTTP_REFERER'];
                            $refer_url = $refer_url . (preg_match('/^(.*)-p-(.*).html$/', $refer_url) && $_GET['click'] == 'write_reviews' ? '#reviewcontent' : '');

                            ?>
                            <input type="hidden"  id="referer" size="25" name="referer" value="<?php echo $refer_url;?>">
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo zen_draw_password_field('password', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password') . ' id="login-passwd" class="loginpass required"'); ?>
                        <br/><div style="margin:5px 0;"><span class="alert" id="login_passwd_error"><?php echo ($error ? TEXT_LOGIN_ERROR : '');?></span></div>
                    </td>
                </tr>
                <?php if ($_SESSION['login_error_times'] >= 3) { ?>
                    <tr id="check_code_tr">
                        <td align="right"><strong><?php echo TEXT_VERIFY_NUMBER;?>:</strong></td>
                        <td>
                            <?php echo zen_draw_input_field('check_code', '', 'style="width:210px;margin-right:5px;vertical-align:middle;" id="check_code_input"'); ?><img style="vertical-align:middle;" id="check_code" src="/check_code.php?code_suffix=login"  onClick="this.src='./check_code.php?code_suffix=login&'+Math.random();" />
                            <br/><div style="margin:5px 0;"><span class="alert" id="login_checkcode_error"></span></div>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <td></td>
                    <td>
                        <?php if (PERMANENT_LOGIN == 'true') {
                            echo zen_draw_checkbox_field('permLogin', '1', false, 'id="permLogin"');
                            echo '<label for="rememberme">'.TEXT_REMEMBER_ME.'</label>';
                        }
                        ?>
                        <?php echo '<a href="' . zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?>
                    </td>
                </tr>
                <tr><td></td><td><input type="submit" class="loginbtn" value="<?php echo TEXT_LOGIN; ?>"></td></tr>
                <?php
                if(isset($facebook)){
                    $helper = $facebook->getRedirectLoginHelper();
                    $permissions = ['email', 'public_profile'];
                    $loginUrlFacebook = $helper->getLoginUrl((ENABLE_SSL?HTTPS_SERVER:HTTP_SERVER).($_SESSION['languages_code']=='en'?'':'/'.$_SESSION['languages_code']).'/ajax_facebook_login.php', $permissions);
                }
                ?>
                <?php if($_SESSION['api_login_type'] == ''){?>
                    <tr><td></td><td>
                            <span style="vertical-align:  top;display: inline-block;">Login with:</span>
                            <a id="btn_like" href="<?php echo $loginUrlFacebook;?>" style="margin-left:0;padding-right:5px;" ><div id="facebook_img" style="top: 5px;"></div></a>
                            <span onclick = "login_twitter('twitter')" id="twitter_img" style="top: 5px;" ></span>
                            <div id='vk_api_transport' style="display: inline"></div>
                            <span onclick="login_api_vk();" id="vk_img" style="top: 5px;"></span>
                        </td></tr>
                <?php }?>
            </table>
            </form>
        </dd>
        <dt>
            <p class="logtit"><?php echo ($_SESSION['api_login_type'] == '' ? TEXT_NEW_CUSTOMER : sprintf(TEXT_API_REGISTE_NEW_ACCOUNT, $_SESSION['api_login_type']));?></p>
            <?php echo zen_draw_form('create_account', zen_href_link(FILENAME_LOGIN, '', 'SSL'), 'post', 'onsubmit="return check_register_form(create_account);"') . zen_draw_hidden_field('action', 'process') ?>
            <table>
                <tr>
                    <td width="200"><?php echo (zen_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span style="color:red">* </span>': '').'<strong>'.ENTRY_EMAIL_ADDRESS.'</strong>'; ?></td>
                    <td>
                        <?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '35') . ' id="email-address" class="text"') ; ?>
                        <br/><div style="margin-left:8px"><span id="reg_email_error"><?php echo TEXT_EMAIL_NOTE;?><?php echo ($error_facebook_register ? 'This email is taken. Please use Login With Facebook' : '');?></span></div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo (zen_not_null(ENTRY_PASSWORD_TEXT) ? '<span style="color:red">* </span>': '').'<strong>'.ENTRY_PASSWORD.'</strong>'; ?></td>
                    <td>
                        <?php echo zen_draw_password_field('password', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '35') . ' id="password-new" class="text"') ; ?>
                        <span><?php echo LENGHT_CHARACTERS;?></span>
                        <br/><div style="margin-left:8px"><span class="alert" id="reg_password_error"></span></div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo (zen_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span style="color:red">* </span>': '').'<strong>'.ENTRY_PASSWORD_CONFIRMATION.'</strong>'; ?></td>
                    <td><?php echo zen_draw_password_field('confirmation', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '35') . ' id="password-confirm" class="text"') ; ?>
                        <span><?php echo TEXT_CONFIRM_PASSWORD_PROMPT;?></span>
                        <br/><div style="margin-left:8px"><span class="alert" id="reg_confirm_error"></span></div>
                    </td>
                </tr>

                <?php if ($show_reg_checkcode) { ?>
                    <tr>
                        <td><span style="color:red">* </span><strong><?php echo TEXT_VERIFY_NUMBER;?>:</strong></td>
                        <td>
                            <?php echo zen_draw_input_field('reg_check_code', '', 'style="width:210px;margin-right:5px;vertical-align:middle;" id="reg_check_code_input"'); ?><img style="vertical-align:middle;" id="check_code" src="./check_code.php?code_suffix=login"  onClick="this.src='./check_code.php?code_suffix=login&'+Math.random();" />
                            <br/><div style="margin-left:8px;"><span class="alert" id="reg_checkcode_error"></span></div>
                        </td>
                    </tr>
                <?php } ?>

            </table>
            <?php
            if (ACCOUNT_NEWSLETTER_STATUS != 0) {
                ?>
                <p>
                    <?php echo zen_draw_checkbox_field('newsletter', '1', $newsletter, 'id="receivemail"'); ?>
                    <label for="receivemail"><?php echo SUBCIBBE_TO_RECEIVE_EMAIL?></label>
                </p>
                <?php
            }
            ?>
           
            <input type="hidden" name="register_entry" value="2" />
            <p><input type="submit" class="registerbtn" value="<?php echo CREATE_NEW_ACCOUNT; ?>"></p>
            <p style="margin: 10px 10px 10px 30px">
                <?= BY_CREATING_AGREEN_TO_TEAMS_AND_CONDITIONS ?>
            </p>
            </form>
        </dt>
    </dl>
    <!--EOF normal login-->
</div>
