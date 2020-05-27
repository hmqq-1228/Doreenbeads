
function Addtocart(productid,pageName,langs){
	var row_id='product_listing'
	var success_addcart;
	var language_name;
	var text_enter_quantity;
	var language_addcart_url; 
	var text_quantity_incart;
	var text_quantity_already_incart;
	switch(langs){
		case 'english':
			language_name = 'english' ;
			language_addcart_url = '/en'; 
			text_enter_quantity = 'Please enter the right quantity!';
			text_quantity_incart = 'Quantity in Cart';
			text_quantity_already_incart = 'Quantity Already In Your Cart:';
			text_update = 'Update';
			break;
		case 'german':		
			language_name = 'german' ;
			language_addcart_url = '/de'; 
			text_enter_quantity = 'Bitte geben Sie die richtige Quantität ein!';
			text_quantity_incart = 'Quantität in Warenkorb';
			text_quantity_already_incart = 'Quantität schon in Ihrem Warenkorb:';
			text_update = 'Aktualisieren';
			break;
		case 'russian':
	        language_name = 'russian' ;
			language_addcart_url = '/ru'; 
	        text_enter_quantity = 'Пожалуйста, введите правильное количество!';
	        text_quantity_incart = 'Количество в корзине';
	        text_quantity_already_incart = 'Количество уже в корзине:';
	        text_update = 'Обновить заказ';
	        break;
		case 'french': 
	        language_name = 'french' ;
	        language_addcart_url = '/fr'; 
	        text_enter_quantity = 'Saisissez la quantité correcte!';
	        text_quantity_incart = 'Quantité dans le panier';
	        text_quantity_already_incart = 'Quantité déjà dans votre panier:';
	        text_update = 'update';
	        break;   
		default : 
			language_name = 'english' ;
			language_addcart_url = '/en'; 
			text_update = 'update';
			text_enter_quantity = 'Please enter the right quantity!';
		    text_quantity_incart = 'Quantity in Cart';
			text_quantity_already_incart = 'Quantity Already In Your Cart:';
	}		
	if(document.getElementById("product_listing_"+productid)){
		number = document.getElementById("product_listing_"+productid).value;
	}else{
		number = "";
	}		
	orl_number = parseInt(document.getElementById("incart_" + productid).value);
	MOD = document.getElementById("MDO_" + productid).value;		
	if(number == orl_number && orl_number>0){
		return false;
	}
	
	$('.addsuccess-content').hide();
	$('.error-content').hide();
	if(!isNaN(number)  && number > 0 && number.length>0){				
		var image_src = document.getElementById("submitp_" + productid).src;
		document.getElementById("submitp_" + productid).src = "./includes/templates/cherry_zen/images/zen_loader.gif";					
		$.post("."+language_addcart_url+"/addcart.php", {productid: ""+productid+"",number: ""+number+"",add:""+MOD+"",orl_number:""+orl_number+""}, function(data){
			if(data.length >0) {				
				var datearr = new Array();
				datearr = data.split("|");
				/* 5.wishlist page  1.product list page 2.product gallarey page 3.match,like,also purpured page
				 */				
				if(pageName == 5 || pageName == 1 ) {		
					if(pageName == 5 || pageName == 1 ){
						_index=$('.addToCart').index($('#product_listing_'+productid));
					}
					if(datearr[2]!=''){
						$(".addsuccess-tip").html(datearr[2]);
						$('.addsuccess-content').show();
						 setTimeout(function(){$('.addsuccess-content').hide()},3000);
					     var offset =$('#product_listing_'+productid).offset();
					     var top = offset.top;
					    $('.addsuccess-content').css('top',top);					    
						$("#product_listing_"+ productid).val(datearr[1]);
					}else if(datearr[1]>0){
						switch(langs){
							case 'english': success_addcart = 'Item(s) Added Successfully into Your Shopping Cart!<br/><a href="index.php?main_page=shopping_cart">View Shopping Cart</a>';break;
							case 'german': success_addcart = 'Artikel wurde erfolgreich hinzugefügt.<br/>'+datearr[0]+'Artikel Betrag:  <strong>'+datearr[2]+'</strong><br/><a href="index.php?main_page=shopping_cart">Warenkorb sehen</a>';break;
							case 'russian': success_addcart  = 'Добавлять в корзину успешно<br/>'+datearr[0]+'товар(ы)  всего: <strong>'+datearr[2]+'</strong><br/><a href="index.php?main_page=shopping_cart">Смотреть корзину</a>';break;
							default : success_addcart = 'Add to Cart Successfully<br/>'+datearr[0]+'item(s) total : <strong>'+datearr[2]+'</strong><br/><a href="index.php?main_page=shopping_cart">View  Cart</a>';
						}
						$('.shopcart').attr('class', 'shopcart1');
						//$(".addsuccess-tip").eq(_index).html(success_addcart);
						$(".addsuccess-tip").html(success_addcart);
						$('.addsuccess-content').show();
						 setTimeout(function(){$('.addsuccess-content').hide()},3000);
					     var offset =$('#product_listing_'+productid).offset();
					     var top = offset.top;
					    $('.addsuccess-content').css('top',top);						
							
					}
					
					//$("#count_cart").html(datearr[0]);
					//$('.cartNumHas').eq(_index).html(text_quantity_incart+': '+datearr[1]);
					$("#product_listing_"+ productid).val(datearr[1]);
					if( pageName == 1  ) {
						$("#submitp_" + productid).removeClass("addcart"); 
						$("#submitp_" + productid).addClass("updatecart"); 
						$("#submitp_" + productid).html('<ins></ins>'+text_update);
					} else if( pageName == 5 ) {
						$("#submitp_" + productid).removeClass("cart"); 
						$("#submitp_" + productid).addClass("update"); 
					}
					
					document.getElementById("MDO_" + productid).value = "1";
					document.getElementById("incart_" + productid).value = datearr[1];
				}
				
			}
			if(typeof(datearr[2]) != "undefined" && datearr[2]!="" && typeof($("#swith_button_" + productid)) != "undefined") {
				$("#swith_button_" + productid).show();
				$("#submitp_" + productid).hide();
			}
		});
		return false;						
	}else{
		$('.error-content').show();
		if(orl_number==0) orl_number=1;
		document.getElementById("product_listing_"+productid).value=orl_number;
		 setTimeout(function(){$('.error-content').hide()},3000);
	     var offset =$('#product_listing_'+productid).offset();
	     var top = offset.top+100;
	    $('.error-content').css('top',top);
	    
		return false;
	}
	return false;
}

	
function Addtowishlist(productid,pageName,langs){
	var success_addwishlist;
	var language_name;
	var language_addWishlist_url; 
	var text_login;
	var text_in_wishlist;
	var number = 0;
	switch(langs){
		case 'english': success_addwishlist = 'Item(s) Added Successfully into Your wishlist!&nbsp;&nbsp;<a href="index.php?main_page=wishlist">View Wishlist Products</a>';
				   language_name = 'english' ;
				   language_addWishlist_url = '/en'; 
				   text_login = 'Please <a href="index.php?main_page=login">login</a> to operation';
				   text_in_wishlist = 'This product has been in the wishlist&nbsp;&nbsp;<a href="index.php?main_page=wishlist">View Wishlist Products</a>';
				   break;
		case 'german': success_addwishlist = 'erfolgreich die Artikel in Ihre Wunschliste Konto einlegen!&nbsp;&nbsp;<a href="index.php?main_page=wishlist">Artikel der Wunschliste sehen</a>';
		           language_name = 'german' ;
				   language_addWishlist_url = '/de'; 
		           text_login = 'Bitte einloggen zu tätigen&nbsp;&nbsp;<a href="index.php?main_page=login">Einloggen</a>';
		           text_in_wishlist = 'Die Waren war schon in der Wunschliste&nbsp;&nbsp;<a href="index.php?main_page=wishlist">Artikel der Wunschliste sehen</a>';
		           break;
		           
		case 'russian': success_addwishlist = 'Товар (ы) Успешно добавлен(ы) в ваш список пожелания!&nbsp;&nbsp;<a href="index.php?main_page=wishlist">Смотреть ваши продукты в списке пожелания</a>';
				    language_name = 'russian' ;
					language_addWishlist_url = '/ru'; 
				    text_login = 'Пожалуйста, войдите в эксплуатацию&nbsp;&nbsp;<a href="index.php?main_page=login">Входа</a>';
				    text_in_wishlist = 'Этот продукт был в списке пожелания&nbsp;&nbsp;<a href="index.php?main_page=wishlist">Смотреть ваши продукты в списке пожелания</a>';
				    break; 
		case 'french': success_addwishlist = 'Article(s) ajouté(s) avec succès dans votre wishlist!&nbsp;&nbsp;<a href="index.php?main_page=wishlist">Voir les produits dans le wishlist</a>';
				   language_name = 'french' ;
				   language_addWishlist_url = '/fr'; 
				   text_login = '<a href="index.php?main_page=login">Connectez vous</a> à exploiter.';
				   text_in_wishlist = 'Ce produit a été dans le wishlist&nbsp;&nbsp;<a href="index.php?main_page=wishlist">Voir les produits dans le wishlist</a>';
				   break;
		
		default :  success_addwishlist = 'Item(s) Added Successfully into Your wishlist!&nbsp;&nbsp;<a href="index.php?main_page=wishlist">View Wishlist Products</a>';
		   		   language_name = 'english' ;
				   language_addWishlist_url = '/en'; 
				   text_login = 'Please <a href="index.php?main_page=login">login</a> to operation';
				   text_in_wishlist = 'This product has been in the wishlist&nbsp;&nbsp;<a href="index.php?main_page=wishlist">View Wishlist Products</a>';
	}
	switch(pageName){
		case 1: row_id = "product_list";//product list page
		is_pids_val = true;
		break;			
	}
	if(number == 0){
		number = 1;
	}
	$('.addwish-content').hide();
	$.post("."+language_addWishlist_url+"/addwishlist.php", {productid: ""+productid+"",number: ""+number+""}, function(data){
		if(data.length >0) {
			var datearr = new Array();
			datearr = data.split("|");
			if(parseInt(datearr[0]) == 1){ //not login
				if( pageName == 1 || pageName == 3){					
					$(".addwish-tip").html(text_login);
					$('.addwish-content').show();
					setTimeout(function(){$('.addwish-content').hide()},3000);
				    var offset =$('#wishlist_'+productid).offset();
				    var top = offset.top+100;
				    $('.addwish-content').css('top',top);
				} 
			}else if(parseInt(datearr[0]) == 2){ //existed
				if( pageName == 1 || pageName == 3){					
					$(".addwish-tip").html(text_in_wishlist);
					$('.addwish-content').show();
					setTimeout(function(){$('.addwish-content').hide()},3000);
				    var offset =$('#wishlist_'+productid).offset();
				    var top = offset.top+100;
				    $('.addwish-content').css('top',top);
				}
			}else if(parseInt(datearr[0]) == 3){ //success
				if( pageName == 1 || pageName == 3){
					$(".addwish-tip").html(success_addwishlist);
					$('.addwish-content').show();
					 setTimeout(function(){$('.addwish-content').hide()},3000);
				     var offset =$('#wishlist_'+productid).offset();
				     var top = offset.top+100;
				    $('.addwish-content').css('top',top);
				}
			}				
		}
	});	
}

function restockNotification(productid,pageName,langs){
	var success_addwishlist;
	var language_name;
	var language_addWishlist_url; 
	var text_login;
	var number = 0;
	switch(langs){
		case 'english':
				   language_name = 'english' ;
				   language_addWishlist_url = '/en'; 
				   text_login = 'Please <a href="index.php?main_page=login">login</a> to operation';
				   break;
		case 'german':
		           language_name = 'german' ;
				   language_addWishlist_url = '/de'; 
		           text_login = 'Bitte einloggen zu tätigen&nbsp;&nbsp;<a href="index.php?main_page=login">Einloggen</a>';
		           break;
		           
		case 'russian': 
				    language_name = 'russian' ;
					language_addWishlist_url = '/ru'; 
				    text_login = 'Пожалуйста, войдите в эксплуатацию&nbsp;&nbsp;<a href="index.php?main_page=login">Входа</a>';
				    break; 
		case 'french': 
				   language_name = 'french' ;
				   language_addWishlist_url = '/fr'; 
				   text_login = '<a href="index.php?main_page=login">Connectez vous</a> à exploiter.';
				   break;
		
		default : 
		   		   language_name = 'english' ;
				   language_addWishlist_url = '/en'; 
				   text_login = 'Please <a href="index.php?main_page=login">login</a> to operation';
	}
	$('.restock-content').hide();
	$.post("."+language_addWishlist_url+"/restock_notification.php", {pid: ""+productid+""}, function(data){
		
		if(data.length >0) {
			if(data == 0){
				$(".restock-tip").html(text_login);
				$('.restock-content').show();
				setTimeout(function(){$('.restock-content').hide()},3000);
			    var offset =$('#wishlist_'+productid).offset();
			    var top = offset.top+100;
			    $('.restock-content').css('top',top);			
			}else{
				$('.restock-content').show();
				 setTimeout(function(){$('.restock-content').hide()},3000);
			     var offset =$('#wishlist_'+productid).offset();
			     var top = offset.top+100;
			    $('.restock-content').css('top',top);
			}
		}
	});
}
