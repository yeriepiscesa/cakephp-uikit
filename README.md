# Uikit Theme Plugin

Plugin ini adalah layer presentasi (theme) berbasis UIkit + Alpine.js + Vite untuk aplikasi CakePHP.

## Tujuan

- Menyediakan layout, asset, dan komponen UI reusable.
- Menjadi renderer menu dan halaman admin/public.
- Menjaga domain logic tetap di plugin domain (contoh: Cms), bukan di theme.

## Daftar Isi

1. [Instalasi](#instalasi)
2. [Konfigurasi](#konfigurasi)
3. [Asset Vite (npm)](#asset-vite-npm)
4. [Arsitektur Ringkas](#arsitektur-ringkas)
5. [Menu System dan Boundary](#menu-system-dan-boundary)
6. [Plugin Template Override](#plugin-template-override)
7. [Workflow Pengembangan](#workflow-pengembangan)

## Instalasi

### 1. Composer

Pastikan host application sudah memiliki `cakephp/plugin-installer`.

```bash
composer require yeriepiscesa/cakephp-uikit icings/menu josbeir/cakephp-vite
```

Atau via repository GitHub (sebelum terdaftar di Packagist):

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/yeriepiscesa/cakephp-uikit"
        }
    ],
    "require": {
        "yeriepiscesa/cakephp-uikit": "dev-main"
    }
}
```

### 2. Load plugin

Tambahkan ke `config/plugins.php`:

```php
'Uikit' => [],
'Icings/Menu' => [],
'CakeVite' => [],
```

Urutan disarankan: `Uikit` sebelum plugin domain yang memakai theme ini.

### 3. Migration

Plugin theme **tidak** memiliki migration database.

### 4. Build asset front-end

```bash
cd vendor/yeriepiscesa/cakephp-uikit   # atau plugins/Uikit saat development monorepo
npm install
npm run build
```

Hasil build ada di `webroot/build/`. Commit folder ini ke repo plugin jika ingin consumer tidak perlu menjalankan npm.

## Konfigurasi

### View class

Plugin Uikit mendaftarkan `Uikit.View.AppView` sebagai view class default untuk semua controller lewat event `Controller.initialize`. Host application **tidak perlu** mendefinisikan helper di `App\View\AppView`.

File `src/View/AppView.php` di host cukup alias tipis (opsional, untuk `@var` docblock dan fallback CakePHP):

```php
namespace App\View;

class AppView extends \Uikit\View\AppView
{
}
```

`Uikit\View\AppView` otomatis memuat:

- `Uikit.Paginator`, `Uikit.Sort`, `Uikit.ImageUpload`
- `CakeVite.Vite` (jika plugin CakeVite loaded)
- `Menu` helper host (jika `App\View\Helper\MenuHelper` ada)

Helper tambahan bisa didaftarkan via `config/app_view.php` plugin Uikit atau override di host:

```php
Configure::write('Uikit.viewHelpers', ['MyPlugin.MyHelper']);
```

### Vite / CakeVite

Plugin memuat `config/app_vite.php` otomatis saat bootstrap dengan config key `uikit`. Tidak perlu copy manual kecuali ingin override.

Opsional — paksa mode production di `config/app.php`:

```php
'ViteHelper' => [
    'mode' => env('VITE_MODE', 'production'), // 'development' saat npm run dev
],
```

### Theme pada controller plugin domain

Plugin domain (Cms, BusinessUsers, FileManager, dll.) memakai konfigurasi masing-masing, misalnya:

```php
'BusinessUsers' => ['theme' => 'Uikit'],
'FileManager'   => ['theme' => 'Uikit'],
```

Default theme name adalah `Uikit` bila key tidak diset.

### Plugin opsional

| Plugin | Keterangan |
|---|---|
| `cakedc/users` | Template override untuk login, register, reset password |
| `yeriepiscesa/cakephp-business-users` | Override template admin BusinessUsers (opsional) |

## Asset Vite (npm)

### Development mode

```bash
npm run dev
```

Default dev server:

- URL: `http://localhost:3000`
- Port: `3000`

Jalankan dev server **bersamaan** dengan server CakePHP. Akses aplikasi lewat URL CakePHP, bukan port Vite.

### Build production

```bash
npm run build
```

Output:

- `webroot/build/`
- Manifest: `webroot/build/.vite/manifest.json`

## Entry Points Vite

Didefinisikan di `vite.config.js`:

- `resources/js/uikit.js`
- `resources/js/uikit-admin.js`
- `resources/js/admin/form.js`
- `resources/js/admin/form-wysiwyg.js`
- `resources/js/admin/airport.js` (dipakai form Airport di plugin FlightBooking)

Catatan penting:

- `uikit-admin.js` harus dimuat lebih dulu pada layout admin sebelum script tambahan lain.
- Hal ini sudah ditangani di `templates/layout/admin.php`.

## Struktur Penting

```
plugins/Uikit/
├── config/
│   └── app_vite.php
├── resources/
│   ├── css/
│   └── js/
├── templates/
│   ├── layout/
│   ├── element/
│   ├── Admin/          ← template admin host (Dashboard, Users)
│   │   ├── Users/      ← admin CRUD users (via BusinessUsers\Controller\Admin\UsersController)
│   │   └── Dashboard/
│   └── plugin/         ← template override untuk plugin lain
│       └── CakeDC/
│           └── Users/
│               └── Users/ ← template public (login, register, dll)
├── vite.config.js
├── package.json
└── webroot/build/
```

## Menu System dan Boundary

- Theme Uikit hanya merender menu tree.
- Isi menu fitur (misalnya menu CMS) berasal dari adapter plugin domain melalui `Menu.adminAdapters`.
- Jangan letakkan definisi menu domain langsung di theme jika domain tersebut punya plugin sendiri.

Referensi integrasi:

- Renderer: `templates/element/Menu/admin.php`
- Helper registrasi adapter (app): `src/View/Helper/MenuHelper.php` (di aplikasi utama)

## Plugin Template Override

Theme Uikit menyediakan template override untuk plugin lain menggunakan konvensi CakePHP:

- Path: `templates/plugin/<PluginName>/...`
- CakePHP otomatis mencari template di sini sebelum fallback ke template bawaan plugin.

Plugin yang saat ini di-override:

| Plugin | Template path | Keterangan |
|---|---|---|
| CakeDC/Users (public) | `templates/plugin/CakeDC/Users/Users/` | Login, register, reset password, verify |

### Cms Plugin (override opsional)

Template admin CMS default berada di `plugins/Cms/templates/Admin/`. Uikit **tidak** menyimpan copy template CMS kecuali ada kebutuhan override khusus.

Jika theme Uikit perlu mengganti markup CMS (misalnya komponen UIkit berbeda dari default), buat override di:

- `templates/plugin/Cms/Admin/<Module>/`

CakePHP akan memakai override theme ini sebelum fallback ke template bawaan plugin Cms.

### BusinessUsers Plugin (override opsional)

Template admin BusinessUsers default berada di `plugins/BusinessUsers/templates/Admin/`. Uikit **tidak** menyimpan copy template BusinessUsers kecuali ada kebutuhan override khusus.

Jika theme Uikit perlu mengganti markup BusinessUsers, buat override di:

- `templates/plugin/BusinessUsers/Admin/<Module>/`

CakePHP akan memakai override theme ini sebelum fallback ke template bawaan plugin BusinessUsers.

### FlightBooking Plugin (override opsional)

Template admin FlightBooking default berada di `plugins/FlightBooking/templates/Admin/`. Uikit **tidak** menyimpan copy template Airlines, Airports, Cities, FlightRoutes, atau States.

Jika theme Uikit perlu mengganti markup FlightBooking, buat override di:

- `templates/plugin/FlightBooking/Admin/<Module>/`

### Admin Users (CakeDC/Users)

Template admin untuk manajemen users **tidak** menggunakan path `plugin/CakeDC/Users/` karena dihandle oleh `BusinessUsers\Controller\Admin\UsersController` (extends CakeDC) dengan prefix `Admin`:

- Template default: `plugins/BusinessUsers/templates/Admin/Users/`
- Override theme (opsional): `plugins/Uikit/templates/plugin/BusinessUsers/Admin/Users/`
- Controller: `plugins/BusinessUsers/src/Controller/Admin/UsersController.php`
- Route: generic admin fallback `/admin/users/*`
- Layout admin di-set otomatis oleh `beforeRender` di controller

> **Catatan**: Saat menambah modul baru ke plugin Cms, BusinessUsers, atau FlightBooking, buat template default di plugin domain masing-masing. Override di Uikit hanya jika markup perlu disesuaikan khusus untuk theme ini.

## Styling Sidebar/Menu

File utama styling menu admin:

- `resources/css/_menu.scss`
- `resources/css/_sidebar.scss`

Perilaku yang saat ini diharapkan:

- Parent menu tetap expand ketika submenu aktif.
- Submenu aktif berwarna lebih kontras dan lebih tebal.

Jika mengubah style, lakukan perubahan di source SCSS lalu build ulang asset.

## Workflow Pengembangan

1. Jalankan `npm run dev` di plugin Uikit saat mengerjakan UI.
2. Akses aplikasi dari server CakePHP (bukan port Vite).
3. Edit source di `resources/` dan template di `templates/`.
4. Build dengan `npm run build` saat siap release.

## Checklist Saat Menambah UI Baru

1. Tentukan apakah perubahan termasuk domain atau hanya presentasi.
2. Jika domain-specific (contoh menu CMS), pakai adapter plugin domain.
3. Jika presentasi umum, tambahkan di Uikit elements/components/layout.
4. Pastikan route/plugin context tidak di-hardcode salah (contoh hindari `plugin => false` untuk halaman plugin).
5. Build asset dan verifikasi halaman admin/public terkait.

## Guardrails Untuk Agentic AI

1. Perlakukan Uikit sebagai theme renderer, bukan tempat business logic.
2. Jangan memindahkan source template domain plugin ke Uikit kecuali diminta eksplisit.
3. Jangan ubah urutan load `uikit-admin.js` di layout admin.
4. Jika menyentuh menu admin, pastikan kompatibel dengan adapter system.
5. Setelah edit SCSS/JS, ingat perlu build untuk output production.
