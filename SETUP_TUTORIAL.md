# Panduan Setup - Dapur Nyonya

## Prasyarat

Pastikan sudah terinstall:
- **PHP 8.1+** - [Download](https://windows.php.net/download/)
- **Composer** - [Download](https://getcomposer.org/download/)
- **Node.js 16+** - [Download](https://nodejs.org/)
- **MySQL/MariaDB** - [Download XAMPP](https://www.apachefriends.org/)

---

## 1. Setup Database

1. Buka **XAMPP** → Start **MySQL**
2. Buka **phpMyAdmin** (http://localhost/phpmyadmin)
3. Buat database baru: `db_dapurnyonya`

---

## 2. Setup Backend (Laravel)

```bash
# Masuk ke folder backend
cd backend

# Install dependencies
composer install

# Copy file environment
cp .env.example .env

# Generate app key
php artisan key:generate
```

### Konfigurasi Database

Edit file `backend/.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_dapurnyonya
DB_USERNAME=root
DB_PASSWORD=
```

### Migrasi & Seeding

```bash
# Buat tabel database
php artisan migrate

# Isi data awal (admin, dll)
php artisan db:seed

# Buat link storage untuk upload gambar
php artisan storage:link
```

### Jalankan Server Backend

```bash
php artisan serve
```
Server jalan di: **http://localhost:8000**

---

## 3. Setup Frontend (Vue.js)

```bash
# Masuk ke folder frontend
cd frontend

# Install dependencies
npm install

# Jalankan server development
npm run serve
```
Server jalan di: **http://localhost:8080**

---

## 4. Akses Website

| Halaman | URL |
|---------|-----|
| Website Publik | http://localhost:8080 |
| Admin Login | http://localhost:8080/admin/login |
| API Backend | http://localhost:8000/api |

### Login Admin Default
- **Username:** `admin`
- **Password:** `admin123`

---

## Troubleshooting

### Error: SQLSTATE[HY000] [1049] Unknown database
→ Database belum dibuat. Buat dulu di phpMyAdmin.

### Error: personal_access_tokens table not found
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### Error: npm not found
→ Install Node.js dulu: https://nodejs.org/

### Error: composer not found
→ Install Composer dulu: https://getcomposer.org/

---

## Quick Start (Copy-Paste)

### Backend
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

### Frontend (Terminal baru)
```bash
cd frontend
npm install
npm run serve
```
