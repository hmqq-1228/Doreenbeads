<?php 
/**
 * �����ļ�
 * �˿�����ҳ�泣������
 * testimonial.php
 * jessa 2010-06-17
 */

  define('NAVBAR_TITLE', 'Avis');
  define('PAGE_TITLE', 'Avis');
  define('TEXT_WRITE_TESTIMONIAL', 'Partager vos avis?');
  if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != ''){
  	define('TEXT_TESTIMONIAL_DESCRIPTION', 'Nous sommes fiers de partager avec tous les amis les avis de nos clients. Nous apprécions les avis de nos clients, ils sont la meilleure récompense en retour de nos efforts et de service tout au long de l’activité. Si vous avez un avis que vous souhaitez partager, vous pouvez l’ajouter utiliser le formulaire ci-dessous.');
  } else {
  	define('TEXT_TESTIMONIAL_DESCRIPTION', 'Nous sommes fiers de partager avec tous les amis les avis de nos clients. Nous apprécions les avis de nos clients, ils sont la meilleure récompense de nos efforts et de service tout au long de l’activité. Si vous avez un avis à partager, vous pouvez <a href="' . zen_href_link(FILENAME_LOGIN) . '">S’enregister</a> or <a href="' . zen_href_link(FILENAME_LOGIN) . '">ou Se Connecter</a> votre compte <b>à écrire vos avis.</b>');
  }
  define('TEXT_NO_PUBLISH', '( Ne pas être publié )');
  define('TEXT_TESTIMONIAL_REQUIRED', '<span style="color:red">*</span> ');
  define('TEXT_CUSTOMER_NAME', 'Nom: ');
  define('TEXT_CUSTOMER_EMAIL', 'Email: ');
  define('TEXT_TESTIMONIAL_COMMENT', 'Avis: ');
  define('TEXT_ERROR_CUSTOMER_NAME', 'Veuillez entrer votre nom!');
  define('TEXT_ERROR_CUSTOMER_EMAIL', 'Veuillez entrer une adresse email valide (il ne sera pas publié)!');
  define('TEXT_ERROR_COMMENT_REQUIRED', 'Veuillez vos avis!');
  define('TEXT_SUCCESS_WRITE_TESTIMONIAL', 'Vos avis a été ajouté avec succès. Merci beaucoup pour votre soutien et votre attention à notre site Web.');
  define('TEXT_TESTIMONIAL_REQUIRED_INFO', '<span style="color:red">* Demandé</span>');
  define('EMAIL_TESTIMONIAL_PENDING_SUBJECT','Vous avez reçu un avis!');
  define('EMAIL_TESTIMONIAL_CONTENT_DETAILS','Détails d’avis: %s');
  define('EMAIL_TESTIMONIAL_CUSTOMER_NAME','Nom du client: %s');
  define('EMAIL_TESTIMONIAL_CUSTOMER_EMAIL',' Email du client: %s');
  define('EMAIL_TESTIMONIAL_COMMENT','Avis: %s');

  define ( 'TEXT_WHO_WE_ARE', 'Qui Sommes-Nous' );
define ( 'TEXT_CUSTOMERS_TESTIMONIALS', 'Témoignages des clients' );
define ( 'TEXT_TERMS_AND_CONDITIONS', 'Modalidés et Conditions' );
define ( 'TEXT_CONTACT_US', 'Contacter nous' );
define ( 'TEXT_INFO_REPLY', 'Réponse:' );
define ( 'TEXT_OUR_TEAM', 'Notre Equipe' );
define ( 'TEXT_QUALITY_CONTROL', 'Contrôle-Qualité' );
define ( 'TEXT_SHIPPING_INFO', 'Infos de Livraison' );
define ( 'TEXT_ABOUT_US', 'A propos de nous' );
?>