/**
 * googleanalytics_outgoing.js
 *
 * @package zen-cart analytics
 * @copyright Copyright 2004-2008 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2007 http://designformasters.info/posts/google-analytics-advanced-use/
 * @copyright Portions Copyright 2003-2008 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer_googleanalytics.php, v 2.2 19.08.2008 15:03 Andrew Berezin $
 */
// http://www.google.com/support/googleanalytics/bin/static.py?page=troubleshooter.cs&problem=tracking&selected=tracking_outbound
/*
Google Analytics provides an easy way to track clicks on links that lead away from your site.
Because these links do not lead to a page on your site containing the UTM JavaScript, you will
need to tag the link itself. This piece of JavaScript assigns a pageview to any click on a
link - the pageview is attributed to the filename you specify.

For example, to log every click on a particular link to www.example.com as a pageview for "/outgoing/example_com"
you would add the following attribute to the link's tag:

    <a href="http://www.example.com" onClick="javascript: pageTracker._trackPageview('/outgoing/example.com');">

It is a good idea to log all of your outbound links into a logical directory structure as shown in the example.
This way, you will be able to easily identify what pages visitors clicked on to leave your site.
*/
var googleanalytics_addListener = function() {
  if ( window.addEventListener ) {
    return function(el, type, fn) {
      el.addEventListener(type, fn, false);
    };
  } else if ( window.attachEvent ) {
    return function(el, type, fn) {
      var f = function() {
        fn.call(el, window.event);
      };
      el.attachEvent('on'+type, f);
    };
  } else {
    return function(el, type, fn) {
      element['on'+type] = fn;
    }
  }
}();

function googleanalytics_isLinkExternal(link) {
  var r = new RegExp('^https?://(?:www.)?'
    + location.host.replace(/^www./, ''));
  return !r.test(link);
}

function googleanalytics_outgoing_init() {
//  if (arguments.callee.done) return;
//  arguments.callee.done = true;
  googleanalytics_addListener(document, 'click',
    function(e) {
      var target = (window.event) ? e.srcElement : e.target;
      while (target) {
        if (target.href) break;
        target = target.parentNode;
      }
      if (!target || !googleanalytics_isLinkExternal(target.href))
        return true;
      var link = target.href;
      link = GOOGLE_ANALYTICS_TRACKING_OUTBOUND_LINKS_PREFIX
        + link.replace(/:\/\//, '/')
        .replace('/^mailto:/', 'mailto/');
      // alert(link); return false; //тестирование
      pageTracker._trackPageview(link);
    }
  );
  //отслеживание дополнительных элементов
  //googleanalytics_addListener(document.getElementById('element-id'),
  //  'click', function() { pageTracker._trackPageview('/element-id/'); });
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