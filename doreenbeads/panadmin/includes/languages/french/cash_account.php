<?php
/**
 * cash_account.php
 * 常量定义文件
 */

  define('HEADING_TITLE', 'Credit Account Manage');
  define('TABLE_HEADING_CUSTOMER_ID', 'Customer ID');
  define('TABLE_HEADING_CUSTOMER_NAME', 'Customer Name');
  define('TABLE_HEADING_CUSTOMER_EMAIL', 'Customer Email');
  define('TABLE_HEADING_CREATOR', 'Creator');
  define('TABLE_HEADING_CREATE_DATE', 'Create Date');
  define('TABLE_HEADING_MODIFY_DATE', 'Modify Date');
  define('TABLE_HEADING_STATUS', 'Status');
  define('TABLE_HEADING_ACTION', 'Action');
  define('TABLE_HEADING_CASH_AMOUNT', 'Amount');
  
  define('TEXT_INFO_HEADING_NEW_CASH_ACCOUNT', 'New Credit Account');
  define('TEXT_INFO_CUSTOMER_EMAIL', 'Customer Email: ');
  define('TEXT_INFO_CASH_AMOUNT', 'Cash Amount: ');
  define('TEXT_INFO_CURRENCY_CODE', 'Currency Code: ');
  define('TEXT_INFO_CREATOR', 'Creator: ');
  define('TEXT_INFO_WHO_MODIFY', 'Who Modify: ');
  define('TEXT_INFO_STATUS', 'Status: ');
  define('TEXT_INFO_MEMO', 'Memo: ');
  define('TEXT_INFO_INSERT_INTRO', 'Please enter the new cash account with its related data');
  
  define('TEXT_INFO_CUSTOMER_NAME', 'Customer Name: ');
  define('TEXT_INFO_HEADING_DELETE_CASH_ACCOUNT', 'Delete Credit Account');
  define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this credit account?');
  define('TEXT_INFO_HEADING_EDIT_CASH_ACCOUNT', 'Edit Credit Account');
  define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
  define('TEXT_INFO_CREATE_DATE', 'Create Date: ');
  define('TEXT_INFO_MODIFY_DATE', 'Modify Date: ');
  define('TEXT_INFO_NOTIFY_CUSTOMER', 'Notify Customer');
  
  define('TEXT_DISPLAY_NUMBER_OF_CASH_ACCOUNT', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> credit account)');
  define('TEXT_STATUS_DESCRIPTION', '<b>Status:</b> ' . zen_image(DIR_WS_IMAGES . 'icon_status_green.gif') . '&nbsp;Active Status<b>(A)</b>&nbsp;&nbsp;&nbsp;&nbsp;' . zen_image(DIR_WS_IMAGES . 'icon_status_yellow.gif') . '&nbsp;Completion Status<b>(C)</b>&nbsp;&nbsp;&nbsp;&nbsp;' . zen_image(DIR_WS_IMAGES . 'icon_status_red.gif') . '&nbsp;Deleted Status<b>(X)</b>');
  
  //define error text
  define('TEXT_CUSTOMER_NOT_EXIST', 'Customer does not exist, please check!');
  define('TEXT_CUSTOMER_EMAIL_REQUIRED', 'Customer email is required!');
  define('TEXT_CASH_AMOUNT_ERROR', 'Cash amount format is error, please check!');
  define('TEXT_CREATOR_IS_REQUIRED', 'Creator is required');
  define('TEXT_WHO_MODIFY_REQUIRED', 'Who modify is required');
  define('TEXT_CASH_ACCOUNT_ADD_SUCCESSED', 'Credit account added successed');
  define('TEXT_CASH_ACCOUNT_DEL_SUCCESSED', 'Cash account delete successed');
  define('TEXT_CASH_AMOUNT_EXCEED', 'Cash amount should be min %.2f US$ and max %.2f US$, Please check!');
  
   //email content
  define('CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION', 'Bonjour, %s <br /><br /> 
                              Veuillez noter que nous avons ajouté %s à votre compte. <br /><br /> 
                              ※ Informations détaillées sur le <font color="red">crédit</font>:<br /><br /> 
                              <b>Comment l\'utiliser?</b><br /><br /> 
                              %s sera déduit de votre prochaine commande automatiquement. Il sera affiché après avoir cliqué sur le bouton "Confirmer la commande", qui est juste comme l\'image ci-dessous montre.<br /><br /> 
                              <img src="'.DIR_WS_IMAGES.'/cash_credit.jpeg" /><br /><br /> 
                              Informations complémentaires sur ce crédit:<br /><br /> 
                              <b>%s</b> <br /><br /> 
                              Pour connaître les détails de votre compte de crédit, connectez-vous à <a href="'.HTTP_SERVER.'/index.php?main_page=myaccount">votre compte de doreenbeads</a>accédez à "Mon compte" sur la page d\'accueil de notre site et cliquez sur "Compte de crédit - Solde". Ensuite, vous verrez toutes les informations détaillées.<br /><br /> 
                              Merci pour vos achats chez nous!<br /><br /> 
                              Très Cordialement,
                              Equipe doreenbeads <br /><br /> 
                              <a href="'.HTTP_SERVER.'">www.doreenbeads.com</a>
                              ');
  // 删除Banlance时 发送邮件模板 
  define('CASH_ACCOUNT_NOTIFY_DEL_DESCRIPTION','Cher(e) %s <br /><br />
                               Veuillez noter que le crédit ci-dessous a été supprimé de votre compte，<br /><br />
                               discuté avec Doreenbeads service à la clientèle. <br /><br />
                               Montant supprimé: %s<br /><br />
                               Note originale: %s<br /><br />
                               Bien cordialement <br />
                               Équipe Doreenbeads
                              ');

  define('CASH_ACCOUNT_NOTIFY_CUSTOMER_SUBJECT', ' a été ajouté à votre compte.');
  define('CASH_ACCOUNT_NOTIFY_CUSTOMER_SUBJECT1', ' ont été ajoutés à votre compte de crédit.');
  define('CASH_ACCOUNT_NOTIFY_CONTENTS', 'dans votre compte de crédit. Ce montant sera crédité sur votre prochaine commande lorsque vous faisez des achats sur notre site. <br />' . '<br />Les infos complémentaires sur ce credit:<br />');
  define('CASH_ACCOUNT_NOTIFY_CONTENTS1', 'Deuxièmement, ici, je veux que vous sachiez que à cause de votre achat précédent, nous avons enregistré <font color="#FF0000">%s</font> dans votre compte. Ce montant sera ajouté à votre prochaine commande lorsque vous ferez l’affaire avec nous.<br />' . '<br />Les infos complémentaires sur ce credit:<br />');
  define('CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION', 'Pour les details de votre compte de crédit, connectez-vous sur notre site et vérifiez « Mon compte » et cliquez sur le bouton « Voir mon compte de crédit » <a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">www.doreenbeads.com</a><br/>Là, vous pouviez trouver les infos détaillées<br/><br/>Nous vous souhaitons nos meilleurs vœux<br/>Au nom de l’Equipe dorabeads<br/><a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">www.doreenbeads.com</a>');
  define('TEXT_INFO_ADJUSTED_AMOUNT', 'Ajuster le Montant');
  ?>
