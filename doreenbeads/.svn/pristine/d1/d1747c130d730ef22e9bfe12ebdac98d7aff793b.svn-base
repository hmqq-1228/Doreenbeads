<?php
/**
 * @package Admin Profiles
 * @copyright Copyright Kuroi Web Design 2009
 * @copyright Portions Copyright 2003-2008 The Zen Cart Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: configuration_dhtml.php 366 2010-05-23 19:56:46Z kuroi $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$za_contents = array();
$za_heading = array();
$za_heading = array('text' => BOX_HEADING_CONFIGURATION, 'link'  => zen_href_link(basename($PHP_SELF), zen_get_all_get_params(array('selected_box')) . 'selected_box=configuration'));

$sql = "SELECT configuration_group_id as cgID, configuration_group_title AS cgTitle 
        FROM " . TABLE_CONFIGURATION_GROUP . " 
        WHERE visible = '1'
        ORDER BY sort_order";
$cfg_groups = $db->Execute($sql);
while (!$cfg_groups->EOF) {
  $za_contents[] = array('text' => $cfg_groups->fields['cgTitle'], 'link' => zen_href_link(FILENAME_CONFIGURATION, 'gID=' . $cfg_groups->fields['cgID'], 'NONSSL'));
  $cfg_groups->MoveNext();
}
?>

<!-- configuration -->
<?php
echo zen_draw_admin_box($za_heading, $za_contents);
?>
<!-- configuration_eof //-->