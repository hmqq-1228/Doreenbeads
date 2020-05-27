<?php
/**
 * jscript_main
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $jId: jscript_main.php 4942 2006-11-17 06:21:37Z ajeh $j
 */
?>
<script language="javascript" type="text/javascript">

$j(document).ready(function(){
	setTimeout("$j('.updatedis').css('display','none')",5000);
	$j('.accountset li').each(function(index){
		$j(this).click(function(){
		 $j('.accountset li.in').removeClass('in');
		 $j(this).addClass('in');   
		 $j('.accounttab.sh').removeClass('sh');
		  $j('.accounttab').eq(index).addClass('sh');
		 $j('.required').parent('td').next('td').children('span').text(''); 	
		})
	})
	var account_num = '<?php echo $messageStack->size('account');?>';
	if( account_num == 1 ){
		$j('.updateshow').show();
		setTimeout(function(){
		  $j('.updateshow').hide()},4000);
	}	
	var class_now = <?php if(isset($_POST['class_now']))  echo $_POST['class_now']; else echo '0';?> ;
	if(class_now!=''){
		$j(".accountset>li").removeClass("in");
		$j(".accountset>li").eq(class_now).addClass("in");
		$j(".accounttab").removeClass("sh");
		$j(".accounttab").eq(class_now).addClass("sh");
	}
	$j('#passwordchange').click(function(){
	    var reg11=/^.{5,}$/;
		var passval=$j.trim($j('.currentpass').val());
		if(!reg11.test(passval)){
			error=" <?php echo ACCOUNTEDIT_PASSWDERR; ?>";
		    $j('.currentpass').parent('td').next('td').children('span').text(error);
			return false;
		}else{
			$j('.currentpass').parent('td').next('td').children('span').text('');
		}		
		var newpass=$j.trim($j('.newpass').val());
		if(!reg11.test(newpass)){
			error=" <?php echo ACCOUNTEDIT_NEWPASSWDERR; ?>";
		    $j('.newpass').parent('td').next('td').children('span').text(error);
			return false;		
		}else{
			$j('.currentpass').parent('td').next('td').children('span').text('');
		}
		var confirm1 = $j('.confirmpass').val();
		if( newpass != confirm1){
			error=" <?php echo ACCOUNTEDIT_PASSWDMATCHERR; ?>";
	        $j('.confirmpass').parent('td').next('td').children('span').text(error);
			return false;
		}
	})

	$j('.require').focus(function(){
			 $j(this).parent('td').next('td').children('span').text('');
			 $j(this).parent('td').children('span').text('');
			});	
			
	$j('#infosubmit').click(function(){		
		var reg11=/^.{1,}$/;
		var telval=$j.trim($j('.telnum').val());
		var firstname = $j.trim($j('#firstname').val());
		var lastname = $j.trim($j('#lastname').val());
		var customers_business_web=$.trim($('#customers_business_web').val());	
		var dob_year = $j.trim($j('.sel_year').val());
		var dob_month = $j.trim($j('.sel_month').val());
		var dob_day = $j.trim($j('.sel_day').val());
		var url_reg=/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/;
		var check = true;
		if(!reg11.test(firstname)){
			error=" <?php echo ACCOUNTEDIT_FIRSTNAMEERR; ?>";
			$j('#firstname').parent('td').next('td').children('span').text(error);
			 	check = false;
		}
		if(!reg11.test(lastname)){
			error=" <?php echo ACCOUNTEDIT_LASTNAMEERR; ?>";
			$j('#lastname').parent('td').next('td').children('span').text(error);
				check = false;
		}
// 		if(!reg11.test(telval)){
//			error=" <?php echo ACCOUNTEDIT_TELERR; ?>";
// 			$j('.telnum').parent('td').next('td').children('span').text(error);
// 				check = false;
// 		}
		if(!url_reg.test(customers_business_web) && customers_business_web!=''){
			error="<?php echo WEBSITE_ADDRESS_FORMAT;?>";
			$j('#customers_business_web').parent('td').next('td').children('span').text(error);
			check = false;
		}
		var myDate = new Date(); 
		var date_now = myDate.toLocaleDateString();
		if( !(dob_year <= 0 && dob_month <= 0 && dob_day <= 0) ){
		    if ( !(dob_year > 0 && dob_month > 0 && dob_day > 0) ) {
		    	error=" <?php echo TEXT_ENTER_BIRTHDAY_ERROR; ?>";
		    	$j('#birthday').next('td').children('span').text(error);
		      	check = false;
		    }else if( parseInt(Date.parse(dob_year+"/"+dob_month+"/"+dob_day)) > parseInt(Date.parse(date_now)) ){
      			error=" <?php echo TEXT_ENTER_BIRTHDAY_OVER_DATE; ?>";
		    	$j('#birthday').next('td').children('span').text(error);
		      	check = false;
    		}    
		}
		if(!check) return false;
			
	})

	$j('#emailsubmit').click(function(){ 
		var patten = /^[A-Za-z\d]+([-_.][A-Za-z\d]*)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,9}$/;
		var reg11=/^.{3,}$/;
		var email = $j.trim($j('#email-address').val());
		if(!reg11.test(email)){
			error=" <?php echo ACCOUNTEDIT_EMAILERR; ?>";
			$j('#email-address').parent('td').children('span').text(error);
			return false;
		}else if(!patten.test(email)){
			error=" <?php echo ACCOUNTEDIT_EMAILERR; ?>";
			$j('#email-address').parent('td').children('span').text(error);
			return false;
		}else{
			$j('#email-address').parent('td').children('span').text('');
		}
	})
	$j('.DetBgW').live('click',function(){
		$j('.DetBgW').remove();	
		$j('.avatar_upload_div').remove();	
		$j.post('./update_user_avatar.php','',function(data){
			$j('#show_user_avatar_img img').attr('src',data);
			$j('.headportrait img').attr('src',data);
		})	
	})
})		

function country_select_choose(cName){
	$j(document).ready(function(){
		$j('.choose_single').click(function(){	
			var ifshow=$j('.country_select_drop').css('display');
			current=$j("#cSelectId").val();
			if(ifshow=="none"){
				$j('.country_select_drop').show();
				$j(this).removeClass('choose_single_focus');
				$j(this).addClass('choose_single_click');
				$j('.country_select_drop .choose_search input').val('');
				$j('.country_select_drop ul .country_list_item').css('display','block');
				$j('.country_select_drop .choose_search input').focus();
				cNum=$j('#cSelectId').val();
				if($j("#country_list_"+cNum).hasClass('country_list_item_selected')&&!$j("#cSelectId").hasClass('selectNeedList')){
						
						}else{
							$j("#cSelectId").removeClass('selectNeedList');
							$j("#country_list_"+cNum).addClass('country_list_item_selected');
							boxTop1=$j("#country_list_1").position().top;
							boxTop2=$j("#country_list_"+cNum).position().top;
							selfHeight=$j("#country_list_"+cNum).height()+8+7;
							boxTop=boxTop2-boxTop1-220+selfHeight;
							$j('.country_select_drop ul').scrollTop((boxTop));
							}
					}else{
						//$j('.country_select_drop').hide();
						$j(this).removeClass('choose_single_click');
						$j(this).addClass('choose_single_focus');
					}
			})

		$j('.country_list_item').hover(function(){
			$j(this).addClass('country_list_item_hover');
			$j('.country_list_item').removeClass('country_list_item_selected');
			},function(){
				$j(this).removeClass('country_list_item_hover');
				})	

		$j('.country_list_item').click(function(){	
			var cListId=$j(this).attr('clistid');
			var cText=$j(this).text();
			var cId=$j(this).attr('id');
			cIdArr=cId.split('_');
			getCId=cIdArr[2];
			$j('.choose_single span').text(cText);
			$j('#'+cName).val(cListId);
			$j('#cSelectId').val(getCId);
			$j(this).addClass('country_list_item_selected');
			$j('.country_select_drop').hide();
			
			$j('.choose_single').removeClass('choose_single_click');
			$j('.choose_single').addClass('choose_single_focus');
			$j('.choose_single').focus();
			})	

		$j('.choose_single').blur(function(){
			$j(this).removeClass('choose_single_focus');
			})

		$j('.choose_search input').keyup(function(){
		    inputVal=$j(this).val();
		    inputVals=inputVal.replace(/^\s*|\s*$/g, "");
			if(inputVals!=''){
					$j('.country_select_drop ul').scrollTop(0);
					$j("#cSelectId").addClass('selectNeedList');
					$j(".country_select_drop ul .country_list_item").each(function(){
						cTextVal=$j(this).text();
						re = new RegExp("^"+inputVals,'i');  
						re2= new RegExp("\\s+"+inputVals,'i')
						if(cTextVal.match(re)||cTextVal.match(re2)){
									$j(this).css('display','block');
								}else{
									$j(this).css('display','none');
									}
						});
				}else{
					$j('.country_select_drop ul .country_list_item').css('display','block');
					}
			})				
		})		
}

// 生日下拉菜单插件
(function($){ 
$.extend({ 
ms_DatePicker: function (options) { 
   var defaults = { 
         YearSelector: "#sel_year", 
         MonthSelector: "#sel_month", 
         DaySelector: "#sel_day", 
         FirstYearText: $lang.TEXT_LANG_YEAR, 
         FirstMonthText: $lang.TEXT_LANG_MONTH, 
         FirstDayText: $lang.TEXT_LANG_DAY, 
         FirstValue: 0 
   }; 
   var opts = $.extend({}, defaults, options); 
   var $YearSelector = $(opts.YearSelector); 
   var $MonthSelector = $(opts.MonthSelector); 
   var $DaySelector = $(opts.DaySelector); 
   var FirstYearText = opts.FirstYearText; 
   var FirstMonthText = opts.FirstMonthText; 
   var FirstDayText = opts.FirstDayText; 
   var FirstValue = opts.FirstValue; 
 
   // 初始化 
   var str_year = "<option value=\"" + FirstValue + "\">"+FirstYearText+"</option>"; 
   var str_month = "<option value=\"" + FirstValue + "\">"+FirstMonthText+"</option>"; 
   var str_day = "<option value=\"" + FirstValue + "\">"+FirstDayText+"</option>"; 
   $YearSelector.html(str_year); 
   $MonthSelector.html(str_month); 
   $DaySelector.html(str_day); 
 
   // 年份列表 
   var yearNow = new Date().getFullYear(); 
   var yearSel = $YearSelector.attr("rel"); 
   for (var i = 1900; i <= yearNow; i++) { 
        var sed = yearSel==i?"selected":""; 
        var yearStr = "<option value=\"" + i + "\" " + sed+">"+i+"</option>"; 
        $YearSelector.append(yearStr); 
   } 
 
    // 月份列表 
    var monthSel = $MonthSelector.attr("rel"); 
    for (var i = 1; i <= 12; i++) { 
        var sed = monthSel==i?"selected":""; 
        var monthStr = "<option value=\"" + i + "\" "+sed+">"+i+"</option>"; 
        $MonthSelector.append(monthStr); 
    } 
 
    // 日列表(仅当选择了年月) 
    function BuildDay() { 
        if ($YearSelector.val() == 0 || $MonthSelector.val() == 0) { 
            // 未选择年份或者月份 
            //$DaySelector.html(str); 
        } else { 
            $DaySelector.html(str_day); 
            var year = parseInt($YearSelector.val()); 
            var month = parseInt($MonthSelector.val()); 
            var dayCount = 0; 
            switch (month) { 
                 case 1: 
                 case 3: 
                 case 5: 
                 case 7: 
                 case 8: 
                 case 10: 
                 case 12: 
                      dayCount = 31; 
                      break; 
                 case 4: 
                 case 6: 
                 case 9: 
                 case 11: 
                      dayCount = 30; 
                      break; 
                 case 2: 
                      dayCount = 28; 
                      if ((year % 4 == 0) && (year % 100 != 0) || (year % 400 == 0)) { 
                          dayCount = 29; 
                      } 
                      break; 
                 default: 
                      break; 
            } 
            
            var daySel = $DaySelector.attr("rel");
            if ($DaySelector.val() != "" && $DaySelector.val() != "0") {daySel = $DaySelector.val()};
            for (var i = 1; i <= dayCount; i++) { 
                var sed = daySel==i?"selected":""; 
                var dayStr = "<option value=\"" + i + "\" "+sed+">" + i + "</option>"; 
                $DaySelector.append(dayStr); 
             } 
         } 
      } 
      $MonthSelector.change(function () { 
         BuildDay(); 
      }); 
      $YearSelector.change(function () { 
         BuildDay(); 
      }); 
      if($DaySelector.attr("rel")!=""){ 
         BuildDay(); 
      } 
   } // End ms_DatePicker 
}); 
})(jQuery); 

$j(function () { 
    $j.ms_DatePicker({ 
            YearSelector: ".sel_year", 
            MonthSelector: ".sel_month", 
            DaySelector: ".sel_day" 
    }); 
});

</script>