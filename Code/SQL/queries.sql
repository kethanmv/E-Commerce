--easy queries

--1. name of customers ending with a
select fname from customer where fname like '%a' ;

--2. search for a product
select * from products where prod_name like '%sam%';

--3. get all the product names and prices in a category.
select prod_name,msrp from products where category_id=21370;
select count(*) from products where category_id=21370;

--4. find all products on discount
select prod_name,msrp,discount from products where discount>0.0;

--5. select all products sold by a seller
select prod_id,prod_name,msrp,units_in_stock from products where supplier_id=93587023;

--6. display details of customers who live in la.
select cust_id,fname,lname,phone,email,country,state from customer where state='la';

--7. display all orders and their order dates.
select distinct order_details.order_id, order_date from order_details,orders where order_details.order_id=orders.order_id;

--8. find the total billing amount of each order.
select order_id,sum(price) from order_details group by(order_id);

--medium queries

--1.display all recent orders
select cust_id, order_date from orders order by order_date desc;

--2.display all the prices in decreasing order
select product_id, msrp from products order by msrp desc;

--3.find all the products which has discount between 20 and 40
select prod_name, discount, msrp from products where discount between 20.0 and 40.0;

--4.find all the customers who have placed orders in a specified date
select fname, lname, c.cust_id from customer as c,orders as o where c.cust_id=o.cust_id and order_date in('2016-09-03');

--5.list of all customer id and the total payment received from them in the specified year.
select o.cust_id, sum(od.price) as total_amount from orders as o left join order_details as od on o.order_id = od.order_id where date_part('year',o.payment_date) = '2018' group by cust_id;

--6.list contact information of suppliers and customers
select 'customer' as type, concat(fname, ' ', lname)  as contact_name, phone, country, state, city, postal from customer
union
select 'suppliers', concat(contact_fname, ' ', contact_lname) as contact_name, phone, country, state, city, postal from suppliers;

--7.select all customers that are from the same countries as the suppliers
select * from customer where country in (select country from suppliers);
   

-- hard queries

--1. find first time customers
select cust_id,fname,lname,phone from customer where cust_id not in (select distinct cust_id from orders);

--2. find the most sold product.
select prod_id,prod_name,msrp from products where units_on_order = (select max(units_on_order) from products);

--3. search for customer who ordered the most products.
select cust_id,fname,lname,date_joined,country from customer where cust_id=(select cust_id from orders where order_id=(select order_id from order_details group by order_id order by count(*) desc limit 1));

--4. get order details for a particular order.
select o.order_id,p.prod_id,p.prod_name,p.msrp,s.contact_fname,s.contact_lname from products as p,orders as o,order_details as od,suppliers as s where p.prod_id=od.product_id and od.order_id=o.order_id and s.supplier_id=p.supplier_id and o.order_id=853194;

--5. get details about order and customer for all pending orders shipped by a shipper.
select o.order_id,o.order_date,c.fname,c.lname,c.phone,c.billing_address,c.postal,c.email from orders as o join customer as c on o.cust_id=c.cust_id where o.shipper_id=33774310543 and o.transact_status='succeed' order by o.order_date;

--6. get all products a customer has purchased.
select prod_id,prod_name from products where prod_id in (select product_id from order_details where order_id in (select order_id from orders where cust_id=67994));

--7. get the most sold product in each category. 
select max(units_on_order),category_id from products group by(category_id);

--8. select all customers who paid through 'online payment'
select order_id,c.cust_id,c.fname,c.lname from orders as o,customer as c where c.cust_id=o.cust_id  and payment_id in (select payment_id from payment where payment_type='online payment');