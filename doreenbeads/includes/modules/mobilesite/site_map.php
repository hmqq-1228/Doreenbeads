<?php
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));


/* $top_categories_query = $db->Execute("select c.categories_id, cd.categories_name 
		from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
		where c.categories_id=cd.categories_id
		and c.parent_id=0
		and c.categories_status=1
		and cd.language_id='".$_SESSION['languages_id']."'
		order by c.sort_order"); */

$top_categories_query = $db->Execute("select c.categories_id from ".TABLE_CATEGORIES." c where c.parent_id=0 and c.categories_status=1 order by c.sort_order");

$sitemap_content = '';
while(!$top_categories_query->EOF){
	$top_cate_id = $top_categories_query->fields['categories_id'];
	$top_categories_query_description = get_category_info_memcache($top_cate_id, 'detail', $_SESSION['languages_id']);
	$top_categories_query->fields['categories_name'] = $top_categories_query_description['categories_name'];
	$products_count = get_category_info_memcache($top_cate_id , 'products_count');
	if ($products_count > 0){
		$sitemap_content.= '<dt><a href="'.zen_href_link(FILENAME_DEFAULT, 'cPath='.$top_cate_id).'">'.$top_categories_query->fields['categories_name'].'</a></dt>';
	
		/* $second_categories_query = $db->Execute("select c.categories_id, cd.categories_name 
			from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
			where c.categories_id=cd.categories_id
			and c.parent_id=".$top_cate_id."
			and c.categories_status=1
			and cd.language_id='".$_SESSION['languages_id']."'
			order by c.sort_order"); */
		
		$second_categories_query = $db->Execute("select c.categories_id from ".TABLE_CATEGORIES." c where c.parent_id=".$top_cate_id." and c.categories_status=1 order by c.sort_order");
		
		while(!$second_categories_query->EOF){
			$second_cate_id = $second_categories_query->fields['categories_id'];
			$second_categories_query_description = get_category_info_memcache($second_cate_id, 'detail', $_SESSION['languages_id']);
			$second_categories_query->fields['categories_name'] = $second_categories_query_description['categories_name'];
			$products_count = get_category_info_memcache($second_cate_id , 'products_count');
			if ($products_count > 0){		
				$sitemap_content.= '<dd><a href="'.zen_href_link(FILENAME_DEFAULT, 'cPath='.$second_cate_id).'">'.$second_categories_query->fields['categories_name'].'</a></dd>';	
			}
			$second_categories_query->MoveNext();
		}
	}
	$top_categories_query->MoveNext();
}

$smarty->assign('hide_session_id', zen_hide_session_id());

$breadcrumb->add(TEXT_SITEMAP);
$smarty->assign('category_list', $sitemap_content);
?>