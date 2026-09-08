# UIKit Bake Template

Template bake untuk menghasilkan CRUD templates dengan UIkit styling otomatis menggunakan Twig.

## Instalasi

Bake template sudah terintegrasi di plugin Uikit. Tidak perlu konfigurasi tambahan.

## Penggunaan

### Bake Template dengan Theme Uikit

```bash
# Bake template untuk controller Admin/FlightRoutes
bin/cake bake template Admin/FlightRoutes --prefix Admin --plugin Uikit --theme Uikit

# Atau bake semua templates untuk resource
bin/cake bake all Admin/Flights --prefix Admin --plugin Uikit --theme Uikit
```

### Option Bake

- `--prefix Admin` - Tentukan prefix untuk routing
- `--plugin Uikit` - Output templates ke plugin Uikit
- `--theme Uikit` - Gunakan bake template dari Uikit plugin

## Struktur Template

Template bake menggunakan Twig dan berlokasi di:
- `/plugins/Uikit/templates/bake/Template/`
  - `add.twig` - Form untuk menambah data
  - `edit.twig` - Form untuk edit dengan delete button
  - `index.twig` - List dengan pagination dan sort
  - `view.twig` - Detail view dengan action buttons

## Fitur Template

### Index Template
- Tabel dengan UIkit styling (striped, hover)
- Limit control untuk pagination
- Search box untuk filter
- Sortable columns dengan icon indicator (triangle up/down)
- Action buttons: View, Edit, Delete dengan UIkit icons
- Delete confirmation menggunakan UIkit modal confirm
- Paginator dengan UIkit styling

### Add Template
- Form dengan UIkit styling (form-stacked)
- UIkit input, textarea, select
- Submit dan Cancel buttons
- Responsive layout

### Edit Template
- Form dengan UIkit styling
- Submit, Cancel, dan Delete buttons
- Delete confirmation menggunakan UIkit modal confirm
- Hidden form untuk delete submission

### View Template
- Table dengan UIkit styling untuk menampilkan data
- Edit, Delete, List, dan New buttons
- Delete confirmation menggunakan UIkit modal confirm

## Komponen Reuseable

Template menggunakan 3 reuseable elements:

1. **page_header** - Title dan action buttons
   ```php
   $this->element('Uikit.page_header', [
       'title' => __('Page Title'),
       'actions' => [...]
   ]);
   ```

2. **table_controls** - Limit control dan search box
   ```php
   <?= $this->element('Uikit.table_controls') ?>
   ```

3. **table_paginator** - Pagination controls
   ```php
   <?= $this->element('Uikit.table_paginator') ?>
   ```

## Styling

Semua template menggunakan:
- UIkit framework classes (uk-button, uk-table, uk-form, etc.)
- Responsive design dengan flex layout
- Font Outfit dari Google Fonts
- Consistent color scheme ($primary-color: #3498db)
- Icon-only actions dengan tooltips

## Template Variables (Twig)

Tersedia di template Twig:
- `{{ namespace }}` - PHP namespace
- `{{ entityClass }}` - Entity class name
- `{{ singularVar }}` - Singular variable (contoh: flightRoute)
- `{{ pluralVar }}` - Plural variable (contoh: flightRoutes)
- `{{ singularHumanName }}` - Singular readable name
- `{{ pluralHumanName }}` - Plural readable name
- `{{ primaryKey[0] }}` - Primary key field
- `{{ fields }}` - Array of table columns
- `{{ associations }}` - BelongsTo, HasMany, BelongsToMany

## Customization

Untuk customize template, edit file Twig di:
- `/plugins/Uikit/templates/bake/Template/`

Gunakan Twig syntax:
- `{% for ... in ... %}` - Loops
- `{% if ... %}` - Conditionals
- `{{ variable }}` - Output variables
- `{{ variable|humanize }}` - Twig filters

## Contoh Output

Hasil bake template akan menghasilkan:
- Form dengan UIkit styling
- Table dengan search, pagination, sort
- Modal confirmation untuk delete
- Icon-only action buttons
- Responsive layout yang mobile-friendly

