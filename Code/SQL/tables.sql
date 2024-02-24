CREATE TABLE category
(
    category_id integer NOT NULL,
    category_name character varying(30) COLLATE pg_catalog."default" NOT NULL,
    description character varying(100) COLLATE pg_catalog."default",
    CONSTRAINT category_pkey PRIMARY KEY (category_id)
);

CREATE TABLE customer
(
    cust_id integer NOT NULL,
    date_joined date NOT NULL,
    fname character varying(30) COLLATE pg_catalog."default",
    lname character varying(30) COLLATE pg_catalog."default",
    phone bigint NOT NULL,
    email character varying(50) COLLATE pg_catalog."default" NOT NULL,
    password character varying(200) COLLATE pg_catalog."default" NOT NULL,
    ship_address character varying(255) COLLATE pg_catalog."default" NOT NULL,
    billing_address character varying(255) COLLATE pg_catalog."default",
    country character varying(30) COLLATE pg_catalog."default" NOT NULL,
    state character varying(30) COLLATE pg_catalog."default" NOT NULL,
    city character varying(30) COLLATE pg_catalog."default" NOT NULL,
    street character varying(30) COLLATE pg_catalog."default" NOT NULL,
    hno character varying(5) COLLATE pg_catalog."default" NOT NULL,
    postal integer NOT NULL,
    CONSTRAINT customer_pkey PRIMARY KEY (cust_id)
);

CREATE TABLE shippers
(
    shipper_id bigint NOT NULL,
    company_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    phone bigint NOT NULL,
    CONSTRAINT shippers_pkey PRIMARY KEY (shipper_id)
);

CREATE TABLE suppliers
(
    supplier_id integer NOT NULL,
    payment_method character varying(20) COLLATE pg_catalog."default" NOT NULL,
    discount numeric(3,1) DEFAULT 0.0,
    company_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    contact_fname character varying(50) COLLATE pg_catalog."default",
    contact_lname character varying(50) COLLATE pg_catalog."default",
    email character varying(50) COLLATE pg_catalog."default",
    phone bigint NOT NULL,
    country character varying(20) COLLATE pg_catalog."default" NOT NULL,
    state character varying(20) COLLATE pg_catalog."default" NOT NULL,
    city character varying(20) COLLATE pg_catalog."default" NOT NULL,
    street character varying(40) COLLATE pg_catalog."default" NOT NULL,
    dno character varying(5) COLLATE pg_catalog."default",
    postal integer,
    CONSTRAINT suppliers_pkey PRIMARY KEY (supplier_id),
    CONSTRAINT suppliers_discount_check CHECK (discount >= 0.0),
    CONSTRAINT suppliers_discount_check1 CHECK (discount <= 100.0)
);

CREATE TABLE products
(
    prod_id integer NOT NULL,
    prod_name character varying(100) COLLATE pg_catalog."default" NOT NULL,
    discount numeric(4,1) DEFAULT 0.0,
    units_in_stock integer NOT NULL,
    units_on_order integer NOT NULL,
    prod_desc character varying(1000) COLLATE pg_catalog."default",
    picture character varying(50) COLLATE pg_catalog."default" NOT NULL,
    supplier_id integer,
    category_id integer,
    qpu integer NOT NULL,
    unitprice numeric(8,2) NOT NULL,
    msrp numeric(8,2) NOT NULL,
    available_size character varying(100) COLLATE pg_catalog."default" DEFAULT 'NA'::character varying,
    available_color character varying(100) COLLATE pg_catalog."default" DEFAULT 'NA'::character varying,
    active integer,
    CONSTRAINT products_pkey PRIMARY KEY (prod_id),
    CONSTRAINT products_category_id_fkey FOREIGN KEY (category_id)
        REFERENCES public.category (category_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT products_supplier_id_fkey FOREIGN KEY (supplier_id)
        REFERENCES public.suppliers (supplier_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

CREATE TABLE payment
(
    payment_id integer NOT NULL,
    payment_type character varying(20) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT payment_pkey PRIMARY KEY (payment_id)
);

CREATE TABLE orders
(
    order_id integer NOT NULL,
    payment_date date NOT NULL,
    cust_id integer,
    payment_id bigint,
    order_date date NOT NULL,
    ship_date date NOT NULL,
    shipper_id bigint,
    time_stamp timestamp without time zone,
    transact_status character varying(20) COLLATE pg_catalog."default" DEFAULT 'Not Avaialable'::character varying,
    delivery_status character varying(50) COLLATE pg_catalog."default",
    CONSTRAINT orders_pkey PRIMARY KEY (order_id),
    CONSTRAINT orders_cust_id_fkey FOREIGN KEY (cust_id)
        REFERENCES public.customer (cust_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT orders_payment_id_fkey FOREIGN KEY (payment_id)
        REFERENCES public.payment (payment_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT orders_shipper_id_fkey FOREIGN KEY (shipper_id)
        REFERENCES public.shippers (shipper_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

CREATE TABLE order_details
(
    order_id integer,
    ship_date date NOT NULL,
    bill_date date NOT NULL,
    product_id integer,
    price numeric(8,2) NOT NULL,
    quantity integer NOT NULL DEFAULT 1,
    discount numeric(4,1) DEFAULT 0.0,
    size character varying(10) COLLATE pg_catalog."default" DEFAULT 'NA'::character varying,
    color character varying(50) COLLATE pg_catalog."default" DEFAULT 'NA'::character varying,
    CONSTRAINT order_details_order_id_fkey FOREIGN KEY (order_id)
        REFERENCES public.orders (order_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT order_details_product_id_fkey FOREIGN KEY (product_id)
        REFERENCES public.products (prod_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);