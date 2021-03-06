
<div style="margin-top: 20px;">
    <div style="width:15%;"><?php echo zen_image(DIR_WS_LANGUAGE_IMAGES.'green_ball.jpg','','','','style="float:right;margin-right:20px;"');?></div>

    <div style="float:right;width:80%;margin-top:-90px;margin-right:30px;">
        <p style="margin-bottom:10px;color:#e4691b;font-size:36px;" ><?php echo WELCOME_8SEASONS_OLD;?> </p>

        <?php
        $coupon_deadline_sql = "SELECT cpc.date_created FROM ".TABLE_COUPONS." cp inner join " . TABLE_COUPON_CUSTOMER . " cpc on cp.coupon_id = cpc.cc_coupon_id WHERE cp.coupon_code = '".REGISTER_COUPON_CODE."' and cpc.cc_customers_id = " . $_SESSION['customer_id'] . " limit 1";
        $coupon_deadline_query = $db->Execute($coupon_deadline_sql);

        $deadline_datetime = zen_date_long(date('Y-m-d H:i:s', strtotime($coupon_deadline_query->fields['date_created'])+30*24*60*60));
        ?>
        <div id="accountSuccessDiv"><?php echo sprintf(ACCOUNT_SUCCESS_DESCRIBES_SELECTED,$deadline_datetime);?></div>

        <div style="font-size:13px;">
            <p><?php echo NOW_YOU_CAN;?></p>
            <ul style="margin-bottom: 10px;margin-left: 10px;padding-left: 25px;text-align: left;">
                <li style="margin-top:10px;">>><?php echo SHIIPING_ON;?></li>
                <li style="margin-top:10px;">>><?php echo BOTTOM_VIP_POLICY;?></li>
                <li style="margin-top:10px;">>><?php echo LIST4;?></li>
                <li style="margin-top:10px;">>><?php echo LIST3;?></li>
            </ul>
        </div>
    </div>
    <div style="display:inline-block;width:1000px;margin-top:20px;">
        <?php if(isset($r_products) && $r_products != ''){?>
            <div class="caption_recent">
                <h3><?php echo NEW_ARRIVALS;?><span style="color:black;float:right;"><a style="color:black;" href="<?php echo zen_href_link(FILENAME_PRODUCTS_NEWS)?>"><?php echo TEXT_MORE_PRO;?>>>></a></span></h3>

            </div>
            <div class="pic_list">
                <ul>
                    <?php foreach ($r_products as $k => $value){?>
                        <li >
                            <div class="galleryimg">
                                <?php if($value['discount'] > 0){?>
                                    <div class="discountbg"><?php if(in_array($_SESSION['languages_id'], array(2, 3, 4)) ){echo '-' . $value['discount'] . '%';}else{echo $value['discount'] . '%' . '<br>off';}?><br/></div>
                                <?php }?>
                                <p class="galleryimgshow"><a href="<?php echo $value['product_link'];?>" title="<?php echo $value['product_name_all'];?>"><?php echo $value['product_image'];?></a></p>
                            </div>

                            <p class="ptext"><a href="<?php echo $value['product_link'];?>" title="<?php echo $value['product_name_all'];?>"><?php echo $value['product_name'];?></a></p>
                            <p class="partprice"><?php echo $value['display_price'];?></p>

                            <div class="detailinput">
                                <?php if($value['btn_class'] == 'cartbuy rp_btn'){?>
                                    <input name="rp_qty" min="1" max="99999" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" class='rp_qty_<?php echo $value['product_id'];?>' id='product_listing_<?php echo $value['product_id'];?>' value="<?php echo $value['product_cart_qty'] <= 0 ? 1 : $value['product_cart_qty']?>" onpaste="return false;" />
                                    <input type="hidden" value="<?php echo $value['product_cart_qty'];?>" class='rp_oqty_<?php echo $value['product_id'];?>' />
                                    <a href="javascript:void(0);" class="<?php echo $value['btn_class'];?>"  onclick="clickToCart(<?php echo $value['product_id'];?>,20,'<?php echo $value['products_model'];?>'); return false;" id="rp_<?php echo $value['product_id'];?>"></a>
                                    <a href="javascript:void(0);" class="addcollect" id="wishlist_<?php echo $value['product_id'];?>" onclick="beforeAddtowishlist('<?php echo $value['product_id'];?>');"></a>
                                <?php }elseif($value['btn_class'] == 'icon_backorder'){?>
                                    <input name="rp_qty" min="1" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" class='rp_qty_<?php echo $value['product_id'];?>' id='product_listing_<?php echo $value['product_id'];?>' value="<?php echo $value['product_cart_qty'] <= 0 ? 1 : $value['product_cart_qty']?>" onpaste="return false;" />
                                    <input type="hidden" value="<?php echo $value['product_cart_qty'];?>" class='rp_oqty_<?php echo $value['product_id'];?>' />
                                    <a href="javascript:void(0);" class="cartbuy rp_btn" onclick="clickToCart(<?php echo $value['product_id'];?>,20,'<?php echo $value['products_model'];?>'); return false;" id="rp_<?php echo $value['product_id'];?>"></a>
                                    <a href="javascript:void(0);" class="addcollect" id="wishlist_<?php echo $value['product_id'];?>" onclick="beforeAddtowishlist('<?php echo $value['product_id'];?>');"></a>
                                    <div class="clearfix"></div><div style="color:#999">
                                        <?php if($value['products_stocking_days'] > 7){?>
                                            <p class="pro_time"><?php echo TEXT_AVAILABLE_IN715;?></p>
                                        <?php }else{?>
                                            <p class="pro_time"><?php echo TEXT_AVAILABLE_IN57;?></p>
                                        <?php }?>
                                    </div>
                                <?php }else{?>
                                    <div class="detailinput protips">
                                        <p>
                                            <input type="hidden" id="MDO_<?php echo $value['product_id'];?>" value="0">
                                            <input type="hidden" id="incart_<?php echo $value['product_id'];?>" value="0">
                                            <span class="soldout_text">
            				<a rel="nofollow" href="javascript:void(0);" id="restock_<?php echo $value['product_id'];?>" onclick="beforeRestockNotification(<?php echo $value['product_id'];?>); return false;">
            					<?php echo TEXT_RESTOCK;?>&nbsp;<?php echo TEXT_NOTIFICATION;?>
           					</a>
        				</span>
                                            <a rel="nofollow" class="<?php echo $value['btn_class'];?>" id="submitp_<?php echo $value['product_id'];?>" style="color:#000;text-deracotion:none;" href="javascript:void(0);">
                                                <?php echo TEXT_SOLD_OUT;?>
                                            </a>
                                            <a rel="nofollow" class="text addcollect" title="Add to Wishlist" id="wishlist_<?php echo $value['product_id'];?>" onclick="beforeAddtowishlist(<?php echo $value['product_id'];?>,0); return false;" href="javascript:void(0);">
                                            </a>
                                        </p>
                                        <div class="successtips_add successtips_add1">
                                            <span class="bot"></span>
                                            <span class="top"></span>
                                            <ins class="sh">Please enter the right quantity!</ins>
                                        </div>
                                        <div class="successtips_add successtips_add2">
                                            <span class="bot"></span>
                                            <span class="top"></span>
                                            <ins class="sh"></ins>
                                        </div>
                                        <div class="successtips_add successtips_add3">
                                            <span class="bot"></span>
                                            <span class="top"></span>
                                            <ins class="sh"></ins>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>

                        </li>
                    <?php }?>
                </ul>
                <div class="clearBoth"></div>
            </div>
        <?php }?>

    </div>
</div>