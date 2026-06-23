# Local Development Jagoskill

Panduan ini untuk menjalankan aplikasi di laptop tanpa menyentuh database production `jagoskill.com`.

## Prinsip Utama

- Gunakan database lokal untuk development.
- Jangan gunakan kredensial database hosting di laptop untuk coding harian.
- Jangan commit `.env`, dump `.sql`, `vendor`, `node_modules`, cache, log, atau file upload.
- Push ke GitHub hanya untuk source code dan file konfigurasi contoh.

## Setup Environment

1. Pastikan laptop memiliki PHP 8.1+, Composer, Node.js, NPM, dan MySQL/MariaDB.
2. Buat database lokal, contoh:

```sql
CREATE DATABASE jagoskill_local CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. Import database export:

```powershell
cmd /c "mysql -u root -p jagoskill_local < u5266512_dbjagoskill.sql"
```

4. Buat file `.env` lokal dari template:

```powershell
Copy-Item .env.local.example .env
```

5. Sesuaikan nilai database lokal di `.env`:

```env
DB_DATABASE=jagoskill_local
DB_USERNAME=root
DB_PASSWORD=
```

6. Install dependency dan jalankan aplikasi:

```powershell
composer install
npm install
php artisan key:generate
php artisan storage:link
php artisan serve
```

Untuk asset frontend:

```powershell
npm run dev
```

## GitHub

Remote lokal sudah diarahkan ke:

```text
https://github.com/imranalwi001-creator/jagoskill.com.git
```

Sebelum push pertama, cek dulu:

```powershell
git status
git add .
git status
```

Pastikan `.env` dan `u5266512_dbjagoskill.sql` tidak masuk daftar commit.

## Setup Dengan Docker

Gunakan opsi ini jika ingin menjalankan Laravel tanpa memasang PHP, Composer, dan MySQL langsung di Windows.

1. Salin template Docker ke `.env`:

```powershell
Copy-Item .env.docker.example .env
```

Jika `.env` lama masih berisi konfigurasi hosting, backup dulu:

```powershell
Copy-Item .env .env.production.backup
Copy-Item .env.docker.example .env
```

2. Jalankan container:

```powershell
docker compose up -d
```

3. Install dependency Laravel:

```powershell
docker compose exec app composer install
```

4. Generate key lokal:

```powershell
docker compose exec app php artisan key:generate
```

5. Import database export ke MySQL container:

```powershell
Get-Content .\u5266512_dbjagoskill.sql | docker compose exec -T mysql mysql -u root -proot jagoskill_local
```

6. Buat storage link:

```powershell
docker compose exec app php artisan storage:link
```

7. Bersihkan cache Laravel:

```powershell
docker compose exec app php artisan optimize:clear
```

Catatan: container Docker mematikan Xdebug secara default karena aplikasi ini memakai ionCube encoded file untuk PHP 8.1. Xdebug dapat menyebabkan PHP-FPM crash pada beberapa halaman.

8. Buat manifest Iconsax lokal:

```powershell
docker compose exec app php tools/build-iconsax-manifest.php
docker compose exec app php artisan view:clear
```

Catatan: pada Docker Windows, PHP kadang tidak membaca semua file SVG Iconsax dari bind mount. Skrip ini memakai `find` Linux di dalam container agar semua komponen seperti `<x-iconsax-bol-star-1>` terdaftar.

9. Buka aplikasi:

```text
http://localhost:8000
```

Docker lokal sudah menyamarkan host `localhost` sebagai `jagoskill.com` di dalam Laravel melalui `JAGOSKILL_LOCAL_LICENSE_HOST`. Jadi browser tetap bisa memakai `localhost:8000`, sementara license checker membaca domain yang benar.

Docker lokal juga memakai page cache ringan untuk halaman publik seperti home, classes, forums, instructors, organizations, products, dan store. First load tetap membangun halaman, tetapi akses berikutnya jauh lebih cepat. Jika tampilan belum berubah setelah edit konten/view, bersihkan cache lokal:

```powershell
Remove-Item -Recurse -Force .\storage\framework\cache\local-pages
```

Jika ingin menguji manual sebagai domain aktif tanpa host spoof, request harus memakai host `jagoskill.com`, misalnya lewat hosts file Windows:

```text
127.0.0.1 jagoskill.com
```

Setelah itu buka:

```text
http://jagoskill.com:8000/classes?sort=newest
```

Hapus atau comment baris hosts tersebut jika ingin kembali mengakses website production `jagoskill.com` dari browser laptop.

phpMyAdmin tersedia di:

```text
http://localhost:8088
```

Login phpMyAdmin:

```text
Server: mysql
Username: root
Password: root
```

Untuk menghentikan container:

```powershell
docker compose down
```

Untuk menghapus database container dan mulai ulang dari nol:

```powershell
docker compose down -v
```
