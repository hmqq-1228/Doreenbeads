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
  define('CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION', 'Уважаемые %s <br /><br /> 
                              Пожалуйста, примите во внимание, что мы уже добавили %s в ваш счет. <br /><br /> 
                              ※ Подробная информация о возвратить деньги:<br /><br /> 
                              <b>Как это использовать?</b><br /><br /> 
                              %s Будет автоматически вычитаться из вашего следующего заказа. Это будет показано после нажатия кнопки «Оформить заказ», как показано на рисунке ниже.<br /><br /> 
                              <img src="'.DIR_WS_IMAGES.'/cash_credit.jpeg" /><br /><br /> 
                              Дополнительная информация о возвращении деньги:<br /><br /> 
                              <b>%s</b> <br /><br /> 
                              Чтобы просмотреть реквизиты своей учетной записи, войдите в <a href="'.HTTP_SERVER.'/index.php?main_page=myaccount">ваш счет doreenbeads</a>, Перейдите в раздел «Мой Счёт» на главной странице нашего сайта и нажмите «Личный счёт- Баланс». Затем вы увидите всю подробную информацию.<br /><br /> 
                              Спасибо за покупку!<br /><br /> 
                              Всего наилучшего,
                              От имени команды doreenbeads <br /><br /> 
                              <a href="'.HTTP_SERVER.'">www.doreenbeads.com</a>
                              ');
  // 删除Banlance时 发送邮件模板 
  define('CASH_ACCOUNT_NOTIFY_DEL_DESCRIPTION','Уважаемые %s <br /><br />
                               Обсудите с обслуживанием клиентов Doreenbeads. Пожалуйста, примите к ，<br /><br />
                               сведению, что указанный ниже кредит был удален из вашего счета. <br /><br />
                               Удаленная сумма: %s<br /><br />
                               Оригинальная записка: %s<br /><br />
                               С наилучшими пожеланиями<br />
                               Doreenbeads Команда
                              ');

  define('CASH_ACCOUNT_NOTIFY_CUSTOMER_SUBJECT', ' были добавлены в ваш кредитный счёт.');
  define('CASH_ACCOUNT_NOTIFY_CUSTOMER_SUBJECT1', ' были добавлены в вашем кредитном счёте.');
  define('CASH_ACCOUNT_NOTIFY_CONTENTS', 'в вашем счёте. Это количество будет зачислено в вашем следующем заказе, когда вы будете делать покупки с нами снова.<br />' . '<br />Дополнительная информация об этой кредитном счёте:<br />');
  define('CASH_ACCOUNT_NOTIFY_CONTENTS1', 'Во-вторых, здесь я хочу сообщить, что из-за вашей предыдущей покупки, мы кредитовали<font color="#FF0000">%s</font>в вашем счёте. Это количество будет добавлены в ваш следующий заказ, когда вы будете делать покупки с нами снова.<br />' . '<br />Дополнительная информация об этой кредитном счёте:<br />');
  define('CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION', 'Чтобы просмотреть детали вашего кредитного счета, пожалуйста, войдите в наш веб-сайт, проверяйте раздел "Мой счёт", а затем нажмите «Личный счёт – Баланс» в"<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">www.doreenbeads.com</a>. И тогда вы найде те подробную информацию обо всех.<br/><br/>Благодарим Вас за покупками в наш веб-сайт!<br/>С наилучшими пожеланиями. <br/>Команда dorabeads<br/><a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">www.doreenbeads.com</a>
');
  define('TEXT_INFO_ADJUSTED_AMOUNT', 'Скорректированная сумма');
?>
