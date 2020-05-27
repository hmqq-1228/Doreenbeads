<?php
require('includes/application_top.php');
$action = (isset($_POST['action']) ? $_POST['action'] : '');
function postcode_format_check($from,$to){//校验邮编格式
    $from = str_split($from);
    $to = str_split($to);
    foreach($from as $index => $words){
        if(is_numeric($words)){
            $words='num';
        }else{$words='wrd';}
        $from_type[]=$words;
    }
    foreach($to as $key => $str){
        if(is_numeric($str)){
            $str='num';
        }else{$str='wrd';}
        $to_type[]=$str;
    }
    $from_format=implode($from_type, "");
    $to_format=implode($to_type, "");
    if($from_format===$to_format){
        return true;
    }else{
        return false;
    }
}
//校验邮编是否有交集，是返回true
function is_in_postcode_range($exist_from,$exist_to,$input_from,$input_to){
    if(empty($exist_from)&&(!empty($input_from))){
        return true;
    }
    if((($input_from>=$exist_from)&&($exist_to>=$input_from)&&(strlen($input_from)==strlen($exist_from)))||(($input_to>=$exist_from)&&($exist_to>=$input_to))&&(strlen($input_to)==strlen($exist_to))){
        return true;
    }else{
        if(($exist_from>=$input_from)&&($input_to>=$exist_to)){
            return true;
        }else{
            return false;
        }
    }
}
//校验产品是否有交集，是返回true
function is_in_products($exist_products,$input_products)
{
    if(($exist_products==$input_products)||(empty($exist_products)&&!empty($input_products))){
        return true;
    }else{
        return false;
    }
}
//校验时间是否有交集，是返回true
function is_mix_time($begintime1,$endtime1,$begintime2,$endtime2)
{
    $begintime1=strtotime($begintime1);
    $begintime2=strtotime($begintime2);
    $endtime1=strtotime($endtime1);
    $endtime2=strtotime($endtime2);
    $status = $begintime2 - $begintime1;
    if(empty($begintime1)&&(!empty($begintime2)))
    {
        return true;
    }
    if($status>0){
        $status2 = $begintime2 - $endtime1;
        if($status2>0){
            return false;
        }else{
            return true;
        }
    }else{
        $status2 = $begintime1 - $endtime2;
        if($status2>0){
            return false;
        }else{
            return true;
        }
    }
}
//校验国家是否有交集，是返回true
function is_in_countries_restriction($exist_countries,$input_countries){
    if(empty($exist_countries)){
        return true;
    }else{
        if(empty($input_countries)){
            return true;
        }else{
            $exist_countries=explode(',',$exist_countries);
            $input_countries=explode(',',$input_countries);
            if(array_intersect($exist_countries,$input_countries)){
                return true;
            }else{
                return false;
            }
        }
    }
}
switch($action){    
     case 'show_countries_name':
        $countries_code = $_POST['countries_code'];
        if(sizeof($countries_code)>=256 || !isset($countries_code)){
            $countries_name='all';
            $returnArray=json_encode($countries_name);
            die($returnArray);
        }else{
            $countries_name='';
            foreach($countries_code as $key=>$code){
                $countries_name_sql="SELECT countries_name FROM ".TABLE_COUNTRIES." WHERE countries_iso_code_2='".$code."'";
                $countries_name_all=$db->Execute($countries_name_sql);
                $countries_name[]=$countries_name_all->fields['countries_name'];
            }
            $countries_name=implode(",",$countries_name);            
            $returnArray=json_encode($countries_name);
            die($returnArray); 
            }      
        break;
     case 'show_shipping_methods_name':
         $shipping_methods_code=zen_db_input($_POST['shipping_methods']);
         if(!$shipping_methods_code){
             break;
         }
         $shipping_methods_code ="'". str_replace(",","','",$shipping_methods_code)."'";

         $shipping_methods=$db->Execute("SELECT name FROM ".TABLE_SHIPPING." WHERE code in (".$shipping_methods_code.")");

         $shipping_methods_arr = array();
         while(!$shipping_methods->EOF){
             $shipping_methods_arr[] = $shipping_methods->fields['name'];
             $shipping_methods->MoveNext();
         }

         if(count($shipping_methods_arr) < 1){
             $virtual_shipping_methods = $db->Execute("SELECT shipping_name FROM ".TABLE_VIRTUAL_SHIPPING." WHERE shipping_code in (".$shipping_methods_code.")");

             while(!$virtual_shipping_methods->EOF){
                 $shipping_methods_arr[] = $virtual_shipping_methods->fields['shipping_name'];
                 $virtual_shipping_methods->MoveNext();
             }

         }

         $returnArray=json_encode($shipping_methods_arr,JSON_UNESCAPED_UNICODE);
         die($returnArray);
         break;
     case 'shipping_method_validate':
         if(sizeof($_POST['country_iso_code_2'])>=254){
             $_POST['country_iso_code_2']=array();
             unset($_POST['activity_countries_code_all']);
         }
         if(empty($_POST['country_iso_code_2'])){
             $_POST['country_iso_code_2']=array();
         }
         $products_model = trim(zen_db_prepare_input($_POST['products_model']));
         $country_iso_code_2 = zen_db_prepare_input($_POST['country_iso_code_2']);
         $postcode_from = trim(zen_db_prepare_input($_POST['postcode_from']));
         $postcode_to = trim(zen_db_prepare_input($_POST['postcode_to']));
         $postcode_from=preg_replace('/[\s-]/','',strtoupper($postcode_from));
         $postcode_to=preg_replace('/[\s-]/','',strtoupper($postcode_to));
         $country_iso_code_2=implode($country_iso_code_2,",");
         $start_time = trim(zen_db_prepare_input($_POST['start_time']));
         $end_time = trim(zen_db_prepare_input($_POST['end_time']));
         $shipping_method=trim(zen_db_prepare_input($_POST['shipping_methods']));

         $products_model = str_replace(chr(10),',',$products_model);
         $products_model = str_replace(chr(13),'',$products_model);
         $products_model_arr = explode(",",$products_model);
         $products_model_str = implode("','",$products_model_arr);

         $check_model = array();
         if(!empty($products_model_str)){
             $products_model_str = "'".$products_model_str."'";

             $model_check_sql='SELECT products_model FROM '.TABLE_PRODUCTS." WHERE products_model in (".$products_model_str.")";
             $model_check=$db->Execute($model_check_sql);

             while(!$model_check->EOF){
                 $check_model[] = $model_check->fields['products_model'];
                 $model_check->MoveNext();
             }

             $diff = array_diff($products_model_arr,$check_model);

             if($diff){
                 $msg = implode(",",$diff);
                 $products_model_error='保存失败，商品编号不存在!('.$msg.')<br/>';
             }
         }
         if((empty($start_time)&&!empty($end_time))||(!empty($start_time)&&empty($end_time)))
         {$time_error = '保存失败，请填写禁用开始（结束）时间<br/>';}
         if(!empty($start_time)&&$start_time>=$end_time){
             $time_error= '保存失败，结束时间必须大于开始时间!<br/>';
         }
         if(!(postcode_format_check($postcode_from,$postcode_to))){
             $postcode_error= '保存失败，邮编范围有误,请保持格式一致!<br/>';
         }else{
             if($postcode_from!=''&&$postcode_from>$postcode_to){
                 $postcode_error = '保存失败，邮编范围有误!邮编上限必须小于等于邮编下限<br/>';
             }
         }

         $shipping_methods_code ="'". str_replace(",","','",$shipping_method)."'";
         $all_shipping_restriction_sql='select smr_id,shipping_method,products_model,country_iso_code_2,postcode_from,postcode_to,start_time,end_time FROM '.TABLE_SHIPPING_METHOD_RESTRICTION." WHERE shipping_method in(".$shipping_methods_code.") and status=10";
         $all_shipping_restriction=$db->Execute($all_shipping_restriction_sql);
         while(!$all_shipping_restriction->EOF){
             $checking_error=false;
             if(in_array($all_shipping_restriction->fields['products_model'],$check_model) && $country_iso_code_2 == $all_shipping_restriction->fields['country_iso_code_2'] && $postcode_from == $all_shipping_restriction->fields['postcode_from'] && $postcode_to == $all_shipping_restriction->fields['postcode_to'] && (($start_time >= $all_shipping_restriction->fields['start_time'] && $start_time <= $all_shipping_restriction->fields['end_time']) || ($end_time >= $all_shipping_restriction->fields['start_time'] && $end_time <= $all_shipping_restriction->fields['end_time']))) {
             	$checking_error='该条禁运规则与已有禁运规则（ID：'.$all_shipping_restriction->fields['smr_id'].',shipping_method：'.$all_shipping_restriction->fields['shipping_method'].',products_model：'.$all_shipping_restriction->fields['products_model'].'）重合，请修改禁运规则<br/>';
             }
             /*
             $rs=array();
             $rs=$all_shipping_restriction->fields;
         
             $postcode_checking=is_in_postcode_range($rs['postcode_from'],$rs['postcode_to'],$postcode_from,$postcode_to);
             $contry_checking=is_in_countries_restriction($rs['country_iso_code_2'], $country_iso_code_2);
             $products_checking=is_in_products($rs['products_model'],$products_model);
             $time_checking=is_mix_time($rs['start_time'],$rs['end_time'],$start_time,$end_time);
         
             if(!empty($postcode_from)){
                 if(!empty($country_iso_code_2)){
                     if(!empty($products_model)){
                         if(!empty($start_time)){//设置了邮编+国家+产品ID+时间
                             if($postcode_checking&&$contry_checking&&$products_checking&&$time_checking){
                                 $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                             }
                         }else{//设置了邮编+国家+产品ID
                             if($postcode_checking&&$contry_checking&&$products_checking){
                                 $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                             }
                         }
                     }elseif(!empty($start_time)){//设置了邮编+国家+时间
                         if($postcode_checking&&$contry_checking&&$time_checking){
                             $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                         }
                     }else{//设置了邮编+国家
                         if($postcode_checking&&$contry_checking){
                             $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                         }
                     }
                 }elseif(!empty($products_model)){
                     if(!empty($start_time)){//设置了邮编+商品ID+时间
                         if($postcode_checking&&$products_checking&&$time_checking){
                             $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                         }
                     }else{//设置了邮编+商品ID
                         if($postcode_checking&&$products_checking){
                             $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                         }
                     }
                 }elseif(!empty($start_time)){//设置了邮编+时间
                     if($postcode_checking&&$time_checking){
                         $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                     }
                 }else{//设置邮编
                     if($postcode_checking){
                         $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                     }
                 }
             }elseif(!empty($country_iso_code_2)&&empty($postcode_from)){
                 if(!empty($products_model)){
                     if(!empty($start_time)){ // 设置了国家+商品id+时间
                         if($contry_checking&&$products_checking&&$time_checking){
                             $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                         }
                     }else{ // 设置了国家 + 商品id
                         if($contry_checking&&$products_checking){
                             $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                         }
                     }
                 }else{
                     if(!empty($start_time)){ // 设置了国家+时间
                         if($contry_checking&&$time_checking){
                             $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                         }
                     }else{ // 只设置了国家
                         if($contry_checking){
                             $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                         }
                     }
                 }
             }elseif(!empty($products_model)&&empty($country_iso_code_2)&&empty($postcode_from)){
                 if (!empty($start_time)){ // 设置了商品id+时间
                     if($products_checking&&$time_checking){
                         $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                     }
                 }else{ // 只设置了商品id
                     if($products_checking){
                         $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                     }
                 }
             }else{
                 if(!empty($start_time)&&empty($products_model)&&empty($country_iso_code_2)&&empty($postcode_from)){ // 设置时间
                     if($time_checking){
                         $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                     }
                 }
                 if(empty($start_time)&&empty($products_model)&&empty($country_iso_code_2)&&empty($postcode_from)){//只设置了运输方式
                     $checking_error='该条禁运规则与已有禁运规则（ID：'.$rs['smr_id'].'）重合，请修改禁运规则<br/>';
                 }
             }
             */
         
             if($checking_error){
                 break;
             }else{
                 $all_shipping_restriction->MoveNext();
             }
         }
         $checking_error_info=array(
             'products_model_error'=>$products_model_error,
             'time_error'=>$time_error,
             'postcode_error'=>$postcode_error,
             'checking_error'=>$checking_error         
         );
         $returnArray=json_encode($checking_error_info,JSON_UNESCAPED_UNICODE);
         die($returnArray);
         break;
}
?>