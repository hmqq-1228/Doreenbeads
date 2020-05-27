<?php
/**
 * Links Listing
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_links_listing.php 3.4.0 3/27/2008 Clyde Jones $
 */
  class linkListingBox extends tableBox {
    function linkListingBox($contents) {
      $this->table_parameters = 'class="linkListing"';
      $this->tableBox($contents, true);
    }
  }

  $listing_split = new splitPageResults($listing_sql, 10, 'l.links_id');

  if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>
<div>
    <div class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_LINKS); ?></div>
    <div class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></div>
</div>

<?php
  }
?>

<?php 
if ($listing_split->number_of_rows > 0) {
	echo '<table id="links_list">';
    $rows = 0;
    $listing_query = $db->Execute($listing_split->sql_query);
	while (!$listing_query->EOF) {
      $rows++;
      if (($rows/2) == floor($rows/2)) {
        $list_box_contents[] = array('params' => 'class="productListing-even"');
      } else {
        $list_box_contents[] = array('params' => 'class="productListing-odd"');
      }
      $link_url = zen_get_links_url($listing_query->fields['links_id']);
	  if (DISPLAY_LINK_DESCRIPTION_AS_LINK == 'true') {
           	$lc_text = '<tr><td><a href="' . $link_url . '" target="_blank">' . $listing_query->fields['links_title'] . 
           		'</a><br /><a href="' . $link_url . '" target="_blank">' . $listing_query->fields['links_description'] . '</a></td></tr><tr><td>&nbsp;</td></tr>';  
        }else {
           	$lc_text = '<tr><td><a href="' . $link_url . '" target="_blank">' . $listing_query->fields['links_title'] . '</a><br />' 
           	. $listing_query->fields['links_description'].'</td></tr><tr><td>&nbsp;</td></tr>'; 
      }
      echo $lc_text;
       $listing_query->MoveNext();
	}
	echo '</table>';
?>
<div id="link_submit_site"><?php echo '<a href="' . $static_submit_link . '">' . TEXT_SUBMIT_YOUR_SITE . '</a>'; ?></div>
<?php 
}else {
	echo TEXT_THRER_NO_LINK;
}
?>
<p>&nbsp;</p><p>&nbsp;</p>
<?php

  if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {

?>
<div>
    <div class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_LINKS); ?></div>
    <div class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></div>
</div>
<?php
  }
?>