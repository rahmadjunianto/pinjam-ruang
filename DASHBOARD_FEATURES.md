# Dashboard Rekap Peminjaman Ruang

## Fitur yang Ditambahkan

### 1. Rekap Ruang yang Sering Dipinjam
- Menampilkan top 10 ruang yang paling sering dipinjam
- Disajikan dalam bentuk tabel dengan ranking
- Progress bar untuk visualisasi persentase
- Grafik donut untuk top 5 ruang

### 2. Rekap Bidang yang Sering Meminjam
- Menampilkan top 10 bidang yang paling aktif meminjam ruang
- Ranking dengan badge dan trophy untuk peringkat 1
- Progress bar dan grafik donut interaktif

### 3. Filter Bulan dan Tahun
- Dropdown untuk memilih bulan (Januari - Desember)
- Dropdown untuk memilih tahun (2020 - 2027)
- Tombol Filter untuk apply perubahan
- Tombol Reset untuk kembali ke periode saat ini

### 4. Statistik Summary
- Total peminjaman dalam periode
- Jumlah peminjaman yang disetujui
- Jumlah peminjaman yang menunggu persetujuan
- Jumlah peminjaman yang ditolak
- Persentase dari total untuk setiap status

### 5. Export PDF
- Tombol untuk mengunduh laporan dalam format PDF
- PDF berisi ringkasan statistik dan ranking
- Layout yang clean dan professional

### 6. Interface yang Menarik
- Menggunakan AdminLTE theme
- Card-based layout dengan shadow effects
- Ranking dengan badge berwarna (emas, perak, perunggu)
- Hover effects dan animasi
- Responsive design untuk mobile

## Cara Menggunakan

1. **Akses Dashboard**:
   ```
   http://localhost:8080/admin/dashboard
   ```

2. **Filter Data**:
   - Pilih bulan dari dropdown
   - Pilih tahun dari dropdown
   - Klik tombol "Filter Data"

3. **Export PDF**:
   - Setelah memilih filter yang diinginkan
   - Klik tombol "Export PDF"
   - File akan diunduh secara otomatis

4. **Reset Filter**:
   - Klik tombol "Reset" untuk kembali ke periode saat ini

## File yang Dibuat/Dimodifikasi

### Controller
- `app/Http/Controllers/Admin/DashboardController.php`
  - Method `index()` untuk menampilkan dashboard
  - Method `getRekapData()` untuk API endpoint
  - Method `exportPdf()` untuk export PDF
  - Helper methods untuk query data

### Views
- `resources/views/admin/dashboard.blade.php`
  - Layout dashboard dengan filter
  - Tabel ranking ruang dan bidang
  - Grafik Chart.js
  - Statistics cards

- `resources/views/admin/dashboard-pdf.blade.php`
  - Template untuk export PDF
  - Layout khusus untuk print

### Assets
- `public/css/dashboard-custom.css`
  - Custom styling untuk dashboard
  - Animasi dan hover effects
  - Responsive design

- `public/js/dashboard.js`
  - Interactive features
  - Auto-refresh functionality
  - Chart updates

### Routes
- `routes/web.php`
  - Route untuk dashboard
  - Route untuk API endpoint
  - Route untuk export PDF

## Dependencies Tambahan

1. **DomPDF** untuk export PDF:
   ```bash
   composer require barryvdh/laravel-dompdf
   ```

2. **Chart.js** untuk grafik (via CDN)

## Database Query Optimization

Dashboard menggunakan query yang dioptimasi:
- `GROUP BY` untuk menghitung jumlah peminjaman
- `WITH` untuk eager loading relasi
- `WHERE` clause untuk filter periode
- `LIMIT` untuk membatasi hasil top 10

## Performance

- Query dibatasi untuk top 10 hasil
- Grafik hanya menampilkan top 5
- CSS dan JS diminifikasi
- Responsive images untuk mobile

## Fitur Lanjutan (Opsional)

Beberapa fitur yang bisa ditambahkan:
1. Real-time updates dengan WebSocket
2. Export ke Excel/CSV
3. Notifikasi email untuk laporan berkala
4. Dashboard mobile app
5. Advanced analytics dengan machine learning
