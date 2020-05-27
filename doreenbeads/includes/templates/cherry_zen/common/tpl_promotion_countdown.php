<?php
$server_time=time();
$start_y=date("Y",$prom_start_date);
$start_mon=date("m",$prom_start_date);
$start_d=date("d",$prom_start_date);
$start_h=date("H",$prom_start_date);

$end_y=date("Y",$prom_end_date);
$end_mon=date("m",$prom_end_date);
$end_d=date("d",$prom_end_date);
$end_h=date("H",$prom_end_date);
//$countdown_info=unserialize(zen_get_configuration_key_value('PROMOTION_COUNTDOWN_INFORMATION'));
//echo stripslashes($countdown_info[$_SESSION['languages_id']]);
$countdown_content=$countdown_info->fields['countdown_content'];
echo stripslashes($countdown_content);
?>
<input type="hidden" id="server_time" value="<?php echo $server_time; ?>">
<input type="hidden" id="year_start" value="<?php echo $start_y; ?>">
<input type="hidden" id="month_start" value="<?php echo $start_mon; ?>">
<input type="hidden" id="day_start" value="<?php echo $start_d; ?>">
<input type="hidden" id="hour_start" value="<?php echo $start_h; ?>">

<input type="hidden" id="year_end" value="<?php echo $end_y; ?>">
<input type="hidden" id="month_end" value="<?php echo $end_mon; ?>">
<input type="hidden" id="day_end" value="<?php echo $end_d; ?>">
<input type="hidden" id="hour_end" value="<?php echo $end_h; ?>">	
<script type="text/javascript"> 

var rm_time=document.getElementById("server_time").value
var start_year=document.getElementById("year_start").value
var start_month=document.getElementById("month_start").value
var start_day=document.getElementById("day_start").value
var start_hour=document.getElementById("hour_start").value

var end_year=document.getElementById("year_end").value
var end_month=document.getElementById("month_end").value
var end_day=document.getElementById("day_end").value
var end_hour=document.getElementById("hour_end").value

	function deleteDiv(dName)
	{
   		var my = document.getElementById(dName);
   		if (my != null)
       	my.parentNode.removeChild(my);
	}

	function setcountdown(theyear,themonth,theday,thehour){
		yr=theyear;mo=themonth;da=theday;ho=thehour;
	} 
	setcountdown(end_year,end_month,end_day,end_hour)
	//document.getElementById("countdown_lasts").innerHTML=start_month+"."+start_day+" - "+end_month+"."+end_day  

	var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec") 
	var d=new Date()
	var lo_time=d.getTime()
	var dtime=lo_time-rm_time*1000
	
	

	function countdown(){
		/*var d=new Date()
      var client_time=d.getTime()
      var today=new Date(client_time-60*60*16*1000)*/
      d=new Date(); //创建一个Date对象
      localTime = d.getTime();
      localOffset=d.getTimezoneOffset()*60000; //获得当地时间偏移的毫秒数
      utc = localTime + localOffset; //utc即GMT时间
      offset =8; //以beijing时间为例，东8区
      hawaii = utc + (3600000*offset);
      var today = new Date(hawaii);
		var todayy=today.getFullYear()
		if (todayy < 1000) 
			todayy+=1900; 
		var todaym=today.getMonth() 
		var todayd=today.getDate()
		var todayh=today.getHours() 
		var todaymin=today.getMinutes() 
		var todaysec=today.getSeconds()

		var todaystring=montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec 
		futurestring=montharray[mo-1]+" "+da+", "+yr+" "+ho+":00:00"
		//alert(todaystring+"||"+futurestring);return false;
		dd=Date.parse(futurestring)*1-Date.parse(todaystring) 
		dday=Math.floor(dd/(60*60*1000*24)*1)
		dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1) 
		dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1) 
		dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1) 
		//alert(dday+'|'+dhour+'|'+dmin+'|'+dsec);return false;
		if(dday<=0&&dhour<=0&&dmin<=0&&dsec<=1&&(todayd*1-1)==da){ 
		 	if (document.all||document.getElementById) 
				document.getElementById("countdown_area").innerHTML="<?php echo TEXT_THE_END;?>"
			return 
		} 
		else if (dday<=-1){ 
			if (document.all||document.getElementById) 
				document.getElementById("countdown_area").innerHTML="<?php echo TEXT_EXPIRED;?>"
			setTimeout("deleteDiv('onsaleinfo')",2000)	
			return 
		} 
		else{ 
			if(dhour.toString().length==1)dhour="0"+dhour
			if(dmin.toString().length==1)dmin="0"+dmin
			if(dsec.toString().length==1)dsec="0"+dsec
			
			if (document.all||document.getElementById) {
				document.getElementById("countdown_day").innerHTML=dday
				document.getElementById("countdown_sec").innerHTML="<span>"+dhour+"</span><a>:</a><span>"+dmin+"</span><a>:</a><span>"+dsec+"</span>";
			}		
		}
		setTimeout("countdown()",1000) 
	}
	window.onload=countdown()
</script>


