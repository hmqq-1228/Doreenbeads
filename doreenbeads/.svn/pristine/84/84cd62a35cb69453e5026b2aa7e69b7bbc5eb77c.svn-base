function SetFocus() {
  if (document.forms.length > 0) {
    var field = document.forms[0];
    for (i=0; i<field.length; i++) {
      if ( (field.elements[i].type != "image") &&
           (field.elements[i].type != "hidden") &&
           (field.elements[i].type != "reset") &&
           (field.elements[i].type != "submit") ) {

        document.forms[0].elements[i].focus();

        if ( (field.elements[i].type == "text") ||
             (field.elements[i].type == "password") )
          document.forms[0].elements[i].select();

        break;
      }
    }
  }
}
function checkCount(contents,obt) {
	var inputs = document.getElementsByName("customerCheckbox[]");
	var checked_counts = 0;
	for(var i=0;i<inputs.length;i++){
		if(inputs[i].checked){
			checked_counts++;
		}
	}
	if(checked_counts == 0) {
		alert(contents); return false;
	} else {
		if(confirm('确定删除选中的客户信息?')) {changeAction(obt)} else {
			for(var i=0;i<inputs.length;i++){
				if(inputs[i].checked){
					//checked_counts++;
					inputs[i].checked = false;
				}
			}
			return false;
		}
	}
}
function rowOverEffect(object) {
  if (object.className == 'dataTableRow') object.className = 'dataTableRowOver';
}
function getAllCheck(point,checkArr){
	var pCheck=point.checked;
	var cCheckArr=document.getElementsByName(checkArr);
	for(var i=0;i<cCheckArr.length;i++){
		cCheckArr[i].checked=pCheck;
	}
}
function changeURLPar(destiny, par, par_value){
	var pattern = par+'=([^&]*)';
	var replaceText = par+'='+par_value;
	if (destiny.match(pattern)){
		var tmp = '/\\'+par+'=[^&]*/';
		tmp = destiny.replace(eval(tmp), replaceText);
		return (tmp);
	} else {
		if (destiny.match('[\?]')) {
			return destiny+'&'+ replaceText;
		} else {
			return destiny+'?'+replaceText;
		}
	}
	return destiny+'\n'+par+'\n'+par_value;
}
function changeAction(object){
	var cust=document.getElementById('customerForm');
	var custAction=cust.action;
	if(object.id=='removeAll'){
		cust.action=changeURLPar(custAction, 'action', 'removeAll');
		return true;
	}else if(object.id=='changeAll'){
		cust.action=changeURLPar(custAction, 'action', 'changeAll');
		return true;
	}else{
		return false;
	}
}
function rowOutEffect(object) {
  if (object.className == 'dataTableRowOver') object.className = 'dataTableRow';
}
function getAllCheck(point,checkArr){
	var pCheck=point.checked;
	var cCheckArr=document.getElementsByName(checkArr);
	for(var i=0;i<cCheckArr.length;i++){
		cCheckArr[i].checked=pCheck;
	}
}
function changeURLPar(destiny, par, par_value)
{
var pattern = par+'=([^&]*)';
var replaceText = par+'='+par_value;

if (destiny.match(pattern))
{
 var tmp = '/\\'+par+'=[^&]*/';
 tmp = destiny.replace(eval(tmp), replaceText);
 return (tmp);
}
else
{
 if (destiny.match('[\?]'))
 {
  return destiny+'&'+ replaceText;
 }
 else
 {
  return destiny+'?'+replaceText;
 }
}

return destiny+'\n'+par+'\n'+par_value;
}

function changeAction(object){
	var cust=document.getElementById('customerForm');
	var custAction=cust.action;
if(object.id=='removeAll'){
	cust.action=changeURLPar(custAction, 'action', 'removeAll');
	return true;
}else if(object.id=='changeAll'){
	cust.action=changeURLPar(custAction, 'action', 'changeAll');
	return true;
}
else{
	return false;
}

}

function changeAction1(object){
	var cust=document.getElementById('productChange');
	var productcheckbox=document.getElementsByName('productcheckbox[]');
	var count=0;
	
	for (var i=0;i<productcheckbox.length;i++){
		if(productcheckbox[i].checked){
			count++;
		}
	}
		var custAction=cust.action;
if(object.id=='moveAll'){
	if (count>0){
	cust.action=changeURLPar(custAction, 'action', 'moveAll');
	return true;
	}
	else {
	 return false;
	}
		
}else if(object.id=='copyAll'){
	if (count>0){
	cust.action=changeURLPar(custAction, 'action', 'copyAll');
	return true;
	}else {
		return false;
	}
}else if(object.id == 'disableAll'){
	if (count > 0){
		cust.action = changeURLPar(custAction, 'action', 'disableAll');
		return true;
	}else{
		return false;		
	}
}else if(object.id == 'listAll'){
	if (count > 0){
		cust.action = changeURLPar(custAction, 'action', 'listAll');
		return true;
	}else{
		return false;		
	}
}else if(object.id == 'unListAll'){
	if (count > 0){
		cust.action = changeURLPar(custAction, 'action', 'unListAll');
		return true;
	}else{
		return false;		
	}
}
else{
	return false;
}

}
//bof added by zale 2012 03 09
function checkip(form){
	var len = form.elements.length;
	
	form.elements[0].value = (form.elements[0].value).replace(' ','');
	form.elements[1].value = (form.elements[1].value).replace(' ','');
	form.elements[2].value = (form.elements[2].value).replace(' ','');
	form.elements[3].value = (form.elements[3].value).replace(' ','');
	if(form.elements[0].value == '' && form.elements[1].value == '' && form.elements[2].value == '' && form.elements[3].value == ''){
		form.elements[0].focus();
		return false;
	}
	for(var i=0; i<len; i++){
		if(form.elements[i].value == ''){
			continue;
		}
		if(check_quarter_ip(form.elements[i].value)){
			form.elements[i].value = '';
			form.elements[i].focus();
			return false;
		}	
	}
	return true;
}
function check_quarter_ip(val){
	val = parseInt(val,10);
	return (isNaN(val) || val > 255 || val < 0);
}
//eof added by zale 2012 03 09

function delete_selected_orders(){
	var checked = false;
	var checkbox = document.getElementsByName("ordersCheckbox[]");
	for(var i=0; i<checkbox.length; i++){
		if(checkbox[i].checked){
			checked = true;
		}
	}
	if(checked){
		if(confirm('Are you sure you want to delete them?')){
			return true;
		}
	}else{
		alert('Please select at least one order!');
	}
	return false;
}
function check_discount_note_form(){
    var discount_note_text=$.trim($('#discount_note_text').val());
	var errorflag = false;
	var errormessage = '';
	if(discount_note_text == ''){
		errorflag = true;
		errormessage += '备注不能为空\n';
		
	}else if(discount_note_text.length > 200){
		errorflag = true;
		errormessage += '最大为200个字符\n';
	}
	if(errorflag){
		alert(errormessage);
		return false;
	}
}