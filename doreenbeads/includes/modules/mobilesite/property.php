<?php 
$pcontents='';
$properties_str='';
$properties_group_array=array();
$properties_show_array=array();
$getsProInfo=array();
$propery_count=34;
$refine_by_properties = array();

foreach($properties_facet as $prop_id=>$cnt){
	if(is_numeric($prop_id)){
		$propery_num= $cnt;
		$property_name = '';
		$property_group_id = '';
		if(isset($memcache)){
			$mem_property_key = 'property_'.$prop_id.'_'.$_SESSION['languages_id'];
			$property_data = $memcache->get($mem_property_key);
			$property_name = $property_data->name;
			$property_group_id = $property_data->group_id;
		}
		if($property_name=='' || $property_group_id==''){
			$property_sql_query = $db->Execute('select p.property_id,property_group_id,pd.property_name from '.TABLE_PROPERTY.' p, '.TABLE_PROPERTY_DESCRIPTION.' pd where pd.property_id=p.property_id and p.property_status=1 and pd.languages_id='.$_SESSION['languages_id'].' and p.property_id = '.(int)$prop_id.' order by p.sort_order,p.property_id');
			if($property_sql_query->RecordCount()>0){
				$property_name = $property_sql_query->fields['property_name'];
				$property_group_id = $property_sql_query->fields['property_group_id'];
				$mem_data_object = new stdClass;
				$mem_data_object->name= $property_name;
				$mem_data_object->group_id = $property_group_id;
				if(isset($memcache)) $memcache->set($mem_property_key, $mem_data_object, false, 86400*7);
			}else{
				continue;
			}
		}
		$properties_group_array[$property_group_id][$prop_id]=
		array(
				'id'=>$prop_id,
				'name'=>$property_name,
				'num'=>$propery_num,
				'sort'=>zen_num_change_to_char($propery_num+34).'!'.zen_num_change_to_char($propery_count)
		);
		$propery_count++;		
	}
}

/*
$properties_str=rtrim($properties_str,',');
if($properties_str==''){$properties_str='""';}

$properties_query='select p.property_id,property_group_id,pd.property_name from '.TABLE_PROPERTY.' p, '.TABLE_PROPERTY_DESCRIPTION.' pd where pd.property_id=p.property_id and p.property_status=1 and pd.languages_id='.$_SESSION['languages_id'].' and p.property_id in ('.$properties_str.') order by p.sort_order,p.property_id';

$properties_result=$db->Execute($properties_query);
$propery_count=34;

while(!$properties_result->EOF){
		
		$propery_num=$properties_facet->{$properties_result->fields['property_id']};
		$properties_group_array[$properties_result->fields['property_group_id']][$properties_result->fields['property_id']]=
		array(
				'id'=>$properties_result->fields['property_id'],
				'name'=>$properties_result->fields['property_name'],
				'num'=>$propery_num,
				'sort'=>zen_num_change_to_char($propery_num+34).'!'.zen_num_change_to_char($propery_count)
		);
		$propery_count++;	
	$properties_result->MoveNext();
}
*/
if(sizeof($properties_group_array)>0){
	$keys_array=array_keys($properties_group_array);
	$keys_str=implode($keys_array, ',');
	$properties_group_query='select pg.property_group_id,pgd.property_group_name, pg.sort_type from '.TABLE_PROPERTY_GROUP.' pg ,'.TABLE_PROPERTY_GROUP_DESCRIPTION.' pgd where pg.property_group_id=pgd.property_group_id and group_status=1 and pgd.languages_id='.$_SESSION['languages_id'].' and pg.property_group_id in ('.$keys_str.')  order by pg.sort_order,pg.property_group_id ';
	
	$properties_group_result=$db->Execute($properties_group_query);
	while(!$properties_group_result->EOF){
		$properties_show_array[]=array('gid'=>$properties_group_result->fields['property_group_id'],'gname'=>$properties_group_result->fields['property_group_name'],'sort_type'=>$properties_group_result->fields['sort_type']);
		$properties_group_result->MoveNext();
	}
}


$pcontents .= '<div class="windowbg" style="display:none;"></div><div class="refine-right"><span class="refine-arrow"></span><h1>'.TEXT_REFINE_BY_WORDS.'</h1>';
if(sizeof($properties_show_array)>0){
	$pcount=$_GET['pcount'];
	$plink=zen_href_link($current_page_base,'p'.($pcount+1).'=%PRONUM%&'.zen_get_all_get_params_reverse(array('pcount','page')).'&pcount='.($pcount+1));
	$pchecknum=0;
	$selected_content = '<div class="select-content">'.TEXT_SELECTED.':';
	$unselected_content = '';
	$cancel_selected_content = '';
    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) {
        $products_display_solr_str = '';
    } else {
        $products_display_solr_str = ' AND is_display:1';
    }

	foreach($properties_show_array as $vals){
		//$pcontents.= '<dl class="navlist_refine"><dt>'.$vals['gname'].'</dt><dd><ul class="navlist_list">';
		$pcheck=false;
		if($pchecknum<$pcount){
			foreach($getsInfoArray as $pkey=>$pget){
				if(isset($properties_group_array[$vals['gid']][$pget])){
					$pcheck=true;
					$pchecknum++;
					$pgetKey[$pget]=$pkey;
					//break;
				}
			}
		}
		//re-group selected property values
		if($pcheck){
			$properties_select_exclude='';
			foreach($property_by_group as $pg=>$pv){
				if($pg!=$vals['gid']){
					$properties_select_exclude.= ' AND (';
					for($prop_cnt=0;$prop_cnt<sizeof($pv);$prop_cnt++){
						if($prop_cnt>0) $properties_select_exclude.=' OR ';
						$properties_select_exclude.=' properties_id:'.$pv[$prop_cnt];
					}
					$properties_select_exclude.=' )';
				}
			}
			$property_solr_query = $extra_select_str . $properties_select_exclude . $products_display_solr_str;


			$solr_property_data = $solr->search($property_solr_query, $search_offset, $item_per_page ,$condition);
			$properties_facet_exclude = $solr_property_data->facet_counts->facet_fields->properties_id;
			
			$properties_group_array[$vals['gid']] = array();
			foreach($properties_facet_exclude as $prop_id=>$cnt){
				if(is_numeric($prop_id)){
					$propery_num= $cnt;
					$property_name = '';
					$property_group_id = '';
					if(isset($memcache)){
						$mem_property_key = 'property_'.$prop_id.'_'.$_SESSION['languages_id'];
						$property_data = $memcache->get($mem_property_key);
						$property_name = $property_data->name;
						$property_group_id = $property_data->group_id;
					}
					if($property_name==''){
						$property_sql_query = $db->Execute('select p.property_id,property_group_id,pd.property_name from '.TABLE_PROPERTY.' p, '.TABLE_PROPERTY_DESCRIPTION.' pd where pd.property_id=p.property_id and p.property_status=1 and pd.languages_id='.$_SESSION['languages_id'].' and p.property_id = '.(int)$prop_id);
						if($property_sql_query->RecordCount()>0){
							$property_name = $property_sql_query->fields['property_name'];
							$property_group_id = $property_sql_query->fields['property_group_id'];
							$mem_data_object = new stdClass;
							$mem_data_object->name= $property_name;
							$mem_data_object->group_id = $property_group_id;
							if(isset($memcache)) $memcache->set($mem_property_key, $mem_data_object, false, 86400*7);
						}else{
							continue;
						}
					}
					if($property_group_id==$vals['gid']){
						$properties_group_array[$vals['gid']][$prop_id]=
						array(
							'id'=>$prop_id,
							'name'=>$property_name,
							'num'=>$propery_num,
							'sort'=>zen_num_change_to_char($propery_num+34).'!'.zen_num_change_to_char($propery_count)
						);
						$propery_count++;
					}
			
				}
			}
			/*
			$properties_str_exclude='';
			foreach($properties_facet_exclude as $prop_id=>$cnt){
				if(is_numeric($prop_id)){
					$properties_str_exclude.=$prop_id.',';
				}
			}
			$properties_str_exclude=rtrim($properties_str_exclude,',');
			if($properties_str_exclude==''){$properties_str_exclude='""';}
						
			$properties_exclude_result=$db->Execute('select p.property_id,pd.property_name from '.TABLE_PROPERTY.' p, '.TABLE_PROPERTY_DESCRIPTION.' pd where pd.property_id=p.property_id and p.property_status=1 and pd.languages_id='.$_SESSION['languages_id'].' and property_group_id='.$vals['gid'].' and p.property_id in ('.$properties_str_exclude.') order by p.sort_order,p.property_id');	
			
			$properties_group_array[$vals['gid']] = array();
			while(!$properties_exclude_result->EOF){
				$propery_selected_num=$properties_facet_exclude->{$properties_exclude_result->fields['property_id']};
				$properties_group_array[$vals['gid']][$properties_exclude_result->fields['property_id']]=
				array(
						'id'=>$properties_exclude_result->fields['property_id'],
						'name'=>$properties_exclude_result->fields['property_name'],
						'num'=>$propery_selected_num,
						'sort'=>zen_num_change_to_char($propery_selected_num+34).'!'.zen_num_change_to_char($propery_count)
				);
				$propery_count++;
				
				$properties_exclude_result->MoveNext();
			}
			*/
		}
		

			$prokey=0;
			if($vals['sort_type']==1){
				$propery_value_list=$properties_group_array[$vals['gid']];
			}else{
				$propery_value_list=array_sort($properties_group_array[$vals['gid']],'sort','desc');			
			}	
			//var_dump($propery_value_list);
			$refine_by_properties [] = array(
					"property" => $vals,
					"property_values" =>$propery_value_list
			);
			
			$unselected_content.='<p class="refine-tit"><span></span>'.$vals['gname'].':</p><ul>';
			foreach($propery_value_list as $pro){
				if(in_array($pro['id'], $getsInfoArray)){
					$ptrail=$pcount>1?'&pcount='.($pcount-1):'';
					$pi=1;
					$pstr='';
					foreach($getsInfoArray as $gkey=>$gval){
						if($gval!=$pro['id']){
							$pstr='p'.$pi.'='.$gval.'&'.$pstr;
							$pi++;
						}
					}						
					
					$checkLink=zen_href_link($current_page_base,$pstr.zen_get_all_get_params_reverse($delArray).$ptrail);
					$getsProInfo[$pgetKey[$pro['id']]]=array('id'=>$pro['id'],'name'=>$pro['name'],'link'=>$checkLink);
					//$pcontents.= '<li class="selectedLi"><a href="'.$checkLink.'"><input type="checkbox" checked="checked"><span>'.$pro['name'].' ('.$pro['num'].')</span><ins></ins></a></li>';
			
					$selected_content.='<p>'.$vals['gname'].': '.$pro['name'].' ('.$pro['num'].')</p>';
					$cancel_selected_content.='<a href="'.$checkLink.'"><span>X</span>'.$vals['gname'].': <ins>'.$pro['name'].' ('.$pro['num'].')</ins></a>';
					$unselected_content.='<li class="selectedLi" ><a href="'.$checkLink.'">'.$pro['name'].' ('.$pro['num'].')<span>X</span></a></li>';
					
				}else{
					
					if($prokey>5 && !$pcheck){
						$unselected_content.='<li class="morelist"><a href="'.str_replace('%PRONUM%', $pro['id'], $plink).'">'.$pro['name'].' ('.$pro['num'].')</a></li>';
					}else{
						$unselected_content.='<li ><a href="'.str_replace('%PRONUM%', $pro['id'], $plink).'">'.$pro['name'].' ('.$pro['num'].')</a></li>';
					}
					
				}
				$prokey++;
			}
			
			if(sizeof($properties_group_array[$vals['gid']])>6&& !$pcheck){
				//$pcontents.= '<p class="navlist_more" style="display: block;"><a href="javascript:void(0);">'.TEXT_MORE_PRO.'...</a></p>';
				$unselected_content.= '<li class="more"><p><a href="javascript:void(0)">'.TEXT_MORE_PRO.'...</a></p></li> ';
				$unselected_content.='<li class="less"><p><a href="javascript:void(0)">'.TEXT_VIEW_LESS.'...</a></p></li>';
				
			}
			$unselected_content.= '</ul>';
		
		
	
	}
	if($pcount) {
		$pcontents.=$selected_content.'</div>';
		$cancel_selected_content='<div class="already-select">'.$cancel_selected_content.'</div>';
	}
	$pcontents.=$unselected_content;
}
$pcontents .= '</div>';

$property_clear_all_link = zen_href_link($current_page_base,zen_get_all_get_params_reverse($delArray));

$smarty->assign('property_clear_all_link',$property_clear_all_link);
//var_dump($cancel_selected_content);die();
$smarty->assign('refine_by_properties',$refine_by_properties);

$smarty->assign('property_cancel',$cancel_selected_content);
$smarty->assign('property_refine',$pcontents);

?>