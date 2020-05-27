
$(function() {

    $j('.addcart_qty_input').live('keydown', function(e){
        if ($j.browser.msie) {
            var key = event.keyCode;
        } else {
            var key = e.which;
        }
        if (key == 8 || (key >= 35 && key <= 39 && key != 38) || (key >= 46 && key <= 57 && key != 47) || (key >= 96 && key <= 105)) {
            return true;
        } else {
            return false;
        }
    }).focus(function() {
        this.style.imeMode='disabled';   // 禁用输入法,禁止输入中文字符
    });

//	$j(".addcart_qty_input").keyup(function(){
//		var val = $j(this).val();
//		var reg = /^\d+$/;
//		if($j(this).parents("table").hasClass('wishlisttab'))
//			var tipObj = $j(this).parents("td").find('.successtips_add1');
//		else
//			var  tipObj = $j(this).parents("li").find('.successtips_add1');
//		if(! val.match(reg) || val <= 0){
//			$j(this).val($j(this).attr('orig_value'));
//			$j(".product_nav .selectlike").css('z-index','0');
//			tipObj.show();
//			setTimeout("$j('.product_list .successtips_add1').hide();$j('.product_info_qty_input .successtips_add1').hide();$j('.product_nav .selectlike').css('z-index','1');", 3000);
//		}
//		else
//			tipObj.hide();
//	});
});

function clicktoclose(pid,pageName){
    language_name = document.getElementById("c_lan").value;
    switch(pageName){
        case 0: row_id = "matching";//product info page
            is_pids_val = true;
            break;
        case 1: row_id = "also_like";//product info page
            is_pids_val = true;
            break;
        case 2: row_id = "also_purchased";//product info page
            is_pids_val = true;
            break;
        case 3: row_id = "new_products";//shopping cart page when item=0
            is_pids_val = true;
            break;
        case 4: row_id = "product_listing";//product list page
            is_small_img =false;
            break;
        case 5: row_id = "featured_products";//shopping cart page when item=0
            is_pids_val = true;
            break;
        case 6: row_id = "specisals_index";//shopping cart page when item=0
            is_pids_val = true;
            break;
        case 7: row_id = "succs_";
            product_info = true;
            is_small_img =false;
            break;
        case 8: row_id = "quick_view";//quick view page
            is_pids_val = true;
            break;
        case 9: row_id = "quick_view_list";//quick view page  quick_view_list
            //is_pids_val = true;
            break;
        case 10: row_id = "also_like_list";
            is_small_img =false;
            break;
        case 11: row_id	= "show_package_product_listing";
            //is_small_img =false;
            is_pids_val = false;
            break;
        default : row_id = "succs_";
            is_pids_val = false;
            is_small_img =false;
    }
    if (pageName == 4 ) {
        $j("#submitp_" + pid).removeClass('icon_loading');
    }else if(pageName == 7){
        $j("#submitp_" + pid).removeClass('icon_loading');
        $j('.open_window').remove();
        $j('.DetBgW').remove();
    }else if(pageName == 8){
        document.getElementById("submitp_" + pid).src = "./includes/templates/cherry_zen/buttons/"+language_name+"/add-cart.png";
    }else if(pageName == 9 || pageName == 0 || pageName == 1 || pageName == 2){
        if ($j('.addcartbtn_sub_loading').hasClass('addbuy_update')) {
            $j('.addbuy_update').removeClass('addcartbtn_sub_loading');
        }else{
            $j('.input_addcart').removeClass('addcartbtn_sub_loading');
        };
    }else{
        document.getElementById("submitp_" + pid).src = "./includes/templates/cherry_zen/buttons/"+language_name+"/button_in_cart_green.gif";
    }
    $j(".messageStackSuccess").hide();
}

function clickToCart(pid,pageName,model){
    var qty = $j('#product_listing_' + pid).val();
    $j.post("./addcart.php", {action: 'add_or_update',productid: pid,number:qty,model:model}, function(data){
        console.log(qty);
        $j('.open_window').remove();
        $j('.DetBgW').remove();
        var language_name;
        var text_enter_quantity;
        var language_addcart_url;
        var text_quantity_incart;
        var text_quantity_already_incart;
        langs = document.getElementById("c_lan").value;//语言版本 english or germen
        switch(langs){
            case 'german':
                language_name = 'german' ;
                language_addcart_url = '/de';
                text_enter_quantity = 'Bitte geben Sie die richtige Quantität ein!';
                text_quantity_incart = 'Quantität in Warenkorb';
                text_quantity_already_incart = 'Quantität schon in Ihrem Warenkorb:';
                proudctsUpdate = 'Aktualisieren';
                proudctsBeenRemoved = 'Es tut uns leid, dass dieses Produkt schon aus unserem Bestand entfernt wurde.';
                break;
            case 'russian':
                language_name = 'russian' ;
                language_addcart_url = '/ru';
                text_enter_quantity = 'Пожалуйста, введите правильное количество!';
                text_quantity_incart = 'Количество в корзине';
                text_quantity_already_incart = 'Количество уже в корзине:';
                proudctsUpdate = 'Oбновить';
                proudctsBeenRemoved = 'К сожалению, этот товар был удален из нашего инвентаря в это время.';
                break;
            case 'french':
                language_name = 'french' ;
                language_addcart_url = '/fr';
                text_enter_quantity = 'Saisissez la quantité correcte!';
                text_quantity_incart = 'Quantité dans le panier';
                text_quantity_already_incart = 'Quantité déjà dans votre panier:';
                proudctsUpdate = 'Mettre à jour';
                proudctsBeenRemoved = 'Désolé, cet article est déjà supprimé de notre catégorie.';
                break;
            case 'spanish':
                language_name = 'spanish' ;
                language_addcart_url = '/es';
                text_enter_quantity = '¡Por favor ingrese la cantidad adecuada!';
                text_quantity_incart = 'Cantidad en el carro';
                text_quantity_already_incart = 'Cantidad ya en su cesta:';
                proudctsUpdate = 'Actualizar';
                proudctsBeenRemoved = 'Lo sentimos pero este producto ha sido retirado de nuestro inventario.';
                break;
            case 'japanese':
                language_name = 'japanese';
                language_addcart_url = '/jp';
                text_enter_quantity = '正しい数量を入力してください！';
                text_quantity_incart = 'カート内数量';
                text_quantity_already_incart = 'すでにカートに入れる数量：';
                proudctsUpdate = '更新';
                proudctsBeenRemoved = '申し訳ございませんが、現時点でこの商品が在庫から削除されました。';
                break;
            case 'italian':
                language_name = 'italian' ;
                language_addcart_url = '/it';
                text_enter_quantity = 'Si prega di inserire la quantità corretta!';
                text_quantity_incart = 'Quantità nel Carrello';
                text_quantity_already_incart = 'Quantità Già nel Tuo Carrello:';
                proudctsUpdate = 'Aggiorna';
                proudctsBeenRemoved = 'Siamo spiacenti ma questo prodotto è già stato cancellato dal nostro inventario.';
                break;
            default :
                language_name = 'english' ;
                language_addcart_url = '/en';
                text_enter_quantity = 'Please enter the right quantity!';
                text_quantity_incart = 'Quantity in Cart';
                text_quantity_already_incart = 'Quantity Already In Your Cart:';
                proudctsUpdate = 'Update';
                proudctsBeenRemoved = 'We are sorry but this product has been removed from our inventory at this time.';

        }
        switch(pageName){
            case 0: row_id = "matching";//product info page
                $j('#matching_'+pid).val(""+qty+"");
                break;
            case 1: row_id = "also_like";//product info page
                $j('#also_like_'+pid).val(""+qty+"");
                break;
            case 2: row_id = "also_purchased";//product info page
                $j('#also_purchased_'+pid).val(""+qty+"");
                break;
            case 3: row_id = "new_products";//shopping cart page when item=0
                is_pids_val = true;
                break;
            case 4: row_id = "product_listing";//product list page
                $j("#submitp_" + pid).removeClass('icon_loading');
                $j("#submitp_" + pid).removeClass('icon_addcart').addClass('icon_updates').html(proudctsUpdate);
                $j('#product_listing_'+pid).val(""+qty+"");
                $j(".product_nav .selectlike").css('z-index','0');
                var success_addcart = $lang.SuccessAddcart;
                $j("#submitp_" + pid).prev('.successtips_add2').children("ins.sh").html(success_addcart);
                $j("#submitp_" + pid).prev('.successtips_add2').show();
                break;
            case 5: row_id = "featured_products";//shopping cart page when item=0
                is_pids_val = true;
                break;
            case 6: row_id = "specisals_index";//shopping cart page when item=0
                is_pids_val = true;
                break;
            case 7: row_id = "succs_";
                $j("#submitp_" + pid).removeClass('icon_loading');
                $j("#submitp_" + pid).removeClass('icon_addcart').addClass('icon_updates').html(proudctsUpdate);
                console.log(qty);
                $j('#product_listing_'+pid).val(""+qty+"");
                $j(".product_nav .selectlike").css('z-index','0');
                var success_addcart = $lang.SuccessAddcart;
                $j("#submitp_" + pid).parent().prev('.successtips_add2').children("ins.sh").html(success_addcart);
                $j("#submitp_" + pid).parent().prev('.successtips_add2.successtips_add').show();
                break;
            case 8: row_id = "quick_view";//quick view page
                $j("#submitp_" + pid).removeClass('icon_loading');
                $j("#submitp_" + pid).removeClass('icon_addcart').addClass('icon_updates');
                $j('#quick_view_'+pid).val(""+qty+"");
                $j(".product_nav .selectlike").css('z-index','0');
                var success_addcart = $lang.SuccessAddcart;
                $j("#submitp_" + pid).parent().siblings('.successtips_add2').children("ins.sh").html(success_addcart);
                $j("#submitp_" + pid).parent().siblings('.successtips_add2.successtips_add').show();
                break;
            case 9: row_id = "quick_view_list";//quick view page  quick_view_list
                document.getElementById('submitp_' + pid).className = 'addbuy_update';
                break;
            case 10: row_id = "also_like_list";
                is_small_img =false;
                break;
            case 11: row_id	= "show_package_product_listing";
                //is_small_img =false;
                is_pids_val = false;
                break;
            case 20: row_id = "recently_viewed";//shopping cart empty page
                $j("#rp_" + pid).removeClass('icon_loading').addClass('icon_updates');
                $j('#rp_qty_'+pid).val(""+qty+"");
                window.location.reload();
                break;
            default : row_id = "succs_";
                document.getElementById("submitp_" + pid).src = "./includes/templates/cherry_zen/buttons/"+language_name+"/button_in_cart_update.png";
                $j('#succs__'+pid).val(""+qty+"");
        }

        if (pageName == 0 || pageName == 1 || pageName == 2 ) {
            $j("#submitp_" + pid).removeClass('icon_loading');
            $j("#submitp_" + pid).removeClass('icon_addcart').addClass('icon_updates');
            $j('#product_listing_'+pid).val(""+qty+"");
            $j(".product_nav .selectlike").css('z-index','0');
            var success_addcart = $lang.SuccessAddcart;
            $j("#submitp_" + pid).parent().siblings('.successtips_add2').children("ins.sh").html(success_addcart);
            $j("#submitp_" + pid).parent().siblings('.successtips_add2.successtips_add').show();
        };
        $j("#count_cart").html(data);



        setTimeout("$j('.product_list .successtips_add2').hide();$j('.product_info_qty_input .successtips_add2').hide();$j('.pic_list .successtips_add2').hide();;$j('.product_nav .selectlike').css('z-index','1');", 3000);
        return false;
    });
}

//	lvxiaoyong 1.30 addtocart call by product_list & quickly
function Addtocart_list(productid,pageName,obj){//产品id
    if(pageName == 8)
        var row_id = "quick_view";
    /*WSL other package tanchuang*/
    else if(pageName == 11)
        var row_id = "show_package_product_listing";
    else
        var row_id = "product_listing";

    if(document.getElementById(row_id+"_"+productid)){
//			number = parseInt(document.getElementById(row_id+"_"+productid).value);//产品的个数
        number = document.getElementById(row_id+"_"+productid).value;
    }else{
        number = "";
    }

    pids = productid;

//		orl_number = parseInt(document.getElementById("incart_" + productid).value);
    orl_number = document.getElementById("incart_" + productid).value;
    MOD = document.getElementById("MDO_" + productid).value;//是否购物车里有数据

    var tipObj = $j(obj).parents("li").find('.successtips_add2');
    if($j(obj).parents("table").hasClass('wishlisttab'))
        var tipObj = $j(obj).parents("td").find('.successtips_add2');
    if(pageName == 11){
        tipObj = $j("#show_package_product_listing_submitp_" + productid).prev('.successtips_add2');
    }else{
        tipObj = $j("#submitp_" + productid).prev('.successtips_add2');
    }
    tipObj.hide();
    if(!isNaN(number)  && number > 0){

        $j('.open_window').remove();
        $j('.DetBgW').remove();
        //$j("#submitp_" + productid).addClass('icon_loading');
        if(document.getElementById("show_package_product_listing_submitp_"+productid)){
            //$j("#show_package_product_listing_submitp_" + productid).addClass('icon_loading');
        }

        $j.post("./addcart.php", {productid: ""+productid+"",number: ""+number+"",add:""+MOD+"",orl_number:""+orl_number+""}, function(data){
            if(data.length >0) {
                var datearr = new Array();
                datearr = data.split("|");

                if (datearr[0] == 'yes') {
                    var langs = document.getElementById("c_lan").value;
                    switch(langs){
                        case 'german':
                            var note = 'Freundliche Erinnerung:<br>Für '+datearr[3]+'  haben wir momentan nur etwa '+datearr[2]+' Packungen auf Lager, trotzdem können Sie dieses Produkt bestellen. Wir werden so schnell wie möglich es auffüllen und Ihnen liefern.';
                            var qty = 'Quant.';
                            var addtocart = 'Bestätigen';
                            break;
                        case 'russian':
                            var note = 'Вежливое напоминание:<br>Для '+datearr[3]+' у нас есть только xx пачка/пачки/пачек '+datearr[2]+' на складе в данный момент. Пожалуйста, продолжайте их заказывать, мы пополняем и позже отправляем их вам как можно скорее.';
                            var qty = 'Кол-КОЛ-ВО.:';
                            var addtocart = 'Подтвердить';
                            break;
                        case 'french':
                            var note = "Rappel gentil:<br>Pour "+datearr[3]+", nous avons seulement environ "+datearr[2]+" paquets en stock en ce moment. Veuillez commander directement. Nous allons les réapprovisionner et expédier dès que possible.";
                            var qty = 'quantité:';
                            var addtocart = 'confirmer';
                            break;
                        case 'spanish':
                            var note = 'Kindly reminder:<br>For '+datearr[3]+', we only have about '+datearr[2]+' packs in stock at moment. Please go ahead to order them, we will restock and ship it to you ASAP. ';
                            var qty = 'QTY:';
                            var addtocart = 'Confirma';
                            break;
                        case 'japanese':
                            var note = 'ご注意：<br>この商品'+datearr[3]+'、只今約'+datearr[2]+'パックしか在庫がございません。先に注文してください。受注後、私たちは在庫を補充して出来るだけ早く出荷致します。';
                            var qty = '数量：';
                            var addtocart = '確認';
                            break;
                        case 'italian':
                            var note = 'Gentile Nota:<br>Per '+datearr[3]+', abbiamo solo circa '+datearr[2]+' pacco(pacchi) nel magazzino al momento. Si prega di andare avanti per ordinarli, riprenderemo e spediremo a Voi presto.';
                            var qty = 'QTY';
                            var addtocart = 'Conferma';//Aggiungi al Carrello
                            break;
                        default :
                            var note ='Kindly reminder:<br>For '+datearr[3]+', we only have about '+datearr[2]+' packs in stock at moment. Please go ahead to order them, we will restock and ship it to you ASAP. ';
                            var qty = 'Quantity:';
                            var addtocart = 'Confirm';
                    }
                    var bodyHeight=$j(document).height();
                    $j("body").append("<div class='DetBgW hasDetBgW'></div>");
                    //$j(".DetBgW").css({"height":bodyHeight,"opacity":0.35});
                    $j(".DetBgW").css({"opacity":0.35});
                    $j(".DetBgW").css({"height":bodyHeight});
                    $j(".DetBgW").fadeIn();
                    var sHeight = $j(document).scrollTop();
                    var wHeight=$j(window).height();
                    news_err="<div class='open_window'></div>";
                    $j("body").append(news_err);
                    var model = datearr[3];
                    var data='<a href="javascript:void(0)" class="close" onclick="clicktoclose('+productid+','+pageName+');return false;" ></a><div class="center_note_area">'+note+'</div><div class="input_num_div"><span>'+qty+'</span><input type="text" maxlength="5" id="getTrueInput" value='+datearr[1]+' name="rp_qty" class="rp_qty_'+productid+'" onpaste="return false;"></div><p class="doublebutton" style="margin-top:0;"><button class="btn_yellow rp_btn" onclick="clickToCart('+productid+','+pageName+',\''+model+'\'); return false;" id="'+productid+'"><span style="background:none;width:118px;"><strong style="background:none;background-color:#b260cd;text-shadow:none;color:#fff;">'+addtocart+'</strong></span></button></p>';
                    $j('.open_window').html(data);
                    rHeight=$j(".open_window").height();
                    var box_top=sHeight+(wHeight-rHeight)/2;
                    rWidth=$j(".open_window").width();
                    var box_left=($j(document).width()-rWidth)/2;
                    //$j(".open_window").css({"top":box_top, "left":box_left});
                    $j(".open_window").css({"left":box_left});
                    $j(".open_window").show();
                    return false;
                };
                if(datearr[2] != ''){
                    alert(datearr[2]);
                }else{
                    if(!tipObj.attr('class')){
                        if(pageName == 11 ){
                            tipObj = $j("#show_package_product_listing_submitp_" + productid).parents("li").find('.successtips_add2');
                        }else{
                            tipObj = $j("#submitp_" + productid).parents("li").find('.successtips_add2');
                        }
                    }
                    //if(!tipObj.attr('class')){
                    // tipObj = $j("#submitp_" + productid).prev('.successtips_add2');
                    //}
                    tipObj.show();
                    $j(".product_nav .selectlike").css('z-index','0');
                    var success_addcart = $lang.SuccessAddcart;
                    tipObj.children("ins.sh").html(success_addcart);
                }
                $j("#count_cart").html(datearr[0]);
                //暂时屏蔽掉计算总价的影响性能，Tianwen.Wan20141013
                //$j("#header_cart_total").html(datearr[3]);
                if($j(".cartcontent .addcart").hasClass("hasnoitem")) $j(".cartcontent .addcart").removeClass("hasnoitem").addClass("hasitem");

                /*other package size*/
                if(pageName == 11){
                    if($j("#show_package_product_listing_submitp_" + productid).attr('class') != 'icon_backorder icon_loading'){
                        $j("#show_package_product_listing_submitp_" + productid).attr('class','icon_updates');
                        document.getElementById(row_id+"_"+productid).value = datearr[1];
                    }else{
                        $j("#show_package_product_listing_submitp_" + productid).attr('class','icon_backorder');
                    }
                    if($j("#show_package_product_listing_submitp_" + productid).attr('class') != 'icon_backorder'){
                        if($j(obj).parents("ul").hasClass('list')) $j("#show_package_product_listing_submitp_" + productid).html($lang.TextUpdate);
                        if($j(obj).parents("ul").hasClass('gallery')) $j("#show_package_product_listing_submitp_" + productid).attr('title',$lang.TextUpdate);
                        if($j(obj).parents("ul").hasClass('detailitem')) $j("#show_package_product_listing_submitp_" + productid).attr('title',$lang.TextUpdate);
                    }
                    if(document.getElementById("quick_view_"+productid)){
                        document.getElementById("quick_view_"+productid).value = datearr[1];
                    }
                }else{
                    if($j("#submitp_" + productid).attr('class') != 'icon_backorder'){
                        if($j(obj).parents("ul").hasClass('list')) $j("#submitp_" + productid).html($lang.TextUpdate);
                        if($j(obj).parents("ul").hasClass('gallery')) $j("#submitp_" + productid).attr('title',$lang.TextUpdate);
                        if($j(obj).parents("ul").hasClass('detailitem')) $j("#submitp_" + productid).attr('title',$lang.TextUpdate);
                    }
                }
                if(!$j("#submitp_" + productid).hasClass('icon_backorder')){
                    $j("#submitp_" + productid).attr('class','icon_updates');
                    document.getElementById(row_id+"_"+productid).value = datearr[1];

                }else{
                    $j("#submitp_" + productid).attr('class','icon_backorder').html($lang.TextUpdate);
                }

                if($j(obj).parents("table").hasClass('wishlisttab')){
                    $j(".wishlisttab #submitp_" + productid).html($lang.TextUpdate);
                    $j(".wishlisttab .cartno_" + productid).html($lang.QtyAlreadyInCart+datearr[1]);
                    $j("#submitp_" + productid).attr('class','addtocart2');
                }
                document.getElementById("MDO_" + productid).value = "1";
                document.getElementById("incart_" + productid).value = datearr[1];
                $j('#qty_in_cart').html(datearr[1]);
                document.getElementById("product_listing_" + productid).value = datearr[1];
            }
        });
    }else{
        tipObj.show();
        var text_enter_quantity = $lang.EnterRightQty;
        $j(".product_nav .selectlike").css('z-index','0');
        tipObj.children("ins.sh").html(text_enter_quantity);
    }

    setTimeout("$j('.product_list .successtips_add2').hide();$j('.product_info_qty_input .successtips_add2').hide();$j('.pic_list .successtips_add2').hide();;$j('.product_nav .selectlike').css('z-index','1');", 3000);
    return false;
}

//	before add to wishlist , check if login
function beforeAddtowishlist(productid,pageName){
    var isLogin = $j('.isLogin').val();
    if(isLogin == 'yes'){
        Addtowishlist_list(productid,pageName, false);
    }else{
        var param = '{"productid":'+productid+',"pageName":'+pageName+'}';
        show_login_div('addtowishlist', param);
    }
}

/*
 * add to wishlist
 * lvxiaoyong 1.30 called by product_list & quickly
 * */
function Addtowishlist_list(productid, pageName, is_reload){
    $j('.loginbody, .windowbody').fadeOut();

    var text_login = $lang.TextLogin;
    var success_addwishlist = $lang.SuccessAddWishlist;
    var text_in_wishlist = $lang.HasInWishlist;

    if(pageName == 8)
        var row_id = "quick_view";
    else if(pageName == 11)
        var row_id = "show_package_product_listing";
    else
        var row_id = "product_listing";

    if(document.getElementById(row_id+"_"+productid)){
//			number = parseInt(document.getElementById(row_id+"_"+productid).value);//产品的个数
        number = document.getElementById(row_id+"_"+productid).value;
    }else{
        number = "";
    }
    pids = productid;
    if(number == 0){
        number = 1;
    }
    var backhtml = $j("#wishlist_" + productid).html();
    var cssborder = $j("#wishlist_" + productid).css('border');
    if(pageName == 11){
        var backhtml = $j("#show_package_product_listingwishlist_" + productid).html();
        var cssborder = $j("#show_package_product_listingwishlist_" + productid).css('border');
    }
    $j("#wishlist_" + productid).css('background', 'url("/includes/templates/cherry_zen/images/zen_loader.gif") no-repeat scroll center center transparent');
    if($j("#wishlist_" + productid).parents("ul").hasClass('list') || $j("#wishlist_" + productid).parents("ul").hasClass('gallery')) $j("#wishlist_" + productid).html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
    $j("#wishlist_" + productid).css('border', '0');
    $j.post("./addwishlist.php", {productid: ""+productid+"",number: ""+number+""}, function(data){
        $j("#wishlist_" + productid).html(backhtml).css('background','');
        $j("#wishlist_" + productid).css('border', cssborder);

        if(pageName == 11){
            var tipObj = $j("#show_package_product_listingwishlist_" + productid).parents("li").find('.successtips_add3');
        }else{
            var tipObj = $j("#wishlist_" + productid).parents("li").find('.successtips_add3');
        }
        if(is_reload)
            window.location.reload();
        else if(data.length > 0) {
            var datearr = new Array();
            datearr = data.split("|");

            tipObj.show();

            if(parseInt(datearr[0]) == 1){	// no login
                tipObj.children("ins.sh").html(text_login);
            }else if(parseInt(datearr[0]) == 2){	//	exist
                tipObj.children("ins.sh").html(text_in_wishlist);
            }else if(parseInt(datearr[0]) == 3){	//	success
                tipObj.children("ins.sh").html(success_addwishlist);
                if(datearr[1]){
                    $j("#count_wishlist_new").html(datearr[1]);
                }
            }
            setTimeout("$j('.product_list .successtips_add3').hide();$j('.product_info_qty_input .successtips_add3').hide();$j('.pic_list .successtips_add3').hide();", 3000);
        }
    });
    return false;
}

//	before restock notification, check if login
function beforeRestockNotification(productid){
    return false;
    var isLogin = $j('.isLogin').val();
    if(isLogin == 'yes'){
        restockNotification_list(productid, false);
    }else{
        var param = '{"productid":'+productid+'}';
        show_login_div('restocknotification', param);
    }
}

//	lvxiaoyong 1.30, restock notification
function restockNotification_list(productid, is_reload){
    $j('.loginbody, .windowbody').fadeOut();

    var text_login = $lang.LoginToOperation;
    var success_subscribed = $lang.SuccessSubscribed;

    var backhtml = $j("#restock_" + productid).html();
    $j("#restock_" + productid).css('background', 'url("/includes/templates/cherry_zen/images/zen_loader.gif") no-repeat scroll center center transparent').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');

    $j.post("./restock_notification.php", {pid: ""+productid+""}, function(data){
        $j("#restock_" + productid).html(backhtml).css('background','');
        if(data.length >0) {
            if(data == 0){
                alert(text_login);
            }else{
                alert(success_subscribed);
            }
            if(is_reload) window.location.reload();
        }
    });
}

/*
 * add to cart
 * */
function Addtocart(productid,pageName){//产品id
    var is_pids_val = false;
    var product_info=false;
    var is_small_img=true;

    var success_addcart = '<img height="20" width="20" src="includes/templates/template_default/images/icons/success.gif"> ' + $lang.SuccessAddcart;
    var language_name = document.getElementById('c_lan');
    var text_enter_quantity = $lang.EnterRightQty;
    var text_quantity_incart = $lang.QtyInCart;

    switch(pageName){
        case 0: row_id = "matching";//product info page
            is_pids_val = true;
            break;
        case 1: row_id = "also_like";//product info page
            is_pids_val = true;
            break;
        case 2: row_id = "also_purchased";//product info page
            is_pids_val = true;
            break;
        case 3: row_id = "new_products";//shopping cart page when item=0
            is_pids_val = true;
            break;
        case 4: row_id = "product_listing";//product list page
            is_small_img =false;
            break;
        case 5: row_id = "featured_products";//shopping cart page when item=0
            is_pids_val = true;
            break;
        case 6: row_id = "specisals_index";//shopping cart page when item=0
            is_pids_val = true;
            break;
        case 7: row_id = "succs_";
            product_info = true;
            is_small_img =false;
            break;
        case 8: row_id = "quick_view";//quick view page
            is_pids_val = true;
            break;
        case 9: row_id = "new_arrivals";//new_arrivals page
            is_pids_val = true;
            break;
        case 10: row_id = "product_listing";//deals_product page
            product_info = true;
            is_pids_val = false;
            is_small_img =false;
            break;
        default : row_id = "succs_";
            is_pids_val = false;
            is_small_img =false;
    }
    if(document.getElementById(row_id+"_"+productid)){
//			number = parseInt(document.getElementById(row_id+"_"+productid).value);//产品的个数
        number = document.getElementById(row_id+"_"+productid).value;
    }else{
        number = "";
    }
//		orl_number = parseInt(document.getElementById("incart_" + productid).value);
    orl_number = document.getElementById("incart_" + productid).value;
    MOD = document.getElementById("MDO_" + productid).value;//是否购物车里有数据

    if(is_pids_val){
        pids = document.getElementById("hide_pid_" + productid).value;
    }else{
        pids = productid;
    }
    if(pageName==9){
        var arr = pids.split("_");
        row_id = arr[0]+"_";
        pids = arr[1];
//			number = parseInt(document.getElementById(row_id+"_"+productid).value);//产品的个数
        number = document.getElementById(row_id+"_"+productid).value;
    }
//		alert(orl_number);
    $j(".messageStackCaution").hide();
    $j(".messageStackSuccess").hide();
    if(!isNaN(number) && number > 0){
        if(product_info){
            $j('#submitp_'+productid).removeClass();
            if(pageName==10){
                $j('#submitp_'+productid).html('...');
            }else
            {
                $j('#submitp_'+productid).html('.');
            }

            $j('#submitp_'+productid).addClass('btn_loading');
        }else{
            document.getElementById("submitp_" + productid).src = "./includes/templates/cherry_zen/images/zen_loader.gif";
        }
        $j.post("./addcart.php", {productid: ""+productid+"",number: ""+number+"",add:""+MOD+"",orl_number:""+orl_number+""}, function(data){
            if(data.length >0) {
                var datearr = new Array();
                datearr = data.split("|");
                $j("#" + row_id + pids).show();
                if(datearr[2] != ''){
                    $j("#" + row_id + pids).attr("class","messageStackCaution");
                    $j("#" + row_id + pids).html(datearr[2]);
                }else{
                    $j("#" + row_id + pids).attr("class","messageStackSuccess");
                    $j("#" + row_id + pids).html(success_addcart);
                }
                $j("#count_cart").html(datearr[0]);
                //暂时屏蔽掉计算总价的影响性能，Tianwen.Wan20141013
                //$j("#header_cart_total").html(datearr[3]);
                if($j(".cartcontent .addcart").hasClass("hasnoitem")) $j(".cartcontent .addcart").removeClass("hasnoitem").addClass("hasitem");
                document.getElementById(row_id+"_"+productid).value = datearr[1];
                if(product_info){
                    $j('#submitp_'+productid).removeClass();
                    $j('#submitp_'+productid).html($lang.TextUpdate);
                    $j('#submitp_'+productid).addClass('btn_update');
                    $j("#qty_in_cart").html(datearr[1]);
                }else if(is_small_img){
                    document.getElementById("submitp_" + productid).src = "./includes/templates/cherry_zen/buttons/"+language_name+"/button_quick_add_to_cart.jpg";
                }else{
                    document.getElementById("submitp_" + productid).src = "./includes/templates/cherry_zen/buttons/"+language_name+"/button_in_cart_green.gif";
                }
                if(document.getElementById("qty" + productid)){
                    $j("#qty"+productid).html("<span style=\"color:green;\">" + QtyAlreadyInCart +datearr[1]+ "</span>");
                }
                document.getElementById("MDO_" + productid).value = "1";
                document.getElementById("incart_" + productid).value = datearr[1];

            }
        });

        setTimeout("$j('.messageStackSuccess').hide();", 5000);
        setTimeout("$j('.messageStackCaution').hide();", 8000);
        return false;
    }else{
        if(product_info){
            document.getElementById(row_id+"_"+productid).value = 10;
        }
        $j("#" + row_id + pids).attr("class","messageStackCaution");
        $j("#" + row_id + pids).show();
        $j("#" + row_id + pids).html('<img height="20" width="20" src="includes/templates/template_default/images/icons/warning.gif"> '+text_enter_quantity);
        return false;
    }
    return false;
    //
}

/*
 * add to wishlist
 * */
function Addtowishlist(productid,pageName){
    var is_pids_val = false;
    var product_info=false;

    var success_addwishlist;
    var language_name;
    var text_login;
    var text_in_wishlist;
    success_addwishlist = '<img height="20" width="20" src="includes/templates/template_default/images/icons/success.gif"> ' + $lang.SuccessAddWishlist;
    language_name = document.getElementById('c_lan');
    text_login = $lang.LoginToOperation;
    text_in_wishlist = $lang.HasInWishlist;
    switch(pageName){
        case 0: row_id = "matching";//product info page
            is_pids_val = true;
            break;
        case 1: row_id = "also_like";//product info page
            is_pids_val = true;
            break;
        case 2: row_id = "also_purchased";//product info page
            is_pids_val = true;
            break;
        case 3: row_id = "new_products";//shopping cart page when item=0
            is_pids_val = true;
            break;
        case 4: row_id = "product_listing";//product list page
            break;
        case 5: row_id = "featured_products";//shopping cart page when item=0
            is_pids_val = true;
            break;
        case 6: row_id = "specisals_index";//shopping cart page when item=0
            is_pids_val = true;
            break;
        case 7: row_id = "succs_";
            product_info = true;
            break;
        case 8: row_id = "quick_view";//quick view page
            is_pids_val = true;
            break;
        case 9: row_id = "new_arrivals";//new_arrivals page
            is_pids_val = true;
            break;
        default : row_id = "succs_";is_pids_val = false;
    }
//		alert(productid);return false;
    if(document.getElementById(row_id+"_"+productid)){
//			number = parseInt(document.getElementById(row_id+"_"+productid).value);//产品的个数
        number = document.getElementById(row_id+"_"+productid).value;
    }else{
        number = "";
    }

    if(is_pids_val){
        pids = document.getElementById("hide_pid_" + productid).value;
    }else{
        pids = productid;
    }
    if(pageName==9){
        var arr = pids.split("_");
        row_id = arr[0]+"_";
        pids = arr[1];
//			number = parseInt(document.getElementById(row_id+"_"+productid).value);//产品的个数
        number = document.getElementById(row_id+"_"+productid).value;
    }
    if(number == 0){
        number = 1;
    }
    $j(".messageStackCaution").hide();
    $j(".messageStackSuccess").hide();

    if(product_info){
        $j('#wishlist_'+productid).removeClass();
        $j('#wishlist_'+productid).html('.');
        $j('#wishlist_'+productid).addClass('btn_loading');
    }else{
        document.getElementById("wishlist_" + productid).src = "./includes/templates/cherry_zen/images/zen_loader.gif";
    }
    $j.post("./addwishlist.php", {productid: ""+productid+"",number: ""+number+""}, function(data){
        if(data.length >0) {
            var datearr = new Array();
            datearr = data.split("|");
            if(parseInt(datearr[0]) == 1){
                $j("#" + row_id + pids).attr("class","messageStackCaution");
                $j("#" + row_id + pids).show();
                $j("#" + row_id + pids).html('<img height="20" width="20" src="includes/templates/template_default/images/icons/warning.gif"> '+text_login);
                if(product_info){
                    $j('#wishlist_'+productid).removeClass();
                    $j('#wishlist_'+productid).html('Add to Wishlist');
                    $j('#wishlist_'+productid).addClass('btn_addwishlist');
                }else{
                    document.getElementById("wishlist_" + productid).src = "./includes/templates/cherry_zen/buttons/"+language_name+"/button_in_wishlist_green.gif";
                }
            }else if(parseInt(datearr[0]) == 2){
                $j("#" + row_id + pids).attr("class","messageStackCaution");
                $j("#" + row_id + pids).show();
                $j("#" + row_id + pids).html('<img height="20" width="20" src="includes/templates/template_default/images/icons/warning.gif"> '+text_in_wishlist);
                if(product_info){
                    $j('#wishlist_'+productid).removeClass();
                    $j('#wishlist_'+productid).html('Add to Wishlist');
                    $j('#wishlist_'+productid).addClass('btn_addwishlist');
                }else{
                    document.getElementById("wishlist_" + productid).src = "./includes/templates/cherry_zen/buttons/"+language_name+"/button_in_wishlist_green.gif";
                }
            }else if(parseInt(datearr[0]) == 3){
                $j("#" + row_id + pids).attr("class","messageStackSuccess");
                $j("#" + row_id + pids).show();
                $j("#" + row_id + pids).html(success_addwishlist);
                if(datearr[1]){
                    //$j("#count_wishlist").html(datearr[1]);
                    $j("#count_wishlist_new").html(datearr[1]);
                }
                if(product_info){
                    $j('#wishlist_'+productid).removeClass();
                    $j('#wishlist_'+productid).html('Add to Wishlist');
                    $j('#wishlist_'+productid).addClass('btn_addwishlist');
                }else{
                    document.getElementById("wishlist_" + productid).src = "./includes/templates/cherry_zen/buttons/"+language_name+"/button_in_wishlist_green.gif";
                }
            }
//				$j("#count_cart").html(data);

        }
    });
    return false;
}
$(function () {
    /**
     * 点击添加/刷新购物车按钮处理购物车并刷新数据
     * @author yifei.wang
     * @date 2018/07/03
     */
    $('a[id^=rp_]').click(function () {
        var product_id = this.id.replace('rp_', '');
        var number = $('input.rp_qty_' + product_id).val();
        $j.post('/addcart.php', {
            action: 'add_or_update',
            productid: product_id,
            number: number
        }, function (data) {
            window.location.href = location.href;
        });
    });
});
