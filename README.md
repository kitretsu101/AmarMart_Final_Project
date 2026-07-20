# AmarMart — Mini E-Commerce Management System

Professional Laravel 12 mini e-commerce project for university Web Programming.

**Stack:** Laravel 12 · PHP 8.2+ · MySQL (XAMPP) · Bootstrap 5 · Laravel Breeze (auth) · Bootstrap Icons · Times New Roman

---

## Features

### Public Shop
- Navbar: Logo, Home, Products, Cart, Wishlist, About, Contact, Login, Live Search
- Product grid with Low Stock / Out of Stock badges
- Trending & Latest products
- Product details + Recently Viewed badge (cookie)
- Session shopping cart (add / remove / increase / decrease)
- AJAX cart + live search suggestions (Fetch API)
- Wishlist (session)
- Quick View modal
- Checkout with HTML5 Geolocation + Google Maps preview
- Auto invoice with print + location map
- Dark / Light theme (cookie, 7 days)
- Last search keyword cookie (7 days)
- Custom 404 & 403 pages

### Admin Panel (`/admin/login`)
- Breeze-style session authentication (Remember Me, Logout)
- Dashboard: products, orders, revenue, low stock, latest orders
- Product CRUD with image upload / preview / delete old image
- Order management (search, paginate, view invoice) — read only
- `AdminMiddleware` + protected route group

---

## Database (MySQL)

| Table | Notes |
|-------|--------|
| `users` | Admin only |
| `products` | `product_id` AUTO_INCREMENT |
| `orders` | Includes `latitude`, `longitude` |
| `order_items` | FK → orders, products |

Raw SQL (Oracle → MySQL converted): `database/sql/create_tables.sql`

---

## Setup (XAMPP + MySQL)

### 1. Start MySQL
Open **XAMPP Control Panel** → Start **Apache** + **MySQL**.

### 2. Install dependencies
```bash
composer install
```

### 3. Environment
`.env` is already configured for local MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=amarmart
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Create database & migrate
```bash
php setup_db.php
php artisan migrate --seed
php artisan storage:link
```

Or import `database/sql/create_tables.sql` in phpMyAdmin, then run seeders only:
```bash
php artisan db:seed
```

### 5. Run
```bash
php artisan serve
```
Visit: http://127.0.0.1:8000

### Admin Login
- URL: http://127.0.0.1:8000/admin/login
- Email: `admin@amarmart.com`
- Password: `password`

---

## Laravel Topics Covered

MVC · Controllers · Models · Blade · Eloquent · Relationships · Auth (Breeze) · Middleware · Protected Routes · Route Groups · Route Model Binding · Sessions · Cookies · Flash Messages · Form Validation · Form Requests · Custom Messages · Pagination · Search · AJAX · Fetch API · Geolocation · File Upload · Image Storage · Responsive Design · MySQL

---

## Project Structure (key paths)

```
app/Http/Controllers/     Public + Admin controllers
app/Http/Requests/        Form Request validation
app/Http/Middleware/      AdminMiddleware
app/Models/               Product, Order, OrderItem, User
database/migrations/      MySQL tables
database/sql/             Raw MySQL schema + sample data
public/js/app.js          AJAX (cart, search, wishlist, theme)
public/css/style.css      Bootstrap customization + dark theme
resources/views/          Blade templates
routes/web.php            Public + admin route groups
```
