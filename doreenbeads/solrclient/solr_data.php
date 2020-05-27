<?php
set_time_limit(7200);
//require('/var/www/8years/includes/application_top.php');
include('../includes/configure.php');
include('../includes/database_tables.php');
include('../includes/classes/class.base.php');
//include('../includes/classes/db/mysql/query_factory.php');
//include(DIR_WS_FUNCTIONS.'functions_categories.php');
include("Apache/Solr/Service.php");

//连接Solr服务器
$solr = new Apache_Solr_service('localhost' , '8080' ,'/solr/');
if( !$solr->ping() ) {
    echo'Solr server not responding';
   exit;
}

$mysql_link = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
if (!$mysql_link) {
   throw new Exception('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db(DB_DATABASE, $mysql_link);
if (!$db_selected) {
   throw new Exception('Can\'t use db : ' . mysql_error());
}

/*$series_query = $db->Execute('select distinct ps.products_series_id,ps.series_image,psd.series_name,ps.createtime,
    		psd.languages_id, psd.products_name_without_catg,ps.theme,ps.style,ps.shape
    		from zen_products_series ps,zen_products_series_description psd, zen_products p 
    		where ps.products_series_id=psd.products_series_id 
    		and p.products_series_id = ps.products_series_id
    		and ps.products_series_status=1
    		and p.products_status=1
    		order by psd.languages_id');*/
$i=1;

$series_query = mysql_query('select distinct ps.products_series_id,ps.series_image,ps.createtime,
    		ps.theme,ps.style,ps.shape,ps.size_counter,ps.color_counter,ps.min_weight,ps.price_sorter
    		from zen_products_series ps, zen_products p 
    		where p.products_series_id = ps.products_series_id
    		and ps.products_series_status=1
    		and p.products_status=1');
$documents = array();
while($row = mysql_fetch_array($series_query, MYSQL_ASSOC)){
	
	$data_arr = array(
		'id'=>'',
		'series_id'=>'',
		'name'=>'',
		//'category_first'=>'',
		//'category_second'=>'',
		//'category_third'=>'',
		'theme'=>'',
		'style'=>'',
		'shape'=>'',
		'use'=>'',
		'material'=>'',
		'color'=>'',
		'description'=>'',
		'details'=>'',
		'price'=>'',		
		'date_added'=>''
	);
	$series_details = array(
       						'weight'=>$row['min_weight'],
       						'color_count'=>$row['color_counter'],
       						'size_count'=>$row['size_counter'],
       						'measure'=>'Piece',
       						'image_name'=>''
       					);
       			
	$data_arr['id']=$row['products_series_id'];
	$data_arr['series_id']=$row['products_series_id'];
	$data_arr['price']=$row['price_sorter'];
	$data_arr['date_added']=$row['createtime'];
	$series_name_query = mysql_query("select series_name from ".TABLE_PRODUCTS_SERICES_DESCRIPTION." 
					where products_series_id='".$row['products_series_id']."' and languages_id=1");
	while($name_res = mysql_fetch_array($series_name_query, MYSQL_ASSOC)){
		$data_arr['name']=$name_res['series_name'];		
	}
	
	$cid_arr = array();
    $p2c_string = '';
    $cid_string = '';
    $p2c_query = mysql_query("select categories_id,first_categories_id,second_categories_id from zen_products_series_to_categories where products_series_id='".$row['products_series_id']."'");
    $categ_names = array();
    while ($listing = mysql_fetch_array($p2c_query, MYSQL_ASSOC)) {
       		       		
      	$p2c_string.='cate_'.$listing['categories_id'].',';
       	if(!in_array($listing['first_categories_id'],$cid_arr)) $cid_arr[] = $listing['first_categories_id'];
       	if(!in_array($listing['second_categories_id'],$cid_arr)) $cid_arr[] = $listing['second_categories_id'];
       	if(!in_array($listing['categories_id'],$cid_arr)) $cid_arr[] = $listing['categories_id'];
       	//$p2c_query->MoveNext();	
    }
    foreach($cid_arr as $c_val){
       	$cid_string.=$c_val.',';
    }
    if($cid_string != '' ) {
    	$cid_string = substr($cid_string,0,-1);
    	$categ_names_query = mysql_query("select categories_name from ".TABLE_CATEGORIES_DESCRIPTION." 
       								where categories_id in (".$cid_string.")
       								and language_id=1");
    	while($categ_name_res = mysql_fetch_array($categ_names_query, MYSQL_ASSOC)){
    		$categ_names[] = $categ_name_res['categories_name'];
    		//$categ_names_query->MoveNext();
    	}
    }
    $data_arr['categories_id'] = serialize($cid_arr);
    $data_arr['categories_name'] = serialize($categ_names);   
	//theme
    $theme_arr = array();
    $theme_query = mysql_query("select a.attribute_id,a.attribute_code,a.attribute_value 
    			from ".TABLE_SERIES_TO_ATTRIBUTE." sa,".TABLE_ATTRIBUTE." a, ".TABLE_ATTRIBUTE_GROUP." ag
    			where sa.attribute_id=a.attribute_id 
    				and a.attribute_group_id=ag.attribute_group_id
    				and a.language_id=ag.language_id
    				and ag.attribute_group_name='theme'
    				and a.language_id=1
    				and sa.products_series_id='".$row['products_series_id']."'");
    
    while($theme_res = mysql_fetch_array($theme_query, MYSQL_ASSOC)){
    	//$data_arr['theme'].= $theme_res['attribute_code'].',';
    	$theme_arr[] = 'theme_'.$theme_res['attribute_code'];
    	$data_arr['description'].= $theme_res['attribute_value'].',';
    	
    }
    $data_arr['theme'] = serialize($theme_arr);
    //style
    $style_arr = array();
	$style_query = mysql_query("select a.attribute_id,a.attribute_code,a.attribute_value 
    			from ".TABLE_SERIES_TO_ATTRIBUTE." sa,".TABLE_ATTRIBUTE." a, ".TABLE_ATTRIBUTE_GROUP." ag
    			where sa.attribute_id=a.attribute_id 
    				and a.attribute_group_id=ag.attribute_group_id
    				and a.language_id=ag.language_id
    				and ag.attribute_group_name='style'
    				and a.language_id=1
    				and sa.products_series_id='".$row['products_series_id']."'");
    while($style_res = mysql_fetch_array($style_query, MYSQL_ASSOC)){
    	//$data_arr['style'].= $style_res['attribute_code'].',';
    	$style_arr[] = 'style_'.$style_res['attribute_code'];
    	$data_arr['description'].= $style_res['attribute_value'].',';
    	
    }
    $data_arr['style'] = serialize($style_arr);
    //shape
    $shape_arr = array();
	$shape_query = mysql_query("select a.attribute_id,a.attribute_code,a.attribute_value 
    			from ".TABLE_SERIES_TO_ATTRIBUTE." sa,".TABLE_ATTRIBUTE." a, ".TABLE_ATTRIBUTE_GROUP." ag
    			where sa.attribute_id=a.attribute_id 
    				and a.attribute_group_id=ag.attribute_group_id
    				and a.language_id=ag.language_id
    				and ag.attribute_group_name='shape'
    				and a.language_id=1
    				and sa.products_series_id='".$row['products_series_id']."'");
    while($shape_res = mysql_fetch_array($shape_query, MYSQL_ASSOC)){
    	//$data_arr['shape'].= $shape_res['attribute_code'].',';
    	$shape_arr[] = 'shape_'.$shape_res['attribute_code'];
    	$data_arr['description'].= $shape_res['attribute_value'].',';
    	//$shape_query->MoveNext();
    }
    $data_arr['shape'] = serialize($shape_arr);
    //use
    $use_arr = array();
	$use_query = mysql_query("select a.attribute_id,a.attribute_code,a.attribute_value 
    			from ".TABLE_SERIES_TO_ATTRIBUTE." sa,".TABLE_ATTRIBUTE." a, ".TABLE_ATTRIBUTE_GROUP." ag
    			where sa.attribute_id=a.attribute_id 
    				and a.attribute_group_id=ag.attribute_group_id
    				and a.language_id=ag.language_id
    				and ag.attribute_group_name='use'
    				and a.language_id=1
    				and sa.products_series_id='".$row['products_series_id']."'");
    while($use_res = mysql_fetch_array($use_query, MYSQL_ASSOC)){
    	//$data_arr['use'].= $use_res['attribute_code'].',';
    	$use_arr[] = 'use_'.$use_res['attribute_code'];
    	$data_arr['description'].= $use_res['attribute_value'].',';
    	//$use_query->MoveNext();
    }
    $data_arr['use'] = serialize($use_arr);   
       
    //material and color
	$series_products_query = mysql_query("select products_id, products_weight,products_color, material,products_sizemarked from ".TABLE_PRODUCTS." where products_series_id='".$row['products_series_id']."'");
    $weight_list = array();
    $size_list = array();
    $color_list = array();
    $material_list = array();
    $products_count = 0;
    while ($products_res = mysql_fetch_array($series_products_query, MYSQL_ASSOC)) {
       			$data_arr['description'].=$products_res['products_id'].',';
       			$products_count++;
       		 	$color_arr= explode(',',$products_res['products_color']);
       		 	$material_arr = explode(',',$products_res['material']);
       		 	$weight_list[]=$products_res['products_weight'];
       		 	if(!in_array($products_res['products_sizemarked'], $size_list)){
       		 		$size_list[]=$products_res['products_sizemarked'];
       		 		
       		 	}
       		 	
       		 	foreach($color_arr as $color){
       		 		$color_query = mysql_query("select color_definition_name from zen_product_color_definition where color_definition_code='".$color."' and languages_id=1");     		 		
       		 		while ($color_res = mysql_fetch_array($color_query, MYSQL_ASSOC)) {
       		 			if(!in_array($color, $color_list)){
       		 				$color_list[]=$color;
       		 				
       		 			}       		 			
       		 			if(!stristr($data_arr['description'],$color_res['color_definition_name'])){
       		 				$data_arr['description'].= $color_res['color_definition_name'].',';
       		 				
       		 			}
       				}
       		 	}
    			foreach($material_arr as $material){
       		 		$material_query = mysql_query("select materialdefinition_name from zen_product_materialdefinition where materialdefinition_code='".$material."' and languages_id=1");
       		 		while ($material_res = mysql_fetch_array($material_query, MYSQL_ASSOC)) {
       		 			if(!in_array($material, $material_list)){
       		 				$material_list[]=$material;
       		 				
       		 			}
       		 			if(!stristr($data_arr['description'],$material_res['materialdefinition_name']))
       		 			$data_arr['description'].= $material_res['materialdefinition_name'].',';
       				}
       		 	}
    }
    
    $data_arr['material'] = serialize($material_list);
    $data_arr['color'] = serialize($color_list);
    
	$sample_image_arr = unserialize($row['series_image']);       
	if($row['series_image']=='' || !file_exists(DIR_FS_CATALOG_IMAGES.$sample_image_arr[0])){
       		$sample_image_query =mysql_query("select image_name from ".TABLE_PRODUCTS_IMAGES." 
          											where products_id = (select products_id from ".TABLE_PRODUCTS."
          												where products_series_id='".$row['products_series_id']."'
          												order by products_id limit 1)");
	   	$image_sort = array();
	   	$postfix_arr = array();
	   
       	while($image_res = mysql_fetch_array($sample_image_query, MYSQL_ASSOC)){
    		$name_ext = explode('.',$image_res['image_name']);     	
    		$image_sort[] = $name_ext[0];
	    	$postfix_arr[$name_ext[0]] = $name_ext[1];
    		//$sample_image_query->MoveNext();
       	}
       	sort($image_sort);
       	$series_details['image_name']=$image_sort[0].'.'.$postfix_arr[$image_sort[0]];
       		
	}else{
	   	$series_details['image_name']=$sample_image_arr[0];
	}
	  
    $measurement_query = mysql_query("select pma.measurementdefinition_name from ".TABLE_PRODUCTS_SERICES." ps,
 	     						".TABLE_PRODUCTS_MEASUREMENTDEFINITION." pma
					    		where  ps.products_series_id  = '".$row['products_series_id']."'
					    		 and pma.measurementdefinition_code = ps.masurement
					    		 and pma.languages_id = 1 limit 1");
    while($measure_res = mysql_fetch_array($measurement_query, MYSQL_ASSOC)){
    	$series_details['measure']=$measure_res['measurementdefinition_name'];
    }
    
    $data_arr['details']=serialize($series_details);
    
    
    $part =new Apache_Solr_Document();
    foreach($data_arr as $key => $value){
    	$part->$key =$value;
    }
    //var_dump($part);exit;
    $documents[] = $part;
    $i++;
    //echo $i.'<br/>';
	//$series_query->MoveNext();
}

/*$data = array(
 array(
 'id' => 'EN80922032',
 'name' => '男士打磨直筒休闲牛仔裤',
 //'brand' => 'ENERGIE',
 //'cat' => '牛仔裤',
 'price' => '1870.00'
 )
);
$documents = array();
foreach($data as $key => $value) {
    $part =new Apache_Solr_Document();
   foreach($value as $key2 =>$value2) {
       $part->$key2 =$value2;
    }
    
   $documents[] = $part;
}*/
//var_dump($documents);exit;
$res1=$solr->addDocuments( $documents );
var_dump($res1);
$solr->commit();
$solr->optimize();


?>
