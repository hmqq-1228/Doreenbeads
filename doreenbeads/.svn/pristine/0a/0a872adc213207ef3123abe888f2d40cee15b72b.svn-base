<?php
/**
 * site_map.php
 *
 * @package general
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: site_map.php 3041 2006-02-15 21:56:45Z wilt $
 */
if (! defined ( 'IS_ADMIN_FLAG' )) {
	die ( 'Illegal Access' );
}
/**
 * site_map.php
 *
 * @package general
 */
class zen_SiteMapTree {
	var $root_category_id = 0, 
	$max_level = 0, 
	$data = array (), 
	$root_start_string = '<h2>', 
	$root_end_string = '</h2>', 
	$parent_start_string = '<h2>', 
	$parent_end_string = '</h2>', 
	$parent_group_start_string = "\n<ul>", 
	$parent_group_end_string = "</ul>\n", 
	$child_start_string = '<li>', 
	$child_end_string = "</li>\n", 
	$spacer_string = '', 
	$spacer_multiplier = 1, 
	$j = 0, //第j个二级下面的所有子及类别
	$i = 0, //第i个二级类别
	$second_length = 0, //二级类别长度
	$second_son_length = 0; //二级类别下的所有子类别长度
	function zen_SiteMapTree($load_from_database = true) {
		global $languages_id, $db,$memcache;
		$this->data = array ();
		//WSl
	/* 	$categories_query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_level
                      from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                      where c.categories_id = cd.categories_id
                      and cd.language_id = '" . ( int ) $_SESSION ['languages_id'] . "'
                      and c.categories_status != '0'
                      order by c.parent_id, c.sort_order, cd.categories_name";
		
		$categories = $db->Execute ( $categories_query );
		while ( ! $categories->EOF ) {
			if($categories->fields ['categories_level'] <= (int)$_SESSION['customers_level']) {
				$this->data [$categories->fields ['parent_id']] [$categories->fields ['categories_id']] = array ('name' => $categories->fields ['categories_name']);
			}
			$categories->MoveNext ();
		} */
		
		$sql = 'select categories_id, parent_id, categories_level from ' . TABLE_CATEGORIES . ' where categories_status != 0 order by parent_id, sort_order';
		$sql_query = $db->Execute($sql);
		while ( !$sql_query->EOF ){
			$categories_name_query = get_category_info_memcache($sql_query->fields['categories_id'], 'detail', $_SESSION ['languages_id']);
			if ($sql_query->fields['categories_level'] <= (int)$_SESSION['customers_level']) {
				$this->data[$sql_query->fields['parent_id']][$sql_query->fields['categories_id']] = array('name' => $categories_name_query['categories_name']);
			}
			$sql_query->MoveNext();
		}
	}	
	
	function buildBranch($parent_id, $level = 0, $parent_link = '') {
		$result = $this->parent_group_start_string;		
		if (isset ( $this->data [$parent_id] )) {
			foreach ( $this->data [$parent_id] as $category_id => $category ) {
				$category_link = $parent_link . $category_id;
				$result .= $this->child_start_string;
				if (isset ( $this->data [$category_id] )) {
					$result .= $this->parent_start_string;
				}				
				if ($level == 0) {
					$result .= $this->root_start_string;
				}
				$result .= str_repeat ( $this->spacer_string, $this->spacer_multiplier * $level ) . '<a href="' . zen_href_link ( FILENAME_DEFAULT, 'cPath=' . $category_link ) . '">';
				$result .= $category ['name'];
				$result .= '</a>';				
				if ($level == 0) {
					$result .= $this->root_end_string;
				}				
				if (isset ( $this->data [$category_id] )) {
					$result .= $this->parent_end_string;
				}				
				// $result .= $this->child_end_string;				
				if (isset ( $this->data [$category_id] ) && (($this->max_level == '0') || ($this->max_level > $level + 1))) {
					$result .= $this->buildBranch ( $category_id, $level + 1, $category_link . '_' );
				}
				$result .= $this->child_end_string;
			}
		}		
		$result .= $this->parent_group_end_string;		
		return $result;
	}
	function buildTree() {
		return $this->buildBranch1 ( $this->root_category_id );
	}
	function getSonCateLength($parent_id, $length){
		$length += count($this->data [$parent_id]);
		if (isset ( $this->data [$parent_id] )) {
			foreach ( $this->data [$parent_id] as $category_id => $category ) {				
				if (isset ( $this->data [$category_id] )) {
					$length = $this->getSonCateLength ( $category_id, $length );
				}
			}
		}
		return $length;
	}
	function buildBranch1($parent_id, $level = 0, $parent_link = '') {
		if (isset ( $this->data [$parent_id] )) {
			$cate_tree = '';
			foreach ( $this->data [$parent_id] as $category_id => $category ) {
				$products_count = get_category_info_memcache($category_id , 'products_count');
				if ($products_count > 0){
					$category_link = $parent_link . $category_id;
					$result = '<div class="categoriescont">';
					$result .= '<h2><a href="' . zen_href_link ( FILENAME_DEFAULT, 'cPath=' . $category_link ) . '">';
					$result .= $category ['name'] . ' >>';
					$result .= '</a></h2>';
					if (isset ( $this->data [$category_id] )) {
						$result .= $this->getSecondCate ( $category_id, $category_link . '_' );
					}
					$result .= '</div>';
					$cate_tree .= $result;
				}
			}
		}
		return $cate_tree;
	}
	function getSecondCate($parent_id, $parent_link = '') {
		if (isset ( $this->data [$parent_id] )) {
			$result = '<div class="categoriescont_inner"><ul>';
			$this->second_length = sizeof($this->data [$parent_id]);
			foreach ( $this->data [$parent_id] as $category_id => $category ) {
				$products_count = get_category_info_memcache($category_id , 'products_count');
				if ($products_count == 0){
					$this->second_length--;
				}
			}
			$this->second_son_length = $this->getSonCateLength($parent_id, $length) - $this->second_length;
			$this->j = 1;
			$this->i = 1;
			foreach ( $this->data [$parent_id] as $category_id => $category ) {
				$products_count = get_category_info_memcache($category_id , 'products_count');
				if ($products_count > 0){
					$category_link = $parent_link . $category_id;
					$result .= '<li><h2><a href="' . zen_href_link ( FILENAME_DEFAULT, 'cPath=' . $category_link ) . '">' . $category ['name'] . ' >> </a></h2></li>';
					if (isset ( $this->data [$category_id] )) {
						$result .= $this->getThirdCate ( $category_id, $category_link . '_' );
					}
					if ($this->i == $this->second_length){
						$result .= '</ul>';
					}
					if ($this->i % ceil($this->second_length / 4) == 0 && $this->i < $this->second_length){
						$result .= '</ul><ul>';
					}
					$this->i++;
				}				
			}
			$result .= '<br class="clearBoth"></div>';
		}
		return $result;
	}
	function getThirdCate($parent_id, $parent_link = '') {
		if (isset ( $this->data [$parent_id] )) {
			$result = '';
			foreach ( $this->data [$parent_id] as $category_id => $category ) {
				$products_count = get_category_info_memcache($category_id , 'products_count');
				if ($products_count > 0){
					$category_link = $parent_link . $category_id;
					$result .= '<li class="thirdCateLi"><a href="' . zen_href_link ( FILENAME_DEFAULT, 'cPath=' . $category_link ) . '">' . $category ['name'] . '</a>';
					if (isset ( $this->data [$category_id] )) {
						$result .= $this->getFourthCate ( $category_id, $category_link . '_' );
					}
					$result .= '</li>';
					$this->j++;
				}
			}
		}
		return $result;
	}
	function getFourthCate($parent_id, $parent_link = '') {
		if (isset ( $this->data [$parent_id] )) {
			$result = '<ul>';
			foreach ( $this->data [$parent_id] as $category_id => $category ) {
				$products_count = get_category_info_memcache($category_id , 'products_count');
				if ($products_count > 0){
					$category_link = $parent_link . $category_id;
					$result .= '<li><a href="' . zen_href_link ( FILENAME_DEFAULT, 'cPath=' . $category_link ) . '">' . $category ['name'] . '</a></li>';				
					$this->j++;
				}
			}
			$result .= '</ul>';			
		}
		return $result;
	}
}
?>