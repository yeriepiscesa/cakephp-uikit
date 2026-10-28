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
        "yeriepiscesa/cakephp-uikit": "dev-master"
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

Jalankan dari root aplikasi CakePHP setelah `composer install`:

```bash
cp vendor/yeriepiscesa/cakephp-uikit/config/uikit_assets.json config/uikit_assets.json
node vendor/yeriepiscesa/cakephp-uikit/bin/uikit-assets.mjs install
node vendor/yeriepiscesa/cakephp-uikit/bin/uikit-assets.mjs build
```

File konfigurasi host opsional; tanpa disalin, nilai default yang sama tetap dipakai. `install` menyalin package, lockfile, konfigurasi Vite, dan source aset dari plugin ke `resources/cakephp-uikit/`, lalu menjalankan `npm ci` di sana. `build` menyalin ulang source plugin dan membuat `webroot/cakephp-uikit/.vite/manifest.json` serta asetnya. Dependency npm dan hasil build tidak ditulis ke `vendor/`. Jalankan `install` lagi jika lockfile plugin berubah setelah pembaruan Composer.

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
- `Uikit.Menu` (tersedia sebagai `$this->Menu` jika plugin Icings/Menu aktif)

Helper tambahan bisa didaftarkan via `config/app_view.php` plugin Uikit atau override di host:

```php
Configure::write('Uikit.viewHelpers', ['MyPlugin.MyHelper']);
```

### Vite / CakeVite

Plugin memuat `config/app_vite.php` secara otomatis dengan config key `uikit`. Salin `config/uikit_assets.json` ke folder `config/` host untuk mengubah path:

```json
{
  "workDirectory": "resources/cakephp-uikit",
  "buildDirectory": "webroot/cakephp-uikit",
  "devServerUrl": "http://localhost:3000"
}
```

Kedua direktori relatif terhadap root proyek. `workDirectory` harus di bawah `resources/`, sedangkan `buildDirectory` harus di bawah `webroot/`. CakeVite membaca manifest dari direktori output host yang sama dan membuat URL aset tanpa prefix plugin. Abaikan kedua direktori hasil di Git host.

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
| `cakedc/users` | Template auth otomatis; contoh admin dan member dapat disalin ke host |
| `yeriepiscesa/cakephp-business-users` | Contoh template admin dan dukungan foto profil |

## Asset Vite (npm)

### Development mode

Dari root aplikasi CakePHP, setelah langkah `install`:

```bash
node vendor/yeriepiscesa/cakephp-uikit/bin/uikit-assets.mjs dev
```

Dev server menggunakan `devServerUrl` (default `http://localhost:3000`). Akses halaman lewat server CakePHP. Source yang dilayani Vite adalah salinan di `resources/cakephp-uikit/resources/`; jalankan kembali perintah `dev` atau `prepare` untuk menyegarkan salinan setelah mengubah source plugin.

### Build production

```bash
node vendor/yeriepiscesa/cakephp-uikit/bin/uikit-assets.mjs build
```

Output default adalah `webroot/cakephp-uikit/`, dengan manifest di `webroot/cakephp-uikit/.vite/manifest.json`. Direktori lama `vendor/yeriepiscesa/cakephp-uikit/webroot/build/` tidak dipakai lagi.

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
│   ├── app_vite.php
│   └── uikit_assets.json
├── resources/
│   ├── css/
│   └── js/
├── templates/
│   ├── layout/
│   ├── element/
│   ├── Admin/          ← template admin host (Dashboard, Users)
│   │   ├── Users/      ← admin CRUD users (via BusinessUsers\Controller\Admin\UsersController)
│   │   └── Dashboard/
│   └── examples/users/ ← contoh template auth, admin, dan member untuk disalin ke host
├── bin/uikit-assets.mjs
├── vite.config.js
└── package.json
```

## Menu System dan Boundary

- Theme Uikit hanya merender menu tree.
- Isi menu fitur (misalnya menu CMS) berasal dari adapter plugin domain melalui `Menu.adminAdapters`.
- Jangan letakkan definisi menu domain langsung di theme jika domain tersebut punya plugin sendiri.

Referensi integrasi:

- Renderer: `templates/element/Menu/admin.php`
- Helper bersama: `src/View/Helper/MenuHelper.php` di plugin Uikit

Plugin lain atau view class kustom dapat memuat helper dengan `$this->loadHelper('Uikit.Menu')`. Helper membangun menu admin dari kelas yang terdaftar dalam `Menu.adminAdapters`. Adapter mengembalikan item melalui `getAdminMenuItems()`; metadata `auth.controller` diperiksa melalui policy akses request, dan metadata `auth.roles`/`auth.superuser` diperiksa terhadap identity. Untuk metadata `auth.permission`, adapter harus menyediakan `isMenuItemAllowed(ServerRequest $request, string $permission): bool`; tanpa pemeriksa tersebut item tidak ditampilkan. Accounting menggunakan pemeriksaan tenant dan permission miliknya sendiri. Menu tidak menggantikan otorisasi pada controller.

Untuk menu publik, `$this->Menu->mainMenu()` menyediakan tree Icings/Menu yang dapat diisi oleh host. `adminMenu()` mengembalikan tree admin yang telah dibangun. `$this->Menu->IcingsMenu` menyediakan helper Icings/Menu bila diperlukan.

## User template examples

Uikit automatically selects the auth templates in `templates/examples/users/auth/CakeDC/Users/Users/` for the corresponding unprefixed CakeDC/Users actions, unless the controller selects another theme or an explicit template. To override one, create `templates/plugin/CakeDC/Users/Users/<template>.php` in the host; the host template takes priority. Other actions retain their normal CakePHP template resolution. Admin and member examples still need to be copied into the host application if desired. The Al Irsyad Admin host provides `bin/cake install_user_templates`, which copies examples without overwriting existing files unless `--force` is supplied.

- `auth/CakeDC/Users/Users/`: login, registration, recovery, and two-factor pages using `Uikit.auth`.
- `admin/CakeDC/Users/Users/`: profile, change password, and CRUD pages using `Uikit.admin`.
- `admin/BusinessUsers/Admin/Users/`: BusinessUsers admin CRUD and profile pages using `Uikit.admin`.
- `member/CakeDC/Users/Users/`: alternative profile and password pages using `Uikit.member`, with no admin sidebar.

Install the `admin` set for a backoffice or `member` set for a member-facing site. Both include the shared `auth` pages. The upload form and avatar URLs in these examples require the BusinessUsers profile-photo migration and routes. Run `bin/cake migrations migrate --plugin BusinessUsers` after updating that plugin.

To customize a screen, add or edit its host template. Auth templates in Uikit are fallbacks and do not override host templates.

## Styling Sidebar/Menu

File utama styling menu admin:

- `resources/css/_menu.scss`
- `resources/css/_sidebar.scss`

Perilaku yang saat ini diharapkan:

- Parent menu tetap expand ketika submenu aktif.
- Submenu aktif berwarna lebih kontras dan lebih tebal.

Jika mengubah style, lakukan perubahan di source SCSS lalu build ulang asset.

## Workflow Pengembangan

1. Jalankan `node vendor/yeriepiscesa/cakephp-uikit/bin/uikit-assets.mjs dev` dari root aplikasi saat mengerjakan UI.
2. Akses aplikasi dari server CakePHP (bukan port Vite).
3. Edit source di `resources/` dan template di `templates/`.
4. Build dengan `node vendor/yeriepiscesa/cakephp-uikit/bin/uikit-assets.mjs build` dari root aplikasi saat siap release.

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

## Dashboard, redirect, dan flash

Host menyediakan dashboard pada `/admin`, menggunakan layout admin Uikit. Buat
`templates/admin/dashboard.php` di host untuk mengganti template bawaan.

Atur tujuan default di `config/app.php` melalui `Uikit.loginRedirect` dan
`Uikit.logoutRedirect` (default `/admin` dan `/`). Redirect login yang
diminta melalui query tetap mengikuti pemeriksaan CakeDC/Users.

Flash default, success, error, warning, dan info ditampilkan sebagai UIkit alert,
termasuk pada halaman login. Elemen flash kustom tetap dapat digunakan.

Aturan host membolehkan halaman publik host tanpa login; area `/admin` dan
`/api` tidak termasuk bypass ini. Plugin domain dan API tetap bertanggung
jawab atas autentikasi dan otorisasinya sendiri. Daftarkan endpoint REST di
bawah `/api` melalui routing host atau plugin domain.

### Branding dan warna

Atur branding di konfigurasi host, misalnya `config/app_local.php`:

```php
'Uikit' => [
    'siteName' => 'Nama Aplikasi',
    'branding' => [
        'tagline' => 'Workspace',
        'logo' => '/img/logo.svg',
        'loginImage' => '/img/login-background.jpg',
        'loginEyebrow' => 'Selamat datang',
        'loginTitle' => 'Semua pekerjaan, lebih terarah.',
        'loginDescription' => 'Ruang kerja untuk tim Anda.',
        'colors' => [
            'primary' => '#2864df',
            'primaryHover' => '#1d50bc',
            'sidebar' => '#16293d',
            'background' => '#f5f7fa',
        ],
    ],
],
```

Logo dan gambar adalah URL yang dapat dijangkau browser; letakkan aset publik
pada `webroot` host atau gunakan URL yang sesuai. Keduanya opsional. Gambar
login bersifat dekoratif, dengan lapisan gelap untuk menjaga keterbacaan;
panel tersebut disembunyikan pada layar kecil. Warna menerima hex tiga atau
enam digit; nilai tidak valid memakai warna default. Pilih kombinasi warna dan
gambar dengan kontras yang memadai. Konfigurasi ini tidak mengunggah atau
mengelola file.

Form login tetap memakai autentikasi CakeDC/Users. Tautan lupa kata sandi,
registrasi, login sosial, login link, remember me, dan reCAPTCHA muncul sesuai
konfigurasi plugin Users. Template login host yang sudah ada tetap didahulukan
dan perlu disesuaikan sendiri jika ingin menggunakan tampilan baru.

Pada desktop tombol navigasi mengganti sidebar menjadi toolbar horizontal;
pada layar kecil tombol membuka sidebar dan Escape menutupnya. Pilihan terakhir
disimpan di localStorage browser secara terpisah untuk desktop dan layar kecil;
jika storage tidak tersedia, navigasi tetap dapat digunakan tanpa menyimpan. Item menu dan
otorisasi tetap berasal dari adapter domain.

Host dan plugin lokal mensyaratkan PHP minimal 8.4. Periksa juga versi tepat
yang dibutuhkan dependensi terkunci sebelum memilih versi PHP; misalnya versi
PHPUnit pada lockfile saat ini membutuhkan minimal PHP 8.4.1.

### Form admin

Default form disediakan di `Uikit/config/app.php` dan dapat ditimpa di
`config/app.php` host:

```php
'Uikit' => [
    'form_edit_redirect' => 'stay', // stay atau index
    'form_add_redirect' => 'add',   // add, edit, atau index
],
```

`stay` tetap pada edit yang disimpan, `add` membuka form tambah kosong,
`edit` membuka form edit record baru, dan `index` kembali ke daftar.
Per form, override melalui elemen tombol di template:

```php
$this->element('Uikit.crud_buttons', [
    'type' => 'form', 'entity' => $entity,
    'options' => ['redirect' => 'index', 'showDelete' => false],
]);
```

Pada controller yang menggunakan CrudConnect, tombol kembali dan cancel
menggunakan URL daftar terakhir dari controller yang sama, termasuk query
pencarian, filter dan pagination. Redirect berlaku setelah penyimpanan sukses;
validasi dan otorisasi tetap ditangani controller dan model domain.

Judul, subtitle dan lebar panel dapat disetel per template:

```php
$this->element('Uikit.page_header', [
    'title' => __('Edit item'),
    'subtitle' => __('Update the item details.'),
    'formWidth' => '1/2', // 1/1 (default), 1/2, 1/3, atau 1/4
]);
```

Di layar kecil panel selalu memenuhi lebar yang tersedia. Untuk select dengan
opsi lokal, tambahkan `data-tom-select` pada elemen select; nilai yang dikirim
tetap nilai option asli. Tom Select tidak mengubah otorisasi atau validasi.

### Listing admin

Untuk daftar dengan `Uikit.admin`, gunakan elemen dan kelas bersama:

```php
$this->element('Uikit.page_header', [
    'title' => __('Items'),
    'actions' => [[
        'label' => __('New item'),
        'url' => ['action' => 'add'],
        'class' => 'uk-button uk-button-primary',
    ]],
]);
?>
<?= $this->element('Uikit.table_controls') ?>
<div class="datalist-table datalist-freeze-3">
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-small uk-table-striped">
            <thead><!-- headings and Sort->column() --></thead>
            <tbody><!-- rows and Uikit.list_action_buttons --></tbody>
        </table>
    </div>
</div>
<?= $this->element('Uikit.table_paginator') ?>
```

Letakkan ketiga komponen sebagai elemen berurutan agar pencarian, tabel dan
pagination tampil dalam satu panel. Kelas `datalist-freeze-2`, `-3`, atau `-4`
menjaga sejumlah kolom tetap terlihat ketika tabel bergulir horizontal.
Komponen menyediakan parameter GET `search` dan `limit`, tombol Clear Search,
dan mempertahankan filter serta pengurutan lain. Controller/model tetap harus
menerapkan pencarian, pengurutan, pagination dan otorisasi; komponen visual ini
tidak memfilter data sendiri. Lihat `BusinessUsers.TenantsTable` untuk contoh
Search behavior dan template `BusinessUsers/Admin/Tenants/index.php` untuk
contoh lengkap. Elemen `Uikit.list_action_buttons` menyediakan aksi baris;
controller tetap wajib memeriksa izin aksi.

URL daftar terakhir disimpan per plugin, prefix dan controller saat form dibuka
dari daftar yang bersangkutan. Tombol Back to list dan Cancel menggunakannya,
termasuk query string. Jika form dibuka langsung tanpa riwayat daftar yang
valid, tombol mengarah ke index controller. Pengaturan redirect sukses di atas
berlaku untuk controller yang menggunakan `CrudConnect.CrudController` dan
`Uikit.crud_buttons`; controller kustom perlu menangani redirect sendiri.

Breadcrumb otomatis muncul di atas judul admin: Dashboard, daftar controller
untuk halaman add/edit/view, dan halaman saat ini. Pada form CrudConnect,
tautan daftar memakai URL kembali yang sudah disimpan. Template dapat mengganti
breadcrumb otomatis dengan mengisi view block `breadcrumbs`; markup kustom
bertanggung jawab atas escaping dan label aksesibilitasnya sendiri.
