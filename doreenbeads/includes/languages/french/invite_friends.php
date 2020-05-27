<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tell_a_friend.php 3159 2006-03-11 01:35:04Z drbyte $
 */

define('NAVBAR_TITLE', 'Invitez des amis');

define('HEADING_TITLE', 'Invitez des amis ’%s’');
define('FORM_FIELD_CUSTOMER_NAME', 'Your Name:');
define('FORM_TITLE_CUSTOMER_DETAILS', 'Your Details');
define('FORM_TITLE_FRIEND_DETAILS', 'Your Friend’s Details');
define('FORM_TITLE_FRIEND_MESSAGE', 'Your Message:');
define('FORM_FIELD_CUSTOMER_EMAIL', 'Your Friend’s Email:');
define('FORM_FIELD_FRIEND_EMAIL', 'Your Friend’s Email:');

define('EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------');

define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Your email about <strong>%s</strong> has been successfully sent to <strong>%s</strong>.');

define('EMAIL_TEXT_HEADER','Important Notice!');

define('EMAIL_TEXT_SUBJECT', 'Your friend %s has recommended this great product from %s');
define('EMAIL_TEXT_GREET', 'Hi %s!' . "\n\n");
define('EMAIL_TEXT_INTRO', 'Your friend, %s, thought that you would be interested in %s from %s.');

define('EMAIL_TELL_A_FRIEND_MESSAGE','%s sent a note saying:');

define('EMAIL_TEXT_LINK', 'To view the product, click on the link below or copy and paste the link into your web browser:' . "\n\n" . '%s');
define('EMAIL_TEXT_SIGNATURE', 'Regards,' . "\n\n" . '%s');

define('ERROR_TO_NAME', 'Error: Your name must not be empty.');
define('ERROR_TO_ADDRESS', 'Error: Your friend’s email address does not appear to be valid. Please try again.');
define('ERROR_FROM_NAME', 'Error: Your name must not be empty.');
define('ERROR_FROM_ADDRESS', 'Error: Your email address does not appear to be valid. Please try again.');

//	v2.80 2015-04-22
define('INVITE_FRIENDS_TITLE', 'Pour chaque ami que vous invitez à DoreenBeads, nous allons vous donner un coupon gratuit <span>jusqu’à USD 15.</span>');
define('INVITE_FRIENDS_BYEMAIL', 'Invitez vos amis par courriel:');
define('INVITE_FRIENDS_EMAIL_ENTER', 'Entrez les courriels de vos amis ici. Une virgule est nécessaire pour séparer les courriels.');
define('INVITE_FRIENDS_BYOTHER', 'Ou, Invitez vos amis par d’autres modes:');
define('INVITE_FRIENDS_COPYLINK', 'Copier le lien');
define('INVITE_FRIENDS_SEND', 'Envoyer');
define('INVITE_FRIENDS_SHAREFB', 'Partager sur Facebook');
define('INVITE_FRIENDS_SHARETW', 'Partager sur Twitter');
define('INVITE_FRIENDS_SHAREVK', 'Поделиться В Контакте');
define('INVITE_FRIENDS_SHAREOD', 'Поделиться в однокласснике');
define('INVITE_FRIENDS_DESCRIPTION', '* Après votre ami(e) passe sa première commande de plus de US$ 10 sur DoreenBeads, vous obtiendrez un coupon en numéraire gratuit jusqu’à US$ 15.');
define('INVITE_FRIENDS_DESCRIPTION1','<li>Gagnez US$ 5 lorsque votre ami(e) dépense US$ 10- US$ 19.99</li><li>Gagnez US$ 10 lorsque votre ami(e) dépense US$ 20- US$ 29.99</li><li>Gagnez US$ 15 lorsque votre ami(e) dépense US$ 30 ou plus</li>');
define('INVITE_FRIENDS_MAIL_TITLE', 'Recommande Fortement DoreenBeads');
define('INVITE_FRIENDS_MAIL_CONT1', 'Salut!'."<br />\n".'J’ai fait des achats sur DoreenBeads pour toutes sortes de fournitures de bijoux et de  l’artisanat. Ils ont d’énormes sélections, et tous les articles sont de la livraison gratuite. Recommande le Fortement ! Voyez via lien suivant:'."<br />\n");
define('INVITE_FRIENDS_MAIL_CONT2', 'Cordialement,'."<br />\n");
define('INVITE_FRIENDS_MAIL_CONT3', 'Equipe de Doreenbeads');
define('INVITE_FRIENDS_EMAIL_EMPTY', 'Courriel Invalide.');
define('INVITE_FRIENDS_EMAIL_WRONG', 'Courriel Invalide.');
define('INVITE_FRIENDS_EMAIL_SUCC', 'Courriel est envoyé avec succès.');
?>