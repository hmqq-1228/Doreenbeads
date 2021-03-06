//JavaScript Document
$j(function() {
	$j('.menushow').click(function() {
		$j('.windowbg').height($j(document).height());
		$j('.windowbg').show();
		$j('.mainmenu').show();
	});
	$j('.menuclose').click(function() {
		$j('.windowbg').hide();
		$j('.mainmenu').hide();
	});

	$j('.back-to-top').click(function() {
		$j('body,html').animate({
			scrollTop: 0
		}, 0);
	});

	$j('.category-list .morebtn').click(function() {
		$j(this).parent('ul').children('.more').slideDown();
		$j(this).hide();
		$j(this).next('.lessbtn').show();
	});
	$j('.category-list .lessbtn').click(function() {
		$j(this).parent('ul').children('.more').slideUp();
		$j(this).hide();
		$j(this).prev('.morebtn').show();
	});

	$j('.product-type-tit li').each(function(index) {
		$j(this).click(function() {
			$j('.product-type-tit li.choose').removeClass('choose');
			$j(this).addClass('choose');
			$j('.product-show.sh').removeClass('sh');
			$j('.product-show').eq(index).addClass('sh');
			if ($j(this).index() == 2) {
				$j('.product-type-tit').addClass('initcolor');
			} else {
				$j('.product-type-tit').removeClass('initcolor');
			}
		});
	});

	//searchinput focus and blur function	
	var inputdiv;
	var inputvalue;
	var writefocus;
	function inputclick(inputdiv, inputvalue, writefocus) {
		inputdiv.focus(function() {
			if ($j(this).attr('value') == inputvalue) {
				$j(this).attr('value', '');
				$j(this).addClass('writefocus');
			}
		});
		inputdiv.blur(function() {
			if ($j(this).attr('value') == '') {
				$j(this).attr('value', inputvalue);
				$j(this).removeClass('writefocus');
			}
		});
	}
	inputclick($j('.searchinput'), 'Free shipping for all items', writefocus);
	inputclick($j('#subscribeinput'), 'Subscribe for our newsletter', writefocus);

	//customer review
	var reviewlevel = ["(Poor)", "(Fair)", "(Average)", "(Good)", "(Excellent)"];
	var star = $j("#review span");
	var a = "greystar";
	var b = "goldstar";
	var curvalue = -1; //鼠标离开的时候
	star.each(function(index) {
		$j(star[index]).click(function() {
			curvalue = index;
			$j("#review input").attr("value", index + 1);
			full(index);
		}) $j(star[index]).mouseover(function() {
			full(index);
		}) $j(star[index]).mouseout(function() {
			full(curvalue);
			if (curvalue == -1) $j("#review ins").text("");
		});
	});
	function full(index) {
		for (var i = 0; i < star.length; i++) {
			if (i <= index) $j(star[i]).attr('class', b);
			else $j(star[i]).attr('class', a);
		}
		$j("#review ins").text(reviewlevel[index]);
		$j("#review label").text('');
	}

	var review_tips = "Please add a few more words to your comments. The review needs to have at least 1 character.";
	$j("#review-text").val(review_tips);
	$j("#review-text").blur(function() {
		if ($j(this).val() == '') $j(this).val(review_tips);
		else $j(this).val();
	});
	$j("#review-text").focus(function() {
		if ($j(this).val() == review_tips) {
			$j(this).val('');
			$j("#review-text").css("background", "#fff");
			$j("#review-text").css("color", "#959595");
		} else {
			$j(this).val();
		}
	});

	$j("#review-text").keyup(function() {
		if ($j(this).val() == review_tips) {
			$j(this).val('');
		} else {
			$j("#review-text").css("color", "#333");
			$j('#remaintext').text(1000 - ($j(this).val().length));
			if ($j(this).val().length > 1000) {
				$j(this).val($j(this).val().substr(0, 1000));
			}
		}
	});

	var reviewchecking = function() {
		var checking = true;
		var starval = $j.trim($j("#review input").attr("value"));
		var reviewname = $j.trim($j("#review_text").val());
		if (starval == "") {
			$j("#review label").text("Please choose a rating for this item");
			$j("#review label").css("color", "#c50000").css("font-weight", "normal");
			checking = false;
		} else {
			$j("#review label").text("");
		}
		if (reviewname == "" || reviewname == review_tips) {
			$j("#review-text").css("background", "#fffdea").css("color", "#c70006");
			checking = false;
		}
		return checking;
	}

	$j("#reviewsubmit").click(function() {
		if (!reviewchecking()) return false;
	})

	var question_checking = function() {
		var q_checking = true;
		var emailvalue = $j('#question-email').val();
		var firstname = $j('#first-name').val();
		var lastname = $j('#last-name').val();
		var questionvalue = $j('#question-text').val();
		var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
		if (!reg.test(emailvalue)) {
			$j('#question-email').next('p').text('Your email address does not appear to be valid.please try again');
			q_checking = false;
		}
		if (firstname == '') {
			$j('#first-name').next('p').text('Your first name must not be empty');
			q_checking = false;
		}
		if (lastname == '') {
			$j('#last-name').next('p').text('Your last name must not be empty');
			q_checking = false;
		}
		if (questionvalue == '') {
			$j('#question-text').next('p').text('Your question must not be empty');
			q_checking = false;
		}
		return q_checking;
	}

	$j("#question-submit").click(function() {
		if (!question_checking()) return false;
	})

	$j('.questionform .required').focus(function() {
		$j(this).next('p').text('');
	})

	$j('.dlist .addcart').click(function() {
		$j('.addsuccess-content').show();
		setTimeout(function() {
			$j('.addsuccess-content').hide();
		}, 1000);
		var offset = $j(this).offset();
		var top = offset.top;
		$j('.addsuccess-content').css('top', top);
	})

	$j('.dlgallery .addcart').click(function() {
		$j('.addsuccess-content').show() setTimeout(function() {
			$j('.addsuccess-content').hide();
		}, 1000);
		var offset = $j(this).offset();
		var top = offset.top;
		$j('.addsuccess-content').css('top', top);
	})

	//下单过程JS
	$j('.getdiscount').mousedown(function() {
		$j(this).hide();
		$j('#discounttab').show();
	}) $j('#subcribe-email').click(function() {
		$j(this).children('.check').toggleClass('select');
	}) $j('#agree').click(function() {
		$j(this).children('.check').toggleClass('select');
	})

	$j('.deletebtn').click(function() {
		$j('.addressedittips').hide() $j(this).parents('.addresslist').next('.addressedittips').show();
		$j('.cancelbtn').click(function() {
			$j(this).parents('.addressedittips').hide();
		});
		$j('.okbtn').click(function() {
			$j(this).parents('.addressedittips').prev('.addresslist').remove();
			$j(this).parents('.addressedittips').remove();
		});
	})

	$j('.addresslist.selected').find('.deletebtn').hide();
	$j('.addresslist').find('.editor').hide();
	$j('.addresslist.selected').find('.editor').show();
	$j('.addresslist input').click(function() {
		$j('.addresslist').removeClass('selected');
		$j('.addresslist').find('.editor').hide();
		$j('.addresslist').find('.deletebtn').show();
		$j(this).parents('.addresslist').addClass('selected');
		$j(this).parents('.addresslist').find('.editor').show();
		$j(this).parents('.addresslist').find('.deletebtn').hide();
	})

	$j('.required').focus(function() {
		$j(this).next('span').text('');
	});
	$j('.telephone').focus(function() {
		$j('#tell').text('');
	});
	$j('.addresstext').focus(function() {
		$j('#address1').text('');
	});
	$j('.newemail').focus(function() {
		$j('#emailtext').text('');
	})

	$j('.viewlessbtn').hide();
	$j('.viewallbtn').click(function() {
		$j(this).hide();
		$j('.viewlessbtn').show();
		$j('.alldetails').show();
	}) $j('.viewlessbtn').click(function() {
		$j(this).hide();
		$j('.viewallbtn').show();
		$j('.alldetails').hide();
	})

	$j('.itemhide').click(function() {
		$j(this).parents('.alldetails').hide();
		$j('.viewlessbtn').hide();
		$j('.viewallbtn').show();
	})

	function initbox() {
		$j('.review-box').each(function() {
			var box = $j(this);
			if (box.index() > 2) {
				box.addClass('none');
			};
		});
	}

	initbox();
	$j('.itemshow').click(function() {
		if ($j(this).attr('class') == 'itemshow') {
			$j(this).attr('class', 'itemhide');
			$j('.review-box.none').removeClass('none');
		} else {
			$j(this).attr('class', 'itemshow');
			initbox();
		}
	})

	$j('#usecoupon').click(function() {
		if ($j(this).attr('checked') == "checked") {
			$j('.couponselect').show();
		} else {
			$j('.couponselect').hide();
		}
	});
	$j('#usebtn2').click(function() {
		$j(this).parent('.selectcont1').hide();
		$j('.selectcont2').show();
	});

	$j('#usebtn1').click(function() {
		$j('.discounttext-cont').hide();
		$j('.discounttext-success').show();
	});

	function shiptr() {
		$j('.shipmethod-list tr').each(function() {
			if ($j(this).index() > 4) {
				$j(this).hide();
			}
		});
	}
	shiptr();

	$j('.morecont').click(function() {
		$j('.shipmethod-list tr').show();
		$j(this).hide();
		$j('.lesscont').show();
		$j('.ship-type').show();
	});
	$j('.lesscont').click(function() {
		shiptr();
		$j(this).hide();
		$j('.morecont').show();
		$j('.ship-type').hide();
	})

	$j('.shipmethod-list input').click(function() {
		$j('.shipmethod-list tr').removeClass('selected');
		$j(this).parents('tr').addClass('selected');
	})

	$j('.shipmethod-list ins').click(function() {
		if ($j(this).attr('class') == "opentips") {
			$j(this).attr('class', 'closetipsbtn');
		} else {
			$j(this).attr('class', 'opentips');
		}
		$j(this).next('.shiptips').toggle();
	});
	$j('.closetips').click(function() {
		$j('.shiptips').hide();
		$j('.shipmethod-list ins').attr('class', 'opentips');
	});

	$j('.pricetipsicon').click(function() {
		$j('.pricetipscont').toggle();
	});

	$j('.discountcoupon').click(function() {
		$j('.discounttips').toggle();
	});

	function bombwindow(nowbtn, confirmwindow, okbtn, cancelbtn, cont) {
		$j('.' + nowbtn).click(function() {
			$j('.' + confirmwindow).show();
			$j('.' + okbtn).click(function() {
				$j('.' + cont).remove();
				$j('.' + confirmwindow).hide();
			});

			$j('.' + cancelbtn).click(function() {
				$j('.' + confirmwindow).hide();
			});
		});
	}
	bombwindow('empty-btn', 'emptytips-move', 'okbtn', 'cancelbtn', 'shopcart-cont');
	bombwindow('moveall-btn', 'confirmtips-move', 'okbtn', 'cancelbtn', 'shopcart-cont');

	$j('.delete-btn').click(function() {
		$j(this).parents('.shopcart-list').next('.deletetips').show();
		$j('.okbtn').click(function() {
			$j(this).parents('.deletetips').hide();
			$j(this).parents('.deletetips').prev('.shopcart-list').remove();
		});
		$j('.cancelbtn').click(function() {
			$j(this).parents('.deletetips').hide();
		});
	});

	$j('#searchbtn').click(function() {
		if ($j(this).attr('class') == 'back-button1') {
			$j(this).attr('class', 'back-button2');
		} else {
			$j(this).attr('class', 'back-button1');
		}
		$j('.Order').toggle();
	})

	$j('.methodlist li label').click(function() {
		$j('.submethods').hide();
		$j(this).next('.submethods').show();
		var ttop = $j(this).offset().top;
		$j(window).scrollTop(ttop - 20);
	})

	$j('.methodlist li input[type="radio"]').click(function() {
		$j('.submethods').hide();
		$j(this).parent('li').find('.submethods').show();
		var ttop = $j(this).offset().top;
		$j(window).scrollTop(ttop - 20);
	})

	$j('.usermenulist p').click(function() {
		$j('.viplevel').hide();
		if ($j(this).hasClass('now')) {
			$j(this).next('ul').slideUp('500');
			$j(this).removeClass('now');
		} else {
			$j('.usermenulist p.now').removeClass('now');
			$j('.usermenulist p').next('ul').slideUp('500');
			$j(this).next('ul').slideDown('500');
			$j(this).addClass('now');
		}

	})

	var checking = function() {
		var checked = true;
		var rega = /^.{2,}$j/;
		var regb = /^.{3,}$j/;
		var regc = /^.{5,}$j/;
		var telval = $j.trim($j('.telephone').val());
		var fnameval = $j.trim($j('.firstname').val());
		var lnameval = $j.trim($j('.lastname').val());
		var cityval = $j.trim($j('.citytext').val());
		var tel = $j.trim($j('.telephone').val());
		var postalval = $j.trim($j('.posttext').val());
		var streetval = $j.trim($j('.addresstext').val());
		if (!rega.test(fnameval)) {
			$j('.firstname').next('span').text('please enter 2 characters at least');
			checked = false;
		}
		if (!rega.test(lnameval)) {
			$j('.lastname').next('span').text('please enter 2 characters at least');
			checked = false;
		}
		if (!regb.test(cityval)) {
			$j('.citytext').next('span').text('please enter 3 characters at least');
			checked = false;
		}
		if (!regb.test(tel)) {
			$j('#tell').text('please enter 3 characters at least');
			checked = false;
		}
		if (!regb.test(postalval)) {
			$j('.posttext').next('span').text('please enter 3 characters at least');
			checked = false;
		}
		if (!regc.test(streetval)) {
			$j('#address1').text('please enter 5 characters at least');
			checked = false;
		};
	}

	$j('.addresscheck').click(function() {
		if (!checking()) {
			return false;
		}
	})

	var infochecking = function() {
		var checked1 = true;
		var rega = /^.{2,}$j/;
		var regb = /^.{3,}$j/;
		var regc = /^.{5,}$j/;
		var telval = $j.trim($j('.tell').val());
		var fnameval = $j.trim($j('.firstname').val());
		var lnameval = $j.trim($j('.lastname').val());
		if (!rega.test(fnameval)) {
			$j('.firstname').next('span').text('please enter 2 characters at least');
			checked1 = false;
		}
		if (!rega.test(lnameval)) {
			$j('.lastname').next('span').text('please enter 2 characters at least');
			checked1 = false;
		}
		if (!regb.test(telval)) {
			$j('.tell').next('span').text('please enter 3 characters at least');
			checkedl = false;
		}

		return checked1;
	}

	$j('#infosubmit').click(function() {
		if (!infochecking()) {
			return false;
		}
	})

	$j('.emailValidate').click(function() {
		var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
		emailval = $j.trim($j('.newemail').val());
		if (!reg.test(emailval)) {
			$j('#emailtext').text('please enter the right email');
			return false;
		};
	})

	$j('#passwordchange').click(function() {
		var reg11 = /^.{5,}$j/;
		var passval = $j.trim($j('.currentpass').val());
		if (!reg11.test(passval)) {
			error = " Your Password must contain a minimum of 5 characters.";
			$j('.currentpass').next('span').text(error);
			return false;
		} else {
			$j('.currentpass').next('span').text('');
		}
		var newpass = $j.trim($j('.newpass').val());
		if (!reg11.test(newpass)) {
			error = " Your new Password must contain a minimum of 5 characters.";
			$j('.newpass').next('span').text(error);
			return false;

		} else {
			$j('.currentpass').next('span').text('');
		}
		var confirm1 = $j('.confirmpass').val();
		if (newpass != confirm1) {
			error = " The Password Confirmation must match your new Password.";
			$j('.confirmpass').next('span').text(error);
			return false;
		};
	});

});