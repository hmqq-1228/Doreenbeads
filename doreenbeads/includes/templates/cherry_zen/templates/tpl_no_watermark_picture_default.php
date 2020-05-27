<div class="wrap sourcing">
	<!-- 头部开始 -->
	<div id="header">
	<?php echo '<input type="hidden" id="c_lan" value="'.$_SESSION['language'].'">';?>
		<div id="logo_new">
          <div class="logo" style="float:left;">
            <a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>"><?php echo zen_image ( DIR_WS_LANGUAGE_IMAGES . 'logo1.jpg' );?></a>
            <p class="font14"><a href="<?php echo HTTP_SERVER;?>/page.html?id=159"><?php echo TEXT_LOGO_TITLE;?></a></p>
            <!--WEBSITE_SUCCESS-->
          </div>
        </div>
		<div class="clearfix"></div>
		<p style="font-size:0.55em"></p>
	</div>	
	
	<div class="no_picture">
		<div class="np_banner">
			<h2><?php echo TEXT_NO_WATERMARK_SERVICE_TITLE; ?></h2>
			<p><?php echo TEXT_NO_WATERMARK_SERVICE_DESCRIPTION; ?></p>
		</div>
		
		<div class="service_detail">
			<div class="detail d_left">
				<img src="includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']?>/images/fs_title.jpg" />
				<p><?php echo TEXT_NO_WATERMARK_SERVICE_DETAIL; ?></p>
				<p class="note"><?php echo TEXT_NO_WATERMARK_SERVICE_NOTE; ?></p>
			</div>
			<div class="detail d_right">
				<img src="includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']?>/images/lcs_title.jpg" />
				<p><?php echo TEXT_NO_WATERMARK_SERVICE_VIP_DISCOUNT; ?></p>
				<p class="note"><?php echo TEXT_NO_WATERMARK_SERVICE_VIP_DISCOUNT_NOTE; ?></p>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<div class="np_title">
			<h3><?php echo TEXT_NO_WATERMARK_SERVICE_QUESTION; ?></h3>
			<img src="includes/templates/cherry_zen/css/<?php echo $_SESSION['languages_code']?>/images/process.jpg" />
		</div>
		<div class="np_title">
			<h3><?php echo TEXT_NO_WATERMARK_SERVICE_START; ?></h3>
			
			<div class="np_left"><a href="/file/products_images_mode.xlsx" class="np_btn"><?php echo TEXT_NO_WATERMARK_SERVICE_DOWNLOAD; ?></a></div>
			<div class="np_right"><a href="javascript:void(0);" class="np_btn np_upload"><?php echo TEXT_NO_WATERMARK_SERVICE_UPLOAD; ?></a></div>
			<div class="clearfix"></div>
		</div>
		<div class="np_title">
			<h3><?php echo TEXT_NO_WATERMARK_SERVICE_SUBMIT; ?></h3>
			<p class="np_require"><?php echo TEXT_NO_WATERMARK_SERVICE_SUBMIT_DESCRIPTION; ?></p>
		</div>
	</div>
	<div class="windowbody" style="display: none;"></div>
	<div id="upload_file_windows" style="display:none;">
		<div id="upload_file_title"><strong><?php echo TEXT_NO_WATERMARK_SERVICE_UPLOAD;?></strong><span></span></div>
		<div id="upload_file_content">
			<form action="<?php echo zen_href_link(FILENAME_NO_WATERMARK_PICTURE)?>" id="no_watermark_picture_form" enctype="multipart/form-data" method="post">
				<div><?php echo zen_draw_hidden_field('action', 'upload_file'); echo zen_draw_hidden_field('customers_id' , $_SESSION['customers_id']);?></div>
				<div style="font-size: 15px;"><?php echo TEXT_NO_WATERMARK_UPLOAD_LIMIT;?></div>
				<div id="upload_file_input"><?php echo zen_draw_file_field('products_mode_file')?></div>
				<div id="error_info"></div>
				<div style="text-align: center;"><button id="upload_file_button" type="submit" onClick="return check_form()"><?php echo TEXT_SUBMIT;?></button></div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
function check_form(){
	var error = false;
	var errorInfo = '';
	var filename = $j("input[name=products_mode_file]").val();
	$j("#upload_file_button").attr("disabled", "disabled");

	if(filename != ''){
		var fileArray = filename.split('.');
		var format = fileArray[1].toLocaleLowerCase();
		
		if(format == 'xlsx' || format == 'xls'){
			var formData = new FormData($j('form')[0]);
			formData.append('products_mode_file', $j(':file')[0].files[0]);
			formData.append('action', 'check_file');

			 $j.ajax({
				  url:'index.php?main_page=no_watermark_picture',
				  type: 'POST',
				  data: formData,
				  async:false,
				  contentType: false,
				  processData: false,
				  success:function(data){
					var data = process_json($j.trim(data));

					if(data.error == true){
						errorInfo = data.error_info;
						error = true;
					}
				  }
		     });
			
		}else{
			errorInfo = "<?php echo TEXT_NO_WATERMARK_UPLOAD_FILE_FORMAT_ERROR; ?>";
			error = true;
		}
	}else{
		errorInfo = "<?php echo TEXT_NO_WATERMARK_UPLOAD_FILE_EMPTY; ?>";
		error = true;
	}

	if(error){
		$j("#error_info").text(errorInfo);
		$j("#upload_file_button").attr("disabled", false);
	}else{
		$j("#error_info").text("<?php echo TEXT_SUBMIT_SUCCESS;?>");
		$j('#upload_file_windows').fadeOut(2000, function(){
			$j("#upload_file_windows").hide();
			$j("#no_watermark_picture_form").submit();
		});
	}
	
	return false;
}

$j(document).ready(function(){
	$j(".np_upload").click(function(){
		var customers_id = $j("input[name=customers_id]").val();

		if(customers_id != '' && customers_id > 0){
			$j(".windowbody").show();
			$j("#upload_file_windows").show();
		}else{
			window.location.href = "<?php echo zen_href_link(FILENAME_LOGIN)?>";
		}
		
	});

	$j("#upload_file_title span").click(function(){
		$j("#upload_file_windows").hide();
		$j(".windowbody").hide();
	});

	$j(".windowbody").click(function(){
		$j("#upload_file_windows").hide();
		$j(".windowbody").hide();
	});

});
</script>