# AmarMart

Mini E-Commerce Management System built with **Laravel 12**, **Oracle Database 11g XE**, **yajra/laravel-oci8**, and **Bootstrap 5**.

## Requirements

- PHP 8.2+ with `oci8` and `pdo_oci`
- Composer
- Oracle XE (service `XE`) + Instant Client
- Node.js optional (UI uses Bootstrap CDN)

## Quick start

```powershell
cd amarmart
composer install
copy .env.example .env
php artisan key:generate
```

### Oracle schema + PL/SQL

```powershell
sqlplus amarmart/AmarMart123@localhost:1521/XE @database/oracle/01_schema.sql
sqlplus amarmart/AmarMart123@localhost:1521/XE @database/oracle/02_plsql.sql
```

### Seed + run

```powershell
php artisan storage:link
php artisan db:seed
php artisan serve
```

Open:

- Shop: http://127.0.0.1:8000
- Admin: http://127.0.0.1:8000/admin/login

Admin login:

- Email: `admin@amarmart.test`
- Password: `password`

## Oracle PL/SQL features

| Object | Purpose |
|--------|---------|
| `trg_orders_invoice` | Auto invoice numbers (`INV-000001`) |
| `trg_reduce_stock` | Reduce product stock on order item insert |
| `fn_total_revenue` | Revenue calculation |
| `sp_dashboard_stats` | Admin dashboard statistics |

## Main features

- Public shop, search, session cart, checkout, printable invoice
- Admin login, dashboard, product CRUD, image upload, order management
