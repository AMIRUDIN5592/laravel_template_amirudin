# Laravel Admin Starter

Starter kit aplikasi admin berbasis **Laravel 13**, **AdminLTE 4 (Bootstrap 5)**, dan **Breeze** untuk autentikasi. Sudah termasuk role-based access control (`admin` & `superadmin`), contoh CRUD, dan generator CRUD siap pakai.

## Fitur

- Laravel 13 + PHP 8.3
- Autentikasi Breeze lengkap: login, register, lupa/reset password, verifikasi email, profil
- RBAC: role & permission (Gates) + middleware `can:` / `role:`
- Layout AdminLTE 4 (sidebar responsif, dark theme)
- Contoh CRUD nyata ke database: **Users** (dengan role) dan **Product**
- Generator CRUD: `php artisan make:crud`
- Seeder akun admin & superadmin
- Test suite PHPUnit
- Kualitas kode: Pint (code style) + PHPStan/Larastan (static analysis)
- CI: GitHub Actions (Pint, PHPStan, PHPUnit)

## Kebutuhan

- PHP >= 8.3
- Composer
- (opsional) Node.js + npm untuk build asset

## Instalasi

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Database default di `.env.example` adalah **SQLite** (`database/database.sqlite`), jadi tidak perlu database server untuk langsung mencoba. Untuk MySQL, sesuaikan variabel `DB_*` di `.env`.

Jalankan server:

```bash
php artisan serve
```

Buka `http://localhost:8000`.

## Kredensial Default

| Role       | Email                  | Password |
| ---------- | ---------------------- | -------- |
| Admin      | admin@example.com      | password |
| Superadmin | superadmin@example.com | password |

> Ganti kredensial ini sebelum dipakai di production. Nilainya bisa diubah lewat variabel `SEED_*` di `.env`.

## Struktur Folder

- `app/Http/Controllers` — controller, termasuk `*Controller` hasil generator
- `app/Http/Middleware/EnsureUserHasRole.php` — middleware pengecekan role
- `app/Models` — model Eloquent (termasuk `User` dengan helper role)
- `resources/views/layouts/admin.blade.php` — layout utama AdminLTE
- `resources/views/{resource}` — view CRUD per resource
- `config/admin.php` — konfigurasi menu sidebar
- `routes/web.php` — route aplikasi

## Menambah CRUD Baru

Gunakan generator:

```bash
php artisan make:crud Category
```

Perintah ini membuat **model**, **migrasi**, **controller**, dan **view** CRUD (index/create/edit) untuk `Category`, lalu menampilkan snippet route yang perlu disalin ke `routes/web.php`. Setelah itu:

```bash
php artisan migrate
```

Bila ingin menu muncul di sidebar, tambahkan entri di `config/admin.php`.

> Resource `Product` dan `Users` bisa dijadikan acuan pola CRUD lengkap.

## Role & Permission

Role disimpan di kolom `users.role` (`admin` / `superadmin`, atau `NULL` untuk user biasa).

Pemetaan role → permission ada di `User::ROLE_PERMISSIONS`:

| Role       | Permission                          |
| ---------- | ----------------------------------- |
| superadmin | `*` (semua permission)              |
| admin      | `manage-products`                   |
| user biasa | —                                   |

Permission didefinisikan di `app/Support/Permissions.php`. Untuk menambah permission baru: tambah konstanta di `Permissions`, lalu daftarkan ke role yang sesuai di `User::ROLE_PERMISSIONS`.

Helper di model `User`:

- `hasRole('admin')`
- `hasAnyRole('admin', 'superadmin')`
- `hasPermission('manage-products')`
- `isAdmin()`
- `isSuperAdmin()`

Membatasi route berdasarkan permission:

```php
Route::middleware('can:manage-users')->group(function () {
    // hanya role yang punya permission manage-users
});
```

Di Blade, tampilkan elemen berdasarkan permission:

```blade
@can('manage-users')
    {{-- hanya untuk yang punya permission --}}
@endcan
```

Role-level check juga tetap tersedia via middleware `role:...` (mis. `role:superadmin`).

## Testing & Kualitas Kode

```bash
php artisan test                 # menjalankan test
composer lint                    # Pint --test (cek gaya kode)
composer format                  # Pint (perbaiki gaya kode)
composer analyse                 # PHPStan/Larastan (analisis statis)
```

Konfigurasi PHPStan ada di `phpstan.neon` dan gaya kode di `pint.json`. CI (GitHub Actions) menjalankan Pint, PHPStan, dan PHPUnit secara otomatis — lihat `.github/workflows/ci.yml`.

## Lisensi

MIT
