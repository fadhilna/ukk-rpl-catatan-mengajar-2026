# 🏫 Aplikasi Catatan Mengajar Guru - UKK RPL 2026

## 📱 Live Demo
🔗 [https://fadhilna.github.io/ukk-rpl-catatan-mengajar-2026] *(jika ada hosting)*  
👨‍💻 **Username:** `admin` | **Password:** `admin123`  
👨‍🏫 **Username:** `guru` | **Password:** `guru123`

## 🎯 Deskripsi Proyek
Aplikasi web untuk mencatat kegiatan mengajar guru dengan sistem role-based (Admin & Guru). Dibuat untuk UKK RPL 2026.

## 🚀 Fitur Utama
### 👨‍💼 **Admin Panel**
- ✅ Dashboard dengan statistik
- ✅ Manajemen Data Guru
- ✅ Manajemen Data Kelas  
- ✅ Manajemen Data Siswa
- ✅ Manajemen Jadwal Mengajar
- ✅ Log Aktivitas Sistem

### 👨‍🏫 **Guru Panel**
- ✅ Dashboard jadwal harian
- ✅ Input Kegiatan Mengajar
- ✅ History Kegiatan
- ✅ Lihat Semua Jadwal
- ✅ Profil Guru

## 🛠 Teknologi Stack
| Layer | Technology |
|-------|------------|
| **Backend** | Laravel 10, PHP 8, MySQL |
| **Frontend** | Bootstrap 5.3, Blade Templates |
| **Auth** | Session-based Authentication |
| **Database** | MySQL, DB::table() Queries |
| **Deployment** | Local Server / XAMPP |

## 📸 Screenshot
| Dashboard Admin | Input Kegiatan Guru |
|----------------|---------------------|
| ![Admin Dashboard](screenshots/admin-dashboard.png) | ![Guru Input](screenshots/guru-input.png) |

## 📦 Instalasi & Setup
```bash
# 1. Clone repository
git clone https://github.com/fadhilna/ukk-rpl-catatan-mengajar-2026.git

# 2. Masuk ke folder project
cd ukk-rpl-catatan-mengajar-2026

# 3. Install dependencies
composer install

# 4. Copy environment file
cp .env.example .env

# 5. Generate key
php artisan key:generate

# 6. Setup database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=catatan_mengajar
DB_USERNAME=root
DB_PASSWORD=

# 7. Migrate database
php artisan migrate

# 8. Seed data contoh (atau akses /seed-data di browser)
php artisan db:seed

# 9. Jalankan server
php artisan serve
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
