@extends('adminlte::page')

@section('title', 'Bantuan')

@section('content_header')
    <h1><i class="fas fa-question-circle mr-2"></i>Pusat Bantuan</h1>
@endsection

@section('content')
    <!-- Navigation Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <i class="fas fa-user fa-4x text-primary mb-3"></i>
                        <h5 class="card-title">Panduan Pengguna</h5>
                        <p class="text-muted">Panduan lengkap untuk menggunakan sistem peminjaman ruangan</p>
                        <a href="{{ route('admin.help.user-guide') }}" class="btn btn-primary">
                            <i class="fas fa-book mr-1"></i>Buka Panduan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-success card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <i class="fas fa-user-shield fa-4x text-success mb-3"></i>
                        <h5 class="card-title">Panduan Administrator</h5>
                        <p class="text-muted">Panduan manajemen sistem untuk administrator</p>
                        <a href="{{ route('admin.help.admin-guide') }}" class="btn btn-success">
                            <i class="fas fa-cogs mr-1"></i>Buka Panduan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-info card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <i class="fas fa-question fa-4x text-info mb-3"></i>
                        <h5 class="card-title">FAQ</h5>
                        <p class="text-muted">Pertanyaan yang sering diajukan dan jawabannya</p>
                        <a href="{{ route('admin.help.faq') }}" class="btn btn-info">
                            <i class="fas fa-comments mr-1"></i>Lihat FAQ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Help Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-rocket mr-2"></i>Memulai Cepat
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="time-label">
                            <span class="bg-green">Langkah Awal</span>
                        </div>
                        <div>
                            <i class="fas fa-user bg-blue"></i>
                            <div class="timeline-item">
                                <h5 class="timeline-header">1. Login dengan NIP</h5>
                                <div class="timeline-body">
                                    Gunakan NIP (18 digit) dan password untuk masuk ke sistem
                                </div>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-calendar bg-green"></i>
                            <div class="timeline-item">
                                <h5 class="timeline-header">2. Pilih Ruangan</h5>
                                <div class="timeline-body">
                                    Lihat daftar ruangan yang tersedia dan jadwal peminjaman
                                </div>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-check bg-orange"></i>
                            <div class="timeline-item">
                                <h5 class="timeline-header">3. Buat Peminjaman</h5>
                                <div class="timeline-body">
                                    Isi form peminjaman dan tunggu persetujuan admin
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-phone mr-2"></i>Hubungi Kami
                    </h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.help.contact') }}" class="btn btn-outline-primary btn-block mb-2">
                        <i class="fas fa-address-book mr-2"></i>Informasi Kontak
                    </a>
                    <a href="{{ route('admin.help.system') }}" class="btn btn-outline-info btn-block mb-2">
                        <i class="fas fa-server mr-2"></i>Info Sistem
                    </a>
                    
                    <div class="mt-3">
                        <h6><i class="fas fa-clock mr-2"></i>Jam Operasional:</h6>
                        <ul class="list-unstyled">
                            <li><strong>Senin - Kamis:</strong> 08:00 - 16:00</li>
                            <li><strong>Jumat:</strong> 08:00 - 11:30, 13:00 - 16:00</li>
                            <li><strong>Sabtu - Minggu:</strong> Tutup</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Common Issues -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-exclamation-triangle mr-2"></i>Masalah Umum & Solusi
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="callout callout-warning">
                        <h6><i class="fas fa-lock mr-2"></i>Tidak Bisa Login</h6>
                        <ul class="mb-0">
                            <li>Pastikan NIP benar (18 digit)</li>
                            <li>Cek caps lock pada keyboard</li>
                            <li>Hubungi admin jika lupa password</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="callout callout-info">
                        <h6><i class="fas fa-calendar-times mr-2"></i>Ruangan Tidak Tersedia</h6>
                        <ul class="mb-0">
                            <li>Cek jadwal di kalender</li>
                            <li>Pilih waktu yang berbeda</li>
                            <li>Cari ruangan alternatif</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="callout callout-danger">
                        <h6><i class="fas fa-times mr-2"></i>Peminjaman Ditolak</h6>
                        <ul class="mb-0">
                            <li>Baca alasan penolakan</li>
                            <li>Perbaiki data yang salah</li>
                            <li>Ajukan peminjaman ulang</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="callout callout-success">
                        <h6><i class="fas fa-bell mr-2"></i>Tidak Ada Notifikasi</h6>
                        <ul class="mb-0">
                            <li>Cek pengaturan browser</li>
                            <li>Refresh halaman</li>
                            <li>Periksa status peminjaman manual</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Tutorial Section -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-play-circle mr-2"></i>Video Tutorial
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-body text-center">
                            <i class="fas fa-video fa-3x text-primary mb-3"></i>
                            <h6>Cara Login dan Navigasi</h6>
                            <p class="text-muted">Tutorial dasar menggunakan sistem</p>
                            <button class="btn btn-primary btn-sm" disabled>
                                <i class="fas fa-play mr-1"></i>Segera Hadir
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-outline card-success">
                        <div class="card-body text-center">
                            <i class="fas fa-video fa-3x text-success mb-3"></i>
                            <h6>Membuat Peminjaman</h6>
                            <p class="text-muted">Langkah-langkah meminjam ruangan</p>
                            <button class="btn btn-success btn-sm" disabled>
                                <i class="fas fa-play mr-1"></i>Segera Hadir
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-outline card-info">
                        <div class="card-body text-center">
                            <i class="fas fa-video fa-3x text-info mb-3"></i>
                            <h6>Manajemen untuk Admin</h6>
                            <p class="text-muted">Panduan lengkap untuk administrator</p>
                            <button class="btn btn-info btn-sm" disabled>
                                <i class="fas fa-play mr-1"></i>Segera Hadir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
