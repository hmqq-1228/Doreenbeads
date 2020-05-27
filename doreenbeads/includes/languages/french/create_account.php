<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account.php 5745 2007-02-01 00:52:06Z ajeh $
 */

define('NAVBAR_TITLE', 'Créer un compte');

define('HEADING_TITLE', 'Infos de mon compte');

define('TEXT_ORIGIN_LOGIN', '<strong class="note">NOTE:</strong> Si vous avez déjà créé un compte, vuillez vous connecter sur la page de <a href="%s">Se Conncter</a>.');

// greeting salutation
define('EMAIL_SUBJECT', 'Bienvenue à ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Bonjour M. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Bonjour Mlle. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Bonjour %s' . "\n\n");

define('TEXT_REMEMBER_ME', 'Rester en connecter');
define('EMAIL_WELCOME', 'Bienvenue de visiter ' . STORE_NAME . ' (Perles & Apprêts de bijoux vente en gros et livarion grauite au monde entier). Merci de vous enregistrer sur notre site, <b>ce sont les infos de votre compte:</b>');
define('EMAIL_CUSTOMER_EMAILADDRESS','<strong>Adresse d’e-mail:</strong>');
define('EMAIL_CUSTOMER_PASSWORD','<strong>Mot de passe:</strong>');
define('EMAIL_CUSTOMER_REG_DESCRIPTION','Maintenant, vous pouviez vous connecter et commencer vos achats sur: <br /><a href="' . zen_href_link(FILENAME_DEFAULT) . '">www.doreenbeads.com</a>');
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Félicitations! Pour vous offrir un meilleur experience d’achats, nous vous offrirons une réduction quand vous passerez votre prochaine commande. Ce sont les détails concernant le coupon ci-dessous!' . "\n\n");
define('EMAIL_COUPON_REDEEM', 'Pour profiter du coupon,veuillez entrer ' . TEXT_GV_REDEEM . ' le code de coupon pendant le processus de payer la commande :  <strong>%s</strong>' . "\n\n");
define('TEXT_COUPON_HELP_DATE', '<p>Le coupon n’est valide que du %s au %s</p>');

define('EMAIL_GV_INCENTIVE_HEADER', 'Jusqu’à maintenant, nous vous avons envoyé  ' . TEXT_GV_NAME . ' %s!' . "\n");
define('EMAIL_GV_REDEEM', 'Le code de coupon ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' est: %s ' . "\n\n" . 'Vous pouviez entrer le code ' . TEXT_GV_REDEEM . ' pendant le processus de payer votre commande. ');
define('EMAIL_GV_LINK', ' OU, vous pouviez l’ajouter dans votre compte en cliquant le lien: ' . "\n");

define('EMAIL_GV_LINK_OTHER','Une fois que vous avait ajouté ' . TEXT_GV_NAME . ' dans votre compte, vous pouviez  profiter du. ' . TEXT_GV_NAME . ' vous-même, ou le donner à un ami!' . "\n\n");

define('EMAIL_TEXT', 'Maintenant, nous vous offrons spécialement un coupon de $6.01 comme le cadeau de votre première commande.  <span style="color:red">Vous pouviez en profiter si le montant d’achat atteindait $30!</span>.<br /><div style="border:1px dashed #FF99CC; padding:6px;"><b>Enjoy 6.01US$ Cash Coupon</b><br />Coupon code: <span style="color:red;">DoreenBeads</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Coupon: <span style="color:red;">6.01US$</span><br /><b>**Tips:</b>Please input DoreenBeads.com in redemption box on our website during step 2 checking out procedure, then 6.01US$ coupon will be subtracted automatically.<br /><span style="color:red;">Please be hurry to use this code, because it will be expired 2 weeks later.</span></div>');
define('EMAIL_CONTACT', 'For help with any of our online service, please contact us by:<br />1. Click livehelp button on our website main page<br />2. or Email us at <a href="mailto:service_fr@doreenbeads.com">service_fr@doreenbeads.com</a><br /><br />');
define('EMAIL_KINDLY_NOTE', '<span style="color:red;"><b>** Kindly Note: </b></span>please keep this email for your records. If you forgot your password in future, you can check and refer to this email then.');
define('EMAIL_GV_CLOSURE','Sincerely' . "\n" . 'Doreenbeads Team' . "\n\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'Vous recevez ce message car vous vous avez inscrit sur notre site. Si vous avez des questions ¨¤ nous demander, nous enoyez une lettre ¨¤ notre adresse d’e-mail %s ');
?>
