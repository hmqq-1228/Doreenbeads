<?php

include("Apache/Solr/Service.php");

//连接Solr服务器
$solr = new Apache_Solr_service('localhost' , '8080' ,'/solr/8years_2');
if( !$solr->ping() ) {
    echo'Solr server not responding';
   exit;
}

$data = array(
array(
'id' => 'EN80922032',
'name' => '男士打磨直筒休闲牛仔裤',
//'brand' => 'ENERGIE',
//'cat' => '牛仔裤',
'price' => '1870.00'
),
array(
'id' => 'EN70906025',
'name' => '品牌LOGO翻领拉链外套',
//'brand' => 'ENERGIE',
//'cat' => '外套',
'price' => '1680.00'
),
array(
'id' => 'EN70903128',
'name' => 'polo翻领拉链t-shirt',
//'brand' => 'ENERGIE',
//'cat' => '外套',
'price' => '800.00'
),
array(
'id' => 'EN70910407',
'name' => 'Jewerly拉链外套',
//'brand' => 'ENERGIE',
//'cat' => '外套',
'price' => '1200.00'
),
);

//添加索引数据
$documents = array();
foreach($data as $key => $value) {
    $part =new Apache_Solr_Document();
   foreach($value as $key2 =>$value2) {
       $part->$key2 =$value2;
    }
    
   $documents[] = $part;
}
//var_dump($documents);exit;
$res1=$solr->addDocuments( $documents );

$solr->commit();
$solr->optimize();

//查询索引 $solr->search(字段:关键字 , 开始 ,每页显示,排序)
$offset = 0;
$limit = 10;
$sort = '';
$sort = 'price asc';

$rs = $solr->search("name:polo" , $offset ,$limit,array('sort' => $sort));
if($rs->response->numFound> 0) {
   foreach($rs->response->docs as $doc) {
       echo $doc->id.'|'.$doc->name.'|'.'|'.$doc->price.'|'.'<br>';
    }
}
die();
?>
