# Template Kementerian Agama - AdminLTE Laravel

Template admin panel yang disesuaikan dengan tema dan branding Kementerian Agama Republik Indonesia menggunakan AdminLTE dan Laravel.

## ✨ Fitur Utama

### 🎨 Desain & Tema
- **Warna Khas Kementerian Agama**: Menggunakan palet warna hijau (#2d5016) dan emas (#d4af37)
- **Logo Terintegrasi**: Logo Kementerian Agama di navbar, sidebar, dan halaman autentikasi
- **Animasi Modern**: Transisi halus dan efek hover yang elegan
- **Responsive Design**: Tampilan optimal di desktop, tablet, dan mobile

### 📊 Dashboard
- **Statistik Real-time**: Total pegawai, jamaah haji, madrasah, dan pernikahan
- **Aktivitas Terbaru**: Timeline aktivitas sistem terkini
- **Aksi Cepat**: Shortcut untuk fungsi-fungsi penting
- **Pengumuman**: Panel pengumuman dan informasi penting

### 🔧 Menu Terintegrasi
Menu sidebar yang disesuaikan dengan struktur organisasi Kementerian Agama:

#### 📈 Manajemen Data
- **Data Master**: Pegawai, jabatan, unit kerja, golongan
- **Kepegawaian**: Mutasi, promosi, cuti, disiplin
- **Keuangan**: Penggajian, tunjangan, laporan keuangan

#### 🕌 Pelayanan Publik
- **Haji & Umrah**: Pendaftaran, data jamaah, pembinaan, layanan umrah
- **Pelayanan Nikah**: Pendaftaran nikah, buku nikah, penghulu
- **Pendidikan Agama**: Madrasah, guru agama, kurikulum, pesantren

#### 📋 Laporan & Monitoring
- **Laporan**: Kepegawaian, pelayanan, keuangan, statistik
- **Pengaturan Sistem**: User management, backup, hak akses

## 🚀 Instalasi & Konfigurasi

### Prasyarat
- PHP 8.0+
- Laravel 11.x
- AdminLTE Package
- Node.js & NPM

### Setup Template

1. **Konfigurasi AdminLTE**
   Template ini telah mengkonfigurasi file `config/adminlte.php` dengan:
   - Judul: "SIAKAD KEMENAG"
   - Logo dan branding Kementerian Agama
   - Warna tema hijau untuk sidebar dan navbar
   - Menu navigasi yang disesuaikan

2. **CSS Custom**
   File `public/css/admin-custom.css` berisi styling khusus:
   - Palet warna Kementerian Agama
   - Gradient backgrounds
   - Animasi dan transisi
   - Responsive design

3. **Logo**
   Logo SVG tersedia di `public/images/logo-kemenag.svg`
   (Dapat diganti dengan logo resmi Kementerian Agama)

### Menggunakan Template

1. **Extend Base Template**
   ```blade
   @extends('admin.app')

   @section('title', 'Judul Halaman')
   @section('page-title', 'Judul Header')

   @section('content')
       <!-- Konten halaman -->
   @endsection
   ```

2. **Breadcrumb Navigation**
   ```blade
   @section('breadcrumb')
       <li class="breadcrumb-item"><a href="#">Parent</a></li>
       <li class="breadcrumb-item active">Current Page</li>
   @endsection
   ```

3. **Custom Scripts & Styles**
   ```blade
   @push('styles')
       <link rel="stylesheet" href="custom.css">
   @endpush

   @push('scripts')
       <script src="custom.js"></script>
   @endpush
   ```

## 🎨 Kustomisasi Warna

Warna utama dapat diubah melalui CSS variables di `admin-custom.css`:

```css
:root {
    --kemenag-green: #2d5016;      /* Hijau utama */
    --kemenag-light-green: #4a7c59; /* Hijau terang */
    --kemenag-gold: #d4af37;        /* Emas/kuning */
    --kemenag-white: #ffffff;       /* Putih */
}
```

## 📱 Komponen UI

### Cards
```blade
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-icon mr-2"></i>
            Judul Card
        </h3>
    </div>
    <div class="card-body">
        <!-- Konten -->
    </div>
</div>
```

### Small Boxes (Statistics)
```blade
<div class="small-box bg-success">
    <div class="inner">
        <h3>150</h3>
        <p>Total Data</p>
    </div>
    <div class="icon">
        <i class="fas fa-users"></i>
    </div>
    <a href="#" class="small-box-footer">
        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
    </a>
</div>
```

### Alerts
```blade
<div class="alert alert-kemenag alert-dismissible fade show">
    <i class="fas fa-info-circle mr-2"></i>
    <strong>Informasi!</strong> Pesan penting untuk pengguna.
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
```

## 🔒 Keamanan & Autentikasi

Template ini terintegrasi dengan sistem autentikasi Laravel:
- Login page dengan branding Kementerian Agama
- User menu dengan foto profil dan logout
- Middleware untuk proteksi route

## 📊 Integrasi Chart

Dashboard dilengkapi dengan Chart.js untuk visualisasi data:
- Bar chart untuk statistik pelayanan
- Doughnut chart untuk distribusi pegawai
- Responsive dan interaktif

## 🔧 Maintenance & Update

### Update Logo
Ganti file `public/images/logo-kemenag.svg` dengan logo resmi

### Modifikasi Menu
Edit array `menu` di `config/adminlte.php` untuk menyesuaikan navigasi

### Custom CSS
Tambahkan styling custom di `public/css/admin-custom.css`

## 📝 Lisensi

Template ini dibuat khusus untuk Kementerian Agama Republik Indonesia dan dapat digunakan sesuai dengan kebijakan organisasi.

## 🤝 Kontribusi

Untuk improvement dan bug fixes, silakan buat issue atau pull request.

## 📞 Support

Untuk bantuan teknis, hubungi tim IT Kementerian Agama.

---

**© 2025 Kementerian Agama Republik Indonesia**
