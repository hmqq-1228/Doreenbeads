############是否是my products###############
delimiter $$
drop function if exists get_is_my_products;
create function get_is_my_products (customers_id_in int(10), products_id_in int(10))
  returns int
begin
	declare is_my_val int;

	if customers_id_in <= 0 or products_id_in <= 0 then
		return 0;
	end if;

	#是否渠道商
	select count(*) into is_my_val from t_my_products where customers_id = customers_id_in and products_id = products_id_in;
	if is_my_val > 0 then
		return 1;
	end if;
  return 0;
end$$


############是否是RCD###############
delimiter $$
drop function if exists check_rcd_available;
create function check_rcd_available (customers_id_in int(10))
  returns int
begin
	declare channel_val int;
	declare customers_info_date_account_created_val int;
	declare orders_id_count_val int;
	
	#暂时用不到返回0
	return 0;

	if customers_id_in <= 0 then
		return 0;
	end if;



	#是否渠道商
	select count(*) into channel_val from t_channel where channel_customers_id = customers_id_in;
	if channel_val > 0 then
		return 0;
	end if;

	select customers_info_date_account_created into customers_info_date_account_created_val from t_customers_info where customers_info_id = customers_id_in;
	if customers_info_date_account_created_val > '2014-04-15 11:00:00' then
		return 0;
	end if;


	select count(*) into orders_id_count_val from t_orders where customers_id = customers_id_in;
	if orders_id_count_val <= 0 then
		return 0;
	end if;

	#club免运费或者满足免运费时不可用
	

	
  return 1;
end$$


############得到产品的专享或促销等价格###############
delimiter $$
DROP FUNCTION if exists get_products_special_price;
CREATE FUNCTION get_products_special_price (products_id_in int(10), products_price_in float(10, 4), products_quantity_in int(10), use_special_price_in tinyint(2))
  RETURNS float(10, 2)
begin
	declare customers_info_date_account_created_val datetime;
	declare channel_val int;
	declare original_price_val float(10, 2);
	declare promotion_account_val float(10, 2);
	declare promotion_discount_val float(10, 2);
	declare discount_price_val float(10, 2);
	declare service_charge_val float(10, 2) default 0.00;

	

	if products_price_in is null or products_price_in <= 0 then
		select products_price into products_price_in from t_products where products_id = products_id_in;
	end if;


	select pdq.discount_price into discount_price_val from t_products_discount_quantity pdq where pdq.products_id = products_id_in and pdq.discount_qty <= products_quantity_in order by discount_qty desc limit 1;

	if discount_price_val is null then
		set discount_price_val = products_price_in;
	end if;


	#set original_price_val = products_price_in - (products_price_in * (discount_price_val / 100));
	set original_price_val = discount_price_val;


	if use_special_price_in = 1 then
		#insert into tmp_products_price (products_id, original_price, promotion_discount, dailydeal_price, products_service_price, final_price) values (products_id_in, 0.00, 0.00, 0.00, 0.00, 0.00);


		#products_id:114754
		select get_products_dailydeal_price(products_id_in) into promotion_account_val;
		#select dp.promotion_account into promotion_account_val from t_dailydeal_promotion dp inner join t_dailydeal_area zda on dp.area_id = zda.dailydeal_area_id where products_id = products_id_in and dp.dailydeal_products_start_date < now() and dp.dailydeal_products_end_date >= now() and dp.dailydeal_is_forbid = 10 and zda.area_status = 1 and zda.area_type = 10 order by dp.dailydeal_promotion_id desc limit 1;
		
		if promotion_account_val is not null and promotion_account_val > 0 then
				#update tmp_products_price tpp set tpp.dailydeal_price = promotion_account_val, final_price = promotion_account_val where tpp.products_id = products_id_in;
				return promotion_account_val;
		else
			set promotion_account_val = discount_price_val;
		end if;

		

		#products_id:25020
		select get_products_promotion_discount(products_id_in) into promotion_discount_val;

		if promotion_discount_val is not null and promotion_discount_val > 0 then
			#update tmp_products_price tpp set tpp.promotion_discount = promotion_discount_val where tpp.products_id = products_id_in;
			set promotion_account_val = round(promotion_account_val - (promotion_account_val * promotion_discount_val / 100), 2);
		end if;


		if promotion_account_val is null or promotion_account_val <= 0 then
			set promotion_account_val = products_price_in;
		#else
			#set promotion_account_val = discount_price_val - (discount_price_val * (discount_price_val / 100));
			#set promotion_account_val = discount_price_val;
		end if;


		
	else
		#set promotion_account_val = products_price_in - (products_price_in * (discount_price_val / 100));
		set promotion_account_val = discount_price_val;
		#update tmp_products_price tpp set tpp.original_price = promotion_account_val where tpp.products_id = products_id_in;
	end if;


	#该临时表(tmp_products_price)在存储过程get_isvalid_checkout_products_optimize在创建，必须和存储过程一起使用
	#insert into tmp_products_price (products_id, original_price, promotion_discount, dailydeal_price, products_service_price, final_price) values (products_id_in, promotion_account_val, 0.00, promotion_account_val, promotion_account_val, promotion_account_val);
	#update tmp_products_price tpp set tpp.final_price = promotion_account_val where tpp.products_id = products_id_in;
  return promotion_account_val;
END$$



############VIP信息###############
delimiter $$
DROP FUNCTION if exists get_customer_vip_info;
CREATE FUNCTION get_customer_vip_info (customers_id_in int(10))
  RETURNS int
begin
	declare customers_info_date_account_created_val datetime;
	declare channel_val int;

	if customers_id_in <= 0 then
		return 0;
	end if;



	#是否渠道商
	select count(*) into channel_val from t_channel where channel_customers_id=customers_id_in;
	if channel_val > 0 then
		return 0;
	end if;

	#club免运费或者满足免运费时不可用
	
  return null;

end$$


############dailydeal_price###############
delimiter $$
DROP FUNCTION if exists get_products_dailydeal_price;
CREATE FUNCTION get_products_dailydeal_price(products_id_in int(10))
  RETURNS float(10, 2)
begin
	declare promotion_account_val float(10, 2);
	
	#products_id:114754
	select dp.dailydeal_price into promotion_account_val from t_dailydeal_promotion dp inner join t_dailydeal_area zda on dp.area_id = zda.dailydeal_area_id where products_id = products_id_in and dp.dailydeal_products_start_date < now() and dp.dailydeal_products_end_date >= now() and dp.dailydeal_is_forbid = 10 and zda.area_status = 1 order by dp.dailydeal_promotion_id desc limit 1;
	
	if promotion_account_val is not null then
			return promotion_account_val;
	else
		set promotion_account_val = 0;
	end if;

  return promotion_account_val;
end$$


############promotion_discount###############
delimiter $$
DROP FUNCTION if exists get_products_promotion_discount;
CREATE FUNCTION get_products_promotion_discount(products_id_in int(10))
  RETURNS int
begin
	declare promotion_discount_val float(10, 2);
	
	#products_id:25020
	select p.promotion_discount into promotion_discount_val from t_promotion p , t_promotion_products pp where pp.pp_products_id = products_id_in and pp.pp_promotion_id = p.promotion_id and pp.pp_is_forbid = 10 and p.promotion_status = 1 and pp.pp_promotion_start_time < now() and pp.pp_promotion_end_time >= now() limit 1;
	
	if promotion_discount_val is not null then
			return promotion_discount_val;
	else
		set promotion_discount_val = 0;
	end if;


	

  return promotion_discount_val;
end$$

############special_price###############
delimiter $$
DROP FUNCTION if exists get_products_special_price;
CREATE FUNCTION get_products_special_price(products_id_in int(10), products_price_in float(10, 2), products_quantity_in int(10), use_special_price_in int(10))
  RETURNS float(10, 2)
begin
	declare customers_info_date_account_created_val datetime;
	declare channel_val int;
	declare original_price_val float(10, 2);
	declare promotion_account_val float(10, 2);
	declare promotion_discount_val float(10, 2);
	declare discount_price_val float(10, 2);
	declare service_charge_val float(10, 2) default 0.00;

	

	if products_price_in is null or products_price_in <= 0 then
		select products_price into products_price_in from t_products where products_id = products_id_in;
	end if;


	select pdq.discount_price into discount_price_val from t_products_discount_quantity pdq where pdq.products_id = products_id_in and pdq.discount_qty <= products_quantity_in order by discount_qty desc limit 1;

	if discount_price_val is null then
		set discount_price_val = products_price_in;
	end if;


	#set original_price_val = products_price_in - (products_price_in * (discount_price_val / 100));
	set original_price_val = discount_price_val;


	if use_special_price_in = 1 then
		#insert into tmp_products_price (products_id, original_price, promotion_discount, dailydeal_price, products_service_price, final_price) values (products_id_in, 0.00, 0.00, 0.00, 0.00, 0.00);


		#products_id:114754
		select get_products_dailydeal_price(products_id_in) into promotion_account_val;
		#select dp.promotion_account into promotion_account_val from t_dailydeal_promotion dp inner join t_dailydeal_area zda on dp.area_id = zda.dailydeal_area_id where products_id = products_id_in and dp.dailydeal_products_start_date < now() and dp.dailydeal_products_end_date >= now() and dp.dailydeal_is_forbid = 10 and zda.area_status = 1 and zda.area_type = 10 order by dp.dailydeal_promotion_id desc limit 1;
		
		if promotion_account_val is not null and promotion_account_val > 0 then
				#update tmp_products_price tpp set tpp.dailydeal_price = promotion_account_val, final_price = promotion_account_val where tpp.products_id = products_id_in;
				return promotion_account_val;
		else
			set promotion_account_val = discount_price_val;
		end if;

		

		#products_id:25020
		select get_products_promotion_discount(products_id_in) into promotion_discount_val;

		if promotion_discount_val is not null and promotion_discount_val > 0 then
			#update tmp_products_price tpp set tpp.promotion_discount = promotion_discount_val where tpp.products_id = products_id_in;
			set promotion_account_val = round(promotion_account_val - (promotion_account_val * promotion_discount_val / 100), 2);
		end if;


		if promotion_account_val is null or promotion_account_val <= 0 then
			set promotion_account_val = products_price_in;
		#else
			#set promotion_account_val = discount_price_val - (discount_price_val * (discount_price_val / 100));
			#set promotion_account_val = discount_price_val;
		end if;


		
	else
		#set promotion_account_val = products_price_in - (products_price_in * (discount_price_val / 100));
		set promotion_account_val = discount_price_val;
		#update tmp_products_price tpp set tpp.original_price = promotion_account_val where tpp.products_id = products_id_in;
	end if;


	#该临时表(tmp_products_price)在存储过程get_isvalid_checkout_products_optimize在创建，必须和存储过程一起使用
	#insert into tmp_products_price (products_id, original_price, promotion_discount, dailydeal_price, products_service_price, final_price) values (products_id_in, promotion_account_val, 0.00, promotion_account_val, promotion_account_val, promotion_account_val);
	#update tmp_products_price tpp set tpp.final_price = promotion_account_val where tpp.products_id = products_id_in;
  return promotion_account_val;
end$$

#能出当前时间说明上面的执行没有问题
select now();