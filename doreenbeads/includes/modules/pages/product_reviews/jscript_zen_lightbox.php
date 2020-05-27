<?php
/**
 * Zen Lightbox v1.4
 *
 * @author Alex Clarke (aclarke@ansellandclarke.co.uk)
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_zen_lightbox.php 2007-09-15 aclarke $
 */

echo '<script type="text/javascript" src="' . $template->get_template_dir('.js',DIR_WS_TEMPLATE, $current_page_base,'jscript') . '/lightbox_lightningload.js"></script>
<script type="text/javascript" src="' . $template->get_template_dir('.js',DIR_WS_TEMPLATE, $current_page_base,'jscript') . '/lightbox_prototype.js"></script>
<script type="text/javascript" src="' . $template->get_template_dir('.js',DIR_WS_TEMPLATE, $current_page_base,'jscript') . '/lightbox_scriptaculous.js?load=effects"></script>
';

?>
<script language="javascript" type="text/javascript"><!--
var fileLoadingImage = "<?php echo $template->get_template_dir('.gif', DIR_WS_TEMPLATE, $current_page_base,'images'). '/zen_lightbox/' . 'loading.gif'; ?>";
var fileBottomNavCloseImage = "<?php echo $template->get_template_dir('.gif', DIR_WS_TEMPLATE, $current_page_base,'images'). '/zen_lightbox/' . 'closelabel.gif'; ?>";
var overlayOpacity = <?php echo ZEN_LIGHTBOX_OVERLAY_OPACITY; ?>;
var overlayDuration = <?php echo ZEN_LIGHTBOX_OVERLAY_DURATION; ?>;
var animate = <?php echo ZEN_LIGHTBOX_RESIZE_ANIMATIONS; ?>;
var resizeSpeed = <?php echo ZEN_LIGHTBOX_RESIZE_SPEED; ?>;
var borderSize = <?php echo ZEN_LIGHTBOX_BORDER_SIZE; ?>;

<?php

if (ZEN_LIGHTBOX_CLOSE_OVERLAY == 'true') {

echo 'var objOverlay = document.createElement("div");
objOverlay.setAttribute(\'id\',\'overlay\');
objOverlay.style.display = \'none\';
objOverlay.onclick = function() { myLightbox.end(); }
		
var objLightbox = document.createElement("div");
objLightbox.setAttribute(\'id\',\'lightbox\');
objLightbox.style.display = \'none\';
objLightbox.onclick = function(e) {
if (!e) var e = window.event;
var clickObj = Event.element(e).id;
if ( clickObj == \'lightbox\') {
myLightbox.end();
}
};';

} else {

echo 'var objOverlay = document.createElement("div");
objOverlay.setAttribute(\'id\',\'overlay\');
objOverlay.style.display = \'none\';
		
var objLightbox = document.createElement("div");
objLightbox.setAttribute(\'id\',\'lightbox\');
objLightbox.style.display = \'none\';';

}

if (ZEN_LIGHTBOX_HIDE_FLASH == 'true') {

echo 'function hideFlash(){
var flashObjects = document.getElementsByTagName("object");
for (i = 0; i < flashObjects.length; i++) {
flashObjects[i].style.visibility = "hidden";
}

var flashEmbeds = document.getElementsByTagName("embed");
for (i = 0; i < flashEmbeds.length; i++) {
flashEmbeds[i].style.visibility = "hidden";
}
}';

} else {

echo 'function hideFlash(){
}';

}

echo 'function showSelectBoxes(){
var selects = document.getElementsByTagName("select");
for (i = 0; i != selects.length; i++) {
selects[i].style.visibility = "visible";
}
flashObjects = document.getElementsByClassName(\'' . ZEN_LIGHTBOX_HIDE_ME . '\')
flashObjects.each(function(object){
Element.show(object);
})
}

function hideSelectBoxes(){
var selects = document.getElementsByTagName("select");
for (i = 0; i != selects.length; i++) {
selects[i].style.visibility = "hidden";
}
flashObjects = document.getElementsByClassName(\'' . ZEN_LIGHTBOX_HIDE_ME . '\')
flashObjects.each(function(object){
Element.hide(object);
})
}';

?>

//--></script>
<?php echo '<script type="text/javascript" src="' . $template->get_template_dir('.js',DIR_WS_TEMPLATE, $current_page_base,'jscript') . '/lightbox.js"></script>'; ?>