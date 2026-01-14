# Struktur Folder Proyek Dapur Nyonya

## Backend (Laravel - PHP)

```
backend/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── AdminController.php
│   │   │   ├── LayananController.php
│   │   │   ├── PemesananController.php
│   │   │   ├── MitraController.php
│   │   │   ├── PenjualanController.php
│   │   │   └── TestimoniController.php
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   ├── AdminMiddleware.php
│   │   │   └── Cors.php
│   │   └── Requests/
│   │       ├── LoginRequest.php
│   │       ├── PemesananRequest.php
│   │       └── LayananRequest.php
│   ├── Models/
│   │   ├── Admin.php
│   │   ├── Layanan.php
│   │   ├── Pemesanan.php
│   │   ├── Mitra.php
│   │   └── Testimoni.php
│   └── Providers/
├── bootstrap/
├── config/
│   ├── app.php
│   ├── database.php
│   ├── cors.php
│   └── auth.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_create_admins_table.php
│   │   ├── 2024_01_02_create_mitras_table.php
│   │   ├── 2024_01_03_create_layanans_table.php
│   │   ├── 2024_01_04_create_pemesanans_table.php
│   │   └── 2024_01_05_create_testimonis_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── AdminSeeder.php
│   │   ├── MitraSeeder.php
│   │   └── LayananSeeder.php
│   └── factories/
├── public/
│   ├── images/
│   │   ├── layanan/
│   │   ├── galeri/
│   │   └── testimoni/
│   └── index.php
├── resources/
│   └── views/
├── routes/
│   ├── api.php
│   ├── web.php
│   └── channels.php
├── storage/
│   ├── app/
│   │   └── public/
│   ├── framework/
│   └── logs/
├── tests/
│   ├── Feature/
│   └── Unit/
├── vendor/
├── .env
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── phpunit.xml
└── README.md
```

## Frontend (Vue.js)

```
frontend/
├── node_modules/
├── public/
│   ├── favicon.ico
│   └── index.html
├── src/
│   ├── assets/
│   │   ├── images/
│   │   │   ├── logo.png
│   │   │   ├── hero-bg.jpg
│   │   │   └── galeri/
│   │   ├── css/
│   │   │   ├── main.css
│   │   │   └── admin.css
│   │   └── fonts/
│   ├── components/
│   │   ├── common/
│   │   │   ├── Navbar.vue
│   │   │   ├── Footer.vue
│   │   │   ├── Loading.vue
│   │   │   └── Alert.vue
│   │   ├── home/
│   │   │   ├── HeroSection.vue
│   │   │   ├── WhyChooseUs.vue
│   │   │   ├── ServicePreview.vue
│   │   │   ├── AboutPreview.vue
│   │   │   ├── GallerySection.vue
│   │   │   ├── TestimonialPreview.vue
│   │   │   └── HowToOrder.vue
│   │   ├── layanan/
│   │   │   └── ServiceCard.vue
│   │   ├── testimoni/
│   │   │   └── TestimonialCard.vue
│   │   └── admin/
│   │       ├── Sidebar.vue
│   │       ├── Header.vue
│   │       ├── ProductTable.vue
│   │       ├── OrderTable.vue
│   │       └── SalesTable.vue
│   ├── views/
│   │   ├── public/
│   │   │   ├── Home.vue
│   │   │   ├── LayananKami.vue
│   │   │   ├── TentangKami.vue
│   │   │   ├── Testimoni.vue
│   │   │   └── HubungiKami.vue
│   │   └── admin/
│   │       ├── Login.vue
│   │       ├── Dashboard.vue
│   │       ├── Produk.vue
│   │       ├── EditProduk.vue
│   │       ├── Pemesanan.vue
│   │       └── Penjualan.vue
│   ├── router/
│   │   └── index.js
│   ├── store/
│   │   ├── index.js
│   │   └── modules/
│   │       ├── auth.js
│   │       ├── layanan.js
│   │       ├── pemesanan.js
│   │       └── penjualan.js
│   ├── services/
│   │   ├── api.js
│   │   ├── authService.js
│   │   ├── layananService.js
│   │   ├── pemesananService.js
│   │   └── penjualanService.js
│   ├── utils/
│   │   ├── helpers.js
│   │   ├── validation.js
│   │   └── constants.js
│   ├── App.vue
│   └── main.js
├── .gitignore
├── babel.config.js
├── jsconfig.json
├── package.json
├── package-lock.json
├── README.md
└── vue.config.js
```

## Penjelasan Struktur Backend (Laravel)

### Controllers
- **AuthController**: Menangani login/logout admin
- **LayananController**: CRUD paket layanan catering
- **PemesananController**: Mengelola pemesanan pelanggan
- **MitraController**: Mengelola data mitra kerja
- **PenjualanController**: Laporan dan analisis penjualan
- **TestimoniController**: Mengelola testimoni pelanggan

### Models
- **Admin**: Model untuk tabel tb_data_admin
- **Layanan**: Model untuk tabel tb_data_layanan
- **Pemesanan**: Model untuk tabel tb_data_pemesanan
- **Mitra**: Model untuk tabel tb_data_mitra
- **Testimoni**: Model untuk testimoni pelanggan

### Migrations
Membuat struktur tabel sesuai ERD:
- admins (id_admin, username, password, nama_lengkap)
- mitras (id_mitra, nama_mitra, kontak, alamat_mitra)
- layanans (id_layanan, nama_paket, harga, deskripsi, gambar, stok)
- pemesanans (id_pemesanan, nama_pelanggan, email, no_hp, alamat, tanggal_acara, catatan, status, id_mitra, id_layanan, created_at)
- testimonis (id, nama, foto, testimoni, rating)

## Penjelasan Struktur Frontend (Vue.js)

### Components
- **common**: Komponen reusable (Navbar, Footer)
- **home**: Komponen khusus halaman beranda
- **layanan**: Komponen untuk menampilkan layanan
- **admin**: Komponen khusus dashboard admin

### Views
- **public**: Halaman yang dapat diakses pengguna umum
- **admin**: Halaman yang hanya dapat diakses admin setelah login

### Router
Mengatur navigasi antar halaman dengan Vue Router

### Store (Vuex)
Manajemen state global aplikasi untuk:
- Autentikasi admin
- Data layanan
- Data pemesanan
- Data penjualan

### Services
Layer untuk komunikasi dengan API backend Laravel:
- **api.js**: Konfigurasi axios base
- **authService.js**: Login/logout
- **layananService.js**: CRUD layanan
- **pemesananService.js**: CRUD pemesanan
- **penjualanService.js**: Laporan penjualan

## Database Configuration

**Database**: MySQL
- Database Name: db_dapurnyonya
- Tables:
  - tb_data_admin
  - tb_data_mitra
  - tb_data_layanan
  - tb_data_pemesanan
  - tb_data_testimoni

## Tech Stack
- **Backend**: Laravel (PHP), Node.js API
- **Frontend**: Vue.js, JavaScript
- **Database**: XAMPP MySQL
- **Server**: MySQL (untuk penyimpanan)
- **Editor**: Visual Studio Code
- **OS Development**: Windows 10
