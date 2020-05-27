<?php
/**
 * jscript_googleanalytics_outgoing.php
 *
 * @package zen-cart analytics
 * @copyright Copyright 2004-2008 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2007 http://designformasters.info/posts/google-analytics-advanced-use/
 * @copyright Portions Copyright 2003-2008 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer_googleanalytics.php, v 2.2 19.08.2008 15:03 Andrew Berezin $
 */
@define('GOOGLE_ANALYTICS_TRACKING_OUTBOUND', 'true');
@define('GOOGLE_ANALYTICS_TRACKING_OUTBOUND_LINKS_PREFIX', '/outgoing/');
if(GOOGLE_ANALYTICS_TRACKING_OUTBOUND == 'true') {
?>
<script type="text/javascript">
<!--
  var GOOGLE_ANALYTICS_TRACKING_OUTBOUND_LINKS_PREFIX = "<?php echo GOOGLE_ANALYTICS_TRACKING_OUTBOUND_LINKS_PREFIX; ?>";
//-->
</script>
<script type="text/javascript" async="async" src="<?php echo $template->get_template_dir('googleanalytics_outgoing.js',DIR_WS_TEMPLATE, $current_page_base,'jscript'). '/googleanalytics_outgoing.js'; ?>"></script>
<?php
} else {
?>
<script type="text/javascript">
<!--
function googleanalytics_outgoing_init() {
  return;
}
//-->
</script>
<?php
}
// http://www.google.com/support/googleanalytics/bin/static.py?page=troubleshooter.cs&problem=tracking&selected=tracking_downloads&ctx=tracking_tracking_downloads_55529
/*
Google Analytics provides an easy way to track clicks on links that lead to file downloads. Because these links do
not lead to a page on your site containing the tracking code, you'll need to tag the link itself with the
 _trackPageview() JavaScript if you would like to track these downloads. This piece of JavaScript assigns a
 pageview to any click on a link - the pageview is attributed to the filename you specify.

For example, to log every click on a particular link to www.example.com/files/map.pdf as a pageview for
/downloads/map you would add the following attribute to the link's <a> tag:

    <a href="http://www.example.com/files/map.pdf" onClick="javascript: pageTracker._trackPageview('/downloads/map'); ">
*/
?>