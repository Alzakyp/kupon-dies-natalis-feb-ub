# Kupon Dies Natalis FEB UB

Sistem pembuat dan penukar kupon fisik satu kali pakai berbasis Laravel Blade dan MySQL untuk Dies Natalis FEB UB ke-65 Lustrum XIII.

## Persyaratan
- PHP 8.2+ (termasuk ekstensi `gd`, `zip`, `pdo_mysql`, `openssl`)
- Composer
- MySQL 8.0+

## Instalasi
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

## Pengaturan Produksi
- Konfigurasi `APP_URL=https://<domain>`
- Admin awal dibuat otomatis oleh seeder jika `ADMIN_EMAIL` dan `ADMIN_PASSWORD` diset pada `.env`.
- Password default penukaran awal adalah `febub65` (disimpan ter-hash di tabel `settings`) dan dapat diubah lewat antarmuka `/admin/settings`.
- Ekspor QR PNG dan CSV disediakan langsung dalam streaming ZIP tanpa menyimpan file ekspor publik di disk server.
