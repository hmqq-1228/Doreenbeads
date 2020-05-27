<?php
chdir("../");
@ set_time_limit(0);
@ ini_set("memory_limit', '2048M");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

$email_content_array = array(
		1 => array(
				'TEXT_EMAIL_TITLE' => 'Kind Inquiry about your shipped order from Doreenbeads  ',
				'TEXT_DEAR_WORDS' => 'Dear %s',
				'TEXT_FIND_YOU_WELL' => 'Hope this letter finds you well, wish you a lovely day there!',
				'TEXT_ORDER_INFO' => 'My friend, thanks for your order #%s with us, we have shipped out your parcel for many days, but sometimes the tracking information cannot be updated timely when parcels leave China, so we are wondering have you received your parcel now? Please kindly let us know.',
				'TEXT_CONTACK_US' => 'If there are any problems, please do not hesitate to contact us, we will do our best to assist.',
				'TEXT_EMAIL_SUGGESTION' => 'BTW, we welcome your kind suggestions or compliments, if you would like to take time to email us.',
				'TEXT_FORWARD_REPLY' => 'Looking forward to your kind reply~~',
				'TEXT_BEST_WISHES' => 'Best wishes',
				'TEXT_CONTENT_END' => 'Doreenbeads Team.  ',
				'EMAIL_NOTIFICATIONS_FROM'=>'notification@doreenbeads.com',
				'STORE_NAME' => 'DoreenBeads.com'
		),
		2 => array(
				'TEXT_EMAIL_TITLE' => 'Herzliche Anfrage nach Ihrer geschickten Bestellung von Doreenbeads  ',
				'TEXT_DEAR_WORDS' => 'Hallo %s',
				'TEXT_FIND_YOU_WELL' => "Wie geht's Ihnen? Ich hoffe, dass alles bei Ihnen gut gelaufen sind.",
				'TEXT_ORDER_INFO' => 'Lieben Dank für Ihre Bestellung #%s, wir haben Ihre Bestellung vor einigen Tagen geschickt.Aber manchmal diese Tracking-Information wird nicht rechtzeitig aktualisiert,sobald Paket China verlassen.',
				'TEXT_CONTACK_US' => 'Nämlich möchte ich mich bei Ihnen erkundigen, ob Sie schon dieses Paket erhalten.<br/>
					Dank schön für Ihre Bestätigung.<br/>
					Falls nicht oder irgendes Problem, bitte senden Sie Email an uns.<br/>
					Wir wollen gerne helfen.<br/>
					Übrigens Ihre Meinung sind sssssssehr wichtig für uns.',
				'TEXT_EMAIL_SUGGESTION' => 'Falls Sie irgendwelchen Vorschlag oder Reklamation über unsere Erzeugnisse oder Webseite haben, bitte nehmen Sie Kontakt mit uns per Email auf.',
				'TEXT_FORWARD_REPLY' => 'Wir werden unser Bestes tun, zu verbessern.',
				'TEXT_BEST_WISHES' => 'Ich freue mich auf Ihre Antwort.<br/>
					Mit freundlichen Grüßen.',
				'TEXT_CONTENT_END' => 'Doreenbeads Team. ',
				'EMAIL_NOTIFICATIONS_FROM'=>'notification_de@doreenbeads.com',
				'STORE_NAME' => 'DoreenBeads.com'
			),
		3 => array(
				'TEXT_EMAIL_TITLE' => 'Получили ваш последный заказ от Doreenbeads  ',
				'TEXT_DEAR_WORDS' => 'Добрый день, %s',
				'TEXT_FIND_YOU_WELL' => 'Как ваше дело? Надеюсь, что у вас все в порядке ',
				'TEXT_ORDER_INFO' => 'Мой друг, спасибо за ваш заказ #%s с нами, мы отправили вашу посылку к вам многих дней. <br/>
Ну, когда посылки из Китая, иногда информации отслеживания не могут быть обновлены своевременно. <br/>
Поэтому хотим узнать, что вы получили вашу посылку сейчас? Прошу вас сказать нам , хорошо?',
				'TEXT_CONTACK_US' => 'Если у вас другие вопросы , то свяжитесь с нами пожалуйста, чтобы помогать вам O(∩_∩)O ~',
				'TEXT_EMAIL_SUGGESTION' => 'Кстати, мы приветствуем ваши добрые пожелания или дополнения, если вы хотите, что выслать письмо к нам .<br/>
					Если у вас другие вопросы , то свяжитесь с нам ',
				'TEXT_FORWARD_REPLY' => 'Приятного дня ',
				'TEXT_BEST_WISHES' => 'С уважением ',
				'TEXT_CONTENT_END' => 'Doreenbeads Team. ',
				'EMAIL_NOTIFICATIONS_FROM'=>'notification_ru@doreenbeads.com',
				'STORE_NAME' => 'DoreenBeads.com'
			),
		4 => array(
				'TEXT_EMAIL_TITLE' => 'Enquête de votre commande expédié chez Doreenbeads ',
				'TEXT_DEAR_WORDS' => 'Bonjour Monnsieur/ Madame, %s',
				'TEXT_FIND_YOU_WELL' => "J'espère que ce courrier ne vous déranger pas!",
				'TEXT_ORDER_INFO' => "Tout d'abord, je vous remercie pour votre commande #%s, nous avons envoyé votre colis depuis plusieurs jours, mais quelques fois, l'information de suivi ne renouvèle pas après que le colis est départ de Chine, donc nous voulons savoir si vous avez reçu le colis maintenant? Pourriez-vous nous informer?",
				'TEXT_CONTACK_US' => "s'il y a aucun problème, n'hésitez pas à nous contacter, nous allons faire tous nos efforts pour vous aider!",
				'TEXT_EMAIL_SUGGESTION' => 'A propos, nous nous réjouissons de vos suggestions ou compliments aimables, si vous voulez prendre le temps de nous envoyer un courriel.',
				'TEXT_FORWARD_REPLY' => 'Bonne journée journée!',
				'TEXT_BEST_WISHES' => 'Meilleurs vœux',
				'TEXT_CONTENT_END' => 'Équipe DoreenBeads.',
				'EMAIL_NOTIFICATIONS_FROM'=>'notification_fr@doreenbeads.com',
				'STORE_NAME' => 'DoreenBeads.com'
		)
);

if(isset ($_GET['action']) && $_GET['action'] == 'check_orders_is_delivered') {
	$shipping_arr = array();
	$shipping_method_query = $db->Execute('SELECT `code` , ask_delivered_days FROM ' . TABLE_SHIPPING . ' where `status` = 1');
	
	while(!$shipping_method_query->EOF){
		$shipping_code = $shipping_method_query->fields['code'];
		$delivered_days = $shipping_method_query->fields['ask_delivered_days'];
		$shipping_arr[$shipping_code] = $delivered_days;
	
		$shipping_method_query->MoveNext();
	}
	
	$orders_sql = 'SELECT orders_id , customers_name , language_id , customers_email_address , shipping_module_code , last_modified from ' . TABLE_ORDERS . ' WHERE orders_status = 3 and orders_id not in (SELECT DISTINCT orders_id from ' . TABLE_ORDERS_PACKAGE_CONFIRMED_DELIVERED . ' ) and date_purchased > "2016-10-01 00:00:00"';
	$shipping_orders_query = $db->Execute($orders_sql);
	
	if($shipping_orders_query->RecordCount() > 0){
		while (!$shipping_orders_query->EOF){
			$orders_id = $shipping_orders_query->fields['orders_id'];
			$customers_name = $shipping_orders_query->fields['customers_name'];
			$customers_email = $shipping_orders_query->fields['customers_email_address'];
			$language_id = $shipping_orders_query->fields['language_id'];
			$shipping_code = $shipping_orders_query->fields['shipping_module_code'];
			
			$shipping_time_query = $db->Execute('select date_added from ' . TABLE_ORDERS_STATUS_HISTORY . ' where orders_id = ' . $orders_id . ' and orders_status_id = 3 order by date_added desc limit 1');
			$shipping_date = strtotime($shipping_time_query->fields['date_added']);
			
			$wait_delivered_time = time() - $shipping_date;
			$delivered_time = $shipping_arr[$shipping_code] * 24 * 60 * 60;
			
			if($wait_delivered_time >= $delivered_time ){
				$insert_order_sql = 'INSERT into ' . TABLE_ORDERS_PACKAGE_CONFIRMED_DELIVERED . ' (orders_id , package_status , date_confirmed , date_created) VALUES ( ' . $orders_id . ' , 10 , NOW() , NOW())';
				$db->Execute($insert_order_sql);	
				
				$message = sprintf($email_content_array[$language_id]['TEXT_DEAR_WORDS'] , $customers_name) . '\n' .
				$email_content_array[$language_id]['TEXT_FIND_YOU_WELL'] . '\n' .
				sprintf($email_content_array[$language_id]['TEXT_ORDER_INFO'] , $orders_id) . '\n' .
				$email_content_array[$language_id]['TEXT_CONTACK_US'] . '\n' .
				$email_content_array[$language_id]['TEXT_EMAIL_SUGGESTION'] . '\n' .
				$email_content_array[$language_id]['TEXT_FORWARD_REPLY'] . '\n' .
				$email_content_array[$language_id]['TEXT_BEST_WISHES'] . '\n' .
				$email_content_array[$language_id]['TEXT_CONTENT_END'] . '\n';
				
				$msg['TEXT_DEAR_WORDS'] = sprintf($email_content_array[$language_id]['TEXT_DEAR_WORDS'] , $customers_name);
				$msg['TEXT_FIND_YOU_WELL'] = $email_content_array[$language_id]['TEXT_FIND_YOU_WELL'];
				$msg['EMAIL_MESSAGE_HTML'] = sprintf($email_content_array[$language_id]['TEXT_ORDER_INFO'] , $orders_id);
				$msg['TEXT_CONTACK_US'] = $email_content_array[$language_id]['TEXT_CONTACK_US'];
				$msg['TEXT_EMAIL_SUGGESTION'] = $email_content_array[$language_id]['TEXT_EMAIL_SUGGESTION'];
				$msg['TEXT_FORWARD_REPLY'] = $email_content_array[$language_id]['TEXT_FORWARD_REPLY'];
				$msg['TEXT_BEST_WISHES'] = $email_content_array[$language_id]['TEXT_BEST_WISHES'];
				$msg['TEXT_CONTENT_END'] = $email_content_array[$language_id]['TEXT_CONTENT_END'];

				zen_mail($customers_name , $customers_email, $email_content_array[$language_id]['TEXT_EMAIL_TITLE'] , $message, $email_content_array[$language_id]['STORE_NAME'], $email_content_array[$language_id]['EMAIL_NOTIFICATIONS_FROM'] , $msg  , 'order_delivered');
			
			}
			
			$shipping_orders_query->MoveNext();
		}
		
	}
	
}


echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>