# Deployment Checklist

Checklist ini untuk deploy JagoSkill/Rocket LMS berbasis Laravel 9 ke hosting production.

## 1. Pre-Deploy Lokal

Jalankan dari root project:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run prod
php artisan optimize:clear
php artisan route:cache
php artisan config:cache
```

Catatan:
- `npm audit fix` jangan dijalankan otomatis sebelum deploy stabil karena dapat menaikkan versi dependency dan mengubah output asset.
- `public/check.php`, `public/symlink.php`, `.env*`, `vendor`, `node_modules`, file SQL, dan cache runtime tidak perlu ikut commit/upload kecuali hosting memang membutuhkan proses manual tertentu.

## 2. File Yang Wajib Ada Di Server

Upload atau pull semua source aplikasi, termasuk:

- `app`
- `bootstrap`
- `config`
- `database`
- `lang`
- `public`
- `resources`
- `routes`
- `storage` dengan struktur foldernya
- `composer.json`
- `composer.lock`
- `artisan`
- `vendor`, jika hosting tidak bisa menjalankan Composer

Jangan upload file lokal sensitif/debug:

- `.env` lokal laptop
- `node_modules`
- `storage/logs/*.log`
- `storage/framework/cache/*`
- `storage/framework/sessions/*`
- `storage/framework/views/*`
- `public/check.php`
- `public/symlink.php`

## 3. Konfigurasi `.env` Production

Minimal:

```env
APP_NAME=Jagoskill
APP_ENV=production
APP_DEBUG=false
APP_URL=https://jagoskill.com
LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD="..."

QUEUE_CONNECTION=sync
SESSION_DRIVER=file
CACHE_DRIVER=file
```

Jika server production punya Redis, lebih baik:

```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

Pastikan `APP_KEY` dan `JWT_SECRET` sudah terisi. Jangan gunakan `APP_DEBUG=true` di production.

## 4. Permission Server

Laravel harus bisa menulis ke:

```bash
storage
bootstrap/cache
```

Contoh Linux:

```bash
chmod -R 775 storage bootstrap/cache
```

Jika user web server berbeda, sesuaikan ownership:

```bash
chown -R www-data:www-data storage bootstrap/cache
```

Untuk shared hosting/cPanel, sesuaikan dengan user hosting dan hindari permission `777` kecuali benar-benar tidak ada opsi lain.

## 5. Migrasi Database

Backup database sebelum deploy.

```bash
php artisan down
php artisan migrate --force
php artisan optimize:clear
php artisan route:cache
php artisan config:cache
php artisan up
```

Migration tambahan performa yang perlu masuk:

```bash
php artisan migrate --path=database/migrations/2026_06_24_020000_add_performance_indexes_to_user_login_histories.php --force
```

## 6. Web Root

Document root domain harus mengarah ke folder:

```text
public
```

Jika hosting memaksa document root ke `public_html/jagoskill.com`, isi folder tersebut harus berisi isi folder `public`, dan path `index.php` harus tetap bisa mengarah ke folder aplikasi utama.

## 7. Cache Production

Setelah deploy:

```bash
php artisan optimize:clear
php artisan route:cache
php artisan config:cache
```

Jangan jalankan `view:cache` dulu untuk project ini sebelum semua halaman admin/user diverifikasi, karena beberapa view/theme dinamis bisa lebih aman dibiarkan compile-on-demand.

## 8. Verifikasi Setelah Deploy

Cek URL berikut:

- `/`
- `/login`
- `/admin/login`
- `/classes`
- `/panel` setelah login user
- `/admin` setelah login admin

Cek juga:

- upload file/media
- email SMTP
- payment callback
- halaman course detail
- fitur checkout
- log error di `storage/logs`

## 9. Rollback Cepat

Sebelum deploy simpan:

- backup database
- backup `.env`
- release folder sebelumnya atau commit/tag terakhir

Rollback:

```bash
php artisan down
git checkout <commit-sebelumnya>
composer install --no-dev --optimize-autoloader
php artisan optimize:clear
php artisan route:cache
php artisan config:cache
php artisan up
```

Jika migration sudah mengubah database, restore backup database bila rollback kode tidak cukup.

