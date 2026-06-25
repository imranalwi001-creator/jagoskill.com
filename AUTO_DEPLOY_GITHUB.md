# Auto Deploy GitHub ke Hosting

Workflow `.github/workflows/deploy.yml` akan berjalan setiap ada push ke branch `main`.

## Syarat di Hosting

- Hosting punya akses SSH.
- Folder aplikasi di hosting adalah git repository yang remote-nya mengarah ke `imranalwi001-creator/jagoskill.com`.
- Branch production memakai `main`.
- File `.env` production tetap berada di hosting dan tidak ikut Git.
- `storage` dan `bootstrap/cache` writable oleh user hosting.

## GitHub Secrets Yang Wajib Dibuat

Buka GitHub repo:

`Settings -> Secrets and variables -> Actions -> New repository secret`

Buat secret berikut:

- `HOSTING_SSH_HOST`: hostname/IP SSH hosting.
- `HOSTING_SSH_PORT`: port SSH, biasanya `22`.
- `HOSTING_SSH_USER`: username SSH hosting.
- `HOSTING_SSH_KEY`: private key SSH untuk login ke hosting.
- `HOSTING_DEPLOY_PATH`: path folder aplikasi Laravel di hosting.

Contoh `HOSTING_DEPLOY_PATH`:

```text
/home/username/jagoskill.com
```

atau jika aplikasi berada di public_html:

```text
/home/username/public_html
```

## Setup Pertama Di Hosting

Jalankan sekali lewat SSH hosting:

```bash
cd /path/ke/folder/aplikasi
git remote -v
git checkout main
git pull origin main
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan optimize:clear
php artisan route:cache
php artisan config:cache
```

Pastikan `.env` production berisi:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://jagoskill.com
```

## Catatan Penting

Workflow ini tidak menjalankan migration otomatis. Untuk perubahan database, backup database dulu lalu jalankan migration manual di hosting:

```bash
php artisan migrate --force
```

