####################8seasons pending订单催款####################
DROP VIEW
IF EXISTS `view_orders_pending`;

CREATE ALGORITHM = UNDEFINED 
DEFINER = `root`@`localhost` 
SQL SECURITY DEFINER 
VIEW `view_orders_pending` AS (
    select o.orders_id, if(from_mobile=1, 20, 10) website_code, l.`code` languages_code from zen_orders o left join zen_languages l on l.languages_id=o.language_id where o.orders_status=1 and o.date_purchased<from_unixtime(unix_timestamp(now())-60*60, '%Y-%m-%d %H:%m:%s') and o.customers_email_address not like '%@panduo.com.cn%' and o.customers_email_address not like '%@163.com%' and o.customers_email_address not like '%@qq.com%'
);

DROP VIEW
IF EXISTS `view_orders_pending_detail_child`;

CREATE ALGORITHM = UNDEFINED 
DEFINER = `root`@`localhost` 
SQL SECURITY DEFINER 
VIEW `view_orders_pending_detail_child` AS (
    select o.orders_id, if(o.from_mobile=1, 20, 10) website_code, o.customers_id, o.customers_name, o.customers_telephone, o.customers_email_address, o.date_purchased, l.`code` languages_code, round(o.order_total*o.currency_value, 2) order_total, o.order_total order_total_usd, if(s.erp_id is not null, s.erp_id, 47) erp_id, o.currency, o.payment_module_code, o.seller_memo, (select comments from zen_orders_status_history osh where osh.orders_id=o.orders_id and orders_status_id=1 order by osh.orders_status_history_id asc limit 1) comments, (select p.payer_email from zen_paypal p where p.zen_order_id=o.orders_id order by p.paypal_ipn_id desc limit 1) payer_email, (select p.payment_type from zen_paypal p where p.zen_order_id=o.orders_id order by p.paypal_ipn_id desc limit 1) payment_type from zen_orders o left join zen_languages l on l.languages_id=o.language_id left join zen_shipping s on s.`code`=o.shipping_module_code where o.orders_status=1 and o.date_purchased<from_unixtime(unix_timestamp(now())-60*60, '%Y-%m-%d %H:%m:%s') and o.customers_email_address not like '%@panduo.com.cn%' and o.customers_email_address not like '%@163.com%' and o.customers_email_address not like '%@qq.com%'
);

DROP VIEW
IF EXISTS `view_orders_pending_detail`;

CREATE ALGORITHM = UNDEFINED 
DEFINER = `root`@`localhost` 
SQL SECURITY DEFINER 
VIEW `view_orders_pending_detail` AS (
    select orders_id, website_code, customers_id, customers_name, customers_telephone, customers_email_address, date_purchased, languages_code, order_total, order_total_usd, erp_id, currency, if(payer_email is not null, payer_email, customers_email_address) payer_email, if(instr(lower(payment_type), 'echeck') > 0, 'paypal_echeck', payment_module_code) payment_module_code, if(CHAR_LENGTH(seller_memo) > 240, concat(left(seller_memo, 240), "【字符有截断】"), seller_memo) seller_memo, if(CHAR_LENGTH(comments) > 240, concat(left(comments, 240), "【字符有截断】"), comments) comments from view_orders_pending_detail_child
);


####################doreenbeads pending订单催款####################
DROP VIEW
IF EXISTS `view_orders_pending`;

CREATE ALGORITHM = UNDEFINED 
DEFINER = `root`@`localhost` 
SQL SECURITY DEFINER 
VIEW `view_orders_pending` AS (
    select o.orders_id, if(from_mobile=1, 40, 30) website_code, l.`code` languages_code from t_orders o left join t_languages l on l.languages_id=o.language_id where o.orders_status=1 and o.date_purchased<from_unixtime(unix_timestamp(now())-60*60, '%Y-%m-%d %H:%m:%s') and o.customers_email_address not like '%@panduo.com.cn%' and o.customers_email_address not like '%@163.com%' and o.customers_email_address not like '%@qq.com%'
);

DROP VIEW
IF EXISTS `view_orders_pending_detail_child`;

CREATE ALGORITHM = UNDEFINED 
DEFINER = `root`@`localhost` 
SQL SECURITY DEFINER 
VIEW `view_orders_pending_detail_child` AS (
    select o.orders_id, if(o.from_mobile=1, 40, 30) website_code, o.customers_id, o.customers_name, o.customers_telephone, o.customers_email_address, o.date_purchased, l.`code` languages_code, round(o.order_total*o.currency_value, 2) order_total, o.order_total order_total_usd, if(s.erp_id is not null, s.erp_id, 47) erp_id, o.currency, o.payment_module_code, o.seller_memo, (select comments from t_orders_status_history osh where osh.orders_id=o.orders_id and orders_status_id=1 order by osh.orders_status_history_id asc limit 1) comments, (select p.payer_email from t_paypal p where p.order_id=o.orders_id order by p.paypal_ipn_id desc limit 1) payer_email, (select p.payment_type from t_paypal p where p.order_id=o.orders_id order by p.paypal_ipn_id desc limit 1) payment_type from t_orders o left join t_languages l on l.languages_id=o.language_id left join t_shipping s on s.`code`=o.shipping_module_code where o.orders_status=1 and o.date_purchased<from_unixtime(unix_timestamp(now())-60*60, '%Y-%m-%d %H:%m:%s') and o.customers_email_address not like '%@panduo.com.cn%' and o.customers_email_address not like '%@163.com%' and o.customers_email_address not like '%@qq.com%'
);

DROP VIEW
IF EXISTS `view_orders_pending_detail`;

CREATE ALGORITHM = UNDEFINED 
DEFINER = `root`@`localhost` 
SQL SECURITY DEFINER 
VIEW `view_orders_pending_detail` AS (
    select orders_id, website_code, customers_id, customers_name, customers_telephone, customers_email_address, date_purchased, languages_code, order_total, order_total_usd, erp_id, currency, if(payer_email is not null, payer_email, customers_email_address) payer_email, if(instr(lower(payment_type), 'echeck') > 0, 'paypal_echeck', payment_module_code) payment_module_code, if(CHAR_LENGTH(seller_memo) > 240, concat(left(seller_memo, 240), "【字符有截断】"), seller_memo) seller_memo, if(CHAR_LENGTH(comments) > 240, concat(left(comments, 240), "【字符有截断】"), comments) comments  from view_orders_pending_detail_child
);