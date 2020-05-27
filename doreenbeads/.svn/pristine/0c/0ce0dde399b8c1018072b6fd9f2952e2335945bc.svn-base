$j(function(){
	 function bind( obj, type, fn ) {
		if ( obj.attachEvent ) {
		obj['e'+type+fn] = fn;
		obj[type+fn] = function(){obj['e'+type+fn]( window.event );}
		obj.attachEvent( 'on'+type, obj[type+fn] );
		} else
		obj.addEventListener( type, fn, false );
	 } 
	 var browser=navigator.appName;
		if (browser=="Microsoft Internet Explorer"){
			$j("#copy_btn").click(function(){ 
				var data = $j("#coupon_code").val();
				window.clipboardData.setData("Text",data);
			});
		}else{
			 ZeroClipboard.setMoviePath( 'includes/templates/cherry_zen/jscript/facebook_coupon/ZeroClipboard.swf' );
			 var clip = new ZeroClipboard.Client();   //创建新的Zero Clipboard对象
	
			 bind(window, "resize", function(){ 
				 clip.reposition(); 
			 }); 

		
			 clip.setHandCursor( true );      //设置鼠标移到复制框时的形状
			 clip.setCSSEffects( true );      //启用css 
			 clip.setText(''); // will be set later on mouseDown   //清空剪贴板
			 clip.addEventListener( 'mouseDown', function(client) {
			 	clip.setText($j("#coupon_code").val());
			 });	
			 clip.addEventListener( 'complete', function(client, text) {     //复制完成后的监听事件		
				$j("#copy_btn").css('background','#ccc');
		          //alert("aa")      
		          //clip.hide();                                          // 复制一次后，hide()使复制按钮失效，防止重复计算使用次数
		     } );
		     clip.glue('copy_btn');
		}
	
});