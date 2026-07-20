-- ============================================================
-- AmarMart — MySQL Schema (converted from Oracle)
-- Sequences → AUTO_INCREMENT
-- VARCHAR2 → VARCHAR, CLOB → TEXT, NUMBER → INT/DECIMAL
-- ============================================================

CREATE DATABASE IF NOT EXISTS amarmart
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE amarmart;

-- USERS (Admin only — Laravel Breeze / Auth)
CREATE TABLE IF NOT EXISTS users (
    id                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name              VARCHAR(255)    NOT NULL,
    email             VARCHAR(255)    NOT NULL,
    email_verified_at TIMESTAMP       NULL DEFAULT NULL,
    password          VARCHAR(255)    NOT NULL,
    remember_token    VARCHAR(100)    NULL DEFAULT NULL,
    created_at        TIMESTAMP       NULL DEFAULT NULL,
    updated_at        TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY users_email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email      VARCHAR(255) NOT NULL,
    token      VARCHAR(255) NOT NULL,
    created_at TIMESTAMP    NULL DEFAULT NULL,
    PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS sessions (
    id            VARCHAR(255) NOT NULL,
    user_id       BIGINT UNSIGNED NULL DEFAULT NULL,
    ip_address    VARCHAR(45)  NULL DEFAULT NULL,
    user_agent    TEXT         NULL,
    payload       LONGTEXT     NOT NULL,
    last_activity INT          NOT NULL,
    PRIMARY KEY (id),
    KEY sessions_user_id_index (user_id),
    KEY sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PRODUCTS
CREATE TABLE IF NOT EXISTS products (
    product_id   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name         VARCHAR(255)    NOT NULL,
    description  TEXT            NULL,
    price        DECIMAL(10, 2)  NOT NULL,
    stock        INT             NOT NULL DEFAULT 0,
    image        VARCHAR(500)    NULL DEFAULT NULL,
    created_at   TIMESTAMP       NULL DEFAULT NULL,
    updated_at   TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ORDERS (includes geolocation lat/lng)
CREATE TABLE IF NOT EXISTS orders (
    order_id        BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    invoice_number  VARCHAR(50)     NOT NULL,
    customer_name   VARCHAR(255)    NOT NULL,
    phone           VARCHAR(20)     NOT NULL,
    email           VARCHAR(255)    NOT NULL,
    address         TEXT            NOT NULL,
    latitude        DECIMAL(10, 8)  NULL DEFAULT NULL,
    longitude       DECIMAL(11, 8)  NULL DEFAULT NULL,
    total_amount    DECIMAL(10, 2)  NOT NULL DEFAULT 0.00,
    created_at      TIMESTAMP       NULL DEFAULT NULL,
    updated_at      TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (order_id),
    UNIQUE KEY orders_invoice_number_unique (invoice_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ORDER ITEMS
CREATE TABLE IF NOT EXISTS order_items (
    order_item_id  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    order_id       BIGINT UNSIGNED NOT NULL,
    product_id     BIGINT UNSIGNED NOT NULL,
    quantity       INT             NOT NULL DEFAULT 1,
    price          DECIMAL(10, 2)  NOT NULL,
    subtotal       DECIMAL(10, 2)  NOT NULL,
    PRIMARY KEY (order_item_id),
    CONSTRAINT fk_order_items_orders
        FOREIGN KEY (order_id) REFERENCES orders (order_id) ON DELETE CASCADE,
    CONSTRAINT fk_order_items_products
        FOREIGN KEY (product_id) REFERENCES products (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CACHE / JOBS (Laravel)
CREATE TABLE IF NOT EXISTS cache (
    `key`        VARCHAR(255) NOT NULL,
    value        MEDIUMTEXT   NOT NULL,
    expiration   INT          NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cache_locks (
    `key`        VARCHAR(255) NOT NULL,
    owner        VARCHAR(255) NOT NULL,
    expiration   INT          NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS jobs (
    id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    queue        VARCHAR(255)    NOT NULL,
    payload      LONGTEXT        NOT NULL,
    attempts     TINYINT UNSIGNED NOT NULL,
    reserved_at  INT UNSIGNED    NULL DEFAULT NULL,
    available_at INT UNSIGNED    NOT NULL,
    created_at   INT UNSIGNED    NOT NULL,
    PRIMARY KEY (id),
    KEY jobs_queue_index (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS job_batches (
    id             VARCHAR(255) NOT NULL,
    name           VARCHAR(255) NOT NULL,
    total_jobs     INT          NOT NULL,
    pending_jobs   INT          NOT NULL,
    failed_jobs    INT          NOT NULL,
    failed_job_ids LONGTEXT     NOT NULL,
    options        MEDIUMTEXT   NULL,
    cancelled_at   INT          NULL DEFAULT NULL,
    created_at     INT          NOT NULL,
    finished_at    INT          NULL DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS failed_jobs (
    id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    uuid       VARCHAR(255)    NOT NULL,
    connection TEXT            NOT NULL,
    queue      TEXT            NOT NULL,
    payload    LONGTEXT        NOT NULL,
    exception  LONGTEXT        NOT NULL,
    failed_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY failed_jobs_uuid_unique (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SAMPLE DATA
-- Admin password = "password" (bcrypt)
-- ============================================================

INSERT INTO users (name, email, password, created_at, updated_at) VALUES
('Admin', 'admin@amarmart.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

INSERT INTO products (name, description, price, stock, image, created_at, updated_at) VALUES
('Samsung Galaxy A55', 'The Samsung Galaxy A55 features a 6.6-inch Super AMOLED display, 50MP triple camera, and a powerful Exynos 1480 processor.', 45000.00, 25, NULL, NOW(), NOW()),
('Apple iPhone 14', 'Apple iPhone 14 with A15 Bionic chip, 6.1-inch Super Retina XDR display, dual-camera system, and emergency SOS via satellite.', 115000.00, 10, NULL, NOW(), NOW()),
('Dell Inspiron 15 Laptop', 'Dell Inspiron 15 with Intel Core i5 12th Gen processor, 8GB RAM, 512GB SSD, and 15.6-inch FHD display.', 75000.00, 15, NULL, NOW(), NOW()),
('Sony WH-1000XM5 Headphones', 'Industry-leading noise cancellation headphones with 30-hour battery life and crystal-clear call quality.', 35000.00, 30, NULL, NOW(), NOW()),
('Nike Air Max 270', 'Nike Air Max 270 running shoes featuring maximum cushioning and comfort. Lightweight and stylish.', 12000.00, 50, NULL, NOW(), NOW()),
('Canon EOS M50 Camera', 'Canon EOS M50 Mark II mirrorless camera with 24.1MP sensor, 4K video recording, and built-in Wi-Fi.', 65000.00, 3, NULL, NOW(), NOW()),
('Organic Cotton T-Shirt', 'Premium quality organic cotton t-shirt. Soft, breathable, and eco-friendly fabric.', 800.00, 100, NULL, NOW(), NOW()),
('Stainless Steel Water Bottle', 'BPA-free insulated water bottle that keeps drinks cold for 24 hours and hot for 12 hours.', 1500.00, 0, NULL, NOW(), NOW());
