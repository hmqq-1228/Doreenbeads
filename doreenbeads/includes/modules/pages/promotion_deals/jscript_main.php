<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: jscript_main.php 5444 2006-12-29 06:45:56Z drbyte $
//
?>
<script language="javascript" type="text/javascript">
function getDomId(id){
	return document.getElementById(id);
}
$j(document).ready(function(){
		$j('.addcartbtn').mouseover(function(){
			id=$j(this).attr('aid');
			var second=getDomId('promotionSecond_'+id);
			var min=getDomId('promotionMin_'+id);
			var hour=getDomId('promotionHour_'+id);
			var day=getDomId('promotionDay_'+id);
			if(min.innerHTML=='00'&&hour.innerHTML=='00'&&day.innerHTML=='00'&&second.innerHTML=='00'){
				$j('#alert_piomotion_'+id).show();
			}
        });
        $j('.addcartbtn').mouseout(function(){
			$j('#alert_piomotion_'+id).hide();
        });  
});
function countdownTime(id){
	var second=getDomId('promotionSecond_'+id);
	var min=getDomId('promotionMin_'+id);
	var hour=getDomId('promotionHour_'+id);
	var day=getDomId('promotionDay_'+id);
	
	if(second.innerHTML=='00'){
		if(min.innerHTML=='00'&&hour.innerHTML=='00'&&day.innerHTML=='00'){
			//clearInterval(cuttime);
			//window.location.reload();
		}else{
			second.innerHTML='59';
			countdownMin(id);
		}	
	}else{
		second.innerHTML-=1;
		if(second.innerHTML.toString().length==1){
			second.innerHTML='0'+second.innerHTML;
		}
	}
}
function countdownMin(id){
	var min=getDomId('promotionMin_'+id);
	var hour=getDomId('promotionHour_'+id);
	var day=getDomId('promotionDay_'+id);
	if(min.innerHTML=='00'){
		if(hour.innerHTML=='00'&&day.innerHTML=='00'){
			return false;
		}else{
			min.innerHTML='59';
			countdownHour(id);
		}
	}else{
		min.innerHTML-=1;
		if(min.innerHTML.toString().length==1){
			min.innerHTML='0'+min.innerHTML;
		}
	}
}
function countdownHour(id){
	var hour=getDomId('promotionHour_'+id);
	var day=getDomId('promotionDay_'+id);
	if(hour.innerHTML=='00'){
		if(day.innerHTML=='00'){
			return false;
		}else{
			hour.innerHTML='23';
			countdownDay(id);
		}		
	}else{
		hour.innerHTML-=1;
		if(hour.innerHTML.toString().length==1){
			hour.innerHTML='0'+hour.innerHTML;
		}
	}
}
function countdownDay(id){
	var day=getDomId('promotionDay_'+id);
	if(day.innerHTML=='00'){
			return false;			
	}else{
		hour.innerHTML-=1;
		if(hour.innerHTML.toString().length==1){
			hour.innerHTML='0'+hour.innerHTML;
		}
	}
}
</script>
