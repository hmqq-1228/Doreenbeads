<script language="javascript" type="text/javascript">
//**让低版本浏览器支持placeholder**
var JPlaceHolder = {
	//检测
	_check: function () {
        return "placeholder" in document.createElement("input");
    },
    //初始化
    init: function () {
        if (!this._check()) {
            this.fix();
        }
    },
    //修复
    fix: function () {
        jQuery(":input[placeholder]").each(function (index, element) {
            var self = j(this), txt = self.attr("placeholder");
            //self.wrap($('<div></div>').css({ position: 'relative', zoom: '1', border: 'none', background: 'none', padding: 'none', margin: 'none' }));
            var pos = self.position(), h = self.outerHeight(true), paddingleft = self.css("padding-left");
            var holder = $("<span></span>").text(txt).css({ position: "absolute", left: pos.left, top: pos.top, height: h, lineHeight: h + "px", paddingLeft: paddingleft, color: "#aaa" }).appendTo(self.parent());
            self.focusin(function (e) {
                holder.hide();
            }).focusout(function (e) {
                if (!self.val()) {
                    holder.show();
                }
            });
            holder.click(function (e) {
                holder.hide();
                self.focus();
            });
        });
    }
};
$(document).ready(function(){
	JPlaceHolder.init();

	$("#send_btn").on('click', function(){
		var send_emails = $.trim($("#send_emails").val());
		$(".send_tips").hide();

		if(send_emails == ''){
			$(".send_tips#send_error_empty").show();
			$("#send_emails").focus();
			return false;
		}

		var arr = send_emails.split(",");
		var reg_address = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
		for(var i in arr){
			if(!reg_address.test($.trim(arr[i]))){
				$(".send_tips#send_error_wrong").show();
				$("#send_emails").focus();
				return false;
			}
		}

		$.post('/index.php?main_page=invite_friends&action=send', {send_emails:send_emails}, function(data){
			$(".send_tips#send_succ").show();
		});

		return true;
	});

});
</script>