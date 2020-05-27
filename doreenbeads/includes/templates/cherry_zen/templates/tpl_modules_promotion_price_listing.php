<?php
/**
 * Module Template
 *
 * Loaded automatically by index.php?main_page=promotion_price.<br />
 * Displays listing of New Products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_products_new_listing.php 4629 2006-09-28 15:29:18Z ajeh $
 */
?>

<div class="dailydeal20140730">
    <div style="margin-bottom:10px;padding-right: 10px;">
        <?php
        $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
        $per_page_parameters = zen_get_all_get_params(array('per_page', 'page'));
        ?>
        <div class="selectlike">
            <label><?php echo TEXT_SHOW;?>: </label>
            <p class="selectnum">
                <span class="text_left1"><?php echo $per_page_num;?></span>
                <span class="arrow_right1"></span>
            </p>
            <ul class="promotion_price_numlist" style="display: none;">
                <li><a rel="nofollow" href="<?php echo zen_href_link($_GET['main_page'], $per_page_parameters . '&per_page='.PRODUCT_NAME_MAX_LENGTH); ?>"><?php echo PRODUCT_NAME_MAX_LENGTH?></a></li>
                <li><a rel="nofollow" href="<?php echo zen_href_link($_GET['main_page'], $per_page_parameters . '&per_page='.ITEM_PERPAGE_DEFAULT); ?>"><?php echo ITEM_PERPAGE_DEFAULT;?></a></li>
                <li><a rel="nofollow" href="<?php echo zen_href_link($_GET['main_page'], $per_page_parameters . '&per_page='.ITEM_PERPAGE_LARGE); ?>"><?php echo ITEM_PERPAGE_LARGE?></a></li>
            </ul>
        </div>
        <div class="sort">
            <div class="selectlike">
                <label><?php echo TEXT_INFO_SORT_BY; ?></label>
                <p class="selectnum">
                    <span class="text_left1"><?php echo isset($_GET['disp_order']) ? $disp_array[$_GET['disp_order']] : ITEM_PERPAGE_DEFAULT;?></span>
                    <span class="arrow_right1"></span>
                </p>
                <ul class="promotion_price_numlist" style="display: none;">
                    <?php
                    if($disp_order != $disp_order_default)
                        echo '<li><a rel="nofollow" href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('disp_order')).'&disp_order='.$disp_order_default).'">'.PULL_DOWN_ALL_RESET.'</a></li>';
                    foreach($disp_array as $key=>$val)
                        echo '<li><a rel="nofollow" href="'.zen_href_link($_GET['main_page'], zen_get_all_get_params(array('disp_order')).'&disp_order='.$key).'">'.$val.'</a></li>';
                    ?>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php
    if (sizeof($promotion_price_split) > 0) {
        $i = 0;
        foreach ($promotion_price_split as $products_new) {
            $products_quantity_data = zen_get_products_stock($products_new['products_id']);
            $products_new['products_quantity'] = $products_quantity_data;
            $page_name = "product_listing";
            $page_type = 10;
            $i++;
            $procuct_qty = 1;
            $bool_in_cart = 0;
// more info in place of buy now
            if (PRODUCT_NEW_BUY_NOW != '0' and zen_get_products_allow_add_to_cart($products_new['products_id']) == 'Y') {

            } else {
                $link = '<a href="' . zen_href_link(zen_get_info_page($products_new['products_id']), 'products_id=' . $products_new['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
                $the_button = $link;
                $products_link = '<a href="' . zen_href_link(zen_get_info_page($products_new['products_id']), 'products_id=' . $products_new['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
                $display_products_button = zen_get_buy_now_button($products_new['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($products_new['products_id']) . str_repeat('', substr(PRODUCT_NEW_BUY_NOW, 3, 1));
            }
            $products_name = get_products_description_memcache($products_new['products_id'], (int) $_SESSION['languages_id']);
            $display_products_name = '<a class="promotion_title_link"  href="' . zen_href_link(zen_get_info_page($products_new['products_id']), 'products_id=' . $products_new['products_id']) . '" title="'.htmlspecialchars(zen_clean_html($products_name)).'">' . zen_name_add_space($products_name) . '&nbsp;&nbsp;('.$products_new['products_model'].')</a>';
            $left_time=strtotime($products_new['dailydeal_products_end_date'])-time();

            $discount_amout = zen_round((($products_new['products_price']-$products_new['dailydeal_price']) / $products_new['products_price']) * 100,0);

            $total_sold = get_deals_sold_info($products_new['products_id']);

            $img_link = '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new['products_id']) . '"><img src="'.HTTP_SERVER.'/'.$products_new['products_img'].'"></a>';

            $all_marketing_infos = get_deals_marketing_info();
            $max_marketing_count = count($all_marketing_infos);
            $rand_index = mt_rand(0, $max_marketing_count >1 ? $max_marketing_count -1 : 0);
            $title = $max_marketing_count >1 ? $all_marketing_infos[$rand_index]:$all_marketing_infos[0];

            ?>
            <?php
//			if($get_group ==3){
            $img_link = '<a href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new['products_id']) . '">'."<img class=\"lazy-img\" src=\"/includes/templates/cherry_zen/images/loading/310.gif\" data-size=\"310\" data-lazyload='".HTTP_IMG_SERVER.'bmz_cache/'.get_img_size($products_new['products_image'], 310, 310)."'/></a>";
//			}
            ?>
            <div class="normalitemleft <?php if($i%2 == 0 )echo 'normalitemright';?>">
                <div class="normalitemfloatprice"><span><?php echo $discount_amout?></span></div>
                <table>
                    <tr>
                        <td>
                            <table width="482">
                                <tr>
                                    <td class="normalitem_product"><?php echo $img_link;?></td>
                                    <td width="272">
                                        <table class="normalitemleft_title">
                                            <tr><th><?php echo $title;?></th></tr>
                                            <tr><td><?php echo $display_products_name;?></td></tr>
                                        </table>
                                        <div class="normalitemleft_price">
                                            <?php echo TEXT_PROMITION_PRICE_NOW_ONLY;?> <span><?php echo $currencies->format($products_new['dailydeal_price']);?></span>
                                        </div>
                                        <table class="normalitemleft_detail" width="268">
                                            <tr class="normalitemleft_detail_valu">
                                                <td><?php echo TEXT_PROMITION_PRICE_VALUE;?></td>
                                                <td><?php echo TEXT_PROMITION_PRICE_YOU_SAVE;?></td>
                                                <td><?php echo TEXT_PROMITION_PRICE_SOLD;?></td>
                                            </tr>
                                            <tr class="normalitemleft_detail_grey">
                                                <td><?php echo $currencies->format($products_new['products_price']);?></td>
                                                <td><?php echo  $currencies->format($products_new['products_price']-round($products_new['dailydeal_price'], 2));?></td>
                                                <td><?php echo $total_sold;?></td>
                                            </tr>
                                        </table>
                                        <table class="normalitemleft_btn">
                                            <tr>
                                                <td>
                                                    <input type="number" min="1" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" class="addinput addcart_qty_input" style="ime-mode:Disabled" maxlength="5" size="4" value="1" name="products_id[<?php echo $products_new['products_id']?>]" id="product_listing_<?php echo $products_new['products_id']?>" onpaste="return !clipboardData.getData('text').match(/\D/)" ondragenter="return false">
                                                    <input type="hidden" value="0" id="MDO_<?php echo $products_new['products_id']?>">
                                                    <input type="hidden" value="0" id="incart_<?php echo $products_new['products_id']?>">
                                                    <a style="cursor:pointer" name="submitp_<?php echo $products_new['products_id']?>" onclick="Addtocart(<?php echo $products_new['products_id'];?>, <?php echo $page_type?>, 0);return false;" id="submitp_<?php echo $products_new['products_id']?>" class="addcartbtn" aid="<?php echo $products_new['products_id'];?>"><?php echo TEXT_PROMITION_PRICE_ADDCART;?></a>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="normalitemleft_time"><tr><td>
                                    <span><b><?php
                                            // if($_SESSION['languages_id'] != 4){
                                            // echo '('.TEXT_PROMITION_PRICE_TIME_LEFT.')';
                                            //}else{
                                            echo TEXT_PROMITION_PRICE_TIME_LEFT .' : ';
                                            //}
                                            ?>
									</b></span>
                                                    <?php
                                                    echo "<span id=\"promotionDay_" . $products_new['products_id']." \">" . str_pad(floor(($left_time)/(24*60*60)),2,'0',STR_PAD_LEFT) . "</span><span>" . TEXT_CODE_DAY . "</span>";
                                                    ?>
                                                    <?php
                                                    echo "<span id=\"promotionHour_" . $products_new['products_id']." \">" . str_pad(floor(($left_time%(24*60*60))/(60*60)),2,'0',STR_PAD_LEFT) . "</span><span>" . TEXT_PROMITION_PRICE_COUNTDOWN_HOUR . "</span>";
                                                    ?>

                                                    <span id="promotionMin_<?php echo $products_new['products_id']?>"><?php echo str_pad(floor((($left_time%(24*60*60))%(60*60))/60),2,'0',STR_PAD_LEFT);?></span><span><?php echo TEXT_PROMITION_PRICE_COUNTDOWN_MIN;?></span>
                                                    <span style="display:none;" id="promotionSecond_<?php echo $products_new['products_id']?>"><?php echo str_pad(floor((($left_time%(24*60*60))%(60*60))%60),2,'0',STR_PAD_LEFT);?></span>


                                                    <script>
                                                        cuttime=setInterval("countdownTime(<?php echo $products_new['products_id']?>)",1000);
                                                    </script>
                                                </td></tr></table>
                                        <div class="floattip2">
                                            <div class="messageStackSuccess hideDiv" id="<?php echo $page_name.$products_new['products_id'];?>">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        <?php }?>
        <?php
    } else {
        echo TEXT_NO_NEW_PRODUCTS;
    }
    ?>
    <div class="clearfix"></div>
    <div class="main_c_pagelist" style="padding-right: 10px;">
        <div class="propagelist spilttd"><?php echo zen_display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page','per_page')) , $_GET['page'] ? $_GET['page'] : 1  , $max_page_num , 0);?></div>
    </div>
    <div class="clearfix"></div>
    <?php
    $html_foot_file = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_DEALS_AREA, 'false');

    if($html_foot_file && file_exists($html_foot_file))
    {
        require($html_foot_file);
    }?>
</div>


<div class="viewtab">




</div>
