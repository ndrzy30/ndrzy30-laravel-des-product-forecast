# IMPLEMENTASI DOUBLE EXPONENTIAL SMOOTHING UNTUK PREDIKSI PERMINTAAN OBAT DI APOTIK

## Deskripsi
Sistem ini merupakan implementasi metode Double Exponential Smoothing untuk memprediksi permintaan obat di apotik. Dibangun menggunakan framework Laravel, sistem ini membantu apotik dalam mengoptimalkan stok obat berdasarkan data historis penjualan.

## Fitur
- Authentication dan Authorization
- Manajemen Data Obat
- Pencatatan Penjualan Obat
- Prediksi Permintaan menggunakan Double Exponential Smoothing
- Laporan Hasil Prediksi
- Dashboard Informatif

## Teknologi
- Laravel 10
- PHP 8.1
- MySQL
- Bootstrap 5
- JavaScript

## Persyaratan Sistem
- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM

## Instalasi
1. Clone repository


2. Install dependencies
composer install
npm install

3. Salin file .env.example ke .env
cp .env.example .env

4. Generate application key
php artisan key:generate

5. Setup database di file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_des_obat
DB_USERNAME=root
DB_PASSWORD=

6. Jalankan migrasi dan seeder
php artisan migrate
php artisan db:seed

7. Jalankan server Laravel
php artisan serve
