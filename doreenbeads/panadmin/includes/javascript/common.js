//多个空格替换成一个空格
String.prototype.clearSpace = function () {
    return this.replace(/\s+/g, "");
};
//多个空格替换成一个空格
String.prototype.trimSpace = function () {
    return this.replace(/\s+/g, " ");
};
//清除左右空格
String.prototype.trim = function () {
    return this.replace(/(^\s*)|(\s*$)/g, "");
};
//清除左空格
String.prototype.lTrim = function () {
    return this.replace(/(^\s*)/g, "");
};
//清除右空格
String.prototype.rTrim = function () {
    return this.replace(/(\s*$)/g, "");
};
//替换所有
String.prototype.replaceAll = function (source, target, ignoreCase) {
    if (ignoreCase == null) {
        ignoreCase = false;
    }
    source = source.replace(/([\\.$^{[(|)*+?\\\\])/g, "\\$1");
    if (!RegExp.prototype.isPrototypeOf(source)) {
        return this.replace(new RegExp(source, (ignoreCase ? "gi" : "g")), target);
    } else {
        return this.replace(source, target);
    }
};
//C#格式化字符串
String.prototype.format = function () {
    if (arguments == null || arguments.length == 0) {
        return this;
    }
    var s = this;
    for (var i = 0, len = arguments.length; i < len; i++) {
        s = s.replaceAll("{" + i.toString() + "}", arguments[i].toString());
    }
    return s;
};
//Url参数设置
String.prototype.urlReplaceParmeter = function (parmeterName, parmeterVlaue) {
    var url = this, pIndex = url.indexOf(parmeterName);
    if (pIndex > -1) {
        var endIndex = url.indexOf("&", pIndex);
        if (endIndex == -1) {
            endIndex = url.length;
        }
        var str = url.substring(pIndex, endIndex);
        return url.replace(str, "{0}={1}".format(parmeterName, parmeterVlaue));
    } else {
        if (this.indexOf("?") > -1) {
            return (url + "&{0}={1}").format(parmeterName, parmeterVlaue);
        } else {
            return (url + "?{0}={1}").format(parmeterName, parmeterVlaue);
        }
    }
};
//字符串是否为空(空、undefined、null)
String.prototype.isEmpty = function () {
    return this == "" || this == undefined || this == null;
};
// 返回字符串的实际长度, 一个汉字算2个长度  
String.prototype.strlen = function () {
    return this.replace(/[^\x00-\xff]/g, "**").length;
};
//字符串超出长度则省略 
String.prototype.cutstr = function (len) {
    var restr = this;
    var wlength = this.replace(/[^\x00-\xff]/g, "**").length;
    if (wlength > len) {
        for (var k = len / 2; k < this.length; k++) {
            if (this.substr(0, k).replace(/[^\x00-\xff]/g, "**").length >= len) {
                restr = this.substr(0, k) + "...";
                break;
            }
        }
    }
    return restr;
};
//判断是否以某个字符串开头 
String.prototype.startWith = function (s) {
    return this.indexOf(s) == 0;
};
//判断是否以某个字符串结束 
String.prototype.endWith = function (s) {
    var d = this.length - s.length;
    return (d >= 0 && this.lastIndexOf(s) == d);
};

Date.prototype.format =function(format)
{
	var o = {
	"M+" : this.getMonth()+1, //month
	"d+" : this.getDate(), //day
	"h+" : this.getHours(), //hour
	"H+" : this.getHours(), //hour
	"m+" : this.getMinutes(), //minute
	"s+" : this.getSeconds(), //second
	"q+" : Math.floor((this.getMonth()+3)/3), //quarter
	"S" : this.getMilliseconds() //millisecond
	}
if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
(this.getFullYear()+"").substr(4- RegExp.$1.length));
for(var k in o)if(new RegExp("("+ k +")").test(format))
format = format.replace(RegExp.$1,
RegExp.$1.length==1? o[k] :
("00"+ o[k]).substr((""+ o[k]).length));
return format;
}

//**Common类**
var Common = {
    AntiForgeryToken: "__RequestVerificationToken"
};
//  验证
Common.Validator = {
    isEmail: function (str) {
        var strReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return strReg.test(str);
    }, isNaturalNumber: function (s) {
        //验证非０开头的正整数，可以为0．（既自然数）
        var reg = /^(([0-9]){1}|[1-9]\d*)$/;
        return reg.test(s);
    }, isPositiveNum: function (s) {
        //验证非0开头且大于0的正整数
        var reg = /^[1-9]\d*$/;
        return reg.test(s);
    }, isParseFloat: function (s) {
        //验证包含小数位的金额（允许输入整数、一位小数以及两位小数）
        var reg = /^((\d{1,}\.\d{2,2})|(\d{1,}\.\d{1,1})|(\d{1,}))$/;
        return reg.test(s);
    }, isNumber: function (s) {
        if (s == "") {
            return false;
        }
        return !isNaN(s);
    }, isFloatNum: function (s) {
        var reg = /^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$/;
        return reg.test(s);
    }, isPwd: function (str) {
        var strReg = /^[A-Za-z0-9]{6,20}$/;
        return strReg.test(str);
    }
};
//  获取键盘key值
Common.getKeyCode = function (e) {
    var evt = e || window.event;
    return evt.keyCode || evt.which || evt.charCode;
};
//  只允许输入数字 
Common.onlyNumber = function (sender, e) {
    var keyCode = Common.getKeyCode(e);
    if (keyCode == 48 || keyCode == 96) {
        if (sender.value != "") {
            return true;
        }
    } else {
        if (keyCode == 8 || keyCode == 9 || keyCode == 37 || keyCode == 39) {
            return true;
        } else {
            if (keyCode > 95 && keyCode < 106) {
                return true;
            } else {
                if (keyCode > 47 && keyCode < 58) {
                    return true;
                }
            }
        }
    }
    return false;
};
//  验证是否为IE浏览器
Common.isIE = function () {
    return document.all ? true : false;
};
//  切换显示文本默认提示
Common.IePlaceholder = function (fieldsObj) {
    if (Common.isIE()) {
        var txtItems = fieldsObj != undefined ? fieldsObj : $("[placeholder]");
        txtItems.each(function () {
            var inputs = $(this);
            var placeText = inputs.attr("placeholder");
            inputs.attr("placeholder", "")
            var inputText = $.trim(inputs.val());
            if (inputText.length < 1 || inputText.toLowerCase() === placeText.toLowerCase()) {
                inputs.addClass("txtTips").val(placeText);
            }
            inputs.focus(function () {
                var _e = $(this);
                inputs.attr("placeholder", "")
                var _inputText = $.trim(_e.val());
                if (_inputText.length < 1 || _inputText.toLowerCase() === placeText.toLowerCase()) {
                    _e.removeClass("txtTips").val("");
                }
            }).blur(function () {
                var _e = $(this);
                var _inputText = $.trim(_e.val());
                if (_inputText.length < 1 || _inputText.toLowerCase() === placeText.toLowerCase()) {
                    _e.addClass("txtTips").val(placeText);
                }
                inputs.attr("placeholder", placeText)
            });
        });
    }
};
//  加入收藏夹 
Common.AddFavorite = function (sURL, sTitle) {
    try {
        window.external.addFavorite(sURL, sTitle);
    } catch (e) {
        try {
            window.sidebar.addPanel(sTitle, sURL, "");
        } catch (e) {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
};
//  设为首页 
Common.setHomepage = function (homeurl) {
    if (document.all) {
        document.body.style.behavior = 'url(#default#homepage)';
        document.body.setHomePage(homeurl);
    } else if (window.sidebar) {
        if (window.netscape) {
            try {
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
            } catch (e) {
                alert("该操作被浏览器拒绝，如果想启用该功能，请在地址栏内输入about:config,然后将项 signed.applets.codebase_principal_support 值该为true");
            }
        }
        var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
        prefs.setCharPref('browser.startup.homepage', homeurl);
    }
};
//  随机数时间戳 
Common.uniqueId = function () {
    var a = Math.random, b = parseInt;
    return Number(new Date()).toString() + b(10 * a()) + b(10 * a()) + b(10 * a());
}

//Ajax附加AntiForgeryToken令牌
$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
    if (options.type.toUpperCase() === "POST") {
        // We need to add the verificationToken to all POSTs
        var tokenName = Common.AntiForgeryToken;
        var tokens = $("input[name^=" + tokenName + "]");
        var token = null;
        if (!tokens.length) return;
        tokens.each(function () {
            if (!$(this).val().isEmpty()) {
                token = $(this);
                return false;
            }
        });

        if (token == null) {
            return;
        }

        // If the data is JSON, then we need to put the token in the QueryString:
        if (options.contentType.indexOf('application/json') === 0) {
            // Add the token to the URL, because we can't add it to the JSON data:
            options.url += ((options.url.indexOf("?") === -1) ? "?" : "&") + token.serialize();
        } else if (typeof options.data === 'string' && options.data.indexOf(tokenName) === -1) {
            // Append to the data string:
            options.data += (options.data ? "&" : "") + token.serialize();
        }
    }
});

//**扩展jQuery**
(function ($) {
    jQuery.fn.extend({
        //参数childrenChkName：单个复选的name， 使用例如：$(":checkbox[name=ChooseAll]").ChooseAll("childrenChkName")
        ChooseAll: function (childrenChkName) {
            var sender = $(this);
            sender.click(function () {
                var isChecked = $(this).attr("checked");
                jQuery(":checkbox[name=" + childrenChkName + "]:not(:disabled)").attr({ checked: isChecked });
                sender.attr({ checked: isChecked });
            });
            jQuery(":checkbox[name=" + childrenChkName + "]").click(function () {
                var isChecked = $(this).attr("checked");
                var checkedCount = jQuery(":checkbox[name=" + childrenChkName + "]:checked,:checkbox[name=" + childrenChkName + "]:disabled").size();
                var totalCount = jQuery(":checkbox[name=" + childrenChkName + "]").size();
                if (checkedCount == totalCount) {
                    sender.attr({ checked: true });
                } else {
                    sender.attr({ checked: false });
                }
                ;
            })
        },
        //获取选中的checkbox的值,返回值以逗号分隔的字符串值. 使用例如：var value = $(":checkbox[name=checkboxName]").GetChooseVal()
        GetChooseVal: function () {
            var chooseCheckbox = jQuery(this).filter(":checked");
            var chkValArr = jQuery.map(chooseCheckbox, function (item) {
                return jQuery(item).val();
            });
            return chkValArr.toString();
        },
        //判断是否有选中的数据 返回true or false
        IsCheck: function () {
            var thisObj = jQuery(this);
            var flag = false;
            thisObj.each(function () {
                if ($(this).attr("checked") == true) {
                    flag = true;
                    return;
                }
            });
            return flag;
        }
    });
    $.extend({}); 
})(jQuery);

$(function(){ 
	//复制文本到剪切板  
    if (window.clipboardData){
    	$(".copytoclipboard").click(function(){ 
			window.clipboardData.setData("Text",$('#'+$(this).attr('data-clipboard-target')).val()); 
			alert('复制成功!');
		});
	}else{  
		if($(".copytoclipboard").size()>0)
		{
			 ZeroClipboard.config({swfPath: "includes/javascript/ZeroClipboard.swf"});
			 
			$(".copytoclipboard").each(function(){ 
			     var client = new ZeroClipboard($(this));
			     
				 client.on("ready", function(readyEvent){ 
				    client.on("beforecopy", function(event){
				    	
					});
					client.on("aftercopy", function(event){
						//复制成功后事件
						alert('复制成功!');
					});
				 }); 
			});
		}
	}
});

//**Datatype类**
var DataType = {};
//  验证是否email格式
DataType.isEmail = function (s) {
    var strReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return strReg.test(s);
};
//  验证非０开头的正整数，可以为0．（既自然数）
DataType.isNaturalNumber = function (s) {
    var reg = /^(([0-9]){1}|[1-9]\d*)$/;
    return reg.test(s);
};
//  验证非0开头且大于0的正整数
DataType.isPositiveNum = function (s) {
    var reg = /^[1-9]\d*$/;
    return reg.test(s);
};
//  验证包含小数位的金额（允许输入整数、一位小数以及两位小数）
DataType.isParseFloat = function (s) {
    var reg = /^((\d{1,}\.\d{2,2})|(\d{1,}\.\d{1,1})|(\d{1,}))$/;
    return reg.test(s);
};
//  验证数字
DataType.isNumber = function (s) {
    if (s == "") {
        return false;
    }
    return !isNaN(s);
};
//  验证浮点数
DataType.isFloatNum = function (s) {
    var reg = /^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$/;
    return reg.test(s);
};
//  验证密码格式
DataType.isPwd = function (s) {
    var strReg = /^[A-Za-z0-9]{6,20}$/;
    return strReg.test(s);
};
//  只允许输入数字 
DataType.onlyNumber = function (sender, e) {
    var keyCode = Common.getKeyCode(e);
    if (keyCode == 48 || keyCode == 96) {
        if (sender.value != "") {
            return true;
        }
    } else {
        if (keyCode == 8 || keyCode == 9 || keyCode == 37 || keyCode == 39) {
            return true;
        } else {
            if (keyCode > 95 && keyCode < 106) {
                return true;
            } else {
                if (keyCode > 47 && keyCode < 58) {
                    return true;
                }
            }
        }
    }
    return false;
};

//yyyy-M-d或yyyy-MM-dd
DataType.isDate = function IsDate(strDate) 
{ 
    // 先判断格式上是否正确 
    var regDate = /^(\d{4})-(\d{1,2})-(\d{1,2})$/; 
    if (!regDate.test(strDate)) 
    { 
        return false; 
    } 
     
    // 将年、月、日的值取到数组arr中，其中arr[0]为整个字符串，arr[1]-arr[3]为年、月、日 
    var arr = regDate.exec(strDate); 
     
    // 判断年、月、日的取值范围是否正确 
    return DataType.isMonthAndDateCorrect(arr[1], arr[2], arr[3]); 
} 

//yyyy-M-d H:m:s或yyyy-MM-dd HH:mm:ss
DataType.isDateTime = function IsDateTime(strDateTime) 
{ 
    // 先判断格式上是否正确 
    var regDateTime = /^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/; 
    if (!regDateTime.test(strDateTime)) 
        return false; 
         
    // 将年、月、日、时、分、秒的值取到数组arr中，其中arr[0]为整个字符串，arr[1]-arr[6]为年、月、日、时、分、秒 
    var arr = regDateTime.exec(strDateTime); 
     
    // 判断年、月、日的取值范围是否正确 
    if (!DataType.isMonthAndDateCorrect(arr[1], arr[2], arr[3])) 
        return false; 
         
    // 判断时、分、秒的取值范围是否正确 
    if (arr[4] >= 24) 
        return false; 
    if (arr[5] >= 60) 
        return false; 
    if (arr[6] >= 60) 
        return false; 
     
    // 正确的返回 
    return true; 
} 
 
// 判断年、月、日的取值范围是否正确 
DataType.isMonthAndDateCorrect = function IsMonthAndDateCorrect(nYear, nMonth, nDay) 
{ 
    // 月份是否在1-12的范围内，注意如果该字符串不是C#语言的，而是JavaScript的，月份范围为0-11 
    if (nMonth > 12 || nMonth <= 0) 
        return false; 
 
    // 日是否在1-31的范围内，不是则取值不正确 
    if (nDay > 31 || nMonth <= 0) 
        return false; 
     
    // 根据月份判断每月最多日数 
    var bTrue = false; 
    switch(nMonth) 
    { 
        case 1: 
        case 3: 
        case 5: 
        case 7: 
        case 8: 
        case 10: 
        case 12: 
            bTrue = true;    // 大月，由于已判断过nDay的范围在1-31内，因此直接返回true 
            break; 
        case 4: 
        case 6: 
        case 9: 
        case 11: 
            bTrue = (nDay <= 30);    // 小月，如果小于等于30日返回true 
            break; 
    } 
     
    if (!bTrue) 
        return true; 
     
    // 2月的情况 
    // 如果小于等于28天一定正确 
    if (nDay <= 28) 
        return true; 
    // 闰年小于等于29天正确 
    if (IsLeapYear(nYear)) 
        return (nDay <= 29); 
    // 不是闰年，又不小于等于28，返回false 
    return false; 
} 
 
// 是否为闰年，规则：四年一闰，百年不闰，四百年再闰 
DataType.isLeapYear =  function IsLeapYear(nYear) 
{ 
    // 如果不是4的倍数，一定不是闰年 
    if (nYear % 4 != 0) 
        return false; 
    // 是4的倍数，但不是100的倍数，一定是闰年 
    if (nYear % 100 != 0) 
        return true; 
     
    // 是4和100的倍数，如果又是400的倍数才是闰年 
    return (nYear % 400 == 0); 
}  

//**Cookie类**
var Cookie = {};
//  写入Cookie，key为键，value是值，duration过期时间（天为单位，默认1天）
Cookie.set = function (key, value, duration) {
    Cookie.remove(key);
    var d = new Date();
    if (duration <= 0)
        duration = 1;
    d.setDate(d.getDay() + duration);
    document.cookie = key + "=" + encodeURI(value) + "; expires=" + d.toGMTString() + ";path=/";
};
//  移除Cookie，key为键
Cookie.remove = function (key) {
    var d = new Date();
    if (Cookie.read(key) != "") {
        d.setDate(d.getDay() - 1);
        document.cookie = key + "=;expires=" + d.toGMTString();
    }
};
//  读取Cookie，key是键
Cookie.get = function (key) {
    var arr = document.cookie.match(new RegExp("(^| )" + key + "=([^;]*)(;|$)"));
    if (arr != null) {
        return decodeURIComponent(arr[2]);
    }
    return "";
};


function formatStr() {
    var ary = [];
    for (var i = 1 ; i < arguments.length ; i++) {
        ary.push(arguments[i]);
    }
    return arguments[0].replace(/\{(\d+)\}/g, function (m, i) {
        return ary[i];
    });
}  


function parseToJson(data){
	if(typeof(JSON)=='undefined'){
		return eval('('+data+')');
	}else{
		return JSON.parse(data);	
	}
}

function bind( obj, type, fn ) {
	if ( obj.attachEvent ) {
	obj['e'+type+fn] = fn;
	obj[type+fn] = function(){obj['e'+type+fn]( window.event );}
	obj.attachEvent( 'on'+type, obj[type+fn] );
	} else
	obj.addEventListener( type, fn, false );
 } 

function copyToClipboard(txt) {  
	
	if (window.clipboardData){
		 window.clipboardData.clearData();   
         window.clipboardData.setData("Text", txt);   
	}else{
		 ZeroClipboard.setMoviePath( 'ZeroClipboard.swf' );
		 var clip = new ZeroClipboard.Client();   //创建新的Zero Clipboard对象

		 bind(window, "resize", function(){ 
			 clip.reposition(); 
		 }); 

	
		 clip.setHandCursor( true );      //设置鼠标移到复制框时的形状
		 clip.setCSSEffects( true );      //启用css 
		 clip.setText(''); // will be set later on mouseDown   //清空剪贴板
		 clip.addEventListener( 'mouseDown', function(client) {
		 	clip.setText(txt);
		 });	
		 clip.addEventListener( 'complete', function(client, text) {     //复制完成后的监听事件		 
	          //clip.hide();                                          // 复制一次后，hide()使复制按钮失效，防止重复计算使用次数
	     } ); 
	}
	
	alert("复制成功！");
	
	
//    if(window.clipboardData) {   
//            window.clipboardData.clearData();   
//            window.clipboardData.setData("Text", txt);   
//    } else if(navigator.userAgent.indexOf("Opera") != -1) {   
//         window.location = txt;   
//    } else if (window.netscape) {   
//         try {   
//              netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");   
//         } catch (e) {   
//              alert("复制到剪切板操作被浏览器拒绝！\n您可以先选中对应文本,同时按住 Ctrl + C 进行复制！\n您也可以在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'(高版本浏览器可能不支持)");   
//         }   
//         var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);   
//         if (!clip)   
//              return;   
//         var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);   
//         if (!trans)   
//              return;   
//         trans.addDataFlavor('text/unicode');   
//         var str = new Object();   
//         var len = new Object();   
//         var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);   
//         var copytext = txt;   
//         str.data = copytext;   
//         trans.setTransferData("text/unicode",str,copytext.length*2);   
//         var clipid = Components.interfaces.nsIClipboard;   
//         if (!clip)   
//              return false;   
//         clip.setData(trans,null,clipid.kGlobalClipboard);   
//         alert("复制成功！")   
//    }   
}