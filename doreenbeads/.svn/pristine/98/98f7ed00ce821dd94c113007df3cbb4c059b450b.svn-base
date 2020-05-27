DROP PROCEDURE if exists get_isvalid_checkout_products_optimize;
CREATE PROCEDURE get_isvalid_checkout_products_optimize(in customers_id_in int, in cookie_id_in varchar(32), in languages_id_in int)  
begin 
	#declare @customers_id_my int;
	#set @customers_id_my=210020; 
	#select * from t_customers limit 100;  
	#select * from t_customers_basket where customers_id=customers_id_in; 
	#重点测试：刻字服务失效了、my_products显示问题
	#shopping_cart.php products_priced_by_attribute 这个变量貌似已没有用了 select products_priced_by_attribute, count(*) from t_products group by products_priced_by_attribute;
	#club商品客户能享受到折扣吗？
	#products表中的products_is_free字段貌似没有用 select product_is_free, count(*) from t_products group by product_is_free;
	#products表中的products_discount_type字段貌似没有用 select products_discount_type, count(*) from t_products group by products_discount_type;
	#商品即是定制服务产品，又是促销、dailydeal、club产品、club产品折扣(t_club_products)等交叉情况下时的价格计算
	#下架商品在购物车的显示
	#如果数据库中产品的product_is_free设置为0，则该产品为免费产品

	#如果不是这三个货号中的一个t02847、b31508、b57700，但价格(产品表中的products_price)小于等于0的话，则删除【已去除该逻辑】
	#如果商品表中设置的products_quantity_order_min(设置为大于0的数量)大于客户下单的数量，则：1、该设置值大于1时将客户购物车的数量修改成products_quantity_order_min；2、该设置值等于0时将客户客户车该商品删除【已去除该逻辑】 select products_quantity_order_min, count(*) from t_products group by products_quantity_order_min;
	#如果商品表中product_is_always_free_shipping为1或者products_virtual为1或者商品货号以gift开头则会累加免运费的金额(不知道是否和运行有关)【已去除该逻辑】 select * from t_products where product_is_always_free_shipping=1; select * from t_products where products_virtual=1; select * from t_products where products_model like '%gift%';;

#######
	#双倍积分


	#这三个商品28675,39729,74012只能添加一个

###select products_quantity_order_units, count(*) from t_products group by products_quantity_order_units; 

##products_mixed_discount_quantity 没有用function in_cart_mixed_discount_quantity
#产品表中的products_discount_type字段没有用

	declare customers_basket_id int;
	declare customers_basket_quantity int;
	declare products_id int;
	declare products_model varchar(32);
	declare products_status int;
	declare original_price float(10, 4);
	declare promotion_discount float(10, 4);
	declare dailydeal_price float(10, 4);
	declare products_service_price float(10, 4);
	declare products_price float(10, 4);
	declare products_image varchar(64);
	declare products_quantity_order_max int;
	declare products_quantity_order_min int;
	declare products_limit_stock int(10);
	declare products_weight float(10, 2);
	declare products_volume_weight float(10, 2);
	declare product_is_free int;
	declare products_quantity_order_units int;
	declare products_name varchar(512);
	declare products_quantity int;
	declare is_checked int;
	declare products_status_my_products tinyint(2);
	declare customers_id_my_products_into varchar(256);
	declare done int default 0; 

	declare products_status_new int;
	declare customers_ids_my_products varchar(512);
	declare my_products_conflict tinyint(2);

	declare is_rcd tinyint(2);
	declare vip_integral_customers_id tinyint(2);
	declare history_amount_1 float(10, 2) default 0.00;
	declare history_amount_2 float(10, 2) default 0.00;
	declare history_amount_3 float(10, 2) default 0.00;
	declare history_amount float(10, 2);
	declare special_price float(10, 2);

	


	declare shopping_cart_cursor cursor for select cb.customers_basket_id, cb.customers_basket_quantity, 
	p.products_id, p.products_model, p.products_status, p.products_price as original_price, 0.00 as promotion_discount, 0.00 as dailydeal_price, 0.00 as products_service_price, p.products_price, p.products_image, p.products_quantity_order_max, p.products_quantity_order_min, p.products_limit_stock, p.products_weight, p.products_volume_weight, p.product_is_free, p.products_quantity_order_units, 
	ifnull(pd.products_name, '') products_name, ifnull(ps.products_quantity, 0) products_quantity, cb.is_checked,
	0 products_status_my_products
	from t_customers_basket cb 
	inner join t_products p on p.products_id = cb.products_id 
	left join t_products_description pd on p.products_id = pd.products_id 
	left join t_products_stock ps on p.products_id = ps.products_id 
	#left join (select products_id, customers_id from t_my_products) temp_mp on temp_mp.products_id=p.products_id
	###where pd.language_id = languages_id_in and if(cb.customers_id > 0, cb.customers_id = customers_id_in, if(cookie_id_in != '', cb.cookie_id = cookie_id_in, 1 = 2)) order by cb.customers_basket_id desc;
	where pd.language_id = languages_id_in and ((cb.customers_id = customers_id_in and customers_id_in > 0) or (cb.cookie_id = cookie_id_in and customers_id_in = 0)) order by cb.customers_basket_id desc;
	#where pd.language_id = languages_id_in and case when cb.customers_id > 0 and (cookie_id_in is null or cookie_id_in = '') then cb.customers_id = customers_id_in when customers_id_in = 0 and cookie_id_in is not null and cookie_id_in !='' then cb.cookie_id = cookie_id_in else 1 = 1 end order by cb.customers_basket_id desc;
	declare continue handler for not found set done=1;

	drop table if exists tmp_my_products;
	create temporary table tmp_my_products ( 
		products_id int(10) not null,
		customers_id_str varchar(1024) null
		
	);
	/*
	drop table if exists tmp_products_price;
	create temporary table tmp_products_price ( 
		products_id int(10) not null,
		original_price float(10, 2) not null,
		promotion_discount float(10, 2) not null,
		dailydeal_price float(10, 2) not null,
		products_service_price float(10, 2) not null,
		final_price float(10, 2) not null
		
	);
	*/

	#insert into tmp_products_price (products_id, original_price, promotion_discount, dailydeal_price, products_service_price, final_price) values (0, 0.00, 0.00, 0.00, 0.00, 0.00);

	insert into tmp_my_products (products_id, customers_id_str) select mp.products_id, concat(",", group_concat(mp.customers_id order by mp.customers_id separator ","), ",") from t_my_products mp group by mp.products_id;

	drop table if exists tmp_customers_basket;
	create temporary table tmp_customers_basket ( 
		customers_basket_id int(10) not null,
		customers_basket_quantity int(10) not null,
		products_id int(10) not null,
		products_model varchar(32) not null,
		products_status int(10) not null,
		original_price float(10, 2) not null,
		promotion_discount float(10, 2) not null,
		dailydeal_price float(10, 2) not null,
		products_service_price float(10, 2) not null,
		final_price float(12, 2) not null,
		products_image varchar(64) not null,
		products_quantity_order_max int(10) not null,
		products_quantity_order_min int(10) not null,
		products_limit_stock int(10) not null,
		products_weight float(12, 2) not null,
		products_volume_weight float(12, 2) not null,
		product_is_free int(10) not null,
		products_quantity_order_units int(10) not null,
		products_name varchar(512) not null,
		products_quantity int(10) not null,
		is_checked int(10) not null,
		products_status_my_products tinyint(2) not null
		
	);


	open shopping_cart_cursor;  
		shopping_cart_loop: loop  
		fetch shopping_cart_cursor into customers_basket_id, customers_basket_quantity, products_id, products_model, products_status, original_price, promotion_discount, dailydeal_price, products_service_price, products_price, products_image, products_quantity_order_max, products_quantity_order_min, products_limit_stock, products_weight, products_volume_weight, product_is_free, products_quantity_order_units, products_name, products_quantity, is_checked, products_status_my_products;  
			if done = 1 then  
				leave shopping_cart_loop;  
			end if;
			
			set customers_id_my_products_into = '';
			set my_products_conflict = 0;
			#declare products_status_new int;
			#select customers_id into customers_id_my_products from tmp_my_products mp where mp.products_id=products_id;
			###select customers_id_str into customers_id_my_products_into from tmp_my_products where products_id=products_id limit 1;
			###select customers_id_my_products_into;
			
			###select instr(customers_id_my_products_into, concat(',', customers_id_in, ',')) into my_products_conflict;
			#if length(customers_id_my_products_into) > 0 and my_products_conflict > 0 then
			#	select 1;
			#else 
			#	select 0;
			#end if;
			#select concat(",", group_concat(mp.customers_id order by mp.customers_id separator ","), ",") into customers_ids_my_products from t_my_products mp where mp.products_id=114751 group by mp.products_id;
			#if customers_ids_my_products != "" and locate(customers_id_in, customers_ids_my_products) > 0 then
			#		set products_status_new = 1;
			#	else
			#		set products_status_new = 0;
			#end if;
			#select locate('bar', 'foobarbar');
			
			#insert into tmp_products_price (products_id, original_price, promotion_discount, dailydeal_price, products_service_price, final_price) values (products_id, 0.00, 0.00, 0.00, 0.00, 0.00);

			if products_limit_stock = 1 and customers_basket_quantity > products_quantity and (products_status = 1 or (products_status = 0 and ((products_status_my_products = 1 and products_limit_stock = 0) or (products_status_my_products = 1 and products_limit_stock = 1 and products_quantity>0)))) then
				update t_customers_basket cb set cb.customers_basket_quantity = products_quantity where cb.customers_basket_id=customers_basket_id;
				#select customers_basket_id, products_quantity;
			end if;

			if products_quantity_order_min > 0 and customers_basket_quantity < products_quantity_order_min then
				update t_customers_basket cb set cb.customers_basket_quantity = products_quantity_order_min where cb.customers_basket_id=customers_basket_id;
			end if;
			
			#select get_products_special_price(products_id, products_price, customers_basket_quantity) into special_price;
			#if special_price is not null and special_price > 0 then
			#	set products_price = special_price;
			#end if;
			
			
			insert into tmp_customers_basket (customers_basket_id, customers_basket_quantity, products_id, products_model, products_status, original_price, promotion_discount, dailydeal_price, products_service_price, final_price, products_image, products_quantity_order_max, products_quantity_order_min, products_limit_stock, products_weight, products_volume_weight, product_is_free, products_quantity_order_units, products_name, products_quantity, is_checked, products_status_my_products) values (customers_basket_id, customers_basket_quantity, products_id, products_model, products_status, original_price, promotion_discount, dailydeal_price, products_service_price, products_price, products_image, products_quantity_order_max, products_quantity_order_min, products_limit_stock, products_weight, products_volume_weight, product_is_free, products_quantity_order_units, products_name, products_quantity, is_checked, products_status_my_products);
		end loop shopping_cart_loop;  
	close shopping_cart_cursor; 



	if customers_id_in is not null and customers_id_in > 0 and customers_id_in != '' then

		#是否是rcd
		select check_rcd_available(customers_id_in) into is_rcd;
		#是否是双积分客户
		#select vic.vip_integral_customers_id into vip_integral_customers_id from t_vip_integral_customers vic where vic.customers_id = customers_id_in limit 1;
		
		select ifnull(sum(order_total), 0.00) into history_amount_1 from t_orders where orders_status in (2,3,4,10,41) and customers_id = customers_id_in;
		select ifnull(sum(usd_order_total), 0.00) into history_amount_2 from t_declare_orders where status>0 and customer_id = customers_id_in;
		if vip_integral_customers_id is not null then
			select ifnull(sum(o.order_total), 0.00) into history_amount_3 from t_orders o ,t_use_vip_integral uv where uv.order_id = o.orders_id and o.orders_status in (2,3,4,10,41) and o.customers_id = customers_id_in;
		end if;
		set history_amount = history_amount_1 + history_amount_2 + history_amount_3;
	else
		set is_rcd = 0;
		set vip_integral_customers_id = 0;
		set history_amount = 0;
	end if;

		update tmp_customers_basket tcb set tcb.original_price = get_products_special_price(tcb.products_id, tcb.final_price, tcb.customers_basket_quantity, 0), tcb.promotion_discount = get_products_promotion_discount(tcb.products_id), tcb.dailydeal_price = get_products_dailydeal_price(tcb.products_id), tcb.final_price = get_products_special_price(tcb.products_id, tcb.final_price, tcb.customers_basket_quantity, 1), tcb.products_status_my_products = get_is_my_products(customers_id_in, tcb.products_id);
		#update tmp_customers_basket tcb set tcb.original_price = get_products_special_price(tcb.products_id, tcb.final_price, tcb.customers_basket_quantity, 0), tcb.final_price = get_products_special_price(tcb.products_id, tcb.final_price, tcb.customers_basket_quantity, 1);
		#下面可以用到临时表里的数据了
		#update tmp_customers_basket tcb inner join tmp_products_price tpp on tpp.products_id = tcb.products_id set tcb.original_price = tpp.original_price, tcb.promotion_discount = tpp.promotion_discount, tcb.products_service_price = tpp.products_service_price, tcb.dailydeal_price = tpp.dailydeal_price, tcb.final_price = tpp.final_price;

	select * from tmp_customers_basket;



	#select t1.products_id, count(t1.products_id) count from (select pnwcr.products_id, pnwcr.tag_id from t_products_name_without_catg_relation pnwcr where pnwcr.products_id in(select tcp.products_id from tmp_customers_basket tcp where tcp.products_status != 1)) t1 inner join t_products_name_without_catg_relation pnwcr on pnwcr.tag_id=t1.tag_id where exists(select p.products_id from t_products p where p.products_id = pnwcr.products_id and p.products_status=1) group by t1.products_id;
	#select t1.products_id, count(t1.products_id) count from (select pnwcr.products_id, pnwcr.tag_id from t_products_name_without_catg_relation pnwcr where pnwcr.products_id in(select tcp.products_id from tmp_customers_basket tcp where tcp.products_status != 1)) t1 inner join t_products_name_without_catg_relation pnwcr on pnwcr.tag_id=t1.tag_id where exists(select p.products_id from t_products p where p.products_id = pnwcr.products_id and p.products_status=1) group by t1.products_id
	#是否存在also like，这种写法最快，注意in和exists
	#select t1.products_id, count(t1.products_id) count from (select pnwcr.products_id, pnwcr.tag_id from t_products_name_without_catg_relation pnwcr where exists (select products_id from tmp_customers_basket tcp where tcp.products_status != 1 and tcp.products_id=pnwcr.products_id)) t1 inner join t_products_name_without_catg_relation pnwcr on pnwcr.tag_id=t1.tag_id where pnwcr.products_id in (select p.products_id from t_products p where p.products_status=1) group by t1.products_id;
	
	
	select is_rcd, ifnull(vip_integral_customers_id, 0) vip_integral_customers_id, history_amount;
	
	#客户当前vip信息、是否是
	select gpd.group_name, gp.group_percentage, gp.max_amt, gp.min_amt from t_group_pricing gp, t_customers c inner join t_group_pricing_description gpd where c.customers_group_pricing = gp.group_id and gp.group_id = gpd.group_id and c.customers_id = customers_id_in and gpd.language_id = languages_id_in;
	
	#客户当前下一个等级vip信息
	select gpd.group_name, gp.group_percentage, gp.max_amt, gp.min_amt from t_group_pricing gp, t_customers c inner join t_group_pricing_description gpd where c.customers_group_pricing = gp.group_id-1 and gp.group_id = gpd.group_id and c.customers_id = customers_id_in and gpd.language_id = languages_id_in;

	#select * from tmp_products_price;
	
	###my products注释
	###select tcb.products_id, tcb.products_model, tcb.products_status, tcb.products_status_my_products, tcb.products_limit_stock, tcb.products_quantity from tmp_customers_basket tcb where tcb.products_status=0;

	#select tcb.products_id, tcb.products_model, tcb.products_status, tcb.products_status_my_products, tcb.products_limit_stock, tcb.products_quantity from tmp_customers_basket tcb where tcb.products_status=0 and (tcb.products_status_my_products=1);
	#select tcb.products_id, tcb.products_model, tcb.products_status, tcb.products_status_my_products, tcb.products_limit_stock, tcb.products_quantity from tmp_customers_basket tcb where tcb.products_limit_stock=1 and tcb.customers_basket_quantity>tcb.products_quantity;
	#select * from t_my_products;
	

	#修改购物车限制库存的产品所在的购物车的数据
	#update t_customers_basket cb inner join (select products_id, products_model, customers_basket_quantity, products_quantity from tmp_customers_basket where products_limit_stock=1 and products_status=1 and customers_basket_quantity>products_quantity) temp1 on cb.products_id=temp1.products_id set cb.customers_basket_quantity=temp1.products_quantity;
end;

/*
CALL get_isvalid_checkout_products_optimize(40083, '', 1);

select * from t_customers where customers_email_address='tianwen.wan@panduo.com.cn';
select * from t_customers_basket where customers_id=40083;

select * from t_customers_basket where customers_id=40083;
insert into t_customers_basket (customers_id, cookie_id, products_id, customers_basket_quantity, final_price, customers_basket_date_added, note) SELECT 40083, '', products_id, 1, 0.00, '20160316', '' from t_orders_products GROUP BY products_id order by orders_id desc limit 10;
*/

select NOW();