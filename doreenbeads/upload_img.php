<?php
//header('Access-Control-Allow-Origin:http://test2.8years.com');
header('Access-Control-Allow-Origin:*');
require('includes/application_top.php');
//global $db;
define('SIZE_A', 500);
define('SIZE_B', 310);
define('SIZE_C', 130);
define('SIZE_D', 80);
@ini_set('memory_limit', '6144M');
@set_time_limit(0);
$water_img_310 = 'images/watermark_310.png';
$water_img = 'images/watermark.png';
$src_folder = 'download/';
$dest_folder = 'bmz_cache/watermarkimg_new/';
$dest_folder_no_watermarkimg = 'bmz_cache/no_watermarkimg/';

$sizeArr_no_watermarkimg = array(310);
$abcArr_no_watermarkimg = array('A');

$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

//php生成缩略图类，经典 http://blog.csdn.net/fuyungeili/article/details/25964715
class ServiceToolImage {
	/**
	* 功能：php生成缩略图片的类
	*/
	public $type; //图片类型
	public $width; //实际宽度
	public $height; //实际高度
	public $resize_width; //改变后的宽度
	public $resize_height; //改变后的高度
	public $cut; //是否裁图
	public $srcimg; //源图象
	public $dstimg; //目标图象地址
	public $im; //临时创建的图象
	public $quality; //图片质量
	function init($img, $wid, $hei, $c, $dstpath, $quality = 100) {
		$this->srcimg = $img; //源图像
		$this->resize_width = $wid; //改变后的宽度
		$this->resize_height = $hei;
		$this->cut = $c;
		$this->quality = $quality;
		$this->type = strtolower(substr(strrchr($this->srcimg, '.'), 1)); //图片的类型
		$this->initi_img(); //初始化图象
		$this->dst_img($dstpath); //目标图象地址
		@ $this->width = imagesx($this->im);
		@ $this->height = imagesy($this->im);
		$this->newimg(); //生成图象
		@ ImageDestroy($this->im);
	}
	function newimg() {
		$resize_ratio = ($this->resize_width) / ($this->resize_height); //改变后的图象的比例
		@ $ratio = ($this->width) / ($this->height); //实际图象的比例
		if (($this->cut) == '1') { //裁图
			if (function_exists('imagepng') && (str_replace('.', '', PHP_VERSION) >= 512)) {
				//针对php版本大于5.12参数变化后的处理情况
				$quality = 9;
			}
			if ($ratio >= $resize_ratio) { //高度优先
				$newimg = imagecreatetruecolor($this->resize_width, $this->resize_height);
				imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, (($this->height) * $resize_ratio), $this->height);
				imagejpeg($newimg, $this->dstimg, $this->quality);
			}
			if ($ratio < $resize_ratio) { //宽度优先
				$newimg = imagecreatetruecolor($this->resize_width, $this->resize_height);
				imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, (($this->width) / $resize_ratio));
				imagejpeg($newimg, $this->dstimg, $this->quality);
			}
		} else { //不裁图
			if ($ratio >= $resize_ratio) {
				$newimg = imagecreatetruecolor($this->resize_width, ($this->resize_width) / $ratio);
				imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width) / $ratio, $this->width, $this->height);
				imagejpeg($newimg, $this->dstimg, $this->quality);
			}
			if ($ratio < $resize_ratio) {
				@ $newimg = imagecreatetruecolor(($this->resize_height) * $ratio, $this->resize_height);
				@ imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height) * $ratio, $this->resize_height, $this->width, $this->height);
				@ imagejpeg($newimg, $this->dstimg, $this->quality);
			}
		}
	}
	function initi_img() { //初始化图象
		if ($this->type == 'jpg' || $this->type == 'jpeg') {
			$this->im = imagecreatefromjpeg($this->srcimg);
		}
		if ($this->type == 'gif') {
			$this->im = imagecreatefromgif($this->srcimg);
		}
		if ($this->type == 'png') {
			$this->im = imagecreatefrompng($this->srcimg);
		}
		if ($this->type == 'wbm') {
			@ $this->im = imagecreatefromwbmp($this->srcimg);
		}
		if ($this->type == 'bmp') {
			$this->im = $this->ImageCreateFromBMP($this->srcimg);
		}
	}
	function dst_img($dstpath) { //图象目标地址
		
		$path_arr = explode('/', $dstpath);
		$save_path = '';
		foreach ($path_arr as $dir) {
			$save_path .= $dir . '/';
			if ($dir != '' && !stristr($dir, '.jpg') && !is_dir($save_path)) {
				mkdir($save_path);
			}
		}
		
		$full_length = strlen($this->srcimg);
		$type_length = strlen($this->type);
		$name_length = $full_length - $type_length;
		$name = substr($this->srcimg, 0, $name_length -1);
		$this->dstimg = $dstpath;
		//echo $this->dstimg;
	}

	//读取文件前几个字节 判断文件类型
	function checkFileType($filename) {
		$file = fopen($filename, 'rb');
		$bin = fread($file, 2); //只读2字节
		fclose($file);
		$strInfo = @ unpack("c2chars", $bin);
		$typeCode = intval($strInfo['chars1'] . $strInfo['chars2']);
		$fileType = '';
		switch ($typeCode) {
			case 7790 :
				$fileType = 'exe';
				break;
			case 7784 :
				$fileType = 'midi';
				break;
			case 8297 :
				$fileType = 'rar';
				break;
			case 255216 :
				$fileType = 'jpg';
				break;
			case 7173 :
				$fileType = 'gif';
				break;
			case 6677 :
				$fileType = 'bmp';
				break;
			case 13780 :
				$fileType = 'png';
				break;
			default :
				$fileType = 'unknown' . $typeCode;
				break;
		}
		if ($strInfo['chars1'] == '-1' && $strInfo['chars2'] == '-40') {
			return 'jpg';
		}
		if ($strInfo['chars1'] == '-119' && $strInfo['chars2'] == '80') {
			return 'png';
		}
		return $fileType;
	}
	
	//php文字水印和php图片水印实现代码 http://blog.csdn.net/vailook/article/details/52368028
	function water_image($source_path, $water_path, $save_path_water) {
		//创建图片的实例
		$dst = imagecreatefromstring(file_get_contents($source_path));
		$src = imagecreatefromstring(file_get_contents($water_path));
		//获取水印图片的宽高
		list ($src_w, $src_h) = getimagesize($water_path);
		//将水印图片复制到目标图片上，最后个参数50是设置透明度，这里实现半透明效果
		//imagecopymerge($dst, $src, 10, 10, 0, 0, $src_w, $src_h, 50);
		//如果水印图片本身带透明色，则使用imagecopy方法
		imagecopy($dst, $src, 10, 10, 0, 0, $src_w, $src_h);
		//输出图片
		list ($dst_w, $dst_h, $dst_type) = getimagesize($source_path);
		switch ($dst_type) {
			case 1 : //GIF
				//header('Content-Type: image/gif');
				imagegif($dst, $save_path_water, 100);
				break;
			case 2 : //JPG
				//header('Content-Type: image/jpeg');
				imagejpeg($dst, $save_path_water, 100);
				break;
			case 3 : //PNG
				//header('Content-Type: image/png');
				imagepng($dst, $save_path_water, 100);
				break;
			default :
				break;
		}
	}

}

function watermark_imagick($groundImage, $saved_name, $waterImage, $height, $width) {
	//	global $db;
	try {
		$image = new Imagick($groundImage);

		// If 0 is provided as a width or height parameter,
		// aspect ratio is maintained
		$image->thumbnailImage($height, $width, true, true);

		if ($waterImage != '' && file_exists($waterImage)) {
			//set water
			$water = new Imagick($waterImage);
			//$water->setImageFormat("png");
			$water->thumbnailImage($height, null);
			$shadow = $water->clone ();
			//$shadow->setImageBackgroundColor( new ImagickPixel( 'black' ) );
			$shadow->shadowImage(80, 3, 5, 5);
			$shadow->compositeImage($water, Imagick :: COMPOSITE_OVER, 0, 0);
			$water = $shadow;

			$canvas = new ImagickDraw();
			//$canvas->color(0,0,imagick::PAINT_FLOODFILL);
			$canvas->setGravity(Imagick :: GRAVITY_CENTER); //water position
			$canvas->composite($water->getImageCompose(), 0, 0, 0, 0, $water);
			$image->drawImage($canvas);
		}
		//$image->writeImage($groundImage);
		$image->enhanceImage();

		$path_arr = explode('/', $saved_name);
		$save_path = '';
		foreach ($path_arr as $dir) {
			$save_path .= $dir . '/';
			if ($dir != '' && !stristr($dir, '.jpg') && !is_dir($save_path)) {
				mkdir($save_path);
			}
		}

		file_put_contents($saved_name, $image);
		$image->clear();
		return true;
	} catch (Exception $ex) {
		//  		$db->Execute("update zen_product_image_update set is_processed=1,product_image_update_type=-1, product_image_update_add_data ='".date('Y-m-d H:i:s')."' where product_image_update_id='".$image_query->fields['product_image_update_id']."'");

		echo $ex->getMessage();
	}
}

/*
* get image from this or img.8seasons
*/
function myGetSourcePath($image){
	global $src_folder;

	if(file_exists($src_folder.$image) && filesize($src_folder.$image) > 0){
		return $src_folder.$image;
	}
	return false;
}

if (isset ($_GET['action']) &&  $_GET['action'] =='clear_product_models') {
    $async = isset($_GET['async']) ? $_GET['async'] : "";
    file_put_contents("upload_exists_img_result_{$async}.txt", "");
}

if (isset ($_GET['action']) &&  $_GET['action'] =='clear_product_upload_result') {
    $async = isset($_GET['async']) ? $_GET['async'] : "";
    file_put_contents("upload_img_result_{$async}.txt", "0%");
}

if (isset ($_GET['pid']) && (int) $_GET['pid'] > 0) {
	$service = new ServiceToolImage();
	//		global $db;
	//$result = $db->Execute("select products_id ,products_model,products_image from zen_products  where products_id = ".(int)$_GET['pid']." order by products_id asc");
	$i = 0;

	$postfix_a = '_' . SIZE_A . '_' . SIZE_A . '.';
	$postfix_b = '_' . SIZE_B . '_' . SIZE_B . '.';
	$postfix_c = '_' . SIZE_C . '_' . SIZE_C . '.';
	$postfix_d = '_' . SIZE_D . '_' . SIZE_D . '.';

	// lvxiaoyong 20140818 换成csv
	$handle = fopen('shanghuo.csv', 'r');
	while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
		$products_image = trim($data[0]);
		$products_model = trim($data[0]);
        $size_type = substr($products_model, -1);

        if(in_array($size_type, array('H', 'S', 'Q', 'h', 's', 'q'))){
            $products_model = substr($products_model,0,strlen($products_model)-1);
        }
		if ($products_image != '') {
			$i++;
			//$products_image = substr($products_image,0,1).'/'.substr($products_image,0,3).'/'.$products_image.'.jpg';
			if (substr($products_model, 0, 1) == 'B') {
				$products_image = ((int) substr($products_model, 1, 2) + 1) . '/' . $products_model . '.JPG';
			} else {
				$products_image = substr($products_model, 0, 3) . '/' . $products_model . '.JPG';
			}
			$products_image_a = str_replace('.', 'A.', $products_image);
			$products_image_b = str_replace('.', 'B.', $products_image);
			$products_image_c = str_replace('.', 'C.', $products_image);
			
			$filesize_a = filesize($src_folder . $products_image_a . '') / 1024;

			if ($filesize_a == 0) {
				$products_image_a = str_replace('JPG', 'jpg', $products_image_a);
				$filesize_a = filesize($src_folder . $products_image_a . '') / 1024;
			}
			$filesize_b = filesize($src_folder . $products_image_b . '') / 1024;
			if ($filesize_b == 0) {
				$products_image_b = str_replace('JPG', 'jpg', $products_image_b);
				$filesize_b = filesize($src_folder . $products_image_b . '') / 1024;
			}
			$filesize_c = filesize($src_folder . $products_image_c . '') / 1024;
			if ($filesize_c == 0) {
				$products_image_c = str_replace('JPG', 'jpg', $products_image_c);
				$filesize_c = filesize($src_folder . $products_image_c . '') / 1024;
			}

			if (file_exists($src_folder . $products_image_a) && (int) $filesize_a > 0) {
				unlink($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)));
				unlink($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)));
				unlink($dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_a)));
				unlink($dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_a)));

				$service->init($src_folder . $products_image_a, SIZE_A, SIZE_A, 0, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)), 100);
				$service->water_image($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)), '', $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)));
				
				$service->init($src_folder . $products_image_a, SIZE_B, SIZE_B, 0, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)), 100);
				$service->water_image($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)), '', $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)));
				
				$service->init($src_folder . $products_image_a, SIZE_C, SIZE_C, 0, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_a)), 100);
				$service->init($src_folder . $products_image_a, SIZE_D, SIZE_D, 0, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_a)), 100);
				
				$index++;
			
				/*
				$res_a = watermark_imagick($src_folder . $products_image_a, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)), $water_img, SIZE_A, SIZE_A);
				watermark_imagick($src_folder . $products_image_a, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)), $water_img, SIZE_B, SIZE_B);
				watermark_imagick($src_folder . $products_image_a, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_a)), '', SIZE_C, SIZE_C);
				watermark_imagick($src_folder . $products_image_a, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_a)), '', SIZE_D, SIZE_D);
				if (!$res_a) {
					$products_image_a . ' is a bad pic<br/>';
				} else {
					//$i++;
				}
				*/
			}else {
                echo  $products_image_a . '图片不存在<br/>';
            }

			if (file_exists($src_folder . $products_image_b) && (int) $filesize_b > 0) {
				unlink($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)));
				unlink($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)));
				unlink($dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_b)));
				unlink($dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_b)));

				$service->init($src_folder . $products_image_b, SIZE_A, SIZE_A, 0, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)), 100);
				$service->water_image($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)), $water_img, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)));
				
				$service->init($src_folder . $products_image_b, SIZE_B, SIZE_B, 0, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)), 100);
				$service->water_image($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)), '', $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)));
				
				$service->init($src_folder . $products_image_b, SIZE_C, SIZE_C, 0, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_b)), 100);
				$service->init($src_folder . $products_image_b, SIZE_D, SIZE_D, 0, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_b)), 100);
				
				$index++;
			
				/*
				$res_b = watermark_imagick($src_folder . $products_image_b, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)), '', SIZE_A, SIZE_A);
				watermark_imagick($src_folder . $products_image_b, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)), '', SIZE_B, SIZE_B);
				watermark_imagick($src_folder . $products_image_b, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_b)), '', SIZE_C, SIZE_C);
				watermark_imagick($src_folder . $products_image_b, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_b)), '', SIZE_D, SIZE_D);
				if (!$res_b) {
					$products_image_b . ' is a bad pic<br/>';
				} else {
					//$i++;
				}
				*/
			}else {
                echo  $products_image_b . '图片不存在<br/>';
            }
			if (file_exists($src_folder . $products_image_c) && (int) $filesize_c > 0) {
				unlink($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)));
				unlink($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)));
				unlink($dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_c)));
				unlink($dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_c)));
				
				$service->init($src_folder . $products_image_c, SIZE_A, SIZE_A, 0, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)), 100);
				$service->water_image($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)), '', $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)));
				
				$service->init($src_folder . $products_image_c, SIZE_B, SIZE_B, 0, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)), 100);
				$service->water_image($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)), '', $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)));
				
				$service->init($src_folder . $products_image_c, SIZE_C, SIZE_C, 0, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_c)), 100);
				$service->init($src_folder . $products_image_c, SIZE_D, SIZE_D, 0, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_c)), 100);
				
				$index++;
			
				/*

				$res_c = watermark_imagick($src_folder . $products_image_c, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)), '', SIZE_A, SIZE_A);
				watermark_imagick($src_folder . $products_image_c, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)), '', SIZE_B, SIZE_B);
				watermark_imagick($src_folder . $products_image_c, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_c)), '', SIZE_C, SIZE_C);
				watermark_imagick($src_folder . $products_image_c, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_c)), '', SIZE_D, SIZE_D);
				if (!$res_c) {
					$products_image_c . ' is a bad pic<br/>';
				} else {
					//$i++;
				}
				*/
			}else {
                echo  $products_image_c . '图片不存在<br/>';
            }

		}

	}
	echo $i;
	exit;
} else
	if (isset ($_GET['action']) && $_GET['action'] == 'update_image_from_data') {
        $is_async = "";
        if (isset ($_POST['async']) && in_array($_POST['async']  ,array('auto','manual' ))) {
            $is_async = $_POST['async'];
            file_put_contents("upload_img_result_".$is_async.".txt", "1%");
            file_put_contents("upload_exists_img_result_".$is_async.".txt", 'start');
        }

        $error_info = array();
        $no_img_product_model = array();
        $exists_img_product_model = array();
		$service = new ServiceToolImage();
		//		global $db;
		//$result = $db->Execute("select products_id ,products_model,products_image from zen_products  where products_id = ".(int)$_GET['pid']." order by products_id asc");
		$index = 0;
		$postfix_a = '_' . SIZE_A . '_' . SIZE_A . '.';
		$postfix_b = '_' . SIZE_B . '_' . SIZE_B . '.';
		$postfix_c = '_' . SIZE_C . '_' . SIZE_C . '.';
		$postfix_d = '_' . SIZE_D . '_' . SIZE_D . '.';
		$request_modes = !empty($_POST['models'])?$_POST['models']:$_GET['models'];

		$models = explode(',', $request_modes);


		$total_size = sizeof($models);
        $current_count  = 0;

		foreach ($models as $model) {
			$index_exists = 0;
			
			$products_image = trim($model);
			$products_model = trim($model);
            $size_type = substr($products_model, -1);

            if(in_array($size_type, array('H', 'S', 'Q', 'h', 's', 'q'))){
                $products_model = substr($products_model,0,strlen($products_model)-1);
            }

            //判断图片是否存在 只要有一张就算存在 chengmin   20191114
            $img_exists = 0;

			if ($products_image != '') {
				//$products_image = substr($products_image,0,1).'/'.substr($products_image,0,3).'/'.$products_image.'.jpg';
				if (substr($products_model, 0, 1) == 'B') {
					$products_image = ((int) substr($products_model, 1, 2) + 1) . '/' . $products_model . '.JPG';
				} else {
					$products_image = substr($products_model, 0, 3) . '/' . $products_model . '.JPG';
				}
				$products_image_a = str_replace('.', 'A.', $products_image);
				$products_image_b = str_replace('.', 'B.', $products_image);
				$products_image_c = str_replace('.', 'C.', $products_image);
				$products_image_d = str_replace('.', 'D.', $products_image);
				
				$filesize_a = filesize($src_folder . $products_image_a . '') / 1024;
				if ($filesize_a == 0) {
					$products_image_a = str_replace('JPG', 'jpg', $products_image_a);
					$filesize_a = filesize($src_folder . $products_image_a . '') / 1024;
				}
				$filesize_b = filesize($src_folder . $products_image_b . '') / 1024;
				if ($filesize_b == 0) {
					$products_image_b = str_replace('JPG', 'jpg', $products_image_b);
					$filesize_b = filesize($src_folder . $products_image_b . '') / 1024;
				}
				$filesize_c = filesize($src_folder . $products_image_c . '') / 1024;
				if ($filesize_c == 0) {
					$products_image_c = str_replace('JPG', 'jpg', $products_image_c);
					$filesize_c = filesize($src_folder . $products_image_c . '') / 1024;
				}
				$filesize_d = filesize($src_folder . $products_image_d . '') / 1024;
				if ($filesize_d == 0) {
					$products_image_d = str_replace('JPG', 'jpg', $products_image_d);
					$filesize_d = filesize($src_folder . $products_image_d . '') / 1024;
				}

				if (file_exists($src_folder . $products_image_a) && (int) $filesize_a > 0) {
					$index_exists++;
					unlink($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)));
					unlink($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)));
					unlink($dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_a)));
					unlink($dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_a)));
					
					$service->init($src_folder . $products_image_a, SIZE_A, SIZE_A, 0, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)), 100);
					$service->water_image($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)), '', $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)));
					
					$service->init($src_folder . $products_image_a, SIZE_B, SIZE_B, 0, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)), 100);
					$service->water_image($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)), '', $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)));
					
					$service->init($src_folder . $products_image_a, SIZE_C, SIZE_C, 0, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_a)), 100);
					$service->init($src_folder . $products_image_a, SIZE_D, SIZE_D, 0, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_a)), 100);
					
					$index++;
                    $img_exists = 1;
					/*
					$res_a = watermark_imagick($src_folder . $products_image_a, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)), '', SIZE_A, SIZE_A);
					watermark_imagick($src_folder . $products_image_a, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)), '', SIZE_B, SIZE_B);
					watermark_imagick($src_folder . $products_image_a, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_a)), '', SIZE_C, SIZE_C);
					watermark_imagick($src_folder . $products_image_a, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_a)), '', SIZE_D, SIZE_D);
					if (!$res_a) {
						echo $products_image_a . '图片存在，但生成失败<br/>';
					} else {
						$index++;
					}
					*/
				} else {
                    $error_info[] = $products_image_a . '图片不存在<br/>';

				}

				if (file_exists($src_folder . $products_image_b) && (int) $filesize_b > 0) {
					$index_exists++;
					unlink($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)));
					unlink($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)));
					unlink($dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_b)));
					unlink($dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_b)));

					$service->init($src_folder . $products_image_b, SIZE_A, SIZE_A, 0, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)), 100);
					$service->water_image($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)), '', $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)));
					
					$service->init($src_folder . $products_image_b, SIZE_B, SIZE_B, 0, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)), 100);
					$service->water_image($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)), '', $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)));
					
					$service->init($src_folder . $products_image_b, SIZE_C, SIZE_C, 0, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_b)), 100);
					$service->init($src_folder . $products_image_b, SIZE_D, SIZE_D, 0, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_b)), 100);
					
					$index++;
                    $img_exists = 1;
					/*
					$res_b = watermark_imagick($src_folder . $products_image_b, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)), '', SIZE_A, SIZE_A);
					watermark_imagick($src_folder . $products_image_b, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)), '', SIZE_B, SIZE_B);
					watermark_imagick($src_folder . $products_image_b, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_b)), '', SIZE_C, SIZE_C);
					watermark_imagick($src_folder . $products_image_b, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_b)), '', SIZE_D, SIZE_D);
					if (!$res_b) {
						echo $products_image_b . '图片存在，但生成失败<br/>';
					} else {
						$index++;
					}
					*/
				} else {
                    $error_info[] =  $products_image_b . '图片不存在<br/>';
				}

				if (file_exists($src_folder . $products_image_c) && (int) $filesize_c > 0) {
					$index_exists++;
					unlink($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)));
					unlink($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)));
					unlink($dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_c)));
					unlink($dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_c)));

					$service->init($src_folder . $products_image_c, SIZE_A, SIZE_A, 0, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)), 100);
					$service->water_image($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)), '', $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)));
					
					$service->init($src_folder . $products_image_c, SIZE_B, SIZE_B, 0, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)), 100);
					$service->water_image($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)), '', $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)));
					
					$service->init($src_folder . $products_image_c, SIZE_C, SIZE_C, 0, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_c)), 100);
					$service->init($src_folder . $products_image_c, SIZE_D, SIZE_D, 0, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_c)), 100);
					
					$index++;
                    $img_exists = 1;
					/*
					$res_c = watermark_imagick($src_folder . $products_image_c, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)), '', SIZE_A, SIZE_A);
					watermark_imagick($src_folder . $products_image_c, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)), '', SIZE_B, SIZE_B);
					watermark_imagick($src_folder . $products_image_c, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_c)), '', SIZE_C, SIZE_C);
					watermark_imagick($src_folder . $products_image_c, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_c)), '', SIZE_D, SIZE_D);
					if (!$res_c) {
						echo $products_image_c . '图片存在，但生成失败<br/>';
					} else {
						$index++;
					}
					*/
				} else {
                    $error_info[] = $products_image_c . '图片不存在<br/>';
				}
				
				if (file_exists($src_folder . $products_image_d) && (int) $filesize_d > 0) {
					$index_exists++;
					unlink($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_d)));
					unlink($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_d)));
					unlink($dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_d)));
					unlink($dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_d)));
				
					$service->init($src_folder . $products_image_d, SIZE_A, SIZE_A, 0, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_d)), 100);
					$service->water_image($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_d)), '', $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_d)));
						
					$service->init($src_folder . $products_image_d, SIZE_B, SIZE_B, 0, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_d)), 100);
					$service->water_image($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_d)), '', $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_d)));
						
					$service->init($src_folder . $products_image_d, SIZE_C, SIZE_C, 0, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_d)), 100);
					$service->init($src_folder . $products_image_d, SIZE_D, SIZE_D, 0, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_d)), 100);
						
					$index++;
                    $img_exists = 1;
				} else {
                    $error_info[] = $products_image_d . '图片不存在<br/>';
				}

                if(!$img_exists ){
                    $no_img_product_model[] = trim($model);
                }else{
                    $exists_img_product_model[] = trim($model);
                }
			}



			if($is_async && $total_size > 0){
                $current_count++;
                if($current_count %3 == 1 || $current_count == $total_size){
                    file_put_contents("upload_img_result_".$is_async.".txt",  sprintf("%.2f",($current_count / $total_size)) * 100  .'%' .PHP_EOL);
                }
            }
		}
		if($is_async){
            if($no_img_product_model){
                $no_img_product_model = array_values(array_unique($no_img_product_model));
                file_put_contents("upload_img_result_".$is_async.".txt", implode(chr(10),$no_img_product_model));
            }else{
                file_put_contents("upload_img_result_".$is_async.".txt", 'success');
            }

            file_put_contents("upload_exists_img_result_".$is_async.".txt", implode(",",$exists_img_product_model));
        }else{
            echo json_encode($error_info);
        }

		exit;
	} else
		if (isset ($_GET['action']) && $_GET['action'] == 'generate_product_image_no_watermark') {
			$service = new ServiceToolImage();
			$i = 0;
			$suffix_str = " order by p.products_id desc limit 500";
			if(isset($_GET['type']) && $_GET['type'] == "all") {
				$suffix_str = " where p.products_status=1";
			}
			$result = $db_main_server->Execute("select p.products_model, p.products_image from " . TABLE_PRODUCTS . " p" . $suffix_str);
			//$result =  $db_main_server->Execute("select p.products_model, p.products_image from " . TABLE_PRODUCTS . " p where products_model='B79976'");
			while (!$result->EOF) {
				$products_image = trim($result->fields['products_model']);
				if (!empty ($products_image)) {
					$i++;
					foreach ($abcArr_no_watermarkimg as $abc) {
						$suffix = strstr($result->fields['products_image'], ".");
						$products_image_a = str_replace($suffix, "", $result->fields['products_image']) . $abc . strtolower($suffix);
						$products_image_a_up = str_replace($suffix, "", $result->fields['products_image']) . $abc . strtoupper($suffix);
						//echo $products_image_a_up;exit;
						//echo $products_image_a . "-" . $products_image_a_up;exit;
						//exit;
						//$products_image_a = substr($products_image, 0, 1).'/'.substr($products_image, 0, 3).'/'.$products_image.$abc.'.jpg';
						//$products_image_a_up = substr($products_image, 0, 1).'/'.substr($products_image, 0, 3).'/'.$products_image.$abc.'.JPG';
						$source_a = myGetSourcePath($products_image_a) == false ? myGetSourcePath($products_image_a_up) : myGetSourcePath($products_image_a);
						if ($source_a) {
							foreach ($sizeArr_no_watermarkimg as $size) {
								if (is_array($size)) {
									$w = $size[0];
									$h = $size[1];
								} else {
									$w = $size;
									$h = $size;
								}
								$postfix_a = '_' . $w . '_' . $h;
								$desc_img = $dest_folder_no_watermarkimg . str_replace($suffix, "", $result->fields['products_image']) . $abc . $postfix_a . strtoupper($suffix);
								if(!is_file($desc_img) || (is_file($desc_img) && filesize($desc_img) <= 0)) {
									if(is_file($desc_img) && filesize($desc_img) <= 0) {
										@unlink($desc_img);
									}
									//@unlink($desc_img);
									$my_water_img = $w >= 30000 ? $water_img : ''; //	是否有水印
									$service->init($source_a, $w, $h, 0, $desc_img, 100);
									/*
									$res_a = watermark_imagick($source_a, $desc_img, $my_water_img, $w, $h);
									if (!$res_a) {
										echo $products_image_a . ' is a bad pic<br/>';
									}
									*/
								}
							}
						} else {
							echo $products_image_a . ' not exists<br/>';
						}
					}
				}

				$result->MoveNext();
			}

			echo $i;
			file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
			exit ();
		}else if(isset($_GET['action']) && $_GET['action']=='update_image_all_products'){
		    
		    $service = new ServiceToolImage();
		    //		global $db;
		    //$result = $db->Execute("select products_id ,products_model,products_image from zen_products  where products_id = ".(int)$_GET['pid']." order by products_id asc");
		    $index = 0;
		    $postfix_a = '_' . SIZE_A . '_' . SIZE_A . '.';
		    $postfix_b = '_' . SIZE_B . '_' . SIZE_B . '.';
		    $postfix_c = '_' . SIZE_C . '_' . SIZE_C . '.';
		    $postfix_d = '_' . SIZE_D . '_' . SIZE_D . '.';
		    
		    $suffix_str = '';
		    if(isset($_GET['type']) && $_GET['type'] == 'test'){
		        $suffix_str = " order by p.products_id desc limit 1000";
		    }else{
		        $start_products_id = 1000;
		        if(isset($_GET['batch']) && $_GET['batch'] >= 0){
		            $offset = (int)$_GET['batch'];
		            $start_products_id += 10000 * $offset;
		            
		            $suffix_str = " order by p.products_id desc limit " . $start_products_id . ', 10000';
		        }else{
		            exit;
		        }
		    }
		    
		    $products_model_query = $db_main_server->Execute("select p.products_model from " . TABLE_PRODUCTS . " p" . $suffix_str);
		    
		    while(!$products_model_query->EOF){
		        $model = trim($products_model_query->fields['products_model']);
		        $index_exists = 0;
		        
		        $products_image = trim($model);
		        $products_model = trim($model);
		        if ($products_image != '') {
		            //$products_image = substr($products_image,0,1).'/'.substr($products_image,0,3).'/'.$products_image.'.jpg';
		            if (substr($products_model, 0, 1) == 'B') {
		                $products_image = ((int) substr($products_model, 1, 2) + 1) . '/' . $products_model . '.JPG';
		            } else {
		                $products_image = substr($products_model, 0, 3) . '/' . $products_model . '.JPG';
		            }
		            $products_image_a = str_replace('.', 'A.', $products_image);
		            $products_image_b = str_replace('.', 'B.', $products_image);
		            $products_image_c = str_replace('.', 'C.', $products_image);
		            $products_image_d = str_replace('.', 'D.', $products_image);
		            
		            $filesize_a = filesize($src_folder . $products_image_a . '') / 1024;
		            if ($filesize_a == 0) {
		                $products_image_a = str_replace('JPG', 'jpg', $products_image_a);
		                $filesize_a = filesize($src_folder . $products_image_a . '') / 1024;
		            }
		            $filesize_b = filesize($src_folder . $products_image_b . '') / 1024;
		            if ($filesize_b == 0) {
		                $products_image_b = str_replace('JPG', 'jpg', $products_image_b);
		                $filesize_b = filesize($src_folder . $products_image_b . '') / 1024;
		            }
		            $filesize_c = filesize($src_folder . $products_image_c . '') / 1024;
		            if ($filesize_c == 0) {
		                $products_image_c = str_replace('JPG', 'jpg', $products_image_c);
		                $filesize_c = filesize($src_folder . $products_image_c . '') / 1024;
		            }
		            $filesize_d = filesize($src_folder . $products_image_d . '') / 1024;
		            if ($filesize_d == 0) {
		                $products_image_d = str_replace('JPG', 'jpg', $products_image_d);
		                $filesize_d = filesize($src_folder . $products_image_d . '') / 1024;
		            }
		            
		            if (file_exists($src_folder . $products_image_a) && (int) $filesize_a > 0) {
		                $index_exists++;
		                unlink($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)));
		                unlink($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)));
		                unlink($dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_a)));
		                unlink($dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_a)));
		                
		                $service->init($src_folder . $products_image_a, SIZE_A, SIZE_A, 0, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)), 100);
		                $service->water_image($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)), '', $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_a)));
		                
		                $service->init($src_folder . $products_image_a, SIZE_B, SIZE_B, 0, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)), 100);
		                $service->water_image($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)), '', $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_a)));
		                
		                $service->init($src_folder . $products_image_a, SIZE_C, SIZE_C, 0, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_a)), 100);
		                $service->init($src_folder . $products_image_a, SIZE_D, SIZE_D, 0, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_a)), 100);
		                
		                $error_info .= $products_image_a . " 图片更新成功\r\n";
		                $index++;
		            } else {
		                $error_info .= $products_image_a . "图片不存在\r\n";
		            }
		            
		            if (file_exists($src_folder . $products_image_b) && (int) $filesize_b > 0) {
		                $index_exists++;
		                unlink($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)));
		                unlink($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)));
		                unlink($dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_b)));
		                unlink($dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_b)));
		                
		                $service->init($src_folder . $products_image_b, SIZE_A, SIZE_A, 0, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)), 100);
		                $service->water_image($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)), '', $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_b)));
		                
		                $service->init($src_folder . $products_image_b, SIZE_B, SIZE_B, 0, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)), 100);
		                $service->water_image($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)), '', $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_b)));
		                
		                $service->init($src_folder . $products_image_b, SIZE_C, SIZE_C, 0, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_b)), 100);
		                $service->init($src_folder . $products_image_b, SIZE_D, SIZE_D, 0, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_b)), 100);
		                
		                $error_info .= $products_image_b . " 图片更新成功\r\n";
		                $index++;
		            } else {
		                $error_info .= $products_image_b . "图片不存在\r\n";
		            }
		            
		            if (file_exists($src_folder . $products_image_c) && (int) $filesize_c > 0) {
		                $index_exists++;
		                unlink($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)));
		                unlink($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)));
		                unlink($dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_c)));
		                unlink($dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_c)));
		                
		                $service->init($src_folder . $products_image_c, SIZE_A, SIZE_A, 0, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)), 100);
		                $service->water_image($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)), '', $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_c)));
		                
		                $service->init($src_folder . $products_image_c, SIZE_B, SIZE_B, 0, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)), 100);
		                $service->water_image($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)), '', $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_c)));
		                
		                $service->init($src_folder . $products_image_c, SIZE_C, SIZE_C, 0, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_c)), 100);
		                $service->init($src_folder . $products_image_c, SIZE_D, SIZE_D, 0, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_c)), 100);
		                
		                $error_info .= $products_image_c . " 图片更新成功\r\n";
		                $index++;
		            } else {
		                $error_info .= $products_image_c . "图片不存在\r\n";
		            }
		            
		            if (file_exists($src_folder . $products_image_d) && (int) $filesize_c > 0) {
		                $index_exists++;
		                unlink($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_d)));
		                unlink($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_d)));
		                unlink($dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_d)));
		                unlink($dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_d)));
		                
		                $service->init($src_folder . $products_image_d, SIZE_A, SIZE_A, 0, $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_d)), 100);
		                $service->water_image($dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_d)), '', $dest_folder . str_replace('.', $postfix_a, str_replace('jpg', 'JPG', $products_image_d)));
		                
		                $service->init($src_folder . $products_image_d, SIZE_B, SIZE_B, 0, $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_d)), 100);
		                $service->water_image($dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_d)), '', $dest_folder . str_replace('.', $postfix_b, str_replace('jpg', 'JPG', $products_image_d)));
		                
		                $service->init($src_folder . $products_image_d, SIZE_C, SIZE_C, 0, $dest_folder . str_replace('.', $postfix_c, str_replace('jpg', 'JPG', $products_image_d)), 100);
		                $service->init($src_folder . $products_image_d, SIZE_D, SIZE_D, 0, $dest_folder . str_replace('.', $postfix_d, str_replace('jpg', 'JPG', $products_image_d)), 100);
		                
		                $error_info .= $products_image_d . " 图片更新成功\r\n";
		                $index++;
		            } else {
		                $error_info .= $products_image_d . "图片不存在\r\n";
		            }
		        }
		        $products_model_query->MoveNext();
		    }
		    file_put_contents("log/img_update_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n". $error_info, FILE_APPEND);
		    echo "成功<font color=red>" . floor($index / $index_exists) . "</font>个";
		    exit;
		}
echo $i;
?>