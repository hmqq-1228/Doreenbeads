<?php
/** 新增文件jscript_main.php
  * jessa 2010-04-13
  */
?>
<script language="javascript" type="text/javascript">
<!--
function show_description(divid, text, startX){
	/*startX = document.getElementById("mouseposX").value;
	startY = document.getElementById("mouseposY").value;*/
	document.getElementById(divid).innerHTML = text;
	document.getElementById(divid).className = "show_description";
	document.getElementById(divid).style.left = startX + "px";
	//document.getElementById("show_description").style.top = "-100px";
}

function close_description(divid){
	document.getElementById(divid).innerHTML = "";
	document.getElementById(divid).className = "close_description";
}

$j(document).ready(function(){
	var aCont;
	var type;
	var type1;
	$j('a.sorttype').toggle(function(){
        type = $j(this).attr('type');
        type1 = $j('a.sorttype').not($j(this)).attr('type');
        clickFun(type, type1);
        fSort(compare_up);
        setTrIndex(type, type1);
    },function(){
		clickFun(type, type1);
        fSort(compare_down);
        setTrIndex(type, type1);
    })
    var clickFun = function(type, type1){
        aCont = [];
        var sortby = type;
        var sortby1 = type1;
        fSetDivCont(sortby, sortby1);
    }
	var fSetDivCont = function(sortby, sortby1){
		$j('.table_cal_result tr:not(":first")').each(function() {
			var oCont = parseFloat($j(this).attr(sortby) * 1000) + parseFloat($j(this).attr(sortby1));
			aCont.push(oCont);
		});
    }
	var compare_down = function(a,b){
		return a-b;
    }
   
    var compare_up = function(a,b){
		return b-a;
    }
   
    var fSort = function(compare){
        aCont.sort(compare);
    }
	var setTrIndex = function(sortby, sortby1){
        for(i=0;i<aCont.length;i++){
            var divCont = aCont[i];
            $j('.table_cal_result tr:not(":first")').each(function() {
				var thisText = parseFloat($j(this).attr(sortby) * 1000) + parseFloat($j(this).attr(sortby1));
                if(thisText == divCont && $j(this).attr('cost') != '0'){
                    $j('.table_cal_result').append($j(this));
                }
			});       
        }
    }
})
//-->
</script>