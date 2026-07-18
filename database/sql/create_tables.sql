-- ============================================================
-- AmarMart Oracle Database Setup Script
-- Run this script as SYSDBA or as the AMARMART schema owner
-- ============================================================

-- ============================================================
-- 1. CREATE SCHEMA USER (run as SYSDBA if needed)
-- ============================================================
-- CREATE USER AMARMART IDENTIFIED BY password;
-- GRANT CONNECT, RESOURCE, CREATE SESSION, CREATE TABLE,
--       CREATE SEQUENCE, CREATE TRIGGER TO AMARMART;
-- ALTER USER AMARMART QUOTA UNLIMITED ON USERS;


-- ============================================================
-- 2. PRODUCTS TABLE
-- ============================================================
CREATE TABLE products (
    product_id   NUMBER          NOT NULL,
    name         VARCHAR2(255)   NOT NULL,
    description  CLOB,
    price        NUMBER(10, 2)   NOT NULL,
    stock        NUMBER(10)      NOT NULL DEFAULT 0,
    image        VARCHAR2(500),
    created_at   TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_products PRIMARY KEY (product_id)
);

-- Sequence for products
CREATE SEQUENCE seq_products START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

-- Trigger for auto-increment
CREATE OR REPLACE TRIGGER trg_products_bi
BEFORE INSERT ON products
FOR EACH ROW
BEGIN
    IF :NEW.product_id IS NULL THEN
        SELECT seq_products.NEXTVAL INTO :NEW.product_id FROM DUAL;
    END IF;
    :NEW.created_at := CURRENT_TIMESTAMP;
    :NEW.updated_at := CURRENT_TIMESTAMP;
END;
/

-- Trigger for updated_at
CREATE OR REPLACE TRIGGER trg_products_bu
BEFORE UPDATE ON products
FOR EACH ROW
BEGIN
    :NEW.updated_at := CURRENT_TIMESTAMP;
END;
/


-- ============================================================
-- 3. ORDERS TABLE
-- ============================================================
CREATE TABLE orders (
    order_id        NUMBER          NOT NULL,
    invoice_number  VARCHAR2(50)    NOT NULL,
    customer_name   VARCHAR2(255)   NOT NULL,
    phone           VARCHAR2(20)    NOT NULL,
    email           VARCHAR2(255)   NOT NULL,
    address         CLOB            NOT NULL,
    total_amount    NUMBER(10, 2)   NOT NULL DEFAULT 0,
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_orders          PRIMARY KEY (order_id),
    CONSTRAINT uq_orders_invoice  UNIQUE (invoice_number)
);

-- Sequence for orders
CREATE SEQUENCE seq_orders START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

-- Trigger for auto-increment
CREATE OR REPLACE TRIGGER trg_orders_bi
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
    IF :NEW.order_id IS NULL THEN
        SELECT seq_orders.NEXTVAL INTO :NEW.order_id FROM DUAL;
    END IF;
    :NEW.created_at := CURRENT_TIMESTAMP;
    :NEW.updated_at := CURRENT_TIMESTAMP;
END;
/

-- Trigger for updated_at
CREATE OR REPLACE TRIGGER trg_orders_bu
BEFORE UPDATE ON orders
FOR EACH ROW
BEGIN
    :NEW.updated_at := CURRENT_TIMESTAMP;
END;
/


-- ============================================================
-- 4. ORDER_ITEMS TABLE
-- ============================================================
CREATE TABLE order_items (
    order_item_id  NUMBER        NOT NULL,
    order_id       NUMBER        NOT NULL,
    product_id     NUMBER        NOT NULL,
    quantity       NUMBER(10)    NOT NULL DEFAULT 1,
    price          NUMBER(10,2)  NOT NULL,
    subtotal       NUMBER(10,2)  NOT NULL,
    CONSTRAINT pk_order_items         PRIMARY KEY (order_item_id),
    CONSTRAINT fk_order_items_orders  FOREIGN KEY (order_id)    REFERENCES orders(order_id)   ON DELETE CASCADE,
    CONSTRAINT fk_order_items_product FOREIGN KEY (product_id)  REFERENCES products(product_id)
);

-- Sequence for order_items
CREATE SEQUENCE seq_order_items START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

-- Trigger for auto-increment
CREATE OR REPLACE TRIGGER trg_order_items_bi
BEFORE INSERT ON order_items
FOR EACH ROW
BEGIN
    IF :NEW.order_item_id IS NULL THEN
        SELECT seq_order_items.NEXTVAL INTO :NEW.order_item_id FROM DUAL;
    END IF;
END;
/


-- ============================================================
-- 5. USERS TABLE (Admin)
-- ============================================================
CREATE TABLE users (
    id              NUMBER          NOT NULL,
    name            VARCHAR2(255)   NOT NULL,
    email           VARCHAR2(255)   NOT NULL,
    password        VARCHAR2(255)   NOT NULL,
    remember_token  VARCHAR2(100),
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_users       PRIMARY KEY (id),
    CONSTRAINT uq_users_email UNIQUE (email)
);

-- Sequence for users
CREATE SEQUENCE seq_users START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

-- Trigger for auto-increment
CREATE OR REPLACE TRIGGER trg_users_bi
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    IF :NEW.id IS NULL THEN
        SELECT seq_users.NEXTVAL INTO :NEW.id FROM DUAL;
    END IF;
    :NEW.created_at := CURRENT_TIMESTAMP;
    :NEW.updated_at := CURRENT_TIMESTAMP;
END;
/


-- ============================================================
-- 6. MIGRATIONS TABLE (Laravel migration tracking)
-- ============================================================
CREATE TABLE migrations (
    id          NUMBER          NOT NULL,
    migration   VARCHAR2(255)   NOT NULL,
    batch       NUMBER(10)      NOT NULL,
    CONSTRAINT pk_migrations PRIMARY KEY (id)
);

CREATE SEQUENCE seq_migrations START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER trg_migrations_bi
BEFORE INSERT ON migrations
FOR EACH ROW
BEGIN
    IF :NEW.id IS NULL THEN
        SELECT seq_migrations.NEXTVAL INTO :NEW.id FROM DUAL;
    END IF;
END;
/


-- ============================================================
-- 7. SAMPLE DATA — PRODUCTS
-- ============================================================
INSERT INTO products (name, description, price, stock, image) VALUES (
    'Samsung Galaxy A55',
    'The Samsung Galaxy A55 features a 6.6-inch Super AMOLED display, 50MP triple camera, and a powerful Exynos 1480 processor. Ideal for everyday use with long battery life.',
    45000, 25, 'products/product1.jpg'
);
INSERT INTO products (name, description, price, stock, image) VALUES (
    'Apple iPhone 14',
    'Apple iPhone 14 with A15 Bionic chip, 6.1-inch Super Retina XDR display, dual-camera system, and emergency SOS via satellite. Experience premium performance.',
    115000, 10, 'products/product2.jpg'
);
INSERT INTO products (name, description, price, stock, image) VALUES (
    'Dell Inspiron 15 Laptop',
    'Dell Inspiron 15 with Intel Core i5 12th Gen processor, 8GB RAM, 512GB SSD, and 15.6-inch FHD display. Perfect for students and professionals.',
    75000, 15, 'products/product3.jpg'
);
INSERT INTO products (name, description, price, stock, image) VALUES (
    'Sony WH-1000XM5 Headphones',
    'Industry-leading noise cancellation headphones with 30-hour battery life, multipoint connection, and crystal-clear call quality. Premium audio experience.',
    35000, 30, 'products/product4.jpg'
);
INSERT INTO products (name, description, price, stock, image) VALUES (
    'Nike Air Max 270',
    'Nike Air Max 270 running shoes featuring the largest Air unit yet for maximum cushioning and comfort. Lightweight and stylish for everyday wear.',
    12000, 50, 'products/product5.jpg'
);
INSERT INTO products (name, description, price, stock, image) VALUES (
    'Canon EOS M50 Camera',
    'Canon EOS M50 Mark II mirrorless camera with 24.1MP sensor, 4K video recording, Eye Detection AF, and built-in Wi-Fi. Great for content creators.',
    65000, 8, 'products/product6.jpg'
);
INSERT INTO products (name, description, price, stock, image) VALUES (
    'Organic Cotton T-Shirt',
    'Premium quality organic cotton t-shirt available in multiple colors. Soft, breathable, and eco-friendly fabric. Perfect for casual daily wear.',
    800, 100, 'products/product7.jpg'
);
INSERT INTO products (name, description, price, stock, image) VALUES (
    'Stainless Steel Water Bottle',
    'BPA-free stainless steel insulated water bottle that keeps drinks cold for 24 hours and hot for 12 hours. Leak-proof and eco-friendly.',
    1500, 75, 'products/product8.jpg'
);

COMMIT;

-- ============================================================
-- END OF SCRIPT
-- ============================================================
