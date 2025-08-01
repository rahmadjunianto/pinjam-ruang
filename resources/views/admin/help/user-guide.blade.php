@extends('adminlte::page')

@section('title', 'Panduan Pengguna')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user mr-2"></i>Panduan Pengguna</h1>
        <a href="{{ route('admin.help.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
    </div>
@endsection

@section('css')
<style>
.guide-nav .nav-link {
    border-radius: 0;
    margin-bottom: 2px;
    color: #495057;
    position: relative;
    z-index: 1;
    pointer-events: auto !important;
}

.guide-nav .nav-link:hover {
    background-color: #e9ecef;
    color: #007bff;
}

.guide-nav .nav-link.active {
    background-color: #007bff;
    color: white;
}

.sticky-top {
    position: sticky !important;
    z-index: 100;
}

/* Ensure sidebar doesn't get blocked */
.main-sidebar {
    z-index: 1040 !important;
    pointer-events: auto !important;
}

.main-sidebar * {
    pointer-events: auto !important;
}

.content-wrapper {
    position: relative;
    z-index: 1;
}

/* Fix overlay issues */
.main-sidebar .nav-link {
    pointer-events: auto !important;
    z-index: inherit !important;
}

.guide-nav {
    position: relative;
    z-index: 1;
}
</style>
@endsection

@section('content')
    <div class="row">
        <!-- Table of Contents -->
        <div class="col-md-3">
            <div class="card card-primary card-outline sticky-top" style="top: 20px;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>Daftar Isi
                    </h3>
                </div>
                <div class="card-body p-0">
                    <nav class="nav nav-pills flex-column guide-nav">
                        <a class="nav-link guide-nav-link" href="#getting-started">Memulai</a>
                        <a class="nav-link guide-nav-link" href="#login">Login ke Sistem</a>
                        <a class="nav-link guide-nav-link" href="#dashboard">Dashboard</a>
                        <a class="nav-link guide-nav-link" href="#booking">Membuat Peminjaman</a>
                        <a class="nav-link guide-nav-link" href="#calendar">Melihat Kalender</a>
                        <a class="nav-link guide-nav-link" href="#profile">Mengelola Profil</a>
                        <a class="nav-link guide-nav-link" href="#notifications">Notifikasi</a>
                        <a class="nav-link guide-nav-link" href="#troubleshooting">Pemecahan Masalah</a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-md-9">
            <!-- Getting Started -->
            <div class="card" id="getting-started">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-rocket mr-2"></i>Memulai
                    </h3>
                </div>
                <div class="card-body">
                    <p>Selamat datang di Sistem Peminjaman Ruangan Kementerian Agama. Sistem ini memungkinkan Anda untuk:</p>
                    <ul>
                        <li>Melihat ketersediaan ruangan secara real-time</li>
                        <li>Mengajukan peminjaman ruangan dengan mudah</li>
                        <li>Memantau status peminjaman Anda</li>
                        <li>Mengelola profil dan data pribadi</li>
                    </ul>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle mr-2"></i>Persyaratan Sistem:</h6>
                        <ul class="mb-0">
                            <li>Browser modern (Chrome, Firefox, Safari, Edge)</li>
                            <li>Koneksi internet yang stabil</li>
                            <li>NIP (Nomor Induk Pegawai) yang valid</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Login -->
            <div class="card" id="login">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login ke Sistem
                    </h3>
                </div>
                <div class="card-body">
                    <h5>Langkah-langkah Login:</h5>
                    <ol>
                        <li>Buka halaman login sistem</li>
                        <li>Masukkan NIP Anda (18 digit)</li>
                        <li>Masukkan password yang telah diberikan admin</li>
                        <li>Klik tombol "Masuk"</li>
                    </ol>

                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle mr-2"></i>Catatan Penting:</h6>
                        <ul class="mb-0">
                            <li>NIP harus 18 digit angka</li>
                            <li>Password bersifat case-sensitive</li>
                            <li>Jika lupa password, hubungi administrator</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ asset('images/login-example.png') }}" alt="Login Example" class="img-fluid rounded border" 
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkNvbnRvaCBMb2dpbjwvdGV4dD48L3N2Zz4='">
                        </div>
                        <div class="col-md-6">
                            <div class="callout callout-success">
                                <h6>Tips Login:</h6>
                                <ul class="mb-0">
                                    <li>Simpan password dengan aman</li>
                                    <li>Logout setelah selesai menggunakan</li>
                                    <li>Jangan share akun dengan orang lain</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard -->
            <div class="card" id="dashboard">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </h3>
                </div>
                <div class="card-body">
                    <p>Setelah login, Anda akan melihat dashboard yang menampilkan:</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-chart-bar mr-2"></i>Statistik:</h6>
                            <ul>
                                <li>Total peminjaman Anda</li>
                                <li>Peminjaman yang sedang aktif</li>
                                <li>Ruangan yang sering dipinjam</li>
                                <li>Grafik penggunaan bulanan</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-list mr-2"></i>Informasi Terbaru:</h6>
                            <ul>
                                <li>Peminjaman mendatang</li>
                                <li>Status persetujuan</li>
                                <li>Notifikasi sistem</li>
                                <li>Pengumuman penting</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking -->
            <div class="card" id="booking">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-plus mr-2"></i>Membuat Peminjaman
                    </h3>
                </div>
                <div class="card-body">
                    <h5>Langkah-langkah Membuat Peminjaman:</h5>
                    <ol>
                        <li><strong>Pilih Menu Peminjaman</strong> - Klik menu "Peminjaman" di sidebar</li>
                        <li><strong>Klik "Buat Peminjaman Baru"</strong> - Tombol hijau di pojok kanan atas</li>
                        <li><strong>Isi Form Peminjaman:</strong>
                            <ul>
                                <li>Pilih ruangan yang diinginkan</li>
                                <li>Tentukan tanggal peminjaman</li>
                                <li>Pilih waktu mulai dan selesai</li>
                                <li>Isi tujuan/keperluan peminjaman</li>
                                <li>Masukkan jumlah peserta (jika diperlukan)</li>
                            </ul>
                        </li>
                        <li><strong>Verifikasi Data</strong> - Pastikan semua informasi benar</li>
                        <li><strong>Submit Peminjaman</strong> - Klik tombol "Ajukan Peminjaman"</li>
                    </ol>

                    <div class="alert alert-info">
                        <h6><i class="fas fa-clock mr-2"></i>Status Peminjaman:</h6>
                        <ul class="mb-0">
                            <li><span class="badge badge-warning">Pending</span> - Menunggu persetujuan admin</li>
                            <li><span class="badge badge-success">Approved</span> - Peminjaman disetujui</li>
                            <li><span class="badge badge-danger">Rejected</span> - Peminjaman ditolak</li>
                            <li><span class="badge badge-secondary">Completed</span> - Peminjaman selesai</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Calendar -->
            <div class="card" id="calendar">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar mr-2"></i>Melihat Kalender
                    </h3>
                </div>
                <div class="card-body">
                    <p>Fitur kalender memungkinkan Anda melihat jadwal peminjaman ruangan secara visual.</p>
                    
                    <h6><i class="fas fa-eye mr-2"></i>Cara Menggunakan Kalender:</h6>
                    <ul>
                        <li>Klik menu "Kalender" untuk membuka tampilan kalender</li>
                        <li>Gunakan tombol navigasi untuk berpindah bulan</li>
                        <li>Klik pada tanggal untuk melihat detail peminjaman</li>
                        <li>Filter berdasarkan ruangan atau status</li>
                    </ul>

                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-palette mr-2"></i>Kode Warna:</h6>
                            <ul>
                                <li><span class="badge badge-success">Hijau</span> - Peminjaman disetujui</li>
                                <li><span class="badge badge-warning">Kuning</span> - Menunggu persetujuan</li>
                                <li><span class="badge badge-danger">Merah</span> - Peminjaman ditolak</li>
                                <li><span class="badge badge-info">Biru</span> - Peminjaman Anda</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-mouse mr-2"></i>Interaksi:</h6>
                            <ul>
                                <li>Hover untuk melihat detail cepat</li>
                                <li>Klik untuk detail lengkap</li>
                                <li>Drag & drop untuk mengubah jadwal (admin)</li>
                                <li>Double-click untuk membuat peminjaman baru</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile -->
            <div class="card" id="profile">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-circle mr-2"></i>Mengelola Profil
                    </h3>
                </div>
                <div class="card-body">
                    <h6><i class="fas fa-edit mr-2"></i>Mengubah Profil:</h6>
                    <ol>
                        <li>Klik nama Anda di pojok kanan atas</li>
                        <li>Pilih "Profil" dari dropdown menu</li>
                        <li>Edit informasi yang dapat diubah</li>
                        <li>Klik "Simpan Perubahan"</li>
                    </ol>

                    <div class="alert alert-warning">
                        <h6><i class="fas fa-lock mr-2"></i>Informasi yang Dapat Diubah:</h6>
                        <ul class="mb-0">
                            <li>Password (masukkan password lama)</li>
                            <li>Nomor telepon</li>
                            <li>Email (jika ada)</li>
                            <li>Foto profil</li>
                        </ul>
                        <p class="mb-0 mt-2"><strong>Catatan:</strong> NIP dan nama tidak dapat diubah. Hubungi admin jika ada kesalahan data.</p>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="card" id="notifications">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bell mr-2"></i>Notifikasi
                    </h3>
                </div>
                <div class="card-body">
                    <p>Sistem akan mengirimkan notifikasi untuk berbagai aktivitas:</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-check-circle text-success mr-2"></i>Notifikasi Positif:</h6>
                            <ul>
                                <li>Peminjaman disetujui</li>
                                <li>Reminder sebelum acara</li>
                                <li>Konfirmasi perubahan data</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-exclamation-circle text-warning mr-2"></i>Notifikasi Penting:</h6>
                            <ul>
                                <li>Peminjaman ditolak</li>
                                <li>Perubahan jadwal</li>
                                <li>Pembatalan peminjaman</li>
                            </ul>
                        </div>
                    </div>

                    <div class="callout callout-info">
                        <h6>Tips Notifikasi:</h6>
                        <ul class="mb-0">
                            <li>Periksa notifikasi secara berkala</li>
                            <li>Aktifkan notifikasi browser jika diminta</li>
                            <li>Baca detail notifikasi dengan teliti</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Troubleshooting -->
            <div class="card" id="troubleshooting">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tools mr-2"></i>Pemecahan Masalah
                    </h3>
                </div>
                <div class="card-body">
                    <div class="accordion" id="troubleshootingAccordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h6 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne">
                                        <i class="fas fa-question-circle mr-2"></i>Tidak bisa login
                                    </button>
                                </h6>
                            </div>
                            <div id="collapseOne" class="collapse show" data-parent="#troubleshootingAccordion">
                                <div class="card-body">
                                    <ul>
                                        <li>Pastikan NIP yang dimasukkan benar (18 digit)</li>
                                        <li>Periksa caps lock pada keyboard</li>
                                        <li>Clear cache dan cookies browser</li>
                                        <li>Coba gunakan browser lain</li>
                                        <li>Hubungi admin jika masih bermasalah</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h6 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo">
                                        <i class="fas fa-question-circle mr-2"></i>Halaman loading terus
                                    </button>
                                </h6>
                            </div>
                            <div id="collapseTwo" class="collapse" data-parent="#troubleshootingAccordion">
                                <div class="card-body">
                                    <ul>
                                        <li>Periksa koneksi internet</li>
                                        <li>Refresh halaman (F5 atau Ctrl+R)</li>
                                        <li>Clear cache browser</li>
                                        <li>Disable ekstensi browser sementara</li>
                                        <li>Restart browser</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h6 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree">
                                        <i class="fas fa-question-circle mr-2"></i>Form tidak bisa disubmit
                                    </button>
                                </h6>
                            </div>
                            <div id="collapseThree" class="collapse" data-parent="#troubleshootingAccordion">
                                <div class="card-body">
                                    <ul>
                                        <li>Pastikan semua field wajib terisi</li>
                                        <li>Periksa format data (tanggal, waktu, dll)</li>
                                        <li>Pastikan tidak ada konflik jadwal</li>
                                        <li>Coba submit ulang setelah beberapa detik</li>
                                        <li>Screenshot error dan laporkan ke admin</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <h6><i class="fas fa-phone mr-2"></i>Butuh Bantuan Lebih Lanjut?</h6>
                        <p class="mb-0">Jika masalah Anda tidak terpecahkan, silakan hubungi administrator sistem melalui halaman <a href="{{ route('admin.help.contact') }}">Kontak</a>.</p>
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
    // Handle guide navigation clicks with more specific selector
    $('.guide-nav-link').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const target = $(this).attr('href');
        if ($(target).length) {
            $('html, body').animate({
                scrollTop: $(target).offset().top - 100
            }, 500);
            
            // Update active state
            $('.guide-nav-link').removeClass('active');
            $(this).addClass('active');
        }
    });

    // Update active state on scroll
    $(window).on('scroll', function() {
        const scrollTop = $(window).scrollTop();
        $('.card[id]').each(function() {
            const id = $(this).attr('id');
            const offset = $(this).offset().top - 150;
            const height = $(this).outerHeight();
            
            if (scrollTop >= offset && scrollTop < (offset + height)) {
                $('.guide-nav-link').removeClass('active');
                $(`.guide-nav-link[href="#${id}"]`).addClass('active');
            }
        });
    });
    
    // Ensure sidebar functionality is preserved
    $(document).on('click', '.main-sidebar a', function(e) {
        // Allow sidebar links to work normally
        e.stopPropagation();
    });
    
    // Prevent event bubbling for guide navigation only
    $('.guide-nav').on('click', function(e) {
        e.stopPropagation();
    });
});
</script>
@endsection
