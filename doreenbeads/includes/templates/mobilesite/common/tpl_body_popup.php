<?php
/*
* 切换币种
*/
?>
<div class="popup" style="display:none" id="popupChangeCurrency">
    <div class="close"><a href="javascript:void(0);" id="closeChangeCurrency"></a></div>
    <div class="currencyx" style="background-color:#FFF">
        <h3><?php echo TEXT_CURRENCY ?></h3>
        <ul>
            <?php
            if (isset ( $currencies ) && is_object ( $currencies )) {
                reset ( $currencies->currencies );
                while ( list ( $key, $value ) = each ( $currencies->currencies ) ) {
                    echo '<li><a href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('currency', 'generate_index')).'currency='.$key).'"><span class="'.strtolower($key).'"></span>'.$key.'</a>'.($_SESSION['currency']==$key?'<ins></ins>':'').'</li>';
                }
            }
            ?>
        </ul>
    </div>
</div>


<!-- 切换语言 -->
<div class="popup" style="display:none" id="popupChangeLanguage">
    <div class="close"><a href="javascript:void(0);" id="closeChangeLanguage"></a></div>
    <div class="languagues" style="background-color:#FFF">
        <h3><?php echo TEXT_LANGUAGE ?></h3>
        <ul>
            <?php
            if (isset ( $lngs ) && is_object ( $lngs )) {
                reset ( $lngs->catalog_languages );
                while ( list ( $key, $value ) = each ( $lngs->catalog_languages ) ) {
                    if ($key == 'en') {
                        //echo '<li><a href="/en/'.substr($_SERVER['REQUEST_URI'],4).'">'.$value['name'].'</a>'.(strtolower($_SESSION ['lng']->language['name'])==strtolower($value['name'])?'<ins></ins>':'').'</li>';
                        $link_en = str_replace('/./', '/en/', zen_href_link($_GET['main_page'], zen_get_all_get_params(array('language', 'currency', 'generate_index')) . 'currency=' . $_SESSION['currency'] . '&language='.$key,'SSL'));
                        echo '<li><a data-code="' . $key . '" href="' . $link_en . '">'.$value['name'].'</a>'.(strtolower($_SESSION ['lng']->language['name'])==strtolower($value['name'])?'<ins></ins>':'').'</li>';
                    }else{
                        echo '<li><a data-code="' . $key . '" href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('language', 'currency', 'generate_index')) . 'currency=' . $_SESSION['currency'] . '&language='.$key,'SSL').'">'.$value['name'].'</a>'.(strtolower($_SESSION ['lng']->language['name'])==strtolower($value['name'])?'<ins></ins>':'').'</li>';
                    }
                }
            }
            ?>
        </ul>
    </div>
</div>


<?php
/*
* 列表排序
*/
?>
<div class="popup" style="display:none" id="popupChangeSortBy">
    <div class="close"><a href="javascript:void(0);" id="closeChangeSortBy"></a></div>
    <div class="sortbyx" style="background-color:#FFF">
        <h3><?php echo strtoupper(TEXT_SORT_BY); ?></h3>
        <ul>
            <?php
            echo '<li><a href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('disp_order')).'disp_order=30').'">'.(WEBSITE_PRODUCTS_SORT_TYPE == 'score' ? TEXT_INFO_SORT_BY_BEST_MATCH : TEXT_INFO_SORT_BY_BEST_SELLERS).'</a>'.(!isset($_GET['disp_order'])||$_GET['disp_order']=='30'?'<ins></ins>':'').'</li>';
            echo '<li><a href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('disp_order')).'disp_order=3').'">'.TEXT_INFO_SORT_BY_PRODUCTS_PRICE.'</a>'.(!isset($_GET['disp_order'])||$_GET['disp_order']=='3'?'<ins></ins>':'').'</li>';
            echo '<li><a href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('disp_order')).'disp_order=4').'">'.TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC.'</a>'.(!isset($_GET['disp_order'])||$_GET['disp_order']=='4'?'<ins></ins>':'').'</li>';
            echo '<li><a href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('disp_order')).'disp_order=6').'">'.TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC.'</a>'.(!isset($_GET['disp_order'])||$_GET['disp_order']=='6'?'<ins></ins>':'').'</li>';
            echo '<li><a href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('disp_order')).'disp_order=7').'">'.TEXT_INFO_SORT_BY_PRODUCTS_DATE.'</a>'.(!isset($_GET['disp_order'])||$_GET['disp_order']=='7'?'<ins></ins>':'').'</li>';
            ?>
        </ul>
    </div>
</div>

<div class="popup" style="display:none" id="popupChangeFilterBy">
    <div class="close"><a href="javascript:void(0);" id="closeChangFilterBy"></a></div>
    <div class="filterbyx" style="background-color:#FFF">
        <h3><?php echo strtoupper(TEXT_FILTER_BY); ?></h3>
        <ul>
            <?php
            echo '<li><a href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('pack', 'page'))).'">'.TEXT_ALL.'</a>'.(!isset($_GET['pack'])?'<ins></ins>':'').'</li>';
            echo '<li><a href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('pack', 'page')).'pack=0').'">'.TEXT_REGULAR_PACK.'</a>'.((isset($_GET['pack'])&&$_GET['pack']=='0')?'<ins></ins>':'').'</li>';
            echo '<li><a href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('pack', 'page')).'pack=2').'">'.TEXT_SMALL_PACK.'</a>'.((isset($_GET['pack'])&&$_GET['pack']=='2')?'<ins></ins>':'').'</li>';
            ?>
        </ul>
    </div>
</div>

<?php
/*
* 加入购物车
*/
?>
<div class="popup_shop modal fade" style="display:none" id="popupAddtoCart">
    <div class="close"><a href="javascript:void(0)" id="closeAddtoCart" data-dismiss="modal"></a></div>
    <table class="price" cellpadding="0" cellspacing="2" id="priceAddtoCart">
    </table>
    <div class="amount-wrapper shop_input">
        <span><?php echo TEXT_QTY;?> :</span>
        <div><a class="minus" id="minusAddtoCart"></a><input id="iptAddtoCart" type="text" value="1" maxlength="5" /><a class="plus" id="plusAddtoCart"></a></div>
        <div class="clearfix"></div>
    </div>
    <div class="button">
        <a href="javascript:void(0)" class="btn_orange" id="btnAddtoCart"><?php echo TEXT_ADD_TO_CART; ?></a>
        <p class="prompt" id="availableAddtoCart"><?php echo TEXT_AVAILABLE_IN715; ?></p>
        <p class="prompt" id="tipsAddtoCart"></p>
    </div>
</div>

<?php
/*
* facebook_like
*/
?>
<div class="popup_wrap modal fade" style="display:none" id="pop_fblike">
    <div class="close"><a href="javascript:void(0)" data-dismiss="modal"></a></div>
    <div class="like">
        <h3>Thanks for your likes! </h3>
        <p>Sign up to get FREE Kit</p>
        <?php if(!$_SESSION['customer_id']){ ?><div class="button"><a href="<?php echo $loginUrl;?>" target="_blank" class="join btn_blue" style="padding: 5px 20px;"><ins class="facebook"></ins>Login with Facebook</a></div><?php } ?>
        <span>
			<b>Step One:</b> Add the free kit to shopping cart <br />
			<b>Step Two:</b> Continue shopping or checkout
		</span>
    </div>
</div>

<?php
/*
* spin to win
*/
?>
<div class="popup_wrap pop_stw modal fade" style="display:none" id="spinPopup">
    <a href="javascript:void(0)" data-dismiss="modal" class="close1"></a>
    <div class="spinPopupCont" id="spinPopupCont"></div>
    <div class="clearfix"></div>
</div>

<!-- learning center -->
<?php if($_GET['main_page'] == 'learning_center'){ ?>
    <div class="popup" style="display:none" id="lcPopup">
        <div class="close"><a href="javascript:void(0);" id="closelcPopup"></a></div>
        <div class="learn">
            <h3><?php echo TEXT_LEARNING_CENTER ?></h3>
            <?php foreach ($lc_categories_array_result1 as $key => $value) { ?>
                <h4><a href="<?php echo $value['url'] ?>" class="current"><?php echo $value['name'] ?></a></h4>
                <ul>
                    <?php foreach ($value[$value['id']] as $key1 => $val1) { ?>
                        <li><a href="<?php echo $val1['url'] ?>"><?php echo $val1['name'] ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </div>
<?php } ?>


<?php
/*
* index_login_window
*/
?>
<style type="text/css">

</style>
<div  id="jq_index_login_window" style="display:none;">
    <div class="index_login_window">
        <div class="popup_sign_up">
            <a class="close_black" href="javascript:void(0);"></a>
            <!-- <h3><?php echo strtoupper(TEXT_FREE_601_COUPON); ?><br />
                <?php echo TEXT_WORLDWIDE_FREE_SHIPPING; ?></h3> -->
        <?php 
              if ($_SESSION['languages_id'] ==1){
                  $lang = 'english';
              }
              if ($_SESSION['languages_id'] ==2){
                  $lang = 'german';
              }
              if ($_SESSION['languages_id'] ==3){
                  $lang = 'russian';
              }
              if ($_SESSION['languages_id'] ==4){
                  $lang = 'french';
              } 
           require("includes/languages/".$lang."/html_includes/define_mobile_login_box.php");
        ?>
            <form name="registerform" class="registerform">
                <input type="hidden" name="agree_terms"  value=1 />
                <input type="hidden" name="action"  value='create' />
                <input type="hidden" name="is_return_array"  value=1 />
                <input type="hidden" name="no_password_confirm"  value=1 />
                <input type="hidden" name="no_subscribe"  value=1 />
                <div class="email_p">
                    <input type="text"  class="reg-email-address required signin_input" name="email_address" id="reg_email_address" placeholder="<?php echo ENTRY_EMAIL_ADDRESS; ?>"/>
                    <ins></ins>
                    <span id="reg_email_error" class="msg"></span>
                </div>
                <div class="email_p">
                    <input class="signin_input password_tr password required" type="password" placeholder="<?php echo ENTRY_PASSWORD; ?>" id="reg_password" name="password"/>
                    <ins class="Password"></ins> 
                    <span id="reg_password_error" class="msg"></span>
                </div>
                <input type="hidden" name="register_entry" value="1" />
                <div class="news_letter"><?php echo zen_draw_checkbox_field('newsletter_general', '1', false, 'id="newsletter" onclick="this.value=(this.value==1)?0:1"'); ?><?php echo SUBCIBBE_TO_RECEIVE_EMAIL; ?></div>
                <p class="join_btn"><button class="button_join jq_register_submit" data-url="<?php echo zen_href_link(FILENAME_DEFAULT) . 'ajax_login.php';?>" type="button"><?php echo CREATE_NEW_ACCOUNT; ?></button></p>
                <p class="button"><a href="<?php echo $loginUrl; ?>">Login with Facebook</a></p>
            </form>
            <p class="sign_bottom"><?php echo TEXT_RETURN_CUSTOMERS; ?>? <a class="link_color" href="<?php echo zen_href_link(FILENAME_LOGIN); ?>"><?php echo TEXT_SIGN_IN; ?></a></p>
            <!-- <img src="images/join_bg.jpg" /> -->
        </div>
    </div>
</div>