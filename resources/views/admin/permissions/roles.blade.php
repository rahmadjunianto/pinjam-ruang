@extends('adminlte::page')

@section('title', 'Kelola Role')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-users-cog mr-2"></i>Kelola Role</h1>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        @foreach($roles as $roleKey => $role)
            <div class="col-md-4">
                <div class="card card-{{ $roleKey === 'admin' ? 'danger' : ($roleKey === 'user' ? 'success' : 'info') }}">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas {{ $roleKey === 'admin' ? 'fa-user-shield' : ($roleKey === 'user' ? 'fa-user' : 'fa-eye') }} mr-2"></i>
                            {{ $role['name'] }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{{ $role['description'] }}</p>

                        <h6><strong>Hak Akses:</strong></h6>
                        <ul class="list-unstyled">
                            @foreach($role['permissions'] as $permission)
                                <li class="mb-1">
                                    <i class="fas fa-check text-success mr-2"></i>{{ $permission }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            Role: <code>{{ $roleKey }}</code>
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Role Management Guidelines -->
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-exclamation-triangle mr-2"></i>Panduan Manajemen Role
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-info-circle text-info mr-2"></i>Penting untuk Diketahui:</h6>
                    <ul>
                        <li><strong>Administrator:</strong> Memiliki akses penuh ke semua fitur sistem. Gunakan dengan hati-hati.</li>
                        <li><strong>User Biasa:</strong> Role default untuk pegawai yang dapat melakukan peminjaman ruangan.</li>
                        <li><strong>Viewer:</strong> Untuk pengguna yang hanya perlu melihat data tanpa melakukan perubahan.</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-shield-alt text-success mr-2"></i>Best Practices:</h6>
                    <ul>
                        <li>Minimal gunakan role Administrator</li>
                        <li>Berikan role sesuai dengan kebutuhan kerja</li>
                        <li>Review secara berkala hak akses pengguna</li>
                        <li>Nonaktifkan akun yang tidak lagi digunakan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Matrix Permission Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-table mr-2"></i>Matrix Hak Akses
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fitur / Aksi</th>
                            <th class="text-center bg-danger text-white">Administrator</th>
                            <th class="text-center bg-success text-white">User Biasa</th>
                            <th class="text-center bg-info text-white">Viewer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fas fa-tachometer-alt mr-2"></i>Dashboard Analytics</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-users-cog mr-2"></i>Manajemen User</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-home mr-2"></i>Manajemen Ruangan</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-calendar-plus mr-2"></i>Buat Peminjaman</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-check-square mr-2"></i>Persetujuan Booking</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-calendar mr-2"></i>Lihat Kalender</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-chart-bar mr-2"></i>Laporan & Export</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-download mr-2"></i>Backup & Restore</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-user-circle mr-2"></i>Edit Profil Sendiri</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
