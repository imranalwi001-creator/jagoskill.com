---
name: laravel-dashboard-speed-optimizer
description: Enterprise standard for ultra-fast Laravel dashboard navigation and sub-second menu transitions. Specializes in instant page prefetching, Gate::before permission fast-paths, sidebar beep query caching, OpCache/realpath buffer tuning for Docker, N+1 query elimination, and SPA-like Blade ergonomics.
---

# Laravel Dashboard Speed & High-Performance Navigation Optimizer

Panduan rekayasa dan standar arsitektur tingkat lanjut untuk mengoptimalkan kecepatan akses dan navigasi menu pada dashboard admin & panel berbasis **Laravel (PHP 8.x - 12.x)**. Menjamin navigasi antar menu instan (< 200ms) dan mengeliminasi latensi CPU, database, maupun I/O filesystem.

---

## 1. Navigasi Cepat & Prefetching Sisi Frontend (Instant Navigation)

Untuk membuat transisi antar menu terasa instan seperti SPA (Single Page Application) tanpa merombak Blade menjadi Vue/React penuh:

### A. Hover/Touch Pre-fetching (`instant.page`)
Muat script ringan (1KB) `instant.page` pada layout dashboard admin (`admin/layout.blade.php`):
```html
<script src="//instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiCGnKDdQRVQztR7oQCrDvi01PvnQA210w2WXGuAzVCqqE2442Yk86pu39"></script>
```
- **Cara Kerja**: Ketika kursor mouse mengambang di atas link menu sidebar selama > 65ms (indikasi 90% user akan klik), browser secara diam-diam mem-*prefetch* halaman HTML di latar belakang.
- **Dampak**: Waktu tunggu saat link diklik berkurang hingga 80-100%, halaman langsung muncul secara instan.

### B. Link Speculation Rules API (Native Browser Pre-rendering)
Tambahkan tag modern Speculation Rules di `<head>`:
```html
<script type="speculationrules">
{
  "prerender": [
    {
      "source": "list",
      "urls": ["/admin", "/admin/webinars", "/admin/users", "/admin/financial/subscribes"]
    }
  ]
}
</script>
```

---

## 2. Fast-Path O(1) Autorisasi & Gate Permission

Masalah umum dashboard Laravel adalah sidebar yang memanggil ratusan `@can(...)` untuk ratusan *section* yang membebani CPU dan memicu query berulang.

### A. Super-Admin Fast Path (`Gate::before`)
Wajib tambahkan bypass awal di `app/Providers/AuthServiceProvider.php`:
```php
Gate::before(function ($user, $ability) {
    if ($user && $user->isAdmin()) {
        return true; // Bypass evaluasi ratusan closures RBAC secara instan O(1)
    }
});
```

### B. In-Memory Memoization untuk Non-Admin
Untuk peran staff/instructor, muat seluruh permission dalam satu array memori (1 query tunggal), hindari query berulang di setiap pemanggilan gate:
```php
if (!isset($this->permissionsCache)) {
    $this->permissionsCache = $this->role->permissions()
        ->pluck('name')
        ->flip()
        ->toArray();
}
return isset($this->permissionsCache[$sectionName]);
```

---

## 3. Sidebar Query & Badge Counters Caching (Anti N-Query)

Banyak template dashboard (seperti Rocket LMS, AdminLTE, Stisla) menjalankan belasan query `COUNT(*)` di setiap menu untuk menghitung badge merah/pending items:

### A. Pengelompokan & Durasi Cache Masif
Jangan pernah mengeksekusi query `COUNT(*)` per request di `AdminAuthenticate` middleware atau view composer:
```php
public function getSidebarBeeps(): array
{
    // Simpan di cache selama 5 - 15 menit
    return Cache::remember('admin.sidebar_beeps', now()->addMinutes(10), function (): array {
        return [
            'courses'         => Webinar::where('type', 'course')->where('status', 'pending')->exists(),
            'bundles'         => Bundle::where('status', 'pending')->exists(),
            'reviews'         => WebinarReview::where('status', 'pending')->exists(),
            'comments'        => Comment::where('status', 'pending')->exists(),
            'offlinePayments' => OfflinePayment::where('status', 'pending')->exists(),
        ];
    });
}
```
*Gunakan `exists()` ketimbang `count() > 0` karena `exists()` berhenti pada baris pertama (jauh lebih cepat).*

### B. Event-Driven Invalidation
Hapus cache beeps hanya saat ada aksi relevan (misal event `WebinarCreated`, `CommentPosted`):
```php
Cache::forget('admin.sidebar_beeps');
```

---

## 4. Konfigurasi Produksi & Memory Buffer (Khusus Docker & Windows)

Pada container Docker yang menggunakan *volume mount* (WSL2/VirtioFS), latensi baca file per request sangat tinggi. Wajib terapkan konfigurasi berikut di `docker/php/local.ini` atau `php.ini`:

```ini
; OpCache Ekstrem untuk Eliminasi I/O Disk
opcache.enable=1
opcache.enable_cli=1
opcache.memory_consumption=512
opcache.interned_strings_buffer=64
opcache.max_accelerated_files=60000
opcache.validate_timestamps=1
opcache.revalidate_freq=120
opcache.save_comments=1
opcache.jit=0

; Realpath Buffer untuk Mengatasi WSL2 Filesystem Bridge
realpath_cache_size=32M
realpath_cache_ttl=3600
```

---

## 5. Standar Wajib Deployment & Caching Laravel

Setiap kali melakukan deployment atau setelah mengubah file konfigurasi, wajib jalankan kompilasi statis:

```bash
# 1. Satukan seluruh konfigurasi ke single-file RAM
php artisan config:cache

# 2. Kompilasi 900+ rute ke single-file array memori
php artisan route:cache

# 3. Pra-kompilasi seluruh template Blade ke PHP murni
php artisan view:cache

# 4. Optimasi Autoloader Composer (Authoritative Classmap)
composer dump-autoload -o --no-dev
```

---

## 6. Audit & Deteksi Bottleneck Mandiri (Checklist)

Saat mendapati menu tertentu lambat:
1. **Periksa N+1 Query**: Pasang `Laravel Debugbar` atau periksa `DB::getQueryLog()`. Pastikan controller menggunakan `with(['relation1', 'relation2'])`.
2. **Periksa Payload SQL**: Pastikan query menggunakan `select(['id', 'title', 'status', 'created_at'])` daripada `select *` pada tabel bertipe TEXT/JSON.
3. **Cek DNS / External HTTP**: Pastikan tidak ada pemanggilan cURL eksternal sinkron (misal GeoIP, Google Fonts, API Lisensi, atau currency exchange) di dalam alur request menu.
