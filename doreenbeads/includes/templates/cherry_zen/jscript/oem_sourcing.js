
$j(function(){
	var num = $j('#pid').val();
	if(num != ''){
		$j("#oem_title_link").hide();
		$j('.pro_details').show();
		$j('#oem_product_title').html($lang.TEXT_PRODUCT_NAME);
	}else{
		$j("#oem_title_link").show();
		$j('.pro_details').hide();
	}

	/*replace whih placeholder and maxlength */
	/*$j("#oem_title_link").keydown(function(){
		$j('#error1 > td').html('');
		if(this.value == $lang.TEXT_WHY_DO_YOU_WANT_TO_BUY){
			this.value = '';
		}
	});		
	
	$j("#oem_title_link").keyup(function(){
		if(this.value == ''){
			this.value = $lang.TEXT_WHY_DO_YOU_WANT_TO_BUY;
		}
		if(this.value == $lang.TEXT_WHY_DO_YOU_WANT_TO_BUY){
			$j("#oem_title_link").css('color','#999');			
		}else{
			$j("#oem_title_link").css('color','#333');
		}
		if($j(this).val().length>500){
			$j(this).val($j(this).val().substr(0,500));
		}
	});*/

	$j("#email").keydown(function(){
		$j('#error3 > td').html('');
	});

	$j("#name").keydown(function(){
		$j('#error4 > td').html('');
	});


	$j("#oem_change").click(function(){
		$j('.pro_details').hide();
		$j("#oem_title_link").show();
		$j('#pid').val('');
		$j('#products_link').val('');
		$j('#oem_product_title').html($lang.TEXT_PRODUCT_NAME_OR_LINK);
	});
	/*var customer_id = $j('#customer_id').val();
	var is_login = false;
	if(customer_id){
		//$j('#email_tr').hide();
		//$j('#name_tr').hide();	
		is_login = true;
	}else{
		$j('#email_tr').show();
		$j('#name_tr').show();
	}*/

	$j('.btn_p30').bind('click',function(){
		var num = $j('#pid').val();
		var textarea   = $j(window.frames["iframe_a"].document).find("#textarea").val();
		var email      = $j("#email").val();
		var name	   = $j("#name").val();
		var langs = $j("#c_lan").val();
		var error = true;
		var error_info;
		$j("#login_checkcode_error").text('');

		switch(langs){
			case 'english':
				error_info = 'Please input right validate code!';
				break;
			case 'german':
				error_info = 'Ungleicher Sicherheitscode!';
				break;
			case 'russian':
				error_info = 'Пожалуйста, введите правильный код!';
				break;
			case 'french':
				error_info = 'Saisissez le code correct et valide!';
				break;
			case 'spanish':
				error_info = 'Por favor ingrese correctamente el código de validación!';
				break;
			case 'japanese':
				error_info = '正しい検証コードを入力してください。';
				break;
			case 'italian':
				error_info = 'Si prega di inserire il codice esatto !';
				break;
			default :
				error_info = 'Please input right validate code!';
		}
		if(num == ''){
			var title_link = $j("#oem_title_link").val();
			if($j.trim(title_link) == '' || title_link == $lang.TEXT_WHY_DO_YOU_WANT_TO_BUY){
				$j('#error1 > td').html($lang.TEXT_WRONG_PRODUCT_NAME);
				error = false;
			}
		}

		$j('#hidden_textarea').val(textarea);

		if($j.trim(textarea) == ''){
			$j('#error2 > td').html($lang.TEXT_ENTER_PRODUCT_OF_YOU_WANT);
			error = false;
		}

		var email_address = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
		//if(!is_login){
		if($j.trim(email) == ''){
			$j('#error3 > td').html($lang.TEXT_EMAIL_REQUIRED).show();
			error = false;
		}else{
			if(!email_address.test($j.trim(email))){
				$j('#error3 > td').html($lang.TEXT_INVALID_EMAIL).show();
				error = false;
			}
		}

		//}

		if($j.trim(name) ==''){
			$j('#error4 > td').html($lang.TEXT_ENTER_YOUR_NAME).show();
			error = false;
		}

		if($j('#check_code_input').length > 0){
			var form_code = $j('#check_code_input').val().toLowerCase();

			if(form_code.length == 0){
				error = false;
				$j("#login_checkcode_error").text(error_info);
			}else{
				$j.ajax({
					url: './checkCode.php',
					type: 'POST',
					async: false,
					data: {form_code: form_code},
					success: function(data){
						if(data.length > 0){
							$j("#login_checkcode_error").text(error_info);
							error = false;
						}
					}
				});
			}
		}

		return error;
	});



	var i=0;

	$j('.loading_oem_a').live('click',function(){
		$j(this).parent().html('');
	});

	var uploader = new plupload.Uploader({
		browse_button : 'browse', //用此id触发对象
		url : 'image_upload.php?Action=oem_file', //上传到php页面进行处理
		flash_swf_url : './plupload/js/Moxie.swf',
		silverlight_xap_url : './plupload/js/Moxie.xap',
		max_file_size : '2MB',
		//prevent_duplicates : true,  //不允许选取重复文件
		filters: {
			mime_types : [ //限制上传文件的类型 图片/视频
				{ title : "Image files", extensions : "jpg,gif,png,bmp,jpeg" },
				{ title : "Doc files", extensions : "doc,docx" },
			],
		}
	});
	//使用init()方法进行初始化
	uploader.init();
	//绑定各种事件，实现所需功能
	uploader.bind('Error', function(up, err) {
		var message, details = "";

		message = '<strong>' + err.message + '</strong>';

		switch (err.code) {
			case plupload.FILE_EXTENSION_ERROR:
				//details = o.sprintf(("File: %s"), err.file.name);
				details = $lang.TEXT_FILE_FOEMAT_NOT_SUPPORTED;
				break;

			case plupload.FILE_SIZE_ERROR:
				//details = o.sprintf(("File: %s, size: %d, max file size: %d"), err.file.name,  plupload.formatSize(err.file.size), plupload.formatSize(plupload.parseSize(up.getOption('filters').max_file_size)));
				details = 'The size of the attachment should be less than 2M.';
				break;

			case plupload.FILE_DUPLICATE_ERROR:
				details = o.sprintf(("%s already present in the queue."), err.file.name);
				break;

			case self.FILE_COUNT_ERROR:
				details = o.sprintf(("Upload element accepts only %d file(s) at a time. Extra files were stripped."), up.getOption('filters').max_file_count || 0);
				break;

			case plupload.IMAGE_FORMAT_ERROR :
				details = ("Image format either wrong or not supported.");
				break;

			case plupload.IMAGE_MEMORY_ERROR :
				details = ("Runtime ran out of available memory.");
				break;

			/* // This needs a review
			case plupload.IMAGE_DIMENSIONS_ERROR :
				details = o.sprintf(_('Resoultion out of boundaries! <b>%s</b> runtime supports images only up to %wx%hpx.'), up.runtime, up.features.maxWidth, up.features.maxHeight);
				break;	*/

			case plupload.HTTP_ERROR:
				details = ("Upload URL might be wrong or doesn't exist.");
				break;
		}

		message += " <br /><i>" + details + "</i>";

		// do not show UI if no runtime can be initialized
		if (err.code === plupload.INIT_ERROR) {
			setTimeout(function() {
				//self.destroy();
			}, 1);
		} else {
			//alert(details);
			$j(".edit_warning").html(details).show();
		}
	});

	uploader.bind('FilesAdded',function(uploader,files){
		console.log(files);
		uploader.start();
	});
	uploader.bind('FileUploaded',function(uploader,file,obj){
		//var return_info = process_json(obj.response);
		console.log(file);
		showAttachmentFile(file.name, obj.response, file.size, 'oem_file_loading_oem');
	});

});

function process_json(data){
	if(typeof(JSON)=='undefined'){
		var returnInfo=eval('('+data+')');
	}else{
		var returnInfo=JSON.parse(data);
	}
	return returnInfo;
}

function ShowMessage(Msg,UploadingTipId) {
	alert(Msg);
	var uploadingTip = $j("#" + UploadingTipId).html();
	if (uploadingTip.length > 0) {
		$j("#" + UploadingTipId).html("");
	}
}

function showUploadingFile(FileName,UploadingTipId) {
	//$j("#" + UploadingTipId).html("<img  width='20'  width='20' src='includes/templates/cherry_zen/images/zen_loader.gif'>");
	$j("#" + UploadingTipId).show();
}

function showAttachmentFile(FileName,NewFileName,FileSize,UploadingTipId) {
	var file_parse = process_json(NewFileName);
	//console.log(file_parse);
	if(file_parse.error == true){
		alert('upload failed');
	}else{
		count = parseInt($j("#oem_count").val());
		if(count >=3){
			$j(".edit_warning").html($lang.TEXT_ONLY_THREE_FILE_AT_MOST);
			$j(".edit_warning").show();
			return false;
		}
		var file = file_parse.data;
		$j("#" + UploadingTipId).append('<div ><p style="float:left">'+ FileName +'</p>&nbsp;&nbsp;&nbsp;&nbsp;<a class="loading_oem_a" style="color:blue" href="javascript:void(0)" onclick="del_file(\''+UploadingTipId+'\');">'+$lang.TEXT_REMOVE+'</a><input type="hidden" value="'+file.original_attachment_name+'"  name="original_attachment_name_'+count+ '"><input type="hidden" name="attachment_name_'+count+'" value="'+file.attachment_name+'"><input type="hidden" name="attachment_link_'+count+'" value="'+file.attachment_link+'"></div>');
		$j("#oem_" + UploadingTipId).val(NewFileName);
		$j(".edit_warning").hide();
		count+=1;
		$j("#oem_count").val(count);
		$j('#oem_loading_oem').val(file_parse.error);
	}
}

function del_file(UploadingTipId){
	//$j("#" + UploadingTipId).html('');
	//$j("#oem_file_" + UploadingTipId).show();

	file_name = $j("#oem_" + UploadingTipId).val();
	$j.post('./image_upload.php',{action:""+"delete_tmp"+"",fname:""+file_name+""},function(data){
		if(data == ''){

		}
		count = parseInt($j("#oem_count").val());
		count-=1;
		if(count < 3){
			$j(".edit_warning").hide();
		}
		$j("#oem_count").val(count)
	});
}


function show_iframe(){
	$j(window.frames["iframe_a"].document).find("#textarea").bind('keyup',function(){
		$j('#error2 > td').html('');
		var a = $j(this).val();
		if(a.length>3000){
			$j(this).val(a.substr(0,3000));
		}
	});
}

$j(function(){
	$j('.jq_custom_made').click(function(){
		$j(this).siblings().removeClass('selected');
		$j(this).addClass('selected');
		$j('.jq_show_custom').show();
		$j('.jq_show_product').hide();
		$j('.jq_show_packed').hide();
		$j('.sourcing_detail').show();
		$j('input[name=oem_type]').val('20');
	});

	$j('.jq_repack_process').click(function(){
		$j(this).siblings().removeClass('selected');
		$j(this).addClass('selected');
		$j('.jq_show_packed').show();
		$j('.jq_show_product').hide();
		$j('.jq_show_custom').hide();
		$j('.sourcing_detail').hide();
	});
	$j('.jq_product_souring').click(function(){
		$j(this).siblings().removeClass('selected');
		$j(this).addClass('selected');
		$j('.jq_show_product').show();
		$j('.jq_show_packed').hide();
		$j('.jq_show_custom').hide();
		$j('.sourcing_detail').show();
		$j('input[name=oem_type]').val('10');
	});
});	