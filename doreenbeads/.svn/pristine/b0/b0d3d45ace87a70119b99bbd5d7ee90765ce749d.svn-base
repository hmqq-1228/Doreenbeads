<?php
require('includes/application_top.php');
global $db;
define('SIZE_A', 500);
define('SIZE_B', 310);
define('SIZE_C', 130);
define('SIZE_D', 80);
ini_set('memory_limit','256M');
$water_img = 'images/watermark.png';
$src_folder = 'download/';
$dest_folder = 'bmz_cache/watermarkimg_new/';

if($_GET['action']=='water'){
	@set_time_limit(7200);

	$postfix_a = '_'.SIZE_A.'_'.SIZE_A.'.';
	$postfix_b = '_'.SIZE_B.'_'.SIZE_B.'.';
	$postfix_c = '_'.SIZE_C.'_'.SIZE_C.'.';
	$postfix_d = '_'.SIZE_D.'_'.SIZE_D.'.';

	$image_query = $db->Execute("select product_image_update_id,product_id ,product_model,product_image from t_product_image_update  where is_processed=0 and product_image!='//' order by product_id asc limit 200");
	$i=0;
	global $image_process_id;
	while(!$image_query->EOF){
		$image_process_id = $image_query->fields['product_image_update_id'];
		$success_cnt = 0;
		$products_model = $image_query->fields['product_model'];
		$products_image = $image_query->fields['product_image'];
		$image_name_arr = explode('.', $products_image);
		$postfix = $image_name_arr[sizeof($image_name_arr)-1];
		
		$products_image_a_tmp = str_replace('.'.$postfix ,'a.'.$postfix ,$products_image);
		$products_image_b_tmp = str_replace('.'.$postfix ,'b.'.$postfix ,$products_image);
		$products_image_c_tmp = str_replace('.'.$postfix ,'c.'.$postfix ,$products_image);
			
		$products_image_a = str_replace('.'.$postfix ,'A.'.$postfix ,$products_image);
		$products_image_b = str_replace('.'.$postfix ,'B.'.$postfix ,$products_image);
		$products_image_c = str_replace('.'.$postfix ,'C.'.$postfix ,$products_image);
	
		if(file_exists($products_image_a_tmp)){
			rename($src_folder.$products_image_a_tmp,$src_folder.$products_image_a);
		}else{
			$products_image_a_tmp = str_replace('JPG','jpg',$products_image_a_tmp);
			rename($src_folder.$products_image_a_tmp,$src_folder.$products_image_a);
		}
		
		if(file_exists($products_image_b_tmp)){
			rename($src_folder.$products_image_b_tmp,$src_folder.$products_image_b);
		}else{
			$products_image_b_tmp = str_replace('JPG','jpg',$products_image_b_tmp);
			rename($src_folder.$products_image_b_tmp,$src_folder.$products_image_b);
		}
		
		if(file_exists($products_image_c_tmp)){
			rename($src_folder.$products_image_c_tmp,$src_folder.$products_image_c);
		}else{
			$products_image_c_tmp = str_replace('JPG','jpg',$products_image_c_tmp);
			rename($src_folder.$products_image_c_tmp,$src_folder.$products_image_c);
		}
		
		$filesize_a = filesize($src_folder.$products_image_a.'')/1024;
		if($filesize_a == 0){
			$products_image_a = str_replace('JPG','jpg',$products_image_a);
			$filesize_a = filesize($src_folder.$products_image_a.'')/1024;	
			//$postfix = 'jpg';
		}			
	
		$filesize_b = filesize($src_folder.$products_image_b.'')/1024;
		if($filesize_b == 0){
			$products_image_b = str_replace('JPG','jpg',$products_image_b);
			$filesize_b = filesize($src_folder.$products_image_b.'')/1024;
			//$postfix = 'jpg';
		}
		
		$filesize_c = filesize($src_folder.$products_image_c.'')/1024;
		if($filesize_c == 0){
			$products_image_c = str_replace('JPG','jpg',$products_image_c);
			$filesize_c = filesize($src_folder.$products_image_c.'')/1024;
			//$postfix = 'jpg';
		}		
		
		if(file_exists($src_folder.$products_image_a) && (int)$filesize_a > 0){
			unlink($dest_folder.str_replace('.',$postfix_a,str_replace('jpg','JPG',$products_image_a)));
			unlink($dest_folder.str_replace('.',$postfix_b,str_replace('jpg','JPG',$products_image_a)));
			unlink($dest_folder.str_replace('.',$postfix_c,str_replace('jpg','JPG',$products_image_a)));
			unlink($dest_folder.str_replace('.',$postfix_d,str_replace('jpg','JPG',$products_image_a)));
			
			$res_a=watermark_imagick($src_folder.$products_image_a, $dest_folder.str_replace('.'.$postfix,$postfix_a.$postfix,str_replace('jpg','JPG',$products_image_a)), $water_img, SIZE_A, SIZE_A);
			watermark_imagick($src_folder.$products_image_a, $dest_folder.str_replace('.'.$postfix,$postfix_b.$postfix,str_replace('jpg','JPG',$products_image_a)), $water_img, SIZE_B, SIZE_B);
			watermark_imagick($src_folder.$products_image_a, $dest_folder.str_replace('.'.$postfix,$postfix_c.$postfix,str_replace('jpg','JPG',$products_image_a)), '', SIZE_C, SIZE_C);
			watermark_imagick($src_folder.$products_image_a, $dest_folder.str_replace('.'.$postfix,$postfix_d.$postfix,str_replace('jpg','JPG',$products_image_a)), '', SIZE_D, SIZE_D);
			if(!$res_a){
				$products_image_a.' is a bad pic<br/>';
			}else{
				$success_cnt++;
				$i++;
			}								
		}
			
		if(file_exists($src_folder.$products_image_b) &&(int)$filesize_b > 0){
			unlink($dest_folder.str_replace('.',$postfix_a,str_replace('jpg','JPG',$products_image_b)));
			unlink($dest_folder.str_replace('.',$postfix_b,str_replace('jpg','JPG',$products_image_b)));
			unlink($dest_folder.str_replace('.',$postfix_c,str_replace('jpg','JPG',$products_image_b)));
			unlink($dest_folder.str_replace('.',$postfix_d,str_replace('jpg','JPG',$products_image_b)));
			
			$res_b=watermark_imagick($src_folder.$products_image_b, $dest_folder.str_replace('.'.$postfix,$postfix_a.$postfix,str_replace('jpg','JPG',$products_image_b)), $water_img, SIZE_A, SIZE_A);
			watermark_imagick($src_folder.$products_image_b, $dest_folder.str_replace('.'.$postfix,$postfix_b.$postfix,str_replace('jpg','JPG',$products_image_b)), $water_img, SIZE_B, SIZE_B);
			watermark_imagick($src_folder.$products_image_b, $dest_folder.str_replace('.'.$postfix,$postfix_c.$postfix,str_replace('jpg','JPG',$products_image_b)), '', SIZE_C, SIZE_C);
			watermark_imagick($src_folder.$products_image_b, $dest_folder.str_replace('.'.$postfix,$postfix_d.$postfix,str_replace('jpg','JPG',$products_image_b)), '', SIZE_D, SIZE_D);
			if(!$res_b){
				$products_image_b.' is a bad pic<br/>';
			}else{
				$success_cnt++;
				$i++;
			}
		}
		if(file_exists($src_folder.$products_image_c) &&(int)$filesize_c > 0){
			unlink($dest_folder.str_replace('.',$postfix_a,str_replace('jpg','JPG',$products_image_c)));
			unlink($dest_folder.str_replace('.',$postfix_b,str_replace('jpg','JPG',$products_image_c)));
			unlink($dest_folder.str_replace('.',$postfix_c,str_replace('jpg','JPG',$products_image_c)));
			unlink($dest_folder.str_replace('.',$postfix_d,str_replace('jpg','JPG',$products_image_c)));
			
			$res_c=watermark_imagick($src_folder.$products_image_c, $dest_folder.str_replace('.'.$postfix,$postfix_a.$postfix,str_replace('jpg','JPG',$products_image_c)), $water_img, SIZE_A, SIZE_A);
			watermark_imagick($src_folder.$products_image_c, $dest_folder.str_replace('.'.$postfix,$postfix_b.$postfix,str_replace('jpg','JPG',$products_image_c)), $water_img, SIZE_B, SIZE_B);
			watermark_imagick($src_folder.$products_image_c, $dest_folder.str_replace('.'.$postfix,$postfix_c.$postfix,str_replace('jpg','JPG',$products_image_c)), '', SIZE_C, SIZE_C);
			watermark_imagick($src_folder.$products_image_c, $dest_folder.str_replace('.'.$postfix,$postfix_d.$postfix,str_replace('jpg','JPG',$products_image_c)), '', SIZE_D, SIZE_D);
			if(!$res_c){
				$products_image_c.' is a bad pic<br/>';
			}else{
				$success_cnt++;
				$i++;
			}
		}
		if($success_cnt>0){		
			$db->Execute("update t_product_image_update set is_processed=1, product_image_update_add_data ='".date('Y-m-d H:i:s')."' where product_image_update_id='".$image_query->fields['product_image_update_id']."'");
		}else{
			$db->Execute("update t_product_image_update set is_processed=1,product_image_update_type=2, product_image_update_add_data ='".date('Y-m-d H:i:s')."' where product_image_update_id='".$image_query->fields['product_image_update_id']."'");			
		}
		$image_query->MoveNext();
	}
}elseif($_GET['plist']!=''){
	$postfix_a = '_'.SIZE_A.'_'.SIZE_A.'.';
	$postfix_b = '_'.SIZE_B.'_'.SIZE_B.'.';
	$postfix_c = '_'.SIZE_C.'_'.SIZE_C.'.';
	$postfix_d = '_'.SIZE_D.'_'.SIZE_D.'.';
	$i=0;
	$pid_list = explode(',', $_GET['plist']);
  foreach($pid_list as $pid){
	$result = $db->Execute("select products_id ,products_model,products_image from t_products  where products_id = ".(int)$pid." limit 1");
	
	$products_model = $result->fields['products_model'];
	$products_image = $result->fields['products_image'];
	$image_name_arr = explode('.', $products_image);
	$postfix = $image_name_arr[sizeof($image_name_arr)-1];
	
	$products_image_a_tmp = str_replace('.'.$postfix ,'a.'.$postfix ,$products_image);
	$products_image_b_tmp = str_replace('.'.$postfix ,'b.'.$postfix ,$products_image);
	$products_image_c_tmp = str_replace('.'.$postfix ,'c.'.$postfix ,$products_image);
	
	$products_image_a = str_replace('.'.$postfix ,'A.'.$postfix ,$products_image);
	$products_image_b = str_replace('.'.$postfix ,'B.'.$postfix ,$products_image);
	$products_image_c = str_replace('.'.$postfix ,'C.'.$postfix ,$products_image);
	
  	if(file_exists($products_image_a_tmp)){
		rename($src_folder.$products_image_a_tmp,$src_folder.$products_image_a);
	}else{
		$products_image_a_tmp = str_replace('JPG','jpg',$products_image_a_tmp);
		rename($src_folder.$products_image_a_tmp,$src_folder.$products_image_a);
	}
		
	if(file_exists($products_image_b_tmp)){
		rename($src_folder.$products_image_b_tmp,$src_folder.$products_image_b);
	}else{
		$products_image_b_tmp = str_replace('JPG','jpg',$products_image_b_tmp);
		rename($src_folder.$products_image_b_tmp,$src_folder.$products_image_b);
	}
		
	if(file_exists($products_image_c_tmp)){
		rename($src_folder.$products_image_c_tmp,$src_folder.$products_image_c);
	}else{
		$products_image_c_tmp = str_replace('JPG','jpg',$products_image_c_tmp);
		rename($src_folder.$products_image_c_tmp,$src_folder.$products_image_c);
	}
	
	$filesize_a = filesize($src_folder.$products_image_a.'')/1024;
	if($filesize_a == 0){
		$products_image_a = str_replace('JPG','jpg',$products_image_a);
		$filesize_a = filesize($src_folder.$products_image_a.'')/1024;	
		//$postfix = 'jpg';
	}	
	
	$filesize_b = filesize($src_folder.$products_image_b.'')/1024;
	if($filesize_b == 0){
		$products_image_b = str_replace('JPG','jpg',$products_image_b);
		$filesize_b = filesize($src_folder.$products_image_b.'')/1024;
		//$postfix = 'jpg';
	}
	
	$filesize_c = filesize($src_folder.$products_image_c.'')/1024;
	if($filesize_c == 0){
		$products_image_c = str_replace('JPG','jpg',$products_image_c);
		$filesize_c = filesize($src_folder.$products_image_c.'')/1024;
		//$postfix = 'jpg';
	}
	
	if(file_exists($src_folder.$products_image_a) &&(int)$filesize_a > 0){
		unlink($dest_folder.str_replace('.',$postfix_a,str_replace('jpg','JPG',$products_image_a)));
		unlink($dest_folder.str_replace('.',$postfix_b,str_replace('jpg','JPG',$products_image_a)));
		unlink($dest_folder.str_replace('.',$postfix_c,str_replace('jpg','JPG',$products_image_a)));
		unlink($dest_folder.str_replace('.',$postfix_d,str_replace('jpg','JPG',$products_image_a)));
			
		$res_a=watermark_imagick($src_folder.$products_image_a, $dest_folder.str_replace('.'.$postfix,$postfix_a.$postfix,str_replace('jpg','JPG',$products_image_a)), $water_img, SIZE_A, SIZE_A);
		watermark_imagick($src_folder.$products_image_a, $dest_folder.str_replace('.'.$postfix,$postfix_b.$postfix,str_replace('jpg','JPG',$products_image_a)), $water_img, SIZE_B, SIZE_B);
		watermark_imagick($src_folder.$products_image_a, $dest_folder.str_replace('.'.$postfix,$postfix_c.$postfix,str_replace('jpg','JPG',$products_image_a)), '', SIZE_C, SIZE_C);
		watermark_imagick($src_folder.$products_image_a, $dest_folder.str_replace('.'.$postfix,$postfix_d.$postfix,str_replace('jpg','JPG',$products_image_a)), '', SIZE_D, SIZE_D);
		if(!$res_a){
			$products_image_a.' is a bad pic<br/>';
		}else{
			$i++;
		}
	}
		
	if(file_exists($src_folder.$products_image_b) &&(int)$filesize_b > 0){
		unlink($dest_folder.str_replace('.',$postfix_a,str_replace('jpg','JPG',$products_image_b)));
		unlink($dest_folder.str_replace('.',$postfix_b,str_replace('jpg','JPG',$products_image_b)));
		unlink($dest_folder.str_replace('.',$postfix_c,str_replace('jpg','JPG',$products_image_b)));
		unlink($dest_folder.str_replace('.',$postfix_d,str_replace('jpg','JPG',$products_image_b)));
			
		$res_b=watermark_imagick($src_folder.$products_image_b, $dest_folder.str_replace('.'.$postfix,$postfix_a.$postfix,str_replace('jpg','JPG',$products_image_b)), $water_img, SIZE_A, SIZE_A);
		watermark_imagick($src_folder.$products_image_b, $dest_folder.str_replace('.'.$postfix,$postfix_b.$postfix,str_replace('jpg','JPG',$products_image_b)), $water_img, SIZE_B, SIZE_B);
		watermark_imagick($src_folder.$products_image_b, $dest_folder.str_replace('.'.$postfix,$postfix_c.$postfix,str_replace('jpg','JPG',$products_image_b)), '', SIZE_C, SIZE_C);
		watermark_imagick($src_folder.$products_image_b, $dest_folder.str_replace('.'.$postfix,$postfix_d.$postfix,str_replace('jpg','JPG',$products_image_b)), '', SIZE_D, SIZE_D);
		if(!$res_b){
			$products_image_b.' is a bad pic<br/>';
		}else{
			$i++;
		}
	}
	if(file_exists($src_folder.$products_image_b) &&(int)$filesize_c > 0){
		unlink($dest_folder.str_replace('.',$postfix_a,str_replace('jpg','JPG',$products_image_c)));
		unlink($dest_folder.str_replace('.',$postfix_b,str_replace('jpg','JPG',$products_image_c)));
		unlink($dest_folder.str_replace('.',$postfix_c,str_replace('jpg','JPG',$products_image_c)));
		unlink($dest_folder.str_replace('.',$postfix_d,str_replace('jpg','JPG',$products_image_c)));
			
		$res_c=watermark_imagick($src_folder.$products_image_c, $dest_folder.str_replace('.'.$postfix,$postfix_a.$postfix,str_replace('jpg','JPG',$products_image_c)), $water_img, SIZE_A, SIZE_A);
		watermark_imagick($src_folder.$products_image_c, $dest_folder.str_replace('.'.$postfix,$postfix_b.$postfix,str_replace('jpg','JPG',$products_image_c)), $water_img, SIZE_B, SIZE_B);
		watermark_imagick($src_folder.$products_image_c, $dest_folder.str_replace('.'.$postfix,$postfix_c.$postfix,str_replace('jpg','JPG',$products_image_c)), '', SIZE_C, SIZE_C);
		watermark_imagick($src_folder.$products_image_c, $dest_folder.str_replace('.'.$postfix,$postfix_d.$postfix,str_replace('jpg','JPG',$products_image_c)), '', SIZE_D, SIZE_D);
		if(!$res_c){
			$products_image_c.' is a bad pic<br/>';
		}else{
			$i++;
		}
	} 
	
  }
}elseif($_GET['action']=='img_data'){
	@set_time_limit(3600);
	$products_query = $db->Execute("select products_id, products_model, products_image from t_products");
	while(!$products_query->EOF){
		$check_exist = $db->Execute("select product_image_update_id from t_product_image_update where product_id='".$products_query->fields['products_id']."'");
		if($check_exist->RecordCount()==0){
			$sql_data = array(
					'product_id'=>$products_query->fields['products_id'],
					'product_model'=>$products_query->fields['products_model'],
					'product_image'=>$products_query->fields['products_image'],
					'is_processed'=>0
			);
			zen_db_perform('t_product_image_update', $sql_data);
		}
		$products_query->MoveNext();
	}
}
echo $i;
exit;


function watermark_imagick($groundImage, $saved_name, $waterImage, $height, $width){
	global $db,$image_process_id;
  try{
	$image = new Imagick($groundImage);
	
	// If 0 is provided as a width or height parameter,
	// aspect ratio is maintained
	$image->thumbnailImage($height, $width,true,true);

	if($waterImage!='' && file_exists($waterImage)){
	//set water
		$water = new Imagick($waterImage);
		//$water->setImageFormat("png");
		$water->thumbnailImage( $height, null );
		$shadow = $water->clone();
		//$shadow->setImageBackgroundColor( new ImagickPixel( 'black' ) );
		$shadow->shadowImage( 80, 3, 5, 5 );
		$shadow->compositeImage( $water, Imagick::COMPOSITE_OVER, 0, 0 );
		$water = $shadow;

		$canvas = new ImagickDraw();
		//$canvas->color(0,0,imagick::PAINT_FLOODFILL);
		$canvas->setGravity(Imagick::GRAVITY_CENTER);//water position
		$canvas->composite($water->getImageCompose(),0,0,0,0,$water);
		$image->drawImage($canvas);
	}
	//$image->writeImage($groundImage);
	$image->enhanceImage();
	
	$path_arr = explode('/', $saved_name);
	$save_path = '';
	foreach($path_arr as $dir){
		$save_path.= $dir.'/';
		if($dir!='' && !stristr($dir, '.jpg') && !is_dir ( $save_path )){
			mkdir ( $save_path);
		}
	}
		
	file_put_contents($saved_name, $image);
	$image->clear();
	return true;
  }catch ( Exception $ex ) {
  		$db->Execute("update t_product_image_update set is_processed=1,product_image_update_type=-1, product_image_update_add_data ='".date('Y-m-d H:i:s')."' where product_image_update_id='".$image_process_id."'");
  	
		echo $ex->getMessage();
		return -1;
  }
}

?>
