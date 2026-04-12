# Warkop Bangboy - Website Pemesanan Online

Website pemesanan online untuk Warkop Bangboy, dibangun dengan Laravel 11.

## Fitur
- Landing page dengan menu per kategori
- Keranjang belanja (session-based)
- Checkout & pesanan tersimpan di database
- Dashboard admin dengan grafik penjualan
- CRUD produk & kategori
- Manajemen pesanan (update status)
- Role admin & kasir

## Cara Install

### 1. Prasyarat
- XAMPP (PHP 8.2+, MySQL) — download di https://www.apachefriends.org
- Composer — download di https://getcomposer.org
- Buka XAMPP, nyalakan Apache & MySQL

### 2. Buat Project Laravel
```bash
composer create-project laravel/laravel warkop-bangboy
cd warkop-bangboy
```

### 3. Copy File dari ZIP
Extract isi ZIP ini, lalu **timpa/replace** file-file berikut ke project Laravel:
- `app/Models/` → timpa semua file
- `app/Http/Controllers/` → timpa semua file
- `app/Http/Middleware/AdminMiddleware.php` → copy ke sini
- `database/migrations/` → HAPUS migration bawaan, replace dengan yang dari ZIP
- `database/seeders/DatabaseSeeder.php` → timpa
- `resources/views/` → timpa semua folder & file
- `routes/web.php` → timpa

### 4. Setup Database
1. Buka browser → http://localhost/phpmyadmin
2. Buat database baru: `warkop_bangboy`
3. Edit file `.env` di root project:
```
DB_DATABASE=warkop_bangboy
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migration & Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 6. Jalankan Server
```bash
php artisan serve
```
Buka browser → http://localhost:8000

## Login Admin
- **Email:** admin@warkopbangboy.com
- **Password:** admin123

## Login Kasir
- **Email:** kasir@warkopbangboy.com
- **Password:** kasir123

## Struktur Database
- `users` — data admin/kasir (role: admin/kasir)
- `categories` — kategori menu (Kopi, Non-Kopi, Makanan, Dessert)
- `products` — daftar menu (relasi ke categories)
- `orders` — data pesanan customer
- `order_items` — detail item per pesanan (relasi ke orders & products)
