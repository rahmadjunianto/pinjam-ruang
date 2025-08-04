# 📋 SIAKAD KEMENAG - Sistem Peminjaman Ruang

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![AdminLTE](https://img.shields.io/badge/AdminLTE-3.x-green.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange.svg)
![Docker](https://img.shields.io/badge/Docker-Ready-blue.svg)

Sistem Informasi Akademik Kementerian Agama untuk manajemen peminjaman ruangan dengan antarmuka AdminLTE yang modern dan responsif.

## 📑 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Persyaratan Sistem](#️-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#️-konfigurasi)
- [Struktur Aplikasi](#-struktur-aplikasi)
- [Panduan Penggunaan](#-panduan-penggunaan)
- [API Documentation](#-api-documentation)
- [Docker Setup](#-docker-setup)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Contributing](#-contributing)
- [License](#-license)

## 🚀 Fitur Utama

### 👤 **Manajemen Pengguna**
- ✅ Autentikasi dengan NIP Kemenag
- ✅ Role-based access control (Admin, User, Viewer)
- ✅ Profil pengguna dengan foto
- ✅ Reset password dan toggle status user

### 🏢 **Manajemen Ruangan**
- ✅ CRUD ruangan dengan kategori
- ✅ Upload foto ruangan multiple
- ✅ Status aktif/non-aktif ruangan
- ✅ Kapasitas dan fasilitas ruangan

### 📅 **Sistem Peminjaman**
- ✅ Booking ruangan dengan validasi waktu
- ✅ Kalender interaktif dengan FullCalendar
- ✅ Approval workflow (Pending → Approved/Rejected)
- ✅ Notifikasi status peminjaman
- ✅ Cancel booking oleh user

### 📊 **Dashboard & Laporan**
- ✅ Dashboard analytics dengan chart
- ✅ Statistik peminjaman real-time
- ✅ Laporan dengan filter advanced
- ✅ Export data ke CSV/PDF
- ✅ Visualisasi data dengan Chart.js

### 🛠️ **Fitur Admin**
- ✅ Backup & restore database
- ✅ Manajemen bidang/departemen
- ✅ Log aktivitas sistem
- ✅ Help system & dokumentasi
- ✅ System information

### 🎨 **UI/UX Features**
- ✅ Theme Kemenag dengan logo resmi
- ✅ Responsive design (mobile-friendly)
- ✅ Dark/Light mode toggle
- ✅ SweetAlert2 untuk notifikasi
- ✅ DataTables untuk tabel interaktif

## ⚙️ Persyaratan Sistem

### Minimum Requirements
- **PHP**: 8.2 atau lebih tinggi
- **Composer**: 2.x
- **Node.js**: 18.x atau lebih tinggi
- **NPM**: 9.x atau lebih tinggi
- **Database**: MySQL 8.0 atau MariaDB 10.4+
- **Web Server**: Apache 2.4+ atau Nginx 1.18+

### Recommended Requirements
- **Memory**: 512MB RAM minimum, 1GB recommended
- **Storage**: 500MB free space
- **PHP Extensions**:
  - BCMath, Ctype, Fileinfo, JSON, Mbstring
  - OpenSSL, PDO, Tokenizer, XML, Zip, GD, Intl

## 📦 Instalasi

### Instalasi Manual

1. **Clone Repository**
```bash
git clone https://github.com/rahmadjunianto/pinjam-ruang.git
cd pinjam-ruang
```

2. **Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

3. **Environment Setup**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

4. **Database Setup**
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE adminlte_laravel"

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

5. **Build Assets**
```bash
# Development build
npm run dev

# Production build
npm run build
```

6. **Storage Link**
```bash
php artisan storage:link
```

7. **Start Development Server**
```bash
php artisan serve
```

### Instalasi dengan Docker

```bash
# Quick setup with script
./docker-setup.sh

# Manual Docker setup
docker-compose up -d
docker-compose exec app php artisan migrate --seed
```

Lihat [Docker Documentation](DOCKER.md) untuk detail lengkap.

## ⚙️ Konfigurasi

### Database Configuration
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=adminlte_laravel
DB_USERNAME=root
DB_PASSWORD=
```

### Mail Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@kemenag.go.id"
MAIL_FROM_NAME="SIAKAD KEMENAG"
```

### AdminLTE Configuration
```env
ADMINLTE_LOGO="<b>KEMENAG</b> SIAKAD"
ADMINLTE_LOGO_IMG="images/logo-kemenag.png"
ADMINLTE_LOGO_IMG_CLASS="brand-image img-circle elevation-3"
```

```
📦 adminlte-laravel/
├── 📁 app/
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/
│   │   │   └── 📁 Admin/
│   │   │       ├── 📄 DashboardController.php
│   │   │       ├── 📄 BookingController.php
│   │   │       ├── 📄 RoomController.php
│   │   │       └── 📄 UserController.php
│   │   ├── 📁 Middleware/
│   │   │   └── 📄 RoleMiddleware.php
│   │   └── 📁 Requests/
│   ├── 📁 Models/
│   │   ├── 📄 User.php
│   │   ├── 📄 Room.php
│   │   ├── 📄 Booking.php
│   │   ├── 📄 RoomCategory.php
│   │   └── 📄 Bidang.php
│   └── 📁 Providers/
├── 📁 database/
│   ├── 📁 migrations/
│   └── 📁 seeders/
├── 📁 resources/
│   ├── 📁 views/
│   │   └── 📁 admin/
│   │       ├── 📁 dashboard/
│   │       ├── 📁 bookings/
│   │       ├── 📁 rooms/
│   │       ├── 📁 users/
│   │       └── 📁 reports/
│   ├── 📁 css/
│   └── 📁 js/
├── 📁 public/
│   ├── 📁 images/
│   ├── 📁 css/
│   └── 📁 js/
├── 📁 docker/
│   ├── 📁 apache/
│   ├── 📁 mysql/
│   └── 📁 php/
├── 📄 docker-compose.yml
├── 📄 Dockerfile
└── 📄 README.md
```

## 📖 Panduan Penggunaan

### Default Login
- **Admin NIP**: `196001011980031001`
- **Password**: `password`

### Untuk Admin

#### 1. **Manajemen Ruangan**
- Akses: `Admin → Ruangan → Kelola Ruangan`
- Tambah/edit/hapus ruangan
- Upload foto ruangan multiple
- Set kapasitas dan fasilitas
- Aktif/nonaktifkan ruangan

#### 2. **Approval Peminjaman**
- Akses: `Admin → Peminjaman → Kelola Peminjaman`
- Review booking request
- Approve/reject dengan alasan
- Edit detail peminjaman

#### 3. **Laporan dan Analytics**
- Akses: `Admin → Laporan Peminjaman`
- Filter berdasarkan periode/status/ruangan
- Export data ke CSV
- Visualisasi chart statistik

### Untuk User

#### 1. **Booking Ruangan**
- Akses: `Peminjaman → Buat Peminjaman`
- Pilih ruangan yang tersedia
- Set tanggal dan waktu
- Submit untuk approval

#### 2. **Kalender Peminjaman**
- Akses: `Kalender Peminjaman`
- Lihat jadwal ruangan
- Check ketersediaan

## 🐳 Docker Setup

### Quick Start
```bash
# Setup otomatis
./docker-setup.sh
```

### Manual Setup
```bash
# Development
docker-compose up -d
docker-compose exec app php artisan migrate --seed

# Production
docker-compose -f docker-compose.prod.yml up -d
```

**Services:**
- **App**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
- **Database**: localhost:3307

Lihat [Docker Documentation](DOCKER.md) untuk detail lengkap.

## 🚀 Deployment

### Production Deployment

1. **Server Setup**
```bash
# LAMP stack
sudo apt install apache2 mysql-server php8.2

# PHP extensions
sudo apt install php8.2-{mysql,zip,gd,mbstring,curl,xml,bcmath,intl}
```

2. **Application Setup**
```bash
# Clone project
git clone https://github.com/rahmadjunianto/pinjam-ruang.git
cd pinjam-ruang

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Set permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

3. **Apache Configuration**
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/pinjam-ruang/public

    <Directory /var/www/pinjam-ruang/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

4. **Production Optimization**
```bash
# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Setup cron
echo "* * * * * cd /var/www/pinjam-ruang && php artisan schedule:run >> /dev/null 2>&1" | crontab -
```

## 🔐 Security Features

- ✅ CSRF Protection
- ✅ XSS Prevention
- ✅ SQL Injection Protection
- ✅ Rate Limiting
- ✅ Secure Headers
- ✅ Input Validation
- ✅ File Upload Security

## 📊 Monitoring

### Application Logs
```bash
# View logs
tail -f storage/logs/laravel.log

# Web server logs
sudo tail -f /var/log/apache2/error.log
```

### Database Backup
```bash
# Create backup
php artisan backup:run

# Manual backup
mysqldump -u root -p adminlte_laravel > backup.sql
```

## 🆘 Troubleshooting

### Common Issues

1. **Permission Errors**
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

2. **Database Connection**
```bash
# Check MySQL service
sudo systemctl status mysql

# Test connection
mysql -u root -p -e "SHOW DATABASES;"
```

3. **Cache Issues**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📚 Documentation

- 📖 **Wiki**: [GitHub Wiki](https://github.com/rahmadjunianto/pinjam-ruang/wiki)
- 🐳 **Docker**: [DOCKER.md](DOCKER.md)
- 🏗️ **API**: [API Documentation](API.md)
- 🧪 **Testing**: [Testing Guide](TESTING.md)

## 🤝 Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Open Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write unit tests
- Update documentation
- Use meaningful commit messages

## 📞 Support

- 📧 **Email**: rahmadjunianto@kemenag.go.id
- 🐛 **Issues**: [GitHub Issues](https://github.com/rahmadjunianto/pinjam-ruang/issues)
- 💬 **Discussions**: [GitHub Discussions](https://github.com/rahmadjunianto/pinjam-ruang/discussions)

## 📄 License

This project is licensed under the MIT License.

## 👥 Credits

- **Developer**: Rahmad Junianto
- **Organization**: Kementerian Agama RI
- **Framework**: Laravel 12.x
- **Theme**: AdminLTE 3.x

---

**© 2025 Kementerian Agama RI. All rights reserved.**
