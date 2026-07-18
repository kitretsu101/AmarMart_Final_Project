# AmarMart — Mini E-Commerce Website

AmarMart is a clean, modern, and professional mini e-commerce web application built using **Laravel 12**, **PHP 8.2+**, **Oracle Database (XE/21c)**, **yajra/laravel-oci8**, and **Bootstrap 5**. It features a session-based shopping cart, checkout, automatic invoice generation, and a fully functional admin panel for product and order management.

---

## Design System
* **CSS Framework**: Bootstrap 5
* **Typography**: Times New Roman (applied globally throughout the site)
* **Color Palette**: Sleek combination of deep blue (`#1a56a5`), white, and light gray (`#f4f6f9`)

---

## Features
### Public Shop
* **Home Page**: Responsive product list displaying products in Bootstrap cards with a search bar to filter products by name.
* **Product Details**: Dedicated details view showcasing a large image, price, stock status, full description, and an "Add to Cart" button.
* **Shopping Cart**: Session-based cart with options to adjust quantities (which automatically updates subtotals and totals) or remove items.
* **Checkout**: Simple billing form capturing name, phone number, email, and shipping address. Validates inputs and handles stock management upon order placement.
* **Invoice Generation**: Displays an automatic unique invoice page after checkout with order breakdown, customer info, and a browser-friendly print button.

### Admin Panel
* **Admin Login**: Secure login restricted to store administrators.
* **Dashboard**: Key business metrics including total products count, total orders count, and total revenue.
* **Product Management**: Full CRUD operations (Add, Edit, Delete, View) with support for uploading product images using Laravel's public storage disk.
* **Order Management**: Read-only tracking of all customer purchases, showing line items, pricing, totals, and customer details.

---

## Technical Specifications & Database Schema

### Products (`products`)
* `product_id` (PK, Auto-increment)
* `name` (VARCHAR2)
* `description` (CLOB)
* `price` (NUMBER(10,2))
* `stock` (NUMBER)
* `image` (VARCHAR2)
* `created_at` (TIMESTAMP)
* `updated_at` (TIMESTAMP)

### Orders (`orders`)
* `order_id` (PK, Auto-increment)
* `invoice_number` (VARCHAR2, Unique)
* `customer_name` (VARCHAR2)
* `phone` (VARCHAR2)
* `email` (VARCHAR2)
* `address` (CLOB)
* `total_amount` (NUMBER(10,2))
* `created_at` (TIMESTAMP)
* `updated_at` (TIMESTAMP)

### Order Items (`order_items`)
* `order_item_id` (PK, Auto-increment)
* `order_id` (FK → orders)
* `product_id` (FK → products)
* `quantity` (NUMBER)
* `price` (NUMBER(10,2))
* `subtotal` (NUMBER(10,2))

---

## Installation & Setup Instructions

Follow these steps to set up and run the application:

### 1. Prerequisites
Ensure you have the following installed on your system:
* **PHP 8.2 or 8.3**
* **Composer**
* **Oracle Database (XE/19c/21c)**
* **OCI8 PHP Extension** (`php_oci8.dll` for Windows/XAMPP, or `oci8.so` for Linux). Make sure it's enabled in your `php.ini` file (`extension=oci8_19` or similar depending on your client version).

### 2. Clone and Install Dependencies
Navigate to the project root directory and install Composer dependencies:
```bash
composer install
```
*Note: If OCI8 is not active on your command-line PHP but is configured for your web server, you can bypass platform checks during installation using:*
```bash
composer install --ignore-platform-reqs
```

### 3. Environment Configuration
Duplicate the example environment file:
```bash
cp .env.example .env
```
Open `.env` and set up your application key and Oracle Database details:
```env
APP_NAME=AmarMart
APP_URL=http://localhost:8000

DB_CONNECTION=oracle
DB_HOST=127.0.0.1
DB_PORT=1521
DB_DATABASE=XE        # Or your Oracle Service Name / SID
DB_USERNAME=AMARMART  # Your Oracle Schema Username
DB_PASSWORD=password  # Your Oracle Schema Password

SESSION_DRIVER=file
CACHE_STORE=file
```

### 4. Database Setup (Choose Option A or B)

#### Option A: Running Migration & Seeder (Laravel Native)
Run the migration command to generate the tables on your Oracle database:
```bash
php artisan migrate
```
After migrating, run the seeders to populate initial products and the admin account:
```bash
php artisan db:seed
```

#### Option B: Native Oracle SQL Scripts
Alternatively, you can run the raw Oracle SQL script located in the project directory using SQL*Plus, SQL Developer, or any PL/SQL database client:
* **Script Location**: `database/sql/create_tables.sql`
This script contains all table definitions, auto-increment sequences, database triggers for timestamps, and seed data.

### 5. Link Public Storage
Create a symbolic link from `public/storage` to `storage/app/public` so product images can be served properly:
```bash
php artisan storage:link
```

### 6. Run the Application
Start the Laravel local development server:
```bash
php artisan serve
```
Open your browser and visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

### 7. Access Admin Panel
To manage products and view client orders:
* **Admin Login URL**: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)
* **Default Credentials**:
  * **Email**: `admin@amarmart.com`
  * **Password**: `password`
