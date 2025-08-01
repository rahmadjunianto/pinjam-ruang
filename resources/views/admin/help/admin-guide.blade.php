@extends('adminlte::page')

@section('title', 'Panduan Administrator')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user-shield mr-2"></i>Panduan Administrator</h1>
        <a href="{{ route('admin.help.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- Table of Contents -->
        <div class="col-md-3">
            <div class="card card-success card-outline sticky-top">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>Daftar Isi
                    </h3>
                </div>
                <div class="card-body p-0">
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link" href="#overview">Gambaran Umum</a>
                        <a class="nav-link" href="#user-management">Manajemen User</a>
                        <a class="nav-link" href="#room-management">Manajemen Ruangan</a>
                        <a class="nav-link" href="#booking-approval">Persetujuan Peminjaman</a>
                        <a class="nav-link" href="#reports">Laporan & Analytics</a>
                        <a class="nav-link" href="#permissions">Hak Akses</a>
                        <a class="nav-link" href="#backup">Backup & Restore</a>
                        <a class="nav-link" href="#security">Keamanan Sistem</a>
                        <a class="nav-link" href="#maintenance">Maintenance</a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-md-9">
            <!-- Overview -->
            <div class="card" id="overview">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye mr-2"></i>Gambaran Umum
                    </h3>
                </div>
                <div class="card-body">
                    <p>Sebagai administrator sistem, Anda memiliki akses penuh untuk mengelola:</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-users text-primary mr-2"></i>Manajemen Pengguna:</h6>
                            <ul>
                                <li>Tambah, edit, hapus user</li>
                                <li>Reset password user</li>
                                <li>Mengatur hak akses</li>
                                <li>Monitoring aktivitas user</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-home text-success mr-2"></i>Manajemen Ruangan:</h6>
                            <ul>
                                <li>Tambah, edit, hapus ruangan</li>
                                <li>Mengatur kategori ruangan</li>
                                <li>Setting kapasitas dan fasilitas</li>
                                <li>Maintenance jadwal ruangan</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle mr-2"></i>Tanggung Jawab Administrator:</h6>
                        <ul class="mb-0">
                            <li><strong>Keamanan:</strong> Jaga kerahasiaan data dan akses sistem</li>
                            <li><strong>Backup:</strong> Lakukan backup data secara rutin</li>
                            <li><strong>Monitoring:</strong> Pantau aktivitas sistem dan user</li>
                            <li><strong>Support:</strong> Berikan bantuan kepada user yang bermasalah</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- User Management -->
            <div class="card" id="user-management">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-2"></i>Manajemen User
                    </h3>
                </div>
                <div class="card-body">
                    <h5>Menambah User Baru:</h5>
                    <ol>
                        <li>Buka menu "Manajemen User"</li>
                        <li>Klik tombol "Tambah User Baru"</li>
                        <li>Isi form dengan data lengkap:
                            <ul>
                                <li>NIP (18 digit, unik)</li>
                                <li>Nama lengkap</li>
                                <li>Password default</li>
                                <li>Bidang/Unit kerja</li>
                                <li>Role (Admin/User/Viewer)</li>
                            </ul>
                        </li>
                        <li>Klik "Simpan" untuk menyimpan user</li>
                    </ol>

                    <h5>Mengelola User Existing:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-edit text-warning mr-2"></i>Edit User:</h6>
                            <ul>
                                <li>Klik tombol edit (pensil kuning)</li>
                                <li>Update data yang diperlukan</li>
                                <li>Simpan perubahan</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-key text-info mr-2"></i>Reset Password:</h6>
                            <ul>
                                <li>Klik tombol "Reset Password"</li>
                                <li>Password akan direset ke default</li>
                                <li>Informasikan password baru ke user</li>
                            </ul>
                        </div>
                    </div>

                    <div class="callout callout-danger">
                        <h6>Peringatan:</h6>
                        <ul class="mb-0">
                            <li>Jangan hapus user yang masih memiliki peminjaman aktif</li>
                            <li>Backup data sebelum menghapus user</li>
                            <li>Informasikan perubahan password kepada user terkait</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Room Management -->
            <div class="card" id="room-management">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-home mr-2"></i>Manajemen Ruangan
                    </h3>
                </div>
                <div class="card-body">
                    <h5>Menambah Ruangan Baru:</h5>
                    <ol>
                        <li>Buka menu "Manajemen Ruangan"</li>
                        <li>Klik "Tambah Ruangan Baru"</li>
                        <li>Isi informasi ruangan:
                            <ul>
                                <li>Nama ruangan</li>
                                <li>Kategori (Meeting Room, Auditorium, dll)</li>
                                <li>Kapasitas maksimal</li>
                                <li>Fasilitas yang tersedia</li>
                                <li>Lokasi/Lantai</li>
                                <li>Status ketersediaan</li>
                            </ul>
                        </li>
                        <li>Upload foto ruangan (opsional)</li>
                        <li>Set aturan peminjaman khusus</li>
                    </ol>

                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-cogs text-primary mr-2"></i>Pengaturan Ruangan:</h6>
                            <ul>
                                <li>Jam operasional</li>
                                <li>Durasi minimum/maksimum peminjaman</li>
                                <li>Advance booking limit</li>
                                <li>Approval requirement</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-tools text-warning mr-2"></i>Maintenance Ruangan:</h6>
                            <ul>
                                <li>Set status maintenance</li>
                                <li>Block tanggal tertentu</li>
                                <li>Update fasilitas</li>
                                <li>Ganti foto ruangan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Approval -->
            <div class="card" id="booking-approval">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-check-square mr-2"></i>Persetujuan Peminjaman
                    </h3>
                </div>
                <div class="card-body">
                    <h5>Proses Approval:</h5>
                    <ol>
                        <li>Buka menu "Peminjaman" → "Pending Approval"</li>
                        <li>Review detail peminjaman:
                            <ul>
                                <li>Nama peminjam dan bidang</li>
                                <li>Ruangan dan waktu</li>
                                <li>Tujuan peminjaman</li>
                                <li>Jumlah peserta</li>
                            </ul>
                        </li>
                        <li>Cek ketersediaan ruangan</li>
                        <li>Pilih action: Approve atau Reject</li>
                        <li>Berikan catatan jika diperlukan</li>
                    </ol>

                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle mr-2"></i>Kriteria Approval:</h6>
                        <ul class="mb-0">
                            <li>Ruangan tersedia pada waktu yang diminta</li>
                            <li>Tujuan peminjaman sesuai dengan fungsi ruangan</li>
                            <li>Jumlah peserta tidak melebihi kapasitas</li>
                            <li>Tidak ada konflik dengan acara penting lainnya</li>
                        </ul>
                    </div>

                    <h6><i class="fas fa-clock mr-2"></i>Bulk Actions:</h6>
                    <ul>
                        <li>Select multiple bookings</li>
                        <li>Approve/reject secara bersamaan</li>
                        <li>Export data untuk pelaporan</li>
                    </ul>
                </div>
            </div>

            <!-- Reports -->
            <div class="card" id="reports">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-2"></i>Laporan & Analytics
                    </h3>
                </div>
                <div class="card-body">
                    <h5>Dashboard Analytics:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-chart-line text-primary mr-2"></i>Statistik Penggunaan:</h6>
                            <ul>
                                <li>Total peminjaman per periode</li>
                                <li>Ruangan yang paling sering digunakan</li>
                                <li>Peak hours penggunaan</li>
                                <li>Tren penggunaan bulanan/tahunan</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-users text-success mr-2"></i>Statistik User:</h6>
                            <ul>
                                <li>User paling aktif</li>
                                <li>Bidang dengan peminjaman terbanyak</li>
                                <li>Approval rate</li>
                                <li>Cancellation rate</li>
                            </ul>
                        </div>
                    </div>

                    <h5>Generate Reports:</h5>
                    <ol>
                        <li>Pilih jenis laporan yang diinginkan</li>
                        <li>Set periode pelaporan</li>
                        <li>Pilih filter (ruangan, user, bidang)</li>
                        <li>Export ke format PDF/Excel</li>
                    </ol>

                    <div class="callout callout-success">
                        <h6>Tips Pelaporan:</h6>
                        <ul class="mb-0">
                            <li>Buat laporan rutin untuk evaluasi</li>
                            <li>Gunakan filter untuk analisis spesifik</li>
                            <li>Share insights dengan manajemen</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="card" id="permissions">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shield-alt mr-2"></i>Hak Akses
                    </h3>
                </div>
                <div class="card-body">
                    <h5>Role Management:</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Deskripsi</th>
                                    <th>Hak Akses</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge badge-danger">Administrator</span></td>
                                    <td>Akses penuh sistem</td>
                                    <td>Semua fitur + manajemen sistem</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-success">User</span></td>
                                    <td>Pengguna reguler</td>
                                    <td>Booking, lihat kalender, edit profil</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-info">Viewer</span></td>
                                    <td>Read-only access</td>
                                    <td>Lihat data, tidak bisa edit/tambah</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h6><i class="fas fa-user-cog mr-2"></i>Mengubah Role User:</h6>
                    <ol>
                        <li>Buka menu "Hak Akses"</li>
                        <li>Cari user yang akan diubah</li>
                        <li>Select role baru dari dropdown</li>
                        <li>Konfirmasi perubahan</li>
                    </ol>

                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle mr-2"></i>Best Practices:</h6>
                        <ul class="mb-0">
                            <li>Berikan role minimal yang diperlukan</li>
                            <li>Review hak akses secara berkala</li>
                            <li>Dokumentasi pemberian akses admin</li>
                            <li>Revoke akses user yang sudah tidak aktif</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Backup -->
            <div class="card" id="backup">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-download mr-2"></i>Backup & Restore
                    </h3>
                </div>
                <div class="card-body">
                    <h5>Jenis Backup:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-database text-success mr-2"></i>Database Backup:</h6>
                            <ul>
                                <li>Data tabel sistem</li>
                                <li>User dan peminjaman</li>
                                <li>File size relatif kecil</li>
                                <li>Untuk backup rutin</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-file-archive text-warning mr-2"></i>Full Backup:</h6>
                            <ul>
                                <li>Database + file sistem</li>
                                <li>Foto, dokumen, config</li>
                                <li>File size besar</li>
                                <li>Untuk disaster recovery</li>
                            </ul>
                        </div>
                    </div>

                    <h5>Jadwal Backup Recommended:</h5>
                    <ul>
                        <li><strong>Harian:</strong> Database backup (automated)</li>
                        <li><strong>Mingguan:</strong> Full backup</li>
                        <li><strong>Bulanan:</strong> Archive backup untuk long-term storage</li>
                        <li><strong>Sebelum Update:</strong> Full backup sebagai safeguard</li>
                    </ul>

                    <div class="callout callout-danger">
                        <h6>Backup Security:</h6>
                        <ul class="mb-0">
                            <li>Simpan backup di lokasi terpisah</li>
                            <li>Encrypt backup yang sensitif</li>
                            <li>Test restore procedure secara berkala</li>
                            <li>Dokumentasi lokasi dan akses backup</li>
                        </ul>
                    </div>

                    <h6><i class="fas fa-undo mr-2"></i>Restore Process:</h6>
                    <p><strong>Catatan:</strong> Proses restore harus dilakukan secara manual melalui command line atau phpMyAdmin. Hubungi technical support jika diperlukan.</p>
                </div>
            </div>

            <!-- Security -->
            <div class="card" id="security">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-lock mr-2"></i>Keamanan Sistem
                    </h3>
                </div>
                <div class="card-body">
                    <h5>Monitoring Keamanan:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-eye text-info mr-2"></i>Yang Perlu Dimonitor:</h6>
                            <ul>
                                <li>Login attempts yang gagal</li>
                                <li>Aktivitas user yang mencurigakan</li>
                                <li>Access ke data sensitif</li>
                                <li>Perubahan konfigurasi sistem</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-shield-alt text-success mr-2"></i>Security Measures:</h6>
                            <ul>
                                <li>Password policy yang kuat</li>
                                <li>Session timeout</li>
                                <li>Data encryption</li>
                                <li>Regular security updates</li>
                            </ul>
                        </div>
                    </div>

                    <h5>Password Management:</h5>
                    <ul>
                        <li>Enforce password complexity</li>
                        <li>Regular password expiry</li>
                        <li>Prevent password reuse</li>
                        <li>Secure password reset process</li>
                    </ul>

                    <div class="alert alert-danger">
                        <h6><i class="fas fa-exclamation-triangle mr-2"></i>Incident Response:</h6>
                        <p class="mb-0">Jika ada indikasi security breach:</p>
                        <ol class="mb-0">
                            <li>Segera blokir akses yang mencurigakan</li>
                            <li>Change password admin accounts</li>
                            <li>Backup data penting</li>
                            <li>Investigate dan dokumentasi incident</li>
                            <li>Report ke management</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Maintenance -->
            <div class="card" id="maintenance">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tools mr-2"></i>Maintenance
                    </h3>
                </div>
                <div class="card-body">
                    <h5>Maintenance Rutin:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-calendar text-primary mr-2"></i>Harian:</h6>
                            <ul>
                                <li>Check system status</li>
                                <li>Review error logs</li>
                                <li>Monitor disk space</li>
                                <li>Verify backup completion</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-calendar-week text-success mr-2"></i>Mingguan:</h6>
                            <ul>
                                <li>Clean up old logs</li>
                                <li>Update system patches</li>
                                <li>Review user access</li>
                                <li>Performance monitoring</li>
                            </ul>
                        </div>
                    </div>

                    <h6><i class="fas fa-calendar-alt text-warning mr-2"></i>Bulanan:</h6>
                    <ul>
                        <li>Comprehensive system review</li>
                        <li>Archive old data</li>
                        <li>Security audit</li>
                        <li>User training needs assessment</li>
                    </ul>

                    <div class="callout callout-info">
                        <h6>Performance Optimization:</h6>
                        <ul class="mb-0">
                            <li>Database query optimization</li>
                            <li>Cache configuration</li>
                            <li>Image compression</li>
                            <li>CDN setup for static files</li>
                        </ul>
                    </div>

                    <h5>Troubleshooting Common Issues:</h5>
                    <div class="accordion" id="maintenanceAccordion">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#maintenance1">
                                        <i class="fas fa-database mr-2"></i>Database Connection Issues
                                    </button>
                                </h6>
                            </div>
                            <div id="maintenance1" class="collapse" data-parent="#maintenanceAccordion">
                                <div class="card-body">
                                    <ul>
                                        <li>Check database server status</li>
                                        <li>Verify connection credentials</li>
                                        <li>Check network connectivity</li>
                                        <li>Review database logs</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#maintenance2">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Slow Performance
                                    </button>
                                </h6>
                            </div>
                            <div id="maintenance2" class="collapse" data-parent="#maintenanceAccordion">
                                <div class="card-body">
                                    <ul>
                                        <li>Check server resources (CPU, Memory)</li>
                                        <li>Optimize database queries</li>
                                        <li>Clear application cache</li>
                                        <li>Review concurrent user load</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
// Smooth scrolling for navigation links
$(document).ready(function() {
    $('.nav-link').on('click', function(e) {
        e.preventDefault();
        const target = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(target).offset().top - 100
        }, 500);
        
        // Update active state
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });

    // Update active state on scroll
    $(window).on('scroll', function() {
        const scrollTop = $(window).scrollTop();
        $('.card[id]').each(function() {
            const id = $(this).attr('id');
            const offset = $(this).offset().top - 150;
            const height = $(this).outerHeight();
            
            if (scrollTop >= offset && scrollTop < (offset + height)) {
                $('.nav-link').removeClass('active');
                $(`.nav-link[href="#${id}"]`).addClass('active');
            }
        });
    });
});
</script>
@endsection
