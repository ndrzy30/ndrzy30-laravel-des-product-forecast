# IMPLEMENTASI DOUBLE EXPONENTIAL SMOOTHING UNTUK PREDIKSI PERMINTAAN OBAT DI APOTIK 🏥

[![Laravel](https://img.shields.io/badge/Laravel-10.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.0-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)

## 📝 Deskripsi

Sistem ini merupakan implementasi metode Double Exponential Smoothing untuk memprediksi permintaan obat di apotik. Dibangun menggunakan framework Laravel, sistem ini membantu apotik dalam mengoptimalkan stok obat berdasarkan data historis penjualan.

## ✨ Fitur

- ✅ Authentication dan Authorization
- 📦 Manajemen Data Obat
- 📊 Pencatatan Penjualan Obat
- 🔮 Prediksi Permintaan menggunakan Double Exponential Smoothing
- 📈 Laporan Hasil Prediksi
- 📱 Dashboard Informatif

## 🛠️ Teknologi

- Laravel 10
- PHP 8.1
- MySQL
- Bootstrap 5
- JavaScript

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM

## 🚀 Instalasi

1. Clone repository
```bash
git clone https://github.com/zaiandra/des_prediksi_permintaan_obat.git
```

2. Install dependencies
```bash
composer install
npm install
```

3. Salin file .env.example ke .env
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Setup database di file .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_des_obat
DB_USERNAME=root
DB_PASSWORD=
```

6. Jalankan migrasi dan seeder
```bash
php artisan migrate
php artisan db:seed
```

7. Jalankan server Laravel
```bash
php artisan serve
```

## 👨‍💻 Penggunaan

Setelah instalasi berhasil, Anda dapat:
1. Akses sistem melalui `http://localhost:8000`
2. Login menggunakan credentials yang telah disediakan di seeder
3. Mulai mengelola data dan melakukan prediksi

## 📊 Metode Double Exponential Smoothing

Sistem ini menggunakan metode Double Exponential Smoothing untuk memprediksi permintaan obat dengan mempertimbangkan:
- Data historis penjualan
- Tren permintaan
- Pola musiman

## 🤝 Kontribusi

Kontribusi selalu welcome! Untuk berkontribusi:
1. Fork repository
2. Buat branch baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

## 📫 Kontak

Project Link: [https://github.com/zaiandra/des_prediksi_permintaan_obat](https://github.com/zaiandra/des_prediksi_permintaan_obat)

[![Instagram](https://img.shields.io/badge/Instagram-%23E4405F.svg?&style=for-the-badge&logo=instagram&logoColor=white)](https://instagram.com/ndrzyy_99)
