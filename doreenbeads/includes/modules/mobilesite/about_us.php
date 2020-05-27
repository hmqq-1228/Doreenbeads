<?php


require('includes/languages/'.$_SESSION['language'].'/contact_us.php');


require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

$link_contact_us = zen_href_link(FILENAME_CONTACT_US,'','SSL');
$link_help_center= zen_href_link(FILENAME_HELP_CENTER,'','SSL');
$link_testimonial= zen_href_link(FILENAME_TESTIMONIAL,'','SSL');


$smarty->assign('link_contact_us',$link_contact_us);
$smarty->assign('link_help_center',$link_help_center);
$smarty->assign('link_testimonial',$link_testimonial);
?>