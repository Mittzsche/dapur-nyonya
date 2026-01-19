# 🍳 Dapur Nyonya

**Website Catering & Layanan Makanan Tradisional**

Aplikasi web full-stack untuk layanan catering dengan sistem pemesanan online, manajemen menu, galeri, dan testimoni pelanggan.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?style=flat-square&logo=vue.js&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat-square&logo=docker&logoColor=white)

---

## 📋 Daftar Isi

- [Tech Stack](#-tech-stack)
- [Struktur Proyek](#-struktur-proyek)
- [Setup Development](#-setup-development)
- [Deploy dengan Docker](#-deploy-dengan-docker)
- [Deploy ke Vercel](#-deploy-ke-vercel)
- [Environment Variables](#-environment-variables)
- [Troubleshooting](#-troubleshooting)

---

## 🛠 Tech Stack

| Layer | Teknologi |
|-------|-----------|
| **Frontend** | Vue.js 3, Vue Router, Axios |
| **Backend** | Laravel 12, PHP 8.2, Sanctum |
| **Database** | MySQL 8.0 |
| **Deployment** | Docker, Vercel |

---

## 📁 Struktur Proyek

```
dapur-nyonya/
├── backend/                 # Laravel API
│   ├── app/                 # Controllers, Models, Services
│   ├── database/            # Migrations, Seeders
│   ├── routes/              # API Routes
│   ├── docker/              # Docker config files
│   └── Dockerfile           # Backend container
├── frontend/                # Vue.js SPA
│   ├── src/
│   │   ├── views/           # Page components
│   │   ├── components/      # Reusable components
│   │   ├── services/        # API services
│   │   └── router/          # Vue Router
│   └── vercel.json          # Vercel config
└── docker-compose.yml       # Docker orchestration
```

---

## 🚀 Setup Development

### Prasyarat

- **PHP 8.2+** - [Download](https://windows.php.net/download/)
- **Composer** - [Download](https://getcomposer.org/download/)
- **Node.js 16+** - [Download](https://nodejs.org/)
- **MySQL/MariaDB** - [Download XAMPP](https://www.apachefriends.org/)

### 1. Setup Database

```bash
# Buka XAMPP → Start MySQL
# Buka phpMyAdmin (http://localhost/phpmyadmin)
# Buat database: db_dapurnyonya
```

### 2. Setup Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

Edit `backend/.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=db_dapurnyonya
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```
> Server: **http://localhost:8000**

### 3. Setup Frontend

```bash
cd frontend
npm install
npm run serve
```
> Server: **http://localhost:8080**

### 4. Login Admin

| Field | Value |
|-------|-------|
| Username | `admin` |
| Password | `admin123` |

---

## 🐳 Deploy dengan Docker

### Quick Start (Production)

```bash
# Clone repository
git clone https://github.com/your-username/dapur-nyonya.git
cd dapur-nyonya

# Start semua services
docker-compose up -d

# Jalankan migrasi database
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed --force
```

### Docker Services

| Service | Port | Deskripsi |
|---------|------|-----------|
| `app` | 8000 | Laravel API |
| `db` | 3306 | MySQL Database |

### Build Manual

```bash
# Backend only
cd backend
docker build -t dapur-nyonya-backend .
docker run -p 8000:8080 dapur-nyonya-backend
```

### Platform yang Didukung

- **Railway** - [railway.app](https://railway.app)
- **Render** - [render.com](https://render.com)
- **Fly.io** - [fly.io](https://fly.io)
- **DigitalOcean App Platform**

---

## ▲ Deploy ke Vercel (Full Stack - Single Project)

Aplikasi ini sudah dikonfigurasi untuk **monorepo deployment** di Vercel, sehingga frontend dan backend bisa di-deploy sebagai satu project.

> **⚠️ Catatan:** Vercel menggunakan `vercel-php` runtime untuk Laravel. Ini cocok untuk aplikasi dengan traffic rendah-menengah. Untuk production skala besar, gunakan Docker deployment.

### Langkah Deploy

```bash
# 1. Install Vercel CLI (jika belum)
npm install -g vercel

# 2. Dari root folder project
cd dapur-nyonya

# 3. Login ke Vercel
vercel login

# 4. Deploy
vercel --prod
```

### Atau via Vercel Dashboard

1. Push ke GitHub
2. Buka [vercel.com](https://vercel.com)
3. Import repository
4. Biarkan Vercel detect konfigurasi dari `vercel.json`
5. Deploy!

### Struktur Deployment

| Endpoint | Served By |
|----------|-----------|
| `/` | Vue.js SPA (frontend) |
| `/api/*` | Laravel API (backend) |
| `/storage/*` | Laravel storage files |

### Environment Variables (di Vercel Dashboard)

| Variable | Value |
|----------|-------|
| `APP_KEY` | (run `php artisan key:generate --show`) |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | (your database host) |
| `DB_DATABASE` | (your database name) |
| `DB_USERNAME` | (your database user) |
| `DB_PASSWORD` | (your database password) |

---

## 🔐 Environment Variables

### Backend (.env)

| Variable | Deskripsi | Default |
|----------|-----------|---------|
| `APP_ENV` | Environment | `production` |
| `APP_DEBUG` | Debug mode | `false` |
| `APP_URL` | Base URL | - |
| `DB_HOST` | Database host | `127.0.0.1` |
| `DB_DATABASE` | Database name | `dapur_nyonya` |
| `DB_USERNAME` | DB username | `root` |
| `DB_PASSWORD` | DB password | - |

### Frontend (.env.production)

| Variable | Deskripsi | Default |
|----------|-----------|---------|
| `VUE_APP_API_URL` | Backend API URL | `http://localhost:8000/api` |

---

## ❓ Troubleshooting

### Error: SQLSTATE[HY000] [1049] Unknown database
> Database belum dibuat. Buat di phpMyAdmin atau jalankan:
```bash
docker-compose exec db mysql -u root -p -e "CREATE DATABASE dapur_nyonya;"
```

### Error: personal_access_tokens table not found
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### CORS Error saat deploy
> Pastikan `APP_URL` dan frontend URL sudah dikonfigurasi dengan benar di backend.

### Docker container exit code 1
```bash
# Cek logs
docker-compose logs app

# Rebuild container
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

---

## 📄 License

[MIT License](LICENSE)

---

<div align="center">
  <sub>Built with ❤️ by Tim Dapur Nyonya</sub>
</div>